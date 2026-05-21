<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily\Services;

use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Gedcom;
use Fisharebest\Webtrees\GedcomRecord;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Media;
use Fisharebest\Webtrees\Note;
use Fisharebest\Webtrees\Registry;
use Fisharebest\Webtrees\Repository;
use Fisharebest\Webtrees\Session;
use Fisharebest\Webtrees\Source;
use Fisharebest\Webtrees\Submitter;
use RuntimeException;

/**
 * Add records and their linked records to the standard webtrees clippings cart.
 */
class ClippingsCartWriter
{
    /** @var array<int,string> */
    private array $record_stack = [];

    /**
     * Add a family, its spouses and all linked records.
     *
     * @param Family $family
     */
    public function addFamilyToCart(Family $family): void
    {
        if (!$family->canShow() || !$this->beginRecord($family)) {
            return;
        }

        try {
            foreach ($family->spouses() as $spouse) {
                $this->addIndividualToCart($spouse);
            }

            $this->addLocationLinksToCart($family);
            $this->addMediaLinksToCart($family);
            $this->addNoteLinksToCart($family);
            $this->addSourceLinksToCart($family);
            $this->addSubmitterLinksToCart($family);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * Add an individual and all linked records.
     *
     * @param Individual $individual
     */
    public function addIndividualToCart(Individual $individual): void
    {
        if (!$individual->canShow() || !$this->beginRecord($individual)) {
            return;
        }

        try {
            $this->addLocationLinksToCart($individual);
            $this->addMediaLinksToCart($individual);
            $this->addNoteLinksToCart($individual);
            $this->addSourceLinksToCart($individual);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * Add a record XREF to the clippings cart and enter its recursion path.
     *
     * @param GedcomRecord $record
     * @return bool true if the record was newly added
     */
    private function beginRecord(GedcomRecord $record): bool
    {
        $record_key = $this->recordKey($record);

        if (in_array($record_key, $this->record_stack, true)) {
            $path = $this->record_stack;
            $path[] = $record_key;

            throw new RuntimeException('Loop detected while adding records to the clippings cart: ' . implode(' -> ', $path));
        }

        $cart = Session::get('cart');
        $cart = is_array($cart) ? $cart : [];

        $tree = $record->tree()->name();
        $xref = $record->xref();

        if (($cart[$tree][$xref] ?? false) !== false) {
            return false;
        }

        $cart[$tree][$xref] = true;
        Session::put('cart', $cart);

        $this->record_stack[] = $record_key;

        return true;
    }

    /**
     * Leave the current record recursion path.
     *
     * @return void
     */
    private function endRecord(): void
    {
        array_pop($this->record_stack);
    }

    /**
     * Build a stable recursion key for a GEDCOM record.
     *
     * @param GedcomRecord $record
     * @return string
     */
    private function recordKey(GedcomRecord $record): string
    {
        return $record->tree()->name() . ':' . $record->xref();
    }

    /**
     * @param object $location
     */
    private function addLocationToCart($location): void
    {
        if (!$location instanceof GedcomRecord || !$location->canShow() || !$this->beginRecord($location)) {
            return;
        }

        try {
            $this->addLocationLinksToCart($location);
            $this->addMediaLinksToCart($location);
            $this->addNoteLinksToCart($location);
            $this->addSourceLinksToCart($location);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * @param GedcomRecord $record
     */
    private function addLocationLinksToCart(GedcomRecord $record): void
    {
        if (!class_exists('Fisharebest\\Webtrees\\Location') || !method_exists(Registry::class, 'locationFactory')) {
            return;
        }

        preg_match_all('/\n\d _LOC @(' . Gedcom::REGEX_XREF . ')@/', $record->gedcom(), $matches);

        foreach ($matches[1] as $xref) {
            $location = Registry::locationFactory()->make($xref, $record->tree());

            if ($location instanceof GedcomRecord && $location->canShow()) {
                $this->addLocationToCart($location);
            }
        }
    }

    /**
     * @param Media $media
     */
    private function addMediaToCart(Media $media): void
    {
        if (!$media->canShow() || !$this->beginRecord($media)) {
            return;
        }

        try {
            $this->addNoteLinksToCart($media);
            $this->addSourceLinksToCart($media);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * @param GedcomRecord $record
     */
    private function addMediaLinksToCart(GedcomRecord $record): void
    {
        preg_match_all('/\n\d OBJE @(' . Gedcom::REGEX_XREF . ')@/', $record->gedcom(), $matches);

        foreach ($matches[1] as $xref) {
            $media = Registry::mediaFactory()->make($xref, $record->tree());

            if ($media instanceof Media && $media->canShow()) {
                $this->addMediaToCart($media);
            }
        }
    }

    /**
     * @param Note $note
     */
    private function addNoteToCart(Note $note): void
    {
        if (!$note->canShow() || !$this->beginRecord($note)) {
            return;
        }

        try {
            $this->addMediaLinksToCart($note);
            $this->addSourceLinksToCart($note);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * @param GedcomRecord $record
     */
    private function addNoteLinksToCart(GedcomRecord $record): void
    {
        preg_match_all('/\n\d NOTE @(' . Gedcom::REGEX_XREF . ')@/', $record->gedcom(), $matches);

        foreach ($matches[1] as $xref) {
            $note = Registry::noteFactory()->make($xref, $record->tree());

            if ($note instanceof Note && $note->canShow()) {
                $this->addNoteToCart($note);
            }
        }
    }

    /**
     * @param Source $source
     */
    private function addSourceToCart(Source $source): void
    {
        if (!$source->canShow() || !$this->beginRecord($source)) {
            return;
        }

        try {
            $this->addMediaLinksToCart($source);
            $this->addNoteLinksToCart($source);
            $this->addRepositoryLinksToCart($source);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * @param GedcomRecord $record
     */
    private function addSourceLinksToCart(GedcomRecord $record): void
    {
        preg_match_all('/\n\d SOUR @(' . Gedcom::REGEX_XREF . ')@/', $record->gedcom(), $matches);

        foreach ($matches[1] as $xref) {
            $source = Registry::sourceFactory()->make($xref, $record->tree());

            if ($source instanceof Source && $source->canShow()) {
                $this->addSourceToCart($source);
            }
        }
    }

    /**
     * @param Repository $repository
     */
    private function addRepositoryToCart(Repository $repository): void
    {
        if (!$repository->canShow() || !$this->beginRecord($repository)) {
            return;
        }

        try {
            $this->addNoteLinksToCart($repository);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * @param GedcomRecord $record
     */
    private function addRepositoryLinksToCart(GedcomRecord $record): void
    {
        preg_match_all('/\n\d REPO @(' . Gedcom::REGEX_XREF . ')@/', $record->gedcom(), $matches);

        foreach ($matches[1] as $xref) {
            $repository = Registry::repositoryFactory()->make($xref, $record->tree());

            if ($repository instanceof Repository && $repository->canShow()) {
                $this->addRepositoryToCart($repository);
            }
        }
    }

    /**
     * @param Submitter $submitter
     */
    private function addSubmitterToCart(Submitter $submitter): void
    {
        if (!$submitter->canShow() || !$this->beginRecord($submitter)) {
            return;
        }

        try {
            $this->addNoteLinksToCart($submitter);
        } finally {
            $this->endRecord();
        }
    }

    /**
     * @param GedcomRecord $record
     */
    private function addSubmitterLinksToCart(GedcomRecord $record): void
    {
        preg_match_all('/\n\d SUBM @(' . Gedcom::REGEX_XREF . ')@/', $record->gedcom(), $matches);

        foreach ($matches[1] as $xref) {
            $submitter = Registry::submitterFactory()->make($xref, $record->tree());

            if ($submitter instanceof Submitter && $submitter->canShow()) {
                $this->addSubmitterToCart($submitter);
            }
        }
    }
}
