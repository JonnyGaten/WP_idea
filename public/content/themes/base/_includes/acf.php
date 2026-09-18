<?php


//*  OPTIONS PAGE FROM ACF

// Registered on acf/init (not at file-parse time) — ACF's own labels are
// translated with __(), and calling this before WP's `init` action trips the
// "_load_textdomain_just_in_time" notice added in WP 6.7.
add_action('acf/init', 'rb_acf__register_options_pages');
function rb_acf__register_options_pages()
{
	if (!function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page(array(
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'options',
		'redirect'		=> false
	));


	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme options',
		'menu_title'	=> 'Theme options',
		'menu_slug' 	=> 'theme-options',
		'parent_slug'	=> 'options',
		'capability' => 'manage_options',

	));
}

//* Adding a custom toolbar
add_filter('acf/fields/wysiwyg/toolbars', 'rb_acf_my_toolbars');
function rb_acf_my_toolbars($toolbars)
{
	// Uncomment to view format of $toolbars

	// echo '< pre >';
	// print_r($toolbars);
	// echo '< /pre >';
	// die;

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple'] = array();
	$toolbars['Very Simple'][1] = array('bold', 'italic', 'underline', 'bullist', 'blockquote ', 'link', 'forecolor', 'formatselect');

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
		unset($toolbars['Full'][2][$key]);
	}

	// remove the 'Basic' toolbar completely
	unset($toolbars['Basic']);

	// return $toolbars - IMPORTANT!
	return $toolbars;
}
