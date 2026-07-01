<?php
/**
 * Template for tabs block.
 */

$tabs = get_field('tabs');
if (empty($tabs) || !is_array($tabs)) {
    return;
}

$block_id = 'tabs-' . (!empty($block['id']) ? $block['id'] : uniqid());
?>

<div class="tabs" data-tabs id="<?php echo esc_attr($block_id); ?>">
    <div class="tabs__wrapper">
        <div class="tabs__titles-block" role="tablist" aria-label="Tabs">
            <div class="tabs__titles-arrow tabs__titles-arrow-prev tabs__titles-arrow-disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M11 3.26083C11 3.41245 10.9432 3.56407 10.8238 3.682L6.44779 8.01156L10.8068 12.3243C11.0398 12.5545 11.0398 12.9307 10.8068 13.161C10.5738 13.3912 10.193 13.3912 9.95998 13.161L5.17476 8.4271C4.94175 8.19687 4.94175 7.82063 5.17476 7.59039L9.97703 2.83967C10.21 2.60943 10.5908 2.60943 10.8238 2.83967C10.9432 2.95198 11 3.10921 11 3.26083Z" fill="#2E2E2E"/>
                </svg>
            </div>
            <?php foreach ($tabs as $i => $tab): 
                $is_active = ($i === 0);
                $title = $tab['tab_title'] ?? '';
                $tab_btn_id = $block_id . '-tab-' . $i;
                $panel_id   = $block_id . '-panel-' . $i;
            ?>
                <button type="button" class="tabs__title<?php echo $is_active ? ' is-active' : ''; ?>" role="tab" id="<?php echo esc_attr($tab_btn_id); ?>" aria-controls="<?php echo esc_attr($panel_id); ?>" aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>" tabindex="<?php echo $is_active ? '0' : '-1'; ?>" data-tab data-tab-index="<?php echo esc_attr($i); ?>">
                    <?php echo esc_html($title); ?>
                </button>
            <?php endforeach; ?>
            <div class="tabs__titles-arrow tabs__titles-arrow-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M5.03516 12.7398C5.03516 12.5882 5.09131 12.4366 5.20924 12.3187L9.53318 7.98909L5.22608 3.67638C4.99585 3.44614 4.99585 3.06991 5.22608 2.83967C5.45632 2.60943 5.83256 2.60943 6.0628 2.83967L10.7911 7.57355C11.0213 7.80378 11.0213 8.18002 10.7911 8.41026L6.05156 13.161C5.82133 13.3912 5.44509 13.3912 5.21485 13.161C5.09693 13.0487 5.04077 12.8914 5.04077 12.7398H5.03516Z" fill="#2E2E2E"/>
                </svg>
            </div>
        </div>

        <div class="tabs__content">
            <?php foreach ($tabs as $i => $tab): 
                $is_active = ($i === 0);
                $text = $tab['tab_text'] ?? '';
                $tab_btn_id = $block_id . '-tab-' . $i;
                $panel_id   = $block_id . '-panel-' . $i;
            ?>
                <div
                    class="tabs__content-item<?php echo $is_active ? ' is-active' : ''; ?>"
                    role="tabpanel"
                    id="<?php echo esc_attr($panel_id); ?>"
                    aria-labelledby="<?php echo esc_attr($tab_btn_id); ?>"
                    <?php echo $is_active ? '' : 'hidden'; ?>
                    data-tab-panel
                    data-tab-index="<?php echo esc_attr($i); ?>"
                >
                    <?php
                    // Если tab_text — WYSIWYG, лучше выводить так:
                    echo wp_kses_post($text);
                    ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="tabs__arrows">
            <div class="tabs__arrows-list">
                <div class="tabs__arrow-item tabs__arrow-prev tabs__arrow-disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16" fill="none">
                        <path d="M9 0.890761C9 1.11819 8.91475 1.34562 8.73573 1.52251L2.17168 8.01685L8.71016 14.4859C9.05967 14.8313 9.05967 15.3956 8.71016 15.741C8.36064 16.0863 7.78949 16.0863 7.43997 15.741L0.262136 8.64017C-0.0873786 8.29481 -0.0873786 7.73046 0.262136 7.3851L7.46554 0.259016C7.81506 -0.0863385 8.38622 -0.0863385 8.73573 0.259016C8.91475 0.427481 9 0.663332 9 0.890761Z" fill="white"/>
                    </svg>
                </div>
                <div class="tabs__arrow-item tabs__arrow-next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M7.55469 19.1092C7.55469 18.8818 7.63892 18.6544 7.81581 18.4775L14.3017 11.9832L7.84108 5.51408C7.49572 5.16873 7.49572 4.60437 7.84108 4.25902C8.18643 3.91366 8.75079 3.91366 9.09615 4.25902L16.1885 11.3598C16.5339 11.7052 16.5339 12.2695 16.1885 12.6149L9.0793 19.741C8.73395 20.0863 8.16959 20.0863 7.82423 19.741C7.64734 19.5725 7.56311 19.3367 7.56311 19.1092H7.55469Z" fill="white"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
