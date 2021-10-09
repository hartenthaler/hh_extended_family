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
 * generelle Familienkennzeichen: statt "Eltern" immer "Ehe/Partnerschaft" verwenden
 *
 * issues/enhancements: see GitHub
 *
 * Familiengruppe Neffen und Nichten: 2-stufig: erst Geschwister als P bzw. Partner als P, dann Eltern wie gehabt;
 * Familiengruppe Cousins: wenn sie zur Vater- und Mutterfamilie gehören, werden sie falsch zugeordnet (bei P Seudo: C2)
 * Familiengruppe Schwäger und Schwägerinnen: Ergänzen der vollbürtigen Geschwister um halbbürtige und Stiefgeschwister
 * Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von
 *                Partner gemischt sein sollte
 * Familiengruppe Partnerketten: grafische Anzeige statt Textketten
 * Familiengruppe Partnerketten: von Ge. geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette
 *                von Di. zu Ga., d.h. dies als zweite Information ergänzen
 * Familiengruppe Geschwister: eventuell statt Label eigene Kategorie für Adoptiv- und Pflegekinder bzw. Stillmutter
 *
 * Label für biologische Vorfahren und Nachkommen mit SOSA-Nummer bzw. d'Aboville
 * Label für diverse Personen unter Nutzung der Funktion getRelationshipName(),
 *      basierend auf den Vesta-Modulen oder eigenen Funktionen:
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
 * Code: eventuell Verwendung der bestehenden Funktionen "_individuals" zum Aufbau von Familienteilen verwenden,
 *       statt es jedes Mal vom Probanden aus komplett neu zu gestalten
 * Code: Ablaufreihenfolge in function addIndividualToFamily() umbauen wie function addIndividualToFamilyAsPartner()
 *
 * Test: Übersetzung bei den Partnern testen bei diversen Fällen mit gemischtem Geschlecht
 * Test: wie verhält es sich, wenn eine Person als Kind zu zwei Familien gehört (bei P Seudo: C2)
 * Test: Stiefcousins (siehe Onkel Walter)
 * Test: Schwagerehe (etwa Levirat oder Sororat)
 *
 * andere Verwandtschaftssysteme: eventuell auch andere Verwandtschaftssysteme als nur das Eskimo-System implementieren
 * andere Verwandtschaftssysteme: Onkel als Vater- oder Mutterbruder ausweisen für Übersetzung (Label?);
 *                                Tante als Vater- oder Mutterschwester ausweisen für Übersetzung (Label?);
 * andere Verwandtschaftssysteme: Brüder und Schwestern als jüngere oder ältere Geschwister ausweisen für Übersetzung
 *                                (in Bezug auf Proband) (Label?)
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;


use function explode;
use function count;

require_once(__DIR__ . '/src/Factory/ExtendedFamilyPartFactory.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyPart.php');
require_once(__DIR__ . '/src/Factory/Objects/ExtendedFamilySupport.php');

require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Great_grandparents.php');
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
     * @var $filters                                 array of object (index is string filterOption)
     *         ->efp                                 object
     *              ->allCount                       int
     *              ->summaryMessageEmptyBlocks      array of string
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
        $this->proband->labels   = ExtendedFamilySupport::generateChildLabels($proband);
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
                    $this->filters[$filterOption] = clone $this->filters['all'];  // using __clone to filter and add counters
                    // sum up ->efp->allCount
                    // replace ->summaryMessageEmptyBlocks
                }
            }
        }
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
            if ($propName !== 'allCount' &&
                $propName !== 'summaryMessageEmptyBlocks' &&
                $extendedFamily->efp->$propName->allCount == 0) {
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
                $rufname = $rufnameParts[count($rufnameParts)-1];         // it has to be the last given name (before *)
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
     * an individual can have no name or many names (then we use only the first one)
     *
     * @param Individual $individual
     * @return string
     */
    private function findNiceName(Individual $individual): string
    {
        if ($this->config->showShortName) {
            if (count($individual->facts(['NAME'])) > 0) {                      // check if there is at least one name
                $niceName = $this->findNiceNameFromRufnameOrNameParts($individual);
            } else {                                          // tbd move following translations to tab.pthml
                $niceName = $this->selectNameSex($individual, I18N::translate('He'),
                                                              I18N::translate('She'),
                                                              I18N::translate('He/she'));
            }
        } else {
            $niceName = $individual->fullname();
        }
        return $niceName;
    }

    /**
     * Find a short, nice name for a person based on Rufname or name facts
     *
     * @param Individual $individual
     * @return string
     */
    private function findNiceNameFromRufnameOrNameParts(Individual $individual): string
    {
        $rufname = $this->findRufname($individual);
        if ($rufname !== '') {
            return $rufname;
        } else {
            return $this->findNiceNameFromNameParts($individual);
        }
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
}
