<?php

namespace App\Support\helpers;

class RouteDisplay
{
    public static function make(?string $routeName): string
    {
        if (!$routeName) {
            return '-';
        }

        $config = config('route_display');

        // اگر override داشت، همون رو برگردون
        if (isset($config['overrides'][$routeName])) {
            return __( $config['overrides'][$routeName] );
        }

        $parts = explode('.', $routeName);

        // آخرین segment
        $last = end($parts);

        if (isset($config['actions'][$last])) {
            return __( $config['actions'][$last] );
        }

        if (isset($config['prefixes'][$last])) {
            return __( $config['prefixes'][$last] );
        }

        return self::humanize($last);
    }

    protected static function humanize(string $value): string
    {
        return ucfirst(str_replace('_', ' ', $value));
    }
}
