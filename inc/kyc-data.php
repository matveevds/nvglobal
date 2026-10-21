<?php
/**
 * Данные страницы /kyc/ (page-kyc.php). Тексты — дословно из Figma (файл ISDh0vGDZPe3CsGvR4ZaIn),
 * где расхождения с макетом — они описаны в docs/DECISIONS.md (запись по странице KYC).
 * Состояния интерактивных блоков (шаги, риск, страны) JS берёт из data-атрибутов, собранных из этих же массивов.
 */

return array(
    'process' => array(
        array(
            'number' => '01',
            'title' => 'Customer identification',
            'text' => 'Collect the data your regulator requires — name, date of birth, address and ID number — directly from the customer\'s document, without typing errors.',
        ),
        array(
            'number' => '02',
            'title' => 'Identity verification: document, selfie and liveness',
            'text' => 'We check that the ID is genuine, match the selfie to the ID photo and confirm a live person is in front of the camera, blocking printed photos, screen replays and deepfakes.',
        ),
        array(
            'number' => '03',
            'title' => 'AML, sanctions and PEP screening',
            'text' => 'Every customer is screened against sanctions lists (EU, OFAC, UK and UN), terrorist lists and politically exposed persons before the account opens.',
        ),
        array(
            'number' => '04',
            'title' => 'Risk scoring and due diligence',
            'text' => 'Each customer gets a risk level based on country, document, screening results and your own rules. High-risk customers move to enhanced due diligence automatically.',
        ),
        array(
            'number' => '05',
            'title' => 'Ongoing monitoring',
            'text' => 'Customers are re-screened when sanctions lists change and re-verified when their documents expire or their risk changes.',
        ),
    ),
    'steps' => array(
        array(
            'title' => 'You set up the KYC flow',
            'text' => 'Choose the checks, the documents you accept in each country and the risk rules in the dashboard. Different products and markets can have different flows.',
            'img' => 'kyc-step-1',
            'w' => 200,
        ),
        array(
            'title' => 'The customer completes eKYC on their phone',
            'text' => 'The customer scans their ID and takes a selfie in your app or website. No branch visit, no video call for most customers, no separate app to download.',
            'img' => 'kyc-step-2',
            'w' => 200,
        ),
        array(
            'title' => 'Automated KYC checks run in seconds',
            'text' => 'Document authenticity, data extraction, face match, liveness, duplicate search and AML screening run in parallel. Online KYC that used to take days now takes seconds.',
            'img' => 'kyc-step-3',
            'w' => 200,
        ),
        array(
            'title' => 'You get a decision, a risk level and an audit record',
            'text' => 'Approved, declined or sent for review — with the risk level, the reason for every flag and a full record you can show an auditor. Results arrive by API, webhook and dashboard.',
            'img' => 'kyc-step-4',
            'w' => 255,
        ),
    ),
    'risk' => array(
        array(
            'button' => 'Simplified due diligence',
            'title' => 'Simplified due diligence for low-risk customers',
            'text' => 'Low-value accounts and products can start with a document and selfie check only, with limits until the customer completes full KYC.',
            'when' => 'Low-risk products, small limits',
            'checks' => array('KYC', 'AML', 'Liveness'),
        ),
        array(
            'button' => 'Customer due diligence (CDD)',
            'title' => 'Customer due diligence (CDD)',
            'text' => 'The standard check for most customers: verified identity, AML screening and a risk level based on country, product and screening results.',
            'when' => 'Most customers',
            'checks' => array('KYC', 'AML', 'Liveness', 'Risk level', 'Sanctions and PEP screening'),
        ),
        array(
            'button' => 'Enhanced due diligence (EDD)',
            'title' => 'Enhanced due diligence (EDD)',
            'text' => 'For high-risk countries, PEPs and large amounts: proof of address, source-of-funds documents, additional screening and a manual review by your team.',
            'when' => 'High-risk countries, PEPs, large amounts',
            'checks' => array('KYC', 'AML', 'Liveness', 'Risk level', 'Sanctions and PEP screening', 'Proof of address', 'Source of funds', 'Manual review'),
        ),
    ),
    'compliance' => array(
        array(
            'id' => 'world',
            'label' => 'FATF',
            'flag' => 'world',
            'title' => 'FATF Recommendations',
            'text' => 'The FATF standards behind most national AML laws require customer due diligence, a risk-based approach and record keeping. Recommendation 10 covers identifying and verifying customers with reliable, independent sources.',
        ),
        array(
            'id' => 'us',
            'label' => 'United States',
            'flag' => 'us',
            'title' => 'United States: CIP and the CDD Rule',
            'text' => 'Banks and other covered institutions must run a Customer Identification Program and, under FinCEN\'s Customer Due Diligence Rule, understand the nature of each customer relationship and monitor it on an ongoing basis.',
        ),
        array(
            'id' => 'eu',
            'label' => 'European Union',
            'flag' => 'eu',
            'title' => 'European Union: AMLD and the new AML Regulation',
            'text' => 'Today, KYC in the EU follows national laws based on the Anti-Money Laundering Directives. The new EU AML Regulation will apply directly in all member states from July 2027, supervised by the new AML Authority (AMLA).',
        ),
        array(
            'id' => 'uk',
            'label' => 'United Kingdom',
            'flag' => 'uk',
            'title' => 'United Kingdom: Money Laundering Regulations',
            'text' => 'The Money Laundering Regulations 2017 require customer due diligence and enhanced checks for high-risk customers and politically exposed persons, supervised by the FCA and other bodies.',
        ),
        array(
            'id' => 'ae',
            'label' => 'United Arab Emirates',
            'flag' => 'ae',
            'title' => 'United Arab Emirates: CBUAE AML/CFT rules',
            'text' => 'Financial institutions and virtual asset service providers in the UAE must identify and verify customers and screen them against sanctions lists under the Central Bank\'s AML/CFT framework.',
        ),
    ),
    'sea' => array(
        array(
            'id' => 'singapore',
            'label' => 'Singapore',
            'title' => 'eKYC in Singapore',
            'text' => 'Banks follow MAS Notice 626 and its equivalents for other financial institutions, and many use Singpass Myinfo to pre-fill verified data. Where Myinfo is not available — for foreigners, or outside banking — customers verify with an NRIC, FIN card or passport and a selfie.',
            'regulator' => 'MAS',
            'id_doc' => 'NRIC / FIN, passport (Singpass Myinfo)',
        ),
        array(
            'id' => 'malaysia',
            'label' => 'Malaysia',
            'title' => 'eKYC in Malaysia',
            'text' => 'Bank Negara Malaysia\'s e-KYC Policy Document sets out how banks and e-money issuers may verify customers remotely, including requirements for liveness and fraud detection. Customers verify with their MyKad or passport; MyDigital ID is becoming another option.',
            'regulator' => 'BNM',
            'id_doc' => 'MyKad, passport (MyDigital ID)',
        ),
        array(
            'id' => 'indonesia',
            'label' => 'Indonesia',
            'title' => 'eKYC in Indonesia',
            'text' => 'OJK rules allow banks, fintech lenders and, since 2025, crypto traders to onboard customers remotely. The KTP-el national ID and its NIK number are at the center of every check, and personal data falls under Law 27/2022 on Personal Data Protection (UU PDP).',
            'regulator' => 'OJK',
            'id_doc' => 'KTP-el (NIK)',
        ),
        array(
            'id' => 'philippines',
            'label' => 'Philippines',
            'title' => 'eKYC in the Philippines',
            'text' => 'BSP allows electronic KYC for banks and e-money issuers, and the national ID — the PhilSys card and its digital ePhilID — is becoming the default ID for financial onboarding, with authentication through the PhilSys system.',
            'regulator' => 'BSP',
            'id_doc' => 'PhilSys ID / ePhilID',
        ),
        array(
            'id' => 'vietnam',
            'label' => 'Vietnam',
            'title' => 'eKYC in Vietnam',
            'text' => 'The State Bank of Vietnam allows eKYC account opening with the chip-based CCCD citizen ID, and since July 2024 requires face authentication against national records for larger transfers.',
            'regulator' => 'SBV',
            'id_doc' => 'CCCD (chip)',
        ),
        array(
            'id' => 'thailand',
            'label' => 'Thailand',
            'title' => 'eKYC in Thailand',
            'text' => 'Thai banks verify the national ID card against the DOPA database, and the Bank of Thailand requires face verification for large mobile banking transfers. NDID connects banks for digital identity.',
            'regulator' => 'BOT',
            'id_doc' => 'Thai national ID card',
        ),
    ),
    'sea_checks' => array('ID document', 'selfie', 'liveness'),
    'industries' => array(
        array(
            'title' => 'Banks and digital banks',
            'icon' => 'temple',
            'text' => 'Open accounts remotely with full CDD, enhanced checks for high-risk customers and an audit trail for your regulator.',
            'tags' => array('CDD and EDD', 'PEP and sanctions screening', 'record keeping'),
        ),
        array(
            'title' => 'FinTech, e-wallets and lending',
            'icon' => 'bank-card',
            'text' => 'Start users on a low limit with a quick check and upgrade them to full KYC when they need higher limits. Stop fake borrowers and loan stacking with face matching and duplicate detection before you pay out.',
            'tags' => array('Tiered KYC', 'duplicate search', 'sanctions screening'),
        ),
        array(
            'title' => 'Crypto exchanges and Web3',
            'icon' => 'crypto',
            'text' => 'Verify traders in line with FATF standards, the Travel Rule and local licensing, and block multi-accounting before the first deposit.',
            'tags' => array('CDD', 'sanctions screening', 'Travel Rule data'),
        ),
        array(
            'title' => 'Telecom and SIM registration',
            'icon' => 'user',
            'text' => 'Register SIM cards with a verified identity, as required by SIM registration laws such as the Philippines\' SIM Registration Act.',
            'tags' => array('ID check', 'selfie match', 'record keeping'),
        ),
        array(
            'title' => 'Gaming and betting',
            'icon' => 'cup',
            'text' => 'Verify age and identity at sign-up and before withdrawals to meet licensing rules.',
            'tags' => array('Age check', 'identity verification', 'self-exclusion lists'),
        ),
        array(
            'title' => 'Government and public services',
            'icon' => 'university',
            'text' => 'Verify citizens for digital public services with national ID checks, face match and liveness, on-premise where the law requires it.',
            'tags' => array('National ID check', 'liveness', 'on-premise deployment'),
        ),
    ),
    'faq' => array(
        array(
            'question' => 'What is KYC verification?',
            'answer' => array(
                'KYC (Know Your Customer) verification is the process of confirming a customer\'s identity and assessing their risk before and during a business relationship. It usually combines an ID check, a selfie match, AML screening and a risk assessment.',
            ),
            'initial_open' => true,
        ),
        array(
            'question' => 'What is eKYC?',
            'answer' => array(
                'eKYC, or electronic KYC, is KYC done fully online: the customer scans their ID and takes a selfie instead of visiting a branch. It is the standard term in Southeast Asia, where regulators such as BNM, OJK and BSP set specific eKYC rules.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'What is the difference between KYC and identity verification?',
            'answer' => array(
                'Identity verification confirms that a person is who they claim to be. KYC is the wider regulatory process that includes identity verification plus AML screening, risk assessment, due diligence and ongoing monitoring.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'What is the difference between KYC and AML?',
            'answer' => array(
                'AML (anti-money laundering) is the overall set of laws and controls that stop criminals from moving money through your business. KYC is one part of AML: it covers identifying and checking customers.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'How long does KYC verification take?',
            'answer' => array(
                'The automated decision arrives within seconds after the customer scans their ID and takes a selfie: each check runs in under a second. Customers flagged for enhanced due diligence take longer because your team reviews them manually.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'Which documents and countries does your KYC software support?',
            'answer' => array(
                'We support passports, national ID cards, driver\'s licenses and residence permits from 195+ countries and territories — 16,000+ document types — including the national IDs of Singapore, Malaysia, Indonesia, the Philippines, Vietnam and Thailand.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'Do you support eKYC in Singapore, Malaysia, Indonesia and the Philippines?',
            'answer' => array(
                'Yes. You can run eKYC for customers in all four countries — and in Vietnam and Thailand — with local ID cards and passports, and configure the flow for MAS, BNM, OJK and BSP requirements.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'Can you verify customers against government databases?',
            'answer' => array(
                'Not today. We verify the ID document itself — its security features and data — together with the selfie and liveness check; direct lookups in government databases are not part of the product yet. Contact us if your regulator requires one for your market.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'How do you handle high-risk customers?',
            'answer' => array(
                'High-risk customers — for example, from high-risk countries or with PEP or sanctions matches — are routed to enhanced due diligence: extra documents, deeper screening and a manual review by your team, all recorded in the audit trail.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'How much does KYC verification cost?',
            'answer' => array(
                'KYC checks start at $0.25 per check with no subscription. The final price depends on the modules you use and your monthly volume; see our pricing page or start a free pilot.',
            ),
            'initial_open' => false,
        ),
        array(
            'question' => 'How do I integrate your KYC solution?',
            'answer' => array(
                'Use our no-code widget or Web SDK for websites and apps, mobile SDKs for iOS and Android, or the REST API for full control. Most teams go live in one business day.',
            ),
            'initial_open' => false,
        ),
    ),
);
