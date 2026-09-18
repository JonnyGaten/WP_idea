<?php
/**
 * Module: Stat interrupt
 * Fields: number, suffix, caption
 */
$number = get_sub_field('number');
$suffix = get_sub_field('suffix');
$caption = get_sub_field('caption');
?>
<section class="module module--stat-interrupt">
    <div class="container interrupt-grid" data-reveal>
        <div class="interrupt-num">
            <div class="num" data-count-to="<?php echo esc_attr($number); ?>" data-suffix="<?php echo esc_attr($suffix); ?>">0<?php echo esc_html($suffix); ?></div>
            <div class="num-line"></div>
        </div>
        <div class="interrupt-side">
            <p class="txt"><?php echo esc_html($caption); ?></p>
            <div class="mosaic" aria-hidden="true">
                <?php for ($i = 0; $i < 60; $i++) : ?>
                    <span<?php echo ($i % 4 === 3) ? ' class="dim"' : ''; ?> style="--i:<?php echo $i; ?>"></span>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
