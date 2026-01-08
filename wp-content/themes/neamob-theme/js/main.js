/**
 * Neamob Theme - Main JavaScript
 * Includes Swiper slider initialization and custom functionality
 */

(function() {
    'use strict';

    /**
     * Initialize when DOM is ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        initSwiperSliders();
        initMobileMenu();
        initSmoothScroll();
        initAnimations();
        initServicesAccordion();
        initTestimonialsSlider();
        initFaqAccordion();
    });

    /**
     * Initialize all Swiper sliders on the page
     */
    function initSwiperSliders() {
        // Hero Slider
        const heroSliders = document.querySelectorAll('.hero-slider .swiper');
        heroSliders.forEach(function(slider) {
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
        cardsSliders.forEach(function(slider) {
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
        testimonialsSliders.forEach(function(slider) {
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
        gallerySliders.forEach(function(slider) {
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
        genericSliders.forEach(function(wrapper) {
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
        const menuToggle = document.querySelector('.menu-toggle');
        const mainNav = document.querySelector('.main-nav');

        if (menuToggle && mainNav) {
            menuToggle.addEventListener('click', function() {
                mainNav.classList.toggle('is-open');
                menuToggle.classList.toggle('is-active');
                menuToggle.setAttribute(
                    'aria-expanded',
                    menuToggle.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
                );
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mainNav.contains(e.target) && !menuToggle.contains(e.target)) {
                    mainNav.classList.remove('is-open');
                    menuToggle.classList.remove('is-active');
                    menuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    /**
     * Initialize smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
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
     * Initialize Testimonials Slider with custom pagination
     */
    function initTestimonialsSlider() {
        const sliderContainers = document.querySelectorAll('.testimonial-slider');
        
        sliderContainers.forEach(function(container) {
            const swiperEl = container.querySelector('.swiper');
            const paginationCurrent = container.querySelector('.testimonial-pagination__current');
            const paginationTotal = container.querySelector('.testimonial-pagination__total');
            const prevBtn = container.querySelector('.testimonial-nav__prev');
            const nextBtn = container.querySelector('.testimonial-nav__next');
            
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
                    init: function() {
                        updatePagination(this, paginationCurrent, paginationTotal);
                    },
                    slideChange: function() {
                        updatePagination(this, paginationCurrent, paginationTotal);
                    }
                }
            });
        });

        function updatePagination(swiper, currentEl, totalEl) {
            if (currentEl && totalEl) {
                const current = String(swiper.realIndex + 1).padStart(2, '0');
                const total = String(swiper.slides.length - (swiper.loopedSlides * 2 || 0)).padStart(2, '0');
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
        
        accordions.forEach(function(accordion) {
            const items = accordion.querySelectorAll('.services-accordion__item');
            
            items.forEach(function(item) {
                const header = item.querySelector('.services-accordion__header');
                
                header.addEventListener('click', function() {
                    const isActive = item.classList.contains('is-active');
                    
                    // Close all items
                    items.forEach(function(otherItem) {
                        otherItem.classList.remove('is-active');
                    });
                    
                    // Open clicked item if it wasn't already open
                    if (!isActive) {
                        item.classList.add('is-active');
                    }
                });
            });

            // Open first item by default
            if (items.length > 0 && !accordion.querySelector('.services-accordion__item.is-active')) {
                items[0].classList.add('is-active');
            }
        });
    }

    /**
     * Initialize FAQ Accordion
     */
    function initFaqAccordion() {
        const faqLists = document.querySelectorAll('.faq-list');
        
        faqLists.forEach(function(faqList) {
            const items = faqList.querySelectorAll('.faq-item');
            
            items.forEach(function(item) {
                const header = item.querySelector('.faq-item__header');
                
                header.addEventListener('click', function() {
                    const isActive = item.classList.contains('is-active');
                    
                    // Close all items
                    items.forEach(function(otherItem) {
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
     * Initialize scroll animations
     */
    function initAnimations() {
        // Intersection Observer for fade-in animations
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        document.querySelectorAll('.animate-on-scroll, .feature-card, .custom-block').forEach(function(el) {
            observer.observe(el);
        });
    }

    /**
     * Helper function to create a slider dynamically
     * Can be called from other scripts
     */
    window.neamobCreateSlider = function(container, options) {
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

})();

