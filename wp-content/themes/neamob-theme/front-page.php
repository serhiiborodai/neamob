<?php
/**
 * Front Page Template
 * Uses ACF fields for dynamic content
 *
 * @package Neamob_Theme
 */

get_header();

// Get ACF fields with defaults
$hero_title = get_field('hero_title') ?: 'We make the<br>complex simple';
$hero_text = get_field('hero_text') ?: 'At NeaMob Tech we specialize in transforming complex data into clear insights and compelling actionable strategies.';
$hero_button_text = get_field('hero_button_text') ?: "Let's Chat";
$hero_button_link = get_field('hero_button_link');
$hero_button_url = $hero_button_link ? $hero_button_link['url'] : '/contact';
$hero_bg_image = get_field('hero_bg_image');

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

<!-- Hero Section -->
<section class="hero-section">
    <div
        class="hero-section__bg">
        <?php
        $bg_url = $hero_bg_image ?: get_template_directory_uri() . '/assets/images/hp.webp';
        ?>
        <img src="<?php echo esc_url($bg_url); ?>" alt="" class="hero-section__bg-img">
    </div>
    <div class="container">
        <div class="hero-section__content">
            <h1 class="hero-section__title"><?php echo wp_kses_post($hero_title); ?></h1>
            <p class="hero-section__text"><?php echo esc_html($hero_text); ?></p>
            <a href="<?php echo esc_url($hero_button_url); ?>" class="btn btn--hero">
                <span class="btn__dot"></span>
                <span><?php echo esc_html($hero_button_text); ?></span>
            </a>
        </div>
    </div>
</section>

<!-- Logo Slider -->
<?php
$logos_dir = get_template_directory() . '/assets/logos/hp_color/';
$logos_url = get_template_directory_uri() . '/assets/logos/hp_color/';
$logo_files = glob($logos_dir . '*.{png,svg,jpg,jpeg}', GLOB_BRACE);

if (!empty($logo_files)):
?>
    <section class="logo-slider">
        <div class="logo-slider__bg"></div>
        <div class="logo-slider__track">
            <div class="logo-slider__group">
                <?php foreach ($logo_files as $logo_path): 
                    $filename = basename($logo_path);
                    $alt = pathinfo($filename, PATHINFO_FILENAME);
                ?>
                    <div class="logo-slider__item">
                        <img src="<?php echo esc_url($logos_url . rawurlencode($filename)); ?>" alt="<?php echo esc_attr($alt); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="logo-slider__group">
                <?php foreach ($logo_files as $logo_path): 
                    $filename = basename($logo_path);
                    $alt = pathinfo($filename, PATHINFO_FILENAME);
                ?>
                    <div class="logo-slider__item">
                        <img src="<?php echo esc_url($logos_url . rawurlencode($filename)); ?>" alt="<?php echo esc_attr($alt); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Services Section (What We Do) -->
<?php
$services = neamob_get_services();
if ($services->have_posts()):
    ?>
        <section class="services-section"> <div class="container">
            <p class="services-section__label">What We Do</p>
            <div class="services-section__grid">
                <div class="services-section__content">
                    <div class="services-accordion">
                        <?php $first = true; ?>
                        <?php while ($services->have_posts()):
                            $services->the_post();
                            $short_desc = get_field('service_short_description') ?: get_the_excerpt();
                            ?>
                                <div class="services-accordion__item<?php echo $first ? ' is-active' : ''; ?>"> <div class="services-accordion__header">
                                    <div class="services-accordion__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                    <h3 class="services-accordion__title"><?php the_title(); ?></h3>
                                </div>
                                <div class="services-accordion__body">
                                    <div class="services-accordion__body-inner">
                                        <p class="services-accordion__text"><?php echo esc_html($short_desc); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="services-accordion__link">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            <?php $first = false; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="services-section__media">
                    <div class="services-section__image">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/services-preview.jpg" alt="Our Services">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
endif;
?>

<!-- Value Section -->
<section class="value-section">
    <div class="container">
        <div class="value-section__grid">
            <div class="value-section__content">
                <h2 class="value-section__title"><?php echo esc_html($value_title); ?></h2>
                <p class="value-section__text"><?php echo esc_html($value_text); ?></p>
                <a href="<?php echo esc_url($value_button_url); ?>" class="btn btn--hero">
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
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/laptop.png" alt="Our Services">
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
                            <a href="#" class="<?php echo esc_attr($class); ?>"><?php echo esc_html($tag['tag_text']); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Default tags if none set -->
            <div class="value-reports">
                <p class="value-reports__label">Some of Our Reports</p>
                <div class="value-reports__tags">
                    <a href="#" class="report-tag">Forecasting</a>
                    <a href="#" class="report-tag">Profitability</a>
                    <a href="#" class="report-tag">Lifetime Value</a>
                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/chart.svg" alt="">
                    </span>
                    <a href="#" class="report-tag">Traffic Sources</a>
                    <a href="#" class="report-tag">Cost per Acquisition</a>
                    <a href="#" class="report-tag">Cash Flow</a>
                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/message.svg" alt="">
                    </span>
                    <a href="#" class="report-tag">Funnel Analysis</a>

                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/chart2.svg" alt="">
                    </span>
                    <a href="#" class="report-tag">Conversion Rates</a>
                    <a href="#" class="report-tag">Offline/Organic Tracking</a>
                    <span class="report-tag report-tag--icon">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/icons/increase.svg" alt="">
                    </span>
                    <a href="#" class="report-tag">Amazon and Shopify</a>
                    <a href="#" class="report-tag">Attribution</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Case Studies Section -->
<?php
$case_studies = neamob_get_case_studies(['posts_per_page' => 2]);
if ($case_studies->have_posts()):
    ?>
    <section class="case-studies-section">
        <div class="container">
            <div class="case-studies-section__header">
                <h2 class="case-studies-section__title">Case studies</h2>
                <a href="<?php echo get_post_type_archive_link('case_study'); ?>" class="case-studies-section__link">View More</a>
            </div>
            <div
                class="case-studies-grid">
                <?php while ($case_studies->have_posts()):
                    $case_studies->the_post();
                    // Try ACF fields first, fall back to post meta
                    $client_name = get_field('client_name') ?: get_post_meta(get_the_ID(), '_case_study_client_name', true);
                    $client_logo = get_field('client_logo') ?: get_post_meta(get_the_ID(), '_case_study_client_logo', true);
                    $badge_value = get_field('badge_value') ?: get_post_meta(get_the_ID(), '_case_study_badge_value', true);
                    $badge_text = get_field('badge_text') ?: get_post_meta(get_the_ID(), '_case_study_badge_text', true);
                    ?>
                    <article class="case-card">
                        <div class="case-card__header">
                            <div
                                class="case-card__logo">
                                <?php if ($client_logo): ?>
                                    <img
                                    src="<?php echo esc_url($client_logo); ?>" alt="<?php echo esc_attr($client_name); ?>">
                                <?php elseif ($client_name): ?>
                                    <span><?php echo esc_html($client_name); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($badge_value && $badge_text): ?>
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
        </div>
    </section>
    <?php
    wp_reset_postdata();
endif;
?>

<!-- Testimonials Section -->
<?php
$testimonials = neamob_get_testimonials();
if ($testimonials->have_posts()):
    $total = $testimonials->post_count;
    ?>
        <section class="testimonials-section"> <div class="testimonials-section__bg"></div>
        <div class="container">
            <div class="testimonial-slider">
                <div class="swiper">
                    <div
                        class="swiper-wrapper">
                        <?php while ($testimonials->have_posts()):
                            $testimonials->the_post();
                            $quote = get_field('testimonial_quote');
                            $author_name = get_field('author_name');
                            $author_position = get_field('author_position');
                            $company_logo = get_field('company_logo');
                            $author_photo = get_field('author_photo');
                            ?>
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-card__quote">
                                        <svg width="48" height="36" viewbox="0 0 48 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M48 36V18H36C36 11.34 41.34 6 48 6V0C38.1 0 30 8.1 30 18V36H48ZM18 36V18H6C6 11.34 11.34 6 18 6V0C8.1 0 0 8.1 0 18V36H18Z" fill="#0094FF"/>
                                        </svg>

                                    </div>
                                    <p class="testimonial-card__text"><?php echo esc_html($quote); ?></p>
                                    <div class="testimonial-card__author">
                                        <span class="testimonial-card__name"><?php echo esc_html($author_name); ?></span>
                                        <?php if ($author_position): ?>
                                            <span class="testimonial-card__position"><?php echo esc_html($author_position); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($company_logo): ?>
                                        <div class="testimonial-card__logo">
                                            <img src="<?php echo esc_url($company_logo); ?>" alt="">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div
                    class="testimonial-footer">
                    <?php if ($author_photo): ?>
                        <div class="testimonial-avatar">
                            <img src="<?php echo esc_url($author_photo); ?>" alt="">
                        </div>
                    <?php endif; ?>
                    <div class="testimonial-pagination">
                        <span class="testimonial-pagination__current">01</span>
                        <span class="testimonial-pagination__separator">/</span>
                        <span class="testimonial-pagination__total"><?php echo str_pad($total, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
endif;
?>

<!-- Why Choose Us - Comparison Section -->
<section class="comparison-section">
    <div class="container">
        <h2 class="comparison-section__title">Why choose NeaMob Tech?</h2>
        <div class="comparison-image">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/table.png" alt="Why choose NeaMob Tech comparison table">
        </div>
    </div>
</section>

<!-- Blog Section -->
<?php
$blog_posts = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post_status' => 'publish',
]);
if ($blog_posts->have_posts()):
    ?>
    <section class="blog-section">
        <div class="container">
            <div class="blog-section__header">
                <h2 class="blog-section__title">Blog</h2>
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="blog-section__link">Read More</a>
            </div>
            <div
                class="blog-grid">
                <?php while ($blog_posts->have_posts()):
                    $blog_posts->the_post();
                    $categories = get_the_category();
                    $category = !empty($categories) ? $categories[0] : null;
                    ?>
                    <article class="blog-card">
                        <a href="<?php the_permalink(); ?>" class="blog-card__image <?php echo !has_post_thumbnail() ? 'blog-card__image--placeholder' : ''; ?>"><?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('card-image'); ?>
                            <?php endif; ?>
                        </a>
                        <div
                            class="blog-card__meta">
                            <?php if ($category): ?>
                                <a
                                    href="<?php echo get_category_link($category->term_id); ?>" class="blog-card__category"><?php echo esc_html($category->name); ?>
                                </a>
                            <?php endif; ?>
                            <span class="blog-card__date"><?php echo get_the_date('d M, Y'); ?></span>
                        </div>
                        <h3 class="blog-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="blog-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        <div class="blog-card__author">
                            <div
                                class="blog-card__author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
                            </div>
                            <span class="blog-card__author-name"><?php the_author(); ?></span>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
endif;
?>

<!-- Partner Video Block -->
<section class="partner-video-section">
    <div class="container">
        <div class="partner-video-block">
            <div class="partner-video-block__content">
                <div class="partner-video-block__logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/snapper.png" alt="Snappper">
                </div>
                <h2 class="partner-video-block__title">Our Partner</h2>
                <p class="partner-video-block__text">The coveted commercial-grade video production company sought-after for their fresh approach and unforgettable creative</p>
            </div>
            <div class="partner-video-block__video" id="partner-video">
                <div class="partner-video-block__thumbnail" onclick="playPartnerVideo()">
                    <img src="https://img.youtube.com/vi/YOUR_VIDEO_ID/maxresdefault.jpg" alt="Video thumbnail">
                    <div class="play-button">
                        <svg viewbox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function playPartnerVideo() {
var container = document.getElementById('partner-video');
var videoId = 'YOUR_VIDEO_ID'; // Replace with actual YouTube video ID
container.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&modestbranding=1&controls=0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
container.classList.add('is-playing');
}
</script>

<!-- FAQ Section -->
<?php
$faqs = neamob_get_faqs();
if ($faqs->have_posts()):
    ?>
    <section class="faq-section">
        <div class="container">
            <div class="faq-section__grid">
                <div class="faq-section__sidebar">
                    <h2 class="faq-section__title">FAQs</h2>
                    <p class="faq-section__text">Got more questions? Reach out to us. We're always here to help!</p>
                    <a href="/contact" class="faq-section__cta">Let's Chat</a>
                </div>
                <div class="faq-list">
                    <?php $first = true; ?>
                    <?php while ($faqs->have_posts()):
                        $faqs->the_post();
                        $answer = get_field('faq_answer');
                        ?>
                            <div class="faq-item<?php echo $first ? ' is-active' : ''; ?>"> <div class="faq-item__header">
                                <h3 class="faq-item__question"><?php the_title(); ?></h3>
                                <div class="faq-item__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>
                            </div>
                            <div class="faq-item__body">
                                <div class="faq-item__answer">
                                    <div class="faq-item__answer-text"><?php echo wp_kses_post($answer); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php $first = false; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
endif;
?>

<!-- Contact Form Section -->
<?php get_template_part('template-parts/contact-form'); ?>

<?php get_footer(); ?>

