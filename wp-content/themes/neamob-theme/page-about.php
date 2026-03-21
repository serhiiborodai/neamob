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
    <section class="about-gallery">
        <div class="about-gallery__track">
            <?php 
            $gallery = get_field('about_gallery');
            if ($gallery && is_array($gallery) && !empty($gallery)): 
                foreach ($gallery as $img): 
                    $url = is_array($img) ? ($img['url'] ?? '') : $img;
                    $alt = is_array($img) ? ($img['alt'] ?? 'About photo') : 'About photo';
            ?>
            <div class="about-gallery__item">
                <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>">
            </div>
            <?php endforeach;
            else: /* Fallback to static images */
                for ($i = 1; $i <= 7; $i++) : ?>
            <div class="about-gallery__item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about/<?php echo $i; ?>.webp" alt="About photo <?php echo $i; ?>">
            </div>
            <?php endfor; endif; ?>
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
                    while ($team_members->have_posts()) : $team_members->the_post(); 
                        $position = get_field('team_position');
                        $location = get_field('team_location');
                        $dept_color = get_field('team_department_color') ?: 'green';
                        $departments = get_the_terms(get_the_ID(), 'team_department');
                        $dept_name = $departments ? $departments[0]->name : '';
                        $photo = get_field('team_photo');
                        $photo_url = $photo && isset($photo['url']) ? $photo['url'] : '';
                    ?>
                    <div class="swiper-slide">
                        <div class="team-card">
                            <div class="team-card__image">
                                <?php if ($photo_url) : ?>
                                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php elseif (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-person.jpg" alt="<?php the_title_attribute(); ?>">
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
                    <?php endwhile; ?>
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
    // About Gallery Slider
    if (document.getElementById('aboutGallerySlider')) {
        new Swiper('#aboutGallerySlider', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 20,
            loop: true,
            speed: 4000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            allowTouchMove: true,
            freeMode: true,
        });
    }

    // Team Slider
    if (document.getElementById('teamSlider')) {
        new Swiper('#teamSlider', {
            slidesPerView: 1,
            spaceBetween: 24,
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

