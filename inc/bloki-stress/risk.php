<?php
/**
 * Стресс-кадры блока Risk tabs (`template-parts/kyc-risk-section.php`): минимум / норма / максимум контента.
 * Файл подмешивает inc/bloki-stress.php (там же `$nv_long_t` / `$nv_long_p` и подключены иконки).
 */

if (!defined('ABSPATH')) {
    exit;
}

$nv_risk_long_t = 'An unusually long heading that keeps going across several lines to prove that nothing collides or gets clipped';
$nv_risk_long_p = 'This paragraph is deliberately long. It carries several sentences so that the panel has to grow in height instead of clipping the text or sliding under the picture: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries, long words like internationalisation and a URL-like string example.com/very/long/path.';

return array(
    /* 2 вкладки, одна иконка у всех, без боковой карточки, пустая строка «Checks». */
    'risk-min' => array(
        'part' => 'template-parts/kyc-risk-section',
        'args' => array(
            'title'      => 'Two modes',
            'tabs'       => array(
                array('button' => 'Active', 'title' => 'Active mode', 'text' => 'The user follows a prompt.', 'when' => 'Banking', 'checks' => array('Move closer')),
                array('button' => 'Passive', 'title' => 'Passive mode', 'text' => 'One selfie.', 'when' => 'Onboarding', 'checks' => array('Take a selfie')),
            ),
            'icon'       => nv_kyc_icon('scan'),
            'arrow_icon' => nv_contacts_icon('arrow', 24),
            'id_prefix'  => 'risk-min',
        ),
    ),
    /* 3 вкладки, разные иконки, боковая карточка с картинкой. */
    'risk-norm' => array(
        'part' => 'template-parts/kyc-risk-section',
        'args' => array(
            'badge'        => 'Due diligence',
            'title'        => 'Risk-Based Checks: Simplified, Standard and Enhanced',
            'lead'         => 'Light checks for low-risk customers, deeper checks where the risk is higher.',
            'tabs_label'   => 'Due diligence level',
            'when_label'   => 'When',
            'checks_label' => 'Checks',
            'tabs'         => array(
                array('button' => 'Simplified due diligence', 'title' => 'Simplified due diligence for low-risk customers', 'text' => 'Low-value accounts can start with a document and selfie check only, with limits until the customer completes full KYC.', 'icon' => nv_kyc_icon('user'), 'when' => 'Low-risk products, small limits', 'checks' => array('KYC', 'AML', 'Liveness')),
                array('button' => 'Customer due diligence (CDD)', 'title' => 'Customer due diligence (CDD)', 'text' => 'The standard check for most customers: verified identity, AML screening and a risk level based on country and product.', 'icon' => nv_kyc_icon('shield'), 'when' => 'Most customers', 'checks' => array('KYC', 'AML', 'Liveness', 'Risk level', 'Sanctions and PEP screening')),
                array('button' => 'Enhanced due diligence (EDD)', 'title' => 'Enhanced due diligence (EDD)', 'text' => 'For high-risk countries, PEPs and large amounts: proof of address, source-of-funds documents and a manual review by your team.', 'icon' => nv_kyc_icon('temple'), 'when' => 'High-risk countries, PEPs, large amounts', 'checks' => array('KYC', 'AML', 'Liveness', 'Risk level', 'Sanctions and PEP screening', 'Proof of address', 'Source of funds', 'Manual review')),
            ),
            'side'         => array('title' => 'Re-verification and KYC refresh', 'text' => 'Ask customers to verify again when their ID expires, their details change or their risk level goes up — without a new onboarding flow.', 'img' => 'kyc-risk-refresh', 'w' => 245, 'h' => 233),
            'arrow_icon'   => nv_contacts_icon('arrow', 24),
            'id_prefix'    => 'risk-norm',
        ),
    ),
    /* 4 вкладки с очень разной длиной текстов, длинные заголовки и токены, боковая карточка с длинным текстом и картинкой. */
    'risk-max' => array(
        'part' => 'template-parts/kyc-risk-section',
        'args' => array(
            'badge'        => 'Due diligence and monitoring',
            'title'        => $nv_risk_long_t,
            'lead'         => $nv_risk_long_p,
            'tabs_label'   => 'Levels',
            'when_label'   => 'Best for',
            'checks_label' => 'What the user does',
            'tabs'         => array(
                array('button' => 'Short', 'title' => 'Short', 'text' => 'One line.', 'icon' => nv_kyc_icon('user'), 'when' => 'Now', 'checks' => array('One')),
                array('button' => 'A tab label that is long enough to wrap onto a second line in the narrow column', 'title' => $nv_risk_long_t, 'text' => $nv_risk_long_p, 'icon' => nv_kyc_icon('shield'), 'when' => $nv_risk_long_t, 'checks' => array('KYC', 'AML', 'Liveness', 'Risk level', 'Sanctions and PEP screening', 'Proof of address', 'Source of funds', 'Manual review', 'A very long token label that has to wrap onto several lines inside the panel', 'Ongoing monitoring', 'Adverse media', 'Beneficial owners')),
                array('button' => 'Medium length tab', 'title' => 'A medium-length panel heading', 'text' => 'For high-risk countries, PEPs and large amounts: proof of address, source-of-funds documents and a manual review by your team.', 'icon' => nv_kyc_icon('temple'), 'when' => 'High-risk countries, PEPs, large amounts', 'checks' => array('KYC', 'AML', 'Manual review')),
                array('button' => 'Fourth', 'title' => 'Fourth level', 'text' => $nv_risk_long_p, 'icon' => nv_kyc_icon('globe'), 'when' => 'Everyone', 'checks' => array('KYC')),
            ),
            'side'         => array('title' => $nv_risk_long_t, 'text' => $nv_risk_long_p, 'img' => 'kyc-risk-refresh', 'w' => 245, 'h' => 233),
            'arrow_icon'   => nv_contacts_icon('arrow', 24),
            'id_prefix'    => 'risk-max',
        ),
    ),
);
