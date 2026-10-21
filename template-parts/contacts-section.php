<?php
/**
 * Секция Contacts (`#cta`). Общая для /solutions/, /kyc/, /identity-verification/ и страниц сборщика.
 * Вынесена из page-solutions.php без изменений разметки; форма — contacts-form.php.
 * Аргументы (все необязательные; по умолчанию — прежние тексты и якорь, страницы без аргументов не меняются):
 *   section_id — id секции (`cta`); badge — плашка (`Contacts`); title — H2;
 *   lead — подзаголовок под H2 (HTML через wp_kses_post; пустая строка убирает абзац).
 */
/*
 * Contacts. Макеты Figma: Full HD 2456:16687, Desktop 2398:25244,
 * Tablet 2457:17398, Mobile 2467:18083.
 *
 * Блок повторяет секцию Contacts главной: те же классы `.contacts*`,
 * та же форма из `template-parts/contacts-form.php`. Отличия макета
 * (ширина колонок, карточка без кнопки и разделителя, порядок блоков
 * на планшете и мобильной) решены CSS в контексте
 * `body.page-template-page-solutions`.
 *
 * Поля «How can we help you?» в макете Solutions нет ни на одном
 * вьюпорте, поэтому форма выводится без него (DECISIONS.md, Р-95).
 * На сервере `clientOption` проверяется только при наличии в запросе.
 *
 * Якорь `#cta` сохранён: ссылок на него в теме нет, но менять адрес
 * без причины не стали (DECISIONS.md, Р-96).
 */
require_once get_template_directory() . '/template-parts/contacts-icons.php';

/*
 * Мессенджеры из макета. Выводим только те, у которых есть реальный
 * адрес: заглушек href="#" не ставим. Telegram и WhatsApp ждут ссылок —
 * тот же пункт, что у главной (BACKLOG R-20).
 */
$nv_contacts_social = array_filter([
    'telegram' => ['url' => '', 'label' => 'Telegram'],
    'whatsapp' => ['url' => '', 'label' => 'WhatsApp'],
    'linkedin' => ['url' => 'https://www.linkedin.com/company/nvglobal-ai/posts/', 'label' => 'LinkedIn'],
], static function ($item) { return $item['url'] !== ''; });

$nv_contacts_id    = sanitize_html_class($args['section_id'] ?? '') ?: 'cta';
$nv_contacts_badge = $args['badge'] ?? 'Contacts';
$nv_contacts_title = $args['title'] ?? 'Not sure which product fits? Tell us about your flow';
$nv_contacts_lead  = $args['lead'] ?? 'We&rsquo;ll map your onboarding and compliance steps to the right modules and set up a pilot on your real traffic.';
?>
<section class="contacts section" id="<?php echo esc_attr($nv_contacts_id); ?>">
    <div class="container">
        <div class="contacts__wrapper">
            <?php if ('' !== (string) $nv_contacts_badge) : ?>
            <div class="section__badge"><?php echo esc_html($nv_contacts_badge); ?></div>
            <?php endif; ?>

            <div class="contacts__content">
                <div class="contacts__title-block">
                    <h2 class="section__title"><?php echo esc_html($nv_contacts_title); ?></h2>
                    <?php if ('' !== (string) $nv_contacts_lead) : ?>
                    <p class="section__subtitle"><?php echo wp_kses_post($nv_contacts_lead); ?></p>
                    <?php endif; ?>
                </div>

                <div class="contacts__actions">
                    <div class="contacts__card">
                        <div class="contacts__card-info">
                            <div class="contacts__card-title">Prefer to reach out directly?</div>

                            <div class="contacts__card-item">
                                <div class="contacts__card-item-name">Email us:</div>
                                <a href="mailto:hello@nv.global" class="contacts__card-item-link">
                                    <span>hello@nv.global</span>
                                    <?php echo nv_contacts_icon('arrow', 24); ?>
                                </a>
                            </div>

                            <?php if ($nv_contacts_social) : ?>
                                <div class="contacts__card-item contacts__card-item--social">
                                    <div class="contacts__card-item-name">Message us</div>
                                    <div class="contacts__card-social-list">
                                        <?php foreach ($nv_contacts_social as $nv_social_key => $nv_social) : ?>
                                            <a href="<?php echo esc_url($nv_social['url']); ?>"
                                               class="contacts__card-social-link"
                                               target="_blank" rel="noopener noreferrer"
                                               aria-label="<?php echo esc_attr($nv_social['label']); ?>">
                                                <?php echo nv_contacts_icon($nv_social_key, 24); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="contacts__form-block">
                    <?php get_template_part('template-parts/contacts-form', null, ['show_select' => false]); ?>
                </div>
            </div>
        </div>
    </div>
</section>
