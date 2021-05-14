<?php
/*
 * webtrees - cousins tab based on vytux_cousins and simpl_cousins
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

namespace Hartenthaler\WebtreesModules\hh_cousins;

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
class CousinsTabModule extends AbstractModule implements ModuleTabInterface, ModuleCustomInterface {
    use ModuleCustomTrait;
    use ModuleTabTrait;

    public const CUSTOM_TITLE = 'Cousins';
    
    public const CUSTOM_MODULE = 'hh_cousins';
    
    public const CUSTOM_DESCRIPTION = 'A tab showing cousins of an individual.';

    public const CUSTOM_AUTHOR = 'Hermann Hartenthaler';
    
    public const CUSTOM_WEBSITE = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE . '/';
    
    public const CUSTOM_VERSION = '2.0.16.4';

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
        return /* I18N: Description of the "Facts and events" module */ I18N::translate(self::CUSTOM_DESCRIPTION);
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
        if ($this->getCousins($individual)->allCousinCount == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function getCousins(Individual $individual): object
    {
        $cousinsObj = (object)[];
        $cousinsObj->self = $individual;
        $cousinsObj->fathersCousinCount = 0;
        $cousinsObj->mothersCousinCount = 0;
        $cousinsObj->allCousinCount = 0;
        $cousinsObj->fatherCousins = [];
        $cousinsObj->motherCousins = [];
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
                                    $cousinsObj->fathersCousinCount++;
                                 }
                              }
                           }
                        }
                     }
                  }
               }
            }
            $cousinsObj->fatherCousins = array_unique( $cousinsObj->fatherCousins );
            $cousinsObj->fathersCousinCount = sizeof( $cousinsObj->fatherCousins );

            if ($cousinsObj->mother) {
               foreach ($cousinsObj->mother->childFamilies() as $family) {
                  foreach ($family->spouses() as $parent) {
                     foreach ($parent->spouseFamilies() as $family2) {
                        foreach ($family2->children() as $sibling) {
                           if ($sibling !== $cousinsObj->mother) {
                              foreach ($sibling->spouseFamilies() as $fam) {
                                 foreach ($fam->children() as $child) {
									if ( in_array( $child, $cousinsObj->fatherCousins )){} else {
                                       $cousinsObj->motherCousins[] = $child;
                                       $cousinsObj->mothersCousinCount++;
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
            $cousinsObj->mothersCousinCount = sizeof( $cousinsObj->motherCousins );

            $cousinsObj->allCousinCount = sizeof(array_unique(array_merge($cousinsObj->fatherCousins,$cousinsObj->motherCousins)));
        }

        return $cousinsObj;
    }

    /**
     * A label for a parental family group
     *
     * @param Family $family
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
            'cousins_obj'   => $this->getCousins($individual),
            'cousins_css'   => route('module', ['module' => $this->name(), 'action' => 'Css']),
            'module_obj'    => $this,
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
            'Cousins' => 'Fætre og kusiner',
            'A tab showing cousins of an individual.' => 'En fane der viser en persons fætre og kusiner.',
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
            'Cousins' => 'Cousins/Cousinen',
            'A tab showing cousins of an individual.' => 'Reiter zeigt Cousins und Cousinen einer Person.',
            'No family available' => 'Es wurde keine Familie gefunden.',
            'Father\'s family (%s)' => 'Familie des Vaters (%s)',
            'Mother\'s family (%s)' => 'Familie der Mutter (%s)',
            '%s has no first cousins recorded.' => 'Für %s sind keine Cousins und Cousinen ersten Grades aufgezeichnet.',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s hat %1$d Cousin oder Cousine ersten Grades.'  . 
                I18N::PLURAL . '%2$s hat %1$d Cousins oder Cousinen ersten Grades.',
        ];
    }

    /**
     * @return array
     */
    protected function finnishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Cousins' => 'Serkut',
            'A tab showing cousins of an individual.' => 'Välilehti joka näyttää henkilön serkut.',
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
            'Cousins' => 'Cousins',
            'A tab showing cousins of an individual.' => 'Onglet montrant les cousins d\'un individu.',
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
            'Cousins' => 'בני דודים',
            'A tab showing cousins of an individual.' => 'חוצץ המראה בני דוד של אדם.',
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
            'Cousins' => 'Pusbroliai/Pusseserės',
            'A tab showing cousins of an individual.' => 'Lapas rodantis asmens pusbrolius ir pusseseres.',
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
            'Cousins' => 'Søskenbarn',
            'A tab showing cousins of an individual.' => 'Fane som viser en persons søskenbarn.',
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
            'Cousins' => 'Neven en Nichten',
            'A tab showing cousins of an individual.' => 'Tab laat neven en nichten van deze persoon zien.',
            'No family available' => 'Geen familie gevonden',
            'Father\'s family (%s)' => 'Vader\'s familie (%s)',
            'Mother\'s family (%s)' => 'Moeder\'s familie (%s)',
            '%2$s has %1$d first cousin recorded.' .
                I18N::PLURAL . '%2$s has %1$d first cousins recorded.'   
                => '%2$s heeft %1$d neef of nicht in de eerste lijn.'  . 
                I18N::PLURAL . '%2$s heeft %1$d neven en nichten in de eerste lijn.',
        ];
    }

    /**
     * @return array
     */
    protected function norwegianNynorskTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Cousins' => 'Syskenbarn',
            'A tab showing cousins of an individual.' => 'Fane som syner ein person sine syskenbarn.',
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
            'Cousins' => 'Kusiner',
            'A tab showing cousins of an individual.' => 'En flik som visar en persons kusiner.',
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

return new CousinsTabModule;
