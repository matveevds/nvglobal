<?php
/**
 * Template for code block.
 */
$html = get_field('code_content');

if ($html) {
    $text = wp_strip_all_tags($html);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace("/\r\n|\r/", "\n", $text);   
}
?>
<div class="code">
    <div class="code__wrapper">
        <div class="code__top">
            <div class="code__top-title">Код</div>
            <div class="code__top-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M6.85694 8.78516L3 11.9989L6.85694 15.2137" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.1426 8.78516L20.9995 11.9989L17.1426 15.2137" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.571 4.92969L9.42773 19.0731" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="code__line"></div>
        <div class="code__content">
            <div class="code__content-lang"><?php echo get_field('code_lang'); ?></div>
            <div class="code__content-code"><?php echo '<pre class="code__pre"><code class="code__code">' . esc_html($text) . '</code></pre>'; ?></div>
        </div>
    </div>
</div>
