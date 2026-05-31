<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * Proband context used while calculating and rendering the extended family.
 */
class ExtendedFamilyProband
{
    /**
     * @param array<int,string> $labels
     * @param array<int,string> $sosaLabels
     */
    public function __construct(
        public Individual $indi,
        public NiceName $niceName,
        public array $labels,
        public array $sosaLabels = []
    ) {
    }
}
