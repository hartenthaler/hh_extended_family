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
 * class Cousins
 *
 * Data and methods for extended family part "cousins".
 * The uncles-and-aunts family part is used as the basis; children of the
 * individuals shown there are shown as first cousins of the proband.
 */
class Cousins extends ExtendedFamilyPart
{
    public const GROUP_COUSINS_FULL_FATHER = 'Children of full siblings of father';
    public const GROUP_COUSINS_FULL_MOTHER = 'Children of full siblings of mother';
    public const GROUP_COUSINS_FULL_U      = 'Children of full siblings of parent';
    public const GROUP_COUSINS_HALF_FATHER = 'Children of half siblings of father';
    public const GROUP_COUSINS_HALF_MOTHER = 'Children of half siblings of mother';
    public const GROUP_COUSINS_HALF_U      = 'Children of half siblings of parent';
    public const GROUP_COUSINS_FULL_SOCIAL = 'Children of full siblings of social parents';
    public const GROUP_COUSINS_HALF_SOCIAL = 'Children of half siblings of social parents';
    public const GROUP_COUSINS_FULL_STEP   = 'Children of full siblings of stepparents';
    public const GROUP_COUSINS_HALF_STEP   = 'Children of half siblings of stepparents';

    public const GROUP_COUSINS_FULL_BIO    = 'Children of full siblings of biological parents';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $unclesAndAunts = new Uncles_and_aunts($this->getProband(), 'all', $this->placeFormat);

        foreach ($unclesAndAunts->getEfpObject()->groups as $group) {
            foreach ($group->members as $key => $uncleAunt) {
                $referenceParent = $group->referencePersons[$key][1] ?? null;

                if ($uncleAunt instanceof Individual && $referenceParent instanceof Individual) {
                    $this->addChildrenOfUncleOrAunt(
                        $uncleAunt,
                        $referenceParent,
                        $this->cousinsGroupName($group->groupName, $uncleAunt, $referenceParent)
                    );
                }
            }
        }
    }

    /**
     * Add children of one uncle or aunt.
     *
     * @param Individual $uncleAunt
     * @param Individual $referenceParent
     * @param string $groupName
     * @return void
     */
    private function addChildrenOfUncleOrAunt(Individual $uncleAunt, Individual $referenceParent, string $groupName): void
    {
        foreach ($uncleAunt->spouseFamilies() as $family) {
            foreach ($family->children() as $cousin) {
                $this->addIndividualToFamily(new IndividualFamily($cousin, $family, $uncleAunt, $referenceParent), $groupName);
            }
        }
    }

    /**
     * Get the group name for children of one uncle or aunt.
     *
     * @param string $unclesAndAuntsGroupName
     * @param Individual $uncleAunt
     * @param Individual $referenceParent
     * @return string
     */
    private function cousinsGroupName(string $unclesAndAuntsGroupName, Individual $uncleAunt, Individual $referenceParent): string
    {
        $isHalfSibling = ExtendedFamilySupport::areHalfSiblings($uncleAunt, $referenceParent);

        if ($unclesAndAuntsGroupName === Uncles_and_aunts::GROUP_UNCLEAUNT_SOCIAL_PARENT) {
            return $isHalfSibling ? self::GROUP_COUSINS_HALF_SOCIAL : self::GROUP_COUSINS_FULL_SOCIAL;
        }

        if ($unclesAndAuntsGroupName === Uncles_and_aunts::GROUP_UNCLEAUNT_STEP_PARENT) {
            return $isHalfSibling ? self::GROUP_COUSINS_HALF_STEP : self::GROUP_COUSINS_FULL_STEP;
        }

        return match ($referenceParent->sex()) {
            'M'     => $isHalfSibling ? self::GROUP_COUSINS_HALF_FATHER : self::GROUP_COUSINS_FULL_FATHER,
            'F'     => $isHalfSibling ? self::GROUP_COUSINS_HALF_MOTHER : self::GROUP_COUSINS_FULL_MOTHER,
            default => $isHalfSibling ? self::GROUP_COUSINS_HALF_U : self::GROUP_COUSINS_FULL_U,
        };
    }
}
