<?php
/**
 * Стресс-кадры блока «Compliance map» (template-parts/kyc-compliance-section.php): минимум / норма / максимум.
 * Возвращает slug => array(part, args); подключается из inc/bloki-stress.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

$nv_cmp_long_t = 'An unusually long heading that keeps going across several lines to prove that nothing collides or gets clipped';
$nv_cmp_long_p = 'This paragraph is deliberately long. It carries several sentences so that the card has to grow in height instead of clipping the text or sliding under the map: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries and territories, long words like internationalisation and a URL-like string example.com/very/long/path.';

return array(
    /* Два маркера, без общего: выбран первый; короткие тексты. */
    'compliance-min' => array(
        'part' => 'template-parts/kyc-compliance-section',
        'args' => array(
            'badge'   => 'Compliance',
            'title'   => 'Where we comply',
            'markers' => array(
                array('flag' => 'us', 'label' => 'United States', 'x' => 22, 'y' => 40, 'title' => 'United States', 'text' => 'CIP and CDD rules.'),
                array('flag' => 'uk', 'label' => 'United Kingdom', 'x' => 62, 'y' => 30, 'title' => 'United Kingdom', 'text' => 'Money Laundering Regulations.'),
            ),
        ),
    ),

    /* Как на /kyc/: общий маркер (FATF) и четыре страны, заголовок, подзаголовок и примечание. */
    'compliance-norm' => array(
        'part' => 'template-parts/kyc-compliance-section',
        'args' => array(
            'badge'      => 'Compliance',
            'section_id' => 'compliance-norm',
            'title'      => 'KYC Compliance Worldwide: FATF, US, EU, UK and UAE',
            'lead'       => 'Our KYC software gives you the checks and records these rules ask for. Your compliance program decides how to use them.',
            'note'       => 'This overview is for information only and is not legal advice.',
            'general'    => array('flag' => 'world', 'label' => 'FATF recommendations (global)', 'x' => 92.8, 'y' => 88.4, 'title' => 'FATF Recommendations', 'text' => 'The FATF standards behind most national AML laws require customer due diligence, a risk-based approach and record keeping. Recommendation 10 covers identifying and verifying customers with reliable, independent sources.'),
            'markers'    => array(
                array('id' => 'us', 'flag' => 'us', 'label' => 'United States', 'x' => 13.0, 'y' => 22.5, 'title' => 'United States: CIP and the CDD Rule', 'text' => 'Banks and other covered institutions must run a Customer Identification Program and, under FinCEN’s Customer Due Diligence Rule, understand the nature of each customer relationship.'),
                array('id' => 'eu', 'flag' => 'eu', 'label' => 'European Union', 'x' => 59.0, 'y' => 25.5, 'title' => 'European Union: AMLD and the new AML Regulation', 'text' => 'Today, KYC in the EU follows national laws based on the Anti-Money Laundering Directives. The new EU AML Regulation will apply directly in all member states from July 2027.'),
                array('id' => 'uk', 'flag' => 'uk', 'label' => 'United Kingdom', 'x' => 46.5, 'y' => 15.5, 'title' => 'United Kingdom: Money Laundering Regulations', 'text' => 'The Money Laundering Regulations 2017 require customer due diligence and enhanced checks for high-risk customers and politically exposed persons.'),
                array('id' => 'ae', 'flag' => 'ae', 'label' => 'United Arab Emirates', 'x' => 76.4, 'y' => 40.3, 'title' => 'United Arab Emirates: CBUAE AML/CFT rules', 'text' => 'Financial institutions in the UAE must identify and verify customers and screen them against sanctions lists.'),
            ),
        ),
    ),

    /* Шесть маркеров + общий, длинные заголовки и тексты, маркер у самого края карты (не должен обрезаться). */
    'compliance-max' => array(
        'part' => 'template-parts/kyc-compliance-section',
        'args' => array(
            'badge'      => 'Compliance',
            'section_id' => 'compliance-max',
            'title'      => $nv_cmp_long_t,
            'lead'       => $nv_cmp_long_p,
            'note'       => $nv_cmp_long_p,
            'general'    => array('flag' => 'world', 'label' => 'Global standard', 'x' => 92.8, 'y' => 88.4, 'title' => $nv_cmp_long_t, 'text' => $nv_cmp_long_p),
            'markers'    => array(
                array('flag' => 'us', 'label' => 'United States', 'x' => 14, 'y' => 24, 'title' => $nv_cmp_long_t, 'text' => $nv_cmp_long_p),
                array('flag' => 'my', 'label' => 'Malaysia', 'x' => 28, 'y' => 60, 'title' => 'Internationalisation and localisation of document templates', 'text' => $nv_cmp_long_p . ' ' . $nv_cmp_long_p),
                array('flag' => 'uk', 'label' => 'United Kingdom', 'x' => 47, 'y' => 18, 'title' => 'Short', 'text' => 'One line.'),
                array('flag' => 'eu', 'label' => 'European Union', 'x' => 60, 'y' => 38, 'title' => $nv_cmp_long_t, 'text' => $nv_cmp_long_p),
                array('flag' => 'sg', 'label' => 'Singapore', 'x' => 97, 'y' => 12, 'title' => 'A marker at the very edge of the map', 'text' => $nv_cmp_long_p),
                array('flag' => 'ae', 'label' => 'United Arab Emirates', 'x' => 88, 'y' => 52, 'title' => $nv_cmp_long_t, 'text' => ''),
            ),
        ),
    ),
);
