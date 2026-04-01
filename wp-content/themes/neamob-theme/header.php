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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/favicon.png'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php esc_html_e('Skip to content', 'neamob-theme'); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-header__inner">
                <!-- Logo -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
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
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ]);
                    ?>
                </nav>

                <!-- CTA Button -->
                <?php
                $cta_text = neamob_get_theme_option('header_cta_text', "Let's Chat");
                $cta_url = neamob_get_theme_option('header_cta_url', '/contact');
                $cta_href = (strpos($cta_url, 'http') === 0) ? $cta_url : home_url($cta_url);
                ?>
                <div class="header-cta">
                    <a href="<?php echo esc_url($cta_href); ?>" class="btn btn--cta">
                        <span><?php echo esc_html($cta_text); ?></span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </header>
