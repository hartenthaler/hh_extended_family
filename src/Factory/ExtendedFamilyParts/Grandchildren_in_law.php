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
 * class Grandchildren_in_law
 *
 * Data and methods for extended family part "grandchildren_in_law".
 * The grandchildren family part is used as the basis; direct partners of the
 * individuals shown there are shown as grandchildren-in-law of the proband.
 */
class Grandchildren_in_law extends ExtendedFamilyPart
{
    public const GROUP_GRANDCHILDRENINLAW_BIO = 'Partners of biological grandchildren';
    public const GROUP_GRANDCHILDRENINLAW_SOCIAL_CHILD = 'Partners of social children of children';
    public const GROUP_GRANDCHILDRENINLAW_STEP_CHILD = 'Partners of stepchildren of children';
    public const GROUP_GRANDCHILDRENINLAW_CHILD_SOCIAL = 'Partners of children of social children';
    public const GROUP_GRANDCHILDRENINLAW_CHILD_STEP = 'Partners of children of stepchildren';
    public const GROUP_GRANDCHILDRENINLAW_STEP_STEP = 'Partners of stepchildren of stepchildren';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups                        array
     *  ->counts                        FamilyPartCounts
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->groupName           string
     *            ->members             array of Individual (index of groups is groupName)
     *            ->labels              array of array of string
     *            ->families            array of object
     *            ->familiesStatus      array of string
     *            ->referencePersons    array of array of Individual
     */

    /**
     * Find members for this specific extended family part and modify $this->efpObject
     */
    protected function addEfpMembers()
    {
        $grandchildren = new Grandchildren($this->getProband(), 'all', $this->placeFormat);

        foreach ($grandchildren->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $grandchild = $entry->individual;
                if ($grandchild instanceof Individual) {
                    $this->addPartnersOfGrandchild($grandchild, $this->partnerGroupName($group->groupName));
                }
            }
        }
    }

    /**
     * Add direct partners of one grandchild.
     */
    private function addPartnersOfGrandchild(Individual $grandchild, string $groupName): void
    {
        foreach ($grandchild->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse->xref() !== $grandchild->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($spouse, $family, $grandchild), $groupName);
                }
            }
        }
    }

    /**
     * Get the corresponding grandchildren-in-law group name for a grandchildren group.
     */
    private function partnerGroupName(string $grandchildGroupName): string
    {
        return match ($grandchildGroupName) {
            Grandchildren::GROUP_GRANDCHILDREN_BIO          => self::GROUP_GRANDCHILDRENINLAW_BIO,
            Grandchildren::GROUP_GRANDCHILDREN_SOCIAL_CHILD => self::GROUP_GRANDCHILDRENINLAW_SOCIAL_CHILD,
            Grandchildren::GROUP_GRANDCHILDREN_STEP_CHILD   => self::GROUP_GRANDCHILDRENINLAW_STEP_CHILD,
            Grandchildren::GROUP_GRANDCHILDREN_CHILD_SOCIAL => self::GROUP_GRANDCHILDRENINLAW_CHILD_SOCIAL,
            Grandchildren::GROUP_GRANDCHILDREN_CHILD_STEP   => self::GROUP_GRANDCHILDRENINLAW_CHILD_STEP,
            Grandchildren::GROUP_GRANDCHILDREN_STEP_STEP    => self::GROUP_GRANDCHILDRENINLAW_STEP_STEP,
            default                                         => self::GROUP_GRANDCHILDRENINLAW_BIO,
        };
    }
}
