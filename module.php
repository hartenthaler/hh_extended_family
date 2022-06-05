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
//use Fisharebest\Webtrees\FlashMessages;
use Illuminate\Support\Collection;

use function app;
use function str_contains;

// webtrees major version switch
if (defined("WT_MODULES_DIR")) {
    // this is a webtrees 2.1 module. it cannot be used with webtrees 1.x (or 2.0.x). See README.md.
    return;
}

//add our own dependencies

// note: in the current module system, this would happen anyway because all module.php's are executed
// whenever a single module is loaded (assuming these autoload.php's are called by the respective module.php's)
// so we aren't loading 'too much' here, as long as we properly filter 'disabled' modules, as in ModuleService.
// DO NOT USE $file HERE! see Module.loadModule($file) - we must not change that var!

$pattern = Webtrees::MODULES_DIR . '*/autoload.php';
$filenames = glob($pattern, GLOB_NOSORT);

Collection::make($filenames)
    ->filter(static function (string $filename): bool {
        // Special characters will break PHP variable names.
        // This also allows us to ignore modules called "foo.example" and "foo.disable"
        $module_name = basename(dirname($filename));

        foreach (['.', ' ', '[', ']'] as $character) {
            if (str_contains($module_name, $character)) {
                return false;
            }
        }

        return strlen($module_name) <= 30;
    })
    ->each(static function (string $filename): void {
        require_once $filename;
    });

/*
 * dependency check
$ok = class_exists("Cissee\WebtreesExt\AbstractModule", true);
if (!$ok) {
    FlashMessages::addMessage("Missing dependency - Make sure to install all Vesta modules!");
    return;
}
 */

return app(ExtendedFamilyTabModule::class);
