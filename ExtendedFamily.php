<?php
/*
 * webtrees - extended family part
 *
 * Copyright (C) 2026 Hermann Hartenthaler. All rights reserved.
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2026 webtrees development team.
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

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Date;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Registry;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Services\ClippingsCartWriter;
use Illuminate\Support\Collection;

use function ucfirst;

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
     *        ->showRelationshipToProband           bool
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
     *        ->placeFormat                         int
     */
    public object $config;
    
    /**
     * @var $proband                                object
     *         ->indi                               Individual
     *         ->niceName                           NiceName
     *                   ->name                     string
     *                   ->forFamilyOf              string
     *                   ->plain                    string
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
        $variant ='A';     // compare performance of variants A and B, see issue #216
                                // A: build up each filter variant from scratch
                                // B: build for filter option 'all', then copy and reduce/filter this
        if ($variant == 'A') {
            $this->filters = [];
            foreach ($this->config->filterOptions as $filterOption) {
                $extfamObj = (object)[];
                $extfamObj->efp = (object)[];
                $extfamObj->efp->summary = (object)[];
                $extfamObj->efp->summary->allCount = 0;
                foreach ($this->config->shownFamilyParts as $efp => $element) {
                    if ($element->enabled) {
                        $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption, $this->config->placeFormat);
                        $extfamObj->efp->$efp = $efpO->getEfpObject();
                        $extfamObj->efp->summary->allCount += $extfamObj->efp->$efp->allCount;
                    }
                }
                $this->addSummaryData($extfamObj);
                $this->filters[$filterOption] = $extfamObj;
            }
        } else {
            // build up structure for 'all'
            $extfamObj = (object)[];
            $extfamObj->efp = (object)[];
            $extfamObj->efp->summary = (object)[];
            $extfamObj->efp->summary->allCount = 0;
            foreach ($this->config->shownFamilyParts as $efp => $element) {
                if ($element->enabled) {
                    $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, 'all', $this->config->placeFormat);
                    $extfamObj->efp->$efp = $efpO->getEfpObject();
                    $extfamObj->efp->summary->allCount += $extfamObj->efp->$efp->allCount;
                }
            }
            $this->addSummaryData($extfamObj);
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
    }

    /**
     * Add all precomputed summary data used by the summary partial.
     *
     * @param object $extendedFamily
     * @return void
     */
    private function addSummaryData(object $extendedFamily): void
    {
        $individuals = $this->collectAllIndividuals($extendedFamily);

        $extendedFamily->efp->summary->summaryMessageEmptyBlocks = $this->summaryMessageEmptyBlocks($extendedFamily);
        $extendedFamily->efp->summary->allCountUnique = $individuals->count();
        $extendedFamily->efp->summary->statistics = $this->summaryStatistics($individuals);
    }

    /**
     * Calculate optional summary statistics for the unique individuals currently shown.
     *
     * @param Collection<int,Individual> $individuals
     * @return object
     */
    private function summaryStatistics(Collection $individuals): object
    {
        $statistics = (object)[];
        $total = $individuals->count();

        $livingCount = 0;
        $deceasedCount = 0;
        $maleCount = 0;
        $femaleCount = 0;
        $otherSexCount = 0;
        $earliestBirthDate = null;
        $earliestBirthJulianDay = PHP_INT_MAX;
        $latestDeathDate = null;
        $latestDeathJulianDay = 0;

        foreach ($individuals as $individual) {
            if ($individual->isDead()) {
                $deceasedCount++;
            } else {
                $livingCount++;
            }

            if ($individual->sex() === 'M') {
                $maleCount++;
            } elseif ($individual->sex() === 'F') {
                $femaleCount++;
            } else {
                $otherSexCount++;
            }

            $birthDate = $individual->getBirthDate();
            if ($birthDate->isOK() && $birthDate->minimumJulianDay() < $earliestBirthJulianDay) {
                $earliestBirthDate = $birthDate;
                $earliestBirthJulianDay = $birthDate->minimumJulianDay();
            }

            $deathDate = $individual->getDeathDate();
            if ($deathDate->isOK() && $deathDate->maximumJulianDay() > $latestDeathJulianDay) {
                $latestDeathDate = $deathDate;
                $latestDeathJulianDay = $deathDate->maximumJulianDay();
            }
        }

        $statistics->living = (object)[
            'show' => $livingCount > 0 && $deceasedCount > 0,
            'livingCount' => $livingCount,
            'deceasedCount' => $deceasedCount,
            'livingPercent' => $total > 0 ? $livingCount / $total : 0,
            'deceasedPercent' => $total > 0 ? $deceasedCount / $total : 0,
        ];

        $sexCategoriesShown = count(array_filter([$maleCount, $femaleCount, $otherSexCount], static fn (int $count): bool => $count > 0));
        $statistics->sex = (object)[
            'show' => $sexCategoriesShown > 1,
            'maleCount' => $maleCount,
            'femaleCount' => $femaleCount,
            'otherSexCount' => $otherSexCount,
            'malePercent' => $total > 0 ? $maleCount / $total : 0,
            'femalePercent' => $total > 0 ? $femaleCount / $total : 0,
            'otherSexPercent' => $total > 0 ? $otherSexCount / $total : 0,
        ];

        $dateRangeEndJulianDay = $livingCount > 0 ? Registry::timestampFactory()->now()->julianDay() : $latestDeathJulianDay;
        $statistics->dateRange = (object)[
            'show' => $earliestBirthDate !== null && $dateRangeEndJulianDay > 0 && $earliestBirthJulianDay < $dateRangeEndJulianDay,
            'startDate' => $earliestBirthDate?->display(),
            'startDateType' => $earliestBirthDate instanceof Date ? $this->summaryDateType($earliestBirthDate) : null,
            'endDate' => $livingCount > 0 ? null : $latestDeathDate?->display(),
            'endDateType' => $livingCount > 0 ? 'today' : ($latestDeathDate instanceof Date ? $this->summaryDateType($latestDeathDate) : null),
            'endIsToday' => $livingCount > 0,
        ];

        return $statistics;
    }

    /**
     * Distinguish year-only dates from fuller dates for grammatical date ranges.
     *
     * @param Date $date
     * @return string
     */
    private function summaryDateType(Date $date): string
    {
        $minimumDate = $date->minimumDate();

        return $minimumDate->month === 0 && $minimumDate->day === 0 ? 'year' : 'date';
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
        $collection = new Collection();
        $this->addIndividualToCollection($collection, $this->proband->indi);

        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName === 'summary') {
                continue;
            }

            if ($propName === 'partner_chains') {
                if ($this->config->countPartnerChainsToTotal && isset($propValue->collectionIndividuals) && is_iterable($propValue->collectionIndividuals)) {
                    foreach ($propValue->collectionIndividuals as $individual) {
                        $this->addIndividualToCollection($collection, $individual);
                    }
                }
                continue;
            }

            if (!isset($propValue->groups) || !is_iterable($propValue->groups)) {
                continue;
            }

            foreach ($propValue->groups as $group) {
                if (!isset($group->members) || !is_iterable($group->members)) {
                    continue;
                }

                foreach ($group->members as $individual) {
                    $this->addIndividualToCollection($collection, $individual);
                }
            }
        }

        return $collection->unique(function ($item) {
            return $item->xref();
        })->values();
    }

    /**
     * collect all families of the extended family,
     * maybe excluding the additional families of the partner chains
     *
     * @param object $extendedFamily
     * @return Collection
     */
    public function collectAllFamilies(object $extendedFamily): Collection
    {
        $collection = new Collection();
        foreach ($extendedFamily->efp as $propName => $propValue) {
            if ($propName === 'summary') {
                continue;
            }

            if ($propName === 'partner_chains') {
                if ($this->config->countPartnerChainsToTotal && isset($propValue->collectionFamilies) && is_iterable($propValue->collectionFamilies)) {
                    foreach ($propValue->collectionFamilies as $family) {
                        $this->addFamilyToCollection($collection, $family);
                    }
                }
                continue;
            }

            if (!isset($propValue->groups) || !is_iterable($propValue->groups)) {
                continue;
            }

            foreach ($propValue->groups as $group) {
                if (isset($group->families) && is_iterable($group->families)) {
                    foreach ($group->families as $family) {
                        $this->addFamilyToCollection($collection, $family);
                    }
                }

                if (isset($group->family)) {
                    $this->addFamilyToCollection($collection, $group->family);
                }
            }
        }

        return $collection->unique(function ($item) {
            return $item->xref();
        })->values();
    }

    /**
     * Add an individual to a collection, ignoring incomplete family-part entries.
     *
     * @param Collection $collection
     * @param mixed $individual
     * @return void
     */
    private function addIndividualToCollection(Collection $collection, $individual): void
    {
        if ($individual instanceof Individual) {
            $collection->add($individual);
        }
    }

    /**
     * Add a family to a collection, ignoring incomplete family-part entries.
     *
     * @param Collection $collection
     * @param mixed $family
     * @return void
     */
    private function addFamilyToCollection(Collection $collection, $family): void
    {
        if ($family instanceof Family) {
            $collection->add($family);
        }
    }

    /**
     * add all members of the extended family (individuals and their families) to the webtrees clippings cart
     *
     * @param Collection $individuals
     * @param Collection|null $families
     */
    public function addExtendedFamilyToClippingsCart(Collection $individuals, ?Collection $families = null): void
    {
        $cart_writer = new ClippingsCartWriter();

        $individuals->each(function($item, $key) use ($cart_writer) {
            if ($item instanceof Individual) {
                $cart_writer->addIndividualToCart($item);
            }
        });

        if ($families) {
            $families->each(function($item, $key) use ($cart_writer) {
                if ($item instanceof Family) {
                    $cart_writer->addFamilyToCart($item);
                }
            });
        }
    }
}
