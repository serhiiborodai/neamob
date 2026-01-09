<?php
/**
 * Single Case Study template
 */
get_header();

$tags = get_field('case_tags') ?: [];
$client_name = get_field('client_name');
$client_logo = get_field('client_logo');
$badge_value = get_field('badge_value');
$badge_text = get_field('badge_text');
$case_excerpt = get_field('case_excerpt');
?>

<main class="single-case-study">
    <div class="container">
        <!-- Back Link -->
        <a href="<?php echo get_post_type_archive_link('case_study'); ?>" class="back-link">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to Case Studies
        </a>

        <!-- Header -->
        <header class="single-case-study__header">
            <?php if ($tags): ?>
                <div class="single-case-study__tags">
                    <?php foreach ($tags as $tag): ?>
                        <span class="case-tag"><?php echo esc_html(is_array($tag) ? $tag['tag_name'] : $tag); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h1 class="single-case-study__title"><?php the_title(); ?></h1>

            <?php if ($case_excerpt): ?>
                <p class="single-case-study__excerpt"><?php echo esc_html($case_excerpt); ?></p>
            <?php endif; ?>

            <?php if ($client_name || $badge_value): ?>
                <div class="single-case-study__meta">
                    <?php if ($client_logo): ?>
                        <img src="<?php echo esc_url($client_logo['url']); ?>" alt="<?php echo esc_attr($client_name); ?>" class="single-case-study__logo">
                    <?php elseif ($client_name): ?>
                        <span class="single-case-study__client"><?php echo esc_html($client_name); ?></span>
                    <?php endif; ?>

                    <?php if ($badge_value): ?>
                        <div class="single-case-study__badge">
                            <span class="badge-value"><?php echo esc_html($badge_value); ?></span>
                            <?php if ($badge_text): ?>
                                <span class="badge-text"><?php echo esc_html($badge_text); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()): ?>
            <div class="single-case-study__image">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <article class="single-case-study__content">
            <?php the_content(); ?>
        </article>

        <!-- Navigation -->
        <nav class="single-case-study__nav">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>
            
            <?php if ($prev_post): ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="case-nav case-nav--prev">
                    <span class="case-nav__label">Previous Case Study</span>
                    <span class="case-nav__title"><?php echo esc_html($prev_post->post_title); ?></span>
                </a>
            <?php else: ?>
                <div class="case-nav case-nav--empty"></div>
            <?php endif; ?>

            <?php if ($next_post): ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="case-nav case-nav--next">
                    <span class="case-nav__label">Next Case Study</span>
                    <span class="case-nav__title"><?php echo esc_html($next_post->post_title); ?></span>
                </a>
            <?php endif; ?>
        </nav>

    </div>
</main>

<?php get_footer(); ?>

