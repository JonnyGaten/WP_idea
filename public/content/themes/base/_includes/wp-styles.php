<?php

    // Styling the visual editor with editor-style.css to match the theme style.
        add_editor_style('_dist/css/main.css');

    // Add Typekit to Wordpress Admin
        // add_filter("mce_external_plugins", "rb_wpstyles__mce_external_plugins");
        function rb_wpstyles__mce_external_plugins($plugin_array){
            $plugin_array['typekit']  =  get_stylesheet_directory_uri().'/includes/typekit.tinymce.js';
            return $plugin_array;
        }

    // Custom Login Styles
        function rb_wpstyles__custom_login() {
            echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/_dist/css/client.css" />';
        }
        add_action('login_head', 'rb_wpstyles__custom_login');

    // Change link to wordpress from logo on login page
        function rb_wpstyles__loginpage_custom_link() {
            return '/';
        }
        add_filter('login_headerurl','rb_wpstyles__loginpage_custom_link');

        // Change tooltip on the logo on the login page
        function rb_wpstyles__change_title_on_logo() {
            return 'View Website';
        }
        add_filter('login_headertitle', 'rb_wpstyles__change_title_on_logo');

    // Custom Styles for Wordpress Edtior

        function rb_wpstyles__wpb_mce_buttons_2($buttons) {
            array_unshift($buttons, 'styleselect');
            return $buttons;
        }

        // add_filter('mce_buttons_2', 'rb_wpstyles__wpb_mce_buttons_2');

        function rb_wpstyles__mce_before_init_insert_formats( $init_array ) {

        // Define the style_formats array

            $style_formats = array (

                array (
                    'title' => 'Colour One',
                    'block' => 'span',
                    'classes' => 'color--alpha',
                    'wrapper' => true,
                )

            );
            // Insert the array, JSON ENCODED, into 'style_formats'
            $init_array['style_formats'] = json_encode( $style_formats );

            return $init_array;

        }

        // Attach callback to 'tiny_mce_before_init'
        // add_filter( 'tiny_mce_before_init', 'rb_wpstyles__mce_before_init_insert_formats' );