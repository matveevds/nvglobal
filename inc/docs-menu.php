<?php
/**
 * Боковое меню документации: сборка дерева, файловый кэш и его инвалидация.
 *
 * Меню одинаково для всех страниц раздела /docs/, поэтому собирается один раз
 * и хранится готовым HTML в uploads. Текущий пункт помечается при выводе.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const NV_DOCS_MENU_DIR  = 'nv-docs-cache';
const NV_DOCS_MENU_FILE = 'menu.html';

/**
 * Путь к файлу кэша. null, если каталог недоступен для записи.
 */
function nv_docs_menu_cache_path() {
	$uploads = wp_get_upload_dir();

	if ( ! empty( $uploads['error'] ) ) {
		return null;
	}

	$dir = trailingslashit( $uploads['basedir'] ) . NV_DOCS_MENU_DIR;

	if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) {
		return null;
	}

	return trailingslashit( $dir ) . NV_DOCS_MENU_FILE;
}

/**
 * Собирает дерево документов в HTML.
 *
 * aria-current здесь не проставляется: меню общее для всех страниц,
 * текущий пункт помечает nv_docs_menu_render().
 */
function nv_docs_menu_build() {
	$documents = get_pages(
		array(
			'post_type'   => 'document',
			'post_status' => 'publish',
			'sort_column' => 'menu_order,post_title',
			'sort_order'  => 'ASC',
		)
	);

	if ( empty( $documents ) ) {
		return '';
	}

	$children = array();

	foreach ( $documents as $document ) {
		$children[ (int) $document->post_parent ][] = $document;
	}

	return '<nav class="toc-block"><ol class="toc-block__list toc-level-2">'
		. nv_docs_menu_build_level( 0, $children, 1 )
		. '</ol></nav>';
}

/**
 * Один уровень дерева.
 *
 * $depth — реальная глубина вложенности. Класс уровня упирается в 5,
 * потому что дальше в document-toc.css отдельных правил нет.
 */
function nv_docs_menu_build_level( $parent_id, $children, $depth ) {
	if ( empty( $children[ $parent_id ] ) ) {
		return '';
	}

	$html  = '';
	$level = min( $depth + 1, 5 );

	foreach ( $children[ $parent_id ] as $document ) {
		$html .= sprintf(
			'<li class="toc-block__item toc-block__item--level-%1$d"><div class="toc-block__row"><a href="%2$s">%3$s</a></div>',
			$level,
			esc_url( get_permalink( $document ) ),
			esc_html( get_the_title( $document ) )
		);

		if ( ! empty( $children[ $document->ID ] ) ) {
			$html .= '<ol class="toc-level-' . min( $depth + 2, 5 ) . '">'
				. nv_docs_menu_build_level( (int) $document->ID, $children, $depth + 1 )
				. '</ol>';
		}

		$html .= '</li>';
	}

	return $html;
}

/**
 * Отдаёт меню из кэша, при промахе собирает и записывает.
 */
function nv_docs_menu_get() {
	$path = nv_docs_menu_cache_path();

	if ( $path && is_readable( $path ) ) {
		$cached = file_get_contents( $path );

		if ( false !== $cached && '' !== $cached ) {
			return $cached;
		}
	}

	$html = nv_docs_menu_build();

	if ( $path && '' !== $html && false === file_put_contents( $path, $html, LOCK_EX ) ) {
		error_log( 'nv_docs_menu: не удалось записать кэш меню в ' . $path );
	}

	return $html;
}

/**
 * Меню для вывода в шаблоне: помечает текущую страницу.
 *
 * @param int $current_id ID документа. По умолчанию — текущий пост.
 */
function nv_docs_menu_render( $current_id = 0 ) {
	$html = nv_docs_menu_get();

	if ( '' === $html ) {
		return '';
	}

	$current_id = $current_id ? (int) $current_id : (int) get_the_ID();

	if ( ! $current_id ) {
		return $html;
	}

	$current_url = esc_url( get_permalink( $current_id ) );

	return str_replace(
		'<a href="' . $current_url . '">',
		'<a href="' . $current_url . '" aria-current="page">',
		$html
	);
}

/**
 * Сброс кэша меню.
 */
function nv_docs_menu_flush() {
	$path = nv_docs_menu_cache_path();

	if ( $path && file_exists( $path ) ) {
		wp_delete_file( $path );
	}

	/**
	 * Меню встроено в HTML всех страниц раздела, поэтому вместе с фрагментом
	 * нужно сбрасывать и полностраничный кэш. Точку расширения оставляем здесь.
	 */
	do_action( 'nv_docs_menu_flushed' );
}

/**
 * Сброс при любом изменении документа.
 */
function nv_docs_menu_flush_for_post( $post_id, $post = null ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}

	$post_type = $post instanceof WP_Post ? $post->post_type : get_post_type( $post_id );

	if ( 'document' !== $post_type ) {
		return;
	}

	nv_docs_menu_flush();
}

add_action( 'save_post_document', 'nv_docs_menu_flush_for_post', 10, 2 );
add_action( 'deleted_post', 'nv_docs_menu_flush_for_post', 10, 2 );
add_action( 'trashed_post', 'nv_docs_menu_flush_for_post', 10, 1 );
add_action( 'untrashed_post', 'nv_docs_menu_flush_for_post', 10, 1 );
add_action( 'permalink_structure_changed', 'nv_docs_menu_flush' );
