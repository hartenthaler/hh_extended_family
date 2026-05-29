<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

class LivingStatistics
{
    public function __construct(
        public bool $show,
        public int $livingCount,
        public int $deceasedCount,
        public float $livingPercent,
        public float $deceasedPercent
    ) {
    }
}
