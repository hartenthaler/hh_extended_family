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
The active filter also controls the toolbar actions, so Print/PDF and clippings-cart operations use the same variant that is currently visible.

### Presentation configuration

The module configuration controls order, visibility, labels, SOSA labels, design density, thumbnail size, summary counts, place formatting, tab-loading behavior, and clippings-cart support.
Most values come from webtrees module preferences and are assembled into a runtime configuration object.

## 🧱 Main components

### `ExtendedFamilyTabModule`

`ExtendedFamilyTabModule.php` is the webtrees integration point.
It registers the module as an individual-page tab and provides the administrative settings screen.

Main responsibilities:

* expose module metadata, title, description, and version
* build the runtime configuration for the current tree
* render the individual tab content
* render the print-optimized tab content
* render and persist control-panel settings
* decide whether the tab should be visible for an individual
* provide custom translations

### `ExtendedFamily`

`ExtendedFamily.php` coordinates the actual calculation.
It receives the proband and the runtime configuration, builds all configured filter variants, creates the configured family parts, and stores summary counts.
It also prepares summary statistics, direct-line ancestor/descendant statistics, and detected ancestor/descendant implex information for the summary partial.

The result is an object model consumed by the tab view.

### `ExtendedFamilyPart`

`src/Factory/ExtendedFamilyPart.php` is the abstract base class for all family-part calculators.
It provides common helpers for traversing webtrees families and individuals, adding people to groups, applying filters, collecting counters, and deriving labels.
The shared helpers also evaluate `FAMC/PEDI` links, so concrete family parts can distinguish biological, social (adoptive, foster, or Rada), and step relationships without duplicating that logic.

Concrete family-part classes implement the relationship-specific logic.

### `ExtendedFamilyPartFactory`

`src/Factory/ExtendedFamilyPartFactory.php` creates the concrete family-part calculator class from the configured family-part name.
The current implementation relies on the naming convention between preference keys and PHP class names.

### Support objects

Objects under `src/Factory/Objects/` hold supporting data and helper behavior.
Important examples are:

* `ExtendedFamilySupport`: lists configurable family parts and filter options
* `ExtendedFamilyConfig`: stores runtime configuration assembled from module and tree preferences
* `ExtendedFamilyFilterResult`: stores the calculated data for one filter option
* `ExtendedFamilyPartSet`: stores the summary plus the calculated family parts for one filter option
* `ExtendedFamilyProband`: stores the proband individual, display-name variants, proband labels, and optional SOSA labels
* `ExtendedFamilySummary`: stores the summary counts and precomputed summary statistics for one filter option
* `FamilyPart`: compatibility builder for one rendered family-part group
* `FamilyPartCounts`: stores male, female, other/unknown, and total counters for a family part
* `FamilyPartGroup`: stores one rendered group inside a family part
* `GroupEntry`: keeps one rendered person together with its family, family status, reference people, labels, optional SOSA labels, and prepared event summary
* `AssociatedPersonEntry`: keeps one linked person or name together with role, event, and reference person or family for the godparents/witnesses family part
* `SummaryStatistics`, `LivingStatistics`, `SexStatistics`, and `DateRangeStatistics`: store optional summary-statistic data
* `LineageStatistics`, `LineageSummary`, `LineageRow`, `LineageImplexSummary`, `RepeatedLineagePerson`, and `OldestIndividuals`: store direct-line statistics and implex data
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

The Print/PDF flow reuses the same calculated data:

1. The tab toolbar links to the module's `Print` action with the current tree, individual XREF, and filter option.
1. `ExtendedFamilyTabModule::getPrintAction()` rebuilds the extended-family object for the same proband.
1. The requested filter option is validated against the available filter objects.
1. `resources/views/print.phtml` renders a print-optimized page and loads the module CSS.
1. Browser printing is triggered by the view; users can print or save the page as PDF.

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
* grandaunts and granduncles
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
* children
* children-in-law
* nephews and nieces
* grandnephews and grandnieces
* grandchildren
* grandchildren-in-law
* great-grandchildren
* great-grandchildren-in-law
* godparents, witnesses, and other linked persons

The family-part base class stores results as grouped entries and counters.
The canonical data structure for normal family parts is:

```text
ExtendedFamily
├── proband: ExtendedFamilyProband
│   ├── indi: Individual
│   ├── niceName: NiceName
│   ├── labels: array<int,string>
│   └── sosaLabels: array<int,string>
└── filters[filterOption]: ExtendedFamilyFilterResult
    └── efp: ExtendedFamilyPartSet
        ├── summary: ExtendedFamilySummary
        │   ├── allCount: int
        │   ├── allCountUnique: int
        │   ├── summaryMessageEmptyBlocks: array<int,string>
        │   ├── statistics: SummaryStatistics|null
        │   └── lineageStatistics: LineageStatistics|null
        └── <family_part_name>
            ├── groups[]: FamilyPartGroup
            │   ├── groupName: string
            │   ├── entries[]: GroupEntry
            │   ├── partner: Individual|null
            │   ├── family: Family|null
            │   ├── familyStatus: string
            │   └── partnerFamilyStatus: string
            ├── counts: FamilyPartCounts
            │   ├── maleCount: int
            │   ├── femaleCount: int
            │   ├── otherSexCount: int
            │   └── allCount: int
            └── partName: string
```

`ExtendedFamilyConfig` is the typed runtime configuration object passed from the tab module into the calculation layer.
It contains the resolved display, filter, ordering, thumbnail, and integration settings for the current tree.
`ExtendedFamilyFilterResult` represents one precomputed filter variant such as `all`, `only_M`, or `only_alive`.
`ExtendedFamilyProband` stores the selected individual together with the name variants, special labels, and optional SOSA labels that views need repeatedly.
`ExtendedFamilyPartSet` is iterable so existing renderers can loop over `summary` and the concrete family parts in display order.
`ExtendedFamilySummary` stores global counts for the selected filter plus precomputed summary text support data.
Optional summary statistics are split into small value objects:
`SummaryStatistics` contains `LivingStatistics`, `SexStatistics`, and `DateRangeStatistics`.
Direct-line statistics are held by `LineageStatistics`, which can contain ancestor, descendant, combined, and implex summaries.
`LineageRow` stores one generation row for the summary table.
`LineageSummary` stores aggregate values such as average generation length, average lifespan, and oldest known people.
`LineageImplexSummary` stores repeated ancestor/descendant positions using `RepeatedLineagePerson`.
`FamilyPartCounts` is the canonical counter structure for family parts.
The `partners` family part also has `partnerCounts` and `partnerOfPartnerCounts` for its special direct-partner and partner-of-partner subtotals, again with legacy scalar aliases.

`FamilyPartGroup` represents one rendered group inside a family part.
Depending on the relationship type, a group may represent a named family branch, a couple, an in-law relation, or a descendant branch.
Most grouped family parts use `groupName` for the heading and translation.
The `partners` and `parents_in_law` renderers additionally use the optional `partner`, `family`, `familyStatus`, and `partnerFamilyStatus` fields to explain the group heading.

Every `FamilyPartGroup` has an `entries` array.
Every `GroupEntry` contains the rendered individual plus the context that belongs to that exact person:
`individual`, `family`, `familyStatus`, `referencePersons`, `labels`, optional `sosaLabels`, and the prepared `vitalEventsSummary`.
This keeps person-level context on the person entry instead of spreading it across parallel arrays.
The older parallel arrays (`members`, `families`, `familiesStatus`, `referencePersons`, `labels`, and `vitalEventsSummaries`) are no longer populated.

The `partner_chains` family part is the main exception.
It uses the `chains` structure with `PartnerChainNode` and `PartnerChainPerson` because it renders a recursive graph rather than flat groups of entries.

The `godparents_witnesses` family part is another exception.
It searches the current filtered family-part result for GEDCOM `ASSO` and `_ASSO` links and for configured proprietary name tags in individual and family events.
The initial proprietary tag list is `_GODP`, `_WITN`, `_WITNESS`, `_SPON`, and `_SPONSOR`.
Its entries use `AssociatedPersonEntry` because some linked people are normal webtrees individuals while proprietary tags may contain only a name.
The part keeps its own counters, including sex/gender counters, but it is excluded from the extended-family total count and from the unique-member summary count.
The tab header suppresses generation and relationship-coefficient badges for this part because the linked people can belong to any generation.

### Relationship basis map

Every family part should be defined from a clear relationship basis.
Primitive parts may read directly from the proband's webtrees families.
Derived parts should build on the already calculated primitive or lower-distance family part,
so that biological, social, step, and in-law relationship distinctions are propagated consistently.

| Family part | Definition | Basis | Implementation note |
| --- | --- | --- | --- |
| `parents` | Biological, social, and step parents of the proband | Proband plus shared parent helper methods | source-level family part. |
| `grandparents` | Parents and stepparents of the proband's biological, social, and step parents | `parents` | uses `Parents` as basis and preserves biological, social, and step-parent distinctions. |
| `great_grandparents` | Parents and stepparents of the relevant grandparent groups | `grandparents` | uses `Grandparents` as basis and preserves its group distinctions. |
| `grandaunts_uncles` | Siblings and half siblings of the proband's grandparent groups | `grandparents` | uses `Grandparents` as basis and preserves biological, social, and step-grandparent distinctions. |
| `partners` | Direct partners of the proband and partners of those partners | Proband spouse families | source-level family part. |
| `partner_chains` | Recursive partner graph starting at the proband | Proband spouse families | special source-level graph calculation. |
| `children` | Biological, social, and step children of the proband | Proband spouse families plus `FAMC/PEDI` helper methods | source-level descendant family part. |
| `grandchildren` | Children, social children, and stepchildren of the `children` groups | `children` | uses `Children` as basis and preserves biological, social, and step-child distinctions. |
| `great_grandchildren` | Children and stepchildren of the `grandchildren` groups | `grandchildren` | uses `Grandchildren` as basis. |
| `parents_in_law` | Parents of the proband's direct partners | `partners` | uses direct partner helper results plus the shared biological, social, and stepparent helper methods. |
| `co_parents_in_law` | Parents of the partners of the proband's children | `children` | uses `Children` as basis. |
| `children_in_law` | Partners of the proband's biological, social, and step children | `children` | uses `Children` as basis and preserves biological, social, and step-child distinctions. |
| `grandchildren_in_law` | Partners of the persons in the `grandchildren` groups | `grandchildren` | uses `Grandchildren` as basis. |
| `great_grandchild_in_law` | Partners of the persons in the `great_grandchildren` groups | `great_grandchildren` | uses `Great_grandchildren` as basis. |
| `siblings` | Full, half, social, and step siblings of the proband | `parents` | uses `Parents` as basis and preserves biological, social, and step-parent distinctions. |
| `siblings_in_law` | Partners of siblings and siblings of partners | `siblings` and direct partners | uses `Siblings` as basis for the proband side and for each direct partner, preserving full, half, social, and step-sibling distinctions as far as `Siblings` provides them. |
| `co_siblings_in_law` | Siblings of siblings' partners and partners of partners' siblings | `siblings_in_law` and `siblings` | uses `Siblings_in_law` as basis, then derives siblings through `Siblings` and partners through direct spouse-family links. |
| `uncles_and_aunts` | Siblings and half siblings of the proband's parent groups | `parents` | uses `Parents` as basis and preserves biological, social, and step-parent distinctions. |
| `uncles_and_aunts_bm` | Partners of the persons in `uncles_and_aunts` | `uncles_and_aunts` | uses `Uncles_and_aunts` as basis and preserves its group distinctions. |
| `cousins` | Children of the persons in `uncles_and_aunts` | `uncles_and_aunts` | uses `Uncles_and_aunts` as basis and preserves biological, social, step-parent, full-sibling, and half-sibling distinctions. |
| `nephews_and_nieces` | Children of siblings and children of siblings-in-law | `siblings` and `siblings_in_law` | uses `Siblings` for children and stepchildren of siblings, and `Siblings_in_law` for children of partners' siblings. |
| `grandnephews_nieces` | Children and stepchildren of nephews and nieces | `nephews_and_nieces` | uses `Nephews_and_nieces` as basis. |
| `godparents_witnesses` | Godparents, witnesses, and other people linked to visible extended-family persons or families through `ASSO`, `_ASSO`, or configured proprietary event tags | Current filtered family-part result | special derived family part; keeps repeated roles as separate rows, can render name-only entries from proprietary tags, is displayed last, and is not included in extended-family total counts. |

### Administrative degree map

The admin UI can use a coarse family-part degree to help administrators select which family parts should be enabled.
This degree is not the exact person-level graph distance.
It is a local selection aid for family parts.

The core family has degree 1:
parents, children, siblings, and partners.
The partner-chain family part is a special case and has administrative degree 2,
although individual members of a partner chain may later receive their exact person-level degree.

| Family part | Administrative degree | Rationale |
| --- | ---: | --- |
| `parents` | 1 | Parents are part of the proband's core family. |
| `children` | 1 | Children are part of the proband's core family. |
| `siblings` | 1 | Siblings are part of the proband's core family. |
| `partners` | 1 | Partners are part of the proband's core family. |
| `grandparents` | 2 | Parents of parents. |
| `grandchildren` | 2 | Children of children. |
| `uncles_and_aunts` | 2 | Siblings of parents. |
| `nephews_and_nieces` | 2 | Children of siblings. |
| `parents_in_law` | 2 | Parents of partners. |
| `children_in_law` | 2 | Partners of children. |
| `siblings_in_law` | 2 | Partners of siblings or siblings of partners. |
| `partner_chains` | 2 | Special administrative value for partner chains. |
| `great_grandparents` | 3 | Parents of grandparents. |
| `grandaunts_uncles` | 3 | Siblings of grandparents. |
| `grandnephews_nieces` | 3 | Children of nephews and nieces. |
| `great_grandchildren` | 3 | Children of grandchildren. |
| `cousins` | 3 | Children of uncles and aunts. |
| `uncles_and_aunts_bm` | 3 | Partners of uncles and aunts. |
| `co_parents_in_law` | 3 | Parents of partners of children. |
| `co_siblings_in_law` | 3 | Siblings or partners reached through siblings-in-law. |
| `grandchildren_in_law` | 3 | Partners of grandchildren. |
| `great_grandchild_in_law` | 4 | Partners of great-grandchildren. |
| `godparents_witnesses` | 9 | Linked persons are selected through events of the current filtered extended-family result, can belong to any generation, and are treated as remote for the admin quick selection. |

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
The `godparents_witnesses` family part is never included in the extended-family total count or the unique-member summary count.
It still keeps its own member and sex/gender counters for the family-part summary.
It can also render direct-line statistics for selected ancestor and descendant generations.
These statistics are calculated only for direct-line family parts that are currently enabled and non-empty.
The biological column is based on the module's biological relationship groups, not on all visible people in the row.

Ancestor and descendant implex detection is intentionally stricter than the general duplicate-membership warning.
Duplicate membership means that the same person appears in more than one extended-family part.
An implex is reported only when the same person is reachable through more than one biological direct-line path within the selected ancestor or descendant generations.
Partner-chain cycles can indicate a complex relationship network, but they are not themselves treated as ancestor or descendant implex unless they also create repeated biological direct-line paths.

Because filter variants are built eagerly, adding additional filters increases the amount of calculation done during tab rendering.
This keeps the view simple, but it is a point to consider if more expensive relationship searches are added later.

## ⚙️ Configuration

The module stores its settings as webtrees module preferences.
There is no custom database schema.

Important preference groups:

* shown family parts and their display order
* user-visible filter options
* compact or enriched design
* thumbnail size and vital data
* summary counts
* empty-block handling
* label and relationship-parameter display
* relationship-path mouseover display
* Print/PDF button display
* tab-loading behavior
* event-place display format
* clippings-cart integration

`ExtendedFamilyTabModule::buildConfig()` converts these preferences into a runtime configuration object.
The calculation and views use this object instead of reading preferences directly.

## 🖥 User interface

The user-facing tab is rendered by `resources/views/tab.phtml`.
The control-panel settings page is rendered by `resources/views/settings.phtml`.

The tab begins with a single responsive toolbar.
If enabled, this toolbar contains the filter controls and the current filter's action buttons in one line where space allows.
The action buttons are built for every filter variant and shown or hidden together with the matching filter block.
The print view uses `resources/views/print.phtml` and shares the same family-part and summary partials where possible.

### Tab view rendering map

`resources/views/tab.phtml` renders each configured family part in two stages:
first the summary text for the family part, then the grouped member list.
The family-part summary text is delegated to `resources/views/partials/family-part-summary.phtml`.
The member-list stage is delegated to `resources/views/partials/family-part-members.phtml`, which selects a renderer partial.

The table below was checked against `ExtendedFamilySupport::getFamilyPartParameters()`
and the `family-part-members.phtml` renderer dispatch.
Normal member renderers and their heading partials iterate over group `entries`.

| Rendering pattern | Renderer partial | Family parts | Grouping / heading basis |
| --- | --- | --- | --- |
| Dedicated partners branch | `partials/family-part-renderers/partners.phtml` | `partners` | Groups by partner / partner-of-partner reference person; heading is "Partner of ..." |
| Dedicated partner-chains branch | `partials/family-part-renderers/partner-chains.phtml` | `partner_chains` | Renders partner chains as chain segments; this part does not use named groups. |
| Dedicated linked-person branch | `partials/family-part-renderers/godparents-witnesses.phtml` | `godparents_witnesses` | Renders associated people and name-only entries with role, event, and reference person or family. |
| Dedicated parents-in-law branch | `partials/family-part-renderers/parents-in-law.phtml` | `parents_in_law` | Groups by the proband's partner partnership, then by the partner's parent family. |
| Shared reference-person branch | `partials/family-part-renderers/grouped.phtml` + `grouped-headings/reference-person.phtml` | `siblings_in_law`, `uncles_and_aunts_bm` | Groups by reference person; headings distinguish sibling, partner, and partnership context. |
| Dedicated nephews-and-nieces reference branch | `partials/family-part-renderers/grouped.phtml` + `grouped-headings/nephews-and-nieces.phtml` | `nephews_and_nieces` | Groups by sibling or sibling-in-law reference person; for partners' siblings it also uses a second reference person. |
| Dedicated children-in-law reference branch | `partials/family-part-renderers/grouped.phtml` + `grouped-headings/children-in-law.phtml` | `children_in_law` | Groups by child reference person and child relationship type; member labels show the partner status. |
| Shared family / reference-family branch | `partials/family-part-renderers/grouped.phtml` + `grouped-headings/family-reference.phtml` | `great_grandparents`, `grandparents`, `grandaunts_uncles`, `uncles_and_aunts`, `parents`, `co_parents_in_law`, `grandchildren_in_law`, `great_grandchild_in_law` | Groups by stored family and, where available, reference person; headings describe parent, grandparent, stepparent, in-law, uncle/aunt, or grandaunt/granduncle context. |
| Dedicated co-siblings-in-law reference branch | `partials/family-part-renderers/grouped.phtml` + `grouped-headings/co-siblings-in-law.phtml` | `co_siblings_in_law` | Groups by sibling-in-law reference person; headings distinguish siblings of siblings-in-law from partners of siblings-in-law. |
| Shared child-family branch | `partials/family-part-renderers/grouped.phtml` + `grouped-headings/child-family.phtml` | `siblings`, `cousins`, `grandnephews_nieces`, `children`, `grandchildren`, `great_grandchildren` | Groups by each member's displayed parent family; step-grandchildren also show the connected child reference. |

Overall summary statistics are rendered by `partials/summary.phtml`.
The empty-family-part message is already isolated in `partials/empty-family-part.phtml`.

The settings page contains a sortable family-part table.
The ordering is persisted through module preferences and later used when the tab creates family parts.

Family-part boxes are rendered in a responsive grid.
The number of columns is derived from the maximum number of subgroups that need to be shown.

The settings page also controls whether users see the clippings-cart button.
When huhwt-cce is available, administrators can choose between huhwt-cce and the internal Extended Family action.
When huhwt-cce is not available, the internal action is used automatically.

The settings page also controls whether the tab can load by Ajax.
The default is later Ajax loading: the individual page can render without calculating the extended-family tab, and the tab content is calculated when the user opens the tab.
Administrators can disable Ajax loading to calculate the tab content immediately as part of the individual page request.

## 🌍 Translations

Translations are provided by gettext files in `resources/lang/*.po` and `resources/lang/*.mo` and registered through the module's custom translation support.

## 📁 File structure

The module's source code is organized into the following directories
(only important files are shown):
```text
hh_extended_family/
├── autoload.php
├── ExtendedFamilyTabModule.php
├── ExtendedFamily.php
├── ExtendedFamilyPersonExists.php
├── latest-version.txt
├── module.php
├── README.md
├── LICENSE.md
├── docs/
│   ├── architecture.md
│   └── images/
├── resources/
│   ├── css/
│   │   └── hh_extended_family.css
│   ├── data/
│   │   ├── CountryRegionCodes2Char.json
│   │   └── CountryRegionCodes3Char.json
│   ├── lang/
│   │   ├── default.pot
│   │   ├── *.po
│   │   └── *.mo
│   └── views/
│       ├── print.phtml
│       ├── settings.phtml
│       ├── tab.phtml
│       └── partials/
│           ├── clippings-cart-button.phtml
│           ├── empty-family-part.phtml
│           ├── family-part-header.phtml
│           ├── family-part-members.phtml
│           ├── family-part-summary.phtml
│           ├── filter-controls.phtml
│           ├── filter-script.phtml
│           ├── summary.phtml
│           └── family-part-renderers/
│               ├── godparents-witnesses.phtml
│               ├── grouped.phtml
│               ├── parents-in-law.phtml
│               ├── partner-chains.phtml
│               ├── partners.phtml
│               └── grouped-headings/
│                   ├── child-family.phtml
│                   ├── children-in-law.phtml
│                   ├── co-siblings-in-law.phtml
│                   ├── family-reference.phtml
│                   ├── nephews-and-nieces.phtml
│                   ├── partners.phtml
│                   └── reference-person.phtml
├── src/
│   ├── Factory/
│   │   ├── ExtendedFamilyPart.php
│   │   ├── ExtendedFamilyPartFactory.php
│   │   ├── ExtendedFamilyParts/
│   │   │   ├── Children.php
│   │   │   ├── Children_in_law.php
│   │   │   ├── Co_parents_in_law.php
│   │   │   ├── Co_siblings_in_law.php
│   │   │   ├── Cousins.php
│   │   │   ├── Godparents_witnesses.php
│   │   │   ├── Grandaunts_uncles.php
│   │   │   ├── Grandchildren.php
│   │   │   ├── Grandchildren_in_law.php
│   │   │   ├── Grandnephews_nieces.php
│   │   │   ├── Grandparents.php
│   │   │   ├── Great_grandchild_in_law.php
│   │   │   ├── Great_grandchildren.php
│   │   │   ├── Great_grandparents.php
│   │   │   ├── Nephews_and_nieces.php
│   │   │   ├── Parents.php
│   │   │   ├── Parents_in_law.php
│   │   │   ├── Partner_chains.php
│   │   │   ├── Partners.php
│   │   │   ├── Siblings.php
│   │   │   ├── Siblings_in_law.php
│   │   │   ├── Uncles_and_aunts.php
│   │   │   └── Uncles_and_aunts_bm.php
│   │   └── Objects/
│   │       ├── AssociatedPersonEntry.php
│   │       ├── DateRangeStatistics.php
│   │       ├── ExtendedFamilyConfig.php
│   │       ├── ExtendedFamilyFilterResult.php
│   │       ├── ExtendedFamilyPartSet.php
│   │       ├── ExtendedFamilyProband.php
│   │       ├── ExtendedFamilySummary.php
│   │       ├── ExtendedFamilySupport.php
│   │       ├── FamilyPart.php
│   │       ├── FamilyPartCounts.php
│   │       ├── FamilyPartGroup.php
│   │       ├── FindBranchConfig.php
│   │       ├── GroupEntry.php
│   │       ├── IndividualFamily.php
│   │       ├── LineageImplexSummary.php
│   │       ├── LineageStatistics.php
│   │       ├── LineageSummary.php
│   │       ├── LineageRow.php
│   │       ├── LivingStatistics.php
│   │       ├── NiceName.php
│   │       ├── OldestIndividuals.php
│   │       ├── PartnerChainNode.php
│   │       ├── PartnerChainPerson.php
│   │       ├── PlaceAbbreviation.php
│   │       ├── ProbandName.php
│   │       ├── RepeatedLineagePerson.php
│   │       ├── SexStatistics.php
│   │       ├── SummaryStatistics.php
│   │       └── ...
│   ├── Internationalization/
│   │   └── MoreI18N.php
│   └── Services/
│       └── ClippingsCartWriter.php
```

## 🚧 Known limitations and design notes

The factory currently depends on class-name conventions.
When new family parts are added, the preference key, class name, and translation strings must stay aligned.

Filter variants are calculated eagerly.
This is straightforward and keeps the templates simple, but it may need optimization if more filters or more expensive relationship searches are introduced.

Partner-chain handling is a unique feature of this module. It is more complex than most other family parts.
Changes in this area should be tested with simple couples, multiple partnerships, and longer partner chains.
