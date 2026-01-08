<?php
/**
 * Template: Category Archive
 *
 * @package Neamob_Theme
 */

get_header();

$current_category = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Get blog categories for tabs
$blog_categories = get_terms([
    'taxonomy' => 'category',
    'hide_empty' => true,
    'exclude' => [1], // Exclude "Uncategorized"
]);
?>

<main class="blog-page">
    <!-- Blog Hero -->
    <section class="blog-hero">
        <div class="container">
            <h1 class="blog-hero__title">Blog</h1>
        </div>
    </section>

    <!-- Category Tabs -->
    <section class="blog-tabs">
        <div class="container">
            <div class="blog-tabs__list">
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="blog-tabs__tab">
                    All posts
                </a>
                <?php foreach ($blog_categories as $cat) : 
                    $is_active = ($cat->term_id === $current_category->term_id);
                ?>
                <a href="<?php echo get_category_link($cat->term_id); ?>" class="blog-tabs__tab<?php echo $is_active ? ' blog-tabs__tab--active' : ''; ?>">
                    <?php echo esc_html($cat->name); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Blog Grid -->
    <section class="blog-grid-section">
        <div class="container">
            <?php if (have_posts()) : ?>
            <div class="blog-grid">
                <?php while (have_posts()) : the_post(); 
                    $categories = get_the_category();
                    $category = $categories ? $categories[0] : null;
                    $cat_slug = $category ? $category->slug : '';
                    $cat_color = 'blue';
                    if (strpos($cat_slug, 'analytics') !== false) $cat_color = 'blue';
                    elseif (strpos($cat_slug, 'creative') !== false) $cat_color = 'green';
                    elseif (strpos($cat_slug, 'campaign') !== false) $cat_color = 'purple';
                ?>
                <article class="blog-card">
                    <a href="<?php the_permalink(); ?>" class="blog-card__image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large'); ?>
                        <?php else : ?>
                            <div class="blog-card__placeholder"></div>
                        <?php endif; ?>
                    </a>
                    <div class="blog-card__content">
                        <div class="blog-card__meta">
                            <?php if ($category) : ?>
                            <span class="blog-card__category blog-card__category--<?php echo esc_attr($cat_color); ?>">
                                <?php echo esc_html($category->name); ?>
                            </span>
                            <?php endif; ?>
                            <span class="blog-card__date"><?php echo get_the_date('d M, Y'); ?></span>
                        </div>
                        <h3 class="blog-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="blog-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <div class="blog-card__author">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                            <span class="blog-card__author-name"><?php the_author(); ?></span>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ($wp_query->max_num_pages > 1) : ?>
            <div class="blog-pagination">
                <?php
                echo paginate_links([
                    'total' => $wp_query->max_num_pages,
                    'current' => $paged,
                    'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>',
                    'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>',
                ]);
                ?>
            </div>
            <?php endif; ?>

            <?php else : ?>
            <div class="blog-empty">
                <p>No posts found in this category.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>

