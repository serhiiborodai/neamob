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
                    <!-- Services & Solutions -->
                    <div class="footer-column">
                        <h4 class="footer-column__title">
                            <a href="<?php echo esc_url(home_url('/services/')); ?>">Services & Solutions</a>
                        </h4>
                        <ul class="footer-column__links">
                            <li><a href="<?php echo esc_url(home_url('/services/growth-strategy-planning/')); ?>">Growth Strategy & Planning</a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/data-analytics-insights/')); ?>">Data Analytics & Insights</a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/creative-experience-design/')); ?>">Creative & Experience Design</a></li>
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
                            <li><a href="<?php echo esc_url(home_url('/case-studies/')); ?>">Case Studies</a></li>
                            <li><a href="<?php echo esc_url(home_url('/portfolio/creative-showcase/')); ?>">Creative Showcase</a></li>
                            <li><a href="<?php echo esc_url(home_url('/portfolio/web-projects/')); ?>">Web Projects</a></li>
                            <li><a href="<?php echo esc_url(home_url('/portfolio/social-media-campaigns/')); ?>">Social Media Campaigns</a></li>
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
                    <div class="footer-column">
                        <h4 class="footer-column__title">
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>">Connect</a>
                        </h4>
                        <ul class="footer-column__links">
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Let's Chat</a></li>
                            <li><a href="mailto:info@neamob.com">info@neamob.com</a></li>
                            <li><a href="<?php echo esc_url(home_url('/careers/')); ?>">Careers</a></li>
                            <li><a href="https://facebook.com/neamob" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                            <li><a href="https://instagram.com/neamob" target="_blank" rel="noopener noreferrer">Instagram</a></li>
                            <li><a href="https://linkedin.com/company/neamob" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
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
