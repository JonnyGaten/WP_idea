<?php
/**
 * Module: Locations map
 * Fields: heading, intro, locations (repeater: city, country)
 * The globe illustration is decorative — pins sit on fixed layout slots
 * (up to 6) rather than plotting real coordinates per location.
 */
$heading = get_sub_field('heading');
$intro = get_sub_field('intro');
$locations = get_sub_field('locations') ?: array();

$slots = array(
    array('x' => 95, 'y' => 150, 'r' => 6),
    array('x' => 205, 'y' => 130, 'r' => 6),
    array('x' => 215, 'y' => 150, 'r' => 4),
    array('x' => 210, 'y' => 170, 'r' => 4),
    array('x' => 200, 'y' => 195, 'r' => 4),
    array('x' => 150, 'y' => 220, 'r' => 4),
);
$anchor = get_sub_field('anchor');
?>
<section class="module module--locations-map"<?php echo $anchor ? ' id="' . esc_attr($anchor) . '"' : ''; ?>>
    <div class="container globe-grid">
        <div>
            <svg class="globe-svg" viewBox="0 0 340 340" width="100%" data-reveal aria-hidden="true">
                <defs>
                    <radialGradient id="rois-sphere" cx="35%" cy="30%" r="75%"><stop offset="0" stop-color="rgba(255,255,255,0.08)"/><stop offset="60%" stop-color="rgba(255,255,255,0.02)"/><stop offset="100%" stop-color="rgba(0,0,0,0.15)"/></radialGradient>
                </defs>
                <circle cx="170" cy="170" r="150" fill="url(#rois-sphere)"/>
                <circle cx="170" cy="170" r="150" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
                <ellipse cx="170" cy="170" rx="150" ry="55" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
                <ellipse cx="170" cy="170" rx="95" ry="150" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
                <ellipse cx="170" cy="170" rx="150" ry="150" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5" transform="rotate(45 170 170)"/>
                <?php foreach ($locations as $i => $loc) : if (!isset($slots[$i])) break; $s = $slots[$i]; ?>
                    <circle class="pulse-ring d<?php echo esc_attr($i + 1); ?>" cx="<?php echo esc_attr($s['x']); ?>" cy="<?php echo esc_attr($s['y']); ?>" r="<?php echo esc_attr($s['r']); ?>"/>
                <?php endforeach; ?>
                <g fill="var(--green)" style="filter: drop-shadow(0 0 8px rgba(44,174,109,0.6));">
                    <?php foreach ($locations as $i => $loc) : if (!isset($slots[$i])) break; $s = $slots[$i]; ?>
                        <circle class="site-node" data-index="<?php echo esc_attr($i); ?>" cx="<?php echo esc_attr($s['x']); ?>" cy="<?php echo esc_attr($s['y']); ?>" r="<?php echo esc_attr($s['r']); ?>"/>
                    <?php endforeach; ?>
                </g>
            </svg>
        </div>
        <div class="globe-copy" data-reveal>
            <h2><?php echo esc_html($heading); ?></h2>
            <?php if ($intro) : ?><p><?php echo esc_html($intro); ?></p><?php endif; ?>
            <div class="site-list" data-reveal>
                <?php foreach ($locations as $i => $loc) : ?>
                    <div class="row" data-index="<?php echo esc_attr($i); ?>">
                        <span class="c"><?php echo esc_html($loc['city']); ?></span>
                        <span class="g"><?php echo esc_html($loc['country']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
