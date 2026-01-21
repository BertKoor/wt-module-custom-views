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

class CustomViewsModule extends AbstractModule implements ModuleCustomInterface
{
    use ModuleCustomTrait;

    const GITHUB_USER = 'bertkoor';
    const GITHUB_REPO = 'wt-module-custom-views';
    const THIS_VERSION = '1.0.0';

    public function __construct() { }

    public function title(): string
    {
        return 'Custom views';
    }

    public function description(): string
    {
        return 'Keep your customizations of .phtml files in a different directory, so upgrades do not overwrite them.';
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

}
