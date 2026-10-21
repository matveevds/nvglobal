<?php
/**
 * Картотека блоков: режим кадра и страница каталога.
 *
 * Страницы сайта держат варианты блоков на body-классах, а JS-инициализаторы берут только
 * первый экземпляр на странице, поэтому блоки каталога показываются не копиями разметки, а
 * «кадрами» настоящих страниц: `?nv_block=<css-селектор>` оставляет видимой только целевую
 * секцию — со своим body-классом, своими стилями и своим JS. Gutenberg-блоки показываются
 * в оболочке записи (`?nv_bloki_demo=<slug>`).
 *
 * Всё доступно только авторизованному администратору (`manage_options`); всем остальным, включая
 * редакторов и гостей, любой из параметров каталога (`nv_bloki`, `nv_bloki_demo`, `nv_block`) отдаёт 404.
 * В БД ничего не пишется.
 *
 * Ограничения темы: header.php / footer.php не менялись — только хуки.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Каталог, кадры и демо доступны только авторизованному администратору. */
function nv_block_catalog_can(): bool {
    return is_user_logged_in() && current_user_can('manage_options');
}

/** В запросе есть любой параметр каталога — независимо от прав. */
function nv_block_catalog_requested(): bool {
    return isset($_GET['nv_bloki']) || isset($_GET['nv_bloki_demo']) || isset($_GET['nv_bloki_stress']) || isset($_GET['nv_block']);
}

/* Не-администратору параметры каталога отдают 404 (а не обычную страницу): каталог для него не существует.
   template_redirect идёт до выбора шаблона — WP сам подставит 404.php. */
add_action('template_redirect', function () {
    if (!nv_block_catalog_requested() || nv_block_catalog_can()) {
        return;
    }
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
}, 0);

/* Без этого redirect_canonical на 404 «угадывает» похожую запись (/kyc/?nv_block= → 301 на
   /docs/products/kyc/?nv_block=) вместо 404. */
add_filter('redirect_canonical', function ($redirect_url) {
    return (nv_block_catalog_requested() && !nv_block_catalog_can()) ? false : $redirect_url;
});

/**
 * Селектор целевого блока из `?nv_block=`. Whitelist символов (без `{ } ; < > , \ @ /`), без запятых,
 * длина до 200; пустая строка — режим выключен. Только для nv_block_catalog_can() (администратор).
 */
function nv_block_frame_selector(): string {
    static $cache = null;
    if (null !== $cache) {
        return $cache;
    }
    $cache = '';
    if (!isset($_GET['nv_block']) || !nv_block_catalog_can()) {
        return $cache;
    }
    $sel = trim((string) wp_unslash($_GET['nv_block']));
    if ('' === $sel || strlen($sel) > 200) {
        return $cache;
    }
    if (!preg_match('/^[A-Za-z0-9_\-\.\#\:\>\+\~\[\]\(\)="\' ]+$/', $sel)) {
        return $cache;
    }
    $cache = $sel;
    return $cache;
}

function nv_is_block_frame(): bool {
    return '' !== nv_block_frame_selector();
}

/** Страница каталога: `?nv_bloki=1`. */
function nv_is_block_catalog(): bool {
    return isset($_GET['nv_bloki']) && !isset($_GET['nv_bloki_demo']) && !isset($_GET['nv_bloki_stress']) && nv_block_catalog_can();
}

/**
 * Slug стресс-кадра универсального блока: `?nv_bloki_stress=steps-max` (только из реестра inc/bloki-stress.php).
 * Блок выводится в пустой оболочке без body-класса страницы — так проверяется независимость вида от страницы.
 */
function nv_block_stress_slug(): string {
    static $cache = null;
    if (null !== $cache) {
        return $cache;
    }
    $cache = '';
    if (!isset($_GET['nv_bloki_stress']) || !nv_block_catalog_can()) {
        return $cache;
    }
    $slug = sanitize_key((string) wp_unslash($_GET['nv_bloki_stress']));
    if ('' !== $slug && isset(nv_block_stress_registry()[$slug])) {
        $cache = $slug;
    }
    return $cache;
}

/** Реестр стресс-кадров: slug => array(part, args). */
function nv_block_stress_registry(): array {
    static $registry = null;
    if (null === $registry) {
        $registry = require get_template_directory() . '/inc/bloki-stress.php';
    }
    return $registry;
}

/** Slug демо-блока Gutenberg: `?nv_bloki_demo=callout` (только из реестра inc/bloki-data.php). */
function nv_block_demo_slug(): string {
    static $cache = null;
    if (null !== $cache) {
        return $cache;
    }
    $cache = '';
    if (!isset($_GET['nv_bloki_demo']) || !nv_block_catalog_can()) {
        return $cache;
    }
    $slug = sanitize_key((string) wp_unslash($_GET['nv_bloki_demo']));
    $demos = nv_block_catalog_demos();
    if ('' !== $slug && isset($demos[$slug])) {
        $cache = $slug;
    }
    return $cache;
}

/** Демо Gutenberg-блоков из данных каталога: slug => array(block, data). */
function nv_block_catalog_demos(): array {
    static $demos = null;
    if (null === $demos) {
        $demos = array();
        $data  = require get_template_directory() . '/inc/bloki-data.php';
        foreach ($data['groups'] as $group) {
            foreach ($group['blocks'] as $block) {
                if (!empty($block['demo']['slug'])) {
                    $demos[$block['demo']['slug']] = $block['demo'];
                }
            }
        }
    }
    return $demos;
}

/** Любой из режимов каталога активен (каталог, кадр или демо). */
function nv_block_catalog_active(): bool {
    return nv_is_block_catalog() || nv_is_block_frame() || '' !== nv_block_demo_slug() || '' !== nv_block_stress_slug();
}

/* Шаблон каталога / демо — вместо шаблона запрошенной страницы. */
add_filter('template_include', function ($template) {
    if (nv_is_block_catalog() || '' !== nv_block_demo_slug() || '' !== nv_block_stress_slug()) {
        $own = get_theme_file_path('page-bloki.php');
        if (file_exists($own)) {
            return $own;
        }
    }
    return $template;
}, 99);

/* Классы body: кадр — `nv-block-frame`; каталог — `nv-bloki` (без классов исходной страницы: токены и
   `.container` берутся из списков `body.nv-bloki`); демо — как запись блога (`single-post`). */
add_filter('body_class', function (array $classes): array {
    $strip = static function (array $list): array {
        return array_values(array_filter($list, static function ($c) {
            return !in_array($c, array('home', 'blog'), true) && 0 !== strpos($c, 'page-template');
        }));
    };
    if (nv_is_block_catalog()) {
        $classes = $strip($classes);
        $classes[] = 'nv-bloki';
    }
    if ('' !== nv_block_demo_slug()) {
        $classes = $strip($classes);
        $classes[] = 'single-post';
        $classes[] = 'nv-bloki-demo-page';
    }
    if ('' !== nv_block_stress_slug()) {
        $classes = $strip($classes);
        $classes[] = 'nv-bloki';
        $classes[] = 'nv-bloki-stress-page';
    }
    if (nv_is_block_frame() || '' !== nv_block_demo_slug() || '' !== nv_block_stress_slug()) {
        $classes[] = 'nv-block-frame';
    }
    return $classes;
});

/* noindex для всех режимов; панель администратора в кадре не нужна. */
add_filter('wp_robots', function (array $robots): array {
    if (nv_block_catalog_active()) {
        $robots['noindex']  = true;
        $robots['nofollow'] = true;
        unset($robots['max-image-preview']);
    }
    return $robots;
});

add_filter('show_admin_bar', function ($show) {
    return (nv_is_block_frame() || '' !== nv_block_demo_slug() || '' !== nv_block_stress_slug()) ? false : $show;
});

/**
 * Режим кадра: скрыть всё, что не целевой блок, не его предок и не его потомок. Правило общее
 * (не зависит от структуры страницы): шапка, подвал, тизер, cookie, виджеты и соседние секции
 * скрываются одним селектором. Модалки (`.modal`) остаются в DOM — кнопки блока их открывают.
 */
add_action('wp_head', function () {
    $sel = nv_block_frame_selector();
    if ('' === $sel && '' === nv_block_demo_slug() && '' === nv_block_stress_slug()) {
        return;
    }
    if ('' === $sel) {
        $sel = '' !== nv_block_stress_slug() ? '.nv-bloki-stress' : '.nv-bloki-demo';
    }
    /* `:is()` внутри `:has()`/`*`: селектор целевого блока (в т.ч. `main > .hero`) вычисляется от корня документа. */
    $keep = ':not(' . $sel . '):not(:has(:is(' . $sel . '))):not(:is(' . $sel . ') *)'
        . ':not(.modal):not(.modal *):not(script):not(style):not(link)';
    echo "<style id=\"nv-block-frame-css\">\n"
        . 'html{overflow-x:hidden;margin-top:0!important}'
        . 'body.nv-block-frame{margin:0!important;padding:0!important;min-height:0!important}'
        . 'body.nv-block-frame *' . $keep . '{display:none!important}'
        . "\n</style>\n";
}, 99);

/* Ассеты каталога — только на странице каталога. */
add_action('wp_enqueue_scripts', function () {
    if (!nv_is_block_catalog()) {
        return;
    }
    $uri = get_template_directory_uri();
    wp_enqueue_style('bloki-styles', $uri . '/css/bloki.css', array('theme-main-style'), THEME_ASSETS_VER);
    wp_enqueue_script('bloki-js', $uri . '/js/bloki.js', array(), THEME_ASSETS_VER, true);
}, 20);

/* Заголовок вкладки каталога. */
add_filter('pre_get_document_title', function ($title) {
    return nv_is_block_catalog() ? 'Каталог блоков — NeuroVision Global' : $title;
});

/* NeVi не грузим в каталоге, кадрах и демо: виджет не нужен, перекрывает контент и утяжеляет ~100 кадров. */
add_action('wp_enqueue_scripts', function () {
    if (nv_block_catalog_active()) {
        remove_action('wp_enqueue_scripts', 'nvglobal_enqueue_nevi_widget', 1);
    }
}, 0);
