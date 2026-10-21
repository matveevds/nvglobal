<?php
/**
 * Данные страницы /identity-verification/ (page-identity-verification.php). Тексты — дословно
 * из Figma (файл ISDh0vGDZPe3CsGvR4ZaIn), по паттерну inc/kyc-data.php. Два заголовка ниже —
 * Accuracy и Security — оставлены ровно как в Figma, включая видимые несоответствия смыслу
 * секции (см. implementation-report: это копипаст-остатки из других разделов макета).
 */

return array(
    'hero_facts' => array(
        array('icon' => 'document-verified', 'text' => '99.74% face match accuracy (NIST)', 'mobile_text' => null),
        array('icon' => 'time-square', 'text' => '0.1 s per face comparison', 'mobile_text' => '0.1 s per face match'),
        array('icon' => 'network-world', 'text' => '195+ countries and territories', 'mobile_text' => null),
        // Mobile-макет (2666:42086) даёт другую подпись четвёртого факта — не дубль второго.
        array('icon' => 'crypto', 'text' => 'From $0.25 per verification', 'mobile_text' => 'From $0.25 per KYC check'),
    ),

    'checks' => array(
        array(
            'title' => 'Document verification',
            'text'  => "AI-powered OCR reads passports, national ID cards, driver's licenses and residence permits, checks the MRZ and barcodes, and looks for photo substitution, tampering and screen replays.",
            'pill'  => 'For IDs from 195+ countries',
        ),
        array(
            'title' => 'Face matching: selfie vs. ID photo',
            'text'  => 'The user\'s live selfie is compared with the photo on their document in 0.1 seconds. The same check powers face authentication for logins and high-value transfers.',
            'pill'  => 'Face recognition scored 99.74% accuracy in NIST testing',
        ),
        array(
            'title' => 'Liveness detection and deepfake protection',
            'text'  => 'Confirms a real person is in front of the camera — not a printed photo, a video on a screen, a silicone mask, a virtual camera or an AI-generated face.',
            'pill'  => '',
        ),
        array(
            'title' => 'AML, sanctions and PEP screening',
            'text'  => 'Names are screened against OFAC, UN, EU and other sanctions lists, PEP databases and adverse media, with ongoing monitoring after onboarding.',
            'pill'  => '',
        ),
        array(
            'title' => 'Proof of address and additional documents',
            'text'  => 'Utility bills, bank statements and tax documents are read and cross-checked against the ID data for enhanced due diligence.',
            'pill'  => '',
        ),
        array(
            'title' => 'Duplicate and multi-account detection',
            'text'  => 'A new face is compared against your existing users (1:N search), so one person cannot open ten accounts under ten different names.',
            'pill'  => '',
        ),
    ),

    /*
     * followup-3 V2-04: 4 точных иллюстрации. Паспорт (document) = `identity-step-icon`,
     * смартфон (selfie) = `kyc-step-2`, аналитический график (checks) = `kyc-step-1` — сверены
     * визуально с FHD-экспортом. Decision — точный Figma-ассет (image hash 6ea4e05a..., node
     * 2650:32193), скачан и сконвертирован: `identity-step-decision`.
     */
    'steps' => array(
        array(
            'title' => 'The user captures their ID document',
            'text'  => 'Guided capture checks framing, glare and covered fields before upload. Only live capture is accepted, which blocks pre-edited and AI-generated images.',
            'img'   => 'identity-step-icon',
            'w'     => 200,
        ),
        array(
            'title' => 'The user takes a live selfie',
            'text'  => 'The user places their face in the frame; the camera checks image quality and runs the liveness check in the same step — no separate app, no video call.',
            'img'   => 'kyc-step-2',
            'w'     => 200,
        ),
        array(
            'title' => 'Automated identity verification checks run in parallel',
            'text'  => 'Document authenticity, data extraction, face match, liveness, duplicate search and AML screening run at the same time, not one after another.',
            'img'   => 'kyc-step-1',
            'w'     => 200,
        ),
        array(
            'title' => 'You get a decision in seconds',
            'text'  => 'Approved, declined or sent to manual review — with a confidence score, the reason for every flag and the extracted data, delivered by API, webhook and dashboard.',
            'img'   => 'identity-step-decision',
            'w'     => 200,
        ),
    ),

    'platform_cards' => array(
        'no_code' => array(
            'title' => 'No-code verification flows',
            'text'  => 'Build onboarding flows in the dashboard: choose the checks, their order and the documents you accept per country.',
        ),
        'note' => 'Change a flow without a new release.',
        'audit' => array(
            'title' => 'Audit trail and compliance reports',
            'text'  => 'Every session is logged with timestamps, results and reviewer actions. Export reports for auditors and regulators in a few clicks.',
        ),
        'risk' => array(
            'title' => 'Risk-based rules and thresholds',
            'text'  => 'Set face-match thresholds, auto-approve low-risk users and add enhanced checks only for high-risk countries, amounts or products.',
        ),
        'case' => array(
            'title' => 'Case management dashboard',
            'text'  => 'Your team reviews flagged cases side by side — document, selfie, liveness frames and AML hits — leaves comments and makes the final call.',
        ),
        'summary' => 'NeuroVision is one ID verification platform with one contract, one integration and one dashboard — and one bill',
    ),

    'coverage' => array(
        'documents' => array(
            'tab'   => 'Documents',
            'title' => "Passports, ID cards, driver's licenses and residence permits",
            'text'  => "Biometric passports, national ID cards, driver's licenses, residence permits and visas — front and back, with MRZ, PDF417 barcodes and QR codes.",
        ),
        'regions' => array(
            'tab'   => 'Regions',
            'title' => 'Latin, Cyrillic, Arabic and Asian scripts',
            'text'  => 'Data is extracted and transliterated from 90+ languages, including Arabic, Chinese, Japanese, Korean, Thai and Cyrillic documents.',
        ),
        'sea' => array(
            'tab'   => 'Southeast Asia',
            'title' => 'Southeast Asian IDs: NRIC, MyKad, KTP, PhilSys, CCCD and Thai ID',
            'text'  => 'Verify users across ASEAN with the IDs they actually carry: Singapore NRIC, Malaysian MyKad, Indonesian KTP, Philippine PhilSys ID, Vietnamese chip-based CCCD and the Thai national ID card — plus passports and driver\'s licenses.',
        ),
        'stats' => array(
            array('value' => '16,000+', 'label' => 'document types'),
            array('value' => '195+', 'label' => 'countries and territories'),
            array('value' => '90+', 'label' => 'languages'),
        ),
        'promo' => array(
            'title' => 'Local rules, one integration',
            'text'  => 'Accept different documents per country, require proof of address only where regulators ask for it and keep one flow for everyone else.',
        ),
    ),

    'accuracy' => array(
        // Заголовок дословно совпадает с Integration в Figma (явная ошибка макета, не наша правка).
        'title' => 'Seamless Integration That Just Works',
        'metrics' => array(
            array('label' => 'Face match accuracy', 'value' => '99.74%'),
            array('label' => 'Global ranking', 'value' => 'Top-24'),
            array('label' => 'Evaluation date', 'value' => 'March 2023'),
            array('label' => 'Document data extraction accuracy', 'value' => '99.85%'),
        ),
        'metrics_note' => 'Face recognition — NIST FRTE, March 2023. Document metrics — internal evaluation on production traffic.',
        'cards' => array(
            array(
                'title' => "Deepfake-resistant\nliveness detection",
                'text'  => 'Our liveness check asks the user to place their face in the frame and rejects printed photos, screen replays, masks, virtual cameras and AI-generated faces before the face match runs.',
            ),
            array(
                'title' => "Reliable in low light,\nwith glasses or a beard",
                'text'  => 'Accuracy holds when users change their hairstyle, grow a beard, wear glasses or make-up, or verify in a dimly lit room. The model is trained on faces of different ages and ethnicities.',
            ),
        ),
        'nist_title' => 'What the NIST FRVT result means',
        'nist_lead'  => 'NIST, the US National Institute of Standards and Technology, runs the Face Recognition Technology Evaluation (FRTE, formerly FRVT)',
        'nist_text'  => "FRTE - the best-known independent benchmark for face recognition. Algorithms from vendors worldwide are tested on the same sequestered image sets. In the March 2023 evaluation, NeuroVision's algorithm reached 99.74% accuracy and placed in the global Top-24.",
    ),

    'industries' => array(
        array(
            'icon' => 'temple',
            'title' => 'Banks and fintech',
            'text' => 'Open accounts and issue cards remotely while meeting AML, PSD2 and local regulator requirements. Client identity verification takes seconds instead of a branch visit.',
            'tags' => array('Remote account opening', 'Loan and BNPL applications', 'Step-up checks for large transfers'),
        ),
        array(
            'icon' => 'bank-card',
            'title' => 'E-wallets and digital lending',
            'text' => 'Onboard e-wallet users and borrowers in minutes, and stop fake borrowers and mule accounts with face matching and duplicate detection.',
            'tags' => array('E-wallet account upgrades', 'Digital loan applications', 'Duplicate and mule account detection'),
        ),
        array(
            /* followup-3 V2-09: точные source-иконки Figma (figma-2642-24331), скачаны и
               подключены в inc/kyc-icons.php (bank-card/cup/building-office/university). */
            'icon' => 'crypto',
            'title' => 'Crypto exchanges and Web3',
            'text' => 'Verify traders in 195+ countries in line with FATF recommendations, the Travel Rule and local licensing, and stop multi-account abuse before the first deposit.',
            'tags' => array('Tiered KYC limits', 'Duplicate account detection', 'Sanctions screening'),
        ),
        array(
            'icon' => 'cup',
            'title' => 'Online gaming and gambling',
            'text' => 'Meet licensing rules without losing players at sign-up: age checks, jurisdiction checks and identity verification before withdrawals.',
            'tags' => array('Age verification', 'Self-exclusion checks', 'Bonus abuse prevention'),
        ),
        array(
            'icon' => 'building-office',
            'title' => 'Marketplaces, sharing economy and SaaS',
            'text' => 'User identity verification for sellers, hosts, ride-hailing drivers and couriers builds trust on both sides of the platform, even where KYC is not mandatory.',
            'tags' => array('Seller and host verification', "Driver's license checks", 'Account takeover protection'),
        ),
        array(
            'icon' => 'university',
            'title' => 'Government and public services',
            'text' => 'Give citizens secure access to digital services, with cloud or on-premise deployment for data that must stay in the country.',
            'tags' => array('Digital ID onboarding', 'On-premise deployment', 'High-volume processing'),
        ),
    ),

    'benefits' => array(
        array('title' => 'Higher onboarding conversion', 'text' => 'A guided flow on any phone means fewer users abandon sign-up: clear capture hints, instant retries and a decision in seconds.'),
        array('title' => 'Compliance without manual work', 'text' => 'Every decision is logged and explainable, so audits take hours instead of weeks.'),
        array('title' => 'Lower verification costs', 'text' => 'Automated customer verification replaces manual document review. Your team only looks at the cases the system flags.'),
    ),
    'benefits_promo' => array(
        'title' => 'Fraud stopped before the first transaction',
        'text'  => 'Fake documents, borrowed faces, deepfakes and duplicate accounts are caught at sign-up, not after a chargeback.',
    ),

    'pricing' => array(
        'title' => 'Identity Verification Service Pricing',
        'lead'  => 'No subscription and no setup fee. You pay only for completed verifications, and the price per check goes down as your volume grows.',
        'eyebrow' => 'Pay per verification',
        'price_note' => 'Add only the modules you need: document, face match, liveness, AML, proof of address.',
        'cta'   => 'Calculate your price',
    ),

    'about' => array(
        'title' => 'Why Choose NeuroVision Identity Verification Software',
    ),

    // Заголовок дословно совпадает с Risk-Based KYC на /kyc/ (явная ошибка макета, не наша правка).
    'security' => array(
        'title' => 'Risk-Based KYC: Simplified, Standard and Enhanced Due Diligence',
        'cards' => array(
            array(
                'title' => 'GDPR by design',
                'text'  => 'Personal data is encrypted in transit and at rest. Biometric templates are not kept after comparison, data is minimized, and users can request deletion at any time.',
            ),
            array(
                'title' => 'ISO/IEC 27001:2022 certified',
                'text'  => 'Our information security management system is certified to ISO/IEC 27001:2022.',
                'marks' => array('iso', 'asib', 'qa'),
            ),
        ),
        'regional' => array(
            'title_plain'  => 'Built for KYC rules in the EU, the US ',
            'title_accent' => 'and Southeast Asia',
            'text'         => "Configurable verification levels, audit trails and reports help you meet AML, eIDAS and FinCEN requirements, the rules of MAS in Singapore, BNM in Malaysia, OJK in Indonesia and BSP in the Philippines, and data protection laws including GDPR, PDPA and Indonesia's UU PDP.",
            'flags'        => array('eu', 'us', 'sg', 'my', 'id', 'ph'),
        ),
    ),

    'faq' => array(
        array('question' => 'What is identity verification?', 'answer' => array('Identity verification is the process of confirming that a person is who they claim to be, usually by checking a government-issued ID and matching it to a live selfie. Businesses use it to onboard customers safely and meet KYC and AML rules.'), 'initial_open' => true),
        array('question' => 'How does online ID verification work?', 'answer' => array('The user photographs their ID and takes a selfie on their phone or webcam. NeuroVision checks that the document is authentic, extracts its data, confirms the selfie matches the ID photo and that the person is live, and screens the name against AML lists — with an automated decision in seconds.'), 'initial_open' => false),
        array('question' => 'What is the difference between identity verification and KYC?', 'answer' => array('Identity verification confirms who a person is. KYC (Know Your Customer) is the wider regulatory process that includes identity verification plus risk assessment, AML screening and ongoing monitoring.'), 'initial_open' => false),
        array('question' => 'How long does identity verification take?', 'answer' => array('Each check runs in under a second and the automated decision arrives within seconds after the user submits their document and selfie. A face comparison itself takes 0.1 seconds.'), 'initial_open' => false),
        array('question' => 'Which documents and countries do you support?', 'answer' => array('We support 16,000+ document types from 195+ countries and territories in 90+ languages, including passports, national ID cards, driver\'s licenses and residence permits.'), 'initial_open' => false),
        array('question' => 'Do you support eKYC in Southeast Asia?', 'answer' => array('Yes. NeuroVision supports eKYC for users in Singapore, Malaysia, Indonesia, the Philippines, Vietnam and Thailand, including their national ID cards and passports. Checks can be configured for MAS, BNM, OJK and BSP requirements.'), 'initial_open' => false),
        array('question' => 'How accurate is your identity verification software?', 'answer' => array('Our face recognition reached 99.74% accuracy in NIST testing and ranks in the global Top-24. Document data extraction is 99.85% accurate, and every result comes with a confidence score.'), 'initial_open' => false),
        array('question' => 'Can identity verification detect fake IDs and deepfakes?', 'answer' => array('Yes. Document checks look for tampering, photo substitution and screen replays, and liveness detection blocks photos, videos, masks and deepfakes.'), 'initial_open' => false),
        array('question' => 'Is your identity verification service GDPR compliant?', 'answer' => array('Yes. We process data under GDPR and the privacy laws of our Southeast Asian markets, are ISO/IEC 27001:2022 certified, encrypt data in transit and at rest and do not keep biometric templates after comparison. On-premise deployment is available when data must stay in your infrastructure.'), 'initial_open' => false),
        array('question' => 'How much does identity verification cost?', 'answer' => array('Pricing starts at $0.25 per verification with no subscription. The final price depends on the checks you use and your monthly volume; see our pricing page or start a free pilot.'), 'initial_open' => false),
        array('question' => 'How do I add identity verification to my app or website?', 'answer' => array('Use our Web SDK or no-code widget for websites, native SDKs for iOS and Android, or the REST API for full control. Most teams go live in one business day.'), 'initial_open' => false),
    ),
);
