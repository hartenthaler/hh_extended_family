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

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

/**
 * class Uncles_and_aunts
 *
 * data and methods for extended family part "uncles_and_aunts" (not including uncles and aunts by marriage)
 */
class Uncles_and_aunts extends ExtendedFamilyPart
{
    public const GROUP_UNCLEAUNT_BIO_PARENT    = 'Siblings and half siblings of biological parents';
    public const GROUP_UNCLEAUNT_SOCIAL_PARENT = 'Siblings and half siblings of social parents';
    public const GROUP_UNCLEAUNT_STEP_PARENT   = 'Siblings and half siblings of stepparents';

    public const GROUP_UNCLEAUNT_FULL_BIO      = 'Full siblings of biological parents';

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
     * Find members for this specific extended family part and modify $this->>efpObject.
     *
     * This part is derived from the parents family part, so biological, social,
     * and step-parent distinctions are preserved.
     */
    protected function addEfpMembers()
    {
        $parents = new Parents($this->getProband(), 'all', $this->placeFormat);

        foreach ($parents->getEfpObject()->groups as $group) {
            $groupName = $this->unclesAndAuntsGroupName($group->groupName);

            foreach ($group->members as $parent) {
                if ($parent instanceof Individual) {
                    $this->addUnclesAndAuntsForParent($parent, $groupName);
                }
            }
        }
    }

    /**
     * Get the group name for siblings and half siblings of one parent group.
     *
     * @param string $parentGroupName
     * @return string
     */
    private function unclesAndAuntsGroupName(string $parentGroupName): string
    {
        return match ($parentGroupName) {
            Parents::GROUP_PARENTS_SOCIAL => self::GROUP_UNCLEAUNT_SOCIAL_PARENT,
            Parents::GROUP_PARENTS_STEP   => self::GROUP_UNCLEAUNT_STEP_PARENT,
            default                       => self::GROUP_UNCLEAUNT_BIO_PARENT,
        };
    }

    /**
     * Find siblings and half siblings of one parent.
     *
     * @param Individual $parent
     * @param string $groupName
     * @return void
     */
    private function addUnclesAndAuntsForParent(Individual $parent, string $groupName): void
    {
        foreach ($parent->childFamilies() as $parentFamily) {
            if (!$this->isBiologicalChildInFamily($parent, $parentFamily)) {
                continue;
            }

            $this->addFullSiblingsOfParent($parent, $parentFamily, $groupName);
            $this->addHalfSiblingsOfParent($parent, $parentFamily, $groupName);
        }
    }

    /**
     * Add full siblings of a parent from the same parent-family.
     *
     * @param Individual $parent
     * @param Family $parentFamily
     * @param string $groupName
     * @return void
     */
    private function addFullSiblingsOfParent(Individual $parent, Family $parentFamily, string $groupName): void
    {
        foreach ($parentFamily->children() as $uncleAunt) {
            if ($uncleAunt->xref() !== $parent->xref() && $this->isBiologicalChildInFamily($uncleAunt, $parentFamily)) {
                $this->addIndividualToFamily(new IndividualFamily($uncleAunt, $parentFamily, $parent), $groupName);
            }
        }
    }

    /**
     * Add half siblings of a parent from other families of either grandparent.
     *
     * @param Individual $parent
     * @param Family $parentFamily
     * @param string $groupName
     * @return void
     */
    private function addHalfSiblingsOfParent(Individual $parent, Family $parentFamily, string $groupName): void
    {
        foreach ($parentFamily->spouses() as $grandparent) {
            foreach ($grandparent->spouseFamilies() as $halfSiblingFamily) {
                if ($halfSiblingFamily->xref() === $parentFamily->xref()) {
                    continue;
                }

                foreach ($halfSiblingFamily->children() as $uncleAunt) {
                    if ($uncleAunt->xref() !== $parent->xref() && $this->isBiologicalChildInFamily($uncleAunt, $halfSiblingFamily)) {
                        $this->addIndividualToFamily(new IndividualFamily($uncleAunt, $halfSiblingFamily, $parent), $groupName);
                    }
                }
            }
        }
    }
}
