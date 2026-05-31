<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

/**
 * One rendered member entry inside an extended-family group.
 */
class GroupEntry
{
    /**
     * @param array<int,string> $labels
     * @param array<int,Individual> $referencePersons
     * @param array<int,string> $sosaLabels
     */
    public function __construct(
        public Individual $individual,
        public ?Family $family,
        public string $familyStatus,
        public array $referencePersons,
        public array $labels,
        public string $vitalEventsSummary,
        public array $sosaLabels = []
    ) {
    }
}
