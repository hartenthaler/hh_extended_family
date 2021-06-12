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
    
    public const CUSTOM_VERSION = '2.0.16.15';

    public const CUSTOM_LAST = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE. '/raw/main/latest-version.txt';
   
    /**
     * Find members of extended family
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getExtendedFamily(Individual $individual): object
    {      
		$extfamObj = (object)[];
        $extfamObj->showFamilyPart = $this->showFamilyPart();
		$extfamObj->allCount = 0;
		$extfamObj->Self = $this->getSelf( $individual );
		
		if ($extfamObj->showFamilyPart['grandparents']) {
			$extfamObj->Grandparents = $this->getGrandparents( $individual );
			$extfamObj->allCount += $extfamObj->Grandparents->allCount;
		}
        if ($extfamObj->showFamilyPart['grandchildren']) {
			$extfamObj->Grandchildren = $this->getGrandchildren( $individual );
			$extfamObj->allCount += $extfamObj->Grandchildren->allCount;
		}
        if ($extfamObj->showFamilyPart['uncles_and_aunts']) {
			$extfamObj->UnclesAunts = $this->getUnclesAunts( $individual );
			$extfamObj->allCount += $extfamObj->UnclesAunts->allCount;
		}
        if ($extfamObj->showFamilyPart['cousins']) {
			$extfamObj->Cousins = $this->getCousins( $individual );
			$extfamObj->allCount += $extfamObj->Cousins->allCount;
		}
        if ($extfamObj->showFamilyPart['nephews_and_nieces']) {
			$extfamObj->NephewsNieces = $this->getNephewsNieces( $individual );
			$extfamObj->allCount += $extfamObj->NephewsNieces->allCount;
		}
       return $extfamObj;
    }
    
    /**
     * self finding
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getSelf(Individual $individual): object
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
    private function getGrandparentsOneSide(object $extendedFamilyPart, string $side)
    {
        if ($side == 'mother') {
            $parent = $extendedFamilyPart->mother;
        } else {
            $parent = $extendedFamilyPart->father;
        }
        
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
    private function getGrandparents(Individual $individual): object
    {      
        $GrandparentsObj = $this->initializedFamilyPartObject('ancestors');
        
        if ($individual->childFamilies()->first()) {
            
            // husband() or wife() may not exist
            $GrandparentsObj->father = $individual->childFamilies()->first()->husband();
            $GrandparentsObj->mother = $individual->childFamilies()->first()->wife();

            $this->getGrandparentsOneSide( $GrandparentsObj, 'father');
            $this->getGrandparentsOneSide( $GrandparentsObj, 'mother');
             
            $this->addCountersToFamilyPartObject( $GrandparentsObj, 'ancestors' );
        }

        return $GrandparentsObj;
    }
    
    /**
     * Find grandchildren including step- and step-step-grandchildren
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getGrandchildren(Individual $individual): object
    {      
        $GrandchildrenObj = $this->initializedFamilyPartObject('descendants');
        
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
            
        $this->addCountersToFamilyPartObject( $GrandchildrenObj, 'descendants' );

        return $GrandchildrenObj;
    }
    
    /**
     * Find uncles and aunts for one side including uncles and aunts by marriage
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side ('father', 'mother'); father is default
     */
    private function getUnclesAuntsOneSide(object $extendedFamilyPart, string $side)
    {
        if ($side == 'mother') {
            $parent = $extendedFamilyPart->mother;
        } else {
            $parent = $extendedFamilyPart->father;
        }
        
        if ($parent instanceof Individual) {                                        // Gen 1 P
           foreach ($parent->childFamilies() as $family1) {                         // Gen 2 F
              foreach ($family1->spouses() as $grandparent) {                       // Gen 2 P
                 foreach ($grandparent->spouseFamilies() as $family2) {             // Gen 2 F
                    foreach ($family2->children() as $uncleaunt) {                  // Gen 1 P
                        if($uncleaunt !== $parent) {
                            //foreach ($uncleaunt->spouseFamilies() as $family3) {    // Gen 1 F    tbd: designed to include uncles/aunts by marriage; but how to group them with their partner in tab.html?
                                //foreach ($family3->spouses() as $uncleaunt2) {      // Gen 1 P
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
    private function getUnclesAunts(Individual $individual): object
    {
        $unclesAuntsObj = $this->initializedFamilyPartObject('ancestors');
        
        if ($individual->childFamilies()->first()) {
            
            $unclesAuntsObj->father = $individual->childFamilies()->first()->husband();
            $unclesAuntsObj->mother = $individual->childFamilies()->first()->wife();

            $this->getUnclesAuntsOneSide( $unclesAuntsObj, 'father');
            $this->getUnclesAuntsOneSide( $unclesAuntsObj, 'mother');
           
            $this->addCountersToFamilyPartObject( $unclesAuntsObj, 'ancestors' );
        }

        return $unclesAuntsObj;
    }

    /**
     * Find half and full cousins for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side ('father', 'mother'); father is default
     */
    private function getCousinsOneSide(object $extendedFamilyPart, string $side)
    {
        if ($side == 'mother') {
            $parent = $extendedFamilyPart->mother;
        } else {
            $parent = $extendedFamilyPart->father;
        }
        
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
    private function getCousins(Individual $individual): object
    {
        $cousinsObj = $this->initializedFamilyPartObject('ancestors');
        
        if ($individual->childFamilies()->first()) {
            
            $cousinsObj->father = $individual->childFamilies()->first()->husband();
            $cousinsObj->mother = $individual->childFamilies()->first()->wife();

            $this->getCousinsOneSide( $cousinsObj, 'father');
            $this->getCousinsOneSide( $cousinsObj, 'mother');
             
            $this->addCountersToFamilyPartObject( $cousinsObj, 'ancestors' );
        }

        return $cousinsObj;
    }
    
    /**
     * Find nephews and nieces
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getNephewsNieces(Individual $individual): object
    {      
        $NephewsNiecesObj = $this->initializedFamilyPartObject('descendants');
          
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
          
        $this->addCountersToFamilyPartObject( $NephewsNiecesObj, 'descendants' );

        return $NephewsNiecesObj;
    }
    
    /**
     * initialize part of extended family (object contains arrays of individuals or families and several counter values)
     *
     * @param string type of part of extended family ('ancestors', 'descendants')
     * @return initialized object
     */
    private function initializedFamilyPartObject(string $type): object
    {    
        $efpObj = (object)[];
        
        if ($type == 'ancestors') {
            $efpObj->fatherFamily = [];
            $efpObj->motherFamily = [];
            $efpObj->fatherAndMotherFamily = [];
        } elseif ($type == 'descendants') {
            $efpObj->families = [];
        }
        
        $efpObj->allCount = 0;
        
        return $efpObj;
    }
    
   /**
    * add an individual to the extended family (of type 'ancestors') if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
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
    * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
    * @param object family (on level of proband) to which these grandchildren are belonging
    */
    private function addIndividualToDescendantsFamily(Individual $individual, object $extendedFamilyPart, object $family)
    {
        $found = 0;
   
        foreach ($extendedFamilyPart->families as $family) {
            if ( in_array( $individual, $family->members ) ){
                $found = 1;
                break;
            }
        }
        
        if ($found == 0) {
            if ( !in_array( $family, $extendedFamilyPart->families ) ) {
                $extendedFamilyPart->families[] = $family;
                $extendedFamilyPart->families[0]->members = [];                 // tbd: richtige Familie
            }
            $extendedFamilyPart->families[0]->members[] = $individual;          // tbd: richtige Familie
        }
        
        return;
    }
    
    /**
     * count individuals per family (maybe including mother/father/motherAndFather families) and per sex
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string type of part of extended family ('ancestors', 'descendants')
     */
    private function addCountersToFamilyPartObject( object $extendedFamilyPart, string $type )
    {
        
        if ($type == 'ancestors') {
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
        } elseif ($type == 'descendants') {
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
     * @return string (is empty if there is no rufname)
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
     * => use nickname ("Sepp") or Rufname or first of first names if one of these is available
     *    => otherwise use surname if available ("Mr. xxx", "Mrs. xxx", or "xxx" if sex is not F or M
     *       => otherwise use "He" or "She" or "She/he" if sex is not F or M
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function niceName(Individual $individual): string
    {
        // an individual can have many names (we use only the first one) or no name
        $name_facts = $individual->facts(['NAME']);
        if (count($name_facts) > 0) {       // check if there is at least one name            
            $nickname = $name_facts[0]->attribute('NICK');
            if ($nickname !== '') {
                $nice = $nickname;
            } else {
                $rn = $this->rufname($individual);
                if ($rn !== '') {
                    $nice = $rn;
                } else {
                    $givensurnames = explode('/', $name_facts[0]->value());
                    if ($givensurnames[0] !== '') {     // are there given names?
                        $givennameparts = explode( ' ', $givensurnames[0]);
                        $nice = $givennameparts[0];     // this is the first given name
                    } else {
                        $surname = $givensurnames[1];
                        if ($surname !== '') {
                            $nice = $this->nameSex($individual, I18N::translate('Mr.') . ' ' . $surname, I18N::translate('Mrs.') . ' ' . $surname, $surname);
                        } else {
                            $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
                        }
                    }
                }
            }
        } else {
            $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
        }
        return $nice;
    }

    /**
     * A label for a parental family group
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function getChildLabel(Individual $individual): string
    {
        if (preg_match('/\n1 FAMC @' . $individual->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $individual->gedcom(), $match)) {
            // A specified pedigree
            return GedcomCodePedi::getValue($match[1],$individual->getInstance($individual->xref(),$individual->tree()));
        }

        // Default (birth) pedigree
        return GedcomCodePedi::getValue('',$individual->getInstance($individual->xref(),$individual->tree()));
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
        if ($this->getExtendedFamily( $individual )->allCount == 0) {      
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
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function getAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->layout = 'layouts/administration';

        return $this->viewResponse($this->name() . '::settings', [
            'grandparents'          => $this->getPreference('grandparents'),
            'grandchildren'         => $this->getPreference('grandchildren'),
			'uncles_and_aunts'      => $this->getPreference('uncles_and_aunts'),
            'cousins'               => $this->getPreference('cousins'),
            'nephews_and_nieces'    => $this->getPreference('nephews_and_nieces'),
            'title'                 => $this->title(),
        ]);
    }

    /**
     * Save the user preference.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function postAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array) $request->getParsedBody();

        // store the preferences in the database
        if ($params['save'] === '1') {
            $this->setPreference('grandparents', $params['grandparents']);
            $this->setPreference('grandchildren', $params['grandchildren']);
			$this->setPreference('uncles_and_aunts', $params['uncles_and_aunts']);
            $this->setPreference('cousins', $params['cousins']);
            $this->setPreference('nephews_and_nieces', $params['nephews_and_nieces']);

            FlashMessages::addMessage(I18N::translate('The preferences for the module “%s” have been updated.', $this->title()), 'success');
        }

        return redirect($this->getConfigLink());
    }

    /**
     * parts of extended family which should be shown
     *
     * @return array 
     */
    public function showFamilyPart(): array
    {    
        // Set default values in case the settings are not stored in the database yet
        // yes should be no and no should be yes, because I don't know how to set the default in settings.phtml radio buttons
		$sp = [
			'grandparents' 		    => !$this->getPreference('grandparents', '1'),
			'grandchildren' 	    => !$this->getPreference('grandchildren', '1'),
			'uncles_and_aunts'	    => !$this->getPreference('uncles_and_aunts', '1'),
			'cousins'			    => !$this->getPreference('cousins', '1'),
            'nephews_and_nieces'    => !$this->getPreference('nephews_and_nieces', '1'),
		];
        
        return $sp;
    }

    /**
     * Additional/updated translations.
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
            case 'da':
                return $this->danishTranslations();
            case 'de':
                return $this->germanTranslations();
            case 'fi':
                return $this->finnishTranslations();
            case 'fr':
            case 'fr-CA':
                return $this->frenchTranslations();
            case 'he':
                return $this->hebrewTranslations();
            case 'lt':
                return $this->lithuanianTranslations();
            case 'nb':
                return $this->norwegianBokmålTranslations();
            case 'nl':
                return $this->dutchTranslations();
            case 'nn':
                return $this->norwegianNynorskTranslations();
            case 'sv':
                return $this->swedishTranslations();               
            default:
                return [];
        }
    }

    /**
     * @return array
     */
    protected function danishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Fætre og kusiner',
            'A tab showing the extended family of an individual.' => 'En fane der viser en persons fætre og kusiner.',
            'No family available' => 'Ingen familie tilgængelig',
            'Father\'s family (%s)' => 'Fars familie (%s)',
            'Mother\'s family (%s)' => 'Mors familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registreret fæter eller kusin.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerede fæter eller kusiner.',
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
            'Are these parts of the extended family to be shown?' => 'Sollen diese Teile der erweiterten Familie angezeigt werden?',
            'He' => 'ihn', // Kontext "Für ihn"
            'She' => 'sie', // Kontext "Für sie"
            'He/she' => 'ihn/sie', // Kontext "Für ihn/sie"
            'Mr.' => 'Herrn', // Kontext "Für Herrn xxx"
            'Mrs.' => 'Frau', // Kontext "Für Frau xxx"
            'No family available' => 'Es wurde keine Familie gefunden.',
            'Father\'s family (%d)' => 'Familie des Vaters (%d)',
            'Mother\'s family (%d)' => 'Familie der Mutter (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie des Vaters und der Mutter (%d)',
            
            'Grandparents' => 'Großeltern',
            '%s has no grandparents recorded.' => 'Für %s sind keine Großeltern verzeichnet.',
            '%s has one grandmother recorded.' => 'Für %s ist eine Großmutter verzeichnet.',
            '%s has one grandfather recorded.' => 'Für %s ist ein Großvater verzeichnet.',
            '%s has one grandparent recorded.' => 'Für %s ist ein Großelternteil verzeichnet.',
            '%s has %d grandmothers recorded.' => 'Für %s sind %d Großmütter verzeichnet.',
            '%s has %d grandfathers recorded.' => 'Für %s sind %d Großväter verzeichnet.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => 'Für %2$s sind %1$d Großvater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Großväter und ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d Großmutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Großmütter verzeichnet (insgesamt %d).',
                
            'Grandchildren' => 'Enkelkinder',
            '%s has no grandchildren recorded.' => 'Für %s sind keine Enkelkinder verzeichnet.',
            '%s has one female grandchild recorded.' => 'Für %s ist ein weibliches Enkelkind verzeichnet.',
            '%s has one male grandchild recorded.' => 'Für %s ist ein männliches Enkelkind verzeichnet.',
            '%s has one grandchild recorded.' => 'Für %s ist ein Enkelkind verzeichnet.',
            '%s has %d female grandchildren recorded.' => 'Für %s sind %d weibliche Enkelkinder verzeichnet.',
            '%s has %d male grandchildren recorded.' => 'Für %s sind %d männliche Enkelkinder verzeichnet.',
            '%2$s has %1$d male grandchild and ' . I18N::PLURAL . '%2$s has %1$d male grandchildren and ' 
                => 'Für %2$s sind %1$d männliches Enkelkind und ' . I18N::PLURAL . 'Für %2$s sind %1$d männliche Enkelkinder und ',
            '%d female grandchild recorded (%d in total).' . I18N::PLURAL . '%d female grandchildren recorded (%d in total).' 
                => '%d weibliches Enkelkind verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d weibliche Enkelkinder verzeichnet (insgesamt %d).',
                
            'Uncles and Aunts' => 'Onkel und Tanten',
            '%s has no uncles or aunts recorded.' => 'Für %s sind keine Onkel oder Tanten verzeichnet.',
            '%s has one aunt recorded.' => 'Für %s ist eine Tante verzeichnet.',
            '%s has one uncle recorded.' => 'Für %s ist ein Onkel verzeichnet.',
            '%s has one uncle or aunt recorded.' => 'Für %s ist ein Onkel oder eine Tante verzeichnet.',
            '%s has %d aunts recorded.' => 'Für %s sind %d Tanten verzeichnet.',
            '%s has %d uncles recorded.' => 'Für %s sind %d Onkel verzeichnet.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => 'Für %2$s sind %1$d Onkel und ' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel und ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d Tante verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Tanten verzeichnet (insgesamt %d).', 

            'Cousins' => 'Cousins und Cousinen',
            '%s has no first cousins recorded.' => 'Für %s sind keine Cousins und Cousinen ersten Grades verzeichnet.',
            '%s has one female first cousin recorded.' => 'Für %s ist eine Cousine ersten Grades verzeichnet.',
            '%s has one male first cousin recorded.' => 'Für %s ist ein Cousin ersten Grades verzeichnet.',
            '%s has one first cousin recorded.' => 'Für %s ist ein Cousin bzw. eine Cousine ersten Grades verzeichnet.',
            '%s has %d female first cousins recorded.' => 'Für %s sind %d Cousinen ersten Grades verzeichnet.',
            '%s has %d male first cousins recorded.' => 'Für %s sind %d Cousins ersten Grades verzeichnet.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => 'Für %2$s sind %1$d Cousin ersten Grades und ' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins ersten Grades und ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d Cousine ersten Grades verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Cousinen ersten Grades verzeichnet (insgesamt %d).',
                
            'Nephews and Nieces' => 'Neffen und Nichten',
            '%s has no nephews or nieces recorded.' => 'Für %s sind keine Neffen oder Nichten verzeichnet.',
            '%s has one niece recorded.' => 'Für %s ist eine Nichte verzeichnet.',
            '%s has one nephew recorded.' => 'Für %s ist ein Neffe verzeichnet.',
            '%s has one nephew or niece recorded.' => 'Für %s ist ein Neffe oder eine Nichte verzeichnet.',
            '%s has %d nieces recorded.' => 'Für %s sind %d Nichten verzeichnet.',
            '%s has %d nephews recorded.' => 'Für %s sind %d Neffen verzeichnet.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => 'Für %2$s sind %1$d Neffe und ' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen und ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d Nichte verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Nichten verzeichnet (insgesamt %d).',                
        ];
    }

    /**
     * @return array
     */
    protected function finnishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Serkut',
            'A tab showing the extended family of an individual.' => 'Välilehti joka näyttää henkilön serkut.',
            'No family available' => 'Perhe puuttuu',
            'Father\'s family (%s)' => 'Isän perhe (%s)',
            'Mother\'s family (%s)' => 'Äidin perhe (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s:llä on %1$d serkku sivustolla.'  . 
                I18N::PLURAL . '%2$s:lla on %1$d serkkua sivustolla.',
        ];
    }

    /**
     * @return array
     */
    protected function frenchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Cousins',
            'A tab showing the extended family of an individual.' => 'Onglet montrant les cousins d\'un individu.',
            'No family available' => 'Pas de famille disponible',
            'Father\'s family (%s)' => 'Famille paternelle (%s)',
            'Mother\'s family (%s)' => 'Famille maternelle (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s a %1$d cousin germain connu.'  . 
                I18N::PLURAL . '%2$s a %1$d cousins germains connus.',
        ];
    }

    /**
     * @return array
     */
    protected function hebrewTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'בני דודים',
            'A tab showing the extended family of an individual.' => 'חוצץ המראה בני דוד של אדם.',
            'No family available' => 'משפחה חסרה',
            'Father\'s family (%s)' => 'משפחת האב (%s)',
            'Mother\'s family (%s)' => 'משפחת האם (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => 'ל%2$s יש בן דוד אחד מדרגה ראשונה.'  . 
                I18N::PLURAL . 'ל%2$s יש %1$d בני דודים מדרגה ראשונה.',
        ];
    }

    /**
     * @return array
     */
    protected function lithuanianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Pusbroliai/Pusseserės',
            'A tab showing the extended family of an individual.' => 'Lapas rodantis asmens pusbrolius ir pusseseres.',
            'No family available' => 'Šeima nerasta',
            'Father\'s family (%s)' => 'Tėvo šeima (%s)',
            'Mother\'s family (%s)' => 'Motinos šeima (%s)',
            '%2$s has %1$d first cousin recorded.' . 
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s turi %1$d įrašyta pirmos eilės pusbrolį/pusseserę.'  . 
                I18N::PLURAL . '%2$s turi %1$d įrašytus pirmos eilės pusbrolius/pusseseres.'  . 
                I18N::PLURAL . '%2$s turi %1$d įrašytų pirmos eilės pusbrolių/pusseserių.',
        ];
    }

    /**
     * @return array
     */
    protected function norwegianBokmålTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Søskenbarn',
            'A tab showing the extended family of an individual.' => 'Fane som viser en persons søskenbarn.',
            'No family available' => 'Ingen familie tilgjengelig',
            'Father\'s family (%s)' => 'Fars familie (%s)',
            'Mother\'s family (%s)' => 'Mors familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registrert søskenbarn.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerte søskenbarn.',
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
            'Are these parts of the extended family to be shown?' => 'Wilt u deze delen van de uitgebreide familie weergeven?',
            'He' => 'hem', // context "Für ihn/Voor ..."
            'She' => 'haar', // context "Für sie/Voor ..."
            'He/she' => 'hem/haar', // context "Für ihn/sie"
            'Mr.' => 'de heer', // context "Für Herrn xxx"
            'Mrs.' => 'mevrouw', // context "Für Frau xxx" `
            'No family available' => 'Geen familie gevonden',
            'Father\'s family (%d)' => 'Familie van de vader (%d)',
            'Mother\'s family (%d)' => 'Familie van de moeder (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie van de vader en de moeder (%d)',
            
            'Grandparents' => 'Grootouders',
            '%s has no grandparents recorded.' => 'Voor %s zijn geen grootouders geregistreerd.', 
            '%s has one grandmother recorded.' => 'Voor %s is een grootmoeder geregistreerd.',
            '%s has one grandfather recorded.' => 'Voor %s is een grootvader geregistreerd.',
            '%s has one grandparent recorded.' => 'Voor %s is een grootouder geregistreerd.',
            '%s has %d grandmothers recorded.' => 'Voor %s zijn %d grootmoeders geregistreerd.',
            '%s has %d grandfathers recorded.' => 'Voor %s zijn %d grootvaders geregistreerd.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => 'Voor %2$s zijn %1$d grootvader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootvaders en ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d grootmoeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d grootmoeders geregistreerd (%d in totaal).',
                
            'Grandchildren' => 'Kleinkinderen',
            '%s has no grandchildren recorded.' => 'Voor %s zijn geen kleinkinderen geregistreerd.',
            '%s has one female grandchild recorded.' => 'Voor %s is een kleindochter geregistreerd.',
            '%s has one male grandchild recorded.' => 'Voor %s is een kleinzoon geregistreerd.',
            '%s has one grandchild recorded.' => 'Voor %s is een kleinkind geregistreerd.',
            '%s has %d female grandchildren recorded.' => 'Voor %s zijn %d kleindochters geregistreerd.',
            '%s has %d male grandchildren recorded.' => 'Voor %s zijn %d kleinzoons geregistreerd.',
            '%2$s has %1$d male grandchild and ' . I18N::PLURAL . '%2$s has %1$d male grandchildren and ' 
                => 'Voor %2$s is %1$d kleinzoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinzoons en ',
            '%d female grandchild recorded (%d in total).' . I18N::PLURAL . '%d female grandchildren recorded (%d in total).' 
                => '%d kleindochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d kleindochters geregistreerd (%d in totaal).',
            
            'Uncles and Aunts' => 'Ooms en tantes',
            '%s has no uncles or aunts recorded.' => 'Voor %s zijn geen ooms en tantes geregistreerd.',
            '%s has one aunt recorded.' => 'Voor %s is een tante geregistreerd.',
            '%s has one uncle recorded.' => 'Voor %s is een oom geregistreerd.',
            '%s has one uncle or aunt recorded.' => 'Voor %s is een oom of tante geregistreerd.',
            '%s has %d aunts recorded.' => 'Voor %s zijn %d tantes geregistreerd.',
            '%s has %d uncles recorded.' => 'Voor %s zijn %d ooms geregistreerd.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => 'Voor %2$s zijn %1$d oom en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms en ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d tante geregistreerd (%d in totaal).' . I18N::PLURAL . '%d tantes geregistreerd (%d in totaal).',

            'Cousins' => 'Neven en nichten',
            '%s has no first cousins recorded.' => 'Voor %s zijn geen eerstegraads neven en nichten geregistreerd.',
            '%s has one female first cousin recorded.' => 'Voor %s is een eerstegraads nicht geregistreerd.',
            '%s has one male first cousin recorded.' => 'Voor %s is een eerstegraads neef geregistreerd.',
            '%s has one first cousin recorded.' => 'Voor %s is een eerstegraads neef of nicht geregistreerd.',
            '%s has %d female first cousins recorded.' => 'Voor %s zijn %d eerstegraads nichten geregistreerd.',
            '%s has %d male first cousins recorded.' => 'Voor %s zijn %d eerstegraads neven geregistreerd.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => 'Voor %2$s zijn %1$d eerstegraads neef en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d eerstegraads neven en ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d eerstegraads nicht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d eerstegraads nichten geregistreerd (%d in totaal).',
                
            'Nephews and Nieces' => 'Neven en nichten (kinderen van broer of zus)',
            '%s has no nephews or nieces recorded.' => 'Voor %s zijn geen neven of nichten geregistreerd.',
            '%s has one niece recorded.' => 'Voor %s is een nicht geregistreerd.',
            '%s has one nephew recorded.' => 'Voor %s is een neef geregistreerd.',
            '%s has one nephew or niece recorded.' => 'Voor %s is een neef of nicht geregistreerd.',
            '%s has %d nieces recorded.' => 'Voor %s zijn %d nichten geregistreerd.',
            '%s has %d nephews recorded.' => 'Voor %s zijn %d neven geregistreerd.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => 'Voor %2$s is %1$d neef en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d neven en ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nichten geregistreerd (%d in total).' 
                => '%d nicht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d nichten geregistreerd (%d in totaal).',          
        ];
    }

    /**
     * @return array
     */
    protected function norwegianNynorskTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Syskenbarn',
            'A tab showing the extended family of an individual.' => 'Fane som syner ein person sine syskenbarn.',
            'No family available' => 'Ingen familie tilgjengeleg',
            'Father\'s family (%s)' => 'Fars familie (%s)',
            'Mother\'s family (%s)' => 'Mors familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registrert syskenbarn.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerte syskenbarn.',
        ];
    }
  
    /**
     * @return array
     */
    protected function swedishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Kusiner',
            'A tab showing the extended family of an individual.' => 'En flik som visar en persons kusiner.',
            'No family available' => 'Familj saknas',
            'Father\'s family (%s)' => 'Faderns familj (%s)',
            'Mother\'s family (%s)' => 'Moderns familj (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registrerad kusin.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerade kusiner.',
        ];
    }

};

return new ExtendedFamilyTabModule;
