<?php
/**
 * Template for callout block.
 */

$callout_title = (string) get_field('callout_title');
$callout_text  = (string) get_field('callout_text');
$callout_btn   = (string) get_field('callout_btn');

if ('' === trim(wp_strip_all_tags($callout_title . $callout_text . $callout_btn))) {
  echo nv_block_placeholder($is_preview, 'Коммерческая врезка', 'Заполните заголовок, текст и подпись кнопки');
  return;
}
?>
<div class="callout">
    <div class="callout__wrapper">
        <div class="callout__icon">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/teaser_logo_primary.svg'); ?>"
                 width="32" height="23" alt="NeuroVision Global Systems" loading="lazy" decoding="async">
        </div>
        <div class="callout__content">
            <div class="callout__title"><?php echo get_field('callout_title'); ?></div>
            <div class="callout__text"><?php echo get_field('callout_text'); ?></div>
            <a href="#callForm" class="btn open-callForm callout-btn" data-modal-title="<?php echo get_field('callout_btn'); ?>" data-modal-btn="<?php echo get_field('callout_btn'); ?>">
                <span><?php echo get_field('callout_btn'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M7.55371 19.1092C7.55371 18.8818 7.63794 18.6544 7.81483 18.4775L14.3007 11.9832L7.8401 5.51408C7.49475 5.16873 7.49475 4.60437 7.8401 4.25902C8.18546 3.91366 8.74982 3.91366 9.09517 4.25902L16.1876 11.3598C16.5329 11.7052 16.5329 12.2695 16.1876 12.6149L9.07832 19.741C8.73297 20.0863 8.16861 20.0863 7.82326 19.741C7.64637 19.5725 7.56213 19.3367 7.56213 19.1092H7.55371Z" fill="currentColor"/>
                </svg>
            </a>
        </div>
    </div>
</div>