<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Summary data for one filtered extended-family result.
 */
class ExtendedFamilySummary
{
    public int $allCount = 0;

    public int $allCountUnique = 0;

    /** @var array<int,string> */
    public array $summaryMessageEmptyBlocks = [];

    public ?object $statistics = null;

    public ?object $lineageStatistics = null;

    public ?FamilyRoleLoopSummary $familyRoleLoops = null;

    /** @var array<int,array{count:int,individuals:array<int,\Fisharebest\Webtrees\Individual>}> */
    public array $degrees = [];

    /** @var array<string,array{degrees:array<int,int>,paths:array<int,string>}> */
    public array $degreeData = [];
}
