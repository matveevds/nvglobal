<?php
/**
 * Template for Steps block.
 *
 * @param array      $block
 * @param string     $content
 * @param bool       $is_preview
 * @param int|string $post_id
 */

$block = $block ?? [];
$data  = $block['data'] ?? [];

$steps_title = trim((string) (get_field('steps_title') ?: ($data['steps_title'] ?? '')));
$steps_style = (get_field('steps_style') ?? ($data['steps_style'] ?? 'style-3-col'));

$steps_items = get_field('steps_items');
if (!is_array($steps_items) || empty($steps_items)) {
  $steps_items = $data['steps_items'] ?? [];
}
$steps_items = is_array($steps_items) ? $steps_items : [];

if (!empty($is_preview) && !$steps_title && empty($steps_items)) {
  $steps_title = 'Как это работает';
  $steps_items = [
    ['steps_item' => 'Шаг 1', 'steps_text' => '<p>Короткое описание первого шага.</p>'],
    ['steps_item' => 'Шаг 2', 'steps_text' => '<p>Ещё один небольшой текст для примера.</p>'],
    ['steps_item' => 'Шаг 3', 'steps_text' => '<p>Финальный шаг с кратким пояснением.</p>'],
  ];
}
?>

<div class="post-steps">
  <div class="post-steps__wrapper">

    <?php if ($steps_title !== '') : ?>
      <div class="post-steps__title"><?php echo esc_html($steps_title); ?></div>
      <div class="post-steps__line"></div>
    <?php endif; ?>

    <?php if (!empty($steps_items)) : ?>
      <div class="post-steps__content">
        <div class="post-steps__list">

          <?php foreach ($steps_items as $row) :
            $item_title = trim((string) ($row['steps_item'] ?? ''));
            $item_text  = (string) ($row['steps_text'] ?? '');
          ?>
            <div class="post-steps__item <?php echo esc_attr($steps_style); ?>">
              <div class="post-steps__item-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5103 1.5C5.08611 1.5 1.5 5.08611 1.5 9.5103C1.5 13.9345 5.08611 17.5206 9.5103 17.5206C13.9345 17.5206 17.5206 13.9345 17.5206 9.5103C17.5206 5.08611 13.9345 1.5 9.5103 1.5ZM0 9.5103C0 4.25768 4.25768 0 9.5103 0C14.7629 0 19.0206 4.25768 19.0206 9.5103C19.0206 14.7629 14.7629 19.0206 9.5103 19.0206C4.25768 19.0206 0 14.7629 0 9.5103Z" fill="#F9AA66"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.4054 2.54531C19.6077 2.90674 19.4787 3.36377 19.1173 3.5661C14.509 6.14587 11.6275 10.3341 10.2528 12.9166C10.1256 13.1556 9.8795 13.3074 9.6088 13.3139C9.3381 13.3204 9.085 13.1806 8.9464 12.948C8.0238 11.3992 6.8536 10.0208 5.42625 8.8154C5.1098 8.5481 5.06992 8.0749 5.33718 7.7585C5.60444 7.442 6.07764 7.40212 6.39409 7.6694C7.61302 8.6988 8.664 9.8485 9.5481 11.1159C11.1686 8.4052 14.0482 4.68478 18.3846 2.25723C18.746 2.0549 19.2031 2.18388 19.4054 2.54531Z" fill="#F9AA66"/>
                </svg>
              </div>
              
              <div class="post-steps__item-info">

                <?php if ($item_title !== '') : ?>
                  <div class="post-steps__item-title"><?php echo esc_html($item_title); ?></div>
                <?php endif; ?>

                <?php if (nv_has_content($item_text)) : ?>
                  <div class="post-steps__item-text"><?php echo wp_kses_post($item_text); ?></div>
                <?php endif; ?>

              </div>

            </div>
          <?php endforeach; ?>

        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
