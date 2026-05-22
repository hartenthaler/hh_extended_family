<?php
/*
 * webtrees - extended family part (custom module)
 * the functions in this file are based on webtrees custom module GVExport
 * see https://github.com/Neriderc/GVExport/blob/main/app/Dot.php
 *
 * Copyright (C) 2026 Hermann Hartenthaler. All rights reserved.
 * Copyright (C) 2025 Neriderc. All rights reserved.
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2026 webtrees development team.
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

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Statistics\Service\CountryService;

use function count;
use function explode;
use function strip_tags;
use function strtolower;
use function strtoupper;
use function trim;
use function file_get_contents;
use function json_decode;
use function preg_match;

/**
 * class PlaceAbbreviation
 *
 * static support methods to abbreviate place names
 */
class PlaceAbbreviation
{
    // PLAC format options
    const int OPTION_FULL_PLACE_NAME = 0;
    const int OPTION_CITY_ONLY = 5;
    const int OPTION_CITY_AND_COUNTRY = 10;
    const int OPTION_2_LETTER_ISO = 20;
    const int OPTION_3_LETTER_ISO = 30;

    // public const int DEFAULT_PLACES_FORMAT = self::OPTION_FULL_PLACE_NAME;

    /**
     * Returns an abbreviated version of the PLAC string.
     * Taken from https://github.com/Neriderc/GVExport/
     * and modified variable names, arguments, removed $settings
     *
     * @param	string $place_long Place string in long format (Town,County,State/Region,Country)
     * @return	string	The abbreviated place name
     */
    public static function getAbbreviatedPlace(string $place_long, int $place_format): string
    {
        // If chose no abbreviating, then return string untouched
        if ($place_format == self::OPTION_FULL_PLACE_NAME) {
            return $place_long;
        }

        $htmlBefore = '';
        $htmlAfter = '';
        if (preg_match('@^(<[^>]+?>)(.*)(</[^>]+?>)$@', $place_long, $matches)) {
            $htmlBefore = $matches[1];
            $place_long = $matches[2];
            $htmlAfter = $matches[3];
        }

        // Cut the place name up into pieces using the commas
        $place_chunks = explode(",", $place_long);
        $place = "";
        $chunk_count = count($place_chunks);
        $abbreviating_country = !($chunk_count == 1 &&
               ($place_format == self::OPTION_2_LETTER_ISO || $place_format == self::OPTION_3_LETTER_ISO));

        // Add city to our return string
        if (!empty($place_chunks[0]) && $abbreviating_country) {
            $place .= trim($place_chunks[0]);

            if ($place_format == self::OPTION_CITY_ONLY) {
                return $htmlBefore . $place . $htmlAfter;
            }
        }

        if ($place_format == self::OPTION_CITY_AND_COUNTRY) {
            if (!empty($place_chunks[$chunk_count - 1]) && ($chunk_count > 1)) {
                if (!empty($place)) {
                    $place .= ", ";
                }
                return $htmlBefore . $place . self::countryNameFromValue($place_chunks[$chunk_count - 1]) . $htmlAfter;
            }
            return $htmlBefore . $place . $htmlAfter;
        }

        /* Otherwise, we have chosen one of the ISO code options */
        switch ($place_format) {
            case self::OPTION_2_LETTER_ISO:
                $code = "iso2";
                break;
            case self::OPTION_3_LETTER_ISO:
                $code = "iso3";
                break;
            default:
                return $htmlBefore . $place_long . $htmlAfter;
        }

        $countries = self::loadCountryDataFile($code);
        $country = strip_tags(strtolower(trim($place_chunks[$chunk_count - 1])));

        /* It's possible the place name string was blank, meaning our return variable is
               still blank. We don't want to add a comma if that's the case. */
        if (!empty($place) && !empty($place_chunks[$chunk_count - 1]) && ($chunk_count > 1)) {
            $place .= ", ";
        }

        /* Look up our country in the array of country names.
           It must be an exact match, or it won't be abbreviated to the country code. */
        if (isset($countries[$country])) {
            $place .= $countries[$country];
        } else if (self::isIsoCountryCode($country)) {
            $place .= self::convertIsoCountryCode($country, $code);
        } else {
            // We didn't find country in the abbreviation list, so just add the full country name
            if (!empty($place_chunks[$chunk_count - 1])) {
                $place .= trim($place_chunks[$chunk_count - 1]);
            }
        }
        return $htmlBefore . $place . $htmlAfter;
    }

    /**
     * Check whether a country value looks like an ISO-2 or ISO-3 code.
     *
     * @param string $country
     * @return bool
     */
    private static function isIsoCountryCode(string $country): bool
    {
        return preg_match('/^[a-z]{2,3}$/', $country) === 1;
    }

    /**
     * Convert an existing ISO-2 or ISO-3 country code to the selected target code.
     *
     * @param string $country
     * @param string $targetCode iso2 or iso3
     * @return string
     */
    private static function convertIsoCountryCode(string $country, string $targetCode): string
    {
        $iso2Countries = self::loadCountryDataFile('iso2');
        $iso3Countries = self::loadCountryDataFile('iso3');

        foreach ($iso3Countries as $name => $iso3) {
            if ($country === strtolower($iso3) || (isset($iso2Countries[$name]) && $country === strtolower($iso2Countries[$name]))) {
                return $targetCode === 'iso2' ? $iso2Countries[$name] : $iso3;
            }
        }

        return strtoupper($country);
    }

    /**
     * Convert a country value from PLAC to a translated country name, if possible.
     *
     * @param string $countryValue
     * @return string
     */
    private static function countryNameFromValue(string $countryValue): string
    {
        $country = strip_tags(strtolower(trim($countryValue)));

        if ($country === '') {
            return '';
        }

        $iso3Countries = self::loadCountryDataFile('iso3');
        $iso3 = null;

        if (isset($iso3Countries[$country])) {
            $iso3 = strtoupper($iso3Countries[$country]);
        } else if (self::isIsoCountryCode($country)) {
            $iso3 = self::convertIsoCountryCode($country, 'iso3');
        }

        if ($iso3 !== null && class_exists(CountryService::class)) {
            try {
                $countries = (new CountryService())->getAllCountries();

                if (isset($countries[$iso3])) {
                    return $countries[$iso3];
                }
            } catch (\Throwable) {
                // Fall back to the original PLAC value if webtrees country data is unavailable.
            }
        }

        if ($iso3 !== null) {
            $countryName = self::englishCountryNameFromIso3($iso3);

            if ($countryName !== null) {
                return $countryName;
            }
        }

        return trim($countryValue);
    }

    /**
     * Get the English country name from the Carbon country list bundled with webtrees.
     *
     * @param string $iso3
     * @return string|null
     */
    private static function englishCountryNameFromIso3(string $iso3): ?string
    {
        $iso2 = self::convertIsoCountryCode(strtolower($iso3), 'iso2');

        $regionsFile = dirname(__DIR__, 5) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'nesbot' .
            DIRECTORY_SEPARATOR . 'carbon' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Carbon' .
            DIRECTORY_SEPARATOR . 'List' . DIRECTORY_SEPARATOR . 'regions.php';

        if (!is_file($regionsFile)) {
            return null;
        }

        $regions = require $regionsFile;

        return $regions[$iso2] ?? null;
    }

    /**
     * Loads country data from JSON file
     * https://github.com/Neriderc/GVExport/blob/main/app/Settings.php
     * Data comes from https://github.com/stefangabos/world_countries
     * tbd: Avoid the manual relative path to resources/data. Use a central module resource-path helper
     *      or inject the module resource folder into this helper instead.
     *
     * @param $type string iso2 or iso3
     * @return array|false
     */
    private static function loadCountryDataFile(string $type) {
        $folder = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .
                    DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;

        switch ($type) {
            case 'iso2':
                $string = file_get_contents($folder . "CountryRegionCodes2Char.json");
                break;
            case 'iso3':
                $string = file_get_contents($folder . "CountryRegionCodes3Char.json");
                break;
            default:
                return false;
        }
        $json = json_decode($string, true);
        $countries = [];
        foreach ($json as $row => $value) {
            $countries[strtolower($row)] = strtoupper($value);
        }
        return $countries;
    }

    /**
     * Returns a list of possible options for PLAC abbreviations
     *
     * @return	array string	option list
     */
    public static function abbrPlacesOptions(): array {
        return [
            self::OPTION_FULL_PLACE_NAME  => I18N::translate("Full place name"),
            self::OPTION_CITY_ONLY        => I18N::translate("City only"),
            self::OPTION_CITY_AND_COUNTRY => I18N::translate("City and country"),
            self::OPTION_2_LETTER_ISO     => I18N::translate("City and 2 letter ISO country code"),
            self::OPTION_3_LETTER_ISO     => I18N::translate("City and 3 letter ISO country code"),
        ];
    }
}
