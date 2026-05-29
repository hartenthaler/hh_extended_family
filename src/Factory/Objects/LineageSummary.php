<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Aggregated direct-line statistics for ancestors, descendants, or both.
 */
class LineageSummary
{
    /**
     * @param array<int,LineageRow> $rows
     */
    public function __construct(
        public array $rows = [],
        public ?int $averageGenerationLength = null,
        public ?int $averageLifespan = null,
        public ?OldestIndividuals $oldest = null,
        public ?OldestIndividuals $oldestMale = null,
        public ?OldestIndividuals $oldestFemale = null
    ) {
    }
}
