<?php

/**
 * webtrees: online genealogy application
 * Copyright (C) 2025 webtrees development team
 *                    <https://webtrees.net>
 *
 * Copyright (C) 2025 Hermann Hartenthaler
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 *
 * 
 * Functions to be used in webtrees custom modules
 *
 */

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Helpers;

use Fisharebest\Webtrees\Registry;
use Fisharebest\Webtrees\Webtrees;

/**
 * Functions to be used in webtrees custom modules
 */
class Functions
{
    /**
     * Get interface from container
     *
     * @return mixed
     */
    public static function getFromContainer(string $id) {
        if (version_compare(Webtrees::VERSION, '2.2.0', '>=')) {
            return Registry::container()->get($id);
        }
        else {
            return app($id);
        }    
    }    
}
