/**
 * Neamob Theme - Main JavaScript
 * Includes Swiper slider initialization and custom functionality
 */

(function () {
    'use strict';

    function initLenis() {
        if (typeof Lenis === 'undefined') return;
        var lenis = new Lenis({
            duration: 1.2,
            easing: function(t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
            touchMultiplier: 2,
        });
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
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
        initFaqAccordion();
        initContactForm();
        initCaseStudyForm();
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
            if (text === "Let's Chat" || text === 'Book Free Audit') {
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
                        asterisk.textContent = ' *';
                        node.after(asterisk);
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
        }

        function clearFieldError(field) {
            field.classList.remove('wpcf7-not-valid');
            var wrap = field.closest('.wpcf7-form-control-wrap') || field.parentNode;
            var tips = wrap.querySelectorAll('.cf7-custom-error');
            tips.forEach(function(t) { t.remove(); });
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

})();

