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
        'supports'            => ['title', 'page-attributes'],
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
        'rewrite'             => ['slug' => 'service-items'],
        'capability_type'     => 'post',
        'has_archive'         => 'service-items',
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
            [
                'key' => 'field_hero_bg_image',
                'label' => 'Background Image',
                'name' => 'hero_bg_image',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Background image for hero section (recommended: WebP format)',
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
    // Why Choose Us (Front Page)
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_why_choose_us',
        'title' => 'Why Choose Us Section',
        'fields' => [
            [
                'key' => 'field_comparison_title',
                'label' => 'Title',
                'name' => 'comparison_title',
                'type' => 'text',
                'default_value' => 'Why choose NeaMob Tech?',
            ],
            [
                'key' => 'field_comparison_image',
                'label' => 'Comparison Table Image',
                'name' => 'comparison_image',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Desktop image. For mobile use compare-mobile.jpeg in assets.',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_type', 'operator' => '==', 'value' => 'front_page'],
            ],
        ],
        'menu_order' => 3,
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
            [
                'key' => 'field_testimonial_order',
                'label' => 'Display Order',
                'name' => 'testimonial_order',
                'type' => 'number',
                'default_value' => 0,
                'instructions' => 'Lower number = shown first',
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
                    'none' => 'None',
                    'purple' => 'Purple (Creative & Design)',
                    'green' => 'Green (Campaign Management)',
                    'blue' => 'Blue (Analytics & Reporting)',
                    'grey' => 'Grey (Default)',
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
            [
                'key' => 'field_team_photo',
                'label' => 'Photo',
                'name' => 'team_photo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Upload via Media Library. Replaces hardcoded placeholder.',
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
    // Department (taxonomy) — Badge Color
    // Поля видны при редактировании: Team Members → Departments → Edit
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_team_department',
        'title' => 'Department Settings',
        'fields' => [
            [
                'key' => 'field_dept_badge_color',
                'label' => 'Badge Color',
                'name' => 'dept_badge_color',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                    'purple' => 'Purple (Creative & Design)',
                    'green' => 'Green (Campaign Management)',
                    'blue' => 'Blue (Analytics & Reporting)',
                    'grey' => 'Grey (Default)',
                ],
                'default_value' => 'green',
                'instructions' => 'Color of the department badge on About Us slider. Overrides per-person color if set.',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'team_department',
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
                    'purple' => 'Purple (Creative & Design)',
                    'green' => 'Green (Campaign Management)',
                    'blue' => 'Blue (Analytics & Reporting)',
                    'grey' => 'Grey (Default)',
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
    // Post Category Color (for blog - same as job categories)
    // =========================================================================
    acf_add_local_field_group([
        'key' => 'group_category_color',
        'title' => 'Category Badge Color',
        'fields' => [
            [
                'key' => 'field_category_color',
                'label' => 'Badge Color',
                'name' => 'category_color',
                'type' => 'select',
                'choices' => [
                    'purple' => 'Purple (Creative & Design)',
                    'green' => 'Green (Campaign Management)',
                    'blue' => 'Blue (Analytics & Reporting)',
                    'grey' => 'Grey (Default)',
                ],
                'default_value' => 'blue',
                'instructions' => 'Color for the category badge on blog list and single post',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'category',
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
    // Partner Logo Fields (logo slider + Our Partners cards)
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
                'preview_size' => 'medium',
                'library' => 'all',
                'required' => 0,
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
            [
                'key' => 'field_partner_show_in_slider',
                'label' => 'Show in Logo Slider (Homepage)',
                'name' => 'partner_show_in_slider',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 0,
            ],
            [
                'key' => 'field_partner_show_in_cards',
                'label' => 'Show in Our Partners Section',
                'name' => 'partner_show_in_cards',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 0,
            ],
            [
                'key' => 'field_partner_description',
                'label' => 'Description (for Partners cards)',
                'name' => 'partner_description',
                'type' => 'textarea',
                'rows' => 3,
                'conditional_logic' => [[['field' => 'field_partner_show_in_cards', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_partner_card_type',
                'label' => 'Card Type',
                'name' => 'partner_card_type',
                'type' => 'select',
                'choices' => ['image' => 'Image', 'video' => 'Video'],
                'default_value' => 'image',
                'conditional_logic' => [[['field' => 'field_partner_show_in_cards', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key' => 'field_partner_image',
                'label' => 'Card Image',
                'name' => 'partner_image',
                'type' => 'image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        ['field' => 'field_partner_show_in_cards', 'operator' => '==', 'value' => '1'],
                        ['field' => 'field_partner_card_type', 'operator' => '==', 'value' => 'image'],
                    ],
                ],
            ],
            [
                'key' => 'field_partner_video_url',
                'label' => 'YouTube Video URL',
                'name' => 'partner_video_url',
                'type' => 'url',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
                'conditional_logic' => [
                    [
                        ['field' => 'field_partner_show_in_cards', 'operator' => '==', 'value' => '1'],
                        ['field' => 'field_partner_card_type', 'operator' => '==', 'value' => 'video'],
                    ],
                ],
            ],
            [
                'key' => 'field_partner_video_thumb',
                'label' => 'Video Thumbnail (fallback)',
                'name' => 'partner_video_thumb',
                'type' => 'image',
                'return_format' => 'url',
                'conditional_logic' => [
                    [
                        ['field' => 'field_partner_show_in_cards', 'operator' => '==', 'value' => '1'],
                        ['field' => 'field_partner_card_type', 'operator' => '==', 'value' => 'video'],
                    ],
                ],
            ],
            [
                'key' => 'field_partner_cta',
                'label' => 'CTA Button (optional)',
                'name' => 'partner_cta',
                'type' => 'link',
                'conditional_logic' => [[['field' => 'field_partner_show_in_cards', 'operator' => '==', 'value' => '1']]],
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
            [
                'key' => 'field_case_excerpt',
                'label' => 'Short Description',
                'name' => 'case_excerpt',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => 'br',
            ],
            [
                'key' => 'field_case_read_more_url',
                'label' => 'Read More URL',
                'name' => 'case_read_more_url',
                'type' => 'text',
                'instructions' => 'Custom URL for the "Read More" link. Leave empty to use the default case study page.',
            ],
            [
                'key' => 'field_case_tags',
                'label' => 'Tags',
                'name' => 'case_tags',
                'type' => 'repeater',
                'button_label' => 'Add Tag',
                'sub_fields' => [
                    [
                        'key' => 'field_case_tag_name',
                        'label' => 'Tag Name',
                        'name' => 'tag_name',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'key' => 'field_case_metrics',
                'label' => 'Metrics & Outcomes',
                'name' => 'case_metrics',
                'type' => 'repeater',
                'button_label' => 'Add Metric',
                'sub_fields' => [
                    [
                        'key' => 'field_metric_value',
                        'label' => 'Value',
                        'name' => 'metric_value',
                        'type' => 'text',
                        'placeholder' => '358%',
                        'wrapper' => ['width' => '30'],
                    ],
                    [
                        'key' => 'field_metric_description',
                        'label' => 'Description',
                        'name' => 'metric_description',
                        'type' => 'text',
                        'placeholder' => 'increase in Qualified Leads',
                        'wrapper' => ['width' => '70'],
                    ],
                ],
            ],
            [
                'key' => 'field_case_challenge',
                'label' => 'Challenge',
                'name' => 'case_challenge',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key' => 'field_case_solution',
                'label' => 'Solution',
                'name' => 'case_solution',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key' => 'field_case_what_we_did',
                'label' => 'What We Did (Services)',
                'name' => 'case_what_we_did',
                'type' => 'repeater',
                'button_label' => 'Add Service',
                'sub_fields' => [
                    [
                        'key' => 'field_service_name',
                        'label' => 'Service Name',
                        'name' => 'service_name',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'key' => 'field_case_results',
                'label' => 'Results',
                'name' => 'case_results',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key' => 'field_case_show_on_homepage',
                'label' => 'Show on Homepage',
                'name' => 'show_on_homepage',
                'type' => 'true_false',
                'ui' => 1,
                'instructions' => 'If enabled, this case study will appear on the homepage and will be hidden from the Case Studies archive page.',
            ],
            [
                'key' => 'field_case_homepage_description',
                'label' => 'Homepage Description',
                'name' => 'homepage_description',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => 'br',
                'instructions' => 'Text shown on the homepage card. Only used when "Show on Homepage" is enabled.',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_case_show_on_homepage',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
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
        'post_type'      => 'testimonial',
        'posts_per_page' => $count,
        'meta_query'     => [
            'relation' => 'OR',
            'order_clause' => [
                'key'     => 'testimonial_order',
                'compare' => 'EXISTS',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'testimonial_order',
                'compare' => 'NOT EXISTS',
            ],
        ],
        'orderby' => ['order_clause' => 'ASC'],
    ]);
}

/**
 * Get services (Service CPT — для админки и архивов)
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
 * Get service pages (дочерние страницы Services) — для главной, ссылки ведут на /services/xxx/
 */
function neamob_get_service_pages($count = -1) {
    $services_page = get_page_by_path('services');
    if (!$services_page) return new WP_Query(['post__in' => [0]]);
    return new WP_Query([
        'post_type' => 'page',
        'post_parent' => $services_page->ID,
        'posts_per_page' => $count,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => [
            ['key' => '_wp_page_template', 'value' => 'page-service.php'],
        ],
    ]);
}

/**
 * Get partner logos (all)
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
 * Get partners for logo slider (hp_color replacement)
 */
function neamob_get_partners_for_slider() {
    return get_posts([
        'post_type'      => 'partner',
        'posts_per_page' => -1,
        'meta_key'       => 'partner_order',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
        'meta_query'     => [
            [
                'key'     => 'partner_show_in_slider',
                'value'   => '1',
                'compare' => '=',
            ],
            [
                'key'     => 'partner_logo',
                'value'   => '',
                'compare' => '!=',
            ],
        ],
    ]);
}

/**
 * Get partners for Our Partners section cards
 */
function neamob_get_partners_for_cards() {
    $query = neamob_get_partners();
    $filtered = [];
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            if (get_field('partner_show_in_cards')) {
                $filtered[] = get_post();
            }
        }
        wp_reset_postdata();
    }
    return $filtered;
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

/**
 * Register ACF fields for Service Pages
 */
function neamob_register_service_page_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_service_page',
        'title' => 'Service Page Settings',
        'fields' => [
            // Accordion (Homepage What We Do) — уникальное имя, не дублирует group_service (CPT)
            [
                'key' => 'field_service_accordion_text',
                'label' => 'Accordion Text (Homepage)',
                'name' => 'service_accordion_text',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => 'Текст во вкладках блока What We Do на главной.',
            ],
            // Hero Section
            [
                'key' => 'field_service_hero_title',
                'label' => 'Hero Title',
                'name' => 'service_hero_title',
                'type' => 'text',
                'instructions' => 'Use <br> for line breaks',
            ],
            [
                'key' => 'field_service_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'service_hero_subtitle',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_service_accordion_image',
                'label' => 'Accordion Image (Homepage services section)',
                'name' => 'service_accordion_image',
                'type' => 'image',
                'return_format' => 'array',
                'instructions' => 'Image shown next to accordion on homepage',
            ],
            [
                'key' => 'field_service_hero_button_text',
                'label' => 'Button Text',
                'name' => 'service_hero_button_text',
                'type' => 'text',
                'default_value' => 'Let\'s Chat',
            ],
            [
                'key' => 'field_service_hero_button_link',
                'label' => 'Button Link',
                'name' => 'service_hero_button_link',
                'type' => 'text',
                'placeholder' => 'https://www.neamob.com/contact/',
            ],
            // Stats
            [
                'key' => 'field_service_show_stats',
                'label' => 'Show Stats Cards',
                'name' => 'service_show_stats',
                'type' => 'true_false',
                'ui' => 1,
            ],
            [
                'key' => 'field_service_stats',
                'label' => 'Stats Cards',
                'name' => 'service_stats',
                'type' => 'repeater',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_service_show_stats',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
                'sub_fields' => [
                    [
                        'key' => 'field_stat_value',
                        'label' => 'Value',
                        'name' => 'stat_value',
                        'type' => 'text',
                        'wrapper' => ['width' => '33'],
                    ],
                    [
                        'key' => 'field_stat_label',
                        'label' => 'Label',
                        'name' => 'stat_label',
                        'type' => 'text',
                        'wrapper' => ['width' => '33'],
                    ],
                    [
                        'key' => 'field_stat_color',
                        'label' => 'Background Color',
                        'name' => 'stat_color',
                        'type' => 'color_picker',
                        'wrapper' => ['width' => '33'],
                    ],
                ],
            ],
            // Overview
            [
                'key' => 'field_service_overview',
                'label' => 'Overview Text',
                'name' => 'service_overview',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            // What We Do
            [
                'key' => 'field_service_what_we_do',
                'label' => 'What We Do Items',
                'name' => 'service_what_we_do',
                'type' => 'repeater',
                'button_label' => 'Add Item',
                'sub_fields' => [
                    [
                        'key' => 'field_item_title',
                        'label' => 'Title',
                        'name' => 'item_title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_item_description',
                        'label' => 'Description',
                        'name' => 'item_description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            // What Sets Us Apart
            [
                'key' => 'field_service_apart_title',
                'label' => 'What Sets Us Apart - Title',
                'name' => 'service_apart_title',
                'type' => 'text',
                'default_value' => 'What sets us apart',
            ],
            [
                'key' => 'field_service_apart_text',
                'label' => 'What Sets Us Apart - Text',
                'name' => 'service_apart_text',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key' => 'field_service_apart_image',
                'label' => 'What Sets Us Apart - Image',
                'name' => 'service_apart_image',
                'type' => 'image',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-service.php',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ]);
}
add_action('acf/init', 'neamob_register_service_page_fields');

/**
 * Register Portfolio Items CPT
 */
function neamob_register_portfolio_items_cpt() {
    $labels = [
        'name'               => __('Portfolio Items', 'neamob-theme'),
        'singular_name'      => __('Portfolio Item', 'neamob-theme'),
        'menu_name'          => __('Portfolio', 'neamob-theme'),
        'add_new'            => __('Add New', 'neamob-theme'),
        'add_new_item'       => __('Add New Portfolio Item', 'neamob-theme'),
        'edit_item'          => __('Edit Portfolio Item', 'neamob-theme'),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => false, // Скрыто: портфолио редактируется через страницу Portfolio и её ACF (галерея, блоки)
        'query_var'           => true,
        'rewrite'             => ['slug' => 'portfolio-item'],
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => ['title', 'editor', 'thumbnail'],
        'show_in_rest'        => true,
    ];

    register_post_type('portfolio_item', $args);
}
add_action('init', 'neamob_register_portfolio_items_cpt');

/**
 * Register ACF fields for Portfolio Items and Portfolio Page
 */
function neamob_register_portfolio_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Portfolio Item fields
    acf_add_local_field_group([
        'key' => 'group_portfolio_item',
        'title' => 'Portfolio Item Settings',
        'fields' => [
            [
                'key' => 'field_portfolio_ctr',
                'label' => 'CTR Value',
                'name' => 'portfolio_ctr',
                'type' => 'text',
                'placeholder' => '2.4%',
            ],
            [
                'key' => 'field_portfolio_category',
                'label' => 'Category',
                'name' => 'portfolio_category',
                'type' => 'select',
                'choices' => [
                    'All' => 'All',
                    'Static' => 'Static',
                    'Video' => 'Video',
                    'UGC-Video' => 'UGC-Video',
                ],
                'default_value' => 'All',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'portfolio_item',
                ],
            ],
        ],
    ]);

    // Portfolio Page fields
    acf_add_local_field_group([
        'key' => 'group_portfolio_page',
        'title' => 'Portfolio Page Settings',
        'fields' => [
            [
                'key' => 'field_portfolio_title',
                'label' => 'Page Title',
                'name' => 'portfolio_title',
                'type' => 'text',
                'default_value' => 'Portfolio',
            ],
            [
                'key' => 'field_portfolio_description',
                'label' => 'Description',
                'name' => 'portfolio_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_portfolio_categories',
                'label' => 'Filter Categories (comma separated)',
                'name' => 'portfolio_categories',
                'type' => 'text',
                'default_value' => 'All, Static, Video, UGC-Video',
            ],
            [
                'key' => 'field_portfolio_gallery',
                'label' => 'Hero Gallery Images',
                'name' => 'portfolio_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Images for the hero gallery strip. If empty, falls back to default images.',
            ],
            [
                'key' => 'field_portfolio_blocks',
                'label' => 'Content Blocks',
                'name' => 'portfolio_blocks',
                'type' => 'repeater',
                'button_label' => 'Add Block',
                'sub_fields' => [
                    [
                        'key' => 'field_block_label',
                        'label' => 'Label',
                        'name' => 'block_label',
                        'type' => 'text',
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_block_layout',
                        'label' => 'Layout',
                        'name' => 'block_layout',
                        'type' => 'select',
                        'choices' => [
                            'two_images' => 'Two Images',
                            'single_image' => 'Single Image',
                            'video' => 'Video',
                        ],
                        'wrapper' => ['width' => '50'],
                    ],
                    [
                        'key' => 'field_block_title',
                        'label' => 'Title',
                        'name' => 'block_title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_block_text',
                        'label' => 'Text',
                        'name' => 'block_text',
                        'type' => 'textarea',
                        'rows' => 4,
                    ],
                    [
                        'key' => 'field_block_link',
                        'label' => 'Link',
                        'name' => 'block_link',
                        'type' => 'link',
                    ],
                    [
                        'key' => 'field_block_image_1',
                        'label' => 'Image 1',
                        'name' => 'block_image_1',
                        'type' => 'image',
                        'return_format' => 'array',
                    ],
                    [
                        'key' => 'field_block_image_2',
                        'label' => 'Image 2 (for two images layout)',
                        'name' => 'block_image_2',
                        'type' => 'image',
                        'return_format' => 'array',
                        'conditional_logic' => [
                            [
                                [
                                    'field' => 'field_block_layout',
                                    'operator' => '==',
                                    'value' => 'two_images',
                                ],
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_block_video_url',
                        'label' => 'YouTube Video URL',
                        'name' => 'block_video_url',
                        'type' => 'url',
                        'conditional_logic' => [
                            [
                                [
                                    'field' => 'field_block_layout',
                                    'operator' => '==',
                                    'value' => 'video',
                                ],
                            ],
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
                    'value' => 'page-portfolio.php',
                ],
            ],
        ],
    ]);
}
add_action('acf/init', 'neamob_register_portfolio_fields');

/**
 * Theme Options (Careers, Blog, Footer, Contact Form)
 * Uses ACF Options if available, else fallback to defaults
 */
function neamob_register_theme_options() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    acf_add_options_page([
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ]);

    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    acf_add_local_field_group([
        'key' => 'group_theme_options',
        'title' => 'Theme Settings',
        'fields' => [
            [
                'key' => 'field_tab_careers',
                'label' => 'Careers Page',
                'name' => '',
                'type' => 'tab',
            ],
            [
                'key' => 'field_careers_hero_title',
                'label' => 'Hero Title',
                'name' => 'careers_hero_title',
                'type' => 'text',
                'default_value' => 'Join Us',
            ],
            [
                'key' => 'field_careers_hero_text',
                'label' => 'Hero Text',
                'name' => 'careers_hero_text',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "We're searching for people who are ready for a new challenge, love collaborating, and value our culture of transparency to join our team.",
            ],
            [
                'key' => 'field_tab_blog',
                'label' => 'Blog Page',
                'name' => '',
                'type' => 'tab',
            ],
            [
                'key' => 'field_blog_hero_title',
                'label' => 'Hero Title',
                'name' => 'blog_hero_title',
                'type' => 'text',
                'default_value' => 'Blog',
            ],
            [
                'key' => 'field_tab_contact',
                'label' => 'Contact Form',
                'name' => '',
                'type' => 'tab',
            ],
            [
                'key' => 'field_contact_form_title',
                'label' => 'Title',
                'name' => 'contact_form_title',
                'type' => 'text',
                'default_value' => 'Get in touch',
            ],
            [
                'key' => 'field_contact_form_text',
                'label' => 'Description',
                'name' => 'contact_form_text',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Ready to take your marketing to the next level? Fill out the form and our team will get back to you within 48 hours.",
            ],
            [
                'key' => 'field_tab_footer',
                'label' => 'Footer & Header',
                'name' => '',
                'type' => 'tab',
            ],
            [
                'key' => 'field_header_cta_text',
                'label' => 'Header CTA Button Text',
                'name' => 'header_cta_text',
                'type' => 'text',
                'default_value' => "Let's Chat",
            ],
            [
                'key' => 'field_header_cta_url',
                'label' => 'Header CTA Button URL',
                'name' => 'header_cta_url',
                'type' => 'url',
                'default_value' => '/contact',
            ],
            [
                'key' => 'field_footer_email',
                'label' => 'Footer Email',
                'name' => 'footer_email',
                'type' => 'email',
                'default_value' => 'info@neamob.com',
            ],
            [
                'key' => 'field_footer_social_facebook',
                'label' => 'Facebook URL',
                'name' => 'footer_social_facebook',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_social_instagram',
                'label' => 'Instagram URL',
                'name' => 'footer_social_instagram',
                'type' => 'url',
            ],
            [
                'key' => 'field_footer_social_linkedin',
                'label' => 'LinkedIn URL',
                'name' => 'footer_social_linkedin',
                'type' => 'url',
            ],
        ],
        'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'theme-settings']]],
    ]);
}
add_action('acf/init', 'neamob_register_theme_options');

/**
 * Get category badge color for blog (from ACF term field or slug fallback)
 */
function neamob_get_category_color($category) {
    if (!$category || !is_object($category)) {
        return 'grey';
    }
    $color = get_field('category_color', 'category_' . $category->term_id);
    if ($color) {
        return $color;
    }
    $slug = $category->slug ?? '';
    if (strpos($slug, 'analytics') !== false) return 'blue';
    if (strpos($slug, 'creative') !== false) return 'purple';
    if (strpos($slug, 'campaign') !== false) return 'green';
    return 'grey';
}

/**
 * Get theme option with fallback (works without ACF Options)
 */
function neamob_get_theme_option($key, $default = '') {
    $val = function_exists('get_field') ? get_field($key, 'option') : null;
    return $val !== null && $val !== '' ? $val : $default;
}

/**
 * НЕ синхронизировать ACF field groups в БД.
 * Поля зарегистрированы через acf_add_local_field_group() в PHP — они работают без записи в БД.
 * Запись в БД создавала тысячи дубликатов и вешала админку.
 */

