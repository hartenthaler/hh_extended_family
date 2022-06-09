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
 * Performance: testen von Variante A und B (letztere muss erst noch fertig implementiert werden)
 *
 * Familiengruppe Urgroßeltern: Unterscheidung bei den Eltern eines Stiefelternteils nach Eltern und Stiefeltern
 * Familiengruppe Neffen und Nichten: 2-stufig: erst Geschwister als P bzw. Partner als P, dann Eltern wie gehabt
 * Familiengruppe Cousins: wenn sie zur Vater- und Mutterfamilie gehören, werden sie falsch zugeordnet (bei P Seudo: C2)
 * Familiengruppe Schwäger und Schwägerinnen: Ergänzen der vollbürtigen Geschwister um halbbürtige und Stiefgeschwister
 * Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von
 *                Partner gemischt sein sollte
 * Familiengruppe Partnerketten: grafische Anzeige statt Textketten
 * Familiengruppe Partnerketten: von Ge. geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette
 *                von Di. zu Ga., d.h. dies als zweite Information ergänzen
 * Familiengruppe Geschwister: eventuell statt Label eigene Kategorie für Adoptiv- und Pflegekinder bzw. Stillmutter
 *
 * generelle Familienkennzeichen: statt "Eltern" immer "Ehe/Partnerschaft" verwenden
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

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Session;
use Illuminate\Support\Collection;

use function explode;
use function count;

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
     *        ->showFilterOptions                   bool
     *        ->filterOptions                       array<int,string>
     *        ->showSummary                         bool
     *        ->showEmptyBlock                      int [0,1,2]
     *        ->countPartnerChainsToTotal           bool
     *        ->showShortName                       bool
     *        ->showLabels                          bool
     *        ->useCompactDesign                    bool
     *        ->useClippingsCart                    bool
     *        ->shownFamilyParts[]                  array<string,object>
     *                            ->name            string
     *                            ->enabled         bool
     *        ->showParameters                      bool
     *        ->familyPartParameters                array of array
     *        ->showThumbnail                       bool
     *        ->sizeThumbnailW                      int (in pixel)
     *        ->sizeThumbnailH                      int (in pixel)
     */
    public object $config;
    
    /**
     * @var $proband                                object
     *         ->indi                               Individual
     *         ->niceName                           string
     *         ->labels                             array<int,string>
     */
    public object $proband;
        
    /**
     * @var $filters                                        array<string,object> (index is filterOption)
     *         ->efp                                        object
     *              ->summary                               object
     *                       ->allCount                     int sum of the members of all family parts without proband
     *                       ->allCountUnique               int unique members of all family parts including proband
     *                                                      allCountUnique depends on countPartnerChainsToTotal
     *                       ->summaryMessageEmptyBlocks    array<int,string>
     *              ... specific data structures for each extended family part
     */
    public array $filters;
    
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
        $this->proband->niceName = ProbandName::findNiceName($proband, $this->config->showShortName);
        $this->proband->labels   = ExtendedFamilySupport::generateChildLabels($proband);
    }

    /**
     * construct array of extended family parts for all combinations of filter options
     */
    private function constructFiltersExtendedFamilyParts()
    {
        $variant ='A';     // tbd test and compare performance of both variants
                                // A: build up each filter variant from scratch
                                // B: build for filter option 'all', then copy and reduce/filter this
        if ($variant == 'A') {
            $this->filters = [];
            foreach ($this->config->filterOptions as $filterOption) {
                //if ($filterOption == 'F') {
                    $extfamObj = (object)[];
                    $extfamObj->efp = (object)[];
                    $extfamObj->efp->summary = (object)[];
                    $extfamObj->efp->summary->allCount = 0;
                    foreach ($this->config->shownFamilyParts as $efp => $element) {
                        if ($element->enabled) {
                            $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption);
                            $extfamObj->efp->$efp = $efpO->getEfpObject();
                            $extfamObj->efp->summary->allCount += $extfamObj->efp->$efp->allCount;
                        }
                    }
                    $extfamObj->efp->summary->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj);
                    $extfamObj->efp->summary->allCountUnique = $this->collectAllIndividuals($extfamObj)->count();
                    $this->filters[$filterOption] = $extfamObj;
                //}
            }
        } else {
            // build up structure for 'all'
            $extfamObj = (object)[];
            $extfamObj->efp = (object)[];
            $extfamObj->efp->summary = (object)[];
            $extfamObj->efp->summary->allCount = 0;
            foreach ($this->config->shownFamilyParts as $efp => $element) {
                if ($element->enabled) {
                    $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, 'all');
                    $extfamObj->efp->$efp = $efpO->getEfpObject();
                    $extfamObj->efp->summary->allCount += $extfamObj->efp->$efp->allCount;
                }
            }
            $extfamObj->efp->summary->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extfamObj);
            $extfamObj->efp->summary->allCountUnique = $this->collectAllIndividuals($extfamObj)->count();
            $this->filters['all'] = $extfamObj;
            // clone and reduce/filter this filtered object
            foreach ($this->config->filterOptions as $filterOption) {
                if ($filterOption !== 'all') {
                    $this->filters[$filterOption] = clone $this->filters['all'];
                    // using __clone to filter and add counters
                    // sum up ->efp->summary->allCount
                    // replace ->summaryMessageEmptyBlocks
                }
            }
        }
        // tbd remove
        if ($this->config->useClippingsCart) {
            //$this->addExtendedFamilyToClippingsCart($this->collectAllIndividuals($this->filters['all']), $this->collectAllFamilies($this->filters['all']));
        }
    }

    /**
     * generate list of empty family parts (blocks) (needed for showEmptyBlock == 1)
     *
     * @param object $extendedFamily
     * @return array<int,string>
     */
    private function summaryMessageEmptyBlocks(object $extendedFamily): array
    {
        $emptyBlocks = [];
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName !== 'summary' &&
                $extendedFamily->efp->$propName->allCount == 0) {
                $emptyBlocks[] = $propName;
            }
        }
        return $emptyBlocks;
    }

    /**
     * collect all members of the extended family (individuals)
     * including the proband, maybe excluding the additional members of the partner chains
     *
     * @param object $extendedFamily
     * @return Collection
     */
    public function collectAllIndividuals(object $extendedFamily): Collection
    {
        $collection = collect([$this->proband->indi]);                            // add proband to the extended family
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName == 'partner_chains' && $this->config->countPartnerChainsToTotal) {
                // we include the additional members of partner chains only if the option is set
                $collection = $collection->concat($propValue->collectionIndividuals);
            } elseif ($propName !== 'summary') {
                foreach ($propValue->groups as $group) {
                    foreach ($group->members as $individual) {
                        $collection->add($individual);
                    }
                }
            }
        }
        return $collection->unique(function ($item) {
            return $item->xref();
        });
    }

    /**
     * collect all families of the extended family
     * maybe excluding the additional families of the partner chains
     *
     * @param object $extendedFamily
     * @return Collection
     */
    public function collectAllFamilies(object $extendedFamily): Collection
    {
        $collection = new Collection();
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName == 'partner_chains' && $this->config->countPartnerChainsToTotal) {
                // we include the additional families of partner chains only if the option is set
                $collection = $collection->concat($propValue->collectionFamilies);
            } elseif ($propName !== 'summary') {
                foreach ($propValue->groups as $group) {
                    return $collection; // tbd
                    foreach ($group->members as $family) {
                        $collection->add($family);
                    }
                }
            }
        }
        return $collection;
    }

    /**
     * add all members of the extended family (individuals and their families) to the webtrees clippings cart
     *
     * @param Collection $individuals
     * @param Collection $families
     */
    public function addExtendedFamilyToClippingsCart(Collection $individuals, Collection $families = null): void
    {
        $individuals->each(function($item, $key) {
            $this->addIndividualToCart($item);
        });

        if ($families) {
            $families->each(function($item, $key) {
                $this->addFamilyToCart($item);
            });
        }
    }

    /**
     * add an individual and all linked other records to the clippings cart
     *
     * @param Individual $individual
     */
    protected function addIndividualToCart(Individual $individual): void
    {
        if ($individual->canShow()) {
            $cart = Session::get('cart');
            $cart = is_array($cart) ? $cart : [];

            $tree = $individual->tree()->name();
            $xref = $individual->xref();

            if (($cart[$tree][$xref] ?? false) === false) {
                $cart[$tree][$xref] = true;
                Session::put('cart', $cart);
                /* add all linked records to the clippings cart
                $this->addLocationLinksToCart($individual);
                $this->addMediaLinksToCart($individual);
                $this->addNoteLinksToCart($individual);
                $this->addSourceLinksToCart($individual);
                */
            }
        }
    }

    /**
     * add a family and the spouses and all linked other records to the clippings cart
     *
     * @param Family $family
     */
    protected function addFamilyToCart(Family $family): void
    {
        $cart = Session::get('cart');
        $cart = is_array($cart) ? $cart : [];

        $tree = $family->tree()->name();
        $xref = $family->xref();

        if (($cart[$tree][$xref] ?? false) === false) {
            $cart[$tree][$xref] = true;

            Session::put('cart', $cart);
            //echo "<br>**** added family $xref to clippings cart ****";

            foreach ($family->spouses() as $spouse) {
                $this->addIndividualToCart($spouse);
            }
            /* add all linked records to the clippings cart
            $this->addLocationLinksToCart($family);
            $this->addMediaLinksToCart($family);
            $this->addNoteLinksToCart($family);
            $this->addSourceLinksToCart($family);
            $this->addSubmitterLinksToCart($family);
            */
        }
    }
}
