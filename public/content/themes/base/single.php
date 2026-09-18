<?php get_header(); ?>

<article class="single-post">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <header class="single-post__header">
                <h1><?php the_title(); ?></h1>
                <p class="single-post__meta"><?php echo esc_html(rb_get__time_to_read(get_the_content())); ?> read</p>
            </header>

            <div class="single-post__content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</article>

<?php get_footer(); ?>
