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

/* tbd
 *
 * plausibility check: indices in $const: only M, F, U
 * plausibility check: callFamilyPart has to be one of the extended family parts
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use function array_keys;

/**
 * class FindBranchConfig
 *
 * object to store the configuration parameters for finding a family branches
 */
class FindBranchConfig
{
    // ------------ definition of data structures

    /** @var object $_config
     *  ->callFamilyPart                string (e.g. 'parents')
     *  ->const                         array of array of string
     */
    private $_config;

    /** @var array $_branches           array of string e.g. ['bio','step'] or ['full', 'half']
     */
    private $_branches;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param string $callFamilyPart
     * @param array $branches
     * @param array $const
     */
    public function __construct(string $callFamilyPart, array $const)
    {
        $this->_config = (object)[];
        $this->_config->callFamilyPart = $callFamilyPart;
        $this->_config->const = $const;

        $this->_branches = $this->_findBranches($const);
    }

    /**
     * get config
     *
     * @return object
     */
    public function getConfig(): object
    {
        return $this->_config;
    }

    /**
     * get "callFamilyPart" of this object
     *
     * @return string
     */
    public function getCallFamilyPart(): string
    {
        return $this->_config->callFamilyPart;
    }

    /**
     * get list of branches of this object
     *
     * @return array
     */
    public function getBranches(): array
    {
        return $this->_branches;
    }

    /**
     * get list of constants for the branches of this object
     *
     * @return array
     */
    public function getConst(): array
    {
        return $this->_config->const;
    }

    /**
     * get list of branches based on index of const
     *
     * @param array $const
     * @return array of string
     */
    private function _findBranches(array $const): array
    {
        return array_keys($const);
    }
}
