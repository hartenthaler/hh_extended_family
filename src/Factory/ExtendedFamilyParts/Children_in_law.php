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
 * class Children_in_law
 *
 * data and methods for extended family part "children-in-law" (partner of children and stepchildren)
 */
class Children_in_law extends ExtendedFamilyPart
{
    public const GROUP_CHILDRENINLAW_BIO    = 'Partners of biological children';
    public const GROUP_CHILDRENINLAW_SOCIAL = 'Partners of social children';
    public const GROUP_CHILDRENINLAW_STEP   = 'Partners of stepchildren';

    /**
     * @var object $_efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array
     *  ->counts                        FamilyPartCounts
     *  ->maleCount                     int legacy alias
     *  ->femaleCount                   int legacy alias
     *  ->otherSexCount                 int legacy alias
     *  ->allCount                      int legacy alias
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->entries[]           array of GroupEntry (index of groups is groupName)
     *            ->groupName           string
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject
     */
    protected function addEfpMembers()
    {
        $children = new Children($this->getProband(), 'all', $this->placeFormat);

        foreach ($children->getEfpObject()->groups as $group) {
            $groupName = $this->childrenInLawGroupName($group->groupName);

            foreach ($group->entries as $entry) {
                $child = $entry->individual;
                if ($child instanceof Individual) {
                    $this->addPartnersOfChild($child, $groupName);
                }
            }
        }
    }

    /**
     * Add direct partners of one child.
     *
     * @param Individual $child
     * @param string $groupName
     * @return void
     */
    private function addPartnersOfChild(Individual $child, string $groupName): void
    {
        foreach ($child->spouseFamilies() as $family) {
            foreach ($family->spouses() as $partner) {
                if ($partner->xref() !== $child->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($partner, $family, $child), $groupName);
                }
            }
        }
    }

    /**
     * Get the corresponding children-in-law group name for a children group.
     *
     * @param string $childGroupName
     * @return string
     */
    private function childrenInLawGroupName(string $childGroupName): string
    {
        return match ($childGroupName) {
            Children::GROUP_CHILDREN_SOCIAL => self::GROUP_CHILDRENINLAW_SOCIAL,
            Children::GROUP_CHILDREN_STEP   => self::GROUP_CHILDRENINLAW_STEP,
            default                         => self::GROUP_CHILDRENINLAW_BIO,
        };
    }
}
