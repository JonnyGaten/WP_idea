<?php
/**
 * Module: Text and image
 * Fields: wysiwyg, cta (link), layout (img-left|img-right), image
 */
$layout = get_sub_field('layout') ?: 'img-left';
$image_id = get_sub_field('image');
$cta = get_sub_field('cta');
?>
<section class="module module--text-and-image module--<?php echo esc_attr($layout); ?>">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 module__image">
                <?php if ($image_id) : ?>
                    <?php echo wp_get_attachment_image($image_id, 'large'); ?>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6 module__content">
                <?php the_sub_field('wysiwyg'); ?>
                <?php echo rb_render__btn($cta); ?>
            </div>
        </div>
    </div>
</section>
