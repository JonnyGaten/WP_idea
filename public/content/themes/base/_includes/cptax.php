<?php


/**
 * CUSTOM POST TYPES
 */

function rb_cptax__reg_pt_vacancies()
{
    $labels = array(
        'name'               => _x('Vacancies', 'Post Type General Name'),
        'singular_name'      => _x('Vacancy', 'Post Type Singular Name'),
        'add_new'            => _x('Add New', 'Vacancy'),
        'add_new_item'       => __('Add New Vacancy'),
        'edit_item'          => __('Edit Vacancy'),
        'new_item'           => __('New Vacancy'),
        'all_items'          => __('All Vacancies'),
        'view_item'          => __('View Vacancy'),
        'search_items'       => __('Search Vacancies'),
        'not_found'          => __('No Vacancies found'),
        'not_found_in_trash' => __('No Vacancies found in the trash'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Vacancies'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'See all vacancies',
        'public'        => false,
        'show_ui'       => true,
        'menu_position' => 31,
        'supports'      => array('title', 'editor', 'thumbnail', 'page-attributes', 'post-thumnbnail'),
        'has_archive'   => false,
        'hierarchical'  => true,
        // 'rewrite'       => array('with_front'=>false, 'slug'=>'new-slug-here'),

        'menu_icon'     => 'dashicons-businesswoman',
    );


    register_post_type('cpt-vacancies', $args);
}

function rb_cptax__reg_pt_team()
{
    $labels = array(
        'name'               => _x('Team', 'Post Type General Name'),
        'singular_name'      => _x('Team Member', 'Post Type Singular Name'),
        'add_new'            => _x('Add New', 'Team Member'),
        'add_new_item'       => __('Add New Team Member'),
        'edit_item'          => __('Edit Team Member'),
        'new_item'           => __('New Team Member'),
        'all_items'          => __('All Team Members'),
        'view_item'          => __('View Team Member'),
        'search_items'       => __('Search Team Members'),
        'not_found'          => __('No Team Members found'),
        'not_found_in_trash' => __('No Team Members found in the trash'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Team'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'See all team members',
        'public'        => true,
        'show_ui'       => true,
        'menu_position' => 31,
        'supports'      => array('title', 'editor', 'thumbnail', 'post-thumnbnail'),
        'has_archive'   => true,
        'hierarchical'  => true,
        'rewrite'       => array('with_front' => false, 'slug' => 'team'),

        'menu_icon'     => 'dashicons-groups',
    );


    register_post_type('cpt-team', $args);
}

function rb_cptax__reg_pt_articles()
{
    $labels = array(
        'name'               => _x('Articles', 'Post Type General Name'),
        'singular_name'      => _x('Article', 'Post Type Singular Name'),
        'add_new'            => _x('Add New', 'Article'),
        'add_new_item'       => __('Add New Article'),
        'edit_item'          => __('Edit Article'),
        'new_item'           => __('New Article'),
        'all_items'          => __('All Articles'),
        'view_item'          => __('View Article'),
        'search_items'       => __('Search Articles'),
        'not_found'          => __('No Articles found'),
        'not_found_in_trash' => __('No Articles found in the trash'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Articles'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'See all articles',
        'public'        => true,
        'show_ui'       => true,
        'menu_position' => 31,
        'supports'      => array('title', 'editor', 'thumbnail', 'page-attributes', 'post-thumnbnail'),
        'has_archive'   => false,
        'hierarchical'  => true,
        'rewrite'       => array('with_front' => false, 'slug' => 'articles'),

        'menu_icon'     => 'dashicons-edit-page',
    );


    register_post_type('cpt-articles', $args);
}

/**
 * TAXONOMIES
 */


function rb_cptax__reg_tax_content_type()
{

    register_taxonomy(
        'tax-content-type',        // (max. 32 characters, only lowercase letters and underscore
        array(                    // Array of post types to use this taxonomy
            'cpt-articles',
        ),
        array(                    // Arguments - see https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
            'labels'            =>    array(
                'name'            =>    'Content type',
                'add_new_item'    =>    'Add Content Type',
                'new_item_name'    =>    "New Content Type"
            ),
            'public'        => false,
            'show_ui'            =>    true,
            'show_tagcloud'        =>    false,
            'hierarchical'        =>    true,
            'show_admin_column'    =>    true,
            'rewrite'           =>  true

            //'rewrite' => array( 'hierarchical' => true, 'slug' => 'test')
        )
    );
}

function rb_cptax__reg_tax_location()
{

    register_taxonomy(
        'tax-location',        // (max. 32 characters, only lowercase letters and underscore
        array(                    // Array of post types to use this taxonomy
            'cpt-team',
            'cpt-vacancies',
        ),
        array(                    // Arguments - see https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
            'labels'            =>    array(
                'name'            =>    'Location',
                'add_new_item'    =>    'Add Location',
                'new_item_name'    =>    "New Location"
            ),
            'public'        => false,
            'show_ui'            =>    true,
            'show_tagcloud'        =>    false,
            'hierarchical'        =>    true,
            'show_admin_column'    =>    true,
            'rewrite'           =>  true

            //'rewrite' => array( 'hierarchical' => true, 'slug' => 'test')
        )
    );
}

function rb_cptax__reg_tax_department()
{

    register_taxonomy(
        'tax-department',        // (max. 32 characters, only lowercase letters and underscore
        array(                    // Array of post types to use this taxonomy
            'cpt-team',
            'cpt-vacancies',
        ),
        array(                    // Arguments - see https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
            'labels'            =>    array(
                'name'            =>    'Department',
                'add_new_item'    =>    'Add Department',
                'new_item_name'    =>    "New Department"
            ),
            'public'        => false,
            'show_ui'            =>    true,
            'show_tagcloud'        =>    false,
            'hierarchical'        =>    true,
            'show_admin_column'    =>    true,
            'rewrite'           =>  true

            //'rewrite' => array( 'hierarchical' => true, 'slug' => 'test')
        )
    );
}

// add_action('init', 'rb_cptax__reg_tax_department');
// add_action('init', 'rb_cptax__reg_tax_location');
add_action('init', 'rb_cptax__reg_tax_content_type');


add_action('init', 'rb_cptax__reg_pt_articles');
// add_action('init', 'rb_cptax__reg_pt_vacancies');
// add_action('init', 'rb_cptax__reg_pt_team');
