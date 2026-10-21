<?php
/*
Template Name: KYB Verification
Template Post Type: page
NV Page Family: identity
*/
get_header();

/*
 * Страница /kyb/ — собрана из блоков библиотеки по ТЗ «KYB» (13.10.2026), вариант А (KYB из существующих модулей).
 * ТЗ: не публиковать, пока продуктовая команда не подтвердит KYB в продукте; блоки варианта Б не ставятся.
 * Регламент — docs/PAGE_BUILDER.md, карта страницы и решения владельца — docs/pages/kyb.md.
 * Тексты в цитатах ТЗ — дословно. Картинки временные (Identity), будущие файлы — в карте.
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
    'hero' => array(
        'title'    => 'KYB Verification: Know Your Business Customers, Directors and Owners',
        'subtitle' => 'Onboard business customers with one KYB flow: check company documents, verify directors and beneficial owners with ID and selfie, and screen the company and its people against sanctions and PEP lists. Business identity verification and KYC on the same platform.',
        'alt'      => 'KYB verification case: company documents, directors and beneficial owners verified, sanctions screening clear',
        /* Факт «[N] registries connected» — вариант Б, не ставится. */
        'facts'    => array(
            array('icon' => 'network-world', 'text' => '195+ countries and territories for documents'),
            array('icon' => 'document-verified', 'text' => 'ID + selfie for every director and owner'),
            array('icon' => 'check-circle', 'text' => 'Sanctions & PEP for company and people'),
        ),
    ),

    /* Логотипы и сертификаты — только после согласия/проверки (В-5). Чипы — слова из hero ТЗ (по просьбе владельца: плашки, как на AML и Liveness). */
    'trust' => array(
        'title' => 'Trusted by 50+ banks, payment companies and platforms.',
        'chips' => array('Company documents', 'Directors', 'Beneficial owners', 'Sanctions & PEP'),
    ),

    /* H3 «Company registry check» — вариант Б. Ссылки-хвосты «→ …» не выводятся (нет стиля ссылок / страницы в плане). */
    'checks' => array(
        'title' => 'What Our KYB Verification Checks',
        'intro' => 'KYB, or Know Your Business, is KYC for companies: you confirm that a business is real and in good standing, find out who controls and owns it, and check those people. NeuroVision covers every part of the check.',
        'items' => array(
            array(
                'title' => 'Company documents',
                'text'  => 'Certificates of incorporation, business registration certificates, articles of association and registry extracts are read automatically, checked for tampering, and their data — name, registration number, address, date — is extracted.',
            ),
            array(
                'title' => 'Directors and authorized representatives',
                'text'  => 'Every director or signatory completes identity verification with an ID and a live selfie, linked to the company case.',
            ),
            array(
                'title' => 'Ultimate beneficial owners',
                'text'  => 'People who own or control the company above your threshold are identified and verified the same way.',
            ),
            array(
                'title' => 'Sanctions and PEP screening for the company and its people',
                'text'  => 'The company name and all its directors and owners are screened against sanctions and PEP lists.',
            ),
        ),
    ),

    /* Шаг 2 — без хвоста варианта Б «and matched against the registry». */
    'steps' => array(
        'title' => 'How Business Verification Works',
        'items' => array(
            array(
                'title' => '1. The company submits its documents',
                'text'  => 'You send the business customer one link. They upload company documents and add their directors and owners.',
                'img'   => 'kyb-step-1',
                'w'     => 200,
            ),
            array(
                'title' => '2. We read and check the documents',
                'text'  => 'Company data is extracted and the documents are checked for signs of tampering.',
                'img'   => 'kyb-step-2',
                'w'     => 200,
            ),
            array(
                'title' => '3. Directors and owners verify their identity',
                'text'  => 'Each person gets their own link, scans their ID and takes a live selfie — from anywhere, on their own phone.',
                'img'   => 'kyb-step-3',
                'w'     => 200,
            ),
            array(
                'title' => '4. Screening, review and decision',
                'text'  => 'The company and its people are screened, your team reviews any flags, and the decision is recorded in one case with a full audit trail.',
                'img'   => 'kyb-step-4',
                'w'     => 200,
            ),
        ),
    ),

    /* Блок 5 «Business Onboarding Without the Back-and-Forth» отложен (К-1). */

    /* Блок 6: текст варианта А в первом H3 (фраза варианта Б не ставится). */
    'ubo' => array(
        'title' => 'UBO Verification: Who Really Owns the Company',
        /* Платформа: четыре карточки слева (как в библиотеке) — фразы ТЗ блока 6 разложены без изменения слов. */
        'top'   => array(
            'title' => 'Identify beneficial owners',
            'text'  => 'A beneficial owner is a person who ultimately owns or controls a company, directly or through other companies.',
            'note'  => 'The business customer declares its owners and the documents that prove them.',
        ),
        'audit' => array('title' => 'Threshold for each market', 'text' => 'You set the threshold for each market.'),
        'pair'  => array(
            array('title' => 'Verify them like any customer', 'text' => 'Each beneficial owner completes ID and selfie verification and is screened against sanctions and PEP lists.'),
            array('title' => 'Ownership thresholds by country', 'text' => 'Most countries define a beneficial owner as someone holding more than 25% — some use lower thresholds.'),
        ),
        'alt'   => 'UBO verification: ownership structure with two beneficial owners identified',
    ),

    /* Блок 7, вариант А (К-2): реестр — справочно, без обещания подключения. */
    'sea' => array(
        'title'  => 'Company Documents Across Southeast Asia',
        'lead'   => 'For information only, not legal advice.',
        'labels' => array('registry' => 'Company registry', 'document' => 'What to ask for'),
        'items'  => array(
            array('id' => 'singapore', 'label' => 'Singapore', 'registry' => 'ACRA (BizFile)', 'document' => 'ACRA business profile', 'ubo' => 'Register of registrable controllers'),
            array('id' => 'malaysia', 'label' => 'Malaysia', 'registry' => 'SSM', 'document' => 'SSM company profile, Form 9 / Section 17 certificate', 'ubo' => 'Beneficial ownership reporting to SSM'),
            array('id' => 'indonesia', 'label' => 'Indonesia', 'registry' => 'Ministry of Law (AHU); OSS', 'document' => 'Deed of establishment, NIB', 'ubo' => 'Beneficial owner disclosure under Perpres 13/2018'),
            array('id' => 'philippines', 'label' => 'Philippines', 'registry' => 'SEC (corporations); DTI (sole proprietors)', 'document' => 'SEC registration, General Information Sheet', 'ubo' => 'Beneficial ownership declaration to SEC'),
            array('id' => 'thailand', 'label' => 'Thailand', 'registry' => 'Department of Business Development (DBD)', 'document' => 'Company affidavit / certificate', 'ubo' => 'Shareholder list; beneficial owner rules for financial institutions'),
            array('id' => 'vietnam', 'label' => 'Vietnam', 'registry' => 'National Business Registration Portal', 'document' => 'Enterprise registration certificate', 'ubo' => 'Beneficial owner information under the 2025 Enterprise Law amendments'),
        ),
        'ubo_label' => 'Beneficial ownership rules: ',
    ),

    /* Блок 8: абзац ТЗ дословно разложен по пяти юрисдикциям карты (решение владельца: блок не из одной карточки);
     * заголовки карточек собраны из слов этих же предложений. Предложение про UK и UAE — общее для двух маркеров. */
    'requirements' => array(
        'title'    => 'KYB Requirements Worldwide: FATF, US, EU, UK and UAE',
        'subtitle' => 'Last reviewed: October 2026.',
        'items'    => array(
            array('id' => 'world', 'label' => 'FATF', 'flag' => 'world', 'title' => 'FATF Recommendations 24 and 25', 'text' => 'FATF Recommendations 24 and 25 require transparency of beneficial ownership for companies and trusts.'),
            array('id' => 'us', 'label' => 'United States', 'flag' => 'us', 'title' => 'United States: FinCEN’s Customer Due Diligence Rule', 'text' => 'In the US, FinCEN’s Customer Due Diligence Rule requires financial institutions to identify the beneficial owners of legal-entity customers.'),
            array('id' => 'eu', 'label' => 'European Union', 'flag' => 'eu', 'title' => 'European Union: AML Directives and AML Regulation', 'text' => 'In the EU, the AML Directives — and from July 2027 the AML Regulation — require identifying beneficial owners above 25%.'),
            array('id' => 'uk', 'label' => 'United Kingdom', 'flag' => 'uk', 'title' => 'United Kingdom: Money Laundering Regulations', 'text' => 'The UK Money Laundering Regulations and the UAE’s beneficial ownership rules set similar duties.'),
            array('id' => 'ae', 'label' => 'United Arab Emirates', 'flag' => 'ae', 'title' => 'United Arab Emirates: beneficial ownership rules', 'text' => 'The UK Money Laundering Regulations and the UAE’s beneficial ownership rules set similar duties.'),
        ),
    ),

    'industries' => array(
        'title' => 'KYB Solutions by Industry',
        'items' => array(
            array(
                'icon'  => 'bank-card',
                'title' => 'Payments, PSPs and merchant onboarding',
                'text'  => 'Verify merchants before they start taking payments, and keep a record for your acquirer and regulator. Merchant verification at the scale of Southeast Asian e-commerce.',
                'tags'  => array('Verify merchants', 'Record for your acquirer and regulator', 'Southeast Asian e-commerce'),
            ),
            array(
                'icon'  => 'building-office',
                'title' => 'Marketplaces and B2B platforms',
                'text'  => 'Seller verification for marketplaces: confirm the business and the person behind it before the first payout.',
                'tags'  => array('Seller verification', 'Confirm the business', 'Before the first payout'),
            ),
            array(
                'icon'  => 'temple',
                'title' => 'Banks and business accounts',
                'text'  => 'Open business accounts remotely with documents, directors’ ID checks and screening in one flow.',
                'tags'  => array('Business accounts', 'Directors’ ID checks', 'Screening in one flow'),
            ),
            array(
                'icon'  => 'crypto',
                'title' => 'Crypto exchanges',
                'text'  => 'Corporate accounts for funds, OTC desks and institutional traders.',
                'tags'  => array('Corporate accounts', 'OTC desks', 'Institutional traders'),
            ),
            array(
                'icon'  => 'document',
                'title' => 'B2B lending and BNPL',
                'text'  => 'Check the company and its guarantors before you lend.',
                'tags'  => array('Check the company', 'Its guarantors', 'Before you lend'),
            ),
        ),
    ),

    /* Блок 10 «Ongoing Business Monitoring» — вариант Б, не ставится. */

    /* К-3: цены нет — без строки цены, одна кнопка «Get a quote» → форма. Предложение ТЗ разложено по композиции блока
       (правило О-1): первая часть — крупной строкой в главную карточку, три составляющих дела — в карточки справа, тексты карточек — из блока 3 ТЗ. */
    'pricing' => array(
        'title'      => 'KYB Service Pricing',
        'price_prefix' => 'KYB is priced',
        'price'      => 'per business case',
        'cta'        => 'Get a quote',
        'plans'      => array(
            array(
                'title' => 'Company document checks',
                'text'  => 'Certificates of incorporation, business registration certificates, articles of association and registry extracts are read automatically and checked for tampering.',
            ),
            array(
                'title' => 'Identity verification for each director and owner',
                'text'  => 'Every director or signatory completes identity verification with an ID and a live selfie, linked to the company case.',
            ),
            array(
                'title' => 'Screening',
                'text'  => 'The company name and all its directors and owners are screened against sanctions and PEP lists.',
            ),
        ),
    ),

    /* Карточка «Built for Southeast Asian companies» — формулировка ТЗ дословно; ТЗ требует подтверждения командой (страница не публикуется до подтверждения KYB). 6 карточек — ровная сетка 3×2 (О-3). */
    'why' => array(
        'title' => 'Why Choose NeuroVision KYB Software',
        'items' => array(
            array('title' => 'KYB and KYC in one platform', 'text' => 'Companies and the people behind them, verified in one place.'),
            array('title' => 'Company documents from 195+ countries and territories', 'text' => 'One document engine for corporate and personal documents.'),
            array('title' => 'Directors verified with face and liveness', 'text' => 'Not just a name on a form: every director passes a live selfie check.'),
            array('title' => 'Sanctions and PEP checks included', 'text' => 'Company names and all related people screened in the same flow.'),
            array('title' => 'Built for Southeast Asian companies', 'text' => 'Registry documents and ownership rules of Singapore, Malaysia, Indonesia, the Philippines, Thailand and Vietnam.'),
            array('title' => 'Cloud or on-premise', 'text' => 'For banks that keep data in-country.'),
        ),
    ),

    /* К-5: Integration со стандартными слайдами партиала; ссылка на /docs/ — зашитая кнопка «View documentation». */
    'api' => array(
        'heading'  => 'KYB API',
        'subtitle' => 'Create a business case, add documents and people, and get the result by webhook — through the same REST API you use for KYC.',
    ),

    /* Блок 14: предложение ТЗ дословно — в первой карточке; заголовки h3 и региональный заголовок собраны из слов
     * этого же предложения (как Security на AML, решение владельца 2026-10-20: блок не из одной карточки). */
    'security' => array(
        'title' => 'Security and Data Protection',
        'cards' => array(
            array(
                'title' => 'Encrypted in transit and at rest',
                'text'  => 'Company and personal data is encrypted in transit and at rest, processed under GDPR and the privacy laws of our Southeast Asian markets, and protected by an ISO/IEC 27001:2022-certified security program.',
            ),
            array(
                'title' => 'ISO/IEC 27001:2022-certified security program',
                'text'  => '',
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

    /* Опубликованы вопросы с ответом в ТЗ; «Which countries…», «How long…», «How do I add…» и вариант Б — отложены. Хвосты-ссылки — В-10. */
    'faq' => array(
        'title' => 'KYB FAQ',
        'items' => array(
            array('question' => 'What is KYB verification?', 'answer' => array('KYB (Know Your Business) verification confirms that a business customer is a real, legally registered company and identifies the people who control and own it. It is the business equivalent of KYC.'), 'initial_open' => true),
            array('question' => 'What is the difference between KYB and KYC?', 'answer' => array('KYC verifies individual customers; KYB verifies companies — and then runs KYC on their directors and beneficial owners.')),
            array('question' => 'What documents do you need to verify a business?', 'answer' => array('Usually a certificate of incorporation or registration, a recent registry extract or business profile, proof of address and ID documents of directors and beneficial owners. Requirements vary by country.')),
            /* К-6: первое предложение ТЗ + фраза варианта А из блока 6. */
            array('question' => 'What is a UBO, and how do you identify one?', 'answer' => array('An ultimate beneficial owner is a person who ultimately owns or controls a company — in many countries, anyone with more than 25%. The business customer declares its owners and the documents that prove them.')),
            array('question' => 'How much does KYB verification cost?', 'answer' => array('Pricing depends on the number of people in each business case and the checks you need. Contact us for a quote.')),
        ),
    ),
);
?>

<main>

    <?php
    /* 1. Hero (ТЗ, блок 1) — универсальный partial template-parts/kyc-hero-section.php; ≥992 — kyb-hero (фото Magnific 4k + HTML-карточка «Sample Trading Pte. Ltd.»), 992–1199, 768–991 и <768 — фото без карточки (kyb-hero-laptop / kyb-hero-tablet с лицом правее / kyb-hero-mobile). */
    $nv_hero_facts = array();
    foreach ($nv_page['hero']['facts'] as $nv_fact) {
        $nv_hero_facts[] = array('icon_html' => nv_identity_icon($nv_fact['icon']), 'text' => esc_html($nv_fact['text']));
    }
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'kyb-hero', 'w' => 1600, 'h' => 1056, 'alt' => $nv_page['hero']['alt'],
            'laptop'       => array('src' => 'kyb-hero-laptop', 'w' => 1600, 'h' => 1056),
            'tablet'       => array('src' => 'kyb-hero-tablet', 'w' => 1600, 'h' => 1056),
            'mobile'       => array('src' => 'kyb-hero-mobile', 'w' => 720, 'h' => 536),
            'focus'        => '100% 50%',
            'focus_tablet' => '100% 50%',
        ),
        'title'         => esc_html($nv_page['hero']['title']),
        'subtitle'      => esc_html($nv_page['hero']['subtitle']),
        'primary_btn'   => array('text' => 'Start KYB Verification', 'mobile_text' => 'Start KYB'),
        'secondary_btn' => array('text' => 'See How It Works', 'mobile_text' => 'How It Works', 'href' => '#how-it-works'),
        'facts'         => $nv_hero_facts,
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Trust strip (ТЗ, блок 2) — template-parts/certs-section.php, без знаков; плашки — слова hero ТЗ. */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'kyb-trust',
        'title'      => $nv_page['trust']['title'],
        'chip_icon'  => nv_kyc_icon('check', 20),
        'chips'      => $nv_page['trust']['chips'],
    )); ?>

    <?php get_template_part('template-parts/idv-checks-section', null, array(
        'section_id' => 'checks',
        'badge' => 'Checks',
        'title' => $nv_page['checks']['title'],
        'intro' => $nv_page['checks']['intro'],
        'items' => $nv_page['checks']['items'],
    )); ?>

    <?php /* 4. How Business Verification Works (ТЗ, блок 4) — template-parts/kyc-steps-section.php. Lead и note — нет текста в ТЗ. Картинки шагов — kyb-step-1…4 (Magnific 4k). */ ?>
    <?php get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'          => 'How it works',
        'title'          => $nv_page['steps']['title'],
        'lead'           => '',
        'note'           => '',
        'steps'          => $nv_page['steps']['items'],
        'arrow_icon'     => $nv_arrow,
        'section_id'     => 'how-it-works',
        'step_id_prefix' => 'kyb-step',
        'nav_label'      => 'Business verification steps',
    )); ?>

    <?php
    /* 6. UBO Verification (ТЗ, блок 6) — template-parts/kyc-platform-section.php, вариант Identity.
     * верхняя карточка, lead и summary не выводятся (В-5); схема владения — HTML-макет kyb-ubo-screen. */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'UBO',
        'title'       => $nv_page['ubo']['title'],
        'lead'        => '',
        'top'         => $nv_platform_top($nv_page['ubo']['top']),
        'audit'       => array('title' => $nv_page['ubo']['audit']['title'], 'text' => $nv_page['ubo']['audit']['text'], 'img' => 'kyb-ubo-audit', 'w' => 255),
        'pair'        => $nv_page['ubo']['pair'],
        'screen'      => array('image' => 'kyb-ubo-screen', 'alt' => $nv_page['ubo']['alt']),
    ));
    ?>

    <?php
    /* 7. Company Documents Across Southeast Asia (ТЗ, блок 7, вариант А) — partial template-parts/kyc-sea-section (универсальный блок; JS — initKycPage()). */
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

    <?php
    /* 8. KYB Requirements Worldwide (ТЗ, блок 8), без бейджа (нет в page-nav ТЗ) — template-parts/kyc-compliance-section.php (универсальный блок). Позиции маркеров — доли области карты 738x630. */
    $nv_comp_pos = array(
        'us'    => array(13.0, 22.5),
        'uk'    => array(46.5, 15.5),
        'eu'    => array(59.0, 25.5),
        'ae'    => array(76.4, 40.3),
        'world' => array(92.8, 88.4),
    );
    $nv_comp_args = array(
        'badge'      => '',
        'section_id' => 'requirements',
        'title'      => $nv_page['requirements']['title'],
        'note'       => $nv_page['requirements']['subtitle'],
        'markers'    => array(),
    );
    foreach ($nv_page['requirements']['items'] as $nv_c) {
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

    <?php /* 9. KYB Solutions by Industry (ТЗ, блок 9) — template-parts/kyc-industries-section.php, вариант Identity, теги — фразы ТЗ. */ ?>
    <?php get_template_part('template-parts/kyc-industries-section', null, array(
        'title'    => $nv_page['industries']['title'],
        'lead'     => '',
        'items'    => $nv_page['industries']['items'],
    )); ?>

    <?php /* 11. KYB Service Pricing (ТЗ, блок 11) — template-parts/kyc-pricing-section.php (без цены; три карточки составляющих дела). */ ?>
    <?php get_template_part('template-parts/kyc-pricing-section', null, array(
        'section_id' => 'pricing',
        'badge'      => 'Pricing',
        'title'      => $nv_page['pricing']['title'],
        'price_prefix' => $nv_page['pricing']['price_prefix'],
        'price'      => $nv_page['pricing']['price'],
        'cta'        => $nv_page['pricing']['cta'],
        'cta_form'   => 'open-callForm2',
        'plans'      => $nv_page['pricing']['plans'],
        'arrow_icon' => $nv_arrow,
    )); ?>

    <?php get_template_part('template-parts/idv-checks-section', null, array(
        'section_id' => 'why-choose',
        'title' => $nv_page['why']['title'],
        'items' => $nv_page['why']['items'],
    )); ?>

    <?php /* 13. KYB API (ТЗ, блок 13) — template-parts/integration-section.php со стандартными слайдами (К-5). */ ?>
    <?php require_once get_template_directory() . '/inc/integration-preset.php'; ?>
    <?php get_template_part('template-parts/integration-section', null, array_merge(nv_integration_preset(), array(
        'section_id' => 'api',
        'badge'      => 'API',
        'heading'    => $nv_page['api']['heading'],
        'subtitle'   => $nv_page['api']['subtitle'],
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

    <?php /* 15. Start KYB Verification (ТЗ, блок 15) — template-parts/contacts-section.php без изменений (В-8). */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>

    <?php /* 16. KYB Resources — отложен (нет опубликованных материалов). FAQ (ТЗ, блок 16) — template-parts/faq-section.php. */ ?>
    <?php get_template_part('template-parts/faq-section', null, array(
        'items'       => $nv_page['faq']['items'],
        'title'       => $nv_page['faq']['title'],
        'description' => '',
    )); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
