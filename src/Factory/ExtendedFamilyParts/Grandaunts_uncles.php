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
 * class Grandaunts_uncles
 *
 * data and methods for extended family part "grandaunts_uncles"
 */
class Grandaunts_uncles extends ExtendedFamilyPart
{
    public const GROUP_GRANDAUNTUNCLE_BIO_GRANDPARENT    = 'Siblings and half siblings of biological grandparents';
    public const GROUP_GRANDAUNTUNCLE_SOCIAL_GRANDPARENT = 'Siblings and half siblings of social grandparents';
    public const GROUP_GRANDAUNTUNCLE_STEP_GRANDPARENT   = 'Siblings and half siblings of stepgrandparents';

    public const GROUP_GRANDAUNTUNCLE_FULL_BIO = 'Full siblings of biological grandparents';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     *
     * This part is derived from the grandparents family part, so biological,
     * social, and step-grandparent distinctions are preserved.
     */
    protected function addEfpMembers()
    {
        $grandparents = new Grandparents($this->getProband(), 'all', $this->placeFormat);

        foreach ($grandparents->getEfpObject()->groups as $group) {
            $groupName = $this->grandauntsAndGrandunclesGroupName($group->groupName);

            foreach ($group->entries as $entry) {
                $grandparent = $entry->individual;
                if ($grandparent instanceof Individual) {
                    $this->addGrandauntsAndGrandunclesForGrandparent($grandparent, $groupName);
                }
            }
        }
    }

    private function grandauntsAndGrandunclesGroupName(string $grandparentGroupName): string
    {
        return match ($grandparentGroupName) {
            Grandparents::GROUP_GRANDPARENTS_FATHER_SOCIAL,
            Grandparents::GROUP_GRANDPARENTS_MOTHER_SOCIAL,
            Grandparents::GROUP_GRANDPARENTS_U_SOCIAL,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT => self::GROUP_GRANDAUNTUNCLE_SOCIAL_GRANDPARENT,

            Grandparents::GROUP_GRANDPARENTS_FATHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_MOTHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_U_STEP,
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENTS,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_FATHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_MOTHER_STEP,
            Grandparents::GROUP_GRANDPARENTS_SOCIAL_PARENT_STEP,
            Grandparents::GROUP_GRANDPARENTS_STEP_PARENT_STEP => self::GROUP_GRANDAUNTUNCLE_STEP_GRANDPARENT,

            default => self::GROUP_GRANDAUNTUNCLE_BIO_GRANDPARENT,
        };
    }

    private function addGrandauntsAndGrandunclesForGrandparent(Individual $grandparent, string $groupName): void
    {
        foreach ($grandparent->childFamilies() as $grandparentFamily) {
            if (!$this->isBiologicalChildInFamily($grandparent, $grandparentFamily)) {
                continue;
            }

            $this->addFullSiblingsOfGrandparent($grandparent, $grandparentFamily, $groupName);
            $this->addHalfSiblingsOfGrandparent($grandparent, $grandparentFamily, $groupName);
        }
    }

    private function addFullSiblingsOfGrandparent(Individual $grandparent, Family $grandparentFamily, string $groupName): void
    {
        foreach ($grandparentFamily->children() as $grandauntGranduncle) {
            if ($grandauntGranduncle->xref() !== $grandparent->xref() && $this->isBiologicalChildInFamily($grandauntGranduncle, $grandparentFamily)) {
                $this->addIndividualToFamily(new IndividualFamily($grandauntGranduncle, $grandparentFamily, $grandparent), $groupName);
            }
        }
    }

    private function addHalfSiblingsOfGrandparent(Individual $grandparent, Family $grandparentFamily, string $groupName): void
    {
        foreach ($grandparentFamily->spouses() as $greatGrandparent) {
            foreach ($greatGrandparent->spouseFamilies() as $halfSiblingFamily) {
                if ($halfSiblingFamily->xref() === $grandparentFamily->xref()) {
                    continue;
                }

                foreach ($halfSiblingFamily->children() as $grandauntGranduncle) {
                    if ($grandauntGranduncle->xref() !== $grandparent->xref() && $this->isBiologicalChildInFamily($grandauntGranduncle, $halfSiblingFamily)) {
                        $this->addIndividualToFamily(new IndividualFamily($grandauntGranduncle, $halfSiblingFamily, $grandparent), $groupName);
                    }
                }
            }
        }
    }
}
