<?php
/**
 * Module: Video full width
 * Fields: depth (tall|short), layout (text-left|text-right), video_placeholder_image,
 *         video_mp4 (file), video_webm (file), cta (link)
 */
$depth = get_sub_field('depth') ?: 'tall';
$layout = get_sub_field('layout') ?: 'text-left';
$poster = get_sub_field('video_placeholder_image');
$mp4 = get_sub_field('video_mp4');
$webm = get_sub_field('video_webm');
$cta = get_sub_field('cta');
?>
<section class="module module--video module--<?php echo esc_attr($depth); ?> module--<?php echo esc_attr($layout); ?>">
    <video autoplay muted loop playsinline <?php if ($poster) : ?>poster="<?php echo esc_url($poster['url']); ?>"<?php endif; ?>>
        <?php if ($mp4) : ?><source src="<?php echo esc_url($mp4['url']); ?>" type="video/mp4"><?php endif; ?>
        <?php if ($webm) : ?><source src="<?php echo esc_url($webm['url']); ?>" type="video/webm"><?php endif; ?>
    </video>
    <div class="module__content">
        <?php echo rb_render__btn($cta); ?>
    </div>
</section>
