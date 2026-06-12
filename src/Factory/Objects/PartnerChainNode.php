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
 * class PartnerChainNode
 *
 * object to store the nodes and links in a partner chain
 */
class PartnerChainNode
{
    // ------------ definition of data structures

    private Individual $individual;

    /** @var array<int,PartnerChainNode> $chains */
    private array $chains;

    private string $filterComment;

    // ------------ definition of methods

    /**
     * construct partner chain node object
     *
     * @param Individual $individual
     * @param array<int,PartnerChainNode> $chains
     * @param string $filterComment
     */
    public function __construct(Individual $individual, array $chains = [], string $filterComment = '')
    {
        $this->individual = $individual;
        $this->chains = $chains;
        $this->filterComment = $filterComment;
    }

    /**
     * @return Individual
     */
    public function getIndividual(): Individual
    {
        return $this->individual;
    }

    /**
     * @return string
     */
    public function getIndividualXref(): string
    {
        return $this->individual->xref();
    }

    /**
     * @return string
     */
    public function getIndividualSex(): string
    {
        return $this->individual->sex();
    }

    /**
     * @return array<int,PartnerChainNode>
     */
    public function getChains(): array
    {
        return $this->chains;
    }

    /**
     * @param array<int,PartnerChainNode> $chains
     */
    public function setChains(array $chains): void
    {
        $this->chains = $chains;
    }

    /**
     * @return string
     */
    public function getFilterComment(): string
    {
        return $this->filterComment;
    }

    /**
     * @param string $filterComment
     */
    public function setFilterComment(string $filterComment): void
    {
        $this->filterComment = $filterComment;
    }
}
