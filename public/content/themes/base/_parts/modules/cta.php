<?php
/**
 * Module: CTA
 * Fields: cta (link), size (md|lg)
 */
$cta = get_sub_field('cta');
$size = get_sub_field('size') ?: 'md';
?>
<section class="module module--cta module--cta-<?php echo esc_attr($size); ?>">
    <div class="container text-center">
        <?php echo rb_render__btn($cta, 'primary', $size); ?>
    </div>
</section>
