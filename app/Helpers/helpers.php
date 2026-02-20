<?php

if (!function_exists('highlight')) {
    function highlight($text, $term, $className = 'bg-yellow-200 text-gray-900 px-0.5 rounded')
    {
        $text = (string) $text;
        $term = trim((string) ($term ?? ''));

        if ($term === '') {
            return e($text);
        }

        // limit term length to avoid abuse
        $term = mb_substr($term, 0, 80);

        // split into words (supports Arabic/English spaces)
        $parts = preg_split('/\s+/u', $term, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($parts)) {
            return e($text);
        }

        // Escape original text once
        $escaped = e($text);

        // Build OR regex from tokens
        $escapedParts = array_map(fn($p) => preg_quote($p, '/'), $parts);
        $pattern = '/(' . implode('|', $escapedParts) . ')/iu';

        return preg_replace($pattern, '<span class="' . $className . '">$1</span>', $escaped);
    }
}

if (!function_exists('roleRoute')) {
    /**
     * Generate a URL for a named route, automatically prefixing with 'admin.'
     * when the authenticated user has an admin role.
     */
    function roleRoute($name, $params = [], $absolute = true)
    {
        $prefix = auth()->check() && auth()->user()->role === 'admin' ? 'admin.' : '';
        return route($prefix . $name, $params, $absolute);
    }
}

if (!function_exists('roleRouteIs')) {
    /**
     * Check if the current route matches the given name for both user and admin prefixes.
     */
    function roleRouteIs($name)
    {
        return request()->routeIs($name, 'admin.' . $name);
    }
}
