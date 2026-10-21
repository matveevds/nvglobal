<?php
/**
 * Стресс-кадры блока #14 «Contacts + FAQ» (картотека, `?nv_bloki_stress=<slug>`).
 *
 * Возвращает slug => array(part, args); подмешивается inc/bloki-stress.php.
 * Contacts и FAQ — светлый блок: его вид задан списками `body.page-template-…` (трогать нельзя), а кадр
 * идёт без body-класса страницы, поэтому для своих кадров ниже добавляется класс семейства KYC — так же,
 * как его получает любая страница, собранная из блоков (inc/page-builder.php).
 */

if (!defined('ABSPATH')) {
    exit;
}

$nv_cf_slugs = array('faq-min', 'faq-max', 'contacts-custom');

add_filter('body_class', static function (array $classes) use ($nv_cf_slugs): array {
    $slug = isset($_GET['nv_bloki_stress']) ? sanitize_key((string) wp_unslash($_GET['nv_bloki_stress'])) : '';
    if (in_array($slug, $nv_cf_slugs, true)) {
        $classes[] = 'page-template-page-kyc';
    }
    return $classes;
}, 20);

$nv_cf_long_q = 'An unusually long question that keeps going across several lines to prove that the accordion header never collides with the chevron or gets clipped?';
$nv_cf_long_a = 'This answer is deliberately long. It carries several sentences so that the open panel has to grow in height instead of clipping the text: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries and territories, and long words like internationalisation.';

$nv_cf_faq_max = array();
for ($i = 1; $i <= 12; $i++) {
    $item = array(
        'question' => 1 === $i % 3 ? $nv_cf_long_q : 'Question number ' . $i . ' — how does it work in practice?',
        'answer'   => array(
            $nv_cf_long_a . ' See the <a href="https://nv.global/docs/">integration documentation</a> for the full list.',
            0 === $i % 2
                ? 'A second paragraph with a <a href="https://example.com/very/long/path/that-has-no-natural-break-points/internationalisation-and-localisation-of-document-templates?utm_source=stress&amp;utm_medium=faq" target="_blank" rel="noopener noreferrer">very long link that must wrap instead of widening the card</a>, <strong>bold text</strong>, <em>emphasis</em> and a line<br>break.'
                : '',
        ),
    );
    if (1 === $i) {
        $item['initial_open'] = true;
    }
    $nv_cf_faq_max[] = $item;
}

return array(
    'faq-min' => array(
        'part' => 'template-parts/faq-section',
        'args' => array(
            'section_id'  => 'faq-min',
            'title'       => 'FAQ',
            'description' => 'Two questions only.',
            'items'       => array(
                array(
                    'question'     => 'How long does a check take?',
                    'answer'       => array('Usually under a second. Details are in the <a href="https://nv.global/docs/">documentation</a>.'),
                    'initial_open' => true,
                ),
                array(
                    'question' => 'Is there a sandbox?',
                    'answer'   => array('Yes, with test data and a test API key.'),
                ),
            ),
        ),
    ),
    'faq-max' => array(
        'part' => 'template-parts/faq-section',
        'args' => array(
            'section_id'  => 'faq-max',
            'title'       => $nv_cf_long_q,
            'description' => $nv_cf_long_a . ' <a href="https://nv.global/docs/">Read the docs</a>.',
            'items'       => $nv_cf_faq_max,
        ),
    ),
    'contacts-custom' => array(
        'part' => 'template-parts/contacts-section',
        'args' => array(
            'section_id' => 'start-pilot',
            'badge'      => 'Start a pilot',
            'title'      => 'An unusually long heading that keeps going across several lines to prove that the form block holds together',
            'lead'       => 'This lead is deliberately long. It carries several sentences so that the heading block has to grow in height while the contact card and the form next to it stay aligned and nothing is clipped or overlapped.',
        ),
    ),
);
