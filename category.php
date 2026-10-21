<?php
/**
 * Category archive template.
 *
 * Файл: category.php
 */

get_header();

$current_category = get_queried_object();

if (!$current_category || empty($current_category->term_id)) {
    get_footer();
    return;
}
?>

<main>
    <?php get_template_part('template-parts/blog-archive', null, ['context' => 'category']); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>
</main>

<?php
get_footer();
