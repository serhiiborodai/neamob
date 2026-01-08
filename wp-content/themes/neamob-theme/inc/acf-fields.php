<?php
/**
 * ACF Fields Registration
 * All custom fields for the theme
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Testimonials CPT
 */
function neamob_register_testimonials_cpt() {
    $labels = [
        'name'               => __('Testimonials', 'neamob-theme'),
        'singular_name'      => __('Testimonial', 'neamob-theme'),
        'menu_name'          => __('Testimonials', 'neamob-theme'),
        'add_new'            => __('Add New', 'neamob-theme'),
        'add_new_item'       => __('Add New Testimonial', 'neamob-theme'),
        'edit_item'          => __('Edit Testimonial', 'neamob-theme'),
        'new_item'           => __('New Testimonial', 'neamob-theme'),
        'view_item'          => __('View Testimonial', 'neamob-theme'),
        'search_items'       => __('Search Testimonials', 'neamob-theme'),
        'not_found'          => __('No testimonials found', 'neamob-theme'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => false,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-format-quote',
        'supports'            => ['title'],
        'show_in_rest'        => true,
    ];

    register_post_type('testimonial', $args);
}
add_action('init', 'neamob_register_testimonials_cpt');

/**
 * Register Services CPT
 */
function neamob_register_services_cpt() {
    $labels = [
        'name'               => __('Services', 'neamob-theme'),
        'singular_name'      => __('Service', 'neamob-theme'),
        'menu_name'          => __('Services', 'neamob-theme'),
        'add_new'            => __('Add New', 'neamob-theme'),
        'add_new_item'       => __('Add New Service', 'neamob-theme'),
        'edit_item'          => __('Edit Service', 'neamob-theme'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'services'],
        'capability_type'     => 'post',
        'has_archive'         => 'services',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-tools',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'        => true,
    ];

    register_post_type('service', $args);
}
add_action('init', 'neamob_register_services_cpt');

/**
 * Register FAQ CPT
 */
function neamob_register_faq_cpt() {
    $labels = [
        'name'               => __('FAQs', 'neamob-theme'),
        'singular_name'      => __('FAQ', 'neamob-theme'),
        'menu_name'          => __('FAQs', 'neamob-theme'),
        'add_new'            => __('Add New', 'neamob-theme'),
        'add_new_item'       => __('Add New FAQ', 'neamob-theme'),
        'edit_item'          => __('Edit FAQ', 'neamob-theme'),
        'new_item'           => __('New FAQ', 'neamob-theme'),
        'view_item'          => __('View FAQ', 'neamob-theme'),
        'search_items'       => __('Search FAQs', 'neamob-theme'),
        'not_found'          => __('No FAQs found', 'neamob-theme'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => false,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-editor-help',
        'supports'            => ['title', 'page-attributes'],
        'show_in_rest'        => true,
    ];

    register_post_type('faq', $args);
}
add_action('init', 'neamob_register_faq_cpt');

/**
 * Register Partner Logos CPT
 */
function neamob_register_partners_cpt() {
    $labels = [
        'name'               => __('Partner Logos', 'neamob-theme'),
        'singular_name'      => __('Partner Logo', 'neamob-theme'),
        'menu_name'          => __('Partner Logos', 'neamob-theme'),
        'add_new'            => __('Add New', 'neamob-theme'),
        'add_new_item'       => __('Add New Partner', 'neamob-theme'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => false,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-building',
        'supports'            => ['title'],
        'show_in_rest'        => true,
    ];

    register_post_type('partner', $args);
}
add_action('init', 'neamob_register_partners_cpt');

/**
 * Register ACF Fields programmatically
 */
function neamob_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // =========================================================================
    // Homepage Hero Section
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_homepage_hero',
        'title' => 'Hero Section',
        'fields' => [
            [
                'key' => 'field_hero_title',
                'label' => 'Title',
                'name' => 'hero_title',
                'type' => 'text',
                'default_value' => 'We make the complex simple',
                'instructions' => 'Main headline. Use <br> for line breaks.',
            ],
            [
                'key' => 'field_hero_text',
                'label' => 'Description',
                'name' => 'hero_text',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'At NeaMob Tech we specialize in transforming complex data into clear insights and compelling actionable strategies.',
            ],
            [
                'key' => 'field_hero_button_text',
                'label' => 'Button Text',
                'name' => 'hero_button_text',
                'type' => 'text',
                'default_value' => "Let's Chat",
            ],
            [
                'key' => 'field_hero_button_link',
                'label' => 'Button Link',
                'name' => 'hero_button_link',
                'type' => 'link',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
                ],
            ],
            [
                [
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ]);

    // =========================================================================
    // Value Section
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_value_section',
        'title' => 'Value Section',
        'fields' => [
            [
                'key' => 'field_value_title',
                'label' => 'Title',
                'name' => 'value_title',
                'type' => 'text',
                'default_value' => 'We focus on what brings value & the bottom line',
            ],
            [
                'key' => 'field_value_text',
                'label' => 'Description',
                'name' => 'value_text',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_value_button_text',
                'label' => 'Button Text',
                'name' => 'value_button_text',
                'type' => 'text',
                'default_value' => 'Book Free Audit',
            ],
            [
                'key' => 'field_value_button_link',
                'label' => 'Button Link',
                'name' => 'value_button_link',
                'type' => 'link',
            ],
            [
                'key' => 'field_value_stats_text',
                'label' => 'Stats Card Text',
                'name' => 'value_stats_text',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_value_stats_number',
                'label' => 'Stats Number',
                'name' => 'value_stats_number',
                'type' => 'text',
                'default_value' => '+358%',
            ],
            [
                'key' => 'field_value_stats_label',
                'label' => 'Stats Label',
                'name' => 'value_stats_label',
                'type' => 'text',
                'default_value' => 'Qualified Leads YoY',
            ],
            [
                'key' => 'field_value_image',
                'label' => 'Laptop/Dashboard Image',
                'name' => 'value_image',
                'type' => 'image',
                'return_format' => 'url',
            ],
            [
                'key' => 'field_value_tags',
                'label' => 'Report Tags',
                'name' => 'value_tags',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Tag',
                'sub_fields' => [
                    [
                        'key' => 'field_value_tag_text',
                        'label' => 'Tag Text',
                        'name' => 'tag_text',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_value_tag_icon_only',
                        'label' => 'Icon Only?',
                        'name' => 'icon_only',
                        'type' => 'true_false',
                        'ui' => 1,
                    ],
                    [
                        'key' => 'field_value_tag_style',
                        'label' => 'Style',
                        'name' => 'tag_style',
                        'type' => 'select',
                        'choices' => [
                            'default' => 'Default (outline)',
                            'icon' => 'Blue Icon',
                            'icon-alt' => 'Green Icon',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
                ],
            ],
            [
                [
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ],
            ],
        ],
        'menu_order' => 2,
    ]);

    // =========================================================================
    // Testimonials Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_testimonial',
        'title' => 'Testimonial Details',
        'fields' => [
            [
                'key' => 'field_testimonial_quote',
                'label' => 'Quote Text',
                'name' => 'testimonial_quote',
                'type' => 'textarea',
                'rows' => 4,
                'required' => 1,
            ],
            [
                'key' => 'field_testimonial_author_name',
                'label' => 'Author Name',
                'name' => 'author_name',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'key' => 'field_testimonial_author_position',
                'label' => 'Author Position',
                'name' => 'author_position',
                'type' => 'text',
            ],
            [
                'key' => 'field_testimonial_company_logo',
                'label' => 'Company Logo',
                'name' => 'company_logo',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'SVG or PNG with transparent background preferred',
            ],
            [
                'key' => 'field_testimonial_author_photo',
                'label' => 'Author Photo',
                'name' => 'author_photo',
                'type' => 'image',
                'return_format' => 'url',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // Services Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_service',
        'title' => 'Service Details',
        'fields' => [
            [
                'key' => 'field_service_short_description',
                'label' => 'Short Description (for accordion)',
                'name' => 'service_short_description',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => 'This text appears in the accordion on homepage',
            ],
            [
                'key' => 'field_service_icon',
                'label' => 'Icon',
                'name' => 'service_icon',
                'type' => 'select',
                'choices' => [
                    'arrow' => 'Arrow',
                    'chart' => 'Chart',
                    'target' => 'Target',
                    'lightbulb' => 'Lightbulb',
                    'gear' => 'Gear',
                ],
                'default_value' => 'arrow',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'service',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // Team Member Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_team_member',
        'title' => 'Team Member Details',
        'fields' => [
            [
                'key' => 'field_team_position',
                'label' => 'Position',
                'name' => 'team_position',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'key' => 'field_team_location',
                'label' => 'Location',
                'name' => 'team_location',
                'type' => 'text',
                'placeholder' => 'Ukraine',
            ],
            [
                'key' => 'field_team_department_color',
                'label' => 'Department Badge Color',
                'name' => 'team_department_color',
                'type' => 'select',
                'choices' => [
                    'green' => 'Green (Campaign Management)',
                    'blue' => 'Blue (Creative & Design)',
                    'purple' => 'Purple (Analytics & Reporting)',
                    'orange' => 'Orange',
                ],
                'default_value' => 'green',
            ],
            [
                'key' => 'field_team_order',
                'label' => 'Display Order',
                'name' => 'team_order',
                'type' => 'number',
                'default_value' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'team_member',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // About Page Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_about_page',
        'title' => 'About Page Content',
        'fields' => [
            // Hero
            [
                'key' => 'field_about_hero_title',
                'label' => 'Hero Title',
                'name' => 'about_hero_title',
                'type' => 'text',
                'default_value' => 'About Us',
            ],
            [
                'key' => 'field_about_hero_text',
                'label' => 'Hero Text',
                'name' => 'about_hero_text',
                'type' => 'textarea',
                'rows' => 3,
            ],
            // Gallery Images
            [
                'key' => 'field_about_gallery',
                'label' => 'Team Gallery Images',
                'name' => 'about_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 3,
                'max' => 10,
            ],
            // Who We Are
            [
                'key' => 'field_about_who_title',
                'label' => 'Who We Are - Title',
                'name' => 'about_who_title',
                'type' => 'text',
            ],
            [
                'key' => 'field_about_who_text',
                'label' => 'Who We Are - Text',
                'name' => 'about_who_text',
                'type' => 'textarea',
                'rows' => 4,
            ],
            [
                'key' => 'field_about_highlight_title',
                'label' => 'Highlight Box - Title',
                'name' => 'about_highlight_title',
                'type' => 'text',
            ],
            [
                'key' => 'field_about_highlight_text',
                'label' => 'Highlight Box - Text',
                'name' => 'about_highlight_text',
                'type' => 'textarea',
                'rows' => 4,
            ],
            // Beliefs
            [
                'key' => 'field_about_beliefs_title',
                'label' => 'Beliefs Section Title',
                'name' => 'about_beliefs_title',
                'type' => 'text',
                'default_value' => 'What we actually believe in',
            ],
            [
                'key' => 'field_about_beliefs',
                'label' => 'Our Beliefs',
                'name' => 'about_beliefs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Belief',
                'sub_fields' => [
                    [
                        'key' => 'field_belief_title',
                        'label' => 'Title',
                        'name' => 'belief_title',
                        'type' => 'text',
                        'wrapper' => ['width' => '30'],
                    ],
                    [
                        'key' => 'field_belief_text',
                        'label' => 'Text',
                        'name' => 'belief_text',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => ['width' => '70'],
                    ],
                ],
            ],
            // Join Us Block
            [
                'key' => 'field_about_join_image',
                'label' => 'Join Us - Image',
                'name' => 'about_join_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_about_join_title',
                'label' => 'Join Us - Title',
                'name' => 'about_join_title',
                'type' => 'text',
                'default_value' => 'Join us',
            ],
            [
                'key' => 'field_about_join_text',
                'label' => 'Join Us - Text',
                'name' => 'about_join_text',
                'type' => 'textarea',
                'rows' => 3,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about.php',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // Job/Career Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_job',
        'title' => 'Job Details',
        'fields' => [
            [
                'key' => 'field_job_category_color',
                'label' => 'Category Badge Color',
                'name' => 'job_category_color',
                'type' => 'select',
                'choices' => [
                    'green' => 'Green (Creative & Design)',
                    'blue' => 'Blue (Campaign Management)',
                    'purple' => 'Purple (Analytics & Reporting)',
                    'orange' => 'Orange',
                    'red' => 'Red',
                ],
                'default_value' => 'green',
            ],
            [
                'key' => 'field_job_company',
                'label' => 'Company Name',
                'name' => 'job_company',
                'type' => 'text',
                'default_value' => 'Neamob Tech',
            ],
            [
                'key' => 'field_job_applications_count',
                'label' => 'Applications Count',
                'name' => 'job_applications_count',
                'type' => 'number',
                'default_value' => 0,
                'instructions' => 'This will be automatically updated when someone applies',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'job',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // FAQ Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_faq',
        'title' => 'FAQ Details',
        'fields' => [
            [
                'key' => 'field_faq_answer',
                'label' => 'Answer',
                'name' => 'faq_answer',
                'type' => 'wysiwyg',
                'required' => 1,
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'faq',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // Partner Logo Fields
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_partner',
        'title' => 'Partner Details',
        'fields' => [
            [
                'key' => 'field_partner_logo',
                'label' => 'Logo',
                'name' => 'partner_logo',
                'type' => 'image',
                'return_format' => 'url',
                'required' => 1,
                'instructions' => 'SVG or PNG, preferably light/white version for dark backgrounds',
            ],
            [
                'key' => 'field_partner_url',
                'label' => 'Website URL',
                'name' => 'partner_url',
                'type' => 'url',
            ],
            [
                'key' => 'field_partner_order',
                'label' => 'Display Order',
                'name' => 'partner_order',
                'type' => 'number',
                'default_value' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'partner',
                ],
            ],
        ],
    ]);

    // =========================================================================
    // Case Study Additional Fields (extend existing CPT)
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_case_study_acf',
        'title' => 'Case Study Details',
        'fields' => [
            [
                'key' => 'field_case_client_name',
                'label' => 'Client Name',
                'name' => 'client_name',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'key' => 'field_case_client_logo',
                'label' => 'Client Logo',
                'name' => 'client_logo',
                'type' => 'image',
                'return_format' => 'url',
            ],
            [
                'key' => 'field_case_badge_value',
                'label' => 'Badge Value',
                'name' => 'badge_value',
                'type' => 'text',
                'instructions' => 'e.g. +32%, +358%',
            ],
            [
                'key' => 'field_case_badge_text',
                'label' => 'Badge Text',
                'name' => 'badge_text',
                'type' => 'text',
                'instructions' => 'e.g. REVENUE, LEADS, ROI',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'case_study',
                ],
            ],
        ],
    ]);
}
add_action('acf/init', 'neamob_register_acf_fields');

// =========================================================================
// Helper Functions to get data
// =========================================================================

/**
 * Get testimonials
 */
function neamob_get_testimonials($count = -1) {
    return new WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => $count,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);
}

/**
 * Get services
 */
function neamob_get_services($count = -1) {
    return new WP_Query([
        'post_type' => 'service',
        'posts_per_page' => $count,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);
}

/**
 * Get partner logos
 */
function neamob_get_partners() {
    return new WP_Query([
        'post_type' => 'partner',
        'posts_per_page' => -1,
        'meta_key' => 'partner_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ]);
}

/**
 * Get FAQs
 */
function neamob_get_faqs($count = -1) {
    return new WP_Query([
        'post_type' => 'faq',
        'posts_per_page' => $count,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);
}

/**
 * Get Jobs
 */
function neamob_get_jobs($count = 10, $paged = 1) {
    return new WP_Query([
        'post_type' => 'job',
        'posts_per_page' => $count,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
}

/**
 * Increment job applications counter
 */
function neamob_increment_job_applications($job_id) {
    $current = (int) get_field('job_applications_count', $job_id);
    update_field('job_applications_count', $current + 1, $job_id);
}

