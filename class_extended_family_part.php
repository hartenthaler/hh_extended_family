<?php
/*
 * webtrees - extended family part
 *
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

/*
 * tbd: offene Punkte
 * ------------------
 *
 * alle inhaltlichen Funktionen, die sich im Kern um die erweiterte Familienteile drehen, hierher verschieben
 * neue Klassen für die einzelnen Zweige der erweiterten Familie mit den jeweiligen Hilfsfunktionen definieren
 */

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

    /**
	 * Definition of object structure 
	 *	 
     *  ->config->showEmptyBlock                                            int [0,1,2]
     *          ->showLabels                                                bool
     *          ->useCompactDesign                                          bool
     *          ->showThumbnail                                             bool
     *          ->filterOptions                                             array of string
     *  ->proband->indi                                                     object individual
     *           ->niceName                                                 string
     *           ->label                                                    string
     *  ->filter[]                                                          array of object (index is string filteroption)
     *            ->efp->allCount                                           int
     *                 ->summaryMessageEmptyBlocks                          string
	 *                 ->grandparents                                       see parents-in-law
     *                 ->uncles_and_aunts                                   see children
     *                 ->uncles_and_aunts_bm                                see children
     *                 ->parents                                            see parents_in_law
     *                 ->parents_in_law->groups[]->members[]                array of object individual   (index of groups is int)
     *                                           ->family                   object family
     *                                           ->familyStatus             string
     *                                           ->partner                  Individual
     *                                           ->partnerFamilyStatus      string
     *                                 ->maleCount                          int    
     *                                 ->femaleCount                        int
     *                                 ->allCount                           int
     *                                 ->partName                           string
     *        					       ->partName_translated	            string
     *        					       ->type					            string
     *                 ->co_parents_in_law                                  see children
     *                 ->partners->groups[]->members[]                      array of object individual   (index of groups is XREF)
     *                                     ->partner                        object individual
     *                           ->pCount                                   int
     *                           ->pmaleCount                               int
     *                           ->pfemaleCount                             int
     *                           ->popCount                                 int
     *                           ->popmaleCount                             int
     *                           ->popfemaleCount                           int
     *                           ->maleCount                                int    
     *                           ->femaleCount                              int
     *                           ->allCount                                 int
     *                           ->partName                                 string
     *        				     ->partName_translated			            string
     *        				     ->type							            string
     *                 ->partner_chains->chains[]                           array of object (tree of marriage chain nodes)
     *                                 ->displayChains[]                    array of chain (array of chainPerson objects)
     *                                 ->chainsCount                        int (number of chains)
     *                                 ->longestChainCount                  int
     *                                 ->mostDistantPartner                 Individual (first one if there are more than one)
     *                                 ->maleCount                          int    
     *                                 ->femaleCount                        int
     *                                 ->allCount                           int
     *                                 ->partName                           string
     *        				           ->partName_translated	            string
     *        				           ->type					            string
     *                 ->siblings                                           see children 
     *                 ->siblings_in_law                                    see children
     *                 ->co_siblings_in_law                                 see children
     *                 ->cousins                                            see children
     *                 ->nephews_and_nieces                                 see children
     *                 ->children->groups[]->members[]                      array of object individual   (index of groups is groupName)
     *                                     ->labels[]                       array of array of string
     *                                     ->families[]                     array of object
     *                                     ->familiesStatus[]               string
     *                                     ->referencePersons[]             Individual
     *                                     ->referencePersons2[]            Individual
     *                                     ->groupName                      string
     *                           ->maleCount                                int    
     *                           ->femaleCount                              int
     *                           ->allCount                                 int
     *                           ->partName                                 string
     *        				     ->partName_translated			            string
     *        				     ->type							            string
     *                 ->children_in_law                                    see children
     *                 ->grandchildren                                      see children
     */

/**
 * Class ExtendedFamily
 */
class ExtendedFamily
{
    private $config  = (object)[];
    private $proband = (object)[];
    private $filter  = [];
}

?>
