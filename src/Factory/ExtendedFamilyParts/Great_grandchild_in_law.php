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

use Fisharebest\Webtrees\Individual;

/**
 * class Great_grandchild_in_law
 *
 * Data and methods for extended family part "great_grandchild_in_law".
 * The great-grandchildren family part is used as the basis; direct partners of
 * the individuals shown there are shown as great-grandchildren-in-law.
 */
class Great_grandchild_in_law extends ExtendedFamilyPart
{
    public const GROUP_GREATGRANDCHILDRENINLAW_BIO          = 'Partners of biological great-grandchildren';
    public const GROUP_GREATGRANDCHILDRENINLAW_SOCIAL_CHILD = 'Partners of social children of grandchildren';
    public const GROUP_GREATGRANDCHILDRENINLAW_CHILD_SOCIAL = 'Partners of children of social grandchildren';
    public const GROUP_GREATGRANDCHILDRENINLAW_CHILD_STEP   = 'Partners of children of stepgrandchildren';
    public const GROUP_GREATGRANDCHILDRENINLAW_STEP         = 'Partners of stepchildren of grandchildren';
    public const GROUP_GREATGRANDCHILDRENINLAW_STEP_SOCIAL  = 'Partners of stepchildren of social grandchildren';
    public const GROUP_GREATGRANDCHILDRENINLAW_STEP_STEP    = 'Partners of stepchildren of stepgrandchildren';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $greatGrandchildren = new Great_grandchildren($this->getProband(), 'all', $this->placeFormat);

        foreach ($greatGrandchildren->getEfpObject()->groups as $group) {
            foreach ($group->members as $greatGrandchild) {
                if ($greatGrandchild instanceof Individual) {
                    $this->addPartnersOfGreatGrandchild($greatGrandchild, $this->partnerGroupName($group->groupName));
                }
            }
        }
    }

    /**
     * Add direct partners of one great-grandchild.
     */
    private function addPartnersOfGreatGrandchild(Individual $greatGrandchild, string $groupName): void
    {
        foreach ($greatGrandchild->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse->xref() !== $greatGrandchild->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($spouse, $family, $greatGrandchild), $groupName);
                }
            }
        }
    }

    /**
     * Get the corresponding great-grandchildren-in-law group name for a great-grandchildren group.
     */
    private function partnerGroupName(string $greatGrandchildGroupName): string
    {
        return match ($greatGrandchildGroupName) {
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIO          => self::GROUP_GREATGRANDCHILDRENINLAW_BIO,
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_SOCIAL_CHILD => self::GROUP_GREATGRANDCHILDRENINLAW_SOCIAL_CHILD,
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_CHILD_SOCIAL => self::GROUP_GREATGRANDCHILDRENINLAW_CHILD_SOCIAL,
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_CHILD_STEP   => self::GROUP_GREATGRANDCHILDRENINLAW_CHILD_STEP,
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_STEP         => self::GROUP_GREATGRANDCHILDRENINLAW_STEP,
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_STEP_SOCIAL  => self::GROUP_GREATGRANDCHILDRENINLAW_STEP_SOCIAL,
            Great_grandchildren::GROUP_GREATGRANDCHILDREN_STEP_STEP    => self::GROUP_GREATGRANDCHILDRENINLAW_STEP_STEP,
            default                                                    => self::GROUP_GREATGRANDCHILDRENINLAW_BIO,
        };
    }
}
