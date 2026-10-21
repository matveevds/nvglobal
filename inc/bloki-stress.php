<?php
/**
 * Стресс-кадры универсальных блоков (картотека, `?nv_bloki_stress=<slug>`).
 *
 * Один блок — минимум / норма / максимум контента: короткие и длинные заголовки, наименьшее и наибольшее число
 * карточек, без картинки. Партиал выводится в пустой оболочке (page-bloki.php), поэтому проверяется именно то,
 * что получает страница, собранная из блока: вид не зависит от body-класса страницы.
 *
 * Возвращает slug => array(part, args). Используется inc/block-catalog.php и картотекой (inc/bloki-data.php).
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/identity-icons.php';
require_once get_template_directory() . '/inc/kyc-icons.php';
require_once get_template_directory() . '/template-parts/contacts-icons.php';
require_once get_template_directory() . '/inc/integration-preset.php';

$nv_long_t = 'An unusually long heading that keeps going across several lines to prove that nothing collides or gets clipped';
$nv_long_p = 'This paragraph is deliberately long. It carries several sentences so that the card has to grow in height instead of clipping the text or sliding under the picture: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries, long words like internationalisation and a URL-like string example.com/very/long/path.';

$nv_steps_item = static function (string $title, string $text, string $img = ''): array {
    return array('title' => $title, 'text' => $text, 'img' => $img, 'w' => 200);
};

$nv_stress = array(
    /* ---------- Steps ---------- */
    'steps-min' => array(
        'part' => 'template-parts/kyc-steps-section',
        'args' => array(
            'title'      => 'How it works',
            'steps'      => array(
                $nv_steps_item('Upload', 'Send the file.'),
                $nv_steps_item('Check', 'We verify it.'),
                $nv_steps_item('Decide', 'You get a result.'),
            ),
            'arrow_icon' => nv_contacts_icon('arrow', 24),
        ),
    ),
    'steps-norm' => array(
        'part' => 'template-parts/kyc-steps-section',
        'args' => array(
            'title'          => 'How Online Verification Works',
            'lead'           => 'Four steps, an automated decision in seconds, a full audit trail for your team.',
            'note'           => 'Every check takes under a second — auto-approve, decline or route to manual review.',
            'steps'          => array(
                $nv_steps_item('The user captures their ID document', 'Guided capture checks framing, glare and covered fields before upload.', 'identity-step-icon'),
                $nv_steps_item('The user takes a live selfie', 'The camera checks image quality and runs the liveness check in the same step.', 'kyc-step-2'),
                $nv_steps_item('Checks run in parallel', 'Document authenticity, data extraction, face match and AML screening run at the same time.', 'kyc-step-1'),
                $nv_steps_item('You get a decision in seconds', 'Approved, declined or sent to manual review, with the reason for every flag.', 'identity-step-decision'),
            ),
            'arrow_icon'     => nv_contacts_icon('arrow', 24),
            'step_id_prefix' => 'norm-step',
        ),
    ),
    'steps-max' => array(
        'part' => 'template-parts/kyc-steps-section',
        'args' => array(
            'title'          => $nv_long_t,
            'lead'           => $nv_long_p,
            'note'           => $nv_long_p,
            'steps'          => array(
                $nv_steps_item($nv_long_t, $nv_long_p, 'identity-step-icon'),
                $nv_steps_item('Internationalisation and localisation of document templates', $nv_long_p, 'kyc-step-2'),
                $nv_steps_item('A very short one', 'Short text.', 'kyc-step-1'),
                $nv_steps_item($nv_long_t, $nv_long_p),
                $nv_steps_item('Fifth step', $nv_long_p, 'identity-step-decision'),
            ),
            'arrow_icon'     => nv_contacts_icon('arrow', 24),
            'step_id_prefix' => 'max-step',
        ),
    ),

    /* ---------- Platform Bento ---------- */
    'platform-min' => array(
        'part' => 'template-parts/kyc-platform-section',
        'args' => array(
            'title' => 'Platform',
            'audit' => array('title' => 'Audit trail', 'text' => 'Every decision is logged.'),
            'pair'  => array(
                array('title' => 'Roles', 'text' => 'Access by role.'),
            ),
        ),
    ),
    'platform-norm' => array(
        'part' => 'template-parts/kyc-platform-section',
        'args' => array(
            'badge'   => 'Platform',
            'title'   => 'One Platform Instead of Five Vendors',
            'lead'    => 'Most teams stitch together an OCR vendor, a face-matching API and a liveness provider.',
            'top'     => array(
                'title'     => 'No-code verification flows',
                'text'      => 'Build onboarding flows in the dashboard: choose the checks, their order and the documents you accept per country.',
                'note'      => 'Change a flow without a new release.',
                'note_icon' => nv_identity_icon('swap'),
            ),
            'audit'   => array('title' => 'Audit trail and compliance reports', 'text' => 'Every session is logged with timestamps, results and reviewer actions.', 'img' => 'identity-platform-accent', 'w' => 255),
            'pair'    => array(
                array('title' => 'Risk-based rules and thresholds', 'text' => 'Set face-match thresholds, auto-approve low-risk users and add enhanced checks only for high-risk countries.'),
                array('title' => 'Case management dashboard', 'text' => 'Your team reviews flagged cases side by side and makes the final call.'),
            ),
            'screen'  => array('image' => 'identity-platform-screen'),
            'summary' => 'One platform with one contract, one integration and one dashboard — and one bill',
        ),
    ),
    'platform-max' => array(
        'part' => 'template-parts/kyc-platform-section',
        'args' => array(
            'badge'   => 'Platform',
            'title'   => $nv_long_t,
            'lead'    => $nv_long_p,
            'top'     => array(
                'title'     => $nv_long_t,
                'text'      => $nv_long_p,
                'note'      => 'A long note that goes over two or three lines to check how the plate behaves next to the text. ' . $nv_long_t,
                'note_icon' => nv_identity_icon('swap'),
            ),
            'audit'   => array('title' => $nv_long_t, 'text' => $nv_long_p . ' ' . $nv_long_p, 'img' => 'identity-platform-accent', 'w' => 255),
            'pair'    => array(
                array('title' => $nv_long_t, 'text' => $nv_long_p),
                array('title' => 'Second card', 'text' => $nv_long_p),
                array('title' => 'Third card with a medium title', 'text' => 'Short text.'),
            ),
            'screen'  => array('image' => 'identity-platform-screen'),
            'summary' => $nv_long_t . '. ' . $nv_long_t,
        ),
    ),
    'platform-no-picture' => array(
        'part' => 'template-parts/kyc-platform-section',
        'args' => array(
            'badge' => 'Platform',
            'title' => 'No picture, no screen',
            'top'   => array('title' => 'Top card without a note', 'text' => 'The top card has text only; nothing is reserved for the note.'),
            'audit' => array('title' => 'Audit card without an image', 'text' => 'The audit card has no picture, so no space is reserved for it.'),
            'pair'  => array(
                array('title' => 'First', 'text' => 'Text of the first card.'),
                array('title' => 'Second', 'text' => 'Text of the second card.'),
            ),
        ),
    ),

    /* ---------- Industries ---------- */
    'industries-min' => array(
        'part' => 'template-parts/kyc-industries-section',
        'args' => array(
            'title' => 'By industry',
            'items' => array(
                array('icon' => 'temple', 'title' => 'Banks', 'text' => 'Remote onboarding.', 'tags' => array('KYC')),
                array('icon' => 'user', 'title' => 'Telecom', 'text' => 'SIM registration.'),
                array('icon' => 'cup', 'title' => 'Gaming', 'text' => 'Age checks.', 'tags' => array('Age', 'Identity')),
            ),
        ),
    ),
    'industries-norm' => array(
        'part' => 'template-parts/kyc-industries-section',
        'args' => array(
            'title' => 'Solutions by Industry',
            'lead'  => 'Verification looks different for a bank, a casino and a car-sharing app. Pick the checks your industry needs.',
            'items' => array(
                array('icon' => 'temple', 'title' => 'Banks and fintech', 'text' => 'Open accounts and issue cards remotely while meeting AML, PSD2 and local regulator requirements.', 'tags' => array('Remote account opening', 'Loan applications', 'Step-up checks')),
                array('icon' => 'bank-card', 'title' => 'E-wallets and digital lending', 'text' => 'Onboard users and borrowers in minutes, and stop fake borrowers with face matching.', 'tags' => array('Account upgrades', 'Duplicate detection')),
                array('icon' => 'crypto', 'title' => 'Crypto exchanges and Web3', 'text' => 'Verify traders in line with FATF recommendations, the Travel Rule and local licensing.', 'tags' => array('Tiered KYC limits', 'Sanctions screening')),
                array('icon' => 'cup', 'title' => 'Online gaming and gambling', 'text' => 'Meet licensing rules without losing players at sign-up.', 'tags' => array('Age verification', 'Self-exclusion checks')),
                array('icon' => 'building-office', 'title' => 'Marketplaces and SaaS', 'text' => 'Identity verification for sellers, hosts and drivers builds trust on both sides.', 'tags' => array('Seller verification', 'Driver checks')),
                array('icon' => 'university', 'title' => 'Government and public services', 'text' => 'Give citizens secure access to digital services, with cloud or on-premise deployment.', 'tags' => array('Digital ID onboarding', 'On-premise deployment')),
            ),
        ),
    ),
    'industries-max' => array(
        'part' => 'template-parts/kyc-industries-section',
        'args' => array(
            'title' => $nv_long_t,
            'lead'  => $nv_long_p,
            'items' => array(
                array('icon' => 'globe', 'title' => $nv_long_t, 'text' => $nv_long_p, 'tags' => array('A very long tag that wraps onto several lines when the card is narrow enough', 'Tag two', 'Tag three', 'Tag four', 'Tag five', 'Tag six', 'Tag seven', 'Tag eight', 'Tag nine')),
                array('icon' => 'bank-card', 'title' => 'Short', 'text' => 'One line.', 'tags' => array('One')),
                array('icon' => 'university', 'title' => 'Internationalisation of identity documents', 'text' => $nv_long_p, 'tags' => array('Alpha', 'Beta', 'Gamma')),
                array('icon' => 'building-office', 'title' => 'No tags here', 'text' => $nv_long_p),
                array('icon' => 'crypto', 'title' => 'Fifth card, odd count', 'text' => 'The last card of an odd list takes the whole row.', 'tags' => array('Wide card')),
            ),
        ),
    ),
    /* ---------- Pricing ---------- */
    'pricing-min' => array(
        'part' => 'template-parts/kyc-pricing-section',
        'args' => array(
            'title'      => 'Pricing',
            'price'      => '$1',
            'price_note' => 'Per check.',
            'cta'        => 'Get a quote',
            'cta_form'   => 'open-callForm2',
            'arrow_icon' => nv_contacts_icon('arrow', 24),
        ),
    ),
    'pricing-norm' => array(
        'part' => 'template-parts/kyc-pricing-section',
        'args' => array(
            'badge'        => 'Pricing',
            'title'        => 'Service Pricing',
            'lead'         => 'No subscription and no setup fee. You pay per completed check, and the price goes down as your volume grows.',
            'eyebrow'      => 'Pay per verification',
            'price_prefix' => 'From',
            'price'        => '$0.25',
            'price_unit'   => 'per check',
            'price_note'   => 'Build your check from the modules you need — document, face match, liveness, AML screening.',
            'cta'          => 'See Pricing',
            'cta_url'      => home_url('/pricing-matrix/'),
            'arrow_icon'   => nv_contacts_icon('arrow', 24),
            'plans'        => array(
                array('title' => 'Free pilot', 'text' => '1-month pilot on your real traffic, sandbox access from day one', 'btn' => 'Start Free Pilot', 'form' => 'open-callForm2'),
                array('title' => 'Volume and enterprise plans', 'text' => 'Custom pricing for high volumes, on-premise deployment, an SLA and a dedicated manager', 'btn' => 'Talk to Sales', 'form' => 'open-callForm'),
            ),
        ),
    ),
    'pricing-max' => array(
        'part' => 'template-parts/kyc-pricing-section',
        'args' => array(
            'badge'        => 'Pricing',
            'title'        => $nv_long_t,
            'lead'         => $nv_long_p,
            'eyebrow'      => 'An unusually long eyebrow line that goes on and on',
            'price_prefix' => 'BASIC and ADVANCED packages — from',
            'price'        => '$0.25 – $12.50',
            'price_unit'   => 'per check, billed monthly after the free pilot',
            'price_note'   => $nv_long_p,
            'cta'          => 'See the full pricing matrix and volume discounts',
            'cta_url'      => home_url('/pricing-matrix/'),
            'arrow_icon'   => nv_contacts_icon('arrow', 24),
            'plans'        => array(
                array('title' => $nv_long_t, 'text' => $nv_long_p, 'btn' => 'Start Free Pilot', 'form' => 'open-callForm2'),
                array('title' => 'Second plan', 'text' => $nv_long_p, 'btn' => 'Talk to Sales', 'form' => 'open-callForm'),
                array('title' => 'Third plan without a button', 'text' => 'Short text.'),
            ),
        ),
    ),

    /* ---------- Checks ---------- */
    'checks-min' => array(
        'part' => 'template-parts/idv-checks-section',
        'args' => array(
            'title' => 'Checks',
            'items' => array(
                array('title' => 'One', 'text' => 'First check.'),
                array('title' => 'Two', 'text' => 'Second check.'),
            ),
        ),
    ),
    'checks-norm' => array(
        'part' => 'template-parts/idv-checks-section',
        'args' => array(
            'badge' => 'Checks',
            'title' => 'What the Platform Checks',
            'lead'  => 'Use all checks in one flow or pick only the ones your onboarding needs.',
            'intro' => 'Every check combines several independent signals, so a stolen document, a borrowed face or a deepfake does not pass.',
            'items' => array(
                array('title' => 'Document authenticity', 'text' => 'Fonts, holograms, MRZ and layout are compared with the issuing country template.', 'pill' => 'In every flow'),
                array('title' => 'Face match', 'text' => 'The selfie is matched with the document photo with a calibrated threshold.'),
                array('title' => 'Liveness', 'text' => 'Passive liveness stops printed photos, screens, masks and injected video.'),
                array('title' => 'Duplicate search', 'text' => 'One person cannot open several accounts with different documents.'),
                array('title' => 'AML screening', 'text' => 'Sanctions, PEP and adverse media checked in the same session.'),
                array('title' => 'Data extraction', 'text' => 'Fields are read and validated against each other and the issuing rules.'),
            ),
        ),
    ),
    'checks-max' => array(
        'part' => 'template-parts/idv-checks-section',
        'args' => array(
            'badge' => 'Checks',
            'title' => $nv_long_t,
            'lead'  => $nv_long_p,
            'intro' => $nv_long_p,
            'items' => array(
                array('title' => $nv_long_t, 'text' => $nv_long_p, 'pill' => 'A long pill label that may wrap onto two lines'),
                array('title' => 'Short', 'text' => 'One line.'),
                array('title' => 'Internationalisation of identity documents', 'text' => $nv_long_p),
                array('title' => 'No text'),
                array('title' => 'Fifth card, odd count', 'text' => 'The last card of an odd list takes the whole row.'),
            ),
        ),
    ),

    /* ---------- Benefits ---------- */
    'benefits-min' => array(
        'part' => 'template-parts/idv-benefits-section',
        'args' => array(
            'title' => 'Why automate',
            'items' => array(
                array('title' => 'Faster', 'text' => 'Seconds, not days.'),
                array('title' => 'Cheaper', 'text' => 'Less manual work.'),
            ),
            'promo' => array('title' => 'Try it', 'text' => 'Free pilot.'),
        ),
    ),
    'benefits-norm' => array(
        'part' => 'template-parts/idv-benefits-section',
        'args' => array(
            'badge' => 'Benefits',
            'title' => 'Why Businesses Automate Verification',
            'icon'  => nv_identity_icon('check-circle'),
            'items' => array(
                array('title' => 'Higher onboarding conversion', 'text' => 'A guided flow on any phone means fewer drop-offs and more verified customers.'),
                array('title' => 'Compliance without manual work', 'text' => 'Every decision is logged and explainable for your auditors.'),
                array('title' => 'Less fraud', 'text' => 'Stolen documents, borrowed faces and deepfakes are stopped before the first transaction.'),
            ),
            'promo' => array('title' => 'Fraud costs more than verification', 'text' => 'Block fake accounts at sign-up instead of chasing them after the first payout.', 'img' => 'identity-benefits-fraud'),
        ),
    ),
    'benefits-max' => array(
        'part' => 'template-parts/idv-benefits-section',
        'args' => array(
            'badge' => 'Benefits',
            'title' => $nv_long_t,
            'icon'  => nv_identity_icon('check-circle'),
            'items' => array(
                array('title' => $nv_long_t, 'text' => $nv_long_p),
                array('title' => 'Second card', 'text' => $nv_long_p),
                array('title' => 'Third card', 'text' => 'Short.'),
                array('title' => 'Fourth card with a medium title', 'text' => $nv_long_p),
            ),
            'promo' => array('title' => $nv_long_t, 'text' => $nv_long_p . ' ' . $nv_long_p, 'img' => 'identity-benefits-fraud'),
        ),
    ),
    'benefits-no-image' => array(
        'part' => 'template-parts/idv-benefits-section',
        'args' => array(
            'badge' => 'Benefits',
            'title' => 'Promo without a picture',
            'items' => array(
                array('title' => 'No icon on the card', 'text' => 'Icons are optional.'),
                array('title' => 'Second card', 'text' => 'Text of the second card.'),
                array('title' => 'Third card', 'text' => 'Text of the third card.'),
            ),
            'promo' => array('title' => 'Promo title', 'text' => 'The promo card has no image, so nothing is reserved for it.'),
        ),
    ),

    /* ---------- Integration ---------- */
    'integration-min' => array(
        'part' => 'template-parts/integration-section',
        'args' => array(
            'heading' => 'Integration',
            'slides'  => array(array('title' => 'REST API', 'subtitle' => '', 'description' => 'One endpoint.')),
        ),
    ),
    'integration-norm' => array(
        'part' => 'template-parts/integration-section',
        'args' => nv_integration_preset(),
    ),
    'integration-max' => array(
        'part' => 'template-parts/integration-section',
        'args' => array_merge(nv_integration_preset(), array(
            'badge'        => 'Integration and an unusually long badge',
            'heading'      => $nv_long_t,
            'subtitle'     => $nv_long_p,
            'docs_text'    => 'View the complete documentation and code samples',
            'contact_text' => 'Talk to the integration team about your scenario',
            'path_title'   => $nv_long_t,
            'slides'       => array(
                array('title' => $nv_long_t, 'subtitle' => 'iOS & Android and more', 'description' => $nv_long_p),
                array('title' => 'Web SDK', 'subtitle' => '', 'description' => 'Short.'),
                array('title' => 'Internationalisation of identity documents', 'subtitle' => '', 'description' => $nv_long_p),
                array('title' => 'Fourth path', 'subtitle' => '', 'description' => $nv_long_p),
                array('title' => 'Fifth path', 'subtitle' => '', 'description' => $nv_long_p),
            ),
            'includes'     => array('title' => $nv_long_t, 'items' => array($nv_long_p, 'sandbox with test data', 'dedicated technical support', $nv_long_t, 'regular check-ins', 'a sixth item')),
            'deploy'       => array('title' => $nv_long_t, 'note' => $nv_long_p, 'img' => 'sol-int-servers', 'w' => 335, 'h' => 224),
            'backoffice'   => array('title' => $nv_long_t, 'chips' => array('scenario builder', 'stop-lists', 'manual review and analytics', 'a very long chip label that has to wrap onto several lines', 'one more'), 'img' => 'sol-int-folders', 'w' => 252, 'h' => 176),
        )),
    ),
    'integration-bare' => array(
        'part' => 'template-parts/integration-section',
        'args' => array(
            'badge'      => 'API',
            'heading'    => 'Slider only, no buttons and no cards',
            'path_title' => 'Choose your path',
            'slides'     => array(
                array('title' => 'REST API', 'subtitle' => '', 'description' => 'Direct backend integration.'),
                array('title' => 'Web SDK', 'subtitle' => '', 'description' => 'Embeddable widget.'),
            ),
        ),
    ),

);

/* Кадры других блоков — по файлу на блок в inc/bloki-stress/<блок>.php (каждый возвращает slug => array(part, args)).
   Так несколько верстальщиков добавляют свои кадры параллельно, не правя этот файл. */
foreach (glob(__DIR__ . '/bloki-stress/*.php') ?: array() as $nv_stress_file) {
    $nv_stress += (array) require $nv_stress_file;
}

return $nv_stress;
