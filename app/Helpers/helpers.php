<?php

if (! function_exists('highlight')) {
    /**
     * Highlight a given query in a text.
     *
     * @param  string|null  $text
     * @param  string|null  $query
     * @return string
     */
    function highlight($text, $query)
    {
        if (!$query || !is_string($text)) {
            return $text;
        }

        $escapedQuery = preg_quote($query, '/');
        return preg_replace("/($escapedQuery)/i", '<mark>$1</mark>', $text);
    }
}