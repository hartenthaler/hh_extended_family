<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * One compact family role loop / matrimonial circuit candidate.
 */
class FamilyRoleLoop
{
    /**
     * @param array<int,FamilyRoleLoopStep> $steps
     * @param array<int,string> $familyXrefs
     */
    public function __construct(
        public array $steps,
        public int $spouseEdgeCount,
        public int $descentEdgeCount,
        public array $familyXrefs
    ) {
    }
}
