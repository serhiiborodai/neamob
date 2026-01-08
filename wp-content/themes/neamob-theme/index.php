<?php
/**
 * Main template file
 *
 * @package Neamob_Theme
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-card__image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('card-image'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-card__content">
                            <header class="post-card__header">
                                <h2 class="post-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="post-card__meta">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </div>
                            </header>
                            
                            <div class="post-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <footer class="post-card__footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn--secondary">
                                    <?php esc_html_e('Read More', 'neamob-theme'); ?>
                                </a>
                            </footer>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination([
                'prev_text' => '&larr; ' . __('Previous', 'neamob-theme'),
                'next_text' => __('Next', 'neamob-theme') . ' &rarr;',
            ]); ?>
            
        <?php else : ?>
            
            <section class="no-posts">
                <h1><?php esc_html_e('Nothing Found', 'neamob-theme'); ?></h1>
                <p><?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'neamob-theme'); ?></p>
            </section>
            
        <?php endif; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();

