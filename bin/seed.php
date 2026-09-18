<?php
/**
 * Seeds a demo homepage using the page-builder flexible content field, so the
 * theme has something to render out of the box. Run via:
 *   ddev wp eval-file bin/seed.php
 * Safe to re-run — updates the same page instead of duplicating it.
 */

if (!function_exists('update_field')) {
    WP_CLI::warning('ACF is not active — skipping content seed.');
    return;
}

$title = 'Home';
$existing = get_page_by_title($title, OBJECT, 'page');

$post_id = $existing
    ? $existing->ID
    : wp_insert_post(array(
        'post_title'  => $title,
        'post_type'   => 'page',
        'post_status' => 'publish',
    ));

if (is_wp_error($post_id)) {
    WP_CLI::error($post_id->get_error_message());
}

update_field('page-builder', array(
    array(
        'acf_fc_layout' => 'text_and_image',
        'wysiwyg'       => '<h1>Welcome to the ramarketing base theme</h1><p>This page was seeded by bin/seed.php to prove the page-builder flexible content field renders end to end.</p>',
        'cta'           => array('title' => 'Learn more', 'url' => '#', 'target' => ''),
        'layout'        => 'img-left',
        'image'         => '',
    ),
    array(
        'acf_fc_layout' => 'spacer',
        'spacer'        => 2,
    ),
    array(
        'acf_fc_layout' => 'quote',
        'text'          => 'Design → component → code + ACF fields.',
    ),
    array(
        'acf_fc_layout' => 'cta',
        'cta'           => array('title' => 'Get in touch', 'url' => '#contact', 'target' => ''),
        'size'          => 'md',
    ),
), $post_id);

update_option('show_on_front', 'page');
update_option('page_on_front', $post_id);

// Primary nav menu with a Home link, if one doesn't already exist.
$menu_name = 'Primary';
$menu = wp_get_nav_menu_object($menu_name);
if (!$menu) {
    $menu_id = wp_create_nav_menu($menu_name);
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title'     => 'Home',
        'menu-item-object'    => 'page',
        'menu-item-object-id' => $post_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
    ));
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary-menu'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

WP_CLI::success("Seeded homepage (post #{$post_id}) and set it as the static front page.");
