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

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;

use function array_key_exists;
use function array_key_first;
use function in_array;

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
     *  ->groups                        array
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *   ->groups[]->members[]          array of object Individual   (index of groups is "spouse->xref()")
     *             ->familiesStatus[]   string
     *             ->labels[]           array of array of string
     *             ->partner            object Individual
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
    protected function addEfpMembers()
    {
        foreach ($this->getProband()->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                                 // Gen  0 P
                if ($spouse1->xref() !== $this->getProband()->xref()) {
                    $this->addIndividualToFamily(new IndividualFamily($spouse1, $family1, $this->getProband()));
                }
                foreach ($spouse1->spouseFamilies() as $family2) {                                      // Gen  0 F
                    foreach ($family2->spouses() as $spouse2) {                                         // Gen  0 P
                        if ($spouse2->xref() !== $spouse1->xref() && $spouse2->xref() !== $this->getProband()->xref()) {
                            $this->addIndividualToFamily(new IndividualFamily($spouse2, $family2, $spouse1));
                        }
                    }
                }
            }
        }
    }

    /**
     * filter individuals and count them per sex for this specific extended family part
     */
    protected function filterAndAddCounters($filterOption) {
        if ( $filterOption !== 'all' ) {
            $this->filter( ExtendedFamilySupport::convertfilterOptions($filterOption) );
        }
        $this->addCountersToFamilyPartObject();
        $this->addLevirateSororateLabels();
        $this->addAdditionalCountersPartners();
    }

    /**
     * add an individual and the corresponding family to the extended family part if it is not already member of this extended family part
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     */
    protected function addIndividualToFamily(IndividualFamily $indifam, string $groupName = '')
    {
         $familyStatus = $indifam->getFamily() === null
             ? ExtendedFamilySupport::FAM_STATUS_PARTNERSHIP
             : ExtendedFamilySupport::findFamilyStatus($indifam->getFamily());

         $this->addIndividualToFamilyAsPartner($indifam->getIndividual(), $indifam->getReferencePersons()[1], $familyStatus);
    }

    /**
     * add an individual to the extended family 'partners' if it is not already member of this extended family
     *
     * @param Individual $individual
     * @param Individual $spouse to which these partners are belonging
     * @param string $familyStatus
     */
    private function addIndividualToFamilyAsPartner(Individual $individual, Individual $spouse, string $familyStatus)
    {
        if ( array_key_exists($spouse->xref(), $this->efpObject->groups)) {    // check if this spouse is already stored as group in this part of the extended family
            foreach ($this->efpObject->groups[$spouse->xref()]->members as $member) {                                // check if individual is already a partner of this partner
                if ($individual->xref() == $member->xref()) {
                    return;
                }
            }
            $this->efpObject->groups[$spouse->xref()]->members[] = $individual;
            $this->efpObject->groups[$spouse->xref()]->familiesStatus[] = $familyStatus;
            $this->efpObject->groups[$spouse->xref()]->labels[] = [];
            $this->efpObject->groups[$spouse->xref()]->vitalEventsSummaries[] = $this->vitalEventsSummary($individual);
        } else {                                                                // generate new group of partners
            $newObj = (object)[];
            $newObj->members[] = $individual;
            $newObj->familiesStatus[] = $familyStatus;
            $newObj->labels[] = [];
            $newObj->vitalEventsSummaries[] = $this->vitalEventsSummary($individual);
            $newObj->partner = $spouse;
            $this->efpObject->groups[$spouse->xref()] = $newObj;
        }
    }

    /**
     * Add levirate/sororate labels if partners of the same person are siblings.
     *
     * @return void
     */
    private function addLevirateSororateLabels(): void
    {
        foreach ($this->efpObject->groups as $group) {
            foreach ($group->members as $key => $partner) {
                $label = $this->levirateSororateLabel($partner, $group->members, $key);

                if ($label !== '') {
                    $group->labels[$key][] = $label;
                }
            }
        }
    }

    /**
     * Get a levirate/sororate label for a partner if a same-sex sibling is also a partner.
     *
     * @param Individual $partner
     * @param array<int,Individual> $partners
     * @param int|string $partnerKey
     * @return string
     */
    private function levirateSororateLabel(Individual $partner, array $partners, int|string $partnerKey): string
    {
        if (!in_array($partner->sex(), ['M', 'F'], true)) {
            return '';
        }

        foreach ($partners as $otherKey => $otherPartner) {
            if ($otherKey === $partnerKey || $otherPartner->sex() !== $partner->sex()) {
                continue;
            }

            if (ExtendedFamilySupport::areSiblings($partner, $otherPartner)) {
                return $partner->sex() === 'M'
                    ? I18N::translate('Levirate')
                    : I18N::translate('Sororate');
            }
        }

        return '';
    }

    /**
     * additional counting of individuals for partners
     */
    private function addAdditionalCountersPartners()
    {
        if (array_key_first($this->efpObject->groups)) {
            $count = $this->countMaleFemale($this->efpObject->groups[array_key_first($this->efpObject->groups)]->members);
        } else {                            // error: this should not happen
            $count=(object)[];
            list ($count->male, $count->female, $count->unknown_others) = [0, 0, 0];
        }

        $this->efpObject->pmaleCount = $count->male;
        $this->efpObject->pfemaleCount = $count->female;
        $this->efpObject->potherSexCount = $count->unknown_others;
        $this->efpObject->pCount = $count->male + $count->female + $count->unknown_others;

        $this->efpObject->popmaleCount = $this->efpObject->maleCount - $count->male;
        $this->efpObject->popfemaleCount = $this->efpObject->femaleCount - $count->female;
        $this->efpObject->popotherSexCount = $this->efpObject->otherSexCount - $count->unknown_others;
        $this->efpObject->popCount = $this->efpObject->allCount - $this->efpObject->pCount;
    }
}
