<?php
/*
 * webtrees - extended family tab based on vytux_cousins and simpl_cousins
 *
 * Copyright (C) 2021 Hermann Hartenthaler 
 *
 * Copyright (C) 2013 Vytautas Krivickas and vytux.com. All rights reserved. 
 *
 * Copyright (C) 2013 Nigel Osborne and kiwtrees.net. All rights reserved.
 *
 * webtrees: Web based Family History software
 * Copyright (C) 2021 webtrees development team.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

declare(strict_types=1);

namespace Hartenthaler\WebtreesModules\hh_extended_family;

use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Gedcom;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Family;
use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\GedcomCode\GedcomCodePedi;
use Fisharebest\Webtrees\Contracts\UserInterface;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleTabInterface;
use Fisharebest\Webtrees\Module\ModuleTabTrait;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\View;
use Fisharebest\Localization\Translation;
use Psr\Http\Message\ResponseInterface;

/**
 * cousins module
 */
class ExtendedFamilyTabModule extends AbstractModule implements ModuleTabInterface, ModuleCustomInterface {
    use ModuleCustomTrait;
    use ModuleTabTrait;

    public const CUSTOM_TITLE = 'Extended family';
    
    public const CUSTOM_MODULE = 'hh_extended_family';
    
    public const CUSTOM_DESCRIPTION = 'A tab showing the extended family of an individual.';

    public const CUSTOM_AUTHOR = 'Hermann Hartenthaler';
    
    public const CUSTOM_WEBSITE = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE . '/';
    
    public const CUSTOM_VERSION = '2.0.16.10';

    public const CUSTOM_LAST = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE. '/raw/main/latest-version.txt';


    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return /* I18N: Name of a module/tab on the individual page. */ I18N::translate(self::CUSTOM_TITLE);
    }

    /**
     * A sentence describing what this module does. Used in the list of all installed modules.
     *
     * @return string
     */
    public function description(): string
    {
        return /* I18N: Description of this module */ I18N::translate(self::CUSTOM_DESCRIPTION);
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return self::CUSTOM_AUTHOR;
    }

    /**
     * The version of this module.
     *
     * @return string
     */
    public function customModuleVersion(): string
    {
        return self::CUSTOM_VERSION;
    }

    /**
     * A URL that will provide the latest version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return self::CUSTOM_LAST;
    }

    /**
     * Where to get support for this module.  Perhaps a github respository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_WEBSITE;
    }
    
    /**
     * Where does this module store its resources
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }
    
    /**
     * The default position for this tab.  It can be changed in the control panel.
     *
     * @return int
     */
    public function defaultTabOrder(): int
    {
        return 10;
    }

    /**
     * Is this tab empty? If so, we don't always need to display it.
     *
     * @param Individual $individual
     *
     * @return bool
     */
    public function hasTabContent(Individual $individual): bool
    {
        return true;
    }

    /**
     * A greyed out tab has no actual content, but may perhaps have options to create content.
     *
     * @param Individual $individual
     *
     * @return bool
     */
    public function isGrayedOut(Individual $individual): bool
    {
        if ($this->getExtendedFamily( $individual )->allIndividualsCount == 0) {      
        // tbd: use another function which is more efficient (stops if the first memeber of extended family is found)
            return true;
        } else {
            return false;
        }
    }

    /**
    * count male and female individuals
    *
    * @param array of individuals
    *
    * @return object with three elements: male, female and unknown_others (integer >= 0)
    */
    private function countMaleFemale(array $indilist): object
    {
        $mf = (object)[];
        $mf->male = 0;
        $mf->female = 0;
        $mf->unknown_others=0;
    
        foreach ($indilist as $il) {
            if ($il instanceof Individual) {
                if ($il->sex() == "M") {
                    $mf->male++;
                } elseif ($il->sex() == "F") {
                    $mf->female++;
                } else {
                   $mf->unknown_others++; 
                }
            }
        }
        
        return $mf;
    }
    
    /**
     * Find members of extended family
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getExtendedFamily(Individual $individual): object
    {
        $extfamObj = (object)[];
       
        $extfamObj->self = (object)[];
        $extfamObj->self->indi = $individual;
        $extfamObj->self->niceName = $this->niceName( $individual );
        
        $extfamObj->Grandparents = $this->getGrandparents( $individual );
        $extfamObj->UnclesAunts = $this->getUnclesAunts( $individual );
        $extfamObj->cousins = $this->getCousins( $individual );
        
        $extfamObj->allIndividualsCount = $extfamObj->Grandparents->allGrandparentCount + $extfamObj->UnclesAunts->allUncleAuntCount + $extfamObj->cousins->allCousinCount;
        
       return $extfamObj;
    }

    /**
     * Find grandparents
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getGrandparents(Individual $individual): object
    {      
        $GrandparentsObj = (object)[];  // contains three arrays of individuals and a bunch of counter values
        
        $GrandparentsObj->fatherGrandparents = [];
        $GrandparentsObj->motherGrandparents = [];
        $GrandparentsObj->fatherAndMotherGrandparents = [];
        
        $GrandparentsObj->allGrandparentCount = 0;
        
        if ($individual->childFamilies()->first()) {
            $GrandparentsObj->father = $individual->childFamilies()->first()->husband();
            $GrandparentsObj->mother = $individual->childFamilies()->first()->wife();

            // tbd: if there are stepparents of proband, then add parents and stepparents of these stepparents
            if ($GrandparentsObj->father) {
                //print_r("Start father");
               foreach ($GrandparentsObj->father->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        if ($family2->husband() instanceof Individual) {
                            $GrandparentsObj->fatherGrandparents[] = $family2->husband();
                            //print_r("add husband: "); print_r($family2->husband()->fullname());
                        }
                        if ($family2->wife() instanceof Individual) {
                            $GrandparentsObj->fatherGrandparents[] = $family2->wife();
                            //print_r("add wife: "); print_r($family2->wife()->fullname());
                        }
                     }
                  }
               }
            }
            $GrandparentsObj->fatherGrandparents = array_unique( $GrandparentsObj->fatherGrandparents );

            if ($GrandparentsObj->mother) {
               foreach ($GrandparentsObj->mother->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        $husband = $family2->husband();
                        if ($husband instanceof Individual) {
                            if ( in_array( $husband, $GrandparentsObj->fatherAndMotherGrandparents )){
                                // already stored in father and mother area
                            } elseif ( in_array( $husband, $GrandparentsObj->fatherGrandparents )){
                                $GrandparentsObj->fatherAndMotherGrandparents[] = $husband;
                                unset($GrandparentsObj->fatherGrandparents[array_search($husband,$GrandparentsObj->fatherGrandparents)]);
                            } else {
                                $GrandparentsObj->motherGrandparents[] = $husband;
                            }
                        }
                        $wife = $family2->wife();
                        if ($wife instanceof Individual) {
                            if ( in_array( $wife, $GrandparentsObj->fatherAndMotherGrandparents )){
                                // already stored in father and mother area
                            } elseif ( in_array( $wife, $GrandparentsObj->fatherGrandparents )){
                                $GrandparentsObj->fatherAndMotherGrandparents[] = $wife;
                                unset($GrandparentsObj->fatherGrandparents[array_search($wife,$GrandparentsObj->fatherGrandparents)]);
                            } else {
                                $GrandparentsObj->motherGrandparents[] = $wife;
                            }
                        }
                     }
                  }
               } 
            }
            $GrandparentsObj->motherGrandparents = array_unique( $GrandparentsObj->motherGrandparents );
            $GrandparentsObj->fatherAndMotherGrandparents = array_unique( $GrandparentsObj->fatherAndMotherGrandparents );
             
            $GrandparentsObj->fathersGrandparentCount = sizeof( $GrandparentsObj->fatherGrandparents );
            $GrandparentsObj->mothersGrandparentCount = sizeof( $GrandparentsObj->motherGrandparents );
            $GrandparentsObj->fathersAndMothersGrandparentCount = sizeof( $GrandparentsObj->fatherAndMotherGrandparents );
            
            $count = $this->countMaleFemale( $GrandparentsObj->fatherGrandparents );
            $GrandparentsObj->fathersGrandfatherCount = $count->male;
            $GrandparentsObj->fathersGrandmotherCount = $count->female;
                                  
            $count = $this->countMaleFemale( $GrandparentsObj->motherGrandparents );
            $GrandparentsObj->mothersGrandfatherCount = $count->male;
            $GrandparentsObj->mothersGrandmotherCount = $count->female;
                                              
            $count = $this->countMaleFemale( $GrandparentsObj->fatherAndMotherGrandparents );
            $GrandparentsObj->fathersAndMothersGrandfatherCount = $count->male;
            $GrandparentsObj->fathersAndMothersGrandmotherCount = $count->female;

            $GrandparentsObj->GrandfatherCount = $GrandparentsObj->fathersGrandfatherCount + $GrandparentsObj->mothersGrandfatherCount + $GrandparentsObj->fathersAndMothersGrandfatherCount;
            $GrandparentsObj->GrandmotherCount = $GrandparentsObj->fathersGrandmotherCount + $GrandparentsObj->mothersGrandmotherCount + $GrandparentsObj->fathersAndMothersGrandmotherCount;
            $GrandparentsObj->allGrandparentCount = $GrandparentsObj->fathersGrandparentCount + $GrandparentsObj->mothersGrandparentCount + $GrandparentsObj->fathersAndMothersGrandparentCount;
        }

        return $GrandparentsObj;
    }

    /**
     * Find uncles and aunts
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getUnclesAunts(Individual $individual): object
    {
    
        $unclesAuntsObj = (object)[];   // contains three arrays of individuals and a bunch of counter values
        
        $unclesAuntsObj->fatherUnclesAunts = [];
        $unclesAuntsObj->motherUnclesAunts = [];
        $unclesAuntsObj->fatherAndMotherUnclesAunts = [];
        
        $unclesAuntsObj->allUncleAuntCount = 0;
        
        if ($individual->childFamilies()->first()) {
            $unclesAuntsObj->father = $individual->childFamilies()->first()->husband();
            $unclesAuntsObj->mother = $individual->childFamilies()->first()->wife();

            if ($unclesAuntsObj->father) {
               foreach ($unclesAuntsObj->father->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        foreach ($family2->children() as $sibling) {
                            if ($sibling !== $unclesAuntsObj->father) {
                                $unclesAuntsObj->fatherUnclesAunts[] = $sibling;
                            }
                        }
                     }
                  }
               }
            }
            $unclesAuntsObj->fatherUnclesAunts = array_unique( $unclesAuntsObj->fatherUnclesAunts );

            if ($unclesAuntsObj->mother) {
               foreach ($unclesAuntsObj->mother->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        foreach ($family2->children() as $sibling) {
                            if ($sibling !== $unclesAuntsObj->mother) {
                                if ( in_array( $sibling, $unclesAuntsObj->fatherAndMotherUnclesAunts )){
                                    // already stored in father and mother area
                                } elseif ( in_array( $sibling, $unclesAuntsObj->fatherUnclesAunts )){
                                    $unclesAuntsObj->fatherAndMotherUnclesAunts[] = $sibling;
                                    unset($unclesAuntsObj->fatherUnclesAunts[array_search($sibling,$unclesAuntsObj->fatherUnclesAunts)]);
                                } else {
                                    $unclesAuntsObj->motherUnclesAunts[] = $sibling;
                                }
                            }
                        }
                     }
                  }
               } 
            }
            $unclesAuntsObj->motherUnclesAunts = array_unique( $unclesAuntsObj->motherUnclesAunts );
            $unclesAuntsObj->fatherAndMotherUnclesAunts = array_unique( $unclesAuntsObj->fatherAndMotherUnclesAunts );
             
            $unclesAuntsObj->fathersUncleAuntCount = sizeof( $unclesAuntsObj->fatherUnclesAunts );
            $unclesAuntsObj->mothersUncleAuntCount = sizeof( $unclesAuntsObj->motherUnclesAunts );
            $unclesAuntsObj->fathersAndMothersUncleAuntCount = sizeof( $unclesAuntsObj->fatherAndMotherUnclesAunts );
            
            $count = $this->countMaleFemale( $unclesAuntsObj->fatherUnclesAunts );
            $unclesAuntsObj->fathersUncleCount = $count->male;
            $unclesAuntsObj->fathersAuntCount = $count->female;
                                  
            $count = $this->countMaleFemale( $unclesAuntsObj->motherUnclesAunts );
            $unclesAuntsObj->mothersUncleCount = $count->male;
            $unclesAuntsObj->mothersAuntCount = $count->female;
                                  
            $count = $this->countMaleFemale( $unclesAuntsObj->fatherAndMotherUnclesAunts );
            $unclesAuntsObj->fathersAndMothersUncleCount = $count->male;
            $unclesAuntsObj->fathersAndMothersAuntCount = $count->female;

            $unclesAuntsObj->UncleCount = $unclesAuntsObj->fathersUncleCount + $unclesAuntsObj->mothersUncleCount + $unclesAuntsObj->fathersAndMothersUncleCount;
            $unclesAuntsObj->AuntCount = $unclesAuntsObj->fathersAuntCount + $unclesAuntsObj->mothersAuntCount + $unclesAuntsObj->fathersAndMothersAuntCount;
            $unclesAuntsObj->allUncleAuntCount = $unclesAuntsObj->fathersUncleAuntCount + $unclesAuntsObj->mothersUncleAuntCount + $unclesAuntsObj->fathersAndMothersUncleAuntCount;
        }

        return $unclesAuntsObj;
    }

    /**
     * Find half and full cousins
     *
     * @param Individual $individual
     *
     * @return object
     */
    private function getCousins(Individual $individual): object
    {
    
        $cousinsObj = (object)[];   // contains three arrays of individuals and a bunch of counter values
        
        $cousinsObj->fatherCousins = [];
        $cousinsObj->motherCousins = [];
        $cousinsObj->fatherAndMotherCousins = [];
        
        $cousinsObj->allCousinCount = 0;
        
        if ($individual->childFamilies()->first()) {
            $cousinsObj->father = $individual->childFamilies()->first()->husband();
            $cousinsObj->mother = $individual->childFamilies()->first()->wife();

            if ($cousinsObj->father) {
               foreach ($cousinsObj->father->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        foreach ($family2->children() as $sibling) {
                           if ($sibling !== $cousinsObj->father) {
                              foreach ($sibling->spouseFamilies() as $fam) {
                                 foreach ($fam->children() as $child) {
                                    $cousinsObj->fatherCousins[] = $child;
                                 }
                              }
                           }
                        }
                     }
                  }
               }
            }
            $cousinsObj->fatherCousins = array_unique( $cousinsObj->fatherCousins );

            if ($cousinsObj->mother) {
               foreach ($cousinsObj->mother->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        foreach ($family2->children() as $sibling) {
                           if ($sibling !== $cousinsObj->mother) {
                              foreach ($sibling->spouseFamilies() as $fam) {
                                 foreach ($fam->children() as $child) {
                                    if ( in_array( $child, $cousinsObj->fatherAndMotherCousins )){
                                        // already stored in father and mother area
                                    } elseif ( in_array( $child, $cousinsObj->fatherCousins )){
                                        $cousinsObj->fatherAndMotherCousins[] = $child;
                                        unset($cousinsObj->fatherCousins[array_search($child,$cousinsObj->fatherCousins)]);
                                    } else {
                                        $cousinsObj->motherCousins[] = $child;
                                    }
                                 }
                              }
                           }
                        }
                     }
                  }
               } 
            }
            $cousinsObj->motherCousins = array_unique( $cousinsObj->motherCousins );
            $cousinsObj->fatherAndMotherCousins = array_unique( $cousinsObj->fatherAndMotherCousins );
             
            $cousinsObj->fathersCousinCount = sizeof( $cousinsObj->fatherCousins );
            $cousinsObj->mothersCousinCount = sizeof( $cousinsObj->motherCousins );
            $cousinsObj->fathersAndMothersCousinCount = sizeof( $cousinsObj->fatherAndMotherCousins );
            
            $count = $this->countMaleFemale( $cousinsObj->fatherCousins );
            $cousinsObj->fathersMaleCousinCount = $count->male;
            $cousinsObj->fathersFemaleCousinCount = $count->female;
                                  
            $count = $this->countMaleFemale( $cousinsObj->motherCousins );
            $cousinsObj->mothersMaleCousinCount = $count->male;
            $cousinsObj->mothersFemaleCousinCount = $count->female;
                                              
            $count = $this->countMaleFemale( $cousinsObj->fatherAndMotherCousins );
            $cousinsObj->fathersAndMothersMaleCousinCount = $count->male;
            $cousinsObj->fathersAndMothersFemaleCousinCount = $count->female;

            $cousinsObj->maleCousinCount = $cousinsObj->fathersMaleCousinCount + $cousinsObj->mothersMaleCousinCount + $cousinsObj->fathersAndMothersMaleCousinCount;
            $cousinsObj->femaleCousinCount = $cousinsObj->fathersFemaleCousinCount + $cousinsObj->mothersFemaleCousinCount + $cousinsObj->fathersAndMothersFemaleCousinCount;
            $cousinsObj->allCousinCount = $cousinsObj->fathersCousinCount + $cousinsObj->mothersCousinCount + $cousinsObj->fathersAndMothersCousinCount;
        }

        return $cousinsObj;
    }

    /**
    * Find a short, nice name for a person
    * => use nickname ("Sepp") or Rufname or first of first names if one of these is available
    *    => otherwise use surname if available ("Mr. xxx", "Mrs. xxx", or "xxx" if sex is not F or M
    *       => otherwise use "He" or "She" or "She/he" if sex is not F or M
    *
    * @param Individual $individual
    *
    * @return string
    */
    public function niceName(Individual $individual): string
    {
        // tbd
        return $individual->fullname();
    }

    /**
     * A label for a parental family group
     *
     * @param Individual $individual
     *
     * @return string
     */
    public function getChildLabel(Individual $individual): string
    {
        if (preg_match('/\n1 FAMC @' . $individual->childFamilies()->first()->xref() . '@(?:\n[2-9].*)*\n2 PEDI (.+)/', $individual->gedcom(), $match)) {
            // A specified pedigree
            return GedcomCodePedi::getValue($match[1],$individual->getInstance($individual->xref(),$individual->tree()));
        }

        // Default (birth) pedigree
        return GedcomCodePedi::getValue('',$individual->getInstance($individual->xref(),$individual->tree()));
    }

    /**
     * @return ResponseInterface
     */
    function getCssAction() : ResponseInterface
    {
        return response(
            file_get_contents($this->resourcesFolder() . 'css/' . self::CUSTOM_MODULE . '.css'), 
            200,
            ['Content-type' => 'text/css']
        );
    }

    /** {@inheritdoc} */
    public function getTabContent(Individual $individual): string
    {
        return view($this->name() . '::tab', [
            'extfam_obj'            => $this->getExtendedFamily( $individual ),
            'extended_family_css'   => route('module', ['module' => $this->name(), 'action' => 'Css']),
            'module_obj'            => $this,
        ]); 
    }

    /** {@inheritdoc} */
    public function canLoadAjax(): bool
    {
        return false;
    }

    /**
     *  Constructor.
     */
    public function __construct()
    {
        // IMPORTANT - the constructor is called on *all* modules, even ones that are disabled.
        // It is also called before the webtrees framework is initialised, and so other components will not yet exist.
    }

    /**
     *  Boostrap.
     *
     * @param UserInterface $user A user (or visitor) object.
     * @param Tree|null     $tree Note that $tree can be null (if all trees are private).
     */
    public function boot(): void
    {
        // Here is also a good place to register any views (templates) used by the module.
        // This command allows the module to use: view($this->name() . '::', 'fish')
        // to access the file ./resources/views/fish.phtml
        View::registerNamespace($this->name(), __DIR__ . '/resources/views/');
    }

    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return string[]
     */
    public function customTranslations(string $language): array
    {
        // Here we are using an array for translations.
        // If you had .MO files, you could use them with:
        // return (new Translation('path/to/file.mo'))->asArray();
        switch ($language) {
            case 'da':
                return $this->danishTranslations();
            case 'de':
                return $this->germanTranslations();
            case 'fi':
                return $this->finnishTranslations();
            case 'fr':
            case 'fr-CA':
                return $this->frenchTranslations();
            case 'he':
                return $this->hebrewTranslations();
            case 'lt':
                return $this->lithuanianTranslations();
            case 'nb':
                return $this->norwegianBokmålTranslations();
            case 'nl':
                return $this->dutchTranslations();
            case 'nn':
                return $this->norwegianNynorskTranslations();
            case 'sv':
                return $this->swedishTranslations();               
            default:
                return [];
        }
    }

    /**
     * @return array
     */
    protected function danishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Fætre og kusiner',
            'A tab showing the extended family of an individual.' => 'En fane der viser en persons fætre og kusiner.',
            'No family available' => 'Ingen familie tilgængelig',
            'Father\'s family (%s)' => 'Fars familie (%s)',
            'Mother\'s family (%s)' => 'Mors familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registreret fæter eller kusin.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerede fæter eller kusiner.',
        ];
    }

    /**
     * @return array
     */
    protected function germanTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Großfamilie',
            'A tab showing the extended family of an individual.' => 'Reiter zeigt die Großfamilie einer Person.',
            'No family available' => 'Es wurde keine Familie gefunden.',
            'Father\'s family (%d)' => 'Familie des Vaters (%d)',
            'Mother\'s family (%d)' => 'Familie der Mutter (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie des Vaters und der Mutter (%d)',
            
            'Grandparents' => 'Großeltern',
            '%s has no grandparents recorded.' => 'Für %s sind keine Großeltern verzeichnet.',
            '%s has one grandmother recorded.' => 'Für %s ist eine Großmutter verzeichnet.',
            '%s has one grandfather recorded.' => 'Für %s ist ein Großvater verzeichnet.',
            '%s has one grandparent recorded.' => 'Für %s ist ein Großelternteil verzeichnet.',
            '%s has %d grandmothers recorded.' => 'Für %s sind %d Großmütter verzeichnet.',
            '%s has %d grandfathers recorded.' => 'Für %s sind %d Großväter verzeichnet.',
            '%s has %d grandfathers and %d grandmothers recorded (%d in total).' => 'Für %s sind %d Großväter und %d Großmütter verzeichnet (insgesamt %d).', // tbd Singular und Plural unterstützen
            
            'Uncles and Aunts' => 'Onkel und Tanten',
            '%s has no uncles or aunts recorded.' => 'Für %s sind keine Onkel oder Tanten verzeichnet.',
            '%s has one aunt recorded.' => 'Für %s ist eine Tante verzeichnet.',
            '%s has one uncle recorded.' => 'Für %s ist ein Onkel verzeichnet.',
            '%s has one uncle or aunt recorded.' => 'Für %s ist ein Onkel oder eine Tante verzeichnet.',
            '%s has %d aunts recorded.' => 'Für %s sind %d Tanten verzeichnet.',
            '%s has %d uncles recorded.' => 'Für %s sind %d Onkel verzeichnet.',
            '%s has %d uncles and %d aunts recorded (%d in total).' => 'Für %s sind %d Onkel und %d Tanten verzeichnet (insgesamt %d).', // tbd Singular und Plural unterstützen

            'Cousins' => 'Cousins und Cousinen',
            '%s has no first cousins recorded.' => 'Für %s sind keine Cousins und Cousinen ersten Grades verzeichnet.',
            '%s has one female first cousin recorded.' => 'Für %s ist eine Cousine ersten Grades verzeichnet.',
            '%s has one male first cousin recorded.' => 'Für %s ist ein Cousin ersten Grades verzeichnet.',
            '%s has one first cousin recorded.' => 'Für %s ist ein Cousin bzw. eine Cousine ersten Grades verzeichnet.',
            '%s has %d female first cousins recorded.' => 'Für %s sind %d Cousinen ersten Grades verzeichnet.',
            '%s has %d male first cousins recorded.' => 'Für %s sind %d Cousins ersten Grades verzeichnet.',
            '%s has %d male and %d female first cousins recorded (%d in total).' => 'Für %s sind %d Cousins und %d Cousinen ersten Grades verzeichnet (insgesamt %d).', // tbd Singular und Plural unterstützen
            // '%2$s has %1$d first cousin recorded.' .
            //    I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
            //    => '%2$s hat %1$d Cousin oder Cousine ersten Grades.'  . 
            //    I18N::PLURAL . '%2$s hat %1$d Cousins oder Cousinen ersten Grades.',

        ];
    }

    /**
     * @return array
     */
    protected function finnishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Serkut',
            'A tab showing the extended family of an individual.' => 'Välilehti joka näyttää henkilön serkut.',
            'No family available' => 'Perhe puuttuu',
            'Father\'s family (%s)' => 'Isän perhe (%s)',
            'Mother\'s family (%s)' => 'Äidin perhe (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s:llä on %1$d serkku sivustolla.'  . 
                I18N::PLURAL . '%2$s:lla on %1$d serkkua sivustolla.',
        ];
    }

    /**
     * @return array
     */
    protected function frenchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Cousins',
            'A tab showing the extended family of an individual.' => 'Onglet montrant les cousins d\'un individu.',
            'No family available' => 'Pas de famille disponible',
            'Father\'s family (%s)' => 'Famille paternelle (%s)',
            'Mother\'s family (%s)' => 'Famille maternelle (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s a %1$d cousin germain connu.'  . 
                I18N::PLURAL . '%2$s a %1$d cousins germains connus.',
        ];
    }

    /**
     * @return array
     */
    protected function hebrewTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'בני דודים',
            'A tab showing the extended family of an individual.' => 'חוצץ המראה בני דוד של אדם.',
            'No family available' => 'משפחה חסרה',
            'Father\'s family (%s)' => 'משפחת האב (%s)',
            'Mother\'s family (%s)' => 'משפחת האם (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => 'ל%2$s יש בן דוד אחד מדרגה ראשונה.'  . 
                I18N::PLURAL . 'ל%2$s יש %1$d בני דודים מדרגה ראשונה.',
        ];
    }

    /**
     * @return array
     */
    protected function lithuanianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Pusbroliai/Pusseserės',
            'A tab showing the extended family of an individual.' => 'Lapas rodantis asmens pusbrolius ir pusseseres.',
            'No family available' => 'Šeima nerasta',
            'Father\'s family (%s)' => 'Tėvo šeima (%s)',
            'Mother\'s family (%s)' => 'Motinos šeima (%s)',
            '%2$s has %1$d first cousin recorded.' . 
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s turi %1$d įrašyta pirmos eilės pusbrolį/pusseserę.'  . 
                I18N::PLURAL . '%2$s turi %1$d įrašytus pirmos eilės pusbrolius/pusseseres.'  . 
                I18N::PLURAL . '%2$s turi %1$d įrašytų pirmos eilės pusbrolių/pusseserių.',
        ];
    }

    /**
     * @return array
     */
    protected function norwegianBokmålTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Søskenbarn',
            'A tab showing the extended family of an individual.' => 'Fane som viser en persons søskenbarn.',
            'No family available' => 'Ingen familie tilgjengelig',
            'Father\'s family (%s)' => 'Fars familie (%s)',
            'Mother\'s family (%s)' => 'Mors familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registrert søskenbarn.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerte søskenbarn.',
        ];
    }

    /**
     * @return array
     */
    protected function dutchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Uitgebreide familie',
            'A tab showing the extended family of an individual.' => 'Tab laat neven en nichten van deze persoon zien.',
            'No family available' => 'Geen familie gevonden',
            'Father\'s family (%d)' => 'Vaders familie (%d)',
            'Mother\'s family (%d)' => 'Moeders familie (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Vaders en moeders familie (%d)',
            
            'Grandparents' => 'Grootouders',
            '%s has no grandparents recorded.' => 'Voor %s is geen grootouder geregistreerd.', 
            '%s has one grandmother recorded.' => 'Voor %s is een grootmoeder geregistreerd.',
            '%s has one grandfather recorded.' => 'Voor %s is een grootvader geregistreerd.',
            '%s has one grandparent recorded.' => 'Voor %s is een grootouder  geregistreerd.',
            '%s has %d grandmothers recorded.' => 'Voor %s zijn %d grootmoeders geregistreerd.',
            '%s has %d grandfathers recorded.' => 'Voor %s zijn %d grootvaders geregistreerd.',
            '%s has %d grandfathers and %d grandmothers recorded (%d in total).' => 'Voor %s zijn %d grootvaders en %d grootmoeders geregistreerd (%d in totaal).', // tbd ondersteuning enkelvoud en meervoud
            
            'Uncles and Aunts' => 'Ooms en tantes',
            '%s has no uncles or aunts recorded.' => 'Voor %s zijn geen ooms en tantes geregistreerd.',
            '%s has one aunt recorded.' => 'Voor %s is een tante geregistreerd.',
            '%s has one uncle recorded.' => 'Voor %s is een oom geregistreerd.',
            '%s has one uncle or aunt recorded.' => 'Voor %s is een oom of tante geregistreerd.',
            '%s has %d aunts recorded.' => 'Voor %s zijn %d tantes geregistreerd.',
            '%s has %d uncles recorded.' => 'Voor %s sind %d ooms geregistreerd.',
            '%s has %d uncles and %d aunts recorded (%d in total).' => 'Voor %s zijn %d ooms en %d tantes geregistreerd (%d in totaal).', // tbd ondersteuning enkelvoud en meervoud

            'Cousins' => 'Neven en nichten',
            '%s has no first cousins recorded.' => 'Voor %s zijn geen eerstegraads neven en nichten geregistreerd.',
            '%s has one female first cousin recorded.' => 'Voor %s is een eerstegraads nicht geregistreerd.',
            '%s has one male first cousin recorded.' => 'Voor %s is een eerstegraads neef geregistreerd.',
            '%s has one first cousin recorded.' => 'Voor %s is een eerstegraads neef of nicht geregistreerd.',
            '%s has %d female first cousins recorded.' => 'Voor %s zijn %d eerstegraads nichten geregistreerd.',
            '%s has %d male first cousins recorded.' => 'Voor %s zijn %d eerstegraads neven geregistreerd.',
            '%s has %d male and %d female first cousins recorded (%d in total).' => 'Voor %s zijn %d eerstegraads neven en %d eerstegraads nichten geregistreerd (%d in totaal).', // tbd ondersteuning enkelvoud en meervoud
            // '%2$s has %1$d first cousin recorded.' .
            //    I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
            //    => '%2$s heeft %1$d eerstegraads neef of nicht.'  . 
            //    I18N::PLURAL . '%2$s heeft %1$d eerstegraads neven en nichten.',
        ];
    }

    /**
     * @return array
     */
    protected function norwegianNynorskTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Syskenbarn',
            'A tab showing the extended family of an individual.' => 'Fane som syner ein person sine syskenbarn.',
            'No family available' => 'Ingen familie tilgjengeleg',
            'Father\'s family (%s)' => 'Fars familie (%s)',
            'Mother\'s family (%s)' => 'Mors familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registrert syskenbarn.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerte syskenbarn.',
        ];
    }
  
    /**
     * @return array
     */
    protected function swedishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Kusiner',
            'A tab showing the extended family of an individual.' => 'En flik som visar en persons kusiner.',
            'No family available' => 'Familj saknas',
            'Father\'s family (%s)' => 'Faderns familj (%s)',
            'Mother\'s family (%s)' => 'Moderns familj (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s har %1$d registrerad kusin.'  . 
                I18N::PLURAL . '%2$s har %1$d registrerade kusiner.',
        ];
    }

};

return new ExtendedFamilyTabModule;
