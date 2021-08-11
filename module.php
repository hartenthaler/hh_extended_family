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

/*
 * tbd: Offene Punkte
 * ------------------
 * Filteroptionen durch Nutzer statt durch Administrator ermöglichen
 *
 * siehe issues/enhancements in github
 *
 * Familiengruppe Schwäger und Schwägerinnen: Ergänzen der vollbürtigen Geschwister um halbbürtige und Stiefgeschwister
 * Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von Partner gemischt sein sollte
 * Familiengruppe Partnerketten: grafische Anzeige statt Textketten
 * Familiengruppe Partnerketten: von Gerlinde geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette von Dieter zu Gabi, d.h. dies als zweite Info ergänzen
 * Familiengruppe Geschwister: eventuell statt Label eigene Kategorie für Adoptiv- und Pflegekinder bzw. Stillmutter
 *
 * Label für Stiefkinder: etwa bei meinen Neffen Fabian, Felix, Jason und Sam
 * Label für Partner: neu einbauen (Ehemann/Ehefrau/Partner/Partnerin/Verlobter/Verlobte/Ex-...)
 * Label für Eltern: biologische Eltern, Stiefeltern, Adoptiveltern, Pflegeeltern
 * Label oder Gruppe bei Onkel/Tante: Halbonkel/-tante = Halbbruder/-schwester eines biologichen Elternteils
 * Label bei Geschwistern: für Zwillinge/Drillinge/... ergänzen
 *
 * Code: Ablaufreihenfolge in function addIndividualToDescendantsFamily() umbauen wie function addIndividualToDescendantsFamilyAsPartner()
 * Code: Abbruch der Suche für isGrayedOut-tab sobald eine Person gefunden worden ist
 * Code: alle eigenen Objekte mit new X() erzeugen
 * Code: eventuell Verwendung der bestehenden Funktionen zum Aufbau von Familienteilen statt es jedes Mal vom Probanden aus komplett neu zu gestalten
 * Code: use array instead of object, ie efp['grandparents' => $this->get_grandparents( $individual ) , ...] instead of efp->grandparents, ...
 * Code: eigentliche Modulfunktionen und Moduladministration in zwei Dateien auftrennen
 * Code: php-Klassen-Konzept verwenden
 *
 * Test: Stiefcousins (siehe Onkel Walter)
 * Test: Schwagerehe (etwa Levirat oder Sororat)
 * Übersetzungen: auslagern in eigene Dateien
 * Übersetzungen: fehlende für french, norwegian (2x), finish und andere organisieren
 * Doku: verwendete Systemfunktionen wie explode etc. auflisten
 * andere Verwandtschaftssysteme: eventuell auch andere als nur das Eskimo-System implementieren
 * andere Verwandtschaftssysteme: Onkel als Vater- oder Mutterbruder ausweisen für Übersetzung (Label?); Tante als Vater- oder Mutterschwester ausweisen für Übersetzung (Label?);
 * andere Verwandtschaftssysteme: Brüder und Schwestern als jüngere oder ältere Geschwister ausweisen für Übersetzung (in Bezugg auf Proband) (Label?)
 * Ergänzung der genetischen Nähe der jeweiligen Personengruppe in % (als Mouse-over?)
 * Funktionen getSizeThumbnailW() und getSizeThumbnailH() verbessern: Option für thumbnail size? oder css für shilouette? Gibt es einen Zusammenhang oder sind sie unabhängig? Wie genau wirken sie sich aus? siehe issue von Sir Peter
 *
 * neue Idee: Statistikfunktion für webtrees zur Ermittlung der längsten und der umfangreichsten Heiratsketten in einem Tree
 * neue Idee: Liste der Spitzenahnen
 * neue Idee: Kette zum entferntesten Vorfahren
 * neue Idee: Kette zum entferntesten Nachkommen
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

// string functions
use function ucfirst;
use function str_replace;
use function preg_match;
use function strval;
use function rtrim;
// array functions
use function explode;
use function implode;
use function count;
use function array_key_exists;
use function array_search;
use function in_array;
//use function unset;

/**
 * Class ExtendedFamilyTabModule
 */
class ExtendedFamilyTabModule extends AbstractModule implements ModuleTabInterface, ModuleCustomInterface, ModuleConfigInterface
{
    use ModuleTabTrait;
    use ModuleCustomTrait;
    use ModuleConfigTrait;

    /**
     * list of const for module administration
     */ 
    public const CUSTOM_TITLE = 'Extended family';
    
    public const CUSTOM_MODULE = 'hh_extended_family';
    
    public const CUSTOM_DESCRIPTION = 'A tab showing the extended family of an individual.';

    public const CUSTOM_AUTHOR = 'Hermann Hartenthaler';
    
    public const CUSTOM_WEBSITE = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE . '/';
    
    public const CUSTOM_VERSION = '2.0.16.44';

    public const CUSTOM_LAST = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE. '/raw/main/latest-version.txt';
    
    /**
     * list of const for extended family
     */    
    public const ANCESTORS   = 'ancestors';
    public const DESCENDANTS = 'descendants';
    
    public const FAM_SIDE_FATHER = 'father';
    public const FAM_SIDE_MOTHER = 'mother';

    public const FAM_STATUS_EX          = 'Ex-marriage';
    public const FAM_STATUS_MARRIAGE    = 'Marriage';
    public const FAM_STATUS_FIANCEE     = 'Fiancée';
    public const FAM_STATUS_PARTNERSHIP = 'Partnership';
    
    public const GROUP_COPARENTSINLAW_BIO  = 'Co-parents-in-law of biological children';
    public const GROUP_COPARENTSINLAW_STEP = 'Co-parents-in-law of stepchildren';
    
    public const GROUP_SIBLINGS_FULL = 'Full siblings';
    public const GROUP_SIBLINGS_HALF = 'Half siblings';          // including more than half siblings (if parents are related to each other)
    public const GROUP_SIBLINGS_STEP = 'Stepsiblings';
    
    public const GROUP_SIBLINGS_IN_LAW_SIBOFP = 'Siblings of partners';
    public const GROUP_SIBLINGS_IN_LAW_POFSIB = 'Partners of siblings';         
    
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
    
    /**
     * list of parts of extended family
     *
     * @return array
     */
    private function listOfFamilyParts(): array         // new elements can be added, but not changed or deleted
    {    
        return [
            'grandparents',                             // generation +2
            'uncles_and_aunts',                         // generation +1
            'parents',                                  // generation +1
            'parents_in_law',                           // generation +1
            'co_parents_in_law',                        // generation  0           
            'partners',                                 // generation  0
            'partner_chains',                           // generation  0
            'siblings',                                 // generation  0
            'siblings_in_law',                          // generation  0
            'cousins',                                  // generation  0
            'nephews_and_nieces',                       // generation -1
            'children',                                 // generation -1
            'children_in_law',                          // generation -1
            'grandchildren',                            // generation -2
        ];
    }
   
    /**
     * Find members of extended family
     *
     * @param Individual $individual
     *
     * @return object
     *  ->config->showEmptyBlock                                int [0,1,2]
     *          ->showLabels                                    bool
     *          ->useCompactDesign                              bool
     *          ->showThumbnail                                 bool
     *          ->fiterOptionDead                               string
     *          ->filterOptionSex                               string
     *  ->self->indi                                            object individual
     *        ->niceName                                        string
     *        ->label                                           string
     *  ->efp->allCount                                         int
     *       ->summaryMessageEmptyBlocks                        string
     *       ->grandparents->father                             object individual
     *                     ->mother                             object individual
     *                     ->families->fatherFamily[]           array of object individual 
     *                               ->motherFamily[]           array of object individual
     *                               ->fatherAndMotherFamily[]  array of object individual    
     *                     ->fathersFamilyCount                 int
     *                     ->mothersFamilyCount                 int
     *                     ->fathersAndMothersFamilyCount       int    
     *                     ->fathersMaleCount                   int
     *                     ->fathersFemaleCount                 int
     *                     ->mothersMaleCount                   int
     *                     ->mothersFemaleCount                 int    
     *                     ->fathersAndMothersMaleCount         int
     *                     ->fathersAndMothersFemaleCount       int
     *                     ->maleCount                          int    
     *                     ->femaleCount                        int
     *                     ->allCount                           int
     *                     ->partName                           string
	 *					   ->partName_translated				string
	 *					   ->type								string
     *       ->uncles_and_aunts                                 see grandparents
     *       ->parents                                          see grandparents
     *       ->parents_in_law->groups[]->members[]              array of object individual   (index of groups is int)
     *                                 ->family                 object family
     *                                 ->familyStatus           string
     *                                 ->partner                object individual
     *                       ->maleCount                        int    
     *                       ->femaleCount                      int
     *                       ->allCount                         int
     *                       ->partName                         string
	 *					   	 ->partName_translated			    string
	 *					   	 ->type						        string
     *       ->co_parents_in_law                                see children
     *       ->partners->groups[]->members[]                    array of object individual   (index of groups is XREF)
     *                           ->partner                      object individual
     *                 ->pCount                                 int
     *                 ->pmaleCount                             int
     *                 ->pfemaleCount                           int
     *                 ->popCount                               int
     *                 ->popmaleCount                           int
     *                 ->popfemaleCount                         int
     *                 ->maleCount                              int    
     *                 ->femaleCount                            int
     *                 ->allCount                               int
     *                 ->partName                               string
	 *				   ->partName_translated			        string
	 *				   ->type							        string
     *       ->partner_chains->chains[]                         array of object (tree of marriage chain nodes)
     *                       ->displayChains[]                  array of chain (array of chainPerson objects)
     *                       ->chainsCount                      int (number of chains)
     *                       ->longestChainCount                int
     *                       ->mostDistantPartner               individual (first one if there are more than one)
     *                       ->maleCount                        int    
     *                       ->femaleCount                      int
     *                       ->allCount                         int
     *                       ->partName                         string
     *				         ->partName_translated			    string
     *				         ->type							    string
     *       ->siblings                                         see children 
     *       ->siblings_in_law                                  see children
     *       ->cousins                                          see grandparents
     *       ->nephews_and_nieces                               see children
     *       ->children->groups[]->members[]                    array of object individual   (index of groups is groupName)
     *                           ->labels[]                     array of string
     *                           ->families[]                   array of object
     *                           ->familiesStatus[]             string
     *                           ->groupName                    string
     *                 ->maleCount                              int    
     *                 ->femaleCount                            int
     *                 ->allCount                               int
     *                 ->partName                               string
     *				   ->partName_translated			        string
     *				   ->type							        string
     *       ->children_in_law                                  see children
     *       ->grandchildren                                    see children
     */
    private function getExtendedFamily(Individual $individual): object
    {
        $extfamObj = (object)[];
        $extfamObj->config = $this->get_config( $individual );
        $extfamObj->self = $this->get_self( $individual );
        $extfamObj->efp = (object)[];
        $extfamObj->efp->allCount = 0;

        $efps = $this->showFamilyParts();
        foreach ($efps as $efp => $value) {
            if ( $efps[$efp]->enabled ) {
                $extfamObj->efp->$efp = $this->callFunction( 'get_' . $efp, $individual );
                $this->filterAndAddCountersToFamilyPartObject( $extfamObj->efp->$efp, $individual );
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
     * store configuration information
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_config(Individual $individual): object
    {
        $configObj = (object)[];
        $configObj->showEmptyBlock    = $this->showEmptyBlock();
        $configObj->showLabels        = $this->showLabels();
        $configObj->useCompactDesign  = $this->useCompactDesign();
        $configObj->showThumbnail     = $this->showThumbnail( $individual->tree() );
        $configObj->showFilterOptions = $this->showFilterOptions();
        $configObj->filterOptionDead  = $this->filterOptionDead();
        $configObj->filterOptionSex   = $this->filterOptionSex();
        return $configObj;
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
        $selfObj->label = $this->getChildLabel( $individual );
        return $selfObj;
    }
    
    /**
     * Find grandparents for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function get_grandparentsOneSide(object $extendedFamilyPart, string $side)
    {
        $parent = $extendedFamilyPart->$side;
        if ($parent instanceof Individual) {                                                    // Gen 1 P
            foreach ($parent->spouseFamilies() as $family1) {                                   // Gen 1 F
                foreach ($family1->spouses() as $spouse) {                                      // Gen 1 P
                    if (!($side == self::FAM_SIDE_FATHER and $spouse == $extendedFamilyPart->mother) && !($side == self::FAM_SIDE_MOTHER and $spouse == $extendedFamilyPart->father)) {
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
        
        if ($individual->childFamilies()->first()) {                                    // husband() or wife() may not exist
            $GrandparentsObj->father = $individual->childFamilies()->first()->husband();
            $GrandparentsObj->mother = $individual->childFamilies()->first()->wife();
            $this->get_grandparentsOneSide( $GrandparentsObj, self::FAM_SIDE_FATHER);
            $this->get_grandparentsOneSide( $GrandparentsObj, self::FAM_SIDE_MOTHER);
        }

        return $GrandparentsObj;
    }

    /**
     * Find uncles and aunts for one side including uncles and aunts by marriage
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
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
            $this->get_uncles_and_auntsOneSide( $unclesAuntsObj, self::FAM_SIDE_FATHER);
            $this->get_uncles_and_auntsOneSide( $unclesAuntsObj, self::FAM_SIDE_MOTHER);
        }

        return $unclesAuntsObj;
    }

    /**
     * Find parents for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function get_parentsOneSide(object $extendedFamilyPart, string $side)
    {
        $parent = $extendedFamilyPart->$side;
        if ($parent instanceof Individual) {                                                    // Gen 1 P
            foreach ($parent->spouseFamilies() as $family1) {                                   // Gen 1 F
                foreach ($family1->spouses() as $spouse) {                                      // Gen 1 P
                    if (!($side == self::FAM_SIDE_FATHER and $spouse == $extendedFamilyPart->mother) and !($side == self::FAM_SIDE_MOTHER and $spouse == $extendedFamilyPart->father)) {
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
        
        if ($individual->childFamilies()->first()) {                                    // husband() or wife() may not exist
            $ParentsObj->father = $individual->childFamilies()->first()->husband();
            $ParentsObj->mother = $individual->childFamilies()->first()->wife();
            $this->get_parentsOneSide( $ParentsObj, self::FAM_SIDE_FATHER);
            $this->get_parentsOneSide( $ParentsObj, self::FAM_SIDE_MOTHER);
        }

        return $ParentsObj;
    }

    /**
     * Find parents-in-law (parents of partners including partners of partners)
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_parents_in_law(Individual $individual): object
    {      
        $Parents_in_lawObj = $this->initializedFamilyPartObject('parents_in_law');
        foreach ($individual->spouseFamilies() as $family) {                                    // Gen  0 F
            foreach ($family->spouses() as $spouse) {                                           // Gen  0 P
                if ($spouse !== $individual) {
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->husband() instanceof Individual)) {
                        $this->addIndividualToDescendantsFamily( $spouse->childFamilies()->first()->husband(), $Parents_in_lawObj, $family, $individual );
                    }
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->wife() instanceof Individual)) {
                        $this->addIndividualToDescendantsFamily( $spouse->childFamilies()->first()->wife(), $Parents_in_lawObj, $family, $individual );
                    }
                }
            }
        }

        return $Parents_in_lawObj;
    }

    /**
     * Find co-parents-in-law (parents of children-in-law)
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_co_parents_in_law(Individual $individual): object
    {      
        $coParents_in_lawObj = $this->initializedFamilyPartObject('co_parents_in_law');
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                foreach ($child->spouseFamilies() as $family2) {                                // Gen -1 F
                    foreach ($family2->spouses() as $child_in_law) {                            // Gen -1 P
                        if ($child_in_law !== $child) {
                            if ( ($child_in_law->childFamilies()->first()) && ($child_in_law->childFamilies()->first()->husband() instanceof Individual) ) {        // husband() or wife() may not exist
                                $this->addIndividualToDescendantsFamily( $child_in_law->childFamilies()->first()->husband(), $coParents_in_lawObj, $family2, null, self::GROUP_COPARENTSINLAW_BIO );
                            }
                            if ( ($child_in_law->childFamilies()->first()) && ($child_in_law->childFamilies()->first()->wife() instanceof Individual) ) {
                                $this->addIndividualToDescendantsFamily( $child_in_law->childFamilies()->first()->wife(), $coParents_in_lawObj, $family2, null, self::GROUP_COPARENTSINLAW_BIO );
                            }
                        }
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->spouses() as $stepchild_in_law) {                // Gen -1 P
                                if ($stepchild_in_law !== $stepchild) {
                                    if ( ($stepchild_in_law->childFamilies()->first()) && ($stepchild_in_law->childFamilies()->first()->husband() instanceof Individual)) {        // husband() or wife() may not exist
                                        $this->addIndividualToDescendantsFamily( $stepchild_in_law->childFamilies()->first()->husband(), $coParents_in_lawObj, $family3, $stepchild, self::GROUP_COPARENTSINLAW_STEP );
                                    }
                                    if ( ($stepchild_in_law->childFamilies()->first()) && ($stepchild_in_law->childFamilies()->first()->wife() instanceof Individual)) {
                                        $this->addIndividualToDescendantsFamily( $stepchild_in_law->childFamilies()->first()->wife(), $coParents_in_lawObj, $family3, $stepchild, self::GROUP_COPARENTSINLAW_STEP );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $coParents_in_lawObj;
    }
    
    /**
     * Find full and half siblings, as well as stepsiblings
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_siblings(Individual $individual): object
    {      
        $SiblingsObj = $this->initializedFamilyPartObject('siblings');
        
        foreach ($individual->childFamilies() as $family) {                                     // Gen  1 F
            foreach ($family->children() as $sibling_full) {                                    // Gen  0 P
                if ($sibling_full !== $individual) {
                    $this->addIndividualToDescendantsFamily( $sibling_full, $SiblingsObj, $family, null, self::GROUP_SIBLINGS_FULL );
                }
            }
        }
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling_half) {                           // Gen  0 P
                        if ($sibling_half !== $individual) {
                            $this->addIndividualToDescendantsFamily( $sibling_half, $SiblingsObj, $family1, null, self::GROUP_SIBLINGS_HALF );
                        }
                    }
                }
            }
        }
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->spouses() as $spouse2) {                                 // Gen  1 P
                        foreach ($spouse2->spouseFamilies() as $family3) {                      // Gen  1 F
                            foreach ($family3->children() as $sibling_step) {                   // Gen  0 P
                                if ($sibling_step !== $individual) {
                                    $this->addIndividualToDescendantsFamily( $sibling_step, $SiblingsObj, $family1, null, self::GROUP_SIBLINGS_STEP );
                                }
                            }
                        }
                    }
                }
            }
        }

        return $SiblingsObj;
    }

    /**
     * Find siblings-in-law (partners of siblings and siblings of partners)
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_siblings_in_law(Individual $individual): object
    {      
        $SiblingsInLawObj = $this->initializedFamilyPartObject('siblings_in_law');
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full !== $individual) {
                    foreach ($sibling_full->spouseFamilies() as $family2) {                     // Gen  0 F
                        foreach ($family2->spouses() as $spouse) {                              // Gen  0 P
                            if ( $spouse !== $sibling_full ) {
                                $this->addIndividualToDescendantsFamily( $spouse, $SiblingsInLawObj, $family2, $sibling_full, self::GROUP_SIBLINGS_IN_LAW_POFSIB );
                            }
                        }
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1 !== $individual ) {
                    foreach ($spouse1->childFamilies() as $family2) {                           // Gen  1 F
                        foreach ($family2->children() as $sibling) {                            // Gen  0 P
                            if ($sibling !== $spouse1) {
                                $this->addIndividualToDescendantsFamily( $sibling, $SiblingsInLawObj, $family1, $spouse1, self::GROUP_SIBLINGS_IN_LAW_SIBOFP );
                            }
                        }
                    }
                }
            }
        }

        return $SiblingsInLawObj;
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
        foreach ($individual->spouseFamilies() as $family1) {                                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                                         // Gen  0 P
                if ( $spouse1 !== $individual ) {
                    $this->addIndividualToDescendantsFamilyAsPartner( $spouse1, $PartnersObj, $individual );
                }
                foreach ($spouse1->spouseFamilies() as $family2) {                                              // Gen  0 F
                    foreach ($family2->spouses() as $spouse2) {                                                 // Gen  0 P
                        if ( $spouse2 !== $spouse1 && $spouse2 !== $individual ) {
                            $this->addIndividualToDescendantsFamilyAsPartner( $spouse2, $PartnersObj, $spouse1 );
                        }
                    }
                }
            }
        }

        return $PartnersObj;
    }

    /**
     * Find a chain of partners
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_partner_chains(Individual $individual): object
    {      
        $TreeObj = $this->initializedFamilyPartObject('partner_chains');
        
        $chainRootNode = (object)[];
        $chainRootNode->chains = [];
        $chainRootNode->indi = $individual;
        $chainRootNode->filterComment = '';
        
        $stop = (object)[];                                 // avoid endless loops
        $stop->indiList = [];
        $stop->indiList[] = $individual->xref();
        $stop->familyList = [];
        
        $TreeObj->chains = $this->get_partner_chains_recursive ($chainRootNode, $stop);

        return $TreeObj;
    }
    
    /**
     * Find chains of partners recursive
     *
     * @param object $node
     * @param object stoplist with arrays of indi-xref and fam-xref
     *
     * @return array
     */
    private function get_partner_chains_recursive(object $node, object &$stop): array
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
                            $new_node->chains = $this->get_partner_chains_recursive($new_node, $stop);
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
     * Find half and full cousins for one side 
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
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
            $this->get_cousinsOneSide( $CousinsObj, self::FAM_SIDE_FATHER);
            $this->get_cousinsOneSide( $CousinsObj, self::FAM_SIDE_MOTHER);
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
                                foreach ($family3->children() as $nephewniece) {                // Gen -1 P
                                    $this->addIndividualToDescendantsFamily( $nephewniece, $NephewsNiecesObj, $family1, null, self::GROUP_NEPHEW_NIECES_CHILD_SIBLING );
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ( $sibling !== $individual ) {
                            foreach ($sibling->spouseFamilies() as $family3) {                  // Gen  0 F
                                foreach ($family3->spouses() as $parent) {                      // Gen  0 P
                                    foreach ($parent->spouseFamilies() as $family4) {           // Gen  0 F    
                                        foreach ($family4->children() as $nephewniece) {        // Gen -1 P
                                            $this->addIndividualToDescendantsFamily( $nephewniece, $NephewsNiecesObj, $family1, null, self::GROUP_NEPHEW_NIECES_CHILD_PARTNER_SIBLING );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family0) {                                               // Gen  0 F
            foreach ($family0->spouses() as $spouse0) {                                                     // Gen  0 P
                if ( $spouse0 !== $individual ) {
                    foreach ($spouse0->childFamilies() as $family1) {                                       // Gen  1 F
                        foreach ($family1->spouses() as $parent_in_law) {                                   // Gen  1 P
                            foreach ($parent_in_law->spouseFamilies() as $family2) {                        // Gen  1 F
                                foreach ($family2->children() as $sibling_in_law) {                         // Gen  0 P
                                    if ( $sibling_in_law !== $spouse0) {
                                        foreach ($sibling_in_law->spouseFamilies() as $family3) {           // Gen  0 F    
                                            foreach ($family3->children() as $nephewniece) {                // Gen -1 P
                                                $this->addIndividualToDescendantsFamily( $nephewniece, $NephewsNiecesObj, $family0, null, self::GROUP_NEPHEW_NIECES_CHILD_SIBLING_PARTNER );
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
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                $this->addIndividualToDescendantsFamily( $child, $ChildrenObj, $family1, null, self::GROUP_CHILDREN_BIO );
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        $this->addIndividualToDescendantsFamily( $child, $ChildrenObj, $family2, null, self::GROUP_CHILDREN_STEP );
                    }
                }
            }
        }

        return $ChildrenObj;
    }

    /**
     * Find children-in-law (partner of children and stepchildren)
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_children_in_law(Individual $individual): object
    {      
        $children_in_lawObj = $this->initializedFamilyPartObject('children_in_law');
        
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                foreach ($child->spouseFamilies() as $family2) {                                // Gen -1 F
                    foreach ($family2->spouses() as $child_in_law) {                            // Gen -1 P
                        if ($child_in_law !== $child) {
                            $this->addIndividualToDescendantsFamily( $child_in_law, $children_in_lawObj, $family1, $child, self::GROUP_CHILDRENINLAW_BIO );
                        }
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->spouses() as $stepchild_in_law) {                // Gen -1 P
                                if ($stepchild_in_law !== $stepchild) {
                                    $this->addIndividualToDescendantsFamily( $stepchild_in_law, $children_in_lawObj, $family1, $stepchild, self::GROUP_CHILDRENINLAW_STEP );
                                }
                            }
                        }
                    }
                }
            }
        }

        return $children_in_lawObj;
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
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    foreach ($family2->children() as $biograndchild) {                          // Gen -2 P
                        $this->addIndividualToDescendantsFamily( $biograndchild, $GrandchildrenObj, $family1, null, self::GROUP_GRANDCHILDREN_BIO );
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    foreach ($family2->spouses() as $spouse) {                                  // Gen -1 P
                        foreach ($spouse->spouseFamilies() as $family3) {                       // Gen -1 F    
                            foreach ($family3->children() as $step_child) {                     // Gen -2 P
                                $this->addIndividualToDescendantsFamily( $step_child, $GrandchildrenObj, $family1, null, self::GROUP_GRANDCHILDREN_STEP_CHILD );
                            }
                        }
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $stepchild) {                              // Gen -1 P
                        foreach ($stepchild->spouseFamilies() as $family3) {                    // Gen -1 F
                            foreach ($family3->children() as $child_step) {                     // Gen -2 P
                                $this->addIndividualToDescendantsFamily( $child_step, $GrandchildrenObj, $family1, null, self::GROUP_GRANDCHILDREN_CHILD_STEP );
                            }
                        }
                    }
                }
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        foreach ($child->spouseFamilies() as $family3) {                        // Gen -1 F
                            foreach ($family3->spouses() as $childstepchild) {                  // Gen -1 P
                                foreach ($childstepchild->spouseFamilies() as $family4) {       // Gen -1 F    
                                    foreach ($family4->children() as $step_step) {              // Gen -2 P
                                        $this->addIndividualToDescendantsFamily( $step_step, $GrandchildrenObj, $family1, null, self::GROUP_GRANDCHILDREN_STEP_STEP );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

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
        
        if ($efpObj->type == self::ANCESTORS) {
            $efpObj->families = (object)[];
            $efpObj->families->fatherFamily = [];
            $efpObj->families->motherFamily = [];
            $efpObj->families->fatherAndMotherFamily = [];
        } elseif ($efpObj->type == self::DESCENDANTS) {
            $efpObj->groups = [];
        }
        
        return $efpObj;
    }
    
    /**
     * type of part of extended family
     *
     * @param name of part of extended family
     *
     * @return string [ANCESTORS, DESCENDANTS]
     */
    private function typeOfFamilyPart(string $partName): string
    {       
        switch ($partName) {
            case 'grandparents':
            case 'parents':
            case 'uncles_and_aunts':
            case 'cousins': 
                return self::ANCESTORS;
            default:
                return self::DESCENDANTS;
        }
    }
    
   /**
    * add an individual to the extended family (of type ANCESTORS) if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family
    * @param string prefered family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
    */
    private function addIndividualToAncestorsFamily(Individual $individual, object $extendedFamilyPart, string $side)
    {
        //echo " Add ".$individual->fullName()." on ".$side." side.";
        if ($side == self::FAM_SIDE_MOTHER) {
            if ( in_array( $individual, $extendedFamilyPart->families->fatherAndMotherFamily )){
                //echo "Already stored in father's and mother's array: do nothing";
            } elseif ( in_array( $individual, $extendedFamilyPart->families->fatherFamily )){
                //echo "Already found in father's side, add to both sides";
                $extendedFamilyPart->families->fatherAndMotherFamily[] = $individual;
                unset($extendedFamilyPart->families->fatherFamily[array_search($individual,$extendedFamilyPart->families->fatherFamily)]);
            } elseif ( !in_array( $individual, $extendedFamilyPart->families->motherFamily ) ) {
                //echo "ok, new to mother's family, add there";
                $extendedFamilyPart->families->motherFamily[] = $individual;
            }
        } elseif ( !in_array( $individual, $extendedFamilyPart->families->fatherFamily ) ) {
            if ( in_array( $individual, $extendedFamilyPart->families->fatherAndMotherFamily )){
                // already stored in father's and mother's array: do nothing
            } elseif ( in_array( $individual, $extendedFamilyPart->families->motherFamily )){
                $extendedFamilyPart->families->fatherAndMotherFamily[] = $individual;
                unset($extendedFamilyPart->families->motherFamily[array_search($individual,$extendedFamilyPart->families->motherFamily)]);
            } elseif ( !in_array( $individual, $extendedFamilyPart->families->fatherFamily ) ) {
                $extendedFamilyPart->families->fatherFamily[] = $individual;
            }
        }
        
        return;
    }
    
   /**
    * add an individual to the extended family (of type DESCENDANTS) if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family
    * @param object family to which these descendants are belonging
    * @param (optional) individual reference person
    * @param (optional) string name of group
    */
    private function addIndividualToDescendantsFamily(Individual $individual, object $extendedFamilyPart, object $family, Individual $referencePerson = null, string $groupName = '' )
    {
        $efp_groups = [                     // family parts which are using "groups" and "labels"
            'co_parents_in_law',
            'siblings',
            'siblings_in_law',
            'nephews_and_nieces',
            'children',
            'children_in_law',
            'grandchildren',
        ];
        $found = false;
        //if ($groupName == '') {
        //    echo 'Soll ' . $individual->xref() . ' der Familie ' . $family->xref() . ' hinzugefügt werden? ';
        //} else {
        //    echo 'Soll ' . $individual->xref() . ' der Gruppe "' . $groupName . '" hinzugefügt werden? ';
        //}
        foreach ($extendedFamilyPart->groups as $i => $groupObj) {                      // check if individual is already a member of this part of the exetnded family   
            //echo 'Teste groups Nr. ' . $i . ': ';
            foreach ($groupObj->members as $member) {
                //echo 'Teste member = ' . $member->xref() . ': ';
                if ($member->xref() == $individual->xref()) {
                    $found = true;
                    //echo 'Person ' . $individual->xref() . ' ist bereits in group-Objekt für Familie ' . $groupObj->family->xref() . ' vorhanden. ';
                    break;
                }
            }
        }
        
        if (!$found) {                                                                  // individual has to be added 
            if ( $groupName == '' ) {
                foreach ($extendedFamilyPart->groups as $famkey => $groupObj) {         // check if this family is already stored in this part of the extended family
                    if ($groupObj->family->xref() == $family->xref()) {                 // family exists already    
                        //echo 'famkey in bereits vorhandener Familie: ' . $famkey . ' (Person ' . $individual->xref() . ' in Objekt für Familie ' . $extendedFamilyPart->groups[$famkey]->family->xref() . '); ';
                        $extendedFamilyPart->groups[$famkey]->members[] = $individual;
                        if ( in_array($extendedFamilyPart->partName, $efp_groups) ) {
                            $extendedFamilyPart->groups[$famkey]->labels[] = $this->getChildLabel($individual);
                            $extendedFamilyPart->groups[$famkey]->families[] = $family;
                            $extendedFamilyPart->groups[$famkey]->familiesStatus[] = $this->getFamilyStatus($family);
                            $extendedFamilyPart->groups[$famkey]->referencePersons[] = $referencePerson;
                        }
                        $found = true;
                        break;
                    }
                }
            } elseif ( array_key_exists($groupName, $extendedFamilyPart->groups) ) {
                //echo 'In bereits vorhandener Gruppe "' . $groupName . '" Person ' . $individual->xref() . ' hinzugefügt. ';
                $extendedFamilyPart->groups[$groupName]->members[] = $individual;
                if ( in_array($extendedFamilyPart->partName, $efp_groups) ) {
                    $extendedFamilyPart->groups[$groupName]->labels[] = $this->getChildLabel($individual);
                    $extendedFamilyPart->groups[$groupName]->families[] = $family;
                    $extendedFamilyPart->groups[$groupName]->familiesStatus[] = $this->getFamilyStatus($family);
                    $extendedFamilyPart->groups[$groupName]->referencePersons[] = $referencePerson;
                }
                $found = true;
            }
            if (!$found) {                                                              // individual not found and family not found
                $newObj = (object)[];
                $newObj->family = $family;
                $newObj->members[] = $individual;
                if ( in_array($extendedFamilyPart->partName, $efp_groups) ) {
                    $newObj->labels[] = $this->getChildLabel($individual);
                    $newObj->families[] = $family;
                    $newObj->familiesStatus[] = $this->getFamilyStatus($family);
                    $newObj->referencePersons[] = $referencePerson;
                }
                if ( $extendedFamilyPart->partName == 'parents_in_law' ) {
                    $newObj->familyStatus = $this->getFamilyStatus($family);
                    foreach ($family->spouses() as $spouse) {                           // find spouse in family which is not equal to proband
                        if ( $spouse->xref() !== $referencePerson->xref() ) {
                            $newObj->partner = $spouse;
                            break;
                        }
                    }
                } elseif ( $groupName !== '' ) {
                    $newObj->groupName = $groupName;
                }
                if ($groupName == '') {
                    $extendedFamilyPart->groups[] = $newObj;
                    //echo 'Neu hinzugefügte Familie Nr. ' . count($extendedFamilyPart->groups)-1 . ' (Person ' . $individual->xref() . ' in Objekt für Familie ' . $extendedFamilyPart->groups[$count]->family->xref() . '); ';
                } else {
                    $extendedFamilyPart->groups[$groupName] = $newObj;
                    //echo 'Neu hinzugefügte Gruppe "' . $groupName . '" (Person ' . $individual->xref() . '). ';
                }
            }
        }
        
        return;
    }

   /**
    * add an individual to the extended family 'partners' if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family
    * @param individual spouse to which these partners are belonging
    */
    private function addIndividualToDescendantsFamilyAsPartner(Individual $individual, object $extendedFamilyPart, Individual $spouse)
    {
        $found = false;
        //echo 'Soll ' . $individual->xref() . ' als Partner von ' . $spouse->xref() . ' hinzugefügt werden? ';
        if ( array_key_exists ( $spouse->xref(), $extendedFamilyPart->groups) ) {               // check if this spouse is already stored as group in this part of the extended family   
            //echo $spouse->xref() . ' definiert bereits eine Gruppe. ';
            $efp = $extendedFamilyPart->groups[$spouse->xref()];
            foreach ($efp->members as $member) {                                                // check if individual is already a partner of this partner   
                //echo 'Teste Ehepartner ' . $member->xref() . ' in Gruppe für ' . $spouse->xref() . ': ';
                if ( $individual->xref() == $member->xref() ) {
                    $found = true;
                    //echo 'Person ' . $individual->xref() . ' ist bereits als Partner von ' . $spouse->xref() . ' vorhanden. ';
                    break;
                }
            }
            if ( !$found ) {                                                                    // add individual to existing partner group
                //echo 'Person ' . $individual->xref() . ' wird als Partner von ' . $spouse->xref() . ' hinzugefügt. ';
                $extendedFamilyPart->groups[$spouse->xref()]->members[] = $individual;
            }
        } else {                                                                                // generate new group of partners
            $newObj = (object)[];
            $newObj->members[] = $individual;
            $newObj->partner = $spouse;
            $extendedFamilyPart->groups[$spouse->xref()] = $newObj;
            //echo 'Neu hinzugefügte Gruppe für: ' . $spouse->xref() . ' (Person ' . $individual->xref() . ' als Partner hier hinzugefügt). ';
        }
        
        return;
    }
    
   /**
    * get status of a family
    *
    * @param object family
    *
    * @return string
    */
    private function getFamilyStatus($family): string
    { 
        $event = $family->facts(['ANUL', 'DIV', 'ENGA', 'MARR'], true)->last();
        if ($event instanceof Fact) {
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
     * filter individuals and count them per family or per group and per sex
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     */
    private function filterAndAddCountersToFamilyPartObject( object $extendedFamilyPart, Individual $individual )
    {
        if ( $this->showFilterOptions() ) {
            if ($this->typeOfFamilyPart($extendedFamilyPart->partName) == self::ANCESTORS) {
                $this->filterAncestors($extendedFamilyPart);
            } elseif ($this->typeOfFamilyPart($extendedFamilyPart->partName) == self::DESCENDANTS) {
                $this->filterDescendants($extendedFamilyPart, $individual);
            }
        }
        if ($extendedFamilyPart->partName == 'partner_chains') {
            $extendedFamilyPart->displayChains = $this->get_display_object_partner_chains($individual, $extendedFamilyPart);
        }
        $this->addCountersToFamilyPartObject( $extendedFamilyPart );
        return;
    }

    /**
     * count individuals per family (maybe including mother/father/motherAndFather families) or per group and per sex
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     */
    private function addCountersToFamilyPartObject( object $extendedFamilyPart )
    {
        
        if ($this->typeOfFamilyPart($extendedFamilyPart->partName) == self::ANCESTORS) {
            $extendedFamilyPart->fathersFamilyCount = count( $extendedFamilyPart->families->fatherFamily );
            $extendedFamilyPart->mothersFamilyCount = count( $extendedFamilyPart->families->motherFamily );
            $extendedFamilyPart->fathersAndMothersFamilyCount = count( $extendedFamilyPart->families->fatherAndMotherFamily );
            
            $count = $this->countMaleFemale( $extendedFamilyPart->families->fatherFamily );
            $extendedFamilyPart->fathersMaleCount = $count->male;
            $extendedFamilyPart->fathersFemaleCount = $count->female;
                                  
            $count = $this->countMaleFemale( $extendedFamilyPart->families->motherFamily );
            $extendedFamilyPart->mothersMaleCount = $count->male;
            $extendedFamilyPart->mothersFemaleCount = $count->female;
                                              
            $count = $this->countMaleFemale( $extendedFamilyPart->families->fatherAndMotherFamily );
            $extendedFamilyPart->fathersAndMothersMaleCount = $count->male;
            $extendedFamilyPart->fathersAndMothersFemaleCount = $count->female;

            $extendedFamilyPart->maleCount = $extendedFamilyPart->fathersMaleCount + $extendedFamilyPart->mothersMaleCount + $extendedFamilyPart->fathersAndMothersMaleCount;
            $extendedFamilyPart->femaleCount = $extendedFamilyPart->fathersFemaleCount + $extendedFamilyPart->mothersFemaleCount + $extendedFamilyPart->fathersAndMothersFemaleCount;
            $extendedFamilyPart->allCount = $extendedFamilyPart->fathersFamilyCount + $extendedFamilyPart->mothersFamilyCount + $extendedFamilyPart->fathersAndMothersFamilyCount;
        } elseif ($this->typeOfFamilyPart($extendedFamilyPart->partName) == self::DESCENDANTS) {
            list ( $countMale, $countFemale, $countOthers ) = [0, 0 , 0];
            if ( $extendedFamilyPart->partName == 'partner_chains' ) {
                $counter = $this->countMaleFemaleMarriageChain( $extendedFamilyPart->chains );
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
                    $count = $this->countMaleFemale( $extendedFamilyPart->groups[array_key_first($extendedFamilyPart->groups)]->members );
                    $extendedFamilyPart->pmaleCount = $count->male;
                    $extendedFamilyPart->pfemaleCount = $count->female;
                    $extendedFamilyPart->pCount = $count->male + $count->female + $count->unknown_others;
                    $extendedFamilyPart->popmaleCount = $extendedFamilyPart->maleCount - $count->male;
                    $extendedFamilyPart->popfemaleCount = $extendedFamilyPart->femaleCount - $count->female;
                    $extendedFamilyPart->popCount = $extendedFamilyPart->allCount - $extendedFamilyPart->pCount;
                } elseif ( $extendedFamilyPart->partName == 'partner_chains' ) {
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
            }
        }
        
        return;
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
     * count male and female individuals in marriage chains
     *
     * @param array of marriage chain nodes
     *
     * @return object
     */
    private function countMaleFemaleMarriageChain(array $chains): object
    { 
        $mfu = (object)[];
        list ( $mfu->male, $mfu->female, $mfu->unknown_others ) = [0, 0, 0];
        list ( $countMale, $countFemale, $countOthers ) = [0, 0, 0];
        foreach ($chains as $chain) {
            $this->countMaleFemaleMarriageChainRecursive( $chain, $mfu );
            $countMale += $mfu->male;
            $countFemale += $mfu->female;
            $countOthers += $mfu->unknown_others;
        }
        return $mfu;
    }   

    /**
     * count male and female individuals in marriage chains
     *
     * @param array of marriage chain nodes
     * @param object counter for sex of individuals (modified by function)
     */
    private function countMaleFemaleMarriageChainRecursive(object $node, object &$mfu)
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
                $this->countMaleFemaleMarriageChainRecursive($chain, $mfu);
            }   
        }
        return;
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
        return;
    }

    /**
     * filter individuals in family parts of type ANCESTORS
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     */
    private function filterAncestors( object $extendedFamilyPart )
    {
        list ($filterDead, $filterSex ) = $this->filterOptions();
        if ( ($filterDead !== 'all') || ($filterSex !== 'all') ) {
            /*
            foreach ( $extendedFamilyPart->families as $familypart) {
                foreach ($familypart as $key => $member) {
                    if ( ($filterDead == 'only_alive' && $member->isDead()) || ($filterDead == 'only_dead' && !$member->isDead()) ||
                         ($filterSex == 'only_M' && $member->sex() !== 'M') || ($filterSex == 'only_F' && $member->sex() !== 'F') || ($filterSex == 'only_U' && $member->sex() !== 'U') ) {
                        unset($familypart[$key]);
                    }
                }
            }
            */
            foreach ($extendedFamilyPart->families->fatherFamily as $key => $member) {
                if ( ($filterDead == 'only_alive' && $member->isDead()) || ($filterDead == 'only_dead' && !$member->isDead()) ||
                     ($filterSex == 'only_M' && $member->sex() !== 'M') || ($filterSex == 'only_F' && $member->sex() !== 'F') || ($filterSex == 'only_U' && $member->sex() !== 'U') ) {
                    unset($extendedFamilyPart->families->fatherFamily[$key]);
                }
            }
            foreach ($extendedFamilyPart->families->motherFamily as $key => $member) {
                if ( ($filterDead == 'only_alive' && $member->isDead()) || ($filterDead == 'only_dead' && !$member->isDead()) ||
                     ($filterSex == 'only_M' && $member->sex() !== 'M') || ($filterSex == 'only_F' && $member->sex() !== 'F') || ($filterSex == 'only_U' && $member->sex() !== 'U') ) {
                    unset($extendedFamilyPart->families->motherFamily[$key]);
                }
            }
            foreach ($extendedFamilyPart->families->fatherAndMotherFamily as $key => $member) {
                if ( ($filterDead == 'only_alive' && $member->isDead()) || ($filterDead == 'only_dead' && !$member->isDead()) ||
                     ($filterSex == 'only_M' && $member->sex() !== 'M') || ($filterSex == 'only_F' && $member->sex() !== 'F') || ($filterSex == 'only_U' && $member->sex() !== 'U') ) {
                    unset($extendedFamilyPart->families->fatherAndMotherFamily[$key]);
                }
            }
        }
        return;
    }

    /**
     * filter individuals in family parts of type DESCENDANTS
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param individual (proband)
     */
    private function filterDescendants( object $extendedFamilyPart, Individual $individual )
    {
        list ($filterDead, $filterSex ) = $this->filterOptions();
        if ( ($filterDead !== 'all') || ($filterSex !== 'all') ) {
            if ($extendedFamilyPart->partName == 'partner_chains') {
                foreach($extendedFamilyPart->chains as $chain) {
                    $this->filterPartnerChainsRecursive($chain);
                }
            } else {
                foreach ($extendedFamilyPart->groups as $group) {
                    foreach ($group->members as $key => $member) {
                        if ( ($filterDead == 'only_alive' && $member->isDead()) || ($filterDead == 'only_dead' && !$member->isDead()) ||
                             ($filterSex == 'only_M' && $member->sex() !== 'M') || ($filterSex == 'only_F' && $member->sex() !== 'F') || ($filterSex == 'only_U' && $member->sex() !== 'U') ) {
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
     * filter individuals in family parts of type DESCENDANTS
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     */
    private function filterPartnerChainsRecursive( object $node )
    {
        list ($filterDead, $filterSex ) = $this->filterOptions();
        if ( ($filterDead !== 'all') || ($filterSex !== 'all') ) {
            if ($node && $node->indi instanceof Individual) {
                if ( $filterDead == 'only_alive' && $node->indi->isDead() ) {
                    $node->filterComment = I18N::translate('a dead person');
                } elseif ( $filterDead == 'only_dead' && !$node->indi->isDead() ) {
                    $node->filterComment = I18N::translate('a living person');
                }
                if ($node->filterComment == '') {
                    if ( $filterSex == 'only_M' && $node->indi->sex() !== 'M' ) {
                        $node->filterComment = I18N::translate('not a male person');
                    } elseif ( $filterSex == 'only_F' && $node->indi->sex() !== 'F' ) {
                        $node->filterComment = I18N::translate('not a female person');
                    } elseif ( $filterSex == 'only_U' && $node->indi->sex() !== 'U' ) {
                        $node->filterComment = I18N::translate('not a person of unknown gender');
                    }
                }
                foreach ($node->chains as $chain) {
                    $this->filterPartnerChainsRecursive($chain);
                }
            }
        }
        return;
    }

    /**
     * option to filter [all, only_M, only_F, only_U]
     *
     * @return string
     */
    private function filterOptionSex(): string
    {
        switch ($this->getPreference('filter_sex', '0')) {
            case '1':
                return 'only_M';
            case '2':
                return 'only_F';
            case '3':
                return 'only_U';
            case '0':
            default:
                return 'all';
        }
    }

    /**
     * option to filter [all, only_dead, only_alive]
     *
     * @return string
     */
    private function filterOptionDead(): string
    {
        switch ($this->getPreference('filter_dead_alive', '0')) {
            case '1':
                return 'only_dead';
            case '2':
                return 'only_alive';
            case '0':
            default:
                return 'all';
        }
    }

    /**
     * option to filter
     *
     * @return array [dead, sex]
     */
    private function filterOptions(): array
    {
        return [
            $this->filterOptionDead(),
            $this->filterOptionSex(),
        ];
    }

    /**
     * build object to display all partner chains
     *
     * @param individual
     * @param extended family part object
     *
     * @return array
     */
    private function get_display_object_partner_chains(Individual $individual, object $efp): array
    {      
        $chains = [];                                                           // array of chain (chain is an array of chainPerson) 
        
        $chain_string = '0§1§' . $individual->fullname() . '§' . $individual->url() . '∞';
        foreach($efp->chains as $chain) {
            $i = 1;
            $this->string_partner_chains_recursive($chain, $chain_string, $i);
        }
        do {                                                                    // remove redundant recursion back step indicators
            $chain_string = str_replace("||", "|", $chain_string, $count);
        } while ($count > 0);
        $chainString = rtrim($chain_string,'|§∞ ');
        //echo "chainString=" . $chainString . ". ";
        $chainStrings = explode('|', $chain_string);
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
     * @param string modified in function
     * @param int recursion step modified in function
     */
    private function string_partner_chains_recursive(object $node, string &$chain_string, int &$i)
    {      
        if ($node && $node->indi instanceof Individual) {
            $chain_string .= strval($i) . '§';
            if ($node->filterComment == '') {
                $chain_string .= (($node->indi->canShow()) ? '1' : '0') . '§' . $node->indi->fullname() . '§' . $node->indi->url() . '∞';
            } else {
                $chain_string .= '0§' . $node->filterComment . '§∞';
            }
            foreach($node->chains as $chain) {
                $i++;
                $this->string_partner_chains_recursive($chain, $chain_string, $i);
            }
        }
        $i--;
        $chain_string = rtrim($chain_string, '∞') . '|';
        return;
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
     * generate a label for a child
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function getChildLabel(Individual $individual): string
    {
        if ( $individual->childFamilies()->first() ) {
            if (preg_match('/\n1 FAMC @' . $individual->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $individual->gedcom(), $match)) {
                // a specified pedigree
                return GedcomCodePedi::getValue($match[1],$individual->getInstance($individual->xref(),$individual->tree()));
            }
        }

        // default (birth) pedigree
        return GedcomCodePedi::getValue('',$individual->getInstance($individual->xref(),$individual->tree()));
    }

    /**
     * size for thumbnails W
     *
     * @return int
     */
    public function getSizeThumbnailW(): int
    {
        return 33;
    }

    /**
     * size for thumbnails H
     *
     * @return int
     */
    public function getSizeThumbnailH(): int
    {
        return 50;
    }
    
    /**
     * generate list of other preferences (control panel options beside the options related to the extended family parts itself)
     *
     * @return array of string
     */
    public function listOfOtherPreferences(): array
    {
        return [
            'show_filter_options',
            'filter_sex',
            'filter_dead_alive',
            'show_empty_block',
            'show_short_name',
            'show_labels',
            'use_compact_design',
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
     * @return array of ordered objects 
     */
    public function showFamilyParts(): array
    {    
        $lofp = $this->listOfFamilyParts();
        $order_default = implode(",", $lofp);
        $order = explode(',', $this->getPreference('order', $order_default));
        
        if (count($lofp) > count($order)) {                                 // there are new parts of extended family defined
            foreach ($lofp as $fp) {
                if (!in_array($fp, $order)) {
                    $order[] = $fp;
                }
            }
        }
        
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
     * should filter options be shown (user can filter by gender or alive/dead)
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool 
     */
    public function showFilterOptions(): bool
    {
        return ($this->getPreference('show_filter_options', '0') == '0') ? true : false;
    }

    /**
     * how should empty parts of the extended family be presented
     * set default values in case the settings are not stored in the database yet
     *
     * @return string 
     */
    public function showEmptyBlock(): string
    {
        return $this->getPreference('show_empty_block', '0');
    }

    /**
     * should a short name of proband be shown
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool 
     */
    public function showShortName(): bool
    {
        return ($this->getPreference('show_short_name', '0') == '0') ? true : false;
    }
        
    /**
     * should a label be shown
     * labels are shown for special situations like:
     * person: adopted person
     * siblings and children: adopted or foster child
     *
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool 
     */
    public function showLabels(): bool
    {
        return ($this->getPreference('show_labels', '0') == '0') ? true : false;
    }

    /**
     * use compact design for individual blocks or show additional information (photo, birth and death information)
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool 
     */
    public function useCompactDesign(): bool
    {
        return ($this->getPreference('use_compact_design', '0') == '0') ? true : false;
    }

    /**
     * get preference in tis tree to show thumbnails
     * @param $tree
     *
     * @return bool 
     */
    public function get_tree_preference_show_thumbnails(object $tree): bool
    {
        return ($tree->getPreference('SHOW_HIGHLIGHT_IMAGES') == '1') ? true : false;
    }

    /**
     * show thumbnail if compact design is not selected and if global preference allows to show thumbnails
     * @param $tree
     *
     * @return bool 
     */
    public function showThumbnail(object $tree): bool
    {
        return (!$this->useCompactDesign() && $this->get_tree_preference_show_thumbnails( $tree ));
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
            case 'partner_chains':
                return I18N::translate('Partner chains');
            case 'nephews_and_nieces':
                return I18N::translate('Nephews and Nieces');
            default:
                return I18N::translate(ucfirst(str_replace('_', '-', $type)));
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
            case 'es':
                return $this->spanishTranslations();
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
            'In which sequence should the parts of the extended family be shown?' => 'V jakém pořadí se části širší rodiny zobrazí?',
            'Family part' => 'Část rodiny',
            'Show name of proband as short name or as full name?' => 'Má se jméno probanta zobrazit jako zkrácené jméno, nebo jako úplné jméno?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Za zkrácené probantovo jméno se vezme domácké jméno nebo přezdívka. Pokud neexistuje, vezme se první křestní jméno, je-li k dispozici. Pokud ani to ne, vezme se příjmení.',
            'Show short name' => 'Zobrazit zkrácené jméno',
            'How should empty parts of extended family be presented?' => 'Jak se mají zobrazit prázdné části (bloky) širší rodiny?',
            'Show empty block' => 'Zobrazit prázdné bloky',
            'yes, always at standard location' => 'ano, vždy na obvyklém místě',
            'no, but collect messages about empty blocks at the end' => 'ne, ale uvést prázdné bloky na konci výpisu',
            'never' => 'nikdy',
            'Use the compact design?' => 'Má se použít kompaktní vzhled?',
            'Use the compact design' => 'Použít kompaktní vzhled',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'V kompaktním vzhledu se u osob zobrazuje jen jméno a životní letopočty. V obohaceném vzhledu se zobrazí také foto (pokud je pro daný strom aktivováno) a údaje o narození a úmrtí.',
            
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
            '%s has one parent recorded.' => '%s má jednoho rodiče.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s má %1$d matku.' . I18N::PLURAL . '%2$s má %1$d matky.' . I18N::PLURAL . '%2$s má %1$d matek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s má %1$d otce.' . I18N::PLURAL . '%2$s má %1$d otce.' . I18N::PLURAL . '%2$s má %1$d otců.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s má %1$d otce a ' . I18N::PLURAL . '%2$s má %1$d otce a ' . I18N::PLURAL . '%2$s má %1$d otců a ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d matku (celkem %d).' . I18N::PLURAL . '%d matky (celkem %d).' . I18N::PLURAL . '%d matek (celkem %d).',

            'Parents-in-law' => 'Tcháni a tchyně',
            '%s has no parents-in-law recorded.' => '%s zde nemá žádného tchána ani tchyni.',
            '%s has one mother-in-law recorded.' => '%s má jednu tchyni.',
            '%s has one father-in-law recorded.' => '%s má jednoho tchána.',
            '%s has one parent-in-law recorded.' => '%s má jednoho tchána či tchyni.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.' => '%2$s má %1$d tchyni.' . I18N::PLURAL . '%2$s má %1$d tchyně.' . I18N::PLURAL . '%2$s má %1$d tchyní.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.' 
                => '%2$s má %1$d tchána.' . I18N::PLURAL . '%2$s má %1$d tchány.' . I18N::PLURAL . '%2$s má %1$d tchánů.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s má %1$d tchána a ' . I18N::PLURAL . '%2$s má %1$d tchány a ' . I18N::PLURAL . '%2$s má %1$d tchánů a ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d tchyni (celkem %d).' . I18N::PLURAL . '%d tchyně (celkem %d).' . I18N::PLURAL . '%d tchyní (celkem %d).',

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
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' => '%2$s má %1$d sestru.' . I18N::PLURAL . '%2$s má %1$d sestry.' . I18N::PLURAL . '%2$s má %1$d sester.',
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
			'Show options to filter the results (gender and alive/dead)?' => 'Optionen zum Filtern der Ergebnisse anzeigen (Geschlecht und lebend/tot)?',
            'Show filter options' => 'Zeige Filteroptionen',
            'Filter results (should be made available to be used by user instead of admin):' => 'Filtere die Ergebnisse (sollte zur Verwendug durch die Nutzer statt durch den Administrator bereit gestellt werden)',
            'Filter by gender' => 'Filtere nach Geschlecht',
            'Filter by alive/dead' => 'Filtere nach lebend/verstorben',
            'How should empty parts of extended family be presented?' => 'Wie sollen leere Teile der erweiterten Familie angezeigt werden?',
			'Show empty block' => 'Zeige leere Familienteile',
			'yes, always at standard location' => 'ja, immer am normalen Platz',
			'no, but collect messages about empty blocks at the end' => 'nein, aber sammle Nachrichten über leere Familienteile am Ende',
			'never' => 'niemals',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Der Kurzname basiert auf dem Rufnamen oder dem Spitznamen des Probanden. Falls diese nicht vorhanden sind, wird der erste der Vornamen verwendet, sofern ein solcher angegeben ist. Andernfalls wird der Nachname verwendet.',
            'Show short name' => 'Zeige die Kurzform des Namens',
            'Show labels in special situations?' => 'Sollen in besonderen Situationen Etiketten gezeigt werden?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Etiketten werden beispielsweise für Adoptivpersonen oder Pflegekinder verwendet. ',
            'Show labels' => 'Zeige Etiketten',
            'Use the compact design?' => 'Soll das kompakte Design verwendet werden?',
            'Use the compact design' => 'Kompaktes Design anwenden',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Das kompakte Design zeigt für jede Person nur den Namen und die Lebensspanne. Das angereicherte Design zeigt zusätzlich ein Foto (wenn dies für diesen Baum aktiviert ist) sowie Geburts- und Sterbeinformationen.',

            'don\'t use this filter' => 'verwende diesen Filter nicht',
            'show only male persons' => 'zeige nur männliche Personen',
            'show only female persons' => 'zeige nur weibliche Personen',
            'show only persons of unknown gender' => 'zeige nur Personen unbekannten Geschlechts',
            'show only alive persons' => 'zeige nur Personen, die noch leben',
            'show only dead persons' => 'zeige nur Personen, die bereits verstorben sind',
            'alive' => 'lebend',
            'dead' => 'verstorben',
            'a dead person' => 'eine verstorbende Person',
            'a living person' => 'eine lebende Person',
            'not a male person' => 'keine männliche Person',
            'not a female person' => 'keine weibliche Person',
            'not a person of unknown gender' => 'keine Person unbekannten Geschlechts',

            'Marriage' => 'Ehe',
            'Ex-marriage' => 'Geschiedene Ehe',
            'Partnership' => 'Partnerschaft',
            'Fiancée' => 'Verlobung',
            ' with ' => ' mit ',
            'Co-parents-in-law of biological children' => 'Gegenschwiegereltern der biologischen Kinder',
            'Co-parents-in-law of stepchildren' => 'Gegenschwiegereltern der Stiefkinder',
            'Full siblings' => 'Vollbürtige Geschwister',
            'Half siblings' => 'Halbbürtige Geschwister',
            'Stepsiblings' => 'Stiefgeschwister',
            'Siblings of partners' => 'Geschwister der Partner',
            'Partners of siblings' => 'Partner der Geschwister',
            'Children of siblings' => 'Kinder der Geschwister',
            'Siblings\' stepchildren' => 'Stiefkinder der Geschwister',
            'Children of siblings of partners' => 'Kinder der Geschwister der Partner',
            'Biological children' => 'Biologische Kinder',
            'Stepchildren' => 'Stiefkinder',
            'Stepchild' => 'Stiefkind',
            'Stepson' => 'Stiefsohn',
            'Stepdaughter' => 'Stieftochter',
            'Partners of biological children' => 'Partner der biologischen Kinder',
            'Partners of stepchildren' => 'Partner der Stiefkinder',
            'Biological grandchildren' => 'Biologische Enkelkinder',
            'Stepchildren of children' => 'Stiefkinder der Kinder',
            'Children of stepchildren' => 'Kinder der Stiefkinder',
            'Stepchildren of stepchildren' => 'Stiefkinder der Stiefkinder',

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
            
            'Parents-in-law' => 'Schwiegereltern',
            '%s has no parents-in-law recorded.' => 'Für %s sind keine Schwiegereltern verzeichnet.',
            '%s has one mother-in-law recorded.' => 'Für %s ist eine Schwiegermutter verzeichnet.',
            '%s has one father-in-law recorded.' => 'Für %s ist ein Schwiegervater verzeichnet.',
            '%s has one parent-in-law recorded.' => 'Für %s ist ein Schwiegerelternteil verzeichnet.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegermutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegermütter verzeichnet.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegervater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerväter verzeichnet.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => 'Für %2$s sind %1$d Schwiegervater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerväter und ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d Schwiegermutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegermütter verzeichnet (insgesamt %d).',
 
            'Co-parents-in-law' => 'Gegenschwiegereltern',
            '%s has no co-parents-in-law recorded.' => 'Für %s sind keine Gegenschwiegereltern verzeichnet.',
            '%s has one co-mother-in-law recorded.' => 'Für %s ist eine Gegenschwiegermutter verzeichnet.',
            '%s has one co-father-in-law recorded.' => 'Für %s ist ein Gegenschwiegervater verzeichnet.',
            '%s has one co-parent-in-law recorded.' => 'Für %s ist ein Gegenschwiegerelternteil verzeichnet.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => 'Für %2$s ist %1$d Gegenschwiegermutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegermütter verzeichnet.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => 'Für %2$s ist %1$d Gegenschwiegervater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegerväter verzeichnet.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => 'Für %2$s sind %1$d Gegenschwiegervater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegerväter und ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d Gegenschwiegermutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Gegenschwiegermütter verzeichnet (insgesamt %d).',
                
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
            
            'Siblings-in-law' => 'Schwäger und Schwägerinnen',
            '%s has no siblings-in-law recorded.' => 'Für %s sind weder Schwäger noch Schwägerinnen verzeichnet.',
            '%s has one sister-in-law recorded.' => 'Für %s ist eine Schwägerin verzeichnet.',
            '%s has one brother-in-law recorded.' => 'Für %s ist ein Schwager verzeichnet.',
            '%s has one sibling-in-law recorded.' => 'Für %s ist ein Schwager oder eine Schwägerin verzeichnet.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => 'Für %2$s ist %1$d Schwägerin verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwägerinnen verzeichnet.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwager verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwäger verzeichnet.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => 'Für %2$s sind %1$d Schwager und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwäger und ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d Schwägerin verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwägerinnen verzeichnet (insgesamt %d).',
            
            'Partners' => 'Partner',
            'Partner of ' => 'Partner von ',
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
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => 'Für %2$s sind %1$d Partnerin und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partnerinnen und ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d Partnerin verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen verzeichnet (insgesamt %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => 'Für %2$s sind %1$d Partner und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partner und ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d Partner von Partnerinnen verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partner von Partnerinnen verzeichnet (insgesamt %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d Partnerin von Partnern verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen von Partnern verzeichnet (insgesamt %d).',

            'Partner chains' => 'Partnerketten',
            '%s has no members of a partner chain recorded.' => 'Für %s sind keine Mitglieder einer Partnerkette verzeichnet.', 
            'There are %d branches in the partner chain. ' => 'Es gibt %d Zweige in der Partnerkette.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Der längste Zweig in der Partnerkette zu %2$s besteht aus %1$d Partnern (einschließlich %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'Der längste Zweig in der Partnerkette besteht aus %1$d Partnern (einschließlich %2$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d Partnerin in dieser Partnerkette verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen in dieser Partnerkette verzeichnet (insgesamt %d).',
            
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

            'Children-in-law' => 'Schwiegerkinder',
            '%s has no children-in-law recorded.' => 'Für %s sind keine Schwiegerkinder verzeichnet.',
            '%s has one daughter-in-law recorded.' => 'Für %s ist eine Schwiegertochter verzeichnet.',
            '%s has one son-in-law recorded.' => 'Für %s ist ein Schwiegersohn verzeichnet.',
            '%s has one child-in-law recorded.' => 'Für %s ist ein Schwiegerkind verzeichnet.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegertochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegertöchter verzeichnet.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegersohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegersöhne verzeichnet.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => 'Für %2$s sind %1$d Schwiegersohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegersöhne und ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d Schwiegertochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegertöchter verzeichnet (insgesamt %d).',
                
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
     * @return array
     */
    protected function spanishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Familia extendida',
            'A tab showing the extended family of an individual.' => 'Esta pestaña muestra todos los vinculos familiares de una persona',
            'In which sequence should the parts of the extended family be shown?' => '¿Que bloques de la familia quieres que se muestren, y en que orden, en la pestaña "Familia extendida"?',
            'Family part' => 'Bloques de la familia',
            'Show name of proband as short name or as full name?' => '¿Debe mostrarse una forma abreviada o el nombre completo de la persona que realiza la prueba?',
	        'How should empty parts of extended family be presented?' => '¿Cómo quieres que se muestren los bloques vacíos en la pestaña "Familia extendida"?',
            'Show empty block' => 'Quieres que se muestren los bloques sin infromación?',
	        'yes, always at standard location' => 'Sí, mostrar bloques sin información en su posición estándar',
	        'no, but collect messages about empty blocks at the end' => 'No mostrar bloques sin información, pero poner una descripcción de los bloques que faltan al final',
	        'never' => 'No mostrar los bloques sin información',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'El nombre corto se basa en los apodos. Si estos no están disponibles, se utiliza el primero de los nombres de pila, si se da alguno. De lo contrario, se utiliza el apellido.',
            'Show short name' => 'Mostrar nombre corto',
            'Use the compact design?' => 'Usar el diseño compacto?',
            'Use the compact design' => 'Usar el diseño compacto',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'El diseño compacto solo muestra el nombre, fecha de nacimiento y fecha de la muerte de cada persona. El diseño enriquecido también muestra una foto (si tienes fotos en el perfil de los familiares en el árbol) así como información sobre el nacimiento y la muerte.',
			
            'Marriage' => 'Matrimonio',
            'Ex-marriage' => 'Ex-matrimonio',
            'Partnership' => 'Cónyugue',
            'Fiancée' => 'Novia',
            ' with ' => ' con ',
            'Co-parents-in-law of biological children' => 'Suegros de sus hijos/as biólogicos',
            'Co-parents-in-law of stepchildren' => 'Consuegros/as de hijastros',
            'Full siblings' => 'Todos los hermanos',
            'Half siblings' => 'Cuñados y cuñadas',
            'Stepsiblings' => 'Hermanastros',
            'Siblings of partners' => 'Hermanos del cónyuge',
            'Partners of siblings' => 'Cónyugues de sus hermanos/as',
            'Children of siblings' => 'Hijos de hermanos',
            'Siblings\' stepchildren' => 'Hijastros de hermanos',
            'Children of siblings of partners' => 'Hijos de los hermanos del cónyuge',
            'Biological children' => 'Hijos biológicos',
            'Stepchildren' => 'Hijastros',
            'Stepchild' => 'Hijastras',
            'Stepson' => 'Hijastro',
            'Stepdaughter' => 'Hijastra',
            'Partners of biological children' => 'Cónyuges de los hijos biológicos',
            'Partners of stepchildren' => 'Cónyuge de hijastros',
            'Biological grandchildren' => 'Nietos biológicos',
            'Stepchildren of children' => 'Hijastros/as',
            'Children of stepchildren' => 'Hijos de hijastros/as',
            'Stepchildren of stepchildren' => 'Hijastro/a de hijastros',
            
            'He' => 'él',
            'She' => 'ella',
            'He/she' => 'él/ella',
            'Mr.' => 'Sr.',
            'Mrs.' => 'Sra.',
            'No family available' => 'No hay familia disponible',
            'Parts of extended family without recorded information' => 'Familia sin información registrada',
            '%s has no %s recorded.' => '%s no tiene %s registrados.',
            '%s has no %s, and no %s recorded.' => '%s no tiene %s ni %s registrados.',
            'Father\'s family (%d)' => 'Familia del padre (%d)',
            'Mother\'s family (%d)' => 'Familia de la madre (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familia del padre y de la Madre (%d)',

            'Grandparents' => 'Abuelos',
            '%s has no grandparents recorded.' => '%s no tiene Abuelos registrados.',
            '%s has one grandmother recorded.' => '%s tiene una Abuela registrada.',
            '%s has one grandfather recorded.' => '%s tiene un Abuelo registrado.',
            '%s has one grandparent recorded.' => '%s tiene un Abuelo registrado.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s tiene %1$d Abuela registrada.' . I18N::PLURAL . '%2$s tiene %1$d Abuelas registradas.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s tiene %1$d Abuelo registrado.' . I18N::PLURAL . '%2$s tiene %1$d Abuelos registrados.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s tiene %1$d Abuelo y ' . I18N::PLURAL . '%2$s tiene %1$d Abuelos y ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d Abuela registrada (%d en total).' . I18N::PLURAL . '%d Abuelas registrados (%d en total).',
            
            'Uncles and Aunts' => 'Tíos y Tías',
            '%s has no uncles or aunts recorded.' => '%s no tiene Tíos registrados.',
            '%s has one aunt recorded.' => '%s tiene una Tía registrados.',
            '%s has one uncle recorded.' => '%s tiene un Tío registrados.',
            '%s has one uncle or aunt recorded.' => '%s tiene un Tío o Tía registrados.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s tiene %1$d Tía registrada.' . I18N::PLURAL . '%2$s tiene %1$d Tías registradas.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s tiene %1$d Tío registrado.' . I18N::PLURAL . '%2$s tiene %1$d Tíos registrados.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
                => '%2$s tiene %1$d Tío y ' . I18N::PLURAL . '%2$s tiene %1$d Tíos y ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d Tía registrados (%d en total).' . I18N::PLURAL . '%d Tías registrados (%d en total).',

            'Parents' => 'Padres',
            '%s has no parents recorded.' => '%s no tiene Padres registrados.',
            '%s has one mother recorded.' => '%s tiene una Madre registrados.',
            '%s has one father recorded.' => '%s tiene un Padre registrados.',
            '%s has one parent recorded.' => '%s tiene uno de los Padres registrados.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s tiene %1$d Madre registrada.' . I18N::PLURAL . '%2$s tiene %1$d Madres registradas.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s tiene %1$d Padre registrado.' . I18N::PLURAL . '%2$s tiene %1$d Padres registrados.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s tiene %1$d Padre y ' . I18N::PLURAL . '%2$s tiene %1$d Padres y ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d Madre registrados (%d en total).' . I18N::PLURAL . '%d Madres registrados (%d en total).',
            
            'Parents-in-law' => 'Suegros',
            '%s has no parents-in-law recorded.' => '%s no tiene Suegros registrados.',
            '%s has one mother-in-law recorded.' => '%s tiene una Suegra registrada.',
            '%s has one father-in-law recorded.' => '%s tiene un Suegro registrado.',
            '%s has one parent-in-law recorded.' => '%s tine un suegro registrados.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s tiene %1$d Suegra registrados.' . I18N::PLURAL . '%2$s tiene %1$d Suegras registrados.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s tiene %1$d Suegro registrado.' . I18N::PLURAL . '%2$s tiene %1$d Suegros registrados.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s tiene %1$d Suegro y ' . I18N::PLURAL . '%2$s tiene %1$d Suegros y ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d Suegra registrados (%d en total).' . I18N::PLURAL . '%d Suegras registrados (%d en total).',
            
            'Co-parents-in-law' => 'Consuegros',
            '%s has no co-parents-in-law recorded.' => '%s no tiene consuegros registrados.',
            '%s has one co-mother-in-law recorded.' => '%s tiene una consuegra registrada.',
            '%s has one co-father-in-law recorded.' => '%s tiene un consuegro registrado.',
            '%s has one co-parent-in-law recorded.' => '%s tiene un consuegro o consuegra registrado/a.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s tiene %1$d Consuegra registrada.' . I18N::PLURAL . '%2$s tiene %1$d Consuegras registradas.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s tiene %1$d Consuegro registrado.' . I18N::PLURAL . '%2$s tiene %1$d Consuegros registrados.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => '%2$s tiene %1$d Consuegro y ' . I18N::PLURAL . '%2$s tiene %1$d Consuegros y ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d Consuegra registrada (%d en total).' . I18N::PLURAL . '%d Consuegras registrados (%d en total).',

            'Siblings' => 'Hermanos/as',
            '%s has no siblings recorded.' => '%s no tiene Hermanos/as registrados.',
            '%s has one sister recorded.' => '%s tiene una Hermana registrada.',
            '%s has one brother recorded.' => '%s tiene un  Hermano registrado.',
            '%s has one brother or sister recorded.' => '%s tiene un Hermano o Hermana registrados.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s tiene %1$d Hermana registrada.' . I18N::PLURAL . '%2$s tiene %1$d Hermanas registradas.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s tiene %1$d Hermano registrado.' . I18N::PLURAL . '%2$s tiene %1$d Hermanos registrados.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s tiene %1$d Hermano y ' . I18N::PLURAL . '%2$s tiene %1$d Hermanos y ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d Hermana registrados (%d en total).' . I18N::PLURAL . '%d Hermanas registrados (%d en total).',
            
            'Siblings-in-law' => 'Cuñados/as',
            '%s has no siblings-in-law recorded.' => '%s no tiene cuñados/as registrados.',
            '%s has one sister-in-law recorded.' => '%s tiene una cuñada registrada.',
            '%s has one brother-in-law recorded.' => '%s un cuñado registrado.',
            '%s has one sibling-in-law recorded.' => '%s tiene un coñado/a registrado.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s tiene %1$d Cuñada registrada.' . I18N::PLURAL . '%2$s tiene %1$d Cuñadas registradas.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s tiene %1$d Cuñado registrado.' . I18N::PLURAL . '%2$s tiene %1$d Cuñados registrados.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => '%2$s tiene %1$d Cuñado y ' . I18N::PLURAL . '%2$s tiene %1$d Cuñados y ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d Cuñada (%d en total).' . I18N::PLURAL . '%d Cuñadas registrados (%d en total).',
                            
            'Partners' => 'Cónyuge',
            'Partner of ' => 'Cónyuge de ', 
            '%s has no partners recorded.' => '%s no tiene Cónyuge registrado.',
            '%s has one female partner recorded.' => '%s tiene un Cónyuge registrado.',
            '%s has one male partner recorded.' => '%s tiene un Cónyuge registrado.',
            '%s has one partner recorded.' => '%s sólo tiene un Cónyuge registrado.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s tiene %1$d Cónyuge registrado.' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges registrados.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s tiene %1$d Cónyuge registrado.' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges registrados.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s tiene %1$d Cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges y ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d Cónyuge registrado (%d en total).' . I18N::PLURAL . '%d Cónyuges registrados (%d en total).',

            'Partner chains' => 'Partnerketten',
            '%s has no members of a partner chain recorded.' => 'Für %s sind keine Mitglieder einer Partnerkette registrado.', 
            'There are %d branches in the partner chain. ' => 'Es gibt %d Zweige in der Partnerkette.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Der längste Zweig in der Partnerkette zu %2$s besteht aus %1$d Partnern (einschließlich %3$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d Partnerin in dieser Partnerkette registrado (%d en total).' . I18N::PLURAL . '%d Partnerinnen in dieser Partnerkette registrados (%d en total).',

            'Cousins' => 'Primos y Primas', 
            '%s has no first cousins recorded.' => '%s no tiene Primos ni Primas registrados.',
            '%s has one female first cousin recorded.' => '%s tiene una Prima registrada.',
            '%s has one male first cousin recorded.' => '%s tiene un Primo registrado.',
            '%s has one first cousin recorded.' => '%s tiene un Primo o Prima registrados.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s tiene %1$d Prima registrada.' . I18N::PLURAL . '%2$s tiene %1$d Primas registradas.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s tiene %1$d Primo registrado.' . I18N::PLURAL . '%2$s tiene %1$d Primos registrados.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s tiene %1$d Primo y ' . I18N::PLURAL . '%2$s tiene %1$d Primos y ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d Prima registrados (%d en total).' . I18N::PLURAL . '%d Primas registrados (%d en total).',
                
            'Nephews and Nieces' => 'Sobrinos y Sobrinas', 
            '%s has no nephews or nieces recorded.' => '%s no tiene Sobrinos ni Sobrinas registrados.',
            '%s has one niece recorded.' => '%s tiene una Sobrina registrada.',
            '%s has one nephew recorded.' => '%s tiene un Sobrino registrado.',
            '%s has one nephew or niece recorded.' => '%s tiene una Sobrina o Sobrino registrados.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s tiene %1$d Sobrina registrada.' . I18N::PLURAL . '%2$s tiene %1$d Sobrinas registradas.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s tiene %1$d Sobrino registrado.' . I18N::PLURAL . '%2$s tiene %1$d Sobrinos registrados.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s tiene %1$d Sobrino y ' . I18N::PLURAL . '%2$s tiene %1$d Sobrinos y ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d Sobrina registrados (%d en total).' . I18N::PLURAL . '%d Sobrinas registrados (%d en total).',

            'Children' => 'Hijos/as',   
            '%s has no children recorded.' => '%s no tiene Hijos registrados.',
            '%s has one daughter recorded.' => '%s tiene una Hija registrado.',
            '%s has one son recorded.' => '%s tiene un Hijo registrado.',
            '%s has one child recorded.' => '%s tiene un Hijo o Hija registrados.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s tiene %1$d Hija registrada.' . I18N::PLURAL . '%2$s tiene %1$d Hijas registradas.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s tiene %1$d Hijo registrado.' . I18N::PLURAL . '%2$s tiene %1$d Hijos registrados.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => '%2$s tiene %1$d Hijo y ' . I18N::PLURAL . '%2$s tiene %1$d Hijos y ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d Hija registrados (%d en total).' . I18N::PLURAL . '%d Hijas registrados (%d en total).',
            
            'Children-in-law' => 'Hijos políticos',
            '%s has no children-in-law recorded.' => '%s no tienes hijos políticos registrados.',
            '%s has one daughter-in-law recorded.' => '%s tiene una hija política registrada.',
            '%s has one son-in-law recorded.' => '%s tiene un hijo político registrado.',
            '%s has one child-in-law recorded.' => '%s tiene un hijo/a político/a registrado.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s tiene %1$d Hija política registrada.' . I18N::PLURAL . '%2$s tiene %1$d Hijas políticas registradas.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s tine %1$d Hijo político registrado.' . I18N::PLURAL . '%2$s tine %1$d Hijos politicos registrados.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => '%2$s tiene %1$d Hijo político y ' . I18N::PLURAL . '%2$s tiene %1$d Hijos políticos y ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d Hijas políticas registradas (%d en total).' . I18N::PLURAL . '%d Hijas políticas registrados (%d en total).',

            'Grandchildren' => 'Nietos/as', 
            '%s has no grandchildren recorded.' => '%s no tiene Nietos registrados.',
            '%s has one granddaughter recorded.' => '%s tiene una Nieta registrada.',
            '%s has one grandson recorded.' => '%s tiene un Nieto registrado.',
            '%s has one grandchild recorded.' => '%s tiene un Nieto o Nieta registrados.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s ist %1$d Nieta registrada.' . I18N::PLURAL . '%2$s tiene %1$d Nietas registradas.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s ist %1$d Nieto registrado.' . I18N::PLURAL . '%2$s tiene %1$d Nietos registrados.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s tiene %1$d Nieto y ' . I18N::PLURAL . '%2$s tiene %1$d Nietos y ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d Nieta registrados (%d en total).' . I18N::PLURAL . '%d Nietas registrados (%d en total).',
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
            'How should empty parts of extended family be presented?' => 'Hoe moeten lege delen van de uitgebreide familie worden weergegeven?',
            'Show empty block' => 'Lege familiedelen weergeven',
            'yes, always at standard location' => 'ja, altijd op de standaardlocatie',
            'no, but collect messages about empty blocks at the end' => 'nee, maar verzamel berichten over lege familiedelen aan het eind',
            'never' => 'nooit',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'De korte naam is gebaseerd op de roepnaam of bijnaam van de proband. Als deze niet beschikbaar zijn, wordt de eerste van de voornamen gebruikt, als er een is opgegeven. Anders wordt de achternaam gebruikt.',
            'Show short name' => 'Korte naam weergeven',
            'Show labels in special situations?' => 'Labels weergeven in bijzondere situaties?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Labels worden gebruikt voor bijvoorbeeld geadopteerde personen of pleegkinderen.',
            'Show labels' => 'Labels weergeven',
            'Use the compact design?' => 'Compact ontwerp gebruiken?',
            'Use the compact design' => 'Gebruik compact ontwerp',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Het compacte ontwerp toont alleen de naam en de levensduur voor elke persoon. Het verrijkte ontwerp toont ook een foto (als dit voor deze boom is geactiveerd), en geboorte- en overlijdensinformatie',

            'Marriage' => 'Huwelijk',
            'Ex-marriage' => 'Ex-huwelijk',
            'Partnership' => 'Relatie',
            'Fiancée' => 'Verloving',
            ' with ' => ' met ',
            'Co-parents-in-law of biological children' => 'Schoonouders van biologische kinderen',
            'Co-parents-in-law of stepchildren' => 'Schoonouders van stiefkinderen',
            'Full siblings' => 'Volle broers/zussen',
            'Half siblings' => 'Halfbroers/-zussen',
            'Stepsiblings' => 'Stiefbroers/-zussen',
            'Siblings of partners' => 'Broers/zussen van partners',
            'Partners of siblings' => 'Partners van broers/zussen',
            'Children of siblings' => 'Kinderen van broers/zussen',
            'Siblings\' stepchildren' => 'Stiefkinderen van broers/zussen',
            'Children of siblings of partners' => 'Kinderen van broers/zussen van partners',
            'Biological children' => 'Biologische kinderen',
            'Stepchildren' => 'Stiefkinderen',
            'Stepchild' => 'Stiefkind',
            'Stepson' => 'Stiefzoon',
            'Stepdaughter' => 'Stiefdochter',
            'Partners of biological children' => 'Partners van biologische kinderen',
            'Partners of stepchildren' => 'Partners van stiefkinderen',
            'Biological grandchildren' => 'Biologische kleinkinderen',
            'Stepchildren of children' => 'Stiefkinderen van kinderen',
            'Children of stepchildren' => 'Kinderen van stiefkinderen',
            'Stepchildren of stepchildren' => 'Stiefkinderen van stiefkinderen',
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

            'Uncles and Aunts' => 'Ooms en tantes',
            '%s has no uncles or aunts recorded.' => 'Voor %s zijn geen ooms of tantes geregistreerd.',
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

            'Parents-in-law' => 'Schoonouders',
            '%s has no parents-in-law recorded.' => 'Voor %s zijn geen schoonouders geregistreerd.',
            '%s has one mother-in-law recorded.' => 'Voor %s is een schoonmoeder geregistreerd.',
            '%s has one father-in-law recorded.' => 'Voor %s is een schoonvader geregistreerd.',
            '%s has one parent-in-law recorded.' => 'Voor %s is een schoonouder geregistreerd.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => 'Voor %2$s is %1$d schoonmoeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonmoeders geregistreerd.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => 'Voor %2$s is %1$d schoonvader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonvaders geregistreerd.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
                => 'Voor %2$s zijn %1$d schoonvader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonvaders en ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
                => '%d schoonmoeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonmoeder geregistreerd (%d in totaal).',

            'Co-parents-in-law' => 'Ouders van schoonkinderen',
            '%s has no co-parents-in-law recorded.' => 'Voor %s zijn geen ouders van schoonkinderen geregistreerd.',
            '%s has one co-mother-in-law recorded.' => 'Voor %s is een moeder van schoonkinderen geregistreerd.',
            '%s has one co-father-in-law recorded.' => 'Voor %s is een vader van schoonkinderen geregistreerd.',
            '%s has one co-parent-in-law recorded.' => 'Voor %s is een ouder van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => 'Voor %2$s is %1$d moeder van schoonkinderen geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => 'Voor %2$s is %1$d vader van schoonkinderen geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => 'Voor %2$s zijn %1$d vader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders en ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d moeder van schoonkinderen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d moeders van schoonkinderen geregistreerd (%d in totaal).',

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

            'Siblings-in-law' => 'Zwagers en schoonzussen',
            '%s has no siblings-in-law recorded.' => 'Voor %s zijn geen zwagers of schoonzussen geregistreerd.',
            '%s has one sister-in-law recorded.' => 'Voor %s is een schoonzus geregistreerd.',
            '%s has one brother-in-law recorded.' => 'Voor %s is een zwager geregistreerd.',
            '%s has one sibling-in-law recorded.' => 'Voor %s is een zwager of schoonzus geregistreerd.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => 'Voor %2$s is %1$d schoonzus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzussen geregistreerd.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => 'Voor %2$s is %1$d zwager geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zwagers geregistreerd.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => 'Voor %2$s zijn %1$d zwager en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zwagers en ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d schoonzus geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonzussen geregistreerd (%d in totaal).',

            'Partners' => 'Partners',
            'Partner of ' => 'Partner van ',
            '%s has no partners recorded.' => 'Voor %s zijn geen partners geregistreerd.',
            '%s has one female partner recorded.' => 'Voor %s is een vrouwelijke partner geregistreerd.',
            '%s has one male partner recorded.' => 'Voor %s is een mannelijke partner geregistreerd.',
            '%s has one partner recorded.' => 'Voor %s is een partner geregistreerd.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => 'Voor %2$s is %1$d vrouwelijke partner geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vrouwelijke partners geregistreerd.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => 'Voor %2$s is %1$d mannelijke partner geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d mannelijke partners geregistreerd.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => 'Voor %2$s zijn %1$d mannelijke en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d mannelijke en ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => 'Voor %2$s zijn %1$d vrouwelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vrouwelijke partners en ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d vrouwelijke partner geregistreerd (%d in totaal).' . I18N::PLURAL . '%d vrouwelijke partners geregistreerd (%d in totaal).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => 'Voor %2$s zijn %1$d partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d partners en ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d mannelijke partner van vrouwelijke partners geregistreerd (%d in totaal).' . I18N::PLURAL . '%d mannelijke partners van vrouwelijke partners geregistreerd (%d in totaal).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d vrouwelijke partner van mannelijke partners geregistreerd (%d in totaal).' . I18N::PLURAL . '%d vrouwelijke partners van mannelijke partners geregistreerd (%d in totaal).',

            'Partner chains' => 'Partnerketens',
            '%s has no members of a partner chain recorded.' => 'Voor %s zijn geen leden van een partnerketen geregistreerd.', 
            'There are %d branches in the partner chain. ' => 'Er zijn %d takken in de partnerketen.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'De langste tak in de partnerketen naar %2$s bestaat uit %1$d partners (inclusief %3$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d vrouwelijke partner in deze partnerketen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d vrouwelijke partners in deze partnerketen geregistreerd (%d in totaal).',

            'Cousins' => 'Volle neven en nichten (kinderen van oom of tante)',
            '%s has no first cousins recorded.' => 'Voor %s zijn geen volle neven of nichten geregistreerd.',
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

            'Children-in-law' => 'Schoonkinderen',
            '%s has no children-in-law recorded.' => 'Voor %s zijn geen schoonkinderen geregistreerd.',
            '%s has one daughter-in-law recorded.' => 'Voor %s is een schoondochter geregistreerd.',
            '%s has one son-in-law recorded.' => 'Voor %s is een schoonzoon geregistreerd.',
            '%s has one child-in-law recorded.' => 'Voor %s is een schoonkind geregistreerd.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => 'Voor %2$s is %1$d schoondochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoondochters geregistreerd.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => 'Voor %2$s is %1$d schoonzoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzonen geregistreerd.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => 'Voor %2$s zijn %1$d schoonzoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzonen en ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d schoondochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoondochters geregistreerd (%d in totaal).', 

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
            '%s has one parent recorded.' => '%s má jedného rodiča.',
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
            'In which sequence should the parts of the extended family be shown?' => 'У якій послідовності будуть показані блоки розширеної сім`ї?',
            'Family part' => 'Блоки сім`ї',
            'How should empty parts of extended family be presented?' => 'Як відображати порожні блоки розширеної сім`ї?',
            'Show empty block' => 'Показати пусті блоки',
            'yes, always at standard location' => 'так, завжди на звичайному місці',
            'no, but collect messages about empty blocks at the end' => 'ні, але збирати повідомлення про порожні блоки в кінці',
            'never' => 'ніколи',
            'Show options to filter the results (gender and alive/dead)?' => 'Показати параметри фільтрації результатів (стать, живий/мертвий)?',
            'Show filter options' => 'Показати параметри фільтрації',
            'Filter results (should be made available to be used by user instead of admin):' => 'Результати фільтрації (мають бути доступними для користувача замість адміністратора):',
            'Filter by gender' => 'Фільтрувати за статтю',
            'Filter by alive/dead' => 'Фільтрувати за живими/мертвими',
	    'Show name of proband as short name or as full name?' => 'Показувати коротке чи повне ім`я об`єкту (пробанду)?',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Коротке ім`я базується на прізвиську або псевдонімі об`єкту. Якщо вони не є доступними, використовується перше з наявних імен. В іншому випадку використовується прізвище.',
            'Show short name' => 'Показати коротку форму імені',
            'Show labels in special situations?' => 'Показувати мітки для особливих ситуацій?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Мітки (або наклейки) використовуються, наприклад, для усиновлених або прийомних дітей..',
            'Show labels' => 'Показувати мітки',
            'Use the compact design?' => 'Чи використовувати компактний дизайн?',
            'Use the compact design' => 'Застосувати компактний дизайн',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Компактний дизайн показує лише ім`я та тривалість життя для кожної людини. Розширений дизайн також містить фотографію (якщо це дозволено для цього дерева), а також дати народження та смерті.',

            'don\'t use this filter' => 'не використовувати цей фільтр',
            'show only male persons' => 'показати тільки чоловіків',
            'show only female persons' => 'показати тільки фінок',
            'show only persons of unknown gender' => 'показати тільки персон з невідомою статтю',
            'show only alive persons' => 'показати тільки живих',
            'show only dead persons' => 'показати тільки померлих',
            'alive' => 'живий',
            'dead' => 'померлий',
            'a dead person' => 'жива людина',
            'a living person' => 'померла людина',
            'not a male person' => 'не є чоловіком',
            'not a female person' => 'не є жінкою',
            'not a person of unknown gender' => 'не є персоною з невідомою статтю',
		
            'Marriage' => 'Шлюб',
            'Ex-marriage' => 'Розвід',
            'Partnership' => 'Відносини',
            'Fiancée' => 'Заручини',
            ' with ' => ' із ',
            'Co-parents-in-law of biological children' => 'Свати через рідних дітей',
            'Co-parents-in-law of stepchildren' => 'Свати через прийомних дітей',
            'Biological children' => 'Рідні діти',
            'Stepchildren' => 'Прийомні діти',
            'Stepchild' => 'Прийомна дитина',
            'Stepson' => 'Пасинок',
            'Stepdaughter' => 'Падчерка',
            'Partners of biological children' => 'Пртнери рідних дітей',
            'Partners of stepchildren' => 'Партнери прийомних дітей',
            'Biological grandchildren' => 'Рідні онуки',
            'Stepchildren of children' => 'Прийомні онуки від рідних дітей',
            'Children of stepchildren' => 'Онки від прийомних дітей',
            'Stepchildren of stepchildren' => 'Прийомні онуки від прийомних дітей',
            'Full siblings' => 'Рідні брати і сестри',
            'Half siblings' => 'Напіврідні брати і сестри',
            'Stepsiblings' => 'Зведені брати і сестри',
            'Siblings of partners' => 'Брати і сестри партнерів',
            'Partners of siblings' => 'Партнери братів і сестер',
            'Children of siblings' => 'Діти братів і сестер',
            'Siblings\' stepchildren' => 'Прийомні діти братів і сестер',
            'Children of siblings of partners' => 'Діти партнерів братів і сестер',
		
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
                => '%2$s має %1$d запис бабусі.' . I18N::PLURAL . '%2$s має %1$d записи бабусь.' . I18N::PLURAL . '%2$s має %1$d записів бабусь.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' 
                => '%2$s має %1$d запис дідуся.' . I18N::PLURAL . '%2$s має %1$d записи дідусів.' . I18N::PLURAL . '%2$s має %1$d записів дідусів.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s має %1$d запис дідуся та ' . I18N::PLURAL . '%2$s має %1$d записи дідусів і ' . I18N::PLURAL . '%2$s має %1$d записів дідусів і ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d бабусю (загалом %d).' . I18N::PLURAL . '%d бабусі (загалом %d).' . I18N::PLURAL . '%d бабусь (загалом %d).',

            'Parents' => 'Батьки',
            '%s has no parents recorded.' => '%s не має жодного запису про батьків.',
            '%s has one mother recorded.' => '%s має тільки запис матері.',
            '%s has one father recorded.' => '%s має тільки запис батька.',
            '%s has one parent recorded.' => '%s має запис про одного з батьків.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s має %1$d запис про мати.' . I18N::PLURAL . '%2$s має %1$d записи про матерів.' . I18N::PLURAL . '%2$s має %1$d записів про матерів.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s має %1$d запис про батька.' . I18N::PLURAL . '%2$s має %1$d записи про батьків.' . I18N::PLURAL . '%2$s має %1$d записів про батьків.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s має %1$d запис про батька та ' . I18N::PLURAL . '%2$s має %1$d записи про батьків і ' . I18N::PLURAL . '%2$s має %1$d записів про батьків і ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d мати (загалом %d).' . I18N::PLURAL . '%d матерів (загалом %d).' . I18N::PLURAL . '%d матерів (загалом %d).',

            'Parents-in-law' => 'Тесті і свекри',
            '%s has no parents-in-law recorded.' => '%s не має жодного запису про батьків.',
            '%s has one mother-in-law recorded.' => '%s має один запис про тещу або свекруху.',
            '%s has one father-in-law recorded.' => '%s має один запис про тестя або свекра',
            '%s has one parent-in-law recorded.' => '%s має запис про одного з батьків.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s має %1$d запис про тещу або свекруху.' . I18N::PLURAL . '%2$s має %1$d записи про тещ або свекрух.' . I18N::PLURAL . '%2$s має %1$d записів про тещ або свекрух.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s має %1$d запис про тестя або свекра.' . I18N::PLURAL . '%2$s має %1$d записи про тестів або свекрів.' . I18N::PLURAL . '%2$s має %1$d записів про тестів або свекрів.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s має %1$d запис про тестя або свекра і ' . I18N::PLURAL . '%2$s має %1$d записи про тестів або свекрів і ' . I18N::PLURAL . '%2$s має %1$d записів про тестів або свекрів і ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d тещу або свекруху (загалом %d).' . I18N::PLURAL . '%d тещі або свекрухи (загалом %d).' . I18N::PLURAL . '%d тещ або свекрух (загалом %d).',

            'Co-parents-in-law' => 'Свати',
            '%s has no co-parents-in-law recorded.' => '%s не має жодного запису про сватів.',
            '%s has one co-mother-in-law recorded.' => '%s має один запис про сваху.',
            '%s has one co-father-in-law recorded.' => '%s має один запис про свата.',
            '%s has one co-parent-in-law recorded.' => '%s має один запис про свата або сваху.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s має %1$d запис про сваху.' . I18N::PLURAL . '%2$s має %1$d записи про свах.' . I18N::PLURAL . '%2$s має %1$d записів про свах.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s має %1$d запис про свата.' . I18N::PLURAL . '%2$s має %1$d записи про сватів.' . I18N::PLURAL . '%2$s має %1$d записів про сватів.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => '%2$s має %1$d запис про свата і ' . I18N::PLURAL . '%2$s має %1$d записи про сватів і ' . I18N::PLURAL . '%2$s має %1$d записів про сватів і ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d сваху (загалом %d).' . I18N::PLURAL . '%d свахи (загалом %d).' . I18N::PLURAL . '%d свах (загалом %d).',
                        
            'Uncles and Aunts' => 'Дядьки і тітки',
            '%s has no uncles or aunts recorded.' => '%s не має жодного запису про дядьків і тіток.',
            '%s has one aunt recorded.' => '%s має запис про одну тітку.',
            '%s has one uncle recorded.' => '%s має запис про одного дядька.',
            '%s has one uncle or aunt recorded.' => '%s має запис про одного дядька чи тітку.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s має %1$d запис про дядька.' . I18N::PLURAL . '%2$s має %1$d записи про дядьків.' . I18N::PLURAL . '%2$s має %1$d записів про дядьків.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s має %1$d запис про тіток.' . I18N::PLURAL . '%2$s має %1$d записи про тіток.' . I18N::PLURAL . '%2$s має %1$d записів про тіток.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s має %1$d запис про дядька та ' . I18N::PLURAL . '%2$s має %1$d записи про дядьків і ' . I18N::PLURAL . '%2$s має %1$d записів про дядьків і ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d тітку (загалом %d).' . I18N::PLURAL . '%d тіток (загалом %d).' . I18N::PLURAL . '%d тіток (загалом %d).', 

            'Siblings' => 'Брати і сестри',
            '%s has no siblings recorded.' => '%s не має жодного запису про братів і сестер.',
            '%s has one sister recorded.' => '%s має запис про одну сестру.',
            '%s has one brother recorded.' => '%s має запис про одного брата.',
            '%s has one brother or sister recorded.' => '%s має запис про одну сестру або брата.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s має %1$d запис про сестру.' . I18N::PLURAL . '%2$s має %1$d записи про сестер.' . I18N::PLURAL . '%2$s має %1$d записів про сестер.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s має %1$d запис про брата.' . I18N::PLURAL . '%2$s має %1$d записи про братів.' . I18N::PLURAL . '%2$s має %1$d записів про братів.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s має %1$d запис про брата і ' . I18N::PLURAL . '%2$s має %1$d записи про братів і ' . I18N::PLURAL . '%2$s має %1$d записів про братів і ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d сестру (загалом %d).' . I18N::PLURAL . '%d сестер (загалом %d).' . I18N::PLURAL . '%d сестер (загалом %d).',
            
            'Siblings-in-law' => 'Брати та сестри подружжя',
            '%s has no siblings-in-law recorded.' => '%s не має записів про братів і сестер партнера.',
            '%s has one sister-in-law recorded.' => '%s має запис про одну зовицю чи своячку.',
            '%s has one brother-in-law recorded.' => '%s має запис про одного дівера чи шурина.',
            '%s has one sibling-in-law recorded.' => '%s має запис про одну сестру або брата партнера.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s має %1$d запис про зовицю чи своячку.' . I18N::PLURAL . '%2$s має %1$d записи про зовиць чи своячок.' . I18N::PLURAL . '%2$s має %1$d записів про зовиць чи своячок.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s має %1$d запис про дівера чи шурина.' . I18N::PLURAL . '%2$s має %1$d записи про діверів чи шуринів.' . I18N::PLURAL . '%2$s має %1$d записів про діверів чи шуринів.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => '%2$s має %1$d запис про дівера чи шурина і ' . I18N::PLURAL . '%2$s має %1$d записи про діверів чи шуринів і ' . I18N::PLURAL . '%2$s має %1$d записів про діверів чи шуринів і ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d зовицю чи своячку (загалом %d).' . I18N::PLURAL . '%d зовиці чи своячки (загалом %d).' . I18N::PLURAL . '%d зовиць чи своячок (загалом %d).',
                                 
            'Partners' => 'Партнери',
            'Partner of ' => 'Партнер для ',
            '%s has no partners recorded.' => '%s не має жодного запису про партнерів.',
            '%s has one female partner recorded.' => '%s має запис про одну партнерку.',
            '%s has one male partner recorded.' => '%s має запис про одного партнера.',
            '%s has one partner recorded.' => '%s має запис про одного партнера.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s має %1$d запис про партнерку.' . I18N::PLURAL . '%2$s має %1$d записи про партнерок.' . I18N::PLURAL . '%2$s має %1$d записів про партнерок.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s має %1$d запис про партнера.' . I18N::PLURAL . '%2$s має %1$d записи про партнерів.' . I18N::PLURAL . '%2$s має %1$d записів про партнерів.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s має %1$d запис про партнера і ' . I18N::PLURAL . '%2$s має %1$d записи про партнерів і ' . I18N::PLURAL . '%2$s має %1$d записів про партнерів і ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => '%2$s має %1$d запис про партнерку і ' . I18N::PLURAL . '%2$s має %1$d записи про партнерок і ' . I18N::PLURAL . '%2$s має %1$d записів про партнерок і ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d партнерку (загалом %d).' . I18N::PLURAL . '%d партнерок (загалом %d).' . I18N::PLURAL . '%d партнерок (загалом %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => '%2$s має %1$d запис про партнера і ' . I18N::PLURAL . '%2$s має %1$d записи про партнерів і ' . I18N::PLURAL . '%2$s має %1$d записів про партнерів і ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d партнера для партнерок (загалом %d).' . I18N::PLURAL . '%d партнери для партнерок (загалом %d).' . I18N::PLURAL . '%d партнерів для партнерок (загалом %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d партнерку для партнерів (загалом %d).' . I18N::PLURAL . '%d партнери для партнерок (загалом %d).' . I18N::PLURAL . '%d партнерів для партнерок (загалом %d).',

            'Partner chains' => 'Низка партнерів',
            '%s has no members of a partner chain recorded.' => 'Для %s немає записів учасників для утворення низки партнерів.', 
            'There are %d branches in the partner chain. ' => 'Низка партнерів має %d відгалужень.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Найдовша гілка низки партнерів до %2$s складається з %1$d осіб (включаючи %3$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d партнерку в цій низці партнерів (загалом %d).' . I18N::PLURAL . '%d партнерки в цій низці партнерів (загалом %d).' . I18N::PLURAL . '%d партнерок в цій низці партнерів (загалом %d).',

            'Cousins' => 'Двоюрідні брати і сестри',
            '%s has no first cousins recorded.' => '%s не має жодного запису про двоюрідних братів і сестер.',
            '%s has one female first cousin recorded.' => '%s має запис про одну двоюрідну сестру.',
            '%s has one male first cousin recorded.' => '%s має запис про одного двоюрідного брата.',
            '%s has one first cousin recorded.' => '%s має запис про одного двоюрідного брата чи сестру.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s має %1$d запис про двоюрідну сестру.' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних сестер.' . I18N::PLURAL . '%2$s має %1$d записів про двоюрідних сестер.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s має %1$d запис про двоюрідного брата.' . I18N::PLURAL . '%2$s має %1$d записи про двюрідних братів.' . I18N::PLURAL . '%2$s має %1$d записів про двюрідних братів.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s має %1$d запис про двоюрідного брата і ' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних братів і ' . I18N::PLURAL . '%2$s має %1$d записів про двоюрідних братів і ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d двоюрідну сестру (загалом %d).' . I18N::PLURAL . '%d двоюрідних сестер (загалом %d).' . I18N::PLURAL . '%d двоюрідних сестер (загалом %d).',
                
            'Nephews and Nieces' => 'Племінники та племінниці',
            '%s has no nephews or nieces recorded.' => '%s не має жодного запису про племінників чи племінниць.',
            '%s has one niece recorded.' => '%s має запис про одну племінницю.',
            '%s has one nephew recorded.' => '%s має запис про одного племінника.',
            '%s has one nephew or niece recorded.' => '%s має запис про одного племінника чи племінницю.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s має %1$d запис про племінницю.' . I18N::PLURAL . '%2$s має %1$d записи про племінниць.' . I18N::PLURAL . '%2$s має %1$d записів про племінниць.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s має %1$d запис про племінника.' . I18N::PLURAL . '%2$s має %1$d записи про племінників.' . I18N::PLURAL . '%2$s має %1$d записів про племінників.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s має %1$d запис про племінника та ' . I18N::PLURAL . '%2$s має %1$d записи про племінників і ' . I18N::PLURAL . '%2$s має %1$d записів про племінників і ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d племінницю (загалом %d).' . I18N::PLURAL . '%d племінниць (загалом %d).' . I18N::PLURAL . '%d племінниць (загалом %d).',

            'Children' => 'Діти',
            '%s has no children recorded.' => '%s не має жодного запису про дітей.',
            '%s has one daughter recorded.' => '%s має запис про одну дочку.',
            '%s has one son recorded.' => '%s має запис про одного сина.',
            '%s has one child recorded.' => '%s запис про одну дитину.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s має %1$d запис про дочку.' . I18N::PLURAL . '%2$s має %1$d записи про дочок.' . I18N::PLURAL . '%2$s має %1$d записів про дочок.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s має %1$d запис про сина.' . I18N::PLURAL . '%2$s має %1$d записи про синів.' . I18N::PLURAL . '%2$s має %1$d записів про синів.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => '%2$s має %1$d запис про сина та ' . I18N::PLURAL . '%2$s має %1$d записи про синів і ' . I18N::PLURAL . '%2$s має %1$d записів про синів і ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d дочку (загалом %d).' . I18N::PLURAL . '%d дочок (загалом %d).' . I18N::PLURAL . '%d дочок (загалом %d).',

            'Children-in-law' => 'Зяті й невістки',
            '%s has no children-in-law recorded.' => '%s не має записів про зятів і невісток.',
            '%s has one daughter-in-law recorded.' => '%s має запис про одну невістку.',
            '%s has one son-in-law recorded.' => '%s має запис про одного зятя.',
            '%s has one child-in-law recorded.' => '%s має запис про одного зятя або невістку.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s має %1$d запис про невістку.' . I18N::PLURAL . '%2$s має %1$d записи про невісток.' . I18N::PLURAL . '%2$s має %1$d записів про невісток.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s має %1$d запис про зятя.' . I18N::PLURAL . '%2$s має %1$d записи про зятів.' . I18N::PLURAL . '%2$s має %1$d записів про зятів.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => '%2$s має %1$d запис про зятя і ' . I18N::PLURAL . '%2$s має %1$d записи про зятів і ' . I18N::PLURAL . '%2$s має %1$d записів про зятів і ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d невістку (загалом %d).' . I18N::PLURAL . '%d невісток (загалом %d).' . I18N::PLURAL . '%d невісток (загалом %d).',

            'Grandchildren' => 'Онуки',
            '%s has no grandchildren recorded.' => '%s не має жодного запису про онуків.',
            '%s has one granddaughter recorded.' => '%s має запис про одну онуку.',
            '%s has one grandson recorded.' => '%s має запис про одного внука.',
            '%s has one grandchild recorded.' => '%s має запис про одного внука чи онуку.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s має %1$d запис про онуку.' . I18N::PLURAL . '%2$s має %1$d записи про онук.' . I18N::PLURAL . '%2$s має %1$d записів про онук.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' 
                => '%2$s має %1$d запис про внука.' . I18N::PLURAL . '%2$s має %1$d записи про внуків.' . I18N::PLURAL . '%2$s має %1$d записів про внуків.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s має %1$d запис про внука та ' . I18N::PLURAL . '%2$s має %1$d записи про внуків і ' . I18N::PLURAL . '%2$s має %1$d записів про внуків і ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d онуку (загалом %d).' . I18N::PLURAL . '%d онуок (загалом %d).' . I18N::PLURAL . '%d онуок (загалом %d).',
        ];
    }
	
    /**
     * @return array
     */
    protected function vietnameseTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Gia đình mở rộng',
            'A tab showing the extended family of an individual.' => 'Một bảng hiển thị thêm các thành phần gia đình mở rộng của một cá nhân.',
            'In which sequence should the parts of the extended family be shown?' => 'Thứ tự các thành phần trong gia đình mở rộng được hiển thị?',
            'Family part' => 'Thành phần gia đình',
            'Show name of proband as short name or as full name?' => 'Hiển thị tên dưới dạng tên ngắn hay tên đầy đủ?',
            'Show empty block' => 'Hiển thị thành phần gia đình không có thông tin',
            'How should empty parts of extended family be presented?' => 'Các thành phần gia đình không có thông tin được trình bày như thế nào?',
            'yes, always at standard location' => 'Luôn hiển thị',
            'no, but collect messages about empty blocks at the end' => 'Không, nhưng thu thập thông báo về các khối trống ở cuối',
            'never' => 'Không hiển thị',
            'The short name is based on the probands Rufname or nickname. If these are not avaiable, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Tên viết tắt dựa hoặc biệt danh. Nếu chúng không có sẵn, tên đầu tiên trong số các tên đã cho sẽ được sử dụng, nếu một tên được đưa ra. Nếu không, họ sẽ được sử dụng.',
            'Show short name' => 'Hiển thị tên rút gọn', 
            'Show labels in special situations?' => 'Hiển thị nhãn trong các trường hợp đặc biệt?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Nhãn (hoặc nhãn dán) được sử dụng chẳng hạn cho người được nhận nuôi hoặc cha/mẹ kế. ',
            'Show labels' => 'Hiển thị nhãn dán',
            'Use the compact design?' => 'Hiển thị các thông tin rút gọn?',
            'Use the compact design' => 'Áp dụng hiển thị thông tin rút gọn',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Hiển thị rút gọn chỉ ghi tên, năm sinh năm mất cho mỗi người. Hiển thị đầy đủ sẽ bao gồm một bức ảnh (nếu điều này được kích hoạt cho cây gia đình này) cũng như thông tin về ngày sinh, nơi sinh và ngày mất, nơi mất của một cá nhân.',

            'Marriage' => 'Kết hôn',
            'Ex-marriage' => 'Kết hôn lại',
            'Partnership' => 'Quan hệ hôn nhân',
            'Fiancée' => 'Hôn ước',
            ' with ' => ' với ',
            'Co-parents-in-law of biological children' => 'Bố mẹ chồng của con đẻ',
            'Co-parents-in-law of stepchildren' => 'Bố mẹ chồng của con riêng',
            'Full siblings' => 'Anh chị em ruột',
            'Half siblings' => 'Anh chị em cùng cha khác mẹ',
            'Stepsiblings' => 'Anh chị em kế',
            'Siblings of partners' => 'Anh chị em ruột của vợ hoặc chồng',
            'Partners of siblings' => 'Vợ hoặc chồng của anh chị em ruột ',
            'Children of siblings' => 'Con của anh chị em ruột',
            'Siblings\' stepchildren' => 'Con riêng của anh chị em ruột',
            'Children of siblings of partners' => 'Con của anh chị em của đối tác',
            'Biological children' => 'Con ',
            'Stepchildren' => 'Con riêng',
            'Stepchild' => 'Con riêng',
            'Stepson' => 'Con trai riêng',
            'Stepdaughter' => 'Con gái riêng',
            'Partners of biological children' => 'Bạn đời của con ruột',
            'Partners of stepchildren' => 'Bạn đời của con riêng',			
            'Biological grandchildren' => 'Cháu ruột',
            'Stepchildren of children' => 'Cháu - con của con riêng',
            'Children of stepchildren' => 'Con của con riêng',
            'Stepchildren of stepchildren' => 'Con riêng của con riêng',

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
                => '%d bà nội.',//có thể thay bằng '%d bà nội (tổng %d).' để xem có bao nhiêu ông và bà

            'Uncles and Aunts' => 'Bác trai, bác gái, chú và cô',
            '%s has no uncles or aunts recorded.' => '%s không có thông tin về bác / cô chú.',
            '%s has one aunt recorded.' => '%s có một bác gái hoặc cô.',
            '%s has one uncle recorded.' => '%s có một bác trai hoặc chú.',
            '%s has one uncle or aunt recorded.' => '%s có một bác trai/bác gái hoặc cô/chú.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s có %1$d người là bác gái hoặc cô.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s có %1$d người là chú bác.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s có %1$d bác trai hoặc chú và ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d bác gái hoặc cô (%d người).',

            'Parents' => 'Bố mẹ',
            '%s has no parents recorded.' => '%s không có thông tin về bố mẹ.',
            '%s has one mother recorded.' => '%s có một người mẹ.',
            '%s has one father recorded.' => '%s có một người bố.',
            '%s has one grandparent recorded.' => '%s có một ông bà.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' 
                => '%2$s có %1$d người mẹ.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s có %1$d người bố.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s có %1$d người bố và ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d người mẹ.',//có thể thay bằng '%d người mẹ (tổng %d).' để xem có bao nhiêu bố, mẹ

            'Parents-in-law' => 'Bố mẹ chồng',
            '%s has no parents-in-law recorded.' => '%s không có thông tin về bố mẹ chồng.',
            '%s has one mother-in-law recorded.' => '%s có một người mẹ chồng.',
            '%s has one father-in-law recorded.' => '%s có một người bố chồng.',
            '%s has one parent-in-law recorded.' => '%s có bố mẹ chồng.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s có %1$d mẹ chồng.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s có %1$d bố chồng.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s có %1$d bố chồng và ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d mẹ chồng (tổng %d).',

            'Co-parents-in-law' => 'Thông gia',
            '%s has no co-parents-in-law recorded.' => '%s không có thông tin về gia đình thông gia.',
            '%s has one co-mother-in-law recorded.' => '%s có một bà thông gia.',
            '%s has one co-father-in-law recorded.' => '%s có một ông thông gia.',
            '%s has one co-parent-in-law recorded.' => '%s có ông bà thông gia.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s có %1$d bà thông gia.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s có %1$d ông thông gia.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => '%2$s có %1$d ông thông gia và ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d bà thông gia (tổng %d).',

            'Siblings' => 'Anh chị em ruột',
            '%s has no siblings recorded.' => '%s không có thông tin về anh chị em ruột.',
            '%s has one sister recorded.' => '%s có một chị gái hoặc em gái.',
            '%s has one brother recorded.' => '%s có một anh trai hoặc em trai.',
            '%s has one brother or sister recorded.' => '%s có môt anh em trai hoặc một chị em gái.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s có %1$d chị em gái.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s có %1$d người anh em trai.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s có %1$d anh em trai và ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d chị em gái (tổng %d).', 

            'Siblings-in-law' => 'Anh em rể và chị em dâu',
            '%s has no siblings-in-law recorded.' => '%s không có anh em rể hoặc chị em dâu.',
            '%s has one sister-in-law recorded.' => '%s có một người chị dâu hoặc em dâu.',
            '%s has one brother-in-law recorded.' => '%s có một người anh rể hoặc em rể .',
            '%s has one sibling-in-law recorded.' => '%s có một anh em rể hoặc chị em dâu.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s có %1$d chị em dâu.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s có %1$d anh em rể.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => '%2$s có %1$d anh em rể và',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d chị em dâu (tổng %d).',
                                
            'Partners' => 'Vợ chồng',
            'Partner of ' => 'Vợ (chồng) của ',
            '%s has no partners recorded.' => '%s không có thông tin về vợ/chồng.',
            '%s has one female partner recorded.' => '%s có một người vợ.',
            '%s has one male partner recorded.' => '%s có một người chồng.',
            '%s has one partner recorded.' => '%s có một vợ/chồng.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s có %1$d người vợ.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s có %1$d một người chồng.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s có %1$d một người chồng và ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => '%2$s có %1$d một người vợ và ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d một người vợ (tổng %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => '%2$s có %1$d một người vợ/chồng và ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d chồng của những người vợ (tổng %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d vợ của những người chồng (tổng %d).',

            'Partner chains' => 'Chuỗi đối tác',
            '%s has no members of a partner chain recorded.' => '%s không có thành viên nào của chuỗi đối tác.', 
            'There are %d branches in the partner chain. ' => 'Có %d nhánh trong chuỗi đối tác.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Nhánh dài nhất trong chuỗi đối tác đến %2$s bao gồm %1$d đối tác (kể cả %3$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d đối tác nữ trong chuỗi đối tác này (tổng %d).',
           
            'Cousins' => 'Anh chị em họ',
            '%s has no first cousins recorded.' => '%s không có thông tin về anh em họ.',
            '%s has one female first cousin recorded.' => '%s có một chị em họ.',
            '%s has one male first cousin recorded.' => '%s có một anh em họ.',
            '%s has one first cousin recorded.' => '%s có một anh em họ.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s có %1$d chị họ/em gái họ.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s có %1$d anh/em trai họ.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s có %1$d anh/em trai họ và ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d chị/em gái họ (tổng %d).',

            'Nephews and Nieces' => 'Cháu (Là con của anh em trai ruột)',
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

            'Children' => 'Con',
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
                => '%d con gái (tổng %d người con).',

            'Children-in-law' => 'Con dâu và con rể',
            '%s has no children-in-law recorded.' => '%s không có thông tin về con dâu và con rể.',
            '%s has one daughter-in-law recorded.' => '%s có một con dâu.',
            '%s has one son-in-law recorded.' => '%s có một con rể.',
            '%s has one child-in-law recorded.' => '%s có con dâu hoặc con rể.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s có %1$d con dâu.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s có %1$d con rể.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => '%2$s có %1$d con rể và ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d con dâu (tổng %d).',

            'Grandchildren' => 'Cháu nội',
            '%s has no grandchildren recorded.' => '%s không có thông tin về cháu.',
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
