<?php

/**
 * Copyright (C) 2025-2026 BertKoor.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details:
 * <https://www.gnu.org/licenses/>
 */

namespace BertKoor\WtModule\CustomViews;

use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\View;

use function fopen;
use function fclose;
use function fgetcsv;
use function is_dir;
use function is_readable;
use function scandir;
use function str_ends_with;
use function str_replace;
use function str_starts_with;

class CustomViewsModule extends AbstractModule implements ModuleCustomInterface
{
    use ModuleCustomTrait;

    const GITHUB_USER = 'bertkoor';
    const GITHUB_REPO = 'wt-module-custom-views';
    const THIS_VERSION = '1.0.0';

    public function __construct() { }

    public function title(): string
    {
        return 'Custom views (and translations)';
    }

    public function description(): string
    {
        return 'Keep your customizations of .phtml files in a different directory, so upgrades do not overwrite them. ' .
            'It also supports customization of translations via .csv files.';
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return self::GITHUB_USER;
    }

    /**
     * The version of this module.
     *
     * @return string
     */
    public function customModuleVersion(): string
    {
        return self::THIS_VERSION;
    }

    /**
     * A URL that will provide the latest stable version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return 'https://raw.githubusercontent.com/' . self::GITHUB_USER . '/' . self::GITHUB_REPO . '/main/latest-version.txt';
    }

    /**
     * Where to get support for this module.  Perhaps a github repository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return 'https://github.com/' . self::GITHUB_USER . '/' . self::GITHUB_REPO;
    }

    public function resourcesFolder(): string {
        return __DIR__ . '/resources/';
    }

    public function boot(): void
    {
        $viewsFolder = $this->resourcesFolder() . 'views/';
        View::registerNamespace($this->name(), $viewsFolder);
        $this->scan($viewsFolder);
    }

    private function scan(string $root, string $path = ''): void
    {
        if (is_readable($root . $path)) {
            foreach (scandir($root . $path) as $item) {
                if (is_dir($root . $path . $item) && !str_starts_with($item, '.')) {
                    $this->scan($root, $path . $item . '/');
                } else if (str_ends_with($item, '.phtml') && is_readable($root . $path . $item)) {
                    $viewName = str_replace('.phtml', '', $path . $item);
                    $this->register($viewName);
                }
            }
        }
    }

    private function register(string $viewName): void {
        View::registerCustomView(View::NAMESPACE_SEPARATOR . $viewName, $this->name() . View::NAMESPACE_SEPARATOR . $viewName);
    }

    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return array<string>
     */
    public function customTranslations(string $language): array
    {
        $translations = [];
        $langFile = $this->resourcesFolder() . 'lang/' . $language . '.csv';
        if (is_readable($langFile)) {
            $fp = fopen($langFile, 'rb');
            if ($fp !== false) {
                while (($data = fgetcsv($fp, 0, ';', '"', '\\')) !== false) {
                    $translations[$data[0]] = $data[1];
                }
                fclose($fp);
            }

        }
        return $translations;
    }

}
