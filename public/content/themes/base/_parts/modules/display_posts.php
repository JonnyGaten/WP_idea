<?php
/**
 * Module: Display posts
 * Data (prepared in module-render.php): posts (array of WP_Post), show_filter (bool)
 */
$posts = $data['posts'] ?? array();
?>
<section class="module module--display-posts">
    <div class="container">
        <?php if (!empty($data['show_filter'])) : ?>
            <div class="module__filter"><!-- filter controls go here --></div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($posts as $post) : setup_postdata($post); ?>
                <div class="col-12 col-md-6 col-lg-3 article-card">
                    <a href="<?php echo esc_url(get_permalink($post)); ?>">
                        <?php echo get_the_post_thumbnail($post, 'medium'); ?>
                        <h3><?php echo esc_html(get_the_title($post)); ?></h3>
                    </a>
                </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
