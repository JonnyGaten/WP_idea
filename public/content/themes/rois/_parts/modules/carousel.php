<?php
/**
 * Module: Carousel
 * Fields: slide (repeater: title, image, hover_background_image)
 */
?>
<section class="module module--carousel">
    <div class="carousel">
        <?php if (have_rows('slide')) : ?>
            <?php while (have_rows('slide')) : the_row(); ?>
                <?php $image = get_sub_field('image'); ?>
                <div class="carousel__slide">
                    <?php if ($image) : ?>
                        <?php echo wp_get_attachment_image($image, 'large'); ?>
                    <?php endif; ?>
                    <h3><?php the_sub_field('title'); ?></h3>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
