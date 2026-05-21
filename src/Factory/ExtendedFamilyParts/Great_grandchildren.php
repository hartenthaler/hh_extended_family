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
 * class Great_grandchildren
 *
 * Data and methods for extended family part "great_grandchildren".
 * The grandchildren family part is used as the basis; their children and stepchildren
 * are shown as great-grandchildren of the proband.
 */
class Great_grandchildren extends ExtendedFamilyPart
{
    public const GROUP_GREATGRANDCHILDREN_BIOLOGICAL = 'Biological great-grandchildren';
    public const GROUP_GREATGRANDCHILDREN_BIO          = 'Children of biological grandchildren';
    public const GROUP_GREATGRANDCHILDREN_SOCIAL_CHILD = 'Social children of grandchildren';
    public const GROUP_GREATGRANDCHILDREN_CHILD_SOCIAL = 'Children of social grandchildren';
    public const GROUP_GREATGRANDCHILDREN_CHILD_STEP   = 'Children of stepgrandchildren';
    public const GROUP_GREATGRANDCHILDREN_STEP         = 'Stepchildren of grandchildren';
    public const GROUP_GREATGRANDCHILDREN_STEP_SOCIAL  = 'Stepchildren of social grandchildren';
    public const GROUP_GREATGRANDCHILDREN_STEP_STEP    = 'Stepchildren of stepgrandchildren';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $grandchildren = new Grandchildren($this->getProband(), 'all', $this->placeFormat);

        foreach ($grandchildren->getEfpObject()->groups as $group) {
            foreach ($group->members as $grandchild) {
                if ($grandchild instanceof Individual) {
                    $this->addChildrenOfGrandchild($grandchild, $group->groupName);
                    $this->addStepchildrenOfGrandchild($grandchild, $group->groupName);
                }
            }
        }
    }

    /**
     * Add children of one grandchild.
     *
     * @param Individual $grandchild
     * @param string $grandchildGroupName
     * @return void
     */
    private function addChildrenOfGrandchild(Individual $grandchild, string $grandchildGroupName): void
    {
        foreach ($grandchild->spouseFamilies() as $family) {
            foreach ($family->children() as $greatGrandchild) {
                $this->addIndividualToFamily(
                    new IndividualFamily($greatGrandchild, $family),
                    $this->childrenOfGrandchildGroupName($grandchildGroupName, $greatGrandchild, $family)
                );
            }
        }
    }

    /**
     * Add stepchildren of one grandchild.
     *
     * Stepchildren are children of a partner of the grandchild from another family.
     *
     * @param Individual $grandchild
     * @param string $grandchildGroupName
     * @return void
     */
    private function addStepchildrenOfGrandchild(Individual $grandchild, string $grandchildGroupName): void
    {
        foreach ($grandchild->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse->xref() === $grandchild->xref()) {
                    continue;
                }

                foreach ($spouse->spouseFamilies() as $stepFamily) {
                    if ($stepFamily->xref() === $family->xref()) {
                        continue;
                    }

                    foreach ($stepFamily->children() as $stepGreatGrandchild) {
                        $this->addIndividualToFamily(
                            new IndividualFamily($stepGreatGrandchild, $stepFamily),
                            $this->stepchildrenOfGrandchildGroupName($grandchildGroupName)
                        );
                    }
                }
            }
        }
    }

    /**
     * Get the group name for children of a grandchild.
     *
     * @param string $grandchildGroupName
     * @param Individual $greatGrandchild
     * @param Family $family
     * @return string
     */
    private function childrenOfGrandchildGroupName(string $grandchildGroupName, Individual $greatGrandchild, Family $family): string
    {
        if ($grandchildGroupName === Grandchildren::GROUP_GRANDCHILDREN_BIO) {
            return $this->isSocialChildInFamily($greatGrandchild, $family)
                ? self::GROUP_GREATGRANDCHILDREN_SOCIAL_CHILD
                : self::GROUP_GREATGRANDCHILDREN_BIO;
        }

        if ($grandchildGroupName === Grandchildren::GROUP_GRANDCHILDREN_SOCIAL_CHILD || $grandchildGroupName === Grandchildren::GROUP_GRANDCHILDREN_CHILD_SOCIAL) {
            return self::GROUP_GREATGRANDCHILDREN_CHILD_SOCIAL;
        }

        return self::GROUP_GREATGRANDCHILDREN_CHILD_STEP;
    }

    /**
     * Get the group name for stepchildren of a grandchild.
     *
     * @param string $grandchildGroupName
     * @return string
     */
    private function stepchildrenOfGrandchildGroupName(string $grandchildGroupName): string
    {
        if ($grandchildGroupName === Grandchildren::GROUP_GRANDCHILDREN_BIO) {
            return self::GROUP_GREATGRANDCHILDREN_STEP;
        }

        if ($grandchildGroupName === Grandchildren::GROUP_GRANDCHILDREN_SOCIAL_CHILD || $grandchildGroupName === Grandchildren::GROUP_GRANDCHILDREN_CHILD_SOCIAL) {
            return self::GROUP_GREATGRANDCHILDREN_STEP_SOCIAL;
        }

        return self::GROUP_GREATGRANDCHILDREN_STEP_STEP;
    }
}
