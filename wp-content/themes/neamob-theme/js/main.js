/**
 * Neamob Theme - Main JavaScript
 * Includes Swiper slider initialization and custom functionality
 */

(function () {
    'use strict';

    var neamobLenis = null;

    function initLenis() {
        if (typeof Lenis === 'undefined') return;
        neamobLenis = new Lenis({
            duration: 1.2,
            easing: function(t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
            // Don't amplify touch — fights horizontal Swiper gestures on mobile
            touchMultiplier: 1,
        });
        window.neamobLenis = neamobLenis;
        function raf(time) {
            neamobLenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    }

    /** Pause page smooth-scroll while a Swiper is being dragged horizontally. */
    function bindLenisToSwiper(swiper) {
        if (!neamobLenis || !swiper) return;
        swiper.on('touchStart', function () {
            if (neamobLenis) neamobLenis.stop();
        });
        swiper.on('touchEnd', function () {
            if (neamobLenis) neamobLenis.start();
        });
        swiper.on('sliderFirstMove', function () {
            if (neamobLenis) neamobLenis.stop();
        });
    }

    /**
     * Initialize when DOM is ready
     */
    document.addEventListener('DOMContentLoaded', function () {
        initLenis();
        initLogoSliderClone();
        initSwiperSliders();
        initMobileMenu();
        initSmoothScroll();
        initScrollToForm();
        initAnimations();
        initServicesAccordion();
        initTestimonialsSlider();
        initTestimonialsV2();
        initHomeV2MobileCarousels();
        initFaqAccordion();
        initContactForm();
        initCaseStudyForm();
        initAuditForm();
        initHeaderMegaMenus();
        initPortfolioBlockVideos();
    });

    function initLogoSliderClone() {
        var track = document.querySelector('.logo-slider__track');
        if (!track) return;
        var group = track.querySelector('.logo-slider__group');
        if (!group) return;
        track.appendChild(group.cloneNode(true));
    }

    /**
     * Initialize all Swiper sliders on the page
     */
    function initSwiperSliders() {
        // Hero Slider
        const heroSliders = document.querySelectorAll('.hero-slider .swiper');
        heroSliders.forEach(function (slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: slider.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
            });
        });

        // Cards Slider
        const cardsSliders = document.querySelectorAll('.cards-slider');
        cardsSliders.forEach(function (slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: slider.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
            });
        });

        // Testimonials Slider
        const testimonialsSliders = document.querySelectorAll('.testimonials-slider');
        testimonialsSliders.forEach(function (slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: slider.querySelector('.swiper-pagination'),
                    clickable: true,
                    dynamicBullets: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
        });

        // Gallery Slider
        const gallerySliders = document.querySelectorAll('.gallery-slider');
        gallerySliders.forEach(function (slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                grabCursor: true,
                pagination: {
                    el: slider.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
                thumbs: {
                    // Optional: thumbs swiper can be configured here
                },
            });
        });

        // Generic sliders with data attributes
        const genericSliders = document.querySelectorAll('.neamob-slider[data-slider-type]');
        genericSliders.forEach(function (wrapper) {
            const slider = wrapper.querySelector('.swiper');
            if (!slider) return;

            const sliderType = wrapper.dataset.sliderType || 'cards';
            const autoplay = wrapper.dataset.autoplay !== 'false';

            const config = getSliderConfig(sliderType, autoplay, slider);
            new Swiper(slider, config);
        });
    }

    /**
     * Get slider configuration based on type
     */
    function getSliderConfig(type, autoplay, slider) {
        const baseConfig = {
            loop: true,
            pagination: {
                el: slider.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: slider.querySelector('.swiper-button-next'),
                prevEl: slider.querySelector('.swiper-button-prev'),
            },
        };

        if (autoplay) {
            baseConfig.autoplay = {
                delay: 4000,
                disableOnInteraction: false,
            };
        }

        switch (type) {
            case 'hero':
                return {
                    ...baseConfig,
                    slidesPerView: 1,
                    effect: 'fade',
                    fadeEffect: { crossFade: true },
                    autoplay: autoplay ? { delay: 5000, disableOnInteraction: false } : false,
                };

            case 'testimonials':
                return {
                    ...baseConfig,
                    slidesPerView: 1,
                    spaceBetween: 30,
                    breakpoints: {
                        768: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 },
                    },
                };

            case 'cards':
            default:
                return {
                    ...baseConfig,
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        1024: { slidesPerView: 3, spaceBetween: 30 },
                    },
                };
        }
    }

    /**
     * Initialize mobile menu
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-mobile__toggle');
        const mainNav = document.querySelector('.main-nav');

        if (menuToggle && mainNav) {
            menuToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                mainNav.classList.toggle('to-show');
            });

            document.addEventListener('click', function (e) {
                if (!mainNav.contains(e.target)) {
                    mainNav.classList.remove('to-show');
                }
            });
        }
    }

    /**
     * Initialize smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Scroll to contact form: Let's Chat / Book Free Audit buttons
     */
    function initScrollToForm() {
        var formSection = document.getElementById('contact-form');
        var homeUrl = (typeof neamobData !== 'undefined' && neamobData.siteUrl) ? neamobData.siteUrl : '/';

        function scrollToForm(e) {
            var formEl = document.getElementById('contact-form');
            if (formEl) {
                e.preventDefault();
                var headerH = document.querySelector('.site-header') ? document.querySelector('.site-header').offsetHeight : 0;
                var top = formEl.getBoundingClientRect().top + window.pageYOffset - headerH;
                window.scrollTo({ top: top, behavior: 'smooth' });
            } else {
                e.preventDefault();
                window.location.href = homeUrl.replace(/\/$/, '') + '/#contact-form';
            }
        }

        document.addEventListener('click', function(e) {
            var t = e.target.closest('a, button');
            if (!t) return;
            var text = (t.textContent || '').trim();
            var href = (t.getAttribute('href') || '');
            var isChat = /^let['’]s chat$/i.test(text);
            var isFormHash = href === '#contact-form' || /#contact-form$/.test(href);
            if (text === 'Book Free Audit' || isChat || isFormHash) {
                scrollToForm(e);
            }
        });

        if (window.location.hash === '#contact-form' && formSection) {
            setTimeout(function() {
                var headerH = document.querySelector('.site-header') ? document.querySelector('.site-header').offsetHeight : 0;
                var top = formSection.getBoundingClientRect().top + window.pageYOffset - headerH;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }, 100);
        }
    }

    /**
     * Initialize Testimonials Slider with custom pagination
     */
    function initTestimonialsSlider() {
        const sliderContainers = document.querySelectorAll('.testimonial-slider');

        sliderContainers.forEach(function (container) {
            const swiperEl = container.querySelector('.swiper');
            const paginationCurrent = container.querySelector('.testimonial-pagination__current');
            const paginationTotal = container.querySelector('.testimonial-pagination__total');
            const prevBtn = container.querySelector('.testimonial-nav__prev');
            const nextBtn = container.querySelector('.testimonial-nav__next');
            var section = container.closest('.testimonials-section');
            const cursorEl = section ? section.querySelector('.testimonial-cursor') : null;

            if (!swiperEl) return;

            const swiper = new Swiper(swiperEl, {
                slidesPerView: 1,
                spaceBetween: 40,
                loop: true,
                speed: 600,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                navigation: {
                    prevEl: prevBtn,
                    nextEl: nextBtn,
                },
                on: {
                    init: function () {
                        updatePagination(this, paginationCurrent, paginationTotal);
                    },
                    slideChange: function () {
                        updatePagination(this, paginationCurrent, paginationTotal);
                    }
                }
            });

            if (cursorEl && window.innerWidth >= 1200) {
                var mouseX = 0, mouseY = 0, cX = 0, cY = 0;
                var isVisible = false;
                var rafId = null;

                function animateCursor() {
                    cX += (mouseX - cX) * 0.12;
                    cY += (mouseY - cY) * 0.12;
                    cursorEl.style.left = cX + 'px';
                    cursorEl.style.top = cY + 'px';
                    rafId = requestAnimationFrame(animateCursor);
                }

                section.addEventListener('mouseenter', function () {
                    cursorEl.classList.add('is-visible');
                    isVisible = true;
                    if (!rafId) rafId = requestAnimationFrame(animateCursor);
                });

                section.addEventListener('mouseleave', function () {
                    cursorEl.classList.remove('is-visible');
                    isVisible = false;
                    if (rafId) { cancelAnimationFrame(rafId); rafId = null; }
                });

                section.addEventListener('mousemove', function (e) {
                    var rect = section.getBoundingClientRect();
                    mouseX = e.clientX - rect.left;
                    mouseY = e.clientY - rect.top;
                });

                swiperEl.addEventListener('click', function () {
                    swiper.slideNext();
                });

                var paginationEl = container.querySelector('.testimonial-pagination');
                if (paginationEl) {
                    paginationEl.addEventListener('mouseenter', function () {
                        cursorEl.classList.remove('is-visible');
                    });
                    paginationEl.addEventListener('mouseleave', function () {
                        cursorEl.classList.add('is-visible');
                    });
                }
            }
        });

        function updatePagination(swiper, currentEl, totalEl) {
            if (currentEl && totalEl) {
                const current = String(swiper.realIndex + 1).padStart(2, '0');
                // Count only original slides (exclude loop duplicates)
                const originalSlides = swiper.el.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length;
                const total = String(originalSlides).padStart(2, '0');
                currentEl.textContent = current;
                totalEl.textContent = total;
            }
        }
    }

    /**
     * Initialize Services Accordion
     */
    function initServicesAccordion() {
        const accordions = document.querySelectorAll('.services-accordion');

        accordions.forEach(function (accordion) {
            const items = accordion.querySelectorAll('.services-accordion__item');
            const section = accordion.closest('.services-section');
            const images = section ? section.querySelectorAll('.services-section__image') : [];

            items.forEach(function (item) {
                const header = item.querySelector('.services-accordion__header');

                header.addEventListener('click', function () {
                    const isActive = item.classList.contains('is-active');
                    const index = item.dataset.index;

                    // If already active, do nothing (always keep one open)
                    if (isActive) {
                        return;
                    }

                    // Close all items
                    items.forEach(function (otherItem) {
                        otherItem.classList.remove('is-active');
                    });

                    // Hide all images
                    images.forEach(function (img) {
                        img.classList.remove('is-active');
                    });

                    // Open clicked item
                    item.classList.add('is-active');
                    // Show corresponding image
                    if (images[index]) {
                        images[index].classList.add('is-active');
                    }
                });
            });

            // Open first item by default
            if (items.length > 0 && !accordion.querySelector('.services-accordion__item.is-active')) {
                items[0].classList.add('is-active');
                if (images[0]) {
                    images[0].classList.add('is-active');
                }
            }
        });
    }

    /**
     * Testimonials v2 — tab list + content panels (redesign homepage)
     */
    function initTestimonialsV2() {
        document.querySelectorAll('.testimonials-v2').forEach(function (section) {
            var tabs = section.querySelectorAll('.testimonials-v2__tab');
            var slides = section.querySelectorAll('.testimonials-v2__slide');
            if (!tabs.length || !slides.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    if (section.classList.contains('is-mobile-swiper')) return;
                    var index = tab.getAttribute('data-index');
                    tabs.forEach(function (t) {
                        t.classList.remove('is-active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    slides.forEach(function (s) {
                        s.classList.remove('is-active');
                    });
                    tab.classList.add('is-active');
                    tab.setAttribute('aria-selected', 'true');
                    var activeSlide = section.querySelector('.testimonials-v2__slide[data-index="' + index + '"]');
                    if (activeSlide) {
                        activeSlide.classList.add('is-active');
                    }
                });
            });
        });
    }

    /**
     * Home redesign mobile carousels — Case studies, Blog, Partners, Testimonials.
     * Desktop keeps grid/tabs; Swiper only below 641px with pill/dot pagination.
     * Each card is wrapped in a dedicated .swiper-slide so card max-width
     * cannot shrink the slide (which showed 2 case cards / broke blog).
     */
    function initHomeV2MobileCarousels() {
        if (typeof Swiper === 'undefined') return;

        var mq = window.matchMedia('(max-width: 640px)');

        function wrapSlides(slides) {
            return slides.map(function (slide) {
                if (slide.classList.contains('home-v2-carousel__slide')) {
                    return slide;
                }
                if (slide.parentElement && slide.parentElement.classList.contains('home-v2-carousel__slide')) {
                    return slide.parentElement;
                }
                var wrap = document.createElement('div');
                wrap.className = 'home-v2-carousel__slide';
                slide.parentNode.insertBefore(wrap, slide);
                wrap.appendChild(slide);
                return wrap;
            });
        }

        function unwrapSlides(slides) {
            slides.forEach(function (slide) {
                // PHP already wraps slides — leave structure alone on desktop
                if (slide.classList.contains('home-v2-carousel__slide')) return;
                var wrap = slide.parentElement;
                if (!wrap || !wrap.classList.contains('home-v2-carousel__slide')) return;
                wrap.parentNode.insertBefore(slide, wrap);
                wrap.remove();
            });
        }

        function bindCarousel(root) {
            var track = root.querySelector('[data-home-v2-track]');
            var slides = Array.prototype.slice.call(root.querySelectorAll('[data-home-v2-slide]'));
            var pagination = root.querySelector('[data-home-v2-pagination]');
            var swiper = null;

            if (!track || slides.length < 2) {
                if (pagination) pagination.setAttribute('hidden', '');
                return;
            }

            function enable() {
                if (swiper) return;
                var slideEls = wrapSlides(slides);
                root.classList.add('swiper', 'is-mobile-swiper');
                track.classList.add('swiper-wrapper');
                slideEls.forEach(function (el) {
                    el.classList.add('swiper-slide');
                });
                if (pagination) pagination.removeAttribute('hidden');
                swiper = new Swiper(root, {
                    slidesPerView: 1,
                    spaceBetween: 12,
                    speed: 360,
                    threshold: 8,
                    resistanceRatio: 0.65,
                    watchOverflow: true,
                    // Avoid mid-gesture reflows from image/lazy observers
                    observer: false,
                    observeParents: false,
                    touchReleaseOnEdges: true,
                    pagination: pagination
                        ? {
                              el: pagination,
                              clickable: true,
                          }
                        : undefined,
                });
                bindLenisToSwiper(swiper);
            }

            function disable() {
                if (!swiper) return;
                swiper.destroy(true, true);
                swiper = null;
                root.classList.remove('swiper', 'is-mobile-swiper');
                track.classList.remove('swiper-wrapper');
                track.querySelectorAll('.home-v2-carousel__slide').forEach(function (el) {
                    el.classList.remove('swiper-slide');
                    el.removeAttribute('style');
                });
                unwrapSlides(slides);
                slides.forEach(function (slide) {
                    slide.removeAttribute('style');
                });
                track.removeAttribute('style');
            }

            function sync() {
                if (mq.matches) enable();
                else disable();
            }

            sync();
            if (typeof mq.addEventListener === 'function') {
                mq.addEventListener('change', sync);
            } else if (typeof mq.addListener === 'function') {
                mq.addListener(sync);
            }
        }

        document.querySelectorAll('[data-home-v2-carousel]').forEach(bindCarousel);

        document.querySelectorAll('.testimonials-v2').forEach(function (section) {
            var track = section.querySelector('[data-home-v2-testimonials-track]');
            var slides = Array.prototype.slice.call(section.querySelectorAll('[data-home-v2-testimonials-slide]'));
            var pagination = section.querySelector('[data-home-v2-testimonials-pagination]');
            var tabs = section.querySelectorAll('.testimonials-v2__tab');
            var swiper = null;

            if (!track || slides.length < 2) {
                if (pagination) pagination.setAttribute('hidden', '');
                return;
            }

            function setTabActive(index) {
                tabs.forEach(function (tab) {
                    var isActive = tab.getAttribute('data-index') === String(index);
                    tab.classList.toggle('is-active', isActive);
                    tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                slides.forEach(function (slide, i) {
                    slide.classList.toggle('is-active', i === index);
                });
            }

            function enable() {
                if (swiper) return;
                section.classList.add('is-mobile-swiper');
                var wrapper = document.createElement('div');
                wrapper.className = 'swiper-wrapper';
                slides.forEach(function (slide) {
                    var wrap = document.createElement('div');
                    wrap.className = 'home-v2-carousel__slide swiper-slide';
                    wrap.appendChild(slide);
                    slide.classList.add('is-active');
                    wrapper.appendChild(wrap);
                });
                track.appendChild(wrapper);
                track.classList.add('swiper');
                if (pagination) pagination.removeAttribute('hidden');
                swiper = new Swiper(track, {
                    slidesPerView: 1,
                    spaceBetween: 12,
                    speed: 360,
                    threshold: 8,
                    resistanceRatio: 0.65,
                    // Fixed height avoids vertical "jump" between quotes of different length
                    autoHeight: false,
                    watchOverflow: true,
                    observer: false,
                    observeParents: false,
                    touchReleaseOnEdges: true,
                    pagination: pagination
                        ? {
                              el: pagination,
                              clickable: true,
                          }
                        : undefined,
                    on: {
                        slideChange: function () {
                            setTabActive(this.realIndex);
                        },
                    },
                });
                bindLenisToSwiper(swiper);
            }

            function disable() {
                if (!swiper) return;
                var activeIndex = swiper.realIndex;
                swiper.destroy(true, true);
                swiper = null;
                section.classList.remove('is-mobile-swiper');
                var wrapper = track.querySelector('.swiper-wrapper');
                if (wrapper) {
                    slides.forEach(function (slide) {
                        slide.removeAttribute('style');
                        track.appendChild(slide);
                    });
                    wrapper.remove();
                }
                track.classList.remove('swiper');
                track.removeAttribute('style');
                setTabActive(activeIndex);
            }

            function sync() {
                if (mq.matches) enable();
                else disable();
            }

            sync();
            if (typeof mq.addEventListener === 'function') {
                mq.addEventListener('change', sync);
            } else if (typeof mq.addListener === 'function') {
                mq.addListener(sync);
            }
        });
    }

    window.neamobPlayPartnerVideo = function (el) {
        var videoId = el.dataset.videoId;
        var container = el.closest('.partner-card__video, .partner-card-v2__video');
        if (!container || !videoId) return;
        container.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&modestbranding=1" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        container.classList.add('is-playing');
    };

    /**
     * Initialize FAQ Accordion
     */
    function initFaqAccordion() {
        const faqLists = document.querySelectorAll('.faq-list');

        faqLists.forEach(function (faqList) {
            const items = faqList.querySelectorAll('.faq-item');

            items.forEach(function (item) {
                const header = item.querySelector('.faq-item__header');

                header.addEventListener('click', function () {
                    const isActive = item.classList.contains('is-active');

                    // Close all items
                    items.forEach(function (otherItem) {
                        otherItem.classList.remove('is-active');
                    });

                    // Open clicked item if it wasn't already open
                    if (!isActive) {
                        item.classList.add('is-active');
                    }
                });
            });
        });
    }

    /**
     * Initialize Contact Form UX
     */
    function initContactForm() {
        var forms = document.querySelectorAll('.wpcf7-form');
        if (!forms.length) return;

        forms.forEach(function(form) {
            form.querySelectorAll('[aria-required="true"]').forEach(function(input) {
                var label = input.closest('label');
                if (!label || label.querySelector('.required-asterisk')) return;
                for (var i = 0; i < label.childNodes.length; i++) {
                    var node = label.childNodes[i];
                    if (node.nodeType === 3 && node.textContent.trim()) {
                        var asterisk = document.createElement('span');
                        asterisk.className = 'required-asterisk';
                        asterisk.textContent = '* ';
                        node.before(asterisk);
                        break;
                    }
                }
            });

            form.querySelectorAll('select').forEach(function(sel) {
                var label = sel.closest('label');
                if (label) label.classList.add('has-select');
                var wrap = sel.closest('.wpcf7-form-control-wrap');
                if (wrap) wrap.classList.add('has-select');
            });

            var submitBtn = form.querySelector('.wpcf7-submit');
            if (!submitBtn) return;

            var submitWrap = document.createElement('div');
            submitWrap.className = 'cf7-submit-wrap';
            submitBtn.parentNode.insertBefore(submitWrap, submitBtn);
            submitWrap.appendChild(submitBtn);

            var loadingEl = document.createElement('div');
            loadingEl.className = 'cf7-status cf7-status--loading';
            loadingEl.innerHTML = '<span class="cf7-status__icon cf7-status__icon--spinner"></span> Submitting Your Request...';
            submitWrap.appendChild(loadingEl);

            var successEl = document.createElement('div');
            successEl.className = 'cf7-status cf7-status--success';
            successEl.innerHTML = '<span class="cf7-status__icon cf7-status__icon--check"></span> Thanks! Our Team Will Contact You Shortly.';
            submitWrap.appendChild(successEl);

            var errorEl = document.createElement('div');
            errorEl.className = 'cf7-status cf7-status--error';
            errorEl.innerHTML = '<button type="button" class="cf7-status__retry"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.00024 1V5.16667H4.95691M1.68191 4.33333C2.45445 2.99538 3.66772 1.96727 5.11431 1.42476C6.5609 0.882251 8.15101 0.859014 9.61284 1.35902C11.0747 1.85903 12.3175 2.85124 13.1288 4.16605C13.9401 5.48087 14.2695 7.03664 14.0608 8.56746C13.8521 10.0983 13.1182 11.5091 11.9846 12.5587C10.8509 13.6084 9.38787 14.2317 7.84554 14.3221C6.30321 14.4126 4.77735 13.9645 3.52878 13.0546C2.2802 12.1446 1.38643 10.8293 1.00024 9.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button><span class="cf7-status__text"></span>';
            submitWrap.appendChild(errorEl);

            var retryBtn = errorEl.querySelector('.cf7-status__retry');
            retryBtn.addEventListener('click', function() {
                submitWrap.classList.remove('is-error');
                submitBtn.style.display = '';
            });

            setupValidation(form);

            form.addEventListener('submit', function() {
                submitWrap.classList.add('is-loading');
                submitBtn.style.display = 'none';
            });
        });

        ['wpcf7submit', 'wpcf7mailsent', 'wpcf7mailfailed', 'wpcf7spam', 'wpcf7invalid'].forEach(function(eventName) {
            document.addEventListener(eventName, function(ev) {
                var unitTag = ev.detail && ev.detail.unitTag;
                var wpcf7El = unitTag ? document.querySelector('#' + unitTag.replace(/^#/, '')) : document.querySelector('.wpcf7');
                if (!wpcf7El) return;
                var submitWrap = wpcf7El.querySelector('.cf7-submit-wrap');
                var submitBtn = wpcf7El.querySelector('.wpcf7-submit');
                var form = wpcf7El.querySelector('.wpcf7-form');
                var errorEl = submitWrap && submitWrap.querySelector('.cf7-status--error');
                if (!submitWrap || !submitBtn) return;

                submitWrap.classList.remove('is-loading');
                if (eventName === 'wpcf7mailsent') {
                    submitWrap.classList.add('is-success');
                    submitBtn.style.display = 'none';
                    if (form) form.reset();
                    setTimeout(function() {
                        submitWrap.classList.remove('is-success');
                        submitBtn.style.display = '';
                    }, 5000);
                } else if (eventName === 'wpcf7mailfailed' || eventName === 'wpcf7spam') {
                    var textEl = errorEl && errorEl.querySelector('.cf7-status__text');
                    if (textEl) textEl.textContent = "We couldn't submit your request. Please try again.";
                    submitWrap.classList.add('is-error');
                    submitBtn.style.display = 'none';
                } else if (eventName === 'wpcf7invalid' || eventName === 'wpcf7submit') {
                    submitBtn.style.display = '';
                    if (eventName === 'wpcf7invalid' && form) {
                        // CF7 injects its own tips (sometimes after this event) — prefer custom
                        dedupeAllFieldTips(form);
                        revalidateFormFields(form);
                        dedupeAllFieldTips(form);
                        setTimeout(function() {
                            revalidateFormFields(form);
                            dedupeAllFieldTips(form);
                        }, 0);
                    }
                }
            });
        });

        function showFormError(wrap, btn, errEl, msg) {
            var textEl = errEl.querySelector('.cf7-status__text');
            textEl.textContent = msg;
            wrap.classList.add('is-error');
            btn.style.display = 'none';
        }

        function setupValidation(form) {
            var nameFields = form.querySelectorAll('input[name="full-name"], input[name="last-name"]');
            var emailField = form.querySelector('input[name="your-email"]');
            var phoneField = form.querySelector('input[name="your-phone"]');

            nameFields.forEach(function(field) {
                field.addEventListener('invalid', function(e) {
                    e.preventDefault();
                });
                field.addEventListener('blur', function() { validateName(field); });
                field.addEventListener('input', function() { clearFieldError(field); });
            });

            if (emailField) {
                emailField.addEventListener('invalid', function(e) { e.preventDefault(); });
                emailField.addEventListener('blur', function() { validateEmail(emailField); });
                emailField.addEventListener('input', function() { clearFieldError(emailField); });
            }

            if (phoneField) {
                phoneField.addEventListener('invalid', function(e) { e.preventDefault(); });
                phoneField.addEventListener('blur', function() { validatePhone(phoneField); });
                phoneField.addEventListener('input', function() { clearFieldError(phoneField); });
            }
        }

        function revalidateFormFields(form) {
            form.querySelectorAll('input[name="full-name"], input[name="last-name"]').forEach(function(field) {
                if (field.classList.contains('wpcf7-not-valid') || !field.value.trim()) {
                    validateName(field);
                }
            });
            var emailField = form.querySelector('input[name="your-email"]');
            if (emailField && (emailField.classList.contains('wpcf7-not-valid') || !emailField.value.trim() || emailField.value.indexOf('@') === -1)) {
                validateEmail(emailField);
            }
            var phoneField = form.querySelector('input[name="your-phone"]');
            if (phoneField && phoneField.classList.contains('wpcf7-not-valid')) {
                validatePhone(phoneField);
            }
        }

        function dedupeFieldTips(wrap) {
            if (!wrap) return;
            var tips = wrap.querySelectorAll('.wpcf7-not-valid-tip');
            if (tips.length < 2) return;
            var custom = wrap.querySelectorAll('.cf7-custom-error');
            if (custom.length) {
                // Keep the latest custom tip; drop CF7 native (+ older custom duplicates)
                var keep = custom[custom.length - 1];
                tips.forEach(function(t) {
                    if (t !== keep) t.remove();
                });
                return;
            }
            // No custom — keep the last tip only
            for (var i = 0; i < tips.length - 1; i++) {
                tips[i].remove();
            }
        }

        function dedupeAllFieldTips(form) {
            form.querySelectorAll('.wpcf7-form-control-wrap').forEach(dedupeFieldTips);
        }

        function validateName(field) {
            var val = field.value.trim();
            var label = field.name === 'full-name' ? 'name' : 'last name';
            if (!val) {
                showFieldError(field, 'Please enter your ' + label + '.');
                return false;
            }
            if (val.length < 2) {
                showFieldError(field, 'Name must be at least 2 characters.');
                return false;
            }
            if (!/^[a-zA-ZÀ-ÿ\s\-']+$/.test(val)) {
                showFieldError(field, 'Please use letters only.');
                return false;
            }
            clearFieldError(field);
            return true;
        }

        function validateEmail(field) {
            var val = field.value;
            if (!val.trim()) {
                showFieldError(field, 'Please enter your email address.');
                return false;
            }
            if (val !== val.trim()) {
                showFieldError(field, 'Remove any extra spaces.');
                return false;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
                showFieldError(field, 'Enter a valid email address (e.g., name@example.com).');
                return false;
            }
            clearFieldError(field);
            return true;
        }

        function validatePhone(field) {
            var val = field.value.trim();
            if (!val) return true;
            var digits = val.replace(/\D/g, '');
            if (digits.length < 7) {
                showFieldError(field, 'Please enter the full phone number.');
                return false;
            }
            if (!/^[\d\s\+\-\(\)\.]+$/.test(val)) {
                showFieldError(field, 'Enter a valid phone number (e.g., +1 555 123 4567).');
                return false;
            }
            clearFieldError(field);
            return true;
        }

        function showFieldError(field, msg) {
            clearFieldError(field);
            field.classList.add('wpcf7-not-valid');
            var wrap = field.closest('.wpcf7-form-control-wrap') || field.parentNode;
            var tip = document.createElement('span');
            tip.className = 'wpcf7-not-valid-tip cf7-custom-error';
            tip.setAttribute('role', 'alert');
            tip.textContent = msg;
            wrap.appendChild(tip);
            dedupeFieldTips(wrap);
        }

        function clearFieldError(field) {
            field.classList.remove('wpcf7-not-valid');
            var wrap = field.closest('.wpcf7-form-control-wrap') || field.parentNode;
            // Remove CF7 native tips too — otherwise they stack under custom ones
            wrap.querySelectorAll('.wpcf7-not-valid-tip').forEach(function(t) { t.remove(); });
        }
    }

    /**
     * Initialize scroll animations
     */
    function initAnimations() {
        // Intersection Observer for fade-in animations
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        document.querySelectorAll('.animate-on-scroll, .feature-card, .custom-block').forEach(function (el) {
            observer.observe(el);
        });
    }

    /**
     * Helper function to create a slider dynamically
     * Can be called from other scripts
     */
    window.neamobCreateSlider = function (container, options) {
        if (typeof Swiper === 'undefined') {
            console.error('Swiper is not loaded');
            return null;
        }

        const defaultOptions = {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: container.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: container.querySelector('.swiper-button-next'),
                prevEl: container.querySelector('.swiper-button-prev'),
            },
        };

        return new Swiper(container, { ...defaultOptions, ...options });
    };

    function initCaseStudyForm() {
        var overlay = document.getElementById('case-study-form-overlay');
        if (!overlay) return;

        var backdrop = overlay.querySelector('.case-study-form-overlay__backdrop');
        var closeBtn = overlay.querySelector('.case-study-form-overlay__close');
        var activeRedirectUrl = '';

        function openForm(e) {
            e.preventDefault();
            var btn = e.currentTarget;
            activeRedirectUrl = btn.getAttribute('data-redirect-url') || '';
            overlay.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        }

        function closeForm() {
            overlay.classList.remove('is-active');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('[data-open-case-study-form]').forEach(function (btn) {
            btn.addEventListener('click', openForm);
        });

        if (closeBtn) closeBtn.addEventListener('click', closeForm);
        if (backdrop) backdrop.addEventListener('click', closeForm);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.classList.contains('is-active')) {
                closeForm();
            }
        });

        document.addEventListener('wpcf7mailsent', function (ev) {
            var formEl = overlay.querySelector('.wpcf7');
            if (!formEl) return;
            var unitTag = ev.detail && ev.detail.unitTag;
            if (unitTag && formEl.id === unitTag.replace(/^#/, '')) {
                var url = activeRedirectUrl;
                setTimeout(function () {
                    closeForm();
                    if (url) window.open(url, '_blank');
                }, 500);
            }
        });
    }

    /**
     * Header “Book a Free Audit” — light modal with CTA short form (Figma 6454:24966).
     */
    /**
     * Redesign header mega menus —
     * desktop: hover bridge across trigger → panel gap
     * mobile/tablet: accordion toggle (Services / Work / About)
     */
    function initHeaderMegaMenus() {
        if (!document.body.classList.contains('redesign-preview')) return;

        var items = document.querySelectorAll('.menu-item--services, .menu-item--work, .menu-item--about');
        if (!items.length) return;

        var closeDelay = 180;
        var timer = null;
        var desktopMq = window.matchMedia('(min-width: 1200px)');

        function isDesktop() {
            return desktopMq.matches;
        }

        function closeAll(except) {
            items.forEach(function (item) {
                if (item !== except) item.classList.remove('is-mega-open');
            });
        }

        items.forEach(function (item) {
            var mega = item.querySelector('.services-mega, .work-mega, .about-mega, .nav-mega');
            var trigger = item.querySelector('a');
            // Prefer direct child link (parent label), not nested mega links
            for (var i = 0; i < item.children.length; i++) {
                if (item.children[i].tagName === 'A') {
                    trigger = item.children[i];
                    break;
                }
            }
            if (!mega || !trigger) return;

            function open() {
                clearTimeout(timer);
                timer = null;
                closeAll(item);
                item.classList.add('is-mega-open');
            }

            function scheduleClose() {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    item.classList.remove('is-mega-open');
                    timer = null;
                }, closeDelay);
            }

            // Desktop hover / focus
            item.addEventListener('mouseenter', function () {
                if (isDesktop()) open();
            });
            item.addEventListener('mouseleave', function () {
                if (isDesktop()) scheduleClose();
            });
            mega.addEventListener('mouseenter', function () {
                if (isDesktop()) open();
            });
            mega.addEventListener('mouseleave', function () {
                if (isDesktop()) scheduleClose();
            });
            item.addEventListener('focusin', function () {
                if (isDesktop()) open();
            });
            item.addEventListener('focusout', function (e) {
                if (isDesktop() && !item.contains(e.relatedTarget)) scheduleClose();
            });

            // Mobile / tablet accordion
            trigger.addEventListener('click', function (e) {
                if (isDesktop()) return;
                e.preventDefault();
                e.stopPropagation();
                var willOpen = !item.classList.contains('is-mega-open');
                closeAll(willOpen ? item : null);
                if (willOpen) {
                    item.classList.add('is-mega-open');
                } else {
                    item.classList.remove('is-mega-open');
                }
            });
        });

        // Close accordion panels when drawer closes
        var mainNav = document.querySelector('.main-nav');
        if (mainNav) {
            var observer = new MutationObserver(function () {
                if (!mainNav.classList.contains('to-show')) closeAll(null);
            });
            observer.observe(mainNav, { attributes: true, attributeFilter: ['class'] });
        }

        desktopMq.addEventListener('change', function () {
            closeAll(null);
        });
    }

    /**
     * Portfolio redesign YouTube embeds in content blocks.
     */
    function initPortfolioBlockVideos() {
        if (!document.body.classList.contains('redesign-preview')) return;

        document.querySelectorAll('.portfolio-block-v2 .video-wrapper').forEach(function (wrapper) {
            wrapper.addEventListener('click', function () {
                var videoId = this.getAttribute('data-video-id');
                if (!videoId) return;
                this.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            });
        });
    }

    function initAuditForm() {
        var overlay = document.getElementById('audit-form-overlay');
        if (!overlay) return;

        function openForm(e) {
            if (e) e.preventDefault();
            overlay.hidden = false;
            overlay.classList.add('is-active');
            document.body.style.overflow = 'hidden';
            var first = overlay.querySelector('input, select, textarea');
            if (first) {
                setTimeout(function () { first.focus(); }, 50);
            }
        }

        function closeForm() {
            overlay.classList.remove('is-active');
            overlay.hidden = true;
            document.body.style.overflow = '';
        }

        document.querySelectorAll('[data-open-audit-form]').forEach(function (btn) {
            btn.addEventListener('click', openForm);
        });

        overlay.querySelectorAll('[data-close-audit-form]').forEach(function (el) {
            el.addEventListener('click', closeForm);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.classList.contains('is-active')) {
                closeForm();
            }
        });

        if (window.location.hash === '#audit-form') {
            openForm();
        }

        document.addEventListener('wpcf7mailsent', function (ev) {
            var formEl = overlay.querySelector('.wpcf7');
            if (!formEl) return;
            var unitTag = ev.detail && ev.detail.unitTag;
            if (unitTag && formEl.id === unitTag.replace(/^#/, '')) {
                setTimeout(closeForm, 1200);
            }
        });
    }

    // Video Overlay
    var videoOverlay = document.getElementById('video-overlay');
    if (videoOverlay) {
        var videoPlayer = videoOverlay.querySelector('.video-overlay__player');
        var videoClose = videoOverlay.querySelector('.video-overlay__close');
        var videoBackdrop = videoOverlay.querySelector('.video-overlay__backdrop');

        function openVideo() {
            videoOverlay.classList.add('is-active');
            document.body.style.overflow = 'hidden';
            if (videoPlayer) {
                videoPlayer.muted = true;
                videoPlayer.controls = true;
                videoPlayer.currentTime = 0;
                videoPlayer.play();
            }
        }

        function closeVideo() {
            videoOverlay.classList.remove('is-active');
            document.body.style.overflow = '';
            if (videoPlayer) {
                videoPlayer.pause();
                videoPlayer.currentTime = 0;
            }
        }

        document.querySelectorAll('[data-open-video-overlay]').forEach(function(trigger) {
            trigger.addEventListener('click', openVideo);
        });

        if (videoClose) videoClose.addEventListener('click', closeVideo);
        if (videoBackdrop) videoBackdrop.addEventListener('click', closeVideo);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && videoOverlay.classList.contains('is-active')) {
                closeVideo();
            }
        });
    }

    // ── GTM dataLayer: CF7 form submissions ──────────────────────
    (function() {
        var formMap = {
            '60':   'contact',
            '61':   'job_application',
            '6261': 'case_study_download'
        };

        var pageSlug = document.body.className.match(/page-template-page-([^\s]+)/);
        var pageType = 'other';
        if (document.body.classList.contains('home')) {
            pageType = 'home';
        } else if (document.body.classList.contains('single-post')) {
            pageType = 'blog_post';
        } else if (document.body.classList.contains('single-case_study')) {
            pageType = 'case_study';
        } else if (document.body.classList.contains('single-job')) {
            pageType = 'job';
        } else if (pageSlug) {
            pageType = pageSlug[1].replace(/-/g, '_');
        }

        document.addEventListener('wpcf7mailsent', function(ev) {
            var detail = ev.detail || {};
            var formId = String(detail.contactFormId || '');
            var formName = formMap[formId] || 'unknown_' + formId;
            var inputs = detail.inputs || [];

            var fieldData = {};
            inputs.forEach(function(input) {
                if (input.name && input.value) {
                    fieldData[input.name] = input.value;
                }
            });

            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'cf7_submission',
                form_id: formName,
                form_cf7_id: formId,
                page_type: pageType,
                page_url: window.location.pathname,
                page_title: document.title,
                user_email: fieldData['your-email'] || '',
                user_name: (fieldData['full-name'] || '') + (fieldData['last-name'] ? ' ' + fieldData['last-name'] : '')
            });
        });
    })();

})();

