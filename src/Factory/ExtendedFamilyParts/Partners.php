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
 * class Partners
 *
 * data and methods for extended family part "partners" (including partners of partners)
 */
class Partners extends ExtendedFamilyPart
{
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
     *   ->groups[]->members[]          array of object individual   (index of groups is "spouse->xref()")
     *             ->partner            object individual
     *   ->pCount                       int
     *   ->pmaleCount                   int
     *   ->pfemaleCount                 int
     *   ->potherSexCount               int
     *   ->popCount                     int
     *   ->popmaleCount                 int
     *   ->popfemaleCount               int
     *   ->popotherSexCount             int
     */

    /**
     * add members for this specific extended family part and modify $this->>efpObject
     */
    protected function _addEfpMembers()
    {
        foreach ($this->_proband->spouseFamilies() as $family1) {                                               // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                                         // Gen  0 P
                if ( $spouse1->xref() !== $this->_proband->xref() ) {
                    $this->_addIndividualToFamily( new IndividualFamily($spouse1, null), '', $this->_proband );
                }
                foreach ($spouse1->spouseFamilies() as $family2) {                                              // Gen  0 F
                    foreach ($family2->spouses() as $spouse2) {                                                 // Gen  0 P
                        if ( $spouse2->xref() !== $spouse1->xref() && $spouse2->xref() !== $this->_proband->xref() ) {
                            $this->_addIndividualToFamily( new IndividualFamily($spouse2, null), '', $spouse1 );
                        }
                    }
                }
            }
        }
    }

    /**
     * filter individuals and count them per sex for this specific extended family part
     */
    protected function _filterAndAddCounters($filterOption) {
        if ( $filterOption !== 'all' ) {
            $this->_filter( ExtendedFamily::convertfilterOptions($filterOption) );
        }
        $this->_addCountersToFamilyPartObject();
        $this->_addAdditionalCountersPartners();
    }

    /**
     * add an individual and the corresponding family to the extended family part if it is not already member of this extended family part
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     * @param Individual|null $referencePerson
     * @param Individual|null $referencePerson2
     */
    protected function _addIndividualToFamily(IndividualFamily $indifam, string $groupName = '', Individual $referencePerson = null, Individual $referencePerson2 = null )
    {
         $this->_addIndividualToFamilyAsPartner($indifam->getIndividual(), $referencePerson);
    }

    /**
     * add an individual to the extended family 'partners' if it is not already member of this extended family
     *
     * @param Individual $individual
     * @param Individual $spouse to which these partners are belonging
     */
    private function _addIndividualToFamilyAsPartner(Individual $individual, Individual $spouse)
    {
        $found = false;
        //error_log('Soll ' . $individual->xref() . ' als Partner von ' . $spouse->xref() . ' hinzugefuegt werden? ');
        if ( array_key_exists ( $spouse->xref(), $this->_efpObject->groups) ) {               // check if this spouse is already stored as group in this part of the extended family
            //error_log($spouse->xref() . ' definiert bereits eine Gruppe. ');
            $efp = $this->_efpObject->groups[$spouse->xref()];
            foreach ($efp->members as $member) {                                                // check if individual is already a partner of this partner
                //error_log('Teste Ehepartner ' . $member->xref() . ' in Gruppe fuer ' . $spouse->xref() . ': ');
                if ( $individual->xref() == $member->xref() ) {
                    $found = true;
                    //error_log('Person ' . $individual->xref() . ' ist bereits als Partner von ' . $spouse->xref() . ' vorhanden. ');
                    break;
                }
            }
            if ( !$found ) {                                                                    // add individual to existing partner group
                //error_log('Person ' . $individual->xref() . ' wird als Partner von ' . $spouse->xref() . ' hinzugefuegt. ');
                $this->_efpObject->groups[$spouse->xref()]->members[] = $individual;
            }
        } else {                                                                                // generate new group of partners
            $newObj = (object)[];
            $newObj->members[] = $individual;
            $newObj->partner = $spouse;
            //error_log(print_r($newObj, true));
            $this->_efpObject->groups[$spouse->xref()] = $newObj;
            //error_log('Neu hinzugefuegte Gruppe fuer: ' . $spouse->xref() . ' (Person ' . $individual->xref() . ' als Partner hier hinzugefuegt). ');
        }
    }

    /**
     * additional counting of individuals for partners
     */
    private function _addAdditionalCountersPartners()
    {
        if (array_key_first($this->_efpObject->groups)) {
            $count = $this->_countMaleFemale($this->_efpObject->groups[array_key_first($this->_efpObject->groups)]->members);
        } else {                            // error: this should not happen
            $count=(object)[];
            list ($count->male, $count->female, $count->unknown_others) = [0, 0, 0];
        }

        $this->_efpObject->pmaleCount = $count->male;
        $this->_efpObject->pfemaleCount = $count->female;
        $this->_efpObject->potherSexCount = $count->unknown_others;
        $this->_efpObject->pCount = $count->male + $count->female + $count->unknown_others;

        $this->_efpObject->popmaleCount = $this->_efpObject->maleCount - $count->male;
        $this->_efpObject->popfemaleCount = $this->_efpObject->femaleCount - $count->female;
        $this->_efpObject->popotherSexCount = $this->_efpObject->otherSexCount - $count->unknown_others;
        $this->_efpObject->popCount = $this->_efpObject->allCount - $this->_efpObject->pCount;
    }
}
