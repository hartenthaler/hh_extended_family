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
 * Performance: testen von Variante A und B (letztere muss erst noch fertig implementiert werden)
 *
 * issues/enhancements: see GitHub
 *
 * generelle Familienkennzeichen: statt "Eltern" immer "Ehe/Partnerschaft" verwenden
 *
 * Familiengruppe Neffen und Nichten: 2-stufig: erst Geschwister als P bzw. Partner als P, dann Eltern wie gehabt;
 * Familiengruppe Cousins: wenn sie zur Vater- und Mutter-Familie gehören, werden sie falsch zugeordnet (bei P Seudo: C2)
 * Familiengruppe Schwäger und Schwägerinnen: Ergänzen der vollbürtigen Geschwister um halbbürtige und Stiefgeschwister
 * Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von Partner gemischt sein sollte
 * Familiengruppe Partnerketten: grafische Anzeige statt Textketten
 * Familiengruppe Partnerketten: von Ge. geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette von Di. zu Ga., d.h. dies als zweite Info ergänzen
 * Familiengruppe Geschwister: eventuell statt Label eigene Kategorie für Adoptiv- und Pflegekinder bzw. Stillmutter
 *
 * Label für biologische Vorfahren und Nachkommen mit SOSA-Nummer bzw. d'Aboville
 * Label für diverse Personen unter Nutzung der Funktion getRelationshipName(), basierend auf den Vesta-Modulen oder eigenen Funktionen:
 *          Schwäger: Partner der Geschwister
 *          Schwippschwäger: Rechts = Partner der Schwäger (Ehemann, Ex-, Partner)
 *          Schwiegerkinder: Partnerin/Ehefrau
 *          Biologische Eltern, falls selbst adoptiert
 *          Partner: (Ehefrau, Ehemann, Partner)
 *          Angeheiratete Onkel und Tanten: generell (Ehefrau/Ehemann, Partner/Partnerin)
 * Label für Stiefkinder: etwa bei meinen Neffen Fabian, Felix, Jason und Sam
 * Label für Partner: neu einbauen (Ehemann/Ehefrau/Partner/Partnerin/Verlobter/Verlobte/Ex-...)
 * Label für Eltern: biologische Eltern, Stiefeltern, Adoptiveltern, Pflegeeltern
 * Label oder Gruppe bei Onkel/Tante: Halbonkel/-tante = Halbbruder/-schwester eines biologischen Elternteils
 *
 * Code: eventuell Verwendung der bestehenden Funktionen "_individuals" zum Aufbau von Familienteilen verwenden statt es jedes Mal vom Probanden aus komplett neu zu gestalten
 * Code: Ablaufreihenfolge in function addIndividualToFamily() umbauen wie function addIndividualToFamilyAsPartner()
 *
 * Test: Übersetzung bei den Partnern testen bei diversen Fällen mit gemischtem Geschlecht
 * Test: wie verhält es sich, wenn eine Person als Kind zu zwei Familien gehört (bei P Seudo: C2)
 * Test: Stiefcousins (siehe Onkel Walter)
 * Test: Schwagerehe (etwa Levirat oder Sororat)
 *
 * andere Verwandtschaftssysteme: eventuell auch andere als nur das Eskimo-System implementieren
 * andere Verwandtschaftssysteme: Onkel als Vater- oder Mutterbruder ausweisen für Übersetzung (Label?); Tante als Vater- oder Mutterschwester ausweisen für Übersetzung (Label?);
 * andere Verwandtschaftssysteme: Brüder und Schwestern als jüngere oder ältere Geschwister ausweisen für Übersetzung (in Bezug auf Proband) (Label?)
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\GedcomCode\GedcomCodePedi;

// string functions
use function str_replace;
use function strtolower;
use function str_contains;  // will be added in PHP 8.0
use function preg_match;

// array functions
use function explode;
use function count;
use function in_array;
use function array_filter;

require_once(__DIR__ . '/src/Factory/ExtendedFamilyPartFactory.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyPart.php');

require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandparents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts_bm.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partners.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partner_chains.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Cousins.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Nephews_and_nieces.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandchildren.php');

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
     *        ->familyPartParameters                array of array
     *        ->sizeThumbnailW                      int (in pixel)
     *        ->sizeThumbnailH                      int (in pixel)
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
     *              ->summaryMessageEmptyBlocks                             array of string
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
     * construct object containing configuration information based on module parameters
     *
     * @param object $config configuration parameters
     */
    protected function constructConfig(object $config)
    {
        $this->config = $config;
    }
    
    /**
     * construct object containing information related to the proband
     *
     * @param Individual $proband
     */
    protected function constructProband(Individual $proband)
    {
        $this->proband = (object)[];
        $this->proband->indi     = $proband;
        $this->proband->niceName = $this->findNiceName($proband);
        $this->proband->labels   = $this->generateChildLabels($proband);
    }

    /**
     * construct array of extended family parts for all combinations of filter options
     */
    private function constructFiltersExtendedFamilyParts()
    {
        $variante ='A';   // tbd test and compare performance of Varianate A and B
        $this->filters = [];
        foreach ($this->config->filterOptions as $filterOption) {
            if ($variante == 'A') {
                $extfamObj = (object)[];
                $extfamObj->efp = (object)[];
                $extfamObj->efp->allCount = 0;
                foreach ($this->config->shownFamilyParts as $efp => $element) {
                    if ($element->enabled) {
                        $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption);
                        $extfamObj->efp->$efp = $efpO->getEfpObject();
                        $extfamObj->efp->allCount += $extfamObj->efp->$efp->allCount;
                    }
                }
                $extfamObj->efp->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj);
                $this->filters[$filterOption] = $extfamObj;
            } else {
                if ($filterOption == 'all') {
                    $extfamObj = (object)[];
                    $extfamObj->efp = (object)[];
                    $extfamObj->efp->allCount = 0;
                    foreach ($this->config->shownFamilyParts as $efp => $element) {
                        if ($element->enabled) {
                            $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption);
                            $extfamObj->efp->$efp = $efpO->getEfpObject();
                            $extfamObj->efp->allCount += $extfamObj->efp->$efp->allCount;
                        }
                    }
                    $extfamObj->efp->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj);
                    $this->filters[$filterOption] = $extfamObj;
                } else {
                    $this->filters[$filterOption] = clone $this->filters['all'];        // using __clone to filter and add counters
                    // sum up ->efp->allCount
                    // replace ->summaryMessageEmptyBlocks
                }
            }
        }
    }

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
            'uncles_and_aunts_bm',                                          // uncles and aunts by marriage
            'parents',
            'parents_in_law',
            'co_parents_in_law',                        // generation  0
            'partners',
            'partner_chains',
            'siblings',
            'siblings_in_law',
            'co_siblings_in_law',
            'cousins',
            'nephews_and_nieces',                       // generation -1
            'children',
            'children_in_law',
            'grandchildren',                            // generation -2
        ];
    }

    /**
     * get parameters for the used extended family parts like relationship coefficients and generation shift
     *
     * @return array of array
     */
    public static function getFamilyPartParameters(): array
    {
        return [
            'grandparents'           => ['generation' => +2, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Grandparents::GROUP_GRANDPARENTS_BIO],
            'uncles_and_aunts'       => ['generation' => +1, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Uncles_and_aunts::GROUP_UNCLEAUNT_FULL_BIO],
            'uncles_and_aunts_bm'    => ['generation' => +1, 'relationshipCoefficient' => 0],
            'parents'                => ['generation' => +1, 'relationshipCoefficient' => 0.5,   'relationshipCoefficientComment' => Parents::GROUP_PARENTS_BIO],
            'parents_in_law'         => ['generation' => +1, 'relationshipCoefficient' => 0],
            'co_parents_in_law'      => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'partners'               => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'partner_chains'         => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'siblings'               => ['generation' =>  0, 'relationshipCoefficient' => 0.5,   'relationshipCoefficientComment' => Siblings::GROUP_SIBLINGS_FULL],
            'siblings_in_law'        => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'co_siblings_in_law'     => ['generation' =>  0, 'relationshipCoefficient' => 0],
            'cousins'                => ['generation' =>  0, 'relationshipCoefficient' => 0.125, 'relationshipCoefficientComment' => Cousins::GROUP_COUSINS_FULL_BIO],
            'nephews_and_nieces'     => ['generation' => -1, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Nephews_and_nieces::GROUP_NEPHEW_NIECES_CHILD_FULLSIBLING],
            'children'               => ['generation' => -1, 'relationshipCoefficient' => 0.5,   'relationshipCoefficientComment' => Children::GROUP_CHILDREN_BIO],
            'children_in_law'        => ['generation' => -1, 'relationshipCoefficient' => 0],
            'grandchildren'          => ['generation' => -2, 'relationshipCoefficient' => 0.25,  'relationshipCoefficientComment' => Grandchildren::GROUP_GRANDCHILDREN_BIO],
       ];
    }

    /**
     * get list of options to filter by gender
     *
     * @return array of string
     */
    private static function getFilterOptionsSex(): array
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
    private static function getFilterOptionsAlive(): array
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
    public static function getFilterOptions(): array
    {
        $options = [];
        $options[] = 'all';
        foreach (ExtendedFamily::getFilterOptionsSex() as $option) {
            $options[] = $option;
        }
        foreach (ExtendedFamily::getFilterOptionsAlive() as $option) {
            $options[] = $option;
        }
        foreach (ExtendedFamily::getFilterOptionsSex() as $optionSex) {
            foreach (ExtendedFamily::getFilterOptionsAlive() as $optionAlive) {
                $options[] = $optionSex . $optionAlive;
            }
        }
        return $options;
    }
    
    /**
     * convert combined filterOption to filter option for gender of a person [all, only_M, only_F, only_U]
     *
     * @param string $filterOption [all, M, F, U, Y, N, MY, FN, ...]
     * @return string
     */
    public static function filterOptionSex(string $filterOption): string
    {
        foreach (ExtendedFamily::getFilterOptionsSex() as  $option) {
            if (str_contains($filterOption, $option)) {
                return 'only_' . $option;
            }
        }
        return 'all';
    }

    /**
     * convert combined filteroption to filter option for alive/dead status of a person [all, only_dead, only_alive]
     *
     * @param string [M, F, U, Y, N, MY, FN, ...]
     * @return string
     */
    public static function filterOptionAlive($filterOption): string
    {
        foreach (ExtendedFamily::getFilterOptionsAlive() as  $option) {
            if (str_contains($filterOption, $option)) {
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
    public static function convertFilterOptions(string $filterOption): array
    {
        return [
            'sex'   => ExtendedFamily::filterOptionSex($filterOption),
            'alive' => ExtendedFamily::filterOptionAlive($filterOption),
        ];
    }

    /**
     * generate list of empty family parts (blocks) (needed for showEmptyBlock == 1)
     *
     * @param object $extendedFamily
     * @return array of string
     */
    private function summaryMessageEmptyBlocks(object $extendedFamily): array
    {
        $emptyBlocks = [];
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName !== 'allCount' && $propName !== 'summaryMessageEmptyBlocks' && $extendedFamily->efp->$propName->allCount == 0) {
                $emptyBlocks[] = $propName;
            }
        }
        return $emptyBlocks;
    }
    
    /**
     * find rufname of an individual (tag _RUFNAME or marked with '*'
     *
     * @param Individual $individual
     * @return string (is empty if there is no Rufname)
     */
    private function findRufname(Individual $individual): string
    {
        $rufname = $individual->facts(['NAME'])[0]->attribute('_RUFNAME');
        if ($rufname == '') {
            $rufnameParts = explode('*', $individual->facts(['NAME'])[0]->value());
            if ($rufnameParts[0] !== $individual->facts(['NAME'])[0]->value()) {
                // there is a Rufname marked with *, but no tag _RUFNAME
                $rufnameParts = explode(' ', $rufnameParts[0]);   
                $rufname = $rufnameParts[count($rufnameParts)-1];                        // it has to be the last given name (before *)
            }
        }
        return $rufname;
    }

    /**
     * set name depending on sex of individual
     *
     * @param Individual $individual
     * @param string $nMale
     * @param string $nFemale
     * @param string $nUnknown
     * @return string
     */
    private function selectNameSex(Individual $individual, string $nMale, string $nFemale, string $nUnknown): string
    {
        if ($individual->sex() == 'M') {
            return $nMale;
        } elseif ($individual->sex() == 'F') {
            return $nFemale;
        } else {
            return $nUnknown;
        }
    }
    
    /**
     * Find a short, nice name for a person
     * => use Rufname or nickname ("Sepp") or first of first names if one of these is available
     *    => otherwise use surname if available ("Mr. xxx", "Mrs. xxx", or "xxx" if sex is not F or M
     *       => otherwise use "He" or "She" (or "He/she" if sex is not F and not M)
     *
     * @param Individual $individual
     * @return string
     */
    private function findNiceName(Individual $individual): string
    {
        if ($this->config->showShortName) {
            // an individual can have no name or many names (then we use only the first one)
            if (count($individual->facts(['NAME'])) > 0) {                                          // check if there is at least one name
                $rufname = $this->findRufname($individual);
                if ($rufname !== '') {
                    $niceName = $rufname;
                } else {
                    $niceName = $this->findNiceNameFromNameParts($individual);
                }
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
     * @return string
     */
    private function findNiceNameFromNameParts(Individual $individual): string
    {
        $niceName = '';
        $nameFacts = $individual->facts(['NAME']);
        $nickname = $nameFacts[0]->attribute('NICK');
        if ($nickname !== '') {
            $niceName = $nickname;
        } else {
            $npfx = $nameFacts[0]->attribute('NPFX');
            $givenAndSurnames = explode('/', $nameFacts[0]->value());
            if ($givenAndSurnames[0] !== '') {                                          // are there given names (or prefix nameparts)?
                $givennameparts = explode( ' ', $givenAndSurnames[0]);
                if ($npfx == '') {                                                      // find the first given name
                    $niceName = $givennameparts[0];                                     // the first given name
                } elseif (count(explode(' ', $npfx)) !== count($givennameparts)) {
                    $niceName = $givennameparts[count(explode(' ', $npfx))];     // the first given name after the prefix nameparts
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
            ExtendedFamily::generatePedigreeLabel($child),
            ExtendedFamily::generateChildLinkageStatusLabel($child),
            ExtendedFamily::generateMultipleBirthLabel($child),
            ExtendedFamily::generateAgeLabel($child),
        ]);
    }

    /**
     * generate a pedigree label
     * GEDCOM record is for example ""
     *
     * @param Individual $child
     * @return string
     */
    private static function generatePedigreeLabel(Individual $child): string
    {
        $label = GedcomCodePedi::getValue('', $child->getInstance($child->xref(), $child->tree()));
        if ($child->childFamilies()->first()) {
            if (preg_match('/\n1 FAMC @' . $child->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $child->gedcom(), $match)) {
                if ($match[1] !== 'birth') {
                    $label = GedcomCodePedi::getValue($match[1], $child->getInstance($child->xref(), $child->tree()));
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
    private static function generateChildLinkageStatusLabel(Individual $child): string
    {
        if ($child->childFamilies()->first()) {
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
    private static function generateMultipleBirthLabel(Individual $child): string
    {
        $multipleBirth = [
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
        if (preg_match('/\n1 ASSO @(?:.+)@\n2 RELA (.+)/', $childGedcom, $match) ||
             preg_match('/\n2 _ASSO @(?:.+)@\n3 RELA (.+)/', $childGedcom, $match)) {
            if (in_array(strtolower($match[1]), $multipleBirth)) {
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
    private static function generateAgeLabel(Individual $child): string
    {     
        $childGedcom = $child->gedcom();
        if (preg_match('/\n2 AGE STILLBORN/i', $childGedcom, $match)) {
            return I18N::translate('stillborn');
        }        
        if (preg_match('/\n2 AGE INFANT/i', $childGedcom, $match)) {
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
            switch ($event->tag()) {
                case 'FAM:ANUL':
                case 'FAM:DIV':
                    return self::FAM_STATUS_EX;
                case 'FAM:MARR':
                    return self::FAM_STATUS_MARRIAGE;
                case 'FAM:ENGA':
                    return self::FAM_STATUS_FIANCEE;
            }
        }
        return self::FAM_STATUS_PARTNERSHIP;                       // default if there is no family status tag
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
        }
    }
}
