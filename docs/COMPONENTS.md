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
| 3а | — | `.video-embed` | `blocks/video.css` | `#video` | универсальный блок «Видео» (`template-parts/video-section.php`, YouTube-фасад, `js/video-block.js`), между About и Results (2026-10-21) |
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

Редизайн по новому макету **завершён**: группы 1–9 (2026-10-09/10) плюс
финальный визуальный аудит 2026-10-10. Светлая тема и шапка, первый экран,
Why, Industries, Products, Integration, Security & compliance, FAQ, Contacts,
светлые тизер и подвал.

Шапка и подвал — общие компоненты главной; у Solutions своих версий нет
(DECISIONS.md, Р-104).

**Полностью статический файл: ни одного `get_field` / `WP_Query`.**

| # | Строка | Разметка | CSS-секция | Якорь | Состояние |
|---|---|---|---|---|---|
| 1 | 18 | `.main.main--solutions` | `MAIN` (11053–11514) | — | **новый дизайн** |
| 2 | 105 | `.page-nav` | `PAGE-NAV` (общая с главной) | — | **скрыта `if (false)`** |
| 3 | 149 | `.benefits` | `BENEFITS` (11516–11994) | `#benefits` | **скрыта `if (false)`** |
| 4 | 364 | `.solutions-why` | `SOLUTIONS WHY` (11996–12502) | — | **новый дизайн** |
| — | — | ~~`.features`~~ | `FEATURES` (12504–13159) | — | разметки нет, CSS legacy |
| 5 | 496 | `.industries` | `INDUSTRIES` (13835–14430) | `#industries` | **новый дизайн** |
| 6 | 636 | `.solutions-products` | `SOLUTIONS PRODUCTS` (13161–13521) | `#solutions` | **новый дизайн** |
| — | — | ~~`.flow`~~ | `FLOW` (13523–13833) | — | разметки нет, CSS legacy |
| 7 | 716 | `.integration` | `INTEGRATION` (14432–15239) | `#integration` | **новый дизайн** |
| 8 | 837 | `.solutions-security` | `SOLUTIONS SECURITY` (15241–15523) | `#security` | **новый дизайн** |
| — | — | ~~`.security`~~ | `SECURITY` (15525–15759) | — | разметки нет, CSS legacy |
| 9 | 866 | `.testimonials` | общая с главной | `#testimonials` | **скрыта `if (false)`** |
| 10 | 978 | `.faq` | `FAQ` (15761–16502), общая с главной | `#faq` | **новый дизайн** |
| 11 | 1078 | `.contacts` | `CONTACTS` (7629–9720), общая с главной | `#cta` | **новый дизайн** |
| — | — | ~~`.cta`~~ | `CTA` (16894–17129) | — | разметки нет, CSS legacy |

Порядок секций в разметке приведён к макету: Why → Industries → Products.
Регионы CSS при этом остались на своих местах в файле.

Якорь `#solutions` стоит на блоке Products — это его финальное место,
туда ведут ссылки «Learn more» со слайдера Products на главной.
Якоря `#products` на этой странице больше нет (был на старой `.flow`).

Вся страница обёрнута маркерами `SOLUTIONS-PAGE START` (10877) … `END` (16742).
Внутри, перед `MAIN`, — подрегион `SOLUTIONS THEME` (10879–11051): светлая шапка
страницы, ограниченная `body.page-template-page-solutions`.


### Первый экран `.main--solutions` — новый компонент

Одна разметка на четыре фрейма; на мобильной перестраивается CSS-сеткой.

```
.main.main--solutions
  .container
    .main__card              карточка 1856x732 (FHD), радиус 32, фото фоном
      .main__media           <picture>, 4 кропа; затемнение — ::after
      .main__body            левая колонка: логотип сверху, текст снизу
        .main__logo
        .main__group
          .main__content     .main__title + .main__subtitle
          .main__actions     .main__btn--primary + .main__btn--ghost
      .main__facts           <ul> из 4 .main__fact (иконка + заголовок)
```

| Параметр | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile 392 |
|---|---|---|---|---|
| Карточка | 1856×732 | 1376×732 | 776×872 | без карточки, сетка |
| Левая колонка | 600 | 372 | 100% | — |
| Полоса фактов | колонка 280 | колонка 180 | строка, 120 | строка 160×120, прокрутка |
| H1 | 52/64 | 52/64 | 44/56 | 30/36, тёмный |
| Подзаголовок | 18/24, белый 85% | 18/24 | 18/24, ширина 516 | 14/20, `--nv-object-2` |
| Заголовок факта | 24/36 | 18/24 | 18/24 | 14/20 |
| Радиус факта | 24 | 24 | 16 | 12 |
| Кнопка | 18/24 | 18/24 | 18/24 | 16/20 |

Особенности:
- на мобильной `.main__body`, `.main__group`, `.main__content` получают
  `display: contents`, а `.main__card` становится сеткой: заголовок и описание
  выходят из фотокарточки, кнопки остаются внутри неё (одна ячейка с `.main__media`);
- полоса фактов на мобильной уходит под правый край экрана и прокручивается;
- кнопки — собственные классы `.main__btn*`, общие `.btn` / `.btn-hero` не
  переопределяются (Р-47). Модалка открывается по `.open-callForm2`;
- иконки фактов — inline-SVG с `fill="currentColor"`, перенесены из прежней
  разметки первого экрана (совпадают с макетом).

Ассеты: `img/sol-hero-{fhd,desktop,tablet,mobile}.webp` (+`@2x`),
`img/logo-hero.svg` (уже был), `img/logo-header-light.svg` (новый, тёмный
логотип 168×32 — его подставляет `header.php` на Solutions).

### Блок «Why Leading Companies Choose ...» — `.solutions-why`

Данные одни на все макеты: массив `$nv_solution_benefits` в `page-solutions.php`
(`number`, `title`, `description`). Разметка тоже одна, разницу делает CSS.

```
.section.solutions-why #solutions
  .container
    .solutions-why__head        бейдж + H2 по центру
    .solutions-why__board       рамка, радиус, overflow: hidden
      .solutions-why__cards     role="group"
        .solutions-why__card.solutions-why__card--level-N[.is-open]
          .solutions-why__card-body
            h3.solutions-why__card-heading > button.solutions-why__card-button
            p.solutions-why__card-text
          span.solutions-why__card-number
      .solutions-why__media     <picture>, 4 кропа
      .solutions-why__nav       две .solutions-why__arrow
```

| Параметр | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile 392 |
|---|---|---|---|---|
| Раскладка | карточки слева, фото справа | то же | фото сверху, карточки под ним | то же |
| Раскрыта | одна | одна | все четыре | все четыре |
| Раскрытая / свёрнутая | 516 / 116 | 516 / 116 | — | — |
| Нахлёст | 24 по горизонтали | 24 | 64 по вертикали | 64 |
| Поле карточки | 24 | 24 | 16 | 12 |
| Радиус | 24 | 24 | 16 | 12 |
| Заголовок карточки | H3 32/48 | H3 32/48 | H4 24/36 | H4 20/32 |
| Описание | 18/28 | 18/28 | 18/28 | 16/24 |
| Номер | H1 52/64 | H1 52/64 | 44/56 | 30/36 |
| Стрелки | есть | есть | нет | нет |

Цвет карточки — по её номеру: 01 оранжевая, 02 `--nv-surface-3`,
03 `--nv-surface-2`, 04 `--nv-surface-1`. Признак раскрытия — только ширина.

Ширины карточек задаются переменными `--swhy-card`, `--swhy-card-open`,
`--swhy-tuck` на `.solutions-why__board` и переопределяются на 1399.98 и
1199.98 — отдельных макетов там нет, но фотография иначе вырождается.

JS — `initSolutionsWhy()` в `js/main.js`. Обработчики вешаются один раз,
режим «десктоп / статика» переключается по `change` у `matchMedia`.

Ассеты: `img/sol-why-{fhd,desktop,tablet,mobile}.webp` (+`@2x`). Фотография
одна на все состояния — в макете она при переключении карточек не меняется.

### Блок «Built for regulated industries» — `.industries` + `.nvslider`

Адаптирован из прежнего блока: механика двух синхронных Swiper сохранена,
оформление и контент переписаны. Данные — массив `$nv_industries`
в `page-solutions.php` (`id`, `pill`, `title`, `description`, `summary`,
`chips`, `image`, `alt`); из него рендерятся и вкладки, и слайды.

```
.section.industries #industries
  .container
    .industries__head           бейдж + H2 + подзаголовок
    .industries__board          grid 3fr / 1fr
      .industries__panel.nvslider
        .nvslider__nav          стрелка — панель вкладок (Swiper) — стрелка
          .nvslider__buttons > .swiper-wrapper[role=tablist]
            button.nvslider__btn[role=tab]
        .nvslider__main         Swiper содержимого
          .nvslider__slide[role=tabpanel]
            .nvslider__card     иконка + заголовок + описание
            .nvslider__aside    пояснение + .nvslider__chips
      .industries__media        6 .industries__illustration, активная .is-current
```

| Параметр | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile 392 |
|---|---|---|---|---|
| Раскладка | карточка слева, иллюстрация справа | то же | то же, блоки внутри друг под другом | иллюстрация сверху |
| Вкладок видно | 3 равные | 3 равные | по содержимому | 1 |
| Стрелки | по краям панели | по краям | по краям | внутри панели |
| Карточка индустрии | 520 | 520 | во всю ширину | во всю ширину |
| Поле карточки | 24 | 24 | 16 | 12 |
| Радиус | 24 | 24 | 16 | 12 |
| Заголовок | H4 24/36 | 24/36 | 24/36 | 20/32 |
| Описание | H6 18/24 | 18/24 | 18/24 | 14/20 |
| Пояснение | 18/28 | 18/28 | 18/28 | 16/24 |
| Чип | 16/24 | 16/24 | 16/24 | 14/20 |
| Иллюстрация | 480, +160 за правый край | 480 | 316, −78 под карточку | 360 над карточкой |

Механика — `initIndustriesSlider()`: `loop: false`, выбор ведёт слайдер
содержимого, панель вкладок только позиционируется; после `breakpoint`
и `resize` оба слайдера возвращаются на выбранный индекс. Вкладки размечены
как tabs (`tablist` / `tab` / `tabpanel`), стрелки выключаются на краях.

Ассеты: `img/sol-ind-{banks,fintech,crypto,telecom,gambling,government}.webp`
480×480 + `@2x`. Старые `img/industries_maskot1…4.*` остались на диске.

### Блок «One platform. Lots of products. One API» — `.solutions-products`

Шесть продуктовых карточек из массива `$nv_products` в `page-solutions.php`
(`number`, `title`, `description`, `link`, `cta`, `modifier`).

```
.section.solutions-products #solutions
  .solutions-products__panel        панель: радиус 32, рамка, подложка surface-2
    .container
      .solutions-products__head     бейдж + H2 + подзаголовок, по центру
      ul.solutions-products__grid
        li.solutions-products__card[.solutions-products__card--accent]
          span.solutions-products__number
          .solutions-products__body
            .solutions-products__text   h3 + p
            a.solutions-products__link  «Learn more» + стрелка
```

| Параметр | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile 392 |
|---|---|---|---|---|
| Колонок | 3 | 3 | 2 | 1 |
| Карточка | 608×211 | 448×263 | 380×249 | 360, по содержимому |
| Текст и кнопка | в строку, зазор 52 | в столбик, зазор 24 | в столбик | в столбик |
| Заголовок карточки | H4 24/36 | H5 20/28 | H5 20/28 | 16/20 |
| Описание | 16/24 | 16/24 | 16/24 | 14/20 |
| Номер | H1 52/64 | 52/64 | 44/56 | 30/36 |
| Поле карточки | 24 | 24 | 16 | 12 |
| Радиус | 24 | 24 | 16 | 12 |
| Кнопка | 117×32 | 117×32 | 117×32 | 102×28 |

Ряды сетки равной высоты (`grid-auto-rows: 1fr`), внутри карточки
`space-between` с зазором 8 — остаток высоты уходит между номером и текстом.
На мобильной ряды по содержимому: карточки без кнопки ниже.

Первая карточка оранжевая — это её постоянное оформление, а не состояние.
Кнопка «Learn more» выводится только там, где в проекте есть реальный адрес:
сейчас это KYC → `/docs/products/kyc/`. Для KYB цели нет (BACKLOG A-29).

JS у блока нет.

### Блок «Seamless Integration That Just Works» — `.integration`

Слева слайдер путей интеграции, справа карточки «Every integration includes», развёртывания и Back-office.
С 2026-10-21 — **универсальный блок** (один вид, без body-скоупа): `template-parts/integration-section.php`,
все тексты, слайды, список, чипы и картинки — аргументы (`section_id`, `badge`, `heading`, `subtitle`,
`docs_text`/`docs_url`, `contact_text`/`contact_form`, `path_title`, `slides`, `includes`, `deploy`, `backoffice`);
стандартный набор — `nv_integration_preset()` (`inc/integration-preset.php`); пустой `deploy`/`backoffice`
убирает карточку (без deploy — два столбца list | backoffice, с deploy — раскладка «3 карточки» через `:has()`).

```
.section.integration #integration
  .container
    .integration__head        бейдж + заголовок/подзаголовок + две кнопки
    .integration__board
      .integration__path      оранжевая карточка слайдера
        h3.integration__path-title
        .integration__path-body
          .integration__nav        две .integration__arrow
          .integration__slider     белая карточка
            .integration__swiper   Swiper, .integration__slide
            .integration__pagination  три .integration__bar
      .integration__info      три .integration__card
```

| Параметр | Full HD 1920 | Desktop 1440 | Tablet 840 | Mobile 392 |
|---|---|---|---|---|
| Раскладка | слайдер 540 + три карточки в ряд | слайдер 400 + две карточки и широкая снизу | слайдер во всю ширину, заголовок и стрелки в строку | всё в колонку |
| Карточка слайдера | 540×364 | 400×488 | 776×268 | 360×352 |
| Поле карточки | 24 | 24 | 16 | 12 |
| Поле белой карточки | 12 | 12 | 8 | 4 |
| Радиус | 24 | 24 | 16 | 12 |
| Заголовок слайдера | H3 32/48 | 32/48 | 32/48 | 24/36 |
| Заголовок слайда | H4 24/36 | 24/36 | 24/36 | 20/32 |
| Описание слайда | H6 18/24 | 18/24 | 18/24 | 14/20 |
| Стрелки | 40×40, тёмные | то же | то же | то же |
| Иллюстрация серверов | 335×224 | 277×185 | 277×185 | 197×132 |
| Иллюстрация папок | 252×176, зеркально справа | 222×155 слева | 222×155 слева | 194×135 справа |

Механика — `initIntegrationSlider()`: `loop: false`, `initialSlide: 0`,
без автопрокрутки; стрелки выключаются на крайних слайдах; индикатор
собственный (`aria-hidden`), подписи стрелок задаются через `a11y` Swiper.
ArrowLeft / ArrowRight работают, когда фокус внутри блока. Высота слайдов
выровнена по самому высокому — переключение не двигает страницу.

Ассеты: `img/sol-int-servers.webp`, `img/sol-int-folders.webp` (+`@2x`).
Звезда и стрелки — inline-SVG, уже были в теме.

Датчика аптайма в разметке больше нет; `initUptimeGauge` оставлен
как legacy (BACKLOG A-31).

---

### Тизер и подвал — светлый вариант на светлых шаблонах

Выбор варианта — одно условие на всю тему, `nv_is_light_theme()`
в `functions.php`:

```php
function nv_is_light_theme(): bool {
    return is_front_page()
        || is_page_template('page-solutions.php')
        || is_page_template('page-privacy.php');
}
```

Его читают три места:

| Файл | Что делает |
|---|---|
| `footer.php` | `if (nv_is_light_theme())` → `template-parts/footer-home.php`, иначе прежняя тёмная разметка |
| `template-parts/teaser.php` | выбирает логотип: светлый `teaser_logo_primary.svg` или тёмный `teaser_logo.svg` |
| `header.php` | глобальная шапка (см. раздел «Header — глобальная шапка» в §4); логотип в шапке Desktop/Tablet не выводится |

`page-privacy.php` обслуживает три юридические страницы, поэтому условие
проверяет шаблон, а не слаг: новая страница на этом шаблоне получит
светлую тему автоматически (DECISIONS.md, Р-122).

Разметка тизера и подвала **общая**: отдельных `teaser-solutions.php` и
`footer-solutions.php` нет. CSS — регионы `TEASER HOME` и `FOOTER HOME`:
каждый селектор перечисляет все три контекста (`body.home`,
`body.page-template-page-solutions`, `body.page-template-page-privacy`)
с одними и теми же значениями.

**Solutions-специфичных правил в этих регионах нет и быть не должно.**
Шапка и подвал приняты при редизайне главной и являются общими
компонентами; подгонять их под отдельный Figma-инстанс страницы Solutions
не нужно (DECISIONS.md, Р-101).

Сетку подвалу и тизеру даёт общее правило `body.home .container,
body.page-template-page-solutions .container` — секции страницы задают
`.container` сами и идут ниже по файлу, их это не затрагивает.

### Contacts — один компонент и одна форма на две страницы

`.contacts` выводится на главной (`main-page.php:1313`) и на Solutions
(`page-solutions.php:1078`). Разметка секции у страниц своя, а **форма общая**:

```
template-parts/contacts-form.php      ← <form class="contacts__form">
    get_template_part('template-parts/contacts-form')                        ← главная
    get_template_part('template-parts/contacts-form', null, ['show_select' => false])  ← Solutions
```

Параметр один: `show_select`. Он управляет блоком «How can we help you?»,
которого нет в макетах Solutions. Поле `clientOption` на сервере проверяется
только при наличии в запросе, поэтому без него отправка работает как обычно.
Больше в форме ничего не ветвится: `name`, `id`, `data-*`, тексты ошибок,
список 235 стран, четыре варианта select, чекбокс согласия, капча и
`send_contacts_form` — общие.

Перед подключением формы шаблон обязан подключить
`template-parts/contacts-icons.php` — оттуда берутся иконки полей.

**Фокус полей.** Рамка обёртки при фокусе задаётся через `:focus-within`:
в тёмной базе — `.input-form-block:focus-within` рядом с существующей
группой `:has(...)`, в светлой теме — парой `body.home .contacts …` /
`body.page-template-page-solutions .contacts …` с `--nv-primary`.
`:has(.input-form:focus)` одного не хватает: у `textarea` нет класса
`.input-form`, а в светлой теме правило проигрывает по специфичности
(DECISIONS.md, Р-110). Правило светлой темы стоит **выше** `.is-error`,
чтобы ошибка не перекрывалась фокусом.

Известное ограничение: `.help-select__control` на главной — `div`
с `tabindex="-1"`, с клавиатуры недостижим (BACKLOG A-45).

Структура секции на Solutions (2456:16687):

```
.contacts.section#cta .container .contacts__wrapper
  .section__badge                      Contacts
  .contacts__content                   сетка 580 + 48 + остаток
    .contacts__title-block             H2 + оранжевый подзаголовок
    .contacts__actions .contacts__card оранжевая карточка: заголовок,
                                       «Email us» и «Message us» в ряд
    .contacts__form-block              карточка формы, внутри template-part
```

Отличия от главной: нет блока «Here's what you'll get», нет кнопки и
разделителя в оранжевой карточке, нет select. CSS — общий регион `CONTACTS`
(7629–9720): базовые правила перечисляют оба контекста, ниже подблок
отличий Solutions и правила в media-запросах.

### FAQ — один компонент на две страницы

`.faq` живёт и на главной (`main-page.php`), и на Solutions
(`page-solutions.php`). Разметка одинаковая, данные разные:

```
.faq .container .faq__wrapper
  .faq__left
    .faq__title-block   .section__badge + .faq__title-text (h2 + p)
    .faq__cta           текст + кнопка .open-callForm2
  .faq__right .faq__list
    .faq__item[--open|--static]
      .faq__item-wrapper
        button.faq__item-question[aria-expanded][aria-controls]
          span.faq__item-question-text + span.faq__item-question-icon (шеврон)
        .faq__item-answer[role=region][aria-labelledby] > .faq__item-answer-text
```

- Вопрос **с ответом** — `<button>` с `aria-expanded` и `aria-controls`;
  id панели `faq-answer-N`, id кнопки `faq-question-N`.
- Вопрос **без ответа** (`faq__item--static`) — `div`, не в фокусе, без шеврона.
  Ветка нужна на случай вопроса без текста; на Solutions с 2026-10-12
  не используется — ответы есть у всех пяти.
- Данные: `$nv_faq_items` на главной (8 вопросов), `$nv_solutions_faq`
  на Solutions (5 вопросов от заказчика, поля `question` / `answer` /
  `initial_open`). На Solutions `answer` — **массив абзацев**: каждый
  печатается отдельным `<p>`, пустые отбрасываются через `nv_has_content`.
  `.faq__item-answer-text` — flex-колонка с `gap: 12px` и `p { margin: 0 }`,
  поэтому несколько абзацев поддерживаются без правок CSS.
- JS — общий `initFaq()` в `js/main.js`: одновременно открыт один элемент,
  высота панели считается по содержимому, второго обработчика нет.
- CSS — регион `FAQ` (15761–16502). Базовые правила перечисляют оба контекста
  (`body.home` и `body.page-template-page-solutions`), ниже идёт подблок
  отличий Solutions: ширина левой колонки 600 на Full HD, планшетная
  раскладка в столбик и мобильная типографика из фрейма 392.
  Прежние тёмные `.faq*` без скоупа остались для других шаблонов.

## 2.1. KYC — `page-kyc.php` → `/kyc/`

Тексты — `inc/kyc-data.php`, иконки — `inc/kyc-icons.php`, JS — `initKycPage()` (состояния в `data-kyc-states`).

С follow-up-1 (2026-10-17) **6 секций вынесены в общие с Identity data-driven partials**
(`get_template_part(..., $args)`, значения по умолчанию в самом partial = прежний текст/
классы/ID KYC, поведение не изменилось):

| Секция | Класс | Partial | Состояния |
|---|---|---|---|
| Первый экран | `.main.main--hero` | `template-parts/kyc-hero-section.php` — универсальный блок (2026-10-21): `media` (кадры fhd/desktop/laptop/tablet/mobile), 3–4 факта, `mobile_text`; CSS — `css/blocks/main-hero.css` | — |
| Сертификации | `.idv-certs` | `template-parts/certs-section.php` — универсальный блок (2026-10-21): `marks` 0–N, `chips` 0–N; CSS — `css/blocks/idv-certs.css` | — |
| Process | `.solutions-why.solutions-why--kyc` | `.solutions-why`, 5 карточек | 1–5, `initSolutionsWhy()` |
| How KYC Works | `.kyc-steps` в `.solutions-products__panel` | `template-parts/kyc-steps-section.php`; CSS — `css/blocks/steps.css` | Step 1–4 (окно / лента); на 992–1199.98 окно листается ещё вертикальным свайпом и колесом над окном, на крайних шагах жест уходит странице |
| Risk-Based KYC | `.kyc-risk` | `template-parts/kyc-risk-section.php` — универсальный блок (2026-10-21): 2–4 вкладки, иконка — аргумент, `side` необязателен; CSS — `css/blocks/kyc-risk.css` | 2–4, `initKycPage()` |
| Platform | `.kyc-platform` | `template-parts/kyc-platform-section.php` — универсальный блок (2026-10-21), аргументы `top`/`audit`/`pair`/`screen`/`summary`; CSS — `css/blocks/platform.css` | — |
| Compliance | `.kyc-compliance` + `.kyc-marker` | `template-parts/kyc-compliance-section.php` — универсальный блок (2026-10-21): 2–6 маркеров + общий; CSS — `css/blocks/kyc-compliance.css` | FATF + 4 страны |
| Southeast Asia | `.kyc-sea` | `template-parts/kyc-sea-section.php` — универсальный блок (2026-10-21): `countries[]` 1–6, `rows` необязательны; CSS — `css/blocks/kyc-sea.css` | 1–6 стран |
| Industries | `.kyc-industries` | `template-parts/kyc-industries-section.php` — универсальный блок (2026-10-21), только `tags`; CSS — `css/blocks/industries.css` | 3–6 карточек |
| Pricing | `.kyc-pricing` | `template-parts/kyc-pricing-section.php` — универсальный блок (2026-10-21): цена, `plans` 1–3, все тексты аргументы; CSS — `css/blocks/kyc-pricing.css` | — |
| About | `.kyc-about` | `template-parts/kyc-about-section.php` | — |
| Integration / Contacts / FAQ | `template-parts/*-section.php` | общие со `/solutions/`; Integration — универсальный блок; Contacts — `section_id`/`badge`/`title`/`lead`; FAQ — `section_id`, ссылки в ответах | FAQ 11 |

Общие примитивы: `.kyc-card` (`--filled`, `--accent`), `.kyc-token`, `.kyc-icon-box`, `.kyc-btn`, `.kyc-title`, `.kyc-lead`.

## 2.2. Identity Verification — `page-identity-verification.php` → `/identity-verification/`

Тексты/иконки — `inc/identity-verification-data.php`, `inc/identity-icons.php`. Переиспользует
примитивы и JS KYC (`.kyc-card`, `.kyc-title`, `.kyc-steps`+`initKycPage()`), **6 общих с KYC
partials** (hero/steps/platform/industries/pricing/about — см. 2.1) и общие
Integration/Contacts/FAQ/News partials (`template-parts/*-section.php`, последний — новый,
вынесен из `main-page.php` без изменений).

| Секция | Класс | Откуда | Состояния |
|---|---|---|---|
| Первый экран | `.main.main--hero` | `kyc-hero-section.php` — тот же универсальный блок, без модификатора | — |
| Certs | `.idv-certs` | `certs-section.php` — тот же универсальный блок | — |
| Checks | `.idv-checks` | `idv-checks-section.php` — универсальный блок (2026-10-21), 2–6 карточек; CSS — `css/blocks/idv-checks.css` | — |
| How it works | `.kyc-steps` | `kyc-steps-section.php`, reuse KYC | Step 1–4 |
| Platform | `.kyc-platform` | `kyc-platform-section.php` — тот же универсальный блок, без модификатора | — |
| Coverage | `.idv-coverage` | новое, 3 отдельных tabpanel, `initCoverage()` | Documents (16 фото)/Regions (карта+флаги)/SEA |
| Accuracy / NIST | `.idv-accuracy` | новое | — |
| Industries | `.kyc-industries` | `kyc-industries-section.php` — тот же универсальный блок, без модификатора | — |
| Benefits | `.idv-benefits` | `idv-benefits-section.php` — универсальный блок (2026-10-21): 2–4 карточки + promo; CSS — `css/blocks/idv-benefits.css` | — |
| Pricing | `.kyc-pricing` | `kyc-pricing-section.php` — тот же универсальный блок | — |
| About | `.kyc-about idv-about` | `kyc-about-section.php` | — |
| API & SDKs | `template-parts/integration-section.php` | универсальный блок, `nv_integration_preset()` + свои `slides`, `deploy` пустой | 1-й слайд REST API |
| Security | `.idv-security` | `idv-security-section.php` — универсальный блок (2026-10-21): 1–3 карточки, регион и карта необязательны; слои карты — `inc/security-map.php`; CSS — `css/blocks/idv-security.css` | — |
| Contacts / FAQ / News | `template-parts/*-section.php` | общие | FAQ 11 |

`initCoverage()` — отдельный guarded-контроллер в `js/main.js` (не часть `initKycPage()`):
с follow-up-1 переключает `hidden`/`.is-active` на реальных DOM tabpanel (`[data-coverage-panel]`,
по одному на состояние, текст каждого — в разметке, не только в JSON), справа переключается
целиком видимый визуал-блок. С follow-up-2 (V2-07) — **progressive enhancement**: PHP больше не
рендерит `hidden` на панелях 2/3, а CSS скрывает неактивные только при `[data-coverage-ready]`,
который выставляет сам `initCoverage()` при успешной инициализации (`activate(0)` в начале
функции) — без JS читаемы все 3 состояния, с JS поведение не изменилось. Заголовки Accuracy/
Security — дословно из Figma несмотря на видимое несоответствие смыслу секции (копипаст в
макете, см. CHANGELOG 2026-10-17).

Platform-экран (`.idv-platform__screen-img` поверх `.kyc-platform__laptop`) — follow-up-2 нашёл и
исправил критичный баг: скриншот интерфейса был ПОЛНОСТЬЮ скрыт непрозрачным чёрным экраном
ноутбука (отсутствовал z-index у оверлея + неверная геометрия выреза экрана, `height:auto` давал
только ~40% нужной высоты). Follow-up-3 нашёл корневую причину самого силуэта ноутбука: исходный
`imgMacbookPro.png` 2011×1183 (landscape) был сконвертирован в 400×489 БЕЗ сохранения пропорции
ещё на этапе создания файла (не CSS-баг) — пересобран через `cwebp -resize`, `.idv-platform__
laptop-wrap` теперь `aspect-ratio:2011/1183`. Security-карта (`.idv-security__map`) переведена на
ту же технику слоёв, что Coverage SEA (нативный размер + `transform:scale` под компактный слот);
follow-up-3 заменил набор на точные 16 слоёв node 2642:30982 (рамка 369×360, была смесь с
9-слойной Coverage SEA и неверными 481×233).

Coverage Documents (`.idv-coverage__docs-grid`) — follow-up-3 перестроил на 3 явных
`.idv-coverage__docs-row` (5/6/5 карточек без переноса, flex:1 на каждой) вместо сетки мелких
90×128 карточек с переносом — по образцу Figma source (references/1920-coverage.png). По ходу
найден и исправлен баг: после перевода `.idv-coverage__row` на `display:contents` для FHD
3-колоночной раскладки, `.idv-coverage__visual` стал grid- вместо flex-элементом — цепочка
percentage-height (panel→grid→row→doc) переставала резолвиться, документы схлопывались до 0px.
Исправлено `.idv-coverage__visual{display:flex}` + `flex:1` на активной панели.

**follow-up-5**: найдена отдельная, более глубокая причина «сдвинутого вправо» ряда документов
на Tablet/Mobile. `.idv-coverage__row{align-items:flex-start}` задан под row-направление
(≥1200px, где влияет только на вертикаль), но наследуется и в column-направлении
(`@media(max-width:1199.98px){.idv-coverage__row{flex-direction:column}}`), где та же команда
становится КРОСС-осью (шириной): `.idv-coverage__visual` терял стандартное `stretch` и
схлопывался до max-content своего некопируемого ряда документов (662px вместо 360px секции на
392). Добавлен явный `align-items:stretch` в этот же `@media(max-width:1199.98px)` блок.
Боковая колонка FHD-грида (`.idv-coverage > .container{grid-template-columns:... 388px}`,
была 280px) пересчитана под `layout-contracts/coverage-*.json`.

**follow-up-5, продолжение (2026-10-18)**: text-panel/visual overlap 200px — координатор
опроверг «техническую невозможность без абсолютного позиционирования секции» DOM-proof'ом.
Решение component-scoped, не page-scoped: `main` (1420 FHD / 1376 Desktop) — НЕ единая grid/flex-
колонка пропорциональным соотношением (0.94fr:1fr было промежуточным приближением), а
left(680px fixed) + visual(auto) с `gap:0` вплотную (680+740=1420, 680+696=1376 — без зазора).
`.idv-coverage__row` вернул себе реальный `display:flex` (не `display:contents`) и стал одним
grid-item рядом с `.idv-coverage__bottom`/side(388px, gap48, FHD-only). Текстовая панель
(`.idv-coverage__tabs`, `.idv-coverage__panel`) — явные `width:816px;margin-left:64px` внутри
680px левой колонки (64+816=880, на 200px шире самой колонки) — перекрывает `.idv-coverage__visual`
слева. Измеренный overlap — ровно 200px на 1920 и 1440 (`panel.x+panel.width − visual.x`).

**follow-up-5, независимая проверка 1.1.45 (C5-01, 2026-10-18)**: z-index в первой версии overlap
был перепутан — DOM-порядок (visual после left) красил visual НАД панелью по умолчанию, и
комментарий ошибочно утверждал, что так и задумано; `elementsFromPoint()` координатора показал
документы поверх текста, тогда как Figma рисует ПАНЕЛЬ целиком поверх документов. Исправлено:
панель `z-index:2`, visual `z-index:1`. Отдельно найдена причина «visual y64 вместо target y144
относительно секции»: `.section__badge` был внутри `.idv-coverage__head` (внутри `.idv-coverage__
row` с `align-items:flex-start`) — visual (сосед left-колонки в том же row) стартовал вровень с
badge, а не с H2, теряя ~80px. В Figma badge — отдельный элемент НАД всей строкой (y64, 32h),
row (head+visual+side) начинается на y144 (48px разрыв). Badge вынесен отдельным sibling'ом перед
`.idv-coverage__row`; на FHD-гриде понадобился явный `grid-template-rows:auto auto` с
`grid-row` на badge (1) и row/bottom (2) — без этого auto-placement сталкивал badge с уже явно
позиционированным row в одной ячейке. `.idv-coverage__panel` получил `min-height:180px` — это
высота самого длинного состояния (SEA, естественно 180h из-за длинного текста); без неё
Documents/Regions короче (152h) и карточка «прыгает» высотой при переключении вкладок.

**Integration** (`template-parts/integration-section.php`; исторически Identity-only scoped правила — с 2026-10-21 вид один, правила на классе `.integration`) —
follow-up-5: FHD `.integration__path` переведён с вертикального стека (title→nav→slider) на
Grid `264px 476px` (title+controls слева, REST-pane-слайдер справа через всю высоту) — точные
координаты `layout-contracts/integration-1920.json`. 1440 `.integration__path` 600px (было 400,
сжимало slider до ~1/3 ширины). Folder-иллюстрация backoffice-карточки 280×195 на 840/1440
(было 160×112 без источника), 182×127 на 392.

**About** (`template-parts/kyc-about-section.php`, общий с `/kyc/`, Identity через `.idv-about`
модификатор) — follow-up-5, продолжение: верхние 2 карточки (`.kyc-about__accuracy`,
`.kyc-about__documents`) используют `flex:0 0 680px` вместо `flex:1 1 0` на широких ширинах
(≥1200px) — старое правило «случайно» давало верный результат на 1440 (контейнер там ровно
1376=680×2+16), но растягивало карточки до 920px на 1920 (контейнер 1856). Марки
(`.kyc-about__badges img`) — 120h на FHD / 72h на Mobile для Identity (KYC-шные дефолты для тех
же ширин — 72px и 88px соответственно, под собственную 3-колоночную FHD-сетку KYC, не трогались).
`padding-top:1px` на About уже был верно scoped с follow-up-4 (ложная тревога в отчёте координатора
не подтвердилась при повторной проверке). `/kyc/` (3-колоночная собственная FHD-сетка, 521w/782w
карточки, марки 72h, `height:220` фикс.) — не затронут, все правки через
`body.page-template-page-identity-verification .idv-about`.

**follow-up-5, независимая проверка 1.1.45 (C5-02, 2026-10-18)**: `.kyc-about__certs-links{flex-
direction:column}` (KYC-шное FHD-правило под узкую 633px-колонку) наследовалось у Identity, где
cert-row на всю ширину — давало 72h (2 чипа друг под другом) вместо32h (в ряд); явный
`flex-direction:row`. 840: `.kyc-about__certs{padding:16px}` (было 23, `.kyc-card`-дефолт). 392:
`padding-top:32px` у Identity — прошлый комментарий «padding-top1px на всех widemodes» ошибочно
включал Mobile, хотя исходный L-05 явно ограничивал это тремя ШИРОКИМИ modes (FHD/Desktop/
Tablet). Divider высота увеличена до2px (1px формально рендерился, но был едва различим на
сравнении). 1920 topcards: `margin-bottom:16px` на `.kyc-about__head` (было8, терялся разрыв до
stats-row).

**Benefits** (`.idv-benefits`) — follow-up-5, независимая проверка 1.1.45 (C5-03): маскот
(`.idv-benefits__promo-image`) был `position:static` (мелкий full-body) на FHD/Tablet/Mobile —
переведён на `position:absolute` overlay-crop, как было задумано (1440 уже был близко к цели).
Источник-ассет (`identity-benefits-fraud.webp`) — центрированный full-body кадр без отдельного
zoom на голову, поэтому буквальный crop по `benefits-*.json` координатам показывал только
прозрачный край кадра; элемент сознательно укрупнён (не точные px из contracts) для сохранения
духа «крупного нижнего кропа». FHD-колонки сделаны НЕ равными: 3 карточки по412px + promo572px
(было4×452 поровну, `flex:1 1 0`) — `benefits-1920.json` даёт 412×3+572+3×16=1856 ровно. Mobile
`align-items`/`text-align` вернули с `center` на `flex-start`/`left` (была явная ошибка в коде, не
задумано). «Compliance without manual work» оставалась на2 строках при общем Mobile
`.kyc-card__title{font-size:20px}` — добавлен более специфичный селектор
`.idv-benefits__card .idv-benefits__card-title{font-size:18px}` (простой класс-селектор той же
специфичности перебивался общим правилом, расположенным позже в каскаде).

**Platform** (`.kyc-platform.idv-platform`) — follow-up-5, независимая проверка 1.1.45 (C5-04):
Mobile `.kyc-platform__audit-image` был `position:static` (192×192 — размер уже верный с
followup-5, но статичный блок в потоке ПОД текстом, добавляющий карточке лишнюю высоту) —
переведён на `position:absolute` overlay-crop, как на Desktop/FHD; карточка получила
`min-height:320px` (без резерва высоты overlay перекрывал заголовок/текст). `padding-top:1px` у
`.idv-platform` (было64, унаследованный KYC-дефолт — тот же паттерн, что у About).

## 3. Pricing Matrix — `page-price-matrix.php` → `/pricing-matrix/`

**Единственная по-настоящему ACF-управляемая страница.**
С 2026-10-13 — светлый дизайн (DECISIONS.md, Р-127…Р-132).

| # | Разметка | CSS-секция | Данные |
|---|---|---|---|
| 1 | `.main.main--pricing` | `HERO` (18931–19076) | статика |
| 2 | `.calculator#kyc-calculator` | `CALCULATOR` (19078–20556) | цены в `data-`атрибутах, `js/calculate.js` |
| 3 | `.overview` | `OVERVIEW` (21186–21412) | статика |
| 4 | `.packages#packages` | `PACKAGES` (20558–21184) | ACF: тарифы, услуги, цены |

Обёрнуто `CALC PAGE START` (18895) … `END` (21414).

**Первый экран — общий блок `main`, а не свой.** Карточка-фотография та же, что
на /solutions/ (`.main__card`, `.main__media`, `.main__body`, `.main__logo`,
`.main__group`, `.main__content`, `.main__title`, `.main__actions`, `.main__btn`).
Отличия страницы — в модификаторе `main--pricing`:

| Что | Solutions | Pricing |
|---|---|---|
| Колонка текста | 600 / 372 ниже 1600 | 580 на всех десктопных ширинах |
| Над заголовком | — | `.main__breadcrumbs` (ссылка + `/` + текущий раздел) |
| Подзаголовок | `.main__subtitle` | нет |
| Полоса фактов | `.main__facts` | нет |
| Акцентная кнопка | текст, затем стрелка | `.main__btn--lead`: стрелка, затем текст |
| Карточка на 840 | 872 (держала факты) | 560 |
| Фото на мобильной | 360×248, затемнение есть | 360×360, затемнения нет |

Блок `.intro` на странице больше не используется; его CSS-секция удалена
вместе с тёмной версией `CALC PAGE` (Р-128).

Калькулятор: три пакета — DOCUMENT, **LIVENESS**, BASIC. Цена LIVENESS **не вводится**,
считается как BASIC − DOCUMENT в каждой из трёх опорных точек. При LIVENESS блок
«Document Type in Package» скрывается классом `calculator--no-documents`,
дополнительные документы остаются доступны и тарифицируются как доплата.

### Карта компонентов калькулятора

| Компонент | Класс / `id` | Нужен JS | Можно менять разметку |
|---|---|---|---|
| Спойлер | `.calculator__spoiler`, `--open` | да (`setSpoilerState`) | только обёртки |
| Шапка спойлера | `.calculator__spoiler-header` | да (click/keydown, aria) | нет |
| Кнопка спойлера | `.calculator__spoiler-icon` | нет (оформление) | да |
| Содержимое спойлера | `.calculator__spoiler-content` | да (inline `height`) | нет |
| Вкладки пакета | `#calculator-package button[data-pkg]` | да | нет |
| Вкладки типа документа | `#calculator-document-type button[data-dt]` | да | нет |
| Состояние вкладки | класс `.active` + `aria-pressed` | да | нет |
| Поле объёма | `#calculator-volume-number` (`step`, `value`) | да | нет |
| Шаг ±  | `.calculator-volume-step[data-volume-step]` | да | нет |
| Ползунок | `#calculator-volume-range` | да (`--range-progress`) | нет |
| Подпись ползунка | `#calculator-volume-range-value` | да (inline `left`) | нет |
| Подписи диапазона | `.calculator-volume-range-limits` | нет | да |
| Доп. документы | `input[name="extra_documents[]"][data-extra-doc]` | да | нет |
| Междунар. скрининг | `#calculator-international-screening` | да | нет |
| Цена за документ | `#calculator-doc-unit-price` | да (текст) | нет |
| Итоги секций | `#calculator-extra-docs-total`, `#calculator-international-total` | да (текст) | нет |
| Карточка итога | `.calculator__result`, `-default`, `-request` | да (классы состояний) | только обёртки |
| Строки итога | `#calculator-result-*` (9 узлов) | да (текст) | нет |
| Заголовок суммы | `.calculator__result-sum-title` | да (текст) | нет |
| Плашка года | `.calculator__result-itog*` | да (текст) | да (обёртки) |
| CTA | `[data-calculator-trigger]`, `.open-callForm2` | да (`data-calculator-json`) | только обёртки |
| Состояния секции | `.calculator--below-min-volume`, `--above-max-volume`, `--no-documents` | да | нет |

Данные о пакете уезжают в модалку через `data-calculator-json` на CTA —
переименование `id` результатов сломает и это тоже.

---

## 3.1. Запись блога — `single.php` → `/<slug>/`

Светлый дизайн с 2026-10-13 (DECISIONS.md, Р-133…Р-138).

| Узел | Разметка | CSS |
|---|---|---|
| Секция статьи | `.post` | `css/post.css`, секция `BLOG POST LIGHT` |
| Оглавление | `.post-sidebar` → блок `acf/toc` | `blocks/toc/toc.css` |
| Шапка статьи | `.post__header`: `.post-title`, `.post__meta`, `.post__thumbnail` | `post.css` |
| Лид | `.post-intro` (вывод `the_excerpt()`) | `post.css` |
| Текст | `.post-text.entry-content` | `post.css` + CSS блоков |
| Низ страницы | `.post-bottom`: карточка автора, его статьи, форма | `post.css` + `styles.css` |

**Что нельзя сломать:**

- **Светлые правила ограничены `body.single-post`.** `css/post.css` подключается
  глобально, а классы `.post`, `.post-content`, `.post-text`, `.post__content`,
  `.post-sidebar`, `.breadcrumbs` используют ещё `page-docs.php`
  и `single-document.php`. Тёмная часть файла обслуживает документацию,
  её трогать нельзя; светлая идёт ниже, отдельной секцией.
- **Абзацы статьи — через дочерний комбинатор** `.post-text > p`. У него и
  у правил врезок (`.post__content .warning__content p`) одинаковое число классов;
  без `>` статья перекрывает цвет врезок.
- **Форма под статьёй** переиспользует светлые правила формы секции Contacts:
  селекторы `body.page-template-page-solutions .contacts X` имеют двойники
  `body.single-post .post__form X`. Разметка форм совпадает — при правке одной
  проверять вторую.
- **Сетка:** сайдбар ровно 436, статья `flex: 0 1 1080px`. Ниже 1200 сайдбар
  становится выдвижной панелью — поведение и классы (`is-open`, `.sidebar-overlay`,
  `.post-sidebar-btn`, `.post-sidebar-btn-mobile`) менять нельзя, ими управляет
  `js/main.js`.
- **Обложка** выводится только если `blog_image()` вернул непустую строку:
  у вложения должны быть размеры `blog_1x/2x/3x`.

---


**Низ страницы записи (`post-bottom`):** слева — карточка автора и «Check out other articles»; справа —
`template-parts/post-comments.php` (форма и список комментариев), если комментарии у записи открыты
или уже есть, иначе прежняя лид-форма `.post__form` (Р-142).

## 4. Общие блоки

### Header — глобальная шапка (`header.php`, Р-141)

Один компонент на весь сайт, светлый на всех шаблонах. Токены `--nv-*` объявлены на `.header`.

| Часть | Класс / файл | Роль |
|---|---|---|
| Плейсхолдер | `.header` | высота 80px (64px на Mobile), в потоке |
| Панель | `.header__bar` | `position: fixed`, z-index 900; `.is-scrolled` → нижняя линия (sticky) |
| Карточка | `.header__shell` | 24px радиус, 16px на Tablet; открыта → `.header.is-open` |
| Меню | `.header__nav` > `.header__list` > `.header__item[data-menu]` | `<nav aria-label="Main navigation">`; `button.header__trigger` (aria-expanded/-controls) или `a.header__link` |
| Панели | `.header__panel--products/--industries/--resources`, внутри `.mega*` | mega-menu; на Mobile — аккордеон и экраны |
| Products | `.mega__item` (выбор) + `.mega__pane` (карточка, «Details», ссылки) + `.mega__col--promo` | вложенное состояние внутри одной панели |
| Язык | `.header-language` (корень) | UI без мультиязычности, `data-language-code`; скрывается одним правилом |
| Кнопки | `.header-btn--primary/--secondary`, `--small/--regular` | CTA `.open-callForm2` / `.open-callForm` (модалки `footer.php`) |
| Бургер, Back | `.header__burger`, `.header__back` | только Mobile |
| Затемнение | `.header__overlay` | `rgba(33,33,33,.6)` + `blur(4px)`, только Desktop/Tablet |
| Данные | `inc/header-menu.php` | `nv_header_menu()`, `nv_header_languages()`, `nv_header_current()`, `nv_header_latest_posts()` |
| Иконки | `inc/header-icons.php` | `nv_header_icon('angle'|'chev'|'arrow'|…)` |
| Поведение | `initHeaderMenu()` в `js/main.js` | один контроллер: `root`, `product`, `view`, `menuOpen`, `lang`, `pinned`, `scrolled` |

Состав меню меняется только в `inc/header-menu.php` (пункт с `'exists' => false` — плановый URL).
Старые `.header__menu`, `.burger`, `.submenu`, `.btn--header` удалены.


| Блок | Где | CSS-секция |
|---|---|---|
| `.btn` + модификаторы | везде | 215+ |
| `.section`, `.section__badge`, `.section__title` | все страницы | по секциям |
| `.page-nav` | главная, solutions | 1503–1741 |
| `.header`, `.header__*`, `.mega*`, `.header-language*`, `.header-btn*` | `header.php` | `HEADER` (одна секция, `HEADER START`/`HEADER END`) |
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

| id | Модификаторы | Тема | Назначение |
|---|---|---|---|
| `callForm` | `modal--form modal--large` | светлая | большая форма: Name, Company, E-mail, Phone, услуга, сообщение |
| `callForm2` | `modal--form modal--compact` | светлая | малая форма: Name, E-mail, Phone, сообщение |
| `review` | — | **тёмная** | просмотр отзыва, редизайн его не касался |
| `thanks` | `modal--result` | светлая | успешная отправка |
| `error` | `modal--result` | светлая | ошибка отправки |

Светлый дизайн модалок (2026-10-12) держится на модификаторах, а не на
классе страницы: окна глобальные и выглядят одинаково на любом шаблоне.
`#review` модификаторов не получает и поэтому остаётся тёмным.

**Оформление полей не дублируется.** Разметка модалок использует тот же
словарь классов, что и `template-parts/contacts-form.php`, поэтому правила
светлой формы в регионе `CONTACTS` перечисляют три контекста:
`body.home .contacts`, `body.page-template-page-solutions .contacts`
и `.modal`. В регионе `MODAL` лежит только своё: подложка, габариты окна,
раскладка в столбик с разделителями, светлые выпадающие списки, кнопка
закрытия и мобильная раскладка окон результата.

Токены `--nv-*` объявлены на `.modal--form` и `.modal--result` — иначе
на тёмных шаблонах (`/pricing-matrix/`, `/docs/`, `/blog/`, 404) у модалки
не было бы значений.

Геометрия по макетам:

| | Десктоп | Планшет | Мобильная |
|---|---|---|---|
| большая | 901x712, поле 24 | 600, поле 16 | 360, поле 12 |
| малая | 640x676, поле 24 | 600, поле 16 | 360x644, поле 12 |
| результат | 480 | 480 | 360, в столбик |

**Что нельзя ломать:** `data-form-id` назначается в `js/form.js` по порядку
форм в DOM (`contacts-form-N`), поэтому порядок форм на странице менять
нельзя. hCaptcha живёт в `.captcha-holder`, стилизуется только обёртка.

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

Поля каждого блока, `field_`-ключи и форма `attrs.data` для импорта —
в `docs/BLOG-IMPORT-GUIDE.md`.

### Что нельзя сломать в блоках

**Заглушка пустого блока.** Шаблоны выходят через `return`, когда поля не заполнены.
В блочном редакторе такой блок получает нулевую высоту: его не видно и нельзя
выделить, чтобы заполнить. Поэтому перед каждым `return` в ветке «нет данных»
стоит `nv_block_placeholder($is_preview, 'Название', 'Подсказка')`
(`inc/block-helpers.php`). На сайт заглушка не попадает: при `$is_preview === false`
помощник возвращает пустую строку. Новый блок — заводить с таким же выходом.

Оформление заглушки — `css/editor-blocks.css`, подключается через
`add_editor_style()`. Через `enqueue_block_editor_assets` нельзя: с WordPress 6
канва редактора — отдельный iframe, и такие стили в неё не попадают.

**Шим quicktags.** `js/admin-blocks.js` обязателен, пока не обновлён ACF Pro:
без него каждый блок с WYSIWYG-полем падает в редакторе с «Этот блок содержит
ошибку и не может быть просмотрен» (`docs/BACKLOG.md`, B-27). Скрипт подключён
с зависимостью от `quicktags` — без зависимости ядро перезаписывает функцию
уже после шима, и он перестаёт работать.

**Режим блока (`acf.mode` в `block.json`).** `preview` — поля редактируются
в правой панели блока, канва показывает живой предпросмотр; `auto` — при выделении
канва показывает форму полей. Выбор не косметический: TinyMCE работает только
в родительском документе, то есть только в панели. Поэтому блоки, где WYSIWYG —
основное поле (`spoiler`, `note`, `warning`, `success`, `disclaimer`, `quote`,
`result`, `about`, `callout`), стоят в `preview`, а блоки с репитерами — в `auto`
(репитер в узкой панели нечитаем). Подробности — `docs/DECISIONS.md`, Р-139, Р-140.

**Стили формы в канве.** `functions.php` дописывает каждому блоку
`editor_style_handles`: `acf-input`, `editor-buttons`, `buttons`. Без них поля
в канве выглядят как голая HTML-форма — стили ACF и ядра в iframe не попадают.

**Иконки врезок** `warning`, `success`, `disclaimer`, `note` выводятся inline-SVG
с `fill="currentColor"`; цвет глифа задаёт `color` на `.<block>__icon` в CSS блока.

**Поля, которых нет.** Шаблоны `single-image`, `two-images`, `slider` читают
`nv_sourcelink`, `gallery_image_sourcelink`, `slider_sourcelink` — таких полей
в группах ACF нет, ветка со ссылкой-источником не выполняется никогда
(`docs/BACKLOG.md`, B-28).

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
| 6 | How it works | ✅ сделано, новая секция | группа 5 |
| 7 | Why us | ✅ сделано | группа 5 |
| 8 | Clients / Trusted | ✅ сделано, карта добавлена (R-14 закрыт) | группа 4 + доработка |
| 9 | Pricing | ✅ сделано, новая секция | группа 4 |
| 10 | Developers | ✅ сделано | группа 4 |
| 11 | Blog | ✅ сделано, вывод из WP_Query | группа 6 |
| 12 | FAQ | ⚠️ сделано, на главной нет 7 ответов (R-18); на Solutions тексты заказчика от 2026-10-12 | группа 7 |
| 13 | Contacts | ✅ сделано, оформление | группа 8 |
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

---

## 15. Группа 5 — How it works, Why us

### How it works — `.how`

Секция новая, вставлена между Products и Why us. Три блока — шаги,
оранжевая плашка, блоки размещения — переставляются на каждом из трёх
макетов, поэтому `.how__layout` сделан через `grid`: разметка одна,
меняются только колонки и строки.

| Макет | Раскладка |
|---|---|
| Full HD `2380:23002` | слева шаги, справа сверху два блока размещения, под ними широкая плашка |
| Desktop `2298:32163` | три колонки: шаги (тянется), плашка 324, блоки размещения 340 |
| Tablet `2376:16830` | шаги (тянется) и плашка 240 в ряд, блоки размещения под ними |
| ≤767.98 | одна колонка (мобильного макета нет) |

Различия по типографике между фреймами:

| | Full HD | Desktop | Tablet |
|---|---|---|---|
| номер шага | 52/64, ширина 96 | 52/64, ширина 80 | 40/52, ширина 56 |
| отступы карточки шага | 12 / 24 | 16 / 24 | 16 |
| зазор номер → текст | 48 | 24 | 24 |
| заголовок плашки | H2 40/52 | H3 32/48 | H3 32/48 |
| заголовок блока размещения | H3 32/48 | H4 24/36 | H4 24/36 |
| угол градиента плашки | 171° | 122° | 122° |

Иконка плашки позиционируется абсолютно: в макете Full HD у неё
отрицательный нижний отступ и она перекрывается с текстом по вертикали.
Текст прижат к низу — так одна раскладка работает на всех трёх фреймах.

3D-картинки выходят за карточку и подрезаются ею (`overflow: hidden`).
Размер окна и сдвиг картинки внутри взяты из макета отдельно для каждого
фрейма, поэтому видимая часть совпадает:

| | окно | картинка внутри |
|---|---|---|
| Cloud, Full HD | 239×159, right 12, bottom 0 | 239×238.5, top −8.22 |
| Cloud, Desktop | 187×125, right −1, bottom −1 | 187×187.5, top −6.46 |
| Cloud, Tablet | 209×148, right −1, bottom 0 | 223×222, top −7.65 |
| On-prem, Full HD | 227×156, right −1, bottom −1 | 216.9×217.85, left 12.24, top −6.61 |
| On-prem, Desktop | 185×109, right −1, bottom −1 | 152×152.2, left 8.58, top −4.62 |
| On-prem, Tablet | 196×147, right −1, bottom −1 | 205.2×205.3, left 11.58, top −6.23 |

Ассеты: `img/how-cloud.webp` (239×239, 8 КБ) + `@2x`,
`img/how-onprem.webp` (217×217, 5 КБ) + `@2x`. Выгружены из Figma
в максимальном нужном размере (Full HD), на остальных фреймах уменьшаются.

### Why us — `.advantages`

Секция переписана. Было восемь карточек с иконками и маскотом, стало шесть
карточек вокруг снимков экранов приложения.

| Макет | Раскладка |
|---|---|
| Full HD `2380:23078` | три колонки, снимки 360.74 по центру, зазор 48 |
| Desktop `291:7937` | то же, снимки 433.41 |
| Tablet `2376:16906` | карточки в две колонки построчно, снимки под ними |
| ≤767.98 | одна колонка |

На планшете карточки идут **построчно** (1-2, 3-4, 5-6), а в разметке они
разложены по двум колонкам. Чтобы не дублировать разметку, колонкам задан
`display: contents` — все шесть карточек попадают в общую сетку в нужном
порядке. Снимкам задан `order: 1`, иначе они встали бы между колонками.

Ассет `img/why-us-phones.webp` (434×525, 29 КБ) + `@2x` собран из
оригинальных ассетов Figma: рамка телефона, SVG-маска и снимок экрана
под маской — та же геометрия, что в макете, отрисована в растр с альфой.

⚠️ Старые правила `.advantages__row*`, `.advantages__col-1/-2`,
`.advantage__item-icon`, `.advantage__item--image-hover`,
`.advantage__item--fill-image` **оставлены** в блоке: их используют запасные
шаблоны `index.php` и `main-page-video-autoplay.php`.

---

## 16. Группа 6 — Blog

### Откуда берутся данные

Секция выводит реальные записи WordPress. До группы 6 она была статической:
пять захардкоженных карточек без `WP_Query`, скрытых правилом
`.news { display: none }` (правило пришло с темой, до редизайна).

```
new WP_Query([
    'post_type' => 'post', 'post_status' => 'publish',
    'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'DESC',
    'ignore_sticky_posts' => true, 'no_found_rows' => true,
])
```

`posts_per_page = 4` — в макете ровно четыре карточки на всех трёх фреймах.
`no_found_rows` — пагинация не нужна.

Карточка: `template-parts/news-card.php`. Логика данных повторяет
`template-parts/article-card.php`:

| Что | Источник |
|---|---|
| просмотры / лайки | `get_post_meta($id, 'post_views' / 'post_likes')` |
| автор | `first_name` + `last_name`, откат на `display_name` |
| должность | `get_user_meta($author_id, 'job_title')` |
| аватар | `get_avatar($author_id, 98)` |
| время чтения | слова контента / 200, минимум 1 |
| анонс | `wp_trim_words(get_the_excerpt(), 32, '...')` |
| обложка | `the_post_thumbnail('large')`, если есть |

⚠️ Общий `article-card.php` **не переиспользуется**: у него другие классы и
оформление, менять его нельзя. **Уточнение 2026-10-17**: `/blog/`, рубрики, поиск и теперь
`author.php` используют `template-parts/blog-card.php` (светлая система); `article-card.php`
используется только AJAX live-поиском блога (`nv_blog_search()` в `functions.php`) — не удалён.

### Пустое состояние

Секция обёрнута в `if ($nv_news_query->have_posts())`. Нет записей —
секции нет в DOM вовсе. Отдельного пустого состояния в макете нет, а пустой
слайдер с нерабочей навигацией показывать нельзя.

Кнопка «Explore All Articles» выводится только если задана страница записей
(`get_option('page_for_posts')`). Сейчас она не настроена — см. BACKLOG R-17.
Заглушки `href="#"` в разметке нет.

### Геометрия

| Макет | Контейнер | Карточка | Зазор | Поведение |
|---|---|---|---|---|
| Full HD `2380:23753` | 1856 | 452×580 | 16 | четыре в ряд, прокрутки нет |
| Desktop `318:9382` | 1376 | 332×580 | 16 | четыре в ряд, прокрутки нет |
| Tablet `2376:17578` | 776 | 360×580 | 16 | слайдер, карточки шире контейнера |
| ≤575.98 | — | 288×540 | 16 | слайдер |

Ширина на десктопе задана формулой `calc((100% - 48px) / 4)` — так карточка
сохраняет размер макета и когда записей меньше четырёх.

Заголовок и анонс занимают ровно три строки (`min-height: 72px` +
`line-clamp: 3`). Без этого картинки в соседних карточках получали бы разную
высоту и блоки автора не выстраивались бы в линию.

На планшете слайды выходят за контейнер до края экрана — так в макете.
Обрезает их унаследованное `html { overflow-x: hidden }`, поэтому
`.news__content` оставлен с `overflow: visible`.

### Стрелки

**Их нет ни на одном фрейме макета** — прежние `.news__arrow` убраны.
`initNewsSlider` к этому готов: все обращения к кнопкам под проверками
на существование. Переключение — свайпом.

### Слайдер

`initNewsSlider` сохранён, изменён один параметр: вместо `slidesPerView`
с брейкпоинтами — `slidesPerView: 'auto'`, ширина слайда из CSS по макету.
Инициализация только ниже 1200px (`matchMedia('(max-width: 1199px)')`),
выше Swiper уничтожается и карточки становятся обычным рядом.
`watchOverflow` сам гасит прокрутку, когда карточки помещаются.

### Состояния

| Элемент | Normal | Hover / focus-visible |
|---|---|---|
| карточка | фон `--nv-surface-2` | `--nv-surface-3` |
| блок автора внутри карточки | `--nv-surface-3` | `--nv-surface-2` |
| заголовок | `--nv-object-1` | `--nv-primary` |
| кнопка | `--nv-surface-2` | `--nv-surface-3` |

Ховер карточки продублирован на `:focus-within` — иначе при переходе
по Tab карточка не подсвечивалась бы.

---

## 17. Группа 7 — FAQ

### Где что лежит

На главной секции FAQ раньше не было. Аккордеон с теми же классами
`.faq__*` формирует FAQ на `/solutions/`, поэтому **все правила главной
ограничены `body.home`**. Отдельный ACF-блок `blocks/faq/` — это другой
компонент (чат-подобный вопрос-ответ в записях), он не затронут.

Контент — массив `$nv_faq_items` в `main-page.php`. Когда утвердят
недостающие ответы (R-18), достаточно дописать строки массива: разметка,
стили и механика уже готовы, кнопка раскрытия появится сама.

### Геометрия

| Макет | Левая колонка | Зазор | Спойлеры | Раскладка |
|---|---|---|---|---|
| Full HD `2380:23774` | 440 | 48 | 1368 | две колонки |
| Desktop `2363:32515` | 440 | 48 | 888 | две колонки |
| Tablet `2376:17599` | 776 | — | 776 | шапка сверху (текст + CTA), спойлеры под ней |
| ≤767.98 | 100% | — | 100% | одна колонка |

На планшете бейдж стоит на своей строке, а текст и блок
«Didn't find your answer?» идут в ряд (496 + 64 + 216). Чтобы не менять
разметку, `.faq__title-block` получает `display: contents` и его дети
попадают в сетку `.faq__left`.

### Спойлер

| | Закрытый | Открытый |
|---|---|---|
| карточка | `--nv-surface-2`, рамка `--nv-surface-4`, радиус 24, паддинг 16 | то же |
| шапка | пунктир по кругу, радиус 12, паддинг 12 / 12 / 12 / 24 | радиус только сверху |
| вопрос | H6 18/24, `--nv-object-1` | то же |
| кнопка шеврона | 32×32, радиус 6, рамка `--nv-surface-4`, фон `--nv-surface-2` | шеврон развёрнут на 180° |
| панель ответа | — | пунктир слева/справа/снизу, радиус снизу 12, текст 18/28 |
| ховер шапки | `--nv-surface-3` | то же |

⚠️ В макете у **открытого** спойлера кнопка шеврона осталась из тёмной
темы: фон `rgba(255,255,255,0.1)`, иконка `#FFFFFF` — на светлом фоне она
не видна. Взят стиль закрытого состояния с поворотом шеврона.

⚠️ Figma рисует обводки **внутрь** габарита, CSS — снаружи. Поэтому паддинги
уменьшены на толщину рамки: карточка `15px` при рамке 1px, шапка
`11px 11px 11px 23px` при рамке обёртки 1px. Расстояние от внешнего края
до вложенного блока остаётся 16 и 12 — как в макете, закрытая строка ровно
**88px**. Если менять паддинг, не трогая рамку, высота разъедется.

Раскрытая карточка — 193 против 192 в макете. Разница в пунктирном
разделителе: в Figma это нижняя обводка шапки, в разметке темы —
`border-top` панели ответа, от которой зависит расчёт высоты в `initFaq`.

### Аккордеон

Переиспользован `initFaq()`, второго обработчика нет. Две правки, обе
безопасны для `/solutions/`:

- `syncExpanded()` пишет `aria-expanded` только если атрибут есть
  в разметке — на `/solutions/` его нет;
- элемент с классом `faq__item--open` в разметке больше не схлопывается
  при инициализации.

Поведение single-open сохранено: открытие одного закрывает остальные.

⚠️ `initFaq` считает высоту панели как `содержимое + поля текста`, причём
ниже 768px прибавляет 32 вместо 48. Поэтому вертикальные отступы ответа
задаются **через `margin` у `.faq__item-answer-text`**, а не через `padding`
панели, и правило `margin: 16px 0` стоит именно в блоке `767.98`.
Если поменять одно без другого — ответ обрежется или появится пустой зазор.

### Доступность

Вопрос с ответом — нативный `<button>` с `aria-expanded` и `aria-controls`;
Enter и Space работают без дублирующей обработки. Панель — `role="region"`
с `aria-labelledby`. `:focus-visible` даёт видимую обводку 2px.
Анимация отключается при `prefers-reduced-motion: reduce`.

Вопрос **без** ответа выводится обычным `<div>` с классом
`faq__item--static`: кнопки нет, курсор обычный, пустая панель не выводится.
Высота строки держится такой же, как у строки с шевроном (`min-height: 56px`).

---

## 18. Группа 8 — Contacts

### Карта зависимостей формы

| Элемент | Разметка | JS | Сервер | Где ещё используется |
|---|---|---|---|---|
| Имя | `input[name=clientName]` | `js/form.js` → `validateForm`, `sanitizeName` | `handle_contacts_form_submission` | `footer.php` (модалка, все страницы), `single.php`, `index.php`, `main-page-video-autoplay.php` |
| Компания | `input[name=clientCompany]` | то же | то же | то же |
| E-mail | `input[type=email][name=clientEmail]` | `sanitizeEmail`, `emailPattern` | то же | то же |
| Телефон | `input[name=clientPhone]` + `[data-phone-field]` | `initPhoneFields` в `form.js` | то же | то же |
| Код страны | `[data-phone-field-code]`, `input[name=clientPhoneCode]` | `initPhoneFields`; код дописывается в `FormData` при отправке | то же | то же |
| Select your option | `[data-help-select-button]`, `input[type=hidden][name=clientOption]` | `initHelpSelect`, `setHelpSelectValue` | то же | то же |
| Сообщение | `textarea[name=clientMessage]` | — | то же | то же |
| Согласие | `input[type=checkbox][name=privacyConsent]` | `validateForm` | то же | то же |
| Отправка | `button[type=submit].btn-form` | `submitForm`, `startButtonLoading` | AJAX `send_contacts_form` | то же |

Внешние интеграции в обработчике: `wp_mail`, Telegram (через Hookdeck),
HubSpot (`HUBSPOT_ACCESS_TOKEN`), hCaptcha. Ключи — в константах, в
документацию не выносятся.

### Почему всё ограничено `body.home .contacts`

Классы формы общие с модалкой из `footer.php`, которая выводится на
**каждой** странице, включая главную. Ограничения одним `body.home` было бы
недостаточно: модалка на главной получила бы светлое оформление, а на
остальных страницах осталась бы тёмной.

Поэтому все 142 добавленных селектора идут от `body.home .contacts`.
Проверка: вычисленные стили `#callForm .contacts__form` на главной до и
после правок совпадают полностью.

### Геометрия

| Макет | Левая колонка | Зазор | Карточка формы | Поле |
|---|---|---|---|---|
| Full HD `2380:23792` | 459 (текст 427) | 48 | 1349 | 638.5 |
| Desktop `322:9869` | 427 | 48 | 901 | 414.5 |
| Tablet `2376:17617` | 776 | — | 776 | 360 |

Оранжевая карточка на Desktop уходит за левый край экрана. Вылет считается
от контейнера: `--nv-bleed: calc((100vw - min(100vw, 1920px) + 64px) / 2)`.
На Full HD вылета нет — так в макете. На планшете карточка уходит под форму.

⚠️ Старое правило `.contacts__card` — `position: absolute; width: 840px;
padding-left: 420px` (так тот же вылет делался в тёмной теме). Новые правила
возвращают карточку в поток, поэтому `position`, `right`, `bottom` и ширина
переопределены явно.

⚠️ `.contacts__form-item` имел `width: calc(25% - 12px)` — в сетке это ломает
колонку, переопределено на `width: auto`.

⚠️ `[data-phone-field-code]` наследовал белый цвет тёмной темы.

### Раскладка формы

| Макет | Раскладка |
|---|---|
| Full HD `2380:23807` | две колонки 638.5 с зазором 24: слева Name, Company, E-mail, Phone (зазор 12), справа селект и текстовое поле (192, начало на y = 84). Разделитель один — перед согласием |
| Desktop и ниже | поток: поля по два в ряд, три разделителя между группами |

Full HD сделан на `grid`: разметка одна, позиции заданы существующими
классами (`.input-form-item--50`, `.help-select`, `:has(.input-form-block--textarea)`).
Абсолютного позиционирования нет, высота текстового поля набирается из
трёх строк сетки — появление текста ошибки раскладку не ломает.

⚠️ `.input-form-item--50` имеет унаследованное `width: calc(50% - 12px)` —
в колонке сетки оно переопределено на `width: auto`.

### Что в макете есть, а в коде намеренно нет

- Опечатка макета «Your Massage» не переносилась — в теме «Your Message».
- Текст согласия взят из темы, а не из макета: менять его нельзя.

### Иконки

`template-parts/contacts-icons.php`, функция `nv_contacts_icon($name, $size)`.
15 иконок из Figma. У `user`, `work`, `check` в макете осталась тень из
тёмной темы — фильтр снят, `viewBox` пересчитан на артборд 24×24
(`dx = (W - 24) / 2`), заливка через `currentColor`.

---

## 19. Группа 9 — Teaser и Footer

Макеты: Desktop 1440 `655:11651`, Full HD 1920 `2380:23846`,
Tablet 840 `2376:17671`, ховеры `2386:37529`.

### Разведение шаблонов

Футер и тизер подключаются **на всех страницах темы**, поэтому светлая
версия сделана так, чтобы остальные страницы остались нетронутыми:

| Файл | Что внутри |
|---|---|
| `footer.php` | `if (is_front_page())` → `template-parts/footer-home.php`, `else` → прежняя тёмная разметка, не изменённая ни на символ. Ниже без изменений: cookie-баннер, `#callForm`, `#callForm2` |
| `template-parts/footer-home.php` | светлый футер главной |
| `template-parts/teaser.php` | общая разметка; на главной подставляется `teaser_logo_primary.svg` вместо `teaser_logo.svg` |
| `css/styles.css` | блоки `TEASER HOME START/END` и `FOOTER HOME START/END` — все селекторы начинаются с `body.home` |

Старые правила блоков `teaser` и `FOOTER` не удалялись и не правились.

### Тизер — вертикаль

`Page edge` 64 → отступ секции 64 → логотип 100 → 32 → текст → 64 до футера.

| Макет | Заголовок | Высота тизера |
|---|---|---|
| Full HD | одна строка 52, `br` скрыт | 416 |
| Desktop | две строки 104, `br` из разметки | 468 |
| Tablet | две строки 104, `br` скрыт, перенос по контейнеру | 468 |

`body.home .teaser::before` — «Page edge» из макета: 64px, фон
`--nv-surface-1`, рамка `--nv-surface-4` слева/справа/снизу, скругление
`0 0 32px 32px`. Фон самого тизера — `--nv-surface-2`.
Свечение `.teaser::after` и маскот в светлой версии не выводятся.

### Футер — сетка

Карточка: `--nv-surface-1`, рамка `--nv-surface-4` сверху и по бокам,
скругление `32px 32px 0 0`, паддинг `63px 31px 32px` (минус толщина рамки —
в Figma обводка внутри габарита). Фон под карточкой — `--nv-surface-2`.

| Макет | Ряд контента | Колонки |
|---|---|---|
| Full HD | 1792 | 812 / 812 / 168, зазор колонок навигации 96, PRODUCTS в две подколонки по три |
| Desktop | 1312 | 572 / 572 / 168, зазор навигации 80, PRODUCTS одной колонкой |
| Tablet | 712 | три ряда: реквизиты, навигация, контакты. У ряда навигации справа 64px запаса — отсюда равные промежутки, как в макете |

Левая колонка: `.footer__brand` (логотип + слоган) и `.footer__details`
(реквизиты + знаки сертификации). На Full HD знаки стоят слева от реквизитов
(`order: -1`) и крупнее — 64px против 48px.

Типографика ссылок навигации: Full HD — Button Regular 18/24,
Desktop и ниже — Button Small 14/20. Прозрачность пунктов 0.7 — как в макете;
ховер меняет цвет на `--nv-primary`, прозрачность остаётся.

### Ассеты

| Файл | Что |
|---|---|
| `img/footer_logo_light.svg` | 302×59, `#212121` + `#FD6B01` |
| `img/teaser_logo_primary.svg` | 62×45, `#FD6B01` |
| `img/footer-badge-iso.webp` + `@2x` | ISO Register Global, 64×64 |
| `img/footer-badge-asib.webp` + `@2x` | ASIB Accreditation International, 50×64 |
| `img/footer-badge-qa.webp` + `@2x` | QA Compliance Assessment, 67×64, в макете обрезан по окружности с зумом |

Иконки — инлайн-SVG с `currentColor`: стрелка 20×20 у кнопки почты,
LinkedIn 24×24 (путь тот же, что в тёмном футере).

### Что в макете есть, а в коде намеренно нет

Всё подтверждено пользователем 2026-10-06.

| В макете | В коде | Причина |
|---|---|---|
| `top@nv.global` | `hello@nv.global` | адрес темы верен, R-24 |
| «User Agreement», «Personal Data Processing Policy» | «Terms of Use», «Privacy Policy», «Information Security Policy Statement» | реальные страницы темы, R-25 |
| «RESOUECES» | «RESOURCES» | опечатка макета, R-28 |
| Telegram в SOCIAL | нет | адреса нет, R-26 |
| Blog в RESOURCES | нет | страница записей не назначена, R-17 |
| Ссылки на шесть продуктов | все на `/#products` | отдельных страниц нет, R-22 |
| Вертикальные рамки контентного блока по всей высоте | только нижний край | по решению пользователя рамки по всей высоте не нужны, R-27 |

Адресный блок **взят из макета полностью**, включая номера:
«IFZA Business Park, DDP, PO Box 342001, Dubai, UAE» + «Reg. 72252 · License 74254»
(R-23). Название юридического лица — в написании темы,
`NEUROVISION GLOBAL INTELLIGENCE - FZCO`.


---

## 20. Раскладки по брейкпоинтам после правок 2026-10-07

Базовый уровень CSS в теме — **Full HD**. Desktop живёт в
`max-width: 1599.98px`, планшет — в `max-width: 991.98px`. До правок пять
секций не имели собственного Full HD-уровня и растягивали Desktop-композицию
на 1856px, а две не имели планшетного.

| Секция | Full HD 1920 | Desktop 1440 | Tablet 840 |
|---|---|---|---|
| **About** | три карточки в ряд 1 : 1 : 1.5 (521 / 521 / 782), блок заголовка 1389, заголовок одной строкой, статистика в две строки с горизонтальным разделителем, знаки 72px | две карточки в ряд + третья на всю ширину, заголовок 1048 в две строки, статистика в две колонки с вертикальным разделителем, знаки 120px | карточки столбиком |
| **Results** | заголовок 1856 на всю ширину, ниже ряд «кейс 576 + четыре карточки 302» | заголовок и кейс в левой колонке 560, статистика сеткой 2×2 | колонка, статистика по две в ряд |
| **Pricing** | карточка цены 560, кнопки столбиком справа от преимуществ | карточка цены 360, кнопки строкой под преимуществами | две колонки 326 + 426, преимущества столбиком, кнопки в ряд |
| **Developers** | левая колонка 503, кнопки призыва в ряд | левая колонка 440, кнопки столбиком | заголовок → две карточки в ряд → полоса поддержки → призыв |
| **How it works** | три колонки `1fr 324 340` | то же | шаги и плашка в ряд, размещение под ними |

### Приёмы, которые тут использованы

- **`display: contents`** — `.results__intro` на Full HD и `.doc__info` на
  планшете: дочерние блоки становятся элементами внешней сетки, и порядок
  задаётся `order`. Разметка не дублируется.
- **`min()` для фиксированных колонок** — `.how__layout` в
  `max-width: 1199.98px`: до 1050px ширины макетные, ниже столбцы ужимаются
  вместе с окном. Так нет ни обрезки, ни скачка на границе брейкпоинта.
- **Доля вместо `flex-basis: 0`** — `.about__card`, `.results__stat`:
  при нулевой базе Chrome раздаёт свободное место поверх `padding` и
  `border`, и доли уезжают на 7–15px. База задаётся через `calc()` от 100%.
- **Паддинг минус толщина рамки** — Figma рисует обводку внутрь габарита,
  поэтому `padding: 15px` там, где в макете 16.

---

## 21. Юридические страницы — `page-privacy.php`

Один шаблон на три страницы: Terms of Use (314), Privacy Policy (306),
Information Security Policy Statement (582). Отдельных шаблонов и копий
CSS под них нет и заводить не нужно (DECISIONS.md, Р-122).

### Разметка

```
main.content-page
└── .container.small-container
    └── .page__wrapper
        ├── .page__header
        │   ├── h1.page__title        ← the_title()
        │   └── .page__last           ← дата из get_the_modified_date()
        └── .page__content            ← the_content()
```

Ниже шаблон подключает общий `template-parts/teaser.php` и `get_footer()`.

**Контент идёт только из `the_content()`.** Текст юридических страниц
в шаблон не переносится и не правится в коде — редактируется в админке.

### Что общее, а что только здесь

| Класс | Где ещё используется |
|---|---|
| `.section-404`, `.section-404__image` (бокс 737×473 + `__picture` + `__shadow`), `.btn-hero` внутри `.section-404` — серая animated button | `404.php`, всё под `body.error404` |
| `.blog-hero`, `.blog-archive`, `.blog-card` (+`--featured`), `.blog-cats`, `.blog-news`, `.blog-pagination`, `.blog-search`, `.blog-tab` | `template-parts/blog-archive.php`, `blog-card.php` (`search.php`, `blog-page.php`, `category.php`); всё под `body.nv-blog`, стили — `css/blog.css`, регион BLOG ARCHIVE LIGHT |
| `.blog-hero--author`, `.blog-archive--author`, `.author-profile*`, `.author-layout`, `.author-content` | Только `author.php`. `template-parts/blog-hero.php` — hero вынесен из `blog-archive.php` в отдельный partial (переиспользуют category/page/search/author), на Mobile скрыт только для author. Профиль: avatar140 (Mobile216) rounded24/32 + border primary, identity (name24/36 bold + job18/24 bold) + socials (реальный `user_url` + для `user_nicename==='neurovision'` реальный LinkedIn из footer), bio ниже (`description`, honest-empty если пусто). FHD — профиль слева 440px колонкой, контент справа, topics СПРАВА от сетки (`grid-template-areas:"main cats"`); Desktop/Tablet/Mobile — сверху/слева, как у category. Card-геометрия свои mode-значения (442×296/333.33×176/364×184/344×224, не category), та же inside-stroke техника (R2-01). Corporate-аватар — `img/author-corporate-mark.png` (официальный N-mark, не `get_avatar()`), определяется по `user_nicename`, не по ID. `article-card.php` этим шаблоном больше не используется (см. выше) |
| `.blog-hero--category`, `.blog-archive--category`, `.blog-cats--category`, `.blog-cats__active`, `.blog-cats__divider`, `.blog-tab__icon` | Только `category.php` (context `category` в `blog-archive.php`). Grid 4/3/2/1 колонки (не 2/3 как у page/search), `grid-template-areas: "cats" "main"` на ≤1199.98 (без зарезервированной пустой строки `news`), H1-зона `min-height:104` с выравниванием по низу на Desktop/FHD (голова секции 152px, сетка с y=612), autoheight на Tablet/Mobile. H1/активная пилюля/её строка в списке — term+count через единый `$grid->found_posts` (R2-12), остальные термины сайдбара — `term->count`. Активная рубрика рендерится **дважды в DOM** — отдельная пилюля (`.blog-cats__active`, видна на Desktop/FHD, 2 разделителя) и обычный пункт списка (`.blog-cats__list li.is-current`, видна на Tablet/Mobile первой через `order:-1`, 1 разделитель) — нужный вариант скрывается `display:none` на каждой ширине. Если текущий term исключён `hide_empty`, PHP добавляет его в `$categories` перед рендером — он проходит тот же путь, что и обычный term, без отдельного состояния (follow-up 2, R2-05; `--empty-active` удалён). Карточка/`__author`/`__stat`/`__time`/табы/поиск — Figma-обводка INSIDE воспроизведена как `box-shadow: inset` вместо `border` (R2-01), иначе внутренняя ширина/высота были на 2px меньше mode-значений; media-лесенка FHD 324/260 / Desktop 329.333/260 / Tablet 364/292 (+padding-bottom:16) / Mobile 344/284 (R2-02). Карточка на Mobile — `border-radius:12` (не 24, R2-08). Иконка таба — слот 24×24 на ≥768px для всех трёх, свои 20×20/24×20 на Mobile (R2-07). Табы с иконками (`nv_blog_icon('document'|'network'|'play')`) только у category. Hero Mobile 548px, заголовок Martel Bold (локальный шрифт, алиас `'Martel Blog Category'`) 52px/92px, подзаголовок 20px/32px, маскот Desktop/FHD 287×179, Tablet/Mobile 216×135 (фиксированные стороны + `object-fit:cover`, не `height:auto`) и Figma-кроп текстуры на Mobile (у page/search маскот на ≤575px скрыт, текстура/обводки — общие) |
| `.content-page` | `404.php` (`content-page page-404`) — **базовые правила не трогать** |
| `.page__wrapper`, `.page__header`, `.page__title`, `.page__last`, `.page__content` | только этот шаблон |
| `.container`, `.small-container`, `.teaser`, `.footer`, `.header` | общие компоненты темы |

Поэтому светлые правила собраны в регионе `LEGAL PAGE LIGHT` блока `PAGE`
и целиком ограничены `body.page-template-page-privacy`. Базовые тёмные
правила блока `PAGE` остались как были — их читает 404.

### Геометрия (Figma `751:13876`, фрейм 1440)

| Параметр | 1440 / 1920 | 840 | 392 |
|---|---|---|---|
| контент сверху | 140 | 128 | 112 |
| контент снизу | 64 | 64 | 48 |
| колонка | 900 | 776 | 360 |
| поля | 32 | 32 | 16 |
| H1 | 52/64 | 44/52 | 24/32 |
| абзац | 18/28 | 18/28 | 16/26 |
| H2 | 24/36 | 24/36 | 22/32 |
| H3 | 20/28 | 20/28 | 18/26 |

Колонку задаёт `body.page-template-page-privacy .container.small-container`
с `max-width: 964px`: 900 макета плюс поля 32 с двух сторон.

Макетов Full HD, Tablet и Mobile нет: выше 1440 колонка те же 900,
ниже — вертикаль и типографика ужаты по логике темы.

### Вертикальные зазоры контента

Собираются схлопыванием соседних `margin`, а не обёртками:

| Переход | Значение | Чем задано |
|---|---|---|
| раздел → раздел | 32 | `h2 { margin-top: 32px }` |
| H2 → текст | 28 | `h2 { margin-bottom: 28px }` |
| текст → H3 | 28 | `h3 { margin-top: 28px }` |
| H3 → текст | 16 | `h3 { margin-bottom: 16px }` |
| абзац → абзац | 20 | `p { margin-bottom: 20px }` |
| текст → таблица | 32 | `.wp-block-table { margin: 32px 0 }` |

### Таблицы

Блок `PAGE` раскладывает `figure.wp-block-table` флексом; в светлой версии
раскладка табличная — `border-spacing: 8px` вместо `gap`, пропорция 1:2
процентами при `table-layout: fixed` (DECISIONS.md, Р-124).

Ниже 576 — `table-layout: auto`, поля ячеек 10/12, снимается
`word-break: break-word` ядра WordPress. У таблиц с неразрывным URL
в ячейке остаётся прокрутка внутри `.wp-block-table`; страница не едет.

### Чего в контенте пока нет

`ol`, `h4`, `hr`, `blockquote`, `th` оформлены на запас — в текущих трёх
страницах встречаются только `p`, `h2`, `h3`, `ul`, `li`, `strong`, `a`
и таблицы. Правила стоят, чтобы редактор мог добавить такой блок
в админке и не получить неоформленный вывод.


---

## CSS по файлам (Р-149 / Р-150, 2026-10-21)

Стили разнесены из `css/styles.css` по файлам; подключает `inc/css-registry.php` (порядок строк = порядок подключения, все файлы грузятся на всех страницах). Колонка «Шаблоны» — где корневой класс стоит в `class=` (поиск по шаблонам; `header.php`/`footer.php` общие). Новый блок: partial + `css/blocks/<имя>.css` + строка в реестре (см. `docs/FRONTEND.md` §2).

| № | Запись реестра | Файл | Корневые классы | Шаблоны |
|---:|---|---|---|---|
| 1 | `base` | `css/base.css` | токены `--nv-*`, reset, `.container`, `.section*`, `.btn*`, `.kyc-*` (примитивы), `@font-face`, body-правила страниц | все |
| 2 | `layout/header` | `css/layout/header.css` | `.mega`, `.header`, `.header-language` | `header.php` |
| 3 | `blocks/hero` | `css/blocks/hero.css` | `.hero`, `.btn-hero`, `.btn` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 4 | `blocks/page-nav` | `css/blocks/page-nav.css` | `.page-nav` | `page-solutions.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 5 | `blocks/about` | `css/blocks/about.css` | `.about`, `.maskot-animation` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 6 | `blocks/results` | `css/blocks/results.css` | `.results` | `main-page.php` |
| 7 | `blocks/video-intro` | `css/blocks/video-intro.css` | `.video-intro` | `main-page.php`, `main-page-video-autoplay.php` |
| 8 | `blocks/solutions` | `css/blocks/solutions.css` | `.solutions`, `.btn` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 9 | `blocks/products` | `css/blocks/products.css` | `.products`, `.home` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 10 | `blocks/how` | `css/blocks/how.css` | `.how` | `main-page.php` |
| 11 | `blocks/advantages` | `css/blocks/advantages.css` | `.advantages`, `.advantage` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 12 | `blocks/clients` | `css/blocks/clients.css` | `.clients`, `.company` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 13 | `blocks/testimonials` | `css/blocks/testimonials.css` | `.testimonials` | `index.php`, `page-solutions.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 14 | `blocks/cases` | `css/blocks/cases.css` | `.cases`, `.btn` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 15 | `blocks/pricing` | `css/blocks/pricing.css` | `.pricing` | `main-page.php` |
| 16 | `blocks/doc` | `css/blocks/doc.css` | `.doc`, `.btn` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 17 | `blocks/news` | `css/blocks/news.css` | `.news` | `index.php`, `main-page-video-autoplay.php`, `template-parts/news-section.php`, `template-parts/news-card.php` |
| 18 | `blocks/offer-card` | `css/blocks/offer-card.css` | `.promo` | `index.php`, `main-page.php`, `main-page-video-autoplay.php` |
| 19 | `layout/forms` | `css/layout/forms.css` | `.phone-field`, `.input-form-block`, `.ui-check` | `functions.php`, `index.php`, `main-page-video-autoplay.php`, `footer.php`, `single.php` … |
| 20 | `blocks/contacts` | `css/blocks/contacts.css` | `.contacts`, `.post`, `.modal` | `index.php`, `main-page.php`, `main-page-video-autoplay.php`, `footer.php`, `single.php` … |
| 21 | `layout/cta-band` | `css/layout/cta-band.css` | `.teaser` | `index.php`, `main-page-video-autoplay.php`, `footer.php`, `template-parts/teaser.php` |
| 22 | `layout/footer` | `css/layout/footer.css` | `.footer` | `footer.php`, `template-parts/footer-home.php` |
| 23 | `layout/cookie` | `css/layout/cookie.css` | `.cookie`, `.cookie-banner` | `footer.php` |
| 24 | `layout/modals` | `css/layout/modals.css` | `.modal`, `.review`, `.post` | `footer.php` |
| 25 | `blocks/benefits` | `css/blocks/benefits.css` | `.benefits`, `.section` | `page-solutions.php` |
| 26 | `blocks/solutions-why` | `css/blocks/solutions-why.css` | `.solutions-why` | `page-solutions.php`, `page-document-verification.php`, `page-kyc.php` |
| 27 | `blocks/features` | `css/blocks/features.css` | `.features` | в `class=` шаблонов не найден |
| 28 | `blocks/solutions-products` | `css/blocks/solutions-products.css` | `.solutions-products` | `page-face-verification.php`, `page-liveness.php`, `page-solutions.php`, `page-document-verification.php`, `page-kyc.php` … |
| 29 | `blocks/flow` | `css/blocks/flow.css` | `.flow` | в `class=` шаблонов не найден |
| 30 | `blocks/industries-slider` | `css/blocks/industries-slider.css` | `.nvslider`, `.industries` | `page-solutions.php` |
| 31 | `blocks/integration` | `css/blocks/integration.css` | `.integration` | `template-parts/integration-section.php` |
| 32 | `blocks/solutions-security` | `css/blocks/solutions-security.css` | `.solutions-security` | `page-solutions.php` |
| 33 | `blocks/security` | `css/blocks/security.css` | `.security` | в `class=` шаблонов не найден |
| 34 | `blocks/faq` | `css/blocks/faq.css` | `.faq` | `main-page.php`, `template-parts/faq-section.php`, `blocks/faq/faq.php` |
| 35 | `blocks/cta` | `css/blocks/cta.css` | `.cta` | в `class=` шаблонов не найден |
| 36 | `blocks/main-hero` | `css/blocks/main-hero.css` | `.main` | `page-face-verification.php`, `page-price-matrix.php`, `page-liveness.php`, `page-solutions.php`, `page-identity-verification.php` … |
| 37 | `blocks/kyc-certs` | `css/blocks/kyc-certs.css` | — (пуст, перенесено в `blocks/idv-certs`) | — |
| 38 | `blocks/kyc-risk` | `css/blocks/kyc-risk.css` | `.kyc-risk` | `template-parts/kyc-risk-section.php` (`page-kyc.php`, `page-liveness.php`) |
| 39 | `blocks/kyc-compliance` | `css/blocks/kyc-compliance.css` | `.kyc-compliance`, `.kyc-marker` | `template-parts/kyc-compliance-section.php` (`page-kyc.php`, `page-aml.php`, `page-kyb.php`) |
| 40 | `blocks/kyc-sea` | `css/blocks/kyc-sea.css` | `.kyc-sea` | `template-parts/kyc-sea-section.php` (6 страниц) |
| 41 | `blocks/kyc-onboarding` | `css/blocks/kyc-onboarding.css` | `.kyc-onboarding`, `.kyc-flags` | `page-kyc.php` |
| 42 | `blocks/kyc-pricing` | `css/blocks/kyc-pricing.css` | `.kyc-pricing` | `page-face-verification.php`, `page-liveness.php`, `page-document-verification.php`, `page-aml.php`, `page-kyb.php` … |
| 43 | `blocks/kyc-about` | `css/blocks/kyc-about.css` | `.kyc-about`, `.idv-about`, `.kyc-tag` | `template-parts/kyc-about-section.php` |
| 44 | `blocks/idv-certs` | `css/blocks/idv-certs.css` | `.idv-certs` | `template-parts/certs-section.php` (7 страниц) |
| 45 | `blocks/idv-checks` | `css/blocks/idv-checks.css` | `.idv-checks` | `template-parts/idv-checks-section.php` (6 страниц) |
| 46 | `blocks/idv-coverage` | `css/blocks/idv-coverage.css` | `.idv-coverage` | `page-identity-verification.php` |
| 47 | `blocks/idv-accuracy` | `css/blocks/idv-accuracy.css` | `.idv-accuracy` | `page-identity-verification.php` |
| 48 | `blocks/idv-benefits` | `css/blocks/idv-benefits.css` | `.idv-benefits` | `template-parts/idv-benefits-section.php` (`page-identity-verification.php`, `page-aml.php`, `page-face-verification.php`) |
| 49 | `blocks/idv-security` | `css/blocks/idv-security.css` | `.idv-security` | `template-parts/idv-security-section.php` (6 страниц) |
| 50 | `pages/404` | `css/pages/404.css` | `.section-404`, `.page-404`, `.page-id-582` | `404.php` |
| 51 | `layout/light-content` | `css/layout/light-content.css` | `.page`, `.content-page`, `.section` | `page-privacy.php` |
| 52 | `pages/price-matrix` | `css/pages/price-matrix.css` | `.calculator`, `.packages`, `.overview` | `page-price-matrix.php` |
| 53 | `layout/chat-widget` | `css/layout/chat-widget.css` | `.wp-singular` | в `class=` шаблонов не найден |
| 54 | `blocks/steps` | `css/blocks/steps.css` | `.kyc-steps` | `template-parts/kyc-steps-section.php` |
| 55 | `blocks/platform` | `css/blocks/platform.css` | `.kyc-platform` | `template-parts/kyc-platform-section.php` |
| 56 | `blocks/industries` | `css/blocks/industries.css` | `.kyc-industries` | `template-parts/kyc-industries-section.php` |
| 57 | `blocks/video` | `css/blocks/video.css` | `.video-embed` | `template-parts/video-section.php` (главная; блок универсальный) |

`css/styles.css` — заглушка (не подключается). Не относятся к реестру: `css/post.css`, `css/blog.css`, `css/document-toc.css`, `css/bloki.css`, `css/editor-blocks.css`.
