<?php
get_header(); ?>
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
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-hero">
                            <span class="btn__text btn__text-hero">Go to main page</span>
                            <span class="btn__icon btn__icon-arrow">
                                <svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 12C17.9951 11.4739 17.7832 10.9709 17.41 10.6L13.12 6.3C12.9326 6.11375 12.6792 6.00921 12.415 6.00921C12.1508 6.00921 11.8974 6.11375 11.71 6.3C11.6163 6.39296 11.5419 6.50356 11.4911 6.62542C11.4403 6.74728 11.4142 6.87799 11.4142 7.01C11.4142 7.14201 11.4403 7.27272 11.4911 7.39458C11.5419 7.51644 11.6163 7.62704 11.71 7.72L15 11H5C4.73478 11 4.48043 11.1054 4.29289 11.2929C4.10536 11.4804 4 11.7348 4 12C4 12.2652 4.10536 12.5196 4.29289 12.7071C4.48043 12.8946 4.73478 13 5 13H15L11.71 16.29C11.5217 16.477 11.4154 16.7311 11.4144 16.9965C11.4135 17.2618 11.518 17.5167 11.705 17.705C11.892 17.8933 12.1461 17.9996 12.4115 18.0006C12.6768 18.0015 12.9317 17.897 13.12 17.71L17.41 13.41C17.7856 13.0366 17.9978 12.5296 18 12Z" fill="currentColor"/></svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="section-404__image" aria-hidden="true">
                    <img class="section-404__shadow" src="<?php echo esc_url(get_template_directory_uri() . '/img/404-shadow.svg'); ?>" alt="" width="730" height="89">
                    <img class="section-404__picture" src="<?php echo esc_url(get_template_directory_uri() . '/img/404-illustration.webp'); ?>" alt="" width="2400" height="1263" fetchpriority="high" decoding="async">
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
