<?php
/**
 * Футер главной страницы — светлый макет Figma.
 *
 * Desktop 1440 — `655:11651`, Full HD 1920 — `2380:23846`, Tablet 840 — `2376:17671`,
 * ховеры — `2386:37529`.
 *
 * Отдельный шаблон, а не правка `footer.php`: футер — глобальный компонент, и на
 * остальных страницах темы должна остаться прежняя тёмная разметка без изменений.
 * Классы — существующие `footer__*`, новые элементы добавлены по БЭМ. Все стили
 * светлой версии в `css/styles.css` живут под `body.home .footer`.
 *
 * Ссылки: только реальные адреса. Пункты макета, для которых в теме нет страницы
 * или якоря (Blog, пер-продуктовые ссылки, Telegram), не выводятся —
 * см. `docs/BACKLOG.md`, R-22…R-24.
 */

$nv_footer_uri = get_template_directory_uri();

// Шесть продуктов из макета. Отдельных страниц под них нет — ведём в секцию
// Products главной (вкладки `products-tab-1…6` соответствуют этим названиям).
$nv_footer_products_url = home_url('/#products');
$nv_footer_products     = ['KYC', 'KYB', 'AML', 'KYT', 'Liveness', 'NeuroPay'];

// Resources. Blog появится, когда в «Настройки → Чтение» будет назначена
// страница записей (`page_for_posts`) — см. BACKLOG R-17.
$nv_footer_resources = [
    ['label' => 'Documentation', 'url' => home_url('/docs/')],
    ['label' => 'Pricing',       'url' => home_url('/pricing-matrix/')],
];

$nv_footer_blog_id = (int) get_option('page_for_posts');

if ($nv_footer_blog_id > 0) {
    $nv_footer_resources[] = ['label' => 'Blog', 'url' => get_permalink($nv_footer_blog_id)];
}

$nv_footer_company = [
    ['label' => 'About us', 'url' => home_url('/#about')],
    ['label' => 'Contacts', 'url' => home_url('/#contacts')],
];

// Сертификаты из макета. Ширина 1x указана явно — пропорции у значков разные.
$nv_footer_badges = [
    [
        'file'  => 'footer-badge-iso',
        'width' => 64,
        'alt'   => 'ISO Register Global',
    ],
    [
        'file'  => 'footer-badge-asib',
        'width' => 50,
        'alt'   => 'ASIB Accreditation International',
    ],
    [
        'file'  => 'footer-badge-qa',
        'width' => 67,
        'alt'   => 'QA Compliance Assessment',
        'round' => true,
    ],
];
?>
<footer class="footer">
    <div class="container">
        <div class="footer__wrapper">

            <div class="footer__top">

                <div class="footer__info">

                    <div class="footer__brand">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo-image">
                            <img src="<?php echo esc_url($nv_footer_uri . '/img/footer_logo_light.svg'); ?>" width="302" height="59" alt="NeuroVision Global Systems">
                        </a>
                        <p class="footer__tagline">Confidence in every client</p>
                    </div>

                    <div class="footer__details">

                        <div class="footer__legal">
                            <p class="footer__legal-name">NEUROVISION GLOBAL INTELLIGENCE - FZCO</p>
                            <p class="footer__legal-address">IFZA Business Park, DDP, PO Box 342001, Dubai, UAE<br>Reg. 72252 · License 74254</p>
                        </div>

                        <div class="footer__badges">
                            <?php foreach ($nv_footer_badges as $nv_badge) : ?>
                                <span class="footer__badge<?php echo empty($nv_badge['round']) ? '' : ' footer__badge--round'; ?>">
                                    <img src="<?php echo esc_url($nv_footer_uri . '/img/' . $nv_badge['file'] . '.webp'); ?>"
                                         srcset="<?php echo esc_url($nv_footer_uri . '/img/' . $nv_badge['file'] . '.webp'); ?> 1x, <?php echo esc_url($nv_footer_uri . '/img/' . $nv_badge['file'] . '@2x.webp'); ?> 2x"
                                         width="<?php echo esc_attr($nv_badge['width']); ?>" height="64"
                                         alt="<?php echo esc_attr($nv_badge['alt']); ?>"
                                         loading="lazy" decoding="async">
                                </span>
                            <?php endforeach; ?>
                        </div>

                    </div>

                </div>

                <div class="footer__navigation">

                    <div class="footer__nav footer__nav--products">
                        <div class="footer__nav-title">PRODUCTS</div>
                        <div class="footer__nav-list">
                            <?php foreach ($nv_footer_products as $nv_product) : ?>
                                <a href="<?php echo esc_url($nv_footer_products_url); ?>" class="footer__nav-link"><?php echo esc_html($nv_product); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="footer__nav">
                        <div class="footer__nav-title">RESOURCES</div>
                        <div class="footer__nav-list">
                            <?php foreach ($nv_footer_resources as $nv_item) : ?>
                                <a href="<?php echo esc_url($nv_item['url']); ?>" class="footer__nav-link"><?php echo esc_html($nv_item['label']); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="footer__nav">
                        <div class="footer__nav-title">COMPANY</div>
                        <div class="footer__nav-list">
                            <?php foreach ($nv_footer_company as $nv_item) : ?>
                                <a href="<?php echo esc_url($nv_item['url']); ?>" class="footer__nav-link"><?php echo esc_html($nv_item['label']); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

                <div class="footer__aside">

                    <div class="footer__contacts">
                        <div class="footer__contacts-title">CONTACTS</div>
                        <div class="footer__contacts-list">
                            <a href="mailto:hello@nv.global" class="footer__mail">
                                <span class="footer__mail-text">hello@nv.global</span>
                                <span class="footer__mail-icon">
                                    <svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.8659 4.45481C11.0297 4.15096 11.4092 4.03713 11.7131 4.2009H11.7139L11.7147 4.20172C11.7155 4.20215 11.7166 4.20263 11.7179 4.20334C11.7208 4.20492 11.7249 4.20783 11.7301 4.21067C11.7407 4.21643 11.7563 4.22433 11.7757 4.23508C11.8149 4.2568 11.8719 4.28863 11.9434 4.32948C12.0862 4.41115 12.289 4.53009 12.5317 4.67942C13.0161 4.97735 13.6657 5.40122 14.318 5.90175C14.9667 6.39944 15.6384 6.98869 16.154 7.61969C16.6575 8.23595 17.0833 8.97818 17.0833 9.77056L17.0785 9.91786C17.03 10.655 16.627 11.3441 16.1548 11.9223C15.6392 12.5536 14.9667 13.1423 14.318 13.6402C13.6656 14.141 13.0161 14.5653 12.5317 14.8633C12.289 15.0127 12.0862 15.1316 11.9434 15.2133C11.8719 15.2541 11.8149 15.286 11.7757 15.3077C11.7566 15.3183 11.7415 15.3263 11.731 15.3321C11.7257 15.335 11.7209 15.3378 11.7179 15.3394C11.7166 15.3401 11.7155 15.3406 11.7147 15.341L11.7139 15.3419H11.7131C11.4092 15.5057 11.0297 15.3925 10.8659 15.0888C10.7021 14.7849 10.816 14.4054 11.1198 14.2416C11.1201 14.2414 11.1213 14.2413 11.1222 14.2408C11.1241 14.2398 11.1271 14.2381 11.1312 14.2359C11.1397 14.2313 11.1529 14.2235 11.1702 14.2139C11.2049 14.1947 11.2563 14.1655 11.3224 14.1277C11.4553 14.0517 11.6468 13.9403 11.8766 13.7989C12.3375 13.5153 12.9484 13.1156 13.5563 12.649C14.168 12.1794 14.7567 11.6573 15.1864 11.1312C15.4026 10.8664 15.5616 10.6204 15.6681 10.3964H3.95833C3.61316 10.3964 3.33333 10.1166 3.33333 9.77138C3.33335 9.42622 3.61317 9.14638 3.95833 9.14638H15.6689C15.5625 8.9222 15.4031 8.676 15.1864 8.4107C14.7567 7.88493 14.1688 7.36229 13.5571 6.89296C12.9491 6.42647 12.3376 6.0274 11.8766 5.74387C11.647 5.60263 11.4561 5.49102 11.3232 5.4151C11.257 5.3772 11.2049 5.34805 11.1702 5.32883C11.153 5.31927 11.1397 5.3123 11.1312 5.30767C11.127 5.30538 11.1241 5.30301 11.1222 5.30198C11.1213 5.30146 11.1201 5.30135 11.1198 5.30116C10.8161 5.13743 10.7024 4.75857 10.8659 4.45481Z" fill="currentColor"/></svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="footer__social">
                        <div class="footer__social-title">SOCIAL</div>
                        <div class="footer__social-list">
                            <a href="https://www.linkedin.com/company/nvglobal-ai/posts/" class="footer__social-item" aria-label="NeuroVision Global Systems on LinkedIn" target="_blank" rel="noopener noreferrer">
                                <svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.976 15.7988C16.976 16.2128 16.64 16.5488 16.226 16.5488C15.812 16.5488 15.476 16.2128 15.476 15.7988V12.3888C15.476 11.3848 14.662 10.5688 13.661 10.5688C12.66 10.5688 11.846 11.3848 11.846 12.3888V15.7988C11.846 16.2128 11.51 16.5488 11.096 16.5488C10.682 16.5488 10.346 16.2128 10.346 15.7988V12.3888C10.346 10.5578 11.833 9.06879 13.661 9.06879C15.489 9.06879 16.976 10.5578 16.976 12.3888V15.7988ZM7.775 10.0088C7.361 10.0088 6.989 9.63279 6.989 9.21879C6.989 8.80479 7.361 8.42879 7.775 8.42879C8.189 8.42879 8.559 8.80479 8.559 9.21879C8.559 9.63279 8.189 10.0088 7.775 10.0088ZM8.524 15.7988C8.524 16.2128 8.188 16.5488 7.774 16.5488C7.36 16.5488 7.024 16.2128 7.024 15.7988V12.0278C7.024 11.6138 7.36 11.2778 7.774 11.2778C8.188 11.2778 8.524 11.6138 8.524 12.0278V15.7988ZM16.217 3.00879H7.783C4.623 3.00879 2.5 5.23179 2.5 8.53879V16.4788C2.5 19.7858 4.623 22.0088 7.783 22.0088H16.216C19.376 22.0088 21.5 19.7858 21.5 16.4788V8.53879C21.5 5.23179 19.377 3.00879 16.217 3.00879Z" fill="currentColor"/></svg>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <div class="footer__line"></div>

            <div class="footer__bottom">
                <div class="footer__bottom-col footer__bottom-col--copy">
                    <p>© <?php echo esc_html(date_i18n('Y')); ?>. All rights reserved</p>
                </div>
                <div class="footer__bottom-col footer__bottom-col--trademark">
                    <p>The logo and trademark NeuroVision Global Systems® are registered trademarks of NEUROVISION GLOBAL INTELLIGENCE - FZCO</p>
                </div>
                <div class="footer__bottom-col footer__bottom-col--links">
                    <div class="footer__bottom-list">
                        <a href="<?php echo esc_url(home_url('/terms-of-use/')); ?>" class="footer__bottom-link">Terms of Use</a>
                        <div class="footer__bottom-line"></div>
                        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="footer__bottom-link">Privacy Policy</a>
                        <div class="footer__bottom-line"></div>
                        <a href="<?php echo esc_url(home_url('/information-security-policy/')); ?>" class="footer__bottom-link">Information Security Policy Statement</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
