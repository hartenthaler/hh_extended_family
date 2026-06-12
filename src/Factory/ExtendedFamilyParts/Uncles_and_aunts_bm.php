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
 * class Uncles_and_aunts_bm
 *
 * data and methods for extended family part "uncles_and_aunts_bm" as uncles and aunts by marriage
 */
class Uncles_and_aunts_bm extends ExtendedFamilyPart
{
    public const GROUP_UNCLEAUNTBM_BIO_PARENT    = 'Partners of siblings and half siblings of biological parents';
    public const GROUP_UNCLEAUNTBM_SOCIAL_PARENT = 'Partners of siblings and half siblings of social parents';
    public const GROUP_UNCLEAUNTBM_STEP_PARENT   = 'Partners of siblings and half siblings of stepparents';

    /**
     * @var object $_efpObject data structure for this extended family part
     *
     * common:
     *  ->groups[]                      array
     *  ->counts                        FamilyPartCounts
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->groups[]->entries[]           array of GroupEntry (index of groups is groupName)
     *            ->groupName           string
     */

    /**
     * Find members for this specific extended family part and modify $this->>efpObject.
     *
     * This part is derived from uncles_and_aunts, so biological, social,
     * and step-parent distinctions are preserved.
     */
    protected function addEfpMembers()
    {
        $unclesAndAunts = new Uncles_and_aunts($this->getProband(), 'all', $this->placeFormat);

        foreach ($unclesAndAunts->getEfpObject()->groups as $group) {
            $groupName = $this->unclesAndAuntsByMarriageGroupName($group->groupName);

            foreach ($group->entries as $entry) {
                $uncleAunt = $entry->individual;
                if ($uncleAunt instanceof Individual) {
                    $this->addPartnersOfUncleOrAunt(
                        $uncleAunt,
                        $entry->referencePersons[1] ?? null,
                        $groupName
                    );
                }
            }
        }
    }

    /**
     * Get the group name for partners of one uncle/aunt group.
     *
     * @param string $unclesAndAuntsGroupName
     * @return string
     */
    private function unclesAndAuntsByMarriageGroupName(string $unclesAndAuntsGroupName): string
    {
        return match ($unclesAndAuntsGroupName) {
            Uncles_and_aunts::GROUP_UNCLEAUNT_SOCIAL_PARENT => self::GROUP_UNCLEAUNTBM_SOCIAL_PARENT,
            Uncles_and_aunts::GROUP_UNCLEAUNT_STEP_PARENT   => self::GROUP_UNCLEAUNTBM_STEP_PARENT,
            default                                         => self::GROUP_UNCLEAUNTBM_BIO_PARENT,
        };
    }

    /**
     * Add partners of one uncle or aunt.
     *
     * @param Individual $uncleAunt
     * @param Individual|null $referenceParent
     * @param string $groupName
     * @return void
     */
    private function addPartnersOfUncleOrAunt(Individual $uncleAunt, ?Individual $referenceParent, string $groupName): void
    {
        foreach ($uncleAunt->spouseFamilies() as $family) {
            foreach ($family->spouses() as $partner) {
                if ($partner->xref() !== $uncleAunt->xref()) {
                    if ($referenceParent instanceof Individual) {
                        $this->addIndividualToFamily(new IndividualFamily($partner, $family, $uncleAunt, $referenceParent), $groupName);
                    } else {
                        $this->addIndividualToFamily(new IndividualFamily($partner, $family, $uncleAunt), $groupName);
                    }
                }
            }
        }
    }
}
