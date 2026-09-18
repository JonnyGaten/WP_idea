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

    // acf_import_field_group() always INSERTs unless told which post to update.
    // acf_get_field_group() prefers the local-JSON copy (no real DB ID) over any
    // existing DB row with the same key, so query wp_posts directly instead —
    // without this, every re-sync duplicates every field group.
    global $wpdb;
    $existing_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'acf-field-group' AND post_name = %s LIMIT 1",
        $json['key']
    ));
    if ($existing_id) {
        $json['ID'] = (int) $existing_id;
    }

    acf_import_field_group($json);

    // ACF's own local-JSON writer reacts to the import by writing a second
    // copy of this file named after the key (e.g. group_ab12cd34.json) into
    // the same acf-json dir — redundant with our title-named file and not
    // this repo's naming convention (see docs/CONVENTIONS.md), so remove it.
    $key_named_file = $json_dir . '/' . $json['key'] . '.json';
    if ($key_named_file !== $file && file_exists($key_named_file)) {
        unlink($key_named_file);
    }

    WP_CLI::log('Synced: ' . ($json['title'] ?? $json['key']));
}
