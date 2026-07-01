<?php
/**
 * Template for NV Single Image block.
 */

$image      = get_field('nv_image');
$caption    = trim((string) get_field('nv_caption'));
$source     = trim((string) get_field('nv_source'));
$sourcelink = trim((string) get_field('nv_sourcelink'));

if (empty($image)) {
  return;
}

// Если ACF возвращает ID
if (is_numeric($image)) {
  $image_id = (int) $image;
  $src = wp_get_attachment_image_url($image_id, 'full');
  $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
} else {
  $src = $image['url'] ?? '';
  $alt = $image['alt'] ?? '';
}

if (empty($src)) {
  return;
}

$alt = trim((string) $alt);
if ($alt === '') {
  $alt = $caption !== '' ? $caption : 'Image';
}
?>

<figure class="nv-single-image wp-block-image">
  <div class="nv-single-image-container">
    
    <div class="nv-single-image__wrapper">
      <img
        src="<?php echo esc_url($src); ?>"
        alt="<?php echo esc_attr($alt); ?>"
        class="nv-single-image__img"
        loading="lazy"
        decoding="async"
      >
    </div>

    <?php if ($caption !== '' || $source !== '') : ?>
      <figcaption class="nv-single-image__meta">

        <?php if ($caption !== '') : ?>
          <div class="nv-single-image__caption wp-element-caption">
            <?php echo esc_html($caption); ?>
          </div>
        <?php endif; ?>

        <?php if ($source !== '') : ?>
          <div class="nv-single-image__source">
            <span class="nv-single-image__source-label">Source:</span>

            <?php if ($sourcelink !== '') : ?>
              <a href="<?php echo esc_url($sourcelink); ?>" class="nv-single-image__source-link" target="_blank" rel="noopener nofollow">
                <span><?php echo esc_html($source); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M10.8659 4.45477C11.0297 4.15092 11.4092 4.03709 11.7131 4.20086H11.7139L11.7147 4.20168C11.7155 4.20211 11.7167 4.20259 11.718 4.20331C11.7209 4.20488 11.725 4.20779 11.7302 4.21063C11.7407 4.21639 11.7563 4.22429 11.7758 4.23504C11.8149 4.25676 11.8719 4.2886 11.9434 4.32944C12.0863 4.41111 12.289 4.53005 12.5318 4.67938C13.0161 4.97731 13.6657 5.40118 14.3181 5.90171C14.9667 6.39941 15.6384 6.98865 16.154 7.61965C16.6576 8.23591 17.0834 8.97814 17.0834 9.77052L17.0785 9.91782C17.03 10.6549 16.627 11.344 16.1548 11.9222C15.6392 12.5535 14.9667 13.1422 14.3181 13.6402C13.6657 14.1409 13.0161 14.5653 12.5318 14.8633C12.289 15.0127 12.0863 15.1315 11.9434 15.2132C11.8719 15.2541 11.8149 15.2859 11.7758 15.3076C11.7566 15.3183 11.7415 15.3263 11.731 15.332C11.7257 15.3349 11.7209 15.3378 11.718 15.3394C11.7167 15.3401 11.7155 15.3406 11.7147 15.341L11.7139 15.3418H11.7131C11.4093 15.5056 11.0298 15.3925 10.8659 15.0887C10.7021 14.7849 10.816 14.4054 11.1198 14.2416C11.1202 14.2414 11.1213 14.2413 11.1223 14.2407C11.1242 14.2397 11.1272 14.2381 11.1312 14.2359C11.1397 14.2312 11.153 14.2235 11.1703 14.2139C11.2049 14.1947 11.2563 14.1654 11.3225 14.1276C11.4553 14.0517 11.6468 13.9403 11.8767 13.7988C12.3375 13.5153 12.9485 13.1156 13.5564 12.6489C14.168 12.1794 14.7568 11.6573 15.1864 11.1312C15.4027 10.8664 15.5616 10.6203 15.6682 10.3963H3.95837C3.6132 10.3963 3.33337 10.1165 3.33337 9.77134C3.33339 9.42618 3.61321 9.14634 3.95837 9.14634H15.669C15.5625 8.92216 15.4032 8.67596 15.1864 8.41066C14.7568 7.88489 14.1689 7.36225 13.5572 6.89292C12.9492 6.42643 12.3376 6.02736 11.8767 5.74383C11.647 5.60259 11.4561 5.49098 11.3233 5.41506C11.257 5.37716 11.205 5.34801 11.1703 5.32879C11.153 5.31923 11.1397 5.31226 11.1312 5.30763C11.127 5.30534 11.1242 5.30297 11.1223 5.30194C11.1213 5.30142 11.1202 5.30132 11.1198 5.30112C10.8162 5.1374 10.7025 4.75853 10.8659 4.45477Z" fill="#FBFBFB"/>
                </svg>
              </a>
            <?php else : ?>
              <?php echo esc_html($source); ?>
            <?php endif; ?>

          </div>
        <?php endif; ?>

      </figcaption>
    <?php endif; ?>

  </div>
</figure>