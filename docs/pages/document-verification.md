# Карта страницы «Document Verification»

> Рабочая память сборщика (регламент — `docs/PAGE_BUILDER.md`). Обновлять после каждого шага:
> после очистки контекста работа продолжается отсюда.

| Поле | Значение |
|---|---|
| ТЗ | `/Users/dmitriy/ZAKAZI/nv.global/ТЗ на новые страницы/ТЗ страница «Document Verification» nv.global.md` (13.10.2026) |
| URL / slug | `/document-verification/` (без родителя) |
| Шаблон | `page-document-verification.php`, Template Name «Document Verification» |
| Семейство | **identity** — отступление от «kyc по умолчанию»: блоки identity (`idv-checks` ×3, `idv-security`) в предпросмотре под семейством kyc рисуются на ТЁМНОМ фоне секции (фон светлой темы задаёт body-класс identity); под identity они светлые. Блоки kyc (Hero `modifier=kyc`, Process-аккордеон, Steps, SEA-табы, Platform, Industries) под identity проверены — вид как на /kyc/ |
| Статус | **готово к приёмке** (2026-10-20) |
| Предпросмотр | `https://nvglobal.local/kyc/?nv_page_preview=page-document-verification.php` |

## Решения сборщика без согласования

Принимаю по опыту AML/KYB (владелец снял остановку на согласование карты):

- **Д-1 Цифры охвата** (16,000+ / 195+ countries and territories / 40+ / $0.24 / $0.13 / $0.44) — как в ТЗ. ТЗ просит сверить («одна цифра для сайта»), в отчёт — как открытый пункт; в тексте не меняю.
- **Д-2 Trust strip** → `kyc-certs` (чипы с галочкой): подпись ТЗ + чипы из цифр блока 10/hero («16,000+ document types», «195+ countries and territories», «90+ languages», «40+ anti-fraud checks»). Сертификаты ISO/GDPR и логотипы клиентов — «после проверки / с согласия» → не ставлю.
- **Д-3 Блок 3 «Documents We Verify»** → Process-аккордеон (5 карточек = 5 H3 ТЗ). Новое фото `docv-process`. Вводный абзац → `solutions-why__lead`; ссылки «→ Full list…», «→ #passports» не выводятся (нет стиля ссылок в тексте).
- **Д-4 Блок 5 «Fraud»** → `idv-checks` (5 карточек), `pill` не выводится.
- **Д-5 Блок 6 «OCR»** → Platform Bento: audit = «Printed and handwritten text» + 3D-иллюстрация, pair = два других H3, экран = HTML-макет «документ-образец → JSON».
- **Д-6 Блок 7 «Passport»** → `idv-checks` (2 карточки: H3 MRZ и Data page vs MRZ). H3 «NFC chip reading» — «только если поддерживается» → отложен.
- **Д-7 Блок 8 «Southeast Asian IDs»** → SEA Map Tabs. Слоты: заголовок = страна; `regulator` → ярлык «Main ID documents»; `id_doc` → ярлык «What we read and check»; текст карточки = предложение ТЗ «Need a check against a national database? Talk to us about your market.» (колонка «Government database check» условная — не показана, как велит ТЗ). Названия документов (NRIC, MyKad, KTP-el, PhilSys…) — как в таблице ТЗ, ТЗ просит подтвердить у команды (в отчёт).
- **Д-8 Блок 9 «Document, Face and Liveness»** → Platform Bento (audit + pair = 3 H3, экран = HTML-макет «Selfie vs document photo»). Ссылки «→ Identity verification / Liveness» не выводятся.
- **Д-9 Блок 10 «Accuracy and Coverage»** → отложен: «99.85%» ТЗ разрешает ставить только с методикой (поле/документ, набор данных, дата), без цифры остальное уже стоит в hero и Trust strip. FAQ «How accurate is your OCR?» тоже отложен.
- **Д-10 Блок 11 «Industries»** → `kyc-industries-section.php` (6 карточек, без `req`).
- **Д-11 Блок 12 «Pricing»** → partial `kyc-pricing-section.php` с аргументами (универсальный блок, зашитых текстов нет; раньше была C-копия; цена ТЗ $0.24 — как на AML/KYB, решение владельца В-1/К-3). Главная карточка: «DOCUMENT package — from $0.24 per check», боковые карточки: Additional documents $0.13 / BASIC from $0.44. Кнопки: Calculate your price → /pricing-matrix/, Start Free Trial → форма. Блок теперь P: partial получил аргументы.
- **Д-12 Блок 13 «Why Choose»** → второй `idv-checks` (6 карточек `h3`, не H4 — как на AML/KYB).
- **Д-13 Блок 14 «Trusted by…»**, **Resources** — отложены (клиенты/кейсы с согласием; нет 2+ опубликованных материалов).
- **Д-14 Блок 15 «API and SDKs»** → Integration (P): 3 слайда = 3 H3 ТЗ, `show_deploy_card=false`, subtitle пустой (в ТЗ нет вводного абзаца). Зашито: `id="integration"`, «Choose Your Integration Path», кнопки.
- **Д-15 Блок 16 «Security»** → `idv-security` целиком, как на AML: предложения ТЗ разложены по карточкам, региональная карта SEA, ISO-знаки, кнопка «Information security policy».
- **Д-16 Блок 17 «Форма»** → Contacts (P) без аргументов (зашиты H2 и поля; `source=document-verification` и GA4 не выполнить). **FAQ** — 8 вопросов из 10: отложены «accurate OCR» (методика), «NFC» (если поддерживается). Хвосты «See the full list →» не выводятся.
- **Д-17 Hero** (`modifier=kyc`, четыре кадра: fhd 1856×872, desktop 1376×732, tablet 776×872, mobile 360×144): фото Magnific «рука с телефоном, снимающим пустую ID-карту» + HTML-карточка с данными документа и тремя плашками («Document authentic ✓ · MRZ ✓ · Not a screen photo ✓», тестовые данные) только на fhd/desktop. Подпись под H1 — подзаголовок ТЗ; кнопки: Try Document Verification Free / See Supported Documents → /docs/products/kyc/recognizable-documents/.

## Блоки

| # ТЗ | Блок ТЗ (H2, якорь) | Блок библиотеки | Способ | Источник | Статус |
|---|---|---|---|---|---|
| 1 | Hero (H1) | Product Hero (KYC), 4 факта | P | `kyc-hero-section.php` | готово |
| 2 | Trust strip | Certifications Chips | P | `certs-section.php` | готово |
| 3 | Documents We Verify `#documents` | Process Accordion, 5 карточек | C | kyc `solutions-why--kyc` | готово |
| 4 | How Online Document Verification Works `#how-it-works` | Steps Slider, 4 шага | P | `kyc-steps-section.php` | готово |
| 5 | Document Fraud Detection `#fraud` | Checks Cards Grid, 5 карточек | P | `idv-checks-section.php` | готово |
| 6 | Document Data Extraction and OCR `#ocr` | Platform Bento | P | `kyc-platform-section.php` | готово |
| 7 | Passport Verification `#passports` | Checks Cards Grid, 2 карточки | P | `idv-checks-section.php` | готово |
| 8 | Southeast Asian ID Documents `#southeast-asia` | SEA Map Tabs | P | `kyc-sea-section.php` | готово |
| 9 | Document, Face and Liveness in One Check | Platform Bento | P | `kyc-platform-section.php` | готово |
| 10 | Accuracy and Coverage | — | — | — | отложен (Д-9) |
| 11 | Industries `#industries` | Industries Cards | P | `kyc-industries-section.php` | готово |
| 12 | Pricing `#pricing` | Pricing Panel | P | `kyc-pricing-section.php` | готово |
| 13 | Why Choose | Checks Cards Grid, 6 карточек | P | `idv-checks-section.php` | готово |
| 14 | Trusted by… | — | — | — | отложен |
| 15 | API and SDKs `#api` | Integration | P | `integration-section.php` | готово |
| 16 | Security and Data Retention | Security Cards + Regional Map | P | `idv-security-section.php` | готово |
| 17 | Try Document Verification Free | Contacts | P | `contacts-section.php` | готово |
| 18 | Document Verification FAQ `#faq` | FAQ, 8 вопросов | P | `faq-section.php` | готово |

## Отложено (условные блоки ТЗ)

- H3 «NFC chip reading», FAQ про NFC — «только если поддерживается».
- Блок 10 «Accuracy and Coverage» + FAQ «How accurate is your OCR?» — цифра 99.85% без методики.
- «…and documents generated by AI» (блок 5, H3 «Edited images and AI-generated fakes») — «только если подтверждено»: текст H3 без AI-хвоста; заголовок H3 остаётся дословно (в ТЗ он с «AI-generated fakes»).
- Колонка «Government database check» (блок 8).
- Блок 14 «Trusted by…», блок 18 «Resources».
- JSON-LD `SoftwareApplication`, `FAQPage` (§7).

## Недостающие картинки / новые

Новые картинки (Magnific / HTML-макет), все вставлены; лист превью — `/private/tmp/claude-501/-Applications-MAMP-htdocs-nvglobal-local-wp-content-themes-nvglobal/780d06ac-a72c-4b8c-8cb3-1a731589b700/scratchpad/docv-preview.png`:

| Блок | Файлы `img/` | Размер 1x | Как сделано |
|---|---|---|---|
| 1 Hero | `docv-hero-fhd` / `-desktop` / `-tablet` / `-mobile` (+`@2x`) | 1856×872 / 1376×732 / 776×872 / 360×144 | фото Magnific (рука с телефоном, дождь, боке) + HTML-образец ID-карты в видоискателе (SPECIMEN) + карточка «Document data» с тестовыми данными (fhd, desktop) |
| 3 Documents | `docv-process` | 1000×1241 | фото Magnific: стол с пустыми паспортом, ID-картами, телефоном; @2x — апскейл из 896×1184 |
| 4 Steps | `docv-step-1…4` | 200×200 | 3D-иконки Magnific, фон удалён |
| 6 OCR | `docv-ocr-audit`, `docv-ocr-screen` | 255×255, 644×452 | иконка Magnific + HTML-макет «образец → JSON» |
| 9 Combo | `docv-face-audit`, `docv-face-screen` | 255×255, 644×452 | иконка Magnific + HTML-макет «Selfie vs document photo» |

Попытки Magnific: hero — 2 (первая — телефон лежал горизонтально и занимал середину), фото процесса — 2 (первая не дождалась ответа за 300 с), остальные — 1.

## Мета для Yoast (из ТЗ)

| Поле | Значение |
|---|---|
| SEO title | Document Verification Software & API \| NeuroVision (запасной: ID Document Verification & Fraud Detection \| NeuroVision) |
| Meta description | Online document verification: read passports, ID cards and driver’s licenses, extract data with OCR and catch fakes with 40+ anti-fraud checks. One API. |
| og:title | NeuroVision Document Verification: Read Any ID, Catch Every Fake |
| og:description | 16,000+ document types from 195+ countries and territories, including Southeast Asian IDs. OCR, MRZ and 40+ anti-fraud checks. From $0.24 per check. |
| og:image | 1200×630 — макет описан в ТЗ, файла нет |
| canonical | https://nv.global/document-verification/ |
| Хлебные крошки | Home → Solutions → Document Verification |
| Родитель страницы | нет |

## Открыто после сборки

- [ ] **Цифры** 16,000+ / 40+ / $0.24 / $0.13 / $0.44 / 90+ — как в ТЗ; ТЗ просит сверить (на сайте 16,000+ vs 13,000+ vs 10,000+, 195+ vs 240).
- [ ] **Названия ASEAN-документов** (NRIC, FIN, MyKad, KTP-el, PhilSys, UMID, CCCD, Thai ID) — как в таблице ТЗ, ТЗ просит подтвердить у команды.
- [ ] **Ссылки в тексте** («→ Full list of supported documents», «→ Identity verification», «→ Liveness», хвосты FAQ «See the full list →», «See our pricing page →») не выведены — нет стиля ссылок в карточках/FAQ-partial, часть страниц — план.
- [ ] **Якоря** `#fraud`, `#ocr`... выставлены только там, где блок принимает id (`#documents`, `#how-it-works`, `#fraud`, `#passports`, `#southeast-asia`, `#pricing`, `#why-choose`); `#ocr`, `#industries`, `#api` — нет (partial без `id`; у Integration зашит `#integration`).
- [ ] **Hero:** `fetchpriority="high"` стоит на `<img>` последнего источника; `Lottie/WebM` анимация ТЗ не делается (нужен дизайнер/аниматор) — статичный кадр.
- [ ] **Process-аккордеон:** фото @2x — апскейл (источник 896×1184); при желании перегенерировать в 2k.
- [ ] JSON-LD `SoftwareApplication`, `FAQPage` — не добавлены (§7).

## Замена hero (2026-10-20, замечание владельца: тёмный ночной hero выбивается из сайта)

Hero пересобран в светлом дневном стиле, как AML/KYB: вариант Identity (`modifier=identity`, рецепт AML из §6), три кадра — `docv-hero` (1600×1056, ≥992: фото Magnific + HTML-карточка с текстами ТЗ), `docv-hero-tablet` (768–991.98, фото без карточки) и `docv-hero-mobile` (720×536, без карточки) + `@2x`. Прежние `docv-hero-fhd`/`-desktop` удалены. Иконки фактов — `nv_identity_icon`. Попыток Magnific на страницу — 2 (первая: человек слева/по центру или без запаса над головой; вторая — удачная). Остальное на странице не менялось.

## Правки по замечаниям владельца (2026-10-20, п. 1, 4, 6 и 7)

- **Industries:** переведён на вариант `idv-industries` с тегами (фразы ТЗ каждой отрасли), 6 карточек.
- **Hero-кнопки на мобильных:** `mobile_text` — «Try Free» / «See Documents».
- **Platform Bento (OCR и «One check»):** по четыре карточки слева как в библиотеке (верхняя «no-code + note», audit с картинкой, пара); фразы ТЗ блоков 6 и 9 разложены без изменения слов.
- **Audit-иконки** `docv-ocr-audit`, `docv-face-audit` пересобраны: иконка уменьшена и уведена в правый нижний угол холста с полями справа и снизу (чтобы не пересекала текст и не обрезалась на мобильных, где картинка выступает за край карточки на ≈33×50 px).

## Audit-иконка без полей (2026-10-21, блок Platform переведён на картинку в потоке)

`docv-ocr-audit`, `docv-face-audit` (+`@2x`): убраны прозрачные поля (были нужны при абсолютной картинке, теперь делали иконку крошечной). Видимая часть обрезана по альфе и вписана в 215×247 из 255 (@2x 430×495 из 510), прижата вниз-вправо (поле справа ≈9%, снизу ≈2%), как у `identity-platform-accent`. Размеры файлов и `width`/`height` в шаблоне прежние. Исходники — scratchpad, чистые альфа-PNG 1024. Замер 14 ширин (1920…320): пересечений с текстом 0, обрезки 0. Реестр: О-13, О-30.

## Журнал

- 2026-10-20 — прочитаны регламент, ТЗ, образец /kyc/; составлена карта и решения Д-1…Д-17. Начинаю картинки и сборку.
- 2026-10-20 — картинки сгенерированы и вставлены; собран `page-document-verification.php` (блоки 1–9, 11–13, 15–18); семейство переведено с kyc на identity (идентити-блоки под kyc тёмные); QA §12 на 6 ширинах пройдено. Статус — готово к приёмке.
- 2026-10-20 — hero заменён на светлый дневной (см. раздел «Замена hero»).
- 2026-10-20 — правки по семи замечаниям владельца (см. раздел «Правки по замечаниям владельца»).
