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
 * class Siblings
 *
 * Data and methods for extended family part "siblings".
 * The parents family part is used as the basis; siblings are derived from the
 * biological, social, and step-parent branches of the proband.
 */
class Siblings extends ExtendedFamilyPart
{
    public const GROUP_SIBLINGS_FULL   = 'Full siblings';
    public const GROUP_SIBLINGS_HALF   = 'Half siblings';
    public const GROUP_SIBLINGS_SOCIAL = 'Social siblings';
    public const GROUP_SIBLINGS_STEP   = 'Stepsiblings';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $parents = new Parents($this->getProband(), 'all', $this->placeFormat);

        foreach ($parents->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $parent = $entry->individual;
                $family = $entry->family;

                if ($parent instanceof Individual && $family instanceof Family) {
                    $this->addSiblingsForParent($parent, $family, $group->groupName);
                }
            }
        }
    }

    /**
     * Add siblings derived from one parent entry.
     *
     * @param Individual $parent
     * @param Family $family
     * @param string $parentGroupName
     * @return void
     */
    private function addSiblingsForParent(Individual $parent, Family $family, string $parentGroupName): void
    {
        if ($parentGroupName === Parents::GROUP_PARENTS_BIO) {
            $this->addFullSiblingsFromFamily($family);
            $this->addHalfSiblingsFromOtherFamilies($parent, $family);
            return;
        }

        if ($parentGroupName === Parents::GROUP_PARENTS_SOCIAL) {
            $this->addSocialSiblingsFromFamily($family);
            return;
        }

        if ($parentGroupName === Parents::GROUP_PARENTS_STEP) {
            $this->addStepSiblingsFromStepParent($parent);
        }
    }

    /**
     * Add biological siblings from the same parent-family as the proband.
     *
     * @param Family $family
     * @return void
     */
    private function addFullSiblingsFromFamily(Family $family): void
    {
        foreach ($family->children() as $sibling) {
            if ($sibling->xref() !== $this->getProband()->xref() && $this->isBiologicalChildInFamily($sibling, $family)) {
                $this->addIndividualToFamily(new IndividualFamily($sibling, $family), self::GROUP_SIBLINGS_FULL);
            }
        }
    }

    /**
     * Add biological half siblings from the other families of one biological parent.
     *
     * @param Individual $parent
     * @param Family $probandFamily
     * @return void
     */
    private function addHalfSiblingsFromOtherFamilies(Individual $parent, Family $probandFamily): void
    {
        foreach ($parent->spouseFamilies() as $family) {
            if ($family->xref() === $probandFamily->xref()) {
                continue;
            }

            foreach ($family->children() as $sibling) {
                if ($sibling->xref() !== $this->getProband()->xref() && $this->isBiologicalChildInFamily($sibling, $family)) {
                    $this->addIndividualToFamily(new IndividualFamily($sibling, $family), self::GROUP_SIBLINGS_HALF);
                }
            }
        }
    }

    /**
     * Add siblings from the same social parent-family as the proband.
     *
     * @param Family $family
     * @return void
     */
    private function addSocialSiblingsFromFamily(Family $family): void
    {
        foreach ($family->children() as $sibling) {
            if ($sibling->xref() !== $this->getProband()->xref()) {
                $this->addIndividualToFamily(new IndividualFamily($sibling, $family), self::GROUP_SIBLINGS_SOCIAL);
            }
        }
    }

    /**
     * Add children of one stepparent as stepsiblings.
     *
     * @param Individual $stepparent
     * @return void
     */
    private function addStepSiblingsFromStepParent(Individual $stepparent): void
    {
        foreach ($stepparent->spouseFamilies() as $family) {
            foreach ($family->children() as $sibling) {
                if ($sibling->xref() !== $this->getProband()->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($sibling, $family), self::GROUP_SIBLINGS_STEP);
                }
            }
        }
    }
}
