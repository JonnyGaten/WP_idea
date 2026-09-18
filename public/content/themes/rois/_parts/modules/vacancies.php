<?php
/**
 * Module: Vacancies
 * No fields — queries and lists the 'cpt-vacancies' post type directly.
 * Register/activate that post type in _includes/cptax.php before using this module.
 */
$vacancies = get_posts(array(
    'post_type'      => 'cpt-vacancies',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
));
?>
<section class="module module--vacancies">
    <div class="container">
        <?php if ($vacancies) : ?>
            <div class="row">
                <?php foreach ($vacancies as $vacancy) : setup_postdata($vacancy); ?>
                    <div class="col-12 col-md-6">
                        <a href="<?php echo esc_url(get_permalink($vacancy)); ?>">
                            <h3><?php echo esc_html(get_the_title($vacancy)); ?></h3>
                        </a>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p>No current vacancies.</p>
        <?php endif; ?>
    </div>
</section>
