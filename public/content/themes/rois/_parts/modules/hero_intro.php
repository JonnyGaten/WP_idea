<?php
/**
 * Module: Hero intro
 * Fields: heading, heading_emphasis, body, cta_primary (link), cta_secondary (link)
 */
$heading = get_sub_field('heading');
$emphasis = get_sub_field('heading_emphasis');
$body = get_sub_field('body');
$cta_primary = get_sub_field('cta_primary');
$cta_secondary = get_sub_field('cta_secondary');
?>
<header class="module module--hero-intro" id="top">
    <div class="container hero-grid">
        <div class="hero-copy" data-reveal>
            <h1 class="big"><?php echo esc_html($heading); ?> <?php if ($emphasis) : ?><em><?php echo esc_html($emphasis); ?></em><?php endif; ?></h1>
            <?php if ($body) : ?><p><?php echo esc_html($body); ?></p><?php endif; ?>
            <div class="hero-ctas">
                <?php echo rb_render__btn($cta_primary, 'primary'); ?>
                <?php echo rb_render__btn($cta_secondary, 'outline-dark'); ?>
            </div>
        </div>
        <div class="hero-art" data-reveal>
            <?php get_template_part('_parts/elements/hero-illustration'); ?>
        </div>
    </div>
</header>
