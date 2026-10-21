<?php
/**
 * Стресс-кадры блока «Видео» (`template-parts/video-section`): минимум / норма / максимум.
 * Возвращает slug => array(part, args); подмешивается inc/bloki-stress.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

$nv_vd_poster = array(
    'src'   => 'video-demo-poster',
    'w'     => 1920,
    'h'     => 1080,
    'small' => array('src' => 'video-demo-poster-960', 'w' => 960),
);
$nv_vd_long = 'An unusually long heading that keeps going across several lines to prove that nothing collides, clips or pushes the player out of its frame on any width';

return array(
    /* Минимум: только рамка с постером и кнопкой, без заголовка и подписи. */
    'video-min' => array(
        'part' => 'template-parts/video-section',
        'args' => array(
            'video_id' => 'JY1JWGREje0',
            'poster'   => $nv_vd_poster,
            'title'    => 'NeuroVision KYC demo',
        ),
    ),
    /* Норма: как в макете Figma — рамка с постером; добавлены короткий заголовок и подпись. */
    'video-norm' => array(
        'part' => 'template-parts/video-section',
        'args' => array(
            'section_id' => 'video-norm',
            'video_id'   => 'JY1JWGREje0',
            'poster'     => $nv_vd_poster,
            'title'      => 'See how KYC verification works',
            'heading'    => 'See how KYC verification works',
            'lead'       => 'A two-minute walkthrough of the verification flow.',
            'caption'    => 'Test data only. No real customers are shown.',
            'alt'        => 'NeuroVision KYC verification demo: a customer passes document, selfie and liveness checks',
        ),
    ),
    /* Максимум: длинные заголовок, лид и подпись, постер без уменьшенной версии, длинное имя ролика. */
    'video-max' => array(
        'part' => 'template-parts/video-section',
        'args' => array(
            'section_id' => 'video-max',
            'video_id'   => 'JY1JWGREje0',
            'poster'     => array('src' => 'video-demo-poster', 'w' => 1920, 'h' => 1080),
            'title'      => $nv_vd_long,
            'heading'    => $nv_vd_long,
            'lead'       => 'This paragraph is deliberately long. It carries several sentences so that the head has to grow in height instead of clipping the text: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries and territories and a URL-like string example.com/very/long/path.',
            'caption'    => 'This caption is deliberately long as well, so that it wraps to several lines on narrow screens and still stays inside the container without any horizontal scroll or overlap with the player above it.',
            'alt'        => 'NeuroVision KYC verification demo',
        ),
    ),
);
