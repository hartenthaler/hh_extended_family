<?php
/*
 * webtrees - extended family part (custom module)
 *
 * Copyright (C) 2025 Hermann Hartenthaler. All rights reserved.
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2025 webtrees development team.
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
use Fisharebest\Webtrees\Individual;

use function count;
use function explode;
use function array_diff;

/**
 * class ProbandName
 *
 * static support methods how to call the proband by name
 */
class ProbandName
{
    /**
     * Find a short, nice name for a person (in this case: name of proband)
     * 1. use Rufname or nickname ("Sepp") or first of first names if one of these is available
     * 2. otherwise, use surname if available ("Mr. xxx", "Mrs. xxx", or "xxx" if sex is not F or M)
     * 3. otherwise use "He" or "She" (or "He/she" if sex is not F and not M)
     *
     * An individual can have no name or many names (then we use only the first one).
     *
     * @param Individual $individual
     * @param bool $showShortName
     * @return string
     */
    public static function findNiceName(Individual $individual, bool $showShortName): string
    {
        if ($showShortName) {
            //if (count($individual->facts(['NAME'])) > 0) {                      // check if there is at least one name
                return ProbandName::findNiceNameFromRufnameOrNameParts($individual);
            //} else {
            //    $niceName = ProbandName::selectNameSex($individual,
             //       I18N::translate('He'),
            //        I18N::translate('She'),
             //       I18N::translate('He/she'));
            //}
        } else {
            return $individual->fullname();
        }
        //return $niceName;
    }

    /**
     * Find a short, nice name for a person based on Rufname or name facts in the first NAME record
     *
     * @param Individual $individual
     * @return string
     */
    private static function findNiceNameFromRufnameOrNameParts(Individual $individual): string
    {
        $rufname = ProbandName::findRufname($individual);
        if ($rufname !== '') {
            return $rufname;
        } else {
            return ProbandName::findNiceNameFromNameParts($individual);
        }
    }

    /**
     * find rufname of an individual (tag _RUFNAME or marked with '*' or both)
     * prefer _RUFNAME more than '*'
     *
     * @param Individual $individual
     * @return string (is empty if there is no Rufname)
     */
    private static function findRufname(Individual $individual): string
    {
        $rufname = '';
        $nameFacts = $individual->facts(['NAME']);
        if (count($nameFacts) > 0) {
            $rufname = $nameFacts[0]->attribute('_RUFNAME');            // check tag _RUFNAME in first NAME record
            if ($rufname == '') {                                       // there is no tag _RUFNAME, so search for '*'
                $rufnameParts = explode('*', $nameFacts[0]->value());
                if ($rufnameParts[0] !== $nameFacts[0]->value()) {
                    // there is a Rufname marked with '*', but no tag _RUFNAME
                    $rufnameParts = explode(' ', $rufnameParts[0]);  // this expands the name pieces before the '*'
                    $rufname = $rufnameParts[count($rufnameParts) - 1];         // it has to be the last given name (before *)
                }
            }
        }
        return $rufname;
    }

    /**
     * Find a short, nice name for a person based on name facts in the first NAME record
     * => use nickname ("Sepp") or first of first names if one of those is available
     *    => otherwise use surname if available
     *
     * @param Individual $individual
     * @return string
     */
    private static function findNiceNameFromNameParts(Individual $individual): string
    {
        $nameFacts = $individual->facts(['NAME']);
        if (count($nameFacts) > 0) {                // is there any NAME record?
            // search for nickname based on GEDCOM tag (sometimes a nickname is defined by a name enclosed in "")
            $nickname = $nameFacts[0]->attribute('NICK');
            if ($nickname !== '') {
                return $nickname;
            }
            // search in NAME tag (like "NAME Dr. Rainer Maria /Hartenthaler/")
            $givenAndSurnames = explode('/', $nameFacts[0]->value());
            if ($givenAndSurnames[0] !== '') {                      // are there given names (or prefix name parts) before the first '/'??
                $npfx = $nameFacts[0]->attribute('NPFX') ?? null;   // name prefix based on NPFX name piece
                $niceName = ProbandName::selectFirstGivenName($givenAndSurnames[0], $npfx);
                if ($niceName !== '') return $niceName;             // only if there are given names and not only name prefixes
            }
            if (count($givenAndSurnames) > 1) {                     // are there name pieces after the first slash?
                return ProbandName::selectSurname($individual, $givenAndSurnames[1]);
            }
        }
        return ProbandName::selectNameSex($individual,
            I18N::translate('He'),
            I18N::translate('She'),
            I18N::translate('He/she'));
    }

    /**
     * select nice name based on surname (there were no given names found)
     *
     * @param Individual $individual
     * @param string $surname
     * @return string
     */
    private static function selectSurname(Individual $individual, string $surname): string
    {
        // Check if a surname exists
        if ($surname !== '') {
            // Return the selected surname with the appropriate title
            return ProbandName::selectNameSex(
                $individual,
                I18N::translate('Mr.') . ' ' . $surname,
                I18N::translate('Mrs.') . ' ' . $surname,
                $surname
            );
        }

        return '';                      // return an empty string if no surname is provided
    }

    /**
     * select first given name (there are maybe prefix name parts still included, like 'Dr.' 'h.c.'; skip them)
     *
     * @param string $givenNames string with given names (everything before the '/' in the NAME record)
     * @param string|null $npfx name prefix based on GEDCOM tag NPFX
     * @return string
     */
    private static function selectFirstGivenName(string $givenNames, ?string $npfx): string
    {
        $niceName = '';
        $givenNameParts = explode( ' ', $givenNames);     // list of all the name parts
        if (end($givenNameParts) === '') {
            array_pop($givenNameParts);                     // delete last array element if it is empty
        }

        if (isset($npfx)) {
            $npfxParts = explode(' ', $npfx);             // list of name prefix parts based on NPFX name piece
            // remove all elements from `$givenNameParts` that are present in `$npfxParts`
            $givenNameParts = array_values(array_diff($givenNameParts, $npfxParts));
        }

        if (count($givenNameParts) > 0) {                           // are there still given names?
            $niceName = $givenNameParts[0];                         // select the first given name
        }
        return $niceName;
    }

    /**
     * set name depending on sex of individual
     *
     * @param Individual $individual
     * @param string $nMale
     * @param string $nFemale
     * @param string $nUnknown
     * @return string
     */
    private static function selectNameSex(Individual $individual, string $nMale, string $nFemale, string $nUnknown): string
    {
        if ($individual->sex() == 'M') {
            return $nMale;
        } elseif ($individual->sex() == 'F') {
            return $nFemale;
        } else {
            return $nUnknown;
        }
    }
}
