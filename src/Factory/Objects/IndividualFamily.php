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
     *  ->individual                    Individual
     *  ->family                        object (?)
     */
    private $_object;

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param Individual $individual
     * @param object $family
     */
    public function __construct(Individual $individual, object $family)
    {
        $this->_object = (object)[];
        if (isset($individual) && ($individual instanceof Individual)) {
            $this->_object->individual = $individual;
        }
        if (isset($family)) {
            $this->_object->family = $family;
        }
    }

    /**
     * get object
     *
     * @return object
     */
    public function getObject(): object
    {
        return $this->_object;
    }

    /**
     * get individual of this object
     *
     * @return Individual
     */
    public function getIndividual(): Individual
    {
        return $this->_object->individual;
    }

    /**
     * get family of this object
     *
     * @return object
     */
    public function getFamily(): object
    {
        return $this->_object->family;
    }

    /**
     * set object
     *
     * @param object $object
     */
    public function setObject(object $object): void
    {
        $this->_object = $object;
    }
}
