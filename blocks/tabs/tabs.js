(function () {
  function initTabs(root) {
    const tabs = Array.from(root.querySelectorAll('[data-tab]'));
    const panels = Array.from(root.querySelectorAll('[data-tab-panel]'));
    if (!tabs.length || !panels.length) return;

    // Верхние стрелки (в заголовках)
    const topPrev = root.querySelector('.tabs__titles-arrow-prev');
    const topNext = root.querySelector('.tabs__titles-arrow-next');
    const topDisabledClass = 'tabs__titles-arrow-disabled';

    // Нижние стрелки
    const bottomPrev = root.querySelector('.tabs__arrow-prev');
    const bottomNext = root.querySelector('.tabs__arrow-next');
    const bottomDisabledClass = 'tabs__arrow-disabled';

    // Блок заголовков — к нему будем скроллить
    const titlesBlock = root.querySelector('.tabs__titles-block');

    function clampIndex(i) {
      return Math.max(0, Math.min(i, tabs.length - 1));
    }

    function getActiveIndex() {
      const idx = tabs.findIndex((t) => t.classList.contains('is-active'));
      return idx >= 0 ? idx : 0;
    }

    function updateArrow(el, disabledClass, isDisabled) {
      if (!el) return;
      el.classList.toggle(disabledClass, isDisabled);
    }

    function updateArrows(index) {
      const isFirst = index <= 0;
      const isLast = index >= tabs.length - 1;

      // Верхние
      updateArrow(topPrev, topDisabledClass, isFirst);
      updateArrow(topNext, topDisabledClass, isLast);

      // Нижние
      updateArrow(bottomPrev, bottomDisabledClass, isFirst);
      updateArrow(bottomNext, bottomDisabledClass, isLast);
    }

    function setActive(index, focus = false) {
      const safeIndex = clampIndex(index);

      tabs.forEach((tab, i) => {
        const isActive = i === safeIndex;
        tab.classList.toggle('is-active', isActive);
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        tab.tabIndex = isActive ? 0 : -1;
        if (focus && isActive) tab.focus();
      });

      panels.forEach((panel, i) => {
        const isActive = i === safeIndex;
        panel.classList.toggle('is-active', isActive);
        if (isActive) panel.removeAttribute('hidden');
        else panel.setAttribute('hidden', '');
      });

      updateArrows(safeIndex);
    }

    function scrollToTitles() {
      const target = titlesBlock || root;
      const offset = 100; // на 100px выше из-за фикс. меню

      const top = target.getBoundingClientRect().top + window.pageYOffset - offset;

      window.scrollTo({
        top: Math.max(0, top),
        behavior: 'smooth',
      });
    }

    // Инициализация (уважаем aria-selected, если вдруг не 0)
    const initial = tabs.findIndex((t) => t.getAttribute('aria-selected') === 'true');
    setActive(initial >= 0 ? initial : 0);

    // Универсальная обработка кликов по стрелкам
    // + опциональный колбэк (например, скролл после нижних стрелок)
    function handleArrowClick(target, prevSel, nextSel, disabledClass, afterChange) {
      const prev = target.closest(prevSel);
      if (prev && root.contains(prev)) {
        if (prev.classList.contains(disabledClass)) return true;
        setActive(getActiveIndex() - 1, false);
        if (typeof afterChange === 'function') afterChange();
        return true;
      }

      const next = target.closest(nextSel);
      if (next && root.contains(next)) {
        if (next.classList.contains(disabledClass)) return true;
        setActive(getActiveIndex() + 1, false);
        if (typeof afterChange === 'function') afterChange();
        return true;
      }

      return false;
    }

    root.addEventListener('click', (e) => {
      // Клик по табу
      const tabBtn = e.target.closest('[data-tab]');
      if (tabBtn && root.contains(tabBtn)) {
        const index = Number(tabBtn.getAttribute('data-tab-index'));
        if (!Number.isNaN(index)) setActive(index, false);
        return;
      }

      // Клик по верхним стрелкам — БЕЗ скролла
      if (
        handleArrowClick(
          e.target,
          '.tabs__titles-arrow-prev',
          '.tabs__titles-arrow-next',
          topDisabledClass
        )
      ) {
        return;
      }

      // Клик по нижним стрелкам — СО скроллом вверх к заголовкам
      handleArrowClick(
        e.target,
        '.tabs__arrow-prev',
        '.tabs__arrow-next',
        bottomDisabledClass,
        scrollToTitles
      );
    });

    // Клавиатура: стрелки влево/вправо (без цикличности)
    root.addEventListener('keydown', (e) => {
      const current = e.target.closest('[data-tab]');
      if (!current) return;

      if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
      e.preventDefault();

      const index = Number(current.getAttribute('data-tab-index'));
      if (Number.isNaN(index)) return;

      const nextIndex = e.key === 'ArrowRight' ? index + 1 : index - 1;
      setActive(nextIndex, true);
    });
  }

  function boot() {
    document.querySelectorAll('[data-tabs]').forEach(initTabs);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
