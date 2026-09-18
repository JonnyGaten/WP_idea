<?php
// Add Menu's To Theme
add_theme_support('menus');
add_theme_support('title-tag');

function rb_menus__register_theme_menus()
{

	// Specify Menus
	register_nav_menus(
		array(
			'primary-menu' => __('Main Navigation'),
			'secondary-menu' => __('Secondary Navigation'),
			'footer-menu' => __('Footer Menu'),
		)
	);
}

// Add menu's to theme
add_action('init', 'rb_menus__register_theme_menus');

add_theme_support('post-thumbnails');

/**
 * Renders the 'footer-menu' as columns: each top-level item is a column
 * heading, its children are the links inside that column.
 */
class RB_Footer_Menu_Walker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<div class="footer-col__links">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</div>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if ($depth === 0) {
            $output .= '<div class="footer-col"><h4>' . esc_html($item->title) . '</h4>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</div>';
        }
    }
}
