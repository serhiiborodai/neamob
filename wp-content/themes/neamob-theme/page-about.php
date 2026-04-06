<?php
/**
 * Template Name: About Us
 *
 * @package Neamob_Theme
 */

get_header();

// Get ACF fields
$hero_title = get_field('about_hero_title') ?: 'About Us';
$hero_text = get_field('about_hero_text') ?: "We're a remote-first team that tells you what's working, what's not, and what we're doing about it, with strategy, data, and creativity that actually moves the needle.";
$gallery = get_field('about_gallery');
$who_title = get_field('about_who_title') ?: "We're the team you wish worked at your company.";
$who_text = get_field('about_who_text') ?: 'A remote-first collective of strategists, analysts, designers, and media buyers who actually like each other. We ditched the office politics, the pointless meetings, and the "that\'s not my department" excuses. What\'s left? People who are really good at what they do, working together from everywhere, making things happen.';
$highlight_title = get_field('about_highlight_title') ?: 'Why do clients stick with us?';
$highlight_text = get_field('about_highlight_text') ?: "We're brutally transparent. If a campaign underperforms, you'll hear it from us first, along with what we're testing to fix it. If something's working, we'll show you exactly why. No smoke and mirrors, just honest conversations about performance and what comes next.";
$beliefs_title = get_field('about_beliefs_title') ?: 'What we actually believe in';
$beliefs = get_field('about_beliefs');
$join_image = get_field('about_join_image');
$join_title = get_field('about_join_title') ?: 'Join us';
$join_text = get_field('about_join_text') ?: "Remote-first. Transparent culture. We're building a team of the best strategists, analysts, designers, and media buyers, wherever they happen to be.";

// Default beliefs if not set
if (!$beliefs) {
    $beliefs = [
        ['belief_title' => 'Own it', 'belief_text' => 'No finger-pointing, no "not my job". If something needs doing, we do it. If something breaks, we fix it.'],
        ['belief_title' => 'Question everything', 'belief_text' => "Just because it's always been done that way doesn't mean it's right. We challenge assumptions, test relentlessly, and optimize obsessively."],
        ['belief_title' => 'Collaborate or go home', 'belief_text' => "Your wins are our wins. Our analysts talk to our designers who work with our media buyers who strategize with our clients. It's almost like we're all on the same team. (We are.)"],
        ['belief_title' => 'Be human', 'belief_text' => "We're professional, but we're not robots. We laugh at bad puns, celebrate wins, and admit when we're wrong. Life's too short for corporate speak."],
        ['belief_title' => 'Move fast', 'belief_text' => "Remote doesn't mean slow. It means we're working while competitors are commuting. Insights become actions, not PowerPoints."],
    ];
}
?>

<main class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1 class="about-hero__title"><?php echo esc_html($hero_title); ?></h1>
            <p class="about-hero__text"><?php echo esc_html($hero_text); ?></p>
        </div>
    </section>

    <!-- Gallery -->
    <section class="about-gallery" id="aboutGallery">
        <div class="about-gallery__cursor">
            <svg class="about-gallery__cursor-arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="about-gallery__track">
            <?php
            $gallery_items = neamob_get_gallery_images('_neamob_about_gallery');
            if (empty($gallery_items) && function_exists('get_field')) {
                $acf_gallery = get_field('about_gallery');
                if ($acf_gallery && is_array($acf_gallery)) {
                    foreach ($acf_gallery as $img) {
                        $gallery_items[] = [
                            'url' => is_array($img) ? ($img['url'] ?? '') : $img,
                            'alt' => is_array($img) ? ($img['alt'] ?? 'About photo') : 'About photo',
                        ];
                    }
                }
            }
            if (empty($gallery_items)) {
                for ($i = 1; $i <= 7; $i++) {
                    $gallery_items[] = [
                        'url' => get_template_directory_uri() . '/assets/images/about/' . $i . '.webp',
                        'alt' => 'About photo ' . $i,
                    ];
                }
            }
            foreach ($gallery_items as $item):
                $ext = strtolower(pathinfo($item['url'], PATHINFO_EXTENSION));
                $is_video = in_array($ext, ['mp4', 'mov', 'webm']);
            ?>
            <div class="about-gallery__item">
                <?php if ($is_video): ?>
                    <video src="<?php echo esc_url($item['url']); ?>" autoplay muted loop playsinline preload="metadata"></video>
                <?php else: ?>
                    <img src="<?php echo esc_url($item['url']); ?>" alt="<?php echo esc_attr($item['alt']); ?>">
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="about-who">
        <div class="container">
            <div class="about-who__grid">
                <span class="about-who__label">WHO WE ARE</span>
                <div class="about-who__content">
                    <h2 class="about-who__title"><?php echo esc_html($who_title); ?></h2>
                    <p class="about-who__text"><?php echo esc_html($who_text); ?></p>
                    
                    <div class="about-who__highlight">
                        <h3 class="about-who__highlight-title"><?php echo esc_html($highlight_title); ?></h3>
                        <p class="about-who__highlight-text"><?php echo esc_html($highlight_text); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Beliefs Section -->
    <section class="about-beliefs">
        <div class="container">
            <h2 class="about-beliefs__title"><?php echo esc_html($beliefs_title); ?></h2>
            
            <div class="about-beliefs__list">
                <?php $num = 1; ?>
                <?php foreach ($beliefs as $belief) : ?>
                <div class="about-beliefs__item">
                    <span class="about-beliefs__number"><?php echo str_pad($num, 2, '0', STR_PAD_LEFT); ?></span>
                    <div class="about-beliefs__content">
                        <h3 class="about-beliefs__item-title"><?php echo esc_html($belief['belief_title']); ?></h3>
                        <p class="about-beliefs__item-text"><?php echo esc_html($belief['belief_text']); ?></p>
                    </div>
                </div>
                <?php $num++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Team Slider Section -->
    <?php
    $team_members = new WP_Query([
        'post_type' => 'team_member',
        'posts_per_page' => -1,
        'meta_key' => 'team_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ]);
    
    if ($team_members->have_posts()) :
    ?>
    <section class="about-team">
        <div class="container">
            <div class="about-team__header">
                <span class="about-team__label">ONE TEAM, MANY<br>TIME ZONES</span>
                <div class="about-team__nav">
                    <button class="about-team__nav-btn about-team__nav-prev" aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    </button>
                    <button class="about-team__nav-btn about-team__nav-next" aria-label="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                    </button>
                </div>
            </div>
            
            <div class="about-team__slider swiper" id="teamSlider">
                <div class="swiper-wrapper">
                    <?php 
                    $team_index = 0;
                    $team_fallbacks = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png', '8.png'];
                    while ($team_members->have_posts()) : $team_members->the_post(); 
                        $post_id = get_the_ID();
                        $position = get_field('team_position', $post_id);
                        $location = get_field('team_location', $post_id);
                        $departments = get_the_terms($post_id, 'team_department');
                        $dept_term = $departments ? $departments[0] : null;
                        $dept_name = $dept_term ? $dept_term->name : '';
                        // Цвет: сначала из департамента (taxonomy term), иначе из персоны
                        $term_color = $dept_term ? get_field('dept_badge_color', 'team_department_' . $dept_term->term_id) : null;
                        $person_color = get_field('team_department_color', $post_id);
                        $valid_colors = ['none', 'green', 'blue', 'purple', 'orange'];
                        $dept_color = ($term_color && in_array($term_color, $valid_colors, true))
                            ? $term_color
                            : (($person_color && in_array($person_color, $valid_colors, true)) ? $person_color : 'green');
                        $photo = get_field('team_photo', $post_id);
                        $photo_url = $photo && isset($photo['url']) ? $photo['url'] : '';
                        $fallback_img = $team_fallbacks[$team_index % count($team_fallbacks)];
                    ?>
                    <div class="swiper-slide">
                        <div class="team-card">
                            <div class="team-card__image">
                                <?php if ($photo_url) : ?>
                                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php elseif (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team/<?php echo esc_attr($fallback_img); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                
                                <?php if ($dept_name) : ?>
                                <span class="team-card__dept team-card__dept--<?php echo esc_attr($dept_color); ?>">
                                    <?php echo esc_html($dept_name); ?>
                                </span>
                                <?php endif; ?>
                                
                                <?php if ($location) : ?>
                                <span class="team-card__location">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <?php echo esc_html($location); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="team-card__info">
                                <h3 class="team-card__name"><?php the_title(); ?></h3>
                                <?php if ($position) : ?>
                                <p class="team-card__position"><?php echo esc_html($position); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php $team_index++; endwhile; ?>
                </div>
            </div>
        </div>
    </section>
    <?php 
    wp_reset_postdata();
    endif; 
    ?>

    <!-- Value Section (Reused from front page) -->
    <?php get_template_part('template-parts/value-section'); ?>

    <!-- Join Us Section -->
    <section class="about-join">
        <div class="container">
            <div class="about-join__grid">
                <div class="about-join__image">
                    <?php if ($join_image) : ?>
                        <img src="<?php echo esc_url($join_image['sizes']['large']); ?>" alt="<?php echo esc_attr($join_image['alt']); ?>">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about_tech.png" alt="Join NeaMob Tech">
                    <?php endif; ?>
                </div>
                <div class="about-join__content">
                    <h2 class="about-join__title"><?php echo esc_html($join_title); ?></h2>
                    <p class="about-join__text"><?php echo esc_html($join_text); ?></p>
                    <a href="<?php echo get_post_type_archive_link('job'); ?>" class="about-join__link">
                        <span class="about-join__link-dot"></span>
                        View Open Roles
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section (Reused) -->
    <?php get_template_part('template-parts/contact-form'); ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // About Gallery — desktop: cursor-based scroll, mobile: swiper
    (function() {
        var gallery = document.getElementById('aboutGallery');
        if (!gallery) return;

        var track = gallery.querySelector('.about-gallery__track');
        var cursor = gallery.querySelector('.about-gallery__cursor');
        var items = track.querySelectorAll('.about-gallery__item');
        if (!items.length) return;

        var isDesktop = window.innerWidth >= 1200;
        var swiperInstance = null;

        function initMobileSwiper() {
            track.classList.add('swiper-wrapper');
            items.forEach(function(item) { item.classList.add('swiper-slide'); });
            gallery.classList.add('swiper');
            swiperInstance = new Swiper(gallery, {
                slidesPerView: 'auto',
                spaceBetween: 20,
                loop: true,
                freeMode: true,
            });
        }

        function destroyMobileSwiper() {
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
                swiperInstance = null;
            }
            gallery.classList.remove('swiper');
            track.classList.remove('swiper-wrapper');
            items.forEach(function(item) { item.classList.remove('swiper-slide'); });
        }

        function initDesktopScroll() {
            var origHTML = track.innerHTML;
            track.innerHTML = origHTML + origHTML + origHTML;

            var scrollPos = 0;
            var speed = 0;
            var rafId = null;
            var totalWidth = 0;

            // Cursor lerp state
            var mouseX = 0, mouseY = 0;
            var cursorX = 0, cursorY = 0;
            var cursorArrow = cursor.querySelector('.about-gallery__cursor-arrow');

            function measureWidth() {
                var allItems = track.querySelectorAll('.about-gallery__item');
                var oneSetCount = items.length;
                totalWidth = 0;
                for (var i = 0; i < oneSetCount; i++) {
                    totalWidth += allItems[i].offsetWidth + 20;
                }
            }
            measureWidth();

            scrollPos = totalWidth;
            track.style.transform = 'translateX(' + (-scrollPos) + 'px)';

            function animate() {
                scrollPos += speed;
                if (scrollPos >= totalWidth * 2) {
                    scrollPos -= totalWidth;
                } else if (scrollPos < 0) {
                    scrollPos += totalWidth;
                }
                track.style.transform = 'translateX(' + (-scrollPos) + 'px)';

                // Smooth cursor follow (lerp)
                cursorX += (mouseX - cursorX) * 0.12;
                cursorY += (mouseY - cursorY) * 0.12;
                cursor.style.left = cursorX + 'px';
                cursor.style.top = cursorY + 'px';

                rafId = requestAnimationFrame(animate);
            }
            rafId = requestAnimationFrame(animate);

            function onEnter() {
                cursor.classList.add('is-visible');
            }

            function onLeave() {
                cursor.classList.remove('is-visible');
                speed = 0;
            }

            function onMove(e) {
                var rect = gallery.getBoundingClientRect();
                mouseX = e.clientX - rect.left;
                mouseY = e.clientY - rect.top;

                var ratio = mouseX / rect.width;
                var maxSpeed = 3;
                if (ratio > 0.5) {
                    speed = (ratio - 0.5) * 2 * maxSpeed;
                    cursorArrow.innerHTML = '<path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                } else {
                    speed = -(0.5 - ratio) * 2 * maxSpeed;
                    cursorArrow.innerHTML = '<path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                }
            }

            gallery.addEventListener('mouseenter', onEnter);
            gallery.addEventListener('mouseleave', onLeave);
            gallery.addEventListener('mousemove', onMove);

            return function cleanup() {
                cancelAnimationFrame(rafId);
                gallery.removeEventListener('mouseenter', onEnter);
                gallery.removeEventListener('mouseleave', onLeave);
                gallery.removeEventListener('mousemove', onMove);
                track.innerHTML = origHTML;
                track.style.transform = '';
                speed = 0;
            };
        }

        var cleanupDesktop = null;

        function setup() {
            var nowDesktop = window.innerWidth >= 1200;
            if (nowDesktop === isDesktop && (swiperInstance || cleanupDesktop)) return;
            isDesktop = nowDesktop;

            if (isDesktop) {
                destroyMobileSwiper();
                cleanupDesktop = initDesktopScroll();
            } else {
                if (cleanupDesktop) { cleanupDesktop(); cleanupDesktop = null; }
                initMobileSwiper();
            }
        }

        setup();
        window.addEventListener('resize', function() {
            var nowDesktop = window.innerWidth >= 1200;
            if (nowDesktop !== isDesktop) setup();
        });
    })();

    // Team Slider
    if (document.getElementById('teamSlider')) {
        new Swiper('#teamSlider', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            navigation: {
                nextEl: '.about-team__nav-next',
                prevEl: '.about-team__nav-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }
});
</script>

<?php get_footer(); ?>

