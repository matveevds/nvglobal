<?php
/**
 * Блок «Видео» (`.video-embed`) — универсальный: один вид, не зависит от страницы, все тексты, постер и ролик — аргументы.
 * Стили — css/blocks/video.css, поведение — js/video-block.js (делегирование по `[data-nv-video]`; несколько блоков на
 * странице работают независимо). Figma: Full HD `2577:41363`, Desktop `2577:41304`, Tablet `2577:41349`, Mobile `2577:41356`.
 *
 * «Фасад»: до клика на странице только постер и кнопка play, никакого iframe и запросов к YouTube. По клику / Enter / Space
 * скрипт подменяет постер на iframe `youtube.com/embed/<id>?autoplay=1…` внутри той же рамки (высота не меняется).
 * Без JS кнопка остаётся ссылкой на ролик в YouTube (новая вкладка).
 *
 * Аргументы:
 *  - video_id    — id ролика YouTube (11 символов; без него блок не выводится);
 *  - poster      — array(src, w, h, alt?, small?): `src` — имя файла в img/ без расширения (`<src>.webp`), `w`/`h` — размеры
 *                  файла (16:9), `small` — array(src, w) уменьшенный вариант для узких экранов (srcset по ширине);
 *  - title       — название ролика: имя кнопки play, title у iframe и aria-label секции;
 *  - section_id  — id секции (необязательно);
 *  - heading     — заголовок H2 над рамкой (необязательно), lead — абзац под ним (необязательно);
 *  - caption     — подпись под рамкой (необязательно);
 *  - play_label  — подпись кнопки play (по умолчанию «Play video: <title>»);
 *  - alt         — альтернативный текст постера (по умолчанию пусто: постер декоративный).
 */
$nv_vd_id      = (string) ($args['video_id'] ?? '');
$nv_vd_poster  = isset($args['poster']) ? (array) $args['poster'] : array();
$nv_vd_title   = (string) ($args['title'] ?? '');
$nv_vd_section = (string) ($args['section_id'] ?? '');
$nv_vd_heading = (string) ($args['heading'] ?? '');
$nv_vd_lead    = (string) ($args['lead'] ?? '');
$nv_vd_caption = (string) ($args['caption'] ?? '');
$nv_vd_alt     = (string) ($args['alt'] ?? ($nv_vd_poster['alt'] ?? ''));
$nv_vd_label   = (string) ($args['play_label'] ?? '');

if (!preg_match('/^[A-Za-z0-9_-]{11}$/', $nv_vd_id)) {
    return;
}
if ('' === $nv_vd_label) {
    $nv_vd_label = '' !== $nv_vd_title ? 'Play video: ' . $nv_vd_title : 'Play video';
}
$nv_vd_img   = get_template_directory_uri() . '/img/';
$nv_vd_watch = 'https://www.youtube.com/watch?v=' . $nv_vd_id;
$nv_vd_src   = (string) ($nv_vd_poster['src'] ?? '');
$nv_vd_w     = (int) ($nv_vd_poster['w'] ?? 1920);
$nv_vd_h     = (int) ($nv_vd_poster['h'] ?? 1080);
$nv_vd_small = isset($nv_vd_poster['small']) ? (array) $nv_vd_poster['small'] : array();
$nv_vd_srcset = '';
if ('' !== $nv_vd_src && !empty($nv_vd_small['src'])) {
    $nv_vd_srcset = esc_url($nv_vd_img . $nv_vd_small['src'] . '.webp') . ' ' . (int) ($nv_vd_small['w'] ?? 960) . 'w, '
        . esc_url($nv_vd_img . $nv_vd_src . '.webp') . ' ' . $nv_vd_w . 'w';
}
?>
<section class="video-embed"<?php echo '' !== $nv_vd_section ? ' id="' . esc_attr($nv_vd_section) . '"' : ''; ?><?php echo '' !== $nv_vd_title ? ' aria-label="' . esc_attr($nv_vd_title) . '"' : ''; ?>>
    <div class="container">
        <?php if ('' !== $nv_vd_heading || '' !== $nv_vd_lead) : ?>
        <div class="video-embed__head">
            <?php if ('' !== $nv_vd_heading) : ?>
            <h2 class="kyc-title video-embed__title"><?php echo esc_html($nv_vd_heading); ?></h2>
            <?php endif; ?>
            <?php if ('' !== $nv_vd_lead) : ?>
            <p class="kyc-subtitle video-embed__lead"><?php echo esc_html($nv_vd_lead); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="video-embed__frame" data-nv-video data-video-id="<?php echo esc_attr($nv_vd_id); ?>" data-video-title="<?php echo esc_attr($nv_vd_title); ?>">
            <div class="video-embed__player">
                <?php if ('' !== $nv_vd_src) : ?>
                <img class="video-embed__poster" src="<?php echo esc_url($nv_vd_img . $nv_vd_src . '.webp'); ?>"<?php echo '' !== $nv_vd_srcset ? ' srcset="' . $nv_vd_srcset . '" sizes="calc(100vw - 54px)"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?> width="<?php echo $nv_vd_w; ?>" height="<?php echo $nv_vd_h; ?>" alt="<?php echo esc_attr($nv_vd_alt); ?>"<?php echo '' === $nv_vd_alt ? ' aria-hidden="true"' : ''; ?> loading="lazy" decoding="async">
                <?php endif; ?>
                <a class="video-embed__play" href="<?php echo esc_url($nv_vd_watch); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($nv_vd_label); ?>">
                    <svg class="video-embed__play-icon" width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.02176 10.5696C8.49906 15.2151 8.48611 20.2023 9.02281 25.4226C9.21219 26.9177 9.91756 27.9189 10.8339 28.4345C11.7575 28.9542 13.0692 29.0772 14.6436 28.4577C18.7984 26.783 22.5808 24.3173 25.6057 21.5783C26.8477 20.4353 27.3807 19.1588 27.3744 17.9688C27.3681 16.7763 26.8192 15.5207 25.6089 14.4246L25.6042 14.4204C22.4148 11.4996 18.7422 9.22109 14.6336 7.53828L14.6234 7.5341C13.241 6.95196 11.9305 7.02503 10.9518 7.53872C9.99172 8.04264 9.22515 9.03506 9.02176 10.5696ZM15.4914 5.45819C13.5769 4.65357 11.5566 4.68018 9.90612 5.54648C8.23756 6.42225 7.07706 8.08928 6.78952 10.2873L6.78709 10.3073C6.24336 15.1322 6.23233 20.2893 6.78592 25.6656L6.78865 25.6895C7.04995 27.7851 8.09607 29.4756 9.73044 30.3953C11.359 31.3118 13.3992 31.3667 15.4726 30.5495L15.4804 30.5463C19.8996 28.7657 23.9086 26.1512 27.1193 23.2431L27.1254 23.2376C28.7613 21.7337 29.6344 19.8764 29.6244 17.957C29.6142 16.0403 28.724 14.2111 27.1217 12.759C23.7249 9.64899 19.825 7.23381 15.4914 5.45819Z" fill="currentColor"/></svg>
                </a>
            </div>
        </div>

        <?php if ('' !== $nv_vd_caption) : ?>
        <p class="video-embed__caption"><?php echo esc_html($nv_vd_caption); ?></p>
        <?php endif; ?>
    </div>
</section>
