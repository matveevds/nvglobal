/**
 * ============================================================
 * form.js
 * ============================================================
 * Здесь находится:
 * - валидация форм
 * - очистка полей
 * - работа с hCaptcha
 * - AJAX-отправка формы
 * - кастомный select "How can we help you?"
 * - кастомное поле телефона
 *
 * ВАЖНО:
 * Функции initPhoneFields / initHelpSelect / initContactsForms
 * экспортируются в window, чтобы их можно было вызывать из main.js
 * после открытия GLightbox.
 * ============================================================
 */

(() => {
  const FORM_SELECTOR = '.contacts__form';
  const AJAX_URL = '/wp-admin/admin-ajax.php';
  const ACTION = 'send_contacts_form';
  const HCAPTCHA_SITEKEY = window.HCAPTCHA_SITEKEY || '';
  const USE_CAPTCHA = window.__USE_CAPTCHA__ === true;
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    function isCaptchaEnabled() {
      return window.__USE_CAPTCHA__ === true;
    }
  /**
   * ------------------------------------------------------------
   * Защита от повторной инициализации
   * ------------------------------------------------------------
   */
  const phoneInitedRoots = new WeakSet();
  const phoneInitedContainers = new WeakSet();

  const helpInitedRoots = new WeakSet();
  const helpInitedContainers = new WeakSet();

  const formsInited = new WeakSet();

  /**
   * ------------------------------------------------------------
   * Получение cookie
   * ------------------------------------------------------------
   */
  function getCookie(name) {
    const match = document.cookie.match(
      new RegExp('(?:^|; )' + name.replace(/[.$?*|{}()[\]\\/+^]/g, '\\$&') + '=([^;]*)')
    );

    return match ? decodeURIComponent(match[1]) : '';
  }

  /**
   * ------------------------------------------------------------
   * Получение всех форм
   * ------------------------------------------------------------
   */
  function getForms(root = document) {
    return Array.from(root.querySelectorAll(FORM_SELECTOR));
  }

  /**
   * ------------------------------------------------------------
   * Базовая нормализация форм
   * ------------------------------------------------------------
   * - назначаем data-form-id
   * - делаем submit-кнопку активной
   * - приводим clear-кнопки к type="button"
   * - назначаем id для textarea
   * ------------------------------------------------------------
   */
  function normalizeForms(root = document) {
    getForms(root).forEach((form, index) => {
      const formId = form.dataset.formId || `contacts-form-${index + 1}`;
      form.dataset.formId = formId;

      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('btn--disabled');
        submitBtn.removeAttribute('aria-disabled');
      }

      form.querySelectorAll('.input-form-clear').forEach((btn) => {
        btn.setAttribute('type', 'button');
      });

      form.querySelectorAll('textarea').forEach((textarea, textareaIndex) => {
        if (!textarea.id) {
          textarea.id = `${formId}-textarea-${textareaIndex + 1}`;
        }
      });
    });
  }

  /**
   * ------------------------------------------------------------
   * Вспомогательные функции для ошибок
   * ------------------------------------------------------------
   */
  function getFieldWrapper(field) {
    return field?.closest('.input-form-item') || null;
  }

  function getErrorBox(wrapper) {
    return wrapper?.querySelector('.input-form-error') || null;
  }

  function getErrorText(wrapper) {
    return wrapper?.querySelector('.input-form-error-text') || null;
  }

  function showError(wrapper, message) {
    if (!wrapper) return;

    const errorBox = getErrorBox(wrapper);
    const errorText = getErrorText(wrapper);

    if (errorText) {
      errorText.textContent = message;
    }

    if (errorBox) {
      errorBox.style.display = 'flex';
    }

    wrapper.classList.add('is-error');
  }

  function clearError(wrapper) {
    if (!wrapper) return;

    const errorBox = getErrorBox(wrapper);
    const errorText = getErrorText(wrapper);

    if (errorText) {
      errorText.textContent = '';
    }

    if (errorBox) {
      errorBox.style.display = '';
    }

    wrapper.classList.remove('is-error');
  }

  function clearFormErrors(form) {
    form.querySelectorAll('.input-form-item').forEach(clearError);
  }

  /**
   * ------------------------------------------------------------
   * Состояние кнопки submit
   * ------------------------------------------------------------
   */
  function startButtonLoading(button) {
    if (!button) return;

    const text = button.querySelector('.btn__text');
    if (!text) return;

    button.disabled = true;
    button.classList.add('is-loading');
    button.dataset.originalText = text.textContent;

    let dots = 0;
    text.textContent = 'Sending';

    const timerId = setInterval(() => {
      dots = (dots + 1) % 4;
      text.textContent = 'Sending' + '.'.repeat(dots);
    }, 350);

    button.dataset.timerId = String(timerId);
  }

  function stopButtonLoading(button) {
    if (!button) return;

    const text = button.querySelector('.btn__text');
    const timerId = Number(button.dataset.timerId);

    if (timerId) {
      clearInterval(timerId);
    }

    if (text) {
      text.textContent = button.dataset.originalText || 'Get Started';
    }

    button.disabled = false;
    button.classList.remove('is-loading');

    delete button.dataset.originalText;
    delete button.dataset.timerId;
  }

  /**
   * ------------------------------------------------------------
   * Санитайзеры
   * ------------------------------------------------------------
   */
  function sanitizeName(value) {
    return value.replace(/[^a-zA-Z\s'-]/g, '');
  }

  function sanitizeEmail(value) {
    let next = value.replace(/[^a-zA-Z0-9@._\-+]/g, '');
    const atCount = (next.match(/@/g) || []).length;

    if (atCount > 1) {
      const firstAt = next.indexOf('@');
      next = next.slice(0, firstAt + 1) + next.slice(firstAt + 1).replace(/@/g, '');
    }

    return next;
  }

  function sanitizePhone(value) {
    let next = value.replace(/[^\d\s()+\-]/g, '');
    next = next.replace(/\s{2,}/g, ' ');
    return next.slice(0, 30);
  }

  /**
   * ------------------------------------------------------------
   * Управление clear-кнопкой для поля
   * ------------------------------------------------------------
   */
  function updateClearButtonState(field) {
    const wrapper = field.closest('.input-form-block, .phone-field__control');
    if (!wrapper) return;

    const clearBtn = wrapper.querySelector('.input-form-clear, .phone-field__clear');
    if (!clearBtn) return;

    const hasValue = !!field.value.trim();
    clearBtn.classList.toggle('input-form-clear--disabled', !hasValue);
    clearBtn.disabled = !hasValue;
  }

  /**
   * ------------------------------------------------------------
   * Help select: состояние clear-кнопки
   * ------------------------------------------------------------
   */
  function updateHelpSelectClearState(selectRoot) {
    if (!selectRoot) return;

    const hiddenInput = selectRoot.querySelector('[data-help-select-hidden]');
    const clearBtn = selectRoot.querySelector('.input-form-clear');

    if (!hiddenInput || !clearBtn) return;

    const hasValue = !!hiddenInput.value.trim();
    clearBtn.classList.toggle('input-form-clear--disabled', !hasValue);
    clearBtn.disabled = !hasValue;
  }

  /**
   * ------------------------------------------------------------
   * Help select: установка значения
   * ------------------------------------------------------------
   */
  function setHelpSelectValue(selectRoot, value) {
    const hiddenInput = selectRoot.querySelector('[data-help-select-hidden]');
    const placeholder = selectRoot.querySelector('[data-help-select-placeholder]');
    const valueBox = selectRoot.querySelector('[data-help-select-value]');
    const dropdown = selectRoot.querySelector('[data-help-select-dropdown]');
    const button = selectRoot.querySelector('[data-help-select-button]');

    if (!hiddenInput || !placeholder || !valueBox) return;

    hiddenInput.value = value || '';

    if (value) {
      placeholder.hidden = true;
      valueBox.hidden = false;
      valueBox.textContent = value;
    } else {
      placeholder.hidden = false;
      valueBox.hidden = true;
      valueBox.textContent = '';
    }

    if (dropdown) {
      dropdown.hidden = true;
    }

    if (button) {
      button.setAttribute('aria-expanded', 'false');
    }

    updateHelpSelectClearState(selectRoot);
  }

  /**
   * ------------------------------------------------------------
   * Проверка: нужен ли help select в форме
   * ------------------------------------------------------------
   */
  function isHelpSelectRequired(form) {
    return !!form.querySelector('[data-help-select]');
  }

  /**
   * ------------------------------------------------------------
   * Валидация формы
   * ------------------------------------------------------------
   */
  function validateForm(form) {
    let isValid = true;
    clearFormErrors(form);

    const nameInput = form.querySelector('input[name="clientName"]');
    const companyInput = form.querySelector('input[name="clientCompany"]');
    const emailInput = form.querySelector('input[name="clientEmail"]');
    const phoneInput = form.querySelector('input[name="clientPhone"]');
    const messageInput = form.querySelector('textarea[name="clientMessage"]');
    const privacyInput = form.querySelector('input[name="privacyConsent"]');
    const optionInput = form.querySelector('input[name="clientOption"]');

    if (nameInput) {
      const wrapper = getFieldWrapper(nameInput);

      if (!nameInput.value.trim()) {
        isValid = false;
        showError(wrapper, 'Please enter your name');
      } else if (nameInput.value.trim().length < 2) {
        isValid = false;
        showError(wrapper, 'Please enter a valid name');
      }
    }

    if (companyInput) {
      const wrapper = getFieldWrapper(companyInput);

      if (companyInput.value.trim() && companyInput.value.trim().length < 2) {
        isValid = false;
        showError(wrapper, 'Please enter a valid company name');
      }
    }

    if (emailInput) {
      const wrapper = getFieldWrapper(emailInput);
      const value = emailInput.value.trim();

      if (!value) {
        isValid = false;
        showError(wrapper, 'Please enter your e-mail');
      } else if (!emailPattern.test(value)) {
        isValid = false;
        showError(wrapper, 'Please enter a valid e-mail');
      }
    }

    // if (phoneInput) {
    //   const wrapper = getFieldWrapper(phoneInput);
    //   const digits = phoneInput.value.replace(/\D/g, '');

    //   if (!digits) {
    //     isValid = false;
    //     showError(wrapper, 'Please enter your phone number');
    //   } else if (digits.length < 6) {
    //     isValid = false;
    //     showError(wrapper, 'Please enter a valid phone');
    //   }
    // }

    if (messageInput && messageInput.value.trim().length > 2000) {
      isValid = false;
      showError(getFieldWrapper(messageInput), 'Message is too long');
    }

    if (isHelpSelectRequired(form) && optionInput) {
      const wrapper = getFieldWrapper(optionInput) || optionInput.closest('.input-form-item');

      if (!optionInput.value.trim()) {
        isValid = false;
        showError(wrapper, 'Please select an option');
      }
    }

    if (privacyInput) {
      const wrapper = getFieldWrapper(privacyInput) || privacyInput.closest('.input-form-item');

      if (!privacyInput.checked) {
        isValid = false;
        showError(wrapper, 'Please accept the privacy policy');
      }
    }

    return isValid;
  }

  /**
   * ------------------------------------------------------------
   * hCaptcha: состояние
   * ------------------------------------------------------------
   */
  function getCaptchaState(form) {
      if (!form._captchaState) {
        form._captchaState = {
          widgetId: null,
          awaiting: false,
          submitting: false,
          token: ''
        };
      }
    
      return form._captchaState;
    }

  function waitForHcaptchaReady() {
    return new Promise((resolve) => {
      if (window.hcaptcha && window.__HCAPTCHA_READY__) {
        resolve();
        return;
      }

      document.addEventListener('hcaptcha:ready', resolve, { once: true });
    });
  }

  async function ensureCaptchaRendered(form) {
      const state = getCaptchaState(form);
      const holder = form.querySelector('.captcha-holder');
    
      if (!isCaptchaEnabled() || !HCAPTCHA_SITEKEY) return;
      if (!holder || state.widgetId !== null) return;
    
      await waitForHcaptchaReady();
    
      holder.innerHTML = '<div class="contacts-form__captcha-widget"></div>';
      const widgetEl = holder.querySelector('.contacts-form__captcha-widget');
    
      state.widgetId = window.hcaptcha.render(widgetEl, {
        sitekey: HCAPTCHA_SITEKEY,
    
        callback: (token) => {
          state.awaiting = false;
          state.token = token || '';
          submitForm(form);
        },
    
        'expired-callback': () => {
          state.token = '';
    
          const wrapper =
            form.querySelector('.captcha-holder')?.closest('.input-form-item') ||
            form.querySelector('.input-form-item:last-child');
    
          if (wrapper) {
            showError(wrapper, 'Captcha expired. Please verify again.');
          }
        },
    
        'error-callback': () => {
          state.token = '';
    
          const wrapper =
            form.querySelector('.captcha-holder')?.closest('.input-form-item') ||
            form.querySelector('.input-form-item:last-child');
    
          if (wrapper) {
            showError(wrapper, 'Captcha error. Please try again.');
          }
        }
      });
    }

    async function preloadCaptcha(form) {
      const holder = form.querySelector('.captcha-holder');
      if (!holder) return;
    
      if (!isCaptchaEnabled() || !HCAPTCHA_SITEKEY) {
        holder.style.display = 'none';
        return;
      }
    
      holder.style.display = '';
      holder.classList.add('captcha-holder--preload');
      holder.classList.remove('captcha-holder--visible');
    
      await ensureCaptchaRendered(form);
    }

    async function showCaptcha(form) {
      const holder = form.querySelector('.captcha-holder');
      if (!holder) return;
    
      if (!isCaptchaEnabled() || !HCAPTCHA_SITEKEY) {
        holder.style.display = 'none';
        return;
      }
    
      holder.style.display = '';
      holder.classList.remove('captcha-holder--preload');
      holder.classList.add('captcha-holder--visible');
    
      await new Promise((resolve) => requestAnimationFrame(resolve));
      await ensureCaptchaRendered(form);
    }

    function hideCaptcha(form) {
      const holder = form.querySelector('.captcha-holder');
      if (!holder) return;
    
      if (!isCaptchaEnabled() || !HCAPTCHA_SITEKEY) {
        holder.style.display = 'none';
        return;
      }
    
      holder.classList.add('captcha-holder--preload');
      holder.classList.remove('captcha-holder--visible');
    }

    function resetCaptcha(form) {
      const state = getCaptchaState(form);
      state.token = '';
    
      if (state.widgetId !== null && window.hcaptcha) {
        try {
          window.hcaptcha.reset(state.widgetId);
        } catch (e) {}
      }
    }

  function hasCaptchaToken(form) {
    const state = getCaptchaState(form);

    if (state.widgetId !== null && window.hcaptcha) {
      try {
        const token = window.hcaptcha.getResponse(state.widgetId);
        return !!(token && token.trim());
      } catch (e) {
        return false;
      }
    }

    const tokenField = form.querySelector('textarea[name="h-captcha-response"]');
    return !!(tokenField && tokenField.value.trim());
  }

  /**
   * ------------------------------------------------------------
   * AJAX-отправка формы
   * ------------------------------------------------------------
   */
  async function submitForm(form) {
      const state = getCaptchaState(form);
      if (state.submitting) return;
    
      state.submitting = true;
    
      const submitButton = form.querySelector('button[type="submit"]');
      startButtonLoading(submitButton);
    
      const formData = new FormData(form);

      const phoneField = form.querySelector('[data-phone-field]');
      if (phoneField) {
          const codeSpan = phoneField.querySelector('[data-phone-field-code]');
          if (codeSpan) {
              let code = codeSpan.textContent.trim();
              // можно добавить как отдельное поле, либо модифицировать clientPhone
              formData.append('clientPhoneCode', code);
          }
      }

      formData.append('action', ACTION);
      formData.append('form_id', form.dataset.formId || '');
      formData.append('ym_uid', getCookie('_ym_uid') || '');
    
      const captchaToken =
        state.token ||
        (state.widgetId !== null && window.hcaptcha
          ? window.hcaptcha.getResponse(state.widgetId)
          : '');
    
      if (captchaToken) {
        formData.set('h-captcha-response', captchaToken);
      }
    
      try {
        const response = await fetch(AJAX_URL, {
          method: 'POST',
          body: formData
        });
    
        const text = await response.text();
    
        let data;
        try {
          data = JSON.parse(text);
        } catch (e) {
          throw new Error('INVALID_JSON');
        }
    
        if (!response.ok) {
          throw new Error(data?.message || 'HTTP_ERROR');
        }
    
        if (!data.success) {
          throw new Error(data?.data?.message || data?.message || 'SERVER_ERROR');
        }
    
        form.reset();
        clearFormErrors(form);
        resetCaptcha(form);
        hideCaptcha(form);
    
        form.querySelectorAll('.input-form, .phone-field__input, textarea').forEach((field) => {
          updateClearButtonState(field);
        });
    
        form.querySelectorAll('[data-help-select]').forEach((selectRoot) => {
          setHelpSelectValue(selectRoot, '');
        });
    
        if (typeof MicroModal !== 'undefined') {
          const parentModal = form.closest('.modal[aria-hidden="false"], .modal.is-open');
          if (parentModal?.id) {
            MicroModal.close(parentModal.id);
          }
    
          MicroModal.show('thanks');
        }
      } catch (error) {
        console.error(error);
    
        resetCaptcha(form);
    
        const wrapper =
          form.querySelector('.captcha-holder')?.closest('.input-form-item') ||
          form.querySelector('.input-form-item:last-child');
    
        if (String(error.message).includes('INVALID_JSON')) {
          showError(wrapper, 'Server error. Please try again later.');
        } else if (String(error.message).includes('Failed to fetch')) {
          showError(wrapper, 'Network error. Please check your connection and try again.');
        } else if (error.message) {
          showError(wrapper, error.message);
        } else {
          showError(wrapper, 'Unable to submit the form. Please try again later.');
        }
    
        if (typeof MicroModal !== 'undefined') {
          const parentModal = form.closest('.modal[aria-hidden="false"], .modal.is-open');
          if (parentModal?.id) {
            MicroModal.close(parentModal.id);
          }
    
          MicroModal.show('error');
        }
      } finally {
        state.submitting = false;
        stopButtonLoading(submitButton);
      }
    }

  /**
   * ------------------------------------------------------------
   * Инициализация телефонных полей
   * ------------------------------------------------------------
   */
  window.initPhoneFields = function (container = document) {
    const phoneFields = container.querySelectorAll('[data-phone-field]');
    const instances = [];

    phoneFields.forEach((root) => {
      if (phoneInitedRoots.has(root)) return;
      phoneInitedRoots.add(root);

      const btn = root.querySelector('.phone-field__country-btn');
      const dropdown = root.querySelector('[data-phone-field-dropdown]');
      const codeEl = root.querySelector('[data-phone-field-code]');
      const options = Array.from(root.querySelectorAll('.phone-field__option'));
      const search = root.querySelector('[data-phone-field-search]');
      const empty = root.querySelector('[data-phone-field-empty]');
      const phoneInput = root.querySelector('[data-phone-field-input]');

      if (!btn || !dropdown || !codeEl || !options.length || !search) return;

      dropdown.hidden = true;
      btn.setAttribute('aria-expanded', 'false');

      const normalize = (v) => String(v || '').trim().toLowerCase();

      const filter = (query) => {
        const q = normalize(query);
        const qDial = normalize(q.replace('+', ''));
        let shown = 0;

        options.forEach((opt) => {
          const name = normalize(opt.dataset.name);
          const dial = normalize(opt.dataset.dial);

          const match =
            !q ||
            name.includes(q) ||
            dial.includes(qDial) ||
            (`+${dial}`).includes(q);

          opt.hidden = !match;
          if (match) shown += 1;
        });

        if (empty) {
          empty.hidden = shown !== 0;
        }

        options.forEach((opt) => {
          opt.tabIndex = opt.hidden ? -1 : 0;
        });
      };

      const open = () => {
        dropdown.hidden = false;
        btn.setAttribute('aria-expanded', 'true');
        filter(search.value);
        search.focus({ preventScroll: true });
      };

      const close = () => {
        dropdown.hidden = true;
        btn.setAttribute('aria-expanded', 'false');
        search.value = '';
        filter('');
      };

      const toggle = () => (dropdown.hidden ? open() : close());

      const setSelectedDial = (dial) => {
        codeEl.textContent = String(dial);
        close();
        phoneInput?.focus?.({ preventScroll: true });
      };

      const syncClearState = () => {
        if (!phoneInput) return;
        root.classList.toggle('phone-field--has-value', phoneInput.value.length > 0);
      };

      filter('');
      syncClearState();

      root.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('.phone-field__country-btn');
        if (toggleBtn && root.contains(toggleBtn)) return toggle();

        const opt = e.target.closest('.phone-field__option');
        if (opt && root.contains(opt) && !opt.hidden) {
          const dial = opt.dataset.dial;
          if (dial) setSelectedDial(dial);
          return;
        }

        const clearBtn = e.target.closest('[data-phone-field-clear]');
        if (clearBtn && root.contains(clearBtn) && phoneInput) {
          phoneInput.value = '';
          syncClearState();
          phoneInput.focus({ preventScroll: true });
        }
      });

      search.addEventListener('input', (e) => filter(e.target.value));
      phoneInput?.addEventListener('input', syncClearState);

      instances.push({ root, dropdown, close });
    });

    if (!phoneInitedContainers.has(container)) {
      phoneInitedContainers.add(container);

      container.addEventListener('pointerdown', (e) => {
        instances.forEach(({ root, dropdown, close }) => {
          if (dropdown.hidden) return;
          if (!root.contains(e.target)) close();
        });
      });
    }
  };

  /**
   * ------------------------------------------------------------
   * Инициализация кастомного select
   * ------------------------------------------------------------
   */
  window.initHelpSelect = function (container = document) {
    const selects = container.querySelectorAll('[data-help-select]');

    selects.forEach((root) => {
      if (helpInitedRoots.has(root)) return;
      helpInitedRoots.add(root);

      const button = root.querySelector('[data-help-select-button]');
      const dropdown = root.querySelector('[data-help-select-dropdown]');
      const options = Array.from(root.querySelectorAll('.help-select__option'));
      const placeholder = root.querySelector('[data-help-select-placeholder]');
      const valueEl = root.querySelector('[data-help-select-value]');
      const arrowBtn = root.querySelector('.help-select__arrow');
      const hiddenInput = root.querySelector('[data-help-select-hidden]');

      if (!button || !dropdown || !options.length) return;

      const isOpen = () => dropdown.hidden === false;

      const setSelected = (index) => {
        const opt = options[index];
        const val = opt.dataset.value || opt.textContent.trim();

        options.forEach((o, i) => o.setAttribute('aria-selected', String(i === index)));

        if (placeholder) placeholder.hidden = true;
        if (valueEl) {
          valueEl.hidden = false;
          valueEl.textContent = val;
        }
        if (hiddenInput) {
          hiddenInput.value = val;
        }

        root.classList.add('help-select--has-value');
      };

      const clearSelected = () => {
        options.forEach((o) => o.setAttribute('aria-selected', 'false'));

        if (placeholder) placeholder.hidden = false;
        if (valueEl) {
          valueEl.hidden = true;
          valueEl.textContent = '';
        }
        if (hiddenInput) {
          hiddenInput.value = '';
        }

        root.classList.remove('help-select--has-value');
      };

      const open = () => {
        dropdown.hidden = false;
        root.classList.add('help-select--open');
        options.forEach((o) => (o.tabIndex = -1));
        options[0].tabIndex = 0;
        options[0].focus({ preventScroll: true });
      };

      const close = () => {
        dropdown.hidden = true;
        root.classList.remove('help-select--open');
        options.forEach((o) => (o.tabIndex = -1));
      };

      const toggle = () => (isOpen() ? close() : open());

      clearSelected();

      root.addEventListener('click', (e) => {
        if (e.target.closest('[data-help-select-button]') || e.target.closest('.help-select__arrow')) {
          return toggle();
        }

        const opt = e.target.closest('.help-select__option');
        if (opt) {
          const idx = options.indexOf(opt);
          if (idx !== -1) setSelected(idx);
          close();
          button.focus({ preventScroll: true });
          return;
        }

        const clearBtn = e.target.closest('.input-form-clear');
        if (clearBtn && root.contains(clearBtn)) {
          e.preventDefault();
          clearSelected();
          close();
          button.focus({ preventScroll: true });
        }
      });

      if (arrowBtn) {
        arrowBtn.tabIndex = -1;
      }
    });

    if (!helpInitedContainers.has(container)) {
      helpInitedContainers.add(container);

      container.addEventListener('click', (e) => {
        const opened = container.querySelectorAll('[data-help-select].help-select--open');
        if (!opened.length) return;

        opened.forEach((root) => {
          if (root.contains(e.target)) return;

          const dropdown = root.querySelector('[data-help-select-dropdown]');
          if (dropdown) dropdown.hidden = true;

          root.classList.remove('help-select--open');
        });
      });
    }
  };
  
  function getCaptchaErrorWrapper(form) {
      return form.querySelector('.privacy-consent')?.closest('.input-form-item') || form;
    }

  /**
   * ------------------------------------------------------------
   * Инициализация форм
   * ------------------------------------------------------------
   * Здесь:
   * - снимаем disabled с submit
   * - обновляем clear-кнопки
   * - вешаем обработчики
   * ------------------------------------------------------------
   */
    window.initContactsForms = function (container = document) {
      normalizeForms(container);
    
      const forms = container.querySelectorAll('form.contacts__form');
    
      forms.forEach((form) => {
        if (formsInited.has(form)) return;
        formsInited.add(form);
    
        form.querySelectorAll('.input-form, .phone-field__input, textarea').forEach((field) => {
          updateClearButtonState(field);
        });
    
        form.querySelectorAll('[data-help-select]').forEach((selectRoot) => {
          updateHelpSelectClearState(selectRoot);
        });
    
        const submitBtn = form.querySelector('button[type="submit"].btn-form');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.classList.remove('btn--disabled');
        }
    
        preloadCaptcha(form);
      });
    };

  /**
   * ------------------------------------------------------------
   * Глобальные обработчики событий
   * ------------------------------------------------------------
   */

  document.addEventListener('submit', async (e) => {
    const form = e.target.closest(FORM_SELECTOR);
    if (!form) return;

    e.preventDefault();

    const state = getCaptchaState(form);
    if (state.submitting) return;

    const isValid = validateForm(form);
    if (!isValid) return;

    if (!isCaptchaEnabled() || !HCAPTCHA_SITEKEY) {
      await submitForm(form);
      return;
    }
    
    if (!hasCaptchaToken(form)) {
      state.awaiting = true;
      await showCaptcha(form);
      return;
    }

    state.awaiting = false;
    await submitForm(form);
  });

  document.addEventListener('input', (e) => {
    const form = e.target.closest(FORM_SELECTOR);
    if (!form) return;

    if (e.target.name === 'clientName' || e.target.name === 'clientCompany') {
      e.target.value = sanitizeName(e.target.value);
    }

    if (e.target.name === 'clientEmail') {
      e.target.value = sanitizeEmail(e.target.value);
    }

    if (e.target.name === 'clientPhone') {
      e.target.value = sanitizePhone(e.target.value);
    }

    const wrapper = getFieldWrapper(e.target);
    if (wrapper) {
      clearError(wrapper);
    }

    updateClearButtonState(e.target);
  });

  document.addEventListener('change', (e) => {
    const form = e.target.closest(FORM_SELECTOR);
    if (!form) return;

    if (e.target.matches('input[name="privacyConsent"]')) {
      const wrapper = getFieldWrapper(e.target) || e.target.closest('.input-form-item');
      clearError(wrapper);
    }
  });

  document.addEventListener('click', (e) => {
    const clearButton = e.target.closest('.input-form-clear, [data-phone-field-clear]');
    if (!clearButton) return;

    if (clearButton.closest('[data-help-select]')) {
      return;
    }

    const phoneField = clearButton.closest('[data-phone-field]');
    if (phoneField) {
      const input = phoneField.querySelector('[data-phone-field-input]');
      if (input) {
        input.value = '';
        input.focus();
        updateClearButtonState(input);
        clearError(getFieldWrapper(input));
      }
      return;
    }

    const block = clearButton.closest('.input-form-block');
    if (!block) return;

    const field = block.querySelector('input, textarea');
    if (!field) return;

    field.value = '';
    field.focus();

    updateClearButtonState(field);
    clearError(getFieldWrapper(field));

    field.dispatchEvent(new Event('input', { bubbles: true }));
    field.dispatchEvent(new Event('change', { bubbles: true }));
  });
})();