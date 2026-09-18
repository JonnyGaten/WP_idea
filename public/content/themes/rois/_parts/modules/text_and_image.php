<?php
/**
 * Module: Text and image
 * Fields: heading, wysiwyg, cta (link), cta_secondary (link), layout (img-left|img-right), image
 */
$heading = get_sub_field('heading');
$layout = get_sub_field('layout') ?: 'img-left';
$image_id = get_sub_field('image');
$cta = get_sub_field('cta');
$cta_secondary = get_sub_field('cta_secondary');
$anchor = get_sub_field('anchor');
?>
<section class="module module--text-and-image module--<?php echo esc_attr($layout); ?>"<?php echo $anchor ? ' id="' . esc_attr($anchor) . '"' : ''; ?>>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 module__image">
                <?php if ($image_id) : ?>
                    <?php echo wp_get_attachment_image($image_id, 'large'); ?>
                <?php else : ?>
                    <?php get_template_part('_parts/elements/weave-illustration'); ?>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6 module__content" data-reveal>
                <?php if ($heading) : ?><h2><?php echo esc_html($heading); ?></h2><?php endif; ?>
                <?php the_sub_field('wysiwyg'); ?>
                <div class="hero-ctas">
                    <?php echo rb_render__btn($cta, 'navy'); ?>
                    <?php echo rb_render__btn($cta_secondary, 'outline-dark'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
