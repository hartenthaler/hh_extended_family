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
     * @var object $_efpObject common data structure for all extended family parts; there are additional specific data structures for each extended family part
     *
     *  ->groups[]                      array           // not used in extended family part "partner_chains"
     *  ->maleCount                     int    
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     */
    protected $_efpObject;

    /**
     * @var Individual $_proband
     */
    protected $_proband;
    
    // ------------ definition of methods

    /**
     * construct extended family part
     *
     * @param Individual $proband
     */
    public function __construct(Individual $proband, string $filterOption)
    {
        $this->_initialize($proband);
        $this->_addEfpMembers();
        $this->_filterAndAddCounters($filterOption);
    }

    /**
     * initialize part of extended family (object contains arrays of individuals or families and several counter values)
     *
     */
    private function _initialize(Individual $proband)
    {
        $this->_efpObject = (object)[];
        $this->_efpObject->groups                = [];
        $this->_efpObject->maleCount             = 0;
        $this->_efpObject->femaleCount           = 0;
        $this->_efpObject->unkonownCount         = 0;
        $this->_efpObject->allCount              = 0;
        $this->_efpObject->partName              = $this->_getClassName();

        $this->_proband = $proband;
    }

    /**
     * get extended family part object
     *
     * @return object
     */
    public function getEfpObject(): object
    {
        return $this->_efpObject;
    }

    /**
     * get name of this class (without namespace)
     *
     * @return string
     */
    private function _getClassName(): string
    {
        return strtolower(substr(strrchr(get_class($this), '\\'), 1));
    }

    /**
     * find members of this specific extended family part (has to be implemented for each extended family part)
     */
    abstract protected function _addEfpMembers();

    /**
     * filter and add counters to this specific extended family part (has to be implemented for each extended family part if it is specific)
     */
    protected function _filterAndAddCounters($filterOption) {
        $this->_filterAndAddCountersToFamilyPartObject($filterOption);
    }

    /**
     * find individuals: biological parents (in first family)
     *
     * @param Individual $individual
     * @return array of IndividualFamily
     */
    protected function _findBioparentsIndividuals(Individual $individual): array
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
    protected function _findStepparentsIndividuals(Individual $individual): array
    {
        $stepparents = [];
        foreach ($this->_findBioparentsIndividuals($individual) as $parent) {
            foreach ($this->_findPartnersIndividuals($parent->getIndividual()) as $stepparent) {
                if ($stepparent->getIndividual()->xref() !== $parent->getIndividual()->xref()) {
                    $stepparents[] = $stepparent;
                }
            }
        }
        return $stepparents;
    }

    /**
     * find individuals: parents for one branch
     *
     * @param Individual $individual
     * @param string $branch ['bio', 'step']
     * @return array of IndividualFamily
     */
    private function _findParentsBranchIndividuals(Individual $individual, string $branch): array
    {
        if ( $branch == 'bio' ) {
            return $this->_findBioparentsIndividuals($individual);
        } elseif ( $branch == 'step' ) {
            return $this->_findStepparentsIndividuals($individual);
        }
        return [];
    }

    /**
     * find individuals: partners
     *
     * @param Individual $individual
     * @return array of IndividualFamily
     */
    protected function _findPartnersIndividuals(Individual $individual): array
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
    protected function _findFullsiblingsIndividuals(Individual $individual): array
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
    protected function _findHalfsiblingsIndividuals(Individual $individual): array
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
     * find individuals: full or half cousins based on father or mother (in first family)
     *
     * @param Individual $parent
     * @param string $branch ['full', 'half']
     * @return array of IndividualFamily
     */
    protected function _findCousinsBranchIndividuals(Individual $parent, string $branch): array
    {
        $cousins = [];
        foreach ((($branch == 'full')? $this->_findFullsiblingsIndividuals($parent): $this->_findHalfsiblingsIndividuals($parent)) as $Sibling) {
            foreach ($this->_findPartnersIndividuals($Sibling->getIndividual()) as $UncleAunt) {
                foreach ($UncleAunt->getFamily()->children() as $cousin) {
                    $cousins[] = new IndividualFamily($cousin, $UncleAunt->getFamily());
                }
            }
        }
        return $cousins;
    }

    /**
     * add cousins in both branches ['full','half'] or add grandparents in both branches ['bio','step']
     *
     * @param FindBranchConfig $config configuration parameters
     */
    protected function _addFamilyBranches(FindBranchConfig $config)
    {
        foreach ($config->getBranches() as $branch) {
            foreach ($this->_findBioparentsIndividuals($this->_proband) as $parent) {
                foreach ($this->_callFunction('_find'.ucfirst($config->getCallFamilyPart()).'BranchIndividuals', $parent->getIndividual(), $branch) as $Obj) {
                    $this->_addIndividualToFamily( $Obj, $config->getConst()[$branch][$parent->getIndividual()->sex()] );
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
    private function _callFunction(string $name, Individual $individual, string $branch): array
    {
        return $this->$name($individual, $branch);
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
        $nolabelGroups = [                                  // family parts which are not using "groups" and "labels"
            'parents_in_law',
            'partners',
            'partner_chains'
        ];

        if (!isset($referencePerson)) {
            $referencePerson = $this->_proband;
        }
        $found = false;
        /*
        if ($groupName == '') {
            error_log('Soll ' . $indifam->getIndividual()->fullName() . ' (' . $indifam->getIndividual()->xref() . ') der Familie ' . $indifam->getFamily()->fullName() . ' (' . $indifam->getFamily()->xref() . ') hinzugefuegt werden? ');
        } else {
            error_log('Soll ' . $indifam->getIndividual()->fullName() . ' (' . $indifam->getIndividual()->xref() . ') der Gruppe "' . $groupName . '" hinzugefuegt werden? ');
        }
        */
        foreach ($this->_efpObject->groups as $i => $groupObj) {                      // check if individual is already a member of this part of the extended family
            //echo 'Teste groups Nr. ' . $i . ': ';
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
            if ( $groupName == '' ) {
                foreach ($this->_efpObject->groups as $famkey => $groupObj) {                       // check if this family is already stored in this part of the extended family
                    if ($groupObj->family->xref() == $indifam->getFamily()->xref()) {               // family exists already
                        //echo 'famkey in bereits vorhandener Familie: ' . $famkey . ' (Person ' . $individual->fullName() .
                        //     ' in Objekt für Familie ' . $extendedFamilyPart->groups[$famkey]->family->fullName() . '); ';
                        $this->_efpObject->groups[$famkey]->members[] = $indifam->getIndividual();
                        if ( !in_array($this->_efpObject->partName, $nolabelGroups) ) {
                            $this->_addIndividualToGroup($indifam, $groupName, $referencePerson, $referencePerson2);
                        }
                        $found = true;
                        break;
                    }
                }
            } elseif ( array_key_exists($groupName, $this->_efpObject->groups) ) {
                //echo 'In bereits vorhandener Gruppe "' . $groupName . '" Person ' . $individual->xref() . ' hinzugefügt. ';
                if ( !in_array($this->_efpObject->partName, $nolabelGroups) ) {
                    $this->_addIndividualToGroup($indifam, $groupName, $referencePerson, $referencePerson2);
                }
                $found = true;
            }
            if (!$found) {                                                              // individual not found and family not found
                $labels = [];
                $newObj = (object)[];
                $newObj->family = $indifam->getFamily();
                $newObj->members[] = $indifam->getIndividual();
                if ( !in_array($this->_efpObject->partName, $nolabelGroups) ) {
                    /*
                    if ($referencePerson) {                                             // tbd: Logik verkehrt !!! Richtige Personen auswählen (siehe Kommentar ganz oben)!
                        $this->getRelationshipName($referencePerson);
                    }
                    */
                    $labels = array_merge($labels, ExtendedFamily::generateChildLabels($indifam->getIndividual()));
                    $newObj->labels[] = $labels;
                    $newObj->families[] = $indifam->getFamily();
                    $newObj->familiesStatus[] = ExtendedFamily::findFamilyStatus($indifam->getIndividual());
                    $newObj->referencePersons[] = $referencePerson;
                    $newObj->referencePersons2[] = $referencePerson2;
                }
                if ( $this->_efpObject->partName == 'grandparents' || $this->_efpObject->partName == 'parents' || $this->_efpObject->partName == 'parents_in_law' ) {
                    $newObj->familyStatus = ExtendedFamily::findFamilyStatus($indifam->getIndividual());
                    if ($referencePerson) {
                        $newObj->partner = $referencePerson;
                        if ($referencePerson2) {
                            foreach ($referencePerson2->spouseFamilies() as $fam) {
                                //echo "Teste Familie ".$fam->fullName().":";
                                foreach ($fam->spouses() as $partner) {
                                    if ( $partner->xref() == $referencePerson->xref() ) {
                                        //echo $referencePerson->fullName();
                                        $newObj->partnerFamilyStatus = ExtendedFamily::findFamilyStatus($fam);
                                    }
                                }
                            }
                        } else {
                            $newObj->partnerFamilyStatus = 'Partnership';
                        }
                    }
                }
                if ($groupName == '') {
                    $this->_efpObject->groups[] = $newObj;
                    /*
                    echo "<br>Neu hinzugefügte Familie Nr. " . (count($this->_efpObject->groups) - 1) .
                        ' (Person ' .
                        $indifam->getIndividual()->fullName() .
                        ' in Objekt für Familie ' .
                        $this->_efpObject->groups[count($this->_efpObject->groups) - 1]->family->xref() .
                        '); ';
                    */
                } else {
                    $newObj->groupName = $groupName;
                    $this->_efpObject->groups[$groupName] = $newObj;
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
    private function _addIndividualToGroup(IndividualFamily $indifam, string $groupName, Individual $referencePerson = null, Individual $referencePerson2 = null )
    {
        $this->_efpObject->groups[$groupName]->members[] = $indifam->getIndividual();                                                                         // array of strings
        $this->_efpObject->groups[$groupName]->labels[] = ExtendedFamily::generateChildLabels($indifam->getIndividual());
        $this->_efpObject->groups[$groupName]->families[] = $indifam->getFamily();
        $this->_efpObject->groups[$groupName]->familiesStatus[] = ExtendedFamily::findFamilyStatus($indifam->getFamily());
        $this->_efpObject->groups[$groupName]->referencePersons[] = $referencePerson;
        $this->_efpObject->groups[$groupName]->referencePersons2[] = $referencePerson2;
    }

    /**
     * filter individuals and count them per family or per group and per sex
     *
     * @param string $filterOption
     */
    protected function _filterAndAddCountersToFamilyPartObject(string $filterOption)
    {
        if ( $filterOption !== 'all' ) {
            $this->_filter( ExtendedFamily::convertfilterOptions($filterOption) );
        }
        $this->_addCountersToFamilyPartObject();
    }

    /**
     * filter individuals in extended family part
     *
     * @param array $filterOptions of string $filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    protected function _filter(array $filterOptions)
    {
        if ( ($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all') ) {
            foreach ($this->_efpObject->groups as $group) {
                foreach ($group->members as $key => $member) {
                    if ( ($filterOptions['alive'] == 'only_alive' && $member->isDead()) || ($filterOptions['alive'] == 'only_dead' && !$member->isDead()) ||
                        ($filterOptions['sex'] == 'only_M' && $member->sex() !== 'M') || ($filterOptions['sex'] == 'only_F' && $member->sex() !== 'F') || ($filterOptions['sex'] == 'only_U' && $member->sex() !== 'U') ) {
                        unset($group->members[$key]);
                    }
                }
            }
        }
        foreach ($this->_efpObject->groups as $key => $group) {
            if (count($group->members) == 0) {
                unset($this->_efpObject->groups[$key]);
            }
        }

        return;
    }

    /**
     * count individuals per family or per group and add them to this extended family part object
     */
    protected function _addCountersToFamilyPartObject()
    {
        list ( $countMale, $countFemale, $countOthers ) = [0, 0 , 0];
        foreach ($this->_efpObject->groups as $group) {
            $counter = $this->_countMaleFemale($group->members);
            $countMale += $counter->male;
            $countFemale += $counter->female;
            $countOthers += $counter->unknown_others;
        }
        list ( $this->_efpObject->maleCount, $this->_efpObject->femaleCount, $this->_efpObject->otherSexCount, $this->_efpObject->allCount ) = [$countMale, $countFemale, $countOthers, $countMale + $countFemale + $countOthers];
    }

    /**
     * count male and female individuals
     *
     * @param array of individuals
     * @return object with three elements: male, female and unknown_others (int >= 0)
     */
    protected function _countMaleFemale(array $indilist): object
    {
        $mfu = (object)[];
        list ( $mfu->male, $mfu->female, $mfu->unknown_others ) = [0, 0, 0];
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
