<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Gedcom;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Registry;

use function array_key_exists;
use function count;
use function in_array;
use function preg_match;
use function preg_split;
use function strtolower;
use function trim;

/**
 * Godparents, witnesses, and other people linked to extended-family records.
 */
class Godparents_witnesses extends ExtendedFamilyPart
{
    public const GROUP_LINKED_PERSONS = 'Godparents, witnesses, and other linked persons';

    private const PROPRIETARY_NAME_TAGS = [
        '_GODP',
        '_WITN',
        '_WITNESS',
        '_SPON',
        '_SPONSOR',
    ];
    private const MULTIPLE_BIRTH_ROLES = [
        'twin',
        'triplet',
        'quadruplet',
        'quintuplet',
        'sextuplet',
        'septuplet',
        'octuplet',
        'nonuplet',
        'decuplet',
    ];

    private ExtendedFamilyPartSet $seedFamilyParts;

    public function __construct(
        Individual $proband,
        string $filterOption,
        int $placeFormat = PlaceAbbreviation::OPTION_FULL_PLACE_NAME,
        ?ExtendedFamilyPartSet $seedFamilyParts = null
    ) {
        $this->seedFamilyParts = $seedFamilyParts ?? new ExtendedFamilyPartSet();

        parent::__construct($proband, $filterOption, $placeFormat);
    }

    protected function addEfpMembers(): void
    {
        $group = new FamilyPartGroup(self::GROUP_LINKED_PERSONS);
        $seen = [];

        foreach ($this->seedRecords() as $record) {
            foreach ($this->associatedEntries($record) as $entry) {
                $signature = $this->entrySignature($entry);
                if (!array_key_exists($signature, $seen)) {
                    $group->entries[] = $entry;
                    $seen[$signature] = true;
                }
            }
        }

        if (count($group->entries) > 0) {
            $this->efpObject->groups[self::GROUP_LINKED_PERSONS] = $group;
        }
    }

    protected function filterAndAddCounters($filterOption): void
    {
        if ($filterOption !== 'all') {
            $this->filterAssociatedEntries(ExtendedFamilySupport::convertfilterOptions($filterOption));
        }

        $this->addCountersAssociatedEntries();
    }

    /**
     * @return array<int,Individual|Family>
     */
    private function seedRecords(): array
    {
        $individuals = [$this->getProband()->xref() => $this->getProband()];
        $candidateFamilies = [];

        foreach ($this->seedFamilyParts as $propName => $familyPart) {
            if ($propName === 'summary') {
                continue;
            }

            if ($propName === 'partner_chains') {
                foreach ($familyPart->collectionIndividuals ?? [] as $individual) {
                    if ($individual instanceof Individual) {
                        $individuals[$individual->xref()] = $individual;
                    }
                }

                foreach ($familyPart->collectionFamilies ?? [] as $family) {
                    if ($family instanceof Family) {
                        $candidateFamilies[$family->xref()] = $family;
                    }
                }

                continue;
            }

            foreach ($familyPart->groups ?? [] as $group) {
                if (($group->family ?? null) instanceof Family) {
                    $candidateFamilies[$group->family->xref()] = $group->family;
                }

                foreach ($group->entries ?? [] as $entry) {
                    if (($entry->individual ?? null) instanceof Individual) {
                        $individuals[$entry->individual->xref()] = $entry->individual;
                    }

                    if (($entry->family ?? null) instanceof Family) {
                        $candidateFamilies[$entry->family->xref()] = $entry->family;
                    }
                }
            }
        }

        $families = [];
        foreach ($candidateFamilies as $family) {
            if ($this->familyHasSeedSpouse($family, $individuals)) {
                $families[$family->xref()] = $family;
            }
        }

        return [...array_values($individuals), ...array_values($families)];
    }

    /**
     * @param array<string,Individual> $individuals
     */
    private function familyHasSeedSpouse(Family $family, array $individuals): bool
    {
        foreach ($family->spouses() as $spouse) {
            if ($spouse instanceof Individual && array_key_exists($spouse->xref(), $individuals)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Individual|Family $record
     * @return array<int,AssociatedPersonEntry>
     */
    private function associatedEntries($record): array
    {
        $entries = [];
        $recordType = $record instanceof Family ? 'FAM' : 'INDI';
        $referenceIndividual = $record instanceof Individual ? $record : null;
        $referenceFamily = $record instanceof Family ? $record : null;
        $lines = preg_split('/\R/', $record->gedcom()) ?: [];
        $stack = [];

        foreach ($lines as $index => $line) {
            if (preg_match('/^(\d+) ([A-Z0-9_]+)(?: (.*))?$/', $line, $match) !== 1) {
                continue;
            }

            $level = (int) $match[1];
            $tag = $match[2];
            $value = trim($match[3] ?? '');
            $stack[$level] = $tag;

            foreach ($stack as $stackLevel => $unused) {
                if ($stackLevel > $level) {
                    unset($stack[$stackLevel]);
                }
            }

            if (($tag === 'ASSO' || $tag === '_ASSO') && preg_match('/^@(' . Gedcom::REGEX_XREF . ')@$/', $value, $xrefMatch) === 1) {
                $role = $this->associationRoleValue($lines, $index, $level);
                if ($this->isMultipleBirthRole($role)) {
                    continue;
                }

                $individual = Registry::individualFactory()->make($xrefMatch[1], $record->tree());
                if ($individual instanceof Individual) {
                    $entries[] = new AssociatedPersonEntry(
                        $individual,
                        '',
                        $this->translateRole($role),
                        $this->eventLabel($recordType, $this->parentEventTag($stack, $level)),
                        $referenceIndividual,
                        $referenceFamily,
                        $tag
                    );
                }
            }

            if (in_array($tag, self::PROPRIETARY_NAME_TAGS, true) && $value !== '') {
                $individual = null;
                $associatedName = $value;

                if (preg_match('/^@(' . Gedcom::REGEX_XREF . ')@$/', $value, $xrefMatch) === 1) {
                    $individual = Registry::individualFactory()->make($xrefMatch[1], $record->tree());
                    if ($individual instanceof Individual) {
                        $associatedName = '';
                    }
                }

                $entries[] = new AssociatedPersonEntry(
                    $individual instanceof Individual ? $individual : null,
                    $associatedName,
                    $this->translateRole($tag),
                    $this->eventLabel($recordType, $this->parentEventTag($stack, $level)),
                    $referenceIndividual,
                    $referenceFamily,
                    $tag
                );
            }
        }

        return $entries;
    }

    /**
     * @param array<int,string> $lines
     */
    private function childValue(array $lines, int $startIndex, int $parentLevel, string $childTag): string
    {
        for ($i = $startIndex + 1; $i < count($lines); $i++) {
            if (preg_match('/^(\d+) ([A-Z0-9_]+)(?: (.*))?$/', $lines[$i], $match) !== 1) {
                continue;
            }

            $level = (int) $match[1];
            if ($level <= $parentLevel) {
                break;
            }

            if ($level === $parentLevel + 1 && strtolower($match[2]) === strtolower($childTag)) {
                return trim($match[3] ?? '');
            }
        }

        return '';
    }

    /**
     * @param array<int,string> $lines
     */
    private function associationRoleValue(array $lines, int $startIndex, int $parentLevel): string
    {
        $rela = $this->childValue($lines, $startIndex, $parentLevel, 'RELA');
        if ($rela !== '') {
            return $rela;
        }

        return $this->childValue($lines, $startIndex, $parentLevel, 'TYPE');
    }

    private function isMultipleBirthRole(string $role): bool
    {
        return in_array(strtolower(trim($role)), self::MULTIPLE_BIRTH_ROLES, true);
    }

    /**
     * @param array<int,string> $stack
     */
    private function parentEventTag(array $stack, int $level): string
    {
        for ($parentLevel = $level - 1; $parentLevel >= 1; $parentLevel--) {
            $tag = $stack[$parentLevel] ?? '';

            if ($tag !== '' && $tag !== 'ASSO' && $tag !== '_ASSO') {
                return $tag;
            }
        }

        return '';
    }

    private function eventLabel(string $recordType, string $eventTag): string
    {
        if ($eventTag === '') {
            return I18N::translate('Record');
        }

        return Registry::elementFactory()->make($recordType . ':' . $eventTag)->label();
    }

    private function translateRole(string $role): string
    {
        $role = trim($role);

        return match (strtolower($role)) {
            '_godp', 'godparent', 'godfather', 'godmother' => I18N::translate('Godparent'),
            'godmother_confirmation', 'godfather_confirmation', 'godparent_confirmation' => I18N::translate('Confirmation godparent'),
            '_witn', '_witness', 'witness' => I18N::translate('Witness'),
            'witnees_of_marriage', 'witness_of_marriage' => I18N::translate('Witness of marriage'),
            'priest' => I18N::translate('Priest'),
            '_spon', '_sponsor', 'sponsor' => I18N::translate('Sponsor'),
            'employer' => I18N::translate('Employer'),
            'landlord' => I18N::translate('Landlord'),
            'neighbor', 'neighbour' => I18N::translate('Neighbor'),
            default => $role !== '' ? $role : I18N::translate('Associated person'),
        };
    }

    private function filterAssociatedEntries(array $filterOptions): void
    {
        if (($filterOptions['alive'] === 'all') && ($filterOptions['sex'] === 'all')) {
            return;
        }

        foreach ($this->efpObject->groups as $group) {
            foreach ($group->entries as $key => $entry) {
                if (!$entry instanceof AssociatedPersonEntry || !$entry->associatedIndividual instanceof Individual) {
                    unset($group->entries[$key]);
                    continue;
                }

                if (($filterOptions['alive'] === 'only_alive' && $entry->associatedIndividual->isDead()) ||
                    ($filterOptions['alive'] === 'only_dead' && !$entry->associatedIndividual->isDead()) ||
                    !ExtendedFamilySupport::sexMatchesFilter($entry->associatedIndividual->sex(), $filterOptions['sex'])) {
                    unset($group->entries[$key]);
                }
            }
        }

        foreach ($this->efpObject->groups as $key => $group) {
            if (count($group->entries) === 0) {
                unset($this->efpObject->groups[$key]);
            }
        }
    }

    private function addCountersAssociatedEntries(): void
    {
        $counts = new FamilyPartCounts();

        foreach ($this->efpObject->groups as $group) {
            foreach ($group->entries as $entry) {
                if (!$entry instanceof AssociatedPersonEntry) {
                    continue;
                }

                if ($entry->associatedIndividual instanceof Individual) {
                    $counts->add(FamilyPartCounts::fromIndividuals([$entry->associatedIndividual]));
                } else {
                    $counts->otherSexCount++;
                    $counts->allCount++;
                }
            }
        }

        $this->setFamilyPartCounts($this->efpObject, $counts);
    }

    private function entrySignature(AssociatedPersonEntry $entry): string
    {
        return ($entry->associatedIndividual instanceof Individual ? $entry->associatedIndividual->xref() : $entry->associatedName) . '|' .
            $entry->role . '|' .
            $entry->event . '|' .
            ($entry->referenceIndividual instanceof Individual ? $entry->referenceIndividual->xref() : '') . '|' .
            ($entry->referenceFamily instanceof Family ? $entry->referenceFamily->xref() : '') . '|' .
            $entry->sourceTag;
    }
}
