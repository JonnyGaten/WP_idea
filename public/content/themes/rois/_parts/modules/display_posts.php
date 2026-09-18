<?php
/**
 * Module: Display posts
 * Fields: heading, display_style (grid|list)
 * Data (prepared in module-render.php): posts (array of WP_Post), show_filter (bool)
 */
$heading = get_sub_field('heading');
$display_style = get_sub_field('display_style') ?: 'grid';
$posts = $data['posts'] ?? array();
$anchor = get_sub_field('anchor');
?>
<section class="module module--display-posts module--display-posts-<?php echo esc_attr($display_style); ?>"<?php echo $anchor ? ' id="' . esc_attr($anchor) . '"' : ''; ?>>
    <div class="container">
        <?php if ($heading) : ?>
            <div class="news-head" data-reveal><h2><?php echo esc_html($heading); ?></h2></div>
        <?php endif; ?>

        <?php if (!empty($data['show_filter'])) : ?>
            <div class="module__filter"><!-- filter controls go here --></div>
        <?php endif; ?>

        <?php if ($display_style === 'list') : ?>
            <div class="news-list" data-reveal>
                <?php foreach ($posts as $post) : setup_postdata($post);
                    $terms = get_the_terms($post, 'tax-content-type');
                    $tag = ($terms && !is_wp_error($terms)) ? $terms[0]->name : get_post_type_object($post->post_type)->labels->singular_name;
                ?>
                    <a class="news-row" href="<?php echo esc_url(get_permalink($post)); ?>">
                        <div class="tag"><?php echo esc_html($tag); ?></div>
                        <h3><?php echo esc_html(get_the_title($post)); ?></h3>
                        <div class="arrow">&rarr;</div>
                    </a>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
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
        <?php endif; ?>
    </div>
</section>
