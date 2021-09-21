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
 * neue Subklasse für die Funktion personExistsInExtendedFamily(), damit die Funktion des ausgegrauten Tabs wieder funktioniert
 * neue Klassen für die einzelnen Zweige der erweiterten Familie mit den jeweiligen Hilfsfunktionen definieren
 *
 * siehe issues/enhancements in github
 *
 * Anzeige der genetischen Nähe der jeweiligen Personengruppe als Verwandtschaftskoeffizient (Coefficient of relationship) als Mouse-over?
 *      [
 *           'grandparents',         => 0.25,
 *           'uncles_and_aunts',     => 0.25,
 *           'uncles_and_aunts_bm',  => 0,
 *           'parents',              => 0.5,
 *           'parents_in_law',       => 0,
 *           'co_parents_in_law',    => 0,           
 *           'partners',             => 0,
 *           'partner_chains',       => 0,
 *           'siblings',             => 0.5,  // fullsiblings
 *           'siblings_in_law',      => 0,
 *           'co_siblings_in_law',   => 0,
 *           'cousins',              => 0.125,
 *           'nephews_and_nieces',   => 0.25,
 *           'children',             => 0.5,
 *           'children_in_law',      => 0,
 *           'grandchildren',        => 0.25,
 *       ]
 *
 * Familiengruppe Neffen und Nichten: 2-stufig: erst Geschwister als P bzw. Partner als P, dann Eltern wie gehabt;
 * Familiengruppe Cousins: wenn sie zur Vater und Mutter-Familie gehören, werden sie falsch zugeordnet (bei P Seudo: C2)
 * Familiengruppe Schwäger und Schwägerinnen: Ergänzen der vollbürtigen Geschwister um halbbürtige und Stiefgeschwister
 * Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von Partner gemischt sein sollte
 * Familiengruppe Partnerketten: grafische Anzeige statt Textketten
 * Familiengruppe Partnerketten: von Ge. geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette von Di. zu Ga., d.h. dies als zweite Info ergänzen
 * Familiengruppe Geschwister: eventuell statt Label eigene Kategorie für Adoptiv- und Pflegekinder bzw. Stillmutter
 *
 * Label für diverse Personen unter Nutzung der Funktion getRelationshipName(), basierend auf den Vesta-Modulen oder eigenen Funktionen:
 *          Schwäger: Partner der Geschwister
 *          Schwippschwäger: Rechts = Partner der Schwäger (Ehemann, Ex-, Partner)
 *          Schwiegerkinder: Partnerin/Ehefrau
 *          Biologische Eltern falls selbst adoptiert
 *          Partner: (Ehefrau, Ehemann, Partner)
 *          Angeheiratete Onkel und Tanten: generell (Ehefrau/Ehemann, Partner/Partnerin)
 * Label für Stiefkinder: etwa bei meinen Neffen Fabian, Felix, Jason und Sam
 * Label für Partner: neu einbauen (Ehemann/Ehefrau/Partner/Partnerin/Verlobter/Verlobte/Ex-...)
 * Label für Eltern: biologische Eltern, Stiefeltern, Adoptiveltern, Pflegeeltern
 * Label oder Gruppe bei Onkel/Tante: Halbonkel/-tante = Halbbruder/-schwester eines biologichen Elternteils
 *
 * Code: eventuell Verwendung der bestehenden Funktionen "_individuals" zum Aufbau von Familienteilen verwenden statt es jedes Mal vom Probanden aus komplett neu zu gestalten
 * Code: Ablaufreihenfolge in function addIndividualToFamily() umbauen wie function addIndividualToFamilyAsPartner()
 *
 * Test: wie verhält es sich, wenn eine Person als Kind zu zwei Familien gehört (bei P Seudo: C2)
 * Test: Stiefcousins (siehe Onkel Walter)
 * Test: Schwagerehe (etwa Levirat oder Sororat)
 *
 * andere Verwandtschaftssysteme: eventuell auch andere als nur das Eskimo-System implementieren
 * andere Verwandtschaftssysteme: Onkel als Vater- oder Mutterbruder ausweisen für Übersetzung (Label?); Tante als Vater- oder Mutterschwester ausweisen für Übersetzung (Label?);
 * andere Verwandtschaftssysteme: Brüder und Schwestern als jüngere oder ältere Geschwister ausweisen für Übersetzung (in Bezugg auf Proband) (Label?)
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\GedcomCode\GedcomCodePedi;

// string functions
use function str_replace;
use function strtolower;
use function str_contains;  // will be added in PHP 8.0
use function preg_match;
use function strval;
use function rtrim;

// array functions
// use function unset;
use function explode;
use function implode;
use function count;
use function array_key_exists;
use function in_array;
use function array_merge;
use function array_filter;

require_once(__DIR__ . '/src/Factory/ExtendedFamilyPartFactory.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyPart.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents.php');

/**
 * class ExtendedFamily
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
    
    // ------------ definition of data structures (they have to be public so that they can be accessed in tab.phtml)
    
    /**
     * $config                                      object
     *        ->showEmptyBlock                      int [0,1,2]
     *        ->showShortName                       bool    
     *        ->showLabels                          bool
     *        ->useCompactDesign                    bool
     *        ->showThumbnail                       bool
     *        ->showFilterOptions                   bool
     *        ->filterOptions                       array of string
     *        ->shownFamilyParts[]                  array of object
     *                            ->name            string
     *                            ->enabled         bool
     *        ->SizeThumbnailW                      int (in pixel)
     *        ->SizeThumbnailH                      int (in pixel)
     */
    public $config;
    
    /**
     * $proband                                     object
     *         ->indi                               Individual
     *         ->niceName                           string
     *         ->labels                             array of string
     */
    public $proband;
        
    /**
     * $filters                                                             array of object (index is string filterOption)
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
     *                                 ->otherSexCount                      int
     *                                 ->allCount                           int
     *                                 ->partName                           string
     *                 ->co_parents_in_law                                  see children
     *                 ->partners->groups[]->members[]                      array of object individual   (index of groups is XREF)
     *                                     ->partner                        object individual
     *                           ->pCount                                   int
     *                           ->pmaleCount                               int
     *                           ->pfemaleCount                             int
     *                           ->potherSexCount                           int
     *                           ->popCount                                 int
     *                           ->popmaleCount                             int
     *                           ->popfemaleCount                           int
     *                           ->popotherSexCount                         int
     *                           ->maleCount                                int    
     *                           ->femaleCount                              int
     *                           ->otherSexCount                            int
     *                           ->allCount                                 int
     *                           ->partName                                 string
     *                 ->partner_chains->chains[]                           array of object (tree of marriage chain nodes)
     *                                 ->displayChains[]                    array of chain (array of chainPerson objects)
     *                                 ->chainsCount                        int (number of chains)
     *                                 ->longestChainCount                  int
     *                                 ->mostDistantPartner                 Individual (first one if there are more than one)
     *                                 ->maleCount                          int    
     *                                 ->femaleCount                        int
     *                                 ->otherSexCount                      int
     *                                 ->allCount                           int
     *                                 ->partName                           string
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
     *                           ->otherSexCount                            int
     *                           ->allCount                                 int
     *                           ->partName                                 string
     *                 ->children_in_law                                    see children
     *                 ->grandchildren                                      see children
     */
    public $filters;
    
    // ------------ definition of methods

    /**
     * Extended Family constructor
     *
     * @param Individual $proband the proband for whom the extended family members are searched
     * @param object $config configuration parameters for this extended family
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
        return $this->config;
    }
    
    /**
     * get object containing information about the proband
     *
     * @return object
     */
    public function getProband(): object
    {
        return $this->proband;
    }
    
    /**
     * get list of extended family parts per filter combination
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * construct object containing configuration information based on module parameters
     *
     * @param object $config configuration parameters
     */
    private function constructConfig(object $config)
    {
        $this->config = $config;
    }
    
    /**
     * construct object containing information related to the proband
     *
     * @param Individual $proband
     */
    private function constructProband(Individual $proband)
    {
        $this->proband = (object)[];
        $this->proband->indi     = $proband;
        $this->proband->niceName = $this->findNiceName( $proband );
        $this->proband->labels   = $this->generateChildLabels( $proband );
    }

    /**
     * construct array of extended family parts for all combinations of filter options
     */
    private function constructFiltersExtendedFamilyParts()
    {
        $this->filters = [];
        foreach ($this->config->filterOptions as $filterOption) {
            $extfamObj = (object)[];
            $extfamObj->efp = (object)[];
            $extfamObj->efp->allCount = 0;
            
            foreach ($this->config->shownFamilyParts as $efp => $element) {
                if ( $element->enabled ) {
                    if ($efp == 'parents') {
                        $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption);
                        $extfamObj->efp->$efp = $efpO->getEfpObject();
                        //$extfamObj->efp->$efp = (object)[];
                        //$extfamObj->efp->$efp->allCount = 0;
                    } else {
                        $extfamObj->efp->$efp = $this->initializeFamilyPartObject($efp);
                        $this->callFunction('find_' . $efp, $extfamObj->efp->$efp);
                        $this->filterAndAddCountersToFamilyPartObject($extfamObj->efp->$efp, $filterOption);
                    }
                    $extfamObj->efp->allCount += $extfamObj->efp->$efp->allCount;
                }
            }
            $extfamObj->efp->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj);
            $this->filters[$filterOption] = $extfamObj;
        }
    }

    /**
     * check if there is at least one person in one of the selected extended family parts (used to decide if tab is grayed out)
     *
     * @return bool
      
    public function personExistsInExtendedFamily(): bool
    {
        $obj = (object)[];                                                      // tbd replace $obj by $ef 
        $extfamObj = (object)[];
        $extfamObj->efp = (object)[];
        $found = false;
        foreach ($this->config->shownFamilyParts as $efp => $element) {
            if ( $element->enabled ) {
                $extfamObj->efp->$efp = $this->initializeFamilyPartObject($efp);
                $this->callFunction( 'find_' . $efp, $extfamObj->efp->$efp );
                $this->filterAndAddCountersToFamilyPartObject( $extfamObj->efp->$efp, 'all' );
                if ($extfamObj->efp->$efp->allCount > 0) {
                    $found = true;
                    break;
                }
            }
        }
        // tbd release/unset all objects
        return $found;
    } */
    
    /**
     * call functions to find extended family parts
     *
     * @param string $name          name of function to be called
     * @param object $param         extended family part                // tbd remove this parameter when classes are defined for each extended family part
     */
    private function callFunction(string $name, object $param)
    {
        return $this->$name($param);
    }

    /**
     * call functions to get a branch of an extended family part
     *
     * @param string $name                  name of function to be called
     * @param Individual $individual        Individual
     * @param string $branch                e.g. ['bio', 'step', 'full', half']
     *
     * @return array of object
     */   
    private function callFunction2(string $name, Individual $individual, string $branch): array
    {
        return $this->$name($individual, $branch);
    }

    /**
     * list of parts of extended family
     *
     * @return array
     */
    public static function listOfFamilyParts(): array   // new elements can be added, but not changed or deleted
                                                        // names of elements have to be shorter than 25 characters
                                                        // this sequence is the default order of family parts
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
     * Find grandparents
     *
     * @param object $extendedFamilyPart
     */
    private function find_grandparents(object &$extendedFamilyPart)
    {      
        $config = (object)[];
        $config->branches = ['bio','step'];
        $config->callFamilyPart = 'parents';
        $config->const = [
            'bio'  => ['M' => self::GROUP_GRANDPARENTS_FATHER_BIO, 'F' => self::GROUP_GRANDPARENTS_MOTHER_BIO, 'U' => self::GROUP_GRANDPARENTS_U_BIO],
            'step' => ['M' => self::GROUP_GRANDPARENTS_FATHER_STEP, 'F' => self::GROUP_GRANDPARENTS_MOTHER_STEP, 'U' => self::GROUP_GRANDPARENTS_U_STEP],
        ];
        $this->findFamilyBranches($config, $extendedFamilyPart);

        // add biological parents and stepparents of stepparents
        foreach ($this->findStepparentsIndividuals($this->proband->indi) as $stepparentObj) {
            foreach ($this->findBioparentsIndividuals($stepparentObj->indi) as $grandparentObj) {
                $this->addIndividualToFamily( $extendedFamilyPart, $grandparentObj->indi, $grandparentObj->family, self::GROUP_GRANDPARENTS_STEP_PARENTS, $stepparentObj->indi );
            }
            foreach ($this->findStepparentsIndividuals($stepparentObj->indi) as $grandparentObj) {
                $this->addIndividualToFamily( $extendedFamilyPart, $grandparentObj->indi, $grandparentObj->family, self::GROUP_GRANDPARENTS_STEP_PARENTS, $stepparentObj->indi );
            }
		}
    }
    
    /**
     * Find uncles and aunts (not including uncles and aunts by marriage)
     *
     * @param object extended family part (modified by this function)
     */
    private function find_uncles_and_aunts(object &$extendedFamilyPart)
    {
        if ($this->proband->indi->childFamilies()->first()) {
            if ($this->proband->indi->childFamilies()->first()->husband() instanceof Individual) {
                $this->find_uncles_and_aunts_OneSide( $extendedFamilyPart, $this->proband->indi->childFamilies()->first()->husband(), self::GROUP_UNCLEAUNT_FATHER);
            }
            if ($this->proband->indi->childFamilies()->first()->wife() instanceof Individual) {
                $this->find_uncles_and_aunts_OneSide( $extendedFamilyPart, $this->proband->indi->childFamilies()->first()->wife(), self::GROUP_UNCLEAUNT_MOTHER);
            }
        }
    }
    
    /**
     * Find uncles and aunts for one side (husband/wife) (not including uncles and aunts by marriage)
     *
     * @param object $extendedFamilyPart    part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param Individual $parent
     * @param string $side  family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function find_uncles_and_aunts_OneSide(object &$extendedFamilyPart, Individual $parent, string $side)
    {
        foreach ($parent->childFamilies() as $family1) {                             // Gen 2 F
            foreach ($family1->spouses() as $grandparent) {                          // Gen 2 P
                foreach ($grandparent->spouseFamilies() as $family2) {               // Gen 2 F
                    foreach ($family2->children() as $uncleaunt) {                   // Gen 1 P
                        if($uncleaunt !== $parent) {
                            $this->addIndividualToFamily( $extendedFamilyPart, $uncleaunt, $family2, $side, $parent );
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Find uncles and aunts by marriage
     *
     * @param object extended family part (modified by this function)
     */
    private function find_uncles_and_aunts_bm(object $efp)
    {
        if ($this->proband->indi->childFamilies()->first()) {
            if ($this->proband->indi->childFamilies()->first()->husband() instanceof Individual) {
                $this->find_uncles_and_aunts_bmOneSide( $efp, $this->proband->indi->childFamilies()->first()->husband(), self::GROUP_UNCLEAUNTBM_FATHER);
            }
            if ($this->proband->indi->childFamilies()->first()->wife() instanceof Individual) {
                $this->find_uncles_and_aunts_bmOneSide( $efp, $this->proband->indi->childFamilies()->first()->wife(), self::GROUP_UNCLEAUNTBM_MOTHER);
            }
        }
    }
    
    /**
     * Find uncles and aunts by marriage for one side
     *
     * @param object part of extended family (modified by this function)
     * @param Individual parent
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function find_uncles_and_aunts_bmOneSide(object &$extendedFamilyPart, Individual $parent, string $side)
    {
        foreach ($parent->childFamilies() as $family1) {                                // Gen 2 F
            foreach ($family1->spouses() as $grandparent) {                             // Gen 2 P
                foreach ($grandparent->spouseFamilies() as $family2) {                  // Gen 2 F
                    foreach ($family2->children() as $uncleaunt) {                      // Gen 1 P
                        if($uncleaunt !== $parent) {
                            foreach ($uncleaunt->spouseFamilies() as $family3) {        // Gen 1 F    
                                foreach ($family3->spouses() as $uncleaunt2) {          // Gen 1 P
                                    if($uncleaunt2 !== $uncleaunt) {
                                        $this->addIndividualToFamily( $extendedFamilyPart, $uncleaunt2, $family3, $side, $uncleaunt );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Find parents-in-law (parents of partners including partners of partners)
     *
     * @param object extended family part (modified by function)
     */
    private function find_parents_in_law(object &$extendedFamilyPart)
    {
        foreach ($this->proband->indi->spouseFamilies() as $family) {                           // Gen  0 F
            foreach ($family->spouses() as $spouse) {                                           // Gen  0 P
                if ($spouse !== $this->proband->indi) {
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->husband() instanceof Individual)) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $spouse->childFamilies()->first()->husband(), $spouse->childFamilies()->first(), '', $spouse, $this->proband->indi );
                    }
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->wife() instanceof Individual)) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $spouse->childFamilies()->first()->wife(), $spouse->childFamilies()->first(), '', $spouse, $this->proband->indi );
                    }
                }
            }
        }
    }

    /**
     * Find co-parents-in-law (parents of children-in-law)
     *
     * @param object extended family part (modified by this fuction)
     */
    private function find_co_parents_in_law(object $extendedFamilyPart)
    {
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                foreach ($child->spouseFamilies() as $family2) {                                // Gen -1 F
                    foreach ($family2->spouses() as $child_in_law) {                            // Gen -1 P
                        if ($child_in_law !== $child) {
                            if ( ($child_in_law->childFamilies()->first()) && ($child_in_law->childFamilies()->first()->husband() instanceof Individual) ) {        // husband() or wife() may not exist
                                $this->addIndividualToFamily( $extendedFamilyPart, $child_in_law->childFamilies()->first()->husband(), $family2, self::GROUP_COPARENTSINLAW_BIO );
                            }
                            if ( ($child_in_law->childFamilies()->first()) && ($child_in_law->childFamilies()->first()->wife() instanceof Individual) ) {
                                $this->addIndividualToFamily( $extendedFamilyPart, $child_in_law->childFamilies()->first()->wife(), $family2, self::GROUP_COPARENTSINLAW_BIO );
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->spouses() as $stepchild_in_law) {                // Gen -1 P
                                if ($stepchild_in_law !== $stepchild) {
                                    if ( ($stepchild_in_law->childFamilies()->first()) && ($stepchild_in_law->childFamilies()->first()->husband() instanceof Individual)) {        // husband() or wife() may not exist
                                        $this->addIndividualToFamily( $extendedFamilyPart, $stepchild_in_law->childFamilies()->first()->husband(), $family3, self::GROUP_COPARENTSINLAW_STEP, $stepchild );
                                    }
                                    if ( ($stepchild_in_law->childFamilies()->first()) && ($stepchild_in_law->childFamilies()->first()->wife() instanceof Individual)) {
                                        $this->addIndividualToFamily( $extendedFamilyPart, $stepchild_in_law->childFamilies()->first()->wife(), $family3, self::GROUP_COPARENTSINLAW_STEP, $stepchild );
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
     * Find partners including partners of partners
     *
     * @param modified object extended family part
     */
    private function find_partners(object $efp)
    {
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                                         // Gen  0 P
                if ( $spouse1 !== $this->proband->indi ) {
                    $this->addIndividualToFamilyAsPartner( $spouse1, $efp, $this->proband->indi );
                }
                foreach ($spouse1->spouseFamilies() as $family2) {                                              // Gen  0 F
                    foreach ($family2->spouses() as $spouse2) {                                                 // Gen  0 P
                        if ( $spouse2 !== $spouse1 && $spouse2 !== $this->proband->indi ) {
                            $this->addIndividualToFamilyAsPartner( $spouse2, $efp, $spouse1 );
                        }
                    }
                }
            }
        }

    }

    /**
     * Find a chain of partners
     *
     * @param object $extendedFamilyPart extended family part (modified by this function)
     */
    private function find_partner_chains(object &$extendedFamilyPart)
    {
        $chainRootNode = (object)[];
        $chainRootNode->chains = [];
        $chainRootNode->indi = $this->proband->indi;
        $chainRootNode->filterComment = '';
        
        $stop = (object)[];                                 // avoid endless loops
        $stop->indiList = [];
        $stop->indiList[] = $this->proband->indi->xref();
        $stop->familyList = [];
        
        $extendedFamilyPart->chains = $this->findPartnerChainsRecursive ($chainRootNode, $stop);
    }
    
    /**
     * Find chains of partners recursive
     *
     * @param object $node
     * @param object stoplist with arrays of indi-xref and fam-xref
     *
     * @return array
     */
    private function findPartnerChainsRecursive(object $node, object &$stop): array
    {      
        $new_nodes = [];            // array of object ($node->indi; $node->chains)
        $i = 0;
        foreach ($node->indi->spouseFamilies() as $family) {
            if (!in_array($family->xref(), $stop->familyList)) {
                foreach ($family->spouses() as $spouse) {
                    if ( $spouse->xref() !== $node->indi->xref() ) {
                        if (!in_array($spouse->xref(), $stop->indiList)) {
                            $new_node = (object)[];
                            $new_node->chains = [];
                            $new_node->indi = $spouse;
                            $new_node->filterComment = '';
                            $stop->indiList[] = $spouse->xref();
                            $stop->familyList[] = $family->xref();
                            $new_node->chains = $this->findPartnerChainsRecursive($new_node, $stop);
                            $new_nodes[$i] = $new_node;
                            $i++;
                        } else {
                            break;
                        }
                    }
                }
            }
        }
        return $new_nodes;
    }

    /**
     * Find full and half siblings, as well as stepsiblings
     *
     * @param object extended family part (modified by this function)
     */
    private function find_siblings(object &$extendedFamilyPart)
    {
        foreach ($this->proband->indi->childFamilies() as $family) {                                     // Gen  1 F
            foreach ($family->children() as $sibling_full) {                                    // Gen  0 P
                if ($sibling_full !== $this->proband->indi) {
                    $this->addIndividualToFamily( $extendedFamilyPart, $sibling_full, $family, self::GROUP_SIBLINGS_FULL );
                }
            }
        }
        foreach ($this->proband->indi->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling_half) {                           // Gen  0 P
                        if ($sibling_half !== $this->proband->indi) {
                            $this->addIndividualToFamily( $extendedFamilyPart, $sibling_half, $family1, self::GROUP_SIBLINGS_HALF );
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->spouses() as $spouse2) {                                 // Gen  1 P
                        foreach ($spouse2->spouseFamilies() as $family3) {                      // Gen  1 F
                            foreach ($family3->children() as $sibling_step) {                   // Gen  0 P
                                if ($sibling_step !== $this->proband->indi) {
                                    $this->addIndividualToFamily( $extendedFamilyPart, $sibling_step, $family1, self::GROUP_SIBLINGS_STEP );
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    /**
     * Find siblings-in-law (partners of siblings and siblings of partners)
     *
     * @param object extended family part (modified by this function)
     */
    private function find_siblings_in_law(object &$extendedFamilyPart)
    {
        foreach ($this->proband->indi->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full !== $this->proband->indi) {
                    foreach ($sibling_full->spouseFamilies() as $family2) {                     // Gen  0 F
                        foreach ($family2->spouses() as $spouse) {                              // Gen  0 P
                            if ( $spouse !== $sibling_full ) {
                                $this->addIndividualToFamily( $extendedFamilyPart, $spouse, $family2, self::GROUP_SIBLINGSINLAW_POFSIB, $sibling_full );
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1 !== $this->proband->indi ) {
                    foreach ($spouse1->childFamilies() as $family2) {                           // Gen  1 F
                        foreach ($family2->children() as $sibling) {                            // Gen  0 P
                            if ($sibling !== $spouse1) {
                                $this->addIndividualToFamily( $extendedFamilyPart, $sibling, $family1, self::GROUP_SIBLINGSINLAW_SIBOFP, $spouse1 );
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Find co-siblings-in-law (partner's sibling's partner and sibling's partner's sibling)
     *
     * @param object extended family part (modified by this function)
     */
    private function find_co_siblings_in_law(object &$extendedFamilyPart)
    {
        foreach ($this->proband->indi->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full !== $this->proband->indi) {
                    foreach ($sibling_full->spouseFamilies() as $family2) {                     // Gen  0 F
                        foreach ($family2->spouses() as $spouse) {                              // Gen  0 P
                            if ( $spouse !== $sibling_full ) {
                                foreach ($spouse->childFamilies() as $family3) {                // Gen  1 F
                                    foreach ($family3->children() as $co_sibling_full) {        // Gen  0 P
                                        if ($co_sibling_full !== $spouse) {
                                            $this->addIndividualToFamily( $extendedFamilyPart, $co_sibling_full, $family3, self::GROUP_COSIBLINGSINLAW_SIBPARSIB, $spouse );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1 !== $this->proband->indi ) {
                    foreach ($spouse1->childFamilies() as $family2) {                           // Gen  1 F
                        foreach ($family2->children() as $sibling) {                            // Gen  0 P
                            if ($sibling !== $spouse1) {
                                foreach ($sibling->spouseFamilies() as $family3) {
                                    foreach ($family3->spouses() as $cosiblinginlaw) {
                                        if ($cosiblinginlaw !== $sibling) {
                                            $this->addIndividualToFamily( $extendedFamilyPart, $cosiblinginlaw, $family3, self::GROUP_COSIBLINGSINLAW_PARSIBPAR, $sibling );
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
    
    /**
     * Find full and half cousins (children of full and half siblings of father and mother)
     *
     * @param object extended family part (modified by function)
     */
    private function find_cousins(object $extendedFamilyPart)
    {
        $config = (object)[];
        $config->branches = ['full','half'];
        $config->callFamilyPart = 'cousins';
        $config->const = [
            'full' => ['M' => self::GROUP_COUSINS_FULL_FATHER, 'F' => self::GROUP_COUSINS_FULL_MOTHER, 'U' => self::GROUP_COUSINS_FULL_U],
            'half' => ['M' => self::GROUP_COUSINS_HALF_FATHER, 'F' => self::GROUP_COUSINS_HALF_MOTHER, 'U' => self::GROUP_COUSINS_HALF_U],
        ];
        $this->findFamilyBranches($config, $extendedFamilyPart);
    }
    
    /**
     * Find nephews and nieces
     *
     * @param object extended family part (modified by this function)
     */
    private function find_nephews_and_nieces(object &$extendedFamilyPart)
    {
        foreach ($this->proband->indi->childFamilies() as $family1) {                           // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ( $sibling !== $this->proband->indi) {
                            foreach ($sibling->spouseFamilies() as $family3) {                  // Gen  0 F
                                foreach ($family3->children() as $nephewniece) {                // Gen -1 P
                                    $this->addIndividualToFamily( $extendedFamilyPart, $nephewniece, $family1, self::GROUP_NEPHEW_NIECES_CHILD_SIBLING, $sibling );
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->childFamilies() as $family1) {                           // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ( $sibling !== $this->proband->indi ) {
                            foreach ($sibling->spouseFamilies() as $family3) {                  // Gen  0 F
                                foreach ($family3->spouses() as $parent) {                      // Gen  0 P
                                    foreach ($parent->spouseFamilies() as $family4) {           // Gen  0 F    
                                        foreach ($family4->children() as $nephewniece) {        // Gen -1 P
                                            $this->addIndividualToFamily( $extendedFamilyPart, $nephewniece, $family1, self::GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING, $sibling );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family0) {                                      // Gen  0 F
            foreach ($family0->spouses() as $spouse0) {                                                     // Gen  0 P
                if ( $spouse0 !== $this->proband->indi ) {
                    foreach ($spouse0->childFamilies() as $family1) {                                       // Gen  1 F
                        foreach ($family1->spouses() as $parent_in_law) {                                   // Gen  1 P
                            foreach ($parent_in_law->spouseFamilies() as $family2) {                        // Gen  1 F
                                foreach ($family2->children() as $sibling_in_law) {                         // Gen  0 P
                                    if ( $sibling_in_law !== $spouse0) {
                                        foreach ($sibling_in_law->spouseFamilies() as $family3) {           // Gen  0 F    
                                            foreach ($family3->children() as $nephewniece) {                // Gen -1 P
                                                $this->addIndividualToFamily( $extendedFamilyPart, $nephewniece, $family0, self::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER, $spouse0, $sibling_in_law );
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
    }

    /**
     * Find children including step-children
     *
     * @param object extended family part (modified by this function)
     */
    private function find_children(object &$extendedFamilyPart)
    {        
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                $this->addIndividualToFamily( $extendedFamilyPart, $child, $family1, self::GROUP_CHILDREN_BIO );
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        $this->addIndividualToFamily( $extendedFamilyPart, $child, $family2, self::GROUP_CHILDREN_STEP );
                    }
                }
            }
        }
    }

    /**
     * Find children-in-law (partner of children and stepchildren)
     *
     * @param object extended family part (modified by this function)
     */
    private function find_children_in_law(object &$extendedFamilyPart)
    {
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                foreach ($child->spouseFamilies() as $family2) {                                // Gen -1 F
                    foreach ($family2->spouses() as $child_in_law) {                            // Gen -1 P
                        if ($child_in_law !== $child) {
                            $this->addIndividualToFamily( $extendedFamilyPart, $child_in_law, $family1, self::GROUP_CHILDRENINLAW_BIO, $child );
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->spouses() as $stepchild_in_law) {                // Gen -1 P
                                if ($stepchild_in_law !== $stepchild) {
                                    $this->addIndividualToFamily( $extendedFamilyPart, $stepchild_in_law, $family1, self::GROUP_CHILDRENINLAW_STEP, $stepchild );
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
     * Find grandchildren including step- and step-step-grandchildren
     *
     * @param object extended family part (modified by this function)
     */
    private function find_grandchildren(object &$extendedFamilyPart)
    {      
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    foreach ($family2->children() as $biograndchild) {                          // Gen -2 P
                        $this->addIndividualToFamily( $extendedFamilyPart, $biograndchild, $family1, self::GROUP_GRANDCHILDREN_BIO );
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    foreach ($family2->spouses() as $spouse) {                                  // Gen -1 P
                        foreach ($spouse->spouseFamilies() as $family3) {                       // Gen -1 F    
                            foreach ($family3->children() as $step_child) {                     // Gen -2 P
                                $this->addIndividualToFamily( $extendedFamilyPart, $step_child, $family1, self::GROUP_GRANDCHILDREN_STEP_CHILD );
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->children() as $child_step) {                     // Gen -2 P
                                $this->addIndividualToFamily( $extendedFamilyPart, $child_step, $family1, self::GROUP_GRANDCHILDREN_CHILD_STEP );
                            }
                        }
                    }
                }
            }
        }
        foreach ($this->proband->indi->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        foreach ($child->spouseFamilies() as $family3) {                        // Gen -1 F
                            foreach ($family3->spouses() as $childstepchild) {                  // Gen -1 P
                                foreach ($childstepchild->spouseFamilies() as $family4) {       // Gen -1 F    
                                    foreach ($family4->children() as $step_step) {              // Gen -2 P
                                        $this->addIndividualToFamily( $extendedFamilyPart, $step_step, $family1, self::GROUP_GRANDCHILDREN_STEP_STEP );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    /**
     * initialize part of extended family (object contains arrays of individuals or families and several counter values)
     *
     * @param string $partName  name of part of extended family
     * @return object           initialized object
     */
    private function initializeFamilyPartObject(string $partName): object
    {    
        $efpObj = (object)[];
        $efpObj->partName = $partName;
        $efpObj->allCount = 0;
        $efpObj->groups = [];
        return $efpObj;
    }

    /**
     * Find individuals: biological parents (in first family)
     *
     * @param Individual $individual
     * @return array of object (individual, family)
     */
    private function findBioparentsIndividuals(Individual $individual): array
    {            
        $parents = [];
		if ($individual->childFamilies()->first()) {
            if ($individual->childFamilies()->first()->husband() instanceof Individual) {
				$obj = (object)[];
                $obj->indi = $individual->childFamilies()->first()->husband();
				$obj->family = $individual->childFamilies()->first();
				$parents[] = $obj;
            }
            if ($individual->childFamilies()->first()->wife() instanceof Individual) {
                $obj = (object)[];
                $obj->indi = $individual->childFamilies()->first()->wife();
				$obj->family = $individual->childFamilies()->first();
				$parents[] = $obj;
            }
        }
        return $parents;
    }
    
    /**
     * Find individuals: stepparents
     *
     * @param Individual
	 *
	 * @return array of object (individual, family)
     */
    private function findStepparentsIndividuals(Individual $individual): array
    {
        $stepparents = [];
        foreach ($this->findBioparentsIndividuals($individual) as $parentObj) {
            foreach ($this->findPartnersIndividuals($parentObj->indi) as $stepparentObj) {
                if ($stepparentObj->indi->xref() !== $parentObj->indi->xref()) {
                    $obj = (object)[];
					$obj->indi = $stepparentObj->indi;
					$obj->family = $stepparentObj->family;
					$stepparents[] = $obj;
                }
            }
        }
        return $stepparents;
    }

    /**
     * Find individuals: parents for one branch
     *
     * @param Individual $individual
     * @param string $branch ['bio', 'step']
	 *
	 * @return array of object (individual, family)
     */
    private function findParentsBranchIndividuals(Individual $individual, string $branch): array
    {
        if ( $branch == 'bio' ) {
            return $this->findBioparentsIndividuals($individual);
        } elseif ( $branch == 'step' ) {
            return $this->findStepparentsIndividuals($individual);
        }
    }
    
    /**
     * Find individuals: partners
     *
     * @param Individual $individual
	 *
	 * @return array of object (individual, family)
     */
    private function findPartnersIndividuals(Individual $individual): array
    {
        $partners = [];
		foreach ($individual->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse !== $individual) {
                    $obj = (object)[];
					$obj->indi = $spouse;
					$obj->family = $family;
					$partners[] = $obj;
                }
            }
        }
        return $partners;
    }
    
    /**
     * Find individuals: fullsiblings
     *
     * @param Individual
	 *
	 * @return array of object (individual, family)
     */
    private function findFullsiblingsIndividuals(Individual $individual): array
    {            
        $siblings = [];
		if ($individual->childFamilies()->first()) {
            foreach ($individual->childFamilies()->first()->children() as $sibling) {
                if ($sibling->xref() !== $individual->xref()) {
                    $obj = (object)[];
                    $obj->indi = $sibling;
                    $obj->family = $individual->childFamilies()->first();
                    $siblings[] = $obj;
                }
            }
        }
        return $siblings;
    }

    /**
     * Find individuals: halfsiblings
     *
     * @param Individual
	 *
	 * @return array of object (individual, family)
     */
    private function findHalfsiblingsIndividuals(Individual $individual): array
    {            
        $siblings = [];
		if ($individual->childFamilies()->first()) {
            foreach ($individual->childFamilies()->first()->spouses() as $parent) {
                foreach ($parent->spouseFamilies() as $family) {
                    if ($family->xref() !== $individual->childFamilies()->first()->xref()) {
                        foreach ($family->children() as $sibling) {
                            if ($sibling->xref() !== $individual->xref()) {
                                $obj = (object)[];
                                $obj->indi = $sibling;
                                $obj->family = $individual->childFamilies()->first();
                                $siblings[] = $obj;
                            }
                        }
                    }
                }
            }
        }
        return $siblings;
    }
    
    /**
     * Find individuals: full or half cousins based on father or mother (in first family)
     *
     * @param Individual $parent
     * @param string $branch ['full', 'half']
	 *
	 * @return array of object (individual, family)
     */
    private function findCousinsBranchIndividuals(Individual $parent, string $branch): array
    {            
        $cousins = [];
        foreach ((($branch == 'full')? $this->findFullsiblingsIndividuals($parent): $this->findHalfsiblingsIndividuals($parent)) as $siblingObj) {
            foreach ($this->findPartnersIndividuals($siblingObj->indi) as $UncleAuntObj) {
                foreach ($UncleAuntObj->family->children() as $cousin) {
                    $obj = (object)[];
                    $obj->indi = $cousin;
                    $obj->family = $UncleAuntObj->family;
                    $cousins[] = $obj;
                }
            }
        }
        return $cousins;
    }
    
    /**
     * Find cousins in both branches ['full','half'] or find grandparents in both branches ['bio','step']
     *
     * @param object $config configuration parameters
     * @param object extended family part (modified by this function)

     */
    private function findFamilyBranches(object $config, object &$extendedFamilyPart)
    {      
        foreach ($config->branches as $branch) {
            foreach ($this->findBioparentsIndividuals($this->proband->indi) as $parentObj) {
                if ($parentObj->indi->sex() == 'M') {
                    foreach ($this->callFunction2('find'.$config->callFamilyPart.'BranchIndividuals', $parentObj->indi, $branch) as $obj) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $obj->indi, $obj->family, $config->const[$branch]['M'], $this->proband->indi );
                    }
                } elseif ($parentObj->indi->sex() == 'F') {
                    foreach ($this->callFunction2('find'.$config->callFamilyPart.'BranchIndividuals', $parentObj->indi, $branch) as $obj) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $obj->indi, $obj->family, $config->const[$branch]['F'], $this->proband->indi );
                    }
                } else {
                    foreach ($this->callFunction2('find'.$config->callFamilyPart.'BranchIndividuals', $parentObj->indi, $branch) as $obj) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $obj->indi,  $obj->family, $config->const[$branch]['U'], $this->proband->indi );
                    }
                }
            }
        }
    }
    
   /**
    * add an individual to the extended family if it is not already member of this extended family
    *
    * @param object part of extended family (modified by this function)
    * @param Individual $individual
    * @param object $family family to which this individual is belonging
    * @param (optional) string $groupName
    * @param (optional) Individual $referencePerson
    * @param (optional) Individual $referencePerson2
    */
    private function addIndividualToFamily(object &$extendedFamilyPart, Individual $individual, object $family, string $groupName = '', Individual $referencePerson = null, Individual $referencePerson2 = null )
    {
        $nolabelGroups = [                                  // family parts which are not using "groups" and "labels"
            'parents_in_law',
            'partners',
            'partner_chains'
        ];
        
        $found = false;
        /*
        if ($groupName == '') {
            error_log('Soll ' . $individual->fullName() . ' (' . $individual->xref() . ') der Familie ' . $family->fullName() . ' (' . $family->xref() . ') hinzugefuegt werden? ');
        } else {
            error_log('Soll ' . $individual->fullName() . ' (' . $individual->xref() . ') der Gruppe "' . $groupName . '" hinzugefuegt werden? ');
        }
        */
        foreach ($extendedFamilyPart->groups as $i => $groupObj) {                      // check if individual is already a member of this part of the extended family   
            //echo 'Teste groups Nr. ' . $i . ': ';
            foreach ($groupObj->members as $member) {
                //echo 'Teste member = ' . $member->xref() . ': ';
                if ($member->xref() == $individual->xref()) {
                    $found = true;
                    //echo 'Person ' . $individual->fullName() . ' ist bereits in group-Objekt für Familie ' . $groupObj->family->fullName() . ' vorhanden. ';
                    break;
                }
            }
        }
        
        if (!$found) {                                                                  // individual has to be added 
            //echo "add person: ".$individual->fullName().". <br>";
            if ( $groupName == '' ) {
                foreach ($extendedFamilyPart->groups as $famkey => $groupObj) {         // check if this family is already stored in this part of the extended family
                    if ($groupObj->family->xref() == $family->xref()) {                 // family exists already    
                        //echo 'famkey in bereits vorhandener Familie: ' . $famkey . ' (Person ' . $individual->fullName() .
                        //     ' in Objekt für Familie ' . $extendedFamilyPart->groups[$famkey]->family->fullName() . '); ';
                        $extendedFamilyPart->groups[$famkey]->members[] = $individual;
                        if ( !in_array($extendedFamilyPart->partName, $nolabelGroups) ) {
                            $this->addIndividualToGroup($extendedFamilyPart, $individual, $family, $groupName, $referencePerson, $referencePerson2);
                        }
                        $found = true;
                        break;
                    }
                }
            } elseif ( array_key_exists($groupName, $extendedFamilyPart->groups) ) {
                //echo 'In bereits vorhandener Gruppe "' . $groupName . '" Person ' . $individual->xref() . ' hinzugefügt. ';
                if ( !in_array($extendedFamilyPart->partName, $nolabelGroups) ) {
                    $this->addIndividualToGroup($extendedFamilyPart, $individual, $family, $groupName, $referencePerson, $referencePerson2);
                }
                $found = true;
            }
            if (!$found) {                                                              // individual not found and family not found
                $labels = [];
                $newObj = (object)[];
                $newObj->family = $family;
                $newObj->members[] = $individual;
                if ( !in_array($extendedFamilyPart->partName, $nolabelGroups) ) {
                    /*
                    if ($referencePerson) {                                             // tbd: Logik verkehrt !!! Richtige Personen auswählen (siehe Kommentar ganz oben)!
                        $this->getRelationshipName($referencePerson);
                    }
                    */
                    $labels = array_merge($labels, $this->generateChildLabels($individual));
                    $newObj->labels[] = $labels;
                    $newObj->families[] = $family;
                    $newObj->familiesStatus[] = $this->findFamilyStatus($family);
                    $newObj->referencePersons[] = $referencePerson;
                    $newObj->referencePersons2[] = $referencePerson2;
                }
                if ( $extendedFamilyPart->partName == 'grandparents' || $extendedFamilyPart->partName == 'parents' || $extendedFamilyPart->partName == 'parents_in_law' ) {
                    $newObj->familyStatus = $this->findFamilyStatus($family);
                    if ($referencePerson) {
                        $newObj->partner = $referencePerson;
                        if ($referencePerson2) {
                            foreach ($referencePerson2->spouseFamilies() as $fam) {
                                //echo "Teste Familie ".$fam->fullName().":";
                                foreach ($fam->spouses() as $partner) {
                                    if ( $partner->xref() == $referencePerson->xref() ) {
                                        //echo $referencePerson->fullName();
                                        $newObj->partnerFamilyStatus = $this->findFamilyStatus($fam);
                                    }
                                }
                            }
                        } else {
                            $newObj->partnerFamilyStatus = 'Partnership';
                        }
                    }
                }
                if ($groupName == '') {
                    $extendedFamilyPart->groups[] = $newObj;
                    /*
                    echo 'Neu hinzugefügte Familie Nr. ' . 
                        //count($extendedFamilyPart->groups)-1 .
                        ' (Person ' . 
                        $individual->fullName() . 
                        ' in Objekt für Familie ' .
                        //$extendedFamilyPart->groups[$count]->family->xref() .
                        '); ';
                    */
                } else {
                    $newObj->groupName = $groupName;
                    $extendedFamilyPart->groups[$groupName] = $newObj;
                    //echo 'Neu hinzugefügte Gruppe "' . $groupName . '" (Person ' . $individual->xref() . '). ';
                }
            }
        }
    }

   /**
    * get a name for the relationship between an individual and the proband
    *
    * @param Individual $individual
    * 
    * @return string
    
    private function getRelationshipName(Individual $individual): string
    {
        if (ExtendedFamilyTabModule::VestaModulesAvailable(false)) {
            error_log("Vesta Modules available");
            // return \Cissee\Webtrees\Module\ExtendedRelationships\ExtendedRelationshipModule::getRelationshipLink($this->config->name, $individual->tree(), null, $individual->xref(), $this->proband->indi->xref(), 4);
        } else {
            error_log("Vesta Modules not available");
        }
        return '';
    }
    */

    /**
     * add an individual to a group of the extended family
     *
     * @param object $extendedFamilyPart part of extended family (modified by this function)
     * @param Individual $individual
     * @param object $family family to which this individual is belonging
     * @param string $groupName
     * @param Individual|null $referencePerson
     * @param Individual|null $referencePerson2
     */
    private function addIndividualToGroup(object &$extendedFamilyPart, Individual $individual, object $family, string $groupName, Individual $referencePerson = null, Individual $referencePerson2 = null )
    {
        $extendedFamilyPart->groups[$groupName]->members[] = $individual;                                                                         // array of strings                                
        $extendedFamilyPart->groups[$groupName]->labels[] = $this->generateChildLabels($individual);
        $extendedFamilyPart->groups[$groupName]->families[] = $family;
        $extendedFamilyPart->groups[$groupName]->familiesStatus[] = $this->findFamilyStatus($family);
        $extendedFamilyPart->groups[$groupName]->referencePersons[] = $referencePerson;
        $extendedFamilyPart->groups[$groupName]->referencePersons2[] = $referencePerson2;
    }

   /**
    * add an individual to the extended family 'partners' if it is not already member of this extended family
    *
    * @param Individual $individual
    * @param object part of extended family
    * @param Individual $spouse to which these partners are belonging
    */
    private function addIndividualToFamilyAsPartner(Individual $individual, object &$extendedFamilyPart, Individual $spouse)
    {
        $found = false;
        //error_log('Soll ' . $individual->xref() . ' als Partner von ' . $spouse->xref() . ' hinzugefuegt werden? ');
        if ( array_key_exists ( $spouse->xref(), $extendedFamilyPart->groups) ) {               // check if this spouse is already stored as group in this part of the extended family   
            //error_log($spouse->xref() . ' definiert bereits eine Gruppe. ');
            $efp = $extendedFamilyPart->groups[$spouse->xref()];
            foreach ($efp->members as $member) {                                                // check if individual is already a partner of this partner   
                //error_log('Teste Ehepartner ' . $member->xref() . ' in Gruppe fuer ' . $spouse->xref() . ': ');
                if ( $individual->xref() == $member->xref() ) {
                    $found = true;
                    error_log('Person ' . $individual->xref() . ' ist bereits als Partner von ' . $spouse->xref() . ' vorhanden. ');
                    break;
                }
            }
            if ( !$found ) {                                                                    // add individual to existing partner group
                //error_log('Person ' . $individual->xref() . ' wird als Partner von ' . $spouse->xref() . ' hinzugefuegt. ');
                $extendedFamilyPart->groups[$spouse->xref()]->members[] = $individual;
            }
        } else {                                                                                // generate new group of partners
            $newObj = (object)[];
            $newObj->members[] = $individual;
            $newObj->partner = $spouse;
            //error_log(print_r($newObj, true));
            $extendedFamilyPart->groups[$spouse->xref()] = $newObj;
            //error_log('Neu hinzugefuegte Gruppe fuer: ' . $spouse->xref() . ' (Person ' . $individual->xref() . ' als Partner hier hinzugefuegt). ');
        }
    }

    /**
     * filter individuals and count them per family or per group and per sex
     *
     * @param object $extendedFamilyPart part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string $filterOption
     */
    private function filterAndAddCountersToFamilyPartObject( object $extendedFamilyPart, string $filterOption )
    {
        if ( $filterOption !== 'all' ) {
            $this->filter( $extendedFamilyPart, $this->convertfilterOptions($filterOption) );
        }
        if ($extendedFamilyPart->partName == 'partner_chains') {
            $extendedFamilyPart->displayChains = $this->buildDisplayObjectPartnerChains($extendedFamilyPart);
        }
        $this->addCountersToFamilyPartObject( $extendedFamilyPart );
    }

    /**
     * count individuals per family or per group
     *
     * @param object part of extended family (modified by this function)
     */
    private function addCountersToFamilyPartObject( object &$extendedFamilyPart )
    {
        list ( $countMale, $countFemale, $countOthers ) = [0, 0 , 0];
        if ( $extendedFamilyPart->partName == 'partner_chains' ) {
            $counter = $this->countMaleFemalePartnerChain( $extendedFamilyPart->chains );
            list ( $countMale, $countFemale, $countOthers ) = [$counter->male, $counter->female, $counter->unknown_others];
        } else {
            foreach ($extendedFamilyPart->groups as $group) {
                $counter = $this->countMaleFemale( $group->members );
                $countMale += $counter->male;
                $countFemale += $counter->female;
                $countOthers += $counter->unknown_others;
            }
        }
        list ( $extendedFamilyPart->maleCount, $extendedFamilyPart->femaleCount, $extendedFamilyPart->allCount ) = [$countMale, $countFemale, $countMale + $countFemale + $countOthers];
        if ( $extendedFamilyPart->allCount > 0) {
            if ( $extendedFamilyPart->partName == 'partners' ) {
                $this->addCountersToFamilyPartObject_forPartners($extendedFamilyPart);
            } elseif ( $extendedFamilyPart->partName == 'partner_chains' ) {
                $this->addCountersToFamilyPartObject_forPartnerChains($extendedFamilyPart);
            }
        }
    }
    
    /**
     * count male and female individuals
     *
     * @param array of individuals
     *
     * @return object with three elements: male, female and unknown_others (int >= 0)
     */
    private function countMaleFemale(array $indilist): object
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

    /**
     * count male and female individuals in partner chains
     *
     * @param array of partner chain nodes
     *
     * @return object
     */
    private function countMaleFemalePartnerChain(array $chains): object
    { 
        $mfu = (object)[];
        list ( $mfu->male, $mfu->female, $mfu->unknown_others ) = [0, 0, 0];
        list ( $countMale, $countFemale, $countOthers ) = [0, 0, 0];
        foreach ($chains as $chain) {
            $this->countMaleFemalePartnerChainRecursive( $chain, $mfu );
            $countMale += $mfu->male;
            $countFemale += $mfu->female;
            $countOthers += $mfu->unknown_others;
        }
        return $mfu;
    }   

    /**
     * count individuals for partners
     *
     * @param object part of extended family (modified by this function)
     */
    private function addCountersToFamilyPartObject_forPartners( object &$extendedFamilyPart )
    {
        $count = $this->countMaleFemale( $extendedFamilyPart->groups[array_key_first($extendedFamilyPart->groups)]->members );
        $extendedFamilyPart->pmaleCount = $count->male;
        $extendedFamilyPart->pfemaleCount = $count->female;
        $extendedFamilyPart->pCount = $count->male + $count->female + $count->unknown_others;
        $extendedFamilyPart->popmaleCount = $extendedFamilyPart->maleCount - $count->male;
        $extendedFamilyPart->popfemaleCount = $extendedFamilyPart->femaleCount - $count->female;
        $extendedFamilyPart->popCount = $extendedFamilyPart->allCount - $extendedFamilyPart->pCount;
    }

    /**
     * count individuals for partner chainss
     *
     * @param object part of extended family (modified by this function)
     */
    private function addCountersToFamilyPartObject_forPartnerChains( object &$extendedFamilyPart )
    {
        $extendedFamilyPart->chainsCount = count($extendedFamilyPart->displayChains);
        $lc = 0;
        $i = 1;
        $lc_node = (object)[];
        $max = 0;
        $max_node = (object)[];
        foreach ($extendedFamilyPart->chains as $chain) { 
            $this->countLongestChainRecursive($chain, $i, $lc, $lc_node);
            if ($lc > $max) {
                $max = $lc;
                $max_node = $lc_node;
            }
        }
        $extendedFamilyPart->longestChainCount = $max+1;
        $extendedFamilyPart->mostDistantPartner = $max_node->indi;
        if ($extendedFamilyPart->longestChainCount <= 2) {                                             // normal marriage is no marriage chain
            $extendedFamilyPart->allCount = 0;
        }
    }

    /**
     * count male and female individuals in marriage chains
     *
     * @param array of marriage chain nodes
     * @param object counter for sex of individuals (modified by function)
     */
    private function countMaleFemalePartnerChainRecursive(object $node, object &$mfu)
    { 
        if ($node && $node->indi instanceof Individual) {
            if ($node->indi->sex() == "M") {
                $mfu->male++;
            } elseif ($node->indi->sex() == "F") {
                $mfu->female++;
            } else {
               $mfu->unknown_others++; 
            }
            foreach($node->chains as $chain) {
                $this->countMaleFemalePartnerChainRecursive($chain, $mfu);
            }   
        }
    }

    /**
     * count longest chain in marriage chains
     *
     * @param object of marriage chain nodes
     * @param int recursion counter (modified by function)
     * @param int counter for longest chain (modified by function)
     * @param object most distant partner (modified by function)
     */
    private function countLongestChainRecursive(object $node, int &$i, int &$lc, object &$lc_node)
    {
        if ($node && $node->indi instanceof Individual) {
            if ($i > $lc) {
                $lc = $i;
                $lc_node = $node;
            }
            $i++;
            foreach ($node->chains as $chain) {
                $this->countLongestChainRecursive($chain, $i, $lc, $lc_node);
            }
        }
        $i--;
    }

    /**
     * filter individuals in family part
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param array of string $filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    private function filter( object $extendedFamilyPart, array $filterOptions )
    {
        if ( ($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all') ) {
            if ($extendedFamilyPart->partName == 'partner_chains') {
                foreach($extendedFamilyPart->chains as $chain) {
                    $this->filterPartnerChainsRecursive($chain, $filterOptions);
                }
            } else {
                foreach ($extendedFamilyPart->groups as $group) {
                    foreach ($group->members as $key => $member) {
                        if ( ($filterOptions['alive'] == 'only_alive' && $member->isDead()) || ($filterOptions['alive'] == 'only_dead' && !$member->isDead()) ||
                             ($filterOptions['sex'] == 'only_M' && $member->sex() !== 'M') || ($filterOptions['sex'] == 'only_F' && $member->sex() !== 'F') || ($filterOptions['sex'] == 'only_U' && $member->sex() !== 'U') ) {
                            unset($group->members[$key]);
                        }
                    }
                }
            }
        }
        foreach ($extendedFamilyPart->groups as $key => $group) {            
            if (count($group->members) == 0) {
                unset($extendedFamilyPart->groups[$key]);
            }
        }

        return;
    }

    /**
     * filter individuals in partner chain
     *
     * @param object $node in chain
     * @param array of string filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    private function filterPartnerChainsRecursive( object $node, array $filterOptions )
    {
        if ( ($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all') ) {
            if ($node && $node->indi instanceof Individual) {
                if ( $filterOptions['alive'] == 'only_alive' && $node->indi->isDead() ) {
                    $node->filterComment = I18N::translate('a dead person');
                } elseif ( $filterOptions['alive'] == 'only_dead' && !$node->indi->isDead() ) {
                    $node->filterComment = I18N::translate('a living person');
                }
                if ($node->filterComment == '') {
                    if ( $filterOptions['sex'] == 'only_M' && $node->indi->sex() !== 'M' ) {
                        $node->filterComment = I18N::translate('not a male person');
                    } elseif ( $filterOptions['sex'] == 'only_F' && $node->indi->sex() !== 'F' ) {
                        $node->filterComment = I18N::translate('not a female person');
                    } elseif ( $filterOptions['sex'] == 'only_U' && $node->indi->sex() !== 'U' ) {
                        $node->filterComment = I18N::translate('not a person of unknown gender');
                    }
                }
                foreach ($node->chains as $chain) {
                    $this->filterPartnerChainsRecursive($chain, $filterOptions);
                }
            }
        }
    }

    /**
     * get list of options to filter by gender
     *
     * @return array of string
     */
    static function getFilterOptionsSex(): array
    {
        return [
            'M',
            'F',
            'U',
        ];
    }

    /**
     * get list of options to filter by alive/dead
     *
     * @return array of string
     */
    static function getFilterOptionsAlive(): array
    {
        return [
            'Y',
            'N',
        ];
    }

    /**
     * get list of all combinations of filter options ['all', 'M', 'F', 'U', 'Y', 'N', 'MY', 'FN', ...]
     *
     * @return array of string
     */
    static function getFilterOptions(): array
    {
        $options = [];
        $options[] = 'all';
        foreach(ExtendedFamily::getFilterOptionsSex() as $option) {
            $options[] = $option;
        }
        foreach(ExtendedFamily::getFilterOptionsAlive() as $option) {
            $options[] = $option;
        }
        foreach(ExtendedFamily::getFilterOptionsSex() as $optionSex) {
            foreach(ExtendedFamily::getFilterOptionsAlive() as $optionAlive) {
                $options[] = $optionSex . $optionAlive;
            }
        }
        return $options;
    }
    
    /**
     * convert combined filterOption to filter option for gender of a person [all, only_M, only_F, only_U]
     *
     * @param string [all, M, F, U, Y, N, MY, FN, ...]
     *
     * @return string
     */
    static function filterOptionSex($filterOption): string
    {
        foreach (ExtendedFamily::getFilterOptionsSex() as  $option) {
            if ( str_contains($filterOption, $option) ) {
                return 'only_' . $option;
            }
        }
        return 'all';
    }

    /**
     * convert combined filteroption to filter option for alive/dead status of a person [all, only_dead, only_alive]
     *
     * @param string [M, F, U, Y, N, MY, FN, ...]
     *
     * @return string
     */
    static function filterOptionAlive($filterOption): string
    {
        foreach (ExtendedFamily::getFilterOptionsAlive() as  $option) {
            if ( str_contains($filterOption,$option) ) {
                if ($option == 'Y') {
                    return 'only_alive';
                } else {
                    return 'only_dead';
                }
            }
        }
        return 'all';            
    }

    /**
     * convert combined filterOption to a pair of filter options
     *
     * @param string $filterOption  [M, F, U, Y, N, MY, ...]
     * @return array of string [sex, alive]
     */
    static function convertFilterOptions(string $filterOption): array
    {
        return [
            'sex'   => ExtendedFamily::filterOptionSex($filterOption),
            'alive' => ExtendedFamily::filterOptionAlive($filterOption),
        ];
    }

    /**
     * build object to display all partner chains
     *
     * @param extended family part object
     *
     * @return array
     */
    private function buildDisplayObjectPartnerChains(object $efp): array
    {      
        $chains = [];                                                           // array of chain (chain is an array of chainPerson) 
        
        $chainString = '0§1§' . $this->proband->indi->fullname() . '§' . $this->proband->indi->url() . '∞';
        foreach($efp->chains as $chain) {
            $i = 1;
            $this->buildStringPartnerChainsRecursive($chain, $chainString, $i);
        }
        do {                                                                    // remove redundant recursion back step indicators
            $chainString = str_replace("||", "|", $chainString, $count);
        } while ($count > 0);
        $chainString = rtrim($chainString,'|§∞ ');
        $chainStrings = explode('|', $chainString);
        foreach ($chainStrings as $chainString) {
            $personStrings = explode('∞', $chainString);
            $chain = [];                                                        // array of chainPerson
            foreach ($personStrings as $personString) {
                $attributes = explode('§', $personString);
                if (count($attributes) == 4) {
                    $chainPerson = (object)[];                                  // object (attributes: step, canShow, fullName, url)
                    $chainPerson->step = $attributes[0];
                    $chainPerson->canShow = ($attributes[1] == '1') ? true : false;
                    $chainPerson->fullName = $attributes[2];
                    $chainPerson->url = $attributes[3];
                    $chain[] = $chainPerson;
                }
            }
            if (count($chain) > 0) {
                $chains[] = $chain;
            }
        }
        
        return $chains;
    }

    /**
     * build string of all partners in marriage chains
     * names and urls should not contain
     * '|' used to seperate chains
     * '∞' used to seperate individuals
     * '§' used to seperate information fields for one individual: step, canShow, fullName, url
     *
     * @param object $node
     * @param string $chainString (modified in this function)
     * @param int $i recursion step (modified in this function)
     */
    private function buildStringPartnerChainsRecursive(object $node, string &$chainString, int &$i)
    {      
        if ($node && $node->indi instanceof Individual) {
            $chainString .= strval($i) . '§';
            if ($node->filterComment == '') {
                $chainString .= (($node->indi->canShow()) ? '1' : '0') . '§' . $node->indi->fullname() . '§' . $node->indi->url() . '∞';
            } else {
                $chainString .= '0§' . $node->filterComment . '§∞';
            }
            foreach($node->chains as $chain) {
                $i++;
                $this->buildStringPartnerChainsRecursive($chain, $chainString, $i);
            }
        }
        $i--;
        $chainString = rtrim($chainString, '∞') . '|';
    }

    /**
     * generate summary message for all empty blocks (needed for showEmptyBlock == 1)
     *
     * @param object $extendedFamily
     *
     * @return string
     */
    private function summaryMessageEmptyBlocks(object $extendedFamily): string
    {
        $summaryMessage = '';
        $empty = [];
        
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName !== 'allCount' && $propName !== 'summaryMessageEmptyBlocks' && $extendedFamily->efp->$propName->allCount == 0) {
                $empty[] = $propName;
            }
        }
        if (count($empty) > 0) {
            if (count($empty) == 1) {
                $summaryList = $this->translateFamilyPart($empty[0]);
                $summaryMessage = I18N::translate('%s has no %s recorded.', $this->proband->niceName, $summaryList);
            }
            else {
                $summaryListA = $this->translateFamilyPart($empty[0]);
                for ( $i = 1; $i <= count($empty)-2; $i++ ) {
                    $summaryListA .= ', ' . $this->translateFamilyPart($empty[$i]);
                }
                $summaryListB = $this->translateFamilyPart($empty[count($empty)-1]);
                $summaryMessage = I18N::translate('%s has no %s, and no %s recorded.', $this->proband->niceName, $summaryListA, $summaryListB);
            }
        }
        return $summaryMessage;      
    }
    
    /**
     * find rufname of an individual (tag _RUFNAME or marked with '*'
     *
     * @param Individual $individual
     *
     * @return string (is empty if there is no Rufname)
     */
    private function findRufname(Individual $individual): string
    {
        $rn = $individual->facts(['NAME'])[0]->attribute('_RUFNAME');
        if ($rn == '') {
            $rufnameParts = explode('*', $individual->facts(['NAME'])[0]->value());
            if ($rufnameParts[0] !== $individual->facts(['NAME'])[0]->value()) {
                // there is a Rufname marked with *, but no tag _RUFNAME
                $rufnameParts = explode(' ', $rufnameParts[0]);   
                $rn = $rufnameParts[count($rufnameParts)-1];                        // it has to be the last given name (before *)
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
    private function selectNameSex(Individual $individual, string $n_male, string $n_female, string $n_unknown): string
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
    private function findNiceName(Individual $individual): string
    {
        if ($this->config->showShortName) {
            // an individual can have no name or many names (then we use only the first one)
            if (count($individual->facts(['NAME'])) > 0) {                                           // check if there is at least one name            
                $niceName = $this->findNiceNameFromNameParts($individual);
            } else {
                $niceName = $this->selectNameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
            }
        } else {
            $niceName = $individual->fullname();
        }
        return $niceName;
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
    private function findNiceNameFromNameParts(Individual $individual): string
    {
        $niceName = '';
        $rn = $this->findRufname($individual);
        if ($rn !== '') {
            $niceName = $rn;
        } else {
            $name_facts = $individual->facts(['NAME']);
            $nickname = $name_facts[0]->attribute('NICK');
            if ($nickname !== '') {
                $niceName = $nickname;
            } else {
                $npfx = $name_facts[0]->attribute('NPFX');
                $givenAndSurnames = explode('/', $name_facts[0]->value());
                if ($givenAndSurnames[0] !== '') {                                  // are there given names (or prefix nameparts)?
                    $givennameparts = explode( ' ', $givenAndSurnames[0]);
                    if ($npfx == '') {                                              // find the first given name
                        $niceName = $givennameparts[0];                             // the first given name
                    } elseif (count(explode(' ',$npfx)) !== count($givennameparts)) {
                        $niceName = $givennameparts[count(explode(' ',$npfx))];     // the first given name after the prefix nameparts
                    }
                } else {
                    $surname = $givenAndSurnames[1];
                    if ($surname !== '') {
                        $niceName = $this->selectNameSex($individual, I18N::translate('Mr.') . ' ' . $surname, I18N::translate('Mrs.') . ' ' . $surname, $surname);
                    } else {
                        $niceName = $this->selectNameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
                    }
                }
            }
        }
        return $niceName;
    }

    /**
     * generate an array of labels for a child
     *
     * @param Individual $child
     * @return array of string with child labels
     */
    public static function generateChildLabels(Individual $child): array
    {
        return array_filter([
            ExtendedFamily::_generatePedigreeLabel($child),
            ExtendedFamily::_generateChildLinkageStatusLabel($child),
            ExtendedFamily::_generateMultipleBirthLabel($child),
            ExtendedFamily::_generateAgeLabel($child),
        ]);
    }

    /**
     * generate a pedigree label
     * GEDCOM record is for example ""
     *
     * @param Individual $child
     * @return string
     */
    static function _generatePedigreeLabel(Individual $child): string
    {
        $label = GedcomCodePedi::getValue('',$child->getInstance($child->xref(),$child->tree()));
        if ( $child->childFamilies()->first() ) {
            if (preg_match('/\n1 FAMC @' . $child->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $child->gedcom(), $match)) {
                if ($match[1] !== 'birth') {
                    $label = GedcomCodePedi::getValue($match[1],$child->getInstance($child->xref(),$child->tree()));
                }
            }
        }
        return $label;
    }

    /**
     * generate a child linkage status label [challenged | disproven | proven]
     * GEDCOM record is for example ""
     *
     * @param Individual $child
     * @return string
     */
    static function _generateChildLinkageStatusLabel(Individual $child): string
    {
        if ( $child->childFamilies()->first() ) {
            if (preg_match('/\n1 FAMC @' . $child->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 STAT (.+)/', $child->gedcom(), $match)) {
                return I18N::translate('linkage ' . strtolower($match[1]));
            }
        }
        return '';
    }
    /**
     * generate a label for twins and triplets etc
     * GEDCOM record is for example "1 ASSO @I123@\n2 RELA triplet" or "1 BIRT\n2 _ASSO @I123@\n3 RELA triplet"
     *
     * @param Individual $child
     * @return string
     */
    static function _generateMultipleBirthLabel(Individual $child): string
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
        
        $childGedcom = $child->gedcom();
        if ( preg_match('/\n1 ASSO @(?:.+)@\n2 RELA (.+)/', $childGedcom, $match) ||
             preg_match('/\n2 _ASSO @(?:.+)@\n3 RELA (.+)/', $childGedcom, $match) ) {
            if (in_array(strtolower($match[1]), $multiple_birth)) {
                return I18N::translate(strtolower($match[1]));
            }
        }        

        return '';
    }

    /**
     * generate a label for children that are stillborn or died as an infant
     * GEDCOM record is for example "1 DEAT\n2 AGE INFANT" or "1 BIRT\n2 AGE STILLBORN"
     *
     * There was a performance bug when using preg_match('/\n1 BIRT((.|\s)*)\n2 AGE STILLBORN/i', $childGedcom, $match)
     *
     * @param Individual $child
     * @return string
     */
    static function _generateAgeLabel(Individual $child): string
    {     
        $childGedcom = $child->gedcom();
        if ( preg_match('/\n2 AGE STILLBORN/i', $childGedcom, $match) ) {
            return I18N::translate('stillborn');
        }        
        if ( preg_match('/\n2 AGE INFANT/i', $childGedcom, $match) ) {
            return I18N::translate('died as infant');
        }
        return '';
    }

   /**
    * find status of a family
    *
    * @param object $family
    * @return string
    */
    public static function findFamilyStatus(object $family): string
    { 
        $event = $family->facts(['ANUL', 'DIV', 'ENGA', 'MARR'], true)->last();
        if ($event instanceof Fact) {
            echo "<br>family tag=".$event->tag().". ";
            switch ($event->tag()) {
                case 'FAM:ANUL':
                case 'FAM:DIV':
                    return I18N::translate(self::FAM_STATUS_EX);
                case 'FAM:MARR':
                    return I18N::translate(self::FAM_STATUS_MARRIAGE);
                case 'FAM:ENGA':
                    return I18N::translate(self::FAM_STATUS_FIANCEE);
            }
        }
        return I18N::translate(self::FAM_STATUS_PARTNERSHIP);                       // default if there is no MARR tag
    }

   /**
    * translate family part names
    *
    * @param string $type (in lower case and using _)
    * @return string
    */
    public static function translateFamilyPart(string $type): string
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
