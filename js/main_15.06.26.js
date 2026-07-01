/**
 * ============================================================
 * main.js - Единый файл инициализации
 * ============================================================
 */

// ==================== ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ====================

/**
 * Подгонка высоты GLightbox под содержимое
 */
function fitGlightboxToContent(slideNode) {
    const media = slideNode.querySelector('.gslide-media.gslide-inline');
    const inline = slideNode.querySelector('.gslide-inline .ginlined-content');

    if (!inline) return;

    if (media) {
        media.style.height = 'auto';
        media.style.maxHeight = 'calc(100vh - 10px)';
    }

    inline.style.height = 'auto';
    inline.style.maxHeight = 'calc(100vh - 10px)';
    inline.style.overflow = window.innerWidth > 768 ? 'hidden' : 'auto';

    const content = inline.querySelector('.modal-window') || inline;
    const contentHeight = content.scrollHeight + 40;
    const maxHeight = window.innerHeight - 10;
    const finalHeight = Math.min(contentHeight, maxHeight);

    if (media) {
        media.style.height = `${finalHeight}px`;
    }

    inline.style.height = `${finalHeight}px`;
}

// ==================== ИНИЦИАЛИЗАТОРЫ МОДУЛЕЙ ====================

/**
 * Меню и подменю
 */
function initHeaderMenu() {
    const headerMenu = document.querySelector('.header__menu');
    const burger = document.querySelector('.burger');

    if (!headerMenu || !burger) return;

    const isMobileMenu = () => window.innerWidth < 620;

    const clearActive = () => {
        document.querySelectorAll('.is-active').forEach((el) => {
            el.classList.remove('is-active');
        });
    };

    function closeMenu() {
        headerMenu.classList.remove('header__menu--open');
        headerMenu.classList.remove('show-submenu');
        clearActive();
    }

    // Виджет в "Our solutions"
    const widgetNavItems = document.querySelectorAll('.header__nav-item--with-widget');

    widgetNavItems.forEach((item) => {
        const submenu = item.querySelector('.submenu');
        if (!submenu) return;

        const widget = submenu.querySelector('.submenu__widget');
        if (!widget) return;

        const defaultTextEl = widget.querySelector('.widget__text--default');
        const dynamicTextEl = widget.querySelector('.widget__text--dynamic');
        const ctaBtn = widget.querySelector('.widget__btn');
        const submenuItems = submenu.querySelectorAll('.submenu__item');

        if (!defaultTextEl || !dynamicTextEl || !ctaBtn) return;

        const defaultHref = ctaBtn.getAttribute('href') || '#';

        const resetWidget = () => {
            dynamicTextEl.textContent = defaultTextEl.textContent;
            defaultTextEl.style.display = 'block';
            widget.classList.remove('item-hovered');
            ctaBtn.setAttribute('href', defaultHref);
        };

        item.addEventListener('mouseenter', resetWidget);
        item.addEventListener('mouseleave', resetWidget);

        submenuItems.forEach((subItem) => {
            subItem.addEventListener('mouseenter', () => {
                const text = subItem.getAttribute('data-text') || defaultTextEl.textContent;
                const link = subItem.getAttribute('data-link') || defaultHref;

                dynamicTextEl.textContent = text;
                defaultTextEl.style.display = 'none';
                widget.classList.add('item-hovered');
                ctaBtn.setAttribute('href', link);
            });
        });
    });

    burger.addEventListener('click', () => {
        const isOpen = headerMenu.classList.contains('header__menu--open');
        if (isOpen) {
            closeMenu();
        } else {
            headerMenu.classList.add('header__menu--open');
        }
    });

    document.addEventListener('click', (e) => {
        if (!headerMenu.contains(e.target) && !burger.contains(e.target)) {
            closeMenu();
        }
    });

    const topNavLinks = document.querySelectorAll(
        '.header__nav > .header__nav-list > .header__nav-item > .header__nav-link'
    );

    topNavLinks.forEach((link) => {
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                link.classList.toggle('is-active');
            }
        });
    });

    const navItemsWithSubmenu = document.querySelectorAll('.header__nav-item--has-submenu');

    navItemsWithSubmenu.forEach((item) => {
        const link = item.querySelector(':scope > .header__nav-link');
        const toggle = item.querySelector(':scope > .header__nav-toggle');

        const openSubmenu = (e) => {
            if (!isMobileMenu()) return;

            e.preventDefault();
            e.stopPropagation();

            navItemsWithSubmenu.forEach((i) => i.classList.remove('is-active'));
            item.classList.add('is-active');
            headerMenu.classList.add('show-submenu');
        };

        if (link) link.addEventListener('click', openSubmenu);
        if (toggle) toggle.addEventListener('click', openSubmenu);
    });

    document.querySelectorAll('.btn-back-menu').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            if (!isMobileMenu()) return;

            e.preventDefault();
            e.stopPropagation();

            headerMenu.classList.remove('show-submenu');
            navItemsWithSubmenu.forEach((i) => i.classList.remove('is-active'));
        });
    });

    window.addEventListener('resize', () => {
        if (!isMobileMenu()) {
            headerMenu.classList.remove('show-submenu');
            navItemsWithSubmenu.forEach((i) => i.classList.remove('is-active'));
        }
    });
}

/**
 * Продукты слайдер
 */
function initProductsSlider() {
    const section = document.querySelector('.products');
    if (!section) return;

    const slider = section.querySelector('.products__slider');
    const tabs = Array.from(section.querySelectorAll('.products__slider-tab'));
    const slides = Array.from(section.querySelectorAll('.products__slide'));
    const prevBtn = section.querySelector('.products__slider-arrow--prev');
    const nextBtn = section.querySelector('.products__slider-arrow--next');
    const desktopImageEl = section.querySelector('.products__slider-image--desktop img');

    const mobileImageSwiperEl = section.querySelector('.products__slider-image-mobile');
    const mobileContentSwiperEl = section.querySelector('.products__slider-content-swiper');

    if (!slider || !tabs.length || !slides.length) return;

    const total = Math.min(tabs.length, slides.length);
    const mobileMedia = window.matchMedia('(max-width: 767.98px)');

    let current = slides.findIndex((slide) => slide.classList.contains('products__slide--active'));
    if (current < 0) current = 0;

    let mobileImageSwiper = null;
    let mobileContentSwiper = null;

    if (!slider.hasAttribute('tabindex')) {
        slider.setAttribute('tabindex', '0');
    }

    function updateDesktopImage(index) {
        if (!desktopImageEl) return;

        const slide = slides[index];
        if (!slide) return;

        const imageUrl = slide.dataset.image;
        const title = slide.querySelector('.products__slide-title')?.textContent?.trim() || '';

        if (imageUrl) desktopImageEl.src = imageUrl;
        desktopImageEl.alt = title;
    }

    function updateTabs(index) {
        tabs.forEach((tab, i) => {
            tab.classList.toggle('products__slider-tab--active', i === index);
        });

        if (mobileMedia.matches) {
            const activeTab = tabs[index];
            const tabsContainer = activeTab?.parentElement;

            if (activeTab && tabsContainer) {
                const containerRect = tabsContainer.getBoundingClientRect();
                const tabRect = activeTab.getBoundingClientRect();

                const offset = activeTab.offsetLeft - (tabsContainer.clientWidth / 2) + (activeTab.clientWidth / 2);

                tabsContainer.scrollTo({
                    left: offset,
                    behavior: 'smooth'
                });
            }
        }
    }

    function setDisabled(index) {
        if (!prevBtn || !nextBtn) return;

        const prevDisabled = index === 0;
        const nextDisabled = index === total - 1;

        prevBtn.classList.toggle('products__slider-arrow--disabled', prevDisabled);
        nextBtn.classList.toggle('products__slider-arrow--disabled', nextDisabled);

        prevBtn.disabled = prevDisabled;
        nextBtn.disabled = nextDisabled;
    }

    function setDesktopActive(index) {
        if (index < 0 || index >= total || index === current) return;

        slides[current]?.classList.remove('products__slide--active');
        slides[index]?.classList.add('products__slide--active');

        current = index;

        updateTabs(current);
        updateDesktopImage(current);
        setDisabled(current);
    }

    function syncDesktopState(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('products__slide--active', i === index);
        });

        current = index;
        updateTabs(current);
        updateDesktopImage(current);
        setDisabled(current);
    }

    function destroyMobileSwipers() {
        if (mobileContentSwiper) {
            mobileContentSwiper.destroy(true, true);
            mobileContentSwiper = null;
        }

        if (mobileImageSwiper) {
            mobileImageSwiper.destroy(true, true);
            mobileImageSwiper = null;
        }
    }

    function initMobileSwipers() {
        if (!mobileImageSwiperEl || !mobileContentSwiperEl) return;
        if (mobileImageSwiper || mobileContentSwiper) return;

        mobileImageSwiper = new Swiper(mobileImageSwiperEl, {
            slidesPerView: 1,
            spaceBetween: 16,
            speed: 450,
            allowTouchMove: true,
            simulateTouch: true,
            watchSlidesProgress: true
        });

        mobileContentSwiper = new Swiper(mobileContentSwiperEl, {
            slidesPerView: 1,
            spaceBetween: 16,
            speed: 450,
            allowTouchMove: true,
            simulateTouch: true,
            autoHeight: false,
            watchSlidesProgress: true,
            on: {
                init(swiper) {
                    current = swiper.activeIndex;
                    updateTabs(current);
                },
                slideChange(swiper) {
                    current = swiper.activeIndex;
                    updateTabs(current);
                }
            }
        });

        mobileImageSwiper.controller.control = mobileContentSwiper;
        mobileContentSwiper.controller.control = mobileImageSwiper;

        mobileImageSwiper.slideTo(current, 0);
        mobileContentSwiper.slideTo(current, 0);
    }

    function applyMode() {
        if (mobileMedia.matches) {
            initMobileSwipers();
        } else {
            destroyMobileSwipers();
            syncDesktopState(current);
        }
    }

    tabs.slice(0, total).forEach((tab, index) => {
        tab.addEventListener('click', () => {
            if (mobileMedia.matches) {
                mobileContentSwiper?.slideTo(index);
            } else {
                setDesktopActive(index);
            }
        });
    });

    prevBtn?.addEventListener('click', () => {
        if (mobileMedia.matches) return;
        setDesktopActive(current - 1);
    });

    nextBtn?.addEventListener('click', () => {
        if (mobileMedia.matches) return;
        setDesktopActive(current + 1);
    });

    slider.addEventListener('keydown', (e) => {
        if (mobileMedia.matches) return;

        if (e.key === 'ArrowLeft') setDesktopActive(current - 1);
        if (e.key === 'ArrowRight') setDesktopActive(current + 1);
    });

    syncDesktopState(current);
    applyMode();

    if (typeof mobileMedia.addEventListener === 'function') {
        mobileMedia.addEventListener('change', applyMode);
    } else {
        mobileMedia.addListener(applyMode);
    }
}

/**
 * Отзывы слайдер
 */
function initTestimonialsSlider() {
    const sliders = document.querySelectorAll('.testimonials__slider');

    sliders.forEach((slider) => {
        const prevBtn = slider.querySelector('.testimonials__arrow-prev');
        const nextBtn = slider.querySelector('.testimonials__arrow-next');

        new Swiper(slider, {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false
            },
            speed: 800,
            grabCursor: true,
            navigation: {
                nextEl: nextBtn,
                prevEl: prevBtn
            }
        });
    });
}

/**
 * Кейсы слайдер
 */
function initCasesSlider() {
    const caseSections = document.querySelectorAll('.cases');

    caseSections.forEach((section) => {
        const sliderEl = section.querySelector('.cases__slider');
        if (!sliderEl) return;

        const prevBtn = section.querySelector('.cases__arrow-prev');
        const nextBtn = section.querySelector('.cases__arrow-next');

        new Swiper(sliderEl, {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            speed: 700,
            grabCursor: true,
            autoplay: false,
            allowTouchMove: true,
            simulateTouch: true,
            touchStartPreventDefault: false,
            threshold: 10,
            touchReleaseOnEdges: true,
            navigation: {
                prevEl: prevBtn,
                nextEl: nextBtn
            }
        });
    });
}

/**
 * Документация табы + свайп
 */
function initDocTabs() {
    const tabsBlocks = document.querySelectorAll('.doc__tabs');

    tabsBlocks.forEach((block, blockIndex) => {
        const buttons = Array.from(block.querySelectorAll('.doc__tab-list .doc__tab-item'));
        const panels = Array.from(block.querySelectorAll('.doc__tab-content-list .doc__tab-content-item'));

        const prevArrow = block.querySelector('.doc__tab-arrow-prev');
        const nextArrow = block.querySelector('.doc__tab-arrow-next');

        const contentList = block.querySelector('.doc__tab-content-list');
        if (!buttons.length || !panels.length || !contentList) return;

        const count = Math.min(buttons.length, panels.length);

        const tablist = block.querySelector('.doc__tab-list');
        if (tablist) {
            tablist.setAttribute('role', 'tablist');
        }

        buttons.slice(0, count).forEach((btn, i) => {
            btn.setAttribute('role', 'tab');
            btn.setAttribute('type', 'button');

            const panelId = `doc-tabpanel-${blockIndex}-${i}`;
            const tabId = `doc-tab-${blockIndex}-${i}`;

            btn.id = btn.id || tabId;
            btn.setAttribute('aria-controls', panelId);

            panels[i].setAttribute('role', 'tabpanel');
            panels[i].id = panels[i].id || panelId;
            panels[i].setAttribute('aria-labelledby', btn.id);
        });

        const setArrowState = (activeIndex) => {
            if (prevArrow) {
                const disabled = activeIndex === 0;
                prevArrow.classList.toggle('doc__tab-arrow--disabled', disabled);
                prevArrow.setAttribute('aria-disabled', String(disabled));
            }

            if (nextArrow) {
                const disabled = activeIndex === count - 1;
                nextArrow.classList.toggle('doc__tab-arrow--disabled', disabled);
                nextArrow.setAttribute('aria-disabled', String(disabled));
            }
        };

        function getActiveIndex() {
            const fromData = Number(block.dataset.activeIndex);
            if (Number.isFinite(fromData) && fromData >= 0 && fromData < count) return fromData;

            const fromClass = buttons.findIndex((b) => b.classList.contains('doc__tab-item--active'));
            return Math.max(0, fromClass);
        }

        function setActive(index, opts = {}) {
            if (index < 0 || index >= count) return;

            for (let i = 0; i < count; i++) {
                const isActive = i === index;

                buttons[i].classList.toggle('doc__tab-item--active', isActive);
                buttons[i].setAttribute('aria-selected', String(isActive));
                buttons[i].setAttribute('tabindex', isActive ? '0' : '-1');

                panels[i].classList.toggle('doc__tab-content-item--active', isActive);
                panels[i].hidden = !isActive;
            }

            setArrowState(index);
            block.dataset.activeIndex = String(index);

            if (opts.focusTab) {
                buttons[index]?.focus?.({ preventScroll: true });
            }
        }

        setActive(getActiveIndex(), { focusTab: false });

        block.addEventListener('click', (e) => {
            const btn = e.target.closest('.doc__tab-item');
            if (btn && block.contains(btn)) {
                const idx = buttons.indexOf(btn);
                if (idx !== -1 && idx < count) setActive(idx, { focusTab: true });
                return;
            }

            const prev = e.target.closest('.doc__tab-arrow-prev');
            if (prev && block.contains(prev) && !prev.classList.contains('doc__tab-arrow--disabled')) {
                const current = getActiveIndex();
                if (current > 0) setActive(current - 1, { focusTab: true });
                return;
            }

            const next = e.target.closest('.doc__tab-arrow-next');
            if (next && block.contains(next) && !next.classList.contains('doc__tab-arrow--disabled')) {
                const current = getActiveIndex();
                if (current < count - 1) setActive(current + 1, { focusTab: true });
            }
        });

        block.addEventListener('keydown', (e) => {
            const currentBtn = e.target.closest('.doc__tab-item');
            if (!currentBtn || !block.contains(currentBtn)) return;

            const currentIndex = buttons.indexOf(currentBtn);
            if (currentIndex === -1) return;

            let nextIndex = null;

            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') nextIndex = (currentIndex + 1) % count;
            if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') nextIndex = (currentIndex - 1 + count) % count;
            if (e.key === 'Home') nextIndex = 0;
            if (e.key === 'End') nextIndex = count - 1;

            if (nextIndex === null) return;

            e.preventDefault();
            setActive(nextIndex, { focusTab: true });
        });

        let startX = 0;
        let startY = 0;
        let isSwiping = false;

        const SWIPE_THRESHOLD = 40;
        const VERTICAL_LIMIT = 25;

        contentList.addEventListener('pointerdown', (e) => {
            if (e.target.closest('a, button, input, textarea, select, label')) return;

            startX = e.clientX;
            startY = e.clientY;
            isSwiping = true;
        });

        contentList.addEventListener('pointermove', (e) => {
            if (!isSwiping) return;

            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            if (Math.abs(dy) > VERTICAL_LIMIT && Math.abs(dy) > Math.abs(dx)) {
                isSwiping = false;
            }
        });

        contentList.addEventListener('pointerup', (e) => {
            if (!isSwiping) return;
            isSwiping = false;

            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            if (Math.abs(dy) > Math.abs(dx)) return;

            const current = getActiveIndex();

            if (dx > SWIPE_THRESHOLD) setActive(current - 1);
            else if (dx < -SWIPE_THRESHOLD) setActive(current + 1);
        });

        contentList.addEventListener('pointercancel', () => {
            isSwiping = false;
        });
    });
}

/**
 * Cookie баннер
 */
function initCookieBanner() {
    const banner = document.getElementById('cookieBanner');
    if (!banner) return;

    const buttons = banner.querySelectorAll('.cookie__btn');

    if (!localStorage.getItem('cookieAccepted')) {
        banner.classList.add('cookie-banner--visible');
    }

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const isDecline = btn.classList.contains('cookie__btn--gray');

            localStorage.setItem('cookieAccepted', isDecline ? 'declined' : 'accepted');
            banner.classList.remove('cookie-banner--visible');
        });
    });
}

/**
 * Клиенты hover/click
 */
function initClientsHover() {
    const items = document.querySelectorAll('.clients__item');
    if (!items.length) return;

    let activeItem = document.querySelector('.clients__item--active');

    items.forEach((item) => {
        item.addEventListener('mouseenter', function() {
            items.forEach((el) => el.classList.remove('clients__item--active'));
            this.classList.add('clients__item--active');
        });

        item.addEventListener('click', function() {
            items.forEach((el) => el.classList.remove('clients__item--active'));
            this.classList.add('clients__item--active');
            activeItem = this;
        });
    });
}

/**
 * Новости слайдер
 */
function initNewsSlider() {
    const sliderEl = document.querySelector('.news__content.swiper');
    if (!sliderEl) return;

    const nextBtn = document.querySelector('.news__arrow-next');
    const prevBtn = document.querySelector('.news__arrow-prev');
    const disabledClass = 'news__arrow--disabled';

    let swiperInstance = null;
    const mq = window.matchMedia('(max-width: 1199px)');

    const setArrowsDisabled = (isBeginning, isEnd) => {
        if (prevBtn) prevBtn.classList.toggle(disabledClass, !!isBeginning);
        if (nextBtn) nextBtn.classList.toggle(disabledClass, !!isEnd);
    };

    const bindArrowClicks = () => {
        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                if (!swiperInstance || prevBtn.classList.contains(disabledClass)) return;
                e.preventDefault();
                swiperInstance.slidePrev();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                if (!swiperInstance || nextBtn.classList.contains(disabledClass)) return;
                e.preventDefault();
                swiperInstance.slideNext();
            });
        }
    };

    bindArrowClicks();

    const initSwiper = () => {
        if (swiperInstance) return;

        swiperInstance = new Swiper(sliderEl, {
            slidesPerView: 1,
            spaceBetween: 16,
            speed: 500,
            watchOverflow: true,
            breakpoints: {
                0: { slidesPerView: 1 },
                576: { slidesPerView: 1.2 },
                768: { slidesPerView: 1.6 },
                992: { slidesPerView: 2.2 }
            },
            on: {
                init(sw) {
                    setArrowsDisabled(sw.isBeginning, sw.isEnd);
                },
                slideChange(sw) {
                    setArrowsDisabled(sw.isBeginning, sw.isEnd);
                },
                resize(sw) {
                    setArrowsDisabled(sw.isBeginning, sw.isEnd);
                }
            }
        });

        setArrowsDisabled(swiperInstance.isBeginning, swiperInstance.isEnd);
    };

    const destroySwiper = () => {
        if (!swiperInstance) return;

        swiperInstance.destroy(true, true);
        swiperInstance = null;

        if (prevBtn) prevBtn.classList.remove(disabledClass);
        if (nextBtn) nextBtn.classList.remove(disabledClass);
    };

    const handle = () => {
        if (mq.matches) {
            initSwiper();
        } else {
            destroySwiper();
        }
    };

    handle();

    if (mq.addEventListener) {
        mq.addEventListener('change', handle);
    } else {
        mq.addListener(handle);
    }
}

/**
 * GLightbox и формы
 */
function initLightboxAndForms() {
    if (typeof window.initPhoneFields === 'function') {
        window.initPhoneFields(document);
    }

    if (typeof window.initHelpSelect === 'function') {
        window.initHelpSelect(document);
    }

    if (typeof window.initContactsForms === 'function') {
        window.initContactsForms(document);
    }

    if (typeof GLightbox === 'undefined') return;

    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: false,
        loop: false,
        draggable: false
    });

    lightbox.on('slide_after_load', ({ slideNode, slideConfig }) => {
        if (slideConfig?.type !== 'inline') return;

        if (typeof window.initPhoneFields === 'function') {
            window.initPhoneFields(slideNode);
        }

        if (typeof window.initHelpSelect === 'function') {
            window.initHelpSelect(slideNode);
        }

        if (typeof window.initContactsForms === 'function') {
            window.initContactsForms(slideNode);
        }

        requestAnimationFrame(() => fitGlightboxToContent(slideNode));
        setTimeout(() => fitGlightboxToContent(slideNode), 50);
    });

    window.addEventListener('resize', () => {
        const activeSlide = document.querySelector('.gslide.loaded.current');
        if (activeSlide) {
            fitGlightboxToContent(activeSlide);
        }
    });
}

/**
 * Модальное окно с формой
 */
// function initModalForm(modalId, buttonSelector) {
//     if (typeof MicroModal === 'undefined') return;

//     const modal = document.getElementById(modalId);
//     const openButtons = document.querySelectorAll(buttonSelector);

//     if (!modal || !openButtons.length) return;

//     let scrollY = 0;

//     openButtons.forEach((button) => {
//         button.addEventListener('click', (e) => {
//             e.preventDefault();

//             scrollY = window.scrollY;

//             document.body.style.position = 'fixed';
//             document.body.style.top = `-${scrollY}px`;
//             document.body.style.left = '0';
//             document.body.style.right = '0';
//             document.body.style.width = '100%';

//             MicroModal.show(modalId, {
//                 openClass: 'is-open',
//                 disableScroll: false,
//                 disableFocus: false,

//                 onShow: (modalEl) => {
//                     initCustomFormUi(modalEl);
//                 },

//                 onClose: () => {
//                     document.body.style.position = '';
//                     document.body.style.top = '';
//                     document.body.style.left = '';
//                     document.body.style.right = '';
//                     document.body.style.width = '';

//                     window.scrollTo(0, scrollY);
//                 }
//             });
//         });
//     });
// }

function initModalForm(modalId, buttonSelector) {
    if (typeof MicroModal === 'undefined') return;
    
    const modal = document.getElementById(modalId);
    const openButtons = document.querySelectorAll(buttonSelector);
    
    if (!modal || !openButtons.length) return;
    
    openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Блокируем скролл на html (а не на body)
            document.documentElement.style.overflow = 'hidden';
            
            MicroModal.show(modalId, {
                openClass: 'is-open',
                disableScroll: false,
                disableFocus: false,
                onShow: (modalEl) => {
                    if (typeof initCustomFormUi === 'function') {
                        initCustomFormUi(modalEl);
                    }
                },
                onClose: () => {
                    // Разблокируем скролл
                    document.documentElement.style.overflow = '';
                }
            });
        });
    });
}


// Инициализация окна отзывов
function initReviewModal(modalId, buttonSelector) {
    if (typeof MicroModal === 'undefined') return;

    const modal = document.getElementById(modalId);
    const openButtons = document.querySelectorAll(buttonSelector);

    if (!modal || !openButtons.length) return;

    const modalImage = modal.querySelector('.review__modal-image');
    const modalImageWrap = modal.querySelector('.review__image');
    const modalText = modal.querySelector('.review__content-text');

    openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const image = button.dataset.reviewImage || '';
            const alt = button.dataset.reviewAlt || '';
            const slide = button.closest('.testimonials__slide');
            const hiddenContent = slide ? slide.querySelector('.review-hidden-content') : null;
            const text = hiddenContent ? hiddenContent.innerHTML : '';

            if (modalImage && modalImageWrap) {
                if (image) {
                    modalImage.src = image;
                    modalImage.alt = alt;
                    modalImageWrap.style.display = '';
                } else {
                    modalImage.src = '';
                    modalImage.alt = '';
                    modalImageWrap.style.display = 'none';
                }
            }

            if (modalText) {
                modalText.innerHTML = text;
            }

            document.documentElement.style.overflow = 'hidden';

            MicroModal.show(modalId, {
                openClass: 'is-open',
                disableScroll: false,
                disableFocus: false,
                onClose: () => {
                    document.documentElement.style.overflow = '';
                }
            });
        });
    });
}

// Переключение картинки и текста отзыва во всплывающем окне
function initReviewTranscriptToggle() {

    const modal = document.getElementById('review');

    if (!modal) return;

    const buttons = modal.querySelectorAll('.review-btn--mobile');

    if (!buttons.length) return;

    buttons.forEach((button) => {

        button.addEventListener('click', (e) => {
            e.preventDefault();

            modal.classList.toggle('modal-review--transcript');
        });

    });

}

/**
 * Инициализация UI форм в контейнере
 */
function initCustomFormUi(container = document) {
    if (typeof window.initPhoneFields === 'function') {
        window.initPhoneFields(container);
    }

    if (typeof window.initHelpSelect === 'function') {
        window.initHelpSelect(container);
    }

    if (typeof window.initContactsForms === 'function') {
        window.initContactsForms(container);
    }
}

/**
 * Преимущества блок
 */
function initBenefitsSlider() {
    const section = document.querySelector('.benefits');
    if (!section) return;

    const tabs = Array.from(section.querySelectorAll('.benefits__tabs .section__tab'));
    const infoItems = Array.from(section.querySelectorAll('.benefits__info-item'));
    const images = Array.from(section.querySelectorAll('.benefits__images .benefits__image'));
    const mobileSwiperEl = section.querySelector('.benefits__mobile');

    if (!tabs.length) return;

    const total = Math.min(tabs.length, infoItems.length, images.length);
    const mobileMedia = window.matchMedia('(max-width: 991.98px)');

    let current = tabs.findIndex((tab) => tab.classList.contains('section__tab--active'));
    if (current < 0) current = 0;

    let mobileSwiper = null;

    function updateTabs(index) {
        tabs.forEach((tab, i) => {
            tab.classList.toggle('section__tab--active', i === index);
        });

        if (mobileMedia.matches) {
            tabs[index]?.scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });
        }
    }

    function setDesktopActive(index) {
        if (index < 0 || index >= total) return;

        infoItems.forEach((item, i) => {
            item.classList.toggle('benefits__info-item--active', i === index);
        });

        images.forEach((image, i) => {
            image.classList.toggle('benefits__image--active', i === index);
        });

        current = index;
        updateTabs(index);
    }

    function destroyMobileSwiper() {
        if (mobileSwiper) {
            mobileSwiper.destroy(true, true);
            mobileSwiper = null;
        }
    }

    function initMobileSwiper() {
        if (!mobileSwiperEl || mobileSwiper) return;

        mobileSwiper = new Swiper(mobileSwiperEl, {
            slidesPerView: 1,
            spaceBetween: 16,
            speed: 450,
            allowTouchMove: true,
            simulateTouch: true,
            observer: true,
            observeParents: true,
            autoHeight: false,
            on: {
                init(swiper) {
                    current = swiper.activeIndex;
                    updateTabs(current);
                },
                slideChange(swiper) {
                    current = swiper.activeIndex;
                    updateTabs(current);
                }
            }
        });

        mobileSwiper.slideTo(current, 0);
        mobileSwiper.update();
    }

    function applyMode() {
        if (mobileMedia.matches) {
            initMobileSwiper();
        } else {
            destroyMobileSwiper();
            setDesktopActive(current);
        }
    }

    tabs.slice(0, total).forEach((tab, index) => {
        tab.addEventListener('click', () => {
            if (mobileMedia.matches) {
                mobileSwiper?.slideTo(index);
            } else {
                setDesktopActive(index);
            }
        });
    });

    setDesktopActive(current);
    applyMode();

    if (typeof mobileMedia.addEventListener === 'function') {
        mobileMedia.addEventListener('change', applyMode);
    } else {
        mobileMedia.addListener(applyMode);
    }
}

/**
 * Особенности блок
 */
function initFeaturesBlock() {
    const section = document.querySelector('.features');
    if (!section) return;

    const tabsContainer = section.querySelector('.features__tabs--desktop');
    const panelContainer = section.querySelector('.features__panel');

    if (!tabsContainer || !panelContainer) return;

    const mobileMedia = window.matchMedia('(max-width: 1199.98px)');

    const originalTabsHTML = tabsContainer.innerHTML;
    const originalPanelsHTML = panelContainer.innerHTML;

    let current = 0;
    let tabsSwiper = null;
    let panelsSwiper = null;
    let isMobileInitialized = false;

    function getDesktopTabs() {
        return Array.from(section.querySelectorAll('.features__tabs--desktop .features__tab'));
    }

    function getDesktopPanels() {
        return Array.from(section.querySelectorAll('.features__panel .features__panel-content'));
    }

    function detectInitialIndex() {
        const tabs = getDesktopTabs();
        let activeIndex = tabs.findIndex(tab => tab.classList.contains('features__tab--active'));
        return activeIndex >= 0 ? activeIndex : 0;
    }

    function setDesktopState(index) {
        const tabs = getDesktopTabs();
        const panels = getDesktopPanels();

        const total = Math.min(tabs.length, panels.length);
        if (!total) return;

        if (index < 0) index = 0;
        if (index >= total) index = total - 1;

        tabs.forEach((tab, i) => {
            tab.classList.toggle('features__tab--active', i === index);
        });

        panels.forEach((panel, i) => {
            panel.classList.toggle('features__panel-content--active', i === index);
        });

        current = index;
    }

    function buildMobileTabsMarkup() {
        const parser = document.createElement('div');
        parser.innerHTML = originalTabsHTML;

        const tabs = Array.from(parser.querySelectorAll('.features__tab'));

        return `
            <div class="swiper-wrapper">
                ${tabs.map((tab, index) => {
                    tab.classList.toggle('features__tab--active', index === current);
                    tab.setAttribute('data-index', index);

                    return `
                        <div class="swiper-slide features__tab-slide" data-index="${index}">
                            ${tab.outerHTML}
                        </div>
                    `;
                }).join('')}
            </div>
        `;
    }

    function buildMobilePanelsMarkup() {
        const parser = document.createElement('div');
        parser.innerHTML = originalPanelsHTML;

        const panels = Array.from(parser.querySelectorAll('.features__panel-content'));

        return `
            <div class="swiper-wrapper">
                ${panels.map((panel, index) => {
                    panel.classList.remove('features__panel-content--active');
                    panel.setAttribute('data-index', index);

                    return `
                        <div class="swiper-slide features__panel-slide" data-index="${index}">
                            ${panel.outerHTML}
                        </div>
                    `;
                }).join('')}
            </div>
        `;
    }

    function updateMobileTabsState(index) {
        const mobileTabs = Array.from(tabsContainer.querySelectorAll('.features__tab'));
        mobileTabs.forEach((tab, i) => {
            tab.classList.toggle('features__tab--active', i === index);
        });
        current = index;
    }

    function destroySwipers() {
        if (tabsSwiper) {
            tabsSwiper.destroy(true, true);
            tabsSwiper = null;
        }

        if (panelsSwiper) {
            panelsSwiper.destroy(true, true);
            panelsSwiper = null;
        }

        isMobileInitialized = false;
    }

    function onMobileTabClick(e) {
        const tab = e.target.closest('.features__tab');
        if (!tab) return;

        const slide = tab.closest('.features__tab-slide');
        if (!slide) return;

        const index = Number(slide.dataset.index);
        if (Number.isNaN(index)) return;

        current = index;
        updateMobileTabsState(index);

        if (tabsSwiper) tabsSwiper.slideTo(index);
        if (panelsSwiper) panelsSwiper.slideTo(index);
    }

    function onDesktopTabClick(e) {
        const tab = e.currentTarget;
        const index = Number(tab.dataset.index);
        if (Number.isNaN(index)) return;

        setDesktopState(index);
    }

    function bindDesktopClicks() {
        const tabs = getDesktopTabs();
        tabs.forEach(tab => {
            tab.removeEventListener('click', onDesktopTabClick);
            tab.addEventListener('click', onDesktopTabClick);
        });
    }

    function initMobile() {
        if (isMobileInitialized) return;

        tabsContainer.classList.add('swiper');
        panelContainer.classList.add('swiper');

        tabsContainer.innerHTML = buildMobileTabsMarkup();
        panelContainer.innerHTML = buildMobilePanelsMarkup();

        tabsSwiper = new Swiper(tabsContainer, {
            slidesPerView: 'auto',
            spaceBetween: 16,
            speed: 600,
            freeMode: false,
            watchSlidesProgress: true,
            slideToClickedSlide: false,
            initialSlide: current,
        });

        panelsSwiper = new Swiper(panelContainer, {
            slidesPerView: 1,
            spaceBetween: 16,
            speed: 600,
            autoHeight: true,
            initialSlide: current
        });

        panelsSwiper.on('slideChange', function() {
            const index = panelsSwiper.activeIndex;
            current = index;
            updateMobileTabsState(index);

            if (tabsSwiper && tabsSwiper.activeIndex !== index) {
                tabsSwiper.slideTo(index);
            }
        });

        tabsSwiper.on('slideChange', function() {
            const index = tabsSwiper.activeIndex;
            current = index;
            updateMobileTabsState(index);

            if (panelsSwiper && panelsSwiper.activeIndex !== index) {
                panelsSwiper.slideTo(index);
            }
        });

        tabsContainer.addEventListener('click', onMobileTabClick);

        updateMobileTabsState(current);
        tabsSwiper.slideTo(current, 0);
        panelsSwiper.slideTo(current, 0);

        isMobileInitialized = true;
    }

    function restoreDesktop() {
        tabsContainer.removeEventListener('click', onMobileTabClick);

        destroySwipers();

        tabsContainer.classList.remove('swiper');
        panelContainer.classList.remove('swiper');

        tabsContainer.innerHTML = originalTabsHTML;
        panelContainer.innerHTML = originalPanelsHTML;

        bindDesktopClicks();
        setDesktopState(current);
    }

    function applyMode() {
        if (mobileMedia.matches) {
            initMobile();
        } else {
            restoreDesktop();
        }
    }

    current = detectInitialIndex();
    bindDesktopClicks();
    setDesktopState(current);
    applyMode();

    if (typeof mobileMedia.addEventListener === 'function') {
        mobileMedia.addEventListener('change', applyMode);
    } else {
        mobileMedia.addListener(applyMode);
    }
}

/**
 * Flow слайдер
 */
function initFlowSlider() {
    const section = document.querySelector('.flow');
    if (!section) return;

    const sliderEl = section.querySelector('.flow__slider');
    const tabs = Array.from(section.querySelectorAll('.flow__steps .flow__step'));
    const slides = Array.from(section.querySelectorAll('.flow__slide'));

    if (!sliderEl || !tabs.length || !slides.length) return;

    tabs.forEach((tab, index) => {
        tab.dataset.index = index;
    });

    function setActiveTab(index) {
        tabs.forEach((tab, i) => {
            tab.classList.toggle('section__tab--active', i === index);
        });
    }

    function clearActiveTabs() {
        tabs.forEach((tab) => {
            tab.classList.remove('section__tab--active');
        });
    }

    const flowSwiper = new Swiper(sliderEl, {
        direction: window.innerWidth < 1200 ? 'horizontal' : 'vertical',
        slidesPerView: 1.1,
        spaceBetween: 36,
        speed: 600,
        watchOverflow: true,
        centeredSlides: true,
        mousewheel: window.innerWidth >= 1200 ? {
            forceToAxis: true,
            releaseOnEdges: true
        } : false,
        breakpoints: {
            0: {
                direction: 'horizontal',
                slidesPerView: 1.1,
                spaceBetween: 16,
                mousewheel: false,
                centeredSlides: false,
            },
            991: {
                direction: 'horizontal',
                slidesPerView: 'auto',
                spaceBetween: 36,
                mousewheel: false,
                centeredSlides: false,
            },
            1200: {
                direction: 'vertical',
                slidesPerView: 1.1,
                spaceBetween: 36,
                mousewheel: {
                    forceToAxis: true,
                    releaseOnEdges: true
                }
            }
        },
        on: {
            init(swiper) {
                const index = swiper.activeIndex;

                if (index < tabs.length) {
                    setActiveTab(index);
                } else {
                    clearActiveTabs();
                }
            },
            slideChange(swiper) {
                const index = swiper.activeIndex;

                if (index < tabs.length) {
                    setActiveTab(index);
                } else {
                    clearActiveTabs();
                }
            }
        }
    });

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            flowSwiper.slideTo(index);
        });
    });

    window.addEventListener('resize', () => {
        flowSwiper.update();
    });
}

/**
 * Индустрии слайдер
 */
function initIndustriesSlider() {
    const section = document.querySelector('.industries');
    if (!section) return;

    const contentSliderEl = section.querySelector('.nvslider__main');
    const buttonsSliderEl = section.querySelector('.nvslider__buttons');
    const prevEl = section.querySelector('.nvslider__arrow--prev');
    const nextEl = section.querySelector('.nvslider__arrow--next');

    if (!contentSliderEl || !buttonsSliderEl || !prevEl || !nextEl) return;

    let syncSource = null;

    function setActiveButton(index) {
        const allButtons = section.querySelectorAll('.nvslider__btn');
        allButtons.forEach((btn) => btn.classList.remove('nvslider__btn--active'));

        const matchingSlides = section.querySelectorAll(
            `.nvslider__buttons .swiper-slide[data-swiper-slide-index="${index}"]`
        );

        matchingSlides.forEach((slide) => {
            const btn = slide.querySelector('.nvslider__btn');
            if (btn) btn.classList.add('nvslider__btn--active');
        });
    }

    const buttonsSwiper = new Swiper(buttonsSliderEl, {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 8,
        centeredSlides: true,
        slideToClickedSlide: true,
        watchSlidesProgress: true,
        speed: 600,
        nested: true,
        breakpoints: {
            0: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            991: { slidesPerView: 2.6, centeredSlides: true },
            1400: { slidesPerView: 3, centeredSlides: true }
        },
        on: {
            init(swiper) {
                setActiveButton(swiper.realIndex);
            },
            touchStart() {
                syncSource = 'buttons';
            },
            realIndexChange(swiper) {
                setActiveButton(swiper.realIndex);
                if (syncSource === 'content') return;
                contentSwiper.slideToLoop(swiper.realIndex, 600);
            },
            transitionEnd() {
                if (syncSource === 'buttons') {
                    syncSource = null;
                }
            }
        }
    });

    const contentSwiper = new Swiper(contentSliderEl, {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 32,
        speed: 600,
        autoHeight: false,
        allowTouchMove: true,
        initialSlide: 2,
        navigation: { prevEl, nextEl },
        on: {
            init(swiper) {
                setActiveButton(swiper.realIndex);
                buttonsSwiper.slideToLoop(swiper.realIndex, 0);
            },
            touchStart() {
                syncSource = 'content';
            },
            realIndexChange(swiper) {
                setActiveButton(swiper.realIndex);
                if (syncSource === 'buttons') return;
                buttonsSwiper.slideToLoop(swiper.realIndex, 600);
            },
            transitionEnd() {
                if (syncSource === 'content') {
                    syncSource = null;
                }
            }
        }
    });

    section.addEventListener('click', (e) => {
        const button = e.target.closest('.nvslider__btn');
        if (!button) return;

        const slide = button.closest('.swiper-slide');
        if (!slide) return;

        const index = Number(slide.dataset.swiperSlideIndex);
        if (Number.isNaN(index)) return;

        syncSource = 'buttons';
        setActiveButton(index);
        buttonsSwiper.slideToLoop(index, 600);
        contentSwiper.slideToLoop(index, 600);

        setTimeout(() => {
            if (syncSource === 'buttons') syncSource = null;
        }, 650);
    });

    prevEl.addEventListener('click', () => {
        syncSource = 'content';
        setTimeout(() => {
            if (syncSource === 'content') syncSource = null;
        }, 650);
    });

    nextEl.addEventListener('click', () => {
        syncSource = 'content';
        setTimeout(() => {
            if (syncSource === 'content') syncSource = null;
        }, 650);
    });
}

/**
 * Интеграция слайдер
 */
function initIntegrationSlider() {
    const section = document.querySelector('.integration');
    if (!section) return;

    const sliderEl = section.querySelector('.integration__slider-inner');
    const prevEl = section.querySelector('.integration__arrow-prew');
    const nextEl = section.querySelector('.integration__arrow-next');
    const paginationEl = section.querySelector('.integration__slider-dots');

    if (!sliderEl || !prevEl || !nextEl || !paginationEl) return;

    const integrationSwiper = new Swiper(sliderEl, {
        slidesPerView: 1,
        spaceBetween: 32,
        loop: true,
        speed: 600,
        watchOverflow: true,
        navigation: { prevEl, nextEl },
        pagination: { el: paginationEl, clickable: true }
    });

    window.addEventListener('resize', () => {
        integrationSwiper.update();
    });
}

/**
 * Uptime gauge анимация
 */
function initUptimeGauge() {
    const gauges = document.querySelectorAll('.uptime-gauge');
    if (!gauges.length) return;

    gauges.forEach((gauge) => {
        const path = gauge.querySelector('.uptime-gauge__path');
        const ticksGroup = gauge.querySelector('.uptime-gauge__ticks');
        const thumb = gauge.querySelector('.uptime-gauge__thumb');
        const valueEl = gauge.querySelector('.uptime-gauge__value');

        if (!path || !ticksGroup || !thumb || !valueEl) return;

        const targetValue = Math.max(0, Math.min(99.9, parseFloat(gauge.dataset.value || '99.9')));
        const duration = parseInt(gauge.dataset.duration || '2200', 10);

        const totalLength = path.getTotalLength();
        const tickCount = 90;
        const tickLength = 18;
        const targetProgress = targetValue / 100;
        const thumbOffset = -10;

        ticksGroup.innerHTML = '';

        for (let i = 0; i <= tickCount; i++) {
            const progress = i / tickCount;
            const lengthAtPoint = totalLength * progress;
            const point = path.getPointAtLength(lengthAtPoint);

            const prevPoint = path.getPointAtLength(Math.max(0, lengthAtPoint - 1));
            const nextPoint = path.getPointAtLength(Math.min(totalLength, lengthAtPoint + 1));

            const angle = Math.atan2(nextPoint.y - prevPoint.y, nextPoint.x - prevPoint.x);
            const normalAngle = angle - Math.PI / 2;

            const x1 = point.x + Math.cos(normalAngle) * 2;
            const y1 = point.y + Math.sin(normalAngle) * 2;
            const x2 = point.x + Math.cos(normalAngle) * (2 + tickLength);
            const y2 = point.y + Math.sin(normalAngle) * (2 + tickLength);

            const tick = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            tick.setAttribute('x1', x1);
            tick.setAttribute('y1', y1);
            tick.setAttribute('x2', x2);
            tick.setAttribute('y2', y2);
            tick.setAttribute('class', 'uptime-gauge__tick');
            ticksGroup.appendChild(tick);
        }

        const startLength = 0;
        const startPoint = path.getPointAtLength(startLength);
        const startPrevPoint = path.getPointAtLength(Math.max(0, startLength - 1));
        const startNextPoint = path.getPointAtLength(Math.min(totalLength, startLength + 1));

        const startAngle = Math.atan2(startNextPoint.y - startPrevPoint.y, startNextPoint.x - startPrevPoint.x);
        const startNormalAngle = startAngle + Math.PI / 2;

        const startThumbX = startPoint.x + Math.cos(startNormalAngle) * thumbOffset;
        const startThumbY = startPoint.y + Math.sin(startNormalAngle) * thumbOffset;

        thumb.setAttribute('transform', `translate(${startThumbX}, ${startThumbY})`);
        valueEl.textContent = '0.0%';
        thumb.style.opacity = '0.8';

        function render(progress) {
            const clampedProgress = Math.max(0, Math.min(targetProgress, progress));
            const currentValue = clampedProgress * 100;
            const currentLength = totalLength * clampedProgress;

            valueEl.textContent = `${currentValue.toFixed(1)}%`;

            const point = path.getPointAtLength(currentLength);
            const prevPoint = path.getPointAtLength(Math.max(0, currentLength - 1));
            const nextPoint = path.getPointAtLength(Math.min(totalLength, currentLength + 1));

            const angle = Math.atan2(nextPoint.y - prevPoint.y, nextPoint.x - prevPoint.x);
            const normalAngle = angle + Math.PI / 2;

            const thumbX = point.x + Math.cos(normalAngle) * thumbOffset;
            const thumbY = point.y + Math.sin(normalAngle) * thumbOffset;

            thumb.setAttribute('transform', `translate(${thumbX}, ${thumbY})`);

            const ticks = ticksGroup.querySelectorAll('.uptime-gauge__tick');
            ticks.forEach((tick, index) => {
                const tickProgress = index / tickCount;
                tick.classList.toggle('uptime-gauge__tick--active', tickProgress <= clampedProgress);
            });
        }

        function animate() {
            const start = performance.now();

            function frame(now) {
                const t = Math.min(1, (now - start) / duration);
                const eased = 1 - Math.pow(1 - t, 3);
                render(targetProgress * eased);
                if (t < 1) {
                    requestAnimationFrame(frame);
                } else {
                    render(targetProgress);
                }
            }
            requestAnimationFrame(frame);
        }

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                animate();
                obs.unobserve(entry.target);
            });
        }, { threshold: 0.35 });

        observer.observe(gauge);
    });
}

/**
 * Безопасность слайдер
 */
function initSecuritySlider() {
    const section = document.querySelector('.security');
    if (!section) return;

    const sliderEl = section.querySelector('.security__slider-inner');
    const prevEl = section.querySelector('.security__arrow--prev');
    const nextEl = section.querySelector('.security__arrow--next');

    if (!sliderEl || !prevEl || !nextEl) return;

    const securitySwiper = new Swiper(sliderEl, {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        speed: 600,
        watchOverflow: true,
        allowTouchMove: true,
        autoHeight: false,
        navigation: { prevEl, nextEl },
        on: {
            init(swiper) { updateArrows(swiper); },
            slideChange(swiper) { updateArrows(swiper); }
        }
    });

    function updateArrows(swiper) {
        const lastIndex = swiper.slides.length - swiper.loopedSlides * 2 - 1;
        prevEl.classList.toggle('security__arrow--disabled', swiper.realIndex === 0);
        nextEl.classList.toggle('security__arrow--disabled', swiper.realIndex === lastIndex);
    }

    window.addEventListener('resize', () => {
        securitySwiper.update();
    });
}

/**
 * FAQ аккордеон
 */
function initFaq() {
    const faqItems = document.querySelectorAll('.faq__item');
    if (!faqItems.length) return;

    function getOpenHeight(item) {
        const answer = item.querySelector('.faq__item-answer');
        const content = item.querySelector('.faq__item-answer-text');
        if (!answer || !content) return 0;

        const styles = getComputedStyle(answer);
        const paddingTop = parseFloat(styles.paddingTop) || 0;
        const paddingBottom = parseFloat(styles.paddingBottom) || 0;
        const borderTop = parseFloat(styles.borderTopWidth) || 0;

        const extra = window.innerWidth < 768 ? 32 : 48;

        return content.scrollHeight + paddingTop + paddingBottom + borderTop + extra;
    }

    function closeItem(item) {
        const answer = item.querySelector('.faq__item-answer');
        if (!answer) return;

        answer.style.height = `${answer.offsetHeight}px`;

        requestAnimationFrame(() => {
            item.classList.remove('faq__item--open');
            answer.style.height = '0px';
        });
    }

    function openItem(item) {
        const answer = item.querySelector('.faq__item-answer');
        if (!answer) return;

        item.classList.add('faq__item--open');

        requestAnimationFrame(() => {
            answer.style.height = `${getOpenHeight(item)}px`;
        });
    }

    faqItems.forEach((item) => {
        const question = item.querySelector('.faq__item-question');
        const answer = item.querySelector('.faq__item-answer');

        if (!question || !answer) return;

        answer.style.height = '0px';
        answer.style.overflow = 'hidden';

        question.addEventListener('click', () => {
            const isOpen = item.classList.contains('faq__item--open');

            faqItems.forEach((otherItem) => {
                if (otherItem !== item) {
                    closeItem(otherItem);
                }
            });

            if (isOpen) {
                closeItem(item);
            } else {
                openItem(item);
            }
        });
    });

    window.addEventListener('resize', () => {
        faqItems.forEach((item) => {
            const answer = item.querySelector('.faq__item-answer');
            if (!answer) return;

            if (item.classList.contains('faq__item--open')) {
                answer.style.height = `${getOpenHeight(item)}px`;
            } else {
                answer.style.height = '0px';
            }
        });
    });
}


/**
 * Hero Canvas анимация по скроллу
 */

// Версия с запуском по первому скроллу (неравномерная смена кадров, в конце медленнее)
// function initHeroCanvasAnimation() {
//     const TOTAL_FRAMES = 38;
//     const FRAME_BASE_URL = "https://nvglobal.webdp.ru/wp-content/themes/nvglobal/animation/video1/main_bg2_";
//     const EXT = ".jpg";

//     const canvas = document.getElementById('heroCanvas');
//     const ctx = canvas ? canvas.getContext('2d') : null;
//     const heroWrapper = document.querySelector('.hero__wrapper');
//     const heroGradient = document.querySelector('.hero_gradient');
//     const heroSection = document.querySelector('.hero');

//     if (!canvas || !ctx || !heroWrapper || !heroGradient || !heroSection) {
//         console.error('Hero Canvas: не найдены необходимые DOM элементы');
//         return;
//     }

//     let frames = [];
//     let loadedCount = 0;
//     let allFramesLoaded = false;
//     let currentFrameIndex = 0;
//     let isAnimating = false;
//     let animationCompleted = false;
//     let animationProgress = 0;
//     let animationId = null;

//     // Блокировка скролла
//     function lockScroll() {
//         const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
//         document.body.style.overflow = 'hidden';
//         if (scrollbarWidth > 0) {
//             document.body.style.paddingRight = `${scrollbarWidth}px`;
//         }
//     }

//     // Разблокировка скролла
//     function unlockScroll() {
//         document.body.style.overflow = '';
//         document.body.style.paddingRight = '';
//     }

//     function updateLoadingStatus() {
//         if (loadedCount === TOTAL_FRAMES) {
//             console.log('Hero Canvas: все кадры загружены');
//         }
//     }

//     function preloadFrames() {
//         const loadPromises = [];

//         for (let i = 0; i < TOTAL_FRAMES; i++) {
//             const idx = i.toString().padStart(3, '0');
//             const url = `${FRAME_BASE_URL}${idx}${EXT}`;
//             const img = new Image();

//             const promise = new Promise((resolve) => {
//                 img.onload = () => {
//                     loadedCount++;
//                     updateLoadingStatus();
//                     resolve(img);
//                 };
//                 img.onerror = () => {
//                     console.warn(`Hero Canvas: не удалось загрузить кадр ${idx}`);
//                     const fallbackCanvas = document.createElement('canvas');
//                     fallbackCanvas.width = 1920;
//                     fallbackCanvas.height = 1080;
//                     const fallbackCtx = fallbackCanvas.getContext('2d');
//                     fallbackCtx.fillStyle = '#000';
//                     fallbackCtx.fillRect(0, 0, 1920, 1080);
//                     resolve(fallbackCanvas);
//                     loadedCount++;
//                     updateLoadingStatus();
//                 };
//                 img.src = url;
//             });

//             loadPromises.push(promise);
//         }

//         return Promise.all(loadPromises).then(images => {
//             frames = images;
//             allFramesLoaded = true;
//             drawFrame(0);
//         });
//     }

//     function drawFrame(index) {
//         if (!ctx || !canvas || frames.length === 0) return;

//         const frame = frames[index];
//         if (!frame) return;

//         const canvasWidth = canvas.clientWidth;
//         const canvasHeight = canvas.clientHeight;

//         if (canvas.width !== canvasWidth || canvas.height !== canvasHeight) {
//             canvas.width = canvasWidth;
//             canvas.height = canvasHeight;
//         }

//         ctx.clearRect(0, 0, canvas.width, canvas.height);

//         const imgRatio = frame.width / frame.height;
//         const canvasRatio = canvas.width / canvas.height;

//         let drawWidth, drawHeight, offsetX = 0, offsetY = 0;

//         if (canvasRatio > imgRatio) {
//             drawWidth = canvas.width;
//             drawHeight = canvas.width / imgRatio;
//             offsetY = (canvas.height - drawHeight) / 2;
//         } else {
//             drawHeight = canvas.height;
//             drawWidth = canvas.height * imgRatio;
//             offsetX = (canvas.width - drawWidth) / 2;
//         }

//         ctx.drawImage(frame, offsetX, offsetY, drawWidth, drawHeight);
//     }

//     function updateAnimation(progress) {
//         const frameIndex = Math.floor(progress * (TOTAL_FRAMES - 1));
//         currentFrameIndex = Math.min(TOTAL_FRAMES - 1, Math.max(0, frameIndex));
//         drawFrame(currentFrameIndex);

//         const translateX = -progress * 500;
//         const opacity = 1 - progress;
        
//         heroWrapper.style.transform = `translateX(${translateX}px)`;
//         heroWrapper.style.opacity = opacity;
//         heroGradient.style.transform = `translateX(${translateX}px)`;
//         heroGradient.style.opacity = opacity;
//     }

//     function animateForward() {
//         const startTime = performance.now();
//         const startProgress = animationProgress;
//         const endProgress = 1;
//         const duration = 2500;

//         function animate(currentTime) {
//             const elapsed = currentTime - startTime;
//             let t = Math.min(1, elapsed / duration);
//             const easeProgress = 1 - Math.pow(1 - t, 3);
            
//             animationProgress = startProgress + (endProgress - startProgress) * easeProgress;
//             updateAnimation(animationProgress);

//             if (t < 1) {
//                 animationId = requestAnimationFrame(animate);
//             } else {
//                 animationProgress = 1;
//                 updateAnimation(1);
//                 isAnimating = false;
//                 animationCompleted = true;
//                 unlockScroll();
//                 animationId = null;
//                 console.log('Hero Canvas: анимация вперед завершена');
//             }
//         }

//         animationId = requestAnimationFrame(animate);
//     }

//     function animateBackward() {
//         const startTime = performance.now();
//         const startProgress = animationProgress;
//         const endProgress = 0;
//         const duration = 2500;

//         function animate(currentTime) {
//             const elapsed = currentTime - startTime;
//             let t = Math.min(1, elapsed / duration);
//             const easeProgress = 1 - Math.pow(1 - t, 3);
            
//             animationProgress = startProgress - (startProgress - endProgress) * easeProgress;
//             updateAnimation(animationProgress);

//             if (t < 1) {
//                 animationId = requestAnimationFrame(animate);
//             } else {
//                 animationProgress = 0;
//                 updateAnimation(0);
//                 isAnimating = false;
//                 animationCompleted = false;
//                 unlockScroll();
//                 animationId = null;
//                 console.log('Hero Canvas: анимация назад завершена');
//             }
//         }

//         animationId = requestAnimationFrame(animate);
//     }

//     function onWheel(e) {
//         if (!allFramesLoaded) return;
        
//         const isScrollingDown = e.deltaY > 0;
        
//         if (isAnimating) {
//             e.preventDefault();
//             return;
//         }
        
//         // Скролл вниз - запускаем прямую анимацию
//         if (isScrollingDown && !animationCompleted) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateForward();
//         }
//         // Скролл вверх - только если анимация завершена и мы в самом верху
//         else if (!isScrollingDown && animationCompleted && window.scrollY <= 0) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateBackward();
//         }
//         // В остальных случаях - стандартный скролл (ничего не блокируем)
//     }

//     let touchStartY = 0;
    
//     function onTouchStart(e) {
//         touchStartY = e.touches[0].clientY;
//     }
    
//     function onTouchMove(e) {
//         if (!allFramesLoaded) return;
        
//         const touchEndY = e.touches[0].clientY;
//         const deltaY = touchStartY - touchEndY;
//         const isScrollingDown = deltaY > 0;
        
//         if (isAnimating) {
//             e.preventDefault();
//             return;
//         }
        
//         if (isScrollingDown && !animationCompleted) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateForward();
//         }
//         else if (!isScrollingDown && animationCompleted && window.scrollY <= 0) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateBackward();
//         }
//         // В остальных случаях - стандартный скролл
//     }

//     function initAnimation() {
//         if (!allFramesLoaded) return;
        
//         updateAnimation(0);
        
//         window.addEventListener('wheel', onWheel, { passive: false });
//         window.addEventListener('touchstart', onTouchStart, { passive: false });
//         window.addEventListener('touchmove', onTouchMove, { passive: false });
        
//         console.log('Hero Canvas: анимация инициализирована');
//     }

//     heroWrapper.style.opacity = '1';
//     heroWrapper.style.transform = 'translateX(0)';
//     heroWrapper.style.transition = 'none';
//     heroGradient.style.opacity = '1';
//     heroGradient.style.transform = 'translateX(0)';
//     heroGradient.style.transition = 'none';

//     const style = document.createElement('style');
//     style.textContent = `
//         .hero {
//             position: relative;
//             z-index: 1;
//         }
//         .hero__wrapper, .hero_gradient {
//             will-change: transform, opacity;
//         }
//         body {
//             overflow-anchor: none;
//         }
//         html {
//             overflow-x: hidden;
//         }
//     `;
//     document.head.appendChild(style);

//     preloadFrames().then(() => {
//         initAnimation();
//     }).catch(error => {
//         console.error('Hero Canvas: ошибка загрузки кадров:', error);
//     });
// }


// Равномерная смена кадров (анимация вперёд и назад)
// function initHeroCanvasAnimation() {
//     const TOTAL_FRAMES = 38;
//     const FRAME_BASE_URL = "https://nvglobal.webdp.ru/wp-content/themes/nvglobal/animation/video1/main_bg2_";
//     const EXT = ".jpg";

//     const canvas = document.getElementById('heroCanvas');
//     const ctx = canvas ? canvas.getContext('2d') : null;
//     const heroWrapper = document.querySelector('.hero__wrapper');
//     const heroGradient = document.querySelector('.hero_gradient');
//     const heroSection = document.querySelector('.hero');

//     if (!canvas || !ctx || !heroWrapper || !heroGradient || !heroSection) {
//         console.error('Hero Canvas: не найдены необходимые DOM элементы');
//         return;
//     }

//     let frames = [];
//     let loadedCount = 0;
//     let allFramesLoaded = false;
//     let currentFrameIndex = 0;
//     let isAnimating = false;
//     let animationCompleted = false;
//     let animationProgress = 0;
//     let animationId = null;

//     // Блокировка скролла
//     function lockScroll() {
//         const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
//         document.body.style.overflow = 'hidden';
//         if (scrollbarWidth > 0) {
//             document.body.style.paddingRight = `${scrollbarWidth}px`;
//         }
//     }

//     // Разблокировка скролла
//     function unlockScroll() {
//         document.body.style.overflow = '';
//         document.body.style.paddingRight = '';
//     }

//     function updateLoadingStatus() {
//         if (loadedCount === TOTAL_FRAMES) {
//             console.log('Hero Canvas: все кадры загружены');
//         }
//     }

//     function preloadFrames() {
//         const loadPromises = [];

//         for (let i = 0; i < TOTAL_FRAMES; i++) {
//             const idx = i.toString().padStart(3, '0');
//             const url = `${FRAME_BASE_URL}${idx}${EXT}`;
//             const img = new Image();

//             const promise = new Promise((resolve) => {
//                 img.onload = () => {
//                     loadedCount++;
//                     updateLoadingStatus();
//                     resolve(img);
//                 };
//                 img.onerror = () => {
//                     console.warn(`Hero Canvas: не удалось загрузить кадр ${idx}`);
//                     const fallbackCanvas = document.createElement('canvas');
//                     fallbackCanvas.width = 1920;
//                     fallbackCanvas.height = 1080;
//                     const fallbackCtx = fallbackCanvas.getContext('2d');
//                     fallbackCtx.fillStyle = '#000';
//                     fallbackCtx.fillRect(0, 0, 1920, 1080);
//                     resolve(fallbackCanvas);
//                     loadedCount++;
//                     updateLoadingStatus();
//                 };
//                 img.src = url;
//             });

//             loadPromises.push(promise);
//         }

//         return Promise.all(loadPromises).then(images => {
//             frames = images;
//             allFramesLoaded = true;
//             drawFrame(0);
//         });
//     }

//     function drawFrame(index) {
//         if (!ctx || !canvas || frames.length === 0) return;

//         const frame = frames[index];
//         if (!frame) return;

//         const canvasWidth = canvas.clientWidth;
//         const canvasHeight = canvas.clientHeight;

//         if (canvas.width !== canvasWidth || canvas.height !== canvasHeight) {
//             canvas.width = canvasWidth;
//             canvas.height = canvasHeight;
//         }

//         ctx.clearRect(0, 0, canvas.width, canvas.height);

//         const imgRatio = frame.width / frame.height;
//         const canvasRatio = canvas.width / canvas.height;

//         let drawWidth, drawHeight, offsetX = 0, offsetY = 0;

//         if (canvasRatio > imgRatio) {
//             drawWidth = canvas.width;
//             drawHeight = canvas.width / imgRatio;
//             offsetY = (canvas.height - drawHeight) / 2;
//         } else {
//             drawHeight = canvas.height;
//             drawWidth = canvas.height * imgRatio;
//             offsetX = (canvas.width - drawWidth) / 2;
//         }

//         ctx.drawImage(frame, offsetX, offsetY, drawWidth, drawHeight);
//     }

//     function updateAnimation(progress) {
//         const frameIndex = Math.floor(progress * (TOTAL_FRAMES - 1));
//         currentFrameIndex = Math.min(TOTAL_FRAMES - 1, Math.max(0, frameIndex));
//         drawFrame(currentFrameIndex);

//         const translateX = -progress * 500;
//         const opacity = 1 - progress;
        
//         heroWrapper.style.transform = `translateX(${translateX}px)`;
//         heroWrapper.style.opacity = opacity;
//         heroGradient.style.transform = `translateX(${translateX}px)`;
//         heroGradient.style.opacity = opacity;
//     }

//     function animateForward() {
//         const startTime = performance.now();
//         const startProgress = animationProgress;
//         const endProgress = 1;
//         const duration = 1800;

//         function animate(currentTime) {
//             const elapsed = currentTime - startTime;
//             let t = Math.min(1, elapsed / duration);
//             // ЛИНЕЙНАЯ интерполяция (равномерная смена кадров)
//             const linearProgress = t;
            
//             animationProgress = startProgress + (endProgress - startProgress) * linearProgress;
//             updateAnimation(animationProgress);

//             if (t < 1) {
//                 animationId = requestAnimationFrame(animate);
//             } else {
//                 animationProgress = 1;
//                 updateAnimation(1);
//                 isAnimating = false;
//                 animationCompleted = true;
//                 unlockScroll();
//                 animationId = null;
//                 console.log('Hero Canvas: анимация вперед завершена');
//             }
//         }

//         animationId = requestAnimationFrame(animate);
//     }

//     function animateBackward() {
//         const startTime = performance.now();
//         const startProgress = animationProgress;
//         const endProgress = 0;
//         const duration = 1800;

//         function animate(currentTime) {
//             const elapsed = currentTime - startTime;
//             let t = Math.min(1, elapsed / duration);
//             // ЛИНЕЙНАЯ интерполяция (равномерная смена кадров)
//             const linearProgress = t;
            
//             animationProgress = startProgress - (startProgress - endProgress) * linearProgress;
//             updateAnimation(animationProgress);

//             if (t < 1) {
//                 animationId = requestAnimationFrame(animate);
//             } else {
//                 animationProgress = 0;
//                 updateAnimation(0);
//                 isAnimating = false;
//                 animationCompleted = false;
//                 unlockScroll();
//                 animationId = null;
//                 console.log('Hero Canvas: анимация назад завершена');
//             }
//         }

//         animationId = requestAnimationFrame(animate);
//     }

//     function onWheel(e) {
//         if (!allFramesLoaded) return;
        
//         const isScrollingDown = e.deltaY > 0;
        
//         if (isAnimating) {
//             e.preventDefault();
//             return;
//         }
        
//         // Скролл вниз - запускаем прямую анимацию
//         if (isScrollingDown && !animationCompleted) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateForward();
//         }
//         // Скролл вверх - только если анимация завершена и мы в самом верху
//         else if (!isScrollingDown && animationCompleted && window.scrollY <= 0) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateBackward();
//         }
//         // В остальных случаях - стандартный скролл (ничего не блокируем)
//     }

//     let touchStartY = 0;
    
//     function onTouchStart(e) {
//         touchStartY = e.touches[0].clientY;
//     }
    
//     function onTouchMove(e) {
//         if (!allFramesLoaded) return;
        
//         const touchEndY = e.touches[0].clientY;
//         const deltaY = touchStartY - touchEndY;
//         const isScrollingDown = deltaY > 0;
        
//         if (isAnimating) {
//             e.preventDefault();
//             return;
//         }
        
//         if (isScrollingDown && !animationCompleted) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateForward();
//         }
//         else if (!isScrollingDown && animationCompleted && window.scrollY <= 0) {
//             e.preventDefault();
//             isAnimating = true;
//             lockScroll();
//             animateBackward();
//         }
//         // В остальных случаях - стандартный скролл
//     }

//     function initAnimation() {
//         if (!allFramesLoaded) return;
        
//         updateAnimation(0);
        
//         window.addEventListener('wheel', onWheel, { passive: false });
//         window.addEventListener('touchstart', onTouchStart, { passive: false });
//         window.addEventListener('touchmove', onTouchMove, { passive: false });
        
//         console.log('Hero Canvas: анимация инициализирована (линейная)');
//     }

//     heroWrapper.style.opacity = '1';
//     heroWrapper.style.transform = 'translateX(0)';
//     heroWrapper.style.transition = 'none';
//     heroGradient.style.opacity = '1';
//     heroGradient.style.transform = 'translateX(0)';
//     heroGradient.style.transition = 'none';

//     const style = document.createElement('style');
//     style.textContent = `
//         .hero {
//             position: relative;
//             z-index: 1;
//         }
//         .hero__wrapper, .hero_gradient {
//             will-change: transform, opacity;
//         }
//         body {
//             overflow-anchor: none;
//         }
//         html {
//             overflow-x: hidden;
//         }
//     `;
//     document.head.appendChild(style);

//     preloadFrames().then(() => {
//         initAnimation();
//     }).catch(error => {
//         console.error('Hero Canvas: ошибка загрузки кадров:', error);
//     });
// }















/**
 * Плавная прокрутка по якорям
 */
function initSmoothAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);

            if (!target) return;

            e.preventDefault();

            const offset = parseInt(target.dataset.offset) || 56;

            const top = target.getBoundingClientRect().top + window.pageYOffset - offset;

            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        });
    });
}

/**
 * Анимация маскота в футере
 */
// function initMaskotAnimation() {
//     const maskot = document.querySelector(".teaser__maskot");
//     if (!maskot) return;

//     const head = maskot.querySelector(".teaser__maskot-head");
//     const hand = maskot.querySelector(".teaser__maskot-hand");

//     if (!head || !hand) return;

//     let hasAnimated = false;
//     let isCurrentlyAnimated = false;
//     const OFFSET = 350;

//     function checkAndAnimate() {
//         const rect = maskot.getBoundingClientRect();
//         const windowHeight = window.innerHeight;
//         const isAtPosition = rect.top <= windowHeight - OFFSET;
        
//         // Запуск анимации
//         if (isAtPosition && !hasAnimated) {
//             hasAnimated = true;
//             isCurrentlyAnimated = true;
            
//             head.classList.add("animate");
//             setTimeout(() => {
//                 hand.classList.add("animate");
//             }, 300);

//             const setZIndex = () => {
//                 //maskot.style.zIndex = "7";
//             };

//             hand.addEventListener("animationend", setZIndex, { once: true });
//             hand.addEventListener("transitionend", setZIndex, { once: true });
//         }
        
//         // Сброс анимации (когда уехал вверх)
//         if (!isAtPosition && isCurrentlyAnimated) {
//             isCurrentlyAnimated = false;
//             hasAnimated = false;  // Разрешаем запуск снова
//             head.classList.remove("animate");
//             hand.classList.remove("animate");
//             maskot.style.zIndex = "";
//         }
//     }

//     window.addEventListener('scroll', checkAndAnimate);
//     window.addEventListener('resize', checkAndAnimate);
//     checkAndAnimate();
// }
function initMaskotAnimation() {
    const maskots = document.querySelectorAll(".teaser__maskot");
    if (!maskots.length) return;

    const OFFSET = 350;

    maskots.forEach((maskot) => {
        const head = maskot.querySelector(".teaser__maskot-head");
        const hand = maskot.querySelector(".teaser__maskot-hand");

        if (!head || !hand) return;

        let hasAnimated = false;
        let isCurrentlyAnimated = false;

        function checkAndAnimate() {
            const rect = maskot.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            const isAtPosition = rect.top <= windowHeight - OFFSET;

            // Запуск
            if (isAtPosition && !hasAnimated) {
                hasAnimated = true;
                isCurrentlyAnimated = true;

                head.classList.add("animate");

                setTimeout(() => {
                    hand.classList.add("animate");
                }, 300);

                const setZIndex = () => {
                    // maskot.style.zIndex = "7";
                };

                hand.addEventListener("animationend", setZIndex, { once: true });
                hand.addEventListener("transitionend", setZIndex, { once: true });
            }

            // Сброс
            if (!isAtPosition && isCurrentlyAnimated) {
                isCurrentlyAnimated = false;
                hasAnimated = false;

                head.classList.remove("animate");
                hand.classList.remove("animate");
                maskot.style.zIndex = "";
            }
        }

        window.addEventListener('scroll', checkAndAnimate);
        window.addEventListener('resize', checkAndAnimate);

        checkAndAnimate();
    });
}


/**
 * Закрепленное меню page-nav
 */
// function initPageNavSticky() {
//     const pageNav = document.querySelector('.page-nav');
//     if (!pageNav) return;

//     let offsetTop = 0;

//     function updateOffset() {
//         const rect = pageNav.getBoundingClientRect();
//         offsetTop = rect.top + window.scrollY;
//     }

//     function checkPosition() {
//         if (window.scrollY >= offsetTop) {
//             pageNav.classList.add('page-nav--fixed');
//         } else {
//             pageNav.classList.remove('page-nav--fixed');
//         }
//     }

//     function refresh() {
//         const wasFixed = pageNav.classList.contains('page-nav--fixed');

//         if (wasFixed) {
//             pageNav.classList.remove('page-nav--fixed');
//         }

//         updateOffset();
//         checkPosition();
//     }

//     updateOffset();
//     checkPosition();

//     window.addEventListener('scroll', checkPosition);
//     window.addEventListener('resize', refresh);
//     window.addEventListener('orientationchange', refresh);
// }


/**
 * Закрепленное меню page-nav
 */
// function initPageNavSticky() {
//     const pageNav = document.querySelector('.page-nav');
//     if (!pageNav) return;

//     let offsetTop = 0;

//     function updateOffset() {
//         const rect = pageNav.getBoundingClientRect();
//         offsetTop = rect.top + window.scrollY;
//     }

//     function checkPosition() {
//         if (window.scrollY >= offsetTop) {
//             pageNav.classList.add('page-nav--fixed');
//         } else {
//             pageNav.classList.remove('page-nav--fixed');
//         }
//     }

//     function refresh() {
//         const wasFixed = pageNav.classList.contains('page-nav--fixed');

//         if (wasFixed) {
//             pageNav.classList.remove('page-nav--fixed');
//         }

//         updateOffset();
//         checkPosition();
//     }

//     updateOffset();
//     checkPosition();

//     window.addEventListener('scroll', checkPosition);
//     window.addEventListener('resize', refresh);
//     window.addEventListener('orientationchange', refresh);
// }



/**
 * Открытие мобильного меню page-nav выпадающим списком
 */
function initPageNavMobile() {
    const nav = document.querySelector('.page-nav');
    const wrapper = nav?.querySelector('.page-nav__wrapper');

    if (!nav || !wrapper) return;

    // Проверяем, существует ли уже кнопка toggle, чтобы не создавать дубликат
    if (nav.querySelector('.page-nav__toggle')) return;

    // Создаем кнопку
    const toggle = document.createElement('div');
    toggle.className = 'page-nav__toggle';
    toggle.innerHTML = `
        <span class="page-nav__toggle-text">About</span>
        <div class="page-nav__toggle-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M15.3313 6.71213C15.5194 6.45753 15.8733 6.38147 16.1516 6.54612C16.4486 6.72192 16.5471 7.10523 16.3714 7.40224V7.40305H16.3705V7.40386C16.37 7.40477 16.3691 7.40634 16.3681 7.40793C16.3662 7.41115 16.3635 7.41586 16.36 7.42177C16.3529 7.43363 16.3424 7.4509 16.329 7.47304C16.302 7.51765 16.2619 7.58241 16.211 7.66428C16.1094 7.82798 15.9621 8.06088 15.7781 8.33974C15.4108 8.89632 14.894 9.64169 14.2986 10.3897C13.706 11.1342 13.02 11.901 12.3146 12.4869C11.633 13.0529 10.8252 13.5424 10.0001 13.5424C9.17513 13.5424 8.36718 13.0529 7.68565 12.4869C6.98028 11.901 6.29507 11.1342 5.70242 10.3897C5.10687 9.64159 4.58956 8.89638 4.22211 8.33974C4.03804 8.06089 3.89086 7.82797 3.78917 7.66428C3.73833 7.58244 3.69818 7.51763 3.67117 7.47304C3.65778 7.45093 3.64734 7.43362 3.64024 7.42177C3.63672 7.41588 3.63401 7.41114 3.6321 7.40793C3.63117 7.40637 3.6302 7.40476 3.62966 7.40386V7.40305H3.62885V7.40224C3.45317 7.10526 3.55165 6.72194 3.84858 6.54612C4.1269 6.38148 4.48078 6.45752 4.66889 6.71213L4.70632 6.76829C4.70772 6.77064 4.70983 6.77466 4.71283 6.77968C4.71891 6.78982 4.72814 6.80565 4.7405 6.82607C4.76524 6.8669 4.80219 6.92756 4.85037 7.0051C4.94686 7.16042 5.08848 7.38325 5.26541 7.65126C5.61994 8.18833 6.11529 8.90157 6.68061 9.61171C7.24874 10.3253 7.87275 11.0172 8.48399 11.525C9.11924 12.0526 9.63555 12.2924 10.0001 12.2924C10.3649 12.2924 10.881 12.0526 11.5162 11.525C12.1276 11.0171 12.7522 10.3255 13.3204 9.61171C13.8857 8.90159 14.3803 8.18833 14.7348 7.65126C14.9117 7.38324 15.0534 7.16042 15.1498 7.0051C15.198 6.92754 15.235 6.8669 15.2597 6.82607C15.2721 6.80565 15.2813 6.78982 15.2874 6.77968C15.2904 6.77468 15.2925 6.77063 15.2939 6.76829L15.3313 6.71213Z" fill="#FBFBFB"/>
            </svg>
        </div>
    `;

    wrapper.prepend(toggle);

    // Открытие/закрытие меню
    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        nav.classList.toggle('page-nav--open');
    });

    // Закрытие при клике на пункт меню
    const menuLinks = document.querySelectorAll('.page-nav__menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('page-nav--open');
            const toggleText = toggle.querySelector('.page-nav__toggle-text');
            if (toggleText) {
                toggleText.textContent = link.textContent;
            }
        });
    });

    // Закрытие при клике вне меню
    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target) && !toggle.contains(e.target)) {
            nav.classList.remove('page-nav--open');
        }
    });
}

/**
 * Активация пунктов меню page-nav при пролистывании
 */
function initPageNavActive() {
    const links = document.querySelectorAll('.page-nav__menu-link');
    const toggleText = document.querySelector('.page-nav__toggle-text');
    const pageNav = document.querySelector('.page-nav');
    const sections = [];

    if (!links.length) return;

    // Собираем секции
    links.forEach(link => {
        const id = link.getAttribute('href');
        if (id && id !== '#') {
            const section = document.querySelector(id);
            if (section) {
                sections.push({
                    id,
                    section,
                    link,
                    item: link.closest('.page-nav__menu-item')
                });
            }
        }
    });

    if (!sections.length) return;

    function onScroll() {
        const navHeight = pageNav?.offsetHeight || 0;
        const scrollPos = window.scrollY + navHeight + 10;

        let current = null;

        sections.forEach(sec => {
            const sectionTop = sec.section.offsetTop;
            const sectionBottom = sectionTop + sec.section.offsetHeight;
            
            if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                current = sec;
            }
        });

        // Сброс active у всех
        sections.forEach(sec => {
            sec.item.classList.remove('page-nav__menu-item--active');
        });

        if (current) {
            current.item.classList.add('page-nav__menu-item--active');

            // Обновляем текст ТОЛЬКО на мобилке (до 576px)
            if (window.innerWidth < 576 && toggleText) {
                toggleText.textContent = current.link.textContent;
            }
        }
    }

    window.addEventListener('scroll', onScroll);
    window.addEventListener('resize', () => {
        if (window.innerWidth < 576 && toggleText && sections.length) {
            const activeItem = sections.find(sec => sec.item.classList.contains('page-nav__menu-item--active'));
            if (activeItem && toggleText) {
                toggleText.textContent = activeItem.link.textContent;
            }
        }
    });

    onScroll();
}

/**
 * Кнопка прокрутки страницы вверх (Top Widget)
 */
function initTopWidget() {
  const widget = document.querySelector('.top__widget');
  if (!widget) return;

  const widgetBtn = widget.querySelector('.top__widget-btn');
  const body = document.body;

  function toggleWidget() {
    if (window.scrollY >= 700) {
      widget.classList.add('top__widget--active');
      body.classList.add('body__widget--active');
    } else {
      widget.classList.remove('top__widget--active');
      body.classList.remove('body__widget--active');
    }
  }

  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }

  window.addEventListener('scroll', toggleWidget);

  if (widgetBtn) {
    widgetBtn.addEventListener('click', scrollToTop);
  }

  // Проверка при загрузке
  toggleWidget();
}







/**
 * Универсальная функция для анимации Lottie на кнопках
 * @param {string} buttonSelector - CSS селектор кнопок
 * @param {string} containerSelector - CSS селектор контейнера внутри кнопки
 * @param {string} animationPath - путь к JSON файлу анимации
 */
function initLottieAnimation(buttonSelector, containerSelector, animationPath) {
    const buttons = document.querySelectorAll(buttonSelector);
    
    if (!buttons.length) return;
    if (typeof lottie === 'undefined') return;
    
    buttons.forEach((button) => {
        const container = button.querySelector(containerSelector);
        if (!container) return;
        
        // Проверяем, не инициализирована ли уже анимация на этой кнопке
        if (container.hasAttribute('data-lottie-initialized')) return;
        container.setAttribute('data-lottie-initialized', 'true');
        
        // Сохраняем оригинальную иконку как fallback
        const originalIcon = container.innerHTML;
        
        // ОЧИЩАЕМ контейнер перед загрузкой анимации
        container.innerHTML = '';
        
        const animation = lottie.loadAnimation({
            container: container,
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: animationPath,
            rendererSettings: {
                preserveAspectRatio: 'xMidYMid meet',
                clearCanvas: true
            }
        });
        
        let ready = false;
        
        animation.addEventListener('DOMLoaded', () => {
            ready = true;
            animation.goToAndStop(0, true);
        });
        
        animation.addEventListener('error', () => {
            container.innerHTML = originalIcon;
        });
        
        button.addEventListener('mouseenter', () => {
            if (ready) {
                animation.goToAndStop(0, true);
                animation.play();
            }
        });
        
        button.addEventListener('mouseleave', () => {
            if (ready) {
                animation.stop();
                animation.goToAndStop(0, true);
            }
        });
    });
}

// Анимация появления для блоков
function initFadeUpAnimations() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const blocks = gsap.utils.toArray('.animate-fade-up');
    if (!blocks.length) return;

    blocks.forEach(section => {
        gsap.set(section, { y: 80, opacity: 0 });
    
        ScrollTrigger.create({
            trigger: section,
            start: "top 85%",
            end: "bottom 45%",
            onEnter: () => {
                gsap.to(section, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    ease: "power3.out"
                });
            },
            onLeaveBack: () => {
                gsap.to(section, {
                    y: 80,
                    opacity: 0,
                    duration: 0.8,
                    ease: "power3.inOut"
                });
            }
        });
    });
}


// ==================== ПЛАВНАЯ ПРОКРУТКА (SMOOTH SCROLL) ====================

function initSmoothScroll() {
    // Проверяем, загружена ли библиотека smoothscroll
    if (typeof smoothscroll !== 'undefined' && typeof smoothscroll.polyfill === 'function') {
        // Принудительное использование полифилла (опционально)
        window.__forceSmoothScrollPolyfill__ = true;
        // Активируем плавную прокрутку
        smoothscroll.polyfill();
        console.log('SmoothScroll: полифилл активирован');
    } else {
        //console.warn('SmoothScroll: библиотека не подключена или недоступна');
    }
    
    // Альтернатива: CSS-способ для современных браузеров
    if ('scrollBehavior' in document.documentElement.style) {
        document.documentElement.style.scrollBehavior = 'smooth';
        //console.log('SmoothScroll: CSS scroll-behavior активирован');
    }
}

//  Нормальный вариант анимации по скроллу, проблема только в том, что у всех разная скорость мыши (но меняется высота окна на мобилках, из-за этого прыгает)
// function initHeroCanvasAnimation() {
//     const TOTAL_FRAMES = 38;
//     const FRAME_BASE_URL = "/wp-content/themes/nvglobal/animation/video1/main_bg2_";
//     const EXT = ".jpg";

//     const canvas = document.getElementById('heroCanvas');
//     const ctx = canvas ? canvas.getContext('2d') : null;
//     const heroWrapper = document.querySelector('.hero__wrapper');
//     const heroGradient = document.querySelector('.hero_gradient');
//     const heroSection = document.querySelector('.hero');

//     if (!canvas || !ctx || !heroWrapper || !heroGradient || !heroSection) {
//         console.error('Hero Canvas: не найдены необходимые DOM элементы');
//         return;
//     }

//     let frames = [];
//     let loadedCount = 0;
//     let allFramesLoaded = false;
//     let currentFrameIndex = 0;

//     function updateLoadingStatus() {
//         if (loadedCount === TOTAL_FRAMES) {
//             console.log('Hero Canvas: все кадры загружены');
//         }
//     }

//     function preloadFrames() {
//         const loadPromises = [];

//         for (let i = 0; i < TOTAL_FRAMES; i++) {
//             const idx = i.toString().padStart(3, '0');
//             const url = `${FRAME_BASE_URL}${idx}${EXT}`;
//             const img = new Image();

//             const promise = new Promise((resolve) => {
//                 img.onload = () => {
//                     loadedCount++;
//                     updateLoadingStatus();
//                     resolve(img);
//                 };
//                 img.onerror = () => {
//                     console.warn(`Hero Canvas: не удалось загрузить кадр ${idx}`);
//                     const fallbackCanvas = document.createElement('canvas');
//                     fallbackCanvas.width = 1920;
//                     fallbackCanvas.height = 1080;
//                     const fallbackCtx = fallbackCanvas.getContext('2d');
//                     fallbackCtx.fillStyle = '#000';
//                     fallbackCtx.fillRect(0, 0, 1920, 1080);
//                     resolve(fallbackCanvas);
//                     loadedCount++;
//                     updateLoadingStatus();
//                 };
//                 img.src = url;
//             });

//             loadPromises.push(promise);
//         }

//         return Promise.all(loadPromises).then(images => {
//             frames = images;
//             allFramesLoaded = true;
//             drawFrame(0);
//         });
//     }

//     function drawFrame(index) {
//         if (!ctx || !canvas || frames.length === 0) return;
        
//         const frame = frames[index];
//         if (!frame) return;
    
//         // Берём размеры контейнера
//         const canvasWidth = canvas.clientWidth;
//         const canvasHeight = canvas.clientHeight;
    
//         // Устанавливаем внутренние размеры canvas под контейнер
//         if (canvas.width !== canvasWidth || canvas.height !== canvasHeight) {
//             canvas.width = canvasWidth;
//             canvas.height = canvasHeight;
//         }
    
//         ctx.clearRect(0, 0, canvas.width, canvas.height);
    
//         // Рисуем изображение с заполнением всего canvas, сохраняя пропорции (cover)
//         const imgRatio = frame.width / frame.height;
//         const canvasRatio = canvas.width / canvas.height;
    
//         let drawWidth, drawHeight, offsetX = 0, offsetY = 0;
    
//         if (canvasRatio > imgRatio) {
//             drawWidth = canvas.width;
//             drawHeight = canvas.width / imgRatio;
//             offsetY = (canvas.height - drawHeight) / 2;
//         } else {
//             drawHeight = canvas.height;
//             drawWidth = canvas.height * imgRatio;
//             offsetX = (canvas.width - drawWidth) / 2;
//         }
    
//         ctx.drawImage(frame, offsetX, offsetY, drawWidth, drawHeight);
//     }

//     function handleResize() {
//         if (canvas && frames.length > 0) {
//             drawFrame(currentFrameIndex);
//         }
//         if (window.ScrollTrigger) {
//             window.ScrollTrigger.refresh();
//         }
//     }

//     function initScrollAnimation() {
//         if (!allFramesLoaded) return;

//         if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
//             console.error('Hero Canvas: не загружены необходимые библиотеки GSAP или ScrollTrigger');
//             return;
//         }

//         gsap.registerPlugin(ScrollTrigger);

//         document.documentElement.classList.remove('has-scroll-smooth', 'has-scroll-init');

//         const heroHeight = heroSection.offsetHeight;
        
//         const timeline = gsap.timeline({
//             scrollTrigger: {
//                 trigger: heroSection,
//                 start: "top top",
//                 end: `+=${heroHeight * 1}`,
//                 scrub: 1.2,
//                 pin: heroSection,
//                 pinSpacing: true,
//                 anticipatePin: 1,
//                 invalidateOnRefresh: true,
//                 onUpdate: function(self) {
//                     const progress = self.progress;
//                     const frameIndex = Math.floor(progress * (TOTAL_FRAMES - 1));
//                     currentFrameIndex = Math.min(TOTAL_FRAMES - 1, Math.max(0, frameIndex));
//                     drawFrame(currentFrameIndex);
//                 }
//             }
//         });

//         timeline.fromTo(heroWrapper,
//             { x: 0, opacity: 1 },
//             { x: -500, opacity: 0, duration: 1, ease: "power2.out", immediateRender: false },
//             0
//         );

//         timeline.fromTo(heroGradient,
//             { x: 0, opacity: 1 },
//             { x: -500, opacity: 0, duration: 1, ease: "power2.out", immediateRender: false },
//             0
//         );

//         ScrollTrigger.refresh();
        
//         setTimeout(() => {
//             ScrollTrigger.refresh(true);
//         }, 100);

//         console.log('Hero Canvas: анимация инициализирована');
//     }

//     heroWrapper.style.opacity = '1';
//     heroWrapper.style.transform = 'translateX(0)';
//     heroGradient.style.opacity = '1';
//     heroGradient.style.transform = 'translateX(0)';

//     preloadFrames().then(() => {
//         initScrollAnimation();
//         ScrollTrigger.refresh(true);
//         initFadeUpAnimations();
//     }).catch(error => {
//         console.error('Hero Canvas: ошибка загрузки кадров:', error);
//     });

//     window.addEventListener('resize', handleResize);
// }

// Тестирование


// function initHeroCanvasAnimation() {
//     const TOTAL_FRAMES = 38;
//     const FRAME_BASE_URL = "/wp-content/themes/nvglobal/animation/video1/main_bg2_";
//     const EXT = ".jpg";

//     const canvas = document.getElementById('heroCanvas');
//     const ctx = canvas?.getContext('2d');
//     const heroSection = document.querySelector('.hero');
//     const heroWrapper = document.querySelector('.hero__wrapper');
//     const heroGradient = document.querySelector('.hero_gradient');

//     if (!canvas || !ctx || !heroSection || !heroWrapper || !heroGradient) {
//         console.error('Hero Canvas: нет DOM элементов');
//         return;
//     }

//     let frames = [];
//     let currentFrame = 0;
//     let timeline = null;
//     let resizeTimeout = null;

//     /* =========================
//       🧪 DEBUG
//     ========================= */

//     function log(stage) {
//         const spacer = document.querySelector('.pin-spacer');

//         console.group(`🧪 ${stage}`);
//         console.log('scrollY:', window.scrollY);

//         if (spacer) {
//             const s = getComputedStyle(spacer);
//             console.log('Spacer:', {
//                 height: spacer.offsetHeight,
//                 padding: s.paddingBottom
//             });
//         }

//         const h = getComputedStyle(heroSection);
//         console.log('Hero:', {
//             position: h.position,
//             transform: h.transform,
//             height: heroSection.offsetHeight
//         });

//         console.groupEnd();
//     }

//     /* =========================
//       🎬 DRAW FRAME
//     ========================= */

//     function draw(index) {
//         const img = frames[index];
//         if (!img) return;

//         const w = canvas.clientWidth;
//         const h = canvas.clientHeight;

//         if (canvas.width !== w || canvas.height !== h) {
//             canvas.width = w;
//             canvas.height = h;
//         }

//         ctx.clearRect(0, 0, w, h);

//         const imgRatio = img.width / img.height;
//         const canvasRatio = w / h;

//         let dw, dh, dx = 0, dy = 0;

//         if (canvasRatio > imgRatio) {
//             dw = w;
//             dh = w / imgRatio;
//             dy = (h - dh) / 2;
//         } else {
//             dh = h;
//             dw = h * imgRatio;
//             dx = (w - dw) / 2;
//         }

//         ctx.drawImage(img, dx, dy, dw, dh);
//     }

//     /* =========================
//       📦 PRELOAD
//     ========================= */

//     function preload() {
//         const promises = [];

//         for (let i = 0; i < TOTAL_FRAMES; i++) {
//             const index = String(i).padStart(3, '0');
//             const img = new Image();

//             promises.push(new Promise((resolve) => {
//                 img.onload = () => resolve(img);
//                 img.onerror = () => {
//                     console.warn(`frame ${index} error`);

//                     const fallback = document.createElement('canvas');
//                     fallback.width = 1920;
//                     fallback.height = 1080;
//                     fallback.getContext('2d').fillRect(0, 0, 1920, 1080);

//                     resolve(fallback);
//                 };
//                 img.src = `${FRAME_BASE_URL}${index}${EXT}`;
//             }));
//         }

//         return Promise.all(promises).then(res => {
//             frames = res;
//             draw(0);
//             console.log('✅ frames ready');
//         });
//     }

//     /* =========================
//       🔥 GSAP INIT
//     ========================= */

//     function initScroll() {
//         if (!window.gsap || !window.ScrollTrigger) {
//             console.error('GSAP нет');
//             return;
//         }

//         gsap.registerPlugin(ScrollTrigger);

//         // 💥 Полный reset
//         ScrollTrigger.getAll().forEach(t => t.kill(true));
//         if (timeline) {
//             timeline.kill();
//             timeline = null;
//         }

//         const height = heroSection.offsetHeight;

//         timeline = gsap.timeline({
//             scrollTrigger: {
//                 trigger: heroSection,
//                 start: "top top",
//                 end: `+=${height}`,
//                 scrub: 1.2,

//                 pin: true,
//                 pinSpacing: true,
//                 pinType: "fixed", // 💥 стабилизация

//                 anticipatePin: 1,
//                 invalidateOnRefresh: true,

//                 onUpdate: (self) => {
//                     const i = Math.floor(self.progress * (TOTAL_FRAMES - 1));
//                     currentFrame = i;
//                     draw(i);
//                 },

//                 onRefresh: () => log('refresh')
//             }
//         });

//         timeline.to(heroWrapper, {
//             x: -500,
//             opacity: 0
//         }, 0);

//         timeline.to(heroGradient, {
//             x: -500,
//             opacity: 0
//         }, 0);

//         requestAnimationFrame(() => {
//             ScrollTrigger.refresh();
//         });

//         console.log('🚀 GSAP init');
//     }

//     /* =========================
//       🔁 RESIZE
//     ========================= */

//     function onResize() {
//         clearTimeout(resizeTimeout);

//         resizeTimeout = setTimeout(() => {
//             log('resize BEFORE');

//             // ❗ важно: сначала убили
//             ScrollTrigger.getAll().forEach(t => t.kill(true));

//             // ❗ даём браузеру пересчитать layout
//             requestAnimationFrame(() => {

//                 draw(currentFrame);

//                 initScroll();

//                 requestAnimationFrame(() => {
//                     ScrollTrigger.refresh();
//                     log('resize AFTER');
//                 });

//             });

//         }, 250);
//     }

//     /* =========================
//       🚀 START
//     ========================= */

//     heroWrapper.style.opacity = 1;
//     heroGradient.style.opacity = 1;

//     preload().then(() => {
//         initScroll();

//         if (typeof initFadeUpAnimations === 'function') {
//             initFadeUpAnimations();
//         }
//     });

//     window.addEventListener('resize', onResize);
// }


// function initHeroCanvasAnimation() {
//     const TOTAL_FRAMES = 38;
//     const FRAME_BASE_URL = "/wp-content/themes/nvglobal/animation/video1/main_bg2_";
//     const EXT = ".jpg";

//     const canvas = document.getElementById('heroCanvas');
//     const ctx = canvas?.getContext('2d');
//     const heroSection = document.querySelector('.hero');
//     const heroWrapper = document.querySelector('.hero__wrapper');
//     const heroGradient = document.querySelector('.hero_gradient');

//     if (!canvas || !ctx || !heroSection || !heroWrapper || !heroGradient) {
//         console.error('Hero Canvas: нет DOM элементов');
//         return;
//     }

//     let frames = [];
//     let currentFrame = 0;
//     let timeline = null;
//     let heroST = null;
//     let resizeTimeout = null;

//     /* =========================
//       🧪 DEBUG
//     ========================= */

//     function log(stage) {
//         const spacer = document.querySelector('.pin-spacer');

//         console.group(`🧪 ${stage}`);
//         console.log('scrollY:', window.scrollY);

//         if (spacer) {
//             const s = getComputedStyle(spacer);
//             console.log('Spacer:', {
//                 height: spacer.offsetHeight,
//                 padding: s.paddingBottom
//             });
//         }

//         const h = getComputedStyle(heroSection);
//         console.log('Hero:', {
//             position: h.position,
//             transform: h.transform,
//             height: heroSection.offsetHeight
//         });

//         console.groupEnd();
//     }

//     /* =========================
//       🎬 DRAW FRAME
//     ========================= */

//     function draw(index) {
//         const img = frames[index];
//         if (!img) return;

//         const w = canvas.clientWidth;
//         const h = canvas.clientHeight;

//         if (canvas.width !== w || canvas.height !== h) {
//             canvas.width = w;
//             canvas.height = h;
//         }

//         ctx.clearRect(0, 0, w, h);

//         const imgRatio = img.width / img.height;
//         const canvasRatio = w / h;

//         let dw, dh, dx = 0, dy = 0;

//         if (canvasRatio > imgRatio) {
//             dw = w;
//             dh = w / imgRatio;
//             dy = (h - dh) / 2;
//         } else {
//             dh = h;
//             dw = h * imgRatio;
//             dx = (w - dw) / 2;
//         }

//         ctx.drawImage(img, dx, dy, dw, dh);
//     }

//     /* =========================
//       📦 PRELOAD
//     ========================= */

//     function preload() {
//         const promises = [];

//         for (let i = 0; i < TOTAL_FRAMES; i++) {
//             const index = String(i).padStart(3, '0');
//             const img = new Image();

//             promises.push(new Promise((resolve) => {
//                 img.onload = () => resolve(img);
//                 img.onerror = () => {
//                     console.warn(`frame ${index} error`);

//                     const fallback = document.createElement('canvas');
//                     fallback.width = 1920;
//                     fallback.height = 1080;
//                     fallback.getContext('2d').fillRect(0, 0, 1920, 1080);

//                     resolve(fallback);
//                 };
//                 img.src = `${FRAME_BASE_URL}${index}${EXT}`;
//             }));
//         }

//         return Promise.all(promises).then(res => {
//             frames = res;
//             draw(0);
//             console.log('✅ frames ready');
//         });
//     }

//     /* =========================
//       🔥 HERO SCROLL
//     ========================= */

//     function destroyHeroScroll() {
//         if (heroST) {
//             heroST.kill(true);
//             heroST = null;
//         }

//         if (timeline) {
//             timeline.kill();
//             timeline = null;
//         }
//     }

//     function initScroll() {
//         if (!window.gsap || !window.ScrollTrigger) {
//             console.error('GSAP нет');
//             return;
//         }

//         gsap.registerPlugin(ScrollTrigger);

//         destroyHeroScroll();

//         const height = heroSection.offsetHeight;

//         timeline = gsap.timeline({
//             scrollTrigger: {
//                 id: "hero-trigger", // 💥 важно
//                 trigger: heroSection,
//                 start: "top top",
//                 end: `+=${height}`,
//                 scrub: 1.2,

//                 pin: true,
//                 pinSpacing: true,
//                 pinType: "fixed",

//                 anticipatePin: 1,
//                 invalidateOnRefresh: true,

//                 onUpdate: (self) => {
//                     const i = Math.floor(self.progress * (TOTAL_FRAMES - 1));
//                     currentFrame = i;
//                     draw(i);
//                 },

//                 onRefresh: () => log('refresh')
//             }
//         });

//         heroST = timeline.scrollTrigger;

//         timeline.to(heroWrapper, {
//             x: -500,
//             opacity: 0
//         }, 0);

//         timeline.to(heroGradient, {
//             x: -500,
//             opacity: 0
//         }, 0);

//         requestAnimationFrame(() => {
//             ScrollTrigger.refresh();
//         });

//         console.log('🚀 Hero ScrollTrigger init');
//     }

//     /* =========================
//       🔁 RESIZE
//     ========================= */

//     function onResize() {
//         clearTimeout(resizeTimeout);

//         resizeTimeout = setTimeout(() => {
//             log('resize BEFORE');

//             destroyHeroScroll();

//             requestAnimationFrame(() => {

//                 draw(currentFrame);

//                 initScroll();

//                 // 💥 ВАЖНО: пересоздаём fade-анимации
//                 if (typeof initFadeUpAnimations === 'function') {
//                     initFadeUpAnimations();
//                 }

//                 requestAnimationFrame(() => {
//                     ScrollTrigger.refresh();
//                     log('resize AFTER');
//                 });

//             });

//         }, 250);
//     }

//     /* =========================
//       🚀 START
//     ========================= */

//     heroWrapper.style.opacity = 1;
//     heroGradient.style.opacity = 1;

//     preload().then(() => {
//         initScroll();

//         if (typeof initFadeUpAnimations === 'function') {
//             initFadeUpAnimations();
//         }
//     });

//     window.addEventListener('resize', onResize);
// }


function initHeroCanvasAnimation() {
    const TOTAL_FRAMES = 38;
    const FRAME_BASE_URL = "/wp-content/themes/nvglobal/animation/video1/main_bg2_";
    const EXT = ".jpg";

    const canvas = document.getElementById('heroCanvas');
    const ctx = canvas?.getContext('2d');
    const heroSection = document.querySelector('.hero');
    const heroWrapper = document.querySelector('.hero__wrapper');
    const heroGradient = document.querySelector('.hero_gradient');

    if (!canvas || !ctx || !heroSection || !heroWrapper || !heroGradient) {
        return;
    }

    let frames = [];
    let currentFrame = 0;
    let timeline = null;
    let heroST = null;
    let resizeTimeout = null;
    let lastWidth = window.innerWidth;

    function draw(index) {
        const img = frames[index];
        if (!img) return;

        const w = canvas.clientWidth;
        const h = canvas.clientHeight;

        if (canvas.width !== w || canvas.height !== h) {
            canvas.width = w;
            canvas.height = h;
        }

        ctx.clearRect(0, 0, w, h);

        const imgRatio = img.width / img.height;
        const canvasRatio = w / h;

        let dw, dh, dx = 0, dy = 0;

        if (canvasRatio > imgRatio) {
            dw = w;
            dh = w / imgRatio;
            dy = (h - dh) / 2;
        } else {
            dh = h;
            dw = h * imgRatio;
            dx = (w - dw) / 2;
        }

        ctx.drawImage(img, dx, dy, dw, dh);
    }

    function preload() {
        const promises = [];

        for (let i = 0; i < TOTAL_FRAMES; i++) {
            const index = String(i).padStart(3, '0');
            const img = new Image();

            promises.push(new Promise((resolve) => {
                img.onload = () => resolve(img);
                img.onerror = () => {
                    const fallback = document.createElement('canvas');
                    fallback.width = 1920;
                    fallback.height = 1080;
                    fallback.getContext('2d').fillRect(0, 0, 1920, 1080);
                    resolve(fallback);
                };

                img.src = `${FRAME_BASE_URL}${index}${EXT}`;
            }));
        }

        return Promise.all(promises).then(res => {
            frames = res;
            draw(0);
        });
    }

    function destroyHeroScroll() {
        if (heroST) {
            heroST.kill(true);
            heroST = null;
        }

        if (timeline) {
            timeline.kill();
            timeline = null;
        }
    }

    function initScroll() {
        if (!window.gsap || !window.ScrollTrigger) {
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        destroyHeroScroll();

        const height = heroSection.offsetHeight;

        timeline = gsap.timeline({
            scrollTrigger: {
                id: "hero-trigger",
                trigger: heroSection,
                start: "top top",
                end: `+=${height}`,
                scrub: 1.2,
                pin: true,
                pinSpacing: true,
                pinType: "fixed",
                anticipatePin: 1,
                invalidateOnRefresh: true,
                onUpdate: (self) => {
                    const i = Math.floor(self.progress * (TOTAL_FRAMES - 1));
                    currentFrame = i;
                    draw(i);
                }
            }
        });

        heroST = timeline.scrollTrigger;

        timeline.to(heroWrapper, {
            x: -500,
            opacity: 0
        }, 0);

        timeline.to(heroGradient, {
            x: -500,
            opacity: 0
        }, 0);

        requestAnimationFrame(() => {
            ScrollTrigger.refresh();
        });
    }

    function onResize() {
        const currentWidth = window.innerWidth;

        if (currentWidth === lastWidth) return;

        lastWidth = currentWidth;

        clearTimeout(resizeTimeout);

        resizeTimeout = setTimeout(() => {
            destroyHeroScroll();

            requestAnimationFrame(() => {
                draw(currentFrame);
                initScroll();

                if (typeof initFadeUpAnimations === 'function') {
                    initFadeUpAnimations();
                }

                requestAnimationFrame(() => {
                    ScrollTrigger.refresh();
                });
            });
        }, 250);
    }

    if (window.ScrollTrigger) {
        ScrollTrigger.config({
            ignoreMobileResize: true
        });
    }

    heroWrapper.style.opacity = 1;
    heroGradient.style.opacity = 1;

    preload().then(() => {
        initScroll();

        if (typeof initFadeUpAnimations === 'function') {
            initFadeUpAnimations();
        }
    });

    window.addEventListener('resize', onResize);
    // Сигнал, что hero-анимация готова
    window.heroAnimationReady = true;

    // Принудительно обновляем все триггеры
    ScrollTrigger.refresh();

    // Пересоздаём анимацию маскота, если она уже была инициализирована
    if (typeof initMaskotAnimations === 'function') {
        // Убиваем старую анимацию маскота, если она есть
        if (window.maskotTimeline) {
            window.maskotTimeline.scrollTrigger?.kill();
        }
        // Пересоздаём
        initMaskotAnimations();
    }
}



// Инициализация второго меню с якорными ссылками
function initPageNavSticky() {
    const pageNav = document.querySelector('.page-nav');
    if (!pageNav) return;
    
    let stickyThreshold = 0;
    
    // Случай 1: есть блок .hero
    const hero = document.querySelector('.hero');
    if (hero) {
        const heroHeight = hero.offsetHeight;
        stickyThreshold = heroHeight * 2; // hero + анимация
        //console.log('✅ Используем .hero, высота:', heroHeight, 'порог:', stickyThreshold);
    } 
    // Случай 2: нет .hero, но есть .main
    else {
        const main = document.querySelector('.main');
        if (main) {
            const mainHeight = main.offsetHeight;
            stickyThreshold = mainHeight; // без умножения на 2
            //console.log('✅ Используем .main, высота:', mainHeight, 'порог:', stickyThreshold);
        } 
        // Случай 3: нет ни .hero, ни .main — берём позицию .page-nav
        else {
            const rect = pageNav.getBoundingClientRect();
            stickyThreshold = rect.top + window.scrollY;
            //console.log('✅ Используем позицию .page-nav, порог:', stickyThreshold);
        }
    }
    
    function checkPosition() {
        if (window.scrollY >= stickyThreshold) {
            pageNav.classList.add('page-nav--fixed');
        } else {
            pageNav.classList.remove('page-nav--fixed');
        }
    }
    
    window.addEventListener('scroll', checkPosition);
    checkPosition();
}




// ==================== ГЛАВНАЯ ФУНКЦИЯ ИНИЦИАЛИЗАЦИИ ====================

document.addEventListener('DOMContentLoaded', () => {
    // Инициализация всех модулей
    initSmoothScroll();
    initHeroCanvasAnimation();
    initHeaderMenu();
    initProductsSlider();
    initTestimonialsSlider();
    initCasesSlider();
    initDocTabs();
    initCookieBanner();
    initCustomFormUi(document);
    initModalForm('callForm', '.open-callForm');
    initModalForm('callForm2', '.open-callForm2');
    initReviewModal('review', '.open-review');
    initReviewTranscriptToggle();
    initClientsHover();
    initNewsSlider();
    initBenefitsSlider();
    initFeaturesBlock();
    initFlowSlider();
    initIndustriesSlider();
    initIntegrationSlider();
    initUptimeGauge();
    initSecuritySlider();
    initFaq();
    initPageNavSticky();
    initSmoothAnchors();
    initMaskotAnimation();
    initPageNavMobile();
    initPageNavActive();
    initTopWidget();
    
    // Lightbox и формы инициализируем после остального
    initLightboxAndForms();
    
    // initLottieButtonsAnimation();
    // initLottieArrowAnimation();
    // initLottieArrowWhiteAnimation();
    initLottieAnimation(
        '.btn-with-lottie',
        '.lottie-container',
        '/wp-content/themes/nvglobal/animation/phone_call_white.json'
    );
    
    initLottieAnimation(
        '.btn-with-lottie-arrow',
        '.lottie-container-arrow',
        '/wp-content/themes/nvglobal/animation/arrow_right_black.json'
    );
    
    initLottieAnimation(
        '.btn-with-lottie-arrow-white',
        '.lottie-container-arrow-white',
        '/wp-content/themes/nvglobal/animation/arrow_right_white.json'
    );
    
    initLottieAnimation(
        '.btn-with-lottie-arrow-orange',
        '.lottie-container-arrow-orange',
        '/wp-content/themes/nvglobal/animation/arrow_right_white.json'
    );
    
    
    const hasHero = document.querySelector('.hero');
    if (hasHero) {
        
    }
    else {
        initFadeUpAnimations();
    }
    
});



// Плавный скролл к #solutions при загрузке страницы
window.addEventListener('load', () => {
  const hash = window.location.hash;
  if(hash) {
    const target = document.querySelector(hash);
    if(target){
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
});

// Отслеживание активного раздела на странице блога
document.addEventListener('DOMContentLoaded', () => {

  const headings = document.querySelectorAll('.post-text h2, .post-text h3, .post-text h4');
  const tocLinks = document.querySelectorAll('.toc-block a');

  if (!headings.length || !tocLinks.length) return;

  // карта: id -> link
  const linkMap = {};
  tocLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href && href.startsWith('#')) {
      linkMap[href.substring(1)] = link;
    }
  });

  // убираем активный класс
  const clearActive = () => {
    document.querySelectorAll('.toc-block__item--active')
      .forEach(el => el.classList.remove('toc-block__item--active'));
  };

  const observer = new IntersectionObserver((entries) => {

    entries.forEach(entry => {

      if (entry.isIntersecting) {
        const id = entry.target.id;
        const link = linkMap[id];

        if (!link) return;

        clearActive();

        const li = link.closest('.toc-block__item');
        if (li) {
          li.classList.add('toc-block__item--active');
        }
      }

    });

  }, {
    rootMargin: '-40% 0px -55% 0px', // зона "чтения"
    threshold: 0
  });

  headings.forEach(h => observer.observe(h));

});

// Увеличение и уменьшение лайков
// Увеличение и уменьшение лайков
document.addEventListener('DOMContentLoaded', () => {
  const likeBlock = document.querySelector('.post__meta-likes');

  if (!likeBlock) return;

  const postId = likeBlock.dataset.postId;
  const countEl = likeBlock.querySelector('.js-likes-count');

  if (!postId) return;

  const storageKey = `nv_liked_post_${postId}`;

  const isLiked =
    localStorage.getItem(storageKey) === 'true' ||
    document.cookie.includes(`${storageKey}=1`);

  if (isLiked) {
    likeBlock.classList.add('is-liked');
  }

  likeBlock.addEventListener('click', () => {
    const active = likeBlock.classList.contains('is-liked');
    const mode = active ? 'unlike' : 'like';

    fetch(themeFormData.ajax_url, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        action: 'nv_update_likes',
        post_id: postId,
        mode: mode,
        nonce: themeFormData.likes_nonce,
      }),
    })
      .then(res => res.json())
      .then(data => {
        if (!data.success) return;

        const newLikes = data.data.likes;

        if (countEl) {
          countEl.textContent = newLikes;
        }

        if (mode === 'like') {
          likeBlock.classList.add('is-liked');
          localStorage.setItem(storageKey, 'true');
          document.cookie = `${storageKey}=1; path=/; max-age=31536000`;
        } else {
          likeBlock.classList.remove('is-liked');
          localStorage.removeItem(storageKey);
          document.cookie = `${storageKey}=1; path=/; max-age=0`;
        }
      })
      .catch(error => {
        console.error('Like error:', error);
      });
  });
});

// Показать/скрыть сайдбар на мобилках и планшетах
document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.querySelector('.post-sidebar');
  const buttons = document.querySelectorAll('.post-sidebar-btn, .post-sidebar-btn-mobile');
  const overlay = document.querySelector('.sidebar-overlay');

  if (!sidebar || !buttons.length || !overlay) return;

  const setButtonsState = (isOpen) => {
    buttons.forEach(btn => {
      btn.classList.toggle('open', isOpen);
    });
  };

  const openSidebar = () => {
    sidebar.classList.add('is-open');
    overlay.classList.add('is-active');
    document.body.classList.add('no-scroll');
    setButtonsState(true);
  };

  const closeSidebar = () => {
    sidebar.classList.remove('is-open');
    overlay.classList.remove('is-active');
    document.body.classList.remove('no-scroll');
    setButtonsState(false);
  };

  const toggleSidebar = (e) => {
    e.preventDefault();
    e.stopPropagation();

    sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
  };

  buttons.forEach((btn) => {
    btn.addEventListener('click', toggleSidebar);
  });

  overlay.addEventListener('click', closeSidebar);

  sidebar.querySelectorAll('.toc-block a').forEach((link) => {
    link.addEventListener('click', closeSidebar);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeSidebar();
    }
  });
});


// Поиск заисей блога на странице блога
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.search__form');
  const input = document.querySelector('.input-search');
  const list = document.querySelector('.blog-page__list');

  if (!form || !input || !list || typeof themeFormData === 'undefined') return;

  let timer = null;

  const searchPosts = async () => {
    const searchValue = input.value.trim();

    const body = new URLSearchParams({
      action: 'nv_blog_search',
      search: searchValue,
      nonce: themeFormData.blog_search_nonce,
    });

    try {
      list.classList.add('is-loading');

      const response = await fetch(themeFormData.ajax_url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body,
      });

      const data = await response.json();

      if (data.success && data.data.html) {
        list.innerHTML = data.data.html;
      }
    } catch (error) {
      console.error('Blog search error:', error);
    } finally {
      list.classList.remove('is-loading');
    }
  };

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    searchPosts();
  });

  input.addEventListener('input', () => {
    clearTimeout(timer);

    timer = setTimeout(() => {
      searchPosts();
    }, 400);
  });
});

// Подгрузка постов на странице блога
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.querySelector('.more-post');
  const list = document.querySelector('.blog-page__list');

  if (!btn || !list || typeof themeFormData === 'undefined') return;

  btn.addEventListener('click', async () => {
    const currentPage = parseInt(btn.dataset.page || '1', 10);

    btn.disabled = true;
    btn.classList.add('is-loading');

    try {
      const response = await fetch(themeFormData.ajax_url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          action: 'nv_load_more_posts',
          page: currentPage,
          nonce: themeFormData.load_more_nonce,
        }),
      });

      const data = await response.json();

      if (!data.success) return;

      list.insertAdjacentHTML('beforeend', data.data.html);

      btn.dataset.page = data.data.page;

      if (!data.data.has_more) {
        btn.closest('.blog-page__action').style.display = 'none';
      }

    } catch (error) {
      console.error('Load more error:', error);
    } finally {
      btn.disabled = false;
      btn.classList.remove('is-loading');
    }
  });
});

