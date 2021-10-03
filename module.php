<?php
/*
 * webtrees - extended family tab
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2021 webtrees development team.
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

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Webtrees;
 
use function app;

//webtrees major version switch
if (defined("WT_MODULES_DIR")) {
    // this is a webtrees 2.x module; it cannot be used with webtrees 1.x. See README.md.
    return;
}

// add our own dependencies if necessary

// note: in the current module system, this would happen anyway because all module.php's are executed
// whenever a single module is loaded (assuming these autoload.php's are called by the respective module.php's)
// so we aren't loading 'too much' here.
// DO NOT USE $file HERE! see Module.loadModule($file) - we must not change that var!

require_once(__DIR__ . '/ExtendedFamilyTabModule.php');

return app(ExtendedFamilyTabModule::class);
