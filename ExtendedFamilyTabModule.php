<?php
/*
 * webtrees - extended family tab (custom module)
 *
 * Copyright (C) 2026 Hermann Hartenthaler.
 * Copyright (C) 2013 Vytautas Krivickas and vytux.com.
 * Copyright (C) 2013 Nigel Osborne and kiwtrees.net.
 *
 * webtrees: online genealogy application
 * Copyright (C) 2026 webtrees development team.
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
 * Test: in Testdatei "komplexe Familie" erscheinen keine Personenbadges (adoptiert, etc)
 * Test: Konfigurationsoption "Partnerketten zählen dazu/nicht dazu"
 * Test: Prüfen, ob allCountUnique immer richtig berechnet wird
 * Test: Rada testen inkl. Rada-Geschwistern, gibt es ein Badge?
 * Test: was passiert, wenn der webtrees-Sammelbehälter deaktiviert ist?
 * Test: Übersetzung bei den Partnern testen bei diversen Fällen mit gemischtem Geschlecht
 * Doku:README: alle Screenshots aktualisieren
 * Bug/Test: Familiengruppe Partner: Problem mit Zusammenfassung, falls Geschlecht der Partner oder Geschlecht der Partner von
 *                Partner gemischt sein sollte
 * Bug/Test: Familiengruppe Partnerketten: von Ge. geht keine Partnerkette aus, aber sie ist Mitglied in der Partnerkette
 *                von Di. zu Ga., d.h. dies als zweite Information ergänzen
 * Code: Versionsprüfung von hh_metasearch übernehmen ??? oder ganz anders?
 * Code: Qualität überprüfen und wichtigste Dinge als issue formulieren
 */

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use HuHwt\WebtreesMods\ClippingsCartEnhanced\ClippingsCartEnhancedModule;
use Fisharebest\Localization\Translation;
use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\Http\Exceptions\HttpAccessDeniedException;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Registry;
use Fisharebest\Webtrees\Session;
use Fisharebest\Webtrees\Validator;
use Fisharebest\Webtrees\View;
use Fisharebest\Webtrees\Webtrees;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\FlashMessages;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleTabTrait;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleConfigTrait;
use Fisharebest\Webtrees\Module\ModuleMenuInterface;
use Fisharebest\Webtrees\Module\ModuleTabInterface;
use Fisharebest\Webtrees\Module\ModuleConfigInterface;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Services\ModuleService;
use Fisharebest\Webtrees\Services\TreeService;
use Hartenthaler\Webtrees\Module\ExtendedFamily\Internationalization\MoreI18N;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function str_starts_with;
use function explode;
use function implode;
use function count;
use function in_array;
use function redirect;

/**
 * Class ExtendedFamilyTabModule
 */
class ExtendedFamilyTabModule extends AbstractModule
                              implements ModuleTabInterface, ModuleCustomInterface, ModuleConfigInterface
{
    use ModuleTabTrait;
    use ModuleCustomTrait;
    use ModuleConfigTrait;

    /**
     * list of const for module administration
     */

    // Module title
    public const CUSTOM_TITLE       = 'Extended family';

    // Module file name
    public const CUSTOM_MODULE      = 'hh_extended_family';

    // Author of custom module
    public const CUSTOM_AUTHOR      = 'Hermann Hartenthaler';

    // User at GitHub
    public const CUSTOM_GITHUB_USER = 'hartenthaler';

    // GitHub repository
    public const GITHUB_REPO        = self::CUSTOM_GITHUB_USER . '/' . self::CUSTOM_MODULE;

    // Custom module website
    public const CUSTOM_WEBSITE     = 'https://github.com/' . self::GITHUB_REPO . '/';

    // Custom module version
    public const CUSTOM_VERSION     = '2.2.6.8';

    // URL to the latest version of the custom module
    public const CUSTOM_LAST        = 'https://github.com/' . self::CUSTOM_GITHUB_USER . '/' .
                                                              self::CUSTOM_MODULE . '/raw/main/latest-version.txt';

    private const CLIPPINGS_CART_ACTION_CCE      = 'cce';
    private const CLIPPINGS_CART_ACTION_INTERNAL = 'internal';
    private const CLIPPINGS_CART_ENHANCED_MODULE = '_huhwt-cce_';
    private const VESTA_UTILS_CLASS              = '\Vesta\VestaUtils';
    private const THUMBNAIL_SIZE_SMALL           = 'small';
    private const THUMBNAIL_SIZE_MEDIUM          = 'medium';
    private const THUMBNAIL_SIZE_LARGE           = 'large';
    private const THUMBNAIL_SIZES                = [
        self::THUMBNAIL_SIZE_SMALL  => ['width' => 66, 'height' => 100],
        self::THUMBNAIL_SIZE_MEDIUM => ['width' => 80, 'height' => 120],
        self::THUMBNAIL_SIZE_LARGE  => ['width' => 100, 'height' => 150],
    ];

    /**
     * find members of extended family parts
     *
     * @param Individual $proband
     * @return object
     */
    public function getExtendedFamily(Individual $proband): object
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
        $configObj->showFilterOptions           = $this->showFilterOptions();
        $configObj->filterOptions               = $this->showFilterOptions() ? ExtendedFamilySupport::getFilterOptions(): ['all'];
        $configObj->showSummary                 = $this->showSummary();
        $configObj->showSummaryStatistics       = $this->showSummaryStatistics();
        $configObj->showEmptyBlock              = $this->showEmptyBlock();
        $configObj->countPartnerChainsToTotal   = $this->countPartnerChainsToTotal();
        $configObj->showPrintButton             = $this->showPrintButton();
        $configObj->showShortName               = $this->showShortName();
        $configObj->showLabels                  = $this->showLabels();
        $configObj->showSosaNumbers             = $this->showSosaNumbers();
        $configObj->showRelationshipToProband   = $this->showRelationshipToProband();
        $configObj->useCompactDesign            = $this->useCompactDesign();
        $configObj->useClippingsCart            = $this->useClippingsCart();
        $configObj->shownFamilyParts            = $this->getShownFamilyParts();
        $configObj->showParameters              = $this->showParameters();
        $configObj->familyPartParameters        = ExtendedFamilySupport::getFamilyPartParameters();
        $configObj->placeFormat                 = $this->placeFormat();
        $configObj->showThumbnail               = $this->showThumbnail($proband->tree());
        $configObj->sizeThumbnailW              = $this->getSizeThumbnailW();
        $configObj->sizeThumbnailH              = $this->getSizeThumbnailH();
        return $configObj;
    }

    /**
     * size for thumbnails W
     *
     * @return int
     */
    private function getSizeThumbnailW(): int
    {
        return $this->thumbnailDimensions()['width'];
    }

    /**
     * size for thumbnails H
     *
     * @return int
     */
    private function getSizeThumbnailH(): int
    {
        return $this->thumbnailDimensions()['height'];
    }

    /**
     * @return array{width:int,height:int}
     */
    private function thumbnailDimensions(): array
    {
        return self::THUMBNAIL_SIZES[$this->thumbnailSize()];
    }

    private function thumbnailSize(): string
    {
        $thumbnailSize = $this->getPreference('thumbnail_size', self::THUMBNAIL_SIZE_SMALL);

        return array_key_exists($thumbnailSize, self::THUMBNAIL_SIZES) ? $thumbnailSize : self::THUMBNAIL_SIZE_SMALL;
    }

    /**
     * @return array<string,string>
     */
    private function thumbnailSizeOptions(): array
    {
        return [
            self::THUMBNAIL_SIZE_SMALL  => I18N::translate('small') . ' (66 x 100 px)',
            self::THUMBNAIL_SIZE_MEDIUM => I18N::translate('medium') . ' (80 x 120 px)',
            self::THUMBNAIL_SIZE_LARGE  => I18N::translate('large') . ' (100 x 150 px)',
        ];
    }

    /**
     * generate list of other preferences
     * (control panel options beside the options related to the extended family parts itself)
     *
     * @return array<int,string>
     */
    private function listOfOtherPreferences(): array
    {
        return [
            'show_filter_options',
            'show_empty_block',
            'show_short_name',
            'show_labels',
            'show_sosa_numbers',
            'show_relationship_to_proband',
            'show_parameters',
            'use_compact_design',
            'thumbnail_size',
            'place_format',
            'show_summary',
            'show_summary_statistics',
            'count_partner_chains',
            'show_print_button',
            'use_clippings_cart',
            'clippings_cart_action',
            'load_tab_on_click',
        ];
    }

    /**
     * view module settings in control panel
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->layout = 'layouts' . DIRECTORY_SEPARATOR . 'administration';
        $response = [];
        
        $preferences = $this->listOfOtherPreferences();
        foreach ($preferences as $preference) {
            $response[$preference] = $this->getPreference($preference);
        }
        $response['show_sosa_numbers'] = $this->showSosaNumbers() ? '0' : '1';

        $response['efps']           	   = $this->getShownFamilyParts();
        $response['title']          	   = $this->title();
        $response['description']    	   = $this->description();
        $response['uses_sorting']   	   = true;
        $response['place_format_options']  = PlaceAbbreviation::abbrPlacesOptions();
        $response['thumbnail_size']         = $this->thumbnailSize();
        $response['thumbnail_size_options'] = $this->thumbnailSizeOptions();
        $response['cce_available']  	   = $this->isClippingsCartEnhancedAvailable();
        $response['clippings_cart_action'] = $this->clippingsCartAction();
        $response['relationship_names_available'] = $this->relationshipNamesAvailable();

        return $this->viewResponse($this->name() . '::' . 'settings', $response);
    }

    /**
     * save module settings after returning from control panel
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function postAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $save = Validator::parsedBody($request)->string('save', '');

        // save the received settings to the user preferences
        if ($save === '1') {
            $params = $this->validatedAdminParameters($request);

            if (($params['clippings_cart_action'] ?? '') !== self::CLIPPINGS_CART_ACTION_INTERNAL) {
                $params['clippings_cart_action'] = self::CLIPPINGS_CART_ACTION_CCE;
            }

            if (!$this->isClippingsCartEnhancedAvailable()) {
                $params['clippings_cart_action'] = self::CLIPPINGS_CART_ACTION_INTERNAL;
            }

            $this->postAdminActionOther($params);
            $this->postAdminActionEfp($params);
            FlashMessages::addMessage(MoreI18N::xlate('The preferences for the module “%s” have been updated.',
                $this->title()), 'success');

            if (($params['use_clippings_cart'] ?? '1') === '0' && !$this->isClippingsCartEnhancedAvailable()) {
                FlashMessages::addMessage($this->clippingsCartEnhancedFallbackMessage(), 'warning');
            }

            if (($params['show_relationship_to_proband'] ?? '1') === '0' && !$this->relationshipNamesAvailable()) {
                FlashMessages::addMessage($this->relationshipNamesUnavailableMessage(), 'warning');
            }
        }
        return redirect($this->getConfigLink());
    }

    /**
     * Read and validate all settings from the control-panel form.
     *
     * @param ServerRequestInterface $request
     * @return array<string,mixed>
     */
    private function validatedAdminParameters(ServerRequestInterface $request): array
    {
        $family_parts         = ExtendedFamilySupport::listFamilyParts();
        $place_format_options = array_map('strval', array_keys(PlaceAbbreviation::abbrPlacesOptions()));
        $thumbnail_size_options = array_keys(self::THUMBNAIL_SIZES);

        $params = [
            'show_filter_options'     => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_filter_options', '0'),
            'show_empty_block'        => Validator::parsedBody($request)->isInArray(['0', '1', '2'])->string('show_empty_block', '0'),
            'show_short_name'         => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_short_name', '0'),
            'show_labels'             => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_labels', '0'),
            'show_sosa_numbers'       => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_sosa_numbers', '1'),
            'show_relationship_to_proband' => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_relationship_to_proband', '0'),
            'show_parameters'         => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_parameters', '0'),
            'use_compact_design'      => Validator::parsedBody($request)->isInArray(['0', '1'])->string('use_compact_design', '0'),
            'thumbnail_size'          => Validator::parsedBody($request)->isInArray($thumbnail_size_options)->string('thumbnail_size', self::THUMBNAIL_SIZE_SMALL),
            'place_format'            => Validator::parsedBody($request)->isInArray($place_format_options)->string('place_format', (string) PlaceAbbreviation::OPTION_FULL_PLACE_NAME),
            'show_summary'            => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_summary', '0'),
            'show_summary_statistics' => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_summary_statistics', '0'),
            'count_partner_chains'    => Validator::parsedBody($request)->isInArray(['0', '1'])->string('count_partner_chains', '0'),
            'show_print_button'       => Validator::parsedBody($request)->isInArray(['0', '1'])->string('show_print_button', '0'),
            'use_clippings_cart'      => Validator::parsedBody($request)->isInArray(['0', '1'])->string('use_clippings_cart', '0'),
            'clippings_cart_action'   => Validator::parsedBody($request)->isInArray([self::CLIPPINGS_CART_ACTION_CCE, self::CLIPPINGS_CART_ACTION_INTERNAL])->string('clippings_cart_action', self::CLIPPINGS_CART_ACTION_CCE),
            'load_tab_on_click'       => Validator::parsedBody($request)->isInArray(['0', '1'])->string('load_tab_on_click', '0'),
            'order'                   => [],
        ];

        foreach (Validator::parsedBody($request)->array('order') as $family_part) {
            if (in_array($family_part, $family_parts, true)) {
                $params['order'][] = $family_part;
            }
        }

        if ($params['order'] === []) {
            $params['order'] = $family_parts;
        }

        foreach ($family_parts as $family_part) {
            if (Validator::parsedBody($request)->boolean('status-' . $family_part, false)) {
                $params['status-' . $family_part] = 'on';
            }
        }

        return $params;
    }

    /**
     * save the user preferences for all parameters
     * that are not explicitly related to the extended family parts in the database
     *
     * @param array<string,mixed> $params configuration parameters
     */
    private function postAdminActionOther(array $params)
    {
        $preferences = $this->listOfOtherPreferences();
        foreach ($preferences as $preference) {
            if (array_key_exists($preference, $params)) {
                $this->setPreference($preference, $params[$preference]);
            }
        }
    }

    /**
     * save the user preferences for all parameters related to the extended family parts in the database
     *
     * @param array<string,mixed> $params configuration parameters
     */
    private function postAdminActionEfp(array $params)
    {
        $order = implode(",", $params['order']);
        $this->setPreference('order', $order);
        foreach (ExtendedFamilySupport::listFamilyParts() as $efp) {
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
     * @return array<string,object> of ordered objects with translated name and status (enabled/disabled)
     */
    private function getShownFamilyParts(): array
    {
        $listFamilyParts = ExtendedFamilySupport::listFamilyParts();
        $orderDefault = implode(',', $listFamilyParts);
        $order = explode(',', $this->getPreference('order', $orderDefault));

        if (count($listFamilyParts) > count($order)) {
            $this->addFamilyParts($listFamilyParts, $order);
        }
        
        $shownParts = [];
        foreach ($order as $efp) {
            $efpObj = (object)[];
            $efpObj->name       = ExtendedFamilySupport::translateFamilyPart($efp);
            $efpObj->generation = ExtendedFamilySupport::formatGeneration($efp);
            $efpObj->enabled    = $this->getPreference('status-' . $efp, 'on');
            $shownParts[$efp]   = $efpObj;
        }
        return $shownParts;
    }

    /**
     * add parts of extended family, which are newly defined
     * It is not yet possible to delete family parts, only add new ones. See issue #215.
     *
     * @param array<int,string> $listFamilyParts list of extended family parts defined by this module
     * @param array<int,string> $order list of ordered family parts out of parameters
     */
    private function addFamilyParts(array $listFamilyParts, array &$order)
    {

        foreach ($listFamilyParts as $familyPartPosition => $familyPart) {
            if (in_array($familyPart, $order, true)) {
                continue;
            }

            $inserted = false;
            for ($previousPartPosition = $familyPartPosition - 1; $previousPartPosition >= 0; $previousPartPosition--) {
                $previousFamilyPart = $listFamilyParts[$previousPartPosition];
                $orderPosition      = array_search($previousFamilyPart, $order, true);

                if ($orderPosition !== false) {
                    array_splice($order, $orderPosition + 1, 0, [$familyPart]);
                    $inserted = true;
                    break;
                }
            }

            if (!$inserted) {
                $order[] = $familyPart;
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
     * @return bool
     */
    private function showSummary(): bool
    {
        return ($this->getPreference('show_summary', '0') == '0');
    }

    /**
     * should statistical details be shown in the summary block
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showSummaryStatistics(): bool
    {
        return ($this->getPreference('show_summary_statistics', '0') == '0');
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
     * how should empty parts of the extended family be presented
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function countPartnerChainsToTotal(): bool
    {
        return ($this->getPreference('count_partner_chains', '0') == '0');
    }

    /**
     * should the print/PDF button be shown in the tab
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showPrintButton(): bool
    {
        return ($this->getPreference('show_print_button', '0') == '0');
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
     * should SOSA numbers be shown for the proband and biological ancestors
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showSosaNumbers(): bool
    {
        return ($this->getPreference('show_sosa_numbers', '1') == '0');
    }

    /**
     * should a person's relationship to the proband be shown as mouse-over text
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function showRelationshipToProband(): bool
    {
        return ($this->getPreference('show_relationship_to_proband', '0') == '0');
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
     * selected format for place names in event boxes
     * set default values in case the settings are not stored in the database yet
     *
     * @return int
     */
    private function placeFormat(): int
    {
        return (int) $this->getPreference('place_format', (string) PlaceAbbreviation::OPTION_FULL_PLACE_NAME);
    }

    /**
     * get preference in this tree to show thumbnails
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
     * use the function to add individuals and families to the clippings cart
     * set default values in case the settings are not stored in the database yet
     *
     * @return bool
     */
    private function useClippingsCart(): bool
    {
        return ($this->getPreference('use_clippings_cart', '0') == '0');
    }

    /**
     * Which clippings-cart action should be used when huhwt-cce is available?
     *
     * @return string
     */
    private function clippingsCartAction(): string
    {
        $action = $this->getPreference('clippings_cart_action', self::CLIPPINGS_CART_ACTION_CCE);

        if ($action === self::CLIPPINGS_CART_ACTION_INTERNAL) {
            return self::CLIPPINGS_CART_ACTION_INTERNAL;
        }

        return self::CLIPPINGS_CART_ACTION_CCE;
    }

    /**
     * Should the tab content be loaded only when the user opens the tab?
     *
     * @return bool
     */
    private function loadTabOnClick(): bool
    {
        return ($this->getPreference('load_tab_on_click', '0') == '0');
    }

    /**
     * Is the enhanced clippings cart module installed and enabled?
     *
     * @return bool
     */
    private function isClippingsCartEnhancedAvailable(): bool
    {
        return $this->customModuleAvailable(self::CLIPPINGS_CART_ENHANCED_MODULE, ClippingsCartEnhancedModule::class);
    }

    /**
     * Is the Vesta relationship-name capability available?
     *
     * @return bool
     */
    private function relationshipNamesAvailable(): bool
    {
        return $this->customModuleAvailable(null, self::VESTA_UTILS_CLASS)
            && ExtendedFamilySupport::relationshipNamesAvailable();
    }

    /**
     * Check whether an optional custom-module dependency is available.
     *
     * @param string|null $module_name
     * @param class-string|null $required_class
     * @param Individual|null $individual
     * @param class-string|null $access_interface
     * @return bool
     */
    private function customModuleAvailable(?string $module_name, ?string $required_class = null, ?Individual $individual = null, ?string $access_interface = null): bool
    {
        try {
            $module = $module_name === null ? null : (new ModuleService())->findByName($module_name);

            if ($module_name !== null && $module === null) {
                return false;
            }

            if ($required_class !== null && !class_exists($required_class, true)) {
                return false;
            }

            if ($individual !== null && $access_interface !== null && $module !== null) {
                return $module->accessLevel($individual->tree(), $access_interface) >= Auth::accessLevel($individual->tree(), Auth::user());
            }

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Warning shown when the CCE-dependent clippings-cart option cannot work.
     *
     * @return string
     */
    private function clippingsCartEnhancedFallbackMessage(): string
    {
        return I18N::translate('The custom module “huhwt-cce” is not available. The button “Copy to clippings cart” will use the internal Extended Family action.');
    }

    /**
     * Warning shown when Vesta relationship names cannot be used.
     *
     * @return string
     */
    private function relationshipNamesUnavailableMessage(): string
    {
        return I18N::translate('Vesta relationship names are not available. Mouse-over text for relationships to the proband will not be shown.');
    }

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return /* I18N: Name of a module/tab on the individual page. */ I18N::translate('Extended family');
    }

    /**
     * {@inheritDoc}
     *
     * @see AbstractModule::description
     */
    public function description(): string
    {
        return /* I18N: Description of this module */ I18N::translate('A tab showing the extended family of an individual.');
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
        return __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;
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
     *
     * @throws \JsonException
     */
    public function getCssAction() : ResponseInterface
    {
        return response(
            file_get_contents($this->resourcesFolder() . 'css' . DIRECTORY_SEPARATOR . self::CUSTOM_MODULE . '.css'),
            200,
            ['content-type' => 'text/css']
        );
    }

    /** {@inheritdoc} */
    public function getTabContent(Individual $individual): string
    {
        // use helper function to check if huhwt-cce is accessible in the current user context
        $cce_ok                = $this->canAccessClippingsCartEnhanced($individual);
        $clippings_cart_action = $this->clippingsCartAction();

        if ($clippings_cart_action === self::CLIPPINGS_CART_ACTION_CCE && !$cce_ok) {
            $clippings_cart_action = self::CLIPPINGS_CART_ACTION_INTERNAL;
        }

        if ($clippings_cart_action === self::CLIPPINGS_CART_ACTION_CCE) {
            $this->rememberExtendedFamilyRoute($individual);
        }

        return view($this->name() . '::' . 'tab',
            [
            'module'                => $this->name(),
            'individual'            => $individual,
            'extfam_obj'            => $this->getExtendedFamily($individual),
            'extended_family_css'   => route('module', ['module' => $this->name(), 'action' => 'Css']),
            'clippings_cart_action' => $clippings_cart_action,
            ]);
        }

    /**
     * Render a print-optimized view of the selected extended-family filter.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getPrintAction(ServerRequestInterface $request): ResponseInterface
    {
        $tree = Validator::attributes($request)->tree();
        $user = Validator::attributes($request)->user();
        $xref = Validator::queryParams($request)->isXref()->string('xref');

        $individual = Registry::individualFactory()->make($xref, $tree);
        $individual = Auth::checkIndividualAccess($individual);

        if ($this->accessLevel($tree, ModuleTabInterface::class) < Auth::accessLevel($tree, $user)) {
            throw new HttpAccessDeniedException();
        }

        $extfam_obj   = $this->getExtendedFamily($individual);
        $filterOption = Validator::queryParams($request)->string('filter', 'all');

        if (!isset($extfam_obj->filters[$filterOption])) {
            $filterOption = 'all';
        }

        // The print/PDF view should not include stale messages from unrelated modules.
        FlashMessages::getMessages();

        return $this->viewResponse($this->name() . '::print', [
            'extended_family_css' => route('module', ['module' => $this->name(), 'action' => 'Css']),
            'extfam_obj'          => $extfam_obj,
            'filterObj'           => $extfam_obj->filters[$filterOption],
            'filterOption'        => $filterOption,
            'individual'          => $individual,
            'module'              => $this->name(),
            'title'               => I18N::translate('Extended family') . ': ' . $individual->fullName(),
            'tree'                => $tree,
        ]);
    }

    /**
     * Copy the currently selected extended-family filter to the standard webtrees clippings cart.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function postClippingsCartAction(ServerRequestInterface $request): ResponseInterface
    {
        $return_url = Validator::parsedBody($request)->isLocalUrl()->string('return_url', '');
        $tree_name  = Validator::parsedBody($request)->string('tree', '');
        $xref       = Validator::parsedBody($request)->isXref()->string('xref', '');
        $filter     = Validator::parsedBody($request)->string('filter', 'all');

        $tree_service = self::getFromContainer(TreeService::class);
        $tree         = $tree_service->all()->get($tree_name);

        if ($tree === null) {
            FlashMessages::addMessage(I18N::translate('The selected tree could not be found.'), 'danger');
            return redirect($return_url === '' ? '/' : $return_url);
        }

        $individual = Registry::individualFactory()->make($xref, $tree);

        if (!$individual instanceof Individual) {
            FlashMessages::addMessage(I18N::translate('The selected individual could not be found.'), 'danger');
            return redirect($return_url === '' ? '/' : $return_url);
        }

        if ($return_url === '') {
            $return_url = $individual->url() . '#tab-' . $this->name();
        }

        $extended_family = $this->getExtendedFamily($individual);

        if (!isset($extended_family->filters[$filter])) {
            $filter = 'all';
        }

        $filter_object = $extended_family->filters[$filter];
        $old_count     = $this->countClippingsCartEntries($tree_name);

        $extended_family->addExtendedFamilyToClippingsCart(
            $extended_family->collectAllIndividuals($filter_object),
            $extended_family->collectAllFamilies($filter_object)
        );

        $new_entries = max(0, $this->countClippingsCartEntries($tree_name) - $old_count);

        FlashMessages::addMessage(
            $this->title() . ': ' . I18N::translate('The extended family has been copied to the clippings cart. New entries: %s', (string) $new_entries),
            'success'
        );

        return redirect($return_url);
    }

    /**
     * Count the current clippings-cart entries for a tree.
     *
     * @param string $tree_name
     * @return int
     */
    private function countClippingsCartEntries(string $tree_name): int
    {
        $cart = Session::get('cart');

        if (!is_array($cart) || !isset($cart[$tree_name]) || !is_array($cart[$tree_name])) {
            return 0;
        }

        return count($cart[$tree_name]);
    }

    /**
     * Remember the current individual route so huhwt-cce can redirect back to this tab.
     *
     * @param Individual $individual
     * @return void
     */
    private function rememberExtendedFamilyRoute(Individual $individual): void
    {
        $url   = $individual->url();
        $query = parse_url($url, PHP_URL_QUERY);

        if (is_string($query)) {
            parse_str($query, $query_params);

            if (is_string($query_params['route'] ?? null)) {
                Session::put('hhEF-act-route', $query_params['route']);
                return;
            }
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (!is_string($path) || $path === '') {
            return;
        }

        try {
            $request   = self::getFromContainer(ServerRequestInterface::class);
            $base_url  = (string) $request->getAttribute('base_url', '');
            $base_path = parse_url($base_url, PHP_URL_PATH);

            if (is_string($base_path) && $base_path !== '' && str_starts_with($path, $base_path)) {
                $path = substr($path, strlen($base_path));
            }
        } catch (\Throwable) {
            // Use the route path as generated if the current request cannot be read.
        }

        Session::put('hhEF-act-route', $path);
    }

    /**
     * check if custom module _huhwt-cce_ is installed and accessible in the current user context.
     *
     * @param Individual $individual
     * @return bool
     */
    private function canAccessClippingsCartEnhanced(Individual $individual): bool
    {
        return $this->customModuleAvailable(self::CLIPPINGS_CART_ENHANCED_MODULE, ClippingsCartEnhancedModule::class, $individual, ModuleMenuInterface::class);
    }

    /** {@inheritdoc} */
    public function canLoadAjax(): bool
    {
        return $this->loadTabOnClick();
    }

    /**
     * Get a service from the webtrees container in webtrees 2.1 and 2.2.
     *
     * @param string $id
     * @return mixed
     */
    private static function getFromContainer(string $id)
    {
        if (version_compare(Webtrees::VERSION, '2.2.0', '>=')) {
            return Registry::container()->get($id);
        }

        return app($id);
    }

    /**
     * bootstrap
     *
     * Here is also a good place to register any views (templates) used by the module.
     * This command allows the module to use: view($this->name() . '::', 'fish')
     * to access the file ./resources/views/fish.phtml
     */
    public function boot(): void
    {
        View::registerNamespace($this->name(), strtr($this->resourcesFolder() . 'views' . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, '/'));
    }
    
    /**
     * additional translations
     *
     * @param string $language
     *
     * @return array<string, string>
     */
    public function customTranslations(string $language): array
    {
        $languageFile = match ($language) {
            'ca', 'ca-ES' => 'ca',
            'cs'          => 'cs',
            'de'          => 'de',
            'es'          => 'es',
            'fr', 'fr-CA' => 'fr',
            'hi'          => 'hi',
            'nb'          => 'nb',
            'nl'          => 'nl',
            'ru'          => 'ru',
            'sk'          => 'sk',
            'sv'          => 'sv',
            'uk'          => 'uk',
            'vi'          => 'vi',
            'zh-Hans'     => 'zh-Hans',
            'zh-Hant'     => 'zh-Hant',
            default       => '',
        };

        if ($languageFile === '') {
            return [];
        }

        $poFile = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $languageFile . '.po';
        $moFile = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $languageFile . '.mo';

        if (is_file($poFile)) {
            return (new Translation($poFile))->asArray();
        }

        if (is_file($moFile)) {
            return (new Translation($moFile))->asArray();
        }

        return [];
    }
}
return new ExtendedFamilyTabModule;
