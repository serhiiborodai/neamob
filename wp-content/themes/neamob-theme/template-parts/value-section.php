<?php
/**
 * Template Part: Value Section
 * Reusable block with laptop image and report tags
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get values from front page or use defaults
$front_page_id = get_option('page_on_front');

$value_title = get_field('value_title', $front_page_id) ?: 'We focus on what brings value & the bottom line';
$value_text = get_field('value_text', $front_page_id) ?: 'We transform raw data into insights with analytics, visualization, and infrastructure to drive smarter decisions and better performance.';
$value_button_text = get_field('value_button_text', $front_page_id) ?: 'Book Free Audit';
$value_button_url = get_field('value_button_link', $front_page_id) ?: '/contact';
$value_stats_text = get_field('value_stats_text', $front_page_id) ?: 'Built a targeting framework and ran keyword analysis for audience insights that resulted in';
$value_stats_number = get_field('value_stats_number', $front_page_id) ?: '+358%';
$value_stats_label = get_field('value_stats_label', $front_page_id) ?: 'Qualified Leads YoY';
$value_image = get_field('value_image', $front_page_id);
$value_tags = get_field('value_tags', $front_page_id);
?>

<!-- Value Section -->
<section class="value-section">
    <div class="container">
        <div class="value-section__grid">
            <div class="value-section__content">
                <h2 class="value-section__title"><?php echo esc_html($value_title); ?></h2>
                <p class="value-section__text"><?php echo esc_html($value_text); ?></p>
                <a href="#contact-form" class="btn btn--hero">
                    <span class="btn__dot"></span>
                    <span><?php echo esc_html($value_button_text); ?></span>
                </a>
            </div>
            <div class="value-section__visual">
                <div class="value-stats-card">
                    <p class="value-stats-card__text"><?php echo esc_html($value_stats_text); ?></p>
                    <div class="value-stats-card__number"><?php echo esc_html($value_stats_number); ?></div>
                    <div class="value-stats-card__label"><?php echo esc_html($value_stats_label); ?></div>
                </div>
                <div
                    class="value-laptop">
                    <?php if ($value_image): ?>
                        <img
                        src="<?php echo esc_url($value_image); ?>" alt="NeaMob Dashboard">
                    <?php else: ?>
                        <div class="value-laptop--placeholder">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/laptop.png" alt="Our Services" width="631" height="480" loading="lazy">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($value_tags): ?>
            <div class="value-reports">
                <p class="value-reports__label">Some of Our Reports</p>
                <div class="value-reports__tags">
                    <?php foreach ($value_tags as $tag):
                        $style = $tag['tag_style'] ?? 'default';
                        $icon_only = $tag['icon_only'] ?? false;
                        $class = 'report-tag';
                        if ($style === 'icon')
                            $class .= ' report-tag--icon';
                        if ($style === 'icon-alt')
                            $class .= ' report-tag--icon-alt';
                        ?>
                        <?php if ($icon_only): ?>
                                <span class="<?php echo esc_attr($class); ?>"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </span>
                        <?php else: ?>
                            <a class="<?php echo esc_attr($class); ?>"><?php echo esc_html($tag['tag_text']); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Default tags if none set -->
            <div class="value-reports">
                <p class="value-reports__label">Some of Our Reports</p>
                <div class="value-reports__tags">
                    <a class="report-tag">Forecasting</a>
                    <a class="report-tag">Profitability</a>
                    <a class="report-tag">Lifetime Value</a>
                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/chart.svg" alt="">
                    </span>
                    <a class="report-tag">Traffic Sources</a>
                    <a class="report-tag">Cost per Acquisition</a>
                    <a class="report-tag">Cash Flow</a>
                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/message.svg" alt="">
                    </span>
                    <a class="report-tag">Funnel Analysis</a>

                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/chart2.svg" alt="">
                    </span>
                    <a class="report-tag">Conversion Rates</a>
                    <a class="report-tag">Offline/Organic Tracking</a>
                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/increase.svg" alt="">
                    </span>
                    <a class="report-tag">Amazon and Shopify</a>
                    <a class="report-tag">Attribution</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

