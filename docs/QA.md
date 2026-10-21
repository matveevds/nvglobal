# QA — проверки перед сдачей

Сайт локально доступен **только по HTTPS**, сертификат самоподписанный:
`curl -k`, в Playwright `ignoreHTTPSErrors: true`. `http://nvglobal.local/` не отвечает.

## Identity Verification — follow-up-5, проверка 1.1.45 (2026-10-18, C5-01…C5-04)

Независимая проверка (`review-finish-5`) нашла 4 остатка в разделах, которые предыдущий отчёт
(1.1.45) закрыл неверно — не новый scope, те же L-01/02/04/05.

- **C5-01 Coverage** (High): z-index панели/visual были перепутаны (`elementsFromPoint()`
  координатора подтвердил документы НАД текстом вместо текста НАД документами) — исправлено.
  Корневая причина y64 вместо target y144 — badge был внутри `.idv-coverage__head` (внутри row с
  `align-items:flex-start`), из-за чего visual стартовал вровень с badge вместо H2; вынесен
  отдельным sibling перед row, FHD-грид получил explicit `grid-template-rows`+`grid-row` на
  badge. Измерено после фикса: **visualYRelSection=146 (target144), badgeYRelSection=64 (точно),
  overlap=200 (точно) на 1920 и 1440**, panel сверху в `elementsFromPoint()`-стеке. Panel
  min-height:180px — все 3 состояния (Documents/Regions/SEA) теперь одной высоты (SEA и так была
  180h из-за длинного текста, остальные были154h).
- **C5-02 About** (Medium): 1920 cert-row192h→**168h точно** (certs-links flex-direction:row).
  840 cert-row216h→**202h** (target200, ±2), padding16 (было23). 392 padding-top32 (было1 —
  ошибочное наследование из прошлого раунда). Divider высота2px (видимость). 1920 topcards
  y141→**157 точно** (margin-bottom:16 на head).
- **C5-03 Benefits** (Medium): маскот переведён с `position:static` на overlay-crop на
  FHD/Tablet/Mobile (был только на 1440). FHD-колонки 3×412+572 (было4×452 поровну — promo была
  уже на120px, чем нужно). Mobile text align вернули на left (была явная ошибка center).
  «Compliance without manual work» теперь **1 строка** на Mobile (font-size18px, scoped с
  достаточной специфичностью, т.к. предыдущая попытка перебивалась общим правилом той же
  специфичности, но позже в каскаде).
- **C5-04 Platform** (Medium): Mobile audit-image переведён с `position:static` (блок ПОД
  текстом) на overlay-crop (как на Desktop/FHD) с `min-height:320px` на карточке (без него
  картинка перекрывала заголовок). `padding-top:1px` у `.idv-platform` (было 64, тот же паттерн,
  что About).

Проверено: PHP lint чисто, CSS-скобки 4278/4278. `/kyc/` About/Platform (свои FHD-сетка/
padding-top64) — не затронуты, измерено отдельно. Coverage keyboard (ArrowRight/Home/End) и
no-JS (3 панели readable:true, tabs display:none, badge присутствует) — не регрессировали.
Targeted sweep 8 ширин × 2 страницы — 0 overflow/console errors. `THEME_ASSETS_VER` → `1.1.46`.

## Identity Verification — follow-up-5, продолжение (2026-10-18, About + Coverage overlap)

Координатор вернул отчёт `1.1.44` в работу: L-05 About и Coverage text-panel/visual overlap
200px были ошибочно закрыты как «вне scope сессии» / «технически невозможно без абсолютного
позиционирования целой секции». Оба опровергнуты и доведены в этом раунде.

- **H2 4 строки**: "Territories"→"territories" (регистр из исходника) — 156h (3 строки) вместо
  обрезанных 4, измерено `getBoundingClientRect()`.
- **Coverage overlap**: `main` = left(680px fixed) + visual(auto), gap:0 (680+740=1420 на FHD,
  680+696=1376 на 1440, без зазора) — НЕ единая grid-колонка. tabs/text-панель 816px с
  margin-left:64px внутри 680px left (64+816=880, перекрывает visual на 200px). Component-scoped
  `position:relative`+`z-index` (панель z-index:1, visual z-index:2), без абсолютного
  позиционирования секции. Измеренный overlap: **ровно 200px на 1920 и 1440** (panel.x+panel.width
  − visual.x). Side-колонка FHD (388px) и visual (740px) не регрессировали.
- **About**: карточки `.kyc-about__accuracy`/`.kyc-about__documents` — `flex:0 0 680px` вместо
  `flex:1 1 0` (на 1440 совпадение ширины контейнера маскировало баг, на 1920 растягивало до
  920px). Измерено после фикса: **680w/680w на обеих широких ширинах, впритык (gap16), без
  разрыва**. Марки: 120h на FHD (было 72, KYC-шное FHD-правило), 72h на Mobile (было 88,
  KYC-дефолт), 72h на 840 — не трогалось, уже было верно. 840 cert-title: max-width:681px (точно
  по JSON). Section height 1920=593/1440=597 (target591, Δ2-6px, в пределах погрешности).

Проверено: PHP lint чисто (page-identity-verification.php, kyc-about-section.php), CSS-скобки
4265/4265. `/kyc/` About (3-колоночная FHD-сетка собственная) — не затронут, измерено отдельно
(521w/782w карточки, 72h марки, height:220 — все KYC-значения сохранены). Coverage 3 вкладки
(Documents/Regions/SEA) — ненулевой canvas на 1440/1920 после рестрактура (16/13/16 изображений).
Targeted sweep 8 ширин × 2 страницы (identity-verification+kyc) — 0 overflow/console errors.
`THEME_ASSETS_VER` → `1.1.45`.

## Identity Verification — follow-up-5 (2026-10-17, точные координаты layout-contracts)

Источник целей — `layout-contracts/{component}-{width}.json` (точные frame-rects из сохранённого
Figma XML по каждой секции/ширине), не собственная CSS и не прошлый самоотчёт.

- **Integration**: FHD slider переведён с вертикального стека на горизонтальный Grid (264px
  title+controls слева / 476px REST-pane справа, gap32) — измерено `getBoundingClientRect()`,
  x/width точно совпадают с `integration-1920.json` (title x56 w264, REST-pane x352 w476). 1440
  slider 600px (было 400 — ~1/3 ширины, визуально «ужат»). 840/1440 folder-картинка 280×195 (было
  160×112 без JSON-источника), 392 — 182×127. Mobile actions — по содержимому, не на всю ширину.
- **Coverage — корневая причина найдена и исправлена**: `.idv-coverage__row{align-items:
  flex-start}` рассчитан на row-направление (≥1200px, влияет на вертикаль), но та же команда
  наследуется и в column-направлении (≤1199.98px для всей Tablet/Mobile раскладки), где становится
  КРОСС-осью (шириной) — `.idv-coverage__visual` терял `align-items:stretch` и схлопывался до
  max-content некопируемого ряда документов (662px вместо 360px секции на 392, 930px вместо 776px
  на 840). Это и была причина «сдвинутого вправо» ряда (Morocco вместо центральных Armenia/
  Andorra/Italy) — весь visual-блок был шире вьюпорта и обрезался контейнером страницы, а не
  центрировался собственным overflow:hidden. Один `align-items:stretch` в этом media query чинит
  оба симптома разом. После фикса: 392 visual 360×460 (точно), документы x-координаты совпадают
  с `coverage-392.json` **пиксель-в-пиксель** (doc1 x=-65, doc6 x=-118 и т.д. — не округление, а
  прямое совпадение); 840 visual 776×680 (точно), документы также совпадают 1:1 с
  `coverage-840.json`; 1920 visual 740×680 (точно, grid-ratio пересчитан под реальный target
  696:740), боковая колонка 388px (было 280 без источника). Все 3 вкладки (Documents/Regions/SEA)
  дают ненулевой canvas на 1440/1920 (16/16, 13/13, 16/16 изображений, 0 с `naturalWidth:0` или
  несчитанных), Belarus-флаг (композит 6 SVG, followup-5 L-03) корректен и в контексте страницы.
  Keyboard (ArrowRight/Home/End по табам) — без регрессии.
  **Не закрыто**: точное наложение text-panel на visual на 200px (1440, Figma-слой через
  абсолютное позиционирование) — не воспроизведено; потребовало бы абсолютного позиционирования
  всей секции, от чего тикет explicitly предостерегает.
- **Certs 392**: inner 360×216 (target214, ±2px), секция 392×248 (target246, ±2px) — padding12/16,
  раздельный gap8 (title↔tokens) + margin-top30 (↔badges) вместо единого uniform gap16/24.
- **Benefits**: иконка перенесена внутрь `<h3>` и переключена на `float:right` (из
  `position:absolute`+`padding-right:44px` на весь заголовок) — «Higher onboarding conversion» и
  «Compliance without manual work» укладываются в 1 строку на Mobile/840, 2-я строка (где есть)
  больше не теряет 44px без нужды.

Проверено: PHP lint 3 изменённых файла, CSS-скобки 4252/4252, targeted sweep 8 ширин × 2 страницы
(identity-verification + kyc) — 0 overflow/console errors. `THEME_ASSETS_VER` → `1.1.44`.

## Identity Verification — follow-up-4 (2026-10-17, доказанные причины CSS-регрессий)

4 группы с runtime-доказательствами (DOM-фикстуры координатора + QA-диагностика 3 точечных
причин Platform/Certs/Integration) исправлены по target/measured, не по догадке:

- Hero: Mobile facts 148→112px (унаследованный от Tablet height, не контентное решение —
  уточнение неверного утверждения из follow-up-3), FHD facts 24/36→18/24 (обрезка текста
  факт 1/3), Mobile-кроп — точный source `identity-hero-mobile.webp` + точные inset-проценты
  вместо догадочного `scale(1.35)`.
- Security: индивидуальные SVG не несли общий canvas — подключены точные per-layer inset-
  проценты всех 16 слоёв (coordinates.json), карта больше не слипается в углу.
- Coverage: документы переведены с пропорционального `flex:1`/`height:100%` (широкие полосы)
  на фиксированные 140×200/98×140 с центрированием и обрезкой по краям — как в реальном source.
- Layout: Platform 840 (`flex-direction:row` явно, pair/screen `calc(50% - 12px)`), Certs 840
  (CSS Grid areas вместо nowrap-row, 3-я марка больше не обрезана), Integration Mobile
  (явный сброс columns+grid-column/row, 2-колоночное Desktop-правило больше не течёт на 392),
  Benefits 840 (истинные 50/50 через calc, не flex:1), icon upper-right без лишней строки,
  About FHD height (auto вместо KYC-шных 220px/карточку), badge→H2 gaps (48px на Benefits/
  Checks/Security, были 0).

Проверено: PHP lint 14 файлов, `node --check`, CSS 4217/4217, targeted sweep 8 ширин × 2
страницы — 0 overflow/errors. Coverage keyboard+no-JS, 4 Steps states — не регрессировали.
KYC About-badges (120px), Integration deploy-карточка — не затронуты.

## Identity Verification — follow-up-3 (2026-10-17, точные ассеты + остатки V2)

Независимая сверка 32 пар (8 секций × 4 ширины) против состояния follow-up-2 (1.1.20) нашла
незакрытые остатки на всех 4 ширинах. Ассет-блокер (иконки/decision/Macbook/Security) снят —
точные файлы перенесены в тему (`img/identity-*`, `inc/kyc-icons.php`).

**Найден и исправлен критичный layout-баг по ходу работы**: после перевода Coverage на CSS Grid
для 3-колоночной FHD-раскладки (follow-up-2) `.idv-coverage__visual` стал grid-, а не
flex-элементом — percentage-height цепочка `panel→grid→row→doc` переставала резолвиться,
документы схлопывались до 0px высоты на FHD. Исправлено `display:flex` + `flex:1` на активной
панели (резолвит высоту независимо от grid/flex контекста снаружи).

Доведено до факта, не до «мы меняли код»: Platform (реальная геометрия нового 2011×1183
ноутбука, 840-композиция risk+case-слева/laptop-справа), Coverage documents (3 плотных ряда на
ВСЕХ 4 ширинах, не только 1440), Industries (4 точные иконки), Certs (1440 2-строчный заголовок,
840 реальная target-композиция), Benefits (840 2-колоночная раскладка, icon upper-right, Mobile
маскот), About (FHD метрики рядом), Integration (list+backoffice делят 2 колонки без deploy-
карточки на 1440 И 840), Hero Mobile (compact CTA), Security (точный 16-слойный наб369×360,
map справа на 1440/840). F2-01 (QA-находка) — Coverage tablist скрыт без JS тем же enhancement-
гейтом, что панели.

Проверено: PHP lint 14 файлов, `node --check`, CSS 4206/4206, targeted sweep 8 ширин × 2
страницы — 0 overflow/errors, Coverage keyboard+no-JS (tabs скрыты, 3 панели читаемы) и 4 Steps
states — не регрессировали, KYC Platform/Integration/About laptop/grid/layout не затронуты
(все фиксы scoped через `body.page-template-page-identity-verification` или зависят от
отсутствующей у KYC карточки deploy).

**Не закрыто явно**: Mobile hero фото-кроп не сверен попиксельно (скорректирован визуально);
высота фактов 1/3 без mobile_text (контентное решение, не CSS). Полный `followup-3/report/
index.md` — таблица по всем 13 пунктам с remaining.

## Identity Verification — follow-up-2 (2026-10-17, независимый visual review)

После side-by-side сверки 15 секций × 4 ширины с Figma exports найдены и исправлены: Hero
(FHD/Tablet facts geometry + Mobile CTA-оверлей на фото через CSS Grid), Certs (FHD 3-строчный
заголовок, Mobile порядок), Checks (нерабочее центрирование бейджа, Mobile типографика), Steps
(2 из 4 иллюстраций, FHD-чип, Mobile размер), **Platform (критичный баг — чёрный экран ноутбука
вместо интерфейса, z-index+геометрия)**, Coverage (stats на Mobile), **Coverage no-JS (критичный
accessibility-баг — 2 из 3 состояний были полностью недоступны без JavaScript, `display:none`
не зависел от `hidden`/JS)**, Accuracy (порядок NIST-карточки), Industries (сетка FHD, 1 точная
иконка), Benefits (4-колоночный ряд на FHD, растянутый icon-box), Integration (вес шрифта),
Security (**карта была горизонтальной полосой вместо компактной композиции** — переведена на
технику Coverage SEA, порядок на Mobile).

Проверено: `php -l` 14 файлов, `node --check js/main.js`, баланс CSS 4141/4141, полный sweep
15 ширин × 2 страницы (0 overflow/errors), Coverage no-JS (`javaScriptEnabled:false` — весь текст
3 состояний читается) и с JS (клик/клавиатура не изменились), regression KYC/Identity после всех
правок (тексты/кнопки/steps/pricing/about идентичны прежним).

**Продолжение (V2-05/06/11/12 доведены до конца, не остановлено на typography-фиксах)**:
Platform Mobile audit/pair collapse-баг (flex:1 1 0 в row≠column) найден и исправлен; Coverage
FHD переведён на CSS Grid (head|visual|promo+stats тремя колонками), 840/392 порядок унифицирован
(badge→visual→tabs→panel); Pricing-840 pilot/enterprise в ряд; About-FHD 2-рядная композиция
(была ошибочно унаследована KYC-шная 3-колоночная FHD-сетка), About-840/392 правки; Integration
стрелки под заголовком на Tablet/Mobile (новая Identity-scoped grid-раскладка), deploy-карточка
скрыта новым опциональным `show_deploy_card` арг (KYC/Solutions не затронуты). FAQ пересверен —
first/second item уже точно по таргету (360×249/360×80), общая высота 97% от цели.

Проверено после: PHP lint 14 файлов, `node --check`, CSS 4164/4164, targeted sweep 8 ширин ×
2 страницы — 0 overflow/errors, Coverage keyboard+no-JS и 4 Steps states не регрессировали.

**Не закрыто явно** (см. `followup-2/report/index.md` и CHANGELOG): точные иконки Steps-decision
и Industries (4 из 6) — ближайшие существующие ассеты, не точные Figma-экспорты (Figma MCP
недоступен без повторной авторизации); Coverage 1440 docs тремя крупными обрезанными рядами
с overlap text panel. Ничего из этого не объявляется пройденным.

## Identity Verification (`/identity-verification/`, 2026-10-17)

WP page ID 1213, publish, реальный URL (не за редиректом). Проверено: `php -l` всех изменённых
PHP, баланс CSS 4067/4067, `node --check js/main.js`, 200/без console errors/без горизонтального
переполнения на 1920/1440/840/392, 1 `h1`, количество карточек/вкладок/FAQ-пунктов по ожидаемому
числу. Функционально: Coverage (3 вкладки, `aria-selected`, смена текста и визуала), Steps
(кнопки 1–4), FAQ-аккордеон (открытие/закрытие). Регрессия на живых `/kyc/`, `/solutions/`, `/`:
200, Integration heading/badge и FAQ heading/count не изменились (прежние значения по умолчанию),
News на главной — 2 реальных поста, как было.

**Критичный фикс этого раунда**: страница не входила в списки селекторов, объявляющие токены
`--nv-*` (HOME THEME) и включающие светлую тему для `.contacts`/`.faq`/`.teaser`/`.footer`/
`.section` — без этого вся страница и переиспользованные блоки рендерились тёмными с нечитаемым
текстом (см. docs/CHANGELOG.md). Исправлено расширением существующих списков селекторов
(`body.page-template-page-kyc` → добавлен `body.page-template-page-identity-verification` же).

**Не проверено / упрощено** (кандидаты на follow-up координатора):
- ~~Responsive sweep — только 4 базовых вьюпорта~~ закрыто в follow-up-1 (см. ниже).
- Hero-фото — один `object-fit:cover` <img>, не 4 раздельных кропа по брейкпоинтам как у `kyc-hero-*`.
- Side-by-side/overlay сверка с Figma по каждой секции не делалась (сравнение по скриншотам секций
  и структуре, не пиксель-в-пиксель).
- ~~Клавиатурная навигация Coverage~~ закрыто в follow-up-1 (реально нажато, см. ниже).
- Security/Accuracy — новые заголовки дословно из Figma, включая видимое несоответствие смыслу
  секции (см. CHANGELOG), не проверялись на предмет опечаток в остальном тексте построчно.
- Mobile hero: кнопки больше не наезжают на фото оверлеем, как в Figma (попытка через
  отрицательный margin не сработала технически — `.main__actions` не потомок `.main__media`
  после `display:contents`), описание сдвинуто вниз на высоту кнопок (y600 вместо y460 из Figma).
  Раскрыто и принято как упрощение, не скрыто.

### Follow-up-1 (2026-10-17) — F-01…F-07

- **Полный sweep 15 ширин** (1920…320) на `/kyc/` и `/identity-verification/`: 0 overflow,
  0 console/page errors на каждой из 30 комбинаций.
- **Regression KYC/Identity после 6 partial-extractions**: H1, тексты кнопок/фактов/степов/
  pricing/about, число industries-карточек — идентичны прежним значениям на обеих страницах,
  0 errors.
- **Coverage — клавиатура нажата по-настоящему** на новой 3-panel структуре: click, ArrowRight,
  End, Home — фокус и `aria-selected` переключаются корректно; текст всех 3 состояний
  подтверждён присутствующим в DOM (`textLen` > 0 для скрытых панелей — не только в JSON).
  Documents — 16 фото, Regions — 4 кластера маркеров × 3 флага = 12 `.idv-coverage__region-flag`.
- **Hero-геометрия перемерена** на 1920/1440/840/392 (`getBoundingClientRect()`): card y96,
  title/description x/y/w/h совпадают с таргетом review в пределах 1px на 1920/1440/840.
  Mobile — H1 вне карточки, фото 360×240, факты: 2-й/4-й — короткие mobile-варианты.
- **Найден и исправлен QA-регресс**: на Mobile факты без `mobile_text` (1-й «99.74%…», 3-й
  «195+ countries…») рендерились пустыми строками — `.main__fact-title--wide` была безусловно
  `display:none` в Mobile-медиа без mobile-замены. Исправлено `:has()`-селектором
  (приём уже используется в проекте), перепроверено — все 4 факта видны на 392px.
- **Certs/Checks/Security на 1440/840/392**: бейджи 80×80/63×80/80×80 (1440/840), 48×48/38×48
  (392) — нативные пропорции, не 64×64; `.idv-certs__left` — `row` на Desktop, `column-reverse`
  на Tablet/Mobile; Checks — `display:flex`, карточки 2 в ряд на 840 (355px), 1 в ряд на 392
  (334px); Security — 9 слоёв карты отрисованы на всех 3 проверенных ширинах.
- **4 состояния Steps нажаты вручную** на обеих страницах (1440): все 4 кнопки переключают
  активное состояние, 0 errors.
- **FAQ/Integration после escaping-фикса (F-06)**: аккордеон открывается/закрывается кликом,
  `wp_kses_post()` не даёт двойного экранирования (нет видимого `&amp;`/`&nbsp;`) в выводе.
- **Смоук** Home/`/solutions/`/`/pricing-matrix/`: 200, без errors, заголовки страниц как были.
- PHP lint 13 файлов — чисто; `node --check` — чисто; CSS-скобки 4103/4103.

## Автор (`/author/<slug>/`, 2026-10-17)

**Yoast SEO `disable-author=true` редиректит реальный URL на главную** (pre-existing настройка,
не менялась) — открывать шаблон для QA только через прямой PHP-рендер (минуя `template_redirect`)
или временно через `page.route()` в Playwright, не через настоящий HTTP-переход.
Реальные проверочные авторы: `neurovision` (id1, corporate — N-mark вместо аватара, LinkedIn+
website, 2 поста) и `kochetkov` (id2, обычный — реальный job/bio/аплоаднутый avatar, без соцсетей).
Эталоны: 1920↔`2570:33393`, 1440↔`2570:31497`, 840↔`1381:25698`, 392↔`1381:26059`. Hero скрыт
только на Mobile (его нет в этом макете). FHD — topics СПРАВА от сетки (`grid-template-areas:
"main cats"`), у остальных ширин — как у category (слева/сверху). Card-геометрия — свои mode-
значения (442×296/333.33×176/364×184/344×224), не category. `article-card.php` этим шаблоном
больше не используется (решение задачи), но файл не удалён — нужен `nv_blog_search` на `/blog/`.

---

## KYC — `/kyc/` (2026-10-15)

Playwright: `scrollWidth == clientWidth` на 1920 / 1600 / 1440 / 1200 / 1024 / 992 / 840 / 768 / 576 / 478 / 420 / 392 / 375;
высоты секций на 1920 и 1440 сверены с Figma; состояния: Process 1–5, Steps 1–4, Risk 1–3, Compliance (клик / hover / focus),
SEA 6 стран, FAQ 11; клавиатура — стрелки у Risk и SEA; регрессия: `/`, `/solutions/` (HTML до и после выноса partials
совпадает с точностью до пробелов), `/pricing-matrix/`, юридические страницы, `/docs/`, 404. Ошибки `hcaptcha.com/logo.png` — внешние.

## Архив блога (2026-10-15)

- `/blog/` (страница #570 — черновик: открывать залогиненным или после публикации), `/?s=слово`, `/?s=несуществующее` (пустое состояние), `/category/<slug>/`.
- Один `h1`; нет вложенных `<a>`; пагинация — реальные `/page/N/` (при поиске `/page/N/?s=`), `aria-current="page"`; `/blog/page/N/` за пределами → 404.
- Нет горизонтальной прокрутки 1920…320; hover карточки гасит соседние только при `(hover: hover)`.
- Эталоны: 1920 ↔ `2570:33169`, 1440 ↔ `1378:20322`, 840 ↔ `2569:29963`; Mobile — выведен, макета нет.
- Для проверки сетки без записей в БД клонировать карточки в DOM (записи в БД не создавать, Р-24).

## Category-only вариант архива (`/category/<slug>/`, 2026-10-16)

- Реальные term'ы на момент проверки: `anti-fraud-liveness-detection` (1 запись), `kyc-aml-and-digital-identification`
  (1 запись), пустая `pending-verification` (0, honest empty state, не 404). Несуществующая рубрика и
  `/category/<slug>/page/N/` за пределами пагинации — настоящий 404 (без доп. кода, стандартное поведение `WP_Query`).
- Сетка — 4/3/2/1 колонка (не 2/3 общего архива); проверять именно на `/category/`, не на `/blog/` или `/?s=`.
- Активная рубрика: на Desktop/Full HD — отдельной строкой над «All topic» (два разделителя), на
  Tablet/Mobile (`≤1199.98px`) — первой в общем списке (`order:-1`, один разделитель под «All topic»),
  отдельная строка скрыта. Технически присутствует в DOM дважды (`display:none` у неактивного варианта) —
  принятое решение (follow-up 1, R-16), не настоящий reorder. **Пустая/исключённая `hide_empty` рубрика**
  (напр. `pending-verification`) с follow-up 2 (R2-05) добавляется в `$categories` в PHP и рендерится
  **обычным пунктом списка** — отдельного `--empty-active` состояния больше нет, один разделитель и
  обычная типографика на всех ширинах, как у непустых терминов. Count текущей рубрики (H1, пилюля, её
  строка в списке) — единый `$grid->found_posts` (R2-12); остальные термины в сайдбаре — `term->count`.
  `grid-template-areas` на `≤1199.98px` — `"cats" "main"` у category, без зарезервированной пустой
  строки `news` (которая осталась бы у page/search).
- `.blog-news` на category не запрашивается и не рендерится ни при каких данных.
- Hero Mobile — 548px, заголовок Martel Bold (локальный шрифт, `fonts/Martel/`) 52px/92px, подзаголовок
  **20px/32px** (3 строки, y276/h96). H1 на Mobile — **32px/44px**. Маскот виден и центрирован (216×135,
  `object-fit:cover`), текстура кроплена по Figma `imageTransform` — на `/blog/`/`/?s=` маскот на
  `≤575.98px` по-прежнему скрыт и текстура/шрифт не менялись, это ожидаемо. Desktop/FHD маскот
  **287×179** фиксированными сторонами + `cover` (не `height:auto`, follow-up 2 R2-06). Tablet hero
  title y86/subtitle y186 (x186, w468, h108, 3 строки); **Desktop/FHD title y104/subtitle y204, голова
  секции 152px, сетка начинается на y=612** (H1-зона `min-height:104` с выравниванием по низу, follow-up 2
  R2-09) — Tablet/Mobile остаются autoheight.
- Табы Blog/News/Video на category — с иконками (`document`/`network`/`play` в `nv_blog_icon()`,
  `currentColor`), Mobile — три равные колонки h36 с иконками `20×20` (document) / `24×20` (network/play),
  Desktop/Tablet — natural width по контенту, слот иконки **24×24 для всех трёх** (`preserveAspectRatio`
  вписывает native 24×20 без искажения, follow-up 2 R2-07). На `/blog/`/`/?s=` табы без иконок — scope
  ограничен category.
- Карточка на category Mobile — компактный вариант (gap12, padding 8/8/12, media 344/284, title/excerpt
  14/20, stats/date 12/16, avatar40, **radius12** — follow-up 2 R2-08, было 24) — `.blog-card` остаётся
  общим для `/blog/`/`/?s=`, которые Mobile-макета не имеют вовсе. На Desktop/FHD/Tablet — заголовок до
  3 строк (`-webkit-line-clamp:3`), Mobile — 2 строки. Media-лесенка (follow-up 2 R2-02, точные значения
  по всем четырём ширинам): **FHD 324/260, Desktop 329.333/260, Tablet 364/292 (+padding-bottom:16 у
  карточки), Mobile 344/284.**
- **Обводка карточки/author/stat/time/tab/search — `box-shadow: inset` вместо `border`** (follow-up 2
  R2-01): Figma-стиль INSIDE не занимает layout, а CSS `border` при auto-размере отъедал 2px у
  внутренней ширины/высоты каждого такого блока. Проверять через `getComputedStyle(...).boxShadow`,
  не только `border`; `:focus-visible` (`outline`) не задет, независимое свойство. На `/blog/`/`/?s=`
  границы остаются настоящим `border` — не трогались.
- Эталоны: 1920 ↔ `2570:33257`, 1440 ↔ `2570:31820`, 840 ↔ `2570:32299`, 392 ↔ `2570:32881`.
- Follow-up 1 и 2 (2026-10-17) сняты реальным Chromium headless Playwright
  (`/Users/dmitriy/.npm/_npx/e41f203b7505f1fb/node_modules/playwright`, `ignoreHTTPSErrors:true`,
  `page.setViewportSize()` + `page.screenshot()` оба работают в этом окружении) — скриншоты и
  `getBoundingClientRect()`/`getComputedStyle()` по 4 эталонным ширинам. Раунд 1 исполнителя использовал
  `iframe` внутри Electron-браузера Traycer из-за `setViewportSize() cannot be represented at current
  page zoom`; с follow-up 1 это ограничение снято — используется обычный headless-прогон.

## 404 — `404.php` (2026-10-15)

- Любой несуществующий URL: HTTP 404, без редиректа; ровно один `h1`; CTA — `<a>` на `home_url('/')`.
- Светлые шапка и футер, нет горизонтальной прокрутки на 1920…320 и на границах 1600/1599, 1200/1199, 992/991, 768/767, 576/575, 420/419.
- Hover и `:focus-visible` на кнопке: круг разрастается, текст не прыгает; иллюстрация и тень — `alt=""`.
- Эталоны: 1440 ↔ `722:20638`, 840 ↔ `722:23852`, 392 ↔ `722:24249`. Cookie-баннер перекрывает низ скриншотов — это нормально.

## 1. PHP-синтаксис — обязательно

```bash
cd /Applications/MAMP/htdocs/nvglobal.local/wp-content/themes/nvglobal
find . -name '*.php' -not -path './.git/*' | while read f; do
  /Applications/MAMP/bin/php/php8.3.30/bin/php -l "$f" | grep -v "No syntax errors" 
done
```

Пустой вывод = всё чисто. На 2026-10-05 все 41 файл проходят.

---

## 2. Страницы отвечают

```bash
for u in / /solutions/ /pricing-matrix/ /docs/ /privacy-policy/ /terms-of-use/ \
         /information-security-policy/ /nesushchestvuyushchaya-stranica/; do
  printf "%-38s " "$u"
  curl -sk -o /dev/null -w "HTTP %{http_code}\n" -m 40 "https://nvglobal.local$u"
done
```

Ожидается 200 на всех, кроме последнего — там 404.

---

## 3. Консоль, переполнение, baseline

Playwright установлен не глобально, а в кэше npx. Путь находится так:

```bash
PW=$(find ~/.npm/_npx -maxdepth 4 -name playwright -type d | head -1)
echo "$PW/index.mjs"
```

Скрипт проверки (подставить найденный путь в `import`):

```js
import { chromium } from '<путь из $PW>/index.mjs';
const pages = [['home','/'],['solutions','/solutions/'],['pricing','/pricing-matrix/'],['docs','/docs/']];
const vps = [[1920,1080],[1440,900],[840,1000],[392,850],[375,812]];
const b = await chromium.launch();
for (const [name, path] of pages) for (const [w,h] of vps) {
  const ctx = await b.newContext({ viewport:{width:w,height:h}, ignoreHTTPSErrors:true });
  const p = await ctx.newPage(); const errs=[];
  p.on('console', m => { if (m.type()==='error') errs.push(m.text()); });
  p.on('pageerror', e => errs.push('PAGEERROR: '+e));
  p.on('response', r => { if (r.status()>=400) errs.push(r.status()+' '+r.url()); });
  await p.goto('https://nvglobal.local'+path, { waitUntil:'load', timeout:60000 });
  await p.waitForTimeout(3500);
  await p.screenshot({ path:`shots/${name}_${w}.png` });
  const ov = await p.evaluate(()=>document.documentElement.scrollWidth > window.innerWidth+1);
  console.log(name, w, 'переполнение:', ov, 'ошибок:', errs.length, errs.slice(0,3));
  await ctx.close();
}
await b.close();
```

### Baseline — с чем сравнивать

Высота документа в px.

**После группы 3 (2026-10-06):**

| Страница | 1920 | 1440 | 840 | 392 | 375 |
|---|---|---|---|---|---|
| `/` | 9259 | 9404 | 13244 | — | — |
| `/solutions/` | — | 9190 | — | — | 12952 |
| `/pricing-matrix/` | — | 6341 | — | — | 6750 |

Высота главной после группы 3 практически не изменилась: секция Products стала
674 вместо прежних ~700, слайды одинаковой высоты.

### Проверка слайдера Products

Обязательный сценарий (скрипт `slider2.mjs` в каталоге сессии):

1. первый слайд активен, `prev` заблокирована;
2. шесть переходов стрелкой вперёд — заголовки и вкладки совпадают по порядку;
3. на шестом `next` получает `disabled`, индекс не меняется, зацикливания нет;
4. возврат назад до первого, `prev` снова заблокирована;
5. переключение вкладками напрямую в произвольном порядке;
6. клавиши ←/→ при фокусе на `.products__slider`;
7. `aria-selected` и roving `tabindex` синхронны с активной вкладкой;
8. **высота секции 674 на каждом слайде** — скачков нет.

Hover-состояния (замерены по фрейму `2386:28499`):

| Элемент | Обычное | Hover |
|---|---|---|
| вкладка | `#E4E4E4` | `#D2D2D2` |
| стрелка | `#F2F2F2` | `#E4E4E4` |
| Request a Demo / Learn more | градиент | сплошной `#FD6B01` |
| Talk to Sales | `#F2F2F2` | `#E4E4E4` |

> Ложное срабатывание детектора «выходов за карточку» на ширинах ≤576: это
> off-screen слайды Swiper внутри `overflow: hidden`, все с `внутриSwiper: true`
> и отрицательным вертикальным выносом. Визуально ничего не выходит.

**После группы 2 (2026-10-05):**

| Страница | 1920 | 1440 | 840 | 392 | 375 |
|---|---|---|---|---|---|
| `/` | 9259 | 9404 | 13244 | 16175 | 16417 |
| `/solutions/` | 9269 | 9190 | 12564 | 12673 | 12952 |
| `/pricing-matrix/` | 6237 | 6341 | 8127 | 6563 | 6750 |
| `/docs/` | 1772 | 1792 | 2109 | 2362 | 2386 |

Главная выросла относительно группы 1: добавлена секция Results.
Остальные страницы не изменились — это и есть проверка на регрессии.

**После группы 1 (2026-10-05):**

| Страница | 1920 | 1440 | 840 | 392 | 375 |
|---|---|---|---|---|---|
| `/` | 8821 | 9261 | 12942 | 15434 | 15569 |

Главная тогда стала короче исходной: скрыты `page-nav`, `video-intro`, `cases`, `promo` (Р-11).

**До редизайна (аудит 2026-10-05), для истории:**

| Страница | 1920 | 1440 | 840 | 392 | 375 |
|---|---|---|---|---|---|
| `/` | 10878 | 10990 | 15434 | 17716 | 17880 |
| `/solutions/` | 9269 | 9190 | 12588 | 12672 | 12951 |
| `/pricing-matrix/` | 6237 | 6341 | 8175 | 6561 | 6748 |
| `/docs/` | 1772 | 1792 | 2109 | 2362 | 2386 |

### Контрольные значения сетки главной

Контент = ширина экрана − 64 (поле 32px), как в макете:

| Вьюпорт | `.container` | Контент | Карточка Hero |
|---|---|---|---|
| 1920 | 1920 | **1856** | 1856×872 |
| 1440 | 1440 | **1376** | 1376×732 |
| 840 | 840 | **776** | 776×872 |

На `/solutions/`, `/pricing-matrix/`, `/docs/` контейнер должен остаться прежним:
1560 при 1920, 1408 при 1440, 754 при 840. Изменился — задета общая сетка,
это регрессия.

### Высоты секций главной (группа 2)

| Ширина | `.about` | `.results` | `.solutions` |
|---|---|---|---|
| 1920 | 810 | 648 | 640 |
| 1440 | 832 | 648 | 640 |
| 1200 | 864 | 690 | 688 |
| 992 | 940 | 774 | 856 |
| 840 | 1042 | 986 | 904 |
| 768 | 1112 | 1010 | 904 |
| 576 | 1255 | 1087 | 1366 |
| 392 | 1629 | 1396 | 1431 |

### Проверка «ничего не вылезает из карточек»

Отдельная проверка на всех ширинах: ни один потомок `.about__card`,
`.results__stat` и `.solutions__item` не выходит за границы своей карточки.

Исключение по замыслу — `.results__case`: декоративная 3D-иллюстрация специально
выходит за правый нижний угол (65px вправо, 45px вниз, как в макете −66/−46)
и обрезается `overflow: hidden`. Текст до неё не доходит, зазор 14px.
Ниже 768px иллюстрация скрыта — там карточка слишком узкая.

### Фон страниц

`body` на `/` — `rgb(248, 248, 248)`. На остальных страницах — `rgb(33, 33, 33)`,
пока их не редизайнили. Потемнела главная или посветлела другая страница — регрессия.

- **Горизонтального переполнения нет нигде** — ни на одной странице, ни на одном вьюпорте.
  Это главный регрессионный индикатор: появилось — сломали вёрстку.
- **Ошибок JS в консоли нет** на `/`, `/solutions/`, `/docs/`.
- **На `/pricing-matrix/` — один 404:** `img/info.svg`, нужен для
  `.packages__service-icon` (`styles.css:12822`). Файла в теме нет и не будет
  до редизайна страницы — **решено ждать иконку из Figma** (`docs/DECISIONS.md`, Р-7).
  **Это ожидаемое состояние. За новую ошибку не считать.**
  Регрессией будет только *второй* 404 на этой странице.
- Фоновые `ERR_ABORTED` на `*.w.hcaptcha.com/logo.png` — внешние запросы hCaptcha, шум.

Скриншоты baseline сняты во временный каталог сессии и в репозиторий не добавлялись.

---

## 4. Фронтенд вручную

На 1920 / 1440 / 840 / 392 / 375:

- **Меню:** открытие и закрытие бургера, блокировка скролла, закрытие по клику вне и по пункту.
- **Якоря:** все пункты шапки (`#about`, `#solutions`, `#products`, `#advantages`,
  `#clients`, `#cases`, `#contacts`) ведут в свои секции; `.page-nav` подсвечивает активную.
- **Слайдеры:** products (7 слайдов), cases (3), news (5), benefits, flow, industries,
  integration, security — листание, стрелки, disabled у крайних.
- **Табы:** doc-табы на главной, features и benefits на `/solutions/`, FAQ-аккордеон.
- **Калькулятор `/pricing-matrix/`:** переключение DOCUMENT / LIVENESS / BASIC,
  слайдер объёма, пороги 10 000 / 50 000 / 100 000, «ON REQUEST» выше 100 000,
  при LIVENESS блок документов скрыт (`calculator--no-documents`), доплата за доп. документы.
- **Модалки:** `callForm`, `callForm2`, `review`, `thanks` — открытие, закрытие по overlay и Esc.
- **Cookie-баннер.**
- **Документация:** дерево меню, автопрокрутка к активному пункту, сайдбар на мобильных.

> **Формы не отправлять.** Заявки реально уходят по SMTP, в Telegram и в HubSpot.
> Проверять только UI: валидацию, маску телефона, состояния кнопки.

---

## 5. После правок CSS или JS

**Поднять `THEME_ASSETS_VER`** в `functions.php:16` (сейчас `1.0.50`).
Иначе браузер и Seraphinite Accelerator отдадут старую версию, и проверка будет ложной.

---

## 6. Структура CSS не разъехалась

> С 2026-10-21 (Р-150) `css/styles.css` — заглушка; правила в `css/base.css`, `css/layout/`, `css/blocks/`, `css/pages/`. Команды ниже
> относятся к прежнему монолиту. Для переносов правил — снимок computed styles до/после (`docs/FRONTEND.md` §2).

```bash
# секции на месте (было 38 маркеров START/END)
grep -cE '^/\*\s*[A-Za-zА-Яа-я0-9 _-]+\s*=*\s*(START|END)\s*=*\s*\*/' css/styles.css

# media-запросы не уехали в конец файла
tail -20 css/styles.css

# line-height в px — должно быть 0
grep -c 'line-height:\s*[0-9]*px' css/styles.css

# новые брейкпоинты не появились
grep -oE '@media[^{]*max-width:\s*[0-9.]+px' css/styles.css |
  grep -oE '[0-9.]+px' | sort -u
```

Ожидаемый набор брейкпоинтов: `1599.98` `1399.98` `1199.98` `991.98` `767.98` `575.98`
`478.98` `419.98` плюс унаследованные `620` `460` `379.98`.

---

## 7. Токены не объявлены

```bash
grep -rnE '^\s*--(island|stroke|text|range)-' css/*.css
```

Должно находить **только** `--toc-depth-offset` в `css/document-toc.css`.
Появилось что-то ещё в `:root` — цвета поехали разом в сотне мест, см. `docs/THEME-TODO.md`.

Проверка в браузере:

```js
getComputedStyle(document.documentElement).getPropertyValue('--island-white-5')
// ожидается пустая строка
```

---

## 7.1. Переписали секцию — проверь, что не унесли чужие правила

**Обязательный шаг после любого переписывания блока `/* X START */ … /* X END */`.**

Разбор должен заходить **внутрь `@media`**. Просмотр правил верхнего уровня
пропускает ровно тот случай, который уже ломал `/solutions/` (R-15).

```bash
# селекторы старой секции, которых больше нет в файле
/usr/bin/python3 docs/qa-scripts/lost2.py     # «ЧУЖИХ» должно быть 0

# новые селекторы без body.home, которые могут задеть другие страницы
/usr/bin/python3 docs/qa-scripts/unscoped.py

# изменённые правила общих классов
/usr/bin/python3 docs/qa-scripts/mod.py
```

`mod.py` ищет по подстроке и даёт известные ложные срабатывания:
`.about`, `.products`, `.solutions`, `.verify` — на других страницах таких
классов нет (совпадает `main--solutions`, `btn-hero` и подобное).
`.top__widget` — осознанная правка R-13. Всё остальное в выводе нужно разбирать.

Прежде чем объявлять селектор «ничейным», проверь его по шаблонам:

```bash
grep -rn 'имя-класса' --include='*.php' .
```

Учитывай альтернативные шаблоны главной — `index.php` и
`main-page-video-autoplay.php` тоже используют эти классы.

### Эталонное сравнение страниц

Самая надёжная проверка: отрендерить страницы с CSS **до редизайна**
и с текущим, затем сравнить каждый видимый элемент.

```bash
export PW=/Users/dmitriy/.npm/_npx/e41f203b7505f1fb/node_modules/playwright/index.mjs
cp css/styles.css /tmp/nv-current.css
git show 3851075:css/styles.css > css/styles.css
node docs/qa-scripts/snap.mjs /tmp/nv-base.json
cp /tmp/nv-current.css css/styles.css      # вернуть ОБЯЗАТЕЛЬНО
node docs/qa-scripts/snap.mjs /tmp/nv-now.json
```

Сверяются координаты, размеры, `color`, `background-color` и `font-size`
каждого элемента на `/solutions/`, `/pricing-matrix/`, `/docs/`,
`/privacy-policy/`, `/blog/` и 404 при 1920 / 1440 / 840 / 375.

Ожидание — **0 расхождений**. Допустимое исключение одно: равномерный сдвиг
бегущей строки `.main__slider-track` на `/solutions/` (фаза анимации,
размеры и цвета совпадают).

### Playwright зависает на `nvglobal.local`

macOS резолвит имена в зоне `.local` через mDNS и тратит ровно 5 секунд
на каждый запрос, несмотря на запись в `/etc/hosts`. На странице с полусотней
ресурсов это кладёт весь прогон в таймаут, а воркеры Apache копятся
и сервер перестаёт отвечать.

Проверка:

```bash
curl -sk -o /dev/null -w "dns:%{time_namelookup}s total:%{time_total}s\n" https://nvglobal.local/
```

`dns:5.0s` — это оно. Лечится на стороне браузера, система не трогается:

```js
chromium.launch({args:['--host-resolver-rules=MAP nvglobal.local 127.0.0.1,MAP www.nvglobal.local 127.0.0.1']})
```

Во всех скриптах `docs/qa-scripts/` этот аргумент уже прописан.

### Ловушка с переменными

`--nv-*` объявлены только в `body.home`. Любое глобальное правило вида
`background: var(--nv-…)` вне главной **невалидно** и даёт прозрачный фон —
именно так группа 1 обнулила `.btn-hero` на четырёх страницах.

Быстрая проверка в браузере на не-главной:

```js
getComputedStyle(document.querySelector('.btn-hero')).backgroundColor
// не должно быть rgba(0, 0, 0, 0), если фон задумывался
```

---

## 7.2. Секция Blog: проверка без реальных записей

В локальной базе **0 опубликованных записей** (`post` / `publish`), один
`auto-draft`. Создавать записи нельзя — это постоянная база проекта.

### Пустое состояние

Секция обёрнута в `if ($nv_news_query->have_posts())`. Ожидание:

```js
document.querySelector('.news')            // null
document.querySelectorAll('.news__arrow')  // 0
```

Пустых контейнеров и нерабочих стрелок быть не должно.

### Проверка с публикациями — временный мок

Постоянная база не меняется. Мок кладётся в
`wp-content/mu-plugins/nv-blog-test-fixture.php`, включается **только**
параметром `?nv_blog_fixture=N` и **удаляется сразу после прогона**.

Что делает: фильтром `the_posts` подменяет результат запроса секции
синтетическими `WP_Post`; просмотры, лайки и `_thumbnail_id` отдаёт через
`get_post_metadata`; постоянную ссылку — через `post_link`; страницу записей
для кнопки — через `pre_option_page_for_posts` (`?nv_blog_page=ID`).

Две ловушки, на которые уходит время:

1. **ID должны быть положительными** и вне диапазона реальных записей
   (используются 900001+). WordPress прогоняет `$object_id` через `absint()`
   в `get_metadata_raw`, поэтому отрицательные ID ломают все meta-фильтры.
2. **Обложку нельзя подсунуть фильтром `post_thumbnail_html`**:
   `get_the_post_thumbnail()` выходит раньше, если `get_post_thumbnail_id()`
   вернул 0. Нужно отдавать реальный ID вложения через `_thumbnail_id`.

Что обязательно прогнать: 1, 2, 4 записи; длинный и очень короткий заголовок;
запись без обложки; разная длина анонса. Проверяется ширина карточки против
макета, выравнивание блоков автора в линию, прокрутка слайдера и её
отсутствие, когда карточки помещаются.

### Ограничение

Мок подтверждает путь «`WP_Query` → цикл → `template-parts/news-card.php`»
целиком, включая `the_permalink()`, `the_title()`, `get_the_excerpt()`,
`the_post_thumbnail()` и `get_avatar()`. Он **не** проверяет выборку из
таблицы `wp_posts` — результат запроса подменяется фильтром. Полная проверка
возможна только после появления реальных публикаций.

---

## 7.3. FAQ: что проверять

### Что нельзя сломать

Классы `.faq__*` общие с `/solutions/`. Все правила главной обязаны идти
через `body.home`. Проверка:

```bash
/usr/bin/python3 -c "
import io,subprocess
exec(io.open('docs/qa-scripts/lost2.py',encoding='utf-8').read().split('cur=io.open')[0])
old=subprocess.run(['git','show','HEAD:css/styles.css'],capture_output=True,text=True).stdout
cur=io.open('css/styles.css',encoding='utf-8').read()
new=[s for s in selectors(section(cur,'FAQ')) if s not in selectors(section(old,'FAQ'))]
print('без body.home:',[s for s in new if 'body.home' not in s])"
```

Должен быть пустой список. Плюс обязательная сверка `/solutions/`
с baseline (раздел 7.1) — расхождений быть не должно.

### Связка CSS и JS, которую легко разорвать

`initFaq` считает высоту панели как `scrollHeight содержимого + поля текста`
и прибавляет **48 выше 768px и 32 ниже**. Поэтому отступы ответа заданы
через `margin` у `.faq__item-answer-text`, а не через `padding` панели,
и правило `margin: 16px 0` стоит в блоке `767.98` — там же, где переключение
в JS.

Если поменять одно без другого, между 576 и 767 ответ обрежется.
Проверка: открыть длинный ответ на 768 и 576 и сравнить

```js
const a = document.querySelector('.faq__item--open .faq__item-answer');
a.scrollHeight > a.clientHeight + 1   // должно быть false
```

### Функциональные проверки

Открытие, закрытие повторным нажатием, переключение между вопросами
(предыдущий должен закрываться), Enter, Space, `:focus-visible`,
`aria-expanded`, поворот шеврона, отсутствие скачков ширины страницы.

Ответы есть только у первого вопроса (R-18). Остальные проверяются
**DOM-фикстурой в браузере**: через `context.addInitScript` панели ответов
добавляются в обработчике `DOMContentLoaded` до вызова `initFaq`, поэтому
тестируется реальный код. В шаблон и базу ничего не пишется.

### Высота строк

Закрытая строка должна быть **ровно 88px** на Full HD, Desktop и Tablet.
Паддинги уменьшены на толщину рамки (карточка 15 при рамке 1, шапка 11/23):
Figma рисует обводку внутрь габарита. Меняя паддинг, пересчитывай и рамку,
иначе высота разъедется.

Раскрытая карточка — 193 при ожидаемых 192 в макете: 1px пунктирного
разделителя, это известное и зафиксированное расхождение (Р-30).

### Чего не должно появиться

Пустых раскрывающихся панелей, кнопок-заглушек у вопросов без ответа,
разметки `FAQPage` / `Question` с неутверждёнными текстами (R-19).

---

## 7.4. Contacts: как проверять форму, не отправляя заявок

### Что нельзя сломать

Классы формы общие с модалкой из `footer.php` — она есть на **каждой**
странице, включая главную. Все правила главной обязаны идти от
`body.home .contacts`, одного `body.home` недостаточно.

Проверка:

```bash
/usr/bin/python3 -c "
import io,re
L=io.open('css/styles.css',encoding='utf-8').read().split('\n')
st=L.index('/* CONTACTS START */'); en=L.index('/* CONTACTS END */')
print([l.strip() for l in L[st:en] if re.match(r'^\s*body\.home (?!\.contacts)',l)])"
```

Должен быть пустой список. Плюс прямое сравнение модалки: открыть главную
до и после правок и сверить вычисленные стили
`#callForm .contacts__form .input-form-block` — они обязаны совпадать.

### Безопасное тестирование

Реальные заявки не отправляем. В Playwright перехватываем запросы:

```js
await p.route('**/wp-admin/admin-ajax.php', async route => {
  const post = route.request().postData() || '';
  if (post.includes('send_contacts_form')) {
    return route.fulfill({status:200, contentType:'application/json',
      body: JSON.stringify({success:true, data:{message:'MOCK OK'}})});
  }
  return route.continue();
});
await p.route(/api\.telegram\.org|api\.hubapi\.com|hookdeck/, r => r.abort());
```

### Что проверять

Поля и их `name`/`type`; пустая отправка (должны появиться блоки
`.is-error` и **ни одного** запроса); варианты `Select your option...`
и запись значения в `clientOption`; список стран (должен открываться,
не обрезаться родительским `overflow`, менять код); согласие; отсутствие
ошибок JS.

Две ловушки:

1. Чекбокс визуально перекрыт `.ui-check__box` — кликать нужно по боксу
   или по подписи, но не в центр подписи: там ссылка на документы.
2. Включена **hCaptcha** (`window.__USE_CAPTCHA__ === true`). После
   успешной валидации форма ждёт токен и только потом шлёт AJAX. Решать
   настоящую капчу нельзя, поэтому серверный путь остаётся непроверенным —
   это зафиксировано как ограничение (BACKLOG R-21), а не как дефект.

### Измерения

Анимация появления секции сдвигает элементы трансформом. Перед замерами
координат отключать:

```js
await p.addStyleTag({content:'.contacts *,.contacts{transform:none!important;opacity:1!important;animation:none!important;transition:none!important}'});
```

## 7.5. Footer и Teaser: что проверять

### Что нельзя сломать

Футер и тизер выводятся **на каждой странице темы**. Светлая версия
подключается только на главной (`is_front_page()`), поэтому любая правка
проверяется с двух сторон:

| Проверка | Как |
|---|---|
| Остальные страницы не изменились | поэлементный снимок `docs/qa-scripts/snap.mjs` до и после — расхождений должно быть **0** |
| Модалки `#callForm` / `#callForm2` не изменились | снимок вычисленных стилей всех потомков модалок на главной и на `/solutions/` — **0** расхождений |
| Принятые секции главной не изменились | `docs/qa-scripts/home-sections.mjs` до и после — **0** расхождений |

Ещё нельзя терять:

- `.teaser__maskot` и его анимацию в тёмной версии — в `initMaskotAnimation`
  стоит `if (!maskots.length) return;`, на главной маскота просто нет;
- cookie-баннер и обе модальные формы — они лежат в `footer.php`
  **после** `endif` и общие для всех страниц;
- ссылку `aria-label` у иконки соцсети и `rel="noopener noreferrer"`.

### Ссылки

В футере не должно быть `href="#"`. Перед сдачей — проверить коды ответа:

```
/docs/ /pricing-matrix/ /terms-of-use/ /privacy-policy/ /information-security-policy/
```

Пункт, для которого адреса нет, **не выводится** (Blog, Telegram) либо ведёт
на реальный существующий якорь (`/#products`, `/#about`, `/#contacts`).

### Геометрия

Опорные значения макета (относительно карточки футера):

| Что | Full HD | Desktop | Tablet |
|---|---|---|---|
| Ширина карточки | 1856 | 1376 | 776 |
| Ряд контента | 1792 | 1312 | 712 |
| Колонки навигации, x | 0 / 280 / 505 | 0 / 176 / 361 | 0 / 297.5 / 558 |
| Высота тизера | 416 | 468 | 468 |

Высота карточки будет **меньше макета**: в теме нет второй строки
реквизитов (R-23), а нижняя строка выше — тексты темы длиннее (R-25).
Это ожидаемое расхождение, не дефект.

### Горизонтальное переполнение

Проверять на всех ширинах: `document.documentElement.scrollWidth` должен
равняться ширине вьюпорта, и ни один потомок `.footer__wrapper` не должен
выходить за его границы.

---

## 7.6. Сквозной аудит: три проверки, которые нельзя заменить ничем

### Вертикаль страницы против Figma

Посекционного совпадения мало: страница может расходиться с макетом
накопленно. Снимать так:

1. `get_metadata` на корневой фрейм макета (`2380:22854` / `291:5735` /
   `2376:16686`). Ответ больше лимита — MCP сохраняет его в файл,
   разбирать оттуда по отступам: дети первого уровня = секции,
   у каждой есть `y` и `height`, скрытые помечены `hidden="true"`.
2. В браузере снять `offsetTop` и `height` каждой секции.
3. Сверять высоты, а не только координаты.

⚠️ **Не отключать трансформы глобально** (`*{transform:none!important}`)
перед замерами: это ломает блоки, которые на трансформах построены, и даёт
ложные расхождения. Правильно — прокрутить страницу до конца, чтобы доиграли
анимации появления, и только потом гасить `transition` и `animation`.

### Эталон «до редизайна» для чужих страниц

Единственный надёжный способ доказать отсутствие регрессий — сравнить
с состоянием до редизайна (`3851075`), а не с предыдущей группой.

Процедура без запрещённых git-команд:

```bash
# 1. резерв текущих файлов
cp css/styles.css js/main.js footer.php functions.php    template-parts/teaser.php <scratch>/backup-head/...
# 2. подмена на эталон
for f in css/styles.css js/main.js footer.php functions.php          template-parts/teaser.php; do git show 3851075:$f > $f; done
# 3. снимок
node docs/qa-scripts/snap.mjs <scratch>/baseline.json
# 4. восстановление из резерва + проверка
#    git status должен быть пуст, md5 css/styles.css совпасть
```

Менялись только эти пять файлов плюс `main-page.php` и новые
`template-parts/*`, поэтому для страниц вне главной их достаточно.

Ожидаемый результат: расхождения только по координате `x`
`.main__slider-track` на `/solutions/` — это работающая бегущая строка.

### Область действия новых CSS-правил

Проверять не «есть ли класс на другой странице», а **корневой класс
селектора**: `.doc .btn` опасен, только если на достижимой странице есть
именно `doc`, а не `btn`.

И считать достижимые шаблоны: `index.php` и
`main-page-video-autoplay.php` содержат старую разметку главной, но
не выводятся ни на одной странице — пересечения с ними ложные.

---

## 7.7. Три ловушки, на которых правки раскладки ломаются молча

### `flex-basis: 0` и доли не совпадают с макетом
`flex: 1 1 0` + `padding`/`border` на элементе: Chrome распределяет свободное
место **поверх** паддинга и рамки, поэтому `1 : 1 : 1.5` даёт 528 / 528 / 767
вместо 521 / 521 / 782. Если нужны точные доли из макета — задавать базу
процентом: `flex: 0 1 calc((100% - 32px) / 3.5)`.

### Скрытый `<br>` съедает пробел
`br { display: none }` убирает перенос, но не добавляет пробел: «for
onboarding,<br>compliance» превращается в «onboarding,compliance».
Лечится пробелом после `<br>` в разметке — при видимом переносе он
схлопывается в начале строки и ничего не меняет.

### Фиксированная колонка упирается в минимум и вылезает
`grid-template-columns: 1fr 324px 340px` и `flex` с `min-width: Npx`
перестают помещаться задолго до следующего брейкпоинта: сетка молча
выходит за контейнер, страница при этом **не** получает горизонтальной
прокрутки, потому что вылет съедают паддинги контейнера. Проверять не
`scrollWidth`, а правый край самих блоков:

```js
document.querySelectorAll('section *').forEach(e => {
  const r = e.getBoundingClientRect();
  if (r.right > innerWidth + 1 && r.width <= innerWidth) { /* обрезка */ }
});
```

Диапазоны, на которых это уже ловилось: 992–1050 (`.how__deploy`),
1200–1230 (`.doc__card`).

---

---

## 7.6. Solutions: что проверять во время редизайна по группам

Страница переделывается **по группам**, поэтому на ней одновременно живут
новые светлые секции и старые тёмные. Это нормальное промежуточное состояние,
а не дефект. Что из-за этого нужно держать в голове:

| Проверка | Как |
|---|---|
| Токены не протекли на другие страницы | `body.home, body.page-template-page-solutions` — больше **никакие** страницы в селекторе не появляются; `snap.mjs` по pricing/docs/privacy/blog/404 = 0 расхождений |
| Главная не изменилась | `snap.mjs` только по `/` на 1920/1440/840/375 = 0 расхождений (блок токенов общий!) |
| Светлый фон не залил тёмные секции | фон задаётся `.header` и `.main--solutions`, **не** `body`: `body.page-template-page-solutions` не должен получать `background`/`color` до последней группы |
| Общие классы не переопределены глобально | новые правила начинаются либо с `body.page-template-page-solutions`, либо с собственного пространства секции (`.main__*`) |
| Модалки целы | `.open-callForm` / `.open-callForm2` сохранены на кнопках; снимок стилей модалок = 0 расхождений |

### Шапка

Светлая шапка Solutions ограничена `body.page-template-page-solutions`.
Проверять отдельно:

- ширина: шапка выровнена по сетке первого экрана (контент = экран − 64,
  поле 32; на мобильной 16), а не по общей лесенке `.container`;
- логотип: на десктопе и планшете скрыт (он в карточке первого экрана),
  на ≤767.98 показан тёмной версией — файл выбирает `header.php`
  по `is_page_template('page-solutions.php')`, в DOM один `<img>` с `alt`;
- стрелка кнопки Inquire: её рисует lottie, у путей нет своего `fill` —
  цвет приходит из `color` кнопки через `currentColor`. На Solutions белая,
  на остальных страницах чёрная;
- бургер на ≤991.98: светлая кнопка 40×40, «пилюля» вокруг убрана;
- **открытая панель меню не должна уезжать за правый край** — у темы она
  привязана к `left: 0`, на Solutions перевешена на `right: 0`;
- `aria-expanded` у бургера переключается, второе нажатие закрывает.

### Блок «Why Leading Companies» (`.solutions-why`)

| Проверка | Как |
|---|---|
| Переключение | клик по любой точке карточки 1–4, Previous / Next, ArrowLeft / ArrowRight / Home / End |
| Крайние состояния | на первой карточке Previous `disabled`, на четвёртой — Next; зацикливания быть не должно |
| Наведение | карточка раскрывается только при `hover: hover` и `pointer: fine`; после ухода мыши выбор **остаётся** |
| Переход 992 ↔ 840 | выбрать карточку 3 на 1440, сузить до 840 — раскрыты все четыре, `aria-expanded="true"`, кнопки `tabindex="-1"`; вернуть 1440 — выбор карточки 3 восстановлен, клик работает (повторных обработчиков нет) |
| Анимация | меняется только `width`; высота доски не прыгает, текст не переносится заново |
| Reduced motion | при `prefers-reduced-motion: reduce` у `.solutions-why__card` `transition-duration: 0s` |
| Доступность | все четыре описания остаются в DOM на любой ширине; фокус на заголовке карточки даёт видимую обводку |

Автопрокрутки при загрузке `/solutions/` быть не должно ни на одной ширине —
после скрытия `.benefits` `scrollIntoView` из `initBenefitsSlider` больше
не срабатывает. Проверять на 840, 768, 576, 392, 375.

### Блок «Built for regulated industries» (`.industries` + `.nvslider`)

| Проверка | Как |
|---|---|
| Синхронность | на каждой из шести вкладок должны совпадать: активная вкладка, активный слайд, видимая иллюстрация, чипы, `aria-selected`, `tabindex` |
| Крайние состояния | на первой вкладке Previous `disabled`, на шестой — Next; переходов 6 → 1 и 1 → 6 быть не должно |
| Клавиатура | ArrowLeft / ArrowRight / Home / End переключают вкладку и переносят фокус; на краях ничего не меняется |
| Активная вкладка видна | после переключения активная вкладка должна попадать в видимую зону панели (фокус ставится с `preventScroll`, иначе панель прокручивается сама и спорит со Swiper) |
| Свайп | протягивание содержимого меняет вкладку и иллюстрацию; протягивание самой панели вкладок — только прокрутка списка |
| Resize | выбрать пятый слайд на 1440, пройти 840 → 392 → 1440: выбор сохраняется, клик после возврата работает, консоль чистая |
| Высота | высота секции одинакова на всех шести вкладках — переключение не должно двигать страницу |
| Переполнение | иллюстрация выходит за правый край и обрезается секцией; `scrollWidth` страницы не должен превышать `clientWidth` ни на одной ширине |
| Подписи вкладок | ни одна подпись не должна обрезаться: сравнить `scrollWidth` кнопки с её шириной на 1920…320 |

### Блок «One platform. Lots of products. One API» (`.solutions-products`)

| Проверка | Как |
|---|---|
| Якорь | прямой переход `/solutions/#solutions` должен останавливаться ровно на этой секции; обе ссылки «Learn more» со слайдера Products на главной ведут туда же |
| Дубли `id` | `#solutions` должен быть ровно один: при переносе якоря его снимают с блока Why |
| Ссылки | `href="#"` быть не должно; кнопка выводится только у карточек с заполненным `link` в `$nv_products` |
| Доступные имена | у ссылки `aria-label` вида «Learn more about …», в нём сохранён видимый текст |
| Заголовки | H2 секции и по одному H3 на карточку |
| Сетка | 3 колонки от 992, 2 на планшете, 1 ниже 768; ряды одинаковой высоты, кроме мобильной |
| Состояния | focus-visible 2px, hover меняет подложку кнопки; на акцентной карточке подложка на уровень темнее |

После замены `.flow`: её разметки в DOM быть не должно, `initFlowSlider`
не должен падать (у функции есть guard), якоря `#products` на этой странице
больше нет.

### Блок «Seamless Integration That Just Works» (`.integration`)

| Проверка | Как |
|---|---|
| Слайды | 1 → 2 → 3 и обратно; Previous выключен на первом, Next на третьем; зацикливания и автопрокрутки быть не должно |
| Индикатор | активный штрих совпадает с номером слайда; сами штрихи не кликабельны и помечены `aria-hidden` |
| Клавиатура | ArrowLeft / ArrowRight при фокусе внутри блока; у стрелок видимая обводка фокуса |
| Подписи стрелок | «Previous integration path» / «Next integration path» — задаются через `a11y` Swiper, иначе он ставит свои |
| Свайп | работает мышью и пальцем; вертикальная прокрутка страницы не перехватывается |
| Отсутствие сдвига | на всех трёх слайдах высота секции, положение правой колонки и начало секции Security должны совпадать |
| Resize | выбрать третий слайд на 1440, пройти 840 → 392 → 1440: выбор сохраняется, Previous после возврата работает |
| Правая колонка | три карточки статичны и с активным слайдом не связаны |
| Ссылки | «View documentation» → `/docs/`; «Talk to integration team» открывает модальную форму через `.open-callForm2` |

После замены: разметки старого слайдера и `uptime-gauge` в DOM быть не должно,
`initUptimeGauge` не должен падать.

### Блок «Security & compliance» (`.solutions-security`)

| Проверка | Как |
|---|---|
| Неинтерактивность | внутри секции ноль `a` / `button` / `input` / `[tabindex]` / `[role="button"]`; клик по плитке ничего не делает и не меняет адрес |
| Раскладка | 4 в ряд от 1400 (иллюстрация третья), 2x2 от 768 до 1399.98 (иллюстрация последняя), одна колонка ниже 768 |
| Иллюстрация | щит выходит за верхний край своей плитки и не обрезается (`overflow: visible` только у `--image`); на остальных плитках `overflow: hidden` сохраняется |
| Ширина плитки с щитом | на 1400…1599 ей должно хватать ширины на щит 238 + поле 24; если плитка уже — раскладка должна уже быть 2x2 |
| Загрузка картинки | после прокрутки к секции `naturalWidth` = 337, `srcset` отдаёт `@2x` на плотности 2 |
| Декоративное | у иконок и `img` — `aria-hidden="true"`, у изображения пустой `alt` |
| Заголовки | один H2 на секцию, по одному H3 на текстовую плитку; у плитки с иллюстрацией заголовка нет |
| Высота ряда | все плитки ряда одной высоты; от 768 и выше высота не меньше 212 |
| Переходы | 1400 → 1399, 1200 → 992, 992 → 840, 768 → 576: раскладка меняется без разрывов и схлопывания |

После замены: разметки тёмного `.security` со слайдером в DOM быть не должно,
`initSecuritySlider` не должен падать (у функции есть guard по `.security`).

### Блок «Not sure which product fits?» (`.contacts`)

Секция и **форма** общие с главной. Форма живёт в
`template-parts/contacts-form.php`, поэтому любая правка проверяется
на обеих страницах и в обеих модалках.

| Проверка | Как |
|---|---|
| Главная не изменилась | HTML главной до и после правки формы должен совпадать **байт в байт** (`curl -sk https://nvglobal.local/ \| diff`); снимок стилей = 0 расхождений |
| Форма одна | в `main-page.php` и `page-solutions.php` не должно быть разметки `<form class="contacts__form">` — только `get_template_part` |
| Параметр | `show_select` — единственное ветвление; на Solutions `[data-help-select]` в секции нет, на главной есть с четырьмя вариантами |
| Пустая отправка | ошибки появляются, запросов к `admin-ajax.php` — **ноль** |
| Невалидные данные | имя короче 2, кривой e-mail и неотмеченное согласие дают три разные подписи ошибок |
| Телефон | выпадающий список открывается, в нём **235** стран, он не обрезан краем экрана, `aria-expanded` переключается |
| Капча | не обходим и не отключаем; валидную форму не отправляем |
| Модалки | `#callForm` и `#callForm2` на всех страницах — снимок стилей сравнивать отдельно |
| Раскладка | 1600+ левая колонка 580, 1400–1599 — 443, ниже 992 блоки в столбик: заголовок, форма, оранжевая карточка |
| Оранжевая карточка | на Full HD и Desktop в потоке без вылета за край экрана; на планшете заголовок слева, контакты справа; на мобильной заголовок сверху |
| Мессенджеры | выводятся только с реальными адресами, `href="#"` быть не должно |
| Якорь | `id="cta"` на новой секции, дублей `id` на странице нет |

После замены: разметки `.cta` в DOM быть не должно.

### Скрытая на Solutions секция отзывов

| Проверка | Как |
|---|---|
| Нет в DOM | `document.querySelector('.testimonials')` на `/solutions/` = `null` на всех ширинах |
| Нет пустого места | зазор между низом `.solutions-security` и верхом `.faq` = 0 на 1920 / 1440 / 840 / 392 |
| Главная цела | на `/` секция отзывов работает как раньше, `initTestimonialsSlider` без ошибок |

### Блок «Questions we hear most» (`.faq`)

Компонент общий с главной: тот же `initFaq()`, та же разметка, общие базовые
правила CSS. Поэтому любая правка FAQ проверяется **на обеих страницах**.

| Проверка | Как |
|---|---|
| Главная не изменилась | снимок стилей `/` на 1920 / 1440 / 840 / 375 = 0 расхождений; первый вопрос раскрыт, click / Enter / Space работают |
| Раскрытие | первый вопрос раскрыт сразу; click закрывает, повторный открывает; Enter и Space делают то же самое |
| ARIA | у кнопки `aria-expanded` и `aria-controls`, у панели свой `id`, `role="region"` и `aria-labelledby`; каждый `aria-controls` указывает на существующий `id` |
| Строки без ответа | `faq__item--static` — это `div`, не `button`: табом не берётся, шеврона нет, курсор обычный |
| Клавиатура | Tab после кнопки «Talk to an Engineer» попадает на вопрос, обводка фокуса 2px видимая |
| Стабильность раскладки | при открытии и закрытии ширина правой колонки не меняется, шеврон не прыгает, текст не обрезается (`scrollHeight` панели равен её высоте в открытом состоянии) |
| Resize | открыть вопрос на 1440, пройти 840 → 392 → 1440: состояние сохраняется, клик после возврата работает, обработчики не задваиваются |
| Reduced motion | при `prefers-reduced-motion: reduce` у панели и шеврона `transition-duration: 0s` на обеих страницах |
| Раскладка | 1600+ левая колонка 600, 1400–1599 — 440, ниже 992 колонки складываются; у Solutions CTA уходит под текст, у главной — вправо от него |
| Микроразметка | `FAQPage` JSON-LD **не добавляем** — это не входило в задание (DECISIONS.md, Р-92) |

После замены на Solutions: прежних пяти тёмных спойлеров с длинными ответами
в DOM быть не должно, `.faq__image` (`td_image`) больше не выводится.

### Светлые тизер и подвал (`.teaser`, `.footer`)

Компоненты общие: одна разметка на главную и на `/solutions/`, вариант
выбирает `nv_is_light_theme()`. Любая правка проверяется на обеих страницах.

| Проверка | Как |
|---|---|
| Вариант подвала | светлый (`.footer__brand`) только на `/` и `/solutions/`; на pricing, docs, privacy, blog и 404 — прежний тёмный (`.teaser__maskot`) |
| Главная не изменилась | снимок стилей `/` на 1920 / 1440 / 840 / 375 = 0 расхождений |
| Новых файлов нет | `footer-solutions.php`, `teaser-solutions.php`, отдельного CSS быть не должно |
| Ссылки | ни одного `href="#"`; все внутренние адреса отвечают 200, якоря `#products`, `#about`, `#contacts` на главной существуют |
| Данные | `hello@nv.global`, IFZA Business Park, DDP, PO Box 342001, Dubai, UAE, Reg. 72252 · License 74254, NEUROVISION GLOBAL INTELLIGENCE - FZCO, три юридические ссылки — только утверждённые |
| Соцсети | только LinkedIn; число иконок в макете не повод добавлять профили |
| Логотип | `<img>` с `alt`, не фоном; светлая версия `footer_logo_light.svg`, тизер — `teaser_logo_primary.svg` |
| Стыки | зазоры Contacts → тизер и тизер → подвал равны 0 на всех ширинах: тёмных полос и двойных полей быть не должно |
| Модалки | `#callForm2` открывается, внутри одна форма и 235 стран, Escape закрывает, фокус уходит в форму |
| Нет Solutions-специфики | в регионах `TEASER HOME` и `FOOTER HOME` не должно быть ни одного одиночного правила `body.page-template-page-solutions`: тизер и подвал на обеих страницах совпадают до пикселя |
| Шапка | `header.php` и её CSS в редизайне Solutions не менялись |

### Всплывающие формы — что проверять

Светлый дизайн модалок (2026-10-12) держится на модификаторах
`modal--form` / `modal--large` / `modal--compact` / `modal--result`.

| Проверка | Ожидание |
|---|---|
| Окно отзывов `#review` | **остаётся тёмным**: фон `#212121`, рамка `#F9AA66`, подложка `rgba(0,0,0,.6)` |
| Остатки тёмной темы | в `#callForm` нет элементов со светлым текстом, тёмным фоном или белой рамкой — проверяется перебором `getComputedStyle` |
| Габариты | большая 901x712 и малая 640x676 на 1440; малая 360x644 на 392 |
| 15 ширин | все четыре окна и оба списка помещаются, горизонтальной прокрутки страницы нет |
| Заголовки | у каждой модалки свой id и свой `aria-labelledby`, битых ссылок нет |
| Закрытие | кнопка с `aria-label="Close"`, Escape, клик по подложке; фокус возвращается на триггер |
| Фокус-ловушка | 25 нажатий Tab не выводят фокус из окна |
| Клавиатура списков | ArrowDown открывает, стрелки водят, Home/End по краям, Enter выбирает, Escape закрывает **и не закрывает всё окно** |
| Ошибки | `aria-invalid`, разрешимый `aria-describedby`, `role="alert"` у текста |
| Успех | форма закрывается, открывается `#thanks`, поля очищены, фокус в диалоге |
| Ошибка отправки | открывается `#error`, введённое **сохранено**, форма не сброшена |
| Капча | 0 запросов к `admin-ajax.php`, пока токен hCaptcha пуст |
| Секции Contacts | снимок главной и Solutions — **0 расхождений** |

Успех и ошибку проверяем подменой ответа `admin-ajax.php` в тестовой
вкладке Playwright (`page.route`). Настоящую заявку не отправляем,
капчу не обходим, тестовых хуков в коде не оставляем.

### Финальный аудит Solutions — что считается нормой

Страница свёрстана целиком; при повторных проходах эти расхождения
с макетом **не считать дефектами** (DECISIONS.md, Р-104…Р-106):

- шапка отличается от макета Solutions составом меню — общий компонент, Р-45;
- подвал не сверяется с макетом Solutions: там устаревший инстанс
  компонента, источник истины — подвал главной, Р-101;
- первый экран на 10px выше макетного — это высота принятой шапки
  (74 против 96); сам первый экран совпадает точно;
- Industries ниже макета: Figma резервирует фиксированную высоту блока
  содержимого, в теме она идёт от содержимого и одинакова на всех вкладках;
- Integration выше макета: высота по третьему слайду, иначе переключение
  двигает страницу;
- на 840 карточки Products в макете растянуты по контейнеру (высота
  248.667 — артефакт fill), в теме они по содержимому;
- на 392 у KYB нет кнопки «Learn more», которая есть в макете: ссылки
  на реальную страницу пока нет (A-29);
- реальные тексты длиннее плейсхолдеров макета и дают другой перенос
  строк — в первую очередь «NeuroVision Global Systems» против
  «NV Global» в заголовке Why;
- юридический текст и тексты FAQ длиннее макетных — реальный контент;
- в подвале одна иконка соцсети и нет пункта Blog;
- `.main__fact` и `.industries__illustration` выходят за правый край
  экрана — так в макете, горизонтальной прокрутки страницы при этом нет.

**Security с 2026-10-10 должен совпадать с макетом точно** на 1920, 1440
и 840 — расхождение там больше нормой не считается (Р-107).

**FAQ с 2026-10-12 по высоте с макетом не сверяется:** выведены тексты
заказчика, они длиннее плейсхолдеров макета (Р-111). Проверять у FAQ нужно
другое: пять кнопок-вопросов, пять панелей `role="region"`, ни одного
`faq__item--static`, первый раскрыт, клик / Enter / Space работают на всех
пяти, при раскрытии текст не обрезается.

### Как снимать скриншоты для сверки с макетом

Две ловушки, на которые уже наступали (DECISIONS.md, Р-106):

1. Полностраничный скриншот Playwright не отрисовывает изображения
   с `loading="lazy"` за пределами исходного вьюпорта — в кадре окажутся
   пустые карточки. Снимать посекционно через `locator.screenshot()`
   после `scrollIntoView`, либо заранее перевести изображения в `eager`.
2. Перед съёмкой выставить `localStorage.setItem('cookieAccepted',
   'accepted')` и скрыть `.wc-fixed`, `.top__widget`, `#cookieBanner` —
   иначе они лягут поверх первых секций.

### Проверка формы — пошаговый сценарий

Прогонять на общей форме (главная и `/solutions/`), ничего не отправляя:

| Шаг | Ожидание |
|---|---|
| Пустая отправка | «Please enter your name», «Please enter your e-mail», «Please accept the privacy policy» |
| Имя из одного символа | «Please enter a valid name» |
| `not-an-email` | «Please enter a valid e-mail» |
| Всё заполнено, галочка снята | «Please accept the privacy policy» |
| Всё валидно | 0 запросов к `admin-ajax.php`: токен hCaptcha пуст, отправка не уходит |
| Список стран | открывается, `aria-expanded="true"`, 235 стран |
| Селект услуги | есть на главной, на Solutions его нет |
| Фокус любого поля | рамка обёртки становится `--nv-primary`, толщина, скругление и высота не меняются |

### Проверка светлой темы: что должно остаться тёмным

После любой правки `nv_is_light_theme()` сверять обе группы страниц.

| Страница | Шапка и подвал | Фон `body` |
|---|---|---|
| `/`, `/solutions/` | светлые | `/` — `#F8F8F8`, `/solutions/` — тёмный (фон задают секции) |
| `/privacy-policy/`, `/terms-of-use/`, `/information-security-policy/` | светлые | `#F8F8F8` |
| `/pricing-matrix/`, `/docs/`, `/blog/`, 404 | **тёмные** | `#212121` |

Светлый подвал опознаётся по `.footer__brand` в разметке, тёмный — по его
отсутствию. Шапка: `.header__menu` с фоном `#F2F2F2` — светлая, `#212121` —
тёмная.

### Юридические страницы — что проверять

Контент приходит из `the_content()`, поэтому после правок шаблона или CSS
сверять вывод с источником в БД: число и состав тегов и текст должны
совпадать (допустима только замена дефиса на тире фильтром `wptexturize`).

Проверять все три страницы — у них разные длина заголовка, объём текста
и набор блоков: в Privacy Policy есть `h3` и таблицы, в Terms of Use —
только `h2` и таблицы, в Information Security Policy Statement — список
и ни одного заголовка внутри контента.

### Известное, что не считать регрессией

- ~~Самопроизвольная прокрутка на 840~~ — ушла вместе со скрытием `.benefits`
  в группе 2. Если появится снова, смотреть `updateTabs` в
  `initBenefitsSlider` (`js/main.js`).
- Повторяющиеся `id` в DOM (`10111`, `5416`, `5403`, `5402`) приходят из
  SVG, который разворачивает lottie. В разметке темы их нет (BACKLOG A-27).
- Состав меню в шапке отличается от макета (8 пунктов против 5, одна кнопка
  против двух) — это решение Р-45, менять нельзя.
- Подзаголовок первого экрана длиннее макетного: в теме полное название
  «NeuroVision Global Systems» вместо «NV Global» (Р-49).
- На 992–1024 десктопная навигация не умещается и обрезается справа —
  на всех страницах с видимым логотипом, включая `/pricing-matrix/`.
  Поведение темы, не регрессия редизайна.
- На бургер-ширинах логотип стоит справа, бургер слева
  (`flex-direction: row-reverse` блока MENU). Исключение — `/solutions/`,
  где порядок обратный по макету.
- Контраст `--nv-primary` на `--nv-surface-1` — 2.72:1. Пара взята из
  макетов и применяется на всех светлых страницах; в юридическом тексте
  ссылки поэтому подчёркнуты постоянно (Р-125).

---

## 7.8. Pricing Matrix: регресс расчётов калькулятора

Дизайн страницы менять можно, числа — нельзя. Перед любой правкой
`/pricing-matrix/` снимается baseline, после правки — повтор тех же сценариев.
Расхождение хотя бы в одном поле = **NOT READY**, объяснять его дизайном нельзя.

### Что снимать

С каждого сценария: значение поля объёма, положение ползунка, активные пакет
и типы документа, отмеченные чекбоксы, цену за документ, итоги двух секций,
все девять узлов `#calculator-result-*`, заголовок суммы, классы состояния
секции (`calculator--below-min-volume`, `--above-max-volume`, `--no-documents`)
и `data-calculator-json` у CTA.

### Сценарии (18, прогон 2026-10-13)

| Сценарий | Цена за проверку | Год |
|---|---|---|
| default (10 000, DOCUMENT, Passport) | $0.24 | $2,400 |
| объём 25 000 | $0.232 | $5,813 |
| объём 50 000 | $0.22 | $11,000 |
| объём 75 000 | $0.21 | $15,750 |
| объём 100 000 | $0.20 | $20,000 |
| + ID Card + Driver's License | $0.50 | $5,000 |
| + 3 дополнительных документа | $0.63 | $6,300 |
| + международный скрининг | $0.64 | $6,400 |
| пакет LIVENESS | $0.20 | $2,000 |
| пакет BASIC | $0.44 | $4,400 |
| BASIC + всё + 60 000 | $1.326 | $79,560 |
| ниже минимума (5 000) | — | $2,400 |
| выше максимума (150 000) | $*** | ON REQUEST |
| пустое поле объёма | — | $2,400 |
| «−» три раза от default | $0.24 | $2,400 |
| «+» пять раз от default | $0.238 | $3,563 |
| ползунок на 50 | $0.22 | $11,000 |
| ползунок на 100 | $0.20 | $20,000 |

Прогон 2026-10-13: 18/18 совпали с baseline по всем полям.

### Ловушки

- Чекбоксы дополнительных документов лежат в **свёрнутом** спойлере: сначала
  открыть `.calculator__spoiler--additional`, иначе Playwright ловит таймаут
  («section intercepts pointer events»).
- Кликать нужно по `.calculator__checkbox-mark`, а не по самому `input`:
  input скрыт через `opacity: 0` + `pointer-events: none`.
- Переключатель объёма округляет до `step` (1000) — проверять именно
  форматированное значение поля, а не введённое.
- Состояния «ниже минимума» и «выше максимума» прячут `.calculator__result-default`
  целиком: там нужно читать `.calculator__result-request-*`.

### Что ещё проверять на странице

- Один `<h1>`, иерархия заголовков h1 → h2 (остальные h2 — внутри скрытых модалок).
- Нет дублирующихся `id`, у всех `<img>` есть `alt`.
- У шапок спойлеров есть `role`, `aria-expanded`, `aria-controls`, `tabindex`
  (их проставляет `initSpoilers`), у групп кнопок — `role="group"` и `aria-label`,
  у самих кнопок — `aria-pressed`, у ползунка — `aria-label`.
- Модалки `#callForm` (кнопка первого экрана) и `#callForm2` (CTA калькулятора)
  открываются и остаются светлыми.
- Горизонтальный скролл таблицы пакетов ниже 1400 — **часть дизайна**:
  `document.documentElement.scrollWidth` при этом равен `clientWidth`, а ячейки
  выходят за вьюпорт внутри `.packages__table--desktop`. Это не переполнение.
- Ниже 768 вместо таблицы работает Swiper: слайды 2 и 3 стоят за кадром,
  это тоже не переполнение.

---

## 7.9. Страница записи блога: что проверять

- **Документация не должна светлеть.** `/docs/` и любой документ (`single-document.php`)
  делят классы с записью блога. После правок `css/post.css` проверять оба:
  у `.post` на `/docs/` фон остаётся `#212121`, заголовок белый.
- **Цвет врезок.** Абзацы статьи ограничены `.post-text > p`. Если убрать `>`,
  врезки `warning` / `success` / `note` / `disclaimer` потеряют свой цвет
  и станут серыми — проверять по `getComputedStyle` у `.warning__content p`
  (должно быть `rgb(255, 52, 52)`) и `.success__content p` (`rgb(46, 225, 129)`).
- **Сайдбар ниже 1200** уезжает за правый край (`translateX(calc(100% - 24px))`).
  Его элементы попадают в список «за вьюпортом» — это не переполнение:
  `document.documentElement.scrollWidth` равен `clientWidth`.
- **Таблицы** прокручиваются внутри `.wp-block-table` — тоже не переполнение.
- **Обложка.** Если у вложения нет размеров `blog_1x/2x/3x`, `blog_image()`
  возвращает пустую строку и рамка не печатается. Для проверки дизайна брать
  вложение с этими размерами.
- **Форма под статьёй** использует светлые правила формы Contacts через
  `body.single-post .post__form`. Проверять, что подписи, рамки полей, выпадающие
  списки стран и опций, чекбокс согласия и кнопка отправки читаются на светлом.
- **Блоки в редакторе** после правок CSS блоков — прогонять вставку всех 19
  (см. раздел 7.8): editor-стили блоков едут в iframe-канву и могут задеть
  заглушку пустого блока.

---

## 7.10. Header: что проверять

Шапка общая — проверка на каждой странице, где подключён `get_header()`.

1. **Состояния:** Products (со вложенным KYC), Industries, Resources, язык, sticky, закрытая — на
   1920 / 1440 / 840 / 392; сверка со скриншотами Figma (узлы — `DECISIONS.md`, Р-141).
2. **Интерактив:** hover открывает без задержки и без «мёртвой зоны» (курсор от кнопки к панели),
   клик закрепляет, повторный закрывает; Enter / Space / ArrowDown / Escape / ←→; Tab из панели
   закрывает; одновременно открыто одно из четырёх (Products, Industries, Resources, язык).
3. **Mobile:** бургер, аккордеон Products → подэкран продукта → Back (фокус на пункте списка),
   Industries / Resources → Back (фокус на триггере), focus trap, Escape → фокус на бургере,
   скролл страницы заблокирован и позиция возвращается, высоты 844 / 740 / 667 / 640 (CTA достижим).
4. **Resize / поворот:** открытое меню → смена ширины Desktop → Tablet → Mobile и портрет ↔ ландшафт:
   нет `aria-expanded="true"`, нет блокировки body, `data-view="root"`.
5. **Ширины:** 1920, 1600/1599, 1440, 1400/1399, 1366, 1200/1199, 1024, 992/991, 840, 768/767, 576/575,
   478, 420/419, 392, 375, 320 — `scrollWidth === clientWidth`, нет наложений, CTA на месте (≥768).
6. **Ссылки:** `href` не `#`, не пустой, не `javascript:`; существующие = 200; плановые = 404 и
   помечены `'exists' => false`; нет дублей, верхнего регистра, `_`, query.
7. **Язык:** ничего не переводится, URL и `lang` не меняются, нет `hreflang`; `.header-language {display:none}`
   не ломает раскладку.
8. **z-index:** модалка (`#callForm2`) выше шапки; панели и затемнение ниже модалок и выше контента.
9. **Регресс:** Home, Solutions, Pricing, Legal, Docs, Blog, 404 — контент под шапкой не сместился.
10. **Техника:** `php -l`, `node --check js/main.js`, баланс скобок CSS, консоль без ошибок, нет дублей ID.

Playwright-скрипты 2026-10-14 (47 проверок) лежали в scratchpad сессии; логику повторяет этот список.

**Дополнение 2026-10-14 (страница записи):**
- Адаптив проверять **в браузере на 392 и 840**, а не по тексту CSS: в `post.css` была невалидная
  запись `body.single-post @media`, из-за чего нижние ширины молча не работали. Быстрая проверка —
  `grep -nE "^[a-z.#].*@media" css/post.css` не должен находить строк (корректный `@media` стоит в начале строки).
- Каждый блок проверять на **читаемость текста**: глобальный `p` темы светлый, поэтому абзацам внутри
  блоков цвет надо задавать явно (так был потерян текст в `result`).
- Комментарии: открыть записи «Обсуждение», отправить комментарий (форма, модерация, уведомление),
  затем одобрить и убедиться, что список выводится; тест — на временной записи, после — удалить запись.
- Таблицы: подпись над таблицей, пунктирные ячейки, выравнивание `has-text-align-*`.

## 8. Отчёт

После работы:
1. список изменённых файлов;
2. что проверено и чем, что проверить не удалось;
3. запись в `docs/CHANGELOG.md`;
4. новые найденные риски — в `docs/BACKLOG.md` или `docs/THEME-TODO.md`.

Не выдавать непроверенное за подтверждённое.


## Рубрика блога — финальная независимая проверка 2026-10-17

READY TO ACCEPT, приёмка владельцем ожидается. Native Chromium:23viewport/boundaries
320…1920 без overflow/pageerrors,4визуальных эталона, pixel-test видимой рамки фото,
category/search/empty/focus/404 и smoke основных страниц. После финального clipping
fix повторены4widths: лапка видна доY392(1920/1440),Y389(840),Y557(392), как в Figma;
texture обрезана собственной обёрткой, geometry текста/controls прежняя, search
overflow:hidden/cover сохранён. Последние evidence /tmp/nv-category-final/paw.json
и paw-pixels.json; остальные — в итоговом артефакте blog-category/result/index.md.
Живая pagination>12 не проверена (недостаточно записей); это не пройденный тест.


Уточнение по приёмке рубрики: network/play исправлены после замечания владельца —
восстановлена геометрия SVG24×24 из сжатого24×20. Проверены скриншоты1440/392 и PHP lint;
THEME_ASSETS_VER=1.0.92. READY TO ACCEPT, приёмка владельцем ожидается, без commit/deploy.
# 2026-10-17 — финальная проверка страницы автора

READY TO ACCEPT: A-01…A-06 закрыты; final hero retest1920/1440/840/392,
Mobile hero assets не запрашиваются, PHP lint чисто, overflow/pageerrors отсутствуют.
После явного разрешения владельца локально изменён только Yoast disable-author true→false,
остальные title/индексационные опции сохранены. Живые /author/neurovision/ и
/author/kochetkov/ —200 (текущие2/0 записи), неизвестный автор и /author/neurovision/page/5/ —404.
Live Chromium: neurovision1920/392, kochetkov1440, один H1, без warnings/errors/overflow.
Пагинация>9 остаётся непроверенной; job/bio — временная DOM fixture.
Подробности/evidence: артефакт `blog-author/result/index.md`. Приёмка владельцем ещё не получена.
