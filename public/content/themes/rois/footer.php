<?php
/**
 * Footer columns are built from the 'footer-menu' location: top-level menu
 * items are column headings, their children are the links in that column.
 */
$footer_menu = wp_nav_menu(array(
    'theme_location' => 'footer-menu',
    'container'      => false,
    'echo'           => false,
    'items_wrap'     => '%3$s',
    'walker'         => new RB_Footer_Menu_Walker(),
));
?>
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <span class="mark"><span></span><span></span><span></span><span></span></span>
                    <?php bloginfo('name'); ?>
                </a>
                <p><?php echo esc_html(get_field('global--footer-tagline', 'options')); ?></p>
            </div>
            <div class="footer-cols">
                <?php if ($footer_menu) : ?>
                    <?php echo $footer_menu; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-legal">
            &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
