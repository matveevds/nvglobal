<?php
/**
 * Секция Benefits (`.idv-benefits`) — универсальный блок: один вид (Identity), стили — css/blocks/idv-benefits.css.
 * Карточки выгод (2–4) и акцентная promo-карточка с необязательной картинкой; текст promo никогда не уходит под картинку.
 *
 * Аргументы (значения по умолчанию пустые, пустое не выводится):
 *  - section_id — id секции;
 *  - badge, title — бейдж и заголовок;
 *  - icon       — HTML иконки в карточках (nv_identity_icon('check-circle')); у карточки можно задать свой `icon`;
 *  - items      — 2–4 карточки: title, text, icon (необязательно);
 *  - promo      — акцентная карточка: title, text, img (имя файла в img/ без `.webp`, есть `@2x.webp`; пусто — без картинки),
 *                 w/h (размеры картинки, по умолчанию 180×180), alt (по умолчанию пусто — декоративная).
 */
$nv_bn_id    = $args['section_id'] ?? '';
$nv_bn_badge = $args['badge'] ?? '';
$nv_bn_title = $args['title'] ?? '';
$nv_bn_icon  = $args['icon'] ?? '';
$nv_bn_items = isset($args['items']) ? (array) $args['items'] : array();
$nv_bn_promo = isset($args['promo']) ? (array) $args['promo'] : array();
$nv_bn_img_base = get_template_directory_uri() . '/img/';
?>
<section class="section idv-benefits"<?php echo '' !== $nv_bn_id ? ' id="' . esc_attr($nv_bn_id) . '"' : ''; ?>>
    <div class="container">
        <?php if ('' !== $nv_bn_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_bn_badge); ?></div>
        <?php endif; ?>
        <?php if ('' !== $nv_bn_title) : ?>
        <h2 class="kyc-title idv-benefits__title"><?php echo esc_html($nv_bn_title); ?></h2>
        <?php endif; ?>
        <div class="idv-benefits__row" style="--idv-benefits-cols: <?php echo max(1, min(4, count($nv_bn_items))); ?>">
            <?php if ($nv_bn_items) : ?>
            <div class="idv-benefits__grid">
                <?php foreach ($nv_bn_items as $nv_b) :
                    $nv_b_icon = $nv_b['icon'] ?? $nv_bn_icon;
                    ?>
                <div class="kyc-card kyc-card--filled idv-benefits__card">
                    <?php if ('' !== $nv_b_icon) : ?>
                    <span class="kyc-icon-box idv-benefits__card-icon" aria-hidden="true"><?php echo $nv_b_icon; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                    <?php endif; ?>
                    <div class="idv-benefits__card-text">
                        <h3 class="kyc-card__title idv-benefits__card-title"><?php echo esc_html($nv_b['title'] ?? ''); ?></h3>
                        <?php if (!empty($nv_b['text'])) : ?>
                        <p class="kyc-card__text"><?php echo esc_html($nv_b['text']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($nv_bn_promo['title'])) : ?>
            <div class="kyc-card kyc-card--accent idv-benefits__promo">
                <div class="idv-benefits__promo-text">
                    <h3 class="kyc-card__title"><?php echo esc_html($nv_bn_promo['title']); ?></h3>
                    <?php if (!empty($nv_bn_promo['text'])) : ?>
                    <p class="kyc-card__text"><?php echo esc_html($nv_bn_promo['text']); ?></p>
                    <?php endif; ?>
                </div>
                <?php if (!empty($nv_bn_promo['img'])) :
                    $nv_pw  = (int) ($nv_bn_promo['w'] ?? 180);
                    $nv_ph  = (int) ($nv_bn_promo['h'] ?? 180);
                    $nv_pal = (string) ($nv_bn_promo['alt'] ?? '');
                    ?>
                <img class="idv-benefits__promo-image" src="<?php echo esc_url($nv_bn_img_base . $nv_bn_promo['img'] . '.webp'); ?>" srcset="<?php echo esc_url($nv_bn_img_base . $nv_bn_promo['img'] . '.webp'); ?> 1x, <?php echo esc_url($nv_bn_img_base . $nv_bn_promo['img'] . '@2x.webp'); ?> 2x" width="<?php echo $nv_pw; ?>" height="<?php echo $nv_ph; ?>" alt="<?php echo esc_attr($nv_pal); ?>"<?php echo '' === $nv_pal ? ' aria-hidden="true"' : ''; ?> loading="lazy" decoding="async">
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
