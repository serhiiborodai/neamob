<?php
/**
 * Template Name: Service Page
 * Template for individual service pages
 */
get_header();

// Get ACF fields
$hero_title = get_field('service_hero_title') ?: get_the_title();
$hero_subtitle = get_field('service_hero_subtitle');
$hero_button_text = get_field('service_hero_button_text') ?: 'Let\'s Chat';
$hero_button_link = get_field('service_hero_button_link') ?: '/contact';

// Hero image (optional - ACF or static based on slug)
$hero_image = get_field('service_hero_image');
$page_slug = get_post_field('post_name', get_post());
$static_images = [
    'growth-strategy-planning' => 'growth-strategy.png',
    'data-analytics-insights' => 'data-analytics.png',
    'creative-design' => 'creative-design.png',
    'media-campaigns' => 'media-campaigns.png',
];
$static_hero_image = isset($static_images[$page_slug]) ? get_template_directory_uri() . '/assets/images/services/' . $static_images[$page_slug] : '';

// Stats cards (optional, fallback if no image)
$show_stats = get_field('service_show_stats');
$stats = get_field('service_stats');

// Overview
$overview_text = get_field('service_overview');

// What we do items
$what_we_do_items = get_field('service_what_we_do');

// What sets us apart
$apart_title = get_field('service_apart_title') ?: 'What sets us apart';
$apart_text = get_field('service_apart_text');
$apart_image = get_field('service_apart_image');
?>

<main class="service-page">
    <!-- Hero Section -->
    <section class="service-hero">
        <div class="service-hero__bg">
            <!-- Grid dots pattern -->
            <div class="service-hero__grid"></div>
        </div>
        
        <div class="container">
            <div class="service-hero__content">
                <div class="service-hero__text">
                    <h1 class="service-hero__title"><?php echo wp_kses_post($hero_title); ?></h1>
                    <?php if ($hero_subtitle): ?>
                        <p class="service-hero__subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($hero_button_link); ?>" class="service-hero__btn">
                        <span class="btn-dot"></span>
                        <?php echo esc_html($hero_button_text); ?>
                    </a>
                </div>
                
                <?php if ($hero_image): ?>
                <div class="service-hero__image">
                    <img src="<?php echo esc_url($hero_image['url']); ?>" alt="<?php echo esc_attr($hero_image['alt']); ?>">
                </div>
                <?php elseif ($static_hero_image): ?>
                <div class="service-hero__image">
                    <img src="<?php echo esc_url($static_hero_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <?php if ($overview_text): ?>
    <section class="service-overview">
        <div class="container">
            <div class="service-overview__layout">
                <div class="service-overview__label">OVERVIEW</div>
                <div class="service-overview__text">
                    <?php echo wp_kses_post($overview_text); ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- What We Do Section -->
    <?php if ($what_we_do_items): ?>
    <section class="service-whatwedo">
        <div class="container">
            <h2 class="service-whatwedo__title">What we do</h2>
            
            <div class="service-whatwedo__list">
                <?php foreach ($what_we_do_items as $index => $item): ?>
                <div class="service-whatwedo__item">
                    <span class="service-whatwedo__number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                    <div class="service-whatwedo__content">
                        <h3 class="service-whatwedo__item-title"><?php echo esc_html($item['item_title']); ?></h3>
                        <p class="service-whatwedo__item-text"><?php echo esc_html($item['item_description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- What Sets Us Apart Section -->
    <?php if ($apart_text): ?>
    <section class="service-apart">
        <div class="container">
            <div class="service-apart__layout">
                <div class="service-apart__image">
                    <?php if ($apart_image): ?>
                        <img src="<?php echo esc_url($apart_image['url']); ?>" alt="<?php echo esc_attr($apart_image['alt'] ?: $apart_title); ?>">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/apart-image.png" alt="<?php echo esc_attr($apart_title); ?>">
                    <?php endif; ?>
                </div>
                <div class="service-apart__content">
                    <h2 class="service-apart__title"><?php echo esc_html($apart_title); ?></h2>
                    <div class="service-apart__text">
                        <?php echo wp_kses_post($apart_text); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php 
// Contact Form before footer
get_template_part('template-parts/contact-form');

get_footer(); 
?>

