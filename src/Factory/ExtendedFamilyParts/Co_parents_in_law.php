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
 * class Co_parents_in_law
 *
 * data and methods for extended family part "co_parents_in_law" (parents of children-in-law)
 */
class Co_parents_in_law extends ExtendedFamilyPart
{
    public const GROUP_COPARENTSINLAW_BIO  = 'Parents-in-law of biological children';
    public const GROUP_COPARENTSINLAW_STEP = 'Parents-in-law of stepchildren';

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
        foreach ($this->getProband()->spouseFamilies() as $family1) {                               // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                foreach ($child->spouseFamilies() as $family2) {                                // Gen -1 F
                    foreach ($family2->spouses() as $child_in_law) {                            // Gen -1 P
                        if ($child_in_law->xref() !== $child->xref()) {
                            if (($child_in_law->childFamilies()->first()) && ($child_in_law->childFamilies()->first()->husband() instanceof Individual)) {        // husband() or wife() may not exist
                                $this->addIndividualToFamily(new IndividualFamily($child_in_law->childFamilies()->first()->husband(), $family2), self::GROUP_COPARENTSINLAW_BIO);
                            }
                            if (($child_in_law->childFamilies()->first()) && ($child_in_law->childFamilies()->first()->wife() instanceof Individual)) {
                                $this->addIndividualToFamily(new IndividualFamily($child_in_law->childFamilies()->first()->wife(), $family2), self::GROUP_COPARENTSINLAW_BIO);
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->getProband()->spouseFamilies() as $family1) {                               // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->spouses() as $stepchild_in_law) {                // Gen -1 P
                                if ($stepchild_in_law->xref() !== $stepchild->xref()) {
                                    if (($stepchild_in_law->childFamilies()->first()) && ($stepchild_in_law->childFamilies()->first()->husband() instanceof Individual)) {        // husband() or wife() may not exist
                                        $this->addIndividualToFamily(new IndividualFamily($stepchild_in_law->childFamilies()->first()->husband(), $family3, $stepchild), self::GROUP_COPARENTSINLAW_STEP);
                                    }
                                    if (($stepchild_in_law->childFamilies()->first()) && ($stepchild_in_law->childFamilies()->first()->wife() instanceof Individual)) {
                                        $this->addIndividualToFamily(new IndividualFamily($stepchild_in_law->childFamilies()->first()->wife(), $family3, $stepchild), self::GROUP_COPARENTSINLAW_STEP);
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
