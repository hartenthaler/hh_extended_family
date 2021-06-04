# webtrees module hh_extended_family

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)

![webtrees Major Version](https://img.shields.io/badge/webtrees-v2.x-green)
![Latest Release](https://img.shields.io/github/v/release/hartenthaler/hh_extended_family)
[![Downloads](https://img.shields.io/github/downloads/hartenthaler/hh_extended_family/2.0.16.7/total)]()

<a name="Description"></a>

## Description

This [webtrees](https://www.webtrees.net) module creates an additional tab in the Individual view which lists the members of the extended family of that person (cousins, uncles, aunts, ...).

This module version is derived from vytux_cousins. There are some additional features:
* including uncles and aunts
* addition for half-cousins from webtrees user [ardhtu](https://www.webtrees.net/index.php/en/forum/2-open-discussion/35751-vytux-cousins-children-of-half-sibblings-will-not-be-recognized-as-cousins#85279).
* don't show empty tables for "Father's family" and "Mother's family"
* count separately for each sex (this supports translation if there are for example different words for male and female cousins)
* new text added if there is a family but no cousins or no aunts/uncles ("... has no first cousins / aunts or uncles recorded.")
* tab is greyed out if the extended family is empty

There are some open issues:
* check sporadic problems with links of individuals
* use singular and plural if there are male and female cousins / aunts and uncles
* handling of cousins / aunts or uncles, when there are cousins / aunts or uncles in fathers and mothers family
* update translations to other languages than English and German

It is planned to add some more features:
* let the user select if he likes to see only living members of extended family
* use a nice short name for the Proband instead of full name
* count separately for full and half cousins ("has 4 male cousins, 2 female half cousins, 1 female full cousin")
* add grandparents, grandchilds, nieces, nephews

<a name="Contents"></a>

## Contents

The readme contains the following main sections:

*   [Description](#Description)
*   [Contents](#Contents)
*   [Requirements](#Requirements)
*   [Installation](#Installation)
*   [Upgrade](#upgrade)
*   [Contact Support](#Support)

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

<a name="Support"></a>

## Contact Support

You can report errors raising an issue in this github repository.

<span style="font-weight: bold;">Forum: </span>general webtrees support can be found at the [webtrees forum](http://www.webtrees.net/)

* * *
