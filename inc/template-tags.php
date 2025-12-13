<?php
/**
 * Custom template tags for this theme
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display poem metadata.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 */
function versalia_poem_meta( ?int $post_id = null ): void {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'poem' !== get_post_type( $post_id ) ) {
		return;
	}

	get_template_part( 'template-parts/poem/poem', 'meta', array( 'post_id' => $post_id ) );
}

/**
 * Get poem date written.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @return string Date written or empty string.
 */
function versalia_get_poem_date_written( ?int $post_id = null ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$date_written = get_post_meta( $post_id, 'poem_date_written', true );
	return $date_written ? sanitize_text_field( $date_written ) : '';
}

/**
 * Display poem date written.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 */
function versalia_poem_date_written( ?int $post_id = null ): void {
	$date_written = versalia_get_poem_date_written( $post_id );
	if ( $date_written ) {
		printf(
			'<span class="poem-date-written">%s</span>',
			esc_html( $date_written )
		);
	}
}

/**
 * Get poem dedication.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @return string Dedication text or empty string.
 */
function versalia_get_poem_dedication( ?int $post_id = null ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$dedication = get_post_meta( $post_id, 'poem_dedication', true );
	return $dedication ? sanitize_text_field( $dedication ) : '';
}

/**
 * Display poem dedication.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 */
function versalia_poem_dedication( ?int $post_id = null ): void {
	$dedication = versalia_get_poem_dedication( $post_id );
	if ( $dedication ) {
		printf(
			'<div class="poem-dedication"><em>%s</em></div>',
			esc_html( $dedication )
		);
	}
}

/**
 * Get poem epigraph.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @return array Epigraph data with 'text' and 'attribution' keys.
 */
function versalia_get_poem_epigraph( ?int $post_id = null ): array {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$epigraph    = get_post_meta( $post_id, 'poem_epigraph', true );
	$attribution = get_post_meta( $post_id, 'poem_epigraph_attribution', true );

	return array(
		'text'        => $epigraph ? sanitize_text_field( $epigraph ) : '',
		'attribution' => $attribution ? sanitize_text_field( $attribution ) : '',
	);
}

/**
 * Display poem epigraph.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 */
function versalia_poem_epigraph( ?int $post_id = null ): void {
	$epigraph = versalia_get_poem_epigraph( $post_id );

	if ( $epigraph['text'] ) {
		echo '<div class="poem-epigraph">';
		printf( '<blockquote><em>%s</em></blockquote>', esc_html( $epigraph['text'] ) );
		if ( $epigraph['attribution'] ) {
			printf( '<cite>— %s</cite>', esc_html( $epigraph['attribution'] ) );
		}
		echo '</div>';
	}
}

/**
 * Get poem reading time.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @return int Reading time in minutes.
 */
function versalia_get_poem_reading_time( ?int $post_id = null ): int {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$reading_time = get_post_meta( $post_id, 'poem_reading_time', true );
	return $reading_time ? absint( $reading_time ) : 0;
}

/**
 * Display poem reading time.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 */
function versalia_poem_reading_time( ?int $post_id = null ): void {
	$reading_time = versalia_get_poem_reading_time( $post_id );
	if ( $reading_time ) {
		printf(
			/* translators: %s: Reading time in minutes */
			'<span class="poem-reading-time">%s</span>',
			sprintf(
				_n( '%s min read', '%s min read', $reading_time, 'versalia' ),
				number_format_i18n( $reading_time )
			)
		);
	}
}

/**
 * Display poetry forms for a poem.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @param string   $before  Content before the forms.
 * @param string   $sep     Separator between forms.
 * @param string   $after   Content after the forms.
 */
function versalia_poetry_forms( ?int $post_id = null, string $before = '', string $sep = ', ', string $after = '' ): void {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$forms = get_the_term_list( $post_id, 'poetry_form', $before, $sep, $after );
	if ( $forms && ! is_wp_error( $forms ) ) {
		echo wp_kses_post( $forms );
	}
}

/**
 * Display collections for a poem.
 *
 * @param int|null $post_id Post ID. Defaults to current post.
 * @param string   $before  Content before the collections.
 * @param string   $sep     Separator between collections.
 * @param string   $after   Content after the collections.
 */
function versalia_collections( ?int $post_id = null, string $before = '', string $sep = ', ', string $after = '' ): void {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$collections = get_the_term_list( $post_id, 'collection', $before, $sep, $after );
	if ( $collections && ! is_wp_error( $collections ) ) {
		echo wp_kses_post( $collections );
	}
}

/**
 * Display taxonomy badges.
 *
 * @param string   $taxonomy Taxonomy name.
 * @param int|null $post_id  Post ID. Defaults to current post.
 * @param int      $limit    Maximum number of terms to display.
 */
function versalia_taxonomy_badges( string $taxonomy, ?int $post_id = null, int $limit = 3 ): void {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$terms = get_the_terms( $post_id, $taxonomy );

	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}

	$terms        = array_slice( $terms, 0, $limit );
	$taxonomy_obj = get_taxonomy( $taxonomy );

	if ( ! $taxonomy_obj ) {
		return;
	}

	echo '<div class="taxonomy-badges taxonomy-' . esc_attr( $taxonomy ) . '">';

	foreach ( $terms as $term ) {
		printf(
			'<a href="%s" class="taxonomy-badge badge-%s" title="%s">%s</a>',
			esc_url( get_term_link( $term ) ),
			esc_attr( $term->slug ),
			/* translators: %s: Taxonomy name */
			esc_attr( sprintf( __( 'View all %s', 'versalia' ), $taxonomy_obj->labels->name ) ),
			esc_html( $term->name )
		);
	}

	echo '</div>';
}

/**
 * Display breadcrumb navigation.
 */
function versalia_breadcrumb(): void {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'versalia' ) . '">';
	echo '<ol>';

	// Home
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'versalia' ) . '</a></li>';

	if ( is_singular( 'poem' ) ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'poem' ) ) . '">' . esc_html__( 'Poems', 'versalia' ) . '</a></li>';
		echo '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_post_type_archive( 'poem' ) ) {
		echo '<li aria-current="page">' . esc_html__( 'Poems', 'versalia' ) . '</li>';
	} elseif ( is_tax( 'collection' ) || is_tax( 'poetry_form' ) ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'poem' ) ) . '">' . esc_html__( 'Poems', 'versalia' ) . '</a></li>';
		echo '<li aria-current="page">' . esc_html( single_term_title( '', false ) ) . '</li>';
	} elseif ( is_archive() ) {
		echo '<li aria-current="page">' . esc_html( get_the_archive_title() ) . '</li>';
	} elseif ( is_search() ) {
		echo '<li aria-current="page">' . esc_html__( 'Search Results', 'versalia' ) . '</li>';
	} elseif ( is_404() ) {
		echo '<li aria-current="page">' . esc_html__( 'Page Not Found', 'versalia' ) . '</li>';
	} else {
		echo '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
	}

	echo '</ol>';
	echo '</nav>';
}

/**
 * Display site logo or site title.
 */
function versalia_site_branding(): void {
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		if ( is_front_page() && is_home() ) :
			?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
		else :
			?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
		endif;

		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) :
			?>
			<p class="site-description"><?php echo esc_html( $description ); ?></p>
			<?php
		endif;
	}
}

/**
 * Display navigation to next/previous poem when applicable.
 */
function versalia_poem_navigation(): void {
	if ( 'poem' !== get_post_type() ) {
		return;
	}

	get_template_part( 'template-parts/poem/poem', 'navigation' );
}
