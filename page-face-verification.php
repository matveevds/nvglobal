<?php
/*
Template Name: Face Verification
Template Post Type: page
NV Page Family: identity
*/
get_header();

/*
 * Страница /face-verification/ — собрана из блоков библиотеки по ТЗ «Face Verification» (13.10.2026).
 * Образец — /kyc/ (page-kyc.php). Регламент — docs/PAGE_BUILDER.md, карта и решения сборщика — docs/pages/face-verification.md.
 * Тексты в цитатах ТЗ — дословно. Картинки fv-*: фото Magnific и HTML-макеты (тексты ТЗ, тестовые данные, лица — схематичные силуэты).
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

/* Верхняя карточка Platform Bento: аргумент `top` партиала kyc-platform-section.php. */
$nv_platform_top = static function (array $c): array {
    return array(
        'title'     => $c['title'],
        'text'      => $c['text'],
        'note'      => $c['note'],
        'note_icon' => nv_identity_icon('swap'),
    );
};

/* Весь контент страницы — здесь, одним массивом, в порядке блоков ТЗ. */
$nv_page = array(
    /* Факт «[0.1 s] per comparison» в ТЗ в скобках (требует подтверждения) — не ставится; четвёртая плашка («Our own face engine») — H4 блока 13 ТЗ, чтобы плашки были 280×190, как на /kyc/. */
    'hero' => array(
        'title'    => 'Face Verification: Match Selfies to IDs and Find Duplicate Accounts',
        'subtitle' => 'Facial verification that answers one question — is this the same person? Match a live selfie to the ID photo, confirm returning customers and search your whole user base for duplicates with one face engine and one API.',
        'alt'      => 'Face verification: a selfie matched to an ID photo and a duplicate account found in the user base',
        'facts'    => array(
            array('icon' => 'scan', 'text' => '99.74% face match accuracy in NIST testing'),
            array('icon' => 'globe', 'text' => '1:1 + 1:N in one engine'),
            array('icon' => 'shield', 'text' => 'Liveness built in'),
            array('icon' => 'document', 'text' => 'Our own face engine'),
        ),
    ),

    /* Блок 2. «NIST FRTE» (без логотипа), ISO/GDPR и логотипы клиентов — после проверки/согласия: не ставятся. Чипы — слова ТЗ (заголовки блока 13). */
    'trust' => array(
        'title' => 'Face technology tested by NIST and trusted by banks, fintechs and exchanges.',
        'chips' => array('99.74% accuracy in NIST testing', '1:1 and 1:N in one engine', 'Built-in liveness', 'Cloud, on-premises or hybrid'),
    ),

    /* Ссылки «→ Document verification», «→ Liveness & Face Authentication» не выводятся (нет стиля ссылок в карточках). */
    'what' => array(
        'title' => 'What Face Verification Does',
        'intro' => 'Face verification compares faces to confirm identity. It works one-to-one — is this selfie the person on the ID? — and one-to-many — have we seen this face before?',
        'items' => array(
            array('title' => 'Selfie vs ID photo (1:1)', 'text' => 'Selfie verification at onboarding: the live selfie is matched to the photo on the passport, ID card or driver’s license.'),
            array('title' => 'Returning customers (1:1)', 'text' => 'Re-verify a known customer by matching a new selfie to the face saved at onboarding — for account recovery, high-risk changes or payouts.'),
            array('title' => 'Search across your users (1:N)', 'text' => 'A new face is searched against all your existing customers, so one person cannot open ten accounts under ten names.'),
            array('title' => 'Your own face blacklist', 'text' => 'Upload faces of known fraudsters; a match blocks the session automatically.'),
        ),
    ),

    'steps' => array(
        'title' => 'How Face Matching Works',
        'lead'  => 'A fraction of a second per comparison, a clear score for your rules.',
        'items' => array(
            array('title' => '1. Face found and checked for quality', 'text' => 'The face is detected, aligned and checked for blur, lighting, angle and covered features before it is used.', 'img' => 'fv-step-1', 'w' => 200),
            array('title' => '2. A face template is built', 'text' => 'A neural network turns the face into a compact numeric template — not a photo.', 'img' => 'fv-step-2', 'w' => 200),
            array('title' => '3. Templates are compared', 'text' => 'The template is compared with the ID photo, the customer’s saved face or your whole database.', 'img' => 'fv-step-3', 'w' => 200),
            array('title' => '4. Match or no match, by your threshold', 'text' => 'You get a similarity score and a decision based on the threshold you set — stricter for payouts, looser for low-risk steps.', 'img' => 'fv-step-4', 'w' => 200),
        ),
    ),

    /* Блок 5. H3 «Tested on Asian faces» — «только при данных»: не ставится. Трек, набор данных, метрика и дата NIST в ТЗ — от команды: не ставятся. Вторая карточка — слова ячеек таблицы ТЗ (определённые значения). */
    'accuracy' => array(
        'title' => 'Accuracy You Can Check: 99.74% in NIST Testing',
        /* Платформа: четыре карточки слева (как в библиотеке) — фразы и ячейки таблицы ТЗ блока 5 разложены без изменения слов.
         * H3 «Tested on Asian faces» — «только при данных»: не ставится; трек/набор/метрика/дата NIST — от команды: не ставятся. */
        'top'   => array(
            'title' => 'What the NIST result means',
            'text'  => 'NIST, the US National Institute of Standards and Technology, runs the Face Recognition Technology Evaluation (FRTE) — the best-known independent benchmark for face recognition.',
            'note'  => 'Our algorithm reached 99.74% accuracy and placed in the global Top-24.',
        ),
        'audit' => array('title' => 'Face match accuracy', 'text' => '99.74% in NIST testing.'),
        'pair'  => array(
            array('title' => 'Reliable with glasses, beards, masks and low light', 'text' => 'Accuracy holds when customers change their hairstyle, grow a beard, wear glasses or a medical mask, or take a selfie in a dim room.'),
            array('title' => 'Global ranking', 'text' => 'Top-24 — NIST FRTE.'),
        ),
        'alt'   => 'Face match accuracy 99.74% in NIST testing, global ranking Top-24',
    ),

    'dup' => array(
        'title' => 'One Person, One Account: 1:N Duplicate Detection',
        'cards' => array(
            array('title' => 'Promo and bonus abuse', 'text' => 'Stop the same person from claiming welcome bonuses again and again with new accounts.'),
            array('title' => 'Money mule and fake accounts', 'text' => 'Accounts opened by one person under several identities are a common sign of mule networks — a growing concern for banks and e-wallets across Southeast Asia.'),
            array('title' => 'Loan stacking', 'text' => 'Catch borrowers who apply under different names to take several loans at once.'),
        ),
        /* Вводный абзац ТЗ, разбитый по предложениям без изменения слов. */
        'promo' => array(
            'title' => 'Fraudsters reuse their own face with different names and documents.',
            'text'  => 'A 1:N search compares every new face with your entire customer base and flags anyone who is already there.',
        ),
    ),

    /* Блок 7: абзац ТЗ разложен по предложениям на три карточки; заголовки — слова этих же предложений. */
    'live' => array(
        'title' => 'Face Verification Plus Liveness',
        /* Платформа: абзац ТЗ блока 7 разложен по предложениям и их частям (слова не менялись) на четыре карточки. */
        'top'   => array(
            'title' => 'Face match',
            'text'  => 'A face match only proves that two images show the same face.',
            'note'  => 'Not a photo, a screen or a deepfake.',
        ),
        'audit' => array('title' => 'Liveness detection', 'text' => 'Liveness detection proves that the face belongs to a real person in front of the camera.'),
        'pair'  => array(
            array('title' => 'Same step', 'text' => 'Every face verification can run with liveness in the same step.'),
            array('title' => 'Real person', 'text' => 'A real person in front of the camera.'),
        ),
        'alt'   => 'Face match and liveness check in one step: same face, real person, approved',
    ),

    'beyond' => array(
        'title' => 'Face Checks Beyond Matching',
        'items' => array(
            array('title' => 'Age from the face vs date of birth', 'text' => 'Compare the age the face suggests with the date of birth on the document, so a borrowed ID stands out.'),
            array('title' => 'Gender vs the document', 'text' => 'Flag a mismatch between the face and the gender on the ID.'),
            array('title' => 'A second face in the frame', 'text' => 'Detect someone else in the shot, a common sign of coached or assisted fraud.'),
            array('title' => 'Masks and accessories', 'text' => 'Detect medical masks, glasses and other accessories that affect the check.'),
        ),
    ),

    /* Блок 9: Integration со стандартным оформлением; примера JSON в блоке нет, кнопки зашиты («View documentation» → /docs/). */
    'api' => array(
        'heading' => 'Face Recognition API for Developers',
        'slides'  => array(
            array('title' => 'Persons and person lists', 'subtitle' => '', 'description' => 'Create persons and person lists — for example, your customers, staff or a blacklist — and keep them up to date through the API.'),
            array('title' => 'Data sources', 'subtitle' => '', 'description' => 'Group face data by source and manage it separately.'),
            array('title' => 'Compare, search and enrol', 'subtitle' => '', 'description' => 'Compare two faces, search a face across a list, or add new images to a person to improve matching.'),
        ),
    ),

    /* Блок 10: колонки таблицы ТЗ → слоты SEA-табов (страна · When a face match is expected · Matched against). Справочно: описание требований, не обещание интеграций. */
    'sea' => array(
        'title'  => 'Face Verification in Southeast Asia',
        'lead'   => 'Regulators across the region expect remote onboarding to match the customer’s face to an official photo. Last reviewed: October 2026.',
        'labels' => array('registry' => 'When a face match is expected', 'document' => 'Matched against'),
        'ubo_label' => '',
        'items'  => array(
            array('id' => 'singapore', 'label' => 'Singapore', 'registry' => 'Remote onboarding where Singpass Myinfo is not used (MAS)', 'document' => 'ID or passport photo', 'ubo' => ''),
            array('id' => 'malaysia', 'label' => 'Malaysia', 'registry' => 'Remote onboarding under the BNM e-KYC Policy Document', 'document' => 'ID photo (MyKad / passport)', 'ubo' => ''),
            array('id' => 'indonesia', 'label' => 'Indonesia', 'registry' => 'Remote onboarding under OJK rules', 'document' => 'ID photo; national population data where the institution has access', 'ubo' => ''),
            array('id' => 'philippines', 'label' => 'Philippines', 'registry' => 'Electronic KYC by banks and e-money issuers (BSP)', 'document' => 'ID photo; PhilSys authentication where available', 'ubo' => ''),
            array('id' => 'vietnam', 'label' => 'Vietnam', 'registry' => 'Account opening; transfers above VND 10 million (SBV Decision 2345)', 'document' => 'Chip ID photo / national population data', 'ubo' => ''),
            array('id' => 'thailand', 'label' => 'Thailand', 'registry' => 'Remote onboarding; large mobile banking transfers (Bank of Thailand)', 'document' => 'ID card / DOPA data', 'ubo' => ''),
        ),
    ),

    'industries' => array(
        'title' => 'Face Verification Solutions by Industry',
        'items' => array(
            array('icon' => 'temple', 'title' => 'Banks and digital banks', 'text' => 'Selfie-to-ID at account opening and face re-checks before high-risk changes.', 'tags' => array('Selfie-to-ID', 'Account opening', 'Face re-checks')),
            array('icon' => 'bank-card', 'title' => 'E-wallets and payments', 'text' => 'One person, one wallet: 1:N search at account upgrade.', 'tags' => array('One person, one wallet', '1:N search', 'Account upgrade')),
            array('icon' => 'document', 'title' => 'Digital lending', 'text' => 'Stop loan stacking and borrowed identities.', 'tags' => array('Loan stacking', 'Borrowed identities')),
            array('icon' => 'crypto', 'title' => 'Crypto exchanges', 'text' => 'Block multi-accounting before the first deposit.', 'tags' => array('Multi-accounting', 'Before the first deposit')),
            array('icon' => 'building-office', 'title' => 'Gig and delivery platforms', 'text' => 'Confirm that the driver or courier on shift is the one who passed verification.', 'tags' => array('Driver or courier on shift', 'Passed verification')),
            array('icon' => 'scan', 'title' => 'Telecom and SIM registration', 'text' => 'Match the SIM buyer’s face to the ID.', 'tags' => array('SIM buyer’s face', 'Match to the ID')),
        ),
    ),

    /* Блок 12: предложение ТЗ разложено по карточкам; цена отдельного Face API в ТЗ — «уточнить»: без цифр. */
    'pricing' => array(
        'title'       => 'Face Verification Service Pricing',
        'price_label' => 'BASIC package — from ',
        'price'       => '$0.44',
        'price_note'  => 'Document recognition plus selfie or liveness, face comparison and checks against your person lists.',
        'cta'         => 'Calculate your price',
        'plans'       => array(
            array('title' => 'Face matching included', 'text' => 'Face matching is included in our BASIC package.', 'btn' => '', 'form' => '', 'cls' => 'kyc-card--accent'),
            array('title' => 'Face API pricing', 'text' => 'Need face search or face matching on its own via API? Ask us for API pricing.', 'btn' => 'Talk to Sales', 'form' => 'open-callForm', 'cls' => 'kyc-card--filled'),
        ),
    ),

    /* Карточка 1 — «99.74% accuracy in NIST testing» (текст «Independent results, not lab claims.») — как в ТЗ; ссылка «→ /neuropay/» не выводится. */
    'why' => array(
        'title' => 'Why Choose NeuroVision Face Verification Software',
        'items' => array(
            array('title' => '99.74% accuracy in NIST testing', 'text' => 'Independent results, not lab claims.'),
            array('title' => '1:1 and 1:N in one engine', 'text' => 'Selfie checks, re-verification and duplicate search with one API.'),
            array('title' => 'Our own face engine', 'text' => 'No third-party licenses.'),
            array('title' => 'Built-in liveness', 'text' => 'Deepfake- and injection-resistant checks in the same step.'),
            array('title' => 'Cloud, on-premises or hybrid', 'text' => 'Biometric data never has to leave your jurisdiction.'),
            array('title' => 'One API for KYC, login and payments', 'text' => 'The same engine powers onboarding, face login and NeuroPay.'),
        ),
    ),

    /* Блок 14 «Trusted by Banks, Fintechs and Exchanges» — только реальные клиенты с согласием: отложен. */

    /* Блок 15: «формулировки от DPO». H3 «Templates, not photos» — «по ответу DPO»: не ставится. Региональный заголовок — слова H4 блока 13. */
    'privacy' => array(
        'title' => 'Biometric Data Privacy',
        'cards' => array(
            array('title' => 'You decide what is stored and for how long', 'text' => 'Original images are kept for 3 months by default, then per your plan.'),
            array('title' => 'Data stays in your jurisdiction', 'text' => 'On-premises or hybrid deployment keeps templates and personal data in your country.'),
        ),
        'regional' => array(
            'title_plain'  => 'Biometric data never has to leave ',
            'title_accent' => 'your jurisdiction',
            'flags'        => array('eu', 'sg', 'my', 'id', 'ph', 'th', 'vn'),
        ),
    ),

    /* FAQ: отложены «Does it work with glasses, beards or masks?» (ответ — «по подтверждённым данным») и «Do you store face images?» (ответ — от DPO). Хвосты-ссылки не выводятся. */
    'faq' => array(
        'title' => 'Face Verification FAQ',
        'items' => array(
            array('question' => 'What is face verification?', 'answer' => array('Face verification confirms that two face images belong to the same person — for example, a live selfie and the photo on an ID. It is a core step of remote identity verification.'), 'initial_open' => true),
            array('question' => 'What is the difference between face verification and face recognition?', 'answer' => array('Face verification checks whether a face matches one specific person (1:1). Face recognition, or identification, searches for a face among many (1:N). NeuroVision does both with one engine.')),
            array('question' => 'What is the difference between 1:1 and 1:N matching?', 'answer' => array('1:1 compares a face with one reference image; 1:N searches a face across a list or database — useful for finding duplicate accounts and blacklisted users.')),
            array('question' => 'How accurate is your face matching?', 'answer' => array('Our algorithm reached 99.74% accuracy in NIST FRTE testing and ranks in the global Top-24.')),
            array('question' => 'Can face verification be fooled by a photo or a deepfake?', 'answer' => array('Not when it runs with liveness detection, which confirms a real person is in front of the camera.')),
            array('question' => 'Why does face verification fail, and how do I reduce failures?', 'answer' => array('Most failures come from poor capture: low light, blur, a covered face or a worn ID photo. Guided capture, quality checks before matching and a threshold tuned to your risk reduce failed checks.')),
            array('question' => 'How much does face verification cost?', 'answer' => array('Face matching is part of our BASIC KYC package, from $0.44 per check including the document check. Contact us for face API pricing.')),
            array('question' => 'How do I integrate face verification?', 'answer' => array('Use our Web SDK, iOS and Android SDKs or the REST API — the same integration as our KYC checks.')),
        ),
    ),
);
?>

<main>

    <?php
    /* 1. Hero (ТЗ, блок 1) — универсальный partial template-parts/kyc-hero-section.php. Светлое дневное фото Magnific + HTML-карточка «Face match»
     * (тексты ТЗ) на fhd и desktop; кадры fhd / desktop / tablet, на мобильной — тот же вертикальный кадр. */
    $nv_hero_facts = array();
    foreach ($nv_page['hero']['facts'] as $nv_fact) {
        $nv_hero_facts[] = array('icon_html' => nv_kyc_icon($nv_fact['icon']), 'text' => esc_html($nv_fact['text']));
    }
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'fv-hero-tablet', 'w' => 776, 'h' => 872, 'alt' => $nv_page['hero']['alt'],
            'fhd'          => array('src' => 'fv-hero-fhd-v2', 'w' => 1856, 'h' => 872),
            'desktop'      => array('src' => 'fv-hero-desktop-v2', 'w' => 1376, 'h' => 732),
            'laptop'       => array('src' => 'fv-hero-laptop-v2', 'w' => 1136, 'h' => 732),
            'tablet'       => array('src' => 'fv-hero-tablet', 'w' => 776, 'h' => 872),
            'mobile'       => array('src' => 'fv-hero-tablet', 'w' => 776, 'h' => 872),
            'focus'        => '100% 50%',
            'focus_mobile' => '50% 40%',
        ),
        'title'         => esc_html($nv_page['hero']['title']),
        'subtitle'      => esc_html($nv_page['hero']['subtitle']),
        'primary_btn'   => array('text' => 'Try Face Verification Free'),
        'secondary_btn' => array('text' => 'See How It Works', 'href' => '#how-it-works'),
        'facts'         => $nv_hero_facts,
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Trust strip (ТЗ, блок 2) — template-parts/certs-section.php: подпись ТЗ + чипы из слов ТЗ. */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'fv-trust',
        'title'      => $nv_page['trust']['title'],
        'chip_icon'  => nv_kyc_icon('check', 20),
        'chips'      => $nv_page['trust']['chips'],
    )); ?>

    <?php /* 3. What Face Verification Does (ТЗ, блок 3) — partial idv-checks-section. */ ?>
    <?php $nv_checks_block('what', 'What it does', $nv_page['what']['title'], $nv_page['what']['intro'], $nv_page['what']['items']); ?>

    <?php /* 4. How Face Matching Works (ТЗ, блок 4) — template-parts/kyc-steps-section.php. Иконки шагов — Magnific. */ ?>
    <?php get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'          => 'How it works',
        'title'          => $nv_page['steps']['title'],
        'lead'           => $nv_page['steps']['lead'],
        'note'           => '',
        'steps'          => $nv_page['steps']['items'],
        'arrow_icon'     => $nv_arrow,
        'section_id'     => 'how-it-works',
        'step_id_prefix' => 'fv-step',
        'nav_label'      => 'Face matching steps',
    )); ?>

    <?php
    /* 5. Accuracy You Can Check (ТЗ, блок 5) — template-parts/kyc-platform-section.php; экран — HTML-макет «99.74% / Top-24 / NIST FRTE». */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'Accuracy',
        'title'       => $nv_page['accuracy']['title'],
        'lead'        => '',
        'top'         => $nv_platform_top($nv_page['accuracy']['top']),
        'audit'       => array('title' => $nv_page['accuracy']['audit']['title'], 'text' => $nv_page['accuracy']['audit']['text'], 'img' => 'fv-accuracy-audit', 'w' => 255),
        'pair'        => $nv_page['accuracy']['pair'],
        'screen'      => array('image' => 'fv-acc-screen', 'alt' => $nv_page['accuracy']['alt']),
    ));
    ?>

    <?php /* 6. One Person, One Account (ТЗ, блок 6) — template-parts/idv-benefits-section.php; промо-картинка — существующий маскот с лупой (подходит по смыслу, §6). */ ?>
    <?php get_template_part('template-parts/idv-benefits-section', null, array(
        'section_id' => 'duplicates',
        'badge'      => 'Duplicates',
        'title'      => $nv_page['dup']['title'],
        'icon'       => nv_identity_icon('check-circle'),
        'items'      => $nv_page['dup']['cards'],
        'promo'      => array(
            'title' => $nv_page['dup']['promo']['title'],
            'text'  => $nv_page['dup']['promo']['text'],
            'img'   => 'identity-benefits-fraud',
        ),
    )); ?>

    <?php
    /* 7. Face Verification Plus Liveness (ТЗ, блок 7) — template-parts/kyc-platform-section.php; экран — HTML-макет «face match + liveness». */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'Liveness',
        'title'       => $nv_page['live']['title'],
        'lead'        => '',
        'top'         => $nv_platform_top($nv_page['live']['top']),
        'audit'       => array('title' => $nv_page['live']['audit']['title'], 'text' => $nv_page['live']['audit']['text'], 'img' => 'fv-live-audit', 'w' => 255),
        'pair'        => $nv_page['live']['pair'],
        'screen'      => array('image' => 'fv-live-screen', 'alt' => $nv_page['live']['alt']),
    ));
    ?>

    <?php /* 8. Face Checks Beyond Matching (ТЗ, блок 8) — partial idv-checks-section, 4 карточки. */ ?>
    <?php $nv_checks_block('beyond', 'Face checks', $nv_page['beyond']['title'], '', $nv_page['beyond']['items']); ?>

    <?php /* 9. Face Recognition API for Developers (ТЗ, блок 9) — template-parts/integration-section.php (зашито: id="integration", «Choose Your Integration Path»). */ ?>
    <?php require_once get_template_directory() . '/inc/integration-preset.php'; ?>
    <?php get_template_part('template-parts/integration-section', null, array_merge(nv_integration_preset(), array(
        'section_id' => 'api',
        'badge'      => 'API',
        'heading'    => $nv_page['api']['heading'],
        'subtitle'   => '',
        'slides'     => $nv_page['api']['slides'],
        'deploy'     => array(),
    ))); ?>

    <?php
    /* 10. Face Verification in Southeast Asia (ТЗ, блок 10) — partial template-parts/kyc-sea-section (универсальный блок; JS — initKycPage()). */
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

    <?php /* 11. Face Verification Solutions by Industry (ТЗ, блок 11) — template-parts/kyc-industries-section.php, вариант Identity (идентити-теги — фразы ТЗ). */ ?>
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

    <?php /* 13. Why Choose NeuroVision Face Verification Software (ТЗ, блок 13) — второй экземпляр idv-checks-section, карточки h3. */ ?>
    <?php $nv_checks_block('why-choose', '', $nv_page['why']['title'], '', $nv_page['why']['items']); ?>

    <?php /* Security: partial template-parts/idv-security-section.php (универсальный блок, тексты — аргументы). */
    get_template_part('template-parts/idv-security-section', null, array(
        'section_id' => 'security',
        'title'      => $nv_page['privacy']['title'],
        'cards'      => $nv_page['privacy']['cards'],
        'regional'   => $nv_page['privacy']['regional'],
    ));
    ?>


    <?php /* 16. Try Face Verification Free (ТЗ, блок 16) — template-parts/contacts-section.php без изменений. */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>

    <?php /* 17. Face Verification Resources — отложен. 18. FAQ (ТЗ, блок 18) — template-parts/faq-section.php. */ ?>
    <?php get_template_part('template-parts/faq-section', null, array(
        'items'       => $nv_page['faq']['items'],
        'title'       => $nv_page['faq']['title'],
        'description' => '',
    )); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
