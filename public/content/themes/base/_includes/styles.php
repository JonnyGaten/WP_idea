<?php
//COMMENT: This will enqueue all styles for the site. They should NOT be added to the header.

function rb_styles__enqueue_style() {
	// wp_enqueue_style('css-mmenu', 'https://cdnjs.cloudflare.com/ajax/libs/jQuery.mmenu/8.5.19/mmenu.min.css', array());
	wp_enqueue_style('css-main', get_template_directory_uri() . '/_dist/css/main.css', array(), time());
	// wp_enqueue_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), time());
}

add_action( 'wp_enqueue_scripts', 'rb_styles__enqueue_style' );
