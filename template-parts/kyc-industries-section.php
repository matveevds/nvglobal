<?php
/**
 * Секция Industries (`.kyc-industries`) — универсальный блок: один вид (карточки с иконкой, текстом и тегами),
 * все тексты — аргументы. Высота по контенту; нечётная последняя карточка занимает всю строку.
 *
 * Аргументы (значения по умолчанию пустые/нейтральные):
 *  - badge — текст бейджа (по умолчанию «Industries»; пусто — не выводится);
 *  - title, lead — заголовок и подзаголовок (пустые не выводятся);
 *  - section_id — id секции (необязательно);
 *  - items — 3–6 карточек: title, text, icon (ключ иконки из inc/kyc-icons.php, по умолчанию industry),
 *            tags (массив коротких фраз; пустой — карточка без тегов).
 */
$nv_ind_badge = $args['badge'] ?? 'Industries';
$nv_ind_title = $args['title'] ?? '';
$nv_ind_lead  = $args['lead'] ?? '';
$nv_ind_id    = $args['section_id'] ?? '';
$nv_ind_items = isset($args['items']) ? (array) $args['items'] : array();
require_once get_template_directory() . '/inc/kyc-icons.php';
?>
<section class="kyc-section kyc-industries"<?php echo '' !== $nv_ind_id ? ' id="' . esc_attr($nv_ind_id) . '"' : ''; ?>>
    <div class="container">
        <?php if ('' !== $nv_ind_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_ind_badge); ?></div>
        <?php endif; ?>
        <?php if ('' !== $nv_ind_title) : ?>
        <h2 class="kyc-title"><?php echo esc_html($nv_ind_title); ?></h2>
        <?php endif; ?>
        <?php if ('' !== $nv_ind_lead) : ?>
        <p class="kyc-subtitle"><?php echo esc_html($nv_ind_lead); ?></p>
        <?php endif; ?>
        <ul class="kyc-industries__grid">
            <?php foreach ($nv_ind_items as $nv_ind) : ?>
            <li class="kyc-card kyc-industries__card">
                <div class="kyc-industries__top">
                    <span class="kyc-icon-box" aria-hidden="true"><?php echo nv_kyc_icon($nv_ind['icon'] ?? 'industry'); ?></span>
                    <div class="kyc-industries__text">
                        <h3 class="kyc-card__title kyc-card__title--md"><?php echo esc_html($nv_ind['title'] ?? ''); ?></h3>
                        <?php if (!empty($nv_ind['text'])) : ?>
                        <p class="kyc-card__text"><?php echo esc_html($nv_ind['text']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($nv_ind['tags'])) : ?>
                <div class="kyc-industries__tags">
                    <?php foreach ((array) $nv_ind['tags'] as $nv_tag) : ?>
                    <span class="kyc-token"><?php echo esc_html($nv_tag); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
