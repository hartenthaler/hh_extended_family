<?php
/*
 * webtrees - extended family tab
 * Copyright (C) 2021 Hermann Hartenthaler. All rights reserved.
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

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\Individual;

/**
 * Class ExtendedFamilyPartFactory
 */
class ExtendedFamilyPartFactory
{
    /* create the instance of a class for a specific part of the extended family
     *
     * @param string $extendedFamilyPart
     * @param Individual $proband
     * @param string $filterOption
     */
    public static function create(string $extendedFamilyPart, Individual $proband, string $filterOption)
    {
        $class = "\\Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\$extendedFamilyPart";
        return new $class($proband, $filterOption);
    }
}