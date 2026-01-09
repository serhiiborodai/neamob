<?php
/**
 * Single Case Study template - Split layout
 */
get_header();

// Get ACF fields
$tags = get_field('case_tags') ?: [];
$case_excerpt = get_field('case_excerpt');
$metrics = get_field('case_metrics') ?: [];
$challenge = get_field('case_challenge');
$solution = get_field('case_solution');
$what_we_did = get_field('case_what_we_did') ?: [];
$results = get_field('case_results');
?>

<main class="single-case">
    <div class="single-case__layout">
        <!-- Left: Content -->
        <div class="single-case__content">
            <div class="single-case__inner">
                <!-- Header -->
                <header class="single-case__header">
                    <h1 class="single-case__title"><?php the_title(); ?></h1>
                    
                    <?php if ($case_excerpt): ?>
                        <p class="single-case__excerpt"><?php echo esc_html($case_excerpt); ?></p>
                    <?php endif; ?>

                    <?php if ($tags): ?>
                        <div class="single-case__tags">
                            <?php foreach ($tags as $tag): ?>
                                <span class="case-tag"><?php echo esc_html(is_array($tag) ? $tag['tag_name'] : $tag); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Metrics -->
                <?php if ($metrics): ?>
                <section class="single-case__section">
                    <h2 class="single-case__label">METRICS & OUTCOMES</h2>
                    <div class="case-metrics">
                        <?php foreach ($metrics as $metric): ?>
                            <div class="case-metric">
                                <span class="case-metric__value"><?php echo esc_html($metric['metric_value']); ?></span>
                                <span class="case-metric__text"><?php echo esc_html($metric['metric_description']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Challenge -->
                <?php if ($challenge): ?>
                <section class="single-case__section">
                    <h2 class="single-case__label">CHALLENGE</h2>
                    <div class="single-case__text">
                        <?php echo wp_kses_post($challenge); ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Solution -->
                <?php if ($solution): ?>
                <section class="single-case__section">
                    <h2 class="single-case__label">SOLUTION</h2>
                    <div class="single-case__text">
                        <?php echo wp_kses_post($solution); ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- What We Did -->
                <?php if ($what_we_did): ?>
                <section class="single-case__section">
                    <h2 class="single-case__label">WHAT WE DID</h2>
                    <div class="case-services">
                        <?php foreach ($what_we_did as $service): ?>
                            <span class="case-service-tag"><?php echo esc_html(is_array($service) ? $service['service_name'] : $service); ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Results -->
                <?php if ($results): ?>
                <section class="single-case__section">
                    <h2 class="single-case__label">RESULTS</h2>
                    <div class="single-case__text">
                        <?php echo wp_kses_post($results); ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Navigation -->
                <nav class="single-case__nav">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <a href="<?php echo get_post_type_archive_link('case_study'); ?>" class="case-nav-back">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        All Case Studies
                    </a>

                    <div class="case-nav-arrows">
                        <?php if ($prev_post): ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="case-nav-arrow" title="<?php echo esc_attr($prev_post->post_title); ?>">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M12 15L7 10L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($next_post): ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>" class="case-nav-arrow" title="<?php echo esc_attr($next_post->post_title); ?>">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M8 5L13 10L8 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Right: Image (Sticky) -->
        <div class="single-case__image">
            <div class="single-case__image-sticky">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('full'); ?>
                <?php else: ?>
                    <div class="single-case__placeholder"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php 
get_template_part('template-parts/contact-form');
get_footer(); 
?>
