<?php
/**
 * Template Name: Home (Redesign)
 * Admin-only preview copy for homepage redesign.
 * Uses ACF fields for dynamic content.
 *
 * @package Neamob_Theme
 */

get_header();

// Get ACF fields with defaults
$hero_title = get_field('hero_title') ?: 'We make the <em>complex</em> simple';
// Figma: "complex" = Playfair Display Medium Italic — wrap if ACF has plain text
if (is_string($hero_title) && stripos($hero_title, '<em') === false) {
    $hero_title = preg_replace('/\bcomplex\b/i', '<em>$0</em>', $hero_title, 1);
}
// Mockup stacks title as two lines: "We make the" / "complex simple"
if (is_string($hero_title) && strpos($hero_title, '<br') === false && preg_match('/^(.*?)\s+(<em>.*?<\/em>\s*.*)$/s', $hero_title, $hero_title_parts)) {
    $hero_title = '<span class="hero-section__title-line">' . $hero_title_parts[1] . '</span>'
        . '<span class="hero-section__title-line">' . $hero_title_parts[2] . '</span>';
} elseif (is_string($hero_title) && strpos($hero_title, '<br') !== false) {
    $hero_title = preg_replace(
        '/<br\s*\/?>/i',
        '</span><span class="hero-section__title-line">',
        '<span class="hero-section__title-line">' . $hero_title . '</span>'
    );
}
$hero_text = get_field('hero_text') ?: 'Data-driven strategy, measured in outcomes: revenue, qualified leads, cost per lead. Not reports — results.';
$hero_button_text = get_field('hero_button_text') ?: 'Book a Free Audit';
$hero_button_link = get_field('hero_button_link');
$hero_button_url = $hero_button_link ? $hero_button_link['url'] : '#contact-form';
$hero_bg_image = get_field('hero_bg_image');
$hero_stats = get_field('hero_stats');
if (empty($hero_stats) || !is_array($hero_stats)) {
    // Defaults match Figma hp update → first-screen stats (node 6601:31395)
    $hero_stats = [
        ['stat_value' => '+210%', 'stat_label' => 'Monthly revenue growth', 'stat_source' => 'Sensibo · 6 months'],
        ['stat_value' => '+468%', 'stat_label' => 'Monthly qualified leads', 'stat_source' => 'CCFA · Q1–Q2 2025'],
        ['stat_value' => '4.2x', 'stat_label' => 'ROAS on paid social', 'stat_source' => 'Weber · Meta Ads'],
        ['stat_value' => '+194%', 'stat_label' => 'Monthly installs', 'stat_source' => 'RecApp · iOS launch'],
    ];
}
$logo_wall_title = get_field('logo_wall_title') ?: 'Growth partners, past and present';
$services_section_title = get_field('services_section_title') ?: 'Our services';
$cta_short_title = get_field('cta_short_title') ?: 'Ready to see your numbers grow?';
$cta_short_text = get_field('cta_short_text') ?: 'Fill out the form and our team will get back to you within 48 hours.';
$faq_cta_text = get_field('faq_cta_text') ?: 'Book a Free Audit';
$faq_cta_link = get_field('faq_cta_link');
$faq_cta_url = ($faq_cta_link && !empty($faq_cta_link['url'])) ? $faq_cta_link['url'] : '#contact-form';
$value_report_groups = get_field('value_report_groups');
if (empty($value_report_groups) || !is_array($value_report_groups)) {
    $value_report_groups = [
        ['group_title' => 'Money', 'group_items' => 'Profitability · Cash Flow · Lifetime value · Cost per Acquisition'],
        ['group_title' => 'Channels', 'group_items' => 'Amazon and Shopify · Offline/Organic Tracking'],
        ['group_title' => 'Growth', 'group_items' => 'Forecasting · Funnel Analysis · Traffic Sources · Attribution'],
    ];
}
$icon_base = get_template_directory_uri() . '/assets/icons/redesign/';
$hero_bg_default = get_template_directory_uri() . '/assets/images/hp.webp';
$hero_bg_mobile = get_template_directory_uri() . '/assets/images/hp-mobile.webp';
$hero_bg_mobile_fallback = get_template_directory_uri() . '/assets/images/hp-mobile.png';

$value_title = get_field('value_title') ?: 'We focus on what brings value & the bottom line';
$value_text = get_field('value_text') ?: 'We transform raw data into insights with analytics, visualization, and infrastructure to drive smarter decisions and better performance.';
$value_button_text = get_field('value_button_text') ?: 'Book Free Audit';
$value_button_link = get_field('value_button_link');
$value_button_url = $value_button_link ? $value_button_link['url'] : '/contact';
$value_stats_text = get_field('value_stats_text') ?: 'Built a targeting framework and ran keyword analysis for audience insights that resulted in';
$value_stats_number = get_field('value_stats_number') ?: '+358%';
$value_stats_label = get_field('value_stats_label') ?: 'Qualified Leads YoY';
$value_image = get_field('value_image');
$value_tags = get_field('value_tags');
?>

<!-- Hero Section (Redesign) -->
<section class="hero-section hero-section--v2">
    <div class="hero-section__bg">
        <?php $bg_url = $hero_bg_image ?: $hero_bg_default; ?>
        <picture>
            <source media="(max-width: 750px)" srcset="<?php echo esc_url($hero_bg_mobile); ?>" type="image/webp">
            <source media="(max-width: 750px)" srcset="<?php echo esc_url($hero_bg_mobile_fallback); ?>">
            <img src="<?php echo esc_url($bg_url); ?>" alt="" class="hero-section__bg-img" width="3024" height="1680" fetchpriority="high">
        </picture>
    </div>
    <div class="container">
        <div class="hero-section__grid">
            <div class="hero-section__content">
                <h1 class="hero-section__title"><?php echo wp_kses($hero_title, ['em' => [], 'br' => [], 'span' => ['class' => true]]); ?></h1>
                <p class="hero-section__text"><?php echo esc_html($hero_text); ?></p>
                <a href="<?php echo esc_url($hero_button_url); ?>" class="btn btn--hero btn--hero-v2">
                    <span class="btn__dot"></span>
                    <span><?php echo esc_html($hero_button_text); ?></span>
                </a>
            </div>
            <?php if (!empty($hero_stats)): ?>
            <div class="hero-section__stats">
                <?php foreach ($hero_stats as $stat):
                    $value = trim($stat['stat_value'] ?? '');
                    $label = trim($stat['stat_label'] ?? '');
                    $source = trim($stat['stat_source'] ?? '');
                    if ($value === '' && $label === '') {
                        continue;
                    }
                ?>
                <article class="hero-stat-card">
                    <?php if ($value): ?>
                        <div class="hero-stat-card__value"><?php echo esc_html($value); ?></div>
                    <?php endif; ?>
                    <?php if ($label): ?>
                        <div class="hero-stat-card__label"><?php echo esc_html($label); ?></div>
                    <?php endif; ?>
                    <?php if ($source): ?>
                        <div class="hero-stat-card__source"><?php echo esc_html($source); ?></div>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Client Logo Wall -->
<?php
$client_logos = neamob_get_client_logos();
if (!empty($client_logos)):
?>
<section class="logo-wall">
    <div class="container">
        <p class="logo-wall__title"><?php echo esc_html($logo_wall_title); ?></p>
        <div class="logo-wall__grid">
            <?php foreach ($client_logos as $logo_post):
                $logo_url = get_the_post_thumbnail_url($logo_post->ID, 'medium');
                if (!$logo_url) {
                    continue;
                }
                $link = get_field('client_logo_url', $logo_post->ID);
            ?>
            <div class="logo-wall__item">
                <?php if ($link): ?>
                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(add_query_arg('v', '2', $logo_url)); ?>" alt="<?php echo esc_attr($logo_post->post_title); ?>" loading="lazy">
                    </a>
                <?php else: ?>
                    <img src="<?php echo esc_url(add_query_arg('v', '2', $logo_url)); ?>" alt="<?php echo esc_attr($logo_post->post_title); ?>" loading="lazy">
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Services Section (Redesign grid) -->
<?php
$service_pages = neamob_get_redesign_service_pages();
if (!empty($service_pages)):
?>
<section class="services-section-v2">
    <div class="container">
        <div class="services-section-v2__layout">
            <h2 class="services-section-v2__title"><?php echo esc_html($services_section_title); ?></h2>
            <div class="services-section-v2__grid">
                <?php foreach ($service_pages as $service_page):
                    $pid = $service_page->ID;
                    $slug = $service_page->post_name;
                    $icon = neamob_get_service_card_icon($slug);
                    $short_desc = get_field('service_short_description', $pid)
                        ?: get_field('service_hero_subtitle', $pid)
                        ?: get_the_excerpt($pid);
                    if (empty($short_desc)) {
                        $cnt = get_post_field('post_content', $pid);
                        $short_desc = $cnt ? wp_trim_words(strip_tags($cnt), 35, '') : '';
                    }
                ?>
                <article class="service-card-v2">
                    <div class="service-card-v2__icon" style="--icon-bg: <?php echo esc_attr($icon['bg']); ?>">
                        <img src="<?php echo esc_url($icon['url']); ?>" alt="" width="24" height="24" loading="lazy">
                    </div>
                    <h3 class="service-card-v2__title"><?php echo esc_html(get_the_title($pid)); ?></h3>
                    <p class="service-card-v2__text"><?php echo esc_html($short_desc); ?></p>
                    <a href="<?php echo esc_url(get_permalink($pid)); ?>" class="service-card-v2__link">
                        <span class="service-card-v2__link-dot"></span>
                        Read More
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Short Form (Redesign) — after Services, before BI -->
<?php get_template_part('template-parts/cta-short-form'); ?>

<?php get_template_part('template-parts/home-v2/sections'); ?>

<div class="video-overlay" id="video-overlay">
    <div class="video-overlay__backdrop"></div>
    <div class="video-overlay__container">
        <button type="button" class="video-overlay__close" aria-label="Close">&times;</button>
        <video class="video-overlay__player" playsinline preload="metadata">
            <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/snappper.webm'); ?>" type="video/webm">
        </video>
    </div>
</div>

<!-- Case Study Download Form (overlay) -->
<div class="case-study-form-overlay" id="case-study-form-overlay">
    <div class="case-study-form-overlay__backdrop"></div>
    <div class="case-study-form-overlay__form">
        <button type="button" class="case-study-form-overlay__close" aria-label="Close">&times;</button>
        <h3 class="case-study-form-overlay__title">Download Case Study</h3>
        <p class="case-study-form-overlay__text">Enter your details to access the presentation.</p>
        <?php
        if (class_exists('WPCF7')) {
            echo do_shortcode('[contact-form-7 id="6261" title="Case Study Download"]');
        }
        ?>
    </div>
</div>

<!-- Contact Form Section -->
<?php get_template_part('template-parts/contact-form-v2'); ?>

<?php get_footer(); ?>

