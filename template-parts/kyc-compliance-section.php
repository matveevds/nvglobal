<?php
/**
 * Секция «Compliance map» (`.kyc-compliance`, `data-kyc-compliance`) — универсальный блок: один вид, все тексты, картинки и id — аргументы.
 * Карта мира с маркерами-кнопками и одной карточкой: наведение/фокус/нажатие на маркер подставляет его заголовок и текст в карточку.
 * Один [data-kyc-compliance] на страницу — initKycPage() ищет его через querySelector (разметку, data-* и классы маркеров не менять).
 *
 * Аргументы (значения по умолчанию пустые/нейтральные):
 *  - badge      — текст бейджа (по умолчанию «Compliance»; пусто — бейдж не выводится);
 *  - title, lead, note — заголовок, оранжевый подзаголовок и серое примечание/предупреждение (пустые не выводятся);
 *  - section_id — якорь секции (по умолчанию compliance; пусто — без id);
 *  - map        — файл карты в img/ с расширением (по умолчанию kyc-map-world.svg), map_alt — alt (по умолчанию пусто — декоративная);
 *  - markers    — 2–6 маркеров: flag (имя файла img/kyc-flag-<flag>.svg, по умолчанию world), label (aria-label маркера, по умолчанию title),
 *                 x, y (центр маркера в % ширины/высоты карты, 0–100), title, text (карточка), id (необязательно);
 *  - general    — необязательный «общий» маркер (глобус/FATF): те же ключи, значок-плашка без «булавки»; по умолчанию
 *                 в правом нижнем углу (x 92.8, y 88.4). Выбран при загрузке, если задан; иначе выбран первый из markers.
 *
 * Маркеры масштабируются вместе с картой (container query) и не выходят за её край; держать между центрами маркеров
 * не меньше ~10% по ширине или ~12% по высоте. Как в Figma, карточка отступает от левого края контейнера и правым краем
 * на 200px заходит на карту (прижата к низу): левее ~27% ширины карты маркеры ставить только в верхней части карты.
 * На ≤991 карточка идёт под картой и карту не перекрывает.
 */
$nv_cm_badge = $args['badge'] ?? 'Compliance';
$nv_cm_title = $args['title'] ?? '';
$nv_cm_lead  = $args['lead'] ?? '';
$nv_cm_note  = $args['note'] ?? '';
$nv_cm_section_id = $args['section_id'] ?? 'compliance';
$nv_cm_map   = $args['map'] ?? 'kyc-map-world.svg';
$nv_cm_map_alt = $args['map_alt'] ?? '';
$nv_cm_markers = isset($args['markers']) ? array_slice(array_values((array) $args['markers']), 0, 6) : array();
$nv_cm_general = (isset($args['general']) && is_array($args['general']) && !empty($args['general'])) ? $args['general'] : null;
$nv_cm_img   = get_template_directory_uri() . '/img/';

/* Единый список: общий маркер первым (id world — от него зависит стартовый выбор в JS), затем остальные. */
$nv_cm_list = array();
$nv_cm_used = array('world' => true);
if (null !== $nv_cm_general) {
    $nv_cm_general['id'] = 'world';
    $nv_cm_general['general'] = true;
    $nv_cm_general += array('x' => 92.8, 'y' => 88.4);
    $nv_cm_list[] = $nv_cm_general;
}
foreach ($nv_cm_markers as $nv_i => $nv_m) {
    if (!is_array($nv_m)) {
        continue;
    }
    $nv_id = sanitize_key((string) ($nv_m['id'] ?? ''));
    if ('' === $nv_id || isset($nv_cm_used[$nv_id])) {
        $nv_id = 'marker-' . ($nv_i + 1);
    }
    $nv_cm_used[$nv_id] = true;
    $nv_m['id'] = $nv_id;
    $nv_m['general'] = false;
    if (!isset($nv_m['x'])) {
        $nv_m['x'] = 15 + 14 * $nv_i;
    }
    if (!isset($nv_m['y'])) {
        $nv_m['y'] = 50;
    }
    $nv_cm_list[] = $nv_m;
}

$nv_cm_states = array();
foreach ($nv_cm_list as $nv_m) {
    $nv_cm_states[$nv_m['id']] = array('title' => (string) ($nv_m['title'] ?? ''), 'text' => (string) ($nv_m['text'] ?? ''));
}
$nv_cm_first = $nv_cm_list ? $nv_cm_list[0] : array();
?>
<section class="kyc-section kyc-compliance"<?php echo ('' !== $nv_cm_section_id) ? ' id="' . esc_attr($nv_cm_section_id) . '"' : ''; ?> data-kyc-compliance data-kyc-states="<?php echo esc_attr(wp_json_encode($nv_cm_states)); ?>">
    <div class="container">
        <?php if ('' !== $nv_cm_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_cm_badge); ?></div>
        <?php endif; ?>
        <div class="kyc-compliance__stage">
            <div class="kyc-compliance__head">
                <?php if ('' !== $nv_cm_title) : ?>
                <h2 class="kyc-compliance__title"><?php echo esc_html($nv_cm_title); ?></h2>
                <?php endif; ?>
                <?php if ('' !== $nv_cm_lead) : ?>
                <p class="kyc-compliance__lead"><?php echo esc_html($nv_cm_lead); ?></p>
                <?php endif; ?>
                <?php if ('' !== $nv_cm_note) : ?>
                <p class="kyc-compliance__note"><?php echo esc_html($nv_cm_note); ?></p>
                <?php endif; ?>
            </div>
            <div class="kyc-compliance__info">
                <div class="kyc-card kyc-card--filled kyc-compliance__card" aria-live="polite">
                    <h3 class="kyc-compliance__card-title" data-slot="title"><?php echo esc_html($nv_cm_first['title'] ?? ''); ?></h3>
                    <p class="kyc-compliance__card-text" data-slot="text"><?php echo esc_html($nv_cm_first['text'] ?? ''); ?></p>
                </div>
            </div>
            <div class="kyc-compliance__map-card">
                <div class="kyc-compliance__map" data-map-area>
                    <?php if ('' !== $nv_cm_map) : ?>
                    <img class="kyc-compliance__world" src="<?php echo esc_url($nv_cm_img . $nv_cm_map); ?>" width="630" height="630" alt="<?php echo esc_attr($nv_cm_map_alt); ?>"<?php echo ('' === $nv_cm_map_alt) ? ' aria-hidden="true"' : ''; ?> loading="lazy" decoding="async">
                    <?php endif; ?>
                    <?php foreach ($nv_cm_list as $nv_i => $nv_m) :
                        $nv_on    = (0 === $nv_i);
                        $nv_x     = max(0, min(100, (float) $nv_m['x']));
                        $nv_y     = max(0, min(100, (float) $nv_m['y']));
                        $nv_flag  = sanitize_file_name((string) ($nv_m['flag'] ?? '')) ?: 'world';
                        $nv_label = (string) ($nv_m['label'] ?? '');
                        if ('' === $nv_label) {
                            $nv_label = (string) ($nv_m['title'] ?? '');
                        }
                        ?>
                    <button type="button" class="kyc-marker kyc-marker--<?php echo esc_attr($nv_m['id']); ?><?php echo $nv_on ? ' is-active' : ''; ?>"
                            data-country="<?php echo esc_attr($nv_m['id']); ?>"
                            aria-pressed="<?php echo $nv_on ? 'true' : 'false'; ?>"
                            aria-label="<?php echo esc_attr($nv_label); ?>"
                            style="--mx: <?php echo esc_attr($nv_x); ?>%; --my: <?php echo esc_attr($nv_y); ?>%;">
                        <?php if (empty($nv_m['general'])) : ?>
                        <img class="kyc-marker__pin" src="<?php echo esc_url($nv_cm_img . 'kyc-marker.svg'); ?>" width="68" height="83" alt="" aria-hidden="true">
                        <img class="kyc-marker__pin kyc-marker__pin--on" src="<?php echo esc_url($nv_cm_img . 'kyc-marker-active.svg'); ?>" width="68" height="83" alt="" aria-hidden="true">
                        <?php else : ?>
                        <span class="kyc-marker__plate" aria-hidden="true"></span>
                        <?php endif; ?>
                        <span class="kyc-marker__face"><img src="<?php echo esc_url($nv_cm_img . 'kyc-flag-' . $nv_flag . '.svg'); ?>" width="44" height="44" alt="" aria-hidden="true"></span>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
