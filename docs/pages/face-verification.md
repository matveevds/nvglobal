# Карта страницы «Face Verification»

> Рабочая память сборщика (регламент — `docs/PAGE_BUILDER.md`). Обновлять после каждого шага:
> после очистки контекста работа продолжается отсюда.

| Поле | Значение |
|---|---|
| ТЗ | `/Users/dmitriy/ZAKAZI/nv.global/ТЗ на новые страницы/ТЗ страница «Face Verification» nv.global.md` (13.10.2026) |
| URL / slug | `/face-verification/` (без родителя) |
| Шаблон | `page-face-verification.php`, Template Name «Face Verification» |
| Семейство | **identity** — как на Document Verification: идентити-блоки (`idv-checks` ×3, `idv-benefits`, `idv-security`) под kyc рисуются на тёмном фоне, под identity светлые; блоки kyc (Hero kyc, Steps, Platform, SEA, Industries, Certs-чипы) под identity проверены |
| Статус | **готово к приёмке** (2026-10-20) |
| Предпросмотр | `https://nvglobal.local/kyc/?nv_page_preview=page-face-verification.php` |

## Решения сборщика без согласования

- **Ф-1 Hero** (`modifier=kyc`, 4 кадра): факты — 3 из 4: «[0.1 s] per comparison» в ТЗ в скобках (нужно подтвердить) — не ставлю. «99.74% face match accuracy in NIST testing» — текст факта ТЗ; расшифровка NIST (трек/набор/метрика/дата) от команды — в открытых.
- **Ф-2 Trust** → `kyc-certs`: подпись ТЗ + чипы из слов заголовков блока 13. Бейдж «NIST FRTE», ISO/GDPR, логотипы — «после подтверждения/согласия» → нет.
- **Ф-3 Блок 3 «What Face Verification Does»** → `idv-checks` (4 карточки + вводный абзац).
- **Ф-4 Блок 5 «Accuracy»** → Platform Bento: audit = «What the NIST result means», pair = «Reliable with glasses…» + карточка «NIST FRTE» (слова ячеек таблицы ТЗ: «Face match accuracy: 99.74%. Global ranking: Top-24.»), экран — HTML-макет. H3 «Tested on Asian faces» — «только при данных» → отложен; плейсхолдеры таблицы [трек]/[дата]/[FNMR] не выводятся.
- **Ф-5 Блок 6 «One Person, One Account»** → `idv-benefits` (3 карточки + promo = вводный абзац по предложениям). Промо-картинка — существующий маскот с лупой (подходит по смыслу, §6).
- **Ф-6 Блок 7 «Face Verification Plus Liveness»** (в ТЗ один абзац) → Platform Bento: абзац разложен по трём предложениям на три карточки, заголовки собраны из слов (Face match / Liveness detection / Same step) — по §4 п.5, не одна карточка.
- **Ф-7 Блок 8 «Beyond Matching»** → `idv-checks` (4 карточки).
- **Ф-8 Блок 9 «API»** → Integration (P) с 3 слайдами ТЗ; зашито: `id="integration"`, «Choose Your Integration Path», кнопки (View documentation → /docs/). Пример JSON ТЗ («поля — от команды») не выводится.
- **Ф-9 Блок 10 «Southeast Asia»** → SEA Map Tabs: «When a face match is expected» / «Matched against» — слоты ярлыков; текст карточки пуст (в ТЗ нет). Порядок вкладок: Singapore первой (разметка блока рассчитана на неё), содержимое — по таблице ТЗ. Названия госбаз — как в таблице ТЗ (это описание требования, не обещание интеграции).
- **Ф-10 Блок 11 «Industries»** → `kyc-industries-section.php` (6 карточек, без req).
- **Ф-11 Блок 12 «Pricing»** → partial `kyc-pricing-section.php` с аргументами (универсальный блок, зашитых текстов нет; раньше была C-копия; цена ТЗ $0.44, как на Document/AML/KYB): основная карточка «BASIC package — from $0.44 per check»; боковые: «Face matching included» и «Face API pricing» (кнопка Talk to Sales). Цены отдельного Face API нет — без цифр.
- **Ф-12 Блок 13 «Why Choose»** → второй/третий `idv-checks`, 6 карточек `h3`.
- **Ф-13 Блок 15 «Biometric Data Privacy»** → `idv-security` (две карточки ТЗ + региональная карта), без ISO-знаков (сертификатов в блоке нет). H3 «Templates, not photos» — «по ответу DPO» → отложен. Текст «keeps templates and personal data» оставлен как в ТЗ — формулировка DPO-зависима (открытый пункт).
- **Ф-14 FAQ** — 8 вопросов из 10: отложены «Does it work with glasses, beards or masks?» (ответ «по подтверждённым данным») и «Do you store face images?» (ответ от DPO). Хвосты «See Liveness →» не выводятся.
- **Ф-15** Блок 14 «Trusted by…», блок 17 «Resources» — отложены. Ссылки «→ …» не выводятся (нет стиля ссылок). Блок «Face recognition API» заголовок — дословно.

## Блоки

| # ТЗ | Блок ТЗ (H2, якорь) | Блок библиотеки | Способ | Источник | Статус |
|---|---|---|---|---|---|
| 1 | Hero (H1) | Product Hero (KYC), 3 факта | P | `kyc-hero-section.php` | готово |
| 2 | Trust strip | Certifications Chips | P | `certs-section.php` | готово |
| 3 | What Face Verification Does `#what` | Checks Cards Grid, 4 карточки | P | `idv-checks-section.php` | готово |
| 4 | How Face Matching Works `#how-it-works` | Steps Slider, 4 шага | P | `kyc-steps-section.php` | готово |
| 5 | Accuracy You Can Check | Platform Bento | P | `kyc-platform-section.php` | готово |
| 6 | One Person, One Account `#duplicates` | Benefits Cards + Promo | P | `idv-benefits-section.php` | готово |
| 7 | Face Verification Plus Liveness | Platform Bento | P | `kyc-platform-section.php` | готово |
| 8 | Face Checks Beyond Matching `#beyond` | Checks Cards Grid, 4 карточки | P | `idv-checks-section.php` | готово |
| 9 | Face Recognition API | Integration | P | `integration-section.php` | готово |
| 10 | Face Verification in Southeast Asia `#southeast-asia` | SEA Map Tabs | P | `kyc-sea-section.php` | готово |
| 11 | Industries | Industries Cards | P | `kyc-industries-section.php` | готово |
| 12 | Pricing `#pricing` | Pricing Panel | P | `kyc-pricing-section.php` | готово |
| 13 | Why Choose | Checks Cards Grid, 6 карточек | P | `idv-checks-section.php` | готово |
| 14 | Trusted by… | — | — | — | отложен |
| 15 | Biometric Data Privacy | Security Cards + Regional Map | P | `idv-security-section.php` | готово |
| 16 | Try Face Verification Free | Contacts | P | `contacts-section.php` | готово |
| 17 | Resources | — | — | — | отложен |
| 18 | Face Verification FAQ `#faq` | FAQ, 8 вопросов | P | `faq-section.php` | готово |

## Отложено (условные блоки ТЗ)

- «[0.1 s] per comparison»; H3 «Tested on Asian faces»; H3 «Templates, not photos»; FAQ «masks» и «store face images»; трек/набор/метрика/дата NIST; блок 14; Resources; пример JSON блока 9; JSON-LD `SoftwareApplication`, `FAQPage`.

## Новые картинки

Лист превью: `/private/tmp/claude-501/-Applications-MAMP-htdocs-nvglobal-local-wp-content-themes-nvglobal/780d06ac-a72c-4b8c-8cb3-1a731589b700/scratchpad/fv-preview.png`

| Блок | Файлы `img/` | Размер 1x | Как сделано |
|---|---|---|---|
| 1 Hero | `fv-hero-fhd` / `-desktop` / `-tablet` / `-mobile` (+`@2x`) | 1856×872 / 1376×732 / 776×872 / 360×144 | фото Magnific (рука с телефоном, бирюзовое боке) + HTML-овал на экране телефона + HTML-карточка «Face match» (Match 99.8% ✓, 5 мини-лиц, «Already registered as user #TEST-213»; силуэты вместо лиц); карточка — только fhd и desktop |
| 4 Steps | `fv-step-1…4` | 200×200 | 3D-иконки Magnific, фон удалён |
| 5 Accuracy | `fv-accuracy-audit`, `fv-acc-screen` | 255×255, 644×452 | иконка Magnific (кубок) + HTML-макет «99.74% / Top-24 / NIST FRTE» |
| 7 Liveness | `fv-live-audit`, `fv-live-screen` | 255×255, 644×452 | иконка Magnific + HTML-макет «face match + liveness → Approved» |

Все попытки Magnific — по одной на картинку (hero, 4 иконки шагов, 2 иконки карточек).

## Открыто после сборки

- [ ] NIST: трек, набор данных, FNMR при каком FMR, дата, ссылка на отчёт; «Top-24» — ТЗ ставит эти формулировки только с расшифровкой (в карте сохранены как в ТЗ).
- [ ] Время сравнения (0.1 s?), скорость 1:N; шаблоны/векторы — формулировки от DPO («templates» в блоке 15 и «a face template is built» в шаге 2).
- [ ] Работает ли сравнение в маске (блок 5, H3 «Reliable with glasses, beards, masks and low light» — текст ТЗ, подтвердить).
- [ ] Ссылки в тексте («→ Document verification», «→ Liveness», «→ /neuropay/», хвосты FAQ) не выведены: нет стиля ссылок; часть страниц — план.
- [ ] Якоря: выставлены `#what`, `#how-it-works`, `#duplicates`, `#beyond`, `#southeast-asia`, `#pricing`, `#why-choose`, `#faq`; `#accuracy`, `#liveness`, `#api`, `#industries`, `#privacy` — нет (у partial нет `id`; у Integration зашит `#integration`).
- [ ] Hero: анимация Lottie/WebM из ТЗ не делается — статичный кадр. Лица заменены силуэтами (ТЗ требует лица со стока с лицензией/согласием).
- [ ] JSON-LD (§7).

## Мета для Yoast (из ТЗ)

| Поле | Значение |
|---|---|
| SEO title | Face Verification & Face Matching API \| NeuroVision (запасной: Face Verification Software: 1:1 and 1:N \| NeuroVision) |
| Meta description | Face verification and face matching with 99.74% NIST-tested accuracy: selfie-to-ID checks, 1:N search for duplicate accounts and a face recognition API. |
| og:title | NeuroVision Face Verification: Is This the Same Person? |
| og:description | Selfie vs ID photo, returning customers and 1:N duplicate search — one face engine with 99.74% accuracy in NIST testing, plus liveness. |
| og:image | 1200×630 (макет в ТЗ), файла нет |
| canonical | https://nv.global/face-verification/ |
| Хлебные крошки | Home → Solutions → Face Verification |
| Родитель страницы | нет |

## Замена hero (2026-10-20, замечание владельца: тёмный ночной hero выбивается из сайта)

Hero пересобран в светлом дневном стиле, как AML/KYB: вариант Identity (`modifier=identity`, рецепт AML из §6), три кадра — `fv-hero` (1600×1056, ≥992: фото Magnific + HTML-карточка с текстами ТЗ), `fv-hero-tablet` (768–991.98, фото без карточки) и `fv-hero-mobile` (720×536, без карточки) + `@2x`. Прежние `fv-hero-fhd`/`-desktop` удалены. Иконки фактов — `nv_identity_icon`. Попыток Magnific на страницу — 2 (первая: человек слева/по центру или без запаса над головой; вторая — удачная). Остальное на странице не менялось.
В карточке hero убрано число «Match 99.8%» (в ТЗ как цифра нет, спутают с 99.74%): оставлено «Match ✓» (иконка и слово «Match»).

## Правки по замечаниям владельца (2026-10-20, п. 1, 5, 6 и 7)

- **Industries:** вариант `idv-industries` с тегами (фразы ТЗ), 6 карточек.
- **Hero — снова modifier `kyc`** с кадрами fhd 1856×872 / desktop 1376×732 / tablet 776×872 / mobile 360×144, нарезанными из светлого фото; на fhd и desktop — тёмный градиент слева (на /kyc/ тень вшита в фото) и HTML-карточка «Face match». Плашек фактов четыре (добавлена «Our own face engine» — H4 блока 13 ТЗ): размеры совпали с /kyc/ — 280×190 при шрифте 24px на 1920 и 180×155 / 18px на 1440. Карточка перенесена выше телефона (не закрывает телефон и руку). CSS не менялся.
- **`fv-accuracy-audit`** (и аналогично `fv-live-audit`): иконка уменьшена и уведена в правый нижний угол холста 255×255 (размер файла и width/height те же): правое поле 50, нижнее 72 px — не пересекает текст на 1920/1440/1100/840/740/392 и не обрезается на мобильных.
- **Platform Bento (Accuracy и Liveness):** по четыре карточки слева; слова ТЗ блоков 5 и 7 разложены (в Accuracy — ещё ячейки таблицы ТЗ: «Face match accuracy 99.74%», «Global ranking Top-24», «NIST FRTE»).

## Audit-иконка без полей (2026-10-21, блок Platform переведён на картинку в потоке)

`fv-accuracy-audit`, `fv-live-audit` (+`@2x`): убраны прозрачные поля (были нужны при абсолютной картинке, теперь делали иконку крошечной). Видимая часть обрезана по альфе и вписана в 215×247 из 255 (@2x 430×495 из 510), прижата вниз-вправо (поле справа ≈9%, снизу ≈2%), как у `identity-platform-accent`. Размеры файлов и `width`/`height` в шаблоне прежние. Исходники — scratchpad, чистые альфа-PNG 1024. Замер 14 ширин (1920…320): пересечений с текстом 0, обрезки 0. Реестр: О-13, О-30.

## Журнал

- 2026-10-20 — прочитано ТЗ, принято решения Ф-1…Ф-15; сгенерированы картинки; собран `page-face-verification.php`; QA §12 на 6 ширинах пройдено. Статус — готово к приёмке.
- 2026-10-20 — hero заменён на светлый дневной (см. раздел «Замена hero»).
- 2026-10-20 — правки по семи замечаниям владельца (см. раздел «Правки по замечаниям владельца»).
