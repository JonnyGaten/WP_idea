<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2CAE6D">
    <meta name="msapplication-navbutton-color" content="#2CAE6D">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2CAE6D">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo RB_THEME_URI . '/_dist/favicons/apple-touch-icon.png'; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo RB_THEME_URI . '/_dist/favicons/favicon-32x32.png'; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo RB_THEME_URI . '/_dist/favicons/favicon-16x16.png'; ?>">
    <link rel="shortcut icon" href="<?php echo RB_THEME_URI . '/_dist/favicons/favicon.ico'; ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<nav class="top">
    <div class="container inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
            <span class="mark"><span></span><span></span><span></span><span></span></span>
            <?php bloginfo('name'); ?>
        </a>

        <?php if (has_nav_menu('primary-menu')) : ?>
            <?php wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'nav-links',
                'depth'          => 1,
            )); ?>
        <?php endif; ?>

        <a class="btn btn--primary" href="#final-cta">Get in touch</a>
    </div>
</nav>
