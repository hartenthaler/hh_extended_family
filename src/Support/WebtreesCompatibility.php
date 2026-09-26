<?php

declare(strict_types=1);

namespace Hartenthaler\Webtrees\Module\ExtendedFamily\Support;

use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\Registry;

/**
 * Small compatibility helpers for webtrees 2.2 and 2.3.
 *
 * webtrees 2.3 replaces the historic integer privacy values with the
 * AccessLevel enum. Keeping that version check here avoids scattering API
 * checks throughout the module.
 */
final class WebtreesCompatibility
{
    /**
     * The access-level value used to include hidden facts in a query.
     *
     * @return mixed int for webtrees 2.2, AccessLevel for webtrees 2.3
     */
    public static function hiddenAccessLevel(): mixed
    {
        $accessLevelClass = 'Fisharebest\\Webtrees\\Enums\\AccessLevel';

        if (class_exists($accessLevelClass)) {
            return constant($accessLevelClass . '::Hidden');
        }

        return Auth::PRIV_HIDE;
    }

    /**
     * Convert either the historic integer or the 2.3 backed enum to an int.
     */
    public static function accessLevelValue(mixed $accessLevel): int
    {
        if (is_object($accessLevel) && isset($accessLevel->value)) {
            return (int) $accessLevel->value;
        }

        return (int) $accessLevel;
    }

    /**
     * Get today's Julian day on both TimestampFactory APIs.
     */
    public static function todayJulianDay(): int
    {
        $timestampFactory = Registry::timestampFactory();

        if (method_exists($timestampFactory, 'todayJulianDay')) {
            return $timestampFactory->todayJulianDay();
        }

        return $timestampFactory->now()->julianDay();
    }
}
