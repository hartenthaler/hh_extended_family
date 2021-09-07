<?php
/*
 * webtrees - extended family tab
 *
 * based on vytux_cousins and simpl_cousins
 *
 * Copyright (C) 2021 Hermann Hartenthaler. All rights reserved.
 * Copyright (C) 2013 Vytautas Krivickas and vytux.com. All rights reserved. 
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
 *
 * siehe issues/enhancements in github
 *
 * Ergänzung der genetischen Nähe der jeweiligen Personengruppe in % (als Mouse-over?)
 *
 * Familiengruppe Neffen und Nichten: 2-stufig: erst Geschwister als P bzw. Partner als P, dann Eltern wie gehabt;
 * Familiengruppe Cousins: wenn sie zur Vater und Mutter-Familie gehören, werden sie falsch zugeordnet (bei P Seudo: C2)
 * Familiengruppe Schwäger und Schwägerinnen: Ergänzen der vollbürtigen Geschwister um halbbürtige und Stiefgeschwister
 * Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von Partner gemischt sein sollte
 * Familiengruppe Partnerketten: grafische Anzeige statt Textketten
 * Familiengruppe Partnerketten: von Ge. geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette von Di. zu Ga., d.h. dies als zweite Info ergänzen
 * Familiengruppe Geschwister: eventuell statt Label eigene Kategorie für Adoptiv- und Pflegekinder bzw. Stillmutter
 *
 * Label für Stiefkinder: etwa bei meinen Neffen Fabian, Felix, Jason und Sam
 * Label für Partner: neu einbauen (Ehemann/Ehefrau/Partner/Partnerin/Verlobter/Verlobte/Ex-...)
 * Label für Eltern: biologische Eltern, Stiefeltern, Adoptiveltern, Pflegeeltern
 * Label oder Gruppe bei Onkel/Tante: Halbonkel/-tante = Halbbruder/-schwester eines biologichen Elternteils
 *
 * Code: Anpassungen an Bootstrap 5 (filter-Buttons) und webtrees 2.1 (neue Testumgebung aufsetzen)
 * Code: Funktionen getSizeThumbnailW() und getSizeThumbnailH() verbessern: Option für thumbnail size? oder css für shilouette? Gibt es einen Zusammenhang oder sind sie unabhängig? Wie genau wirken sie sich aus? siehe issue von Sir Peter
 * Code: eventuell Verwendung der bestehenden Funktionen "_individuals" zum Aufbau von Familienteilen verwenden statt es jedes Mal vom Probanden aus komplett neu zu gestalten
 * Code: Ablaufreihenfolge in function addIndividualToFamily() umbauen wie function addIndividualToFamilyAsPartner()
 * Code: eigentliche Modulfunktionen nach class_extended_family_part verschieben; hier verbleiben nur die Funktionen zum Modul an sich
 * Code: Funktionen rings um das CotrolPanel und die Speicherung der Parameter in der Datenbank auslagern in eine eigene Datei
 * Code: php-Klassen-Konzept verwenden
 *
 * Test: wie verhält es sich, wenn eine Person als Kind zu zwei Familien gehört (bei P Seudo: C2)
 * Test: Stiefcousins (siehe Onkel Walter)
 * Test: Schwagerehe (etwa Levirat oder Sororat)
 *
 * andere Verwandtschaftssysteme: eventuell auch andere als nur das Eskimo-System implementieren
 * andere Verwandtschaftssysteme: Onkel als Vater- oder Mutterbruder ausweisen für Übersetzung (Label?); Tante als Vater- oder Mutterschwester ausweisen für Übersetzung (Label?);
 * andere Verwandtschaftssysteme: Brüder und Schwestern als jüngere oder ältere Geschwister ausweisen für Übersetzung (in Bezugg auf Proband) (Label?)
 *
 * neue Idee: Statistikfunktion für webtrees zur Ermittlung der längsten und der umfangreichsten Heiratsketten in einem Tree
 * neue Idee: Liste der Spitzenahnen
 * neue Idee: Kette zum entferntesten Vorfahren
 * neue Idee: Kette zum entferntesten Nachkommen
 */

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

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
use Cissee\Webtrees\Module\ExtendedRelationships;

// string functions
use function ucfirst;
use function str_replace;
use function str_contains;
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

//include ("class_extended_family_part.php");
include ("resources/lang/ExtendedFamilyTranslations.php");

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
    public const CUSTOM_VERSION = '2.0.16.49';
    public const CUSTOM_LAST = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE. '/raw/main/latest-version.txt';
    
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
    
    /* Find members of extended family parts
     *
     * @param Individual $individual
     *
     * @return object 
     */
    private function getExtendedFamily(Individual $individual): object
    {
        $obj = (object)[];
        $obj->config = $this->get_config( $individual );
        $obj->self   = $this->get_self( $individual );        
        $obj->filter = $this->getExtendedFamilyParts($obj);
        return $obj;
    }

    /**
     * get extended family parts for each filter combination
     *
     * @param object
     *
     * @return array of extended family parts for all filter combinations
     */
    private function getExtendedFamilyParts(object $obj): array
    {       
        $filter = [];
        foreach ($obj->config->filterOptions as $filterOption) {
            $extfamObj = (object)[];
            $extfamObj->efp = (object)[];
            $extfamObj->efp->allCount = 0;
            foreach ($this->showFamilyParts() as $efp => $element) {
                if ( $element->enabled ) {
                    $extfamObj->efp->$efp = $this->initializedFamilyPartObject($efp);
                    $this->callFunction1( 'get_' . $efp, $extfamObj->efp->$efp, $obj->self->indi );
                    $this->filterAndAddCountersToFamilyPartObject( $extfamObj->efp->$efp, $obj->self->indi, $filterOption );
                    $extfamObj->efp->allCount += $extfamObj->efp->$efp->allCount;
                }
            }
            $extfamObj->efp->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj, $obj->self->niceName);
            $filter[$filterOption] = $extfamObj;
        }
        return $filter;
    }

    /**
     * call functions to get extended family parts
     *
     * @param $name string (name of function to be called)
     * @param $efp extended family part (modified by function)
     * @param $individual Individual
     */   
    private function callFunction1($name, object &$extendedFamilyPart, Individual $individual)
    {
        return $this->$name($extendedFamilyPart, $individual);
    }

    /**
     * call functions to get a branch of a extended family parts
     *
     * @param $name string (name of function to be called)
     * @param $individual Individual
     * @param string $branch (e.g. ['bio', 'step', 'full', half']
     *
     * @return array of object
     */   
    private function callFunction2($name, Individual $individual, string $branch): array
    {
        return $this->$name($individual, $branch);
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
     * check if there is at least one person in one of the selected extended family parts (used to decide if tab is grayed out)
     *
     * @param individual
     *
     * @return bool
     */ 
    private function personExistsInExtendedFamily(Individual $individual): bool
    {
        $obj = (object)[];
        $obj->config = $this->get_config( $individual );
        $obj->self = $this->get_self( $individual );
        $extfamObj = (object)[];
        $extfamObj->efp = (object)[];
        $efps = $this->showFamilyParts();
        foreach ($efps as $efp => $element) {
            if ( $element->enabled ) {
                $extfamObj->efp->$efp = $this->initializedFamilyPartObject($efp);
                $this->callFunction1( 'get_' . $efp, $extfamObj->efp->$efp, $individual );
                $this->filterAndAddCountersToFamilyPartObject( $extfamObj->efp->$efp, $individual, 'all' );
                if ($extfamObj->efp->$efp->allCount >0) {
                    return true;
                }
            }
        }
        return false;
    }
     
    /**
     * get configuration information
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function get_config(Individual $individual): object
    {
        $configObj = (object)[];
        $configObj->showEmptyBlock     = $this->showEmptyBlock();
        $configObj->showLabels         = $this->showLabels();
        $configObj->useCompactDesign   = $this->useCompactDesign();
        $configObj->showThumbnail      = $this->showThumbnail( $individual->tree() );
        $configObj->showFilterOptions  = $this->showFilterOptions();
        $configObj->filterOptions      = $this->getFilterOptions();
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
        $selfObj->indi      = $individual;
        $selfObj->niceName  = $this->niceName( $individual );
        $selfObj->label     = implode(", ", $this->getChildLabels( $individual ));
        return $selfObj;
    }

    /**
     * Find grandparents
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_grandparents(object &$extendedFamilyPart, Individual $individual)
    {      
        $config = (object)[];
        $config->branches = ['bio','step'];
        $config->callFamilyPart = 'parents';
        $config->const = [
            'bio'  => ['M' => self::GROUP_GRANDPARENTS_FATHER_BIO, 'F' => self::GROUP_GRANDPARENTS_MOTHER_BIO, 'U' => self::GROUP_GRANDPARENTS_U_BIO],
            'step' => ['M' => self::GROUP_GRANDPARENTS_FATHER_STEP, 'F' => self::GROUP_GRANDPARENTS_MOTHER_STEP, 'U' => self::GROUP_GRANDPARENTS_U_STEP],
        ];
        $this->get_familyBranches($config, $extendedFamilyPart, $individual);

        // add biological parents and stepparents of stepparents
        foreach ($this->get_stepparents_individuals($individual) as $stepparentObj) {
            foreach ($this->get_bioparents_individuals($stepparentObj->indi) as $grandparentObj) {
                $this->addIndividualToFamily( $extendedFamilyPart, $grandparentObj->indi, $grandparentObj->family, self::GROUP_GRANDPARENTS_STEP_PARENTS, $stepparentObj->indi );
            }
            foreach ($this->get_stepparents_individuals($stepparentObj->indi) as $grandparentObj) {
                $this->addIndividualToFamily( $extendedFamilyPart, $grandparentObj->indi, $grandparentObj->family, self::GROUP_GRANDPARENTS_STEP_PARENTS, $stepparentObj->indi );
            }
		}
        return;
    }
    
    /**
     * Find uncles and aunts (not including uncles and aunts by marriage)
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_uncles_and_aunts(object &$extendedFamilyPart, Individual $individual)
    {
        if ($individual->childFamilies()->first()) {
            if ($individual->childFamilies()->first()->husband() instanceof Individual) {
                $this->get_uncles_and_aunts_OneSide( $extendedFamilyPart, $individual->childFamilies()->first()->husband(), self::GROUP_UNCLEAUNT_FATHER);
            }
            if ($individual->childFamilies()->first()->wife() instanceof Individual) {
                $this->get_uncles_and_aunts_OneSide( $extendedFamilyPart, $individual->childFamilies()->first()->wife(), self::GROUP_UNCLEAUNT_MOTHER);
            }
        }
        return;
    }
    
    /**
     * Find uncles and aunts for one side (husband/wife) (not including uncles and aunts by marriage)
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param Individual parent
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function get_uncles_and_aunts_OneSide(object &$extendedFamilyPart, Individual $parent, string $side)
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
        return;
    }
    
    /**
     * Find uncles and aunts by marriage
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_uncles_and_aunts_bm(object $efp, Individual $individual)
    {
        if ($individual->childFamilies()->first()) {
            if ($individual->childFamilies()->first()->husband() instanceof Individual) {
                $this->get_uncles_and_aunts_bmOneSide( $efp, $individual->childFamilies()->first()->husband(), self::GROUP_UNCLEAUNTBM_FATHER);
            }
            if ($individual->childFamilies()->first()->wife() instanceof Individual) {
                $this->get_uncles_and_aunts_bmOneSide( $efp, $individual->childFamilies()->first()->wife(), self::GROUP_UNCLEAUNTBM_MOTHER);
            }
        }
        return;
    }
    
    /**
     * Find uncles and aunts by marriage for one side
     *
     * @param object part of extended family (modified by this function)
     * @param Individual parent
     * @param string family side (FAM_SIDE_FATHER, FAM_SIDE_MOTHER); father is default
     */
    private function get_uncles_and_aunts_bmOneSide(object &$extendedFamilyPart, Individual $parent, string $side)
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
        return;
    }

    /**
     * Find parents
     *
     * @param object extended family part (modified by this function)
     * @param $individual Individual
     */
    private function get_parents(object &$extendedFamilyPart, Individual $individual)
    {            
		foreach ($this->get_bioparents_individuals($individual) as $parentObj) {
			$this->addIndividualToFamily( $extendedFamilyPart, $parentObj->indi, $parentObj->family, self::GROUP_PARENTS_BIO, $individual );
		}
        foreach ($this->get_stepparents_individuals($individual) as $stepparentObj) {
            $this->addIndividualToFamily( $extendedFamilyPart, $stepparentObj->indi, $stepparentObj->family, self::GROUP_PARENTS_STEP, $individual );
        }
        return;
    }

    /**
     * Find parents-in-law (parents of partners including partners of partners)
     *
     * @param object extended family part (modified by function)
     * @param $individual Individual
     */
    private function get_parents_in_law(object &$extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->spouseFamilies() as $family) {                                    // Gen  0 F
            foreach ($family->spouses() as $spouse) {                                           // Gen  0 P
                if ($spouse !== $individual) {
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->husband() instanceof Individual)) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $spouse->childFamilies()->first()->husband(), $spouse->childFamilies()->first(), '', $spouse, $individual );
                    }
                    if (($spouse->childFamilies()->first()) && ($spouse->childFamilies()->first()->wife() instanceof Individual)) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $spouse->childFamilies()->first()->wife(), $spouse->childFamilies()->first(), '', $spouse, $individual );
                    }
                }
            }
        }
        return;
    }

    /**
     * Find co-parents-in-law (parents of children-in-law)
     *
     * @param object extended family part (modified by this fuction)
     * @param Individual $individual
     */
    private function get_co_parents_in_law(object $extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
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
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
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
     * @param Individual $individual
     */
    private function get_partners(object $efp, Individual $individual)
    {
        foreach ($individual->spouseFamilies() as $family1) {                                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                                         // Gen  0 P
                if ( $spouse1 !== $individual ) {
                    $this->addIndividualToFamilyAsPartner( $spouse1, $efp, $individual );
                }
                foreach ($spouse1->spouseFamilies() as $family2) {                                              // Gen  0 F
                    foreach ($family2->spouses() as $spouse2) {                                                 // Gen  0 P
                        if ( $spouse2 !== $spouse1 && $spouse2 !== $individual ) {
                            $this->addIndividualToFamilyAsPartner( $spouse2, $efp, $spouse1 );
                        }
                    }
                }
            }
        }

        return;
    }

    /**
     * Find a chain of partners
     *
     * @param Individual $individual
     *
     * @param modified object extended family part
     */
    private function get_partner_chains(object &$extendedFamilyPart, Individual $individual)
    {
        $chainRootNode = (object)[];
        $chainRootNode->chains = [];
        $chainRootNode->indi = $individual;
        $chainRootNode->filterComment = '';
        
        $stop = (object)[];                                 // avoid endless loops
        $stop->indiList = [];
        $stop->indiList[] = $individual->xref();
        $stop->familyList = [];
        
        $extendedFamilyPart->chains = $this->get_partner_chains_recursive ($chainRootNode, $stop);
        return;
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
     * Find full and half siblings, as well as stepsiblings
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_siblings(object &$extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->childFamilies() as $family) {                                     // Gen  1 F
            foreach ($family->children() as $sibling_full) {                                    // Gen  0 P
                if ($sibling_full !== $individual) {
                    $this->addIndividualToFamily( $extendedFamilyPart, $sibling_full, $family, self::GROUP_SIBLINGS_FULL );
                }
            }
        }
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling_half) {                           // Gen  0 P
                        if ($sibling_half !== $individual) {
                            $this->addIndividualToFamily( $extendedFamilyPart, $sibling_half, $family1, self::GROUP_SIBLINGS_HALF );
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
                                    $this->addIndividualToFamily( $extendedFamilyPart, $sibling_step, $family1, self::GROUP_SIBLINGS_STEP );
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
     * Find siblings-in-law (partners of siblings and siblings of partners)
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_siblings_in_law(object &$extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full !== $individual) {
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
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1 !== $individual ) {
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

        return;
    }

    /**
     * Find co-siblings-in-law (partner's sibling's partner and sibling's partner's sibling)
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_co_siblings_in_law(object &$extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->children() as $sibling_full) {                                   // Gen  0 P
                if ($sibling_full !== $individual) {
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
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                if ( $spouse1 !== $individual ) {
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

        return;
    }
    
    /**
     * Find full and half cousins (children of full and half siblings of father and mother)
     *
     * @param object extended family part (modified by function)
     * @param Individual $individual
     */
    private function get_cousins(object $extendedFamilyPart, Individual $individual)
    {
        $config = (object)[];
        $config->branches = ['full','half'];
        $config->callFamilyPart = 'cousins';
        $config->const = [
            'full' => ['M' => self::GROUP_COUSINS_FULL_FATHER, 'F' => self::GROUP_COUSINS_FULL_MOTHER, 'U' => self::GROUP_COUSINS_FULL_U],
            'half' => ['M' => self::GROUP_COUSINS_HALF_FATHER, 'F' => self::GROUP_COUSINS_HALF_MOTHER, 'U' => self::GROUP_COUSINS_HALF_U],
        ];
        $this->get_familyBranches($config, $extendedFamilyPart, $individual);
        return;
    }
    
    /**
     * Find nephews and nieces
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_nephews_and_nieces(object &$extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ( $sibling !== $individual) {
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
        foreach ($individual->childFamilies() as $family1) {                                    // Gen  1 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  1 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  1 F
                    foreach ($family2->children() as $sibling) {                                // Gen  0 P
                        if ( $sibling !== $individual ) {
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
        return;
    }

    /**
     * Find children including step-children
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_children(object &$extendedFamilyPart, Individual $individual)
    {        
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $child) {                                          // Gen -1 P
                $this->addIndividualToFamily( $extendedFamilyPart, $child, $family1, self::GROUP_CHILDREN_BIO );
            }
        }
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->spouses() as $spouse1) {                                         // Gen  0 P
                foreach ($spouse1->spouseFamilies() as $family2) {                              // Gen  0 F
                    foreach ($family2->children() as $child) {                                  // Gen -1 P
                        $this->addIndividualToFamily( $extendedFamilyPart, $child, $family2, self::GROUP_CHILDREN_STEP );
                    }
                }
            }
        }
        return;
    }

    /**
     * Find children-in-law (partner of children and stepchildren)
     *
     * @param object extended family part (modified by this function)
     * @param Individual $individual
     */
    private function get_children_in_law(object &$extendedFamilyPart, Individual $individual)
    {
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
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
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
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
     * @param Individual $individual
     */
    private function get_grandchildren(object &$extendedFamilyPart, Individual $individual)
    {      
        foreach ($individual->spouseFamilies() as $family1) {                                   // Gen  0 F
            foreach ($family1->children() as $biochild) {                                       // Gen -1 P
                foreach ($biochild->spouseFamilies() as $family2) {                             // Gen -1 F
                    foreach ($family2->children() as $biograndchild) {                          // Gen -2 P
                        $this->addIndividualToFamily( $extendedFamilyPart, $biograndchild, $family1, self::GROUP_GRANDCHILDREN_BIO );
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
                                $this->addIndividualToFamily( $extendedFamilyPart, $step_child, $family1, self::GROUP_GRANDCHILDREN_STEP_CHILD );
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
                                $this->addIndividualToFamily( $extendedFamilyPart, $child_step, $family1, self::GROUP_GRANDCHILDREN_CHILD_STEP );
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
                                        $this->addIndividualToFamily( $extendedFamilyPart, $step_step, $family1, self::GROUP_GRANDCHILDREN_STEP_STEP );
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
        $efpObj->allCount = 0;
        $efpObj->groups = [];
        return $efpObj;
    }
    
    /**
     * Find individuals: biological parents (in first family)
     *
     * @param Individual
	 *
	 * @return array of object (individual, family)
     */
    private function get_bioparents_individuals(Individual $individual): array
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
    private function get_stepparents_individuals(Individual $individual): array
    {
        $stepparents = [];
        foreach ($this->get_bioparents_individuals($individual) as $parentObj) {
            foreach ($this->get_partners_individuals($parentObj->indi) as $stepparentObj) {
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
     * @param Individual
     * @param string $branch ['bio', 'step']
	 *
	 * @return array of object (individual, family)
     */
    private function get_parentsBranch_individuals(Individual $individual, string $branch): array
    {
        if ( $branch == 'bio' ) {
            return $this->get_bioparents_individuals($individual);
        } elseif ( $branch == 'step' ) {
            return $this->get_stepparents_individuals($individual);
        }
    }
    
    /**
     * Find individuals: partners
     *
     * @param Individual
	 *
	 * @return array of object (individual, family)
     */
    private function get_partners_individuals(Individual $individual): array
    {
        $spouses = [];
		foreach ($individual->spouseFamilies() as $family) {
            foreach ($family->spouses() as $spouse) {
                if ($spouse !== $individual) {
                    $obj = (object)[];
					$obj->indi = $spouse;
					$obj->family = $family;
					$spouses[] = $obj;
                }
            }
        }
        return $spouses;
    }
    
    /**
     * Find individuals: fullsiblings
     *
     * @param Individual
	 *
	 * @return array of object (individual, family)
     */
    private function get_fullsiblings_individuals(Individual $individual): array
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
    private function get_halfsiblings_individuals(Individual $individual): array
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
    private function get_cousinsBranch_individuals(Individual $parent, string $branch): array
    {            
        $cousins = [];
        foreach ((($branch == 'full')? $this->get_fullsiblings_individuals($parent): $this->get_halfsiblings_individuals($parent)) as $siblingObj) {
            foreach ($this->get_partners_individuals($siblingObj->indi) as $UncleAuntObj) {
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
     * @param Individual $individual
     */
    private function get_familyBranches(object $config, object &$extendedFamilyPart, Individual $individual)
    {      
        foreach ($config->branches as $branch) {
            foreach ($this->get_bioparents_individuals($individual) as $parentObj) {
                if ($parentObj->indi->sex() == 'M') {
                    foreach ($this->callFunction2('get_'.$config->callFamilyPart.'Branch_individuals', $parentObj->indi, $branch) as $obj) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $obj->indi, $obj->family, $config->const[$branch]['M'], $individual );
                    }
                } elseif ($parentObj->indi->sex() == 'F') {
                    foreach ($this->callFunction2('get_'.$config->callFamilyPart.'Branch_individuals', $parentObj->indi, $branch) as $obj) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $obj->indi, $obj->family, $config->const[$branch]['F'], $individual );
                    }
                } else {
                    foreach ($this->callFunction2('get_'.$config->callFamilyPart.'Branch_individuals', $parentObj->indi, $branch) as $obj) {
                        $this->addIndividualToFamily( $extendedFamilyPart, $obj->indi,  $obj->family, $config->const[$branch]['U'], $individual );
                    }
                }
            }
        }
        return;
    }
    
   /**
    * add an individual to the extended family if it is not already member of this extended family
    *
    * @param object part of extended family (modified by this function)
    * @param Individual $individual
    * @param object $family family to which this individual is belonging
    * @param (optional) string name of group
    * @param (optional) Individual reference person
    * @param (optional) Individual reference person 2
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
                    if ($referencePerson) {                                             // tbd: Logik verkehrt !!!
                        if ($this->VestaModulesAvailable(false)) {
                            $labels[] = \Cissee\Webtrees\Module\ExtendedRelationships\ExtendedRelationshipModule::getRelationshipLink($this->name(), $individual->tree(), null, $referencePerson->xref(), $individual->xref(), 4);
                            error_log("Vesta Modules available");
                        } else {
                            error_log("Vesta Modules not available");
                        }
                    }
                    */
                    $labels = array_merge($labels, $this->getChildLabels($individual));
                    $newObj->labels[] = $labels;
                    $newObj->families[] = $family;
                    $newObj->familiesStatus[] = $this->getFamilyStatus($family);
                    $newObj->referencePersons[] = $referencePerson;
                    $newObj->referencePersons2[] = $referencePerson2;
                }
                if ( $extendedFamilyPart->partName == 'grandparents' || $extendedFamilyPart->partName == 'parents' || $extendedFamilyPart->partName == 'parents_in_law' ) {
                    $newObj->familyStatus = $this->getFamilyStatus($family);
                    if ($referencePerson) {
                        $newObj->partner = $referencePerson;
                        if ($referencePerson2) {
                            foreach ($referencePerson2->spouseFamilies() as $fam) {
                                //echo "Teste Familie ".$fam->fullName().":";
                                foreach ($fam->spouses() as $partner) {
                                    if ( $partner->xref() == $referencePerson->xref() ) {
                                        //echo $referencePerson->fullName();
                                        $newObj->partnerFamilyStatus = $this->getFamilyStatus($fam);
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
                    //echo 'Neu hinzugefügte Familie Nr. ' . count($extendedFamilyPart->groups)-1 . ' (Person ' . $individual->xref() . ' in Objekt für Familie ' . $extendedFamilyPart->groups[$count]->family->xref() . '); ';
                } else {
                    $newObj->groupName = $groupName;
                    $extendedFamilyPart->groups[$groupName] = $newObj;
                    //echo 'Neu hinzugefügte Gruppe "' . $groupName . '" (Person ' . $individual->xref() . '). ';
                }
            }
        }
        
        return;
    }
    
   /**
    * add an individual to a group of the extended family
    *
    * @param object part of extended family (modified by this function)
    * @param Individual $individual
    * @param object $family family to which this individual is belonging
    * @param string name of group
    * @param (optional) Individual reference person
    * @param (optional) Individual reference person 2
    */
    private function addIndividualToGroup(object &$extendedFamilyPart, Individual $individual, object $family, string $groupName, Individual $referencePerson = null, Individual $referencePerson2 = null )
    {
        $extendedFamilyPart->groups[$groupName]->members[] = $individual;                                                                         // array of strings                                
        $extendedFamilyPart->groups[$groupName]->labels[] = $this->getChildLabels($individual);
        $extendedFamilyPart->groups[$groupName]->families[] = $family;
        $extendedFamilyPart->groups[$groupName]->familiesStatus[] = $this->getFamilyStatus($family);
        $extendedFamilyPart->groups[$groupName]->referencePersons[] = $referencePerson;
        $extendedFamilyPart->groups[$groupName]->referencePersons2[] = $referencePerson2;
        return;
    }

   /**
    * add an individual to the extended family 'partners' if it is not already member of this extended family
    *
    * @param individual
    * @param object part of extended family
    * @param individual spouse to which these partners are belonging
    */
    private function addIndividualToFamilyAsPartner(Individual $individual, object $extendedFamilyPart, Individual $spouse)
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
     * @param Individual
     * @param string filterOption
     */
    private function filterAndAddCountersToFamilyPartObject( object $extendedFamilyPart, Individual $individual, string $filterOption )
    {
        if ( $filterOption !== 'all' ) {
            $this->filter( $extendedFamilyPart, $individual, $this->filterOptions($filterOption) );
        }
        if ($extendedFamilyPart->partName == 'partner_chains') {
            $extendedFamilyPart->displayChains = $this->get_display_object_partner_chains($individual, $extendedFamilyPart);
        }
        $this->addCountersToFamilyPartObject( $extendedFamilyPart );
        return;
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
        return;
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
        return;
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
     * filter individuals in family part
     *
     * @param object part of extended family (grandparents, uncles/aunts, cousins, ...)
     * @param individual (proband)
     * @param array of string filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    private function filter( object $extendedFamilyPart, Individual $individual, $filterOptions )
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
        return;
    }

    /**
     * get list of options to filter by gender
     *
     * @return array of string
     */
    private function getFilterOptionsSex(): array
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
    private function getFilterOptionsAlive(): array
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
    private function getFilterOptions(): array
    {
        $options = [];
        $options[] = 'all';
        if ( $this->showFilterOptions() ) {
            foreach($this->getFilterOptionsSex() as $option) {
                $options[] = $option;
            }
            foreach($this->getFilterOptionsAlive() as $option) {
                $options[] = $option;
            }
            foreach($this->getFilterOptionsSex() as $optionSex) {
                foreach($this->getFilterOptionsAlive() as $optionAlive) {
                    $options[] = $optionSex . $optionAlive;
                }
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
    private function filterOptionSex($filterOption): string
    {
        foreach ($this->getFilterOptionsSex() as  $option) {
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
    private function filterOptionAlive($filterOption): string
    {
        foreach ($this->getFilterOptionsAlive() as  $option) {
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
     * convert combined filteroption to pair of filter options
     *
     * @param string [M, F, U, Y, N, MY, ...]
     *
     * @return array of string [sex, dead]
     */
    private function filterOptions($filterOption): array
    {
        return [
            'sex'   => $this->filterOptionSex($filterOption),
            'alive' => $this->filterOptionAlive($filterOption),
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
            if (count($individual->facts(['NAME'])) > 0) {                                           // check if there is at least one name            
                $nice = $this->niceNameFromNameParts($individual);
            } else {
                $nice = $this->nameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
            }
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
    public function niceNameFromNameParts(Individual $individual): string
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
    * generate summary message for all empty blocks (needed for showEmptyBlock == 1)
    *
    * @param object extended family
    * @param string 
    *
    * @return string
    */
    private function summaryMessageEmptyBlocks(object $extendedFamily, string $niceName): string
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
                $summary_message = I18N::translate('%s has no %s recorded.', $niceName, $summary_list);
            }
            else {
                $summary_list_a = $this->translateFamilyPart($empty[0]);
                for ( $i = 1; $i <= count($empty)-2; $i++ ) {
                    $summary_list_a .= ', ' . $this->translateFamilyPart($empty[$i]);
                }
                $summary_list_b = $this->translateFamilyPart($empty[count($empty)-1]);
                $summary_message = I18N::translate('%s has no %s, and no %s recorded.', $niceName, $summary_list_a, $summary_list_b);
            }
        }
        return $summary_message;      
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
     * dependency check if Vesta modules are available (needed for relationship name)
     *
     * @param bool $showErrorMessage
     *
     * @return bool
     */
    public function VestaModulesAvailable(bool $showErrorMessage): bool
    {
        $ok = class_exists("Cissee\WebtreesExt\AbstractModule", true);
        if (!$ok && $showErrorMessage) {
            FlashMessages::addMessage("Missing dependency - Make sure to install all Vesta modules!");
        }
        return $ok;
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
        return !$this->personExistsInExtendedFamily($individual);
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
        View::registerNamespace($this->name(),$this->resourcesFolder() . 'views/');
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
                return ExtendedFamilyTranslations::czechTranslations();
            case 'da':
                return ExtendedFamilyTranslations::danishTranslations();             // tbd
            case 'de':
                return ExtendedFamilyTranslations::germanTranslations();
            case 'es':
                return ExtendedFamilyTranslations::spanishTranslations();
            case 'fi':
                return ExtendedFamilyTranslations::finnishTranslations();            // tbd
            case 'fr':
            case 'fr-CA':
                return ExtendedFamilyTranslations::frenchTranslations();             // tbd
            case 'he':
                return ExtendedFamilyTranslations::hebrewTranslations();             // tbd
            case 'it':
                return ExtendedFamilyTranslations::italianTranslations();
            case 'lt':
                return ExtendedFamilyTranslations::lithuanianTranslations();         // tbd
            case 'nb':
                return ExtendedFamilyTranslations::norwegianBokmålTranslations();    // tbd
            case 'nl':
                return ExtendedFamilyTranslations::dutchTranslations();
            case 'nn':
                return ExtendedFamilyTranslations::norwegianNynorskTranslations();   // tbd
            case 'sk':
                return ExtendedFamilyTranslations::slovakTranslations();     
            case 'sv':
                return ExtendedFamilyTranslations::swedishTranslations();            // tbd
            case 'uk':
                return ExtendedFamilyTranslations::ukrainianTranslations();
            case 'vi':
                return ExtendedFamilyTranslations::vietnameseTranslations();
            default:
                return [];
        }
    }
}
return new ExtendedFamilyTabModule;
