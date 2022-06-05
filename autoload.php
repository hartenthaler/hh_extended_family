<?php

namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Composer\Autoload\ClassLoader;

$loader = new ClassLoader();
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__);
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src');
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src/Factory');
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src/Factory/Objects');
$loader->addPsr4('Hartenthaler\\Webtrees\\Module\\ExtendedFamily\\', __DIR__ . '/src/Factory/ExtendedFamilyParts');
$loader->register();
