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

/* tbd
 *
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * class Nephews_and_nieces
 *
 * data and methods for extended family part "nephews_and_nieces"
 */
class Nephews_and_nieces extends ExtendedFamilyPart
{
    public const GROUP_NEPHEW_NIECES_CHILD_SIBLING         = 'Children of siblings';
    public const GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING = 'Siblings\' stepchildren';
    public const GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER = 'Children of siblings of partners';

    public const GROUP_NEPHEW_NIECES_CHILD_FULLSIBLING     = 'Children of full siblings';

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
     * Find members for this specific extended family part and modify $this->efpObject
     */
    protected function addEfpMembers()
    {
        foreach ($this->getProband()->childFamilies() as $family1) {                            // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ($sibling->xref() !== $this->getProband()->xref()) {
                            foreach ($sibling->spouseFamilies() as $family3) {                  // Gen  0 F
                                foreach ($family3->children() as $nephewniece) {                // Gen -1 P
                                    $this->addIndividualToFamily(new IndividualFamily($nephewniece, $family1, $sibling), self::GROUP_NEPHEW_NIECES_CHILD_SIBLING);
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->getProband()->childFamilies() as $family1) {                            // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ($sibling->xref() !== $this->getProband()->xref()) {
                            foreach ($sibling->spouseFamilies() as $family3) {                  // Gen  0 F
                                foreach ($family3->spouses() as $parent) {                      // Gen  0 P
                                    foreach ($parent->spouseFamilies() as $family4) {           // Gen  0 F
                                        foreach ($family4->children() as $nephewniece) {        // Gen -1 P
                                            $this->addIndividualToFamily(new IndividualFamily($nephewniece, $family1, $sibling), self::GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->getProband()->spouseFamilies() as $family0) {                                       // Gen  0 F
            foreach ($family0->spouses() as $spouse0) {                                                     // Gen  0 P
                if ($spouse0->xref() !== $this->getProband()->xref()) {
                    foreach ($spouse0->childFamilies() as $family1) {                                       // Gen  1 F
                        foreach ($family1->spouses() as $parent_in_law) {                                   // Gen  1 P
                            foreach ($parent_in_law->spouseFamilies() as $family2) {                        // Gen  1 F
                                foreach ($family2->children() as $sibling_in_law) {                         // Gen  0 P
                                    if ($sibling_in_law->xref() !== $spouse0->xref()) {
                                        foreach ($sibling_in_law->spouseFamilies() as $family3) {           // Gen  0 F
                                            foreach ($family3->children() as $nephewniece) {                // Gen -1 P
                                                $this->addIndividualToFamily(new IndividualFamily($nephewniece, $family0, $spouse0, $sibling_in_law), self::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER);
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
}
