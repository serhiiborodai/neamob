<?php
/**
 * Template: Single Job
 *
 * @package Neamob_Theme
 */

get_header();

while (have_posts()) : the_post();
    $categories = get_the_terms(get_the_ID(), 'job_category');
    $category_name = $categories ? $categories[0]->name : '';
    $category_color = get_field('job_category_color') ?: 'green';
    $applications = (int) get_field('job_applications_count') ?: 0;
    $job_id = get_the_ID();
?>

<main class="single-job-page">
    <div class="container">
        <div class="single-job-grid">
            <!-- Left Column: Job Content -->
            <div class="single-job-content">
                <header class="single-job-header">
                    <h1 class="single-job-title"><?php the_title(); ?></h1>
                </header>

                <div class="single-job-body">
                    <?php the_content(); ?>
                </div>

                <a href="<?php echo get_post_type_archive_link('job'); ?>" class="single-job-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to all jobs
                </a>
            </div>

            <!-- Right Column: Application Form -->
            <aside class="single-job-sidebar">
                <div class="single-job-meta">
                    <span class="single-job-applied">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <?php echo esc_html($applications); ?> applied
                    </span>
                    <?php if ($category_name) : ?>
                    <span class="single-job-category single-job-category--<?php echo esc_attr($category_color); ?>">
                        <?php echo esc_html($category_name); ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="job-apply-card">
                    <h3 class="job-apply-card__title">Apply to this job</h3>
                    
                    <?php if (class_exists('WPCF7')) : ?>
                        <?php echo do_shortcode('[contact-form-7 id="61" title="Job Application"]'); ?>
                    <?php else : ?>
                    <form class="job-apply-form" method="post" enctype="multipart/form-data" data-job-id="<?php echo esc_attr($job_id); ?>">
                        <?php wp_nonce_field('job_application', 'job_application_nonce'); ?>
                        <input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>">
                        <input type="hidden" name="job_title" value="<?php echo esc_attr(get_the_title()); ?>">
                        
                        <div class="job-apply-form__field">
                            <label class="job-apply-form__label">Full name</label>
                            <input type="text" name="applicant_name" class="job-apply-form__input" required>
                        </div>
                        
                        <div class="job-apply-form__field">
                            <label class="job-apply-form__label">Email</label>
                            <input type="email" name="applicant_email" class="job-apply-form__input" required>
                        </div>
                        
                        <div class="job-apply-form__field">
                            <label class="job-apply-form__label">LinkedIn profile</label>
                            <input type="url" name="applicant_linkedin" class="job-apply-form__input" placeholder="https://linkedin.com/in/...">
                        </div>
                        
                        <div class="job-apply-form__field">
                            <label class="job-apply-form__label">Resume</label>
                            <div class="job-apply-form__upload">
                                <input type="file" name="applicant_resume" id="resume-upload" class="job-apply-form__file" accept=".pdf,.doc,.docx">
                                <label for="resume-upload" class="job-apply-form__upload-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Upload
                                </label>
                                <span class="job-apply-form__filename"></span>
                            </div>
                        </div>
                        
                        <button type="submit" class="job-apply-form__submit">
                            <span class="job-apply-form__submit-dot"></span>
                            Submit
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show filename when file is selected
    const fileInput = document.getElementById('resume-upload');
    const filenameDisplay = document.querySelector('.job-apply-form__filename');
    
    if (fileInput && filenameDisplay) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                filenameDisplay.textContent = this.files[0].name;
            }
        });
    }
});
</script>

<?php endwhile; ?>

<!-- Success Modal -->
<div class="job-success-modal" id="jobSuccessModal">
    <div class="job-success-modal__backdrop"></div>
    <div class="job-success-modal__content">
        <button class="job-success-modal__close" type="button" aria-label="Close">✕ Close</button>
        <div class="job-success-modal__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="job-success-modal__title">Thanks!</h3>
        <p class="job-success-modal__text">We'll contact your as soon as possible.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('jobSuccessModal');
    var closeBtn = modal ? modal.querySelector('.job-success-modal__close') : null;
    var backdrop = modal ? modal.querySelector('.job-success-modal__backdrop') : null;

    // Show modal on CF7 success
    document.addEventListener('wpcf7mailsent', function(event) {
        if (modal) {
            modal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        }
    }, false);

    // Close modal
    function closeModal() {
        if (modal) {
            modal.classList.remove('is-active');
            document.body.style.overflow = '';
        }
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (backdrop) backdrop.addEventListener('click', closeModal);

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('is-active')) {
            closeModal();
        }
    });
});
</script>

<?php get_footer(); ?>

