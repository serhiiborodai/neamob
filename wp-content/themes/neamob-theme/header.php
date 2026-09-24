<?php
/**
 * Header template
 *
 * @package Neamob_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta
        name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Google Tag Manager -->
        <script>
            (function (w, d, s, l, i) {
w[l] = w[l] || [];
w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
var f = d.getElementsByTagName(s)[0],
j = d.createElement(s),
dl = l != 'dataLayer' ? '&l=' + l : '';
j.async = true;
j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
f.parentNode.insertBefore(j, f);
})(window, document, 'script', 'dataLayer', 'GTM-TQB84FGB');
        </script>
        <!-- End Google Tag Manager -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
        <link rel="preconnect" href="https://unpkg.com" crossorigin>
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/favicon-32x32.png'); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/favicon-16x16.png'); ?>">
        <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/favicon.ico'); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/apple-touch-icon.png'); ?>">
        <link
        rel="manifest" href="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/site.webmanifest'); ?>">
    <?php wp_head(); ?>
    </head>

    <body
        <?php body_class(); ?>>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQB84FGB" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php wp_body_open(); ?>

        <div id="page" class="site">
            <a
                class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'neamob-theme'); ?>
            </a>

            <header id="masthead" class="site-header<?php echo (function_exists('neamob_is_redesign_preview') && neamob_is_redesign_preview()) ? ' site-header--v2' : ''; ?>">
                <div class="container">
                    <div
                        class="site-header__inner">
                        <!-- Logo -->
                        <div
                            class="site-branding">
                            <?php if (has_custom_logo()): ?>
                                <div
                                    class="site-logo"><?php the_custom_logo(); ?>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo site-logo--text" rel="home">
                                    <span class="site-logo__text">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo__img">
                                    </span>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Navigation -->
                        <nav id="site-navigation" class="main-nav">
                            <span class="menu-mobile__toggle">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/menu.svg'); ?>" alt="" width="40" height="40">
                            </span>
                            <?php if (function_exists('neamob_is_redesign_preview') && neamob_is_redesign_preview()): ?>
                                <ul id="primary-menu" class="nav-menu nav-menu--v2">
                                    <li class="menu-item-has-children menu-item--services">
                                        <a href="<?php echo esc_url(home_url('/services/')); ?>">Services</a>
                                        <?php
                                        $mega_services = [
                                            [
                                                'slug' => 'growth-strategy-planning',
                                                'title' => 'Growth strategy',
                                                'text' => 'Custom roadmaps built for profit, not vanity metrics.',
                                            ],
                                            [
                                                'slug' => 'creative-design',
                                                'title' => 'Creative and design',
                                                'text' => 'Ad creative and brand work that earns attention.',
                                            ],
                                            [
                                                'slug' => 'data-analytics-insights',
                                                'title' => 'Data and analytics',
                                                'text' => 'Reporting that turns raw data into decisions.',
                                            ],
                                            [
                                                'slug' => 'media-campaigns',
                                                'title' => 'Media and campaigns',
                                                'text' => 'Paid media managed to measurable ROI.',
                                            ],
                                        ];
                                        ?>
                                        <div class="services-mega" role="menu" aria-label="Services">
                                            <div class="services-mega__grid">
                                                <?php foreach ($mega_services as $item):
                                                    $icon = function_exists('neamob_get_service_card_icon')
                                                        ? neamob_get_service_card_icon($item['slug'])
                                                        : ['url' => '', 'bg' => 'rgba(0,148,255,0.12)'];
                                                    $href = home_url('/services/' . $item['slug'] . '/');
                                                    ?>
                                                    <a class="services-mega__item" href="<?php echo esc_url($href); ?>" role="menuitem">
                                                        <span class="services-mega__head">
                                                            <span class="services-mega__icon" style="--icon-bg: <?php echo esc_attr($icon['bg']); ?>">
                                                                <?php if (!empty($icon['url'])): ?>
                                                                    <img src="<?php echo esc_url($icon['url']); ?>" alt="" width="14" height="14">
                                                                <?php endif; ?>
                                                            </span>
                                                            <strong class="services-mega__title"><?php echo esc_html($item['title']); ?></strong>
                                                        </span>
                                                        <span class="services-mega__text"><?php echo esc_html($item['text']); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                            <aside class="services-mega__featured">
                                                <div class="services-mega__featured-copy">
                                                    <p class="services-mega__label">Featured result</p>
                                                    <p class="services-mega__metric">+468%</p>
                                                    <p class="services-mega__desc">Qualified leads for Canadian Centre for Addictions</p>
                                                </div>
                                                <a href="#audit-form" class="btn btn--cta btn--cta-v2 services-mega__cta" data-open-audit-form>
                                                    <span class="btn__dot"></span>
                                                    <span>Book a Free Audit</span>
                                                </a>
                                            </aside>
                                        </div>
                                    </li>
                                    <li><a href="<?php echo esc_url(home_url('/business-intelligence/')); ?>">Business Intelligence</a></li>
                                    <li class="menu-item-has-children menu-item--work">
                                        <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Work</a>
                                        <?php
                                        $theme_uri = get_template_directory_uri();
                                        $mega_work = [
                                            [
                                                'href' => home_url('/case-studies/'),
                                                'title' => 'Case studies',
                                                'text' => 'Real projects, real numbers.',
                                                'icon' => $theme_uri . '/assets/icons/redesign/case-studies.svg',
                                                'bg' => 'rgba(0, 148, 255, 0.12)',
                                            ],
                                            [
                                                'href' => home_url('/portfolio/'),
                                                'title' => 'Portfolio',
                                                'text' => 'Selected work across brands and channels.',
                                                'icon' => $theme_uri . '/assets/icons/redesign/portfolio.svg',
                                                'bg' => 'rgba(0, 148, 255, 0.12)',
                                            ],
                                        ];
                                        ?>
                                        <div class="nav-mega nav-mega--work work-mega" role="menu" aria-label="Work">
                                            <div class="nav-mega__grid nav-mega__grid--stack work-mega__grid">
                                                <?php foreach ($mega_work as $item): ?>
                                                    <a class="nav-mega__item" href="<?php echo esc_url($item['href']); ?>" role="menuitem">
                                                        <span class="nav-mega__head">
                                                            <span class="nav-mega__icon" style="--icon-bg: <?php echo esc_attr($item['bg']); ?>">
                                                                <img src="<?php echo esc_url($item['icon']); ?>" alt="" width="14" height="14">
                                                            </span>
                                                            <strong class="nav-mega__title"><?php echo esc_html($item['title']); ?></strong>
                                                        </span>
                                                        <span class="nav-mega__text"><?php echo esc_html($item['text']); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                            <aside class="nav-mega__featured">
                                                <div class="nav-mega__featured-copy">
                                                    <p class="nav-mega__label">Featured result</p>
                                                    <p class="nav-mega__metric">1,200+</p>
                                                    <p class="nav-mega__desc">Creatives shipped for 30+ brands.</p>
                                                </div>
                                                <a href="#audit-form" class="btn btn--cta btn--cta-v2 nav-mega__cta" data-open-audit-form>
                                                    <span class="btn__dot"></span>
                                                    <span>Book a Free Audit</span>
                                                </a>
                                            </aside>
                                        </div>
                                    </li>
                                    <li class="menu-item-has-children menu-item--about">
                                        <a href="<?php echo esc_url(home_url('/about-us/')); ?>">About Us</a>
                                        <?php
                                        $mega_about = [
                                            [
                                                'href' => home_url('/careers/'),
                                                'title' => 'Careers',
                                                'text' => 'Grow your career with us.',
                                                'icon' => $theme_uri . '/assets/icons/redesign/careers.svg',
                                                'bg' => 'rgba(0, 148, 255, 0.12)',
                                            ],
                                            [
                                                'href' => 'https://adverdly.com/',
                                                'title' => 'Analysis Tool',
                                                'text' => 'Analyze your marketing in minutes.',
                                                'icon' => $theme_uri . '/assets/icons/redesign/analysis-tool.svg',
                                                'bg' => 'rgba(0, 148, 255, 0.12)',
                                                'external' => true,
                                            ],
                                        ];
                                        ?>
                                        <div class="nav-mega nav-mega--about about-mega" role="menu" aria-label="About Us">
                                            <div class="nav-mega__grid nav-mega__grid--stack about-mega__grid">
                                                <?php foreach ($mega_about as $item): ?>
                                                    <a class="nav-mega__item" href="<?php echo esc_url($item['href']); ?>" role="menuitem"<?php echo !empty($item['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                                                        <span class="nav-mega__head">
                                                            <span class="nav-mega__icon" style="--icon-bg: <?php echo esc_attr($item['bg']); ?>">
                                                                <img src="<?php echo esc_url($item['icon']); ?>" alt="" width="14" height="14">
                                                            </span>
                                                            <strong class="nav-mega__title"><?php echo esc_html($item['title']); ?></strong>
                                                        </span>
                                                        <span class="nav-mega__text"><?php echo esc_html($item['text']); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                            <aside class="nav-mega__featured">
                                                <div class="nav-mega__featured-copy">
                                                    <p class="nav-mega__label">Featured result</p>
                                                    <p class="nav-mega__metric">30+</p>
                                                    <p class="nav-mega__desc">Happy employees.</p>
                                                </div>
                                                <a href="#audit-form" class="btn btn--cta btn--cta-v2 nav-mega__cta" data-open-audit-form>
                                                    <span class="btn__dot"></span>
                                                    <span>Book a Free Audit</span>
                                                </a>
                                            </aside>
                                        </div>
                                    </li>
                                    <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a></li>
                                </ul>
                            <?php else:
                                wp_nav_menu([
                                    'theme_location' => 'primary',
                                    'menu_id' => 'primary-menu',
                                    'menu_class' => 'nav-menu',
                                    'container' => false,
                                    'fallback_cb' => false,
                                ]);
                            endif; ?>
                        </nav>

                        <!-- CTA Button -->
                        <?php
                        $is_redesign = function_exists('neamob_is_redesign_preview') && neamob_is_redesign_preview();
                        $cta_text = $is_redesign
                            ? 'Book a Free Audit'
                            : neamob_get_theme_option('header_cta_text', "Let's Chat");
                        $cta_url = $is_redesign
                            ? '#audit-form'
                            : neamob_get_theme_option('header_cta_url', '/contact');
                        $cta_href = (strpos($cta_url, 'http') === 0 || strpos($cta_url, '#') === 0)
                            ? $cta_url
                            : home_url($cta_url);
                        ?>
                        <div class="header-cta">
                            <a href="<?php echo esc_url($cta_href); ?>"
                               class="btn btn--cta<?php echo $is_redesign ? ' btn--cta-v2' : ''; ?>"
                               <?php echo $is_redesign ? ' data-open-audit-form' : ''; ?>>
                                <?php if ($is_redesign): ?>
                                    <span class="btn__dot"></span>
                                    <span><?php echo esc_html($cta_text); ?></span>
                                <?php else: ?>
                                    <span><?php echo esc_html($cta_text); ?></span>
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                <?php endif; ?>
                            </a>
                        </div>

                    </div>
                </div>
            </header>

