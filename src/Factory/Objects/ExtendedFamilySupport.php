<?php
/*
 * webtrees - extended family part
 *
 * Copyright (C) 2021 Hermann Hartenthaler. All rights reserved.
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2021 webtrees development team.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; If not, see <https://www.gnu.org/licenses/>.
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Elements\PedigreeLinkageType;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Registry;

// string functions
use function e;
use function class_exists;
use function method_exists;
use function strip_tags;
use function str_replace;
use function strtolower;
use function str_contains;  // will be added in PHP 8.0, at the moment part of the framework
use function trim;
use function preg_match;

// array functions
use function in_array;
use function array_filter;

/**
 * class ExtendedFamilySupport
 *
 * static support methods for extended family
 */
class ExtendedFamilySupport
{
    /**
     * list of const for extended family
     */
    public const FAM_STATUS_EX          = 'Ex-marriage';
    public const FAM_STATUS_MARRIAGE    = 'Marriage';
    public const FAM_STATUS_FIANCEE     = 'Fiancée';
    public const FAM_STATUS_PARTNERSHIP = 'Partnership';
    public const FAM_STATUS_DIVORCED    = 'divorced';
    public const FAM_STATUS_MARRIED     = 'married';
    public const FAM_STATUS_ENGAGED     = 'engaged';
    public const FAM_STATUS_PARTNERS    = 'partners';
    public const FAM_STATUS_DIVORCED_PARTNER = 'divorced partner';
    public const FAM_STATUS_MARRIED_PARTNER  = 'married partner';
    public const FAM_STATUS_ENGAGED_PARTNER  = 'engaged partner';
    public const FAM_STATUS_PARTNER          = 'partner';

    /**
     * Core webtrees relationship labels used in group headings.
     *
     * @return object{
     *     brother:string,
     *     child:string,
     *     daughter:string,
     *     sibling:string,
     *     sister:string,
     *     son:string
     * }
     */
    public static function coreRelationshipLabels(): object
    {
        return (object)[
            'brother'  => /* I18N: This is a webtrees core relationship label; no module-specific translation is needed. */ I18N::translate('Brother'),
            'child'    => /* I18N: This is a webtrees core relationship label; no module-specific translation is needed. */ I18N::translate('Child'),
            'daughter' => /* I18N: This is a webtrees core relationship label; no module-specific translation is needed. */ I18N::translate('Daughter'),
            'sibling'  => /* I18N: This is a webtrees core relationship label; no module-specific translation is needed. */ I18N::translate('Sibling'),
            'sister'   => /* I18N: This is a webtrees core relationship label; no module-specific translation is needed. */ I18N::translate('Sister'),
            'son'      => /* I18N: This is a webtrees core relationship label; no module-specific translation is needed. */ I18N::translate('Son'),
        ];
    }

    public static function individualLink(Individual $person): string
    {
        if ($person->canShow()) {
            return '<a href="' . e($person->url()) . '">' . $person->fullName() . '</a>';
        }

        return $person->fullName();
    }

    public static function partnerInFamilyLink(Family $family, Individual $person): string
    {
        foreach ($family->spouses() as $spouse) {
            if ($spouse->xref() !== $person->xref()) {
                return self::individualLink($spouse);
            }
        }

        return $family->fullName();
    }

    /**
     * get parameters for the used extended family parts like relationship coefficients and generation shift
     *
     * @return array<string,array<string,int|string>>
     */
    public static function getFamilyPartParameters(): array // new elements can be added, but not changed or deleted
                                                            // names of elements have to be shorter than 25 characters
                                                            // this sequence is the default order of family parts
    {
        return [
            'great_grandparents'     => ['generation' => +3, 'relationshipCoefficient' => 0.125, 'relationshipCoefficientComment' => Great_grandparents::GROUP_GREATGRANDPARENTS_BIO],
            'grandparents'           => ['generation' => +2, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Grandparents::GROUP_GRANDPARENTS_BIO],
            'grandaunts_uncles'      => ['generation' => +2, 'relationshipCoefficient' => 0.125, 'relationshipCoefficientComment' => Grandaunts_uncles::GROUP_GRANDAUNTUNCLE_FULL_BIO],
            'uncles_and_aunts'       => ['generation' => +1, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Uncles_and_aunts::GROUP_UNCLEAUNT_FULL_BIO],
            'uncles_and_aunts_bm'    => ['generation' => +1, 'relationshipCoefficient' => 0],
            'parents'                => ['generation' => +1, 'relationshipCoefficient' => 0.5,   'relationshipCoefficientComment' => Parents::GROUP_PARENTS_BIO],
            'parents_in_law'         => ['generation' => +1, 'relationshipCoefficient' => 0],
            'co_parents_in_law'      => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'partners'               => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'partner_chains'         => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'siblings'               => ['generation' =>  0, 'relationshipCoefficient' => 0.5,   'relationshipCoefficientComment' => Siblings::GROUP_SIBLINGS_FULL],
            'siblings_in_law'        => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'co_siblings_in_law'     => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'cousins'                => ['generation' =>  0, 'relationshipCoefficient' => 0.125, 'relationshipCoefficientComment' => Cousins::GROUP_COUSINS_FULL_BIO],
            'nephews_and_nieces'     => ['generation' => -1, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_FULLSIBLING],
            'children'               => ['generation' => -1, 'relationshipCoefficient' => 0.5,   'relationshipCoefficientComment' => Children::GROUP_CHILDREN_BIO],
            'children_in_law'        => ['generation' => -1, 'relationshipCoefficient' => 0],
            'grandchildren'          => ['generation' => -2, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Grandchildren::GROUP_GRANDCHILDREN_BIO],
            'grandchildren_in_law'   => ['generation' => -2, 'relationshipCoefficient' => 0],
            'great_grandchildren'    => ['generation' => -3, 'relationshipCoefficient' => 0.125, 'relationshipCoefficientComment' => Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIOLOGICAL],
            'great_grandchild_in_law' => ['generation' => -3, 'relationshipCoefficient' => 0],
       ];
    }

    /**
     * list of parts of extended family
     *
     * @return array<int,string>
     */
    public static function listFamilyParts(): array
    {
        return array_keys(self::getFamilyPartParameters());
    }

    /**
     * Coarse administrative degree per family part.
     *
     * This value is used only as a selection aid in the control panel. It is not
     * the exact person-level distance that may later be stored per individual.
     *
     * @return array<string,int>
     */
    public static function getFamilyPartDegrees(): array
    {
        return [
            'parents'                => 1,
            'children'               => 1,
            'siblings'               => 1,
            'partners'               => 1,
            'grandparents'           => 2,
            'grandchildren'          => 2,
            'uncles_and_aunts'       => 2,
            'nephews_and_nieces'     => 2,
            'parents_in_law'         => 2,
            'children_in_law'        => 2,
            'siblings_in_law'        => 2,
            'partner_chains'         => 2,    // this is used for the admin selection of family parts only, not for the members in a partner chain
            'great_grandparents'     => 3,
            'grandaunts_uncles'     => 3,
            'great_grandchildren'    => 3,
            'cousins'                => 3,
            'uncles_and_aunts_bm'    => 3,
            'co_parents_in_law'      => 3,
            'co_siblings_in_law'     => 3,
            'grandchildren_in_law'   => 3,
            'great_grandchild_in_law' => 4,
        ];
    }

    /**
     * format generation in relation to the proband for an extended family part (e.g. '+3' or '0' or '-2'
     *
     * @param string $efp
     * @return string
     */
    public static function formatGeneration(string $efp): string
    {
        $generation = ExtendedFamilySupport::getFamilyPartParameters()[$efp]['generation'];
        if ($generation > 0) {
            return '+' . strval($generation);
        } else {
            return strval($generation);
        }
    }

    /**
     * get list of options to filter by gender
     *
     * @return array<int,string>
     */
    private static function getFilterOptionsSex(): array
    {
        return [
            'M',
            'F',
            'U',    // used for sex = "X" (other/divers) and sex ="U" (unknown)
        ];
    }

    /**
     * get list of options to filter by alive/dead
     *
     * @return array<int,string>
     */
    private static function getFilterOptionsAlive(): array
    {
        return [
            'Y',
            'N',
        ];
    }

    /**
     * get list of all combinations of filter options ['all', 'M', 'F', 'U', 'Y', 'N', 'MY', 'FN', ...]
     *
     * @return array<int,string>
     */
    public static function getFilterOptions(): array
    {
        $options = [];
        $options[] = 'all';
        foreach (self::getFilterOptionsSex() as $option) {
            $options[] = $option;
        }
        foreach (self::getFilterOptionsAlive() as $option) {
            $options[] = $option;
        }
        foreach (self::getFilterOptionsSex() as $optionSex) {
            foreach (self::getFilterOptionsAlive() as $optionAlive) {
                $options[] = $optionSex . $optionAlive;
            }
        }
        return $options;
    }
    
    /**
     * convert combined filterOption to filter option for gender of a person [all, only_M, only_F, only_U]
     *
     * @param string $filterOption [all, M, F, U, Y, N, MY, FN, ...]
     * @return string
     */
    public static function filterOptionSex(string $filterOption): string
    {
        foreach (self::getFilterOptionsSex() as  $option) {
            if (str_contains($filterOption, $option)) {
                return 'only_' . $option;
            }
        }
        return 'all';
    }

    /**
     * Check whether an individual sex value matches the configured sex filter.
     *
     * GEDCOM 7 supports sex "X" for people who do not fit the typical male/female definition.
     * The module keeps the existing filter value "U" as the combined "other or unknown" category.
     *
     * @param string $sex          GEDCOM sex value [M, F, X, U, ...]
     * @param string $filterOption [all, only_M, only_F, only_U]
     * @return bool
     */
    public static function sexMatchesFilter(string $sex, string $filterOption): bool
    {
        switch ($filterOption) {
            case 'only_M':
                return $sex === 'M';

            case 'only_F':
                return $sex === 'F';

            case 'only_U':
                return $sex !== 'M' && $sex !== 'F';

            default:
                return true;
        }
    }

    /**
     * convert combined filteroption to filter option for alive/dead status of a person [all, only_dead, only_alive]
     *
     * @param string [M, F, U, Y, N, MY, FN, ...]
     * @return string
     */
    public static function filterOptionAlive($filterOption): string
    {
        foreach (self::getFilterOptionsAlive() as  $option) {
            if (str_contains($filterOption, $option)) {
                if ($option == 'Y') {
                    return 'only_alive';
                } else {
                    return 'only_dead';
                }
            }
        }
        return 'all';            
    }

    /**
     * convert combined filterOption to a pair of filter options
     *
     * @param string $filterOption  [M, F, U, Y, N, MY, ...]
     * @return array<string,string> [sex, alive]
     */
    public static function convertFilterOptions(string $filterOption): array
    {
        return [
            'sex'   => self::filterOptionSex($filterOption),
            'alive' => self::filterOptionAlive($filterOption),
        ];
    }

    /**
     * generate an array of labels for a child
     *
     * @param Individual $child
     * @return array<int,string> with child labels
     */
    public static function generateChildLabels(Individual $child): array
    {
        return array_filter([
            self::generatePedigreeLabel($child),
            self::generateChildLinkageStatusLabel($child),
            self::generateMultipleBirthLabel($child),
            self::generateAgeLabel($child),
        ]);
    }

    /**
     * Get how an individual is related to the proband using Vesta, if available.
     *
     * @return bool
     */
    public static function relationshipNamesAvailable(): bool
    {
        static $available = null;

        if ($available !== null) {
            return $available;
        }

        if (!class_exists('\Vesta\VestaUtils', true)) {
            $available = false;

            return $available;
        }

        try {
            $relationshipService = \Vesta\VestaUtils::get(\Fisharebest\Webtrees\Services\RelationshipService::class);

            $available = method_exists($relationshipService, 'getCloseRelationshipName');

            return $available;
        } catch (\Throwable) {
            $available = false;

            return $available;
        }
    }

    /**
     * Get how an individual is related to the proband using Vesta, if available.
     *
     * @param Individual $individual
     * @param Individual $proband
     * @return string
     */
    public static function relationshipNameToProband(Individual $individual, Individual $proband): string
    {
        static $relationshipNames = [];

        if ($individual->xref() === $proband->xref() || !self::relationshipNamesAvailable()) {
            return '';
        }

        $cacheKey = $proband->tree()->name() . ':' . $proband->xref() . ':' . $individual->xref();

        if (isset($relationshipNames[$cacheKey])) {
            return $relationshipNames[$cacheKey];
        }

        try {
            $relationshipService = \Vesta\VestaUtils::get(\Fisharebest\Webtrees\Services\RelationshipService::class);

            if (!method_exists($relationshipService, 'getCloseRelationshipName')) {
                return '';
            }

            $relationshipNames[$cacheKey] = trim(strip_tags($relationshipService->getCloseRelationshipName($proband, $individual)));

            return $relationshipNames[$cacheKey];
        } catch (\Throwable) {
            $relationshipNames[$cacheKey] = '';

            return '';
        }
    }

    /**
     * Generate a fact summary using the configured place format.
     *
     * @param Fact $event
     * @param int $placeFormat
     * @return string
     */
    public static function eventSummary(Fact $event, int $placeFormat): string
    {
        $summary = $event->summary();
        if ($event->place()->gedcomName() === '') {
            return $summary;
        }

        $place = PlaceAbbreviation::getAbbreviatedPlace($event->place()->gedcomName(), $placeFormat);
        return str_replace($event->place()->shortName(), '<span class="ut">' . e($place) . '</span>', $summary);
    }

    /**
     * generate a translated pedigree label for a child
     * GEDCOM record could be for example "1 FAMC @xref@\n ...\n2 PEDI adopted"
     *
     * @param Individual $child
     * @return string
     */
    private static function generatePedigreeLabel(Individual $child): string
    {
        $label = '';
        if ($child->childFamilies()->first()) {
            $fact = $child->facts(['FAMC'])->first();
            if ($fact instanceof Fact) {
                $pedi = $fact->attribute('PEDI');
            } else {
                $pedi = '';
            }
            if ($pedi !== '' && $pedi !== PedigreeLinkageType::VALUE_BIRTH) {
                $label  = Registry::elementFactory()->make('INDI:FAMC:PEDI')->value($pedi, $child->tree());
            } else {
                $label  = Registry::elementFactory()->make('INDI:FAMC:PEDI')->value('', $child->tree());
            }
        }
        return $label;
    }

    /**
     * generate a child linkage status label [challenged | disproven | proven]
     * GEDCOM record is for example "1 FAMC @F1@\n2 PEDI birth\n2 STAT proven"
     *
     * @param Individual $child
     * @return string
     */
    private static function generateChildLinkageStatusLabel(Individual $child): string
    {
        if ($child->childFamilies()->first()) {
            if (preg_match('/\n1 FAMC @' . $child->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 STAT (.+)/', $child->gedcom(), $match)) {
                switch (strtolower($match[1])) {
                    case 'challenged':
                        return I18N::translate('Linkage challenged');

                    case 'disproven':
                        return I18N::translate('Linkage disproven');

                    case 'proven':
                        return I18N::translate('Linkage proven');
                }
            }
        }
        return '';
    }
    /**
     * generate a label for twins and triplets etc.
     * GEDCOM record is for example "1 ASSO @I123@\n2 RELA triplet" or "1 BIRT\n2 _ASSO @I123@\n3 RELA triplet"
     *
     * @param Individual $child
     * @return string
     */
    private static function generateMultipleBirthLabel(Individual $child): string
    {
        $multipleBirth = [
            2 => 'twin',
            3 => 'triplet',
            4 => 'quadruplet',
            5 => 'quintuplet',
            6 => 'sextuplet',
            7 => 'septuplet',
            8 => 'octuplet',
            9 => 'nonuplet',
            10 => 'decuplet',
        ];
        $childGedcom = $child->gedcom();
        if (preg_match('/\n1 ASSO @(?:.+)@\n2 RELA (.+)/', $childGedcom, $match) ||
             preg_match('/\n2 _ASSO @(?:.+)@\n3 RELA (.+)/', $childGedcom, $match)) {
            $rela = strtolower($match[1]);
            if (in_array($rela, $multipleBirth)) {
                return self::translateMultipleBirthLabel($rela);
            }
        }
        return '';
    }

    /**
     * Translate multiple-birth labels explicitly so gettext extractors can find them.
     *
     * @param string $rela
     * @return string
     */
    private static function translateMultipleBirthLabel(string $rela): string
    {
        return match ($rela) {
            'twin'      => I18N::translate('Twin'),
            'triplet'   => I18N::translate('Triplet'),
            'quadruplet' => I18N::translate('Quadruplet'),
            'quintuplet' => I18N::translate('Quintuplet'),
            'sextuplet' => I18N::translate('Sextuplet'),
            'septuplet' => I18N::translate('Septuplet'),
            'octuplet'  => I18N::translate('Octuplet'),
            'nonuplet'  => I18N::translate('Nonuplet'),
            'decuplet'  => I18N::translate('Decuplet'),
            default     => I18N::translate($rela),
        };
    }

    /**
     * generate a label for children that are stillborn or died as an infant
     * GEDCOM record is for example "1 DEAT\n2 AGE INFANT" or "1 BIRT\n2 AGE STILLBORN"
     *
     * There was a performance bug when using preg_match('/\n1 BIRT((.|\s)*)\n2 AGE STILLBORN/i', $childGedcom, $match)
     *
     * @param Individual $child
     * @return string
     */
    private static function generateAgeLabel(Individual $child): string
    {     
        $childGedcom = $child->gedcom();
        if (preg_match('/\n2 AGE STILLBORN/i', $childGedcom, $match)) {
            return I18N::translate('Stillborn');
        }        
        if (preg_match('/\n2 AGE INFANT/i', $childGedcom, $match)) {
            return I18N::translate('Died as infant');
        }
        return '';
    }

   /**
    * find status of a family
    *
    * @param Family $family
    * @return string
    */
    public static function findFamilyStatus(Family $family): string
    {
        $event = $family->facts(['ANUL', 'DIV', 'ENGA', 'MARR'], true)->last();
        if ($event instanceof Fact) {
            switch ($event->tag()) {
                case 'FAM:ANUL':
                case 'FAM:DIV':
                    return self::FAM_STATUS_EX;
                case 'FAM:MARR':
                    return self::FAM_STATUS_MARRIAGE;
                case 'FAM:ENGA':
                    return self::FAM_STATUS_FIANCEE;
            }
        }
        return self::FAM_STATUS_PARTNERSHIP;                       // default if there is no family status tag
    }

    /**
     * Translate family status for parenthetical use.
     *
     * @param string $familyStatus
     * @return string
     */
    public static function translateFamilyStatusForParentheses(string $familyStatus): string
    {
        return match ($familyStatus) {
            self::FAM_STATUS_EX          => I18N::translate('divorced'),
            self::FAM_STATUS_MARRIAGE    => I18N::translate('married'),
            self::FAM_STATUS_FIANCEE     => I18N::translate('engaged'),
            self::FAM_STATUS_PARTNERSHIP => I18N::translate('partners'),
            default                      => self::translateFamilyStatus($familyStatus),
        };
    }

    /**
     * Translate family status for standalone use.
     *
     * @param string $familyStatus
     * @return string
     */
    public static function translateFamilyStatus(string $familyStatus): string
    {
        return match ($familyStatus) {
            self::FAM_STATUS_EX          => I18N::translate('Ex-marriage'),
            self::FAM_STATUS_MARRIAGE    => I18N::translate('Marriage'),
            self::FAM_STATUS_FIANCEE     => I18N::translate('Fiancée'),
            self::FAM_STATUS_PARTNERSHIP => I18N::translate('Partnership'),
            default                      => I18N::translate($familyStatus),
        };
    }

    /**
     * Translate family status as a modifier for a partner.
     *
     * @param string $familyStatus
     * @return string
     */
    public static function translateFamilyStatusAsPartner(string $familyStatus): string
    {
        return match ($familyStatus) {
            self::FAM_STATUS_EX          => I18N::translate('divorced partner'),
            self::FAM_STATUS_MARRIAGE    => I18N::translate('married partner'),
            self::FAM_STATUS_FIANCEE     => I18N::translate('engaged partner'),
            self::FAM_STATUS_PARTNERSHIP => I18N::translate('partner'),
            default                      => I18N::translate($familyStatus),
        };
    }

    /**
     * Check whether two individuals share the same parent-family record.
     *
     * @param Individual $individual1
     * @param Individual $individual2
     * @return bool
     */
    public static function areFullSiblings(Individual $individual1, Individual $individual2): bool
    {
        foreach ($individual1->childFamilies() as $family1) {
            foreach ($individual2->childFamilies() as $family2) {
                if ($family1->xref() === $family2->xref() && self::isBiologicalChildInFamily($individual1, $family1) && self::isBiologicalChildInFamily($individual2, $family2)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check whether two individuals share at least one, but not the same pair of, parents.
     *
     * @param Individual $individual1
     * @param Individual $individual2
     * @return bool
     */
    public static function areHalfSiblings(Individual $individual1, Individual $individual2): bool
    {
        if (self::areFullSiblings($individual1, $individual2)) {
            return false;
        }

        return array_intersect_key(
            self::parentXrefsFromChildFamilies($individual1),
            self::parentXrefsFromChildFamilies($individual2)
        ) !== [];
    }

    /**
     * Check whether two individuals are biological full or half siblings.
     *
     * @param Individual $individual1
     * @param Individual $individual2
     * @return bool
     */
    public static function areSiblings(Individual $individual1, Individual $individual2): bool
    {
        return self::areFullSiblings($individual1, $individual2) || self::areHalfSiblings($individual1, $individual2);
    }

    /**
     * Translate a sibling label, optionally relative to another sibling.
     *
     * @param Individual $sibling
     * @param Individual|null $referenceSibling
     * @return string
     */
    public static function translateSiblingLabel(Individual $sibling, ?Individual $referenceSibling = null): string
    {
        $isHalfSibling = $referenceSibling instanceof Individual && self::areHalfSiblings($sibling, $referenceSibling);

        return match ($sibling->sex()) {
            'M'     => I18N::translate($isHalfSibling ? 'Half-brother' : 'Brother'),
            'F'     => I18N::translate($isHalfSibling ? 'Half-sister' : 'Sister'),
            default => I18N::translate($isHalfSibling ? 'Half-sibling' : 'Sibling'),
        };
    }

    /**
     * Get the xrefs of all parents in all child-family records.
     *
     * @param Individual $individual
     * @return array<string,bool>
     */
    private static function parentXrefsFromChildFamilies(Individual $individual): array
    {
        $parentXrefs = [];

        foreach ($individual->childFamilies() as $family) {
            if (!self::isBiologicalChildInFamily($individual, $family)) {
                continue;
            }
            foreach ($family->spouses() as $parent) {
                $parentXrefs[$parent->xref()] = true;
            }
        }

        return $parentXrefs;
    }

    /**
     * Is this a biological child-family link?
     *
     * @param Individual $individual
     * @param Family $family
     * @return bool
     */
    private static function isBiologicalChildInFamily(Individual $individual, Family $family): bool
    {
        return self::childFamilyPedigreeType($individual, $family) === PedigreeLinkageType::VALUE_BIRTH;
    }

    /**
     * get PEDI value for a child-family link; missing PEDI is treated as birth
     *
     * @param Individual $individual
     * @param Family $family
     * @return string
     */
    private static function childFamilyPedigreeType(Individual $individual, Family $family): string
    {
        $fact = $individual->facts(['FAMC'])->first(static fn (Fact $fact): bool => $fact->value() === '@' . $family->xref() . '@');

        if ($fact instanceof Fact) {
            return $fact->attribute('PEDI') ?: PedigreeLinkageType::VALUE_BIRTH;
        }

        return PedigreeLinkageType::VALUE_BIRTH;
    }

   /**
    * translate family part names
    *
    * @param string $type (in lower case and using _)
    * @return string
    */
    public static function translateFamilyPart(string $type): string
    {
        return match ($type) {
            'great_grandparents'      => I18N::translate('Great-grandparents'),
            'grandparents'            => I18N::translate('Grandparents'),
            'grandaunts_uncles'      => I18N::translate('Grandaunts and Granduncles'),
            'uncles_and_aunts'        => I18N::translate('Uncles and Aunts'),
            'uncles_and_aunts_bm'     => I18N::translate('Uncles and Aunts by marriage'),
            'parents'                 => I18N::translate('Parents'),
            'parents_in_law'          => I18N::translate('Parents-in-law'),
            'co_parents_in_law'       => I18N::translate('Co-parents-in-law'),
            'partners'                => I18N::translate('Partners'),
            'partner_chains'          => I18N::translate('Partner chains'),
            'siblings'                => I18N::translate('Siblings'),
            'siblings_in_law'         => I18N::translate('Siblings-in-law'),
            'co_siblings_in_law'      => I18N::translate('Co-siblings-in-law'),
            'cousins'                 => I18N::translate('Cousins'),
            'nephews_and_nieces'      => I18N::translate('Nephews and Nieces'),
            'children'                => I18N::translate('Children'),
            'children_in_law'         => I18N::translate('Children-in-law'),
            'grandchildren'           => I18N::translate('Grandchildren'),
            'great_grandchildren'     => I18N::translate('Great-grandchildren'),
            'grandchildren_in_law'    => I18N::translate('Grandchildren-in-law'),
            'great_grandchild_in_law' => I18N::translate('Great-grandchildren-in-law'),
            default                   => I18N::translate($type),
        };
    }

   /**
    * Translate family part names for use inside sentences.
    *
    * These strings intentionally differ from the heading labels above. Several
    * languages use different capitalization in headings and running text.
    *
    * @param string $type (in lower case and using _)
    * @return string
    */
    public static function translateFamilyPartSentenceObject(string $type): string
    {
        return match ($type) {
            'great_grandparents'      => I18N::translateContext('Family part name in sentence', 'great-grandparents'),
            'grandparents'            => I18N::translateContext('Family part name in sentence', 'grandparents'),
            'grandaunts_uncles'      => I18N::translateContext('Family part name in sentence', 'grandaunts and granduncles'),
            'uncles_and_aunts'        => I18N::translateContext('Family part name in sentence', 'uncles and aunts'),
            'uncles_and_aunts_bm'     => I18N::translateContext('Family part name in sentence', 'uncles and aunts by marriage'),
            'parents'                 => I18N::translateContext('Family part name in sentence', 'parents'),
            'parents_in_law'          => I18N::translateContext('Family part name in sentence', 'parents-in-law'),
            'co_parents_in_law'       => I18N::translateContext('Family part name in sentence', 'co-parents-in-law'),
            'partners'                => I18N::translateContext('Family part name in sentence', 'partners'),
            'partner_chains'          => I18N::translateContext('Family part name in sentence', 'partner chains'),
            'siblings'                => I18N::translateContext('Family part name in sentence', 'siblings'),
            'siblings_in_law'         => I18N::translateContext('Family part name in sentence', 'siblings-in-law'),
            'co_siblings_in_law'      => I18N::translateContext('Family part name in sentence', 'co-siblings-in-law'),
            'cousins'                 => I18N::translateContext('Family part name in sentence', 'cousins'),
            'nephews_and_nieces'      => I18N::translateContext('Family part name in sentence', 'nephews and nieces'),
            'children'                => I18N::translateContext('Family part name in sentence', 'children'),
            'children_in_law'         => I18N::translateContext('Family part name in sentence', 'children-in-law'),
            'grandchildren'           => I18N::translateContext('Family part name in sentence', 'grandchildren'),
            'great_grandchildren'     => I18N::translateContext('Family part name in sentence', 'great-grandchildren'),
            'grandchildren_in_law'    => I18N::translateContext('Family part name in sentence', 'grandchildren-in-law'),
            'great_grandchild_in_law' => I18N::translateContext('Family part name in sentence', 'great-grandchildren-in-law'),
            default                   => I18N::translate($type),
        };
    }

    /**
     * Translate comments used for the relationship coefficient badge.
     *
     * @param string $comment
     * @return string
     */
    public static function translateRelationshipCoefficientComment(string $comment): string
    {
        return match ($comment) {
            Great_grandparents::GROUP_GREATGRANDPARENTS_BIO                   => I18N::translate('Biological great-grandparents'),
            Grandparents::GROUP_GRANDPARENTS_BIO                              => I18N::translate('Biological grandparents'),
            Grandaunts_uncles::GROUP_GRANDAUNTUNCLE_FULL_BIO          => I18N::translate('Full siblings of biological grandparents'),
            Uncles_and_aunts::GROUP_UNCLEAUNT_FULL_BIO                        => I18N::translate('Full siblings of biological parents'),
            Parents::GROUP_PARENTS_BIO                                        => I18N::translate('Biological parents'),
            Siblings::GROUP_SIBLINGS_FULL                                     => I18N::translate('Full siblings'),
            Cousins::GROUP_COUSINS_FULL_BIO                                   => I18N::translate('Children of full siblings of biological parents'),
            Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_FULLSIBLING         => I18N::translate('Children of full siblings'),
            Children::GROUP_CHILDREN_BIO                                      => I18N::translate('Biological children'),
            Grandchildren::GROUP_GRANDCHILDREN_BIO                            => I18N::translate('Biological grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIOLOGICAL          => I18N::translate('Biological great-grandchildren'),
            default                                                           => I18N::translate($comment),
        };
    }

    /**
     * Translate group names that may otherwise only occur as dynamic values.
     *
     * @param string $groupName
     * @return string
     */
    public static function translateGroupName(string $groupName): string
    {
        return match ($groupName) {
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_BIO         => I18N::translate('Biological grandparents of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIO         => I18N::translate('Biological grandparents of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_BIO              => I18N::translate('Biological grandparents of parent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEPBIO     => I18N::translate('Stepparents of biological parent of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEPBIO     => I18N::translate('Stepparents of biological parent of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_STEPBIO          => I18N::translate('Stepparents of biological grandparent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_BIOSOCIAL   => I18N::translate('Social parents of biological parent of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIOSOCIAL   => I18N::translate('Social parents of biological parent of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_BIOSOCIAL        => I18N::translate('Social parents of biological grandparent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP        => I18N::translate('Parents of stepparent of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP        => I18N::translate('Parents of stepparent of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_STEP             => I18N::translate('Parents of stepparent of parent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP_STEP   => I18N::translate('Stepparents of stepparent of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP_STEP   => I18N::translate('Stepparents of stepparent of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_STEP_STEP        => I18N::translate('Stepparents of stepparent of parent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL      => I18N::translate('Parents of social parent of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL      => I18N::translate('Parents of social parent of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_SOCIAL           => I18N::translate('Parents of social parent of parent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL_STEP => I18N::translate('Stepparents of social parent of father'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL_STEP => I18N::translate('Stepparents of social parent of mother'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_SOCIAL_STEP      => I18N::translate('Stepparents of social parent of parent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_STEP_PARENTS           => I18N::translate('Grandparents of stepparent'),
            Great_grandparents::GROUP_GREATGRANDPARENTS_SOCIAL_PARENTS         => I18N::translate('Grandparents of social parent'),
            Grandparents::GROUP_GRANDPARENTS_FATHER_BIO         => I18N::translate('Biological parents of father'),
            Grandparents::GROUP_GRANDPARENTS_MOTHER_BIO         => I18N::translate('Biological parents of mother'),
            Grandparents::GROUP_GRANDPARENTS_U_BIO              => I18N::translate('Biological parents of parent'),
            Grandparents::GROUP_GRANDPARENTS_FATHER_STEP        => I18N::translate('Stepparents of father'),
            Grandparents::GROUP_GRANDPARENTS_MOTHER_STEP        => I18N::translate('Stepparents of mother'),
            Grandparents::GROUP_GRANDPARENTS_U_STEP             => I18N::translate('Stepparents of parent'),
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENTS       => I18N::translate('Parents of stepparent'),
            Grandparents::GROUP_GRANDPARENTS_FATHER_SOCIAL      => I18N::translate('Social parents of father'),
            Grandparents::GROUP_GRANDPARENTS_MOTHER_SOCIAL      => I18N::translate('Social parents of mother'),
            Grandparents::GROUP_GRANDPARENTS_U_SOCIAL           => I18N::translate('Social parents of parent'),
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER      => I18N::translate('Parents of social father'),
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER      => I18N::translate('Parents of social mother'),
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT      => I18N::translate('Parents of social parent'),
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER_STEP => I18N::translate('Stepparents of social father'),
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER_STEP => I18N::translate('Stepparents of social mother'),
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT_STEP => I18N::translate('Stepparents of social parent'),
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENT_STEP   => I18N::translate('Stepparents of stepparent'),
            Grandaunts_uncles::GROUP_GRANDAUNTUNCLE_BIO_GRANDPARENT    => I18N::translate('Siblings and half siblings of biological grandparents'),
            Grandaunts_uncles::GROUP_GRANDAUNTUNCLE_SOCIAL_GRANDPARENT => I18N::translate('Siblings and half siblings of social grandparents'),
            Grandaunts_uncles::GROUP_GRANDAUNTUNCLE_STEP_GRANDPARENT   => I18N::translate('Siblings and half siblings of stepgrandparents'),
            Parents::GROUP_PARENTS_SOCIAL                       => I18N::translate('Social parents'),
            Parents::GROUP_PARENTS_STEP                         => I18N::translate('Stepparents'),
            Uncles_and_aunts::GROUP_UNCLEAUNT_BIO_PARENT        => I18N::translate('Siblings and half siblings of biological parents'),
            Uncles_and_aunts::GROUP_UNCLEAUNT_SOCIAL_PARENT     => I18N::translate('Siblings and half siblings of social parents'),
            Uncles_and_aunts::GROUP_UNCLEAUNT_STEP_PARENT       => I18N::translate('Siblings and half siblings of stepparents'),
            Uncles_and_aunts_bm::GROUP_UNCLEAUNTBM_BIO_PARENT    => I18N::translate('Partners of siblings and half siblings of biological parents'),
            Uncles_and_aunts_bm::GROUP_UNCLEAUNTBM_SOCIAL_PARENT => I18N::translate('Partners of siblings and half siblings of social parents'),
            Uncles_and_aunts_bm::GROUP_UNCLEAUNTBM_STEP_PARENT   => I18N::translate('Partners of siblings and half siblings of stepparents'),
            Cousins::GROUP_COUSINS_FULL_FATHER                  => I18N::translate('Children of full siblings of father'),
            Cousins::GROUP_COUSINS_FULL_MOTHER                  => I18N::translate('Children of full siblings of mother'),
            Cousins::GROUP_COUSINS_FULL_U                       => I18N::translate('Children of full siblings of parent'),
            Cousins::GROUP_COUSINS_HALF_FATHER                  => I18N::translate('Children of half siblings of father'),
            Cousins::GROUP_COUSINS_HALF_MOTHER                  => I18N::translate('Children of half siblings of mother'),
            Cousins::GROUP_COUSINS_HALF_U                       => I18N::translate('Children of half siblings of parent'),
            Cousins::GROUP_COUSINS_FULL_SOCIAL                  => I18N::translate('Children of full siblings of social parents'),
            Cousins::GROUP_COUSINS_HALF_SOCIAL                  => I18N::translate('Children of half siblings of social parents'),
            Cousins::GROUP_COUSINS_FULL_STEP                    => I18N::translate('Children of full siblings of stepparents'),
            Cousins::GROUP_COUSINS_HALF_STEP                    => I18N::translate('Children of half siblings of stepparents'),
            Siblings::GROUP_SIBLINGS_HALF                       => I18N::translate('Half siblings'),
            Siblings::GROUP_SIBLINGS_SOCIAL                     => I18N::translate('Social siblings'),
            Siblings::GROUP_SIBLINGS_STEP                       => I18N::translate('Stepsiblings'),
            Siblings_in_law::GROUP_SIBLINGSINLAW_SIBOFP         => I18N::translate('Siblings of partners'),
            Siblings_in_law::GROUP_SIBLINGSINLAW_POFSIB         => I18N::translate('Partners of siblings'),
            Co_siblings_in_law::GROUP_COSIBLINGSINLAW_SIBPARSIB => I18N::translate('Siblings of siblings-in-law'),
            Co_siblings_in_law::GROUP_COSIBLINGSINLAW_PARSIBPAR => I18N::translate('Partners of siblings-in-law'),
            Children::GROUP_CHILDREN_SOCIAL                     => I18N::translate('Social children'),
            Children::GROUP_CHILDREN_STEP                       => I18N::translate('Stepchildren'),
            Children_in_law::GROUP_CHILDRENINLAW_BIO            => I18N::translate('Partners of biological children'),
            Children_in_law::GROUP_CHILDRENINLAW_SOCIAL         => I18N::translate('Partners of social children'),
            Children_in_law::GROUP_CHILDRENINLAW_STEP           => I18N::translate('Partners of stepchildren'),
            Co_parents_in_law::GROUP_COPARENTSINLAW_BIO         => I18N::translate('Parents-in-law of biological children'),
            Co_parents_in_law::GROUP_COPARENTSINLAW_STEP        => I18N::translate('Parents-in-law of stepchildren'),
            Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_SIBLING => I18N::translate('Children of siblings'),
            Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING => I18N::translate('Siblings\' stepchildren'),
            Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER => I18N::translate('Children of siblings of partners'),
            Grandchildren::GROUP_GRANDCHILDREN_CHILD_SOCIAL      => I18N::translate('Children of social children'),
            Grandchildren::GROUP_GRANDCHILDREN_SOCIAL_CHILD      => I18N::translate('Social children of children'),
            Grandchildren::GROUP_GRANDCHILDREN_STEP_CHILD        => I18N::translate('Stepchildren of children'),
            Grandchildren::GROUP_GRANDCHILDREN_CHILD_STEP        => I18N::translate('Children of stepchildren'),
            Grandchildren::GROUP_GRANDCHILDREN_STEP_STEP         => I18N::translate('Stepchildren of stepchildren'),
            Grandchildren_in_law::GROUP_GRANDCHILDRENINLAW_BIO   => I18N::translate('Partners of biological grandchildren'),
            Grandchildren_in_law::GROUP_GRANDCHILDRENINLAW_SOCIAL_CHILD => I18N::translate('Partners of social children of children'),
            Grandchildren_in_law::GROUP_GRANDCHILDRENINLAW_STEP_CHILD => I18N::translate('Partners of stepchildren of children'),
            Grandchildren_in_law::GROUP_GRANDCHILDRENINLAW_CHILD_STEP => I18N::translate('Partners of children of stepchildren'),
            Grandchildren_in_law::GROUP_GRANDCHILDRENINLAW_STEP_STEP => I18N::translate('Partners of stepchildren of stepchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIOLOGICAL => I18N::translate('Biological great-grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIO    => I18N::translate('Children of biological grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_SOCIAL_CHILD => I18N::translate('Social children of grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_CHILD_SOCIAL => I18N::translate('Children of social grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_CHILD_STEP => I18N::translate('Children of stepgrandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_STEP => I18N::translate('Stepchildren of grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_STEP_SOCIAL => I18N::translate('Stepchildren of social grandchildren'),
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_STEP_STEP => I18N::translate('Stepchildren of stepgrandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_BIO => I18N::translate('Partners of biological great-grandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_SOCIAL_CHILD => I18N::translate('Partners of social children of grandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_CHILD_SOCIAL => I18N::translate('Partners of children of social grandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_CHILD_STEP => I18N::translate('Partners of children of stepgrandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_STEP => I18N::translate('Partners of stepchildren of grandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_STEP_SOCIAL => I18N::translate('Partners of stepchildren of social grandchildren'),
            Great_grandchild_in_law::GROUP_GREATGRANDCHILDRENINLAW_STEP_STEP => I18N::translate('Partners of stepchildren of stepgrandchildren'),
            default                                             => I18N::translate($groupName),
        };
    }

    /**
     * Translate the known date range with enough context for languages that
     * need different prepositions for years, full dates, and today.
     *
     * @param string      $startDate
     * @param string|null $startDateType year|date
     * @param string|null $endDate
     * @param string|null $endDateType year|date|today
     * @return string
     */
    public static function translateKnownDateRange(string $startDate, ?string $startDateType, ?string $endDate, ?string $endDateType): string
    {
        return match ($startDateType . '-' . $endDateType) {
            'year-today' => I18N::translateContext('Date range: year to today', 'The known dates range from %1$s to today.', $startDate),
            'date-today' => I18N::translateContext('Date range: date to today', 'The known dates range from %1$s to today.', $startDate),
            'year-year'  => I18N::translateContext('Date range: year to year', 'The known dates range from %1$s to %2$s.', $startDate, $endDate),
            'year-date'  => I18N::translateContext('Date range: year to date', 'The known dates range from %1$s to %2$s.', $startDate, $endDate),
            'date-year'  => I18N::translateContext('Date range: date to year', 'The known dates range from %1$s to %2$s.', $startDate, $endDate),
            'date-date'  => I18N::translateContext('Date range: date to date', 'The known dates range from %1$s to %2$s.', $startDate, $endDate),
            default      => I18N::translateContext('Date range: date to date', 'The known dates range from %1$s to %2$s.', $startDate, $endDate ?? /* I18N: This is a webtrees core date string; no module-specific translation is needed. */ I18N::translate('today')),
        };
    }
}
