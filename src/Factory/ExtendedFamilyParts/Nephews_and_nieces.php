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
 * class Nephews_and_nieces
 *
 * Data and methods for extended family part "nephews_and_nieces".
 * The siblings and siblings-in-law family parts are used as the basis.
 */
class Nephews_and_nieces extends ExtendedFamilyPart
{
    public const GROUP_NEPHEW_NIECES_CHILD_SIBLING         = 'Children of siblings';
    public const GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING = 'Siblings\' stepchildren';
    public const GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER = 'Children of siblings of partners';

    public const GROUP_NEPHEW_NIECES_CHILD_FULLSIBLING     = 'Biological children of biological full siblings';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $siblings = new Siblings($this->getProband(), 'all', $this->placeFormat);

        foreach ($siblings->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $sibling = $entry->individual;
                if ($sibling instanceof Individual) {
                    $this->addChildrenOfSibling($sibling);
                    $this->addStepchildrenOfSibling($sibling);
                }
            }
        }

        $siblingsInLaw = new Siblings_in_law($this->getProband(), 'all', $this->placeFormat);

        foreach ($siblingsInLaw->getEfpObject()->groups as $group) {
            if ($group->groupName !== Siblings_in_law::GROUP_SIBLINGSINLAW_SIBOFP) {
                continue;
            }

            foreach ($group->entries as $entry) {
                $siblingInLaw = $entry->individual;
                $partner = $entry->referencePersons[1] ?? null;

                if ($siblingInLaw instanceof Individual && $partner instanceof Individual) {
                    $this->addChildrenOfPartnersSibling($siblingInLaw, $partner);
                }
            }
        }
    }

    /**
     * Add children of one sibling.
     *
     * @param Individual $sibling
     * @return void
     */
    private function addChildrenOfSibling(Individual $sibling): void
    {
        foreach ($sibling->spouseFamilies() as $family) {
            foreach ($family->children() as $child) {
                $this->addIndividualToFamily(new IndividualFamily($child, $family, $sibling), self::GROUP_NEPHEW_NIECES_CHILD_SIBLING);
            }
        }
    }

    /**
     * Add stepchildren of one sibling.
     *
     * Stepchildren are children of a sibling's partner from another family.
     *
     * @param Individual $sibling
     * @return void
     */
    private function addStepchildrenOfSibling(Individual $sibling): void
    {
        foreach ($sibling->spouseFamilies() as $family) {
            foreach ($family->spouses() as $partner) {
                if ($partner->xref() === $sibling->xref()) {
                    continue;
                }

                foreach ($partner->spouseFamilies() as $stepFamily) {
                    if ($stepFamily->xref() === $family->xref()) {
                        continue;
                    }

                    foreach ($stepFamily->children() as $stepchild) {
                        $this->addIndividualToFamily(new IndividualFamily($stepchild, $family, $sibling), self::GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING);
                    }
                }
            }
        }
    }

    /**
     * Add children of one sibling of a partner.
     *
     * @param Individual $siblingInLaw
     * @param Individual $partner
     * @return void
     */
    private function addChildrenOfPartnersSibling(Individual $siblingInLaw, Individual $partner): void
    {
        foreach ($siblingInLaw->spouseFamilies() as $family) {
            foreach ($family->children() as $child) {
                $this->addIndividualToFamily(new IndividualFamily($child, $family, $partner, $siblingInLaw), self::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER);
            }
        }
    }
}
