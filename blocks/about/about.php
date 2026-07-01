<?php
/**
 * Template for Note block.
 *
 * @param array      $block
 * @param string     $content
 * @param bool       $is_preview
 * @param int|string $post_id
 */

$about_title = get_field('about_title');
$about_text = get_field('about_text');
$about_link  = trim((string) get_field('about_link'));
$about_link_text = trim((string) get_field('about_link_text'));

if (!empty($is_preview) && empty($about_text)) {
  $about_text = '<p>Lorem ipsum dolor sit amet consectetur. Pretium vitae orci quis mi duis nunc. Sed eu elementum dui dui convallis aenean diam sed. Viverra accumsan volutpat sit sit. Pellentesque congue maecenas massa sem viverra. Nunc amet condimentum tincidunt semper etiam egestas amet arcu. Quis viverra tortor phasellus egestas felis risus lorem volutpat varius. Non pharetra orci quam ultrices convallis eget sagittis commodo nunc. Mi ullamcorper nisi odio orci lacus facilisis</p>';
}

if (!empty($is_preview) && empty($about_link)) {
  $about_link = '';
}

if (!empty($is_preview) && (empty(trim((string) get_field('about_link_text'))))) {
  $about_link_text = '';
}
?>

<div class="about-block">
  <div class="about-block__wrapper">
    <div class="about-block-icon">
      <img src="<?php echo get_template_directory_uri(); ?>/img/logo_nv.svg" alt="Нейровижн">
    </div>

    <div class="about-block__content">
      <?php if ($about_title) : ?>
        <div class="about-block-title"><?php echo wp_kses_post($about_title); ?></div>
      <?php endif; ?>
      <?php if ($about_text) : ?>
        <div class="about-block-text"><?php echo wp_kses_post($about_text); ?></div>
      <?php endif; ?>
    </div>


    <?php if ($about_link) : ?>
      <a href="<?php echo esc_url($about_link); ?>" class="btn2 about-block__btn" target="_blank" rel="noopener noreferrer nofollow">
        <span><?php echo esc_html($about_link_text); ?></span>
        <span class="btn2-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16" fill="none">
              <path d="M0 15.1092C0 14.8818 0.084233 14.6544 0.261122 14.4775L6.74704 7.98315L0.286391 1.51408C-0.0589628 1.16873 -0.0589628 0.60437 0.286391 0.259016C0.631745 -0.0863385 1.1961 -0.0863385 1.54146 0.259016L8.63385 7.35983C8.9792 7.70519 8.9792 8.26954 8.63385 8.6149L1.52461 15.741C1.17926 16.0863 0.614899 16.0863 0.269545 15.741C0.0926561 15.5725 0.00842346 15.3367 0.00842346 15.1092H0Z" fill="white"></path>
          </svg>
      </span>
      </a>
    <?php endif; ?>
  </div>
</div>
