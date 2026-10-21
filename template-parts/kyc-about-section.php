<?php
/**
 * Секция About (`.kyc-about`). Общая для /kyc/ и /identity-verification/ — вынесена из page-kyc.php
 * без изменений разметки (I-01). Статистика/сертификаты одинаковы на обеих страницах (те же цифры
 * и марки в обоих Figma-источниках); различаются только badge, заголовок и лид.
 *
 * Аргументы: badge, title, lead, arrow_icon (html стрелки, nv_contacts_icon('arrow', 24)).
 */
$nv_about_badge = $args['badge'] ?? 'About';
$nv_about_title = $args['title'] ?? 'One identity platform for onboarding, compliance, signing and payments';
// На /identity-verification/ (2620:26881) под заголовком лида нет вовсе — null, не пустая строка по умолчанию.
$nv_about_lead  = array_key_exists('lead', $args) ? $args['lead'] : 'NeuroVision Global builds every engine in-house — document OCR, face recognition, liveness and anti-fraud — and runs them for banks, fintechs, telecoms and government services on four continents. Profitable and founder-owned; no third-party technology under the hood.';
$nv_about_arrow = $args['arrow_icon'] ?? '';
$nv_about_img   = get_template_directory_uri() . '/img/';
?>
<section class="kyc-section kyc-about<?php echo isset($args['modifier']) ? ' ' . esc_attr($args['modifier']) : ''; ?>">
    <div class="container">
        <div class="section__badge"><?php echo esc_html($nv_about_badge); ?></div>
        <div class="kyc-about__head">
            <h2 class="kyc-title"><?php echo esc_html($nv_about_title); ?></h2>
            <?php if ($nv_about_lead) : ?>
            <p class="kyc-lead kyc-lead--md"><?php echo esc_html($nv_about_lead); ?></p>
            <?php endif; ?>
        </div>
        <div class="kyc-about__stats">
            <div class="kyc-card kyc-about__accuracy">
                <p class="kyc-card__text kyc-card__text--md">Our advanced computer vision technology delivers</p>
                <div class="kyc-about__figures">
                    <div class="kyc-about__figure"><span class="kyc-about__value">99.74%</span><span class="kyc-about__caption">facial recognition accuracy</span></div>
                    <span class="kyc-about__divider" aria-hidden="true"></span>
                    <div class="kyc-about__figure"><span class="kyc-about__value">99.85%</span><span class="kyc-about__caption">document recognition accuracy</span></div>
                </div>
            </div>
            <div class="kyc-card kyc-about__documents">
                <p class="kyc-card__text kyc-card__text--md">Our advanced computer vision technology delivers</p>
                <p class="kyc-about__documents-text">over <span>16,000 document</span> types <br class="kyc-about__br">from <span>195+ countries and territories</span></p>
            </div>
        </div>
        <div class="kyc-card kyc-about__certs">
            <div class="kyc-about__certs-text">
                <p class="kyc-about__certs-title">NeuroVision Global operates in compliance with ISO/IEC 27001:2022 and GDPR standards, covering the design, development, and operation of AI-based identity verification systems</p>
                <div class="kyc-about__certs-links">
                    <span class="kyc-tag"><span>ISO/IEC 27001:2022</span><?php echo $nv_about_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                    <span class="kyc-tag"><span>GDPR compliance certification</span><?php echo $nv_about_arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                </div>
            </div>
            <div class="kyc-about__badges">
                <img src="<?php echo esc_url($nv_about_img . 'kyc-cert-iso.webp'); ?>" srcset="<?php echo esc_url($nv_about_img . 'kyc-cert-iso.webp'); ?> 1x, <?php echo esc_url($nv_about_img . 'kyc-cert-iso@2x.webp'); ?> 2x" width="120" height="120" alt="ISO register global certification mark" loading="lazy" decoding="async">
                <img src="<?php echo esc_url($nv_about_img . 'kyc-cert-asib.webp'); ?>" srcset="<?php echo esc_url($nv_about_img . 'kyc-cert-asib.webp'); ?> 1x, <?php echo esc_url($nv_about_img . 'kyc-cert-asib@2x.webp'); ?> 2x" width="94" height="120" alt="ASIB certification mark" loading="lazy" decoding="async">
                <img class="kyc-about__badge-round" src="<?php echo esc_url($nv_about_img . 'kyc-cert-qa.webp'); ?>" srcset="<?php echo esc_url($nv_about_img . 'kyc-cert-qa.webp'); ?> 1x, <?php echo esc_url($nv_about_img . 'kyc-cert-qa@2x.webp'); ?> 2x" width="120" height="120" alt="QA Compliance Assessment certification mark" loading="lazy" decoding="async">
            </div>
        </div>
    </div>
</section>
