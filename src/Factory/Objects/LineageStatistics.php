<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Direct-line statistics for one filtered extended-family result.
 */
class LineageStatistics
{
    public ?LineageSummary $ancestors = null;

    public ?LineageSummary $descendants = null;

    public ?LineageSummary $combined = null;

    public ?LineageImplexSummary $implex = null;
}
