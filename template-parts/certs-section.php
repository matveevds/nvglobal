<?php
/**
 * Полоса сертификатов «Independently tested and certified» (`.idv-certs`) — универсальный блок: один вид, все тексты,
 * знаки и плашки — аргументы. Строка не пустеет и не переполняется при любом сочетании: нет знаков, нет плашек,
 * нет подписи — остаётся то, что передано; пустой набор — секция не выводится.
 *
 * Аргументы (значения по умолчанию пустые):
 *  - section_id — якорь секции (по умолчанию не выводится); от него же id подписи для aria-labelledby (по умолчанию certs-title);
 *  - title      — подпись (пусто — не выводится);
 *  - marks      — 0–N знаков сертификации: img (имя файла в img/ без `.webp`; есть и `@2x.webp`), w, h (размер в пикселях,
 *                 задаёт пропорции), alt, href (необязательная ссылка на сертификат), round (true — круглая обрезка
 *                 для знака на белом квадрате);
 *  - chips      — 0–N текстовых плашек: строка либо array('text' => …, 'icon' => HTML иконки);
 *  - chip_icon  — HTML иконки по умолчанию для плашек, у которых своей иконки нет (nv_kyc_icon('check', 20) и т. п.).
 */
$nv_ce_id    = (string) ($args['section_id'] ?? '');
$nv_ce_title = (string) ($args['title'] ?? '');
$nv_ce_marks = isset($args['marks']) ? (array) $args['marks'] : array();
$nv_ce_chips = isset($args['chips']) ? (array) $args['chips'] : array();
$nv_ce_icon  = (string) ($args['chip_icon'] ?? '');
$nv_ce_img   = get_template_directory_uri() . '/img/';
$nv_ce_title_id = ('' !== $nv_ce_id ? $nv_ce_id : 'certs') . '-title';

if ('' === $nv_ce_title && !$nv_ce_marks && !$nv_ce_chips) {
    return;
}
?>
<section class="idv-certs"<?php echo ('' !== $nv_ce_id) ? ' id="' . esc_attr($nv_ce_id) . '"' : ''; ?><?php echo ('' !== $nv_ce_title) ? ' aria-labelledby="' . esc_attr($nv_ce_title_id) . '"' : ''; ?>>
    <div class="container">
        <div class="idv-certs__inner">
            <?php if ('' !== $nv_ce_title || $nv_ce_marks) : ?>
            <div class="idv-certs__left">
                <?php if ($nv_ce_marks) : ?>
                <div class="idv-certs__badges">
                    <?php foreach ($nv_ce_marks as $nv_mark) :
                        $nv_mark_img = (string) ($nv_mark['img'] ?? '');
                        if ('' === $nv_mark_img) {
                            continue;
                        }
                        $nv_mark_w    = max(1, (int) ($nv_mark['w'] ?? 80));
                        $nv_mark_h    = max(1, (int) ($nv_mark['h'] ?? 80));
                        $nv_mark_alt  = (string) ($nv_mark['alt'] ?? '');
                        $nv_mark_href = (string) ($nv_mark['href'] ?? '');
                        $nv_mark_cls  = 'idv-certs__badge' . (!empty($nv_mark['round']) ? ' idv-certs__badge--round' : '');
                        $nv_mark_tag  = '<img class="' . esc_attr($nv_mark_cls) . '" src="' . esc_url($nv_ce_img . $nv_mark_img . '.webp') . '"'
                            . ' srcset="' . esc_url($nv_ce_img . $nv_mark_img . '.webp') . ' 1x, ' . esc_url($nv_ce_img . $nv_mark_img . '@2x.webp') . ' 2x"'
                            . ' width="' . $nv_mark_w . '" height="' . $nv_mark_h . '" alt="' . esc_attr($nv_mark_alt) . '"'
                            . ('' === $nv_mark_alt ? ' aria-hidden="true"' : '') . ' loading="lazy" decoding="async">';
                        if ('' !== $nv_mark_href) {
                            echo '<a class="idv-certs__badge-link" href="' . esc_url($nv_mark_href) . '" target="_blank" rel="noopener noreferrer">' . $nv_mark_tag . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
                        } else {
                            echo $nv_mark_tag; // phpcs:ignore WordPress.Security.EscapeOutput
                        }
                    endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if ('' !== $nv_ce_title) : ?>
                <p class="idv-certs__title" id="<?php echo esc_attr($nv_ce_title_id); ?>"><?php echo esc_html($nv_ce_title); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($nv_ce_chips) : ?>
            <ul class="idv-certs__tokens">
                <?php foreach ($nv_ce_chips as $nv_chip) :
                    $nv_chip_text = is_array($nv_chip) ? (string) ($nv_chip['text'] ?? '') : (string) $nv_chip;
                    $nv_chip_icon = is_array($nv_chip) && isset($nv_chip['icon']) ? (string) $nv_chip['icon'] : $nv_ce_icon;
                    if ('' === $nv_chip_text) {
                        continue;
                    }
                    ?>
                <li class="idv-certs__chip"><?php if ('' !== $nv_chip_icon) : ?><span class="idv-certs__chip-icon" aria-hidden="true"><?php echo $nv_chip_icon; // phpcs:ignore WordPress.Security.EscapeOutput ?></span><?php endif; ?><span class="idv-certs__chip-text"><?php echo esc_html($nv_chip_text); ?></span></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
