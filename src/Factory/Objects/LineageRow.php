<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * One generation row in the direct-line statistics table.
 */
class LineageRow
{
    /**
     * @param array<int,Individual> $individuals
     */
    public function __construct(
        public int $generation,
        public string $relation,
        public array $individuals,
        public int $totalCount,
        public int $biologicalCount,
        public int $birthYearCount,
        public int $biologicalBirthYearCount,
        public ?int $earliestBirthYear,
        public ?int $latestBirthYear,
        public ?int $averageBirthYear,
        public ?int $averageMarriageAge,
        public ?int $generationLength,
        public ?int $averageLifespan,
        public ?int $averageChildren
    ) {
    }
}
