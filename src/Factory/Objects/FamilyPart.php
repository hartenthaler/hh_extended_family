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
use Fisharebest\Webtrees\Family;

/**
 * class FamilyPart
 *
 * object to store a family-part group
 * this is used by some extended family parts
 */
class FamilyPart
{
    // ------------ definition of data structures

    /**
     * @var FamilyPartGroup $familyPart
     */
    private FamilyPartGroup $familyPart;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param string $groupName
     * @param Individual $member
     * @param array<int,string> $labels
     * @param Family|null $family
     * @param string $familyStatus
     * @param array<int,Individual> $referencePersons
     * @param string $vitalEventsSummary
     */
    public function __construct
        (
            string $groupName,
            Individual $member,
            array $labels,
            ?Family $family,
            string $familyStatus,
            array $referencePersons,
            string $vitalEventsSummary
        )
    {
        $this->familyPart = new FamilyPartGroup($groupName);
        $this->familyPart->addEntry(new GroupEntry($member, $family, $familyStatus, $referencePersons, $labels, $vitalEventsSummary));
    }

    /**
     * get object family part
     *
     * @return FamilyPartGroup
     */
    public function getFamilyPart(): FamilyPartGroup
    {
        return $this->familyPart;
    }
}
