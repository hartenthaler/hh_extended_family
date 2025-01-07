<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Composer\Autoload\ClassLoader;

// autoload this webtrees custom module
$loader = new ClassLoader();

$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__);
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src');
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src/Factory');
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src/Factory/Objects');
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src/Factory/ExtendedFamilyParts');

// my helper functions for webtrees custom modules
$loader->addPsr4('Hartenthaler\\Webtrees\\Helpers\\', __DIR__ . "/vendor/hartenthaler/Webtrees/Helpers");

$loader->register();

return true;