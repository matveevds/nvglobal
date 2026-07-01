<?php
/**
 * Template for Stages block.
 */

$stages = get_field('stages');
if (empty($stages) || !is_array($stages)) {
  return;
}
?>

<div class="post-stages">
  <div class="post-stages__wrapper">
    <div class="post-stages__list">

      <?php foreach ($stages as $stage) :
        $stage_name   = trim((string) ($stage['stage_name'] ?? ''));
        $stage_title  = trim((string) ($stage['stage_title'] ?? ''));
        $stage_text   = (string) ($stage['stage_text'] ?? '');
        $stage_active = !empty($stage['stage_active']);

        $item_classes = 'post-stages__item' . ($stage_active ? ' post-stages__item--active' : '');
      ?>
        <div class="<?php echo esc_attr($item_classes); ?>">
          <div class="post-stages__item-info post-stages__item-info--content">
            <div class="post-stages__item-top">
              <?php if ($stage_name !== '') : ?>
                <div class="post-stages__item-name"><?php echo esc_html($stage_name); ?></div>
              <?php endif; ?>

              <div class="post-stages__item-hr"></div>

              <?php if ($stage_title !== '') : ?>
                <div class="post-stages__item-title"><?php echo esc_html($stage_title); ?></div>
              <?php endif; ?>
            </div>

            <?php if (trim(strip_tags($stage_text)) !== '') : ?>
              <div class="post-stages__item-text"><?php echo wp_kses_post($stage_text); ?></div>
            <?php endif; ?>
          </div>

          <div class="post-stages__item-line-wrapper">
            <div class="post-stages__item-line"></div>
          </div>

          <div class="post-stages__item-info post-stages__item-info--empty"></div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>
