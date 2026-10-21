<?php
/*
Template Name: Document Verification
Template Post Type: page
NV Page Family: identity
*/
get_header();

/*
 * Страница /document-verification/ — собрана из блоков библиотеки по ТЗ «Document Verification» (13.10.2026).
 * Образец — /kyc/ (page-kyc.php). Регламент — docs/PAGE_BUILDER.md, карта и решения сборщика — docs/pages/document-verification.md.
 * Тексты в цитатах ТЗ — дословно. Картинки docv-*: фото Magnific и HTML-макеты (тексты ТЗ, тестовые данные).
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
    'hero' => array(
        'title'    => 'Document Verification for 16,000+ ID Types from 195+ Countries and Territories',
        'subtitle' => 'Identity document verification in one API: read passports, ID cards, driver’s licenses and residence permits, extract their data with our own OCR and catch screen copies, edited photos and forged documents with 40+ anti-fraud checks — including Southeast Asian IDs.',
        'alt'      => 'Online document verification: an ID card is captured, its data extracted and checked for fraud',
        'facts'    => array(
            array('icon' => 'document-verified', 'text' => '16,000+ document types'),
            array('icon' => 'network-world', 'text' => '195+ countries and territories'),
            array('icon' => 'check-circle', 'text' => '40+ anti-fraud checks'),
            array('icon' => 'crypto', 'text' => 'From $0.24 per check'),
        ),
    ),

    /* Блок 2. Логотипы клиентов и сертификаты ISO/GDPR — только с согласием / после проверки: не ставятся. Чипы — цифры ТЗ. */
    'trust' => array(
        'title' => 'Trusted by banks, fintechs and exchanges to verify documents from 195+ countries and territories.',
        'chips' => array('16,000+ document types', '195+ countries and territories', '90+ languages', '40+ anti-fraud checks'),
    ),

    /* Блок 3: 5 H3 ТЗ = 5 карточек аккордеона. Ссылки «→ Full list…», «→ #passports», «→ #southeast-asia» не выводятся. */
    'documents' => array(
        'title' => 'Documents We Verify',
        'lead'  => 'Identity document verification starts with recognizing the document itself. We support 16,000+ document types from 195+ countries and territories — so the same flow works for a local customer and a traveler.',
        'items' => array(
            array('number' => '01', 'title' => 'Passports', 'text' => 'Biometric and non-biometric passports, with MRZ reading and checksum verification.'),
            array('number' => '02', 'title' => 'National ID cards', 'text' => 'Front and back of national ID cards, including Singapore’s NRIC, Malaysia’s MyKad, Indonesia’s KTP, the Philippine national ID, Vietnam’s citizen ID and the Thai national ID card.'),
            array('number' => '03', 'title' => 'Driver’s licenses', 'text' => 'Driver’s licenses from around the world — useful for ride-hailing, delivery and car-sharing platforms. Both sides are read as separate documents.'),
            array('number' => '04', 'title' => 'Residence permits and visas', 'text' => 'Residence permits and visas as additional documents for foreign customers and employees.'),
            array('number' => '05', 'title' => 'Proof of address', 'text' => 'Utility bills, bank statements, lease agreements, tax notices and phone or internet bills — read and matched to the customer’s data.'),
        ),
    ),

    'steps' => array(
        'title' => 'How Online Document Verification Works',
        'lead'  => 'A few seconds for the customer, structured data and a clear result for you.',
        'items' => array(
            array('title' => '1. Guided capture', 'text' => 'The camera checks framing, glare, blur and covered fields before the photo is taken, so fewer documents fail on quality.', 'img' => 'docv-step-1', 'w' => 200),
            array('title' => '2. Document type and country detected', 'text' => 'The system recognizes which document it is — country, type and version — and knows which fields and security features to expect.', 'img' => 'docv-step-2', 'w' => 200),
            array('title' => '3. Data extracted and cross-checked', 'text' => 'Fields are read with OCR, the MRZ checksum is verified, and dates and numbers are checked for consistency between zones.', 'img' => 'docv-step-3', 'w' => 200),
            array('title' => '4. Automated document verification decision', 'text' => 'Anti-fraud checks run in parallel; you get the extracted data, the result of every check and an overall decision — approve, decline or manual review.', 'img' => 'docv-step-4', 'w' => 200),
        ),
    ),

    /* Блок 5: H3 «Edited images and AI-generated fakes» — заголовок дословно, текст без хвоста про ИИ («только если подтверждено»). */
    'fraud' => array(
        'title' => 'Document Fraud Detection: 40+ Checks on Every Document',
        'intro' => 'A real-looking document is not always a real document. Our document fraud detection software checks every image for the signs of the most common attacks.',
        'items' => array(
            array('title' => 'Screen photos, photocopies and printouts', 'text' => 'Photos of a document shown on another phone, tablet or monitor, black-and-white photocopies and printed copies are detected and flagged.'),
            array('title' => 'Photo substitution and tampering', 'text' => 'Glued-in photos, drawn or added elements, erasures and corrections are spotted on the document image.'),
            array('title' => 'Edited images and AI-generated fakes', 'text' => 'Images processed in a graphic editor are flagged.'),
            array('title' => 'Data that does not add up', 'text' => 'Dates, numbers and fields that contradict each other — or the MRZ — reveal forged documents that look right at a glance.'),
            array('title' => 'Signatures, stamps and wear', 'text' => 'Signatures and stamps are checked, and document condition is assessed.'),
        ),
    ),

    'ocr' => array(
        'title' => 'Document Data Extraction and OCR',
        /* Платформа: четыре карточки слева (как в библиотеке) — фразы ТЗ блока 6 разложены без изменения слов. */
        'top'   => array(
            'title' => 'Printed and handwritten text',
            'text'  => 'Our own OCR engine reads printed and handwritten fields.',
            'note'  => 'Older documents and handwritten entries do not need manual typing.',
        ),
        'audit' => array('title' => 'Structured JSON output', 'text' => 'Extracted data comes back as structured fields — ready for your systems.'),
        'pair'  => array(
            array('title' => 'Latin and non-Latin scripts in 90+ languages', 'text' => 'Thai, Vietnamese diacritics, Chinese, Arabic, Cyrillic and more are read, with transliteration where needed.'),
            array('title' => 'Structured fields', 'text' => 'Name, date of birth, document number, expiry date, address.'),
        ),
        'alt'   => 'Document data extraction: OCR fields returned as structured JSON',
    ),

    /* Блок 7: H3 «NFC chip reading» — «только если поддерживается»: не ставится. */
    'passport' => array(
        'title' => 'Passport Verification: MRZ, Data Page and Chip',
        'items' => array(
            array('title' => 'MRZ and checksum verification', 'text' => 'The machine-readable zone is read and its checksums verified, catching altered numbers and dates.'),
            array('title' => 'Data page vs MRZ consistency', 'text' => 'Data in the visual zone is compared with the MRZ; any mismatch is flagged.'),
        ),
    ),

    /* Блок 8: колонка «Government database check» условная — не показана; вместо неё предложение ТЗ. */
    'sea' => array(
        'title'  => 'Southeast Asian ID Documents',
        'lead'   => 'Verify customers across Southeast Asia with the documents they actually carry. National ID cards, driver’s licenses and passports from all six markets are recognized and checked. Last reviewed: October 2026.',
        'labels' => array('registry' => 'Main ID documents', 'document' => 'What we read and check'),
        'ubo_label' => '',
        'items'  => array(
            array('id' => 'singapore', 'label' => 'Singapore', 'registry' => 'NRIC, FIN card, driver’s license, passport', 'document' => 'Recognition, data extraction, anti-fraud', 'ubo' => 'Need a check against a national database? Talk to us about your market.'),
            array('id' => 'malaysia', 'label' => 'Malaysia', 'registry' => 'MyKad, driver’s license, passport', 'document' => 'Recognition, data extraction, anti-fraud', 'ubo' => 'Need a check against a national database? Talk to us about your market.'),
            array('id' => 'indonesia', 'label' => 'Indonesia', 'registry' => 'KTP-el (NIK), driver’s license (SIM), passport', 'document' => 'Recognition, data extraction, anti-fraud', 'ubo' => 'Need a check against a national database? Talk to us about your market.'),
            array('id' => 'philippines', 'label' => 'Philippines', 'registry' => 'PhilSys national ID, UMID, driver’s license, passport', 'document' => 'Recognition, data extraction, anti-fraud', 'ubo' => 'Need a check against a national database? Talk to us about your market.'),
            array('id' => 'vietnam', 'label' => 'Vietnam', 'registry' => 'Citizen ID (CCCD), driver’s license, passport', 'document' => 'Recognition, data extraction, anti-fraud', 'ubo' => 'Need a check against a national database? Talk to us about your market.'),
            array('id' => 'thailand', 'label' => 'Thailand', 'registry' => 'Thai national ID card, driver’s license, passport', 'document' => 'Recognition, data extraction, anti-fraud', 'ubo' => 'Need a check against a national database? Talk to us about your market.'),
        ),
    ),

    'combo' => array(
        'title' => 'Document, Face and Liveness in One Check',
        /* Платформа: четыре карточки слева (как в библиотеке) — фразы ТЗ блока 9 разложены без изменения слов. */
        'top'   => array(
            'title' => 'Age from the document',
            'text'  => 'The date of birth on the document is compared with the face.',
            'note'  => 'A borrowed ID shows up.',
        ),
        'audit' => array('title' => 'Selfie vs document photo', 'text' => 'The customer’s selfie is matched to the photo on the document.'),
        'pair'  => array(
            array('title' => 'Liveness against photos and deepfakes', 'text' => 'Liveness detection confirms a real person is holding the document.'),
            array('title' => 'In one check', 'text' => 'Document, face and liveness in one check.'),
        ),
        'alt'   => 'Selfie matched to the document photo, with age and liveness checks',
    ),

    /* Блок 10 «Accuracy and Coverage You Can Check» отложен: 99.85% — только с методикой (ТЗ). */

    'industries' => array(
        'title' => 'Document Verification Solutions by Industry',
        'items' => array(
            array('icon' => 'temple', 'title' => 'Banks and digital banks', 'text' => 'Remote account opening with full document checks and proof of address.', 'tags' => array('Remote account opening', 'Full document checks', 'Proof of address')),
            array('icon' => 'bank-card', 'title' => 'E-wallets and payments', 'text' => 'Fast checks at account upgrade, with local IDs from across Southeast Asia.', 'tags' => array('Fast checks', 'Account upgrade', 'Local IDs')),
            array('icon' => 'document', 'title' => 'Digital lending', 'text' => 'Catch edited and borrowed documents before payout.', 'tags' => array('Edited documents', 'Borrowed documents', 'Before payout')),
            array('icon' => 'crypto', 'title' => 'Crypto exchanges', 'text' => 'Verify traders from 195+ countries and territories.', 'tags' => array('Verify traders', '195+ countries and territories')),
            array('icon' => 'building-office', 'title' => 'Marketplaces and gig platforms', 'text' => 'Driver’s license checks for drivers and couriers; ID checks for sellers.', 'tags' => array('Driver’s license checks', 'ID checks for sellers')),
            array('icon' => 'scan', 'title' => 'Telecom and SIM registration', 'text' => 'Register SIM cards with a verified ID, as SIM registration laws require.', 'tags' => array('Register SIM cards', 'Verified ID', 'SIM registration laws')),
        ),
    ),

    'pricing' => array(
        'title'      => 'Document Verification Service Pricing',
        'price'      => '$0.24',
        'price_note' => 'Document recognition and anti-fraud checks.',
        'cta'        => 'Calculate your price',
        'plans'      => array(
            array('title' => 'Additional documents — $0.13 each', 'text' => 'Priced on the same volume curve; both sides of a driver’s license count as separate documents.', 'btn' => 'Start Free Trial', 'form' => 'open-callForm2', 'cls' => 'kyc-card--accent'),
            array('title' => 'BASIC package — from $0.44', 'text' => 'Add selfie or liveness with the BASIC package.', 'btn' => '', 'form' => '', 'cls' => 'kyc-card--filled'),
        ),
    ),

    'why' => array(
        'title' => 'Why Choose NeuroVision Document Verification Software',
        'items' => array(
            array('title' => '16,000+ document types', 'text' => 'One provider for every country and territory you serve.'),
            array('title' => '40+ anti-fraud checks', 'text' => 'From screen photos to glued-in pictures and edited data.'),
            array('title' => 'Southeast Asian IDs supported', 'text' => 'National IDs and licenses from all six markets.'),
            array('title' => 'Our own OCR engine', 'text' => 'No third-party licenses; one vendor, one SLA.'),
            array('title' => 'Live in under an hour', 'text' => 'REST API, Web SDK, iOS, Android and WebView.'),
            array('title' => 'Cloud, on-premises or hybrid', 'text' => 'Documents and data stay in your jurisdiction.'),
        ),
    ),

    /* Блок 14 «Trusted by Banks, Fintechs and Exchanges» — только реальные клиенты с согласием: отложен. */

    'api' => array(
        'heading' => 'Document Verification API and SDKs',
        'slides'  => array(
            array('title' => 'REST API', 'subtitle' => '', 'description' => 'Send one image or an array of images and get the document type, extracted fields and check results.'),
            array('title' => 'Web SDK and widget', 'subtitle' => '', 'description' => 'Guided capture in the browser with your branding.'),
            array('title' => 'iOS, Android and WebView', 'subtitle' => '', 'description' => 'Native capture for apps.'),
        ),
    ),

    /* Блок 16: предложения ТЗ дословно разложены по карточкам; заголовки h3 и региональный — из слов этих же предложений. */
    'security' => array(
        'title' => 'Security and Data Retention',
        'cards' => array(
            array(
                'title' => 'Encrypted in transit and at rest',
                'text'  => 'Images are encrypted in transit and at rest. Original images are kept for three months by default and then according to your plan; you control retention.',
            ),
            array(
                'title' => 'ISO/IEC 27001:2022 certified, GDPR-ready',
                'text'  => '',
                'marks' => array('iso', 'asib', 'qa'),
                'link'  => array('text' => 'Information security policy', 'href' => '/information-security-policy/'),
            ),
        ),
        'regional' => array(
            'title_plain'  => 'Original images are kept for three months by default ',
            'title_accent' => 'and then according to your plan',
            'flags'        => array('eu', 'sg', 'my', 'id', 'ph', 'th', 'vn'),
        ),
    ),

    /* FAQ: отложены «How accurate is your OCR?» (методика 99.85%) и «Do you read passport chips (NFC)?» (если поддерживается). Хвосты-ссылки не выводятся. */
    'faq' => array(
        'title' => 'Document Verification FAQ',
        'items' => array(
            array('question' => 'What is document verification?', 'answer' => array('Document verification checks that an identity document is genuine and reads its data — so you know the document is real before you trust the person holding it.'), 'initial_open' => true),
            array('question' => 'Which documents and countries do you support?', 'answer' => array('16,000+ document types from 195+ countries and territories: passports, national ID cards, driver’s licenses, residence permits, visas and proof-of-address documents.')),
            array('question' => 'Do you support Southeast Asian IDs like MyKad, KTP and PhilSys?', 'answer' => array('Yes. National ID cards, driver’s licenses and passports from Singapore, Malaysia, Indonesia, the Philippines, Vietnam and Thailand are recognized and checked.')),
            array('question' => 'How do you detect fake or edited documents?', 'answer' => array('Every document goes through 40+ checks: screen photos, photocopies, glued-in photos, drawings, physical alterations, graphic-editor edits and data that does not match.')),
            array('question' => 'Can you read handwritten documents?', 'answer' => array('Yes, our OCR reads printed and handwritten text.')),
            array('question' => 'Do you check documents against government databases?', 'answer' => array('We verify the document itself; database checks depend on the country — contact us for your market.')),
            array('question' => 'How much does document verification cost?', 'answer' => array('From $0.24 per check for document recognition with anti-fraud checks; additional documents from $0.13.')),
            array('question' => 'How do I integrate document verification?', 'answer' => array('Use our REST API, Web SDK or native iOS and Android SDKs. Most teams go live in under an hour in the sandbox.')),
        ),
    ),
);
?>

<main>

    <?php
    /* 1. Hero (ТЗ, блок 1) — универсальный partial template-parts/kyc-hero-section.php; ≥992 — docv-hero (фото Magnific + HTML-карточка с текстами ТЗ), 768–991.98 и <768 — фото без карточки (docv-hero-tablet / docv-hero-mobile). */
    $nv_hero_facts = array();
    foreach ($nv_page['hero']['facts'] as $nv_fact) {
        $nv_hero_facts[] = array('icon_html' => nv_identity_icon($nv_fact['icon']), 'text' => esc_html($nv_fact['text']));
    }
    get_template_part('template-parts/kyc-hero-section', null, array(
        'media'         => array(
            'src'          => 'docv-hero', 'w' => 1600, 'h' => 1056, 'alt' => $nv_page['hero']['alt'],
            'laptop'       => array('src' => 'docv-hero-tablet', 'w' => 1600, 'h' => 1056),
            'tablet'       => array('src' => 'docv-hero-tablet', 'w' => 1600, 'h' => 1056),
            'mobile'       => array('src' => 'docv-hero-mobile', 'w' => 720, 'h' => 536),
            'focus'        => '100% 25%',
            'focus_tablet' => '45% 50%',
            'focus_mobile' => '50% 24%',
        ),
        'title'         => esc_html($nv_page['hero']['title']),
        'subtitle'      => esc_html($nv_page['hero']['subtitle']),
        'primary_btn'   => array('text' => 'Try Document Verification Free', 'mobile_text' => 'Try Free'),
        'secondary_btn' => array('text' => 'See Supported Documents', 'mobile_text' => 'See Documents', 'href' => home_url('/docs/products/kyc/recognizable-documents/')),
        'facts'         => $nv_hero_facts,
        'arrow_icon'    => $nv_arrow,
    ));
    ?>

    <?php /* 2. Trust strip (ТЗ, блок 2) — template-parts/certs-section.php: подпись ТЗ + чипы с цифрами ТЗ. */ ?>
    <?php get_template_part('template-parts/certs-section', null, array(
        'section_id' => 'docv-trust',
        'title'      => $nv_page['trust']['title'],
        'chip_icon'  => nv_kyc_icon('check', 20),
        'chips'      => $nv_page['trust']['chips'],
    )); ?>

    <?php /* 3. Documents We Verify (ТЗ, блок 3) — копия аккордеона solutions-why--kyc из page-kyc.php; фото docv-process-v2* — HTML-макеты документов поверх фона Magnific. */ ?>
        <section class="section solutions-why solutions-why--kyc" id="documents">
        <div class="container">
            <div class="solutions-why__head">
                <div class="section__badge">Documents</div>
                <div class="solutions-why__head-text">
                    <h2 class="section__title solutions-why__title"><?php echo esc_html($nv_page['documents']['title']); ?></h2>
                    <p class="solutions-why__lead"><?php echo esc_html($nv_page['documents']['lead']); ?></p>
                </div>
            </div>

            <div class="solutions-why__board" data-solutions-why>
                <div class="solutions-why__cards" role="group" aria-label="Documents we verify">
                    <?php foreach ($nv_page['documents']['items'] as $nv_i => $nv_card) :
                        $nv_open = (0 === $nv_i);
                        ?>
                        <div class="solutions-why__card solutions-why__card--level-<?php echo (int) ($nv_i + 1); ?><?php echo $nv_open ? ' is-open' : ''; ?>" data-why-card>
                            <div class="solutions-why__card-body">
                                <h3 class="solutions-why__card-heading">
                                    <button type="button"
                                            class="solutions-why__card-button"
                                            id="docv-process-button-<?php echo esc_attr($nv_card['number']); ?>"
                                            aria-expanded="<?php echo $nv_open ? 'true' : 'false'; ?>"
                                            aria-controls="docv-process-panel-<?php echo esc_attr($nv_card['number']); ?>"><?php echo esc_html($nv_card['title']); ?></button>
                                </h3>
                                <p class="solutions-why__card-text" id="docv-process-panel-<?php echo esc_attr($nv_card['number']); ?>"><?php echo esc_html($nv_card['text']); ?></p>
                            </div>
                            <span class="solutions-why__card-number" aria-hidden="true"><?php echo esc_html($nv_card['number']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <picture class="solutions-why__media">
                    <?php /* Шесть кадров под видимую область фото: блок показывает его cover'ом, область меняется от 166×438 до 874×438 (≥992) и от 286×301 до 918×489 (<992); документы собраны HTML-макетами (SPECIMEN) поверх фона Magnific. */ ?>
                    <source media="(min-width: 1700px)" srcset="<?php echo esc_url($nv_img . 'docv-process-v2-xl.webp'); ?> 1x, <?php echo esc_url($nv_img . 'docv-process-v2-xl@2x.webp'); ?> 2x" width="1050" height="500">
                    <source media="(min-width: 1480px)" srcset="<?php echo esc_url($nv_img . 'docv-process-v2.webp'); ?> 1x, <?php echo esc_url($nv_img . 'docv-process-v2@2x.webp'); ?> 2x" width="1000" height="625">
                    <source media="(min-width: 1120px)" srcset="<?php echo esc_url($nv_img . 'docv-process-v2-mid.webp'); ?> 1x, <?php echo esc_url($nv_img . 'docv-process-v2-mid@2x.webp'); ?> 2x" width="600" height="600">
                    <source media="(min-width: 992px)" srcset="<?php echo esc_url($nv_img . 'docv-process-v2-narrow.webp'); ?> 1x, <?php echo esc_url($nv_img . 'docv-process-v2-narrow@2x.webp'); ?> 2x" width="372" height="600">
                    <source media="(min-width: 560px)" srcset="<?php echo esc_url($nv_img . 'docv-process-v2-m.webp'); ?> 1x, <?php echo esc_url($nv_img . 'docv-process-v2-m@2x.webp'); ?> 2x" width="960" height="505">
                    <img src="<?php echo esc_url($nv_img . 'docv-process-v2-s.webp'); ?>"
                         srcset="<?php echo esc_url($nv_img . 'docv-process-v2-s.webp'); ?> 1x, <?php echo esc_url($nv_img . 'docv-process-v2-s@2x.webp'); ?> 2x"
                         width="560" height="431" alt="" aria-hidden="true" loading="lazy" decoding="async">
                </picture>

                <div class="solutions-why__nav">
                    <button type="button" class="solutions-why__arrow solutions-why__arrow--prev" aria-label="Previous document type" disabled><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M10.0137 5.5564C10.3648 5.41076 10.7767 5.5525 10.9609 5.89429C11.1571 6.25879 11.0206 6.71344 10.6562 6.90992C10.6558 6.91015 10.6545 6.91027 10.6533 6.91089C10.651 6.91214 10.6476 6.915 10.6426 6.91773C10.6324 6.92329 10.6164 6.93167 10.5957 6.94312C10.5541 6.96616 10.4925 7.00125 10.4131 7.04664C10.2537 7.13778 10.0238 7.27147 9.74805 7.44117C9.19501 7.78146 8.46189 8.26114 7.73242 8.82105C6.99842 9.38447 6.29193 10.0111 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5895 5.77637 13.908C6.29187 14.5388 6.99755 15.1652 7.73145 15.7283C8.46104 16.2881 9.19491 16.767 9.74805 17.1072C10.0236 17.2767 10.2527 17.4106 10.4121 17.5017C10.4916 17.5472 10.5541 17.5822 10.5957 17.6052C10.6165 17.6168 10.6324 17.626 10.6426 17.6316C10.6475 17.6343 10.6511 17.6362 10.6533 17.6375L10.6562 17.6384L10.7217 17.6785C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9578C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.954 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9307 9.86914 18.9177C9.82212 18.8917 9.75372 18.8535 9.66797 18.8044C9.49654 18.7065 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.3371 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2729 3.50097 12.2716 3.50098 12.2703C3.50295 11.3213 4.01126 10.4325 4.61426 9.6941C5.23299 8.93647 6.03997 8.22911 6.81836 7.6316C7.60128 7.03062 8.38067 6.52147 8.96191 6.16382C9.25325 5.98456 9.49653 5.84193 9.66797 5.7439C9.75368 5.69489 9.82214 5.65766 9.86914 5.6316C9.89234 5.61874 9.91016 5.60826 9.92285 5.60132C9.92922 5.59784 9.93494 5.59445 9.93848 5.59253C9.94003 5.59169 9.94143 5.59109 9.94238 5.59058L9.94336 5.5896H9.94434L10.0137 5.5564Z" fill="currentColor"/></svg></button>
                    <button type="button" class="solutions-why__arrow solutions-why__arrow--next" aria-label="Next document type"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></button>
                </div>
            </div>
        </div>
    </section>

    <?php /* 4. How Online Document Verification Works (ТЗ, блок 4) — template-parts/kyc-steps-section.php. Иконки шагов — Magnific. */ ?>
    <?php get_template_part('template-parts/kyc-steps-section', null, array(
        'badge'          => 'How it works',
        'title'          => $nv_page['steps']['title'],
        'lead'           => $nv_page['steps']['lead'],
        'note'           => '',
        'steps'          => $nv_page['steps']['items'],
        'arrow_icon'     => $nv_arrow,
        'section_id'     => 'how-it-works',
        'step_id_prefix' => 'docv-step',
        'nav_label'      => 'Document verification steps',
    )); ?>

    <?php /* 5. Document Fraud Detection (ТЗ, блок 5) — partial idv-checks-section. */ ?>
    <?php $nv_checks_block('fraud', 'Fraud detection', $nv_page['fraud']['title'], $nv_page['fraud']['intro'], $nv_page['fraud']['items']); ?>

    <?php
    /* 6. Document Data Extraction and OCR (ТЗ, блок 6) — template-parts/kyc-platform-section.php; экран — HTML-макет «документ-образец → JSON». */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'OCR',
        'title'       => $nv_page['ocr']['title'],
        'lead'        => '',
        'top'         => $nv_platform_top($nv_page['ocr']['top']),
        'audit'       => array('title' => $nv_page['ocr']['audit']['title'], 'text' => $nv_page['ocr']['audit']['text'], 'img' => 'docv-ocr-audit', 'w' => 255),
        'pair'        => $nv_page['ocr']['pair'],
        'screen'      => array('image' => 'docv-ocr-screen', 'alt' => $nv_page['ocr']['alt']),
    ));
    ?>

    <?php /* 7. Passport Verification (ТЗ, блок 7) — partial idv-checks-section, 2 карточки. */ ?>
    <?php $nv_checks_block('passports', 'Passports', $nv_page['passport']['title'], '', $nv_page['passport']['items']); ?>

    <?php
    /* 8. Southeast Asian ID Documents (ТЗ, блок 8) — partial template-parts/kyc-sea-section (универсальный блок; JS — initKycPage()). */
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
    /* 9. Document, Face and Liveness in One Check (ТЗ, блок 9) — template-parts/kyc-platform-section.php; экран — HTML-макет. */
    get_template_part('template-parts/kyc-platform-section', null, array(
        'badge'       => 'One check',
        'title'       => $nv_page['combo']['title'],
        'lead'        => '',
        'top'         => $nv_platform_top($nv_page['combo']['top']),
        'audit'       => array('title' => $nv_page['combo']['audit']['title'], 'text' => $nv_page['combo']['audit']['text'], 'img' => 'docv-face-audit', 'w' => 255, 'h' => 286),
        'pair'        => $nv_page['combo']['pair'],
        'screen'      => array('image' => 'docv-face-screen', 'alt' => $nv_page['combo']['alt']),
    ));
    ?>

    <?php /* 11. Document Verification Solutions by Industry (ТЗ, блок 11) — template-parts/kyc-industries-section.php, вариант Identity (идентити-теги — фразы ТЗ). */ ?>
    <?php get_template_part('template-parts/kyc-industries-section', null, array(
        'title' => $nv_page['industries']['title'],
        'lead'  => '',
        'items' => $nv_page['industries']['items'],
    )); ?>

    <?php /* 12. Document Verification Service Pricing (ТЗ, блок 12) — template-parts/kyc-pricing-section.php. */ ?>
    <?php get_template_part('template-parts/kyc-pricing-section', null, array(
        'section_id'   => 'pricing',
        'badge'        => 'Pricing',
        'title'        => $nv_page['pricing']['title'],
        'price_prefix' => 'DOCUMENT package — from',
        'price'        => $nv_page['pricing']['price'],
        'price_unit'   => 'per check',
        'price_note'   => $nv_page['pricing']['price_note'],
        'cta'          => $nv_page['pricing']['cta'],
        'cta_url'      => home_url('/pricing-matrix/'),
        'arrow_icon'   => $nv_arrow,
        'plans'        => $nv_page['pricing']['plans'],
    )); ?>

    <?php /* 13. Why Choose NeuroVision Document Verification Software (ТЗ, блок 13) — второй экземпляр idv-checks-section, карточки h3. */ ?>
    <?php $nv_checks_block('why-choose', '', $nv_page['why']['title'], '', $nv_page['why']['items']); ?>

    <?php /* 14. Trusted by Banks, Fintechs and Exchanges — отложен. 15. Document Verification API and SDKs (ТЗ, блок 15) — template-parts/integration-section.php. */ ?>
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


    <?php /* 17. Try Document Verification Free (ТЗ, блок 17) — template-parts/contacts-section.php без изменений. */ ?>
    <?php get_template_part('template-parts/contacts-section'); ?>

    <?php /* 18. Document Verification Resources — отложен. FAQ (ТЗ, блок 18) — template-parts/faq-section.php. */ ?>
    <?php get_template_part('template-parts/faq-section', null, array(
        'items'       => $nv_page['faq']['items'],
        'title'       => $nv_page['faq']['title'],
        'description' => '',
    )); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
