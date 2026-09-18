<?php
/**
 * Module: Image gallery
 * Fields: gallery (gallery field, returns array of attachment IDs)
 */
$images = get_sub_field('gallery');
?>
<section class="module module--image-gallery">
    <div class="container">
        <div class="row">
            <?php foreach ((array) $images as $image_id) : ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
