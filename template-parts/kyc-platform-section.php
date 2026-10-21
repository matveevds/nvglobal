<?php
/**
 * Секция Platform Bento (`.kyc-platform`) — универсальный блок: один вид, все тексты, картинки и id — аргументы.
 * Раскладка не зависит от страницы; любой необязательный элемент можно не передавать — место не резервируется.
 *
 * Аргументы (значения по умолчанию пустые):
 *  - section_id  — id секции (необязательно);
 *  - badge, title, lead — бейдж, заголовок, подзаголовок (пустые не выводятся);
 *  - top         — верхняя карточка: title, text, note (плашка справа/ниже), note_icon (HTML иконки, необязательно);
 *  - audit       — карточка с картинкой: title, text, img (имя файла в img/ без `.webp`, есть `@2x.webp`; пусто — без
 *                  картинки), w/h (размеры картинки, по умолчанию 255), alt (по умолчанию пусто — декоративная);
 *  - pair        — 1–3 карточки: title, text;
 *  - screen      — ноутбук со скриншотом: image (скриншот, имя файла в img/ без `.webp`), alt, w/h (по умолчанию 644×452),
 *                  laptop (имя файла ноутбука, по умолчанию identity-platform-laptop);
 *  - screen_html — вместо `screen`: готовый HTML содержимого серой панели (собственный макет), экранируется вызывающим;
 *  - summary     — текст нижней градиентной плашки (необязательно).
 * Серая панель выводится, если передан screen или screen_html.
 */
$nv_pl_id      = $args['section_id'] ?? '';
$nv_pl_badge   = $args['badge'] ?? '';
$nv_pl_title   = $args['title'] ?? '';
$nv_pl_lead    = $args['lead'] ?? '';
$nv_pl_top     = isset($args['top']) ? (array) $args['top'] : array();
$nv_pl_audit   = isset($args['audit']) ? (array) $args['audit'] : array();
$nv_pl_pair    = isset($args['pair']) ? (array) $args['pair'] : array();
$nv_pl_screen  = isset($args['screen']) ? (array) $args['screen'] : array();
$nv_pl_screen_html = $args['screen_html'] ?? '';
$nv_pl_summary = $args['summary'] ?? '';
$nv_pl_img_base = get_template_directory_uri() . '/img/';
$nv_pl_img = static function (string $name, int $w, int $h, string $class, string $alt = '', bool $lazy = true) use ($nv_pl_img_base): string {
    return '<img class="' . esc_attr($class) . '" src="' . esc_url($nv_pl_img_base . $name . '.webp') . '"'
        . ' srcset="' . esc_url($nv_pl_img_base . $name . '.webp') . ' 1x, ' . esc_url($nv_pl_img_base . $name . '@2x.webp') . ' 2x"'
        . ' width="' . $w . '" height="' . $h . '" alt="' . esc_attr($alt) . '"' . ('' === $alt ? ' aria-hidden="true"' : '')
        . ($lazy ? ' loading="lazy"' : '') . ' decoding="async">';
};
$nv_pl_has_screen = !empty($nv_pl_screen['image']) || '' !== $nv_pl_screen_html;
?>
<section class="kyc-section kyc-platform"<?php echo '' !== $nv_pl_id ? ' id="' . esc_attr($nv_pl_id) . '"' : ''; ?>>
    <div class="container">
        <?php if ('' !== $nv_pl_badge) : ?>
        <div class="section__badge"><?php echo esc_html($nv_pl_badge); ?></div>
        <?php endif; ?>
        <?php if ('' !== $nv_pl_title) : ?>
        <h2 class="kyc-title"><?php echo esc_html($nv_pl_title); ?></h2>
        <?php endif; ?>
        <?php if ('' !== $nv_pl_lead) : ?>
        <p class="kyc-subtitle"><?php echo esc_html($nv_pl_lead); ?></p>
        <?php endif; ?>
        <div class="kyc-platform__grid">
            <div class="kyc-platform__col">
                <?php if (!empty($nv_pl_top['title'])) : ?>
                <div class="kyc-card kyc-card--filled kyc-platform__case">
                    <div class="kyc-platform__case-text">
                        <h3 class="kyc-card__title kyc-card__title--lg"><?php echo esc_html($nv_pl_top['title']); ?></h3>
                        <?php if (!empty($nv_pl_top['text'])) : ?>
                        <p class="kyc-card__text kyc-card__text--md"><?php echo esc_html($nv_pl_top['text']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($nv_pl_top['note'])) : ?>
                    <div class="kyc-platform__note">
                        <?php if (!empty($nv_pl_top['note_icon'])) : ?>
                        <span class="kyc-icon-box" aria-hidden="true"><?php echo $nv_pl_top['note_icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                        <?php endif; ?>
                        <p class="kyc-platform__note-text"><?php echo esc_html($nv_pl_top['note']); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($nv_pl_audit['title']) || $nv_pl_pair) : ?>
                <div class="kyc-platform__row">
                    <?php if (!empty($nv_pl_audit['title'])) : ?>
                    <div class="kyc-card kyc-platform__audit">
                        <h3 class="kyc-card__title kyc-card__title--lg"><?php echo esc_html($nv_pl_audit['title']); ?></h3>
                        <?php if (!empty($nv_pl_audit['text'])) : ?>
                        <p class="kyc-card__text kyc-card__text--md"><?php echo esc_html($nv_pl_audit['text']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($nv_pl_audit['img'])) :
                            $nv_aw = (int) ($nv_pl_audit['w'] ?? 255);
                            $nv_ah = (int) ($nv_pl_audit['h'] ?? $nv_aw);
                            echo $nv_pl_img($nv_pl_audit['img'], $nv_aw, $nv_ah, 'kyc-platform__audit-image', (string) ($nv_pl_audit['alt'] ?? '')); // phpcs:ignore WordPress.Security.EscapeOutput
                        endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($nv_pl_pair) : ?>
                    <div class="kyc-platform__pair">
                        <?php foreach ($nv_pl_pair as $nv_pc) : ?>
                        <div class="kyc-card kyc-card--filled">
                            <h3 class="kyc-card__title"><?php echo esc_html($nv_pc['title'] ?? ''); ?></h3>
                            <?php if (!empty($nv_pc['text'])) : ?>
                            <p class="kyc-card__text kyc-card__text--md"><?php echo esc_html($nv_pc['text']); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($nv_pl_has_screen) : ?>
            <div class="kyc-platform__screen">
                <?php if ('' !== $nv_pl_screen_html) : ?>
                <div class="kyc-platform__screen-custom"><?php echo $nv_pl_screen_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                <?php else : ?>
                <div class="kyc-platform__laptop-wrap">
                    <?php
                    echo $nv_pl_img((string) ($nv_pl_screen['laptop'] ?? 'identity-platform-laptop'), 400, 235, 'kyc-platform__laptop'); // phpcs:ignore WordPress.Security.EscapeOutput
                    echo $nv_pl_img((string) $nv_pl_screen['image'], (int) ($nv_pl_screen['w'] ?? 644), (int) ($nv_pl_screen['h'] ?? 452), 'kyc-platform__screen-img', (string) ($nv_pl_screen['alt'] ?? '')); // phpcs:ignore WordPress.Security.EscapeOutput
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php if ('' !== $nv_pl_summary) : ?>
        <div class="kyc-platform__summary">
            <p><?php echo esc_html($nv_pl_summary); ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>
