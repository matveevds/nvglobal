<?php
/**
 * Реестр CSS-файлов темы (Р-149). Порядок в массиве = порядок подключения; записи — 'base' или '<группа>/<имя>'
 * (css/<группа>/<имя>.css; группы: layout — каркас сайта, blocks — блоки, pages — страницы).
 *
 * Порядок — по исходному положению правил в бывшем css/styles.css, а не «все layout, потом все blocks»: при равной
 * специфичности победитель определялся положением (подвал, модалки и формы стояли между блоками главной и блоками
 * Solutions), и разнесение по группам меняло вид. steps/platform/industries идут в конце, как были подключены после
 * styles.css. Новый блок — файл css/blocks/<имя>.css и строка здесь (в конец блоков, перед pages, если нет причин иначе).
 */

if (!defined('ABSPATH')) {
    exit;
}

return array(
    'base',
    'layout/header',
    'blocks/hero',
    'blocks/page-nav',
    'blocks/about',
    'blocks/results',
    'blocks/video-intro',
    'blocks/solutions',
    'blocks/products',
    'blocks/how',
    'blocks/advantages',
    'blocks/clients',
    'blocks/testimonials',
    'blocks/cases',
    'blocks/pricing',
    'blocks/doc',
    'blocks/news',
    'blocks/offer-card',
    'layout/forms',
    'blocks/contacts',
    'layout/cta-band',
    'layout/footer',
    'layout/cookie',
    'layout/modals',
    'blocks/benefits',
    'blocks/solutions-why',
    'blocks/features',
    'blocks/solutions-products',
    'blocks/flow',
    'blocks/industries-slider',
    'blocks/integration',
    'blocks/solutions-security',
    'blocks/security',
    'blocks/faq',
    'blocks/cta',
    'blocks/main-hero',
    'blocks/kyc-certs',
    'blocks/kyc-risk',
    'blocks/kyc-compliance',
    'blocks/kyc-sea',
    'blocks/kyc-onboarding',
    'blocks/kyc-pricing',
    'blocks/kyc-about',
    'blocks/idv-certs',
    'blocks/idv-checks',
    'blocks/idv-coverage',
    'blocks/idv-accuracy',
    'blocks/idv-benefits',
    'blocks/idv-security',
    'pages/404',
    'pages/demo',
    'layout/light-content',
    'pages/price-matrix',
    'layout/chat-widget',
    'blocks/steps',
    'blocks/platform',
    'blocks/industries',
    'blocks/video',
);
