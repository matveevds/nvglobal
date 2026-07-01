document.addEventListener('DOMContentLoaded', function () {
    const I18N = Object.assign({
        documentLabel: 'DOCUMENT — Document Recognition',
        basicLabel: 'BASIC — Document + Selfie / Liveness',
        perDocument: 'per document',
        clear: 'Clear',
        selectAll: 'Select All',
        minimumVolume: 'Minimum volume — ',
        volumeAbove: 'Volume > ',
        priceOnRequest: ' — price on request',
        priceOnRequestValue: 'ON REQUEST',
        volumeAbovePriceOnRequest: 'For volumes above 100,000 checks, the price is available on request',
        volumeAboveRequestTitle: 'Quantity > 100,000 —<br>Price upon request',
        volumeAboveRequestText: 'Please contact a sales representative<br>for large orders.',
        minimumVolumeRequestTitle: 'Minimum 10,000',
        minimumVolumeRequestText: '',
        hiddenPrice: '$***',
        pricePerCheck: 'Price per Check',
        documents: 'Documents',
        checks: 'Checks',
        internationalScreening: 'International Screening',
        checksUnit: 'checks',
        includedInBase: 'included in the basic package',
        locale: 'en-US',
        currency: '$'
    }, window.kycCalculatorI18n || {});

    const root = document.querySelector('#kyc-calculator');
    if (!root) return;

    function parseCalculatorPrice(value, fallback) {
        const price = parseFloat(String(value || '').replace(',', '.'));

        return Number.isFinite(price) ? price : fallback;
    }

    const EXTRA_DOC_UNIT_PRICE = parseCalculatorPrice(root.dataset.docPrice, 0.13);
    const AML_INTERNATIONAL_PRICE = parseCalculatorPrice(root.dataset.internationalPrice, 0.40);

    const PKG = {
        DOCUMENT: {
            label: I18N.documentLabel,
            name: 'DOCUMENT',
            description: 'Document Recognition',
            USD: [[10000, 0.24], [50000, 0.22], [100000, 0.20]]
        },
        BASIC: {
            label: I18N.basicLabel,
            name: 'BASIC',
            description: 'Document + Selfie / Liveness',
            USD: [[10000, 0.44], [50000, 0.41], [100000, 0.39]]
        }
    };

    const EXTRA_DOC_PRICE = {
        USD: [[10000, EXTRA_DOC_UNIT_PRICE], [50000, EXTRA_DOC_UNIT_PRICE], [100000, EXTRA_DOC_UNIT_PRICE]]
    };

    const MIN_VOLUME = 10000;
    const MAX_VOLUME = 100000;
    const MID_VOLUME = 50000;
    const MID_RANGE_PROGRESS = 50;

    let selectedPackage = 'DOCUMENT';
    let selectedDocumentTypes = new Set(['passport']);

    const volumeRange = root.querySelector('#calculator-volume-range');
    const volumeRangeValue = root.querySelector('#calculator-volume-range-value');
    const volumeNumber = root.querySelector('#calculator-volume-number');
    const volumeStepButtons = root.querySelectorAll('.calculator-volume-step');

    const packageButtons = root.querySelectorAll('#calculator-package button');
    const documentTypeButtons = root.querySelectorAll('#calculator-document-type button');

    const extraDocumentCheckboxes = root.querySelectorAll('input[name="extra_documents[]"]');
    const internationalCheckbox = root.querySelector('#calculator-international-screening');

    const spoilers = root.querySelectorAll('.calculator__spoiler');
    const resultButtons = root.querySelectorAll('[data-calculator-trigger], .calculator__result-request .open-callForm2');
    const requestTitle = root.querySelector('.calculator__result-request-title');
    const requestText = root.querySelector('.calculator__result-request-text');

    function getSpoilerContent(spoiler) {
        return spoiler.querySelector('.calculator__spoiler-content');
    }

    function getSpoilerExpandedHeight(spoiler, content) {
        // const visualOverflow = spoiler.classList.contains('calculator__spoiler--base') ? 8 : 0;

        // return Math.max(0, content.scrollHeight - visualOverflow);
        return content.scrollHeight;
    }

    function setSpoilerState(spoiler, isOpen, animate) {
        const header = spoiler.querySelector('.calculator__spoiler-header');
        const content = getSpoilerContent(spoiler);
        const wasOpen = spoiler.classList.contains('calculator__spoiler--open');

        if (!content) return;

        if (!wasOpen && !isOpen) {
            content.style.height = '0px';

            if (header) {
                header.setAttribute('aria-expanded', 'false');
            }

            return;
        }

        if (isOpen) {
            const expandedHeight = getSpoilerExpandedHeight(spoiler, content);

            spoiler.classList.add('calculator__spoiler--open');
            content.style.height = animate && !wasOpen ? '0px' : expandedHeight + 'px';

            if (animate && !wasOpen) {
                requestAnimationFrame(function () {
                    content.style.height = getSpoilerExpandedHeight(spoiler, content) + 'px';
                });
            }
        } else {
            content.style.height = getSpoilerExpandedHeight(spoiler, content) + 'px';

            if (animate) {
                requestAnimationFrame(function () {
                    spoiler.classList.remove('calculator__spoiler--open');
                    content.style.height = '0px';
                });
            } else {
                spoiler.classList.remove('calculator__spoiler--open');
                content.style.height = '0px';
            }
        }

        if (header) {
            header.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
    }

    function updateOpenSpoilerHeights() {
        spoilers.forEach(function (spoiler) {
            const content = getSpoilerContent(spoiler);

            if (!content || !spoiler.classList.contains('calculator__spoiler--open')) return;

            content.style.height = getSpoilerExpandedHeight(spoiler, content) + 'px';
        });
    }

    function scheduleOpenSpoilerHeightsUpdate() {
        requestAnimationFrame(updateOpenSpoilerHeights);
    }

    function initSpoilers() {
        if (!spoilers.length) return;

        const firstOpenSpoiler = root.querySelector('.calculator__spoiler--open') || spoilers[0];

        spoilers.forEach(function (spoiler, index) {
            const header = spoiler.querySelector('.calculator__spoiler-header');
            const content = getSpoilerContent(spoiler);

            if (!header || !content) return;

            if (!content.id) {
                content.id = 'calculator-spoiler-content-' + index;
            }

            header.setAttribute('role', 'button');
            header.setAttribute('tabindex', '0');
            header.setAttribute('aria-controls', content.id);

            setSpoilerState(spoiler, spoiler === firstOpenSpoiler, false);

            header.addEventListener('click', function () {
                if (spoiler.classList.contains('calculator__spoiler--open')) return;

                spoilers.forEach(function (currentSpoiler) {
                    setSpoilerState(currentSpoiler, currentSpoiler === spoiler, true);
                });
            });

            header.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter' && event.key !== ' ') return;

                event.preventDefault();
                header.click();
            });

            content.addEventListener('transitionend', function (event) {
                if (event.propertyName !== 'height') return;

                updateOpenSpoilerHeights();
            });
        });

        window.addEventListener('resize', scheduleOpenSpoilerHeightsUpdate);

        if ('ResizeObserver' in window) {
            let lastRootWidth = root.getBoundingClientRect().width;
            const spoilerResizeObserver = new ResizeObserver(function (entries) {
                const nextRootWidth = entries[0].contentRect.width;

                if (Math.abs(nextRootWidth - lastRootWidth) < 1) return;

                lastRootWidth = nextRootWidth;
                scheduleOpenSpoilerHeightsUpdate();
            });

            spoilerResizeObserver.observe(root);
        }
    }

    function rateAt(points, volume) {
        if (volume <= points[0][0]) return points[0][1];
        if (volume >= points[points.length - 1][0]) return points[points.length - 1][1];

        for (let i = 0; i < points.length - 1; i++) {
            const [v1, r1] = points[i];
            const [v2, r2] = points[i + 1];

            if (volume >= v1 && volume <= v2) {
                return r1 + (r2 - r1) * (volume - v1) / (v2 - v1);
            }
        }

        return points[points.length - 1][1];
    }

    function formatMoney(value) {
        return I18N.currency + Math.round(value).toLocaleString(I18N.locale);
    }

    function formatRate(value) {
        return I18N.currency + Number(value).toLocaleString(I18N.locale, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 3
        });
    }

    function formatVolume(value) {
        return Math.round(value).toLocaleString(I18N.locale);
    }

    function parseVolumeValue(value) {
        const normalizedValue = String(value || '').replace(/[^\d]/g, '');

        if (normalizedValue === '') {
            return null;
        }

        const volume = parseInt(normalizedValue, 10);

        return Number.isNaN(volume) ? null : volume;
    }

    function roundVolumeToStep(value) {
        const step = parseInt(volumeNumber.step, 10) || 1000;

        return Math.round(value / step) * step;
    }

    function getRangeProgressByVolume(volume) {
        if (volume <= MIN_VOLUME) return 0;
        if (volume >= MAX_VOLUME) return 100;

        if (volume <= MID_VOLUME) {
            return (volume - MIN_VOLUME) / (MID_VOLUME - MIN_VOLUME) * MID_RANGE_PROGRESS;
        }

        return MID_RANGE_PROGRESS + (volume - MID_VOLUME) / (MAX_VOLUME - MID_VOLUME) * MID_RANGE_PROGRESS;
    }

    function getVolumeByRangeProgress(progress) {
        let volume;

        if (progress <= MID_RANGE_PROGRESS) {
            volume = MIN_VOLUME + progress / MID_RANGE_PROGRESS * (MID_VOLUME - MIN_VOLUME);
        } else {
            volume = MID_VOLUME + (progress - MID_RANGE_PROGRESS) / MID_RANGE_PROGRESS * (MAX_VOLUME - MID_VOLUME);
        }

        return Math.min(MAX_VOLUME, Math.max(MIN_VOLUME, roundVolumeToStep(volume)));
    }

    function updateRangeProgress() {
        if (!volumeRange) return;

        const progress = Number(volumeRange.value);
        const volume = getVolumeByRangeProgress(progress);

        volumeRange.style.setProperty('--range-progress', progress + '%');

        if (volumeRangeValue) {
            volumeRangeValue.textContent = formatVolume(volume);
            volumeRangeValue.style.left = 'calc(24px + (100% - 48px) * ' + (progress / 100) + ')';
            volumeRangeValue.style.setProperty('--range-value-shift', progress + '%');
        }
    }

    function getVolume() {
        return parseVolumeValue(volumeNumber.value);
    }

    function getCleanText(element) {
        return element ? element.textContent.replace(/\s+/g, ' ').trim() : '';
    }

    function getCheckboxText(text) {
        if (!text) return '';

        return text.dataset.originalText || getCleanText(text);
    }

    function getCheckboxItems(checkboxes) {
        return Array.from(checkboxes).map(function (checkbox) {
            const label = checkbox.closest('.calculator__checkbox');
            const text = label ? label.querySelector('.calculator__checkbox-text') : null;

            return {
                value: checkbox.value,
                label: text ? getCheckboxText(text) : checkbox.value,
                checked: checkbox.checked,
                disabled: checkbox.disabled,
                included_in_base: checkbox.disabled && !!(label && label.classList.contains('calculator__checkbox--disabled'))
            };
        });
    }

    function getCalculatorData() {
        const volume = getVolume();

        return {
            source: 'kyc_calculator',
            package: {
                selected: selectedPackage,
                label: PKG[selectedPackage].label,
                options: Array.from(packageButtons).map(function (button) {
                    return {
                        value: button.dataset.pkg || '',
                        label: getCleanText(button),
                        selected: button.classList.contains('active')
                    };
                })
            },
            document_types: Array.from(documentTypeButtons).map(function (button) {
                const value = button.dataset.dt || '';

                return {
                    value: value,
                    label: getCleanText(button),
                    selected: selectedDocumentTypes.has(value)
                };
            }),
            volume: {
                input_value: volumeNumber.value,
                numeric_value: volume,
                range_progress: Number(volumeRange.value),
                range_label: volumeRangeValue ? getCleanText(volumeRangeValue) : '',
                min: MIN_VOLUME,
                mid: MID_VOLUME,
                max: MAX_VOLUME,
                below_min: volume !== null && volume < MIN_VOLUME,
                above_max: volume !== null && volume > MAX_VOLUME
            },
            extra_documents: getCheckboxItems(extraDocumentCheckboxes),
            aml: {
                international: internationalCheckbox ? getCheckboxItems([internationalCheckbox])[0] : null
            },
            result: {
                package: getCleanText(root.querySelector('#calculator-result-package')),
                package_description: getCleanText(root.querySelector('#calculator-result-package-description')),
                package_price: getCleanText(root.querySelector('#calculator-result-package-price')),
                docs_label: getCleanText(root.querySelector('#calculator-result-docs-label')),
                docs_price: getCleanText(root.querySelector('#calculator-result-docs-price')),
                aml_label: getCleanText(root.querySelector('#calculator-result-aml-label')),
                aml_price: getCleanText(root.querySelector('#calculator-result-aml-price')),
                price_per_check: getCleanText(root.querySelector('#calculator-result-price-per-check')),
                sum_title: getCleanText(root.querySelector('.calculator__result-sum-title')),
                year_total: getCleanText(root.querySelector('#calculator-result-year-total')),
                year_info: getCleanText(root.querySelector('#calculator-result-year-info'))
            }
        };
    }

    function updateCalculatorRequestData() {
        if (!resultButtons.length) return;

        const calculatorJson = JSON.stringify(getCalculatorData());

        resultButtons.forEach(function (button) {
            button.dataset.calculatorJson = calculatorJson;
        });
    }

    function updateCalculatorRequestText(type) {
        if (!requestTitle || !requestText) return;

        if (type === 'below-min') {
            requestTitle.innerHTML = I18N.minimumVolumeRequestTitle;
            requestText.textContent = I18N.minimumVolumeRequestText;
            return;
        }

        requestTitle.innerHTML = I18N.volumeAboveRequestTitle;
        requestText.innerHTML = I18N.volumeAboveRequestText;
    }

    function changeVolumeByStep(direction) {
        const step = parseInt(volumeNumber.step, 10) || 1000;
        const min = parseInt(volumeNumber.min, 10) || 0;
        const currentVolume = getVolume();
        const currentValue = currentVolume === null ? min : currentVolume;
        const nextValue = Math.max(min, currentValue + direction * step);

        volumeNumber.value = formatVolume(nextValue);
        updateCalculator();
    }

    function getExtraDocumentUnitPrice(volume) {
        return rateAt(EXTRA_DOC_PRICE.USD, volume);
    }

    function getSelectedExtraDocuments() {
        return Array.from(extraDocumentCheckboxes).filter(function (checkbox) {
            return checkbox.checked && !checkbox.disabled;
        });
    }

    function getInternationalScreeningPrice() {
        return internationalCheckbox && internationalCheckbox.checked ? AML_INTERNATIONAL_PRICE : 0;
    }

    function lockIncludedDocuments() {
        extraDocumentCheckboxes.forEach(function (checkbox) {
            const value = checkbox.value;
            const label = checkbox.closest('.calculator__checkbox');
            const text = label ? label.querySelector('.calculator__checkbox-text') : null;

            const isIncludedDriver = value === 'driver_front' && selectedDocumentTypes.has('driver');
            const isIncludedId = value === 'id_front' && selectedDocumentTypes.has('id');
            const isLocked = isIncludedDriver || isIncludedId;

            checkbox.disabled = isLocked;

            if (isLocked) {
                checkbox.checked = false;
            }

            if (label) {
                label.classList.toggle('calculator__checkbox--disabled', isLocked);
            }

            if (text) {
                text.dataset.originalText = text.dataset.originalText || text.textContent.trim();

                text.textContent = text.dataset.originalText;

                if (isLocked) {
                    const includedText = document.createElement('span');
                    includedText.className = 'calculator__checkbox-included-text';
                    includedText.textContent = I18N.includedInBase;
                    text.appendChild(includedText);
                }
            }
        });
    }

    function updateCalculator() {
        let inputVolume = getVolume();
        const isEmptyVolume = inputVolume === null;

        if (isEmptyVolume) {
            inputVolume = 0;
        } else {
            if (inputVolume < 0) inputVolume = 0;
        }

        const isBelowMinVolume = inputVolume < MIN_VOLUME;
        const isAboveMaxVolume = inputVolume > MAX_VOLUME;
        const volume = isBelowMinVolume ? MIN_VOLUME : Math.min(inputVolume, MAX_VOLUME);

        volumeRange.value = getRangeProgressByVolume(volume);

        if (!isEmptyVolume) {
            volumeNumber.value = formatVolume(inputVolume);
        }

        updateRangeProgress();
        lockIncludedDocuments();

        const packagePrice = rateAt(PKG[selectedPackage].USD, volume);
        const extraDocUnitPrice = getExtraDocumentUnitPrice(volume);
        const selectedExtraDocs = getSelectedExtraDocuments();
        const extraDocsPrice = selectedExtraDocs.length * extraDocUnitPrice;
        const internationalScreeningPrice = getInternationalScreeningPrice();

        const pricePerCheck = packagePrice + extraDocsPrice + internationalScreeningPrice;
        const yearTotal = volume * pricePerCheck;

        root.classList.toggle('calculator--below-min-volume', isBelowMinVolume);
        root.classList.toggle('calculator--above-max-volume', isAboveMaxVolume);

        root.querySelector('#calculator-doc-unit-price').textContent = formatRate(extraDocUnitPrice) + ' ' + I18N.perDocument;
        root.querySelector('#calculator-extra-docs-total').textContent = formatRate(extraDocsPrice);
        root.querySelector('#calculator-international-total').textContent = formatRate(internationalScreeningPrice);

        if (isBelowMinVolume) {
            updateCalculatorRequestText('below-min');
            root.querySelector('.calculator__result-sum-title').textContent = I18N.minimumVolume + formatVolume(MIN_VOLUME);
            root.querySelector('#calculator-result-price-per-check').textContent = '';
            updateCalculatorRequestData();
            updateOpenSpoilerHeights();
            return;
        }

        if (isAboveMaxVolume) {
            updateCalculatorRequestText('above-max');
            root.querySelector('.calculator__result-sum-title').textContent = I18N.pricePerCheck;
            root.querySelector('#calculator-result-package').textContent = PKG[selectedPackage].name;
            root.querySelector('#calculator-result-package-description').textContent = PKG[selectedPackage].description;
            root.querySelector('#calculator-result-package-price').textContent = I18N.hiddenPrice;
            root.querySelector('#calculator-result-docs-label').textContent = I18N.documents;
            root.querySelector('#calculator-result-docs-price').textContent = I18N.hiddenPrice;
            root.querySelector('#calculator-result-aml-label').textContent = I18N.internationalScreening;
            root.querySelector('#calculator-result-aml-price').textContent = I18N.hiddenPrice;
            root.querySelector('#calculator-result-price-per-check').textContent = I18N.hiddenPrice;
            root.querySelector('#calculator-result-year-total').textContent = I18N.priceOnRequestValue;
            root.querySelector('#calculator-result-year-info').textContent = I18N.volumeAbovePriceOnRequest;
            updateCalculatorRequestData();
            updateOpenSpoilerHeights();
            return;
        }

        root.querySelector('.calculator__result-sum-title').textContent = I18N.pricePerCheck;
        root.querySelector('#calculator-result-package').textContent = PKG[selectedPackage].name;
        root.querySelector('#calculator-result-package-description').textContent = PKG[selectedPackage].description;
        root.querySelector('#calculator-result-package-price').textContent = formatRate(packagePrice);

        root.querySelector('#calculator-result-docs-label').textContent = selectedExtraDocs.length
            ? I18N.documents + ' (' + selectedExtraDocs.length + ' × ' + formatRate(extraDocUnitPrice) + ')'
            : I18N.documents;

        root.querySelector('#calculator-result-docs-price').textContent = '+' + formatRate(extraDocsPrice);

        root.querySelector('#calculator-result-aml-label').textContent = I18N.internationalScreening;
        root.querySelector('#calculator-result-aml-price').textContent = '+' + formatRate(internationalScreeningPrice);
        root.querySelector('#calculator-result-price-per-check').textContent = formatRate(pricePerCheck);
        root.querySelector('#calculator-result-year-total').textContent = formatMoney(yearTotal);
        root.querySelector('#calculator-result-year-info').textContent = formatVolume(volume) + ' ' + I18N.checksUnit + ' × ' + formatRate(pricePerCheck);

        updateCalculatorRequestData();
        updateOpenSpoilerHeights();
    }

    packageButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            selectedPackage = button.dataset.pkg;

            packageButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            button.classList.add('active');

            updateCalculator();
        });
    });

    documentTypeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const type = button.dataset.dt;

            if (selectedDocumentTypes.has(type)) {
                if (selectedDocumentTypes.size > 1) {
                    selectedDocumentTypes.delete(type);
                    button.classList.remove('active');
                }
            } else {
                selectedDocumentTypes.add(type);
                button.classList.add('active');
            }

            updateCalculator();
        });
    });

    volumeRange.addEventListener('input', function () {
        volumeNumber.value = formatVolume(getVolumeByRangeProgress(Number(volumeRange.value)));
        updateRangeProgress();
        updateCalculator();
    });

    volumeNumber.addEventListener('input', function () {
        updateCalculator();
    });

    volumeStepButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const direction = parseInt(button.dataset.volumeStep, 10);

            if (Number.isNaN(direction)) return;

            changeVolumeByStep(direction);
        });
    });

    extraDocumentCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', updateCalculator);
    });

    if (internationalCheckbox) {
        internationalCheckbox.addEventListener('change', updateCalculator);
    }

    initSpoilers();
    updateCalculator();
    updateRangeProgress();
});
