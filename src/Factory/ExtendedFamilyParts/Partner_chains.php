<?php
/*
 * webtrees - extended family parts
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
 * replace text representation of partner chains by a graphical representation (png/svg)
 * move I18N::translate to tab.phtml
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Illuminate\Support\Collection;

// string functions
use function str_replace;
use function strval;
use function rtrim;

// array functions
use function explode;
use function count;

/**
 * class Partner_chains
 *
 * data and methods for extended family part "partner_chains"
 */
class Partner_chains extends ExtendedFamilyPart
{
    /**
     * @var object $efpObject data structure for this extended family part
     *
     * common:
     *  ->groups                        array       // not used for this extended family part
     *  ->maleCount                     int
     *  ->femaleCount                   int
     *  ->otherSexCount                 int
     *  ->allCount                      int
     *  ->partName                      string
     *
     * special for this extended family part:
     *  ->collectionIndividuals         collection
     *  ->collectionFamilies            collection
     *  ->chains                        object
     *          ->node                  object (tree of partner chain nodes ->indi, ->chains, ->filterComment)
     *          ->displayChains[]       array (of chains for proband)
     *          ->chainsCount           int (number of chains for proband)
     *          ->longestChainCount     int (length of the longest chain for proband)
     *          ->mostDistantPartner    Individual (individual at the end or the longest chain for proband)
     *                                             (first one of them if there are more than one longest chains)
     */

    /**
     * list of const for this module
     */
    public const FILTER_DEAD    = 'a dead person';
    public const FILTER_LIVING  = 'a living person';
    public const FILTER_MALE    = 'not a male person';
    public const FILTER_FEMALE  = 'not a female person';
    public const FILTER_UNKNOWN = 'not a person of unknown gender';

    /**
     * add members for this specific extended family part and modify $this->efpObject
     * this is the only family part for that the proband is counted as a member
     */
    protected function addEfpMembers()
    {
        $this->efpObject->chains->node = new PartnerChainNode($this->getProband());
        $this->efpObject->collectionIndividuals = collect([$this->getProband()]);
        $this->efpObject->collectionFamilies = new Collection();

        $this->addPartnerChainsRecursive($this->efpObject->chains->node);
        $this->efpObject->collectionIndividuals = $this->efpObject->collectionIndividuals->unique(function ($item) {
            return $item->xref();
        });
        $this->efpObject->collectionFamilies = $this->efpObject->collectionFamilies->unique(function ($item) {
            return $item->xref();
        });
    }

    /**
     * add chains of partners recursive
     *
     * @param PartnerChainNode $node with $node->individual is set to an Individual
     */
    private function addPartnerChainsRecursive(PartnerChainNode $node): void
    {
        $newNodes = [];
        $i = 1;
        if ($node->getIndividual() instanceof Individual) {
            foreach ($node->getIndividual()->spouseFamilies() as $family) {
                if ($this->efpObject->collectionFamilies->search($family) === false) {
                    foreach ($family->spouses() as $spouse) {
                        if ($spouse->xref() !== $node->getIndividualXref()) {
                            if ($this->efpObject->collectionIndividuals->search($spouse) === false) {
                                $this->efpObject->collectionIndividuals->add($spouse);
                                $this->efpObject->collectionFamilies->add($family);
                                $newNode = new PartnerChainNode($spouse);
                                $this->addPartnerChainsRecursive($newNode);
                                $newNodes[$i] = $newNode;
                                $i++;
                            } else {
                                break;
                            }
                        }
                    }
                }
            }
        }
        $node->setChains($newNodes);
    }

    /**
     * filter individuals and count them per sex for this specific extended family part
     */
    protected function filterAndAddCounters($filterOption)
    {
        if ($filterOption !== 'all') {
            $filterOptions = ExtendedFamilySupport::convertfilterOptions($filterOption);
            $this->filterPartnerChainsRecursive($this->efpObject->chains->node, $filterOptions);
            $this->filterCollectionIndividuals($filterOptions);
        }
        $this->efpObject->chains->displayChains = $this->buildDisplayObjectPartnerChains();
        $this->addCountersPartnerChains();
    }

    /**
     * filter individuals in partner chains
     *
     * @param PartnerChainNode $node node in a partner chain array
     * @param array<string,string> $filterOptions [all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    private function filterPartnerChainsRecursive(PartnerChainNode $node, array $filterOptions)
    {
        if (($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all')) {
            if ($node->getIndividual() instanceof Individual) {
                $node->setFilterComment($this->filterPartnerChainsIndividual($node->getIndividual(), $filterOptions));
                foreach ($node->getChains() as $nextNode) {
                    $this->filterPartnerChainsRecursive($nextNode, $filterOptions);
                }
            }
        }
    }

    /**
     * check individual to be filtered
     *
     * @param Individual $individual
     * @param array $filterOptions
     * @return string
     */
    private function filterPartnerChainsIndividual(Individual $individual, array $filterOptions): string
    {
        $comment = '';
        if ($filterOptions['alive'] == 'only_alive' && $individual->isDead()) {
            $comment = self::FILTER_DEAD;
        } elseif ($filterOptions['alive'] == 'only_dead' && !$individual->isDead()) {
            $comment = self::FILTER_LIVING;
        } else {                                    // comment for dead/alive is more important than for sex
            if ($filterOptions['sex'] == 'only_M' && $individual->sex() !== 'M') {
                $comment = self::FILTER_MALE;
            } elseif ($filterOptions['sex'] == 'only_F' && $individual->sex() !== 'F') {
                $comment = self::FILTER_FEMALE;
            } elseif ($filterOptions['sex'] == 'only_U' && $individual->sex() !== 'U') {
                $comment = self::FILTER_UNKNOWN;
            }
        }
        return $comment;
    }

    /**
     * filter individuals in collection
     *
     * @param array $filterOptions
     */
    protected function filterCollectionIndividuals(array $filterOptions)
    {
        if (($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all')) {
            // delete all individuals in collection that fit to a filter option
            $this->efpObject->collectionIndividuals = $this->efpObject->collectionIndividuals->
                filter(function ($individual, $key) use ($filterOptions) {
                    return ($this->filterPartnerChainsIndividual($individual, $filterOptions) == '');
            });
        }
    }

    /**
     * count individuals in partner chains
     */
    private function addCountersPartnerChains()
    {
        $counter = $this->efpObject->collectionIndividuals->countBy(function ($individual) {
            return $individual->sex();
        });
        list ($this->efpObject->maleCount, $this->efpObject->femaleCount, $this->efpObject->otherSexCount, $this->efpObject->allCount) =
            [$counter['M']??0, $counter['F']??0, $counter['U']??0, ($counter['M']??0) + ($counter['F']??0) + ($counter['U']??0)];
        if ($this->efpObject->allCount > 0) {
            $this->addCountersToFamilyPartObjectPartnerChains();
        }
    }

    /**
     * count individuals for partner chains
     */
    private function addCountersToFamilyPartObjectPartnerChains()
    {
        $this->efpObject->chains->chainsCount = count($this->efpObject->chains->displayChains);
        $i = 1;
        $longestChainCount = 0;
        $longestChainNode = new PartnerChainNode($this->getProband());
        $max = 0;
        $mostDistantNode = new PartnerChainNode($this->getProband());
        foreach ($this->efpObject->chains->node->getChains() as $node) {
            $this->countLongestChainRecursive($node, $i, $longestChainCount, $longestChainNode);
            if ($longestChainCount > $max) {
                $max = $longestChainCount;
                $mostDistantNode = $longestChainNode;
            }
        }
        $this->efpObject->chains->longestChainCount = $max + 1;
        $this->efpObject->chains->mostDistantPartner = $mostDistantNode->getIndividual();
        if ($this->efpObject->chains->longestChainCount <= 2) {                // normal marriage is no partner chain
            $this->efpObject->allCount = 0;
        }
    }

    /**
     * count the longest chain in partner chains
     *
     * @param PartnerChainNode $node partner chain node
     * @param int $i recursion counter (modified by function)
     * @param int $lengthChain counter for longest chain (modified by function)
     * @param PartnerChainNode $longestChainNode node with most distant partner (modified by function)
     */
    private function countLongestChainRecursive(PartnerChainNode $node, int &$i, int &$lengthChain, PartnerChainNode &$longestChainNode)
    {
        if ($node->getIndividual() instanceof Individual) {
            if ($i > $lengthChain) {
                $lengthChain = $i;
                $longestChainNode = $node;
            }
            $i++;
            foreach ($node->getChains() as $nextNode) {
                $this->countLongestChainRecursive($nextNode, $i, $lengthChain, $longestChainNode);
            }
        }
        $i--;
    }

    /**
     * build array to display all partner chains
     *
     * @return array of array of PartnerChainPerson
     */
    private function buildDisplayObjectPartnerChains(): array
    {
        $node = $this->efpObject->chains->node;
        $chainAllString = '';
        $i = 1;
        $this->buildStringPartnerChainsRecursive($node, $chainAllString, $i);
        return $this->prepareChains($chainAllString);
    }

    /**
     * prepare chains of chains of partners
     *
     * @param string $chainAllString string containing '|' to separate chains; '∞' and '§' are used to separate individuals and their parameters
     * @return array of array of PartnerChainPerson
     */
    private function prepareChains(string $chainAllString): array
    {
        $chains = [];
        $chainStrings = explode('|', $this->cleanChainString($chainAllString));
        foreach ($chainStrings as $chainString) {
            $chain = $this->prepareOneChain($chainString);
            if (count($chain) > 0) {
                $chains[] = $chain;
            }
        }
        return $chains;
    }

    /**
     * prepare one chain of PartnerChainPerson
     *
     * example: 1§1§Max Mustermann§<URL>∞2§not a male person∞...
     *
     * @param string $chainString string containing '∞' and '§' to separate individuals and their parameters in one chain
     * @return array of PartnerChainPerson
     */
    private function prepareOneChain(string $chainString): array
    {
        $chain = [];
        $personStrings = explode('∞', $chainString);
        foreach ($personStrings as $personString) {
            $attributes = explode('§', $personString);
            if (count($attributes) == 4) {
                $chain[] = new PartnerChainPerson($attributes[0], ($attributes[1] == '1'), $attributes[2], $attributes[3]);
            } elseif (count($attributes) == 2) {
                $chain[] = new PartnerChainPerson($attributes[0], false, $attributes[1], '');
            }
        }
        return $chain;
    }

    /**
     * clean chain string by removing redundant recursion back step indicators
     *
     * @param string $chainString string containing '|' to separate chains; '∞' and '§' are used to separate individuals and their parameters
     * @return string
     */
    private function cleanChainString(string $chainString): string
    {
        $cleanString = $chainString;
        do {
            $cleanString = str_replace("||", "|", $cleanString, $count);
        } while ($count > 0);
        return rtrim($cleanString, '|§∞ ');
    }

    /**
     * build string of all partners in partner chains
     * names and urls should not contain:
     * '|' used to separate chains
     * '∞' used to separate individuals
     * '§' used to separate information fields for one individual: step, canShow, fullName, url
     *
     * example: 1§1§Max Mustermann§<URL>∞2§not a male person|...
     *
     * @param PartnerChainNode $node
     * @param string $chainString (modified in this function)
     * @param int $i recursion step (modified in this function)
     */
    private function buildStringPartnerChainsRecursive(PartnerChainNode $node, string &$chainString, int &$i)
    {
        if ($node->getIndividual() instanceof Individual) {
            $chainString .= strval($i) . '§';
            if ($node->getFilterComment() == '') {
                $chainString .= (($node->getIndividual()->canShow()) ? '1' : '0') .
                                '§' . $node->getIndividual()->fullName() .
                                '§' . $node->getIndividual()->url();
            } else {
                $chainString .= I18N::translate($node->getFilterComment());
            }
            $chainString .= '∞';
            foreach ($node->getChains() as $nextNode) {
                $i++;
                $this->buildStringPartnerChainsRecursive($nextNode, $chainString, $i);
            }
        }
        $chainString = rtrim($chainString, '∞') . '|';
    }
}
