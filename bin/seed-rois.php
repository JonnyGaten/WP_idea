<?php
/**
 * Seeds the ROIS design-demo build: activates the theme, imports its ACF
 * JSON, creates demo articles + menus, and builds the homepage through the
 * page-builder field so it matches the design end to end. Run via:
 *   ddev wp eval-file bin/seed-rois.php
 * Safe to re-run — updates existing content instead of duplicating it.
 */

switch_theme('rois');
WP_CLI::log('Activated theme: rois');

if (function_exists('acf_import_field_group')) {
    // rois is now the active theme, so this picks up rois/acf-json and
    // handles dedup + local-json cleanup the same way `bin/setup.sh` does.
    require __DIR__ . '/sync-acf.php';
    WP_CLI::log('Synced rois ACF field groups.');
} else {
    WP_CLI::warning('ACF is not active — field groups not synced, page-builder content below will not save correctly.');
}

// ---------- demo articles for the News module ----------
$articles = array(
    array('title' => 'ROIS: the CDMO making waves in the US market', 'tag' => 'Articles'),
    array('title' => 'ROIS CDMO closes on the acquisition of a US injectable manufacturing facility', 'tag' => 'News'),
    array('title' => 'Water for injection: why WFI is now a strategic manufacturing decision', 'tag' => 'Articles'),
);
$article_ids = array();
foreach ($articles as $a) {
    $existing = get_page_by_title($a['title'], OBJECT, 'cpt-articles');
    $post_id = $existing ? $existing->ID : wp_insert_post(array(
        'post_title'  => $a['title'],
        'post_type'   => 'cpt-articles',
        'post_status' => 'publish',
    ));
    if (!is_wp_error($post_id)) {
        wp_set_object_terms($post_id, $a['tag'], 'tax-content-type');
        $article_ids[] = $post_id;
    }
}
WP_CLI::log('Seeded ' . count($article_ids) . ' demo articles.');

// ---------- primary nav menu (anchor links, this is a one-pager) ----------
$primary_links = array(
    'Capabilities'      => '#process',
    'About'              => '#about',
    'Locations'          => '#locations',
    'News and resources' => '#news',
    'Events'             => '#',
);
$primary_menu = wp_get_nav_menu_object('Primary');
$primary_menu_id = $primary_menu ? $primary_menu->term_id : wp_create_nav_menu('Primary');
foreach (wp_get_nav_menu_items($primary_menu_id) ?: array() as $item) {
    wp_delete_post($item->ID, true);
}
foreach ($primary_links as $title => $url) {
    wp_update_nav_menu_item($primary_menu_id, 0, array(
        'menu-item-title'  => $title,
        'menu-item-url'    => home_url('/') . $url,
        'menu-item-status' => 'publish',
        'menu-item-type'   => 'custom',
    ));
}
$locations = get_theme_mod('nav_menu_locations') ?: array();
$locations['primary-menu'] = $primary_menu_id;
set_theme_mod('nav_menu_locations', $locations);

// ---------- footer nav menu (nested: parent = column heading) ----------
$footer_columns = array(
    'Capabilities' => array('Sterile fill-finish', 'Oral solids', 'Drug substance'),
    'Company'      => array('About ROIS', 'Leadership and people', 'Locations', 'ESG', 'Quality and compliance'),
    'More'         => array('News and resources', 'Events', 'Contact us'),
);
$footer_menu = wp_get_nav_menu_object('Footer');
$footer_menu_id = $footer_menu ? $footer_menu->term_id : wp_create_nav_menu('Footer');
foreach (wp_get_nav_menu_items($footer_menu_id) ?: array() as $item) {
    wp_delete_post($item->ID, true);
}
foreach ($footer_columns as $heading => $links) {
    $parent_id = wp_update_nav_menu_item($footer_menu_id, 0, array(
        'menu-item-title'  => $heading,
        'menu-item-url'    => '#',
        'menu-item-status' => 'publish',
        'menu-item-type'   => 'custom',
    ));
    foreach ($links as $link) {
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title'     => $link,
            'menu-item-url'       => '#',
            'menu-item-status'    => 'publish',
            'menu-item-type'      => 'custom',
            'menu-item-parent-id' => $parent_id,
        ));
    }
}
$locations['footer-menu'] = $footer_menu_id;
set_theme_mod('nav_menu_locations', $locations);
WP_CLI::log('Seeded primary + footer menus.');

// ---------- footer tagline (General options) ----------
if (function_exists('update_field')) {
    update_field('global--footer-tagline', 'Expertise in every dose.', 'options');
}

// ---------- homepage, built through the page-builder field ----------
if (!function_exists('update_field')) {
    WP_CLI::warning('ACF is not active — cannot write page-builder content, stopping here.');
    return;
}

$title = 'Home';
$existing = get_page_by_title($title, OBJECT, 'page');
$post_id = $existing ? $existing->ID : wp_insert_post(array(
    'post_title'  => $title,
    'post_type'   => 'page',
    'post_status' => 'publish',
));
if (is_wp_error($post_id)) {
    WP_CLI::error($post_id->get_error_message());
}

update_field('page-builder', array(
    array(
        'acf_fc_layout'   => 'hero_intro',
        'heading'         => 'Every dose, done',
        'heading_emphasis' => 'right.',
        'body'            => "Global capacity, proven expertise and personalized partnerships. ROIS works alongside science leaders to bring complex injectable medicines to patients worldwide.",
        'cta_primary'     => array('title' => 'Get in touch', 'url' => '#final-cta', 'target' => ''),
        'cta_secondary'   => array('title' => 'See our capabilities', 'url' => '#process', 'target' => ''),
    ),
    array(
        'acf_fc_layout' => 'stat_interrupt',
        'number'        => 800,
        'suffix'        => 'm',
        'caption'       => 'prefilled syringes, cartridges and vials manufactured every year',
    ),
    array(
        'acf_fc_layout' => 'process_steps',
        'anchor'        => 'process',
        'heading'       => 'One line, four capabilities.',
        'intro'         => 'ROIS connects an integrated manufacturing network through one accountable partnership, from format selection through to warehousing and shipment.',
        'steps'         => array(
            array('title' => 'Formats', 'description' => 'Prefilled syringes, cartridges and vials, matched to the tolerances complex injectables demand.'),
            array('title' => 'Manufacturing technologies', 'description' => 'Sterile fill-finish through to cytotoxic filling and lyophilization.'),
            array('title' => 'Packaging and integrated services', 'description' => 'Analytical studies, device assembly, warehousing and logistics.'),
            array('title' => 'Modalities', 'description' => 'Biologics, biosimilars, vaccines, ADCs, mRNA and LNP, peptides and GLP-1s.'),
        ),
    ),
    array(
        'acf_fc_layout' => 'locations_map',
        'anchor'        => 'locations',
        'heading'       => 'Five sites. Seventy-five markets. One network.',
        'intro'         => 'Global capacity with local expertise, across manufacturing sites in the US and Spain, supplying complex injectable medicines worldwide.',
        'locations'     => array(
            array('city' => 'Phoenix', 'country' => 'USA'),
            array('city' => 'Madrid', 'country' => 'Spain'),
            array('city' => 'San Sebastián de los Reyes', 'country' => 'Spain'),
            array('city' => 'Alcalá de Henares', 'country' => 'Spain'),
            array('city' => 'Granada', 'country' => 'Spain'),
        ),
    ),
    array(
        'acf_fc_layout'  => 'text_and_image',
        'anchor'         => 'about',
        'heading'        => 'Family-led. 1,900 people. Five sites.',
        'wysiwyg'        => '<p>ROIS is a family-led CDMO among the top three sterile capacities worldwide for injectables, with around 1,900 employees across the US and Europe holding the quality bar that complex biologics and vaccines demand.</p>',
        'cta'            => array('title' => 'About us', 'url' => '#', 'target' => ''),
        'cta_secondary'  => array('title' => 'Quality and compliance', 'url' => '#', 'target' => ''),
        'layout'         => 'img-left',
        'image'          => '',
    ),
    array(
        'acf_fc_layout' => 'feature_cards',
        'cards'         => array(
            array('heading' => 'Oral solids', 'text' => 'Large-scale oral solid dose manufacturing, with the flexibility, capacity and quality commercial programs demand.'),
            array('heading' => 'Drug substance', 'text' => 'Supporting drug substance development and GMP manufacturing through specialist expertise.'),
        ),
    ),
    array(
        'acf_fc_layout' => 'text_only',
        'heading'       => 'Join a team redefining what a CDMO can be',
        'wysiwyg'       => '<p>Combining technical capability with true partnership to build a more resilient global supply of life-changing medicines.</p>',
        'cta'           => array('title' => 'Learn more about us', 'url' => '#', 'target' => ''),
        'col_width'     => '9',
        'col_align'     => 'center',
        'background'    => 'green',
    ),
    array(
        'acf_fc_layout'  => 'display_posts',
        'anchor'         => 'news',
        'heading'        => 'News and resources',
        'criteria'       => 'recent',
        'post_type'      => 'cpt-articles',
        'display_style'  => 'list',
    ),
    array(
        'acf_fc_layout' => 'text_only',
        'anchor'        => 'final-cta',
        'heading'       => 'Personalized partnerships. Global reach.',
        'wysiwyg'       => "<p>Connect with the ROIS team to explore what true manufacturing partnership looks like, with a shared commitment to every program's success, at any scale.</p>",
        'cta'           => array('title' => 'Get in touch', 'url' => '#', 'target' => ''),
        'col_width'     => '9',
        'col_align'     => 'center',
        'background'    => 'navy',
    ),
), $post_id);

update_option('show_on_front', 'page');
update_option('page_on_front', $post_id);

WP_CLI::success("Seeded the ROIS homepage (post #{$post_id}), set it as the static front page.");
