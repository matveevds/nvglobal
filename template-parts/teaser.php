<?php
/**
 * Тизер над футером. Подключается на всех шаблонах страниц.
 *
 * Светлый макет Figma включён на главной (655:11651 / 2380:23846 / 2376:17671)
 * и на /solutions/ (2456:16730 / 652:10946 / 2457:17441 / 2467:18125);
 * остальные страницы остаются на тёмной теме. Разметка общая, различается только
 * файл логотипа: тёмная тема — персиковый `teaser_logo.svg`, светлая — оранжевый
 * `teaser_logo_primary.svg` (#FD6B01 из макета). Всё остальное — в `css/styles.css`
 * под `body.home` и `body.page-template-page-solutions`.
 */

$nv_teaser_logo = nv_is_light_theme() ? 'teaser_logo_primary.svg' : 'teaser_logo.svg';
?>
<section class="teaser section">
    <div class="container">
        <div class="teaser__wrapper">
            <div class="teaser__logo">
                <div class="teaser__logo-image">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $nv_teaser_logo); ?>" alt="NeuroVision Global Systems">
                </div>
            </div>
            <div class="teaser__info">
                <h2 class="teaser__title">All-in-One Face Recognition Platform <br>for Instant KYC Verification</h2>
                <p class="teaser__subtitle">Streamline onboarding, prevent fraud, and ensure KYC/AML compliance</p>
            </div>
        </div>
    </div>
</section>
