<?php
/**
 * Секция «Southeast Asia» (`.kyc-sea`, `data-kyc-sea`) — универсальный блок: один вид, все тексты и id — аргументы.
 * Карта из слоёв-стран и вкладки стран. Один [data-kyc-sea] на страницу — initKycPage() ищет его через querySelector.
 *
 * Контракт с initKycPage() (js/main.js не менялся): `data-kyc-states` — JSON `id => {title, text}`; слоты `data-slot="title"` и
 * `data-slot="text"` в карточке; вкладки `[role=tab][data-country]`, панель `[role=tabpanel]`, слои `.kyc-sea__layer[data-country]`
 * с `data-src` / `data-src-on`, увеличительный круг `[data-sea-zoom]` (JS показывает его только у Сингапура).
 * Строки-характеристики (`rows`) JS не знает: каждой стране — свой блок строк, показывает его CSS по активной вкладке.
 *
 * Аргументы (значения по умолчанию пустые/нейтральные):
 *  - section_id  — якорь секции и префикс id вкладок/панели (по умолчанию southeast-asia);
 *  - badge, title, lead — бейдж, заголовок, подзаголовок (пустые не выводятся);
 *  - tabs_label  — aria-label списка вкладок (по умолчанию Countries);
 *  - countries   — 1–6 стран, любой порядок; первая в массиве — открыта при загрузке:
 *      id    — страна на карте: singapore | malaysia | indonesia | philippines | vietnam | thailand (другое значение —
 *              страна без подсветки на карте; по умолчанию — slug из label);
 *      label — текст вкладки;  title — заголовок карточки (по умолчанию label);
 *      text  — абзац под заголовком (пусто — абзац скрыт, промежутка нет);
 *      rows  — строки-характеристики: label (подпись строки) и values[] (оранжевые токены; строка с одним значением — `value`);
 *              строка без значений не выводится.
 */
$nv_sea_section_id = $args['section_id'] ?? 'southeast-asia';
$nv_sea_badge      = $args['badge'] ?? '';
$nv_sea_title      = $args['title'] ?? '';
$nv_sea_lead       = $args['lead'] ?? '';
$nv_sea_tabs_label = $args['tabs_label'] ?? 'Countries';
$nv_sea_pid        = sanitize_html_class($nv_sea_section_id);
$nv_sea_img        = get_template_directory_uri() . '/img/';

/* Слои карты 604x520: имя файла, поля Figma в % (сверху, справа, снизу, слева), страна с оранжевым состоянием (или пусто). */
$nv_sea_layers = array(
    array('thailand',    array(23.55, 67.42, 41.21, 16.29), 'thailand'),
    array('indonesia',   array(58.58, 7.84, 4.79, 12.65),   'indonesia'),
    array('laos',        array(18.66, 63.69, 60.98, 21.79), ''),
    array('cambodia',    array(37.16, 63.55, 52.77, 26.09), ''),
    array('vietnam',     array(16.76, 60.12, 48.42, 25.71), 'vietnam'),
    array('group-a',     array(18.87, 63.63, 62.66, 25.66), ''),
    array('myanmar',     array(3.86, 76.07, 51.47, 6.09),   ''),
    array('philippines', array(21.04, 25.82, 39.19, 54.38), 'philippines'),
    array('dili',        array(89.82, 26.99, 8.03, 69.24),  ''),
    array('singapore',   array(68.04, 70.6, 31.48, 28.62),  'singapore'),
    array('malaysia',    array(54.88, 41.35, 30.83, 20.94), 'malaysia'),
    array('group-b',     array(56.25, 74.33, 41.15, 21.93), ''),
    array('group-c',     array(61.34, 44.69, 30.77, 39.99), ''),
    array('cambodia-b',  array(37.09, 63.49, 52.68, 26.04), ''),
    array('group-d',     array(20.98, 67.36, 61.9, 21.74),  ''),
    array('thailand-b',  array(23.48, 78.2, 51.63, 16.23),  ''),
);

/* Нормализация стран: 1–6, уникальные id, строки без значений отбрасываются. */
$nv_sea_countries = array();
$nv_sea_used      = array();
foreach (array_slice(array_values((array) ($args['countries'] ?? array())), 0, 6) as $nv_c) {
    $nv_label = trim((string) ($nv_c['label'] ?? ''));
    $nv_id    = sanitize_key((string) ($nv_c['id'] ?? $nv_label));
    if ('' === $nv_label && '' === $nv_id) {
        continue;
    }
    if ('' === $nv_id) {
        $nv_id = 'country';
    }
    $nv_base = $nv_id;
    for ($nv_n = 2; isset($nv_sea_used[$nv_id]); $nv_n++) {
        $nv_id = $nv_base . '-' . $nv_n;
    }
    $nv_sea_used[$nv_id] = true;
    $nv_rows = array();
    foreach ((array) ($nv_c['rows'] ?? array()) as $nv_row) {
        $nv_values = isset($nv_row['values']) ? (array) $nv_row['values'] : (isset($nv_row['value']) ? array($nv_row['value']) : array());
        $nv_values = array_values(array_filter(array_map('strval', $nv_values), static function ($v) {
            return '' !== trim($v);
        }));
        if ($nv_values) {
            $nv_rows[] = array('label' => (string) ($nv_row['label'] ?? ''), 'values' => $nv_values);
        }
    }
    $nv_sea_countries[] = array(
        'id'    => $nv_id,
        'label' => '' !== $nv_label ? $nv_label : $nv_id,
        'title' => (string) ($nv_c['title'] ?? ('' !== $nv_label ? $nv_label : $nv_id)),
        'text'  => (string) ($nv_c['text'] ?? ''),
        'rows'  => $nv_rows,
    );
}
if (!$nv_sea_countries) {
    return;
}

$nv_sea_first  = $nv_sea_countries[0];
$nv_sea_states = array();
$nv_sea_has_sg = false;
foreach ($nv_sea_countries as $nv_c) {
    $nv_sea_states[$nv_c['id']] = array('title' => $nv_c['title'], 'text' => $nv_c['text']);
    if ('singapore' === $nv_c['id']) {
        $nv_sea_has_sg = true;
    }
}
$nv_sea_has_top = ('' !== $nv_sea_badge || '' !== $nv_sea_title || '' !== $nv_sea_lead);
?>
<section class="kyc-sea" id="<?php echo esc_attr($nv_sea_section_id); ?>" data-kyc-sea data-kyc-states="<?php echo esc_attr(wp_json_encode($nv_sea_states)); ?>">
    <div class="solutions-products__panel kyc-panel">
        <div class="container">
            <div class="kyc-sea__inner">
                <?php if ($nv_sea_has_top) : ?>
                <div class="kyc-sea__top">
                    <?php if ('' !== $nv_sea_badge) : ?>
                    <div class="section__badge"><?php echo esc_html($nv_sea_badge); ?></div>
                    <?php endif; ?>
                    <?php if ('' !== $nv_sea_title || '' !== $nv_sea_lead) : ?>
                    <div class="kyc-sea__head">
                        <?php if ('' !== $nv_sea_title) : ?>
                        <h2 class="kyc-title"><?php echo esc_html($nv_sea_title); ?></h2>
                        <?php endif; ?>
                        <?php if ('' !== $nv_sea_lead) : ?>
                        <p class="kyc-lead"><?php echo esc_html($nv_sea_lead); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="kyc-sea__row">
                    <div class="kyc-sea__map" data-sea-map aria-hidden="true">
                        <?php foreach ($nv_sea_layers as $nv_layer) :
                            $nv_name   = $nv_layer[0];
                            $nv_in     = $nv_layer[1];
                            $nv_key    = ($nv_layer[2] && isset($nv_sea_used[$nv_layer[2]])) ? $nv_layer[2] : '';
                            $nv_is_on  = ($nv_key && $nv_key === $nv_sea_first['id']);
                            $nv_src    = $nv_sea_img . 'kyc-sea-' . $nv_name . ($nv_is_on ? '-on' : '') . '.svg';
                            ?>
                        <img class="kyc-sea__layer" src="<?php echo esc_url($nv_src); ?>" alt="" loading="lazy" decoding="async"
                             <?php if ($nv_key) : ?>data-country="<?php echo esc_attr($nv_key); ?>" data-src="<?php echo esc_url($nv_sea_img . 'kyc-sea-' . $nv_name . '.svg'); ?>" data-src-on="<?php echo esc_url($nv_sea_img . 'kyc-sea-' . $nv_name . '-on.svg'); ?>"<?php endif; ?>
                             style="left: <?php echo esc_attr(round($nv_in[3], 2)); ?>%; top: <?php echo esc_attr(round($nv_in[0], 2)); ?>%; width: <?php echo esc_attr(round(100 - $nv_in[1] - $nv_in[3], 2)); ?>%; height: <?php echo esc_attr(round(100 - $nv_in[0] - $nv_in[2], 2)); ?>%;">
                        <?php endforeach; ?>
                        <?php if ($nv_sea_has_sg) : ?>
                        <div class="kyc-sea__zoom"<?php echo 'singapore' === $nv_sea_first['id'] ? '' : ' hidden'; ?> data-sea-zoom>
                            <img class="kyc-sea__ellipse" src="<?php echo esc_url($nv_sea_img . 'kyc-sea-ellipse.svg'); ?>" width="24" height="24" alt="">
                            <img class="kyc-sea__line kyc-sea__line--a" src="<?php echo esc_url($nv_sea_img . 'kyc-sea-line-a.svg'); ?>" alt="">
                            <img class="kyc-sea__line kyc-sea__line--b" src="<?php echo esc_url($nv_sea_img . 'kyc-sea-line-b.svg'); ?>" alt="">
                            <span class="kyc-sea__circle"><img src="<?php echo esc_url($nv_sea_img . 'kyc-sea-singapore-zoom.svg'); ?>" alt=""></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="kyc-sea__side">
                        <div class="kyc-sea__tabs" role="tablist" aria-label="<?php echo esc_attr($nv_sea_tabs_label); ?>">
                            <?php foreach ($nv_sea_countries as $nv_i => $nv_c) : ?>
                            <button type="button" role="tab" class="kyc-sea__tab<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"
                                    id="<?php echo esc_attr($nv_sea_pid . '-tab-' . $nv_c['id']); ?>" data-country="<?php echo esc_attr($nv_c['id']); ?>"
                                    aria-selected="<?php echo (0 === $nv_i) ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($nv_sea_pid . '-panel'); ?>"
                                    tabindex="<?php echo (0 === $nv_i) ? '0' : '-1'; ?>"><?php echo esc_html($nv_c['label']); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="kyc-card kyc-card--filled kyc-sea__card" id="<?php echo esc_attr($nv_sea_pid . '-panel'); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($nv_sea_pid . '-tab-' . $nv_sea_first['id']); ?>" aria-live="polite">
                            <div class="kyc-sea__intro">
                                <h3 class="kyc-card__title" data-slot="title"><?php echo esc_html($nv_sea_first['title']); ?></h3>
                                <p class="kyc-sea__text" data-slot="text"><?php echo esc_html($nv_sea_first['text']); ?></p>
                            </div>
                            <?php /* По одному <dl> на страну, в порядке вкладок: CSS показывает блок активной вкладки (пустой <dl> не занимает места). */ ?>
                            <?php foreach ($nv_sea_countries as $nv_c) : ?>
                            <dl class="kyc-sea__facts" data-sea-rows="<?php echo esc_attr($nv_c['id']); ?>"><?php foreach ($nv_c['rows'] as $nv_row) : ?><div class="kyc-sea__fact"><?php if ('' !== $nv_row['label']) : ?><dt><?php echo esc_html($nv_row['label']); ?></dt><?php endif; ?><dd class="kyc-sea__tokens"><?php foreach ($nv_row['values'] as $nv_v) : ?><span class="kyc-token kyc-token--orange"><?php echo esc_html($nv_v); ?></span><?php endforeach; ?></dd></div><?php endforeach; ?></dl>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
