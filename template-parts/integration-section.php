<?php
/**
 * Секция Integration (`.integration`) — универсальный блок: один вид (Identity), стили — css/blocks/integration.css. Слайдер
 * путей интеграции слева и до трёх карточек справа; все тексты, id и ссылки — аргументы. Один экземпляр на страницу
 * (JS `[data-integration-slider]`). Стандартное содержимое KYC/Solutions — inc/integration-preset.php.
 *
 * Аргументы (значения по умолчанию пустые, пустое не выводится):
 *  - section_id — id секции (например integration, api);
 *  - badge, heading, subtitle — бейдж, заголовок, подзаголовок (subtitle допускает &nbsp; и простую разметку);
 *  - docs_text, docs_url        — кнопка-ссылка (например «View documentation»);
 *  - contact_text, contact_form — кнопка открытия формы: подпись и класс модалки (open-callForm2);
 *  - path_title — заголовок слайдера; slides — 1–5 слайдов: title, subtitle, description (простой текст);
 *  - includes   — карточка-список: title, items (строки);
 *  - deploy     — карточка с картинкой: title, note, img (имя файла в img/ без `.webp`), w/h;
 *  - backoffice — карточка с чипами: title, chips (строки), img, w/h.
 */
$nv_in_id        = $args['section_id'] ?? '';
$nv_in_badge     = $args['badge'] ?? '';
$nv_in_heading   = $args['heading'] ?? '';
$nv_in_subtitle  = $args['subtitle'] ?? '';
$nv_in_docs_text = $args['docs_text'] ?? '';
$nv_in_docs_url  = $args['docs_url'] ?? '';
$nv_in_cont_text = $args['contact_text'] ?? '';
$nv_in_cont_form = $args['contact_form'] ?? '';
$nv_in_path      = $args['path_title'] ?? '';
$nv_in_slides    = isset($args['slides']) ? array_values((array) $args['slides']) : array();
$nv_in_includes  = isset($args['includes']) ? (array) $args['includes'] : array();
$nv_in_deploy    = isset($args['deploy']) ? (array) $args['deploy'] : array();
$nv_in_back      = isset($args['backoffice']) ? (array) $args['backoffice'] : array();
$nv_in_img_base  = get_template_directory_uri() . '/img/';
$nv_in_card_img  = static function (array $card, string $mod) use ($nv_in_img_base): string {
    if (empty($card['img'])) {
        return '';
    }
    return '<img class="integration__card-image integration__card-image--' . esc_attr($mod) . '" src="' . esc_url($nv_in_img_base . $card['img'] . '.webp') . '"'
        . ' srcset="' . esc_url($nv_in_img_base . $card['img'] . '.webp') . ' 1x, ' . esc_url($nv_in_img_base . $card['img'] . '@2x.webp') . ' 2x"'
        . ' width="' . (int) ($card['w'] ?? 335) . '" height="' . (int) ($card['h'] ?? 224) . '" alt="" aria-hidden="true" loading="lazy" decoding="async">';
};
?>
<section class="section integration"<?php echo '' !== $nv_in_id ? ' id="' . esc_attr($nv_in_id) . '"' : ''; ?>>
    <div class="container">
        <div class="integration__head">
            <?php if ('' !== $nv_in_badge) : ?>
            <div class="section__badge"><?php echo esc_html($nv_in_badge); ?></div>
            <?php endif; ?>
            <div class="integration__head-row">
                <div class="integration__title-block">
                    <?php if ('' !== $nv_in_heading) : ?>
                    <h2 class="section__title integration__title"><?php echo esc_html($nv_in_heading); ?></h2>
                    <?php endif; ?>
                    <?php if ('' !== $nv_in_subtitle) : ?>
                    <p class="integration__subtitle"><?php echo wp_kses_post($nv_in_subtitle); ?></p>
                    <?php endif; ?>
                </div>
                <?php if ('' !== $nv_in_docs_text || '' !== $nv_in_cont_text) : ?>
                <div class="integration__actions">
                    <?php if ('' !== $nv_in_docs_text) : ?>
                    <a class="integration__btn integration__btn--primary" href="<?php echo esc_url($nv_in_docs_url); ?>">
                        <span class="integration__btn-text"><?php echo esc_html($nv_in_docs_text); ?></span>
                        <span class="integration__btn-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                    </a>
                    <?php endif; ?>
                    <?php if ('' !== $nv_in_cont_text) : ?>
                    <button class="integration__btn integration__btn--ghost <?php echo esc_attr($nv_in_cont_form); ?>" type="button">
                        <span class="integration__btn-text"><?php echo esc_html($nv_in_cont_text); ?></span>
                        <span class="integration__btn-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7247C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg></span>
                    </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="integration__board">
            <div class="integration__path" data-integration-slider>
                <?php if ('' !== $nv_in_path) : ?>
                <h3 class="integration__path-title"><?php echo esc_html($nv_in_path); ?></h3>
                <?php endif; ?>
                <div class="integration__path-body">
                    <div class="integration__nav">
                        <button type="button" class="integration__arrow integration__arrow--prev" aria-label="Previous integration path"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <path d="M10.0137 5.5564C10.3648 5.41076 10.7767 5.5525 10.9609 5.89429C11.1571 6.25879 11.0206 6.71344 10.6562 6.90992C10.6558 6.91015 10.6545 6.91027 10.6533 6.91089C10.651 6.91214 10.6476 6.915 10.6426 6.91773C10.6324 6.92329 10.6164 6.93167 10.5957 6.94312C10.5541 6.96616 10.4925 7.00125 10.4131 7.04664C10.2537 7.13778 10.0238 7.27147 9.74805 7.44117C9.19501 7.78146 8.46189 8.26114 7.73242 8.82105C6.99842 9.38447 6.29193 10.0111 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5895 5.77637 13.908C6.29187 14.5388 6.99755 15.1652 7.73145 15.7283C8.46104 16.2881 9.19491 16.767 9.74805 17.1072C10.0236 17.2767 10.2527 17.4106 10.4121 17.5017C10.4916 17.5472 10.5541 17.5822 10.5957 17.6052C10.6165 17.6168 10.6324 17.626 10.6426 17.6316C10.6475 17.6343 10.6511 17.6362 10.6533 17.6375L10.6562 17.6384L10.7217 17.6785C11.0364 17.8917 11.1452 18.3132 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919L9.94434 18.9587H9.94336L9.94238 18.9578C9.94141 18.9572 9.94006 18.9567 9.93848 18.9558C9.93505 18.954 9.92992 18.9513 9.92383 18.948C9.91116 18.9411 9.89248 18.9307 9.86914 18.9177C9.82212 18.8917 9.75372 18.8535 9.66797 18.8044C9.49654 18.7065 9.25318 18.5637 8.96191 18.3845C8.3807 18.027 7.60115 17.5183 6.81836 16.9177C6.04002 16.3205 5.23395 15.6134 4.61523 14.8562C4.04864 14.1628 3.56398 13.3371 3.50586 12.4529L3.5 12.2761V12.2742C3.5 12.2729 3.50097 12.2716 3.50098 12.2703C3.50295 11.3213 4.01126 10.4325 4.61426 9.6941C5.23299 8.93647 6.03997 8.22911 6.81836 7.6316C7.60128 7.03062 8.38067 6.52147 8.96191 6.16382C9.25325 5.98456 9.49653 5.84193 9.66797 5.7439C9.75368 5.69489 9.82214 5.65766 9.86914 5.6316C9.89234 5.61874 9.91016 5.60826 9.92285 5.60132C9.92922 5.59784 9.93494 5.59445 9.93848 5.59253C9.94003 5.59169 9.94143 5.59109 9.94238 5.59058L9.94336 5.5896H9.94434L10.0137 5.5564Z" fill="currentColor"/> </g> </svg></button>
                        <button type="button" class="integration__arrow integration__arrow--next" aria-label="Next integration path"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29338 14.7468 5.43611 15.0381 5.6153C15.6193 5.97282 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.9891 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4082 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89265C13.9764 6.72316 13.7473 6.58922 13.5879 6.49812C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36163 13.3438 6.3614C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/> </g> </svg></button>
                    </div>

                    <div class="integration__slider">
                        <div class="integration__swiper swiper">
                            <div class="swiper-wrapper">
                            <?php foreach ($nv_in_slides as $nv_slide) : ?>
                                <div class="integration__slide swiper-slide">
                                <span class="integration__slide-icon" aria-hidden="true"><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g> <path d="M10.2246 3.84082C10.9531 2.38602 13.0469 2.38602 13.7754 3.84082L15.6025 7.49219L15.665 7.58691C15.7388 7.6731 15.844 7.7328 15.9639 7.75L20.0518 8.33789H20.0527C21.6655 8.57087 22.3383 10.5488 21.1455 11.6934L21.1445 11.6924L18.1895 14.5322C18.0773 14.6401 18.0293 14.792 18.0547 14.9385V14.9395L18.7529 18.9492V18.9502C19.034 20.575 17.3154 21.7672 15.8818 21.0225V21.0234L12.2275 19.1289V19.1279C12.0864 19.0549 11.9147 19.054 11.7715 19.1279L8.11816 21.0234L8.11719 21.0225C6.68412 21.7663 4.96495 20.5749 5.24805 18.9492L5.94531 14.9395V14.9385C5.97069 14.792 5.92173 14.641 5.80957 14.5332V14.5322L2.85547 11.6924L2.85449 11.6934C1.66166 10.5488 2.33449 8.57087 3.94727 8.33789H3.94824L8.03613 7.75L8.15137 7.71875C8.25986 7.67484 8.34776 7.5936 8.39844 7.49219L10.2246 3.8418V3.84082ZM12.4336 4.5127C12.2692 4.18437 11.8055 4.164 11.6035 4.45117L11.5664 4.5127L9.74023 8.16309C9.44967 8.74449 8.8901 9.14241 8.24902 9.23437L4.16113 9.82227C3.75466 9.88139 3.6242 10.3522 3.89258 10.6104L3.89355 10.6113L6.84961 13.4512V13.4521C7.28902 13.8747 7.50627 14.4738 7.43945 15.0762L7.42285 15.1963L6.72656 19.2061V19.207C6.66459 19.5646 7.05485 19.8853 7.42676 19.6924L7.42773 19.6914L11.0811 17.7969H11.082C11.6571 17.4993 12.3439 17.4984 12.9189 17.7969L16.5723 19.6914L16.5732 19.6924C16.9217 19.8731 17.288 19.6025 17.2812 19.2725L17.2744 19.2061L16.5771 15.1963C16.4653 14.5543 16.6818 13.9028 17.1504 13.4521V13.4512L20.1074 10.6104C20.3759 10.3521 20.2448 9.882 19.8379 9.82324L15.751 9.23437C15.1893 9.1538 14.6918 8.83862 14.3818 8.37207L14.2607 8.16309L12.4336 4.5127Z" fill="currentColor"/> </g> </svg></span>
                                <div class="integration__slide-text">
                                    <h4 class="integration__slide-title"><?php echo esc_html($nv_slide['title'] ?? ''); ?><?php if (!empty($nv_slide['subtitle'])) : ?><span class="integration__slide-subtitle"><?php echo esc_html($nv_slide['subtitle']); ?></span><?php endif; ?></h4>
                                    <?php if (!empty($nv_slide['description'])) : ?>
                                    <p class="integration__slide-description"><?php echo esc_html($nv_slide['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        </div>

                        <?php /* 539:11129 — индикатор, а не управление: переключают стрелки, свайп и клавиатура. */ ?>
                        <div class="integration__pagination" aria-hidden="true">
                            <?php foreach ($nv_in_slides as $nv_i => $nv_slide) : ?>
                            <span class="integration__bar<?php echo (0 === $nv_i) ? ' is-active' : ''; ?>"></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($nv_in_includes || $nv_in_deploy || $nv_in_back) : ?>
            <div class="integration__info">
                <?php if (!empty($nv_in_includes['items'])) : ?>
                <div class="integration__card integration__card--list">
                    <?php if (!empty($nv_in_includes['title'])) : ?>
                    <h3 class="integration__card-title"><?php echo esc_html($nv_in_includes['title']); ?></h3>
                    <?php endif; ?>
                    <ul class="integration__list">
                        <?php foreach ((array) $nv_in_includes['items'] as $nv_item) : ?>
                        <li class="integration__list-item"><?php echo esc_html($nv_item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($nv_in_deploy['title'])) : ?>
                <div class="integration__card integration__card--deploy">
                    <div class="integration__card-text">
                        <h3 class="integration__card-title"><?php echo wp_kses_post($nv_in_deploy['title']); ?></h3>
                        <?php if (!empty($nv_in_deploy['note'])) : ?>
                        <p class="integration__card-note"><?php echo esc_html($nv_in_deploy['note']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php echo $nv_in_card_img($nv_in_deploy, 'servers'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($nv_in_back['title'])) : ?>
                <div class="integration__card integration__card--backoffice">
                    <div class="integration__card-text">
                        <h3 class="integration__card-title"><?php echo esc_html($nv_in_back['title']); ?></h3>
                        <?php if (!empty($nv_in_back['chips'])) : ?>
                        <ul class="integration__chips">
                            <?php foreach ((array) $nv_in_back['chips'] as $nv_chip) : ?>
                            <li class="integration__chip"><?php echo esc_html($nv_chip); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php echo $nv_in_card_img($nv_in_back, 'folders'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
