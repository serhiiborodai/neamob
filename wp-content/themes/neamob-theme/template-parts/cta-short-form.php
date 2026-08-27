<?php
/**
 * Template Part: CTA Short Form (homepage redesign)
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$form_id = neamob_get_home_cta_short_form_id();
if (!$form_id || !class_exists('WPCF7')) {
    return;
}

$title = get_field('cta_short_title') ?: 'Ready to see your numbers grow?';
$text = get_field('cta_short_text') ?: 'Fill out the form and our team will get back to you within 48 hours.';
?>
<section class="cta-short-section" id="cta-short-form">
    <div class="container">
        <div class="cta-short-section__header">
            <h2 class="cta-short-section__title"><?php echo esc_html($title); ?></h2>
            <p class="cta-short-section__text"><?php echo esc_html($text); ?></p>
        </div>
        <div class="cta-short-section__form">
            <?php echo do_shortcode('[contact-form-7 id="' . intval($form_id) . '" title="Home CTA Short"]'); ?>
        </div>
    </div>
</section>
