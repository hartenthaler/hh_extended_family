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

use Fisharebest\Webtrees\Individual;

use function array_key_exists;

require_once('Objects/IndividualFamily.php');
require_once('Objects/FindBranchConfig.php');
require_once('Objects/FamilyPart.php');

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
     *  ->groups                        array           // not used in extended family part "partner_chains"
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     */
    protected $efpObject;

    /**
     * @var Individual $proband
     */
    protected $proband;
    
    // ------------ definition of methods

    /**
     * construct extended family part
     *
     * @param Individual $proband
     * @param string $filterOption
     */
    public function __construct(Individual $proband, string $filterOption)
    {
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
        $this->efpObject->groups                = [];
        $this->efpObject->maleCount             = 0;
        $this->efpObject->femaleCount           = 0;
        $this->efpObject->unkonownCount         = 0;
        $this->efpObject->allCount              = 0;
        $this->efpObject->partName              = $this->getClassName();
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
     * find individuals: biological parents (in first family)
     *
     * @param Individual $individual
     * @return array of IndividualFamily
     */
    protected function findBioparentsIndividuals(Individual $individual): array
    {
        $parents = [];
        if ($individual->childFamilies()->first()) {
            if ($individual->childFamilies()->first()->husband() instanceof Individual) {
                $parents[] = new IndividualFamily($individual->childFamilies()->first()->husband(), $individual->childFamilies()->first());
            }
            if ($individual->childFamilies()->first()->wife() instanceof Individual) {
                $parents[] = new IndividualFamily($individual->childFamilies()->first()->wife(), $individual->childFamilies()->first());
            }
        }
        return $parents;
    }

    /**
     * find individuals: stepparents
     *
     * @param Individual $individual
     * @return array of IndividualFamily
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
     * @return array of IndividualFamily
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
     * @return array of IndividualFamily
     */
    protected function findFullsiblingsIndividuals(Individual $individual): array
    {
        $siblings = [];
        if ($individual->childFamilies()->first()) {
            foreach ($individual->childFamilies()->first()->children() as $sibling) {
                if ($sibling->xref() !== $individual->xref()) {
                    $siblings[] = new IndividualFamily($sibling, $individual->childFamilies()->first());
                }
            }
        }
        return $siblings;
    }

    /**
     * find individuals: halfsiblings
     *
     * @param Individual $individual
     * @return array of IndividualFamily
     */
    protected function findHalfsiblingsIndividuals(Individual $individual): array
    {
        $siblings = [];
        if ($individual->childFamilies()->first()) {
            foreach ($individual->childFamilies()->first()->spouses() as $parent) {
                foreach ($parent->spouseFamilies() as $family) {
                    if ($family->xref() !== $individual->childFamilies()->first()->xref()) {
                        foreach ($family->children() as $sibling) {
                            if ($sibling->xref() !== $individual->xref()) {
                                $siblings[] = new IndividualFamily($sibling, $individual->childFamilies()->first());
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
     * @param string $branch ['bio', 'stepbio', 'step']
     * @return array of IndividualFamily
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
        }
        return $greatGrandparents;
    }

    /**
     * find individuals: grandparents for one branch
     * this function is called via "callFunction"
     *
     * @param Individual $parent
     * @param string $branch ['bio', 'step']
     * @return array of IndividualFamily
     */
    private function findGrandparentsBranchIndividuals(Individual $parent, string $branch): array
    {
        if ($branch == 'bio') {
            return $this->findBioparentsIndividuals($parent);
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
     * @return array of IndividualFamily
     */
    private function findCousinsBranchIndividuals(Individual $parent, string $branch): array
    {
        $cousins = [];
        foreach ((($branch == 'full')? $this->findFullsiblingsIndividuals($parent): $this->findHalfsiblingsIndividuals($parent)) as $Sibling) {
            foreach ($this->findPartnersIndividuals($Sibling->getIndividual()) as $uncleAunt) {
                foreach ($uncleAunt->getFamily()->children() as $cousin) {
                    $cousins[] = new IndividualFamily($cousin, $uncleAunt->getFamily());
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
                    $this->addIndividualToFamily($obj, $config->getConst()[$branch][$parent->getIndividual()->sex()]);
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
     * @return array of IndividualFamily
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
            foreach ($groupObj->members as $member) {
                if ($member->xref() == $indifam->getIndividual()->xref()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * add an individual to an already existing group as part of an extended family part
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     */
    private function addIndividualToGroup(IndividualFamily $indifam, string $groupName)
    {
        $this->efpObject->groups[$groupName]->members[] = $indifam->getIndividual();
        $this->efpObject->groups[$groupName]->labels[] = ExtendedFamilySupport::generateChildLabels($indifam->getIndividual());
        $this->efpObject->groups[$groupName]->families[] = $indifam->getFamily();
        $this->efpObject->groups[$groupName]->familiesStatus[] = ExtendedFamilySupport::findFamilyStatus($indifam->getFamily());
        $this->efpObject->groups[$groupName]->referencePersons[] = $indifam->getReferencePersons();
    }

    /**
     * add an individual to a new group as part of an extended family part
     * tbd: add more labels to a person if there are special situations using
     *      $labels[] = ExtendedFamily::getRelationshipName($referencePerson, $this->getProband(), '');
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
            $indifam->getReferencePersons()
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
     * @param array $filterOptions of string $filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    protected function filter(array $filterOptions)
    {
        if (($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all')) {
            foreach ($this->efpObject->groups as $group) {
                foreach ($group->members as $key => $member) {
                    if ( ($filterOptions['alive'] == 'only_alive' && $member->isDead()) || ($filterOptions['alive'] == 'only_dead' && !$member->isDead()) ||
                        ($filterOptions['sex'] == 'only_M' && $member->sex() !== 'M') || ($filterOptions['sex'] == 'only_F' && $member->sex() !== 'F') || ($filterOptions['sex'] == 'only_U' && $member->sex() !== 'U') ) {
                        unset($group->members[$key]);
                    }
                }
            }
        }
        foreach ($this->efpObject->groups as $key => $group) {
            if (count($group->members) == 0) {
                unset($this->efpObject->groups[$key]);
            }
        }
    }

    /**
     * count individuals per family or per group and add them to this extended family part object
     */
    protected function addCountersToFamilyPartObject()
    {
        list ($countMale, $countFemale, $countOthers) = [0, 0 , 0];
        foreach ($this->efpObject->groups as $group) {
            $counter = $this->countMaleFemale($group->members);
            $countMale += $counter->male;
            $countFemale += $counter->female;
            $countOthers += $counter->unknown_others;
        }
        list ($this->efpObject->maleCount, $this->efpObject->femaleCount, $this->efpObject->otherSexCount, $this->efpObject->allCount) = [$countMale, $countFemale, $countOthers, $countMale + $countFemale + $countOthers];
    }

    /**
     * count male and female individuals
     *
     * @param array $indilist of Individuals
     * @return object with three elements: male, female and unknown_others (int >= 0)
     */
    protected function countMaleFemale(array $indilist): object
    {
        $mfu = (object)[];
        list ($mfu->male, $mfu->female, $mfu->unknown_others) = [0, 0, 0];
        foreach ($indilist as $il) {
            if ($il instanceof Individual) {
                if ($il->sex() == "M") {
                    $mfu->male++;
                } elseif ($il->sex() == "F") {
                    $mfu->female++;
                } else {
                    $mfu->unknown_others++;
                }
            }
        }
        return $mfu;
    }
}
