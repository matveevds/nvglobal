<?php
/**
 * Секция Pricing (`.kyc-pricing`) — универсальный блок: один вид (Identity), стили — css/blocks/kyc-pricing.css, все тексты,
 * цена, планы и ссылки — аргументы. Ничего не зашито; необязательное не передавать — оно не выводится.
 *
 * Аргументы (значения по умолчанию пустые):
 *  - section_id   — id секции (необязательно, например pricing);
 *  - badge, title, lead — бейдж, заголовок, подзаголовок;
 *  - eyebrow      — оранжевая надпись над ценой (необязательно);
 *  - price_prefix — слово перед ценой, например «From» (необязательно); price — цена («$0.25»), выделяется цветом;
 *    price_unit   — текст после цены («per check»);
 *  - price_note   — пояснение под ценой;
 *  - cta          — подпись основной кнопки (кнопка выводится, если есть `cta`); cta_url — её адрес, либо cta_form —
 *                   класс открытия модалки (open-callForm2): тогда вместо ссылки выводится кнопка;
 *  - arrow_icon   — HTML иконки стрелки на кнопках (nv_contacts_icon('arrow', 24) и т. п.);
 *  - plans        — 1–3 карточки планов: title, text, btn (подпись кнопки), form (класс открытия модалки, например
 *                   open-callForm2) или url (ссылка вместо кнопки-модалки); первая карточка — акцентная.
 */
$nv_pr_id      = $args['section_id'] ?? '';
$nv_pr_badge   = $args['badge'] ?? '';
$nv_pr_title   = $args['title'] ?? '';
$nv_pr_lead    = $args['lead'] ?? '';
$nv_pr_eyebrow = $args['eyebrow'] ?? '';
$nv_pr_prefix  = $args['price_prefix'] ?? '';
$nv_pr_price   = $args['price'] ?? '';
$nv_pr_unit    = $args['price_unit'] ?? '';
$nv_pr_desc    = $args['price_note'] ?? '';
$nv_pr_cta     = $args['cta'] ?? '';
$nv_pr_cta_url = $args['cta_url'] ?? '';
$nv_pr_cta_form = $args['cta_form'] ?? '';
$nv_pr_arrow   = $args['arrow_icon'] ?? '';
$nv_pr_plans   = isset($args['plans']) ? (array) $args['plans'] : array();
?>
<section class="kyc-pricing"<?php echo '' !== $nv_pr_id ? ' id="' . esc_attr($nv_pr_id) . '"' : ''; ?>>
    <div class="solutions-products__panel kyc-panel">
        <div class="container">
            <?php if ('' !== $nv_pr_badge) : ?>
            <div class="section__badge"><?php echo esc_html($nv_pr_badge); ?></div>
            <?php endif; ?>
            <div class="kyc-pricing__inner">
                <?php if ('' !== $nv_pr_title || '' !== $nv_pr_lead) : ?>
                <div class="kyc-pricing__head">
                    <?php if ('' !== $nv_pr_title) : ?>
                    <h2 class="kyc-title"><?php echo esc_html($nv_pr_title); ?></h2>
                    <?php endif; ?>
                    <?php if ('' !== $nv_pr_lead) : ?>
                    <p class="kyc-lead kyc-lead--md"><?php echo esc_html($nv_pr_lead); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="kyc-pricing__grid">
                    <div class="kyc-card kyc-card--filled kyc-pricing__main">
                        <div class="kyc-pricing__main-text">
                            <?php if ('' !== $nv_pr_eyebrow) : ?>
                            <p class="kyc-pricing__eyebrow"><?php echo esc_html($nv_pr_eyebrow); ?></p>
                            <?php endif; ?>
                            <?php if ('' !== $nv_pr_price) : ?>
                            <p class="kyc-pricing__price"><?php echo '' !== $nv_pr_prefix ? esc_html($nv_pr_prefix) . ' ' : ''; ?><span><?php echo esc_html($nv_pr_price); ?></span><?php echo '' !== $nv_pr_unit ? ' ' . esc_html($nv_pr_unit) : ''; ?></p>
                            <?php endif; ?>
                            <?php if ('' !== $nv_pr_desc) : ?>
                            <p class="kyc-pricing__desc"><?php echo esc_html($nv_pr_desc); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ('' !== $nv_pr_cta) : ?>
                        <?php if ('' !== $nv_pr_cta_form) : ?>
                        <button type="button" class="kyc-btn kyc-btn--primary <?php echo esc_attr($nv_pr_cta_form); ?>">
                        <?php else : ?>
                        <a class="kyc-btn kyc-btn--primary" href="<?php echo esc_url($nv_pr_cta_url); ?>">
                        <?php endif; ?>
                            <span class="kyc-btn__text"><?php echo esc_html($nv_pr_cta); ?></span>
                            <span class="kyc-btn__icon"><?php echo $nv_pr_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                        <?php echo '' !== $nv_pr_cta_form ? '</button>' : '</a>'; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($nv_pr_plans) : ?>
                    <div class="kyc-pricing__side">
                        <?php foreach ($nv_pr_plans as $nv_pi => $nv_plan) : ?>
                        <div class="kyc-card <?php echo (0 === $nv_pi) ? 'kyc-card--accent' : 'kyc-card--filled'; ?> kyc-pricing__plan">
                            <div class="kyc-pricing__plan-text">
                                <h3 class="kyc-card__title"><?php echo esc_html($nv_plan['title'] ?? ''); ?></h3>
                                <?php if (!empty($nv_plan['text'])) : ?>
                                <p class="kyc-card__text"><?php echo esc_html($nv_plan['text']); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($nv_plan['btn'])) : ?>
                                <?php if (!empty($nv_plan['url'])) : ?>
                            <a class="kyc-btn kyc-btn--small" href="<?php echo esc_url($nv_plan['url']); ?>">
                                <?php else : ?>
                            <button type="button" class="kyc-btn kyc-btn--small <?php echo esc_attr($nv_plan['form'] ?? ''); ?>">
                                <?php endif; ?>
                                <span class="kyc-btn__text"><?php echo esc_html($nv_plan['btn']); ?></span>
                                <span class="kyc-btn__icon"><?php echo $nv_pr_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                                <?php echo !empty($nv_plan['url']) ? '</a>' : '</button>'; ?>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
