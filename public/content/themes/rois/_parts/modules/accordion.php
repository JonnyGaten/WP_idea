<?php
/**
 * Module: Accordion
 * Fields: accordion (repeater: title, wysiwyg, image)
 */
?>
<section class="module module--accordion">
    <div class="container">
        <?php if (have_rows('accordion')) : $i = 0; ?>
            <?php while (have_rows('accordion')) : the_row(); $i++; ?>
                <div class="accordion-item">
                    <button class="accordion-item__trigger" aria-expanded="false" aria-controls="accordion-panel-<?php echo esc_attr($i); ?>">
                        <?php the_sub_field('title'); ?>
                    </button>
                    <div id="accordion-panel-<?php echo esc_attr($i); ?>" class="accordion-item__panel" hidden>
                        <?php the_sub_field('wysiwyg'); ?>
                        <?php if ($image = get_sub_field('image')) : ?>
                            <img src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
