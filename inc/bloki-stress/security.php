<?php
/**
 * Стресс-кадры блока Security (`template-parts/idv-security-section.php`): 1 карточка без региона, норма,
 * 3 карточки с длинными текстами + регион, плюс сочетания «только карточки» и «регион без карты».
 * Возвращает slug => array(part, args); подмешивается в inc/bloki-stress.php.
 */
if (!defined('ABSPATH')) {
    exit;
}

$nv_sec_long_t = 'An unusually long heading that keeps going across several lines to prove that nothing collides or gets clipped';
$nv_sec_long_p = 'This paragraph is deliberately long. It carries several sentences so that the card has to grow in height instead of clipping the text or sliding under the picture: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries, long words like internationalisation and a URL-like string example.com/very/long/path.';
$nv_sec_link   = array('text' => 'Information security policy', 'href' => '/information-security-policy/');

return array(
    'security-min' => array(
        'part' => 'template-parts/idv-security-section',
        'args' => array(
            'title' => 'Security',
            'cards' => array(
                array('title' => 'Encrypted', 'text' => 'Data is encrypted in transit and at rest.'),
            ),
        ),
    ),
    'security-norm' => array(
        'part' => 'template-parts/idv-security-section',
        'args' => array(
            'badge'    => 'Security',
            'title'    => 'Security and Data Protection',
            'cards'    => array(
                array('title' => 'Encrypted in transit and at rest', 'text' => 'Screening data is encrypted in transit and at rest and processed under GDPR and the privacy laws of our Southeast Asian markets.'),
                array('title' => 'ISO/IEC 27001:2022 certified', 'text' => 'Our information security management system is certified to ISO/IEC 27001:2022.', 'marks' => array('iso', 'asib', 'qa'), 'link' => $nv_sec_link),
            ),
            'regional' => array(
                'title_plain'  => 'Processed under GDPR and the privacy laws ',
                'title_accent' => 'of our Southeast Asian markets',
                'flags'        => array('eu', 'sg', 'my', 'id', 'ph', 'th', 'vn'),
            ),
        ),
    ),
    'security-max' => array(
        'part' => 'template-parts/idv-security-section',
        'args' => array(
            'badge'    => 'Security and an unusually long badge',
            'title'    => $nv_sec_long_t,
            'cards'    => array(
                array('title' => $nv_sec_long_t, 'text' => $nv_sec_long_p),
                array('title' => 'ISO/IEC 27001:2022 certified, GDPR-ready and audited every year', 'text' => $nv_sec_long_p, 'marks' => array('iso', 'asib', 'qa'), 'link' => array('text' => 'Read the complete information security policy of the platform', 'href' => '/information-security-policy/')),
                array('title' => 'A short one', 'text' => 'Short text.'),
            ),
            'regional' => array(
                'title_plain'  => $nv_sec_long_t . ' ',
                'title_accent' => 'and an accent part that also goes on for a while',
                'text'         => $nv_sec_long_p . ' ' . $nv_sec_long_p,
                'flags'        => array('eu', 'us', 'sg', 'my', 'id', 'ph', 'th', 'vn'),
            ),
        ),
    ),
    'security-cards-only' => array(
        'part' => 'template-parts/idv-security-section',
        'args' => array(
            'badge' => 'Security',
            'title' => 'Cards without a regional panel',
            'cards' => array(
                array('title' => 'Encrypted in transit and at rest', 'text' => 'Screening data is encrypted in transit and at rest.'),
                array('title' => 'ISO/IEC 27001:2022 certified', 'text' => 'Our information security management system is certified to ISO/IEC 27001:2022.', 'marks' => array('iso', 'asib', 'qa'), 'link' => $nv_sec_link),
                array('title' => 'Retention you control', 'text' => 'Original images are kept for three months by default and then according to your plan.'),
            ),
        ),
    ),
    'security-no-map' => array(
        'part' => 'template-parts/idv-security-section',
        'args' => array(
            'badge'    => 'Security',
            'title'    => 'Regional panel without a map',
            'cards'    => array(
                array('title' => 'One card with certificates', 'text' => 'The only card carries the marks and the link.', 'marks' => array('iso', 'qa'), 'link' => $nv_sec_link),
            ),
            'regional' => array(
                'title_plain'  => 'Data stays in ',
                'title_accent' => 'your jurisdiction',
                'text'         => 'On-premises or hybrid deployment keeps templates and personal data in your country.',
                'flags'        => array('eu', 'sg'),
                'map'          => false,
            ),
        ),
    ),
);
