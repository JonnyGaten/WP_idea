<?php

/**
 * Renders a button/link from an ACF 'link' field array (url, title, target).
 *
 * @param array|null $link  ACF link field value, e.g. get_sub_field('cta')
 * @param string     $colour  Modifier class suffix, e.g. 'primary', 'black'
 * @param string     $size    Modifier class suffix, e.g. 'md', 'lg'
 * @return string
 */
function rb_render__btn($link, $colour = 'primary', $size = '')
{
    if (empty($link['url'])) {
        return '';
    }

    $url = esc_url($link['url']);
    $text = esc_html($link['title']);
    $target = !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '" rel="noopener"' : '';

    $class = 'btn btn--' . esc_attr($colour);
    if ($size) {
        $class .= ' btn--' . esc_attr($size);
    }

    return sprintf('<a href="%s" class="%s"%s>%s</a>', $url, $class, $target, $text);
}
