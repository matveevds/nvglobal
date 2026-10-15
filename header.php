<!DOCTYPE html>
<html lang="en">
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
        document.documentElement.classList.add('has-js');
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
<?php wp_body_open(); ?>
<div id="site-content">
    <?php
    /*
     * Глобальная шапка. Структура меню — inc/header-menu.php, иконки — inc/header-icons.php,
     * поведение — initHeaderMenu() в js/main.js (один контроллер на все ширины),
     * стили — секция HEADER в css/styles.css. Макет — Figma NV Global, Header
     * (docs/DECISIONS.md, Р-141). Шапка одна на весь сайт: светлая, без вариантов
     * по шаблонам.
     */
    $nv_menu     = nv_header_menu();
    $nv_langs    = nv_header_languages();
    $nv_current  = nv_header_current();
    $nv_img      = get_template_directory_uri() . '/img/';
    $nv_lang_now = $nv_langs[0];

    foreach ($nv_langs as $nv_lang) {
        if (!empty($nv_lang['current'])) {
            $nv_lang_now = $nv_lang;
        }
    }

    $nv_cur = static fn(string $key): string => $nv_current === $key ? ' is-current' : '';
    $nv_aria = static fn(string $key): string => $nv_current === $key ? ' aria-current="page"' : '';
    $nv_products = $nv_menu['products'];
    $nv_industries = $nv_menu['industries'];
    $nv_resources = $nv_menu['resources'];
    ?>
    <header class="header" id="site-header" data-header>
        <div class="header__bar">
            <div class="header__shell">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo" aria-label="NeuroVision Global Systems — home">
                    <img src="<?php echo esc_url($nv_img . 'header-logo-mark.svg'); ?>" width="46" height="32" alt="">
                </a>

                <nav class="header__nav" id="header-nav" aria-label="Main navigation" data-header-nav>
                    <ul class="header__list">

                        <li class="header__item<?php echo esc_attr($nv_cur('products')); ?>" data-menu="products">
                            <button type="button" class="header__trigger" id="header-trigger-products" aria-expanded="false" aria-controls="header-panel-products" data-trigger="products">
                                <span class="header__trigger-label"><?php echo esc_html($nv_products['label']); ?></span>
                                <span class="header__chevron"><?php echo nv_header_icon('angle'); echo nv_header_icon('chev', 'header__icon--m'); ?></span>
                            </button>
                            <div class="header__panel header__panel--products" id="header-panel-products" role="region" aria-labelledby="header-trigger-products" data-panel="products">
                                <div class="mega mega--products">
                                    <div class="mega__col mega__col--list">
                                        <ul class="mega__list">
                                            <?php foreach ($nv_products['items'] as $nv_i => $nv_item) : ?>
                                            <li>
                                                <button type="button" class="mega__item" aria-expanded="false" aria-controls="header-product-<?php echo esc_attr($nv_item['id']); ?>" data-product="<?php echo esc_attr($nv_item['id']); ?>">
                                                    <span class="mega__item-label"><?php echo esc_html($nv_item['link']['label']); ?></span>
                                                    <?php echo nv_header_icon('chev-right', 'mega__item-icon'); ?>
                                                </button>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <a href="<?php echo esc_url($nv_products['cta']['url']); ?>" class="header-btn header-btn--primary header-btn--small mega__cta">
                                            <span class="header-btn__text"><?php echo esc_html($nv_products['cta']['label']); ?></span>
                                            <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                                        </a>
                                    </div>
                                    <div class="mega__col mega__col--detail">
                                        <?php foreach ($nv_products['items'] as $nv_item) : ?>
                                        <div class="mega__pane" id="header-product-<?php echo esc_attr($nv_item['id']); ?>" role="region" aria-label="<?php echo esc_attr($nv_item['link']['label']); ?>" data-pane="<?php echo esc_attr($nv_item['id']); ?>">
                                            <button type="button" class="header__back" data-back>
                                                <?php echo nv_header_icon('arrow-left', 'header__back-icon'); ?>
                                                <span>Back</span>
                                            </button>
                                            <div class="mega__card">
                                                <div class="mega__card-text">
                                                    <p class="mega__card-title"><?php echo esc_html($nv_item['link']['label']); ?></p>
                                                    <?php if (!empty($nv_item['desc'])) : ?>
                                                    <p class="mega__card-desc"><?php echo esc_html($nv_item['desc']); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="<?php echo esc_url($nv_item['link']['url']); ?>" class="header-btn header-btn--primary header-btn--small mega__card-btn" aria-label="<?php echo esc_attr($nv_products['details'] . ': ' . $nv_item['link']['label']); ?>">
                                                    <span class="header-btn__text"><?php echo esc_html($nv_products['details']); ?></span>
                                                    <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                                                </a>
                                            </div>
                                            <?php if (!empty($nv_item['links'])) : ?>
                                            <ul class="mega__links">
                                                <?php foreach ($nv_item['links'] as $nv_link) : ?>
                                                <li><a href="<?php echo esc_url($nv_link['url']); ?>" class="mega__link"><?php echo esc_html($nv_link['label']); ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php $nv_promo = $nv_products['promo']; ?>
                                    <div class="mega__col mega__col--promo">
                                        <?php echo $nv_promo['url'] ? '<a href="' . esc_url($nv_promo['url']) . '" class="mega__promo">' : '<div class="mega__promo">'; ?>
                                            <span class="mega__promo-media">
                                                <img src="<?php echo esc_url($nv_img . $nv_promo['image']); ?>" width="1200" height="675" loading="lazy" alt="">
                                                <span class="mega__promo-play"><?php echo nv_header_icon('play'); ?></span>
                                            </span>
                                            <span class="mega__promo-text">
                                                <span class="mega__promo-title"><?php echo esc_html($nv_promo['title']); ?></span>
                                                <span class="mega__promo-desc"><?php echo esc_html($nv_promo['text']); ?></span>
                                            </span>
                                        <?php echo $nv_promo['url'] ? '</a>' : '</div>'; ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="header__item<?php echo esc_attr($nv_cur('industries')); ?>" data-menu="industries">
                            <button type="button" class="header__trigger" id="header-trigger-industries" aria-expanded="false" aria-controls="header-panel-industries" data-trigger="industries">
                                <span class="header__trigger-label"><?php echo esc_html($nv_industries['label']); ?></span>
                                <span class="header__chevron"><?php echo nv_header_icon('angle'); echo nv_header_icon('chev', 'header__icon--m'); ?></span>
                            </button>
                            <div class="header__panel header__panel--industries" id="header-panel-industries" role="region" aria-labelledby="header-trigger-industries" data-panel="industries">
                                <div class="mega mega--industries<?php echo empty($nv_industries['blog']['posts']) ? ' mega--no-aside' : ''; ?>">
                                    <button type="button" class="header__back" data-back>
                                        <?php echo nv_header_icon('arrow-left', 'header__back-icon'); ?>
                                        <span>Back</span>
                                    </button>
                                    <div class="mega__intro">
                                        <div class="mega__intro-text">
                                            <p class="mega__title"><?php echo esc_html($nv_industries['title']); ?></p>
                                            <p class="mega__desc"><?php echo esc_html($nv_industries['text']); ?></p>
                                        </div>
                                        <a href="<?php echo esc_url($nv_industries['cta']['url']); ?>" class="header-btn header-btn--primary header-btn--small mega__intro-btn">
                                            <span class="header-btn__text"><?php echo esc_html($nv_industries['cta']['label']); ?></span>
                                            <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                                        </a>
                                    </div>
                                    <div class="mega__groups">
                                        <?php foreach ($nv_industries['groups'] as $nv_group) : ?>
                                        <div class="mega__group">
                                            <a href="<?php echo esc_url($nv_group['link']['url']); ?>" class="mega__group-title"><?php echo esc_html($nv_group['label']); ?></a>
                                            <?php if (!empty($nv_group['links'])) : ?>
                                            <ul class="mega__links">
                                                <?php foreach ($nv_group['links'] as $nv_link) : ?>
                                                <li><a href="<?php echo esc_url($nv_link['url']); ?>" class="mega__link"><?php echo esc_html($nv_link['label']); ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if (!empty($nv_industries['blog']['posts'])) : ?>
                                    <aside class="mega__aside" aria-label="Blog">
                                        <p class="mega__aside-title"><?php echo esc_html($nv_industries['blog']['title']); ?></p>
                                        <ul class="mega__posts">
                                            <?php foreach ($nv_industries['blog']['posts'] as $nv_post) : ?>
                                            <li>
                                                <a href="<?php echo esc_url($nv_post['url']); ?>" class="mega__post">
                                                    <?php if ($nv_post['thumb']) : ?><img src="<?php echo esc_url($nv_post['thumb']); ?>" class="mega__post-thumb" loading="lazy" alt=""><?php endif; ?>
                                                    <span class="mega__post-text">
                                                        <span class="mega__post-date"><?php echo esc_html($nv_post['ago']); ?></span>
                                                        <span class="mega__post-title"><?php echo esc_html($nv_post['title']); ?></span>
                                                    </span>
                                                </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </aside>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>

                        <li class="header__item<?php echo esc_attr($nv_cur('resources')); ?>" data-menu="resources">
                            <button type="button" class="header__trigger" id="header-trigger-resources" aria-expanded="false" aria-controls="header-panel-resources" data-trigger="resources">
                                <span class="header__trigger-label"><?php echo esc_html($nv_resources['label']); ?></span>
                                <span class="header__chevron"><?php echo nv_header_icon('angle'); echo nv_header_icon('chev', 'header__icon--m'); ?></span>
                            </button>
                            <div class="header__panel header__panel--resources" id="header-panel-resources" role="region" aria-labelledby="header-trigger-resources" data-panel="resources">
                                <div class="mega mega--resources<?php echo empty($nv_resources['latest']) ? ' mega--no-latest' : ''; ?>">
                                    <button type="button" class="header__back" data-back>
                                        <?php echo nv_header_icon('arrow-left', 'header__back-icon'); ?>
                                        <span>Back</span>
                                    </button>
                                    <div class="mega__banner">
                                        <img src="<?php echo esc_url($nv_img . 'header-news-texture.webp'); ?>" class="mega__banner-texture" width="1360" height="906" loading="lazy" alt="">
                                        <p class="mega__banner-title"><span>Neuro</span>News</p>
                                        <p class="mega__banner-text"><?php echo esc_html($nv_resources['banner']['text']); ?></p>
                                        <img src="<?php echo esc_url($nv_img . 'header-news-mascot.webp'); ?>" class="mega__banner-mascot" width="374" height="238" loading="lazy" alt="">
                                    </div>
                                    <div class="mega__nav">
                                        <ul class="mega__nav-list">
                                            <?php foreach ($nv_resources['links'] as $nv_link) : ?>
                                            <li><a href="<?php echo esc_url($nv_link['url']); ?>" class="mega__nav-link"><?php echo esc_html($nv_link['label']); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <ul class="mega__social">
                                            <?php foreach ($nv_resources['social'] as $nv_soc) : ?>
                                            <li><a href="<?php echo esc_url($nv_soc['url']); ?>" class="mega__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr('NeuroVision Global Systems on ' . $nv_soc['label']); ?>"><?php echo nv_header_icon($nv_soc['icon']); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php if (!empty($nv_resources['latest'])) : ?>
                                    <div class="mega__latest">
                                        <p class="mega__latest-title">Latest</p>
                                        <ul class="mega__cards">
                                            <?php foreach ($nv_resources['latest'] as $nv_post) : ?>
                                            <li>
                                                <a href="<?php echo esc_url($nv_post['url']); ?>" class="mega__card-post">
                                                    <?php if ($nv_post['thumb']) : ?><img src="<?php echo esc_url($nv_post['thumb']); ?>" class="mega__card-post-thumb" loading="lazy" alt=""><?php endif; ?>
                                                    <span class="mega__card-post-title"><?php echo esc_html($nv_post['title']); ?></span>
                                                </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>

                        <li class="header__item<?php echo esc_attr($nv_cur('docs')); ?>">
                            <a href="<?php echo esc_url($nv_menu['docs']['url']); ?>" class="header__link"<?php echo $nv_aria('docs'); ?>><?php echo esc_html($nv_menu['docs']['label']); ?></a>
                        </li>

                        <li class="header__item<?php echo esc_attr($nv_cur('pricing')); ?>">
                            <a href="<?php echo esc_url($nv_menu['pricing']['url']); ?>" class="header__link"<?php echo $nv_aria('pricing'); ?>><?php echo esc_html($nv_menu['pricing']['label']); ?></a>
                        </li>
                    </ul>

                    <div class="header__mobile-cta">
                        <button type="button" class="header-btn header-btn--primary header-btn--regular <?php echo esc_attr($nv_menu['cta']['modal']); ?>">
                            <span class="header-btn__text"><?php echo esc_html($nv_menu['cta']['label']); ?></span>
                            <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                        </button>
                        <button type="button" class="header-btn header-btn--secondary header-btn--regular <?php echo esc_attr($nv_menu['cta2']['modal']); ?>">
                            <span class="header-btn__text"><?php echo esc_html($nv_menu['cta2']['label']); ?></span>
                            <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                        </button>
                    </div>
                </nav>

                <div class="header__actions">
                    <?php
                    /*
                     * Переключатель языка — только интерфейс. Мультиязычности в теме нет:
                     * активен английский, остальные пункты не ведут никуда. Один корень
                     * `.header-language` — компонент скрывается одним правилом.
                     */
                    ?>
                    <div class="header-language" data-language>
                        <button type="button" class="header-language__trigger" id="header-language-trigger" aria-expanded="false" aria-controls="header-language-list" aria-label="Language: <?php echo esc_attr($nv_lang_now['label']); ?>">
                            <img src="<?php echo esc_url($nv_img . 'header-flag-' . $nv_lang_now['flag'] . '.svg'); ?>" class="header-language__flag" width="24" height="24" alt="">
                            <?php echo nv_header_icon('chev', 'header-language__chevron'); ?>
                        </button>
                        <div class="header-language__dropdown" id="header-language-list">
                            <ul class="header-language__list">
                                <?php foreach ($nv_langs as $nv_lang) : ?>
                                <li>
                                    <button type="button" class="header-language__option<?php echo !empty($nv_lang['current']) ? ' is-current' : ''; ?>" data-language-code="<?php echo esc_attr($nv_lang['code']); ?>"<?php echo !empty($nv_lang['current']) ? ' aria-current="true"' : ' aria-disabled="true"'; ?>>
                                        <span class="header-language__option-main">
                                            <img src="<?php echo esc_url($nv_img . 'header-flag-' . $nv_lang['flag'] . '.svg'); ?>" class="header-language__option-flag" width="20" height="20" alt="">
                                            <span><?php echo esc_html($nv_lang['label']); ?></span>
                                        </span>
                                        <?php if (!empty($nv_lang['current'])) { echo nv_header_icon('check', 'header-language__check'); } ?>
                                    </button>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <button type="button" class="header-btn header-btn--primary header-btn--small header__cta <?php echo esc_attr($nv_menu['cta']['modal']); ?>">
                        <span class="header-btn__text"><?php echo esc_html($nv_menu['cta']['label']); ?></span>
                        <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                    </button>

                    <button type="button" class="header__burger" aria-label="Open menu" aria-expanded="false" aria-controls="header-nav">
                        <?php echo nv_header_icon('category', 'header__burger-open'); ?>
                        <?php echo nv_header_icon('close', 'header__burger-close'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="header__overlay" data-header-overlay aria-hidden="true"></div>
    </header>

