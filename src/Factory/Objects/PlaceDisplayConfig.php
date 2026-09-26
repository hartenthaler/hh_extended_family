<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/** Configuration for rendering event places. */
final class PlaceDisplayConfig
{
    public const SOURCE_PLAC = 'plac';
    public const SOURCE_LOC_HISTORICAL = 'loc_historical';
    public const SOURCE_LOC_CURRENT = 'loc_current';

    /**
     * @param array<int,string> $sources
     */
    public function __construct(
        public readonly array $sources = [self::SOURCE_PLAC],
        public readonly int $variant = PlaceAbbreviation::OPTION_FULL_PLACE_NAME
    ) {
    }

    public function uses(string $source): bool
    {
        return in_array($source, $this->sources, true);
    }
}
