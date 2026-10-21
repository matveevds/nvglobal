<?php
/**
 * Стресс-кадр блока Blog / News (`template-parts/news-section`): с главной блок убран (2026-10-21), ни одна страница
 * его сейчас не выводит, поэтому кадр картотеки — единственное место, где его видно.
 * Вид блока задан списками `body.home` / `body.page-template-page-identity-verification` (css/blocks/news.css), а кадр идёт
 * без body-класса страницы — для него добавляется класс Identity (как у остальных светлых блоков в кадрах).
 * Возвращает slug => array(part, args); подмешивается inc/bloki-stress.php.
 */
if (!defined('ABSPATH')) {
    exit;
}

add_filter('body_class', static function (array $classes): array {
    $slug = isset($_GET['nv_bloki_stress']) ? sanitize_key((string) wp_unslash($_GET['nv_bloki_stress'])) : '';
    if ('news-slider' === $slug) {
        $classes[] = 'page-template-page-identity-verification';
    }
    return $classes;
}, 20);

return array(
    'news-slider' => array(
        'part' => 'template-parts/news-section',
        'args' => array(),
    ),
);
