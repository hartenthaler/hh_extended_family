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
 * class Siblings_in_law
 *
 * data and methods for extended family part "siblings_in_law" (partners of siblings and siblings of partners)
 */
class Siblings_in_law extends ExtendedFamilyPart
{
    public const GROUP_SIBLINGSINLAW_SIBOFP = 'Siblings of partners';
    public const GROUP_SIBLINGSINLAW_POFSIB = 'Partners of siblings';

    /**
     * @var object $efpObject data structure for this extended family part
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
        $siblings = new Siblings($this->getProband(), 'all', $this->placeFormat);

        foreach ($siblings->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $sibling = $entry->individual;
                if ($sibling instanceof Individual) {
                    $this->addPartnersOfSibling($sibling);
                }
            }
        }

        foreach ($this->findPartnersIndividuals($this->getProband()) as $partner) {
            $this->addSiblingsOfPartner($partner);
        }
    }

    /**
     * Add direct partners of one sibling.
     *
     * @param Individual $sibling
     * @return void
     */
    private function addPartnersOfSibling(Individual $sibling): void
    {
        foreach ($sibling->spouseFamilies() as $family) {
            foreach ($family->spouses() as $partner) {
                if ($partner->xref() !== $sibling->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($partner, $family, $sibling), self::GROUP_SIBLINGSINLAW_POFSIB);
                }
            }
        }
    }

    /**
     * Add siblings of one direct partner.
     *
     * @param IndividualFamily $partner
     * @return void
     */
    private function addSiblingsOfPartner(IndividualFamily $partner): void
    {
        $siblingsOfPartner = new Siblings($partner->getIndividual(), 'all', $this->placeFormat);

        foreach ($siblingsOfPartner->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $sibling = $entry->individual;
                if ($sibling instanceof Individual) {
                    $this->addIndividualToFamily(
                        new IndividualFamily($sibling, $partner->getFamily(), $partner->getIndividual()),
                        self::GROUP_SIBLINGSINLAW_SIBOFP
                    );
                }
            }
        }
    }
}
