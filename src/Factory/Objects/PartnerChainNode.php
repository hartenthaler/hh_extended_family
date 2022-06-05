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

    /**
     * @var object $node
     *  ->individual                    Individual
     *  ->chains                        array<int,node>
     *  ->filterComment                 string
     */
    private object $node;

    // ------------ definition of methods

    /**
     * construct partner chain node object
     *
     * @param Individual $individual
     * @param array $chains
     * @param string $filterComment
     */
    public function __construct(Individual $individual, array $chains = [], string $filterComment = '')
    {
        $this->node = (object)[];
        $this->node->individual = $individual;
        $this->node->chains = $chains;
        $this->node->filterComment = $filterComment;
    }

    /**
     * @return object
     */
    public function getNode(): object
    {
        return $this->node;
    }

    /**
     * @return Individual
     */
    public function getIndividual(): Individual
    {
        return $this->node->individual;
    }

    /**
     * @return string
     */
    public function getIndividualXref(): string
    {
        if ($this->node->individual instanceof Individual) {
            return $this->node->individual->xref();
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getIndividualSex(): string
    {
        if ($this->node->individual instanceof Individual) {
            return $this->node->individual->sex();
        } else {
            return 'U';
        }
    }

    /**
     * @return array
     */
    public function getChains(): array
    {
        return $this->node->chains;
    }

    /**
     * @param array $chains
     */
    public function setChains(array $chains): void
    {
        $this->node->chains = $chains;
    }

    /**
     * @return string
     */
    public function getFilterComment(): string
    {
        return $this->node->filterComment;
    }

    /**
     * @param string $filterComment
     */
    public function setFilterComment(string $filterComment): void
    {
        $this->node->filterComment = $filterComment;
    }
}
