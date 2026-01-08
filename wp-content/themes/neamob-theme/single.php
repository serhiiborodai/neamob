<?php
/**
 * Single post template
 *
 * @package Neamob_Theme
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <header class="single-post__header">
                    <h1 class="single-post__title"><?php the_title(); ?></h1>
                    
                    <div class="single-post__meta">
                        <span class="post-date">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                        <span class="post-author">
                            <?php esc_html_e('By', 'neamob-theme'); ?> <?php the_author(); ?>
                        </span>
                        <?php if (has_category()) : ?>
                            <span class="post-categories">
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-post__thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post__content">
                    <?php the_content(); ?>
                </div>

                <?php if (has_tag()) : ?>
                    <footer class="single-post__footer">
                        <div class="post-tags">
                            <?php the_tags('<span class="tags-label">' . esc_html__('Tags:', 'neamob-theme') . '</span> ', ', '); ?>
                        </div>
                    </footer>
                <?php endif; ?>

                <?php
                // Post navigation
                the_post_navigation([
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'neamob-theme') . '</span><span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'neamob-theme') . '</span><span class="nav-title">%title</span>',
                ]);
                ?>

                <?php
                // Comments
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </article>
            
        <?php endwhile; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();

