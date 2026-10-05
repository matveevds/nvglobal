# COMPONENTS — каталог того, что уже есть

Собрано чтением шаблонов и `css/styles.css` 2026-10-05.
Перед созданием нового компонента смотреть сюда.

---

## 1. Главная — `main-page.php` → `/`

15 секций. Номера строк — на момент аудита, ориентир, а не адрес.

| # | Строка | Разметка | CSS-секция | Якорь | Данные |
|---|---|---|---|---|---|
| 1 | 26 | `.hero` | `HERO END` (1501) | — | статика + canvas-анимация |
| 2 | 60 | `.page-nav` | `PAGE-NAV` (1503–1741) | — | `data-threshold="2200"` |
| 3 | 102 | `.about.section` | `ABOUT` (1744–2080) | `#about` | статика |
| 4 | 187 | `.video-intro.section` | `VIDEO INTRO` (2082–2212) | `#get-to-know` | статика + video |
| 5 | 251 | `.solutions.section` | `SOLUTIONS` (2214–2405) | `#solutions` | статика |
| 6 | 501 | `.products.section` | `PRODUCTS` (2408–2928) | `#products` | статика, 7 слайдов |
| 7 | 857 | `.advantages.section` | `advantages` (2932–3301) | `#advantages` | статика |
| 8 | 968 | `.clients.section` | `CLIENTS` (3304–3824) | `#clients` | статика |
| 9 | 1049 | `.testimonials.section` | `TESTIMONIALS` (3826–4061) | — | **ACF `reviews`, выключена `if (false)` на 1048** |
| 10 | 1164 | `.cases.section` | `CASES` (4063–4486) | `#cases` | статика, 3 кейса |
| 11 | 1342 | `.doc.section` | `DOC` (4488–4929) | `#documentation` | статика, табы |
| 12 | 1471 | `.news.section` | `NEWS` (4932–5312) | — | статика, 5 карточек |
| 13 | 1755 | `.promo.section` | `PROMO` (5314–5574) | — | статика |
| 14 | 1812 | `.contacts.section` | `CONTACTS` (5577–6375) | `#contacts` | форма |
| — | 2311 | inline `<style>` + `<script>` | — | — | CSS/JS фонового видео hero |

---

## 2. Solutions — `page-solutions.php` → `/solutions/`

**Полностью статический файл: ни одного `get_field` / `WP_Query` / `esc_*`.**

| # | Строка | Разметка | CSS-секция | Якорь |
|---|---|---|---|---|
| 1 | 10 | `.main.main--solutions` | `MAIN` (7314–7567) | — |
| 2 | 114 | `.page-nav` | общая с главной | `data-threshold="900"` |
| 3 | 156 | `.benefits` | `BENEFITS` (7569–8047) | `#benefits` |
| 4 | 331 | `.features` | `FEATURES` (8049–8704) | `#solutions` |
| 5 | 533 | `.flow` | `FLOW` (8706–9016) | `#products` |
| 6 | 632 | `.industries` | `INDUSTRIES` (9018–9394) | `#industries` |
| 7 | 811 | `.integration` | `INTEGRATION` (9396–10064) | `#integration` |
| 8 | 973 | `.security` | `SECURITY` (10066–10300) | `#security` |
| 9 | 1044 | `.testimonials` | общая с главной | `#testimonials` |
| 10 | 1126 | `.faq` | `FAQ` (10302–10492) | `#faq` |
| 11 | 1242 | `.cta` | `CTA` (10494–10729) | `#cta` |

Вся страница обёрнута маркерами `SOLUTIONS-PAGE START` (7312) … `END` (10732).

---

## 3. Pricing Matrix — `page-price-matrix.php` → `/pricing-matrix/`

**Единственная по-настоящему ACF-управляемая страница.**

| # | Строка | Разметка | CSS-секция | Данные |
|---|---|---|---|---|
| 1 | 8 | `.intro` | `INTRO` (11023–11368) | статика |
| 2 | 90 | `.calculator#kyc-calculator` | `CALCULATOR` (11370–12643) | цены в `data-`атрибутах, `js/calculate.js` |
| 3 | 347 | `.overview` | `OVERVIEW` (13170–13433) | статика |
| 4 | 443 | `.packages#packages` | `PACKAGES` (12645–13168) | ACF: тарифы, услуги, цены |

Обёрнуто `CALC PAGE START` (11021) … `END` (13435).

Калькулятор: три пакета — DOCUMENT, **LIVENESS**, BASIC. Цена LIVENESS **не вводится**,
считается как BASIC − DOCUMENT в каждой из трёх опорных точек. При LIVENESS блок
«Document Type in Package» скрывается классом `calculator--no-documents`,
дополнительные документы остаются доступны и тарифицируются как доплата.

---

## 4. Общие блоки

| Блок | Где | CSS-секция |
|---|---|---|
| `.btn` + модификаторы | везде | 215+ |
| `.section`, `.section__badge`, `.section__title` | все страницы | по секциям |
| `.page-nav` | главная, solutions | 1503–1741 |
| `.header` | `header.php` | `MENU` (650–930) |
| `.footer` | `footer.php` | `FOOTER` (6577–6869) |
| `.teaser` | `footer.php`, `template-parts/teaser.php` | `teaser` (6378–6574) |
| `.cookie-banner` | `footer.php:98` | `COOCKIE` (6871–7008) |
| `.modal` | `footer.php`, 4 штуки | `MODAL` (7011–7310) |
| `.contacts` | главная + `footer.php` | `CONTACTS` (5577–6375) |
| `.testimonials` | главная + solutions | 3826–4061 |
| `.nvslider` | solutions | в своих секциях |
| `.phone-field` | формы | 27 правил |
| `.page` | юр. страницы | `PAGE` (10736–11019) |

### Модалки в `footer.php`
| id | Строка | Назначение |
|---|---|---|
| `callForm` | 113 | основная форма заявки |
| `callForm2` | 425 | вторая форма — **164 строки расходятся** с `callForm`, остальное совпадает |
| `review` | 625 | просмотр отзыва |
| `thanks` | 668 | благодарность |

---

## 5. JS-компоненты — `js/main.js`

31 инициализатор. Привязка к разметке — по классам и `data-`атрибутам, поэтому
переименование класса ломает компонент.

**Слайдеры (Swiper):** `initProductsSlider`, `initTestimonialsSlider`, `initCasesSlider`,
`initNewsSlider`, `initBenefitsSlider`, `initFlowSlider`, `initIndustriesSlider`,
`initIntegrationSlider`, `initSecuritySlider`.

**Табы и раскрытие:** `initDocTabs`, `initFeaturesBlock`, `initFaq`, `initReviewTranscriptToggle`.

**Навигация:** `initHeaderMenu`, `initPageNavMobile`, `initPageNavActive`, `initPageNavSticky`,
`initSmoothAnchors`, `initSmoothScroll`, `initTopWidget`.

**Формы и модалки:** `initLightboxAndForms`, `initModalForm`, `initReviewModal`,
`initCustomFormUi`, `initCookieBanner`.

**Анимации:** `initMaskotAnimation`, `initLottieAnimation`, `initFadeUpAnimations`,
`initHeroCanvasAnimation`, `initUptimeGauge`, `initClientsHover`.

Отдельно: `js/calculate.js` — калькулятор, `js/form.js` — отправка форм, hCaptcha, лайки, поиск.

### Доступность
Полный набор ARIA есть **только** у `blocks/tabs/tabs.php` (`role="tablist"`).
`initDocTabs`, `initFeaturesBlock`, `initBenefitsSlider` работают без ролей табов.
В шаблонах: `aria-hidden` — 42, `tabindex` — 20, `aria-expanded` — 13,
`aria-labelledby` — 5, `role="tab*"` — по 1.

---

## 6. ACF-блоки Gutenberg — `blocks/`

19 блоков, категория `neurovision` («NVGlobal»). Для статей блога и документации.
У каждого: `block.json`, `<name>.php`, `<name>.css`, `<name>.editor.css`, иногда `<name>.js`.

`about`, `callout`, `code`, `disclaimer`, `faq`, `note`, `pillar`, `quote`, `result`,
`single-image`, `slider`, `spoiler`, `stages`, `steps`, `success`, `tabs`, `toc`,
`two-images`, `warning`.

---

## 7. Заготовки блога (сейчас не видны: 0 записей)

| Файл | Строк | Роль |
|---|---|---|
| `single.php` | 436 | статья |
| `category.php` | 181 | рубрика |
| `author.php` | 308 | автор |
| `search.php` | 194 | поиск / листинг |
| `blog-page.php` | 125 | страница блога |
| `template-parts/article-card.php` | 120 | карточка записи |

Стили: `css/blog.css`, `css/post.css`. **Рабочий код, не удалять.**

---

## 8. Библиотеки

| Библиотека | Файл | Подключена |
|---|---|---|
| Swiper | `assets/swiper/` | да |
| MicroModal | `assets/micromodal/` | да |
| GSAP + ScrollTrigger | `assets/gsap.min.js`, `assets/scrolltrigger.min.js` | да |
| Locomotive Scroll | `assets/locomotive-scroll.min.*` | да |
| Lottie | `assets/lottie.min.js` | да (в `<head>`) |
| smoothscroll | `assets/smoothscroll.min.js` | да (в `<head>`) |
| **GLightbox** | `assets/glightbox/` | **нет** — см. ниже |
| **Siema** | `assets/siema/` | **нет** — в enqueue отсутствует |

> Проверено в браузере на `/`: `window.Swiper`, `gsap`, `MicroModal`, `lottie`,
> `LocomotiveScroll` — определены; `GLightbox` и `Siema` — `undefined`.
>
> **GLightbox нигде не подключается.** Файлы лежат в `assets/glightbox/`, но `wp_enqueue_script`
> для них нет ни в `functions.php`, ни в шаблонах (enqueue есть только в соседней теме
> `wp-content/themes/neurovision`). При этом `js/main.js:804` в `initLightboxAndForms()`
> делает `if (typeof GLightbox === 'undefined') return;` — то есть функция молча выходит,
> и лайтбокс на сайте не работает. Ошибок в консоли нет. Решение — в `docs/BACKLOG.md`.
