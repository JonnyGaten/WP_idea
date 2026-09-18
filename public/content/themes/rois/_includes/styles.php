<?php
// Enqueues all front-end styles. Do not add styles to the header manually, register them here.

function rb_styles__enqueue_style() {
	wp_enqueue_style('google-font-sora', 'https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap', array());

	$main_css = RB_THEME_DIR . '/_dist/css/main.css';
	$version = file_exists($main_css) ? filemtime($main_css) : wp_get_theme()->get('Version');
	wp_enqueue_style('css-main', RB_THEME_URI . '/_dist/css/main.css', array('google-font-sora'), $version);
}

add_action( 'wp_enqueue_scripts', 'rb_styles__enqueue_style' );
