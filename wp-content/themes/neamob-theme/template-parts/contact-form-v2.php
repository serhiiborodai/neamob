<?php
/**
 * Contact Form Section — redesign layout
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$contact_title = neamob_get_theme_option('contact_form_title', 'Get in touch');
$contact_text = neamob_get_theme_option('contact_form_text', "Ready to take your marketing to the next level? Fill out the form and our team will get back to you within 48 hours.");
?>
<section class="contact-form-section contact-form-section--v2" id="contact-form">
    <div class="container">
        <div class="contact-form-section__grid">
            <div class="contact-form-section__content">
                <h2 class="contact-form-section__title"><?php echo esc_html($contact_title); ?></h2>
                <p class="contact-form-section__text"><?php echo esc_html($contact_text); ?></p>
                <div class="contact-form-section__image">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/form_obj.png'); ?>" alt="" width="542" height="947" loading="lazy">
                </div>
            </div>
            <div class="contact-form-section__form">
                <?php
                if (class_exists('WPCF7')) {
                    echo do_shortcode('[contact-form-7 id="60" title="Contact Form"]');
                }
                ?>
            </div>
        </div>
    </div>
</section>
