<?php
/**
 * Template Name: Case Study — Rehab Center
 *
 * @package Neamob_Theme
 */

get_header();
?>

<main class="cs-rehab">

    <!-- Hero (always from template — needs PHP for image paths) -->
    <section class="cs-rehab__hero">
        <div class="cs-rehab__hero-bg">
            <picture>
                <source media="(max-width: 750px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/hp-mobile.png">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hp.webp" alt="" class="cs-rehab__hero-bg-img">
            </picture>
        </div>
        <div class="container">
            <div class="cs-rehab__hero-inner">
                <div class="cs-rehab__hero-content">
                    <span class="cs-rehab__tag">Case Study — Rehabilitation Center</span>
                    <div class="cs-rehab__hero-headline">
                        <h1 class="cs-rehab__hero-title">Full capacity.<br>Maximum efficiency.</h1>
                        <p class="cs-rehab__hero-text">How NeaMob transformed a leading Canadian rehabilitation center's digital strategy, driving revenue growth while reducing acquisition costs.</p>
                    </div>
                    <div class="cs-rehab__hero-actions">
                        <a href="#cs-contact" class="cs-rehab__btn cs-rehab__btn--primary"><span class="cs-rehab__btn-dot"></span>Get similar results</a>
                        <a href="#cs-approach" class="cs-rehab__btn cs-rehab__btn--outline"><span class="cs-rehab__btn-dot"></span>See how we did it</a>
                    </div>
                </div>
                <div class="cs-rehab__hero-stats">
                    <div class="cs-rehab__stat-card">
                        <div class="cs-rehab__stat-number">210%</div>
                        <div class="cs-rehab__stat-label">Monthly Revenue Increase</div>
                    </div>
                    <div class="cs-rehab__stat-card">
                        <div class="cs-rehab__stat-number">268%</div>
                        <div class="cs-rehab__stat-label">Qualified Leads Growth</div>
                    </div>
                    <div class="cs-rehab__stat-card">
                        <div class="cs-rehab__stat-number cs-rehab__stat-number--green">-35%</div>
                        <div class="cs-rehab__stat-label">Cost per Qualified Lead</div>
                    </div>
                    <div class="cs-rehab__stat-card">
                        <div class="cs-rehab__stat-number">179%</div>
                        <div class="cs-rehab__stat-label">Monthly Patient Growth</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sections: from WP editor if available, otherwise fallback -->
    <?php
    remove_filter('the_content', 'wpautop');
    $cs_content = '';
    if (have_posts()):
        while (have_posts()): the_post();
            $cs_content = trim(get_the_content());
        endwhile;
    endif;
    add_filter('the_content', 'wpautop');

    if ($cs_content): ?>
        <?php echo apply_filters('the_content', $cs_content); ?>
    <?php else: ?>

    <!-- Challenge -->
    <section class="cs-rehab__section cs-rehab__section--light" id="cs-challenge">
        <div class="container">
            <div class="cs-rehab__section-header">
                <span class="cs-rehab__section-tag">The Challenge</span>
                <div class="cs-rehab__section-headline">
                    <h2 class="cs-rehab__section-title">Where they started</h2>
                    <p class="cs-rehab__section-subtitle">A leading rehabilitation center with 10+ years in the Canadian market had no clear digital path to sustainable growth.</p>
                </div>
            </div>
            <div class="cs-rehab__challenge-grid">
                <div class="cs-rehab__challenge-card fade-in">
                    <div class="cs-rehab__challenge-icon">
                        <svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 4"/></svg>
                    </div>
                    <div class="cs-rehab__challenge-body">
                        <h3>No Digital Strategy</h3>
                        <p>No clear strategy for online patient acquisition, leaving growth to chance rather than data-driven decisions.</p>
                    </div>
                </div>
                <div class="cs-rehab__challenge-card fade-in">
                    <div class="cs-rehab__challenge-icon">
                        <svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 16l4-4 4 4 4-4"/></svg>
                    </div>
                    <div class="cs-rehab__challenge-body">
                        <h3>Unclear ROI</h3>
                        <p>Online investment results were impossible to measure. No visibility into which channels drove actual revenue.</p>
                    </div>
                </div>
                <div class="cs-rehab__challenge-card fade-in">
                    <div class="cs-rehab__challenge-icon">
                        <svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/><circle cx="10" cy="7" r="4"/></svg>
                    </div>
                    <div class="cs-rehab__challenge-body">
                        <h3>Unstable Patient Flow</h3>
                        <p>Inconsistent lead generation caused unpredictable revenue swings and unfilled capacity month over month.</p>
                    </div>
                </div>
                <div class="cs-rehab__challenge-card fade-in">
                    <div class="cs-rehab__challenge-icon">
                        <svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="cs-rehab__challenge-body">
                        <h3>Unable to Scale</h3>
                        <p>Growth required proportional budget increases with no efficiency gains. Scaling seemed impossible without burning cash.</p>
                    </div>
                </div>
                <div class="cs-rehab__challenge-card fade-in">
                    <div class="cs-rehab__challenge-icon">
                        <svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H5l-4 4V3a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    </div>
                    <div class="cs-rehab__challenge-body">
                        <h3>Slow Messaging</h3>
                        <p>Turnaround on messaging to potential audiences was too slow, missing critical windows in the decision-making journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Results -->
    <section class="cs-rehab__section cs-rehab__section--dark" id="cs-results">
        <div class="container">
            <div class="cs-rehab__section-header">
                <span class="cs-rehab__section-tag">The Results</span>
                <div class="cs-rehab__section-headline">
                    <h2 class="cs-rehab__section-title">What we achieved</h2>
                    <p class="cs-rehab__section-subtitle">Measurable, transformative outcomes that took the center from underperforming to fully booked.</p>
                </div>
            </div>
            <div class="cs-rehab__results-grid">
                <div class="cs-rehab__result-card fade-in">
                    <div class="cs-rehab__result-top">
                        <div class="cs-rehab__result-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#ciu)"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.95 21.74a.86.86 0 01-1.49-.23.86.86 0 01.1-.77L7.1 10.65a.86.86 0 011.49.1l4.46 3.12 4.88-6.97-2.83-2.09a.86.86 0 01.65-1.57l6.41-1.19a.86.86 0 01.99.7l1.13 6.75a.86.86 0 01-1.36.83l-2.98-2.2-5.47 7.8a.86.86 0 01-1.33.08l-4.46-3.12L1.95 21.74z" fill="#0094FF"/></g><defs><clipPath id="ciu"><rect width="24" height="24" fill="white" transform="matrix(1 0 0 -1 0 24)"/></clipPath></defs></svg></div>
                        <div class="cs-rehab__result-number">210%</div>
                    </div>
                    <div class="cs-rehab__result-label">Monthly Revenue Increase</div>
                </div>
                <div class="cs-rehab__result-card fade-in">
                    <div class="cs-rehab__result-top">
                        <div class="cs-rehab__result-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#cid)"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.95 21.74a.86.86 0 01-1.49-.23.86.86 0 01.1-.77L7.1 10.65a.86.86 0 011.49.1l4.46 3.12 4.88-6.97-2.83-2.09a.86.86 0 01.65-1.57l6.41-1.19a.86.86 0 01.99.7l1.13 6.75a.86.86 0 01-1.36.83l-2.98-2.2-5.47 7.8a.86.86 0 01-1.33.08l-4.46-3.12L1.95 21.74z" fill="#0094FF"/></g><defs><clipPath id="cid"><rect width="24" height="24" fill="white" transform="matrix(1 0 0 -1 0 24)"/></clipPath></defs></svg></div>
                        <div class="cs-rehab__result-number">268%</div>
                    </div>
                    <div class="cs-rehab__result-label">Qualified Leads Growth</div>
                </div>
                <div class="cs-rehab__result-card fade-in">
                    <div class="cs-rehab__result-top">
                        <div class="cs-rehab__result-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#cic)"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.95 2.26a.86.86 0 00-1.49.23.86.86 0 00.1.77L7.1 13.35a.86.86 0 001.49-.1l4.46-3.12 4.88 6.97-2.83 2.09a.86.86 0 00.65 1.57l6.41 1.19a.86.86 0 00.99-.7l1.13-6.75a.86.86 0 00-1.36-.83l-2.98 2.2-5.47-7.8a.86.86 0 00-1.33-.08l-4.46 3.12L1.95 2.26z" fill="#00C853"/></g><defs><clipPath id="cic"><rect width="24" height="24" fill="white"/></clipPath></defs></svg></div>
                        <div class="cs-rehab__result-number cs-rehab__result-number--green">-35%</div>
                    </div>
                    <div class="cs-rehab__result-label">Cost per Qualified Lead</div>
                </div>
                <div class="cs-rehab__result-card fade-in">
                    <div class="cs-rehab__result-top">
                        <div class="cs-rehab__result-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#cim)"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.95 21.74a.86.86 0 01-1.49-.23.86.86 0 01.1-.77L7.1 10.65a.86.86 0 011.49.1l4.46 3.12 4.88-6.97-2.83-2.09a.86.86 0 01.65-1.57l6.41-1.19a.86.86 0 01.99.7l1.13 6.75a.86.86 0 01-1.36.83l-2.98-2.2-5.47 7.8a.86.86 0 01-1.33.08l-4.46-3.12L1.95 21.74z" fill="#0094FF"/></g><defs><clipPath id="cim"><rect width="24" height="24" fill="white" transform="matrix(1 0 0 -1 0 24)"/></clipPath></defs></svg></div>
                        <div class="cs-rehab__result-number">179%</div>
                    </div>
                    <div class="cs-rehab__result-label">Monthly Patient Growth</div>
                </div>
            </div>
            <div class="cs-rehab__results-list">
                <div class="cs-rehab__results-item fade-in">
                    <div class="cs-rehab__check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <p>System for consistent, quality lead generation implemented and running</p>
                </div>
                <div class="cs-rehab__results-item fade-in">
                    <div class="cs-rehab__check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <p>Full facility capacity maintained month over month</p>
                </div>
                <div class="cs-rehab__results-item fade-in">
                    <div class="cs-rehab__check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <p>Improved profitability and brand visibility across all channels</p>
                </div>
                <div class="cs-rehab__results-item fade-in">
                    <div class="cs-rehab__check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <p>Planning and forecasting models for new location expansion</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Before & After -->
    <section class="cs-rehab__section cs-rehab__section--light" id="cs-approach">
        <div class="container">
            <div class="cs-rehab__section-header">
                <span class="cs-rehab__section-tag">The Transformation</span>
                <div class="cs-rehab__section-headline">
                    <h2 class="cs-rehab__section-title">Before & after NeaMob</h2>
                    <p class="cs-rehab__section-subtitle">A side-by-side look at the measurable impact across key operational areas.</p>
                </div>
            </div>
            <div class="cs-rehab__comparison fade-in">
                <div class="cs-rehab__comparison-headers">
                    <div class="cs-rehab__comparison-header cs-rehab__comparison-header--empty"></div>
                    <div class="cs-rehab__comparison-header cs-rehab__comparison-header--before">BEFORE</div>
                    <div class="cs-rehab__comparison-header cs-rehab__comparison-header--after">AFTER NEAMOB</div>
                </div>
                <div class="cs-rehab__comparison-rows">
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">Acquisition Strategy</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">No clear strategy</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">Multi-channel system across 5+ platforms</div>
                    </div>
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">ROI Visibility</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">Unclear results</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">Full-funnel reporting per channel & campaign</div>
                    </div>
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">Patient Flow</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">Unstable, unpredictable</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">Consistent full capacity (+179% patients)</div>
                    </div>
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">Revenue</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">Flat growth</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">+210% monthly revenue increase</div>
                    </div>
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">Lead Quality</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">Low qualification rate</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">+268% qualified leads, -35% cost per lead</div>
                    </div>
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">Website Traffic</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">Limited organic reach</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">+83% traffic, +22 domain rating</div>
                    </div>
                    <div class="cs-rehab__comparison-row">
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--area">Email Performance</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--before">Minimal engagement</div>
                        <div class="cs-rehab__comparison-cell cs-rehab__comparison-cell--after">+72% open rates, +32.6% click rates</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services / How We Did It -->
    <section class="cs-rehab__section cs-rehab__section--light" id="cs-services">
        <div class="container">
            <div class="cs-rehab__section-header">
                <span class="cs-rehab__section-tag">How We Did It</span>
                <div class="cs-rehab__section-headline">
                    <h2 class="cs-rehab__section-title">A full-stack digital approach</h2>
                    <p class="cs-rehab__section-subtitle">Ten integrated disciplines working together to drive consistent, scalable patient acquisition.</p>
                </div>
            </div>
            <div class="cs-rehab__services-grid">
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 16l4-4 4 4 4-4"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Reporting & Analytics</h3>
                        <p>Full-funnel reporting tying investment to revenue. Lead scoring synchronized with the sales team across all channels.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>KPI Tracking</span><span>Lead Scoring</span><span>ROI Analysis</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Call Tracking</h3>
                        <p>Integrated call tracking with dynamic phone numbers matched to originating source for precise attribution.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Attribution</span><span>Dynamic Numbers</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Campaign Management</h3>
                        <p>Audited platforms, opened 5 new channels driving 60%+ of qualified leads. Continuous audience and creative testing.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Google Ads</span><span>TikTok</span><span>Mailchimp</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>SEO</h3>
                        <p>Keyword research, local content strategy, new landing pages, technical optimization, and AI search optimization.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Local SEO</span><span>Content</span><span>AI Search</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Affiliates</h3>
                        <p>Strategic partnerships with affiliate websites that evolved into a primary source of monthly qualified leads.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Partnerships</span><span>Lead Gen</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.586 7.586"/><circle cx="11" cy="11" r="2"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Creatives</h3>
                        <p>Brand-aligned ad design with human-led creative direction. Monthly performance analysis and A/B testing.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Ad Design</span><span>UGC</span><span>A/B Testing</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Website Optimization</h3>
                        <p>A/B tested homepage for conversion, built new SEO pages, and redesigned key pages per UX/UI best practices.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>CRO</span><span>UX/UI</span><span>A/B Testing</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2"/><path d="M7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 17h5M17 7h5"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Branding</h3>
                        <p>Complete brand overhaul: competitor analysis, value proposition, positioning, tone of voice, messaging pillars.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Brand Identity</span><span>Tone of Voice</span><span>Typography</span><span>Guidelines</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Social Media Marketing</h3>
                        <p>Full-service SMM: strategy, content planning, visual creation, voice acting for video, community management.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Strategy</span><span>Content</span><span>Community</span></div>
                </div>
                <div class="cs-rehab__service-card fade-in">
                    <div class="cs-rehab__service-icon"><svg width="24" height="24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="13" width="3" height="4"/><rect x="12" y="9" width="3" height="8"/><rect x="17" y="5" width="3" height="12"/></svg></div>
                    <div class="cs-rehab__service-body">
                        <h3>Business Intelligence</h3>
                        <p>Multichannel report blending data from advertising, CRM, and Analytics. Includes funnels, leads tracking, and creative reports.</p>
                    </div>
                    <div class="cs-rehab__tags"><span>Dashboards</span><span>CRM</span><span>Analytics</span><span>Data Blending</span></div>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

</main>

<?php
get_template_part('template-parts/contact-form');
get_footer();
?>

<script>
(function(){
    var observer = new IntersectionObserver(function(entries){
        entries.forEach(function(entry, i){
            if(entry.isIntersecting){
                setTimeout(function(){ entry.target.classList.add('visible'); }, i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, {threshold: 0.15});
    document.querySelectorAll('.cs-rehab .fade-in').forEach(function(el){ observer.observe(el); });
})();
</script>
