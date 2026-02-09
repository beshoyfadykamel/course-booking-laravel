<?php

if (!function_exists('highlight')) {
    function highlight($text, $term, $className = 'bg-warning text-dark')
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
