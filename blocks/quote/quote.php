<?php
/**
 * Template for Quote block.
 */

$quote_content = get_field('quote_content'); // textarea / wysiwyg
$author        = trim((string) get_field('quote_author'));
$job           = trim((string) get_field('quote_author_job'));
$author_image  = get_field('quote_author_image'); // image array or ID (depends on ACF setting)

// если ACF возвращает ID вместо массива — получим массив
if (!empty($author_image) && is_numeric($author_image)) {
  $author_image = wp_get_attachment_image_src((int) $author_image, 'thumbnail');
}
?>

<figure class="quote">
  <div class="quote__wrapper">

    <blockquote class="quote__blockquote">
      <div class="quote__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M7.04497 18.81C5.55497 18.81 4.04496 18.08 3.18496 16.86C1.86496 14.99 2.22496 12.66 2.56496 11.44C3.23496 8.97003 4.74497 6.80003 6.82497 5.31003C7.08497 5.13003 7.42496 5.12003 7.68496 5.30003L9.18496 6.33003C9.35496 6.45003 9.47497 6.63003 9.50497 6.84003C9.53497 7.05003 9.47496 7.26003 9.34496 7.42003C8.82496 8.07003 8.38496 8.78003 8.03497 9.54003C8.93497 9.78003 9.76498 10.29 10.395 10.99C11.485 12.22 11.855 13.91 11.385 15.52C10.925 17.07 9.74497 18.25 8.22497 18.67C7.84497 18.78 7.45495 18.83 7.05495 18.83L7.04497 18.81ZM7.28497 6.84003C5.71496 8.10003 4.53498 9.90003 4.01498 11.83C3.56498 13.48 3.71497 14.99 4.41497 15.99C5.15497 17.03 6.58496 17.55 7.81496 17.21C8.84496 16.92 9.62496 16.15 9.93496 15.09C10.265 13.98 10.015 12.82 9.26498 11.98C8.68498 11.32 7.81496 10.91 6.93496 10.87C6.69496 10.86 6.47496 10.74 6.34496 10.54C6.21496 10.34 6.18498 10.09 6.26498 9.87003C6.62498 8.90003 7.09496 7.98003 7.68496 7.13003L7.27496 6.85003L7.28497 6.84003Z" fill="#F9AA66"/>
          <path d="M17.2249 18.81C15.7349 18.81 14.2249 18.08 13.3649 16.86C12.0449 14.99 12.4049 12.66 12.7449 11.44C13.4149 8.97003 14.9249 6.80003 17.0049 5.31003C17.2649 5.13003 17.6049 5.12003 17.8649 5.30003L19.3649 6.33003C19.5349 6.45003 19.6549 6.63003 19.6849 6.84003C19.7149 7.05003 19.6549 7.26003 19.5249 7.42003C19.0049 8.07003 18.5649 8.78003 18.2049 9.54003C19.1049 9.78003 19.9349 10.29 20.5649 10.99C21.6549 12.22 22.0249 13.91 21.5449 15.52C21.0849 17.07 19.9049 18.24 18.3849 18.66C18.0049 18.77 17.6149 18.82 17.2149 18.82L17.2249 18.81ZM17.4649 6.84003C15.9049 8.10003 14.7149 9.90003 14.1949 11.83C13.7449 13.48 13.8949 14.99 14.5949 15.99C15.3349 17.04 16.7649 17.55 17.9949 17.21C19.0249 16.92 19.8049 16.15 20.1149 15.09C20.4449 13.98 20.1949 12.82 19.4449 11.98C18.8649 11.32 17.9949 10.91 17.1149 10.87C16.8749 10.86 16.6549 10.74 16.5249 10.54C16.3949 10.34 16.3649 10.09 16.4449 9.87003C16.8049 8.90003 17.2749 7.98003 17.8649 7.13003L17.4549 6.85003L17.4649 6.84003Z" fill="#F9AA66"/>
        </svg>
      </div>

      <?php if (!empty($quote_content)) : ?>
        <div class="quote__content"><?php echo wp_kses_post($quote_content); ?></div>
      <?php endif; ?>
    </blockquote>

    <?php if ($author) : ?>
      <figcaption class="quote__caption">
        <div class="quote__author">
          <cite class="quote__author-name"><?php echo esc_html($author); ?></cite>

          <?php if ($job) : ?>
            <span class="quote__author-job"><?php echo esc_html($job); ?></span>
          <?php endif; ?>
        </div>

        <?php if (!empty($author_image) && is_array($author_image)) : ?>
          <?php
            // Вариант ACF image array: $author_image['sizes']['thumbnail']
            $thumb_url = $author_image['sizes']['thumbnail'] ?? ($author_image['url'] ?? '');
            $alt       = $author_image['alt'] ?? $author;
          ?>
          <?php if ($thumb_url) : ?>
            <div class="quote__author-image">
              <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($alt ?: $author); ?>">
            </div>
          <?php endif; ?>

        <?php elseif (!empty($author_image) && is_array($author_image) && isset($author_image[0])) : ?>
          <?php // если пришёл wp_get_attachment_image_src() ?>
          <div class="quote__author-image">
            <img src="<?php echo esc_url($author_image[0]); ?>" alt="<?php echo esc_attr($author); ?>">
          </div>
        <?php endif; ?>
      </figcaption>
    <?php endif; ?>

  </div>
</figure>
