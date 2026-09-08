<?php
/**
 * Audit form popup — Figma node 6454:24966 (header Book a Free Audit).
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('neamob_get_home_cta_short_form_id')) {
    return;
}

$form_id = neamob_get_home_cta_short_form_id();
if (!$form_id || !class_exists('WPCF7')) {
    return;
}

$title = get_field('cta_short_title') ?: 'Ready to see your numbers grow?';
$text = get_field('cta_short_text') ?: 'Fill out the form and our team will get back to you within 48 hours.';
?>
<div class="audit-form-overlay" id="audit-form-overlay" hidden>
    <div class="audit-form-overlay__backdrop" data-close-audit-form></div>
    <div class="audit-form-overlay__dialog" role="dialog" aria-modal="true" aria-labelledby="audit-form-overlay-title">
        <button type="button" class="audit-form-overlay__close" aria-label="Close" data-close-audit-form>&times;</button>
        <h2 class="audit-form-overlay__title" id="audit-form-overlay-title"><?php echo esc_html($title); ?></h2>
        <p class="audit-form-overlay__text"><?php echo esc_html($text); ?></p>
        <div class="audit-form-overlay__form">
            <?php
            $form_html = do_shortcode('[contact-form-7 id="' . intval($form_id) . '" title="Home CTA Short"]');
            // CF7 can leave a literal [recaptcha] when the tag is not expanded
            $form_html = preg_replace('/\[recaptcha[^\]]*\]/i', '', $form_html);
            echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
        </div>
    </div>
</div>
