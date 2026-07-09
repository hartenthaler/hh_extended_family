# Change Log

This file records user-visible changes for the **Extended family** module.
The section **After the latest release / Nach dem letzten Release** is a working log for changes that are already merged but not yet released.
It should be reviewed and converted into meaningful GitHub release notes before publishing a new release.

## After the latest release / Nach dem letzten Release

- Updated Dutch translations; thanks to TheDutchJewel.
- Updated Slovak translations; thanks to Ladislav Rosival.
- Let administrators define which family parts users may choose and which of them are rendered by default.
- Let users choose the family parts for an individual directly in the Extended family tab without changing module defaults.

## 2.2.6.11 - 2026-07-08

- Moved family-part summary decision logic from the template into a presenter.
- Render partner chains as compact HTML/CSS node chains instead of plain text.
- Updated Czech translations; thanks to Josef Prause.
- Disabled unsafe translated strings with mismatched placeholders to avoid runtime errors.
- Detect family-role loops in the displayed extended family and show them as compact node chains in the summary.
- Ignore non-positive generation lengths when calculating average generation length for the summary.
- Show branched partner chains when the proband has multiple direct partners.
- Add a strict/sequential step-parent concept as the default, with the previous relaxed/symmetrical interpretation still available as an option.
- In strict step-parent mode, use divorce/annulment and partner death dates to identify partner families that ended before a later child was born.

## 2.2.6.10 - 2026-06-29

- Included the proband when calculating oldest direct-line people.
- Limited godparent/witness lookup to displayed extended-family people and their own partnership families.
- Fixed inconsistent capitalization in partner h5 headings.
- Updated Slovak translations; thanks to Ladislav Rosival.
- Respect hidden individual names when rendering partner lists and partner chains.

## Previous releases

For earlier versions, see the GitHub releases:

<https://github.com/hartenthaler/hh_extended_family/releases>
