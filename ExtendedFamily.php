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

// array functions
// use function unset;      // cannot be declared as used function
use function explode;
use function count;
use function array_key_exists;
use function in_array;
use function array_merge;
use function array_filter;

require_once(__DIR__ . '/src/Factory/ExtendedFamilyPartFactory.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyPart.php');

require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandparents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Cousins.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Nephews_and_nieces.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandchildren.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts_bm.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partner_chains.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partners.php');

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

    // ------------ definition of data structures (they have to be public so that they can be accessed in tab.phtml)
    
    /**
     * @var $config                                 object
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
     * @var $proband                                object
     *         ->indi                               Individual
     *         ->niceName                           string
     *         ->labels                             array of string
     */
    public $proband;
        
    /**
     * @var $filters                                                        array of object (index is string filterOption)
     *         ->efp                                                        object
     *              ->allCount                                              int
     *              ->summaryMessageEmptyBlocks                             string
     *              ... specific data structures for each extended family part
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
                    $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption);
                    $extfamObj->efp->$efp = $efpO->getEfpObject();
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
     * list of parts of extended family
     *
     * @return array of string
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
     * generate summary message for all empty blocks (needed for showEmptyBlock == 1)
     *
     * @param object $extendedFamily
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
            //echo "<br>family tag=".$event->tag().". ";
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
