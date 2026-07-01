<?php
/*
Template Name: KYC/AML Pricing Matrix
Template Post Type: page
*/
get_header(); ?>

<section class="intro">
    <div class="container">
        <div class="intro__wrapper">
            <div class="intro__row">
                <div class="intro__col intro__col--content">
                    <div class="intro__content">
                       <div class="intro__breadcrumbs">
                            <div class="intro__breadcrumbs-item">
                                <a href="/" class="intro__breadcrumbs-link">Home</a>
                            </div>
                            <div class="intro__breadcrumbs-sep">/</div>
                            <div class="intro__breadcrumbs-item">
                                <p class="intro__breadcrumbs-current">Pricing Matrix</p>
                            </div>
                       </div>

                       <div class="intro__info">
                            <h1 class="intro__title">Unified Pricing Matrix for&nbsp;KYC/AML&nbsp;Services</h1>
                            <p class="intro__description">Smooth per-check pricing plus additional modules and database checks. Choose a fixed price or cost-effective package rates.</p>
                       </div>

                       <div class="intro__actions-block">
                            <button class="btn-hero open-callForm2">
                                <span class="btn__text btn__text-hero">Request Demo</span>
                                <div class="btn__icon btn__icon-arrow"></div>
                            </button>
                            <hr>
                            <div class="intro__actions">

                                <button class="btn btn--gray btn-with-lottie-arrow-orange open-callForm">
                                    <span class="btn__text">Start Free Trial</span>
                                    <span class="btn__icon lottie-container-arrow-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                        </svg>
                                    </span>
                                </button>

                                <a href="#packages" class="btn btn--gray btn-with-lottie-arrow-orange">
                                    <span class="btn__text">View Rates</span>
                                    <span class="btn__icon lottie-container-arrow-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M13.0391 5.34572C13.2356 4.9811 13.691 4.8445 14.0557 5.04104H14.0566L14.0576 5.04201C14.0586 5.04254 14.0599 5.0431 14.0615 5.04397C14.065 5.04586 14.0699 5.04934 14.0762 5.05276C14.0888 5.05967 14.1076 5.06914 14.1309 5.08205C14.1779 5.10811 14.2463 5.14631 14.332 5.19533C14.5035 5.29333 14.7468 5.43607 15.0381 5.61526C15.6193 5.97277 16.3988 6.48141 17.1816 7.08205C17.96 7.67929 18.766 8.38638 19.3848 9.14358C19.989 9.88309 20.5 10.7738 20.5 11.7246L20.4941 11.9014C20.436 12.7859 19.9524 13.6128 19.3857 14.3067C18.767 15.0642 17.96 15.7707 17.1816 16.3682C16.3987 16.9691 15.6193 17.4783 15.0381 17.836C14.7467 18.0152 14.5035 18.1579 14.332 18.2559C14.2463 18.3049 14.1779 18.3431 14.1309 18.3692C14.1079 18.3819 14.0898 18.3916 14.0771 18.3985C14.0708 18.4019 14.0651 18.4053 14.0615 18.4072C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6067 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2864 13.3438 17.0899C13.3442 17.0896 13.3455 17.0895 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.083C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0336 13.5075 16.9985 13.5869 16.9531C13.7463 16.862 13.9761 16.7283 14.252 16.5586C14.805 16.2183 15.5381 15.7387 16.2676 15.1787C17.0016 14.6153 17.7081 13.9887 18.2236 13.3574C18.4832 13.0396 18.6739 12.7444 18.8018 12.4756H4.75C4.33579 12.4756 4 12.1398 4 11.7256C4.00002 11.3114 4.3358 10.9756 4.75 10.9756H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46187 17.0026 8.8347 16.2686 8.27151C15.539 7.71171 14.8051 7.23283 14.252 6.8926C13.9764 6.72311 13.7473 6.58918 13.5879 6.49807C13.5083 6.4526 13.4459 6.41761 13.4043 6.39455C13.3836 6.38307 13.3676 6.37472 13.3574 6.36916C13.3524 6.3664 13.349 6.36357 13.3467 6.36233C13.3455 6.36171 13.3442 6.36158 13.3438 6.36135C12.9794 6.16488 12.8429 5.71023 13.0391 5.34572Z" fill="#FBFBFB"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                       </div>
                       
                    </div>                    
                </div>
                <div class="intro__col intro__col--image" aria-hidden="true">
                    <?php echo td_image(965, ['loading' => 'eager']); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$calculator_format_price = function ($value, $fallback) {
    $value = is_string($value) ? str_replace(',', '.', $value) : $value;
    $value = is_numeric($value) ? (float) $value : $fallback;
    $price = rtrim(rtrim(number_format($value, 3, '.', ''), '0'), '.');

    if (strpos($price, '.') !== false && strlen(substr(strrchr($price, '.'), 1)) < 2) {
        $price .= '0';
    }

    return $price;
};

$calculator_doc_price = $calculator_format_price(get_field('doc_price'), 0.13);
$calculator_international_price = $calculator_format_price(get_field('international_price'), 0.4);
?>

<section class="section calculator" id="kyc-calculator" data-doc-price="<?php echo esc_attr($calculator_doc_price); ?>" data-international-price="<?php echo esc_attr($calculator_international_price); ?>">
    <div class="container">
        <div class="calculator__wrapper">
            <div class="section__title-block">
                <h2 class="section__title">KYC Cost Calculator</h2>
                <p class="section__description">Smooth price per check plus additional modules and database checks</p>
            </div>

            <div class="calculator__content">
                <div class="calculator__spoilers">

                    <div class="calculator__spoiler calculator__spoiler--open calculator__spoiler--base">
                        <div class="calculator__spoiler-header">
                            <div class="calculator__spoiler-title">Base Package</div>
                            <div class="calculator__spoiler-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M15.3316 6.71409C15.5197 6.45948 15.8735 6.38343 16.1519 6.54807C16.4488 6.72388 16.5473 7.10719 16.3716 7.40419V7.405H16.3708V7.40582C16.3703 7.40673 16.3693 7.4083 16.3684 7.40989C16.3664 7.41311 16.3638 7.41781 16.3602 7.42372C16.3531 7.43559 16.3427 7.45286 16.3293 7.47499C16.3023 7.5196 16.2621 7.58437 16.2113 7.66623C16.1096 7.82993 15.9624 8.06283 15.7783 8.34169C15.411 8.89827 14.8943 9.64364 14.2989 10.3917C13.7062 11.1361 13.0202 11.9029 12.3148 12.4888C11.6332 13.0549 10.8254 13.5443 10.0004 13.5443C9.17537 13.5443 8.36742 13.0549 7.6859 12.4888C6.98052 11.9029 6.29532 11.1361 5.70266 10.3917C5.10712 9.64355 4.58981 8.89833 4.22236 8.34169C4.03829 8.06285 3.89111 7.82992 3.78941 7.66623C3.73857 7.5844 3.69842 7.51959 3.67141 7.47499C3.65802 7.45289 3.64758 7.43558 3.64049 7.42372C3.63696 7.41784 3.63426 7.41309 3.63235 7.40989C3.63142 7.40832 3.63044 7.40672 3.62991 7.40582V7.405H3.62909V7.40419C3.45342 7.10721 3.55189 6.7239 3.84882 6.54807C4.12715 6.38343 4.48102 6.45948 4.66913 6.71409L4.70657 6.77024C4.70797 6.77259 4.71007 6.77661 4.71308 6.78163C4.71915 6.79178 4.72838 6.8076 4.74075 6.82802C4.76549 6.86886 4.80243 6.92951 4.85061 7.00705C4.94711 7.16237 5.08873 7.3852 5.26565 7.65321C5.62018 8.19028 6.11553 8.90353 6.68085 9.61366C7.24898 10.3273 7.873 11.0192 8.48424 11.5269C9.11948 12.0546 9.63579 12.2943 10.0004 12.2943C10.3652 12.2943 10.8812 12.0545 11.5165 11.5269C12.1279 11.0191 12.7525 10.3275 13.3207 9.61366C13.8859 8.90354 14.3806 8.19028 14.7351 7.65321C14.9119 7.3852 15.0536 7.16237 15.1501 7.00705C15.1983 6.92949 15.2352 6.86885 15.26 6.82802C15.2723 6.8076 15.2816 6.79178 15.2876 6.78163C15.2906 6.77664 15.2927 6.77258 15.2941 6.77024L15.3316 6.71409Z" fill="#FBFBFB"/>
                                </svg>
                            </div>
                        </div>

                        <div class="calculator__spoiler-content">
                            <div class="calculator__spoiler-item">
                                <div class="calculator__spoiler-item-title">Base Package</div>
                                <div class="calculator__spoiler-item-actions" id="calculator-package">
                                    <button class="calculator__spoiler-btn active" type="button" data-pkg="DOCUMENT">DOCUMENT — Document Recognition</button>
                                    <button class="calculator__spoiler-btn" type="button" data-pkg="BASIC">BASIC — Document + Selfie / Liveness</button>
                                </div>
                            </div>

                            <div class="calculator__spoiler-item">
                                <div class="calculator__spoiler-item-title">Document Type in Package</div>
                                <div class="calculator__spoiler-item-subtitle">Multiple types are possible: the client presents one, the price remains the same</div>

                                <div class="calculator__spoiler-item-actions" id="calculator-document-type">
                                    <button class="calculator__spoiler-btn small active" type="button" data-dt="passport">Passport</button>
                                    <button class="calculator__spoiler-btn small" type="button" data-dt="id">ID Card</button>
                                    <button class="calculator__spoiler-btn small" type="button" data-dt="driver">Driver’s License</button>
                                </div>
                            </div>

                            <div class="calculator__spoiler-item calculator__spoiler-item--range">
                                <div class="calculator__spoiler-item-title-block">
                                    <div class="calculator__spoiler-item-top">
                                        <div class="calculator__spoiler-item-title">Annual Check Volume</div>
                                        <div class="calculator__spoiler-item-subtitle">Enter the desired check volume or set the number using the slider below</div>
                                        <div class="calculator__spoiler-item-title-input">
                                            <button class="calculator-volume-step calculator-volume-step--minus" type="button" aria-label="Decrease volume" data-volume-step="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.16669 10.0013C4.16669 9.54105 4.53979 9.16797 5.00002 9.16797H15C15.4603 9.16797 15.8334 9.54105 15.8334 10.0013C15.8334 10.4616 15.4603 10.8346 15 10.8346H5.00002C4.53979 10.8346 4.16669 10.4616 4.16669 10.0013Z" fill="#2E2E2E" fill-opacity="0.5"/>
                                                </svg>
                                            </button>
                                            <input class="calculator-volume-number" type="text" id="calculator-volume-number" min="0" step="1000" value="10,000" inputmode="numeric" autocomplete="off">
                                            <button class="calculator-volume-step calculator-volume-step--plus" type="button" aria-label="Increase volume" data-volume-step="1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 4.16797C10.4603 4.16797 10.8334 4.54107 10.8334 5.0013V9.16797H15C15.4603 9.16797 15.8334 9.54105 15.8334 10.0013C15.8334 10.4616 15.4603 10.8346 15 10.8346H10.8334V15.0013C10.8334 15.4616 10.4603 15.8346 10 15.8346C9.53977 15.8346 9.16669 15.4616 9.16669 15.0013V10.8346H5.00002C4.53979 10.8346 4.16669 10.4616 4.16669 10.0013C4.16669 9.54105 4.53979 9.16797 5.00002 9.16797H9.16669V5.0013C9.16669 4.54107 9.53977 4.16797 10 4.16797Z" fill="#2E2E2E" fill-opacity="0.5"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="calculator__spoiler-item-actions">
                                    <div class="calculator-volume-range-wrap">
                                        <output class="calculator-volume-range-value" id="calculator-volume-range-value" for="calculator-volume-range">10 000</output>
                                        <input class="calculator-volume-range" type="range" id="calculator-volume-range" min="0" max="100" step="1" value="0">
                                        <div class="calculator-volume-range-limits">
                                            <span>10,000</span>
                                            <span>50,000</span>
                                            <span>100,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="calculator__spoiler calculator__spoiler--additional">
                        <div class="calculator__spoiler-header">
                            <div class="calculator__spoiler-title">Additional modules and checks</div>
                            <div class="calculator__spoiler-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M15.3316 6.71409C15.5197 6.45948 15.8735 6.38343 16.1519 6.54807C16.4488 6.72388 16.5473 7.10719 16.3716 7.40419V7.405H16.3708V7.40582C16.3703 7.40673 16.3693 7.4083 16.3684 7.40989C16.3664 7.41311 16.3638 7.41781 16.3602 7.42372C16.3531 7.43559 16.3427 7.45286 16.3293 7.47499C16.3023 7.5196 16.2621 7.58437 16.2113 7.66623C16.1096 7.82993 15.9624 8.06283 15.7783 8.34169C15.411 8.89827 14.8943 9.64364 14.2989 10.3917C13.7062 11.1361 13.0202 11.9029 12.3148 12.4888C11.6332 13.0549 10.8254 13.5443 10.0004 13.5443C9.17537 13.5443 8.36742 13.0549 7.6859 12.4888C6.98052 11.9029 6.29532 11.1361 5.70266 10.3917C5.10712 9.64355 4.58981 8.89833 4.22236 8.34169C4.03829 8.06285 3.89111 7.82992 3.78941 7.66623C3.73857 7.5844 3.69842 7.51959 3.67141 7.47499C3.65802 7.45289 3.64758 7.43558 3.64049 7.42372C3.63696 7.41784 3.63426 7.41309 3.63235 7.40989C3.63142 7.40832 3.63044 7.40672 3.62991 7.40582V7.405H3.62909V7.40419C3.45342 7.10721 3.55189 6.7239 3.84882 6.54807C4.12715 6.38343 4.48102 6.45948 4.66913 6.71409L4.70657 6.77024C4.70797 6.77259 4.71007 6.77661 4.71308 6.78163C4.71915 6.79178 4.72838 6.8076 4.74075 6.82802C4.76549 6.86886 4.80243 6.92951 4.85061 7.00705C4.94711 7.16237 5.08873 7.3852 5.26565 7.65321C5.62018 8.19028 6.11553 8.90353 6.68085 9.61366C7.24898 10.3273 7.873 11.0192 8.48424 11.5269C9.11948 12.0546 9.63579 12.2943 10.0004 12.2943C10.3652 12.2943 10.8812 12.0545 11.5165 11.5269C12.1279 11.0191 12.7525 10.3275 13.3207 9.61366C13.8859 8.90354 14.3806 8.19028 14.7351 7.65321C14.9119 7.3852 15.0536 7.16237 15.1501 7.00705C15.1983 6.92949 15.2352 6.86885 15.26 6.82802C15.2723 6.8076 15.2816 6.79178 15.2876 6.78163C15.2906 6.77664 15.2927 6.77258 15.2941 6.77024L15.3316 6.71409Z" fill="#FBFBFB"/>
                                </svg>
                            </div>
                        </div>
                        
                        
                        <div class="calculator__spoiler-content">
                            <div class="calculator__spoiler-section">
                                <div class="calculator__spoiler-content-subtitle">
                                    <p>Additional Documents</p>
                                    <span id="calculator-doc-unit-price">$<?php echo esc_html($calculator_doc_price); ?> per document</span>
                                </div>

                                <div class="calculator__spoiler-content-text">
                                    <p>Each document is priced based on the recognition cost, with the same volume curve. Both sides of a driver’s license are considered separate documents.</p>
                                </div>

                                <div class="calculator__spoiler-columns">
                                    <div class="calculator__spoiler-content-col">

                                        <label class="calculator__checkbox">
                                            <input type="checkbox" name="extra_documents[]" value="id_front" data-extra-doc="id_front">
                                            <span class="calculator__checkbox-mark"></span>
                                            <span class="calculator__checkbox-text">ID Card</span>
                                        </label>

                                        <label class="calculator__checkbox">
                                            <input type="checkbox" name="extra_documents[]" value="driver_front" data-extra-doc="driver_front">
                                            <span class="calculator__checkbox-mark"></span>
                                            <span class="calculator__checkbox-text">Driver’s License</span>
                                        </label>

                                        <label class="calculator__checkbox">
                                            <input type="checkbox" name="extra_documents[]" value="residence_permit" data-extra-doc="residence_permit">
                                            <span class="calculator__checkbox-mark"></span>
                                            <span class="calculator__checkbox-text">Residence</span>
                                        </label>                                       

                                    </div>

                                    <div class="calculator__spoiler-content-col">
                                        
                                        <label class="calculator__checkbox">
                                            <input type="checkbox" name="extra_documents[]" value="visa" data-extra-doc="visa">
                                            <span class="calculator__checkbox-mark"></span>
                                            <span class="calculator__checkbox-text">Visa</span>
                                        </label>

                                        <div class="calculator__checkbox-row">
                                            <label class="calculator__checkbox">
                                                <input type="checkbox" name="extra_documents[]" value="address_proof" data-extra-doc="address_proof">
                                                <span class="calculator__checkbox-mark"></span>
                                                <span class="calculator__checkbox-text">Proof of Address</span>
                                            </label>
                                            <span class="calculator__checkbox-info" tabindex="0" role="button" aria-label="More information about Proof of Address">
                                                <svg class="calculator__checkbox-info-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.75C7.44329 3.75 3.75 7.44329 3.75 12C3.75 16.5558 7.44335 20.25 12 20.25C16.5567 20.25 20.25 16.5558 20.25 12C20.25 7.44329 16.5567 3.75 12 3.75ZM2.25 12C2.25 6.61487 6.61487 2.25 12 2.25C17.3851 2.25 21.75 6.61487 21.75 12C21.75 17.3841 17.3852 21.75 12 21.75C6.61481 21.75 2.25 17.3841 2.25 12Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7.54102C12.4142 7.54102 12.75 7.8768 12.75 8.29102V8.35426C12.75 8.76847 12.4142 9.10426 12 9.10426C11.5858 9.10426 11.25 8.76847 11.25 8.35426V8.29102C11.25 7.8768 11.5858 7.54102 12 7.54102ZM12.0057 10.6436C12.4199 10.6436 12.7557 10.9794 12.7557 11.3936V15.6932C12.7557 16.1074 12.4199 16.4432 12.0057 16.4432C11.5915 16.4432 11.2557 16.1074 11.2557 15.6932V11.3936C11.2557 10.9794 11.5915 10.6436 12.0057 10.6436Z" fill="#FBFBFB" fill-opacity="0.5"/>
                                                </svg>
                                                <span class="calculator__checkbox-tooltip" role="tooltip"><strong>Proof of address</strong> — a document confirming your address: a bank statement, a utility bill (electricity, gas, or water), a lease agreement, a tax notice, or an internet or phone bill.</span>
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                <div class="calculator__spoiler-content-botom">
                                    <div class="calculator__spoiler-content-botom-title">Total for additional documents</div>
                                    <div class="calculator__spoiler-content-botom-sum" id="calculator-extra-docs-total">$0.00</div>
                                </div>
                            </div>

                            <div class="calculator__spoiler-section calculator__spoiler-section--international">
                                <div class="calculator__spoiler-content-subtitle">
                                    <p>International Screening</p>
                                    <span>$<?php echo esc_html($calculator_international_price); ?> per check</span>
                                </div>

                                <div class="calculator__spoiler-content-col">
                                        <label class="calculator__checkbox">
                                            <input type="checkbox" name="aml_international[]" value="international_compliance_screening" id="calculator-international-screening">
                                            <span class="calculator__checkbox-mark"></span>
                                            <span class="calculator__checkbox-text">International Compliance Screening: Sanctions, PEPs, 50+ Countries</span>
                                        </label>
                                </div>

                                <div class="calculator__spoiler-content-botom">
                                    <div class="calculator__spoiler-content-botom-title">Total for International Screening</div>
                                    <div class="calculator__spoiler-content-botom-sum" id="calculator-international-total">$0.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="calculator__result" id="calculator-result">
                    <div class="calculator__result-default">
                        <div class="calculator__result-content">
                            <div class="calculator__result-tarif">
                                <div class="calculator__result-text">Selected Package</div>
                                <div class="calculator__result-package">
                                    <div class="calculator__result-subtitle" id="calculator-result-package">DOCUMENT</div>
                                    <div class="calculator__result-package-description" id="calculator-result-package-description">Document Recognition</div>
                                </div>
                            </div>

                            <div class="calculator__result-paket">
                                <div class="calculator__result-item">
                                    <div class="calculator__result-name">Package</div>
                                    <div class="calculator__result-value" id="calculator-result-package-price">$0.24</div>
                                </div>

                                <div class="calculator__result-item">
                                    <div class="calculator__result-name" id="calculator-result-docs-label">Documents</div>
                                    <div class="calculator__result-value" id="calculator-result-docs-price">+$0.00</div>
                                </div>

                                <div class="calculator__result-item">
                                    <div class="calculator__result-name" id="calculator-result-aml-label">International Screening</div>
                                    <div class="calculator__result-value" id="calculator-result-aml-price">+$0.40</div>
                                </div>
                            </div>

                            <hr class="calculator__result-line">

                            <div class="calculator__result-sum">
                                <div class="calculator__result-sum-title">Price per Check</div>
                                <div class="calculator__result-sum-value" id="calculator-result-price-per-check">$0.24</div>
                            </div>

                            <hr class="calculator__result-line">

                            <div class="calculator__result-itog">
                                <div class="calculator__result-itog-subtitle">Annual Package Cost</div>
                                <div class="calculator__result-itog-summa" id="calculator-result-year-total">$2,400</div>
                                <div class="calculator__result-itog-info" id="calculator-result-year-info">10,000 checks × $0.24</div>
                            </div>
                        </div>

                        <div class="calculator__result-action">
                            <button class="btn-hero open-callForm2" data-calculator-trigger data-modal-service="Get KYC Cost Estimate" data-modal-title="KYC Cost Estimate" data-modal-btn="Get Package">
                                <span class="btn__text btn__text-hero">Get Package</span>
                                <div class="btn__icon btn__icon-arrow"></div>
                            </button>
                        </div>
                    </div>

                    <div class="calculator__result-request">
                        <div class="calculator__result-request-card">
                            <div class="calculator__result-request-image">
                                <?php echo td_image(966, [
                                    'class'   => 'calculator__result-request-maskot',
                                    'loading' => 'eager',
                                ]); ?>
                            </div>
                            <div class="calculator__result-request-title">Quantity &gt; 100,000 —<br>Price upon request</div>
                            <div class="calculator__result-request-text">Please contact a sales representative<br>for large orders.</div>
                            <button class="btn-hero open-callForm2">
                                <span class="btn__text btn__text-hero">Talk to an Engineer</span>
                                <div class="btn__icon btn__icon-arrow"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section overview">
    <div class="container">
        <div class="overview__wrapper">
            <div class="overview__title-block">
                <h2 class="section__title">What is 1 KYC Check</h2>
            </div>
            <div class="overview__content">
                <div class="overview__card">
                    <div class="overview__card-title">1 check =</div>
                    <div class="overview__card-info">
                        <div class="overview__card-descriptin">1 KYC session including all scenario steps (document, selfie, liveness, etc.).</div>
                        <hr>
                        <div class="overview__card-text">The scenario is configured in the KYC editor: the client selects steps, document types, countries, anti-fraud checks, and liveness mode.</div>
                    </div>
                </div>
                <div class="overview__info">
                    <div class="overview__info-card">
                        <div class="overview__info-content">
                            <div class="overview__info-text">Each step allows</div>
                            <div class="overview__info-title">up to 6 free photo attempts</div>
                        </div>
                        <div class="overview__info-image" aria-hidden="true">
                            <?php echo td_image(967, [
                                'class'   => 'overview__info-maskot',
                                'loading' => 'lazy',
                            ]); ?>
                        </div>
                    </div>                    
                    <div class="overview__info-description">After all attempts are used the session is blocked.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$packages = [
    'document' => [
        'title'         => 'DOCUMENT',
        'subtitle'      => 'Document Recognition + Anti-Fraud',
        'subtitle_html' => 'Document Recognition<br>+ Anti-Fraud',
        'mobile_intro'  => '',
        'price'         => get_field('document-price'),
    ],
    'basic' => [
        'title'         => 'BASIC',
        'subtitle'      => 'DOCUMENT + Selfie or Liveness',
        'subtitle_html' => '<span>DOCUMENT</span><br> + Selfie or Liveness',
        'mobile_intro'  => 'Everything in DOCUMENT plus Selfie or Liveness',
        'price'         => get_field('basic-price'),
    ],
    'advanced' => [
        'title'         => 'ADVANCED *',
        'subtitle'      => 'BASIC + Compliance',
        'subtitle_html' => '<span>BASIC</span> + Compliance<br> (Database Checks)',
        'mobile_intro'  => 'Everything in DOCUMENT and BASIC plus Compliance Database Checks',
        'price'         => get_field('advanced-price'),
    ],
];

$groups = [];

if (have_rows('tarif-group')) {
    while (have_rows('tarif-group')) {
        the_row();

        $group = [
            'title'       => get_sub_field('tarif-group-name'),
            'description' => get_sub_field('tarif-group-description'),
            'services'    => [],
        ];

        if (have_rows('service-list')) {
            while (have_rows('service-list')) {
                the_row();

                $service_tariffs = get_sub_field('service-tariffs');

                if (!is_array($service_tariffs)) {
                    $service_tariffs = $service_tariffs ? [$service_tariffs] : [];
                }

                $group['services'][] = [
                    'name'        => get_sub_field('service-name'),
                    'description' => get_sub_field('service-description'),
                    'subgroup'    => get_sub_field('service-subgroup-name'),
                    'tariffs'     => $service_tariffs,
                ];
            }
        }

        $groups[] = $group;
    }
}
?>

<section class="section packages" id="packages">
    <div class="container">
        <div class="packages__wrapper">
            <div class="packages__title-block">
                <h2 class="section__title">Service Packages</h2>
            </div>

            <div class="packages__table packages__table--desktop">

                <div class="packages__row packages__row--head">
                    <div class="packages__cell packages__cell--label">
                        <div class="packages__names-price">Price</div>
                    </div>

                    <div class="packages__cell packages__cell--package packages__cell--document">
                        <div class="packages__cell-wraper">
                            <div class="packages__column-title">
                                DOCUMENT
                            </div>

                            <div class="packages__column-subtitle">
                                Document Recognition<br>+ Anti-Fraud
                            </div>

                            <?php if (!empty($packages['document']['price'])) : ?>
                                <div class="packages__column-price">
                                    <?php echo esc_html($packages['document']['price']); ?>
                                </div>
                            <?php endif; ?>
                        </div>                        
                    </div>

                    <div class="packages__cell packages__cell--package packages__cell--basic">
                        <div class="packages__cell-wraper">
                            <div class="packages__column-title">
                                BASIC
                            </div>

                            <div class="packages__column-subtitle">
                                <span>DOCUMENT</span><br> + Selfie or Liveness
                            </div>

                            <?php if (!empty($packages['basic']['price'])) : ?>
                                <div class="packages__column-price">
                                    <?php echo esc_html($packages['basic']['price']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="packages__cell packages__cell--package packages__cell--advanced">
                        <div class="packages__cell-wraper">
                            <div class="packages__column-title">
                                ADVANCED *
                            </div>

                            <div class="packages__column-subtitle">
                                <span>BASIC</span> + Compliance<br> (Database Checks)
                            </div>

                            <?php if (!empty($packages['advanced']['price'])) : ?>
                                <div class="packages__column-price">
                                    <?php echo esc_html($packages['advanced']['price']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <?php foreach ($groups as $group) : ?>
                    <div class="packages__group packages__row">
                        <div class="packages__cell packages__cell--label packages__group-title">
                            <span class="packages__group-name">
                                <?php echo esc_html($group['title']); ?>
                                <?php if (!empty($group['description'])) : ?>
                                    <span class="packages__icon packages__service-icon packages__group-icon">
                                        <span class="packages__service-description">
                                            <?php echo wp_kses_post($group['description']); ?>
                                        </span>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="packages__cell packages__cell--empty packages__cell--document"></div>
                        <div class="packages__cell packages__cell--empty packages__cell--basic"></div>
                        <div class="packages__cell packages__cell--empty packages__cell--advanced"></div>
                    </div>

                    <?php $current_subgroup = ''; ?>
                    <?php foreach ($group['services'] as $service) : ?>
                        <?php if (!empty($service['subgroup']) && $service['subgroup'] !== $current_subgroup) : ?>
                            <?php $current_subgroup = $service['subgroup']; ?>
                            <div class="packages__subgroup packages__row">
                                <div class="packages__cell packages__cell--label packages__group-title packages__subgroup-title">
                                    <?php echo wp_kses_post($current_subgroup); ?>
                                </div>
                                <div class="packages__cell packages__cell--empty packages__cell--document"></div>
                                <div class="packages__cell packages__cell--empty packages__cell--basic"></div>
                                <div class="packages__cell packages__cell--empty packages__cell--advanced"></div>
                            </div>
                        <?php endif; ?>

                        <div class="packages__row packages__row--service">
                            <div class="packages__cell packages__cell--service">
                                <div class="packages__service-name">
                                    <?php echo esc_html($service['name']); ?>
                                    <?php if (!empty($service['description'])) : ?>
                                        <span class="packages__icon packages__service-icon">
                                            <span class="packages__service-description">
                                                <?php echo wp_kses_post($service['description']); ?>
                                            </span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php foreach ($packages as $package_key => $package) : ?>
                                <?php $is_included = in_array($package_key, $service['tariffs'], true); ?>

                                <div class="packages__cell packages__cell--value packages__cell--<?php echo esc_attr($package_key); ?>">
                                    <?php if ($is_included) : ?>
                                        <span class="packages__icon packages__icon--check"></span>
                                    <?php else : ?>
                                        <span class="packages__icon packages__icon--cross"></span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>

            </div>

            <div class="packages__slider packages__table-mobile swiper">
                <div class="packages__slider-wrapper swiper-wrapper">
                    <div class="packages__slider-arrows">
                        <div class="packages__slider-arrow packages__slider-arrow-prev packages__slider--disable">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6.67643 3.70588C6.9105 3.60879 7.18509 3.70328 7.30794 3.93114C7.4387 4.17414 7.34775 4.47724 7.10482 4.60822C7.10453 4.60838 7.10363 4.60846 7.10286 4.60887C7.10134 4.6097 7.09903 4.61161 7.0957 4.61343C7.08892 4.61714 7.07822 4.62272 7.06445 4.63036C7.03675 4.64572 6.99563 4.66911 6.94271 4.69937C6.83644 4.76013 6.68321 4.84926 6.49935 4.96239C6.13066 5.18925 5.64191 5.50904 5.1556 5.88231C4.66627 6.25793 4.19527 6.67566 3.85156 7.0965C3.67856 7.30835 3.55137 7.50523 3.46615 7.68439H12.834C13.1101 7.68439 13.3339 7.90829 13.334 8.18439C13.334 8.46054 13.1101 8.68439 12.834 8.68439H3.46549C3.5507 8.86381 3.67806 9.06125 3.85156 9.27359C4.19523 9.69413 4.66568 10.1117 5.15495 10.4871C5.64134 10.8603 6.13059 11.1796 6.49935 11.4064C6.68304 11.5194 6.83579 11.6087 6.94206 11.6694C6.99505 11.6997 7.03672 11.7231 7.06445 11.7384C7.07832 11.7461 7.08893 11.7523 7.0957 11.756C7.09896 11.7578 7.10136 11.7591 7.10286 11.7599L7.10482 11.7606L7.14844 11.7873C7.35826 11.9294 7.43078 12.2104 7.30794 12.4383C7.18508 12.6662 6.91051 12.76 6.67643 12.6629L6.63021 12.6408H6.62956L6.62891 12.6401C6.62826 12.6398 6.62736 12.6394 6.6263 12.6388C6.62402 12.6376 6.6206 12.6358 6.61654 12.6336C6.60809 12.629 6.59564 12.6221 6.58008 12.6134C6.54873 12.5961 6.50313 12.5706 6.44596 12.5379C6.33168 12.4726 6.16944 12.3774 5.97526 12.258C5.58779 12.0196 5.06808 11.6805 4.54622 11.2801C4.02733 10.8819 3.48995 10.4105 3.07747 9.90575C2.69974 9.44347 2.37664 8.89299 2.33789 8.30354L2.33398 8.1857V8.18439C2.33398 8.18352 2.33463 8.18266 2.33464 8.18179C2.33595 7.54915 2.67483 6.95664 3.07682 6.46434C3.48931 5.95926 4.0273 5.48769 4.54622 5.08934C5.06817 4.68869 5.58776 4.34926 5.97526 4.11083C6.16949 3.99132 6.33167 3.89623 6.44596 3.83088C6.50311 3.7982 6.54874 3.77338 6.58008 3.75601C6.59554 3.74744 6.60743 3.74045 6.61589 3.73583C6.62013 3.73351 6.62395 3.73125 6.6263 3.72997C6.62734 3.72941 6.62827 3.72901 6.62891 3.72867L6.62956 3.72801H6.63021L6.67643 3.70588Z" fill="#2E2E2E"/>
                            </svg>
                        </div>
                        <div class="packages__slider-arrow packages__slider-arrow-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8.69206 3.56382C8.82308 3.32074 9.12671 3.22967 9.36979 3.36069H9.37044L9.37109 3.36134C9.37174 3.36169 9.37264 3.36207 9.3737 3.36264C9.37602 3.36391 9.3793 3.36623 9.38346 3.3685C9.3919 3.37311 9.40439 3.37943 9.41992 3.38803C9.45127 3.40541 9.49687 3.43088 9.55404 3.46356C9.66833 3.52889 9.83053 3.62404 10.0247 3.7435C10.4122 3.98185 10.9319 4.32094 11.4538 4.72137C11.9727 5.11952 12.51 5.59092 12.9225 6.09572C13.3254 6.58873 13.666 7.18251 13.666 7.81642L13.6621 7.93426C13.6234 8.52393 13.3009 9.07522 12.9232 9.53777C12.5107 10.0428 11.9727 10.5138 11.4538 10.9121C10.9318 11.3128 10.4122 11.6522 10.0247 11.8906C9.83051 12.0101 9.66833 12.1052 9.55404 12.1706C9.49688 12.2033 9.45127 12.2287 9.41992 12.2461C9.4046 12.2546 9.39253 12.261 9.38411 12.2656C9.37987 12.268 9.37605 12.2702 9.3737 12.2715C9.37265 12.2721 9.37173 12.2725 9.37109 12.2728L9.37044 12.2735H9.36979C9.12675 12.4045 8.82313 12.314 8.69206 12.071C8.561 11.8279 8.65212 11.5243 8.89518 11.3932C8.89547 11.3931 8.89637 11.393 8.89714 11.3926C8.89865 11.3918 8.90105 11.3905 8.9043 11.3887C8.91107 11.385 8.92168 11.3788 8.93555 11.3711C8.96326 11.3557 9.00438 11.3324 9.05729 11.3021C9.16356 11.2413 9.31677 11.1522 9.50065 11.0391C9.86935 10.8122 10.3581 10.4924 10.8444 10.1192C11.3338 9.74353 11.8047 9.32582 12.1484 8.90496C12.3215 8.69309 12.4486 8.49626 12.5339 8.31707H3.16602C2.88987 8.31707 2.66602 8.09321 2.66602 7.81707C2.66603 7.54094 2.88988 7.31707 3.16602 7.31707H12.5345C12.4493 7.13773 12.3218 6.94077 12.1484 6.72853C11.8047 6.30791 11.3344 5.8898 10.8451 5.51434C10.3587 5.14114 9.86941 4.82189 9.50065 4.59507C9.31695 4.48207 9.1642 4.39278 9.05794 4.33205C9.00491 4.30173 8.96328 4.27841 8.93555 4.26303C8.92174 4.25538 8.91108 4.24981 8.9043 4.24611C8.90093 4.24427 8.89866 4.24238 8.89714 4.24155C8.89637 4.24114 8.89547 4.24105 8.89518 4.2409C8.65226 4.10992 8.5613 3.80682 8.69206 3.56382Z" fill="#2E2E2E"/>
                            </svg>
                        </div>
                    </div>
                    <?php $previous_package_services = []; ?>
                    <?php foreach ($packages as $package_key => $package) : ?>
                        <?php
                        $package_service_keys = [];
                        $package_groups = [];

                        foreach ($groups as $group_index => $group) {
                            $package_group = [
                                'title'       => $group['title'],
                                'description' => $group['description'],
                                'services'    => [],
                            ];

                            foreach ($group['services'] as $service_index => $service) {
                                $service_key = $group_index . '-' . $service_index;

                                if (!in_array($package_key, $service['tariffs'], true)) {
                                    continue;
                                }

                                $package_service_keys[] = $service_key;

                                if (in_array($service_key, $previous_package_services, true)) {
                                    continue;
                                }

                                $package_group['services'][] = $service;
                            }

                            if (!empty($package_group['services'])) {
                                $package_groups[] = $package_group;
                            }
                        }
                        ?>

                        <div class="packages__slide packages__slide--<?php echo esc_attr($package_key); ?> swiper-slide">
                            <div class="packages__cell packages__cell--package packages__cell--<?php echo esc_attr($package_key); ?>">
                                <div class="packages__cell-wraper">
                                    <div class="packages__column-title">
                                        <?php echo esc_html($package['title']); ?>
                                    </div>

                                    <div class="packages__column-subtitle">
                                        <?php echo wp_kses_post($package['subtitle_html']); ?>
                                    </div>

                                    <?php if (!empty($package['price'])) : ?>
                                        <div class="packages__column-price">
                                            <?php echo esc_html($package['price']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="packages__slide-services packages__cell--<?php echo esc_attr($package_key); ?>">
                                <?php if (!empty($package['mobile_intro'])) : ?>
                                    <div class="packages__mobile-group-title">
                                        <?php echo wp_kses_post($package['mobile_intro']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php foreach ($package_groups as $package_group) : ?>
                                    <div class="packages__mobile-group-title">
                                        <span class="packages__group-name">
                                            <?php echo esc_html($package_group['title']); ?>
                                            <?php if (!empty($package_group['description'])) : ?>
                                                <span class="packages__icon packages__service-icon packages__group-icon">
                                                    <span class="packages__service-description">
                                                        <?php echo wp_kses_post($package_group['description']); ?>
                                                    </span>
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </div>

                                    <?php $current_mobile_subgroup = ''; ?>
                                    <?php foreach ($package_group['services'] as $service) : ?>
                                        <?php if (!empty($service['subgroup']) && $service['subgroup'] !== $current_mobile_subgroup) : ?>
                                            <?php $current_mobile_subgroup = $service['subgroup']; ?>
                                            <div class="packages__mobile-group-title packages__mobile-subgroup-title">
                                                <?php echo wp_kses_post($current_mobile_subgroup); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="packages__mobile-service">
                                            <div class="packages__service-name">
                                                <?php echo esc_html($service['name']); ?>
                                                <?php if (!empty($service['description'])) : ?>
                                                    <span class="packages__icon packages__service-icon">
                                                        <span class="packages__service-description">
                                                            <?php echo wp_kses_post($service['description']); ?>
                                                        </span>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php $previous_package_services = array_values(array_unique(array_merge($previous_package_services, $package_service_keys))); ?>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class="packages__note">
                <p>Document anti-fraud verification and widget customization are included in all packages. The “Selfie / Selfie with Passport” or “LiveNess” verification is included in the BASIC and ADVANCED packages: the client chooses one of the two (Selfie or LiveNess) in the scenario settings; the price for BASIC is fixed.</p>
                <p>* The cost of the ADVANCED package is calculated individually, taking into account a 5% discount when all database checks are included in the package.</p>
            </div>

        </div>
    </div>
</section>







<?php include get_stylesheet_directory() . '/template-parts/teaser.php'; ?>

<?php get_footer(); ?>
