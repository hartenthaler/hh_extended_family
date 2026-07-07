<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Family role loops detected in the displayed extended-family graph.
 */
class FamilyRoleLoopSummary
{
    /**
     * @param array<int,FamilyRoleLoop> $loops
     */
    public function __construct(
        public array $loops = []
    ) {
    }

    public function hasAny(): bool
    {
        return $this->loops !== [];
    }

    public function count(): int
    {
        return count($this->loops);
    }
}
