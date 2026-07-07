<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily\Presentation;

use Fisharebest\Webtrees\I18N;
use Hartenthaler\Webtrees\Module\ExtendedFamily\FamilyPartCounts;

/**
 * Prepares translated family-part summary lines for the view layer.
 */
class FamilyPartSummaryPresenter
{
    /**
     * @return array<int,string>
     */
    public function summaryLines(object $extfam_obj, object $filterObj, string $filterOption, string $propName, string $summaryName): array
    {
        $familyPart = $filterObj->efp->$propName;
        $counts = $familyPart->counts;

        if ($propName === 'partners') {
            return $this->partnerSummaryLines($extfam_obj, $familyPart, $counts, $summaryName);
        }

        if ($propName === 'partner_chains') {
            return $this->partnerChainSummaryLines($extfam_obj, $familyPart, $filterOption, $counts, $summaryName);
        }

        if ($propName === 'godparents_witnesses') {
            return $this->godparentsWitnessesSummaryLines($counts, $summaryName);
        }

        $terms = $this->terms($propName);
        if ($terms === []) {
            return [];
        }

        return [$this->countSummary($counts, $terms, $summaryName)];
    }

    /**
     * @param array<string,string> $terms
     */
    private function countSummary(FamilyPartCounts $counts, array $terms, string $summaryName): string
    {
        if ($counts->allCount === 1) {
            if ($counts->femaleCount === 1) {
                return I18N::translate($terms['single_female'], $summaryName);
            }

            if ($counts->maleCount === 1) {
                return I18N::translate($terms['single_male'], $summaryName);
            }

            return I18N::translate($terms['single_other'], $summaryName);
        }

        if ($counts->femaleCount === $counts->allCount) {
            return I18N::plural($terms['female_one'], $terms['female_many'], $counts->femaleCount, $counts->femaleCount, $summaryName);
        }

        if ($counts->maleCount === $counts->allCount) {
            return I18N::plural($terms['male_one'], $terms['male_many'], $counts->maleCount, $counts->maleCount, $summaryName);
        }

        if ($counts->otherSexCount === $counts->allCount) {
            return I18N::plural($terms['other_one'], $terms['other_many'], $counts->otherSexCount, $counts->otherSexCount, $summaryName);
        }

        if ($counts->otherSexCount === 0) {
            return I18N::plural($terms['male_and_one'], $terms['male_and_many'], $counts->maleCount, $counts->maleCount, $summaryName)
                . ' '
                . I18N::plural($terms['female_total_one'], $terms['female_total_many'], $counts->femaleCount, $counts->femaleCount, $counts->allCount);
        }

        if ($counts->femaleCount === 0) {
            return I18N::plural($terms['male_and_one'], $terms['male_and_many'], $counts->maleCount, $counts->maleCount, $summaryName)
                . ' '
                . I18N::plural($terms['other_total_one'], $terms['other_total_many'], $counts->otherSexCount, $counts->otherSexCount, $counts->allCount);
        }

        if ($counts->maleCount === 0) {
            return I18N::plural($terms['female_and_one'], $terms['female_and_many'], $counts->femaleCount, $counts->femaleCount, $summaryName)
                . ' '
                . I18N::plural($terms['other_total_one'], $terms['other_total_many'], $counts->otherSexCount, $counts->otherSexCount, $counts->allCount);
        }

        return I18N::plural($terms['male_comma_one'], $terms['male_comma_many'], $counts->maleCount, $counts->maleCount, $summaryName)
            . ' '
            . I18N::plural($terms['female_comma_one'], $terms['female_comma_many'], $counts->femaleCount, $counts->femaleCount)
            . ' '
            . I18N::plural($terms['other_total_one'], $terms['other_total_many'], $counts->otherSexCount, $counts->otherSexCount, $counts->allCount);
    }

    /**
     * @return array<int,string>
     */
    private function partnerSummaryLines(object $extfam_obj, object $familyPart, FamilyPartCounts $counts, string $summaryName): array
    {
        if ($counts->allCount === 1) {
            if ($counts->femaleCount === 1) {
                return [I18N::translate('%s has one female partner recorded.', $summaryName)];
            }

            if ($counts->maleCount === 1) {
                return [I18N::translate('%s has one male partner recorded.', $summaryName)];
            }

            return [I18N::translate('%s has one partner of diverse or unknown sex recorded.', $summaryName)];
        }

        if ($familyPart->popCount === 0) {
            return [$this->countSummary($counts, $this->terms('partners'), $summaryName)];
        }

        if ($extfam_obj->proband->indi->sex() === 'M') {
            return [
                I18N::plural('%2$s has %1$d female partner and', '%2$s has %1$d female partners and', $familyPart->pfemaleCount, $familyPart->pfemaleCount, $summaryName)
                . ' '
                . I18N::plural('%d male partner of female partners recorded (%d in total).', '%d male partners of female partners recorded (%d in total).', $familyPart->popmaleCount, $familyPart->popmaleCount, $counts->allCount),
            ];
        }

        if ($extfam_obj->proband->indi->sex() === 'F') {
            return [
                I18N::plural('%2$s has %1$d male partner and', '%2$s has %1$d male partners and', $familyPart->pmaleCount, $familyPart->pmaleCount, $summaryName)
                . ' '
                . I18N::plural('%d female partner of male partners recorded (%d in total).', '%d female partners of male partners recorded (%d in total).', $familyPart->popfemaleCount, $familyPart->popfemaleCount, $counts->allCount),
            ];
        }

        return [
            I18N::plural('%2$s has %1$d partner and', '%2$s has %1$d partners and', $familyPart->pCount, $familyPart->pCount, $summaryName)
            . ' '
            . I18N::plural('%1$d partner of partners recorded (%2$d in total).', '%1$d partners of partners recorded (%2$d in total).', $familyPart->popCount, $familyPart->popCount, $counts->allCount),
        ];
    }

    /**
     * @return array<int,string>
     */
    private function partnerChainSummaryLines(object $extfam_obj, object $familyPart, string $filterOption, FamilyPartCounts $counts, string $summaryName): array
    {
        $probandSex = $extfam_obj->proband->indi->sex();
        $lines = [];

        if ($counts->femaleCount === $counts->allCount) {
            $lines[] = I18N::plural('%d female partner in this partner chain recorded', '%d female partners in this partner chain recorded', $counts->femaleCount, $counts->femaleCount)
                . ($probandSex === 'F' ? ' (' . I18N::translate('including %s', $summaryName) . ')' : '')
                . '.';
        } elseif ($counts->maleCount === $counts->allCount) {
            $lines[] = I18N::plural('%d male partner in this partner chain recorded', '%d male partners in this partner chain recorded', $counts->maleCount, $counts->maleCount)
                . ($probandSex === 'M' ? ' (' . I18N::translate('including %s', $summaryName) . ')' : '')
                . '.';
        } elseif ($counts->otherSexCount === $counts->allCount) {
            $lines[] = I18N::plural('%d partner of diverse or unknown sex in this partner chain recorded', '%d partners of diverse or unknown sex in this partner chain recorded', $counts->otherSexCount, $counts->otherSexCount)
                . ($probandSex !== 'M' && $probandSex !== 'F' ? ' (' . I18N::translate('including %s', $summaryName) . ')' : '')
                . '.';
        } elseif ($counts->otherSexCount === 0) {
            $lines[] = I18N::plural('%2$s has %1$d male partner and', '%2$s has %1$d male partners and', $counts->maleCount, $counts->maleCount, $summaryName)
                . ' '
                . I18N::plural('%1$d female partner in this partner chain recorded (%2$d in total', '%1$d female partners in this partner chain recorded (%2$d in total', $counts->femaleCount, $counts->femaleCount, $counts->allCount)
                . ($probandSex === 'M' || $probandSex === 'F' ? ', ' . I18N::translate('including %s', $summaryName) . ')' : ')')
                . '.';
        } elseif ($counts->femaleCount === 0) {
            $lines[] = I18N::plural('%2$s has %1$d male partner and', '%2$s has %1$d male partners and', $counts->maleCount, $counts->maleCount, $summaryName)
                . ' '
                . I18N::plural('%1$d partner of diverse or unknown sex in this partner chain recorded (%2$d in total', '%1$d partners of diverse or unknown sex in this partner chain recorded (%2$d in total', $counts->otherSexCount, $counts->otherSexCount, $counts->allCount)
                . ($probandSex !== 'F' ? ', ' . I18N::translate('including %s', $summaryName) . ')' : ')')
                . '.';
        } elseif ($counts->maleCount === 0) {
            $lines[] = I18N::plural('%2$s has %1$d female partner and', '%2$s has %1$d female partners and', $counts->femaleCount, $counts->femaleCount, $summaryName)
                . ' '
                . I18N::plural('%1$d partner of diverse or unknown sex in this partner chain recorded (%2$d in total', '%1$d partners of diverse or unknown sex in this partner chain recorded (%2$d in total', $counts->otherSexCount, $counts->otherSexCount, $counts->allCount)
                . ($probandSex !== 'M' ? ', ' . I18N::translate('including %s', $summaryName) . ')' : ')')
                . '.';
        } else {
            $lines[] = I18N::plural('%2$s has %1$d male partner and', '%2$s has %1$d male partners and', $counts->maleCount, $counts->maleCount, $summaryName)
                . ' '
                . I18N::plural('%d female partner, and', '%d female partners, and', $counts->femaleCount, $counts->femaleCount)
                . ' '
                . I18N::plural('%1$d partner of diverse or unknown sex in this partner chain recorded (%2$d in total, including %3$s).', '%1$d partners of diverse or unknown sex in this partner chain recorded (%2$d in total, including %3$s).', $counts->otherSexCount, $counts->otherSexCount, $counts->allCount, $summaryName);
        }

        if ($familyPart->chains->chainsCount > 1) {
            $line = I18N::translate('There are %d branches in the partner chain.', $familyPart->chains->chainsCount, $familyPart->chains->chainsCount) . ' ';
            $line .= $filterOption === 'all'
                ? I18N::translate('The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).', $familyPart->chains->longestChainCount, $familyPart->chains->mostDistantPartner->fullname(), $summaryName)
                : I18N::translate('The longest branch in the partner chain consists of %1$d partners (including %2$s).', $familyPart->chains->longestChainCount, $summaryName);
            $lines[] = $line;
        }

        return $lines;
    }

    /**
     * @return array<int,string>
     */
    private function godparentsWitnessesSummaryLines(FamilyPartCounts $counts, string $summaryName): array
    {
        if ($counts->allCount === 1) {
            return [I18N::translate('The extended family of %s has one godparent, witness, or other linked person recorded.', $summaryName)];
        }

        return [
            I18N::plural(
                'The extended family of %2$s has %1$d godparent, witness, or other linked person recorded.',
                'The extended family of %2$s has %1$d godparents, witnesses, or other linked persons recorded.',
                $counts->allCount,
                $counts->allCount,
                $summaryName
            ),
        ];
    }

    /**
     * @return array<string,string>
     */
    private function terms(string $propName): array
    {
        return self::TERMS[$propName] ?? [];
    }

    /** @var array<string,array<string,string>> */
    private const TERMS = [
        'great_grandparents' => [
            'single_female' => '%s has one great-grandmother recorded.',
            'single_male' => '%s has one great-grandfather recorded.',
            'single_other' => '%s has one great-grandparent of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d great-grandmother recorded.',
            'female_many' => '%2$s has %1$d great-grandmothers recorded.',
            'male_one' => '%2$s has %1$d great-grandfather recorded.',
            'male_many' => '%2$s has %1$d great-grandfathers recorded.',
            'other_one' => '%2$s has %1$d great-grandparent of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d great-grandparents of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d great-grandfather and',
            'male_and_many' => '%2$s has %1$d great-grandfathers and',
            'female_and_one' => '%2$s has %1$d great-grandmother and',
            'female_and_many' => '%2$s has %1$d great-grandmothers and',
            'male_comma_one' => '%2$s has %1$d great-grandfather,',
            'male_comma_many' => '%2$s has %1$d great-grandfathers,',
            'female_comma_one' => '%d great-grandmother, and',
            'female_comma_many' => '%d great-grandmothers, and',
            'female_total_one' => '%d great-grandmother recorded (%d in total).',
            'female_total_many' => '%d great-grandmothers recorded (%d in total).',
            'other_total_one' => '%d great-grandparent of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d great-grandparents of diverse or unknown sex recorded (%d in total).',
        ],
        'grandparents' => [
            'single_female' => '%s has one grandmother recorded.',
            'single_male' => '%s has one grandfather recorded.',
            'single_other' => '%s has one grandparent of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d grandmother recorded.',
            'female_many' => '%2$s has %1$d grandmothers recorded.',
            'male_one' => '%2$s has %1$d grandfather recorded.',
            'male_many' => '%2$s has %1$d grandfathers recorded.',
            'other_one' => '%2$s has %1$d grandparent of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d grandparents of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d grandfather and',
            'male_and_many' => '%2$s has %1$d grandfathers and',
            'female_and_one' => '%2$s has %1$d grandmother and',
            'female_and_many' => '%2$s has %1$d grandmothers and',
            'male_comma_one' => '%2$s has %1$d grandfather,',
            'male_comma_many' => '%2$s has %1$d grandfathers,',
            'female_comma_one' => '%d grandmother, and',
            'female_comma_many' => '%d grandmothers, and',
            'female_total_one' => '%d grandmother recorded (%d in total).',
            'female_total_many' => '%d grandmothers recorded (%d in total).',
            'other_total_one' => '%d grandparent of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d grandparents of diverse or unknown sex recorded (%d in total).',
        ],
        'grandaunts_uncles' => [
            'single_female' => '%s has one grandaunt recorded.',
            'single_male' => '%s has one granduncle recorded.',
            'single_other' => '%s has one grandaunt or granduncle of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d grandaunt recorded.',
            'female_many' => '%2$s has %1$d grandaunts recorded.',
            'male_one' => '%2$s has %1$d granduncle recorded.',
            'male_many' => '%2$s has %1$d granduncles recorded.',
            'other_one' => '%2$s has %1$d grandaunt or granduncle of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d grandaunts or granduncles of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d granduncle and',
            'male_and_many' => '%2$s has %1$d granduncles and',
            'female_and_one' => '%2$s has %1$d grandaunt and',
            'female_and_many' => '%2$s has %1$d grandaunts and',
            'male_comma_one' => '%2$s has %1$d granduncle,',
            'male_comma_many' => '%2$s has %1$d granduncles,',
            'female_comma_one' => '%d grandaunt, and',
            'female_comma_many' => '%d grandaunts, and',
            'female_total_one' => '%d grandaunt recorded (%d in total).',
            'female_total_many' => '%d grandaunts recorded (%d in total).',
            'other_total_one' => '%d grandaunt or granduncle of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d grandaunts or granduncles of diverse or unknown sex recorded (%d in total).',
        ],
        'uncles_and_aunts' => [
            'single_female' => '%s has one aunt recorded.',
            'single_male' => '%s has one uncle recorded.',
            'single_other' => '%s has one uncle or aunt of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d aunt recorded.',
            'female_many' => '%2$s has %1$d aunts recorded.',
            'male_one' => '%2$s has %1$d uncle recorded.',
            'male_many' => '%2$s has %1$d uncles recorded.',
            'other_one' => '%2$s has %1$d uncle or aunt of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d uncles or aunts of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d uncle and',
            'male_and_many' => '%2$s has %1$d uncles and',
            'female_and_one' => '%2$s has %1$d aunt and',
            'female_and_many' => '%2$s has %1$d aunts and',
            'male_comma_one' => '%2$s has %1$d uncle,',
            'male_comma_many' => '%2$s has %1$d uncles,',
            'female_comma_one' => '%d aunt, and',
            'female_comma_many' => '%d aunts, and',
            'female_total_one' => '%d aunt recorded (%d in total).',
            'female_total_many' => '%d aunts recorded (%d in total).',
            'other_total_one' => '%d uncle or aunt of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d uncles or aunts of diverse or unknown sex recorded (%d in total).',
        ],
        'uncles_and_aunts_bm' => [
            'single_female' => '%s has one aunt by marriage recorded.',
            'single_male' => '%s has one uncle by marriage recorded.',
            'single_other' => '%s has one uncle or aunt by marriage of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d aunt by marriage recorded.',
            'female_many' => '%2$s has %1$d aunts by marriage recorded.',
            'male_one' => '%2$s has %1$d uncle by marriage recorded.',
            'male_many' => '%2$s has %1$d uncles by marriage recorded.',
            'other_one' => '%2$s has %1$d uncle or aunt by marriage of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d uncles or aunts by marriage of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d uncle by marriage and',
            'male_and_many' => '%2$s has %1$d uncles by marriage and',
            'female_and_one' => '%2$s has %1$d aunt by marriage and',
            'female_and_many' => '%2$s has %1$d aunts by marriage and',
            'male_comma_one' => '%2$s has %1$d uncle by marriage,',
            'male_comma_many' => '%2$s has %1$d uncles by marriage,',
            'female_comma_one' => '%d aunt by marriage, and',
            'female_comma_many' => '%d aunts by marriage, and',
            'female_total_one' => '%d aunt by marriage recorded (%d in total).',
            'female_total_many' => '%d aunts by marriage recorded (%d in total).',
            'other_total_one' => '%d uncle or aunt by marriage of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d uncles or aunts by marriage of diverse or unknown sex recorded (%d in total).',
        ],
        'parents' => [
            'single_female' => '%s has one mother recorded.',
            'single_male' => '%s has one father recorded.',
            'single_other' => '%s has one parent of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d mother recorded.',
            'female_many' => '%2$s has %1$d mothers recorded.',
            'male_one' => '%2$s has %1$d father recorded.',
            'male_many' => '%2$s has %1$d fathers recorded.',
            'other_one' => '%2$s has %1$d parent of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d parents of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d father and',
            'male_and_many' => '%2$s has %1$d fathers and',
            'female_and_one' => '%2$s has %1$d mother and',
            'female_and_many' => '%2$s has %1$d mothers and',
            'male_comma_one' => '%2$s has %1$d father,',
            'male_comma_many' => '%2$s has %1$d fathers,',
            'female_comma_one' => '%d mother, and',
            'female_comma_many' => '%d mothers, and',
            'female_total_one' => '%d mother recorded (%d in total).',
            'female_total_many' => '%d mothers recorded (%d in total).',
            'other_total_one' => '%d parent of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d parents of diverse or unknown sex recorded (%d in total).',
        ],
        'parents_in_law' => [
            'single_female' => '%s has one mother-in-law recorded.',
            'single_male' => '%s has one father-in-law recorded.',
            'single_other' => '%s has one parent-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d mother-in-law recorded.',
            'female_many' => '%2$s has %1$d mothers-in-law recorded.',
            'male_one' => '%2$s has %1$d father-in-law recorded.',
            'male_many' => '%2$s has %1$d fathers-in-law recorded.',
            'other_one' => '%2$s has %1$d parent-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d parents-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d father-in-law and',
            'male_and_many' => '%2$s has %1$d fathers-in-law and',
            'female_and_one' => '%2$s has %1$d mother-in-law and',
            'female_and_many' => '%2$s has %1$d mothers-in-law and',
            'male_comma_one' => '%2$s has %1$d father-in-law,',
            'male_comma_many' => '%2$s has %1$d fathers-in-law,',
            'female_comma_one' => '%d mother-in-law, and',
            'female_comma_many' => '%d mothers-in-law, and',
            'female_total_one' => '%d mother-in-law recorded (%d in total).',
            'female_total_many' => '%d mothers-in-law recorded (%d in total).',
            'other_total_one' => '%d parent-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d parents-in-law of diverse or unknown sex recorded (%d in total).',
        ],
        'co_parents_in_law' => [
            'single_female' => '%s has one co-mother-in-law recorded.',
            'single_male' => '%s has one co-father-in-law recorded.',
            'single_other' => '%s has one co-parent-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d co-mother-in-law recorded.',
            'female_many' => '%2$s has %1$d co-mothers-in-law recorded.',
            'male_one' => '%2$s has %1$d co-father-in-law recorded.',
            'male_many' => '%2$s has %1$d co-fathers-in-law recorded.',
            'other_one' => '%2$s has %1$d co-parent-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d co-parents-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d co-father-in-law and',
            'male_and_many' => '%2$s has %1$d co-fathers-in-law and',
            'female_and_one' => '%2$s has %1$d co-mother-in-law and',
            'female_and_many' => '%2$s has %1$d co-mothers-in-law and',
            'male_comma_one' => '%2$s has %1$d co-father-in-law,',
            'male_comma_many' => '%2$s has %1$d co-fathers-in-law,',
            'female_comma_one' => '%d co-mother-in-law, and',
            'female_comma_many' => '%d co-mothers-in-law, and',
            'female_total_one' => '%d co-mother-in-law recorded (%d in total).',
            'female_total_many' => '%d co-mothers-in-law recorded (%d in total).',
            'other_total_one' => '%d co-parent-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d co-parents-in-law of diverse or unknown sex recorded (%d in total).',
        ],
        'partners' => [
            'single_female' => '%s has one female partner recorded.',
            'single_male' => '%s has one male partner recorded.',
            'single_other' => '%s has one partner of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d female partner recorded.',
            'female_many' => '%2$s has %1$d female partners recorded.',
            'male_one' => '%2$s has %1$d male partner recorded.',
            'male_many' => '%2$s has %1$d male partners recorded.',
            'other_one' => '%2$s has %1$d partner of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d partners of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d male partner and',
            'male_and_many' => '%2$s has %1$d male partners and',
            'female_and_one' => '%2$s has %1$d female partner and',
            'female_and_many' => '%2$s has %1$d female partners and',
            'male_comma_one' => '%2$s has %1$d male partner,',
            'male_comma_many' => '%2$s has %1$d male partners,',
            'female_comma_one' => '%d female partner, and',
            'female_comma_many' => '%d female partners, and',
            'female_total_one' => '%d female partner recorded (%d in total).',
            'female_total_many' => '%d female partners recorded (%d in total).',
            'other_total_one' => '%d partner of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d partners of diverse or unknown sex recorded (%d in total).',
        ],
        'siblings' => [
            'single_female' => '%s has one sister recorded.',
            'single_male' => '%s has one brother recorded.',
            'single_other' => '%s has one sibling of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d sister recorded.',
            'female_many' => '%2$s has %1$d sisters recorded.',
            'male_one' => '%2$s has %1$d brother recorded.',
            'male_many' => '%2$s has %1$d brothers recorded.',
            'other_one' => '%2$s has %1$d sibling of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d siblings of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d brother and',
            'male_and_many' => '%2$s has %1$d brothers and',
            'female_and_one' => '%2$s has %1$d sister and',
            'female_and_many' => '%2$s has %1$d sisters and',
            'male_comma_one' => '%2$s has %1$d brother,',
            'male_comma_many' => '%2$s has %1$d brothers,',
            'female_comma_one' => '%d sister, and',
            'female_comma_many' => '%d sisters, and',
            'female_total_one' => '%d sister recorded (%d in total).',
            'female_total_many' => '%d sisters recorded (%d in total).',
            'other_total_one' => '%d sibling of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d siblings of diverse or unknown sex recorded (%d in total).',
        ],
        'siblings_in_law' => [
            'single_female' => '%s has one sister-in-law recorded.',
            'single_male' => '%s has one brother-in-law recorded.',
            'single_other' => '%s has one sibling-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d sister-in-law recorded.',
            'female_many' => '%2$s has %1$d sisters-in-law recorded.',
            'male_one' => '%2$s has %1$d brother-in-law recorded.',
            'male_many' => '%2$s has %1$d brothers-in-law recorded.',
            'other_one' => '%2$s has %1$d sibling-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d siblings-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d brother-in-law and',
            'male_and_many' => '%2$s has %1$d brothers-in-law and',
            'female_and_one' => '%2$s has %1$d sister-in-law and',
            'female_and_many' => '%2$s has %1$d sisters-in-law and',
            'male_comma_one' => '%2$s has %1$d brother-in-law,',
            'male_comma_many' => '%2$s has %1$d brothers-in-law,',
            'female_comma_one' => '%d sister-in-law, and',
            'female_comma_many' => '%d sisters-in-law, and',
            'female_total_one' => '%d sister-in-law recorded (%d in total).',
            'female_total_many' => '%d sisters-in-law recorded (%d in total).',
            'other_total_one' => '%d sibling-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d siblings-in-law of diverse or unknown sex recorded (%d in total).',
        ],
        'co_siblings_in_law' => [
            'single_female' => '%s has one co-sister-in-law recorded.',
            'single_male' => '%s has one co-brother-in-law recorded.',
            'single_other' => '%s has one co-sibling-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d co-sister-in-law recorded.',
            'female_many' => '%2$s has %1$d co-sisters-in-law recorded.',
            'male_one' => '%2$s has %1$d co-brother-in-law recorded.',
            'male_many' => '%2$s has %1$d co-brothers-in-law recorded.',
            'other_one' => '%2$s has %1$d co-sibling-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d co-siblings-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d co-brother-in-law and',
            'male_and_many' => '%2$s has %1$d co-brothers-in-law and',
            'female_and_one' => '%2$s has %1$d co-sister-in-law and',
            'female_and_many' => '%2$s has %1$d co-sisters-in-law and',
            'male_comma_one' => '%2$s has %1$d co-brother-in-law,',
            'male_comma_many' => '%2$s has %1$d co-brothers-in-law,',
            'female_comma_one' => '%d co-sister-in-law, and',
            'female_comma_many' => '%d co-sisters-in-law, and',
            'female_total_one' => '%d co-sister-in-law recorded (%d in total).',
            'female_total_many' => '%d co-sisters-in-law recorded (%d in total).',
            'other_total_one' => '%d co-sibling-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d co-siblings-in-law of diverse or unknown sex recorded (%d in total).',
        ],
        'cousins' => [
            'single_female' => '%s has one female first cousin recorded.',
            'single_male' => '%s has one male first cousin recorded.',
            'single_other' => '%s has one first cousin of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d female first cousin recorded.',
            'female_many' => '%2$s has %1$d female first cousins recorded.',
            'male_one' => '%2$s has %1$d male first cousin recorded.',
            'male_many' => '%2$s has %1$d male first cousins recorded.',
            'other_one' => '%2$s has %1$d first cousin of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d first cousins of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d male first cousin and',
            'male_and_many' => '%2$s has %1$d male first cousins and',
            'female_and_one' => '%2$s has %1$d female first cousin and',
            'female_and_many' => '%2$s has %1$d female first cousins and',
            'male_comma_one' => '%2$s has %1$d male first cousin,',
            'male_comma_many' => '%2$s has %1$d male first cousins,',
            'female_comma_one' => '%d female first cousin, and',
            'female_comma_many' => '%d female first cousins, and',
            'female_total_one' => '%d female first cousin recorded (%d in total).',
            'female_total_many' => '%d female first cousins recorded (%d in total).',
            'other_total_one' => '%d first cousin of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d first cousins of diverse or unknown sex recorded (%d in total).',
        ],
        'nephews_and_nieces' => [
            'single_female' => '%s has one niece recorded.',
            'single_male' => '%s has one nephew recorded.',
            'single_other' => '%s has one nephew or niece of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d niece recorded.',
            'female_many' => '%2$s has %1$d nieces recorded.',
            'male_one' => '%2$s has %1$d nephew recorded.',
            'male_many' => '%2$s has %1$d nephews recorded.',
            'other_one' => '%2$s has %1$d nephew or niece of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d nephews or nieces of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d nephew and',
            'male_and_many' => '%2$s has %1$d nephews and',
            'female_and_one' => '%2$s has %1$d niece and',
            'female_and_many' => '%2$s has %1$d nieces and',
            'male_comma_one' => '%2$s has %1$d nephew,',
            'male_comma_many' => '%2$s has %1$d nephews,',
            'female_comma_one' => '%d niece, and',
            'female_comma_many' => '%d nieces, and',
            'female_total_one' => '%d niece recorded (%d in total).',
            'female_total_many' => '%d nieces recorded (%d in total).',
            'other_total_one' => '%d nephew or niece of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d nephews or nieces of diverse or unknown sex recorded (%d in total).',
        ],
        'grandnephews_nieces' => [
            'single_female' => '%s has one grandniece recorded.',
            'single_male' => '%s has one grandnephew recorded.',
            'single_other' => '%s has one grandnephew or grandniece of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d grandniece recorded.',
            'female_many' => '%2$s has %1$d grandnieces recorded.',
            'male_one' => '%2$s has %1$d grandnephew recorded.',
            'male_many' => '%2$s has %1$d grandnephews recorded.',
            'other_one' => '%2$s has %1$d grandnephew or grandniece of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d grandnephews or grandnieces of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d grandnephew and',
            'male_and_many' => '%2$s has %1$d grandnephews and',
            'female_and_one' => '%2$s has %1$d grandniece and',
            'female_and_many' => '%2$s has %1$d grandnieces and',
            'male_comma_one' => '%2$s has %1$d grandnephew,',
            'male_comma_many' => '%2$s has %1$d grandnephews,',
            'female_comma_one' => '%d grandniece, and',
            'female_comma_many' => '%d grandnieces, and',
            'female_total_one' => '%d grandniece recorded (%d in total).',
            'female_total_many' => '%d grandnieces recorded (%d in total).',
            'other_total_one' => '%d grandnephew or grandniece of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d grandnephews or grandnieces of diverse or unknown sex recorded (%d in total).',
        ],
        'children' => [
            'single_female' => '%s has one daughter recorded.',
            'single_male' => '%s has one son recorded.',
            'single_other' => '%s has one child of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d daughter recorded.',
            'female_many' => '%2$s has %1$d daughters recorded.',
            'male_one' => '%2$s has %1$d son recorded.',
            'male_many' => '%2$s has %1$d sons recorded.',
            'other_one' => '%2$s has %1$d child of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d children of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d son and',
            'male_and_many' => '%2$s has %1$d sons and',
            'female_and_one' => '%2$s has %1$d daughter and',
            'female_and_many' => '%2$s has %1$d daughters and',
            'male_comma_one' => '%2$s has %1$d son,',
            'male_comma_many' => '%2$s has %1$d sons,',
            'female_comma_one' => '%d daughter, and',
            'female_comma_many' => '%d daughters, and',
            'female_total_one' => '%d daughter recorded (%d in total).',
            'female_total_many' => '%d daughters recorded (%d in total).',
            'other_total_one' => '%d child of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d children of diverse or unknown sex recorded (%d in total).',
        ],
        'children_in_law' => [
            'single_female' => '%s has one daughter-in-law recorded.',
            'single_male' => '%s has one son-in-law recorded.',
            'single_other' => '%s has one child-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d daughter-in-law recorded.',
            'female_many' => '%2$s has %1$d daughters-in-law recorded.',
            'male_one' => '%2$s has %1$d son-in-law recorded.',
            'male_many' => '%2$s has %1$d sons-in-law recorded.',
            'other_one' => '%2$s has %1$d child-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d children-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d son-in-law and',
            'male_and_many' => '%2$s has %1$d sons-in-law and',
            'female_and_one' => '%2$s has %1$d daughter-in-law and',
            'female_and_many' => '%2$s has %1$d daughters-in-law and',
            'male_comma_one' => '%2$s has %1$d son-in-law,',
            'male_comma_many' => '%2$s has %1$d sons-in-law,',
            'female_comma_one' => '%d daughter-in-law, and',
            'female_comma_many' => '%d daughters-in-law, and',
            'female_total_one' => '%d daughter-in-law recorded (%d in total).',
            'female_total_many' => '%d daughters-in-law recorded (%d in total).',
            'other_total_one' => '%d child-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d children-in-law of diverse or unknown sex recorded (%d in total).',
        ],
        'grandchildren' => [
            'single_female' => '%s has one granddaughter recorded.',
            'single_male' => '%s has one grandson recorded.',
            'single_other' => '%s has one grandchild of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d granddaughter recorded.',
            'female_many' => '%2$s has %1$d granddaughters recorded.',
            'male_one' => '%2$s has %1$d grandson recorded.',
            'male_many' => '%2$s has %1$d grandsons recorded.',
            'other_one' => '%2$s has %1$d grandchild of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d grandchildren of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d grandson and',
            'male_and_many' => '%2$s has %1$d grandsons and',
            'female_and_one' => '%2$s has %1$d granddaughter and',
            'female_and_many' => '%2$s has %1$d granddaughters and',
            'male_comma_one' => '%2$s has %1$d grandson,',
            'male_comma_many' => '%2$s has %1$d grandsons,',
            'female_comma_one' => '%d granddaughter, and',
            'female_comma_many' => '%d granddaughters, and',
            'female_total_one' => '%d granddaughter recorded (%d in total).',
            'female_total_many' => '%d granddaughters recorded (%d in total).',
            'other_total_one' => '%d grandchild of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d grandchildren of diverse or unknown sex recorded (%d in total).',
        ],
        'great_grandchildren' => [
            'single_female' => '%s has one great-granddaughter recorded.',
            'single_male' => '%s has one great-grandson recorded.',
            'single_other' => '%s has one great-grandchild of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d great-granddaughter recorded.',
            'female_many' => '%2$s has %1$d great-granddaughters recorded.',
            'male_one' => '%2$s has %1$d great-grandson recorded.',
            'male_many' => '%2$s has %1$d great-grandsons recorded.',
            'other_one' => '%2$s has %1$d great-grandchild of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d great-grandchildren of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d great-grandson and',
            'male_and_many' => '%2$s has %1$d great-grandsons and',
            'female_and_one' => '%2$s has %1$d great-granddaughter and',
            'female_and_many' => '%2$s has %1$d great-granddaughters and',
            'male_comma_one' => '%2$s has %1$d great-grandson,',
            'male_comma_many' => '%2$s has %1$d great-grandsons,',
            'female_comma_one' => '%d great-granddaughter, and',
            'female_comma_many' => '%d great-granddaughters, and',
            'female_total_one' => '%d great-granddaughter recorded (%d in total).',
            'female_total_many' => '%d great-granddaughters recorded (%d in total).',
            'other_total_one' => '%d great-grandchild of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d great-grandchildren of diverse or unknown sex recorded (%d in total).',
        ],
        'grandchildren_in_law' => [
            'single_female' => '%s has one granddaughter-in-law recorded.',
            'single_male' => '%s has one grandson-in-law recorded.',
            'single_other' => '%s has one grandchild-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d granddaughter-in-law recorded.',
            'female_many' => '%2$s has %1$d granddaughters-in-law recorded.',
            'male_one' => '%2$s has %1$d grandson-in-law recorded.',
            'male_many' => '%2$s has %1$d grandsons-in-law recorded.',
            'other_one' => '%2$s has %1$d grandchild-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d grandchildren-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d grandson-in-law and',
            'male_and_many' => '%2$s has %1$d grandsons-in-law and',
            'female_and_one' => '%2$s has %1$d granddaughter-in-law and',
            'female_and_many' => '%2$s has %1$d granddaughters-in-law and',
            'male_comma_one' => '%2$s has %1$d grandson-in-law,',
            'male_comma_many' => '%2$s has %1$d grandsons-in-law,',
            'female_comma_one' => '%d granddaughter-in-law, and',
            'female_comma_many' => '%d granddaughters-in-law, and',
            'female_total_one' => '%d granddaughter-in-law recorded (%d in total).',
            'female_total_many' => '%d granddaughters-in-law recorded (%d in total).',
            'other_total_one' => '%d grandchild-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d grandchildren-in-law of diverse or unknown sex recorded (%d in total).',
        ],
        'great_grandchild_in_law' => [
            'single_female' => '%s has one great-granddaughter-in-law recorded.',
            'single_male' => '%s has one great-grandson-in-law recorded.',
            'single_other' => '%s has one great-grandchild-in-law of diverse or unknown sex recorded.',
            'female_one' => '%2$s has %1$d great-granddaughter-in-law recorded.',
            'female_many' => '%2$s has %1$d great-granddaughters-in-law recorded.',
            'male_one' => '%2$s has %1$d great-grandson-in-law recorded.',
            'male_many' => '%2$s has %1$d great-grandsons-in-law recorded.',
            'other_one' => '%2$s has %1$d great-grandchild-in-law of diverse or unknown sex recorded.',
            'other_many' => '%2$s has %1$d great-grandchildren-in-law of diverse or unknown sex recorded.',
            'male_and_one' => '%2$s has %1$d great-grandson-in-law and',
            'male_and_many' => '%2$s has %1$d great-grandsons-in-law and',
            'female_and_one' => '%2$s has %1$d great-granddaughter-in-law and',
            'female_and_many' => '%2$s has %1$d great-granddaughters-in-law and',
            'male_comma_one' => '%2$s has %1$d great-grandson-in-law,',
            'male_comma_many' => '%2$s has %1$d great-grandsons-in-law,',
            'female_comma_one' => '%d great-granddaughter-in-law, and',
            'female_comma_many' => '%d great-granddaughters-in-law, and',
            'female_total_one' => '%d great-granddaughter-in-law recorded (%d in total).',
            'female_total_many' => '%d great-granddaughters-in-law recorded (%d in total).',
            'other_total_one' => '%d great-grandchild-in-law of diverse or unknown sex recorded (%d in total).',
            'other_total_many' => '%d great-grandchildren-in-law of diverse or unknown sex recorded (%d in total).',
        ],
    ];
}
