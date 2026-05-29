<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * One person appearing in more than one direct-line position.
 */
class RepeatedLineagePerson
{
    /**
     * @param array<int,int> $generations
     */
    public function __construct(
        public Individual $individual,
        public int $pathCount,
        public array $generations
    ) {
    }
}
