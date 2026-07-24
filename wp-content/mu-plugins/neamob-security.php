<?php
/**
 * Plugin Name: Neamob Security
 * Description: REST hardening and Contact Form 7 anti-spam (honeypot, rate limit, reCAPTCHA v3).
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * reCAPTCHA v3 keys from wp-config.php (CF7 built-in integration).
 */
function neamob_security_recaptcha_configured(): bool
{
    $sitekey = defined('WPCF7_RECAPTCHA_SITEKEY') ? (string) WPCF7_RECAPTCHA_SITEKEY : '';
    $secret = defined('WPCF7_RECAPTCHA_SECRET') ? (string) WPCF7_RECAPTCHA_SECRET : '';

    return $sitekey !== '' && $secret !== '';
}

/**
 * Block unauthenticated access to the REST batch endpoint (wp2shell mitigation).
 */
add_filter('rest_pre_dispatch', function ($result, $server, $request) {
    if ($result !== null) {
        return $result;
    }

    if (is_user_logged_in() && current_user_can('read')) {
        return $result;
    }

    $route = (string) $request->get_route();
    if (preg_match('#^/batch/v1(?:/|$)#i', $route)) {
        return new WP_Error(
            'rest_batch_forbidden',
            'Batch endpoint requires authentication.',
            ['status' => 403]
        );
    }

    return $result;
}, 5, 3);

/**
 * Honeypot field for all CF7 forms (bots often fill every input).
 */
add_filter('wpcf7_form_elements', function ($elements) {
    $honeypot = '<div class="neamob-hp" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;">'
        . '<label>Website<input type="text" name="neamob_website" tabindex="-1" autocomplete="off" value=""></label>'
        . '</div>';

    return $elements . $honeypot;
});

add_filter('wpcf7_spam', function ($spam, $submission) {
    if ($spam) {
        return $spam;
    }

    if (!empty($_POST['neamob_website'])) {
        if ($submission instanceof WPCF7_Submission) {
            $submission->add_spam_log([
                'agent' => 'neamob_honeypot',
                'reason' => 'Honeypot field was filled.',
            ]);
        }
        return true;
    }

    return $spam;
}, 5, 2);

/**
 * Simple per-IP rate limit for CF7 (max 8 submissions / hour).
 */
add_filter('wpcf7_spam', function ($spam, $submission) {
    if ($spam) {
        return $spam;
    }

    $ip = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
    if ($ip === '') {
        return $spam;
    }

    $key = 'neamob_cf7_rl_' . md5($ip);
    $count = (int) get_transient($key);
    if ($count >= 8) {
        if ($submission instanceof WPCF7_Submission) {
            $submission->add_spam_log([
                'agent' => 'neamob_rate_limit',
                'reason' => 'Too many form submissions from this IP.',
            ]);
        }
        return true;
    }

    set_transient($key, $count + 1, HOUR_IN_SECONDS);

    return $spam;
}, 15, 2);

/**
 * Ensure [recaptcha] tag exists in every CF7 form when keys are configured.
 */
function neamob_security_cf7_ensure_recaptcha_tag(): void
{
    if (!neamob_security_recaptcha_configured()) {
        return;
    }

    if (get_option('neamob_cf7_recaptcha_tag_v1')) {
        return;
    }

    if (!class_exists('WPCF7_ContactForm')) {
        return;
    }

    $posts = get_posts([
        'post_type' => 'wpcf7_contact_form',
        'post_status' => 'any',
        'posts_per_page' => -1,
        'fields' => 'ids',
    ]);

    foreach ($posts as $post_id) {
        $form = WPCF7_ContactForm::get_instance((int) $post_id);
        if (!$form) {
            continue;
        }

        $template = (string) $form->prop('form');
        if (stripos($template, '[recaptcha') !== false) {
            continue;
        }

        $template = rtrim($template) . "\n\n[recaptcha]\n";
        $form->set_properties(['form' => $template]);
        $form->save();
    }

    update_option('neamob_cf7_recaptcha_tag_v1', 1, false);
}
add_action('init', 'neamob_security_cf7_ensure_recaptcha_tag', 99);

add_action('admin_notices', function () {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (neamob_security_recaptcha_configured()) {
        return;
    }

    echo '<div class="notice notice-warning"><p><strong>Neamob Security:</strong> '
        . 'Добавьте <code>WPCF7_RECAPTCHA_SITEKEY</code> и <code>WPCF7_RECAPTCHA_SECRET</code> (reCAPTCHA v3) в <code>wp-config.php</code> '
        . 'для капчи на всех формах Contact Form 7. Пока работают honeypot и лимит по IP.</p></div>';
});
