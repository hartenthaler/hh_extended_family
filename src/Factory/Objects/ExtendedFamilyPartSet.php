<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Family-part collection for one filtered extended-family result.
 *
 * @implements IteratorAggregate<string,object>
 */
class ExtendedFamilyPartSet implements IteratorAggregate
{
    public ExtendedFamilySummary $summary;

    /** @var array<string,object> */
    private array $familyParts = [];

    public function __construct()
    {
        $this->summary = new ExtendedFamilySummary();
    }

    public function __set(string $name, object $familyPart): void
    {
        if ($name === 'summary') {
            if ($familyPart instanceof ExtendedFamilySummary) {
                $this->summary = $familyPart;
            }

            return;
        }

        $this->familyParts[$name] = $familyPart;
    }

    public function __get(string $name): object
    {
        if ($name === 'summary') {
            return $this->summary;
        }

        return $this->familyParts[$name];
    }

    public function __isset(string $name): bool
    {
        return $name === 'summary' || isset($this->familyParts[$name]);
    }

    /**
     * @return Traversable<string,object>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator(['summary' => $this->summary] + $this->familyParts);
    }

    public function __clone()
    {
        $this->summary = clone $this->summary;
    }
}
