<?php
/*
 * webtrees - extended family part
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
 * class FamilyPart
 *
 * object to store a family part used by some of the extended family parts
 */
class FamilyPart
{
    // ------------ definition of data structures

    /**
     * @var object $familyPart
     *  -> groupName        string
     *  -> members          array of Individual
     *  -> labels           array of array of string
     *  -> families         array of object
     *  -> familiesStatus   array of string
     *  -> referencePersons array of array of Individual
     */
    private $familyPart;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param string $groupName
     * @param Individual $member
     * @param array $labels
     * @param object $family
     * @param string $familyStatus
     * @param array $referencePersons
     */
    public function __construct
        (
            string $groupName,
            Individual $member,
            array $labels,
            object $family,
            string $familyStatus,
            array $referencePersons
        )
    {
        $this->familyPart = (object)[];
        $this->familyPart->groupName = $groupName;
        $this->familyPart->members[] = $member;
        $this->familyPart->labels[] = $labels;
        $this->familyPart->families[] = $family;
        $this->familyPart->familiesStatus[] = $familyStatus;
        $this->familyPart->referencePersons[] = $referencePersons;
    }

    /**
     * get object family part
     *
     * @return object
     */
    public function getFamilyPart(): object
    {
        return $this->familyPart;
    }
}
