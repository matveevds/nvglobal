/**
 * Каталог блоков (page-bloki.php, ?nv_bloki=1). Подключается только в режиме каталога.
 * Кадр — same-origin iframe реальной страницы: ширина вьюпорта кадра = выбранная (1920/1600/1440/1200/1100/992/840/740/392),
 * кадр масштабируется под ширину колонки (transform: scale), высота — по содержимому кадра.
 *
 * ≈100 кадров: iframe получает src только при подходе к вьюпорту (IntersectionObserver) и выгружается,
 * когда уходит далеко (высота сохраняется, прокрутка не прыгает) — число живых страниц ограничено.
 */
(function () {
    'use strict';

    var DEFAULT_VW = 1440;
    var LOAD_MARGIN = '1000px 0px';
    var UNLOAD_MARGIN = '5000px 0px';
    var globalVw = DEFAULT_VW;
    var items = Array.prototype.slice.call(document.querySelectorAll('[data-bloki-item]'))
        .filter(function (item) { return item.querySelector('iframe'); });

    function itemVw(item) {
        return parseInt(item.getAttribute('data-vw'), 10) || globalVw;
    }

    function measure(item) {
        var iframe = item.querySelector('iframe');
        var frame = item.querySelector('[data-bloki-frame]');
        var stage = item.querySelector('[data-bloki-stage]');
        if (!iframe || !frame || !stage) { return; }

        var vw = itemVw(item);
        var scale = Math.min(1, frame.clientWidth / vw);
        var minH = parseInt(iframe.getAttribute('data-min-h'), 10) || 0;
        var h = Math.max(parseInt(iframe.getAttribute('data-content-h'), 10) || 600, minH);

        iframe.style.width = vw + 'px';
        iframe.style.height = h + 'px';
        stage.style.width = Math.round(vw * scale) + 'px';
        stage.style.height = Math.round(h * scale) + 'px';
        iframe.style.transform = 'scale(' + scale + ')';
    }

    function contentHeight(doc) {
        /* высота содержимого, а не вьюпорта кадра: html/body растут по контенту */
        var b = doc.body;
        if (!b) { return 0; }
        return Math.ceil(b.getBoundingClientRect().height);
    }

    function bindFrame(item) {
        var iframe = item.querySelector('iframe');
        var ro = null;

        function update() {
            var doc;
            try { doc = iframe.contentDocument; } catch (e) { return; }
            if (!doc || !doc.body) { return; }
            var h = contentHeight(doc);
            if (h > 0 && String(h) !== iframe.getAttribute('data-content-h')) {
                iframe.setAttribute('data-content-h', String(h));
                measure(item);
            }
        }

        iframe.addEventListener('load', function () {
            if (!iframe.getAttribute('src') || iframe.getAttribute('src') === 'about:blank') { return; }
            update();
            var doc;
            try { doc = iframe.contentDocument; } catch (e) { return; }
            if (!doc || !doc.body) { return; }
            if (ro) { ro.disconnect(); }
            if (typeof iframe.contentWindow.ResizeObserver === 'function') {
                ro = new iframe.contentWindow.ResizeObserver(update);
                ro.observe(doc.body);
            }
            /* поздние картинки/шрифты/слайдеры */
            setTimeout(update, 600);
            setTimeout(update, 1800);
        });

        iframe.__blokiStop = function () { if (ro) { ro.disconnect(); ro = null; } };
    }

    function loadFrame(item) {
        var iframe = item.querySelector('iframe');
        if (!iframe || iframe.getAttribute('src')) { return; }
        iframe.setAttribute('src', iframe.getAttribute('data-src'));
    }

    function unloadFrame(item) {
        var iframe = item.querySelector('iframe');
        if (!iframe || !iframe.getAttribute('src')) { return; }
        if (iframe.__blokiStop) { iframe.__blokiStop(); }
        iframe.removeAttribute('src'); /* about:blank: высота stage остаётся прежней */
    }

    function setGlobal(vw) {
        globalVw = vw;
        document.querySelectorAll('[data-bloki-switch] [data-vw]').forEach(function (btn) {
            var on = parseInt(btn.getAttribute('data-vw'), 10) === vw;
            btn.classList.toggle('is-active', on);
            btn.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        items.forEach(function (item) {
            item.removeAttribute('data-vw');
            item.querySelectorAll('[data-item-vw]').forEach(function (b) { b.classList.remove('is-active'); });
            measure(item);
        });
    }

    function setItem(item, vw) {
        item.setAttribute('data-vw', String(vw));
        item.querySelectorAll('[data-item-vw]').forEach(function (b) {
            b.classList.toggle('is-active', parseInt(b.getAttribute('data-item-vw'), 10) === vw);
        });
        measure(item);
    }

    document.querySelectorAll('[data-bloki-switch] [data-vw]').forEach(function (btn) {
        btn.addEventListener('click', function () { setGlobal(parseInt(btn.getAttribute('data-vw'), 10)); });
    });

    items.forEach(function (item) {
        bindFrame(item);
        item.querySelectorAll('[data-item-vw]').forEach(function (btn) {
            btn.addEventListener('click', function () { setItem(item, parseInt(btn.getAttribute('data-item-vw'), 10)); });
        });
        measure(item);
    });

    /* Ленивая загрузка: ближняя зона — грузим, дальняя — выгружаем. */
    /* Наблюдатели стартуют после load самой страницы каталога: кадры не задерживают её загрузку. */
    function startLazy() {
        if ('IntersectionObserver' in window) {
            var near = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) { if (e.isIntersecting) { loadFrame(e.target); } });
            }, { rootMargin: LOAD_MARGIN });
            var far = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) { if (!e.isIntersecting) { unloadFrame(e.target); } });
            }, { rootMargin: UNLOAD_MARGIN });
            items.forEach(function (item) { near.observe(item); far.observe(item); });
        } else {
            items.forEach(loadFrame);
        }
    }
    if (document.readyState === 'complete') {
        startLazy();
    } else {
        window.addEventListener('load', startLazy, { once: true });
    }

    /* Каталог уникальных блоков: переключатель вариантов меняет кадр (и ссылки) без перезагрузки каталога;
       ширина кадра — текущая для блока. */
    items.forEach(function (item) {
        var iframe = item.querySelector('iframe');
        item.querySelectorAll('[data-variant-src]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (btn.classList.contains('is-active')) { return; }
                item.querySelectorAll('[data-variant-src]').forEach(function (b) {
                    var on = b === btn;
                    b.classList.toggle('is-active', on);
                    b.setAttribute('aria-pressed', on ? 'true' : 'false');
                });
                var src = btn.getAttribute('data-variant-src');
                var minH = btn.getAttribute('data-variant-min-h');
                var loaded = !!iframe.getAttribute('src');
                if (iframe.__blokiStop) { iframe.__blokiStop(); }
                iframe.removeAttribute('data-content-h');
                if (minH && minH !== '0') { iframe.setAttribute('data-min-h', minH); } else { iframe.removeAttribute('data-min-h'); }
                iframe.setAttribute('data-src', src);
                if (loaded) { iframe.setAttribute('src', src); }
                var pageLink = item.querySelector('[data-bloki-page-link]');
                var frameLink = item.querySelector('[data-bloki-frame-link]');
                if (pageLink) { pageLink.setAttribute('href', btn.getAttribute('data-variant-page')); }
                if (frameLink) { frameLink.setAttribute('href', src); }
                measure(item);
            });
        });
    });

    var raf = 0;
    window.addEventListener('resize', function () {
        cancelAnimationFrame(raf);
        raf = requestAnimationFrame(function () { items.forEach(measure); });
    });

    /* Кнопки без кадра: модалки сайта и cookie-баннер (в каталоге они скрыты по умолчанию). */
    document.querySelectorAll('[data-bloki-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (window.MicroModal) { window.MicroModal.show(btn.getAttribute('data-bloki-modal')); }
        });
    });
    document.querySelectorAll('[data-bloki-cookie]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var banner = document.getElementById('cookieBanner');
            if (!banner) { return; }
            var on = !document.body.classList.contains('bloki-show-cookie');
            document.body.classList.toggle('bloki-show-cookie', on);
            banner.classList.toggle('cookie-banner--visible', on);
        });
    });
})();
