<?php
/**
 * Module: Text only
 * Fields: heading, col_width (4|6|8|9|12), col_align (start|center|end),
 *         wysiwyg, cta (link), background (default|navy|green)
 */
$heading = get_sub_field('heading');
$col_width = get_sub_field('col_width') ?: '8';
$col_align = get_sub_field('col_align') ?: 'center';
$cta = get_sub_field('cta');
$background = get_sub_field('background') ?: 'default';
$anchor = get_sub_field('anchor');
?>
<section class="module module--text-only module--bg-<?php echo esc_attr($background); ?>"<?php echo $anchor ? ' id="' . esc_attr($anchor) . '"' : ''; ?>>
    <div class="container">
        <div class="text-only__panel">
            <div class="row justify-content-<?php echo esc_attr($col_align); ?>">
                <div class="col-12 col-md-<?php echo esc_attr($col_width); ?> text-<?php echo esc_attr($col_align); ?>">
                    <?php if ($heading) : ?><h2><?php echo esc_html($heading); ?></h2><?php endif; ?>
                    <?php the_sub_field('wysiwyg'); ?>
                    <?php echo rb_render__btn($cta, $background === 'default' ? 'primary' : 'navy'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
