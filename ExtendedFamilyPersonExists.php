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

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

//use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
/*
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\GedcomCode\GedcomCodePedi;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Grandparents;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Uncles_and_aunts;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Parents;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Siblings;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Cousins;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Nephews_and_nieces;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Children;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Grandchildren;
*/

require_once(__DIR__ . '/src/Factory/ExtendedFamilyPartFactory.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyPart.php');

require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandparents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Uncles_and_aunts_bm.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_parents_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Co_siblings_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partners.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Partner_chains.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Cousins.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Nephews_and_nieces.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Children_in_law.php');
require_once(__DIR__ . '/src/Factory/ExtendedFamilyParts/Grandchildren.php');

/**
 * class ExtendedFamilyPersonExists
 * to check in efficient way if there exists at least one person in one of the selected extended family parts of the proband
 * used in the function to decide if the tab has to be grayed out
 */
class ExtendedFamilyPersonExists extends ExtendedFamily
{
    public bool $found;

    /**
     * constructor for this class
     *
     * @param Individual $proband the proband for whom the extended family members are searched
     * @param object $config configuration parameters for this extended family
     */
    public function __construct(Individual $proband, object $config)
    {
        $this->constructConfig($config);
        $this->constructProband($proband); 
        $this->found = $this->constructCheck();
    }

    /**
     * construct object containing configuration information based on module parameters
     *
     * @param object $config configuration parameters
     */
    private function constructConfig(object $config)
    {
        $this->config = $config;
    }
    
    /**
     * construct object containing information related to the proband
     *
     * @param Individual $proband
     */
    private function constructProband(Individual $proband)
    {
        $this->proband = (object)[];
        $this->proband->indi = $proband;
    }

    /**
     * build extended family parts, but stop as soon a person is found in one of the extended family parts
     * tbd: start with parents, children, siblings, ... this is maybe a bit more efficient
     *
     * @return bool
     */
    private function constructCheck(): bool
    {
        $found = false;
        foreach ($this->config->shownFamilyParts as $efp => $element) {
            if ($element->enabled) {
                //$efpObj = ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, 'all');
                if (ExtendedFamilyPartFactory::create(ucfirst($efp), $this->proband->indi, 'all')->getEfpObject()->allCount > 0) {
                    $found = true;
                    break;
                }
            }
        }
        return $found;      // tbd release/unset all objects
    }

    public function found(): bool
    {
        return $this->found;
    }
}
