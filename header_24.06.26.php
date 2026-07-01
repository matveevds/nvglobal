<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon-32x32.png">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/img/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo get_template_directory_uri(); ?>/img/favicon/android-chrome-512x512.png">

    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/img/clients__item--bank-hover.svg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/img/clients__item--crypto-hover.svg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/img/clients__item--goverment-hover.svg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/img/clients__item--insurance-hover.svg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/img/clients__item--gambling-hover.svg" as="image">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/img/clients__item--goverment.svg" as="image">
    
    <link rel="preload" href="/wp-content/themes/nvglobal/animation/video1/main_bg2_000.jpg" as="image">
    <script>
        window.HCAPTCHA_SITEKEY = '<?php echo esc_js(defined("HCAPTCHA_SITEKEY") ? HCAPTCHA_SITEKEY : ""); ?>';
        window.__HCAPTCHA_READY__ = false;
        window.__USE_CAPTCHA__ = false;

        window.hcaptchaOnLoad = function () {
            window.__HCAPTCHA_READY__ = true;
            document.dispatchEvent(new Event('hcaptcha:ready'));
        };

        function shouldUseCaptcha() {
            const body = document.body;
            if (!body) return false;

            return body.dataset.useCaptcha === '1';
        }

        function loadHCaptcha() {
            window.__USE_CAPTCHA__ = shouldUseCaptcha();

            if (!window.__USE_CAPTCHA__) {
                window.__HCAPTCHA_READY__ = true;
                document.dispatchEvent(new Event('hcaptcha:ready'));
                return;
            }

            const base = 'https://js.hcaptcha.com/1/api.js?render=explicit&onload=hcaptchaOnLoad';
            const src = `${base}&hl=en`;

            if (document.querySelector('script[data-hcaptcha-api]')) return;

            const s = document.createElement('script');
            s.src = src;
            s.async = true;
            s.defer = true;
            s.setAttribute('data-hcaptcha-api', '1');
            document.head.appendChild(s);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadHCaptcha);
        } else {
            loadHCaptcha();
        }
    </script>
        
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-use-captcha="<?php echo (bool) get_field('use_captcha', 'options') ? '1' : '0'; ?>">
<!--
<style>
    #preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #212121;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s;
}

#lottiePreloader {
    width: 300px;
    height: 300px;
}

body.preload {
    overflow: hidden;
}

#site-content {
    opacity: 0;
    transition: opacity 0.5s;
}
</style>
<div id="preloader">
    <div id="lottiePreloader"></div>
</div>
-->
<div id="site-content">
    <header class="header">
        <div class="container">
            <div class="header__wrapper">
                <a href="<?php echo home_url(); ?>" class="header__logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/nvglobal_logo.png" alt="NV Global">
                </a>
                <div class="header__menu">
                    <button class="burger" aria-label="Open menu" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 13C10.319 13 10.5 14.38 10.5 17.25C10.5 18.688 10.5 19.711 9.896 20.46C9.201 21.323 7.936 21.5 6.25 21.5C4.564 21.5 3.299 21.323 2.604 20.46C2 19.711 2 18.689 2 17.275L2.75 17.25H2C2 14.38 2.181 13 6.25 13ZM17.25 13C21.319 13 21.5 14.38 21.5 17.25C21.5 18.688 21.5 19.711 20.896 20.46C20.201 21.323 18.936 21.5 17.25 21.5C15.564 21.5 14.299 21.323 13.604 20.46C13 19.711 13 18.689 13 17.275L13.75 17.25H13C13 14.38 13.181 13 17.25 13ZM6.45616 14.5004L6.25 14.5C3.64103 14.5 3.50723 14.6872 3.50037 16.8771L3.50079 17.7302C3.50553 18.6011 3.53871 19.2303 3.771 19.52C4.036 19.848 4.823 20 6.25 20C7.677 20 8.464 19.847 8.729 19.519C9 19.182 9 18.382 9 17.274C9 14.7738 9 14.5122 6.45616 14.5004ZM17.4562 14.5004L17.25 14.5C14.641 14.5 14.5072 14.6872 14.5004 16.8771L14.5008 17.7302C14.5055 18.6011 14.5387 19.2303 14.771 19.52C15.036 19.848 15.823 20 17.25 20C18.677 20 19.464 19.847 19.729 19.519C20 19.182 20 18.382 20 17.274C20 14.7738 20 14.5122 17.4562 14.5004ZM6.25 2C10.319 2 10.5 3.38 10.5 6.25C10.5 7.688 10.5 8.711 9.896 9.46C9.201 10.323 7.936 10.5 6.25 10.5C4.564 10.5 3.299 10.323 2.604 9.46C2 8.711 2 7.689 2 6.275L2.75 6.25H2C2 3.38 2.181 2 6.25 2ZM17.25 2C21.319 2 21.5 3.38 21.5 6.25C21.5 7.688 21.5 8.711 20.896 9.46C20.201 10.323 18.936 10.5 17.25 10.5C15.564 10.5 14.299 10.323 13.604 9.46C13 8.711 13 7.689 13 6.275L13.75 6.25H13C13 3.38 13.181 2 17.25 2ZM6.45616 3.50045L6.25 3.5C3.64103 3.5 3.50723 3.68721 3.50037 5.87705L3.50079 6.73018C3.50553 7.60114 3.53871 8.23029 3.771 8.52C4.036 8.848 4.823 9 6.25 9C7.677 9 8.464 8.847 8.729 8.519C9 8.182 9 7.382 9 6.274C9 3.7738 9 3.51222 6.45616 3.50045ZM17.4562 3.50045L17.25 3.5C14.641 3.5 14.5072 3.68721 14.5004 5.87705L14.5008 6.73018C14.5055 7.60114 14.5387 8.23029 14.771 8.52C15.036 8.848 15.823 9 17.25 9C18.677 9 19.464 8.847 19.729 8.519C20 8.182 20 7.382 20 6.274C20 3.7738 20 3.51222 17.4562 3.50045Z" fill="#FBFBFB"/>
                        </svg>
                    </button>
                    
                    <nav class="header__nav">
                        <ul class="header__nav-list">
                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#about" class="header__nav-link header__nav-link--underline">About</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#solutions" class="header__nav-link header__nav-link--underline">Industry Solutions</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#products" class="header__nav-link header__nav-link--underline">Products</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#advantages" class="header__nav-link header__nav-link--underline">Advantages</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#clients" class="header__nav-link header__nav-link--underline">Clients</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#cases" class="header__nav-link header__nav-link--underline">Cases</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#documentation" class="header__nav-link header__nav-link--underline">Documentation</a></li>

                            <li class="header__nav-item"><a href="<?php echo home_url(); ?>/#contacts" class="header__nav-link header__nav-link--underline">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
                <button class="btn--desktop btn--header open-callForm2 btn-with-lottie-arrow">
                    <span class="btn__text">Inquire</span>
                    <span class="btn__icon lottie-container-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10.8658 4.45482C11.0296 4.15097 11.4091 4.03713 11.713 4.20091H11.7138L11.7146 4.20172C11.7154 4.20216 11.7165 4.20263 11.7179 4.20335C11.7208 4.20493 11.7249 4.20783 11.7301 4.21068C11.7406 4.21643 11.7562 4.22433 11.7756 4.23509C11.8148 4.25681 11.8718 4.28864 11.9433 4.32949C12.0861 4.41115 12.2889 4.5301 12.5317 4.67943C13.016 4.97735 13.6656 5.40122 14.318 5.90176C14.9666 6.39945 15.6383 6.9887 16.1539 7.61969C16.6575 8.23596 17.0833 8.97818 17.0833 9.77057L17.0784 9.91787C17.0299 10.655 16.6269 11.3441 16.1547 11.9223C15.6391 12.5536 14.9666 13.1423 14.318 13.6402C13.6655 14.141 13.016 14.5653 12.5317 14.8633C12.2889 15.0127 12.0861 15.1316 11.9433 15.2133C11.8718 15.2541 11.8148 15.286 11.7756 15.3077C11.7565 15.3183 11.7414 15.3263 11.7309 15.3321C11.7256 15.335 11.7208 15.3378 11.7179 15.3394C11.7165 15.3401 11.7154 15.3406 11.7146 15.341L11.7138 15.3419H11.713C11.4092 15.5057 11.0296 15.3925 10.8658 15.0888C10.702 14.7849 10.8159 14.4054 11.1197 14.2416C11.1201 14.2414 11.1212 14.2413 11.1222 14.2408C11.124 14.2398 11.127 14.2381 11.1311 14.2359C11.1396 14.2313 11.1528 14.2235 11.1702 14.2139C11.2048 14.1947 11.2562 14.1655 11.3223 14.1277C11.4552 14.0517 11.6467 13.9403 11.8765 13.7989C12.3374 13.5153 12.9483 13.1156 13.5562 12.649C14.1679 12.1795 14.7566 11.6573 15.1863 11.1312C15.4026 10.8664 15.5615 10.6204 15.668 10.3964H3.95825C3.61307 10.3964 3.33325 10.1166 3.33325 9.77138C3.33327 9.42622 3.61309 9.14638 3.95825 9.14638H15.6689C15.5624 8.92221 15.403 8.67601 15.1863 8.41071C14.7567 7.88494 14.1687 7.3623 13.557 6.89297C12.9491 6.42647 12.3375 6.0274 11.8765 5.74388C11.6469 5.60264 11.456 5.49103 11.3232 5.4151C11.2569 5.37721 11.2048 5.34805 11.1702 5.32884C11.1529 5.31927 11.1396 5.31231 11.1311 5.30768C11.1269 5.30538 11.1241 5.30302 11.1222 5.30198C11.1212 5.30147 11.1201 5.30136 11.1197 5.30117C10.8161 5.13744 10.7024 4.75857 10.8658 4.45482Z" fill="#2B323B"/>
                        </svg>
                    </span>
                </button>
                <button class="btn btn--mobile open-callForm2">
                    <span class="btn__text">Inquire</span>
                    <span class="btn__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </header>

