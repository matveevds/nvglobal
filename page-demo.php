<?php
/*
Template Name: Demo
Template Post Type: page
NV Page Family: kyc
*/
get_header();

/*
 * Страница Demo — встроенное демо KYC (скрипт демо-сервиса, не iframe).
 * Подключение — по инструкции разработчика демо, вариант для обычного (не SPA) сайта:
 * контейнер `#kyc-demo` уже в HTML, затем classic <script src defer> и вызов setupKYCDemoWidget в onload.
 * `lng` не передаётся: язык берётся из <html lang> (en-US → английский).
 * Теги стоят прямо в шаблоне, а не через wp_enqueue_script: functions.php общий, а так в HTML ровно то, что
 * требует инструкция (defer + onload на самом теге; wp_enqueue_script добавил бы только src/defer, вызов пришлось
 * бы делать отдельным inline-скриптом).
 *
 * У предков контейнера нельзя ставить transform / filter / perspective / backdrop-filter / contain / will-change,
 * overflow:hidden с фиксированной высотой и z-index (иначе fixed-окна демо окажутся под шапкой или обрежутся).
 * Поэтому обёртка `.demo` не использует `.section` (у неё `position:relative; z-index:1`) — см. css/pages/demo.css.
 */
?>
<main>

    <div class="demo" id="demo">
        <div class="container">
            <div class="demo__wrap">
                <div class="demo__head">
                    <div class="section__badge">Demo</div>
                    <h1 class="section__title demo__title">Try the KYC demo</h1>
                </div>

                <div class="demo__widget">
                    <div id="kyc-demo"></div>
                </div>
                <script src="https://demo.nv.global/embed/kyc-demo.js" defer onload="KYCDemoWidget.setupKYCDemoWidget({ mountElementId: 'kyc-demo' })"></script>
            </div>
        </div>
    </div>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

</main>

<?php
get_footer();
