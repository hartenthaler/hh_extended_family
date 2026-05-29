<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * One precomputed extended-family result for a single filter option.
 */
class ExtendedFamilyFilterResult
{
    public ExtendedFamilyPartSet $efp;

    public function __construct()
    {
        $this->efp = new ExtendedFamilyPartSet();
    }

    public function __clone()
    {
        $this->efp = clone $this->efp;
    }
}
