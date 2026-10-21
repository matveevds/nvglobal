<?php
/**
 * Стресс-кадры блока Certs (`template-parts/certs-section`): минимум / норма / максимум.
 * Возвращает slug => array(part, args); подмешивается inc/bloki-stress.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/kyc-icons.php';

$nv_ce_long_t = 'An unusually long heading that keeps going across several lines to prove that nothing collides or gets clipped';
$nv_ce_marks  = array(
    array('img' => 'kyc-cert-iso', 'w' => 80, 'h' => 80, 'alt' => 'ISO register global certification mark'),
    array('img' => 'kyc-cert-asib', 'w' => 62, 'h' => 80, 'alt' => 'ASIB certification mark'),
    array('img' => 'kyc-cert-qa', 'w' => 80, 'h' => 80, 'alt' => 'QA Compliance Assessment certification mark', 'round' => true),
);

return array(
    'certs-min' => array(
        'part' => 'template-parts/certs-section',
        'args' => array(
            'title' => 'Trusted by banks',
        ),
    ),
    'certs-norm' => array(
        'part' => 'template-parts/certs-section',
        'args' => array(
            'section_id' => 'certs-norm',
            'title'      => 'Independently tested and certified',
            'marks'      => $nv_ce_marks,
            'chips'      => array('ISO/IEC 27001:2022', 'GDPR'),
        ),
    ),
    'certs-max' => array(
        'part' => 'template-parts/certs-section',
        'args' => array(
            'section_id' => 'certs-max',
            'title'      => $nv_ce_long_t,
            'marks'      => array_merge($nv_ce_marks, array(
                array('img' => 'kyc-cert-iso', 'w' => 80, 'h' => 80, 'alt' => 'Second ISO mark', 'href' => 'https://example.com/certificate'),
                array('img' => 'kyc-cert-asib', 'w' => 62, 'h' => 80, 'alt' => 'Second ASIB mark'),
                array('img' => 'kyc-cert-qa', 'w' => 80, 'h' => 80, 'alt' => 'Second QA mark', 'round' => true),
            )),
            'chip_icon'  => nv_kyc_icon('check', 20),
            'chips'      => array(
                'ISO/IEC 27001:2022',
                'GDPR',
                'A very long chip label that has to wrap onto several lines when the row is narrow enough to need it',
                'NIST FRVT 1:1 and 1:N, tested at scale',
                array('text' => 'FATF-aligned AML', 'icon' => nv_kyc_icon('shield', 20)),
            ),
        ),
    ),
    'certs-chips-only' => array(
        'part' => 'template-parts/certs-section',
        'args' => array(
            'chip_icon' => nv_kyc_icon('check', 20),
            'chips'     => array('NIST FRVT', 'ISO/IEC 27001:2022', 'GDPR', 'FATF-aligned AML'),
        ),
    ),
);
