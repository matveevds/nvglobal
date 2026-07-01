<?php
get_header(); ?>
<?php 

?>
<main class="content-page page-404">
    <section class="section section-404">
        <div class="container">
            <div class="section-404__wrapper">
                <div class="section-404__content">
                    <div class="section-404__title-block">
                        <h1 class="section-404__title section__title">Oooops...</h1>
                        <p class="section-404__description">We certainly have advanced computer vision technology, but even it cannot see such a page</p>
                    </div>
                    <div class="section-404__action">
                        <a href="<?php echo home_url(); ?>" class="btn-hero">
                            <span class="btn__text btn__text-hero">Go to main page</span>
                            <div class="btn__icon btn__icon-arrow"></div>
                        </a>
                    </div>
                    
                </div>
                <div class="section-404__image">
                    <?php echo td_image(477, ['loading' => 'eager']); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>