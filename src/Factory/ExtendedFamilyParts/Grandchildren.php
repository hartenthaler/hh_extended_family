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

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

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
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups                        array
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->groupName           string
     *            ->members             array of Individual (index of groups is groupName)
     *            ->labels              array of array of string
     *            ->families            array of object
     *            ->familiesStatus      array of string
     *            ->referencePersons    array of array of Individual
     */

    /**
     * Find members for this specific extended family part and modify $this->efpObject
     */
    protected function addEfpMembers()
    {
        /*
        foreach ($this->getProband()->spouseFamilies() as $family1) {                           // Gen  0 F
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    echo "<br>=== 1 biochild : ".$biochild->fullName()." with family ".$family2->fullName().". ";
                    $this->addGrandchildrenBio($family1, $family2, self::GROUP_GRANDCHILDREN_BIO);
                }
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    echo "<br>=== 2 biochild : ".$biochild->fullName()." with family ".$family2->fullName().". ";
                    $this->addStepchildrenOfChildren($family1, $family2, self::GROUP_GRANDCHILDREN_STEP_CHILD);
                }
            }
        }
        */

        // get 'Biological grandchildren'
        foreach ($this->getProband()->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $biochild) {                                               // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                                     // Gen -1 F
                    //echo "<br>=== 1 biochild : " . $biochild->fullName() . " with family " . $family2->fullName() . ". ";
                    foreach ($family2->children() as $grandchild) {                                     // Gen -2 P
                        //echo "<br>biograndchild : " . self::GROUP_GRANDCHILDREN_BIO . ": " . $grandchild->fullName() . " with family " . $family2->fullName() . ". ";
                        $this->addIndividualToFamily(new IndividualFamily($grandchild, $family2), self::GROUP_GRANDCHILDREN_BIO);
                    }
                }
            }
        }

        // get 'Stepchildren of children'
        foreach ($this->getProband()->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $biochild) {                                               // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                                     // Gen -1 F
                    foreach ($family2->spouses() as $spouse1) {                                         // Gen -1 P
                        foreach ($spouse1->spouseFamilies() as $family3) {                              // Gen -1 F
                            if ($family3->xref() !== $family2->xref()) {
                                foreach ($family3->children() as $grandchild) {                         // Gen -2 P
                                    //echo "<br>bio " . self::GROUP_GRANDCHILDREN_STEP_CHILD . ": " . $grandchild->fullName() . " with family " . $family3->fullName() . ". ";
                                    $this->addIndividualToFamily(new IndividualFamily($grandchild, $family3), self::GROUP_GRANDCHILDREN_STEP_CHILD);
                                }
                            }
                        }
                    }
                }
            }
        }

        // get 'Children of stepchildren'
        foreach ($this->getProband()->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                                 // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family4) {                                      // Gen  0 F
                    if ($family4->xref() !== $family1->xref()) {
                        foreach ($family4->children() as $stepchild) {                                  // Gen -1 P
                            foreach ($stepchild->spouseFamilies() as $family5) {                        // Gen -1 F
                                foreach ($family5->children() as $grandchild) {                         // Gen -2 P
                                    //echo "<br> " . self::GROUP_GRANDCHILDREN_CHILD_STEP . ": " . $grandchild->fullName() . " with family " . $family5->fullName() . ". ";
                                    $this->addIndividualToFamily(new IndividualFamily($grandchild, $family5), self::GROUP_GRANDCHILDREN_CHILD_STEP);
                                }
                            }
                        }
                    }
                }
            }
        }

        // get 'Stepchildren of stepchildren'
        $this->addChildrenStepchildrenOfStepchildren();
    }


    /**
     * add biological grandchildren
     *
     * @param object $family1
     * @param object $family2
     * @param string $groupName
     */
    private function addGrandchildrenBio(object $family1, object $family2, string $groupName)
    {
        foreach ($family2->children() as $biograndchild) {                          // Gen -2 P
            //echo "<br>bio ".$groupName.": ".$biograndchild->fullName()." with family ".$family2->fullName().". ";
            $this->addIndividualToFamily(new IndividualFamily($biograndchild, $family1), $groupName);
        }
    }

    /**
     * add stepchildren of children
     *
     * @param object $family1
     * @param object $family2
     * @param string $groupName
     */
    private function addStepchildrenOfChildren(object $family1, object $family2, string $groupName)
    {
        foreach ($family2->spouses() as $spouse) {                                  // Gen -1 P
            foreach ($spouse->spouseFamilies() as $family3) {                       // Gen -1 F
                if ($family3->xref() !== $family2->xref()) {
                    foreach ($family3->children() as $stepchild) {                  // Gen -2 P
                        //echo "<br>step ".$groupName.": ".$stepchild->fullName()." with family ".$family3->fullName().". ";
                        $this->addIndividualToFamily(new IndividualFamily($stepchild, $family1), $groupName);
                    }
                }
            }
        }
    }

    /**
     * add children and stepchildren of stepchildren
     */
    private function addChildrenStepchildrenOfStepchildren()
    {
        foreach ($this->getProband()->spouseFamilies() as $family1) {                           // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    if ($family2->xref() !== $family1->xref()) {
                        foreach ($family2->children() as $stepchild) {                          // Gen -1 P
                            foreach ($stepchild->spouseFamilies() as $family3) {                // Gen -1 F
                                //echo "<br>=== 3 stepstep : ".$stepchild->fullName()." with family ".$family3->fullName().". ";
                                $this->addGrandchildrenBio($family1, $family3, self::GROUP_GRANDCHILDREN_CHILD_STEP);
                                $this->addStepchildrenOfChildren($family1, $family3, self::GROUP_GRANDCHILDREN_STEP_STEP);
                            }
                        }
                    }
                }
            }
        }
    }
}
