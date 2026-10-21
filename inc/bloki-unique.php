<?php
/**
 * Уникальные блоки (page-bloki.php, ?nv_bloki=unique) — карта поверх inc/bloki-data.php, данные не дублируются.
 *
 * Номера — позиции полного каталога (?nv_bloki=1, сквозная нумерация по порядку групп inc/bloki-data.php).
 * Критерий слияния: тот же компонент (partial или корневой класс и структура), отличия — контент, количество
 * элементов, модификатор или body-класс страницы. Похожие блоки с разным кодом не сливаются
 * (тикет block-catalog/unique, раздел «Похожие»).
 *
 * merges[key]: name, desc, usage, source, edit, deps — общая подпись; variants — array(номер => подпись варианта):
 * кадр каждого варианта берётся из позиции полного каталога. Вариант с подписью '' в переключатель не выводится
 * (Blog Slider + News Card: карточка — часть слайдера, отдельного кадра не нужно).
 *
 * groups: title, note?, items — номер полного каталога (int) или ключ слияния (string).
 * Проверка: каждый из 101 номеров встречается ровно один раз (скрипт приёмки).
 */

if (!defined('ABSPATH')) {
    exit;
}

return array(
    'merges' => array(
        'hero' => array(
            'name'     => 'Main Hero Card',
            'desc'     => 'Первый экран продуктовой страницы: скруглённая карточка с фото и логотипом, H1, подзаголовок и кнопки. KYC и Identity — универсальный блок `main--hero` (фото набором кадров, 3–4 факта с иконками, затемнение в блоке); Solutions и Pricing — свой каркас в шаблоне (у Pricing вместо фактов крошки и две кнопки). На ≤991 факты уходят строкой под текст, на ≤767 фото становится картинкой сверху, кнопки — столбиком.',
            'usage'    => '/solutions/, /kyc/, /identity-verification/, /pricing-matrix/. Для новой продуктовой страницы — вызов kyc-hero-section со своими аргументами.',
            'source'   => 'Solutions — page-solutions.php (разметка в шаблоне); Pricing — page-price-matrix.php (разметка в шаблоне); KYC и Identity и страницы из блоков — template-parts/kyc-hero-section.php, css/blocks/main-hero.css (`title`, `subtitle`, `primary_btn`, `secondary_btn`, `facts`, `arrow_icon`, `media` или `media_html`).',
            'edit'     => 'Универсальный блок: аргументы partial (тексты, кнопки, факты 3–4, `media` с кадрами fhd / desktop / laptop / tablet / mobile и `focus*`; `mobile_text` у кнопок и фактов). Solutions и Pricing — разметка в шаблоне.',
            'deps'     => 'Для KYC / Identity вид не зависит от страницы (`.main--hero`, модификаторов нет). Каркас Solutions / Pricing — `.main__*` в css/styles.css и body-класс страницы. Основная кнопка без `href` открывает модалку обратной связи.',
            'variants' => array(22 => 'Solutions', 30 => 'KYC', 42 => 'Identity', 55 => 'Pricing'),
        ),
        'accordion' => array(
            'name'     => 'Accordion Cards',
            'desc'     => 'Доска карточек внахлёст с номерами и фото справа: наведение или клик раскрывает карточку (ширина анимируется 0,45 с) и показывает её заголовок и текст, фото во время перехода не меняет размер. Solutions — 4 карточки, высота 620; KYC — 5 карточек, высота 440. На ≤991 интерактив снимается: фото сверху, под ним все карточки раскрыты внахлёст по вертикали.',
            'usage'    => '/solutions/ (Key Benefits) и /kyc/ (процесс). Для 3–5 преимуществ или шагов с одной иллюстрацией.',
            'source'   => 'page-solutions.php:364–417 (`section.solutions-why[data-solutions-why]`) и page-kyc.php:84–128 (`solutions-why--kyc#process`).',
            'edit'     => 'Карточки: массив в page-solutions.php или `process` в inc/kyc-data.php; фото — `img/sol-why-*.webp`. Отличия: модификатор `solutions-why--kyc` (высота 440, 5 уровней, ширина фото от 4 свёрнутых карточек).',
            'deps'     => 'JS — `initSolutionsWhy()` берёт только первый `[data-solutions-why]`: два аккордеона на одной странице не оживут. Ширина фото считается от «раскрытая + (N−1) свёрнутые» — при другом числе карточек нужна правка CSS.',
            'variants' => array(23 => 'Solutions', 32 => 'KYC'),
        ),
        'steps' => array(
            'name'     => 'Steps Slider',
            'desc'     => 'Универсальный блок (один вид): бейдж, заголовок, лид, примечание и кнопки Step 1–N; карточки шагов с иллюстрациями — вертикальная лента на Desktop, ряд на Full HD, свайп-лента <992. 3–5 шагов, высота карточек по содержимому.',
            'usage'    => '/kyc/, /identity-verification/ и страницы, собранные из блоков. Пошаговое объяснение процесса.',
            'source'   => 'template-parts/kyc-steps-section.php (`section.kyc-steps[data-kyc-steps]`); аргументы — `badge`, `title`, `lead`, `note`, `steps`, `arrow_icon`, `section_id`, `step_id_prefix`, `nav_label`, `step_label`.',
            'edit'     => 'Шаги — массив `steps` в вызове; тексты — аргументы. Варианта Identity больше нет: вид один.',
            'deps'     => 'JS — `initKycPage()`, только первый `[data-kyc-steps]`. Правила на классе `.kyc-steps`, без body-скоупа.',
            'variants' => array(33 => 'KYC', 45 => 'Identity'),
        ),
        'platform' => array(
            'name'     => 'Platform Bento',
            'desc'     => 'Универсальный блок (один вид): бейдж, заголовок, лид; верхняя карточка с плашкой, аудит с иллюстрацией, 1–3 карточки, панель с ноутбуком и сводка. ≥1200 — карточки и панель рядом, ниже — столбцом. Необязательные части не оставляют дыр.',
            'usage'    => '/kyc/, /identity-verification/ и страницы, собранные из блоков. Обзор возможностей платформы.',
            'source'   => 'template-parts/kyc-platform-section.php; аргументы — `section_id`, `badge`, `title`, `lead`, `top`, `audit`, `pair`, `screen` / `screen_html`, `summary`.',
            'edit'     => 'Карточки — массивы аргументов; скриншот — `screen.image`. Варианта Identity и модификатора `idv-platform` больше нет.',
            'deps'     => 'Правила на классе `.kyc-platform`, без body-скоупа; JS нет.',
            'variants' => array(35 => 'KYC', 46 => 'Identity'),
        ),
        'industries' => array(
            'name'     => 'Industries Cards',
            'desc'     => 'Универсальный блок (один вид): заголовок, лид и 3–6 карточек отраслей с иконкой, текстом и тегами; высота по содержимому, нечётная последняя карточка — на всю строку. ≤767 одна колонка.',
            'usage'    => '/kyc/, /identity-verification/ и страницы, собранные из блоков. Сценарии по отраслям без переключения (с переключением — Industries Tabs Slider).',
            'source'   => 'template-parts/kyc-industries-section.php; аргументы — `badge`, `title`, `lead`, `section_id`, `items` (`title`, `text`, `icon`, `tags`).',
            'edit'     => 'Отрасли — `items`; теги — `tags`. Вариант `req` и модификатор `idv-industries` убраны.',
            'deps'     => 'Правила на классе `.kyc-industries`, без body-скоупа.',
            'variants' => array(39 => 'KYC', 49 => 'Identity'),
        ),
        'pricing' => array(
            'name'     => 'Pricing Panel',
            'desc'     => 'Универсальный блок (один вид): серая секция с белыми PageEdge, заголовок, лид, основная плашка цены с описанием и кнопкой, рядом 1–3 плашки планов. На ≤991 плашки столбиком, на ≤767 содержимое плана — столбиком.',
            'usage'    => '/kyc/, /identity-verification/ и страницы, собранные из блоков. Для новой страницы — короткий блок цен со ссылкой на /pricing-matrix/.',
            'source'   => 'template-parts/kyc-pricing-section.php; аргументы — `section_id`, `badge`, `title`, `lead`, `eyebrow`, `price_prefix`, `price`, `price_unit`, `price_note`, `cta`, `cta_url`/`cta_form`, `arrow_icon`, `plans`.',
            'edit'     => 'Все тексты, цена и планы — аргументы вызова; необязательное не передавать — не выводится. Модификатор `idv-pricing` убран.',
            'deps'     => 'Правила на классе `.kyc-pricing`, без body-скоупа.',
            'variants' => array(40 => 'KYC', 51 => 'Identity'),
        ),
        'certs' => array(
            'name'     => 'Certs Strip',
            'desc'     => 'Универсальная полоса доверия под первым экраном: рамка; слева знаки сертификации (0–N, со ссылкой или без) и подпись, справа плашки (0–N, с иконкой или без). Любое сочетание: нет знаков, нет плашек, только подпись. На ≤1199 подпись над знаками, плашки ниже; всё переносится.',
            'usage'    => '/kyc/, /identity-verification/, /aml/, /kyb/, /document-verification/, /face-verification/, /liveness/ и страницы, собранные из блоков.',
            'source'   => 'template-parts/certs-section.php, css/blocks/idv-certs.css (`section.idv-certs`); аргументы — `section_id`, `title`, `marks`, `chips`, `chip_icon`.',
            'edit'     => 'Знаки — `img/kyc-cert-*.webp` (+`@2x`, высота 80); `kyc-cert-qa` на тёмном фоне — с `round: true`; плашки — строки или `text` + `icon`.',
            'deps'     => 'Вид не зависит от страницы, без body-класса. `css/blocks/kyc-certs.css` пуст (перенесено в idv-certs.css).',
            'variants' => array(31 => 'KYC', 43 => 'Identity'),
        ),
        'about' => array(
            'name'     => 'About Stats & Certs',
            'desc'     => 'О компании: заголовок, лид, ряд цифр с разделителями и блок сертификатов со знаками и ссылками. На ≤991 сертификаты столбиком, на ≤767 цифры столбиком — у KYC разделители скрыты, у Identity становятся горизонтальными линиями.',
            'usage'    => '/kyc/ и /identity-verification/. Для новой страницы — блок «о компании» с цифрами и сертификатами.',
            'source'   => 'template-parts/kyc-about-section.php:16–54; вызовы page-kyc.php:448 и page-identity-verification.php:442–448 (`badge`, `title`, `lead`, `arrow_icon`, `modifier`).',
            'edit'     => 'Тексты — аргументы/умолчания partial; значки — `img/kyc-cert-*`. Отличия Identity: модификатор `idv-about`.',
            'deps'     => 'Вид варианта — модификатор (`idv-about`) и body-класс страницы.',
            'variants' => array(41 => 'KYC', 52 => 'Identity'),
        ),
        'integration' => array(
            'name'     => 'Integration',
            'desc'     => 'Универсальный блок (один вид): заголовок, слайдер путей интеграции, карточки «Every integration includes», развёртывания и Back-office; любую часть можно не передавать.',
            'usage'    => '/solutions/, /kyc/, /identity-verification/ и страницы, собранные из блоков.',
            'source'   => 'template-parts/integration-section.php; стандартные тексты — `nv_integration_preset()` (inc/integration-preset.php); аргументы — `section_id`, `badge`, `heading`, `subtitle`, `docs_text`/`docs_url`, `contact_text`/`contact_form`, `path_title`, `slides`, `includes`, `deploy`, `backoffice`.',
            'edit'     => 'Все тексты, слайды и картинки — аргументы вызова; набор по умолчанию — `nv_integration_preset()`. Картинки — `img/sol-int-*.webp`.',
            'deps'     => 'Правила на классе `.integration`, без body-скоупа. JS — `initIntegrationSlider()` (первый на странице).',
            'variants' => array(26 => 'Solutions / KYC', 53 => 'Identity'),
        ),
        'faq' => array(
            'name'     => 'FAQ Accordion',
            'desc'     => 'Вопросы и ответы аккордеоном: слева бейдж, заголовок, описание (у partial — с кнопкой), справа список вопросов — клик раскрывает ответ, открыт один. На ≤991 левая часть уходит над списком, на ≤767 — одна колонка.',
            'usage'    => 'Главная (разметка в шаблоне) и /solutions/, /kyc/, /identity-verification/ (partial). Для новой страницы — partial faq-section.php со своими `items`.',
            'source'   => 'main-page.php (`section.faq#faq`) и template-parts/faq-section.php (`section.faq`; аргументы `items`, `title`, `description`, `section_id`); в ответах partial разрешены `<a href target rel>`, `<strong>`, `<em>`, `<br>`.',
            'edit'     => 'Вопросы — в разметке главной или массивом `items` (page-solutions.php `$nv_solutions_faq`, `faq` в inc/kyc-data.php и inc/identity-verification-data.php); ссылки в ответах оранжевые (css/blocks/faq.css).',
            'deps'     => 'JS — `initFaq()`; id `#faq` и `faq-question-N` повторяются при двух FAQ на странице.',
            'variants' => array(20 => 'Home', 28 => 'Solutions / KYC / Identity'),
        ),
        'contacts' => array(
            'name'     => 'Contacts',
            'desc'     => 'Обратная связь: бейдж, заголовок, оранжевая карточка с почтой и соцсетями, преимущества и форма (имя, компания, e-mail, телефон, услуга, сообщение, согласие).',
            'usage'    => 'Главная и /solutions/, /kyc/, /identity-verification/. Для новой страницы — partial contacts-section.php (и body-класс страницы в списках Contacts).',
            'source'   => 'main-page.php (`section.contacts#contacts`) и template-parts/contacts-section.php (`section.contacts`; аргументы `section_id` (`cta`), `badge`, `title`, `lead` — по умолчанию прежние тексты); форма — template-parts/contacts-form.php (`show_select`).',
            'edit'     => 'Тексты — в шаблоне главной или аргументы contacts-section.php (пустые `badge` / `lead` убирают элемент); поля — contacts-form.php (`name` и `data-*` не менять).',
            'deps'     => '`initContactsForms()` (js/form.js); вид — ≈160 списков контекстов `.contacts` по body-классам. Формы не отправлять.',
            'variants' => array(21 => 'Home', 29 => 'Solutions / KYC / Identity'),
        ),
        'blog' => array(
            'name'     => 'Blog Slider + News Card',
            'desc'     => 'Insights & Resources: бейдж Blog, заголовок, кнопка «Explore All Articles» и слайдер карточек четырёх последних записей. Карточка слайдера (`article.news__item`: картинка, мета, заголовок) — часть блока.',
            'usage'    => '/identity-verification/ (с главной убран 2026-10-21). Выводится, только если есть записи.',
            'source'   => 'template-parts/news-section.php (`section.news#blog`); карточка — template-parts/news-card.php:42; вызов — page-identity-verification.php.',
            'edit'     => 'Заголовок и описание — news-section.php; кнопка ведёт на страницу записей (`page_for_posts`, без неё не выводится); карточки — из записей: заголовок, отрывок, миниатюра, мета `post_views` / `post_likes`, время чтения.',
            'deps'     => 'JS — `initNewsSlider()` (первый `.news__content.swiper`), Swiper.',
            'variants' => array(19 => 'Blog Slider', 73 => ''),
        ),
        'layout' => array(
            'name'     => 'Article Layout',
            'desc'     => 'Раскладка статьи: крошки, боковая колонка (оглавление или меню документации), статья, внизу — автор и форма у записи, дочерние ссылки и prev/next у документа.',
            'usage'    => 'Записи блога (single.php) и документы (single-document.php, /docs/). Шаблон статьи — отдельно не собирается.',
            'source'   => 'single.php:10–446 (`main.main-post`) и single-document.php:154–206 / page-docs.php:215–257 (`main.main-post.single-doc`).',
            'edit'     => 'Содержимое — запись / документ в админке. Отличия: модификатор `single-doc`, css/document-toc.css у документации.',
            'deps'     => 'body-класс `single-post` / `single-document`; css/post.css, у документации ещё css/document-toc.css. Оглавление и меню ниже 1200 — выезжающая панель (js/main.js).',
            'variants' => array(74 => 'Запись', 60 => 'Документ'),
        ),
        'sidebar' => array(
            'name'     => 'Article Sidebar',
            'desc'     => 'Боковая колонка статьи: оглавление записи (Gutenberg-блок `acf/toc`) или дерево меню документации; на мобильных выезжает по кнопке.',
            'usage'    => 'Записи блога (оглавление) и документы (меню). Для статьи — оглавление ставится блоком `acf/toc`, меню строится из дерева документов.',
            'source'   => 'single.php:25–38 / single-document.php:169–178 (`aside.post-sidebar`); оглавление — blocks/toc/ + functions.php:1917 (`extract_toc_block_from_content()`); меню — inc/docs-menu.php:128 (`nv_docs_menu_render()`).',
            'edit'     => 'Оглавление — заголовки статьи; меню — дерево документов (родитель, `menu_order`).',
            'deps'     => 'JS оглавления — js/main.js (`.post-sidebar .toc-block`); кэш меню — `nv_docs_menu_flush_for_post()`.',
            'variants' => array(82 => 'Оглавление записи', 62 => 'Меню документации'),
        ),
        'body' => array(
            'name'     => 'Article Body (typography)',
            'desc'     => 'Текст статьи: типографика H2–H4, абзацев, списков, таблиц, цитат и ссылок, внутри — Gutenberg-блоки; у документа заголовки получают якоря для ссылок из меню. Таблицы и картинки ужимаются по ширине колонки на мобильных.',
            'usage'    => 'Записи блога и документы. Для новой статьи — весь основной текст.',
            'source'   => 'single.php:96–98 (`.post-text.entry-content`) и single-document.php:180–201 (`article.post-content`, якоря — `nv_document_add_heading_ids()`); стили — css/post.css.',
            'edit'     => 'Текст — редактор записи или документа (H2–H4, абзацы, списки, таблицы, Gutenberg-блоки); формат импорта — docs/BLOG-IMPORT-GUIDE.md.',
            'deps'     => 'Стили core-блоков — только внутри `.post__content .post-text`.',
            'variants' => array(77 => 'Запись', 63 => 'Документ'),
        ),
    ),

    'groups' => array(
        array('title' => 'Общие элементы сайта', 'items' => array(1, 2, 3, 4, 5, 6, 7, 8)),
        array('title' => 'Первые экраны', 'items' => array(9, 'hero', 66)),
        array('title' => 'Процессы и шаги', 'items' => array(14, 'steps', 'accordion', 34)),
        array('title' => 'Возможности и карточки', 'items' => array(12, 13, 15, 24, 25, 38, 44, 50, 'platform', 'industries')),
        array('title' => 'Карты и охват', 'items' => array(16, 36, 37, 47)),
        array('title' => 'Цены', 'items' => array(17, 'pricing', 56, 57, 58)),
        array('title' => 'Доверие и о компании', 'items' => array(10, 11, 'certs', 48, 27, 54, 'about')),
        array('title' => 'Интеграция и разработчикам', 'items' => array('integration', 18)),
        array('title' => 'Формы и FAQ', 'items' => array('contacts', 81, 'faq')),
        array('title' => 'Блог и медиа', 'items' => array('blog', 67, 68, 69, 70, 71, 72)),
        array('title' => 'Статья и документация', 'items' => array('layout', 61, 'sidebar', 75, 76, 'body', 78, 79, 80, 64, 65, 59)),
        array('title' => 'Gutenberg-блоки (ACF)', 'items' => array(83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100)),
        array('title' => 'Служебные', 'items' => array(101)),
    ),
);
