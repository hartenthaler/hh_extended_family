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

use Fisharebest\Webtrees\Individual;

require_once(__DIR__ . '/src/Factory/ExtendedFamilyPartFactory.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyPart.php');

require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Great_grandparents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandparents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts_bm.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partners.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partner_chains.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Cousins.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Nephews_and_nieces.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandchildren.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Great_grandchildren.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Great_grandchild_in_law.php');

/**
 * class ExtendedFamilyPersonExists
 * to check in an efficient way if there exists at least one person in one of
 * the selected extended family parts of the proband
 * (used in the function to decide if the tab has to be grayed out)
 */
class ExtendedFamilyPersonExists extends ExtendedFamily
{
    /**
     * Efficient check order for family parts.
     *
     * Close direct relationships are checked first. More expensive or derived
     * parts, such as cousins and partner chains, are checked later.
     */
    private const EXISTENCE_CHECK_ORDER = [
        'parents',
        'children',
        'partners',
        'siblings',
        'grandparents',
        'grandchildren',
        'parents_in_law',
        'children_in_law',
        'siblings_in_law',
        'co_parents_in_law',
        'co_siblings_in_law',
        'uncles_and_aunts',
        'uncles_and_aunts_bm',
        'nephews_and_nieces',
        'cousins',
        'great_grandparents',
        'great_grandchildren',
        'grandchildren_in_law',
        'great_grandchild_in_law',
        'partner_chains',
    ];

    /**
     * @var bool $found
     */
    public $found;

    /**
     * constructor for this class
     *
     * @param Individual $proband the proband for whom the extended family members are searched
     * @param object $config configuration parameters for this extended family
     */
    public function __construct(Individual $proband, object $config)
    {
        $this->constructConfig($config);
        $this->constructProband($proband);
        $this->found = $this->constructCheck();
    }

    /**
     * build extended family parts, but stop as soon as a person is found in one of the extended family parts
     *
     * @return bool
     */
    private function constructCheck(): bool
    {
        foreach ($this->orderedShownFamilyParts() as $efp => $element) {
            if ($element->enabled) {
                if (ExtendedFamilyPartFactory::create(ucfirst($efp),
                                                      $this->proband->indi,
                                                      'all',
                                                      $this->config->placeFormat)
                        ->getEfpObject()->allCount > 0) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Return the selected family parts in an efficient order for existence checks.
     *
     * @return array<string,object>
     */
    private function orderedShownFamilyParts(): array
    {
        $shownFamilyParts = $this->config->shownFamilyParts;
        $priority         = array_flip(self::EXISTENCE_CHECK_ORDER);

        uksort($shownFamilyParts, static function (string $left, string $right) use ($priority): int {
            return ($priority[$left] ?? PHP_INT_MAX) <=> ($priority[$right] ?? PHP_INT_MAX);
        });

        return $shownFamilyParts;
    }

    /**
     * provide value of $found
     *
     * @return bool
     */
    public function found(): bool
    {
        return $this->found;
    }
}
