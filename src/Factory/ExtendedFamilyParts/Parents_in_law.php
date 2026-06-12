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
 * class Parents_in_law
 *
 * data and methods for extended family part Parents-in-law
 */
class Parents_in_law extends ExtendedFamilyPart
{
    // named groups are not used for parents in law (instead the marriages are used for grouping)
    // public const GROUP_PARENTSINLAW_BIO  = 'Biological parents of partner';
    // public const GROUP_PARENTSINLAW_STEP = 'Stepparents of partner';

    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array of FamilyPartGroup
     *  ->counts                        FamilyPartCounts
     *  ->partName                      string
     *
     * special for this extended family part:
     *            ->entries[]           array of GroupEntry
     *            ->family              Family
     *            ->familyStatus        string
     *            ->partner             Individual
     *            ->partnerFamilyStatus string
     */

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     *
     * This part is derived from the proband's direct partners. The parents
     * of each partner are found through the same biological, social, and
     * stepparent helper methods as the parents family part.
     */
    protected function addEfpMembers()
    {
        foreach ($this->findPartnersIndividuals($this->getProband()) as $partner) {
            $this->addParentsOfPartner($partner->getIndividual());
        }
    }

    /**
     * Add all known biological, social, and stepparents of one direct partner.
     *
     * @param Individual $partner
     * @return void
     */
    private function addParentsOfPartner(Individual $partner): void
    {
        foreach ($this->findAllParentTypesOfPartner($partner) as $parent) {
            $parent->setReferencePerson(1, $partner);
            $this->addIndividualToFamily($parent);
        }
    }

    /**
     * Find all biological, social, and stepparents of one direct partner.
     *
     * @param Individual $partner
     * @return array<int,IndividualFamily>
     */
    private function findAllParentTypesOfPartner(Individual $partner): array
    {
        return array_merge(
            $this->findBioparentsIndividuals($partner),
            $this->findSocialparentsIndividuals($partner),
            $this->findStepparentsIndividuals($partner)
        );
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
                $this->addEntryToGroup(
                    $this->efpObject->groups[$famkey],
                    new GroupEntry(
                        $indifam->getIndividual(),
                        $indifam->getFamily(),
                        ExtendedFamilySupport::findFamilyStatus($indifam->getFamily()),
                        $indifam->getReferencePersons(),
                        ExtendedFamilySupport::generateChildLabels($indifam->getIndividual()),
                        $this->vitalEventsSummary($indifam->getIndividual())
                    )
                );
                return;
            }
        }
        $newObj = new FamilyPartGroup(
            '',
            [],
            null,
            $indifam->getFamily(),
            ExtendedFamilySupport::findFamilyStatus($indifam->getFamily())
        );                                           // individual not found and family not found
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
        $this->addEntryToGroup(
            $newObj,
            new GroupEntry(
                $indifam->getIndividual(),
                $indifam->getFamily(),
                ExtendedFamilySupport::findFamilyStatus($indifam->getFamily()),
                $indifam->getReferencePersons(),
                ExtendedFamilySupport::generateChildLabels($indifam->getIndividual()),
                $this->vitalEventsSummary($indifam->getIndividual())
            )
        );
        $this->efpObject->groups[] = $newObj;
    }
}
