<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2b2d42"><!-- Chrome, Firefox OS and Opera -->
    <meta name="msapplication-navbutton-color" content="#2b2d42"><!-- Windows Phone -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#2b2d42"><!-- iOS Safari -->

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo RB_THEME_URI . '/_dist/favicons/apple-touch-icon.png'; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo RB_THEME_URI . '/_dist/favicons/favicon-32x32.png'; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo RB_THEME_URI . '/_dist/favicons/favicon-16x16.png'; ?>">
    <link rel="manifest" href="<?php echo RB_THEME_URI . '/_dist/favicons/site.webmanifest'; ?>">
    <link rel="mask-icon" href="<?php echo RB_THEME_URI . '/_dist/favicons/safari-pinned-tab.svg'; ?>" color="#2b2d42">
    <link rel="shortcut icon" href="<?php echo RB_THEME_URI . '/_dist/favicons/favicon.ico'; ?>">
    <meta name="msapplication-TileColor" content="#2b2d42">
    <meta name="msapplication-config" content="<?php echo RB_THEME_URI . '/_dist/favicons/browserconfig.xml'; ?>">
    <link rel="preload" href="<?php echo RB_THEME_URI . '/_dist/fonts/icon.woff'; ?>" as="font" crossorigin>
    <?php wp_head(); ?>
</head>

<div class="breakpoint-identifier"></div>

<body <?php body_class(); ?>>

    <!-- Site wrapped in a div so the mobile nav menu library can transform it -->
    <div class="overflow-hidden">
