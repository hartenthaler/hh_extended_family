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
use Fisharebest\Webtrees\Family;


/**
 * class IndividualFamily
 *
 * object to store an individual and the corresponding family together
 */
class IndividualFamily
{
    // ------------ definition of data structures

    private Individual $individual;
    private ?Family $family = null;

    /** @var array<int,Individual> $referencePersons */
    private array $referencePersons = [];

    // ------------ definition of methods

    /**
     * construct object
     *
     * @param Individual $individual
     * @param Family|null $family
     * @param Individual|null $referencePerson
     * @param Individual|null $referencePerson2
     */
    public function __construct(Individual $individual,
                                ?Family $family = null,
                                ?Individual $referencePerson = null,
                                ?Individual $referencePerson2 = null)
    {
        $this->individual = $individual;
        $this->family = $family;
        foreach ([1 => $referencePerson, 2 => $referencePerson2] as $refIndex => $refPerson) {
            if (isset($refPerson) && ($refPerson instanceof Individual)) {
                $this->referencePersons[$refIndex] = $refPerson;
            }
        }
    }

    /**
     * get individual of this object
     *
     * @return Individual
     */
    public function getIndividual(): Individual
    {
        return $this->individual;
    }

    /**
     * get family of this object
     *
     * @return Family|null
     */
    public function getFamily(): ?Family
    {
       return $this->family;
    }

    /**
     * get reference persons in this object
     *
     * @return array<int,Individual>
     */
    public function getReferencePersons(): array
    {
        return $this->referencePersons;
    }

    /**
     * set reference person of this object
     *
     * @param int $index
     * @param Individual $referencePerson
     */
    public function setReferencePerson(int $index, Individual $referencePerson)
    {
        $this->referencePersons[$index] = $referencePerson;
    }

}
