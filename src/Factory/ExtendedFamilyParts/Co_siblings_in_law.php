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
 * class Co_siblings_in_law
 *
 * Data and methods for extended family part "co_siblings_in_law".
 * The siblings-in-law family part is used as the basis; this part adds siblings
 * of siblings' partners and partners of partners' siblings.
 */
class Co_siblings_in_law extends ExtendedFamilyPart
{
    public const GROUP_COSIBLINGSINLAW_SIBPARSIB = 'Siblings of siblings-in-law';
    public const GROUP_COSIBLINGSINLAW_PARSIBPAR = 'Partners of siblings-in-law';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $siblingsInLaw = new Siblings_in_law($this->getProband(), 'all', $this->placeFormat);

        foreach ($siblingsInLaw->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $siblingInLaw = $entry->individual;
                if (!$siblingInLaw instanceof Individual) {
                    continue;
                }

                if ($group->groupName === Siblings_in_law::GROUP_SIBLINGSINLAW_POFSIB) {
                    $this->addSiblingsOfSiblingInLaw($siblingInLaw);
                } elseif ($group->groupName === Siblings_in_law::GROUP_SIBLINGSINLAW_SIBOFP) {
                    $this->addPartnersOfSiblingInLaw($siblingInLaw);
                }
            }
        }
    }

    /**
     * Add siblings of one sibling-in-law.
     *
     * @param Individual $siblingInLaw
     * @return void
     */
    private function addSiblingsOfSiblingInLaw(Individual $siblingInLaw): void
    {
        $siblings = new Siblings($siblingInLaw, 'all', $this->placeFormat);

        foreach ($siblings->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $sibling = $entry->individual;
                if ($sibling instanceof Individual) {
                    $this->addIndividualToFamily(
                        new IndividualFamily($sibling, $entry->family, $siblingInLaw),
                        self::GROUP_COSIBLINGSINLAW_SIBPARSIB
                    );
                }
            }
        }
    }

    /**
     * Add partners of one sibling-in-law.
     *
     * @param Individual $siblingInLaw
     * @return void
     */
    private function addPartnersOfSiblingInLaw(Individual $siblingInLaw): void
    {
        foreach ($siblingInLaw->spouseFamilies() as $family) {
            foreach ($family->spouses() as $partner) {
                if ($partner->xref() !== $siblingInLaw->xref()) {
                    $this->addIndividualToFamily(
                        new IndividualFamily($partner, $family, $siblingInLaw),
                        self::GROUP_COSIBLINGSINLAW_PARSIBPAR
                    );
                }
            }
        }
    }
}
