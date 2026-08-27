<?php
/**
 * Admin-only redesign preview pages (noindex, blocked for visitors).
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Page slugs that are redesign previews. */
const NEAMOB_REDESIGN_PAGE_SLUGS = [
    'home-redesign',
    'portfolio-redesign',
];

/** Post slug for blog redesign preview. */
const NEAMOB_REDESIGN_POST_SLUG = 'blog-post-redesign';

/** Post meta flag for redesign preview copies. */
const NEAMOB_REDESIGN_POST_META = '_neamob_redesign_preview';

/**
 * Whether the current request is a redesign preview page/post.
 */
function neamob_is_redesign_preview(): bool
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return false;
    }

    if (is_page()) {
        $slug = get_post_field('post_name', get_queried_object_id());
        return in_array($slug, NEAMOB_REDESIGN_PAGE_SLUGS, true);
    }

    if (is_singular('post')) {
        $post_id = get_queried_object_id();
        if (get_post_meta($post_id, NEAMOB_REDESIGN_POST_META, true)) {
            return true;
        }

        return get_post_field('post_name', $post_id) === NEAMOB_REDESIGN_POST_SLUG;
    }

    return false;
}

/**
 * Restrict redesign previews to administrators.
 */
function neamob_redesign_preview_access_control(): void
{
    if (!neamob_is_redesign_preview()) {
        return;
    }

    if (current_user_can('manage_options')) {
        return;
    }

    if (is_user_logged_in()) {
        status_header(403);
        nocache_headers();
        wp_die(
            esc_html__('This preview page is available to site administrators only.', 'neamob-theme'),
            esc_html__('Access denied', 'neamob-theme'),
            ['response' => 403]
        );
    }

    auth_redirect();
}
add_action('template_redirect', 'neamob_redesign_preview_access_control', 0);

/**
 * Use the v2 single template for redesign blog posts.
 */
function neamob_redesign_single_template(string $template): string
{
    if (!is_singular('post') || !neamob_is_redesign_preview()) {
        return $template;
    }

    $v2 = locate_template('single-v2.php');
    return $v2 ?: $template;
}
add_filter('single_template', 'neamob_redesign_single_template');

/**
 * Prevent search engines from indexing redesign previews.
 */
function neamob_redesign_preview_robots(array $robots): array
{
    if (!neamob_is_redesign_preview()) {
        return $robots;
    }

    return array_merge($robots, [
        'noindex'   => true,
        'nofollow'  => true,
        'noarchive' => true,
        'noimageindex' => true,
    ]);
}
add_filter('wp_robots', 'neamob_redesign_preview_robots');

function neamob_redesign_preview_robots_header(): void
{
    if (neamob_is_redesign_preview()) {
        header('X-Robots-Tag: noindex, nofollow, noarchive, noimageindex', true);
    }
}
add_action('template_redirect', 'neamob_redesign_preview_robots_header', 1);

function neamob_redesign_preview_rank_math_robots(array $robots): array
{
    if (!neamob_is_redesign_preview()) {
        return $robots;
    }

    return [
        'index'  => 'noindex',
        'follow' => 'nofollow',
    ];
}
add_filter('rank_math/frontend/robots', 'neamob_redesign_preview_rank_math_robots');

function neamob_redesign_preview_exclude_from_sitemap(bool $exclude, string $type, $object): bool
{
    if (!$exclude && neamob_is_redesign_preview()) {
        return true;
    }

    if ($type === 'post' && is_object($object) && isset($object->ID)) {
        if (get_post_meta($object->ID, NEAMOB_REDESIGN_POST_META, true)) {
            return true;
        }
        if (isset($object->post_name) && $object->post_name === NEAMOB_REDESIGN_POST_SLUG) {
            return true;
        }
    }

    if ($type === 'page' && is_object($object) && isset($object->post_name)) {
        if (in_array($object->post_name, NEAMOB_REDESIGN_PAGE_SLUGS, true)) {
            return true;
        }
    }

    return $exclude;
}
add_filter('rank_math/sitemap/exclude_object', 'neamob_redesign_preview_exclude_from_sitemap', 10, 3);

function neamob_redesign_preview_body_class(array $classes): array
{
    if (neamob_is_redesign_preview()) {
        $classes[] = 'redesign-preview';
    }
    return $classes;
}
add_filter('body_class', 'neamob_redesign_preview_body_class');

/**
 * Copy post meta from one post to another (for creating redesign page copies).
 */
function neamob_copy_post_meta(int $source_id, int $target_id, array $skip_keys = []): void
{
    $default_skip = [
        '_edit_lock',
        '_edit_last',
        '_wp_old_slug',
        NEAMOB_REDESIGN_POST_META,
    ];
    $skip_keys = array_merge($default_skip, $skip_keys);

    $meta = get_post_meta($source_id);
    if (!is_array($meta)) {
        return;
    }

    foreach ($meta as $key => $values) {
        if (in_array($key, $skip_keys, true)) {
            continue;
        }

        delete_post_meta($target_id, $key);
        foreach ($values as $value) {
            add_post_meta($target_id, $key, maybe_unserialize($value));
        }
    }
}

/**
 * Create or update redesign preview pages/posts on theme setup (local/dev).
 */
function neamob_setup_redesign_preview_content(): void
{
    if (!function_exists('get_page_by_path')) {
        return;
    }

    $home_source = get_page_by_path('home');
    if ($home_source) {
        $home_redesign = get_page_by_path('home-redesign');
        if (!$home_redesign) {
            $home_id = wp_insert_post([
                'post_title'   => 'Home (Redesign)',
                'post_name'    => 'home-redesign',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ], true);

            if (!is_wp_error($home_id)) {
                update_post_meta($home_id, '_wp_page_template', 'front-page-v2.php');
                neamob_copy_post_meta($home_source->ID, $home_id);
                update_post_meta($home_id, '_wp_page_template', 'front-page-v2.php');
            }
        }
    }

    $portfolio_source = get_page_by_path('portfolio');
    if ($portfolio_source) {
        $portfolio_redesign = get_page_by_path('portfolio-redesign');
        if (!$portfolio_redesign) {
            $portfolio_id = wp_insert_post([
                'post_title'   => 'Portfolio (Redesign)',
                'post_name'    => 'portfolio-redesign',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ], true);

            if (!is_wp_error($portfolio_id)) {
                update_post_meta($portfolio_id, '_wp_page_template', 'page-portfolio-v2.php');
                neamob_copy_post_meta($portfolio_source->ID, $portfolio_id);
                update_post_meta($portfolio_id, '_wp_page_template', 'page-portfolio-v2.php');
            }
        }
    }

    $blog_source = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    if (!empty($blog_source)) {
        $source_post = $blog_source[0];
        $blog_redesign = get_page_by_path(NEAMOB_REDESIGN_POST_SLUG, OBJECT, 'post');

        if (!$blog_redesign) {
            $post_id = wp_insert_post([
                'post_title'   => $source_post->post_title . ' (Redesign)',
                'post_name'    => NEAMOB_REDESIGN_POST_SLUG,
                'post_status'  => 'publish',
                'post_type'    => 'post',
                'post_content' => $source_post->post_content,
                'post_excerpt' => $source_post->post_excerpt,
            ], true);

            if (!is_wp_error($post_id)) {
                update_post_meta($post_id, NEAMOB_REDESIGN_POST_META, '1');
                neamob_copy_post_meta($source_post->ID, $post_id);
                update_post_meta($post_id, NEAMOB_REDESIGN_POST_META, '1');

                $taxonomies = get_object_taxonomies('post');
                foreach ($taxonomies as $taxonomy) {
                    $terms = wp_get_object_terms($source_post->ID, $taxonomy, ['fields' => 'ids']);
                    if (!is_wp_error($terms) && !empty($terms)) {
                        wp_set_object_terms($post_id, $terms, $taxonomy);
                    }
                }

                $thumb_id = get_post_thumbnail_id($source_post->ID);
                if ($thumb_id) {
                    set_post_thumbnail($post_id, $thumb_id);
                }
            }
        }
    }
}
add_action('after_setup_theme', 'neamob_setup_redesign_preview_content', 20);
