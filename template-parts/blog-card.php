<?php
/**
 * Карточка записи архива блога (Figma 1378:20322): обычная и «The latest article».
 *
 * Вызывается внутри цикла. Аргументы: `featured` (bool) — крупная карточка первой
 * страницы блога. Просмотры и лайки — реальные мета `post_views` / `post_likes`;
 * если мета у записи нет, плашка не выводится. Вся карточка кликабельна через
 * ::after у ссылки заголовка — вложенных `<a>` нет.
 * `article-card.php` остаётся для author.php (Р-24).
 */

$featured = !empty($args['featured']);
$post_id  = get_the_ID();

$views = get_post_meta($post_id, 'post_views', true);
$likes = get_post_meta($post_id, 'post_likes', true);

$author_id   = (int) get_post_field('post_author', $post_id);
$first       = trim((string) get_user_meta($author_id, 'first_name', true));
$last        = trim((string) get_user_meta($author_id, 'last_name', true));
$author_name = trim($first . ' ' . $last);
if ($author_name === '') {
    $author_name = get_the_author_meta('display_name', $author_id);
}
$author_job = get_user_meta($author_id, 'job_title', true);

$reading_time = max(1, (int) ceil(str_word_count(wp_strip_all_tags(get_the_content())) / 200));
$minutes      = $reading_time . ' ' . ($reading_time === 1 ? 'minute' : 'minutes');
$ago          = nv_blog_ago((int) get_post_time('U', true));

$thumb = '';
if (has_post_thumbnail()) {
    $thumb = get_the_post_thumbnail($post_id, $featured ? 'large' : 'medium_large', ($featured ? ['fetchpriority' => 'high'] : []) + [
        'alt'           => '',
        'loading'       => $featured ? 'eager' : 'lazy',
        'decoding'      => 'async',
        'sizes'         => $featured
            ? '(max-width: 767px) 100vw, (max-width: 1599px) 400px, 500px'
            : '(max-width: 767px) 100vw, (max-width: 1599px) 400px, 340px',
    ]);
}
?>
<article class="blog-card<?php echo $featured ? ' blog-card--featured' : ''; ?>">
    <?php if ($featured) : ?>
        <p class="blog-card__label">THE LATEST ARTICLE</p>
    <?php endif; ?>
    <div class="blog-card__inner">
        <a class="blog-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
            <?php echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput ?>
        </a>
        <div class="blog-card__body">
            <div class="blog-card__meta">
                <ul class="blog-card__stats">
                    <?php if ($views !== '') : ?>
                        <li class="blog-card__stat"><?php echo nv_blog_icon('eye'); ?><span><?php echo (int) $views; ?></span><span class="screen-reader-text"> views</span></li>
                    <?php endif; ?>
                    <?php if ($likes !== '') : ?>
                        <li class="blog-card__stat"><?php echo nv_blog_icon('heart'); ?><span><?php echo (int) $likes; ?></span><span class="screen-reader-text"> likes</span></li>
                    <?php endif; ?>
                </ul>
                <span class="blog-card__time"><?php echo nv_blog_icon('clock'); ?><?php echo esc_html($minutes); ?></span>
            </div>
            <div class="blog-card__content">
                <time class="blog-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html($ago); ?></time>
                <h2 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="blog-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), $featured ? 60 : 32, '...')); ?></p>
            </div>
            <a class="blog-card__author" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                <?php echo get_avatar($author_id, 48, '', '', ['class' => 'blog-card__avatar']); ?>
                <span class="blog-card__author-info">
                    <span class="blog-card__author-name"><?php echo esc_html($author_name); ?></span>
                    <?php if ($author_job) : ?>
                        <span class="blog-card__author-job"><?php echo esc_html($author_job); ?></span>
                    <?php endif; ?>
                </span>
            </a>
        </div>
    </div>
</article>
