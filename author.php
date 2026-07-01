<?php
/**
 * Author archive template.
 *
 * Файл: author.php
 */

get_header();

$author = get_queried_object();

if (!$author || empty($author->ID)) {
    get_footer();
    return;
}

$author_id = (int) $author->ID;

// Имя автора
$first_name = trim((string) get_user_meta($author_id, 'first_name', true));
$last_name  = trim((string) get_user_meta($author_id, 'last_name', true));
$author_name = trim($first_name . ' ' . $last_name);

if ($author_name === '') {
    $author_name = get_the_author_meta('display_name', $author_id);
}

// Должность
$author_job = trim((string) get_user_meta($author_id, 'job_title', true));

// Биография
$author_description = trim((string) get_the_author_meta('description', $author_id));

// Аватар автора
$author_avatar = get_avatar(
    $author_id,
    512,
    '',
    $author_name,
    [
        'class'   => 'author-block__avatar',
        'loading' => 'lazy',
        'decoding' => 'async',
    ]
);

// Количество опубликованных записей автора
$author_posts_count = (int) count_user_posts($author_id, 'post', true);

// Страница блога
$blog_page = get_page_by_path('blog');
$blog_url  = $blog_page ? get_permalink($blog_page->ID) : home_url('/blog/');

/**
 * Категории.
 * Ссылки остаются обычными ссылками на категории,
 * но количество считаем только по записям текущего автора.
 */
$categories = get_categories([
    'taxonomy'   => 'category',
    'hide_empty' => false,
]);

$author_category_counts = [];

$author_posts_for_count = get_posts([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'author'         => $author_id,
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);

if (!empty($author_posts_for_count)) {
    foreach ($author_posts_for_count as $author_post_id) {
        $post_categories = get_the_category($author_post_id);

        if (empty($post_categories)) {
            continue;
        }

        foreach ($post_categories as $post_category) {
            $term_id = (int) $post_category->term_id;

            if (!isset($author_category_counts[$term_id])) {
                $author_category_counts[$term_id] = 0;
            }

            $author_category_counts[$term_id]++;
        }
    }
}

/**
 * Записи текущего автора.
 */
$blog_query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 9,
    'paged'          => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'author'         => $author_id,
]);
?>

<main>

    <div class="author-page__wrapper">

        <div class="breadcrumbs__block">
            <div class="container">
                <div class="breadcrumbs__block-wrapper">
                    <div class="breadcrumbs">
                        <p id="breadcrumbs">
                            <a href="<?php echo esc_url(home_url('/')); ?>">Main</a>
                            /
                            <a href="<?php echo esc_url($blog_url); ?>">Blog</a>
                            /
                            <span><?php echo esc_html($author_name); ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <section class="author-block">
            <div class="container">
                <div class="author-block__wrapper">

                    <div class="author-block__image">
                        <?php echo $author_avatar; ?>
                    </div>

                    <div class="author-block__info">

                        <div class="author-block__info-top">
                            <p class="author-block__info-name">
                                <?php echo esc_html($author_name); ?>
                            </p>

                            <?php if ($author_job !== '') : ?>
                                <p class="author-block__info-job">
                                    <?php echo esc_html($author_job); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="author-block__info-bottom">
                            <div class="author-block__socials">

                                <a href="#" class="author-block__social">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5552 17.281L10.2512 19.422C9.96917 19.685 9.51017 19.469 9.53617 19.084C9.60817 17.996 9.72017 16.343 9.79517 15.424C9.80717 15.279 9.92917 15.117 10.0452 15.012C12.7362 12.572 15.4332 10.138 18.1292 7.70198C18.2292 7.61198 18.3472 7.38998 18.2852 7.27298C18.2152 7.14098 17.8922 7.18098 17.7582 7.26498C14.3342 9.42098 10.9102 11.576 7.49117 13.739C7.28117 13.871 7.02417 13.903 6.78817 13.827C5.37817 13.374 3.96017 12.945 2.54717 12.499C2.22217 12.396 1.83617 12.294 1.79917 11.891C1.76017 11.47 2.12117 11.27 2.44717 11.139C3.76117 10.609 5.08417 10.102 6.40517 9.59198C11.1572 7.76098 15.9092 5.93098 20.6612 4.10098C20.8202 4.03998 21.0322 4.00198 21.1982 3.96898C21.6962 3.86898 22.1442 4.11898 22.1932 4.62298C22.2302 4.99198 22.1652 5.40298 22.0882 5.76798C21.0982 10.477 20.0952 15.184 19.0932 19.892C18.8232 21.164 18.1692 21.405 17.1162 20.628C15.7592 19.626 12.5552 17.281 12.5552 17.281Z" fill="#FBFBFB"/>
                                    </svg>
                                </a>

                                <a href="#" class="author-block__social">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.51 14.0678L14.407 13.9968C14.198 13.8508 13.909 13.8698 13.736 14.0418L13.504 14.2758C13.262 14.5218 12.881 14.5688 12.584 14.3908C11.432 13.6968 10.857 13.0268 10.138 11.9578C9.941 11.6638 9.976 11.2708 10.223 11.0168L10.456 10.7768C10.639 10.5898 10.661 10.3108 10.512 10.0938C10.353 9.87175 10.198 9.64875 10.05 9.43575C9.964 9.31375 9.823 9.23375 9.668 9.22075C9.655 9.21975 9.64 9.21875 9.623 9.21875C9.529 9.21875 9.385 9.24475 9.261 9.36975L9.136 9.49575L9.133 9.49875C8.071 10.5638 9.218 12.4698 10.646 13.8988C12.056 15.3038 13.944 16.4318 15.006 15.3678L15.153 15.2298C15.282 15.0988 15.291 14.9238 15.283 14.8338C15.275 14.7428 15.236 14.5738 15.065 14.4548C14.881 14.3228 14.7 14.1988 14.51 14.0678Z" fill="#FBFBFB"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.1957 16.3083L16.0477 16.4483C15.4677 17.0253 14.7667 17.3103 13.9857 17.3103C12.6777 17.3103 11.1457 16.5143 9.58671 14.9603C7.11071 12.4843 6.52971 9.98624 8.06871 8.44124L8.19571 8.31324C8.62071 7.88724 9.21271 7.67124 9.79671 7.72624C10.3947 7.77824 10.9347 8.08824 11.2797 8.57824C11.4257 8.78924 11.5777 9.00624 11.7397 9.23224C12.2437 9.96224 12.2207 10.9133 11.7187 11.6023C12.0777 12.0913 12.4117 12.4523 12.8877 12.7973C13.5797 12.2803 14.5347 12.2583 15.2617 12.7643L15.3607 12.8313C15.5597 12.9693 15.7497 13.0993 15.9317 13.2313C16.4127 13.5653 16.7237 14.1033 16.7777 14.6993C16.8317 15.2973 16.6187 15.8833 16.1957 16.3083ZM21.3317 10.6973C20.6197 6.91024 17.5957 3.88724 13.8087 3.17724C10.9957 2.64824 8.13471 3.38624 5.95271 5.19624C3.75871 7.01624 2.50171 9.68124 2.50171 12.5093C2.50171 13.9313 2.82571 15.3443 3.46371 16.7053C3.51571 16.8233 3.53171 16.9423 3.50771 17.0523C3.35171 17.7613 3.02471 19.1883 2.78871 20.2083C2.68971 20.6393 2.81971 21.0793 3.13371 21.3843C3.44471 21.6863 3.88471 21.8053 4.30471 21.6943C5.25571 21.4543 6.55871 21.1353 7.37671 20.9443C7.48371 20.9193 7.60171 20.9343 7.72471 20.9953C9.04371 21.6593 10.5227 22.0093 12.0017 22.0093C14.8277 22.0093 17.4917 20.7523 19.3097 18.5613C21.1227 16.3783 21.8587 13.5113 21.3317 10.6973Z" fill="#FBFBFB"/>
                                    </svg>
                                </a>

                                <a href="#" class="author-block__social">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.976 15.7998C16.976 16.2138 16.64 16.5498 16.226 16.5498C15.812 16.5498 15.476 16.2138 15.476 15.7998V12.3898C15.476 11.3858 14.662 10.5698 13.661 10.5698C12.66 10.5698 11.846 11.3858 11.846 12.3898V15.7998C11.846 16.2138 11.51 16.5498 11.096 16.5498C10.682 16.5498 10.346 16.2138 10.346 15.7998V12.3898C10.346 10.5588 11.833 9.06977 13.661 9.06977C15.489 9.06977 16.976 10.5588 16.976 12.3898V15.7998ZM7.775 10.0098C7.361 10.0098 6.989 9.63377 6.989 9.21977C6.989 8.80577 7.361 8.42977 7.775 8.42977C8.189 8.42977 8.559 8.80577 8.559 9.21977C8.559 9.63377 8.189 10.0098 7.775 10.0098ZM8.524 15.7998C8.524 16.2138 8.188 16.5498 7.774 16.5498C7.36 16.5498 7.024 16.2138 7.024 15.7998V12.0288C7.024 11.6148 7.36 11.2788 7.774 11.2788C8.188 11.2788 8.524 11.6148 8.524 12.0288V15.7998ZM16.217 3.00977H7.783C4.623 3.00977 2.5 5.23277 2.5 8.53977V16.4798C2.5 19.7868 4.623 22.0098 7.783 22.0098H16.216C19.376 22.0098 21.5 19.7868 21.5 16.4798V8.53977C21.5 5.23277 19.377 3.00977 16.217 3.00977Z" fill="#FBFBFB"/>
                                    </svg>
                                </a>

                            </div>
                        </div>

                    </div>

                    <?php if ($author_description !== '') : ?>
                        <div class="author-block__description">
                            <?php echo wp_kses_post(wpautop($author_description)); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>

        <section class="blog-page blog-page--author">
            <div class="container">
                <div class="blog-page__wrapper">

                    <div class="blog-page__title">
                        <h1 class="page-title">
                            Popular articles by <?php echo esc_html($author_name); ?>
                        </h1>
                    </div>

                    <div class="blog-page__sidebar">

                        <div class="blog-page__categories">

                            <a
                                href="<?php echo esc_url($blog_url); ?>"
                                class="blog-page__category blog-page__category-active"
                            >
                                All topic (<?php echo (int) $author_posts_count; ?>)
                            </a>

                            <?php foreach ($categories as $category) : ?>
                                <?php
                                $category_author_count = (int) ($author_category_counts[(int) $category->term_id] ?? 0);

                                if ($category_author_count <= 0) {
                                    continue;
                                }
                                ?>
                                <a
                                    href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                    class="blog-page__category"
                                >
                                    <?php echo esc_html($category->name); ?> (<?php echo (int) $category_author_count; ?>)
                                </a>
                            <?php endforeach; ?>

                        </div>

                    </div>

                    <div class="blog-page__content">

                        <div class="blog-page__categories-mobile">

                            <a
                                href="<?php echo esc_url($blog_url); ?>"
                                class="blog-page__category-btn blog-page__category-btn--active"
                            >
                                All topic (<?php echo (int) $author_posts_count; ?>)
                            </a>

                            <?php foreach ($categories as $category) : ?>
                                <?php
                                $category_author_count = (int) ($author_category_counts[(int) $category->term_id] ?? 0);

                                if ($category_author_count <= 0) {
                                    continue;
                                }
                                ?>
                                <a
                                    href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                    class="blog-page__category-btn"
                                >
                                    <?php echo esc_html($category->name); ?> (<?php echo (int) $category_author_count; ?>)
                                </a>
                            <?php endforeach; ?>

                        </div>

                        <div class="blog-page__articles">

                            <div class="blog-page__list">

                                <?php if ($blog_query->have_posts()) : ?>
                                    <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>

                                        <?php get_template_part('template-parts/article-card'); ?>

                                    <?php endwhile; ?>
                                    <?php wp_reset_postdata(); ?>
                                <?php else : ?>

                                    <div class="blog-page__not-found">
                                        Nothing found
                                    </div>

                                <?php endif; ?>

                            </div>

                            <?php if ($blog_query->max_num_pages > 1) : ?>
                                <div class="blog-page__action">
                                    <button
                                        class="btn-hero more-post"
                                        type="button"
                                        data-page="1"
                                        data-max="<?php echo esc_attr($blog_query->max_num_pages); ?>"
                                        data-author="<?php echo esc_attr($author_id); ?>"
                                    >
                                        <span class="btn__text btn__text-hero">Show more</span>
                                        <div class="btn__icon btn__icon-arrow"></div>
                                    </button>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>
            </div>
        </section>

    </div>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
