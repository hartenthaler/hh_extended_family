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
 * class Uncles_and_aunts
 *
 * data and methods for extended family part "uncles_and_aunts" (not including uncles and aunts by marriage)
 */
class Uncles_and_aunts extends ExtendedFamilyPart
{
    public const GROUP_UNCLEAUNT_FATHER  = 'Siblings of father';
    public const GROUP_UNCLEAUNT_MOTHER  = 'Siblings of mother';

    public const GROUP_UNCLEAUNT_FULL_BIO  = 'Full siblings of biological parents';

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
                $this->addUnclesAndAuntsOneSide( $this->getProband()->childFamilies()->first()->husband(), self::GROUP_UNCLEAUNT_FATHER);
            }
            if ($this->getProband()->childFamilies()->first()->wife() instanceof Individual) {
                $this->addUnclesAndAuntsOneSide($this->getProband()->childFamilies()->first()->wife(), self::GROUP_UNCLEAUNT_MOTHER);
            }
        }
    }

    /**
     * Find uncles and aunts for one side (husband/wife) (only full siblings and not including uncles and aunts by marriage)
     *
     * @param Individual $parent
     * @param string $side  family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function addUnclesAndAuntsOneSide(Individual $parent, string $side)
    {
        foreach ($parent->childFamilies() as $family1) {                             // Gen 2 F
            foreach ($family1->spouses() as $grandparent) {                          // Gen 2 P
                foreach ($grandparent->spouseFamilies() as $family2) {               // Gen 2 F
                    foreach ($family2->children() as $uncleaunt) {                   // Gen 1 P
                        if($uncleaunt->xref() !== $parent->xref()) {
                            $this->addIndividualToFamily(new IndividualFamily($uncleaunt, $family2, $parent), $side);
                        }
                    }
                }
            }
        }
    }
}
