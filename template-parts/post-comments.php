<?php
/**
 * Комментарии под записью — Figma 2570:39540: форма «Comment» (имя, должность,
 * сообщение, согласие, «Publish») и список комментариев.
 *
 * Используется стандартная обработка WordPress (`wp-comments-post.php`), поэтому
 * модерация, очереди и спам-фильтры работают штатно. Дополнительно (functions.php,
 * `nv_comments_*`): должность хранится в мете комментария `nv_position`, e-mail
 * не требуется, ловушка-«медовый горшок» и обязательное согласие проверяются на сервере.
 *
 * Выводится только если комментарии у записи открыты или уже есть (см. single.php).
 */

$nv_post_id  = get_the_ID();
$nv_comments = get_comments([
    'post_id' => $nv_post_id,
    'status'  => 'approve',
    'type'    => 'comment',
    'order'   => 'DESC',
]);
$nv_open     = comments_open($nv_post_id);
$nv_pending  = isset($_GET['unapproved']);
$nv_privacy  = home_url('/privacy-policy/');
?>
<section class="post-comments" id="comments" aria-label="Comments">
    <?php if ($nv_open) : ?>
    <div class="post-comments__form-card">
        <h2 class="post-comments__title" id="post-comments-title">Comment</h2>

        <?php if ($nv_pending) : ?>
            <p class="post-comments__notice" role="status">Thank you! Your comment is awaiting moderation.</p>
        <?php endif; ?>

        <form class="post-comments__form" action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post">
            <div class="post-comments__row">
                <label class="post-comments__field">
                    <span class="post-comments__label">Name <span class="post-comments__req" aria-hidden="true">*</span></span>
                    <span class="post-comments__control">
                        <svg class="post-comments__icon" aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="6.5" r="3" stroke="currentColor" stroke-width="1.5"/><path d="M4 16c.6-2.6 3-4 6-4s5.4 1.4 6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        <input type="text" name="author" required maxlength="245" autocomplete="name" placeholder="e.g. John Smith">
                    </span>
                </label>
                <label class="post-comments__field">
                    <span class="post-comments__label">Position <span class="post-comments__req" aria-hidden="true">*</span></span>
                    <span class="post-comments__control">
                        <svg class="post-comments__icon" aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="3" y="6" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7.5 6V5a1.5 1.5 0 0 1 1.5-1.5h2A1.5 1.5 0 0 1 12.5 5v1" stroke="currentColor" stroke-width="1.5"/></svg>
                        <input type="text" name="nv_position" required maxlength="120" autocomplete="organization-title" placeholder="e.g. Designer">
                    </span>
                </label>
            </div>

            <label class="post-comments__field">
                <span class="post-comments__label">Message <span class="post-comments__req" aria-hidden="true">*</span></span>
                <textarea class="post-comments__textarea" name="comment" required maxlength="2000" rows="5" placeholder="Add your message here..."></textarea>
            </label>

            <label class="post-comments__consent">
                <input type="checkbox" name="nv_consent" value="1" required>
                <span>We value your privacy. By submitting this form, you consent to the use of your information in accordance with our <a href="<?php echo esc_url($nv_privacy); ?>" target="_blank" rel="noopener">Privacy Policy</a></span>
            </label>

            <?php /* Ловушка для ботов: человек поле не видит и не заполняет. */ ?>
            <div class="post-comments__trap" aria-hidden="true">
                <label>Website <input type="text" name="nv_website" tabindex="-1" autocomplete="off"></label>
            </div>

            <input type="hidden" name="comment_post_ID" value="<?php echo (int) $nv_post_id; ?>">
            <input type="hidden" name="comment_parent" value="0">
            <?php wp_comment_form_unfiltered_html_nonce(); ?>

            <div class="post-comments__actions">
                <button type="submit" class="header-btn header-btn--primary header-btn--small post-comments__submit">
                    <span class="header-btn__text">Publish</span>
                    <?php echo nv_header_icon('arrow', 'header-btn__icon'); ?>
                </button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <?php if (!empty($nv_comments)) : ?>
    <ul class="post-comments__list">
        <?php foreach ($nv_comments as $nv_c) :
            $nv_pos = trim((string) get_comment_meta($nv_c->comment_ID, 'nv_position', true));
            ?>
        <li class="post-comments__item" id="comment-<?php echo (int) $nv_c->comment_ID; ?>">
            <div class="post-comments__meta">
                <span class="post-comments__author"><?php echo esc_html(get_comment_author($nv_c)); ?></span>
                <?php if ($nv_pos !== '') : ?><span class="post-comments__position"><?php echo esc_html($nv_pos); ?></span><?php endif; ?>
                <time class="post-comments__date" datetime="<?php echo esc_attr(get_comment_date('c', $nv_c)); ?>"><?php echo esc_html(date('M d, Y', strtotime($nv_c->comment_date))); ?></time>
            </div>
            <div class="post-comments__text"><?php echo wp_kses_post(wpautop(get_comment_text($nv_c))); ?></div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</section>
