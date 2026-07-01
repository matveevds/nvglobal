<?php
/**
 * Template for FAQ block.
 */
?>
<div class="faq">
  <div class="faq-block__wrapper">
    <div class="faq-block__list">

      <?php if ( have_rows('faq_list') ) : ?>
        <?php while ( have_rows('faq_list') ) : the_row(); ?>

          <?php
            $question  = get_sub_field('faq_question');
            $answer    = get_sub_field('faq_answer');
            $author_id = (int) get_sub_field('faq_author'); // ACF: User ID

            $author_name = '';
            if ($author_id) {
              $author = get_userdata($author_id);
              $author_name = $author ? $author->display_name : '';
            }

            // Simple User Avatar stores attachment ID in user meta
            $avatar_html = '';
            if ($author_id) {
              $avatar_id = (int) get_user_meta($author_id, 'simple_local_avatar', true);

              if ($avatar_id) {
                $avatar_html = wp_get_attachment_image(
                  $avatar_id,
                  'thumb_120',
                  false,
                  [
                    'class' => 'faq-block__answer-avatar-img',
                    'alt'   => esc_attr($author_name),
                  ]
                );
              } else {
                // fallback (если нет локального аватара)
                $avatar_html = get_avatar(
                  $author_id,
                  120,
                  '',
                  $author_name,
                  ['class' => 'faq-block__answer-avatar-img']
                );
              }
            }
          ?>

          <div class="faq-block__item">
            <div class="faq-block__question">
              <div class="faq-block__question-author">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/author_question.jpg'); ?>" alt="Автор вопроса">
              </div>
              <div class="faq-block__question-content">
                <?php echo esc_html($question); ?>
              </div>
            </div>

            <div class="faq-block__answer">
              <div class="faq-block__answer-content">
                <?php echo esc_html($answer); ?>
              </div>
              <div class="faq-block__answer-author">
                <?php echo $avatar_html; ?>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
      <?php endif; ?>

    </div>
  </div>
</div>

