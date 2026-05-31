<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily\Internationalization;

use Fisharebest\Webtrees\I18N;

/**
 * Reuse webtrees core translations without adding these strings to the module catalog.
 */
class MoreI18N
{
    public static function xlate(string $message, ...$args): string
    {
        return I18N::translate($message, ...$args);
    }

    public static function xlateContext(string $context, string $message, ...$args): string
    {
        return I18N::translateContext($context, $message, ...$args);
    }

    public static function plural(string $singular, string $plural, int $count, ...$args): string
    {
        return I18N::plural($singular, $plural, $count, ...$args);
    }

    public static function number(float $number, int $precision = 0): string
    {
        return I18N::number($number, $precision);
    }
}
