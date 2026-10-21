<?php
/**
 * Секция Checks (`.idv-checks`) — универсальный блок: один вид (Identity), стили — css/blocks/idv-checks.css. Карточки
 * «что проверяем» в общей рамке; 2–6 карточек, сетка в 2 колонки, нечётная последняя карточка занимает всю строку.
 *
 * Аргументы (значения по умолчанию пустые, пустое не выводится):
 *  - section_id — id секции (например checks);
 *  - badge, title — бейдж и заголовок (бейдж по центру над заголовком);
 *  - lead       — оранжевый подзаголовок под заголовком (необязательно);
 *  - intro      — вводный текст внутри рамки над карточками (необязательно);
 *  - items      — 2–6 карточек: title, text, pill (плашка внизу карточки, необязательно).
 */
$nv_ck_id    = $args['section_id'] ?? '';
$nv_ck_badge = $args['badge'] ?? '';
$nv_ck_title = $args['title'] ?? '';
$nv_ck_lead  = $args['lead'] ?? '';
$nv_ck_intro = $args['intro'] ?? '';
$nv_ck_items = isset($args['items']) ? (array) $args['items'] : array();
?>
<section class="section idv-checks"<?php echo '' !== $nv_ck_id ? ' id="' . esc_attr($nv_ck_id) . '"' : ''; ?>>
    <div class="container">
        <?php if ('' !== $nv_ck_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_ck_badge); ?></div>
        <?php endif; ?>
        <?php if ('' !== $nv_ck_title || '' !== $nv_ck_lead) : ?>
        <div class="idv-checks__head">
            <?php if ('' !== $nv_ck_title) : ?>
            <h2 class="kyc-title idv-checks__title"><?php echo esc_html($nv_ck_title); ?></h2>
            <?php endif; ?>
            <?php if ('' !== $nv_ck_lead) : ?>
            <p class="kyc-subtitle"><?php echo esc_html($nv_ck_lead); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="idv-checks__group">
            <?php if ('' !== $nv_ck_intro) : ?>
            <p class="kyc-lead--md idv-checks__intro"><?php echo esc_html($nv_ck_intro); ?></p>
            <?php endif; ?>
            <div class="idv-checks__grid">
                <?php foreach ($nv_ck_items as $nv_check) : ?>
                <div class="kyc-card kyc-card--filled idv-checks__card">
                    <div class="idv-checks__card-text">
                        <h3 class="kyc-card__title idv-checks__card-title"><?php echo esc_html($nv_check['title'] ?? ''); ?></h3>
                        <?php if (!empty($nv_check['text'])) : ?>
                        <p class="kyc-card__text idv-checks__card-desc"><?php echo esc_html($nv_check['text']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($nv_check['pill'])) : ?>
                    <div class="idv-checks__pill"><?php echo esc_html($nv_check['pill']); ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
