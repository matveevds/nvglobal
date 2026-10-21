<?php
/**
 * Hero NeuroNews — общий для archive (blog-archive.php: page/search/category) и author.php.
 * Вынесен из blog-archive.php, чтобы author.php переиспользовал тот же markup/CSS без копирования
 * (reuse-first, см. blog-author ТЗ). Аргумент `context`: page | search | category | author.
 *
 * Mobile-only исключение: на author этот hero не показывается (его нет в Mobile author-макете) —
 * скрытие через CSS `.blog-hero--author` на ≤767.98px, а не пропуск рендера, чтобы не плодить
 * условный вызов partial в двух местах.
 */

$context = $args['context'] ?? 'page';
// category/author делят одну editorial-ветку (Martel, crop, выступающий маскот, Tablet BR) — page/search
// остаются ровно 'blog-hero' (исходное поведение до выноса в partial).
$is_editorial = in_array($context, ['category', 'author'], true);
$hero_modifier = $is_editorial ? ' blog-hero--' . esc_attr($context) : '';
// A-06: на author этот hero скрыт на Mobile (.blog-hero--author, ≤767.98px) — <img> всё равно скачал бы
// texture/mascot независимо от display:none. <picture>+<source min-width:768> не грузит реальный файл
// ниже границы, отдавая 1×1 placeholder; page/search/category эту ветку не затрагивают (их hero виден
// на всех ширинах или имеет собственный Mobile-макет) и остаются на обычном <img>.
$hero_placeholder = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
?>
<section class="blog-hero<?php echo $hero_modifier; ?>">
    <span class="blog-hero__texture-wrap">
        <?php if ($context === 'author') : ?>
        <picture>
            <source media="(min-width: 768px)" srcset="<?php echo esc_url(get_template_directory_uri() . '/img/header-news-texture.webp'); ?>">
            <img class="blog-hero__texture" src="<?php echo esc_attr($hero_placeholder); ?>" alt="" width="1360" height="906" decoding="async">
        </picture>
        <?php else : ?>
        <img class="blog-hero__texture" src="<?php echo esc_url(get_template_directory_uri() . '/img/header-news-texture.webp'); ?>" alt="" width="1360" height="906" decoding="async">
        <?php endif; ?>
    </span>
    <div class="blog-hero__content">
        <p class="blog-hero__title"><span>Neuro</span>News</p>
        <p class="blog-hero__text">Our specialist media platform dedicated to anti-fraud <?php if (!$is_editorial) : ?><br><?php endif; ?>measures, KYC checks<?php if ($is_editorial) : ?><br class="blog-hero__text-break"><?php endif; ?> and facial recognition</p>
    </div>
    <?php if ($context === 'author') : ?>
    <picture class="blog-hero__mascot-wrap">
        <source media="(min-width: 768px)" srcset="<?php echo esc_url(get_template_directory_uri() . '/img/header-news-mascot.webp'); ?>">
        <img class="blog-hero__mascot" src="<?php echo esc_attr($hero_placeholder); ?>" alt="" width="374" height="238" decoding="async">
    </picture>
    <?php else : ?>
    <img class="blog-hero__mascot" src="<?php echo esc_url(get_template_directory_uri() . '/img/header-news-mascot.webp'); ?>" alt="" width="374" height="238" decoding="async">
    <?php endif; ?>
</section>
