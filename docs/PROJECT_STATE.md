# PROJECT_STATE — проверенные факты

Первичный аудит: **2026-10-05**, baseline-коммит `bbfad4c` (2026-10-02).
Факты поддерживаются в актуальном состоянии. Последняя сверка: **2026-10-14**.

> **Дерево разобрано 2026-10-14** (коммиты `f378cb5`…`aaec395`). **Поверх него — новая глобальная
> шапка (Р-141), в рабочем дереве, не закоммичена, ждёт приёмки.** Файлы: `header.php`,
> `inc/header-menu.php`, `inc/header-icons.php`, `functions.php` (2 `require_once`), `css/styles.css`,
> `js/main.js`, 9 файлов `img/header-*`, документация.

Всё ниже получено чтением файлов, запросами к БД и обращениями к локальному сайту.
Непроверенное помечено явно.

---

## 1. Окружение

| Параметр | Значение |
|---|---|
| Корень темы | `/Applications/MAMP/htdocs/nvglobal.local/wp-content/themes/nvglobal` |
| Git-корень | совпадает с корнем темы (под версионным контролем только тема) |
| Remote | `git@github.com:matveevds/nvglobal.git` |
| **Локальный адрес** | **`https://nvglobal.local/`** — только HTTPS |
| Apache | MAMP, слушает **только порт 443**. `http://nvglobal.local/` не отвечает |
| Сертификат | самоподписанный → `curl -k`, в Playwright `ignoreHTTPSErrors: true` |
| MySQL | MAMP, порт **8889**, БД `nvglobal`, префикс `wp_`. Креды — в `wp-config.php` сайта, в репозиторий не выносим |
| PHP (CLI для скриптов) | `/Applications/MAMP/bin/php/php8.4.17/bin/php`. Системный `php` из Homebrew **не видит сокет MySQL** → `Error establishing a database connection`. Для скриптов с `wp-load.php` брать только бинарь MAMP |
| Сокет MySQL | `/Applications/MAMP/tmp/mysql/mysql.sock` |
| WordPress | **7.1.3** |
| ACF Pro | **6.3.11** — с WP 7.1.3 несовместим на канве редактора, см. раздел 12 и `BACKLOG.md` B-27 |
| WP-CLI | **отсутствует** |
| Playwright | доступен: в кэше npx (`find ~/.npm/_npx -maxdepth 4 -name playwright -type d`), Chromium установлен |
| MCP Figma | работает, ссылки получены. Карта node-id по страницам — раздел 13 |
| `WP_DEBUG` | `false` |

> Прод: доступ к БД и WP-CLI у пользователя отсутствует, работа только через админку WordPress.

---

## 2. Что реально отдаётся на сайте

`show_on_front = page`, `page_on_front = 420`, `page_for_posts = 0`.

| URL | Страница (ID) | Шаблон | HTTP | Вес HTML |
|---|---|---|---|---|
| `/` | main (420) | **`main-page.php`** | 200 | 582 KB |
| `/solutions/` | solutions (429) | `page-solutions.php` | 200 | 426 KB |
| `/pricing-matrix/` | pricing-matrix (939) | `page-price-matrix.php` | 200 | 398 KB |
| `/docs/` | docs (586) | `page-docs.php` | 200 | 242 KB |
| `/privacy-policy/` | 306 | `page-privacy.php` | 200 | — |
| `/terms-of-use/` | 314 | `page-privacy.php` | 200 | — |
| `/information-security-policy/` | 582 | `page-privacy.php` | 200 | — |
| `/docs/<...>/` | CPT `document`, 71 запись | `single-document.php` | 200 | — |
| несуществующий URL | — | `404.php` | 404 | — |

Страница `blog` (570) — **черновик**, шаблон `search.php`.

**Главная страница — это `main-page.php`.** `index.php` в отдаче не участвует:
`front-page.php` в теме нет, главная задана статической страницей.

### Контент, которого нет
- Записей `post`: **0 опубликованных**. Есть один черновик #1026 «Test blog 1» —
  тестовая запись, на ней проверялись блоки и светлый редизайн статьи; плюс 125 `auto-draft`
  (мусор от сессий редактора). Блог не наполнен.
- Следствие: `single.php`, `category.php`, `author.php`, `search.php`, `blog-page.php`,
  `template-parts/article-card.php`, `css/blog.css`, `css/post.css` — инфраструктура на будущее,
  сейчас на сайте не видна. **Удалять нельзя**, это готовый блог.
- С группы 6 секция Blog на главной тоже работает от `WP_Query`
  (`template-parts/news-card.php`). Пока записей нет — секция не выводится.
  До группы 6 она была статической и скрыта правилом `.news { display: none }`.
  Что нужно, чтобы она заработала, — в `BACKLOG.md`, R-17.

---

## 3. Шаблоны

Все 41 PHP-файла темы проходят `php -l` **без ошибок** (PHP 8.3.30).

### Активные
| Файл | Строк | Template Name | Роль |
|---|---|---|---|
| `main-page.php` | 1547 | Шаблон главной страницы | **главная**; форма Contacts вынесена в `template-parts/contacts-form.php` |
| `page-solutions.php` | 1176 | Шаблон страницы Solutions | `/solutions/`; **редизайн завершён**, группы 1–9, финальный визуальный аудит и overlay с Figma 2026-10-10 |
| `page-price-matrix.php` | 713 | KYC/AML Pricing Matrix | `/pricing-matrix/` + калькулятор; **светлый редизайн завершён 2026-10-13**, логика калькулятора не менялась (Р-131) |
| `page-docs.php` | 263 | Шаблон страницы Documentation | корень документации |
| `single.php` | 440 | — | запись блога; **светлый редизайн завершён 2026-10-13** (Р-133…Р-138) |
| `single-document.php` | 208 | — | CPT `document`; остаётся тёмным |
| `page-privacy.php` | 37 | Шаблон страницы PRIVACY POLICY | 3 юр. страницы; **светлый редизайн завершён 2026-10-12**, контент не менялся |
| `header.php` | 350 | — | **глобальная шапка (Р-141)**: одна светлая для всех шаблонов; логотип — только знак «N» на Mobile; меню Products / Industries / Resources / Docs / Pricing + язык + CTA; sticky; мобильное меню. Структура — `inc/header-menu.php`, иконки — `inc/header-icons.php` |
| `inc/header-menu.php` | ~200 | — | данные шапки: дерево меню, реальные и плановые URL (`exists`), языки, текущий пункт, последние записи блога |
| `inc/header-icons.php` | ~30 | — | `nv_header_icon()` — inline-SVG из Figma, заливка `currentColor` |
| `inc/block-helpers.php` | 49 | — | `nv_block_placeholder()` — заглушка пустого ACF-блока в редакторе |
| `js/admin-blocks.js` | 46 | — | шим ACF↔iframe-канва редактора; обязателен до обновления ACF Pro (BACKLOG B-27) |
| `css/editor-blocks.css` | 42 | — | оформление заглушки; подключается через `add_editor_style()` |
| `footer.php` | 752 | — | футер (ветвление по `nv_is_light_theme()`) + cookie + 5 модалок; `#callForm`, `#callForm2`, `#thanks`, `#error` переведены на светлый дизайн 2026-10-12, `#review` остался тёмным |

> Проверено сквозным аудитом 2026-10-07: на главной выводится один
> `<footer class="footer">` (светлый), на остальных страницах — прежний
> тёмный; двойного вывода нет, `wp_footer()` вызывается, cookie-баннер
> и обе модалки на месте, теги сбалансированы (534 `div`, 13 `section`,
> 3 `form`, по одному `header`/`footer`/`main`).
| `template-parts/footer-home.php` | 181 | — | светлый футер: все страницы, где `nv_is_light_theme()` → главная, `/solutions/`, 3 юр. страницы, `/pricing-matrix/` |
| `template-parts/contacts-form.php` | 228 | — | общая форма обратной связи: главная и `/solutions/` |
| `functions.php` | 2464 | — | вся логика темы |
| `404.php` | 32 | — | 404 |
| `inc/docs-menu.php` | 188 | — | меню документации + файловый кэш |
| `inc/calculator-fields.php` | 148 | — | ACF-поля цен калькулятора |
| `blocks/*/` | 19 блоков | — | ACF-блоки Gutenberg для статей |

### Заготовки блога (сейчас не видны)
`single.php` (436), `category.php` (181), `author.php` (308), `search.php` (194),
`blog-page.php` (125), `template-parts/article-card.php` (120), `template-parts/teaser.php` (28).

### Дубли и устаревшее — **трогать только по согласованию**
| Файл | Строк | Отличий от оригинала | Статус |
|---|---|---|---|
| `main-page-video-autoplay.php` | 2412 | **26 строк** от `main-page.php` | почти полный дубль главной |
| `index.php` | 2135 | 1238 строк от `main-page.php` | устаревшая копия, WP-фолбэк |
| `header_24.06.26.php` | 158 | 42 строки от `header.php` | бэкап по дате |
| `template-parts/teaser_10.04.26.php` | 20 | 6 строк от `teaser.php` | бэкап по дате |

Два шаблона носят **одинаковое** `Template Name: Шаблон страницы Блога` — `search.php` и `blog-page.php`.

С группы 7 на главной есть секция FAQ. Классы `.faq__*` общие с `/solutions/`,
поэтому правила главной ограничены `body.home`. Семи ответов из восьми нет
в макете — см. `BACKLOG.md`, R-18.
В админке они неразличимы.

---

## 4. Динамические данные

Ключевой факт: **вёрстка почти полностью статична.** Количество вызовов на файл:

| Файл | `get_field` | `have_rows` | `get_sub_field` | `WP_Query` | `esc_*` |
|---|---|---|---|---|---|
| `main-page.php` | 0 | 2 | 6 | 0 | 8 |
| `page-solutions.php` | **0** | **0** | **0** | 0 | **0** |
| `page-price-matrix.php` | 5 | 4 | 6 | 0 | 34 |
| `page-docs.php` | 0 | 0 | 0 | 0 | 16 |
| `footer.php` | 0 | 0 | 0 | 0 | 0 |
| `header.php` | 1 | 0 | 0 | 0 | 0 |
| `single-document.php` | 0 | 0 | 0 | 0 | 10 |
| `category.php` / `author.php` / `search.php` / `blog-page.php` | 0 | 0 | 0 | 1 | 7–14 |

### Единственные динамические острова, которые нельзя ломать
1. **`page-price-matrix.php`** — реально ACF-управляемая страница: тарифы, пакеты, цены
   (`tarif-group`, `service-*`, `doc_price`, `basic-price`, `international_price`, …).
   Плюс цены из `inc/calculator-fields.php` уходят в `data-`атрибуты `#kyc-calculator`.
2. **`header.php`** (тег `<body>`) — `get_field('use_captcha', 'options')` → `data-use-captcha` на `<body>`.
3. **`main-page.php:1077`** — репитер `reviews` (секция testimonials).
4. **`page-docs.php` / `single-document.php`** — дерево документации через `inc/docs-menu.php`.
5. **Циклы блога** в `category.php`, `author.php`, `search.php`, `blog-page.php`.
6. **`blocks/*/`** — 19 ACF-блоков, все на `get_field()`.

Остальные `<?php ?>` в `main-page.php` — это `get_template_directory_uri()` для путей к картинкам (≈40 вызовов).

### Меню
`register_nav_menus()` в теме **не вызывается**. Навигация шапки собирается из PHP-массива
`nv_header_menu()` (`inc/header-menu.php`), разметка — `header.php` (с 2026-10-14, Р-141; раньше был
жёстко прописанный `<ul>` с якорями). В БД лежат 6 неиспользуемых меню (`Основное меню RU`, `Main menu EN`,
`Меню Ссылки`, `Меню Наши решения`, `Menu Links EN`, `Menu Our solutions footer EN`),
а `theme_mods_nvglobal` ссылается на локацию `main_menu`, которой не существует.

### Мультиязычность
Плагина нет. В БД — остатки Polylang: таксономии `language` (Русский/English),
`term_language`, `post_translations`, `term_translations`. Тема **не использует** `pll_*` / `icl_*`.
Сайт фактически одноязычный, английский.

---

## 5. ACF

26 групп полей. 18 — для Gutenberg-блоков статей. Остальные:

| Группа | Привязка | Читается темой? |
|---|---|---|
| Тарифы, Пакеты услуг по тарифам, Данные для расчётов | `page-price-matrix.php` | **да** |
| Настройки сайта | options-страница `site-settings` | частично (`use_captcha`, SMTP/TG в `functions.php`) |
| Отзывы (`reviews`) | `main-page.php` | да, но секция выключена (см. ниже) |
| Мета поля для записей блога | записи | да (`single.php`) |
| **Главная страница** (#67) | `main-page.php` | **нет** |
| **Сферы применения** (#209) | `page-kyt-en.php`, `page-aml-en.php`, `page-liveness-en.php` | **нет — шаблонов не существует** |

> Группа «Главная страница» объявляет 14 полей (`h1_title`, `main_subtitle`, `main_description`,
> `industries`, `services`, `about_image/title/text/link`, `stats`). В админке они видны
> на странице «main», но `main-page.php` **ни одного из них не читает**. Заполнение ничего не изменит.
> В БД все эти поля пустые — последствий для текущего сайта нет, но ловушка для редактора реальна.

---

## 6. CSS

| Файл | Строк | Подключение |
|---|---|---|
| `css/styles.css` | **18 973** | глобально |
| `css/post.css` | 902 | глобально (нужен только статьям) |
| `css/blog.css` | 586 | глобально (нужен только блогу) |
| `css/document-toc.css` | 539 | условно: `is_singular('document')` или `page-docs.php` |
| `style.css` | 17 | заголовок темы; `Theme Name: NVGlobal` — **менять нельзя** |

### Архитектура — совпадает с регламентом NeuroVision
`styles.css` разбит маркерами `/* SECTION START */ … /* SECTION END */`, **43 секции**
(2026-10-09: внутри `SOLUTIONS-PAGE` добавлены подрегионы `SOLUTIONS THEME`,
`SOLUTIONS WHY` и `SOLUTIONS PRODUCTS`).
Внутри каждой секции — своя лесенка media-запросов по убыванию. В конец файла они **не вынесены**.
Это ровно то, чего требует исходный регламент, — переучивать ничего не нужно.

### Брейкпоинты — тоже совпадают
Используются все восемь из регламента:

| Брейкпоинт | Секций |
|---|---|
| 1599.98px | 24 |
| 1399.98px | 25 |
| 1199.98px | 31 |
| 991.98px | 30 |
| 767.98px | 34 |
| 575.98px | 34 |
| 478.98px | 29 |
| 419.98px | 26 |

Отклонения: три разовых `620px`, `460px`, `379.98px` и `min-width` в `<picture>`-источниках.
Новых брейкпоинтов редизайн не добавлял (проверено 2026-10-09).

### Соответствие правилам регламента
| Правило | Статус |
|---|---|
| `line-height` не в px | ✅ **0 вхождений в px** |
| Flexbox в приоритете | ⚠️ 489 `display:flex` против 20 `display:grid` |
| `min-height` у текстовых кнопок | ⚠️ 40 `min-height`, но `.btn-hero` имеет `height: 64px` |
| БЭМ | ✅ выдержан |

### Дефекты структуры (не исправлены)
- Строки 1–649 и 930–1501 не накрыты маркерами секций.
- ~~`MENU … START` закрывается `HEADER MENU … END` — имена не совпадают~~ — исправлено 2026-10-14: регион заменён парой `HEADER START` / `HEADER END` (секция шапки целиком).
- `HERO END` (1501) есть, `HERO START` — **нет**.
- После `CALC PAGE END` (13435) висит бесхозное правило для чат-виджета.

### Токены — главный риск файла
В `styles.css` **384 обращения `var(--…)`** к **11 именам**, из которых
**не объявлено ни одно**. Везде работает fallback-значение. Объявления `--*` есть только
в `css/document-toc.css` (5 локальных `--toc-depth-offset`).

У пяти токенов fallback’и **расходятся** — одно имя, разные цвета:

| Токен | Значения |
|---|---|
| `--text-white-70` | `rgba(251,251,251,0.7)`, `rgba(251,251,251,0.70)`, `rgba(255,255,255,0.70)` |
| `--stroke-white-15` | `0.1` и `0.15` |
| `--island-white-5` | `0.05` и `0.15` |
| `--island-white-10` | `0.10` и `0.30` |
| `--island-orange-20` | `0.2` и `0.20` |

> Пока `:root` пуст, сайт выглядит как задумано. Стоит кому-то объявить эти переменные —
> цвет разом изменится в сотне мест, причём там, где fallback’и расходились, изменение будет неверным.
> Подробности и порядок действий — `docs/THEME-TODO.md`.

---

## 7. JavaScript

| Файл | Всего строк | Комментариев | Кода |
|---|---|---|---|
| `js/main.js` | 4452 | **1302 (29 %)** | ~2224 |
| `js/form.js` | 1054 | 12 | ~831 |
| `js/calculate.js` | 677 | 14 | ~529 |

В `main.js` — **31 инициализатор** компонентов (`initHeaderMenu` — единый контроллер шапки, переписан 2026-10-14, `initProductsSlider`,
`initDocTabs`, `initFeaturesBlock`, `initUptimeGauge`, `initHeroCanvasAnimation` и др.).
Крупные закомментированные блоки экспериментов с ScrollTrigger — примерно строки 3007–3700.

### Библиотеки (все локальные, без CDN)
Swiper, MicroModal, GSAP + ScrollTrigger, Locomotive Scroll, Lottie, smoothscroll,
GLightbox, Siema (в `assets/`, **в enqueue не подключается**).

### Внешняя зависимость
`functions.php:23–30` — виджет NeVi с `https://nevi-gateway.erpprog.workers.dev/widget/…`,
CSS + JS, подключается с приоритетом 1 и инлайн-скриптом инициализации.

---

## 8. AJAX, формы, безопасность

Четыре эндпоинта, все с проверкой nonce и санитизацией:

| Действие | Функция | Защита |
|---|---|---|
| `send_contacts_form` | `handle_contacts_form_submission` | `check_ajax_referer` |
| `nv_update_likes` | `nv_update_likes` | `wp_verify_nonce` + `sanitize_text_field` |
| `nv_blog_search` | `nv_blog_search` | `wp_verify_nonce` + `sanitize_text_field` |
| `nv_load_more_posts` | `nv_load_more_posts` | `wp_verify_nonce` |

Форма уходит по SMTP (`phpmailer_init`), в Telegram и в HubSpot — управляется ACF-опциями
`send_mail` / `send_tg` / `send_hubspot`. Капча hCaptcha — по флагу `use_captcha`.

SEO и Schema — целиком на Yoast. В теме только `nv_setup_404_seo` и фильтр
`wpseo_enhanced_slack_data`.

---

## 9. Ассеты

| Каталог | Объём |
|---|---|
| `img/` | **62 MB** |
| `video/` | 54 MB |
| `animation/` | 7 MB (Lottie JSON) |
| `fonts/` | 3.2 MB (Satoshi: eot/woff/woff2/ttf/otf) |

`img/` — **плоский**, подпапки только `industries/` и `favicon/`.
Состав: 65 PNG, 53 WebP, 29 SVG, 17 JPG, 7 JSON.

Схема `x1 + @2x` из регламента **не применяется**: файл `@2x` ровно один,
`srcset` встречается в 3 шаблонах.

### ⚠️ `*.png.webp` — это НЕ мусор, а WebP-двойники Seraphinite

В `img/` лежит 31 файл вида `name.png.webp` и `name.jpg.webp`. Ни один из них
не упоминается в `*.php`, `*.css`, `*.js` — и первичный аудит ошибочно записал их
в неиспользуемые.

**Проверка 2026-10-05 показала обратное.** В корне сайта есть
`seraph-accel-img-compr-redir.conf` с заголовком:

```
# seraphinite-accelerator - Automatic redirection to Avif and WebP versions if they exist
```

В `wp-content/plugins/` лежит `seraphinite-accelerator-ext`. Схема `file.png.webp`
рядом с `file.png` — это ровно то, что создаёт Seraphinite Accelerator и подменяет
на лету через rewrite, не меняя ссылок в коде.

Сверка подтвердила соответствие один к одному: **для каждого из 31 артефакта
исходный `.png` / `.jpg` используется в коде темы**. То есть это живые ассеты.

| Локально | На проде |
|---|---|
| плагина нет в `active_plugins`, конфиг `# Empty` → двойники инертны | по признакам критического CSS Seraphinite **активен** → двойники обслуживают реальный трафик |

**Удаление этих файлов ничего не сломает визуально и не даст ошибок в тестах —
но молча вернёт прод к выдаче тяжёлых PNG.** Не трогать.

### Действительно неиспользуемые файлы

Проверка ссылок проведена полностью: код темы + `wp_posts.post_content` +
`wp_postmeta` + `wp_options` + `uploads/` + плагины.
Вне кода темы ссылок на `themes/nvglobal/img/` **нет нигде** (0 попаданий во всех трёх таблицах).

Крупнейшие файлы без единой ссылки:

| Файл | Размер | Примечание |
|---|---|---|
| `img/main-solutions-bg.png` | **28 MB** | в CSS используется только `main-solutions-bg3.webp` (140 KB) |
| `img/main-solutions-bg.svg` | 10 MB | |
| `img/features__tab--maskot.png` | 3.4 MB | |
| `img/cases__item-image.png` | 1.5 MB | |
| `img/case_image_sound.svg` | 1.4 MB | |
| `img/doc__bottom-image_orig.png` | 660 KB | суффикс `_orig` |

Суммарно ~50 MB. **Чистка отложена до конца редизайна** (`docs/DECISIONS.md`, Р-1):
редизайн может заменить фоны целиком, и чистить логичнее после него.

> Ложные срабатывания при проверке: поиск по *имени файла* в БД даёт попадания
> на одноимённые вложения медиабиблиотеки в `uploads/` (например `flow_step1.png`
> существует и в `img/`, и в `uploads/2026/04/`). Сверять нужно по пути
> `themes/nvglobal/img/`, а не по basename.

### Удалено 2026-10-05
`img/flow_step1 (1).png` — 45 KB, побайтовая копия `flow_step1.png`
(одинаковый md5), ноль ссылок где-либо, имя — артефакт повторной загрузки.
Единственный файл, прошедший критерий «доказанный дубликат».

---

## 10. Активные плагины

ACF Pro, ai-content-processor, **blog-json-io** (Blog JSON Export/Import 1.4.0),
company-clients (CPT `cc_client`, 9 записей), cyr2lat,
docs-manager (CPT `document`, 71 запись), duplicate-page, duplicator, safe-svg,
simple-user-avatar, Yoast SEO.

> `blog-json-io` — импорт записей блога из JSON. Формат файла описан
> в `docs/BLOG-IMPORT-GUIDE.md`; внешняя копия для заказчика —
> `/Users/dmitriy/ZAKAZI/nv.global/BLOG/` (раздел 15).

В каталоге `wp-content/plugins/` дополнительно лежит **`seraphinite-accelerator-ext`** —
локально не активирован, но на проде по признакам работает (инлайнит критический CSS).
Именно он обслуживает WebP-двойники `*.png.webp` (см. раздел 9).

Замечания:
- В `active_plugins` **`duplicator/duplicator.php` записан дважды** (индексы 6 и 12), индексы 8, 10 пропущены.
- CPT `popup` (1) и `popup_theme` (8) в БД есть, а плагина, который их создаёт, в активных нет — осиротевшие записи.
- Плагина массовой замены (Better Search Replace и т. п.) нет.

> По CPT `document`: у каждого документа есть мета `_source_markdown`. Импорт MD **полностью
> перезаписывает** контент, правка в редакторе `_source_markdown` не трогает.
> Согласованный порядок — экспорт MD → правка → импорт MD.

---

## 11. Чего проверить не удалось

- Figma — ссылок нет, MCP не вызывался.
- Прод-сайт в этом запуске не опрашивался.
- Отправка форм и AJAX вживую не выполнялась (чтобы не слать письма и заявки).
- Поведение Seraphinite Accelerator на проде (локально плагин неактивен) — вывод
  об активности сделан по косвенным признакам, прямой проверки прода не было.

---

## 12. Статус Git и незакоммиченные изменения

Сверено **2026-10-14**.

| Параметр | Значение |
|---|---|
| Ветка | `dev` |
| Последний коммит | `1b6162e` «Solutions: финальный визуальный аудит, доступность форм и тексты FAQ» (2026-10-12 11:59 +0700) |
| Remote | `git@github.com:matveevds/nvglobal.git` |
| **`origin/dev` не существует** | ветка `dev` **ни разу не пушилась**. На remote только `origin/main` |
| Незакоммичено | код — ничего (разобрано 2026-10-14 в коммиты `f378cb5`, `97af0d0`, `c9458d1`, `15472fc`) |

### Что было незакоммичено — четыре задачи (разложено по коммитам 2026-10-14)

Список ниже — историческая раскладка. Фактически вышло пять коммитов: задачи 1, 2, 3 и отдельный коммит «формы, модалки, футер, светлая тема» (`js/form.js`, `footer.php`, `header.php`, `page-privacy.php`, остаток `styles.css` и `functions.php`), затем документация.

**1. Pricing Matrix, светлый редизайн** (Р-127…Р-132)
`page-price-matrix.php`, `js/calculate.js`, секция `CALC PAGE` в `css/styles.css`,
8 новых файлов `img/pricing-hero-*.webp`.
Логика калькулятора не менялась, регресс 18 сценариев 1:1.

**2. Починка Gutenberg-блоков в редакторе** (B-27)
`functions.php`, новые `js/admin-blocks.js`, `inc/block-helpers.php`, `css/editor-blocks.css`,
`block.json` у 8 блоков (режим `preview`).
Причина — несовместимость WP 7.1.3 и ACF Pro 6.3.11 на канве-iframe редактора.

**3. Редизайн 19 блоков + светлая страница записи** (Р-133…Р-140, B-28, B-30)
`blocks/*/` (19 блоков: `*.php`, `*.css`, `*.editor.css`, часть `block.json`),
`single.php`, светлая секция в конце `css/post.css`, светлые селекторы в `css/styles.css`.

**4. Документация**
`CLAUDE.md`, `docs/PROJECT_STATE.md`, `docs/CHANGELOG.md`, `docs/DECISIONS.md`,
`docs/BACKLOG.md`, `docs/COMPONENTS.md`, `docs/QA.md`, новый `docs/BLOG-IMPORT-GUIDE.md`.

### ⚠️ Требует приёмки до коммита

- **`header.php` и `footer.php` изменены.** `CLAUDE.md` запрещает их трогать без
  явного указания. Фактические правки: в `header.php` выбор логотипа переведён
  с `is_page_template('page-solutions.php')` на общее `nv_is_light_theme()` (Р-126);
  в `footer.php` модалке `#callForm` добавлены заголовок и кнопка закрытия,
  часть `fill` в SVG заменена на `currentColor`. Обе правки осмысленные,
  но формально вне разрешённого — подтвердить или откатить.
- **Мусорный каталог `</`** в корне темы: пустое дерево
  `</Users/dmitriy/ZAKAZI/neuro-vision.ru/SEO/…`, артефакт сорвавшегося редиректа
  в консоли (создан 2026-10-14 00:00). Содержимого не несёт.
  Не удалён, потому что удаление файлов запрещено без указания. Удалить вручную:
  `rm -rf '</'` из корня темы.

---

## 13. Карта Figma-макетов по страницам

Полный регламент работы с макетами и карта секций главной — `docs/FIGMA.md`.
Здесь — сводка по страницам, чтобы не искать по журналу.

| Страница | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile |
|---|---|---|---|---|
| Главная | `2380:22854` | `291:5735` | `2376:16686` | ❌ нет |
| Solutions | `2456:16495` | `499:6129` | `2457:17206` | `2467:17893` |
| Pricing Matrix | — | `1680:26979` | `1687:15573` | `1687:24170` |
| **Запись блога** | `2570:37654` | `198:2964` | `236:5552` | `236:6388` |

**Header (глобальная шапка, Р-141):**

| Состояние | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile 392 |
|---|---|---|---|---|
| Закрытая | `2580:50483` | `2580:45386` | `2580:48317` | `2580:49995` |
| Products | `2580:50536` | `2580:47102` | `2580:48368` | `2577:43141` / `2580:43334` |
| Подраздел Products | — | в `2580:47102` | — | `2580:43430` |
| Industries | `2580:52503` | **нет** (по Full HD) | `2580:48912` | `2580:43708` |
| Resources | `2580:53083` | **нет** (по Full HD) | `2580:49112` | `2580:43893` |
| Язык | — | `2386:28441` | `2580:50326` | `2580:50198` |
| Sticky | — | `2580:48215` | — | — |

Вспомогательные узлы:

| Что | node-id |
|---|---|
| Футер — состояния | `2386:37529` |
| Подвал на Solutions | `2456:16730` |
| FAQ на Solutions | `2467:18067` |
| Иллюстрация Pricing Hero | `2547:23070` / `2547:23264` |
| Форма комментариев под статьёй | `2570:39540` — **не реализована** |
| Врезка `about` с логотипом | `2570:39198` |

Макет записи блога (`2570:37654` и остальные три) **светлый** — именно он задал
светлый редизайн `single.php` и всех 19 блоков.

---

## 14. Открытые вопросы — ждут решения пользователя

Задачник целиком — `docs/BACKLOG.md` (109 открытых пунктов, 6 закрытых).
Здесь только то, что блокирует продолжение.

| # | Вопрос | Где |
|---|---|---|
| 1 | Приёмка Pricing: убрана кнопка «View Rates», на мобильной свой набор кнопок в hero, в Overview убран маскот | `CHANGELOG.md` 2026-10-13 |
| 2 | Приёмка страницы записи: форма комментариев из `2570:39540` **не сделана**, хлебные крошки оставлены | `BACKLOG.md` B-28 |
| 3 | Переводить ли 4 WYSIWYG-подполя повторителей (`steps_text`, `tab_text`, `slider_title`, `gallery_image_caption`) в режим «только текст» | `BACKLOG.md` B-30 |
| 4 | `header.php` / `footer.php` изменены без явного разрешения — подтвердить (`header.php` дальше переписан по явному заданию, Р-141) | раздел 12 |
| 7 | Приёмка новой шапки: Lorem Ipsum из Figma заменён реальными пунктами, «Company» вместо «Docs» не реализован, плановые URL | `DECISIONS.md` Р-141, `BACKLOG.md` H-01…H-13 |
| 5 | A-47 (P1): «200 countries» в FAQ против «195+» в остальных текстах | `BACKLOG.md` A-47 |
| 6 | A-49 (P1): списки стран и услуг в Contacts остались тёмными | `BACKLOG.md` A-49 |

### Технический долг, заведённый этой сессией

- **B-27 — шим ACF↔iframe.** `js/admin-blocks.js` + принудительная подстановка
  `editor_style_handles` в `functions.php` держатся на несовместимости
  WP 7.1.3 с ACF Pro 6.3.11. **Снять после обновления ACF Pro**, не раньше:
  без шима редактор падает с `TypeError … buildQuicktags`.
- **B-29** — вкладка пакета переносится в две строки ниже 1600 на Pricing.
- **B-30** — блоки записи рассчитаны на светлую страницу; на тёмных шаблонах
  (`page-docs.php`, `single-document.php`) их не выводить.
- **A-53…A-56** — контраст `--nv-primary` 2.72:1, обрезка навигации на 992–1024,
  порядок логотипа и бургера на мобильной, `min-width: 700px` у таблиц в `post.css`.

---

## 15. Внешние файлы проекта (вне репозитория)

| Путь | Что |
|---|---|
| `/Users/dmitriy/ZAKAZI/nv.global/BLOG/GUTENBERG_BLOCKS_CATALOG.md` | каталог 19 ACF-блоков и 6 core-блоков: назначение, поля, ACF-ключи, режимы |
| `/Users/dmitriy/ZAKAZI/nv.global/BLOG/BLOG_IMPORT_JSON_SPEC.md` | формат JSON для `blog-json-io`; все примеры проверены рендером и живым импортом |
| `/Users/dmitriy/ZAKAZI/nv.global/BLOG/rules/WORDPRESS_BLOCKS_REFERENCE.md` | статус снят 2026-10-14: `SCHEMA VERIFIED … JSON BUILD ALLOWED`; прод не подтверждён — импортировать черновиком |
| «ТЗ на новые страницы» | ТЗ страниц nv.global, `.md` + `.docx` |

Внутритемная копия справки по импорту — `docs/BLOG-IMPORT-GUIDE.md`.
Колонка `mode` синхронизирована с `block.json` 2026-10-14 (8 блоков в `preview`).

---

## 16. Что делать следующим шагом

1. ~~Разобрать незакоммиченное~~ — сделано 2026-10-14. Остаётся принять или откатить
   правки `header.php` / `footer.php` (коммит `15472fc`).
2. ~~Удалить мусорный каталог `</`~~ — удалён 2026-10-14.
3. ~~Снять статус `JSON BUILD BLOCKED`, синхронизировать `mode`~~ — сделано 2026-10-14.
4. Принять новую шапку (раздел 14, п. 7), затем закоммитить её отдельно от всего остального.
5. Закрыть приёмку по пунктам 1–4 раздела 14.
6. `git push` ветки `dev` — её на remote нет. **Только по прямому указанию.**
