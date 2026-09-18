<?php
/**
 * Module: Map
 * Fields: google_map
 * Requires theme--map enabled and theme--map-api-key set under Theme options.
 */
$location = get_sub_field('google_map');
$map_enabled = get_field('theme--map', 'options');
$api_key = get_field('theme--map-api-key', 'options');
?>
<section class="module module--map">
    <div class="container">
        <?php if ($map_enabled && $api_key && $location) : ?>
            <div class="module__map" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
        <?php else : ?>
            <!-- Map module: enable "theme--map" and set an API key under Theme options to render. -->
        <?php endif; ?>
    </div>
</section>
