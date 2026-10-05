# WORDPRESS — что нельзя ломать

Тема обслуживает живой сайт. Вёрстка в ней почти вся статическая, но несколько мест
держат реальные данные. Их список ниже — он короткий, выучить его дешевле, чем чинить.

---

## 1. Неприкосновенное

- Не подменять `get_field()`, `get_sub_field()`, `have_rows()`, `the_content()`,
  `WP_Query`, `have_posts()` / `the_post()` статическим HTML.
- Не удалять циклы WordPress.
- Не снимать `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses()`; экранирование — по контексту.
- Не убирать `check_ajax_referer()`, `wp_verify_nonce()`, `current_user_can()`, `sanitize_*`.
- Пути к ассетам — только `get_template_directory_uri()`, ссылки — `home_url()`.
  Не вписывать `https://nvglobal.local` и не хардкодить `/wp-content/themes/nvglobal/`.
- Не трогать роутинг, `permalink_structure`, `show_on_front` / `page_on_front`.
- `style.css`: `Theme Name: NVGlobal` и `Text Domain` завязаны на имя папки темы — **не менять**.

---

## 2. Динамические острова — полный список

Всё остальное в шаблонах можно считать статикой.

### 2.1 `page-price-matrix.php` — самая «живая» страница
Тарифы и пакеты целиком на ACF: `tarif-group`, `tarif-group-name`, `tarif-group-description`,
`service-name`, `service-description`, `service-list`, `service-subgroup-name`,
`service-tariffs`, `doc_price`, `basic-price`, `advanced-price`, `international_price`.

Цены калькулятора регистрирует `inc/calculator-fields.php`
(`calc_document_price_10k/50k/100k`, `calc_basic_price_*`) и отдаёт в `data-`атрибуты `#kyc-calculator`.

> **Ловушка:** читать их в JS через `dataset` **нельзя**. В `data-document-price-10k`
> дефис перед цифрой не срезается, ключ выходит `documentPrice-10k`, и обращение к
> `documentPrice10k` молча падает на fallback. Только `getAttribute()`.
> Пороги объёмов (10 000 / 50 000 / 100 000) захардкожены в `js/calculate.js`
> (`MIN_VOLUME` / `MID_VOLUME` / `MAX_VOLUME`) и в подписях слайдера.

### 2.2 `header.php:71`
`get_field('use_captcha', 'options')` → `data-use-captcha` на `<body>`. От него зависит hCaptcha в формах.

### 2.3 `main-page.php:1077`
Репитер `reviews` (`reviews_short`, `reviews_author`, `reviews_company`, `reviews_logo`,
`reviews_image`, `reviews_text`).
Секция обёрнута в `<?php if (false) : ?>` на строке 1048 — **выключена намеренно**,
данные в БД есть (1 отзыв). Не включать и не удалять без указания.

### 2.4 Документация
`inc/docs-menu.php` собирает дерево CPT `document` и кэширует в
`wp-content/uploads/nv-docs-cache/menu.html`. Сброс — на `save_post_document`,
`deleted_post`, `trashed_post`, `untrashed_post`, `permalink_structure_changed`.
Точка расширения для сброса полностраничного кэша — экшен `nv_docs_menu_flushed`.
Вызывается из `single-document.php` и `page-docs.php`.

### 2.5 Блог
`WP_Query` в `category.php`, `author.php`, `search.php`, `blog-page.php`.
Опубликованных записей сейчас 0 — страницы пустые, но код рабочий. **Не удалять.**

### 2.6 ACF-блоки
19 блоков в `blocks/*/`, регистрируются в `nv_register_acf_blocks()` на `acf/init`.
У каждого свои `block.json`, `*.php`, `*.css`, `*.editor.css`, у некоторых `*.js`.
Используются в статьях блога и документации.

---

## 3. Подключение ассетов

Всё через `my_theme_enqueue_assets()` (`functions.php:73`, приоритет 10).
Новые файлы — только туда, никаких `<link>` и `<script src>` в шаблонах.

Порядок зависимостей стилей:
`swiper-css`, `locomotive-css` → `theme-styles` (`css/styles.css`) → `theme-main-style`
(`style.css`) → `post-styles`, `blog-styles`. Условно: `document-toc-styles`.

`main-js` зависит от всех библиотек и от `form-js` — порядок не переставлять.

Версия ассетов — константа `THEME_ASSETS_VER` (`functions.php:16`, сейчас `1.0.50`).
**Менял CSS или JS — подними её**, иначе браузеры и Seraphinite отдадут старое.

### Известные неточности (не исправлять походя)
- `is_page_template('page-price-matrix-en.php')` — такого файла в теме нет.
- `post.css` и `blog.css` грузятся на всех страницах, хотя нужны только блогу и статьям.
- Виджет NeVi (`functions.php:23–30`) тянется с внешнего домена
  `nevi-gateway.erpprog.workers.dev` на каждой странице.

---

## 4. Хуки темы

Перехватывают вывод — учитывать при правках разметки:

| Хук | Функция | Что делает |
|---|---|---|
| `after_setup_theme` | `theme_setup` | `title-tag`, `post-thumbnails`, `html5` |
| `wp_enqueue_scripts` (1) | `nvglobal_enqueue_nevi_widget` | виджет NeVi |
| `wp_enqueue_scripts` (10) | `my_theme_enqueue_assets` | стили и скрипты темы |
| `wp_body_open`, `wp_footer` | `nvglobal_render_nevi_widget_root` | корень виджета |
| `the_content` | `nv_add_ids_to_post_headings` | добавляет `id` к h2/h3/h4 в записях |
| `wp_generate_attachment_metadata` | `blog_generate_image_sizes` (20), `td_generate_image_sizes` (30) | размеры картинок |
| `wp` | `nv_setup_404_seo`, `nv_count_post_views` | SEO 404, счётчик просмотров |
| `acf/init` | `nv_register_acf_blocks` | 19 блоков |
| `block_categories_all` | `nv_add_block_category` | категория `neurovision` |
| `save_post` | `nv_set_random_post_stats_on_create` | стартовые лайки/просмотры |
| `phpmailer_init` | — | SMTP из ACF-опций |
| `show_admin_bar` | `__return_false` | админбар скрыт |

`header.php` обязан содержать `wp_head()` и `wp_body_open()`, `footer.php` — `wp_footer()`.

---

## 5. AJAX

| Действие | Функция | nonce |
|---|---|---|
| `send_contacts_form` | `handle_contacts_form_submission` | `send_contacts_form_nonce` |
| `nv_update_likes` | `nv_update_likes` | `nv_likes_nonce` |
| `nv_blog_search` | `nv_blog_search` | `nv_blog_search_nonce` |
| `nv_load_more_posts` | `nv_load_more_posts` | `nv_load_more_posts_nonce` |

Все nonce отдаются в JS через `wp_localize_script('form-js', 'themeFormData', …)`.
Меняешь имя действия — правь обе стороны.

Заявки уходят по SMTP, в Telegram и в HubSpot; каналы включаются ACF-опциями
`send_mail`, `send_tg`, `send_hubspot`. **Формы на локальном сайте не отправлять** —
уйдут реальные письма и сообщения.

---

## 6. SEO и Schema

Целиком на Yoast SEO. Тема добавляет только `nv_setup_404_seo` и фильтр
`wpseo_enhanced_slack_data`. Собственной разметки JSON-LD в теме нет —
не добавлять, будет конфликт с Yoast.

Известный хвост на проде: в JSON-LD Yoast стоит `"name":"NeuroVision Global"` без `Systems`.
Это опции `wpseo_titles` (`website_name`, `company_name`), правится в
**SEO → Настройки → Представление сайта**, не в коде.

---

## 7. Мультиязычность

Плагина нет, тема `pll_*` / `icl_*` не использует, сайт одноязычный английский.

В БД остались следы Polylang: таксономии `language` (Русский / English), `term_language`,
`post_translations`, `term_translations`, плюс 6 меню `nav_menu` в парах RU/EN.
Тема их не читает. **Не удалять и не «чинить»** — см. `docs/THEME-TODO.md`.

---

## 8. Меню

`register_nav_menus()` не вызывается. Навигация в `header.php` — статический `<ul>`
с `home_url()` и якорями (`#about`, `#solutions`, `#products`, `#advantages`,
`#clients`, `#cases`, `/pricing-matrix/`, `/docs/`, `#contacts`).

Якоря должны совпадать с `id` секций в `main-page.php`. Переименовал `id` секции —
поправь ссылку в шапке и `data-offset` в `.page-nav`.

Перевод навигации на `wp_nav_menu()` — отдельная задача, не побочный эффект правки вёрстки.

---

## 9. Прод

У пользователя там только админка WordPress: **нет доступа к БД и WP-CLI**.
Любые изменения контента и опций расписывать маршрутом по экранам админки, а не SQL.

Плагина массовой замены (Better Search Replace) на сайте нет.

Бренд и юрлицо — разные вещи:
- бренд / товарный знак — **NeuroVision Global Systems**;
- уставное наименование — **NEUROVISION GLOBAL INTELLIGENCE - FZCO**
  (в Privacy policy #306, Terms of use #314, Information Security Policy #582).

`NEUROVISION GLOBAL INTELLIGENCE - FZCO` в юридических страницах **менять нельзя** —
это не старое написание бренда.
