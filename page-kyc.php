<?php
/*
Template Name: KYC
Template Post Type: page
*/
get_header();

/*
 * Страница KYC (/kyc/). Figma ISDh0vGDZPe3CsGvR4ZaIn: Full HD 2561:30912, Desktop 2492:14440,
 * Mobile 2558:28451 (392). Макета Tablet нет: узел 2553:24034, названный в задании Tablet, — это
 * блок FAQ с раскрытыми ответами шириной 1440 (docs/DECISIONS.md, запись по KYC).
 *
 * Переиспользовано без копирования: первый экран `.main--solutions` (модификатор `.main--kyc`),
 * аккордеон `.solutions-why` (модификатор `--kyc`), секции Integration / Contacts / FAQ
 * (template-parts/*-section.php, общие со /solutions/), панель `.solutions-products__panel`,
 * тизер и футер. Новое — только `.kyc-*` и один контроллер initKycPage() в js/main.js.
 * Данные — inc/kyc-data.php; тексты дословно из Figma.
 */
require_once get_template_directory() . '/inc/kyc-icons.php';
require_once get_template_directory() . '/template-parts/contacts-icons.php';
$nv_kyc  = require get_template_directory() . '/inc/kyc-data.php';
$nv_img  = get_template_directory_uri() . '/img/';
$nv_arrow = nv_contacts_icon('arrow', 24);

/* Картинка 1x/2x с готовыми размерами. */
$nv_kyc_img = static function (string $name, int $w, int $h, string $class = '', string $alt = '', bool $lazy = true) use ($nv_img): string {
    return '<img' . ($class ? ' class="' . esc_attr($class) . '"' : '')
        . ' src="' . esc_url($nv_img . $name . '.webp') . '"'
        . ' srcset="' . esc_url($nv_img . $name . '.webp') . ' 1x, ' . esc_url($nv_img . $name . '@2x.webp') . ' 2x"'
        . ' width="' . $w . '" height="' . $h . '" alt="' . esc_attr($alt) . '"'
        . ($alt === '' ? ' aria-hidden="true"' : '') . ($lazy ? ' loading="lazy"' : '') . ' decoding="async">';
};
?>

<main>

    <?php /* 1. Первый экран: 2561:30924 (FHD 1856x872), 2492:14452 (Desktop 1376x732), 2560:30238 (Mobile). */ ?>
    <section class="main main--solutions main--kyc">
        <div class="container">
            <div class="main__card">
                <picture class="main__media">
                    <source media="(min-width: 1600px)"
                            srcset="<?php echo esc_url($nv_img . 'kyc-hero-fhd.webp'); ?> 1x, <?php echo esc_url($nv_img . 'kyc-hero-fhd@2x.webp'); ?> 2x"
                            width="1856" height="872">
                    <source media="(min-width: 992px)"
                            srcset="<?php echo esc_url($nv_img . 'kyc-hero-desktop.webp'); ?> 1x, <?php echo esc_url($nv_img . 'kyc-hero-desktop@2x.webp'); ?> 2x"
                            width="1376" height="732">
                    <source media="(min-width: 768px)"
                            srcset="<?php echo esc_url($nv_img . 'kyc-hero-tablet.webp'); ?> 1x, <?php echo esc_url($nv_img . 'kyc-hero-tablet@2x.webp'); ?> 2x"
                            width="776" height="872">
                    <img src="<?php echo esc_url($nv_img . 'kyc-hero-mobile.webp'); ?>"
                         srcset="<?php echo esc_url($nv_img . 'kyc-hero-mobile.webp'); ?> 1x, <?php echo esc_url($nv_img . 'kyc-hero-mobile@2x.webp'); ?> 2x"
                         width="360" height="144" alt="" aria-hidden="true" fetchpriority="high" decoding="async">
                </picture>

                <div class="main__body">
                    <img class="main__logo" src="<?php echo esc_url($nv_img . 'logo-hero.svg'); ?>" width="206" height="39" alt="NeuroVision Global Systems">

                    <div class="main__group">
                        <div class="main__content">
                            <h1 class="main__title">Automated KYC and eKYC Verification for Fast, Compliant Onboarding</h1>
                            <p class="main__subtitle">One KYC solution for the whole process: ID document checks, selfie face match, liveness detection, AML screening and risk scoring — with an audit trail for every customer. Run KYC verification worldwide and eKYC under the rules of Singapore, Malaysia, Indonesia and the Philippines.</p>
                        </div>
                        <div class="main__actions">
                            <button class="main__btn main__btn--primary open-callForm2" type="button">
                                <span class="main__btn-text">Start Free Pilot</span>
                                <span class="main__btn-icon"><?php echo $nv_arrow; ?></span>
                            </button>
                            <a class="main__btn main__btn--ghost" href="#how-it-works">
                                <span class="main__btn-text">See How It Works</span>
                                <span class="main__btn-icon"><?php echo $nv_arrow; ?></span>
                            </a>
                        </div>
                    </div>
                </div>

                <ul class="main__facts">
                    <li class="main__fact">
                        <span class="main__fact-icon" aria-hidden="true"><?php echo nv_kyc_icon('globe'); ?></span>
                        <span class="main__fact-title">99.74% face match accuracy&nbsp;(NIST)</span>
                    </li>
                    <li class="main__fact">
                        <span class="main__fact-icon" aria-hidden="true"><?php echo nv_kyc_icon('shield'); ?></span>
                        <span class="main__fact-title">0.1&nbsp;s per face match</span>
                    </li>
                    <li class="main__fact">
                        <span class="main__fact-icon" aria-hidden="true"><?php echo nv_kyc_icon('scan'); ?></span>
                        <span class="main__fact-title">195+ countries and&nbsp;territories</span>
                    </li>
                    <li class="main__fact">
                        <span class="main__fact-icon" aria-hidden="true"><?php echo nv_kyc_icon('document'); ?></span>
                        <span class="main__fact-title">From $0.25 per KYC&nbsp;check</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <?php /* 2. Сертификации: 2495:24360. */ ?>
    <section class="kyc-certs" aria-labelledby="kyc-certs-title">
        <div class="container">
            <p class="kyc-certs__title" id="kyc-certs-title">Independently tested and certified</p>
            <ul class="kyc-certs__list">
                <?php foreach (array('NIST FRVT', 'ISO/IEC 27001:2022', 'GDPR', 'FATF-aligned AML') as $nv_cert) : ?>
                <li class="kyc-certs__chip"><?php echo nv_kyc_icon('check', 20); ?><span><?php echo esc_html($nv_cert); ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php
    /*
     * 3. The Complete KYC Process on One Platform: 2492:14472, состояния 2556:27399 / 27443 / 27487 / 27531.
     * Тот же аккордеон, что «Why Leading Companies Choose…» на /solutions/: initSolutionsWhy() без изменений,
     * с 992px раскрыта одна карточка из пяти, ниже — статичный список. Фото одно на все состояния.
     * Цвет карточки задаёт её номер (модификатор `--kyc`).
     */
    ?>
    <section class="section solutions-why solutions-why--kyc" id="process">
        <div class="container">
            <div class="solutions-why__head">
                <div class="section__badge">Process</div>
                <div class="solutions-why__head-text">
                    <h2 class="section__title solutions-why__title">The Complete KYC Process on One Platform</h2>
                    <p class="solutions-why__lead">Regulators expect you to know who your customer is, check them against watchlists, understand their risk and keep watching after onboarding. Most companies buy a separate tool for each step. NeuroVision runs the whole KYC process on one platform, from the first selfie to the next review.</p>
                </div>
            </div>

            <div class="solutions-why__board" data-solutions-why>
                <div class="solutions-why__cards" role="group" aria-label="The complete KYC process">
                    <?php foreach ($nv_kyc['process'] as $nv_i => $nv_card) :
                        $nv_open = (0 === $nv_i);
                        ?>
                        <div class="solutions-why__card solutions-why__card--level-<?php echo (int) ($nv_i + 1); ?><?php echo $nv_open ? ' is-open' : ''; ?>" data-why-card>
                            <div class="solutions-why__card-body">
                                <h3 class="solutions-why__card-heading">
                                    <button type="button"
                                            class="solutions-why__card-button"
                                            id="kyc-process-button-<?php echo esc_attr($nv_card['number']); ?>"
                                            aria-expanded="<?php echo $nv_open ? 'true' : 'false'; ?>"
                                            aria-controls="kyc-process-panel-<?php echo esc_attr($nv_card['number']); ?>"><?php echo esc_html($nv_card['title']); ?></button>
                                </h3>
                                <p class="solutions-why__card-text" id="kyc-process-panel-<?php echo esc_attr($nv_card['number']); ?>"><?php echo esc_html($nv_card['text']); ?></p>
                            </div>
                            <span class="solutions-why__card-number" aria-hidden="true"><?php echo esc_html($nv_card['number']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <picture class="solutions-why__media">
                    <img src="<?php echo esc_url($nv_img . 'kyc-process.webp'); ?>"
                         srcset="<?php echo esc_url($nv_img . 'kyc-process.webp'); ?> 1000w, <?php echo esc_url($nv_img . 'kyc-process@2x.webp'); ?> 1856w"
                         sizes="(min-width: 992px) 508px, 360px"
                         width="1000" height="1241" alt="" aria-hidden="true" loading="lazy" decoding="async">
                </picture>

                <div class="solutions-why__nav">
                    <button type="button" class="solutions-why__arrow solutions-why__arrow--prev" aria-label="Previous benefit" disabled><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M10.0137 5.5564C10.3648 5.41076 10.7767 5.5525 10.9609 5.89429C11.1571 6.25879 11.0206 6.71344 10.6562 6.90992C10.6558 6.91015 10.6545 6.91027 10.6533 6.91089C10.651 6.91214 10.6476 6.915 10.6426 6.91773C10.6324 6.92329 10.6164 6.93167 10.5957 6.94312C10.5541 6.96616 10.4925 7.00125 10.4131 7.04664C10.2537 7.13778 10.0238 7.27147 9.74805 7.44117C9.19501 7.78146 8.46189 8.26114 7.73242 8.82105C6.99842 9.38447 6.29193 10.0111 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5895 5.77637 13.908C6.29187 14.5388 6.99755 15.1652 7.73145 15.7283C8.46104 16.2881 9.19491 16.767 9.74805 17.1072C10.0236 17.2767 10.2527 17.4106 10.4121 17.5017C10.4916 17.5472 10.5541 17.5822 10.5957 17.6052C10.6165 17.6168 10.6324 17.626 10.6426 17.6316C10.6475 17.6343 10.6511 17.6362 10.6533 17.6375L10.6562 17.6384L10.7217 17.6785C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9578C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.954 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9307 9.86914 18.9177C9.82212 18.8917 9.75372 18.8535 9.66797 18.8044C9.49654 18.7065 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.3371 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2729 3.50097 12.2716 3.50098 12.2703C3.50295 11.3213 4.01126 10.4325 4.61426 9.6941C5.23299 8.93647 6.03997 8.22911 6.81836 7.6316C7.60128 7.03062 8.38067 6.52147 8.96191 6.16382C9.25325 5.98456 9.49653 5.84193 9.66797 5.7439C9.75368 5.69489 9.82214 5.65766 9.86914 5.6316C9.89234 5.61874 9.91016 5.60826 9.92285 5.60132C9.92922 5.59784 9.93494 5.59445 9.93848 5.59253C9.94003 5.59169 9.94143 5.59109 9.94238 5.59058L9.94336 5.5896H9.94434L10.0137 5.5564Z" fill="currentColor"/></svg></button>
                    <button type="button" class="solutions-why__arrow solutions-why__arrow--next" aria-label="Next benefit"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></button>
                </div>
            </div>
        </div>
    </section>

    <?php
    /*
     * 4. How KYC Verification Works: 2495:24452, шаги 2553:23453 / 23505 / 23557 (FHD 2561:31154 — четыре карточки в ряд).
     * Один список карточек; кнопки «Step N» сдвигают окно списка (с 992px — по вертикали, ниже — лента со свайпом).
     */
    ?>
    <section class="kyc-steps" id="how-it-works" data-kyc-steps>
        <div class="solutions-products__panel kyc-panel">
            <div class="container">
                <div class="kyc-steps__grid">
                    <div class="kyc-steps__left">
                        <div class="section__badge">How it works</div>
                        <div class="kyc-steps__text">
                            <div class="kyc-steps__head">
                                <h2 class="kyc-steps__title">How KYC Verification Works</h2>
                                <p class="kyc-steps__lead">An automated decision in seconds, a documented record for your compliance team.</p>
                            </div>
                            <p class="kyc-steps__note">Every check in under a second — auto-approve, decline or route to manual review, by your scenario.</p>
                            <div class="kyc-steps__nav" role="group" aria-label="KYC verification steps">
                                <?php foreach ($nv_kyc['steps'] as $nv_i => $nv_step) : ?>
                                <button type="button" class="kyc-steps__btn<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>" data-step="<?php echo (int) $nv_i; ?>" aria-pressed="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="kyc-step-<?php echo (int) $nv_i; ?>">
                                    <span class="kyc-steps__btn-text">Step <?php echo (int) ($nv_i + 1); ?></span>
                                    <span class="kyc-steps__btn-icon"><?php echo $nv_arrow; ?></span>
                                </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="kyc-steps__right">
                        <div class="kyc-steps__viewport" data-steps-viewport>
                            <ol class="kyc-steps__list" data-steps-list>
                                <?php foreach ($nv_kyc['steps'] as $nv_i => $nv_step) : ?>
                                <li class="kyc-steps__card" id="kyc-step-<?php echo (int) $nv_i; ?>" data-step-card>
                                    <span class="kyc-steps__chip">Step <?php echo (int) ($nv_i + 1); ?></span>
                                    <?php echo $nv_kyc_img($nv_step['img'], $nv_step['w'], $nv_step['w'], 'kyc-steps__image', '', false); ?>
                                    <div class="kyc-steps__card-text">
                                        <h3 class="kyc-steps__card-title"><?php echo esc_html($nv_step['title']); ?></h3>
                                        <p class="kyc-steps__card-desc"><?php echo esc_html($nv_step['text']); ?></p>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    /*
     * 5. Risk-Based KYC: 2492:14501, вкладки 2502:24747 / 2539:20397 (FHD 2561:31026 / 37195 / 37270).
     * В Figma 2502:24747 подсвечена третья кнопка при содержимом CDD — ошибка макета: активна вторая (CDD).
     */
    $nv_risk_states = array();
    foreach ($nv_kyc['risk'] as $nv_r) {
        $nv_risk_states[] = array('title' => $nv_r['title'], 'text' => $nv_r['text'], 'when' => $nv_r['when'], 'checks' => $nv_r['checks']);
    }
    $nv_risk0 = $nv_kyc['risk'][0];
    ?>
    <section class="kyc-section kyc-risk" data-kyc-risk data-kyc-states="<?php echo esc_attr(wp_json_encode($nv_risk_states)); ?>">
        <div class="container">
            <div class="section__badge">Due diligence</div>
            <div class="kyc-risk__row">
                <div class="kyc-risk__left">
                    <div class="kyc-risk__text">
                        <h2 class="kyc-title">Risk-Based KYC: Simplified, Standard and Enhanced Due Diligence</h2>
                        <p class="kyc-lead">FATF and most national regulators require a risk-based approach: light checks for low-risk customers, deeper checks where the risk is higher. Set the rules once, and every customer gets the right level of KYC automatically.</p>
                    </div>
                    <div class="kyc-risk__tabs" role="tablist" aria-label="Due diligence level" aria-orientation="vertical">
                        <?php foreach ($nv_kyc['risk'] as $nv_i => $nv_r) : ?>
                        <button type="button" role="tab" class="kyc-risk__tab<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"
                                id="kyc-risk-tab-<?php echo (int) $nv_i; ?>" data-index="<?php echo (int) $nv_i; ?>"
                                aria-selected="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="kyc-risk-panel"
                                tabindex="<?php echo (0 === $nv_i) ? '0' : '-1'; ?>">
                            <span class="kyc-risk__tab-text"><?php echo esc_html($nv_r['button']); ?></span>
                            <span class="kyc-risk__tab-icon"><?php echo $nv_arrow; ?></span>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="kyc-risk__right">
                    <div class="kyc-risk__main" id="kyc-risk-panel" role="tabpanel" aria-labelledby="kyc-risk-tab-0" aria-live="polite">
                        <h3 class="kyc-risk__title" data-slot="title"><?php echo esc_html($nv_risk0['title']); ?></h3>
                        <div class="kyc-risk__inner">
                            <div class="kyc-risk__summary">
                                <span class="kyc-icon-box" aria-hidden="true"><?php echo nv_kyc_icon('temple'); ?></span>
                                <p class="kyc-risk__summary-text" data-slot="text"><?php echo esc_html($nv_risk0['text']); ?></p>
                            </div>
                            <div class="kyc-risk__details">
                                <div class="kyc-risk__row-item">
                                    <span class="kyc-risk__label">When</span>
                                    <span class="kyc-risk__when" data-slot="when"><?php echo esc_html($nv_risk0['when']); ?></span>
                                </div>
                                <div class="kyc-risk__row-item kyc-risk__row-item--checks">
                                    <span class="kyc-risk__label">Checks</span>
                                    <ul class="kyc-risk__checks" data-slot="checks">
                                        <?php foreach ($nv_risk0['checks'] as $nv_c) : ?>
                                        <li class="kyc-token"><?php echo esc_html($nv_c); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kyc-card kyc-risk__side">
                        <div class="kyc-risk__side-text">
                            <h3 class="kyc-card__title">Re-verification and KYC refresh</h3>
                            <p class="kyc-card__text">Ask customers to verify again when their ID expires, their details change or their risk level goes up — without a new onboarding flow.</p>
                        </div>
                        <?php echo $nv_kyc_img('kyc-risk-refresh', 245, 233, 'kyc-risk__side-image'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* 6. Case management и платформа: 2502:24611. */ ?>
    <section class="kyc-section kyc-platform">
        <div class="container">
            <div class="section__badge">Platform</div>
            <h2 class="kyc-title">A KYC Platform Your Compliance Team Will Actually Use</h2>
            <div class="kyc-platform__grid">
                <div class="kyc-platform__col">
                    <div class="kyc-card kyc-card--filled kyc-platform__case">
                        <div class="kyc-platform__case-text">
                            <h3 class="kyc-card__title kyc-card__title--lg">Case management and manual review</h3>
                            <p class="kyc-card__text kyc-card__text--md">Flagged customers land in a review queue with everything side by side: document, selfie, liveness frames, extracted data and screening hits.</p>
                        </div>
                        <div class="kyc-platform__note">
                            <span class="kyc-icon-box" aria-hidden="true"><?php echo nv_kyc_icon('user'); ?></span>
                            <p class="kyc-platform__note-text">Your analyst approves or declines in one click and leaves a comment.</p>
                        </div>
                    </div>
                    <div class="kyc-platform__row">
                        <div class="kyc-card kyc-platform__audit">
                            <h3 class="kyc-card__title kyc-card__title--lg">Audit trail for every decision</h3>
                            <p class="kyc-card__text kyc-card__text--md">Every KYC session is logged with timestamps, check results, risk level and reviewer actions, so you can show a regulator why each customer was accepted.</p>
                            <?php echo $nv_kyc_img('kyc-step-4', 255, 255, 'kyc-platform__audit-image'); ?>
                        </div>
                        <div class="kyc-platform__pair">
                            <div class="kyc-card kyc-card--filled">
                                <h3 class="kyc-card__title">Roles and access rights</h3>
                                <p class="kyc-card__text kyc-card__text--md">Give analysts, managers and auditors different permissions, and limit who can see personal data.</p>
                            </div>
                            <div class="kyc-card kyc-card--filled">
                                <h3 class="kyc-card__title">Reports and statistics</h3>
                                <p class="kyc-card__text kyc-card__text--md">Track pass rates, review times, decline reasons and volumes by country in the KYC dashboard, and export reports for audits.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kyc-platform__screen">
                    <picture>
                        <source media="(min-width: 1600px)"
                                srcset="<?php echo esc_url($nv_img . 'kyc-platform-laptop-fhd.webp'); ?> 1x, <?php echo esc_url($nv_img . 'kyc-platform-laptop-fhd@2x.webp'); ?> 2x"
                                width="555" height="431">
                        <?php echo $nv_kyc_img('kyc-platform-laptop', 400, 489, 'kyc-platform__laptop'); ?>
                    </picture>
                </div>
            </div>
        </div>
    </section>

    <?php
    /*
     * 7. KYC Compliance: 2504:24910, страны 2513:31315 / 31448 / 31544 / 31640.
     * По умолчанию выбран глобус (FATF). Маркеры — настоящие кнопки: наведение и фокус показывают страну,
     * клик/касание фиксирует выбор. Позиции маркеров — доли области карты 738x630 (центр-привязка Figma).
     */
    $nv_markers = array(
        'us'    => array(13.0, 22.5),
        'uk'    => array(48.2, 17.9),
        'eu'    => array(58.0, 23.3),
        'ae'    => array(76.4, 40.3),
        'world' => array(92.8, 88.4),
    );
    $nv_comp_states = array();
    foreach ($nv_kyc['compliance'] as $nv_c) {
        $nv_comp_states[$nv_c['id']] = array('title' => $nv_c['title'], 'text' => $nv_c['text']);
    }
    $nv_comp0 = $nv_kyc['compliance'][0];
    ?>
    <section class="kyc-section kyc-compliance" data-kyc-compliance data-kyc-states="<?php echo esc_attr(wp_json_encode($nv_comp_states)); ?>">
        <div class="container">
            <div class="section__badge">Compliance</div>
            <div class="kyc-compliance__stage">
                <div class="kyc-compliance__head">
                    <h2 class="kyc-title">KYC Compliance Worldwide: FATF, US, EU, UK and UAE</h2>
                    <p class="kyc-subtitle">Our KYC software gives you the checks and records these rules ask for. Your compliance program decides how to use them.</p>
                </div>
                <div class="kyc-compliance__row">
                    <div class="kyc-compliance__info">
                        <div class="kyc-card kyc-card--filled kyc-compliance__card" aria-live="polite">
                            <h3 class="kyc-card__title" data-slot="title"><?php echo esc_html($nv_comp0['title']); ?></h3>
                            <p class="kyc-card__text kyc-card__text--md" data-slot="text"><?php echo esc_html($nv_comp0['text']); ?></p>
                        </div>
                    </div>
                    <div class="kyc-compliance__map-card">
                        <div class="kyc-compliance__map" data-map-area>
                            <img class="kyc-compliance__world" src="<?php echo esc_url($nv_img . 'kyc-map-world.svg'); ?>" width="630" height="630" alt="" aria-hidden="true" loading="lazy" decoding="async">
                            <?php foreach ($nv_kyc['compliance'] as $nv_i => $nv_c) :
                                $nv_pos = $nv_markers[$nv_c['id']];
                                $nv_on  = (0 === $nv_i);
                                ?>
                            <button type="button" class="kyc-marker kyc-marker--<?php echo esc_attr($nv_c['id']); ?><?php echo $nv_on ? ' is-active' : ''; ?>"
                                    data-country="<?php echo esc_attr($nv_c['id']); ?>"
                                    aria-pressed="<?php echo $nv_on ? 'true' : 'false'; ?>"
                                    aria-label="<?php echo esc_attr('world' === $nv_c['id'] ? 'FATF recommendations (global)' : $nv_c['label']); ?>"
                                    style="left: <?php echo esc_attr($nv_pos[0]); ?>%; top: <?php echo esc_attr($nv_pos[1]); ?>%;">
                                <?php if ('world' !== $nv_c['id']) : ?>
                                <img class="kyc-marker__pin" src="<?php echo esc_url($nv_img . 'kyc-marker.svg'); ?>" width="68" height="83" alt="" aria-hidden="true">
                                <img class="kyc-marker__pin kyc-marker__pin--on" src="<?php echo esc_url($nv_img . 'kyc-marker-active.svg'); ?>" width="68" height="83" alt="" aria-hidden="true">
                                <?php else : ?>
                                <span class="kyc-marker__plate" aria-hidden="true"></span>
                                <?php endif; ?>
                                <span class="kyc-marker__face"><img src="<?php echo esc_url($nv_img . 'kyc-flag-' . $nv_c['flag'] . '.svg'); ?>" width="44" height="44" alt="" aria-hidden="true"></span>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    /*
     * 8. eKYC in Southeast Asia: 2492:14522, страны 2538:15792 / 16413 / 17034 / 17655 / 18276.
     * Одна карта из слоёв-стран (позиции — Figma, в долях), активной стране подставляется оранжевый слой;
     * увеличительный круг с выносками есть только у Сингапура (стартовое состояние).
     */
    $nv_sea_layers = array(
        array('thailand',     array(23.55, 67.42, 41.21, 16.29), 'th'),
        array('indonesia',    array(58.58, 7.84, 4.79, 12.65),   'id'),
        array('laos',         array(18.66, 63.69, 60.98, 21.79), ''),
        array('cambodia',     array(37.16, 63.55, 52.77, 26.09), ''),
        array('vietnam',      array(16.76, 60.12, 48.42, 25.71), 'vn'),
        array('group-a',      array(18.87, 63.63, 62.66, 25.66), ''),
        array('myanmar',      array(3.86, 76.07, 51.47, 6.09),   ''),
        array('philippines',  array(21.04, 25.82, 39.19, 54.38), 'ph'),
        array('dili',         array(89.82, 26.99, 8.03, 69.24),  ''),
        array('singapore',    array(68.04, 70.6, 31.48, 28.62),  'sg'),
        array('malaysia',     array(54.88, 41.35, 30.83, 20.94), 'my'),
        array('group-b',      array(56.25, 74.33, 41.15, 21.93), ''),
        array('group-c',      array(61.34, 44.69, 30.77, 39.99), ''),
        array('cambodia-b',   array(37.09, 63.49, 52.68, 26.04), ''),
        array('group-d',      array(20.98, 67.36, 61.9, 21.74),  ''),
        array('thailand-b',   array(23.48, 78.2, 51.63, 16.23),  ''),
    );
    $nv_sea_key = array('th' => 'thailand', 'id' => 'indonesia', 'vn' => 'vietnam', 'ph' => 'philippines', 'sg' => 'singapore', 'my' => 'malaysia');
    $nv_sea_states = array();
    foreach ($nv_kyc['sea'] as $nv_s) {
        $nv_sea_states[$nv_s['id']] = array('title' => $nv_s['title'], 'text' => $nv_s['text'], 'regulator' => $nv_s['regulator'], 'id_doc' => $nv_s['id_doc']);
    }
    $nv_sea0 = $nv_kyc['sea'][0];
    ?>
    <section class="kyc-sea" id="southeast-asia" data-kyc-sea data-kyc-states="<?php echo esc_attr(wp_json_encode($nv_sea_states)); ?>">
        <div class="solutions-products__panel kyc-panel">
            <div class="container">
                <div class="kyc-sea__inner">
                    <div class="section__badge">Southeast Asia</div>
                    <div class="kyc-sea__head">
                        <h2 class="kyc-title">eKYC in Southeast Asia: Rules and IDs by Country</h2>
                        <p class="kyc-lead">In Southeast Asia, regulators call it eKYC — electronic KYC — and each country has its own rules, ID cards and government databases. NeuroVision runs one eKYC solution across the region and adapts the checks to each market.</p>
                    </div>
                    <div class="kyc-sea__row">
                        <div class="kyc-sea__map" data-sea-map aria-hidden="true">
                            <?php foreach ($nv_sea_layers as $nv_layer) :
                                $nv_name = $nv_layer[0]; $nv_in = $nv_layer[1]; $nv_code = $nv_layer[2];
                                $nv_on_key = $nv_code ? $nv_sea_key[$nv_code] : '';
                                $nv_is_on  = ($nv_on_key && $nv_on_key === $nv_sea0['id']);
                                $nv_src    = $nv_img . 'kyc-sea-' . $nv_name . ($nv_is_on ? '-on' : '') . '.svg';
                                ?>
                            <img class="kyc-sea__layer" src="<?php echo esc_url($nv_src); ?>" alt="" loading="lazy" decoding="async"
                                 <?php if ($nv_on_key) : ?>data-country="<?php echo esc_attr($nv_on_key); ?>" data-src="<?php echo esc_url($nv_img . 'kyc-sea-' . $nv_name . '.svg'); ?>" data-src-on="<?php echo esc_url($nv_img . 'kyc-sea-' . $nv_name . '-on.svg'); ?>"<?php endif; ?>
                                 style="left: <?php echo esc_attr(round($nv_in[3], 2)); ?>%; top: <?php echo esc_attr(round($nv_in[0], 2)); ?>%; width: <?php echo esc_attr(round(100 - $nv_in[1] - $nv_in[3], 2)); ?>%; height: <?php echo esc_attr(round(100 - $nv_in[0] - $nv_in[2], 2)); ?>%;">
                            <?php endforeach; ?>
                            <div class="kyc-sea__zoom"<?php echo 'singapore' === $nv_sea0['id'] ? '' : ' hidden'; ?> data-sea-zoom>
                                <img class="kyc-sea__ellipse" src="<?php echo esc_url($nv_img . 'kyc-sea-ellipse.svg'); ?>" width="24" height="24" alt="">
                                <img class="kyc-sea__line kyc-sea__line--a" src="<?php echo esc_url($nv_img . 'kyc-sea-line-a.svg'); ?>" alt="">
                                <img class="kyc-sea__line kyc-sea__line--b" src="<?php echo esc_url($nv_img . 'kyc-sea-line-b.svg'); ?>" alt="">
                                <span class="kyc-sea__circle"><img src="<?php echo esc_url($nv_img . 'kyc-sea-singapore-zoom.svg'); ?>" alt=""></span>
                            </div>
                        </div>
                        <div class="kyc-sea__side">
                            <div class="kyc-sea__tabs" role="tablist" aria-label="Southeast Asia countries">
                                <?php foreach ($nv_kyc['sea'] as $nv_i => $nv_s) : ?>
                                <button type="button" role="tab" class="kyc-sea__tab<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"
                                        id="kyc-sea-tab-<?php echo esc_attr($nv_s['id']); ?>" data-country="<?php echo esc_attr($nv_s['id']); ?>"
                                        aria-selected="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="kyc-sea-panel"
                                        tabindex="<?php echo (0 === $nv_i) ? '0' : '-1'; ?>"><?php echo esc_html($nv_s['label']); ?></button>
                                <?php endforeach; ?>
                            </div>
                            <div class="kyc-card kyc-card--filled kyc-sea__card" id="kyc-sea-panel" role="tabpanel" aria-labelledby="kyc-sea-tab-singapore" aria-live="polite">
                                <h3 class="kyc-card__title" data-slot="title"><?php echo esc_html($nv_sea0['title']); ?></h3>
                                <p class="kyc-sea__text" data-slot="text"><?php echo esc_html($nv_sea0['text']); ?></p>
                                <dl class="kyc-sea__facts">
                                    <div class="kyc-sea__fact"><dt>Regulator</dt><dd><span class="kyc-token kyc-token--orange" data-slot="regulator"><?php echo esc_html($nv_sea0['regulator']); ?></span></dd></div>
                                    <div class="kyc-sea__fact"><dt>Main ID</dt><dd><span class="kyc-token kyc-token--orange" data-slot="id_doc"><?php echo esc_html($nv_sea0['id_doc']); ?></span></dd></div>
                                    <div class="kyc-sea__fact"><dt>What we check</dt><dd class="kyc-sea__tokens"><?php foreach ($nv_kyc['sea_checks'] as $nv_c) : ?><span class="kyc-token kyc-token--orange"><?php echo esc_html($nv_c); ?></span><?php endforeach; ?></dd></div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* 9. KYC Onboarding That Customers Finish: 2538:18915. */ ?>
    <section class="kyc-section kyc-onboarding">
        <div class="container">
            <div class="section__badge">Onboarding</div>
            <div class="kyc-onboarding__head">
                <h2 class="kyc-title">KYC Onboarding That Customers Finish</h2>
                <p class="kyc-subtitle">Every extra minute in KYC onboarding costs you customers. Our KYC onboarding software keeps honest users moving and saves the friction for the cases that need it.</p>
            </div>
            <div class="kyc-onboarding__grid">
                <div class="kyc-card kyc-card--filled kyc-onboarding__auto">
                    <h3 class="kyc-card__title kyc-card__title--lg">Automated customer onboarding with manual review only when needed</h3>
                    <p class="kyc-card__text kyc-card__text--md">Clear passes and clear fails are decided automatically. Your team only sees the borderline cases — with the reason they were flagged.</p>
                    <?php echo $nv_kyc_img('kyc-onboard-laptop', 443, 323, 'kyc-onboarding__laptop'); ?>
                </div>
                <div class="kyc-card kyc-onboarding__retakes">
                    <picture>
                        <source media="(min-width: 1600px)"
                                srcset="<?php echo esc_url($nv_img . 'kyc-onboard-phone-fhd.webp'); ?> 1x, <?php echo esc_url($nv_img . 'kyc-onboard-phone-fhd@2x.webp'); ?> 2x"
                                width="172" height="354">
                        <?php echo $nv_kyc_img('kyc-onboard-phone', 158, 326, 'kyc-onboarding__phone'); ?>
                    </picture>
                    <div class="kyc-onboarding__retakes-text">
                        <h3 class="kyc-card__title kyc-card__title--lg">Digital customer onboarding without retakes</h3>
                        <p class="kyc-card__text kyc-card__text--md">Guided capture tells customers to move closer, avoid glare or flip the card, so fewer sessions fail on bad photos — on any phone.</p>
                    </div>
                </div>
                <div class="kyc-onboarding__side">
                    <div class="kyc-card kyc-card--filled kyc-card--overflow">
                        <h3 class="kyc-card__title">Local documents and languages</h3>
                        <p class="kyc-card__text kyc-card__text--md">Customers verify with the ID they actually carry, and the flow speaks their language — including Bahasa Indonesia, Malay, Vietnamese and Thai.</p>
                        <ul class="kyc-flags">
                            <?php foreach (array('us' => 'United States', 'ae' => 'United Arab Emirates', 'sg' => 'Singapore', 'vn' => 'Vietnam', 'th' => 'Thailand', 'id' => 'Indonesia', 'es' => 'Spain') as $nv_f => $nv_fl) : ?>
                            <li class="kyc-flags__item"><img src="<?php echo esc_url($nv_img . 'kyc-flag-' . $nv_f . '.svg'); ?>" width="40" height="40" alt="<?php echo esc_attr($nv_fl); ?>" loading="lazy"></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="kyc-card kyc-card--filled">
                        <h3 class="kyc-card__title">See where customers drop off</h3>
                        <p class="kyc-card__text kyc-card__text--md">Funnel statistics show at which step customers leave, so you can change the flow and measure the result.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* 10. KYC Solutions by Industry: 2538:19117. */ ?>
    <section class="kyc-section kyc-industries">
        <div class="container">
            <div class="section__badge">Industries</div>
            <h2 class="kyc-title">KYC Solutions by Industry</h2>
            <ul class="kyc-industries__grid">
                <?php foreach ($nv_kyc['industries'] as $nv_ind) : ?>
                <li class="kyc-card kyc-industries__card">
                    <div class="kyc-industries__top">
                        <span class="kyc-icon-box" aria-hidden="true"><?php echo nv_kyc_icon('industry'); ?></span>
                        <div class="kyc-industries__text">
                            <h3 class="kyc-card__title kyc-card__title--md"><?php echo esc_html($nv_ind['title']); ?></h3>
                            <p class="kyc-card__text"><?php echo esc_html($nv_ind['text']); ?></p>
                        </div>
                    </div>
                    <div class="kyc-industries__req">
                        <span class="kyc-industries__req-label">Typical requirements</span>
                        <span class="kyc-industries__req-text"><?php echo esc_html($nv_ind['req']); ?></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php /* 11. KYC Service Pricing: 2539:19468. */ ?>
    <section class="kyc-pricing">
        <div class="solutions-products__panel kyc-panel">
            <div class="container">
                <div class="section__badge">Industries</div>
                <div class="kyc-pricing__inner">
                    <div class="kyc-pricing__head">
                        <h2 class="kyc-title">KYC Service Pricing</h2>
                        <p class="kyc-lead kyc-lead--md">No subscription and no setup fee. You pay per completed KYC check, and the price goes down as your volume grows.</p>
                    </div>
                    <div class="kyc-pricing__grid">
                        <div class="kyc-card kyc-card--filled kyc-pricing__main">
                            <div class="kyc-pricing__main-text">
                                <p class="kyc-pricing__price">From <span>$0.25</span> per check</p>
                                <p class="kyc-pricing__desc">Build your check from the modules you need — document, face match, liveness, AML screening, proof of address.</p>
                            </div>
                            <a class="kyc-btn kyc-btn--primary" href="<?php echo esc_url(home_url('/pricing-matrix/')); ?>">
                                <span class="kyc-btn__text">See KYC Pricing</span>
                                <span class="kyc-btn__icon"><?php echo $nv_arrow; ?></span>
                            </a>
                        </div>
                        <div class="kyc-pricing__side">
                            <div class="kyc-card kyc-card--accent kyc-pricing__plan">
                                <div class="kyc-pricing__plan-text">
                                    <h3 class="kyc-card__title">Free pilot</h3>
                                    <p class="kyc-card__text">1-month pilot on your real traffic, sandbox access from day one</p>
                                </div>
                                <button type="button" class="kyc-btn kyc-btn--small open-callForm2">
                                    <span class="kyc-btn__text">Start Free Pilot</span>
                                    <span class="kyc-btn__icon"><?php echo $nv_arrow; ?></span>
                                </button>
                            </div>
                            <div class="kyc-card kyc-card--filled kyc-pricing__plan">
                                <div class="kyc-pricing__plan-text">
                                    <h3 class="kyc-card__title">Volume and enterprise plans</h3>
                                    <p class="kyc-card__text">Custom pricing for high volumes, on-premise deployment, an SLA and a dedicated manager</p>
                                </div>
                                <button type="button" class="kyc-btn kyc-btn--small open-callForm">
                                    <span class="kyc-btn__text">Talk to Sales</span>
                                    <span class="kyc-btn__icon"><?php echo $nv_arrow; ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* 12. About: 2539:19578. */ ?>
    <section class="kyc-section kyc-about">
        <div class="container">
            <div class="section__badge">About</div>
            <div class="kyc-about__head">
                <h2 class="kyc-title">One identity platform for onboarding, compliance, signing and payments</h2>
                <p class="kyc-lead kyc-lead--md">NeuroVision Global builds every engine in-house — document OCR, face recognition, liveness and anti-fraud — and runs them for banks, fintechs, telecoms and government services on four continents. Profitable and founder-owned; no third-party technology under the hood.</p>
            </div>
            <div class="kyc-about__stats">
                <div class="kyc-card kyc-about__accuracy">
                    <p class="kyc-card__text kyc-card__text--md">Our advanced computer vision technology delivers</p>
                    <div class="kyc-about__figures">
                        <div class="kyc-about__figure"><span class="kyc-about__value">99.74%</span><span class="kyc-about__caption">facial recognition accuracy</span></div>
                        <span class="kyc-about__divider" aria-hidden="true"></span>
                        <div class="kyc-about__figure"><span class="kyc-about__value">99.85%</span><span class="kyc-about__caption">document recognition accuracy</span></div>
                    </div>
                </div>
                <div class="kyc-card kyc-about__documents">
                    <p class="kyc-card__text kyc-card__text--md">Our advanced computer vision technology delivers</p>
                    <p class="kyc-about__documents-text">over <span>16,000 document</span> types <br class="kyc-about__br">from <span>195+ countries and territories</span></p>
                </div>
            </div>
            <div class="kyc-card kyc-about__certs">
                <div class="kyc-about__certs-text">
                    <p class="kyc-about__certs-title">NeuroVision Global operates in compliance with ISO/IEC 27001:2022 and GDPR standards, covering the design, development, and operation of AI-based identity verification systems</p>
                    <div class="kyc-about__certs-links">
                        <span class="kyc-tag"><span>ISO/IEC 27001:2022</span><?php echo $nv_arrow; ?></span>
                        <span class="kyc-tag"><span>GDPR compliance certification</span><?php echo $nv_arrow; ?></span>
                    </div>
                </div>
                <div class="kyc-about__badges">
                    <?php echo $nv_kyc_img('kyc-cert-iso', 120, 120, '', 'ISO register global certification mark'); ?>
                    <?php echo $nv_kyc_img('kyc-cert-asib', 94, 120, '', 'ASIB certification mark'); ?>
                    <?php echo $nv_kyc_img('kyc-cert-qa', 120, 120, 'kyc-about__badge-round', 'QA Compliance Assessment certification mark'); ?>
                </div>
            </div>
        </div>
    </section>

    <?php /* 13. Integration — общий блок со /solutions/ (Figma 2539:19620, тексты совпадают). */ ?>
    <?php get_template_part('template-parts/integration-section'); ?>

    <?php /* 14. Contacts: 2492:14632 — общая секция и форма. FAQ: 2492:14616, ответы — 2553:24034. */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>
    <?php get_template_part('template-parts/faq-section', null, array('items' => $nv_kyc['faq'])); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
