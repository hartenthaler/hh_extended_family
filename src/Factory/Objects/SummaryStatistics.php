<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Optional summary statistics for the unique individuals currently shown.
 */
class SummaryStatistics
{
    public function __construct(
        public LivingStatistics $living,
        public SexStatistics $sex,
        public DateRangeStatistics $dateRange
    ) {
    }
}
