<?php
/*
Template Name: Hero Variant 1 — Video Scroll
Template Post Type: page
*/

/* =============================================================================
 * АНИМАЦИЯ ПЕРВОГО БЛОКА (.hero) — ВОСПРОИЗВЕДЕНИЕ ВИДЕО ПО СКРОЛЛУ
 * Демо: /main-1/
 * -----------------------------------------------------------------------------
 * Идея: фоновое видео (video/main_bg.mp4) НЕ проигрывается само по себе — его
 * кадр («время», video.currentTime) полностью управляется позицией скролла.
 * Крутишь вниз — видео идёт вперёд, крутишь вверх — назад. Одновременно с этим
 * заголовок и градиент плавно уезжают влево и растворяются, а секция «залипает»
 * (pin) на экране, пока ролик не проиграется целиком; только потом страница
 * листается дальше.
 *
 * Библиотеки: GSAP + ScrollTrigger (уже подключены в теме). Код анимации —
 * во встроенном <script> в конце этого шаблона; сюда ничего выносить не нужно.
 *
 * Архитектура «scroll = намерение, RAF = исполнение» (3 слоя):
 *
 *   СЛОЙ 1 — SCROLL (вход). ScrollTrigger закрепляет .hero (pin) и на каждом
 *     шаге скролла пишет ТОЛЬКО одну величину: targetProgress = self.progress
 *     (0..1). Он не трогает видео напрямую. Длина закрепления (end) считается
 *     пропорционально длительности ролика (≈ duration * PX_PER_SEC), чтобы за
 *     время прокрутки видео успевало проиграться от первого до последнего кадра
 *     и его нельзя было «проскочить» одним движением колеса.
 *
 *   СЛОЙ 2 — TIMELINE CONTROLLER (единый RAF-цикл animate()). Плавно догоняет
 *     цель: currentProgress += (targetProgress - currentProgress) * EASE, с
 *     ограничением скорости за кадр (MAX_STEP). Это даёт строго монотонную,
 *     без рывков и «прыжков кадров» прогрессию, даже если ScrollTrigger отдаёт
 *     скачкообразный progress.
 *
 *   СЛОЙ 3 — RENDER (выход, ничего не знает о скролле). render(progress):
 *     - renderVideo(): video.currentTime = progress * duration. Перемотка
 *       выполняется ТОЛЬКО из этого цикла и только когда предыдущий seek уже
 *       завершён (if (!video.seeking)) — иначе <video> вечно «в перемотке» и не
 *       успевает отрисовать кадр (визуально видео «не играет»).
 *     - renderFades(): заголовок (.hero__wrapper) и градиент (.hero_gradient)
 *       сдвигаются на x = -500 * progress и гаснут (opacity = 1 - progress)
 *       синхронно с воспроизведением.
 *
 * Разметка блока: <section class="hero"> с .hero_gradient, .hero_media (внутри
 * <video id="heroVideo">) и .container > .hero__wrapper (заголовок и кнопки).
 * В <script> есть флаг DEBUG для служебного вывода состояния в консоль.
 * ============================================================================= */

get_header(); ?>

<main>


    <section class="hero">
        <div class="hero_gradient"></div>
        <div class="hero_media">
            <video id="heroVideo"
                   src="/wp-content/themes/nvglobal/video/main_bg.mp4"
                   muted
                   playsinline
                   preload="auto"></video>
        </div>
        <div class="container">
            <div class="hero__wrapper">
                <div class="hero__content">
                    <h1 class="hero__title">All in one Identity verification platform for Instant KYC Verification</h1>
                    <div class="verify">Verify customers identity in 0.1 seconds with industry-leading accuracy</div>
                </div>
                <div class="hero__actions">
                    <button class="btn-hero open-callForm2">
                        <span class="btn__text btn__text-hero">Start Free Trial</span>
                        <div class="btn__icon btn__icon-arrow"></div>
                    </button>
                    <div class="hero__actions-sep"></div>
                    <a href="/pricing-matrix/" class="btn btn--gray btn-with-lottie-arrow-orange">
                        <span class="btn__text">View our prices</span>
                        <span class="btn__icon lottie-container-arrow-orange" data-lottie-initialized="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" width="512" height="512" preserveAspectRatio="xMidYMid meet" style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px); content-visibility: visible;"><defs><clipPath id="__lottie_element_35"><rect width="512" height="512" x="0" y="0"></rect></clipPath><clipPath id="__lottie_element_37"><path d="M0,0 L512,0 L512,512 L0,512z"></path></clipPath></defs><g clip-path="url(#__lottie_element_35)"><g id="10111" clip-path="url(#__lottie_element_37)" transform="matrix(-1,0,0,1,512,0)" opacity="1" style="display: block;"><g id="5416" transform="matrix(1,0,0,1,0,0)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,257.9159851074219,256)"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="32" d=" M-170.66600036621094,0 C-170.66600036621094,0 170.66600036621094,0 170.66600036621094,0"></path></g></g><g opacity="1" transform="matrix(1,0,0,1,156.10299682617188,256.00799560546875)"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" stroke="rgb(255,255,255)" stroke-opacity="1" stroke-width="32" d=" M68.83599853515625,-137.09100341796875 C68.83599853515625,-137.09100341796875 -68.83599853515625,-0.012000000104308128 -68.83599853515625,-0.012000000104308128 C-68.83599853515625,-0.012000000104308128 68.83599853515625,137.09100341796875 68.83599853515625,137.09100341796875"></path></g></g></g><g id="5403" style="display: none;"><g><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"></path></g></g><g id="5402" style="display: none;"><g><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0"></path></g></g></g></g></svg></span>
                    </a>
                </div>
            </div>
        </div>
    </section>


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
 
    <section class="about section" id="about" data-offset="1">
        <div class="container">
            <div class="about__wrapper section__wrapper">
                <div class="section__badge">About</div>
                <div class="section__content">
                    <div class="section__title-block">
                        <h2 class="section__title">Streamline onboarding, prevent fraud, and ensure KYC/AML compliance</h2>
                        <p class="section__subtitle">all through a single powerful API that integrates in just one business day</p>
                    </div>
                    <div class="about__info">
                        <div class="about__description">Join hundreds of companies worldwide who trust NV GLobal to handle millions of identity verifications every year.</div>
                        <div class="about__cards">

                            <div class="about__card about__card--maskot-mobile">
                                <div class="about__card-info">
                                    <div class="about__card-text">Our advanced computer vision technology delivers </div>
                                    <div class="about__card-percent">99.74% </div>
                                    <div class="about__card-description">facial recognition accuracy</div>
                                </div>
                                <div class="about__card-image">
                                    <div class="about__card-image-text">verified by</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="206" height="55" viewBox="0 0 206 55" fill="none">
                                        <path d="M11.2671 54.9324H0V11.5706C0 11.5706 -1.23978e-05 3.31127 8.26252 0.683279C15.7739 -1.75699 20.6563 3.12353 20.6563 3.12353L57.65 43.1065C59.5278 44.2328 60.279 43.1065 60.279 41.9802V0.683279H71.7338V43.6696C71.7338 47.2362 68.7293 51.929 64.2224 53.6184C59.7156 55.3078 55.021 55.3079 49.3874 50.4273L14.6472 12.8846C13.7083 11.9461 11.2671 11.7584 11.2671 13.6355V54.9324Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                        <path d="M78.8696 0.683302H90.3245V39.5399C90.3245 43.6696 93.8924 43.6696 97.0848 43.6696H147.411C149.477 43.6696 151.918 41.2293 151.918 38.6014C151.918 35.9734 149.477 33.3454 147.223 33.3454H114.549C108.915 33.5331 97.2726 28.2771 97.2726 17.3898C97.2726 4.06213 108.352 0.871004 113.422 0.495577H206.188V11.9461H183.09V54.9324H171.823V11.9461H115.112C109.666 11.5707 105.911 20.7686 114.737 22.0826H149.665C154.923 22.0826 163.561 26.5877 163.748 37.8505C163.748 49.301 156.988 54.7447 149.665 54.7447H97.6481C89.1978 54.7447 86.0055 52.6799 83.0009 50.0519C80.1841 47.2362 79.8086 45.7345 78.8696 40.1031V0.683302Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="about__card about__card--map about__card--maskot">
                                <div class="about__card-info">
                                    <div class="about__card-text">Our advanced computer vision technology delivers </div>
                                    <div class="about__card-description">over 10,000 document types from 200+ countries & territories</div>
                                </div>
                                <div class="about__card-image">
                                    
                                </div>
                            </div>
                            <div class="teaser__maskot teaser__maskot--about">
                                <div class="teaser__maskot-head">
                                    <?php echo td_image(472, ['loading' => 'eager']); ?>    
                                </div>
                                <div class="teaser__maskot-hand">
                                    <?php echo td_image(471, ['loading' => 'eager']); ?>
                                </div>
                            </div>

                            <div class="about__card about__card--long about__card--certfication">
                                <div class="about__card-title">NeuroVision Global operates in compliance with ISO/IEC 27001:2022 and GDPR standards, covering the design, development, and operation of AI-based identity verification systems</div>
                                <div class="about__card-actions">
                                    <a href="https://nvglobal.local/wp-content/uploads/2026/06/neurovision_iso_27001_certificate.pdf" target="_blank" rel="noopener noreferrer" class="btn btn--small btn--gray btn-with-lottie-arrow-orange">
                                        <span class="btn__text">ISO/IEC 27001:2022</span>
                                        <span class="btn__icon lottie-container-arrow-orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                            </svg>
                                        </span>
                                    </a>
                                    <a href="https://nvglobal.local/wp-content/uploads/2026/06/neurovision_gdpr_certificate.pdf"  target="_blank" rel="noopener noreferrer" class="btn btn--small btn--gray btn-with-lottie-arrow-orange">
                                        <span class="btn__text">GDPR compliance certification</span>
                                        <span class="btn__icon lottie-container-arrow-orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                            </svg>
                                        </span>
                                    </a>
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

    <section class="video-intro section" id="get-to-know">
        <div class="container">
            <div class="video-intro__wrapper section__wrapper">
                <header class="video-intro__head">
                    <h2 class="video-intro__title">Let&rsquo;s get to know each other!</h2>
                    <p class="video-intro__subtitle">Our mascot, Nevi, will tell you about NeuroVision Global Systems</p>
                </header>
                <?php $vi_uri = get_template_directory_uri(); ?>
                <div class="video-intro__player">
                    <video class="video-intro__video"
                           preload="none"
                           playsinline
                           aria-label="Video introduction: our mascot Nevi tells you about NeuroVision Global Systems">
                        <source src="<?php echo $vi_uri; ?>/video/nvglobal_video.webm" type="video/webm">
                        <source src="<?php echo $vi_uri; ?>/video/nvglobal_video.mp4" type="video/mp4">
                    </video>
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
    <script>
        (function () {
            var player = document.querySelector('.video-intro__player');
            if (!player) return;
            var video = player.querySelector('.video-intro__video');
            var playBtn = player.querySelector('.video-intro__play');
            if (!video || !playBtn) return;
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

                    <div class="solutions__title-block">
                        <h2 class="solutions__title section__title">Solutions&nbsp;Tailored to&nbsp;Your&nbsp;Industry</h2>
                    </div>
                    <div class="solutions__maskot animate-fade-up">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/solutions_maskot.png" alt="Solutions Tailored to Your Industry">
                    </div>
                    <div class="solutions__list">

                        <div class="solutions__item animate-fade-up">
                            <div class="solutions__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none">
                                    <g filter="url(#filter0_d_2005_7119)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3648 10.4289C9.83028 11.003 9.5 11.851 9.5 12.9172V16.2107C9.5 16.625 9.16421 16.9607 8.75 16.9607C8.33579 16.9607 8 16.625 8 16.2107V12.9172C8 11.5414 8.43009 10.3057 9.26696 9.40676C10.1095 8.5018 11.3075 8 12.7149 8H22.7851C24.1895 8 25.3872 8.50209 26.2302 9.40643C27.0677 10.3049 27.5 11.5405 27.5 12.9172V19.5043C27.5 20.8801 27.0699 22.1158 26.233 23.0147C25.3905 23.9197 24.1924 24.4215 22.7851 24.4215H17.3725C16.9583 24.4215 16.6225 24.0857 16.6225 23.6715C16.6225 23.2573 16.9583 22.9215 17.3725 22.9215H22.7851C23.8219 22.9215 24.6063 22.5608 25.1352 21.9926C25.6697 21.4185 26 20.5705 26 19.5043V12.9172C26 11.8518 25.6685 11.0038 25.1329 10.4292C24.6028 9.86045 23.8181 9.5 22.7851 9.5H12.7149C11.6781 9.5 10.8937 9.86074 10.3648 10.4289Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 14.0443C8 13.6301 8.33579 13.2943 8.75 13.2943H26.75C27.1642 13.2943 27.5 13.6301 27.5 14.0443C27.5 14.4585 27.1642 14.7943 26.75 14.7943H8.75C8.33579 14.7943 8 14.4585 8 14.0443Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3457 17.7225C11.6596 17.7225 11.9403 17.9181 12.0492 18.2126L12.1502 18.4859C12.4553 19.3117 13.1052 19.9623 13.929 20.2676L14.202 20.3687C14.4961 20.4777 14.6914 20.7583 14.6914 21.072C14.6914 21.3857 14.4961 21.6663 14.202 21.7753L13.929 21.8764C13.1052 22.1817 12.4553 22.8323 12.1502 23.658L12.0492 23.9314C11.9404 24.2259 11.6596 24.4215 11.3457 24.4215C11.0317 24.4215 10.7509 24.2259 10.6421 23.9314L10.5411 23.658C10.236 22.8323 9.58613 22.1817 8.76233 21.8764L8.48935 21.7752C8.19522 21.6662 8 21.3857 8 21.072C8 20.7583 8.19522 20.4778 8.48935 20.3687L8.76228 20.2676C9.58609 19.9623 10.236 19.3117 10.5411 18.486L10.6421 18.2126C10.751 17.9181 11.0317 17.7225 11.3457 17.7225ZM11.3457 22.0215C11.6128 21.6595 11.9326 21.3394 12.2943 21.072C11.9326 20.8046 11.6128 20.4845 11.3457 20.1225C11.0785 20.4845 10.7587 20.8046 10.397 21.072C10.7587 21.3394 11.0785 21.6595 11.3457 22.0215Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.159 17.0548C17.4892 17.0548 17.7805 17.2708 17.8766 17.5867C17.9756 17.9125 18.23 18.167 18.5543 18.2658C18.87 18.362 19.0856 18.6533 19.0856 18.9832C19.0856 19.3132 18.87 19.6044 18.5543 19.7006C18.23 19.7995 17.9756 20.0539 17.8766 20.3798C17.7805 20.6957 17.4892 20.9117 17.159 20.9117C16.8288 20.9117 16.5374 20.6957 16.4414 20.3798C16.3423 20.0539 16.0879 19.7995 15.7636 19.7006C15.448 19.6044 15.2323 19.3132 15.2323 18.9832C15.2323 18.6533 15.448 18.3621 15.7636 18.2658C16.0879 18.167 16.3423 17.9126 16.4414 17.5867C16.5374 17.2708 16.8288 17.0548 17.159 17.0548Z" fill="#F9AA66"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_2005_7119" x="0" y="0" width="35.5" height="32.4215" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                        <feOffset/>
                                        <feGaussianBlur stdDeviation="4"/>
                                        <feComposite in2="hardAlpha" operator="out"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_7119"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_7119" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            </div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">FinTech</div>
                                <div class="solutions__item-description">Lightning-fast online customer verification that boosts conversion rates while meeting regulatory compliance. Transform your onboarding with instant KYC that users actually love.</div>
                            </div>
                            <div class="solutions__item-action">
                                <a href="/solutions/" class="btn btn-with-lottie-arrow">
                                    <span class="btn__text">Learn more</span>
                                    <span class="btn__icon lottie-container-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="solutions__item animate-fade-up">
                            <div class="solutions__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 35 36" fill="none">
                                    <g filter="url(#filter0_d_2005_2852)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1226 26V18.0039H25.7117C26.1259 18.0039 26.4617 17.6681 26.4617 17.2539C26.4617 16.8397 26.1259 16.5039 25.7117 16.5039H25.0874C24.7329 12.7441 21.7407 9.75152 17.9809 9.3968L17.9813 8.75043C17.9815 8.33621 17.6459 8.00024 17.2317 8C16.8175 7.99976 16.4815 8.33536 16.4813 8.74957L16.4809 9.39671C12.7207 9.75098 9.7276 12.7437 9.37307 16.5039H8.75C8.33579 16.5039 8 16.8397 8 17.2539C8 17.6681 8.33579 18.0039 8.75 18.0039H9.33789V26H8.75C8.33579 26 8 26.3358 8 26.75C8 27.1642 8.33579 27.5 8.75 27.5H10.0879H13.6605H17.2312H20.8019H24.3726H25.7117C26.1259 27.5 26.4617 27.1642 26.4617 26.75C26.4617 26.3358 26.1259 26 25.7117 26H25.1226ZM23.6226 26V18.0039H21.5519V26H23.6226ZM20.0519 26V18.0039H17.9812V26H20.0519ZM16.4812 26V18.0039H14.4105V26H16.4812ZM12.9105 26V18.0039H10.8379V26H12.9105ZM23.579 16.5039H20.8019H17.2312H13.6605H10.8814C11.2528 13.3271 13.9539 10.8616 17.2304 10.8616C20.5068 10.8616 23.2077 13.3271 23.579 16.5039Z" fill="#F9AA66"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_2005_2852" x="0" y="0" width="34.4617" height="35.5" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                        <feOffset/>
                                        <feGaussianBlur stdDeviation="4"/>
                                        <feComposite in2="hardAlpha" operator="out"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2852"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2852" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            </div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Banks</div>
                                <div class="solutions__item-description">Secure identity verification for remote account opening and fraud prevention. Enable seamless digital banking experiences while maintaining the highest security standards.</div>
                            </div>
                             <div class="solutions__item-action">
                                <a href="/solutions/" class="btn btn-with-lottie-arrow">
                                    <span class="btn__text">Learn more</span>
                                    <span class="btn__icon lottie-container-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="solutions__item animate-fade-up">
                            <div class="solutions__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                  <g filter="url(#filter0_d_3001_9687)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.06445 14.574C8.06445 10.9404 11.014 8 14.6375 8C18.2706 8 21.2115 10.941 21.2115 14.574C21.2115 14.7628 21.2014 14.94 21.1927 15.0937L21.1924 15.0989C21.1688 15.5124 20.8145 15.8286 20.4009 15.805C19.9874 15.7815 19.6713 15.4271 19.6948 15.0136C19.7039 14.8537 19.7115 14.7159 19.7115 14.574C19.7115 11.7694 17.4421 9.5 14.6375 9.5C11.8412 9.5 9.56445 11.77 9.56445 14.574C9.56445 17.3697 11.8418 19.6471 14.6375 19.6471C14.7687 19.6471 14.893 19.6407 15.0384 19.6333C15.0526 19.6326 15.0671 19.6318 15.0817 19.6311C15.4954 19.6102 15.8478 19.9285 15.8687 20.3422C15.8897 20.7559 15.5713 21.1082 15.1576 21.1292C15.1428 21.1299 15.1276 21.1307 15.1122 21.1315C14.9718 21.1387 14.8093 21.1471 14.6375 21.1471C11.0134 21.1471 8.06445 18.1981 8.06445 14.574Z" fill="#F9AA66"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3555 20.8611C14.3555 17.2309 17.2985 14.2891 20.9275 14.2891C24.5576 14.2891 27.4996 17.231 27.4996 20.8611C27.4996 24.4912 24.5576 27.4332 20.9275 27.4332C17.2985 27.4332 14.3555 24.4913 14.3555 20.8611ZM20.9275 15.7891C18.1268 15.7891 15.8555 18.0595 15.8555 20.8611C15.8555 23.6627 18.1268 25.9332 20.9275 25.9332C23.7292 25.9332 25.9996 23.6628 25.9996 20.8611C25.9996 18.0595 23.7292 15.7891 20.9275 15.7891Z" fill="#F9AA66"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.59699 21.346C9.00248 21.2615 9.39976 21.5216 9.48435 21.9271C9.84626 23.662 11.1042 25.1059 12.7975 25.6877C13.1892 25.8222 13.3977 26.2489 13.2631 26.6407C13.1285 27.0324 12.7018 27.2408 12.3101 27.1063C10.1121 26.3511 8.4849 24.4814 8.01596 22.2334C7.93137 21.8279 8.19151 21.4306 8.59699 21.346Z" fill="#F9AA66"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.0175 8.62565C22.1521 8.23391 22.5787 8.02545 22.9705 8.16004C25.1685 8.91524 26.7957 10.7849 27.2646 13.0329C27.3492 13.4384 27.0891 13.8357 26.6836 13.9203C26.2781 14.0048 25.8808 13.7447 25.7962 13.3392C25.4343 11.6043 24.1763 10.1604 22.4831 9.57865C22.0913 9.44406 21.8829 9.01739 22.0175 8.62565Z" fill="#F9AA66"/>
                                  </g>
                                  <defs>
                                    <filter id="filter0_d_3001_9687" x="0" y="0" width="35.4996" height="35.4332" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                      <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                      <feOffset/>
                                      <feGaussianBlur stdDeviation="4"/>
                                      <feComposite in2="hardAlpha" operator="out"/>
                                      <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3001_9687"/>
                                      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3001_9687" result="shape"/>
                                    </filter>
                                  </defs>
                                </svg>
                            </div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Crypto Exchanges</div>
                                <div class="solutions__item-description">Complete AML compliance for cryptocurrency platforms: document and face verification that stops fake accounts and money laundering attempts in their tracks.</div>
                            </div>
                            <div class="solutions__item-action">
                                <a href="/solutions/" class="btn btn-with-lottie-arrow">
                                    <span class="btn__text">Learn more</span>
                                    <span class="btn__icon lottie-container-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="solutions__item animate-fade-up">
                            <div class="solutions__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="34" viewBox="0 0 36 34" fill="none">
                                    <g filter="url(#filter0_d_2005_3470)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.169 8.21984C11.3096 8.07909 11.5005 8 11.6995 8H23.7999C24.2141 8 24.5499 8.33579 24.5499 8.75H23.7999C24.5499 8.75 24.5499 8.75 24.5499 8.75V8.76114L24.5497 8.78764C24.5495 8.81031 24.5491 8.8429 24.5483 8.88475C24.5467 8.96844 24.5436 9.08924 24.5375 9.24187C24.5252 9.54695 24.5008 9.98019 24.4522 10.4991C24.3551 11.5334 24.1603 12.9247 23.766 14.3261C23.3742 15.7186 22.7701 17.1774 21.8218 18.3007C20.9952 19.28 19.9019 20.0063 18.4966 20.1967V21.4433H20.9899C21.316 21.4433 21.6048 21.6541 21.7042 21.9648L22.4247 24.2164H23.4943C23.9085 24.2164 24.2443 24.5522 24.2443 24.9664C24.2443 25.3806 23.9085 25.7164 23.4943 25.7164H21.8997C21.8846 25.7169 21.8695 25.7169 21.8544 25.7164H13.789C13.774 25.7169 13.7589 25.7169 13.7437 25.7164H12.1489C11.7347 25.7164 11.3989 25.3806 11.3989 24.9664C11.3989 24.5522 11.7347 24.2164 12.1489 24.2164H13.2188L13.9393 21.9648C14.0387 21.6541 14.3274 21.4433 14.6536 21.4433H16.9966V20.1951C15.5973 20.0021 14.5076 19.2772 13.683 18.3008C12.7343 17.1776 12.1294 15.7189 11.7368 14.3265C11.3417 12.9252 11.146 11.5338 11.0483 10.4996C10.9993 9.98065 10.9746 9.54742 10.9622 9.24234C10.956 9.08971 10.9528 8.96891 10.9512 8.88523C10.9504 8.84338 10.9499 8.81078 10.9497 8.78811L10.9495 8.76162L10.9495 8.7518C10.9495 8.7518 10.9495 8.75048 11.6995 8.75L10.9495 8.75048C10.9493 8.55148 11.0283 8.3606 11.169 8.21984ZM12.4766 9.5C12.4902 9.74099 12.5108 10.0313 12.5417 10.3586C12.6343 11.3392 12.8182 12.6343 13.1805 13.9195C13.5454 15.2135 14.0759 16.4413 14.829 17.333C15.5632 18.2023 16.499 18.746 17.7526 18.746C19.0064 18.746 19.9419 18.2023 20.6756 17.3331C21.4282 16.4417 21.9579 15.2139 22.322 13.9199C22.6836 12.6348 22.8667 11.3396 22.9587 10.359C22.9894 10.0316 23.0098 9.74108 23.0233 9.5H12.4766ZM17.7189 22.9433H15.201L14.7937 24.2164H20.8497L20.4424 22.9433H17.7743C17.7651 22.9437 17.7559 22.9438 17.7466 22.9438C17.7373 22.9438 17.7281 22.9437 17.7189 22.9433Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.02782 10.427C8.0704 10.0475 8.39129 9.76059 8.77315 9.76059H11.8041C12.2183 9.76059 12.5541 10.0964 12.5541 10.5106C12.5541 10.9248 12.2183 11.2606 11.8041 11.2606H9.50301C9.51279 11.5944 9.54877 12.0227 9.64517 12.4889C9.86666 13.56 10.3887 14.7555 11.5646 15.5296C11.9106 15.7573 12.0064 16.2225 11.7786 16.5684C11.5508 16.9144 11.0857 17.0103 10.7398 16.7824C9.11041 15.7098 8.44297 14.0825 8.17624 12.7927C8.04211 12.144 8.00466 11.5614 8.00042 11.1405C7.9983 10.9293 8.00452 10.7568 8.01155 10.6344C8.01506 10.5732 8.0188 10.5243 8.02181 10.4893C8.02332 10.4718 8.02465 10.4577 8.02569 10.4473L8.02702 10.4343L8.02767 10.4283L8.02782 10.427C8.02782 10.427 8.02782 10.427 8.77315 10.5106L8.02782 10.427Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.9453 10.5106C22.9453 10.0964 23.2811 9.76059 23.6953 9.76059H26.7263C27.1081 9.76059 27.429 10.0475 27.4716 10.427L26.7263 10.5106C27.4716 10.427 27.4716 10.427 27.4716 10.427L27.4719 10.43L27.4724 10.4343L27.4737 10.4473C27.4748 10.4577 27.4761 10.4718 27.4776 10.4893C27.4806 10.5243 27.4843 10.5732 27.4879 10.6344C27.4949 10.7568 27.5011 10.9293 27.499 11.1405C27.4947 11.5614 27.4573 12.144 27.3232 12.7927C27.0564 14.0825 26.389 15.7098 24.7596 16.7824C24.4137 17.0103 23.9486 16.9144 23.7208 16.5684C23.493 16.2225 23.5889 15.7573 23.9348 15.5296C25.1107 14.7555 25.6328 13.56 25.8542 12.4889C25.9506 12.0227 25.9866 11.5944 25.9964 11.2606H23.6953C23.2811 11.2606 22.9453 10.9248 22.9453 10.5106Z" fill="#F9AA66"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_2005_3470" x="0" y="0" width="35.4995" height="33.7167" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                        <feOffset/>
                                        <feGaussianBlur stdDeviation="4"/>
                                        <feComposite in2="hardAlpha" operator="out"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_3470"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_3470" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            </div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Gambling</div>
                                <div class="solutions__item-description">Swift KYC verification for players that satisfies licensing requirements and keeps minors out. Get players in the game faster with identity checks that take seconds, not hours.</div>
                            </div>
                            <div class="solutions__item-action">
                                <a href="/solutions/" class="btn btn-with-lottie-arrow">
                                    <span class="btn__text">Learn more</span>
                                    <span class="btn__icon lottie-container-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="solutions__item animate-fade-up">
                            <div class="solutions__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="36" viewBox="0 0 34 36" fill="none">
                                    <g filter="url(#filter0_d_2005_3090)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6469 9.5C10.9088 9.5 9.5 10.9088 9.5 12.6469V21.8816C9.5 23.6196 10.9088 25.0284 12.6469 25.0284H15.0989C15.5131 25.0284 15.8489 25.3642 15.8489 25.7784C15.8489 26.1927 15.5131 26.5284 15.0989 26.5284H12.6469C10.0804 26.5284 8 24.4481 8 21.8816V12.6469C8 10.0804 10.0804 8 12.6469 8H19.3606C21.9271 8 24.0074 10.0804 24.0074 12.6469V15.8305C24.0074 16.2447 23.6717 16.5805 23.2574 16.5805C22.8432 16.5805 22.5074 16.2447 22.5074 15.8305V12.6469C22.5074 10.9088 21.0986 9.5 19.3606 9.5H12.6469Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0205 14.4062C12.0205 13.992 12.3563 13.6562 12.7705 13.6562H16.6547C17.0689 13.6562 17.4047 13.992 17.4047 14.4062C17.4047 14.8205 17.0689 15.1562 16.6547 15.1562H12.7705C12.3563 15.1562 12.0205 14.8205 12.0205 14.4062ZM12.0195 18.6033C12.0195 18.189 12.3553 17.8533 12.7695 17.8533H14.3555C14.7698 17.8533 15.1056 18.189 15.1056 18.6033C15.1056 19.0175 14.7698 19.3533 14.3555 19.3533H12.7695C12.3553 19.3533 12.0195 19.0175 12.0195 18.6033Z" fill="#F9AA66"/>
                                        <path d="M20.8399 27.3504C20.6083 27.351 20.3788 27.306 20.1647 27.2178C19.9505 27.1296 19.7559 27 19.5919 26.8364L19.2589 26.5044C19.2078 26.4539 19.1388 26.4255 19.0669 26.4254H18.6019C18.1317 26.4246 17.681 26.2375 17.3487 25.9049C17.0163 25.5724 16.8294 25.1216 16.8289 24.6514V24.1834C16.8293 24.1463 16.8223 24.1095 16.8082 24.0751C16.7941 24.0408 16.7733 24.0096 16.7469 23.9834L16.4249 23.6614C16.0932 23.3306 15.906 22.8818 15.9044 22.4133C15.9027 21.9448 16.0866 21.4947 16.4159 21.1614L16.4459 21.1324L16.7459 20.8324C16.7966 20.7814 16.825 20.7124 16.8249 20.6404V20.1754C16.8257 19.7055 17.0126 19.2551 17.3447 18.9226C17.6767 18.5902 18.127 18.4028 18.5969 18.4014H19.0639C19.1361 18.4014 19.2054 18.373 19.2569 18.3224L19.5799 17.9994C19.9116 17.6663 20.3619 17.4783 20.832 17.4766C21.3022 17.4749 21.7538 17.6597 22.0879 17.9904L22.4189 18.3214C22.444 18.3468 22.4739 18.367 22.5068 18.3807C22.5398 18.3945 22.5752 18.4015 22.6109 18.4014H23.0779C23.5482 18.402 23.9991 18.589 24.3317 18.9216C24.6643 19.2542 24.8513 19.7051 24.8519 20.1754V20.6414C24.8522 20.7131 24.8802 20.7818 24.9299 20.8334L25.2559 21.1594C25.5881 21.4915 25.7751 21.9416 25.7762 22.4112C25.7774 22.8808 25.5924 23.3318 25.2619 23.6654L24.9289 23.9984C24.8796 24.0489 24.8523 24.1169 24.8529 24.1874V24.6554C24.8524 25.1254 24.6654 25.576 24.3329 25.9082C24.0005 26.2404 23.5499 26.4272 23.0799 26.4274H22.6099C22.5747 26.4273 22.5397 26.4341 22.5071 26.4475C22.4745 26.4609 22.4449 26.4806 22.4199 26.5054L22.0909 26.8324C21.9277 26.9976 21.7334 27.1288 21.5192 27.2184C21.3049 27.308 21.0751 27.3543 20.8429 27.3544L20.8399 27.3504ZM17.4679 22.2304C17.4228 22.283 17.3992 22.3507 17.402 22.4199C17.4048 22.4891 17.4337 22.5547 17.4829 22.6034L17.8109 22.9324C18.1424 23.2644 18.3287 23.7143 18.3289 24.1834V24.6514C18.3289 24.7239 18.3576 24.7935 18.4088 24.8448C18.46 24.8962 18.5294 24.9252 18.6019 24.9254H19.0669C19.5357 24.9263 19.9852 25.1121 20.3179 25.4424L20.6429 25.7664C20.669 25.793 20.7001 25.814 20.7345 25.8282C20.7688 25.8425 20.8057 25.8497 20.8429 25.8494C20.8785 25.8497 20.9138 25.8427 20.9466 25.829C20.9794 25.8152 21.0091 25.795 21.0339 25.7694L21.3649 25.4394C21.5287 25.275 21.7237 25.1448 21.9382 25.0562C22.1528 24.9676 22.3827 24.9225 22.6149 24.9234H23.0839C23.1199 24.9236 23.1556 24.9166 23.1889 24.9028C23.2222 24.8891 23.2524 24.8689 23.2779 24.8434C23.329 24.7918 23.3577 24.7221 23.3579 24.6494V24.1834C23.3569 23.7154 23.5417 23.2662 23.8719 22.9344L24.2009 22.6054C24.2265 22.5799 24.2467 22.5496 24.2606 22.5162C24.2744 22.4828 24.2815 22.4471 24.2815 22.4109C24.2815 22.3748 24.2744 22.339 24.2606 22.3057C24.2467 22.2723 24.2265 22.242 24.2009 22.2164L23.8739 21.8884C23.7094 21.7244 23.579 21.5294 23.4902 21.3147C23.4015 21.0999 23.3562 20.8698 23.3569 20.6374V20.1714C23.3569 20.0988 23.3281 20.0291 23.2767 19.9777C23.2253 19.9263 23.1555 19.8974 23.0829 19.8974H22.6159C22.3835 19.8981 22.1532 19.8527 21.9385 19.7638C21.7237 19.6749 21.5288 19.5442 21.3649 19.3794L21.0399 19.0564L21.0249 19.0424C20.9748 18.9971 20.9095 18.9721 20.8419 18.9724C20.806 18.9723 20.7705 18.9794 20.7374 18.9931C20.7042 19.0068 20.6742 19.027 20.6489 19.0524L20.3229 19.3794C19.9895 19.7101 19.5394 19.8962 19.0699 19.8974H18.6039C18.5314 19.8977 18.4619 19.9267 18.4108 19.978C18.3596 20.0294 18.3309 20.0989 18.3309 20.1714V20.6374C18.3312 20.8696 18.2858 21.0995 18.1971 21.314C18.1084 21.5285 17.9781 21.7234 17.8139 21.8874L17.4889 22.2134L17.4679 22.2304ZM20.3659 24.1404C20.2672 24.1404 20.1695 24.1208 20.0784 24.0829C19.9872 24.0449 19.9045 23.9894 19.8349 23.9194L18.9149 22.9974C18.7785 22.8558 18.7031 22.6662 18.7051 22.4696C18.7071 22.2729 18.7862 22.0849 18.9255 21.9461C19.0647 21.8072 19.253 21.7286 19.4496 21.7272C19.6463 21.7257 19.8356 21.8016 19.9769 21.9384L20.3669 22.3284L21.7329 20.9624C21.8743 20.8258 22.0637 20.7501 22.2604 20.7517C22.457 20.7533 22.6451 20.8321 22.7842 20.9711C22.9234 21.1101 23.0023 21.2981 23.0041 21.4948C23.0059 21.6914 22.9304 21.8809 22.7939 22.0224L20.8939 23.9224C20.7535 24.0618 20.5637 24.1402 20.3659 24.1404Z" fill="#F9AA66"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_2005_3090" x="0" y="0" width="33.7761" height="35.3545" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                        <feOffset/>
                                        <feGaussianBlur stdDeviation="4"/>
                                        <feComposite in2="hardAlpha" operator="out"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_3090"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_3090" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            </div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Insurance</div>
                                <div class="solutions__item-description">Remote policyholder identification that accelerates claims processing while maintaining strict identity control. Build trust through secure, hassle-free verification.</div>
                            </div>
                            <div class="solutions__item-action">
                                <a href="/solutions/" class="btn btn-with-lottie-arrow">
                                    <span class="btn__text">Learn more</span>
                                    <span class="btn__icon lottie-container-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="solutions__item animate-fade-up">
                            <div class="solutions__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                    <g filter="url(#filter0_d_2005_4885)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9157 8.23611C17.4036 7.9213 18.032 7.9213 18.5199 8.23611L26.7206 13.5296C27.14 13.8021 27.3955 14.269 27.3955 14.7723V15.3471C27.3955 16.1643 26.7324 16.8262 25.9155 16.8262H9.52005C8.70319 16.8262 8.04005 16.1643 8.04005 15.3471V14.7723C8.04005 14.2686 8.29594 13.8012 8.71731 13.5288L16.9157 8.23611ZM17.7178 9.50369L9.54005 14.783V15.3262H25.8955V14.7824L17.7178 9.50369Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7178 12.2637C18.132 12.2637 18.4678 12.5995 18.4678 13.0137V13.0237C18.4678 13.4379 18.132 13.7737 17.7178 13.7737C17.3036 13.7737 16.9678 13.4379 16.9678 13.0237V13.0137C16.9678 12.5995 17.3036 12.2637 17.7178 12.2637Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.41673 24.2134C8.54392 23.6357 9.05628 23.2244 9.64746 23.2244H25.788C26.3792 23.2244 26.8917 23.6358 27.0188 24.2137L27.4055 25.9691C27.5776 26.7528 26.9826 27.4999 26.1758 27.4999H9.26065C8.45581 27.4999 7.8573 26.7554 8.02979 25.9696L8.41673 24.2134ZM9.84012 24.7244L9.55909 25.9999H25.8763L25.5953 24.7244H9.84012Z" fill="#F9AA66"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9448 15.3259C11.359 15.3259 11.6948 15.6617 11.6948 16.0759V23.9751C11.6948 24.3893 11.359 24.7251 10.9448 24.7251C10.5306 24.7251 10.1948 24.3893 10.1948 23.9751V16.0759C10.1948 15.6617 10.5306 15.3259 10.9448 15.3259ZM15.4589 15.3259C15.8731 15.3259 16.2089 15.6617 16.2089 16.0759V23.9751C16.2089 24.3893 15.8731 24.7251 15.4589 24.7251C15.0446 24.7251 14.7089 24.3893 14.7089 23.9751V16.0759C14.7089 15.6617 15.0446 15.3259 15.4589 15.3259ZM19.9748 15.3259C20.389 15.3259 20.7248 15.6617 20.7248 16.0759V23.9751C20.7248 24.3893 20.389 24.7251 19.9748 24.7251C19.5606 24.7251 19.2248 24.3893 19.2248 23.9751V16.0759C19.2248 15.6617 19.5606 15.3259 19.9748 15.3259ZM24.4888 15.3259C24.9031 15.3259 25.2388 15.6617 25.2388 16.0759V23.9751C25.2388 24.3893 24.9031 24.7251 24.4888 24.7251C24.0746 24.7251 23.7388 24.3893 23.7388 23.9751V16.0759C23.7388 15.6617 24.0746 15.3259 24.4888 15.3259Z" fill="#F9AA66"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_2005_4885" x="0" y="0" width="35.4353" height="35.5" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                        <feOffset/>
                                        <feGaussianBlur stdDeviation="4"/>
                                        <feComposite in2="hardAlpha" operator="out"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_4885"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_4885" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            </div>
                            <div class="solutions__item-info">
                                <div class="solutions__item-title">Government</div>
                                <div class="solutions__item-description">Advanced face recognition systems for public services and security applications. Deliver efficient citizen services with technology that respects privacy and compliance requirements.</div>
                            </div>
                            <div class="solutions__item-action">
                                <a href="/solutions/" class="btn btn-with-lottie-arrow">
                                    <span class="btn__text">Learn more</span>
                                    <span class="btn__icon lottie-container-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                        </svg>
                                    </span>
                                </a>
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
                <div class="products__info-top">
                    <div class="section__badge">Products</div>
                    <div class="section__title-block products__title-block">
                        <h2 class="products__title section__title">Our&nbsp;AI-Powered Identity&nbsp;Solutions</h2>
                        <p class="section__subtitle">Everything you need to verify, authenticate, and&nbsp;protect your customers — all&nbsp;in&nbsp;one powerful&nbsp;platform</p>
                    </div>
                </div>

                <div class="products__info-bottom">
                    <div class="products__info-description">
                        Ready to transform your identity verification? <br>Join hundreds of&nbsp;companies processing millions of&nbsp;verifications&nbsp;with NV Global
                    </div>
                    <div class="products__info-actions">
                        <button class="btn-hero open-callForm">
                            <span class="btn__text btn__text-hero">Request a Demo</span>
                            <div class="btn__icon btn__icon-arrow"></div>
                        </button>
                        <button class="btn btn--transparent open-callForm2 btn-with-lottie">
                            <span class="btn__text">Talk to Sales</span>
                            <span class="btn__icon lottie-container">
                                <!-- Ваша существующая SVG иконка остаётся здесь как fallback -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21.7038 10.5392C21.3268 10.5392 21.0028 10.2562 20.9598 9.87322C20.5798 6.49722 17.9568 3.87722 14.5808 3.50222C14.1698 3.45622 13.8728 3.08622 13.9188 2.67422C13.9638 2.26322 14.3328 1.95622 14.7468 2.01222C18.8238 2.46422 21.9918 5.62822 22.4498 9.70522C22.4968 10.1172 22.1998 10.4882 21.7888 10.5342C21.7608 10.5372 21.7318 10.5392 21.7038 10.5392Z" fill="#FBFBFB"/>
                                    <path d="M18.1625 10.55C17.8105 10.55 17.4975 10.302 17.4275 9.94398C17.1395 8.46398 15.9985 7.32298 14.5205 7.03598C14.1135 6.95698 13.8485 6.56398 13.9275 6.15698C14.0065 5.74998 14.4095 5.48498 14.8065 5.56398C16.8875 5.96798 18.4945 7.57398 18.8995 9.65598C18.9785 10.064 18.7135 10.457 18.3075 10.536C18.2585 10.545 18.2105 10.55 18.1625 10.55Z" fill="#FBFBFB"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.48215 16.8361C12.1952 21.5501 15.3332 22.7861 17.3152 22.7861C18.2932 22.7861 18.9912 22.4851 19.4562 22.1511C19.4772 22.1391 21.6292 20.8231 22.0062 18.8311C22.1842 17.8961 21.9242 16.9711 21.2562 16.1551C18.5042 12.8141 17.1022 13.1261 15.5542 13.8791C14.6032 14.3451 13.8522 14.7071 11.7312 12.5881C9.6114 10.4674 9.97707 9.71628 10.44 8.76544C11.194 7.21744 11.5042 5.81511 8.16215 3.06111C7.34815 2.39611 6.42915 2.13611 5.49515 2.31111C3.53215 2.67811 2.20815 4.79511 2.21015 4.79511C1.15815 6.27211 0.444156 9.79911 7.48215 16.8361ZM5.80115 3.77911C5.88915 3.76511 5.97615 3.75711 6.06215 3.75711C6.45415 3.75711 6.83215 3.91011 7.20915 4.22011C9.90413 6.44009 9.56316 7.1401 9.09116 8.10908C8.38216 9.56608 8.01115 10.9881 10.6702 13.6491C13.3322 16.3101 14.7552 15.9391 16.2102 15.2281L16.2126 15.2269C17.1804 14.7565 17.8801 14.4164 20.0972 17.1081C20.4762 17.5701 20.6212 18.0321 20.5392 18.5191C20.3502 19.6391 19.0482 20.6421 18.6542 20.8861C17.2432 21.8921 13.8462 21.0791 8.54215 15.7761C3.24015 10.4731 2.42615 7.07611 3.46815 5.61111C3.67615 5.27211 4.68315 3.96811 5.80115 3.77911Z" fill="#FBFBFB"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="products__slider">
                    <div class="products__slider-media animate-fade-up">
                        <div class="products__slider-image products__slider-image--desktop">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/products-image1.jpg" alt="Identity Verification">
                        </div>

                        <div class="products__slider-image-mobile swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image1.jpg" alt="Identity Verification">
                                </div>
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image2.jpg" alt="Face Recognition API/SDK">
                                </div>
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image3.jpg" alt="Liveness Detection">
                                </div>
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image4.jpg" alt="Document Verification">
                                </div>
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image5.jpg" alt="AML Screening">
                                </div>
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image6.jpg" alt="Authentication">
                                </div>
                                <div class="swiper-slide products__slider-image-slide">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/products-image7.jpg" alt="Video Analytics">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="products__slider-content">
                        <div class="products__slider-tabs">
                            <button type="button" class="products__slider-tab products__slider-tab--active">Identity Verification</button>
                            <button type="button" class="products__slider-tab">Face Recognition API/SDK</button>
                            <button type="button" class="products__slider-tab">Liveness Detection</button>
                            <button type="button" class="products__slider-tab">Document Verification</button>
                            <button type="button" class="products__slider-tab">AML Screening</button>
                            <button type="button" class="products__slider-tab">Authentication</button>
                            <button type="button" class="products__slider-tab">Video Analytics</button>
                        </div>

                        <div class="products__slider-wrapper animate-fade-up">
                            <div class="products__slider-arrows">
                                <button type="button" class="products__slider-arrow products__slider-arrow--prev products__slider-arrow--disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M10.0137 5.55638C10.3648 5.41074 10.7767 5.55248 10.9609 5.89427C11.1571 6.25876 11.0206 6.71341 10.6562 6.90989C10.6558 6.91012 10.6545 6.91025 10.6533 6.91087C10.651 6.91211 10.6476 6.91498 10.6426 6.91771C10.6324 6.92326 10.6164 6.93165 10.5957 6.9431C10.5541 6.96614 10.4925 7.00122 10.4131 7.04661C10.2537 7.13776 10.0238 7.27144 9.74805 7.44114C9.19501 7.78144 8.46189 8.26111 7.73242 8.82103C6.99842 9.38445 6.29193 10.011 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5894 5.77637 13.9079C6.29187 14.5388 6.99755 15.1651 7.73145 15.7283C8.46104 16.288 9.19491 16.7669 9.74805 17.1072C10.0236 17.2766 10.2527 17.4106 10.4121 17.5017C10.4916 17.5471 10.5541 17.5821 10.5957 17.6052C10.6165 17.6167 10.6324 17.626 10.6426 17.6316C10.6475 17.6342 10.6511 17.6362 10.6533 17.6374L10.6562 17.6384L10.7217 17.6784C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9577C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.9539 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9306 9.86914 18.9177C9.82212 18.8916 9.75372 18.8534 9.66797 18.8044C9.49654 18.7064 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.337 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2728 3.50097 12.2715 3.50098 12.2702C3.50295 11.3213 4.01126 10.4325 4.61426 9.69407C5.23299 8.93645 6.03997 8.22909 6.81836 7.63157C7.60128 7.0306 8.38067 6.52145 8.96191 6.1638C9.25325 5.98453 9.49653 5.84191 9.66797 5.74388C9.75368 5.69487 9.82214 5.65763 9.86914 5.63157C9.89234 5.61871 9.91016 5.60823 9.92285 5.6013C9.92922 5.59782 9.93494 5.59443 9.93848 5.59251C9.94003 5.59167 9.94143 5.59107 9.94238 5.59056L9.94336 5.58958H9.94434L10.0137 5.55638Z" fill="#FBFBFB"/>
                                    </svg>
                                </button>
                                <button type="button" class="products__slider-arrow products__slider-arrow--next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="products__slider-content-swiper swiper">
                                <div class="products__slider-list swiper-wrapper">

                                    <div class="products__slide products__slide--active swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image1.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                        <feOffset/>
                                                        <feGaussianBlur stdDeviation="4"/>
                                                        <feComposite in2="hardAlpha" operator="out"/>
                                                        <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Identity Verification</div>
                                            <div class="products__slidedescription">Complete eKYC in seconds. Our AI instantly verifies documents, matches selfies with IDs, and screens against global sanctions lists — turning hours of manual checks into a seamless 60-second experience for your customers</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">Learn more</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products__slide swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image2.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Face Recognition API/SDK</div>
                                            <div class="products__slidedescription">Add face recognition to your app in just one business day. Our developer-friendly API and SDKs work across all major platforms and languages, giving you the same 99.74% accuracy technology trusted by leading financial institutions worldwide.</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">View documentation</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products__slide swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image3.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Liveness Detection</div>
                                            <div class="products__slidedescription">Stop fraud before it starts. Our advanced AI detects deepfakes, masks, and photo spoofs in real-time, ensuring you're always dealing with a real person — not a sophisticated fake. Your customers simply look at their camera for instant verification.</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">See it in action</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products__slide swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image4.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Document Verification</div>
                                            <div class="products__slidedescription">Accept IDs from anywhere. Our AI reads and verifies passports, driver's licenses, and national IDs from over 200 countries in 90 languages. OCR, MRZ, barcodes — we handle it all, checking authenticity markers to catch even the best forgeries.</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">Explore coverage</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products__slide swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image5.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">AML Screening</div>
                                            <div class="products__slidedescription">Stay compliant without the complexity. Automatically screen customers against global sanctions, PEP lists, and watchlists with continuous monitoring. Get instant alerts when status changes, keeping your business protected 24/7.</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">Learn about compliance</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products__slide swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image6.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Authentication</div>
                                            <div class="products__slidedescription">Let your customers log in with just their face. Once verified, they can access their accounts instantly — no passwords to remember, no codes to type. Secure, convenient, and faster than any traditional login method.</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">Discover passwordless</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="products__slide swiper-slide" data-image="<?php echo get_template_directory_uri(); ?>/img/products-image7.jpg">
                                        <div class="products__slide-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="35" viewBox="0 0 36 35" fill="none">
                                                <g filter="url(#filter0_d_2005_2917)">
                                                    <path d="M15.9767 9.0911C16.7051 7.6363 18.799 7.6363 19.5274 9.0911L21.3546 12.7425L21.4171 12.8372C21.4908 12.9234 21.596 12.9831 21.7159 13.0003L25.8038 13.5882H25.8048C27.4176 13.8211 28.0904 15.7991 26.8976 16.9436L26.8966 16.9427L23.9415 19.7825C23.8293 19.8903 23.7814 20.0423 23.8067 20.1888V20.1897L24.505 24.1995V24.2005C24.7861 25.8253 23.0674 27.0175 21.6339 26.2727V26.2737L17.9796 24.3792V24.3782C17.8385 24.3051 17.6667 24.3043 17.5235 24.3782L13.8702 26.2737L13.8692 26.2727C12.4362 27.0165 10.717 25.8252 11.0001 24.1995L11.6974 20.1897V20.1888C11.7227 20.0423 11.6738 19.8913 11.5616 19.7835V19.7825L8.60751 16.9427L8.60654 16.9436C7.4137 15.7991 8.08653 13.8211 9.69931 13.5882H9.70029L13.7882 13.0003L13.9034 12.969C14.0119 12.9251 14.0998 12.8439 14.1505 12.7425L15.9767 9.09208V9.0911ZM18.1856 9.76298C18.0212 9.43466 17.5575 9.41428 17.3556 9.70145L17.3184 9.76298L15.4923 13.4134C15.2017 13.9948 14.6421 14.3927 14.0011 14.4847L9.91318 15.0725C9.5067 15.1317 9.37624 15.6025 9.64462 15.8606L9.6456 15.8616L12.6017 18.7015V18.7024C13.0411 19.125 13.2583 19.7241 13.1915 20.3265L13.1749 20.4466L12.4786 24.4563V24.4573C12.4166 24.8148 12.8069 25.1356 13.1788 24.9427L13.1798 24.9417L16.8331 23.0472H16.8341C17.4092 22.7496 18.0959 22.7487 18.671 23.0472L22.3243 24.9417L22.3253 24.9427C22.6737 25.1234 23.0401 24.8528 23.0333 24.5227L23.0265 24.4563L22.3292 20.4466C22.2174 19.8046 22.4338 19.1531 22.9024 18.7024V18.7015L25.8595 15.8606C26.128 15.6024 25.9969 15.1323 25.5899 15.0735L21.503 14.4847C20.9413 14.4041 20.4438 14.0889 20.1339 13.6224L20.0128 13.4134L18.1856 9.76298Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2005_2917" x="0" y="0" width="35.5042" height="34.4995" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2005_2917"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2005_2917" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="products__slide-content">
                                            <div class="products__slide-title">Video Analytics</div>
                                            <div class="products__slidedescription">Transform your security cameras into intelligent systems. Our face recognition works in real-time video streams, perfect for retail analytics, access control, or security monitoring. Track, analyze, and respond — all powered by the same trusted AI.</div>
                                            <div class="products__slide-action">
                                                <a href="/solutions/#solutions" class="btn btn-with-lottie-arrow">
                                                    <span class="btn__text">Explore use cases</span>
                                                    <span class="btn__icon lottie-container-arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                            <path d="M10.8658 4.45477C11.0296 4.15092 11.4091 4.03709 11.713 4.20086H11.7138L11.7146 4.20168C11.7154 4.20211 11.7165 4.20259 11.7179 4.20331C11.7208 4.20488 11.7249 4.20779 11.7301 4.21063C11.7406 4.21639 11.7562 4.22429 11.7756 4.23504C11.8148 4.25676 11.8718 4.2886 11.9433 4.32944C12.0861 4.41111 12.2889 4.53005 12.5317 4.67938C13.016 4.97731 13.6656 5.40118 14.318 5.90171C14.9666 6.39941 15.6383 6.98865 16.1539 7.61965C16.6575 8.23591 17.0833 8.97814 17.0833 9.77052L17.0784 9.91782C17.0299 10.6549 16.6269 11.344 16.1547 11.9222C15.6391 12.5535 14.9666 13.1422 14.318 13.6402C13.6655 14.1409 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1315 11.9433 15.2132C11.8718 15.2541 11.8148 15.2859 11.7756 15.3076C11.7565 15.3183 11.7414 15.3263 11.7309 15.332C11.7256 15.3349 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3418H11.713C11.4092 15.5056 11.0296 15.3925 10.8658 15.0887C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2407C11.124 14.2397 11.127 14.2381 11.1311 14.2359C11.1396 14.2312 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1654 11.3223 14.1276C11.4552 14.0517 11.6467 13.9403 11.8765 13.7988C12.3374 13.5153 12.9483 13.1156 13.5562 12.6489C14.1679 12.1794 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6203 15.668 10.3963H3.95825C3.61307 10.3963 3.33325 10.1165 3.33325 9.77134C3.33327 9.42618 3.61309 9.14634 3.95825 9.14634H15.6689C15.5624 8.92216 15.403 8.67596 15.1863 8.41066C14.7567 7.88489 14.1687 7.36225 13.557 6.89292C12.9491 6.42643 12.3375 6.02736 11.8765 5.74383C11.6469 5.60259 11.456 5.49098 11.3232 5.41506C11.2569 5.37716 11.2048 5.34801 11.1702 5.32879C11.1529 5.31923 11.1396 5.31226 11.1311 5.30763C11.1269 5.30534 11.1241 5.30297 11.1222 5.30194C11.1212 5.30142 11.1201 5.30132 11.1197 5.30112C10.8161 5.1374 10.7024 4.75853 10.8658 4.45477Z" fill="#2B323B"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="advantages section" id="advantages">
        <div class="container">
            <div class="section__wrapper advantages__wrapper">
                <div class="section__badge">Advantages</div>
                <div class="section__content">
                    <div class="section__title-block">
                        <h2 class="section__title">Why Teams Choose <span>NeuroVision Global</span></h2>
                    </div>
                    <div class="advantages__list">
                        <div class="advantages__row advantages__row-3">
                            <div class="advantage__item animate-fade-up">
                                <div class="advantage__item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                    </svg>
                                </div>
                                <div class="advantage__item-title">Top-Tier Accuracy</div>
                                <div class="advantage__item-description">99.74% face recognition accuracy — that's not marketing fluff, it's our NIST-verified score that puts us in the global <span>Top-24</span>. When every verification matters, you need technology that gets it right almost every single time</div>
                            </div>
                            <div class="advantage__item animate-fade-up">
                                <div class="advantage__item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                    </svg>
                                </div>
                                <div class="advantage__item-title">Lightning-Fast Integration</div>
                                <div class="advantage__item-description">One business day from start to live — seriously. With our REST API and ready-to-use SDKs for Web, iOS, and Android, plus documentation that actually makes sense, your dev team will thank you for choosing NV Global</div>
                            </div>
                            <div class="advantage__item animate-fade-up">
                                <div class="advantage__item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                    </svg>
                                </div>
                                <div class="advantage__item-title">Rich Recognition Features</div>
                                <div class="advantage__item-description">We analyze 10+ facial parameters beyond basic verification: age, gender, emotions, eye openness, masks, glasses — giving you deeper insights and more flexible verification options than any competitor.</div>
                            </div>
                        </div>

                        <div class="advantages__row advantages__row-2">
                            <div class="advantage__item advantage__item--image-hover animate-fade-up">
                                <div class="advantage__item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                    </svg>
                                </div>
                                <div class="advantage__item-title">Global Coverage</div>
                                <div class="advantage__item-description">Support for 10,000+ document types from 200+ countries and territories. Whether it's a passport from Paraguay or a driver's license from Denmark, our system recognizes them all — making global expansion actually global.</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/img/case_image_folder.png" alt="Global Coverage">
                            </div>
                            <div class="advantage__item advantage__item--image-hover animate-fade-up">
                                <div class="advantage__item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                        <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                    </svg>
                                </div>
                                <div class="advantage__item-title">Battle-Tested Anti-Fraud</div>
                                <div class="advantage__item-description">Our liveness detection and anti-spoofing algorithms stop fraudsters cold. Masks, photos, videos, deepfakes — we catch them all with iBeta Level 1-2 certified technology and advanced eye movement analysis.</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/img/case_image_shield.png" alt="Global Coverage">
                            </div>
                        </div>

                        <div class="advantages__row-2-1">
                            <div class="advantages__col-2">
                                <div class="advantages__row-2">
                                    <div class="advantage__item animate-fade-up">
                                        <div class="advantage__item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                                <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="advantage__item-title">Proven ROI Impact </div>
                                        <div class="advantage__item-description">Speed up customer onboarding by 5x while cutting verification costs by up to 70%. These aren't projections — they're real results our clients see every day. Better experience, lower costs, happier customers.</div>
                                    </div>
                                    <div class="advantage__item animate-fade-up">
                                        <div class="advantage__item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                                <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="advantage__item-title">Privacy-First Compliance</div>
                                        <div class="advantage__item-description">Full GDPR compliance with our unique instant vectorless face comparison technology. ISO 27001 certified data storage, end-to-end encryption — the security standards banks and governments trust. Your users' data stays protected, always.</div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="advantages__col-1">
                                <div class="advantages__row">
                                    <div class="advantage__item advantage__item--image-hover animate-fade-up">
                                        <div class="advantage__item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                                <path d="M26.0781 10.6914C26.4712 9.96221 27.3821 9.68901 28.1113 10.0821H28.1133L28.1152 10.084C28.1172 10.0851 28.1199 10.0862 28.123 10.0879C28.13 10.0917 28.1399 10.0987 28.1523 10.1055C28.1776 10.1193 28.2151 10.1383 28.2617 10.1641C28.3558 10.2162 28.4926 10.2926 28.6641 10.3907C29.0069 10.5867 29.4935 10.8721 30.0762 11.2305C31.2386 11.9455 32.7976 12.9628 34.3633 14.1641C35.92 15.3586 37.5321 16.7728 38.7695 18.2872C39.9781 19.7662 41 21.5475 41 23.4493L40.9883 23.8028C40.872 25.5718 39.9048 27.2257 38.7715 28.6133C37.5341 30.1285 35.92 31.5414 34.3633 32.7364C32.7975 33.9383 31.2387 34.9566 30.0762 35.6719C29.4935 36.0304 29.0069 36.3157 28.6641 36.5118C28.4926 36.6098 28.3557 36.6862 28.2617 36.7383C28.2157 36.7638 28.1795 36.7831 28.1543 36.7969C28.1416 36.8039 28.1301 36.8107 28.123 36.8145C28.1199 36.8162 28.1172 36.8174 28.1152 36.8184L28.1133 36.8204H28.1113C27.3822 37.2135 26.4713 36.942 26.0781 36.2129C25.685 35.4837 25.9583 34.5729 26.6875 34.1797C26.6883 34.1793 26.6911 34.179 26.6934 34.1778C26.6979 34.1753 26.7051 34.1714 26.7148 34.1661C26.7352 34.1549 26.767 34.1364 26.8086 34.1133C26.8917 34.0672 27.0151 33.9971 27.1738 33.9063C27.4926 33.724 27.9523 33.4567 28.5039 33.1172C29.61 32.4366 31.0762 31.4773 32.5352 30.3575C34.0032 29.2306 35.4161 27.9775 36.4473 26.7149C36.9664 26.0793 37.3478 25.4888 37.6035 24.9512H9.5C8.67157 24.9512 8 24.2796 8 23.4512C8.00005 22.6228 8.6716 21.9512 9.5 21.9512H37.6055C37.3499 21.4132 36.9675 20.8223 36.4473 20.1856C35.4162 18.9237 34.0052 17.6694 32.5371 16.543C31.0779 15.4234 29.6102 14.4657 28.5039 13.7852C27.9528 13.4462 27.4945 13.1784 27.1758 12.9961C27.0167 12.9052 26.8918 12.8352 26.8086 12.7891C26.7672 12.7661 26.7352 12.7494 26.7148 12.7383C26.7047 12.7328 26.6979 12.7271 26.6934 12.7247C26.6911 12.7234 26.6883 12.7232 26.6875 12.7227C25.9587 12.3298 25.6859 11.4205 26.0781 10.6914Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="advantage__item-title">Always-On Support</div>
                                        <div class="advantage__item-description">Round-the-clock quality monitoring with expert review available in just 3 minutes. Enterprise clients get dedicated account managers who actually know your business. Real people, real support, really there when you need us</div>
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/case_image_sound.png" alt="Always-On Support">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="advantages__image animate-fade-up">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/advantages__maskot.png" alt="Why Teams Choose NV Global">
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
                                <p class="section__subtitle">Leading banks, crypto exchanges, and government agencies choose NV Global</p>
                                <p class="section__description">From fintech startups to Fortune 500 companies, organizations trust our AI-powered identity verification to protect their users and streamline operations</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clients__content">
                    <div class="clients__list">

                        <div class="clients__item clients__item--bank">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Banks</div>
                                <div class="clients__item-description">Powering secure digital onboarding</div>
                            </div>
                            <div class="clients__item-icon">
                                
                            </div>
                        </div>

                        <div class="clients__item clients__item--crypto">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Crypto Exchanges</div>
                                <div class="clients__item-description">Enabling compliant KYC verification</div>
                            </div>
                            <div class="clients__item-icon">
                                
                            </div>
                        </div>

                        <div class="clients__item clients__item--goverment clients__item--active">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Government</div>
                                <div class="clients__item-description">Securing citizen identity services</div>
                            </div>
                            <div class="clients__item-icon">
                                
                            </div>
                        </div>

                        <div class="clients__item clients__item--insurance">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Insurance</div>
                                <div class="clients__item-description">Accelerating claim processing</div>
                            </div>
                            <div class="clients__item-icon">
                                
                            </div>
                        </div>

                        <div class="clients__item clients__item--gambling">
                            <div class="clients__item-info">
                                <div class="clients__item-title">Gambling</div>
                                <div class="clients__item-description">Verifying age and identity instantly</div>
                            </div>
                            <div class="clients__item-icon">
                                
                            </div>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </section>

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

    <section class="cases section animate-fade-up" id="cases">
        <div class="container">
            <div class="cases__wrapper">
                <div class="cases__title-left">
                    <div class="cases__title-block">
                        <div class="section__badge">Cases</div>
                        <h2 class="cases__title section__title">Success Stories That Speak for Themselves</h2>
                        <p class="section__subtitle cases__subtitle">See how leading companies transformed their identity verification with NV Global</p>
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
                                        <p class="cases__slide-description">When EasyPay integrated NV Global’s identity verification platform, they completely reimagined their account opening process. What used to take 2 days now happens in just 5 seconds. The result? A 40% reduction in customer drop-offs during registration and happier customers who can start banking immediately. Their KYC automation now handles thousands of verifications daily with 99.74% accuracy, all while maintaining full regulatory compliance.</p>
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
                                        <p class="cases__slide-description">In the high-stakes world of cryptocurrency trading, CryptoX needed a solution that could keep pace with their 24/7 operations while meeting strict AML5 requirements. NV Global's platform detected and prevented over 500 fraud attempts in the first month alone. Using our instant face matching technology (just 0.1 seconds per verification), CryptoX built trust with legitimate traders while keeping bad actors out. The platform's GDPR-compliant vectorless comparison technology meant they could expand across Europe without privacy concerns.</p>
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
                                        <p class="cases__slide-description">When a national government needed to verify identities for over 10 million citizens accessing digital services, they turned to NV Global. Our face recognition technology achieved a remarkable 99.87% first-attempt success rate, making government services accessible to citizens while maintaining the highest security standards. The system processes hundreds of thousands of verifications daily, supporting documents from over 200 countries & territories in 90 languages. This wasn't just about technology - it was about creating a seamless experience for millions of people interacting with essential services.</p>
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
                    <div class="cases__bottom-subtitle">Let's talk about how NeuroVision Global can transform your identity verification process.</div>
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

    <section class="doc section" id="documentation">
        <div class="container">
            <div class="doc__wrapper">
                <div class="doc__title-block">
                    <div class="section__badge">Documentation</div>
                    <h2 class="doc__title section__title">Developer Hub</h2>
                    <p class="doc__subtitle">Getting started with NV Global is refreshingly simple. Connect to our API or SDK and start verifying users today — no complex setup, no hidden complications, just straightforward integration that works.</p>
                </div>

                <div class="doc__actions-block">
                    <div class="doc__actions-text">Ready to build something amazing? Start integrating NV Global today with our free developer account</div>
                    <div class="doc__actions">
                        <button class="btn-hero open-callForm">
                            <span class="btn__text btn__text-hero">Get Your API Key</span>
                            <div class="btn__icon btn__icon-arrow"></div>
                        </button>
                        <button class="btn btn--transparent open-callForm2 btn--18 btn-with-lottie">
                            <span class="btn__text">Schedule Integration Call</span>
                            <span class="btn__icon lottie-container">
                                <!-- Ваша существующая SVG иконка остаётся здесь как fallback -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21.7038 10.5392C21.3268 10.5392 21.0028 10.2562 20.9598 9.87322C20.5798 6.49722 17.9568 3.87722 14.5808 3.50222C14.1698 3.45622 13.8728 3.08622 13.9188 2.67422C13.9638 2.26322 14.3328 1.95622 14.7468 2.01222C18.8238 2.46422 21.9918 5.62822 22.4498 9.70522C22.4968 10.1172 22.1998 10.4882 21.7888 10.5342C21.7608 10.5372 21.7318 10.5392 21.7038 10.5392Z" fill="#FBFBFB"/>
                                    <path d="M18.1625 10.55C17.8105 10.55 17.4975 10.302 17.4275 9.94398C17.1395 8.46398 15.9985 7.32298 14.5205 7.03598C14.1135 6.95698 13.8485 6.56398 13.9275 6.15698C14.0065 5.74998 14.4095 5.48498 14.8065 5.56398C16.8875 5.96798 18.4945 7.57398 18.8995 9.65598C18.9785 10.064 18.7135 10.457 18.3075 10.536C18.2585 10.545 18.2105 10.55 18.1625 10.55Z" fill="#FBFBFB"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.48215 16.8361C12.1952 21.5501 15.3332 22.7861 17.3152 22.7861C18.2932 22.7861 18.9912 22.4851 19.4562 22.1511C19.4772 22.1391 21.6292 20.8231 22.0062 18.8311C22.1842 17.8961 21.9242 16.9711 21.2562 16.1551C18.5042 12.8141 17.1022 13.1261 15.5542 13.8791C14.6032 14.3451 13.8522 14.7071 11.7312 12.5881C9.6114 10.4674 9.97707 9.71628 10.44 8.76544C11.194 7.21744 11.5042 5.81511 8.16215 3.06111C7.34815 2.39611 6.42915 2.13611 5.49515 2.31111C3.53215 2.67811 2.20815 4.79511 2.21015 4.79511C1.15815 6.27211 0.444156 9.79911 7.48215 16.8361ZM5.80115 3.77911C5.88915 3.76511 5.97615 3.75711 6.06215 3.75711C6.45415 3.75711 6.83215 3.91011 7.20915 4.22011C9.90413 6.44009 9.56316 7.1401 9.09116 8.10908C8.38216 9.56608 8.01115 10.9881 10.6702 13.6491C13.3322 16.3101 14.7552 15.9391 16.2102 15.2281L16.2126 15.2269C17.1804 14.7565 17.8801 14.4164 20.0972 17.1081C20.4762 17.5701 20.6212 18.0321 20.5392 18.5191C20.3502 19.6391 19.0482 20.6421 18.6542 20.8861C17.2432 21.8921 13.8462 21.0791 8.54215 15.7761C3.24015 10.4731 2.42615 7.07611 3.46815 5.61111C3.67615 5.27211 4.68315 3.96811 5.80115 3.77911Z" fill="#FBFBFB"/>
                                </svg>
                            </span>
                        </button>
                    </div>                        
                </div>                    

                <div class="doc__content">
                    <div class="doc__tabs">
                        <div class="doc__tab-list">
                            <div class="doc__tab-arrow doc__tab-arrow-prev doc__tab-arrow--disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M8.34505 4.6304C8.63764 4.50903 8.98087 4.62715 9.13444 4.91197C9.29788 5.21572 9.1842 5.59459 8.88053 5.75833C8.88018 5.75852 8.87904 5.75862 8.87809 5.75914C8.87618 5.76018 8.8733 5.76256 8.86914 5.76484C8.86067 5.76947 8.84729 5.77645 8.83008 5.78599C8.79545 5.8052 8.74404 5.83444 8.6779 5.87226C8.54507 5.94821 8.35353 6.05962 8.1237 6.20103C7.66283 6.48461 7.0519 6.88434 6.44401 7.35094C5.83234 7.82045 5.2436 8.34262 4.81396 8.86868C4.59771 9.13348 4.43873 9.37958 4.33219 9.60354H16.042C16.3871 9.60354 16.6669 9.88341 16.667 10.2285C16.667 10.5737 16.3872 10.8535 16.042 10.8535H4.33138C4.43788 11.0778 4.59708 11.3246 4.81396 11.59C5.24355 12.1157 5.83162 12.6377 6.4432 13.107C7.05119 13.5735 7.66275 13.9725 8.1237 14.256C8.35331 14.3973 8.54425 14.5089 8.67708 14.5848C8.74333 14.6227 8.79541 14.6519 8.83008 14.6711C8.84741 14.6807 8.86067 14.6884 8.86914 14.6931C8.87321 14.6953 8.87621 14.6969 8.87809 14.6979L8.88053 14.6988L8.93506 14.7321C9.19734 14.9098 9.28799 15.261 9.13444 15.5459C8.98086 15.8307 8.63765 15.9481 8.34505 15.8267L8.28727 15.799H8.28646L8.28564 15.7982C8.28483 15.7978 8.28371 15.7973 8.28239 15.7966C8.27953 15.795 8.27526 15.7928 8.27018 15.7901C8.25963 15.7843 8.24406 15.7756 8.22461 15.7648C8.18543 15.7431 8.12843 15.7113 8.05697 15.6704C7.91411 15.5888 7.71131 15.4698 7.46859 15.3205C6.98424 15.0226 6.33461 14.5987 5.68229 14.0982C5.03368 13.6005 4.36195 13.0112 3.84635 12.3802C3.37419 11.8024 2.97031 11.1143 2.92188 10.3775L2.91699 10.2302V10.2285C2.91699 10.2275 2.9178 10.2264 2.91781 10.2253C2.91945 9.43449 3.34304 8.69385 3.84554 8.07847C4.36115 7.44712 5.03364 6.85765 5.68229 6.35973C6.33472 5.85891 6.98421 5.43462 7.46859 5.13658C7.71137 4.98719 7.9141 4.86834 8.05697 4.78665C8.1284 4.7458 8.18544 4.71477 8.22461 4.69306C8.24394 4.68234 8.2588 4.67361 8.26937 4.66783C8.27467 4.66493 8.27945 4.6621 8.28239 4.66051C8.28368 4.6598 8.28485 4.65931 8.28564 4.65888L8.28646 4.65806H8.28727L8.34505 4.6304Z" fill="#FBFBFB"/>
                                </svg>
                            </div>
                            <button class="doc__tab-item doc__tab-item--active">API Reference & SDKs</button>
                            <button class="doc__tab-item">Developer Portal</button>
                            <button class="doc__tab-item">Integration Guide</button>
                            <div class="doc__tab-arrow doc__tab-arrow-next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10.8656 4.45477C11.0293 4.15092 11.4089 4.03709 11.7127 4.20086H11.7135L11.7144 4.20168C11.7152 4.20211 11.7163 4.20259 11.7176 4.20331C11.7205 4.20488 11.7246 4.20779 11.7298 4.21063C11.7404 4.21639 11.756 4.22429 11.7754 4.23504C11.8146 4.25676 11.8716 4.2886 11.943 4.32944C12.0859 4.41111 12.2886 4.53005 12.5314 4.67938C13.0158 4.97731 13.6654 5.40118 14.3177 5.90171C14.9663 6.39941 15.638 6.98865 16.1536 7.61965C16.6572 8.23591 17.083 8.97814 17.083 9.77052L17.0781 9.91782C17.0297 10.6549 16.6267 11.344 16.1545 11.9222C15.6389 12.5535 14.9663 13.1422 14.3177 13.6402C13.6653 14.1409 13.0158 14.5653 12.5314 14.8633C12.2886 15.0127 12.0859 15.1315 11.943 15.2132C11.8716 15.2541 11.8146 15.2859 11.7754 15.3076C11.7562 15.3183 11.7411 15.3263 11.7306 15.332C11.7253 15.3349 11.7206 15.3378 11.7176 15.3394C11.7163 15.3401 11.7152 15.3406 11.7144 15.341L11.7135 15.3418H11.7127C11.4089 15.5056 11.0294 15.3925 10.8656 15.0887C10.7017 14.7849 10.8156 14.4054 11.1195 14.2416C11.1198 14.2414 11.121 14.2413 11.1219 14.2407C11.1238 14.2397 11.1268 14.2381 11.1309 14.2359C11.1393 14.2312 11.1526 14.2235 11.1699 14.2139C11.2046 14.1947 11.256 14.1654 11.3221 14.1276C11.4549 14.0517 11.6464 13.9403 11.8763 13.7988C12.3372 13.5153 12.9481 13.1156 13.556 12.6489C14.1677 12.1794 14.7564 11.6573 15.186 11.1312C15.4023 10.8664 15.5613 10.6203 15.6678 10.3963H3.95801C3.61283 10.3963 3.33301 10.1165 3.33301 9.77134C3.33303 9.42618 3.61284 9.14634 3.95801 9.14634H15.6686C15.5621 8.92216 15.4028 8.67596 15.186 8.41066C14.7564 7.88489 14.1685 7.36225 13.5568 6.89292C12.9488 6.42643 12.3372 6.02736 11.8763 5.74383C11.6467 5.60259 11.4557 5.49098 11.3229 5.41506C11.2566 5.37716 11.2046 5.34801 11.1699 5.32879C11.1527 5.31923 11.1393 5.31226 11.1309 5.30763C11.1267 5.30534 11.1238 5.30297 11.1219 5.30194C11.121 5.30142 11.1198 5.30132 11.1195 5.30112C10.8158 5.1374 10.7021 4.75853 10.8656 4.45477Z" fill="#FBFBFB"/>
                                </svg>
                            </div>
                        </div>
                        <div class="doc__tab-content-list">

                            <div class="doc__tab-content-item doc__tab-content-item--active">
                                <div class="doc__tab-content-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/star_icon.svg" alt="Star">
                                </div>
                                <div class="doc__tab-content-info">
                                    <div class="doc__tab-content-title">API Reference & SDKs</div>
                                    <div class="doc__tab-content-text">Dive into our comprehensive REST API documentation with clear endpoints, sample requests, and response examples. We've built native SDKs for all major platforms — JavaScript, Python, Java, iOS, and Android — so you can integrate NV Global using the tools you already know and love. Each SDK comes with detailed code samples and best practices to get you up and running fast.</div>
                                </div>
                                <div class="doc__tab-content-action">
                                    <a href="https://nv-global.gitbook.io/docs" class="btn btn-with-lottie-arrow">
                                        <span class="btn__text">View API Documentation</span>
                                        <span class="btn__icon lottie-container-arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>

                            <div class="doc__tab-content-item">
                                <div class="doc__tab-content-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/star_icon.svg" alt="Star">
                                </div>
                                <div class="doc__tab-content-info">
                                    <div class="doc__tab-content-title">Developer Portal</div>
                                    <div class="doc__tab-content-text">Your command center for everything NV Global. Generate test API keys instantly, experiment in our sandbox environment, and see exactly how our verification flows work before going live. Track your usage, manage multiple projects, and access real-time analytics — all from one intuitive dashboard.</div>
                                </div>
                                <div class="doc__tab-content-action">
                                    <a href="#" class="btn btn-with-lottie-arrow">
                                        <span class="btn__text">Access Developer Portal</span>
                                        <span class="btn__icon lottie-container-arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>

                            <div class="doc__tab-content-item">
                                <div class="doc__tab-content-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/star_icon.svg" alt="Star">
                                </div>
                                <div class="doc__tab-content-info">
                                    <div class="doc__tab-content-title">Step-by-Step Integration</div>
                                    <div class="doc__tab-content-text">Follow our crystal-clear integration guides that walk you through every step of the process. From initial setup to production deployment, we've documented common scenarios, webhook configurations, error handling patterns, and optimization tips. Most developers complete their basic integration in just one business day.</div>
                                </div>
                                <div class="doc__tab-content-action">
                                    <a href="#" class="btn btn-with-lottie-arrow">
                                        <span class="btn__text">Read Integration Guide</span>
                                        <span class="btn__icon lottie-container-arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="doc__content-line"></div>

                    <div class="doc__bottom">
                        <div class="doc__bottom-info">
                            <div class="doc__bottom-title">Developer Support</div>
                            <div class="doc__bottom-description">Got questions? Our technical support team speaks your language. Whether you need help with a specific endpoint, guidance on best practices, or troubleshooting assistance, we're here to help. Reach out via chat, email, or schedule a call with our integration specialists</div>
                        </div>
                        <div class="doc__bottom-action">
                            <button class="btn btn--black open-callForm2 btn-with-lottie-arrow-orange">
                                <span>Book a call</span>
                                <span class="btn__icon lottie-container-arrow-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="news section">
        <div class="container">
            <div class="news__wrapper">
                <div class="news__top">
                    <div class="section__badge">Blog</div>
                    <div class="news__top-info">
                        <div class="news__title-block">
                            <h2 class="news__title">Insights & Resources</h2>
                            <p class="news__descriptioin">Stay ahead with expert insights on identity verification, compliance, and AI-powered security</p>
                        </div>
                        <div class="news__top-action">
                            <div class="news__arrows">
                                <div class="news__arrow news__arrow-prev news__arrow--disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M10.0137 5.55687C10.3648 5.41123 10.7767 5.55297 10.9609 5.89476C11.1571 6.25925 11.0206 6.7139 10.6562 6.91038C10.6558 6.91061 10.6545 6.91074 10.6533 6.91136C10.651 6.9126 10.6476 6.91547 10.6426 6.91819C10.6324 6.92375 10.6164 6.93213 10.5957 6.94358C10.5541 6.96663 10.4925 7.00171 10.4131 7.0471C10.2537 7.13824 10.0238 7.27193 9.74805 7.44163C9.19501 7.78192 8.46189 8.2616 7.73242 8.82151C6.99842 9.38494 6.29193 10.0115 5.77637 10.6428C5.51686 10.9606 5.32608 11.2559 5.19824 11.5246H19.25C19.6642 11.5246 19.9999 11.8605 20 12.2746C20 12.6889 19.6642 13.0246 19.25 13.0246H5.19727C5.32507 13.2938 5.51611 13.5899 5.77637 13.9084C6.29187 14.5392 6.99755 15.1656 7.73145 15.7287C8.46104 16.2885 9.19491 16.7674 9.74805 17.1076C10.0236 17.2771 10.2527 17.4111 10.4121 17.5022C10.4916 17.5476 10.5541 17.5826 10.5957 17.6057C10.6165 17.6172 10.6324 17.6265 10.6426 17.6321C10.6475 17.6347 10.6511 17.6367 10.6533 17.6379L10.6562 17.6389L10.7217 17.6789C11.0364 17.8922 11.1452 18.3136 10.9609 18.6555C10.7766 18.9973 10.3648 19.1381 10.0137 18.9924L9.94434 18.9592H9.94336L9.94238 18.9582C9.94141 18.9577 9.94006 18.9571 9.93848 18.9563C9.93505 18.9544 9.92992 18.9518 9.92383 18.9485C9.91116 18.9415 9.89248 18.9311 9.86914 18.9182C9.82212 18.8921 9.75372 18.8539 9.66797 18.8049C9.49654 18.7069 9.25318 18.5641 8.96191 18.385C8.3807 18.0275 7.60115 17.5188 6.81836 16.9182C6.04002 16.321 5.23395 15.6139 4.61523 14.8567C4.04864 14.1633 3.56398 13.3375 3.50586 12.4533L3.5 12.2766V12.2746C3.5 12.2733 3.50097 12.272 3.50098 12.2707C3.50295 11.3218 4.01126 10.433 4.61426 9.69456C5.23299 8.93694 6.03997 8.22958 6.81836 7.63206C7.60128 7.03109 8.38067 6.52194 8.96191 6.16429C9.25325 5.98502 9.49653 5.8424 9.66797 5.74437C9.75368 5.69535 9.82214 5.65812 9.86914 5.63206C9.89234 5.6192 9.91016 5.60872 9.92285 5.60179C9.92922 5.59831 9.93494 5.59492 9.93848 5.593C9.94003 5.59216 9.94143 5.59156 9.94238 5.59105L9.94336 5.59007H9.94434L10.0137 5.55687Z" fill="#FBFBFB"/>
                                    </svg>
                                </div>
                                <div class="news__arrow news__arrow-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                    </svg>
                                </div>
                            </div>
                            <a href="#" class="btn btn--orange">
                                <span class="btn__text">Explore All Articles</span>
                                <span class="btn__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>                    
                </div>

                <div class="news__content swiper">
                    <div class="news__list swiper-wrapper">

                        <div class="news__item swiper-slide">
                            <div class="news__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/news1.jpg" alt="">
                            </div>
                            <div class="news__item-info">
                                <div class="news__item-meta">
                                    <div class="news__item-meta-left">
                                        <div class="news__item-meta-views">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.875 10.8057C16.8749 9.54755 16.1151 8.2316 14.8218 7.20459C13.5371 6.18442 11.7975 5.5127 10 5.5127C8.20293 5.5127 6.46308 6.18438 5.17822 7.20459C3.88484 8.23162 3.12514 9.54765 3.125 10.8057C3.125 12.0657 3.87856 13.3825 5.16683 14.4084C6.44674 15.4276 8.18634 16.0994 10 16.0994C11.814 16.0994 13.5534 15.4275 14.8332 14.4084C16.1213 13.3825 16.875 12.0658 16.875 10.8057ZM11.9409 10.8049C11.9409 9.73423 11.0722 8.86563 10.0016 8.86556C8.93194 8.86556 8.06315 9.73406 8.06315 10.8049C8.0632 11.8746 8.93183 12.7433 10.0016 12.7433C11.0723 12.7433 11.9409 11.8745 11.9409 10.8049ZM18.125 10.8057C18.125 12.5638 17.092 14.207 15.612 15.3857C14.1234 16.5712 12.1126 17.3494 10 17.3494C7.88787 17.3494 5.87746 16.5711 4.38883 15.3857C2.9086 14.207 1.875 12.5639 1.875 10.8057C1.87513 9.04567 2.91827 7.40295 4.40104 6.22559C5.89264 5.04122 7.9029 4.2627 10 4.2627C12.0974 4.2627 14.1075 5.04127 15.599 6.22559C17.0817 7.40299 18.1249 9.04571 18.125 10.8057ZM13.1909 10.8049C13.1909 12.5651 11.7624 13.9933 10.0016 13.9933C8.24149 13.9933 6.8132 12.565 6.81315 10.8049C6.81315 9.04397 8.24131 7.61556 10.0016 7.61556C11.7626 7.61563 13.1909 9.04389 13.1909 10.8049Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">16 245</div>
                                        </div>
                                        <div class="news__item-meta-likes">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7532 5.87558C12.8592 5.54706 13.2114 5.36662 13.5399 5.47255C14.6254 5.82258 15.3932 6.79242 15.4849 7.92907C15.5127 8.27313 15.2562 8.57451 14.9122 8.60226C14.5681 8.63001 14.2667 8.37359 14.2389 8.02957C14.1879 7.39699 13.7605 6.85707 13.1563 6.66223C12.8277 6.55629 12.6473 6.2041 12.7532 5.87558Z" fill="#FBFBFB"/>
                                                    <path d="M10.0029 17.5168C9.91174 17.5165 9.82166 17.4967 9.73875 17.4584C9.48875 17.3409 3.57795 14.5376 2.19795 10.1143C1.29962 7.31512 2.29879 3.78678 5.53129 2.73678C6.34747 2.48192 7.21218 2.42283 8.05545 2.56428C8.76525 2.72591 9.43041 3.04297 10.0029 3.49262C10.5749 3.03808 11.242 2.71848 11.9546 2.55762C12.7977 2.41628 13.6623 2.4774 14.4771 2.73595C17.7046 3.77595 18.7013 7.30595 17.7997 10.1184C16.3362 14.5876 10.5146 17.3426 10.2679 17.4576C10.1849 17.4962 10.0945 17.5163 10.0029 17.5168ZM7.15378 3.73928C6.73249 3.73906 6.31359 3.80256 5.91128 3.92762C3.33628 4.76512 2.69045 7.54595 3.39295 9.73759C4.45878 13.1543 8.87458 15.6118 10.0062 16.1934C11.1279 15.6159 15.4838 13.1818 16.613 9.73343C17.3163 7.54095 16.6737 4.75762 14.0971 3.92678C13.4727 3.72817 12.8099 3.68132 12.1637 3.79012C11.5062 3.98388 10.8982 4.31731 10.3812 4.76762C10.2731 4.84875 10.1415 4.89262 10.0062 4.89262C9.87108 4.89262 9.73949 4.84875 9.63124 4.76762C9.11241 4.31839 8.50266 3.9864 7.84378 3.79428C7.61568 3.75703 7.3849 3.73863 7.15378 3.73928Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">100</div>
                                        </div>
                                    </div>
                                    <div class="news__item-meta-times">
                                        <div class="news__item-meta-times-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.6668 7.99967C13.6668 5.71509 13.2797 4.3508 12.4644 3.53548C11.649 2.72017 10.2848 2.33301 8.00016 2.33301C5.71557 2.33301 4.35128 2.72017 3.53597 3.53548C2.72066 4.3508 2.3335 5.71508 2.3335 7.99967C2.3335 10.2843 2.72066 11.6486 3.53597 12.4639C4.35128 13.2792 5.71558 13.6663 8.00016 13.6663C10.2848 13.6663 11.649 13.2792 12.4644 12.4639C13.2797 11.6486 13.6668 10.2843 13.6668 7.99967ZM7.49951 5.08887C7.4996 4.81284 7.72347 4.58892 7.99951 4.58887C8.2756 4.58887 8.49942 4.8128 8.49951 5.08887V7.71191L10.5164 8.91569C10.7536 9.05717 10.8311 9.36409 10.6896 9.60124C10.5481 9.83836 10.2412 9.91588 10.0041 9.77441L7.74365 8.42611C7.59244 8.3359 7.49952 8.17249 7.49951 7.99642V5.08887ZM14.6668 7.99967C14.6668 10.3397 14.2832 12.059 13.1714 13.1709C12.0595 14.2827 10.3402 14.6663 8.00016 14.6663C5.66011 14.6663 3.94079 14.2827 2.82894 13.1709C1.71709 12.059 1.3335 10.3397 1.3335 7.99967C1.3335 5.65962 1.71709 3.9403 2.82894 2.82845C3.94079 1.7166 5.6601 1.33301 8.00016 1.33301C10.3402 1.33301 12.0595 1.7166 13.1714 2.82845C14.2832 3.9403 14.6668 5.65962 14.6668 7.99967Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="news__item-meta-times-text">15 minutes</div>
                                    </div>
                                </div>
                                <div class="news__item-title">A very long and intriguing article title, stretched out over several long lines</div>
                                <div class="news__item-description">Lorem ipsum dolor sit amet consectetur. Pretium vitae orci quis mi duis nunc. Sed eu elementum dui dui convallis aenean diam sed. Viverra accumsan volutpat sit sit. Pellentesque congue maecenas massa sem viverra. Nunc amet condimentum tincidunt semper etiam egestas amet arcu.</div>
                            </div>
                            <div class="news__item-author">
                                <div class="news__item-author-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/clent_image.webp" alt="Author">
                                </div>
                                <div class="news__item-author-info">
                                    <div class="news__item-author-name">Elon Musk</div>
                                    <div class="news__item-author-job">CEO of Tesla</div>
                                </div>                                
                            </div>
                        </div>

                        <div class="news__item swiper-slide">
                            <div class="news__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/news2.jpg" alt="">
                            </div>
                            <div class="news__item-info">
                                <div class="news__item-meta">
                                    <div class="news__item-meta-left">
                                        <div class="news__item-meta-views">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.875 10.8057C16.8749 9.54755 16.1151 8.2316 14.8218 7.20459C13.5371 6.18442 11.7975 5.5127 10 5.5127C8.20293 5.5127 6.46308 6.18438 5.17822 7.20459C3.88484 8.23162 3.12514 9.54765 3.125 10.8057C3.125 12.0657 3.87856 13.3825 5.16683 14.4084C6.44674 15.4276 8.18634 16.0994 10 16.0994C11.814 16.0994 13.5534 15.4275 14.8332 14.4084C16.1213 13.3825 16.875 12.0658 16.875 10.8057ZM11.9409 10.8049C11.9409 9.73423 11.0722 8.86563 10.0016 8.86556C8.93194 8.86556 8.06315 9.73406 8.06315 10.8049C8.0632 11.8746 8.93183 12.7433 10.0016 12.7433C11.0723 12.7433 11.9409 11.8745 11.9409 10.8049ZM18.125 10.8057C18.125 12.5638 17.092 14.207 15.612 15.3857C14.1234 16.5712 12.1126 17.3494 10 17.3494C7.88787 17.3494 5.87746 16.5711 4.38883 15.3857C2.9086 14.207 1.875 12.5639 1.875 10.8057C1.87513 9.04567 2.91827 7.40295 4.40104 6.22559C5.89264 5.04122 7.9029 4.2627 10 4.2627C12.0974 4.2627 14.1075 5.04127 15.599 6.22559C17.0817 7.40299 18.1249 9.04571 18.125 10.8057ZM13.1909 10.8049C13.1909 12.5651 11.7624 13.9933 10.0016 13.9933C8.24149 13.9933 6.8132 12.565 6.81315 10.8049C6.81315 9.04397 8.24131 7.61556 10.0016 7.61556C11.7626 7.61563 13.1909 9.04389 13.1909 10.8049Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">16 245</div>
                                        </div>
                                        <div class="news__item-meta-likes">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7532 5.87558C12.8592 5.54706 13.2114 5.36662 13.5399 5.47255C14.6254 5.82258 15.3932 6.79242 15.4849 7.92907C15.5127 8.27313 15.2562 8.57451 14.9122 8.60226C14.5681 8.63001 14.2667 8.37359 14.2389 8.02957C14.1879 7.39699 13.7605 6.85707 13.1563 6.66223C12.8277 6.55629 12.6473 6.2041 12.7532 5.87558Z" fill="#FBFBFB"/>
                                                    <path d="M10.0029 17.5168C9.91174 17.5165 9.82166 17.4967 9.73875 17.4584C9.48875 17.3409 3.57795 14.5376 2.19795 10.1143C1.29962 7.31512 2.29879 3.78678 5.53129 2.73678C6.34747 2.48192 7.21218 2.42283 8.05545 2.56428C8.76525 2.72591 9.43041 3.04297 10.0029 3.49262C10.5749 3.03808 11.242 2.71848 11.9546 2.55762C12.7977 2.41628 13.6623 2.4774 14.4771 2.73595C17.7046 3.77595 18.7013 7.30595 17.7997 10.1184C16.3362 14.5876 10.5146 17.3426 10.2679 17.4576C10.1849 17.4962 10.0945 17.5163 10.0029 17.5168ZM7.15378 3.73928C6.73249 3.73906 6.31359 3.80256 5.91128 3.92762C3.33628 4.76512 2.69045 7.54595 3.39295 9.73759C4.45878 13.1543 8.87458 15.6118 10.0062 16.1934C11.1279 15.6159 15.4838 13.1818 16.613 9.73343C17.3163 7.54095 16.6737 4.75762 14.0971 3.92678C13.4727 3.72817 12.8099 3.68132 12.1637 3.79012C11.5062 3.98388 10.8982 4.31731 10.3812 4.76762C10.2731 4.84875 10.1415 4.89262 10.0062 4.89262C9.87108 4.89262 9.73949 4.84875 9.63124 4.76762C9.11241 4.31839 8.50266 3.9864 7.84378 3.79428C7.61568 3.75703 7.3849 3.73863 7.15378 3.73928Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">100</div>
                                        </div>
                                    </div>
                                    <div class="news__item-meta-times">
                                        <div class="news__item-meta-times-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.6668 7.99967C13.6668 5.71509 13.2797 4.3508 12.4644 3.53548C11.649 2.72017 10.2848 2.33301 8.00016 2.33301C5.71557 2.33301 4.35128 2.72017 3.53597 3.53548C2.72066 4.3508 2.3335 5.71508 2.3335 7.99967C2.3335 10.2843 2.72066 11.6486 3.53597 12.4639C4.35128 13.2792 5.71558 13.6663 8.00016 13.6663C10.2848 13.6663 11.649 13.2792 12.4644 12.4639C13.2797 11.6486 13.6668 10.2843 13.6668 7.99967ZM7.49951 5.08887C7.4996 4.81284 7.72347 4.58892 7.99951 4.58887C8.2756 4.58887 8.49942 4.8128 8.49951 5.08887V7.71191L10.5164 8.91569C10.7536 9.05717 10.8311 9.36409 10.6896 9.60124C10.5481 9.83836 10.2412 9.91588 10.0041 9.77441L7.74365 8.42611C7.59244 8.3359 7.49952 8.17249 7.49951 7.99642V5.08887ZM14.6668 7.99967C14.6668 10.3397 14.2832 12.059 13.1714 13.1709C12.0595 14.2827 10.3402 14.6663 8.00016 14.6663C5.66011 14.6663 3.94079 14.2827 2.82894 13.1709C1.71709 12.059 1.3335 10.3397 1.3335 7.99967C1.3335 5.65962 1.71709 3.9403 2.82894 2.82845C3.94079 1.7166 5.6601 1.33301 8.00016 1.33301C10.3402 1.33301 12.0595 1.7166 13.1714 2.82845C14.2832 3.9403 14.6668 5.65962 14.6668 7.99967Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="news__item-meta-times-text">15 minutes</div>
                                    </div>
                                </div>
                                <div class="news__item-title">A very long and intriguing article title, stretched out over several long lines</div>
                                <div class="news__item-description">Lorem ipsum dolor sit amet consectetur. Pretium vitae orci quis mi duis nunc. Sed eu elementum dui dui convallis aenean diam sed. Viverra accumsan volutpat sit sit. Pellentesque congue maecenas massa sem viverra. Nunc amet condimentum tincidunt semper etiam egestas amet arcu.</div>
                            </div>
                            <div class="news__item-author">
                                <div class="news__item-author-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/clent_image.webp" alt="Author">
                                </div>
                                <div class="news__item-author-info">
                                    <div class="news__item-author-name">Elon Musk</div>
                                    <div class="news__item-author-job">CEO of Tesla</div>
                                </div>                                
                            </div>
                        </div>

                        <div class="news__item swiper-slide">
                            <div class="news__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/news1.jpg" alt="">
                            </div>
                            <div class="news__item-info">
                                <div class="news__item-meta">
                                    <div class="news__item-meta-left">
                                        <div class="news__item-meta-views">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.875 10.8057C16.8749 9.54755 16.1151 8.2316 14.8218 7.20459C13.5371 6.18442 11.7975 5.5127 10 5.5127C8.20293 5.5127 6.46308 6.18438 5.17822 7.20459C3.88484 8.23162 3.12514 9.54765 3.125 10.8057C3.125 12.0657 3.87856 13.3825 5.16683 14.4084C6.44674 15.4276 8.18634 16.0994 10 16.0994C11.814 16.0994 13.5534 15.4275 14.8332 14.4084C16.1213 13.3825 16.875 12.0658 16.875 10.8057ZM11.9409 10.8049C11.9409 9.73423 11.0722 8.86563 10.0016 8.86556C8.93194 8.86556 8.06315 9.73406 8.06315 10.8049C8.0632 11.8746 8.93183 12.7433 10.0016 12.7433C11.0723 12.7433 11.9409 11.8745 11.9409 10.8049ZM18.125 10.8057C18.125 12.5638 17.092 14.207 15.612 15.3857C14.1234 16.5712 12.1126 17.3494 10 17.3494C7.88787 17.3494 5.87746 16.5711 4.38883 15.3857C2.9086 14.207 1.875 12.5639 1.875 10.8057C1.87513 9.04567 2.91827 7.40295 4.40104 6.22559C5.89264 5.04122 7.9029 4.2627 10 4.2627C12.0974 4.2627 14.1075 5.04127 15.599 6.22559C17.0817 7.40299 18.1249 9.04571 18.125 10.8057ZM13.1909 10.8049C13.1909 12.5651 11.7624 13.9933 10.0016 13.9933C8.24149 13.9933 6.8132 12.565 6.81315 10.8049C6.81315 9.04397 8.24131 7.61556 10.0016 7.61556C11.7626 7.61563 13.1909 9.04389 13.1909 10.8049Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">16 245</div>
                                        </div>
                                        <div class="news__item-meta-likes">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7532 5.87558C12.8592 5.54706 13.2114 5.36662 13.5399 5.47255C14.6254 5.82258 15.3932 6.79242 15.4849 7.92907C15.5127 8.27313 15.2562 8.57451 14.9122 8.60226C14.5681 8.63001 14.2667 8.37359 14.2389 8.02957C14.1879 7.39699 13.7605 6.85707 13.1563 6.66223C12.8277 6.55629 12.6473 6.2041 12.7532 5.87558Z" fill="#FBFBFB"/>
                                                    <path d="M10.0029 17.5168C9.91174 17.5165 9.82166 17.4967 9.73875 17.4584C9.48875 17.3409 3.57795 14.5376 2.19795 10.1143C1.29962 7.31512 2.29879 3.78678 5.53129 2.73678C6.34747 2.48192 7.21218 2.42283 8.05545 2.56428C8.76525 2.72591 9.43041 3.04297 10.0029 3.49262C10.5749 3.03808 11.242 2.71848 11.9546 2.55762C12.7977 2.41628 13.6623 2.4774 14.4771 2.73595C17.7046 3.77595 18.7013 7.30595 17.7997 10.1184C16.3362 14.5876 10.5146 17.3426 10.2679 17.4576C10.1849 17.4962 10.0945 17.5163 10.0029 17.5168ZM7.15378 3.73928C6.73249 3.73906 6.31359 3.80256 5.91128 3.92762C3.33628 4.76512 2.69045 7.54595 3.39295 9.73759C4.45878 13.1543 8.87458 15.6118 10.0062 16.1934C11.1279 15.6159 15.4838 13.1818 16.613 9.73343C17.3163 7.54095 16.6737 4.75762 14.0971 3.92678C13.4727 3.72817 12.8099 3.68132 12.1637 3.79012C11.5062 3.98388 10.8982 4.31731 10.3812 4.76762C10.2731 4.84875 10.1415 4.89262 10.0062 4.89262C9.87108 4.89262 9.73949 4.84875 9.63124 4.76762C9.11241 4.31839 8.50266 3.9864 7.84378 3.79428C7.61568 3.75703 7.3849 3.73863 7.15378 3.73928Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">100</div>
                                        </div>
                                    </div>
                                    <div class="news__item-meta-times">
                                        <div class="news__item-meta-times-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.6668 7.99967C13.6668 5.71509 13.2797 4.3508 12.4644 3.53548C11.649 2.72017 10.2848 2.33301 8.00016 2.33301C5.71557 2.33301 4.35128 2.72017 3.53597 3.53548C2.72066 4.3508 2.3335 5.71508 2.3335 7.99967C2.3335 10.2843 2.72066 11.6486 3.53597 12.4639C4.35128 13.2792 5.71558 13.6663 8.00016 13.6663C10.2848 13.6663 11.649 13.2792 12.4644 12.4639C13.2797 11.6486 13.6668 10.2843 13.6668 7.99967ZM7.49951 5.08887C7.4996 4.81284 7.72347 4.58892 7.99951 4.58887C8.2756 4.58887 8.49942 4.8128 8.49951 5.08887V7.71191L10.5164 8.91569C10.7536 9.05717 10.8311 9.36409 10.6896 9.60124C10.5481 9.83836 10.2412 9.91588 10.0041 9.77441L7.74365 8.42611C7.59244 8.3359 7.49952 8.17249 7.49951 7.99642V5.08887ZM14.6668 7.99967C14.6668 10.3397 14.2832 12.059 13.1714 13.1709C12.0595 14.2827 10.3402 14.6663 8.00016 14.6663C5.66011 14.6663 3.94079 14.2827 2.82894 13.1709C1.71709 12.059 1.3335 10.3397 1.3335 7.99967C1.3335 5.65962 1.71709 3.9403 2.82894 2.82845C3.94079 1.7166 5.6601 1.33301 8.00016 1.33301C10.3402 1.33301 12.0595 1.7166 13.1714 2.82845C14.2832 3.9403 14.6668 5.65962 14.6668 7.99967Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="news__item-meta-times-text">15 minutes</div>
                                    </div>
                                </div>
                                <div class="news__item-title">A very long and intriguing article title, stretched out over several long lines</div>
                                <div class="news__item-description">Lorem ipsum dolor sit amet consectetur. Pretium vitae orci quis mi duis nunc. Sed eu elementum dui dui convallis aenean diam sed. Viverra accumsan volutpat sit sit. Pellentesque congue maecenas massa sem viverra. Nunc amet condimentum tincidunt semper etiam egestas amet arcu.</div>
                            </div>
                            <div class="news__item-author">
                                <div class="news__item-author-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/clent_image.webp" alt="Author">
                                </div>
                                <div class="news__item-author-info">
                                    <div class="news__item-author-name">Elon Musk</div>
                                    <div class="news__item-author-job">CEO of Tesla</div>
                                </div>                                
                            </div>
                        </div>

                        <div class="news__item swiper-slide">
                            <div class="news__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/news1.jpg" alt="">
                            </div>
                            <div class="news__item-info">
                                <div class="news__item-meta">
                                    <div class="news__item-meta-left">
                                        <div class="news__item-meta-views">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.875 10.8057C16.8749 9.54755 16.1151 8.2316 14.8218 7.20459C13.5371 6.18442 11.7975 5.5127 10 5.5127C8.20293 5.5127 6.46308 6.18438 5.17822 7.20459C3.88484 8.23162 3.12514 9.54765 3.125 10.8057C3.125 12.0657 3.87856 13.3825 5.16683 14.4084C6.44674 15.4276 8.18634 16.0994 10 16.0994C11.814 16.0994 13.5534 15.4275 14.8332 14.4084C16.1213 13.3825 16.875 12.0658 16.875 10.8057ZM11.9409 10.8049C11.9409 9.73423 11.0722 8.86563 10.0016 8.86556C8.93194 8.86556 8.06315 9.73406 8.06315 10.8049C8.0632 11.8746 8.93183 12.7433 10.0016 12.7433C11.0723 12.7433 11.9409 11.8745 11.9409 10.8049ZM18.125 10.8057C18.125 12.5638 17.092 14.207 15.612 15.3857C14.1234 16.5712 12.1126 17.3494 10 17.3494C7.88787 17.3494 5.87746 16.5711 4.38883 15.3857C2.9086 14.207 1.875 12.5639 1.875 10.8057C1.87513 9.04567 2.91827 7.40295 4.40104 6.22559C5.89264 5.04122 7.9029 4.2627 10 4.2627C12.0974 4.2627 14.1075 5.04127 15.599 6.22559C17.0817 7.40299 18.1249 9.04571 18.125 10.8057ZM13.1909 10.8049C13.1909 12.5651 11.7624 13.9933 10.0016 13.9933C8.24149 13.9933 6.8132 12.565 6.81315 10.8049C6.81315 9.04397 8.24131 7.61556 10.0016 7.61556C11.7626 7.61563 13.1909 9.04389 13.1909 10.8049Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">16 245</div>
                                        </div>
                                        <div class="news__item-meta-likes">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7532 5.87558C12.8592 5.54706 13.2114 5.36662 13.5399 5.47255C14.6254 5.82258 15.3932 6.79242 15.4849 7.92907C15.5127 8.27313 15.2562 8.57451 14.9122 8.60226C14.5681 8.63001 14.2667 8.37359 14.2389 8.02957C14.1879 7.39699 13.7605 6.85707 13.1563 6.66223C12.8277 6.55629 12.6473 6.2041 12.7532 5.87558Z" fill="#FBFBFB"/>
                                                    <path d="M10.0029 17.5168C9.91174 17.5165 9.82166 17.4967 9.73875 17.4584C9.48875 17.3409 3.57795 14.5376 2.19795 10.1143C1.29962 7.31512 2.29879 3.78678 5.53129 2.73678C6.34747 2.48192 7.21218 2.42283 8.05545 2.56428C8.76525 2.72591 9.43041 3.04297 10.0029 3.49262C10.5749 3.03808 11.242 2.71848 11.9546 2.55762C12.7977 2.41628 13.6623 2.4774 14.4771 2.73595C17.7046 3.77595 18.7013 7.30595 17.7997 10.1184C16.3362 14.5876 10.5146 17.3426 10.2679 17.4576C10.1849 17.4962 10.0945 17.5163 10.0029 17.5168ZM7.15378 3.73928C6.73249 3.73906 6.31359 3.80256 5.91128 3.92762C3.33628 4.76512 2.69045 7.54595 3.39295 9.73759C4.45878 13.1543 8.87458 15.6118 10.0062 16.1934C11.1279 15.6159 15.4838 13.1818 16.613 9.73343C17.3163 7.54095 16.6737 4.75762 14.0971 3.92678C13.4727 3.72817 12.8099 3.68132 12.1637 3.79012C11.5062 3.98388 10.8982 4.31731 10.3812 4.76762C10.2731 4.84875 10.1415 4.89262 10.0062 4.89262C9.87108 4.89262 9.73949 4.84875 9.63124 4.76762C9.11241 4.31839 8.50266 3.9864 7.84378 3.79428C7.61568 3.75703 7.3849 3.73863 7.15378 3.73928Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">100</div>
                                        </div>
                                    </div>
                                    <div class="news__item-meta-times">
                                        <div class="news__item-meta-times-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.6668 7.99967C13.6668 5.71509 13.2797 4.3508 12.4644 3.53548C11.649 2.72017 10.2848 2.33301 8.00016 2.33301C5.71557 2.33301 4.35128 2.72017 3.53597 3.53548C2.72066 4.3508 2.3335 5.71508 2.3335 7.99967C2.3335 10.2843 2.72066 11.6486 3.53597 12.4639C4.35128 13.2792 5.71558 13.6663 8.00016 13.6663C10.2848 13.6663 11.649 13.2792 12.4644 12.4639C13.2797 11.6486 13.6668 10.2843 13.6668 7.99967ZM7.49951 5.08887C7.4996 4.81284 7.72347 4.58892 7.99951 4.58887C8.2756 4.58887 8.49942 4.8128 8.49951 5.08887V7.71191L10.5164 8.91569C10.7536 9.05717 10.8311 9.36409 10.6896 9.60124C10.5481 9.83836 10.2412 9.91588 10.0041 9.77441L7.74365 8.42611C7.59244 8.3359 7.49952 8.17249 7.49951 7.99642V5.08887ZM14.6668 7.99967C14.6668 10.3397 14.2832 12.059 13.1714 13.1709C12.0595 14.2827 10.3402 14.6663 8.00016 14.6663C5.66011 14.6663 3.94079 14.2827 2.82894 13.1709C1.71709 12.059 1.3335 10.3397 1.3335 7.99967C1.3335 5.65962 1.71709 3.9403 2.82894 2.82845C3.94079 1.7166 5.6601 1.33301 8.00016 1.33301C10.3402 1.33301 12.0595 1.7166 13.1714 2.82845C14.2832 3.9403 14.6668 5.65962 14.6668 7.99967Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="news__item-meta-times-text">15 minutes</div>
                                    </div>
                                </div>
                                <div class="news__item-title">A very long and intriguing article title, stretched out over several long lines</div>
                                <div class="news__item-description">Lorem ipsum dolor sit amet consectetur. Pretium vitae orci quis mi duis nunc. Sed eu elementum dui dui convallis aenean diam sed. Viverra accumsan volutpat sit sit. Pellentesque congue maecenas massa sem viverra. Nunc amet condimentum tincidunt semper etiam egestas amet arcu.</div>
                            </div>
                            <div class="news__item-author">
                                <div class="news__item-author-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/clent_image.webp" alt="Author">
                                </div>
                                <div class="news__item-author-info">
                                    <div class="news__item-author-name">Elon Musk</div>
                                    <div class="news__item-author-job">CEO of Tesla</div>
                                </div>                                
                            </div>
                        </div>

                        <div class="news__item swiper-slide">
                            <div class="news__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/news1.jpg" alt="">
                            </div>
                            <div class="news__item-info">
                                <div class="news__item-meta">
                                    <div class="news__item-meta-left">
                                        <div class="news__item-meta-views">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.875 10.8057C16.8749 9.54755 16.1151 8.2316 14.8218 7.20459C13.5371 6.18442 11.7975 5.5127 10 5.5127C8.20293 5.5127 6.46308 6.18438 5.17822 7.20459C3.88484 8.23162 3.12514 9.54765 3.125 10.8057C3.125 12.0657 3.87856 13.3825 5.16683 14.4084C6.44674 15.4276 8.18634 16.0994 10 16.0994C11.814 16.0994 13.5534 15.4275 14.8332 14.4084C16.1213 13.3825 16.875 12.0658 16.875 10.8057ZM11.9409 10.8049C11.9409 9.73423 11.0722 8.86563 10.0016 8.86556C8.93194 8.86556 8.06315 9.73406 8.06315 10.8049C8.0632 11.8746 8.93183 12.7433 10.0016 12.7433C11.0723 12.7433 11.9409 11.8745 11.9409 10.8049ZM18.125 10.8057C18.125 12.5638 17.092 14.207 15.612 15.3857C14.1234 16.5712 12.1126 17.3494 10 17.3494C7.88787 17.3494 5.87746 16.5711 4.38883 15.3857C2.9086 14.207 1.875 12.5639 1.875 10.8057C1.87513 9.04567 2.91827 7.40295 4.40104 6.22559C5.89264 5.04122 7.9029 4.2627 10 4.2627C12.0974 4.2627 14.1075 5.04127 15.599 6.22559C17.0817 7.40299 18.1249 9.04571 18.125 10.8057ZM13.1909 10.8049C13.1909 12.5651 11.7624 13.9933 10.0016 13.9933C8.24149 13.9933 6.8132 12.565 6.81315 10.8049C6.81315 9.04397 8.24131 7.61556 10.0016 7.61556C11.7626 7.61563 13.1909 9.04389 13.1909 10.8049Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">16 245</div>
                                        </div>
                                        <div class="news__item-meta-likes">
                                            <div class="news__item-meta-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7532 5.87558C12.8592 5.54706 13.2114 5.36662 13.5399 5.47255C14.6254 5.82258 15.3932 6.79242 15.4849 7.92907C15.5127 8.27313 15.2562 8.57451 14.9122 8.60226C14.5681 8.63001 14.2667 8.37359 14.2389 8.02957C14.1879 7.39699 13.7605 6.85707 13.1563 6.66223C12.8277 6.55629 12.6473 6.2041 12.7532 5.87558Z" fill="#FBFBFB"/>
                                                    <path d="M10.0029 17.5168C9.91174 17.5165 9.82166 17.4967 9.73875 17.4584C9.48875 17.3409 3.57795 14.5376 2.19795 10.1143C1.29962 7.31512 2.29879 3.78678 5.53129 2.73678C6.34747 2.48192 7.21218 2.42283 8.05545 2.56428C8.76525 2.72591 9.43041 3.04297 10.0029 3.49262C10.5749 3.03808 11.242 2.71848 11.9546 2.55762C12.7977 2.41628 13.6623 2.4774 14.4771 2.73595C17.7046 3.77595 18.7013 7.30595 17.7997 10.1184C16.3362 14.5876 10.5146 17.3426 10.2679 17.4576C10.1849 17.4962 10.0945 17.5163 10.0029 17.5168ZM7.15378 3.73928C6.73249 3.73906 6.31359 3.80256 5.91128 3.92762C3.33628 4.76512 2.69045 7.54595 3.39295 9.73759C4.45878 13.1543 8.87458 15.6118 10.0062 16.1934C11.1279 15.6159 15.4838 13.1818 16.613 9.73343C17.3163 7.54095 16.6737 4.75762 14.0971 3.92678C13.4727 3.72817 12.8099 3.68132 12.1637 3.79012C11.5062 3.98388 10.8982 4.31731 10.3812 4.76762C10.2731 4.84875 10.1415 4.89262 10.0062 4.89262C9.87108 4.89262 9.73949 4.84875 9.63124 4.76762C9.11241 4.31839 8.50266 3.9864 7.84378 3.79428C7.61568 3.75703 7.3849 3.73863 7.15378 3.73928Z" fill="#FBFBFB"/>
                                                </svg>
                                            </div>
                                            <div class="news__item-meta-count">100</div>
                                        </div>
                                    </div>
                                    <div class="news__item-meta-times">
                                        <div class="news__item-meta-times-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.6668 7.99967C13.6668 5.71509 13.2797 4.3508 12.4644 3.53548C11.649 2.72017 10.2848 2.33301 8.00016 2.33301C5.71557 2.33301 4.35128 2.72017 3.53597 3.53548C2.72066 4.3508 2.3335 5.71508 2.3335 7.99967C2.3335 10.2843 2.72066 11.6486 3.53597 12.4639C4.35128 13.2792 5.71558 13.6663 8.00016 13.6663C10.2848 13.6663 11.649 13.2792 12.4644 12.4639C13.2797 11.6486 13.6668 10.2843 13.6668 7.99967ZM7.49951 5.08887C7.4996 4.81284 7.72347 4.58892 7.99951 4.58887C8.2756 4.58887 8.49942 4.8128 8.49951 5.08887V7.71191L10.5164 8.91569C10.7536 9.05717 10.8311 9.36409 10.6896 9.60124C10.5481 9.83836 10.2412 9.91588 10.0041 9.77441L7.74365 8.42611C7.59244 8.3359 7.49952 8.17249 7.49951 7.99642V5.08887ZM14.6668 7.99967C14.6668 10.3397 14.2832 12.059 13.1714 13.1709C12.0595 14.2827 10.3402 14.6663 8.00016 14.6663C5.66011 14.6663 3.94079 14.2827 2.82894 13.1709C1.71709 12.059 1.3335 10.3397 1.3335 7.99967C1.3335 5.65962 1.71709 3.9403 2.82894 2.82845C3.94079 1.7166 5.6601 1.33301 8.00016 1.33301C10.3402 1.33301 12.0595 1.7166 13.1714 2.82845C14.2832 3.9403 14.6668 5.65962 14.6668 7.99967Z" fill="#F9AA66"/>
                                            </svg>
                                        </div>
                                        <div class="news__item-meta-times-text">15 minutes</div>
                                    </div>
                                </div>
                                <div class="news__item-title">A very long and intriguing article title, stretched out over several long lines</div>
                                <div class="news__item-description">Lorem ipsum dolor sit amet consectetur. Pretium vitae orci quis mi duis nunc. Sed eu elementum dui dui convallis aenean diam sed. Viverra accumsan volutpat sit sit. Pellentesque congue maecenas massa sem viverra. Nunc amet condimentum tincidunt semper etiam egestas amet arcu.</div>
                            </div>
                            <div class="news__item-author">
                                <div class="news__item-author-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/clent_image.webp" alt="Author">
                                </div>
                                <div class="news__item-author-info">
                                    <div class="news__item-author-name">Elon Musk</div>
                                    <div class="news__item-author-job">CEO of Tesla</div>
                                </div>                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <section class="contacts section" id="contacts">
        <div class="container">
            <div class="contacts__wrapper">
                <div class="section__badge">Contacts</div>

                <div class="contacts__content">
                    <div class="contacts__title-block">
                        <h2 class="section__title">Ready to Transform Your Identity Verification?</h2>
                        <p class="section__subtitle">See how NV Global can streamline your onboarding and security in just one demo</p>
                        <p class="section__description">Whether you're scaling your fintech platform, securing crypto transactions, or modernizing government services, we're here to show you exactly how our AI-powered verification fits your unique needs. Connect with our team and discover why leading companies trust NV Global to verify hundreds of millions of identities every year.</p>
                    </div>

                    <div class="contacts__actions">
                        <div class="contacts__card">
                            <div class="contacts__card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21.7038 10.5394C21.3268 10.5394 21.0028 10.2564 20.9598 9.87346C20.5798 6.49746 17.9568 3.87746 14.5808 3.50246C14.1698 3.45646 13.8728 3.08646 13.9188 2.67446C13.9638 2.26346 14.3328 1.95646 14.7468 2.01246C18.8238 2.46446 21.9918 5.62846 22.4498 9.70546C22.4968 10.1174 22.1998 10.4884 21.7888 10.5344C21.7608 10.5374 21.7318 10.5394 21.7038 10.5394Z" fill="#2B323B"/>
                                    <path d="M18.1625 10.5502C17.8105 10.5502 17.4975 10.3022 17.4275 9.94422C17.1395 8.46422 15.9985 7.32322 14.5205 7.03622C14.1135 6.95722 13.8485 6.56422 13.9275 6.15722C14.0065 5.75022 14.4095 5.48522 14.8065 5.56422C16.8875 5.96822 18.4945 7.57422 18.8995 9.65622C18.9785 10.0642 18.7135 10.4572 18.3075 10.5362C18.2585 10.5452 18.2105 10.5502 18.1625 10.5502Z" fill="#2B323B"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.48215 16.8363C12.1952 21.5503 15.3332 22.7863 17.3152 22.7863C18.2932 22.7863 18.9912 22.4853 19.4562 22.1513C19.4772 22.1393 21.6292 20.8233 22.0062 18.8313C22.1842 17.8963 21.9242 16.9713 21.2562 16.1553C18.5042 12.8143 17.1022 13.1263 15.5542 13.8793C14.6032 14.3453 13.8522 14.7073 11.7312 12.5883C9.6114 10.4676 9.97707 9.71652 10.44 8.76568C11.194 7.21768 11.5042 5.81535 8.16215 3.06135C7.34815 2.39635 6.42915 2.13635 5.49515 2.31135C3.53215 2.67835 2.20815 4.79535 2.21015 4.79535C1.15815 6.27235 0.444156 9.79935 7.48215 16.8363ZM5.80115 3.77935C5.88915 3.76535 5.97615 3.75735 6.06215 3.75735C6.45415 3.75735 6.83215 3.91035 7.20915 4.22035C9.90413 6.44033 9.56316 7.14034 9.09116 8.10932C8.38216 9.56632 8.01115 10.9883 10.6702 13.6493C13.3322 16.3103 14.7552 15.9393 16.2102 15.2283L16.2126 15.2271C17.1804 14.7567 17.8801 14.4166 20.0972 17.1083C20.4762 17.5703 20.6212 18.0323 20.5392 18.5193C20.3502 19.6393 19.0482 20.6423 18.6542 20.8863C17.2432 21.8923 13.8462 21.0793 8.54215 15.7763C3.24015 10.4733 2.42615 7.07635 3.46815 5.61135C3.67615 5.27235 4.68315 3.96835 5.80115 3.77935Z" fill="#2B323B"/>
                                </svg>
                            </div>

                            <div class="contacts__card-info">
                                <div class="contacts__card-title">Prefer to reach out directly?</div>

                                <div class="contacts__card-item">
                                    <div class="contacts__card-item-name">Email us:</div>
                                    <a href="mailto:hello@nv.global" class="contacts__card-item-link">
                                        <span>hello@nv.global</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#2B323B"/>
                                        </svg>
                                    </a>
                                </div>

                                <div class="contacts__card-item">
                                    <div class="contacts__card-item-name">Call us</div>
                                    <a href="tel:+15551234567" class="contacts__card-item-link">
                                        <span>+1 (555) 123-4567</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#2B323B"/>
                                        </svg>
                                    </a>
                                </div>

                                <!-- <div class="contacts__card-item-social">
                                    <div class="contacts__card-item-name">Massage us</div>
                                    <div class="contacts__card-social-list">
                                        <a href="#" class="contacts__card-social-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5553 17.28L10.2513 19.421C9.96929 19.684 9.51029 19.468 9.53629 19.083C9.60829 17.995 9.72029 16.342 9.79529 15.423C9.80729 15.278 9.92929 15.116 10.0453 15.011C12.7363 12.571 15.4333 10.137 18.1293 7.70101C18.2293 7.61101 18.3473 7.38901 18.2853 7.27201C18.2153 7.14001 17.8923 7.18001 17.7583 7.26401C14.3343 9.42001 10.9103 11.575 7.49129 13.738C7.28129 13.87 7.02429 13.902 6.78829 13.826C5.37829 13.373 3.96029 12.944 2.54729 12.498C2.22229 12.395 1.83629 12.293 1.79929 11.89C1.76029 11.469 2.12129 11.269 2.44729 11.138C3.76129 10.608 5.08429 10.101 6.40529 9.59101C11.1573 7.76001 15.9093 5.93001 20.6613 4.10001C20.8203 4.03901 21.0323 4.00101 21.1983 3.96801C21.6963 3.86801 22.1443 4.11801 22.1933 4.62201C22.2303 4.99101 22.1653 5.40201 22.0883 5.76701C21.0983 10.476 20.0953 15.183 19.0933 19.891C18.8233 21.163 18.1693 21.404 17.1163 20.627C15.7593 19.625 12.5553 17.28 12.5553 17.28Z" fill="#212121"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="contacts__card-social-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5102 14.0668L14.4072 13.9958C14.1982 13.8498 13.9092 13.8688 13.7362 14.0408L13.5042 14.2748C13.2622 14.5208 12.8812 14.5678 12.5842 14.3898C11.4322 13.6958 10.8572 13.0258 10.1382 11.9568C9.94124 11.6628 9.97624 11.2698 10.2232 11.0158L10.4562 10.7758C10.6392 10.5888 10.6612 10.3098 10.5122 10.0928C10.3532 9.87077 10.1982 9.64777 10.0502 9.43477C9.96424 9.31277 9.82324 9.23277 9.66824 9.21977C9.65524 9.21877 9.64024 9.21777 9.62324 9.21777C9.52924 9.21777 9.38524 9.24377 9.26124 9.36877L9.13624 9.49477L9.13324 9.49777C8.07124 10.5628 9.21824 12.4688 10.6462 13.8978C12.0562 15.3028 13.9442 16.4308 15.0062 15.3668L15.1532 15.2288C15.2822 15.0978 15.2912 14.9228 15.2832 14.8328C15.2752 14.7418 15.2362 14.5728 15.0652 14.4538C14.8812 14.3218 14.7002 14.1978 14.5102 14.0668Z" fill="#212121"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.1959 16.3073L16.0479 16.4473C15.4679 17.0243 14.7669 17.3093 13.9859 17.3093C12.6779 17.3093 11.1459 16.5133 9.58695 14.9593C7.11095 12.4833 6.52995 9.98526 8.06895 8.44026L8.19595 8.31226C8.62095 7.88626 9.21295 7.67026 9.79695 7.72526C10.3949 7.77726 10.9349 8.08726 11.2799 8.57726C11.4259 8.78826 11.5779 9.00526 11.7399 9.23126C12.2439 9.96126 12.2209 10.9123 11.7189 11.6013C12.0779 12.0903 12.4119 12.4513 12.8879 12.7963C13.5799 12.2793 14.5349 12.2573 15.2619 12.7633L15.3609 12.8303C15.5599 12.9683 15.7499 13.0983 15.9319 13.2303C16.4129 13.5643 16.7239 14.1023 16.7779 14.6983C16.8319 15.2963 16.6189 15.8823 16.1959 16.3073ZM21.3319 10.6963C20.6199 6.90926 17.5959 3.88626 13.8089 3.17626C10.9959 2.64726 8.13495 3.38526 5.95295 5.19526C3.75895 7.01526 2.50195 9.68026 2.50195 12.5083C2.50195 13.9303 2.82595 15.3433 3.46395 16.7043C3.51595 16.8223 3.53195 16.9413 3.50795 17.0513C3.35195 17.7603 3.02495 19.1873 2.78895 20.2073C2.68995 20.6383 2.81995 21.0783 3.13395 21.3833C3.44495 21.6853 3.88495 21.8043 4.30495 21.6933C5.25595 21.4533 6.55895 21.1343 7.37695 20.9433C7.48395 20.9183 7.60195 20.9333 7.72495 20.9943C9.04395 21.6583 10.5229 22.0083 12.0019 22.0083C14.8279 22.0083 17.4919 20.7513 19.3099 18.5603C21.1229 16.3773 21.8589 13.5103 21.3319 10.6963Z" fill="#212121"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div> -->
                            </div>

                            <div class="contacts__card-line"></div>

                            <div class="contacts__card-action">
                                <button class="btn btn--black open-callForm2 btn-with-lottie-arrow-orange">
                                    <span>Book a meeting instantly</span>
                                    <span class="btn__icon lottie-container-arrow-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>

                           

                        </div>
                    </div>

                    <div class="contacts__form-block animate-fade-up">

                        <div class="contacts__form-title">Here's what you'll get:</div>

                        <div class="contacts__form-list">
                            <div class="contacts__form-item">
                                <div class="contacts__form-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                        <g filter="url(#filter0_d_2010_7930)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5103 9.5C13.0861 9.5 9.5 13.0861 9.5 17.5103C9.5 21.9345 13.0861 25.5206 17.5103 25.5206C21.9345 25.5206 25.5206 21.9345 25.5206 17.5103C25.5206 13.0861 21.9345 9.5 17.5103 9.5ZM8 17.5103C8 12.2577 12.2577 8 17.5103 8C22.7629 8 27.0206 12.2577 27.0206 17.5103C27.0206 22.7629 22.7629 27.0206 17.5103 27.0206C12.2577 27.0206 8 22.7629 8 17.5103Z" fill="#F9AA66"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4054 10.5453C27.6077 10.9067 27.4787 11.3638 27.1173 11.5661C22.509 14.1459 19.6275 18.3341 18.2528 20.9166C18.1256 21.1556 17.8795 21.3074 17.6088 21.3139C17.3381 21.3204 17.085 21.1806 16.9464 20.948C16.0238 19.3992 14.8536 18.0208 13.4262 16.8154C13.1098 16.5481 13.0699 16.0749 13.3372 15.7585C13.6044 15.442 14.0776 15.4021 14.3941 15.6694C15.613 16.6988 16.664 17.8485 17.5481 19.1159C19.1686 16.4052 22.0482 12.6848 26.3846 10.2572C26.746 10.0549 27.2031 10.1839 27.4054 10.5453Z" fill="#F9AA66"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_2010_7930" x="0" y="0" width="35.501" height="35.0205" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="4"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_7930"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_7930" result="shape"/>
                                            </filter>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="contacts__form-item-text">Live platform demo tailored to your industry</div>
                            </div>
                            <div class="contacts__form-item">
                                <div class="contacts__form-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                        <g filter="url(#filter0_d_2010_7930)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5103 9.5C13.0861 9.5 9.5 13.0861 9.5 17.5103C9.5 21.9345 13.0861 25.5206 17.5103 25.5206C21.9345 25.5206 25.5206 21.9345 25.5206 17.5103C25.5206 13.0861 21.9345 9.5 17.5103 9.5ZM8 17.5103C8 12.2577 12.2577 8 17.5103 8C22.7629 8 27.0206 12.2577 27.0206 17.5103C27.0206 22.7629 22.7629 27.0206 17.5103 27.0206C12.2577 27.0206 8 22.7629 8 17.5103Z" fill="#F9AA66"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4054 10.5453C27.6077 10.9067 27.4787 11.3638 27.1173 11.5661C22.509 14.1459 19.6275 18.3341 18.2528 20.9166C18.1256 21.1556 17.8795 21.3074 17.6088 21.3139C17.3381 21.3204 17.085 21.1806 16.9464 20.948C16.0238 19.3992 14.8536 18.0208 13.4262 16.8154C13.1098 16.5481 13.0699 16.0749 13.3372 15.7585C13.6044 15.442 14.0776 15.4021 14.3941 15.6694C15.613 16.6988 16.664 17.8485 17.5481 19.1159C19.1686 16.4052 22.0482 12.6848 26.3846 10.2572C26.746 10.0549 27.2031 10.1839 27.4054 10.5453Z" fill="#F9AA66"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_2010_7930" x="0" y="0" width="35.501" height="35.0205" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="4"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_7930"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_7930" result="shape"/>
                                            </filter>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="contacts__form-item-text">14-day free trial with full API access</div>
                            </div>
                            <div class="contacts__form-item">
                                <div class="contacts__form-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                        <g filter="url(#filter0_d_2010_7930)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5103 9.5C13.0861 9.5 9.5 13.0861 9.5 17.5103C9.5 21.9345 13.0861 25.5206 17.5103 25.5206C21.9345 25.5206 25.5206 21.9345 25.5206 17.5103C25.5206 13.0861 21.9345 9.5 17.5103 9.5ZM8 17.5103C8 12.2577 12.2577 8 17.5103 8C22.7629 8 27.0206 12.2577 27.0206 17.5103C27.0206 22.7629 22.7629 27.0206 17.5103 27.0206C12.2577 27.0206 8 22.7629 8 17.5103Z" fill="#F9AA66"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4054 10.5453C27.6077 10.9067 27.4787 11.3638 27.1173 11.5661C22.509 14.1459 19.6275 18.3341 18.2528 20.9166C18.1256 21.1556 17.8795 21.3074 17.6088 21.3139C17.3381 21.3204 17.085 21.1806 16.9464 20.948C16.0238 19.3992 14.8536 18.0208 13.4262 16.8154C13.1098 16.5481 13.0699 16.0749 13.3372 15.7585C13.6044 15.442 14.0776 15.4021 14.3941 15.6694C15.613 16.6988 16.664 17.8485 17.5481 19.1159C19.1686 16.4052 22.0482 12.6848 26.3846 10.2572C26.746 10.0549 27.2031 10.1839 27.4054 10.5453Z" fill="#F9AA66"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_2010_7930" x="0" y="0" width="35.501" height="35.0205" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="4"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_7930"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_7930" result="shape"/>
                                            </filter>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="contacts__form-item-text">Custom ROI calculation for your use case</div>
                            </div>
                            <div class="contacts__form-item">
                                <div class="contacts__form-item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                        <g filter="url(#filter0_d_2010_7930)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5103 9.5C13.0861 9.5 9.5 13.0861 9.5 17.5103C9.5 21.9345 13.0861 25.5206 17.5103 25.5206C21.9345 25.5206 25.5206 21.9345 25.5206 17.5103C25.5206 13.0861 21.9345 9.5 17.5103 9.5ZM8 17.5103C8 12.2577 12.2577 8 17.5103 8C22.7629 8 27.0206 12.2577 27.0206 17.5103C27.0206 22.7629 22.7629 27.0206 17.5103 27.0206C12.2577 27.0206 8 22.7629 8 17.5103Z" fill="#F9AA66"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4054 10.5453C27.6077 10.9067 27.4787 11.3638 27.1173 11.5661C22.509 14.1459 19.6275 18.3341 18.2528 20.9166C18.1256 21.1556 17.8795 21.3074 17.6088 21.3139C17.3381 21.3204 17.085 21.1806 16.9464 20.948C16.0238 19.3992 14.8536 18.0208 13.4262 16.8154C13.1098 16.5481 13.0699 16.0749 13.3372 15.7585C13.6044 15.442 14.0776 15.4021 14.3941 15.6694C15.613 16.6988 16.664 17.8485 17.5481 19.1159C19.1686 16.4052 22.0482 12.6848 26.3846 10.2572C26.746 10.0549 27.2031 10.1839 27.4054 10.5453Z" fill="#F9AA66"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_2010_7930" x="0" y="0" width="35.501" height="35.0205" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="4"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_7930"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_7930" result="shape"/>
                                            </filter>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="contacts__form-item-text">Expert guidance on GDPR-compliant implementation</div>
                            </div>
                        </div>

                        <div class="contacts__form-line--orange"></div>

                        <form class="contacts__form" action="#">


                            <div class="input-form-item input-form-item--50">
                                <div class="input-form-label">Name <span>*</span></div>

                                <div class="input-form-block">
                                    <div class="input-form-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="33" viewBox="0 0 29 33" fill="none">
                                            <g filter="url(#filter0_d_2010_5911)">
                                                <path d="M14.0446 17.6615C15.8583 17.6615 17.2379 18.0722 18.2365 18.743C19.2389 19.4164 19.8216 20.3289 20.0692 21.2568C20.2281 21.8532 19.9371 22.4286 19.4678 22.7184C17.9017 23.6855 16.0533 24.2499 14.0764 24.25C12.0782 24.25 10.2075 23.6756 8.63528 22.6875C8.16859 22.3941 7.8822 21.8161 8.0469 21.221C8.56886 19.3355 10.43 17.6615 14.0446 17.6615ZM14.0446 18.9115C10.8576 18.9115 9.59029 20.3299 9.25133 21.5547C9.25015 21.559 9.24902 21.566 9.25459 21.5791C9.26096 21.594 9.27533 21.6139 9.30016 21.6296C10.6785 22.4958 12.3199 23 14.0764 23C15.8125 22.9999 17.4347 22.5046 18.8111 21.6548C18.8362 21.6392 18.8508 21.6195 18.8574 21.6043C18.8631 21.5913 18.8627 21.5839 18.8615 21.5791C18.6893 20.9334 18.2823 20.2794 17.5399 19.7806C16.7937 19.2793 15.6725 18.9115 14.0446 18.9115ZM16.9597 12.1634C16.9597 10.5542 15.6547 9.25 14.0463 9.25C12.4367 9.25002 11.132 10.5543 11.132 12.1634C11.1321 13.7725 12.4367 15.0768 14.0463 15.0768C15.6546 15.0768 16.9596 13.7726 16.9597 12.1634ZM18.2097 12.1634C18.2096 14.4632 16.3448 16.3268 14.0463 16.3268C11.7469 16.3268 9.88212 14.4633 9.88203 12.1634C9.88203 9.86346 11.7468 8.00002 14.0463 8C16.3448 8 18.2097 9.86356 18.2097 12.1634Z" fill="#F9AA66"/>
                                            </g>
                                            <defs>
                                                <filter id="filter0_d_2010_5911" x="0" y="0" width="28.113" height="32.25" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                <feOffset/>
                                                <feGaussianBlur stdDeviation="4"/>
                                                <feComposite in2="hardAlpha" operator="out"/>
                                                <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_5911"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_5911" result="shape"/>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </div>
                                    <input class="input-form contacts__form-input" type="text" name="clientName" placeholder="e.g. John Smith">
                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1784 10L15.5892 5.58921C15.915 5.26338 15.915 4.73671 15.5892 4.41088C15.2634 4.08505 14.7367 4.08505 14.4109 4.41088L10 8.82167L5.58921 4.41088C5.26338 4.08505 4.73671 4.08505 4.41088 4.41088C4.08505 4.73671 4.08505 5.26338 4.41088 5.58921L8.8217 10L4.41088 14.4109C4.08505 14.7367 4.08505 15.2633 4.41088 15.5892C4.57338 15.7517 4.78671 15.8333 5.00005 15.8333C5.21338 15.8333 5.42671 15.7517 5.58921 15.5892L10 11.1784L14.4109 15.5892C14.5734 15.7517 14.7867 15.8333 15 15.8333C15.2134 15.8333 15.4267 15.7517 15.5892 15.5892C15.915 15.2633 15.915 14.7367 15.5892 14.4109L11.1784 10Z" fill="#FBFBFB"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please enter a valid name</div>
                                </div>
                            </div>

                            <div class="input-form-item input-form-item--50">
                                <div class="input-form-label">Company</div>

                                <div class="input-form-block">
                                    <div class="input-form-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                            <g filter="url(#filter0_d_2010_491)">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3856 19.0186C17.7243 18.9526 18.0525 19.1737 18.1185 19.5126L18.1201 19.5209C18.1861 19.8597 17.9649 20.1879 17.6261 20.2538C17.2873 20.3198 16.9592 20.0987 16.8932 19.7598L16.8916 19.7515C16.8256 19.4128 17.0468 19.0846 17.3856 19.0186ZM13.9476 19.0186C14.2864 18.9527 14.6146 19.1738 14.6805 19.5127L14.6821 19.521C14.7481 19.8598 14.5268 20.1879 14.188 20.2539C13.8492 20.3198 13.5211 20.0986 13.4551 19.7597L13.4535 19.7514C13.3876 19.4126 13.6088 19.0845 13.9476 19.0186Z" fill="#F9AA66"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3856 15.7609C17.7243 15.695 18.0525 15.9162 18.1185 16.255L18.1201 16.2633C18.1861 16.6021 17.9649 16.9302 17.6261 16.9962C17.2873 17.0622 16.9592 16.8411 16.8932 16.5022L16.8916 16.4939C16.8256 16.1551 17.0468 15.8269 17.3856 15.7609ZM13.9476 15.7609C14.2864 15.695 14.6146 15.9163 14.6805 16.2551L14.6821 16.2634C14.7481 16.6022 14.5268 16.9303 14.188 16.9962C13.8492 17.0622 13.5211 16.841 13.4551 16.5022L13.4535 16.4938C13.3876 16.155 13.6088 15.8268 13.9476 15.7609Z" fill="#F9AA66"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3856 12.4309C17.7243 12.3649 18.0525 12.5861 18.1185 12.9249L18.1201 12.9332C18.1861 13.272 17.9649 13.6002 17.6261 13.6662C17.2873 13.7321 16.9592 13.511 16.8932 13.1722L16.8916 13.1638C16.8256 12.825 17.0468 12.4969 17.3856 12.4309ZM13.9476 12.4309C14.2864 12.3649 14.6146 12.5861 14.6805 12.925L14.6821 12.9333C14.7481 13.2721 14.5268 13.6002 14.188 13.6662C13.8492 13.7321 13.5211 13.5109 13.4551 13.1721L13.4535 13.1637C13.3876 12.8249 13.6088 12.4968 13.9476 12.4309Z" fill="#F9AA66"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 23.625C8 23.2798 8.27982 23 8.625 23H22.9504C23.2956 23 23.5754 23.2798 23.5754 23.625C23.5754 23.9702 23.2956 24.25 22.9504 24.25H8.625C8.27982 24.25 8 23.9702 8 23.625Z" fill="#F9AA66"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.16862 10.4315C9.16862 9.08882 10.2578 8 11.6009 8H19.9749C21.3181 8 22.4073 9.08882 22.4073 10.4315V23.625C22.4073 23.9702 22.1274 24.25 21.7823 24.25C21.4371 24.25 21.1573 23.9702 21.1573 23.625V10.4315C21.1573 9.77955 20.6281 9.25 19.9749 9.25H11.6009C10.9478 9.25 10.4186 9.77955 10.4186 10.4315V23.625C10.4186 23.9702 10.1388 24.25 9.79362 24.25C9.44844 24.25 9.16862 23.9702 9.16862 23.625V10.4315Z" fill="#F9AA66"/>
                                            </g>
                                            <defs>
                                                <filter id="filter0_d_2010_491" x="0" y="0" width="31.5754" height="32.25" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                <feOffset/>
                                                <feGaussianBlur stdDeviation="4"/>
                                                <feComposite in2="hardAlpha" operator="out"/>
                                                <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_491"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_491" result="shape"/>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </div>
                                    <input class="input-form contacts__form-input" type="text" name="clientCompany" placeholder="e.g. Example Co">
                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1784 10L15.5892 5.58921C15.915 5.26338 15.915 4.73671 15.5892 4.41088C15.2634 4.08505 14.7367 4.08505 14.4109 4.41088L10 8.82167L5.58921 4.41088C5.26338 4.08505 4.73671 4.08505 4.41088 4.41088C4.08505 4.73671 4.08505 5.26338 4.41088 5.58921L8.8217 10L4.41088 14.4109C4.08505 14.7367 4.08505 15.2633 4.41088 15.5892C4.57338 15.7517 4.78671 15.8333 5.00005 15.8333C5.21338 15.8333 5.42671 15.7517 5.58921 15.5892L10 11.1784L14.4109 15.5892C14.5734 15.7517 14.7867 15.8333 15 15.8333C15.2134 15.8333 15.4267 15.7517 15.5892 15.5892C15.915 15.2633 15.915 14.7367 15.5892 14.4109L11.1784 10Z" fill="#FBFBFB"></path>
                                        </svg>
                                    </button>
                                </div>

                            </div>

                            <div class="input-form-item input-form-item--50">
                                <div class="input-form-label">E-mail <span>*</span></div>

                                <div class="input-form-block">
                                    <div class="input-form-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="31" viewBox="0 0 33 31" fill="none">
                                            <g filter="url(#filter0_d_2010_2043)">
                                                <path d="M23 12.9277C23 10.9511 21.7145 9.5 19.9316 9.5H12.5684C10.7854 9.5 9.5 10.9511 9.5 12.9277V18.0781C9.5 20.0574 10.7851 21.5044 12.5664 21.5H19.9336C21.7149 21.5044 23 20.0574 23 18.0781V12.9277ZM20.2041 12.5557C20.5255 12.2947 20.9976 12.3438 21.2588 12.665C21.52 12.9863 21.4715 13.4584 21.1504 13.7197L17.8174 16.4297L17.8115 16.4346C16.9108 17.1503 15.6342 17.1503 14.7334 16.4346L14.7295 16.4316L11.3682 13.7217C11.046 13.4617 10.995 12.9894 11.2549 12.667C11.5148 12.3447 11.9871 12.2941 12.3096 12.5537L15.667 15.2607L15.8057 15.3525C16.1427 15.5367 16.5632 15.5062 16.873 15.2627L20.2041 12.5557ZM24.5 18.0781C24.5 20.707 22.711 23.0051 19.9316 22.999V23H12.5684V22.999C9.789 23.005 8 20.707 8 18.0781V12.9277C8 10.3005 9.78969 8 12.5684 8H19.9316C22.7102 8 24.5 10.3005 24.5 12.9277V18.0781Z" fill="#F9AA66"/>
                                            </g>
                                            <defs>
                                                <filter id="filter0_d_2010_2043" x="0" y="0" width="32.5" height="31" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                <feOffset/>
                                                <feGaussianBlur stdDeviation="4"/>
                                                <feComposite in2="hardAlpha" operator="out"/>
                                                <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2010_2043"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2010_2043" result="shape"/>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </div>
                                    <input class="input-form contacts__form-input" type="email" name="clientEmail" placeholder="e.g. john.smith@example.co">
                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1784 10L15.5892 5.58921C15.915 5.26338 15.915 4.73671 15.5892 4.41088C15.2634 4.08505 14.7367 4.08505 14.4109 4.41088L10 8.82167L5.58921 4.41088C5.26338 4.08505 4.73671 4.08505 4.41088 4.41088C4.08505 4.73671 4.08505 5.26338 4.41088 5.58921L8.8217 10L4.41088 14.4109C4.08505 14.7367 4.08505 15.2633 4.41088 15.5892C4.57338 15.7517 4.78671 15.8333 5.00005 15.8333C5.21338 15.8333 5.42671 15.7517 5.58921 15.5892L10 11.1784L14.4109 15.5892C14.5734 15.7517 14.7867 15.8333 15 15.8333C15.2134 15.8333 15.4267 15.7517 15.5892 15.5892C15.915 15.2633 15.915 14.7367 15.5892 14.4109L11.1784 10Z" fill="#FBFBFB"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please enter a valid e-mail</div>
                                </div>
                            </div>

                            <div class="input-form-item input-form-item--50">
                                <div class="phone-field" data-phone-field>
                                    <div class="phone-field__label input-form-label">
                                        Phone
                                    </div>

                                    <div class="phone-field__control input-form-block">
                                        <div class="phone-field__icon" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 34 34" fill="none">
                                                <g filter="url(#filter0_d_2001_8610)">
                                                    <path d="M24.7987 15.1113C24.4845 15.1113 24.2145 14.8755 24.1787 14.5563C23.862 11.743 21.6762 9.55967 18.8628 9.24717C18.5203 9.20884 18.2728 8.9005 18.3112 8.55717C18.3487 8.21467 18.6562 7.95884 19.0012 8.0055C22.3987 8.38217 25.0387 11.0188 25.4203 14.4163C25.4595 14.7596 25.212 15.0688 24.8695 15.1071C24.8462 15.1096 24.822 15.1113 24.7987 15.1113Z" fill="#F9AA66"/>
                                                    <path d="M21.8476 15.1203C21.5542 15.1203 21.2934 14.9136 21.2351 14.6153C20.9951 13.382 20.0442 12.4311 18.8126 12.192C18.4734 12.1261 18.2526 11.7986 18.3184 11.4595C18.3842 11.1203 18.7201 10.8995 19.0509 10.9653C20.7851 11.302 22.1242 12.6403 22.4617 14.3753C22.5276 14.7153 22.3067 15.0428 21.9684 15.1086C21.9276 15.1161 21.8876 15.1203 21.8476 15.1203Z" fill="#F9AA66"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9473 20.3587C16.8748 24.2871 19.4898 25.3171 21.1415 25.3171C21.9565 25.3171 22.5382 25.0662 22.9257 24.7879C22.9432 24.7779 24.7365 23.6812 25.0507 22.0212C25.199 21.2421 24.9823 20.4712 24.4257 19.7912C22.1323 17.0071 20.964 17.2671 19.674 17.8946C18.8815 18.2829 18.2557 18.5846 16.4882 16.8187C14.7217 15.0515 15.0264 14.4256 15.4122 13.6332C16.0405 12.3432 16.299 11.1746 13.514 8.87958C12.8356 8.32541 12.0698 8.10874 11.2915 8.25458C9.65562 8.56041 8.55229 10.3246 8.55395 10.3246C7.67729 11.5554 7.08229 14.4946 12.9473 20.3587ZM11.5465 9.47791C11.6198 9.46624 11.6923 9.45958 11.764 9.45958C12.0906 9.45958 12.4056 9.58708 12.7198 9.84541C14.9656 11.6954 14.6815 12.2787 14.2881 13.0862C13.6973 14.3004 13.3881 15.4854 15.604 17.7029C17.8223 19.9204 19.0082 19.6112 20.2207 19.0187L20.2227 19.0177C21.0292 18.6257 21.6122 18.3423 23.4598 20.5854C23.7757 20.9704 23.8965 21.3554 23.8282 21.7612C23.6707 22.6946 22.5857 23.5304 22.2573 23.7337C21.0815 24.5721 18.2507 23.8946 13.8306 19.4754C9.41228 15.0562 8.73395 12.2254 9.60229 11.0046C9.77562 10.7221 10.6148 9.63541 11.5465 9.47791Z" fill="#F9AA66"/>
                                                </g>
                                                <defs>
                                                    <filter id="filter0_d_2001_8610" x="0" y="0" width="33.4243" height="33.3174" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                    <feOffset/>
                                                    <feGaussianBlur stdDeviation="4"/>
                                                    <feComposite in2="hardAlpha" operator="out"/>
                                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2001_8610"/>
                                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2001_8610" result="shape"/>
                                                    </filter>
                                                </defs>
                                            </svg>
                                        </div>
                                        
                                        <button class="phone-field__country-btn" type="button" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="phone-field__country-code" data-phone-field-code>44</span>
                                            <span class="phone-field__country-arrow" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="28" viewBox="0 0 20 28" fill="none">
                                                    <path d="M15.3313 9.3964C15.5194 9.03995 15.8733 8.93348 16.1516 9.16398C16.4486 9.41011 16.5471 9.94674 16.3714 10.3625V10.3637H16.3705V10.3648C16.37 10.3661 16.3691 10.3683 16.3681 10.3705C16.3662 10.375 16.3635 10.3816 16.36 10.3899C16.3529 10.4065 16.3424 10.4307 16.329 10.4617C16.302 10.5241 16.2619 10.6148 16.211 10.7294C16.1094 10.9586 15.9621 11.2846 15.7781 11.675C15.4108 12.4543 14.894 13.4978 14.2986 14.545C13.706 15.5873 13.02 16.6608 12.3146 17.481C11.633 18.2735 10.8252 18.9587 10.0001 18.9587C9.17513 18.9587 8.36718 18.2735 7.68565 17.481C6.98028 16.6608 6.29507 15.5873 5.70242 14.545C5.10687 13.4976 4.58956 12.4543 4.22211 11.675C4.03804 11.2847 3.89086 10.9586 3.78917 10.7294C3.73833 10.6148 3.69818 10.5241 3.67117 10.4617C3.65778 10.4307 3.64734 10.4065 3.64024 10.3899C3.63672 10.3817 3.63401 10.375 3.6321 10.3705C3.63117 10.3683 3.6302 10.3661 3.62966 10.3648V10.3637H3.62885V10.3625C3.45317 9.94678 3.55165 9.41013 3.84858 9.16398C4.1269 8.93348 4.48078 9.03995 4.66889 9.3964L4.70632 9.47501C4.70772 9.47831 4.70983 9.48393 4.71283 9.49096C4.71891 9.50517 4.72814 9.52732 4.7405 9.55591C4.76524 9.61308 4.80219 9.698 4.85037 9.80656C4.94686 10.024 5.08848 10.336 5.26541 10.7112C5.61994 11.4631 6.11529 12.4616 6.68061 13.4558C7.24874 14.4549 7.87275 15.4235 8.48399 16.1344C9.11924 16.8731 9.63555 17.2087 10.0001 17.2087C10.3649 17.2087 10.881 16.873 11.5162 16.1344C12.1276 15.4234 12.7522 14.4551 13.3204 13.4558C13.8857 12.4616 14.3803 11.4631 14.7348 10.7112C14.9117 10.336 15.0534 10.024 15.1498 9.80656C15.198 9.69797 15.235 9.61307 15.2597 9.55591C15.2721 9.52732 15.2813 9.50517 15.2874 9.49096C15.2904 9.48397 15.2925 9.4783 15.2939 9.47501L15.3313 9.3964Z" fill="#FBFBFB"/>
                                                </svg>
                                            </span>
                                        </button>

                                        <input class="phone-field__input" type="tel" name="clientPhone" placeholder="000 000 00 00" autocomplete="tel" inputmode="tel" data-phone-field-input/>

                                        <button class="phone-field__clear input-form-clear" type="button" aria-label="Clear phone" data-phone-field-clear>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1784 10L15.5892 5.58921C15.915 5.26338 15.915 4.73671 15.5892 4.41088C15.2634 4.08505 14.7367 4.08505 14.4109 4.41088L10 8.82167L5.58921 4.41088C5.26338 4.08505 4.73671 4.08505 4.41088 4.41088C4.08505 4.73671 4.08505 5.26338 4.41088 5.58921L8.8217 10L4.41088 14.4109C4.08505 14.7367 4.08505 15.2633 4.41088 15.5892C4.57338 15.7517 4.78671 15.8333 5.00005 15.8333C5.21338 15.8333 5.42671 15.7517 5.58921 15.5892L10 11.1784L14.4109 15.5892C14.5734 15.7517 14.7867 15.8333 15 15.8333C15.2134 15.8333 15.4267 15.7517 15.5892 15.5892C15.915 15.2633 15.915 14.7367 15.5892 14.4109L11.1784 10Z" fill="#FBFBFB"></path>
                                            </svg>
                                        </button>

                                        <div class="phone-field__dropdown" hidden data-phone-field-dropdown>
                                            <div class="phone-field__search">
                                                <input class="phone-field__search-input" name="clientPhoneCode" type="text" placeholder="ex. USA" autocomplete="off" data-phone-field-search/>
                                                <button class="phone-field__search-btn" type="button" aria-label="Search" data-phone-field-search-btn>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69371 3.125C6.16465 3.125 3.30408 5.98557 3.30408 9.51458C3.30408 13.0437 6.16474 15.905 9.69371 15.905C11.3592 15.905 12.8759 15.2677 14.0132 14.2235C14.017 14.2196 14.0208 14.2157 14.0246 14.2118C14.04 14.1964 14.0559 14.1821 14.0723 14.1687C15.3103 13.0032 16.0833 11.3491 16.0833 9.51458C16.0833 5.98557 13.2227 3.125 9.69371 3.125ZM15.3497 14.6507C16.5822 13.2938 17.3333 11.4919 17.3333 9.51458C17.3333 5.29522 13.913 1.875 9.69371 1.875C5.47429 1.875 2.05408 5.29522 2.05408 9.51458C2.05408 13.7339 5.4742 17.155 9.69371 17.155C11.4855 17.155 13.1333 16.538 14.4361 15.5049L16.88 17.9425C17.1244 18.1862 17.52 18.1857 17.7639 17.9413C18.0076 17.697 18.0071 17.3012 17.7627 17.0575L15.3497 14.6507ZM10.5126 5.43562C10.613 5.10537 10.9622 4.91907 11.2924 5.01951C12.6534 5.43338 13.7286 6.49147 14.1653 7.8414C14.2715 8.16982 14.0915 8.52217 13.763 8.62842C13.4346 8.73467 13.0823 8.55458 12.976 8.22615C12.6651 7.26519 11.8981 6.51022 10.9287 6.21543C10.5985 6.115 10.4122 5.76587 10.5126 5.43562Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="phone-field__list" role="listbox" tabindex="-1" data-phone-field-list>
                                                <?php echo taodep_render_phone_country_buttons(); ?>
                                            </div>

                                            <div class="phone-field__empty" hidden data-phone-field-empty>
                                                Nothing found
                                            </div>
                                        </div>
                                    </div>

                                   <div class="input-form-error">
                                        <div class="input-form-error-icon"></div>
                                        <div class="input-form-error-text">Please enter a valid phone</div>
                                    </div>
                                </div>
                            </div>

                            <div class="contacts__form-line"></div>

                            <div class="input-form-item help-select" data-help-select>
                                <div class="help-select__label input-form-label">
                                    How can we help you? <span>*</span>
                                </div>

                                <div class="help-select__control input-form-block">
                                    <div class="input-form-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
                                            <g filter="url(#filter0_d_2001_9193)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M24.0606 18.6126C24.4047 18.6384 24.6622 18.9393 24.6364 19.2834L24.4781 21.3743C24.3472 23.0993 22.8914 24.4501 21.1622 24.4501H11.4956C9.76642 24.4501 8.31058 23.0993 8.17975 21.3743L8.02142 19.2834C7.99558 18.9393 8.25392 18.6384 8.59808 18.6126C8.94392 18.6001 9.24225 18.8443 9.26892 19.1893L9.42642 21.2793C9.50808 22.3559 10.4164 23.2001 11.4956 23.2001H21.1622C22.2414 23.2001 23.1506 22.3559 23.2314 21.2793L23.3897 19.1893C23.4164 18.8443 23.7222 18.5993 24.0606 18.6126ZM17.4041 8C18.6565 8 19.6941 8.93855 19.8504 10.1492L21.4917 10.1499C23.2383 10.1499 24.6583 11.5741 24.6583 13.3257V16.1916C24.6583 16.4141 24.54 16.6191 24.3492 16.7308C22.2922 17.9353 19.6866 18.6379 16.9538 18.7316L16.9541 20.2305C16.9541 20.5755 16.6741 20.8555 16.3291 20.8555C15.9841 20.8555 15.7041 20.5755 15.7041 20.2305L15.7035 18.7319C12.9735 18.639 10.3676 17.9362 8.30917 16.7308C8.1175 16.6191 8 16.4141 8 16.1916V13.3174C8 11.5708 9.42417 10.1499 11.175 10.1499L12.8078 10.1492C12.964 8.93855 14.0016 8 15.2541 8H17.4041ZM21.4917 11.3999H11.175C10.1133 11.3999 9.25 12.2599 9.25 13.3174V15.8274C11.2281 16.9022 13.7219 17.4913 16.3175 17.4924L16.3291 17.4913L16.3383 17.4917L16.7351 17.4875C19.19 17.4291 21.5318 16.8466 23.4083 15.8274V13.3257C23.4083 12.2632 22.5492 11.3999 21.4917 11.3999ZM17.4041 9.25H15.2541C14.693 9.25 14.2193 9.63189 14.0794 10.1494H18.5788C18.4389 9.63189 17.9652 9.25 17.4041 9.25Z" fill="#F9AA66"/>
                                            </g>
                                            <defs>
                                            <filter id="filter0_d_2001_9193" x="0" y="0" width="32.6584" height="32.4502" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                <feOffset/>
                                                <feGaussianBlur stdDeviation="4"/>
                                                <feComposite in2="hardAlpha" operator="out"/>
                                                <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.5 0"/>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2001_9193"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2001_9193" result="shape"/>
                                            </filter>
                                            </defs>
                                        </svg>
                                    </div>

                                    <button class="help-select__button" type="button" aria-haspopup="listbox" aria-expanded="false" data-help-select-button>
                                        <span class="help-select__placeholder" data-help-select-placeholder>Select your option...</span>
                                        <span class="help-select__value" hidden data-help-select-value></span>
                                    </button>

                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1784 10L15.5892 5.58921C15.915 5.26338 15.915 4.73671 15.5892 4.41088C15.2634 4.08505 14.7367 4.08505 14.4109 4.41088L10 8.82167L5.58921 4.41088C5.26338 4.08505 4.73671 4.08505 4.41088 4.41088C4.08505 4.73671 4.08505 5.26338 4.41088 5.58921L8.8217 10L4.41088 14.4109C4.08505 14.7367 4.08505 15.2633 4.41088 15.5892C4.57338 15.7517 4.78671 15.8333 5.00005 15.8333C5.21338 15.8333 5.42671 15.7517 5.58921 15.5892L10 11.1784L14.4109 15.5892C14.5734 15.7517 14.7867 15.8333 15 15.8333C15.2134 15.8333 15.4267 15.7517 15.5892 15.5892C15.915 15.2633 15.915 14.7367 15.5892 14.4109L11.1784 10Z" fill="#FBFBFB"></path>
                                        </svg>
                                    </button>

                                    <button class="help-select__arrow" type="button" aria-hidden="true" tabindex="-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15.3311 6.71116C15.5192 6.45655 15.8731 6.3805 16.1514 6.54514C16.4484 6.72095 16.5468 7.10426 16.3711 7.40126V7.40207H16.3703V7.40289C16.3698 7.4038 16.3688 7.40537 16.3679 7.40696C16.3659 7.41018 16.3633 7.41488 16.3597 7.42079C16.3526 7.43266 16.3422 7.44993 16.3288 7.47206C16.3018 7.51667 16.2617 7.58144 16.2108 7.6633C16.1091 7.827 15.9619 8.0599 15.7779 8.33876C15.4105 8.89534 14.8938 9.64071 14.2984 10.3887C13.7058 11.1332 13.0197 11.9 12.3143 12.4859C11.6327 13.0519 10.8249 13.5414 9.99986 13.5414C9.17488 13.5414 8.36694 13.052 7.68541 12.4859C6.98003 11.9 6.29483 11.1332 5.70217 10.3887C5.10663 9.64062 4.58932 8.8954 4.22187 8.33876C4.0378 8.05992 3.89062 7.82699 3.78892 7.6633C3.73808 7.58147 3.69794 7.51666 3.67092 7.47206C3.65753 7.44996 3.6471 7.43265 3.64 7.42079C3.63648 7.41491 3.63377 7.41017 3.63186 7.40696C3.63093 7.40539 3.62995 7.40379 3.62942 7.40289V7.40207H3.62861V7.40126C3.45293 7.10428 3.5514 6.72097 3.84833 6.54514C4.12666 6.3805 4.48054 6.45655 4.66864 6.71116L4.70608 6.76731C4.70748 6.76966 4.70958 6.77368 4.71259 6.7787C4.71866 6.78885 4.72789 6.80467 4.74026 6.82509C4.765 6.86593 4.80195 6.92658 4.85012 7.00412C4.94662 7.15944 5.08824 7.38227 5.26516 7.65028C5.6197 8.18736 6.11504 8.9006 6.68036 9.61073C7.24849 10.3244 7.87251 11.0162 8.48375 11.524C9.11899 12.0516 9.63531 12.2914 9.99986 12.2914C10.3647 12.2914 10.8807 12.0516 11.516 11.524C12.1274 11.0162 12.752 10.3245 13.3202 9.61073C13.8854 8.90061 14.3801 8.18735 14.7346 7.65028C14.9115 7.38227 15.0531 7.15944 15.1496 7.00412C15.1978 6.92656 15.2347 6.86592 15.2595 6.82509C15.2718 6.80467 15.2811 6.78885 15.2871 6.7787C15.2901 6.77371 15.2922 6.76965 15.2936 6.76731L15.3311 6.71116Z" fill="#2B323B"/>
                                        </svg>
                                    </button>

                                    <div class="help-select__dropdown" role="listbox" hidden data-help-select-dropdown>
                                        <button class="help-select__option" type="button" role="option" data-value="Schedule a demo">
                                            Schedule a demo
                                        </button>

                                        <button class="help-select__option" type="button" role="option" data-value="Discuss integration">
                                            Discuss integration
                                        </button>

                                        <button class="help-select__option" type="button" role="option" data-value="Get pricing information">
                                            Get pricing information
                                        </button>

                                        <button class="help-select__option" type="button" role="option" data-value="Technical questions">
                                            Technical questions
                                        </button>
                                    </div>
                                </div>

                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please select an option</div>
                                </div>

                                <!-- Hidden input для отправки формы -->
                                <input type="hidden" name="clientOption" value="" data-help-select-hidden/>
                            </div>

                            <div class="contacts__form-line"></div>
                            
                            <div class="input-form-item">
                                <div class="input-form-label">Your Massage <span>(optional)</span></div>
                                <div class="input-form-block input-form-block--textarea">
                                    <textarea name="clientMessage" placeholder="What do you want to discuss?"></textarea>
                                </div>
                            </div>

                            <div class="contacts__form-line"></div>

                            <div class="input-form-item input-form-item--privacy">
                                <div class="privacy-consent">
                                    <label class="ui-check">
                                        <input class="ui-check__input" type="checkbox" name="privacyConsent" />
                                        <span class="ui-check__box" aria-hidden="true"></span>
                            
                                        <span class="ui-check__text">
                                            I have read and agree to the <a class="ui-check__link" href="/terms_of_use/" target="_blank" rel="noopener">Terms of Use</a> and <a class="ui-check__link" href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a>
                                        </span>
                                    </label>
                                </div>
                            
                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please accept the privacy policy</div>
                                </div>
                            </div>
                            
                            <div class="captcha-holder captcha-holder--preload"></div>

                            <div class="input-form-action">
                                <button class="btn-form" type="submit">
                                    <div class="btn-form__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M18 11.9996C17.9951 11.4735 17.7832 10.9705 17.41 10.5996L13.12 6.29958C12.9326 6.11333 12.6792 6.00879 12.415 6.00879C12.1508 6.00879 11.8974 6.11333 11.71 6.29958C11.6163 6.39254 11.5419 6.50315 11.4911 6.62501C11.4403 6.74686 11.4142 6.87757 11.4142 7.00958C11.4142 7.14159 11.4403 7.2723 11.4911 7.39416C11.5419 7.51602 11.6163 7.62662 11.71 7.71958L15 10.9996H5C4.73478 10.9996 4.48043 11.1049 4.29289 11.2925C4.10536 11.48 4 11.7344 4 11.9996C4 12.2648 4.10536 12.5192 4.29289 12.7067C4.48043 12.8942 4.73478 12.9996 5 12.9996H15L11.71 16.2896C11.5217 16.4766 11.4154 16.7307 11.4144 16.996C11.4135 17.2614 11.518 17.5163 11.705 17.7046C11.892 17.8929 12.1461 17.9992 12.4115 18.0001C12.6768 18.0011 12.9317 17.8966 13.12 17.7096L17.41 13.4096C17.7856 13.0362 17.9978 12.5292 18 11.9996Z" fill="#2B323B"/>
                                        </svg>
                                    </div>
                                    <span class="btn__text btn__text-hero">Get Started</span>                                
                                </button>
                            </div>
                            

                        </form>


                    </div>
                </div>

                <div class="contacts__bottom">
                    <div class="contacts__bottom-text">Our teams are ready to help from Amsterdam, Dubai, and São Paulo</div>
                    <div class="contacts__bottom-list">
                        <div class="contacts__bottom-item tag">ISO 27001 certified</div>
                        <div class="contacts__bottom-item tag">GDPR compliant</div>
                        <div class="contacts__bottom-item tag">SOC 2 Type II</div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>


</main>

<!-- ===== HERO VARIANT 1: <video> + direct currentTime sync via scroll ===== -->
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
    // Отключаем авто-восстановление позиции скролла браузером: hero с pin должен считаться
    // от верха страницы. Иначе при обновлении на середине страницы pin создаётся относительно
    // восстановленной позиции, ломается pin-spacer и сверху появляется пустота.
    if ('scrollRestoration' in history) { try { history.scrollRestoration = 'manual'; } catch (e) {} }

    document.addEventListener('DOMContentLoaded', function () {
        if (!window.gsap || !window.ScrollTrigger) return;

        var heroSection  = document.querySelector('.hero');
        var heroWrapper  = document.querySelector('.hero__wrapper');
        var heroGradient = document.querySelector('.hero_gradient');
        var video        = document.getElementById('heroVideo');

        if (!heroSection || !heroWrapper || !heroGradient || !video) return;

        gsap.registerPlugin(ScrollTrigger);
        ScrollTrigger.config({ ignoreMobileResize: true });

        heroWrapper.style.opacity  = 1;
        heroGradient.style.opacity = 1;

        // ---- Диагностика ----
        var DEBUG = false;   // служебный вывод в консоль отключён
        function log() {
            if (!DEBUG) return;
            var a = ['%c[hero-v1]', 'color:#0a0;font-weight:bold'];
            for (var i = 0; i < arguments.length; i++) a.push(arguments[i]);
            console.log.apply(console, a);
        }
        log('init', { readyState: video.readyState, duration: video.duration });

        // Видео не проигрывается само — кадр задаёт только render-loop
        video.pause();
        video.muted = true;
        video.playsInline = true;

        // iOS-костыль: «пробуждаем» видео-декодер на ПЕРВОМ жесте пользователя (play()->pause()),
        // иначе iOS Safari не обновляет кадр <video> при перемотке currentTime на паузе.
        var _primed = false;
        function primeVideo() {
            if (_primed) return;
            _primed = true;
            var p = video.play();
            if (p && typeof p.then === 'function') {
                p.then(function () { video.pause(); }).catch(function () {});
            } else {
                try { video.pause(); } catch (e) {}
            }
            log('video primed on first gesture');
        }
        window.addEventListener('touchstart', primeVideo, { once: true, passive: true });
        window.addEventListener('click', primeVideo, { once: true });

        /* =====================================================================
           СЛОЙ 2 — TIMELINE CONTROLLER (единый animation clock)
           scroll задаёт НАМЕРЕНИЕ (targetProgress), RAF его ИСПОЛНЯЕТ.
           ===================================================================== */
        var targetProgress  = 0;   // вход:  куда хочет скролл (0..1)
        var currentProgress = 0;   // выход: что реально показываем (сглажено, монотонно)
        var EASE     = 0.10;       // lerp smoothing
        var MAX_STEP = 0.05;       // velocity limit — макс. изменение прогресса за кадр
        var started  = false;
        var frameTick = 0;

        function animate() {
            requestAnimationFrame(animate);

            var delta = (targetProgress - currentProgress) * EASE;
            if (delta >  MAX_STEP) delta =  MAX_STEP;   // velocity limit — строго монотонно
            if (delta < -MAX_STEP) delta = -MAX_STEP;
            currentProgress += delta;

            render(currentProgress);

            // раз в ~30 кадров печатаем состояние, но только пока идёт заметное движение
            if (DEBUG && (frameTick++ % 30 === 0) && Math.abs(targetProgress - currentProgress) > 0.002) {
                log('tick', {
                    target: +targetProgress.toFixed(3),
                    current: +currentProgress.toFixed(3),
                    currentTime: +video.currentTime.toFixed(3),
                    duration: +(video.duration || 0).toFixed(3),
                    seeking: video.seeking
                });
            }
        }

        /* =====================================================================
           СЛОЙ 3 — RENDER ENGINE (ничего не знает о scroll)
           ===================================================================== */
        var desiredTime = 0;
        function renderVideo(progress) {
            var d = video.duration;
            if (!isFinite(d) || d <= 0) {
                log('renderVideo: duration не готова', d);
                return;
            }
            var t = progress * d;
            if (t < 0) t = 0; else if (t > d) t = d;
            desiredTime = t;
            // ВАЖНО: сикаем только когда предыдущий seek завершён. Иначе <video> постоянно
            // в состоянии seeking и не успевает отрисовать кадр — видео визуально «не играет».
            // Так браузер декодирует кадры в максимальном темпе и всегда догоняет последнюю цель.
            if (!video.seeking) {
                try { video.currentTime = t; } catch (e) { log('seek error', e); }
            }
        }
        function renderFades(progress) {
            gsap.set(heroWrapper,  { x: -500 * progress, opacity: 1 - progress });
            gsap.set(heroGradient, { x: -500 * progress, opacity: 1 - progress });
        }
        function render(progress) {
            renderVideo(progress);
            renderFades(progress);
        }

        /* =====================================================================
           СЛОЙ 1 — SCROLL (GSAP ScrollTrigger: ТОЛЬКО progress + pin)
           ===================================================================== */
        // Длина прокрутки привязана к длительности видео, чтобы клип успел проиграться
        // целиком по мере скролла (иначе на 1 экране 6-секундное видео не «докручивается»).
        var PX_PER_SEC = 300;
        function computeScrollLen() {
            var height = heroSection.offsetHeight;
            var dur    = (isFinite(video.duration) && video.duration > 0) ? video.duration : 1;
            return Math.max(height, Math.round(dur * PX_PER_SEC));
        }

        function buildScroll() {
            log('buildScroll', { heroHeight: heroSection.offsetHeight, duration: video.duration, scrollLen: computeScrollLen() });

            ScrollTrigger.create({
                id: 'hero-video-scroll',
                trigger: heroSection,
                start: 'top top',
                end: function () { return '+=' + computeScrollLen(); },  // пересчёт при refresh
                pin: true,
                pinSpacing: true,
                anticipatePin: 1,
                invalidateOnRefresh: true,
                onUpdate: function (self) {
                    targetProgress = self.progress;   // scroll = intention, и только
                },
                onToggle: function (self) {
                    log('pin toggle -> active =', self.isActive);
                },
                onRefresh: function (self) {
                    log('refresh -> start/end px', Math.round(self.start), Math.round(self.end),
                        'distance =', Math.round(self.end - self.start));
                }
            });
            requestAnimationFrame(function () { ScrollTrigger.refresh(); });
        }

        function start() {
            if (started) return;
            started = true;
            log('start', { duration: video.duration, readyState: video.readyState,
                           videoW: video.videoWidth, videoH: video.videoHeight });
            try { video.currentTime = 0; } catch (e) {}  // первый кадр сразу, без заставки
            // Прокручиваем к началу перед созданием pin (кроме перехода по якорю #...),
            // чтобы pin посчитался от верха и не было пустоты сверху после обновления.
            if (!location.hash) { window.scrollTo(0, 0); }
            render(0);
            buildScroll();
            requestAnimationFrame(animate);   // RAF = execution
        }

        // duration может прийти позже (или как Infinity) — ждём событий и пересчитываем pin
        video.addEventListener('seeked',   function () { if (DEBUG && frameTick < 3) log('seeked ->', +video.currentTime.toFixed(3)); });
        video.addEventListener('durationchange', function () {
            log('durationchange ->', video.duration);
            if (started) ScrollTrigger.refresh();   // пересчитать длину pin под реальную duration
        });

        if (isFinite(video.duration) && video.duration > 0) {
            start();
        } else {
            log('duration ещё не готова, ждём loadedmetadata...');
            video.addEventListener('loadedmetadata', start, { once: true });
            // подстраховка: если метаданные не пришли за 3 c — стартуем всё равно
            setTimeout(function () { if (!started) { log('fallback start по таймауту'); start(); } }, 3000);
        }

        if (typeof initFadeUpAnimations === 'function') initFadeUpAnimations();
    });
})();
</script>

<?php
get_footer();
?>