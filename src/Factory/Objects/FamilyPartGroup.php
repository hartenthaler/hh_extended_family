<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

/**
 * One rendered group inside an extended-family part.
 */
class FamilyPartGroup
{
    /**
     * @param array<int,GroupEntry> $entries
     */
    public function __construct(
        public string $groupName = '',
        public array $entries = [],
        public ?Individual $partner = null,
        public ?Family $family = null,
        public string $familyStatus = '',
        public string $partnerFamilyStatus = ''
    ) {
    }

    public function addEntry(GroupEntry $entry): void
    {
        $this->entries[] = $entry;
    }
}
