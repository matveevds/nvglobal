<?php
/*
Template Name: Liveness Detection
Template Post Type: page
NV Page Family: identity
*/
get_header();

/*
 * Страница /liveness/ — собрана из блоков библиотеки по ТЗ «Liveness Detection» (13.10.2026).
 * Образец — /kyc/ (page-kyc.php). Регламент — docs/PAGE_BUILDER.md, карта и решения сборщика — docs/pages/liveness.md.
 * Тексты в цитатах ТЗ — дословно. Картинки lv-*: фото Magnific и HTML-макет hero (тексты ТЗ, силуэты вместо лиц).
 */
require_once get_template_directory() . '/inc/identity-icons.php';
require_once get_template_directory() . '/inc/kyc-icons.php';
require_once get_template_directory() . '/template-parts/contacts-icons.php';
$nv_img   = get_template_directory_uri() . '/img/';
$nv_arrow = nv_contacts_icon('arrow', 24);


/* Картинка 1x/2x с готовыми размерами — копия помощника $nv_idv_img из page-identity-verification.php. */
$nv_page_img = static function (string $name, int $w, int $h, string $class = '', string $alt = '', bool $lazy = true) use ($nv_img): string {
    return '<img' . ($class ? ' class="' . esc_attr($class) . '"' : '')
        . ' src="' . esc_url($nv_img . $name . '.webp') . '"'
        . ' srcset="' . esc_url($nv_img . $name . '.webp') . ' 1x, ' . esc_url($nv_img . $name . '@2x.webp') . ' 2x"'
        . ' width="' . $w . '" height="' . $h . '" alt="' . esc_attr($alt) . '"'
        . ($alt === '' ? ' aria-hidden="true"' : '') . ($lazy ? ' loading="lazy"' : '') . ' decoding="async">';
};

/* Блок Checks — partial template-parts/idv-checks-section.php (вызывается для нескольких блоков ТЗ; данные — ниже). */
$nv_checks_block = static function (string $id, string $badge, string $title, string $intro, array $items): void {
    get_template_part('template-parts/idv-checks-section', null, array(
        'section_id' => $id,
        'badge'      => $badge,
        'title'      => $title,
        'intro'      => $intro,
        'items'      => $items,
    ));
};

/* Весь контент страницы — здесь, одним массивом, в порядке блоков ТЗ. */
$nv_page = array(
    /* Факт «[N] s per check» в ТЗ заменён на «Built into KYC» (так велит ТЗ, пока нет замера). H1 — основной вариант ТЗ (с «Deepfakes»): плашка «Deepfake videos» в блоке 3 не помечена как условная; запасной H1 — «…Photos, Videos and Masks» (открытый пункт). */
    'hero' => array(
        'title'    => 'Face Liveness Detection That Stops Photos, Masks and Deepfakes',
        'subtitle' => 'Confirm that a real, live person is in front of the camera before you trust a selfie. Our liveness detection software blocks printed photos, screen replays, masks and deepfakes in a few seconds — inside your KYC flow or as a standalone API.',
        'alt'      => 'Face liveness detection with NeuroVision: a user moves closer to the camera and is confirmed as a live person',
        'facts'    => array(
            array('icon' => 'check-circle', 'text' => '3 levels of presentation attacks'),
            array('icon' => 'swap', 'text' => 'Active + passive modes'),
            array('icon' => 'document-verified', 'text' => 'Built into KYC'),
            array('icon' => 'network-world', 'text' => 'Web SDK + REST API'),
        ),
    ),

    /* Блок 2. Бейдж iBeta / ISO/IEC 30107-3 — только при письмах-подтверждениях; ISO/GDPR и логотипы — после проверки/согласия: не ставятся. Чипы — слова фактов hero. */
    'trust' => array(
        'title' => 'Trusted by 50+ banks, fintechs and exchanges to keep fake selfies out of onboarding.',
        'chips' => array('3 levels of presentation attacks', 'Active + passive modes', 'Built into KYC', 'Web SDK + REST API'),
    ),

    /* Ссылка «→ Deepfake and injection attack detection» не выводится (блок 6 отложен). */
    'attacks' => array(
        'title' => 'Presentation Attacks Our Liveness Detection Stops',
        /* Второе предложение вводного абзаца ТЗ вынесено в четвёртую карточку (сетка 2×2); H3 «Deepfake videos» оставлен. */
        'intro' => 'A presentation attack is any attempt to fool the camera with something that is not a live face.',
        'items' => array(
            array('title' => 'Printed photos and screen replays', 'text' => 'Paper printouts, photos with cut-out eyes, bent prints, social-media pictures and photos or videos shown on another phone or tablet — including replays with blinking and head movement.'),
            array('title' => 'Paper, silicone and 3D masks', 'text' => 'Paper and cardboard masks, basic and professional silicone masks, theatrical masks, 3D-printed faces and full-size 3D heads.'),
            array('title' => 'Deepfake videos', 'text' => 'Videos with an AI-generated or swapped face shown to the camera.'),
            array('title' => 'Simple printouts to professional masks', 'text' => 'Our biometric liveness detection is trained on attacks from simple printouts to professional masks.'),
        ),
    ),

    'steps' => array(
        'title' => 'How Face Liveness Detection Works',
        'lead'  => 'A few seconds for the user, a clear live / not live answer for your system.',
        'items' => array(
            array('title' => '1. The user takes a selfie', 'text' => 'The widget opens the front camera and guides the user to place their face in an oval. No app download.', 'img' => 'lv-step-1', 'w' => 200),
            array('title' => '2. The camera follows the face', 'text' => 'In active mode, the user moves closer to the camera to fill a second oval; the face only moves toward the camera, so the check is quick and hard to fake with a flat image.', 'img' => 'lv-step-2', 'w' => 200),
            array('title' => '3. Models check depth, texture and motion', 'text' => '2D and 3D models look for signs of a real face — depth, skin texture, light reflections and natural movement — and for signs of paper, screens, masks and generated images.', 'img' => 'lv-step-3', 'w' => 200),
            array('title' => '4. You get a live / not live result', 'text' => 'Your system receives the liveness result with a score, and the best frame is passed on to face matching against the ID photo.', 'img' => 'lv-step-4', 'w' => 200),
        ),
    ),

    /* Блок 5: таблица ТЗ разложена по панелям вкладок (When → «Best for», Checks → «What the user does»); строка «Time for the user» — значения «[ ] s» не заданы: не выводится. Третий H3 — боковая карточка блока. Ссылка на статью блога (декабрь, план) не выводится. */
    'modes' => array(
        'title' => 'Active and Passive Liveness Detection',
        'items' => array(
            array('button' => 'Active liveness', 'title' => 'Active liveness: guided face movement', 'text' => 'The user follows a simple instruction — moving closer to the camera. Active liveness adds a challenge that a static photo or a pre-recorded video cannot answer.', 'when' => 'Banking, high-risk checks', 'checks' => array('Moves closer to the camera')),
            array('button' => 'Passive liveness', 'title' => 'Passive liveness: a single selfie', 'text' => 'The user just takes a selfie; analysis runs in the background. Passive liveness is the fastest option for high-volume, low-risk onboarding.', 'when' => 'Mass-market onboarding', 'checks' => array('Takes one selfie')),
        ),
        'side' => array('title' => 'Which mode to choose', 'text' => 'Use passive liveness where speed matters most and active liveness for higher-risk checks — account opening at a bank, large withdrawals or account recovery. You can switch modes per scenario in the dashboard.'),
    ),

    /* Блок 4 «Deepfake and Injection Attack Detection» — «только если подтверждено»: отложен. Блок 5 «Liveness Detection for KYC, Login and Payments» — login/transfers «только при повторной проверке клиента»: отложен. Блок 6 «Presentation Attack Detection You Can Check» — нет документов и значений APCER/BPCER: отложен. */

    /* Блок 9: колонки таблицы ТЗ → слоты SEA-табов (страна · Rule · Where liveness matters); текст карточки пуст (в ТЗ нет). Singapore — первой (разметка блока рассчитана на неё). */
    'sea' => array(
        'title'  => 'Liveness Rules in Southeast Asia',
        'lead'   => 'Regulators across the region now expect a live face, not just a selfie. Last reviewed: October 2026.',
        'labels' => array('registry' => 'Rule', 'document' => 'Where liveness matters'),
        'ubo_label' => '',
        'items'  => array(
            array('id' => 'singapore', 'label' => 'Singapore', 'registry' => 'MAS guidance on digital onboarding', 'document' => 'Remote onboarding where Singpass Myinfo is not used', 'ubo' => ''),
            array('id' => 'malaysia', 'label' => 'Malaysia', 'registry' => 'BNM e-KYC Policy Document', 'document' => 'Remote onboarding with biometric checks and fraud controls', 'ubo' => ''),
            array('id' => 'indonesia', 'label' => 'Indonesia', 'registry' => 'OJK rules; Dukcapil face matching', 'document' => 'Remote onboarding with face match against national data', 'ubo' => ''),
            array('id' => 'philippines', 'label' => 'Philippines', 'registry' => 'BSP rules on electronic KYC', 'document' => 'Remote onboarding for banks and e-money issuers', 'ubo' => ''),
            array('id' => 'vietnam', 'label' => 'Vietnam', 'registry' => 'SBV Decision 2345 (from July 2024)', 'document' => 'Face authentication against national records for transfers above VND 10 million', 'ubo' => ''),
            array('id' => 'thailand', 'label' => 'Thailand', 'registry' => 'Bank of Thailand measures (from 2023)', 'document' => 'Face scan for mobile banking transfers above THB 50,000', 'ubo' => ''),
        ),
    ),

    /* Блок 10: карточка «Gig and sharing platforms» — «только при поддержке повторной аутентификации»: отложена. */
    'industries' => array(
        'title' => 'Liveness Detection Solutions by Industry',
        'items' => array(
            array('icon' => 'temple', 'title' => 'Banks and digital banks', 'text' => 'Remote account opening and high-value transfers with a live face, not a photo.', 'tags' => array('Remote account opening', 'High-value transfers', 'A live face, not a photo')),
            array('icon' => 'bank-card', 'title' => 'E-wallets and payments', 'text' => 'Stop fake and rented accounts at account upgrade, when users unlock higher limits.', 'tags' => array('Fake and rented accounts', 'Account upgrade', 'Higher limits')),
            array('icon' => 'document', 'title' => 'Digital lending', 'text' => 'Make sure the borrower is real and present before you pay out a loan.', 'tags' => array('Borrower is real and present', 'Before you pay out a loan')),
            array('icon' => 'crypto', 'title' => 'Crypto exchanges', 'text' => 'Block account takeover and multi-accounting with deepfakes at onboarding and withdrawal.', 'tags' => array('Account takeover', 'Multi-accounting', 'Onboarding and withdrawal')),
        ),
    ),

    /* Блок 11: предложение ТЗ разложено по карточкам; цены standalone liveness в ТЗ нет — без цифр. */
    'pricing' => array(
        'title'       => 'Liveness Detection Service Pricing',
        'price_label' => 'BASIC and ADVANCED KYC packages — from ',
        'price'       => '$0.44',
        'price_note'  => 'Document check plus selfie or liveness.',
        'cta'         => 'Calculate your price',
        'plans'       => array(
            array('title' => 'Liveness included', 'text' => 'Liveness is included in our BASIC and ADVANCED KYC packages.', 'btn' => '', 'form' => '', 'cls' => 'kyc-card--accent'),
            array('title' => 'Standalone pricing', 'text' => 'Need liveness on its own, for login or payments? Ask us for standalone pricing.', 'btn' => 'Talk to Sales', 'form' => 'open-callForm', 'cls' => 'kyc-card--filled'),
        ),
    ),

    /* Блок 12: карточка «Works on everyday phones» — заголовок ТЗ, текст сокращён до подтверждённого («Runs in the mobile browser…»; «mid-range and older phones» в ТЗ — после теста на устройствах). Текст карточки о хранении — как в ТЗ (формулировка DPO-зависима). */
    'why' => array(
        'title' => 'Why Choose NeuroVision Liveness Detection Software',
        'items' => array(
            array('title' => 'Three attack levels covered', 'text' => 'From printed photos to professional masks and 3D heads.'),
            array('title' => 'Active and passive modes', 'text' => 'Choose the right balance of speed and security for each scenario.'),
            array('title' => 'Built into KYC', 'text' => 'Liveness, face match and document checks in one session and one API.'),
            array('title' => 'Works on everyday phones', 'text' => 'Runs in the mobile browser, with no app to install.'),
            array('title' => 'No face images kept beyond your settings', 'text' => 'Original images are stored for 3 months by default, then per your plan; you control retention.'),
            array('title' => 'Cloud or on-premise', 'text' => 'Deploy in our cloud or in your own data center.'),
        ),
    ),

    /* Блок 13: третий слайд — без скобки «[подтвердить наличие]» (нативные SDK не заявляются). Пример ответа — «от команды»: не выводится. */
    'api' => array(
        'heading' => 'Liveness Detection API and SDK',
        'slides'  => array(
            array('title' => 'Web SDK and KYC widget', 'subtitle' => '', 'description' => 'Add liveness with the KYC widget — a script tag, an npm package for React or a direct link — and choose active or passive mode in the scenario.'),
            array('title' => 'REST API', 'subtitle' => '', 'description' => 'Create a session, receive the liveness result and score by webhook, and download frames for audits.'),
            array('title' => 'Mobile apps', 'subtitle' => '', 'description' => 'Works in mobile browsers and WebViews.'),
        ),
    ),

    /* Блок 14: предложения ТЗ дословно разложены по карточкам; заголовки h3 и региональный — из слов этих же предложений (как Security на AML). */
    'security' => array(
        'title' => 'Security and Biometric Data Protection',
        'cards' => array(
            array(
                'title' => 'Face images are biometric data',
                'text'  => 'Face images are biometric data. We encrypt them in transit and at rest, process them under GDPR and the privacy laws of our Southeast Asian markets, and let you set how long images are kept.',
            ),
            array(
                'title' => 'ISO/IEC 27001:2022 certified',
                'text'  => 'Our information security management system is certified to ISO/IEC 27001:2022.',
                'marks' => array('iso', 'asib', 'qa'),
                'link'  => array('text' => 'Information security policy', 'href' => '/information-security-policy/'),
            ),
        ),
        'regional' => array(
            'title_plain'  => 'Processed under GDPR and the privacy laws ',
            'title_accent' => 'of our Southeast Asian markets',
            'flags'        => array('eu', 'sg', 'my', 'id', 'ph', 'th', 'vn'),
        ),
    ),

    /* FAQ: отложены «Can liveness detection stop deepfakes?» (блок 6), «Is your liveness detection certified?» (документы iBeta), «How long does a liveness check take?» ([N] s), «Does liveness work on low-end phones?» (тест), «Do you store face images?» (DPO). Хвосты-ссылки не выводятся. */
    'faq' => array(
        'title' => 'Liveness Detection FAQ',
        'items' => array(
            array('question' => 'What is liveness detection?', 'answer' => array('Liveness detection checks that a real, live person is in front of the camera rather than a photo, video, mask or deepfake. It is used together with face matching in remote identity verification.'), 'initial_open' => true),
            array('question' => 'What is the difference between active and passive liveness?', 'answer' => array('Active liveness asks the user to do something, such as move closer to the camera; passive liveness works from a single selfie without instructions. Active is harder to fool, passive is faster.')),
            array('question' => 'What is presentation attack detection?', 'answer' => array('Presentation attack detection (PAD) is the technical term for spotting fake faces shown to a camera — printouts, screens, masks. ISO/IEC 30107-3 is the international standard for testing it.')),
            array('question' => 'How much does liveness detection cost?', 'answer' => array('Liveness is part of our BASIC KYC package, from $0.44 per check including the document check. Contact us for standalone liveness pricing.')),
            array('question' => 'How do I add liveness detection to my app?', 'answer' => array('Turn on liveness in your KYC scenario and add our Web SDK or widget, or use the REST API. Most teams go live in one business day.')),
        ),
    ),
);
?>

<main>

    <?php
    /* 1. Hero (ТЗ, блок 1) — универсальный partial template-parts/kyc-hero-section.php; ≥992 — lv-hero (фото Magnific + HTML-карточка с текстами ТЗ), 768–991.98 и <768 — фото без карточки (lv-hero-tablet / lv-hero-mobile). */
    $nv_hero_facts = array();
    foreach ($nv_page['hero']['facts'] as $nv_fact) {
        $nv_hero_facts[] = array('icon_html' => nv_identity_icon($nv_fact['icon']), 'text' => esc_html($nv_fact['text']));
    }
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'lv-hero', 'w' => 1600, 'h' => 1056, 'alt' => $nv_page['hero']['alt'],
            'laptop'       => array('src' => 'lv-hero-tablet', 'w' => 1600, 'h' => 1056),
            'tablet'       => array('src' => 'lv-hero-tablet', 'w' => 1600, 'h' => 1056),
            'mobile'       => array('src' => 'lv-hero-mobile', 'w' => 720, 'h' => 536),
            'focus'        => '100% 50%',
            'focus_tablet' => '70% 50%',
        ),
        'title'         => esc_html($nv_page['hero']['title']),
        'subtitle'      => esc_html($nv_page['hero']['subtitle']),
        'primary_btn'   => array('text' => 'Try Liveness Detection Free', 'mobile_text' => 'Try Free'),
        'secondary_btn' => array('text' => 'See How It Works', 'mobile_text' => 'How It Works', 'href' => '#how-it-works'),
        'facts'         => $nv_hero_facts,
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Trust strip (ТЗ, блок 2) — template-parts/certs-section.php: подпись ТЗ + чипы из слов ТЗ. */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'lv-trust',
        'title'      => $nv_page['trust']['title'],
        'chip_icon'  => nv_kyc_icon('check', 20),
        'chips'      => $nv_page['trust']['chips'],
    )); ?>

    <?php /* 3. Presentation Attacks Our Liveness Detection Stops (ТЗ, блок 3) — partial idv-checks-section, 3 карточки. */ ?>
    <?php $nv_checks_block('attacks', 'Attacks', $nv_page['attacks']['title'], $nv_page['attacks']['intro'], $nv_page['attacks']['items']); ?>

    <?php /* 4. How Face Liveness Detection Works (ТЗ, блок 4) — template-parts/kyc-steps-section.php. Иконки шагов — Magnific. */ ?>
    <?php get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'          => 'How it works',
        'title'          => $nv_page['steps']['title'],
        'lead'           => $nv_page['steps']['lead'],
        'note'           => '',
        'steps'          => $nv_page['steps']['items'],
        'arrow_icon'     => $nv_arrow,
        'section_id'     => 'how-it-works',
        'step_id_prefix' => 'lv-step',
        'nav_label'      => 'Face liveness detection steps',
    )); ?>

    <?php
    /* 5. Active and Passive Liveness Detection (ТЗ, блок 5) — универсальный partial template-parts/kyc-risk-section.php: две вкладки режимов, третий H3 — боковая карточка. Иконки — свои у каждого режима. */
    $nv_risk_icons = array(nv_kyc_icon('user'), nv_kyc_icon('scan'));
    $nv_risk_tabs  = array();
    foreach ($nv_page['modes']['items'] as $nv_i => $nv_r) {
        $nv_risk_tabs[] = $nv_r + array('icon' => $nv_risk_icons[$nv_i] ?? '');
    }
    get_template_part('template-parts/kyc-risk-section', null, array(
        'badge'        => 'Modes',
        'title'        => $nv_page['modes']['title'],
        'tabs'         => $nv_risk_tabs,
        'when_label'   => 'Best for',
        'checks_label' => 'What the user does',
        'side'         => array(
            'title' => $nv_page['modes']['side']['title'],
            'text'  => $nv_page['modes']['side']['text'],
            'img'   => 'lv-modes',
            'w'     => 245,
            'h'     => 233,
        ),
        'arrow_icon'   => $nv_arrow,
        'tabs_label'   => 'Liveness mode',
    ));
    ?>


    <?php
    /* 9. Liveness Rules in Southeast Asia (ТЗ, блок 9) — partial template-parts/kyc-sea-section (универсальный блок; JS — initKycPage()). */
    $nv_sea_items = array();
    foreach ($nv_page['sea']['items'] as $nv_s) {
        $nv_sea_items[] = array(
            'id'    => $nv_s['id'],
            'label' => $nv_s['label'],
            'text'  => ('' !== $nv_s['ubo']) ? $nv_page['sea']['ubo_label'] . $nv_s['ubo'] : '',
            'rows'  => array(
                array('label' => $nv_page['sea']['labels']['registry'], 'values' => array($nv_s['registry'])),
                array('label' => $nv_page['sea']['labels']['document'], 'values' => array($nv_s['document'])),
            ),
        );
    }
    get_template_part('template-parts/kyc-sea-section', null, array(
        'section_id' => 'southeast-asia',
        'badge'      => 'Southeast Asia',
        'title'      => $nv_page['sea']['title'],
        'lead'       => $nv_page['sea']['lead'],
        'tabs_label' => 'Southeast Asia countries',
        'countries'  => $nv_sea_items,
    ));
    ?>

    <?php /* 10. Liveness Detection Solutions by Industry (ТЗ, блок 10) — template-parts/kyc-industries-section.php, вариант Identity (идентити-теги — фразы ТЗ). */ ?>
    <?php get_template_part('template-parts/kyc-industries-section', null, array(
        'title' => $nv_page['industries']['title'],
        'lead'  => '',
        'items' => $nv_page['industries']['items'],
    )); ?>

    <?php /* Pricing (ТЗ) — template-parts/kyc-pricing-section.php. */ ?>
    <?php get_template_part('template-parts/kyc-pricing-section', null, array(
        'section_id'   => 'pricing',
        'badge'        => 'Pricing',
        'title'        => $nv_page['pricing']['title'],
        'price_prefix' => trim($nv_page['pricing']['price_label']),
        'price'        => $nv_page['pricing']['price'],
        'price_unit'   => 'per check',
        'price_note'   => $nv_page['pricing']['price_note'],
        'cta'          => $nv_page['pricing']['cta'],
        'cta_url'      => home_url('/pricing-matrix/'),
        'arrow_icon'   => $nv_arrow,
        'plans'        => $nv_page['pricing']['plans'],
    )); ?>

    <?php /* 12. Why Choose NeuroVision Liveness Detection Software (ТЗ, блок 12) — второй экземпляр idv-checks-section, карточки h3. */ ?>
    <?php $nv_checks_block('why-choose', '', $nv_page['why']['title'], '', $nv_page['why']['items']); ?>

    <?php /* 13. Liveness Detection API and SDK (ТЗ, блок 13) — template-parts/integration-section.php (зашито: id="integration", «Choose Your Integration Path», кнопка «View documentation» → /docs/). */ ?>
    <?php require_once get_template_directory() . '/inc/integration-preset.php'; ?>
    <?php get_template_part('template-parts/integration-section', null, array_merge(nv_integration_preset(), array(
        'section_id' => 'api',
        'badge'      => 'API',
        'heading'    => $nv_page['api']['heading'],
        'subtitle'   => '',
        'slides'     => $nv_page['api']['slides'],
        'deploy'     => array(),
    ))); ?>

    <?php /* Security: partial template-parts/idv-security-section.php (универсальный блок, тексты — аргументы). */
    get_template_part('template-parts/idv-security-section', null, array(
        'section_id' => 'security',
        'title'      => $nv_page['security']['title'],
        'cards'      => $nv_page['security']['cards'],
        'regional'   => $nv_page['security']['regional'],
    ));
    ?>


    <?php /* 15. Try Liveness Detection Free (ТЗ, блок 15) — template-parts/contacts-section.php без изменений. */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>

    <?php /* 16. Liveness Detection Resources — отложен. FAQ (ТЗ, блок 16) — template-parts/faq-section.php. */ ?>
    <?php get_template_part('template-parts/faq-section', null, array(
        'items'       => $nv_page['faq']['items'],
        'title'       => $nv_page['faq']['title'],
        'description' => '',
    )); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
