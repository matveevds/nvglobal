<?php
/*
Template Name: Шаблон страницы Блога
Template Post Type: page
*/
get_header(); ?>

<main>
    <?php get_template_part('template-parts/blog-archive', null, ['context' => 'page']); ?>

    <?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>
</main>

<?php
get_footer();
