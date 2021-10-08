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

require_once('Objects/IndividualFamily.php');
require_once('Objects/FindBranchConfig.php');

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
     *  ->groups[]                      array           // not used in extended family part "partner_chains"
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
     * find individuals: greatgrandparents for one branch
     * this function is called via "callFunction"
     *
     * @param Individual $parent
     * @param string $branch ['bio', 'stepbio', 'step']
     * @return array of IndividualFamily
     */
    private function findGreatgrandparentsBranchIndividuals(Individual $parent, string $branch): array
    {
        $greatgrandparents = [];
        if ($branch == 'bio') {
            foreach ($this->findBioparentsIndividuals($parent) as $grandparent) {
                foreach ($this->findBioparentsIndividuals($grandparent->getIndividual()) as $greatgrandparent) {
                    $greatgrandparent->setReferencePerson($grandparent->getIndividual());
                    $greatgrandparents[] = $greatgrandparent;
                }
            }
        } elseif ($branch == 'stepbio') {
            foreach ($this->findBioparentsIndividuals($parent) as $grandparent) {
                $greatgrandparents = array_merge($greatgrandparents,
                                                 $this->findStepparentsIndividuals($grandparent->getIndividual()));
            }
        } elseif ($branch == 'step') {
            foreach ($this->findStepparentsIndividuals($parent) as $grandparent) {
                $greatgrandparents = array_merge($greatgrandparents,
                                                 $this->findBioparentsIndividuals($grandparent->getIndividual()));
                $greatgrandparents = array_merge($greatgrandparents,
                                                 $this->findStepparentsIndividuals($grandparent->getIndividual()));
            }
        }
        return $greatgrandparents;
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
    protected function findCousinsBranchIndividuals(Individual $parent, string $branch): array
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
     * add cousins in both branches ['full','half'] or
     * add grandparents in both branches ['bio','step'] or
     * add greatgrandparents in three branches ['bio', 'stepbio', 'step']
     *
     * @param FindBranchConfig $config configuration parameters
     */
    protected function addFamilyBranches(FindBranchConfig $config)
    {
        foreach ($config->getBranches() as $branch) {
            foreach ($this->findBioparentsIndividuals($this->getProband()) as $parent) {
                foreach ($this->callFunction('find'.ucfirst($config->getCallFamilyPart()).'BranchIndividuals', $parent->getIndividual(), $branch) as $obj) {
                    $this->addIndividualToFamily($obj, $config->getConst()[$branch][$parent->getIndividual()->sex()], $obj->getReferencePerson());
                }
            }
        }
    }

    /**
     * call functions to get a branch of an extended family part
     *
     * @param string $name                  name of function to be called
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
     * @param Individual|null $referencePerson
     * @param Individual|null $referencePerson2
     */
    protected function addIndividualToFamily(IndividualFamily $indifam, string $groupName = '', Individual $referencePerson = null, Individual $referencePerson2 = null)
    {
        if (!isset($referencePerson)) {
            $referencePerson = $this->getProband();
        }
        $found = false;
        /*
        if ($groupName == '') {
            error_log('Soll ' . $indifam->getIndividual()->fullName() . ' (' . $indifam->getIndividual()->xref() . ') der Familie ' . $indifam->getFamily()->fullName() . ' (' . $indifam->getFamily()->xref() . ') hinzugefuegt werden? ');
        } else {
            error_log('Soll ' . $indifam->getIndividual()->fullName() . ' (' . $indifam->getIndividual()->xref() . ') der Gruppe "' . $groupName . '" hinzugefuegt werden? ');
        }
        */
        foreach ($this->efpObject->groups as $groupObj) {                      // check if individual is already a member of this part of the extended family
            foreach ($groupObj->members as $member) {
                //echo 'Teste member = ' . $member->xref() . ': ';
                if ($member->xref() == $indifam->getIndividual()->xref()) {
                    $found = true;
                    //echo 'Person ' . $indifam->getIndividual()->fullName() . ' ist bereits in group-Objekt für Familie ' . $groupObj->family->fullName() . ' vorhanden. ';
                    break;
                }
            }
        }
        if (!$found) {                                                                              // individual has to be added
            //echo "add person: ".$indifam->getIndividual()->fullName().". <br>";
            if ($groupName == '') {
                foreach ($this->efpObject->groups as $famkey => $groupObj) {                       // check if this family is already stored in this part of the extended family
                    if ($groupObj->family->xref() == $indifam->getFamily()->xref()) {               // family exists already
                        //echo 'famkey in bereits vorhandener Familie: ' . $famkey . ' (Person ' . $individual->fullName() . ' in Objekt für Familie ' . $extendedFamilyPart->groups[$famkey]->family->fullName() . '); ';
                        $this->addIndividualToGroup($indifam, $groupName, $referencePerson, $referencePerson2);
                        $found = true;
                        break;
                    }
                }
            } elseif (array_key_exists($groupName, $this->efpObject->groups)) {
                //echo 'In bereits vorhandener Gruppe "' . $groupName . '" Person ' . $individual->xref() . ' hinzugefügt. ';
                $this->addIndividualToGroup($indifam, $groupName, $referencePerson, $referencePerson2);
                $found = true;
            }
            if (!$found) {                                                                              // individual not found and family not found
                $newObj = (object)[];
                $newObj->members[] = $indifam->getIndividual();
                $newObj->family = $indifam->getFamily();
                $labels = [];
/*
                if ($referencePerson) {               // tbd: Logik ist verkehrt! Richtige Personen auswählen (siehe Kommentar ganz oben)!
                    $labels[] = ExtendedFamily::getRelationshipName($referencePerson, $this->getProband(), '');
                }
*/
                $labels = array_merge($labels, ExtendedFamilySupport::generateChildLabels($indifam->getIndividual()));
                $newObj->labels[] = $labels;
                $newObj->families[] = $indifam->getFamily();
                $newObj->familiesStatus[] = ExtendedFamilySupport::findFamilyStatus($indifam->getFamily());
                $newObj->referencePersons[] = $referencePerson;
                $newObj->referencePersons2[] = $referencePerson2;
                if ($this->efpObject->partName == 'greatgrandparents' || $this->efpObject->partName == 'grandparents' || $this->efpObject->partName == 'parents') {
                    $newObj->familyStatus = ExtendedFamilySupport::findFamilyStatus($indifam->getFamily());
                    if ($referencePerson) {
                        $newObj->partner = $referencePerson;
                        if ($referencePerson2) {
                            foreach ($referencePerson2->spouseFamilies() as $fam) {
                                //echo "Teste Familie ".$fam->fullName().":";
                                foreach ($fam->spouses() as $partner) {
                                    if ($partner->xref() == $referencePerson->xref()) {
                                        //echo $referencePerson->fullName();
                                        $newObj->partnerFamilyStatus = ExtendedFamilySupport::findFamilyStatus($fam);
                                    }
                                }
                            }
                        } else {
                            $newObj->partnerFamilyStatus = 'Partnership';
                        }
                    }
                }
                if ($groupName == '') {
                    $this->efpObject->groups[] = $newObj;
                    //echo "<br>Neu hinzugefügte Familie Nr. " . (count($this->efpObject->groups) - 1) . ' (Person ' . $indifam->getIndividual()->fullName() . ' in Objekt für Familie ' . $this->efpObject->groups[count($this->efpObject->groups) - 1]->family->xref() . '); ';
                } else {
                    $newObj->groupName = $groupName;
                    $this->efpObject->groups[$groupName] = $newObj;
                    //echo 'Neu hinzugefügte Gruppe "' . $groupName . '" (Person ' . $individual->xref() . '). ';
                }
            }
        }
    }

    /**
     * add an individual to a group of the extended family
     *
     * @param IndividualFamily $indifam
     * @param string $groupName
     * @param Individual|null $referencePerson
     * @param Individual|null $referencePerson2
     */
    private function addIndividualToGroup(IndividualFamily $indifam, string $groupName, Individual $referencePerson = null, Individual $referencePerson2 = null)
    {
        $this->efpObject->groups[$groupName]->members[] = $indifam->getIndividual();
        $this->efpObject->groups[$groupName]->labels[] = ExtendedFamilySupport::generateChildLabels($indifam->getIndividual());
        $this->efpObject->groups[$groupName]->families[] = $indifam->getFamily();
        $this->efpObject->groups[$groupName]->familiesStatus[] = ExtendedFamilySupport::findFamilyStatus($indifam->getFamily());
        $this->efpObject->groups[$groupName]->referencePersons[] = $referencePerson;
        $this->efpObject->groups[$groupName]->referencePersons2[] = $referencePerson2;
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
