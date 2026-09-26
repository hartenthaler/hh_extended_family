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

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

/**
 * class Grandnephews_nieces
 *
 * Data and methods for extended family part "grandnephews_nieces".
 * The nephews and nieces family part is used as the basis; their children and
 * stepchildren are shown as grandnephews and grandnieces of the proband.
 */
class Grandnephews_nieces extends ExtendedFamilyPart
{
    public const GROUP_GRANDNEPHEW_NIECES_CHILD        = 'Children of nephews and nieces';
    public const GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD = 'Social children of nephews and nieces';
    public const GROUP_GRANDNEPHEW_NIECES_STEPCHILD    = 'Stepchildren of nephews and nieces';
    public const GROUP_GRANDNEPHEW_NIECES_CHILD_FULL   = 'Biological grandchildren of biological full siblings';

    public const GROUP_GRANDNEPHEW_NIECES_CHILD_SIBLING = 'Children of nephews and nieces from the sibling line';
    public const GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD_SIBLING = 'Social children of nephews and nieces from the sibling line';
    public const GROUP_GRANDNEPHEW_NIECES_CHILD_STEP_SIBLING = 'Children of nephews and nieces from the step-sibling line';
    public const GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD_STEP_SIBLING = 'Social children of nephews and nieces from the step-sibling line';
    public const GROUP_GRANDNEPHEW_NIECES_CHILD_SIBLING_PARTNER = 'Children of nephews and nieces from the partners\' sibling line';
    public const GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD_SIBLING_PARTNER = 'Social children of nephews and nieces from the partners\' sibling line';

    /**
     * Find members for this specific extended family part and modify $this->efpObject.
     */
    protected function addEfpMembers()
    {
        $nephewsAndNieces = new Nephews_and_nieces($this->getProband(), 'all', $this->placeFormat);

        foreach ($nephewsAndNieces->getEfpObject()->groups as $group) {
            foreach ($group->entries as $entry) {
                $nephewOrNiece = $entry->individual;
                if ($nephewOrNiece instanceof Individual) {
                    $this->addChildrenOfNephewOrNiece($nephewOrNiece, $group->groupName, $entry->referencePersons);
                    $this->addStepchildrenOfNephewOrNiece($nephewOrNiece);
                }
            }
        }
    }

    /**
     * Add children of one nephew or niece.
     *
     * @param Individual $nephewOrNiece
     * @param string     $sourceGroupName
     * @param array<int,Individual> $sourceReferencePersons
     * @return void
     */
    private function addChildrenOfNephewOrNiece(Individual $nephewOrNiece, string $sourceGroupName, array $sourceReferencePersons): void
    {
        $referencePerson2 = $sourceGroupName === Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER
            ? ($sourceReferencePersons[1] ?? null)
            : null;
        $referencePerson2 = $referencePerson2 instanceof Individual ? $referencePerson2 : null;

        foreach ($nephewOrNiece->spouseFamilies() as $family) {
            foreach ($family->children() as $grandnephewOrGrandniece) {
                $this->addIndividualToFamily(
                    new IndividualFamily($grandnephewOrGrandniece, $family, $nephewOrNiece, $referencePerson2),
                    $this->childrenOfNephewOrNieceGroupName($grandnephewOrGrandniece, $family, $sourceGroupName)
                );
            }
        }
    }

    /**
     * Add stepchildren of one nephew or niece.
     *
     * Stepchildren are children of a partner of the nephew or niece from another family.
     *
     * @param Individual $nephewOrNiece
     * @return void
     */
    private function addStepchildrenOfNephewOrNiece(Individual $nephewOrNiece): void
    {
        foreach ($nephewOrNiece->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse->xref() === $nephewOrNiece->xref()) {
                    continue;
                }

                foreach ($spouse->spouseFamilies() as $stepFamily) {
                    if ($stepFamily->xref() === $family->xref()) {
                        continue;
                    }

                    foreach ($stepFamily->children() as $stepGrandnephewOrGrandniece) {
                        $this->addIndividualToFamily(
                            new IndividualFamily($stepGrandnephewOrGrandniece, $stepFamily, $nephewOrNiece),
                            self::GROUP_GRANDNEPHEW_NIECES_STEPCHILD
                        );
                    }
                }
            }
        }
    }

    /**
     * Get the group name for a child of a nephew or niece.
     *
     * @param Individual $grandnephewOrGrandniece
     * @param Family $family
     * @param string $sourceGroupName
     * @return string
     */
    private function childrenOfNephewOrNieceGroupName(Individual $grandnephewOrGrandniece, Family $family, string $sourceGroupName): string
    {
        $isSocialChild = $this->isSocialChildInFamily($grandnephewOrGrandniece, $family);

        return match ($sourceGroupName) {
            Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING => $isSocialChild
                ? self::GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD_STEP_SIBLING
                : self::GROUP_GRANDNEPHEW_NIECES_CHILD_STEP_SIBLING,
            Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER => $isSocialChild
                ? self::GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD_SIBLING_PARTNER
                : self::GROUP_GRANDNEPHEW_NIECES_CHILD_SIBLING_PARTNER,
            default => $isSocialChild
                ? self::GROUP_GRANDNEPHEW_NIECES_SOCIAL_CHILD_SIBLING
                : self::GROUP_GRANDNEPHEW_NIECES_CHILD_SIBLING,
        };
    }
}
