<?php
/**
 * Блок «Insights & Resources» (Blog). Вынесен из main-page.php без изменений разметки/поведения,
 * чтобы переиспользовать на /identity-verification/ (blog-author ТЗ-style reuse). Только реальные
 * опубликованные записи WordPress; секция не выводится, если записей нет или выключен флаг NVGLOBAL_BLOG_LINKS_ENABLED.
 */

$nv_news_query = new WP_Query([
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 4,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
]);

$nv_posts_page_id = (int) get_option('page_for_posts');
$nv_blog_url      = ($nv_posts_page_id && nv_blog_links_enabled()) ? get_permalink($nv_posts_page_id) : ''; // кнопка скрыта флагом NVGLOBAL_BLOG_LINKS_ENABLED
?>

<?php
/* Блок скрыт вместе со ссылками на Blog (флаг NVGLOBAL_BLOG_LINKS_ENABLED); в картотеке и стресс-кадрах выводится всегда. */
$nv_news_hidden = !nv_blog_links_enabled()
    && !(function_exists('nv_block_stress_slug') && '' !== nv_block_stress_slug())
    && !(function_exists('nv_is_block_catalog') && nv_is_block_catalog());
?>
<?php if (!$nv_news_hidden && $nv_news_query->have_posts()) : ?>
<section class="news section" id="blog">
    <div class="container">
        <div class="news__wrapper">
            <div class="news__top">
                <div class="section__badge">Blog</div>
                <div class="news__top-info">
                    <div class="news__title-block">
                        <h2 class="news__title">Insights &amp; Resources</h2>
                        <p class="news__description">Stay ahead with expert insights on identity verification, compliance, and AI-powered security</p>
                    </div>
                    <?php if ($nv_blog_url) : ?>
                        <div class="news__top-action">
                            <a href="<?php echo esc_url($nv_blog_url); ?>" class="btn btn--gray news__btn">
                                <span class="btn__text">Explore All Articles</span>
                                <span class="btn__icon">
                                    <svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg>
                                </span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="news__content swiper">
                <div class="news__list swiper-wrapper">
                    <?php while ($nv_news_query->have_posts()) : $nv_news_query->the_post(); ?>
                        <?php get_template_part('template-parts/news-card'); ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
