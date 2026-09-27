<?php

/*
 * webtrees - extended family parts
 * Copyright (C) 2026 Hermann Hartenthaler. All rights reserved.
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2026 webtrees development team.
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

use Fisharebest\Webtrees\Date;
use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

/**
 * Former partners of the proband's biological, step, and social parents.
 *
 * A person is included when the parent's partnership with that person has a
 * Biological and social parent partnerships must have a known end date before
 * the proband's birth. For a stepparent, the former partnership must have
 * ended before the stepparent's parent role began. In relaxed/symmetrical
 * step-parent mode the same person may additionally be classified as a
 * stepparent; the possible overlap is useful information for patchwork-family
 * research.
 */
class Ex_partners_of_parents extends ExtendedFamilyPart
{
    public const GROUP_EX_PARTNERS_BIOLOGICAL = 'Ex-partners of biological parents';
    public const GROUP_EX_PARTNERS_STEP       = 'Ex-partners of stepparents';
    public const GROUP_EX_PARTNERS_SOCIAL     = 'Ex-partners of social parents';

    /**
     * Find former partners of each biological parent.
     *
     * @return void
     */
    protected function addEfpMembers(): void
    {
        $child = $this->getProband();
        $childBirth = $child->getBirthDate();

        $this->addExPartners(
            $this->findBioparentsIndividuals($child),
            self::GROUP_EX_PARTNERS_BIOLOGICAL,
            $childBirth->isOK() ? $childBirth : null
        );

        // Use only direct stepparents here. In relaxed mode the normal
        // stepparent family part additionally exposes their former partners;
        // this part retains the explicit role distinction and chronology.
        foreach ($this->findDirectStepparentsIndividuals($child) as $stepparent) {
            $roleStart = $stepparent->getFamily() instanceof Family
                ? $this->partnerFamilyStartDate($stepparent->getFamily())
                : null;
            $this->addExPartners([$stepparent], self::GROUP_EX_PARTNERS_STEP, $roleStart);
        }

        $this->addExPartners(
            $this->findSocialparentsIndividuals($child),
            self::GROUP_EX_PARTNERS_SOCIAL,
            $childBirth->isOK() ? $childBirth : null
        );
    }

    /**
     * @param array<int,\Hartenthaler\Webtrees\Module\ExtendedFamily\IndividualFamily> $parents
     * @param string $groupName
     * @param Date|null $beforeDate
     * @return void
     */
    private function addExPartners(array $parents, string $groupName, ?Date $beforeDate): void
    {
        foreach ($parents as $parent) {
            $parentIndividual = $parent->getIndividual();
            foreach ($this->findPartnersIndividuals($parentIndividual) as $partner) {
                if (!$this->isExPartnerBeforeDate($beforeDate, $partner)) {
                    continue;
                }

                $partner->setReferencePerson(1, $parentIndividual);
                $this->addIndividualToFamily($partner, $groupName);
            }
        }
    }
}
