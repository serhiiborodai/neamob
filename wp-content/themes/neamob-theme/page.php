<?php
/**
 * Page template
 *
 * @package Neamob_Theme
 */

get_header();
?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (!is_front_page()) : ?>
                <header class="page-header section">
                    <div class="container">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                </header>
            <?php endif; ?>

            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>
        
    <?php endwhile; ?>
</main>

<?php
get_footer();

