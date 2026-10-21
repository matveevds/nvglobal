<?php
/**
 * Секция «How it works» (`.kyc-steps`, `data-kyc-steps`) — универсальный блок: один вид, все тексты и id — аргументы.
 * Один [data-kyc-steps] на страницу — initKycPage() ищет его через querySelector.
 *
 * Аргументы (значения по умолчанию пустые/нейтральные):
 *  - badge          — текст бейджа (по умолчанию «How it works»; пусто — бейдж не выводится);
 *  - title, lead, note — заголовок, подзаголовок, примечание (пустые не выводятся);
 *  - steps          — 3–5 шагов: title, text, img (имя файла в img/ без `.webp`; есть и `@2x.webp`; пусто — без картинки),
 *                     w (размер картинки, по умолчанию 200), alt (по умолчанию пусто — декоративная);
 *  - arrow_icon     — HTML иконки стрелки на кнопках шагов (nv_contacts_icon('arrow', 24) и т. п.);
 *  - section_id     — якорь секции (по умолчанию how-it-works);
 *  - step_id_prefix — префикс id карточек для aria-controls (по умолчанию step);
 *  - nav_label      — aria-label группы кнопок (по умолчанию Steps);
 *  - step_label     — слово перед номером на кнопках (по умолчанию Step).
 */
$nv_st_badge = $args['badge'] ?? 'How it works';
$nv_st_title = $args['title'] ?? '';
$nv_st_lead  = $args['lead'] ?? '';
$nv_st_note  = $args['note'] ?? '';
$nv_st_items = isset($args['steps']) ? (array) $args['steps'] : array();
$nv_st_arrow = $args['arrow_icon'] ?? '';
$nv_st_section_id = $args['section_id'] ?? 'how-it-works';
$nv_st_id    = $args['step_id_prefix'] ?? 'step';
$nv_st_nav_label = $args['nav_label'] ?? 'Steps';
$nv_st_label = $args['step_label'] ?? 'Step';
$nv_st_img_base = get_template_directory_uri() . '/img/';
?>
<section class="kyc-steps" id="<?php echo esc_attr($nv_st_section_id); ?>" data-kyc-steps>
    <div class="solutions-products__panel kyc-panel">
        <div class="container">
            <div class="kyc-steps__grid">
                <div class="kyc-steps__left">
                    <?php if ('' !== $nv_st_badge) : ?>
                    <div class="section__badge"><?php echo esc_html($nv_st_badge); ?></div>
                    <?php endif; ?>
                    <div class="kyc-steps__text">
                        <div class="kyc-steps__head">
                            <?php if ('' !== $nv_st_title) : ?>
                            <h2 class="kyc-steps__title"><?php echo esc_html($nv_st_title); ?></h2>
                            <?php endif; ?>
                            <?php if ('' !== $nv_st_lead) : ?>
                            <p class="kyc-steps__lead"><?php echo esc_html($nv_st_lead); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ('' !== $nv_st_note) : ?>
                        <p class="kyc-steps__note"><?php echo esc_html($nv_st_note); ?></p>
                        <?php endif; ?>
                        <div class="kyc-steps__nav" role="group" aria-label="<?php echo esc_attr($nv_st_nav_label); ?>">
                            <?php foreach ($nv_st_items as $nv_i => $nv_step) : ?>
                            <button type="button" class="kyc-steps__btn<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>" data-step="<?php echo (int) $nv_i; ?>" aria-pressed="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($nv_st_id); ?>-step-<?php echo (int) $nv_i; ?>">
                                <span class="kyc-steps__btn-text"><?php echo esc_html($nv_st_label . ' ' . (int) ($nv_i + 1)); ?></span>
                                <span class="kyc-steps__btn-icon"><?php echo $nv_st_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="kyc-steps__right">
                    <div class="kyc-steps__viewport" data-steps-viewport>
                        <ol class="kyc-steps__list" data-steps-list>
                            <?php foreach ($nv_st_items as $nv_i => $nv_step) :
                                $nv_step_w   = (int) ($nv_step['w'] ?? 200);
                                $nv_step_img = (string) ($nv_step['img'] ?? '');
                                $nv_step_alt = (string) ($nv_step['alt'] ?? '');
                                ?>
                            <li class="kyc-steps__card" id="<?php echo esc_attr($nv_st_id); ?>-step-<?php echo (int) $nv_i; ?>" data-step-card>
                                <?php if ('' !== $nv_step_img) : ?>
                                <img class="kyc-steps__image" src="<?php echo esc_url($nv_st_img_base . $nv_step_img . '.webp'); ?>" srcset="<?php echo esc_url($nv_st_img_base . $nv_step_img . '.webp'); ?> 1x, <?php echo esc_url($nv_st_img_base . $nv_step_img . '@2x.webp'); ?> 2x" width="<?php echo $nv_step_w; ?>" height="<?php echo $nv_step_w; ?>" alt="<?php echo esc_attr($nv_step_alt); ?>"<?php echo ('' === $nv_step_alt) ? ' aria-hidden="true"' : ''; ?> decoding="async">
                                <?php endif; ?>
                                <div class="kyc-steps__card-text">
                                    <h3 class="kyc-steps__card-title"><?php echo esc_html($nv_step['title'] ?? ''); ?></h3>
                                    <?php if (!empty($nv_step['text'])) : ?>
                                    <p class="kyc-steps__card-desc"><?php echo esc_html($nv_step['text']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
