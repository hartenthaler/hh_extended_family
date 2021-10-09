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
 * move I18N translations in filterPartnerChainsRecursive() to tab.html
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;

// string functions
use function str_replace;
use function strval;
use function rtrim;

// array functions
use function explode;
use function count;
use function in_array;

/**
 * class Partner_chains
 *
 * data and methods for extended family part "partner_chains"
 */
class Partner_chains extends ExtendedFamilyPart
{
    /**
     * @var object $_efpObject data structure for this extended family part
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
     *  ->chains                        object
     *          ->chains[]              array of object (tree of partner chain nodes)
     *          ->indi                  Individual
     *              ->filterComment     string
     *          ->displayChains[]       array of chain (array of chainPerson objects)
     *          ->chainsCount           int (number of chains)
     *          ->longestChainCount     int
     *          ->mostDistantPartner    Individual (first one of them if there are more than one)
     */

    /**
     * add members for this specific extended family part and modify $this->efpObject
     */
    protected function addEfpMembers()
    {
        $chainRootNode = (object)[];
        $chainRootNode->chains = [];
        $chainRootNode->indi = $this->getProband();
        $chainRootNode->filterComment = '';

        $stop = (object)[];                                 // avoid endless loops
        $stop->indiList = [];
        $stop->indiList[] = $this->getProband()->xref();
        $stop->familyList = [];

        $this->efpObject->chains = $this->addPartnerChainsRecursive($chainRootNode, $stop);
    }

    /**
     * add chains of partners recursive
     *
     * @param object $node
     * @param object $stop stoplist with arrays of indi-xref and fam-xref
     * @return array
     */
    private function addPartnerChainsRecursive(object $node, object &$stop): array
    {
        $new_nodes = [];            // array of object ($node->indi; $node->chains)
        $i = 0;
        foreach ($node->indi->spouseFamilies() as $family) {
            if (!in_array($family->xref(), $stop->familyList)) {
                foreach ($family->spouses() as $spouse) {
                    if ($spouse->xref() !== $node->indi->xref()) {
                        if (!in_array($spouse->xref(), $stop->indiList)) {
                            $new_node = (object)[];
                            $new_node->chains = [];
                            $new_node->indi = $spouse;
                            $new_node->filterComment = '';
                            $stop->indiList[] = $spouse->xref();
                            $stop->familyList[] = $family->xref();
                            $new_node->chains = $this->addPartnerChainsRecursive($new_node, $stop);
                            $new_nodes[$i] = $new_node;
                            $i++;
                        } else {
                            break;
                        }
                    }
                }
            }
        }
        return $new_nodes;
    }

    /**
     * filter individuals and count them per sex for this specific extended family part
     */
    protected function filterAndAddCounters($filterOption)
    {
        if ($filterOption !== 'all') {
            $this->filterPartnerChains(ExtendedFamilySupport::convertfilterOptions($filterOption));
        }
        $this->efpObject->displayChains = $this->buildDisplayObjectPartnerChains();
        $this->addCountersPartnerChains();
    }

    /**
     * filter individuals in partner chains
     *
     * @param array of string $filterOptions (all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    private function filterPartnerChains(array $filterOptions)
    {
        if (($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all')) {
            foreach ($this->efpObject->chains as $chain) {
                $this->filterPartnerChainsRecursive($chain, $filterOptions);
            }
        }
    }

    /**
     * filter individuals in partner chains
     *
     * @param object $node in chain
     * @param array of string filterOptions [all|only_M|only_F|only_U, all|only_alive|only_dead]
     */
    private function filterPartnerChainsRecursive(object $node, array $filterOptions)
    {
        if (($filterOptions['alive'] !== 'all') || ($filterOptions['sex'] !== 'all')) {
            if ($node && $node->indi instanceof Individual) {
                if ($filterOptions['alive'] == 'only_alive' && $node->indi->isDead()) {
                    $node->filterComment = I18N::translate('a dead person');
                } elseif ($filterOptions['alive'] == 'only_dead' && !$node->indi->isDead()) {
                    $node->filterComment = I18N::translate('a living person');
                }
                if ($node->filterComment == '') {
                    if ($filterOptions['sex'] == 'only_M' && $node->indi->sex() !== 'M') {
                        $node->filterComment = I18N::translate('not a male person');
                    } elseif ($filterOptions['sex'] == 'only_F' && $node->indi->sex() !== 'F') {
                        $node->filterComment = I18N::translate('not a female person');
                    } elseif ($filterOptions['sex'] == 'only_U' && $node->indi->sex() !== 'U') {
                        $node->filterComment = I18N::translate('not a person of unknown gender');
                    }
                }
                foreach ($node->chains as $chain) {
                    $this->filterPartnerChainsRecursive($chain, $filterOptions);
                }
            }
        }
    }

    /**
     * count individuals in partner chains
     */
    private function addCountersPartnerChains()
    {
        $counter = $this->countMaleFemalePartnerChain($this->efpObject->chains);
        list ($countMale, $countFemale, $countOthers) = [$counter->male, $counter->female, $counter->unknown_others];
        list ($this->efpObject->maleCount, $this->efpObject->femaleCount, $this->efpObject->otherSexCount, $this->efpObject->allCount) = [$countMale, $countFemale, $countOthers, $countMale + $countFemale + $countOthers];
        if ($this->efpObject->allCount > 0) {
            $this->addCountersToFamilyPartObject_forPartnerChains();
        }
    }

    /**
     * count male and female individuals in partner chains
     *
     * @param array of partner chain nodes
     *
     * @return object
     */
    private function countMaleFemalePartnerChain(array $chains): object
    {
        $mfu = (object)[];
        list ($mfu->male, $mfu->female, $mfu->unknown_others) = [0, 0, 0];
        list ($countMale, $countFemale, $countOthers) = [0, 0, 0];
        foreach ($chains as $chain) {
            $this->countMaleFemalePartnerChainRecursive($chain, $mfu);
            $countMale += $mfu->male;
            $countFemale += $mfu->female;
            $countOthers += $mfu->unknown_others;
        }
        return $mfu;
    }

    /**
     * count individuals for partner chains
     */
    private function addCountersToFamilyPartObject_forPartnerChains()
    {
        $this->efpObject->chainsCount = count($this->efpObject->displayChains);
        $lc = 0;
        $i = 1;
        $lc_node = (object)[];
        $max = 0;
        $max_node = (object)[];
        foreach ($this->efpObject->chains as $chain) {
            $this->countLongestChainRecursive($chain, $i, $lc, $lc_node);
            if ($lc > $max) {
                $max = $lc;
                $max_node = $lc_node;
            }
        }
        $this->efpObject->longestChainCount = $max + 1;
        $this->efpObject->mostDistantPartner = $max_node->indi;
        if ($this->efpObject->longestChainCount <= 2) {                                             // normal marriage is no marriage chain
            $this->efpObject->allCount = 0;
        }
    }

    /**
     * count male and female individuals in marriage chains
     *
     * @param object $mfu of marriage chain nodes
     * @param object $node counter for sex of individuals (modified by function)
     */
    private function countMaleFemalePartnerChainRecursive(object $node, object &$mfu)
    {
        if ($node && $node->indi instanceof Individual) {
            if ($node->indi->sex() == 'M') {
                $mfu->male++;
            } elseif ($node->indi->sex() == 'F') {
                $mfu->female++;
            } else {
                $mfu->unknown_others++;
            }
            foreach ($node->chains as $chain) {
                $this->countMaleFemalePartnerChainRecursive($chain, $mfu);
            }
        }
    }

    /**
     * count the longest chain in marriage chains
     *
     * @param object of marriage chain nodes
     * @param int recursion counter (modified by function)
     * @param int counter for longest chain (modified by function)
     * @param object most distant partner (modified by function)
     */
    private function countLongestChainRecursive(object $node, int &$i, int &$lengthChain, object &$lcNode)
    {
        if ($node && $node->indi instanceof Individual) {
            if ($i > $lengthChain) {
                $lengthChain = $i;
                $lcNode = $node;
            }
            $i++;
            foreach ($node->chains as $chain) {
                $this->countLongestChainRecursive($chain, $i, $lengthChain, $lcNode);
            }
        }
        $i--;
    }

    /**
     * build object to display all partner chains
     *
     * @return array
     */
    private function buildDisplayObjectPartnerChains(): array
    {
        $chains = [];                                                           // array of chain (chain is an array of chainPerson)

        $chainString = '0§1§' . $this->getProband()->fullName() . '§' . $this->getProband()->url() . '∞';
        foreach ($this->efpObject->chains as $chain) {
            $i = 1;
            $this->buildStringPartnerChainsRecursive($chain, $chainString, $i);
        }
        do {                                                                    // remove redundant recursion back step indicators
            $chainString = str_replace("||", "|", $chainString, $count);
        } while ($count > 0);
        $chainString = rtrim($chainString, '|§∞ ');
        $chainStrings = explode('|', $chainString);
        foreach ($chainStrings as $chainString) {
            $personStrings = explode('∞', $chainString);
            $chain = [];                                                        // array of chainPerson
            foreach ($personStrings as $personString) {
                $attributes = explode('§', $personString);
                if (count($attributes) == 4) {
                    $chainPerson = (object)[];                                  // object (attributes: step, canShow, fullName, url)
                    $chainPerson->step = $attributes[0];
                    $chainPerson->canShow = ($attributes[1] == '1') ? true : false;
                    $chainPerson->fullName = $attributes[2];
                    $chainPerson->url = $attributes[3];
                    $chain[] = $chainPerson;
                }
            }
            if (count($chain) > 0) {
                $chains[] = $chain;
            }
        }
        return $chains;
    }

    /**
     * build string of all partners in partner chains
     * names and urls should not contain
     * '|' used to separate chains
     * '∞' used to separate individuals
     * '§' used to separate information fields for one individual: step, canShow, fullName, url
     *
     * @param object $node
     * @param string $chainString (modified in this function)
     * @param int $i recursion step (modified in this function)
     */
    private function buildStringPartnerChainsRecursive(object $node, string &$chainString, int &$i)
    {
        if ($node && $node->indi instanceof Individual) {
            $chainString .= strval($i) . '§';
            if ($node->filterComment == '') {
                $chainString .= (($node->indi->canShow()) ? '1' : '0') . '§' . $node->indi->fullname() . '§' . $node->indi->url() . '∞';
            } else {
                $chainString .= '0§' . $node->filterComment . '§∞';
            }
            foreach ($node->chains as $chain) {
                $i++;
                $this->buildStringPartnerChainsRecursive($chain, $chainString, $i);
            }
        }
        $i--;
        $chainString = rtrim($chainString, '∞') . '|';
    }
}

