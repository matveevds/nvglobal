<?php
/*
Template Name: AML Screening
Template Post Type: page
NV Page Family: identity
*/
get_header();

/*
 * Страница /aml/ — собрана из блоков библиотеки по ТЗ «AML Screening» (13.10.2026).
 * Регламент — docs/PAGE_BUILDER.md, карта страницы и решения владельца — docs/pages/aml.md.
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
        'title'    => 'Automated AML Screening: Sanctions and PEP Checks at Onboarding',
        'subtitle' => 'Run AML checks on every new customer in the same session as their ID and selfie. Our AML screening software checks names against EU, OFAC, UK and UN sanctions lists, terrorist lists and politically exposed persons, and sends possible matches to your team for review.',
        'alt'      => 'AML screening result: a customer checked against EU, OFAC, UK and UN sanctions lists and PEP data with no matches',
        /* Факт «50+ countries' lists» отложен до ответа команды (карта, В-2). */
        'facts'    => array(
            array('icon' => 'network-world', 'text' => 'EU · OFAC · UK · UN sanctions lists'),
            array('icon' => 'document-verified', 'text' => 'PEP screening'),
            array('icon' => 'crypto', 'text' => '$0.40 per screening check'),
        ),
    ),

    'trust' => array(
        'title'  => 'Trusted by 50+ banks, fintechs and exchanges for KYC and AML checks.',
        'tokens' => array('Sanctions', 'PEP', 'Watchlists'),
    ),

    'checks' => array(
        'title' => 'What NeuroVision AML Screening Checks',
        'intro' => 'AML screening means checking a customer against the lists regulators expect you to know about before you open an account: sanctions, terrorist lists and politically exposed persons. NeuroVision runs these AML checks automatically for every customer, using the name, date of birth and nationality from their verified ID.',
        /* H3 «National lists in 50+ countries» и «Adverse media screening» — отложены до подтверждения. */
        'items' => array(
            array(
                'title' => 'Sanctions screening: EU, OFAC, UK and UN lists',
                'text'  => 'Sanctions screening checks whether a customer is subject to financial sanctions. We screen against the EU consolidated list, the US OFAC Specially Designated Nationals list, UK sanctions lists and the UN Security Council consolidated list.',
            ),
            array(
                'title' => 'Terrorist lists and watchlists',
                'text'  => 'Customers are also checked against terrorist lists and other watchlists that regulators require in your markets.',
            ),
            array(
                'title' => 'PEP screening: politically exposed persons',
                'text'  => 'A PEP check shows whether a customer holds, or recently held, a prominent public role — or is a close family member or associate of such a person. A PEP match is not a reason to refuse a customer, but it triggers enhanced due diligence.',
            ),
        ),
    ),

    'steps' => array(
        'title' => 'How AML Screening Works',
        'lead'  => 'Seconds for the customer, a documented decision for your compliance team.',
        'items' => array(
            array(
                'title' => '1. Data comes from a verified ID, not a typed form',
                'text'  => 'The customer’s name, date of birth and nationality are read from the ID document they just verified — so you screen the real person, not a typo or a made-up name.',
                'img'   => 'identity-step-icon',
                'w'     => 200,
            ),
            array(
                'title' => '2. Names are matched against every list at once',
                'text'  => 'The name is compared with all sanctions, PEP and watchlist entries in one request, allowing for spelling variants and transliteration, and narrowed down by date of birth and nationality.',
                'img'   => 'aml-step-2',
                'w'     => 200,
            ),
            array(
                'title' => '3. Possible matches go to review',
                'text'  => 'Clear results pass automatically. Possible matches land in a review queue with the list entry and the customer’s data side by side.',
                'img'   => 'aml-step-3',
                'w'     => 200,
            ),
            array(
                'title' => '4. You get a decision and an audit record',
                'text'  => 'Every check is logged with the lists used, the time of the check and the reviewer’s decision, so you can show a regulator why each customer was accepted.',
                'img'   => 'identity-step-decision',
                'w'     => 200,
            ),
        ),
    ),

    'kyc_flow' => array(
        'title' => 'AML Checks Inside Your KYC Flow',
        'cards' => array(
            array(
                'title' => 'One session: ID, selfie, liveness and AML',
                'text'  => 'The customer scans their ID and takes a selfie; the screening runs on the verified data before the session closes.',
            ),
            array(
                'title' => 'Fewer typos, fewer false alerts',
                'text'  => 'Screening on data read from the document removes typing errors and fake names — two common causes of missed matches and false alerts.',
            ),
            array(
                'title' => 'One integration, one bill',
                'text'  => 'One API, one dashboard and one price per check for the whole onboarding.',
            ),
        ),
        /* Вводный абзац ТЗ, разбитый без изменения слов (решение В-5). Короткое предложение — заголовком:
         * длинное первым уходило под картинку promo (картинка absolute, текст во всю ширину). */
        'promo' => array(
            'title' => 'With NeuroVision, AML screening is a step in the same KYC session.',
            'text'  => 'Most companies buy identity verification from one vendor and AML screening from another, then stitch the results together.',
        ),
    ),

    'review' => array(
        'title' => 'An AML Platform for Reviewing Matches',
        /* Платформа: четыре карточки слева (как в библиотеке) — фразы ТЗ блока 6 разложены без изменения слов. */
        'top'   => array(
            'title' => 'Match details side by side',
            'text'  => 'See the customer’s verified data next to the list entry — name, date of birth, nationality, list and reason.',
            'note'  => 'Decide in seconds whether it is the same person.',
        ),
        'audit' => array('title' => 'Audit trail and reports', 'text' => 'Every check and decision is stored with timestamps and the lists used.'),
        'pair'  => array(
            array('title' => 'Approve, reject or escalate', 'text' => 'Analysts clear false matches, reject true ones or escalate to enhanced due diligence, with a comment for each decision.'),
            array('title' => 'Reports for audits', 'text' => 'Export reports for audits and regulator requests.'),
        ),
        'alt'   => 'AML platform: reviewing a possible sanctions match side by side with the customer’s verified data',
    ),

    /* Колонка «Local list to screen» не подтверждена командой → запасной текст ТЗ (В-7). */
    'sea' => array(
        'title'  => 'AML Screening in Southeast Asia',
        'lead'   => 'Each Southeast Asian market has its own AML law, financial intelligence unit and local list. Global sanctions lists are the baseline. Ask us which local lists are covered. Last reviewed: October 2026.',
        'labels' => array('regulator' => 'Regulator / FIU', 'law' => 'Main AML law', 'tokens' => 'What we screen'),
        'tokens' => array('Sanctions', 'PEP', 'Watchlists'),
        'local'  => 'Ask us which local lists are covered.',
        'items'  => array(
            array('id' => 'singapore', 'label' => 'Singapore', 'regulator' => 'MAS; STRO (FIU)', 'law' => 'MAS AML/CFT Notices; Terrorism (Suppression of Financing) Act'),
            array('id' => 'malaysia', 'label' => 'Malaysia', 'regulator' => 'Bank Negara Malaysia (FIU)', 'law' => 'AMLA 2001 (AML, CFT and Proceeds of Unlawful Activities Act)'),
            array('id' => 'indonesia', 'label' => 'Indonesia', 'regulator' => 'OJK; PPATK (FIU)', 'law' => 'Law 8/2010 on AML'),
            array('id' => 'philippines', 'label' => 'Philippines', 'regulator' => 'BSP; AMLC (FIU)', 'law' => 'Anti-Money Laundering Act (RA 9160, as amended)'),
            array('id' => 'thailand', 'label' => 'Thailand', 'regulator' => 'AMLO (FIU)', 'law' => 'Anti-Money Laundering Act B.E. 2542 (1999)'),
            array('id' => 'vietnam', 'label' => 'Vietnam', 'regulator' => 'State Bank of Vietnam (FIU)', 'law' => 'Law on Anti-Money Laundering 2022'),
        ),
    ),

    'requirements' => array(
        'title'    => 'AML Screening Requirements Worldwide: FATF, US, EU, UK and UAE',
        'subtitle' => 'This overview is for information only and is not legal advice.',
        'items'    => array(
            array(
                'id'    => 'world',
                'label' => 'FATF',
                'flag'  => 'world',
                'title' => 'FATF Recommendations',
                'text'  => 'FATF Recommendations 6 and 7 require targeted financial sanctions against terrorism and proliferation financing; Recommendation 12 requires extra checks on politically exposed persons.',
            ),
            array(
                'id'    => 'us',
                'label' => 'United States',
                'flag'  => 'us',
                'title' => 'United States: OFAC',
                'text'  => 'US persons must not deal with anyone on OFAC’s Specially Designated Nationals list, and financial institutions are expected to screen customers and transactions against it.',
            ),
            array(
                'id'    => 'eu',
                'label' => 'European Union',
                'flag'  => 'eu',
                'title' => 'European Union: consolidated sanctions list and AMLR',
                'text'  => 'EU firms must apply restrictive measures from the EU consolidated financial sanctions list. The new EU AML Regulation, applying from July 2027, sets common rules for PEP checks across member states.',
            ),
            array(
                'id'    => 'uk',
                'label' => 'United Kingdom',
                'flag'  => 'uk',
                'title' => 'United Kingdom: UK sanctions list',
                'text'  => 'Firms in the UK must check customers against the UK sanctions list and apply enhanced due diligence to PEPs under the Money Laundering Regulations 2017.',
            ),
            array(
                'id'    => 'ae',
                'label' => 'United Arab Emirates',
                'flag'  => 'ae',
                'title' => 'United Arab Emirates: local terrorist list and UN sanctions',
                'text'  => 'UAE financial institutions and virtual asset providers must screen customers against the UAE Local Terrorist List and the UN Security Council consolidated list.',
            ),
        ),
    ),

    'industries' => array(
        'title' => 'AML Solutions by Industry',
        'items' => array(
            array(
                'icon'  => 'temple',
                'title' => 'Banks and digital banks',
                'text'  => 'Screen every account holder and beneficial owner before the first transaction, and keep the record for your regulator.',
                'tags'  => array('What to screen: sanctions, PEP, local lists', 'At onboarding and on list updates'),
            ),
            array(
                'icon'  => 'bank-card',
                'title' => 'E-wallets, remittance and payments',
                'text'  => 'High volumes and cross-border transfers make sanctions screening the first line of defense for e-wallets and remittance firms in the Philippines, Indonesia and Vietnam.',
                'tags'  => array('What to screen: sanctions, terrorist lists', 'At account upgrade and payout'),
            ),
            array(
                'icon'  => 'crypto',
                'title' => 'Crypto exchanges',
                'text'  => 'Screen traders against sanctions lists before deposits and withdrawals, as FATF standards and local licensing rules expect.',
                'tags'  => array('What to screen: sanctions, PEP', 'At onboarding and withdrawal'),
            ),
            array(
                'icon'  => 'document',
                'title' => 'Digital lending',
                'text'  => 'Check borrowers against sanctions and PEP lists as part of loan onboarding, without slowing approval.',
                'tags'  => array('What to screen: sanctions, PEP', 'At application'),
            ),
            array(
                'icon'  => 'building-office',
                'title' => 'Marketplaces and gig platforms',
                'text'  => 'Screen sellers, drivers and couriers before their first payout.',
                'tags'  => array('What to screen: sanctions', 'Before first payout'),
            ),
            array(
                'icon'  => 'cup',
                'title' => 'Gaming and betting',
                'text'  => 'Licensed operators screen players against sanctions and PEP lists before withdrawals.',
                'tags'  => array('What to screen: sanctions, PEP', 'Before withdrawal'),
            ),
        ),
    ),

    'pricing' => array(
        'title'      => 'AML Screening Pricing',
        'lead'       => 'AML screening is an add-on to any KYC check. You pay per screened customer, with no separate subscription.',
        'price'      => '$0.40',
        'price_unit' => 'per screening check',
        'price_note' => 'International screening against sanctions and PEP lists costs $0.40 per check on top of your KYC package.',
        'cta'        => 'Calculate your price',
        'plans'      => array(
            array('title' => 'Free trial', 'text' => 'Test AML screening with free checks and full API access.', 'btn' => 'Start Free Trial', 'form' => 'open-callForm2'),
            array('title' => 'Volume and enterprise plans', 'text' => 'Custom pricing for high volumes, the ADVANCED package with database checks, on-premise deployment and an SLA.', 'btn' => 'Talk to Sales', 'form' => 'open-callForm'),
        ),
    ),

    /* Карточка «Global and regional lists» отложена до подтверждения «50+ countries». */
    'why' => array(
        'title' => 'Why Choose NeuroVision AML Screening Software',
        'items' => array(
            array('title' => 'AML and KYC in one session', 'text' => 'ID, selfie, liveness and AML screening in one flow, one API and one dashboard.'),
            array('title' => 'Screening on verified data', 'text' => 'Names and dates of birth come from the verified document, not from a form.'),
            array('title' => 'Price per check on our website', 'text' => 'No annual minimums for standard plans.'),
            array('title' => 'Review and audit built in', 'text' => 'Clear, reject or escalate matches and keep a full record for audits.'),
            array('title' => 'Cloud or on-premise', 'text' => 'Use our cloud or deploy in your own infrastructure when data must stay in the country.'),
        ),
    ),

    'api' => array(
        'heading'  => 'AML Screening API',
        'subtitle' => 'Add AML checks to your onboarding through the same API and widget you use for KYC.',
        'slides'   => array(
            array('title' => 'REST API', 'subtitle' => '', 'description' => 'Request a screening for a customer, or let it run automatically as a step of a KYC session, and get the result in JSON.'),
            array('title' => 'Inside the KYC widget', 'subtitle' => '', 'description' => 'Turn on AML screening as a step in your KYC scenario — no separate integration.'),
            array('title' => 'Webhooks and results', 'subtitle' => '', 'description' => 'Receive results and match details by webhook, and pull them from the dashboard for audits.'),
        ),
    ),

    /* Ссылки «→ KYC verification» (блок 5) и «→ Information security policy» сняты: у текста карточек
     * нет стиля ссылок (выходит синяя подчёркнутая) — открытый вопрос в docs/pages/aml.md. */
    /* Блок 16: два предложения ТЗ дословно разнесены по двум карточкам; заголовки h3 и региональный
     * заголовок собраны из слов этих же предложений (решение владельца 2026-10-20: блок не из одной карточки). */
    'security' => array(
        'title' => 'Security and Data Protection',
        'cards' => array(
            array(
                'title' => 'Encrypted in transit and at rest',
                'text'  => 'Screening data is encrypted in transit and at rest and processed under GDPR and the privacy laws of our Southeast Asian markets.',
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

    /* Вопросы без подтверждённого ответа (re-screen, SEA lists, без ID) отложены; хвосты-ссылки — В-10. */
    'faq' => array(
        'title' => 'AML Screening FAQ',
        'items' => array(
            array('question' => 'What is AML screening?', 'answer' => array('AML screening is checking customers against sanctions lists, politically exposed persons and other watchlists to stop money laundering and terrorist financing. It is a required part of customer due diligence in most countries.'), 'initial_open' => true),
            array('question' => 'Which sanctions lists do you check?', 'answer' => array('We screen against the EU consolidated list, the US OFAC SDN list, UK sanctions lists and the UN Security Council consolidated list, plus terrorist lists.')),
            array('question' => 'What is PEP screening?', 'answer' => array('PEP screening checks whether a customer is a politically exposed person — someone with a prominent public role — or their relative or close associate. A PEP match leads to enhanced due diligence, not automatic rejection.')),
            array('question' => 'What is the difference between AML and KYC?', 'answer' => array('AML is the full set of rules and controls against money laundering. KYC is the part of AML that identifies and verifies customers; AML screening checks those verified customers against sanctions and PEP lists.')),
            array('question' => 'How long does an AML check take?', 'answer' => array('An automated check returns in seconds as part of the KYC session. Possible matches take longer because your team reviews them.')),
            array('question' => 'How do you handle false positives?', 'answer' => array('Matching uses date of birth and nationality from the verified ID to rule out namesakes, and the remaining possible matches go to a review queue where analysts clear them in a few clicks.')),
            array('question' => 'How much does AML screening cost?', 'answer' => array('International sanctions and PEP screening costs $0.40 per check on top of your KYC package, with volume pricing for large orders.')),
            array('question' => 'How do I add AML screening to my onboarding?', 'answer' => array('Turn on AML screening as a step in your KYC scenario, or call it through the REST API. Most teams go live in one business day.')),
        ),
    ),
);
?>

<main>

    <?php
    /* 1. Hero (ТЗ, блок 1) — универсальный partial template-parts/kyc-hero-section.php; картинка aml-hero — фото Magnific + карточка результата скрининга (HTML-рендер, тексты ТЗ) только ≥992; aml-hero-tablet / -mobile — фото без карточки (на Tablet и Mobile карточка перекрывала текст/кнопки). */
    $nv_hero_facts = array();
    foreach ($nv_page['hero']['facts'] as $nv_fact) {
        $nv_hero_facts[] = array('icon_html' => nv_identity_icon($nv_fact['icon']), 'text' => esc_html($nv_fact['text']));
    }
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'aml-hero', 'w' => 1600, 'h' => 1056, 'alt' => $nv_page['hero']['alt'],
            'laptop'       => array('src' => 'aml-hero-tablet', 'w' => 1600, 'h' => 1056),
            'tablet'       => array('src' => 'aml-hero-tablet', 'w' => 1600, 'h' => 1056),
            'mobile'       => array('src' => 'aml-hero-mobile', 'w' => 720, 'h' => 536),
            'focus'        => '100% 50%',
            'focus_tablet' => '90% 50%',
        ),
        'title'         => esc_html($nv_page['hero']['title']),
        'subtitle'      => esc_html($nv_page['hero']['subtitle']),
        'primary_btn'   => array('text' => 'Try AML Screening Free', 'mobile_text' => 'Try Free'),
        'secondary_btn' => array('text' => 'See Pricing', 'mobile_text' => 'See Pricing', 'href' => home_url('/pricing-matrix/')),
        'facts'         => $nv_hero_facts,
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Trust strip (ТЗ, блок 2) — template-parts/certs-section.php, без знаков сертификации (В-3). */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'aml-trust',
        'title'      => $nv_page['trust']['title'],
        'chips'      => $nv_page['trust']['tokens'],
    )); ?>

    <?php get_template_part('template-parts/idv-checks-section', null, array(
        'section_id' => 'checks',
        'badge' => 'Checks',
        'title' => $nv_page['checks']['title'],
        'intro' => $nv_page['checks']['intro'],
        'items' => $nv_page['checks']['items'],
    )); ?>

    <?php /* 4. How AML Screening Works (ТЗ, блок 4) — template-parts/kyc-steps-section.php. Картинки шагов временные. */ ?>
    <?php get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'          => 'How it works',
        'title'          => $nv_page['steps']['title'],
        'lead'           => $nv_page['steps']['lead'],
        'note'           => '',
        'steps'          => $nv_page['steps']['items'],
        'arrow_icon'     => $nv_arrow,
        'section_id'     => 'how-it-works',
        'step_id_prefix' => 'aml-step',
        'nav_label'      => 'AML screening steps',
    )); ?>

    <?php /* 5. AML Checks Inside Your KYC Flow (ТЗ, блок 5) — template-parts/idv-benefits-section.php. Promo-картинка временная. */ ?>
    <?php get_template_part('template-parts/idv-benefits-section', null, array(
        'section_id' => 'kyc-flow',
        'title'      => $nv_page['kyc_flow']['title'],
        'icon'       => nv_identity_icon('check-circle'),
        'items'      => $nv_page['kyc_flow']['cards'],
        'promo'      => array(
            'title' => $nv_page['kyc_flow']['promo']['title'],
            'text'  => $nv_page['kyc_flow']['promo']['text'],
            'img'   => 'identity-benefits-fraud',
        ),
    )); ?>

    <?php
    /* 6. An AML Platform for Reviewing Matches (ТЗ, блок 6) — template-parts/kyc-platform-section.php, вариант Identity.
     * верхняя карточка и summary не выводятся (В-5); ноутбук и экран — временные картинки Identity. */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'Review',
        'title'       => $nv_page['review']['title'],
        'lead'        => '',
        'top'         => $nv_platform_top($nv_page['review']['top']),
        'audit'       => array('title' => $nv_page['review']['audit']['title'], 'text' => $nv_page['review']['audit']['text'], 'img' => 'aml-review-audit', 'w' => 255),
        'pair'        => $nv_page['review']['pair'],
        'screen'      => array('image' => 'aml-platform-screen', 'alt' => $nv_page['review']['alt']),
    ));
    ?>

    <?php
    /* 8. AML Screening in Southeast Asia (ТЗ, блок 8) — partial template-parts/kyc-sea-section (универсальный блок; JS — initKycPage()). */
    $nv_sea_items = array();
    foreach ($nv_page['sea']['items'] as $nv_s) {
        $nv_sea_items[] = array(
            'id'    => $nv_s['id'],
            'label' => $nv_s['label'],
            'title' => $nv_s['label'],
            'text'  => $nv_page['sea']['local'],
            'rows'  => array(
                array('label' => $nv_page['sea']['labels']['regulator'], 'values' => array($nv_s['regulator'])),
                array('label' => $nv_page['sea']['labels']['law'], 'values' => array($nv_s['law'])),
                array('label' => $nv_page['sea']['labels']['tokens'], 'values' => $nv_page['sea']['tokens']),
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
    /* 10. AML Screening Requirements Worldwide (ТЗ, блок 10) — template-parts/kyc-compliance-section.php (универсальный блок). Позиции маркеров — доли области карты 738x630. */
    $nv_comp_pos = array(
        'us'    => array(13.0, 22.5),
        'uk'    => array(46.5, 15.5),
        'eu'    => array(59.0, 25.5),
        'ae'    => array(76.4, 40.3),
        'world' => array(92.8, 88.4),
    );
    $nv_comp_args = array(
        'badge'      => 'Requirements',
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

    <?php /* 11. AML Solutions by Industry (ТЗ, блок 11) — template-parts/kyc-industries-section.php, вариант Identity. */ ?>
    <?php get_template_part('template-parts/kyc-industries-section', null, array(
        'title'    => $nv_page['industries']['title'],
        'lead'     => '',
        'items'    => $nv_page['industries']['items'],
    )); ?>

    <?php /* 12. AML Screening Pricing (ТЗ, блок 12) — template-parts/kyc-pricing-section.php. */ ?>
    <?php get_template_part('template-parts/kyc-pricing-section', null, array(
        'section_id' => 'pricing',
        'badge'      => 'Pricing',
        'title'      => $nv_page['pricing']['title'],
        'lead'       => $nv_page['pricing']['lead'],
        'price'      => $nv_page['pricing']['price'],
        'price_unit' => $nv_page['pricing']['price_unit'],
        'price_note' => $nv_page['pricing']['price_note'],
        'cta'        => $nv_page['pricing']['cta'],
        'cta_url'    => home_url('/pricing-matrix/'),
        'arrow_icon' => $nv_arrow,
        'plans'      => $nv_page['pricing']['plans'],
    )); ?>

    <?php get_template_part('template-parts/idv-checks-section', null, array(
        'section_id' => 'why-choose',
        'title' => $nv_page['why']['title'],
        'items' => $nv_page['why']['items'],
    )); ?>

    <?php /* 14. Trusted by Banks, Fintechs and Exchanges — отложен (В-4). */ ?>

    <?php
    /* 15. AML Screening API (ТЗ, блок 15) — template-parts/integration-section.php. Описание слайда выводится partial без экранирования. */
    require_once get_template_directory() . '/inc/integration-preset.php';
    get_template_part('template-parts/integration-section', null, array_merge(nv_integration_preset(), array(
        'section_id' => 'api',
        'badge'      => 'API',
        'heading'    => $nv_page['api']['heading'],
        'subtitle'   => $nv_page['api']['subtitle'],
        'slides'     => $nv_page['api']['slides'],
        'deploy'     => array(),
    )));
    ?>

    <?php /* Security: partial template-parts/idv-security-section.php (универсальный блок, тексты — аргументы). */
    get_template_part('template-parts/idv-security-section', null, array(
        'section_id' => 'security',
        'badge'      => 'Security',
        'title'      => $nv_page['security']['title'],
        'cards'      => $nv_page['security']['cards'],
        'regional'   => $nv_page['security']['regional'],
    ));
    ?>

    <?php /* 17. Try AML Screening Free (ТЗ, блок 17) — template-parts/contacts-section.php без изменений (В-8). */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>

    <?php /* 18. AML Resources — отложен (нет опубликованных материалов). FAQ (ТЗ, блок 18) — template-parts/faq-section.php. */ ?>
    <?php get_template_part('template-parts/faq-section', null, array(
        'items'       => $nv_page['faq']['items'],
        'title'       => $nv_page['faq']['title'],
        'description' => '',
    )); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
