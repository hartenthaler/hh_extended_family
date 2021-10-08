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
 * how should an exception be thrown?
 * plausibility check: check if indices in $const are M, F, or U
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use function array_keys;
use function in_array;

/**
 * class FindBranchConfig
 *
 * object to store the configuration parameters for finding a family branches
 */
class FindBranchConfig
{
    // ------------ definition of data structures

    /** @var object $config
     *  ->callFamilyPart                string (e.g. 'parents')
     *  ->const                         array of array of string
     */
    private $config;

    /** @var array $branches            array of string e.g. ['bio','step'] or ['full', 'half']
     */
    private $branches;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param string $callFamilyPart
     * @param array $const
     */
    public function __construct(string $callFamilyPart, array $const)
    {
        $this->config = (object)[];
        if (in_array($callFamilyPart, ExtendedFamilySupport::listFamilyParts())) {
            $this->config->callFamilyPart = $callFamilyPart;
        } else {
            throw new Exception('extended family part ' . $callFamilyPart . ' does not exist');   // tbd class "Exception" does not exist
        }
        $this->config->const = $const;

        $this->branches = $this->findBranches($const);
    }

    /**
     * get config
     *
     * @return object
     */
    public function getConfig(): object
    {
        return $this->config;
    }

    /**
     * get "callFamilyPart" of this object
     *
     * @return string
     */
    public function getCallFamilyPart(): string
    {
        return $this->config->callFamilyPart;
    }

    /**
     * get list of branches of this object
     *
     * @return array
     */
    public function getBranches(): array
    {
        return $this->branches;
    }

    /**
     * get list of constants for the branches of this object
     *
     * @return array
     */
    public function getConst(): array
    {
        return $this->config->const;
    }

    /**
     * get list of branches based on index of const
     *
     * @param array $const
     * @return array of string
     */
    private function findBranches(array $const): array
    {
        return array_keys($const);
    }
}
