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


---

## 10. Состояние редизайна

| # | Секция Figma | Статус | Коммит |
|---|---|---|---|
| — | Основа: палитра `--nv-*`, сетка | ✅ сделано | группа 1 |
| 1 | Header | ⚠️ только палитра (Р-10) | группа 1 |
| 1 | Hero | ✅ сделано | группа 1 |
| 2 | About | ✅ сделано | группа 2 |
| 3 | Results | ✅ сделано, новая секция | группа 2 |
| 4 | Industry Solutions | ✅ сделано | группа 2 |
| 5 | Products (слайдер) | ✅ сделано | группа 3 |
| 6 | How it works | — новая секция | |
| 7 | Why us | — | |
| 8 | Clients / Trusted | ✅ сделано, карта добавлена (R-14 закрыт) | группа 4 + доработка |
| 9 | Pricing | ✅ сделано, новая секция | группа 4 |
| 10 | Developers | ✅ сделано | группа 4 |
| 11 | Blog | — | |
| 12 | FAQ | — перенос компонента | |
| 13 | Contacts | — | |
| 14 | Teaser + Footer | — | |

Скрыты по Р-11 (`if (false)`, разметка и CSS на месте): `page-nav`, `video-intro`,
`cases`, `promo`. Ранее была скрыта `testimonials`.

### Новые классы первого экрана

| Класс | Назначение |
|---|---|
| `.hero__card` | карточка со скруглением 32 и фотофоном |
| `.hero__media` | обёртка фотографии, `object-fit: cover` |
| `.hero__logo` | логотип в левом верхнем углу карточки |
| `.hero__title-accent` | «in seconds» оранжевым внутри H1 |

Сохранены и продолжают работать: `.hero__wrapper`, `.hero__content`, `.hero__title`,
`.verify`, `.hero__actions`, `.btn-hero` (`open-callForm2` → модалка `#callForm2`),
`.btn.btn--gray` (ссылка на `/pricing-matrix/`).

### Токены светлой темы

Объявлены на `body.home` с префиксом `--nv-`. Старое семейство
`--island-*` / `--text-white-*` / `--stroke-white-*` **не объявлено и не трогается**.

| Токен | Значение | Figma |
|---|---|---|
| `--nv-primary` | #FD6B01 | Primary_1 |
| `--nv-primary-2` | #FF4601 | Orange/800 |
| `--nv-primary-soft` | #FFF0E6 | Orange/400 |
| `--nv-object-1` | #212121 | Object_1 |
| `--nv-object-2` | #5A5A5A | Object_2 |
| `--nv-object-3` | #898989 | Object_3 |
| `--nv-surface-1` | #F8F8F8 | Surface_1 |
| `--nv-surface-2` | #F2F2F2 | Surface_2 |
| `--nv-surface-3` | #E4E4E4 | Surface_3 |
| `--nv-surface-4` | #D2D2D2 | Surface_4 |
| `--nv-constant-1` | #F8F8F8 | Text/Constant/Text 1 |
| `--nv-constant-85` | rgba(248,248,248,.85) | Opacity_85% |
| `--nv-gradient` | linear-gradient(167deg, #FD6B01 15%, #FF4601 100%) | Island/Gradient |


---

## 11. Секция Results — новый компонент

Добавлена в группе 2 по макету Figma `2363:33982`. Расположена между About
и Industry Solutions, как в макете.

| Класс | Назначение |
|---|---|
| `.results` | секция, использует общий `.section` |
| `.results__content` | строка: слева интро, справа карточки статистики |
| `.results__intro` | колонка 560px: заголовок + карточка кейса |
| `.results__case` | карточка кейса, `overflow: hidden` для выходящей иллюстрации |
| `.results__case-name` | «A major retail bank», 32/150% оранжевым |
| `.results__case-problem` | подзаголовок кейса, 20/140% |
| `.results__case-label` | «After automated KYC…», 14/142.857% |
| `.results__tokens` / `.results__token` | список плашек-результатов |
| `.results__case-image` | 3D-иллюстрация, absolute, выходит за правый нижний угол |
| `.results__stats` / `.results__stat` | сетка 2×2 на Flexbox (`flex: 0 0 calc(50% - 8px)`) |
| `.results__stat-value` | число, 52/123.077% оранжевым |
| `.results__stat-title` | 24/150% |
| `.results__stat-description` | 16/150% |

> В макете карточки статистики собраны на CSS Grid. Здесь это `flex-wrap`
> с `calc(50% - 8px)` — регламент требует отдавать предпочтение Flexbox,
> и для равных 2×2 разницы в поведении нет.

Ассеты: `img/results-bank.webp` (276×276, 44 KB) и `img/results-bank@2x.webp`
(552×552, 118 KB), lossless WebP из PNG с альфой 2000×2000 (1.1 MB).

---

## 12. Что изменилось в About и Industry Solutions

### About
Структура и классы сохранены. Убраны из разметки: `.about__description`
(в макете такого блока нет), `.about__card-image` с подписью «verified by»,
маскот `.teaser__maskot--about`. CSS этих классов оставлен на месте.

Добавлены: `.about__card-stats`, `.about__card-stat`, `.about__card-divider`
(вторая колонка статистики с разделителем), `.about__card--statement`
и `.about__card-statement` (карточка с крупной формулировкой).

Логотипы сертификатов остались вложениями WordPress (`td_image(960|961|962)`) —
это те же три значка, что в макете, с теми же пропорциями (360×360, 282×360,
360×360 против 120×120, 94×120, 120×120). Статикой не подменялись.

### Industry Solutions
`.solutions__item` структурно уже совпадал с макетом (`min-width: 340`,
`padding: 24`, `flex: 1 0 0`, `align-items: flex-end`, `gap: 24`, радиус 24) —
изменены только цвета.

`.solutions__content` переведён с CSS Grid (`1fr 2fr`, три ряда под маскота)
на колонку Flexbox: маскота в макете нет, раскладка стала линейной.

Иконки: пять из шести уже были в теме из того же экспорта Figma — переиспользованы,
`fill` заменён на `currentColor`, id фильтров уникализированы. Новая только иконка
Crypto Exchanges. Исходные кадры SVG сохранены, `viewBox` не пересчитывался.


---

## 13. Слайдер Products — состав и управление

Редизайн группы 3 по макетам Figma `291:7228` (Desktop), `2376:16797` (Tablet)
и пяти фреймам отдельных слайдов.

### Шесть слайдов

| # | Вкладка | Заголовок | Подзаголовок | Кнопка |
|---|---|---|---|---|
| 1 | KYC / eKYC | Know Your Customer | A real person with a real document — verified in seconds | есть |
| 2 | AML & Sanctions | AML & Sanctions | 1,700+ databases, one API call. | нет |
| 3 | KYB | Know Your Business | Find out who you are signing with | есть |
| 4 | KYT | Know Your Transaction | On-chain, in real time | нет |
| 5 | Liveness & Face Authentication | Liveness & Face Authentication | A live person, not a photo, video or mask | нет |
| 6 | NeuroPay | NeuroPay | Pay by face or palm | нет |

Кнопка «Learn more» есть только на слайдах 1 и 3 — на остальных её слой
в макете помечен `hidden="true"`. Обе ведут на `/solutions/#solutions`
(Figma назначение ссылок не задаёт, цель сохранена из прежней версии).

### Управление

JS не переписывался — `initProductsSlider` уже обеспечивал всё нужное:

| Возможность | Реализация |
|---|---|
| вкладка → слайд | `tabs.forEach(click)` → `setDesktopActive` |
| синхронизация вкладок и стрелок | `updateTabs` + `setDisabled` |
| края без зацикливания | `--disabled` и `disabled` на prev при 0, next при `total − 1` |
| клавиатура | `keydown` на `.products__slider` (`tabindex="0"`), ←/→ |
| телефоны | Swiper на `.products__slider-content-swiper` при `≤767.98` |
| без повторной инициализации | `destroyMobileSwipers()` перед `initMobileSwipers()` |
| число слайдов | `total = Math.min(tabs.length, slides.length)` |

Внесены две правки:
1. Слайдер картинок сделан **опциональным** — в новом макете изображений нет,
   а прежний код выходил из `initMobileSwipers`, если блока картинок не было,
   и мобильный свайп контента не поднимался.
2. В `updateTabs` добавлена синхронизация `aria-selected` и roving `tabindex`
   (вкладки получили `role="tab"`).

### Разметка и доступность

`.products__slider-tabs` → `role="tablist"`; вкладки → `role="tab"` с
`aria-controls`; слайды → `role="tabpanel"` с `aria-labelledby`. Стрелки получили
`aria-label`. Это закрывает B-13 для данной секции.

Блок изображений (`.products__slider-image--desktop`, `.products__slider-image-mobile`)
и атрибуты `data-image` убраны из разметки — в макете изображений нет.
Файлы `img/products-image*.jpg` **не удалялись**.

### Оформление

Секция оформлена как скруглённая «страница»: компонент Figma Page edge сверху
и снизу — это рамка `1px #D2D2D2` с радиусом 32; отдельная разметка не нужна,
поля `128px = 64 (Page edge) + 64 (контент)`.

| Элемент | Значение |
|---|---|
| карточка слайдера | `#F2F2F2`, рамка `#D2D2D2`, радиус 24, поле 24 (планшет — 16) |
| вкладка активная | градиент `#FD6B01 → #FF4601`, текст `#F8F8F8`, рамка `#D2D2D2` |
| вкладка обычная | `#E4E4E4`, текст `#898989`, без рамки |
| вкладка hover | фон `#D2D2D2` |
| стрелка | 40×40, `#F2F2F2`, рамка `#D2D2D2`, радиус 8 |
| стрелка hover | `#E4E4E4` |
| стрелка disabled | без заливки, `opacity: .5` |
| заголовок слайда | 32/150% `#FD6B01` |
| подзаголовок | 18/133.333% `#212121` |
| описание | 18/155.556% `#5A5A5A` |

Ниже 1200px раскладка переходит на схему планшетного фрейма: заголовок,
под ним карточка, описание и кнопки — отдельной строкой внизу.
Переключение сделано через `display: contents` на `.products__info` и `order`
у трёх блоков, без дублирования разметки.

---

## 14. Группа 4 — Trusted, Pricing, Developers

### Trusted by Industry Leaders Worldwide — `.clients`

Полоса карты `1376×293`, пины позиционируются в процентах от неё,
поэтому при любой ширине остаются на своих местах макета.

В макете пины — это блок шириной 1376, который на FullHD не растягивается,
а центрируется. Поэтому `.clients__list` ограничен `max-width: 1376px`
и центрируется, а проценты внутри считаются от 1376.

Координата в Figma — это бокс иконки 60×60; наш элемент — капля 68×83
с отступом 4, поэтому `left`/`top` = координата из Figma минус 4.

| Пин | Figma x,y | `left` | `top` |
|---|---|---|---|
| `.clients__item--bank` | 163, 136 | 11.5552% | 45.0512% |
| `.clients__item--crypto` | 379, 33 | 27.2529% | 9.8976% |
| `.clients__item--goverment` | 662, 90 | 47.8198% | 29.3515% |
| `.clients__item--insurance` | 932, 88 | 67.4419% | 28.6689% |
| `.clients__item--gambling` | 1138, 63 | 82.4128% | 20.1365% |

Иконка пина — `img/clients__pin.svg` (427 B, `#D2D2D2`), inline `currentColor`
не используется: цвет один и тот же во всех состояниях.

Тултип `.clients__tooltip`: `bottom: 95px`, `left: 50%`,
`transform: translateX(-50%)`, ширина 160, паддинг `12px 8px`, радиус 16,
фон `--nv-surface-1`, рамка `1px solid --nv-surface-4`.

На `≤575.98` карта и пины скрываются, отрасли выводятся вертикальным
списком карточек с оранжевой иконкой слева.

### Карта мира

`img/clients-map.webp` + `@2x` — собраны из оригинальных векторов Figma
(фрейм Map), цвета `#F2F2F2` / `#F8F8F8`, с прозрачностью.
Файл обрезан по верхним 340px из 679 (50.07% высоты карты), поэтому высота
слоя `.clients__map` = высота карты в Figma × 0.5007:

| Макет | Карта в Figma | `left` | `width` | `height` слоя |
|---|---|---|---|---|
| FullHD `2380:23178` | 1655.4 × 605.386 при x 100.3 | 5.4042% | 89.1918% | 303.12px |
| Desktop `2318:18234` | 1376 × 678.747 при x 0 | 0 | 100% | 339.86px |
| Tablet `2376:17006` | 776 × 678.747 при x 0 | 0 | 100% | 339.86px |

`top: 0.6265px` одинаков во всех трёх.

⚠️ Полосе **нельзя** давать `overflow: hidden` — подсказки пинов выходят выше
полосы и будут срезаны. Карта обрезается своим `clip-path: inset(...)`.

Затухание к низу полосы (в макете растровый `Rectangle 3922`, y 208.28,
высота 149) сделано через `.clients__content::after` с CSS-градиентом.

### Pricing — `.pricing`

Секция новая. Слева карточка с ценой (`from $0.24`, подпись, разделитель,
строка про дополнительный документ), справа сетка из трёх преимуществ
с иконкой-галочкой в правом верхнем углу карточки.

Ниже — две кнопки: `Talk to sales` (`.btn--gray`) и `Calculate your price`
(`.btn--primary`).

⚠️ Кнопкам нужен собственный блок `.pricing .btn` — иначе они наследуют
прежний `#F9AA66` из тёмной темы.

На `≤575.98` колонки складываются в одну, карточки преимуществ идут
вертикально, кнопки — на всю ширину (`max-width: none`, иначе базовый
`.btn { max-width: fit-content }` даёт разную ширину).

### Developers — `.doc`

Левая колонка: бейдж, заголовок, описание, оранжевая строка призыва,
`Get Your API Key` (`.btn--primary`) и `Schedule an integration call`
(`.btn--gray`, иконка телефона слева — разметка уже в нужном порядке,
`row-reverse` не нужен).

Правая колонка: две карточки документации (`API Reference & SDKs`,
`Integration Guide`) с иконкой-звездой и кнопкой внизу, под ними —
оранжевый блок `Developer Support` с кнопкой `Book a call` (`.btn--dark`).

На `≤840` колонки складываются: сначала текст и кнопки, затем карточки
в столбик, затем блок поддержки.

Данные берутся из `get_field()` — подстановок статикой нет.

### Кнопка `.btn-hero` — важное ограничение

`.btn-hero` живёт **не только на главной**: `/pricing-matrix/`, `/404/`,
`/blog/`, `category`, `search`, `author`, `single`.

Поэтому новый вид кнопки описан **только** в `body.home .btn-hero`,
а глобальные правила оставлены прежними:

```
.btn-hero            { padding: 16px; gap: 17px; border-radius: 16px;
                       flex-direction: row-reverse; height: 64px; … }
.btn__text-hero      { color: var(--Text-White, #FBFBFB); }
.btn-hero:hover .btn__icon-arrow, .btn-hero.is-active .btn__icon-arrow { … }
.btn-hero:hover .btn__text-hero, .btn-hero.is-active .btn__text-hero  { … }
.btn-hero:hover .btn__icon-arrow::after                               { … }
```

Причина жёсткая: `--nv-gradient` объявлена только в `body.home`.
Глобальное `background: var(--nv-gradient)` вне главной невалидно,
и кнопка получает прозрачный фон.

