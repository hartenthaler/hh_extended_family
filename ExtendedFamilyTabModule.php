<?php
/*
 * webtrees - extended family tab
 *
 * based on vytux_cousins and simpl_cousins
 *
 * Copyright (C) 2021 Hermann Hartenthaler. All rights reserved.
 * Copyright (C) 2013 Vytautas Krivickas and vytux.com. All rights reserved. 
 * Copyright (C) 2013 Nigel Osborne and kiwtrees.net. All rights reserved.
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
 * tbd
 * ---
 * Code: autoloader wieder aktivieren und alle require_once eliminieren?
 * Code: Anpassungen an Bootstrap 5 (filter-Buttons) und webtrees 2.1 (neue Testumgebung aufsetzen)
 * Code: Beziehungsbezeichnungen als Label aus Vesta-Relationship oder durch eigene Funktion ergänzen?
 * Code: Funktionen getSizeThumbnailW() und getSizeThumbnailH() verbessern (siehe issue #46 von Sir Peter)
 *      Gibt es einen Zusammenhang oder sind sie unabhängig? Wie genau wirken sie sich aus? Testen, wenn im CSS-Modul nichts eingetragen ist.
 *      Option für thumbnail size? css für silhouette anpassen?
 * Code: neues Management für Updates und Information der Anwender über Neuigkeiten zu diesem Modul
 * Code: Datenbank-Schema mit Updates einführen, damit man Familienteile auch ändern und löschen kann
 * Code: restliche, verstreut vorkommenden Übersetzungen mit I18N alle nach tab.html verschieben
 * Code: Iterate-Pattern für Umgang mit groups implementieren?
 * Code: alle noch verwendeten object als Klassen definieren?
 *
 * neue Idee: Statistikfunktion für webtrees zur Ermittlung der längsten und der umfangreichsten Heiratsketten in einem Tree
 * neue Idee: Liste der Spitzenahnen
 * neue Idee: Kette zum entferntesten Vorfahren
 * neue Idee: Kette zum entferntesten Nachkommen
 */

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\View;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\FlashMessages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleTabTrait;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleConfigTrait;
use Fisharebest\Webtrees\Module\ModuleTabInterface;
use Fisharebest\Webtrees\Module\ModuleConfigInterface;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
//use Cissee\Webtrees\Module\ExtendedRelationships;

use function str_starts_with;   // will be added in PHP 8.0
use function explode;
use function implode;
use function count;
use function in_array;

require_once(__DIR__ . '/ExtendedFamily.php');
require_once(__DIR__ . '/ExtendedFamilyPersonExists.php');

/**
 * Class ExtendedFamilyTabModule
 */
class ExtendedFamilyTabModule extends AbstractModule implements ModuleTabInterface, ModuleCustomInterface, ModuleConfigInterface
{
    use ModuleTabTrait;
    use ModuleCustomTrait;
    use ModuleConfigTrait;

    /**
     * list of const for module administration
     */
    public const CUSTOM_TITLE       = 'Extended family';
    public const CUSTOM_MODULE      = 'hh_extended_family';
    public const CUSTOM_DESCRIPTION = 'A tab showing the extended family of an individual.';
    public const CUSTOM_AUTHOR      = 'Hermann Hartenthaler';
    public const CUSTOM_WEBSITE     = 'https://github.com/hartenthaler/' . self::CUSTOM_MODULE . '/';
    public const CUSTOM_VERSION     = '2.0.16.57';
    public const CUSTOM_LAST        = 'https://github.com/hartenthaler/' .
                                      self::CUSTOM_MODULE. '/raw/main/latest-version.txt';
   
    /**
     * find members of extended family parts
     *
     * @param Individual $proband
     * @return object
     */
    private function getExtendedFamily(Individual $proband): object
    {
        return new ExtendedFamily($proband, $this->buildConfig($proband));
    }

    /**
     * check in efficient way if there is at least one person in one of the selected extended family parts
     * (used to decide if tab has to be grayed out)
     *
     * @param Individual $proband
     * @return bool
     */
    private function personExistsInExtendedFamily(Individual $proband): bool
    {
        return (new ExtendedFamilyPersonExists($proband, $this->buildConfig($proband)))->found();
    }
     
    /**
     * get configuration information
     *
     * @param Individual $proband
     * @return object
     */
    private function buildConfig(Individual $proband): object
    {
        $configObj = (object)[];
        $configObj->showEmptyBlock          = $this->showEmptyBlock();
        $configObj->showShortName           = $this->showShortName();
        $configObj->showLabels              = $this->showLabels();
        $configObj->useCompactDesign        = $this->useCompactDesign();
        $configObj->showThumbnail           = $this->showThumbnail($proband->tree());
        $configObj->showFilterOptions       = $this->showFilterOptions();
        $configObj->showParameters          = $this->showParameters();
        $configObj->filterOptions           = $this->showFilterOptions() ? ExtendedFamily::getFilterOptions(): ['all'];
        $configObj->shownFamilyParts        = $this->getShownFamilyParts();
        $configObj->familyPartParameters    = ExtendedFamily::getFamilyPartParameters();
        $configObj->sizeThumbnailW          = $this->getSizeThumbnailW();
        $configObj->sizeThumbnailH          = $this->getSizeThumbnailH();
        //$configObj->name = $this->name();     // nötig, falls Vesta-Module doch genutzt werden sollten
                                                //(unklar wie diese Information ins Modul ExtendedFamilyPart.php transferiert werden soll)
        return $configObj;
    }

    /**
     * size for thumbnails W
     *
     * @return int
     */
    private function getSizeThumbnailW(): int
    {
        return 66;
    }

    /**
     * size for thumbnails H
     *
     * @return int
     */
    private function getSizeThumbnailH(): int
    {
        return 100;
    }

    /**
     * dependency check if Vesta modules are available (needed for relationship name)
     *
     * @param bool $showErrorMessage
     * @return bool
     */
    public static function VestaModulesAvailable(bool $showErrorMessage): bool
    {
        $vesta = class_exists("Cissee\WebtreesExt\AbstractModule", true);
        if (!$vesta && $showErrorMessage) {
            FlashMessages::addMessage("Missing dependency - Make sure to install all Vesta modules!");
        }
        return $vesta;
    }

    /**
     * generate list of other preferences
     * (control panel options beside the options related to the extended family parts itself)
     *
     * @return array of string
     */
    private function listOfOtherPreferences(): array
    {
        return [
            'show_filter_options',
            'show_empty_block',
            'show_short_name',
            'show_labels',
            'show_parameters',
            'use_compact_design',
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->layout = 'layouts/administration';
        $response = [];
        
        $preferences = $this->listOfOtherPreferences();
        foreach ($preferences as $preference) {
            $response[$preference] = $this->getPreference($preference);
        }

        $response['efps'] = $this->getShownFamilyParts();
        $response['title'] = $this->title();
        $response['description'] = $this->description();
        $response['uses_sorting'] = true;

        return $this->viewResponse($this->name() . '::settings', $response);
    }

    /**
     * save the user preferences in the database
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function postAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array) $request->getParsedBody();
        if ($params['save'] === '1') {
            $this->postAdminActionOther($params);
            $this->postAdminActionEfp($params);
            FlashMessages::addMessage(
                I18N::translate('The preferences for the module “%s” have been updated.', $this->title()), 'success');
        }
        return redirect($this->getConfigLink());
    }

    /**
     * save the user preferences for all parameters that are not explicitly related to the extended family parts in the database
     *
     * @param array $params configuration parameters
     */
    private function postAdminActionOther(array $params)
    {
        $preferences = $this->listOfOtherPreferences();
        foreach ($preferences as $preference) {
            $this->setPreference($preference, $params[$preference]);
        }
    }

    /**
     * save the user preferences for all parameters related to the extended family parts in the database
     *
     * @param array $params configuration parameters
     */
    private function postAdminActionEfp(array $params)
    {
        $order = implode(",", $params['order']);
        $this->setPreference('order', $order);
        foreach (ExtendedFamily::listOfFamilyParts() as $efp) {
            $this->setPreference('status-' . $efp, '0');
        }
        foreach ($params as $key => $value) {
            if (str_starts_with($key, 'status-')) {
                $this->setPreference($key, $value);
            }
        }
    }

    /**
     * parts of extended family which should be shown (order and enabled/disabled)
     * set default values in case the settings are not stored in the database yet
     *
     * @return array of ordered objects with name and status (enabled/disabled)
     */
    private function getShownFamilyParts(): array
    {
        $listOfFamilyParts = ExtendedFamily::listOfFamilyParts();
        $orderDefault = implode(',', $listOfFamilyParts);
        $order = explode(',', $this->getPreference('order', $orderDefault));
        
        $this->checkAndAddFamilyParts($listOfFamilyParts, $order);
        
        $shownParts = [];
        foreach ($order as $efp) {
            $efpObj = (object)[];
            $efpObj->name     = ExtendedFamily::translateFamilyPart($efp);
            $efpObj->enabled  = $this->getPreference('status-' . $efp, 'on');
            $shownParts[$efp] = $efpObj;
        }
        return $shownParts;
    }

    /**
     * check if there are new parts of extended family defined
     * tbd: it is not possible to delete family parts, only add new ones
     *
     * @param array $lofp list of extended family parts defined by this module
     * @param array $order list of ordered family parts out of parameters
     */
    private function checkAndAddFamilyParts(array $lofp, array &$order)
    {
        if (count($lofp) > count($order)) {
            foreach ($lofp as $familyPart) {
                if (!in_array($familyPart, $order)) {
                    $order[] = $familyPart;                 // add new parts at the end of the list
                }
            }
        }
    }

    /**
     * should filter options be shown (user can filter by gender or alive/dead)
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showFilterOptions(): bool
    {
        return ($this->getPreference('show_filter_options', '0') == '0');
    }

    /**
     * how should empty parts of the extended family be presented
     * set default values in case the settings are not stored in the database yet
     *
     * @return string
     */
    private function showEmptyBlock(): string
    {
        return $this->getPreference('show_empty_block', '0');
    }

    /**
     * should a short name of proband be shown
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showShortName(): bool
    {
        return ($this->getPreference('show_short_name', '0') == '0');
    }

    /**
     * should a label be shown
     * labels are shown for special situations like:
     * person: adopted person, stillborn
     * siblings and children: adopted or foster child, twin
     *
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showLabels(): bool
    {
        return ($this->getPreference('show_labels', '0') == '0');
    }

    /**
     * should parameters for each extended family part be shown (like generation shift and coefficient of relationship)
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showParameters(): bool
    {
        return ($this->getPreference('show_parameters', '0') == '0');
    }

    /**
     * use compact design for individual blocks or show additional information (photo, birth and death information)
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function useCompactDesign(): bool
    {
        return ($this->getPreference('use_compact_design', '0') == '0');
    }

    /**
     * get preference in tis tree to show thumbnails
     * @param object $tree
     *
     * @return bool
     */
    private function isTreePreferenceShowingThumbnails(object $tree): bool
    {
        return ($tree->getPreference('SHOW_HIGHLIGHT_IMAGES') == '1');
    }

    /**
     * show thumbnail if compact design is not selected and if global preference allows seeing thumbnails
     *
     * @param object $tree
     * @return bool
     */
    private function showThumbnail(object $tree): bool
    {
        return (!$this->useCompactDesign() && $this->isTreePreferenceShowingThumbnails($tree));
    }
 
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
     * Where to get support for this module?  Perhaps a GitHub repository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_WEBSITE;
    }
    
    /**
     * Where does this module store its resources?
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }

    /**
     * The default position for this tab can be changed in the control panel.
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
     * @return bool
     */
    public function hasTabContent(Individual $individual): bool
    {
        return true;
    }

    /**
     * A greyed out tab has no actual content, but perhaps have options to create content.
     *
     * @param Individual $individual
     * @return bool
     */
    public function isGrayedOut(Individual $individual): bool
    {
        return !$this->personExistsInExtendedFamily($individual);
    }
    
    /**
     * Where are the CCS specifications for this module stored?
     *
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
            'extfam_obj'            => $this->getExtendedFamily($individual),
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
     *  constructor
     */
    public function __construct()
    {
        // IMPORTANT - the constructor is called on *all* modules, even ones that are disabled.
        // It is also called before the webtrees framework is initialised, and so other components will not yet exist.
    }

    /**
     *  bootstrap
     *
     * @param UserInterface $user A user (or visitor) object.
     * @param Tree|null     $tree Note that $tree can be null (if all trees are private).
     */
    public function boot(): void
    {
        // Here is also a good place to register any views (templates) used by the module.
        // This command allows the module to use: view($this->name() . '::', 'fish')
        // to access the file ./resources/views/fish.phtml
        View::registerNamespace($this->name(), $this->resourcesFolder() . 'views/');
    }
    
    /**
     * additional translations
     *
     * @param string $language
     * @return array of string
     */
    public function customTranslations(string $language): array
    {
        // Here we are using an array for translations.
        // If you had .MO files, you could use them with: return (new Translation('path/to/file.mo'))->asArray();
        
        require_once($this->resourcesFolder() . 'lang/ExtendedFamilyTranslations.php');
        
        switch ($language) {
            case 'cs':
                return ExtendedFamilyTranslations::czechTranslations();
            case 'da':
                return ExtendedFamilyTranslations::danishTranslations();            // tbd
            case 'de':
                return ExtendedFamilyTranslations::germanTranslations();
            case 'es':
                return ExtendedFamilyTranslations::spanishTranslations();
            case 'fi':
                return ExtendedFamilyTranslations::finnishTranslations();           // tbd
            case 'fr':
            case 'fr-CA':
                return ExtendedFamilyTranslations::frenchTranslations();            // tbd
            case 'he':
                return ExtendedFamilyTranslations::hebrewTranslations();            // tbd
            case 'it':
                return ExtendedFamilyTranslations::italianTranslations();           // tbd    
            case 'lt':
                return ExtendedFamilyTranslations::lithuanianTranslations();        // tbd
            case 'nb':
                return ExtendedFamilyTranslations::norwegianBokmålTranslations();   // tbd
            case 'nl':
                return ExtendedFamilyTranslations::dutchTranslations();
            case 'nn':
                return ExtendedFamilyTranslations::norwegianNynorskTranslations();   // tbd
            case 'sk':
                return ExtendedFamilyTranslations::slovakTranslations();     
            case 'sv':
                return ExtendedFamilyTranslations::swedishTranslations();            // tbd
            case 'uk':
                return ExtendedFamilyTranslations::ukrainianTranslations();
            case 'vi':
                return ExtendedFamilyTranslations::vietnameseTranslations();
            case 'zh-Hans':
                return ExtendedFamilyTranslations::chineseSimplifiedTranslations();   // tbd
            case 'zh-Hant':
                return ExtendedFamilyTranslations::chineseTraditionalTranslations();  // tbd
            default:
                return [];
        }
    }
}
return new ExtendedFamilyTabModule;
