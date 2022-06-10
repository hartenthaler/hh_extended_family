<?php
/*
 * webtrees - extended family part
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

use Fisharebest\Webtrees\Individual;

/**
 * class PartnerChainPerson
 *
 * object to store the information that is necessary to show a person in the partner chain
 */
class PartnerChainPerson
{
    // ------------ definition of data structures

    /**
     * @var object $person
     *  ->step              string
     *  ->canShow           bool
     *  ->fullName          string
     *  ->url               string
     */
    private object $person;

    // ------------ definition of methods

    /**
     * construct partner chain person object
     *
     * @param string $step
     * @param bool $canShow
     * @param string $fullName
     * @param string $url
     */
    public function __construct(string $step, bool $canShow, string $fullName, string $url)
    {
        $this->person = (object)[];
        $this->person->step = $step;
        $this->person->canShow = $canShow;
        $this->person->fullName = $fullName;
        $this->person->url = $url;
    }

    /**
     * @return string
     */
    public function getStep(): string
    {
        return $this->person->step;
    }

    /**
     * @return bool
     */
    public function getCanShow(): bool
    {
        return $this->person->canShow;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->person->fullName;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->person->url;
    }
}
