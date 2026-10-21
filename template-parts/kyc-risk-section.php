<?php
/**
 * Секция «Risk tabs» (`.kyc-risk`, `data-kyc-risk`) — универсальный блок: один вид, все тексты, иконки и id — аргументы.
 * Вкладки слева, одна панель справа: содержимое выбранной вкладки подставляет initKycPage() из `data-kyc-states`
 * (слоты `title`, `text`, `when`, `checks`). Один [data-kyc-risk] на страницу — JS берёт первый.
 *
 * Аргументы (значения по умолчанию пустые/нейтральные; вкладок нет — секция не выводится):
 *  - section_id   — якорь секции (по умолчанию без id);
 *  - badge        — текст бейджа (пусто — без бейджа);
 *  - title, lead  — заголовок H2 и подзаголовок слева (пустые не выводятся);
 *  - tabs         — 2–4 вкладки (лишние отбрасываются): button (подпись кнопки), title (заголовок панели), text (текст панели),
 *                   icon (HTML иконки панели — nv_kyc_icon() / nv_identity_icon(); пусто — иконка `icon` блока), when (значение
 *                   первой строки), checks (массив подписей токенов второй строки);
 *  - icon         — иконка по умолчанию для вкладок без своей (HTML; пусто — без иконки). Одинаковая у всех вкладок —
 *                   выводится один раз, разная — по одной на вкладку, видна иконка активной (CSS :has);
 *  - when_label   — подпись первой строки (по умолчанию «When»; строка выводится, если `when` есть хотя бы у одной вкладки);
 *  - checks_label — подпись второй строки (по умолчанию «Checks»; строка выводится, если `checks` есть хотя бы у одной вкладки);
 *  - side         — боковая карточка (необязательна): title, text, img (имя файла в img/ без `.webp`, есть `@2x.webp`),
 *                   w, h (размеры картинки, по умолчанию 245×233), alt (по умолчанию пусто — декоративная);
 *  - arrow_icon   — HTML иконки стрелки на кнопках вкладок (nv_contacts_icon('arrow', 24) и т. п.);
 *  - tabs_label   — aria-label списка вкладок (по умолчанию Options);
 *  - id_prefix    — префикс id вкладок и панели (по умолчанию kyc-risk).
 *
 * Высота панели не прыгает при переключении: под реальным содержимым лежат скрытые копии всех вкладок в одной
 * grid-ячейке (`.kyc-risk__state--ghost`), панель всегда высотой по самой длинной.
 */
$nv_rk_tabs = array_slice(array_values(array_filter(isset($args['tabs']) ? (array) $args['tabs'] : array(), 'is_array')), 0, 4);
if (!$nv_rk_tabs) {
    return;
}

$nv_rk_section_id = (string) ($args['section_id'] ?? '');
$nv_rk_badge  = (string) ($args['badge'] ?? '');
$nv_rk_title  = (string) ($args['title'] ?? '');
$nv_rk_lead   = (string) ($args['lead'] ?? '');
$nv_rk_icon   = (string) ($args['icon'] ?? '');
$nv_rk_when_label   = (string) ($args['when_label'] ?? 'When');
$nv_rk_checks_label = (string) ($args['checks_label'] ?? 'Checks');
$nv_rk_arrow  = (string) ($args['arrow_icon'] ?? '');
$nv_rk_label  = (string) ($args['tabs_label'] ?? 'Options');
$nv_rk_id     = (string) ($args['id_prefix'] ?? 'kyc-risk');
$nv_rk_side   = isset($args['side']) ? (array) $args['side'] : array();
$nv_rk_side_title = (string) ($nv_rk_side['title'] ?? '');
$nv_rk_side_text  = (string) ($nv_rk_side['text'] ?? '');
$nv_rk_side_img   = (string) ($nv_rk_side['img'] ?? '');
$nv_rk_has_side   = ('' !== $nv_rk_side_title || '' !== $nv_rk_side_text || '' !== $nv_rk_side_img);
$nv_rk_img_base   = get_template_directory_uri() . '/img/';

/* Нормализация вкладок + состояния для JS. */
$nv_rk_states = array();
$nv_rk_icons  = array();
$nv_rk_has_when = false;
$nv_rk_has_checks = false;
foreach ($nv_rk_tabs as $nv_k => $nv_tab) {
    $nv_tab['checks'] = array_values(array_map('strval', (array) ($nv_tab['checks'] ?? array())));
    $nv_tab['when']   = (string) ($nv_tab['when'] ?? '');
    $nv_tab['icon']   = (string) (($nv_tab['icon'] ?? '') ?: $nv_rk_icon);
    $nv_rk_tabs[$nv_k] = $nv_tab;
    $nv_rk_icons[]    = $nv_tab['icon'];
    $nv_rk_has_when   = $nv_rk_has_when || '' !== $nv_tab['when'];
    $nv_rk_has_checks = $nv_rk_has_checks || $nv_tab['checks'];
    $nv_rk_states[]   = array(
        'title'  => (string) ($nv_tab['title'] ?? ''),
        'text'   => (string) ($nv_tab['text'] ?? ''),
        'when'   => $nv_tab['when'],
        'checks' => $nv_tab['checks'],
    );
}
$nv_rk_icons_same = 1 === count(array_unique($nv_rk_icons));

/* Содержимое одной вкладки: реальное (со слотами JS) или скрытая копия для высоты панели. */
$nv_rk_state = static function (array $tab, int $i, bool $ghost) use ($nv_rk_icons, $nv_rk_icons_same, $nv_rk_has_when, $nv_rk_has_checks, $nv_rk_when_label, $nv_rk_checks_label): void {
    $slot = static function (string $name) use ($ghost): string {
        return $ghost ? '' : ' data-slot="' . $name . '"';
    };
    $title_tag = $ghost ? 'div' : 'h3';
    ?>
    <div class="kyc-risk__state<?php echo $ghost ? ' kyc-risk__state--ghost' : ''; ?>"<?php echo $ghost ? ' aria-hidden="true"' : ''; ?>>
        <<?php echo $title_tag; ?> class="kyc-risk__title"<?php echo $slot('title'); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html($tab['title'] ?? ''); ?></<?php echo $title_tag; ?>>
        <div class="kyc-risk__inner">
            <div class="kyc-risk__summary">
                <?php if (!$ghost && !$nv_rk_icons_same) : // у вкладок разные иконки — все в панели, видна иконка активной (CSS) ?>
                    <?php foreach ($nv_rk_icons as $nv_ik => $nv_icon_html) : ?>
                        <?php if ('' !== $nv_icon_html) : ?>
                <span class="kyc-icon-box kyc-risk__icon" data-index="<?php echo (int) $nv_ik; ?>" aria-hidden="true"><?php echo $nv_icon_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php elseif ('' !== $tab['icon']) : ?>
                <span class="kyc-icon-box kyc-risk__icon" aria-hidden="true"><?php echo $tab['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                <?php endif; ?>
                <p class="kyc-risk__summary-text"<?php echo $slot('text'); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html($tab['text'] ?? ''); ?></p>
            </div>
            <div class="kyc-risk__details"<?php echo ($nv_rk_has_when || $nv_rk_has_checks) ? '' : ' hidden'; ?>>
                <?php if ($nv_rk_has_when) : ?>
                <div class="kyc-risk__row-item">
                    <span class="kyc-risk__label"><?php echo esc_html($nv_rk_when_label); ?></span>
                    <span class="kyc-risk__when"<?php echo $slot('when'); // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html($tab['when']); ?></span>
                </div>
                <?php endif; ?>
                <div class="kyc-risk__row-item kyc-risk__row-item--checks"<?php echo $nv_rk_has_checks ? '' : ' hidden'; ?>>
                    <?php if ($nv_rk_has_checks) : ?>
                    <span class="kyc-risk__label"><?php echo esc_html($nv_rk_checks_label); ?></span>
                    <?php endif; ?>
                    <ul class="kyc-risk__checks"<?php echo $slot('checks'); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
                        <?php foreach ($tab['checks'] as $nv_c) : ?>
                        <li class="kyc-token"><?php echo esc_html($nv_c); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
};
?>
<section class="kyc-section kyc-risk"<?php echo '' !== $nv_rk_section_id ? ' id="' . esc_attr($nv_rk_section_id) . '"' : ''; ?> data-kyc-risk data-kyc-states="<?php echo esc_attr(wp_json_encode($nv_rk_states)); ?>">
    <div class="container">
        <?php if ('' !== $nv_rk_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_rk_badge); ?></div>
        <?php endif; ?>
        <div class="kyc-risk__row">
            <div class="kyc-risk__left">
                <?php if ('' !== $nv_rk_title || '' !== $nv_rk_lead) : ?>
                <div class="kyc-risk__text">
                    <?php if ('' !== $nv_rk_title) : ?>
                    <h2 class="kyc-title"><?php echo esc_html($nv_rk_title); ?></h2>
                    <?php endif; ?>
                    <?php if ('' !== $nv_rk_lead) : ?>
                    <p class="kyc-lead"><?php echo esc_html($nv_rk_lead); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="kyc-risk__tabs" role="tablist" aria-label="<?php echo esc_attr($nv_rk_label); ?>" aria-orientation="vertical">
                    <?php foreach ($nv_rk_tabs as $nv_i => $nv_tab) : ?>
                    <button type="button" role="tab" class="kyc-risk__tab<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"
                            id="<?php echo esc_attr($nv_rk_id); ?>-tab-<?php echo (int) $nv_i; ?>" data-index="<?php echo (int) $nv_i; ?>"
                            aria-selected="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($nv_rk_id); ?>-panel"
                            tabindex="<?php echo (0 === $nv_i) ? '0' : '-1'; ?>">
                        <span class="kyc-risk__tab-text"><?php echo esc_html($nv_tab['button'] ?? ($nv_tab['title'] ?? '')); ?></span>
                        <span class="kyc-risk__tab-icon"><?php echo $nv_rk_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="kyc-risk__right">
                <div class="kyc-risk__main" id="<?php echo esc_attr($nv_rk_id); ?>-panel" role="tabpanel" aria-labelledby="<?php echo esc_attr($nv_rk_id); ?>-tab-0" aria-live="polite">
                    <?php
                    $nv_rk_state($nv_rk_tabs[0], 0, false);
                    foreach ($nv_rk_tabs as $nv_i => $nv_tab) {
                        $nv_rk_state($nv_tab, (int) $nv_i, true);
                    }
                    ?>
                </div>
                <?php if ($nv_rk_has_side) : ?>
                <div class="kyc-card kyc-risk__side">
                    <?php if ('' !== $nv_rk_side_title || '' !== $nv_rk_side_text) : ?>
                    <div class="kyc-risk__side-text">
                        <?php if ('' !== $nv_rk_side_title) : ?>
                        <h3 class="kyc-card__title"><?php echo esc_html($nv_rk_side_title); ?></h3>
                        <?php endif; ?>
                        <?php if ('' !== $nv_rk_side_text) : ?>
                        <p class="kyc-card__text"><?php echo esc_html($nv_rk_side_text); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ('' !== $nv_rk_side_img) :
                        $nv_rk_side_alt = (string) ($nv_rk_side['alt'] ?? '');
                        ?>
                    <img class="kyc-risk__side-image" src="<?php echo esc_url($nv_rk_img_base . $nv_rk_side_img . '.webp'); ?>" srcset="<?php echo esc_url($nv_rk_img_base . $nv_rk_side_img . '.webp'); ?> 1x, <?php echo esc_url($nv_rk_img_base . $nv_rk_side_img . '@2x.webp'); ?> 2x" width="<?php echo (int) ($nv_rk_side['w'] ?? 245); ?>" height="<?php echo (int) ($nv_rk_side['h'] ?? 233); ?>" alt="<?php echo esc_attr($nv_rk_side_alt); ?>"<?php echo ('' === $nv_rk_side_alt) ? ' aria-hidden="true"' : ''; ?> loading="lazy" decoding="async">
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
