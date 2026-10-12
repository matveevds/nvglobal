<?php
/**
 * Общая форма обратной связи.
 *
 * Одна и та же разметка выводится в секции Contacts на главной
 * (`main-page.php`) и на /solutions/ (`page-solutions.php`). Вынесена сюда,
 * чтобы не держать ~200 строк в двух шаблонах. Разметка, классы, `name`,
 * `data-*`, тексты ошибок, капча и путь отправки не менялись: их использует
 * `js/form.js` (`initContactsForms`, делегированный submit) и обработчик
 * `send_contacts_form` в `functions.php`.
 *
 * Параметры (`get_template_part(..., $args)`):
 *   show_select (bool, по умолчанию true) — выводить ли блок
 *   «How can we help you?». Поле `clientOption` проверяется на сервере
 *   только при наличии в запросе (`isset($_POST['clientOption'])`),
 *   поэтому без него отправка работает как обычно. В макете Solutions
 *   этого поля нет — см. DECISIONS.md, Р-95.
 *
 * ВАЖНО: иконки берутся из `template-parts/contacts-icons.php`, его нужно
 * подключить до вызова этого файла (так делают оба шаблона).
 */

$nv_form_show_select = !isset($args['show_select']) || (bool) $args['show_select'];
?>
<form class="contacts__form" action="#">


                            <div class="input-form-item input-form-item--50">
                                <div class="input-form-label">Name <span>*</span></div>

                                <div class="input-form-block">
                                    <div class="input-form-icon">
                                        <?php echo nv_contacts_icon('user', 24); ?>
                                    </div>
                                    <input class="input-form contacts__form-input" type="text" name="clientName" placeholder="e.g. John Smith">
                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <?php echo nv_contacts_icon('close', 20); ?>
                                    </button>
                                </div>

                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please enter a valid name</div>
                                </div>
                            </div>

                            <div class="input-form-item input-form-item--50">
                                <div class="input-form-label">Company</div>

                                <div class="input-form-block">
                                    <div class="input-form-icon">
                                        <?php echo nv_contacts_icon('building', 24); ?>
                                    </div>
                                    <input class="input-form contacts__form-input" type="text" name="clientCompany" placeholder="e.g. Example Co">
                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <?php echo nv_contacts_icon('close', 20); ?>
                                    </button>
                                </div>

                            </div>

                            <div class="input-form-item input-form-item--50">
                                <div class="input-form-label">E-mail <span>*</span></div>

                                <div class="input-form-block">
                                    <div class="input-form-icon">
                                        <?php echo nv_contacts_icon('email', 24); ?>
                                    </div>
                                    <input class="input-form contacts__form-input" type="email" name="clientEmail" placeholder="e.g. john.smith@example.co">
                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <?php echo nv_contacts_icon('close', 20); ?>
                                    </button>
                                </div>

                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please enter a valid e-mail</div>
                                </div>
                            </div>

                            <div class="input-form-item input-form-item--50">
                                <div class="phone-field" data-phone-field>
                                    <div class="phone-field__label input-form-label">
                                        Phone
                                    </div>

                                    <div class="phone-field__control input-form-block">
                                        <div class="phone-field__icon" aria-hidden="true">
                                            <?php echo nv_contacts_icon('calling', 24); ?>
                                        </div>
                                        
                                        <button class="phone-field__country-btn" type="button" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="phone-field__country-code" data-phone-field-code>44</span>
                                            <span class="phone-field__country-arrow" aria-hidden="true">
                                                <?php echo nv_contacts_icon('chevron', 24); ?>
                                            </span>
                                        </button>

                                        <input class="phone-field__input" type="tel" name="clientPhone" placeholder="000 000 00 00" autocomplete="tel" inputmode="tel" data-phone-field-input/>

                                        <button class="phone-field__clear input-form-clear" type="button" aria-label="Clear phone" data-phone-field-clear>
                                            <?php echo nv_contacts_icon('close', 20); ?>
                                        </button>

                                        <div class="phone-field__dropdown" hidden data-phone-field-dropdown>
                                            <div class="phone-field__search">
                                                <input class="phone-field__search-input" name="clientPhoneCode" type="text" placeholder="ex. USA" autocomplete="off" data-phone-field-search/>
                                                <button class="phone-field__search-btn" type="button" aria-label="Search" data-phone-field-search-btn>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true" focusable="false">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69371 3.125C6.16465 3.125 3.30408 5.98557 3.30408 9.51458C3.30408 13.0437 6.16474 15.905 9.69371 15.905C11.3592 15.905 12.8759 15.2677 14.0132 14.2235C14.017 14.2196 14.0208 14.2157 14.0246 14.2118C14.04 14.1964 14.0559 14.1821 14.0723 14.1687C15.3103 13.0032 16.0833 11.3491 16.0833 9.51458C16.0833 5.98557 13.2227 3.125 9.69371 3.125ZM15.3497 14.6507C16.5822 13.2938 17.3333 11.4919 17.3333 9.51458C17.3333 5.29522 13.913 1.875 9.69371 1.875C5.47429 1.875 2.05408 5.29522 2.05408 9.51458C2.05408 13.7339 5.4742 17.155 9.69371 17.155C11.4855 17.155 13.1333 16.538 14.4361 15.5049L16.88 17.9425C17.1244 18.1862 17.52 18.1857 17.7639 17.9413C18.0076 17.697 18.0071 17.3012 17.7627 17.0575L15.3497 14.6507ZM10.5126 5.43562C10.613 5.10537 10.9622 4.91907 11.2924 5.01951C12.6534 5.43338 13.7286 6.49147 14.1653 7.8414C14.2715 8.16982 14.0915 8.52217 13.763 8.62842C13.4346 8.73467 13.0823 8.55458 12.976 8.22615C12.6651 7.26519 11.8981 6.51022 10.9287 6.21543C10.5985 6.115 10.4122 5.76587 10.5126 5.43562Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="phone-field__list" role="listbox" tabindex="-1" data-phone-field-list>
                                                <?php echo taodep_render_phone_country_buttons(); ?>
                                            </div>

                                            <div class="phone-field__empty" hidden data-phone-field-empty>
                                                Nothing found
                                            </div>
                                        </div>
                                    </div>

                                   <div class="input-form-error">
                                        <div class="input-form-error-icon"></div>
                                        <div class="input-form-error-text">Please enter a valid phone</div>
                                    </div>
                                </div>
                            </div>

                            <div class="contacts__form-line"></div>
<?php if ($nv_form_show_select) : ?>

                            <div class="input-form-item help-select" data-help-select>
                                <div class="help-select__label input-form-label">
                                    How can we help you? <span>*</span>
                                </div>

                                <div class="help-select__control input-form-block">
                                    <div class="input-form-icon">
                                        <?php echo nv_contacts_icon('work', 24); ?>
                                    </div>

                                    <button class="help-select__button" type="button" aria-haspopup="listbox" aria-expanded="false" data-help-select-button>
                                        <span class="help-select__placeholder" data-help-select-placeholder>Select your option...</span>
                                        <span class="help-select__value" hidden data-help-select-value></span>
                                    </button>

                                    <button class="input-form-clear input-form-clear--disabled" aria-label="Clear field">
                                        <?php echo nv_contacts_icon('close', 20); ?>
                                    </button>

                                    <button class="help-select__arrow" type="button" aria-hidden="true" tabindex="-1">
                                        <?php echo nv_contacts_icon('chevron-white', 20); ?>
                                    </button>

                                    <div class="help-select__dropdown" role="listbox" hidden data-help-select-dropdown>
                                        <button class="help-select__option" type="button" role="option" data-value="Schedule a demo">
                                            Schedule a demo
                                        </button>

                                        <button class="help-select__option" type="button" role="option" data-value="Discuss integration">
                                            Discuss integration
                                        </button>

                                        <button class="help-select__option" type="button" role="option" data-value="Get pricing information">
                                            Get pricing information
                                        </button>

                                        <button class="help-select__option" type="button" role="option" data-value="Technical questions">
                                            Technical questions
                                        </button>
                                    </div>
                                </div>

                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please select an option</div>
                                </div>

                                <!-- Hidden input для отправки формы -->
                                <input type="hidden" name="clientOption" value="" data-help-select-hidden/>
                            </div>

                            <div class="contacts__form-line"></div>
<?php endif; ?>
                            
                            <div class="input-form-item">
                                <div class="input-form-label">Your Message <span>(optional)</span></div>
                                <div class="input-form-block input-form-block--textarea">
                                    <textarea name="clientMessage" placeholder="What do you want to discuss?"></textarea>
                                </div>
                            </div>

                            <div class="contacts__form-line"></div>

                            <div class="input-form-item input-form-item--privacy">
                                <div class="privacy-consent">
                                    <label class="ui-check">
                                        <input class="ui-check__input" type="checkbox" name="privacyConsent" />
                                        <span class="ui-check__box" aria-hidden="true"></span>
                            
                                        <span class="ui-check__text">
                                            I have read and agree to the <a class="ui-check__link" href="/terms-of-use/" target="_blank" rel="noopener">Terms of Use</a> and <a class="ui-check__link" href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a>
                                        </span>
                                    </label>
                                </div>
                            
                                <div class="input-form-error">
                                    <div class="input-form-error-icon"></div>
                                    <div class="input-form-error-text">Please accept the privacy policy</div>
                                </div>
                            </div>
                            
                            <div class="captcha-holder captcha-holder--preload"></div>

                            <div class="input-form-action">
                                <button class="btn-form" type="submit">
                                    <div class="btn-form__icon">
                                        <?php echo nv_contacts_icon('arrow', 24); ?>
                                    </div>
                                    <span class="btn__text btn__text-hero">Get Started</span>                                
                                </button>
                            </div>
                            

                        </form>
