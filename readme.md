# webtrees module hh_extended_family

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)

![webtrees Major Version](https://img.shields.io/badge/webtrees-v2.x-green)
![Latest Release](https://img.shields.io/github/v/release/hartenthaler/hh_extended_family)

<a name="Description"></a>

## Description

This [webtrees](https://www.webtrees.net) module creates an additional tab in the Individual view which lists the members of the core and the extended family of that person: grandparents, parents, uncles, aunts, siblings, spouses, cousins, nephews, nieces, children and grandchildren.

This module version is derived from vytux_cousins. There are additional features
* admin can decide in control panel which extended family parts should be shown
* addition for half-cousins from webtrees user [ardhtu](https://www.webtrees.net/index.php/en/forum/2-open-discussion/35751-vytux-cousins-children-of-half-sibblings-will-not-be-recognized-as-cousins#85279).
* don't show empty tables for "Father's family" and "Mother's family"
* beside father's and mother's family, now there can be a third category "father's and mother's family" if members of the extended family are related to both sides
* count separately for each sex (this supports translation if there are for example different words for male and female cousins)
* new text added if there is a family but no members in a part of the extended family (e.g. "... has no first cousins recorded.")
* tab is greyed out if the extended family is empty

<a name="Contents"></a>

## Contents

The readme contains the following main sections:

*   [Description](#Description)
*   [Contents](#Contents)
*   [Screenshots](#Screenshots)
*   [Requirements](#Requirements)
*   [Installation](#Installation)
*   [Upgrade](#upgrade)
*   [Translation](#translation)
*   [Contact Support](#Support)

<a name="Screenshots"></a>

## Screenshots

Screenshot of module
<p align="center"><img src="screenshot.png" alt="Screenshot" align="center" width="80%"></p>

Screenshot of control panel menu
<p align="center"><img src="screenshot_control_panel.png" alt="Screenshot control panel" align="center" width="40%"></p>

<a name="Requirements"></a>

## Requirements

This module requires **webtrees** version 2.0 or later.
This module has the same requirements as [webtrees#system-requirements](https://github.com/fisharebest/webtrees#system-requirements).

This module was tested with **webtrees** 2.0.16 version.

<a name="Installation"></a>

## Installation

This section documents installation instructions for hh_cousins.

1. Make database backup
1. Download the [latest release](https://github.com/hartenthaler/hh_extended_family/releases/latest)
1. Unzip the package into your `webtrees/modules_v4` directory of your web server
1. Rename the folder to `hh_extended_family`
1. Login to **webtrees** as administrator, go to <span class="pointer">Control Panel/Modules/Individual page/Tabs</span>, and find the module. It will be called "Extended family". Check if it has a tick for "Enabled".
1. Edit this entry to set the access level for each tree and to position the menu item to suit your preferences.
1. Finally click SAVE, to complete the installation.

<a name="upgrade"></a>

## Upgrade

To update simply replace the hh_extended_family files with the new ones from the latest download.

<a name="translation"></a>

## Translation

If you like to translate the text fragments in this module, contact me, please!

There are now, beside English and German translations to
* dutch by @TheDutchJewel
* czech by @jpretired


<a name="Support"></a>

## Contact Support

You can report errors raising an issue in this github repository.

<span style="font-weight: bold;">Forum: </span>general webtrees support can be found at the [webtrees forum](http://www.webtrees.net/)

* * *
