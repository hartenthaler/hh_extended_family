<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * Oldest known individual or tied individuals in a statistic group.
 */
class OldestIndividuals
{
    /**
     * @param array<int,Individual> $individuals
     */
    public function __construct(
        public int $age,
        public array $individuals
    ) {
    }
}
