<?php
/**
 * Template Name: Portfolio (Redesign)
 * Admin-only preview — body.redesign-preview (/portfolio-redesign/).
 *
 * @package Neamob_Theme
 */

get_header();

$hero_title = get_field('portfolio_title') ?: 'Portfolio';
$hero_description = get_field('portfolio_description_v2')
    ?: '1,200+ creatives shipped for 30+ brands, including:';
$hero_cta_text = 'Book a Free Audit';

$theme_uri = get_template_directory_uri();
$assets_dir = get_template_directory() . '/assets/images/portfolio-redesign';
$assets_url = $theme_uri . '/assets/images/portfolio-redesign';
$data_file = $assets_dir . '/gallery-data.json';

$portfolio_items = [];
if (is_readable($data_file)) {
    $decoded = json_decode((string) file_get_contents($data_file), true);
    if (is_array($decoded)) {
        foreach ($decoded as $row) {
            if (empty($row['file'])) {
                continue;
            }
            $path = $assets_dir . '/' . $row['file'];
            if (!is_file($path)) {
                continue;
            }
            $ext = strtolower(pathinfo($row['file'], PATHINFO_EXTENSION));
            $is_video = in_array($ext, ['mp4', 'mov', 'webm'], true);
            $industry = isset($row['industry']) ? (string) $row['industry'] : '';
            $portfolio_items[] = [
                'url'      => $assets_url . '/' . $row['file'],
                'client'   => isset($row['client']) ? (string) $row['client'] : '',
                'title'    => isset($row['title']) ? (string) $row['title'] : '',
                'industry' => $industry,
                'category' => sanitize_title($industry),
                'media'    => isset($row['category']) ? (string) $row['category'] : 'static',
                'is_video' => $is_video,
            ];
        }
    }
}

$portfolio_categories = ['All', 'DTC & E-com', 'Health & Wellness', 'Apps & Tech'];

$client_logos = function_exists('neamob_get_client_logos') ? neamob_get_client_logos() : [];
$blocks = get_field('portfolio_blocks');
$fallback_img_1 = $theme_uri . '/assets/images/portfolio/portfolio-1.png';
$fallback_img_2 = $theme_uri . '/assets/images/portfolio/portfolio-2.png';
$fallback_single = $theme_uri . '/assets/images/portfolio/single-image.png';
$fallback_video_thumb = $theme_uri . '/assets/images/portfolio/video-thumbnail.png';
$fallback_play = $theme_uri . '/assets/images/portfolio/play-button.png';

$logo_items_html = '';
if (!empty($client_logos)) {
    ob_start();
    foreach ($client_logos as $logo_post) {
        $logo_url = get_the_post_thumbnail_url($logo_post->ID, 'medium');
        if (!$logo_url) {
            continue;
        }
        $link = get_field('client_logo_url', $logo_post->ID);
        echo '<div class="portfolio-logos__item">';
        if ($link) {
            echo '<a href="' . esc_url($link) . '" target="_blank" rel="noopener noreferrer">';
            echo '<img src="' . esc_url(add_query_arg('v', '2', $logo_url)) . '" alt="' . esc_attr($logo_post->post_title) . '" loading="lazy">';
            echo '</a>';
        } else {
            echo '<img src="' . esc_url(add_query_arg('v', '2', $logo_url)) . '" alt="' . esc_attr($logo_post->post_title) . '" loading="lazy">';
        }
        echo '</div>';
    }
    $logo_items_html = ob_get_clean();
}
?>

<main class="portfolio-page portfolio-page-v2">
    <section class="portfolio-hero-v2">
        <div class="portfolio-hero-v2__bg" aria-hidden="true">
            <img
                class="portfolio-hero-v2__bg-img"
                src="<?php echo esc_url($theme_uri . '/assets/images/portfolio-redesign/hero-bg.png'); ?>"
                alt=""
                width="1536"
                height="1024"
            >
        </div>
        <div class="container">
            <h1 class="portfolio-hero-v2__title"><?php echo esc_html($hero_title); ?></h1>
            <?php if ($hero_description): ?>
                <p class="portfolio-hero-v2__text"><?php echo esc_html($hero_description); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($logo_items_html !== ''): ?>
        <div class="portfolio-logos" aria-hidden="false">
            <div class="portfolio-logos__track">
                <div class="portfolio-logos__group">
                    <?php echo $logo_items_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_* above ?>
                </div>
                <div class="portfolio-logos__group" aria-hidden="true">
                    <?php echo $logo_items_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="container portfolio-hero-v2__cta-wrap">
            <a href="#audit-form" class="btn btn--hero btn--hero-v2 portfolio-hero-v2__cta" data-open-audit-form>
                <span class="btn__dot" aria-hidden="true"></span>
                <span><?php echo esc_html($hero_cta_text); ?></span>
            </a>
        </div>
    </section>

    <section class="portfolio-gallery-wrap">
        <div class="container">
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
        </div>

        <section class="portfolio-gallery" id="portfolioGallery">
            <div class="portfolio-gallery__cursor">
                <svg class="portfolio-gallery__cursor-arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="portfolio-gallery__track">
                <?php foreach ($portfolio_items as $item): ?>
                <div class="portfolio-gallery__item<?php echo $item['is_video'] ? ' portfolio-gallery__item--video' : ''; ?>" data-category="<?php echo esc_attr($item['category']); ?>">
                    <div class="portfolio-gallery__media">
                        <?php if ($item['is_video']): ?>
                            <video src="<?php echo esc_url($item['url']); ?>" autoplay muted loop playsinline preload="metadata"></video>
                        <?php else: ?>
                            <img src="<?php echo esc_url($item['url']); ?>" alt="<?php echo esc_attr($item['client'] ?: 'Portfolio'); ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <div class="portfolio-gallery__body">
                        <?php if ($item['client']): ?>
                            <p class="portfolio-gallery__client"><?php echo esc_html($item['client']); ?></p>
                        <?php endif; ?>
                        <?php if ($item['title']): ?>
                            <p class="portfolio-gallery__text"><?php echo esc_html($item['title']); ?></p>
                        <?php endif; ?>
                        <?php if ($item['industry']): ?>
                            <span class="portfolio-gallery__tag"><?php echo esc_html($item['industry']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="container">
            <div class="portfolio-cta-v2">
                <p class="portfolio-cta-v2__text">Ready to take your marketing to the next level?</p>
                <a href="#audit-form" class="btn btn--hero btn--hero-v2 portfolio-cta-v2__btn" data-open-audit-form>
                    <span class="btn__dot" aria-hidden="true"></span>
                    <span>Book a Free Audit</span>
                </a>
            </div>
        </div>
    </section>

    <?php if ($blocks): foreach ($blocks as $block): ?>
    <section class="portfolio-block" id="<?php echo esc_attr(sanitize_title($block['block_label'])); ?>">
        <div class="container">
            <div class="portfolio-block__layout <?php echo $block['block_layout'] === 'video' ? 'portfolio-block__layout--video' : ''; ?>">
                <div class="portfolio-block__content">
                    <span class="portfolio-block__label"><?php echo esc_html($block['block_label']); ?></span>
                    <h2 class="portfolio-block__title"><?php echo esc_html($block['block_title']); ?></h2>
                    <p class="portfolio-block__text"><?php echo wp_kses_post($block['block_text']); ?></p>
                    <?php if ($block['block_link'] && !empty($block['block_link']['url'])):
                        $link = $block['block_link'];
                        $link_url = $link['url'];
                        $link_href = (strpos($link_url, 'http') === 0) ? $link_url : home_url($link_url);
                    ?>
                        <a href="<?php echo esc_url($link_href); ?>" class="portfolio-block__link" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                            <span class="link-dot"></span>
                            <?php echo esc_html($link['title'] ?: 'Learn More'); ?>
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
                                <img src="<?php echo esc_url($fallback_video_thumb); ?>" alt="Video thumbnail" class="video-thumbnail">
                                <button class="video-play-btn">
                                    <img src="<?php echo esc_url($fallback_play); ?>" alt="Play">
                                </button>
                            </div>
                        </div>
                    <?php elseif ($block['block_layout'] === 'two_images'): ?>
                        <div class="portfolio-block__images portfolio-block__images--two">
                            <?php if ($block['block_image_1']): ?>
                                <img src="<?php echo esc_url($block['block_image_1']['url']); ?>" alt="<?php echo esc_attr($block['block_image_1']['alt']); ?>">
                            <?php else: ?>
                                <img src="<?php echo esc_url($fallback_img_1); ?>" alt="Portfolio">
                            <?php endif; ?>
                            <?php if ($block['block_image_2']): ?>
                                <img src="<?php echo esc_url($block['block_image_2']['url']); ?>" alt="<?php echo esc_attr($block['block_image_2']['alt']); ?>">
                            <?php else: ?>
                                <img src="<?php echo esc_url($fallback_img_2); ?>" alt="Portfolio">
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="portfolio-block__images portfolio-block__images--single">
                            <?php if ($block['block_image_1']): ?>
                                <img src="<?php echo esc_url($block['block_image_1']['url']); ?>" alt="<?php echo esc_attr($block['block_image_1']['alt']); ?>">
                            <?php else: ?>
                                <img src="<?php echo esc_url($fallback_single); ?>" alt="Portfolio">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; endif; ?>
</main>

<script>
var portfolioItemsData = <?php echo wp_json_encode($portfolio_items); ?>;

document.addEventListener('DOMContentLoaded', function() {
    var gallery = document.getElementById('portfolioGallery');
    if (!gallery) return;

    var track = gallery.querySelector('.portfolio-gallery__track');
    var cursorEl = gallery.querySelector('.portfolio-gallery__cursor');
    var isDesktop = window.innerWidth >= 1200;
    var swiperInstance = null;
    var cleanupDesktop = null;
    var currentFilter = 'all';

    function esc(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/"/g, '&quot;');
    }

    function buildItemsHTML(filter) {
        var items = filter === 'all'
            ? portfolioItemsData
            : portfolioItemsData.filter(function(item) { return item.category === filter; });

        var html = '';
        items.forEach(function(item) {
            var cls = 'portfolio-gallery__item' + (item.is_video ? ' portfolio-gallery__item--video' : '');
            html += '<div class="' + cls + '" data-category="' + esc(item.category) + '">';
            html += '<div class="portfolio-gallery__media">';
            if (item.is_video) {
                html += '<video src="' + esc(item.url) + '" autoplay muted loop playsinline preload="metadata"></video>';
            } else {
                html += '<img src="' + esc(item.url) + '" alt="' + esc(item.client || 'Portfolio') + '" loading="lazy">';
            }
            html += '</div><div class="portfolio-gallery__body">';
            if (item.client) html += '<p class="portfolio-gallery__client">' + esc(item.client) + '</p>';
            if (item.title) html += '<p class="portfolio-gallery__text">' + esc(item.title) + '</p>';
            if (item.industry) html += '<span class="portfolio-gallery__tag">' + esc(item.industry) + '</span>';
            html += '</div></div>';
        });
        return { html: html, count: items.length };
    }

    function manageVideos(galleryEl, trackEl) {
        var galleryRect = galleryEl.getBoundingClientRect();
        var videos = trackEl.querySelectorAll('video');
        for (var i = 0; i < videos.length; i++) {
            var vRect = videos[i].getBoundingClientRect();
            var visible = vRect.right > galleryRect.left - 200 && vRect.left < galleryRect.right + 200;
            if (visible && videos[i].paused) {
                videos[i].play().catch(function(){});
            } else if (!visible && !videos[i].paused) {
                videos[i].pause();
            }
        }
    }

    function initMobileSwiper() {
        var data = buildItemsHTML(currentFilter);
        track.innerHTML = data.html;

        var slideItems = track.querySelectorAll('.portfolio-gallery__item');
        slideItems.forEach(function(item) { item.classList.add('swiper-slide'); });
        track.classList.add('swiper-wrapper');
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
        var slideItems = track.querySelectorAll('.portfolio-gallery__item');
        slideItems.forEach(function(item) { item.classList.remove('swiper-slide'); });
    }

    function initDesktopScroll() {
        var data = buildItemsHTML(currentFilter);
        var origHTML = data.html;
        var oneSetCount = data.count;

        if (!oneSetCount) { track.innerHTML = ''; return function(){}; }

        track.innerHTML = origHTML + origHTML + origHTML;

        var scrollPos = 0;
        var speed = 0;
        var rafId = null;
        var totalWidth = 0;
        var mouseX = 0, mouseY = 0;
        var cursorX = 0, cursorY = 0;
        var cursorArrow = cursorEl.querySelector('.portfolio-gallery__cursor-arrow');
        var videoFrame = 0;

        function measureWidth() {
            var allItems = track.querySelectorAll('.portfolio-gallery__item');
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
            if (scrollPos >= totalWidth * 2) scrollPos -= totalWidth;
            else if (scrollPos < 0) scrollPos += totalWidth;
            track.style.transform = 'translateX(' + (-scrollPos) + 'px)';

            cursorX += (mouseX - cursorX) * 0.12;
            cursorY += (mouseY - cursorY) * 0.12;
            cursorEl.style.left = cursorX + 'px';
            cursorEl.style.top = cursorY + 'px';

            videoFrame++;
            if (videoFrame % 20 === 0) manageVideos(gallery, track);

            rafId = requestAnimationFrame(animate);
        }
        rafId = requestAnimationFrame(animate);

        function onEnter() { cursorEl.classList.add('is-visible'); }
        function onLeave() { cursorEl.classList.remove('is-visible'); speed = 0; }

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
            var videos = track.querySelectorAll('video');
            for (var i = 0; i < videos.length; i++) videos[i].pause();
            track.innerHTML = '';
            track.style.transform = '';
            speed = 0;
        };
    }

    function setup() {
        var nowDesktop = window.innerWidth >= 1200;
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

    var tabs = document.querySelectorAll('.portfolio-page-v2 .portfolio-tabs__btn');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            if (cleanupDesktop) { cleanupDesktop(); cleanupDesktop = null; }
            destroyMobileSwiper();
            setup();
        });
    });

    document.querySelectorAll('.portfolio-page-v2 .video-wrapper').forEach(function(wrapper) {
        wrapper.addEventListener('click', function() {
            var videoId = this.dataset.videoId;
            if (videoId) {
                this.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            }
        });
    });
});
</script>

<?php
get_template_part('template-parts/contact-form');
get_footer();
?>
