<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

/**
 * Runtime configuration assembled from module and tree preferences.
 */
class ExtendedFamilyConfig
{
    /**
     * @param array<int,string> $filterOptions
     * @param array<string,object> $shownFamilyParts
     * @param array<string,array<string,mixed>> $familyPartParameters
     */
    public function __construct(
        public bool $showFilterOptions,
        public array $filterOptions,
        public bool $showSummary,
        public bool $showSummaryStatistics,
        public string $showEmptyBlock,
        public bool $countPartnerChainsToTotal,
        public bool $showPrintButton,
        public bool $showShortName,
        public bool $showLabels,
        public bool $showSosaNumbers,
        public bool $showRelationshipToProband,
        public bool $useCompactDesign,
        public bool $useClippingsCart,
        public array $shownFamilyParts,
        public bool $showParameters,
        public array $familyPartParameters,
        public int $placeFormat,
        public bool $showThumbnail,
        public int $sizeThumbnailW,
        public int $sizeThumbnailH
    ) {
    }
}
