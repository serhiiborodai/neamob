<?php
/**
 * Homepage redesign — sections 4–11
 *
 * @package Neamob_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$value_title = get_field('value_title') ?: 'We focus on what brings value & the bottom line';
$value_text = get_field('value_text') ?: 'We transform raw data into insights with analytics, visualization, and infrastructure to drive smarter decisions and better performance.';
$value_button_text = get_field('value_button_text') ?: 'Book a Free Audit';
$value_button_link = get_field('value_button_link');
$value_button_url = ($value_button_link && !empty($value_button_link['url'])) ? $value_button_link['url'] : '#contact-form';
$value_stats_text = get_field('value_stats_text') ?: 'Built a targeting framework and ran keyword analysis for audience insights that resulted in';
$value_stats_number = get_field('value_stats_number') ?: '+358%';
$value_stats_label = get_field('value_stats_label') ?: 'Qualified Leads YoY';
$value_image = get_field('value_image');
$value_report_groups = get_field('value_report_groups');
if (empty($value_report_groups) || !is_array($value_report_groups)) {
    $value_report_groups = [
        ['group_title' => 'Money', 'group_items' => 'Profitability · Cash Flow · Lifetime value · Cost per Acquisition'],
        ['group_title' => 'Channels', 'group_items' => 'Amazon and Shopify · Offline/Organic Tracking'],
        ['group_title' => 'Growth', 'group_items' => 'Forecasting · Funnel Analysis · Traffic Sources · Attribution'],
    ];
}

$comparison_title = get_field('comparison_title') ?: 'Why choose NeaMob Tech?';
$faq_cta_text = get_field('faq_cta_text') ?: 'Book a Free Audit';
$faq_cta_link = get_field('faq_cta_link');
$faq_cta_url = ($faq_cta_link && !empty($faq_cta_link['url'])) ? $faq_cta_link['url'] : '#contact-form';

// BI visuals: laptop + stats card (from Downloads 000 1.png / Frame 2100226115.png)
// ?v= busts stale WebP Express 404 caches; .dontreplace siblings skip <picture> rewrite.
$laptop_url = add_query_arg('v', '2', get_template_directory_uri() . '/assets/images/value-laptop.png');
$stats_card_url = add_query_arg('v', '2', get_template_directory_uri() . '/assets/images/value-stats-card.png');
?>

<!-- Value / BI Section (Redesign) -->
<section class="value-section value-section--v2">
    <div class="container">
        <div class="value-section__grid">
            <div class="value-section__content">
                <h2 class="value-section__title"><?php echo esc_html($value_title); ?></h2>
                <p class="value-section__text"><?php echo esc_html($value_text); ?></p>
                <a href="<?php echo esc_url($value_button_url); ?>" class="btn btn--hero btn--hero-v2">
                    <span class="btn__dot"></span>
                    <span><?php echo esc_html($value_button_text); ?></span>
                </a>
            </div>
            <div class="value-section__visual">
                <div class="value-stats-card value-stats-card--v2">
                    <img src="<?php echo esc_url($stats_card_url); ?>" alt="<?php echo esc_attr(trim($value_stats_number . ' ' . $value_stats_label)); ?>" width="230" height="140" loading="lazy">
                </div>
                <div class="value-laptop value-laptop--v2">
                    <img src="<?php echo esc_url($laptop_url); ?>" alt="NeaMob Dashboard" loading="lazy">
                </div>
            </div>
        </div>
        <div class="value-reports value-reports--v2">
            <p class="value-reports__label">Some of Our Reports</p>
            <div class="value-reports__rule" aria-hidden="true"></div>
            <div class="value-reports__columns">
                <?php foreach ($value_report_groups as $group):
                    $title = trim($group['group_title'] ?? '');
                    $items = trim($group['group_items'] ?? '');
                    if ($title === '' && $items === '') {
                        continue;
                    }
                ?>
                <div class="value-reports__column">
                    <?php if ($title): ?><h3 class="value-reports__column-title"><?php echo esc_html($title); ?></h3><?php endif; ?>
                    <?php if ($items): ?><p class="value-reports__column-items"><?php echo esc_html($items); ?></p><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Case Studies (Redesign) -->
<?php
$case_studies = neamob_get_case_studies([
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'meta_query' => [
        [
            'key' => 'show_on_homepage',
            'value' => '1',
            'compare' => '=',
        ],
    ],
]);
if ($case_studies->have_posts()):
?>
<section class="case-studies-section case-studies-section--v2">
    <div class="container">
        <div class="case-studies-section__header">
            <h2 class="case-studies-section__title">Case studies</h2>
            <a href="<?php echo esc_url(get_post_type_archive_link('case_study')); ?>" class="case-studies-section__link case-studies-section__link--v2">
                <span class="case-studies-section__link-dot"></span>
                View More
            </a>
        </div>
        <div class="home-v2-carousel" data-home-v2-carousel>
            <div class="case-studies-grid case-studies-grid--v2" data-home-v2-track>
                <?php while ($case_studies->have_posts()):
                    $case_studies->the_post();
                    $client_name = get_field('client_name') ?: get_post_meta(get_the_ID(), '_case_study_client_name', true);
                    $client_logo = get_field('client_logo') ?: get_post_meta(get_the_ID(), '_case_study_client_logo', true);
                    if (is_array($client_logo) && isset($client_logo['url'])) {
                        $client_logo = $client_logo['url'];
                    }
                    $badge_value = get_field('badge_value') ?: get_post_meta(get_the_ID(), '_case_study_badge_value', true);
                    $badge_text = get_field('badge_text') ?: get_post_meta(get_the_ID(), '_case_study_badge_text', true);
                    $coming_soon = (bool) get_field('case_coming_soon');
                    $card_image = get_field('homepage_card_image') ?: get_the_post_thumbnail_url(get_the_ID(), 'card-image');
                    $hp_desc = get_field('homepage_description') ?: get_field('case_excerpt') ?: wp_trim_words(get_the_excerpt(), 50);
                    $read_more_url = get_field('case_read_more_url');
                    $card_class = 'case-card-v2' . ($coming_soon ? ' case-card-v2--soon' : '');
                ?>
                <div class="home-v2-carousel__slide" data-home-v2-slide>
                    <article class="<?php echo esc_attr($card_class); ?>">
                        <div class="case-card-v2__media">
                            <?php if ($card_image): ?>
                                <img src="<?php echo esc_url($card_image); ?>" alt="<?php echo esc_attr($client_name ?: get_the_title()); ?>" loading="lazy">
                            <?php else: ?>
                                <div class="case-card-v2__media-placeholder" aria-hidden="true"></div>
                            <?php endif; ?>
                        </div>
                        <div class="case-card-v2__body">
                            <div class="case-card-v2__header">
                                <div class="case-card-v2__brand">
                                    <?php if ($client_logo): ?>
                                        <span class="case-card-v2__logo">
                                            <img src="<?php echo esc_url($client_logo); ?>" alt="<?php echo esc_attr($client_name ?: ''); ?>">
                                        </span>
                                    <?php elseif ($client_name): ?>
                                        <span class="case-card-v2__logo case-card-v2__logo--text"><?php echo esc_html($client_name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($badge_value && $badge_text): ?>
                                    <div class="case-card-v2__badge"><?php echo esc_html(trim($badge_value . ' ' . $badge_text)); ?></div>
                                <?php endif; ?>
                            </div>
                            <p class="case-card-v2__text"><?php echo wp_kses_post($hp_desc); ?></p>
                            <?php if ($coming_soon): ?>
                                <span class="case-card-v2__soon">Coming Soon</span>
                            <?php elseif ($read_more_url): ?>
                                <a href="<?php echo esc_url($read_more_url); ?>" class="case-card-v2__link">
                                    <span class="case-card-v2__link-dot" aria-hidden="true"></span>
                                    Read More
                                </a>
                            <?php else: ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="case-card-v2__link">
                                    <span class="case-card-v2__link-dot" aria-hidden="true"></span>
                                    Read More
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="swiper-pagination home-v2-pagination" data-home-v2-pagination></div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>

<!-- Testimonials (Redesign tabs) -->
<?php
$testimonials = neamob_get_testimonials();
$testimonial_items = [];
if ($testimonials->have_posts()) {
    while ($testimonials->have_posts()) {
        $testimonials->the_post();
        $name = get_field('author_name') ?: get_the_title();
        $company = get_field('company_name') ?: '';
        if ($company === '') {
            $title_for_company = html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8');
            if (preg_match('/[–—-]\s*(.+)$/u', $title_for_company, $company_match)) {
                $company = trim($company_match[1]);
            }
        }
        $position = get_field('author_position') ?: '';
        $initials = '';
        foreach (preg_split('/\s+/', trim($name)) as $part) {
            if ($part !== '') {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }
        $initials = substr($initials, 0, 2);
        $testimonial_items[] = [
            'quote'    => get_field('testimonial_quote'),
            'name'     => $name,
            'company'  => $company,
            'position' => $position,
            'initials' => $initials,
            'photo'    => get_field('author_photo'),
        ];
    }
    wp_reset_postdata();
}
if (!empty($testimonial_items)):
    $total = count($testimonial_items);
?>
<section class="testimonials-v2">
    <div class="container">
        <div class="testimonials-v2__panel">
            <div class="testimonials-v2__tabs" role="tablist">
                <?php foreach ($testimonial_items as $i => $item): ?>
                <button type="button"
                    class="testimonials-v2__tab<?php echo $i === 0 ? ' is-active' : ''; ?>"
                    role="tab"
                    aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                    data-index="<?php echo esc_attr((string) $i); ?>">
                    <span class="testimonials-v2__tab-text">
                        <strong><?php echo esc_html($item['name']); ?></strong>
                        <?php if ($item['company']): ?>
                            <span><?php echo esc_html($item['company']); ?></span>
                        <?php elseif ($item['position']): ?>
                            <span><?php echo esc_html($item['position']); ?></span>
                        <?php endif; ?>
                    </span>
                </button>
                <?php endforeach; ?>
            </div>
            <div class="testimonials-v2__content" data-home-v2-testimonials-track>
                <?php foreach ($testimonial_items as $i => $item): ?>
                <article class="testimonials-v2__slide<?php echo $i === 0 ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr((string) $i); ?>" data-home-v2-testimonials-slide>
                    <div class="testimonials-v2__counter">
                        <span class="testimonials-v2__counter-current"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <span class="testimonials-v2__counter-sep">/</span>
                        <span class="testimonials-v2__counter-total"><?php echo esc_html(str_pad((string) $total, 2, '0', STR_PAD_LEFT)); ?></span>
                    </div>
                    <blockquote class="testimonials-v2__quote"><?php echo esc_html($item['quote']); ?></blockquote>
                    <div class="testimonials-v2__author">
                        <?php if ($item['photo']): ?>
                            <img class="testimonials-v2__avatar-img" src="<?php echo esc_url($item['photo']); ?>" alt="<?php echo esc_attr($item['name']); ?>">
                        <?php else: ?>
                            <span class="testimonials-v2__avatar"><?php echo esc_html($item['initials']); ?></span>
                        <?php endif; ?>
                        <div class="testimonials-v2__author-meta">
                            <strong><?php echo esc_html($item['name']); ?></strong>
                            <?php if ($item['position'] || $item['company']): ?>
                                <span><?php echo esc_html(trim($item['position'] . ($item['position'] && $item['company'] ? ', ' : '') . $item['company'])); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php if ($total > 1): ?>
                <div class="swiper-pagination home-v2-pagination home-v2-pagination--on-dark testimonials-v2__pagination" data-home-v2-testimonials-pagination></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Why Choose Us — HTML comparison table -->
<?php
$comparison_rows = function_exists('neamob_get_comparison_table_rows')
    ? neamob_get_comparison_table_rows()
    : [];
$comparison_logo = get_template_directory_uri() . '/assets/icons/redesign/comparison-logo.png';
?>
<section class="comparison-section comparison-section--v2">
    <div class="container">
        <h2 class="comparison-section__title"><?php echo esc_html($comparison_title); ?></h2>
        <?php if (!empty($comparison_rows)): ?>
        <div class="comparison-grid comparison-grid--v2" role="region" aria-label="<?php echo esc_attr($comparison_title); ?>">
            <table class="comparison-grid__table">
                <thead>
                    <tr>
                        <th scope="col" class="comparison-grid__th comparison-grid__th--feature"><span class="screen-reader-text">Feature</span></th>
                        <th scope="col" class="comparison-grid__th comparison-grid__th--brand">
                            <img class="comparison-grid__logo" src="<?php echo esc_url($comparison_logo); ?>" alt="NeaMob" width="40" height="40">
                        </th>
                        <th scope="col" class="comparison-grid__th">Corporate Agencies</th>
                        <th scope="col" class="comparison-grid__th">Boutique Agencies</th>
                        <th scope="col" class="comparison-grid__th">Internal Teams</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comparison_rows as $row): ?>
                    <tr class="comparison-grid__row">
                        <th scope="row" class="comparison-grid__td comparison-grid__td--feature"><?php echo esc_html($row['feature']); ?></th>
                        <?php foreach (['neamob', 'corporate', 'boutique', 'internal'] as $col):
                            $yes = !empty($row[$col]);
                            $icon = neamob_comparison_icon_url($yes);
                            $label = $yes ? 'Yes' : 'No';
                        ?>
                        <td class="comparison-grid__td comparison-grid__td--icon">
                            <img class="comparison-grid__icon" src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($label); ?>" width="32" height="32" loading="lazy">
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Blog (Redesign) -->
<?php
$exclude_post = get_posts([
    'name' => 'blog-post-redesign',
    'post_type' => 'post',
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'fields' => 'ids',
]);
$blog_posts = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post_status' => 'publish',
    'post__not_in' => !empty($exclude_post) ? $exclude_post : [],
]);
if ($blog_posts->have_posts()):
?>
<section class="blog-section blog-section--v2">
    <div class="container">
        <div class="blog-section__header">
            <h2 class="blog-section__title">Blog</h2>
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="blog-section__link blog-section__link--v2">
                <span class="blog-section__link-dot"></span>
                View More
            </a>
        </div>
        <div class="home-v2-carousel" data-home-v2-carousel>
            <div class="blog-grid blog-grid--v2" data-home-v2-track>
                <?php while ($blog_posts->have_posts()):
                    $blog_posts->the_post();
                    $categories = get_the_category();
                    $category = !empty($categories) ? $categories[0] : null;
                    $cat_color = $category ? neamob_get_category_color($category) : 'blue';
                ?>
                <div class="home-v2-carousel__slide" data-home-v2-slide>
                    <article class="blog-card blog-card--v2">
                        <a href="<?php the_permalink(); ?>" class="blog-card__image <?php echo !has_post_thumbnail() ? 'blog-card__image--placeholder' : ''; ?>">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('card-image');
                            } ?>
                        </a>
                        <div class="blog-card__meta">
                            <?php if ($category): ?>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="blog-card__category blog-card__category--<?php echo esc_attr($cat_color); ?>"><?php echo esc_html($category->name); ?></a>
                            <?php endif; ?>
                            <span class="blog-card__date"><?php echo esc_html(get_the_date('d M, Y')); ?></span>
                        </div>
                        <h3 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="blog-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?></p>
                        <div class="blog-card__author">
                            <div class="blog-card__author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 64); ?></div>
                            <span class="blog-card__author-name"><?php the_author(); ?></span>
                        </div>
                    </article>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="swiper-pagination home-v2-pagination" data-home-v2-pagination></div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>

<!-- Our Partners (Redesign) -->
<?php
$partner_cards = neamob_get_partners_for_cards();
$has_partners = !empty($partner_cards);
?>
<section class="our-partners our-partners--v2">
    <div class="container">
        <h2 class="our-partners__title">Our Partners</h2>
        <div class="home-v2-carousel" data-home-v2-carousel>
        <div class="our-partners__grid our-partners__grid--v2" data-home-v2-track>
            <?php if ($has_partners):
                $card_index = 0;
                foreach ($partner_cards as $p):
                    setup_postdata($p);
                    $logo = get_field('partner_logo', $p->ID);
                    $logo_url = is_array($logo) ? ($logo['url'] ?? '') : ($logo ?: '');
                    $desc = get_field('partner_description', $p->ID);
                    $card_type = get_field('partner_card_type', $p->ID) ?: 'image';
                    $cta = get_field('partner_cta', $p->ID);
                    $video_id = '';
                    if ($card_type === 'video') {
                        $video_url = get_field('partner_video_url', $p->ID);
                        if ($video_url && preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $m)) {
                            $video_id = $m[1];
                        }
                    }
                    $card_class = 'partner-card-v2' . ($card_type === 'video' ? ' partner-card-v2--video' : '');
                    $card_id = 'partner-video-v2-' . $card_index;
            ?>
            <div class="<?php echo esc_attr($card_class); ?>" data-home-v2-slide>
                <div class="partner-card-v2__logo">
                    <?php if ($logo_url):
                        $partner_url = get_field('partner_url', $p->ID);
                        if ($partner_url): ?>
                            <a href="<?php echo esc_url($partner_url); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($p->post_title); ?>"></a>
                        <?php else: ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($p->post_title); ?>">
                        <?php endif;
                    endif; ?>
                </div>
                <?php if ($card_type === 'video'):
                    $thumb = get_field('partner_video_thumb', $p->ID) ?: get_template_directory_uri() . '/assets/images/power.png';
                ?>
                <div class="partner-card-v2__video" id="<?php echo esc_attr($card_id); ?>">
                    <button type="button" class="partner-card-v2__thumbnail" data-video-id="<?php echo esc_attr($video_id); ?>" onclick="neamobPlayPartnerVideo(this)">
                        <img src="<?php echo esc_url($thumb); ?>" alt="Video thumbnail">
                        <span class="partner-card-v2__play" aria-hidden="true"></span>
                    </button>
                </div>
                <?php else:
                    $img = get_field('partner_image', $p->ID);
                    $img_url = $img && isset($img['url']) ? $img['url'] : (get_template_directory_uri() . '/assets/images/partners/partner-1.png');
                ?>
                <div class="partner-card-v2__image">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($p->post_title); ?>" loading="lazy">
                </div>
                <?php endif; ?>
                <?php if ($desc): ?><p class="partner-card-v2__text"><?php echo esc_html($desc); ?></p><?php endif; ?>
                <?php if ($cta && !empty($cta['url'])):
                    $is_case_study = (strpos($cta['url'], 'docs.google.com/presentation') !== false || strpos($cta['url'], 'drive.google.com') !== false);
                    if ($is_case_study): ?>
                <div class="partner-card-v2__downloads">
                    <span class="partner-card-v2__downloads-label"><?php echo esc_html($cta['title'] ?: 'Download case study'); ?></span>
                    <div class="partner-card-v2__downloads-buttons">
                        <button type="button" class="partner-card-v2__download-btn" data-open-case-study-form data-redirect-url="https://drive.google.com/file/d/1grv4J3BA92UEglwit5LaFVnm0XzhP-bG/view">Illumin</button>
                        <button type="button" class="partner-card-v2__download-btn" data-open-case-study-form data-redirect-url="<?php echo esc_url($cta['url']); ?>">NeaMob</button>
                    </div>
                </div>
                    <?php else: ?>
                <a href="<?php echo esc_url($cta['url']); ?>" class="partner-card-v2__cta" <?php echo !empty($cta['target']) ? 'target="' . esc_attr($cta['target']) . '"' : ''; ?>>
                    <span class="partner-card-v2__cta-dot"></span>
                    <?php echo esc_html($cta['title'] ?: 'Learn More'); ?>
                </a>
                    <?php endif;
                endif; ?>
            </div>
            <?php $card_index++; endforeach; wp_reset_postdata();
            else: ?>
            <div class="partner-card-v2" data-home-v2-slide>
                <div class="partner-card-v2__logo">
                    <a href="https://www.vokal.io/" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logos/three_partners/p1.png'); ?>" alt="Vokal" width="112" height="40">
                    </a>
                </div>
                <div class="partner-card-v2__image">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partners/partner-1.png'); ?>" alt="Vokal office" width="340" height="234" loading="lazy">
                </div>
                <p class="partner-card-v2__text">Vokal is a digital agency driving measurable growth through strategic digital value creation and performance marketing.</p>
            </div>
            <div class="partner-card-v2" data-home-v2-slide>
                <div class="partner-card-v2__logo">
                    <a href="https://illumin.com/" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logos/three_partners/p3.png'); ?>" alt="illumin Partners" width="246" height="40">
                    </a>
                </div>
                <div class="partner-card-v2__image">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partners/partner-2.png'); ?>" alt="illumin platform" width="340" height="234" loading="lazy">
                </div>
                <p class="partner-card-v2__text">illumin is a journey advertising platform that helps brands plan, activate, and optimize digital campaigns across channels with real-time insights.</p>
                <div class="partner-card-v2__downloads">
                    <span class="partner-card-v2__downloads-label">Download case study</span>
                    <div class="partner-card-v2__downloads-buttons">
                        <button type="button" class="partner-card-v2__download-btn" data-open-case-study-form data-redirect-url="https://drive.google.com/file/d/1grv4J3BA92UEglwit5LaFVnm0XzhP-bG/view">Illumin</button>
                        <button type="button" class="partner-card-v2__download-btn" data-open-case-study-form data-redirect-url="https://docs.google.com/presentation/d/1Uu3wqB5EI-SIGIweGL30J6Uk2z_lvYLWAd4KijiZACo/edit?slide=id.g29fd362bea0_0_154#slide=id.g29fd362bea0_0_154">NeaMob</button>
                    </div>
                </div>
            </div>
            <div class="partner-card-v2 partner-card-v2--video" data-home-v2-slide>
                <div class="partner-card-v2__logo">
                    <a href="https://www.snappper.com/" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logos/three_partners/p2.png'); ?>" alt="Snappper" width="176" height="48">
                    </a>
                </div>
                <div class="partner-card-v2__image partner-card-v2__image--playable" data-open-video-overlay>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/power.png'); ?>" alt="Snappper" width="340" height="254" loading="lazy">
                    <span class="partner-card-v2__play" aria-hidden="true"></span>
                </div>
                <p class="partner-card-v2__text">Snappper is an award-winning creative and video production agency crafting engaging branded content with proven reach and results.</p>
            </div>
            <?php endif; ?>
        </div>
        <div class="swiper-pagination home-v2-pagination" data-home-v2-pagination></div>
        </div>
    </div>
</section>

<!-- FAQ (Redesign) -->
<?php
$faqs = neamob_get_faqs();
if ($faqs->have_posts()):
?>
<section class="faq-section faq-section--v2">
    <div class="container">
        <div class="faq-section__grid">
            <div class="faq-section__sidebar">
                <h2 class="faq-section__title">FAQs</h2>
                <p class="faq-section__text">Got more questions? Reach out to us. We're always here to help!</p>
                <a href="<?php echo esc_url($faq_cta_url); ?>" class="faq-section__cta faq-section__cta--v2">
                    <span class="btn__dot"></span>
                    <?php echo esc_html($faq_cta_text); ?>
                </a>
            </div>
            <div class="faq-list faq-list--v2">
                <?php $first = true; ?>
                <?php while ($faqs->have_posts()):
                    $faqs->the_post();
                    $answer = get_field('faq_answer');
                ?>
                <div class="faq-item faq-item--v2<?php echo $first ? ' is-active' : ''; ?>">
                    <div class="faq-item__header">
                        <h3 class="faq-item__question"><?php the_title(); ?></h3>
                        <span class="faq-item__icon faq-item__icon--v2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                    <div class="faq-item__body">
                        <div class="faq-item__answer">
                            <div class="faq-item__answer-text"><?php echo wp_kses_post($answer); ?></div>
                        </div>
                    </div>
                </div>
                <?php $first = false; endwhile; ?>
            </div>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
endif;
?>
