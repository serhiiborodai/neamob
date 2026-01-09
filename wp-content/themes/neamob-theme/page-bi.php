<?php
/**
 * Template Name: Business Intelligence Page
 */
get_header();

// Get ACF fields
$hero_title = get_field('bi_hero_title') ?: 'One infrastructure.<br>Every answer.';
$hero_text = get_field('bi_hero_text');
$hero_button_text = get_field('bi_hero_button_text') ?: "Let's Chat";
$hero_button_link = get_field('bi_hero_button_link') ?: '/contact';
$hero_stats = get_field('bi_hero_stats');

$overview_title = get_field('bi_overview_title');
$overview_text = get_field('bi_overview_text');
$overview_tags = get_field('bi_overview_tags');

$sections = get_field('bi_sections');

$apart_title = get_field('bi_apart_title') ?: 'What sets us apart';
$apart_text = get_field('bi_apart_text');
$apart_image = get_field('bi_apart_image');
?>

<main class="bi-page">
    <!-- Hero Section -->
    <section class="bi-hero">
        <div class="bi-hero__bg"></div>
        <div class="container">
            <div class="bi-hero__layout">
                <div class="bi-hero__content">
                    <h1 class="bi-hero__title"><?php echo wp_kses_post($hero_title); ?></h1>
                    <?php if ($hero_text): ?>
                        <p class="bi-hero__text"><?php echo wp_kses_post($hero_text); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($hero_button_link); ?>" class="bi-hero__btn">
                        <span class="btn-dot"></span>
                        <?php echo esc_html($hero_button_text); ?>
                    </a>
                </div>
                
                <div class="bi-hero__dashboard">
                    <!-- Stats Cards -->
                    <div class="bi-hero__stats">
                        <?php if ($hero_stats): foreach ($hero_stats as $stat): ?>
                            <div class="stat-box">
                                <span class="stat-box__label"><?php echo esc_html($stat['stat_label']); ?></span>
                                <span class="stat-box__value"><?php echo esc_html($stat['stat_value']); ?></span>
                                <?php if ($stat['stat_change']): ?>
                                    <span class="stat-box__change stat-box__change--<?php echo $stat['stat_change_type'] ?: 'up'; ?>">
                                        <?php echo esc_html($stat['stat_change']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="stat-box">
                                <span class="stat-box__label">Blended ROAS</span>
                                <span class="stat-box__value">1.42</span>
                                <span class="stat-box__change stat-box__change--up">↑ +25.7%</span>
                            </div>
                            <div class="stat-box">
                                <span class="stat-box__label">Holistic GPMA</span>
                                <span class="stat-box__value">$1,007,432</span>
                                <span class="stat-box__change stat-box__change--up">↑ +2.21%</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Dashboard Mockup -->
                    <div class="bi-hero__mockup">
                        <div class="mockup-card mockup-card--insights">
                            <span class="mockup-card__title">Campaign Insights</span>
                        </div>
                        <div class="mockup-card mockup-card--impressions">
                            <span class="mockup-card__label">Impressions</span>
                            <span class="mockup-card__value">12 M</span>
                            <div class="mockup-card__metrics">
                                <span>CPC: $0.56</span>
                                <span>CTR: 1.12%</span>
                            </div>
                        </div>
                        <div class="mockup-card mockup-card--report">
                            <span class="mockup-card__label">Performance Report Q4</span>
                            <span class="mockup-card__size">3.1 MB</span>
                            <div class="mockup-card__chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="bi-overview">
        <div class="container">
            <div class="bi-overview__layout">
                <span class="bi-overview__label">OVERVIEW</span>
                <div class="bi-overview__content">
                    <h2 class="bi-overview__title"><?php echo esc_html($overview_title ?: 'Infrastructure, not just dashboards'); ?></h2>
                    <p class="bi-overview__text"><?php echo wp_kses_post($overview_text ?: "We don't bolt dashboards onto broken data flows. We architect the entire pipeline: extraction, transformation, warehousing, modeling, visualization; so every metric is calculated consistently, updated automatically, and tied to a single source of truth."); ?></p>
                    
                    <?php 
                    $tags = $overview_tags ?: ['DATA INTEGRATION & ETL', 'CENTRALIZED WAREHOUSING', 'UNIFIED DEFINITIONS'];
                    if ($tags): 
                    ?>
                        <div class="bi-overview__tags">
                            <?php foreach ($tags as $tag): ?>
                                <span class="bi-tag"><?php echo esc_html(is_array($tag) ? $tag['tag_text'] : $tag); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <?php 
    $default_sections = [
        [
            'section_title' => 'Advanced measurement & Attribution',
            'section_items' => [
                ['item_title' => 'Multi-Touch & Algorithmic Attribution', 'item_text' => 'From position-based models to Marketing Mix Modeling (MMM) for measuring true channel incrementality, including brand and awareness efforts that traditional attribution misses.'],
                ['item_title' => 'Full-Funnel Tracking', 'item_text' => 'We capture the complete journey: impression through purchase and beyond. For sales-driven businesses, CRM integration connects marketing touchpoints to closed revenue, not just form fills.'],
                ['item_title' => 'Incrementality Testing', 'item_text' => 'Geo-lift studies, holdout experiments, and statistical methods that separate correlation from causation, so you know what\'s actually driving growth.'],
            ],
            'section_image' => '',
            'start_number' => 1,
        ],
        [
            'section_title' => 'Automation',
            'section_items' => [
                ['item_title' => 'Pipeline Automation', 'item_text' => 'End-to-end orchestration. Extraction, transformation, loading, and refresh all run without intervention. If something fails, alerts fire immediately.'],
                ['item_title' => 'Anomaly Detection & Alerting', 'item_text' => 'Spend pacing issues, conversion drops, ROAS thresholds breached—your system surfaces problems the moment they appear, not during weekly reviews.'],
                ['item_title' => 'Pacing & Forecasting', 'item_text' => "Automated tracking against targets plus forecasting models that project where you're headed. Know in week two whether the month is on track."],
            ],
            'section_image' => '',
            'start_number' => 4,
        ],
        [
            'section_title' => 'Reporting that drives action',
            'section_items' => [
                ['item_title' => 'Real-Time Dashboards', 'item_text' => 'Data refreshes automatically within hours. No weekly exports, no stale numbers.'],
                ['item_title' => 'Layered Views', 'item_text' => 'Executives see top-level KPIs. Channel managers drill into campaigns. Creative teams see asset performance. Everyone gets what they need.'],
                ['item_title' => 'Built-In Analysis', 'item_text' => 'Landing page comparisons, COGS breakdowns by product and geography, profitability models showing true margin after all costs.'],
            ],
            'section_image' => '',
            'start_number' => 7,
            'show_apart' => true,
        ],
    ];
    
    $sections_data = $sections ?: $default_sections;
    $item_number = 1;
    
    foreach ($sections_data as $section_index => $section): 
        $is_last = $section_index === count($sections_data) - 1;
    ?>
    <section class="bi-section <?php echo $is_last ? 'bi-section--with-apart' : ''; ?>">
        <div class="container">
            <h2 class="bi-section__title"><?php echo esc_html($section['section_title']); ?></h2>
            
            <div class="bi-section__items">
                <?php foreach ($section['section_items'] as $item): ?>
                    <div class="bi-section__item">
                        <span class="bi-section__number"><?php echo str_pad($item_number++, 2, '0', STR_PAD_LEFT); ?></span>
                        <div class="bi-section__item-content">
                            <h3 class="bi-section__item-title"><?php echo esc_html($item['item_title']); ?></h3>
                            <p class="bi-section__item-text"><?php echo esc_html($item['item_text']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($is_last): ?>
                <!-- What sets us apart -->
                <div class="bi-apart">
                    <div class="bi-apart__image">
                        <?php if ($apart_image): ?>
                            <img src="<?php echo esc_url($apart_image['url']); ?>" alt="<?php echo esc_attr($apart_image['alt']); ?>">
                        <?php else: ?>
                            <div class="bi-apart__placeholder"></div>
                        <?php endif; ?>
                    </div>
                    <div class="bi-apart__content">
                        <h2 class="bi-apart__title"><?php echo esc_html($apart_title); ?></h2>
                        <div class="bi-apart__text">
                            <?php echo wp_kses_post($apart_text ?: "<p>We're not an external vendor delivering static reports. Our BI infrastructure connects directly to our creative and campaign teams.</p><p>When data shows a creative fatiguing, our campaign team already knows. When attribution reveals an undervalued channel, budget shifts happen within days. Insights become action without the handoff delay.</p>"); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($section['section_image']): ?>
                <div class="bi-section__image">
                    <img src="<?php echo esc_url($section['section_image']['url']); ?>" alt="<?php echo esc_attr($section['section_image']['alt']); ?>">
                </div>
            <?php else: ?>
                <div class="bi-section__image">
                    <div class="bi-section__placeholder"></div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endforeach; ?>

</main>

<?php 
get_template_part('template-parts/contact-form');
get_footer(); 
?>

