<?php
/**
 * Секция Security (`.idv-security`) — универсальный блок: один вид, стили — css/blocks/idv-security.css. Карточки
 * (1–3) и необязательная региональная панель с картой ЮВА; раскладка без пустот при любом сочетании.
 *
 * Аргументы (значения по умолчанию пустые, пустое не выводится):
 *  - section_id — id секции (например security);
 *  - badge, title — бейдж и заголовок (бейдж необязателен);
 *  - cards      — 1–3 карточки: title, text (необязательно), marks (необязательно — знаки сертификатов:
 *                 массив ключей iso / asib / qa), link (необязательно — array(text, href); href — путь от корня
 *                 сайта, «/…», либо полный URL или «#…»);
 *  - regional   — необязательная панель: title_plain, title_accent (акцентная часть заголовка), text, flags
 *                 (коды флагов из img/kyc-flag-<код>.svg), map (bool, по умолчанию true — карта ЮВА).
 */
require_once get_template_directory() . '/inc/security-map.php';
require_once get_template_directory() . '/template-parts/contacts-icons.php';

$nv_sec_id       = $args['section_id'] ?? '';
$nv_sec_badge    = $args['badge'] ?? '';
$nv_sec_title    = $args['title'] ?? '';
$nv_sec_cards    = isset($args['cards']) ? array_values((array) $args['cards']) : array();
$nv_sec_regional = isset($args['regional']) ? (array) $args['regional'] : array();
$nv_sec_img      = get_template_directory_uri() . '/img/';

$nv_sec_reg_plain  = $nv_sec_regional['title_plain'] ?? '';
$nv_sec_reg_accent = $nv_sec_regional['title_accent'] ?? '';
$nv_sec_reg_text   = $nv_sec_regional['text'] ?? '';
$nv_sec_reg_flags  = isset($nv_sec_regional['flags']) ? (array) $nv_sec_regional['flags'] : array();
$nv_sec_reg_map    = !empty($nv_sec_regional) && (!array_key_exists('map', $nv_sec_regional) || $nv_sec_regional['map']);
$nv_sec_has_reg    = $nv_sec_reg_map || '' !== $nv_sec_reg_plain . $nv_sec_reg_accent . $nv_sec_reg_text || $nv_sec_reg_flags;

/* Знаки сертификатов: ключ => файл (webp 1x/2x), размеры и alt. */
$nv_sec_marks = array(
    'iso'  => array('kyc-cert-iso', 80, 80, '', 'ISO register global certification mark'),
    'asib' => array('kyc-cert-asib', 62, 80, '', 'ASIB certification mark'),
    'qa'   => array('kyc-cert-qa', 80, 80, 'kyc-about__badge-round', 'QA Compliance Assessment certification mark'),
);

$nv_sec_classes = 'idv-security__grid'
    . (empty($nv_sec_cards) ? ' idv-security__grid--no-cards' : '')
    . (!$nv_sec_has_reg ? ' idv-security__grid--no-regional' : '');
?>
<section class="kyc-section idv-security"<?php echo '' !== $nv_sec_id ? ' id="' . esc_attr($nv_sec_id) . '"' : ''; ?>>
    <div class="container">
        <?php if ('' !== $nv_sec_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_sec_badge); ?></div>
        <?php endif; ?>
        <?php if ('' !== $nv_sec_title) : ?>
        <h2 class="kyc-title idv-security__title"><?php echo esc_html($nv_sec_title); ?></h2>
        <?php endif; ?>
        <div class="<?php echo esc_attr($nv_sec_classes); ?>">
            <?php if (!empty($nv_sec_cards)) : ?>
            <div class="idv-security__col">
                <?php foreach ($nv_sec_cards as $nv_sc) :
                    $nv_sc_marks = array_values(array_intersect((array) ($nv_sc['marks'] ?? array()), array_keys($nv_sec_marks)));
                    $nv_sc_link  = !empty($nv_sc['link']) && !empty($nv_sc['link']['text']) ? (array) $nv_sc['link'] : array();
                    ?>
                <div class="kyc-card idv-security__card<?php echo $nv_sc_marks ? ' idv-security__card--marks' : ''; ?>">
                    <h3 class="kyc-card__title"><?php echo esc_html($nv_sc['title'] ?? ''); ?></h3>
                    <?php if (!empty($nv_sc['text'])) : ?>
                    <p class="kyc-card__text"><?php echo esc_html($nv_sc['text']); ?></p>
                    <?php endif; ?>
                    <?php if ($nv_sc_marks) : ?>
                    <div class="idv-security__badges">
                        <?php foreach ($nv_sc_marks as $nv_mark_key) :
                            list($nv_mark_file, $nv_mark_w, $nv_mark_h, $nv_mark_class, $nv_mark_alt) = $nv_sec_marks[$nv_mark_key];
                            ?>
                        <img<?php echo '' !== $nv_mark_class ? ' class="' . esc_attr($nv_mark_class) . '"' : ''; ?> src="<?php echo esc_url($nv_sec_img . $nv_mark_file . '.webp'); ?>" srcset="<?php echo esc_url($nv_sec_img . $nv_mark_file . '.webp'); ?> 1x, <?php echo esc_url($nv_sec_img . $nv_mark_file . '@2x.webp'); ?> 2x" width="<?php echo (int) $nv_mark_w; ?>" height="<?php echo (int) $nv_mark_h; ?>" alt="<?php echo esc_attr($nv_mark_alt); ?>" loading="lazy" decoding="async">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($nv_sc_link) :
                        $nv_link_href = (string) ($nv_sc_link['href'] ?? '');
                        $nv_link_url  = ('' === $nv_link_href || '#' === $nv_link_href[0] || preg_match('#^https?://#', $nv_link_href)) ? $nv_link_href : home_url($nv_link_href);
                        ?>
                    <a class="kyc-btn kyc-btn--small idv-security__link" href="<?php echo esc_url($nv_link_url); ?>">
                        <span class="kyc-btn__text"><?php echo esc_html($nv_sc_link['text']); ?></span>
                        <span class="kyc-btn__icon"><?php echo nv_contacts_icon('arrow', 24); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if ($nv_sec_has_reg) : ?>
            <div class="idv-security__regional<?php echo !$nv_sec_reg_map ? ' idv-security__regional--no-map' : ''; ?>">
                <?php if ($nv_sec_reg_map) : ?>
                <div class="idv-security__map" aria-hidden="true">
                    <?php foreach (nv_security_map_layers() as $nv_layer) :
                        list($nv_name, $nv_top, $nv_right, $nv_bottom, $nv_left) = $nv_layer;
                        /* Явные width/height из inset-процентов: img не вычисляет размер из top/right/bottom/left (F4-01). */
                        $nv_layer_w = 100 - $nv_right - $nv_left;
                        $nv_layer_h = 100 - $nv_top - $nv_bottom;
                        ?>
                    <img class="idv-security__map-layer" src="<?php echo esc_url($nv_sec_img . 'identity-security-' . $nv_name . '.svg'); ?>" alt=""
                         style="top: <?php echo esc_attr($nv_top); ?>%; right: <?php echo esc_attr($nv_right); ?>%; bottom: <?php echo esc_attr($nv_bottom); ?>%; left: <?php echo esc_attr($nv_left); ?>%; width: <?php echo esc_attr($nv_layer_w); ?>%; height: <?php echo esc_attr($nv_layer_h); ?>%;">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if ($nv_sec_reg_flags || '' !== $nv_sec_reg_plain . $nv_sec_reg_accent . $nv_sec_reg_text) : ?>
                <div class="idv-security__regional-text">
                    <?php if ($nv_sec_reg_flags) : ?>
                    <div class="idv-security__flags">
                        <?php foreach ($nv_sec_reg_flags as $nv_flag) : ?>
                        <img class="idv-security__flag" src="<?php echo esc_url($nv_sec_img . 'kyc-flag-' . $nv_flag . '.svg'); ?>" width="32" height="32" alt="" aria-hidden="true" loading="lazy">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ('' !== $nv_sec_reg_plain . $nv_sec_reg_accent) : ?>
                    <h3 class="kyc-card__title"><?php echo esc_html($nv_sec_reg_plain); ?><?php if ('' !== $nv_sec_reg_accent) : ?><span class="idv-security__accent"><?php echo esc_html($nv_sec_reg_accent); ?></span><?php endif; ?></h3>
                    <?php endif; ?>
                    <?php if ('' !== $nv_sec_reg_text) : ?>
                    <p class="kyc-card__text"><?php echo esc_html($nv_sec_reg_text); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
