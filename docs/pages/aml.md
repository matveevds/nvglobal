# Карта страницы «AML Screening»

> Рабочая память сборщика (регламент — `docs/PAGE_BUILDER.md`). Обновлять после каждого шага:
> после очистки контекста работа продолжается отсюда.

| Поле | Значение |
|---|---|
| ТЗ | `/Users/dmitriy/ZAKAZI/nv.global/ТЗ на новые страницы/ТЗ страница «AML Screening» nv.global.md` (13.10.2026) |
| URL / slug | `/aml/` (без родителя) |
| Шаблон | `page-aml.php`, Template Name «AML Screening»  |
| Семейство | **identity**: продуктовая страница; из identity берутся Checks ×2, Benefits, Security, вариант Platform и Industries. Из KYC-only — два блока (Compliance Map, SEA Map Tabs): правила их элементов в `css/styles.css` не привязаны к `body.page-template-page-kyc` (BEM без префикса), Identity уже использует слои `kyc-sea-*` → риск низкий, но **обязательна проверка в предпросмотре** (§2, §12) |
| Статус | **готово к приёмке** (2026-10-20) |
| Предпросмотр | `https://nvglobal.local/kyc/?nv_page_preview=page-aml.php` |

## Блоки

Бейджи секций берутся из подписей `page-nav` в ТЗ (блок 1): Checks · How it works · Review · Southeast Asia · Requirements · Industries · Pricing · API · FAQ.

| # ТЗ | Блок ТЗ (H2, якорь) | Блок библиотеки | Способ | Источник | Статус |
|---|---|---|---|---|---|
| 1 | Hero (H1) | Product Hero (Identity), 3 факта (В-2), кнопки Try AML Screening Free / See Pricing | P | `kyc-hero-section.php` | готово |
| 2 | Trust strip | `idv-certs` без знаков: подпись ТЗ + токены Sanctions · PEP · Watchlists (В-3) | P | `certs-section.php` | готово |
| 3 | What NeuroVision AML Screening Checks `#checks` | Checks: интро + 3 карточки h3, без subtitle и pill | P | `idv-checks-section.php` | готово |
| 4 | How AML Screening Works `#how-it-works` | Steps (Identity), 4 шага h3, `aml-step`, note пустой (В-10) | P | `kyc-steps-section.php` | готово |
| 5 | AML Checks Inside Your KYC Flow (`#kyc-flow`) | Benefits: 3 карточки + promo (вводный абзац разбит, короткое предложение — заголовком), без бейджа | P | `idv-benefits-section.php` | готово |
| 6 | An AML Platform for Reviewing Matches | Platform (Identity): `top_html`/lead/summary пусто; audit = Match details, pair = Approve + Audit trail | P | `kyc-platform-section.php` | готово |
| 8 | AML Screening in Southeast Asia `#southeast-asia` | SEA Map Tabs: страна · «Ask us which local lists are covered.» · Regulator / FIU · Main AML law · What we screen | P | `kyc-sea-section.php` | готово, предпросмотр ок |
| 10 | Requirements `#requirements` | Compliance Map, 5 юрисдикций, подзаголовок = дисклеймер | P | `kyc-compliance-section.php` | готово, предпросмотр ок |
| 11 | AML Solutions by Industry | Industries (Identity), 6 карточек, теги «What to screen: …» + «когда» | P | `kyc-industries-section.php` | готово |
| 12 | AML Screening Pricing `#pricing` | Pricing — partial `kyc-pricing-section.php` с аргументами (В-1) | P | `kyc-pricing-section.php` | готово |
| 13 | Why Choose… (`#why-choose`) | Checks, 2-й экземпляр, 5 карточек h3 (В-6), без бейджа/интро | P | `idv-checks-section.php` | готово |
| 14 | Trusted by… | — | — | — | отложен (В-4) |
| 15 | AML Screening API | Integration: badge API, 3 слайда (h4), без deploy-карточки | P | `integration-section.php` | готово |
| 16 | Security and Data Protection (`#security`) | одна карточка, без ISO и регионального блока (В-9) | P | `idv-security-section.php` | готово |
| 17 | Try AML Screening Free | Contacts без аргументов (В-8) | P | `contacts-section.php` | готово |
| 18b | AML Screening FAQ `#faq` | FAQ: 8 вопросов, первый раскрыт, description пустой | P | `faq-section.php` | готово |

## Отложено (условные блоки ТЗ)

- Блок 3, H3 «Adverse media screening»: «только если функция есть».
- Блок 3, H3 «National lists in 50+ countries», факт hero «50+ countries' lists», карточка 13 «Global and regional lists», FAQ «Which sanctions lists…» (хвост про 50+): «без подтверждения… не публикуем». До ответа: H3 не ставлю; в факте hero — В-2.
- Блок 7 «Re-Screening and Ongoing Monitoring»: «только если функция есть».
- Блок 9 «Matching Asian Names Without the Noise»: «только если подтверждено».
- Блок 18a «AML Resources»: «выводим при 2+ опубликованных материалах», опубликованных нет. Блок News показывает последние записи блога, а не AML.
- FAQ «Do you re-screen customers…», «Do you cover Southeast Asian…», «Can I run AML checks without ID verification?»: в ТЗ нет готового ответа или ответ «без подтверждения не публикуем».
- JSON-LD `SoftwareApplication` и `FAQPage`: §7, открытый пункт отчёта.
- Блоки 4, 6 и шаг 2 (транслитерация, очередь разбора) ТЗ просит подтвердить. Собираю по тексту ТЗ и отмечаю в отчёте.

## Недостающие картинки

| Блок | Будущий файл | Размер 1x | Что изображено (ТЗ) | alt | Временно стоит |
|---|---|---|---|---|---|
| 1 Hero | `img/aml-hero.webp` + `aml-hero-mobile.webp` (+`@2x`) | 1600×1056 / 720×536 | карточка результата скрининга «Jane Sample», строки EU/OFAC/UK/UN/PEP — no match ✓, статус «Clear»; позади карточка «Possible match — review» | «AML screening result: a customer checked against EU, OFAC, UK and UN sanctions lists and PEP data with no matches» | `identity-hero*` |
| 4 Steps | `img/aml-step-1…4.webp` (+`@2x`) | 200×200 | документ → «Name · DOB · Nationality» → веер списков → «Clear / Possible match» | `alt=""`, как в источнике (в ТЗ alt дан на всю схему) | `identity-step-*` |
| 5 Benefits promo | `img/aml-benefits-promo.webp` (+`@2x`) | 180×151 | в ТЗ не описано; по смыслу «документ + лицо + щит в одной рамке» | `alt=""` | `identity-benefits-fraud` |
| 6 Platform | `img/aml-platform-screen.webp` (+`@2x`) | 644×452 | дашборд: очередь «Possible matches», сравнение «Customer · List entry», кнопки Clear · Reject · Escalate, тестовые данные | «AML platform: reviewing a possible sanctions match side by side with the customer's verified data» | `identity-platform-screen` |
| 6 Platform audit | `img/aml-platform-audit.webp` (+`@2x`) | 255 по ширине | в ТЗ не описано (иллюстрация карточки) | `alt=""` | `identity-platform-accent` |

Hero и og:image (1200×630) — дизайнер; og:image владелец загружает в Yoast.

**Замена картинок (2026-10-20, координатор, по указанию владельца):**

| Блок | Было | Стало | Как сделано |
|---|---|---|---|
| 1 Hero ≥992 | `identity-hero` | `aml-hero` (1600×1056, @2x 3200×2112) | фото Magnific (Mystic, realism) + карточка результата скрининга «Jane Sample», EU/OFAC/UK/UN/PEP — no match, Clear; позади «Test Person — Possible match — review» (HTML-рендер, Satoshi) |
| 1 Hero 768–991 | `identity-hero` | `aml-hero-tablet` | то же фото без карточки: кадрирование Identity на Tablet уводило карточку под H1 |
| 1 Hero <768 | `identity-hero-mobile` | `aml-hero-mobile` (720×536) | кроп фото без карточки: на Mobile карточку перекрывали кнопки |
| 4 Step 2 | `kyc-step-2` (телефон) | `aml-step-2` | 3D-иконка Magnific: лупа над стопкой списков, фон удалён (remove-background) |
| 4 Step 3 | `kyc-step-1` (графики) | `aml-step-3` | 3D-иконка Magnific: две карточки профилей + флаг, фон удалён |
| 6 Platform screen | `identity-platform-screen` | `aml-platform-screen` (644×452) | HTML-макет: AML review queue, Customer / List entry, Match score, Clear · Reject · Escalate, Audit trail; только тестовые имена |

Оставлены как подходящие по смыслу: Step 1 `identity-step-icon` (паспорт), Step 4 `identity-step-decision` (запись решения), промо блока 5 `identity-benefits-fraud` (маскот с лупой), audit `identity-platform-accent` (чек-лист), ноутбук `identity-platform-laptop`. og:image 1200×630 — не сделан.

**Блок 16 Security пересобран (2026-10-20, координатор, замечание владельца «всего одна карточка»):** вместо одной
карточки — полный `idv-security` Identity: карточка «Encrypted in transit and at rest» (1-е предложение ТЗ дословно),
карточка «ISO/IEC 27001:2022 certified» (2-е предложение ТЗ, ISO/ASIB/QA-знаки как в подвале сайта, кнопка
`kyc-btn--small` «Information security policy» → `/information-security-policy/` из ТЗ), региональная карточка с картой SEA
(`$nv_security_map` скопирован из Identity) и флагами EU/SG/MY/ID/PH/TH/VN, заголовок «Processed under GDPR and the privacy
laws of our Southeast Asian markets» — слова ТЗ. Решение В-9 этим заменено. Открыто: «View certificate (PDF)» — PDF
сертификата в теме нет; кому выданы сертификаты — ТЗ просит сверить до публикации.

## Вопросы владельцу

- [x] **В-1 Pricing (блок 12).** В `kyc-pricing-section.php` зашиты «From $0.25 per check», карточка «Free pilot / 1-month pilot…» и текст enterprise. Для AML это неверная цена. Предложение: перенести разметку partial в `page-aml.php` как C-копию (те же теги и классы, partial не трогаю) и вставить тексты ТЗ: $0.40 · Free trial · Volume and enterprise. «$0.40 per screening check» встанет в `<p class="kyc-pricing__price">`, а не в H3. **[Закрыто 2026-10-21: Pricing стал универсальным partial с аргументами, C-копия не нужна.]**
- [ ] **В-2 Факт hero «50+ countries' lists».** Факт условный, ТЗ предлагает замену «Seconds per check» после замера. Предложение: до ответа команды поставить 3 факта (EU · OFAC · UK · UN / PEP / $0.40). Подпись под кнопками «Free trial · Part of your KYC flow · One API» в partial не помещается, её не ставлю.
- [ ] **В-3 Trust strip (блок 2).** Сертификаты ISO/GDPR — «только после проверки», логотипы — «только с согласия», NIST/iBeta не ставить. Предложение: полоса `idv-certs` без знаков сертификации, подпись — «Trusted by 50+ banks, fintechs and exchanges for KYC and AML checks.», токены «Sanctions» · «PEP» · «Watchlists» (из og:image ТЗ). Либо блок отложить.
- [ ] **В-4 Блок 14 «Trusted by…».** Кроме одной фразы, всё условное (логотипы и кейс — с согласия). Подходящего блока для одной фразы нет: в About Stats зашиты цифры точности лица и документов. Предложение: отложить блок до логотипов и кейса.
- [ ] **В-5 Элементы без текста в ТЗ.** Как поступать, когда у блока есть элемент, для которого в ТЗ нет текста: `kyc-subtitle` у Checks (блоки 3, 13), интро у Checks (блок 13), `faq__description`, заголовок promo в Benefits (блок 5). Предложение: такие `<p>` не выводить. Для promo в блоке 5 разбить вводный абзац ТЗ без изменения слов: первое предложение — заголовок, второе — текст.
- [ ] **В-6 Блок 13 «Why Choose».** ТЗ требует H4, но в Checks карточки — `h3`. Предложение: оставить `h3`, потому что H4 сразу под H2 — пропуск уровня, который запрещает само ТЗ. Бейдж секции — «Why NeuroVision»?
- [ ] **В-7 SEA (блок 8).** JS вкладок держит только поля title, text, regulator и id_doc. Колонка «Local list to screen» уйдёт в текст карточки. В DOM виден только первый Singapore, остальные страны лежат в `data-kyc-states` (ТЗ просит весь текст в HTML). Колонка «Local list» условна: если список не поддерживается, текст карточки будет «Ask us which local lists are covered.» Ссылки «Read more» ведут на неопубликованные страницы, их не ставлю.
- [ ] **В-8 Partial с зашитыми текстами.** У Integration якорь `#integration` вместо `#api`, слайды — `h4`, кнопки «View documentation» и «Talk to integration team», примера JSON нет. У Contacts H2 «Not sure which product fits?…» вместо «Try AML Screening Free», поля формы стандартные, `source=aml` и GA4 из ТЗ не сделать. Предложение: принять как есть, шаблоны не трогать.
- [ ] **В-9 Security (блок 16).** В ТЗ один абзац, сертификаты — после проверки. В блоке `idv-security` есть карточки с `h3` и региональная карта, а текста для них в ТЗ нет. Предложение: одна карточка с заголовком = H2 ТЗ, без знаков ISO и регионального блока, либо отложить блок до ответа DPO.
- [ ] **В-10 Ссылки на планируемые материалы.** Хвосты «Read our guide to AML screening →» (FAQ 1), «New to AML? Read our guide…» (под шагами, note), «→ Transaction monitoring» ведут на ещё не опубликованные страницы. Предложение: не выводить их до публикации. Note шагов — пустой.

## Решения владельца (2026-10-20, «Пусть делает»)

- В-1 — Pricing: вызов partial `kyc-pricing-section.php` в `page-aml.php` с текстами ТЗ (partial стал универсальным: аргументы вместо зашитых текстов).
- В-3 — полоса `idv-certs` без знаков: подпись из ТЗ + токены Sanctions · PEP · Watchlists.
- В-4 — блок 14 отложен.
- В-5 — элементы без текста в ТЗ не выводить; promo блока 5 — вводный абзац разбит на заголовок и текст без изменения слов.
- В-6 — карточки «Why Choose» остаются `h3`.
- В-9 — Security: одна карточка без ISO-знаков и регионального блока.
- В-2, В-7, В-8, В-10 — приняты как есть.

## Мета для Yoast (из ТЗ)

| Поле | Значение |
|---|---|
| SEO title | AML Screening & Compliance Software \| NeuroVision (запасной: AML Screening Software: Sanctions & PEP Checks \| NeuroVision) |
| Meta description | AML screening software for sanctions, PEP and watchlist checks, built into your KYC flow. Global and Southeast Asian lists. From $0.40 per check, one API. |
| og:title | NeuroVision AML Screening: Sanctions and PEP Checks in Your KYC Flow |
| og:description | Screen every customer against sanctions, PEP and watchlists in the same session as ID and selfie checks. Review matches, keep an audit trail. |
| og:image | 1200×630 — макет описан в ТЗ, файла нет |
| canonical | https://nv.global/aml/ |
| Хлебные крошки | Home → Products → AML Screening |
| Родитель страницы | нет |

## Открыто после сборки

- [ ] **Ссылки в тексте карточек сняты:** «→ KYC verification» (блок 5) и «→ Information security policy» (блок 16). У `.kyc-card__text` нет стиля ссылок — выходит синяя подчёркнутая браузерная ссылка. Варианты: принять без ссылок / координатор добавляет стиль ссылки в карточках.
- [ ] **Хвосты-ссылки FAQ сняты** («Learn more about KYC →», «See our pricing page →»): FAQ-partial выводит ответы через `esc_html`, ссылку не поставить. Тот же выбор.
- [ ] **Promo блока 5 на 1100:** promo во всю ширину, текст ТЗ длиннее исходного — конец строки уходит под картинку-маскота (временную). На 1920/1440/840/740/392 не пересекается.
- [ ] **Platform без верхнего ряда:** левая колонка ниже карточки ноутбука на ~170 px (1440) — пустое место под парой карточек. Не сломано, но видно.
- [ ] **FAQ «Which sanctions lists…»** — снят хвост «and national lists in 50+ countries» (условный «50+»); **Industries / Banks** — тег «local lists» оставлен, как в ТЗ, до ответа про локальные списки.
- [ ] **Якоря:** `#review`, `#industries`, `#api` не выставлены — partial без аргумента `id`; `#review` к тому же занят модалкой в `footer.php`. Липкого `page-nav` в библиотеке нет, поэтому сейчас не мешает.
- [ ] **H3 в SEA и Compliance:** в DOM только первая страна/юрисдикция, остальные — в `data-kyc-states` (В-7).
- [ ] **SEA: дисклеймер** «This overview is for information only…» в блок не помещается (нет слота) — стоит только в блоке 10.
- [ ] JSON-LD `SoftwareApplication`, `FAQPage` — не добавлены (§7).

## Правки по замечаниям владельца (2026-10-20, п. 4 и 7)

- **Hero-кнопки на мобильных:** добавлены `mobile_text` — «Try Free» / «See Pricing» (в варианте Identity на мобильных виден только `--mobile`). Проверено на 392 и 740.
- **Platform Bento (блок 6):** возвращены четыре карточки слева как в библиотеке: верхняя «no-code + note» («Match details side by side» + заметка «Decide in seconds whether it is the same person.»), audit с картинкой («Audit trail and reports»), пара («Approve, reject or escalate», «Reports for audits»). Все слова — из ТЗ блока 6, разложены по фразам; `summary` в блоке не выводится.

## Audit-иконка без полей (2026-10-21, блок Platform переведён на картинку в потоке)

`aml-review-audit` (+`@2x`): убраны прозрачные поля (были нужны при абсолютной картинке, теперь делали иконку крошечной). Видимая часть обрезана по альфе и вписана в 215×247 из 255 (@2x 430×495 из 510), прижата вниз-вправо (поле справа ≈9%, снизу ≈2%), как у `identity-platform-accent`. Размеры файлов и `width`/`height` в шаблоне прежние. Исходники — scratchpad, чистые альфа-PNG 1024. Замер 14 ширин (1920…320): пересечений с текстом 0, обрезки 0. Реестр: О-13, О-30.

## Журнал

- 2026-10-20 — прочитаны регламент и ТЗ, библиотека сверена с кодом partial и секций, составлена карта. Код не начат. Жду «ок» владельца и ответов на В-1…В-10.
- 2026-10-20 — решения владельца записаны; собран `page-aml.php` (блоки 1–6, 8, 10–13, 15–18b); QA §12 на 6 ширинах пройдено; promo блока 5 перестроен (короткое предложение заголовком), ссылки в карточках сняты. Статус — готово к приёмке.
- 2026-10-20 — правки по семи замечаниям владельца (см. раздел «Правки по замечаниям владельца»).
