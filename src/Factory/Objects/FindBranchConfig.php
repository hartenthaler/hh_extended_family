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

use Exception;

use function array_keys;
use function in_array;

/**
 * class FindBranchConfig
 *
 * object to store the configuration parameters for finding a family branches
 */
class FindBranchConfig
{
    private const SEX_KEYS = ['M', 'F', 'U', 'X'];

    // ------------ definition of data structures

    private string $callFamilyPart;

    /** @var array<string,array<string,string>> $const */
    private array $const;

    /** @var array<int,string> $branches e.g. ['bio','step'] or ['full', 'half']
     */
    private array $branches;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param string $callFamilyPart
     * @param array<string,array<string,string>> $const
     */
    public function __construct(string $callFamilyPart, array $const)
    {
        if (in_array($callFamilyPart, ExtendedFamilySupport::listFamilyParts())) {
            $this->callFamilyPart = $callFamilyPart;
        } else {
            throw new Exception('extended family part ' . $callFamilyPart . ' does not exist');
        }
        $this->const = $this->normalizeAndValidateConst($const);

        $this->branches = $this->findBranches($this->const);
    }

    /**
     * get "callFamilyPart" of this object
     *
     * @return string
     */
    public function getCallFamilyPart(): string
    {
        return $this->callFamilyPart;
    }

    /**
     * get list of branches of this object
     *
     * @return array<int,string>
     */
    public function getBranches(): array
    {
        return $this->branches;
    }

    /**
     * get list of constants for the branches of this object
     *
     * @return array<string,array<string,string>>
     */
    public function getConst(): array
    {
        return $this->const;
    }

    public function familyPartForSex(string $branch, string $sex): string
    {
        if (!isset($this->const[$branch])) {
            throw new Exception('extended family branch ' . $branch . ' does not exist');
        }

        if (isset($this->const[$branch][$sex])) {
            return $this->const[$branch][$sex];
        }

        if (isset($this->const[$branch]['U'])) {
            return $this->const[$branch]['U'];
        }

        throw new Exception('sex key ' . $sex . ' is not configured for branch ' . $branch);
    }

    /**
     * get list of branches based on index of const
     *
     * @param array<string,array<string,string>> $const
     * @return array<int,string>
     */
    private function findBranches(array $const): array
    {
        return array_keys($const);
    }

    /**
     * @param array<string,array<string,string>> $const
     * @return array<string,array<string,string>>
     */
    private function normalizeAndValidateConst(array $const): array
    {
        foreach ($const as $branch => $sexMap) {
            foreach (array_keys($sexMap) as $sex) {
                if (!in_array($sex, self::SEX_KEYS, true)) {
                    throw new Exception('invalid sex key ' . $sex . ' in branch ' . $branch);
                }
            }

            if (isset($sexMap['U']) && !isset($sexMap['X'])) {
                $const[$branch]['X'] = $sexMap['U'];
            }

            foreach (self::SEX_KEYS as $sex) {
                if (!isset($const[$branch][$sex])) {
                    throw new Exception('missing sex key ' . $sex . ' in branch ' . $branch);
                }
            }
        }

        return $const;
    }
}
