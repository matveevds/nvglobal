<?php
/*
Template Name: Шаблон страницы Documentation
Template Post Type: page
*/

get_header();

$document_id   = 588;
$document_post = get_post( $document_id );

if ( ! function_exists( 'nv_docs_flatten_document_tree' ) ) {
	function nv_docs_flatten_document_tree( $parent_id, $children, &$flat ) {
		if ( empty( $children[ $parent_id ] ) ) {
			return;
		}

		foreach ( $children[ $parent_id ] as $document ) {
			$flat[] = $document;
			nv_docs_flatten_document_tree( (int) $document->ID, $children, $flat );
		}
	}
}

if ( ! function_exists( 'nv_docs_get_adjacent_documents' ) ) {
	function nv_docs_get_adjacent_documents( $current_id ) {
		$documents = get_pages(
			array(
				'post_type'   => 'document',
				'post_status' => 'publish',
				'sort_column' => 'menu_order,post_title',
				'sort_order'  => 'ASC',
			)
		);

		if ( empty( $documents ) ) {
			return array( null, null );
		}

		$children = array();
		foreach ( $documents as $document ) {
			$parent_id = (int) $document->post_parent;
			if ( ! isset( $children[ $parent_id ] ) ) {
				$children[ $parent_id ] = array();
			}

			$children[ $parent_id ][] = $document;
		}

		$flat = array();
		nv_docs_flatten_document_tree( 0, $children, $flat );

		foreach ( $flat as $index => $document ) {
			if ( (int) $document->ID !== (int) $current_id ) {
				continue;
			}

			return array(
				$flat[ $index - 1 ] ?? null,
				$flat[ $index + 1 ] ?? null,
			);
		}

		return array( null, null );
	}
}

if ( ! function_exists( 'nv_docs_render_bottom_nav' ) ) {
	function nv_docs_render_bottom_nav( $current_id ) {
		list( $previous_document, $next_document ) = nv_docs_get_adjacent_documents( $current_id );

		if ( ! $previous_document && ! $next_document ) {
			return '';
		}

		$previous_label = 'Prev';
		$next_label     = 'Next';

		ob_start();
		?>
		<nav class="document-bottom-nav" aria-label="<?php esc_attr_e( 'Навигация по документам', 'nvglobal' ); ?>">
			<?php if ( $previous_document ) : ?>
				<a href="<?php echo esc_url( get_permalink( $previous_document ) ); ?>" class="btn btn3 btn-outline document-bottom-nav__link document-bottom-nav__link--prev">
					<span><?php echo esc_html( $previous_label ); ?></span>
				</a>
			<?php else : ?>
				<span class="document-bottom-nav__spacer" aria-hidden="true"></span>
			<?php endif; ?>

			<?php if ( $next_document ) : ?>
				<a href="<?php echo esc_url( get_permalink( $next_document ) ); ?>" class="btn btn3 btn-outline document-bottom-nav__link document-bottom-nav__link--next">
					<span><?php echo esc_html( $next_label ); ?></span>
				</a>
			<?php else : ?>
				<span class="document-bottom-nav__spacer" aria-hidden="true"></span>
			<?php endif; ?>
		</nav>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'nv_docs_render_document_sidebar_menu' ) ) {
	function nv_docs_render_document_sidebar_menu() {
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
			$parent_id = (int) $document->post_parent;

			if ( ! isset( $children[ $parent_id ] ) ) {
				$children[ $parent_id ] = array();
			}

			$children[ $parent_id ][] = $document;
		}

		return '<nav class="toc-block"><ol class="toc-block__list toc-level-2">' . nv_docs_render_document_sidebar_menu_level( 0, $children, array() ) . '</ol></nav>';
	}
}

if ( ! function_exists( 'nv_docs_render_document_sidebar_menu_level' ) ) {
	function nv_docs_render_document_sidebar_menu_level( $parent_id, $children, $number_path ) {
		if ( empty( $children[ $parent_id ] ) ) {
			return '';
		}

		$html  = '';
		$index = 1;

		foreach ( $children[ $parent_id ] as $document ) {
			$current_path = array_merge( $number_path, array( $index ) );
			$level        = count( $current_path ) > 1 ? 3 : 2;
			$is_current   = ( get_the_ID() === (int) $document->ID ) ? ' aria-current="page"' : '';

			$html .= sprintf(
				'<li class="toc-block__item toc-block__item--level-%1$d"><div class="toc-block__row"><a href="%2$s"%3$s>%4$s</a></div>',
				$level,
				esc_url( get_permalink( $document ) ),
				$is_current,
				esc_html( get_the_title( $document ) )
			);

			if ( ! empty( $children[ $document->ID ] ) ) {
				$html .= '<ol class="toc-level-3">' . nv_docs_render_document_sidebar_menu_level( (int) $document->ID, $children, $current_path ) . '</ol>';
			}

			$html .= '</li>';

			$index++;
		}

		return $html;
	}
}

if ( ! function_exists( 'nv_docs_render_child_links' ) ) {
	function nv_docs_render_child_links( $parent_id ) {
		$child_documents = get_pages(
			array(
				'post_type'   => 'document',
				'post_status' => 'publish',
				'parent'      => (int) $parent_id,
				'sort_column' => 'menu_order,post_title',
				'sort_order'  => 'ASC',
			)
		);

		if ( empty( $child_documents ) ) {
			return '';
		}

		$html = '';
		foreach ( $child_documents as $child_document ) {
			$html .= sprintf(
				'<li class="document-child-links__item"><a href="%1$s">%2$s</a></li>',
				esc_url( get_permalink( $child_document ) ),
				esc_html( get_the_title( $child_document ) )
			);
		}

		if ( '' === $html ) {
			return '';
		}

		return '<div class="document-child-links"><ul class="document-child-links__list">' . $html . '</ul></div>';
	}
}

if ( ! function_exists( 'nv_document_add_heading_ids' ) ) {
	function nv_document_add_heading_ids( $content ) {
		return preg_replace_callback(
			'/<h([2-4])([^>]*)>(.*?)<\/h\1>/is',
			function ( $matches ) {
				if ( preg_match( '/\sid\s*=\s*([\'"]).*?\1/i', $matches[2] ) ) {
					return $matches[0];
				}

				$text = trim( wp_strip_all_tags( $matches[3] ) );
				$id   = function_exists( 'translit_cyr_to_lat' ) ? translit_cyr_to_lat( $text ) : sanitize_title( $text );

				if ( ! $id ) {
					return $matches[0];
				}

				return sprintf( '<h%1$s id="%2$s"%3$s>%4$s</h%1$s>', $matches[1], esc_attr( $id ), $matches[2], $matches[3] );
			},
			$content
		);
	}
}

if ( ! function_exists( 'nv_docs_page_breadcrumbs' ) ) {
	function nv_docs_page_breadcrumbs() {
		?>
		<nav class="breadcrumbs__nav" aria-label="<?php esc_attr_e( 'Breadcrumb', 'nvglobal' ); ?>">
			<a class="breadcrumbs__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Main</a>
			<span class="breadcrumbs__sep">/</span>
			<span class="breadcrumbs__current">Documentations</span>
		</nav>
		<?php
	}
}

if (
	! $document_post ||
	'document' !== $document_post->post_type ||
	'publish' !== $document_post->post_status
) :
	?>
	<main class="main-post">
		<section class="post">
			<div class="container">
				<div class="post__wrapper">
					<div class="breadcrumbs">
						<?php nv_docs_page_breadcrumbs(); ?>
					</div>

					<div class="post__content">
						<article class="post-content">
							<div class="post__header">
								<h1 class="post-title"><?php esc_html_e( 'Documentation', 'nvglobal' ); ?></h1>
							</div>
							<div class="post-text entry-content">
								<p><?php esc_html_e( 'The document for this page was not found.', 'nvglobal' ); ?></p>
							</div>
						</article>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php
	get_footer();
	return;
endif;

global $post;

$original_post = $post;
$post          = $document_post;
setup_postdata( $post );

$content           = get_the_content( null, false, $document_post );
$data              = extract_toc_block_from_content( $content );
?>

<div class="sidebar-overlay"></div>
<main class="main-post single-doc">
	<section class="post">
		<div class="container">
			<div class="post__wrapper">
				<div class="breadcrumbs">
					<?php nv_docs_page_breadcrumbs(); ?>
				</div>

				<div class="post__content">
					<button class="post-sidebar-btn-mobile" aria-label="<?php esc_attr_e( 'Toggle table of contents', 'nvglobal' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M10.0137 5.55638C10.3648 5.41074 10.7767 5.55248 10.9609 5.89427C11.1571 6.25876 11.0206 6.71341 10.6562 6.90989C9.19501 7.78144 6.29193 10.011 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5894 5.77637 13.9079C6.29187 14.5388 9.19491 16.7669 10.6562 17.6384C11.0206 17.8349 11.1571 18.2895 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919C8.96191 18.3845 6.81836 16.9177 4.61523 14.8562C4.04864 14.1628 3.5 13.337 3.5 12.2742C3.5 11.3213 4.01126 10.4325 4.61426 9.69407C6.03997 8.22909 8.38067 6.52145 10.0137 5.55638Z" fill="#2B323B"/>
						</svg>
					</button>

					<aside class="post-sidebar">
						<button class="post-sidebar-btn" aria-label="<?php esc_attr_e( 'Toggle table of contents', 'nvglobal' ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M10.0137 5.55638C10.3648 5.41074 10.7767 5.55248 10.9609 5.89427C11.1571 6.25876 11.0206 6.71341 10.6562 6.90989C9.19501 7.78144 6.29193 10.011 5.77637 10.6423C5.51686 10.9601 5.32608 11.2554 5.19824 11.5242H19.25C19.6642 11.5242 19.9999 11.86 20 12.2742C20 12.6884 19.6642 13.0242 19.25 13.0242H5.19727C5.32507 13.2933 5.51611 13.5894 5.77637 13.9079C6.29187 14.5388 9.19491 16.7669 10.6562 17.6384C11.0206 17.8349 11.1571 18.2895 10.9609 18.655C10.7766 18.9968 10.3648 19.1376 10.0137 18.9919C8.96191 18.3845 6.81836 16.9177 4.61523 14.8562C4.04864 14.1628 3.5 13.337 3.5 12.2742C3.5 11.3213 4.01126 10.4325 4.61426 9.69407C6.03997 8.22909 8.38067 6.52145 10.0137 5.55638Z" fill="#2B323B"/>
							</svg>
						</button>
						<div class="post-sidebar__wrapper">
							<?php echo nv_docs_render_document_sidebar_menu(); ?>
						</div>
					</aside>

					<article id="post-<?php echo esc_attr( $document_id ); ?>" <?php post_class( 'post-content', $document_id ); ?> itemscope itemtype="https://schema.org/Article">
						<div class="post__header">
							<h1 class="post-title" itemprop="headline"><?php echo esc_html( get_the_title( $document_post ) ); ?></h1>
						</div>

						<div class="post-text entry-content" itemprop="articleBody">
							<?php echo nv_document_add_heading_ids( apply_filters( 'the_content', $data['content'] ) ); ?>
							<?php echo nv_docs_render_child_links( $document_id ); ?>
						</div>

						<?php echo nv_docs_render_bottom_nav( $document_id ); ?>
					</article>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
wp_reset_postdata();
$post = $original_post;

get_footer();
