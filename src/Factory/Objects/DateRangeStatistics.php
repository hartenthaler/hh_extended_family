<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

class DateRangeStatistics
{
    public function __construct(
        public bool $show,
        public ?string $startDate,
        public ?string $startDateType,
        public ?string $endDate,
        public ?string $endDateType,
        public bool $endIsToday
    ) {
    }
}
