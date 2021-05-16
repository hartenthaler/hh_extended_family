# webtrees module hh_cousins

[![Latest Release](https://img.shields.io/github/v/release/hartenthaler/hh_cousins)][1]
[![webtrees major version](https://img.shields.io/badge/webtrees-v2.x-green)][2]
[![Downloads](https://img.shields.io/github/downloads/hartenthaler/hh_cousins/V2.0.16.4/total)]()

<a name="Description"></a>

## Description

This webtrees module creates an additional tab in the Individual view which list all the first cousins of that person (including half-cousins).

This module version is derived from vytux_cousins. There are some additional features:
* support for half-cousins added (from webtrees user [ardhtu](https://www.webtrees.net/index.php/en/forum/2-open-discussion/35751-vytux-cousins-children-of-half-sibblings-will-not-be-recognized-as-cousins#85279))
* translation to German added
* don't show empty tables for "Father's family" and "Mother's family" anymore
* new text added if there is a family but no cousins ("... has no first cousins recorded.")
* tab is greyed out if there are no cousins

It is planned to add some more features:
* count separately for each sex and for full and half cousins ("has 4 male cousins, 2 female half cousins, 1 female full cousin")
* maybe add uncles, nieces, nephews and so on
* check sporadic problem with links of individuals

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
1. Download the [latest release](https://github.com/hartenthaler/hh_cousins/releases/latest)
1. Unzip the package into your `webtrees/modules_v4` directory of your web server
1. Rename the folder to `hh_cousins`
1. Login to **webtrees** as administrator, go to <span class="pointer">Control Panel/Modules/Individual page/Tabs</span>, and find the module. It will be called "Cousins". Check if it has a tick for "Enabled".
1. Edit this entry to set the access level for each tree and to position the menu item to suit your preferences.
1. Finally click SAVE, to complete the installation.

<a name="upgrade"></a>

## Upgrade

To update simply replace the hh_cousins files with the new ones from the latest download.

<a name="Support"></a>

## Contact Support

You can report errors raising an issue in this github repository.

<span style="font-weight: bold;">Forum: </span>general webtrees support can be found at the [webtrees forum](http://www.webtrees.net/)

* * *
