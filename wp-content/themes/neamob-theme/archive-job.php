<?php
/**
 * Template: Jobs Archive (Careers Page)
 *
 * @package Neamob_Theme
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$jobs = neamob_get_jobs(10, $paged);
?>

<main class="careers-page">
    <!-- Hero Section -->
    <section class="careers-hero">
        <div class="container">
            <h1 class="careers-hero__title">Join Us</h1>
            <p class="careers-hero__text">We're searching for people who are ready for a new challenge, love collaborating, and value our culture of transparency to join our team.</p>
        </div>
    </section>

    <!-- Jobs List -->
    <section class="jobs-section">
        <div class="container">
            <?php if ($jobs->have_posts()) : ?>
            <div class="jobs-list">
                <?php while ($jobs->have_posts()) : $jobs->the_post(); 
                    $categories = get_the_terms(get_the_ID(), 'job_category');
                    $category_name = $categories ? $categories[0]->name : '';
                    $category_color = get_field('job_category_color') ?: 'green';
                    $company = get_field('job_company') ?: 'Neamob Tech';
                    $applications = (int) get_field('job_applications_count') ?: 0;
                ?>
                <article class="job-card">
                    <div class="job-card__content">
                        <?php if ($category_name) : ?>
                        <span class="job-card__category job-card__category--<?php echo esc_attr($category_color); ?>">
                            <?php echo esc_html($category_name); ?>
                        </span>
                        <?php endif; ?>
                        <h2 class="job-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <span class="job-card__company"><?php echo esc_html($company); ?></span>
                    </div>
                    <div class="job-card__meta">
                        <span class="job-card__applied">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <?php echo esc_html($applications); ?> applied
                        </span>
                        <a href="<?php the_permalink(); ?>" class="job-card__apply">
                            <span class="job-card__apply-dot"></span>
                            Apply Now
                        </a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ($jobs->max_num_pages > 1) : ?>
            <div class="careers-pagination">
                <?php
                echo paginate_links([
                    'total' => $jobs->max_num_pages,
                    'current' => $paged,
                    'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>',
                    'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>',
                ]);
                ?>
            </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>

            <?php else : ?>
            <div class="jobs-empty">
                <p>No job openings at the moment. Please check back later!</p>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>

