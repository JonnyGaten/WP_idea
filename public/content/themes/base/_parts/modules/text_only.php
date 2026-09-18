<?php
/**
 * Module: Text only
 * Fields: col_width (4|6|8|9|12), col_align (start|center|end), wysiwyg, cta (link)
 */
$col_width = get_sub_field('col_width') ?: '8';
$col_align = get_sub_field('col_align') ?: 'center';
$cta = get_sub_field('cta');
?>
<section class="module module--text-only">
    <div class="container">
        <div class="row justify-content-<?php echo esc_attr($col_align); ?>">
            <div class="col-12 col-md-<?php echo esc_attr($col_width); ?> text-<?php echo esc_attr($col_align); ?>">
                <?php the_sub_field('wysiwyg'); ?>
                <?php echo rb_render__btn($cta); ?>
            </div>
        </div>
    </div>
</section>
