<?php
/**
 * Footer template
 *
 * @package Neamob_Theme
 */
?>

    <footer id="colophon" class="site-footer">
        <!-- Footer Main -->
        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">
                    <!-- Services & Solutions — заголовок без href (как в меню), подпункты со ссылками -->
                    <div class="footer-column">
                        <h4 class="footer-column__title">Services & Solutions</h4>
                        <ul class="footer-column__links">
                            <li><a href="<?php echo esc_url(home_url('/services/growth-strategy-planning/')); ?>">Growth Strategy & Planning</a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/data-analytics-insights/')); ?>">Data Analytics & Insights</a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/creative-design/')); ?>">Creative & Design</a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/media-campaigns/')); ?>">Media & Campaigns</a></li>
                        </ul>
                    </div>

                    <!-- Business Intelligence -->
                    <div class="footer-column">
                        <h4 class="footer-column__title">
                            <a href="<?php echo esc_url(home_url('/business-intelligence/')); ?>">Business Intelligence</a>
                        </h4>
                    </div>

                    <!-- Portfolio -->
                    <div class="footer-column">
                        <h4 class="footer-column__title">
                            <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Portfolio</a>
                        </h4>
                        <ul class="footer-column__links">
                            <li><a href="<?php echo esc_url(home_url('/portfolio/#branding')); ?>">Creative Showcase</a></li>
                            <li><a href="<?php echo esc_url(home_url('/portfolio/#web-projects')); ?>">Web Projects</a></li>
                            <li><a href="<?php echo esc_url(home_url('/portfolio/#social-media-campaigns')); ?>">Social Media Campaigns</a></li>
                        </ul>
                    </div>

                    <!-- Case Studies -->
                    <div class="footer-column">
                        <h4 class="footer-column__title">
                            <a href="<?php echo esc_url(home_url('/case-studies/')); ?>">Case Studies</a>
                        </h4>
                    </div>

                    <!-- About Us -->
                    <div class="footer-column">
                        <h4 class="footer-column__title">
                            <a href="<?php echo esc_url(home_url('/about-us/')); ?>">About Us</a>
                        </h4>
                        <ul class="footer-column__links">
                            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a></li>
                        </ul>
                    </div>

                    <!-- Connect -->
                    <?php
                    $footer_email = neamob_get_theme_option('footer_email', 'info@neamob.com');
                    $social_fb = neamob_get_theme_option('footer_social_facebook', 'https://facebook.com/neamob');
                    $social_ig = neamob_get_theme_option('footer_social_instagram', 'https://www.instagram.com/neamob.tech/');
                    $social_li = neamob_get_theme_option('footer_social_linkedin', 'https://linkedin.com/company/neamob');
                    ?>
                    <div class="footer-column">
                        <h4 class="footer-column__title">Connect</h4>
                        <ul class="footer-column__links">
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Let's Chat</a></li>
                            <?php if ($footer_email): ?><li><a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a></li><?php endif; ?>
                            <li><a href="<?php echo esc_url(home_url('/careers/')); ?>">Careers</a></li>
                            <?php if ($social_fb): ?><li><a href="<?php echo esc_url($social_fb); ?>" target="_blank" rel="noopener noreferrer">Facebook</a></li><?php endif; ?>
                            <?php if ($social_ig): ?><li><a href="<?php echo esc_url($social_ig); ?>" target="_blank" rel="noopener noreferrer">Instagram</a></li><?php endif; ?>
                            <?php if ($social_li): ?><li><a href="<?php echo esc_url($social_li); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a></li><?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom__inner">
                    <div class="footer-copyright">
                        &copy; <?php echo date('Y'); ?> NeaMob Tech. All rights reserved.
                    </div>
                    <div class="footer-legal">
                        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>
                        <span class="separator">|</span>
                        <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
