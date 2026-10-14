# Справка по импорту записей блога

Формат JSON для плагина **Blog JSON Export/Import** (`wp-content/plugins/blog-json-io/`, версия 1.4.0)
и каталог всех Gutenberg-блоков темы, которые можно использовать в записи.

Все формы блоков ниже сняты реальным `parse_blocks()` на этом сайте и проверены
рендером `render_block()`; итоговый файл прогонялся через `BJIO_Importer::import_post()`.

> Починка блоков в редакторе от 2026-10-13 (`docs/CHANGELOG.md`) формат импорта
> не затронула: имена блоков, имена полей, `field_`-ключи и структура `attrs.data`
> прежние. Всё описанное ниже остаётся в силе.

---

## 1. Как работает плагин

| Действие | Где | Что делает |
|---|---|---|
| Экспорт | Инструменты → Экспорт/импорт блога (JSON); метабокс на записи | `parse_blocks()` → JSON |
| Импорт новой записи | Инструменты → форма импорта | `serialize_blocks()` → `wp_insert_post()` |
| Обновление существующей | метабокс «Обновить из JSON» (AJAX) | перезаписывает контент, заголовок, отрывок, SEO, картинку и рубрики **этой** записи |

Главное: **контент не парсится из HTML — он собирается из массива `post.blocks`
функцией `serialize_blocks()`**. Поэтому в файле должны лежать блоки в том виде,
в каком их отдаёт `parse_blocks()`, а не готовая разметка статьи.

Round-trip проверен: `serialize_blocks(parse_blocks(serialize_blocks($b))) === serialize_blocks($b)`.

---

## 2. Структура файла целиком

```json
{
  "blog_json_io_version": 1,
  "exported_at": "2026-05-20 10:00:00",
  "source": {
    "site_url": "https://nvglobal.local/",
    "post_id": 1424
  },
  "_translation_note": "подсказка для LLM, импортом не используется",
  "post": {
    "title": "Заголовок записи",
    "slug": "zagolovok-zapisi",
    "status": "publish",
    "date": "2026-04-13 21:13:48",
    "date_gmt": "2026-04-13 18:13:48",
    "excerpt": "Короткий отрывок.",
    "author": { "id": 1, "login": "neurovision", "name": "NeuroVision" },
    "seo": {
      "title": "SEO-заголовок",
      "description": "SEO-описание",
      "keywords": "focus keyphrase"
    },
    "featured_image": {
      "id": 1408,
      "url": "https://nvglobal.local/wp-content/uploads/2026/03/img.jpg",
      "alt": "Описание картинки"
    },
    "categories": [ { "slug": "kyc-aml", "name": "KYC/AML" } ],
    "tags": [ { "slug": "biometrics", "name": "Biometrics" } ],
    "blocks": [ /* массив блоков — раздел 4 и 5 */ ]
  },
  "images": [ "https://nvglobal.local/.../img.jpg" ]
}
```

### Что реально читает импортёр

| Ключ | Обязателен | Что происходит |
|---|---|---|
| `post` | **да** | без него — «Некорректный JSON: нет секции post» |
| `post.blocks` | фактически да | `serialize_blocks()`; если пусто — запись без контента |
| `post.title` | нет | прогоняется через `wp_strip_all_tags()` |
| `post.excerpt` | нет | как есть |
| `post.status` | нет | **учитывается только если снять галочку «Создать как черновик»** |
| `post.date`, `post.date_gmt` | нет | переносятся **всегда**, даже у черновика. Формат строго `YYYY-MM-DD HH:MM:SS`, иначе `strtotime()` + `gmdate()` — часовой пояс может уехать |
| `post.author.login` | нет | поиск по login; фолбэк — `author.id` (только если `source.site_url` совпадает с текущим сайтом); иначе текущий пользователь |
| `post.seo.*` | нет | `_yoast_wpseo_title`, `_yoast_wpseo_metadesc`, `_yoast_wpseo_focuskw`. Пустые строки пропускаются |
| `post.featured_image.url` | нет | `attachment_url_to_postid()`. Не нашёл → фолбэк на `.id` (тот же сайт) → иначе URL уходит в мету `_bjio_featured_url` |
| `post.categories[]`, `post.tags[]` | нет | поиск по `slug`, затем по `name`; **не найдено — создаётся новый термин** |
| `source.post_id`, `source.site_url` | нет | фолбэки автора и картинки, связка Polylang, мета `_bjio_imported_from` |

**Игнорируются при импорте:** `blog_json_io_version`, `exported_at`, `_translation_note`,
`images` — справочные поля. **`post.slug` тоже игнорируется**: WordPress всегда
генерирует новый уникальный slug из заголовка, чтобы перевод не конфликтовал с оригиналом.

---

## 3. Анатомия одного блока

Каждый элемент `post.blocks` — ровно пять ключей:

```json
{
  "blockName": "core/paragraph",
  "attrs": {},
  "innerBlocks": [],
  "innerHTML": "\n<p>Текст.</p>\n",
  "innerContent": ["\n<p>Текст.</p>\n"]
}
```

| Ключ | Смысл |
|---|---|
| `blockName` | имя блока; `null` — «сырой» HTML между блоками |
| `attrs` | атрибуты в фигурных скобках комментария. `{}` и `[]` равнозначны |
| `innerBlocks` | вложенные блоки (списки, цитаты) |
| `innerHTML` | склеенный HTML блока |
| `innerContent` | массив кусков HTML; `null` на месте каждого вложенного блока |

Два класса блоков ведут себя по-разному:

- **Core-блоки** хранят текст в `innerHTML` / `innerContent`.
- **ACF-блоки темы** самозакрывающиеся: `innerHTML: ""`, `innerContent: []`,
  весь контент лежит в `attrs.data`.

### `innerContent` и `null`

Здесь чаще всего ломаются файлы, написанные руками. Количество `null` в `innerContent`
должно **точно совпадать** с количеством элементов `innerBlocks`, а строки между ними —
это куски обёртки. Для списка из двух пунктов:

```json
"innerHTML": "\n<ul class=\"wp-block-list\">\n\n</ul>\n",
"innerContent": ["\n<ul class=\"wp-block-list\">", null, "\n\n", null, "</ul>\n"]
```

---

## 4. Core-блоки

Тема стилизует шесть core-блоков (`css/post.css`): `paragraph`, `heading`, `image`,
`list`, `separator`, `table`.

### Абзац

```json
{ "blockName": "core/paragraph", "attrs": {}, "innerBlocks": [],
  "innerHTML": "\n<p>Текст со <strong>жирным</strong> и <a href=\"https://example.com/\">ссылкой</a>.</p>\n",
  "innerContent": ["\n<p>Текст со <strong>жирным</strong> и <a href=\"https://example.com/\">ссылкой</a>.</p>\n"] }
```

### Заголовок

H2 — без `level`, остальные — с ним. Класс `wp-block-heading` обязателен.

```json
{ "blockName": "core/heading", "attrs": {}, "innerBlocks": [],
  "innerHTML": "\n<h2 class=\"wp-block-heading\">Заголовок</h2>\n",
  "innerContent": ["\n<h2 class=\"wp-block-heading\">Заголовок</h2>\n"] }

{ "blockName": "core/heading", "attrs": { "level": 3 }, "innerBlocks": [],
  "innerHTML": "\n<h3 class=\"wp-block-heading\">Подзаголовок</h3>\n",
  "innerContent": ["\n<h3 class=\"wp-block-heading\">Подзаголовок</h3>\n"] }
```

> **`id` у заголовков не проставлять.** `nv_add_ids_to_post_headings()` в `functions.php`
> сам вешает `id` через `translit_cyr_to_lat()` — и тем же способом строит ссылки блок
> `acf/toc`. Свой `id` фильтр не перезапишет, и оглавление перестанет попадать в якоря.

### Список

`core/list` + вложенные `core/list-item`. Нумерованный — `"ordered": true` и `<ol>`.

```json
{ "blockName": "core/list", "attrs": {},
  "innerBlocks": [
    { "blockName": "core/list-item", "attrs": {}, "innerBlocks": [],
      "innerHTML": "\n<li>Первый пункт</li>\n", "innerContent": ["\n<li>Первый пункт</li>\n"] },
    { "blockName": "core/list-item", "attrs": {}, "innerBlocks": [],
      "innerHTML": "\n<li>Второй пункт</li>\n", "innerContent": ["\n<li>Второй пункт</li>\n"] }
  ],
  "innerHTML": "\n<ul class=\"wp-block-list\">\n\n</ul>\n",
  "innerContent": ["\n<ul class=\"wp-block-list\">", null, "\n\n", null, "</ul>\n"] }
```

### Картинка

`attrs.id` и класс `wp-image-<id>` должны указывать на один и тот же attachment.

```json
{ "blockName": "core/image",
  "attrs": { "id": 87, "sizeSlug": "large", "linkDestination": "none" },
  "innerBlocks": [],
  "innerHTML": "\n<figure class=\"wp-block-image size-large\"><img src=\"https://nvglobal.local/wp-content/uploads/2026/03/service1.png\" alt=\"Описание\" class=\"wp-image-87\"/><figcaption class=\"wp-element-caption\">Подпись</figcaption></figure>\n",
  "innerContent": ["...тот же HTML..."] }
```

### Разделитель и таблица

```json
{ "blockName": "core/separator", "attrs": {}, "innerBlocks": [],
  "innerHTML": "\n<hr class=\"wp-block-separator has-alpha-channel-opacity\"/>\n",
  "innerContent": ["\n<hr class=\"wp-block-separator has-alpha-channel-opacity\"/>\n"] }

{ "blockName": "core/table", "attrs": {}, "innerBlocks": [],
  "innerHTML": "\n<figure class=\"wp-block-table\"><table><thead><tr><th>A</th><th>B</th></tr></thead><tbody><tr><td>1</td><td>2</td></tr></tbody></table></figure>\n",
  "innerContent": ["...тот же HTML..."] }
```

### Цитата

`core/quote` — обёртка с вложенными абзацами. В статьях блога обычно уместнее
`acf/quote`: он с автором, должностью и аватаром.

---

## 5. ACF-блоки темы

19 блоков, регистрируются в `functions.php` → `nv_register_acf_blocks()`.
Общая форма:

```json
{
  "blockName": "acf/<slug>",
  "attrs": {
    "name": "acf/<slug>",
    "data": { "<поле>": "<значение>", "_<поле>": "field_xxxxxxxxxxxxx" },
    "mode": "auto"
  },
  "innerBlocks": [],
  "innerHTML": "",
  "innerContent": []
}
```

### Три правила

**1. На каждое поле — две записи в `data`: значение и ссылка на ключ поля.**

Проверено экспериментально:

| Что опущено | Результат |
|---|---|
| `_поле` у простого поля (text / wysiwyg / image) | работает — ACF находит поле по имени в группе |
| `_поле` у **репитера** | **блок не выводится вообще, 0 байт** |
| весь `attrs` | значения теряются, остаётся пустая обёртка |

`_`-ключи пишем всегда: для репитеров это обязательно, для остальных — это то,
что ACF пишет сам, и единственная гарантированно правильная форма.

**2. `attrs.name` и `attrs.mode` на рендер фронта не влияют** (проверено — результат
идентичен), но нужны редактору Gutenberg. Дублируем `blockName` в `name`,
`mode` берём из `block.json`.

**3. Картинки — только числовой attachment ID.** Несмотря на `return_format: array`
в настройках поля, в `attrs.data` ACF хранит ID. Строка с URL работать не будет.

### Репитеры

ACF разворачивает репитер в плоские ключи: счётчик строк плюс
`<репитер>_<индекс>_<подполе>`, индексация с нуля.

```json
"data": {
  "pillar": 2,
  "_pillar": "field_69438532408a2",

  "pillar_0_pillar_name": "Первый",
  "_pillar_0_pillar_name": "field_6943853244730",
  "pillar_0_pillar_percent": "70%",
  "_pillar_0_pillar_percent": "field_69438532481ca",

  "pillar_1_pillar_name": "Второй",
  "_pillar_1_pillar_name": "field_6943853244730",
  "pillar_1_pillar_percent": "30%",
  "_pillar_1_pillar_percent": "field_69438532481ca"
}
```

Счётчик (`"pillar": 2`) — число, не строка, и должен совпадать с реальным числом строк.
Ключ подполя одинаковый во всех строках: он описывает подполе, а не строку.

### Врезки с одним полем

| Блок | mode | Поле | Тип | field key |
|---|---|---|---|---|
| `acf/warning` | **preview** | `text_content` | wysiwyg | `field_69268eadd076f` |
| `acf/success` | **preview** | `text_content` | wysiwyg | `field_69268eadd076f` |
| `acf/disclaimer` | **preview** | `disclaimer_content` | wysiwyg | `field_6926768f32397` |

> `warning` и `success` делят одну группу полей, поэтому ключ у них общий.
> **У `acf/note` поле называется так же (`text_content`), но ключ другой** —
> `field_694369da4a9b2`. Перепутать легко, блок молча останется пустым.

```json
{ "blockName": "acf/warning",
  "attrs": { "name": "acf/warning", "mode": "preview",
    "data": { "text_content": "<p>Текст предупреждения.</p>", "_text_content": "field_69268eadd076f" } },
  "innerBlocks": [], "innerHTML": "", "innerContent": [] }
```

### Текстовые блоки

| Блок | mode | Поля (тип, field key) |
|---|---|---|
| `acf/note` | **preview** | `text_content` wysiwyg `field_694369da4a9b2`; `ssylka_na_istochnik` url `field_69436a024a9b3`; `tekst_ssylki` text `field_69436aa4fa9ab` |
| `acf/spoiler` | **preview** | `spoiler_title` text `field_69266a592c5f5`; `spoiler_content` wysiwyg `field_69266bd92c5f6` |
| `acf/result` | **preview** | `result_title` text `field_6936c8f5aa17d`; `result_text` wysiwyg `field_6936c920aa17e` |
| `acf/about` | **preview** | `about_title` text `field_6998062eca25e`; `about_text` wysiwyg `field_69980665ca25f`; `about_link` text `field_69980693ca260`; `about_link_text` text `field_699806abca261` |
| `acf/callout` | **preview** | `callout_title` text `field_69b003ce25e8b`; `callout_text` wysiwyg `field_69b003ee25e8c`; `callout_btn` text `field_69b0040c25e8d` |
| `acf/code` | auto | `code_lang` text `field_697a0fd28915a`; `code_content` **textarea** `field_697a101e8915b` |
| `acf/quote` | **preview** | `quote_content` wysiwyg `field_69267a6bed983`; `quote_author` text `field_69267aaaed984`; `quote_author_job` text `field_69267ac2ed985`; `quote_author_image` **image → ID** `field_69267f4575236` |

> `code_content` — textarea: код кладётся **чистым текстом**, без `<p>` и без
> HTML-экранирования. В `wysiwyg`-поля, наоборот, кладётся HTML (`<p>…</p>`, `<ul>`, `<a>`).

```json
{ "blockName": "acf/quote",
  "attrs": { "name": "acf/quote", "mode": "preview", "data": {
    "quote_content": "<p>Текст цитаты.</p>", "_quote_content": "field_69267a6bed983",
    "quote_author": "Иван Петров", "_quote_author": "field_69267aaaed984",
    "quote_author_job": "CTO", "_quote_author_job": "field_69267ac2ed985",
    "quote_author_image": 87, "_quote_author_image": "field_69267f4575236"
  } },
  "innerBlocks": [], "innerHTML": "", "innerContent": [] }
```

### Изображения

| Блок | mode | Поля |
|---|---|---|
| `acf/single-image` | auto | `nv_image` image→ID `field_69255b46b4efe`; `nv_caption` text `field_69255c07cc8b1`; `nv_source` text `field_69255c14cc8b2` |
| `acf/two-images` | auto | репитер `gallery` `field_6943c8261daf8` → `gallery_image` image→ID `field_6943c8371daf9`; `gallery_image_caption` wysiwyg `field_6943c84e1dafa`; `gallery_image_source` text `field_6943c8681dafb` |

`acf/single-image` поддерживает `anchor` и `align: wide|full`, `acf/two-images` — только
`align`. Выравнивание пишется в `attrs.align`, якорь — в `attrs.anchor`.

```json
{ "blockName": "acf/single-image",
  "attrs": { "name": "acf/single-image", "mode": "auto", "align": "wide", "data": {
    "nv_image": 87, "_nv_image": "field_69255b46b4efe",
    "nv_caption": "Подпись под картинкой", "_nv_caption": "field_69255c07cc8b1",
    "nv_source": "NeuroVision", "_nv_source": "field_69255c14cc8b2"
  } },
  "innerBlocks": [], "innerHTML": "", "innerContent": [] }
```

### Блоки с репитерами

| Блок | mode | Репитер | Подполя |
|---|---|---|---|
| `acf/slider` | auto | `slider` `field_69426269a5f1a` | `slider_image` image→ID `field_694262a1a5f1b`; `slider_title` wysiwyg `field_694262b5a5f1c`; `slider_istocjnik` text `field_694262cba5f1d` |
| `acf/tabs` | auto | `tabs` `field_69690183e2875` | `tab_title` text `field_696901a3e2876`; `tab_text` wysiwyg `field_696901b6e2877` |
| `acf/faq` | auto | `faq_list` `field_697a32596190f` | `faq_question` textarea `field_697a327861910`; `faq_answer` textarea `field_697a329161911`; `faq_author` **user → ID** `field_697a32cf61912` |
| `acf/stages` | auto | `stages` `field_69367cbe3892a` | `stage_name` text `field_69367d113892b`; `stage_title` text `field_69367d403892c`; `stage_active` **true_false (0/1)** `field_69367f8d7991c`; `stage_text` textarea `field_69367d4f3892d` |
| `acf/pillar` | auto | `pillar` `field_69438532408a2` | `pillar_name` text `field_6943853244730`; `pillar_percent` text `field_69438532481ca`; `pillar_height` **number** `field_6943985b66121`; `pillar_color` color `field_694385ebcb4f9`; `pillar_percent_color` color `field_694386b7cb4fa` |

`acf/steps` устроен иначе — есть и обычные поля, и репитер:

| Поле | Тип | field key |
|---|---|---|
| `steps_title` | text | `field_69366856a4477` |
| `steps_style` | radio: `style-2-col` / `style-3-col` / `style-4-col` | `field_69438058e55b1` |
| `steps_items` | репитер | `field_693668e7a4478` |
| → `steps_item` | text | `field_69366904a4479` |
| → `steps_text` | wysiwyg | `field_69366916a447a` |

```json
{ "blockName": "acf/steps",
  "attrs": { "name": "acf/steps", "mode": "auto", "data": {
    "steps_title": "Как это работает", "_steps_title": "field_69366856a4477",
    "steps_style": "style-3-col", "_steps_style": "field_69438058e55b1",
    "steps_items": 2, "_steps_items": "field_693668e7a4478",
    "steps_items_0_steps_item": "Шаг 1", "_steps_items_0_steps_item": "field_69366904a4479",
    "steps_items_0_steps_text": "<p>Описание первого шага.</p>", "_steps_items_0_steps_text": "field_69366916a447a",
    "steps_items_1_steps_item": "Шаг 2", "_steps_items_1_steps_item": "field_69366904a4479",
    "steps_items_1_steps_text": "<p>Описание второго шага.</p>", "_steps_items_1_steps_text": "field_69366916a447a"
  } },
  "innerBlocks": [], "innerHTML": "", "innerContent": [] }
```

Типы значений: `pillar_height` и `stage_active` — **числа**, не строки (`70`, `1` / `0`).
`faq_author` — ID пользователя из `wp_users`. `steps_style` — только одно из трёх значений,
иначе вёрстка колонок не включится.

### Оглавление

| Блок | mode | Поля |
|---|---|---|
| `acf/toc` | **preview** | нет |

Единственный блок без полей: сам сканирует `post_content` на `h2`–`h4` и строит список.
Ставится один раз в начале статьи.

```json
{ "blockName": "acf/toc",
  "attrs": { "name": "acf/toc", "data": {}, "mode": "preview" },
  "innerBlocks": [], "innerHTML": "", "innerContent": [] }
```

---

## 6. Частые ошибки

| Симптом | Причина |
|---|---|
| Блок-репитер исчез с фронта | нет `_<репитер>` или счётчик не совпадает с числом строк |
| Врезка вывелась только с иконкой | значение положили не в тот ключ (`text_content` у `note` ≠ у `warning`) |
| Картинка в ACF-блоке не видна | в `data` URL вместо attachment ID; или ID с другого сайта |
| Картинка записи не привязалась | URL не резолвится — смотрите мету `_bjio_featured_url` у записи |
| Список или цитата едут | число `null` в `innerContent` не равно числу `innerBlocks` |
| Ссылки оглавления никуда не ведут | у заголовков в JSON прописан свой `id` |
| Дата сбилась на часы | `date` не в формате `YYYY-MM-DD HH:MM:SS` |
| Появились дубли рубрик | опечатка в `categories[].slug` — термин создался заново |
| Запись вышла черновиком, хотя в файле `publish` | не снята галочка «Создать как черновик» |

Общее правило: **структуру менять нельзя** — та же длина массивов, тот же порядок,
те же ключи. Переводить и править можно только `post.title`, `post.excerpt`,
`post.seo.*`, `name` у рубрик и меток, `innerHTML` / `innerContent` у core-блоков
и **значения** в `attrs.data`. Не трогать: ключи, `_`-ключи, значения `field_xxx`,
attachment ID, URL, CSS-классы, имена тегов, числа.

---

## 7. Минимальный рабочий файл

```json
{
  "blog_json_io_version": 1,
  "source": { "site_url": "https://nvglobal.local/", "post_id": 0 },
  "post": {
    "title": "Название статьи",
    "status": "publish",
    "date": "2026-05-20 10:00:00",
    "date_gmt": "2026-05-20 07:00:00",
    "excerpt": "Отрывок.",
    "author": { "id": 1, "login": "neurovision", "name": "NeuroVision" },
    "seo": { "title": "SEO", "description": "Описание", "keywords": "kyc aml" },
    "featured_image": { "id": 87, "url": "https://nvglobal.local/wp-content/uploads/2026/03/service1.png", "alt": "alt" },
    "categories": [ { "slug": "kyc-aml", "name": "KYC/AML" } ],
    "tags": [],
    "blocks": [
      { "blockName": "acf/toc", "attrs": { "name": "acf/toc", "data": {}, "mode": "preview" },
        "innerBlocks": [], "innerHTML": "", "innerContent": [] },
      { "blockName": "core/paragraph", "attrs": {}, "innerBlocks": [],
        "innerHTML": "\n<p>Вводный абзац.</p>\n", "innerContent": ["\n<p>Вводный абзац.</p>\n"] },
      { "blockName": "core/heading", "attrs": {}, "innerBlocks": [],
        "innerHTML": "\n<h2 class=\"wp-block-heading\">Первый раздел</h2>\n",
        "innerContent": ["\n<h2 class=\"wp-block-heading\">Первый раздел</h2>\n"] },
      { "blockName": "acf/warning",
        "attrs": { "name": "acf/warning", "mode": "preview",
          "data": { "text_content": "<p>Важное предупреждение.</p>", "_text_content": "field_69268eadd076f" } },
        "innerBlocks": [], "innerHTML": "", "innerContent": [] }
    ]
  },
  "images": []
}
```

Самый надёжный способ получить образец — экспортировать существующую запись
из админки и править её копию: так гарантированно совпадут и `field_`-ключи,
и форма `innerContent`.
