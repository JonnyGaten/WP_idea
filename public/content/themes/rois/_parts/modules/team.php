<?php
/**
 * Module: Team
 * Fields: headline (text), subheading (textarea)
 * Lists all published 'cpt-team' members. Register/activate that post type in
 * _includes/cptax.php before using this module.
 */
$team = get_posts(array(
    'post_type'      => 'cpt-team',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
));
?>
<section class="module module--team">
    <div class="container">
        <?php if ($headline = get_sub_field('headline')) : ?>
            <h2><?php echo esc_html($headline); ?></h2>
        <?php endif; ?>
        <?php if ($subheading = get_sub_field('subheading')) : ?>
            <p><?php echo wp_kses_post($subheading); ?></p>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($team as $member) : setup_postdata($member); ?>
                <div class="col-12 col-md-4 col-lg-3">
                    <?php echo get_the_post_thumbnail($member, 'medium'); ?>
                    <h3><?php echo esc_html(get_the_title($member)); ?></h3>
                </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
