<?php
/**
 * Карточка записи в слайдере Blog на главной странице.
 *
 * Данные те же, что в `template-parts/article-card.php` (карточка для /blog/,
 * архивов и поиска), но разметка и классы свои — по макету Figma 830:11701.
 * Общий шаблон не переиспользуется намеренно: у него другие классы и другое
 * оформление, менять его нельзя, чтобы не задеть /blog/ и архивы.
 *
 * Вызывается внутри цикла WP_Query.
 */

$post_id   = get_the_ID();
$author_id = (int) get_post_field('post_author', $post_id);

$views = (int) get_post_meta($post_id, 'post_views', true);
$likes = (int) get_post_meta($post_id, 'post_likes', true);

$first = trim((string) get_user_meta($author_id, 'first_name', true));
$last  = trim((string) get_user_meta($author_id, 'last_name', true));

$author_name = trim($first . ' ' . $last);

if ($author_name === '') {
    $author_name = get_the_author_meta('display_name', $author_id);
}

$author_job = get_user_meta($author_id, 'job_title', true);
$author_url = get_author_posts_url($author_id);

$avatar_html = get_avatar($author_id, 98, '', $author_name, [
    'class' => 'news__item-author-avatar',
]);

// Та же формула, что в article-card.php: 200 слов в минуту, минимум 1.
$reading_time = max(
    1,
    ceil(str_word_count(wp_strip_all_tags(get_the_content())) / 200)
);
?>

<article class="news__item swiper-slide">

    <div class="news__item-image">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', [
                'loading'  => 'lazy',
                'decoding' => 'async',
                'alt'      => the_title_attribute(['echo' => false]),
            ]); ?>
        <?php endif; ?>
    </div>

    <div class="news__item-info">

        <div class="news__item-meta">

            <div class="news__item-meta-left">

                <span class="news__item-chip">
                    <span class="news__item-chip-icon">
                        <svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.875 10.8057C16.8749 9.54755 16.1151 8.2316 14.8218 7.20459C13.5371 6.18442 11.7975 5.5127 10 5.5127C8.20293 5.5127 6.46308 6.18438 5.17822 7.20459C3.88484 8.23162 3.12514 9.54765 3.125 10.8057C3.125 12.0657 3.87856 13.3825 5.16683 14.4084C6.44674 15.4276 8.18634 16.0994 10 16.0994C11.814 16.0994 13.5534 15.4275 14.8332 14.4084C16.1213 13.3825 16.875 12.0658 16.875 10.8057ZM11.9409 10.8049C11.9409 9.73423 11.0722 8.86563 10.0016 8.86556C8.93194 8.86556 8.06315 9.73406 8.06315 10.8049C8.0632 11.8746 8.93183 12.7433 10.0016 12.7433C11.0723 12.7433 11.9409 11.8745 11.9409 10.8049ZM18.125 10.8057C18.125 12.5638 17.092 14.207 15.612 15.3857C14.1234 16.5712 12.1126 17.3494 10 17.3494C7.88787 17.3494 5.87746 16.5711 4.38883 15.3857C2.9086 14.207 1.875 12.5639 1.875 10.8057C1.87513 9.04567 2.91827 7.40295 4.40104 6.22559C5.89264 5.04122 7.9029 4.2627 10 4.2627C12.0974 4.2627 14.1075 5.04127 15.599 6.22559C17.0817 7.40299 18.1249 9.04571 18.125 10.8057ZM13.1909 10.8049C13.1909 12.5651 11.7624 13.9933 10.0016 13.9933C8.24149 13.9933 6.8132 12.565 6.81315 10.8049C6.81315 9.04397 8.24131 7.61556 10.0016 7.61556C11.7626 7.61563 13.1909 9.04389 13.1909 10.8049Z" fill="currentColor"/></svg>
                    </span>
                    <span class="news__item-chip-value"><?php echo esc_html(number_format_i18n($views)); ?></span>
                </span>

                <span class="news__item-chip">
                    <span class="news__item-chip-icon">
                        <svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.7532 5.87558C12.8592 5.54706 13.2114 5.36662 13.5399 5.47255C14.6254 5.82258 15.3932 6.79242 15.4849 7.92907C15.5127 8.27313 15.2562 8.57451 14.9122 8.60226C14.5681 8.63001 14.2667 8.37359 14.2389 8.02957C14.1879 7.39699 13.7605 6.85707 13.1563 6.66223C12.8277 6.55629 12.6473 6.2041 12.7532 5.87558Z" fill="currentColor"/><path d="M10.0029 17.5168C9.91174 17.5165 9.82166 17.4967 9.73875 17.4584C9.48875 17.3409 3.57795 14.5376 2.19795 10.1143C1.29962 7.31512 2.29879 3.78678 5.53129 2.73678C6.34747 2.48192 7.21218 2.42283 8.05545 2.56428C8.76525 2.72591 9.43041 3.04297 10.0029 3.49262C10.5749 3.03808 11.242 2.71848 11.9546 2.55762C12.7977 2.41628 13.6623 2.4774 14.4771 2.73595C17.7046 3.77595 18.7013 7.30595 17.7997 10.1184C16.3362 14.5876 10.5146 17.3426 10.2679 17.4576C10.1849 17.4962 10.0945 17.5163 10.0029 17.5168ZM7.15378 3.73928C6.73249 3.73906 6.31359 3.80256 5.91128 3.92762C3.33628 4.76512 2.69045 7.54595 3.39295 9.73759C4.45878 13.1543 8.87458 15.6118 10.0062 16.1934C11.1279 15.6159 15.4838 13.1818 16.613 9.73343C17.3163 7.54095 16.6737 4.75762 14.0971 3.92678C13.4727 3.72817 12.8099 3.68132 12.1637 3.79012C11.5062 3.98388 10.8982 4.31731 10.3812 4.76762C10.2731 4.84875 10.1415 4.89262 10.0062 4.89262C9.87108 4.89262 9.73949 4.84875 9.63124 4.76762C9.11241 4.31839 8.50266 3.9864 7.84378 3.79428C7.61568 3.75703 7.3849 3.73863 7.15378 3.73928Z" fill="currentColor"/></svg>
                    </span>
                    <span class="news__item-chip-value"><?php echo esc_html(number_format_i18n($likes)); ?></span>
                </span>

            </div>

            <span class="news__item-time">
                <span class="news__item-time-icon">
                    <svg aria-hidden="true" focusable="false" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.6668 7.99967C13.6668 5.71509 13.2797 4.3508 12.4644 3.53548C11.649 2.72017 10.2848 2.33301 8.00016 2.33301C5.71557 2.33301 4.35128 2.72017 3.53597 3.53548C2.72066 4.3508 2.3335 5.71508 2.3335 7.99967C2.3335 10.2843 2.72066 11.6486 3.53597 12.4639C4.35128 13.2792 5.71558 13.6663 8.00016 13.6663C10.2848 13.6663 11.649 13.2792 12.4644 12.4639C13.2797 11.6486 13.6668 10.2843 13.6668 7.99967ZM7.49951 5.08887C7.4996 4.81284 7.72347 4.58892 7.99951 4.58887C8.2756 4.58887 8.49942 4.8128 8.49951 5.08887V7.71191L10.5164 8.91569C10.7536 9.05717 10.8311 9.36409 10.6896 9.60124C10.5481 9.83836 10.2412 9.91588 10.0041 9.77441L7.74365 8.42611C7.59244 8.3359 7.49952 8.17249 7.49951 7.99642V5.08887ZM14.6668 7.99967C14.6668 10.3397 14.2832 12.059 13.1714 13.1709C12.0595 14.2827 10.3402 14.6663 8.00016 14.6663C5.66011 14.6663 3.94079 14.2827 2.82894 13.1709C1.71709 12.059 1.3335 10.3397 1.3335 7.99967C1.3335 5.65962 1.71709 3.9403 2.82894 2.82845C3.94079 1.7166 5.6601 1.33301 8.00016 1.33301C10.3402 1.33301 12.0595 1.7166 13.1714 2.82845C14.2832 3.9403 14.6668 5.65962 14.6668 7.99967Z" fill="currentColor"/></svg>
                </span>
                <span class="news__item-time-text"><?php
                    printf(
                        /* translators: %d — время чтения в минутах */
                        esc_html(_n('%d minute', '%d minutes', $reading_time, 'nvglobal')),
                        (int) $reading_time
                    );
                ?></span>
            </span>

        </div>

        <div class="news__item-content">

            <a href="<?php the_permalink(); ?>" class="news__item-title"><?php the_title(); ?></a>

            <p class="news__item-description"><?php
                echo esc_html(wp_trim_words(get_the_excerpt(), 32, '...'));
            ?></p>

        </div>

        <a href="<?php echo esc_url($author_url); ?>" class="news__item-author">

            <span class="news__item-author-image"><?php echo $avatar_html; ?></span>

            <span class="news__item-author-info">
                <span class="news__item-author-name"><?php echo esc_html($author_name); ?></span>
                <?php if ($author_job) : ?>
                    <span class="news__item-author-job"><?php echo esc_html($author_job); ?></span>
                <?php endif; ?>
            </span>

        </a>

    </div>

</article>
