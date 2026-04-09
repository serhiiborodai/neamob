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

<main
    class="careers-page">
    <!-- Hero Section -->
    <?php
    $careers_title = neamob_get_theme_option('careers_hero_title', 'Join Us');
    $careers_text = neamob_get_theme_option('careers_hero_text', "We're searching for people who are ready for a new challenge, love collaborating, and value our culture of transparency to join our team.");
    ?>
    <section class="careers-hero">
        <div class="container">
            <h1 class="careers-hero__title"><?php echo esc_html($careers_title); ?></h1>
            <p class="careers-hero__text"><?php echo esc_html($careers_text); ?></p>
        </div>
    </section>

    <!-- Jobs List -->
    <section class="jobs-section">
        <div
            class="container">
            <?php if ($jobs->have_posts()): ?>
                <div
                    class="jobs-list">
                    <?php while ($jobs->have_posts()):
                        $jobs->the_post();
                        $category_color = get_field('job_category_color') ?: 'green';
                        $color_labels = ['purple' => 'Creative & Design', 'green' => 'Campaign Management', 'blue' => 'Analytics & Reporting', 'grey' => ''];
                        $category_name = isset($color_labels[$category_color]) ? $color_labels[$category_color] : '';
                        $company = get_field('job_company') ?: 'Neamob Tech';
                        $applications = (int) get_field('job_applications_count') ?: 0;
                        ?>
                        <article class="job-card">
                            <div
                                class="job-card__content">
                                <?php if ($category_name): ?>
                                    <span
                                        class="job-card__category job-card__category--<?php echo esc_attr($category_color); ?>"><?php echo esc_html($category_name); ?>
                                    </span>
                                <?php endif; ?>
                                <h2 class="job-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <span class="job-card__company"><?php echo esc_html($company); ?></span>
                            </div>
                            <div class="job-card__meta">
                                <span class="job-card__applied">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewbox="0 0 13 12" fill="none">
                                        <path d="M3.35111 4.50409H2.96444C2.43678 4.48502 1.91083 4.57459 1.41922 4.76726C0.927622 4.95992 0.480861 5.25157 0.106667 5.62409L0 5.74853V9.42853H1.81333V7.33964L2.05778 7.06409L2.16889 6.9352C2.74752 6.34075 3.4679 5.90333 4.26222 5.66409C3.86467 5.36134 3.55105 4.96205 3.35111 4.50409Z" fill="#495B75"/>
                                        <path d="M11.9467 5.61075C11.5725 5.23823 11.1257 4.94659 10.6341 4.75393C10.1425 4.56126 9.61655 4.47168 9.08889 4.49075C8.92707 4.49162 8.76539 4.50052 8.60444 4.51742C8.40078 4.94706 8.09572 5.32075 7.71556 5.60631C8.56363 5.8407 9.33187 6.30164 9.93778 6.93964L10.0489 7.06409L10.2889 7.33964V9.43298H12.04V5.7352L11.9467 5.61075Z" fill="#495B75"/>
                                        <path d="M2.95111 3.63742H3.08889C3.02487 3.08775 3.12132 2.5313 3.36659 2.03524C3.61186 1.53918 3.99547 1.12471 4.47111 0.841866C4.2987 0.578465 4.06083 0.364358 3.7808 0.220509C3.50078 0.0766596 3.18819 0.00800098 2.87366 0.0212558C2.55913 0.0345105 2.25343 0.129224 1.9865 0.296123C1.71957 0.463021 1.50056 0.696382 1.35091 0.973354C1.20127 1.25033 1.12612 1.56141 1.13283 1.87616C1.13954 2.1909 1.22787 2.4985 1.38918 2.76884C1.55049 3.03919 1.77924 3.26301 2.05304 3.41838C2.32684 3.57375 2.6363 3.65536 2.95111 3.6552V3.63742Z" fill="#495B75"/>
                                        <path d="M8.87556 3.30409C8.8806 3.40625 8.8806 3.50859 8.87556 3.61075C8.96083 3.62441 9.04698 3.63184 9.13333 3.63298H9.21778C9.53121 3.61626 9.83497 3.51868 10.0995 3.34972C10.364 3.18077 10.5803 2.9462 10.7272 2.66885C10.8742 2.3915 10.9468 2.08083 10.9381 1.76708C10.9293 1.45333 10.8395 1.14719 10.6773 0.878468C10.5151 0.609747 10.2861 0.3876 10.0125 0.233656C9.73902 0.0797118 9.43029 -0.00078383 9.11642 5.75325e-06C8.80254 0.000795336 8.49422 0.0828433 8.22147 0.238162C7.94872 0.39348 7.72083 0.616776 7.56 0.88631C7.96226 1.14895 8.29303 1.50733 8.52264 1.92932C8.75225 2.3513 8.87351 2.82368 8.87556 3.30409Z" fill="#495B75"/>
                                        <path d="M5.96 5.2952C7.05721 5.2952 7.94667 4.40574 7.94667 3.30853C7.94667 2.21133 7.05721 1.32187 5.96 1.32187C4.86279 1.32187 3.97333 2.21133 3.97333 3.30853C3.97333 4.40574 4.86279 5.2952 5.96 5.2952Z" fill="#495B75"/>
                                        <path d="M6.06667 6.35298C5.48627 6.3298 4.90718 6.42415 4.36415 6.63036C3.82113 6.83657 3.32538 7.15039 2.90667 7.55298L2.79556 7.67742V10.4908C2.79729 10.5824 2.81706 10.6728 2.85374 10.7568C2.89042 10.8408 2.94329 10.9167 3.00932 10.9803C3.07536 11.0438 3.15327 11.0938 3.2386 11.1272C3.32394 11.1607 3.41503 11.177 3.50667 11.1752H8.61333C8.70497 11.177 8.79606 11.1607 8.8814 11.1272C8.96673 11.0938 9.04464 11.0438 9.11068 10.9803C9.17671 10.9167 9.22958 10.8408 9.26626 10.7568C9.30294 10.6728 9.32271 10.5824 9.32444 10.4908V7.68631L9.21778 7.55298C8.80192 7.14894 8.30792 6.8341 7.76607 6.62775C7.22422 6.42141 6.64594 6.3279 6.06667 6.35298Z" fill="#495B75"/>
                                    </svg>
                                    <?php echo esc_html($applications); ?>
                                    applied
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
                <?php if ($jobs->max_num_pages > 1): ?>
                    <div
                        class="careers-pagination"><?php
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

            <?php else: ?>
                    <div class="jobs-empty"> <p>No job openings at the moment. Please check back later!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>

