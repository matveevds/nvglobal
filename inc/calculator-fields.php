<?php
/**
 * ACF-поля с ценами пакетов для калькулятора на /pricing-matrix/.
 *
 * Регистрируются из кода, а не через админку: так тарифная сетка переносится
 * вместе с темой и не требует ручного пересоздания полей на другом сайте.
 * Значения вводятся в админке страницы; пока поля пустые, калькулятор
 * работает на значениях по умолчанию из nv_calculator_default_prices().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Цены по умолчанию — те же, что были захардкожены в calculate.js.
 *
 * @return array<string, array<string, float>>
 */
function nv_calculator_default_prices() {
	return array(
		'document' => array(
			'10k'  => 0.24,
			'50k'  => 0.22,
			'100k' => 0.20,
		),
		'basic' => array(
			'10k'  => 0.44,
			'50k'  => 0.41,
			'100k' => 0.39,
		),
	);
}

/**
 * Нормализует введённое значение цены.
 *
 * Принимает и «0,24», и «0.24», и пустоту. Возвращает строку с двумя-тремя
 * знаками после точки — в таком виде цена уходит в data-атрибут.
 */
function nv_calculator_format_price( $value, $fallback ) {
	$value = is_string( $value ) ? str_replace( ',', '.', trim( $value ) ) : $value;
	$value = is_numeric( $value ) ? (float) $value : (float) $fallback;

	$price = rtrim( rtrim( number_format( $value, 3, '.', '' ), '0' ), '.' );

	if ( strpos( $price, '.' ) === false ) {
		return $price . '.00';
	}

	if ( strlen( substr( strrchr( $price, '.' ), 1 ) ) < 2 ) {
		$price .= '0';
	}

	return $price;
}

/**
 * Цена пакета на опорном объёме: из ACF, иначе значение по умолчанию.
 *
 * @param string $package 'document' или 'basic'.
 * @param string $point   '10k', '50k' или '100k'.
 */
function nv_calculator_package_price( $package, $point ) {
	$defaults = nv_calculator_default_prices();
	$fallback = $defaults[ $package ][ $point ] ?? 0;
	$value    = function_exists( 'get_field' ) ? get_field( "calc_{$package}_price_{$point}" ) : null;

	return nv_calculator_format_price( $value, $fallback );
}

/**
 * Регистрация группы полей.
 */
function nv_calculator_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$defaults = nv_calculator_default_prices();
	$fields   = array();

	$labels = array(
		'document' => 'DOCUMENT',
		'basic'    => 'BASIC',
	);

	$points = array(
		'10k'  => '10 000 проверок в год',
		'50k'  => '50 000 проверок в год',
		'100k' => '100 000 проверок в год',
	);

	foreach ( $labels as $package => $package_label ) {
		$fields[] = array(
			'key'   => "field_nv_calc_{$package}_tab",
			'label' => 'Пакет ' . $package_label,
			'type'  => 'tab',
		);

		foreach ( $points as $point => $point_label ) {
			$fields[] = array(
				'key'           => "field_nv_calc_{$package}_{$point}",
				'label'         => $package_label . ' — ' . $point_label,
				'name'          => "calc_{$package}_price_{$point}",
				'type'          => 'number',
				'instructions'  => 'Цена за одну проверку в долларах. Пусто — используется ' . $defaults[ $package ][ $point ] . '.',
				'min'           => 0,
				'step'          => 0.001,
				'placeholder'   => (string) $defaults[ $package ][ $point ],
				'prepend'       => '$',
				'wrapper'       => array( 'width' => '33' ),
			);
		}
	}

	$fields[] = array(
		'key'     => 'field_nv_calc_liveness_note',
		'label'   => 'Пакет LIVENESS',
		'type'    => 'message',
		'message' => 'Цена пакета LIVENESS не вводится: она вычисляется как разница BASIC минус DOCUMENT на каждом из трёх объёмов. При правке цен выше тариф Liveness пересчитывается автоматически.',
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_nv_calculator_prices',
			'title'                 => 'Калькулятор: цены пакетов',
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-price-matrix.php',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'active'                => true,
			'description'           => 'Опорные точки тарифной сетки. Между ними калькулятор считает цену линейной интерполяцией.',
			'show_in_rest'          => false,
		)
	);
}
add_action( 'acf/init', 'nv_calculator_register_fields' );
