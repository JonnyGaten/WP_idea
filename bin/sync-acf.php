<?php
/**
 * Imports every local-JSON field group into the database, same as clicking
 * "Sync available" on the Custom Fields screen. Run via:
 *   ddev wp eval-file bin/sync-acf.php
 */

if (!function_exists('acf_import_field_group')) {
    WP_CLI::warning('ACF is not active — skipping field group sync.');
    return;
}

$theme_dir = get_template_directory();
$json_dir = $theme_dir . '/acf-json';
$files = glob($json_dir . '/*.json');

if (!$files) {
    WP_CLI::log('No acf-json files found.');
    return;
}

foreach ($files as $file) {
    $json = json_decode(file_get_contents($file), true);

    if (!$json) {
        WP_CLI::warning("Could not decode {$file}");
        continue;
    }

    acf_import_field_group($json);
    WP_CLI::log('Synced: ' . ($json['title'] ?? $json['key']));
}
