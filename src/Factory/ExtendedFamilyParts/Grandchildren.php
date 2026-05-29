<?php
/*
 * webtrees - extended family parts
 * Copyright (C) 2026 Hermann Hartenthaler. All rights reserved.
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2026 webtrees development team.
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
 * class Grandchildren
 *
 * Data and methods for extended family part "grandchildren".
 * The children family part is used as the basis; children and stepchildren of
 * the individuals shown there are shown as grandchildren of the proband.
 */
class Grandchildren extends ExtendedFamilyPart
{
    public const GROUP_GRANDCHILDREN_BIO          = 'Biological grandchildren';
    public const GROUP_GRANDCHILDREN_SOCIAL_CHILD = 'Social children of children';
    public const GROUP_GRANDCHILDREN_STEP_CHILD   = 'Stepchildren of children';
    public const GROUP_GRANDCHILDREN_CHILD_SOCIAL = 'Children of social children';
    public const GROUP_GRANDCHILDREN_CHILD_STEP   = 'Children of stepchildren';
    public const GROUP_GRANDCHILDREN_STEP_STEP    = 'Stepchildren of stepchildren';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $children = new Children($this->getProband(), 'all', $this->placeFormat);

        foreach ($children->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $child = $entry->individual;
                if ($child instanceof Individual) {
                    $this->addChildrenOfChild($child, $group->groupName);
                    $this->addStepchildrenOfChild($child, $group->groupName);
                }
            }
        }
    }

    /**
     * Add children of one child.
     *
     * @param Individual $child
     * @param string $childGroupName
     * @return void
     */
    private function addChildrenOfChild(Individual $child, string $childGroupName): void
    {
        foreach ($child->spouseFamilies() as $family) {
            foreach ($family->children() as $grandchild) {
                $this->addIndividualToFamily(
                    new IndividualFamily($grandchild, $family),
                    $this->childrenOfChildGroupName($childGroupName, $grandchild, $family)
                );
            }
        }
    }

    /**
     * Add stepchildren of one child.
     *
     * Stepchildren are children of a partner of the child from another family.
     *
     * @param Individual $child
     * @param string $childGroupName
     * @return void
     */
    private function addStepchildrenOfChild(Individual $child, string $childGroupName): void
    {
        foreach ($child->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse->xref() === $child->xref()) {
                    continue;
                }

                foreach ($spouse->spouseFamilies() as $stepFamily) {
                    if ($stepFamily->xref() === $family->xref()) {
                        continue;
                    }

                    foreach ($stepFamily->children() as $stepGrandchild) {
                        $this->addIndividualToFamily(
                            new IndividualFamily($stepGrandchild, $stepFamily, $child),
                            $this->stepchildrenOfChildGroupName($childGroupName)
                        );
                    }
                }
            }
        }
    }

    /**
     * Get the group name for children of a child.
     *
     * @param string $childGroupName
     * @param Individual $grandchild
     * @param Family $family
     * @return string
     */
    private function childrenOfChildGroupName(string $childGroupName, Individual $grandchild, Family $family): string
    {
        if ($childGroupName === Children::GROUP_CHILDREN_BIO) {
            return $this->isSocialChildInFamily($grandchild, $family)
                ? self::GROUP_GRANDCHILDREN_SOCIAL_CHILD
                : self::GROUP_GRANDCHILDREN_BIO;
        }

        if ($childGroupName === Children::GROUP_CHILDREN_SOCIAL) {
            return self::GROUP_GRANDCHILDREN_CHILD_SOCIAL;
        }

        return self::GROUP_GRANDCHILDREN_CHILD_STEP;
    }

    /**
     * Get the group name for stepchildren of a child.
     *
     * @param string $childGroupName
     * @return string
     */
    private function stepchildrenOfChildGroupName(string $childGroupName): string
    {
        return $childGroupName === Children::GROUP_CHILDREN_STEP
            ? self::GROUP_GRANDCHILDREN_STEP_STEP
            : self::GROUP_GRANDCHILDREN_STEP_CHILD;
    }
}
