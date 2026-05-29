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

use Fisharebest\Webtrees\Family;
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
     *  ->counts                        FamilyPartCounts
     *  ->maleCount                     int legacy alias
     *  ->femaleCount                   int legacy alias
     *  ->otherSexCount                 int legacy alias
     *  ->allCount                      int legacy alias
     *  ->partName                      string
     *
     * special for this extended family part:
     *   ->groups[]                     array of FamilyPartGroup (index of groups is "spouse->xref()")
     *             ->entries[]          array of GroupEntry
     *             ->partner            Individual
     *   ->partnerCounts                FamilyPartCounts for direct partners
     *   ->partnerOfPartnerCounts       FamilyPartCounts for partners of partners
     *   ->pCount                       int legacy alias for partnerCounts->allCount
     *   ->popCount                     int legacy alias for partnerOfPartnerCounts->allCount
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

         $this->addIndividualToFamilyAsPartner($indifam->getIndividual(), $indifam->getReferencePersons()[1], $familyStatus, $indifam->getFamily());
    }

    /**
     * add an individual to the extended family 'partners' if it is not already member of this extended family
     *
     * @param Individual $individual
     * @param Individual $spouse to which these partners are belonging
     * @param string $familyStatus
     * @param Family|null $family
     */
    private function addIndividualToFamilyAsPartner(Individual $individual, Individual $spouse, string $familyStatus, ?Family $family)
    {
        if ( array_key_exists($spouse->xref(), $this->efpObject->groups)) {    // check if this spouse is already stored as group in this part of the extended family
            foreach ($this->efpObject->groups[$spouse->xref()]->entries as $entry) {                                // check if individual is already a partner of this partner
                if ($individual->xref() == $entry->individual->xref()) {
                    return;
                }
            }
            $this->addEntryToGroup(
                $this->efpObject->groups[$spouse->xref()],
                new GroupEntry($individual, $family, $familyStatus, [], [], $this->vitalEventsSummary($individual))
            );
        } else {                                                                // generate new group of partners
            $newObj = new FamilyPartGroup('', [], $spouse);
            $this->addEntryToGroup(
                $newObj,
                new GroupEntry($individual, $family, $familyStatus, [], [], $this->vitalEventsSummary($individual))
            );
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
            foreach ($group->entries as $key => $entry) {
                $partner = $entry->individual;
                $label = $this->levirateSororateLabel($partner, $group->entries, $key);

                if ($label !== '') {
                    $entry->labels[] = $label;
                }
            }
        }
    }

    /**
     * Get a levirate/sororate label for a partner if a same-sex sibling is also a partner.
     *
     * @param Individual $partner
     * @param array<int,GroupEntry> $partners
     * @param int|string $partnerKey
     * @return string
     */
    private function levirateSororateLabel(Individual $partner, array $partners, int|string $partnerKey): string
    {
        if (!in_array($partner->sex(), ['M', 'F'], true)) {
            return '';
        }

        foreach ($partners as $otherKey => $otherPartner) {
            if ($otherKey === $partnerKey || $otherPartner->individual->sex() !== $partner->sex()) {
                continue;
            }

            if (ExtendedFamilySupport::areSiblings($partner, $otherPartner->individual)) {
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
            $partnerCounts = $this->countMaleFemale($this->individualsFromEntries($this->efpObject->groups[array_key_first($this->efpObject->groups)]->entries));
        } else {                            // error: this should not happen
            $partnerCounts = new FamilyPartCounts();
        }

        $partnerOfPartnerCounts = $this->efpObject->counts->subtract($partnerCounts);

        $this->efpObject->partnerCounts = $partnerCounts;
        $this->efpObject->pmaleCount = $partnerCounts->maleCount;
        $this->efpObject->pfemaleCount = $partnerCounts->femaleCount;
        $this->efpObject->potherSexCount = $partnerCounts->otherSexCount;
        $this->efpObject->pCount = $partnerCounts->allCount;

        $this->efpObject->partnerOfPartnerCounts = $partnerOfPartnerCounts;
        $this->efpObject->popmaleCount = $partnerOfPartnerCounts->maleCount;
        $this->efpObject->popfemaleCount = $partnerOfPartnerCounts->femaleCount;
        $this->efpObject->popotherSexCount = $partnerOfPartnerCounts->otherSexCount;
        $this->efpObject->popCount = $partnerOfPartnerCounts->allCount;
    }
}
