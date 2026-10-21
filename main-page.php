<?php
/*
Template Name: Шаблон главной страницы
Template Post Type: page
*/

/* =============================================================================
 * АНИМАЦИЯ ПЕРВОГО БЛОКА (.hero) — АВТОПЛЕЙ ФОНОВОГО ВИДЕО
 * -----------------------------------------------------------------------------
 * Самый простой вариант: при загрузке страницы (и на десктопе, и на телефоне)
 * фоновое видео main_bg.mp4 СРАЗУ проигрывается (autoplay, muted, playsinline).
 * Проигрывается ОДИН раз (без loop) и остаётся последний кадр. Блок с текстом
 * НИКУДА не уезжает — никакой привязки к скроллу, pin, fade-out и ScrollTrigger нет.
 *
 * Автоплей немого инлайн-видео разрешён на iOS/Android. На случай блокировки
 * (например, режим энергосбережения) есть фолбэк: запуск по первому жесту.
 * Poster (первый кадр) — до старта; после конца держим точный последний кадр
 * отдельным слоем (предзагружен), без чёрной вспышки.
 * ============================================================================= */

get_header(); ?>

<main>


    <section class="hero">
        <div class="container">
            <div class="hero__card">
                <picture class="hero__media">
                    <?php /* Full HD 2380:22866 — свой кроп 1856×872; ниже 1600 кадр Desktop 2363:34983. */ ?>
                    <source media="(min-width: 1600px)"
                            srcset="<?php echo esc_url(get_template_directory_uri() . '/img/hero-bg-fhd.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/hero-bg-fhd@2x.webp'); ?> 2x"
                            width="1856" height="872">
                    <?php /* Tablet 2376:16686 — свой кадр 776×872: телефон 290×610 справа, текст слева на диване. */ ?>
                    <source media="(min-width: 768px) and (max-width: 991.98px)"
                            srcset="<?php echo esc_url(get_template_directory_uri() . '/img/hero-bg-tablet.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/hero-bg-tablet@2x.webp'); ?> 2x"
                            width="776" height="872">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/hero-bg.webp'); ?>"
                         srcset="<?php echo esc_url(get_template_directory_uri() . '/img/hero-bg.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/hero-bg@2x.webp'); ?> 2x"
                         width="1856" height="1006" alt="" aria-hidden="true" fetchpriority="high" decoding="async">
                </picture>
                <img class="hero__logo" src="<?php echo esc_url(get_template_directory_uri() . '/img/logo-hero.svg'); ?>"
                     width="206" height="39" alt="NeuroVision Global Systems">
                <div class="hero__wrapper">
                    <div class="hero__content">
                        <h1 class="hero__title">We verify people, documents and transactions <span class="hero__title-dash">-</span><br> <span class="hero__title-accent">in&nbsp;seconds</span></h1>
                        <div class="verify">AI identity platform built on 20&nbsp;years of computer-vision engineering. KYC, KYB, AML and KYT through one REST API — live in under an&nbsp;hour.</div>
                    </div>
                    <div class="hero__actions">
                        <button class="btn-hero open-callForm2" type="button">
                            <span class="btn__text btn__text-hero">Start Free Trial</span>
                            <span class="btn__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                        </button>
                        <a href="/pricing-matrix/" class="btn btn--gray">
                            <span class="btn__text">View our prices</span>
                            <span class="btn__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php if (false) : /* Секция page-nav скрыта: в макетах редизайна её нет (DECISIONS.md, Р-11) */ ?>
    <section class="page-nav" data-threshold="2200">
        <div class="container">
            <div class="page-nav__wrapper">
                <nav class="page-nav__menu">
                    <ul class="page-nav__menu-list">
                        <li class="page-nav__menu-item">
                            <a href="#about" class="page-nav__menu-link">About</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#solutions" class="page-nav__menu-link">Industry Solutions</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#products" class="page-nav__menu-link">Products</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#advantages" class="page-nav__menu-link">Advantages</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#clients" class="page-nav__menu-link">Clients</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#cases" class="page-nav__menu-link">Cases</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#documentation" class="page-nav__menu-link">Documentation</a>
                        </li>
                        <li class="page-nav__menu-dot"></li>
                        <li class="page-nav__menu-item">
                            <a href="#contacts" class="page-nav__menu-link">Contacts</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <?php endif; ?>
 
    <section class="about section" id="about" data-offset="1">
        <div class="container">
            <div class="about__wrapper section__wrapper">
                <div class="section__badge">About</div>
                <div class="section__content">
                    <div class="section__title-block">
                        <h2 class="section__title">One identity platform for&nbsp;onboarding,<br> compliance, signing and&nbsp;payments</h2>
                        <p class="section__subtitle">NeuroVision Global Systems builds every engine in-house — document OCR, face recognition, liveness and anti-fraud — and runs them for banks, fintechs, telecoms and government services on four continents. Profitable and founder-owned; no third-party technology under the&nbsp;hood.</p>
                    </div>
                    <div class="about__info">
                        <div class="about__cards">
                            <div class="about__card">
                                <div class="about__card-text">Our advanced computer vision technology delivers</div>
                                <div class="about__card-stats">
                                    <div class="about__card-stat">
                                        <div class="about__card-percent">99.74%</div>
                                        <div class="about__card-description">facial recognition accuracy</div>
                                    </div>
                                    <div class="about__card-divider" aria-hidden="true"></div>
                                    <div class="about__card-stat">
                                        <div class="about__card-percent">99.85%</div>
                                        <div class="about__card-description">document recognition accuracy</div>
                                    </div>
                                </div>
                            </div>
                            <div class="about__card about__card--statement">
                                <div class="about__card-text">Our advanced computer vision technology delivers</div>
                                <div class="about__card-statement">over <span>16,000&nbsp;document</span> types<br>from <span>195+&nbsp;countries and territories</span></div>
                            </div>
                            <div class="about__card about__card--long about__card--certfication">
                                <div class="about__card-content">
                                    <div class="about__card-title">NeuroVision Global Systems operates in compliance with ISO/IEC 27001:2022 and GDPR standards, covering the design, development, and operation of AI-based identity verification systems</div>
                                    <div class="about__card-actions">
                                        <a href="/wp-content/uploads/2026/06/neurovision_iso_27001_certificate.pdf" target="_blank" rel="noopener noreferrer" class="btn btn--small btn--gray">
                                            <span class="btn__text">ISO/IEC 27001:2022</span>
                                            <span class="btn__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                                        </a>
                                        <a href="/wp-content/uploads/2026/06/neurovision_gdpr_certificate.pdf" target="_blank" rel="noopener noreferrer" class="btn btn--small btn--gray">
                                            <span class="btn__text">GDPR compliance certification</span>
                                            <span class="btn__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="about__card-logos">
                                    <div class="about__card-logo">
                                        <?php echo td_image(960, ['loading' => 'eager']); ?>
                                    </div>
                                    <div class="about__card-logo">
                                        <?php echo td_image(961, ['loading' => 'eager']); ?>
                                    </div>
                                    <div class="about__card-logo">
                                        <?php echo td_image(962, ['loading' => 'eager']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* Видео (Figma 2577:41363 / 41304 / 41349 / 41356): универсальный блок template-parts/video-section.php, между About и Results. */
    get_template_part('template-parts/video-section', null, array(
        'section_id' => 'video',
        'video_id'   => 'JY1JWGREje0',
        'title'      => 'See how NeuroVision KYC verification works',
        'alt'        => 'NeuroVision KYC verification demo: a customer passes document, selfie and liveness checks',
        'poster'     => array(
            'src'   => 'video-demo-poster',
            'w'     => 1920,
            'h'     => 1080,
            'small' => array('src' => 'video-demo-poster-960', 'w' => 960),
        ),
    )); ?>

    <section class="results section" id="results">
        <div class="container">
            <div class="results__wrapper section__wrapper">
                <div class="section__badge">Results</div>
                <div class="results__content">
                    <div class="results__intro">
                        <h2 class="results__title section__title">The platform pays for&nbsp;itself: lower losses, higher revenue</h2>
                        <div class="results__case">
                            <div class="results__case-info">
                                <div class="results__case-head">
                                    <div class="results__case-name">A major retail bank</div>
                                    <div class="results__case-problem">KYC review was slow, expensive and&nbsp;still leaked risk</div>
                                </div>
                                <div class="results__case-outcome">
                                    <div class="results__case-label">After automated KYC with anti-fraud and&nbsp;AML:</div>
                                    <ul class="results__tokens">
                                        <li class="results__token">+15% conversion</li>
                                        <li class="results__token">processing ×10&nbsp;faster</li>
                                        <li class="results__token">residual fraud down to&nbsp;0.01%</li>
                                    </ul>
                                </div>
                            </div>
                            <img class="results__case-image"
                                 src="<?php echo esc_url(get_template_directory_uri() . '/img/results-bank.webp'); ?>"
                                 srcset="<?php echo esc_url(get_template_directory_uri() . '/img/results-bank.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/results-bank@2x.webp'); ?> 2x"
                                 width="276" height="276" alt="" aria-hidden="true" loading="lazy" decoding="async">
                        </div>
                    </div>
                    <div class="results__stats">
                            <div class="results__stat">
                                <div class="results__stat-value">×60</div>
                                <div class="results__stat-info">
                                    <div class="results__stat-title">faster checks</div>
                                    <div class="results__stat-description">verification automated end to&nbsp;end</div>
                                </div>
                            </div>
                            <div class="results__stat">
                                <div class="results__stat-value">+15%</div>
                                <div class="results__stat-info">
                                    <div class="results__stat-title">conversion uplift</div>
                                    <div class="results__stat-description">sub-second speed and 99.85% accuracy</div>
                                </div>
                            </div>
                            <div class="results__stat">
                                <div class="results__stat-value">0.01%</div>
                                <div class="results__stat-info">
                                    <div class="results__stat-title">residual fraud risk</div>
                                    <div class="results__stat-description">anti-fraud and AML working together</div>
                                </div>
                            </div>
                            <div class="results__stat">
                                <div class="results__stat-value">195+</div>
                                <div class="results__stat-info">
                                    <div class="results__stat-title">countries and territories</div>
                                    <div class="results__stat-description">non-residents verified, new markets opened</div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (false) : /* Секция video-intro скрыта: в макетах редизайна её нет (DECISIONS.md, Р-11) */ ?>
    <section class="video-intro section" id="get-to-know">
        <div class="container">
            <div class="video-intro__wrapper section__wrapper">
                <header class="video-intro__head">
                    <h2 class="video-intro__title">Let&rsquo;s get to know each other!</h2>
                    <p class="video-intro__subtitle">Our mascot, Nevi, will tell you about NeuroVision Global Systems</p>
                </header>
                <?php $vi_uri = get_template_directory_uri(); ?>
                <div class="video-intro__player" data-video-base="<?php echo esc_url( $vi_uri . '/video/' ); ?>">
                    <video class="video-intro__video"
                           preload="none"
                           playsinline
                           aria-label="Video introduction: our mascot Nevi tells you about NeuroVision Global Systems"></video>
                    <picture class="video-intro__poster" aria-hidden="true">
                        <source type="image/webp"
                                srcset="<?php echo $vi_uri; ?>/video/nvglobal_video_poster.webp 1x, <?php echo $vi_uri; ?>/video/nvglobal_video_poster@2x.webp 2x, <?php echo $vi_uri; ?>/video/nvglobal_video_poster@3x.webp 3x">
                        <img class="video-intro__poster-img"
                             src="<?php echo $vi_uri; ?>/video/nvglobal_video_poster.jpg"
                             srcset="<?php echo $vi_uri; ?>/video/nvglobal_video_poster.jpg 1x, <?php echo $vi_uri; ?>/video/nvglobal_video_poster@2x.jpg 2x, <?php echo $vi_uri; ?>/video/nvglobal_video_poster@3x.jpg 3x"
                             alt="" decoding="async">
                    </picture>
                    <button type="button" class="video-intro__play" aria-label="Play video introduction">
                        <svg class="video-intro__play-icon" width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true" focusable="false">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.02176 10.5696C8.49906 15.2151 8.48611 20.2023 9.02281 25.4226C9.21219 26.9177 9.91756 27.9189 10.8339 28.4345C11.7575 28.9542 13.0692 29.0772 14.6436 28.4577C18.7984 26.783 22.5808 24.3173 25.6057 21.5783C26.8477 20.4353 27.3807 19.1588 27.3744 17.9688C27.3681 16.7763 26.8192 15.5207 25.6089 14.4246L25.6042 14.4204C22.4148 11.4996 18.7422 9.22109 14.6336 7.53828L14.6234 7.5341C13.241 6.95196 11.9305 7.02503 10.9518 7.53872C9.99172 8.04264 9.22515 9.03506 9.02176 10.5696ZM15.4914 5.45819C13.5769 4.65357 11.5566 4.68018 9.90612 5.54648C8.23756 6.42225 7.07706 8.08928 6.78952 10.2873L6.78709 10.3073C6.24336 15.1322 6.23233 20.2893 6.78592 25.6656L6.78865 25.6895C7.04995 27.7851 8.09607 29.4756 9.73044 30.3953C11.359 31.3118 13.3992 31.3667 15.4726 30.5495L15.4804 30.5463C19.8996 28.7657 23.9086 26.1512 27.1193 23.2431L27.1254 23.2376C28.7613 21.7337 29.6344 19.8764 29.6244 17.957C29.6142 16.0403 28.724 14.2111 27.1217 12.759C23.7249 9.64899 19.825 7.23381 15.4914 5.45819Z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <script>
        (function () {
            var player = document.querySelector('.video-intro__player');
            if (!player) return;
            var video = player.querySelector('.video-intro__video');
            var playBtn = player.querySelector('.video-intro__play');
            if (!video || !playBtn) return;

            // Выбор ролика по ширине экрана: ПК — 1080p, телефон — сжатый 540p.
            // Источники добавляем до загрузки, поэтому <video> изначально пустой.
            var base = player.getAttribute('data-video-base') || '';
            var isMobile = window.matchMedia('(max-width: 768px)').matches;
            var sources = isMobile
                ? [['nvglobal_video_mobile.webm', 'video/webm'],
                   ['nvglobal_video_mobile.mp4',  'video/mp4']]
                : [['nvglobal_video_desktop.mp4', 'video/mp4']];

            sources.forEach(function (s) {
                var el = document.createElement('source');
                el.src = base + s[0];
                el.type = s[1];
                video.appendChild(el);
            });

            playBtn.addEventListener('click', function () {
                video.controls = true;
                player.classList.add('video-intro__player--playing');
                video.focus();
                var p = video.play();
                if (p && typeof p.catch === 'function') { p.catch(function () {}); }
            });
        })();
    </script>

    <section class="solutions section" id="solutions">
        <div class="container">
            <div class="section__wrapper">
                <div class="section__badge">Industry Solutions</div>
                <div class="section__content solutions__content">
                    <h2 class="solutions__title section__title">Built for regulated industries</h2>
                    <div class="solutions__list">
                        <div class="solutions__item">
                            <div class="solutions__item-icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"> <g filter="url(#filter0_d_2005_7119_1)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3648 10.4289C9.83028 11.003 9.5 11.851 9.5 12.9172V16.2107C9.5 16.625 9.16421 16.9607 8.75 16.9607C8.33579 16.9607 8 16.625 8 16.2107V12.9172C8 11.5414 8.43009 10.3057 9.26696 9.40676C10.1095 8.5018 11.3075 8 12.7149 8H22.7851C24.1895 8 25.3872 8.50209 26.2302 9.40643C27.0677 10.3049 27.5 11.5405 27.5 12.9172V19.5043C27.5 20.8801 27.0699 22.1158 26.233 23.0147C25.3905 23.9197 24.1924 24.4215 22.7851 24.4215H17.3725C16.9583 24.4215 16.6225 24.0857 16.6225 23.6715C16.6225 23.2573 16.9583 22.9215 17.3725 22.9215H22.7851C23.8219 22.9215 24.6063 22.5608 25.1352 21.9926C25.6697 21.4185 26 20.5705 26 19.5043V12.9172C26 11.8518 25.6685 11.0038 25.1329 10.4292C24.6028 9.86045 23.8181 9.5 22.7851 9.5H12.7149C11.6781 9.5 10.8937 9.86074 10.3648 10.4289Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 14.0443C8 13.6301 8.33579 13.2943 8.75 13.2943H26.75C27.1642 13.2943 27.5 13.6301 27.5 14.0443C27.5 14.4585 27.1642 14.7943 26.75 14.7943H8.75C8.33579 14.7943 8 14.4585 8 14.0443Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3457 17.7225C11.6596 17.7225 11.9403 17.9181 12.0492 18.2126L12.1502 18.4859C12.4553 19.3117 13.1052 19.9623 13.929 20.2676L14.202 20.3687C14.4961 20.4777 14.6914 20.7583 14.6914 21.072C14.6914 21.3857 14.4961 21.6663 14.202 21.7753L13.929 21.8764C13.1052 22.1817 12.4553 22.8323 12.1502 23.658L12.0492 23.9314C11.9404 24.2259 11.6596 24.4215 11.3457 24.4215C11.0317 24.4215 10.7509 24.2259 10.6421 23.9314L10.5411 23.658C10.236 22.8323 9.58613 22.1817 8.76233 21.8764L8.48935 21.7752C8.19522 21.6662 8 21.3857 8 21.072C8 20.7583 8.19522 20.4778 8.48935 20.3687L8.76228 20.2676C9.58609 19.9623 10.236 19.3117 10.5411 18.486L10.6421 18.2126C10.751 17.9181 11.0317 17.7225 11.3457 17.7225ZM11.3457 22.0215C11.6128 21.6595 11.9326 21.3394 12.2943 21.072C11.9326 20.8046 11.6128 20.4845 11.3457 20.1225C11.0785 20.4845 10.7587 20.8046 10.397 21.072C10.7587 21.3394 11.0785 21.6595 11.3457 22.0215Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M17.159 17.0548C17.4892 17.0548 17.7805 17.2708 17.8766 17.5867C17.9756 17.9125 18.23 18.167 18.5543 18.2658C18.87 18.362 19.0856 18.6533 19.0856 18.9832C19.0856 19.3132 18.87 19.6044 18.5543 19.7006C18.23 19.7995 17.9756 20.0539 17.8766 20.3798C17.7805 20.6957 17.4892 20.9117 17.159 20.9117C16.8288 20.9117 16.5374 20.6957 16.4414 20.3798C16.3423 20.0539 16.0879 19.7995 15.7636 19.7006C15.448 19.6044 15.2323 19.3132 15.2323 18.9832C15.2323 18.6533 15.448 18.3621 15.7636 18.2658C16.0879 18.167 16.3423 17.9126 16.4414 17.5867C16.5374 17.2708 16.8288 17.0548 17.159 17.0548Z" fill="currentColor"/> </g> <defs> <filter id="filter0_d_2005_7119_1" x="0" y="0" width="35.5" height="32.4215" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset/> <feGaussianBlur stdDeviation="4"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_7119"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_7119" result="shape"/> </filter> </defs> </svg></div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Banks</div>
                                <div class="solutions__item-description">Open accounts remotely in one session: KYC and AML in a single flow, evidence logged for the regulator.</div>
                            </div>
                        </div>
                        <div class="solutions__item">
                            <div class="solutions__item-icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 35 36" fill="none"> <g filter="url(#filter0_d_2005_2852_2)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1226 26V18.0039H25.7117C26.1259 18.0039 26.4617 17.6681 26.4617 17.2539C26.4617 16.8397 26.1259 16.5039 25.7117 16.5039H25.0874C24.7329 12.7441 21.7407 9.75152 17.9809 9.3968L17.9813 8.75043C17.9815 8.33621 17.6459 8.00024 17.2317 8C16.8175 7.99976 16.4815 8.33536 16.4813 8.74957L16.4809 9.39671C12.7207 9.75098 9.7276 12.7437 9.37307 16.5039H8.75C8.33579 16.5039 8 16.8397 8 17.2539C8 17.6681 8.33579 18.0039 8.75 18.0039H9.33789V26H8.75C8.33579 26 8 26.3358 8 26.75C8 27.1642 8.33579 27.5 8.75 27.5H10.0879H13.6605H17.2312H20.8019H24.3726H25.7117C26.1259 27.5 26.4617 27.1642 26.4617 26.75C26.4617 26.3358 26.1259 26 25.7117 26H25.1226ZM23.6226 26V18.0039H21.5519V26H23.6226ZM20.0519 26V18.0039H17.9812V26H20.0519ZM16.4812 26V18.0039H14.4105V26H16.4812ZM12.9105 26V18.0039H10.8379V26H12.9105ZM23.579 16.5039H20.8019H17.2312H13.6605H10.8814C11.2528 13.3271 13.9539 10.8616 17.2304 10.8616C20.5068 10.8616 23.2077 13.3271 23.579 16.5039Z" fill="currentColor"/> </g> <defs> <filter id="filter0_d_2005_2852_2" x="0" y="0" width="34.4617" height="35.5" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset/> <feGaussianBlur stdDeviation="4"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2852"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2852" result="shape"/> </filter> </defs> </svg></div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">FinTech &amp; lending</div>
                                <div class="solutions__item-description">Cut drop-off during checks: a full verification session in minutes, decision in seconds</div>
                            </div>
                        </div>
                        <div class="solutions__item">
                            <div class="solutions__item-icon"><svg aria-hidden="true" focusable="false" width="34.9066" height="35.5007" viewBox="0 0 34.9066 35.5007" fill="none" xmlns="http://www.w3.org/2000/svg"> <g id="Tron - Iconly Pro_3"> <g id="Vector_3" filter="url(#filter0_d_2413_15694_3)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M9.50561 9.55355V9.55355L16.461 25.9776C16.4639 25.9843 16.4676 25.9893 16.4676 25.9893C16.4688 25.9909 16.4715 25.9931 16.4715 25.9931C16.4748 25.9956 16.4814 25.9989 16.4908 26.0002C16.5002 26.0014 16.5072 25.9999 16.5108 25.9985L16.5152 25.9961C16.5152 25.9961 16.5197 25.9926 16.5242 25.9869L25.3987 14.6994V14.6994C25.4105 14.6842 25.4091 14.6616 25.3946 14.648V14.648L22.4118 11.8847L9.54606 9.50198C9.5378 9.50044 9.53106 9.50076 9.53106 9.50076L9.52663 9.5018C9.52347 9.50304 9.51711 9.50669 9.51076 9.5146C9.5044 9.52252 9.50201 9.5298 9.50138 9.53375C9.50138 9.53375 9.50106 9.53711 9.5013 9.53916C9.5013 9.53916 9.50233 9.54577 9.50561 9.55355ZM9.81921 8.02706C8.61246 7.80296 7.64823 9.01173 8.1239 10.1374L15.0798 26.5624V26.5624C15.5354 27.6386 16.9805 27.8341 17.7037 26.9136V26.9136L26.5781 15.6263C27.072 14.9974 27.0018 14.0936 26.4152 13.5488L23.2718 10.6367C23.1677 10.5402 23.0383 10.4752 22.8987 10.4494L9.81921 8.02706Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39413 8.66039C8.66907 8.35058 9.14311 8.32231 9.45291 8.59725L17.9507 16.1387C18.1289 16.2968 18.2214 16.5302 18.1998 16.7675L17.2862 26.8182C17.2487 27.2307 16.8839 27.5348 16.4714 27.4973C16.0589 27.4598 15.7549 27.095 15.7924 26.6824L16.6717 17.0091L8.45727 9.71917C8.14746 9.44423 8.11919 8.9702 8.39413 8.66039Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M23.2818 10.6453C23.5802 10.9325 23.5892 11.4073 23.3019 11.7057L19.7729 15.3712L25.9812 13.8811C26.384 13.7844 26.7889 14.0326 26.8855 14.4353C26.9822 14.8381 26.7341 15.243 26.3313 15.3397L17.6282 17.4286C17.3042 17.5064 16.9678 17.3611 16.8022 17.072C16.6367 16.7828 16.6817 16.4192 16.9128 16.1791L22.2213 10.6654C22.5086 10.367 22.9834 10.358 23.2818 10.6453Z" fill="currentColor"/> </g> </g> <defs> <filter id="filter0_d_2413_15694_3" x="0" y="0" width="34.9066" height="35.5007" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset/> <feGaussianBlur stdDeviation="4"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2413_15694"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2413_15694" result="shape"/> </filter> </defs> </svg></div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Crypto Exchanges</div>
                                <div class="solutions__item-description">KYC, AML and KYT on one API: onboard users, screen wallets and monitor transactions in real time.</div>
                            </div>
                        </div>
                        <div class="solutions__item">
                            <div class="solutions__item-icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="36" height="34" viewBox="0 0 36 34" fill="none"> <g filter="url(#filter0_d_2005_3470_4)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.169 8.21984C11.3096 8.07909 11.5005 8 11.6995 8H23.7999C24.2141 8 24.5499 8.33579 24.5499 8.75H23.7999C24.5499 8.75 24.5499 8.75 24.5499 8.75V8.76114L24.5497 8.78764C24.5495 8.81031 24.5491 8.8429 24.5483 8.88475C24.5467 8.96844 24.5436 9.08924 24.5375 9.24187C24.5252 9.54695 24.5008 9.98019 24.4522 10.4991C24.3551 11.5334 24.1603 12.9247 23.766 14.3261C23.3742 15.7186 22.7701 17.1774 21.8218 18.3007C20.9952 19.28 19.9019 20.0063 18.4966 20.1967V21.4433H20.9899C21.316 21.4433 21.6048 21.6541 21.7042 21.9648L22.4247 24.2164H23.4943C23.9085 24.2164 24.2443 24.5522 24.2443 24.9664C24.2443 25.3806 23.9085 25.7164 23.4943 25.7164H21.8997C21.8846 25.7169 21.8695 25.7169 21.8544 25.7164H13.789C13.774 25.7169 13.7589 25.7169 13.7437 25.7164H12.1489C11.7347 25.7164 11.3989 25.3806 11.3989 24.9664C11.3989 24.5522 11.7347 24.2164 12.1489 24.2164H13.2188L13.9393 21.9648C14.0387 21.6541 14.3274 21.4433 14.6536 21.4433H16.9966V20.1951C15.5973 20.0021 14.5076 19.2772 13.683 18.3008C12.7343 17.1776 12.1294 15.7189 11.7368 14.3265C11.3417 12.9252 11.146 11.5338 11.0483 10.4996C10.9993 9.98065 10.9746 9.54742 10.9622 9.24234C10.956 9.08971 10.9528 8.96891 10.9512 8.88523C10.9504 8.84338 10.9499 8.81078 10.9497 8.78811L10.9495 8.76162L10.9495 8.7518C10.9495 8.7518 10.9495 8.75048 11.6995 8.75L10.9495 8.75048C10.9493 8.55148 11.0283 8.3606 11.169 8.21984ZM12.4766 9.5C12.4902 9.74099 12.5108 10.0313 12.5417 10.3586C12.6343 11.3392 12.8182 12.6343 13.1805 13.9195C13.5454 15.2135 14.0759 16.4413 14.829 17.333C15.5632 18.2023 16.499 18.746 17.7526 18.746C19.0064 18.746 19.9419 18.2023 20.6756 17.3331C21.4282 16.4417 21.9579 15.2139 22.322 13.9199C22.6836 12.6348 22.8667 11.3396 22.9587 10.359C22.9894 10.0316 23.0098 9.74108 23.0233 9.5H12.4766ZM17.7189 22.9433H15.201L14.7937 24.2164H20.8497L20.4424 22.9433H17.7743C17.7651 22.9437 17.7559 22.9438 17.7466 22.9438C17.7373 22.9438 17.7281 22.9437 17.7189 22.9433Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.02782 10.427C8.0704 10.0475 8.39129 9.76059 8.77315 9.76059H11.8041C12.2183 9.76059 12.5541 10.0964 12.5541 10.5106C12.5541 10.9248 12.2183 11.2606 11.8041 11.2606H9.50301C9.51279 11.5944 9.54877 12.0227 9.64517 12.4889C9.86666 13.56 10.3887 14.7555 11.5646 15.5296C11.9106 15.7573 12.0064 16.2225 11.7786 16.5684C11.5508 16.9144 11.0857 17.0103 10.7398 16.7824C9.11041 15.7098 8.44297 14.0825 8.17624 12.7927C8.04211 12.144 8.00466 11.5614 8.00042 11.1405C7.9983 10.9293 8.00452 10.7568 8.01155 10.6344C8.01506 10.5732 8.0188 10.5243 8.02181 10.4893C8.02332 10.4718 8.02465 10.4577 8.02569 10.4473L8.02702 10.4343L8.02767 10.4283L8.02782 10.427C8.02782 10.427 8.02782 10.427 8.77315 10.5106L8.02782 10.427Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9453 10.5106C22.9453 10.0964 23.2811 9.76059 23.6953 9.76059H26.7263C27.1081 9.76059 27.429 10.0475 27.4716 10.427L26.7263 10.5106C27.4716 10.427 27.4716 10.427 27.4716 10.427L27.4719 10.43L27.4724 10.4343L27.4737 10.4473C27.4748 10.4577 27.4761 10.4718 27.4776 10.4893C27.4806 10.5243 27.4843 10.5732 27.4879 10.6344C27.4949 10.7568 27.5011 10.9293 27.499 11.1405C27.4947 11.5614 27.4573 12.144 27.3232 12.7927C27.0564 14.0825 26.389 15.7098 24.7596 16.7824C24.4137 17.0103 23.9486 16.9144 23.7208 16.5684C23.493 16.2225 23.5889 15.7573 23.9348 15.5296C25.1107 14.7555 25.6328 13.56 25.8542 12.4889C25.9506 12.0227 25.9866 11.5944 25.9964 11.2606H23.6953C23.2811 11.2606 22.9453 10.9248 22.9453 10.5106Z" fill="currentColor"/> </g> <defs> <filter id="filter0_d_2005_3470_4" x="0" y="0" width="35.4995" height="33.7167" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset/> <feGaussianBlur stdDeviation="4"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_3470"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_3470" result="shape"/> </filter> </defs> </svg></div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Telecom</div>
                                <div class="solutions__item-description">SIM registration and eSIM issue by document and face; re-verification on SIM swap.</div>
                            </div>
                        </div>
                        <div class="solutions__item">
                            <div class="solutions__item-icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="34" height="36" viewBox="0 0 34 36" fill="none"> <g filter="url(#filter0_d_2005_3090_5)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6469 9.5C10.9088 9.5 9.5 10.9088 9.5 12.6469V21.8816C9.5 23.6196 10.9088 25.0284 12.6469 25.0284H15.0989C15.5131 25.0284 15.8489 25.3642 15.8489 25.7784C15.8489 26.1927 15.5131 26.5284 15.0989 26.5284H12.6469C10.0804 26.5284 8 24.4481 8 21.8816V12.6469C8 10.0804 10.0804 8 12.6469 8H19.3606C21.9271 8 24.0074 10.0804 24.0074 12.6469V15.8305C24.0074 16.2447 23.6717 16.5805 23.2574 16.5805C22.8432 16.5805 22.5074 16.2447 22.5074 15.8305V12.6469C22.5074 10.9088 21.0986 9.5 19.3606 9.5H12.6469Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0205 14.4062C12.0205 13.992 12.3563 13.6562 12.7705 13.6562H16.6547C17.0689 13.6562 17.4047 13.992 17.4047 14.4062C17.4047 14.8205 17.0689 15.1562 16.6547 15.1562H12.7705C12.3563 15.1562 12.0205 14.8205 12.0205 14.4062ZM12.0195 18.6033C12.0195 18.189 12.3553 17.8533 12.7695 17.8533H14.3555C14.7698 17.8533 15.1056 18.189 15.1056 18.6033C15.1056 19.0175 14.7698 19.3533 14.3555 19.3533H12.7695C12.3553 19.3533 12.0195 19.0175 12.0195 18.6033Z" fill="currentColor"/> <path d="M20.8399 27.3504C20.6083 27.351 20.3788 27.306 20.1647 27.2178C19.9505 27.1296 19.7559 27 19.5919 26.8364L19.2589 26.5044C19.2078 26.4539 19.1388 26.4255 19.0669 26.4254H18.6019C18.1317 26.4246 17.681 26.2375 17.3487 25.9049C17.0163 25.5724 16.8294 25.1216 16.8289 24.6514V24.1834C16.8293 24.1463 16.8223 24.1095 16.8082 24.0751C16.7941 24.0408 16.7733 24.0096 16.7469 23.9834L16.4249 23.6614C16.0932 23.3306 15.906 22.8818 15.9044 22.4133C15.9027 21.9448 16.0866 21.4947 16.4159 21.1614L16.4459 21.1324L16.7459 20.8324C16.7966 20.7814 16.825 20.7124 16.8249 20.6404V20.1754C16.8257 19.7055 17.0126 19.2551 17.3447 18.9226C17.6767 18.5902 18.127 18.4028 18.5969 18.4014H19.0639C19.1361 18.4014 19.2054 18.373 19.2569 18.3224L19.5799 17.9994C19.9116 17.6663 20.3619 17.4783 20.832 17.4766C21.3022 17.4749 21.7538 17.6597 22.0879 17.9904L22.4189 18.3214C22.444 18.3468 22.4739 18.367 22.5068 18.3807C22.5398 18.3945 22.5752 18.4015 22.6109 18.4014H23.0779C23.5482 18.402 23.9991 18.589 24.3317 18.9216C24.6643 19.2542 24.8513 19.7051 24.8519 20.1754V20.6414C24.8522 20.7131 24.8802 20.7818 24.9299 20.8334L25.2559 21.1594C25.5881 21.4915 25.7751 21.9416 25.7762 22.4112C25.7774 22.8808 25.5924 23.3318 25.2619 23.6654L24.9289 23.9984C24.8796 24.0489 24.8523 24.1169 24.8529 24.1874V24.6554C24.8524 25.1254 24.6654 25.576 24.3329 25.9082C24.0005 26.2404 23.5499 26.4272 23.0799 26.4274H22.6099C22.5747 26.4273 22.5397 26.4341 22.5071 26.4475C22.4745 26.4609 22.4449 26.4806 22.4199 26.5054L22.0909 26.8324C21.9277 26.9976 21.7334 27.1288 21.5192 27.2184C21.3049 27.308 21.0751 27.3543 20.8429 27.3544L20.8399 27.3504ZM17.4679 22.2304C17.4228 22.283 17.3992 22.3507 17.402 22.4199C17.4048 22.4891 17.4337 22.5547 17.4829 22.6034L17.8109 22.9324C18.1424 23.2644 18.3287 23.7143 18.3289 24.1834V24.6514C18.3289 24.7239 18.3576 24.7935 18.4088 24.8448C18.46 24.8962 18.5294 24.9252 18.6019 24.9254H19.0669C19.5357 24.9263 19.9852 25.1121 20.3179 25.4424L20.6429 25.7664C20.669 25.793 20.7001 25.814 20.7345 25.8282C20.7688 25.8425 20.8057 25.8497 20.8429 25.8494C20.8785 25.8497 20.9138 25.8427 20.9466 25.829C20.9794 25.8152 21.0091 25.795 21.0339 25.7694L21.3649 25.4394C21.5287 25.275 21.7237 25.1448 21.9382 25.0562C22.1528 24.9676 22.3827 24.9225 22.6149 24.9234H23.0839C23.1199 24.9236 23.1556 24.9166 23.1889 24.9028C23.2222 24.8891 23.2524 24.8689 23.2779 24.8434C23.329 24.7918 23.3577 24.7221 23.3579 24.6494V24.1834C23.3569 23.7154 23.5417 23.2662 23.8719 22.9344L24.2009 22.6054C24.2265 22.5799 24.2467 22.5496 24.2606 22.5162C24.2744 22.4828 24.2815 22.4471 24.2815 22.4109C24.2815 22.3748 24.2744 22.339 24.2606 22.3057C24.2467 22.2723 24.2265 22.242 24.2009 22.2164L23.8739 21.8884C23.7094 21.7244 23.579 21.5294 23.4902 21.3147C23.4015 21.0999 23.3562 20.8698 23.3569 20.6374V20.1714C23.3569 20.0988 23.3281 20.0291 23.2767 19.9777C23.2253 19.9263 23.1555 19.8974 23.0829 19.8974H22.6159C22.3835 19.8981 22.1532 19.8527 21.9385 19.7638C21.7237 19.6749 21.5288 19.5442 21.3649 19.3794L21.0399 19.0564L21.0249 19.0424C20.9748 18.9971 20.9095 18.9721 20.8419 18.9724C20.806 18.9723 20.7705 18.9794 20.7374 18.9931C20.7042 19.0068 20.6742 19.027 20.6489 19.0524L20.3229 19.3794C19.9895 19.7101 19.5394 19.8962 19.0699 19.8974H18.6039C18.5314 19.8977 18.4619 19.9267 18.4108 19.978C18.3596 20.0294 18.3309 20.0989 18.3309 20.1714V20.6374C18.3312 20.8696 18.2858 21.0995 18.1971 21.314C18.1084 21.5285 17.9781 21.7234 17.8139 21.8874L17.4889 22.2134L17.4679 22.2304ZM20.3659 24.1404C20.2672 24.1404 20.1695 24.1208 20.0784 24.0829C19.9872 24.0449 19.9045 23.9894 19.8349 23.9194L18.9149 22.9974C18.7785 22.8558 18.7031 22.6662 18.7051 22.4696C18.7071 22.2729 18.7862 22.0849 18.9255 21.9461C19.0647 21.8072 19.253 21.7286 19.4496 21.7272C19.6463 21.7257 19.8356 21.8016 19.9769 21.9384L20.3669 22.3284L21.7329 20.9624C21.8743 20.8258 22.0637 20.7501 22.2604 20.7517C22.457 20.7533 22.6451 20.8321 22.7842 20.9711C22.9234 21.1101 23.0023 21.2981 23.0041 21.4948C23.0059 21.6914 22.9304 21.8809 22.7939 22.0224L20.8939 23.9224C20.7535 24.0618 20.5637 24.1402 20.3659 24.1404Z" fill="currentColor"/> </g> <defs> <filter id="filter0_d_2005_3090_5" x="0" y="0" width="33.7761" height="35.3545" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset/> <feGaussianBlur stdDeviation="4"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_3090"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_3090" result="shape"/> </filter> </defs> </svg></div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Gambling &amp; betting</div>
                                <div class="solutions__item-description">Age 18+ verified from the document, self-exclusion lists screened, one person — one account.</div>
                            </div>
                        </div>
                        <div class="solutions__item">
                            <div class="solutions__item-icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none"> <g filter="url(#filter0_d_2005_4885_6)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9157 8.23611C17.4036 7.9213 18.032 7.9213 18.5199 8.23611L26.7206 13.5296C27.14 13.8021 27.3955 14.269 27.3955 14.7723V15.3471C27.3955 16.1643 26.7324 16.8262 25.9155 16.8262H9.52005C8.70319 16.8262 8.04005 16.1643 8.04005 15.3471V14.7723C8.04005 14.2686 8.29594 13.8012 8.71731 13.5288L16.9157 8.23611ZM17.7178 9.50369L9.54005 14.783V15.3262H25.8955V14.7824L17.7178 9.50369Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7178 12.2637C18.132 12.2637 18.4678 12.5995 18.4678 13.0137V13.0237C18.4678 13.4379 18.132 13.7737 17.7178 13.7737C17.3036 13.7737 16.9678 13.4379 16.9678 13.0237V13.0137C16.9678 12.5995 17.3036 12.2637 17.7178 12.2637Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.41673 24.2134C8.54392 23.6357 9.05628 23.2244 9.64746 23.2244H25.788C26.3792 23.2244 26.8917 23.6358 27.0188 24.2137L27.4055 25.9691C27.5776 26.7528 26.9826 27.4999 26.1758 27.4999H9.26065C8.45581 27.4999 7.8573 26.7554 8.02979 25.9696L8.41673 24.2134ZM9.84012 24.7244L9.55909 25.9999H25.8763L25.5953 24.7244H9.84012Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9448 15.3259C11.359 15.3259 11.6948 15.6617 11.6948 16.0759V23.9751C11.6948 24.3893 11.359 24.7251 10.9448 24.7251C10.5306 24.7251 10.1948 24.3893 10.1948 23.9751V16.0759C10.1948 15.6617 10.5306 15.3259 10.9448 15.3259ZM15.4589 15.3259C15.8731 15.3259 16.2089 15.6617 16.2089 16.0759V23.9751C16.2089 24.3893 15.8731 24.7251 15.4589 24.7251C15.0446 24.7251 14.7089 24.3893 14.7089 23.9751V16.0759C14.7089 15.6617 15.0446 15.3259 15.4589 15.3259ZM19.9748 15.3259C20.389 15.3259 20.7248 15.6617 20.7248 16.0759V23.9751C20.7248 24.3893 20.389 24.7251 19.9748 24.7251C19.5606 24.7251 19.2248 24.3893 19.2248 23.9751V16.0759C19.2248 15.6617 19.5606 15.3259 19.9748 15.3259ZM24.4888 15.3259C24.9031 15.3259 25.2388 15.6617 25.2388 16.0759V23.9751C25.2388 24.3893 24.9031 24.7251 24.4888 24.7251C24.0746 24.7251 23.7388 24.3893 23.7388 23.9751V16.0759C23.7388 15.6617 24.0746 15.3259 24.4888 15.3259Z" fill="currentColor"/> </g> <defs> <filter id="filter0_d_2005_4885_6" x="0" y="0" width="35.4353" height="35.5" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset/> <feGaussianBlur stdDeviation="4"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_4885"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_4885" result="shape"/> </filter> </defs> </svg></div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Government</div>
                                <div class="solutions__item-description">Citizen services and digital ID with on-premises deployment; data never leaves your jurisdiction.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products section" id="products" data-offset="24">
        <div class="container">
            <div class="products__wrapper">
                <div class="section__badge">Products</div>
                <div class="products__content">
                    <div class="products__info">
                        <div class="products__info-top">
                            <h2 class="products__title section__title">Our&nbsp;AI-Powered Identity Solutions</h2>
                            <p class="section__subtitle">Everything you need to verify, authenticate, and protect your customers — all in one powerful platform</p>
                        </div>
                        <div class="products__info-bottom">
                            <div class="products__info-description">Ready to transform your identity verification? Request a demo or talk to sales — we&rsquo;ll map the modules to your&nbsp;flow</div>
                            <div class="products__info-actions">
                                <button type="button" class="btn btn--primary open-callForm">
                                    <span class="btn__text">Request a Demo</span>
                                    <span class="btn__icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="currentColor"/> </svg></span>
                                </button>
                                <button type="button" class="btn btn--gray open-callForm2">
                                    <span class="btn__text">Talk to Sales</span>
                                    <span class="btn__icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <g> <path d="M21.7038 10.5393C21.3268 10.5393 21.0028 10.2563 20.9598 9.87334C20.5798 6.49734 17.9568 3.87734 14.5808 3.50234C14.1698 3.45634 13.8728 3.08634 13.9188 2.67434C13.9638 2.26334 14.3328 1.95634 14.7468 2.01234C18.8238 2.46434 21.9918 5.62834 22.4498 9.70534C22.4968 10.1173 22.1998 10.4883 21.7888 10.5343C21.7608 10.5373 21.7318 10.5393 21.7038 10.5393Z" fill="currentColor"/> <path d="M18.1625 10.5501C17.8105 10.5501 17.4975 10.3021 17.4275 9.9441C17.1395 8.4641 15.9985 7.3231 14.5205 7.0361C14.1135 6.9571 13.8485 6.5641 13.9275 6.1571C14.0065 5.7501 14.4095 5.4851 14.8065 5.5641C16.8875 5.9681 18.4945 7.5741 18.8995 9.6561C18.9785 10.0641 18.7135 10.4571 18.3075 10.5361C18.2585 10.5451 18.2105 10.5501 18.1625 10.5501Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.48215 16.8362C12.1952 21.5502 15.3332 22.7862 17.3152 22.7862C18.2932 22.7862 18.9912 22.4852 19.4562 22.1512C19.4772 22.1392 21.6292 20.8232 22.0062 18.8312C22.1842 17.8962 21.9242 16.9712 21.2562 16.1552C18.5042 12.8142 17.1022 13.1262 15.5542 13.8792C14.6032 14.3452 13.8522 14.7072 11.7312 12.5882C9.6114 10.4675 9.97707 9.7164 10.44 8.76556C11.194 7.21756 11.5042 5.81523 8.16215 3.06123C7.34815 2.39623 6.42915 2.13623 5.49515 2.31123C3.53215 2.67823 2.20815 4.79523 2.21015 4.79523C1.15815 6.27223 0.444153 9.79923 7.48215 16.8362ZM5.80115 3.77923C5.88915 3.76523 5.97615 3.75723 6.06215 3.75723C6.45415 3.75723 6.83215 3.91023 7.20915 4.22023C9.90413 6.44021 9.56316 7.14022 9.09116 8.1092C8.38216 9.5662 8.01115 10.9882 10.6702 13.6492C13.3322 16.3102 14.7552 15.9392 16.2102 15.2282L16.2126 15.227C17.1804 14.7566 17.8801 14.4165 20.0972 17.1082C20.4762 17.5702 20.6212 18.0322 20.5392 18.5192C20.3502 19.6392 19.0482 20.6422 18.6542 20.8862C17.2432 21.8922 13.8462 21.0792 8.54215 15.7762C3.24015 10.4732 2.42615 7.07623 3.46815 5.61123C3.67615 5.27223 4.68315 3.96823 5.80115 3.77923Z" fill="currentColor"/> </g> </g> </svg></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="products__slider">
                        <div class="products__slider-head">
                            <div class="products__slider-tabs" role="tablist" aria-label="Identity solutions">
                            <button type="button" role="tab" id="products-tab-1" aria-controls="products-panel-1"
                                    aria-selected="true" tabindex="0"
                                    class="products__slider-tab products__slider-tab--active">KYC / eKYC</button>
                            <button type="button" role="tab" id="products-tab-2" aria-controls="products-panel-2"
                                    aria-selected="false" tabindex="-1"
                                    class="products__slider-tab">AML &amp; Sanctions</button>
                            <button type="button" role="tab" id="products-tab-3" aria-controls="products-panel-3"
                                    aria-selected="false" tabindex="-1"
                                    class="products__slider-tab">KYB</button>
                            <button type="button" role="tab" id="products-tab-4" aria-controls="products-panel-4"
                                    aria-selected="false" tabindex="-1"
                                    class="products__slider-tab">KYT</button>
                            <button type="button" role="tab" id="products-tab-5" aria-controls="products-panel-5"
                                    aria-selected="false" tabindex="-1"
                                    class="products__slider-tab">Liveness &amp; Face Authentication</button>
                            <button type="button" role="tab" id="products-tab-6" aria-controls="products-panel-6"
                                    aria-selected="false" tabindex="-1"
                                    class="products__slider-tab">NeuroPay</button>
                            </div>
                            <div class="products__slider-arrows">
                                <button type="button" class="products__slider-arrow products__slider-arrow--prev products__slider-arrow--disabled" aria-label="Previous solution"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M10.0137 5.55638C10.3648 5.41074 10.7767 5.55248 10.9609 5.89427C11.1571 6.25876 11.0206 6.71341 10.6562 6.90989C10.6558 6.91012 10.6545 6.91025 10.6533 6.91087C10.651 6.91211 10.6476 6.91498 10.6426 6.91771C10.6324 6.92326 10.6164 6.93165 10.5957 6.9431C10.5541 6.96614 10.4925 7.00122 10.4131 7.04661C10.2537 7.13776 10.0238 7.27144 9.74805 7.44114C9.19501 7.78144 8.46189 8.26111 7.73242 8.82103C6.99842 9.38445 6.29193 10.011 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5894 5.77637 13.9079C6.29187 14.5388 6.99755 15.1651 7.73145 15.7283C8.46104 16.288 9.19491 16.7669 9.74805 17.1072C10.0236 17.2766 10.2527 17.4106 10.4121 17.5017C10.4916 17.5471 10.5541 17.5821 10.5957 17.6052C10.6165 17.6167 10.6324 17.626 10.6426 17.6316C10.6475 17.6342 10.6511 17.6362 10.6533 17.6374L10.6562 17.6384L10.7217 17.6784C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9577C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.9539 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9306 9.86914 18.9177C9.82212 18.8916 9.75372 18.8534 9.66797 18.8044C9.49654 18.7064 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.337 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2728 3.50097 12.2715 3.50098 12.2702C3.50295 11.3213 4.01126 10.4325 4.61426 9.69407C5.23299 8.93645 6.03997 8.22909 6.81836 7.63157C7.60128 7.0306 8.38067 6.52145 8.96191 6.1638C9.25325 5.98453 9.49653 5.84191 9.66797 5.74388C9.75368 5.69487 9.82214 5.65763 9.86914 5.63157C9.89234 5.61871 9.91016 5.60823 9.92285 5.6013C9.92922 5.59782 9.93494 5.59443 9.93848 5.59251C9.94003 5.59167 9.94143 5.59107 9.94238 5.59056L9.94336 5.58958H9.94434L10.0137 5.55638Z" fill="currentColor"/> </svg></button>
                                <button type="button" class="products__slider-arrow products__slider-arrow--next" aria-label="Next solution"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="currentColor"/> </svg></button>
                            </div>
                        </div>
                        <div class="products__slider-content-swiper swiper">
                            <div class="products__slider-list swiper-wrapper">
                                    <div class="products__slide products__slide--active swiper-slide" role="tabpanel"
                                         id="products-panel-1" aria-labelledby="products-tab-1">
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Know Your Customer</div>
                                            <div class="products__slide-subtitle">A real person with a real document — verified in&nbsp;seconds</div>
                                            <div class="products__slidedescription">Document capture · face match 99.74% · liveness · anti-fraud and 1:N deduplication · AML screening.</div>
                                        </div>
                                        <div class="products__slide-action">
                                            <a href="/solutions/#solutions" class="btn btn--small btn--primary">
                                                <span class="btn__text">Learn more</span>
                                                <span class="btn__icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="currentColor"/> </svg></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="products__slide swiper-slide" role="tabpanel"
                                         id="products-panel-2" aria-labelledby="products-tab-2">
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">AML &amp; Sanctions</div>
                                            <div class="products__slide-subtitle">1,700+ databases, one API&nbsp;call.</div>
                                            <div class="products__slidedescription">OFAC, EU, UK, UN and national lists · PEP and adverse media · daily re-screening with alerts and an audit trail.</div>
                                        </div>
                                    </div>
                                    <div class="products__slide swiper-slide" role="tabpanel"
                                         id="products-panel-3" aria-labelledby="products-tab-3">
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Know Your Business</div>
                                            <div class="products__slide-subtitle">Find out who you are signing&nbsp;with</div>
                                            <div class="products__slidedescription">Corporate structure down to UBO · registry checks: bankruptcy, litigation, sanctions, tax debts · signatory verification.</div>
                                        </div>
                                        <div class="products__slide-action">
                                            <a href="/solutions/#solutions" class="btn btn--small btn--primary">
                                                <span class="btn__text">Learn more</span>
                                                <span class="btn__icon"><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="currentColor"/> </svg></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="products__slide swiper-slide" role="tabpanel"
                                         id="products-panel-4" aria-labelledby="products-tab-4">
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Know Your Transaction</div>
                                            <div class="products__slide-subtitle">On-chain, in real&nbsp;time</div>
                                            <div class="products__slidedescription">Risk scoring of wallets and transactions · fund-flow monitoring · AML/CFT flags for exchanges, OTC desks and wallets.</div>
                                        </div>
                                    </div>
                                    <div class="products__slide swiper-slide" role="tabpanel"
                                         id="products-panel-5" aria-labelledby="products-tab-5">
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Liveness &amp; Face Authentication</div>
                                            <div class="products__slide-subtitle">A live person, not a photo, video or&nbsp;mask</div>
                                            <div class="products__slidedescription">Active liveness · deepfake and injection protection · password-free login with the same face&nbsp;engine.</div>
                                        </div>
                                    </div>
                                    <div class="products__slide swiper-slide" role="tabpanel"
                                         id="products-panel-6" aria-labelledby="products-tab-6">
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">NeuroPay</div>
                                            <div class="products__slide-subtitle">Pay by face or&nbsp;palm</div>
                                            <div class="products__slidedescription">FacePay production-ready, PalmPay in pilot · online and at the counter · customers keep paying on your&nbsp;rails.</div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how section" id="how-it-works">
        <div class="container">
            <div class="section__wrapper how__wrapper">
                <div class="section__badge">How it works</div>
                <div class="section__content how__content">
                    <div class="section__title-block">
                        <h2 class="section__title">Five checks, one pass <span>&mdash; in seconds</span></h2>
                    </div>
                    <div class="how__layout">
                        <ol class="how__steps">
                            <li class="how__step">
                                <span class="how__step-number" aria-hidden="true">01</span>
                                <div class="how__step-info">
                                    <h3 class="how__step-title">Document capture</h3>
                                    <p class="how__step-description">16,000+ document types from 195+ countries and territories</p>
                                </div>
                            </li>
                            <li class="how__step">
                                <span class="how__step-number" aria-hidden="true">02</span>
                                <div class="how__step-info">
                                    <h3 class="how__step-title">Face match</h3>
                                    <p class="how__step-description">Selfie against the document photo, age verified from the document</p>
                                </div>
                            </li>
                            <li class="how__step">
                                <span class="how__step-number" aria-hidden="true">03</span>
                                <div class="how__step-info">
                                    <h3 class="how__step-title">Liveness</h3>
                                    <p class="how__step-description">a real, present person; deepfake-resistant</p>
                                </div>
                            </li>
                            <li class="how__step">
                                <span class="how__step-number" aria-hidden="true">04</span>
                                <div class="how__step-info">
                                    <h3 class="how__step-title">Anti-fraud &amp; 1:N deduplication</h3>
                                    <p class="how__step-description">40+ algorithms; one person, one account</p>
                                </div>
                            </li>
                            <li class="how__step">
                                <span class="how__step-number" aria-hidden="true">05</span>
                                <div class="how__step-info">
                                    <h3 class="how__step-title">AML screening</h3>
                                    <p class="how__step-description">sanctions, PEP, watchlists and self-exclusion lists</p>
                                </div>
                            </li>
                        </ol>

                        <div class="how__highlight">
                            <span class="how__highlight-icon">
                                <svg aria-hidden="true" focusable="false" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M23.5206 7.9794C14.6722 7.9794 7.5 15.1516 7.5 24C7.5 32.8484 14.6722 40.0206 23.5206 40.0206C32.369 40.0206 39.5412 32.8484 39.5412 24C39.5412 15.1516 32.369 7.9794 23.5206 7.9794ZM4.5 24C4.5 13.4948 13.0154 4.9794 23.5206 4.9794C34.0258 4.9794 42.5412 13.4948 42.5412 24C42.5412 34.5052 34.0258 43.0206 23.5206 43.0206C13.0154 43.0206 4.5 34.5052 4.5 24Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M43.3108 10.07C43.7154 10.7929 43.4574 11.7069 42.7346 12.1116C33.518 17.2711 27.755 25.6476 25.0056 30.8126C24.7512 31.2906 24.259 31.5942 23.7176 31.6072C23.1762 31.6202 22.67 31.3406 22.3928 30.8754C20.5476 27.7778 18.2072 25.021 15.3525 22.6102C14.7196 22.0756 14.6398 21.1292 15.1744 20.4964C15.7089 19.8634 16.6553 19.7836 17.2882 20.3182C19.726 22.377 21.828 24.6764 23.5962 27.2112C26.8372 21.7898 32.5964 14.349 41.2692 9.49386C41.992 9.0892 42.9062 9.34716 43.3108 10.07Z" fill="currentColor"/></svg>
                            </span>
                            <div class="how__highlight-info">
                                <h3 class="how__highlight-title">Every check in under a second</h3>
                                <p class="how__highlight-description">auto-approve, decline or route to manual review, by your scenario.</p>
                            </div>
                        </div>

                        <div class="how__deploy">
                            <article class="how__deploy-card">
                                <div class="how__deploy-info">
                                    <h3 class="how__deploy-title">Cloud</h3>
                                    <p class="how__deploy-description">fault-tolerant cluster, sandbox first, production next</p>
                                </div>
                                <span class="how__deploy-image how__deploy-image--cloud">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/how-cloud.webp'); ?>"
                                         srcset="<?php echo esc_url(get_template_directory_uri() . '/img/how-cloud.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/how-cloud@2x.webp'); ?> 2x"
                                         width="239" height="239" alt="" aria-hidden="true" loading="lazy" decoding="async">
                                </span>
                            </article>
                            <article class="how__deploy-card">
                                <div class="how__deploy-info">
                                    <h3 class="how__deploy-title">On-premises or hybrid</h3>
                                    <p class="how__deploy-description">in your data centres; templates and personal data never leave your jurisdiction.</p>
                                </div>
                                <span class="how__deploy-image how__deploy-image--onprem">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/how-onprem.webp'); ?>"
                                         srcset="<?php echo esc_url(get_template_directory_uri() . '/img/how-onprem.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/how-onprem@2x.webp'); ?> 2x"
                                         width="217" height="217" alt="" aria-hidden="true" loading="lazy" decoding="async">
                                </span>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="advantages section" id="advantages">
        <div class="container">
            <div class="section__wrapper advantages__wrapper">
                <div class="section__badge">Why us</div>
                <div class="section__content advantages__content">
                    <div class="section__title-block">
                        <h2 class="section__title">Why Teams Choose <span>NeuroVision Global Systems</span></h2>
                    </div>
                    <div class="advantages__layout">
                        <div class="advantages__col">
                            <article class="advantage__item">
                                <h3 class="advantage__item-title">Accuracy you can audit</h3>
                                <p class="advantage__item-description">16,000+ document types from 195+ countries and territories</p>
                            </article>
                            <article class="advantage__item">
                                <h3 class="advantage__item-title">Live in under an hour</h3>
                                <p class="advantage__item-description">REST API, Web SDK, iOS and Android SDK, WebView; sandbox first.</p>
                            </article>
                            <article class="advantage__item">
                                <h3 class="advantage__item-title">Global coverage</h3>
                                <p class="advantage__item-description">195+ countries and territories, 16,000+ document types, 90+ languages.</p>
                            </article>
                        </div>

                        <div class="advantages__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/why-us-phones.webp'); ?>"
                                 srcset="<?php echo esc_url(get_template_directory_uri() . '/img/why-us-phones.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/why-us-phones@2x.webp'); ?> 2x"
                                 width="434" height="525"
                                 alt="Экраны приложения NeuroVision Global Systems: съёмка документа и селфи с паспортом"
                                 loading="lazy" decoding="async">
                        </div>

                        <div class="advantages__col">
                            <article class="advantage__item">
                                <h3 class="advantage__item-title">Anti-fraud built on real attacks</h3>
                                <p class="advantage__item-description">40+ document checks, 1:N face search, blacklist screening, 30 more layers</p>
                            </article>
                            <article class="advantage__item">
                                <h3 class="advantage__item-title">Privacy by design</h3>
                                <p class="advantage__item-description">ISO/IEC 27001:2022, GDPR-ready; on-premises, cloud or hybrid.</p>
                            </article>
                            <article class="advantage__item">
                                <h3 class="advantage__item-title">In-house engines only</h3>
                                <p class="advantage__item-description">OCR, face, liveness and anti-fraud are ours: one vendor, one SLA, no third-party licences</p>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="clients section" id="clients">
        <div class="container">
            <div class="clients__wrapper section__wrapper">
                <div class="clients__top">
                    <div class="clients__top-info">
                        <div class="section__badge">Clients</div>
                        <div class="section__content">
                            <div class="section__title-block">
                                <h2 class="section__title">Trusted by Industry Leaders Worldwide</h2>
                                <p class="section__subtitle">Leading banks, crypto exchanges, and government agencies choose NeuroVision Global Systems</p>
                            </div>
                            <p class="section__description">From fintech startups to Fortune 500 companies, organizations trust our AI-powered identity verification to protect their users and streamline operations</p>
                        </div>
                    </div>
                </div>
                <div class="clients__content">
                    <img class="clients__map"
                         src="<?php echo esc_url(get_template_directory_uri() . '/img/clients-map.webp'); ?>"
                         srcset="<?php echo esc_url(get_template_directory_uri() . '/img/clients-map.webp'); ?> 1x, <?php echo esc_url(get_template_directory_uri() . '/img/clients-map@2x.webp'); ?> 2x"
                         width="1376" height="340" alt="" aria-hidden="true" loading="lazy" decoding="async">
                    <div class="clients__list">
                        <div class="clients__item clients__item--bank" tabindex="0" role="button"
                             aria-label="Banks. Powering secure digital onboarding">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Banks</div>
                                <div class="clients__item-description">Powering secure digital onboarding</div>
                            </div>
                            <div class="clients__item-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M26.522 27V16.3385H27.3074C27.8597 16.3385 28.3074 15.8908 28.3074 15.3385C28.3074 14.7863 27.8597 14.3385 27.3074 14.3385H26.4751C26.0025 9.32546 22.0128 5.33536 16.9997 4.86241L17.0002 4.00057C17.0005 3.44828 16.553 3.00032 16.0008 3C15.4485 2.99968 15.0005 3.44715 15.0002 3.99943L14.9997 4.86228C9.98612 5.33463 5.99535 9.32497 5.52265 14.3385H4.69189C4.13961 14.3385 3.69189 14.7863 3.69189 15.3385C3.69189 15.8908 4.13961 16.3385 4.69189 16.3385H5.47575V27H4.69189C4.13961 27 3.69189 27.4477 3.69189 28C3.69189 28.5523 4.13961 29 4.69189 29H6.47575H11.2392H16.0001H20.761H25.522H27.3074C27.8597 29 28.3074 28.5523 28.3074 28C28.3074 27.4477 27.8597 27 27.3074 27H26.522ZM24.522 27V16.3385H21.761V27H24.522ZM19.761 27V16.3385H17.0001V27H19.761ZM15.0001 27V16.3385H12.2392V27H15.0001ZM10.2392 27V16.3385H7.47575V27H10.2392ZM24.4639 14.3385H20.761H16.0001H11.2392H7.5338C8.02894 10.1028 11.6305 6.81544 15.999 6.81544C20.3677 6.81544 23.9688 10.1028 24.4639 14.3385Z" fill="currentColor" fill-opacity="0.5"/> </svg></div>
                        </div>
                        <div class="clients__item clients__item--crypto" tabindex="0" role="button"
                             aria-label="Crypto Exchanges. Enabling compliant KYC verification">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Crypto Exchanges</div>
                                <div class="clients__item-description">Enabling compliant KYC verification</div>
                            </div>
                            <div class="clients__item-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.08593 11.8098C3.08593 6.96494 7.01862 3.04443 11.85 3.04443C16.6941 3.04443 20.6153 6.96573 20.6153 11.8098C20.6153 12.0615 20.6019 12.2978 20.5903 12.5027L20.5899 12.5096C20.5584 13.061 20.086 13.4826 19.5345 13.4511C18.9832 13.4198 18.5617 12.9472 18.5931 12.3959C18.6052 12.1826 18.6153 11.9989 18.6153 11.8098C18.6153 8.07029 15.5895 5.04443 11.85 5.04443C8.12164 5.04443 5.08593 8.07107 5.08593 11.8098C5.08593 15.5374 8.12241 18.5739 11.85 18.5739C12.025 18.5739 12.1906 18.5654 12.3845 18.5555C12.4035 18.5546 12.4228 18.5535 12.4423 18.5526C12.9939 18.5247 13.4637 18.9491 13.4916 19.5007C13.5196 20.0523 13.095 20.522 12.5435 20.55C12.5237 20.551 12.5035 20.552 12.483 20.5531C12.2957 20.5627 12.0791 20.5739 11.85 20.5739C7.01784 20.5739 3.08593 16.6419 3.08593 11.8098Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.474 20.1926C11.474 15.3523 15.398 11.4299 20.2367 11.4299C25.0768 11.4299 28.9995 15.3524 28.9995 20.1926C28.9995 25.0327 25.0768 28.9554 20.2367 28.9554C15.398 28.9554 11.474 25.0328 11.474 20.1926ZM20.2367 13.4299C16.5024 13.4299 13.474 16.4571 13.474 20.1926C13.474 23.928 16.5024 26.9554 20.2367 26.9554C23.9723 26.9554 26.9995 23.9282 26.9995 20.1926C26.9995 16.4571 23.9723 13.4299 20.2367 13.4299Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.79598 20.8391C4.33664 20.7264 4.86634 21.0732 4.97913 21.6139C5.46168 23.9271 7.13897 25.8523 9.39666 26.628C9.91898 26.8074 10.1969 27.3763 10.0175 27.8987C9.83802 28.421 9.26913 28.6988 8.74681 28.5195C5.81608 27.5126 3.64653 25.0196 3.02128 22.0223C2.90849 21.4816 3.25534 20.9519 3.79598 20.8391Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.69 3.87863C21.8695 3.35631 22.4383 3.07837 22.9607 3.25782C25.8913 4.26475 28.0609 6.75761 28.6861 9.75498C28.7989 10.2956 28.4521 10.8253 27.9115 10.9381C27.3708 11.0509 26.8411 10.704 26.7283 10.1634C26.2457 7.85014 24.5684 5.92499 22.3108 5.1493C21.7884 4.96985 21.5105 4.40095 21.69 3.87863Z" fill="currentColor" fill-opacity="0.5"/> </svg></div>
                        </div>
                        <div class="clients__item clients__item--goverment" tabindex="0" role="button"
                             aria-label="Government. Securing citizen identity services">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Government</div>
                                <div class="clients__item-description">Securing citizen identity services</div>
                            </div>
                            <div class="clients__item-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9305 3.31481C15.5811 2.89506 16.4189 2.89506 17.0695 3.31481L28.0037 10.3728C28.5629 10.7361 28.9036 11.3586 28.9036 12.0297V12.7962C28.9036 13.8857 28.0195 14.7683 26.9303 14.7683H5.0697C3.98055 14.7683 3.09636 13.8857 3.09636 12.7962V12.0297C3.09636 11.3582 3.43755 10.7349 3.99938 10.3717L14.9305 3.31481ZM16 5.00492L5.09636 12.0441V12.7682H26.9036V12.0432L16 5.00492Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 8.68489C16.5523 8.68489 17 9.13261 17 9.68489V9.69822C17 10.2505 16.5523 10.6982 16 10.6982C15.4477 10.6982 15 10.2505 15 9.69822V9.68489C15 9.13261 15.4477 8.68489 16 8.68489Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.5986 24.6179C3.76819 23.8476 4.45134 23.2992 5.23958 23.2992H26.7603C27.5485 23.2992 28.2319 23.8477 28.4013 24.6183L28.9169 26.9588C29.1464 28.0037 28.3531 28.9999 27.2773 28.9999H4.72383C3.65071 28.9999 2.8527 28.0072 3.08268 26.9595L3.5986 24.6179ZM5.49646 25.2992L5.12175 26.9999H26.878L26.5033 25.2992H5.49646Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.9694 12.7679C7.52168 12.7679 7.9694 13.2156 7.9694 13.7679V24.3001C7.9694 24.8524 7.52168 25.3001 6.9694 25.3001C6.41712 25.3001 5.9694 24.8524 5.9694 24.3001V13.7679C5.9694 13.2156 6.41712 12.7679 6.9694 12.7679ZM12.9881 12.7679C13.5404 12.7679 13.9881 13.2156 13.9881 13.7679V24.3001C13.9881 24.8524 13.5404 25.3001 12.9881 25.3001C12.4358 25.3001 11.9881 24.8524 11.9881 24.3001V13.7679C11.9881 13.2156 12.4358 12.7679 12.9881 12.7679ZM19.0093 12.7679C19.5616 12.7679 20.0093 13.2156 20.0093 13.7679V24.3001C20.0093 24.8524 19.5616 25.3001 19.0093 25.3001C18.4571 25.3001 18.0093 24.8524 18.0093 24.3001V13.7679C18.0093 13.2156 18.4571 12.7679 19.0093 12.7679ZM25.028 12.7679C25.5804 12.7679 26.028 13.2156 26.028 13.7679V24.3001C26.028 24.8524 25.5804 25.3001 25.028 25.3001C24.4757 25.3001 24.028 24.8524 24.028 24.3001V13.7679C24.028 13.2156 24.4757 12.7679 25.028 12.7679Z" fill="currentColor" fill-opacity="0.5"/> </svg></div>
                        </div>
                        <div class="clients__item clients__item--insurance" tabindex="0" role="button"
                             aria-label="Insurance. Accelerating claim processing">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Insurance</div>
                                <div class="clients__item-description">Accelerating claim processing</div>
                            </div>
                            <div class="clients__item-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9822 5C8.66478 5 6.78638 6.8784 6.78638 9.19581V21.5088C6.78638 23.8261 8.66478 25.7045 10.9822 25.7045H14.2515C14.8038 25.7045 15.2515 26.1523 15.2515 26.7045C15.2515 27.2569 14.8038 27.7045 14.2515 27.7045H10.9822C7.56022 27.7045 4.78638 24.9308 4.78638 21.5088V9.19581C4.78638 5.77383 7.56022 3 10.9822 3H19.9338C23.3558 3 26.1295 5.77383 26.1295 9.19581V13.4407C26.1295 13.9929 25.6819 14.4407 25.1295 14.4407C24.5773 14.4407 24.1295 13.9929 24.1295 13.4407V9.19581C24.1295 6.8784 22.2511 5 19.9338 5H10.9822Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.147 11.5417C10.147 10.9894 10.5947 10.5417 11.147 10.5417H16.3259C16.8782 10.5417 17.3259 10.9894 17.3259 11.5417C17.3259 12.0939 16.8782 12.5417 16.3259 12.5417H11.147C10.5947 12.5417 10.147 12.0939 10.147 11.5417ZM10.1458 17.1377C10.1458 16.5853 10.5935 16.1377 11.1458 16.1377H13.2604C13.8127 16.1377 14.2605 16.5853 14.2605 17.1377C14.2605 17.69 13.8127 18.1377 13.2604 18.1377H11.1458C10.5935 18.1377 10.1458 17.69 10.1458 17.1377Z" fill="currentColor" fill-opacity="0.5"/> <path d="M21.9062 28.8005C21.5974 28.8013 21.2914 28.7413 21.0059 28.6237C20.7203 28.5061 20.4609 28.3333 20.2422 28.1152L19.7982 27.6725C19.7301 27.6052 19.6381 27.5673 19.5422 27.5672H18.9222C18.2953 27.5661 17.6943 27.3167 17.2513 26.8732C16.8081 26.4299 16.5589 25.8288 16.5582 25.2019V24.5779C16.5587 24.5284 16.5494 24.4793 16.5306 24.4335C16.5118 24.3877 16.4841 24.3461 16.4489 24.3112L16.0195 23.8819C15.5773 23.4408 15.3277 22.8424 15.3255 22.2177C15.3233 21.5931 15.5685 20.9929 16.0075 20.5485L16.0475 20.5099L16.4475 20.1099C16.5151 20.0419 16.553 19.9499 16.5529 19.8539V19.2339C16.5539 18.6073 16.8031 18.0068 17.2459 17.5635C17.6886 17.1203 18.289 16.8704 18.9155 16.8685H19.5382C19.6345 16.8685 19.7269 16.8307 19.7955 16.7632L20.2262 16.3325C20.6685 15.8884 21.2689 15.6377 21.8957 15.6355C22.5226 15.6332 23.1247 15.8796 23.5702 16.3205L24.0115 16.7619C24.045 16.7957 24.0849 16.8227 24.1287 16.8409C24.1727 16.8593 24.2199 16.8687 24.2675 16.8685H24.8902C25.5173 16.8693 26.1185 17.1187 26.5619 17.5621C27.0054 18.0056 27.2547 18.6068 27.2555 19.2339V19.8552C27.2559 19.9508 27.2933 20.0424 27.3595 20.1112L27.7942 20.5459C28.2371 20.9887 28.4865 21.5888 28.4879 22.2149C28.4895 22.8411 28.2429 23.4424 27.8022 23.8872L27.3582 24.3312C27.2925 24.3985 27.2561 24.4892 27.2569 24.5832V25.2072C27.2562 25.8339 27.0069 26.4347 26.5635 26.8776C26.1203 27.3205 25.5195 27.5696 24.8929 27.5699H24.2662C24.2193 27.5697 24.1726 27.5788 24.1291 27.5967C24.0857 27.6145 24.0462 27.6408 24.0129 27.6739L23.5742 28.1099C23.3566 28.3301 23.0975 28.5051 22.8119 28.6245C22.5262 28.744 22.2198 28.8057 21.9102 28.8059L21.9062 28.8005ZM17.4102 21.9739C17.3501 22.044 17.3186 22.1343 17.3223 22.2265C17.3261 22.3188 17.3646 22.4063 17.4302 22.4712L17.8675 22.9099C18.3095 23.3525 18.5579 23.9524 18.5582 24.5779V25.2019C18.5582 25.2985 18.5965 25.3913 18.6647 25.4597C18.733 25.5283 18.8255 25.5669 18.9222 25.5672H19.5422C20.1673 25.5684 20.7666 25.8161 21.2102 26.2565L21.6435 26.6885C21.6783 26.724 21.7198 26.752 21.7657 26.7709C21.8114 26.79 21.8606 26.7996 21.9102 26.7992C21.9577 26.7996 22.0047 26.7903 22.0485 26.772C22.0922 26.7536 22.1318 26.7267 22.1649 26.6925L22.6062 26.2525C22.8246 26.0333 23.0846 25.8597 23.3706 25.7416C23.6567 25.6235 23.9633 25.5633 24.2729 25.5645H24.8982C24.9462 25.5648 24.9938 25.5555 25.0382 25.5371C25.0826 25.5188 25.1229 25.4919 25.1569 25.4579C25.225 25.3891 25.2633 25.2961 25.2635 25.1992V24.5779C25.2622 23.9539 25.5086 23.3549 25.9489 22.9125L26.3875 22.4739C26.4217 22.4399 26.4486 22.3995 26.4671 22.3549C26.4855 22.3104 26.495 22.2628 26.495 22.2145C26.495 22.1664 26.4855 22.1187 26.4671 22.0743C26.4486 22.0297 26.4217 21.9893 26.3875 21.9552L25.9515 21.5179C25.7322 21.2992 25.5583 21.0392 25.4399 20.7529C25.3217 20.4665 25.2613 20.1597 25.2622 19.8499V19.2285C25.2622 19.1317 25.2238 19.0388 25.1553 18.9703C25.0867 18.9017 24.9937 18.8632 24.8969 18.8632H24.2742C23.9643 18.8641 23.6573 18.8036 23.371 18.6851C23.0846 18.5665 22.8247 18.3923 22.6062 18.1725L22.1729 17.7419L22.1529 17.7232C22.0861 17.6628 21.999 17.6295 21.9089 17.6299C21.861 17.6297 21.8137 17.6392 21.7695 17.6575C21.7253 17.6757 21.6853 17.7027 21.6515 17.7365L21.2169 18.1725C20.7723 18.6135 20.1722 18.8616 19.5462 18.8632H18.9249C18.8282 18.8636 18.7355 18.9023 18.6674 18.9707C18.5991 19.0392 18.5609 19.1319 18.5609 19.2285V19.8499C18.5613 20.1595 18.5007 20.466 18.3825 20.752C18.2642 21.038 18.0905 21.2979 17.8715 21.5165L17.4382 21.9512L17.4102 21.9739ZM21.2742 24.5205C21.1426 24.5205 21.0123 24.4944 20.8909 24.4439C20.7693 24.3932 20.659 24.3192 20.5662 24.2259L19.3395 22.9965C19.1577 22.8077 19.0571 22.5549 19.0598 22.2928C19.0625 22.0305 19.1679 21.7799 19.3537 21.5948C19.5393 21.4096 19.7903 21.3048 20.0525 21.3029C20.3147 21.3009 20.5671 21.4021 20.7555 21.5845L21.2755 22.1045L23.0969 20.2832C23.2854 20.1011 23.5379 20.0001 23.8002 20.0023C24.0623 20.0044 24.3131 20.1095 24.4986 20.2948C24.6842 20.4801 24.7894 20.7308 24.7918 20.9931C24.7942 21.2552 24.6935 21.5079 24.5115 21.6965L21.9782 24.2299C21.791 24.4157 21.5379 24.5203 21.2742 24.5205Z" fill="currentColor" fill-opacity="0.5"/> </svg></div>
                        </div>
                        <div class="clients__item clients__item--gambling" tabindex="0" role="button"
                             aria-label="Gambling. Verifying age and identity instantly">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Gambling</div>
                                <div class="clients__item-description">Verifying age and identity instantly</div>
                            </div>
                            <div class="clients__item-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.22528 4.48208C7.41284 4.29442 7.66729 4.18896 7.93261 4.18896H24.0665C24.6188 4.18896 25.0665 4.63668 25.0665 5.18896H24.0665C25.0665 5.18896 25.0665 5.18896 25.0665 5.18896V5.20382L25.0663 5.23915C25.066 5.26938 25.0655 5.31283 25.0644 5.36863C25.0623 5.48022 25.0581 5.64128 25.05 5.84479C25.0336 6.25156 25.0011 6.82922 24.9363 7.52111C24.8068 8.90015 24.5471 10.7553 24.0213 12.6238C23.4989 14.4805 22.6935 16.4254 21.4291 17.9233C20.3269 19.2289 18.8692 20.1974 16.9955 20.4513V22.1134H20.3199C20.7547 22.1134 21.1397 22.3945 21.2723 22.8088L22.2329 25.8108H23.6591C24.2113 25.8108 24.6591 26.2585 24.6591 26.8108C24.6591 27.363 24.2113 27.8108 23.6591 27.8108H21.5329C21.5128 27.8114 21.4927 27.8114 21.4725 27.8108H10.7187C10.6986 27.8114 10.6785 27.8114 10.6583 27.8108H8.53188C7.9796 27.8108 7.53188 27.363 7.53188 26.8108C7.53188 26.2585 7.9796 25.8108 8.53188 25.8108H9.95835L10.919 22.8088C11.0515 22.3945 11.4366 22.1134 11.8714 22.1134H14.9955V20.4492C13.1297 20.1918 11.6769 19.2252 10.5774 17.9234C9.31243 16.4258 8.5059 14.4809 7.98242 12.6244C7.45556 10.7559 7.19463 8.90075 7.06443 7.52171C6.99911 6.82983 6.96619 6.25219 6.94959 5.84542C6.94128 5.64191 6.93704 5.48084 6.93488 5.36927C6.9338 5.31347 6.93323 5.27 6.93293 5.23978L6.93267 5.20446L6.93262 5.19136C6.93262 5.19136 6.93261 5.1896 7.93261 5.18896L6.93262 5.1896C6.93246 4.92427 7.03774 4.66976 7.22528 4.48208ZM8.96875 6.18896C8.98697 6.51028 9.01439 6.8974 9.05557 7.33372C9.17901 8.64119 9.4242 10.3681 9.90735 12.0816C10.3939 13.807 11.1012 15.4441 12.1053 16.633C13.0843 17.7921 14.332 18.517 16.0035 18.517C17.6752 18.517 18.9225 17.7921 19.9008 16.6332C20.9043 15.4445 21.6105 13.8076 22.096 12.0821C22.5781 10.3687 22.8223 8.64179 22.9449 7.33434C22.9859 6.89775 23.0131 6.5104 23.0311 6.18896H8.96875ZM15.9585 24.1134H12.6014L12.0583 25.8108H20.1329L19.5899 24.1134H16.0324C16.0201 24.114 16.0079 24.1141 15.9955 24.1141C15.9831 24.1141 15.9708 24.114 15.9585 24.1134Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.03709 7.42492C3.09387 6.91896 3.52172 6.53642 4.03087 6.53642H8.07213C8.62441 6.53642 9.07213 6.98414 9.07213 7.53642C9.07213 8.08871 8.62441 8.53642 8.07213 8.53642H5.00401C5.01705 8.98146 5.06503 9.55256 5.19356 10.1742C5.48888 11.6023 6.18497 13.1963 7.75277 14.2285C8.21407 14.5321 8.34184 15.1522 8.03815 15.6136C7.73446 16.0749 7.11432 16.2026 6.65303 15.8989C4.48055 14.4688 3.59063 12.299 3.23499 10.5792C3.05615 9.71423 3.00621 8.93748 3.00056 8.37635C2.99773 8.09476 3.00603 7.86468 3.0154 7.70151C3.02008 7.61984 3.02507 7.55472 3.02908 7.50804C3.03109 7.4847 3.03287 7.46594 3.03425 7.45202L3.03603 7.43476L3.03689 7.42668L3.03709 7.42492C3.03709 7.42492 3.03709 7.42492 4.03087 7.53642L3.03709 7.42492Z" fill="currentColor" fill-opacity="0.5"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9271 7.53642C22.9271 6.98414 23.3748 6.53642 23.9271 6.53642H27.9684C28.4775 6.53642 28.9053 6.91896 28.9621 7.42492L27.9684 7.53642C28.9621 7.42492 28.9621 7.42492 28.9621 7.42492L28.9625 7.42891L28.9632 7.43476L28.9649 7.45202C28.9664 7.46594 28.9681 7.4847 28.9701 7.50804C28.9741 7.55472 28.9791 7.61984 28.9839 7.70151C28.9932 7.86468 29.0015 8.09476 28.9987 8.37635C28.9929 8.93748 28.9431 9.71423 28.7643 10.5792C28.4085 12.299 27.5187 14.4688 25.3461 15.8989C24.8849 16.2026 24.2648 16.0749 23.9611 15.6136C23.6573 15.1522 23.7852 14.5321 24.2464 14.2285C25.8143 13.1963 26.5104 11.6023 26.8056 10.1742C26.9341 9.55256 26.9821 8.98146 26.9952 8.53642H23.9271C23.3748 8.53642 22.9271 8.08871 22.9271 7.53642Z" fill="currentColor" fill-opacity="0.5"/> </svg></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pricing section" id="pricing">
        <div class="container">
            <div class="pricing__wrapper section__wrapper">
                <div class="section__badge">Pricing</div>
                <div class="pricing__content">
                    <h2 class="pricing__title section__title">Pay per verification. Scale as&nbsp;you&nbsp;grow</h2>
                    <div class="pricing__cards">
                        <div class="pricing__price">
                            <span class="pricing__price-icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g id="Bank Carrd ai - Iconly Pro"> <g> <path fill-rule="evenodd" clip-rule="evenodd" d="M4.61483 6.04214C4.08028 6.61631 3.75 7.46423 3.75 8.53052V11.824C3.75 12.2383 3.41421 12.574 3 12.574C2.58579 12.574 2.25 12.2383 2.25 11.824V8.53052C2.25 7.15465 2.68009 5.91895 3.51696 5.02004C4.35946 4.11508 5.55755 3.61328 6.96486 3.61328H17.0351C18.4395 3.61328 19.6372 4.11537 20.4802 5.01971C21.3177 5.91819 21.75 7.15377 21.75 8.53052V15.1176C21.75 16.4934 21.3199 17.7291 20.483 18.628C19.6405 19.533 18.4424 20.0348 17.0351 20.0348H11.6225C11.2083 20.0348 10.8725 19.699 10.8725 19.2848C10.8725 18.8706 11.2083 18.5348 11.6225 18.5348H17.0351C18.0719 18.5348 18.8563 18.1741 19.3852 17.6059C19.9197 17.0318 20.25 16.1838 20.25 15.1176V8.53052C20.25 7.46511 19.9185 6.61708 19.3829 6.04248C18.8528 5.47373 18.0681 5.11328 17.0351 5.11328H6.96486C5.92807 5.11328 5.14373 5.47402 4.61483 6.04214Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M2.25 9.65759C2.25 9.24338 2.58579 8.90759 3 8.90759H21C21.4142 8.90759 21.75 9.24338 21.75 9.65759C21.75 10.0718 21.4142 10.4076 21 10.4076H3C2.58579 10.4076 2.25 10.0718 2.25 9.65759Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.59566 13.3358C5.90961 13.3358 6.19034 13.5314 6.29916 13.8259L6.40018 14.0992C6.70528 14.925 7.35518 15.5756 8.17897 15.8809V15.8809L8.45197 15.982C8.74614 16.091 8.94139 16.3716 8.94139 16.6853C8.94139 16.999 8.74614 17.2796 8.45197 17.3886L8.17899 17.4897C7.35519 17.795 6.70528 18.4456 6.40019 19.2713L6.29917 19.5447C6.19036 19.8392 5.90962 20.0348 5.59566 20.0348C5.28169 20.0348 5.00095 19.8392 4.89214 19.5447L4.79113 19.2713C4.48603 18.4456 3.83613 17.795 3.01233 17.4897L2.73935 17.3885C2.44522 17.2795 2.25 16.999 2.25 16.6853C2.25 16.3716 2.44522 16.0911 2.73935 15.982L3.01228 15.8809C3.83609 15.5756 4.48603 14.925 4.79113 14.0993L4.89215 13.8259C5.00097 13.5314 5.2817 13.3358 5.59566 13.3358ZM5.59566 17.6348C5.8628 17.2728 6.18262 16.9527 6.54432 16.6853C6.18262 16.4179 5.8628 16.0978 5.59566 15.7358C5.32851 16.0978 5.00869 16.4179 4.647 16.6853C5.00869 16.9527 5.32851 17.2728 5.59566 17.6348Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.409 12.6681C11.7392 12.6681 12.0305 12.8841 12.1266 13.2C12.2256 13.5258 12.48 13.7803 12.8043 13.8791C13.12 13.9753 13.3356 14.2666 13.3356 14.5965C13.3356 14.9265 13.12 15.2177 12.8043 15.3139C12.48 15.4128 12.2256 15.6672 12.1266 15.9931C12.0305 16.309 11.7392 16.525 11.409 16.525C11.0788 16.525 10.7874 16.309 10.6914 15.9931C10.5923 15.6672 10.3379 15.4128 10.0136 15.3139C9.69797 15.2177 9.4823 14.9265 9.4823 14.5965C9.4823 14.2666 9.69797 13.9754 10.0136 13.8791C10.3379 13.7803 10.5923 13.5259 10.6914 13.2C10.7874 12.8841 11.0788 12.6681 11.409 12.6681Z" fill="currentColor"/> </g> </g> </svg></span>
                            <div class="pricing__price-body">
                                <div class="pricing__price-head">
                                    <div class="pricing__price-value">from $0.24</div>
                                    <div class="pricing__price-unit">per document verification</div>
                                </div>
                                <div class="pricing__price-divider" aria-hidden="true"></div>
                                <p class="pricing__price-note">each additional document in the same session from <span>+$0.13</span></p>
                            </div>
                        </div>
                        <div class="pricing__offer">
                            <ul class="pricing__benefits">
                            <li class="pricing__benefit">
                                <span class="pricing__benefit-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <g> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6804 5.3196C9.78148 5.3196 5 10.1011 5 16C5 21.8989 9.78148 26.6804 15.6804 26.6804C21.5793 26.6804 26.3608 21.8989 26.3608 16C26.3608 10.1011 21.5793 5.3196 15.6804 5.3196ZM3 16C3 8.99651 8.67691 3.3196 15.6804 3.3196C22.6839 3.3196 28.3608 8.99651 28.3608 16C28.3608 23.0035 22.6839 28.6804 15.6804 28.6804C8.67691 28.6804 3 23.0035 3 16Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M28.8739 6.71335C29.1436 7.19525 28.9716 7.80463 28.4897 8.0744C22.3453 11.5141 18.5033 17.0984 16.6704 20.5417C16.5008 20.8604 16.1727 21.0628 15.8117 21.0715C15.4508 21.0801 15.1133 20.8937 14.9285 20.5836C13.6984 18.5185 12.1381 16.6807 10.235 15.0735C9.81307 14.7171 9.75989 14.0861 10.1162 13.6643C10.4726 13.2423 11.1035 13.1891 11.5255 13.5455C13.1507 14.918 14.552 16.4509 15.7308 18.1408C17.8915 14.5265 21.7309 9.56597 27.5128 6.32924C27.9947 6.05947 28.6041 6.23144 28.8739 6.71335Z" fill="currentColor"/> </g> </g> </svg></span>
                                <span class="pricing__benefit-text">No setup fee</span>
                            </li>
                            <li class="pricing__benefit">
                                <span class="pricing__benefit-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <g> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6804 5.3196C9.78148 5.3196 5 10.1011 5 16C5 21.8989 9.78148 26.6804 15.6804 26.6804C21.5793 26.6804 26.3608 21.8989 26.3608 16C26.3608 10.1011 21.5793 5.3196 15.6804 5.3196ZM3 16C3 8.99651 8.67691 3.3196 15.6804 3.3196C22.6839 3.3196 28.3608 8.99651 28.3608 16C28.3608 23.0035 22.6839 28.6804 15.6804 28.6804C8.67691 28.6804 3 23.0035 3 16Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M28.8739 6.71335C29.1436 7.19525 28.9716 7.80463 28.4897 8.0744C22.3453 11.5141 18.5033 17.0984 16.6704 20.5417C16.5008 20.8604 16.1727 21.0628 15.8117 21.0715C15.4508 21.0801 15.1133 20.8937 14.9285 20.5836C13.6984 18.5185 12.1381 16.6807 10.235 15.0735C9.81307 14.7171 9.75989 14.0861 10.1162 13.6643C10.4726 13.2423 11.1035 13.1891 11.5255 13.5455C13.1507 14.918 14.552 16.4509 15.7308 18.1408C17.8915 14.5265 21.7309 9.56597 27.5128 6.32924C27.9947 6.05947 28.6041 6.23144 28.8739 6.71335Z" fill="currentColor"/> </g> </g> </svg></span>
                                <span class="pricing__benefit-text">Price per document<br> falls as volume grows</span>
                            </li>
                            <li class="pricing__benefit">
                                <span class="pricing__benefit-icon"><svg aria-hidden="true" focusable="false" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <g> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6804 5.3196C9.78148 5.3196 5 10.1011 5 16C5 21.8989 9.78148 26.6804 15.6804 26.6804C21.5793 26.6804 26.3608 21.8989 26.3608 16C26.3608 10.1011 21.5793 5.3196 15.6804 5.3196ZM3 16C3 8.99651 8.67691 3.3196 15.6804 3.3196C22.6839 3.3196 28.3608 8.99651 28.3608 16C28.3608 23.0035 22.6839 28.6804 15.6804 28.6804C8.67691 28.6804 3 23.0035 3 16Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M28.8739 6.71335C29.1436 7.19525 28.9716 7.80463 28.4897 8.0744C22.3453 11.5141 18.5033 17.0984 16.6704 20.5417C16.5008 20.8604 16.1727 21.0628 15.8117 21.0715C15.4508 21.0801 15.1133 20.8937 14.9285 20.5836C13.6984 18.5185 12.1381 16.6807 10.235 15.0735C9.81307 14.7171 9.75989 14.0861 10.1162 13.6643C10.4726 13.2423 11.1035 13.1891 11.5255 13.5455C13.1507 14.918 14.552 16.4509 15.7308 18.1408C17.8915 14.5265 21.7309 9.56597 27.5128 6.32924C27.9947 6.05947 28.6041 6.23144 28.8739 6.71335Z" fill="currentColor"/> </g> </g> </svg></span>
                                <span class="pricing__benefit-text">14-day trial with<br> full API access</span>
                            </li>
                            </ul>
                            <div class="pricing__actions">
                                <button type="button" class="btn btn--gray open-callForm2">
                                    <span class="btn__text">Talk to sales</span>
                                    <span class="btn__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                                </button>
                                <a href="/pricing-matrix/" class="btn btn--primary">
                                    <span class="btn__text">Calculate your price</span>
                                    <span class="btn__icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php if (false) : /* Секция testimonials временно скрыта */ ?>
    <section class="testimonials section">
        <div class="container">
            <div class="testimonials__wrapper">
                <div class="testimonials__top">
                    <div class="section__badge">Testimonials</div>
                    <div class="testimonials__title-block">
                        <h2 class="testimonials__title section__title"> What Our Clients Say</h2>
                    </div>
                </div>

                <div class="testimonials__content">
                    <div class="testimonials__slider swiper">
                        <div class="testimonials__arrows">
                            <div class="testimonials__arrow testimonials__arrow-prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M10.0137 5.55638C10.3648 5.41074 10.7767 5.55248 10.9609 5.89427C11.1571 6.25876 11.0206 6.71341 10.6562 6.90989C10.6558 6.91012 10.6545 6.91025 10.6533 6.91087C10.651 6.91211 10.6476 6.91498 10.6426 6.91771C10.6324 6.92326 10.6164 6.93165 10.5957 6.9431C10.5541 6.96614 10.4925 7.00122 10.4131 7.04661C10.2537 7.13776 10.0238 7.27144 9.74805 7.44114C9.19501 7.78144 8.46189 8.26111 7.73242 8.82103C6.99842 9.38445 6.29193 10.011 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5894 5.77637 13.9079C6.29187 14.5388 6.99755 15.1651 7.73145 15.7283C8.46104 16.288 9.19491 16.7669 9.74805 17.1072C10.0236 17.2766 10.2527 17.4106 10.4121 17.5017C10.4916 17.5471 10.5541 17.5821 10.5957 17.6052C10.6165 17.6167 10.6324 17.626 10.6426 17.6316C10.6475 17.6342 10.6511 17.6362 10.6533 17.6374L10.6562 17.6384L10.7217 17.6784C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9577C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.9539 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9306 9.86914 18.9177C9.82212 18.8916 9.75372 18.8534 9.66797 18.8044C9.49654 18.7064 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.337 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2728 3.50097 12.2715 3.50098 12.2702C3.50295 11.3213 4.01126 10.4325 4.61426 9.69407C5.23299 8.93645 6.03997 8.22909 6.81836 7.63157C7.60128 7.0306 8.38067 6.52145 8.96191 6.1638C9.25325 5.98453 9.49653 5.84191 9.66797 5.74388C9.75368 5.69487 9.82214 5.65763 9.86914 5.63157C9.89234 5.61871 9.91016 5.60823 9.92285 5.6013C9.92922 5.59782 9.93494 5.59443 9.93848 5.59251C9.94003 5.59167 9.94143 5.59107 9.94238 5.59056L9.94336 5.58958H9.94434L10.0137 5.55638Z" fill="#FBFBFB"/>
                                </svg>
                            </div>
                            <div class="testimonials__arrow testimonials__arrow-next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                </svg>
                            </div>
                        </div>
                        <div class="testimonials__slider-wrapper swiper-wrapper">

                            <div class="testimonials__slider-wrapper swiper-wrapper">

                                <?php if (have_rows('reviews')) : ?>
                                    <?php while (have_rows('reviews')) : the_row(); ?>

                                        <?php
                                        $review_short   = get_sub_field('reviews_short');
                                        $review_author  = get_sub_field('reviews_author');
                                        $review_company = get_sub_field('reviews_company');
                                        $review_logo    = get_sub_field('reviews_logo');

                                        $review_image   = get_sub_field('reviews_image');
                                        $review_text    = get_sub_field('reviews_text');
                                        ?>

                                        <div class="testimonials__slide swiper-slide">
                                            <div class="testimonials__slide-wrapper">

                                                <div class="testimonials__slide-icon">
                                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/quote.svg'); ?>" alt="Testimonial">
                                                </div>

                                                <?php if ($review_short) : ?>
                                                    <div class="testimonials__slide-text">
                                                        <?php echo wp_kses_post($review_short); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="testimonials__slide-author">

                                                    <?php if (!empty($review_logo['url'])) : ?>
                                                        <div class="testimonials__slide-author-image">
                                                            <img 
                                                                src="<?php echo esc_url($review_logo['url']); ?>" 
                                                                alt="<?php echo esc_attr($review_logo['alt'] ?: $review_company); ?>"
                                                            >
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if ($review_author) : ?>
                                                        <div class="testimonials__slide-author-name">
                                                            <?php echo esc_html($review_author); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if ($review_company) : ?>
                                                        <div class="testimonials__slide-author-subtitle">
                                                            <?php echo esc_html($review_company); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>

                                                <div class="testimonials__slide-action">
                                                    <button 
                                                        class="btn btn--black open-review btn-with-lottie-arrow-orange"
                                                        data-review-image="<?php echo esc_url($review_image['url'] ?? ''); ?>"
                                                        data-review-alt="<?php echo esc_attr($review_image['alt'] ?? $review_author); ?>"
                                                    >
                                                        <span class="btn__text">Read full review</span>
                                                        <span class="btn__icon lottie-container-arrow-orange">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="review-hidden-content" hidden>
                                                        <?php echo wp_kses_post($review_text); ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (false) : /* Секция cases скрыта: в макетах редизайна её нет (DECISIONS.md, Р-11) */ ?>
    <section class="cases section animate-fade-up" id="cases">
        <div class="container">
            <div class="cases__wrapper">
                <div class="cases__title-left">
                    <div class="cases__title-block">
                        <div class="section__badge">Cases</div>
                        <h2 class="cases__title section__title">Success Stories That Speak for Themselves</h2>
                        <p class="section__subtitle cases__subtitle">See how leading companies transformed their identity verification with NeuroVision Global Systems</p>
                    </div>
                    <div class="cases__arrows">
                        <div class="cases__arrow cases__arrow-prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M10.0137 5.55638C10.3648 5.41074 10.7767 5.55248 10.9609 5.89427C11.1571 6.25876 11.0206 6.71341 10.6562 6.90989C10.6558 6.91012 10.6545 6.91025 10.6533 6.91087C10.651 6.91211 10.6476 6.91498 10.6426 6.91771C10.6324 6.92326 10.6164 6.93165 10.5957 6.9431C10.5541 6.96614 10.4925 7.00122 10.4131 7.04661C10.2537 7.13776 10.0238 7.27144 9.74805 7.44114C9.19501 7.78144 8.46189 8.26111 7.73242 8.82103C6.99842 9.38445 6.29193 10.011 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5894 5.77637 13.9079C6.29187 14.5388 6.99755 15.1651 7.73145 15.7283C8.46104 16.288 9.19491 16.7669 9.74805 17.1072C10.0236 17.2766 10.2527 17.4106 10.4121 17.5017C10.4916 17.5471 10.5541 17.5821 10.5957 17.6052C10.6165 17.6167 10.6324 17.626 10.6426 17.6316C10.6475 17.6342 10.6511 17.6362 10.6533 17.6374L10.6562 17.6384L10.7217 17.6784C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9577C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.9539 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9306 9.86914 18.9177C9.82212 18.8916 9.75372 18.8534 9.66797 18.8044C9.49654 18.7064 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.337 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2728 3.50097 12.2715 3.50098 12.2702C3.50295 11.3213 4.01126 10.4325 4.61426 9.69407C5.23299 8.93645 6.03997 8.22909 6.81836 7.63157C7.60128 7.0306 8.38067 6.52145 8.96191 6.1638C9.25325 5.98453 9.49653 5.84191 9.66797 5.74388C9.75368 5.69487 9.82214 5.65763 9.86914 5.63157C9.89234 5.61871 9.91016 5.60823 9.92285 5.6013C9.92922 5.59782 9.93494 5.59443 9.93848 5.59251C9.94003 5.59167 9.94143 5.59107 9.94238 5.59056L9.94336 5.58958H9.94434L10.0137 5.55638Z" fill="#FBFBFB"/>
                            </svg>
                        </div>
                        <div class="cases__arrow cases__arrow-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="cases__line"></div>
                <div class="cases__content">
                    <div class="cases__slider swiper">
                        <div class="cases__slider-wrapper swiper-wrapper">

                            <div class="cases__slide swiper-slide">
                                <div class="cases__slide-wrapper">
                                    <div class="cases__slide-image">
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cases__content-image.png" alt="Easypay">
                                    </div>
                                    <div class="cases__slide-title">EasyPay Bank: From Days to Minutes</div>
                                    <div class="cases__slide-info">
                                        <p class="cases__slide-subtitle">Solution</p>
                                        <p class="cases__slide-description">When EasyPay integrated NeuroVision Global Systems’s identity verification platform, they completely reimagined their account opening process. What used to take 2 days now happens in just 5 seconds. The result? A 40% reduction in customer drop-offs during registration and happier customers who can start banking immediately. Their KYC automation now handles thousands of verifications daily with 99.74% accuracy, all while maintaining full regulatory compliance.</p>
                                    </div>
                                    <div class="cases__slide-metriks">
                                        <div class="cases__slide-metriks-title">Key Metrics</div>
                                        <div class="cases__slide-metriks-list">
    
                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Verification time:</div>
                                                <div class="cases__slide-metrik-value cases__slide-metrik-value-old">2 days</div>
                                                <div class="cases__slide-metrik-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <path d="M9.83322 8.00019C9.83322 7.70835 9.64137 7.29549 9.21928 6.7873C8.81303 6.29818 8.25973 5.7985 7.68868 5.34394C7.12059 4.89174 6.54998 4.49601 6.12032 4.21243C5.90591 4.07092 5.72765 3.95758 5.6034 3.8804C5.54135 3.84186 5.49284 3.8123 5.46017 3.79251C5.44383 3.78262 5.43117 3.77523 5.42306 3.77038C5.41906 3.76799 5.41582 3.76629 5.41394 3.76517L5.36902 3.73522C5.16534 3.58474 5.10449 3.30164 5.23621 3.07897C5.37685 2.8414 5.6835 2.76264 5.92111 2.90319H5.92176V2.90384H5.92241C5.92314 2.90427 5.92439 2.90504 5.92566 2.90579C5.92824 2.90733 5.932 2.90947 5.93673 2.9123C5.94622 2.91799 5.96004 2.92632 5.97775 2.93704C6.01343 2.95866 6.06525 2.99076 6.13074 3.03144C6.2617 3.11279 6.44802 3.23056 6.67111 3.3778C7.11637 3.67168 7.71267 4.08507 8.31108 4.56139C8.90667 5.03548 9.52009 5.58429 9.98881 6.14863C10.4416 6.69389 10.8332 7.34014 10.8332 8.00019C10.8332 8.66018 10.4417 9.30654 9.98881 9.85176C9.5201 10.4161 8.90666 10.9642 8.31108 11.4383C7.71259 11.9148 7.11642 12.3286 6.67111 12.6226C6.44803 12.7698 6.26169 12.8876 6.13074 12.9689C6.06527 13.0096 6.01342 13.0417 5.97775 13.0633C5.96006 13.0741 5.94622 13.0824 5.93673 13.0881C5.93202 13.0909 5.92823 13.0931 5.92566 13.0946C5.92441 13.0953 5.92313 13.0961 5.92241 13.0965H5.92176V13.0972H5.92111C5.68352 13.2377 5.37687 13.159 5.23621 12.9214C5.1045 12.6988 5.16533 12.4157 5.36902 12.2652L5.41394 12.2352C5.41583 12.2341 5.41904 12.2324 5.42306 12.23C5.43117 12.2252 5.44383 12.2178 5.46017 12.2079C5.49284 12.1881 5.54136 12.1585 5.6034 12.12C5.72765 12.0428 5.90591 11.9295 6.12032 11.788C6.54998 11.5043 7.12057 11.108 7.68868 10.6558C8.25959 10.2013 8.81308 9.70208 9.21928 9.21308C9.6414 8.70489 9.83322 8.29184 9.83322 8.00019Z" fill="#FBFBFB"/>
                                                    </svg>
                                                </div>
                                                <div class="cases__slide-metrik-value">5 seconds</div>
                                            </div>
    
                                            <div class="cases__slide-metrik-line"></div>
    
                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Registration drop-off:</div>
                                                <div class="cases__slide-metrik-value">-40%</div>
                                            </div>
    
                                            <div class="cases__slide-metrik-line"></div>
    
                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Customer satisfaction:</div>
                                                <div class="cases__slide-metrik-value">+65%</div>
                                            </div>
    
                                        </div>
                                    </div>
                                    <div class="cases__slide-action">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="cases__slide swiper-slide">
                                <div class="cases__slide-wrapper">
                                    <div class="cases__slide-image">
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cases__content-image2.png" alt="CryptoX">
                                    </div>
                                    <div class="cases__slide-title">CryptoX Exchange: Security Meets Speed</div>
                                    <div class="cases__slide-info">
                                        <p class="cases__slide-subtitle">Solution</p>
                                        <p class="cases__slide-description">In the high-stakes world of cryptocurrency trading, CryptoX needed a solution that could keep pace with their 24/7 operations while meeting strict AML5 requirements. NeuroVision Global Systems's platform detected and prevented over 500 fraud attempts in the first month alone. Using our instant face matching technology (just 0.1 seconds per verification), CryptoX built trust with legitimate traders while keeping bad actors out. The platform's GDPR-compliant vectorless comparison technology meant they could expand across Europe without privacy concerns.</p>
                                    </div>
                                    <div class="cases__slide-metriks">
                                        <div class="cases__slide-metriks-title">Key Metrics</div>
                                        <div class="cases__slide-metriks-list">

                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Fraud attempts blocked:</div>
                                                <div class="cases__slide-metrik-value">500+ (first month)</div>
                                            </div>

                                            <div class="cases__slide-metrik-line"></div>

                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Verification speed:</div>
                                                <div class="cases__slide-metrik-value">0.1 seconds</div>
                                            </div>

                                            <div class="cases__slide-metrik-line"></div>

                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Trader trust score:</div>
                                                <div class="cases__slide-metrik-value">+82%</div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="cases__slide-action">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="cases__slide swiper-slide">
                                <div class="cases__slide-wrapper">
                                    <div class="cases__slide-image">
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cases__content-image3.png" alt="GovID">
                                    </div>
                                    <div class="cases__slide-title">GovID Project: Securing a Nation's Digital Identity</div>
                                    <div class="cases__slide-info">
                                        <p class="cases__slide-subtitle">Solution</p>
                                        <p class="cases__slide-description">When a national government needed to verify identities for over 10 million citizens accessing digital services, they turned to NeuroVision Global Systems. Our face recognition technology achieved a remarkable 99.87% first-attempt success rate, making government services accessible to citizens while maintaining the highest security standards. The system processes hundreds of thousands of verifications daily, supporting documents from over 200 countries & territories in 90 languages. This wasn't just about technology - it was about creating a seamless experience for millions of people interacting with essential services.</p>
                                    </div>
                                    <div class="cases__slide-metriks">
                                        <div class="cases__slide-metriks-title"></div>
                                        <div class="cases__slide-metriks-list">

                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Citizens verified:</div>
                                                <div class="cases__slide-metrik-value">10M+</div>
                                            </div>

                                            <div class="cases__slide-metrik-line"></div>

                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">First-attempt success:</div>
                                                <div class="cases__slide-metrik-value">99.87%</div>
                                            </div>

                                            <div class="cases__slide-metrik-line"></div>

                                            <div class="cases__slide-metrik">
                                                <div class="cases__slide-metrik-name">Daily verifications:</div>
                                                <div class="cases__slide-metrik-value">300,000+</div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="cases__slide-action">
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="cases__bottom">
                <div class="cases__bottom-info">
                    <div class="cases__bottom-title">Ready to write your own success story? </div>
                    <div class="cases__bottom-subtitle">Let's talk about how NeuroVision Global Systems can transform your identity verification process.</div>
                </div>
                <div class="cases__bottom-action">
                    <button class="btn-hero open-callForm2">
                        <span class="btn__text btn__text-hero">Get Started Today</span>
                        <div class="btn__icon btn__icon-arrow"></div>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="doc section" id="documentation">
        <div class="container">
            <div class="doc__wrapper">
                <div class="doc__info">
                    <div class="doc__info-top">
                        <div class="section__badge">Developers</div>
                        <div class="doc__info-head">
                            <h2 class="doc__title section__title">Integration under<br> an&nbsp;hour, on&nbsp;your terms</h2>
                            <p class="doc__description">REST API and Web SDK, sandbox first. iOS, Android, web, desktop and Telegram Mini App. On-premises, cloud or hybrid — data stays in your&nbsp;jurisdiction.</p>
                        </div>
                    </div>
                    <div class="doc__info-bottom">
                        <p class="doc__lead">Ready to build something amazing? Start integrating NeuroVision Global Systems today with our free developer&nbsp;account</p>
                        <div class="doc__actions">
                            <button type="button" class="btn btn--primary open-callForm2">
                                <span class="btn__text">Get Your API Key</span>
                                <span class="btn__icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                            </button>
                            <button type="button" class="btn btn--gray btn--icon-first open-callForm2">
                                <span class="btn__icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <g> <path d="M21.7038 10.5393C21.3268 10.5393 21.0028 10.2563 20.9598 9.87334C20.5798 6.49734 17.9568 3.87734 14.5808 3.50234C14.1698 3.45634 13.8728 3.08634 13.9188 2.67434C13.9638 2.26334 14.3328 1.95634 14.7468 2.01234C18.8238 2.46434 21.9918 5.62834 22.4498 9.70534C22.4968 10.1173 22.1998 10.4883 21.7888 10.5343C21.7608 10.5373 21.7318 10.5393 21.7038 10.5393Z" fill="currentColor"/> <path d="M18.1625 10.5501C17.8105 10.5501 17.4975 10.3021 17.4275 9.9441C17.1395 8.4641 15.9985 7.3231 14.5205 7.0361C14.1135 6.9571 13.8485 6.5641 13.9275 6.1571C14.0065 5.7501 14.4095 5.4851 14.8065 5.5641C16.8875 5.9681 18.4945 7.5741 18.8995 9.6561C18.9785 10.0641 18.7135 10.4571 18.3075 10.5361C18.2585 10.5451 18.2105 10.5501 18.1625 10.5501Z" fill="currentColor"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.48215 16.8362C12.1952 21.5502 15.3332 22.7862 17.3152 22.7862C18.2932 22.7862 18.9912 22.4852 19.4562 22.1512C19.4772 22.1392 21.6292 20.8232 22.0062 18.8312C22.1842 17.8962 21.9242 16.9712 21.2562 16.1552C18.5042 12.8142 17.1022 13.1262 15.5542 13.8792C14.6032 14.3452 13.8522 14.7072 11.7312 12.5882C9.6114 10.4675 9.97707 9.7164 10.44 8.76556C11.194 7.21756 11.5042 5.81523 8.16215 3.06123C7.34815 2.39623 6.42915 2.13623 5.49515 2.31123C3.53215 2.67823 2.20815 4.79523 2.21015 4.79523C1.15815 6.27223 0.444153 9.79923 7.48215 16.8362ZM5.80115 3.77923C5.88915 3.76523 5.97615 3.75723 6.06215 3.75723C6.45415 3.75723 6.83215 3.91023 7.20915 4.22023C9.90413 6.44021 9.56316 7.14022 9.09116 8.1092C8.38216 9.5662 8.01115 10.9882 10.6702 13.6492C13.3322 16.3102 14.7552 15.9392 16.2102 15.2282L16.2126 15.227C17.1804 14.7566 17.8801 14.4165 20.0972 17.1082C20.4762 17.5702 20.6212 18.0322 20.5392 18.5192C20.3502 19.6392 19.0482 20.6422 18.6542 20.8862C17.2432 21.8922 13.8462 21.0792 8.54215 15.7762C3.24015 10.4732 2.42615 7.07623 3.46815 5.61123C3.67615 5.27223 4.68315 3.96823 5.80115 3.77923Z" fill="currentColor"/> </g> </g> </svg></span>
                                <span class="btn__text">Schedule an integration call</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="doc__content">
                    <div class="doc__cards">
                        <div class="doc__card">
                            <span class="doc__card-icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <path d="M10.2246 3.84082C10.9531 2.38602 13.0469 2.38602 13.7754 3.84082L15.6025 7.49219L15.665 7.58691C15.7388 7.6731 15.844 7.7328 15.9639 7.75L20.0518 8.33789H20.0527C21.6655 8.57087 22.3383 10.5488 21.1455 11.6934L21.1445 11.6924L18.1895 14.5322C18.0773 14.6401 18.0293 14.792 18.0547 14.9385V14.9395L18.7529 18.9492V18.9502C19.034 20.575 17.3154 21.7672 15.8818 21.0225V21.0234L12.2275 19.1289V19.1279C12.0864 19.0549 11.9147 19.054 11.7715 19.1279L8.11816 21.0234L8.11719 21.0225C6.68412 21.7663 4.96495 20.5749 5.24805 18.9492L5.94531 14.9395V14.9385C5.97069 14.792 5.92173 14.641 5.80957 14.5332V14.5322L2.85547 11.6924L2.85449 11.6934C1.66166 10.5488 2.33449 8.57087 3.94727 8.33789H3.94824L8.03613 7.75L8.15137 7.71875C8.25986 7.67484 8.34776 7.5936 8.39844 7.49219L10.2246 3.8418V3.84082ZM12.4336 4.5127C12.2692 4.18437 11.8055 4.164 11.6035 4.45117L11.5664 4.5127L9.74023 8.16309C9.44967 8.74449 8.8901 9.14241 8.24902 9.23437L4.16113 9.82227C3.75466 9.88139 3.6242 10.3522 3.89258 10.6104L3.89355 10.6113L6.84961 13.4512V13.4521C7.28902 13.8747 7.50627 14.4738 7.43945 15.0762L7.42285 15.1963L6.72656 19.2061V19.207C6.66459 19.5646 7.05485 19.8853 7.42676 19.6924L7.42773 19.6914L11.0811 17.7969H11.082C11.6571 17.4993 12.3439 17.4984 12.9189 17.7969L16.5723 19.6914L16.5732 19.6924C16.9217 19.8731 17.288 19.6025 17.2812 19.2725L17.2744 19.2061L16.5771 15.1963C16.4653 14.5543 16.6818 13.9028 17.1504 13.4521V13.4512L20.1074 10.6104C20.3759 10.3521 20.2448 9.882 19.8379 9.82324L15.751 9.23437C15.1893 9.1538 14.6918 8.83862 14.3818 8.37207L14.2607 8.16309L12.4336 4.5127Z" fill="currentColor"/> </g> </svg></span>
                            <div class="doc__card-body">
                                <div class="doc__card-text">
                                    <div class="doc__card-title">API Reference &amp; SDKs</div>
                                    <div class="doc__card-description">Dive into our REST API documentation with clear endpoints, sample requests, and response examples. We&rsquo;ve built native SDKs for all major platforms — so you can integrate NeuroVision using the tools you already know</div>
                                </div>
                                <a href="/docs/" class="btn btn--gray">
                                    <span class="btn__text">View API Documentation</span>
                                    <span class="btn__icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                                </a>
                            </div>
                        </div>
                        <div class="doc__card">
                            <span class="doc__card-icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <path d="M10.2246 3.84082C10.9531 2.38602 13.0469 2.38602 13.7754 3.84082L15.6025 7.49219L15.665 7.58691C15.7388 7.6731 15.844 7.7328 15.9639 7.75L20.0518 8.33789H20.0527C21.6655 8.57087 22.3383 10.5488 21.1455 11.6934L21.1445 11.6924L18.1895 14.5322C18.0773 14.6401 18.0293 14.792 18.0547 14.9385V14.9395L18.7529 18.9492V18.9502C19.034 20.575 17.3154 21.7672 15.8818 21.0225V21.0234L12.2275 19.1289V19.1279C12.0864 19.0549 11.9147 19.054 11.7715 19.1279L8.11816 21.0234L8.11719 21.0225C6.68412 21.7663 4.96495 20.5749 5.24805 18.9492L5.94531 14.9395V14.9385C5.97069 14.792 5.92173 14.641 5.80957 14.5332V14.5322L2.85547 11.6924L2.85449 11.6934C1.66166 10.5488 2.33449 8.57087 3.94727 8.33789H3.94824L8.03613 7.75L8.15137 7.71875C8.25986 7.67484 8.34776 7.5936 8.39844 7.49219L10.2246 3.8418V3.84082ZM12.4336 4.5127C12.2692 4.18437 11.8055 4.164 11.6035 4.45117L11.5664 4.5127L9.74023 8.16309C9.44967 8.74449 8.8901 9.14241 8.24902 9.23437L4.16113 9.82227C3.75466 9.88139 3.6242 10.3522 3.89258 10.6104L3.89355 10.6113L6.84961 13.4512V13.4521C7.28902 13.8747 7.50627 14.4738 7.43945 15.0762L7.42285 15.1963L6.72656 19.2061V19.207C6.66459 19.5646 7.05485 19.8853 7.42676 19.6924L7.42773 19.6914L11.0811 17.7969H11.082C11.6571 17.4993 12.3439 17.4984 12.9189 17.7969L16.5723 19.6914L16.5732 19.6924C16.9217 19.8731 17.288 19.6025 17.2812 19.2725L17.2744 19.2061L16.5771 15.1963C16.4653 14.5543 16.6818 13.9028 17.1504 13.4521V13.4512L20.1074 10.6104C20.3759 10.3521 20.2448 9.882 19.8379 9.82324L15.751 9.23437C15.1893 9.1538 14.6918 8.83862 14.3818 8.37207L14.2607 8.16309L12.4336 4.5127Z" fill="currentColor"/> </g> </svg></span>
                            <div class="doc__card-body">
                                <div class="doc__card-text">
                                    <div class="doc__card-title">Integration Guide</div>
                                    <div class="doc__card-description">Follow our integration guides that walk you through every step of the process. We&rsquo;ve documented common scenarios, webhook configurations and optimization tips. Most developers complete their basic integration in just one business day.</div>
                                </div>
                                <a href="/docs/products/kyc/api-and-integration/web-sdk/installation/" class="btn btn--gray">
                                    <span class="btn__text">Read Integration Guide</span>
                                    <span class="btn__icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="doc__support">
                        <div class="doc__support-text">
                            <div class="doc__support-title">Developer Support</div>
                            <p class="doc__support-description">24/7 support with a personal account manager — plus a dedicated Telegram chat for your integration&nbsp;team.</p>
                        </div>
                        <button type="button" class="btn btn--dark open-callForm2">
                            <span class="btn__text">Book a call</span>
                            <span class="btn__icon"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    /*
     * Блок Blog («Insights & Resources») с главной убран по решению владельца (2026-10-21).
     * Partial template-parts/news-section.php остаётся и выводится на /identity-verification/.
     */
    ?>

    <?php
    /*
     * FAQ. Макеты Figma: Full HD 2380:23774, Desktop 2363:32515, Tablet 2376:17599,
     * спойлер открытый/закрытый 2363:32526 / 2363:32527, ховер 2386:37430.
     *
     * Разметка повторяет структуру аккордеона темы (`.faq__item-wrapper` →
     * `.faq__item-question` + `.faq__item-answer`), чтобы работал существующий
     * `initFaq()` без второго обработчика.
     *
     * ВАЖНО: в макете раскрыт только первый вопрос, у остальных семи узла ответа
     * нет вовсе. Тексты не выдумываем: вопрос без ответа выводится обычной
     * строкой — без кнопки раскрытия и без пустой панели. См. BACKLOG R-18.
     */
    $nv_faq_items = [
        [
            'question' => 'How long does integration take?',
            'answer'   => 'Under an hour for REST API or Web SDK with sandbox keys; production in one business day. A one-month pilot on your real traffic comes with full support.',
        ],
        ['question' => 'Which countries and documents do you support?',      'answer' => ''],
        ['question' => 'How accurate is face matching, and who verified it?', 'answer' => ''],
        ['question' => 'Where is customer data stored?',                      'answer' => ''],
        ['question' => 'What makes you different from other KYC providers?',  'answer' => ''],
        ['question' => 'Can we test before we buy?',                          'answer' => ''],
        ['question' => 'How is pricing calculated?',                          'answer' => ''],
        ['question' => 'What support do we get after launch?',                'answer' => ''],
    ];

    $nv_faq_chevron = '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.3312 6.71213C15.5193 6.45753 15.8732 6.38147 16.1515 6.54612C16.4485 6.72192 16.5469 7.10523 16.3712 7.40224V7.40305H16.3704V7.40386C16.3699 7.40477 16.3689 7.40634 16.368 7.40793C16.3661 7.41115 16.3634 7.41586 16.3598 7.42177C16.3527 7.43363 16.3423 7.4509 16.3289 7.47304C16.3019 7.51765 16.2618 7.58241 16.2109 7.66428C16.1092 7.82798 15.962 8.06088 15.778 8.33974C15.4106 8.89632 14.8939 9.64169 14.2985 10.3897C13.7059 11.1342 13.0199 11.901 12.3144 12.4869C11.6329 13.0529 10.8251 13.5424 9.99998 13.5424C9.17501 13.5424 8.36706 13.0529 7.68553 12.4869C6.98015 11.901 6.29495 11.1342 5.70229 10.3897C5.10675 9.64159 4.58944 8.89638 4.22199 8.33974C4.03792 8.06089 3.89074 7.82797 3.78905 7.66428C3.7382 7.58244 3.69806 7.51763 3.67105 7.47304C3.65766 7.45093 3.64722 7.43362 3.64012 7.42177C3.6366 7.41588 3.63389 7.41114 3.63198 7.40793C3.63105 7.40637 3.63007 7.40476 3.62954 7.40386V7.40305H3.62873V7.40224C3.45305 7.10526 3.55152 6.72194 3.84845 6.54612C4.12678 6.38148 4.48066 6.45752 4.66877 6.71213L4.7062 6.76829C4.7076 6.77064 4.7097 6.77466 4.71271 6.77968C4.71879 6.78982 4.72801 6.80565 4.74038 6.82607C4.76512 6.8669 4.80207 6.92756 4.85024 7.0051C4.94674 7.16042 5.08836 7.38325 5.26528 7.65126C5.61982 8.18833 6.11516 8.90157 6.68049 9.61171C7.24861 10.3253 7.87263 11.0172 8.48387 11.525C9.11912 12.0526 9.63543 12.2924 9.99998 12.2924C10.3648 12.2924 10.8809 12.0526 11.5161 11.525C12.1275 11.0171 12.7521 10.3255 13.3203 9.61171C13.8856 8.90159 14.3802 8.18833 14.7347 7.65126C14.9116 7.38324 15.0532 7.16042 15.1497 7.0051C15.1979 6.92754 15.2349 6.8669 15.2596 6.82607C15.272 6.80565 15.2812 6.78982 15.2873 6.77968C15.2902 6.77468 15.2924 6.77063 15.2938 6.76829L15.3312 6.71213Z" fill="currentColor"/></svg>';
    ?>

    <section class="faq section" id="faq">
        <div class="container">
            <div class="faq__wrapper">

                <div class="faq__left">
                    <div class="faq__title-block">
                        <div class="section__badge">FAQ</div>
                        <div class="faq__title-text">
                            <h2 class="faq__title">Questions we hear most</h2>
                            <p class="faq__description">A focused set of KYC-specific questions. The full library &mdash; including industry- and region-specific topics &mdash; lives in the resource center.</p>
                        </div>
                    </div>

                    <div class="faq__cta">
                        <p class="faq__cta-text">Didn&rsquo;t find your answer?</p>
                        <button type="button" class="btn btn--gray faq__cta-btn open-callForm2">
                            <span class="btn__text">Talk to an Engineer</span>
                            <span class="btn__icon">
                                <svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="faq__right">
                    <div class="faq__list">
                        <?php foreach ($nv_faq_items as $i => $nv_faq) : ?>
                            <?php $nv_has_answer = nv_has_content($nv_faq['answer']); ?>
                            <?php
                                // В обоих фреймах макета первый вопрос раскрыт.
                                $nv_faq_classes = $nv_has_answer ? '' : ' faq__item--static';
                                if ($nv_has_answer && $i === 0) {
                                    $nv_faq_classes .= ' faq__item--open';
                                }
                            ?>
                            <div class="faq__item<?php echo $nv_faq_classes; ?>">
                                <div class="faq__item-wrapper">
                                    <?php if ($nv_has_answer) : ?>
                                        <button type="button"
                                                class="faq__item-question"
                                                id="faq-question-<?php echo (int) $i; ?>"
                                                aria-expanded="<?php echo ($i === 0) ? 'true' : 'false'; ?>"
                                                aria-controls="faq-answer-<?php echo (int) $i; ?>">
                                            <span class="faq__item-question-text"><?php echo esc_html($nv_faq['question']); ?></span>
                                            <span class="faq__item-question-icon"><?php echo $nv_faq_chevron; ?></span>
                                        </button>
                                        <div class="faq__item-answer"
                                             id="faq-answer-<?php echo (int) $i; ?>"
                                             role="region"
                                             aria-labelledby="faq-question-<?php echo (int) $i; ?>">
                                            <div class="faq__item-answer-text">
                                                <p><?php echo esc_html($nv_faq['answer']); ?></p>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="faq__item-question">
                                            <span class="faq__item-question-text"><?php echo esc_html($nv_faq['question']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php if (false) : /* Секция promo скрыта: в макетах редизайна её нет (DECISIONS.md, Р-11) */ ?>
    <section class="promo section">
        <div class="container">
            <div class="promo__wrapper">
                <div class="promo__info">
                    <div class="promo__info-title">Get Your Free KYC Implementation Checklist</div>
                    <div class="promo__info-description">Join thousands of compliance professionals who rely on our comprehensive guide</div>
                </div>
                <div class="promo__image-maskot">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/promo_image.png" alt="Get Your Free KYC Implementation Checklist">
                </div>
                <div class="promo__action">
                    <form class="promo__form" action="#">
                        <div class="promo__form-wrapper">
                            <div class="input-form-block">
                                <div class="input-form-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="33" height="31" viewBox="0 0 33 31" fill="none">
                                        <g filter="url(#filter0_d_2001_2503)">
                                          <path d="M23 12.9277C23 10.9511 21.7145 9.5 19.9316 9.5H12.5684C10.7854 9.5 9.5 10.9511 9.5 12.9277V18.0781C9.5 20.0574 10.7851 21.5044 12.5664 21.5H19.9336C21.7149 21.5044 23 20.0574 23 18.0781V12.9277ZM20.2041 12.5557C20.5255 12.2947 20.9976 12.3438 21.2588 12.665C21.52 12.9863 21.4715 13.4584 21.1504 13.7197L17.8174 16.4297L17.8115 16.4346C16.9108 17.1503 15.6342 17.1503 14.7334 16.4346L14.7295 16.4316L11.3682 13.7217C11.046 13.4617 10.995 12.9894 11.2549 12.667C11.5148 12.3447 11.9871 12.2941 12.3096 12.5537L15.667 15.2607L15.8057 15.3525C16.1427 15.5367 16.5632 15.5062 16.873 15.2627L20.2041 12.5557ZM24.5 18.0781C24.5 20.707 22.711 23.0051 19.9316 22.999V23H12.5684V22.999C9.789 23.005 8 20.707 8 18.0781V12.9277C8 10.3005 9.78969 8 12.5684 8H19.9316C22.7102 8 24.5 10.3005 24.5 12.9277V18.0781Z" fill="#F9AA66"/>
                                        </g>
                                        <defs>
                                          <filter id="filter0_d_2001_2503" x="0" y="0" width="32.5" height="31" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="4"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2001_2503"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2001_2503" result="shape"/>
                                          </filter>
                                        </defs>
                                    </svg>
                                </div>
                                <input class="input-form promo__form-input" type="email" name="clientEmail" placeholder="Enter your email">
                                <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1784 10L15.5892 5.58921C15.915 5.26338 15.915 4.73671 15.5892 4.41088C15.2634 4.08505 14.7367 4.08505 14.4109 4.41088L10 8.82167L5.58921 4.41088C5.26338 4.08505 4.73671 4.08505 4.41088 4.41088C4.08505 4.73671 4.08505 5.26338 4.41088 5.58921L8.8217 10L4.41088 14.4109C4.08505 14.7367 4.08505 15.2633 4.41088 15.5892C4.57338 15.7517 4.78671 15.8333 5.00005 15.8333C5.21338 15.8333 5.42671 15.7517 5.58921 15.5892L10 11.1784L14.4109 15.5892C14.5734 15.7517 14.7867 15.8333 15 15.8333C15.2134 15.8333 15.4267 15.7517 15.5892 15.5892C15.915 15.2633 15.915 14.7367 15.5892 14.4109L11.1784 10Z" fill="#FBFBFB"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="input-form-action">
                                <button type="submit" class="btn btn--orange">
                                    <span class="btn__text">Download</span>
                                    <span class="btn__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    /* Contacts: тот же блок, что `#cta` на /solutions/ (template-parts/contacts-section.php); заголовок и подзаголовок — прежние главной.
     * Якорь оставлен `contacts`: на него ведут пункт page-nav и ссылка «Contacts» в подвале. */
    get_template_part('template-parts/contacts-section', null, array(
        'section_id' => 'contacts',
        'badge'      => 'Contacts',
        'title'      => 'Let’s talk about your verification flow',
        'lead'       => 'Demo, sandbox access and a pilot scenario for your flow &mdash; within one week of the first call.',
    ));
    ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>


</main>

<style>
    .hero_media {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }
    .hero_media video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
</style>
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var heroSection = document.querySelector('.hero');
        var video       = document.getElementById('heroVideo');
        if (!video) return;
        var media = heroSection ? heroSection.querySelector('.hero_media') : null;

        video.muted = true;
        video.playsInline = true;
        video.setAttribute('playsinline', '');
        video.setAttribute('webkit-playsinline', '');

        var LAST_FRAME = '/wp-content/themes/nvglobal/video/main_bg_lastframe.jpg';
        var lastLayer = document.createElement('div');
        lastLayer.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;z-index:3;' +
            "background-image:url('" + LAST_FRAME + "');background-position:center center;" +
            'background-size:cover;background-repeat:no-repeat;opacity:0;pointer-events:none;';
        if (media) { media.appendChild(lastLayer); }
        var lastImg = new Image();
        lastImg.onload = function () { if (lastImg.decode) { try { lastImg.decode(); } catch (e) {} } };
        lastImg.src = LAST_FRAME;
        function showLastFrame() { lastLayer.style.opacity = '1'; }
        video.addEventListener('timeupdate', function () {
            if (video.duration && video.currentTime >= video.duration - 0.08) { showLastFrame(); }
        });
        video.addEventListener('ended', showLastFrame);

        
        var p = video.play();
        if (p && typeof p.catch === 'function') {
            p.catch(function () {
                var kick = function () {
                    video.play();
                    window.removeEventListener('touchstart', kick);
                    window.removeEventListener('click', kick);
                };
                window.addEventListener('touchstart', kick, { passive: true });
                window.addEventListener('click', kick);
            });
        }
       
        var TOP_THRESHOLD = 2;
        var didReset      = false;
        function sy() { return Math.round(window.pageYOffset || document.documentElement.scrollTop || 0); }
        function blockBottom() { return heroSection ? heroSection.offsetHeight : window.innerHeight; }

        function resetVideo() {
            try { video.pause(); } catch (e) {}
            try { video.currentTime = 0; } catch (e) {}
            lastLayer.style.opacity = '0';
            didReset = true;
        }
        function replayVideo() {
            lastLayer.style.opacity = '0';
            try { video.currentTime = 0; } catch (e) {}
            var pp = video.play();
            if (pp && typeof pp.catch === 'function') { pp.catch(function () {}); }
            didReset = false;
        }
        window.addEventListener('scroll', function () {
            var y = sy();
            if (!didReset && y > blockBottom()) {
                resetVideo();
            } else if (didReset && y <= TOP_THRESHOLD) {
                replayVideo();
            }
        }, { passive: true });

        if (typeof initFadeUpAnimations === 'function') { initFadeUpAnimations(); }
    });
})();
</script>

<?php
get_footer();
?>
