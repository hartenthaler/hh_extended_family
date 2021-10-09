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
 * class Grandparents
 *
 * data and methods for extended family part "grandparents"
 */
class Grandparents extends ExtendedFamilyPart
{
    public const GROUP_GRANDPARENTS_FATHER_BIO   = 'Biological parents of father';
    public const GROUP_GRANDPARENTS_MOTHER_BIO   = 'Biological parents of mother';
    public const GROUP_GRANDPARENTS_U_BIO        = 'Biological parents of parent';
    public const GROUP_GRANDPARENTS_FATHER_STEP  = 'Stepparents of father';
    public const GROUP_GRANDPARENTS_MOTHER_STEP  = 'Stepparents of mother';
    public const GROUP_GRANDPARENTS_U_STEP       = 'Stepparents of parent';
    public const GROUP_GRANDPARENTS_STEP_PARENTS = 'Parents of stepparent';

    // used for relationshipCoefficientComment
    public const GROUP_GRANDPARENTS_BIO          = 'Biological grandparents';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array there are 7 groups defined (1a, 1b, 1c, 2a, 2b, 2c, 3)
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->members[]           array of Individual (index of groups is int)
     *            ->family              object family
     *            ->familyStatus        string
     *            ->partner             Individual
     *            ->partnerFamilyStatus string
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject
     */
    protected function addEfpMembers()
    {
        $config = new FindBranchConfig(
            'grandparents',
            [
            'bio'  => ['M' => self::GROUP_GRANDPARENTS_FATHER_BIO, 'F' => self::GROUP_GRANDPARENTS_MOTHER_BIO, 'U' => self::GROUP_GRANDPARENTS_U_BIO],
            'step' => ['M' => self::GROUP_GRANDPARENTS_FATHER_STEP, 'F' => self::GROUP_GRANDPARENTS_MOTHER_STEP, 'U' => self::GROUP_GRANDPARENTS_U_STEP]
            ]
        );
        $this->addFamilyBranches($config);

        // add biological parents and stepparents of stepparents
        foreach ($this->findStepparentsIndividuals($this->getProband()) as $stepparent) {
            foreach ($this->findBioparentsIndividuals($stepparent->getIndividual()) as $grandparent) {
                $grandparent->setReferencePerson(1, $stepparent->getIndividual());
                $this->addIndividualToFamily($grandparent, self::GROUP_GRANDPARENTS_STEP_PARENTS);
            }
            foreach ($this->findStepparentsIndividuals($stepparent->getIndividual()) as $grandparent) {
                $grandparent->setReferencePerson(1, $stepparent->getIndividual());
                $this->addIndividualToFamily($grandparent, self::GROUP_GRANDPARENTS_STEP_PARENTS);
            }
        }
    }
}
