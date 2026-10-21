# CHANGELOG

Журнал изменений темы. Новые записи — сверху.
Формат: дата, что сделано, какие файлы затронуты, чем проверено.

## 2026-10-21 — /kyb/: свои картинки вместо Identity/KYC

Не закоммичено. `page-kyb.php` (hero `media`: kyb-hero / kyb-hero-laptop / kyb-hero-tablet / kyb-hero-mobile; шаги 1–4 → kyb-step-1…4; экран Platform → kyb-ubo-screen); новые `img/kyb-hero`, `kyb-hero-laptop`, `kyb-hero-tablet`, `kyb-hero-mobile`, `kyb-step-1…4`, `kyb-ubo-screen` (1x и `@2x`). Hero и иконки — Magnific 4k (проверены кропы рук и лица), карточка hero и экран UBO — HTML-макеты Satoshi. Список `<img>` /kyb/ сравнен с /identity-verification/, /kyc/, /aml/, /document-verification/, /face-verification/, /liveness/: совпадений нет, кроме общих элементов (шапка, подвал, флаги, сертификаты, рамка ноутбука), карт региона и `sol-int-folders`. Playwright на 14 ширинах: горизонтального скролла нет, ошибок консоли и 404 нет, дублей id нет, один H1. Карта `docs/pages/kyb.md`.

## 2026-10-21 — Главная: первый экран `.hero` на Tablet и Mobile по макету

Не закоммичено. Сверка с кадрами Figma: Full HD `2380:22854` и Desktop `291:5735` совпадают с текущей вёрсткой (не менялись); переделаны **Tablet** `2376:16686` и **Mobile** `2377:20847` (макеты — картинки от владельца, Figma MCP в сессии недоступен). Только `.hero` главной: `css/blocks/hero.css` (новые блоки в конце файла), `main-page.php` (один `<source>` для Tablet в `<picture>`), `img/hero-bg-tablet.webp` + `@2x` (776×872 / 1552×1744), картотека (`Home Hero`).
- **Tablet 768–991:** свой кадр — телефон 290×610 справа (в макете он меньше, чем в общей картинке; кадр собран из `hero-bg@2x` с продлением верха/низа и диагональным затемнением), `object-position: right center`; H1 44/56 (на 768–829 — 40/51, чтобы не заходить на телефон), колонка текста 384, подзаголовок 18/24; кнопки внизу справа без изменений; легаси-градиент `.hero::after` под секцией на ≤991 убран.
- **Mobile ≤767:** раскладка как у `main--hero` без фактов — H1 40/48 тёмный над карточкой (тире тёмное), фотокарточка 360×264 радиус 16 (высота `clamp(264px, 67vw, 480px)`, `hero-bg.webp`, `object-position: 14% 50%`), кнопки 36 высотой в левом нижнем углу фото в столбик (поле 16, зазор 12), подзаголовок 14/20 под фото (поле 8), логотип в карточке скрыт, `.hero::after` убран.
- Проверено: 320/392/576/767/768/840/991 и Desktop 992/1100/1440/1920 — горизонтального скролла нет, JS-ошибок нет, Desktop/Full HD не менялись (правила только в media ≤991); Tablet и Mobile сверены с макетом наложением (расхождения: на Mobile телефон на фото на 8px выше, чем в макете, — фото одно общее с Desktop).
- Для прода: `css/blocks/hero.css`, `main-page.php`, `img/hero-bg-tablet.webp`, `img/hero-bg-tablet@2x.webp`.

## 2026-10-21 — Главная, #products: стрелки слайдера не работали на <768

Не закоммичено. `js/main.js`, `initProductsSlider()`: обработчики `.products__slider-arrow--prev/--next` на мобильной ширине (≤767.98) делали `return`, а на мобильной раскладке слайдами управляет Swiper (`mobileContentSwiper`, картинка идёт следом через controller) — стрелки были «мёртвыми». Теперь на мобильной ширине стрелки вызывают `slidePrev()` / `slideNext()`, а состояние `disabled` стрелок обновляется в `init` и `slideChange` Swiper (синхронно со свайпом и вкладками); десктопная логика не менялась. Проверено на 320/392/767/768/1440: стрелка «вперёд» проходит все 6 вкладок 0→5 и блокируется на последней, «назад» возвращает на предыдущую; JS-ошибок нет.

## 2026-10-21 — Шапка: пункт Solutions после Products

Не закоммичено. Верхнее меню: простая ссылка **Solutions** → `/solutions/` сразу после Products (запрос владельца; правка `header.php` разрешена явно). `inc/header-menu.php` — данные `$nv_menu['solutions']` (`nv_header_link('Solutions', '/solutions/', true)`) и ключ текущей страницы `solutions` для шаблона `page-solutions.php` (пункт подсвечивается на /solutions/); `header.php` — `<li class="header__item">` с `header__link` между Products и скрытым Industries. Порядок: Products, Solutions, Docs, Pricing. Проверено на 1920/1440/1100/840/392: пункт виден, ссылка верная, подсветка на /solutions/ работает, в мобильном меню (бургер) он идёт вторым, горизонтального скролла и JS-ошибок нет. Это же пункт «Discover our solution → /solutions/» в панели Products — без изменений.

## 2026-10-21 — Чат-виджет NeVi временно отключён

Не закоммичено. `functions.php`: подключение виджета (`web-chat-widget.css` / `web-chat-widget.standalone.js` с `nevi-gateway.erpprog.workers.dev`, инициализация `WebChatWidget`) и контейнер `<div id="web-chat-widget-root">` (хуки `wp_enqueue_scripts`, `wp_body_open`, `wp_footer`) больше не регистрируются — стоит константа `NVGLOBAL_NEVI_WIDGET_ENABLED = false` у функции `nvglobal_enqueue_nevi_widget()`. Код виджета не удалён: включить обратно — поставить `true`. `css/layout/chat-widget.css` оставлен (стили без виджета ничего не делают). Проверено: на /, /aml/, /blog/ нет `#web-chat-widget-root` и `.web-chat-widget`, нет запросов к nevi-gateway, JS-ошибок нет.

## 2026-10-21 — Всплывающие окна: кнопка-крестик `.modal__close` убрана

Не закоммичено. По указанию владельца из `footer.php` удалены все 5 кнопок `.modal__close`: формы `#callForm` и `#callForm2`, отзыв-видео (`.review`), результаты `#thanks` и `#error` (правка `footer.php` разрешена явно). Окна по-прежнему закрываются кликом по подложке (`data-micromodal-close` на `.modal__overlay`) и клавишей Esc. CSS `.modal__close` в `css/layout/modals.css` и `querySelector('.modal__close')?.focus()` в `js/form.js` оставлены (мёртвое правило, `?.` безопасен; фокус при открытии берёт MicroModal). Картотека: описания Contact Modal Large/Compact и Result Modals обновлены. Проверено на /kyc/ 1440/392: `.modal__close` в DOM нет; все 5 окон открываются и закрываются подложкой, формы — ещё и Esc; JS-ошибок нет.

## 2026-10-21 — Главная: блок записей блога убран

Не закоммичено. По решению владельца с главной убран блок «Insights & Resources» (слайдер последних записей): `main-page.php` больше не вызывает `template-parts/news-section.php` (стоит комментарий вместо вызова). Partial `news-section.php`, `news-card.php`, `css/blocks/news.css` и `initNewsSlider()` остались — ни одна страница сейчас блок не выводит (на /identity-verification/ он уже не вызывался). Картотека: записи «Blog Slider» и «News Card» переведены на стресс-кадр `news-slider` (`inc/bloki-stress/news.php`; добавляет body-класс Identity, на которой держится вид блока), usage/source обновлены. Мега-меню Resources и ссылка Blog в шапке/подвале не затронуты. Проверено: `/` на 1440/392 — `section.news` нет, горизонтального скролла и JS-ошибок нет; все 73 frame картотеки находят элементы.

## 2026-10-21 — Hero: лента фактов на <768 уходит за край экрана, а не контейнера

Не закоммичено. `css/blocks/main-hero.css`, блок `max-width: 767.98px`: у `.main--hero .main__facts` добавлено `width: calc(100% + 32px)` — базовое `width: 100%` блока перебивало мобильное `calc(100% + 32px)` из секции MAIN, и лента (поле −16 слева) обрезалась в 360 при вьюпорте 392, не доходя 32px до правого края. Теперь лента занимает всю ширину экрана (0…вьюпорт), начинается по сетке (поле 16), при прокрутке карточки скрываются за правый/левый край страницы, в конце — поле 16. Проверено: 8 страниц (kyc, identity, solutions, aml, kyb, document, face, liveness) и кадры hero-min/norm/max на 320/392/576/700/767 — 55 замеров, расхождений 0, горизонтального скролла страницы нет; /solutions/ (`.main__facts` без `main--hero`) уже вёл себя так.

## 2026-10-21 — Сводка интегратора: правки после партии блоков (меню, подвал, страницы, картинки)

Не закоммичено. Вносит принятые правки верстальщиков 21.10, не попавшие в сводную запись партии.
- **Onboarding /kyc/ (О-17):** обрезанный `kyc-onboard-laptop` заменён полным `kyc-onboard-laptop-full` (440×394, +@2x, Magnific); ноутбук стоит на нижней грани карточки, срезов нет на 15 ширинах; подправлены ширины и поля `.kyc-onboarding__laptop` / `__auto` (`css/blocks/kyc-onboarding.css`). Старые `kyc-onboard-laptop*` не используются (Р-1).
- **Шапка (Р-141):** ссылки продуктов в мега-меню Products переведены с плановых `/products/...` (`exists=false`) на реальные `/kyc/`, `/identity-verification/`, `/document-verification/`, `/face-verification/`, `/liveness/`, `/aml/`, `/kyb/` (`exists=true`); чипы Industries обновились сами; KYT — плановый `/products/kyt/`. Выпадающий Resources заменён простой ссылкой Blog (страница со slug `blog`, иначе `/blog/`; решение владельца 2026-10-21). Файл `inc/header-menu.php`; `header.php` поле `exists` не читает.
- **Подвал (светлый, `template-parts/footer-home.php`):** в соцсети добавлен YouTube `https://www.youtube.com/@NeuroVisionGlobal` (inline SVG `currentColor`, `.footer__social-item`, `target=_blank rel=noopener`, aria-label «NeuroVision on YouTube»; F-01 закрыт для светлого подвала, тёмный `footer.php` — только LinkedIn); в Resources добавлен пункт Blog; слоган на планшете 768–991 переносится в две строки по макету Figma `2376:17671` (`css/layout/footer.css`). Тексты подвала (почта, соцсети, юрлицо, юр. ссылки, ©) реальные, отличаются от заглушек макета — ждут решения владельца.
- **Teaser:** фон светлого тизера на `/pricing-matrix/` и в записях блога — surface-2 (#F2F2F2) по Figma `2380:23846`, `655:11651`, `2376:17671` (раньше `light-content.css` перекрашивал в surface-1). **Pricing** (`css/blocks/kyc-pricing.css`), 992–1199: колонки плана поровну, текст над кнопкой (новый media 992–1199.98); 7 страниц × 16 ширин.
- **Benefits, маскот promo:** `identity-benefits-fraud.webp` (+@2x) пересобрана в квадрат 180×180 / 360×360 (исходник был сжат по вертикали ≈0,84, маскот выглядел сплюснутым); высота по умолчанию в `idv-benefits-section.php` 151→180; затрагивает /aml/, /face-verification/, /identity-verification/.
- **/document-verification/, hero:** фото перегенерировано (Magnific 4k) — у прежнего были искажены пальцы и мягкая картинка (О-18); файлы `docv-hero*` (1856×1225 +@2x; на ≥992 фото + HTML-карточка с текстами ТЗ; `laptop`/`tablet` = `docv-hero-tablet`, `mobile` = `docv-hero-mobile` 720×536 — фото без карточки), `focus` `'100% 25%'`, `focus_mobile` `'50% 24%'`.
- **/document-verification/, Documents We Verify:** фото `docv-process` (стол с пустыми книгами, видна только середина) заменено шестью кадрами `docv-process-v2*` под реальные пропорции показа (≥1700, 1480–1699, 1120–1479, 992–1119, 560–991, <560) через `<picture>`: xl 1050×500, основная 1000×625, mid 600×600, narrow 372×600, m 960×505, s 560×431, +@2x; на фоне Magnific 4k — HTML-макеты паспорта, ID, прав, ВНЖ и счёта с SPECIMEN (О-19); старый файл оставлен.
- **/document-verification/, блок 9:** `docv-face-audit` перегенерирована (Magnific 4k, remove-bg: смартфон с селфи-силуэтом в овале, ID-карта с силуэтом и значок совпадения с галкой), размер 255×286 / 510×571 (раньше 255×255), в вызове partial `'h' => 286`.
- **/face-verification/, hero:** карточка «Face match» заменена карточкой «селфи ↔ фото на ID (Match) + поиск дубликатов»; кадры `fv-hero-fhd-v2` / `fv-hero-desktop-v2` / `fv-hero-laptop-v2` (+@2x), ключ `laptop` в `media`; старые кадры оставлены (Р-1).
- **/liveness/, шаг 2:** иконка `lv-step-2` заменена (Magnific 4k, `--remove-bg`, попытка 3 из 3): 3D-смартфон, на экране силуэт в овале со стрелками к центру — вместо непонятной маски (О-12); 200×200 + @2x 400×400.
- **/kyb/:** все картинки, совпадавшие с Identity/KYC, заменены на свои `kyb-*`: hero `kyb-hero` (1600×1056, Magnific 4k + HTML-карточка «Sample Trading Pte. Ltd.»), кадры `kyb-hero-laptop` (992–1199) / `-tablet` / `-mobile` (720×536), иконки шагов `kyb-step-1…4` (Magnific 4k, remove-bg, 200×200 / 400×400), `kyb-ubo-audit` (255×255) и экран Platform `kyb-ubo-screen` (644×452, схема Ownership structure); общими остались только карты SEA/Security и `sol-int-folders`.
- **Demo:** новый шаблон `page-demo.php` (Template Name: Demo, семейство kyc): демо KYC встроено скриптом `https://demo.nv.global/embed/kyc-demo.js` (classic `<script src defer onload>`, без iframe), `css/pages/demo.css`, запись `pages/demo` в `inc/css-registry.php`; локально опубликована `/demo/` (ID 1226). Правило: на странице ровно один `#kyc-demo`; у предков контейнера нет transform/filter/perspective/backdrop-filter/contain/will-change, overflow:hidden с фиксированной высотой и z-index; обёртка — не `.section`; язык — из `<html lang>`. Открыто: `nvglobal.local` и `nv.global` не в разрешённых доменах демо (403 captcha / «Verification is not available on this domain»), после добавления перепроверить фото и «Delete session?».
- **Картотека:** `page-bloki.php` — ширины кадров 1920 / 1600 / 1440 / 1200 / 1100 / 992 / 840 / 740 / 392 (раньше 6; по умолчанию 1440), `js/bloki.js` — комментарий; обновлены записи Footer Light, Site Header + Mega Menu, Onboarding Bento, Benefits + Promo, Teaser, Pricing Panel.
- **Для прода:** к пакету партии добавить `inc/header-menu.php`, `template-parts/footer-home.php`, `css/layout/footer.css`, `css/layout/light-content.css`, `css/pages/demo.css`, `page-demo.php`, `page-bloki.php`, `js/bloki.js` и новые `img/` (kyc-onboard-laptop-full*, docv-*, fv-hero-*-v2*, kyb-*, lv-step-2*, identity-benefits-fraud*, header-logo-mark и др. — по `git status`).

## 2026-10-21 — CSS-файлы: имена без «teaser/promo» (блокировщики рекламы) и версия по времени файла

Не закоммичено. У владельца `css/layout/teaser.css` отдавал `ERR_BLOCKED_BY_CLIENT` (расширение-блокировщик режет URL с рекламными словами) — тизер на /aml/ оставался без стилей; у посетителей с AdBlock было бы то же. Переименованы (содержимое не менялось, порядок в реестре тот же): `css/layout/teaser.css` → `css/layout/cta-band.css`, `css/blocks/promo.css` → `css/blocks/offer-card.css`; обновлены `inc/css-registry.php`, `docs/COMPONENTS.md`, `docs/FRONTEND.md`, скрипты `tools/css-qa/split_css.py`. Правило для новых файлов — `docs/FRONTEND.md` §2: в именах css/js/img нет слов teaser, promo, banner, ad(s), sponsor, popup. Картинки с такими именами (`img/teaser_*`, `img/promo_image.png`, `img/header-promo-video.webp`) загружаются в разметке — не переименованы (Р-1), список передан координатору.
Кэш: `functions.php` — функция `nv_asset_ver()`; `?ver=` каждого файла темы (css по реестру, `style.css`, `post/blog/document-toc.css`, `js/main.js`, `form.js`, `calculate.js`, `admin-blocks.js`) = `THEME_ASSETS_VER.<filemtime>`; библиотеки `assets/*` — прежний `THEME_ASSETS_VER`. Любая правка файла меняет URL, браузер не держит старую копию (сервер не отдаёт Cache-Control). `THEME_ASSETS_VER` 1.1.92.

## 2026-10-21 — Универсальные блоки: партия 2–3 (10 блоков), сводная запись интегратора

Не закоммичено. Блоки приведены к одному виду (Identity) без модификаторов и body-скоупа: partial с аргументами, все
тексты/картинки/id — аргументы, пустое не выводится, зашитых текстов нет; правила на классе блока в `css/blocks/<имя>.css`;
копии разметки в шаблонах страниц заменены вызовами partial; стресс-кадры (min/norm/max) в группе «Универсальные блоки —
стресс-кадры» картотеки (`?nv_bloki_stress=<slug>`; `inc/bloki-stress.php` + `inc/bloki-stress/*.php`). Проверка каждого блока —
14 ширин, 0 проблем. `THEME_ASSETS_VER` 1.1.91 (финальный бамп партии).

- **Pricing** (`kyc-pricing-section.php`, `blocks/kyc-pricing.css`) — аргументы `section_id`, `badge`, `title`, `lead`, `eyebrow`, `price_prefix`, `price`, `price_unit`, `price_note`, `cta` + `cta_url`/`cta_form`, `arrow_icon`, `plans` (1–3); серая секция с белыми PageEdge; `.idv-pricing` и body-скоуп убраны; 7 страниц переведены. Кадры pricing-min/norm/max. Проверка: 98 прогонов стресс-кадров Pricing/Integration (7 кадров × 14 ширин), 0 проблем.
- **Integration** (`integration-section.php`, `blocks/integration.css`, новый `inc/integration-preset.php` — `nv_integration_preset()`) — аргументы `section_id`, `badge`, `heading`, `subtitle`, `docs_text`/`docs_url`, `contact_text`/`contact_form`, `path_title`, `slides`, `includes`, `deploy`, `backoffice`; Identity-скоуп снят (34 правила перенесены в конец с сохранением каскада); раскладка «3 карточки» (list | deploy + широкий Back-office) через `:has()`; длинные подписи кнопок и чипов переносятся. /solutions/ и /kyc/ теперь в виде Identity. Кадры integration-min/norm/max/bare. Идентичность эталона: Identity до/после — 0 расхождений на 1920/1440/840.
- **Checks** (`idv-checks-section.php`, `blocks/idv-checks.css`) — 2–6 карточек, `intro`, `lead`, `pill`; **Benefits + promo** (`idv-benefits-section.php`, `blocks/idv-benefits.css`) — 2–4 карточки + promo с необязательным маскотом (на 768–1199 маскот 180px вместо 215). Кадры checks-min/norm/max, benefits-min/norm/max/no-image.
- **Hero** (`kyc-hero-section.php`, `blocks/main-hero.css`, корневой класс `main main--hero`) — убраны модификаторы kyc/identity (~300 строк CSS); аргумент `media` (кадры fhd/desktop/laptop/tablet/mobile, `focus*`) или `media_html`; затемнение в блоке; плашки 280×190 / 180×155 для 3–4 фактов; `mobile_text` с фолбэком; кадр `laptop` для 992–1199 (AML, DocV, Liveness — без вшитой карточки); 7 страниц переведены. Кадры hero-min/norm/max/nomedia.
- **Certs** (`certs-section.php`, `blocks/idv-certs.css`; `kyc-certs.css` пуст) — `section_id`, `title`, `marks` (0–N), `chips` (0–N), `chip_icon`; 7 страниц, копии удалены. Кадры certs-min/norm/max/chips-only. 210 прогонов, 0 проблем. Знак `kyc-cert-qa` на тёмном — `round: true`.
- **Security** (`idv-security-section.php`, `blocks/idv-security.css`, слои карты — `inc/security-map.php`) — 1–3 карточки, знаки и ссылка по желанию, регион и карта необязательны; 6 страниц, копии разметки и `$nv_security_map` удалены; данные Identity — `security.cards` + `regional`. Кадры security-min/norm/max/cards-only/no-map.
- **SEA tabs** (`kyc-sea-section.php`, `blocks/kyc-sea.css`) — `countries[]` 1–6 в любом порядке, строки-характеристики аргументами, пустой текст скрыт; CSS без привязки к Сингапуру; 6 страниц. Кадры sea-min/norm/max. 686 проверок (9 целей × 14 ширин × каждая вкладка), 0 проблем. Без `:has()` виден только первый блок строк.
- **Compliance map** (`kyc-compliance-section.php`, `blocks/kyc-compliance.css`) — `markers` 2–6 + общий; карточка вынесена из-под карты в колонку; маркеры масштабируются с картой (container query); UK и EU сдвинуты на ~3%. Кадры compliance-min/norm/max. 490 проверок + клик по каждому маркеру, 0 проблем.
- **Risk tabs** (`kyc-risk-section.php`, `blocks/kyc-risk.css`) — 2–4 вкладки, иконка — аргумент, боковая карточка необязательна, высота панели по самой длинной вкладке; /kyc/ и /liveness/ (свои иконки). Кадры risk-min/norm/max. 70 проверок × все вкладки, 0 проблем. Произвольных `rows[]` нет (JS знает два слота).
- **Contacts + FAQ** (`contacts-section.php`, `faq-section.php`, `blocks/faq.css`) — Contacts: аргументы `section_id`, `badge`, `title`, `lead` (по умолчанию прежние тексты); FAQ: `section_id`, ответы через `wp_kses` со ссылками. Кадры faq-min/faq-max/contacts-custom (body-класс семейства KYC добавляет `inc/bloki-stress/contacts-faq.php` — костыль, убрать при переводе светлых списков на класс блока). Computed styles: 0 расхождений на home/solutions/kyc/identity/post.
- **Общее (интегратор):** `css/base.css` — примитив ссылок в тексте карточек `.kyc-card__text a` / `.kyc-card__title a` (оранжевая, подчёркнутая, переносится; на оранжевой карточке белая); `functions.php` — `nv_is_light_theme()` включает стресс-кадры (правка координатора); `inc/bloki-data.php`, `inc/bloki-unique.php` — описания/source/edit/deps/frame всех блоков, устаревшие `section.kyc-certs` / `section.main--kyc` / `section.main--identity` и номера строк заменены, слияние «Certs Strip» (31 + 43), 38 стресс-записей; `docs/PAGE_BUILDER.md` §3.1, `docs/COMPONENTS.md`, `docs/pages/*.md` («C-копия» → вызов partial).
- **Не используются после перевода (не удалять, Р-1):** `img/kyc-hero-mobile*.webp`, `img/fv-hero-mobile*.webp`.
- **Для прода одним пакетом:** список файлов — в отчёте интегратора координатору (partials, `inc/*`, `css/blocks/*`, `css/base.css`, `inc/css-registry.php`, `js/main.js`, `functions.php`, страницы, картинки новых блоков).

## 2026-10-21 — Разделение css/styles.css завершено (Р-150), документация

Не закоммичено. `css/styles.css` (28 619 строк, 3 829 правил) разнесён без визуальных изменений: `css/base.css`; `css/layout/` — header, forms, teaser, footer, cookie, modals, light-content, chat-widget; `css/blocks/` — 42 новых блока + steps/platform/industries (пилот); `css/pages/` — 404, price-matrix. `styles.css` — заглушка (не подключается). Подключение — реестр `inc/css-registry.php` (плоский список в исходном порядке правил), цикл в `functions.php` (`theme-styles` = `css/base.css`); `THEME_ASSETS_VER` 1.1.88. Метод — `split_css.py` (инструменты вне темы: `/Users/dmitriy/ZAKAZI/nv.global/tools/css-qa/`): регионы-баннеры + корневой BEM-класс части селектора, порядок и `@media` сохранены, 26 смешанных правил разрезаны, `url(../` → `url(../../` в подкаталогах; 6 487 частей селекторов до = 6 487 после.
Проверка: computed styles всех элементов (+ открытые `callForm`/`callForm2`) до/после — 20 шаблонов, 138 кадров (1920/1440/1100/840/392/320 + 1665/740 для страниц с блоками), 1 432 994 сравнения, 0 расхождений на повторной проверке (25 расхождений в открытой модалке картотеки на 1100 исчезли при повторном прогоне — тайминг; поддеревья-счётчики `.post__meta/.news__item-meta/.blog-card__stat` и `<head>` исключены). Все 56 CSS-файлов реестра отдают 200.
Решения (Р-150): порядок по реестру, не «base→layout→blocks→pages» (иначе меняется победитель при равной специфичности); общие `.btn*`/`.tag`/`.section__tab*` остались внутри cases/doc/hero/solutions/contacts/benefits; `.modal …`-контексты Contacts остались в `blocks/contacts.css`; правило `body.page-template-page-price-matrix .section, body.single-post .section` — в `layout/light-content.css`. Выборочная загрузка (этап 3) отложена — `docs/BACKLOG.md` CSS-01.
Документация: `docs/FRONTEND.md` §2 (структура, реестр, правило «новый блок = partial + css/blocks/<имя>.css + строка в реестре», список общих классов внутри чужих блоков), `docs/DECISIONS.md` Р-149/Р-150, `docs/COMPONENTS.md` («CSS по файлам»), `docs/PAGE_BUILDER.md` §3.1, `docs/BACKLOG.md` (CSS-01…03), `docs/WORDPRESS.md`, `docs/QA.md`, `CLAUDE.md` (строка про правку CSS).
**Для прода одним пакетом:** весь каталог `css/` (base.css, layout/, blocks/, pages/, styles.css-заглушка), `inc/css-registry.php`, `functions.php`. Заливать вместе: `functions.php` без новых файлов (или наоборот) оставит страницы без стилей.

## 2026-10-21 — Разделение CSS по блокам: Steps, Platform Bento, Industries (Р-149)

Не закоммичено. Правила трёх универсальных блоков перенесены из `css/styles.css` в `css/blocks/steps.css` (67 правил), `platform.css` (46), `industries.css` (25) без визуальных изменений; медиа-запросы и `@container` — вместе со своими правилами, порядок внутри блока сохранён. Групповые правила `:is(.kyc-steps, .kyc-platform, .kyc-industries) …` разрезаны на отдельные правила в файле каждого блока. В `styles.css` на месте блоков — комментарии «перенесено в css/blocks/<файл>.css» (остался только `.kyc-onboarding__retakes picture` из прежней смешанной ветки). `functions.php`: массив `$nv_css_blocks` и цикл `wp_enqueue_style` (заменено реестром `inc/css-registry.php`, см. запись выше) (зависимость `theme-styles`, после `styles.css` и до `style.css`, везде, где грузится `styles.css`); `THEME_ASSETS_VER` +1. Документация: `docs/FRONTEND.md` (структура CSS), `docs/DECISIONS.md` Р-149, `docs/COMPONENTS.md`, `docs/PAGE_BUILDER.md` §3.1.

## 2026-10-21 — Audit-иконки новых страниц: без прозрачных полей

Не закоммичено. Только картинки: `img/aml-review-audit`, `docv-ocr-audit`, `docv-face-audit`, `fv-accuracy-audit`, `fv-live-audit`, `kyb-ubo-audit` (1x 255×255 и `@2x` 510×510, размеры прежние). После перевода Platform на картинку в потоке старые поля (right 44/bottom 66) делали иконку ≈110×170 из 510; теперь видимая часть обрезана по альфе и вписана в 430×495 (@2x), прижата вниз-вправо. Замер Playwright на 1920/1665/1600/1440/1366/1200/1100/992/840/768/740/576/392/320 для AML, KYB, Document, Face: пересечений с текстом 0, обрезки краем карточки 0. Карты `docs/pages/{aml,kyb,document-verification,face-verification}.md`.

## 2026-10-21 — Platform Bento: ноутбук всегда из полного изображения (F-3)

Не закоммичено. `css/styles.css`, `template-parts/kyc-platform-section.php`; `THEME_ASSETS_VER` 1.1.85. Ноутбук собирается из целого `identity-platform-laptop` (без обрезанного кадра) и скриншота страницы поверх, оба в процентах от ноутбука; обёртка не клипает. Панель — container query: ≥700px ноутбук виден целиком по центру (≤640px), уже — крупнее панели (118%), отступ слева 23 (12 на Mobile), правая часть уходит под край панели вплотную (обрезает сама панель, `overflow:hidden`). Свой макет `screen_html` лежит в `.kyc-platform__screen-custom` с полями панели.

## 2026-10-21 — Универсальные блоки: пилот (Steps, Platform Bento, Industries)

Не закоммичено. По решению владельца блоки приведены к одному виду (Identity) без модификаторов и body-скоупа, под любой объём контента; пилот — три блока.

- **Партиалы:** `template-parts/kyc-steps-section.php` (аргументы `badge`, `title`, `lead`, `note`, `steps`, `step_label`, … — пустые не выводятся, чип «Step N» убран), `kyc-platform-section.php` (структурные аргументы `top`, `audit`, `pair`, `screen`/`screen_html`, `summary` вместо `top_html`/`summary_html`/`modifier`; классы `idv-platform__*` → `kyc-platform__laptop-wrap/__screen-img/__summary`), `kyc-industries-section.php` (только `tags`, вариант `req` и `modifier` убраны; `badge`, `section_id`).
- **CSS (`css/styles.css`):** удалены 181 правило блоков (Steps 34, Platform 116, Industries 31): body-скоуп `page-template-page-identity-verification`, `.idv-platform` / `.idv-industries`, KYC-варианты, пиксельные подгонки под ширины макета; блоки переписаны на собственном классе. Platform — grid/flex с `minmax` и `min-width:0` (панель 34% в пределах 380–632 на ≥1200, ниже — столбец), картинка аудита в потоке под текстом, ноутбук — кадр 569×430 масштабируется по панели. Industries — 2 колонки на ≥768, нечётная последняя карточка на всю строку, высота по содержимому. Steps — PageEdge и размеры Identity на самом `.kyc-steps`, карточки ленты `min-height` вместо фиксированной высоты. Типографика и бейдж Identity для трёх блоков — через `:is(.kyc-steps, .kyc-platform, .kyc-industries)`.
- **JS (`js/main.js`):** в вертикальном режиме Steps (992–1599.98) высота окна не меньше самой высокой карточки.
- **Страницы:** `/kyc/`, `/identity-verification/`, `page-aml.php`, `page-kyb.php`, `page-document-verification.php`, `page-face-verification.php`, `page-liveness.php` переведены на новые аргументы; `inc/kyc-data.php` — `req` → `tags`.
- **Картотека:** `inc/bloki-stress.php` (10 стресс-кадров), `?nv_bloki_stress=<slug>` в `inc/block-catalog.php` и `page-bloki.php`, группа «Универсальные блоки — стресс-кадры» и обновлённые описания в `inc/bloki-data.php`, `inc/bloki-unique.php`; регламент сборщика — `docs/PAGE_BUILDER.md` §3.1.
- `THEME_ASSETS_VER` повышен на один шаг.

## 2026-10-21 — Роли агентов, реестр замечаний владельца, чек-лист Сборщика

Документация. `CLAUDE.md`: раздел «Роли агентов — читать первым» (роль по названию агента → свои файлы) и строка
`docs/OWNER_REMARKS.md` в карте документов. Новый `docs/OWNER_REMARKS.md`: замечания владельца О-1…О-53 как правила
с ролями. `docs/PAGE_BUILDER.md`: §12 — чек-лист перед сдачей на 14 ширинах (включая 1665/1600/1366/1100/740/576/320)
с замерами пересечений; ссылка на реестр в шапке.

## 2026-10-21 — Platform (Identity): пара карточек заезжала на ноутбук на 1600–1907

Не закоммичено. Ошибка общего варианта `.idv-platform` (видна на /identity-verification/ и всех собранных страницах
семейства identity): на ≥1600 `.kyc-platform__audit{flex:0 0 480px}` + `.kyc-platform__pair{flex:0 0 720px}` = 1212px,
а колонка уже 1212 только на 1920 (913 на 1600) — пара заходила на карточку с ноутбуком до 308px.
`css/styles.css`: audit остаётся 480 (в нём абсолютная картинка — при сжатии ложилась на текст), пара —
`flex: 1 1 720px; min-width: 0`. На 1920 — ровно 480|720 (как в Figma), на 1600 — 480|400.
`THEME_ASSETS_VER` 1.1.81 → 1.1.82. Проверено DOM-замером на 1600/1665/1880 (Identity, Document ×2, Face ×2, AML, KYB):
пересечений нет, 21 из 21; 1440 и 1920 без изменений; снимки Identity 1600 и Document 1665.

## 2026-10-20 — Собранные страницы: правки по замечаниям владельца (7 пунктов)

Не закоммичено. Только шаблоны страниц (`page-aml.php`, `page-kyb.php`, `page-document-verification.php`, `page-face-verification.php`,
`page-liveness.php`), `img/<slug>-*`, карты и этот журнал; CSS/JS/partial не менялись.
- Industries на Liveness/Document/Face/KYB — вариант `idv-industries` с тегами (фразы ТЗ).
- Liveness: 4-я карточка блока атак (сетка 2×2); новая иконка `lv-modes`.
- Hero-кнопки всех пяти страниц: `mobile_text` (Face — modifier `kyc`, на мобильных виден полный текст).
- Face: hero на modifier `kyc` (кадры fhd/desktop/tablet/mobile из светлого фото, 4 плашки фактов 280×190 как на /kyc/); `fv-accuracy-audit` сдвинут в правый нижний угол прозрачными полями (то же для `fv-live-audit`, `docv-ocr-audit`, `docv-face-audit`).
- Platform Bento (AML, KYB, Document ×2, Face ×2): четыре карточки слева, как в библиотеке; тексты ТЗ разложены без изменения слов.
Проверено: 1920/1440/1100/840/740/392 — overflow 0, ошибок JS и 404 нет на всех пяти страницах.

## 2026-10-20 — Hero трёх новых страниц: светлый дневной стиль

Не закоммичено. По замечанию владельца (тёмные ночные hero выбиваются из сайта) заменены hero на `page-document-verification.php`,
`page-face-verification.php`, `page-liveness.php`: вариант Identity (рецепт AML), светлые дневные фото Magnific, HTML-карточки с
текстами ТЗ поверх фото (только ≥992), отдельные кадры без карточки для 768–991.98 и <768. Файлы `img/docv-hero*`, `img/fv-hero*`,
`img/lv-hero*` перезаписаны (`-fhd`/`-desktop` удалены); в шаблонах изменён только блок hero (иконки фактов — `nv_identity_icon`).
В карточке Face убрано «Match 99.8%». Проверено: 1920/1440/1100/840/740/392 — overflow 0, ошибок JS и 404 нет.

## 2026-10-20 — Страница /liveness/ (Liveness Detection) из блоков библиотеки

Не закоммичено. Собрал агент «Сборщик страниц» по ТЗ «Liveness Detection» (13.10.2026); карта, решения
сборщика Л-1…Л-16 и открытые пункты — `docs/pages/liveness.md`.
- Новый `page-liveness.php` (Template Name «Liveness Detection», `NV Page Family: identity`):
  Hero (KYC), Trust chips, Checks ×2 (attacks, why), Steps, Risk Tabs (modes), SEA Map Tabs, Industries, Pricing (C-копия),
  Integration, Security, Contacts, FAQ, Teaser. Отложены: блоки 6, 7, 8, 16, карточки «Gig…» и «Works on everyday phones»,
  5 вопросов FAQ (условные блоки ТЗ).
- Новые картинки `img/lv-*` (18 WebP, 1x/2x): hero ×4 кадра, 4 иконки шагов, иконка блока режимов.

Существующие файлы темы не менялись. Проверено: `php -l`; предпросмотр — администратор 200, гость 404;
1920/1440/1100/840/740/392 — overflow 0, ошибок JS нет, 404 в сети нет, битых картинок нет; один H1, дублей id нет;
вкладки Risk и SEA, шаги, FAQ, слайдер Integration, модалка `#callForm2` работают.

## 2026-10-20 — Страница /face-verification/ (Face Verification) из блоков библиотеки

Не закоммичено. Собрал агент «Сборщик страниц» по ТЗ «Face Verification» (13.10.2026); карта, решения
сборщика Ф-1…Ф-15 и открытые пункты — `docs/pages/face-verification.md`.
- Новый `page-face-verification.php` (Template Name «Face Verification», `NV Page Family: identity`):
  Hero (KYC), Trust chips, Checks ×3 (what, beyond, why), Steps, Platform ×2 (accuracy, liveness), Benefits (duplicates),
  Integration, SEA Map Tabs, Industries, Pricing (C-копия), Security (privacy), Contacts, FAQ, Teaser.
  Отложены: блоки 14 и 17, «[0.1 s]», H3 «Tested on Asian faces» и «Templates, not photos», два вопроса FAQ.
- Новые картинки `img/fv-*` (24 WebP, 1x/2x): hero ×4 кадра, 4 иконки шагов, 2 иконки карточек, 2 HTML-макета экранов.

Существующие файлы темы не менялись. Проверено: `php -l`; предпросмотр — администратор 200, гость 404;
1920/1440/1100/840/740/392 — overflow 0, ошибок JS нет, 404 в сети нет, битых картинок нет; один H1, дублей id нет;
вкладки SEA, шаги, FAQ, слайдер Integration, модалка `#callForm2` работают.

## 2026-10-20 — Страница /document-verification/ (Document Verification) из блоков библиотеки

Не закоммичено. Собрал агент «Сборщик страниц» по ТЗ «Document Verification» (13.10.2026); карта,
решения сборщика Д-1…Д-17 и открытые пункты — `docs/pages/document-verification.md`.
- Новый `page-document-verification.php` (Template Name «Document Verification», `NV Page Family: identity`):
  Hero (KYC), Trust chips, Process-аккордеон, Steps, Checks ×3 (fraud, passports, why), Platform ×2 (OCR, Face),
  SEA Map Tabs, Industries, Pricing (C-копия), Integration, Security, Contacts, FAQ, Teaser.
  Отложены: блок 10 (99.85% без методики), блок 14, Resources, NFC, колонка «Government database check».
- Новые картинки `img/docv-*` (26 WebP, 1x/2x): hero ×4 кадра, фото процесса, 4 иконки шагов, 2 иконки карточек,
  2 HTML-макета экранов; фото и иконки — Magnific, текстовые элементы — HTML-макет (тексты ТЗ, тестовые данные).

Существующие файлы темы не менялись. Проверено: `php -l`; предпросмотр — администратор 200, гость 404;
1920/1440/1100/840/740/392 — overflow 0, ошибок JS нет, 404 в сети нет, битых картинок нет; один H1, дублей id нет;
вкладки SEA, шаги, FAQ, слайдер Integration, модалка `#callForm2` работают.

## 2026-10-20 — Страница /kyb/ (KYB Verification) из блоков библиотеки

Не закоммичено. Собрал агент «Сборщик страниц» по ТЗ «KYB» (13.10.2026), вариант А; карта, решения
владельца К-1…К-6 и открытые пункты — `docs/pages/kyb.md`. ТЗ: не публиковать до подтверждения KYB командой.
- Новый `page-kyb.php` (Template Name «KYB Verification», `NV Page Family: identity`): Hero, Trust strip,
  Checks, Steps, Platform (UBO), SEA Map Tabs, Compliance Map (требования, абзац ТЗ по юрисдикциям),
  Industries, Pricing (C-копия без цены), Why Choose (второй Checks), Integration, Security (полный, как на AML),
  Contacts, FAQ, Teaser. Блок 5 и блоки варианта Б не поставлены. Картинки временные (Identity).
- `docs/pages/kyb.md` — карта страницы.

Существующие файлы темы не менялись. Проверено: `php -l`; предпросмотр — администратор 200, гость 404;
1920/1440/1100/840/740/392 — overflow 0, ошибок JS нет, 404 в сети нет; один H1, дублей id нет;
вкладки SEA, маркеры Compliance, шаги, FAQ, слайдер Integration, модалка `#callForm2` работают.

## 2026-10-20 — AML: блок Security — полная композиция вместо одной карточки

Не закоммичено. По замечанию владельца. `page-aml.php`: блок 16 — копия `idv-security` Identity целиком (две карточки +
региональная карта SEA), тексты — два предложения ТЗ дословно; во второй карточке ISO/ASIB/QA-знаки и кнопка
«Information security policy» (`kyc-btn--small`, ссылка из ТЗ); `$nv_security_map` скопирован из шаблона Identity.
Подробности — `docs/pages/aml.md`. Проверено в предпросмотре 1920/1440/840/392: раскладка 3 колонки / 2+карта /
2 в ряд + карта / столбик, overflow 0, ошибок JS нет.

## 2026-10-20 — AML: собственные картинки вместо временных Identity

Не закоммичено. По указанию владельца. Подробности и источники — `docs/pages/aml.md`, «Замена картинок».
- Новые `img/aml-hero*.webp` (desktop с карточкой результата скрининга; tablet и mobile — фото без карточки),
  `img/aml-step-2*.webp`, `img/aml-step-3*.webp`, `img/aml-platform-screen*.webp` (1x/2x). Фото и 3D-иконки —
  Magnific API (`/Users/dmitriy/ZAKAZI/nv.global/tools/magnific_generate.py`, добавлена опция `--remove-bg`);
  карточка hero и экран дашборда — HTML-рендер с текстами ТЗ и тестовыми именами.
- `page-aml.php`: ссылки на новые файлы, `<source>` для 768–991.98 (`aml-hero-tablet`).

Проверено в предпросмотре 1920/1440/840/392: все `aml-*` загружаются, 404 нет; карточка hero не перекрывает
текст на ≥992, на Tablet/Mobile её нет; шаги 2–3 и экран Platform отображаются.

## 2026-10-20 — Страница /aml/ (AML Screening) из блоков библиотеки

Не закоммичено. Собрал агент «Сборщик страниц» по ТЗ «AML Screening» (13.10.2026); карта, решения
владельца В-1…В-10 и открытые пункты — `docs/pages/aml.md`.
- Новый `page-aml.php` (Template Name «AML Screening», `NV Page Family: identity`): Hero, Trust strip,
  Checks, Steps, Benefits, Platform, SEA Map Tabs и Compliance Map (KYC-блоки в семействе identity),
  Industries, Pricing (C-копия разметки partial, В-1), Why Choose (второй Checks), Integration,
  Security, Contacts, FAQ, Teaser. Условные блоки ТЗ (7, 9, 14, 18a, adverse media, «50+ countries»)
  не поставлены. Картинки временные (Identity), новые файлы в `img/` не добавлялись.
- `docs/pages/aml.md` — карта страницы.

Существующие файлы темы не менялись. Проверено: `php -l`; предпросмотр — администратор 200, гость 404;
1920/1440/1100/840/740/392 — overflow 0, ошибок JS нет, 404 в сети нет; один H1, дублей id нет;
вкладки SEA, маркеры Compliance, шаги, FAQ, слайдер Integration, модалка `#callForm2` работают.

## 2026-10-20 — Сборщик страниц: механизм семейств, предпросмотр, регламент агента

Не закоммичено. Решение — `docs/DECISIONS.md`, Р-148.
- Новый `inc/page-builder.php`: заголовок шаблона `NV Page Family: identity|kyc|solutions` →
  body-класс шаблона-источника + `nv-built-page`; предпросмотр `?nv_page_preview=page-<slug>.php`
  (только администратор, остальным 404, `noindex`, без canonical-редиректа).
- `functions.php`: подключение `inc/page-builder.php`; в `nv_is_light_theme()` — `|| '' !== nv_page_family()`.
- Новые документы: `docs/PAGE_BUILDER.md` (регламент агента), `docs/pages/_TEMPLATE.md` (карта
  страницы). Ссылки — `CLAUDE.md`, `docs/AGENT_WORKFLOW.md`.

Проверено временным шаблоном (семейство identity: Steps + FAQ, удалён после проверки):
предпросмотр — администратор 200, гость 404; body-классы `page-template-page-<slug>`
+ `page-template-page-identity-verification` + `nv-built-page`; светлые шапка/FAQ/подвал;
вид Steps как на Identity (PageEdge); 1440/392 — overflow 0, ошибок JS нет. Чужой шаблон
(`page-kyc.php`) в предпросмотр не подставляется. `/kyc/` и `/identity-verification/` без изменений.

## 2026-10-20 — Картотека блоков: только администратор, остальным 404

Не закоммичено. Решение владельца: каталог доступен только авторизованному администратору.
- `inc/block-catalog.php`: `nv_block_catalog_can()` — `manage_options` (было `edit_pages`, то есть и редакторы). Новая `nv_block_catalog_requested()`: любой из параметров `nv_bloki` (включая `=unique`), `nv_bloki_demo`, `nv_block`. На `template_redirect` (приоритет 0) не-администратору — `set_404()` + `status_header(404)` + `nocache_headers()`, WP подставляет `404.php` (раньше гостю отдавалась обычная страница). Фильтр `redirect_canonical` для этих запросов отключён: иначе WP на 404 «угадывал» `/docs/products/kyc/` и отдавал 301.
- Комментарии в `page-bloki.php` и `functions.php`.

Проверено curl с cookie, сгенерированными локально: `/?nv_bloki=1`, `/?nv_bloki_demo=callout`, `/kyc/?nv_block=.kyc-platform`, `/identity-verification/?nv_block=#how-it-works` — гость 404, редактор 404, администратор 200; `/` и `/kyc/` — 200 для всех. Страниц с шаблоном «Каталог блоков» в БД нет.

## 2026-10-20 — Identity Platform: ноутбук по центру на 576–767.98; ширины 1100/740 в картотеке

Не закоммичено.
- `css/styles.css` (Identity): на 576–767.98 `.idv-platform__laptop-wrap { margin-left: calc(50% - 203.45px) }` — видимый bitmap (4.62…402.29px от слота 319) по центру карточки. На ≤575.98 — прежний отступ 41 из Figma.
- `page-bloki.php`: ширины кадров картотеки `1920/1440/1100/840/740/392` (добавлены 1100 и 740 — на них видны сегодняшние правки: свайп/колесо Steps и карта SEA на 1100, полный ноутбук KYC/Identity и центрирование карт на 740). По умолчанию по-прежнему 1440. Комментарий в `js/bloki.js` обновлён.
- `inc/bloki-data.php`: описание Platform Bento (Identity) — центрирование на 576–767.
- `THEME_ASSETS_VER` 1.1.80 → 1.1.81.

Проверено в iframe: 600/740/767 — ноутбук по центру (76/76, 146/146, 159/159), 392/575 — отступ слева 46 (41 + border/сдвиг bitmap), как раньше. Картотеку под редактором не открывал.

## 2026-10-20 — Кнопка «наверх» убрана с сайта; карты Identity Coverage SEA и Security

Не закоммичено.
- `footer.php` (по прямому указанию владельца): удалён блок `.top__widget` (кнопка «наверх») — со всех страниц. `initTopWidget()` в js/main.js не менялся: при отсутствии `.top__widget` выходит сразу, класс `body__widget--active` больше не ставится, поэтому сдвиг `.post-sidebar-btn-mobile` (css/post.css) не срабатывает — кнопке сайдбара не с чем конфликтовать. Стили `.top__widget*` остались (мёртвые, чистка — вместе с прочей после редизайна). Запись «Scroll-to-top» удалена из картотеки (`inc/bloki-data.php`).
- `css/styles.css`: `.idv-coverage__sea-map` на 768–1199.98 — `width: min(100%, 560px)` (было 360; 560×546 в панели 639–1070×630). Mobile и Desktop — прежние 360.
- `css/styles.css`: `.idv-security__map` на ≤767.98 — `margin-inline: auto` (на 740 карта 336 по центру карточки, отступы 179/179; на 392 без изменений).
- `THEME_ASSETS_VER` 1.1.79 → 1.1.80.

Проверено: SEA 392/740/767 — 360 (319 на 392), 768/1100/1199 — 560×546, 1200/1440 — 360; Security 740/767 — по центру; `.top__widget` отсутствует на /identity-verification/, /kyc/, / после прокрутки, ошибок JS нет.

## 2026-10-20 — KYC Platform: полный ноутбук на 576–991.98; описания картотеки

Не закоммичено. Картинки `kyc-platform-laptop*.webp` экспортированы из Figma уже обрезанными, а на 576–991 карточка `.kyc-platform__screen` шире кадра, и линия обреза была видна посреди карточки (730: ноутбук кончался на 552 при карточке до 699). Figma MCP в сессии не авторизован, поэтому полный ноутбук собран локально из полных ассетов Identity: `identity-platform-laptop@2x` (MacBook) + `identity-platform-screen@2x` (тот же интерфейс NeuroVision), геометрия экрана — из clip-контрактов Identity. Новые файлы: `img/kyc-platform-laptop-full.webp` (640×376) и `@2x` (1280×752).
- `page-kyc.php`: в `<picture>` добавлен `<source media="(min-width: 576px) and (max-width: 991.98px)">` с полным ноутбуком.
- `css/styles.css` (KYC PLATFORM): на 576–991.98 `.kyc-platform:not(.idv-platform)` — ноутбук `width:100%; max-width:620px` по центру карточки, `picture{display:contents}`. На ≤575.98 и ≥992 кадры Figma прежние; Identity не затронута.
- `inc/bloki-data.php`: описания картотеки для How it works (KYC и Identity — свайп/колесо 992–1199) и Platform Bento (KYC и Identity — поведение ноутбука).
- `THEME_ASSETS_VER` 1.1.78 → 1.1.79.

Проверено в iframe: 392/575 — прежний кадр, 576/600/730/900/991 — полный ноутбук (620×364 на ≥730), 992/1100/1440 — 400×489, 1920 — 555×431; горизонтальный overflow 0. Картотека `?nv_bloki=1` не открыта (нужна авторизация редактора); её кадры — iframe настоящих страниц.

## 2026-10-20 — Identity Platform: ноутбук без обреза посреди карточки (≤1199.98)

Не закоммичено. `css/styles.css`: `.idv-platform__laptop-wrap { overflow: visible }` при ≤1199.98. Clip-слоты Figma (319×234 Mobile, 421×392 Tablet) рассчитаны на 392/840; на 420–767 и ~850–991 карточка `.kyc-platform__screen` шире слота, и линия обреза ноутбука была видна посреди карточки (до 83px пустоты). Теперь обрезает только сама карточка (`overflow: hidden`): на 392 и 768–820 кадр прежний, на 600/730 ноутбук со скриншотом виден целиком, на 900/991 уходит за край карточки. Новые картинки не нужны: `identity-platform-laptop*.webp` и `identity-platform-screen*.webp` и так полные. Desktop/FHD не менялись. `THEME_ASSETS_VER` 1.1.77 → 1.1.78. Проверено в iframe 392/600/730/900/991, горизонтальный overflow 0.

## 2026-10-20 — `.kyc-steps`: свайп и колесо мыши в вертикальном окне 992–1199.98

Не закоммичено. `js/main.js`, `initKycPage()` → блок `[data-kyc-steps]`: на ширине 992–1199.98 шаги, кроме кнопок Step, переключает вертикальный свайп (touch, порог 40px) и колесо мыши/тачпада над окном шагов (`[data-steps-viewport]`). Один жест — один шаг; поток инерции гасится до паузы 200 мс. На первом шаге «назад» и на последнем «вперёд» жест не перехватывается — листается страница. Колесо вне окна и поток колеса, начатый над страницей и доехавший до окна, листают страницу. Горизонтальный свайп не перехватывается. `assets/smoothscroll.min.js` уважает `defaultPrevented` — конфликта нет. Вне диапазона поведение прежнее. CSS не менялся. `THEME_ASSETS_VER` 1.1.76 → 1.1.77. Проверено синтетическими wheel/touch-событиями в iframe 1100px на `/kyc/` и `/identity-verification/`, контроль 900/1300px.

## 2026-10-20 — `.products`: внутреннее поле 64px на Mobile

Не закоммичено. По решению владельца сохранена прежняя геометрия 128/96px: `css/styles.css`, `.home.page-template-main-page .products__wrapper` на <768 — `padding-block: 64px` (было 32px); вместе с контрактным 64/32 секции итог 128 (desktop) / 96 (mobile). Legacy `index.php` не менялся. `THEME_ASSETS_VER` 1.1.75 → 1.1.76.

## 2026-10-20 — PageEdge Identity Steps/Pricing Mobile: F-1

Не закоммичено. `css/styles.css`: на <768 `.kyc-steps` и `.idv-pricing` получают `padding-block: 64px` (вместо 64px + `--nv-block-space` = 96px): при крае 64px и panel padding 32px видимое серое поле — 32px. Panel padding и `.products` не менялись. `THEME_ASSETS_VER` 1.1.74 → 1.1.75.

## 2026-10-19 — Единый вертикальный контракт: QA follow-up этапа 1

Не закоммичено. Код: `css/styles.css`; `THEME_ASSETS_VER` 1.1.73 → 1.1.74. PageEdge Identity Steps/Pricing Mobile: края 64px, section inset 64px + token (96px), 32px серого поля за краями; существующий panel padding сохранён. Удалены устаревшие body-scoped секционные 1px/64px/0 компенсации (включая top-only Contacts и FAQ); legacy single-post сохранён. `.products` вынесен на внутренний padding целевого Home с сохранением legacy `index.php`. Scope ограничен прямыми `main > section`; убран дубль. Ретест PageEdge 392/840 и Steps S4/Pricing controls — без регрессии.

## 2026-10-19 — Документация QA follow-up этапа 1

Документация: `docs/DECISIONS.md` уточняет mobile PageEdge, явные шаблоны и подключение будущего шаблона; артефакт `block-catalog/spacing-composer/index.md` исправляет Home count (12) и содержит адресный QA follow-up. Этап 2 отложен.

## 2026-10-19 — Единый вертикальный контракт продуктовых блоков (этап 1)

Не закоммичено. `THEME_ASSETS_VER` → `1.1.73` (до QA follow-up). `css/styles.css`: токен `--nv-block-space` (64px при ≥768px, 32px при <768px), одинаковый верхний и нижний padding у контентных блоков внутри `main` на Home, Solutions, KYC, Identity и Pricing Matrix. Исключены первые экраны и teaser; вертикальные компенсации на тот момент перебивались единым правилом; заменены при QA follow-up ниже. Собственные фоны секций сохраняют пространство внутри фона. Проверено: computed styles всех секций на 1920/1440/840/392 (64/64 и 32/32), overflow 0 на пяти страницах; smoke интерактива Steps, Coverage, Integration и Why. Стыки проверены на crop всех соседних секций на 1440/392 (92 PNG, `scratchpad/spacing-composer/crops/`); sticky header не попал в итоговые crops.

Правки кода и правки документации пишем разными записями.

---

## 2026-10-19 — Картотека: подписи всех блоков по единому стандарту

Не закоммичено, версия не менялась (только PHP-данные). `inc/bloki-data.php` (101 позиция) и `inc/bloki-unique.php`
(14 слияний): описание — состав, поведение, адаптив (для Gutenberg — вид в статье); «Применение» — где стоит и для чего;
«Что менять» — поля с типами и ключами, файлы `img/`, массивы данных; «Зависимости» — body-класс/оболочка, JS и ограничения.
Заглушки сняты; минимальная длина описания — 120 символов. Сверено с кодом блоков, шаблонов и CSS.

## 2026-10-19 — Картотека: каталог уникальных блоков (?nv_bloki=unique)

Не закоммичено. `THEME_ASSETS_VER` → `1.1.72`. Новый режим `?nv_bloki=unique` (тот же доступ `edit_pages`); `?nv_bloki=1` — прежний,
добавлена только ссылка на новый каталог.
- `inc/bloki-unique.php`: карта поверх inc/bloki-data.php — 14 слияний (поле `variants`: номер полного каталога → подпись) и 13 групп
  по назначению; итого 85 позиций, каждый из 101 номеров — ровно в одной (проверено скриптом).
- `page-bloki.php`: сборка уникального списка, «В полном каталоге: №…», переключатель вариантов; `js/bloki.js`: смена кадра
  и ссылок без перезагрузки; `css/bloki.css`: ссылка между каталогами.

## 2026-10-19 — Steps Slider (KYC + Identity): конец ленты <992 и общая лента для KYC

Не закоммичено. `THEME_ASSETS_VER` → `1.1.71`. `css/styles.css`, KYC STEPS ≤991.98: правила ленты перенесены из
`body.page-template-page-identity-verification` в общие `.kyc-steps` (`__right{max-width:none;width:100%}`, viewport
`position:relative` + `scroll-padding-inline` 32/16); правый отступ после последней карточки — спейсер `.kyc-steps__list::after`
(16 px Tablet; 1px с −1px Mobile — бокс нулевой ширины в scrollable overflow не учитывается), padding-right у viewport снят.
Identity Mobile: карточка `min(320px, 100vw − 32px)` (на 320 видна целиком). ≥992 не затронуто.

## 2026-10-18 — Solutions: фото Why Accordion не тянется при переключении карточек

Не закоммичено. `THEME_ASSETS_VER` → `1.1.70`. `css/styles.css`, регион SOLUTIONS WHY: на ≥992 `.solutions-why__media`
абсолютное, ширина от стопки в покое (`100% − open − 3·card + overlap`), как у KYC Process (там `4 *`, правило KYC не менялось).
Замер по rAF на 1920/1440/1200/992 при проходе мышью 1→4→2: left/width фото постоянны (было колебание до 234 px).

## 2026-10-18 — Картотека блоков, этап 2 (101 позиция, памятка, ленивая загрузка)

Не закоммичено. `THEME_ASSETS_VER` → `1.1.69`. Существующие блоки не менялись.

- `inc/bloki-data.php`: полная опись — 101 позиция в 12 группах (порядок spec `block-catalog`); 75 кадров реальных URL,
  18 Gutenberg-демо на существующих вложениях (576–578, 569), 8 блоков без кадра (модалки, cookie, scroll-to-top, пагинация,
  колонка новостей, комментарии — кнопки/пояснения). Номера проставляются по порядку в `page-bloki.php`.
- `page-bloki.php`: памятка «Как собрать новую страницу», блоки `action` (modal / cookie / note), `demo.markup`, `<code>` в подписях.
- `js/bloki.js`: кадр получает `src` только при подходе к вьюпорту (IntersectionObserver, после `load` каталога) и выгружается вдали;
  кнопки модалок и cookie. `css/bloki.css`: памятка, кнопки, скрыты `.top__widget` и cookie-баннер.
- `inc/block-catalog.php`: NeVi не подключается в каталоге, кадрах и демо.

## 2026-10-18 — Картотека блоков, этап 1 (режим кадра + каталог + 6 блоков)

Не закоммичено. `THEME_ASSETS_VER` → `1.1.68`. Новый код только для каталога; существующие блоки не менялись.

- `inc/block-catalog.php` (подключён из `functions.php`): `?nv_block=<селектор>` — режим кадра (whitelist символов, noindex, без admin bar,
  общий CSS скрывает всё, что не целевой блок / его предок / потомок; `.modal` остаются); `?nv_bloki=1` — каталог через `template_include`;
  `?nv_bloki_demo=<slug>` — демо Gutenberg-блока в оболочке записи. Всё только при `edit_pages`, гостю параметры ничего не меняют.
- `page-bloki.php`, `inc/bloki-data.php` (6 блоков: Home Hero, Contacts Home, Steps Identity, Coverage Tabs Map, Pricing Calculator, Callout),
  `css/bloki.css`, `js/bloki.js` (lazy iframe, автовысота, переключатель 1920/1440/840/392, масштаб под колонку) — только в режиме каталога.
- `css/styles.css`: `body.nv-bloki` добавлен в список токенов и в два списка `.container`; `functions.php`: `nv_is_light_theme()` учитывает каталог и демо.

## 2026-10-18 — Contacts: светлые выпадающие списки во всех секционных формах (Р-147)

Не закоммичено. Глобальная правка, отдельный логический блок. `THEME_ASSETS_VER` → `1.1.67`.

- `css/styles.css`: светлые правила `.modal--form .phone-field__*` / `.help-select__*` (dropdown, search,
  search-input, placeholder, search-btn + hover/focus-visible, option + hover/focus-visible/last-child,
  empty, scrollbar track/thumb/hover, search:focus-within) расширены контекстами `body.home .contacts`,
  `body.page-template-page-kyc .contacts`, `…identity-verification .contacts`, `…solutions .contacts`,
  `body.single-post .post__form`. Без новых блоков; ширина/`max-width` списков в секциях не менялись.
- Пока список открыт, секция Contacts (у single-post — `.post-bottom`) поднимается `z-index:5` через `:has()`: иначе
  следующие секции (teaser/FAQ/news) перекрывали хвост списка — это было и у тёмных списков.
- Тёмными остаются формы вне списка: legacy `index.php`, демо `main-page-video-autoplay.php`.
- Docs: DECISIONS Р-147 (снимает Р-117), BACKLOG A-49 закрыт.

## 2026-10-18 — Identity Verification: follow-up-5, независимая проверка 1.1.45 (C5-01…C5-04)

Не закоммичено. Независимая проверка (`review-finish-5`) нашла 4 остатка в уже закрытых разделах
предыдущего раунда — не новый scope. `THEME_ASSETS_VER` → `1.1.46`.

- **C5-01 Coverage (High)**: z-index текстовой панели и visual были перепутаны — документы
  закрывали панель, а не наоборот (Figma красит панель ПОВЕРХ документов). Исправлено
  (панель z-index:2, visual z-index:1). Корневая причина y64 вместо target y144: badge был
  внутри `.idv-coverage__head` (внутри `.idv-coverage__row`, align-items:flex-start), поэтому
  visual стартовал вровень с badge, а не с H2 — badge вынесен в отдельный sibling ПЕРЕД row
  (как в Figma: badge y64, row y144, 48px разрыв между ними). FHD-грид получил
  `grid-template-rows:auto auto` с явным `grid-row` на badge (1) и row/bottom (2) — иначе
  auto-placement сталкивал badge с уже явно позиционированным row. Panel min-height:180px
  (высота самого длинного состояния, SEA, — без неё Documents/Regions короче и «прыгают» при
  переключении вкладок).
- **C5-02 About (Medium)**: `.kyc-about__certs-links{flex-direction:column}` наследовалось от
  KYC-шного FHD-правила (72h вместо32h) — явный `flex-direction:row` для Identity. 840:
  `.kyc-about__certs{padding:16px}` (было 23, KYC-дефолт). 392: `padding-top:32px` у Identity
  (было 1px — «padding-top1px на всех widemodes» из прошлого раунда ошибочно включал Mobile,
  хотя L-05 явно ограничивал это тремя ШИРОКИМИ modes). Divider высота увеличена до2px (1px
  был формально корректен, но едва различим). 1920 topcards y141 вместо157 — добавлен
  `margin-bottom:16px` на `.kyc-about__head`.
- **C5-03 Benefits (Medium)**: маскот (`.idv-benefits__promo-image`) был `position:static`
  (мелкий full-body) на FHD/Tablet/Mobile — переведён на `position:absolute` с overlay-кропом,
  как и было задумано (как на 1440, который уже был близко к цели). Источник-ассет —
  центрированный full-body кадр без отдельного zoom на голову, поэтому буквальный JSON-кроп
  показывал только прозрачный край; элемент укрупнён (сохраняя дух «крупного нижнего кропа»,
  не точные px из contracts, которые предполагают другой исходный crop). FHD-колонки сделаны
  НЕ равными: 3×412px + promo572px (было 4×452 поровну) — promo-карточка была уже на120px.
  Mobile: `align-items`/`text-align` вернули с `center` на `flex-start`/`left` (была явная
  ошибка, не задумано). «Compliance without manual work» всё ещё была на2 строках при общем
  Mobile `font-size:20px` — добавлен scoped `font-size:18px` для `.idv-benefits__card-title`
  (специфичность поднята через `.idv-benefits__card .idv-benefits__card-title`, иначе
  перебивалась общим правилом той же специфичности, но позже в каскаде).
- **C5-04 Platform (Medium)**: Mobile `.kyc-platform__audit-image` был `position:static`
  (192×192 — размер уже верный с followup-5, но статичный блок ПОД текстом, не overlay-кроп) —
  переведён на `position:absolute` с `min-height:320px` на карточке (без резерва высоты
  overlay перекрывал заголовок/текст). `padding-top:1px` у `.idv-platform` (было 64,
  унаследованный KYC-дефолт — тот же паттерн, что у About).

Проверено: PHP lint чисто, CSS-скобки 4278/4278. `/kyc/` Platform (padding-top64) — не затронут.
Coverage keyboard (ArrowRight/Home/End) и no-JS (3 панели readable, tabs none, badge присутствует)
— не регрессировали. Targeted sweep 8 ширин × 2 страницы (identity-verification + kyc) —
**0 overflow/console errors** на всех 16 комбинациях.

## 2026-10-18 — Identity Verification: follow-up-5, продолжение (About + Coverage overlap)

Не закоммичено. Координатор вернул followup-5 в работу: остаток отчёта `1.1.44` неполон — L-05
About не входил в прошлую сессию по ошибке (границы сессии не исключают scope) и Coverage overlap
был признан невозможным без абсолютного позиционирования целой секции — координатор опроверг это
DOM-proof'ом. `THEME_ASSETS_VER` → `1.1.45`.

- **H2 4 строки (Coverage)**: корневая причина — "Territories" (заглавная) вместо "territories"
  из исходника; DOM-замена координатора дала ровно 156h (3 строки) при тех же 40/52. Один символ
  регистра, не font-size. Поправлено в `page-identity-verification.php`.
- **Coverage overlap (L-02, доведено)**: координатор предоставил DOM-proof без абсолютного
  позиционирования всей секции — component-scoped `position:relative`/`z-index` только на
  `.idv-coverage__panel`/`.idv-coverage__tabs` (z-index:1) и `.idv-coverage__visual` (z-index:2).
  `main` (1420 на FHD, 1376 на 1440) — НЕ единая grid-колонка: left(680px fixed)+visual(auto),
  gap:0 вплотную (680+740=1420, 680+696=1376 — без зазора); только после main идёт gap48 до
  side(388, FHD-only). `.idv-coverage__row` вернул себе реальный flex (не `display:contents`) и
  стал одним grid-item рядом с `.idv-coverage__bottom`. tabs/text-панель — 816px с
  `margin-left:64px` внутри 680px левой колонки (64+816=880, на 200px шире колонки) — перекрывает
  visual слева; DOM-порядок (visual после left) красит его поверх панели. Измерено: overlap
  ровно 200px на 1920 И 1440 (было: пропорциональная 0.94fr/1fr аппроксимация без наложения).
- **About (L-05, полностью)**: `padding-top:1px` уже было корректно scoped с followup-4 (не
  требовало повторного фикса). Реальный остаток — обе верхние карточки (`.kyc-about__accuracy`,
  `.kyc-about__documents`) использовали `flex:1 1 0`, что на 1440 "случайно" давало ровно 680px
  (контейнер там точно 1376=680×2+16), но на 1920 (контейнер 1856) растягивало их до 920px.
  Фикс — явные `flex:0 0 680px;width:680px` вместо совпадения по ширине контейнера. Марки
  (`.kyc-about__badges img`): 120h на FHD (KYC-шное FHD-правило задаёт 72px под свою 3-колоночную
  сетку — не подходит Identity), 72h на Mobile (KYC-дефолт 88px). 840: `.kyc-about__certs-title`
  max-width:681px (точно по `about-840.json`, было ограничено только отступами card, 728px).
  Section height: 1920 593 (target591, Δ2), 1440 597 (Δ6) — в пределах погрешности, не трогалось
  дальше. Divider на 392 уже был корректен с followup-5 (не переоткрывался).

Проверено: PHP lint page-identity-verification.php + kyc-about-section.php чисто, CSS-скобки
4265/4265. `/kyc/` About (3-колоночная FHD-сетка, карточки 521w/782w, марки 72h, height:220
фикс.) — не затронут (правки scoped `body.page-template-page-identity-verification .idv-about`).
Coverage 3 вкладки (Documents/Regions/SEA) на 1440/1920 — 16/13/16 изображений без ошибок после
рестрактура overlap. Targeted sweep 8 ширин × 2 страницы — 0 overflow/console errors.

## 2026-10-17 — Identity Verification: follow-up-5 (точные координаты layout-contracts)

Не закоммичено. Источник целей — `layout-contracts/{component}-{width}.json` (точные frame-rects
из сохранённого Figma XML), не собственная CSS/прошлый самоотчёт. `THEME_ASSETS_VER` → `1.1.44`.

- **Integration (L-07)**: FHD-композиция слайдера переведена с вертикального стека на Grid
  `264px 476px` (gap32) — title+controls слева, REST-pane-карточка справа через всю высоту
  (`integration-1920.json`: slider820×340, left-group264×292 x56/y273, REST-pane476×292
  x352/y273 — gap=320-24-264=32). 1440: `.integration__path` 600px (не 400, `integration-1440.json`:
  main600+gap16+info760=1376). 840/1440: `.integration__card-image--folders` 280×195 (было 160×112
  без источника). 392: 182×127 (`integration-392.json`). «Compact actions» — Mobile
  `.integration__actions`/`.integration__btn` по содержимому (не `width:100%` на весь ряд).
  Все правки scoped `body.page-template-page-identity-verification` — KYC/Solutions не тронуты.
- **Coverage (L-02/L-03)**: корневая причина «весь layout не совпадает» — `.idv-coverage__row
  {align-items:flex-start}` в row-направлении (≥1200px) переопределяется в column-направлении
  (≤1199.98px) и там же становится КРОСС-осью (шириной): `.idv-coverage__visual` схлопывался до
  max-content некопируемого ряда документов (662px вместо 360px секции на 392) — отсюда «сдвинутый
  вправо» ряд и Morocco вместо центральных Armenia/Andorra/Italy. Добавлен `align-items:stretch`
  в этом же media query. После фикса visual/docs-row точно совпадают с `coverage-{840,392}.json`
  (пиксель-в-пиксель по x каждого документа), 1920 — 740×680 точно (grid-ratio пересчитан
  0.94fr:1fr), боковая колонка 388px (было 280px без источника). SEA/Regions: все 3 вкладки дают
  ненулевой canvas (16/16 слоёв SEA, 13/13 Regions, 0 ошибок загрузки на 1440/1920); Belarus-флаг
  (6-SVG композит из followup-5 L-03) рендерится корректно и в контексте страницы, не только
  изолированно. Keyboard-регрессия (ArrowRight/Home/End по табам) не нарушена.
- **Certs 392 (L-06)**: `.idv-certs{padding:16px 0}` (было 24), `.idv-certs__inner{padding:12px}`
  (было 16), gap между title/tokens сужен до 8px (тесная группа, как в Figma) + отдельный
  `margin-top:30px` на `.idv-certs__badges` (а не единый uniform gap) — inner 360×216 (target214,
  ±2px), секция 392×248 (target246, ±2px).
  Все остальные L-06-пункты (840 Grid/title) не переоткрывались, уже закрыты в followup-4.
- **Benefits (L-04)**: иконка `.kyc-icon-box` перенесена из отдельного span-соседа ВНУТРЬ `<h3>`
  (первый inline-узел) и переключена с `position:absolute` на `float:right` — текст обтекает её
  только на строке(ах), реально соседствующей с иконкой, не на каждой перенесённой строке (прежний
  `padding-right:44px` на titled целиком снят). «Higher onboarding conversion» и «Compliance
  without manual work» укладываются в 1 строку на Mobile/840 без лишнего отступа на 2-й строке.

Файлы: `page-identity-verification.php`, `css/styles.css`, `functions.php` (`THEME_ASSETS_VER`).
Не закоммичено, не запушено, БД/формы не трогались.

## 2026-10-17 — Identity Verification: follow-up-4 (доказанные причины CSS-регрессий)

Не закоммичено. Независимая сверка 32 пар против 1.1.30 дала 4 группы с доказанными runtime-
причинами (DOM-фикстуры координатора + QA-диагностика трёх точечных причин).

- **Hero Mobile facts**: `<=991.98 .main--identity .main__facts{height:148px}` не имел Mobile-
  сброса (148 наследовался от Tablet-значения, не контентное решение) — добавлен `height:112px`
  в Mobile-блоке, `.main__fact{height:112px}`, `font-size:14px;line-height:1.42857` (unitless,
  не округлённые 142.857%). DOM-фикстура координатора подтвердила: весь текст помещается
  (scrollHeight===clientHeight).
- **Hero FHD facts**: безусловная `.main__fact-title{font-size:24px}` (общий Solutions/KYC hero)
  обрезала факты 1/3 на FHD (scrollHeight206>clientHeight188) — scoped `18px/1.3333` для
  `.main--identity` на FHD (1440/840 уже были 18/24, не трогались).
- **Hero Mobile crop**: подключён точный source `identity-hero-mobile(@2x).webp` (из
  hero-mobile-source.png 3063×2282, другой aspect, не кроп общего 1600×1056 файла) через
  `<source media="(max-width:767.98px)">`; `transform:scale(1.35)` (догадка) заменён на точный
  `left:-20.46%;top:-36.57%;width:141%;height:157.57%` из DOM-фикстуры координатора.
- **Security**: индивидуальные SVG-слои не несут общего canvas (у каждого свой тесный bounding
  box) — голый `top:0;left:0` сводил всё в один угол. Подключены точные inset-проценты всех 16
  слоёв (exact-assets/security/coordinates.json, node 2642:30982, кадр 369×360) — каждый `<img>`
  получил собственный `top/right/bottom/left`; обёртка — `aspect-ratio:369/360` без
  `transform:scale` (не нужен при точных процентах).
- **Coverage documents**: `flex:1`/`height:100%` делили место по свободной ширине — паспорта
  были широкими горизонтальными полосами. Заменено на фиксированные 140×200 (392: 98×140),
  `flex:0 0 <px>`, ряды центрированы и обрезаны по краям visual (не ужаты под контейнер) —
  соответствует реальному source (5/6/5, ряд из 6 шире видимой области). `.idv-coverage__visual`
  min-height 680px (wide/Tablet), на Mobile — 468px (3×140+2×8+2×16, по контенту).
- **Platform 840** (QA-диагностика): `.kyc-platform__grid{flex-direction:column}` наследовался
  от общего KYC-правила (@max-width:991.98px) — `flex-wrap`+`display:contents` сами по себе не
  создают строку без явного `flex-direction:row`; pair/screen — `flex:0 0 calc(50% - 12px)`
  при gap24 (не `flex:1 1 0`, который сползался на отдельные строки).
- **Certs 840** (QA-диагностика): nowrap-row из 3 inline items обрезал 3-ю марку справа —
  заменено на CSS Grid (`grid-template-areas:"title badges" "tokens badges"`, columns
  `1fr auto`) — title+tokens колонкой слева, badges — во всю высоту справа, без переноса.
- **Integration ≤767.98** (QA-диагностика): 2-колоночное правило (без нижней границы, до
  1599.98) не сбрасывалось на Mobile — добавлен явный сброс `grid-template-columns:minmax(0,1fr)`
  И `grid-column:1;grid-row:auto` на backoffice (одного sбpoса columns недостаточно — implicit-
  колонка от прежнего `grid-column:2` продолжала резервировать место).
- **Benefits 840**: `flex:1 1 0` на grid/promo не давал истинные 50/50 (promo растягивался
  шире) — заменено на `flex:0 0 calc(50% - 8px)`. Icon-box переведён на `position:absolute`
  (top:23px;right:23px) — больше не занимает отдельную строку перед заголовком; добавлен
  `padding-right:44px` на заголовок, чтобы текст не наезжал на иконку. Mobile card-text
  добавлен в общий 16/24-сброс (был пропущен, оставался 18/28).
- **About FHD**: KYC-шный `height:220px` на каждой из 2 карточек (своя 3-колоночная FHD-сетка)
  давал 748h секции вместо целевых ~591 — сброшен на `height:auto` для Identity. **840**: марки
  120px (KYC-размер) сжимали text-колонку — уменьшены до 80px, cert-text — явный `flex:1 1 0`.
- **Badge→H2 gaps**: Benefits/Checks/Security badge-to-title были 0 (KYC-отступы не задавали
  гап вовсе в этих 3 секциях) — добавлен `margin-top:48px` на заголовки (Figma-норма,
  Platform/About уже были корректны и не трогались).
- `THEME_ASSETS_VER` → `1.1.36`.

### Регрессия
PHP lint 14 файлов, `node --check`, CSS-скобки 4217/4217 — чисто. Coverage keyboard+no-JS
(tabs скрыты, 3 панели читаемы) и 4 Steps states — не регрессировали. KYC About-badges (120px,
свои), Integration deploy-карточка (есть, 3 карточки) — не затронуты.

---

## 2026-10-17 — Identity Verification: follow-up-3 (остатки V2, точные ассеты)

Не закоммичено. Независимая сверка 32 пар (8 секций × 4 ширины) против follow-up-2 нашла, что
больше 3 пунктов самоотчёта были не доведены. Ассет-блокер снят координатором — скачаны точные
Figma-файлы (`/tmp/nv-identity-spec/exact-assets`), перенесены в тему.

- **Ассеты**: `identity-platform-laptop(@2x).webp` и `identity-platform-screen(@2x).webp`
  пересобраны из оригиналов 2011×1183/2880×1712 (прежние были сконвертированы в 400×489 БЕЗ
  сохранения пропорции ещё на этапе создания файла — узкий вертикальный ноутбук не был CSS-багом).
  `identity-security-*.svg` — точный набор 16 слоёв node 2642:30982 (взамен смеси с 9-слойной
  Coverage SEA). `identity-icon-{bank-card,cup,building-office,university}.svg` → добавлены в
  `inc/kyc-icons.php` (`bank-card`/`cup`/`building-office`/`university`). `identity-step-decision
  .webp` — точная decision-иллюстрация (была `kyc-step-4`, смысловое приближение).
- **V2-13 Security**: карта пересобрана на точном 16-слойном наборе, рамка 369×360 (была 481×233
  от смеси с Coverage SEA) — компактный почти-квадратный слот вместо горизонтальной полосы;
  карта теперь справа от текста на 1440 И 840 (`row-reverse` для диапазона 768–1599.98px, не
  только 1440); GDPR+ISO рядом на 840 (как на FHD, не в столбец); Mobile-карта крупнее (260×254).
- **V2-05 Platform**: геометрия ноутбука пересчитана по новому 2011×1183 source (вырез экрана
  9.7%/0.4%/80.5%/96.4%, был 9.75%/4.09%/80.25%/85.89% от неверных пропорций); `.kyc-platform
  __screen{min-height}` сброшен для Identity (новый ноутбук вдвое короче); 840 — audit+no-code
  full-width, risk+case колонкой слева, ноутбук справа (`.kyc-platform__col/__row` раскрыты в
  grid-обёртке `flex-wrap`); Mobile summary — компактнее.
- **V2-06 Coverage**: стена документов — 3 реальных плотных ряда (5/6/5, без переноса) вместо
  сетки мелких 90×128 карточек — на ВСЕХ 4 ширинах. По пути найден и исправлен баг: percentage-
  height цепочка panel→grid→row→doc не резолвилась на FHD (после перехода `.idv-coverage__row`
  на `display:contents` для 3-колоночной раскладки, `.idv-coverage__visual` стал grid-, не
  flex-элементом) — документы схлопывались до 0 высоты; исправлено `.idv-coverage__visual
  {display:flex}` + `flex:1` на активной панели. Stats icon справа на Mobile.
- **V2-09 Industries**: точные иконки — e-wallets→`bank-card`, gaming→`cup`,
  marketplaces→`building-office`, government→`university` (были похожие user/shield/industry/globe).
- **V2-02 Certs**: 1440 — заголовок в 2 строки (max-width 330, был 280); 840 — реальная целевая
  композиция heading+chips слева / marks справа (не прежнее heading-над-marks из ≤1199.98,
  которое верно только для Mobile) — потребовался `flex-shrink:0` на заголовке, иначе он всё
  равно сжимался до 3 строк несмотря на max-width.
- **V2-10 Benefits**: 840 — 3 карточки колонкой слева + promo справа (2 колонки, было всё в один
  столбец); icon-box — upper-right, не upper-left (`align-self:flex-end` в column-flex управляет
  именно горизонтальной осью); Mobile-маскот крупный по центру снизу (было мелким слева).
- **V2-11 About**: FHD — две метрики рядом с вертикальным разделителем (KYC-шное FHD-правило
  `.kyc-about__figures{flex-direction:column}` рассчитано на другую, 3-колоночную FHD-сетку);
  cert-row текст — полная ширина (не узкая 633px-колонка с пустым местом).
- **V2-12 Integration**: `.integration__info` grid (list|deploy row1 + backoffice full row2) был
  рассчитан на 3 карточки KYC/Solutions — у Identity (без deploy) оставлял пустую колонку и
  ронял backoffice отдельной строкой; теперь list+backoffice делят 2 колонки (backoffice
  переключён на вертикальную компоновку — 700+277px картинка+текст не умещались бок о бок в
  половинной колонке), на всех диапазонах до 1599.98 включительно (1440 и 840 оба получают это).
- **V2-01 Hero Mobile**: CTA-кнопки — compact width по содержимому (были растянуты на всю
  ширину через `align-items:stretch`).
- **F2-01 (QA-находка)**: Coverage tablist без JS был виден, но «мёртв» (клик ничего не делает) с
  вводящими в заблуждение aria-selected/tabindex — скрыт тем же enhancement-гейтом
  `[data-coverage-ready]`, что и панели; все 3 панели остаются читаемыми без JS, с JS поведение
  не изменилось (клик/клавиатура проверены заново на 392/1440).
- `THEME_ASSETS_VER` → `1.1.30`.

### Регрессия
PHP lint 14 файлов, `node --check`, CSS-скобки 4206/4206 — чисто. Targeted sweep 8 ширин (1920…320)
× 2 страницы — 0 overflow/errors. Coverage keyboard (click/ArrowRight/Home/End) + no-JS (3 панели
читаемы, tabs скрыты), 4 Steps states на обеих страницах, KYC Platform/Integration/About не
затронуты (все фиксы scoped через `body.page-template-page-identity-verification` или зависят от
отсутствующей у KYC карточки deploy) — проверено отдельно.

### Не закрыто (явно, не выдано за решённое)
V2-01 Mobile hero — фото-кроп/масштаб скорректирован (`scale(1.35)`), но не сверен попиксельно с
Figma; высота фактов (148 вместо 112h) остаётся из-за длины текста фактов 1/3 без mobile_text
(контентное решение из follow-up-1, не CSS-баг).

---

## 2026-10-17 — Identity Verification: follow-up-2 (V2-01…V2-13, независимый visual review)

Не закоммичено. После независимой side-by-side сверки 15 статических секций × 4 ширины с Figma
exports (`/tmp/nv-identity-spec/compare-v2`). Полный разбор — `followup-2/report/index.md`.

- **V2-01 Hero**: `.main__facts` 180px на FHD (не 280, specificity-ошибка чуть не сломала Tablet/
  Mobile ряд — исправлено `@media(min-width:1600px)`); `.main__facts{height:148px}` на 840
  (раньше наследовала базовые 120px — это и сдвигало H1/subtitle на 28px вниз через
  `justify-content:space-between` в `.main__body`); Mobile — карточка переведена на CSS Grid,
  кнопки делят строку с фото (`grid-row`) без абсолютного позиционирования и без дублирования
  разметки; фото увеличено `transform:scale(1.35)`.
- **V2-02 Certs**: заголовок на FHD рвался на 3 строки (`max-width:280px` в контейнере 1856) —
  снят лимит; на Mobile порядок исправлен на heading→chips→marks (`display:contents`), марки
  остаются 80px (не ужимаются до 48).
- **V2-03 Checks**: `.section__badge{align-self:center}` не работал вовсе (родитель `.container`
  не flex) — заменён на `margin:0 auto`; Mobile body-текст возвращён к 16/24 (был 18/28 от
  безусловного F-02-правила).
- **V2-04 Steps**: добавлены 2 из 4 реальных иллюстраций (смартфон/аналитика — точные существующие
  ассеты KYC, сверено визуально с FHD-экспортом), «Step N»-чип скрыт на FHD только для Identity,
  Mobile-иллюстрация уменьшена 200→130px. Паспорт (step 1) был уже верным.
- **V2-05 Platform**: экран ноутбука был ПОЛНОСТЬЮ скрыт чёрным экраном (отсутствовал z-index у
  скриншота, плюс неверный расчёт высоты — `height:auto` от intrinsic-пропорции давало только 176
  из нужных 420px) — найдено и исправлено пиксельным промером выреза экрана; Identity-композиция
  на Tablet теперь audit full-width → risk+case в ряд (было вперемешку с audit).
- **V2-06 Coverage**: иконка/текст stats переведены в строку с иконкой справа на Mobile (была
  колонка с иконкой сверху).
- **V2-07 Coverage no-JS**: критичный доступность-баг — `display:none` на неактивных панелях был
  безусловным (не зависел от `hidden`/JS), 2 из 3 состояний были полностью недоступны без
  JavaScript. Исправлено через `[data-coverage-ready]`, который выставляет сам JS при успешной
  инициализации; без JS теперь читаемы все 3 состояния, с JS поведение не изменилось (проверено).
- **V2-08 Accuracy**: NIST-карточка переставлена перед metrics/cards на Tablet/Mobile (`order:-1`).
- **V2-09 Industries**: сетка на FHD возвращена к 2×3 (была KYC-шная 3×2); добавлена точная
  существующая иконка `crypto` для Crypto exchanges (было визуально похожее `scan`).
- **V2-10 Benefits**: 3 карточки и promo объединены в один ряд на FHD (новая обёртка
  `.idv-benefits__row`, `display:contents` у `.idv-benefits__grid`); icon-box в карточках
  растягивался на всю ширину (`align-items:stretch` в column-flex без `align-self`) — исправлено.
- **V2-12 Integration**: REST-описание (единственный слайд Identity) — обычный вес шрифта, а не
  унаследованный `font-weight:700` от 3-слайдового KYC/Solutions набора.
- **V2-13 Security**: карта была растянута в горизонтальную полосу (`width:100%;height:160px` при
  композиции, рассчитанной на другой контейнер) — переведена на ту же технику, что Coverage SEA
  (слои в нативном размере + `transform:scale`), вписана в компактный слот слева от текста;
  GDPR+ISO — в ряд на FHD; на Mobile карта теперь идёт последней (после текста), а не раньше heading.
- `THEME_ASSETS_VER` → `1.1.16`.

### Продолжение раунда — V2-05/06/11/12 доведены (не только «mechanical wins»)
- **V2-05 Platform**: найден и исправлен ещё один баг — `.kyc-platform__audit`/`__pair` на Mobile
  схлопывались почти до нуля (flex:1 1 0 в row-направлении управляет шириной, но в column после
  смены direction та же запись даёт flex-basis:0 по высоте) — `flex:0 0 auto` возвращает высоту
  по контенту. Порядок no-code→audit→risk→case→laptop→summary подтверждён на 392.
- **V2-06 Coverage**: на FHD — `.container` переведён в CSS Grid (3 колонки: left/visual/promo+
  stats), `.idv-coverage__row` и `.idv-coverage__bottom` раскрыты в его прямые grid-элементы —
  promo+stats теперь справа от visual, не отдельной строкой снизу. На 840/392 унифицирован порядок
  (`.idv-coverage__left` тоже раскрыт): badge/H2/intro → visual → tabs → text panel (раньше 840
  показывал tabs/panel перед visual, а 392 — visual перед самим heading).
- **V2-11 Pricing/About**: Pricing-840 — Free pilot и Volume/enterprise теперь в ряд под
  полношириной price-карточкой; About-FHD — metrics+documents в верхнем ряду (2 колонки), certs
  полной шириной ниже (была KYC-шная 3-колоночная FHD-сетка 2561:36904, для Identity не подходит);
  About-840 — марки остаются справа внутри карточки сертификатов; About-392 — documents 24/36,
  cert description 16/20 (специфичность-конфликт с правилами выше).
- **V2-12 Integration**: стрелки на Tablet/Mobile перенесены под заголовок (своя строка на всю
  ширину, была в общей KYC/Solutions grid-ячейке рядом с title); карточка «Cloud, on-premises or
  hybrid» скрыта новым опциональным `show_deploy_card` (default true — KYC/Solutions не трогаются).
  FAQ пересверен — первый item/второй item уже 360×249/360×80 (точно по таргету), общая высота
  секции 1647 vs цель 1697 (97%, в пределах погрешности, не трогалось дальше).

Регрессия после этих правок: PHP lint 14 файлов + `node --check` — чисто, CSS-скобки 4164/4164,
targeted sweep 8 ширин × 2 страницы (1920…320) — 0 overflow/errors, Coverage keyboard/no-JS и
4 Steps states — без изменений поведения.

### Не закрыто (см. report, явно не объявлено решённым)
V2-04 (иконки decision/document — ближайшие, не точные Figma-ассеты), V2-06 (1440 docs тремя
крупными обрезанными рядами с overlap text panel — не делалось), V2-09 (4 из 6 иконок —
ближайшие, не точные). Источник блокировки там, где указано явно, — Figma MCP недоступен без
повторной авторизации в этой сессии.

---

## 2026-10-17 — Identity Verification: follow-up-1 (F-01…F-07, fixes required)

Не закоммичено. Правки по единому follow-up-тикету после review FIXES REQUIRED
(отсутствие карты Security, Coverage Documents 5 фото вместо полного набора, непроверенная
геометрия hero, без visual QA/sweep).

- **F-01 (реальный shared reuse)**: 6 новых data-driven partials в `template-parts/`:
  `kyc-hero-section.php`, `kyc-steps-section.php`, `kyc-platform-section.php`,
  `kyc-industries-section.php`, `kyc-pricing-section.php`, `kyc-about-section.php`.
  `page-kyc.php` и `page-identity-verification.php` теперь вызывают их через
  `get_template_part(..., $args)`; текст/классы/ID/поведение KYC сохранены байт-в-байт
  через значения `$args` по умолчанию. Не page-builder — структурно разные блоки
  (media/top/screen/summary) передаются готовым HTML через `*_html`-аргументы.
- **F-02 (Identity-only типографика)**: новый блок «IDENTITY TYPOGRAPHY» в `css/styles.css`,
  все селекторы под `body.page-template-page-identity-verification`, значения — по
  зафиксированным расхождениям factual vs Figma (Tablet H2 40/52, Mobile 32/44, Mobile
  lead/body, wide Checks/Industry body, Pricing note, cert title).
- **F-03 (геометрия hero)**: `.main--identity{padding-top:16px}` (устранён источник
  сдвига y96→112), раздельные `min-height` card на 1920/1440/840, Mobile — `display:contents`
  реструктуризация (H1 вне карточки, фото 360×240, описание 344px, горизонтальная лента
  фактов со свайпом). Мобильные факты: 2-й «0.1 s per face match», 4-й «From $0.25 per
  KYC check» — больше не дублируют друг друга.
- **F-04 (Coverage)**: три отдельных tabpanel (`idv-coverage-panel-{key}`, каждый со своим
  текстом в DOM — не только в JSON), `.idv-coverage__left`/`__visual` на одном уровне,
  Mobile — порядок visual→tabs→text через `order`; Documents — полный набор 16 фото
  (`identity-coverage-doc1…16.webp`); Regions — реальная карта + кластеры флагов
  (`.idv-coverage__region-marker`); stats-иконка — звезда, не check-circle. `initCoverage()`
  в `js/main.js` переписан на переключение `hidden`/`.is-active` по реальным DOM-панелям.
- **F-05**: карта Security восстановлена (`.idv-security__map`, слои `kyc-sea-*.svg`,
  инсеты из `figma-2642-30982`); Certs — нативные пропорции бейджей (80×80/62×80/81×80),
  Tablet/Mobile — заголовок над знаками (`column-reverse`); Checks — обёртка
  `.idv-checks__group` (рамка+скругление), сетка на Flexbox (не Grid), 2 колонки на Tablet;
  Platform note-иконка — `swap` (была ошибочно `check-circle`); Benefits check-circle
  оставлен как есть (подтверждено корректным, реальный источник `imgCheckCircleIconlyPro`).
- **F-06 (escaping)**: `faq-section.php`/`integration-section.php` — `echo $var; // phpcs:ignore`
  заменены на `wp_kses_post($var)` (не `esc_html()` — в дефолтных строках есть `&nbsp;`/`&mdash;`).
- **Найден и исправлен в ходе QA**: на Mobile факты без `mobile_text` (1-й и 3-й) рендерились
  пустыми — `.main__fact-title--wide` была безусловно скрыта в `@media (max-width:767.98px)`
  без mobile-замены. Исправлено через `:has()` (уже используется в `styles.css` в других
  местах): wide скрывается только когда реально есть `.main__fact-title--mobile`-сосед.
- `THEME_ASSETS_VER` → `1.1.2`.

### QA этого раунда
Playwright: regression KYC/Identity (H1/кнопки/факты/цены/текст всех 6 вынесенных секций —
идентичны прежним), Coverage — клавиатура (click/ArrowRight/End/Home) на новой 3-panel
структуре, весь текст 3 состояний подтверждён в DOM без JS; геометрия hero на 1920/1440/840/392
(card y96, title/desc x/y/w/h — совпадает с таргетом); Certs/Checks/Security на 1440/840/392;
FAQ-аккордеон и Integration-текст после escaping-фикса — функциональны, без двойного
экранирования; смоук Home/Solutions/Pricing — без ошибок; PHP lint (13 файлов) и
`node --check` — чисто; CSS-скобки сбалансированы (4103/4103).

**Уточнение (follow-up-2, V2-07):** «текст в DOM без JS» выше проверялся через `textContent`
скрытых панелей — технически верно, но вводило в заблуждение: панели были `display:none`
безусловным CSS-правилом (не зависело от `hidden`/JS), то есть реально недоступны и для
скринридеров тоже при отключённом JS. Настоящая progressive-enhancement проверка
(`javaScriptEnabled:false` в Playwright) сделана только в follow-up-2, см. запись выше.

---

## 2026-10-17 — страница Identity Verification (`/identity-verification/`)

Figma: FHD 2666:50067, Desktop 2620:25851, Tablet 2654:34135, Mobile 2666:42085. WP page ID 1213
(publish, назначен шаблон). Не закоммичено.

- `page-identity-verification.php` — новый шаблон, 17 секций, reuse-first по аудиту ТЗ:
  hero (`.main--solutions.main--identity`, новый фон+градиент), `.kyc-card`/`.kyc-title`/
  `.kyc-lead`/`.kyc-btn`/`.kyc-icon-box`/`.kyc-token` примитивы, `.kyc-steps` (initKycPage()
  без изменений, один `[data-kyc-steps]` на загрузку страницы — конфликта с /kyc/ нет),
  `.kyc-industries`/`.kyc-about`/`.kyc-pricing` variants, Integration/Contacts/FAQ/News —
  общие partials.
- `template-parts/news-section.php` — News вынесен из `main-page.php` (строки 1093–1152)
  без изменений разметки/поведения, подключён на Home и на новой странице.
- `template-parts/integration-section.php` — добавлены необязательные `$args`
  (badge/heading/subtitle/slides), значения по умолчанию — прежние тексты KYC/Solutions;
  Identity передаёт только 1-й слайд (REST API), 2-й/3-й остаются данными компонента.
- `template-parts/faq-section.php` — добавлены необязательные `$args` (title/description),
  по умолчанию прежний текст KYC/Solutions.
- `inc/identity-verification-data.php`, `inc/identity-icons.php` — данные/иконки по паттерну
  `inc/kyc-data.php`/`inc/kyc-icons.php`.
- Новая секция Coverage (Documents/Regions/Southeast Asia) — `initCoverage()` в `js/main.js`,
  отдельный guarded-контроллер (не копия `initKycPage()`): текст через `data-idv-states`,
  справа — переключение целиком видимого визуального блока.
- `css/styles.css`: блок `IDENTITY-PAGE` (hero/certs/checks/platform/coverage/accuracy/
  industries/benefits/security). **Отдельным, более важным фиксом** — страница не входила
  ни в один из существующих списков селекторов, которые объявляют токены `--nv-*`
  (HOME THEME) и включают светлую тему для `.contacts`/`.faq`/`.teaser`/`.footer`/`.section`
  (CONTACTS/FAQ/TEASER HOME/FOOTER HOME): без этого вся страница, включая переиспользованные
  блоки, рендерилась тёмной с нечитаемым текстом. `body.page-template-page-identity-verification`
  добавлен туда же, где уже стоял `body.page-template-page-kyc` (364 места, скрипт расширения
  списка селекторов, исходные селекторы сохранены байт-в-байт) плюс отдельно в HOME THEME
  (токены) и `body.home .section*` (News использует общий `.section`, не `.kyc-section`).
- `functions.php`: `page-identity-verification.php` добавлен в `nv_is_light_theme()`
  (светлый футер/тизер через существующий `nv_is_light_theme()`-свитч), `THEME_ASSETS_VER` → `1.0.96`.
- Новые ассеты: `img/identity-*.webp` (hero/steps/platform/benefits/nist/coverage-docs,
  x1+@2x), `img/kyc-flag-my.svg`, `img/kyc-flag-ph.svg` (были только 8 из 10 нужных флагов).
  Остальные иконки/карты/сертификаты — переиспользованы из существующих `img/kyc-*`.
- Два заголовка оставлены дословно как в Figma, несмотря на видимое несоответствие смыслу
  секции (копипаст в макете): Accuracy — «Seamless Integration That Just Works», Security —
  «Risk-Based KYC: Simplified, Standard and Enhanced Due Diligence» (дословно повторяет /kyc/).

### Не проверено / упрощено (для follow-up)
- Hero-фото — один responsive `<img>` с `object-fit:cover` вместо 4 отдельных пречерченных
  кропов по брейкпоинтам, как у `kyc-hero-*`: в token-экономном кэше была только Desktop-версия.
- Coverage «Documents»: 5 уникальных фото вместо 15 — повторяются по кругу в сетке 15 ячеек.
- Responsive sweep сделан по 4 базовым вьюпортам (1920/1440/840/392), не по полному списку
  из 15 ширин; KYC/Solutions/Home регрессия проверена на 3 живых страницах (200, FAQ/Integration/
  News-счётчики без изменений).

## 2026-10-17 — canonical author archive (`/author/<slug>/`)

Figma: FHD 2570:33393, Desktop 2570:31497, Tablet 1381:25698, Mobile 1381:26059. Не закоммичено.

- `author.php` переписан: главный WP_Query с реальной пагинацией (`posts_per_page` через
  `pre_get_posts` → `NV_AUTHOR_PER_PAGE=9`) вместо вторичного `paged=1` + AJAX «Show more»
  (`nv_load_more_posts` без author-фильтра — был сломан, но не удалён, может использоваться
  в другом месте). Карточки — `template-parts/blog-card.php` (reuse), не `article-card.php`
  (**архитектурное решение этой задачи**, отменяет комментарий Р-24 про «author.php остаётся
  на старой карточке»; `article-card.php` не удалён — нужен `nv_blog_search`/live-поиску блога).
- `template-parts/blog-hero.php` — hero NeuroNews вынесен из `blog-archive.php` в отдельный
  partial, переиспользуется author.php (без копирования markup/CSS); на Mobile скрыт только
  для author (`.blog-hero--author`, его нет в Mobile-макете).
- `functions.php`: `nv_author_display_name()` (общая first+last→display_name логика),
  `NV_AUTHOR_PER_PAGE`, `nv_is_light_theme()`/`body_class`/`nv_breadcrumbs()` получили ветку
  author (`nv-blog`+`nv-author` body-классы, реальное имя в крошках).
- `css/blog.css`: новый блок «AUTHOR ARCHIVE» — профиль (avatar/identity/socials/bio) и
  author-only геометрия карточки (442×296 FHD / 333.33×176 Desktop / 364×184 Tablet / 344×224
  Mobile — не category-значения), inside-stroke той же техникой, что и category. FHD: профиль
  слева 440px колонкой, контент справа с topics СПРАВА от сетки (у Desktop/Tablet/Mobile —
  сверху/слева, как у category).
- Corporate-аккаунт (`user_nicename === 'neurovision'`, по текущему реальному slug, не по ID):
  вместо `get_avatar()` — `img/author-corporate-mark.png` (официальный Figma-ассет N-mark,
  Rectangle 3922, скачан локально) на всех ширинах, не фото Ostap Bender из Mobile-макета.
  Соцсети — реальный `user_url` (общий globe-icon `nv_blog_icon('network')`) + для corporate
  дополнительно реальный LinkedIn из `footer.php` (`nv_contacts_icon('linkedin')`, общий
  helper) — пустых `href="#"` не рендерится.
- **Допущение:** FHD-макет содержит 8 placeholder-карточек с одной растянутой последней и
  пустой ячейкой перед ней — реализована регулярная сетка 2 колонок без спец-кейса по индексу.

### Чем проверено
- `php -l` всех изменённых PHP — без ошибок; `css/blog.css` баланс `{}` — 383/383.
- **Блокер окружения, не моя правка:** Yoast SEO `wpseo_titles.disable-author=true` (pre-existing)
  редиректит `/author/*/` на главную на реальном сайте — БД/настройки не менялись. Для QA шаблон
  рендерился напрямую через WP-CLI-стиль PHP-бутстрап (минуя HTTP-редирект) и показывался
  реальному Chromium через перехват запроса (`page.route`) — геометрия/скриншоты с реальным
  CSS/шрифтами/картинками, не файловый/статический мок. Решение о `disable-author` — за
  координатором/владельцем, не менялось.
- 1920/1440/840/392 (референсные): hero скрыт на Mobile для author; H1 «Popular articles by
  {name}» единственный H1; FHD грид/topics зеркалятся (areas `"main cats"`), Desktop/Tablet/
  Mobile — `"cats main"`; media 442×296/333×176/364×184/344×224 — exact match на всех четырёх;
  grid 2/3/2/1 колонки. `/author/neurovision/` (corporate, N-mark, LinkedIn+website,
  2 реальные записи) и `/author/kochetkov/` (обычный автор, реальные job/bio/avatar-аплоад,
  0 соцсетей — нет `user_url`) — оба честные, без фейковых данных.
- Regression: `/category/...` и `/?s=test` — hero без лишнего модификатора (до фикса `search`
  ошибочно получал `.blog-hero--search`, которого не было в оригинале — найдено и исправлено
  до сдачи), grid/H1/карточки не изменились. Smoke `/`, `/solutions/`, `/pricing-matrix/`,
  `/kyc/`, `/docs/`, 3 юр. страницы — 200; `/author/.../page/5/` и несуществующий автор — 404.
- **Не проверено**: живая пагинация >9 записей (у текущего автора 2 поста); `id="Vector"` на
  author.php — тот же pre-existing дубль из `nv_blog_icon()` eye/heart/clock, что и на
  `/blog/`/`/?s=`, не новый.

## 2026-10-17 — мascot-finish: выступающая лапка маскота на category hero

READY TO ACCEPT; исправлено единственное подтверждённое косметическое отклонение вместо принятия.
Не закоммичено.

- `template-parts/blog-archive.php`: текстура hero обёрнута в `<span class="blog-hero__texture-wrap">`
  (общая разметка, нейтрально для page/search).
- `css/blog.css`: `.blog-hero__texture-wrap` — `position:absolute;inset:0;overflow:hidden` берёт на
  себя обрезку текстуры; `.blog-hero--category` — `overflow:visible` (было `hidden` от общего
  `.blog-hero`), чтобы лапка маскота не обрезалась по нижней кромке hero. page/search сохраняют
  `.blog-hero{overflow:hidden}` без изменений. Геометрия hero/title/subtitle/mascot/texture не менялась.
  Стекинг не трогали — `.blog-hero{position:relative}` уже достаточно, чтобы лапка рисовалась поверх
  фона `.blog-archive` без поднятия z-index.
- `THEME_ASSETS_VER` `1.0.90` → `1.0.91`.

### Чем проверено
- `php -l`, баланс `{}` в `css/blog.css` (324/324).
- Реальный Chromium headless: `hero.overflow:"visible"` на всех 1920/1440/840/392, `wrap.overflow:
  "hidden"`; геометрия title/text/controls/mascot — без изменений (те же значения, что в доработке 3).
  Pixel-скриншоты по точным Figma-диапазонам (`/tmp/nv-mascot-finish/paw-*.png`,
  `bottom-*.png`) — лапка видна поверх фона `.blog-archive` на всех четырёх ширинах, без z-index хаков.
  `/?s=test`: `.blog-hero{overflow:hidden}` не изменился, обёртка присутствует нейтрально. Overflow
  документа — `false` на всех четырёх; smoke `/`, `/?s=test`, category — 200; `pageerrors: []`.

## 2026-10-17 — доработка 3 по review-3 (4 финальных пункта)

## 2026-10-17 — доработка 3 по review-3 (4 финальных пункта)

Независимый review-3 подтвердил: все R2 закрыты. Остаток — 4 точечных пункта. Не закоммичено.

- **R3-01:** обводка `.blog-card__media` была не видна — inset `box-shadow` на самом элементе
  рисовался ПОД `<img>` (статичный child перекрывает фон/shadow родителя). Заменено на
  `position:relative` + `::after` (`position:absolute;inset:0;border-radius:inherit;box-shadow:inset
  0 0 0 2px var(--nv-surface-3);pointer-events:none`) — позиционированный псевдоэлемент красится
  после статичных детей и ложится поверх фото, клики/hover проходят насквозь. Геометрия
  `.blog-card__media` не менялась.
- **R3-02:** Figma-кроп текстуры (`imageTransform`, тот же `imageHash` на 2570:32301/31822/33259,
  что и у Mobile 2570:32883) перенесён из `≤767.98px`-дубля в base `.blog-hero--category
  .blog-hero__texture` — действует на всех category-ширинах одной декларацией. `object-fit:cover`
  у page/search не тронут.
- **R3-03:** добавлен статичный `<br class="blog-hero__text-break">` перед «and facial recognition»
  в category-подзаголовке; `display:none` по умолчанию и на Mobile, `inline` только в существующем
  `≤1199.98px`. Общий `<br>` page/search (другая позиция, другое условие) не затронут.
- **R3-04:** `.blog-card__stat svg` — `16×16` вместо `20×20` на Mobile (узел `2570:32946`) — бейдж
  естественно получает высоту `28` без отдельного `height`. Time-иконка (уже `16/24`) и Desktop/Tablet
  не менялись.
- `THEME_ASSETS_VER` `1.0.89` → `1.0.90`.

### Чем проверено
- `php -l` — без ошибок; баланс `{}` в `css/blog.css` — 322/322.
- Реальный Chromium headless: эфемерный синий `<img>`, временно вставленный в `.blog-card__media`
  (у реальной тестовой записи нет featured-изображения) — скриншот `blue-1440.png`/`blue-392-clean.png`
  показывает чёткую серую обводку `#e4e4e4` поверх синей заливки на обеих ширинах.
- Текстура: `getComputedStyle` подтверждает одинаковый кроп (`top:-113.11%` и производные в px) на
  1920/1440/840/392; на `/?s=test` — `object-fit:cover` не изменился ни на одной из проверенных ширин.
- Подзаголовок на 840: `.blog-hero__text-break` → `display:inline`; скриншот `tablet-hero.png`
  показывает ровно три строки «Our specialist media platform dedicated» / «to anti-fraud measures,
  KYC checks» / «and facial recognition» — точное совпадение с целевым текстом из ТЗ. На 392/1440/1920
  → `display:none`; на `/?s=test` элемент `.blog-hero__text-break` отсутствует в DOM вовсе.
- `.blog-card__stat svg` на 392 — `16×16`, бейдж `h=28`; на 840/1440/1920 — `20×20`/`h=32` (без
  изменений). На `/?s=test` — `20×20` (не затронуто).
- Overflow: 13 ширин (1920…320) — без горизонтальной прокрутки, `pageerrors: []`.
- Smoke (целевой, не полный): `/`, `/?s=test`, обе категории — 200.

## 2026-10-17 — доработка 2 по независимому review-2 (геометрия карточки, пустой term)

## 2026-10-17 — доработка 2 по независимому review-2 (геометрия карточки, пустой term)

Review-2 подтвердил: блокеры раунда 1 закрыты, функциональных регрессий нет. Остаток — 14 пунктов
геометрической точности (`R2-xx`), один системный. Не закоммичено.

- **R2-01 (системный):** Figma-обводка карточки/author/stat/time/tab/search задана INSIDE и не
  занимает layout; CSS `border` при auto-размере отъедал 2px у внутренней ширины/высоты. Category-only
  замена `border:0` + `box-shadow: inset 0 0 0 Npx <цвет>` для всех шести элементов — внутренние размеры
  (media, author, табы, controls) сошлись на всех четырёх ширинах без изменения HTML-потока.
  `:focus-visible` (outline) не задет — box-shadow и outline независимы.
- **R2-02:** media-лесенка по уже существующим регионам (не новый compound-query):
  FHD `324/260`, Desktop (база) `329.333/260`, Tablet `364/292` + `padding-bottom:16` у карточки,
  Mobile `344/284` (без изменений). Полная высота карточки нигде не фиксируется.
- **R2-03/R2-04/R2-09:** Mobile — `padding-top:32`, head gap `24`, сайдбар→сетка gap `48`,
  breadcrumbs-контейнер (`.breadcrumbs`, `.breadcrumbs__nav`) тоже на `14/20` (не только `a`/`span`).
  Desktop/FHD — H1-зона `min-height:104` с `align-items:flex-end` (textAlignVertical BOTTOM), голова
  секции `152px`, сетка начинается на `y=612`; название рубрики из 1–3 строк не сдвигает структуру.
  Tablet/Mobile остаются autoheight.
- **R2-05/R2-10/R2-11/R2-12:** пустая/исключённая `hide_empty` текущая рубрика теперь добавляется в
  `$categories` в PHP и рендерится обычным пунктом списка — модификатор `.blog-cats--empty-active` и
  его CSS-исключения удалены целиком. Один разделитель, обычная типографика, `order:-1` на узких
  ширинах — без особого случая. Count текущей рубрики (H1, пилюля, её строка в списке) — один
  `$grid->found_posts`; остальные термины в сайдбаре — `term->count`.
- **R2-06/R2-07/R2-08:** маскот Desktop/FHD `287×179`, Tablet `216×135` — фиксированные стороны +
  `object-fit:cover` (ассет 374×238 не даёт точную высоту через `auto`). Слот иконки таба `24×24` на
  `≥768px` для всех трёх (document/network/play — `preserveAspectRatio` вписывает native `24×20` без
  искажения), Mobile — свои `20×20`/`24×20` как было. Карточка на Mobile — `border-radius:12`
  (было 24), включая `::after` у кликабельного заголовка.
- **R2-13:** текст hero-подзаголовка — один literal с условным `<br>` (`$context !== 'category'`)
  вместо двух копий текста.
- **R2-14:** Tablet-текстура осознанно оставлена на общем `object-fit:cover` — follow-up-2 прямо
  запретил менять это вслепую без адресных данных; зафиксировано как явный выбор, не дефект.
- `THEME_ASSETS_VER` `1.0.88` → `1.0.89`.

### Чем проверено
- `php -l` по всем изменённым PHP — без ошибок; баланс `{}` в `css/blog.css` (317/317).
- Реальный Chromium headless Playwright — геометрия/скриншоты на 1920/1440/840/392:
  media `344×284 / 364×292 / 329.33×260 / 324×260` — exact-match на всех четырёх; `head.h=152`,
  `grid.y=612` на Desktop/FHD — exact-match; controls `88/40/104/104`, search `40` на всех ширинах
  (после компенсирующего padding — см. «Найдено в процессе» ниже); табы `94.03/101.78/104.97×40` с
  иконками `24×24` на Desktop/Tablet, `20×20`+`24×20` на Mobile; `/category/pending-verification/` —
  один разделитель, активный термин первым пунктом списка, `(0)` единообразно в H1/списке.
- Regression: `/?s=test` — `.blog-card` сохраняет реальный `border:1px`, `box-shadow:none`,
  `border-radius:24px`, без иконок у табов — ни один из scoped-фиксов не протёк. Smoke 8 маршрутов —
  коды как ожидалось.
- **Найдено и исправлено в процессе:** снятие border у `.blog-search` (R2-01) просадило её
  auto-высоту на 2px именно на Mobile (`38` вместо `40`), из-за чего `.blog-archive__controls`
  откатился на `86` вместо уже подтверждённых `88`; компенсировано `padding-top/bottom:7px` для
  category на Mobile. Также изначально пропустил Tablet-регион для `.blog-card__media`/`padding-bottom`
  (R2-02) — добавлен при ретесте после того, как измерение показало `287.36` вместо `292`.

## 2026-10-16 — category-only вариант архива блога (`/category/<рубрика>/`)

Figma: Full HD `2570:33257`, Desktop `2570:31820`, Tablet `2570:32299`, Mobile `2570:32881`. Не закоммичено
(рабочее дерево уже содержало незакоммиченные правки координатора — baseline сохранён отдельно до начала
работы, см. `implementation-report` задачи в артефакте `blog-category`).

- `template-parts/blog-archive.php`: добавлен модификатор `context === 'category'` без изменения веток
  `page`/`search`. H1 — реальные имя рубрики и `wp_count_posts`-совместимый `$category->count`, без префикса
  «NeuroVision Global Systems Blog:». Сайдбар рубрик — активная рубрика первой (десктоп — отдельной строкой
  над «All topic», Tablet/Mobile — первой в общем списке через `order:-1`), не дублируется в списке ниже.
  Правая колонка «News» для category не запрашивается и не выводится (её нет ни в одном из 4 макетов).
- `css/blog.css`: новые классы `.blog-hero--category`, `.blog-archive--category`, `.blog-cats--category`,
  `.blog-cats__active`, `.blog-cats__divider`, `.blog-cats__list li.is-current` — добавлены в существующие
  брейкпоинты (base, `≥1800px`, `≤1199.98px`, `≤767.98px`, `≤575.98px`), новых breakpoint-значений нет.
  Сетка карточек у category — 4/3/2/1 колонка (FHD/Desktop/Tablet/Mobile), не 2/3 как у page/search.
  Hero Mobile для category — 548px, заголовок 52px/92px (контекст Figma, не 52px/60px общей NeuroNews-шапки),
  подзаголовок без уменьшения (24px/36px), маскот виден и центрирован (у page/search маскот на ≤575px скрыт).
  Подзаголовок hero на Tablet — `max-width: 468px` (только у category).
- Переиспользовано без изменений: `blog-card.php`, пагинация, поиск, `nv_breadcrumbs()`, sidebar-ширины
  260/400px и `--no-news` 2-колоночная раскладка (уже совпадали с Figma).
- 404 для несуществующей рубрики и пагинации за пределами — стандартное поведение `WP_Query`/template loader,
  кода не потребовалось.

### Чем проверено
- `php -l` по `template-parts/blog-archive.php`, `category.php`, `functions.php` — без ошибок; баланс `{}` в
  `css/blog.css` (264/264).
- Браузер (реальные данные REST `wp/v2/categories`): `anti-fraud-liveness-detection` (1 запись),
  `kyc-aml-and-digital-identification` (1 запись), пустая `pending-verification` (0 записей, честный empty
  state, не 404) — H1/счётчики реальные, не хардкод.
- 404: несуществующая рубрика и `.../page/5/` за пределами пагинации — оба 200→404 подтверждены через `fetch`.
- Responsive: 1920/1440/840/392 (референсные) + границы 1799/1800, 1199/1200, 767/768, 575/576, 320 — через
  вложенный `iframe` с фиксированной шириной (ресайз окна недоступен в этой браузерной сессии); сетка 4/3/2/1,
  видимость активной рубрики/пилюли, hero-параметры — везде совпали с ожиданием, без горизонтального overflow.
- Regression: `/?s=test` (search) — `.blog-archive` без `--category`, `.blog-news` на месте, H1 с префиксом —
  не задета; smoke `/`, `/kyc/`, `/pricing-matrix/` — 200. `/blog/` в этом окружении отдаёт 404 — страница
  `blog` не опубликована в WP (подтверждено через REST `wp/v2/pages?slug=blog` → `[]`), не регрессия задачи.
- **Не проверено** (ограничение сессии): пиксельный скриншот-оверлей с Figma (инструмент `screenshot` не
  вернул кадр в этой сессии — таймаут); `/docs/`, `/solutions/`, юридические страницы, `404.php` смоуком не
  пройдены; пагинация при >12 записей в одной рубрике (в БД сейчас максимум 1 запись на рубрику) — только
  проверена логика (`paginate_links`, `total`), не вживую на реальных данных.

> **Уточнение 2026-10-17 (независимый review + follow-up 1).** Строка 19 («не дублируется в списке ниже») —
> неточно: активная рубрика технически присутствует в DOM дважды, один вариант всегда `display:none`
> (решение принято, подробности — ниже в записи 2026-10-17, R-16). Строка 26 («подзаголовок без уменьшения
> (24px/36px)») была неверна по Figma mode-данным (нужно 20px/32px на Mobile — иначе 4 строки вместо 3) —
> исправлено, см. запись 2026-10-17. Строка 29 («`--no-news` раскладка уже совпадала с Figma») — ширины
> колонок совпадали, но `grid-template-areas` у Tablet/Mobile резервировала пустую строку `news`
> (+48/+32px лишнего отступа) — исправлено, см. запись 2026-10-17 (R-01).

## 2026-10-17 — доработка по независимому review (follow-up 1)

Review: `review/index.md` и уточнения `precise-figma/`, `precise-followup/` в артефакте `blog-category`.
Вердикт был FIXES REQUIRED (R-01…R-20). Не закоммичено.

- **Блокирующие (R-01…R-05), исправлено и подтверждено реальным Playwright-скриншотом:**
  пустая grid-область `news` на Tablet/Mobile убрана (`grid-template-areas: "cats" "main"` у category);
  лишний разделитель над «All topic» убран (`.blog-cats__active + .blog-cats__divider` скрывается вместе
  с пилюлей); Mobile H1 32px/44px (было 40/52); Mobile hero subtitle 20px/32px (было 24/36, давало 4 строки
  вместо 3); Tablet hero subtitle центрирован и 3 строки — добавлен `.blog-hero--category .blog-hero__content
  {display:flex; flex-direction:column; align-items:center; gap:8px}` (и `<br>` убран из category-разметки
  подзаголовка) — один и тот же фикс даёт exact y104/y204 (Desktop), y86/y186 (Tablet), y176/y276 (Mobile),
  подтверждено `getBoundingClientRect()`.
- **R-06:** пустая/исключённая `hide_empty` активная рубрика (`pending-verification`) теперь видна на всех
  ширинах через модификатор `.blog-cats--empty-active`, вычисляемый в PHP (`$current_in_list`).
- **R-07/R-08/R-15:** типографика и gap сайдбара по mode-данным — Tablet All topic 18/24 + list row-gap8/
  col-gap24; Mobile All topic 16/20 + список в колонку gap12 + боковой инсет `padding:0 8px`.
- **R-09 (разрешено координатором):** category-only компактная карточка на Mobile (`gap12, padding 8/8/12,
  media 344/284, типографика 12-14px`), заголовок до 3 строк на Desktop/FHD/Tablet (было 2, узел `2570:31874`),
  2 строки на Mobile. Desktop (1200–1799.98px) media `aspect-ratio: 329.333/260` по подтверждённому узлу;
  FHD/Tablet используют общий `366/284` — точные mode-узлы для них не читались (Figma MCP недоступен в этой
  сессии), зафиксировано как coverage gap.
- **R-10 (разрешено координатором):** иконки `document`/`network`/`play` — официальные Figma SVG-ассеты,
  скачаны локально и встроены в `nv_blog_icon()` (`currentColor`, без ID-коллизий), только у category-табов.
  Mobile — три равные колонки h36; Desktop/Tablet — natural width с иконкой 24×24 (document) / 24×20
  (network/play — собственный неквадратный native-аспект, не растягивается до квадрата).
- **R-11:** `THEME_ASSETS_VER` поднят `1.0.87` → `1.0.88` (единственная правка `functions.php`).
- **R-12:** breadcrumbs на Mobile 14px/20px (было 16/24, переносилось на 2 строки) — category-only.
- **R-13:** все line-height у новых category-правил переведены на unitless-множитель (было в px).
- **R-14:** кроп hero-текстуры на Mobile — по `imageTransform` узла `2570:32883`
  (`top:-113.11%; left:-1.4%; width:102.79%; height:350.74%; object-fit:fill`), не общий `object-fit:cover`.
- **R-17:** цвет разделителя сайдбара — `var(--nv-surface-3)` (`#e4e4e4`), было `var(--nv-surface-4)` (`#d2d2d2`).
- **R-18:** H1-счётчик теперь берёт `$grid->found_posts` (главный запрос, учитывает иерархию при её появлении),
  счётчики сайдбара остаются `term->count` (WP term semantics) — без recursive SQL.
- **R-19:** `get_category()` оборачивается в `is_wp_error()` перед использованием.
- **R-16:** `<li class="">` исправлен на условный атрибут; дублирование активной рубрики в DOM осознанно
  сохранено (`display:none` — решение разрешено review, архитектурно сложнее убрать без JS).
- **Шрифт:** `fonts/Martel/Martel-Bold.{ttf,woff2}` — официальный Google Fonts Martel Bold (SIL OFL 1.1,
  `fonts/Martel/OFL.txt`), алиас `@font-face` `'Martel Blog Category'` только в `css/blog.css`, применяется
  исключительно к `.blog-hero--category .blog-hero__title` — общий `font-family: Martel, Georgia, ...` у
  `.blog-hero__title` (page/search) и `.mega__banner-title` (`styles.css:1637`) не тронут, оба остаются на
  Georgia-фолбэке как раньше (BACKLOG).

### Чем проверено
- `php -l` по всем изменённым PHP — без ошибок; баланс `{}` в `css/blog.css` (298/298).
- Реальный Chromium headless Playwright (`~/.npm/_npx/e41f203b7505f1fb/node_modules/playwright`,
  `ignoreHTTPSErrors:true`) — `page.setViewportSize()` и `page.screenshot()` оба работают (Electron-лимит
  раунда 1 снят). Скриншоты и `getBoundingClientRect()`/`getComputedStyle()` на 1920/1440/840/392 плюс
  границы 1199/1200, 1799/1800, 767/768 — пути `/tmp/nv-category-retest/` (вне репозитория).
- Все числовые требования R-01…R-15, R-17, R-18 перепроверены измерением (не только текстом CSS) и совпали
  с ожиданием — таблица R-ID → evidence в `followup-1/report/index.md`.
- `document.fonts` подтверждает `"Martel Blog Category loaded"`; иконки табов — реальный рендер-размер
  через `getBoundingClientRect()` (24×24 document на Desktop, 20×20 на Mobile; 24×20 у network/play везде).
- Regression: `/?s=test` — `.blog-archive`/`.blog-hero` без `--category`, `.blog-news` на месте, H1 с
  префиксом, табы без иконок, grid 3×289.3 (FHD-диапазон на 1800px) — не задета. Smoke `/`, `/kyc/`,
  `/pricing-matrix/`, `/?s=test`, обе реальные рубрики, пустая рубрика, несуществующая рубрика,
  `page/5/` — коды 200/200/200/200/200/200/404/404, как ожидалось.
- **Не проверено**: FHD/Tablet precise card media geometry (Figma MCP недоступен в сессии — read-only
  доступ не настроен); живая пагинация >12 записей (данных нет); `/docs/`, `/solutions/`, юр. страницы,
  `404.php` смоуком не пройдены (не менялись, риск низкий, но формально не подтверждено).

## 2026-10-15 — светлый архив блога (`/blog/`, поиск, рубрики)

Figma: Full HD `2570:33169`, Desktop `1378:20322`, hover `2569:23708`, Tablet `2569:29963`. Отдельного Mobile-макета нет
(во втором задании указан тот же Tablet) — мобильная версия выведена из Tablet. Не закоммичено.

- Шаблоны `search.php`, `blog-page.php`, `category.php` теперь только вызывают `template-parts/blog-archive.php`
  (hero NeuroNews, заголовок, табы, поиск, категории, «последняя статья», сетка, пагинация, правая колонка/полоса).
  Новая карточка — `template-parts/blog-card.php`; `article-card.php` не тронут — он нужен `author.php` (Р-24).
- Данные реальные: сетка и пагинация — `WP_Query` (12 на страницу, `paginate_links`, `/blog/page/N/` за пределами → 404),
  «последняя статья» — самая свежая запись только на 1-й странице, правая колонка — один запрос без уже показанных записей,
  поиск — стандартный `/?s=` (только записи), категории — `get_categories`. Просмотры/лайки — мета `post_views`/`post_likes`.
- `functions.php`: `nv_is_blog_archive()` (в `nv_is_light_theme()`), body-класс `nv-blog`, `pre_get_posts` (12 в поиске и рубриках),
  `nv_blog_url()`, `nv_blog_ago()`, ветка архива в `nv_breadcrumbs()`, `template_redirect` для 404 за последней страницей.
- `inc/blog-icons.php` — inline-SVG иконки; `css/blog.css` — регион `BLOG ARCHIVE LIGHT`; `css/styles.css` — `body.nv-blog`
  добавлен в токены, `.container`, тизер и футер.
- Hero переиспользует `img/header-news-texture.webp` и `header-news-mascot.webp`; шрифт — Martel → Georgia (как баннер меню).
- Раскладка Desktop с 1200px, три колонки карточек (Full HD) с 1800px, ниже 1200 — компоновка Tablet, ≤767 — одна колонка.

 (`404.php`)

Figma: Desktop `722:20638`, Tablet `722:23852`, Mobile `722:24249`. Не закоммичено.

- `404.php`: тот же шаблон, один `h1`, CTA — `<a href="home_url('/')">` на `.btn-hero`, иллюстрация и тень — локальные `img/404-illustration.webp` (из PNG Figma 4096×2155, 2400px) и `img/404-shadow.svg`, оба `alt=""`, `aria-hidden`.
- `functions.php`: `nv_is_light_theme()` → `|| is_404()` (светлые шапка, тизер, футер).
- `css/styles.css`: `body.error404` добавлен в списки токенов `--nv-*`, `.container`, тизера и футера (клоны строк `page-template-page-docs`); блок `/* 404 */` переписан под `body.error404`; серая «Animated button» — переопределение `.btn-hero` внутри `.section-404` (круг `#FD6B01` разрастается на hover/focus-visible, только `transform`).
- Full HD макета нет: общий `.container` (потолок 1920, поля 32), текст 574 и картинка 737 не растут.
- Шапка и футер не менялись.

 (`/docs/`, `/docs/<документ>/`)

По просьбе пользователя документация перекрашена в светлый дизайн страницы записи блога (макетов Figma нет —
решение «взять стили записи», Р-145). Не закоммичено.

**Что сделано.**
- `functions.php`: `nv_is_light_theme()` знает `is_singular('document')` и `page-docs.php` — шапка, футер и тизер светлые.
- `css/styles.css`: `body.single-document` и `body.page-template-page-docs` добавлены в токены `--nv-*`, правило `.container` и в
  селекторы тизера и футера (регионы `TEASER HOME`, `FOOTER HOME`).
- `css/post.css`: все `body.single-post`-правила светлого региона продублированы под оба класса документации
  (раскладка, сайдбар-ящик, типографика, таблицы, код, кнопки сайдбара).
- `css/document-toc.css`: новый регион `DOCUMENT LIGHT` — оглавление-дерево, спойлеры, код, дочерние ссылки,
  нижняя навигация, фон body; `img/faq_arrow_dark.svg` — тёмная стрелка раскрытия.

**Проверено (Playwright):** `/docs/` и документ с таблицами, кодом, спойлерами на 1440, 840, 392 — без горизонтальной прокрутки,
ошибок консоли нет, выезжающее оглавление открывается и светлое; `/`, `/solutions/`, `/kyc/`, `/pricing-matrix/` и юр. страницы — 200.
Страницы записей блога визуально не проверялись (опубликованных записей нет): правила только дополнены, баланс скобок сохранён.

## 2026-10-15 — страница KYC (`page-kyc.php`, `/kyc/`)

Задание «NV Global — новая страница KYC». Решения и расхождения макета — `DECISIONS.md`, Р-144.
**Не закоммичено — ждёт приёмки.** Перед работой дерево разобрано на два коммита
(Header; блог и блоки) по решению пользователя.

**Новые файлы:** `page-kyc.php`, `inc/kyc-data.php` (тексты и состояния), `inc/kyc-icons.php`
(`nv_kyc_icon()`), `template-parts/{integration,faq,contacts}-section.php` (вынесены из
`page-solutions.php`, разметка не менялась — HTML /solutions/ сверен до и после, отличаются только пробелы),
`img/kyc-*` (растр WebP 1x/2x и SVG из Figma: герой ×4 кропа, процесс, шаги, риск, ноутбук FHD/Desktop,
телефон FHD/Desktop, значки сертификатов, флаги, карта мира, слои карты ЮВА, маркеры).

**Правки:** `functions.php` (`nv_is_light_theme()` + `page-kyc.php`), `page-solutions.php` (три
`get_template_part`), `css/styles.css` (в селекторы токенов, `.container`, Contacts, тизера, футера и FAQ добавлен
`body.page-template-page-kyc` — 362 строки; новый регион `KYC-PAGE` с секциями `KYC BASE/HERO/CERTS/PROCESS/
STEPS/RISK/PLATFORM/COMPLIANCE/SEA/ONBOARDING/INDUSTRIES/PRICING/ABOUT`), `js/main.js` (`initKycPage()`).
Локально создана страница WP «KYC» (ID 1209, slug `kyc`, шаблон `page-kyc.php`).

**Проверено (Playwright):** высоты секций совпадают с Figma на 1920 и 1440 (±2 px, кроме Contacts +2);
нет горизонтальной прокрутки на 1920…375; функционал 1440/768/392 — все состояния Process 1–5, Steps 1–4,
Risk 1–3 (+клавиатура), Compliance (клик, hover, focus), SEA 6 стран (+клавиатура), FAQ 11 вопросов,
дубликатов `id` нет, один `h1`, ошибок консоли нет.

## 2026-10-14 — доработка страницы записи блога и блоков

Проверка на статье `/2026/10/14/h1-from-article_final-md/` и временной записи со всеми 19 блоками
(создана и удалена, в БД не осталась; комментарии тоже). Решения — `DECISIONS.md`, Р-142, Р-143.

**Найдено и исправлено.**
- **`css/post.css`: адаптив светлой страницы записи не работал.** Строки вида
  `body.single-post @media (…) {` — невалидный CSS, весь блок правил ниже 1199.98px браузер
  отбрасывал. На 392px страница была сломана (высота ~72 000px, колонка статьи в несколько
  пикселей). Приведено к `@media (…) {` (7 мест); высота на 392px стала ~18 500px.
- **`blocks/result`:** текст «Conclusion» был светлым на светлом фоне (глобальный `p` темы —
  `#FBFBFB` 70%). Задан цвет `--nv-object-2`, размеры по Figma 2570:39198 (18/28, заголовок 24/36 Bold, зазор 16).
- **`blocks/about`, `blocks/callout`:** стрелки в кнопках были невидимы (белая на светлом,
  `#2E2E2E` на тёмном) — переведены на `currentColor`.
- **`blocks/code`:** заголовок «Код» → «Code» (сайт английский, в макете «Code»).
- **Таблицы** — по Figma (Р-143).
- **Низ страницы:** комментарии по макету (Р-142), карточка статей без битой картинки.

**Новые файлы:** `template-parts/post-comments.php`. **Правки:** `single.php`, `functions.php`
(секция «Комментарии записей блога», `get_post_author_articles_html()`), `css/post.css`,
`blocks/{result,about,callout,code}`.

**Проверено (Playwright):** статья 1440 / 840 / 392 без горизонтального скролла и ошибок консоли;
комментарии — форма, отказ сервера без согласия и при заполненной ловушке, сохранение должности,
модерация и уведомление, список после одобрения (тест на временной записи); все 19 блоков
на 1440 — читаемы, стрелки видны.

---

## 2026-10-14 — глобальная шапка (Header) по новому Figma

Задание «NV Global — полный redesign глобального Header» (правка `header.php` и стилей
шапки разрешена явно). Решение и таблица URL — `DECISIONS.md`, Р-141. **Не закоммичено.**

**Что сделано.**
- `header.php`: разметка шапки заменена целиком (`<head>` не тронут, кроме `has-js` в
  существующем inline-скрипте). Меню Products / Industries / Resources / Docs / Pricing,
  язык, CTA «Start Free Trial», мобильное меню, `aria-*`, текущий пункт.
- Новые `inc/header-menu.php` (данные, реальные и плановые URL) и `inc/header-icons.php`
  (inline-SVG из Figma); подключены в `functions.php`.
- `css/styles.css`: удалены 105 правил старой шапки (`.header*`, `.burger`, `.submenu*`,
  `.btn--header` и их копии в HOME THEME / SOLUTIONS THEME / LEGAL PAGE LIGHT / CALC PAGE, комментарии
  к ним); регион `MENU…/HEADER MENU…` заменён секцией `HEADER START/END`; `.header`
  добавлен в список селекторов токенов `--nv-*`.
- `js/main.js`: `initHeaderMenu()` переписан (один контроллер на все ширины), удалён
  закомментированный прежний вариант (~130 строк).
- Ассеты `img/header-*`: логомарка «N», 5 флагов, `header-promo-video.webp`,
  `header-news-texture.webp`, `header-news-mascot.webp` (WebP из Figma-PNG 1–19 МБ → 18–270 КБ).

**Проверено** (Playwright, Chromium): 47 функциональных проверок — все проходят (клавиатура,
hover без «мёртвой зоны», одно открытое меню, Escape/outside, язык инертен, sticky, модалка
поверх шапки, focus trap, блокировка скролла и возврат позиции, сброс при resize и повороте,
высоты 844/740/667/640, 23 ширины без горизонтального скролла и наложений, нет `href="#"`,
нет дублей ID). `php -l`, `node --check`, баланс скобок CSS — чисто. Ссылки: 32 уникальных,
15 существующих = 200, 17 плановых = 404 (ожидаемо). Скриншоты и diff с Figma — в отчёте.
Остаточные расхождения — `BACKLOG.md`, H-01…H-13.

Закрыты: A-54 (обрезка навигации 992–1024), A-55 (порядок логотипа и бургера) — прежней шапки нет.

---

## 2026-10-14 — разбор незакоммиченного дерева на коммиты

Правка организационная, код не менялся. 90 файлов из четырёх задач разложены
на пять коммитов в ветке `dev` (`push` не выполнялся):

1. `f378cb5` — Pricing Matrix: `page-price-matrix.php`, `js/calculate.js`,
   8 `img/pricing-hero-*.webp`, секция `CALC PAGE` в `css/styles.css`.
2. `97af0d0` — шим редактора (B-27): `js/admin-blocks.js`, `inc/block-helpers.php`,
   `css/editor-blocks.css`, 3 хунка `functions.php`, `block.json` у блоков.
3. `c9458d1` — страница записи и 19 блоков: `blocks/*`, `single.php`, `css/post.css`.
4. `15472fc` — формы, модалки, футер, Contacts, юридические страницы и
   `nv_is_light_theme()`: `js/form.js`, `footer.php`, `header.php`,
   `page-privacy.php`, остальной `css/styles.css`, остаток `functions.php`.
5. Документация (этот коммит).

`css/styles.css` разделён по границе секции `CALC PAGE`. Промежуточный
коммит 1 не включает светлые футер и модалки, поэтому как самостоятельный
срез он визуально неполон; полное состояние — `HEAD`.
`header.php` и `footer.php` вошли в коммит 4 как правки вне разрешённого
(`PROJECT_STATE.md`, раздел 12) — приёмка за пользователем.

---

## 2026-10-13 — поля ACF-блоков в редакторе: стили и визуальный редактор

Поля блоков выглядели как голая HTML-форма: подписи без оформления, инпуты
и вкладки «Визуально / Текст» в стилях браузера (скриншот от пользователя
на блоке `spoiler`).

**Поля сделаны через ACF, с ними всё в порядке.** Причина та же, что у прежнего
краха блоков: канва редактора WordPress 7 — отдельный iframe. Форму полей ACF
печатает внутрь неё, а свои стили (`acf-input` → `acf-global` → `dashicons`)
подключает только в родительский документ. Замер подтвердил: в iframe
0 таблиц стилей ACF при 2 в родительском документе.

**Правка 1 — стили в канву.** WordPress кладёт в iframe `editor_style_handles`
каждого зарегистрированного блока (`_wp_get_iframed_editor_assets()`). После
`register_block_type()` дописываем туда три хэндла: `acf-input` (поля ACF),
`editor-buttons` (вкладки «Визуально / Текст») и `buttons` (кнопка «Добавить
медиафайл»). Ядро само разрешает зависимости и подключает стили ссылкой,
с обычным кэшированием. Проверено: в канве 1 таблица `acf-input`, подписи
и поля оформлены штатно.

**Правка 2 — визуальный редактор.** TinyMCE инициализируется в родительском
документе и до textarea внутри iframe не дотягивается: в канве у WYSIWYG-поля
не было панели инструментов. В режиме `preview` ACF печатает поля не в канву,
а в правую панель блока — это родительский документ, и TinyMCE там работает.
Поэтому девять блоков, у которых WYSIWYG — основное поле верхнего уровня,
переведены с `auto` на `preview`: `spoiler`, `note`, `warning`, `success`,
`disclaimer`, `quote`, `result`, `about` (`callout` и `toc` были в `preview`).

Теперь у них в панели полноценный редактор с панелью инструментов, а канва
показывает живой предпросмотр блока. Проверено сквозняком: ввод заголовка
и текста через TinyMCE → сохранение → в `post_content` лежит штатная пара
`spoiler_title` / `_spoiler_title` → блок рендерится. **Формат импорта не изменился.**

Блоки с репитерами (`steps`, `tabs`, `slider`, `two-images`, `stages`, `pillar`,
`faq`, `code`, `single-image`) оставлены в `auto`: репитер в узкой панели
сжимается в нечитаемую таблицу, в канве форма шире. Проверено экспериментом
на `tabs` — вернули обратно.

**Попутно:** иконки спойлера, стрелок слайдера и ссылок-источников
(`single-image`, `two-images`, `slider`, `about`) переведены на
`fill="currentColor"` — на светлых карточках они оставались белыми.

**Файлы:** `functions.php`, `blocks/{about,disclaimer,note,quote,result,spoiler,success,warning}/block.json`,
`blocks/{spoiler,slider,single-image,two-images,about}/*.php`,
`blocks/{spoiler,slider,single-image,two-images}/*.css`.

**Проверено:** все 19 блоков вставляются без крахов, стили ACF в канве есть
у всех, TinyMCE поднимается у всех девяти `preview`-блоков; PHP lint,
валидность `block.json`, баланс скобок CSS.

---

## 2026-10-13 — страница записи блога на светлом дизайне

`single.php` переведён на светлый дизайн по макетам Figma: Full HD `2570:37654`,
Desktop `198:2964`, Tablet `236:5552`, Mobile `236:6388`.
Решения — `docs/DECISIONS.md`, Р-133…Р-138.

**Светлая тема включена** для записей блога: `nv_is_light_theme()` дополнена
`is_singular('post')` — отсюда светлые шапка, тизер и футер. Листинги блога,
архивы, документация и 404 остаются тёмными.

**`css/post.css` не переписан, а дополнен.** Файл подключается глобально,
а классы `.post`, `.post-content`, `.post-text`, `.post-sidebar`, `.breadcrumbs`
делит с `page-docs.php` и `single-document.php`. Прежние тёмные правила остались
на месте и обслуживают документацию; светлый дизайн добавлен секцией
`BLOG POST LIGHT`, каждое правило — от `body.single-post` (201 правило).

**`css/styles.css`:** светлая тема распространена на `body.single-post`
(215 селекторов), светлая форма секции Contacts — на `body.single-post .post__form`
(201 селектор). Разметка формы под статьёй совпадает с формой /solutions/,
поэтому правила переиспользованы, а не написаны заново.

**Оформление по макету:**

| Узел | Значение |
|---|---|
| Фон страницы | `#F8F8F8`, нижний блок `#F2F2F2` со скруглённым «page edge» |
| Колонки | сайдбар 436, статья до 1080, зазор 36 |
| Оглавление | карточка `#F2F2F2` / рамка `#D2D2D2` / радиус 24, пункты 14/20, активный — оранжевый с полосой слева |
| H1 статьи | 52/64, по центру; счётчики: просмотры — светлая плашка, лайки — оранжевый градиент |
| Обложка | рамка с полем 8, радиус 24, слот 1080×512, внутри радиус 16 |
| Типографика | H2 40/52 `#212121`, H3 32/48 и H4 24/36 `#FD6B01`, абзац 18/28 `#5A5A5A`, ритм 32 |
| Таблицы | шапка `#FFF0E6` с оранжевой рамкой, строки `#F2F2F2` |
| Автор и статьи | карточки `#F8F8F8` с рамкой `#D2D2D2` на `#F2F2F2` |

**Блоки записи переведены в светлую палитру** (19 блоков, 38 файлов CSS):
врезки `warning` / `success` / `disclaimer` / `note`, `callout` (белый бейдж NV,
тёмная кнопка), `about` (карточка с оранжевой полосой слева), `spoiler`, `quote`,
`code`, `tabs` (панель `#E4E4E4`, активная вкладка — оранжевый градиент),
`faq` (серый пузырь вопроса, оранжевый — ответа), `steps`, `stages`, `pillar`,
`single-image`, `two-images`, `slider`, `toc`, `result`.

**Попутно исправлено:**
- `single.php` — убран отладочный `echo` URL автора, печатавшийся текстом в страницу;
- `single.php` — рамка обложки не выводится, если у вложения нет размеров `blog_1x`;
- `blocks/toc/toc.css` — `line-height: 140%ж` (кириллическая «ж» вместо `;`)
  и синие по умолчанию ссылки оглавления;
- абзацы статьи ограничены `.post-text > p`, иначе врезки теряли свой цвет.

**Формат импорта не менялся:** имена блоков, поля, `field_`-ключи и `attrs.data`
прежние — `docs/BLOG-IMPORT-GUIDE.md` остаётся актуальным.

**Файлы:** `single.php`, `css/post.css`, `css/styles.css`, `functions.php`,
`blocks/*/*.css` (33 файла), `blocks/callout/callout.php`, `blocks/note/note.php`,
`blocks/tabs/tabs.php`.

**Проверено:** 21 ширина от 1920 до 320 — горизонтального переполнения нет,
0 ошибок консоли, 0 ответов 4xx; PHP lint, `node --check`, баланс скобок CSS;
документация (`/docs/`) осталась тёмной и не изменилась; Home / Solutions /
Pricing / Terms / Privacy / InfoSec / 404 и архив автора — без изменений;
вставка всех 19 блоков в редакторе — без ошибок.

**Не сделано:** форма комментариев и список комментариев из макета `2570:39540`
(Р-136) — это смена функциональности, а не оформления.

---

## 2026-10-13 — Gutenberg-блоки блога: починка редактора

Блоки записей блога (`blocks/`, 19 ACF-блоков) чинились в админке: часть падала
с «Этот блок содержит ошибку и не может быть просмотрен», часть вставлялась
с нулевой высотой — блок нельзя было ни выделить, ни заполнить.

**Причина краха — несовместимость ACF Pro 6.3.11 с WordPress 7.1.3.**
С WordPress 6 канва блочного редактора вынесена в `<iframe name="editor-canvas">`.
ACF инициализирует quicktags для WYSIWYG-полей в верхнем документе, там textarea
поля нет, ядро возвращает «пустой» объект без `settings`, проверка ACF
`if (!instance) return` его не ловит, и следом `settings.buttons` читается
у `undefined`. Падали все блоки с WYSIWYG: `warning`, `success`, `note`,
`quote`, `spoiler`, `disclaimer`, `result`, `about`.

Правка — шим в теме (`js/admin-blocks.js`): `quicktags()` возвращает `false`,
если textarea не найдена в этом документе. ACF обрабатывает `false` штатно
и просто пропускает панель быстрых тегов; визуальный редактор и вкладка «Текст»
работают. Скрипт подключён на `enqueue_block_editor_assets` с зависимостью
от `quicktags` — без неё ядро перезаписывало функцию уже после шима.
Снять после обновления ACF (`docs/BACKLOG.md`, B-27).

**Пустые блоки получили заглушку.** Шаблоны выходят через `return`, когда поля
не заполнены; в редакторе это давало нулевую высоту. Добавлен общий помощник
`nv_block_placeholder()` (`inc/block-helpers.php`) — видимая карточка с названием
блока и подсказкой, только в режиме предпросмотра. На сайт заглушка не попадает
(проверено: 0 вхождений в `the_content()`). Оформление — `css/editor-blocks.css`,
подключён через `add_editor_style()`: стили из `enqueue_block_editor_assets`
в iframe-канву не попадают, туда едут только editor styles темы и `editorStyle`
из `block.json`.

**Закрыты две битые ссылки на ассеты:**
- `img/logo_nv.svg` в `about` — файла в теме нет. В макете `2570:39198` у врезки
  иконки и не должно быть (карточка с оранжевой полосой слева), `<img>` убран;
- `img/author_question.jpg` в `faq` — файла нет, отдельного поля под автора
  вопроса у блока тоже нет. Переведено на `get_avatar()`.

**Мелочи:** в `about/block.json` в `example` лежали поля блока `note`
(`text_content`, `ssylka_na_istochnik`) — заменены на собственные; в `about.php`
класс иконки `about-block-icon` не совпадал с `.about-block__icon` в CSS;
иконки врезок `warning`/`success`/`disclaimer`/`note` переведены на
`fill="currentColor"`, цвет задан в CSS блока (вид не изменился).

**Формат импорта не менялся.** Имена блоков, ключи полей, `field_`-ключи
и структура `attrs.data` те же — `docs/BLOG-IMPORT-GUIDE.md` остаётся актуальным.

**Файлы:** `js/admin-blocks.js` (новый), `css/editor-blocks.css` (новый),
`inc/block-helpers.php` (новый), `functions.php`, 15 шаблонов в `blocks/`,
`blocks/about/block.json`, CSS четырёх врезок.

**Проверено:** вставка всех 19 блоков в редакторе через `wp.data` — 0 крахов,
0 блоков с нулевой высотой, 0 ответов 4xx; PHP lint всех шаблонов и `block.json`,
`node --check`, баланс скобок CSS; Home / Solutions / Pricing / Terms / Privacy /
InfoSec / Docs / 404 — без изменений.

**Не сделано:** редизайн блоков по макетам Figma. Выяснилось, что страница записи
(`single.php`, `css/post.css`) пока тёмная (`background: #212121`), а макеты
`2570:37654` / `198:2964` / `236:5552` / `236:6388` — светлые. Перекрашивать
блоки по одному нельзя: нужен перевод всей страницы записи на светлую тему
вместе с шапкой, крошками, сайдбаром-оглавлением и типографикой статьи.
Снятые спецификации врезок — в `docs/BACKLOG.md`, B-28.

---

## 2026-10-13 — Pricing Matrix на светлом дизайне

Страница `/pricing-matrix/` (шаблон `page-price-matrix.php`) переведена на светлый
дизайн по макетам Figma: Desktop `1680:26979`, Tablet `1687:15573` (калькулятор),
Mobile `1687:24170`. Решения — `docs/DECISIONS.md`, Р-127…Р-132.

**Логика калькулятора не менялась.** Формулы, цены, коэффициенты, скидки,
округление, минимумы/максимумы, значения по умолчанию, состав и порядок услуг,
названия пакетов, `id` и `data-`атрибуты, ACF-поля — без изменений.
Регресс 18 сценариев до и после: совпадение 1:1 (`docs/QA.md`).

**Первый экран переделан.** Вместо блока `intro` используется общий блок `main`
с модификатором `main--pricing` — та же карточка-фотография, что на /solutions/
(Р-128). Новая иллюстрация выгружена из макета (`2547:23070` / `2547:23264`)
четырьмя кропами: `img/pricing-hero-{fhd,desktop,tablet,mobile}.webp` + `@2x`.
Состав первого экрана: логотип, хлебные крошки, H1 52/64, две кнопки.

**Калькулятор — только оформление.** Карточки на обводке Stroke 2 с радиусом 24,
заголовки блоков H4 оранжевым, панель вкладок на Island/2 level с активной
вкладкой-градиентом, поле объёма 220×40, дорожка 8 с бегунком 16 и подписью над
ним, карточка итога на Island/1 level, оранжевая плашка годовой стоимости.
На планшете плашка разворачивается в строку, кнопка «Get Package» уезжает внутрь
неё (`display: contents` + сетка, как на первом экране Solutions).

**Таблица пакетов.** Четыре колонки по 332 с зазором 16: подписи, DOCUMENT
(прозрачная с обводкой), BASIC (Island/1 level), ADVANCED (оранжевый градиент).
Галочки и крестики переведены с фоновых картинок на inline-SVG с `currentColor`.

**Закрыт 404 `img/info.svg`** (Р-7 → Р-129): иконка подсказки переведена на тот же
inline-SVG, что уже стоит у подсказки калькулятора. В консоли страницы 0 ошибок
(было 18 — один 404 на каждую загрузку в регресс-прогоне).

**Файлы:**
- `page-price-matrix.php` — первый экран, inline-иконки таблицы и подсказок,
  `aria-pressed` / `role="group"` / `aria-label` у контролов калькулятора;
- `css/styles.css` — секция `CALC PAGE` переписана (HERO / CALCULATOR / PACKAGES /
  OVERVIEW); шаблон добавлен в список светлых контекстов (токены, `.container`,
  `.btn--header`, `.btn-hero`, `teaser`, `footer-home`, светлая шапка Solutions);
- `functions.php` — `nv_is_light_theme()` + `is_page_template('page-price-matrix.php')`;
- `js/calculate.js` — `setButtonPressed()`: класс `active` и `aria-pressed` ставятся
  вместе. Расчётных веток не касались;
- `img/pricing-hero-*.webp` — 8 новых файлов (4 кропа × 1x/2x).

**Проверено:** PHP lint всех шаблонов, `node --check` всех скриптов, баланс скобок
CSS, 21 ширина от 1920 до 320 (горизонтального переполнения нет, 0 ошибок консоли,
0 ответов 4xx), регресс расчётов 18/18, модалки `callForm` и `callForm2`,
Home / Solutions / Terms / Privacy / InfoSec / Docs / 404 — без изменений.

---

## 2026-10-12 — юридические страницы на светлом шаблоне

Terms of Use, Privacy Policy и Information Security Policy Statement
переведены на светлый дизайн. Все три сидят на одном шаблоне
`page-privacy.php` — отдельных шаблонов и копий CSS не заводили.

**Контент не менялся.** Вывод по-прежнему идёт из `the_content()`,
заголовок — из `the_title()`. Сверка DOM с `post_content` в БД:
совпадают число и состав тегов (`p`, `h2`, `h3`, `ul`, `li`, `strong`,
`a`, `table`, `tr`, `td`, `figure`) и текст — вплоть до штатной
замены дефиса на тире фильтром `wptexturize`.

**Светлая тема.** `nv_is_light_theme()` дополнена проверкой
`is_page_template('page-privacy.php')` (Р-122) — отсюда светлые шапка,
тизер и футер. Светлые правила `teaser` и `footer-home` получили третий
контекст `body.page-template-page-privacy` (Р-123), шапка написана
отдельно: на юридических страницах логотип виден всегда (Р-126).

**Оформление по макету** (Article page `751:13876`, фрейм 1440):

| Параметр | Значение |
|---|---|
| фон страницы | `--nv-surface-1` |
| контент сверху / снизу | 140 / 64 |
| колонка | 900 в полях 32 |
| H1 | 52/64, `--nv-object-1`, по центру |
| плашка даты | `--nv-surface-2`, рамка `--nv-surface-4`, радиус 8 |
| абзац | 18/28, `--nv-object-2`, отступ 20 |
| вводный абзац (`strong`) | Medium 500, `--nv-object-1` |
| H2 (раздел) | 24/36, `--nv-primary`, сверху 32 / снизу 28 |
| H3 (подраздел) | 20/28, `--nv-object-1`, сверху 28 / снизу 16 |
| ячейка таблицы | 16/20, рамка 2 пунктиром `--nv-surface-4`, радиус 12 |
| колонки таблицы | 1:2, зазор 8 |

Таблицы переведены с флекса на табличную раскладку (Р-124): пропорция
макета стала точной, ширина считается от контейнера, роли строк и ячеек
сохранились. Списки, `ol`, `h4`, `hr`, `blockquote` оформлены на запас —
в текущем контенте из них встречается только `ul`.

Ссылки подчёркнуты постоянно (Р-125): контраст оранжевого на светлом
фоне — 2.72:1, одного цвета для юридического текста мало.

Ниже 1440 макета нет — вертикаль и типографика ужаты по логике темы,
адаптив шапки и меню не трогали.

### Проверено

- 15 ширин (1920…320) на всех трёх страницах: горизонтального переполнения
  страницы нет, консоль чистая, 4xx нет, дублей `id` нет.
- Геометрия 1920 / 1440 / 840 / 392 — сверена с макетом.
- Регрессия шапки и подвала: главная, `/solutions/` и три юридические —
  светлые; `/pricing-matrix/`, `/docs/`, `/blog/`, 404 — остались тёмными.
- Контраст: H1 и H3 — 15.16, абзац и таблица — 6.49, плашка — 14.38,
  H2 и ссылки — 2.72 (цвет макета, см. «Остаются»).
- Один `H1` на странице, порядок заголовков H1 → H2 → H3 без пропусков,
  фокус на ссылке — видимая рамка 2px.

### Остаются

- `--nv-primary` на `--nv-surface-1` даёт 2.72:1 — ниже порога WCAG AA
  и для H2 (24/700, нужно 3:1), и для ссылок (нужно 4.5:1). Пара взята
  из макета и уже используется на светлых главной и `/solutions/`;
  решение по ней — за пределами задачи.
- На 992–1024 десктопная навигация не умещается и обрезается справа.
  Поведение темы, одинаковое на всех страницах с видимым логотипом
  (воспроизводится на `/pricing-matrix/`), не регрессия.
- На бургер-ширинах логотип стоит справа, бургер слева
  (`flex-direction: row-reverse` блока MENU). Так было на этих страницах
  и раньше; на `/solutions/` порядок обратный.
- У одной таблицы Terms of Use на 320 остаётся прокрутка **внутри**
  `.wp-block-table` (~32px) из-за неразрывного URL в ячейке.
  Страница при этом не прокручивается.

### Файлы

`functions.php`, `header.php`, `page-privacy.php`, `css/styles.css`.

---

## 2026-10-12 — белая стрелка в кнопке шапки

Стрелка в кнопке «Inquire» оставалась чёрной на светлых страницах,
хотя подпись кнопки белая.

**Причина.** Анимацию рисует lottie из `arrow_right_black.json`, и цвет
там задан атрибутом `stroke="rgb(0,0,0)"` на самих путях; заливки у них
нет (`fill-opacity="0"`). Прежнее правило красило только `fill`.

**Решение.** Цвет ведётся через `currentColor` кнопки: он красит и пути
lottie, и запасную inline-иконку до инициализации анимации (Р-121).
Разметка шапки не менялась, второй ассет не понадобился.

Область — только светлые страницы. Проверено:

| Страница | Подпись | Стрелка |
|---|---|---|
| главная, `/solutions/` | `#F8F8F8` | **`#F8F8F8`** |
| `/pricing-matrix/`, `/docs/`, `/blog/`, 404 | `#2B323B` | `#000` без изменений |

Цвет держится и при наведении, пока проигрывается анимация. Кнопка
видна от 992 и выше; ниже её заменяет мобильное меню. Остальные
lottie-стрелки на страницах не затронуты.

### Файлы

`css/styles.css`.

---

## 2026-10-12 — Solutions, Why: стопка карточек и фотография под ними

Две правки по макету `2456:16527` после замечаний заказчика.

### Карточки

У каждой карточки в макете `margin-right: -400` — следующая уходит под
неё целиком, поэтому слева у полосок скруглений не видно. В вёрстке
нахлёст был 24, ровно радиус, и на каждом стыке читалась выемка.
`--swhy-tuck` переведён с 24 на 400 (Р-119).

Ширины не изменились: ширина карточки считается как «видимая часть
плюс нахлёст», положение содержимого от нахлёста не зависит.

| | было | стало | макет |
|---|---|---|---|
| позиции карточек на 1920 | 1 / 493 / 609 / 725 | 1 / 117 / 233 / 349 | 0 / 116 / 232 / 348 |
| ширина карточки | 516 / 140 / 140 / 140 | 516 / 516 / 516 / 516 | 516 у всех |
| видимые полоски | 516 / 116 / 116 / 116 | 516 / 116 / 116 / 116 | то же |

### Фотография

В макете снимок — фон всего блока, карточки лежат поверх. У нас это была
отдельная колонка встык, поэтому скруглённый правый угол последней
карточки открывал подложку доски, а слева у снимка был прямой обрыв.
Блок карточек получил `margin-right: -112`, как `2456:16532` (Р-120).

На 1600+ поле под снимок выросло с 992 до 1102, и ассет отрисовывается
примерно на 11% крупнее — вынесено в BACKLOG A-52.

### Чем проверено

- высота секции не изменилась: 904 на 1920 и 1440, 956 на 1200 и 992,
  1302 на 840, 1202 на 392;
- переключение карточек работает, после клика по третьей видимые полоски
  116 / 116 / 516 / 116, JS-ошибок нет;
- планшетная и мобильная раскладки не затронуты — там доска колонкой,
  нахлёст и смещение фотографии сняты;
- 15 ширин: горизонтальной прокрутки нет, в списке вылезающих элементов
  только слайдер Industries и его иллюстрация, карточек Why там нет;
- регрессия: главная и остальные страницы — 0 расхождений.

### Файлы

`css/styles.css`.

---

## 2026-10-12 — светлый редизайн всплывающих форм

Четыре модалки переведены на светлый дизайн: большая `#callForm`, малая
`#callForm2`, окно успеха `#thanks`, окно ошибки `#error`. Backend, AJAX,
hCaptcha, имена полей и `data-form-id` не трогались.

### Макеты

Большая 712:18528 / 722:22947 / 722:23483, малая 712:18887 / 722:23196 /
722:23516, состояния 713:19244, список стран 722:19927, список услуг
722:20943, заполненные поля 722:21130, ошибки 731:25443, успех 869:12476,
ошибка отправки 870:12694. Подложку страницы из макетов не верстали.

### Что сделано

- правила светлой формы в регионе `CONTACTS` получили третий контекст
  `.modal` — 97 селекторов, без дублирования и без новых файлов (Р-114);
- токены `--nv-*` объявлены на `.modal--form` и `.modal--result`, чтобы
  модалки выглядели одинаково на тёмных шаблонах (Р-113);
- модификаторы `--large` / `--compact` / `--result`; окно отзывов
  `#review` модификаторов не получает и остаётся тёмным (Р-115);
- габариты окон, поля, разделители, высота текстового поля и кнопка —
  по макетам, включая планшет и мобильную;
- светлые списки стран и услуг внутри модалок (Р-117);
- окна результата: светлая карточка, оранжевый заголовок, маскот выходит
  за край на десктопе и уходит под текст на мобильной (Р-116);
- все значки модалок переведены на `currentColor` — 31 жёстко заданная
  заливка `#F9AA66` / `#FBFBFB` / `#2B323B` убрана.

### Доступность

- у каждой модалки свой заголовок и свой `aria-labelledby`: было
  `callForm-title` на обеих формах и `thanks-title` на обоих результатах;
- настоящая кнопка закрытия с `aria-label="Close"` и `data-micromodal-close`
  во всех четырёх окнах (в макетах её нет, Р-115);
- 13 полей получили `aria-label`;
- `aria-invalid` и `aria-describedby` на полях с ошибкой, `role="alert"`
  у текста ошибки, снятие при исправлении;
- клавиатура у обоих списков: стрелки, Home/End, Escape, возврат фокуса,
  `aria-expanded`, `aria-selected` (A-45);
- обводка фокуса из палитры вместо системной синей у строк списка,
  кнопки поиска, кнопки селекта и галочки согласия;
- декоративный значок поиска стран — `aria-hidden` и `focusable="false"`;
- окно результата открывается в следующем кадре, иначе MicroModal уводил
  фокус из диалога (Р-118).

### Чем проверено

- `php -l`, `node --check`, баланс скобок CSS — чисто;
- 15 ширин (1920…320): все четыре окна и оба списка помещаются,
  горизонтальной прокрутки страницы нет, JS-ошибок нет;
- геометрия против макетов: большая 901x712 и малая 640x676 на десктопе
  совпадают поэлементно, малая на мобильной 360x644 — точно;
- фокус-ловушка (25 Tab внутри), Escape, возврат фокуса на триггер;
- валидация пошагово, 0 запросов к `admin-ajax.php` без капчи;
- успех и ошибка проверены подменой ответа `admin-ajax` в тестовой
  вкладке: при успехе форма закрывается, открывается `#thanks`, поля
  очищены; при ошибке открывается `#error`, введённое сохранено;
- регрессия: главная и `pricing-matrix`, `docs`, `privacy-policy`,
  `blog`, 404, `solutions` × 4 ширины — **0 расхождений**; отличия только
  в снимках самих модалок.

### Файлы

`footer.php`, `css/styles.css`, `js/form.js`.

---

## 2026-10-12 — Solutions: FAQ, тексты заказчика

Пять вопросов с ответами, переданных заказчиком, заменили набор из макета
целиком. Присланный HTML не переносился: он повторяет разметку тёмного FAQ
главной, а на Solutions своя — со своим `aria` и общим `initFaq()`.

### Что изменено

- `$nv_solutions_faq` — новые пять вопросов; `answer` теперь **массив
  абзацев** вместо строки;
- цикл вывода печатает каждый абзац отдельным `<p>` через `esc_html`,
  пустые отбрасываются `nv_has_content`;
- ветка «вопрос без ответа» (`faq__item--static`) сохранена, но больше
  не задействована — раскрываются все пять.

CSS и JS не трогали: `.faq__item-answer-text` и так flex-колонка
с `gap: 12px` и `p { margin: 0 }`.

### Текст

Выведен дословно. Единственное вмешательство — типографика под остальную
страницу: прямые апострофы → `’`, кавычки вокруг «Know Your Customer» →
`“ ”`, тире → `—`.

**Требует решения:** в ответе про документы стоит «more than 200 countries
and territories», тогда как в первом экране и в карточке Why — «195+
countries and territories». Цифру не меняли, вынесено в BACKLOG A-47.

### Высота секции

| Ширина | Было | Стало | Макет |
|---:|---:|---:|---:|
| 1920 | 709 | 916 | 708 |
| 1440 | 737 | 1000 | 736 |
| 840 | 1085 | 1348 | 1084 |
| 392 | 940 | 1480 | 948 |

Рост ожидаемый: в макете ответ-плейсхолдер в три строки, у заказчика —
два абзаца. Высота FAQ с макетом больше не сверяется (Р-111).

### Чем проверено

- `php -l` по `page-solutions.php` — чисто.
- Раскрытие: 5 кнопок, 0 `faq__item--static`, 5 панелей `role="region"`
  с `aria-labelledby`, 0 битых `aria-controls`, дублей `id` нет, обводка
  фокуса 2px. Клик, Enter и Space переключают все пять на всех ширинах;
  при раскрытии текст не обрезается ни на одной из четырёх.
- 15 ширин (1920…320): горизонтальной прокрутки нет, обрезанного текста
  нет, 13/13 изображений, JS-ошибок и 4xx нет.
- Регрессия: главная, модалки, `pricing-matrix`, `docs`, `privacy-policy`,
  `blog`, 404 — расхождений нет; изменения только в `/solutions/`.

### Файлы

`page-solutions.php`.

---

## 2026-10-10 — Solutions: overlay с Figma, три правки по геометрии и фокус формы

Проход поверх финального аудита: восстановлен доступ к Figma, выполнен
настоящий overlay и закрыты A-42, A-43, A-44.

### Overlay

Figma Desktop был запущен, но без открытого документа — MCP отвечал
`No Figma window open`. После открытия файла NV-Global всё заработало.
Сняты посекционные рендеры четырёх фреймов — Full HD `2456:16495`,
Desktop `499:6129`, Tablet `2457:17206`, Mobile `2467:17893` — и собраны
32 пары «макет / сайт»: side-by-side, 50% наложение и difference.

### Правки кода

| Что | Где | Почему |
|---|---|---|
| Типографика плиток Security на ступень ниже с 1599.98 | `css/styles.css`, блок `@media (max-width: 1599.98px)` | в макете Desktop заголовок H5 20/28 и текст 16/24; ступень срабатывала только с 991.98, из-за чего на 1440 плитка росла до 240 вместо 212 (Р-107) |
| Бейдж `.industries` на мобильной — 14/20 | `css/styles.css`, блок `@media (max-width: 767.98px)` | единственная секция без мобильного правила: бейдж оставался 32 вместо 24 и сдвигал заголовок (Р-108) |
| Внешнее поле секции Products на мобильной остаётся 64 | `css/styles.css`, блок `@media (max-width: 767.98px)` | в макете «Page edge» на всех ширинах 64, мельче становится только поле внутри панели (Р-109) |
| Индикация фокуса полей формы | `css/styles.css`, тёмная база и светлая тема | общее `:has(.input-form:focus)` проигрывало по специфичности, а у `textarea` нет класса `.input-form`; добавлен `:focus-within` (Р-110, A-42) |
| `aria-hidden="true" focusable="false"` значку поиска стран | `template-parts/contacts-form.php` | декоративный SVG внутри кнопки с `aria-label="Search"` (A-43) |

### Результат по геометрии

| Секция | 1920 Δ | 1440 Δ | 840 Δ | 392 Δ |
|---|---:|---:|---:|---:|
| Первый экран | +10 | +10 | +8 | 0 |
| Why | 0 | 0 | −34 | +70 |
| Industries | −1 | −29 | −2 | −48 |
| Products | +2 | −6 | +34 | −34 |
| Integration | +15 | −1 | +35 | +17 |
| Security | 0 | **0** | 0 | −21 |
| FAQ | +1 | +1 | +1 | −8 |
| Contacts | −1 | +1 | +1 | +24 |

Security на 1440 сошёлся в ноль: бейдж, заголовок, координаты и размеры
всех четырёх плиток совпадают с макетом. Products на 392 улучшен
с −98 до −34. Industries на 392 стал −48 вместо −40 — бейдж теперь
правильной высоты, остаток целиком приходится на пустой резерв в макете.

### Чем проверено

- `php -l` по шести затронутым и смежным шаблонам, `node --check` по
  `js/main.js` и `js/form.js`, баланс фигурных скобок CSS — 0.
- 15 ширин (1920…320): горизонтальной прокрутки нет, обрезанного текста
  нет, дублей `id` нет, битых `aria-controls` нет, один H1, скачков
  уровней заголовков нет, 13/13 изображений, порядок секций верный,
  JS-ошибок и 4xx нет. Вынос `.main__fact` и `.industries__illustration`
  за правый край — намеренный, как в макете.
- Интерактив на 1440/840/392: Why, 6 вкладок Industries с шестью
  уникальными иллюстрациями и неизменной высотой секции, 3 слайда
  Integration, FAQ кликом, Enter и Space.
- Форма пошагово: пустая → имя, e-mail, согласие; короткое имя →
  «Please enter a valid name»; `not-an-email` → «Please enter a valid
  e-mail»; без галочки → «Please accept the privacy policy»; всё валидно
  → **0 запросов к `admin-ajax.php`**, токен hCaptcha пуст, отправки нет.
  Список стран открывается, `aria-expanded` синхронен, 235 стран.
  Селекта на Solutions нет, на главной он есть и открывается.
- Фокус: главная и `/solutions/` на 1920/1440/840/392, модалки
  `#callForm` и `#callForm2` — рамка меняется у всех полей, габариты
  и скругление прежние.
- Регрессия: снимки «до» и «после» по главной (1920/1440/840/375),
  модалкам и пяти страницам (`pricing-matrix`, `docs`, `privacy-policy`,
  `blog`, 404).

### Файлы

`css/styles.css`, `template-parts/contacts-form.php`.

---

## 2026-10-10 — документация: финальный визуальный аудит Solutions

Проход по готовой странице целиком. **Кода не меняли ни строки** — P0-дефектов
нет, все крупные расхождения высот упираются в правила, заданные в самом
задании на аудит (DECISIONS.md, Р-105).

### Что проверено

| Проверка | Результат |
|---|---|
| P0 на 15 ширинах (1920…320) | горизонтальной прокрутки нет, обрезанного текста нет, дублей `id` нет, `aria-controls`/`aria-labelledby` разрешаются, один H1, скачков уровней заголовков нет, все 13 изображений грузятся, порядок секций верный, JS-ошибок и 4xx нет |
| Why | 4 карточки, на десктопе открыта одна, ширины меняются 516/140/140/140 → 116/140/540/140, высота секции 904 не меняется; ArrowRight и End переключают; на ≤991.98 все четыре раскрыты, `tabindex="-1"`, стрелки выключены |
| Industries | 6 вкладок, вкладка = слайд = иллюстрация всегда, 6 уникальных иллюстраций, высота секции одна на всех вкладках, Previous выключен на первой, Next на шестой, Home/End/ArrowLeft работают, после resize выбор сохраняется и клик работает |
| Integration | 3 слайда вперёд и назад, высота секции одна на всех слайдах, Previous выключен на первом, Next на третьем |
| FAQ | открытие и закрытие кликом, Enter и Space, `aria-expanded` синхронен |
| Contacts | пустая и невалидная отправка дают ошибки, 0 запросов к `admin-ajax.php`, 235 стран, `aria-expanded` у списка стран |
| Доступность | 6 `aria-expanded`, 13 `aria-controls` — битых нет; вкладки с `aria-selected`/`tabindex`; 11 декоративных изображений с `alt=""`; обводка фокуса видна у всех интерактивных элементов, кроме полей формы (A-42) |
| Регрессия | главная × 4 ширины — 0; модальные формы — 0; pricing, docs, privacy, blog, 404 — 0 |

### Карта секций и расхождения

| Секция | 1920 Δ | 1440 Δ | 840 Δ | 392 Δ | Статус |
|---|---:|---:|---:|---:|---|
| Первый экран | +10 | +10 | — | — | принято: высота общей шапки |
| Why | 0 | 0 | −34 | +70 | в пределах переноса строк |
| Industries | −1 | −29 | −2 | −40 | принято: в макете фиксированный резерв |
| Products | +2 | −6 | +34 | −98 | принято: поля секции и перенос строк |
| Integration | +15 | −1 | +35 | +17 | принято: высота по третьему слайду |
| Security | 0 | +28 | 0 | −21 | принято: высота от содержимого |
| FAQ | +1 | +1 | +1 | −8 | совпадает |
| Contacts | −1 | +1 | +1 | +24 | совпадает |

Шапка и подвал в таблицу не входят: это общие компоненты главной.

> Цифры этого прохода уточнены в следующем проходе с overlay (запись выше):
> Security на 1440, Products и Industries на 392 изменились после правок.

> Цифры этого прохода уточнены в следующем проходе с overlay (запись выше):
> Security на 1440, Products и Industries на 392 изменились после правок.

### Полные скриншоты

Сняты `/solutions/` целиком на 1920 / 1440 / 840 / 392 — для следующего
прохода. Просмотрены: структура, порядок, ассеты и переносы строк в порядке,
обрезок и наложений нет.

### Ограничение прохода

Figma MCP отключился в середине этапа, поэтому сверка велась по числам,
снятым при реализации групп, и по живому сайту. Для 840 и 392 остаток
расхождений зафиксирован гипотезами в BACKLOG A-44.

> Снято в следующем проходе: доступ к Figma восстановлен, overlay выполнен,
> A-44 закрыт.


### Файлы

Только документация: CHANGELOG, DECISIONS (Р-104…Р-106), BACKLOG (A-42…A-44),
QA, COMPONENTS, PROJECT_STATE.

---

## 2026-10-10 — редизайн Solutions, группа 9: светлые тизер и подвал

Нижняя часть `/solutions/` переведена на светлый макет. Новых шаблонов
и CSS-файлов не заводили: подключены те же `template-parts/teaser.php`
и `template-parts/footer-home.php`, что на главной.

### Что сделано

| Что | Как |
|---|---|
| Условие светлой темы | хелпер `nv_is_light_theme()` в `functions.php`, читают `footer.php` и `teaser.php` |
| Тизер | тот же шаблон, светлый логотип `teaser_logo_primary.svg` |
| Подвал | `template-parts/footer-home.php` без изменений |
| CSS | регионы `TEASER HOME` и `FOOTER HOME`: каждый селектор теперь перечисляет `body.home` и `body.page-template-page-solutions` |
| Сетка | правило `body.home .container` распространено на `/solutions/` — тизер и подвал выводятся вне шаблона страницы |
| Отличия Solutions | **нет**: подвал и тизер главной — единственный source of truth (DECISIONS.md, Р-101) |

Разметку модалок, их валидацию, телефонный селектор, капчу, аналитику
и хуки не трогали.

### Геометрия нижней части

Тизер и подвал на `/solutions/` совпадают с главной **до пикселя** на всех
четырёх ширинах — сверены 13 элементов (логотипы, заголовок, подзаголовок,
реквизиты, значки, навигация, правая колонка, разделитель, нижняя строка,
а также раскладка колонки продуктов, кегль ссылок, высота значков):

| Вьюпорт | Тизер | Подвал | Расхождений с главной |
|---|---:|---:|---:|
| 1920 | 416 | 428 | 0 |
| 1440 | 468 | 528 | 0 |
| 840 | 532 | 768 | 0 |
| 392 | 465 | 1390 | 0 |

С Figma-инстансом подвала на странице Solutions (`2456:16730`, 975px) они
намеренно не сверяются: это более ранняя версия компонента, чем принятая
на главной (`2380:23846`, 843px). Принятое отклонение, Р-101.

### Высота всей страницы

| Вьюпорт | Сайт | Figma | Δ |
|---|---:|---:|---:|
| 1920 | 6516 | 6622 | −106 |
| 1440 | 7074 | 7050 | +24 |
| 840 | 9708 | 9646 | +62 |
| 392 | 10760 | 10736 | +24 |

Дельта на 1920 целиком приходится на подвал: принятый подвал главной на
132px ниже устаревшего инстанса в макете Solutions. Содержательные секции
от этого не зависят.

Локализация дельты по секциям (1920 / 1440):

| Секция | 1920 сайт | Figma | Δ | 1440 сайт | Figma | Δ |
|---|---:|---:|---:|---:|---:|---:|
| Шапка + первый экран | 870 | 860 | +10 | 870 | 860 | +10 |
| Why | 904 | 904 | 0 | 904 | 904 | 0 |
| Industries | 556 | 557 | −1 | 564 | 593 | −29 |
| Products | 918 | 916 | +2 | 1014 | 1020 | −6 |
| Integration | 664 | 649 | +15 | 772 | 773 | −1 |
| Security | 520 | 520 | 0 | 548 | 520 | +28 |
| FAQ | 709 | 708 | +1 | 737 | 736 | +1 |
| Contacts | 532 | 533 | −1 | 670 | 669 | +1 |
| Тизер + подвал | 844 | — | — | 996 | — | — |

Ничего из этого в группе 9 не правилось — разбор на этапе финального аудита
(BACKLOG A-41).

### Файлы

- `functions.php` — добавлен `nv_is_light_theme()`
- `footer.php` — ветвление переведено на хелпер (разметка не менялась)
- `template-parts/teaser.php` — выбор логотипа через хелпер
- `css/styles.css` — регионы `TEASER HOME` и `FOOTER HOME` получили второй
  контекст (одни и те же значения для обеих страниц, без Solutions-специфики);
  `body.home .container` распространено на `/solutions/`
- `docs/` — CHANGELOG, DECISIONS (Р-99…Р-103), COMPONENTS, QA, PROJECT_STATE, BACKLOG

Новых файлов и ассетов нет.

### Чем проверено

- PHP lint `functions.php`, `footer.php`, `teaser.php`, обоих шаблонов страниц;
  `node --check`; баланс скобок CSS — чисто
- Вариант подвала: светлый только на `/` и `/solutions/`; pricing, docs,
  privacy, blog и 404 остались на тёмном
- 15 ширин (1920…320): переполнения, горизонтальной прокрутки, JS-ошибок,
  4xx и дублей `id` нет; все пять изображений тизера и подвала загружаются
- Ссылки: 16 штук, ни одного `href="#"`, все внутренние адреса 200,
  якоря `#products`, `#about`, `#contacts` на главной существуют
- Модалка `#callForm2` открывается, внутри одна форма и 235 стран,
  фокус уходит в поле, Escape закрывает; форм не отправляли
- Стыки Contacts → тизер → подвал: зазоры 0 на всех четырёх ширинах
- Тизер и подвал Solutions сверены с главной поэлементно: 0 расхождений
  на 1920 / 1440 / 840 / 392
- Регрессия: главная × 4 ширины — 0 расхождений; модальные формы — 0;
  pricing, docs, privacy, blog, 404 — 0; `header.php` и её CSS не менялись
- Сняты полные скриншоты `/solutions/` на 1920 / 1440 / 840 / 392
  для финального аудита

### Найдено, но не правилось

- Макет Solutions ссылается на более раннюю версию компонента Footer, чем
  главная. Подвал главной принят единственным source of truth: Solutions
  подключает его как есть, расхождение с макетом страницы — принятое
  отклонение (DECISIONS.md, Р-101; BACKLOG A-39 закрыт).
- Нижняя строка подвала на 1440 в две строки вместо одной: полный
  юридический текст длиннее макетного.
- В подвале одна иконка соцсети вместо двух и нет пункта Blog: нет
  подтверждённого профиля и страницы записей (BACKLOG R-20, R-17).
- Накопленная дельта высоты страницы (BACKLOG A-41).

---

## 2026-10-09 — редизайн Solutions, группа 8: Contacts «Not sure which product fits?»

Прежняя тёмная секция `.cta` заменена светлым блоком Contacts по макету.
Форма обратной связи вынесена в общий template-part: одна разметка на
главную и на Solutions вместо двух копий.

### Что сделано

| Что | Как | Узлы Figma |
|---|---|---|
| Общая форма | `template-parts/contacts-form.php`, подключается `get_template_part` | — |
| Шапка блока | бейдж, H2 и оранжевый подзаголовок | `2456:16692` |
| Оранжевая карточка | заголовок, «Email us» и «Message us» в ряд, без кнопки и разделителя | `2456:16695` |
| Карточка формы | поля слева, сообщение и согласие справа, кнопка справа внизу | `2456:16711` |
| Раскладка | Full HD левая колонка 580; Desktop 443; ≤991.98 — в столбик: заголовок, форма, карточка | `2398:25244`, `2457:17398`, `2467:18083` |
| Старый `.cta` | разметки нет, CSS-регион `CTA` оставлен как legacy | — |

JavaScript не менялся. Новых ассетов нет.

### Вынос формы — что сохранено

`name`, `id`, `data-*`, классы для JS, порядок полей, плейсхолдеры, тексты
ошибок, список из 235 стран (`taodep_phone_country_list`), четыре варианта
select, чекбокс согласия с полным юридическим текстом и обеими ссылками,
`captcha-holder`, кнопка отправки, AJAX-действие `send_contacts_form`.
Единственный параметр — `show_select`.

**HTML главной до и после совпадает байт в байт** (`curl` + `diff`).

### Тексты блока

| Элемент | Текст |
|---|---|
| Badge | Contacts |
| H2 | Not sure which product fits? Tell us about your flow |
| Подзаголовок | We'll map your onboarding and compliance steps to the right modules and set up a pilot on your real traffic. |
| Заголовок карточки | Prefer to reach out directly? |
| Контакты | Email us: hello@nv.global · Message us |
| Кнопка формы | Get Started |

Блока «Here's what you'll get» в макете Solutions нет — не выводим.

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 532 | 533 | 670 | 669 | 978 | 977 | 1161 | 1137 |
| Бейдж | 103×32 | 103×32 | 103×32 | 103×32 | 103×32 | 103×32 | 85×24 | 87×24 |
| H2 | 580×104 | 580×104 | 427×156 | 427×156 | 776×104 | 776×104 | 360×132 | 360×132 |
| Подзаголовок | 580×56 | 580×56 | 427×84 | 427×84 | 776×56 | 776×56 | 360×60 | 360×60 |
| Оранжевая карточка | 580×156 | 580×156 | 443×156 | 443×156 | 776×88 | 776×88 | 360×128 | 360×128 |
| Карточка формы | 1228×388 | 1228×388 | 885×526 | 885×524 | 776×510 | 776×508 | 360×662 | 360×636 |
| Поле ввода | 578×60 | 578×60 | 407×60 | 406.5×60 | 360×60 | 360×60 | 336×60 | 336×56 |
| Поле сообщения | 578×204 | 578×160 | 837×160 | 837×160 | 744×160 | 744×160 | 336×160 | 336×160 |
| Кнопка | 152×40 @y468 | 153×40 @y468 | 152×40 @y606 | 153×40 @y604 | 152×40 @y818 | 153×40 @y816 | 152×40 @y965 | 153×36 @y944 |

Карточка формы и позиция кнопки на Full HD и Desktop совпадают точно.
Расхождения перечислены ниже.

### Файлы

- `template-parts/contacts-form.php` — **новый**, 228 строк
- `main-page.php` — 202 строки формы заменены одной строкой `get_template_part`
- `page-solutions.php` — секция `.cta` заменена секцией `.contacts`
- `css/styles.css` — регион `CONTACTS` (7629–9720): базовые правила перечисляют
  оба контекста, ниже подблок отличий Solutions и правила в media-запросах;
  регион `CTA` (16894–17129) не тронут
- `docs/` — CHANGELOG, DECISIONS (Р-93…Р-98), COMPONENTS, QA, PROJECT_STATE, BACKLOG

### Чем проверено

- PHP lint трёх шаблонов, `node --check` для `main.js` и `form.js`,
  баланс скобок CSS — чисто
- HTML главной до и после выноса формы — **0 байт разницы**
- 15 ширин (1920…320): переполнения и горизонтальной прокрутки нет,
  JS-ошибок нет, 4xx нет, дублей `id` нет, форм на странице три
  (секция и две модалки)
- Валидация **без единой реальной отправки**: пустая форма, короткое имя,
  кривой e-mail, неотмеченное согласие — ошибки те же, что на главной,
  запросов к `admin-ajax.php` ноль; на Solutions нет только проверки
  «Please select an option», потому что поля нет
- Телефонный список открывается, 235 стран, не обрезан, `aria-expanded`
  переключается; выбор страны подставляет код
- Select на главной — четыре прежних варианта; на Solutions поля нет
- hCaptcha не обходилась и не отключалась
- Регрессия: главная × 4 ширины — 0 расхождений; pricing, docs, privacy,
  blog, 404 — 0; на Solutions изменения начинаются ровно с секции Contacts

### Найдено, но не правилось

- Поле сообщения на Full HD 204 вместо 160, согласие на 32 ниже: правая
  колонка выровнена по левой, иначе пришлось бы заводить второй вариант
  разметки формы (DECISIONS.md, Р-97). Высота карточки и позиция кнопки
  при этом совпадают с макетом.
- Высота секции на 392 больше на 24: подписи полей оставлены 12/16,
  в макете они 10/12 — 10px подписи ухудшили бы читаемость и разошлись бы
  с формой главной. Плюс юридический текст согласия занимает две строки
  14px против 12px в макете.
- В карточке одна иконка мессенджера вместо трёх: реальный адрес есть
  только у LinkedIn (BACKLOG R-20).
- Между 992 и 1399 своего макета нет: раскладка та же, что у главной.
- Модалки на Solutions изменили метрику подписей и совпали с модалками
  главной — следствие подгрузки Satoshi Light (BACKLOG A-38).

---

## 2026-10-09 — редизайн Solutions, группа 7: FAQ «Questions we hear most»

Прежний тёмный FAQ Solutions заменён светлым блоком по макету. Компонент
не переписывался: взята разметка и механика FAQ главной, которая уже
переделана, а CSS главной расширен вторым контекстом.

### Что сделано

| Что | Как | Узлы Figma |
|---|---|---|
| Шапка блока | бейдж, H2, подзаголовок, «Didn't find your answer?» и кнопка «Talk to an Engineer» | `2456:16672` |
| Спойлеры | пять строк по данным `$nv_solutions_faq`, рендер циклом | `2456:16681` |
| Раскрытие | общий `initFaq()`, второго обработчика нет; первый вопрос раскрыт сразу | — |
| Раскладка | Full HD — левая колонка 600; Desktop — 440; ≤991.98 — в столбик, CTA под текстом; ≤767.98 — мобильные размеры из фрейма 392 | `2398:25091`, `2457:17382`, `2467:18067` |
| Старая разметка | пять тёмных спойлеров и `td_image` в левой колонке убраны | — |

JavaScript не менялся. `FAQPage` JSON-LD не добавлялся.

### Контент — источник только фрейм Solutions

| № | Вопрос | Ответ | Раскрыт |
|---|---|---|---|
| 1 | How long does integration take? | Under an hour via REST API or Web SDK. Sandbox access from day one, production after a 1-month pilot on your real traffic. | да |
| 2 | Which countries and documents do you support? | в макете нет | — |
| 3 | How fast is a verification? | в макете нет | — |
| 4 | How do you protect personal data? | в макете нет | — |
| 5 | Which products can I combine? | в макете нет | — |

Вопросы 2–5 выводятся строкой без шеврона и без пустой панели — тем же
приёмом `faq__item--static`, что на главной. Тексты не выдумывались и не
переносились ни с главной, ни из прежнего тёмного FAQ: там были другие
пять вопросов (BACKLOG A-34).

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 709 | 708 | 737 | 736 | 1085 | 1084 | 940 | 948 |
| Бейдж | 70×32 | 71×32 | 70×32 | 71×32 | 70×32 | 71×32 | 56×24 | 59×24 |
| H2 x/y | 32 / 144 | 32 / 144 | 32 / 144 | 32 / 144 | 32 / 144 | 32 / 144 | 16 / 104 | 16 / 104 |
| H2 размер | 600×52 | 600×52 | 440×104 | 440×104 | 776×52 | 776×52 | 360×44 | 360×44 |
| Подзаголовок | 600×56 | 600×56 | 440×84 | 440×84 | 776×56 | 776×56 | 360×72 | 360×72 |
| Левая колонка | 600 | 600 | 440 | 440 | 776 | 776 | 360 | 360 |
| Колонка спойлеров | 1208 @680 | 1208 @680 | 888 @520 | 888 @520 | 776 @y412 | 776 @y412 | 360 @y372 | 360 @y372 |
| Кнопка CTA | 216×40 @y372 | 216×40 @y372 | 216×40 @y452 | 216×40 @y452 | 216×40 @y348 | 216×40 @y348 | 194×36 @y312 | 194×36 @y312 |
| Закрытая строка | 88 | 88 | 88 | 88 | 88 | 88 | 72 / 80 | 72 / 80 |
| Раскрытая строка | 165 | 164 | 193 | 192 | 193 | 192 | 177 | 176 |
| Панель ответа | 1174×77 | 1176×76 | 854×105 | 856×104 | 742×105 | 744×104 | 342×105 | 344×104 |
| Шеврон | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 |

Раскрытая строка и панель на 1px выше макетной: `initFaq` прибавляет к высоте
толщину верхней рамки. Так же считается FAQ главной — поведение не меняли.

### Файлы

- `page-solutions.php` — секция переписана, данные в массиве `$nv_solutions_faq`
- `css/styles.css` — регион `FAQ` (15761–16502): базовые правила перечисляют
  `body.home` и `body.page-template-page-solutions`, ниже подблок отличий
  Solutions и правила в media-запросах
- `docs/` — CHANGELOG, DECISIONS (Р-87…Р-92), COMPONENTS, QA, PROJECT_STATE, BACKLOG

Новых ассетов нет: шеврон и стрелка кнопки уже были в теме.

### Чем проверено

- PHP lint, `node --check js/main.js`, баланс скобок CSS — чисто
- 15 ширин (1920…320): переполнения и горизонтальной прокрутки нет,
  обрезанного текста нет, JS-ошибок нет, 4xx нет, дублей `faq-*` id нет
- Раскрытие на 1440 / 840 / 392: click, Enter, Space закрывают и открывают
  первый вопрос; `aria-expanded` переключается; каждый `aria-controls`
  указывает на существующий `id`
- Строки без ответа — `div`, не `button`: табом не берутся, шеврона нет
- Tab после кнопки «Talk to an Engineer» попадает на вопрос, обводка 2px
- Ширина колонки спойлеров при раскрытии не меняется, текст не обрезается
- Resize 1440 → 840 → 392 → 1440: состояние сохраняется, клик после
  возврата работает, обработчики не задваиваются
- `prefers-reduced-motion: reduce` — у панели и шеврона `transition: 0s`
- Главная: первый вопрос раскрыт, click / Enter / Space работают,
  снимок стилей на 1920 / 1440 / 840 / 375 — 0 расхождений
- Регрессия: pricing, docs, privacy, blog, 404 — 0 расхождений;
  модальные формы — 0; на Solutions изменения начинаются ровно с контейнера FAQ
- Переход Security → FAQ → CTA: зазоров 0, как между фреймами макета

### Найдено, но не правилось

- Высота секции на 392 на 8px меньше макетной: вопрос «How do you protect
  personal data?» в браузере помещается в одну строку, в Figma — в две.
  Ширина текстовой колонки совпадает (220px), расходится метрика шрифта.
- Между 992 и 1399 своего макета нет: раскладка остаётся двухколоночной,
  как у FAQ главной (BACKLOG A-35).
- У строк без ответа нет шеврона, в макете он нарисован у всех пяти
  (BACKLOG A-34).

---

## 2026-10-09 — редизайн Solutions, группа 6: Security & compliance

Старая тёмная секция `.security` со слайдером заменена новым светлым блоком
из четырёх статичных плиток: три текстовые и одна с иллюстрацией щита.
Секция отзывов на этой странице скрыта.

### Что сделано

| Что | Как | Узлы Figma |
|---|---|---|
| Шапка блока | бейдж «Security» и H2 | `2456:16640` |
| Плитки | три текстовые по данным `$nv_security_items`, рендер циклом | `2456:16643` |
| Плитка с иллюстрацией | `.solutions-security__card--image`, щит выходит за верхний край | `2456:16646` |
| Раскладка | Full HD и Desktop — 4 в ряд, иллюстрация третья; ≤1399.98 — 2x2, иллюстрация последняя; ≤767.98 — одна колонка | `2457:17350`, `2467:18034` |
| `.testimonials` | обёрнута в `<?php if (false) : ?>`, CSS, JS и ассеты не трогали | — |
| Старый `.security` | разметки нет, CSS-регион `SECURITY` и `initSecuritySlider` оставлены как legacy | — |

Скрытый в макете блок «Trusted by Industry Leaders» не реализован — по заданию.

### Три текстовые плитки

| № | Заголовок | Описание |
|---|---|---|
| 1 | Data protection | Encryption in transit and at rest; biometric templates are irreversible and raw images are never stored; deletion on request. |
| 2 | Certifications | ISO/IEC 27001:2022, GDPR-ready; face recognition benchmarked by NIST FRVT (TOP-24 worldwide, 03/2023). |
| 3 | Deployment | On-premises, cloud or hybrid — your data stays where your regulator wants it. |

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 520 | 520 | 548 | 520 | 776 | 776 | 943 | 964 |
| Бейдж | 96×32 | 96×32 | 96×32 | 96×32 | 96×32 | 96×32 | 79×24 | 81×24 |
| H2 y / высота | 144 / 52 | 144 / 52 | 144 / 52 | 144 / 52 | 144 / 104 | 144 / 104 | 104 / 88 | 104 / 88 |
| Сетка | 1856×212 | 1856×212 | 1376×240 | 1376×212 | 776×440 | 776×440 | 360×695 | 360×716 |
| Текстовая плитка | 452×212 | 452×212 | 340×240 | 340×212 | 380×212 | 380×212 | 360×152 | 360×152 |
| Плитка с щитом | 452×212 | 452×212 | 308×240 | 308×212 | 380×212 | 380×212 | 360×212 | 360×212 |
| Иконка | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 |
| Щит | 337×267 @ 1053,188 | 337×267 @ 1053.9,189 | 238×188 | 238×188 | 241×196 | 241×196 | 277×200 | 277×200 |

На 1440 плитки на 28px выше макетных: высота ряда идёт от содержимого
самой длинной карточки «Certifications». Фиксированную высоту не ставим —
при другой длине текста она обрезала бы описание.

### Ассеты

Новые: `img/sol-sec-shield.webp` 337×267 (+`@2x` 674×534), 10 / 21 КБ —
кроп исходного PNG 2000×2000 по занятой щитом области, прозрачность сохранена.
Иконка кубка встроена inline с `fill="currentColor"` — в теме её не было.
Старые изображения и код слайдера Security не удалялись.

### Файлы

- `page-solutions.php` — секция переписана, данные в массиве `$nv_security_items`;
  `.testimonials` скрыта через `if (false)`
- `css/styles.css` — новый регион `SOLUTIONS SECURITY` (15241–15523);
  регион `SECURITY` (15525–15759) оставлен нетронутым
- `img/` — 2 новых файла
- `docs/` — CHANGELOG, DECISIONS (Р-82…Р-86), COMPONENTS, QA, PROJECT_STATE, BACKLOG

JavaScript не менялся.

### Чем проверено

- PHP lint, баланс скобок CSS — чисто
- 15 ширин (1920…320): переполнения и горизонтальной прокрутки нет,
  схлопнувшихся плиток нет, JS-ошибок нет, 4xx нет
- Переходы 1200 → 992, 992 → 840, 768 → 576: раскладка меняется
  по брейкпоинтам темы, разрывов нет
- Плитки не интерактивны: внутри секции ноль `a` / `button` / `[tabindex]`,
  клик по плитке ничего не делает
- Иллюстрация грузится (`naturalWidth` 337), `srcset` 1x/2x, `alt=""`
  и `aria-hidden` у декоративных элементов
- `.testimonials` нет в DOM на всех ширинах; зазор между Security и FAQ — 0,
  пустого места от скрытой секции не осталось
- `initSecuritySlider` и `initTestimonialsSlider` при отсутствии разметки
  не падают — консоль чистая
- Регрессия: pricing, docs, privacy, blog, 404 × 4 ширины — 0 расхождений;
  главная × 4 ширины — 0; модальные формы — 0

### Найдено, но не правилось

- Между 1200 и 1440 своего макета нет. Четыре плитки по 340 в ряд ниже 1400
  оставляют иллюстрации меньше ширины щита, поэтому планшетная раскладка 2x2
  включается с 1399.98, а не с 1199.98.
- Высота секции на 392 на 21px меньше макетной: мобильные плитки считаются
  по содержимому, в макете у первых трёх жёсткая высота.
- Дубли `id` от lottie в `.cta` и подвале — прежний пункт BACKLOG A-27.

---

## 2026-10-09 — редизайн Solutions, группа 5: Seamless Integration That Just Works

Старая секция `.integration` со слайдером и датчиком аптайма заменена новым
светлым блоком: слева слайдер из трёх путей интеграции, справа три статичные
карточки.

### Что сделано

| Что | Как | Узлы Figma |
|---|---|---|
| Шапка блока | бейдж, H2, подзаголовок и две кнопки | `2456:16594` |
| Слайдер | три пути интеграции, `loop: false`, без автопрокрутки, индикатор-штрихи | `2456:16602`, `2439:14696`, `2440:14784` |
| Правая колонка | три статичные карточки, с активным слайдом не связаны | `2456:16616` |
| Раскладка | Full HD — три карточки в ряд; Desktop — две плюс широкая; планшет и мобильная — своя | `499:6223`, `2457:17303`, `2467:17987` |
| Датчик аптайма | разметка удалена, CSS и `initUptimeGauge` оставлены как legacy | — |

### Три слайда

| № | Заголовок | Подпись | Описание |
|---|---|---|---|
| 1 | API Integration | — | Direct backend integration for maximum control and extensive customisation options. |
| 2 | Web SDK & Widget | — | Drop our embeddable verification widget into your website with just a few lines of code. |
| 3 | Mobile SDK | iOS & Android | Native SDKs that bring document scanning and selfie capture directly into your mobile app. |

### Три статичные карточки

| № | Заголовок | Содержимое |
|---|---|---|
| 1 | Every integration includes: | пять строк: step-by-step implementation guides; sandbox with test data; dedicated technical support; an account manager who speaks both business and tech; regular check-ins |
| 2 | Cloud, on-premises or hybrid | подпись «data stays in your jurisdiction» + 3D-стойка серверов |
| 3 | Back-office included | три чипа: scenario builder, stop-lists, manual review and analytics + 3D-папки |

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 664 | 649 | 772 | 836 | 1148 | 1113 | 1550 | 1533 |
| Бейдж | 115×32 | 116×32 | 115×32 | 116×32 | 115×32 | 116×32 | 96×24 | 98×24 |
| H2 y / высота | 80 / 52 | 81 / 52 | 80 / 52 | 144 / 52 | 80 / 52 | 81 / 52 | 72 / 88 | 73 / 88 |
| Кнопки шапки | 493×40 | 483×40 | 493×40 | 483×40 | 493×40 | 483×40 | 360×92 | 227×84 |
| Карточка слайдера | 540×380 | 540×364 | 400×488 | 400×488 | 776×304 | 776×268 | 360×364 | 360×352 |
| Белая карточка слайда | 492×208 | 492×188 | 352×232 | 352×236 | 744×200 | 744×164 | 336×180 | 336×168 |
| Стрелки | 88×40 | 88×40 | 88×40 | 88×40 | 88×40 | 88×40 | 88×40 | 88×40 |
| Индикатор | 3 штриха, активный 32×4 | 32×4 | то же | то же | то же | то же | то же | то же |
| Every integration includes | 468×380 | 468×364 | 544×340 | 544×340 | 492×324 | 492×324 | 360×311 | 360×312 |
| Cloud / on-premises | 400×380 | 400×364 | 400×340 | 400×340 | 268×324 | 268×324 | 360×200 | 360×200 |
| Back-office | 400×380 | 400×364 | 960×132 | 960×132 | 776×116 | 776×116 | 360×216 | 360×216 |
| Иллюстрация серверов | 335×224 | 335×224 | 277×185 | 277×185 | 277×185 | 277×185 | 197×132 | 197×132 |
| Иллюстрация папок | 252×176 | 252×176 | 222×155 | 222×155 | 222×155 | 222×155 | 194×135 | 194×135 |

Desktop 1440 совпадает по всем карточкам точно. Карточка слайдера везде
на 16–36px выше макетной: высота выровнена по третьему слайду, у которого
есть подпись «iOS & Android» — иначе переключение двигало бы страницу.

### Ассеты

Новые: `img/sol-int-servers.webp` 335×224 (+`@2x` 670×448), 11 / 23 КБ;
`img/sol-int-folders.webp` 252×176 (+`@2x` 504×352), 4 / 8 КБ. Прозрачность
сохранена, кроп посчитан по трансформации изображения в своём узле.
Звезда слайда и обе стрелки уже были в теме — переиспользованы inline
с `currentColor`. Старые изображения и код датчика аптайма не удалялись.

### Файлы

- `page-solutions.php` — секция переписана, данные в массивах
  `$nv_integration_slides`, `$nv_integration_includes`, `$nv_integration_backoffice`
- `css/styles.css` — регион `INTEGRATION` (14432–15239) переписан
- `js/main.js` — `initIntegrationSlider` переписан
- `img/` — 4 новых файла
- `docs/` — CHANGELOG, DECISIONS (Р-74…Р-81), COMPONENTS, QA, PROJECT_STATE, BACKLOG

### Чем проверено

- PHP lint, `node --check js/main.js`, баланс скобок CSS — чисто
- 15 ширин (1920…320): переполнения нет, схлопнувшихся карточек нет,
  JS-ошибок нет, 4xx нет
- Три слайда на 1440 / 840 / 392: 1 → 2 → 3 и обратно, Previous выключен
  на первом, Next на третьем, зацикливания нет; индикатор синхронен
- Клавиатура ArrowLeft / ArrowRight, свайп мышью и на узких ширинах —
  работают, вертикальная прокрутка страницы не перехватывается
- Отсутствие сдвига: на всех трёх слайдах высота секции, положение правой
  колонки и начало секции Security совпадают до пикселя
- Resize 1440 → 840 → 392 → 1440 с выбранным третьим слайдом: выбор
  сохраняется, Previous после возврата работает, консоль чистая
- Подписи стрелок, `aria-hidden` у индикатора и декоративных картинок,
  видимая обводка фокуса, иерархия заголовков
- Старого слайдера и датчика аптайма в DOM нет, `initUptimeGauge` не падает
- Регрессия: pricing, docs, privacy, blog, 404 × 4 ширины — 0 расхождений;
  главная × 4 ширины — 0; модальные формы — 0

### Найдено, но не правилось

- Высота секции на 1440 меньше макетной на 64: во фрейме Full HD у блока
  нет верхнего поля, во фрейме Desktop оно 64. Взят вариант Full HD —
  отступ даёт нижнее поле секции Products.
- Кнопка в макете подписана «View documentatio» (обрезано) — выводим
  «View documentation».
- Дубли `id` от lottie — прежний пункт BACKLOG A-27.

---

## 2026-10-09 — редизайн Solutions, группа 4: One platform. Lots of products. One API

Старый блок `.flow` заменён новым блоком из шести продуктовых карточек.
Якорь `#solutions` переехал на своё финальное место.

### Что сделано

| Что | Как | Узлы Figma |
|---|---|---|
| Новый блок | `.solutions-products`: панель со скруглением 32 и рамкой, сетка 3×2 (планшет 2×3, мобильная — колонка) | `2456:16577`, `2398:21666`, `2457:17288`, `2467:17972` |
| Данные | массив `$nv_products`, шесть карточек рендерятся циклом | — |
| Якорь | `id="solutions"` снят с блока Why и поставлен сюда | — |
| CTA | «Learn more» у KYC ведёт на `/docs/products/kyc/`; у KYB цели в проекте нет, кнопка не выводится | — |
| Старая `.flow` | разметки нет; регион `FLOW` и `initFlowSlider` оставлены как legacy | — |

### Шесть карточек

| № | Продукт | Описание | CTA | Адрес |
|---|---|---|---|---|
| 01 | KYC / eKYC | A real person with a real document: document capture, face match, liveness, anti-fraud in one flow. | Learn more | `/docs/products/kyc/` |
| 02 | KYB | Corporate structure down to the UBO, registry checks and signatory verification. | в макете есть | **нет цели** |
| 03 | AML & Sanctions | Screening against 1,700+ databases: OFAC, EU, UK, UN, PEP lists and adverse media; daily re-screening. | нет | — |
| 04 | KYT | Real-time risk scoring of crypto transactions, wallets and addresses. | нет | — |
| 05 | Liveness & Face Authentication | A live person, not a photo, video or mask — deepfake-resistant; password-free login by face. | нет | — |
| 06 | NeuroPay | Pay by face at checkout, branch, ATM or kiosk; palm as a second factor. | нет | — |

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 918 | 916 | 1014 | 1020 | 1318 | 1284 | 1308 | 1406 |
| Панель | 1920×790 | 1920×788 | 1440×886 | 1440×892 | 840×1190 | 840×1156 | 392×1244 | 392×1278 |
| Бейдж | 102×32, по центру | 103×32 | 102×32 | 103×32 | 102×32 | 103×32 | 84×24 | 87×24 |
| H2 y / высота | 209 / 52 | 208 / 52 | 209 / 52 | 208 / 52 | 209 / 52 | 208 / 52 | 137 / 88 | 136 / 88 |
| Подзаголовок | 1854×28 | 1856×28 | 1374×28 | 1376×28 | 774×56 | 776×56 | 358×60 | 360×40 |
| Сетка | 1854×440 | 1856×440 | 1374×536 | 1376×544 | 774×812 | 776×780 | 358×899 | 360×954 |
| Колонок | 3 | 3 | 3 | 3 | 2 | 2 | 1 | 1 |
| Карточка | 607×212 | 608×211 | 447×260 | 448×263 | 379×260 | 380×249 | 358×180 | 360×180 |
| Зазоры сетки | 16 / 16 | 16 / 16 | 16 / 16 | 16 / 16 | 16 / 16 | 16 / 16 | 16 | 16 |
| Номер | 57×64 | 58×64 | 57×64 | 58×64 | 49×56 | 49×56 | 33×36 | 33×36 |
| Кнопка | 116×32 @ x500 y505 | 117×32 @ x499 y503 | 116×32 | 117×32 | 116×32 | 117×32 | 102×28 | ~102×28 |

Full HD совпадает с точностью до 1–2px. Отличия на других ширинах — ниже,
в разделе «Найдено, но не правилось».

### Файлы

- `page-solutions.php` — `.flow` заменена блоком `.solutions-products`,
  данные в массиве `$nv_products`, `id="solutions"` перенесён
- `css/styles.css` — новый регион `SOLUTIONS PRODUCTS` (13161–13521),
  токен `--nv-primary-tint`
- `docs/` — CHANGELOG, DECISIONS (Р-68…Р-73), COMPONENTS, QA, PROJECT_STATE, BACKLOG

Новых ассетов нет: в блоке нет иконок, стрелка кнопки — та же, что уже
используется в теме, с `currentColor`.

### Чем проверено

- PHP lint, `node --check js/main.js`, баланс скобок CSS — чисто
- 15 ширин (1920…320): переполнения и выхода элементов за край нет,
  JS-ошибок нет, 4xx нет; колонок 3 / 2 / 1 по брейкпоинтам
- Прямой переход `/solutions/#solutions` на 1440 и 392 — попадает ровно
  на новую секцию; обе ссылки с главной ведут туда же
- Иерархия заголовков H2 → шесть H3, пустых ссылок нет, у единственной
  ссылки описательное `aria-label`, focus-visible 2px, hover меняет фон
- Старой `.flow` в DOM нет, `initFlowSlider` не падает
- Регрессия: pricing, docs, privacy, blog, 404 × 4 ширины — 0 расхождений;
  главная × 4 ширины — 0; модальные формы — 0

### Найдено, но не правилось

- **У карточки KYB нет кнопки**: в макете она есть, но страницы KYB
  в проекте не существует (`/docs/products/kyb/` → 404). Адрес не выдумываем,
  кнопка включается одной строкой в массиве (BACKLOG A-29).
- Подзаголовок на мобильной занимает три строки вместо двух: при 16/20
  строка в 360px не вмещает столько, сколько показывает макет.
- Карточки на планшете выше макетных (260 против 249): высота идёт
  от содержимого, Figma резервирует фиксированную.
- Дубли `id` от lottie — прежний пункт BACKLOG A-27.

---

## 2026-10-09 — редизайн Solutions, группа 3: Built for regulated industries

Прежний блок `.industries` + `.nvslider` адаптирован под новый светлый макет.
Механика слайдера сохранена, разметка, оформление и контент переписаны.
Блок перенесён: теперь он идёт сразу после «Why Leading Companies».

### Что сделано

| Что | Как | Узлы Figma |
|---|---|---|
| Контент | шесть реальных индустрий из состояний слайдера, один PHP-массив `$nv_industries` на вкладки и слайды | `2456:16556`, `2422:26065`, `2439:14516`, `2439:14561`, `2439:14606`, `2439:14651` |
| Раскладка | карточка 3fr + колонка иллюстрации 1fr; планшет — внутренние блоки друг под другом с нахлёстом 24; мобильная — иллюстрация сверху | `527:9591`, `2457:17267`, `2467:17951` |
| Слайдер | `loop: false`, `initialSlide: 0`, `slideTo`; Previous выключен на первой вкладке, Next — на шестой | — |
| Доступность | `role="tablist"` / `tab` / `tabpanel`, `aria-selected`, `aria-controls`, roving `tabindex`, стрелки клавиатуры и Home/End | — |
| Иллюстрации | шесть отдельных ассетов, слой вне слайдера, переключение по тому же индексу | `2456:16576` и аналоги |

### Шесть индустрий

| № | Вкладка | Заголовок | Чипы | Иллюстрация |
|---|---|---|---|---|
| 1 | Banks | Banks | KYC, AML, Liveness | здание банка |
| 2 | FinTech & lending | FinTech & lending | KYC, AML, KYT | кошелёк и смартфон |
| 3 | Crypto exchanges & Web3 | Crypto exchanges & Web3 | KYC, AML, KYT | смартфон с биткоином |
| 4 | Telecom | Telecom | KYC, Liveness, Face Auth | SIM-карты |
| 5 | Gambling & betting | Gambling & betting | KYC, Liveness, 1:N | рулетка |
| 6 | Government | Government | KYC, AI-OCR, NeuroSign | здание учреждения |

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 556 | 557 | 564 | 593 | 794 | 796 | 1081 | 1121 |
| Бейдж | 107×32 | 103×32 | 107×32 | 103×32 | 107×32 | 103×32 | 107×32 | 103×32 |
| H2 | 1856×52 | 1856×52 | 1376×52 | 1376×52 | 776×52 | 776×52 | 360×88 | 360×88 |
| Подзаголовок | y208, 24 | y208, 24 | y208, 24 | y208, 24 | y208, 24 | y208, 24 | y212, 40 | y212, 40 |
| Карточка | 1380×300 | 1380×300 | 1020×308 | 1020×336 | 776×458 | 776×~460 | 360×422 | 360×~474 |
| Строка навигации | 1332×40 | 1332×40 | 972×40 | 972×40 | 744×40 | 744×40 | 336×40 | 336×40 |
| Стрелка | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 | 32×32 |
| Вкладка | 404×32 | 404×32 | 284×32 | 284×32 | по содержимому | 208×32 | 248×28 | 248×28 |
| Блок содержимого | 1332×180 | 1332×180 | 972×188 | 972×216 | 744×354 | 744×~392 | 336×326 | 336×~392 |
| Карточка индустрии | 520×180 | 520×180 | 520×188 | 520×216 | во всю ширину | во всю ширину | во всю ширину | во всю ширину |
| Правый блок | 812×180 | 812×180 | 452×188 | 452×216 | 744×198 | 744×216 | 336×170 | 336×216 |
| Иллюстрация | 480×480, +128 за край | 480×480, +128 | 480×480, +128 | 480×480, +128 | 316×316, −78 под карточку | 316×316, −78 | 360×360 над карточкой | 360×360 |
| Чип | 55×32 | 56×32 | 55×32 | 56×32 | 55×32 | 56×32 | 51×28 | ~51×28 |

Full HD совпадает полностью. На остальных ширинах блок содержимого ниже
макетного: Figma резервирует фиксированные 216, в теме высота выровнена по
самому высокому слайду (Р-64) — переключение вкладок не двигает секцию.

### Ассеты

Новые, по одному на индустрию: `img/sol-ind-{banks,fintech,crypto,telecom,gambling,government}.webp`
480×480 (+`@2x` 960×960), 11–29 КБ при 1x. Прозрачный фон сохранён.
Стрелка «влево» 20×20 добавлена inline-SVG с `currentColor`; стрелка «вправо»
и иконка индустрии уже были в теме и переиспользованы.
Старые изображения (`img/industries_maskot1…4.*`, вложения медиабиблиотеки
447–451) не удалялись.

### Файлы

- `page-solutions.php` — блок перестроен и перенесён выше `.flow`, данные
  в массиве `$nv_industries`
- `css/styles.css` — регион `INDUSTRIES` (13470–14065) переписан
- `js/main.js` — `initIndustriesSlider` адаптирован
- `img/` — 12 новых файлов
- `docs/` — CHANGELOG, DECISIONS (Р-59…Р-67), COMPONENTS, QA, PROJECT_STATE

### Чем проверено

- PHP lint, `node --check js/main.js`, баланс скобок CSS — чисто
- 15 ширин (1920…320): горизонтальной прокрутки нет, выхода элементов
  за левый край нет, JS-ошибок нет, 4xx нет
- Все шесть вкладок на 1440 / 840 / 392: вкладка, слайд, иллюстрация, чипы,
  `aria-selected`, `tabindex` и состояние стрелок синхронны; Previous выключен
  на первой, Next — на шестой, переходов 6 → 1 и 1 → 6 нет
- Клавиатура: ArrowLeft / ArrowRight / Home / End переключают и переносят фокус,
  на краях ничего не происходит
- Свайп содержимого переключает вкладку и иллюстрацию
- Resize 1440 → 840 → 392 → 1440 с выбранным пятым слайдом: выбор сохраняется,
  раскладка перестраивается, повторных обработчиков нет, консоль чистая
- Высота секции одинакова на всех шести вкладках на всех четырёх ширинах
- `aria-controls` и `aria-labelledby` разрешаются в существующие элементы
- Регрессия: pricing, docs, privacy, blog, 404 × 4 ширины — 0 расхождений;
  главная × 4 ширины — 0; модальные формы — 0

### Найдено, но не правилось

- Макет показывает зацикленную полосу вкладок (Government слева от Banks
  и Banks справа от Government). Зацикливание снято по указанию — активная
  вкладка на краях прижата к краю панели, а не по центру (Р-60).
- Бейдж в макете подписан «Industrys»; оставлено «Industries» (Р-67).
- Дубли `id` от lottie — прежний пункт BACKLOG A-27.

---

## 2026-10-09 — редизайн Solutions, группа 2: блок «Why Leading Companies»

Новый блок вместо секции `.features`, отключение старой `.benefits`.
Остальные секции страницы не трогались.

### Что сделано

| Блок | Что | Узлы Figma |
|---|---|---|
| Why Leading Companies | новый компонент `.solutions-why`: горизонтальное раскрытие на десктопе, статичный список ниже 992 | `2456:16527`, `499:6143`, `2457:17238`, `2467:17925` |
| Состояния карточек | реальные тексты четырёх карточек взяты из состояний Desktop | `2431:14300`, `2431:14440`, `2431:14478` |
| `.benefits` | скрыта через `<?php if (false) : ?>`; автопрокрутка страницы при загрузке исчезла | — |
| `.features` | разметка заменена; CSS-регион и `initFeaturesBlock` оставлены как legacy | — |
| Шапка | стрелка Inquire на Solutions стала белой; логотип выводится из `header.php` по `is_page_template` | `2456:16506`, `2467:18538` |

### Механика

Десктоп (≥992): раскрыта одна карточка (516), остальные сведены до номера (116),
нахлёст 24, левая карточка всегда выше по стопке. Переключение — клик по любой
точке карточки, стрелки Previous/Next, ArrowLeft/ArrowRight/Home/End, наведение
мышью (только `hover: hover` + `pointer: fine`). Зацикливания нет: на первой
карточке Previous выключена, на четвёртой — Next. Анимируется только `width`;
при `prefers-reduced-motion: reduce` переход снят.

Планшет и мобильная: фотография сверху, под ней четыре раскрытые карточки
внахлёст по вертикали на 64. Стрелок нет, интерактив снят.

Доступность: контейнер `role="group"`, заголовок карточки — `<button>`
с `aria-expanded` и `aria-controls`; описания всех карточек остаются в DOM
и читаются скринридером на любой ширине (DECISIONS.md, Р-54).

### Геометрия — сайт против макета

| Параметр | 1920 | Figma | 1440 | Figma | 840 | Figma | 392 | Figma |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Высота секции | 904 | 904 | 904 | 904 | 1302 | 1336 | 1202 | 1132 |
| Доска | 1856×620 | 1856×620 | 1376×620 | 1376×620 | 776×966 | 776×1000 | 360×867 | 360×840 |
| Карточки, всего | 864 | 864 | 864 | 864 | 774 | 776 | 358 | 360 |
| Раскрытая | 516 | 516 | 516 | 516 | все | все | все | все |
| Свёрнутая (видимая) | 116 | 116 | 116 | 116 | — | — | — | — |
| Фотография | 990×618 | 992×620 | 510×618 | 512×620 | 774×489 | 776×489 | 358×301 | 360×301 |
| Высоты карточек | 618 | 620 | 618 | 620 | 132/188/188/160 | 132/188/188/188 | 136/196/228/196 | 136/196/196/196 |
| Нахлёст | 24 | 24 | 24 | 24 | 64 | 64 | 64 | 64 |
| Бейдж | 126×32 | 126×32 | 126×32 | 126×32 | 126×32 | 126×32 | 105×24 | 107×24 |
| H2 | 40px, 1 строка | 40/52, 1 | 40px, 1 | 40/52, 1 | 40px, 2 | 40/52, 2 | 32px, 4 | 32/44, 3 |
| Стрелки | 88×40, 24/24 от угла | 88×40 | 88×40 | 88×40 | нет | нет | нет | нет |

Разница по высоте на планшете и мобильной — от реального текста: четвёртая
карточка укладывается в меньшее число строк, чем плейсхолдер макета, а заголовок
секции с полным названием «NeuroVision Global Systems KYC» занимает на мобильной
четыре строки вместо трёх (Р-49). Минус 2px на доске — рамка в 1px, которую
Figma рисует внутрь.

### Ассеты

`img/sol-why-fhd.webp` 992×620 (+@2x), `sol-why-desktop.webp` 658×620 (+@2x),
`sol-why-tablet.webp` 776×489 (+@2x), `sol-why-mobile.webp` 360×301 (+@2x) —
один и тот же снимок, свой кроп на каждый фрейм. Фотография в макете **не
меняется** при переключении карточек, проверено на всех трёх состояниях.
Стрелка «влево» добавлена inline-SVG с `currentColor`; стрелка «вправо» —
та же, что уже используется в теме.

### Файлы

- `page-solutions.php` — `.benefits` под `if (false)`, `.features` заменена
  блоком `.solutions-why`, данные карточек в массиве `$nv_solution_benefits`
- `css/styles.css` — новый регион `SOLUTIONS WHY` (11993–12499), токен
  `--nv-constant-50`
- `js/main.js` — `initSolutionsWhy()`
- `header.php` — логотип по шаблону страницы, стрелка Inquire на `currentColor`
- `img/` — 8 новых файлов
- `docs/` — CHANGELOG, DECISIONS (Р-53…Р-58), COMPONENTS, QA, PROJECT_STATE, BACKLOG

### Чем проверено

- PHP lint, `node --check js/main.js`, баланс скобок CSS — чисто
- 15 ширин (1920…320): переполнения нет, перехлёстов нет, JS-ошибок нет
- Переход 992 → 840: интерактив корректно сменяется статикой и обратно
- Функционально на 1440: клик по карточкам 1–4, Previous/Next, крайние
  состояния, ArrowLeft/ArrowRight/Home/End с переносом фокуса, наведение мышью,
  устойчивость после resize (повторных обработчиков нет), автопрокрутки нет
- `prefers-reduced-motion: reduce` — `transition-duration: 0s`
- Автопрокрутка страницы при загрузке: 0 на 1920/1440/992/840/768/576/392/375
- Регрессия: `docs/qa-scripts/snap.mjs` (pricing, docs, privacy, blog, 404 ×
  4 ширины) — 0 расхождений; главная × 4 ширины — 0; модальные формы — 0

### Найдено, но не правилось

- Повторяющиеся `id` в DOM (`10111`, `5416`, `5403`, `5402`) приходят из
  SVG, который рисует lottie: на странице несколько кнопок с одной и той же
  анимацией. К разметке темы отношения не имеет, записано в BACKLOG.
- Заголовок секции на мобильной в четыре строки вместо трёх — следствие
  полного названия компании (Р-49).

---

## 2026-10-09 — редизайн Solutions, группа 1: светлая тема, Header, Hero

Начало редизайна `/solutions/` по новым макетам Figma. В группе 1 — только
каркас страницы: токены светлой темы, шапка, первый экран и отключение старой
`.page-nav`. Остальные секции страницы не трогались.

### Что сделано

| Блок | Что | Узлы Figma |
|---|---|---|
| Токены | `body.home` → `body.home, body.page-template-page-solutions`; `background`/`color` вынесены в отдельное правило `body.home` | — |
| Шапка | светлая палитра, фон `--nv-surface-1`, сетка 32/контент−64, бургер и мобильная панель в светлом | `2456:16497`, `2467:18538` |
| Первый экран | полностью перестроен: фотокарточка, логотип, H1, описание, две CTA, полоса из четырёх фактов | `2456:16496`, `2396:15605`, `2457:17207`, `2467:17894` |
| `.page-nav` | скрыта через `<?php if (false) : ?>`, разметка/CSS/JS сохранены | — |
| Логотип шапки | на Solutions выводится тёмной версией из `header.php` по `is_page_template('page-solutions.php')`, обычным `<img>` с `alt` | `2467:18538` |
| Стрелка Inquire | белая на Solutions: цвет задан кнопке и проходит через `currentColor` | `2456:16506` |

### Геометрия первого экрана — сайт против макета

| Параметр | 1920 | Figma FHD | 1440 | Figma Desktop | 840 | Figma Tablet | 392 | Figma Mobile |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Карточка | 1856×732 | 1856×732 | 1376×732 | 1376×732 | 776×872 | 776×872 | — | — |
| Левая колонка | 600 | 600 | 372 | 372 | 712 | 712 | — | — |
| Полоса фактов | 280×668 | 280×668 | 180×668 | 180×668 | 712×120 | 712×120 | 392×120 | 392×120 |
| Карточка факта | 280×155 | 280×155 | 180×155 | 180×155 | 166×120 | 166×120 | 160×120 | 160×120 |
| H1 | 52/64, 2 строки | 52/64, 2 | 52/64, 4 строки | 52/64, 4 | 44/56, 2 | 44/56, 2 | 30/36, 2 | 30/36, 2 |
| Логотип | 206×39 | 206×39 | 206×39 | 206×39 | 206×39 | 206×39 | в шапке 168×32 | 168×32 |
| Кнопки | 40 высота, зазор 12 | 40 / 12 | 40 / 12 | 40 / 12 | 40 / 12 | 40 / 12 | столбик, 12 | столбик, 12 |
| Шапка + экран | 870 | 860 | 870 | 860 | 1008 | 1000 | 720 | 720 |

Расхождение +10 (FHD/Desktop) и +8 (Tablet) — высота «пилюли» меню: в теме она
42/40, в макете 32. Это известный пункт BACKLOG A-23, общий с главной.

### Ассеты

Новые: `img/sol-hero-fhd.webp` (+`@2x`), `sol-hero-desktop.webp` (+`@2x`),
`sol-hero-tablet.webp` (+`@2x`), `sol-hero-mobile.webp` (+`@2x`),
`img/logo-header-light.svg`. Каждый кроп посчитан по трансформации изображения
в своём фрейме, а не подогнан на глаз. Старые изображения не удалялись:
`img/main-solutions-bg3.webp` остаётся на диске.

Иконки четырёх карточек-фактов не добавлялись: те же inline-SVG уже были
в прежней разметке первого экрана, у них заменён `fill="#F9AA66"` на
`fill="currentColor"`.

### Файлы

- `page-solutions.php` — первый экран переписан, `.page-nav` под `if (false)`
- `header.php` — выбор файла логотипа по шаблону страницы; запасная inline-стрелка
  кнопки Inquire переведена с `fill="#2B323B"` на `fill="currentColor"`
  (на остальных страницах цвет кнопки чёрный, вид не изменился)
- `css/styles.css` — блок токенов `HOME THEME`; новый подрегион
  `SOLUTIONS THEME` (светлая шапка); регион `MAIN` переписан целиком
- `img/` — 9 новых файлов
- `docs/` — CHANGELOG, DECISIONS (Р-44…Р-52), COMPONENTS, QA, PROJECT_STATE

### Чем проверено

- PHP lint, `node --check js/main.js`, баланс скобок CSS — чисто
- 15 ширин (1920…320): горизонтальной прокрутки нет, перехлёстов нет,
  JS-ошибок нет, 4xx нет
- Сверка с Figma по `get_metadata` + `get_variable_defs` на всех четырёх фреймах
- Функционально: обе CTA (модалка открывается и закрывается по Escape, ссылка
  на `/pricing-matrix/`), бургер (`aria-expanded` переключается, панель светлая
  и не уезжает за край), фокус с клавиатуры на обеих кнопках — обводка 2px
- Регрессия `docs/qa-scripts/snap.mjs` (pricing, docs, privacy, blog, 404 ×
  4 ширины) — 0 расхождений; главная × 4 ширины — 0 расхождений;
  модальные формы — 0 расхождений

### Найдено, но не правилось

- Автопрокрутка страницы на 840: `updateTabs` в `initBenefitsSlider`
  (`js/main.js:1081`) зовёт `scrollIntoView` на активной вкладке. Поведение
  было и до группы 1 (прокрутка 413 → 265 — изменилась только величина).
  Уйдёт вместе со скрытием `.benefits` в группе 2.
- Мобильная панель меню на главной уезжает за правый край экрана (тот же
  дефект темы, что исправлен на Solutions). Главную не трогали — BACKLOG.
- Высота шапки и состав меню — осознанные отличия (Р-45, BACKLOG A-23).

---

## 2026-10-07 — визуальное доведение главной до эталонного изображения макета

Сверка по двум изображениям: `nv.global_main.png` (эталон, 1920×10213) и
полностраничный снимок сайта. Разбор посекционный, каждое расхождение
подтверждено узлом Figma Full HD перед правкой. Не новый этап редизайна —
точечная полировка геометрии.

### Что исправлено

| Секция | Было | Стало | Узел макета |
|---|---|---|---|
| How it works | правая колонка 260 / 206 | 314 / 152 | `2380:26815` |
| Pricing | карточки растянуты до 269, кнопки размазаны по высоте | 245 и 230, кнопки по нижнему краю | `2380:23639` |
| Results | значение съезжало вниз в карточке с короткой подписью | поле описания фиксировано в две строки | `I2380:22948;147:2811` |
| About | подпись показателя в одну строку, текст сертификации H5/20 на всю ширину | две строки (`max-width: 192px`), H6 18/24 в поле 588 | `2380:22912`, `2380:22922` |
| Industry Solutions | рамка иконки 34×34 | 32×32, обводка внутри | `I2380:22957;147:2731` |
| Products | описание слайда во всю ширину, вкладки 34 | поле 571, вкладки 32 | `2380:22999`, `2380:22986` |
| Developers | заголовок переносился после «hour,», описание 503 | перенос после «under», описание 437 | `2380:23734`, `2380:23735` |
| Contacts | заголовок списка тёмный, тексты карточек в одну строку | `--nv-primary`, перенос на две строки | `2380:23800`, `2380:23802` |
| Кнопки главной | 42 и 34 по высоте | 40 и 32 (обводка Figma — внутри рамки) | — |

Все правки Full HD вынесены в базу, значения Desktop и Tablet восстановлены
в `max-width: 1599.98px` — раскладки ниже Full HD не изменились.

### Высоты секций после правок (Full HD)

| Секция | Макет | Сайт | Δ |
|---|---|---|---|
| Hero | 1000 | 1010 | +10 |
| About | 576 | 581 | +5 |
| Results | 564 | 572 | +8 |
| Industry Solutions | 630 | 636 | +6 |
| Products | 616 | 622 | +6 |
| How it works | 697 | 704 | +7 |
| Why us | 721 | 722 | +1 |
| Trusted | 737 | 738 | +1 |
| Pricing | 524 | 531 | +7 |
| Developers | 564 | 572 | +8 |
| FAQ | 1020 | 1021 | +1 |
| Contacts | 809 | 812 | +3 |
| Teaser + Footer | 843 | 844 | +1 |

Остаточный плюс — 1px рамки карточки с каждой стороны: в Figma обводка рисуется
внутри габарита, в CSS `border` добавляется к `padding: 24px`. Сводить к нулю
пришлось бы правкой `padding` у каждой карточки темы; отложено.

Hero +10 — следствие шапки: в макете строка меню 32px, на сайте 42px
(пункты меню не менялись по прямому указанию пользователя).

### Файлы
- `css/styles.css`
- `main-page.php`

### Чем проверено
- Посекционные кропы эталона и снимка сайта в одном масштабе.
- Геометрия элементов через Playwright на 1920 / 1440 / 840 / 392 после каждой правки.
- `qa-responsive.mjs` на 1920 / 1600 / 1440 / 1200 / 992 / 840 / 768 / 576 / 392 / 375:
  `doc == vw` везде, горизонтального переполнения нет, JS-ошибок 0.
- `qa-func.mjs`: вкладки Products (6/6, ArrowRight, prev/next disabled), пины Trusted,
  FAQ, якорные ссылки, архитектура футера — без изменений.
- `qa-form-func.mjs`: валидация формы контактов, 0 запросов к `admin-ajax`,
  открытие/закрытие `callForm2` с ловушкой фокуса.
- Мобильное меню на 840 и 392: открывается (8 ссылок), закрывается.
- `docs/qa-scripts/snap.mjs` по 6 страницам × 4 ширины против предыдущего прогона:
  56 расхождений, все — координата `x` бегущей строки на `/solutions/`.
- `modals.mjs`: 0 расхождений.

### Найдено, но не правилось
- «NeuroVision Global Systems» в теме против «NeuroVision Global» в эталоне
  (About, Why us, Trusted, Developers, футер) — текст темы, нужно отдельное решение.
- Юридическое имя в футере: эталон «NeuroVision Global Intelligence — FZCO»,
  на сайте верхним регистром и с дефисом — юридические реквизиты.
- FAQ: в эталоне шеврон у всех восьми вопросов, на сайте только у первого —
  у остальных нет текста ответа, шеврон появится вместе с контентом.
- Контакты и футер: в эталоне три мессенджера и две соцсети, на сайте по одной —
  остальные ссылки отсутствуют (решение пользователя не ставить пустые ссылки).
- Шапка: состав меню и две кнопки макета — вне задачи.

---

## 2026-10-07 — Results: размер заголовка карточки на Full HD

По замечанию пользователя о тексте «countries and territories».

`.results__stat-title` был 24 / 150% на всех ширинах. В макете стиль разный
по брейкпоинтам: Full HD `2380:22951` — Title/H5 **20 / 28**, Desktop
`2363:33996` и Tablet `2376:16779` — Title/H4 24 / 36. Базовый уровень
переведён на 20 / 140%, в `max-width: 1599.98px` возвращается 24 / 150%.

Заодно сверена типографика всех карточек перерисованных секций — 13 элементов
Results, How it works, Why us, Developers, Industry Solutions, Pricing
и Contacts. Расхождение было только это одно, таблица — в `docs/BACKLOG.md`,
пункт A-18.

Отдельно отмечено: в коде, который отдаёт Figma MCP, алиас переменной может
не совпадать с именем стиля (здесь `--text/title/size/h3` со значением 20
при стиле `Title/H5`). Ориентироваться нужно на разрешённое значение.

Проверено: 1920 / 1600 / 1440 / 1200 / 992 / 840 / 768 / 392 / 375 —
размер применяется по брейкпоинтам верно, высоты секции Results не
изменились ни на одной ширине (572 / 572 / 648 / 690 / 774 / 986 / 1010 /
1396 / 1420), горизонтального переполнения и ошибок JS нет. Селекторов
не удалено, новых не добавлено.

---

## 2026-10-07 — визуальная полировка высот четырёх секций

Закрыты A-08 (Products), A-12 (How it works) и A-09 (Contacts). Why us
на планшете разобран и оставлен с доказанной причиной. Правился только CSS,
разметка, тексты и логика не трогались. Таблица замеров — `docs/BACKLOG.md`,
раздел «A — визуальная полировка высот».

### Что изменено

**Products.** Колонки разведены по брейкпоинтам: Full HD `2380:22973` —
633 + 1000, Desktop `2363:30609` — 540 + 740. В прежней узкой колонке
заголовок переносился на вторую строку и давал +52. Зазор между колонками
сделан подвижным (`justify-content: space-between` + `max-width: 1000px`
у карточки слайдера), чтобы на 1600 ряд не распирало фиксированными 223px.
674 → 622 при макетных 616.

**How it works.** У секции снято верхнее поле: в макете бейдж стоит на y=1
во всех трёх фреймах, а ритм задаёт нижнее поле предыдущей секции. Общее
`.section { padding: 64px 0 }` давало лишние 63px. На планшете поле
возвращается — там наша раскладка на 60px ниже макетной.
Full HD 768 → 704 (макет 697), Desktop 808 → 744 (макет 737).

**Contacts.** Три подтверждённые причины:
1. `grid-template-rows: min-content 1fr` — браузер выравнивал обе строки
   сетки по карточке контактов, из-за чего левая колонка вырастала на 136px
   сверх высоты формы;
2. нижнее поле секции снято — в макете контент заканчивается за 1px до низа
   во всех трёх фреймах, дальше сразу «Page edge» тизера;
3. зазор между значком и текстом в карточке выгод: 0 на Full HD
   (`2380:23802` — карточка 104), 24 на Desktop (там макетная карточка 128),
   8 на планшете (`2376:17626` — карточка 90).

Full HD 1036 → 812 (макет 809), Desktop 1074 → 1010 (1005),
Tablet 1502 → 1406 (1397).

**Why us, планшет.** Не правится: заголовок занимает две строки из-за
утверждённого названия «NeuroVision Global Systems», в макете оно короче.
Остаток +55 разложен по пикселям в BACKLOG.

### Проверено
- Селекторов не удалено ни одного, добавлено четыре — все ограничены
  классами секций главной; правил, задевающих достижимые страницы, нет.
- Вычисленные стили всех потомков `#callForm` и `#callForm2` на главной
  и `/solutions/`, четыре ширины — **0 различий**.
- 1920 / 1600 / 1440 / 1200 / 992 / 840 / 768 / 392 / 375: `scrollWidth`
  равен ширине окна, обрезанного контента нет, ошибок JS нет.
- Форма: 4 варианта услуг, 235 стран, пустая отправка даёт ошибки и
  **0 запросов** `admin-ajax`; раскладка Full HD сохранена.
- Остальные секции главной остались в прежних пределах.
- Шесть страниц против состояния до редизайна — без новых регрессий.

---

## 2026-10-07 — устранение дефектов аудита: P1 целиком и три P2

Закрыты все шесть P1 (A-01…A-06) и три P2 (A-07, A-10 частично, A-11),
плюс две находки самого регресса (A-16, A-17). Подробности и проверки —
`docs/BACKLOG.md`, раздел «A — результаты устранения дефектов».

### Разметка
- `header.php` — пункт «Cases» обёрнут в `if (!is_front_page())`: на главной
  секция скрыта решением Р-11 и якоря нет, на остальных страницах меню
  не изменилось. Скрытая секция и её код не трогались.
- `main-page.php` — сняты декоративные `id` слоёв Figma в инлайн-SVG
  (`Vector`, `Calling`, `Star`, `Check circle - Iconly Pro`), на них не
  было ссылок; в заголовке About добавлен пробел после `<br>`, иначе при
  скрытом переносе на Full HD слова склеивались.
- `footer.php` — три `filter0_d_*` второй модальной формы переименованы
  с суффиксом `-cf2` вместе со своими `url(#…)`.
- `js/main.js` — в `initProductsSlider` добавлен обработчик клавиатуры
  вкладок по WAI-ARIA: стрелки и Home/End двигают выбор вместе с фокусом.
  Второй системы управления не вводилось, поведение мыши и мобильного
  слайдера не менялось.

### CSS
Базовый уровень по регламенту — Full HD, поэтому Desktop-значения
перенесены в `max-width: 1599.98px`, планшетные — в `max-width: 991.98px`:

- **ABOUT** — Full HD: три карточки в ряд 1 : 1 : 1.5, блок заголовка 1389,
  заголовок в одну строку, статистика в две строки с горизонтальным
  разделителем, знаки 72px. Desktop возвращён целиком.
- **RESULTS** — Full HD: заголовок на всю ширину, ниже ряд «кейс 576 +
  четыре карточки 302». `.results__intro` переведён в `display: contents`,
  сетка на `grid` — разметка не дублируется, абсолютного позиционирования
  в основной сетке нет.
- **PRICING** — Full HD: кнопки столбиком справа от преимуществ, карточка
  цены 560. Tablet: две колонки 326 + 426, преимущества столбиком,
  кнопки в ряд, галочка позиционируется абсолютно (в макете она перекрывает
  верх текста).
- **DOC** — Full HD: левая колонка 503 и кнопки в ряд. Tablet: `display:
  contents` + `order` переставляют блок призыва вниз, карточки идут в ряд.
- **HOW** — в `max-width: 1199.98px` фиксированные ширины второй и третьей
  колонок заменены на `min()`: до 1050px значения макетные, ниже столбцы
  ужимаются вместе с окном. Скачка на границе 1200 нет.

Селекторов не удалено ни одного. Добавлено три новых:
`.about .section__title br`, `.pricing__actions .btn--primary`,
`.pricing__benefit:nth-child(3) .pricing__benefit-text br` — все
ограничены классами секций главной.

### Проверено
- Вертикаль всех 14 секций против трёх корневых фреймов Figma. Full HD:
  About 581 против 576, Results 572 против 564, Pricing 555 против 524,
  Developers 572 против 564 (было +234, +84, +66, +86). Tablet: Pricing
  716 против 712, Developers 1052 против 1024 (было +171 и +302).
  Desktop 1440 не изменился ни в одной секции.
- 16 ширин от 1920 до 320: `scrollWidth` равен ширине окна везде,
  обрезанного контента нет, диапазоны 992–1044 и 1200–1230 чистые.
- Шапка, мобильное меню, якоря, Products (вкладки, ARIA, клавиатура,
  крайние положения), Trusted, FAQ, Contacts, обе модалки, футер.
- Форма: 4 варианта услуг, 235 стран, пустая отправка даёт ошибки
  и **0 запросов** `admin-ajax`; раскладка Full HD сохранена.
- Дублей `id` в разметке темы не осталось; четыре оставшихся генерирует
  Lottie во время выполнения.
- PHP lint всех шаблонов, `node --check` для трёх JS-файлов.

---

## 2026-10-07 — сквозной приёмочный аудит главной (документация)

Кода не менял. Запись о проверке; найденные дефекты — `docs/BACKLOG.md`,
раздел «A — дефекты сквозного аудита».

### Что проверено заново на актуальном коде
- Вертикаль всей страницы против трёх корневых фреймов Figma на
  1920 / 1440 / 840 — все 14 секций, высоты и стыки.
- Contacts на Full HD: раскладка формы, Tab-порядок, ошибки, телефонный
  селектор (235 стран), список услуг, отсутствие дублей формы.
- Функциональность: шапка, мобильное меню, якоря, Products (6 вкладок,
  ARIA, клавиатура, крайние положения), Trusted (5 пинов, подсказки,
  hover и focus, мобильный список), FAQ, Blog, модалки.
- Blog с данными — через временный мок `mu-plugins/nv-blog-test-fixture.php`
  на 1, 2, 4 и 6 записей, с записью без обложки. **База не менялась**,
  мок удалён сразу после прогона, каталог `mu-plugins` удалён.
- Адаптивность на 16 ширинах от 1920 до 320.
- Регрессия шести страниц против состояния **до редизайна** (`3851075`).
- CSS-аудит: исчезнувшие и новые селекторы, область действия, переменные.
- Производительность: вес, запросы, блокирующие ресурсы, CLS.
- PHP lint всех шаблонов, баланс тегов, `wp_footer()`, дубли `id`.

### Главные результаты
- Регрессий на других страницах **нет**: 58 расхождений, все — координата
  `x` бегущей строки `.main__slider-track` на `/solutions/`.
- Форма Contacts на Full HD реализована по макету, координаты всех шести
  полей совпадают; форма на странице одна.
- Горизонтальной прокрутки нет ни на одной из 16 ширин.
- Найдено 6 дефектов P1, 5 P2, 3 P3. P0 нет.

### Исправлено в ходе аудита (не закоммичено)
Планшетный отступ между тизером и футером: в макете 840 между ними 128px,
в теме стояли 64px на всех ширинах. `body.home .teaser__wrapper` получил
`padding-bottom: 128px` в `max-width: 991.98px` и прежние 64px в
`max-width: 767.98px`. После правки тизер + футер: 844 против 843 на Full HD,
996 против 975 на Desktop, 1300 против 1280 на планшете — остаток
соответствует утверждённому объёму нижней строки. BACKLOG A-15.

### Обновлены документы
`docs/BACKLOG.md` (раздел A, находки A-01…A-14),
`docs/QA.md` (§7.6 — методика сквозного аудита),
`docs/CHANGELOG.md`, `docs/PROJECT_STATE.md`.

---

## 2026-10-07 — кнопка `.btn-hero` на главной: остатки тёмной темы

Локальная правка, к группе 9 не относится. Все три правила — под
`body.home`, кнопка на `/pricing-matrix/`, `/404/`, `/solutions/`, `/blog/`
и в архивах не затронута.

### По запросу пользователя
Стрелка в кнопке «Start Free Trial» была чёрной. SVG красится через
`currentColor`, а у `<button>` цвет не наследуется от `body` — браузер
подставлял собственный `rgb(0, 0, 0)`. Подпись оставалась белой только
потому, что у `.btn__text-hero` цвет задан отдельно.

Добавлено `color: var(--nv-constant-1)` в `body.home .btn-hero` — теперь
иконка `#F8F8F8`, как в макете.

### Найдено при проверке
1. На ховере подпись становилась `#2B323B`: унаследованное
   `.btn-hero:hover .btn__text-hero` (0,3,0) перебивало
   `body.home .btn__text-hero` (0,2,1). По фрейму `2386:28441` цвет на
   ховере не меняется — возвращён явным правилом.
2. На ховере кнопку забеливал круг-заливка `.btn-hero::before`
   (`#F9AA66 → #FF7759`) из тёмной темы: он лежит поверх заливки и давал
   бледно-оранжевый вместо сплошного `#FD6B01`. Отключён через
   `content: none` — тем же приёмом, что `body.home .contacts .btn-form::before`
   в группе 8.

### Проверено
- Пиксель заливки на ховере — ровно `rgb(253, 107, 1)` (#FD6B01),
  стрелка и подпись `rgb(248, 248, 248)` (#F8F8F8) в обоих состояниях.
- Поэлементный снимок `/solutions/`, `/pricing-matrix/`, `/docs/`,
  `/privacy-policy/`, `/blog/` (404), 404 на 1920/1440/840/375 — без
  изменений относительно состояния до группы 9.
- На главной `.btn-hero` отрисована одна: вторая, в скрытой секции
  `cases`, в DOM не попадает.

### Файлы
`css/styles.css` (+14 строк, 0 удалено), `docs/CHANGELOG.md`.

---

## 2026-10-06 — редизайн, группа 9: Teaser и Footer

Макеты: Desktop 1440 `655:11651`, Full HD 1920 `2380:23846`,
Tablet 840 `2376:17671`, ховеры `2386:37529`.

### Главное ограничение
Футер и тизер выводятся **на каждой странице темы**. Поэтому светлая версия
подключается только на главной:

- `footer.php` — прежняя тёмная разметка обёрнута в `else` ветки
  `if (is_front_page())`. Внутри блока `<footer>` не изменено ни символа.
  Cookie-баннер и обе модальные формы лежат ниже `endif` и общие для всех.
- `template-parts/footer-home.php` — новый шаблон светлого футера.
- `template-parts/teaser.php` — разметка общая, меняется только файл логотипа.
- CSS — два новых блока `TEASER HOME START/END` и `FOOTER HOME START/END`,
  все селекторы начинаются с `body.home`. Старые правила не трогались:
  `git diff` по `css/styles.css` — **604 строки добавлено, 0 удалено**.

### Что сделано
- Тизер: фон `--nv-surface-2`, «Page edge» из макета (`::before`, 64px,
  скругление 32 снизу), светлый бейдж логотипа, оранжевый знак, заголовок
  `--nv-object-1`, подзаголовок `--nv-primary`. Свечение и маскот не выводятся.
- Футер: карточка `--nv-surface-1` со скруглением 32 сверху и рамкой
  `--nv-surface-4`; левая колонка — логотип, слоган «Confidence in every client»,
  реквизиты, три знака сертификации; три колонки навигации; справа почта и
  соцсети; разделитель и нижняя строка.
- Full HD: знаки сертификации слева от реквизитов и крупнее (64 против 48),
  PRODUCTS в две подколонки по три, ссылки 18/24, зазор колонок 96.
- Tablet: три ряда — реквизиты, навигация, контакты.
- Ховеры по макету: цвет `--nv-primary`, фон кнопок `--nv-surface-3`.

### Ассеты
`img/footer_logo_light.svg`, `img/teaser_logo_primary.svg`,
`img/footer-badge-iso|asib|qa.webp` + `@2x`. Иконки — инлайн-SVG
с `currentColor`.

### Тексты — решения пользователя от 2026-10-06
Адресный блок взят из макета целиком:
«IFZA Business Park, DDP, PO Box 342001, Dubai, UAE» и
«Reg. 72252 · License 74254» (прежде в теме был только адрес без номеров).

Не перенесены: `top@nv.global` (верный адрес — `hello@nv.global`),
переименование нижних юридических ссылок, опечатка «RESOUECES».
Blog, Telegram и персональные адреса продуктов не выводятся, пока нет
реальных URL. Вертикальные рамки контентного блока по всей высоте страницы
решено не вводить. Подробности — BACKLOG R-22…R-28.

### Проверено
- Поэлементный снимок `/solutions/`, `/pricing-matrix/`, `/docs/`,
  `/privacy-policy/`, `/blog/` (404), 404 на 1920/1440/840/375 до и после:
  различий нет, кроме координаты `x` бегущей строки `.main__slider-track`
  на `/solutions/` — это работающая анимация.
- Принятые секции главной (`hero`…`contacts`) на 7 ширинах — **0 различий**.
- Вычисленные стили всех потомков `#callForm` и `#callForm2` на главной и
  на `/solutions/`, 1920/1440/840/375 — **0 различий**. Обе модалки
  открываются и закрываются по Escape.
- Геометрия против макета: ширина карточки 1856 / 1376 / 776; колонки
  навигации Full HD 0 / 279.8 / 504.5 (макет 0 / 280 / 505), Desktop
  0 / 175.9 / 361.3 (макет 0 / 176 / 361), Tablet 0 / 297.1 / 558.5
  (макет 0 / 297.5 / 558); высота тизера 416 / 468 / 468 — совпадает.
  После добавления строки «Reg. … License …» совпали и вертикали:
  Full HD ряд контента 246.9 (макет 247), разделитель 342.9 (343),
  нижняя строка 375.9 (375), карточка 427.9 (427); Desktop ряд 326.9 (327),
  блок реквизитов 87.9 (88), разделитель 422.9 (423), строка 455.9 (455).
- 18 ширин от 1920 до 375: горизонтального переполнения нет,
  `scrollWidth` равен ширине вьюпорта, за карточку футера ничего не выходит.
- Ссылок `href="#"` нет, все адреса отвечают 200. JS-ошибок нет,
  запросов с кодом ≥400 нет, POST-запросов формы не было.
- На `/solutions/`, `/docs/` и поиске футер и тизер остались тёмными,
  логотип прежний, маскот на месте.

### Известные расхождения с макетом
Нижняя строка выше макета: три юридические ссылки вместо двух и более
длинный текст товарного знака (R-25). Из-за этого карточка футера выше
на ~21px: 527.7 против 507 на Desktop. Вертикальные рамки контентного
блока реализованы только на 64px «Page edge» — по решению пользователя
так и остаётся (R-27).

### Файлы
`footer.php`, `template-parts/footer-home.php` (новый),
`template-parts/teaser.php`, `css/styles.css`,
`img/footer_logo_light.svg`, `img/teaser_logo_primary.svg`,
`img/footer-badge-{iso,asib,qa}.webp` и `@2x` (новые),
`docs/CHANGELOG.md`, `docs/COMPONENTS.md`, `docs/DECISIONS.md`,
`docs/BACKLOG.md`, `docs/QA.md`, `docs/PROJECT_STATE.md`.

---

## 2026-10-06 — редизайн, группа 8: Contacts

### Главное ограничение
Форма — **общий компонент**: `.contacts__form`, `.input-form*`,
`.phone-field*`, `.help-select*`, `.ui-check*`, `.btn-form` используются
модальной формой в `footer.php`, то есть на **каждой странице**, и в
`single.php`. Поэтому все новые правила ограничены не `body.home`,
а `body.home .contacts` — 142 селектора. Проверено отдельно: вычисленные
стили модалки на главной до и после правок совпадают полностью.

### Что изменено
Только оформление. Разметка формы, атрибуты полей, обработчики, валидация
и серверный путь не трогались. **JavaScript не менялся вовсе.**

- Заголовок и подзаголовок — по макету; третий абзац и нижний блок с тегами
  скрыты через `if (false)` (в макете их нет).
- Четыре пункта «Here's what you'll get» стали карточками с иконкой-галочкой;
  тексты из макета.
- Оранжевая карточка контактов: градиент, вылет за левый край экрана на
  Desktop, кнопка «Book a meeting instantly» на тёмном фоне. Добавлен блок
  мессенджеров — выводятся только те, у кого есть реальный адрес (сейчас
  только LinkedIn), заглушек `href="#"` нет (BACKLOG R-20).
- Поля: подпись 12/16, рамка `--nv-surface-4`, радиус 8, иконка в бейдже
  `--nv-primary-soft`, кнопка очистки 28×28, плейсхолдер `--nv-object-3`.
  Отступы уменьшены на толщину рамки — в Figma обводка внутри габарита.
- Стрелка селекта — градиентная кнопка из макета, кнопка отправки —
  градиент с иконкой перед текстом.

Иконки выгружены из Figma в `template-parts/contacts-icons.php`. У трёх
(`user`, `work`, `check`) в макете осталась тень из тёмной темы — фильтр
снят, `viewBox` пересчитан на артборд 24×24, заливка через `currentColor`.

### Что сохранено без изменений
`name`, `id`, `type`, `data-*` всех полей; `clientName`, `clientCompany`,
`clientEmail`, `clientPhone`, `clientPhoneCode`, `clientOption`,
`clientMessage`, `privacyConsent`; AJAX-действие `send_contacts_form`;
список из четырёх вариантов `Select your option...` с теми же `value`;
собственный телефонный селектор темы (`taodep_phone_country_list()`,
235 стран) — внешних библиотек не подключалось; текст согласия и ссылки
на документы; защита от повторной отправки в `form.js`.

### Проверено (без реальных заявок)
Запросы перехватывались Playwright, внешние сервисы блокировались.

- Поля и их типы на месте, все восемь имён совпадают.
- Пустая отправка: 4 блока с ошибкой, **0 запросов ушло**.
- `Select your option...`: 4 варианта в прежнем порядке, выбор пишет
  значение в `clientOption`.
- Телефон: список открывается, 235 стран, родительским `overflow` не
  обрезается, код меняется 44 → 355.
- Согласие отмечается кликом по боксу и по подписи.
- Ошибок JS нет.

**Ограничение:** на сайте включена hCaptcha, после валидации форма ждёт
токен. Решать настоящую капчу нельзя, поэтому запрос `send_contacts_form`
и серверная обработка не выполнялись — BACKLOG R-21.

### Геометрия
Ширины колонок и полей совпали с макетом: Full HD 459 + 48 + 1349, поле
638.5; Desktop 427 + 48 + 901, поле 414.5; Tablet 776, поле 360.

На Full HD форма разложена по макету `2380:23807`: слева четыре поля
подряд (зазор 12), справа селект и текстовое поле. Сделано на `grid`,
разметка одна, позиции заданы существующими классами — абсолютного
позиционирования и привязки к высоте содержимого нет, появление текста
ошибки раскладку не ломает. Все шесть координат совпали с макетом.

Разделителей в этом фрейме один — перед согласием; три
`.contacts__form-line` скрыты, линия нарисована рамкой блока согласия.
Ниже 1600 возвращается раскладка Desktop со всеми тремя разделителями.

### Регрессии
Главная на десяти ширинах: горизонтального скролла, выходов за вьюпорт,
ошибок и 404 нет. Ранее принятые секции сверены поэлементно на семи
ширинах — расхождений 0. Страницы вне главной — расхождений 0.
Потерянных правил в блоке CONTACTS нет.

---

## 2026-10-06 — редизайн, группа 7: FAQ

### Секция новая
На главной FAQ не было вовсе. Аккордеон с теми же классами `.faq__*` живёт
на `/solutions/`, поэтому **все новые правила ограничены `body.home`** —
оформление `/solutions/` не меняется.

Макеты: Full HD `2380:23774`, Desktop `2363:32515`, Tablet `2376:17599`,
спойлер `2363:32526` (открыт) / `2363:32527` (закрыт), ховер `2386:37430`.
Из четырёх присланных фреймов состояний к FAQ относится только `2386:37419`;
`2386:37529` оказался Footer.

### Контент
Восемь вопросов из макета. **Ответ в Figma есть только у первого** — у
остальных семи узла ответа нет вовсе. Тексты не придумывались: вопрос без
ответа выводится обычной строкой, без кнопки раскрытия и без пустой панели.
Таблица соответствия со старыми вопросами темы и список недостающих
текстов — BACKLOG R-18.

Контент лежит массивом `$nv_faq_items` в `main-page.php`: когда ответы
утвердят, достаточно дописать строки — разметка и механика уже готовы.

### Аккордеон переиспользован
`initFaq()` не переписывался, второй обработчик не добавлялся. Внесены две
правки, обе безопасны для `/solutions/`:

- `syncExpanded()` обновляет `aria-expanded` **только если атрибут есть
  в разметке**; на `/solutions/` его нет, поведение там не меняется;
- элемент, открытый прямо в разметке, больше не схлопывается при
  инициализации (в обоих фреймах макета первый вопрос раскрыт).

Поведение single-open сохранено. Вопрос сделан нативным `<button>` —
Enter и Space работают без дублирующей обработки клавиатуры.
Добавлены `aria-controls`, `role="region"` и `aria-labelledby`.

### Высота панели
`initFaq` считает высоту по содержимому и вертикальным полям текста, причём
ниже 768px прибавляет 32 вместо 48. Поэтому отступы ответа заданы через
`margin` текста, а не через `padding` панели, и правило `margin: 16px 0`
стоит в блоке `767.98` — ровно там, где переключается расчёт в JS.
Жёсткого `max-height` нет, длинный ответ не обрезается.

Анимация раскрытия отключается при `prefers-reduced-motion: reduce`.

### Иконка
Шеврон `Arrow - Down 2 - Iconly Pro` из макета совпал с SVG, который уже
используется в FAQ на `/solutions/` (различия только в округлении координат).
Переиспользован существующий, повторно из Figma не выгружался.

### Проверено
Ширины колонок совпали с макетом точно: 440 + 48 + 1368 (Full HD),
440 + 48 + 888 (Desktop), 776 (Tablet).

Аккордеон (ответы подставлены DOM-фикстурой в браузере, в шаблон и базу
ничего не писалось): открытие, закрытие повторным нажатием, переключение
между вопросами с закрытием предыдущего, длинный ответ без обрезки
(панель 243 при тексте 195 + 48 полей), Enter и Space, `:focus-visible`
с видимой обводкой, `aria-expanded` синхронизирован. Ширина страницы
не меняется ни на одном шаге, ошибок JS нет.

Главная на десяти ширинах: горизонтального скролла, выходов за вьюпорт,
ошибок и 404 нет. Ранее принятые секции сверены поэлементно на семи
ширинах — расхождений 0. Страницы вне главной, включая `/solutions/`
с теми же классами, сверены с состоянием до редизайна — расхождений 0.

### Высота строк приведена к макету
Figma рисует обводки **внутрь** габарита, CSS — снаружи, поэтому сначала
закрытая строка выходила 92px против 88. Корректный перевод — вычесть
толщину рамки из паддинга: расстояние от внешнего края до вложенного блока
остаётся ровно 16 (и 12 у шапки), а 1px рамки занимает первый пиксель этого
отступа — ровно как в макете.

Паддинги: карточка `15px` при рамке 1px, шапка `11px 11px 11px 23px` при
рамке обёртки 1px. Закрытая строка теперь **ровно 88px**.

Остаётся 1px на раскрытой карточке: 193 против 192. Причина — пунктирный
разделитель: в Figma это нижняя обводка шапки (внутри её 56px), в разметке
темы — `border-top` панели ответа. Переносить разделитель значило бы менять
структуру, от которой зависит расчёт высоты в `initFaq`.

---

## 2026-10-06 — редизайн, группа 6: Blog

### Исходное состояние отличалось от ожидаемого
Секция Blog на главной была **полностью статической**: пять захардкоженных
карточек с Lorem ipsum, «Elon Musk / CEO of Tesla» и картинками темы,
без `WP_Query`, `have_posts()` и `get_permalink()`. Кнопка «Explore All
Articles» вела на `href="#"`. Сама секция была скрыта правилом
`.news { display: none }` — оно пришло с темой, до редизайна.

Реальный динамический вывод записей живёт в `template-parts/article-card.php`
и используется на `/blog/`, в архивах и поиске.

### Что сделано
Статическая разметка заменена на `WP_Query`:

```
post_type=post, post_status=publish, posts_per_page=4,
orderby=date, order=DESC, ignore_sticky_posts, no_found_rows
```

`posts_per_page=4` — в макете ровно четыре карточки на всех трёх фреймах.

Карточка вынесена в новый `template-parts/news-card.php`. Логика данных та
же, что в `article-card.php` (просмотры и лайки из post meta, автор из
`first_name`/`last_name` с откатом на `display_name`, должность из
`job_title`, аватар через `get_avatar`, время чтения 200 слов в минуту,
анонс `wp_trim_words(get_the_excerpt(), 32)`). Общий шаблон не
переиспользован намеренно: у него другие классы и оформление, менять его
нельзя, чтобы не задеть `/blog/` и архивы.

Правило `.news { display: none }` снято: секция выводится только при наличии
опубликованных записей, иначе не рендерится вовсе.

### Оформление по макету
Фреймы: Full HD `2380:23753`, Desktop `318:9382`, Tablet `2376:17578`,
карточка `830:11701`, ховер `2386:37293`.

Карточка 580px высотой на всех трёх фреймах, ширина 452 / 332 / 360,
зазор 16. На Full HD и Desktop четыре карточки ровно заполняют контейнер,
прокрутка не нужна; на планшете они шире контейнера — там работает слайдер.

**Стрелок навигации в макете нет ни на одном фрейме** — прежние
`.news__arrow` убраны. JS к их отсутствию готов (все обращения под
проверками), переключение осталось свайпом.

Ховер: фон карточки `#F2F2F2 → #E4E4E4`, блок автора наоборот. То же
состояние повторено на `:focus-within`, чтобы работала клавиатура.

### Слайдер
`initNewsSlider` сохранён. Изменён один параметр: вместо `slidesPerView`
с брейкпоинтами — `slidesPerView: 'auto'`, ширина слайда задаётся CSS по
макету. Инициализация по-прежнему только ниже 1200px, выше — обычный ряд.
Бесконечная прокрутка, автопрокрутка и новые библиотеки не добавлялись.

### Проверено
Пустое состояние (записей 0): секции нет в DOM, пустых контейнеров и
нерабочих стрелок нет, ошибок консоли и 404 нет.

С публикациями — через временный мок, не затрагивающий базу (см. `QA.md`):
1, 2, 4 записи; длинные и короткие заголовки; запись без обложки; разная
длина текста. Ширины карточек совпали с макетом на 1920 / 1440 / 840 / 375;
слайдер не прокручивается, когда карточки помещаются, и прокручивается,
когда нет. Все ссылки ведут на реальные адреса, заглушек `href="#"` нет.

Главная на десяти ширинах: горизонтального скролла, выходов за вьюпорт,
ошибок и 404 нет. Ранее принятые секции сверены поэлементно на семи
ширинах — расхождений 0. `/solutions/`, `/pricing-matrix/`, `/docs/`,
`/privacy-policy/`, `/blog/` и 404 сверены с состоянием до редизайна —
расхождений 0.

---

## 2026-10-06 — редизайн, группа 5: How it works, Why us

### How it works (`.how`) — новая секция
Вставлена между Products и Why us. Три блока — шаги, оранжевая плашка,
блоки размещения — переставляются на каждом из трёх макетов, поэтому
`.how__layout` сделан через `grid`: разметка одна, меняются только колонки.

- Full HD `2380:23002` — слева шаги, справа сверху два блока размещения,
  под ними широкая плашка.
- Desktop `2298:32163` — три колонки.
- Tablet `2376:16830` — шаги и плашка в ряд, блоки размещения под ними.
- ≤767.98 — одна колонка, мобильного макета нет.

Между фреймами меняются и размеры: номер шага 52/64 → 40/52, заголовок
плашки H2 → H3, заголовок блока размещения H3 → H4, угол градиента
171° → 122°. Все значения в `COMPONENTS.md`, раздел 15.

### Why us (`.advantages`) — переписана
Было восемь карточек с иконками и маскотом, стало шесть карточек вокруг
снимков экранов приложения (`2380:23078`, `291:7937`, `2376:16906`).

На планшете карточки идут построчно, а в разметке разложены по колонкам.
Чтобы не дублировать разметку, колонкам задан `display: contents` — все
шесть карточек попадают в общую сетку в порядке макета.

Правила старой вёрстки (`.advantages__row*`, `.advantages__col-1/-2`,
`.advantage__item-icon`, `.advantage__item--image-hover`) оставлены: их
используют `index.php` и `main-page-video-autoplay.php`. Ховер старых
карточек ограничен `.advantages__list`, чтобы не задеть новую вёрстку.
Расхождение запасных шаблонов с главной вынесено в BACKLOG R-16.

### Изображения
Все выгружены из Figma, ничего не дорисовано:

- `img/how-cloud.webp` 239×239 (8 КБ) + `@2x`;
- `img/how-onprem.webp` 217×217 (5 КБ) + `@2x`;
- `img/why-us-phones.webp` 434×525 (29 КБ) + `@2x` — собран из оригинальных
  ассетов макета (рамка телефона, SVG-маска, снимок экрана под маской)
  с той же геометрией и отрисован в растр с прозрачностью.

Иконка плашки — inline SVG с `currentColor`, родной `viewBox` сохранён.

### Проверено
Главная на 1920 / 1600 / 1440 / 1200 / 992 / 840 / 768 / 576 / 392 / 375:
горизонтального скролла, выходов за вьюпорт, ошибок консоли и 404 нет.

Принятые секции групп 1–4 (`hero`, `about`, `results`, `solutions`,
`products`, `pricing`, `doc`) сверены поэлементно на семи ширинах —
**расхождений 0**. В `clients` добавился ровно один элемент (карта),
высоты не изменились.

Страницы `/solutions/`, `/pricing-matrix/`, `/docs/`, `/privacy-policy/`,
`/blog/` и 404 сверены с состоянием до редизайна на четырёх ширинах —
**расхождений 0**.

Новых брейкпоинтов нет, `line-height` в px нет, новых глобальных
селекторов вне главной нет.

---

## 2026-10-06 — Trusted: фон карты мира и точные позиции пинов (R-14)

### Как получена карта
Одним файлом Figma MCP её не отдаёт: 406 отдельных векторов, рендера узла
целиком у сервера ассетов нет, `get_screenshot` ограничен 1024px, без альфы
и с пинами поверх. Поэтому карта собрана из тех же оригинальных векторов:
позиции — из `get_metadata` с полной точностью, сопоставление вектор - ассет —
из `get_design_context` по двум подгруппам (на 46 пересекающихся узлах оба
источника совпали), затем сборка в один SVG и отрисовка в растр с альфой.

Файлы: `img/clients-map.webp` (1376x340, 33 КБ), `img/clients-map@2x.webp`
(71 КБ). Обрезано по верхним 340px из 679 — ниже карта в полосу не попадает
ни в одном из трёх макетов.

Сверка с эталонным скриншотом Figma: по области карты среднее отклонение
0.28% на канал.

### Исправлены позиции пинов
При сверке выяснилось, что принятые в группе 4 координаты расходились
с макетом:

- по вертикали все пять пинов были ниже на 72px;
- на ширинах свыше 1376 пины расползались по ширине полосы, тогда как
  в макете это блок 1376, который просто центрируется (на FullHD x каждого
  пина ровно +240 = (1856 - 1376) / 2, y совпадают).

Теперь все 15 координат (5 пинов x 3 макета: FullHD, Desktop, Tablet)
совпадают с Figma с точностью до пикселя.

### Прочее
Затухание карты к низу полосы в макете — растровый `Rectangle 3922`
с градиентом от прозрачного к #F8F8F8; воспроизведено средствами CSS,
отдельный файл не понадобился.

Полосе нельзя давать `overflow: hidden` — подсказки пинов по макету выходят
выше полосы и были бы срезаны. Карта обрезается собственным `clip-path`.

### Проверено
Позиции пинов и геометрия карты на 1920 / 1440 / 840 — совпадение с Figma.
Главная на десяти ширинах: горизонтального скролла, выходов за вьюпорт,
ошибок консоли и 404 нет. Подсказка открывается по наведению и по
клавиатурному фокусу, не срезается. На <=767.98 карта и затухание скрыты,
остаётся список отраслей.

---

## 2026-10-06 — редизайн, группа 4: Trusted, Pricing, Developers

### Trusted by Industry Leaders Worldwide (`.clients`)
Секция переведена на светлую тему. Полоса карты 1376×293, пять пинов
`img/clients__pin.svg` размещены в процентах от полосы по точным координатам
макета `297:8202`: Banks 11.555%/69.625%, Crypto 27.253%/34.471%,
Government 47.820%/53.925%, Insurance 67.442%/53.242%, Gambling 82.413%/44.710%.
Тултип — `bottom: 95px`, ширина 160, радиус 16, фон `--nv-surface-1`,
рамка `--nv-surface-4`.

Фон карты не добавлен: в Figma это 406 отдельных векторов, нужен экспорт
одним файлом — **BACKLOG R-14**.

На ≤575.98 карта уходит, остаётся вертикальный список отраслей с иконками.

### Pricing (`.pricing`)
Секция новая, написана с нуля по `2363:30854`. Левая карточка с ценой
`from $0.24`, правая сетка из трёх преимуществ, снизу две кнопки
(`Talk to sales`, `Calculate your price`). Все кнопки получили блок
`.pricing .btn` — без него они наследовали прежний `#F9AA66`.

### Developers (`.doc`)
Секция `documentation` перерисована по `2363:32425`: слева заголовок,
описание и две кнопки, справа две карточки документации и оранжевый блок
`Developer Support`. Данные по-прежнему из `get_field()`, подстановок нет.

### Проверено
Главная на 1920 / 1600 / 1440 / 1200 / 992 / 840 / 768 / 576 / 392 / 375:
горизонтального скролла нет, выходов за вьюпорт нет, ошибок консоли и 404 нет.

---

## 2026-10-06 — восстановлены чужие правила, потерянные при переписывании секций

### Причина
Секции переписывались целиком между маркерами `/* X START */ … /* X END */`.
Внутри этих блоков лежали правила **других** компонентов, в том числе внутри
`@media`, и уходили вместе с секцией. Проверка «чужих» селекторов смотрела
только правила верхнего уровня и такие случаи не видела.

### Что восстановлено
- `DOC`: `@media 767.98 { .btn--black span { font-size: 16px } }` и ещё
  14 правил `.btn--black*` — из-за потери `section.cta` на `/solutions/`
  вырастала на 2px.
- `CLIENTS`: `.company__item`.
- `ABOUT`: `@media 1199.98 { .teaser__maskot.teaser__maskot--about }` —
  используется шаблоном `main-page-video-autoplay.php`.
- Базовый блок кнопок: `.btn-hero` (база), `.btn__text-hero` и три правила
  `:hover` / `.is-active`. Группа 1 переписала их **глобально**, из-за чего
  на `/pricing-matrix/`, `/404/`, `/blog/` и в архивах кнопка теряла фон
  (`var(--nv-gradient)` объявлена только в `body.home`), высота падала
  64 → 40, радиус 16 → 8, текст оставался нестилизованным.
  Исходные правила возвращены, новый вид ограничен `body.home`.

### Проверено
Поэлементное сравнение с CSS до редизайна (коммит `3851075`) —
`/solutions/`, `/pricing-matrix/`, `/docs/`, `/privacy-policy/`, `/blog/`, 404
на ширинах 1920 / 1440 / 840 / 375. Сверялись координаты, размеры, цвет текста,
цвет фона и кегль каждого видимого элемента.

**Расхождений 0 на всех 24 комбинациях.** Единственное отличие —
равномерный сдвиг бегущей строки `.main__slider-track` на `/solutions/`
(фаза анимации; размеры и цвета совпадают).

---

## 2026-10-06 — исправлен виджет прокрутки наверх

### Причина
`.top__widget` зафиксирован `left: 32px; bottom: 42px; z-index: 7` и живёт
в `footer.php`, то есть на всех страницах. На ширинах ≤575.98 тема сама
переносит чат-виджет NeVi влево правилом
`.wp-singular .web-chat-widget .wc-right-4 { left: 1rem !important }`.
Класс `wp-singular` есть на всех пяти страницах сайта.

В итоге на телефонах кнопка «наверх» (44×44, `z-index: 7`) оказывалась
**целиком внутри** кнопки чата (72×72, `z-index: 9998`) и переставала нажиматься.

### Исправление
В блоке `@media (max-width: 575.98px)` базовой части `styles.css` кнопка
переносится к правому краю: `left: auto; right: 16px`. Виджеты разведены
по разным сторонам, `z-index` не трогался, ничего не отключалось и не скрывалось.

Попутно кнопка приведена к светлой теме на главной (`body.home`): прежние
`#F9AA66` и тёмная рамка выбивались из новой палитры. На остальных страницах
вид прежний.

### Проверено
Пять страниц × ширины 840 / 768 / 576 / 392 / 375: пересечения с чатом нет
нигде, кнопка кликабельна везде. Отдельная проверка восьми кнопок главной
(Hero, About, Products): **перехвата клика нет ни на одной ширине**.

---

## 2026-10-06 — редизайн, группа 3: слайдер Our AI-Powered Identity Solutions

### Слайдер
Шесть слайдов по макетам Figma вместо прежних семи. Тексты вкладок, заголовков,
подзаголовков и описаний сверены с макетом дословно — 6 из 6 совпадений.
Кнопка «Learn more» только на слайдах 1 и 3: на остальных её слой в макете
помечен `hidden="true"`. Обе ведут на `/solutions/#solutions`.

Изображения слайдов из макета убраны — в новом дизайне карточка содержит
только вкладки, стрелки, текст и кнопку. Файлы `img/products-image*.jpg`
не удалялись.

### JS — две минимальные правки, логика не переписывалась
1. Слайдер картинок сделан опциональным: прежний `initMobileSwipers` выходил,
   если блока изображений нет, и мобильный свайп контента не инициализировался.
2. `updateTabs` синхронизирует `aria-selected` и roving `tabindex`.

Вся остальная механика (вкладки, стрелки, disabled на краях без зацикливания,
клавиатура, переинициализация Swiper по брейкпоинту) работала и сохранена.

### Доступность
Вкладки получили `role="tablist"` / `role="tab"` / `aria-controls`,
слайды — `role="tabpanel"` / `aria-labelledby`, стрелки — `aria-label`.
Закрывает B-13 для этой секции.

### Оформление
Секция оформлена как скруглённая «страница» (компонент Page edge из макета —
это рамка с радиусом 32, отдельной разметки не потребовалось).
Ниже 1200px — схема планшетного фрейма через `display: contents` и `order`.

### Исправлено по ходу
- Ширина кнопок на телефонах: базовый `.btn` ограничен `max-width: fit-content`,
  из-за чего в колонке кнопки выходили разной ширины.
- Перестроение в одну колонку перенесено с 991.98 на 1199.98: между ними
  карточке оставалось 458px и вкладки занимали по строке каждая.

### Проверено
PHP-линт и `node --check` чисты. Все шесть слайдов проверены через вкладки,
стрелки и клавиатуру; высота секции 674 на каждом слайде — скачков нет;
на краях кнопки блокируются, зацикливания нет. Hover вкладки, стрелки и трёх
кнопок замерен по фрейму `2386:28499` и совпадает. Девять ширин от 1920 до 375:
переполнения, выходов за карточку и ошибок нет. Группы 1 и 2 — геометрия
не изменилась ни в одном замере.

---

## 2026-10-05 (5) — редизайн, группа 2: About, Results, Industry Solutions

### Общие компоненты светлой темы
В секцию HOME THEME добавлены ограниченные `body.home` правила для `.section`,
`.section__badge`, `.section__title`, `.section__title span`, `.section__subtitle`,
`.section__title-block`. Эти классы используются ещё на `/solutions/`,
`/pricing-matrix/` и 404 — без ограничения перекраска сломала бы их.

### About
Разметка приведена к макету `291:5892`. Убраны блок `.about__description`,
картинка «verified by» и маскот — в макете их нет. Добавлены вторая колонка
статистики с разделителем и карточка с крупной формулировкой.
Логотипы сертификатов остались вложениями WordPress (`td_image`), статикой не подменялись.

### Results
Новая секция между About и Industry Solutions по макету `2363:33982`.
Карточка кейса с выходящей за угол 3D-иллюстрацией, плашки результатов,
четыре карточки статистики. Сетка 2×2 собрана на Flexbox, а не Grid.

### Industry Solutions
`.solutions__item` структурно уже совпадал с макетом — изменены только цвета.
`.solutions__content` переведён с Grid на Flexbox-колонку: маскота в макете нет.
Карточек по-прежнему шесть, состав и тексты — по макету `2363:33911`.
Пять иконок из шести переиспользованы из темы (тот же экспорт Figma),
добавлена только иконка Crypto Exchanges.

### Ассеты
`img/results-bank.webp` (276×276, 44 KB), `img/results-bank@2x.webp` (552×552, 118 KB).

### Проверено
PHP-линт чист. Геометрия совпадает с макетом: блок заголовка About 1048×204
(H2 1048×104, лид 1048×84), карточки About 680×186 и 1376×192, карточки Results
376×211 при колонке интро 560, карточки Industry Solutions 448×200, иконка 24×24
в боксе 34×34. Цвета, радиусы, отступы и типографика — по токенам.

### Открытые вопросы
R-09 убраны шесть ссылок «Learn more» на `/solutions/` (в макете их нет);
R-10 Insurance заменён на Telecom; R-11 бренд в макете без «Systems».

---

## 2026-10-05 (4) — редизайн, группа 1: основа, шапка, Hero

Первая группа редизайна главной. Правки в рабочем коде темы.

### Основа (ограничена `body.home`)
Новая секция `/* HOME THEME START ... END */` в `css/styles.css` перед секцией MENU:
палитра светлой темы токенами с префиксом `--nv-` и сетка макета.

Префикс выбран, чтобы не пересекаться с семейством `--island-*` / `--text-white-*` /
`--stroke-white-*`: те 384 раза используются с fallback и нигде не объявлены
(`docs/THEME-TODO.md`, раздел 1). Ни одна из старых переменных не объявлена.

Сетка: `body.home .container { max-width: 1920px; padding: 0 32px }` — контент равен
ширине экрана минус 64 на всех трёх фреймах. Общий `.container` не тронут (Р-9).

### Шапка
Только палитра (Р-10): состав навигации прежний. Светлая подложка `#F2F2F2`,
текст `#212121`, кнопка Inquire — оранжевый градиент. Шапка выведена в поток
(`position: relative`), логотип на главной скрыт — в макете он лежит внутри карточки Hero.
`header.php` **не изменялся**.

### Hero
Разметка в `main-page.php` переписана под макет: карточка со скруглением 32,
фотофон, логотип в левом верхнем углу, заголовок и подзаголовок слева внизу,
две кнопки справа внизу. Классы `.hero__wrapper`, `.hero__content`, `.hero__title`,
`.verify`, `.hero__actions`, `.btn-hero`, `.btn--gray` сохранены, обработчики
`open-callForm2` и ссылка на `/pricing-matrix/` работают по-прежнему.

Фоновое видео заменено фотографией из макета. Элемент `.hero_gradient` удалён:
сверка рендера Figma с экспортом фото дала отклонение 0.00 — отдельного
затемняющего слоя в макете нет.

`.btn-hero` переведена с `height: 64px` на `padding` + `min-height` — попутно
закрывает B-15 для этой кнопки.

### Скрыты секции без пары в макете (Р-11)
`page-nav`, `video-intro`, `cases`, `promo` обёрнуты в `<?php if (false) : ?>`.
Разметка и CSS на месте. Все связанные функции `main.js` безопасно выходят при
отсутствии элементов — проверено.

### Ассеты
Добавлены `img/hero-bg.webp` (1856×1006, 52 KB) и `img/hero-bg@2x.webp`
(3712×2012, 156 KB) — из исходника Figma 3918×2124 PNG 9.9 MB.
Добавлен `img/logo-hero.svg` (206×39) — логотип для карточки.
Стрелка в кнопках — inline SVG: path из Figma побайтово совпал с уже имеющимся
в теме, использован существующий с `fill="currentColor"`.

### Проверено
PHP-линт всех файлов чист. Геометрия совпадает с макетом точно: контент
1856 / 1376 / 776 при 1920 / 1440 / 840, карточка 1856×872, 1376×732, 776×872,
радиус 32. Логотип и контент внутри карточки — на тех же координатах, что в Figma.
Попиксельная сверка карточки с рендером Figma: среднее отклонение 1.26%,
по зоне фотографии 0.3% пикселей — геометрия и кадрирование верны.
Горизонтального переполнения нет, ошибок консоли и 404 нет.
`/solutions/` сохранила тёмный фон и прежний контейнер — регрессии нет.

### Осталось расхождение с макетом
Шапка: в макете 5 пунктов и две кнопки, в теме прежние 9 якорей и Inquire — по Р-10.

---

## 2026-10-05 (3) — анализ макетов главной страницы

**Код темы не изменялся.** Только анализ Figma и документация.

### Выполнено
Разобраны три макета главной (Full HD 1920, Desktop 1440, Tablet 840) и два фрейма
состояний. Построена карта из 14 секций с node-id по каждому макету, получены токены
дизайн-системы, составлена таблица соответствия «Figma ↔ PHP / CSS / JS».

### Ключевые результаты
- Все три макета содержат **14 видимых секций в одинаковом порядке**, 1:1.
  Пять слоёв верхнего уровня помечены `hidden="true"` и в расчёт не идут.
- Сетка едина: контент = ширина фрейма − 64, боковое поле 32px.
  **При 1440 тема совпадает с макетом точно (1376px).** При 1920 и 840 — расходится.
- **Шрифт и шкала типографики уже совпадают:** Satoshi, H2 = 40/52/700 и там, и там.
- Основное изменение — **инверсия палитры**: фон `#212121` → `#F8F8F8`,
  текст `#FBFBFB` → `#212121`, акцент `#F9AA66` → `#FD6B01`.
- Блок Trusted: подписи в теме **дословно совпадают** с Figma, порядок тот же —
  правятся только цвета.

### Разрешены противоречия в задании
- **FAQ** находится не в ноде футера (`2386:37529` — это только hover-состояния футера),
  а в секции 12 основного макета (`2363:32515`).
- **Mobile-макета нет**: нода, указанная и для Tablet, и для Mobile, — фрейм 840px.

### Обновлена документация
`docs/FIGMA.md` — ссылки, подтверждённые node-id, размеры фреймов, сетка, токены;
`docs/COMPONENTS.md` — карта редизайна и список готовых к переиспользованию компонентов;
`docs/BACKLOG.md` — восемь вопросов R-01…R-08, два из них блокирующие.

### Блокирующее
R-01 отсутствует Mobile-макет; R-02 в FAQ восемь вопросов, но текст ответа есть только у первого.

---

## 2026-10-05 (2) — решения по реорганизации, режим редизайна

### Решения зафиксированы
Создан `docs/DECISIONS.md` — семь решений по реорганизации + правила основного режима
работы (прямой редизайн темы по Figma). Документ имеет приоритет над `REFACTOR_PLAN.md`.

### Проверки, выполненные под решения
- **Р-2 `main-page-video-autoplay.php`:** шаблон не используется ни одной записью
  (все статусы, включая корзину); ноль упоминаний в `wp_options` и `wp_postmeta`;
  **найдены две ACF-группы**, ссылающиеся на него как на альтернативную локацию —
  «Главная страница» (#67) и «Отзывы» (#557). Файл оставлен.
- **Р-3 GLightbox:** `class="glightbox"` в шаблонах — 0; в живом DOM шести страниц
  `.glightbox` / `[data-glightbox]` / `[data-gallery]` — по нулю. Не восстанавливаем.
- **Р-7 `img/info.svg`:** в git-истории темы файла не было никогда; найден в родительской
  теме `neurovision` с идентичным правилом `.packages__service-icon`. Ждёт решения.
- **Р-1 изображения:** проверка ссылок доведена до БД, `uploads/` и плагинов.

### ⚠️ Поправка к аудиту: `*.png.webp` — живые файлы
31 файл вида `name.png.webp` первичный аудит ошибочно отнёс к неиспользуемым.
Это **WebP-двойники Seraphinite Accelerator** (`seraph-accel-img-compr-redir.conf`
в корне сайта, плагин `seraphinite-accelerator-ext`). Для каждого из 31 исходный
`.png`/`.jpg` используется в коде темы. Их удаление не дало бы ни визуальной поломки,
ни ошибок в тестах — но молча вернуло бы прод к выдаче тяжёлых PNG.

### Изменения в ассетах
- **Удалён** `img/flow_step1 (1).png` — 45 KB, побайтовая копия `flow_step1.png`
  (одинаковый md5), ноль ссылок где-либо. Единственный файл, прошедший критерий
  «доказанный дубликат».

### Обновлена документация
- `CLAUDE.md` — режим редизайна, карта документов, запрет трогать `*.png.webp`.
- `docs/FIGMA.md` — новый раздел «Работа с Desktop-only макетами».
- `docs/PROJECT_STATE.md` — находка про Seraphinite, переписан раздел 9; убраны
  креды БД и абсолютные домашние пути.
- `docs/BACKLOG.md` — статусы B-01, B-02, B-03, B-06, B-10; добавлен B-10a.
- `docs/REFACTOR_PLAN.md` — статусы этапов R1–R6 по принятым решениям.
- `docs/QA.md` — устойчивый способ найти Playwright вместо жёсткого пути.

### Проверено
PHP-линт всех файлов; baseline Playwright на 4 страницах × 5 вьюпортов после удаления
файла — высоты документа совпали с эталоном до единицы, горизонтального переполнения нет,
число ошибок консоли не изменилось.

### Решения, принятые по итогам
- **`img/info.svg` (Р-7): не копировать из темы neurovision, ждать иконку из Figma.**
  404 на `/pricing-matrix/` остаётся до редизайна страницы и считается ожидаемым
  состоянием, а не регрессией.
- **Git (Р-8): постоянная рабочая ветка `dev`.** Ветка `docs/initial-setup`
  переименована в `dev`. В `main` напрямую не коммитим.

### Открытый вопрос
Судьба `header_24.06.26.php` и `template-parts/teaser_10.04.26.php` — бэкапы по дате,
дублируют git, ни на что не влияют.

---

## 2026-10-05 — первоначальная настройка: аудит и документация

**Код темы не изменялся. Редизайн не начат.**

### Создано (только документация)
- `CLAUDE.md`
- `docs/PROJECT_STATE.md`
- `docs/FRONTEND.md`
- `docs/WORDPRESS.md`
- `docs/COMPONENTS.md`
- `docs/FIGMA.md` (статус `WAITING_FOR_FIGMA`)
- `docs/QA.md`
- `docs/BACKLOG.md`
- `docs/THEME-TODO.md`
- `docs/REFACTOR_PLAN.md`
- `docs/CHANGELOG.md`

### Не изменялось
PHP, CSS, JS, изображения, шрифты, видео, `functions.php`, БД, настройки WordPress,
состав плагинов, активная тема.

### Чем проверено
- `php -l` по всем 41 PHP-файлу темы (PHP 8.3.30) — ошибок нет.
- HTTP-статусы 8 маршрутов через `curl -k`.
- Playwright + Chromium: 4 страницы × 5 вьюпортов (1920 / 1440 / 840 / 392 / 375) —
  скриншоты, высота документа, горизонтальное переполнение, ошибки консоли,
  неуспешные запросы. Baseline зафиксирован в `docs/QA.md`.
- Запросы к БД `nvglobal` через PHP CLI + mysqli: опции, шаблоны страниц,
  типы записей, ACF-группы и их привязки, таксономии, меню, плагины.
- Проверка `window.*` в браузере: наличие Swiper, GSAP, MicroModal, Lottie,
  LocomotiveScroll; отсутствие GLightbox и Siema; незаявленность CSS-токенов.

### Ключевое из найденного
- Главная — `main-page.php` (страница 420), не `index.php`.
- Вёрстка почти полностью статическая; `page-solutions.php` — 0 вызовов ACF/WP_Query/esc.
- Структура CSS и все 8 брейкпоинтов **уже совпадают** с регламентом NeuroVision.
- 384 обращения `var()` к 11 **необъявленным** токенам, у 5 расходятся fallback’и.
- `img/info.svg` отсутствует → 404 на `/pricing-matrix/`.
- GLightbox нигде не подключён — лайтбокс не работает, молча.
- ACF-группа «Главная страница» (14 полей) шаблоном не читается.
- ~50 MB неиспользуемых изображений в `img/`.
- Горизонтального переполнения нет ни на одной странице и вьюпорте.

Подробности — `docs/PROJECT_STATE.md`, список задач — `docs/BACKLOG.md`,
план работ — `docs/REFACTOR_PLAN.md`.
