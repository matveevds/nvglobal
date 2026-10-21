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
 * Переиспользовано без копирования: первый экран `.main--hero` (partial kyc-hero-section),
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

    <?php
    /* 1. Первый экран: 2561:30924 (FHD 1856x872), 2492:14452 (Desktop 1376x732), 2560:30238 (Mobile). Универсальный partial
     * template-parts/kyc-hero-section.php; кадры по брейкпоинтам — fhd / desktop / tablet, на мобильной — тот же вертикальный кадр. */
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'kyc-hero-tablet', 'w' => 776, 'h' => 872, 'alt' => '',
            'fhd'          => array('src' => 'kyc-hero-fhd', 'w' => 1856, 'h' => 872),
            'desktop'      => array('src' => 'kyc-hero-desktop', 'w' => 1376, 'h' => 732),
            'tablet'       => array('src' => 'kyc-hero-tablet', 'w' => 776, 'h' => 872),
            'mobile'       => array('src' => 'kyc-hero-tablet', 'w' => 776, 'h' => 872),
            'focus'        => '100% 50%',
            'focus_mobile' => '50% 40%',
        ),
        'title'         => 'Automated KYC and eKYC Verification for Fast, Compliant Onboarding',
        'subtitle'      => 'One KYC solution for the whole process: ID document checks, selfie face match, liveness detection, AML screening and risk scoring — with an audit trail for every customer. Run KYC verification worldwide and eKYC under the rules of Singapore, Malaysia, Indonesia and the Philippines.',
        'primary_btn'   => array('text' => 'Start Free Pilot'),
        'secondary_btn' => array('text' => 'See How It Works', 'href' => '#how-it-works'),
        'facts'         => array(
            array('icon_html' => nv_kyc_icon('globe'), 'text' => '99.74% face match accuracy&nbsp;(NIST)'),
            array('icon_html' => nv_kyc_icon('shield'), 'text' => '0.1&nbsp;s per face match'),
            array('icon_html' => nv_kyc_icon('scan'), 'text' => '195+ countries and&nbsp;territories'),
            array('icon_html' => nv_kyc_icon('document'), 'text' => 'From $0.25 per KYC&nbsp;check'),
        ),
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Сертификации: 2495:24360. */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'kyc-certs',
        'title'      => 'Independently tested and certified',
        'chip_icon'  => nv_kyc_icon('check', 20),
        'chips'      => array('NIST FRVT', 'ISO/IEC 27001:2022', 'GDPR', 'FATF-aligned AML'),
    )); ?>

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
    <?php
    /* Общий partial с /identity-verification/ (I-01); section_id/step_id_prefix по умолчанию
     * воспроизводят прежние "how-it-works"/"kyc-step-N" — byte-identical для KYC. */
    get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'          => 'How it works',
        'title'          => 'How KYC Verification Works',
        'lead'           => 'An automated decision in seconds, a documented record for your compliance team.',
        'note'           => 'Every check in under a second — auto-approve, decline or route to manual review, by your scenario.',
        'steps'          => $nv_kyc['steps'],
        'arrow_icon'     => $nv_arrow,
        'step_id_prefix' => 'kyc-step',
        'nav_label'      => 'KYC verification steps',
    ));
    ?>

    <?php
    /*
     * 5. Risk-Based KYC: 2492:14501, вкладки 2502:24747 / 2539:20397 (FHD 2561:31026 / 37195 / 37270).
     * В Figma 2502:24747 подсвечена третья кнопка при содержимом CDD — ошибка макета: активна вторая (CDD).
     * Универсальный блок — partial template-parts/kyc-risk-section.php; данные вкладок — `risk` в inc/kyc-data.php.
     */
    $nv_risk_tabs = array();
    foreach ($nv_kyc['risk'] as $nv_r) {
        $nv_risk_tabs[] = $nv_r + array('icon' => nv_kyc_icon('temple'));
    }
    get_template_part('template-parts/kyc-risk-section', null, array(
        'badge'        => 'Due diligence',
        'title'        => 'Risk-Based KYC: Simplified, Standard and Enhanced Due Diligence',
        'lead'         => 'FATF and most national regulators require a risk-based approach: light checks for low-risk customers, deeper checks where the risk is higher. Set the rules once, and every customer gets the right level of KYC automatically.',
        'tabs'         => $nv_risk_tabs,
        'when_label'   => 'When',
        'checks_label' => 'Checks',
        'side'         => array(
            'title' => 'Re-verification and KYC refresh',
            'text'  => 'Ask customers to verify again when their ID expires, their details change or their risk level goes up — without a new onboarding flow.',
            'img'   => 'kyc-risk-refresh',
            'w'     => 245,
            'h'     => 233,
        ),
        'arrow_icon'   => $nv_arrow,
        'tabs_label'   => 'Due diligence level',
    ));
    ?>

    <?php
    /* 6. Case management и платформа: 2502:24611. Общий скелет .kyc-platform* с /identity-verification/
     * (I-01/I-02); блок универсальный — тот же вид, что на /identity-verification/ (решение владельца 2026-10-21). */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'Platform',
        'title'       => 'A KYC Platform Your Compliance Team Will Actually Use',
        'top'         => array(
            'title'     => 'Case management and manual review',
            'text'      => 'Flagged customers land in a review queue with everything side by side: document, selfie, liveness frames, extracted data and screening hits.',
            'note'      => 'Your analyst approves or declines in one click and leaves a comment.',
            'note_icon' => nv_kyc_icon('user'),
        ),
        'audit'       => array('title' => 'Audit trail for every decision', 'text' => 'Every KYC session is logged with timestamps, check results, risk level and reviewer actions, so you can show a regulator why each customer was accepted.', 'img' => 'kyc-step-4', 'w' => 255),
        'pair'        => array(
            array('title' => 'Roles and access rights', 'text' => 'Give analysts, managers and auditors different permissions, and limit who can see personal data.'),
            array('title' => 'Reports and statistics', 'text' => 'Track pass rates, review times, decline reasons and volumes by country in the KYC dashboard, and export reports for audits.'),
        ),
        'screen'      => array('image' => 'identity-platform-screen'),
    ));
    ?>

    <?php
    /*
     * 7. KYC Compliance: 2504:24910, страны 2513:31315 / 31448 / 31544 / 31640 — template-parts/kyc-compliance-section.php.
     * По умолчанию выбран глобус (FATF, общий маркер). Позиции маркеров — доли области карты 738x630 (центр-привязка Figma; UK и EU сдвинуты на ~3% друг от друга, чтобы маркеры не слипались на мобильных).
     */
    $nv_comp_pos = array(
        'us'    => array(13.0, 22.5),
        'uk'    => array(46.5, 15.5),
        'eu'    => array(59.0, 25.5),
        'ae'    => array(76.4, 40.3),
        'world' => array(92.8, 88.4),
    );
    $nv_comp_args = array(
        'badge'   => 'Compliance',
        'title'   => 'KYC Compliance Worldwide: FATF, US, EU, UK and UAE',
        'lead'    => 'Our KYC software gives you the checks and records these rules ask for. Your compliance program decides how to use them.',
        'markers' => array(),
    );
    foreach ($nv_kyc['compliance'] as $nv_c) {
        $nv_m = array(
            'id'    => $nv_c['id'],
            'flag'  => $nv_c['flag'],
            'label' => ('world' === $nv_c['id']) ? 'FATF recommendations (global)' : $nv_c['label'],
            'x'     => $nv_comp_pos[$nv_c['id']][0],
            'y'     => $nv_comp_pos[$nv_c['id']][1],
            'title' => $nv_c['title'],
            'text'  => $nv_c['text'],
        );
        if ('world' === $nv_c['id']) {
            $nv_comp_args['general'] = $nv_m;
        } else {
            $nv_comp_args['markers'][] = $nv_m;
        }
    }
    get_template_part('template-parts/kyc-compliance-section', null, $nv_comp_args);
    ?>

    <?php
    /* 8. eKYC in Southeast Asia: 2492:14522, страны 2538:15792 / 16413 / 17034 / 17655 / 18276 — partial template-parts/kyc-sea-section (универсальный блок; JS — initKycPage()). */
    $nv_sea_items = array();
    foreach ($nv_kyc['sea'] as $nv_s) {
        $nv_sea_items[] = array(
            'id'    => $nv_s['id'],
            'label' => $nv_s['label'],
            'title' => $nv_s['title'],
            'text'  => $nv_s['text'],
            'rows'  => array(
                array('label' => 'Regulator', 'values' => array($nv_s['regulator'])),
                array('label' => 'Main ID', 'values' => array($nv_s['id_doc'])),
                array('label' => 'What we check', 'values' => $nv_kyc['sea_checks']),
            ),
        );
    }
    get_template_part('template-parts/kyc-sea-section', null, array(
        'section_id' => 'southeast-asia',
        'badge'      => 'Southeast Asia',
        'title'      => 'eKYC in Southeast Asia: Rules and IDs by Country',
        'lead'       => 'In Southeast Asia, regulators call it eKYC — electronic KYC — and each country has its own rules, ID cards and government databases. NeuroVision runs one eKYC solution across the region and adapts the checks to each market.',
        'tabs_label' => 'Southeast Asia countries',
        'countries'  => $nv_sea_items,
    ));
    ?>

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
                    <?php echo $nv_kyc_img('kyc-onboard-laptop-full', 440, 394, 'kyc-onboarding__laptop'); ?>
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

    <?php
    /* 10. KYC Solutions by Industry: 2538:19117. Общий partial с /identity-verification/ (I-01). */
    get_template_part('template-parts/kyc-industries-section', null, array(
        'badge' => 'Industries',
        'title' => 'KYC Solutions by Industry',
        'items' => $nv_kyc['industries'],
    ));
    ?>

    <?php
    /* 11. KYC Service Pricing: 2539:19468. Общий partial с /identity-verification/ (I-01). */
    get_template_part('template-parts/kyc-pricing-section', null, array(
        'badge'        => 'Industries',
        'title'        => 'KYC Service Pricing',
        'lead'         => 'No subscription and no setup fee. You pay per completed KYC check, and the price goes down as your volume grows.',
        'price_prefix' => 'From',
        'price'        => '$0.25',
        'price_unit'   => 'per check',
        'price_note'   => 'Build your check from the modules you need — document, face match, liveness, AML screening, proof of address.',
        'cta'          => 'See KYC Pricing',
        'cta_url'      => home_url('/pricing-matrix/'),
        'arrow_icon'   => $nv_arrow,
        'plans'        => array(
            array('title' => 'Free pilot', 'text' => '1-month pilot on your real traffic, sandbox access from day one', 'btn' => 'Start Free Pilot', 'form' => 'open-callForm2'),
            array('title' => 'Volume and enterprise plans', 'text' => 'Custom pricing for high volumes, on-premise deployment, an SLA and a dedicated manager', 'btn' => 'Talk to Sales', 'form' => 'open-callForm'),
        ),
    ));
    ?>

    <?php
    /* 12. About: 2539:19578. Общий partial с /identity-verification/ (I-01): только badge/title/lead
     * свои, статистика/сертификаты — те же данные на обеих страницах. */
    get_template_part('template-parts/kyc-about-section', null, array('arrow_icon' => $nv_arrow));
    ?>

    <?php /* 13. Integration — общий блок со /solutions/ (Figma 2539:19620, тексты совпадают). */ ?>
    <?php require_once get_template_directory() . '/inc/integration-preset.php'; get_template_part('template-parts/integration-section', null, nv_integration_preset()); ?>

    <?php /* 14. Contacts: 2492:14632 — общая секция и форма. FAQ: 2492:14616, ответы — 2553:24034. */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>
    <?php get_template_part('template-parts/faq-section', null, array('items' => $nv_kyc['faq'])); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
