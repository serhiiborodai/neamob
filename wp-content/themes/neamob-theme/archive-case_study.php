<?php
/**
 * Archive template for Case Studies
 */
get_header();

// Get all case studies
$case_studies = new WP_Query([
    'post_type' => 'case_study',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
]);

$first_post = null;
$all_posts = [];

if ($case_studies->have_posts()) {
    $count = 0;
    while ($case_studies->have_posts()) {
        $case_studies->the_post();
        $post = get_post();
        $all_posts[] = $post;
        if ($count === 0) {
            $first_post = $post;
        }
        $count++;
    }
    wp_reset_postdata();
}
?>

<main class="case-studies-archive">
    <div class="container">
        <h1 class="case-studies-archive__title">Case Studies</h1>

        <?php if ($first_post): 
            $tags = get_field('case_tags', $first_post->ID) ?: [];
            $excerpt = get_field('case_excerpt', $first_post->ID) ?: get_the_excerpt($first_post->ID);
            $image = get_the_post_thumbnail_url($first_post->ID, 'large');
        ?>
        <!-- Featured Case Study -->
        <article class="case-featured">
            <div class="case-featured__image">
                <?php if ($image): ?>
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($first_post->post_title); ?>">
                <?php else: ?>
                    <div class="case-featured__placeholder"></div>
                <?php endif; ?>
            </div>
            <div class="case-featured__content">
                <?php if ($tags): ?>
                    <div class="case-featured__tags">
                        <?php foreach ($tags as $tag): ?>
                            <span class="case-tag"><?php echo esc_html(is_array($tag) ? $tag['tag_name'] : $tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <h2 class="case-featured__title"><?php echo esc_html($first_post->post_title); ?></h2>
                
                <?php if ($excerpt): ?>
                    <p class="case-featured__excerpt"><?php echo esc_html($excerpt); ?></p>
                <?php endif; ?>
                
                <a href="<?php echo get_permalink($first_post->ID); ?>" class="case-featured__link">
                    <span class="link-dot"></span>
                    Learn More
                </a>
            </div>
        </article>
        <?php endif; ?>

        <?php if (!empty($all_posts)): ?>
        <!-- All Case Studies -->
        <div class="case-grid">
            <?php foreach ($all_posts as $post): 
                $tags = get_field('case_tags', $post->ID) ?: [];
                $excerpt = get_field('case_excerpt', $post->ID) ?: get_the_excerpt($post->ID);
                $image = get_the_post_thumbnail_url($post->ID, 'medium_large');
            ?>
            <article class="case-card">
                <a href="<?php echo get_permalink($post->ID); ?>" class="case-card__image-link">
                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post->post_title); ?>" class="case-card__image">
                    <?php else: ?>
                        <div class="case-card__placeholder"></div>
                    <?php endif; ?>
                </a>
                
                <div class="case-card__content">
                    <h3 class="case-card__title">
                        <a href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_html($post->post_title); ?></a>
                    </h3>
                    
                    <?php if ($excerpt): ?>
                        <p class="case-card__excerpt"><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($tags): ?>
                        <div class="case-card__tags">
                            <?php foreach ($tags as $tag): ?>
                                <span class="case-tag case-tag--small"><?php echo esc_html(is_array($tag) ? $tag['tag_name'] : $tag); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>

