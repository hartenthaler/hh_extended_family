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
 * class Co_siblings_in_law
 *
 * data and methods for extended family part "co_siblings_in_law" (partner's sibling's partner and sibling's partner's sibling)
 */
class Co_siblings_in_law extends ExtendedFamilyPart
{
    public const GROUP_COSIBLINGSINLAW_SIBPARSIB = 'Siblings of siblings-in-law';       // sibling's partner's sibling
    public const GROUP_COSIBLINGSINLAW_PARSIBPAR = 'Partners of siblings-in-law';       // partner's sibling's partner';

    /**
     * @var object $_efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->members[]           array of Individual (index of groups is groupName)
     *            ->labels[]            array of array of string
     *            ->families[]          array of object
     *            ->familiesStatus[]    string
     *            ->referencePersons[]  array of array of Individual
     *            ->groupName           string
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject
     */
    protected function addEfpMembers()
    {
        foreach ($this->getProband()->childFamilies() as $family1) {                            // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full->xref() !== $this->getProband()->xref()) {
                    foreach ($sibling_full->spouseFamilies() as $family2) {                     // Gen  0 F
                        foreach ($family2->spouses() as $spouse) {                              // Gen  0 P
                            if ($spouse->xref() !== $sibling_full->xref()) {
                                foreach ($spouse->childFamilies() as $family3) {                // Gen  1 F
                                    foreach ($family3->children() as $co_sibling_full) {        // Gen  0 P
                                        if ($co_sibling_full->xref() !== $spouse->xref()) {
                                            $this->addIndividualToFamily(new IndividualFamily($co_sibling_full, $family3, $spouse), self::GROUP_COSIBLINGSINLAW_SIBPARSIB);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->getProband()->spouseFamilies() as $family1) {                           // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1->xref() !== $this->getProband()->xref() ) {
                    foreach ($spouse1->childFamilies() as $family2) {                           // Gen  1 F
                        foreach ($family2->children() as $sibling) {                            // Gen  0 P
                            if ($sibling->xref() !== $spouse1->xref()) {
                                foreach ($sibling->spouseFamilies() as $family3) {
                                    foreach ($family3->spouses() as $cosiblinginlaw) {
                                        if ($cosiblinginlaw->xref() !== $sibling->xref()) {
                                            $this->addIndividualToFamily(new IndividualFamily($cosiblinginlaw, $family3, $sibling), self::GROUP_COSIBLINGSINLAW_PARSIBPAR);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
