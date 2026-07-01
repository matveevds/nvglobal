<?php
/**
 * Template for Pillar block.
 */

$pillar = get_field('pillar');
if (empty($pillar) || !is_array($pillar)) return;
?>

<div class="pillar">
  <div class="pillar__wrapper">
    <div class="pillar__list">

      <?php foreach ($pillar as $item) :
        $name      = trim((string) ($item['pillar_name'] ?? ''));
        $pct       = trim((string) ($item['pillar_percent'] ?? ''));
        $color     = trim((string) ($item['pillar_color'] ?? ''));
        $pct_color = trim((string) ($item['pillar_percent_color'] ?? ''));
        $height    = (int) ($item['pillar_height'] ?? 0);

        if ($pct_color === '') $pct_color = $color;

        $line_style = [];
        if ($color)  $line_style[] = 'background-color:' . esc_attr($color);
        if ($height) $line_style[] = 'height:' . $height . 'px';

        $sep_style  = $pct_color ? 'background-color:' . esc_attr($pct_color) : '';
        $pct_style  = $pct_color ? 'color:' . esc_attr($pct_color) : '';
      ?>
        <div class="pillar__item">

          <div class="pillar__item-info">
            <?php if ($name !== '') : ?>
              <div class="pillar__item-name"><?php echo esc_html($name); ?></div>
            <?php endif; ?>

            <div class="pillar__item-separator"<?php if ($sep_style) : ?> style="<?php echo esc_attr($sep_style); ?>"<?php endif; ?>></div>

            <?php if ($pct !== '') : ?>
              <div class="pillar__item-percent"<?php if ($pct_style) : ?> style="<?php echo esc_attr($pct_style); ?>"<?php endif; ?>>
                <?php echo esc_html($pct); ?>
              </div>
            <?php endif; ?>

          </div>

          <div class="pillar__item-line-wrapper">
            <div class="pillar__item-line"<?php if ($line_style) : ?> style="<?php echo esc_attr(implode(';', $line_style)); ?>"<?php endif; ?>>
              <div class="pillar__item-circle"<?php if ($sep_style) : ?> style="<?php echo esc_attr($sep_style); ?>"<?php endif; ?>></div>
            </div>
          </div>

          <div class="pillar__item-empty"></div>

        </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>
