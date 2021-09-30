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
 * class IndividualFamily
 *
 * object to store an individual and the corresponding family together
 */
class IndividualFamily
{
    // ------------ definition of data structures

    /**
     * @var object $objectIndividualFamily
     *  ->individual                    Individual
     *  ->family                        object (?)
     */
    private $objectIndividualFamily;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param Individual $individual
     * @param object|null $family
     */
    public function __construct(Individual $individual, object $family = null)
    {
        $this->objectIndividualFamily = (object)[];
        if (isset($individual) && ($individual instanceof Individual)) {
            $this->objectIndividualFamily->individual = $individual;
        }
        if (isset($family)) {
            $this->objectIndividualFamily->family = $family;
        }
    }

    /**
     * get objectIndividualFamily
     *
     * @return object
     */
    public function getObjectIndividualFamily(): object
    {
        return $this->objectIndividualFamily;
    }

    /**
     * get individual of this object
     *
     * @return Individual
     */
    public function getIndividual(): Individual
    {
        return $this->objectIndividualFamily->individual;
    }

    /**
     * get family of this object
     *
     * @return object|void
     */
    public function getFamily()
    {
       if (isset($this->objectIndividualFamily->family)) {
           return $this->objectIndividualFamily->family;
       }
       return null;
    }

    /**
     * set object
     *
     * @param object $object
     */
    public function setObjectIndividualFamily(object $object): void
    {
        $this->objectIndividualFamily = $object;
    }
}
