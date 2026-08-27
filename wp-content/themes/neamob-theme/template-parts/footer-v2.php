<?php
/**
 * Footer — redesign layout (homepage preview)
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$footer_email = neamob_get_theme_option('footer_email', 'info@neamob.com');
$social_fb = neamob_get_theme_option('footer_social_facebook', 'https://facebook.com/neamob');
$social_ig = neamob_get_theme_option('footer_social_instagram', 'https://www.instagram.com/neamob.tech/');
$social_li = neamob_get_theme_option('footer_social_linkedin', 'https://linkedin.com/company/neamob');
?>
<footer id="colophon" class="site-footer site-footer--v2">
    <div class="footer-main footer-main--v2">
        <div class="container">
            <div class="footer-grid footer-grid--v2">
                <div class="footer-column">
                    <h4 class="footer-column__title">Services &amp; Solutions</h4>
                    <ul class="footer-column__links">
                        <li><a href="<?php echo esc_url(home_url('/services/growth-strategy-planning/')); ?>">Growth Strategy &amp; Planning</a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/data-analytics-insights/')); ?>">Data Analytics &amp; Insights</a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/creative-design/')); ?>">Creative &amp; Design</a></li>
                        <li><a href="<?php echo esc_url(home_url('/services/media-campaigns/')); ?>">Media &amp; Campaigns</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column__title">
                        <a href="<?php echo esc_url(home_url('/business-intelligence/')); ?>">Business Intelligence</a>
                    </h4>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column__title">Work</h4>
                    <ul class="footer-column__links">
                        <li><a href="<?php echo esc_url(home_url('/case-studies/')); ?>">Case Studies</a></li>
                        <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Portfolio</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column__title">
                        <a href="<?php echo esc_url(home_url('/about-us/')); ?>">About Us</a>
                    </h4>
                    <ul class="footer-column__links">
                        <li><a href="<?php echo esc_url(home_url('/careers/')); ?>">Careers</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column__title">
                        <a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a>
                    </h4>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column__title">Connect</h4>
                    <ul class="footer-column__links">
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Let's Chat</a></li>
                        <?php if ($footer_email): ?>
                            <li><a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo esc_url(home_url('/careers/')); ?>">Careers</a></li>
                        <?php if ($social_fb): ?><li><a href="<?php echo esc_url($social_fb); ?>" target="_blank" rel="noopener noreferrer">Facebook</a></li><?php endif; ?>
                        <?php if ($social_ig): ?><li><a href="<?php echo esc_url($social_ig); ?>" target="_blank" rel="noopener noreferrer">Instagram</a></li><?php endif; ?>
                        <?php if ($social_li): ?><li><a href="<?php echo esc_url($social_li); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a></li><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom footer-bottom--v2">
        <div class="container">
            <div class="footer-bottom__inner">
                <div class="footer-copyright">&copy; <?php echo esc_html(date('Y')); ?> NeaMob Tech. All rights reserved.</div>
                <div class="footer-legal">
                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>
                    <span class="separator">|</span>
                    <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
