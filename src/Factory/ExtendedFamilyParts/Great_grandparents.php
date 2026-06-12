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

use Fisharebest\Webtrees\Individual;

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

    // 2s (2sa, 2sb, 2sc): social parents of biological grandparents
    // refPerson = biological grandparent
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_BIOSOCIAL = 'Social parents of biological parent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIOSOCIAL = 'Social parents of biological parent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_BIOSOCIAL = 'Social parents of biological grandparent';

    // 3 (3a, 3b, 3c): biological parents of stepparents of biological parents and
    //                stepparents of stepparents of biological parents
    // refPerson = stepparent of parent
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP = 'Parents of stepparent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP = 'Parents of stepparent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_STEP = 'Parents of stepparent of parent';
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP_STEP = 'Stepparents of stepparent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP_STEP = 'Stepparents of stepparent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_STEP_STEP = 'Stepparents of stepparent of parent';

    // 3s (3sa, 3sb, 3sc): parents of social parents of biological parents
    // refPerson = social parent of parent
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL = 'Parents of social parent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL = 'Parents of social parent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_SOCIAL = 'Parents of social parent of parent';
    public const GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL_STEP = 'Stepparents of social parent of father';
    public const GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL_STEP = 'Stepparents of social parent of mother';
    public const GROUP_GREATGRANDPARENTS_USIDE_SOCIAL_STEP = 'Stepparents of social parent of parent';

    // 4 biological grandparents and stepgrandparents of stepparent
    // refPerson = stepparent
    public const GROUP_GREATGRANDPARENTS_STEP_PARENTS = 'Grandparents of stepparent';

    // 5 biological and social grandparents of social parent
    // refPerson = social parent
    public const GROUP_GREATGRANDPARENTS_SOCIAL_PARENTS = 'Grandparents of social parent';

    // used for relationshipCoefficientComment
    public const GROUP_GREATGRANDPARENTS_BIO = 'Biological great-grandparents';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups                        array of FamilyPart (there are 10 groups defined (1a-c, 2a-c, 3a-c, 4))
     *  ->counts                        FamilyPartCounts
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
     * Find members for this specific extended family part and modify $this->efpObject.
     *
     * This part is derived from the grandparents family part, so biological,
     * social, and step distinctions from all parent branches are preserved.
     */
    protected function addEfpMembers()
    {
        $grandparents = new Grandparents($this->getProband(), 'all', $this->placeFormat);

        foreach ($grandparents->getEfpObject()->groups as $group) {
            $groupNames = $this->greatGrandparentGroupNames($group->groupName);

            foreach ($group->entries as $entry) {
                $grandparent = $entry->individual;
                if ($grandparent instanceof Individual) {
                    $referencePerson = $this->greatGrandparentReferencePerson(
                        $group->groupName,
                        $grandparent,
                        $entry->referencePersons[1] ?? null
                    );
                    $this->addGreatGrandparentsForGrandparent($grandparent, $referencePerson, $groupNames);
                }
            }
        }
    }

    /**
     * Add parents and stepparents of one grandparent-like person.
     *
     * @param Individual $grandparent
     * @param Individual $referencePerson
     * @param array{bio:string,social:string,step:string} $groupNames
     * @return void
     */
    private function addGreatGrandparentsForGrandparent(Individual $grandparent, Individual $referencePerson, array $groupNames): void
    {
        foreach ($this->findBioparentsIndividuals($grandparent) as $greatGrandParent) {
            $this->addGreatGrandparent($greatGrandParent, $referencePerson, $groupNames['bio']);
        }

        foreach ($this->findSocialparentsIndividuals($grandparent) as $greatGrandParent) {
            $this->addGreatGrandparent($greatGrandParent, $referencePerson, $groupNames['social']);
        }

        foreach ($this->findStepparentsIndividuals($grandparent) as $greatGrandParent) {
            $this->addGreatGrandparent($greatGrandParent, $referencePerson, $groupNames['step']);
        }
    }

    /**
     * Add one great-grandparent-like person with a reference person for display.
     *
     * @param IndividualFamily $greatGrandParent
     * @param Individual $referencePerson
     * @param string $groupName
     * @return void
     */
    private function addGreatGrandparent(IndividualFamily $greatGrandParent, Individual $referencePerson, string $groupName): void
    {
        $greatGrandParent->setReferencePerson(1, $referencePerson);
        $this->addIndividualToFamily($greatGrandParent, $groupName);
    }

    /**
     * Get group names for parents of one grandparent group.
     *
     * @param string $grandparentGroupName
     * @return array{bio:string,social:string,step:string}
     */
    private function greatGrandparentGroupNames(string $grandparentGroupName): array
    {
        return match ($grandparentGroupName) {
            Grandparents::GROUP_GRANDPARENTS_FATHER_BIO => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_BIO,
                'social' => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_BIOSOCIAL,
                'step'   => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEPBIO,
            ],
            Grandparents::GROUP_GRANDPARENTS_MOTHER_BIO => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIO,
                'social' => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIOSOCIAL,
                'step'   => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEPBIO,
            ],
            Grandparents::GROUP_GRANDPARENTS_FATHER_STEP => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP,
                'social' => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP,
                'step'   => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_STEP_STEP,
            ],
            Grandparents::GROUP_GRANDPARENTS_MOTHER_STEP => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP,
                'social' => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP,
                'step'   => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_STEP_STEP,
            ],
            Grandparents::GROUP_GRANDPARENTS_U_STEP => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_USIDE_STEP,
                'social' => self::GROUP_GREATGRANDPARENTS_USIDE_STEP,
                'step'   => self::GROUP_GREATGRANDPARENTS_USIDE_STEP_STEP,
            ],
            Grandparents::GROUP_GRANDPARENTS_FATHER_SOCIAL => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL,
                'social' => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL,
                'step'   => self::GROUP_GREATGRANDPARENTS_FATHERSIDE_SOCIAL_STEP,
            ],
            Grandparents::GROUP_GRANDPARENTS_MOTHER_SOCIAL => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL,
                'social' => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL,
                'step'   => self::GROUP_GREATGRANDPARENTS_MOTHERSIDE_SOCIAL_STEP,
            ],
            Grandparents::GROUP_GRANDPARENTS_U_SOCIAL => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_USIDE_SOCIAL,
                'social' => self::GROUP_GREATGRANDPARENTS_USIDE_SOCIAL,
                'step'   => self::GROUP_GREATGRANDPARENTS_USIDE_SOCIAL_STEP,
            ],
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT_STEP => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_SOCIAL_PARENTS,
                'social' => self::GROUP_GREATGRANDPARENTS_SOCIAL_PARENTS,
                'step'   => self::GROUP_GREATGRANDPARENTS_SOCIAL_PARENTS,
            ],
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENTS,
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENT_STEP => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_STEP_PARENTS,
                'social' => self::GROUP_GREATGRANDPARENTS_STEP_PARENTS,
                'step'   => self::GROUP_GREATGRANDPARENTS_STEP_PARENTS,
            ],
            default => [
                'bio'    => self::GROUP_GREATGRANDPARENTS_USIDE_BIO,
                'social' => self::GROUP_GREATGRANDPARENTS_USIDE_BIOSOCIAL,
                'step'   => self::GROUP_GREATGRANDPARENTS_USIDE_STEPBIO,
            ],
        };
    }

    /**
     * Get the display reference person for one derived great-grandparent group.
     *
     * @param string $grandparentGroupName
     * @param Individual $grandparent
     * @param Individual|null $grandparentReferencePerson
     * @return Individual
     */
    private function greatGrandparentReferencePerson(string $grandparentGroupName, Individual $grandparent, ?Individual $grandparentReferencePerson): Individual
    {
        if ($grandparentReferencePerson instanceof Individual && in_array($grandparentGroupName, [
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT_STEP,
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENTS,
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENT_STEP,
        ], true)) {
            return $grandparentReferencePerson;
        }

        return $grandparent;
    }
}
