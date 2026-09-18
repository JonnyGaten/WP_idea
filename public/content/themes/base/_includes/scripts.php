<?php
// Enqueues all front-end scripts. Do not add scripts to the footer manually, register them here.

function rb_scripts__enqueue_script()
{
    $main_js = RB_THEME_DIR . '/_dist/js/main.min.js';
    $version = file_exists($main_js) ? filemtime($main_js) : wp_get_theme()->get('Version');

    wp_enqueue_script('main-script', RB_THEME_URI . '/_dist/js/main.min.js', array('jquery'), $version, true);

    /**
     * REGISTER, LOAD ELSEWHERE (I.E. IN MODULES)
     */
    // wp_register_script('isotopeLib', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array());
    // wp_register_script('isotopeControl', RB_THEME_URI . '/_dist/js/libs/isotope-controller.min.js', array());

    /**
     * CONDITIONALLY LOAD SCRIPTS
     */
    $ajax = get_field('ajax_filter', 'options');
    if ($ajax && !empty($ajax['library'])) {
        require_once RB_THEME_DIR . '/_includes/theme-options/ajax-loadmore/scripts.php';
    }
}

add_action('wp_enqueue_scripts', 'rb_scripts__enqueue_script');
