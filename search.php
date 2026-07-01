<?php
/*
Template Name: Шаблон страницы Блога
Template Post Type: page
*/
get_header(); ?>

<main>

    <section class="blog-page">
        <div class="container">
            <div class="blog-page__wrapper">
                <div class="blog-page__sidebar">                
                    <div class="breadcrumbs">
                        <p id="breadcrumbs"><a href="http://nvglobal.local/">Main</a> / <span>Blog</span></p>
                    </div>

                    <?php
                        $categories = get_categories([
                            'taxonomy'   => 'category',
                            'hide_empty' => true,
                        ]);

                        $posts_count = wp_count_posts('post')->publish;
                        ?>

                        <div class="blog-page__categories">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-page__category blog-page__category-active">
                                All topic (<?php echo (int) $posts_count; ?>)
                            </a>

                            <?php foreach ($categories as $category) : ?>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="blog-page__category">
                                    <?php echo esc_html($category->name); ?> (<?php echo (int) $category->count; ?>)
                                </a>
                            <?php endforeach; ?>
                        </div>
                </div>

                <div class="blog-page__content">
                    <div class="blog-page__title">
                        <h1 class="page-title">Stay ahead with expert insights on identity verification, compliance, and AI-powered security</h1>
                    </div>

                    <div class="blog-page__categories-mobile">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-page__category-btn blog-page__category-btn--active">
                            All topic (<?php echo (int) $posts_count; ?>)
                        </a>

                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="blog-page__category-btn">
                                <?php echo esc_html($category->name); ?> (<?php echo (int) $category->count; ?>)
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <div class="blog-page__search">
                        <form class="search__form" action="#">
                            <div class="input-wrapper">
                                <input class="input-search" type="text" name="input-search" id="input-search">
                                <button class="input-search-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69371 3.125C6.16465 3.125 3.30408 5.98557 3.30408 9.51458C3.30408 13.0437 6.16474 15.905 9.69371 15.905C11.3592 15.905 12.8759 15.2677 14.0132 14.2235C14.017 14.2196 14.0208 14.2157 14.0246 14.2117C14.04 14.1964 14.0559 14.1821 14.0723 14.1687C15.3103 13.0032 16.0833 11.3491 16.0833 9.51458C16.0833 5.98557 13.2227 3.125 9.69371 3.125ZM15.3497 14.6507C16.5822 13.2938 17.3333 11.4919 17.3333 9.51458C17.3333 5.29522 13.913 1.875 9.69371 1.875C5.47429 1.875 2.05408 5.29522 2.05408 9.51458C2.05408 13.7339 5.4742 17.155 9.69371 17.155C11.4855 17.155 13.1333 16.538 14.4361 15.5049L16.88 17.9425C17.1244 18.1862 17.52 18.1857 17.7639 17.9413C18.0076 17.697 18.0071 17.3012 17.7627 17.0575L15.3497 14.6507ZM10.5126 5.43562C10.613 5.10537 10.9622 4.91907 11.2924 5.01951C12.6534 5.43338 13.7286 6.49147 14.1653 7.8414C14.2715 8.16982 14.0915 8.52217 13.763 8.62842C13.4346 8.73467 13.0823 8.55458 12.976 8.22615C12.6651 7.26519 11.8981 6.51022 10.9287 6.21542C10.5985 6.115 10.4122 5.76587 10.5126 5.43562Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                    </svg>
                                </button>
                            </div>                            
                        </form>
                    </div>

                    <div class="blog-page__articles">
                        <div class="blog-page__list">

                           <?php
                            $paged = max(1, get_query_var('paged'), get_query_var('page'));

                            $blog_query = new WP_Query([
                                'post_type'      => 'post',
                                'post_status'    => 'publish',
                                'posts_per_page' => -1,
                                'paged'          => $paged,
                            ]);
                            ?>

                            <?php if ($blog_query->have_posts()) : ?>
                                <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>

                                    <?php
                                    $post_id = get_the_ID();

                                    $views = (int) get_post_meta($post_id, 'post_views', true);
                                    $likes = (int) get_post_meta($post_id, 'post_likes', true);

                                    $author_id = (int) get_post_field('post_author', $post_id);

                                    $first = trim((string) get_user_meta($author_id, 'first_name', true));
                                    $last  = trim((string) get_user_meta($author_id, 'last_name', true));
                                    $author_name = trim($first . ' ' . $last);

                                    if ($author_name === '') {
                                        $author_name = get_the_author_meta('display_name', $author_id);
                                    }

                                    $author_job = get_user_meta($author_id, 'job_title', true);

                                    $avatar_html = get_avatar($author_id, 64, '', $author_name, [
                                        'class' => 'article__author-avatar',
                                    ]);

                                    $reading_time = max(1, ceil(str_word_count(wp_strip_all_tags(get_the_content())) / 200));
                                    ?>

                                    <a href="<?php the_permalink(); ?>" class="blog-page__item article">
                                        <div class="article__wrapper">

                                            <div class="article__thumbnail">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('large', [
                                                        'loading' => 'lazy',
                                                        'decoding' => 'async',
                                                    ]); ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="article__meta">
                                                <div class="article__meta-left">
                                                    <div class="article__meta-views">
                                                        <span><?php echo (int) $views; ?></span>
                                                    </div>

                                                    <div class="article__meta-likes">
                                                        <span><?php echo (int) $likes; ?></span>
                                                    </div>
                                                </div>

                                                <div class="article__meta-right">
                                                    <div class="article__meta-time">
                                                        <span><?php echo (int) $reading_time; ?> minutes</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="article__content">
                                                <p class="article__title"><?php the_title(); ?></p>

                                                <p class="article__intro">
                                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 32, '...')); ?>
                                                </p>
                                            </div>

                                            <div class="article__author">
                                                <div class="article__author-image">
                                                    <?php echo $avatar_html; ?>
                                                </div>

                                                <div class="article__author-info">
                                                    <p class="article__author-name"><?php echo esc_html($author_name); ?></p>

                                                    <?php if ($author_job) : ?>
                                                        <p class="article__author-job"><?php echo esc_html($author_job); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>
                                    </a>

                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>

                        </div>

                        <div class="blog-page__action">
                            <button class="btn-hero more-post">
                                <span class="btn__text btn__text-hero">Show more</span>
                                <div class="btn__icon btn__icon-arrow"></div>
                            </button>
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
?>