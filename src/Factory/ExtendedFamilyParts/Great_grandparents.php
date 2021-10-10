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
 * class Great_grandparents
 *
 * data and methods for extended family part "great_grandparents"
 */
class Great_grandparents extends ExtendedFamilyPart
{
    // 1 (1a, 1b, 1c): biological grandparents of biological parents (up to 4 in each group)
    // refPerson = biological grandparent
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_BIO = 'Biological grandparents of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIO = 'Biological grandparents of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_BIO = 'Biological grandparents of parent';

    // 2 (2a, 2b, 2c): stepparents of biological grandparents
    // refPerson = biological grandparent
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_STEPBIO = 'Stepparents of biological parent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEPBIO = 'Stepparents of biological parent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_STEPBIO = 'Stepparents of biological grandparent';

    // 3 (3a, 3b, 3c): biological parents of stepparents of biological parents and
    //                stepparents of stepparents of biological parents
    // refPerson = stepparent of parent
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP = 'Parents of stepparent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP = 'Parents of stepparent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_STEP = 'Parents of stepparent of parent';

    // 4 biological grandparents and stepgrandparents of stepparent
    // refPerson = stepparent
    public const GROUP_GREATGRANDPARENTS_STEP_PARENTS = 'Grandparents of stepparent';

    // used for relationshipCoefficientComment
    public const GROUP_GREATGRANDPARENTS_BIO = 'Biological greatgrandparents';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups                        array of FamilyPart (there are 10 groups defined (1a-c, 2a-c, 3a-c, 4))
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for several extended family parts:
     *  ->groups[]->groupName           string
     *            ->members             array of Individual (index of groups is int)
     *            ->labels              array of array of labels
     *            ->families            array of object family
     *            ->familiesStatus      array of string
     *            ->referencePersons    array of array of Individual
     */

    /**
     * Find members for this specific extended family part and modify $this->efpObject
     */
    protected function addEfpMembers()
    {
        // 1, 2 and 3: add grandparents of biological parent (father, mother, unknown sex)
        $config = new FindBranchConfig(
            'great_grandparents',
            [
                'bio' => [
                    'M' => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_BIO,
                    'F' => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIO,
                    'U' => self::GROUP_GREATGRANDPARENTS_USIDE_BIO],
                'stepbio' => [
                    'M' => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEPBIO,
                    'F' => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEPBIO,
                    'U' => self::GROUP_GREATGRANDPARENTS_USIDE_STEPBIO],
                'step' => [
                    'M' => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP,
                    'F' => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP,
                    'U' => self::GROUP_GREATGRANDPARENTS_USIDE_STEP]
            ]
        );
        $this->addFamilyBranches($config);

        // 4: add biological grandparents and stepgrandparents of stepparent
        $this->addGrandparentsOfStepparent();
    }

    /**
     * find and add biological grandparents and stepgrandparents of stepparents (modify $this->efpObject)
     */
    private function addGrandparentsOfStepparent()
    {
        foreach ($this->findStepparentsIndividuals($this->getProband()) as $stepparent) {
            $this->addBioGrandparentsOfStepparent($stepparent);
            $this->addStepGrandparentsOfStepparent($stepparent);
        }
    }

    /**
     * find and add biological grandparents of stepparent (modify $this->efpObject)
     */
    private function addBioGrandparentsOfStepparent(IndividualFamily $stepparent)
    {
        foreach ($this->findBioparentsIndividuals($stepparent->getIndividual()) as $grandparent) {
            foreach ($this->findBioparentsIndividuals($grandparent->getIndividual()) as $greatgrandparent) {
                $greatgrandparent->setReferencePerson(1, $stepparent->getIndividual());
                $this->addIndividualToFamily($greatgrandparent, self::GROUP_GREATGRANDPARENTS_STEP_PARENTS);
            }
            foreach ($this->findStepparentsIndividuals($grandparent->getIndividual()) as $greatgrandparent) {
                $greatgrandparent->setReferencePerson(1, $stepparent->getIndividual());
                $this->addIndividualToFamily($greatgrandparent, self::GROUP_GREATGRANDPARENTS_STEP_PARENTS);
            }
        }
    }

    /**
     * find and add stepgrandparents of stepparent (modify $this->efpObject)
     */
    private function addStepGrandparentsOfStepparent(IndividualFamily $stepparent)
    {
        foreach ($this->findStepparentsIndividuals($stepparent->getIndividual()) as $grandparent) {
            foreach ($this->findBioparentsIndividuals($grandparent->getIndividual()) as $greatgrandparent) {
                $greatgrandparent->setReferencePerson(1, $stepparent->getIndividual());
                $this->addIndividualToFamily($greatgrandparent, self::GROUP_GREATGRANDPARENTS_STEP_PARENTS);
            }
            foreach ($this->findStepparentsIndividuals($grandparent->getIndividual()) as $greatgrandparent) {
                $greatgrandparent->setReferencePerson(1, $stepparent->getIndividual());
                $this->addIndividualToFamily($greatgrandparent, self::GROUP_GREATGRANDPARENTS_STEP_PARENTS);
            }
        }
    }
}
