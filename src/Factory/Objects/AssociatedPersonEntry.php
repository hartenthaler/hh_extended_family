<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Individual;

/**
 * One association entry for godparents, witnesses, and other linked persons.
 */
class AssociatedPersonEntry
{
    public function __construct(
        public ?Individual $associatedIndividual,
        public string $associatedName,
        public string $role,
        public string $event,
        public ?Individual $referenceIndividual,
        public ?Family $referenceFamily,
        public string $sourceTag
    ) {
    }
}
