<?php
/**
 * Импорт логотипов из hp_color в Partners.
 * Запуск: php import-partner-logos.php (из корня проекта)
 *
 * Создаёт Partner для каждого файла в assets/logos/hp_color/,
 * устанавливает partner_logo (URL) и partner_show_in_slider = 1.
 */
$_SERVER['HTTP_HOST'] = 'localhost:8080';
define('WP_USE_THEMES', false);
require __DIR__ . '/wp-load.php';

$logos_dir = get_template_directory() . '/assets/logos/hp_color/';
$logos_url = get_template_directory_uri() . '/assets/logos/hp_color/';
$extensions = ['png', 'svg', 'jpg', 'jpeg'];
$files = [];
foreach ($extensions as $ext) {
    foreach (glob($logos_dir . '*.' . $ext) ?: [] as $path) {
        $files[] = basename($path);
    }
}
sort($files);

if (empty($files)) {
    echo "Нет файлов в $logos_dir\n";
    exit(1);
}

echo "Найдено " . count($files) . " логотипов в hp_color.\n";

// Файл -> slug существующего партнёра (обновить вместо создать)
$update_existing = [
    '615af3edeb2426bf4efea79a_Rupert logo 3.png' => 'rupert',
    '62afff730bb194b4ef6ff933_logo_blyp-blue 3.png' => 'blyp',
];
$display_names = [
    'logo-force-of-nature 1.png' => 'Force of Nature',
    'storquest-logo 1.png' => 'Storquest',
    'weber-logo 2.png' => 'Weber',
];

$created = 0;
$updated = 0;
$order = 0;

foreach ($files as $filename) {
    $logo_url = $logos_url . rawurlencode($filename);
    $title = $display_names[$filename] ?? pathinfo($filename, PATHINFO_FILENAME);
    $slug = $update_existing[$filename] ?? sanitize_title($title);

    // Уже есть партнёр с этим лого?
    $by_logo = new WP_Query([
        'post_type' => 'partner',
        'meta_query' => [['key' => 'partner_logo', 'value' => $logo_url]],
        'posts_per_page' => 1,
    ]);
    if ($by_logo->have_posts()) {
        $p = $by_logo->posts[0];
        update_post_meta($p->ID, 'partner_show_in_slider', 1);
        update_post_meta($p->ID, 'partner_order', $order);
        $order++;
        continue;
    }

    $q = new WP_Query(['post_type' => 'partner', 'name' => $slug, 'posts_per_page' => 1]);
    $existing = $q->have_posts() ? $q->posts[0] : null;

    if ($existing && isset($update_existing[$filename])) {
        update_post_meta($existing->ID, 'partner_logo', $logo_url);
        update_post_meta($existing->ID, '_partner_logo', 'field_partner_logo');
        update_post_meta($existing->ID, 'partner_show_in_slider', 1);
        update_post_meta($existing->ID, '_partner_show_in_slider', 'field_partner_show_in_slider');
        update_post_meta($existing->ID, 'partner_order', $order);
        update_post_meta($existing->ID, '_partner_order', 'field_partner_order');
        $updated++;
        echo "  Обновлён: " . $existing->post_title . " ($filename)\n";
    } else {
        $post_name = sanitize_title($title);
        $n = 0;
        while ((new WP_Query(['post_type' => 'partner', 'name' => $post_name, 'posts_per_page' => 1]))->have_posts()) {
            $post_name = sanitize_title($title) . '-' . (++$n);
        }
        $post_id = wp_insert_post([
        'post_title' => $title,
        'post_name' => $post_name,
        'post_status' => 'publish',
        'post_type' => 'partner',
        'post_author' => 1,
        'menu_order' => $order,
    ], true);
    if (is_wp_error($post_id)) {
        echo "  Ошибка: $filename - " . $post_id->get_error_message() . "\n";
        continue;
    }
    update_post_meta($post_id, 'partner_logo', $logo_url);
    update_post_meta($post_id, '_partner_logo', 'field_partner_logo');
    update_post_meta($post_id, 'partner_show_in_slider', 1);
    update_post_meta($post_id, '_partner_show_in_slider', 'field_partner_show_in_slider');
    update_post_meta($post_id, 'partner_order', $order);
    update_post_meta($post_id, '_partner_order', 'field_partner_order');
    $created++;
    echo "  Создан: $title ($filename)\n";
    }
    $order++;
}

echo "\nГотово: создано $created, обновлено $updated. Всего в слайдере: " . ($created + $updated) . "\n";
