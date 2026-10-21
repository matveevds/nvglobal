<?php
/**
 * Стандартное содержимое блока Integration (template-parts/integration-section.php) для KYC / Solutions / продуктовых страниц.
 * Партиал ничего не зашивает — страница берёт этот набор и переопределяет нужное: array_merge(nv_integration_preset(), array(...)).
 */

if (!defined('ABSPATH')) {
    exit;
}

function nv_integration_preset(): array {
    return array(
        'section_id'   => 'integration',
        'badge'        => 'Integration',
        'heading'      => 'Seamless Integration That Just Works',
        'subtitle'     => 'Integration under an&nbsp;hour, on&nbsp;your terms',
        'docs_text'    => 'View documentation',
        'docs_url'     => home_url('/docs/'),
        'contact_text' => 'Talk to integration team',
        'contact_form' => 'open-callForm2',
        'path_title'   => 'Choose Your Integration Path',
        'slides'       => array(
            array('title' => 'API Integration', 'subtitle' => '', 'description' => 'Direct backend integration for maximum control and extensive customisation options.'),
            array('title' => 'Web SDK & Widget', 'subtitle' => '', 'description' => 'Drop our embeddable verification widget into your website with just a few lines of code.'),
            array('title' => 'Mobile SDK', 'subtitle' => 'iOS & Android', 'description' => 'Native SDKs that bring document scanning and selfie capture directly into your mobile app.'),
        ),
        'includes'     => array(
            'title' => 'Every integration includes:',
            'items' => array(
                'step-by-step implementation guides',
                'sandbox with test data',
                'dedicated technical support',
                'an account manager who speaks both business and tech',
                'regular check-ins',
            ),
        ),
        'deploy'       => array('title' => 'Cloud, on-premises or&nbsp;hybrid', 'note' => 'data stays in your jurisdiction', 'img' => 'sol-int-servers', 'w' => 335, 'h' => 224),
        'backoffice'   => array(
            'title' => 'Back-office included',
            'chips' => array('scenario builder', 'stop-lists', 'manual review and analytics'),
            'img'   => 'sol-int-folders',
            'w'     => 252,
            'h'     => 176,
        ),
    );
}
