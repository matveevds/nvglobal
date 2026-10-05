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

---

## 9. Карта редизайна главной — Figma ↔ тема

Составлена 2026-10-05 по макетам Full HD / Desktop / Tablet (`docs/FIGMA.md`).
Номера строк — на момент анализа.

### Что совпало само собой

Сверено замерами в браузере на `/` при 1440:

| Параметр | Тема сейчас | Figma | Итог |
|---|---|---|---|
| Шрифт | Satoshi | Satoshi | ✅ менять не нужно |
| H2 (`.section__title`) | 40px / 52px / 700 | 40 / 52 / 700 | ✅ совпадает точно |
| Контент при 1440 | 1376px | 1376px | ✅ совпадает точно |
| Брейкпоинты | 8 штук | — | ✅ сохраняем |
| `line-height` в px | 0 вхождений | требование | ✅ |

**Главное изменение — инверсия палитры:**

| | Тема сейчас | Figma |
|---|---|---|
| Фон страницы | `#212121` | `#F8F8F8` |
| Основной текст | `#FBFBFB` | `#212121` |
| Акцент | `#F9AA66` (132 исп.) | `#FD6B01` |
| Второй акцент | `#FF7759` (29 исп.) | `#FF4601` |
| Градиент | `linear-gradient(142deg,#F9AA66,#FF7759)` — 27 исп. | уточняется по секциям |

### Таблица секций

| # | Секция Figma | PHP-блок | CSS-секция | JS | Тип изменений |
|---|---|---|---|---|---|
| 1 | Header + Hero | `header.php`, `.hero` (`main-page.php:26`) | `MENU` 650–930, hero 930–1501 | `initHeaderMenu`, `initHeroCanvasAnimation` | **структура + навигация + палитра** |
| 2 | About | `.about` `:102` | `ABOUT` 1744–2080 | — | палитра + перекомпоновка карточек |
| 3 | Results | **нет** | — | — | **новая секция** |
| 4 | Industry Solutions | `.solutions` `:251` | `SOLUTIONS` 2214–2405 | — | палитра + 6 карточек |
| 5 | Products (слайдер) | `.products` `:501` | `PRODUCTS` 2408–2928 | `initProductsSlider` | палитра + контент 7→6 слайдов |
| 6 | How it works | **нет** | — | — | **новая секция** |
| 7 | Why us | `.advantages` `:857` | `advantages` 2932–3301 | — | палитра, заголовок совпадает |
| 8 | Clients / Trusted | `.clients` `:968` | `CLIENTS` 3304–3824 | `initClientsHover` | **только палитра** |
| 9 | Pricing | **нет** | — | — | **новая секция** |
| 10 | Developers | `.doc` `:1342` | `DOC` 4488–4929 | `initDocTabs` | палитра + смена раскладки |
| 11 | Blog | `.news` `:1471` | `NEWS` 4932–5312 | `initNewsSlider` | палитра + карточки |
| 12 | **FAQ** | **нет на главной** | `FAQ` 10302–10492 | `initFaq` | **перенос готового компонента** |
| 13 | Contacts | `.contacts` `:1812` | `CONTACTS` 5577–6375 | `initCustomFormUi`, `form.js` | палитра + состояния полей |
| 14 | Teaser + Footer | `footer.php` | `teaser` 6378–6574, `FOOTER` 6577–6869 | — | **глобально** — палитра + колонки ссылок |

### Секции темы без пары в Figma

| Секция | Заголовок | Статус |
|---|---|---|
| `.page-nav` `:60` | липкая навигация по якорям | в макетах не нарисована |
| `.video-intro` `:187` | «Let's get to know each other!» | пары нет |
| `.testimonials` `:1049` | «What Our Clients Say» | уже выключена `if (false)` |
| `.cases` `:1164` | «Success Stories That Speak for Themselves» | пары нет; ближе всего Figma «Results» |
| `.promo` `:1755` | промо-блок | пары нет |

Решение по ним — за пользователем, самостоятельно не удаляем.

### Компоненты, готовые к переиспользованию

**FAQ** (`page-solutions.php:1126`) переносится на главную без правок JS:
`initFaq()` работает по глобальному `document.querySelectorAll('.faq__item')`
и безопасно выходит, если элементов нет. Структура:
`.faq` → `.faq__left` (badge, `.section__title`, кнопка) + `.faq__right` → `.faq__list` →
`.faq__item` → `.faq__item-question` / `.faq__item-answer`.

**Clients tooltip** (`.clients__item`) — менять нечего, кроме цветов:
подписи в теме **дословно совпадают** с фреймом `2328:21867`, порядок тот же.

| # | Заголовок | Подпись |
|---|---|---|
| 1 | Banks | Powering secure digital onboarding |
| 2 | Crypto Exchanges | Enabling compliant KYC verification |
| 3 | Government | Securing citizen identity services |
| 4 | Insurance | Accelerating claim processing |
| 5 | Gambling | Verifying age and identity instantly |

`initClientsHover` уже поддерживает и `mouseenter`, и `click` — требования п. 6.3 задания выполнены.

**Слайдер Products** — структура подходит целиком:
`.products__slider-tabs` → `.products__slider-tab(--active)`,
`.products__slider-content-swiper.swiper` → `.products__slider-list.swiper-wrapper` → `.products__slide`,
`.products__slider-arrows` → `.products__slider-arrow--prev/--next(--disabled)`.
Меняются контент (7 → 6 слайдов) и оформление; Swiper и `initProductsSlider` остаются.

Новые названия слайдов из Figma: KYC / eKYC, AML & Sanctions, KYB, KYT,
Liveness & Face Authentication, NeuroPay — тот же список, что в колонке PRODUCTS футера.

**Селект формы** — `help-select`, кастомный listbox с полным ARIA
(`aria-haspopup="listbox"`, `role="listbox"`, `role="option"`, `aria-expanded`).
Варианты (менять запрещено, п. 8.2 задания): Schedule a demo, Discuss integration,
Get pricing information, Technical questions.
