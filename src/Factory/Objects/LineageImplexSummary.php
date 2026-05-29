<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Repeated direct-line positions in ancestor and descendant branches.
 */
class LineageImplexSummary
{
    /**
     * @param array<string,RepeatedLineagePerson> $ancestors
     * @param array<string,RepeatedLineagePerson> $descendants
     */
    public function __construct(
        public array $ancestors,
        public array $descendants,
        public bool $hasAncestors,
        public bool $hasDescendants,
        public bool $hasAny
    ) {
    }
}
