<?php
/**
 * Template for TOC block.
 */

global $post;

$content = $post ? $post->post_content : '';
$content = strip_shortcodes( $content );
$content = preg_replace( '/<!--.*?-->/', '', $content );

// Ищем заголовки H2, H3, H4
preg_match_all( '/<h([2-4])[^>]*>(.*?)<\/h[2-4]>/', $content, $matches, PREG_SET_ORDER );

// Счётчики уровней
$counters = [
    2 => 0,
    3 => 0,
    4 => 0
];

if ( $matches ) :
?>
<nav class="toc-block">
    <p class="toc-block__title">Content Outline</p>

    <ol class="toc-block__list toc-level-2">
    <?php
    $currentLevel = 2;

    foreach ( $matches as $match ) :
        $level = intval( $match[1] );
        $title = wp_strip_all_tags( $match[2] );
        $anchor = translit_cyr_to_lat( $title );

        // Сброс вложенных счетчиков при переходе на верхний уровень
        if ( $level == 2 ) {
            $counters[2]++;
            $counters[3] = 0;
            $counters[4] = 0;
        } elseif ( $level == 3 ) {
            $counters[3]++;
            $counters[4] = 0;
        } elseif ( $level == 4 ) {
            $counters[4]++;
        }

        // Формируем номер вида 1, 1.2, 1.2.3
        $number = $counters[2];
        if ( $level >= 3 ) $number .= '.' . $counters[3];
        if ( $level == 4 ) $number .= '.' . $counters[4];

        // Открываем вложенные <ol>, если уровень растёт
        while ( $currentLevel < $level ) {
            echo '<ol class="toc-level-' . ($currentLevel + 1) . '">';
            $currentLevel++;
        }

        // Закрываем <ol>, если уровень уменьшается
        while ( $currentLevel > $level ) {
            echo '</ol>';
            $currentLevel--;
        }
        ?>
        <li class="toc-block__item toc-block__item--level-<?php echo $level; ?>">
            <a href="#<?php echo esc_attr( $anchor ); ?>">
                <?php echo esc_html( $number . '. ' . $title ); ?>
            </a>
        </li>

    <?php endforeach; ?>

    <?php
    // Закрываем все открытые списки
    while ( $currentLevel > 2 ) {
        echo '</ol>';
        $currentLevel--;
    }
    ?>
    </ol>
</nav>

<?php else : ?>
<p class="toc-block__empty">Нет заголовков для оглавления.</p>
<?php endif; ?>
