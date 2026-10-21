<?php
/*
Template Name: Каталог блоков
*/

/**
 * Картотека блоков сайта. Открывается по `?nv_bloki=1` (template_include, inc/block-catalog.php),
 * только для авторизованного администратора (manage_options; остальным — 404), без записи в БД. Блоки показываются кадрами настоящих страниц
 * (`?nv_block=<селектор>`), Gutenberg-блоки — в оболочке записи (`?nv_bloki_demo=<slug>`).
 *
 * Тот же файл рисует демо-оболочку: при `?nv_bloki_demo=` выводится только запись-обёртка
 * с блоком (шапка/подвал скрыты режимом кадра).
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!nv_block_catalog_can()) {
    status_header(404);
    nocache_headers();
    include get_query_template('404');
    return;
}

$nv_demo_slug = nv_block_demo_slug();

/* ---------- Демо-оболочка Gutenberg-блока ---------- */
if ('' !== $nv_demo_slug) {
    $nv_demos = nv_block_catalog_demos();
    $nv_demo  = $nv_demos[$nv_demo_slug];
    /* `markup` — готовая разметка блоков (вложенные / core-блоки); иначе один ACF-блок из `block` + `data`. */
    $nv_markup = !empty($nv_demo['markup'])
        ? $nv_demo['markup']
        : '<!-- wp:' . $nv_demo['block'] . ' ' . wp_json_encode(array(
            'name' => $nv_demo['block'],
            'data' => $nv_demo['data'],
            'mode' => 'preview',
        )) . ' /-->';
    get_header();
    ?>
<main class="main-post">
    <section class="post">
        <div class="container">
            <div class="post__wrapper">
                <div class="post__content">
                    <article class="post-content">
                        <div class="post-text entry-content nv-bloki-demo">
                            <?php echo do_blocks($nv_markup); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</main>
    <?php
    get_footer();
    return;
}

/* ---------- Стресс-кадр универсального блока ---------- */
$nv_stress_slug = nv_block_stress_slug();
if ('' !== $nv_stress_slug) {
    $nv_stress = nv_block_stress_registry()[$nv_stress_slug];
    get_header();
    ?>
<main class="nv-bloki-stress">
    <?php get_template_part($nv_stress['part'], null, $nv_stress['args']); ?>
</main>
    <?php
    get_footer();
    return;
}

/* ---------- Страница каталога ---------- */
$nv_data = require get_template_directory() . '/inc/bloki-data.php';

/** Адрес кадра: страница + `nv_block`, либо демо-оболочка. */
$nv_frame_src = function (array $block): string {
    if (!empty($block['demo']['slug'])) {
        return add_query_arg('nv_bloki_demo', $block['demo']['slug'], home_url('/'));
    }
    if (!empty($block['stress']['slug'])) {
        return add_query_arg('nv_bloki_stress', $block['stress']['slug'], home_url('/'));
    }
    return add_query_arg('nv_block', rawurlencode($block['frame']['selector']), home_url($block['frame']['url']));
};

/** Ссылка «открыть на странице»: настоящая страница, якорь — `#id`, если селектор по id. */
$nv_page_link = function (array $block): string {
    if (!empty($block['demo']['slug'])) {
        return add_query_arg('nv_bloki_demo', $block['demo']['slug'], home_url('/'));
    }
    if (!empty($block['stress']['slug'])) {
        return add_query_arg('nv_bloki_stress', $block['stress']['slug'], home_url('/'));
    }
    $link = home_url($block['frame']['url']);
    if (0 === strpos($block['frame']['selector'], '#') && preg_match('/^#[A-Za-z0-9_\-]+$/', $block['frame']['selector'])) {
        $link .= $block['frame']['selector'];
    }
    return $link;
};

/* Номера — сквозные по порядку групп (в данных не хранятся, чтобы вставка блока не сдвигала их вручную). */
$nv_total = 0;
foreach ($nv_data['groups'] as $nv_gi => $nv_g) {
    foreach ($nv_g['blocks'] as $nv_bi => $nv_b) {
        $nv_total++;
        $nv_data['groups'][$nv_gi]['blocks'][$nv_bi]['num'] = sprintf('%02d', $nv_total);
    }
}
$nv_widths = array(1920, 1600, 1440, 1200, 1100, 992, 840, 740, 392);

/** Текст подписи: экранирование + `код` → <code>код</code>. */
$nv_md = static function (string $text): string {
    return preg_replace('/`([^`]+)`/', '<code>$1</code>', esc_html($text));
};

/*
 * ?nv_bloki=unique — каталог уникальных блоков: тот же компонент с разным контентом — одна позиция с вариантами.
 * Строится из полного каталога (номера выше) и карты inc/bloki-unique.php; данные блоков не дублируются.
 */
$nv_unique    = isset($_GET['nv_bloki']) && 'unique' === sanitize_key(wp_unslash($_GET['nv_bloki']));
$nv_full_total = $nv_total;
if ($nv_unique) {
    $nv_flat = array();
    foreach ($nv_data['groups'] as $nv_g) {
        foreach ($nv_g['blocks'] as $nv_b) {
            $nv_flat[(int) $nv_b['num']] = $nv_b;
        }
    }
    $nv_map    = require get_template_directory() . '/inc/bloki-unique.php';
    $nv_groups = array();
    $nv_total  = 0;
    foreach ($nv_map['groups'] as $nv_g) {
        $nv_items = array();
        foreach ($nv_g['items'] as $nv_item) {
            $nv_total++;
            if (is_int($nv_item)) {
                $nv_b              = $nv_flat[$nv_item];
                $nv_b['full_nums'] = array($nv_item);
            } else {
                $nv_m     = $nv_map['merges'][$nv_item];
                $nv_nums  = array_keys($nv_m['variants']);
                $nv_b     = array_merge($nv_flat[$nv_nums[0]], array_intersect_key($nv_m, array_flip(array('name', 'desc', 'usage', 'source', 'edit', 'deps'))));
                $nv_b['full_nums'] = $nv_nums;
                $nv_b['variants']  = array();
                foreach ($nv_m['variants'] as $nv_vn => $nv_vlabel) {
                    if ('' !== $nv_vlabel) {
                        $nv_b['variants'][] = array('label' => $nv_vlabel, 'block' => $nv_flat[$nv_vn]);
                    }
                }
            }
            $nv_b['num'] = sprintf('%02d', $nv_total);
            $nv_items[]  = $nv_b;
        }
        $nv_groups[] = array('title' => $nv_g['title'], 'note' => $nv_g['note'] ?? '', 'blocks' => $nv_items);
    }
    $nv_data['groups'] = $nv_groups;
}

get_header();
?>
<main class="bloki">
    <section class="bloki-intro">
        <div class="container">
            <?php if ($nv_unique) : ?>
            <h1 class="bloki-intro__title">Уникальные блоки NeuroVision Global</h1>
            <p class="bloki-intro__text"><?php echo (int) $nv_total; ?> уникальных блоков вместо <?php echo (int) $nv_full_total; ?> позиций полного каталога: один и тот же компонент с разным контентом (тот же partial или корневой класс, отличия — тексты, число элементов, модификатор, body-класс страницы) показан один раз, его варианты переключаются кнопками в подписи. Похожие блоки с разным кодом оставлены отдельными. Группы — по назначению. У каждого блока — номер, название, описание, применение, источник в теме, что менять и зависимости. Блоки показаны живыми кадрами настоящих страниц: в кадре работают стили и скрипты своей страницы, переключатель ширины меняет адаптив текущего варианта. Кадр загружается при подходе к нему. Модалки и cookie-баннер открываются кнопкой. Каталог виден только редакторам. <a class="bloki-intro__link" href="<?php echo esc_url(add_query_arg('nv_bloki', '1', home_url('/'))); ?>">Полный каталог (<?php echo (int) $nv_full_total; ?>) →</a></p>
            <?php else : ?>
            <h1 class="bloki-intro__title">Каталог блоков NeuroVision Global</h1>
            <p class="bloki-intro__text"><a class="bloki-intro__link" href="<?php echo esc_url(add_query_arg('nv_bloki', 'unique', home_url('/'))); ?>">Только уникальные блоки →</a></p>
            <?php endif; ?>
            <?php if (!$nv_unique) : ?>
            <p class="bloki-intro__text">Реализованные секции сайта — <?php echo (int) $nv_full_total; ?> блоков. У каждого — номер, название, описание, применение, источник в теме, что менять и зависимости. Блоки показаны живыми кадрами настоящих страниц: в кадре работают стили и скрипты своей страницы, переключатель ширины меняет адаптив. Кадр загружается при подходе к нему. Модалки и cookie-баннер открываются кнопкой. Каталог виден только редакторам.</p>
            <?php endif; ?>

            <div class="bloki-memo" id="memo">
                <h2 class="bloki-memo__title">Как собрать новую страницу</h2>
                <ol class="bloki-memo__list">
                    <li><b>Шаблон.</b> Новый <code>page-&lt;slug&gt;.php</code> с <code>Template Name</code>, <code>get_header()</code> / <code>get_footer()</code>, секции внутри <code>&lt;main&gt;</code>, в конце — <code>include …/template-parts/teaser.php</code>. Partials подключать через <code>get_template_part()</code> с аргументами (см. «Источник» у блока).</li>
                    <li><b>Дописать body-класс шаблона</b> (<code>page-template-page-&lt;slug&gt;</code>) в списки, без которых блок теряет цвета и сетку:
                        <ul>
                            <li>токены <code>--nv-*</code> — <code>css/styles.css</code> ~675 (список <code>body.home, body.page-template-…</code>);</li>
                            <li><code>.container</code> — <code>css/styles.css</code> ~820 и ~855 (мобильный);</li>
                            <li><code>nv_is_light_theme()</code> — <code>functions.php</code> ~2194: светлые шапка, подвал и логотип тизера;</li>
                            <li>Contacts — ≈160 списков <code>body.page-template-page-solutions .contacts …</code> (<code>css/styles.css</code> с ~9540), FAQ — ~19833, Teaser — ~11878, Footer — ~12469;</li>
                            <li>светлые выпадающие списки формы — контексты правил <code>.modal--form .phone-field__*</code> (~14300) и подъём секции через <code>:has()</code> (~10862, Р-147).</li>
                        </ul>
                    </li>
                    <li><b>Варианты общих блоков привязаны к страницам.</b> Identity-вид Steps / Platform / Industries / Pricing / About / Integration / Contacts / FAQ держится на <code>body.page-template-page-identity-verification</code> (647 правил) и модификаторах <code>idv-*</code>; KYC — 389, Solutions — 385 правил. На новой странице такой вариант появится только с body-классом исходной страницы либо после переноса стилей на модификатор (рефакторинг — отдельным решением).</li>
                    <li><b>JS берёт только первый экземпляр.</b> <code>initKycPage</code>, <code>initSolutionsWhy</code>, <code>initCoverage</code>, <code>initIntegrationSlider</code>, <code>initNewsSlider</code>, <code>initProductsSlider</code>, <code>initIndustriesSlider</code> ищут блок через <code>querySelector</code>: второй однотипный блок на странице не оживёт. Повторяются <code>id</code> (<code>#faq</code>, <code>#solutions</code>, <code>#how-it-works</code>, <code>#integration</code>, <code>#security</code>, <code>faq-question-N</code>) — якоря и <code>aria-controls</code> конфликтуют.</li>
                    <li><b>Тексты и картинки.</b> Тексты — в <code>inc/*-data.php</code> или в разметке (поле «Что менять»), картинки — <code>img/</code> парами <code>name.webp</code> + <code>name@2x.webp</code>. Новые токены <code>--island-*</code> / <code>--stroke-*</code> / <code>--text-*</code> не объявлять.</li>
                    <li><b>Статьи блога</b> собираются из Gutenberg-блоков в редакторе записи; формат импорта — <code>docs/BLOG-IMPORT-GUIDE.md</code>.</li>
                </ol>
            </div>
            <nav class="bloki-toc" aria-label="Оглавление каталога">
                <ol class="bloki-toc__list">
                    <?php foreach ($nv_data['groups'] as $nv_g) : ?>
                    <li class="bloki-toc__group"><?php echo esc_html($nv_g['title']); ?></li>
                    <?php foreach ($nv_g['blocks'] as $nv_b) : ?>
                    <li class="bloki-toc__item"><a class="bloki-toc__link" href="#block-<?php echo esc_attr($nv_b['num']); ?>"><span class="bloki-toc__num"><?php echo esc_html($nv_b['num']); ?></span><?php echo esc_html($nv_b['name']); ?></a></li>
                    <?php endforeach; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    </section>

    <div class="bloki-switch" data-bloki-switch role="group" aria-label="Ширина кадров">
        <div class="container bloki-switch__inner">
            <span class="bloki-switch__label">Ширина кадров</span>
            <?php foreach ($nv_widths as $nv_i => $nv_w) : ?>
            <button type="button" class="bloki-switch__btn<?php echo 1440 === (int) $nv_w ? ' is-active' : ''; ?>" data-vw="<?php echo (int) $nv_w; ?>" aria-pressed="<?php echo 1440 === (int) $nv_w ? 'true' : 'false'; ?>"><?php echo (int) $nv_w; ?></button>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach ($nv_data['groups'] as $nv_g) : ?>
    <h2 class="bloki-group"><?php echo esc_html($nv_g['title']); ?></h2>
    <?php if (!empty($nv_g['note'])) : ?>
    <p class="bloki-group__note"><?php echo $nv_md($nv_g['note']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
    <?php endif; ?>

    <?php foreach ($nv_g['blocks'] as $nv_b) : ?>
    <div class="bloki-item" data-bloki-item>
        <div class="bloki-label" id="block-<?php echo esc_attr($nv_b['num']); ?>">
            <div class="bloki-label__inner">
                <p class="bloki-label__head"><span class="bloki-label__num"><?php echo esc_html($nv_b['num']); ?></span><span class="bloki-label__name"><?php echo esc_html($nv_b['name']); ?></span></p>
                <p class="bloki-label__desc"><?php echo $nv_md($nv_b['desc']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
                <p class="bloki-label__meta"><b>Применение:</b> <?php echo $nv_md($nv_b['usage']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
                <p class="bloki-label__meta"><b>Источник:</b> <?php echo $nv_md($nv_b['source']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
                <p class="bloki-label__meta"><b>Что менять:</b> <?php echo $nv_md($nv_b['edit']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
                <p class="bloki-label__meta bloki-label__meta--scope"><b>Зависимости:</b> <?php echo $nv_md($nv_b['deps']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
                <?php if (!empty($nv_b['full_nums'])) : ?>
                <p class="bloki-label__meta"><b>В полном каталоге:</b> № <?php echo esc_html(implode(', № ', array_map(static function ($n) { return sprintf('%02d', $n); }, $nv_b['full_nums']))); ?></p>
                <?php endif; ?>
                <?php if (!empty($nv_b['variants']) && count($nv_b['variants']) > 1) : ?>
                <div class="bloki-label__tools" data-bloki-variants>
                    <span class="bloki-label__tools-label">Вариант</span>
                    <?php foreach ($nv_b['variants'] as $nv_vi => $nv_v) : ?>
                    <button type="button" class="bloki-item__vw bloki-item__variant<?php echo 0 === $nv_vi ? ' is-active' : ''; ?>" aria-pressed="<?php echo 0 === $nv_vi ? 'true' : 'false'; ?>" data-variant-src="<?php echo esc_url($nv_frame_src($nv_v['block'])); ?>" data-variant-page="<?php echo esc_url($nv_page_link($nv_v['block'])); ?>" data-variant-min-h="<?php echo (int) ($nv_v['block']['frame']['min_h'] ?? 0); ?>"><?php echo esc_html($nv_v['label']); ?></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if (empty($nv_b['action'])) : ?>
                <div class="bloki-label__tools">
                    <span class="bloki-label__tools-label">Ширина этого блока</span>
                    <?php foreach ($nv_widths as $nv_w) : ?>
                    <button type="button" class="bloki-item__vw" data-item-vw="<?php echo (int) $nv_w; ?>"><?php echo (int) $nv_w; ?></button>
                    <?php endforeach; ?>
                    <a class="bloki-label__link" href="<?php echo esc_url($nv_page_link($nv_b)); ?>" target="_blank" rel="noopener" data-bloki-page-link>Открыть на странице</a>
                    <a class="bloki-label__link" href="<?php echo esc_url($nv_frame_src($nv_b)); ?>" target="_blank" rel="noopener" data-bloki-frame-link>Кадр отдельно</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($nv_b['action'])) : ?>
        <div class="bloki-action">
            <div class="container bloki-action__inner">
                <?php foreach ((array) $nv_b['action'] as $nv_act) : ?>
                <?php if ('modal' === $nv_act['type']) : ?>
                <button type="button" class="bloki-action__btn" data-bloki-modal="<?php echo esc_attr($nv_act['id']); ?>"><?php echo esc_html($nv_act['label']); ?></button>
                <?php elseif ('cookie' === $nv_act['type']) : ?>
                <button type="button" class="bloki-action__btn" data-bloki-cookie><?php echo esc_html($nv_act['label']); ?></button>
                <?php else : ?>
                <p class="bloki-action__note"><?php echo $nv_md($nv_act['label']); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else : ?>
        <div class="bloki-frame" data-bloki-frame>
            <div class="bloki-frame__stage" data-bloki-stage>
                <iframe class="bloki-frame__iframe" title="<?php echo esc_attr($nv_b['name']); ?>" data-src="<?php echo esc_url($nv_frame_src($nv_b)); ?>"<?php echo !empty($nv_b['frame']['min_h']) ? ' data-min-h="' . (int) $nv_b['frame']['min_h'] . '"' : ''; ?> scrolling="no" width="1440" height="600"></iframe>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    <?php endforeach; ?>
</main>
<?php
get_footer();
