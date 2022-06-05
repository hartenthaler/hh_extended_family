<?php
/*
 * webtrees - extended family part
 *
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

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;

use function count;
use function explode;

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
            if (count($individual->facts(['NAME'])) > 0) {                      // check if there is at least one name
                $niceName = ProbandName::findNiceNameFromRufnameOrNameParts($individual);
            } else {                                          // tbd move following translations to tab.pthml
                $niceName = ProbandName::selectNameSex($individual, I18N::translate('He'),
                    I18N::translate('She'),
                    I18N::translate('He/she'));
            }
        } else {
            $niceName = $individual->fullname();
        }
        return $niceName;
    }

    /**
     * find rufname of an individual (tag _RUFNAME or marked with '*'
     *
     * @param Individual $individual
     * @return string (is empty if there is no Rufname)
     */
    private static function findRufname(Individual $individual): string
    {
        $rufname = $individual->facts(['NAME'])[0]->attribute('_RUFNAME');
        if ($rufname == '') {
            $rufnameParts = explode('*', $individual->facts(['NAME'])[0]->value());
            if ($rufnameParts[0] !== $individual->facts(['NAME'])[0]->value()) {
                // there is a Rufname marked with *, but no tag _RUFNAME
                $rufnameParts = explode(' ', $rufnameParts[0]);
                $rufname = $rufnameParts[count($rufnameParts)-1];         // it has to be the last given name (before *)
            }
        }
        return $rufname;
    }

    /**
     * Find a short, nice name for a person based on Rufname or name facts
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
     * Find a short, nice name for a person based on name facts
     * => use Rufname or nickname ("Sepp") or first of first names if one of these is available
     *    => otherwise use surname if available
     *
     * @param Individual $individual
     * @return string
     */
    private static function findNiceNameFromNameParts(Individual $individual): string
    {
        $nameFacts = $individual->facts(['NAME']);
        $nickname = $nameFacts[0]->attribute('NICK');
        if ($nickname !== '') {
            $niceName = $nickname;
        } else {
            $givenAndSurnames = explode('/', $nameFacts[0]->value());
            if ($givenAndSurnames[0] !== '') {                         // are there given names (or prefix name parts)?
                $niceName = ProbandName::selectFirstGivenName($givenAndSurnames, $nameFacts[0]->attribute('NPFX'));
            } else {
                $surname = $givenAndSurnames[1];
                if ($surname !== '') {
                    $niceName = ProbandName::selectNameSex($individual, I18N::translate('Mr.') . ' ' . $surname, I18N::translate('Mrs.') . ' ' . $surname, $surname);
                } else {
                    $niceName = ProbandName::selectNameSex($individual, I18N::translate('He'), I18N::translate('She'), I18N::translate('He/she'));
                }
            }
        }
        return $niceName;
    }

    /**
     * select first given name
     *
     * @param array<int, string> $givenAndSurnames
     * @param string $npfx
     * @return string
     */
    private static function selectFirstGivenName(array $givenAndSurnames, string $npfx): string
    {
        $niceName = '';
        $givenNameParts = explode( ' ', $givenAndSurnames[0]);
        if ($npfx == '') {
            $niceName = $givenNameParts[0];                                     // the first given name
        } elseif (count(explode(' ', $npfx)) !== count($givenNameParts)) {
            $niceName = $givenNameParts[count(explode(' ', $npfx))];   // the first name after the prefix name parts
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
