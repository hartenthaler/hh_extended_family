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
 * maybe use find...Individuals() instead of foreach-structures
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * class Parents_in_law
 *
 * data and methods for extended family part Parents-in-law
 */
class Parents_in_law extends ExtendedFamilyPart
{
    // named groups ar not used for parents in law (instead the marriages are used for grouping)
    // public const GROUP_PARENTSINLAW_BIO  = 'Biological parents of partner';
    // public const GROUP_PARENTSINLAW_STEP = 'Stepparents of partner';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array f object
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->groupName           string
     *            ->members             array of Individual (index of groups is int)
     *            ->family              object family
     *            ->familyStatus        string
     *            ->partner             Individual
     *            ->partnerFamilyStatus string
     */

    /**
     * Find members for this specific extended family part and modify $this->efpObject
     */
    protected function addEfpMembers()
    {
        foreach ($this->getProband()->spouseFamilies() as $family) {                            // Gen  0 F
            foreach ($family->spouses() as $spouse) {                                           // Gen  0 P
                if ($spouse->xref() !== $this->getProband()->xref()) {
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->husband() instanceof Individual)) {
                        $this->addIndividualToFamily(new IndividualFamily($spouse->childFamilies()->first()->husband(), $spouse->childFamilies()->first(), $spouse));
                    }
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->wife() instanceof Individual)) {
                        $this->addIndividualToFamily(new IndividualFamily($spouse->childFamilies()->first()->wife(), $spouse->childFamilies()->first(), $spouse));
                    }
                }
            }
        }
    }

    /**
     * add an individual and the corresponding family to the extended family part if it is not already member of this extended family part
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     */
    protected function addIndividualToFamily(IndividualFamily $indifam, string $groupName = '')
    {
        $this->addIndividualToFamilyAsParentInLaw($indifam);
    }

    /**
     * add an individual to the extended family 'partners' if it is not already member of this extended family
     *
     * @param IndividualFamily $indifam
     */
    private function addIndividualToFamilyAsParentInLaw(IndividualFamily $indifam)
    {
        if ($this->isIndividualAlreadyMember($indifam)) {
            return;
        }
        foreach ($this->efpObject->groups as $famkey => $groupObj) {                    // check if this family is already stored in this part of the extended family
            if ($groupObj->family->xref() == $indifam->getFamily()->xref()) {           // family exists already
                $this->efpObject->groups[$famkey]->members[] = $indifam->getIndividual();
                return;
            }
        }
        $newObj = (object)[];                                           // individual not found and family not found
        $newObj->members[] = $indifam->getIndividual();
        $newObj->family = $indifam->getFamily();
        $newObj->familyStatus = ExtendedFamilySupport::findFamilyStatus($indifam->getFamily());
        if (isset($indifam->getReferencePersons()[1])) {
            $newObj->partner = $indifam->getReferencePersons()[1];
            foreach ($this->getProband()->spouseFamilies() as $fam) {
                foreach ($fam->spouses() as $partner) {
                    if ($partner->xref() == $indifam->getReferencePersons()[1]->xref()) {
                        $newObj->partnerFamilyStatus = ExtendedFamilySupport::findFamilyStatus($fam);
                    }
                }
            }
        }
        $this->efpObject->groups[] = $newObj;
    }
}
