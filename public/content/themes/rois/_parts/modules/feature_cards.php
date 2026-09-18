<?php
/**
 * Module: Feature cards
 * Fields: cards (repeater: heading, text)
 */
$cards = get_sub_field('cards') ?: array();
$colours = array('var(--green)', 'var(--green-pale)', 'var(--navy)');
?>
<section class="module module--feature-cards">
    <div class="container">
        <div class="cx-grid" data-reveal>
            <?php foreach ($cards as $i => $card) : ?>
                <div class="cx-cell">
                    <svg width="46" height="46" viewBox="0 0 46 46" aria-hidden="true">
                        <circle cx="14" cy="23" r="6" fill="<?php echo esc_attr($colours[$i % 3]); ?>"/>
                        <circle cx="26" cy="14" r="6" fill="<?php echo esc_attr($colours[($i + 1) % 3]); ?>"/>
                        <circle cx="32" cy="30" r="6" fill="<?php echo esc_attr($colours[($i + 2) % 3]); ?>"/>
                    </svg>
                    <h3><?php echo esc_html($card['heading']); ?></h3>
                    <p><?php echo esc_html($card['text']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
