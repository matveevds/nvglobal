<?php
/**
 * Первый экран продуктовой страницы (`section.main.main--hero`). Универсальный блок: один вид, не зависит от
 * страницы и body-класса; все тексты, кнопки, факты и картинки — аргументы.
 *
 * Аргументы:
 *  - title, subtitle — wp_kses_post (может содержать &nbsp;/<br>);
 *  - primary_btn / secondary_btn — array(text, mobile_text?, href?): без href основная кнопка открывает форму
 *    (`.open-callForm2`); `mobile_text` — подпись на ≤767, без неё на мобильных остаётся `text` (кнопка никогда
 *    не остаётся без текста);
 *  - facts[] — 3–4 плашки array(icon_html, text, mobile_text?); столбец справа на ≥992, лента ниже;
 *  - media — array(src, w, h, alt, fhd?, desktop?, tablet?, mobile?, focus?, focus_tablet?, focus_mobile?):
 *    `src` — имя файла в img/ без расширения (читаются `<src>.webp` и `<src>@2x.webp`), `w`/`h` — размеры файла;
 *    fhd (≥1600), desktop (992–1599), laptop (992–1199; если задан, desktop — 1200–1599), tablet (768–991),
 *    mobile (≤767) — необязательные array(src, w, h) отдельных кадров, где их нет — берётся основной `src`
 *    (laptop нужен, если в основной картинке есть вшитые карточки, на которые на узкой карточке заходит H1); focus* — `object-position` кадра (по умолчанию `50% 50%`);
 *  - media_html — готовая разметка вместо `media` (строка, выводится как есть);
 *  - arrow_icon — inline SVG стрелки кнопок.
 * Затемнение под текстом — часть блока (`.main__media::after`), вшивать тень в картинку не нужно.
 */
$nv_h_media_html = $args['media_html'] ?? '';
$nv_h_media      = isset($args['media']) ? (array) $args['media'] : array();
$nv_h_title      = $args['title'] ?? '';
$nv_h_subtitle   = $args['subtitle'] ?? '';
$nv_h_primary    = $args['primary_btn'] ?? array();
$nv_h_secondary  = $args['secondary_btn'] ?? array();
$nv_h_facts      = isset($args['facts']) ? (array) $args['facts'] : array();
$nv_h_arrow      = $args['arrow_icon'] ?? '';
$nv_h_img        = get_template_directory_uri() . '/img/';

/* Источник кадра: `<src>.webp 1x, <src>@2x.webp 2x`. */
$nv_h_srcset = static function (string $src) use ($nv_h_img): string {
    return esc_url($nv_h_img . $src . '.webp') . ' 1x, ' . esc_url($nv_h_img . $src . '@2x.webp') . ' 2x';
};
/* `object-position` приходит из аргументов — пропускаем только цифры, проценты, единицы и ключевые слова. */
$nv_h_focus = static function ($value): string {
    $value = is_string($value) ? trim($value) : '';
    return preg_match('/^[a-z0-9%.\s-]{1,40}$/i', $value) ? $value : '';
};

if ('' === $nv_h_media_html && !empty($nv_h_media['src'])) {
    /* Диапазоны не пересекаются: если задан laptop (992–1199), desktop действует на 1200–1599. */
    $nv_h_ranges = array(
        'fhd'     => '(min-width: 1600px)',
        'desktop' => !empty($nv_h_media['laptop']['src']) ? '(min-width: 1200px) and (max-width: 1599.98px)' : '(min-width: 992px) and (max-width: 1599.98px)',
        'laptop'  => '(min-width: 992px) and (max-width: 1199.98px)',
        'tablet'  => '(min-width: 768px) and (max-width: 991.98px)',
        'mobile'  => '(max-width: 767.98px)',
    );
    $nv_h_style = '';
    foreach (array('focus' => '--hero-pos', 'focus_tablet' => '--hero-pos-tablet', 'focus_mobile' => '--hero-pos-mobile') as $nv_h_key => $nv_h_var) {
        $nv_h_pos = $nv_h_focus($nv_h_media[$nv_h_key] ?? '');
        if ('' !== $nv_h_pos) {
            $nv_h_style .= $nv_h_var . ':' . $nv_h_pos . ';';
        }
    }
    $nv_h_alt = (string) ($nv_h_media['alt'] ?? '');
    ob_start();
    ?>
    <picture class="main__media"<?php echo '' !== $nv_h_style ? ' style="' . esc_attr($nv_h_style) . '"' : ''; ?>>
        <?php foreach ($nv_h_ranges as $nv_h_name => $nv_h_query) :
            $nv_h_frame = $nv_h_media[$nv_h_name] ?? null;
            if (empty($nv_h_frame['src'])) {
                continue;
            }
            ?>
        <source media="<?php echo esc_attr($nv_h_query); ?>" srcset="<?php echo $nv_h_srcset($nv_h_frame['src']); // phpcs:ignore WordPress.Security.EscapeOutput ?>"<?php echo !empty($nv_h_frame['w']) ? ' width="' . (int) $nv_h_frame['w'] . '" height="' . (int) ($nv_h_frame['h'] ?? 0) . '"' : ''; ?>>
        <?php endforeach; ?>
        <img src="<?php echo esc_url($nv_h_img . $nv_h_media['src'] . '.webp'); ?>" srcset="<?php echo $nv_h_srcset($nv_h_media['src']); // phpcs:ignore WordPress.Security.EscapeOutput ?>" width="<?php echo (int) ($nv_h_media['w'] ?? 1600); ?>" height="<?php echo (int) ($nv_h_media['h'] ?? 1056); ?>" alt="<?php echo esc_attr($nv_h_alt); ?>"<?php echo '' === $nv_h_alt ? ' aria-hidden="true"' : ''; ?> fetchpriority="high" decoding="async">
    </picture>
    <?php
    $nv_h_media_html = ob_get_clean();
}

/* Кнопка: основная без href открывает форму; подпись `mobile_text` показывается на ≤767 вместо `text`. */
$nv_h_btn_texts = static function (array $btn): string {
    $text   = (string) ($btn['text'] ?? '');
    $mobile = (string) ($btn['mobile_text'] ?? '');
    $out    = '<span class="main__btn-text main__btn-text--wide">' . esc_html($text) . '</span>';
    if ('' !== $mobile && $mobile !== $text) {
        $out .= '<span class="main__btn-text main__btn-text--mobile">' . esc_html($mobile) . '</span>';
    }
    return $out;
};
?>
<section class="main main--hero">
    <div class="container">
        <div class="main__card">
            <?php echo $nv_h_media_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>

            <div class="main__body">
                <img class="main__logo" src="<?php echo esc_url($nv_h_img . 'logo-hero.svg'); ?>" width="206" height="39" alt="NeuroVision Global Systems">

                <div class="main__group">
                    <div class="main__content">
                        <h1 class="main__title"><?php echo wp_kses_post($nv_h_title); ?></h1>
                        <?php if ('' !== $nv_h_subtitle) : ?>
                        <p class="main__subtitle"><?php echo wp_kses_post($nv_h_subtitle); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="main__actions">
                        <?php if (!empty($nv_h_primary['href'])) : ?>
                        <a class="main__btn main__btn--primary" href="<?php echo esc_url($nv_h_primary['href']); ?>">
                        <?php else : ?>
                        <button class="main__btn main__btn--primary open-callForm2" type="button">
                        <?php endif; ?>
                            <?php echo $nv_h_btn_texts($nv_h_primary); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                            <span class="main__btn-icon"><?php echo $nv_h_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                        <?php echo !empty($nv_h_primary['href']) ? '</a>' : '</button>'; ?>
                        <?php if (!empty($nv_h_secondary['text'])) : ?>
                        <a class="main__btn main__btn--ghost" href="<?php echo esc_url($nv_h_secondary['href'] ?? '#how-it-works'); ?>">
                            <?php echo $nv_h_btn_texts($nv_h_secondary); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                            <span class="main__btn-icon"><?php echo $nv_h_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($nv_h_facts) : ?>
            <ul class="main__facts">
                <?php foreach ($nv_h_facts as $nv_fact) : ?>
                <li class="main__fact">
                    <span class="main__fact-icon" aria-hidden="true"><?php echo $nv_fact['icon_html'] ?? ''; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                    <span class="main__fact-title main__fact-title--wide"><?php echo wp_kses_post($nv_fact['text'] ?? ''); ?></span>
                    <?php if (!empty($nv_fact['mobile_text'])) : ?>
                    <span class="main__fact-title main__fact-title--mobile"><?php echo wp_kses_post($nv_fact['mobile_text']); ?></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
