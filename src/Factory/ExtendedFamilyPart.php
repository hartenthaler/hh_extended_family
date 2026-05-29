<?php
/*
 * webtrees - extended family part
 *
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

use Fisharebest\Webtrees\Elements\PedigreeLinkageType;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

use function array_key_exists;

/**
 * abstract class ExtendedFamilyPart
 *
 * data and methods for extended family parts (like grandparents, partners, children, cousins, ...)
 */
abstract class ExtendedFamilyPart
{
    // ------------ definition of data structures
        
    /**
     * @var object $efpObject common data structure for all extended family parts
     *                        there are additional specific data structures for each extended family part
     *
     *  ->groups                        array<string|int,FamilyPartGroup> // not used in extended family part "partner_chains"
     *  ->chains                        object          // only used for extended family part "partner_chains"
     *  ->counts                        FamilyPartCounts
     *  ->maleCount                     int legacy alias for counts->maleCount
     *  ->femaleCount                   int legacy alias for counts->femaleCount
     *  ->otherSexCount                 int legacy alias for counts->otherSexCount
     *  ->allCount                      int legacy alias for counts->allCount
     *  ->partName                      string
     */
    protected object $efpObject;

    /**
     * @var Individual $proband
     */
    protected Individual $proband;

    /**
     * @var int $placeFormat selected format for event places
     */
    protected int $placeFormat;
    
    // ------------ definition of methods

    /**
     * construct extended family part
     *
     * @param Individual $proband
     * @param string $filterOption
     * @param int $placeFormat
     */
    public function __construct(
        Individual $proband,
        string $filterOption,
        int $placeFormat = PlaceAbbreviation::OPTION_FULL_PLACE_NAME
    )
    {
        $this->placeFormat = $placeFormat;
        $this->initialize($proband);
        $this->addEfpMembers();
        $this->filterAndAddCounters($filterOption);
    }

    /**
     * initialize part of extended family
     * object contains arrays of individuals or families and several counter values
     *
     * @param Individual $proband
     */
    private function initialize(Individual $proband)
    {
        $this->proband = $proband;

        $this->efpObject = (object)[];
        $this->efpObject->groups                = [];             // not used for extended family part "partner_chains"
        $this->efpObject->unkonownCount         = 0;
        $this->setFamilyPartCounts($this->efpObject, new FamilyPartCounts());
        $this->efpObject->partName              = $this->getClassName();
        $this->efpObject->chains                = (object)[];     // only used for extended family part "partner_chains"
    }

    /**
     * get extended family part object
     *
     * @return object
     */
    public function getEfpObject(): object
    {
        return $this->efpObject;
    }

    /**
     * get proband object
     *
     * @return Individual
     */
    public function getProband(): Individual
    {
        return $this->proband;
    }

    /**
     * get name of this class (without namespace)
     *
     * @return string
     */
    private function getClassName(): string
    {
        return strtolower(substr(strrchr(get_class($this), '\\'), 1));
    }

    /**
     * find members of this specific extended family part (has to be implemented for each extended family part)
     */
    abstract protected function addEfpMembers();

    /**
     * filter and add counters to this specific extended family part (has to be implemented for each extended family part if it is specific)
     */
    protected function filterAndAddCounters($filterOption)
    {
        $this->filterAndAddCountersToFamilyPartObject($filterOption);
    }

    /**
     * find individuals: biological parents
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findBioparentsIndividuals(Individual $individual): array
    {
        return $this->findParentsIndividualsByPedigreeTypes($individual, [PedigreeLinkageType::VALUE_BIRTH, '']);
    }

    /**
     * find individuals: social parents (adoptive, foster, or rada parents)
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findSocialparentsIndividuals(Individual $individual): array
    {
        return $this->findParentsIndividualsByPedigreeTypes($individual, [
            PedigreeLinkageType::VALUE_ADOPTED,
            PedigreeLinkageType::VALUE_FOSTER,
            PedigreeLinkageType::VALUE_RADA,
        ]);
    }

    /**
     * find individuals: biological and social parents
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findParentsIndividuals(Individual $individual): array
    {
        return array_merge(
            $this->findBioparentsIndividuals($individual),
            $this->findSocialparentsIndividuals($individual)
        );
    }

    /**
     * find parent individuals for child-family links with selected PEDI values
     *
     * @param Individual $individual
     * @param array<int,string> $pedigreeTypes
     * @return array<int,IndividualFamily>
     */
    private function findParentsIndividualsByPedigreeTypes(Individual $individual, array $pedigreeTypes): array
    {
        $parents = [];
        foreach ($individual->childFamilies() as $family) {
            if (!in_array($this->childFamilyPedigreeType($individual, $family), $pedigreeTypes, true)) {
                continue;
            }
            if ($family->husband() instanceof Individual) {
                $parents[] = new IndividualFamily($family->husband(), $family);
            }
            if ($family->wife() instanceof Individual) {
                $parents[] = new IndividualFamily($family->wife(), $family);
            }
        }
        return $parents;
    }

    /**
     * get PEDI value for a child-family link; missing PEDI is treated as birth
     *
     * @param Individual $individual
     * @param Family $family
     * @return string
     */
    protected function childFamilyPedigreeType(Individual $individual, Family $family): string
    {
        $fact = $individual->facts(['FAMC'])->first(static fn (Fact $fact): bool => $fact->value() === '@' . $family->xref() . '@');

        if ($fact instanceof Fact) {
            return $fact->attribute('PEDI') ?: PedigreeLinkageType::VALUE_BIRTH;
        }

        return PedigreeLinkageType::VALUE_BIRTH;
    }

    /**
     * Is this a biological child-family link?
     *
     * @param Individual $individual
     * @param Family $family
     * @return bool
     */
    protected function isBiologicalChildInFamily(Individual $individual, Family $family): bool
    {
        return $this->childFamilyPedigreeType($individual, $family) === PedigreeLinkageType::VALUE_BIRTH;
    }

    /**
     * Is this a social child-family link (adopted, foster, or rada)?
     *
     * @param Individual $individual
     * @param Family $family
     * @return bool
     */
    protected function isSocialChildInFamily(Individual $individual, Family $family): bool
    {
        return in_array($this->childFamilyPedigreeType($individual, $family), [
            PedigreeLinkageType::VALUE_ADOPTED,
            PedigreeLinkageType::VALUE_FOSTER,
            PedigreeLinkageType::VALUE_RADA,
        ], true);
    }

    /**
     * find individuals: stepparents
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findStepparentsIndividuals(Individual $individual): array
    {
        $stepparents = [];
        $bioParents = $this->findBioparentsIndividuals($individual);
        foreach ($bioParents as $parent) {
            foreach ($this->findPartnersIndividuals($parent->getIndividual()) as $stepparent) {
                $found = false;
                foreach ($bioParents as $bioParent)  {      // check if this stepparent is one of the biological parents
                    if ($stepparent->getIndividual()->xref() == $bioParent->getIndividual()->xref()) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $stepparents[] = $stepparent;
                }
            }
        }
        return $stepparents;
    }

    /**
     * find individuals: partners
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findPartnersIndividuals(Individual $individual): array
    {
        $partners = [];
        foreach ($individual->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse->xref() !== $individual->xref()) {
                    $partners[] = new IndividualFamily($spouse, $family);
                }
            }
        }
        return $partners;
    }

    /**
     * find individuals: fullsiblings
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findFullsiblingsIndividuals(Individual $individual): array
    {
        $siblings = [];
        foreach ($individual->childFamilies() as $family) {
            if (!$this->isBiologicalChildInFamily($individual, $family)) {
                continue;
            }
            foreach ($family->children() as $sibling) {
                if ($sibling->xref() !== $individual->xref() && $this->isBiologicalChildInFamily($sibling, $family)) {
                    $siblings[] = new IndividualFamily($sibling, $family);
                }
            }
        }
        return $siblings;
    }

    /**
     * find individuals: halfsiblings
     *
     * @param Individual $individual
     * @return array<int,IndividualFamily>
     */
    protected function findHalfsiblingsIndividuals(Individual $individual): array
    {
        $siblings = [];
        foreach ($individual->childFamilies() as $childFamily) {
            if (!$this->isBiologicalChildInFamily($individual, $childFamily)) {
                continue;
            }
            foreach ($childFamily->spouses() as $parent) {
                foreach ($parent->spouseFamilies() as $family) {
                    if ($family->xref() !== $childFamily->xref()) {
                        foreach ($family->children() as $sibling) {
                            if ($sibling->xref() !== $individual->xref() && $this->isBiologicalChildInFamily($sibling, $family)) {
                                $siblings[] = new IndividualFamily($sibling, $childFamily);
                            }
                        }
                    }
                }
            }
        }
        return $siblings;
    }

    /**
     * find individuals: great-grandparents for one branch
     * this function is called via "callFunction"
     *
     * @param Individual $parent
     * @param string $branch ['bio', 'stepbio', 'biosocial', 'step', 'social']
     * @return array<int,IndividualFamily>
     */
    private function findGreat_grandparentsBranchIndividuals(Individual $parent, string $branch): array
    {
        $greatGrandparents = [];
        if ($branch == 'bio') {
            foreach ($this->findBioparentsIndividuals($parent) as $grandparent) {
                foreach ($this->findBioparentsIndividuals($grandparent->getIndividual()) as $greatGrandparent) {
                    $greatGrandparent->setReferencePerson(1, $grandparent->getIndividual());
                    $greatGrandparents[] = $greatGrandparent;
                }
            }
        } elseif ($branch == 'stepbio') {
            foreach ($this->findBioparentsIndividuals($parent) as $grandparent) {
                foreach ($this->findStepparentsIndividuals($grandparent->getIndividual()) as $greatGrandparent) {
                    $greatGrandparent->setReferencePerson(1, $grandparent->getIndividual());
                    $greatGrandparents[] = $greatGrandparent;
                }
            }
        } elseif ($branch == 'biosocial') {
            foreach ($this->findBioparentsIndividuals($parent) as $grandparent) {
                foreach ($this->findSocialparentsIndividuals($grandparent->getIndividual()) as $greatGrandparent) {
                    $greatGrandparent->setReferencePerson(1, $grandparent->getIndividual());
                    $greatGrandparents[] = $greatGrandparent;
                }
            }
        } elseif ($branch == 'step') {
            foreach ($this->findStepparentsIndividuals($parent) as $stepgrandparent) {
                foreach ($this->findBioparentsIndividuals($stepgrandparent->getIndividual()) as $greatGrandparent) {
                    $greatGrandparent->setReferencePerson(1, $stepgrandparent->getIndividual());
                    $greatGrandparents[] = $greatGrandparent;
                }
                foreach ($this->findStepparentsIndividuals($stepgrandparent->getIndividual()) as $greatGrandparent) {
                    $greatGrandparent->setReferencePerson(1, $stepgrandparent->getIndividual());
                    $greatGrandparents[] = $greatGrandparent;
                }
            }
        } elseif ($branch == 'social') {
            foreach ($this->findSocialparentsIndividuals($parent) as $socialGrandparent) {
                foreach ($this->findParentsIndividuals($socialGrandparent->getIndividual()) as $greatGrandparent) {
                    $greatGrandparent->setReferencePerson(1, $socialGrandparent->getIndividual());
                    $greatGrandparents[] = $greatGrandparent;
                }
            }
        }
        return $greatGrandparents;
    }

    /**
     * find individuals: grandparents for one branch
     * this function is called via "callFunction"
     *
     * @param Individual $parent
     * @param string $branch ['bio', 'step']
     * @return array<int,IndividualFamily>
     */
    private function findGrandparentsBranchIndividuals(Individual $parent, string $branch): array
    {
        if ($branch == 'bio') {
            return $this->findBioparentsIndividuals($parent);
        } elseif ($branch == 'social') {
            return $this->findSocialparentsIndividuals($parent);
        } elseif ($branch == 'step') {
            return $this->findStepparentsIndividuals($parent);
        }
        return [];
    }

    /**
     * find individuals: full or half cousins based on father or mother (in first family)
     * this function is called via "callFunction"
     *
     * @param Individual $parent
     * @param string $branch ['full', 'half']
     * @return array<int,IndividualFamily>
     */
    private function findCousinsBranchIndividuals(Individual $parent, string $branch): array
    {
        $cousins = [];
        foreach ((($branch == 'full')? $this->findFullsiblingsIndividuals($parent): $this->findHalfsiblingsIndividuals($parent)) as $sibling) {
            foreach ($sibling->getIndividual()->spouseFamilies() as $family) {
                foreach ($family->children() as $cousin) {
                    $cousins[] = new IndividualFamily($cousin, $sibling->getFamily());
                }
            }
        }
        return $cousins;
    }

    /**
     * add great-grandparents in three branches ['bio', 'stepbio', 'step'] or
     * add grandparents in both branches ['bio','step'] or
     * add cousins in both branches ['full','half']
     *
     * @param FindBranchConfig $config configuration parameters
     */
    protected function addFamilyBranches(FindBranchConfig $config)
    {
        foreach ($config->getBranches() as $branch) {
            foreach ($this->findBioparentsIndividuals($this->getProband()) as $parent) {
                foreach ($this->callFunction('find'.ucfirst($config->getCallFamilyPart()).'BranchIndividuals',
                                             $parent->getIndividual(),
                                             $branch) as $obj) {
                    $this->addIndividualToFamily($obj, $config->familyPartForSex($branch, $parent->getIndividual()->sex()));
                }
            }
        }
    }

    /**
     * call functions to get a branch of an extended family part
     *
     * @param string $name                  name of function to be called ['great_grandparents', 'grandparents', 'cousins']
     * @param Individual $individual        Individual
     * @param string $branch                e.g. ['bio', 'step', 'full', half']
     * @return array<int,IndividualFamily>
     */
    private function callFunction(string $name, Individual $individual, string $branch): array
    {
        return $this->$name($individual, $branch);
    }

    /**
     * add an individual and the corresponding family to the extended family part
     * if it is not already member of this extended family part.
     * this function is overloaded by a special version for: parents_in_law, partners and partner_chains
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     */
    protected function addIndividualToFamily(IndividualFamily $indifam, string $groupName)
    {
        if ($this->isIndividualAlreadyMember($indifam)) {
                    return;
        }
        if (!isset($indifam->getReferencePersons()[1])) {
            $indifam->setReferencePerson(1, $this->getProband());
        }
        if (array_key_exists($groupName, $this->efpObject->groups)) {
            $this->addIndividualToGroup($indifam, $groupName);                  // add individual to existing group
        } else {
            $this->addIndividualToNewGroup($indifam, $groupName);               // add individual to new group
        }
    }

    /**
     * check if individual is already a member of any group of this extended family part
     *
     * @param IndividualFamily $indifam
     * @return bool
     */
    public function isIndividualAlreadyMember(IndividualFamily $indifam): bool
    {
        foreach ($this->efpObject->groups as $groupObj) {
            foreach ($groupObj->entries as $entry) {
                if ($entry->individual->xref() == $indifam->getIndividual()->xref()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Generate prepared birth/death summaries for display in event boxes.
     *
     * @param Individual $individual
     * @return string
     */
    protected function vitalEventsSummary(Individual $individual): string
    {
        $summary = '';
        foreach (['BIRT', 'DEAT'] as $tag) {
            $event = $individual->facts([$tag])->first();
            if ($event instanceof Fact) {
                $summary .= ExtendedFamilySupport::eventSummary($event, $this->placeFormat);
            }
        }
        return $summary;
    }

    /**
     * add an individual to an already existing group as part of an extended family part
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     */
    private function addIndividualToGroup(IndividualFamily $indifam, string $groupName)
    {
        $this->addEntryToGroup(
            $this->efpObject->groups[$groupName],
            new GroupEntry(
                $indifam->getIndividual(),
                $indifam->getFamily(),
                ExtendedFamilySupport::findFamilyStatus($indifam->getFamily()),
                $indifam->getReferencePersons(),
                ExtendedFamilySupport::generateChildLabels($indifam->getIndividual()),
                $this->vitalEventsSummary($indifam->getIndividual())
            )
        );
    }

    /**
     * Add one entry to a group.
     *
     * @param FamilyPartGroup $group
     * @param GroupEntry $entry
     * @return void
     */
    protected function addEntryToGroup(FamilyPartGroup $group, GroupEntry $entry): void
    {
        $group->addEntry($entry);
    }

    /**
     * add an individual to a new group as part of an extended family part
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     */
    private function addIndividualToNewGroup(IndividualFamily $indifam, string $groupName)
    {
        $newObj = new FamilyPart(
            $groupName,
            $indifam->getIndividual(),
            ExtendedFamilySupport::generateChildLabels($indifam->getIndividual()),
            $indifam->getFamily(),
            ExtendedFamilySupport::findFamilyStatus($indifam->getFamily()),
            $indifam->getReferencePersons(),
            $this->vitalEventsSummary($indifam->getIndividual())
        );
        $this->efpObject->groups[$groupName] = $newObj->getFamilyPart();
    }

    /**
     * filter individuals and count them per family or per group and per sex
     *
     * @param string $filterOption
     */
    protected function filterAndAddCountersToFamilyPartObject(string $filterOption)
    {
        if ($filterOption !== 'all') {
            $this->filter(ExtendedFamilySupport::convertfilterOptions($filterOption));
        }
        $this->addCountersToFamilyPartObject();
    }

    /**
     * filter individuals in extended family part
     *
     * @param array<string,string> $filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    protected function filter(array $filterOptions)
    {
        if (($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all')) {
            foreach ($this->efpObject->groups as $group) {
                foreach ($group->entries as $key => $entry) {
                    if ( ($filterOptions['alive'] == 'only_alive' && $entry->individual->isDead()) || ($filterOptions['alive'] == 'only_dead' && !$entry->individual->isDead()) ||
                        !ExtendedFamilySupport::sexMatchesFilter($entry->individual->sex(), $filterOptions['sex']) ) {
                        unset($group->entries[$key]);
                    }
                }
            }
        }
        foreach ($this->efpObject->groups as $key => $group) {
            if (count($group->entries) == 0) {
                unset($this->efpObject->groups[$key]);
            }
        }
    }

    /**
     * count individuals per family or per group and add them to this extended family part object
     */
    protected function addCountersToFamilyPartObject()
    {
        $counts = new FamilyPartCounts();
        foreach ($this->efpObject->groups as $group) {
            $counts->add($this->countMaleFemale($this->individualsFromEntries($group->entries)));
        }
        $this->setFamilyPartCounts($this->efpObject, $counts);
    }

    /**
     * count male and female individuals
     *
     * @param array<int,Individual> $indilist
     * @return FamilyPartCounts
     */
    protected function countMaleFemale(array $indilist): FamilyPartCounts
    {
        return FamilyPartCounts::fromIndividuals($indilist);
    }

    protected function setFamilyPartCounts(object $familyPart, FamilyPartCounts $counts): void
    {
        $familyPart->counts = $counts;
        $familyPart->maleCount = $counts->maleCount;
        $familyPart->femaleCount = $counts->femaleCount;
        $familyPart->otherSexCount = $counts->otherSexCount;
        $familyPart->allCount = $counts->allCount;
    }

    /**
     * @param array<int,GroupEntry> $entries
     * @return array<int,Individual>
     */
    protected function individualsFromEntries(array $entries): array
    {
        return array_map(static fn (GroupEntry $entry): Individual => $entry->individual, $entries);
    }
}
