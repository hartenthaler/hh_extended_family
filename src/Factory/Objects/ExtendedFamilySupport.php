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
use function str_replace;
use function strtolower;
use function str_contains;  // will be added in PHP 8.0, at the moment part of the framework
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
            'great_grandchildren'    => ['generation' => -3, 'relationshipCoefficient' => 0.125, 'relationshipCoefficientComment' => Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIOLOGICAL],
            'grandchildren_in_law'   => ['generation' => -2, 'relationshipCoefficient' => 0],
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
     * @return array of string
     */
    private static function getFilterOptionsSex(): array
    {
        return [
            'M',
            'F',
            'U',    // used for sex = "X" (other) and sex ="U" (unknown)
        ];
    }

    /**
     * get list of options to filter by alive/dead
     *
     * @return array of string
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
     * @return array of string
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
     * @return array of string [sex, alive]
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
     * @return array of string with child labels
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
            // $label = ExtendedFamilySupport::getPedigreeValue($match[1], $individual); // aus dem alten Code - Funktion getPedigreeValue kann wohl weg
        }
        return $label;
    }

    /**
     * Translate a pedigree code, for a record
     * This is a copy of a webtrees 1 function
     *
     * @param string $type
     * @param Individual $individual
     * @return string
     */
    private static function getPedigreeValue(string $type, Individual $individual): string
    {
        $sex = $individual->sex();

        switch (strtoupper($type)) {
            case 'BIRTH':
                if ($sex === 'M') {
                    return I18N::translateContext('Male pedigree', 'Birth');
                } elseif ($sex === 'F') {
                    return I18N::translateContext('Female pedigree', 'Birth');
                } else {
                    return I18N::translateContext('Pedigree', 'Birth');
                }

            case 'ADOPTED':
                if ($sex === 'M') {
                    return I18N::translateContext('Male pedigree', 'Adopted');
                } elseif ($sex === 'F') {
                    return I18N::translateContext('Female pedigree', 'Adopted');
                } else {
                    return I18N::translateContext('Pedigree', 'Adopted');
                }

            case 'FOSTER':
                if ($sex === 'M') {
                    return I18N::translateContext('Male pedigree', 'Foster');
                } elseif ($sex === 'F') {
                    return I18N::translateContext('Female pedigree', 'Foster');
                } else {
                    return I18N::translateContext('Pedigree', 'Foster');
                }

            case 'SEALING':
                if ($sex === 'M') {
                    /* I18N: “sealing” is a ceremony in the Mormon church. */
                    return I18N::translateContext('Male pedigree', 'Sealing');
                } elseif ($sex === 'F') {
                    /* I18N: “sealing” is a ceremony in the Mormon church. */
                    return I18N::translateContext('Female pedigree', 'Sealing');
                } else {
                    /* I18N: “sealing” is a ceremony in the Mormon church. */
                    return I18N::translateContext('Pedigree', 'Sealing');
                }

            case 'RADA':
                // Not standard GEDCOM - a webtrees extension
                // This is an arabic word which does not exist in other languages.
                // So, it will not have any inflected forms.
                /* I18N: This is an Arabic word, pronounced “ra DAH”. It is child-to-parent pedigree, established by wet-nursing. */
                return I18N::translate('Rada');
            default:
                return $type;
        }
    }

    /**
     * tbd: switch to uppercase labels
     * generate a child linkage status label [challenged | disproven | proven]
     * GEDCOM record is for example ""
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
                        return I18N::translate('linkage challenged');

                    case 'disproven':
                        return I18N::translate('linkage disproven');

                    case 'proven':
                        return I18N::translate('linkage proven');
                }
            }
        }
        return '';
    }
    /**
     * tbd: switch to uppercase labels
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
            if (in_array(strtolower($match[1]), $multipleBirth)) {
                return I18N::translate(strtolower($match[1]));
            }
        }
        return '';
    }

    /**
     * tbd: switch to uppercase labels
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
            return I18N::translate('stillborn');
        }        
        if (preg_match('/\n2 AGE INFANT/i', $childGedcom, $match)) {
            return I18N::translate('died as infant');
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
            self::FAM_STATUS_EX          => I18N::translate(self::FAM_STATUS_DIVORCED),
            self::FAM_STATUS_MARRIAGE    => I18N::translate(self::FAM_STATUS_MARRIED),
            self::FAM_STATUS_FIANCEE     => I18N::translate(self::FAM_STATUS_ENGAGED),
            self::FAM_STATUS_PARTNERSHIP => I18N::translate(self::FAM_STATUS_PARTNERS),
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
            self::FAM_STATUS_EX          => I18N::translate(self::FAM_STATUS_DIVORCED_PARTNER),
            self::FAM_STATUS_MARRIAGE    => I18N::translate(self::FAM_STATUS_MARRIED_PARTNER),
            self::FAM_STATUS_FIANCEE     => I18N::translate(self::FAM_STATUS_ENGAGED_PARTNER),
            self::FAM_STATUS_PARTNERSHIP => I18N::translate(self::FAM_STATUS_PARTNER),
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
        switch ($type) {
            case 'uncles_and_aunts':
                return I18N::translate('Uncles and Aunts');
            case 'uncles_and_aunts_bm':
                return I18N::translate('Uncles and Aunts by marriage');
            case 'partner_chains':
                return I18N::translate('Partner chains');
            case 'nephews_and_nieces':
                return I18N::translate('Nephews and Nieces');
            default:
                return I18N::translate(ucfirst(str_replace('_', '-', $type)));
        }
    }
}
