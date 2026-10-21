<?php
/**
 * Author archive template (canonical, реальные WP-данные): Figma NV Global
 * Full HD 2570:33393, Desktop 2570:31497, Tablet 1381:25698, Mobile 1381:26059.
 *
 * Reuse: template-parts/blog-hero.php (скрыт на Mobile — его нет в Mobile-макете),
 * template-parts/blog-card.php (author-only геометрия через body.nv-author в css/blog.css),
 * .blog-cats / .blog-archive__grid / .blog-pagination из той же светлой системы, что
 * category.php/search.php/blog-page.php. Главный WP_Query — основной запрос страницы
 * (пагинация настоящая, posts_per_page через pre_get_posts → NV_AUTHOR_PER_PAGE),
 * не вторичный paged=1 + «Show more», как было раньше.
 */

get_header();

$author = get_queried_object();

if (!$author || empty($author->ID)) {
    get_footer();
    return;
}

$author_id          = (int) $author->ID;
$author_name        = nv_author_display_name($author_id);
$author_job         = trim((string) get_user_meta($author_id, 'job_title', true));
$author_description = trim((string) get_the_author_meta('description', $author_id));
$author_slug        = get_the_author_meta('user_nicename', $author_id);

// Корпоративный аккаунт определяется по текущему реальному slug (не по ID) — показывает
// фирменный N-mark вместо get_avatar(); остальные авторы не затронуты.
$is_corporate = ($author_slug === 'neurovision');

$author_url         = get_author_posts_url($author_id);
$author_posts_count = (int) count_user_posts($author_id, 'post', true);

/**
 * Категории — реальные ссылки, счётчик только по записям текущего автора (как в исходном
 * author.php). «All topic» ведёт обратно на эту же author-страницу, а не на /blog/ — это
 * единственный «сброс фильтра» для author-контекста.
 */
$categories = get_categories(['taxonomy' => 'category', 'hide_empty' => false]);
$author_category_counts = [];
$author_posts_for_count = get_posts([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'author'         => $author_id,
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);
foreach ($author_posts_for_count as $author_post_id) {
    foreach (get_the_category($author_post_id) as $post_category) {
        $term_id = (int) $post_category->term_id;
        $author_category_counts[$term_id] = ($author_category_counts[$term_id] ?? 0) + 1;
    }
}

// Главный запрос страницы: posts_per_page уже выставлен pre_get_posts (NV_AUTHOR_PER_PAGE).
$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$grid  = $GLOBALS['wp_query'];
$total = max(1, (int) $grid->max_num_pages);

/**
 * Соцсети: реальных per-user social meta-полей в этой установке WP нет — только core
 * `user_url`. Для корпоративного аккаунта дополнительно разрешено использовать уже
 * настроенный реальный LinkedIn из footer.php. Иконки — общие шаренные helpers
 * (nv_contacts_icon, nv_blog_icon), без новых SVG и без href="#".
 */
require_once get_template_directory() . '/template-parts/contacts-icons.php';

$socials = [];
$author_website = trim((string) get_the_author_meta('url', $author_id));
if ($author_website !== '') {
    $socials[] = [
        'url'   => $author_website,
        'label' => 'Website',
        'icon'  => nv_blog_icon('network'),
    ];
}
if ($is_corporate) {
    $socials[] = [
        'url'   => 'https://www.linkedin.com/company/nvglobal-ai/posts/',
        'label' => 'NeuroVision Global Systems on LinkedIn',
        'icon'  => nv_contacts_icon('linkedin', 24),
    ];
}

if ($is_corporate) {
    $avatar_html = '<img class="author-profile__avatar-img" src="' . esc_url(get_template_directory_uri() . '/img/author-corporate-mark.png') . '" width="140" height="140" alt="" loading="eager" decoding="async">';
} else {
    $avatar_html = get_avatar($author_id, 280, '', $author_name, [
        'class'    => 'author-profile__avatar-img',
        'loading'  => 'eager',
        'decoding' => 'async',
    ]);
}
?>

<main>
    <?php get_template_part('template-parts/blog-hero', null, ['context' => 'author']); ?>

    <section class="blog-archive blog-archive--author">
        <div class="container">
            <div class="breadcrumbs"><?php nv_breadcrumbs(); ?></div>

            <div class="author-layout">
                <div class="author-profile">
                    <div class="author-profile__avatar"><?php echo $avatar_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                    <div class="author-profile__body">
                        <div class="author-profile__head">
                            <div class="author-profile__identity">
                                <p class="author-profile__name"><?php echo esc_html($author_name); ?></p>
                                <?php if ($author_job !== '') : ?>
                                    <p class="author-profile__job"><?php echo esc_html($author_job); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if ($socials) : ?>
                                <div class="author-profile__socials">
                                    <?php foreach ($socials as $social) : ?>
                                        <a class="author-profile__social" href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social['label']); ?>"><?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($author_description !== '') : ?>
                            <div class="author-profile__bio"><?php echo wp_kses_post(wpautop($author_description)); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="author-content">
                    <div class="blog-archive__head blog-archive__head--author">
                        <h1 class="blog-archive__title">Popular articles by <?php echo esc_html($author_name); ?></h1>
                    </div>

                    <div class="blog-archive__layout blog-archive__layout--no-news blog-archive__layout--author">
                        <nav class="blog-cats blog-cats--author" aria-label="Author topics">
                            <a class="blog-cats__all is-active" href="<?php echo esc_url($author_url); ?>" aria-current="page">All topic (<?php echo (int) $author_posts_count; ?>)</a>
                            <ul class="blog-cats__list">
                                <?php foreach ($categories as $category) :
                                    $cat_count = (int) ($author_category_counts[(int) $category->term_id] ?? 0);
                                    if ($cat_count <= 0) {
                                        continue;
                                    }
                                ?>
                                    <li><a class="blog-cats__link" href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?> (<?php echo $cat_count; ?>)</a></li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>

                        <div class="blog-archive__main">
                            <?php if ($grid->have_posts()) : ?>
                                <div class="blog-archive__grid">
                                    <?php
                                    while ($grid->have_posts()) {
                                        $grid->the_post();
                                        get_template_part('template-parts/blog-card');
                                    }
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            <?php else : ?>
                                <p class="blog-archive__empty">There are no articles here yet.</p>
                            <?php endif; ?>

                            <?php if ($total > 1) :
                                $base  = str_replace('999999999', '%#%', esc_url(get_pagenum_link(999999999)));
                                $links = paginate_links([
                                    'base'      => $base,
                                    'format'    => '',
                                    'current'   => $paged,
                                    'total'     => $total,
                                    'prev_next' => false,
                                    'mid_size'  => 1,
                                    'end_size'  => 1,
                                    'type'      => 'array',
                                ]);
                                ?>
                                <nav class="blog-pagination" aria-label="Pagination">
                                    <div class="blog-pagination__nav">
                                        <?php if ($paged > 1) : ?>
                                            <a class="blog-pagination__arrow" href="<?php echo esc_url(get_pagenum_link($paged - 1)); ?>" rel="prev" aria-label="Previous page"><?php echo nv_blog_icon('prev'); ?></a>
                                        <?php endif; ?>
                                        <div class="blog-pagination__pages"><?php echo implode('', (array) $links); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
                                        <?php if ($paged < $total) : ?>
                                            <a class="blog-pagination__arrow" href="<?php echo esc_url(get_pagenum_link($paged + 1)); ?>" rel="next" aria-label="Next page"><?php echo nv_blog_icon('next'); ?></a>
                                            <a class="blog-pagination__last" href="<?php echo esc_url(get_pagenum_link($total)); ?>">Last <?php echo nv_blog_icon('arrow-dark'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                    <p class="blog-pagination__info">Page <?php echo $paged; ?> of <?php echo $total; ?></p>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>
</main>

<?php
get_footer();
