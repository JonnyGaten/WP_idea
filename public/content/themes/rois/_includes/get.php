<?php

/**
 * GET functions
 * Used... for getting things
 * Basically, anything that returns data
 */


/**
 * Calculate the estimated reading time for a given piece of $content.
 *
 * @param string $content
 * @param integer $wpm
 * @return int ($time)
 */
function rb_get__time_to_read($content = '', $wpm = 200)
{
    $clean_content = strip_shortcodes($content);
    $clean_content = strip_tags($clean_content);
    $word_count = str_word_count($clean_content);
    $time = ceil($word_count / $wpm);
    $append = 'mins';
    $prepend = '';

    if ($time == 1) :
        $append = 'min';
        $prepend = 'Less than';
    endif;

    return $prepend . ' ' . $time . ' ' . $append;
}
