<?php

define('RB_THEME_DIR', get_template_directory());
define('RB_THEME_URI', get_template_directory_uri());

// Admin-side changes
require_once RB_THEME_DIR . '/_includes/admin.php';

// ACF options pages, toolbars
require_once RB_THEME_DIR . '/_includes/acf.php';

// Styles and scripts
require_once RB_THEME_DIR . '/_includes/styles.php';
require_once RB_THEME_DIR . '/_includes/scripts.php';

// Post types and taxonomies
require_once RB_THEME_DIR . '/_includes/cptax.php';

// Menus
require_once RB_THEME_DIR . '/_includes/menus.php';

// Data helpers (rb_get__*)
require_once RB_THEME_DIR . '/_includes/get.php';

// Render helpers (rb_render__*)
require_once RB_THEME_DIR . '/_includes/render.php';

// Page builder module rendering (ra__render_modules)
require_once RB_THEME_DIR . '/_parts/module-render.php';

// Image sizes
require_once RB_THEME_DIR . '/_includes/images.php';

// wp-admin / login screen branding
require_once RB_THEME_DIR . '/_includes/wp-styles.php';

// Form submission handling
require_once RB_THEME_DIR . '/_includes/form-submissions.php';
