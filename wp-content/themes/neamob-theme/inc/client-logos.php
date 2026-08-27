<?php
/**
 * Client Logo Wall — separate from Partner Logos (slider uses white versions).
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Client Logo CPT (homepage logo wall, redesign).
 */
function neamob_register_client_logo_cpt(): void
{
    register_post_type('client_logo', [
        'labels' => [
            'name'          => 'Client Logos (Wall)',
            'singular_name' => 'Client Logo',
            'add_new'       => 'Add Client Logo',
            'add_new_item'  => 'Add Client Logo',
            'edit_item'     => 'Edit Client Logo',
            'all_items'     => 'Client Logos (Wall)',
            'search_items'  => 'Search Client Logos',
            'not_found'     => 'No client logos found',
        ],
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => ['title', 'thumbnail', 'page-attributes'],
        'show_in_rest'        => true,
    ]);
}
add_action('init', 'neamob_register_client_logo_cpt');

/**
 * Optional external link for a client logo.
 */
function neamob_register_client_logo_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_client_logo',
        'title' => 'Client Logo Settings',
        'fields' => [
            [
                'key' => 'field_client_logo_url',
                'label' => 'Website URL',
                'name' => 'client_logo_url',
                'type' => 'url',
                'instructions' => 'Optional link when clicking the logo on the homepage wall.',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'client_logo',
                ],
            ],
        ],
    ]);
}
add_action('acf/init', 'neamob_register_client_logo_fields');

/**
 * Client logos for the redesign homepage wall.
 */
function neamob_get_client_logos(): array
{
    return get_posts([
        'post_type'      => 'client_logo',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

/**
 * Import bundled PNG logos into Client Logos CPT (one-time seed).
 */
function neamob_seed_client_logos_from_assets(): void
{
    if (get_posts(['post_type' => 'client_logo', 'posts_per_page' => 1, 'post_status' => 'any'])) {
        return;
    }

    $dir = get_template_directory() . '/assets/logos/client-wall';
    if (!is_dir($dir)) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $files = glob($dir . '/*.png') ?: [];
    sort($files, SORT_NATURAL | SORT_FLAG_CASE);

    $order = 0;
    foreach ($files as $file_path) {
        $basename = pathinfo($file_path, PATHINFO_FILENAME);
        $title = ucwords(str_replace(['_', '-'], ' ', $basename));

        $post_id = wp_insert_post([
            'post_title'  => $title,
            'post_type'   => 'client_logo',
            'post_status' => 'publish',
            'menu_order'  => $order,
        ], true);

        if (is_wp_error($post_id)) {
            continue;
        }

        $upload_dir = wp_upload_dir();
        if (!empty($upload_dir['error'])) {
            continue;
        }

        $filename = sanitize_file_name(basename($file_path));
        $dest = trailingslashit($upload_dir['path']) . $filename;
        if (!copy($file_path, $dest)) {
            continue;
        }

        $filetype = wp_check_filetype($filename);
        $attachment_id = wp_insert_attachment([
            'post_mime_type' => $filetype['type'] ?: 'image/png',
            'post_title'     => $title,
            'post_content'   => '',
            'post_status'    => 'inherit',
        ], $dest, $post_id);

        if (is_wp_error($attachment_id)) {
            continue;
        }

        $attach_data = wp_generate_attachment_metadata($attachment_id, $dest);
        wp_update_attachment_metadata($attachment_id, $attach_data);
        set_post_thumbnail($post_id, $attachment_id);
        $order++;
    }
}
add_action('after_setup_theme', 'neamob_seed_client_logos_from_assets', 25);

/**
 * Service card icon config for homepage redesign.
 */
function neamob_get_service_card_icon(string $slug): array
{
    $icons = [
        'creative-design' => [
            'file'  => 'pin.svg',
            'color' => '#8A6AFF',
            'bg'    => 'rgba(138, 106, 255, 0.12)',
        ],
        'media-campaigns' => [
            'file'  => 'monitor.svg',
            'color' => '#00C853',
            'bg'    => 'rgba(0, 200, 83, 0.12)',
        ],
        'data-analytics-insights' => [
            'file'  => 'bar-chart.svg',
            'color' => '#0094FF',
            'bg'    => 'rgba(0, 148, 255, 0.12)',
        ],
        'growth-strategy-planning' => [
            'file'  => 'chart-line.svg',
            'color' => '#FF7A00',
            'bg'    => 'rgba(255, 122, 0, 0.12)',
        ],
    ];

    $base = get_template_directory_uri() . '/assets/icons/redesign/';
    $config = $icons[$slug] ?? [
        'file'  => 'bar-chart.svg',
        'color' => '#0094FF',
        'bg'    => 'rgba(0, 148, 255, 0.12)',
    ];
    $config['url'] = $base . $config['file'];

    return $config;
}

/**
 * Service pages order for redesign homepage grid.
 */
function neamob_get_redesign_service_pages(): array
{
    $slugs = [
        'creative-design',
        'media-campaigns',
        'data-analytics-insights',
        'growth-strategy-planning',
    ];

    $pages = [];
    foreach ($slugs as $slug) {
        $page = get_page_by_path('services/' . $slug);
        if (!$page) {
            $page = get_page_by_path($slug);
        }
        if ($page) {
            $pages[] = $page;
        }
    }

    return $pages;
}

/**
 * Ensure CF7 "Home CTA Short" form exists (redesign homepage).
 */
function neamob_ensure_home_cta_short_form(): void
{
    if (!class_exists('WPCF7_ContactForm')) {
        return;
    }

    $existing = get_posts([
        'post_type'      => 'wpcf7_contact_form',
        'title'          => 'Home CTA Short',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ]);

    if (!empty($existing)) {
        return;
    }

    $form_id = wp_insert_post([
        'post_type'   => 'wpcf7_contact_form',
        'post_title'  => 'Home CTA Short',
        'post_status' => 'publish',
    ], true);

    if (is_wp_error($form_id)) {
        return;
    }

    $form_markup = <<<'CF7'
<div class="cta-short-form__row">
<div class="cta-short-form__field">
<label><span class="required">*</span>Full name</label>
[text* full-name placeholder "John Doe"]
</div>
<div class="cta-short-form__field">
<label><span class="required">*</span>Email</label>
[email* your-email placeholder "john@mail.com"]
</div>
<div class="cta-short-form__field">
<label><span class="required">*</span>Interest</label>
[select* your-interest include_blank "Strategy & Planning" "Analytics & Reporting" "Creative & Design" "Media Buying" "Other"]
</div>
<div class="cta-short-form__submit">
[submit "Submit"]
</div>
</div>
[recaptcha]
CF7;

    $mail = [
        'active'             => true,
        'subject'            => 'Home CTA Short — [full-name]',
        'sender'             => 'neamob@twyx.us',
        'recipient'          => 'twyx.us@gmail.com',
        'body'               => "Name: [full-name]\nEmail: [your-email]\nInterest: [your-interest]\n",
        'additional_headers' => 'Reply-To: [your-email]',
        'attachments'        => '',
        'use_html'           => false,
    ];

    update_post_meta($form_id, '_form', $form_markup);
    update_post_meta($form_id, '_mail', $mail);
    update_post_meta($form_id, '_mail_2', ['active' => false]);
    update_post_meta($form_id, '_messages', [
        'mail_sent_ok'    => 'Thank you! Our team will get back to you within 48 hours.',
        'mail_sent_ng'    => 'There was an error. Please try again.',
        'validation_error'=> 'Please check the highlighted fields.',
    ]);
}
add_action('init', 'neamob_ensure_home_cta_short_form', 20);

/**
 * Get Home CTA Short CF7 form ID.
 */
function neamob_get_home_cta_short_form_id(): int
{
    $posts = get_posts([
        'post_type'      => 'wpcf7_contact_form',
        'title'          => 'Home CTA Short',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    return !empty($posts) ? (int) $posts[0] : 0;
}
