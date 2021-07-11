<?php
/*
 * webtrees - extended family tab based on vytux_cousins and simpl_cousins
 *
 * Copyright (C) 2021 Hermann Hartenthaler. All rights reserved.
 *
 * Copyright (C) 2013 Vytautas Krivickas and vytux.com. All rights reserved. 
 *
 * Copyright (C) 2013 Nigel Osborne and kiwtrees.net. All rights reserved.
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

declare(strict_types=1);

namespace Hartenthaler\WebtreesModules\hh_extended_family;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\View;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Registry;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Gedcom;
use Fisharebest\Webtrees\GedcomCode\GedcomCodePedi;
use Fisharebest\Webtrees\FlashMessages;
use Fisharebest\Localization\Translation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleTabTrait;
use Fisharebest\Webtrees\Module\ModuleConfigTrait;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleTabInterface;
use Fisharebest\Webtrees\Module\ModuleConfigInterface;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;

/**
 * Class ExtendedFamilyTabModule
 */
class ExtendedFamilyTabModule extends AbstractModule implements ModuleTabInterface, ModuleCustomInterface, ModuleConfigInterface
{
    use ModuleTabTrait;
    use ModuleCustomTrait;
    use ModuleConfigTrait;

    public const CUSTOM_TITLE = 'Extended family';
    
    public const CUSTOM_MODULE = 'hh_extended_family';
    
    public const CUSTOM_DESCRIPTION = 'A tab showing the extended family of an individual.';

    public const CUSTOM_AUTHOR = 'Hermann Hartenthaler';
    
    public const CUSTOM_WEBSITE = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE . '/';
    
    public const CUSTOM_VERSION = '2.0.16.26';

    public const CUSTOM_LAST = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE. '/raw/main/latest-version.txt';

    /**
     * list of parts of extended family
     *
     * @return array
     */
    private function listOfFamilyParts(): array
    {    
        $efp = [
            'grandparents',                             // generation +2
            'parents',                                  // generation +1
            'uncles_and_aunts',                         // generation +1
            'siblings',                                 // generation  0
            'partners',                                 // generation  0
            'cousins',                                  // generation  0
            'nephews_and_nieces',                       // generation -1
            'children',                                 // generation -1
            'grandchildren',                            // generation -2
        ];
        
        return $efp;
    }
   
    /**
     * Find members of extended family
     *
     * @param Individual $individual
     *
     * @return object
     *  ->self->indi                                            object individual
     *        ->niceName                                        string
     *  ->efp->allCount                                         integer
     *       ->summaryMessageEmptyBlocks                        string
     *       ->grandparents->father                             object individual
     *                     ->mother                             object individual
     *                     ->fatherFamily[]                     array of object individual 
     *                     ->motherFamily[]                     array of object individual
     *                     ->fatherAndMotherFamily[]            array of object individual    
     *                     ->fathersFamilyCount                 integer
     *                     ->mothersFamilyCount                 integer
     *                     ->fathersAndMothersFamilyCount       integer    
     *                     ->fathersMaleCount                   integer
     *                     ->fathersFemaleCount                 integer
     *                     ->mothersMaleCount                   integer
     *                     ->mothersFemaleCount                 integer    
     *                     ->fathersAndMothersMaleCount         integer
     *                     ->fathersAndMothersFemaleCount       integer
     *                     ->maleCount                          integer    
     *                     ->femaleCount                        integer
     *                     ->allCount                           integer
     *                     ->partName                           string
	 *					   ->partName_translated				string
	 *					   ->type								string
     *       ->parents                                          see grandparents
     *       ->uncles_and_aunts                                 see grandparents
     *       ->siblings                                         see nephews_and_nieces    
     *       ->partners                                         see nephews_and_nieces
     *       ->cousins                                          see grandparents
     *       ->nephews_and_nieces->families[]->members[]        array of object individual
     *                                       ->family           object family
     *                           ->maleCount                    integer    
     *                           ->femaleCount                  integer
     *                           ->allCount                     integer
     *                           ->partName                     string
	 *					   	     ->partName_translated			string
	 *					   		 ->type							string
     *       ->children                                         see nephews_and_nieces
     *       ->grandchildren                                    see nephews_and_nieces
     *  ->config->showEmptyBlock                                integer [0,1,2]
     *
     * tbd: use array instead of object, ie efp['grandparents' => $this->get_grandparents( $individual ) , ...] instead of efp->grandparents, ...
     * tbd: Stiefcousins testen (siehe Onkel Walter)
     */
    private function getExtendedFamily(Individual $individual): object
    {             
        $extfamObj = (object)[];
        $extfamObj->self = $this->get_self( $individual );
        $extfamObj->efp = (object)[];
        $extfamObj->efp->allCount = 0;
        $extfamObj->config = (object)[];
        $extfamObj->config->showEmptyBlock = $this->showEmptyBlock();

        $efps = $this->showFamilyParts();
        foreach ($efps as $efp => $value) {
            if ($efps[$efp]->enabled == true) {
                $extfamObj->efp->$efp = $this->callFunction( 'get_' . $efp, $individual );
                $extfamObj->efp->allCount += $extfamObj->efp->$efp->allCount;
            }
        }
        $extfamObj->efp->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj);

       return $extfamObj;
    }

    /**
     * call functions to get extended family parts
     *
     * @param $name name of function to be called
     * @param $parameter parameter to be transfered to the called function
     *
     * @return object
     */   
    private function callFunction($name, $parameter)
    {
        return $this->$name($parameter);
    }
    
    /**
     * self finding
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_self(Individual $individual): object
    {
        $selfObj = (object)[];
        
        $selfObj->indi = $individual;
        $selfObj->niceName = $this->niceName( $individual );
        return $selfObj;
    }
    
    /**
     * Find grandparents for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side ('father', 'mother'); father is default
     */
    private function get_grandparentsOneSide(object $extendedFamilyPart, string $side)
    {
        $parent = $extendedFamilyPart->$side;
        if ($parent instanceof Individual) {                                                    // Gen 1 P
            foreach ($parent->spouseFamilies() as $family1) {                                   // Gen 1 F
                foreach ($family1->spouses() as $spouse) {                                      // Gen 1 P
                    if (!($side == 'father' and $spouse == $extendedFamilyPart->mother) and !($side == 'mother' and $spouse == $extendedFamilyPart->father)) {
                        foreach ($spouse->childFamilies() as $family1) {                        // Gen 2 F
                            foreach ($family1->spouses() as $spouse1) {                         // Gen 2 P
                                foreach ($spouse1->spouseFamilies() as $family2) {              // Gen 2 F
                                    foreach ($family2->spouses() as $spouse2) {                 // Gen 2 P
                                        foreach ($spouse2->spouseFamilies() as $family3) {      // Gen 2 F
                                            foreach ($family3->spouses() as $spouse3) {         // Gen 2 P
                                                $this->addIndividualToAncestorsFamily( $spouse3, $extendedFamilyPart, $side );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return;
    }
    
    /**
     * Find grandparents
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_grandparents(Individual $individual): object
    {      
        $GrandparentsObj = $this->initializedFamilyPartObject('grandparents');
        
        if ($individual->childFamilies()->first()) {
            
            // husband() or wife() may not exist
            $GrandparentsObj->father = $individual->childFamilies()->first()->husband();
            $GrandparentsObj->mother = $individual->childFamilies()->first()->wife();

            $this->get_grandparentsOneSide( $GrandparentsObj, 'father');
            $this->get_grandparentsOneSide( $GrandparentsObj, 'mother');
             
            $this->addCountersToFamilyPartObject( $GrandparentsObj );
        }

        return $GrandparentsObj;
    }

    /**
     * Find parents for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side ('father', 'mother'); father is default
     */
    private function get_parentsOneSide(object $extendedFamilyPart, string $side)
    {
        $parent = $extendedFamilyPart->$side;
        if ($parent instanceof Individual) {                                                    // Gen 1 P
            foreach ($parent->spouseFamilies() as $family1) {                                   // Gen 1 F
                foreach ($family1->spouses() as $spouse) {                                      // Gen 1 P
                    if (!($side == 'father' and $spouse == $extendedFamilyPart->mother) and !($side == 'mother' and $spouse == $extendedFamilyPart->father)) {
                        $this->addIndividualToAncestorsFamily( $spouse, $extendedFamilyPart, $side );
                    }
                }
            }
        }
        
        return;
    }

    /**
     * Find parents
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_parents(Individual $individual): object
    {      
        $ParentsObj = $this->initializedFamilyPartObject('parents');
        
        if ($individual->childFamilies()->first()) {
            
            // husband() or wife() may not exist
            $ParentsObj->father = $individual->childFamilies()->first()->husband();
            $ParentsObj->mother = $individual->childFamilies()->first()->wife();

            $this->get_parentsOneSide( $ParentsObj, 'father');
            $this->get_parentsOneSide( $ParentsObj, 'mother');
             
            $this->addCountersToFamilyPartObject( $ParentsObj  );
        }

        return $ParentsObj;
    }
    
    /**
     * Find uncles and aunts for one side including uncles and aunts by marriage
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side ('father', 'mother'); father is default
     */
    private function get_uncles_and_auntsOneSide(object $extendedFamilyPart, string $side)
    {
        $parent = $extendedFamilyPart->$side;
        if ($parent instanceof Individual) {                                            // Gen 1 P
           foreach ($parent->childFamilies() as $family1) {                             // Gen 2 F
              foreach ($family1->spouses() as $grandparent) {                           // Gen 2 P
                 foreach ($grandparent->spouseFamilies() as $family2) {                 // Gen 2 F
                    foreach ($family2->children() as $uncleaunt) {                      // Gen 1 P
                        if($uncleaunt !== $parent) {
                            //foreach ($uncleaunt->spouseFamilies() as $family3) {      // Gen 1 F    tbd: designed to include uncles/aunts by marriage; but how to group them with their partner in tab.html?
                                //foreach ($family3->spouses() as $uncleaunt2) {        // Gen 1 P
                                    $this->addIndividualToAncestorsFamily( $uncleaunt, $extendedFamilyPart, $side );
                                //}
                            //}
                        }
                    }
                 }
              }
           }
        }
        
        return;
    }
    
    /**
     * Find uncles and aunts
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_uncles_and_aunts(Individual $individual): object
    {
        $unclesAuntsObj = $this->initializedFamilyPartObject('uncles_and_aunts');
        
        if ($individual->childFamilies()->first()) {
            
            $unclesAuntsObj->father = $individual->childFamilies()->first()->husband();
            $unclesAuntsObj->mother = $individual->childFamilies()->first()->wife();

            $this->get_uncles_and_auntsOneSide( $unclesAuntsObj, 'father');
            $this->get_uncles_and_auntsOneSide( $unclesAuntsObj, 'mother');
           
            $this->addCountersToFamilyPartObject( $unclesAuntsObj );
        }

        return $unclesAuntsObj;
    }

    /**
     * Find siblings including step-siblings
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_siblings(Individual $individual): object
    {      
        $SiblingsObj = $this->initializedFamilyPartObject('siblings');
        
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $child) {                                  // Gen  0 P
                        if ($child !== $individual) {
                            $this->addIndividualToDescendantsFamily( $child, $SiblingsObj, $family1 );
                        }
                    }
                }
            }
        }

        $this->addCountersToFamilyPartObject( $SiblingsObj );

        return $SiblingsObj;
    }
    
    /**
     * Find partners including partners of partners
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_partners(Individual $individual): object
    {      
        $PartnersObj = $this->initializedFamilyPartObject('partners');
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->spouses() as $spouse2) {                                 // Gen  0 P
                        if ($spouse2 !== $individual) {
                            $this->addIndividualToDescendantsFamily( $spouse2, $PartnersObj, $family1 );
                        }
                    }
                }
            }
        }
        $this->addCountersToFamilyPartObject( $PartnersObj );

        return $PartnersObj;
    }
    
    /**
     * Find half and full cousins for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side ('father', 'mother'); father is default
     */
    private function get_cousinsOneSide(object $extendedFamilyPart, string $side)
    {
        $parent = $extendedFamilyPart->$side;
        if ($parent instanceof Individual) {                                            // Gen 1 P    
           foreach ($parent->childFamilies() as $family1) {                             // Gen 2 F
                foreach ($family1->spouses() as $grandparent) {                         // Gen 2 P
                    foreach ($grandparent->spouseFamilies() as $family2) {              // Gen 2 F
                        foreach ($family2->children() as $uncleaunt) {                  // Gen 1 P
                            if($uncleaunt !== $parent) {
                                foreach ($uncleaunt->spouseFamilies() as $family3) {    // Gen 1 F
                                    foreach ($family3->children() as $cousin) {         // Gen 0 P
                                        $this->addIndividualToAncestorsFamily( $cousin, $extendedFamilyPart, $side );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return;
    }
    
    /**
     * Find half and full cousins
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_cousins(Individual $individual): object
    {
        $CousinsObj = $this->initializedFamilyPartObject('cousins');
        
        if ($individual->childFamilies()->first()) {
            $CousinsObj->father = $individual->childFamilies()->first()->husband();
            $CousinsObj->mother = $individual->childFamilies()->first()->wife();

            $this->get_cousinsOneSide( $CousinsObj, 'father');
            $this->get_cousinsOneSide( $CousinsObj, 'mother');
             
            $this->addCountersToFamilyPartObject( $CousinsObj );
        }

        return $CousinsObj;
    }
    
    /**
     * Find nephews and nieces
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_nephews_and_nieces(Individual $individual): object
    {      
        $NephewsNiecesObj = $this->initializedFamilyPartObject('nephews_and_nieces');
          
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ( $sibling !== $individual) {
                            foreach ($sibling->spouseFamilies() as $family3) {                  // Gen  0 F
                                foreach ($family3->spouses() as $parent) {                      // Gen  0 P
                                    foreach ($parent->spouseFamilies() as $family4) {           // Gen  0 F    
                                        foreach ($family4->children() as $nephewniece) {        // Gen -1 P
                                            $this->addIndividualToDescendantsFamily( $nephewniece, $NephewsNiecesObj, $family1 );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
          
        $this->addCountersToFamilyPartObject( $NephewsNiecesObj );

        return $NephewsNiecesObj;
    }

    /**
     * Find children including step-children
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_children(Individual $individual): object
    {      
        $ChildrenObj = $this->initializedFamilyPartObject('children');
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        $this->addIndividualToDescendantsFamily( $child, $ChildrenObj, $family1 );
                    }
                }
            }
        }
        $this->addCountersToFamilyPartObject( $ChildrenObj );

        return $ChildrenObj;
    }
    
    /**
     * Find grandchildren including step- and step-step-grandchildren
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_grandchildren(Individual $individual): object
    {      
        $GrandchildrenObj = $this->initializedFamilyPartObject('grandchildren');
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        foreach ($child->spouseFamilies() as $family3) {                        // Gen -1 F
                            foreach ($family3->spouses() as $childstepchild) {                  // Gen -1 P
                                foreach ($childstepchild->spouseFamilies() as $family4) {       // Gen -1 F    
                                    foreach ($family4->children() as $grandchild) {             // Gen -2 P
                                        $this->addIndividualToDescendantsFamily( $grandchild, $GrandchildrenObj, $family1 );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->addCountersToFamilyPartObject( $GrandchildrenObj );

        return $GrandchildrenObj;
    }
    
    /**
     * initialize part of extended family (object contains arrays of individuals or families and several counter values)
     *
     * @param string name of part of extended family
     * @return initialized object
     */
    private function initializedFamilyPartObject(string $partName): object
    {    
        $efpObj = (object)[];
        $efpObj->partName = $partName;
		$efpObj->partName_translated = $this->translateFamilyPart($partName);
		$efpObj->type = $this->typeOfFamilyPart($partName);
        $efpObj->allCount = 0;
        
        if ($efpObj->type == 'ancestors') {
            $efpObj->fatherFamily = [];
            $efpObj->motherFamily = [];
            $efpObj->fatherAndMotherFamily = [];
        } elseif ($efpObj->type == 'descendants') {
            $efpObj->families = [];
        }
        
        return $efpObj;
    }
    
    /**
     * type of part of extended family
     *
     * @param name of part of extended family 
     * @return string ['ancestors', 'descendants']
     */
    private function typeOfFamilyPart(string $partName): string
    {       
        switch ($partName) {
            case 'grandparents':
            case 'parents':
            case 'uncles_and_aunts':
            case 'cousins': 
                return 'ancestors';
            default:
                return 'descendants';
        }
    }
    
   /**
    * add an individual to the extended family (of type 'ancestors') if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family
    * @param string prefered family side ('father', 'mother'); father is default
    */
    private function addIndividualToAncestorsFamily(Individual $individual, object $extendedFamilyPart, string $side)
    {
        if ($side == 'mother') {
            if ( in_array( $individual, $extendedFamilyPart->fatherAndMotherFamily )){
                // already stored in father's and mother's array: do nothing
            } elseif ( in_array( $individual, $extendedFamilyPart->fatherFamily )){
                $extendedFamilyPart->fatherAndMotherFamily[] = $individual;
                unset($extendedFamilyPart->fatherFamily[array_search($individual,$extendedFamilyPart->fatherFamily)]);
            } elseif ( !in_array( $individual, $extendedFamilyPart->motherFamily ) ) {
                $extendedFamilyPart->motherFamily[] = $individual;
            }
        } elseif ( !in_array( $individual, $extendedFamilyPart->fatherFamily ) ) {
            if ( in_array( $individual, $extendedFamilyPart->fatherAndMotherFamily )){
                // already stored in father's and mother's array: do nothing
            } elseif ( in_array( $individual, $extendedFamilyPart->motherFamily )){
                $extendedFamilyPart->fatherAndMotherFamily[] = $individual;
                unset($extendedFamilyPart->motherFamily[array_search($individual,$extendedFamilyPart->motherFamily)]);
            } elseif ( !in_array( $individual, $extendedFamilyPart->fatherFamily ) ) {
                $extendedFamilyPart->fatherFamily[] = $individual;
            }
        }
        
        return;
    }
    
   /**
    * add an individual to the extended family (of type 'descendants') if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family
    * @param object family (on level of proband) to which these descendants are belonging
    */
    private function addIndividualToDescendantsFamily(Individual $individual, object $extendedFamilyPart, object $family)
    {
        $found = 0;
   
        foreach ($extendedFamilyPart->families as $famobj) {        // check if individual is already a member of this part of the exetnded family        
            foreach ($famobj->members as $member) {
                if ($member == $individual) {
                    $found = 1;
                    //echo 'Person ' . $individual->xref() . ' ist bereits in Objekt für Familie ' . $famobj->family->xref() . ' vorhanden. ';
                    break;
                }
            }
            break;
        }
        
        if ($found == 0) {                                          // individual has to be added 
            foreach ($extendedFamilyPart->families as $famobj) {    // check if this family is already stored in this part of the extended family
                if ($famobj->family == $family) {
                    $famkey = key($extendedFamilyPart->families);
                    //echo 'famkey in bereits vorhandener Familie: ' . $famkey . ' (Person ' . $individual->xref() . ' in Objekt für Familie ' . $extendedFamilyPart->families[$famkey]->family->xref() . '); ';
                    $extendedFamilyPart->families[$famkey]->members[] = $individual;
                    $found = 1;
                    break;
                }
            }
            if ($found == 0) {                                      // individual not found and family not found
                $famkey = count($extendedFamilyPart->families);
                $extendedFamilyPart->families[$famkey] = (object)[];
                $extendedFamilyPart->families[$famkey]->family = $family;
                $extendedFamilyPart->families[$famkey]->members[] = $individual;
                //echo 'famkey in neu hinzugefügter Familie: ' . $famkey . ' (Person ' . $individual->xref() . ' in Objekt für Familie ' . $extendedFamilyPart->families[$famkey]->family->xref() . '); ';
            }
            
        }
        
        return;
    }
    
    /**
     * count individuals per family (maybe including mother/father/motherAndFather families) and per sex
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     */
    private function addCountersToFamilyPartObject( object $extendedFamilyPart )
    {
        
        if ($this->typeOfFamilyPart($extendedFamilyPart->partName) == 'ancestors') {
            $extendedFamilyPart->fathersFamilyCount = sizeof( $extendedFamilyPart->fatherFamily );
            $extendedFamilyPart->mothersFamilyCount = sizeof( $extendedFamilyPart->motherFamily );
            $extendedFamilyPart->fathersAndMothersFamilyCount = sizeof( $extendedFamilyPart->fatherAndMotherFamily );
            
            $count = $this->countMaleFemale( $extendedFamilyPart->fatherFamily );
            $extendedFamilyPart->fathersMaleCount = $count->male;
            $extendedFamilyPart->fathersFemaleCount = $count->female;
                                  
            $count = $this->countMaleFemale( $extendedFamilyPart->motherFamily );
            $extendedFamilyPart->mothersMaleCount = $count->male;
            $extendedFamilyPart->mothersFemaleCount = $count->female;
                                              
            $count = $this->countMaleFemale( $extendedFamilyPart->fatherAndMotherFamily );
            $extendedFamilyPart->fathersAndMothersMaleCount = $count->male;
            $extendedFamilyPart->fathersAndMothersFemaleCount = $count->female;

            $extendedFamilyPart->maleCount = $extendedFamilyPart->fathersMaleCount + $extendedFamilyPart->mothersMaleCount + $extendedFamilyPart->fathersAndMothersMaleCount;
            $extendedFamilyPart->femaleCount = $extendedFamilyPart->fathersFemaleCount + $extendedFamilyPart->mothersFemaleCount + $extendedFamilyPart->fathersAndMothersFemaleCount;
            $extendedFamilyPart->allCount = $extendedFamilyPart->fathersFamilyCount + $extendedFamilyPart->mothersFamilyCount + $extendedFamilyPart->fathersAndMothersFamilyCount;
        } elseif ($this->typeOfFamilyPart($extendedFamilyPart->partName) == 'descendants') {
            $countMale = 0;
            $countFemale = 0;
            $countOthers = 0;
            foreach ($extendedFamilyPart->families as $family) {
                $count = $this->countMaleFemale( $family->members );
                $countMale += $count->male;
                $countFemale += $count->female;
                $countOthers += $count->unknown_others;
            }
            $extendedFamilyPart->maleCount = $countMale;
            $extendedFamilyPart->femaleCount = $countFemale;
            $extendedFamilyPart->allCount = $countMale + $countFemale + $countOthers;
        }
        
        return;
    }
    
    /**
     * count male and female individuals
     *
     * @param array of individuals
     *
     * @return object with three elements: male, female and unknown_others (integer >= 0)
     */
    private function countMaleFemale(array $indilist): object
    {
        $mf = (object)[];
        $mf->male = 0;
        $mf->female = 0;
        $mf->unknown_others=0;
    
        foreach ($indilist as $il) {
            if ($il instanceof Individual) {
                if ($il->sex() == "M") {
                    $mf->male++;
                } elseif ($il->sex() == "F") {
                    $mf->female++;
                } else {
                   $mf->unknown_others++; 
                }
            }
        }
        
        return $mf;
    }
        
    /**
     * find rufname of an individual (tag _RUFNAME or marked with '*'
     *
     * @param Individual $individual
     *
     * @return string (is empty if there is no Rufname)
     */
    private function rufname(Individual $individual): string
    {
        $rn = $individual->facts(['NAME'])[0]->attribute('_RUFNAME');
        if ($rn == '') {
            $rufnameparts = explode('*', $individual->facts(['NAME'])[0]->value());
            if ($rufnameparts[0] !== $individual->facts(['NAME'])[0]->value()) {
                // there is a Rufname marked with *, but no tag _RUFNAME
                $rufnameparts = explode(' ', $rufnameparts[0]);   
                $rn = $rufnameparts[count($rufnameparts)-1];  // it has to be the last given name (before *)
            }
        }
        return $rn;
    }
     
    /**
     * set name depending on sex of individual
     *
     * @param Individual $individual
     * @param string $n_male
     * @param string $n_female
     * @param string $n_unknown
     *
     * @return string
     */
    private function nameSex(Individual $individual, string $n_male, string $n_female, string $n_unknown): string
    {
        if ($individual->sex() == 'M') {
            return $n_male;
        } elseif ($individual->sex() == 'F') {
            return $n_female;
        } else {
            return $n_unknown;
        }
    }
    
    /**
     * Find a short, nice name for a person
     * => use Rufname or nickname ("Sepp") or first of first names if one of these is available
     *    => otherwise use surname if available ("Mr. xxx", "Mrs. xxx", or "xxx" if sex is not F or M
     *       => otherwise use "He" or "She" (or "She/he" if sex is not F or M)
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function niceName(Individual $individual): string
    {
        $optionFullName = !$this->showShortName();
        if ($optionFullName) {
            $nice = $individual->fullname();
        } else {
            $nice = '';
            // an individual can have no name or many names (then we use only the first one)
            $name_facts = $individual->facts(['NAME']);
            if (count($name_facts) > 0) {                                           // check if there is at least one name            
                $rn = $this->rufname($individual);
                if ($rn !== '') {
                    $nice = $rn;
                } else {
                    $nickname = $name_facts[0]->attribute('NICK');
                    if ($nickname !== '') {
                        $nice = $nickname;
                    } else {
                        $npfx = $name_facts[0]->attribute('NPFX');
                        $givenAndSurnames = explode('/', $name_facts[0]->value());
                        if ($givenAndSurnames[0] !== '') {                          // are there given names (or prefix nameparts)?
                            $givennameparts = explode( ' ', $givenAndSurnames[0]);
                            if ($npfx == '') {                                      // find the first given name
                                $nice = $givennameparts[0];                         // the first given name
                            } elseif (count(explode(' ',$npfx)) !== count($givennameparts)) {
                                $nice = $givennameparts[count(explode(' ',$npfx))]; // the first given name after the prefix nameparts
                            }
                        }
                    }
                }
            } else {
                $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
            }
            if ($nice == '') {
                $surname = $givenAndSurnames[1];
                if ($surname !== '') {
                    $nice = $this->nameSex($individual, I18N::translate('Mr.') . ' ' . $surname, I18N::translate('Mrs.') . ' ' . $surname, $surname);
                } else {
                    $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
                }
            }
        }
        return $nice;
    }
    
   /**
    * generate summary message for all empty blocks (needed for showEmptyBlock == 1)
    *
    * @param object extended family
    *
    * @return string
    */
    private function summaryMessageEmptyBlocks(object $extendedFamily): string
    {
        $summary_message = '';
        $empty = [];
        
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName !== 'allCount' && $propName !== 'summaryMessageEmptyBlocks' && $extendedFamily->efp->$propName->allCount == 0) {
                $empty[] = $propName;
            }
        }
        if (count($empty) > 0) {
            if (count($empty) == 1) {
                $summary_list = $this->translateFamilyPart($empty[0]);
                $summary_message = I18N::translate('%s has no %s recorded.', $extendedFamily->self->niceName, $summary_list);
            }
            else {
                $summary_list_a = $this->translateFamilyPart($empty[0]);
                for ( $i = 1; $i <= count($empty)-2; $i++ ) {
                    $summary_list_a .= ', ' . $this->translateFamilyPart($empty[$i]);
                }
                $summary_list_b = $this->translateFamilyPart($empty[count($empty)-1]);
                $summary_message = I18N::translate('%s has no %s, and no %s recorded.', $extendedFamily->self->niceName, $summary_list_a, $summary_list_b);
            }
        }
        return $summary_message;      
    }

    /**
     * generate a label for a parental family group
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function getChildLabel(Individual $individual): string
    {
        if (preg_match('/\n1 FAMC @' . $individual->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $individual->gedcom(), $match)) {
            // a specified pedigree
            return GedcomCodePedi::getValue($match[1],$individual->getInstance($individual->xref(),$individual->tree()));
        }

        // default (birth) pedigree
        return GedcomCodePedi::getValue('',$individual->getInstance($individual->xref(),$individual->tree()));
    }

    /**
     * generate list of other preferences (control panel options beside the options related to the extended family parts itself)
     *
     * @return array of string
     */
    public function listOfOtherPreferences(): array
    {
        return [
            'show_short_name',
            'show_empty_block',
        ];
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function getAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->layout = 'layouts/administration';
        $response = [];
        
        $preferences = $this->listOfOtherPreferences();
        foreach ($preferences as $preference) {
           $response[$preference] = $this->getPreference($preference);
        }

        $response['efps'] = $this->showFamilyParts();
        
        $response['title'] = $this->title();
        $response['description'] = $this->description();
        $response['uses_sorting'] = true;

        return $this->viewResponse($this->name() . '::settings', $response);
    }

    /**
     * save the user preferences in the database
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function postAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array) $request->getParsedBody();

        if ($params['save'] === '1') {
            $preferences = $this->listOfOtherPreferences();
            foreach ($preferences as $preference) {
                $this->setPreference($preference, $params[$preference]);
			}
            
            $order = implode(",",$params['order']);
            $this->setPreference('order', $order);
            
            $efps = $this->listOfFamilyParts();
            foreach ($efps as $efp) {
                $this->setPreference('status-' . $efp, '0');
			}
            foreach ($params as $key => $value) {
                if (str_starts_with($key, 'status-')) {
                    $this->setPreference($key, $value);
                }
			}
            FlashMessages::addMessage(I18N::translate('The preferences for the module “%s” have been updated.', $this->title()), 'success');
        }

        return redirect($this->getConfigLink());
    }
    
    /**
     * parts of extended family which should be shown (order and enabled/disabled)
     * set default values in case the settings are not stored in the database yet
     *
     * @return array of objects 
     */
    public function showFamilyParts(): array
    {    
        $order_default = implode(",", $this->listOfFamilyParts());
        $order = explode(',', $this->getPreference('order', $order_default));
        
        $sp = [];
        foreach ($order as $efp) {
           $efpObj = (object)[];
           $efpObj->name = $this->translateFamilyPart($efp);
           $efpObj->enabled = $this->getPreference('status-' . $efp, 'on');
           $sp[$efp] = $efpObj;
        }
        return $sp;
    }
    
    /**
     * should a short name of proband be shown
     * set default values in case the settings are not stored in the database yet
     *
     * @return array 
     */
    public function showShortName(): bool
    {
        return !$this->getPreference('show_short_name', '0');
    }
    
    /**
     * how should empty parts of the extended family be presented
     * set default values in case the settings are not stored in the database yet
     *
     * @return array 
     */
    public function showEmptyBlock(): string
    {
        return $this->getPreference('show_empty_block', '0');
    }

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return /* I18N: Name of a module/tab on the individual page. */ I18N::translate(self::CUSTOM_TITLE);
    }

    /**
     * A sentence describing what this module does. Used in the list of all installed modules.
     *
     * @return string
     */
    public function description(): string
    {
        return /* I18N: Description of this module */ I18N::translate(self::CUSTOM_DESCRIPTION);
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return self::CUSTOM_AUTHOR;
    }

    /**
     * The version of this module.
     *
     * @return string
     */
    public function customModuleVersion(): string
    {
        return self::CUSTOM_VERSION;
    }

    /**
     * A URL that will provide the latest version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return self::CUSTOM_LAST;
    }

    /**
     * Where to get support for this module.  Perhaps a github respository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_WEBSITE;
    }
    
    /**
     * Where does this module store its resources
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }

    /**
     * The default position for this tab.  It can be changed in the control panel.
     *
     * @return int
     */
    public function defaultTabOrder(): int
    {
        return 10;
    }

    /**
     * Is this tab empty? If so, we don't always need to display it.
     *
     * @param Individual $individual
     *
     * @return bool
     */
    public function hasTabContent(Individual $individual): bool
    {
        return true;
    }

    /**
     * A greyed out tab has no actual content, but may perhaps have options to create content.
     *
     * @param Individual $individual
     *
     * @return bool
     */
    public function isGrayedOut(Individual $individual): bool
    {
        if ($this->getExtendedFamily( $individual )->efp->allCount == 0) {      
        // tbd: use another function which is more efficient (stops if the first memeber of extended family is found)
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @return ResponseInterface
     */
    function getCssAction() : ResponseInterface
    {
        return response(
            file_get_contents($this->resourcesFolder() . 'css/' . self::CUSTOM_MODULE . '.css'), 
            200,
            ['Content-type' => 'text/css']
        );
    }

    /** {@inheritdoc} */
    public function getTabContent(Individual $individual): string
    {
        return view($this->name() . '::tab', [
            'extfam_obj'            => $this->getExtendedFamily( $individual ),
            'extended_family_css'   => route('module', ['module' => $this->name(), 'action' => 'Css']),
            'module_obj'            => $this,
        ]); 
    }

    /** {@inheritdoc} */
    public function canLoadAjax(): bool
    {
        return false;
    }

    /**
     *  Constructor.
     */
    public function __construct()
    {
        // IMPORTANT - the constructor is called on *all* modules, even ones that are disabled.
        // It is also called before the webtrees framework is initialised, and so other components will not yet exist.
    }

    /**
     *  Boostrap.
     *
     * @param UserInterface $user A user (or visitor) object.
     * @param Tree|null     $tree Note that $tree can be null (if all trees are private).
     */
    public function boot(): void
    {
        // Here is also a good place to register any views (templates) used by the module.
        // This command allows the module to use: view($this->name() . '::', 'fish')
        // to access the file ./resources/views/fish.phtml
        View::registerNamespace($this->name(), __DIR__ . '/resources/views/');
    }
    
   /**
    * translate family part names
    *
    * @param string $type
    *
    * @return string
    */
    private function translateFamilyPart($type): string
    {
        switch ($type) {
            case 'uncles_and_aunts':
                return I18N::translate('Uncles and Aunts');
            case 'nephews_and_nieces':
                return I18N::translate('Nephews and Nieces');
            default:
                return I18N::translate(ucfirst($type));
        };
    }
    
    /**
     * Additional translations
     *
     * @param string $language
     *
     * @return string[]
     */
    public function customTranslations(string $language): array
    {
        // Here we are using an array for translations.
        // If you had .MO files, you could use them with:
        // return (new Translation('path/to/file.mo'))->asArray();
        switch ($language) {
            case 'cs':
                return $this->czechTranslations();
            case 'da':
                return $this->danishTranslations();             // tbd
            case 'de':
                return $this->germanTranslations();
            case 'fi':
                return $this->finnishTranslations();            // tbd
            case 'fr':
            case 'fr-CA':
                return $this->frenchTranslations();             // tbd
            case 'he':
                return $this->hebrewTranslations();             // tbd
            case 'lt':
                return $this->lithuanianTranslations();         // tbd
            case 'nb':
                return $this->norwegianBokmålTranslations();    // tbd
            case 'nl':
                return $this->dutchTranslations();
            case 'nn':
                return $this->norwegianNynorskTranslations();   // tbd
            case 'sk':
                return $this->slovakTranslations();     
            case 'sv':
                return $this->swedishTranslations();            // tbd
            case 'uk':
                return $this->ukrainianTranslations();
            case 'vi':
                return $this->vietnameseTranslations();
            default:
                return [];
        }
    }

    /**
     * @return array
     */
    protected function czechTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Širší rodina',
            'A tab showing the extended family of an individual.' => 'Panel širší rodiny dané osoby.',
            'Are these parts of the extended family to be shown?' => 'Mají se tyto části širší rodiny zobrazit?',
            'Show name of proband as short name or as full name?' => 'Má se jméno probanta zobrazit jako zkrácené jméno, nebo jako úplné jméno?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Za zkrácené probantovo jméno se vezme domácké jméno nebo přezdívka. Pokud neexistuje, vezme se první křestní jméno, je-li k dispozici. Pokud ani to ne, vezme se příjmení.',
            'Show short name' => 'Zobrazit zkrácené jméno',
            'How should empty parts of extended family be presented?' => 'Jak se mají zobrazit prázdné části (bloky) širší rodiny?',
            'Show empty block' => 'Zobrazit prázdné bloky',
            'yes, always at standard location' => 'ano, vždy na obvyklém místě',
            'no, but collect messages about empty blocks at the end' => 'ne, ale uvést prázdné bloky na konci výpisu',
            'never' => 'nikdy',
            
            'He' => 'On',
            'She' => 'Ona',
            'He/she' => 'On/ona',
            'Mr.' => 'Pan',
            'Mrs.' => 'Paní',
            'No family available' => 'Rodina chybí',
            'Parts of extended family without recorded information' => 'Chybějící části širší rodiny',
            '%s has no %s recorded.' => 'Pro osobu \'%s\' chybí záznamy %s.',
            '%s has no %s, and no %s recorded.' => 'Pro osobu \'%s\' chybí záznamy %s a %s.',
            'Father\'s family (%d)' => 'Otcova rodina (%d)',
            'Mother\'s family (%d)' => 'Matčina rodina (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Otcova a matčina rodina (%d)',

            'Grandparents' => 'Prarodiče',
            '%s has no grandparents recorded.' => '%s zde nemá žádné prarodiče.',
            '%s has one grandmother recorded.' => '%s má jednu bábu.',
            '%s has one grandfather recorded.' => '%s má jednoho děda.',
            '%s has one grandparent recorded.' => '%s má jednoho prarodiče.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' => '%2$s má %1$d bábu.' . I18N::PLURAL . '%2$s má %1$d báby.' . I18N::PLURAL . '%2$s má %1$d bab.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' 
                => '%2$s má %1$d děda.' . I18N::PLURAL . '%2$s má %1$d dědy.' . I18N::PLURAL . '%2$s má %1$d dědů.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s má %1$d děda a ' . I18N::PLURAL . '%2$s má %1$d dědy a ' . I18N::PLURAL . '%2$s má %1$d dědů a ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d bábu (celkem %d).' . I18N::PLURAL . '%d báby (celkem %d).' . I18N::PLURAL . '%d bab (celkem %d).',

            'Parents' => 'Rodiče',
            '%s has no parents recorded.' => '%s zde nemá žádné rodiče.',
            '%s has one mother recorded.' => '%s má jednu matku.',
            '%s has one father recorded.' => '%s má jednoho otce.',
            '%s has one grandparent recorded.' => '%s má jednoho rodiče.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s má %1$d matku.' . I18N::PLURAL . '%2$s má %1$d matky.' . I18N::PLURAL . '%2$s má %1$d matek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s má %1$d otce.' . I18N::PLURAL . '%2$s má %1$d otce.' . I18N::PLURAL . '%2$s má %1$d otců.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s má %1$d otce a ' . I18N::PLURAL . '%2$s má %1$d otce a ' . I18N::PLURAL . '%2$s má %1$d otců a ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d matku (celkem %d).' . I18N::PLURAL . '%d matky (celkem %d).' . I18N::PLURAL . '%d matek (celkem %d).',

            'Uncles and Aunts' => 'Strýcové a tety',
            '%s has no uncles or aunts recorded.' => '%s zde nemá žádné strýce ani tety.',
            '%s has one aunt recorded.' => '%s má jednu tetu.',
            '%s has one uncle recorded.' => '%s má jednoho strýce.',
            '%s has one uncle or aunt recorded.' => '%s jednoho strýce nebo jednu tetu.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.' => '%2$s má %1$d tetu.' . I18N::PLURAL . '%2$s má %1$d tety.' . I18N::PLURAL . '%2$s má %1$d tet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.' 
                => '%2$s má %1$d strýce.' . I18N::PLURAL . '%2$s má %1$d strýce.' . I18N::PLURAL . '%2$s má %1$d strýců.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s má %1$d strýce a ' . I18N::PLURAL . '%2$s má %1$d strýce a ' . I18N::PLURAL . '%2$s má %1$d strýců a ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d tetu (celkem %d).' . I18N::PLURAL . '%d tety (celkem %d).' . I18N::PLURAL . '%d tet (celkem %d).', 

            'Siblings' => 'Sourozenci',
            '%s has no siblings recorded.' => '%s zde nemá žádné sourozence.',
            '%s has one sister recorded.' => '%s má jednu sestru.',
            '%s has one brother recorded.' => '%s má jednoho bratra.',
            '%s has one brother or sister recorded.' => '%s má jednoho sourozence.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' => '%2$s má %1$d dceru.' . I18N::PLURAL . '%2$s má %1$d dcery.' . I18N::PLURAL . '%2$s má %1$d dcer.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.' 
                => '%2$s má %1$d bratra.' . I18N::PLURAL . '%2$s má %1$d bratry.' . I18N::PLURAL . '%2$s má %1$d bratrů.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s má %1$d bratra a ' . I18N::PLURAL . '%2$s má %1$d bratry a ' . I18N::PLURAL . '%2$s má %1$d bratrů a ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d sestru (celkem %d).' . I18N::PLURAL . '%d sestry (celkem %d).' . I18N::PLURAL . '%d sester (celkem %d).',
                                
            'Partners' => 'Partneři',
            '%s has no partners recorded.' => '%s zde nemá žádného partnera.',
            '%s has one female partner recorded.' => '%s má jednu partnerku.',
            '%s has one male partner recorded.' => '%s má jednoho partnera.',
            '%s has one partner recorded.' => '%s má jednoho partnera.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.' => '%2$s má %1$d partnerku.' . I18N::PLURAL . '%2$s má %1$d partnerky.' . I18N::PLURAL . '%2$s má %1$d partnerek.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.' 
                => '%2$s má %1$d partnera.' . I18N::PLURAL . '%2$s má %1$d partnery.' . I18N::PLURAL . '%2$s má %1$d partnerů.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s má %1$d partnera a ' . I18N::PLURAL . '%2$s má %1$d partnery a ' . I18N::PLURAL . '%2$s má %1$d partnerů a ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d partnerku (celkem %d).' . I18N::PLURAL . '%d partnerky (celkem %d).' . I18N::PLURAL . '%d partnerek (celkem %d).',

            'Cousins' => 'Bratranci a sestřenice',
            '%s has no first cousins recorded.' => '%s zde nemá žádné bratrance ani sestřenice.',
            '%s has one female first cousin recorded.' => '%s má jednu sestřenici.',
            '%s has one male first cousin recorded.' => '%s má jednoho bratrance.',
            '%s has one first cousin recorded.' => '%s má jednoho bratrance příp. jednu sestřenici.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.' => '%2$s má %1$d sestřenici.' . I18N::PLURAL . '%2$s má %1$d sestřenice.' . I18N::PLURAL . '%2$s má %1$d sestřenic.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.' 
                => '%2$s má %1$d bratrance.' . I18N::PLURAL . '%2$s má %1$d bratrance.' . I18N::PLURAL . '%2$s má %1$d bratranců.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s má %1$d bratrance a ' . I18N::PLURAL . '%2$s má %1$d bratrance a ' . I18N::PLURAL . '%2$s má %1$d bratranců a ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d sestřenici (celkem %d).' . I18N::PLURAL . '%d sestřenice (celkem %d).' . I18N::PLURAL . '%d sestřenic (celkem %d).',
                
            'Nephews and Nieces' => 'Synovci a neteře',
            '%s has no nephews or nieces recorded.' => '%s zde nemá žádné synovce ani neteře.',
            '%s has one niece recorded.' => '%s má jednu neteř.',
            '%s has one nephew recorded.' => '%s má jednoho synovce.',
            '%s has one nephew or niece recorded.' => '%s má jednoho synovce nebo jednu neteř.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.' => '%2$s má %1$d sestřenici.' . I18N::PLURAL . '%2$s má %1$d sestřenice.' . I18N::PLURAL . '%2$s má %1$d sestřenic.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.' 
                => '%2$s má %1$d synovce.' . I18N::PLURAL . '%2$s má %1$d synovce.' . I18N::PLURAL . '%2$s má %1$d synovců.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s má %1$d synovce a ' . I18N::PLURAL . '%2$s má %1$d synovce a ' . I18N::PLURAL . '%2$s má %1$d synovců a ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d neteř (celkem %d).' . I18N::PLURAL . '%d neteře (celkem %d).' . I18N::PLURAL . '%d neteří (celkem %d).',

            'Children' => 'Děti',
            '%s has no children recorded.' => '%s zde nemá žádné děti.',
            '%s has one daughter recorded.' => '%s má jednu dceru.',
            '%s has one son recorded.' => '%s má jednoho syna.',
            '%s has one child recorded.' => '%s má jedno dítě.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.' => '%2$s má %1$d dceru.' . I18N::PLURAL . '%2$s má %1$d dcery.' . I18N::PLURAL . '%2$s má %1$d dcer.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.' 
                => '%2$s má %1$d syna.' . I18N::PLURAL . '%2$s má %1$d syny.' . I18N::PLURAL . '%2$s má %1$d synů.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => '%2$s má %1$d syna a ' . I18N::PLURAL . '%2$s má %1$d syny a ' . I18N::PLURAL . '%2$s má %1$d synů a ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d dceru (celkem %d).' . I18N::PLURAL . '%d dcery (celkem %d).' . I18N::PLURAL . '%d dcer (celkem %d).',

            'Grandchildren' => 'Vnoučata',
            '%s has no grandchildren recorded.' => '%s zde nemá žádná vnoučata.',
            '%s has one granddaughter recorded.' => '%s má jednu vnučku.',
            '%s has one grandson recorded.' => '%s má jednoho vnuka.',
            '%s has one grandchild recorded.' => '%s má jedno vnouče.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.' => '%2$s má %1$d vnučku.' . I18N::PLURAL . '%2$s má %1$d vnučky.' . I18N::PLURAL . '%2$s má %1$d vnuček.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' 
                => '%2$s má %1$d vnuka.' . I18N::PLURAL . '%2$s má %1$d vnuky.' . I18N::PLURAL . '%2$s má %1$d vnuků.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s má %1$d vnuka a ' . I18N::PLURAL . '%2$s má %1$d vnuky a ' . I18N::PLURAL . '%2$s má %1$d vnuků a ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d vnučku (celkem %d).' . I18N::PLURAL . '%d vnučky (celkem %d).' . I18N::PLURAL . '%d vnuček (celkem %d).',            
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function danishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * @return array
     */
    protected function germanTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Großfamilie',
            'A tab showing the extended family of an individual.' => 'Reiter zeigt die Großfamilie einer Person.',
            'In which sequence should the parts of the extended family be shown?' => 'In welcher Reihenfolge sollen die Teile der erweiterten Familie angezeigt werden?',
            'Family part' => 'Familienteil',
            'Show name of proband as short name or as full name?' => 'Soll eine Kurzform oder der vollständige Name des Probanden angezeigt werden?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Der Kurzname basiert auf dem Rufnamen oder dem Spitznamen des Probanden. Falls diese nicht vorhanden sind, wird der erste der Vornamen verwendet, sofern ein solcher angegeben ist. Andernfalls wird der Nachname verwendet.',
            'Show short name' => 'Zeige die Kurzform des Namens',
			'How should empty parts of extended family be presented?' => 'Wie sollen leere Teile der erweiterten Familie angezeigt werden?',
			'Show empty block' => 'Zeige leere Familienteile',
			'yes, always at standard location' => 'ja, immer am normalen Platz',
			'no, but collect messages about empty blocks at the end' => 'nein, aber sammle Nachrichten über leere Familienteile am Ende',
			'never' => 'niemals',
			
            'He' => 'ihn', // Kontext "Für ihn"
            'She' => 'sie', // Kontext "Für sie"
            'He/she' => 'ihn/sie', // Kontext "Für ihn/sie"
            'Mr.' => 'Herrn', // Kontext "Für Herrn xxx"
            'Mrs.' => 'Frau', // Kontext "Für Frau xxx"
            'No family available' => 'Es wurde keine Familie gefunden.',
            'Parts of extended family without recorded information' => 'Teile der erweiterten Familie ohne Angaben',
            '%s has no %s recorded.' => 'Für %s sind keine %s verzeichnet.',
            '%s has no %s, and no %s recorded.' => 'Für %s sind keine %s und keine %s verzeichnet.',
            'Father\'s family (%d)' => 'Familie des Vaters (%d)',
            'Mother\'s family (%d)' => 'Familie der Mutter (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie des Vaters und der Mutter (%d)',

            'Grandparents' => 'Großeltern',
            '%s has no grandparents recorded.' => 'Für %s sind keine Großeltern verzeichnet.',
            '%s has one grandmother recorded.' => 'Für %s ist eine Großmutter verzeichnet.',
            '%s has one grandfather recorded.' => 'Für %s ist ein Großvater verzeichnet.',
            '%s has one grandparent recorded.' => 'Für %s ist ein Großelternteil verzeichnet.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => 'Für %2$s ist %1$d Großmutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Großmütter verzeichnet.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => 'Für %2$s ist %1$d Großvater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Großväter verzeichnet.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => 'Für %2$s sind %1$d Großvater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Großväter und ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d Großmutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Großmütter verzeichnet (insgesamt %d).',

            'Parents' => 'Eltern',
            '%s has no parents recorded.' => 'Für %s sind keine Eltern verzeichnet.',
            '%s has one mother recorded.' => 'Für %s ist eine Mutter verzeichnet.',
            '%s has one father recorded.' => 'Für %s ist ein Vater verzeichnet.',
            '%s has one parent recorded.' => 'Für %s ist ein Elternteil verzeichnet.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => 'Für %2$s ist %1$d Mutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Mütter verzeichnet.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => 'Für %2$s ist %1$d Vater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Väter verzeichnet.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => 'Für %2$s sind %1$d Vater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Väter und ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d Mutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Mütter verzeichnet (insgesamt %d).',

            'Uncles and Aunts' => 'Onkel und Tanten',
            '%s has no uncles or aunts recorded.' => 'Für %s sind keine Onkel oder Tanten verzeichnet.',
            '%s has one aunt recorded.' => 'Für %s ist eine Tante verzeichnet.',
            '%s has one uncle recorded.' => 'Für %s ist ein Onkel verzeichnet.',
            '%s has one uncle or aunt recorded.' => 'Für %s ist ein Onkel oder eine Tante verzeichnet.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => 'Für %2$s ist %1$d Tante verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Tanten verzeichnet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => 'Für %2$s ist %1$d Onkel verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel verzeichnet.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => 'Für %2$s sind %1$d Onkel und ' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel und ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d Tante verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Tanten verzeichnet (insgesamt %d).', 

            'Siblings' => 'Geschwister',
            '%s has no siblings recorded.' => 'Für %s sind keine Geschwister verzeichnet.',
            '%s has one sister recorded.' => 'Für %s ist eine Schwester verzeichnet.',
            '%s has one brother recorded.' => 'Für %s ist ein Bruder verzeichnet.',
            '%s has one brother or sister recorded.' => 'Für %s ist ein Bruder oder Schwester verzeichnet.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => 'Für %2$s ist %1$d Schwester verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwestern verzeichnet.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => 'Für %2$s ist %1$d Bruder verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Brüder verzeichnet.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => 'Für %2$s sind %1$d Bruder und ' . I18N::PLURAL . 'Für %2$s sind %1$d Brüder und ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d Schwester verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwestern verzeichnet (insgesamt %d).',
                                
            'Partners' => 'Partner',
            '%s has no partners recorded.' => 'Für %s sind keine Partner verzeichnet.',
            '%s has one female partner recorded.' => 'Für %s ist eine Partnerin verzeichnet.',
            '%s has one male partner recorded.' => 'Für %s ist ein Partner verzeichnet.',
            '%s has one partner recorded.' => 'Für %s ist ein Partner verzeichnet.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => 'Für %2$s ist %1$d Partnerin verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Partnerinnen verzeichnet.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => 'Für %2$s ist %1$d Partner verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Partner verzeichnet.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => 'Für %2$s sind %1$d Partner und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partner und ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d Partnerin verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen verzeichnet (insgesamt %d).',

            'Cousins' => 'Cousins und Cousinen',
            '%s has no first cousins recorded.' => 'Für %s sind keine Cousins und Cousinen ersten Grades verzeichnet.',
            '%s has one female first cousin recorded.' => 'Für %s ist eine Cousine ersten Grades verzeichnet.',
            '%s has one male first cousin recorded.' => 'Für %s ist ein Cousin ersten Grades verzeichnet.',
            '%s has one first cousin recorded.' => 'Für %s ist ein Cousin bzw. eine Cousine ersten Grades verzeichnet.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => 'Für %2$s ist %1$d Cousine ersten Grades verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Cousinen ersten Grades verzeichnet.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => 'Für %2$s ist %1$d Cousin ersten Grades verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins ersten Grades verzeichnet.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => 'Für %2$s sind %1$d Cousin ersten Grades und ' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins ersten Grades und ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d Cousine ersten Grades verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Cousinen ersten Grades verzeichnet (insgesamt %d).',
                
            'Nephews and Nieces' => 'Neffen und Nichten',
            '%s has no nephews or nieces recorded.' => 'Für %s sind keine Neffen oder Nichten verzeichnet.',
            '%s has one niece recorded.' => 'Für %s ist eine Nichte verzeichnet.',
            '%s has one nephew recorded.' => 'Für %s ist ein Neffe verzeichnet.',
            '%s has one nephew or niece recorded.' => 'Für %s ist ein Neffe oder eine Nichte verzeichnet.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => 'Für %2$s ist %1$d Nichte verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Nichten verzeichnet.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => 'Für %2$s ist %1$d Neffe verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen verzeichnet.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => 'Für %2$s sind %1$d Neffe und ' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen und ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d Nichte verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Nichten verzeichnet (insgesamt %d).',

            'Children' => 'Kinder',
            '%s has no children recorded.' => 'Für %s sind keine Kinder verzeichnet.',
            '%s has one daughter recorded.' => 'Für %s ist eine Tochter verzeichnet.',
            '%s has one son recorded.' => 'Für %s ist ein Sohn verzeichnet.',
            '%s has one child recorded.' => 'Für %s ist ein Kind verzeichnet.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => 'Für %2$s ist %1$d Tochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Töchter verzeichnet.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => 'Für %2$s ist %1$d Sohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Söhne verzeichnet.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => 'Für %2$s sind %1$d Sohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Söhne und ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d Tochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Töchter verzeichnet (insgesamt %d).',

            'Grandchildren' => 'Enkelkinder',
            '%s has no grandchildren recorded.' => 'Für %s sind keine Enkelkinder verzeichnet.',
            '%s has one granddaughter recorded.' => 'Für %s ist eine Enkeltochter verzeichnet.',
            '%s has one grandson recorded.' => 'Für %s ist ein Enkelsohn verzeichnet.',
            '%s has one grandchild recorded.' => 'Für %s ist ein Enkelkind verzeichnet.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => 'Für %2$s ist %1$d Enkeltochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Enkeltöchter verzeichnet.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => 'Für %2$s ist %1$d Enkelsohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Enkelsöhne verzeichnet.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => 'Für %2$s sind %1$d Enkelsohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Enkelsöhne und ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d Enkeltochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Enkeltöchter verzeichnet (insgesamt %d).',                
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function finnishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function frenchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function hebrewTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function lithuanianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function norwegianBokmålTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * @return array
     */
    protected function dutchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Uitgebreide familie',
            'A tab showing the extended family of an individual.' => 'Tab laat de uitgebreide familie van deze persoon zien.',
            'In which sequence should the parts of the extended family be shown?' => 'In welke volgorde moeten de delen van de uitgebreide familie worden weergegeven?',
            'Family part' => 'Familiedeel',
            'Show name of proband as short name or as full name?' => 'Naam van proband weergeven als korte naam of als volledige naam?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'De korte naam is gebaseerd op de roepnaam of bijnaam van de proband. Als deze niet beschikbaar zijn, wordt de eerste van de voornamen gebruikt, als er een is opgegeven. Anders wordt de achternaam gebruikt.',
            'Show short name' => 'Korte naam weergeven',
            'How should empty parts of extended family be presented?' => 'Hoe moeten lege delen van de uitgebreide familie worden weergegeven?',
            'Show empty block' => 'Leeg blok weergeven',
            'yes, always at standard location' => 'ja, altijd op de standaardlocatie',
            'no, but collect messages about empty blocks at the end' => 'nee, maar verzamel berichten over lege blokken aan het eind',
            'never' => 'nooit',
            
            'He' => 'hem',
            'She' => 'haar',
            'He/she' => 'hem/haar',
            'Mr.' => 'de heer',
            'Mrs.' => 'mevrouw',
            'No family available' => 'Geen familie gevonden',
            'Parts of extended family without recorded information' => 'Onderdelen van uitgebreide familie zonder geregistreerde informatie',
            '%s has no %s recorded.' => 'Voor %s zijn geen %s geregistreerd.',
            '%s has no %s, and no %s recorded.' => 'Voor %s zijn geen %s en geen %s geregistreerd.',
            'Father\'s family (%d)' => 'Familie van de vader (%d)',
            'Mother\'s family (%d)' => 'Familie van de moeder (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie van de vader en de moeder (%d)',
                
            'Grandparents' => 'Grootouders',
            '%s has no grandparents recorded.' => 'Voor %s zijn geen grootouders geregistreerd.', 
            '%s has one grandmother recorded.' => 'Voor %s is een grootmoeder geregistreerd.',
            '%s has one grandfather recorded.' => 'Voor %s is een grootvader geregistreerd.',
            '%s has one grandparent recorded.' => 'Voor %s is een grootouder geregistreerd.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => 'Voor %2$s is %1$d grootmoeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootmoeders geregistreerd.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => 'Voor %2$s is %1$d grootvader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootvaders geregistreerd.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => 'Voor %2$s zijn %1$d grootvader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootvaders en ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d grootmoeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d grootmoeders geregistreerd (%d in totaal).',
                
            'Parents' => 'Ouders',
            '%s has no parents recorded.' => 'Voor %s zijn geen ouders geregistreerd.',
            '%s has one mother recorded.' => 'Voor %s is een moeder geregistreerd.',
            '%s has one father recorded.' => 'Voor %s is een vader geregistreerd.',
            '%s has one parent recorded.' => 'Voor %s is een ouder geregistreerd.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => 'Voor %2$s is %1$d moeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders geregistreerd.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => 'Voor %2$s is %1$d vader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders geregistreerd.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => 'Voor %2$s zijn %1$d vader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders en ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d moeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d moeders geregistreerd (%d in totaal).',
                
            'Uncles and Aunts' => 'Ooms en tantes',
            '%s has no uncles or aunts recorded.' => 'Voor %s zijn geen ooms en tantes geregistreerd.',
            '%s has one aunt recorded.' => 'Voor %s is een tante geregistreerd.',
            '%s has one uncle recorded.' => 'Voor %s is een oom geregistreerd.',
            '%s has one uncle or aunt recorded.' => 'Voor %s is een oom of tante geregistreerd.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => 'Voor %2$s is %1$d tante geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d tantes geregistreerd.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => 'Voor %2$s is %1$d oom geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms geregistreerd.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => 'Voor %2$s zijn %1$d oom en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms en ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d tante geregistreerd (%d in totaal).' . I18N::PLURAL . '%d tantes geregistreerd (%d in totaal).',
                
            'Siblings' => 'Broers en zussen',
            '%s has no siblings recorded.' => 'Voor %s zijn geen broers of zussen geregistreerd.',
            '%s has one sister recorded.' => 'Voor %s is een zus geregistreerd.',
            '%s has one brother recorded.' => 'Voor %s is een broer geregistreerd.',
            '%s has one brother or sister recorded.' => 'Voor %s is een broer of zus geregistreerd.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => 'Voor %2$s is %1$d zus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zussen geregistreerd.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => 'Voor %2$s is %1$d broer geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers geregistreerd.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => 'Voor %2$s zijn %1$d broer en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers en ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d zus geregistreerd (%d in totaal).' . I18N::PLURAL . '%d zussen geregistreerd (%d in totaal).',
                                
            'Partners' => 'Partners',
            '%s has no partners recorded.' => 'Voor %s zijn geen partners geregistreerd.',
            '%s has one female partner recorded.' => 'Voor %s is een partner geregistreerd.',
            '%s has one male partner recorded.' => 'Voor %s is een partner geregistreerd.',
            '%s has one partner recorded.' => 'Voor %s is een partner geregistreerd.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => 'Voor %2$s is %1$d partner geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d partners geregistreerd.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => 'Voor %2$s is %1$d partner geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d partners geregistreerd.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => 'Voor %2$s zijn %1$d partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d partners en ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d partner geregistreerd (%d in totaal).' . I18N::PLURAL . '%d partners geregistreerd (%d in totaal).',
            
            'Cousins' => 'Volle neven en nichten (kinderen van oom of tante)',
            '%s has no first cousins recorded.' => 'Voor %s zijn geen volle neven en nichten geregistreerd.',
            '%s has one female first cousin recorded.' => 'Voor %s is een volle nicht geregistreerd.',
            '%s has one male first cousin recorded.' => 'Voor %s is een volle neef geregistreerd.',
            '%s has one first cousin recorded.' => 'Voor %s is een volle neef of nicht geregistreerd.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => 'Voor %2$s is %1$d volle nicht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle nichten geregistreerd.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => 'Voor %2$s is %1$d volle neef geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle neven geregistreerd.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => 'Voor %2$s zijn %1$d volle neef en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle neven en ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d volle nicht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d volle nichten geregistreerd (%d in totaal).',
                
            'Nephews and Nieces' => 'Neefjes en nichtjes (kinderen van broer of zus)',
            '%s has no nephews or nieces recorded.' => 'Voor %s zijn geen neefjes of nichtjes (kinderen van broer of zus) geregistreerd.',
            '%s has one niece recorded.' => 'Voor %s is een nichtje geregistreerd.',
            '%s has one nephew recorded.' => 'Voor %s is een neefje geregistreerd.',
            '%s has one nephew or niece recorded.' => 'Voor %s is een neefje of nichtje geregistreerd.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => 'Voor %2$s is %1$d nichtje geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d nichtjes geregistreerd.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => 'Voor %2$s is %1$d neefje geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d neefjes geregistreerd.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => 'Voor %2$s zijn %1$d neefje en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d neefjes en ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d nichtje geregistreerd (%d in totaal).' . I18N::PLURAL . '%d nichtjes geregistreerd (%d in totaal).', 
                
            'Children' => 'Kinderen',
            '%s has no children recorded.' => 'Voor %s zijn geen kinderen geregistreerd.',
            '%s has one daughter recorded.' => 'Voor %s is een dochter geregistreerd.',
            '%s has one son recorded.' => 'Voor %s is een zoon geregistreerd.',
            '%s has one child recorded.' => 'Voor %s is een kind geregistreerd.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => 'Voor %2$s is %1$d dochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d dochters geregistreerd.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => 'Voor %2$s is %1$d zoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zonen geregistreerd.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => 'Voor %2$s zijn %1$d zoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zonen en ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d dochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d dochters geregistreerd (%d in totaal).', 
                
            'Grandchildren' => 'Kleinkinderen',
            '%s has no grandchildren recorded.' => 'Voor %s zijn geen kleinkinderen geregistreerd.',
            '%s has one granddaughter recorded.' => 'Voor %s is een kleindochter geregistreerd.',
            '%s has one grandson recorded.' => 'Voor %s is een kleinzoon geregistreerd.',
            '%s has one grandchild recorded.' => 'Voor %s is een kleinkind geregistreerd.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => 'Voor %2$s is %1$d kleindochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleindochters geregistreerd.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => 'Voor %2$s is %1$d kleinzoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinzoons geregistreerd.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => 'Voor %2$s zijn %1$d kleinzoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinzoons en ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d kleindochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d kleindochters geregistreerd (%d in totaal).',
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    protected function norwegianNynorskTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     *
     * @return array
     */
    protected function slovakTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Širšia rodina',
            'A tab showing the extended family of an individual.' => 'Záložka širšej rodiny danej osoby.',
            'Are these parts of the extended family to be shown?' => 'Vyberte príslušníkov širšej rodiny, ktorí sa majú zobraziť.',
            'Show name of proband as short name or as full name?' => 'Má sa zobraziť skrátené, alebo plné meno probanda?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Skrátené meno je buď tzv. Rufname, alebo prezývka. Ak tieto neexistujú, tak sa použije prvé krstné meno. Ak ani toto neexistuje, tak sa použije priezvisko.',
            'Show short name' => 'Zobraziť skrátené meno',
            'How should empty parts of extended family be presented?' => 'Ako sa majú zobraziť prázdne bloky?',
            'Show empty block' => 'Zobraziť prázdne bloky',
            'yes, always at standard location' => 'áno, vždy na bežnom mieste',
            'no, but collect messages about empty blocks at the end' => 'nie, zobraz správy o prázdnych blokoch na konci',
            'never' => 'nikdy',
            
            'He' => 'On',
            'She' => 'Ona',
            'He/she' => 'On/ona',
            'Mr.' => 'Pán',
            'Mrs.' => 'Pani',
            'No family available' => 'Nenašla sa žiadna rodina',
            'Parts of extended family without recorded information' => 'Časti širšej rodiny bez zaznamenaných informácií',
            '%s has no %s recorded.' => '%s nemá zaznamenané %s.',
            '%s has no %s, and no %s recorded.' => '%s nemá zaznamenané %s ani %s.',
            'Father\'s family (%d)' => 'Otcova rodina (%d)',
            'Mother\'s family (%d)' => 'Matkina rodina (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Otcova a matkina rodina (%d)',

            'Grandparents' => 'Starí rodičia',
            '%s has no grandparents recorded.' => '%s nemá zaznamenaných žiadnych starých rodičov.',
            '%s has one grandmother recorded.' => '%s má zaznamenanú jednu starú mamu.',
            '%s has one grandfather recorded.' => '%s má zaznamenaného jedného starého otca.',
            '%s has one grandparent recorded.' => '%s má zaznamenaného jedného starého rodiča.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' => '%2$s má zaznamenanú %1$d starú mamu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d staré mamy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých mám.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' 
                => '%2$s má zaznamenaného %1$d starého otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s má zaznamenaného %1$d starého otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov a ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d starú mamu (spolu %d).' . I18N::PLURAL . '%d staré mamy (spolu %d).' . I18N::PLURAL . '%d starých mám (spolu %d).',

            '%s has no parents recorded.' => '%s nemá zaznamenaných žiadnych rodičov.',
            '%s has one mother recorded.' => '%s má zaznamenanú jednu matku.',
            '%s has one father recorded.' => '%s má zaznamenaného jedného otca.',
            '%s has one grandparent recorded.' => '%s má jedného rodiča.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s má zaznamenanú %1$d matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d matiek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s má zaznamenaného %1$d otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s má zaznamenaného %1$d otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov a ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d matku (spolu %d).' . I18N::PLURAL . '%d matky (spolu %d).' . I18N::PLURAL . '%d matiek (spolu %d).',

            'Uncles and Aunts' => 'Strýkovia a tety',
            '%s has no uncles or aunts recorded.' => '%s nemá zaznamenaného žiadneho strýka alebo tetu.',
            '%s has one aunt recorded.' => '%s má zaznamenanú jednu tetu.',
            '%s has one uncle recorded.' => '%s má zaznamenaného jedného strýka.',
            '%s has one uncle or aunt recorded.' => '%s jedného strýka alebo tetu.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.' => '%2$s má zaznamenanú %1$d tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tiet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.' 
                => '%2$s má zaznamenaného %1$d strýka.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s má zaznamenaného %1$d strýka a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov a ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d tetu (spolu %d).' . I18N::PLURAL . '%d tety (spolu %d).' . I18N::PLURAL . '%d tiet (spolu %d).', 

            '%s has no siblings recorded.' => '%s nemá zaznamenaných žiadnych súrodencov.',
            '%s has one sister recorded.' => '%s má zaznamenanú jednu sestru.',
            '%s has one brother recorded.' => '%s má zaznamenaného jedného brata.',
            '%s has one brother or sister recorded.' => '%s má jedného súrodenca.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' 
                => '%2$s má zaznamenanú %1$d dcéru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcéry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcér.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.' 
                => '%2$s má zaznamenaného %1$d brata.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s má zaznamenaného %1$d brata a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov a ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d sestru (spolu %d).' . I18N::PLURAL . '%d sestry (spolu %d).' . I18N::PLURAL . '%d sestier (spolu %d).',

            'Partners' => 'Partneri',
            '%s has no partners recorded.' => '%s nemá zaznamenaného žiadneho partnera.',
            '%s has one female partner recorded.' => '%s má zaznamenanú jednu partnerku.',
            '%s has one male partner recorded.' => '%s má zaznamenaného jedného partnera.',
            '%s has one partner recorded.' => '%s má zaznamenaného jedného partnera.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.' 
                => '%2$s má zaznamenanú %1$d partnerku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnerky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partneriek.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.' 
                => '%2$s má zaznamenaného %1$d partnera.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s má zaznamenaného %1$d partnera a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov a ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d partnerku (spolu %d).' . I18N::PLURAL . '%d partnerky (spolu %d).' . I18N::PLURAL . '%d partneriek (spolu %d).',

            'Cousins' => 'Bratranci a sesternice',
            '%s has no first cousins recorded.' => '%s nemá zaznamenaných žiadnych prvostupňových bratrancov alebo sesternice.',
            '%s has one female first cousin recorded.' => '%s má zaznamenanú jednu prvostupňovú sesternicu.',
            '%s has one male first cousin recorded.' => '%s má zaznamenaného jedného prvostupňového bratranca.',
            '%s has one first cousin recorded.' => '%s má jedného prvostupňového bratranca alebo sesternicu.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s má zaznamenanú %1$d prvostupňovú sesternicu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prvostupňové sesternice.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prvostupňových sesterníc.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.' 
                => '%2$s má zaznamenaného %1$d prvostupňového bratranca.' . I18N::PLURAL . '%2$s má zaznamenaného %1$d prvostupňových bratrancov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prvostupňových bratrancov.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s má zaznamenaného %1$d prvostupňového bratranca a ' . I18N::PLURAL . '%2$s má zaznamenaného %1$d prvostupňových bratrancov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prvostupňových bratrancov a ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d prvostupňovú sesternicu (spolu %d).' . I18N::PLURAL . '%d prvostupňové sesternice (spolu %d).' . I18N::PLURAL . '%d prvostupňových sesterníc (spolu %d).',

            'Nephews and Nieces' => 'Synovci a netere',
            '%s has no nephews or nieces recorded.' => '%s nemá zaznamenaných žiadnych synovcov alebo netere.',
            '%s has one niece recorded.' => '%s má zaznamenanú jednu neter.',
            '%s has one nephew recorded.' => '%s má zaznamenaného jedného synovca.',
            '%s has one nephew or niece recorded.' => '%s má jedného synovca alebo jednu neter.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s má zaznamenanú %1$d neter.' . I18N::PLURAL . '%2$s má zaznamenané %1$d netere.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d neterí.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.' 
                => '%2$s má zaznamenaného %1$d synovca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovcov.' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s má zaznamenaného %1$d synovca a ' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov a ' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov a ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d neter (spolu %d).' . I18N::PLURAL . '%d netere (spolu %d).' . I18N::PLURAL . '%d neterí (spolu %d).',

            '%s has no children recorded.' => '%s nemá zaznamenané žiadne deti.',
            '%s has one daughter recorded.' => '%s má zaznamenanú jednu dcéru.',
            '%s has one son recorded.' => '%s má zaznamenaného jedného syna.',
            '%s has one child recorded.' => '%s má jedno dieťa.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s má zaznamenanú %1$d dcéru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcéry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcér.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s má zaznamenaného %1$d syna.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s má zaznamenaného %1$d syna a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov a ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d dcéru (spolu %d).' . I18N::PLURAL . '%d dcéry (spolu %d).' . I18N::PLURAL . '%d dcár (spolu %d).',
 
            'Grandchildren' => 'Vnúčatá',
            '%s has no grandchildren recorded.' => '%s nemá zaznamenané žiadne vnúča.',
            '%s has one granddaughter recorded.' => '%s má zaznamenanú jednu vnučku.',
            '%s has one grandson recorded.' => '%s má zaznamenaného jedného vnuka.',
            '%s has one grandchild recorded.' => '%s má zaznamenané jedno vnúča.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s má zaznamenanú %1$d vnučku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnučky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnučiek.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' 
                => '%2$s má zaznamenaného %1$d vnuka.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s má zaznamenaného %1$d vnuka a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov a ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d vnučku (spolu %d).' . I18N::PLURAL . '%d vnučky (spolu %d).' . I18N::PLURAL . '%d vnučiek (spolu %d).',
        ];
    }
  
    /**
     * tbd
     *
     * @return array
     */
    protected function swedishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }
  
    /**
     * @return array
     */
    protected function ukrainianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Розширена сім`я',
            'A tab showing the extended family of an individual.' => 'Додає вкладку з розширеним виглядом родини для картки персони',
            'In which sequence should the parts of the extended family be shown?' => '*** In which sequence should the parts of the extended family be shown?',
            'Family part' => '*** Family part',
            'Show name of proband as short name or as full name?' => 'Показувати коротке чи повне ім`я об`єкту (пробанду)?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Коротке ім`я базується на прізвиську або псевдонімі об`єкту. Якщо вони не є доступними, використовується перше з наявних імен. В іншому випадку використовується прізвище.',
            'Show short name' => 'Показати коротку форму імені',
            'How should empty parts of extended family be presented?' => 'Як відображати порожні блоки розширеної сім`ї?',
            'Show empty block' => 'Показати пусті блоки',
            'yes, always at standard location' => 'так, завжди на звичайному місці',
            'no, but collect messages about empty blocks at the end' => 'ні, але збирати повідомлення про порожні блоки в кінці',
            'never' => 'ніколи',
            
            'He' => 'йому',
            'She' => 'їй',
            'He/she' => 'йому/їй',
            'Mr.' => 'Пан',
            'Mrs.' => 'Пані',
            'No family available' => 'Не знайдено жодної сім`ї.',
            'Parts of extended family without recorded information' => 'Частини розширеної сім`ї, що не містять записаної інформації',
            '%s has no %s recorded.' => 'Для %s не записано %s.',
            '%s has no %s, and no %s recorded.' => 'Для %s не записано %s і %s.',
            'Father\'s family (%d)' => 'Сім`я батька (%d)',
            'Mother\'s family (%d)' => 'Сім`я матері (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Сім`я батька і матері (%d)',

            'Grandparents' => 'Бабусі і дідусі',
            '%s has no grandparents recorded.' => '%s не має жодного запису про бабусю чи дідуся.',
            '%s has one grandmother recorded.' => '%s має запис про одну бабусю.',
            '%s has one grandfather recorded.' => '%s має запис про одного дідуся.',
            '%s has one grandparent recorded.' => '%s має запис про одного дідуся чи бабусю.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' 
                => '%2$s має %1$d запис бабусі.' . I18N::PLURAL . '%2$s має %1$d записи бабусь.' . I18N::PLURAL . '%2$s має %1$d записи бабусь.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' 
                => '%2$s має %1$d запис дідуся.' . I18N::PLURAL . '%2$s має %1$d записи дідусів.' . I18N::PLURAL . '%2$s має %1$d записи дідусів.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s має %1$d запис дідуся та ' . I18N::PLURAL . '%2$s має %1$d записи дідусів і ' . I18N::PLURAL . '%2$s має %1$d записи дідусів і ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d бабусю (загалом %d).' . I18N::PLURAL . '%d бабусі (загалом %d).' . I18N::PLURAL . '%d бабусі (загалом %d).',


            'Parents' => 'Батьки',
            '%s has no parents recorded.' => '%s не має записів батьків.',
            '%s has one mother recorded.' => '%s має тільки запис матері.',
            '%s has one father recorded.' => '%s має тільки запис батька.',
            '%s has one parent recorded.' => '%s має запис одного з батьків.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s має %1$d запис про мати.' . I18N::PLURAL . '%2$s має %1$d записи про матерів.' . I18N::PLURAL . '%2$s має %1$d записи про матерів.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s має %1$d запис про батька.' . I18N::PLURAL . '%2$s має %1$d записів про батьків.' . I18N::PLURAL . '%2$s має %1$d записів про батьків.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s має %1$d запис про батька та ' . I18N::PLURAL . '%2$s має %1$d записи про батьків і ' . I18N::PLURAL . '%2$s має %1$d записи про батьків і ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d мати (загалом %d).' . I18N::PLURAL . '%d матерів (загалом %d).' . I18N::PLURAL . '%d матерів (загалом %d).',

            'Uncles and Aunts' => 'Дядьки і тітки',
            '%s has no uncles or aunts recorded.' => '%s не має записів про дядьків і тіток.',
            '%s has one aunt recorded.' => '%s має запис про одну тітку.',
            '%s has one uncle recorded.' => '%s має запис про одного дядька.',
            '%s has one uncle or aunt recorded.' => '%s має запис про одного дядька чи тітку.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s має %1$d запис про дядька.' . I18N::PLURAL . '%2$s має %1$d записи про дядьків.' . I18N::PLURAL . '%2$s має %1$d записи про дядьків.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s має %1$d запис про тіток.' . I18N::PLURAL . '%2$s має %1$d записи про тіток.' . I18N::PLURAL . '%2$s має %1$d записи про тіток.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s має %1$d запис про дядька та ' . I18N::PLURAL . '%2$s має %1$d записи про дядьків і ' . I18N::PLURAL . '%2$s має %1$d записи про дядьків і ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d тітку (загалом %d).' . I18N::PLURAL . '%d тіток (загалом %d).' . I18N::PLURAL . '%d тіток (загалом %d).', 

            'Siblings' => 'Брати і сестри',
            '%s has no siblings recorded.' => '%s не має записів про братів і сестер.',
            '%s has one sister recorded.' => '%s має запис про одну сестру.',
            '%s has one brother recorded.' => '%s має запис про одного брата.',
            '%s has one brother or sister recorded.' => '%s має записи про одного брата чи сестру.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s має %1$d запис про сестру.' . I18N::PLURAL . '%2$s має %1$d записи про сестер.' . I18N::PLURAL . '%2$s має %1$d записи про сестер.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s має %1$d запис про брата.' . I18N::PLURAL . '%2$s має %1$d записи про братів.' . I18N::PLURAL . '%2$s має %1$d записи про братів.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s має %1$d запис про брата і ' . I18N::PLURAL . '%2$s має %1$d записи про братів і ' . I18N::PLURAL . '%2$s має %1$d записи про братів і ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d сестру (загалом %d).' . I18N::PLURAL . '%d сестер (загалом %d).' . I18N::PLURAL . '%d сестер (загалом %d).',
                                
            'Partners' => 'Партнери',
            '%s has no partners recorded.' => '%s не має записів про партнерів.',
            '%s has one female partner recorded.' => '%s має запис про одну партнерку.',
            '%s has one male partner recorded.' => '%s має запис про одного партнера.',
            '%s has one partner recorded.' => '%s має запис про одного партнера.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s має %1$d запис про партнерку.' . I18N::PLURAL . '%2$s має %1$d записи про партнерок.' . I18N::PLURAL . '%2$s має %1$d записи про партнерок.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s має %1$d запис про партнера.' . I18N::PLURAL . '%2$s має %1$d записи про партнерів.' . I18N::PLURAL . '%2$s має %1$d записи про партнерів.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s має %1$d запис про партнера і ' . I18N::PLURAL . '%2$s має %1$d запис про партнера і ' . I18N::PLURAL . '%2$s має %1$d запис про партнера і ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d партнерку (загалом %d).' . I18N::PLURAL . '%d партнерок (загалом %d).' . I18N::PLURAL . '%d партнерок (загалом %d).',

            'Cousins' => 'Двоюрідні брати і сестри',
            '%s has no first cousins recorded.' => '%s не має записів про двоюрідних братів і сестер.',
            '%s has one female first cousin recorded.' => '%s має запис про одну двоюрідну сестру.',
            '%s has one male first cousin recorded.' => '%s має запис про одного двоюрідного брата.',
            '%s has one first cousin recorded.' => '%s має запис про одного двоюрідного брата чи сестру.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s має %1$d запис про двоюрідну сестру.' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних сестер.' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних сестер.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s має %1$d запис про двоюрідного брата.' . I18N::PLURAL . '%2$s має %1$d записи про двюрідних братів.' . I18N::PLURAL . '%2$s має %1$d записи про двюрідних братів.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s має %1$d запис про двоюрідного брата і ' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних братів і ' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних братів і ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d двоюрідну сестру (загалом %d).' . I18N::PLURAL . '%d двоюрідних сестер (загалом %d).' . I18N::PLURAL . '%d двоюрідних сестер (загалом %d).',
                
            'Nephews and Nieces' => 'Племінники та племінниці',
            '%s has no nephews or nieces recorded.' => '%s не має записів про племінників чи племінниць.',
            '%s has one niece recorded.' => '%s має запис про одну племінницю.',
            '%s has one nephew recorded.' => '%s має запис про одного племінника.',
            '%s has one nephew or niece recorded.' => '%s має запис про одного племінника чи племінницю.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s має %1$d запис про племінницю.' . I18N::PLURAL . '%2$s має %1$d записи про племінниць.' . I18N::PLURAL . '%2$s має %1$d записи про племінниць.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s має %1$d запис про племінника.' . I18N::PLURAL . '%2$s має %1$d записи про племінників.' . I18N::PLURAL . '%2$s має %1$d записи про племінників.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s має %1$d запис про племінника та ' . I18N::PLURAL . '%2$s має %1$d записи про племінників і ' . I18N::PLURAL . '%2$s має %1$d записи про племінників і ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d племінницю (загалом %d).' . I18N::PLURAL . '%d племінниць (загалом %d).' . I18N::PLURAL . '%d племінниць (загалом %d).',

            'Children' => 'Діти',
            '%s has no children recorded.' => '%s не має записів про дітей.',
            '%s has one daughter recorded.' => '%s має запис про одного сина.',
            '%s has one son recorded.' => '%s має запис про одну дочку.',
            '%s has one child recorded.' => '%s запис про одну дитину.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s має %1$d запис про дочку.' . I18N::PLURAL . '%2$s має %1$d записи про дочок.' . I18N::PLURAL . '%2$s має %1$d записи про дочок.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s має %1$d запис про сина.' . I18N::PLURAL . '%2$s має %1$d записи про синів.' . I18N::PLURAL . '%2$s має %1$d записи про синів.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => '%2$s має %1$d запис про сина та ' . I18N::PLURAL . '%2$s має %1$d записи про синів і ' . I18N::PLURAL . '%2$s має %1$d записи про синів і ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d дочку (загалом %d).' . I18N::PLURAL . '%d дочок (загалом %d).' . I18N::PLURAL . '%d дочок (загалом %d).',

            'Grandchildren' => 'Онуки',
            '%s has no grandchildren recorded.' => '%s не має записів про онуків.',
            '%s has one granddaughter recorded.' => '%s має запис про одну онуку.',
            '%s has one grandson recorded.' => '%s має запис про одного внука.',
            '%s has one grandchild recorded.' => '%s має запис про одного внука чи онуку.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s має %1$d запис про онуку.' . I18N::PLURAL . '%2$s має %1$d записи про онук.' . I18N::PLURAL . '%2$s має %1$d записи про онук.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' 
                => '%2$s має %1$d запис про внука.' . I18N::PLURAL . '%2$s має %1$d записів про внуків.' . I18N::PLURAL . '%2$s має %1$d записів про внуків.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s має %1$d запис про внука та ' . I18N::PLURAL . '%2$s має %1$d записи про внуків і ' . I18N::PLURAL . '%2$s має %1$d записи про внуків і ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d онуку (загалом %d).' . I18N::PLURAL . '%d онуок (загалом %d).' . I18N::PLURAL . '%d онуок (загалом %d).',
        ];
    }
    
    /**
     * tbd
     *
     * @return array
     */
    protected function vietnameseTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Thông tin thêm về gia đình',
            'A tab showing the extended family of an individual.' => 'Một bảng hiển thị gia đình mở rộng của một cá nhân.',
            'In which sequence should the parts of the extended family be shown?' => '*** In which sequence should the parts of the extended family be shown?',
            'Family part' => '*** Family part',
            'Show name of proband as short name or as full name?' => 'Hiển thị tên dưới dạng tên ngắn hay tên đầy đủ?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Tên viết tắt dựa hoặc biệt danh. Nếu chúng không có sẵn, tên đầu tiên trong số các tên đã cho sẽ được sử dụng, nếu một tên được đưa ra. Nếu không, họ sẽ được sử dụng.',
            'Show short name' => 'Hiển thị tên rút gọn',
            'How should empty parts of extended family be presented?' => 'Các quan hệ không có thông tin của đại gia đình được trình bày như thế nào?',
            'Show empty block' => 'Các quan hệ không có thông tin',
            'yes, always at standard location' => 'Có, luôn ở vị trí tiêu chuẩn',
            'no, but collect messages about empty blocks at the end' => 'Không, nhưng thu thập thông báo về các khối trống ở cuối',
            'never' => 'Không hiển thị',

            'He' => 'Anh',
            'She' => 'Cô',
            'He/she' => 'Anh/Cô',
            'Mr.' => 'Ông',
            'Mrs.' => 'Bà',
            'No family available' => 'Không có thông tin về gia đình',
            'Parts of extended family without recorded information' => 'Các mối quan hệ khác trong gia đình không có thông tin được ghi lại',
            '%s has no %s recorded.' => '%s không có %s thông tin được ghi lại.',
            '%s has no %s, and no %s recorded.' => '%s không có %s và không có %s thông tin được ghi lại.',
            'Father\'s family (%d)' => 'Gia đình bên Bố (%d)',
            'Mother\'s family (%d)' => 'Gia đình bên Mẹ (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Gia đình của Bố và Mẹ (%d)',

            'Grandparents' => 'Ông bà',
            '%s has no grandparents recorded.' => '%s không có thông tin về ông bà.',
            '%s has one grandmother recorded.' => '%s có một người bà.',
            '%s has one grandfather recorded.' => '%s có một người ông.',
            '%s has one grandparent recorded.' => '%s có ông bà.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s có %1$d bà nội.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s có %1$d ông nội.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s có %1$d ông nội và ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d bà nội (tổng %d).',

            'Parents' => 'Bố mẹ',
            '%s has no parents recorded.' => '%s không có thông tin về bố mẹ.',
            '%s has one mother recorded.' => '%s có một người mẹ.',
            '%s has one father recorded.' => '%s có một người bố.',
            '%s has one grandparent recorded.' => '%s có một ông bà.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' 
                => '%2$s có %1$d mẹ.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s có %1$d bố.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s có %1$d bố và ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d mẹ (tổng %d).',

            'Uncles and Aunts' => 'Bác / cô và chú',
            '%s has no uncles or aunts recorded.' => '%s không có thiing tin về bác / cô chú.',
            '%s has one aunt recorded.' => '%s có một bác gái hoặc cô.',
            '%s has one uncle recorded.' => '%s có một bác trai hoặc chú.',
            '%s has one uncle or aunt recorded.' => '%s có một bác trai/bác gái hoặc cô/chú.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s có %1$d bác gái hoặc cô.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s có %1$d bác trai hoặc chú.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s có %1$d bác trai hoặc chú và ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d bác gái hoặc cô (tổng %d).', 

            'Siblings' => 'Anh chị em ruột',
            '%s has no siblings recorded.' => '%s không có thông tin về anh chị em ruột.',
            '%s has one sister recorded.' => '%s có một chị gái hoặc em gái.',
            '%s has one brother recorded.' => '%s có một anh trai hoặc em trai.',
            '%s has one brother or sister recorded.' => '%s có môt anh trai/em trai hoặc chị gái/em gái.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s có %1$d chị gái/em gái.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s có %1$d anh trai/em trai.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s có %1$d anh trai/em trai và ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d chị gái/em gái (tổng %d).',
                                
            'Partners' => 'Vợ/Chồng',
            '%s has no partners recorded.' => '%s không có thông tin về vợ/chồng.',
            '%s has one female partner recorded.' => 'Ông %s có một người vợ.',
            '%s has one male partner recorded.' => '%s có một người chồng.',
            '%s has one partner recorded.' => '%s có một vợ/chồng.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s có %1$d một người vợ.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s có %1$d một người chồng.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s có %1$d một người chồng và ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d một người vợ (tổng %d).',

            'Cousins' => 'Anh chị em họ',
            '%s has no first cousins recorded.' => '%s không có thông tin về anh em họ.',
            '%s has one female first cousin recorded.' => '%s có một chị em họ.',
            '%s has one male first cousin recorded.' => '%s có một anh em họ.',
            '%s has one first cousin recorded.' => '%s có một anh em họ.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s có %1$d chị họ/em gái họ.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s có %1$d anh/em họ.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s có %1$d anh/em họ và ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d chị/em gái họ (tổng %d).',
                
            'Nephews and Nieces' => 'Cháu (Là con của anh chị em ruột)',
            '%s has no nephews or nieces recorded.' => '%s không có thông tin về con của anh chị em ruột.',
            '%s has one niece recorded.' => '%s có một cháu gái.',
            '%s has one nephew recorded.' => '%s có một cháu trai.',
            '%s has one nephew or niece recorded.' => '%s có một cháu trai hoặc một cháu gái.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s có %1$d một cháu gái.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s có %1$d một cháu trai.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s có %1$d cháu trai và',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d cháu gái (tổng %d).',

            'Children' => 'Các con',
            '%s has no children recorded.' => '%s không có thông tin về con cái.',
            '%s has one daughter recorded.' => '%s có một con gái.',
            '%s has one son recorded.' => '%s có một con trai.',
            '%s has one child recorded.' => '%s có một người con được.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s có %1$d con gái.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s có %1$d con trai.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => '%2$s có %1$d con trai và ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d con gái (tổng %d).',

            'Grandchildren' => 'Cháu nội',
            '%s has no grandchildren recorded.' => '%s không có thông tin về cháu nội.',
            '%s has one granddaughter recorded.' => '%s có một cháu gái.',
            '%s has one grandson recorded.' => '%s có một cháu trai.',
            '%s has one grandchild recorded.' => '%s có một cháu.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s có %1$d cháu gái.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s có %1$d cháu trai.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s có %1$d cháu trai và ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d cháu gái (tổng %d).',
        ];
    }
}
return new ExtendedFamilyTabModule;
