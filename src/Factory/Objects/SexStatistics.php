<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

class SexStatistics
{
    public function __construct(
        public bool $show,
        public int $maleCount,
        public int $femaleCount,
        public int $otherSexCount,
        public float $malePercent,
        public float $femalePercent,
        public float $otherSexPercent
    ) {
    }
}
