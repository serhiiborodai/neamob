<?php
/**
 * Template for single blog posts
 */
get_header();

// Get post data
$categories = get_the_category();
$category = !empty($categories) ? $categories[0] : null;
$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_position = get_the_author_meta('description') ?: 'Author at NeaMob';
$author_avatar = get_avatar_url($author_id, ['size' => 60]);

// Get previous and next posts
$prev_post = get_previous_post();
$next_post = get_next_post();
?>

<main class="single-post">
    <div class="container">
        <!-- Back to Blog -->
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="back-to-blog">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to Blog
        </a>

        <div class="single-post__layout">
            <!-- Sticky Table of Contents -->
            <aside class="single-post__toc">
                <div class="toc-wrapper">
                    <h4 class="toc-title">Table of content</h4>
                    <nav class="toc-nav" id="toc-nav">
                        <!-- Will be populated by JavaScript -->
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <article class="single-post__content">
                <!-- Post Header -->
                <header class="single-post__header">
                    <div class="single-post__meta">
                        <?php if ($category): ?>
                            <a href="<?php echo get_category_link($category->term_id); ?>" class="single-post__category">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        <?php endif; ?>
                        <time class="single-post__date" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date('d M, Y'); ?>
                        </time>
                    </div>

                    <h1 class="single-post__title"><?php the_title(); ?></h1>
                </header>

                <!-- Post Content -->
                <div class="single-post__body" id="post-content">
                    <?php the_content(); ?>
                </div>

                <!-- Author Box -->
                <div class="single-post__author">
                    <div class="author-avatar">
                        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                    </div>
                    <div class="author-info">
                        <span class="author-label">Written by <strong><?php echo esc_html($author_name); ?></strong></span>
                        <span class="author-position"><?php echo esc_html($author_position); ?></span>
                    </div>
                </div>

                <!-- Post Navigation -->
                <nav class="single-post__navigation">
                    <div class="nav-prev">
                        <?php if ($prev_post): ?>
                            <a href="<?php echo get_permalink($prev_post); ?>">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Previous post
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="nav-next">
                        <?php if ($next_post): ?>
                            <a href="<?php echo get_permalink($next_post); ?>">
                                Next post
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>
            </article>
        </div>
    </div>
</main>

<!-- FAQ Section for Blog Posts -->
<section class="faq-section">
    <div class="container">
        <div class="faq-section__grid">
            <div class="faq-section__sidebar">
                <h2 class="faq-section__title">FAQs</h2>
                <p class="faq-section__text">Got more questions? Reach out to us. We're always here to help!</p>
                <a href="/contact" class="faq-section__cta">Let's Chat</a>
            </div>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-item__header">
                        <h3 class="faq-item__question">What is creative reporting in advertising?</h3>
                        <div class="faq-item__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                    <div class="faq-item__body">
                        <div class="faq-item__answer">
                            <div class="faq-item__answer-text">Creative reporting is the process of analyzing ad creative performance to understand what visual and messaging elements resonate with your audience and drive results.</div>
                        </div>
                    </div>
                </div>
                <div class="faq-item is-active">
                    <div class="faq-item__header">
                        <h3 class="faq-item__question">How often should creative reporting be done?</h3>
                        <div class="faq-item__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                    <div class="faq-item__body">
                        <div class="faq-item__answer">
                            <div class="faq-item__answer-text">We produce creative reports both weekly and monthly. Weekly reports help catch trends early and make quick adjustments. Monthly reports provide the larger picture: month-over-month comparisons, pattern recognition across longer timeframes, and strategic recommendations that shape the next production cycle.</div>
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-item__header">
                        <h3 class="faq-item__question">What metrics matter most in ad creative analysis?</h3>
                        <div class="faq-item__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                    <div class="faq-item__body">
                        <div class="faq-item__answer">
                            <div class="faq-item__answer-text">Key metrics include click-through rate (CTR), conversion rate, cost per acquisition (CPA), engagement rate, and creative fatigue indicators.</div>
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-item__header">
                        <h3 class="faq-item__question">What's the difference between creative reporting and campaign reporting?</h3>
                        <div class="faq-item__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                    <div class="faq-item__body">
                        <div class="faq-item__answer">
                            <div class="faq-item__answer-text">Campaign reporting focuses on overall performance metrics, while creative reporting dives deeper into which specific visual and copy elements drive those results.</div>
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-item__header">
                        <h3 class="faq-item__question">Can creative reporting improve ad performance over time?</h3>
                        <div class="faq-item__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                    <div class="faq-item__body">
                        <div class="faq-item__answer">
                            <div class="faq-item__answer-text">Yes, by continuously analyzing creative performance and iterating based on data, you can systematically improve ad effectiveness and reduce wasted spend.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php // Contact Form before footer
get_template_part('template-parts/contact-form'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Table of Contents
    const postContent = document.getElementById('post-content');
    const tocNav = document.getElementById('toc-nav');
    const headings = postContent.querySelectorAll('h2, h3');
    
    if (headings.length > 0 && tocNav) {
        const tocList = document.createElement('ul');
        tocList.className = 'toc-list';
        
        headings.forEach((heading, index) => {
            // Add ID to heading if not present
            if (!heading.id) {
                heading.id = 'section-' + index;
            }
            
            const li = document.createElement('li');
            li.className = 'toc-item' + (heading.tagName === 'H3' ? ' toc-item--sub' : '');
            
            const link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent;
            link.className = 'toc-link';
            
            li.appendChild(link);
            tocList.appendChild(li);
        });
        
        tocNav.appendChild(tocList);
        
        // Copy toc-wrapper before first h2 (for mobile)
        const tocWrapper = document.querySelector('.toc-wrapper');
        const firstH2 = postContent.querySelector('h2');
        if (tocWrapper && firstH2) {
            const tocCopy = document.createElement('div');
            tocCopy.className = 'toc__for-mobile';
            tocCopy.appendChild(tocWrapper.cloneNode(true));
            firstH2.parentNode.insertBefore(tocCopy, firstH2);
        }
        
        // Highlight active section on scroll
        const tocLinks = tocNav.querySelectorAll('.toc-link');
        
        function updateActiveLink() {
            let currentSection = '';
            
            headings.forEach(heading => {
                const rect = heading.getBoundingClientRect();
                if (rect.top <= 150) {
                    currentSection = heading.id;
                }
            });
            
            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + currentSection) {
                    link.classList.add('active');
                }
            });
        }
        
        window.addEventListener('scroll', updateActiveLink);
        updateActiveLink();
        
        // Smooth scroll to section
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 100;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    } else {
        // Hide TOC if no headings
        const tocWrapper = document.querySelector('.single-post__toc');
        if (tocWrapper) {
            tocWrapper.style.display = 'none';
        }
    }
});
</script>

<?php get_footer(); ?>
