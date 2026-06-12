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
    public const GROUP_GRANDPARENTS_FATHER_SOCIAL = 'Social parents of father';
    public const GROUP_GRANDPARENTS_MOTHER_SOCIAL = 'Social parents of mother';
    public const GROUP_GRANDPARENTS_U_SOCIAL      = 'Social parents of parent';
    public const GROUP_GRANDPARENTS_SOCIAL_FATHER = 'Parents of social father';
    public const GROUP_GRANDPARENTS_SOCIAL_MOTHER = 'Parents of social mother';
    public const GROUP_GRANDPARENTS_SOCIAL_PARENT = 'Parents of social parent';
    public const GROUP_GRANDPARENTS_SOCIAL_FATHER_STEP = 'Stepparents of social father';
    public const GROUP_GRANDPARENTS_SOCIAL_MOTHER_STEP = 'Stepparents of social mother';
    public const GROUP_GRANDPARENTS_SOCIAL_PARENT_STEP = 'Stepparents of social parent';
    public const GROUP_GRANDPARENTS_STEP_PARENT_STEP   = 'Stepparents of stepparent';

    // used for relationshipCoefficientComment
    public const GROUP_GRANDPARENTS_BIO          = 'Biological grandparents';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array there are 7 groups defined (1a, 1b, 1c, 2a, 2b, 2c, 3)
     *  ->counts                        FamilyPartCounts
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->entries[]           array of GroupEntry (index of groups is int)
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject.
     *
     * This part is derived from the parents family part, so biological,
     * social, and step-parent distinctions are preserved.
     */
    protected function addEfpMembers()
    {
        $parents = new Parents($this->getProband(), 'all', $this->placeFormat);

        foreach ($parents->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $parent = $entry->individual;
                if ($parent instanceof Individual) {
                    $this->addGrandparentsForParent($parent, $group->groupName);
                }
            }
        }
    }

    /**
     * Add parents and stepparents of one parent.
     *
     * @param Individual $parent
     * @param string $parentGroupName
     * @return void
     */
    private function addGrandparentsForParent(Individual $parent, string $parentGroupName): void
    {
        if ($parentGroupName === Parents::GROUP_PARENTS_BIO) {
            foreach ($this->findBioparentsIndividuals($parent) as $grandparent) {
                $this->addGrandparent($grandparent, $parent, $this->biologicalParentGroupName($parent));
            }
            foreach ($this->findSocialparentsIndividuals($parent) as $grandparent) {
                $this->addGrandparent($grandparent, $parent, $this->socialParentOfBiologicalParentGroupName($parent));
            }
        } else {
            foreach ($this->findParentsIndividuals($parent) as $grandparent) {
                $this->addGrandparent($grandparent, $parent, $this->parentsOfParentGroupName($parent, $parentGroupName));
            }
        }

        foreach ($this->findStepparentsIndividuals($parent) as $grandparent) {
            $this->addGrandparent($grandparent, $parent, $this->stepparentsOfParentGroupName($parent, $parentGroupName));
        }
    }

    /**
     * Add one grandparent-like person with the parent as reference person.
     *
     * @param IndividualFamily $grandparent
     * @param Individual $parent
     * @param string $groupName
     * @return void
     */
    private function addGrandparent(IndividualFamily $grandparent, Individual $parent, string $groupName): void
    {
        $grandparent->setReferencePerson(1, $parent);
        $this->addIndividualToFamily($grandparent, $groupName);
    }

    /**
     * Get the group name for biological parents of one biological parent.
     *
     * @param Individual $parent
     * @return string
     */
    private function biologicalParentGroupName(Individual $parent): string
    {
        return match ($parent->sex()) {
            'M'     => self::GROUP_GRANDPARENTS_FATHER_BIO,
            'F'     => self::GROUP_GRANDPARENTS_MOTHER_BIO,
            default => self::GROUP_GRANDPARENTS_U_BIO,
        };
    }

    /**
     * Get the group name for social parents of one biological parent.
     *
     * @param Individual $parent
     * @return string
     */
    private function socialParentOfBiologicalParentGroupName(Individual $parent): string
    {
        return match ($parent->sex()) {
            'M'     => self::GROUP_GRANDPARENTS_FATHER_SOCIAL,
            'F'     => self::GROUP_GRANDPARENTS_MOTHER_SOCIAL,
            default => self::GROUP_GRANDPARENTS_U_SOCIAL,
        };
    }

    /**
     * Get the group name for parents of one social or step parent.
     *
     * @param Individual $parent
     * @param string $parentGroupName
     * @return string
     */
    private function parentsOfParentGroupName(Individual $parent, string $parentGroupName): string
    {
        if ($parentGroupName === Parents::GROUP_PARENTS_SOCIAL) {
            return match ($parent->sex()) {
                'M'     => self::GROUP_GRANDPARENTS_SOCIAL_FATHER,
                'F'     => self::GROUP_GRANDPARENTS_SOCIAL_MOTHER,
                default => self::GROUP_GRANDPARENTS_SOCIAL_PARENT,
            };
        }

        return self::GROUP_GRANDPARENTS_STEP_PARENTS;
    }

    /**
     * Get the group name for stepparents of one parent.
     *
     * @param Individual $parent
     * @param string $parentGroupName
     * @return string
     */
    private function stepparentsOfParentGroupName(Individual $parent, string $parentGroupName): string
    {
        if ($parentGroupName === Parents::GROUP_PARENTS_BIO) {
            return match ($parent->sex()) {
                'M'     => self::GROUP_GRANDPARENTS_FATHER_STEP,
                'F'     => self::GROUP_GRANDPARENTS_MOTHER_STEP,
                default => self::GROUP_GRANDPARENTS_U_STEP,
            };
        }

        if ($parentGroupName === Parents::GROUP_PARENTS_SOCIAL) {
            return match ($parent->sex()) {
                'M'     => self::GROUP_GRANDPARENTS_SOCIAL_FATHER_STEP,
                'F'     => self::GROUP_GRANDPARENTS_SOCIAL_MOTHER_STEP,
                default => self::GROUP_GRANDPARENTS_SOCIAL_PARENT_STEP,
            };
        }

        return self::GROUP_GRANDPARENTS_STEP_PARENT_STEP;
    }
}
