<?php

/*
 * webtrees: online genealogy application
 * Copyright (C) 2025 webtrees development team
 *                    <https://webtrees.net>
 *
 * webtrees - extended family tab (webtrees custom module):
 * Copyright (C) 2025 Hermann Hartenthaler 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Composer\Autoload\ClassLoader;

$loader = new ClassLoader();

// this webtrees custom module
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__);

// my helper functions for webtrees custom modules
$loader->addPsr4('Hartenthaler\\Webtrees\\Helpers\\', __DIR__ . "/vendor/hartenthaler/Webtrees/Helpers");

$loader->register();

return new ExtendedFamilyTabModule;
