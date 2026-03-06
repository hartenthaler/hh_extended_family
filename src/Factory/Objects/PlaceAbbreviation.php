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

use function count;
use function explode;
use function strip_tags;
use function strtolower;
use function strtoupper;
use function trim;
use function file_get_contents;
use function json_decode;

/**
 * tbd: Systemadministrator muss im Control panel eine der Optionen aus abbrPlacesOptions() auswählen
 * tbd: enthalten Ortsangaben html-Elemente (siehe https://github.com/elysch/webtrees-mitalteli-chart-family-book/blob/main/src/FamilyBookChartEnhancedModule.php)
 * tbd: kann man bei vorhandenem _LOC: Ortsangaben und GOV-Hierarchie zusätzlich darstellen?
 */


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

        // Cut the place name up into pieces using the commas
        $place_chunks = explode(",", $place_long);
        $place = "";
        $chunk_count = count($place_chunks);
        // tbd check what happens if PLAC = "DEU"
        $abbreviating_country = !($chunk_count == 1 &&
               ($place_format == self::OPTION_2_LETTER_ISO || $place_format == self::OPTION_3_LETTER_ISO));

        // Add city to our return string
        if (!empty($place_chunks[0]) && $abbreviating_country) {
            $place .= trim($place_chunks[0]);

            if ($place_format == self::OPTION_CITY_ONLY) {
                return $place;
            }
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
                return $place_long;
        }

        $countries = self::loadCountryDataFile($code);

        // Chose to keep just the first and last sections
        if ($place_format == self::OPTION_CITY_AND_COUNTRY) {
            if (!empty($place_chunks[$chunk_count - 1]) && ($chunk_count > 1)) {
                if (!empty($place)) {
                    $place .= ", ";
                }
                // Add last section, but convert to full name if it's ISO
                $country = self::getIsoCountry($countries, trim($place_chunks[$chunk_count - 1]));
                // Translate city/country combo if translation available in webtrees, else just translate country
                if ($place . $country === I18N::translate($place . $country)) {
                    return $place . I18N::translate($country);
                }
                return I18N::translate($place . $country);
            }
        }

        /* Der folgende Kommentar ist unvollständig oder widersprüchlich. tbd: austesten */
        /* It's possible the place name string was blank, meaning our return variable is
               still blank. We don't want to add a comma if that's the case. */
        if (!empty($place) && !empty($place_chunks[$chunk_count - 1]) && ($chunk_count > 1)) {
            $place .= ", ";
        }

        /* Look up our country in the array of country names.
           It must be an exact match, or it won't be abbreviated to the country code. */
        if (isset($countries[strip_tags(strtolower(trim($place_chunks[$chunk_count - 1])))])) {
            $place .= $countries[strip_tags(strtolower(trim($place_chunks[$chunk_count - 1])))];
        } else {
            // We didn't find country in the abbreviation list, so just add the full country name
            if (!empty($place_chunks[$chunk_count - 1])) {
                $place .= trim($place_chunks[$chunk_count - 1]);
            }
        }
        return $place;
    }

    private static function getIsoCountry(array $countries, string $country): string {
        // Our country might have been stored as a country code, in this case we should convert
        // to the country, then convert back to the code. This allows conversion from 2 to 3 or
        // 3 to 2 character ISO codes
        $country = self::getIsoCountry($countries, $country);

        /* Look up our country in the array of country names.
           It must be an exact match, or it won't be abbreviated to the country code. */
        if (isset($countries[strtolower(trim($country))])) {
            return $countries[strtolower(trim($country))];
        }
        // We didn't find country in the abbreviation list, so just add the full country name
        if (!empty($country)) {
            return trim($country);
        }
        return '';
    }
    /**
     * Loads country data from JSON file
     * https://github.com/Neriderc/GVExport/blob/main/app/Settings.php
     * Data comes from https://github.com/stefangabos/world_countries
     * tbd: Systemfunktion für ressource-folder nutzen
     *
     * @param $type string iso2 or iso3
     * @return array|false
     */
    private static function loadCountryDataFile(string $type): array|false {
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
    public function abbrPlacesOptions(): array {
        return [
            self::OPTION_FULL_PLACE_NAME  => I18N::translate("Full place name"),
            self::OPTION_CITY_ONLY        => I18N::translate("City only"),
            self::OPTION_CITY_AND_COUNTRY => I18N::translate("City and country"),
            self::OPTION_2_LETTER_ISO     => I18N::translate("City and 2 letter ISO country code"),
            self::OPTION_3_LETTER_ISO     => I18N::translate("City and 3 letter ISO country code"),
        ];
    }
}
