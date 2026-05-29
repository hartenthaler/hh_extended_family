<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * Sex and total counters for a calculated family part.
 */
class FamilyPartCounts
{
    public function __construct(
        public int $maleCount = 0,
        public int $femaleCount = 0,
        public int $otherSexCount = 0,
        public int $allCount = 0
    ) {
    }

    /**
     * @param array<int,Individual> $individuals
     */
    public static function fromIndividuals(array $individuals): self
    {
        $counts = new self();

        foreach ($individuals as $individual) {
            if (!$individual instanceof Individual) {
                continue;
            }

            if ($individual->sex() === 'M') {
                $counts->maleCount++;
            } elseif ($individual->sex() === 'F') {
                $counts->femaleCount++;
            } else {
                $counts->otherSexCount++;
            }
        }

        $counts->allCount = $counts->maleCount + $counts->femaleCount + $counts->otherSexCount;

        return $counts;
    }

    public function add(self $counts): void
    {
        $this->maleCount += $counts->maleCount;
        $this->femaleCount += $counts->femaleCount;
        $this->otherSexCount += $counts->otherSexCount;
        $this->allCount += $counts->allCount;
    }

    public function subtract(self $counts): self
    {
        return new self(
            $this->maleCount - $counts->maleCount,
            $this->femaleCount - $counts->femaleCount,
            $this->otherSexCount - $counts->otherSexCount,
            $this->allCount - $counts->allCount
        );
    }
}
