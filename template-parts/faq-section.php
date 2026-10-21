<?php
/**
 * Секция FAQ (`#faq`). Общая для /solutions/, /kyc/ и /identity-verification/; работает общий initFaq().
 * Аргументы: items — массив вопросов (question, answer[], initial_open); title/description — опционально,
 * по умолчанию прежние тексты KYC/Solutions; section_id — id секции (по умолчанию `faq`).
 * Абзацы ответов проходят wp_kses: разрешены <a href target rel>, <strong>, <em>, <br>; вопросы — только текст.
 */
$nv_solutions_faq = isset($args['items']) ? (array) $args['items'] : array();
$nv_faq_title       = $args['title'] ?? 'Questions we hear most';
$nv_faq_description = $args['description'] ?? 'A focused set of KYC-specific questions. The full library &mdash; including industry- and region-specific topics &mdash; lives in the resource center.';
$nv_faq_id          = sanitize_html_class($args['section_id'] ?? '') ?: 'faq';
$nv_faq_allowed     = array(
    'a'      => array('href' => true, 'target' => true, 'rel' => true),
    'strong' => array(),
    'em'     => array(),
    'br'     => array(),
);
$nv_faq_chevron = '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.3312 6.71213C15.5193 6.45753 15.8732 6.38147 16.1515 6.54612C16.4485 6.72192 16.5469 7.10523 16.3712 7.40224V7.40305H16.3704V7.40386C16.3699 7.40477 16.3689 7.40634 16.368 7.40793C16.3661 7.41115 16.3634 7.41586 16.3598 7.42177C16.3527 7.43363 16.3423 7.4509 16.3289 7.47304C16.3019 7.51765 16.2618 7.58241 16.2109 7.66428C16.1092 7.82798 15.962 8.06088 15.778 8.33974C15.4106 8.89632 14.8939 9.64169 14.2985 10.3897C13.7059 11.1342 13.0199 11.901 12.3144 12.4869C11.6329 13.0529 10.8251 13.5424 9.99998 13.5424C9.17501 13.5424 8.36706 13.0529 7.68553 12.4869C6.98015 11.901 6.29495 11.1342 5.70229 10.3897C5.10675 9.64159 4.58944 8.89638 4.22199 8.33974C4.03792 8.06089 3.89074 7.82797 3.78905 7.66428C3.7382 7.58244 3.69806 7.51763 3.67105 7.47304C3.65766 7.45093 3.64722 7.43362 3.64012 7.42177C3.6366 7.41588 3.63389 7.41114 3.63198 7.40793C3.63105 7.40637 3.63007 7.40476 3.62954 7.40386V7.40305H3.62873V7.40224C3.45305 7.10526 3.55152 6.72194 3.84845 6.54612C4.12678 6.38148 4.48066 6.45752 4.66877 6.71213L4.7062 6.76829C4.7076 6.77064 4.7097 6.77466 4.71271 6.77968C4.71879 6.78982 4.72801 6.80565 4.74038 6.82607C4.76512 6.8669 4.80207 6.92756 4.85024 7.0051C4.94674 7.16042 5.08836 7.38325 5.26528 7.65126C5.61982 8.18833 6.11516 8.90157 6.68049 9.61171C7.24861 10.3253 7.87263 11.0172 8.48387 11.525C9.11912 12.0526 9.63543 12.2924 9.99998 12.2924C10.3648 12.2924 10.8809 12.0526 11.5161 11.525C12.1275 11.0171 12.7521 10.3255 13.3203 9.61171C13.8856 8.90159 14.3802 8.18833 14.7347 7.65126C14.9116 7.38324 15.0532 7.16042 15.1497 7.0051C15.1979 6.92754 15.2349 6.8669 15.2596 6.82607C15.272 6.80565 15.2812 6.78982 15.2873 6.77968C15.2902 6.77468 15.2924 6.77063 15.2938 6.76829L15.3312 6.71213Z" fill="currentColor"/></svg>';
?>
<section class="section faq" id="<?php echo esc_attr($nv_faq_id); ?>">
    <div class="container">
        <div class="faq__wrapper">

            <div class="faq__left">
                <div class="faq__title-block">
                    <div class="section__badge">FAQ</div>
                    <div class="faq__title-text">
                        <h2 class="faq__title"><?php echo esc_html($nv_faq_title); ?></h2>
                        <p class="faq__description"><?php echo wp_kses_post($nv_faq_description); ?></p>
                    </div>
                </div>

                <div class="faq__cta">
                    <p class="faq__cta-text">Didn&rsquo;t find your answer?</p>
                    <button type="button" class="btn btn--gray faq__cta-btn open-callForm2">
                        <span class="btn__text">Talk to an Engineer</span>
                        <span class="btn__icon">
                            <svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="currentColor"/></svg>
                        </span>
                    </button>
                </div>
            </div>

            <div class="faq__right">
                <div class="faq__list">
                    <?php foreach ($nv_solutions_faq as $i => $nv_faq) : ?>
                        <?php
                            /* `answer` — массив абзацев; пустые отбрасываем. */
                            $nv_faq_paragraphs = array_values(array_filter(
                                (array) $nv_faq['answer'],
                                'nv_has_content'
                            ));
                            $nv_has_answer = !empty($nv_faq_paragraphs);
                        ?>
                        <?php
                            $nv_faq_classes = $nv_has_answer ? '' : ' faq__item--static';
                            $nv_faq_open    = $nv_has_answer && !empty($nv_faq['initial_open']);
                            if ($nv_faq_open) {
                                $nv_faq_classes .= ' faq__item--open';
                            }
                        ?>
                        <div class="faq__item<?php echo $nv_faq_classes; ?>">
                            <div class="faq__item-wrapper">
                                <?php if ($nv_has_answer) : ?>
                                    <button type="button"
                                            class="faq__item-question"
                                            id="faq-question-<?php echo (int) $i; ?>"
                                            aria-expanded="<?php echo $nv_faq_open ? 'true' : 'false'; ?>"
                                            aria-controls="faq-answer-<?php echo (int) $i; ?>">
                                        <span class="faq__item-question-text"><?php echo esc_html($nv_faq['question']); ?></span>
                                        <span class="faq__item-question-icon"><?php echo $nv_faq_chevron; ?></span>
                                    </button>
                                    <div class="faq__item-answer"
                                         id="faq-answer-<?php echo (int) $i; ?>"
                                         role="region"
                                         aria-labelledby="faq-question-<?php echo (int) $i; ?>">
                                        <div class="faq__item-answer-text">
                                            <?php foreach ($nv_faq_paragraphs as $nv_paragraph) : ?>
                                            <p><?php echo wp_targeted_link_rel(wp_kses((string) $nv_paragraph, $nv_faq_allowed, array('http', 'https', 'mailto', 'tel'))); ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="faq__item-question">
                                        <span class="faq__item-question-text"><?php echo esc_html($nv_faq['question']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>
