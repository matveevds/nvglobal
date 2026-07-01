<?php
/**
 * Template for success block.
 */

$content = (string) get_field('text_content');
$icon_url = get_template_directory_uri() . '/img/success.svg';
?>

<div class="success">
  <div class="success__wrapper">
    <div class="success__icon" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7603 3.98975C7.33611 3.98975 3.75 7.57586 3.75 12C3.75 16.4242 7.33611 20.0103 11.7603 20.0103C16.1845 20.0103 19.7706 16.4242 19.7706 12C19.7706 7.57586 16.1845 3.98975 11.7603 3.98975ZM2.25 12C2.25 6.74743 6.50768 2.48975 11.7603 2.48975C17.0129 2.48975 21.2706 6.74743 21.2706 12C21.2706 17.2526 17.0129 21.5103 11.7603 21.5103C6.50768 21.5103 2.25 17.2526 2.25 12Z" fill="#FBFBFB"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.6554 5.03506C21.8577 5.39649 21.7287 5.85352 21.3673 6.05585C16.759 8.63562 13.8775 12.8238 12.5028 15.4063C12.3756 15.6453 12.1295 15.7971 11.8588 15.8036C11.5881 15.8101 11.335 15.6703 11.1964 15.4377C10.2738 13.8889 9.1036 12.5105 7.67625 11.3051C7.3598 11.0378 7.31992 10.5646 7.58718 10.2482C7.85444 9.93175 8.32764 9.89187 8.64409 10.1591C9.86302 11.1885 10.914 12.3382 11.7981 13.6056C13.4186 10.8949 16.2982 7.17453 20.6346 4.74698C20.996 4.54465 21.4531 4.67363 21.6554 5.03506Z" fill="#FBFBFB"/>
      </svg>
    </div>

    <?php if (trim(strip_tags($content)) !== '') : ?>
      <div class="success__content"><?php echo wp_kses_post($content); ?></div>
    <?php endif; ?>
  </div>
</div>
