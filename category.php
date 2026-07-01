<?php
/**
 * Category archive template.
 *
 * Файл: category.php
 */

get_header();

$current_category = get_queried_object();

if (!$current_category || empty($current_category->term_id)) {
    get_footer();
    return;
}

$current_category_id = (int) $current_category->term_id;

$categories = get_categories([
    'taxonomy'   => 'category',
    'hide_empty' => true,
]);

$posts_count = wp_count_posts('post')->publish;

$blog_page = get_page_by_path('blog');
$blog_url  = $blog_page ? get_permalink($blog_page->ID) : home_url('/blog/');

$blog_query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 9,
    'paged'          => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'cat'            => $current_category_id,
]);
?>

<main>

    <section class="blog-page">
        <div class="container">
            <div class="blog-page__wrapper">

                <div class="blog-page__sidebar">

                    <div class="breadcrumbs">
                        <p id="breadcrumbs">
                            <a href="<?php echo esc_url(home_url('/')); ?>">Main</a>
                            /
                            <a href="<?php echo esc_url($blog_url); ?>">Blog</a>
                            
                        </p>
                    </div>

                    <div class="blog-page__categories">

                        <a
                            href="<?php echo esc_url($blog_url); ?>"
                            class="blog-page__category"
                        >
                            All topic (<?php echo (int) $posts_count; ?>)
                        </a>

                        <?php foreach ($categories as $category) : ?>
                            <?php
                            $is_active = ((int) $category->term_id === $current_category_id);
                            ?>
                            <a
                                href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                class="blog-page__category<?php echo $is_active ? ' blog-page__category-active' : ''; ?>"
                            >
                                <?php echo esc_html($category->name); ?> (<?php echo (int) $category->count; ?>)
                            </a>
                        <?php endforeach; ?>

                    </div>

                </div>

                <div class="blog-page__content">

                    <div class="blog-page__title">
                        <h1 class="page-title">
                            <?php echo esc_html(single_cat_title('', false)); ?>
                        </h1>
                    </div>

                    <?php if (category_description()) : ?>
                        <div class="blog-page__description">
                            <?php echo wp_kses_post(category_description()); ?>
                        </div>
                    <?php endif; ?>

                    <div class="blog-page__categories-mobile">

                        <a
                            href="<?php echo esc_url($blog_url); ?>"
                            class="blog-page__category-btn"
                        >
                            All topic (<?php echo (int) $posts_count; ?>)
                        </a>

                        <?php foreach ($categories as $category) : ?>
                            <?php
                            $is_active = ((int) $category->term_id === $current_category_id);
                            ?>
                            <a
                                href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                class="blog-page__category-btn<?php echo $is_active ? ' blog-page__category-btn--active' : ''; ?>"
                            >
                                <?php echo esc_html($category->name); ?> (<?php echo (int) $category->count; ?>)
                            </a>
                        <?php endforeach; ?>

                    </div>

                    <div class="blog-page__search">
                        <form class="search__form" action="#" method="get">
                            <div class="input-wrapper">
                                <input class="input-search" type="text" name="input-search" id="input-search">
                                <button class="input-search-icon" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69371 3.125C6.16465 3.125 3.30408 5.98557 3.30408 9.51458C3.30408 13.0437 6.16474 15.905 9.69371 15.905C11.3592 15.905 12.8759 15.2677 14.0132 14.2235C14.017 14.2196 14.0208 14.2157 14.0246 14.2117C14.04 14.1964 14.0559 14.1821 14.0723 14.1687C15.3103 13.0032 16.0833 11.3491 16.0833 9.51458C16.0833 5.98557 13.2227 3.125 9.69371 3.125ZM15.3497 14.6507C16.5822 13.2938 17.3333 11.4919 17.3333 9.51458C17.3333 5.29522 13.913 1.875 9.69371 1.875C5.47429 1.875 2.05408 5.29522 2.05408 9.51458C2.05408 13.7339 5.4742 17.155 9.69371 17.155C11.4855 17.155 13.1333 16.538 14.4361 15.5049L16.88 17.9425C17.1244 18.1862 17.52 18.1857 17.7639 17.9413C18.0076 17.697 18.0071 17.3012 17.7627 17.0575L15.3497 14.6507ZM10.5126 5.43562C10.613 5.10537 10.9622 4.91907 11.2924 5.01951C12.6534 5.43338 13.7286 6.49147 14.1653 7.8414C14.2715 8.16982 14.0915 8.52217 13.763 8.62842C13.4346 8.73467 13.0823 8.55458 12.976 8.22615C12.6651 7.26519 11.8981 6.51022 10.9287 6.21542C10.5985 6.115 10.4122 5.76587 10.5126 5.43562Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
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
                                    data-category="<?php echo esc_attr($current_category_id); ?>"
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

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
