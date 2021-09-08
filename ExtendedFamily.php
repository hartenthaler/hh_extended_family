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

/*
 * tbd: offene Punkte
 * ------------------
 *
 * alle inhaltlichen Funktionen, die sich im Kern um die erweiterte Familienteile drehen, hierher verschieben
 * neue Klassen für die einzelnen Zweige der erweiterten Familie mit den jeweiligen Hilfsfunktionen definieren
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * Class ExtendedFamily
 *
 * data and methods for extended family
 */
class ExtendedFamily
{
    
    // ------------ definition of data structure
    
    /**
     * $Config                                      object
     *        ->showEmptyBlock                      int [0,1,2]
     *        ->showLabels                          bool
     *        ->useCompactDesign                    bool
     *        ->showThumbnail                       bool
     *        ->filterOptions                       array of string
     */
    private $Config;
    
    /**
     * $Proband                                     object
     *         ->indi                               Individual
     *         ->niceName                           string
     *         ->label                              string
     */
    private $Proband;
        
    /**
     * $Filters                                                             array of object (index is string filteroption)
     *         ->efp                                                        object
     *                 ->allCount                                           int
     *                 ->summaryMessageEmptyBlocks                          string
	 *                 ->grandparents                                       see parents-in-law
     *                 ->uncles_and_aunts                                   see children
     *                 ->uncles_and_aunts_bm                                see children
     *                 ->parents                                            see parents_in_law
     *                 ->parents_in_law->groups[]->members[]                array of object individual   (index of groups is int)
     *                                           ->family                   object family
     *                                           ->familyStatus             string
     *                                           ->partner                  Individual
     *                                           ->partnerFamilyStatus      string
     *                                 ->maleCount                          int    
     *                                 ->femaleCount                        int
     *                                 ->allCount                           int
     *                                 ->partName                           string
     *        					       ->partName_translated	            string
     *        					       ->type					            string
     *                 ->co_parents_in_law                                  see children
     *                 ->partners->groups[]->members[]                      array of object individual   (index of groups is XREF)
     *                                     ->partner                        object individual
     *                           ->pCount                                   int
     *                           ->pmaleCount                               int
     *                           ->pfemaleCount                             int
     *                           ->popCount                                 int
     *                           ->popmaleCount                             int
     *                           ->popfemaleCount                           int
     *                           ->maleCount                                int    
     *                           ->femaleCount                              int
     *                           ->allCount                                 int
     *                           ->partName                                 string
     *        				     ->partName_translated			            string
     *        				     ->type							            string
     *                 ->partner_chains->chains[]                           array of object (tree of marriage chain nodes)
     *                                 ->displayChains[]                    array of chain (array of chainPerson objects)
     *                                 ->chainsCount                        int (number of chains)
     *                                 ->longestChainCount                  int
     *                                 ->mostDistantPartner                 Individual (first one if there are more than one)
     *                                 ->maleCount                          int    
     *                                 ->femaleCount                        int
     *                                 ->allCount                           int
     *                                 ->partName                           string
     *        				           ->partName_translated	            string
     *        				           ->type					            string
     *                 ->siblings                                           see children 
     *                 ->siblings_in_law                                    see children
     *                 ->co_siblings_in_law                                 see children
     *                 ->cousins                                            see children
     *                 ->nephews_and_nieces                                 see children
     *                 ->children->groups[]->members[]                      array of object individual   (index of groups is groupName)
     *                                     ->labels[]                       array of array of string
     *                                     ->families[]                     array of object
     *                                     ->familiesStatus[]               string
     *                                     ->referencePersons[]             Individual
     *                                     ->referencePersons2[]            Individual
     *                                     ->groupName                      string
     *                           ->maleCount                                int    
     *                           ->femaleCount                              int
     *                           ->allCount                                 int
     *                           ->partName                                 string
     *        				     ->partName_translated			            string
     *        				     ->type							            string
     *                 ->children_in_law                                    see children
     *                 ->grandchildren                                      see children
     */
    private $Filters;
    
    // ------------ definition of methods
    
    /**
     * Extended Family Constructor
     *
     * @param Individual $proband the proband for whom the extended family members are searched
     */
    public function __construct(Individual $proband)
    {
        $this->constructProband($proband); 
        $this->constructConfig();
        $this->constructFiltersExtendedFamilyParts();
    }
    
    /**
     * get object containing configuration parameters
     *
     * @return object
     */
    public function getConfig(): object
    {
        return $this->Config;
    }
    
    /**
     * get object containing information about the proband
     *
     * @return object
     */
    public function getProband(): object
    {
        return $this->Proband;
    }
    
    /**
     * get list of extended family parts per filter combination
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->Filters;
    }
    
    /**
     * construct object containing information related to the proband
     *
     * @param Individual $proband
     */
    private function constructProband(Individual $proband)
    {
        $this->Proband = (object)[];
        $this->Proband->indi      = $proband;
        $this->Proband->niceName  = 'Susi';
        $this->Proband->label     = 'adopted, foster';
        /*
        $this->Proband->niceName  = $this->niceName( $proband );
        $this->Proband->label     = implode(", ", $this->getChildLabels( $proband ));
        */
        return;
    }
    
    /**
     * construct object containing configuration information based on module parameters
     */
    private function constructConfig()
    {
        $this->Config = (object)[];
        $this->Config->showEmptyBlock     = 1;
        $this->Config->showLabels         = true;
        $this->Config->useCompactDesign   = true;
        $this->Config->showThumbnail      = true;
        $this->Config->showFilterOptions  = true;
        $this->Config->filterOptions      = [$this->Proband->indi->fullName()];
        /*
        $this->Config->showEmptyBlock     = $this->showEmptyBlock();
        $this->Config->showLabels         = $this->showLabels();
        $this->Config->useCompactDesign   = $this->useCompactDesign();
        $this->Config->showThumbnail      = $this->showThumbnail( $proband->tree() );
        $this->Config->showFilterOptions  = $this->showFilterOptions();
        $this->Config->filterOptions      = $this->getFilterOptions();
        */
        return;
    }
    
    /**
     * construct array of extended family parts for all combinations of filter options
     */
    private function constructFiltersExtendedFamilyParts()
    {
        $this->Filters = [];
        foreach ($this->Config->filterOptions as $filterOption) {
            $extfamObj = (object)[];
            $extfamObj->efp = (object)[];
            $extfamObj->efp->allCount = 0;
            /*
            foreach ($this->showFamilyParts() as $efp => $element) {
                if ( $element->enabled ) {
                    $extfamObj->efp->$efp = $this->initializedFamilyPartObject($efp);
                    $this->callFunction( 'get_' . $efp, $extfamObj->efp->$efp );
                    $this->filterAndAddCountersToFamilyPartObject( $extfamObj->efp->$efp, $this->Proband->indi, $filterOption );
                    $extfamObj->efp->allCount += $extfamObj->efp->$efp->allCount;
                }
            }
            $extfamObj->efp->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj, $this->Proband->niceName);
            */
            $this->Filters[$filterOption] = $extfamObj;
        }
        return;
    }
    
    /**
     * call functions to get extended family parts
     *
     * @param string $name name of function to be called
     * @param object $extendedFamilyPart extended family part (modified by this function)
     */   
    private function callFunction($name, object &$extendedFamilyPart)
    {
        return $this->$name($extendedFamilyPart);
    }
    
    /**
     * list of parts of extended family
     *
     * @return array
     */
    private function listOfFamilyParts(): array         // new elements can be added, but not changed or deleted; names of elements should be shorter than 25 characters
    {    
        return [
            'grandparents',                             // generation +2
            'uncles_and_aunts',                         // generation +1
            'uncles_and_aunts_bm',                      // generation +1     // uncles and aunts by marriage
            'parents',                                  // generation +1
            'parents_in_law',                           // generation +1
            'co_parents_in_law',                        // generation  0           
            'partners',                                 // generation  0
            'partner_chains',                           // generation  0
            'siblings',                                 // generation  0
            'siblings_in_law',                          // generation  0
            'co_siblings_in_law',                       // generation  0
            'cousins',                                  // generation  0
            'nephews_and_nieces',                       // generation -1
            'children',                                 // generation -1
            'children_in_law',                          // generation -1
            'grandchildren',                            // generation -2
        ];
    }
}

?>
