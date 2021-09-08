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

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\GedcomCode\GedcomCodePedi;

/**
 * Class ExtendedFamily
 *
 * data and methods for extended family
 */
class ExtendedFamily
{
    /**
     * list of const for extended family
     */    
    public const FAM_STATUS_EX          = 'Ex-marriage';
    public const FAM_STATUS_MARRIAGE    = 'Marriage';
    public const FAM_STATUS_FIANCEE     = 'Fiancée';
    public const FAM_STATUS_PARTNERSHIP = 'Partnership';

    public const GROUP_GRANDPARENTS_FATHER_BIO   = 'Biological parents of father';
	public const GROUP_GRANDPARENTS_MOTHER_BIO   = 'Biological parents of mother';
    public const GROUP_GRANDPARENTS_U_BIO        = 'Biological parents of parent';
    public const GROUP_GRANDPARENTS_FATHER_STEP  = 'Stepparents of father';
    public const GROUP_GRANDPARENTS_MOTHER_STEP  = 'Stepparents of mother';
    public const GROUP_GRANDPARENTS_U_STEP       = 'Stepparents of parent';
	public const GROUP_GRANDPARENTS_STEP_PARENTS = 'Parents of stepparents';
	
    public const GROUP_UNCLEAUNT_FATHER  = 'Siblings of father';
    public const GROUP_UNCLEAUNT_MOTHER  = 'Siblings of mother';

    public const GROUP_UNCLEAUNTBM_FATHER = 'Siblings-in-law of father';
    public const GROUP_UNCLEAUNTBM_MOTHER = 'Siblings-in-law of mother';

    public const GROUP_PARENTS_BIO  = 'Biological parents';
    public const GROUP_PARENTS_STEP = 'Stepparents';
    
    // named groups ar not used for parents in law (instead the marriages are used for grouping)
    // public const GROUP_PARENTSINLAW_BIO  = 'Biological parents of partner'; 
    // public const GROUP_PARENTSINLAW_STEP = 'Stepparents of partner';
    
    public const GROUP_COPARENTSINLAW_BIO  = 'Parents-in-law of biological children';
    public const GROUP_COPARENTSINLAW_STEP = 'Parents-in-law of stepchildren';
    
    // no groups for partners and partner chains
    
    public const GROUP_SIBLINGS_FULL = 'Full siblings';
    public const GROUP_SIBLINGS_HALF = 'Half siblings';                                 // including more than half siblings (if parents are related to each other)
    public const GROUP_SIBLINGS_STEP = 'Stepsiblings';
    
    public const GROUP_SIBLINGSINLAW_SIBOFP = 'Siblings of partners';
    public const GROUP_SIBLINGSINLAW_POFSIB = 'Partners of siblings';

    public const GROUP_COSIBLINGSINLAW_SIBPARSIB = 'Siblings of siblings-in-law';       // sibling's partner's sibling
    public const GROUP_COSIBLINGSINLAW_PARSIBPAR = 'Partners of siblings-in-law';       // partner's sibling's partner';    
    
    public const GROUP_COUSINS_FULL_FATHER = 'Children of full siblings of father';
    public const GROUP_COUSINS_FULL_MOTHER = 'Children of full siblings of mother';
    public const GROUP_COUSINS_FULL_U      = 'Children of full siblings of parent';
    public const GROUP_COUSINS_HALF_FATHER = 'Children of half siblings of father';
    public const GROUP_COUSINS_HALF_MOTHER = 'Children of half siblings of mother';
    public const GROUP_COUSINS_HALF_U      = 'Children of half siblings of parent';
    
    public const GROUP_NEPHEW_NIECES_CHILD_SIBLING         = 'Children of siblings';
    public const GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING = 'Siblings\' stepchildren';
    public const GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER = 'Children of siblings of partners';

    public const GROUP_CHILDREN_BIO  = 'Biological children';
    public const GROUP_CHILDREN_STEP = 'Stepchildren';

    public const GROUP_CHILDRENINLAW_BIO  = 'Partners of biological children';
    public const GROUP_CHILDRENINLAW_STEP = 'Partners of stepchildren';
    
    public const GROUP_GRANDCHILDREN_BIO        = 'Biological grandchildren';
    public const GROUP_GRANDCHILDREN_STEP_CHILD = 'Stepchildren of children';
    public const GROUP_GRANDCHILDREN_CHILD_STEP = 'Children of stepchildren';
    public const GROUP_GRANDCHILDREN_STEP_STEP  = 'Stepchildren of stepchildren';
    
    // ------------ definition of data structure
    
    /**
     * $Config                                      object
     *        ->showEmptyBlock                      int [0,1,2]
     *        ->showShortName                       bool    
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
     *         ->label                              string      // or should it be better an array of string?
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
     * @param Individual $proband       the proband for whom the extended family members are searched
     * @param object $config            configuration parameters
     */
    public function __construct(Individual $proband, object $config)
    {
        $this->constructConfig($config);
        $this->constructProband($proband); 
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
     * construct object containing configuration information based on module parameters
     *
     * @param object $config    configuration parameters
     */
    private function constructConfig(object $config)
    {
        $this->Config = $config;
        return;
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
        $this->Proband->niceName  = $this->niceName( $proband );
        $this->Proband->label     = implode(", ", $this->getChildLabels( $proband ));       // tbd or should it be better an array of labels?
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
                $rn = $rufnameparts[count($rufnameparts)-1];                // it has to be the last given name (before *)
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
     *       => otherwise use "He" or "She" (or "He/she" if sex is not F and not M)
     *
     * @param Individual $individual
     *
     * @return string
     */
    private function niceName(Individual $individual): string
    {
        if ($this->Config->showShortName) {
            $nice = '';
            // an individual can have no name or many names (then we use only the first one)
            if (count($individual->facts(['NAME'])) > 0) {                                           // check if there is at least one name            
                $nice = $this->niceNameFromNameParts($individual);
            } else {
                $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
            }
        } else {
            $nice = $individual->fullname();
        }
        return $nice;
    }

    /**
     * Find a short, nice name for a person based on name facts
     * => use Rufname or nickname ("Sepp") or first of first names if one of these is available
     *    => otherwise use surname if available
     *
     * @param Individual $individual
     *
     * @return string
     */
    private function niceNameFromNameParts(Individual $individual): string
    {
        $nice = '';
        $rn = $this->rufname($individual);
        if ($rn !== '') {
            $nice = $rn;
        } else {
            $name_facts = $individual->facts(['NAME']);
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
                } else {
                    $surname = $givenAndSurnames[1];
                    if ($surname !== '') {
                        $nice = $this->nameSex($individual, I18N::translate('Mr.') . ' ' . $surname, I18N::translate('Mrs.') . ' ' . $surname, $surname);
                    } else {
                        $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
                    }
                }
            }
        }
        return $nice;
    }

    /**
     * generate a label for a child
     *
     * @param Individual $individual
     *
     * @return array of string
     */
    public function getChildLabels(Individual $individual): array
    {
        // default (birth) pedigree label
        $label = GedcomCodePedi::getValue('',$individual->getInstance($individual->xref(),$individual->tree()));
        if ( $individual->childFamilies()->first() ) {
            if (preg_match('/\n1 FAMC @' . $individual->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $individual->gedcom(), $match)) {
                // a specified pedigree
                $label = GedcomCodePedi::getValue($match[1],$individual->getInstance($individual->xref(),$individual->tree()));
            }
        }
        $mbLabel = $this->getMultipleBirthLabel($individual);
        return array_filter([$label, $mbLabel]);
    }

    /**
     * generate a label for twins and triplets etc
     * GEDCOM record is for example "1 ASSO @I123@\n2 RELA triplet" or "1 BIRT\n2 _ASSO @I123@\n3 RELA triplet"
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function getMultipleBirthLabel(Individual $individual): string
    {
        $multiple_birth = [
            2 => 'twin',
            3 => 'triplet',
            4 => 'quadruplet',
            5 => 'quintuplet',
            6 => 'sextuplet',
            7 => 'septuplet',
            8 => 'octuplet',
            9 => 'nonuplet',
            10 => 'decuplet',
        ];
        
        if ( preg_match('/\n1 ASSO @(.+)@\n2 RELA (.+)/', $individual->gedcom(), $match) ||
             preg_match('/\n2 _ASSO @(.+)@\n3 RELA (.+)/', $individual->gedcom(), $match) ) {
            if (in_array($match[2], $multiple_birth)) {
                return I18N::translate($match[2]);
            }
        }        

        return '';
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
            case 'uncles_and_aunts_bm':
                return I18N::translate('Uncles and Aunts by marriage');
            case 'partner_chains':
                return I18N::translate('Partner chains');
            case 'nephews_and_nieces':
                return I18N::translate('Nephews and Nieces');
            default:
                return I18N::translate(ucfirst(str_replace('_', '-', $type)));
        };
    }
}

?>
