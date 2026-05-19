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

/**
 * class Co_parents_in_law
 *
 * data and methods for extended family part "co_parents_in_law" (parents of children-in-law)
 */
class Co_parents_in_law extends ExtendedFamilyPart
{
    public const GROUP_COPARENTSINLAW_BIO    = 'Parents-in-law of biological children';
    public const GROUP_COPARENTSINLAW_SOCIAL = 'Parents-in-law of social children';
    public const GROUP_COPARENTSINLAW_STEP   = 'Parents-in-law of stepchildren';

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
        $children = new Children($this->getProband(), 'all', $this->placeFormat);

        foreach ($children->getEfpObject()->groups as $group) {
            $groupName = $this->coParentsInLawGroupName($group->groupName);

            foreach ($group->members as $child) {
                foreach ($child->spouseFamilies() as $family) {
                    foreach ($family->spouses() as $childInLaw) {
                        if ($childInLaw->xref() === $child->xref()) {
                            continue;
                        }

                        foreach ($this->findParentsIndividuals($childInLaw) as $parent) {
                            $this->addIndividualToFamily(new IndividualFamily($parent->getIndividual(), $family, $child, $childInLaw), $groupName);
                        }
                    }
                }
            }
        }
    }

    /**
     * Map child groups to their corresponding co-parents-in-law groups.
     *
     * @param string $childGroupName
     * @return string
     */
    private function coParentsInLawGroupName(string $childGroupName): string
    {
        return match ($childGroupName) {
            Children::GROUP_CHILDREN_SOCIAL => self::GROUP_COPARENTSINLAW_SOCIAL,
            Children::GROUP_CHILDREN_STEP   => self::GROUP_COPARENTSINLAW_STEP,
            default                         => self::GROUP_COPARENTSINLAW_BIO,
        };
    }
}
