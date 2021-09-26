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
     *            ->referencePersons[]  Individual
     *            ->referencePersons2[] Individual
     *            ->groupName           string
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject
     */
    protected function _addEfpMembers()
    {
        foreach ($this->_proband->childFamilies() as $family1) {                                // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full->xref() !== $this->_proband->xref()) {
                    foreach ($sibling_full->spouseFamilies() as $family2) {                     // Gen  0 F
                        foreach ($family2->spouses() as $spouse) {                              // Gen  0 P
                            if ( $spouse->xref() !== $sibling_full->xref() ) {
                                $this->_addIndividualToFamily(new IndividualFamily($spouse, $family2), self::GROUP_SIBLINGSINLAW_POFSIB, $sibling_full );
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->_proband->spouseFamilies() as $family1) {                               // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1->xref() !== $this->_proband->xref() ) {
                    foreach ($spouse1->childFamilies() as $family2) {                           // Gen  1 F
                        foreach ($family2->children() as $sibling) {                            // Gen  0 P
                            if ($sibling->xref() !== $spouse1->xref()) {
                                $this->_addIndividualToFamily(new IndividualFamily($sibling, $family1), self::GROUP_SIBLINGSINLAW_SIBOFP, $spouse1 );
                            }
                        }
                    }
                }
            }
        }
    }
}