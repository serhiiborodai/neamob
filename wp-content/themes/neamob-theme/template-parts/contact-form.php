<?php
/**
 * Template Part: Contact Form Section
 * Can be included on any page with: get_template_part('template-parts/contact-form');
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="contact-form-section" id="contact-form">
    <div class="container">
        <div class="contact-form-section__grid">
            <div class="contact-form-section__content">
                <h2 class="contact-form-section__title">Get in touch</h2>
                <p class="contact-form-section__text">Ready to take your marketing to the next level? Fill out the form and our team will get back to you within 48 hours.</p>
                <div class="contact-form-section__image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/form_obj.png" alt="Get in touch">
                </div>
            </div>
            <div
                class="contact-form-section__form">
                <?php
                // Check if Contact Form 7 is active
                if (class_exists('WPCF7')) {
                    // Use CF7 form (ID: 60)
                    echo do_shortcode('[contact-form-7 id="60" title="Contact Form"]');
                } else {
                    // Fallback HTML form
                    ?>
                    <form class="neamob-contact-form" action="#" method="post">
                        <div class="neamob-contact-form__row">
                            <div class="neamob-contact-form__field">
                                <label class="neamob-contact-form__label">Full name</label>
                                <input type="text" name="full_name" class="neamob-contact-form__input" required>
                            </div>
                            <div class="neamob-contact-form__field">
                                <label class="neamob-contact-form__label">Last name</label>
                                <input type="text" name="last_name" class="neamob-contact-form__input" required>
                            </div>
                        </div>
                        <div class="neamob-contact-form__field">
                            <label class="neamob-contact-form__label">Email</label>
                            <input type="email" name="email" class="neamob-contact-form__input" required>
                        </div>
                        <div class="neamob-contact-form__field">
                            <label class="neamob-contact-form__label">Phone number</label>
                            <input type="tel" name="phone" class="neamob-contact-form__input">
                        </div>
                        <div class="neamob-contact-form__field">
                            <label class="neamob-contact-form__label">Company name</label>
                            <input type="text" name="company" class="neamob-contact-form__input">
                        </div>
                        <div class="neamob-contact-form__field">
                            <label class="neamob-contact-form__label">Role</label>
                            <select name="role" class="neamob-contact-form__select">
                                <option value="">Select...</option>
                                <option value="ceo">CEO / Founder</option>
                                <option value="cmo">CMO / Marketing Director</option>
                                <option value="manager">Marketing Manager</option>
                                <option value="specialist">Marketing Specialist</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="neamob-contact-form__field">
                            <label class="neamob-contact-form__label">Interest</label>
                            <select name="interest" class="neamob-contact-form__select">
                                <option value="">Select...</option>
                                <option value="strategy">Strategy & Planning</option>
                                <option value="analytics">Analytics & Reporting</option>
                                <option value="creative">Creative & Design</option>
                                <option value="media">Media Buying</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="neamob-contact-form__field">
                            <label class="neamob-contact-form__label">Leave us a message</label>
                            <textarea name="message" class="neamob-contact-form__textarea" rows="4"></textarea>
                        </div>
                        <button type="submit" class="neamob-contact-form__submit">Submit</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

