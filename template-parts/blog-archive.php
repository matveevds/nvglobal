<?php
/**
 * Архив блога по макету Figma NV Global: Full HD 2570:33169, Desktop 1378:20322,
 * hover 2569:23708, Tablet 2569:29963. Отдельного макета Mobile нет — он выведен из Tablet.
 *
 * Один шаблон для страницы блога (search.php / blog-page.php), результатов поиска
 * (`?s=`, search.php) и рубрик (category.php). Аргумент `context`: page | search | category.
 * Записи — реальные: сетка и пагинация идут из WP_Query, «последняя статья» — только
 * на первой странице блога, правая колонка (она же полоса на Tablet) — один запрос
 * без записей, уже показанных на странице.
 */

$context = $args['context'] ?? 'page';
$paged   = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));

$blog_url   = nv_blog_url();
$all_count  = (int) wp_count_posts('post')->publish;
$categories = get_categories(['taxonomy' => 'category', 'hide_empty' => true]);
$current_cat = is_category() ? (int) get_queried_object_id() : 0;

$featured_post = null;
if ($context === 'page') {
    $latest = get_posts([
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 1,
        'ignore_sticky_posts' => true,
    ]);
    $featured_post = $latest ? $latest[0] : null;
    $grid = new WP_Query([
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => NV_BLOG_PER_PAGE,
        'paged'               => $paged,
        'post__not_in'        => $featured_post ? [$featured_post->ID] : [],
        'ignore_sticky_posts' => true,
    ]);
} else {
    $grid = $GLOBALS['wp_query'];
}

$shown = $featured_post ? [$featured_post->ID] : [];
foreach ((array) $grid->posts as $grid_post) {
    $shown[] = $grid_post->ID;
}
// News aside не предусмотрен ни в одном из четырёх category-макетов — для category запрос не нужен.
$news = null;
if ($context !== 'category') {
    $news = new WP_Query([
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 6,
        'post__not_in'        => $shown,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ]);
}

$total = max(1, (int) $grid->max_num_pages);

$current_category_obj = null;
$current_in_list      = false;
$h1_count             = 0;
if ($context === 'search') {
    $title_tail = 'Search: “' . get_search_query() . '”';
} elseif ($context === 'category') {
    $maybe_category = get_category($current_cat);
    $current_category_obj = is_wp_error($maybe_category) ? null : $maybe_category;
    $title_tail = single_cat_title('', false);
    // H1 — реальный found_posts главного запроса (учитывает иерархию при её появлении). Пилюля и её
    // собственная строка в списке показывают то же значение (R2-12); остальные терминов в сайдбаре —
    // term->count (WP term semantics, R-18).
    $h1_count = (int) $grid->found_posts;
    foreach ($categories as $category) {
        if ((int) $category->term_id === $current_cat) {
            $current_in_list = true;
            break;
        }
    }
    // R2-05: если текущая рубрика пуста и hide_empty исключил её из $categories, добавляем её в список —
    // тогда она рендерится обычным пунктом (тот же order/typography/divider, что у непустых терминов),
    // без отдельного --empty-active состояния и его CSS-исключений.
    if (!$current_in_list && $current_category_obj) {
        array_unshift($categories, $current_category_obj);
        $current_in_list = true;
    }
} else {
    $title_tail = 'KYC, AML, biometrics and anti-fraud';
}
?>

<?php get_template_part('template-parts/blog-hero', null, ['context' => $context]); ?>

<section class="blog-archive<?php echo $context === 'category' ? ' blog-archive--category' : ''; ?>">
    <div class="container">
        <div class="blog-archive__head">
            <div class="blog-archive__heading">
                <div class="breadcrumbs"><?php nv_breadcrumbs(); ?></div>
                <?php if ($context === 'category' && $current_category_obj) : ?>
                    <h1 class="blog-archive__title"><?php echo esc_html($title_tail); ?> (<?php echo $h1_count; ?>)</h1>
                <?php else : ?>
                    <h1 class="blog-archive__title"><span class="blog-archive__title-lead">NeuroVision Global Systems Blog:</span> <?php echo esc_html($title_tail); ?></h1>
                <?php endif; ?>
            </div>
            <div class="blog-archive__controls">
                <?php if ($context === 'category') : ?>
                    <nav class="blog-archive__tabs" aria-label="Media sections">
                        <a class="blog-tab is-active" href="<?php echo esc_url($blog_url); ?>"><span class="blog-tab__icon blog-tab__icon--document"><?php echo nv_blog_icon('document'); ?></span>Blog</a>
                        <span class="blog-tab is-soon" aria-disabled="true"><span class="blog-tab__icon blog-tab__icon--network"><?php echo nv_blog_icon('network'); ?></span>News</span>
                        <span class="blog-tab is-soon" aria-disabled="true"><span class="blog-tab__icon blog-tab__icon--play"><?php echo nv_blog_icon('play'); ?></span>Video</span>
                    </nav>
                <?php else : ?>
                    <nav class="blog-archive__tabs" aria-label="Media sections">
                        <a class="blog-tab is-active" href="<?php echo esc_url($blog_url); ?>"<?php echo $context === 'page' ? ' aria-current="page"' : ''; ?>>Blog</a>
                        <span class="blog-tab is-soon" aria-disabled="true">News</span>
                        <span class="blog-tab is-soon" aria-disabled="true">Video</span>
                    </nav>
                <?php endif; ?>
                <form class="blog-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <label class="screen-reader-text" for="blog-search-input">Search the blog</label>
                    <input class="blog-search__input" id="blog-search-input" type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Find what interests you..." autocomplete="off">
                    <button class="blog-search__submit" type="submit" aria-label="Search"><?php echo nv_blog_icon('search'); ?></button>
                </form>
            </div>
        </div>

        <div class="blog-archive__layout<?php echo ($news && $news->have_posts()) ? '' : ' blog-archive__layout--no-news'; ?>">
            <?php if ($context === 'category') : ?>
                <nav class="blog-cats blog-cats--category" aria-label="Blog topics">
                    <?php if ($current_category_obj) : ?>
                        <a class="blog-cats__link blog-cats__active is-active" href="<?php echo esc_url(get_category_link($current_category_obj->term_id)); ?>" aria-current="page"><?php echo esc_html($current_category_obj->name); ?> (<?php echo $h1_count; ?>)</a>
                        <span class="blog-cats__divider" aria-hidden="true"></span>
                    <?php endif; ?>
                    <a class="blog-cats__all" href="<?php echo esc_url($blog_url); ?>">All topic (<?php echo $all_count; ?>)</a>
                    <span class="blog-cats__divider" aria-hidden="true"></span>
                    <ul class="blog-cats__list">
                        <?php foreach ($categories as $category) : $is_cur = $current_cat === (int) $category->term_id; $cat_count = $is_cur ? $h1_count : (int) $category->count; ?>
                            <li<?php echo $is_cur ? ' class="is-current"' : ''; ?>><a class="blog-cats__link<?php echo $is_cur ? ' is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($category->term_id)); ?>"<?php echo $is_cur ? ' aria-current="page"' : ''; ?>><?php echo esc_html($category->name); ?> (<?php echo $cat_count; ?>)</a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php else : ?>
                <nav class="blog-cats" aria-label="Blog topics">
                    <a class="blog-cats__all<?php echo $context === 'page' ? ' is-active' : ''; ?>" href="<?php echo esc_url($blog_url); ?>"<?php echo $context === 'page' ? ' aria-current="page"' : ''; ?>>All topic (<?php echo $all_count; ?>)</a>
                    <ul class="blog-cats__list">
                        <?php foreach ($categories as $category) : $is_cur = $current_cat === (int) $category->term_id; ?>
                            <li><a class="blog-cats__link<?php echo $is_cur ? ' is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($category->term_id)); ?>"<?php echo $is_cur ? ' aria-current="page"' : ''; ?>><?php echo esc_html($category->name); ?> (<?php echo (int) $category->count; ?>)</a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <div class="blog-archive__main">
                <?php if ($featured_post && $paged === 1) : ?>
                    <?php
                    global $post;
                    $post = $featured_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
                    setup_postdata($post);
                    get_template_part('template-parts/blog-card', null, ['featured' => true]);
                    wp_reset_postdata();
                    ?>
                <?php endif; ?>

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
                <?php elseif (!$featured_post || $paged > 1) : ?>
                    <p class="blog-archive__empty">
                        <?php echo $context === 'search'
                            ? 'Nothing found for “' . esc_html(get_search_query()) . '”. Try a different query.'
                            : 'There are no articles here yet.'; ?>
                    </p>
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

            <?php if ($news && $news->have_posts()) : ?>
                <aside class="blog-news" aria-labelledby="blog-news-title">
                    <p class="blog-news__title" id="blog-news-title">All NeuroVision News</p>
                    <div class="blog-news__list">
                        <?php while ($news->have_posts()) : $news->the_post(); ?>
                            <article class="blog-news__item">
                                <time class="blog-news__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(nv_blog_ago((int) get_post_time('U', true))); ?></time>
                                <h2 class="blog-news__link"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</section>
