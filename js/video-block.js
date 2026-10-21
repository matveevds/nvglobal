/*
 * Блок «Видео» (template-parts/video-section.php): «фасад» YouTube.
 * До клика на странице только постер и кнопка play — никакого iframe и запросов к YouTube. По клику / Enter / Space постер
 * подменяется iframe youtube.com/embed (autoplay) внутри той же рамки. Делегирование по `[data-nv-video]`: блоков на
 * странице может быть несколько. Без JS остаётся ссылка на ролик (прогрессивное улучшение).
 */
(function () {
    'use strict';

    var ID_RE = /^[A-Za-z0-9_-]{11}$/;

    /* Ссылка из разметки становится настоящей кнопкой (тот же класс и содержимое). */
    function upgradeLinks(root) {
        var links = (root || document).querySelectorAll('[data-nv-video] a.video-embed__play');
        Array.prototype.forEach.call(links, function (link) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = link.className;
            var label = link.getAttribute('aria-label');
            if (label) {
                btn.setAttribute('aria-label', label);
            }
            while (link.firstChild) {
                btn.appendChild(link.firstChild);
            }
            link.parentNode.replaceChild(btn, link);
        });
    }

    function play(frame) {
        if (!frame || frame.classList.contains('is-playing')) {
            return;
        }
        var id = frame.getAttribute('data-video-id') || '';
        if (!ID_RE.test(id)) {
            return;
        }
        var player = frame.querySelector('.video-embed__player');
        if (!player) {
            return;
        }
        var iframe = document.createElement('iframe');
        iframe.className = 'video-embed__iframe';
        iframe.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0&playsinline=1';
        iframe.title = frame.getAttribute('data-video-title') || 'Video';
        iframe.setAttribute('allow', 'autoplay; encrypted-media; picture-in-picture; fullscreen');
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
        player.appendChild(iframe);
        frame.classList.add('is-playing');
        iframe.focus();
    }

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest ? event.target.closest('[data-nv-video] .video-embed__play') : null;
        if (!trigger) {
            return;
        }
        event.preventDefault();
        play(trigger.closest('[data-nv-video]'));
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { upgradeLinks(); });
    } else {
        upgradeLinks();
    }
}());
