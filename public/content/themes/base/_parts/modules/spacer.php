<?php
/**
 * Module: Spacer
 * Data (prepared in module-render.php): size (smallest|small|medium|large|largest)
 */
$size = $data['size'] ?? 'medium';
?>
<div class="module module--spacer module--spacer-<?php echo esc_attr($size); ?>"></div>
