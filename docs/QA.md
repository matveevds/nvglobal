# QA — проверки перед сдачей

Сайт локально доступен **только по HTTPS**, сертификат самоподписанный:
`curl -k`, в Playwright `ignoreHTTPSErrors: true`. `http://nvglobal.local/` не отвечает.

---

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

**После группы 1 редизайна (2026-10-05, коммит группы 1):**

| Страница | 1920 | 1440 | 840 | 392 | 375 |
|---|---|---|---|---|---|
| `/` | 8821 | 9261 | 12942 | 15434 | 15569 |
| `/solutions/` | 9269 | 9190 | 12564 | 12673 | 12952 |
| `/pricing-matrix/` | 6237 | 6341 | 8127 | 6563 | 6750 |
| `/docs/` | 1772 | 1792 | 2109 | 2362 | 2386 |

Главная стала короче: скрыты `page-nav`, `video-intro`, `cases`, `promo` (Р-11).
Остальные страницы не изменились — это и есть проверка на регрессии.

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

## 8. Отчёт

После работы:
1. список изменённых файлов;
2. что проверено и чем, что проверить не удалось;
3. запись в `docs/CHANGELOG.md`;
4. новые найденные риски — в `docs/BACKLOG.md` или `docs/THEME-TODO.md`.

Не выдавать непроверенное за подтверждённое.
