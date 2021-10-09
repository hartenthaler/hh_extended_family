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
 * class Siblings
 *
 * data and methods for extended family part "siblings", as full and half siblings, and stepsiblings
 */
class Siblings extends ExtendedFamilyPart
{
    public const GROUP_SIBLINGS_FULL = 'Full siblings';
    public const GROUP_SIBLINGS_HALF = 'Half siblings';                         // including more than half siblings (if parents are related to each other)
    public const GROUP_SIBLINGS_STEP = 'Stepsiblings';

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
        foreach ($this->getProband()->childFamilies() as $family) {                                 // Gen  1 F
            foreach ($family->children() as $sibling_full) {                                    // Gen  0 P
                if ($sibling_full->xref() !== $this->getProband()->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($sibling_full, $family), self::GROUP_SIBLINGS_FULL);
                }
            }
        }
        foreach ($this->getProband()->childFamilies() as $family1) {                                // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling_half) {                           // Gen  0 P
                        if ($sibling_half->xref() !== $this->getProband()->xref()) {
                            $this->addIndividualToFamily(new IndividualFamily($sibling_half, $family1), self::GROUP_SIBLINGS_HALF);
                        }
                    }
                }
            }
        }
        foreach ($this->getProband()->childFamilies() as $family1) {                                // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->spouses() as $spouse2) {                                 // Gen  1 P
                        foreach ($spouse2->spouseFamilies() as $family3) {                      // Gen  1 F
                            foreach ($family3->children() as $sibling_step) {                   // Gen  0 P
                                if ($sibling_step->xref() !== $this->getProband()->xref()) {
                                    $this->addIndividualToFamily(new IndividualFamily($sibling_step, $family1), self::GROUP_SIBLINGS_STEP);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
