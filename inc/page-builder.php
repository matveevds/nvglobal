<?php
/**
 * Страницы, собранные из блоков библиотеки (агент «Сборщик страниц», регламент — docs/PAGE_BUILDER.md).
 *
 * Шаблон такой страницы — `page-<slug>.php` в корне темы с двумя заголовками в шапке файла:
 *   Template Name: <название для списка шаблонов в админке>
 *   NV Page Family: identity | kyc | solutions
 *
 * «Семейство» — существующая страница, чьё оформление наследует новая. Стили блоков, светлые
 * шапка / тизер / подвал / Contacts / FAQ и контракт отступов `--nv-block-space` написаны под
 * body-класс шаблона-источника (`body.page-template-page-identity-verification …`, ≈640 правил
 * у Identity). Новой странице добавляется body-класс семейства, и блоки выглядят как на
 * странице-источнике без копирования CSS. Каждый новый шаблон — один самостоятельный файл:
 * регистрировать его где-то ещё не нужно.
 *
 * Предпросмотр без создания страницы в БД (только администратор, остальным 404):
 *   https://nvglobal.local/kyc/?nv_page_preview=page-<slug>.php
 * Текущая обычная страница (не главная) на время запроса «получает» указанный шаблон:
 * `is_page_template()`, body-классы и выбор файла шаблона работают как у настоящей страницы.
 * Заголовок вкладки и Yoast-мета при этом остаются от страницы-основы.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Семейство => body-класс шаблона-источника. */
function nv_page_families(): array {
    return array(
        'identity'  => 'page-template-page-identity-verification',
        'kyc'       => 'page-template-page-kyc',
        'solutions' => 'page-template-page-solutions',
    );
}

/** Семейство шаблона по заголовку `NV Page Family` ('' — не шаблон сборщика). */
function nv_page_family_of(string $template): string {
    static $cache = array();
    if (isset($cache[$template])) {
        return $cache[$template];
    }
    $cache[$template] = '';
    if (!preg_match('/^page-[a-z0-9-]+\.php$/', $template)) {
        return '';
    }
    $path = get_theme_file_path($template);
    if (!is_file($path)) {
        return '';
    }
    $data   = get_file_data($path, array('family' => 'NV Page Family'));
    $family = strtolower(trim((string) $data['family']));
    if (isset(nv_page_families()[$family])) {
        $cache[$template] = $family;
    }
    return $cache[$template];
}

/** Шаблон из `?nv_page_preview=` — только администратору и только шаблон сборщика. */
function nv_page_preview_template(): string {
    static $cache = null;
    if (null !== $cache) {
        return $cache;
    }
    $cache = '';
    if (!isset($_GET['nv_page_preview']) || !is_user_logged_in() || !current_user_can('manage_options')) {
        return $cache;
    }
    $tpl = (string) wp_unslash($_GET['nv_page_preview']);
    if ('' !== nv_page_family_of($tpl)) {
        $cache = $tpl;
    }
    return $cache;
}

/** Семейство текущей страницы ('' — обычная страница). */
function nv_page_family(): string {
    if (!is_page() || is_front_page()) {
        return '';
    }
    return nv_page_family_of((string) get_page_template_slug(get_queried_object_id()));
}

/* Предпросмотр: подменяем `_wp_page_template` только у запрошенной страницы и только после разбора
   запроса. Главная не годится как основа — её `body.home` (≈380 правил) исказит вид. */
add_filter('get_post_metadata', function ($value, $object_id, $meta_key) {
    if ('_wp_page_template' !== $meta_key || !did_action('wp')) {
        return $value;
    }
    $tpl = nv_page_preview_template();
    if ('' === $tpl || is_front_page() || (int) $object_id !== (int) get_queried_object_id()) {
        return $value;
    }
    return array($tpl);
}, 10, 3);

/* Не-администратору параметр предпросмотра отдаёт 404, как параметры картотеки. */
add_action('template_redirect', function () {
    if (!isset($_GET['nv_page_preview']) || (is_user_logged_in() && current_user_can('manage_options'))) {
        return;
    }
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
}, 0);

add_filter('redirect_canonical', function ($redirect_url) {
    return isset($_GET['nv_page_preview']) ? false : $redirect_url;
});

add_filter('wp_robots', function (array $robots): array {
    if ('' !== nv_page_preview_template()) {
        $robots['noindex']  = true;
        $robots['nofollow'] = true;
        unset($robots['max-image-preview']);
    }
    return $robots;
});

/* Body-класс семейства + маркер собранной страницы. */
add_filter('body_class', function (array $classes): array {
    $family = nv_page_family();
    if ('' !== $family) {
        $classes[] = nv_page_families()[$family];
        $classes[] = 'nv-built-page';
    }
    return $classes;
});
