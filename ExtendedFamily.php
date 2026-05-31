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
use Fisharebest\Webtrees\Elements\PedigreeLinkageType;
use Fisharebest\Webtrees\Fact;
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
     *        ->showSosaNumbers                     bool
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
     * @var ExtendedFamilyProband $proband
     */
    public ExtendedFamilyProband $proband;

    /**
     * @var array<string,array<int,int>> SOSA numbers indexed by individual xref
     */
    private array $sosaNumbers = [];
        
    /**
     * @var $filters                                        array<string,ExtendedFamilyFilterResult> (index is filterOption)
     *         ->efp                                        ExtendedFamilyPartSet
     *              ->summary                               ExtendedFamilySummary
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
        $this->proband = new ExtendedFamilyProband(
            $proband,
            ProbandName::findNiceName($proband, $this->config->showShortName),
            ExtendedFamilySupport::generateChildLabels($proband),
            $this->config->showSosaNumbers ? [ExtendedFamilySupport::generateSosaLabel([1])] : []
        );
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
                $extfamObj = new ExtendedFamilyFilterResult();
                $familyParts = $this->buildFamilyPartsForFilter($filterOption);
                foreach ($this->config->shownFamilyParts as $efp => $element) {
                    if (isset($familyParts[$efp])) {
                        $extfamObj->efp->$efp = $familyParts[$efp];
                        if ($efp !== 'godparents_witnesses') {
                            $extfamObj->efp->summary->allCount += $extfamObj->efp->$efp->allCount;
                        }
                    }
                }
                $this->addSosaLabels($extfamObj);
                $this->addSummaryData($extfamObj);
                $this->filters[$filterOption] = $extfamObj;
            }
        } else {
            // build up structure for 'all'
            $extfamObj = new ExtendedFamilyFilterResult();
            $familyParts = $this->buildFamilyPartsForFilter('all');
            foreach ($this->config->shownFamilyParts as $efp => $element) {
                if (isset($familyParts[$efp])) {
                    $extfamObj->efp->$efp = $familyParts[$efp];
                    if ($efp !== 'godparents_witnesses') {
                        $extfamObj->efp->summary->allCount += $extfamObj->efp->$efp->allCount;
                    }
                }
            }
            $this->addSosaLabels($extfamObj);
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
     * Build enabled family parts for one filter.
     *
     * The associated-person family part depends on the other currently enabled
     * family parts. It is therefore calculated after the normal family parts
     * but inserted later in the configured display order.
     *
     * @param string $filterOption
     * @return array<string,object>
     */
    private function buildFamilyPartsForFilter(string $filterOption): array
    {
        $familyParts = [];
        $seedFamilyParts = new ExtendedFamilyPartSet();

        foreach ($this->config->shownFamilyParts as $efp => $element) {
            if (!$element->enabled || $efp === 'godparents_witnesses') {
                continue;
            }

            $efpO = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, $filterOption, $this->config->placeFormat);
            $familyParts[$efp] = $efpO->getEfpObject();
            $seedFamilyParts->$efp = $familyParts[$efp];
        }

        if ($this->config->shownFamilyParts['godparents_witnesses']->enabled ?? false) {
            $efpO = new Godparents_witnesses($this->proband->indi, $filterOption, $this->config->placeFormat, $seedFamilyParts);
            $familyParts['godparents_witnesses'] = $efpO->getEfpObject();
        }

        return $familyParts;
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
        $extendedFamily->efp->summary->lineageStatistics = $this->lineageStatistics($extendedFamily);
    }

    /**
     * Add SOSA labels to biological ancestors in one filtered result.
     *
     * @param ExtendedFamilyFilterResult $extendedFamily
     * @return void
     */
    private function addSosaLabels(ExtendedFamilyFilterResult $extendedFamily): void
    {
        if (!$this->config->showSosaNumbers) {
            return;
        }

        $sosaNumbers = $this->sosaNumbers();

        foreach ($this->collectGroupEntries($extendedFamily) as $entry) {
            $xref = $entry->individual->xref();

            if (isset($sosaNumbers[$xref])) {
                $entry->sosaLabels[] = ExtendedFamilySupport::generateSosaLabel($sosaNumbers[$xref]);
            }
        }
    }

    /**
     * Collect all group entries from one filtered result.
     *
     * @param ExtendedFamilyFilterResult $extendedFamily
     * @return array<int,GroupEntry>
     */
    private function collectGroupEntries(ExtendedFamilyFilterResult $extendedFamily): array
    {
        $entries = [];

        foreach (ExtendedFamilySupport::listFamilyParts() as $familyPart) {
            if (!isset($extendedFamily->efp->$familyPart->groups) || !is_iterable($extendedFamily->efp->$familyPart->groups)) {
                continue;
            }

            foreach ($extendedFamily->efp->$familyPart->groups as $group) {
                foreach ($group->entries ?? [] as $entry) {
                    if ($entry instanceof GroupEntry) {
                        $entries[] = $entry;
                    }
                }
            }
        }

        return $entries;
    }

    /**
     * SOSA numbers for the proband and biological ancestors shown by this module.
     *
     * @return array<string,array<int,int>>
     */
    private function sosaNumbers(): array
    {
        if ($this->sosaNumbers !== []) {
            return $this->sosaNumbers;
        }

        $ancestors = [1 => $this->proband->indi];
        $queue = [1];
        $max = 2 ** 3;

        while ($queue !== []) {
            $sosaNumber = array_shift($queue);
            $individual = $ancestors[$sosaNumber];
            $this->sosaNumbers[$individual->xref()][] = $sosaNumber;

            if ($sosaNumber >= $max) {
                continue;
            }

            $family = $this->biologicalChildFamily($individual);

            if ($family instanceof Family) {
                if ($family->husband() instanceof Individual) {
                    $ancestors[$sosaNumber * 2] = $family->husband();
                    $queue[] = $sosaNumber * 2;
                }

                if ($family->wife() instanceof Individual) {
                    $ancestors[$sosaNumber * 2 + 1] = $family->wife();
                    $queue[] = $sosaNumber * 2 + 1;
                }
            }
        }

        foreach ($this->sosaNumbers as &$numbers) {
            sort($numbers);
        }

        return $this->sosaNumbers;
    }

    /**
     * First family in which the individual is linked as biological child.
     *
     * @param Individual $individual
     * @return Family|null
     */
    private function biologicalChildFamily(Individual $individual): ?Family
    {
        foreach ($individual->childFamilies() as $family) {
            if ($this->isBiologicalChildInFamily($individual, $family)) {
                return $family;
            }
        }

        return null;
    }

    /**
     * Calculate ancestor and descendant statistics for selected direct-line family parts.
     *
     * @param object $extendedFamily
     * @return LineageStatistics
     */
    private function lineageStatistics(object $extendedFamily): LineageStatistics
    {
        $statistics = new LineageStatistics();

        $ancestorRows = $this->lineageRows($extendedFamily, 'ancestors');
        if (count($ancestorRows) > 1) {
            $statistics->ancestors = $this->lineageSummary($ancestorRows);
        }

        $descendantRows = $this->lineageRows($extendedFamily, 'descendants');
        if (count($descendantRows) > 1) {
            $statistics->descendants = $this->lineageSummary($descendantRows);
        }

        if ($statistics->ancestors !== null || $statistics->descendants !== null) {
            $statistics->combined = $this->combinedLineageSummary($ancestorRows, $descendantRows);
            $statistics->implex = $this->lineageImplexSummary($ancestorRows, $descendantRows);
        }

        return $statistics;
    }

    /**
     * Build rows for direct ancestor or descendant statistics.
     *
     * @param object $extendedFamily
     * @param string $direction
     * @return array<int,LineageRow>
     */
    private function lineageRows(object $extendedFamily, string $direction): array
    {
        $rows = [
            $this->lineageRow(1, 'self', [$this->proband->indi], [$this->proband->indi]),
        ];

        $parts = $direction === 'ancestors'
            ? [
                2 => ['parents', 'parents'],
                3 => ['grandparents', 'grandparents'],
                4 => ['great_grandparents', 'great-grandparents'],
            ]
            : [
                2 => ['children', 'children'],
                3 => ['grandchildren', 'grandchildren'],
                4 => ['great_grandchildren', 'great-grandchildren'],
            ];

        foreach ($parts as $generation => [$familyPart, $relation]) {
            if (!isset($extendedFamily->efp->$familyPart)) {
                continue;
            }

            $individuals = $this->collectIndividualsFromFamilyPart($extendedFamily->efp->$familyPart);
            if (count($individuals) === 0) {
                continue;
            }

            $biologicalIndividuals = $this->collectBiologicalIndividualsFromFamilyPart($familyPart, $extendedFamily->efp->$familyPart);
            $rows[] = $this->lineageRow($generation, $relation, $individuals, $biologicalIndividuals);
        }

        $this->addGenerationLengths($rows, $direction);

        return $rows;
    }

    /**
     * @param object $familyPart
     * @return array<int,Individual>
     */
    private function collectIndividualsFromFamilyPart(object $familyPart): array
    {
        $individuals = [];

        if (!isset($familyPart->groups) || !is_iterable($familyPart->groups)) {
            return [];
        }

        foreach ($familyPart->groups as $group) {
            if (!isset($group->entries) || !is_iterable($group->entries)) {
                continue;
            }

            foreach ($group->entries as $entry) {
                $individual = $entry->individual ?? null;
                if ($individual instanceof Individual) {
                    $individuals[$individual->xref()] = $individual;
                }
            }
        }

        return array_values($individuals);
    }

    /**
     * @param string $familyPartName
     * @param object $familyPart
     * @return array<int,Individual>
     */
    private function collectBiologicalIndividualsFromFamilyPart(string $familyPartName, object $familyPart): array
    {
        $individuals = [];

        if (!isset($familyPart->groups) || !is_iterable($familyPart->groups)) {
            return [];
        }

        foreach ($familyPart->groups as $group) {
            if (!$this->isBiologicalLineageGroup($familyPartName, $group->groupName ?? '')) {
                continue;
            }

            foreach ($group->entries ?? [] as $entry) {
                $individual = $entry->individual ?? null;
                if ($individual instanceof Individual) {
                    $individuals[$individual->xref()] = $individual;
                }
            }
        }

        return array_values($individuals);
    }

    /**
     * @param string $familyPartName
     * @param string $groupName
     * @return bool
     */
    private function isBiologicalLineageGroup(string $familyPartName, string $groupName): bool
    {
        return match ($familyPartName) {
            'parents' => $groupName === Parents::GROUP_PARENTS_BIO,
            'grandparents' => in_array($groupName, [
                Grandparents::GROUP_GRANDPARENTS_FATHER_BIO,
                Grandparents::GROUP_GRANDPARENTS_MOTHER_BIO,
                Grandparents::GROUP_GRANDPARENTS_U_BIO,
            ], true),
            'great_grandparents' => in_array($groupName, [
                Great_grandparents::GROUP_GREATGRANDPARENTS_FATHERSIDE_BIO,
                Great_grandparents::GROUP_GREATGRANDPARENTS_MOTHERSIDE_BIO,
                Great_grandparents::GROUP_GREATGRANDPARENTS_USIDE_BIO,
            ], true),
            'children' => $groupName === Children::GROUP_CHILDREN_BIO,
            'grandchildren' => $groupName === Grandchildren::GROUP_GRANDCHILDREN_BIO,
            'great_grandchildren' => $groupName === Great_grandchildren::GROUP_GREATGRANDCHILDREN_BIO,
            default => false,
        };
    }

    /**
     * @param int $generation
     * @param string $relation
     * @param array<int,Individual> $individuals
     * @param array<int,Individual> $biologicalIndividuals
     * @return LineageRow
     */
    private function lineageRow(int $generation, string $relation, array $individuals, array $biologicalIndividuals): LineageRow
    {
        $birthYears = [];
        $marriageAges = [];
        $lifespans = [];
        $childrenCounts = [];

        foreach ($individuals as $individual) {
            $birthYear = $this->individualBirthYear($individual);
            if ($birthYear !== null) {
                $birthYears[] = $birthYear;
            }

            $marriageAge = $this->individualFirstMarriageAge($individual);
            if ($marriageAge !== null) {
                $marriageAges[] = $marriageAge;
            }

            $lifespan = $this->individualLifespan($individual);
            if ($lifespan !== null) {
                $lifespans[] = $lifespan;
            }

            $childrenCounts[] = $this->biologicalChildrenCount($individual);
        }

        return new LineageRow(
            $generation,
            $relation,
            $individuals,
            count($individuals),
            count($biologicalIndividuals),
            count($birthYears),
            count(array_filter($biologicalIndividuals, fn (Individual $individual): bool => $this->individualBirthYear($individual) !== null)),
            $birthYears === [] ? null : min($birthYears),
            $birthYears === [] ? null : max($birthYears),
            $this->averageRounded($birthYears),
            $this->averageRounded($marriageAges),
            null,
            $this->averageRounded($lifespans),
            $this->averageRounded($childrenCounts)
        );
    }

    /**
     * @param array<int,LineageRow> $rows
     * @param string $direction
     * @return void
     */
    private function addGenerationLengths(array &$rows, string $direction): void
    {
        foreach ($rows as $index => $row) {
            if ($index === 0 || $row->averageBirthYear === null || $rows[$index - 1]->averageBirthYear === null) {
                continue;
            }

            $generationGap = max(1, $row->generation - $rows[$index - 1]->generation);
            $birthYearDifference = $direction === 'ancestors'
                ? $rows[$index - 1]->averageBirthYear - $row->averageBirthYear
                : $row->averageBirthYear - $rows[$index - 1]->averageBirthYear;

            $row->generationLength = (int) round($birthYearDifference / $generationGap);
        }
    }

    /**
     * @param array<int,LineageRow> $rows
     * @return LineageSummary
     */
    private function lineageSummary(array $rows): LineageSummary
    {
        $individuals = [];
        foreach ($rows as $row) {
            if ($row->generation === 1) {
                continue;
            }

            foreach ($row->individuals as $individual) {
                $individuals[$individual->xref()] = $individual;
            }
        }

        $generationLengths = array_values(array_filter(array_map(static fn (LineageRow $row): ?int => $row->generationLength, $rows), static fn (?int $length): bool => $length !== null));
        $lifespans = [];

        foreach ($individuals as $individual) {
            $lifespan = $this->individualLifespan($individual);
            if ($lifespan !== null) {
                $lifespans[] = $lifespan;
            }
        }

        return new LineageSummary(
            $rows,
            $this->averageRounded($generationLengths),
            $this->averageRounded($lifespans),
            $this->oldestIndividuals($individuals),
            $this->oldestIndividuals($individuals, 'M'),
            $this->oldestIndividuals($individuals, 'F')
        );
    }

    /**
     * @param array<int,LineageRow> $ancestorRows
     * @param array<int,LineageRow> $descendantRows
     * @return LineageSummary
     */
    private function combinedLineageSummary(array $ancestorRows, array $descendantRows): LineageSummary
    {
        $individuals = [];
        $generationLengths = [];
        $lifespans = [];

        foreach ([$ancestorRows, $descendantRows] as $rows) {
            foreach ($rows as $row) {
                if ($row->generationLength !== null) {
                    $generationLengths[] = $row->generationLength;
                }

                if ($row->generation === 1) {
                    continue;
                }

                foreach ($row->individuals as $individual) {
                    $individuals[$individual->xref()] = $individual;
                }
            }
        }

        foreach ($individuals as $individual) {
            $lifespan = $this->individualLifespan($individual);
            if ($lifespan !== null) {
                $lifespans[] = $lifespan;
            }
        }

        return new LineageSummary(
            [],
            $this->averageRounded($generationLengths),
            $this->averageRounded($lifespans),
            $this->oldestIndividuals($individuals),
            $this->oldestIndividuals($individuals, 'M'),
            $this->oldestIndividuals($individuals, 'F')
        );
    }

    /**
     * Detect repeated biological ancestor/descendant positions in the selected direct-line generations.
     *
     * @param array<int,LineageRow> $ancestorRows
     * @param array<int,LineageRow> $descendantRows
     * @return LineageImplexSummary
     */
    private function lineageImplexSummary(array $ancestorRows, array $descendantRows): LineageImplexSummary
    {
        $ancestorDepth = $this->maxLineageDepth($ancestorRows);
        $descendantDepth = $this->maxLineageDepth($descendantRows);

        $ancestors = $ancestorDepth > 0 ? $this->repeatedLineagePositions($ancestorDepth, 'ancestors') : [];
        $descendants = $descendantDepth > 0 ? $this->repeatedLineagePositions($descendantDepth, 'descendants') : [];

        return new LineageImplexSummary(
            $ancestors,
            $descendants,
            $ancestors !== [],
            $descendants !== [],
            $ancestors !== [] || $descendants !== []
        );
    }

    /**
     * @param array<int,LineageRow> $rows
     * @return int
     */
    private function maxLineageDepth(array $rows): int
    {
        $maxDepth = 0;

        foreach ($rows as $row) {
            $maxDepth = max($maxDepth, (int) $row->generation - 1);
        }

        return $maxDepth;
    }

    /**
     * @param int $maxDepth
     * @param string $direction
     * @return array<string,RepeatedLineagePerson>
     */
    private function repeatedLineagePositions(int $maxDepth, string $direction): array
    {
        $positionsByXref = [];
        $current = [[
            'individual' => $this->proband->indi,
            'path' => [$this->proband->indi->xref()],
        ]];

        for ($depth = 1; $depth <= $maxDepth; $depth++) {
            $next = [];

            foreach ($current as $position) {
                $relatives = $direction === 'ancestors'
                    ? $this->biologicalParents($position['individual'])
                    : $this->biologicalChildren($position['individual']);

                foreach ($relatives as $relative) {
                    $path = [...$position['path'], $relative->xref()];
                    $pathKey = implode('>', $path);
                    $positionsByXref[$relative->xref()]['individual'] = $relative;
                    $positionsByXref[$relative->xref()]['paths'][$pathKey] = $path;
                    $positionsByXref[$relative->xref()]['generations'][$depth] = true;

                    if (!in_array($relative->xref(), $position['path'], true)) {
                        $next[] = [
                            'individual' => $relative,
                            'path' => $path,
                        ];
                    }
                }
            }

            $current = $next;
        }

        $repeated = [];
        foreach ($positionsByXref as $xref => $position) {
            $pathCount = count($position['paths'] ?? []);

            if ($pathCount > 1) {
                $repeated[$xref] = new RepeatedLineagePerson(
                    $position['individual'],
                    $pathCount,
                    array_keys($position['generations'] ?? [])
                );
            }
        }

        uasort($repeated, static fn (RepeatedLineagePerson $a, RepeatedLineagePerson $b): int => $b->pathCount <=> $a->pathCount ?: $a->individual->fullName() <=> $b->individual->fullName());

        return $repeated;
    }

    /**
     * @param Individual $individual
     * @return array<string,Individual>
     */
    private function biologicalParents(Individual $individual): array
    {
        $parents = [];

        foreach ($individual->childFamilies() as $family) {
            if (!$this->isBiologicalChildInFamily($individual, $family)) {
                continue;
            }

            foreach ($family->spouses() as $parent) {
                $parents[$parent->xref()] = $parent;
            }
        }

        return $parents;
    }

    /**
     * @param Individual $individual
     * @return array<string,Individual>
     */
    private function biologicalChildren(Individual $individual): array
    {
        $children = [];

        foreach ($individual->spouseFamilies() as $family) {
            foreach ($family->children() as $child) {
                if ($this->isBiologicalChildInFamily($child, $family)) {
                    $children[$child->xref()] = $child;
                }
            }
        }

        return $children;
    }

    /**
     * @param Individual $individual
     * @return int|null
     */
    private function individualBirthYear(Individual $individual): ?int
    {
        $birthDate = $individual->getBirthDate();

        if (!$birthDate->isOK()) {
            return null;
        }

        $year = $birthDate->gregorianYear();

        return $year === 0 ? null : $year;
    }

    /**
     * @param Individual $individual
     * @return int|null
     */
    private function individualLifespan(Individual $individual): ?int
    {
        $birthDate = $individual->getBirthDate();
        $deathDate = $individual->getDeathDate();

        if (!$birthDate->isOK() || !$deathDate->isOK()) {
            return null;
        }

        return max(0, (int) round(($deathDate->julianDay() - $birthDate->julianDay()) / 365.2425));
    }

    /**
     * @param Individual $individual
     * @return int|null
     */
    private function individualFirstMarriageAge(Individual $individual): ?int
    {
        $birthDate = $individual->getBirthDate();

        if (!$birthDate->isOK()) {
            return null;
        }

        $marriageJulianDay = null;
        foreach ($individual->spouseFamilies() as $family) {
            $marriageDate = $family->getMarriageDate();

            if ($marriageDate->isOK() && ($marriageJulianDay === null || $marriageDate->julianDay() < $marriageJulianDay)) {
                $marriageJulianDay = $marriageDate->julianDay();
            }
        }

        if ($marriageJulianDay === null || $marriageJulianDay < $birthDate->julianDay()) {
            return null;
        }

        return (int) round(($marriageJulianDay - $birthDate->julianDay()) / 365.2425);
    }

    /**
     * @param Individual $individual
     * @return int
     */
    private function biologicalChildrenCount(Individual $individual): int
    {
        return count($this->biologicalChildren($individual));
    }

    /**
     * Is this individual a biological child in this family?
     *
     * @param Individual $individual
     * @param Family $family
     * @return bool
     */
    private function isBiologicalChildInFamily(Individual $individual, Family $family): bool
    {
        $fact = $individual->facts(['FAMC'])->first(static fn (Fact $fact): bool => $fact->value() === '@' . $family->xref() . '@');

        if ($fact instanceof Fact) {
            return ($fact->attribute('PEDI') ?: PedigreeLinkageType::VALUE_BIRTH) === PedigreeLinkageType::VALUE_BIRTH;
        }

        return true;
    }

    /**
     * @param array<int,int> $values
     * @return int|null
     */
    private function averageRounded(array $values): ?int
    {
        if ($values === []) {
            return null;
        }

        return (int) round(array_sum($values) / count($values));
    }

    /**
     * @param array<string,Individual> $individuals
     * @param string|null $sex
     * @return OldestIndividuals|null
     */
    private function oldestIndividuals(array $individuals, ?string $sex = null): ?OldestIndividuals
    {
        $oldest = [];
        $oldestAge = null;

        foreach ($individuals as $individual) {
            if ($sex !== null && $individual->sex() !== $sex) {
                continue;
            }

            $lifespan = $this->individualLifespan($individual);
            if ($lifespan === null) {
                continue;
            }

            if ($oldestAge === null || $lifespan > $oldestAge) {
                $oldestAge = $lifespan;
                $oldest = [$individual];
            } elseif ($lifespan === $oldestAge) {
                $oldest[] = $individual;
            }
        }

        if ($oldestAge === null) {
            return null;
        }

        return new OldestIndividuals($oldestAge, $oldest);
    }

    /**
     * Calculate optional summary statistics for the unique individuals currently shown.
     *
     * @param Collection<int,Individual> $individuals
     * @return SummaryStatistics
     */
    private function summaryStatistics(Collection $individuals): SummaryStatistics
    {
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

        $living = new LivingStatistics(
            $livingCount > 0 && $deceasedCount > 0,
            $livingCount,
            $deceasedCount,
            $total > 0 ? $livingCount / $total : 0,
            $total > 0 ? $deceasedCount / $total : 0
        );

        $sexCategoriesShown = count(array_filter([$maleCount, $femaleCount, $otherSexCount], static fn (int $count): bool => $count > 0));
        $sex = new SexStatistics(
            $sexCategoriesShown > 1,
            $maleCount,
            $femaleCount,
            $otherSexCount,
            $total > 0 ? $maleCount / $total : 0,
            $total > 0 ? $femaleCount / $total : 0,
            $total > 0 ? $otherSexCount / $total : 0
        );

        $dateRangeEndJulianDay = $livingCount > 0 ? Registry::timestampFactory()->now()->julianDay() : $latestDeathJulianDay;
        $dateRange = new DateRangeStatistics(
            $earliestBirthDate !== null && $dateRangeEndJulianDay > 0 && $earliestBirthJulianDay < $dateRangeEndJulianDay,
            $earliestBirthDate?->display(),
            $earliestBirthDate instanceof Date ? $this->summaryDateType($earliestBirthDate) : null,
            $livingCount > 0 ? null : $latestDeathDate?->display(),
            $livingCount > 0 ? 'today' : ($latestDeathDate instanceof Date ? $this->summaryDateType($latestDeathDate) : null),
            $livingCount > 0
        );

        return new SummaryStatistics($living, $sex, $dateRange);
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

            if ($propName === 'godparents_witnesses') {
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
                if (!isset($group->entries) || !is_iterable($group->entries)) {
                    continue;
                }

                foreach ($group->entries as $entry) {
                    $individual = $entry->individual ?? $entry->associatedIndividual ?? null;
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

            if ($propName === 'godparents_witnesses') {
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
                if (isset($group->entries) && is_iterable($group->entries)) {
                    foreach ($group->entries as $entry) {
                        $family = $entry->family ?? $entry->referenceFamily ?? null;
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
