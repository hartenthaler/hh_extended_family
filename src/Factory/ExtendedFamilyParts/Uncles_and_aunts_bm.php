<?php
/*
 * webtrees - extended family parts
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

/* tbd
 *
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * class Uncles_and_aunts_bm
 *
 * data and methods for extended family part "uncles_and_aunts_bm" as uncles and aunts by marriage
 */
class Uncles_and_aunts_bm extends ExtendedFamilyPart
{
    public const GROUP_UNCLEAUNTBM_FATHER = 'Siblings-in-law of father';
    public const GROUP_UNCLEAUNTBM_MOTHER = 'Siblings-in-law of mother';

    /**
     * @var object $_efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->members[]           array of Individual (index of groups is groupName)
     *            ->labels[]            array of array of string
     *            ->families[]          array of object
     *            ->familiesStatus[]    string
     *            ->referencePersons[]  array of array of Individual
     *            ->groupName           string
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject
     */
    protected function addEfpMembers()
    {
        if ($this->getProband()->childFamilies()->first()) {
            if ($this->getProband()->childFamilies()->first()->husband() instanceof Individual) {
                $this->addUnclesAndAuntsBmOneSide($this->getProband()->childFamilies()->first()->husband(), self::GROUP_UNCLEAUNTBM_FATHER);
            }
            if ($this->getProband()->childFamilies()->first()->wife() instanceof Individual) {
                $this->addUnclesAndAuntsBmOneSide($this->getProband()->childFamilies()->first()->wife(), self::GROUP_UNCLEAUNTBM_MOTHER);
            }
        }
    }

    /**
     * Find uncles and aunts by marriage for one side
     *
     * @param Individual $parent
     * @param string $side family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father side is default
     */
    private function addUnclesAndAuntsBmOneSide(Individual $parent, string $side)
    {
        foreach ($parent->childFamilies() as $family1) {                                // Gen 2 F
            foreach ($family1->spouses() as $grandparent) {                             // Gen 2 P
                foreach ($grandparent->spouseFamilies() as $family2) {                  // Gen 2 F
                    foreach ($family2->children() as $uncleaunt) {                      // Gen 1 P
                        if($uncleaunt->xref() !== $parent->xref()) {
                            foreach ($uncleaunt->spouseFamilies() as $family3) {        // Gen 1 F
                                foreach ($family3->spouses() as $uncleaunt2) {          // Gen 1 P
                                    if($uncleaunt2->xref() !== $uncleaunt->xref()) {
                                        $this->addIndividualToFamily(new IndividualFamily($uncleaunt2, $family3, $uncleaunt), $side);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
