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
