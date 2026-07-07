<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * One person and the relationship edge to the next person in a family role loop.
 */
class FamilyRoleLoopStep
{
    public function __construct(
        public Individual $individual,
        public string $relationToNext,
        public string $edgeType,
        public bool $canShow,
        public string $name,
        public string $url
    ) {
    }
}
