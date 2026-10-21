# Карта страницы «Liveness Detection»

> Рабочая память сборщика (регламент — `docs/PAGE_BUILDER.md`). Обновлять после каждого шага:
> после очистки контекста работа продолжается отсюда.

| Поле | Значение |
|---|---|
| ТЗ | `/Users/dmitriy/ZAKAZI/nv.global/ТЗ на новые страницы/ТЗ страница «Liveness Detection» nv.global.md` (13.10.2026) |
| URL / slug | `/liveness/` (без родителя) → `page-liveness.php` |
| Шаблон | `page-liveness.php`, Template Name «Liveness Detection» |
| Семейство | **identity** — как на Document/Face: `idv-checks` и `idv-security` под kyc рисуются тёмными. Блоки kyc (Hero, Steps, Risk Tabs, SEA, Industries, Certs-чипы) под identity проверены |
| Статус | **готово к приёмке** (2026-10-20) |
| Предпросмотр | `https://nvglobal.local/kyc/?nv_page_preview=page-liveness.php` |

## Решения сборщика без согласования

- **Л-1 Hero** (`modifier=kyc`, 4 кадра): плашка «[N] s per check» заменена на «Built into KYC» (так велит ТЗ, пока нет замера). Под кнопками «Free trial · Part of your KYC flow · One API» в partial не помещается. Анимация Lottie/WebM — статичный кадр: два овала («Move closer»), плашка «Live person ✓», карточка «Attacks blocked» (Printed photo ✗ · Screen replay ✗ · Mask ✗ · Live person ✓) — тексты ТЗ.
- **Л-2 H1** — основной вариант ТЗ («…Photos, Masks and Deepfakes»). ТЗ допускает запасной «…Photos, Videos and Masks», если блок 6 (дипфейки/инъекции) не подтверждён; блок 6 отложен, но подзаголовок hero и H3 «Deepfake videos» (блок 3) в ТЗ не помечены условными и о дипфейках говорят, поэтому H1 оставлен основным. **Открытый пункт для владельца/команды.**
- **Л-3 Trust** → `kyc-certs`: подпись ТЗ + чипы из слов фактов hero. Бейдж iBeta/ISO 30107-3 (только при письмах), ISO/GDPR, логотипы — нет.
- **Л-4 Блок 3 «Attacks»** → `idv-checks` (3 карточки + вводный абзац); ссылка «→ Deepfake and injection…» не выводится.
- **Л-5 Блок 5 «Active and Passive»** → Risk Tabs (partial `kyc-risk-section.php`): две вкладки = два режима; третий H3 «Which mode to choose» — боковая карточка. Таблицу ТЗ разложил по панелям: «When» → «Best for» (Banking, high-risk checks / Mass-market onboarding), «Checks» → «What the user does» (Moves closer to the camera / Takes one selfie). Строка «Time for the user» (значения «[ ] s» не заданы) — не выводится. Ссылка на статью блога (план) — нет. Passive-режим в ТЗ «подтвердить» (в документации указан) — оставлен, в открытых.
- **Л-6 Блок 6 «Deepfake and Injection Attack Detection»** — «только если подтверждено» → отложен, FAQ «Can liveness detection stop deepfakes?» — тоже.
- **Л-7 Блок 7 «Liveness Detection for KYC, Login and Payments»** — login/transfers «только при повторной проверке клиента» (от ответа зависят два из трёх H3, остаётся один) → отложен целиком.
- **Л-8 Блок 8 «Presentation Attack Detection You Can Check»** — H3 «Independent testing» (только при документах), таблица APCER/BPCER (значений нет), «Works for every user» (только при разбивке) → от блока остаётся одна фраза; одна карточка недопустима (§4 п.5), блок с заголовком «You Can Check» без проверяемого — вводит в заблуждение → отложен.
- **Л-9 Блок 9 «Southeast Asia»** → SEA Map Tabs: слоты — страна · «Rule» · «Where liveness matters»; текст карточки пуст (в ТЗ нет). Singapore — первой (разметка блока рассчитана на неё), содержимое — по таблице ТЗ. Строки с порогами (VND 10 million, THB 50,000) — как в ТЗ, юрист сверяет.
- **Л-10 Блок 10 «Industries»** → `kyc-industries-section.php`, 4 карточки: «Gig and sharing platforms» — «только при поддержке повторной аутентификации» → отложена.
- **Л-11 Блок 11 «Pricing»** → partial `kyc-pricing-section.php` с аргументами (универсальный блок, зашитых текстов нет; раньше была C-копия; цена ТЗ $0.44, как на Document/Face/AML/KYB): основная карточка «BASIC and ADVANCED KYC packages — from $0.44 per check», боковые «Liveness included» и «Standalone pricing» (кнопка Talk to Sales). Цены standalone liveness нет — без цифр.
- **Л-12 Блок 12 «Why Choose»** → второй `idv-checks`, 6 карточек `h3` (3×2): «Works on everyday phones» добавлена 2026-10-21 по просьбе владельца — заголовок ТЗ, текст сокращён до «Runs in the mobile browser, with no app to install.» (часть ТЗ «on mid-range and older phones» — после теста на устройствах); карточка о хранении — как в ТЗ (формулировка DPO-зависима).
- **Л-13 Блок 13 «API and SDK»** → Integration (P), 3 слайда ТЗ; «Mobile apps» — без скобки «[подтвердить наличие]» (нативные SDK не заявляются); пример ответа «от команды» не выводится. Зашито: `id="integration"`, «Choose Your Integration Path», кнопка «View documentation» → /docs/.
- **Л-14 Блок 14 «Security»** → `idv-security` целиком, как на AML: предложения ТЗ разложены по двум карточкам, ISO-знаки, кнопка «Information security policy», региональная карта. Сертификат — «после проверки» (как на AML).
- **Л-15 FAQ** — 5 вопросов из 10; отложены: deepfakes (блок 6), certified (нет документов iBeta), «How long…» ([N] s), «low-end phones» (тест), «store face images» (DPO). Хвост «Read our guide →» не выводится.
- **Л-16** Блок 16 «Resources» — отложен. Ссылки «→ …» не выводятся (нет стиля ссылок). iBeta — нигде не упомянут (так велит ТЗ без писем).

## Блоки

| # ТЗ | Блок ТЗ (H2, якорь) | Блок библиотеки | Способ | Источник | Статус |
|---|---|---|---|---|---|
| 1 | Hero (H1) | Product Hero (KYC), 4 факта | P | `kyc-hero-section.php` | готово |
| 2 | Trust strip | Certifications Chips | P | `certs-section.php` | готово |
| 3 | Presentation Attacks `#attacks` | Checks Cards Grid, 3 карточки | P | `idv-checks-section.php` | готово |
| 4 | How Face Liveness Detection Works `#how-it-works` | Steps Slider, 4 шага | P | `kyc-steps-section.php` | готово |
| 5 | Active and Passive Liveness `#modes` | Risk Tabs | P | `kyc-risk-section.php` | готово, предпросмотр ок |
| 6 | Deepfake and Injection Attack Detection | — | — | — | отложен |
| 7 | Liveness for KYC, Login and Payments | — | — | — | отложен |
| 8 | Presentation Attack Detection You Can Check | — | — | — | отложен |
| 9 | Liveness Rules in Southeast Asia `#southeast-asia` | SEA Map Tabs | P | `kyc-sea-section.php` | готово |
| 10 | Industries | Industries Cards, 4 карточки | P | `kyc-industries-section.php` | готово |
| 11 | Pricing `#pricing` | Pricing Panel | P | `kyc-pricing-section.php` | готово |
| 12 | Why Choose | Checks Cards Grid, 6 карточек | P | `idv-checks-section.php` | готово |
| 13 | API and SDK | Integration | P | `integration-section.php` | готово |
| 14 | Security and Biometric Data Protection | Security Cards + Regional Map | P | `idv-security-section.php` | готово |
| 15 | Try Liveness Detection Free | Contacts | P | `contacts-section.php` | готово |
| 16 | Resources, FAQ `#faq` | FAQ, 5 вопросов | P | `faq-section.php` | готово |

## Отложено (условные блоки ТЗ)

Блоки 6, 7, 8; карточка «Gig and sharing platforms»; «Works on everyday phones»; плашка «[N] s»; строка «Time for the user»; бейдж iBeta; 5 вопросов FAQ; блок «Resources»; пример ответа API; JSON-LD `SoftwareApplication`, `FAQPage`.

## Новые картинки

Лист превью: `/private/tmp/claude-501/-Applications-MAMP-htdocs-nvglobal-local-wp-content-themes-nvglobal/780d06ac-a72c-4b8c-8cb3-1a731589b700/scratchpad/lv-preview.png`

| Блок | Файлы `img/` | Размер 1x | Как сделано |
|---|---|---|---|
| 1 Hero | `lv-hero-fhd` / `-desktop` / `-tablet` / `-mobile` (+`@2x`) | 1856×872 / 1376×732 / 776×872 / 360×144 | фото Magnific (рука с телефоном, фиолетово-малиновое боке) + HTML: два овала на экране, «Move closer», «Live person ✓»; карточка «Attacks blocked» — только fhd и desktop; силуэт вместо лица |
| 4 Steps | `lv-step-1…4` | 200×200 | 3D-иконки Magnific, фон удалён |
| 5 Modes | `lv-modes` | 245×233 | 3D-иконка Magnific (два переключателя), фон удалён |

Попытки Magnific: по одной на каждую картинку.

## Открыто после сборки

- [ ] **H1 с «Deepfakes»** при отложенном блоке 6 (Л-2): оставить, либо запасной «Face Liveness Detection That Stops Photos, Videos and Masks» (тогда подзаголовок hero и H3 «Deepfake videos» тоже править по ТЗ).
- [ ] iBeta: письма-подтверждения (уровни, дата, версия SDK); «Level 1-2» (главная) vs «Level 1–3» (/pricing-matrix/). На странице iBeta не упоминается.
- [ ] Passive liveness — подтвердить (на /pricing-matrix/ описан только активный сценарий); время проверки в обоих режимах; «eye movement analysis».
- [ ] Дипфейки/инъекции — что ловит модель; APCER/BPCER; разбивка по группам; повторная проверка клиента (login, переводы); liveness отдельно от документа и его цена; нативные SDK; хранение «Face Crop … unlimited» — формулировка DPO.
- [ ] Ссылки в тексте («→ Face verification», «→ KYC verification», «→ Biometric authentication», «Read our guide →») не выведены: нет стиля ссылок; часть страниц — план.
- [ ] Якоря: выставлены `#attacks`, `#how-it-works`, `#southeast-asia`, `#pricing`, `#why-choose`, `#faq`; `#modes`, `#industries`, `#api` — нет (partial без `id`; у Integration зашит `#integration`).
- [ ] Hero: Lottie/WebM из ТЗ не делается; лица заменены силуэтами (ТЗ требует сток с лицензией/согласие модели).
- [ ] JSON-LD (§7).

## Мета для Yoast (из ТЗ)

| Поле | Значение |
|---|---|
| SEO title | Liveness Detection Software & API \| NeuroVision (запасной: Face Liveness Detection: Stop Spoofs and Deepfakes \| NeuroVision) |
| Meta description | Liveness detection software that confirms a real person is on camera. Blocks photos, screen replays, masks and deepfakes. Active and passive modes, one API. |
| og:title | NeuroVision Liveness Detection: Prove a Real Person Is on Camera |
| og:description | Stop printed photos, video replays, silicone masks and deepfakes at onboarding. Active and passive liveness, Web SDK and REST API. |
| og:image | 1200×630 (макет в ТЗ), файла нет |
| canonical | https://nv.global/liveness/ |
| Хлебные крошки | Home → Products → Liveness Detection |
| Родитель страницы | нет |

## Замена hero (2026-10-20, замечание владельца: тёмный ночной hero выбивается из сайта)

Hero пересобран в светлом дневном стиле, как AML/KYB: вариант Identity (`modifier=identity`, рецепт AML из §6), три кадра — `lv-hero` (1600×1056, ≥992: фото Magnific + HTML-карточка с текстами ТЗ), `lv-hero-tablet` (768–991.98, фото без карточки) и `lv-hero-mobile` (720×536, без карточки) + `@2x`. Прежние `lv-hero-fhd`/`-desktop` удалены. Иконки фактов — `nv_identity_icon`. Попыток Magnific на страницу — 2 (первая: человек слева/по центру или без запаса над головой; вторая — удачная). Остальное на странице не менялось.
Вместо экрана телефона в hero — оранжевый овал вокруг лица, подсказка «Move closer», плашка «Live person ✓» и карточка «Attacks blocked» (тексты ТЗ).

## Правки по замечаниям владельца (2026-10-20, п. 1–4)

- **Industries:** вариант `idv-industries` с тегами (фразы ТЗ), 4 карточки.
- **Attacks (блок 3):** 4-я карточка — второе предложение вводного абзаца ТЗ выделено в карточку «Simple printouts to professional masks» («Our biometric liveness detection is trained on attacks from simple printouts to professional masks.»); во вводном абзаце осталось первое предложение; сетка 2×2. H3 «Deepfake videos» оставлен (не условный).
- **`lv-modes`** перегенерирован (Magnific, 1 попытка, `--remove-bg`, 245×233 + @2x): два телефона — слева лицо с кольцом-движением (active), справа лицо с галочкой (passive).
- **Hero-кнопки на мобильных:** `mobile_text` — «Try Free» / «How It Works».

## Журнал

- 2026-10-20 — прочитано ТЗ, принято решения Л-1…Л-16; сгенерированы картинки; собран `page-liveness.php`; QA §12 на 6 ширинах пройдено. Статус — готово к приёмке.
- 2026-10-20 — hero заменён на светлый дневной (см. раздел «Замена hero»).
- 2026-10-20 — правки по семи замечаниям владельца (см. раздел «Правки по замечаниям владельца»).
