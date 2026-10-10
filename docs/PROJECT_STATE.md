# PROJECT_STATE — проверенные факты

Аудит: **2026-10-05**. Baseline-коммит: `bbfad4c` «Убран номер телефона со всех страниц» (2026-10-02).
Ветка `main`, рабочее дерево чистое (не считая `AGENT_SETUP_TASK.md` и `reference/`).

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
| PHP (CLI для скриптов) | `/Applications/MAMP/bin/php/php8.3.30/bin/php` |
| WP-CLI | **отсутствует** |
| Playwright | доступен: в кэше npx (`find ~/.npm/_npx -maxdepth 4 -name playwright -type d`), Chromium установлен |
| MCP Figma | инструменты объявлены, **ссылки не предоставлены** |
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
- Записей `post`: **0 опубликованных** (одна `auto-draft`). Блог не наполнен.
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
| `page-solutions.php` | 1134 | Шаблон страницы Solutions | `/solutions/`; редизайн по группам, выполнены 1 (шапка и первый экран), 2 (Why), 3 (Industries), 4 (Products), 5 (Integration), 6 (Security; секция отзывов скрыта), 7 (FAQ), 8 (Contacts), 9 (светлые тизер и подвал) |
| `page-price-matrix.php` | 715 | KYC/AML Pricing Matrix | `/pricing-matrix/` + калькулятор |
| `page-docs.php` | 263 | Шаблон страницы Documentation | корень документации |
| `single-document.php` | 208 | — | CPT `document` |
| `page-privacy.php` | 37 | Шаблон страницы PRIVACY POLICY | 3 юр. страницы |
| `header.php` | 131 | — | шапка; пункт «Cases» выводится только вне главной (BACKLOG A-01) |
| `footer.php` | 726 | — | футер (ветвление по `nv_is_light_theme()`) + cookie + 4 модалки |

> Проверено сквозным аудитом 2026-10-07: на главной выводится один
> `<footer class="footer">` (светлый), на остальных страницах — прежний
> тёмный; двойного вывода нет, `wp_footer()` вызывается, cookie-баннер
> и обе модалки на месте, теги сбалансированы (534 `div`, 13 `section`,
> 3 `form`, по одному `header`/`footer`/`main`).
| `template-parts/footer-home.php` | 181 | — | светлый футер: главная и `/solutions/` |
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
| `page-price-matrix.php` | 5 | 4 | 6 | 0 | 23 |
| `page-docs.php` | 0 | 0 | 0 | 0 | 16 |
| `footer.php` | 0 | 0 | 0 | 0 | 0 |
| `header.php` | 1 | 0 | 0 | 0 | 0 |
| `single-document.php` | 0 | 0 | 0 | 0 | 10 |
| `category.php` / `author.php` / `search.php` / `blog-page.php` | 0 | 0 | 0 | 1 | 7–14 |

### Единственные динамические острова, которые нельзя ломать
1. **`page-price-matrix.php`** — реально ACF-управляемая страница: тарифы, пакеты, цены
   (`tarif-group`, `service-*`, `doc_price`, `basic-price`, `international_price`, …).
   Плюс цены из `inc/calculator-fields.php` уходят в `data-`атрибуты `#kyc-calculator`.
2. **`header.php:71`** — `get_field('use_captcha', 'options')` → `data-use-captcha` на `<body>`.
3. **`main-page.php:1077`** — репитер `reviews` (секция testimonials).
4. **`page-docs.php` / `single-document.php`** — дерево документации через `inc/docs-menu.php`.
5. **Циклы блога** в `category.php`, `author.php`, `search.php`, `blog-page.php`.
6. **`blocks/*/`** — 19 ACF-блоков, все на `get_field()`.

Остальные `<?php ?>` в `main-page.php` — это `get_template_directory_uri()` для путей к картинкам (≈40 вызовов).

### Меню
`register_nav_menus()` в теме **не вызывается**. Навигация в `header.php` — **жёстко прописанный `<ul>`**
с `home_url()` и якорями. В БД лежат 6 неиспользуемых меню (`Основное меню RU`, `Main menu EN`,
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
- `MENU … START` (650) закрывается `HEADER MENU … END` (930) — имена не совпадают.
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

В `main.js` — **31 инициализатор** компонентов (`initHeaderMenu`, `initProductsSlider`,
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

ACF Pro, ai-content-processor, company-clients (CPT `cc_client`, 9 записей), cyr2lat,
docs-manager (CPT `document`, 71 запись), duplicate-page, duplicator, safe-svg,
simple-user-avatar, Yoast SEO.

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
