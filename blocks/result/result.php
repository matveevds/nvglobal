<?php
/**
 * Template for Result block.
 */
$result_title = get_field('result_title') ?: '';
$result_text  = get_field('result_text') ?: '';

if ('' === trim(wp_strip_all_tags((string) $result_title . (string) $result_text))) {
  echo nv_block_placeholder($is_preview, 'Вывод', 'Заполните заголовок и текст в настройках блока');
  return;
}
?>

<div class="result">
  <div class="result__wrapper">
    <?php if ($result_title) : ?>
      <div class="result__title"><?php echo esc_html($result_title); ?></div>
    <?php endif; ?>

    <?php if ($result_text) : ?>
      <div class="result__text"><?php echo wp_kses_post($result_text); ?></div>
    <?php endif; ?>
  </div>
</div>
