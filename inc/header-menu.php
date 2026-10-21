<?php
/**
 * Данные глобальной шапки (Header): структура меню, ссылки, языки.
 *
 * Единственное место, где живёт состав навигации: header.php только выводит
 * этот массив. Источник структуры — Figma NV Global (Header, Full HD / Desktop /
 * Tablet / Mobile, узлы перечислены в docs/DECISIONS.md, Р-141).
 *
 * Ссылки:
 *  - 'exists' => true  — страница есть на сайте, URL реальный;
 *  - 'exists' => false — страницы ещё нет, URL плановый (SEO-slug будущей
 *    страницы). Сами страницы здесь не создаются; до их появления ссылка
 *    отдаёт 404 — это ожидаемо. Таблица «меню → URL» — docs/DECISIONS.md, Р-141.
 *
 * Ничего не выдумано: подпункты, для которых в Figma стоит «Lorem Ipsum»,
 * заменены реальными пунктами сайта (документация KYC, продукты в чипах
 * индустрий) либо не выводятся. Подробности — docs/BACKLOG.md.
 */

/**
 * Пункт меню: ['label' => …, 'url' => …, 'exists' => bool].
 */
function nv_header_link(string $label, string $path, bool $exists): array {
    return ['label' => $label, 'url' => home_url($path), 'exists' => $exists];
}

/**
 * «2 days ago». Сайт английский, а локаль WordPress может быть другой, поэтому
 * human_time_diff() с его переводом не используем.
 */
function nv_header_ago(int $timestamp): string {
    $diff  = max(0, time() - $timestamp);
    $units = [[31536000, 'year'], [2592000, 'month'], [604800, 'week'], [86400, 'day'], [3600, 'hour'], [60, 'minute']];

    foreach ($units as [$seconds, $name]) {
        if ($diff >= $seconds) {
            $n = (int) floor($diff / $seconds);
            return $n . ' ' . $name . (1 === $n ? '' : 's') . ' ago';
        }
    }

    return 'Just now';
}

/**
 * Последние записи блога для панелей Industries и Resources.
 * Пока опубликованных записей нет — вернёт пустой массив, и блок не выводится.
 */
function nv_header_latest_posts(int $limit = 3): array {
    static $cache = null;

    if (null === $cache) {
        $cache = [];
        $query = new WP_Query([
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $limit,
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ]);

        foreach ($query->posts as $post) {
            $cache[] = [
                'title' => get_the_title($post),
                'url'   => get_permalink($post),
                'ago'   => nv_header_ago((int) get_post_time('U', true, $post)),
                'thumb' => get_the_post_thumbnail_url($post, 'medium_large') ?: '',
            ];
        }
        wp_reset_postdata();
    }

    return $cache;
}

function nv_header_menu(): array {
    $kyc_docs = [
        nv_header_link('General information',        '/docs/products/kyc/general-information/',        true),
        nv_header_link('Architecture and components', '/docs/products/kyc/architecture-and-components/', true),
        nv_header_link('API and integration',        '/docs/products/kyc/api-and-integration/',        true),
        nv_header_link('REST API',                   '/docs/products/kyc/api-and-integration/rest-api/', true),
        nv_header_link('Web SDK',                    '/docs/products/kyc/api-and-integration/web-sdk/', true),
        nv_header_link('Recognizable documents',     '/docs/products/kyc/recognizable-documents/',     true),
        nv_header_link('Errors',                     '/docs/products/kyc/errors/',                     true),
        nv_header_link('FAQ',                        '/docs/products/kyc/faq/',                        true),
    ];

    // Продукты из Figma. Описания — из макета (KYC) и из секции Products
    // страницы Solutions; для остальных текст не выдумываем. Ссылки ведут на
    // реальные страницы (slug верхнего уровня); у KYT страницы пока нет —
    // плановый /products/kyt/ с 'exists' => false.
    $products = [
        ['id' => 'kyc', 'link' => nv_header_link('KYC & eKYC', '/kyc/', true),
         'desc' => 'Automated KYC and eKYC Verification for Fast, Compliant Onboarding', 'links' => $kyc_docs],
        ['id' => 'identity', 'link' => nv_header_link('Identity Verification', '/identity-verification/', true)],
        ['id' => 'document', 'link' => nv_header_link('Document Verification', '/document-verification/', true)],
        ['id' => 'face', 'link' => nv_header_link('Face Verification', '/face-verification/', true)],
        ['id' => 'liveness', 'link' => nv_header_link('Liveness Detection', '/liveness/', true),
         'desc' => 'A live person, not a photo, video or mask — deepfake-resistant; password-free login by face.'],
        ['id' => 'aml', 'link' => nv_header_link('AML Screening', '/aml/', true),
         'desc' => 'Screening against 1,700+ databases: OFAC, EU, UK, UN, PEP lists and adverse media; daily re-screening.'],
        ['id' => 'kyb', 'link' => nv_header_link('KYB', '/kyb/', true),
         'desc' => 'Corporate structure down to the UBO, registry checks and signatory verification.'],
        ['id' => 'kyt', 'link' => nv_header_link('KYT', '/products/kyt/', false),
         'desc' => 'Real-time risk scoring of crypto transactions, wallets and addresses.'],
    ];

    // Продукты, на которые ссылаются чипы индустрий на странице Solutions.
    $chip = [
        'KYC'      => $products[0]['link'],
        'AML'      => $products[5]['link'],
        'KYT'      => $products[7]['link'],
        'Liveness' => $products[4]['link'],
        'Face'     => $products[3]['link'],
    ];

    $industries = [
        ['label' => 'Banks',               'path' => '/industries/banks/',            'chips' => ['KYC', 'AML', 'Liveness']],
        ['label' => 'FinTech & lending',   'path' => '/industries/fintech-lending/',  'chips' => ['KYC', 'AML', 'KYT']],
        ['label' => 'Crypto Exchanges',    'path' => '/industries/crypto-exchanges/', 'chips' => ['KYC', 'AML', 'KYT']],
        ['label' => 'Telecom',             'path' => '/industries/telecom/',          'chips' => ['KYC', 'Liveness', 'Face']],
        ['label' => 'Gambling & betting',  'path' => '/industries/gambling-betting/', 'chips' => ['KYC', 'Liveness']],
        ['label' => 'Government',          'path' => '/industries/government/',       'chips' => ['KYC']],
    ];

    foreach ($industries as &$group) {
        $group['link']  = nv_header_link($group['label'], $group['path'], false);
        $group['links'] = array_map(static fn($key) => $chip[$key], $group['chips']);
        unset($group['path'], $group['chips']);
    }
    unset($group);

    $blog_page    = get_page_by_path('blog');
    $blog_page_ok = $blog_page && 'publish' === $blog_page->post_status;
    $blog_page_url = $blog_page_ok ? get_permalink($blog_page) : home_url('/blog/');

    $blog_id  = (int) get_option('page_for_posts');
    $blog_url = $blog_id > 0 ? get_permalink($blog_id) : home_url('/blog/');

    return [
        'products' => [
            'label'    => 'Products',
            'items'    => $products,
            'cta'      => nv_header_link('Discover our solution', '/solutions/', true),
            'details'  => 'Details',
            // Видео в теме нет — карточка не интерактивна, пока не задан 'url'.
            'promo'    => [
                'title' => 'Confidence in every client',
                'text'  => 'Watch our introductory video to find out how we can help improve your business',
                'image' => 'header-promo-video.webp',
                'url'   => '',
            ],
        ],
        'industries' => [
            'label'  => 'Industries',
            'title'  => 'Identity verification for regulated industries',
            'text'   => 'Banks, fintechs, exchanges, telecoms and government services run onboarding, compliance and payments on one NV Global platform — pick your industry or your product.',
            'cta'    => nv_header_link('More about industries', '/solutions/#industries', true),
            'groups' => $industries,
            'blog'   => [
                'title' => 'Read our blog to find out how our solutions are tailored to different sectors',
                'posts' => nv_header_latest_posts(),
            ],
        ],
        'resources' => [
            'label'  => 'Resources',
            'banner' => [
                'text' => 'Our specialist media platform dedicated to anti-fraud measures, KYC checks and facial recognition',
            ],
            'links'  => [
                ['label' => 'Blog',  'url' => $blog_url,           'exists' => $blog_id > 0 && 'publish' === get_post_status($blog_id)],
                nv_header_link('News',  '/news/',  false),
                nv_header_link('Video', '/video/', false),
            ],
            // Из четырёх иконок макета (Telegram, LinkedIn, WhatsApp, YouTube) в теме
            // есть реальный адрес только у LinkedIn (BACKLOG R-22…R-24).
            'social' => [
                ['label' => 'LinkedIn', 'icon' => 'linkedin', 'url' => 'https://www.linkedin.com/company/nvglobal-ai/posts/'],
            ],
            'latest' => nv_header_latest_posts(),
        ],
        // Простая ссылка вместо выпадающего Resources (решение владельца 2026-10-21, Р-141): страница со slug blog,
        // если она опубликована, иначе плановый /blog/.
        'blog'    => ['label' => 'Blog', 'url' => $blog_page_url, 'exists' => $blog_page_ok],
        'docs'    => nv_header_link('Docs',    '/docs/',           true),
        'pricing' => nv_header_link('Pricing', '/pricing-matrix/', true),
        'cta'     => ['label' => 'Start Free Trial', 'modal' => 'open-callForm2'],
        'cta2'    => ['label' => 'Book a demo',      'modal' => 'open-callForm'],
    ];
}

/**
 * Язык интерфейса. Мультиязычности в теме нет: активен только английский,
 * остальные пункты инертны (кнопки без перехода). Код языка лежит в
 * data-language-code для будущей интеграции.
 */
function nv_header_languages(): array {
    return [
        ['code' => 'en', 'label' => 'English',  'flag' => 'us', 'current' => true],
        ['code' => 'es', 'label' => 'Español',  'flag' => 'es', 'current' => false],
        ['code' => 'de', 'label' => 'Deutsch',  'flag' => 'de', 'current' => false],
        ['code' => 'fr', 'label' => 'Français', 'flag' => 'fr', 'current' => false],
        ['code' => 'pt', 'label' => 'Português', 'flag' => 'pt', 'current' => false],
    ];
}

/**
 * Какой пункт верхнего уровня соответствует текущей странице.
 * Возвращает ключ: products | industries | resources | blog | docs | pricing | ''. Блог (запись, архив, рубрика, автор, поиск) → 'blog'; 'resources' сейчас не выводится.
 */
function nv_header_current(): string {
    if (is_page_template('page-docs.php') || is_singular('document')) {
        return 'docs';
    }
    if (is_page_template('page-price-matrix.php')) {
        return 'pricing';
    }
    if (is_page('blog') || is_singular('post') || is_home() || is_category() || is_tag() || is_date() || is_author() || is_search()) {
        return 'blog';
    }
    return '';
}
