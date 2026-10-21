# Карта страницы «KYB»

> Рабочая память сборщика (регламент — `docs/PAGE_BUILDER.md`). Обновлять после каждого шага:
> после очистки контекста работа продолжается отсюда.

| Поле | Значение |
|---|---|
| ТЗ | `/Users/dmitriy/ZAKAZI/nv.global/ТЗ на новые страницы/ТЗ страница «KYB» nv.global.md` (13.10.2026) |
| URL / slug | `/kyb/` (без родителя) |
| Шаблон | `page-kyb.php`, Template Name «KYB Verification» |
| Семейство | **identity** — как AML: Hero (Identity), Checks ×2, Platform (Identity), Industries (Identity), Security; из KYC — SEA Map Tabs (в семействе identity проверен на AML) |
| Объём | **вариант А** (KYB из существующих модулей). Блоки и фразы «вариант Б» не ставятся. ТЗ: страницу **не публиковать**, пока продуктовая команда не подтвердит, что KYB есть в продукте; собирать параллельно — можно |
| Статус | **готово к приёмке** (2026-10-20); публикация — только после подтверждения KYB командой |
| Предпросмотр | `https://nvglobal.local/kyc/?nv_page_preview=page-kyb.php` |

## Правила, перенесённые с AML (решения владельца 2026-10-20)

- Элементы блока без текста в ТЗ не выводятся (AML В-5): бейджи, subtitle, lead, note, promo.
- Карточки «Why Choose» — `h3`, а не H4 (AML В-6).
- Зашитое в partial принимается как есть (AML В-8): H2 формы, кнопки Integration, якоря.
- Ссылки на неопубликованные страницы не ставятся (AML В-10). Ссылки на опубликованные (/kyc/, /aml/, /docs/) внутри текста карточек — тоже нет: у `.kyc-card__text` нет стиля ссылок (открытый пункт AML).
- Бейджи — из подписей `page-nav` ТЗ: Checks · How it works · UBO · Southeast Asia · Industries · Pricing · API · FAQ.

## Блоки

| # ТЗ | Блок ТЗ (H2, якорь) | Блок библиотеки | Способ | Источник | Статус |
|---|---|---|---|---|---|
| 1 | Hero (H1) | Product Hero (Identity): 3 факта, Start KYB Verification (форма) / See How It Works (`#how-it-works`) | P | `kyc-hero-section.php` | готово |
| 2 | Trust strip | `idv-certs`: только подпись ТЗ, без знаков и токенов | P | `certs-section.php` | готово, **см. «Открыто»** |
| 3 | What Our KYB Verification Checks `#checks` | Checks: интро + 4 карточки h3 | P | `idv-checks-section.php` | готово |
| 4 | How Business Verification Works `#how-it-works` | Steps (Identity), 4 шага, `kyb-step`, lead/note пустые | P | `kyc-steps-section.php` | готово |
| 5 | Business Onboarding… | — | — | — | отложен (К-1) |
| 6 | UBO Verification | Platform (Identity): audit + pair, свой экран `kyb-ubo-screen` | P | `kyc-platform-section.php` | готово |
| 7 | Company Documents Across Southeast Asia `#southeast-asia` | SEA Map Tabs (К-2) | P | `kyc-sea-section.php` | готово, предпросмотр ок |
| 8 | KYB Requirements Worldwide (`#requirements`) | **Compliance Map**: абзац ТЗ дословно разложен по 5 юрисдикциям, subtitle «Last reviewed: October 2026.» — пересобрано вместо одной карточки (правило владельца с AML) | P | `kyc-compliance-section.php` | готово, предпросмотр ок |
| 9 | KYB Solutions by Industry | Industries (Identity), 5 карточек без тегов | P | `kyc-industries-section.php` | готово |
| 11 | KYB Service Pricing `#pricing` | Pricing (partial): главная карточка (текст ТЗ + Get a quote), без цены и планов (К-3) | P | `kyc-pricing-section.php` | готово, **см. «Открыто»** |
| 12 | Why Choose… (`#why-choose`) | Checks, 2-й экземпляр, 5 карточек h3 | P | `idv-checks-section.php` | готово |
| 13 | KYB API | Integration: стандартные слайды, без deploy-карточки (К-5) | P | `integration-section.php` | готово |
| 14 | Security and Data Protection (`#security`) | **полный idv-security, как на AML**: 2 карточки (предложение ТЗ дословно; ISO-знаки + кнопка «Information security policy»), региональная карта SEA — пересобрано вместо одной карточки | P | `idv-security-section.php` | готово |
| 15 | Start KYB Verification | Contacts без аргументов | P | `contacts-section.php` | готово |
| 16 | KYB FAQ `#faq` | FAQ: 5 вопросов (К-6) | P | `faq-section.php` | готово |

## Отложено (условные блоки ТЗ)

- Вся страница — до подтверждения командой, что KYB есть в продукте (условие запуска ТЗ). Собираю как вариант А.
- Вариант Б: H3 «Company registry check», факт hero «[N] registries connected», хвост шага 2 «and matched against the registry», UBO-фраза «We build the ownership structure…», блок 10 «Ongoing Business Monitoring», FAQ «Do you check company registries automatically?».
- Блок 5 «Business Onboarding…» — «только при подтверждённой связке „дело по компании“» (К-1).
- Блок 12, карточка «Built for Southeast Asian companies» — «только в формулировке, подтверждённой командой».
- KYB Resources — нет 2+ опубликованных материалов.
- FAQ без ответа в ТЗ: «Which countries’ companies can you verify?», «How long does KYB verification take?», «How do I add KYB to my onboarding?».
- JSON-LD `SoftwareApplication`, `FAQPage` (§7).
- Требуют подтверждения, но ставятся по тексту ТЗ (отмечу в отчёте): «one link / one case» в шагах 1, 3, 4; распознавание корпоративных документов (блок 3); скрининг названия компании; API для дела по компании (блок 13).

## Недостающие картинки

| Блок | Будущий файл | Размер 1x | Что изображено (ТЗ) | alt | Временно стоит |
|---|---|---|---|---|---|
| 1 Hero | `img/kyb-hero.webp` + `-mobile` (+`@2x`) | 1600×1056 / 720×536 | карточка дела «Sample Trading Pte. Ltd.»: Documents ✓ · Directors ✓ · Owners ✓ · Screening: no matches ✓ · Status: Approved (без цифр) | «KYB verification case: company documents, directors and beneficial owners verified, sanctions screening clear» | `identity-hero*` |
| 4 Steps | `img/kyb-step-1…4.webp` (+`@2x`) | 200×200 | компания → документы → три человека с галками → щит скрининга → «Approved» | `alt=""` (alt ТЗ — на всю схему) | `identity-step-*`, `kyc-step-*` |
| 6 UBO | `img/kyb-ubo-schema.webp` (+`@2x`) | 644×452 | Sample Trading Pte. Ltd. ← 60% Holding Ltd. ← 100% Jane Sample (UBO ✓); 40% ← John Example (UBO ✓) | «UBO verification: ownership structure with two beneficial owners identified» | ноутбук `identity-platform-*` |
| 6 UBO audit | `img/kyb-ubo-audit.webp` (+`@2x`) | 255 по ширине | в ТЗ не описано (иллюстрация карточки; по смыслу — «дерево владения») | `alt=""` | `identity-platform-accent` |

Компании и люди — только вымышленные, документы — с пометкой SPECIMEN (требование ТЗ). Генерация через Magnific — только по прямому указанию владельца (§6).

## Вопросы владельцу

- [ ] **К-1 Блок 5 «Business Onboarding Without the Back-and-Forth».** ТЗ: «только при подтверждённой связке „дело по компании“». Предложение: отложить, как другие условные блоки. Если ставить сейчас — Benefits (3 карточки) без promo: текста для promo в ТЗ нет.
- [ ] **К-2 SEA, вариант А.** В варианте А ТЗ переименовывает колонку «Registry» в «What to ask for», но значения не меняет. Блок вмещает три факта, их переключает JS: заголовок, текст и два ярлыка. Предложение: заголовок — страна; «Company registry» → реестр (ACRA (BizFile)… — справочно, без обещания подключения); «What to ask for» → основной документ компании; текст карточки → «Beneficial ownership rules: …». Третий общий ряд токенов не выводить, текста для него нет.
- [ ] **К-3 Pricing (блок 11).** Цены нет. В partial зашиты «From $0.25 per check» и карточки Free pilot / Enterprise. Предложение: вызов partial без цены и планов, как AML В-1 (раньше предлагалась C-копия). Нужно разрешение и для этой страницы. Строку цены и боковые карточки не выводить, в главной карточке — текст ТЗ. Кнопка — одна: «Get a quote» → форма (`button` с классами `kyc-btn kyc-btn--primary`). «See KYC pricing» не ставлю: KYB в калькуляторе нет, ссылка на цены KYC запутает. Другой вариант — оставить «See KYC pricing» ссылкой на /pricing-matrix/, а «Get a quote» не ставить.
- [ ] **К-4 Блок 8 «KYB Requirements Worldwide».** ТЗ: «один абзац, без H3». Compliance Map для этого не годится: у неё H3 на каждую юрисдикцию. Предложение: H2 + одна карточка с абзацем (разметка Security). Дата «Last reviewed: October 2026.» остаётся в конце абзаца.
- [ ] **К-5 Блок 13 «KYB API».** В ТЗ — один абзац, слайдов нет. Если не передать слайды, Integration покажет свои стандартные (API Integration / Web SDK & Widget / Mobile SDK). Тот же текст стоит на /solutions/, /kyc/ и /identity-verification/. Варианты: (а) Integration со стандартными слайдами — блок про интеграцию с кнопкой «View documentation» → /docs/, моя рекомендация; (б) H2 + одна карточка с абзацем, но тогда блоки 13 и 14 одинаковые и стоят подряд; (в) отложить до подтверждения API.
- [ ] **К-6 FAQ «What is a UBO, and how do you identify one?».** В ТЗ — только «what», часть «how» ждёт варианта. Предложение: ответ = первое предложение ТЗ + фраза варианта А из блока 6 «The business customer declares its owners and the documents that prove them.» Так ответ не придуман. Хвосты «Read our guide to KYB →» и «Read KYB vs KYC →» не ставлю (В-10).

## Решения владельца (2026-10-20)

Все предложения К-1…К-6 приняты, Pricing теперь partial с аргументами (C-копия больше не нужна):
- К-1 — блок 5 отложен.
- К-2 — SEA: заголовок = страна; «Company registry» → реестр; «What to ask for» → основной документ; текст → «Beneficial ownership rules: …»; общий ряд токенов не выводится; lead = дисклеймер.
- К-3 — Pricing (partial): без строки цены и без карточек планов; одна кнопка «Get a quote» → форма.
- К-4 — блок 8: H2 + одна карточка с абзацем. **Заменено** при сборке правилом владельца с AML («блок не из одной карточки», 2026-10-20): Compliance Map; блок 14 — полный Security, как на AML.
- К-5 — Integration со стандартными слайдами, кнопка «View documentation» → /docs/.
- К-6 — FAQ про UBO: первое предложение ТЗ + фраза варианта А из блока 6.

## Мета для Yoast (из ТЗ)

| Поле | Значение |
|---|---|
| SEO title | KYB Verification: Know Your Business Software \| NeuroVision (запасной: Know Your Business (KYB) Verification \| NeuroVision) |
| Meta description | вариант А (ТЗ: убрать «and registries»): KYB verification for business onboarding: check company documents, verify directors and beneficial owners, and screen them for sanctions. |
| og:title | NeuroVision KYB: Verify Companies, Directors and Beneficial Owners |
| og:description | Onboard business customers faster: company documents, registry data, UBO and director checks with KYC and AML screening in one flow. (⚠ «registry data» — вариант Б; при варианте А убрать) |
| og:image | 1200×630 — макет описан в ТЗ, файла нет |
| canonical | https://nv.global/kyb/ |
| Хлебные крошки | Home → Products → KYB |
| Родитель страницы | нет |

## Открыто после сборки

- [ ] **Блоки, урезанные до одного элемента** (утверждены в К-3 и карте до правила «не из одной карточки»):
  - Trust strip — только подпись, широкая пустая плашка. Предложение: токены из слов hero ТЗ «Company documents» · «Directors» · «Beneficial owners» · «Sanctions & PEP» (как токены на AML).
  - Pricing — одна карточка на полширины, справа пусто. Предложение: вернуть боковую колонку одной accent-карточкой «Get a quote» с ответом FAQ ТЗ «Pricing depends on the number of people in each business case and the checks you need. Contact us for a quote.», а в главной — ссылка «See KYC pricing» → /pricing-matrix/ (обе кнопки — из ТЗ).
- [ ] **Блок 8 — H3 вопреки ТЗ** («без H3, чтобы не дублировать /kyc/ и /aml/»): у Compliance Map заголовок на каждую юрисдикцию (в DOM виден один). Заголовки собраны из слов абзаца. UK и UAE в ТЗ — одно предложение, у двух маркеров текст одинаковый.
- [ ] Steps без lead и note — в ТЗ подзаголовка нет; над кнопками шагов только H2.
- [ ] Industries без тегов — карточки ниже наполнены, чем на Identity.
- [ ] Ссылки внутри текста карточек не выведены (→ KYC verification, → AML screening, → UBO verification, → Document verification) — как на AML: нет стиля ссылок. Хвосты FAQ «Read our guide to KYB →», «Read KYB vs KYC →» — материалы в плане.
- [ ] Якоря `#ubo`, `#industries`, `#api` не выставлены — у partial нет аргумента `id`.
- [ ] Подтвердить у команды тексты, поставленные по ТЗ: «one link / one case» (шаги 1, 3, 4; «linked to the company case» в блоке 3), распознавание корпоративных документов, скрининг названия компании, API для дела по компании.
- [ ] JSON-LD `SoftwareApplication`, `FAQPage` — не добавлены (§7).

## Правки по замечаниям владельца (2026-10-20, п. 1, 4 и 7)

- **Industries:** у 5 карточек добавлены теги `tags` (фразы ТЗ каждой отрасли), вариант `idv-industries`.
- **Hero-кнопки на мобильных:** `mobile_text` — «Start KYB» / «How It Works».
- **Platform Bento (UBO):** четыре карточки слева как в библиотеке: верхняя «Identify beneficial owners» + заметка («The business customer declares its owners and the documents that prove them.»), audit «Verify them like any customer», пара «Ownership thresholds by country» + «Threshold for each market».

## Audit-иконка без полей (2026-10-21, блок Platform переведён на картинку в потоке)

`kyb-ubo-audit` (+`@2x`; новый файл — в пакет для прода): убраны прозрачные поля (были нужны при абсолютной картинке, теперь делали иконку крошечной). Видимая часть обрезана по альфе и вписана в 215×247 из 255 (@2x 430×495 из 510), прижата вниз-вправо (поле справа ≈9%, снизу ≈2%), как у `identity-platform-accent`. Размеры файлов и `width`/`height` в шаблоне прежние. Исходники — scratchpad, чистые альфа-PNG 1024. Замер 14 ширин (1920…320): пересечений с текстом 0, обрезки 0. Реестр: О-13, О-30.

## Свои картинки (2026-10-21, замечание владельца: страница выглядела как /identity-verification/)

Все картинки страницы — свои `kyb-*`, чужих Identity/KYC больше нет (Magnific 4k, О-17…О-19).

| Блок | Было | Стало |
|---|---|---|
| 1 Hero ≥992 / 768–1199 / <768 | `identity-hero`, `identity-hero-mobile` | `kyb-hero` (фото 4k «деловая женщина за ноутбуком» + HTML-карточка «Sample Trading Pte. Ltd.»: Documents / Directors / Owners verified, Screening no matches, Approved — без цифр не из ТЗ), `kyb-hero-laptop` (то же фото без карточки, кадр 992–1199), `kyb-hero-tablet` (без карточки, субъект сдвинут вправо зеркальным полем слева, чтобы H1 на 768–991 не заходил на лицо), `kyb-hero-mobile` 720×536. Один человек, руки у ноутбука не в фокусе, кропы лица и руки проверены (О-18); 3 попытки не понадобились — первая принята |
| 4 Steps 1–4 | `identity-step-icon`, `kyc-step-2`, `kyc-step-1`, `identity-step-decision` | `kyb-step-1…4` 200×200 (+@2x): папка с документами компании → документ с лупой и печатью → телефон + ID → щит с галкой на папке (4k, `--remove-bg`, поля 6%) |
| 6 Platform, экран ноутбука | `identity-platform-screen` | `kyb-ubo-screen` 644×452 (+@2x 1288×904): HTML-макет «Ownership structure» (Sample Trading Pte. Ltd. → Sample Holdings Ltd. → Jane Sample, John Example; UBO verified), без процентов; содержимое сжато влево — правый край ноутбука уходит под панель (О-16) |
| 6 Platform, audit | `kyb-ubo-audit` | без изменений |

Общие элементы, оставшиеся от библиотеки (по замечанию — не заменяются): шапка/подвал, флаги, знаки сертификатов, рамка `identity-platform-laptop`; карты региона SEA/Security (`kyc-sea-*`, `kyc-map-world`, `kyc-marker*`, `identity-security-*`) и иллюстрация карточки Integration `sol-int-folders` — геометрия и слои блоков, общие для всех страниц.

## Журнал

- 2026-10-20 — прочитаны регламент и ТЗ, составлена карта (вариант А). Код не начат. Жду «ок» владельца и ответов на К-1…К-6.
- 2026-10-20 — карта согласована (К-1…К-6); собран `page-kyb.php`; блоки 8 и 14 пересобраны по правилу владельца «не из одной карточки» (Compliance Map, полный Security); QA §12 на 6 ширинах пройдено. Статус — готово к приёмке.
- 2026-10-20 — по указанию владельца («генерировать новые изображения, а не использовать старые») сгенерированы через Magnific и подготовлены в WebP 1x/2x, **ещё не вставлены** (ждут показа владельцу, §6): `kyb-hero` (фото + HTML-карточка «Sample Trading Pte. Ltd.», только ≥992), `kyb-hero-tablet`, `kyb-hero-mobile` (фото без карточки), `kyb-step-1…4` (3D-иконки, фон удалён), `kyb-ubo-audit` (3D-дерево владения), `kyb-ubo-screen` (HTML-макет схемы владения 60/40/100%, тестовые имена). Готовые файлы — в scratchpad сессии `kyb-gen/out/`, превью — `kyb-gen/contact-sheet.png`.
- 2026-10-20 — правки по семи замечаниям владельца (см. раздел «Правки по замечаниям владельца»).
