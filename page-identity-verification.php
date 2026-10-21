<?php
/*
Template Name: Identity Verification
Template Post Type: page
*/
get_header();

/*
 * Страница /identity-verification/. Figma ISDh0vGDZPe3CsGvR4ZaIn: Full HD 2666:50067,
 * Desktop 2620:25851, Tablet 2654:34135, Mobile 2666:42085. Переиспользовано без копирования:
 * первый экран `.main--hero` (partial kyc-hero-section), `.kyc-card`/`.kyc-title`/
 * `.kyc-lead`/`.kyc-btn`/`.kyc-icon-box`/`.kyc-token` примитивы, Integration/Contacts/FAQ/News
 * (template-parts/*-section.php, общие со /solutions/, /kyc/ и главной). Новое — только `.idv-*`
 * композиции и initCoverage() в js/main.js. Данные и иконки — inc/identity-verification-data.php,
 * inc/identity-icons.php; тексты дословно из Figma.
 *
 * Два заголовка ниже видимо скопированы в Figma из других разделов макета (Accuracy повторяет
 * заголовок Integration, Security — заголовок Risk-Based KYC с /kyc/). Оставлены как в макете,
 * см. implementation-report.
 */
require_once get_template_directory() . '/inc/identity-icons.php';
require_once get_template_directory() . '/inc/kyc-icons.php';
require_once get_template_directory() . '/template-parts/contacts-icons.php';
$nv_idv = require get_template_directory() . '/inc/identity-verification-data.php';
$nv_img = get_template_directory_uri() . '/img/';
$nv_arrow = nv_contacts_icon('arrow', 24);

/* Слои карты SEA — inc/security-map.php (общая для блока Security и Coverage, L-03). */
require_once get_template_directory() . '/inc/security-map.php';
$nv_security_map = nv_security_map_layers();

/* Картинка 1x/2x с готовыми размерами — тот же помощник, что в page-kyc.php. */
$nv_idv_img = static function (string $name, int $w, int $h, string $class = '', string $alt = '', bool $lazy = true) use ($nv_img): string {
    return '<img' . ($class ? ' class="' . esc_attr($class) . '"' : '')
        . ' src="' . esc_url($nv_img . $name . '.webp') . '"'
        . ' srcset="' . esc_url($nv_img . $name . '.webp') . ' 1x, ' . esc_url($nv_img . $name . '@2x.webp') . ' 2x"'
        . ' width="' . $w . '" height="' . $h . '" alt="' . esc_attr($alt) . '"'
        . ($alt === '' ? ' aria-hidden="true"' : '') . ($lazy ? ' loading="lazy"' : '') . ' decoding="async">';
};
?>

<main>

    <?php
    /* 1. Первый экран: универсальный partial template-parts/kyc-hero-section.php (аргумент `media` — основной
     * кадр + отдельный mobile 720×536; кадрирование на планшете и мобильной — focus_*). */
    $nv_idv_hero_facts = array();
    foreach ($nv_idv['hero_facts'] as $nv_fact) {
        $nv_idv_hero_facts[] = array(
            'icon_html'   => nv_identity_icon($nv_fact['icon']),
            'text'        => $nv_fact['text'],
            'mobile_text' => $nv_fact['mobile_text'] ?? null,
        );
    }
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'identity-hero', 'w' => 1600, 'h' => 1056, 'alt' => '',
            'mobile'       => array('src' => 'identity-hero-mobile', 'w' => 720, 'h' => 536),
            'focus'        => '75% 50%',
            'focus_tablet' => '35% 50%',
        ),
        'title'         => 'Automated Identity Verification for 195+ Countries',
        'subtitle'      => 'Verify customers in seconds with one identity verification service: ID verification for 16,000+ document types, selfie face matching with 99.74% accuracy, liveness detection and AML screening — through a single API or a no-code widget.',
        'primary_btn'   => array('text' => 'Start Free Pilot', 'mobile_text' => 'Start Free Trial'),
        'secondary_btn' => array('text' => 'See Pricing', 'mobile_text' => 'View our prices', 'href' => home_url('/pricing-matrix/')),
        'facts'         => $nv_idv_hero_facts,
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Independently tested and certified: variant с реальными cert-марками (2620:25883). */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'idv-certs',
        'title'      => 'Independently tested and certified',
        'marks'      => array(
            array('img' => 'kyc-cert-iso', 'w' => 80, 'h' => 80, 'alt' => 'ISO register global certification mark'),
            array('img' => 'kyc-cert-asib', 'w' => 62, 'h' => 80, 'alt' => 'ASIB certification mark'),
            array('img' => 'kyc-cert-qa', 'w' => 80, 'h' => 80, 'alt' => 'QA Compliance Assessment certification mark', 'round' => true),
        ),
        'chips'      => array('ISO/IEC 27001:2022', 'GDPR'),
    )); ?>

    <?php
    /* 3. What NeuroVision Identity Verification Checks: partial template-parts/idv-checks-section.php, 6 карточек (2620:25891). */
    get_template_part('template-parts/idv-checks-section', null, array(
        'section_id' => 'checks',
        'badge'      => 'Checks',
        'title'      => 'What NeuroVision Identity Verification Checks',
        'lead'       => 'Use all six checks in one flow or pick only the ones your onboarding needs.',
        'intro'      => 'Digital identity verification is more than reading a passport. Every NeuroVision check combines several independent signals, so a stolen document, a borrowed face or a deepfake fails at least one of them.',
        'items'      => $nv_idv['checks'],
    ));
    ?>

    <?php
    /*
     * 4. How Online ID Verification Works: общий partial с /kyc/ (I-01, 2620:25928). Один
     * [data-kyc-steps] на загрузку страницы — initKycPage() запрашивает его через querySelector,
     * конфликта с /kyc/ нет (разные HTTP-запросы).
     */
    get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'           => 'How it works',
        'title'           => 'How Online ID Verification Works',
        'lead'            => 'Four steps, an automated decision in seconds, a full audit trail for your compliance team.',
        'note'            => 'Every check in under a second — auto-approve, decline or route to manual review, by your scenario.',
        'steps'           => $nv_idv['steps'],
        'step_id_prefix'  => 'idv-step',
        'nav_label'       => 'Identity verification steps',
        'arrow_icon'      => $nv_arrow,
    ));
    ?>

    <?php
    /* 5. One Identity Verification Platform Instead of Five Vendors: общий скелет .kyc-platform*
     * с /kyc/ (I-01/I-02, 2620:25998); верх/screen/summary — отличия Identity (no-code+note ряд,
     * laptop+screen оверлей, нижняя summary-плашка). */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'        => 'Platform',
        'title'        => 'One Identity Verification Platform Instead of Five Vendors',
        'lead'         => 'Most teams stitch together an OCR vendor, a face-matching API, a liveness provider and a separate AML database',
        'top'          => array(
            'title'     => $nv_idv['platform_cards']['no_code']['title'],
            'text'      => $nv_idv['platform_cards']['no_code']['text'],
            'note'      => $nv_idv['platform_cards']['note'],
            'note_icon' => nv_identity_icon('swap'),
        ),
        'audit'        => array('title' => $nv_idv['platform_cards']['audit']['title'], 'text' => $nv_idv['platform_cards']['audit']['text'], 'img' => 'identity-platform-accent', 'w' => 255),
        'pair'         => array(
            array('title' => $nv_idv['platform_cards']['risk']['title'], 'text' => $nv_idv['platform_cards']['risk']['text']),
            array('title' => $nv_idv['platform_cards']['case']['title'], 'text' => $nv_idv['platform_cards']['case']['text']),
        ),
        'screen'       => array('image' => 'identity-platform-screen'),
        'summary'      => $nv_idv['platform_cards']['summary'],
    ));
    ?>

    <?php
    /*
     * 6. Coverage: new composition, 3 состояния (Documents/Regions/Southeast Asia, 2620:26028,
     * 2636:20653, 2636:23113). Отдельный guarded init initCoverage() в js/main.js — не копия
     * большого initKycPage(), т.к. визуал справа переключается целиком, а не только текст.
     * Текст всех 3 состояний рендерится в разметке (три tabpanel), не только в JSON (I-08):
     * initCoverage() лишь переключает hidden/aria, ничего не подставляет через textContent.
     */
    $nv_coverage_order = array('documents', 'regions', 'sea');
    /* Regions: четыре маркера Target из Figma (2636:20653), 60×60. Доли карты 632×632:
       [центр по X, верх маркера по Y, флаги]. Карта в макете лежит в фрейме 648×632 со сдвигом x=18,
       поэтому X = (left + 30 − 18) / 632, Y = top / 632. */
    $nv_region_markers = array(
        array(14.24, 16.77, array('fi', 'de', 'uk')),
        array(37.66, 12.34, array('by', 'ru', 'ua')),
        array(27.22, 38.29, array('ae', 'kw', 'sa')),
        array(59.97, 40.66, array('th', 'my', 'ph')),
    );
    ?>
    <section class="section idv-coverage" id="coverage" data-idv-coverage>
        <div class="container">
            <?php /* C5-01 (продолжение followup-5): coverage-1920.json — badge отдельно над всей
                     строкой (y64, 32h), row(head+visual+side) начинается ниже, на y144 (48px gap
                     после badge); badge НЕ часть `.idv-coverage__head`, иначе visual (top-aligned
                     с left-колонкой через align-items:flex-start) стартует вместе с badge вместо
                     H2, теряя эти ~80px сдвига вниз. */ ?>
            <div class="section__badge">Coverage</div>
            <div class="idv-coverage__row">
                <div class="idv-coverage__left">
                    <div class="idv-coverage__head">
                        <h2 class="kyc-title">Global Identity Verification in 195+ Countries and territories and 90+ Languages</h2>
                        <p class="kyc-lead--md">Expanding to a new market should not mean a new identity vendor. NeuroVision recognizes 16,000+ document types from 195+ countries and territories, so international identity verification works through the same API from Brazil to the UAE.</p>
                    </div>
                    <div class="idv-coverage__tabs" role="tablist" aria-label="Coverage">
                        <?php foreach ($nv_coverage_order as $nv_i => $nv_ck) : ?>
                        <button type="button" role="tab" class="idv-coverage__tab<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"
                                id="idv-coverage-tab-<?php echo esc_attr($nv_ck); ?>" data-coverage="<?php echo esc_attr($nv_ck); ?>"
                                aria-selected="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="idv-coverage-panel-<?php echo esc_attr($nv_ck); ?>"
                                tabindex="<?php echo (0 === $nv_i) ? '0' : '-1'; ?>"><?php echo esc_html($nv_idv['coverage'][$nv_ck]['tab']); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <?php foreach ($nv_coverage_order as $nv_i => $nv_ck) : ?>
                    <?php
                    /* V2-07: `hidden` на панелях 2/3 НЕ рендерим в PHP — без JS все три состояния
                       должны быть читаемы. Схлопывание до одной активной панели выполняет JS
                       (initCoverage() вызывает activate(0) при инициализации), а не разметка. */
                    ?>
                    <div class="kyc-card kyc-card--filled idv-coverage__panel<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"
                         id="idv-coverage-panel-<?php echo esc_attr($nv_ck); ?>" data-coverage-panel="<?php echo esc_attr($nv_ck); ?>"
                         role="tabpanel" aria-labelledby="idv-coverage-tab-<?php echo esc_attr($nv_ck); ?>">
                        <h3 class="kyc-card__title"><?php echo esc_html($nv_idv['coverage'][$nv_ck]['title']); ?></h3>
                        <p class="kyc-card__text kyc-card__text--md"><?php echo esc_html($nv_idv['coverage'][$nv_ck]['text']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="idv-coverage__visual">
                    <div class="idv-coverage__visual-panel is-active" data-coverage-visual="documents">
                        <?php
                        /*
                         * followup-3 V2-06: источник (references/1920-coverage.png) — 3 плотных
                         * ряда без переноса, по 5/6/5 документов (= 16), не сетка с переносом.
                         * Каждый ряд — отдельный flex-row, карточки делят ширину поровну.
                         */
                        $nv_coverage_doc_rows = array(5, 6, 5);
                        $nv_coverage_doc_n = 1;
                        ?>
                        <div class="idv-coverage__docs-grid" aria-hidden="true">
                            <?php foreach ($nv_coverage_doc_rows as $nv_row_count) : ?>
                            <div class="idv-coverage__docs-row">
                                <?php for ($nv_rd = 0; $nv_rd < $nv_row_count; $nv_rd++) : ?>
                                <?php echo $nv_idv_img('identity-coverage-doc' . $nv_coverage_doc_n, 140, 200, 'idv-coverage__doc'); ?>
                                <?php $nv_coverage_doc_n++; ?>
                                <?php endfor; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="idv-coverage__visual-panel" data-coverage-visual="regions">
                        <img class="idv-coverage__map" src="<?php echo esc_url($nv_img . 'identity-regions-map.svg'); ?>" alt="" aria-hidden="true" loading="lazy" decoding="async">
                        <?php /* Маркеры лежат в квадратной «сцене» min(ширина, высота панели) по центру — ровно там, где
                                 `object-fit: contain` рисует карту; доли $nv_region_markers считаются от сцены, а не от панели. */ ?>
                        <span class="idv-coverage__map-overlay">
                            <span class="idv-coverage__map-stage">
                            <?php foreach ($nv_region_markers as $nv_marker) :
                                list($nv_mx, $nv_my, $nv_mflags) = $nv_marker;
                                ?>
                            <span class="idv-coverage__region-marker" style="left: <?php echo esc_attr($nv_mx); ?>%; top: <?php echo esc_attr($nv_my); ?>%;">
                                <img class="idv-coverage__region-callout" src="<?php echo esc_url($nv_img . 'identity-coverage-callout.svg'); ?>" width="68" height="61" alt="">
                                <span class="idv-coverage__region-plate">
                                    <?php foreach ($nv_mflags as $nv_mflag) : ?>
                                    <img class="idv-coverage__region-flag" src="<?php echo esc_url($nv_img . 'kyc-flag-' . $nv_mflag . '.svg'); ?>" width="24" height="24" alt="">
                                    <?php endforeach; ?>
                                </span>
                            </span>
                            <?php endforeach; ?>
                            </span>
                        </span>
                    </div>
                    <?php
                    /*
                     * followup-5 L-03: прежние 9 слоёв (kyc-sea-*) без insets давали ту же
                     * проблему, что была у Security до фикса (нет canvas-масштаба) плюс
                     * height:0 у самой панели. Переиспользуем точную 16-слойную географию
                     * Security (figma node 2642:30982, та же территория SEA) — те же файлы,
                     * тот же inset-технику (top/right/bottom/left + явные width/height, F4-01).
                     */
                    ?>
                    <div class="idv-coverage__visual-panel" data-coverage-visual="sea">
                        <div class="idv-coverage__sea-map">
                            <?php foreach ($nv_security_map as $nv_sea_layer) :
                                list($nv_sea_name, $nv_sea_top, $nv_sea_right, $nv_sea_bottom, $nv_sea_left) = $nv_sea_layer;
                                $nv_sea_w = 100 - $nv_sea_right - $nv_sea_left;
                                $nv_sea_h = 100 - $nv_sea_top - $nv_sea_bottom;
                                ?>
                            <img class="idv-coverage__sea-layer" src="<?php echo esc_url($nv_img . 'identity-security-' . $nv_sea_name . '.svg'); ?>" alt=""
                                 style="top: <?php echo esc_attr($nv_sea_top); ?>%; right: <?php echo esc_attr($nv_sea_right); ?>%; bottom: <?php echo esc_attr($nv_sea_bottom); ?>%; left: <?php echo esc_attr($nv_sea_left); ?>%; width: <?php echo esc_attr($nv_sea_w); ?>%; height: <?php echo esc_attr($nv_sea_h); ?>%;"
                                 loading="lazy" decoding="async">
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="idv-coverage__bottom">
                <div class="kyc-card kyc-card--accent idv-coverage__promo">
                    <h3 class="kyc-card__title kyc-card__title--lg"><?php echo esc_html($nv_idv['coverage']['promo']['title']); ?></h3>
                    <p class="kyc-card__text kyc-card__text--md"><?php echo esc_html($nv_idv['coverage']['promo']['text']); ?></p>
                </div>
                <div class="idv-coverage__stats">
                    <?php foreach ($nv_idv['coverage']['stats'] as $nv_stat) : ?>
                    <div class="kyc-card kyc-card--filled idv-coverage__stat">
                        <span class="kyc-icon-box" aria-hidden="true"><?php echo nv_identity_icon('star'); ?></span>
                        <span class="idv-coverage__stat-text">
                            <span class="idv-coverage__stat-value"><?php echo esc_html($nv_stat['value']); ?></span>
                            <span class="idv-coverage__stat-label"><?php echo esc_html($nv_stat['label']); ?></span>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    /* 7. Accuracy / NIST: new composition (2620:26912). Заголовок дословно из Figma (копипаст Integration). */
    ?>
    <section class="section idv-accuracy" id="accuracy">
        <div class="container">
            <div class="section__badge">Accuracy</div>
            <h2 class="kyc-title idv-accuracy__title"><?php echo esc_html($nv_idv['accuracy']['title']); ?></h2>
            <div class="idv-accuracy__grid">
                <div class="idv-accuracy__col">
                    <div class="kyc-card kyc-card--filled idv-accuracy__metrics">
                        <dl class="idv-accuracy__metrics-list">
                            <?php foreach ($nv_idv['accuracy']['metrics'] as $nv_metric) : ?>
                            <div class="idv-accuracy__metric-row">
                                <dt><?php echo esc_html($nv_metric['label']); ?></dt>
                                <dd><?php echo esc_html($nv_metric['value']); ?></dd>
                            </div>
                            <?php endforeach; ?>
                        </dl>
                        <p class="idv-accuracy__metrics-note"><?php echo esc_html($nv_idv['accuracy']['metrics_note']); ?></p>
                    </div>
                    <div class="idv-accuracy__cards">
                        <?php foreach ($nv_idv['accuracy']['cards'] as $nv_ac) : ?>
                        <div class="kyc-card idv-accuracy__card">
                            <h3 class="kyc-card__title"><?php echo nl2br(esc_html($nv_ac['title'])); ?></h3>
                            <p class="kyc-card__text"><?php echo esc_html($nv_ac['text']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="kyc-card kyc-card--accent idv-accuracy__nist">
                    <h3 class="kyc-card__title kyc-card__title--lg idv-accuracy__nist-title"><?php echo esc_html($nv_idv['accuracy']['nist_title']); ?></h3>
                    <div class="idv-accuracy__nist-inner">
                        <?php echo $nv_idv_img('identity-nist-logos', 318, 50, 'idv-accuracy__nist-logos', 'NIST FRTE'); ?>
                        <p class="idv-accuracy__nist-lead"><?php echo esc_html($nv_idv['accuracy']['nist_lead']); ?></p>
                        <p class="idv-accuracy__nist-text"><?php echo esc_html($nv_idv['accuracy']['nist_text']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    /* 8. Identity Verification Solutions by Industry: общий partial с /kyc/ (I-01, 2642:24331). */
    get_template_part('template-parts/kyc-industries-section', null, array(
        'title'    => 'Identity Verification Solutions by Industry',
        'lead'     => 'Customer identity verification looks different for a bank, a casino and a car-sharing app. Pick the checks your industry needs and the documents your regulator accepts.',
        'badge'    => 'Industries',
        'items'    => $nv_idv['industries'],
    ));
    ?>

    <?php /* 9. Why Businesses Automate Identity Verification: partial template-parts/idv-benefits-section.php (2642:30293). */ ?>
    <?php get_template_part('template-parts/idv-benefits-section', null, array(
        'section_id' => 'benefits',
        'badge'      => 'Benefits',
        'title'      => 'Why Businesses Automate Identity Verification',
        'icon'       => nv_identity_icon('check-circle'),
        'items'      => $nv_idv['benefits'],
        'promo'      => array(
            'title' => $nv_idv['benefits_promo']['title'],
            'text'  => $nv_idv['benefits_promo']['text'],
            'img'   => 'identity-benefits-fraud',
        ),
    )); ?>

    <?php
    /* 10. Identity Verification Service Pricing: общий partial с /kyc/ (I-01, 2620:26852). */
    get_template_part('template-parts/kyc-pricing-section', null, array(
        'badge'      => 'Pricing',
        'title'      => $nv_idv['pricing']['title'],
        'lead'       => $nv_idv['pricing']['lead'],
        'eyebrow'    => $nv_idv['pricing']['eyebrow'],
        'price_prefix' => 'From',
        'price'      => '$0.25',
        'price_unit' => 'per check',
        'price_note' => $nv_idv['pricing']['price_note'],
        'cta'        => $nv_idv['pricing']['cta'],
        'cta_url'    => home_url('/pricing-matrix/'),
        'arrow_icon' => $nv_arrow,
        'plans'      => array(
            array('title' => 'Free pilot', 'text' => '1-month pilot on your real traffic, sandbox access from day one', 'btn' => 'Start Free Pilot', 'form' => 'open-callForm2'),
            array('title' => 'Volume and enterprise plans', 'text' => 'Custom pricing for high volumes, on-premise deployment, an SLA and a dedicated manager', 'btn' => 'Talk to Sales', 'form' => 'open-callForm'),
        ),
    ));
    ?>

    <?php
    /* 11. Why Choose NeuroVision Identity Verification Software: общий partial с /kyc/ (I-01, 2620:26881).
     * Своё — только badge/title/modifier; лида под заголовком в этом Figma-узле нет (lead => null). */
    get_template_part('template-parts/kyc-about-section', null, array(
        'badge'      => 'Why NeuroVision',
        'title'      => $nv_idv['about']['title'],
        'lead'       => null,
        'modifier'   => 'idv-about',
        'arrow_icon' => $nv_arrow,
    ));
    ?>

    <?php
    /*
     * 12. API and SDKs: reuse template-parts/integration-section.php (2637:24119). Первый слайд —
     * REST API из Figma; 2-й/3-й слайды — прежние данные компонента (ТЗ: не выдавать за новые states).
     */
    require_once get_template_directory() . '/inc/integration-preset.php';
    $nv_int = nv_integration_preset();
    get_template_part('template-parts/integration-section', null, array_merge($nv_int, array(
        'badge'    => 'API & SDKs',
        'heading'  => 'Identity Verification API and SDKs: Go Live in One Business Day',
        'subtitle' => 'Most teams finish their identity verification API integration in one business day. Start in the sandbox with test data, then switch one key to go live',
        /* V2-12: Identity-Figma не содержит карточку Cloud/on-prem/hybrid в этом блоке. */
        'deploy'   => array(),
        'slides'   => array_replace($nv_int['slides'], array(
            0 => array(
                'title'       => 'REST API',
                'subtitle'    => '',
                'description' => 'Create a verification session, send images or let our SDK capture them, and receive the result by webhook. Clear endpoints, sample requests and responses in JSON, code examples in Python, Java and Node.js.',
            ),
        )),
    )));
    ?>

    <?php
    /* 13. Security: Risk-Based KYC title дословно из Figma (копипаст с /kyc/); partial template-parts/idv-security-section.php. */
    get_template_part('template-parts/idv-security-section', null, array(
        'section_id' => 'security',
        'badge'      => 'Security',
        'title'      => $nv_idv['security']['title'],
        'cards'      => $nv_idv['security']['cards'],
        'regional'   => $nv_idv['security']['regional'],
    ));
    ?>

    <?php /* 14. Contacts — общая секция/форма, без изменений (2620:26959, тексты совпадают с /solutions/ и /kyc/). */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>

    <?php /* 16. FAQ: reuse, заголовок/11 вопросов дословно из Figma (2642:31958). */ ?>
    <?php get_template_part('template-parts/faq-section', null, array(
        'items'       => $nv_idv['faq'],
        'title'       => 'Identity Verification FAQ',
        'description' => 'A focused set of Identity Verification specific questions. The full library &mdash; including industry- and region-specific topics &mdash; lives in the resource center.',
    )); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
