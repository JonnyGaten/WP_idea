<?php
/**
 * Module: Process steps
 * Fields: heading, intro, steps (repeater: title, description)
 */
$heading = get_sub_field('heading');
$intro = get_sub_field('intro');
$steps = get_sub_field('steps') ?: array();
$count = count($steps);
$anchor = get_sub_field('anchor');
?>
<section class="module module--process-steps"<?php echo $anchor ? ' id="' . esc_attr($anchor) . '"' : ''; ?>>
    <div class="container">
        <div class="process-head" data-reveal>
            <h2><?php echo esc_html($heading); ?></h2>
            <?php if ($intro) : ?><p><?php echo esc_html($intro); ?></p><?php endif; ?>
        </div>

        <?php if ($count > 0) : ?>
            <svg class="line-svg" data-reveal viewBox="0 0 1200 90" preserveAspectRatio="none" aria-hidden="true">
                <line x1="0" y1="45" x2="1200" y2="45" stroke="var(--line)" stroke-width="3"/>
                <line class="line-track" x1="0" y1="45" x2="1200" y2="45" stroke="var(--green)" stroke-width="3" stroke-dasharray="1200"/>
                <line class="flow" x1="0" y1="45" x2="1200" y2="45" stroke="var(--green)" stroke-width="4"/>
                <?php foreach ($steps as $i => $step) :
                    $x = $count > 1 ? (60 + $i * ((1200 - 120) / ($count - 1))) : 600;
                ?>
                    <circle class="line-node" data-index="<?php echo esc_attr($i); ?>" cx="<?php echo esc_attr($x); ?>" cy="45" r="11" fill="<?php echo $i === $count - 1 ? 'var(--navy)' : 'var(--green)'; ?>"/>
                <?php endforeach; ?>
            </svg>

            <div class="stage-labels" data-reveal>
                <?php foreach ($steps as $i => $step) : ?>
                    <div class="stage" data-index="<?php echo esc_attr($i); ?>">
                        <div class="n"><?php echo esc_html(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></div>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
