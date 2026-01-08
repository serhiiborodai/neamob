<?php
/**
 * Neamob Theme Functions
 *
 * @package Neamob_Theme
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include ACF fields registration
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * Theme Setup
 */
function neamob_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Add custom image sizes
    add_image_size('slider-image', 1200, 600, true);
    add_image_size('card-image', 600, 400, true);

    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'neamob-theme'),
        'footer'  => __('Footer Menu', 'neamob-theme'),
    ]);

    // Add support for HTML5 markup
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Add support for custom logo
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Add support for wide alignment in Gutenberg
    add_theme_support('align-wide');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'neamob_theme_setup');

/**
 * Enqueue scripts and styles
 */
function neamob_enqueue_scripts() {
    $theme_version = wp_get_theme()->get('Version');

    // Google Fonts - Raleway & DM Sans
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Raleway:wght@400;500;600;700;800&display=swap',
        [],
        null
    );

    // Swiper CSS
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    // Theme styles - minified CSS (compiled from SCSS)
    // style.css exists for WordPress theme info, but we load the minified version
    wp_enqueue_style(
        'neamob-style',
        get_template_directory_uri() . '/css/style.min.css',
        ['swiper-css'],
        $theme_version
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );

    // Theme custom JS
    wp_enqueue_script(
        'neamob-script',
        get_template_directory_uri() . '/js/main.js',
        ['swiper-js'],
        wp_get_theme()->get('Version'),
        true
    );

    // Pass data to JS
    wp_localize_script('neamob-script', 'neamobData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'siteUrl' => get_site_url(),
    ]);
}
add_action('wp_enqueue_scripts', 'neamob_enqueue_scripts');

/**
 * Register widget areas
 */
function neamob_widgets_init() {
    register_sidebar([
        'name'          => __('Main Sidebar', 'neamob-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'neamob-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget Area 1', 'neamob-theme'),
        'id'            => 'footer-1',
        'description'   => __('Footer widget area.', 'neamob-theme'),
        'before_widget' => '<div id="%1$s" class="footer-column %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget Area 2', 'neamob-theme'),
        'id'            => 'footer-2',
        'description'   => __('Footer widget area.', 'neamob-theme'),
        'before_widget' => '<div id="%1$s" class="footer-column %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget Area 3', 'neamob-theme'),
        'id'            => 'footer-3',
        'description'   => __('Footer widget area.', 'neamob-theme'),
        'before_widget' => '<div id="%1$s" class="footer-column %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'neamob_widgets_init');

/**
 * Register Custom Gutenberg Blocks
 */
function neamob_register_blocks() {
    // Check if Gutenberg is available
    if (!function_exists('register_block_type')) {
        return;
    }

    // Register block styles
    wp_register_style(
        'neamob-blocks-style',
        get_template_directory_uri() . '/css/blocks.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('init', 'neamob_register_blocks');

/**
 * Add custom block category
 */
function neamob_block_categories($categories) {
    return array_merge(
        [
            [
                'slug'  => 'neamob-blocks',
                'title' => __('Neamob Blocks', 'neamob-theme'),
                'icon'  => 'layout',
            ],
        ],
        $categories
    );
}
add_filter('block_categories_all', 'neamob_block_categories');

/**
 * Add custom patterns for reusable HTML blocks
 */
function neamob_register_block_patterns() {
    // Hero Section Pattern
    register_block_pattern(
        'neamob/hero-section',
        [
            'title'       => __('Hero Section', 'neamob-theme'),
            'description' => __('Full-width hero section with background', 'neamob-theme'),
            'categories'  => ['neamob-blocks'],
            'content'     => '<!-- wp:group {"className":"hero-slider","layout":{"type":"constrained"}} -->
<div class="wp-block-group hero-slider">
    <!-- wp:heading {"level":1,"textAlign":"center"} -->
    <h1 class="wp-block-heading has-text-align-center">Welcome to Neamob</h1>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center">Your success is our mission</p>
    <!-- /wp:paragraph -->
    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button {"className":"btn btn--primary"} -->
        <div class="wp-block-button btn btn--primary"><a class="wp-block-button__link wp-element-button">Get Started</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
        ]
    );

    // Feature Cards Pattern
    register_block_pattern(
        'neamob/feature-cards',
        [
            'title'       => __('Feature Cards', 'neamob-theme'),
            'description' => __('Grid of feature cards', 'neamob-theme'),
            'categories'  => ['neamob-blocks'],
            'content'     => '<!-- wp:group {"className":"feature-grid","layout":{"type":"constrained"}} -->
<div class="wp-block-group feature-grid">
    <!-- wp:group {"className":"feature-card"} -->
    <div class="wp-block-group feature-card">
        <!-- wp:heading {"level":3} -->
        <h3>Feature One</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p>Description of the first feature goes here.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"className":"feature-card"} -->
    <div class="wp-block-group feature-card">
        <!-- wp:heading {"level":3} -->
        <h3>Feature Two</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p>Description of the second feature goes here.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"className":"feature-card"} -->
    <div class="wp-block-group feature-card">
        <!-- wp:heading {"level":3} -->
        <h3>Feature Three</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p>Description of the third feature goes here.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->',
        ]
    );

    // CTA Block Pattern
    register_block_pattern(
        'neamob/cta-block',
        [
            'title'       => __('Call to Action', 'neamob-theme'),
            'description' => __('CTA section with button', 'neamob-theme'),
            'categories'  => ['neamob-blocks'],
            'content'     => '<!-- wp:group {"className":"cta-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group cta-block">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="wp-block-heading has-text-align-center">Ready to Get Started?</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center">Join thousands of satisfied customers today.</p>
    <!-- /wp:paragraph -->
    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button {"className":"btn btn--primary"} -->
        <div class="wp-block-button btn btn--primary"><a class="wp-block-button__link wp-element-button">Contact Us</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
        ]
    );

    // Slider Block Pattern
    register_block_pattern(
        'neamob/slider-section',
        [
            'title'       => __('Slider Section', 'neamob-theme'),
            'description' => __('Swiper slider container', 'neamob-theme'),
            'categories'  => ['neamob-blocks'],
            'content'     => '<!-- wp:html -->
<div class="neamob-slider">
    <div class="swiper cards-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="" alt="Slide 1">
                <div class="slide-content">
                    <h3>Slide Title 1</h3>
                    <p>Slide description goes here.</p>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="" alt="Slide 2">
                <div class="slide-content">
                    <h3>Slide Title 2</h3>
                    <p>Slide description goes here.</p>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="" alt="Slide 3">
                <div class="slide-content">
                    <h3>Slide Title 3</h3>
                    <p>Slide description goes here.</p>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
<!-- /wp:html -->',
        ]
    );

    // Contact Form Pattern (for Contact Form 7)
    register_block_pattern(
        'neamob/contact-section',
        [
            'title'       => __('Contact Section', 'neamob-theme'),
            'description' => __('Contact form section', 'neamob-theme'),
            'categories'  => ['neamob-blocks'],
            'content'     => '<!-- wp:group {"className":"section contact-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group section contact-section">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="wp-block-heading has-text-align-center">Contact Us</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center">Have questions? We would love to hear from you.</p>
    <!-- /wp:paragraph -->
    <!-- wp:shortcode -->
    [contact-form-7 id="" title="Contact Form"]
    <!-- /wp:shortcode -->
</div>
<!-- /wp:group -->',
        ]
    );
}
add_action('init', 'neamob_register_block_patterns');

/**
 * Register block pattern category
 */
function neamob_register_block_pattern_categories() {
    register_block_pattern_category(
        'neamob-blocks',
        ['label' => __('Neamob Blocks', 'neamob-theme')]
    );
}
add_action('init', 'neamob_register_block_pattern_categories');

/**
 * Shortcode for Swiper Slider
 * Usage: [neamob_slider type="hero|cards|testimonials"]
 */
function neamob_slider_shortcode($atts) {
    $atts = shortcode_atts([
        'type'    => 'cards',
        'slides'  => 3,
        'autoplay' => 'true',
    ], $atts, 'neamob_slider');

    $slider_class = 'neamob-slider';
    $swiper_class = sanitize_html_class($atts['type']) . '-slider';
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($slider_class); ?>" 
         data-slider-type="<?php echo esc_attr($atts['type']); ?>"
         data-autoplay="<?php echo esc_attr($atts['autoplay']); ?>">
        <div class="swiper <?php echo esc_attr($swiper_class); ?>">
            <div class="swiper-wrapper">
                <?php
                // Get slider content based on type
                $slides_html = apply_filters('neamob_slider_slides', '', $atts['type']);
                echo $slides_html;
                ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('neamob_slider', 'neamob_slider_shortcode');

/**
 * Shortcode for custom blocks
 * Usage: [neamob_block type="primary|accent|light" title="" content=""]
 */
function neamob_block_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'type'  => 'light',
        'title' => '',
    ], $atts, 'neamob_block');

    $class = 'custom-block custom-block--' . sanitize_html_class($atts['type']);
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($class); ?>">
        <?php if (!empty($atts['title'])) : ?>
            <h2><?php echo esc_html($atts['title']); ?></h2>
        <?php endif; ?>
        <?php echo do_shortcode($content); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('neamob_block', 'neamob_block_shortcode');

/**
 * Allow HTML in shortcodes
 */
function neamob_allow_html_shortcode($atts, $content = null) {
    return do_shortcode($content);
}
add_shortcode('html_block', 'neamob_allow_html_shortcode');

/**
 * Add AccessYes Accessibility Widget support
 * To enable: Go to Appearance > Customize > Accessibility Widget
 * Or add your AccessYes script ID to the theme
 */
function neamob_customizer_accessibility($wp_customize) {
    // Add Accessibility section
    $wp_customize->add_section('neamob_accessibility', [
        'title'    => __('Accessibility Widget', 'neamob-theme'),
        'priority' => 200,
    ]);

    // AccessYes Widget ID
    $wp_customize->add_setting('accessyes_enabled', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);

    $wp_customize->add_control('accessyes_enabled', [
        'label'       => __('Enable AccessYes Widget', 'neamob-theme'),
        'description' => __('Enable the CookieYes AccessYes accessibility widget', 'neamob-theme'),
        'section'     => 'neamob_accessibility',
        'type'        => 'checkbox',
    ]);

    // Custom accessibility script
    $wp_customize->add_setting('accessibility_script', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('accessibility_script', [
        'label'       => __('Custom Accessibility Script', 'neamob-theme'),
        'description' => __('Paste your AccessYes installation code here (from cookieyes.com)', 'neamob-theme'),
        'section'     => 'neamob_accessibility',
        'type'        => 'textarea',
    ]);
}
add_action('customize_register', 'neamob_customizer_accessibility');

/**
 * Output AccessYes widget script
 */
function neamob_output_accessibility_widget() {
    $enabled = get_theme_mod('accessyes_enabled', false);
    $script = get_theme_mod('accessibility_script', '');

    if ($enabled && !empty($script)) {
        echo $script;
    }
}
add_action('wp_footer', 'neamob_output_accessibility_widget');

/**
 * Register Case Studies Custom Post Type
 */
function neamob_register_case_studies_cpt() {
    $labels = [
        'name'               => __('Case Studies', 'neamob-theme'),
        'singular_name'      => __('Case Study', 'neamob-theme'),
        'menu_name'          => __('Case Studies', 'neamob-theme'),
        'add_new'            => __('Add New', 'neamob-theme'),
        'add_new_item'       => __('Add New Case Study', 'neamob-theme'),
        'edit_item'          => __('Edit Case Study', 'neamob-theme'),
        'new_item'           => __('New Case Study', 'neamob-theme'),
        'view_item'          => __('View Case Study', 'neamob-theme'),
        'search_items'       => __('Search Case Studies', 'neamob-theme'),
        'not_found'          => __('No case studies found', 'neamob-theme'),
        'not_found_in_trash' => __('No case studies found in trash', 'neamob-theme'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'case-study'],
        'capability_type'     => 'post',
        'has_archive'         => 'case-studies',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'        => true,
    ];

    register_post_type('case_study', $args);
}
add_action('init', 'neamob_register_case_studies_cpt');

/**
 * Register Jobs/Careers CPT
 */
function neamob_register_jobs_cpt() {
    register_post_type('job', [
        'labels' => [
            'name' => 'Jobs',
            'singular_name' => 'Job',
            'add_new' => 'Add New Job',
            'add_new_item' => 'Add New Job',
            'edit_item' => 'Edit Job',
            'view_item' => 'View Job',
            'all_items' => 'All Jobs',
            'search_items' => 'Search Jobs',
            'not_found' => 'No jobs found',
        ],
        'public' => true,
        'has_archive' => 'careers',
        'rewrite' => ['slug' => 'careers', 'with_front' => false],
        'menu_icon' => 'dashicons-businessman',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    // Register Job Category Taxonomy
    register_taxonomy('job_category', 'job', [
        'labels' => [
            'name' => 'Job Categories',
            'singular_name' => 'Job Category',
            'search_items' => 'Search Categories',
            'all_items' => 'All Categories',
            'edit_item' => 'Edit Category',
            'add_new_item' => 'Add New Category',
        ],
        'hierarchical' => true,
        'public' => true,
        'rewrite' => ['slug' => 'job-category'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'neamob_register_jobs_cpt');

/**
 * Register Team Members CPT
 */
function neamob_register_team_cpt() {
    register_post_type('team_member', [
        'labels' => [
            'name' => 'Team Members',
            'singular_name' => 'Team Member',
            'add_new' => 'Add New Member',
            'add_new_item' => 'Add New Team Member',
            'edit_item' => 'Edit Team Member',
            'view_item' => 'View Team Member',
            'all_items' => 'All Team Members',
            'search_items' => 'Search Team Members',
            'not_found' => 'No team members found',
        ],
        'public' => true,
        'has_archive' => false,
        'rewrite' => ['slug' => 'team'],
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    // Register Team Department Taxonomy
    register_taxonomy('team_department', 'team_member', [
        'labels' => [
            'name' => 'Departments',
            'singular_name' => 'Department',
            'search_items' => 'Search Departments',
            'all_items' => 'All Departments',
            'edit_item' => 'Edit Department',
            'add_new_item' => 'Add New Department',
        ],
        'hierarchical' => true,
        'public' => true,
        'rewrite' => ['slug' => 'department'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'neamob_register_team_cpt');

/**
 * Increment job applications counter when CF7 form is submitted
 */
function neamob_count_job_application($contact_form) {
    $form_id = $contact_form->id();
    
    // Only process job application form (ID: 61)
    if ($form_id != 61) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
        $job_id = isset($data['job-id']) ? intval($data['job-id']) : 0;
        
        if ($job_id > 0 && get_post_type($job_id) === 'job') {
            $current = (int) get_post_meta($job_id, 'job_applications_count', true);
            update_post_meta($job_id, 'job_applications_count', $current + 1);
        }
    }
}
add_action('wpcf7_mail_sent', 'neamob_count_job_application');

/**
 * Add meta boxes for Case Studies
 */
function neamob_case_study_meta_boxes() {
    add_meta_box(
        'case_study_details',
        __('Case Study Details', 'neamob-theme'),
        'neamob_case_study_meta_box_callback',
        'case_study',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'neamob_case_study_meta_boxes');

/**
 * Case Study meta box callback
 */
function neamob_case_study_meta_box_callback($post) {
    wp_nonce_field('neamob_case_study_meta', 'neamob_case_study_nonce');

    $badge_text = get_post_meta($post->ID, '_case_study_badge_text', true);
    $badge_value = get_post_meta($post->ID, '_case_study_badge_value', true);
    $client_logo = get_post_meta($post->ID, '_case_study_client_logo', true);
    $client_name = get_post_meta($post->ID, '_case_study_client_name', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="case_study_client_name"><?php _e('Client Name', 'neamob-theme'); ?></label></th>
            <td><input type="text" id="case_study_client_name" name="case_study_client_name" value="<?php echo esc_attr($client_name); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="case_study_client_logo"><?php _e('Client Logo URL', 'neamob-theme'); ?></label></th>
            <td>
                <input type="text" id="case_study_client_logo" name="case_study_client_logo" value="<?php echo esc_url($client_logo); ?>" class="regular-text">
                <button type="button" class="button neamob-upload-logo"><?php _e('Upload Logo', 'neamob-theme'); ?></button>
                <p class="description"><?php _e('Upload or enter URL of the client logo (preferably SVG or PNG with transparent background)', 'neamob-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="case_study_badge_value"><?php _e('Badge Value', 'neamob-theme'); ?></label></th>
            <td>
                <input type="text" id="case_study_badge_value" name="case_study_badge_value" value="<?php echo esc_attr($badge_value); ?>" class="regular-text" placeholder="+32%">
                <p class="description"><?php _e('Example: +32%, +358%, 2x', 'neamob-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="case_study_badge_text"><?php _e('Badge Text', 'neamob-theme'); ?></label></th>
            <td>
                <input type="text" id="case_study_badge_text" name="case_study_badge_text" value="<?php echo esc_attr($badge_text); ?>" class="regular-text" placeholder="REVENUE">
                <p class="description"><?php _e('Example: REVENUE, LEADS, ROI', 'neamob-theme'); ?></p>
            </td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('.neamob-upload-logo').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Select Logo',
                button: { text: 'Use this logo' },
                multiple: false
            }).on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.prev('input').val(attachment.url);
            }).open();
        });
    });
    </script>
    <?php
}

/**
 * Save Case Study meta
 */
function neamob_save_case_study_meta($post_id) {
    if (!isset($_POST['neamob_case_study_nonce']) || !wp_verify_nonce($_POST['neamob_case_study_nonce'], 'neamob_case_study_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = ['case_study_badge_text', 'case_study_badge_value', 'case_study_client_logo', 'case_study_client_name'];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $field === 'case_study_client_logo' ? esc_url_raw($_POST[$field]) : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post_case_study', 'neamob_save_case_study_meta');

/**
 * Helper function to get case studies for display
 */
function neamob_get_case_studies($args = []) {
    $defaults = [
        'post_type'      => 'case_study',
        'posts_per_page' => 2,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    
    $args = wp_parse_args($args, $defaults);
    return new WP_Query($args);
}

/**
 * Shortcode to display case studies
 * Usage: [case_studies count="2"]
 */
function neamob_case_studies_shortcode($atts) {
    $atts = shortcode_atts([
        'count' => 2,
    ], $atts, 'case_studies');

    $query = neamob_get_case_studies(['posts_per_page' => intval($atts['count'])]);
    
    if (!$query->have_posts()) {
        return '';
    }

    ob_start();
    ?>
    <div class="case-studies-grid">
        <?php while ($query->have_posts()) : $query->the_post(); 
            $badge_text = get_post_meta(get_the_ID(), '_case_study_badge_text', true);
            $badge_value = get_post_meta(get_the_ID(), '_case_study_badge_value', true);
            $client_logo = get_post_meta(get_the_ID(), '_case_study_client_logo', true);
            $client_name = get_post_meta(get_the_ID(), '_case_study_client_name', true);
        ?>
        <article class="case-card">
            <div class="case-card__header">
                <div class="case-card__logo">
                    <?php if ($client_logo) : ?>
                        <img src="<?php echo esc_url($client_logo); ?>" alt="<?php echo esc_attr($client_name); ?>">
                    <?php elseif ($client_name) : ?>
                        <span><?php echo esc_html($client_name); ?></span>
                    <?php endif; ?>
                </div>
                <?php if ($badge_value && $badge_text) : ?>
                <div class="case-card__badge"><?php echo esc_html($badge_value . ' ' . $badge_text); ?></div>
                <?php endif; ?>
            </div>
            <div class="case-card__content">
                <p class="case-card__text"><?php echo wp_trim_words(get_the_excerpt(), 50); ?></p>
            </div>
            <a href="<?php the_permalink(); ?>" class="case-card__link">Read More</a>
        </article>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('case_studies', 'neamob_case_studies_shortcode');

