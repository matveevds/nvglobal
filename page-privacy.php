<?php
/*
Template Name: Шаблон страницы PRIVACY POLICY
Template Post Type: page
*/
get_header(); ?>
<?php 
$modified_date = get_the_modified_date('d.m.Y');

?>
<main class="content-page">
    <div class="container small-container">
        <div class="page__wrapper">
            <div class="page__header">
                <h1 class="page__title"><?php echo the_title(); ?></h1>
                <div class="page__last">
                    <div class="page__last-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20.5 12C20.5 8.57312 19.9193 6.52668 18.6963 5.30371C17.4733 4.08074 15.4269 3.5 12 3.5C8.57311 3.5 6.52668 4.08074 5.30371 5.30371C4.08074 6.52668 3.5 8.57311 3.5 12C3.5 15.4269 4.08074 17.4733 5.30371 18.6963C6.52668 19.9193 8.57312 20.5 12 20.5C15.4269 20.5 17.4733 19.9193 18.6963 18.6963C19.9193 17.4733 20.5 15.4269 20.5 12ZM11.249 7.63379C11.2492 7.21974 11.585 6.88387 11.999 6.88379C12.4132 6.88379 12.7489 7.21969 12.749 7.63379V11.5684L15.7744 13.374C16.1301 13.5862 16.2464 14.0466 16.0342 14.4023C15.822 14.758 15.3616 14.8743 15.0059 14.6621L11.6152 12.6396C11.3884 12.5043 11.249 12.2592 11.249 11.9951V7.63379ZM22 12C22 15.5101 21.4246 18.0891 19.7568 19.7568C18.0891 21.4246 15.5101 22 12 22C8.48992 22 5.91094 21.4246 4.24316 19.7568C2.57539 18.0891 2 15.5101 2 12C2 8.48991 2.57539 5.91094 4.24316 4.24316C5.91094 2.57539 8.48991 2 12 2C15.5101 2 18.0891 2.57539 19.7568 4.24316C21.4246 5.91094 22 8.48992 22 12Z" fill="#FBFBFB"/>
                        </svg>
                    </div>
                    <div class="page__last-text">Last updated: <?php echo $modified_date; ?></div>
                </div>
            </div>
            
            <div class="page__content">
                <?php the_content(); ?>
            </div>

        </div>
    </div>
</main>

<?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

<?php
get_footer();
?>