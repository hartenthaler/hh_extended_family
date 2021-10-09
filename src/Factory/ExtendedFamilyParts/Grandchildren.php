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
 * class Grandchildren
 *
 * data and methods for extended family part "grandchildren" including step- and step-step-grandchildren
 */
class Grandchildren extends ExtendedFamilyPart
{
    public const GROUP_GRANDCHILDREN_BIO        = 'Biological grandchildren';
    public const GROUP_GRANDCHILDREN_STEP_CHILD = 'Stepchildren of children';
    public const GROUP_GRANDCHILDREN_CHILD_STEP = 'Children of stepchildren';
    public const GROUP_GRANDCHILDREN_STEP_STEP  = 'Stepchildren of stepchildren';

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
        foreach ($this->getProband()->spouseFamilies() as $family1) {                           // Gen  0 F
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    foreach ($family2->children() as $biograndchild) {                          // Gen -2 P
                        $this->addIndividualToFamily(new IndividualFamily($biograndchild, $family1), self::GROUP_GRANDCHILDREN_BIO);
                    }
                    foreach ($family2->spouses() as $spouse) {                                  // Gen -1 P
                        foreach ($spouse->spouseFamilies() as $family3) {                       // Gen -1 F
                            foreach ($family3->children() as $step_child) {                     // Gen -2 P
                                $this->addIndividualToFamily(new IndividualFamily($step_child, $family1), self::GROUP_GRANDCHILDREN_STEP_CHILD);
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->getProband()->spouseFamilies() as $family1) {                           // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->children() as $child_step) {                     // Gen -2 P
                                $this->addIndividualToFamily(new IndividualFamily($child_step, $family1), self::GROUP_GRANDCHILDREN_CHILD_STEP);
                            }
                            foreach ($family3->spouses() as $childstepchild) {                  // Gen -1 P
                                foreach ($childstepchild->spouseFamilies() as $family4) {       // Gen -1 F
                                    foreach ($family4->children() as $step_step) {              // Gen -2 P
                                        $this->addIndividualToFamily(new IndividualFamily($step_step, $family1), self::GROUP_GRANDCHILDREN_STEP_STEP);
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
