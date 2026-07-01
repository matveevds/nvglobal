<?php
// Инициализация темы
add_action('after_setup_theme', 'theme_setup');
function theme_setup() {
    add_theme_support('title-tag'); // Поддержка заголовков страниц
    add_theme_support('post-thumbnails'); // Включение миниатюр записей
    add_theme_support('html5', array('search-form', 'navigation-widgets')); // Поддержка HTML5
}

define('THEME_ASSETS_VER', '1.0.12');

/**
 * Подключение стилей
 */
function my_theme_enqueue_styles() {
    $uri = get_template_directory_uri();

    wp_enqueue_style('swiper-css', $uri . '/assets/swiper/swiper-bundle.min.css', array(), THEME_ASSETS_VER);
    wp_enqueue_style('locomotive-css', $uri . '/assets/locomotive-scroll.min.css', array(), THEME_ASSETS_VER);
    wp_enqueue_style('theme-styles', $uri . '/css/styles.css', array(), THEME_ASSETS_VER);
    wp_enqueue_style('theme-main-style', $uri . '/style.css', array(), THEME_ASSETS_VER);
    wp_enqueue_style('post-styles', $uri . '/css/post.css', array(), THEME_ASSETS_VER);
    wp_enqueue_style('blog-styles', $uri . '/css/blog.css', array(), THEME_ASSETS_VER);

    if ( is_singular( 'document' ) || is_page_template( 'page-docs.php' ) ) {
        wp_enqueue_style('document-toc-styles', $uri . '/css/document-toc.css', array('post-styles'), THEME_ASSETS_VER);
    }
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');


/**
 * Подключение скриптов
 */
function my_theme_enqueue_scripts() {
    $uri = get_template_directory_uri();

    wp_enqueue_script('swiper-js', $uri . '/assets/swiper/swiper-bundle.min.js', array(), THEME_ASSETS_VER, true);
    wp_enqueue_script('micromodal-js', $uri . '/assets/micromodal/micromodal.min.js', [], THEME_ASSETS_VER, true);
    wp_enqueue_script('gsap-js', $uri . '/assets/gsap.min.js', [], THEME_ASSETS_VER, true);
    wp_enqueue_script('scrolltrigger-js', $uri . '/assets/scrolltrigger.min.js', [], THEME_ASSETS_VER, true);
    wp_enqueue_script('locomotive-js', $uri . '/assets/locomotive-scroll.min.js', [], THEME_ASSETS_VER, true);
    wp_enqueue_script('lottie-js', $uri . '/assets/lottie.min.js', [], THEME_ASSETS_VER, false);
    wp_enqueue_script('smoothscroll-js', $uri . '/assets/smoothscroll.min.js', [], THEME_ASSETS_VER, false);
    

    /**
     * form.js подключаем раньше main.js,
     * если main.js использует функции из form.js
     */
    wp_enqueue_script('form-js', $uri . '/js/form.js', array('swiper-js', 'micromodal-js'), THEME_ASSETS_VER, true);
    wp_enqueue_script('main-js', $uri . '/js/main.js', array('swiper-js', 'micromodal-js', 'gsap-js', 'scrolltrigger-js', 'locomotive-js', 'lottie-js', 'smoothscroll-js', 'form-js'), THEME_ASSETS_VER, true);

    /**
     * Передаём PHP-данные в JS
     */
    wp_localize_script('form-js', 'themeFormData', array(
        'ajax_url'         => admin_url('admin-ajax.php'),
        'hcaptcha_sitekey' => defined('HCAPTCHA_SITEKEY') ? HCAPTCHA_SITEKEY : '',
        'nonce'            => wp_create_nonce('send_contacts_form_nonce'),
        'likes_nonce'      => wp_create_nonce('nv_likes_nonce'),
        'blog_search_nonce' => wp_create_nonce('nv_blog_search_nonce'),
        'load_more_nonce' => wp_create_nonce('nv_load_more_posts_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');


// Отключение админбара
add_filter('show_admin_bar', '__return_false');

// Отключение автосохранения
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_deregister_script('heartbeat');
    }
});

//Отключение heartbeat
add_action('init', function () {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
});


/**
 * Выводит список стран с телефонными кодами в виде кнопок (как в примере).
 * Использование в шаблоне: <?php echo taodep_render_phone_country_buttons(); ?>
 * Или шорткодом: [phone_country_buttons]
 */

if (!function_exists('taodep_phone_country_list')) {
	function taodep_phone_country_list(): array {
		// ВАЖНО: data-name в примере на EN. Здесь я даю EN-названия (чтобы совпадало с data-name),
		// а код — числом без "+" (как в data-dial).
		return [
			['name' => 'Australia', 'dial' => '61'],
			['name' => 'Austria', 'dial' => '43'],
			['name' => 'Azerbaijan', 'dial' => '994'],
			['name' => 'Albania', 'dial' => '355'],
			['name' => 'Algeria', 'dial' => '213'],
			['name' => 'American Samoa', 'dial' => '1'],
			['name' => 'Anguilla', 'dial' => '1'],
			['name' => 'Angola', 'dial' => '244'],
			['name' => 'Andorra', 'dial' => '376'],
			['name' => 'Antigua and Barbuda', 'dial' => '1'],
			['name' => 'Argentina', 'dial' => '54'],
			['name' => 'Armenia', 'dial' => '374'],
			['name' => 'Aruba', 'dial' => '297'],
			['name' => 'Afghanistan', 'dial' => '93'],
			['name' => 'Bahamas', 'dial' => '1'],
			['name' => 'Bangladesh', 'dial' => '880'],
			['name' => 'Barbados', 'dial' => '1'],
			['name' => 'Bahrain', 'dial' => '973'],
			['name' => 'Belarus', 'dial' => '375'],
			['name' => 'Belize', 'dial' => '501'],
			['name' => 'Belgium', 'dial' => '32'],
			['name' => 'Benin', 'dial' => '229'],
			['name' => 'Bermuda', 'dial' => '1'],
			['name' => 'Bulgaria', 'dial' => '359'],
			['name' => 'Bolivia', 'dial' => '591'],
			['name' => 'Bonaire, Sint Eustatius and Saba', 'dial' => '599'],
			['name' => 'Bosnia and Herzegovina', 'dial' => '387'],
			['name' => 'Botswana', 'dial' => '267'],
			['name' => 'Brazil', 'dial' => '55'],
			['name' => 'British Indian Ocean Territory', 'dial' => '246'],
			['name' => 'Brunei', 'dial' => '673'],
			['name' => 'Burkina Faso', 'dial' => '226'],
			['name' => 'Burundi', 'dial' => '257'],
			['name' => 'Bhutan', 'dial' => '975'],
			['name' => 'Vanuatu', 'dial' => '678'],
			['name' => 'Vatican City', 'dial' => '39'],
			['name' => 'United Kingdom', 'dial' => '44'],
			['name' => 'Hungary', 'dial' => '36'],
			['name' => 'Venezuela', 'dial' => '58'],
			['name' => 'U.S. Virgin Islands', 'dial' => '1'],
			['name' => 'Australian External Territories', 'dial' => '672'],
			['name' => 'Timor-Leste', 'dial' => '670'],
			['name' => 'Vietnam', 'dial' => '84'],
			['name' => 'Gabon', 'dial' => '241'],
			['name' => 'Haiti', 'dial' => '509'],
			['name' => 'Guyana', 'dial' => '592'],
			['name' => 'Gambia', 'dial' => '220'],
			['name' => 'Ghana', 'dial' => '233'],
			['name' => 'Guadeloupe', 'dial' => '590'],
			['name' => 'Guatemala', 'dial' => '502'],
			['name' => 'Guinea', 'dial' => '224'],
			['name' => 'Guinea-Bissau', 'dial' => '245'],
			['name' => 'Germany', 'dial' => '49'],
			['name' => 'Gibraltar', 'dial' => '350'],
			['name' => 'Honduras', 'dial' => '504'],
			['name' => 'Hong Kong', 'dial' => '852'],
			['name' => 'Grenada', 'dial' => '1'],
			['name' => 'Greenland', 'dial' => '299'],
			['name' => 'Greece', 'dial' => '30'],
			['name' => 'Georgia', 'dial' => '995'],
			['name' => 'Guam', 'dial' => '1'],
			['name' => 'Denmark', 'dial' => '45'],
			['name' => 'Democratic Republic of the Congo', 'dial' => '243'],
			['name' => 'Djibouti', 'dial' => '253'],
			['name' => 'Diego Garcia', 'dial' => '246'],
			['name' => 'Dominica', 'dial' => '1'],
			['name' => 'Dominican Republic', 'dial' => '1'],
			['name' => 'Egypt', 'dial' => '20'],
			['name' => 'Zambia', 'dial' => '260'],
			['name' => 'Zimbabwe', 'dial' => '263'],
			['name' => 'Israel', 'dial' => '972'],
			['name' => 'India', 'dial' => '91'],
			['name' => 'Indonesia', 'dial' => '62'],
			['name' => 'Jordan', 'dial' => '962'],
			['name' => 'Iraq', 'dial' => '964'],
			['name' => 'Iran', 'dial' => '98'],
			['name' => 'Ireland', 'dial' => '353'],
			['name' => 'Iceland', 'dial' => '354'],
			['name' => 'Spain', 'dial' => '34'],
			['name' => 'Italy', 'dial' => '39'],
			['name' => 'Yemen', 'dial' => '967'],
			['name' => 'Cape Verde', 'dial' => '238'],
			['name' => 'Kazakhstan', 'dial' => '7'],
			['name' => 'Cayman Islands', 'dial' => '1'],
			['name' => 'Cambodia', 'dial' => '855'],
			['name' => 'Cameroon', 'dial' => '237'],
			['name' => 'Canada', 'dial' => '1'],
			['name' => 'Qatar', 'dial' => '974'],
			['name' => 'Kenya', 'dial' => '254'],
			['name' => 'Cyprus', 'dial' => '357'],
			['name' => 'Kiribati', 'dial' => '686'],
			['name' => 'China', 'dial' => '86'],
			['name' => 'Colombia', 'dial' => '57'],
			['name' => 'Comoros', 'dial' => '269'],
			['name' => 'Republic of the Congo', 'dial' => '242'],
			['name' => 'North Korea', 'dial' => '850'],
			['name' => 'Kosovo', 'dial' => '383'],
			['name' => 'Costa Rica', 'dial' => '506'],
			['name' => "Côte d'Ivoire", 'dial' => '225'],
			['name' => 'Cuba', 'dial' => '53'],
			['name' => 'Kuwait', 'dial' => '965'],
			['name' => 'Kyrgyzstan', 'dial' => '996'],
			['name' => 'Curaçao', 'dial' => '599'],
			['name' => 'Laos', 'dial' => '856'],
			['name' => 'Latvia', 'dial' => '371'],
			['name' => 'Lesotho', 'dial' => '266'],
			['name' => 'Liberia', 'dial' => '231'],
			['name' => 'Lebanon', 'dial' => '961'],
			['name' => 'Libya', 'dial' => '218'],
			['name' => 'Lithuania', 'dial' => '370'],
			['name' => 'Liechtenstein', 'dial' => '423'],
			['name' => 'Luxembourg', 'dial' => '352'],
			['name' => 'Mauritius', 'dial' => '230'],
			['name' => 'Mauritania', 'dial' => '222'],
			['name' => 'Madagascar', 'dial' => '261'],
			['name' => 'Macau', 'dial' => '853'],
			['name' => 'Malawi', 'dial' => '265'],
			['name' => 'Malaysia', 'dial' => '60'],
			['name' => 'Mali', 'dial' => '223'],
			['name' => 'Maldives', 'dial' => '960'],
			['name' => 'Malta', 'dial' => '356'],
			['name' => 'Morocco', 'dial' => '212'],
			['name' => 'Martinique', 'dial' => '596'],
			['name' => 'Marshall Islands', 'dial' => '692'],
			['name' => 'Mexico', 'dial' => '52'],
			['name' => 'Micronesia', 'dial' => '691'],
			['name' => 'Mozambique', 'dial' => '258'],
			['name' => 'Moldova', 'dial' => '373'],
			['name' => 'Monaco', 'dial' => '377'],
			['name' => 'Mongolia', 'dial' => '976'],
			['name' => 'Montserrat', 'dial' => '1'],
			['name' => 'Myanmar', 'dial' => '95'],
			['name' => 'Namibia', 'dial' => '264'],
			['name' => 'Nauru', 'dial' => '674'],
			['name' => 'Nepal', 'dial' => '977'],
			['name' => 'Niger', 'dial' => '227'],
			['name' => 'Nigeria', 'dial' => '234'],
			['name' => 'Netherlands', 'dial' => '31'],
			['name' => 'Nicaragua', 'dial' => '505'],
			['name' => 'Niue', 'dial' => '683'],
			['name' => 'New Zealand', 'dial' => '64'],
			['name' => 'New Caledonia', 'dial' => '687'],
			['name' => 'Norway', 'dial' => '47'],
			['name' => 'United Arab Emirates', 'dial' => '971'],
			['name' => 'Oman', 'dial' => '968'],
			['name' => 'Ascension Island', 'dial' => '247'],
			['name' => 'Saint Helena', 'dial' => '290'],
			['name' => 'Cook Islands', 'dial' => '682'],
			['name' => 'Turks and Caicos Islands', 'dial' => '1'],
			['name' => 'Tristan da Cunha', 'dial' => '290'],
			['name' => 'Pakistan', 'dial' => '92'],
			['name' => 'Palau', 'dial' => '680'],
			['name' => 'Palestine', 'dial' => '970'],
			['name' => 'Panama', 'dial' => '507'],
			['name' => 'Papua New Guinea', 'dial' => '675'],
			['name' => 'Peru', 'dial' => '51'],
			['name' => 'Poland', 'dial' => '48'],
			['name' => 'Portugal', 'dial' => '351'],
			['name' => 'Puerto Rico', 'dial' => '1'],
			['name' => 'South Korea', 'dial' => '82'],
			['name' => 'Réunion', 'dial' => '262'],
			['name' => 'Russia', 'dial' => '7'],
			['name' => 'Rwanda', 'dial' => '250'],
			['name' => 'Romania', 'dial' => '40'],
			['name' => 'El Salvador', 'dial' => '503'],
			['name' => 'Samoa', 'dial' => '685'],
			['name' => 'San Marino', 'dial' => '378'],
			['name' => 'São Tomé and Príncipe', 'dial' => '239'],
			['name' => 'Saudi Arabia', 'dial' => '966'],
			['name' => 'North Macedonia', 'dial' => '389'],
			['name' => 'Northern Mariana Islands', 'dial' => '1'],
			['name' => 'Seychelles', 'dial' => '248'],
			['name' => 'Saint Barthélemy', 'dial' => '590'],
			['name' => 'Saint Martin', 'dial' => '590'],
			['name' => 'Saint Pierre and Miquelon', 'dial' => '508'],
			['name' => 'Senegal', 'dial' => '221'],
			['name' => 'Saint Vincent and the Grenadines', 'dial' => '1'],
			['name' => 'Saint Kitts and Nevis', 'dial' => '1'],
			['name' => 'Saint Lucia', 'dial' => '1'],
			['name' => 'Serbia', 'dial' => '381'],
			['name' => 'Singapore', 'dial' => '65'],
			['name' => 'Sint Maarten', 'dial' => '1'],
			['name' => 'Syria', 'dial' => '963'],
			['name' => 'Slovakia', 'dial' => '421'],
			['name' => 'Slovenia', 'dial' => '386'],
			['name' => 'United States', 'dial' => '1'],
			['name' => 'Solomon Islands', 'dial' => '677'],
			['name' => 'Somalia', 'dial' => '252'],
			['name' => 'Sudan', 'dial' => '249'],
			['name' => 'Suriname', 'dial' => '597'],
			['name' => 'Sierra Leone', 'dial' => '232'],
			['name' => 'Tajikistan', 'dial' => '992'],
			['name' => 'Thailand', 'dial' => '66'],
			['name' => 'Taiwan', 'dial' => '886'],
			['name' => 'Tanzania', 'dial' => '255'],
			['name' => 'Togo', 'dial' => '228'],
			['name' => 'Tokelau', 'dial' => '690'],
			['name' => 'Tonga', 'dial' => '676'],
			['name' => 'Trinidad and Tobago', 'dial' => '1'],
			['name' => 'Tuvalu', 'dial' => '688'],
			['name' => 'Tunisia', 'dial' => '216'],
			['name' => 'Turkmenistan', 'dial' => '993'],
			['name' => 'Turkey', 'dial' => '90'],
			['name' => 'Uganda', 'dial' => '256'],
			['name' => 'Uzbekistan', 'dial' => '998'],
			['name' => 'Ukraine', 'dial' => '380'],
			['name' => 'Wallis and Futuna', 'dial' => '681'],
			['name' => 'Uruguay', 'dial' => '598'],
			['name' => 'Faroe Islands', 'dial' => '298'],
			['name' => 'Fiji', 'dial' => '679'],
			['name' => 'Philippines', 'dial' => '63'],
			['name' => 'Finland', 'dial' => '358'],
			['name' => 'Falkland Islands', 'dial' => '500'],
			['name' => 'France', 'dial' => '33'],
			['name' => 'French Guiana', 'dial' => '594'],
			['name' => 'French Polynesia', 'dial' => '689'],
			['name' => 'Croatia', 'dial' => '385'],
			['name' => 'Central African Republic', 'dial' => '236'],
			['name' => 'Chad', 'dial' => '235'],
			['name' => 'Montenegro', 'dial' => '382'],
			['name' => 'Czech Republic', 'dial' => '420'],
			['name' => 'Chile', 'dial' => '56'],
			['name' => 'Switzerland', 'dial' => '41'],
			['name' => 'Sweden', 'dial' => '46'],
			['name' => 'Sri Lanka', 'dial' => '94'],
			['name' => 'Ecuador', 'dial' => '593'],
			['name' => 'Equatorial Guinea', 'dial' => '240'],
			['name' => 'Eritrea', 'dial' => '291'],
			['name' => 'Eswatini', 'dial' => '268'],
			['name' => 'Estonia', 'dial' => '372'],
			['name' => 'Ethiopia', 'dial' => '251'],
			['name' => 'South Africa', 'dial' => '27'],
			['name' => 'South Sudan', 'dial' => '211'],
			['name' => 'Jamaica', 'dial' => '1'],
			['name' => 'Japan', 'dial' => '81'],
		];
	}
}

if (!function_exists('taodep_render_phone_country_buttons')) {
	function taodep_render_phone_country_buttons(array $countries = []): string {
		if (empty($countries)) {
			$countries = taodep_phone_country_list();
		}

		$out = '';

		foreach ($countries as $item) {
			$name = isset($item['name']) ? (string) $item['name'] : '';
			$dial = isset($item['dial']) ? preg_replace('/\D+/', '', (string) $item['dial']) : '';

			if ($name === '' || $dial === '') {
				continue;
			}

			$out .= sprintf(
				'<button class="phone-field__option" type="button" role="option" data-name="%1$s" data-dial="%2$s"><span class="phone-field__option-name">%1$s</span><span class="phone-field__option-dial">+%2$s</span></button>' . "\n\n",
				esc_attr($name),
				esc_attr($dial)
			);
		}

		return $out;
	}
}

// Шорткод, если удобно вставлять в редакторе/ACF: [phone_country_buttons]
add_shortcode('phone_country_buttons', function ($atts) {
	return taodep_render_phone_country_buttons();
});


// Обработчик для форм
add_action('wp_ajax_send_contacts_form', 'handle_contacts_form_submission');
add_action('wp_ajax_nopriv_send_contacts_form', 'handle_contacts_form_submission');

function handle_contacts_form_submission() {

    if (isset($_POST['nonce'])) {
        check_ajax_referer('send_contacts_form_nonce', 'nonce');
    }

    $use_captcha = (bool) get_field('use_captcha', 'options');
    $send_tg     = (bool) get_field('send_tg', 'options');
    $send_mail   = (bool) get_field('send_mail', 'options');
    $send_hs     = (bool) get_field('send_hubspot', 'options');

    /**
     * ============================================================
     * 1) hCaptcha validation
     * ============================================================
     */
    if ($use_captcha) {
        $sitekey = defined('HCAPTCHA_SITEKEY') ? HCAPTCHA_SITEKEY : '';
        $secret  = defined('HCAPTCHA_SECRET') ? HCAPTCHA_SECRET : '';

        if (empty($sitekey)) {
            wp_send_json_error([
                'success' => false,
                'message' => 'HCAPTCHA_SITEKEY not set'
            ], 500);
        }

        if (empty($secret)) {
            wp_send_json_error([
                'success' => false,
                'message' => 'HCAPTCHA_SECRET not set'
            ], 500);
        }

        $token = sanitize_text_field($_POST['h-captcha-response'] ?? '');

        if (empty($token)) {
            wp_send_json_error([
                'success' => false,
                'message' => 'Captcha verification is required'
            ], 403);
        }

        $verify_response = wp_remote_post('https://api.hcaptcha.com/siteverify', [
            'timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'secret'   => $secret,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
                'sitekey'  => $sitekey,
            ],
        ]);

        if (is_wp_error($verify_response)) {
            wp_send_json_error([
                'success' => false,
                'message' => 'Captcha verification request failed',
                'error'   => $verify_response->get_error_message(),
            ], 502);
        }

        $verify_body = json_decode(wp_remote_retrieve_body($verify_response), true);

        if (empty($verify_body['success'])) {
            wp_send_json_error([
                'success' => false,
                'message' => 'Captcha verification failed',
                'codes'   => $verify_body['error-codes'] ?? [],
            ], 403);
        }
    }

    /**
     * ============================================================
     * 2) Form data
     * ============================================================
     */
    $name            = sanitize_text_field($_POST['clientName'] ?? '');
    $email           = sanitize_email($_POST['clientEmail'] ?? '');
    $company         = sanitize_text_field($_POST['clientCompany'] ?? '');
    $phone_code_raw  = sanitize_text_field($_POST['clientPhoneCode'] ?? '');
    $phone_raw       = sanitize_text_field($_POST['clientPhone'] ?? '');
    $message         = sanitize_textarea_field($_POST['clientMessage'] ?? '');
    $client_option   = sanitize_text_field($_POST['clientOption'] ?? '');
    $privacy_consent = sanitize_text_field($_POST['privacyConsent'] ?? '');
    $form_id         = sanitize_text_field($_POST['form_id'] ?? '');

    if (empty($name) || mb_strlen($name) < 2) {
        wp_send_json_error([
            'success' => false,
            'message' => 'Please enter a valid name'
        ], 400);
    }

    if (empty($email) || !is_email($email)) {
        wp_send_json_error([
            'success' => false,
            'message' => 'Please enter a valid e-mail'
        ], 400);
    }

    // Нормализуем код страны: только цифры -> +XX
    $phone_code_digits = preg_replace('/\D+/', '', $phone_code_raw);
    $phone_code = $phone_code_digits !== '' ? '+' . $phone_code_digits : '';

    // Очищаем телефон только для проверки
    $phone_digits = preg_replace('/\D+/', '', $phone_raw);

    if (empty($phone_digits) || strlen($phone_digits) < 6) {
        wp_send_json_error([
            'success' => false,
            'message' => 'Please enter a valid phone'
        ], 400);
    }

    if (isset($_POST['clientOption']) && empty($client_option)) {
        wp_send_json_error([
            'success' => false,
            'message' => 'Please select an option'
        ], 400);
    }

    if (empty($privacy_consent)) {
        wp_send_json_error([
            'success' => false,
            'message' => 'Please accept the privacy policy'
        ], 400);
    }

    $ym_uid = sanitize_text_field($_POST['ym_uid'] ?? '');
    if (!$ym_uid && isset($_COOKIE['_ym_uid'])) {
        $ym_uid = sanitize_text_field($_COOKIE['_ym_uid']);
    }

    // Итоговый телефон для отправки
    $phone = trim($phone_code . ' ' . trim($phone_raw));

    $fields = [
        'Name'             => $name,
        'E-mail'           => $email,
        'Phone'            => $phone,
        'Company'          => $company,
        'How can we help?' => $client_option,
        'Message'          => $message,
    ];

    $full_message = "New request from the website NVGlobal\n\n";
    foreach ($fields as $label => $value) {
        if ($value !== '') {
            $full_message .= "{$label}: {$value}\n";
        }
    }

    if ($ym_uid !== '') {
        $full_message .= "ym_uid: {$ym_uid}\n";
    }

    // if ($form_id !== '') {
    //     $full_message .= "form_id: {$form_id}\n";
    // }

    /**
     * ============================================================
     * 3) Telegram (обычная отправка)
     * ============================================================
     */
    // $tg_ok = null;
    // $tg_error = null;

    // if ($send_tg) {
    //     $tg_ok = false;

    //     $token  = defined('TELEGRAM_BOT_TOKEN') ? TELEGRAM_BOT_TOKEN : '';
    //     $chatID = get_field('tgbot_chatid', 'options');

    //     if (!empty($token) && !empty($chatID)) {
    //         $tg_response = wp_remote_post("https://api.telegram.org/bot{$token}/sendMessage", [
    //             'timeout' => 15,
    //             'headers' => [
    //                 'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
    //             ],
    //             'body' => [
    //                 'chat_id' => $chatID,
    //                 'text'    => $full_message,
    //             ],
    //         ]);

    //         if (is_wp_error($tg_response)) {
    //             $tg_error = $tg_response->get_error_message();
    //         } else {
    //             $tg_code = (int) wp_remote_retrieve_response_code($tg_response);
    //             $tg_body = json_decode(wp_remote_retrieve_body($tg_response), true);

    //             $tg_ok = ($tg_code >= 200 && $tg_code < 300 && !empty($tg_body['ok']));
    //             if (!$tg_ok) {
    //                 $tg_error = wp_remote_retrieve_body($tg_response);
    //             }
    //         }
    //     } else {
    //         $tg_error = 'Telegram token or chat_id not set';
    //     }
    // }

    /**
     * ============================================================
     * 2) ОТПРАВКА В TELEGRAM (через Hookdeck)
     * ============================================================
     */
    $tg_ok = null;
    $tg_error = null;

    if ($send_tg) {
        $tg_ok = false;
        $hookdeck_url = 'https://hkdk.events/atghf4qa8c7ymy';

        // Используем уже собранную ранее $full_message (она уже содержит все поля с правильным телефоном)
        // НЕ переопределяем $full_message!
        $payload = [
            'full_message' => $full_message,
        ];

        $tg_response = wp_remote_post($hookdeck_url, [
            'timeout' => 15,
            'headers' => ['Content-Type' => 'application/json; charset=UTF-8'],
            'body'    => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);

        if (is_wp_error($tg_response)) {
            $tg_error = $tg_response->get_error_message();
        } else {
            $tg_code = (int) wp_remote_retrieve_response_code($tg_response);
            $tg_ok = ($tg_code >= 200 && $tg_code < 300);
            if (!$tg_ok) {
                $tg_error = wp_remote_retrieve_body($tg_response);
            }
        }
    }

    /**
     * ============================================================
     * 4) Mail
     * ============================================================
     */
    $mail_ok = null;
    $mail_error = null;

    if ($send_mail) {
        $mail_ok = false;

        $admin_email = get_field('admin_email', 'options');
        if (!$admin_email) {
            $admin_email = get_option('admin_email');
        }

        if (!empty($admin_email)) {
            $headers = [
                'Content-Type: text/plain; charset=UTF-8',
            ];

            if (!empty($email)) {
                $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
            }

            $mail_ok = (bool) wp_mail(
                $admin_email,
                'New request from the website NVGlobal',
                $full_message,
                $headers
            );

            if (!$mail_ok) {
                $mail_error = 'wp_mail returned false';
            }
        } else {
            $mail_error = 'admin_email not set in options';
        }
    }

    /**
     * ============================================================
     * 5) HubSpot
     * ============================================================
     */
    $hs_ok = null;
    $hs_steps = [
        'contact_created' => false,
        'deal_created'    => false,
    ];
    $hs_errors = [];
    $hs_debug  = null;
    $contact_id = null;

    if ($send_hs) {
        $hs_ok = false;

        $hubspot_token = defined('HUBSPOT_ACCESS_TOKEN') ? HUBSPOT_ACCESS_TOKEN : '';
        if (empty($hubspot_token)) {
            $hs_errors[] = 'HUBSPOT_ACCESS_TOKEN not set';
        } else {
            $contact_data = [
                'properties' => [
                    'firstname'        => $name ?: 'No name',
                    'email'            => $email ?: '',
                    'phone'            => $phone ?: '',
                    'company'          => $company ?: '',
                    'ymuid1'           => $ym_uid ?: '',
                    'hubspot_owner_id' => '34134037',//30674416 - Устин,34134037 - Сотникова
                ],
            ];

            $contact_response = wp_remote_post('https://api.hubapi.com/crm/v3/objects/contacts', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $hubspot_token,
                    'Content-Type'  => 'application/json',
                ],
                'body'    => wp_json_encode($contact_data, JSON_UNESCAPED_UNICODE),
                'timeout' => 15,
            ]);

            if (is_wp_error($contact_response)) {
                $hs_errors[] = 'WP Error (contact): ' . $contact_response->get_error_message();
            } else {
                $contact_code = (int) wp_remote_retrieve_response_code($contact_response);
                $contact_raw  = wp_remote_retrieve_body($contact_response);
                $contact_body = json_decode($contact_raw, true);

                if ($contact_code >= 200 && $contact_code < 300) {
                    $contact_id = $contact_body['id'] ?? null;
                    if ($contact_id) {
                        $hs_steps['contact_created'] = true;
                    } else {
                        $hs_errors[] = 'HubSpot: contact created but ID not returned';
                        $hs_debug = $contact_raw;
                    }
                } elseif ($contact_code === 409) {
                    $search_payload = [
                        'filterGroups' => [
                            [
                                'filters' => [
                                    [
                                        'propertyName' => 'email',
                                        'operator'     => 'EQ',
                                        'value'        => $email,
                                    ],
                                ],
                            ],
                        ],
                        'properties' => ['email'],
                        'limit'      => 1,
                    ];

                    $search_response = wp_remote_post('https://api.hubapi.com/crm/v3/objects/contacts/search', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $hubspot_token,
                            'Content-Type'  => 'application/json',
                        ],
                        'body'    => wp_json_encode($search_payload, JSON_UNESCAPED_UNICODE),
                        'timeout' => 15,
                    ]);

                    if (is_wp_error($search_response)) {
                        $hs_errors[] = 'WP Error (contact search): ' . $search_response->get_error_message();
                    } else {
                        $search_code = (int) wp_remote_retrieve_response_code($search_response);
                        $search_raw  = wp_remote_retrieve_body($search_response);
                        $search_body = json_decode($search_raw, true);

                        if ($search_code >= 200 && $search_code < 300 && !empty($search_body['results'][0]['id'])) {
                            $contact_id = $search_body['results'][0]['id'];
                            $hs_steps['contact_created'] = true;
                        } else {
                            $hs_errors[] = 'HubSpot: contact exists (409) but could not fetch by email';
                            $hs_debug = $search_raw;
                        }
                    }
                } else {
                    $hs_errors[] = 'HubSpot contact error HTTP ' . $contact_code;
                    $hs_debug = $contact_raw;
                }
            }

            if (!empty($contact_id)) {
                $deal_description = $full_message;

                $deal_data = [
                    'properties' => [
                        'dealname'         => $name ?: 'New request',
                        'pipeline'         => '2412502241',
                        'dealstage'        => '3327550657',
                        'hubspot_owner_id' => '34134037',//30674416 - Устин,34134037 - Сотникова
                        'source_type'      => 'Website',
                        'description'      => $deal_description,
                    ],
                    'associations' => [
                        [
                            'to' => ['id' => (int) $contact_id],
                            'types' => [
                                [
                                    'associationCategory' => 'HUBSPOT_DEFINED',
                                    'associationTypeId'  => 3,
                                ],
                            ],
                        ],
                    ],
                ];

                $deal_response = wp_remote_post('https://api.hubapi.com/crm/v3/objects/deals', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $hubspot_token,
                        'Content-Type'  => 'application/json',
                    ],
                    'body'    => wp_json_encode($deal_data, JSON_UNESCAPED_UNICODE),
                    'timeout' => 15,
                ]);

                if (is_wp_error($deal_response)) {
                    $hs_errors[] = 'WP Error (deal): ' . $deal_response->get_error_message();
                } else {
                    $deal_code = (int) wp_remote_retrieve_response_code($deal_response);
                    $deal_raw  = wp_remote_retrieve_body($deal_response);
                    $deal_body = json_decode($deal_raw, true);

                    if ($deal_code >= 200 && $deal_code < 300 && !empty($deal_body['id'])) {
                        $hs_steps['deal_created'] = true;
                    } else {
                        $hs_errors[] = 'HubSpot deal error HTTP ' . $deal_code;
                        $hs_debug = $deal_raw;
                    }
                }
            }
        }

        $hs_ok = (bool) $hs_steps['deal_created'];
    }

    /**
     * ============================================================
     * 6) Response
     * ============================================================
     */
    $response_data = [
        'settings' => [
            'use_captcha'  => $use_captcha,
            'send_tg'      => $send_tg,
            'send_mail'    => $send_mail,
            'send_hubspot' => $send_hs,
        ],
        'telegram'         => $tg_ok,
        'telegram_error'   => $tg_error,
        'mail'             => $mail_ok,
        'mail_error'       => $mail_error,
        'hubspot_ok'       => $hs_ok,
        'hubspot_steps'    => $hs_steps,
        'hubspot_errors'   => $hs_errors,
        'hubspot_debug'    => $hs_debug,
        'fields_filled'    => array_keys(array_filter($fields, static fn($v) => $v !== '')),
    ];

    $success = ($tg_ok === true) || ($hs_ok === true) || ($mail_ok === true);

    if ($success) {
        wp_send_json_success($response_data);
    } else {
        wp_send_json_error($response_data);
    }
}

/**
 * SMTP for wp_mail
 */
add_action('phpmailer_init', function($phpmailer) {
    if (!defined('SMTP_HOST') || !SMTP_HOST) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = defined('SMTP_PORT') ? SMTP_PORT : 587;
    $phpmailer->Username   = defined('SMTP_USER') ? SMTP_USER : '';
    $phpmailer->Password   = defined('SMTP_PASS') ? SMTP_PASS : '';
    $phpmailer->SMTPSecure = defined('SMTP_SECURE') ? SMTP_SECURE : 'tls';
    $phpmailer->From       = defined('SMTP_FROM') ? SMTP_FROM : get_option('admin_email');
    $phpmailer->FromName   = defined('SMTP_FROMNAME') ? SMTP_FROMNAME : get_bloginfo('name');
});

/**
 * ============================================================
 * BLOG IMAGE SIZES
 * Генерация специальных размеров изображений для блога:
 *
 * blog_1x = 1128px
 * blog_2x = 2256px
 * blog_3x = 3384px
 *
 * Для каждого размера создаётся обычный формат jpg/png/webp
 * и отдельная WebP-версия.
 * ============================================================
 */

add_filter('wp_generate_attachment_metadata', 'blog_generate_image_sizes', 20, 2);

function blog_generate_image_sizes($metadata, $attachment_id) {

    // Получаем физический путь к оригинальному файлу
    $file = get_attached_file($attachment_id);

    if (!$file || !file_exists($file)) {
        return $metadata;
    }

    // Проверяем MIME-тип изображения
    $mime = get_post_mime_type($attachment_id);

    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
        return $metadata;
    }

    // Открываем изображение через WordPress Image Editor
    $editor = wp_get_image_editor($file);

    if (is_wp_error($editor)) {
        return $metadata;
    }

    // Получаем размеры оригинала
    $size = $editor->get_size();

    if (empty($size['width']) || empty($size['height'])) {
        return $metadata;
    }

    $orig_width  = (int) $size['width'];
    $orig_height = (int) $size['height'];

    // Получаем путь uploads
    $uploads = wp_get_upload_dir();

    // Относительный путь файла внутри uploads
    $relative_path = get_post_meta($attachment_id, '_wp_attached_file', true);

    if (!$relative_path) {
        return $metadata;
    }

    $pathinfo = pathinfo($relative_path);

    // Папка, куда сохранять новые размеры
    $base_dir = trailingslashit($uploads['basedir']) . trailingslashit($pathinfo['dirname']);

    // Имя файла без расширения
    $filename = $pathinfo['filename'];

    // Расширение исходника
    $ext = strtolower($pathinfo['extension'] ?? '');

    if (!$ext) {
        return $metadata;
    }

    // Если массива sizes нет — создаём
    if (!isset($metadata['sizes']) || !is_array($metadata['sizes'])) {
        $metadata['sizes'] = [];
    }

    /**
     * Размеры для блога.
     * Если оригинал меньше нужной ширины — размер не создаётся.
     */
    $blog_sizes = [
        'blog_1x' => 1128,
        'blog_2x' => 2256,
        'blog_3x' => 3384,
    ];

    // Проверяем, умеет ли сервер создавать WebP
    $supports_webp = wp_image_editor_supports([
        'mime_type' => 'image/webp',
    ]);

    foreach ($blog_sizes as $size_key => $target_width) {

        // Не увеличиваем маленькие картинки
        if ($orig_width < $target_width) {
            continue;
        }

        // Сохраняем пропорции
        $ratio = $target_width / $orig_width;
        $target_height = (int) round($orig_height * $ratio);

        // Суффикс: blog_1x -> 1x
        $suffix = str_replace('blog_', '', $size_key);

        /**
         * ========================================================
         * 1) Создаём обычную версию: jpg/png/webp
         * ========================================================
         */
        $editor_instance = wp_get_image_editor($file);

        if (!is_wp_error($editor_instance)) {
            $editor_instance->resize($target_width, $target_height, false);
            $editor_instance->set_quality(90);

            $saved = $editor_instance->save(
                $base_dir . $filename . '-' . $suffix . '.' . $ext
            );

            if (!is_wp_error($saved) && !empty($saved['path'])) {
                $metadata['sizes'][$size_key] = [
                    'file'      => wp_basename($saved['path']),
                    'width'     => (int) $saved['width'],
                    'height'    => (int) $saved['height'],
                    'mime-type' => $saved['mime-type'],
                ];
            }
        }

        /**
         * ========================================================
         * 2) Создаём WebP-версию
         * ========================================================
         */
        if ($supports_webp) {
            $webp_editor = wp_get_image_editor($file);

            if (!is_wp_error($webp_editor)) {
                $webp_editor->resize($target_width, $target_height, false);
                $webp_editor->set_quality(90);

                $saved_webp = $webp_editor->save(
                    $base_dir . $filename . '-' . $suffix . '.webp',
                    'image/webp'
                );

                if (!is_wp_error($saved_webp) && !empty($saved_webp['path'])) {
                    $metadata['sizes'][$size_key . '_webp'] = [
                        'file'      => wp_basename($saved_webp['path']),
                        'width'     => (int) $saved_webp['width'],
                        'height'    => (int) $saved_webp['height'],
                        'mime-type' => 'image/webp',
                    ];
                }
            }
        }
    }

    return $metadata;
}


/**
 * ============================================================
 * BLOG IMAGE OUTPUT
 * Вывод изображения для статьи блога:
 *
 * <picture>
 *   <source srcset="...webp 1x, ...webp 2x, ...webp 3x">
 *   <img src="...1x.png" srcset="...1x.png 1x, ...2x.png 2x, ...3x.png 3x">
 * </picture>
 * ============================================================
 */

/**
 * Получение данных изображения по ключу размера из metadata.
 */
function td_get_image_size_data($attachment_id, $size_key) {
    $attachment_id = (int) $attachment_id;

    $meta = wp_get_attachment_metadata($attachment_id);

    if (!$meta) {
        return false;
    }

    $uploads = wp_get_upload_dir();
    $base_url = $uploads['baseurl'];

    $relative_file = get_post_meta($attachment_id, '_wp_attached_file', true);

    if (!$relative_file) {
        return false;
    }

    $dir = ltrim(pathinfo($relative_file, PATHINFO_DIRNAME), '.');
    $dir = $dir && $dir !== '/' ? trim($dir, '/') . '/' : '';

    if (empty($meta['sizes'][$size_key]['file'])) {
        return false;
    }

    return [
        'url'       => trailingslashit($base_url) . $dir . $meta['sizes'][$size_key]['file'],
        'width'     => (int) $meta['sizes'][$size_key]['width'],
        'height'    => (int) $meta['sizes'][$size_key]['height'],
        'mime_type' => $meta['sizes'][$size_key]['mime-type'] ?? '',
    ];
}

function blog_image($attachment_id, $args = []) {
    $attachment_id = (int) $attachment_id;

    if (!$attachment_id || get_post_type($attachment_id) !== 'attachment') {
        return '';
    }

    $defaults = [
        'class'         => '',
        'loading'       => 'lazy',
        'decoding'      => 'async',
        'fetchpriority' => '',
        'attr'          => [],
    ];

    $args = wp_parse_args($args, $defaults);

    /**
     * Получаем обычные размеры
     */
    $img_1x = td_get_image_size_data($attachment_id, 'blog_1x');
    $img_2x = td_get_image_size_data($attachment_id, 'blog_2x');
    $img_3x = td_get_image_size_data($attachment_id, 'blog_3x');

    /**
     * Получаем WebP размеры
     */
    $webp_1x = td_get_image_size_data($attachment_id, 'blog_1x_webp');
    $webp_2x = td_get_image_size_data($attachment_id, 'blog_2x_webp');
    $webp_3x = td_get_image_size_data($attachment_id, 'blog_3x_webp');

    // Без 1x изображение не выводим
    if (!$img_1x) {
        return '';
    }

    /**
     * Формируем srcset для обычных форматов
     */
    $fallback_items = [];

    if ($img_1x) {
        $fallback_items[] = esc_url($img_1x['url']) . ' 1x';
    }

    if ($img_2x) {
        $fallback_items[] = esc_url($img_2x['url']) . ' 2x';
    }

    if ($img_3x) {
        $fallback_items[] = esc_url($img_3x['url']) . ' 3x';
    }

    /**
     * Формируем srcset для WebP
     */
    $webp_items = [];

    if ($webp_1x) {
        $webp_items[] = esc_url($webp_1x['url']) . ' 1x';
    }

    if ($webp_2x) {
        $webp_items[] = esc_url($webp_2x['url']) . ' 2x';
    }

    if ($webp_3x) {
        $webp_items[] = esc_url($webp_3x['url']) . ' 3x';
    }

    /**
     * Alt изображения
     */
    $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

    if ($alt === '') {
        $alt = get_the_title($attachment_id);
    }

    /**
     * Атрибуты img
     */
    $attributes = [
        'src'      => esc_url($img_1x['url']),
        'srcset'   => esc_attr(implode(', ', $fallback_items)),
        'alt'      => esc_attr($alt),
        'width'    => (int) $img_1x['width'],
        'height'   => (int) $img_1x['height'],
        'decoding' => esc_attr($args['decoding']),
    ];

    if ($args['loading'] !== false && $args['loading'] !== '') {
        $attributes['loading'] = esc_attr($args['loading']);
    }

    if (!empty($args['class'])) {
        $attributes['class'] = esc_attr($args['class']);
    }

    if (!empty($args['fetchpriority'])) {
        $attributes['fetchpriority'] = esc_attr($args['fetchpriority']);
    }

    /**
     * Дополнительные атрибуты
     */
    if (!empty($args['attr']) && is_array($args['attr'])) {
        foreach ($args['attr'] as $key => $value) {
            if ($value !== '' && $value !== null) {
                $attributes[$key] = esc_attr($value);
            }
        }
    }

    /**
     * Собираем HTML
     */
    $html = '<picture>';

    if (!empty($webp_items)) {
        $html .= '<source srcset="' . esc_attr(implode(', ', $webp_items)) . '" type="image/webp">';
    }

    $html .= '<img';

    foreach ($attributes as $name => $value) {
        $html .= sprintf(' %s="%s"', esc_attr($name), $value);
    }

    $html .= '>';

    $html .= '</picture>';

    return $html;
}


/**
 * ============================================================
 * TD IMAGE OUTPUT
 * Старая функция вывода изображений для вёрстки.
 * Нужна, потому что используется в footer.php и других шаблонах.
 * ============================================================
 */

function td_image($attachment_id, $args = []) {
    $attachment_id = (int) $attachment_id;

    if (!$attachment_id || get_post_type($attachment_id) !== 'attachment') {
        return '';
    }

    $defaults = [
        'class'         => '',
        'format'        => '',
        'loading'       => 'lazy',
        'decoding'      => 'async',
        'fetchpriority' => '',
        'attr'          => [],
    ];

    $args = wp_parse_args($args, $defaults);

    $img_1x = td_get_image_size_data($attachment_id, 'td_1x');
    $img_2x = td_get_image_size_data($attachment_id, 'td_2x');
    $img_3x = td_get_image_size_data($attachment_id, 'td_3x');

    if (!$img_1x || !$img_2x || !$img_3x) {
        return '';
    }

    $webp_1x = td_get_image_size_data($attachment_id, 'td_1x_webp');
    $webp_2x = td_get_image_size_data($attachment_id, 'td_2x_webp');
    $webp_3x = td_get_image_size_data($attachment_id, 'td_3x_webp');

    $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

    if ($alt === '') {
        $alt = get_the_title($attachment_id);
    }

    $attributes = [
        'src'      => esc_url($img_1x['url']),
        'srcset'   => esc_attr(
            esc_url($img_1x['url']) . ' 1x, ' .
            esc_url($img_2x['url']) . ' 2x, ' .
            esc_url($img_3x['url']) . ' 3x'
        ),
        'alt'      => esc_attr($alt),
        'width'    => (int) $img_1x['width'],
        'height'   => (int) $img_1x['height'],
        'decoding' => esc_attr($args['decoding']),
    ];

    if ($args['loading'] !== false && $args['loading'] !== '') {
        $attributes['loading'] = esc_attr($args['loading']);
    }

    if (!empty($args['class'])) {
        $attributes['class'] = esc_attr($args['class']);
    }

    if (!empty($args['fetchpriority'])) {
        $attributes['fetchpriority'] = esc_attr($args['fetchpriority']);
    }

    if (!empty($args['attr']) && is_array($args['attr'])) {
        foreach ($args['attr'] as $key => $value) {
            if ($value !== '' && $value !== null) {
                $attributes[$key] = esc_attr($value);
            }
        }
    }

    $render_img = function ($attributes) {
        $html = '<img';

        foreach ($attributes as $name => $value) {
            $html .= sprintf(' %s="%s"', esc_attr($name), $value);
        }

        $html .= '>';

        return $html;
    };

    if ($args['format'] === 'png') {
        return $render_img($attributes);
    }

    if ($args['format'] === 'webp') {
        if (!$webp_1x || !$webp_2x || !$webp_3x) {
            return '';
        }

        $attributes['src'] = esc_url($webp_1x['url']);
        $attributes['srcset'] = esc_attr(
            esc_url($webp_1x['url']) . ' 1x, ' .
            esc_url($webp_2x['url']) . ' 2x, ' .
            esc_url($webp_3x['url']) . ' 3x'
        );

        return $render_img($attributes);
    }

    $html = '<picture>';

    if ($webp_1x && $webp_2x && $webp_3x) {
        $html .= '<source srcset="' . esc_attr(
            esc_url($webp_1x['url']) . ' 1x, ' .
            esc_url($webp_2x['url']) . ' 2x, ' .
            esc_url($webp_3x['url']) . ' 3x'
        ) . '" type="image/webp">';
    }

    $html .= $render_img($attributes);
    $html .= '</picture>';

    return $html;
}



/**
 * ============================================================
 * 1. SEO ДЛЯ СТРАНИЦЫ 404
 * ============================================================
 */

add_action('wp', 'nv_setup_404_seo');

function nv_setup_404_seo() {

    if (!is_404()) {
        return;
    }

    // Title страницы 404
    add_filter('document_title_parts', function ($title) {
        $title['title'] = 'Page Not Found';
        $title['site']  = get_bloginfo('name');

        return $title;
    });

    // Meta-теги страницы 404
    add_action('wp_head', function () {
        echo '<meta name="description" content="Page not found. Please check the address or return to the homepage.">' . "\n";
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    }, 1);
}


/**
 * ============================================================
 * 2. GUTENBERG / ACF БЛОКИ
 * ============================================================
 */

/**
 * Добавляем свою категорию блоков в редактор Gutenberg
 */
add_filter('block_categories_all', 'nv_add_block_category', 10, 2);

function nv_add_block_category($categories, $post) {

    $custom_category = [
        [
            'slug'  => 'neurovision',
            'title' => 'NVGlobal',
            'icon'  => 'visibility',
        ],
    ];

    return array_merge($custom_category, $categories);
}


/**
 * Регистрируем ACF-блоки темы
 */
add_action('acf/init', 'nv_register_acf_blocks');

function nv_register_acf_blocks() {

    if (!function_exists('register_block_type')) {
        return;
    }

    $blocks = [
        'toc',          // Оглавление для записи блога
        'single-image', // Одиночное изображение с подписью
        'two-images',   // Блок с двумя картинками
        'slider',       // Слайдер
        'spoiler',      // Спойлер
        'disclaimer',   // Дисклеймер
        'quote',        // Цитата
        'warning',      // Врезка Warning
        'success',      // Врезка Success
        'note',         // Примечание
        'steps',        // Блок-схема
        'stages',       // Этапы
        'pillar',       // Шкала
        'result',       // Вывод
        'tabs',         // Вкладки
        'code',         // Блок кода
        'faq',          // Вопрос-ответ
        'about',        // Врезка О нас
        'callout',      // Коммерческая врезка
    ];

    foreach ($blocks as $block) {
        register_block_type(get_template_directory() . '/blocks/' . $block);
    }
}


/**
 * ============================================================
 * 3. ЯКОРЯ ДЛЯ ЗАГОЛОВКОВ В СТАТЬЯХ
 * ============================================================
 */

/**
 * Добавляет id к h2, h3, h4 внутри записей блога.
 */
add_filter('the_content', 'nv_add_ids_to_post_headings');

function nv_add_ids_to_post_headings($content) {

    if (!is_singular('post')) {
        return $content;
    }

    return preg_replace_callback(
        '/<h([2-4])([^>]*)>(.*?)<\/h\1>/is',
        function ($matches) {

            $level = $matches[1];
            $attrs = $matches[2];
            $inner = $matches[3];

            // Если id уже есть — не трогаем заголовок
            if (preg_match('/\sid\s*=\s*([\'"]).*?\1/i', $attrs)) {
                return $matches[0];
            }

            $text = trim(wp_strip_all_tags($inner));
            $id   = translit_cyr_to_lat($text);

            if (!$id) {
                return $matches[0];
            }

            return sprintf(
                '<h%s id="%s"%s>%s</h%s>',
                $level,
                esc_attr($id),
                $attrs,
                $inner,
                $level
            );
        },
        $content
    );
}


/**
 * Транслитерация кириллицы в латиницу для якорных ссылок.
 */
function translit_cyr_to_lat($string) {

    $converter = [
        'а' => 'a',  'б' => 'b',  'в' => 'v',   'г' => 'g',   'д' => 'd',
        'е' => 'e',  'ё' => 'yo', 'ж' => 'zh',  'з' => 'z',   'и' => 'i',
        'й' => 'y',  'к' => 'k',  'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',  'п' => 'p',  'р' => 'r',   'с' => 's',   'т' => 't',
        'у' => 'u',  'ф' => 'f',  'х' => 'h',   'ц' => 'c',   'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch','ъ' => '',    'ы' => 'y',   'ь' => '',
        'э' => 'e',  'ю' => 'yu', 'я' => 'ya',

        'А' => 'A',  'Б' => 'B',  'В' => 'V',   'Г' => 'G',   'Д' => 'D',
        'Е' => 'E',  'Ё' => 'Yo', 'Ж' => 'Zh',  'З' => 'Z',   'И' => 'I',
        'Й' => 'Y',  'К' => 'K',  'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',  'П' => 'P',  'Р' => 'R',   'С' => 'S',   'Т' => 'T',
        'У' => 'U',  'Ф' => 'F',  'Х' => 'H',   'Ц' => 'C',   'Ч' => 'Ch',
        'Ш' => 'Sh', 'Щ' => 'Sch','Ъ' => '',    'Ы' => 'Y',   'Ь' => '',
        'Э' => 'E',  'Ю' => 'Yu', 'Я' => 'Ya',
    ];

    $string = strtr($string, $converter);
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    $string = trim($string, '-');

    return $string;
}


/**
 * ============================================================
 * 4. ОГЛАВЛЕНИЕ СТАТЬИ
 * ============================================================
 */

/**
 * Ищет ACF-блок оглавления acf/toc в контенте.
 * Возвращает:
 * - toc     — найденный блок оглавления
 * - content — контент без блока оглавления
 */
function extract_toc_block_from_content($content) {

    $blocks = parse_blocks($content);

    $toc_block  = null;
    $new_blocks = [];

    foreach ($blocks as $block) {

        if (!empty($block['blockName']) && $block['blockName'] === 'acf/toc') {
            $toc_block = $block;
            continue;
        }

        $new_blocks[] = $block;
    }

    return [
        'toc'     => $toc_block,
        'content' => serialize_blocks($new_blocks),
    ];
}


/**
 * ============================================================
 * 5. ПРОСМОТРЫ И ЛАЙКИ ЗАПИСЕЙ
 * ============================================================
 */

/**
 * Делаем поля post_likes и post_views доступными только для чтения в ACF.
 */
add_filter('acf/prepare_field/name=post_likes', 'nv_make_post_stats_readonly');
add_filter('acf/prepare_field/name=post_views', 'nv_make_post_stats_readonly');

function nv_make_post_stats_readonly($field) {
    $field['readonly'] = 1;
    $field['disabled'] = 0;

    return $field;
}


/**
 * При создании новой записи задаём случайные значения просмотров и лайков.
 */
add_action('save_post', 'nv_set_random_post_stats_on_create', 10, 3);

function nv_set_random_post_stats_on_create($post_id, $post, $update) {

    if ($post->post_type !== 'post') {
        return;
    }

    // При обновлении существующей записи значения не меняем
    if ($update) {
        return;
    }

    $likes = get_post_meta($post_id, 'post_likes', true);
    $views = get_post_meta($post_id, 'post_views', true);

    if ($likes === '') {
        update_post_meta($post_id, 'post_likes', rand(10, 30));
    }

    if ($views === '') {
        update_post_meta($post_id, 'post_views', rand(10, 30));
    }
}


/**
 * Увеличивает количество просмотров записи.
 * Один просмотр считается один раз в час для одной записи.
 */
add_action('wp', 'nv_count_post_views');

function nv_count_post_views() {

    if (!is_singular('post')) {
        return;
    }

    $post_id = get_queried_object_id();

    if (!$post_id) {
        return;
    }

    $cookie_key = 'nv_viewed_' . $post_id;

    if (isset($_COOKIE[$cookie_key])) {
        return;
    }

    $views = (int) get_post_meta($post_id, 'post_views', true);
    $views++;

    update_post_meta($post_id, 'post_views', $views);

    setcookie($cookie_key, '1', time() + HOUR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN);
}


/**
 * AJAX: увеличение / уменьшение лайков.
 */
add_action('wp_ajax_nv_update_likes', 'nv_update_likes');
add_action('wp_ajax_nopriv_nv_update_likes', 'nv_update_likes');

function nv_update_likes() {

    if (
        empty($_POST['nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'nv_likes_nonce')
    ) {
        wp_send_json_error(['message' => 'nonce error'], 403);
    }

    $post_id = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
    $mode    = isset($_POST['mode']) ? sanitize_text_field(wp_unslash($_POST['mode'])) : '';

    if (!$post_id || get_post_type($post_id) !== 'post') {
        wp_send_json_error(['message' => 'Post not found'], 404);
    }

    $likes = (int) get_field('post_likes', $post_id);

    if ($mode === 'like') {
        $likes++;
    } elseif ($mode === 'unlike' && $likes > 0) {
        $likes--;
    } else {
        wp_send_json_error(['message' => 'Wrong mode'], 400);
    }

    update_field('post_likes', $likes, $post_id);

    wp_send_json_success([
        'likes' => $likes,
    ]);
}


/**
 * ============================================================
 * 6. ХЛЕБНЫЕ КРОШКИ
 * ============================================================
 */

/**
 * Хлебные крошки:
 * Main / Blog / Category / Current post
 * Main / Documentations / Parent document / Current document
 */
function nv_breadcrumbs() {
    global $post;

    if (is_home() || is_front_page()) {
        return;
    }

    if ( ! $post instanceof WP_Post ) {
        return;
    }

    if ( 'document' === $post->post_type ) {
        $ancestors = array_reverse( get_post_ancestors( $post ) );

        echo '<nav class="breadcrumbs__nav" aria-label="Breadcrumb">';
        echo '<a class="breadcrumbs__link" href="' . esc_url( home_url( '/' ) ) . '">Main</a>';
        echo ' <span class="breadcrumbs__sep">/</span> ';
        echo '<a class="breadcrumbs__link" href="' . esc_url( home_url( '/docs/' ) ) . '">Documentations</a>';

        foreach ( $ancestors as $ancestor_id ) {
            echo ' <span class="breadcrumbs__sep">/</span> ';
            echo '<a class="breadcrumbs__link" href="' . esc_url( get_permalink( $ancestor_id ) ) . '">';
            echo esc_html( get_the_title( $ancestor_id ) );
            echo '</a>';
        }

        echo ' <span class="breadcrumbs__sep">/</span> ';
        echo '<span class="breadcrumbs__current">' . esc_html( get_the_title( $post ) ) . '</span>';
        echo '</nav>';

        return;
    }

    if ( ! is_singular( 'post' ) ) {
        return;
    }

    echo '<nav class="breadcrumbs__nav" aria-label="Breadcrumb">';

    // Главная
    echo '<a class="breadcrumbs__link" href="' . esc_url(home_url('/')) . '">Main</a>';

    // Страница записи
    if (is_singular('post')) {

        // Блог
        echo ' <span class="breadcrumbs__sep">/</span> <a class="breadcrumbs__link" href="' . esc_url(home_url('/blog/')) . '">Blog</a>';

        // Категория
        $categories = get_the_category();

        if (!empty($categories)) {

            // Берём первую категорию
            $category = $categories[0];

            echo ' <span class="breadcrumbs__sep">/</span> <a class="breadcrumbs__link" href="' . esc_url(get_category_link($category->term_id)) . '">';
            echo esc_html($category->name);
            echo '</a>';
        }

        // Текущая запись
        echo ' <span class="breadcrumbs__sep">/</span> <span class="breadcrumbs__current">' . esc_html(get_the_title()) . '</span>';
    }

    echo '</nav>';
}

function nv_has_content($value): bool {
  return trim(strip_tags((string) $value)) !== '';
}




/**
 * Добавляет поле "Должность" в профиль пользователя (страницы редактирования профиля).
 *
 * Выводится:
 *   - в профиле текущего пользователя (show_user_profile)
 *   - в админке при редактировании любого пользователя (edit_user_profile)
 *
 * @param WP_User $user Текущий пользователь.
 */
add_action( 'show_user_profile', 'nv_user_job_title_field' );
add_action( 'edit_user_profile', 'nv_user_job_title_field' );
function nv_user_job_title_field( $user ) {
    ?>
    <h3>Информация о должности</h3>
    <table class="form-table">
        <tr>
            <th><label for="job_title">Должность</label></th>
            <td>
                <input type="text"
                       name="job_title"
                       id="job_title"
                       class="regular-text"
                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'job_title', true ) ); ?>"
                />
                <p class="description">Укажите должность пользователя (например: «Менеджер проектов»).</p>
            </td>
        </tr>
    </table>
    <?php
}


/**
 * Сохраняет значение поля "Должность" при обновлении профиля.
 *
 * Работает как:
 *   - при редактировании своего профиля (personal_options_update)
 *   - при редактировании других пользователей (edit_user_profile_update)
 *
 * @param int $user_id ID пользователя.
 */
add_action( 'personal_options_update', 'nv_save_job_title_field' );
add_action( 'edit_user_profile_update', 'nv_save_job_title_field' );
function nv_save_job_title_field( $user_id ) {

    // Защита: проверяем права
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    if ( isset( $_POST['job_title'] ) ) {
        update_user_meta(
            $user_id,
            'job_title',
            sanitize_text_field( $_POST['job_title'] )
        );
    }
}


/**
 * Author block для single post (новый шаблон).
 */
function get_post_author_card_html() {

    $post_id = get_the_ID();

    if (!$post_id) {
        return '';
    }

    $author_id = (int) get_post_field('post_author', $post_id);

    if (!$author_id) {
        return '';
    }

    // Имя автора
    $first_name = trim((string) get_user_meta($author_id, 'first_name', true));
    $last_name  = trim((string) get_user_meta($author_id, 'last_name', true));

    $full_name = trim($first_name . ' ' . $last_name);

    if ($full_name === '') {
        $full_name = get_the_author_meta('display_name', $author_id);
    }

    // Должность
    $job_title = trim((string) get_user_meta($author_id, 'job_title', true));

    // Ссылка на автора
    $author_url = get_author_posts_url($author_id);

    // Количество статей
    $posts_count = (int) count_user_posts($author_id, 'post', true);

    // Аватар
    $avatar_html = get_avatar(
        $author_id,
        120,
        '',
        $full_name,
        [
            'class' => 'post__author-avatar-img',
        ]
    );

    // Fallback
    if (!$avatar_html) {
        $fallback = get_template_directory_uri() . '/assets/images/author_image.jpg';

        $avatar_html = sprintf(
            '<img src="%s" alt="%s" class="post__author-avatar-img">',
            esc_url($fallback),
            esc_attr($full_name)
        );
    }

    ob_start();
    ?>

    <div class="post__author">
        <div class="post__author-top">
            <div class="post__author-title">Author</div>
            <div class="post__author-content">
                <div class="post__author-image"><?php echo $avatar_html; ?></div>
                <div class="post__author-info">
                    <div class="post__author-name"><?php echo esc_html($full_name); ?></div>
                    <?php if (!empty($job_title)) : ?>
                        <div class="post__author-job"><?php echo esc_html($job_title); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="post__author-bottom">
            <div class="post__author-articles">
                <p>Other articles <span><?php echo (int) $posts_count; ?></span></p>
            </div>
            <div class="post__author-action">
                <a href="<?php echo esc_url($author_url); ?>" class="btn btn-with-lottie-arrow">
                    <span class="btn__text">See</span>
                    <span class="btn__icon lottie-container-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M13.0391 5.34577C13.2356 4.98115 13.691 4.84455 14.0557 5.04108H14.0566L14.0576 5.04206C14.0586 5.04258 14.0599 5.04315 14.0615 5.04401C14.065 5.0459 14.0699 5.04939 14.0762 5.0528C14.0888 5.05971 14.1076 5.06919 14.1309 5.0821C14.1779 5.10816 14.2463 5.14636 14.332 5.19538C14.5035 5.29337 14.7468 5.43611 15.0381 5.6153C15.6193 5.97281 16.3988 6.48146 17.1816 7.0821C17.96 7.67933 18.766 8.38643 19.3848 9.14362C19.989 9.88314 20.5 10.7738 20.5 11.7247L20.4941 11.9014C20.436 12.7859 19.9524 13.6129 19.3857 14.3067C18.767 15.0643 17.96 15.7707 17.1816 16.3682C16.3987 16.9692 15.6193 17.4784 15.0381 17.836C14.7467 18.0153 14.5035 18.1579 14.332 18.2559C14.2463 18.305 14.1779 18.3431 14.1309 18.3692C14.1079 18.382 14.0898 18.3916 14.0771 18.3985C14.0708 18.402 14.0651 18.4054 14.0615 18.4073C14.0599 18.4081 14.0586 18.4087 14.0576 18.4092L14.0566 18.4102H14.0557C13.6911 18.6068 13.2357 18.471 13.0391 18.1065C12.8425 17.7419 12.9792 17.2865 13.3438 17.0899C13.3442 17.0897 13.3455 17.0896 13.3467 17.0889C13.349 17.0877 13.3525 17.0857 13.3574 17.0831C13.3676 17.0775 13.3835 17.0682 13.4043 17.0567C13.4459 17.0337 13.5075 16.9986 13.5869 16.9532C13.7463 16.862 13.9761 16.7284 14.252 16.5587C14.805 16.2184 15.5381 15.7387 16.2676 15.1788C17.0016 14.6153 17.7081 13.9888 18.2236 13.3575C18.4832 13.0397 18.6739 12.7444 18.8018 12.4757H4.75C4.33579 12.4757 4 12.1399 4 11.7257C4.00002 11.3115 4.3358 10.9757 4.75 10.9757H18.8027C18.675 10.7066 18.4837 10.4112 18.2236 10.0928C17.7081 9.46192 17.0026 8.83475 16.2686 8.27155C15.539 7.71176 14.8051 7.23288 14.252 6.89264C13.9764 6.72316 13.7473 6.58922 13.5879 6.49811C13.5083 6.45264 13.4459 6.41766 13.4043 6.3946C13.3836 6.38312 13.3676 6.37476 13.3574 6.36921C13.3524 6.36645 13.349 6.36361 13.3467 6.36237C13.3455 6.36175 13.3442 6.36162 13.3438 6.36139C12.9794 6.16492 12.8429 5.71028 13.0391 5.34577Z" fill="#2B323B"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <?php

    return ob_get_clean();
}


/**
 * Вывод 3 последних записей текущего автора
 * (исключая текущую запись).
 */
function get_post_author_articles_html() {

    $post_id = get_the_ID();

    if (!$post_id) {
        return '';
    }

    $author_id = (int) get_post_field('post_author', $post_id);

    if (!$author_id) {
        return '';
    }

    $posts = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'author'         => $author_id,
        'post__not_in'   => [$post_id],
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    if (empty($posts)) {
        return '';
    }

    ob_start();
    ?>

    <div class="post__articles">

        <div class="post__articles-title">
            Check out other articles
        </div>

        <div class="post__articles-list">

            <?php foreach ($posts as $post) : ?>

                <?php
                $article_id    = $post->ID;
                $article_title = get_the_title($article_id);
                $article_url   = get_permalink($article_id);

                $thumbnail = get_the_post_thumbnail(
                    $article_id,
                    'medium',
                    [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                    ]
                );

                if (!$thumbnail) {
                    $fallback = get_template_directory_uri() . '/assets/images/post-placeholder.jpg';

                    $thumbnail = sprintf(
                        '<img src="%s" alt="%s" loading="lazy" decoding="async">',
                        esc_url($fallback),
                        esc_attr($article_title)
                    );
                }
                ?>

                <div class="post__article-item">

                    <div class="post__article-image">
                        <?php echo $thumbnail; ?>
                    </div>

                    <a href="<?php echo esc_url($article_url); ?>" class="post__article-title">
                        <?php echo esc_html($article_title); ?>
                    </a>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <?php

    wp_reset_postdata();

    return ob_get_clean();
}


// Поиск записей блога на странице блога
add_action('wp_ajax_nv_blog_search', 'nv_blog_search');
add_action('wp_ajax_nopriv_nv_blog_search', 'nv_blog_search');

function nv_blog_search() {

    if (
        empty($_POST['nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'nv_blog_search_nonce')
    ) {
        wp_send_json_error(['message' => 'Nonce error'], 403);
    }

    $search = isset($_POST['search'])
        ? sanitize_text_field(wp_unslash($_POST['search']))
        : '';

    $query = new WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        's'              => $search,
    ]);

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();?>

            <?php get_template_part('template-parts/article-card'); ?>

            <?php
        endwhile;
    else :
        ?>

        <div class="blog-page__not-found">
            Nothing found
        </div>

        <?php
    endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
    ]);
}

// Подгрузка постов при нажатии на кнопку "Show More"
add_action('wp_ajax_nv_load_more_posts', 'nv_load_more_posts');
add_action('wp_ajax_nopriv_nv_load_more_posts', 'nv_load_more_posts');

function nv_load_more_posts() {

    if (
        empty($_POST['nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'nv_load_more_posts_nonce')
    ) {
        wp_send_json_error(['message' => 'Nonce error'], 403);
    }

    $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $next_page = $page + 1;

    $query = new WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'paged'          => $next_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();

            get_template_part('template-parts/article-card');

        endwhile;
    endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html'      => ob_get_clean(),
        'page'      => $next_page,
        'max_pages' => (int) $query->max_num_pages,
        'has_more'  => $next_page < (int) $query->max_num_pages,
    ]);
}



// Перевод надписей страницы автора
/**
 * Переводим Slack labels Yoast SEO на английский.
 */
add_filter('wpseo_enhanced_slack_data', 'nv_translate_yoast_slack_labels');

function nv_translate_yoast_slack_labels($data) {

    if (empty($data) || !is_array($data)) {
        return $data;
    }

    $new_data = [];

    foreach ($data as $label => $value) {

        if (
            $label === 'Написано автором' ||
            $label === 'Автор' ||
            stripos($label, 'автор') !== false
        ) {
            $new_data['Written by'] = $value;
            continue;
        }

        if (
            $label === 'Примерное время для чтения' ||
            stripos($label, 'время') !== false ||
            stripos($label, 'чтения') !== false
        ) {
            $new_data['Est. reading time'] = $value;
            continue;
        }

        $new_data[$label] = $value;
    }

    return $new_data;
}
