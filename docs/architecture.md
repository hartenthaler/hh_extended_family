# 🧭 Extended Family Module - Architecture

This document describes the internal structure of the `hh_extended_family` custom module for **webtrees**.
It is intended as an orientation for maintenance, refactoring, and future feature work.

## 🎯 Purpose

The module adds an **Extended family** tab to the webtrees individual page.
For the selected person, the tab calculates relationship groups such as grandparents, parents, siblings, cousins, in-laws, descendants, and partner chains.

The module does not persist calculated relationships.
It derives them from the existing webtrees family and individual records at render time.

## 🧩 Core concepts

### Proband

The proband is the individual whose tab is currently being displayed.
All calculated family parts are relative to this person.

### Family part

A family part is one relationship group, for example `parents`, `siblings`, `children`, or `grandchildren_in_law`.
Each family part has its own calculation class under `src/Factory/ExtendedFamilyParts/`.

### Filter variant

The module can build the family view for multiple filter options.
Filter options include all relatives, sex or gender groups, and living/deceased state.
The tab then switches between the precomputed variants.

### Presentation configuration

The module configuration controls order, visibility, labels, design density, thumbnails, summary counts, place formatting, and clippings-cart support.
Most values come from webtrees module preferences and are assembled into a runtime configuration object.

## 🧱 Main components

### `ExtendedFamilyTabModule`

`ExtendedFamilyTabModule.php` is the webtrees integration point.
It registers the module as an individual-page tab and provides the administrative settings screen.

Main responsibilities:

* expose module metadata, title, description, and version
* build the runtime configuration for the current tree
* render the individual tab content
* render and persist control-panel settings
* decide whether the tab should be visible for an individual
* provide custom translations

### `ExtendedFamily`

`ExtendedFamily.php` coordinates the actual calculation.
It receives the proband and the runtime configuration, builds all configured filter variants, creates the configured family parts, and stores summary counts.

The result is an object model consumed by the tab view.

### `ExtendedFamilyPart`

`src/Factory/ExtendedFamilyPart.php` is the abstract base class for all family-part calculators.
It provides common helpers for traversing webtrees families and individuals, adding people to groups, applying filters, collecting counters, and deriving labels.

Concrete family-part classes implement the relationship-specific logic.

### `ExtendedFamilyPartFactory`

`src/Factory/ExtendedFamilyPartFactory.php` creates the concrete family-part calculator class from the configured family-part name.
The current implementation relies on the naming convention between preference keys and PHP class names.

### Support objects

Objects under `src/Factory/Objects/` hold supporting data and helper behavior.
Important examples are:

* `ExtendedFamilySupport`: lists configurable family parts and filter options
* `FamilyPart`: describes one configured family part
* `IndividualFamily`: wraps individual/family relationship context
* `ProbandName`: formats the proband name for the tab
* `PartnerChainNode` and `PartnerChainPerson`: represent partner-chain structures
* `PlaceAbbreviation`: supports compact place display

### Clippings-cart writer

`src/Services/ClippingsCartWriter.php` implements the internal fallback for copying the extended family to the standard webtrees clippings cart.
It accepts the already filtered individual and family collections from `ExtendedFamily`, adds their XREFs to the session cart, and recursively follows linked records such as `SOUR`, `NOTE`, `OBJE`, `REPO`, `_LOC`, and `SUBM`.

The writer tracks the current recursion path.
If a linked-record loop is detected, for example `OBJE -> SOUR -> OBJE`, `_LOC -> _LOC`, or `SOUR -> NOTE -> SOUR`, it throws a `RuntimeException` with the detected path instead of recursing indefinitely.

## 🔄 Data flow

The typical tab-rendering flow is:

1. webtrees opens the individual page.
1. `ExtendedFamilyTabModule::getTabContent()` is called for the selected individual.
1. `ExtendedFamilyTabModule::buildConfig()` reads module preferences and builds the runtime configuration.
1. `ExtendedFamilyTabModule::getExtendedFamily()` creates an `ExtendedFamily` object.
1. `ExtendedFamily` loops through the configured filter options.
1. For each filter option, the module creates each enabled family part through `ExtendedFamilyPartFactory`.
1. Each concrete family-part class finds its relatives using webtrees family and individual APIs.
1. The abstract base class applies filters and calculates counters.
1. The tab view renders the computed family groups.

The administrative flow is separate:

1. `getAdminAction()` reads current preferences and renders `resources/views/settings.phtml`.
1. The settings view lets administrators reorder family parts and change display options.
1. `postAdminAction()` persists the submitted preferences.
1. Later tab renders use the new configuration.

The clippings-cart flow depends on the selected action:

1. `getTabContent()` checks whether huhwt-cce is installed, active, and accessible for the current tree and user.
1. If huhwt-cce is selected and available, the tab button routes to `ClippingsCartEnhancedModule` with action `clip_hhEF`.
1. If huhwt-cce is unavailable or the internal action is selected, the button posts to this module's `ClippingsCart` action.
1. `postClippingsCartAction()` rebuilds the current extended-family data, applies the selected filter, and delegates the filtered collections to `ExtendedFamily::addExtendedFamilyToClippingsCart()`.
1. The internal `ClippingsCartWriter` adds the records and their linked records to the session cart.

## 👥 Family part model

Each concrete family-part class represents one relationship group.
The module currently contains calculators for:

* great-grandparents
* grandparents
* parents
* parents-in-law
* co-parents-in-law
* uncles and aunts
* uncles and aunts by marriage
* partners and partner chains
* siblings
* siblings-in-law
* co-siblings-in-law
* cousins
* nephews and nieces
* children
* children-in-law
* grandchildren
* grandchildren-in-law

The family-part base class stores results as grouped individuals and counters.
Depending on the relationship type, a group may represent a family branch, a couple, an in-law relation, or a partner-chain segment.

## 🔎 Filtering and summaries

Filters are applied after a family part has collected its candidate relatives.
The module can filter by sex or gender category and by living/deceased state.

For each filter variant, the module calculates counters for:

* male
* female
* unknown
* other
* all

The summary section can include or exclude partner-chain members, depending on the administrator setting.

Because filter variants are built eagerly, adding additional filters increases the amount of calculation done during tab rendering.
This keeps the view simple, but it is a point to consider if more expensive relationship searches are added later.

## ⚙️ Configuration

The module stores its settings as webtrees module preferences.
There is no custom database schema.

Important preference groups:

* shown family parts and their display order
* user-visible filter options
* compact or enriched design
* thumbnails and vital data
* summary counts
* empty-block handling
* label and relationship-parameter display
* event-place display format
* clippings-cart integration

`ExtendedFamilyTabModule::buildConfig()` converts these preferences into a runtime configuration object.
The calculation and views use this object instead of reading preferences directly.

## 🖥 User interface

The user-facing tab is rendered by `resources/views/tab.phtml`.
The control-panel settings page is rendered by `resources/views/settings.phtml`.

The settings page contains a sortable family-part table.
The ordering is persisted through module preferences and later used when the tab creates family parts.

The settings page also controls whether users see the clippings-cart button.
When huhwt-cce is available, administrators can choose between huhwt-cce and the internal Extended Family action.
When huhwt-cce is not available, the internal action is used automatically.

The module currently disables Ajax loading for the tab.
The tab content is rendered as part of the individual page request.

## 🌍 Translations

Translations are provided by gettext files in `resources/lang/*.po` and registered through the module's custom translation support.

## 📁 File structure

The module's source code is organized into the following directories
(only important files are shown):
```text
hh_extended_family/
├── ExtendedFamilyTabModule.php
├── ExtendedFamily.php
├── ExtendedFamilyPersonExists.php
├── module.php
├── resources/
│   ├── lang/
│   │   ├── messages.pot
│   │   └── *.po
│   └── views/
│       ├── settings.phtml
│       └── tab.phtml
├── src/
│   ├── Factory/
│   │   ├── ExtendedFamilyPart.php
│   │   ├── ExtendedFamilyPartFactory.php
│   │   ├── ExtendedFamilyParts/
│   │   └── Objects/
│   └── Services/
│       └── ClippingsCartWriter.php
└── docs/
    └── images/
```

## 🚧 Known limitations and design notes

The factory currently depends on class-name conventions.
When new family parts are added, the preference key, class name, and translation strings must stay aligned.

Filter variants are calculated eagerly.
This is straightforward and keeps the templates simple, but it may need optimization if more filters or more expensive relationship searches are introduced.

The module uses existing GEDCOM and webtrees APIs as its source of truth.
It should avoid persisting derived relationship results unless there is a clear cache invalidation strategy.

Partner-chain handling is a unique feature of this module. It is more complex than most other family parts.
Changes in this area should be tested with simple couples, multiple partnerships, and longer partner chains.
