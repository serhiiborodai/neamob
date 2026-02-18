<?php
/**
 * Template Name: Portfolio Page
 */
get_header();

// Get ACF fields
$hero_title = get_field('portfolio_title') ?: 'Portfolio';
$hero_description = get_field('portfolio_description');
$portfolio_categories = get_field('portfolio_categories') ?: ['All', 'Static', 'Video', 'UGC-Video'];
$portfolio_items = get_field('portfolio_items');

// Blocks
$blocks = get_field('portfolio_blocks');
?>

<main class="portfolio-page">
    <!-- Hero Section -->
    <section class="portfolio-hero">
        <div class="container">
            <h1 class="portfolio-hero__title"><?php echo esc_html($hero_title); ?></h1>
            <?php if ($hero_description): ?>
                <p class="portfolio-hero__description"><?php echo wp_kses_post($hero_description); ?></p>
            <?php endif; ?>

            <!-- Category Tabs -->
            <div class="portfolio-tabs">
                <?php 
                $cats = is_array($portfolio_categories) ? $portfolio_categories : explode(',', $portfolio_categories);
                foreach ($cats as $index => $cat): 
                    $cat = trim($cat);
                ?>
                    <button class="portfolio-tabs__btn <?php echo $index === 0 ? 'active' : ''; ?>" data-filter="<?php echo esc_attr(sanitize_title($cat)); ?>">
                        <?php echo esc_html($cat); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Portfolio Gallery -->
            <section class="portfolio-gallery">
                <div class="portfolio-gallery__track">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <div class="portfolio-gallery__item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/portfolio/<?php echo $i; ?>.png" alt="Portfolio item <?php echo $i; ?>">
                    </div>
                    <?php endfor; ?>
                </div>
            </section>
        </div>
    </section>

    <!-- Portfolio Blocks -->
    <?php if ($blocks): foreach ($blocks as $block): ?>
    <section class="portfolio-block">
        <div class="container">
            <div class="portfolio-block__layout <?php echo $block['block_layout'] === 'video' ? 'portfolio-block__layout--video' : ''; ?>">
                <div class="portfolio-block__content">
                    <span class="portfolio-block__label"><?php echo esc_html($block['block_label']); ?></span>
                    <h2 class="portfolio-block__title"><?php echo esc_html($block['block_title']); ?></h2>
                    <p class="portfolio-block__text"><?php echo wp_kses_post($block['block_text']); ?></p>
                    <?php if ($block['block_link']): ?>
                        <a href="<?php echo esc_url($block['block_link']['url']); ?>" class="portfolio-block__link">
                            <span class="link-dot"></span>
                            <?php echo esc_html($block['block_link']['title'] ?: 'Learn More'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="portfolio-block__media">
                    <?php if ($block['block_layout'] === 'video' && $block['block_video_url']): ?>
                        <div class="portfolio-block__video">
                            <?php 
                            $video_id = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $block['block_video_url'], $matches)) {
                                $video_id = $matches[1];
                            }
                            ?>
                            <div class="video-wrapper" data-video-id="<?php echo esc_attr($video_id); ?>">
                                <img src="https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/maxresdefault.jpg" alt="Video thumbnail" class="video-thumbnail">
                                <button class="video-play-btn">
                                    <svg width="68" height="48" viewBox="0 0 68 48"><path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="red"/><path d="M45 24L27 14v20" fill="white"/></svg>
                                </button>
                            </div>
                        </div>
                    <?php elseif ($block['block_layout'] === 'two_images'): ?>
                        <div class="portfolio-block__images portfolio-block__images--two">
                            <?php if ($block['block_image_1']): ?>
                                <img src="<?php echo esc_url($block['block_image_1']['url']); ?>" alt="<?php echo esc_attr($block['block_image_1']['alt']); ?>">
                            <?php else: ?>
                                <div class="image-placeholder"></div>
                            <?php endif; ?>
                            <?php if ($block['block_image_2']): ?>
                                <img src="<?php echo esc_url($block['block_image_2']['url']); ?>" alt="<?php echo esc_attr($block['block_image_2']['alt']); ?>">
                            <?php else: ?>
                                <div class="image-placeholder"></div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="portfolio-block__images portfolio-block__images--single">
                            <?php if ($block['block_image_1']): ?>
                                <img src="<?php echo esc_url($block['block_image_1']['url']); ?>" alt="<?php echo esc_attr($block['block_image_1']['alt']); ?>">
                            <?php else: ?>
                                <div class="image-placeholder"></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; endif; ?>

</main>

<?php 
// Contact Form before footer
get_template_part('template-parts/contact-form');

get_footer(); 
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Portfolio Swiper
    const portfolioSwiper = new Swiper('.portfolio-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        centeredSlides: false,
        loop: false,
        grabCursor: true,
    });

    // Tab filtering
    const tabs = document.querySelectorAll('.portfolio-tabs__btn');
    const slides = document.querySelectorAll('.portfolio-swiper .swiper-slide');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            slides.forEach(slide => {
                if (filter === 'all' || slide.dataset.category === filter) {
                    slide.style.display = '';
                } else {
                    slide.style.display = 'none';
                }
            });
            
            portfolioSwiper.update();
        });
    });

    // Video play
    document.querySelectorAll('.video-wrapper').forEach(wrapper => {
        wrapper.addEventListener('click', function() {
            const videoId = this.dataset.videoId;
            if (videoId) {
                this.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            }
        });
    });
});
</script>

