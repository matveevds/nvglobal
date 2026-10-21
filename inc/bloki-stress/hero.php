<?php
/**
 * Стресс-кадры блока Hero (`template-parts/kyc-hero-section`): минимум / норма / максимум (+ без картинки).
 * Возвращает slug => array(part, args); подмешивается inc/bloki-stress.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/identity-icons.php';
require_once get_template_directory() . '/template-parts/contacts-icons.php';

$nv_he_arrow = nv_contacts_icon('arrow', 24);
$nv_he_icons = array('document-verified', 'time-square', 'network-world', 'crypto');
$nv_he_fact  = static function (int $i, string $text, string $mobile = '') use ($nv_he_icons): array {
    return array('icon_html' => nv_identity_icon($nv_he_icons[$i % 4]), 'text' => $text, 'mobile_text' => $mobile);
};
$nv_he_long_p = 'This paragraph is deliberately long. It carries several sentences so that the subtitle has to grow in height instead of clipping the text or sliding under the buttons: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries and territories, long words like internationalisation and a URL-like string example.com/very/long/path.';

return array(
    /* 3 факта, короткие тексты, одна картинка без отдельных кадров. */
    'hero-min' => array(
        'part' => 'template-parts/kyc-hero-section',
        'args' => array(
            'media'         => array('src' => 'identity-hero', 'w' => 1600, 'h' => 1056, 'alt' => ''),
            'title'         => 'Face Matching API',
            'subtitle'      => 'Compare a selfie with an ID photo.',
            'primary_btn'   => array('text' => 'Try it free'),
            'secondary_btn' => array('text' => 'Pricing', 'href' => '#'),
            'facts'         => array(
                $nv_he_fact(0, '99.74% accuracy'),
                $nv_he_fact(1, '0.1 s per match'),
                $nv_he_fact(2, '195+ countries'),
            ),
            'arrow_icon'    => $nv_he_arrow,
        ),
    ),
    /* Норма: 4 факта, отдельные кадры планшета и мобильной, короткие подписи мобильных кнопок и фактов. */
    'hero-norm' => array(
        'part' => 'template-parts/kyc-hero-section',
        'args' => array(
            'media'         => array(
                'src'          => 'aml-hero', 'w' => 1600, 'h' => 1056, 'alt' => 'A compliance officer reviewing a screening result',
                'tablet'       => array('src' => 'aml-hero-tablet', 'w' => 1600, 'h' => 1056),
                'mobile'       => array('src' => 'aml-hero-mobile', 'w' => 720, 'h' => 536),
                'focus_tablet' => '90% 50%',
            ),
            'title'         => 'Automated AML Screening: Sanctions and PEP Checks at Onboarding',
            'subtitle'      => 'Run AML checks on every new customer in the same session as their ID and selfie. Matches are scored and sent to your team for review.',
            'primary_btn'   => array('text' => 'Try AML Screening Free', 'mobile_text' => 'Try Free'),
            'secondary_btn' => array('text' => 'See Pricing', 'href' => '#'),
            'facts'         => array(
                $nv_he_fact(0, 'EU · OFAC · UK · UN sanctions lists'),
                $nv_he_fact(1, '0.1 s per screening', '0.1 s per check'),
                $nv_he_fact(2, '195+ countries and territories'),
                $nv_he_fact(3, 'From $0.40 per screening check', 'From $0.40 per check'),
            ),
            'arrow_icon'    => $nv_he_arrow,
        ),
    ),
    /* Максимум: H1 в 4 строки, длинный подзаголовок, 4 факта с длинными подписями, длинные кнопки. */
    'hero-max' => array(
        'part' => 'template-parts/kyc-hero-section',
        'args' => array(
            'media'         => array(
                'src'          => 'identity-hero', 'w' => 1600, 'h' => 1056, 'alt' => 'A person taking a selfie',
                'mobile'       => array('src' => 'identity-hero-mobile', 'w' => 720, 'h' => 536),
                'focus_tablet' => '35% 50%',
            ),
            'title'         => 'Automated Liveness Detection and Identity Verification for Banks, Fintechs and Marketplaces Across Southeast Asia',
            'subtitle'      => $nv_he_long_p,
            'primary_btn'   => array('text' => 'Start Your Free Enterprise Verification Pilot Today'),
            'secondary_btn' => array('text' => 'See Every Supported Document Type and Country'),
            'facts'         => array(
                $nv_he_fact(0, '99.74% face match accuracy confirmed in independent NIST testing of 1:N algorithms'),
                $nv_he_fact(1, '0.1 s per face comparison, including liveness detection and the document check'),
                $nv_he_fact(2, '195+ countries and territories with 16,000+ supported document types'),
                $nv_he_fact(3, 'From $0.25 per verification check with volume discounts on every plan'),
            ),
            'arrow_icon'    => $nv_he_arrow,
        ),
    ),
    /* Без картинки: тёмная подложка, текст читается; 4 факта. */
    'hero-nomedia' => array(
        'part' => 'template-parts/kyc-hero-section',
        'args' => array(
            'title'         => 'A hero without a picture',
            'subtitle'      => 'The card keeps a dark background, so the white text stays readable until the photo is added.',
            'primary_btn'   => array('text' => 'Start Free Pilot', 'mobile_text' => 'Start Free'),
            'secondary_btn' => array('text' => 'See How It Works', 'href' => '#'),
            'facts'         => array(
                $nv_he_fact(0, 'Fact one'),
                $nv_he_fact(1, 'Fact two'),
                $nv_he_fact(2, 'Fact three'),
                $nv_he_fact(3, 'Fact four'),
            ),
            'arrow_icon'    => $nv_he_arrow,
        ),
    ),
);
