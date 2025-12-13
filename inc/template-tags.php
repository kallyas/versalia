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
 * Display breadcrumb navigation with schema.org structured data.
 */
function versalia_breadcrumb(): void {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'versalia' ) . '">';
	echo '<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';

	$position = 1;

	// Home
	printf(
		'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="%s"><span itemprop="name">%s</span></a><meta itemprop="position" content="%d" /></li>',
		esc_url( home_url( '/' ) ),
		esc_html__( 'Home', 'versalia' ),
		$position++
	);

	if ( is_singular( 'poem' ) ) {
		// Add collection or poetry form if available
		$collections = get_the_terms( get_the_ID(), 'collection' );
		if ( $collections && ! is_wp_error( $collections ) ) {
			$collection = array_shift( $collections );
			printf(
				'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="%s"><span itemprop="name">%s</span></a><meta itemprop="position" content="%d" /></li>',
				esc_url( get_term_link( $collection ) ),
				esc_html( $collection->name ),
				$position++
			);
		} else {
			// Fallback to Poems archive
			printf(
				'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="%s"><span itemprop="name">%s</span></a><meta itemprop="position" content="%d" /></li>',
				esc_url( get_post_type_archive_link( 'poem' ) ),
				esc_html__( 'Poems', 'versalia' ),
				$position++
			);
		}

		// Current poem
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html( get_the_title() ),
			$position
		);
	} elseif ( is_post_type_archive( 'poem' ) ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html__( 'Poems', 'versalia' ),
			$position
		);
	} elseif ( is_tax( 'collection' ) || is_tax( 'poetry_form' ) ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="%s"><span itemprop="name">%s</span></a><meta itemprop="position" content="%d" /></li>',
			esc_url( get_post_type_archive_link( 'poem' ) ),
			esc_html__( 'Poems', 'versalia' ),
			$position++
		);

		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html( single_term_title( '', false ) ),
			$position
		);
	} elseif ( is_author() ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html( get_the_author() ),
			$position
		);
	} elseif ( is_archive() ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html( get_the_archive_title() ),
			$position
		);
	} elseif ( is_search() ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html__( 'Search Results', 'versalia' ),
			$position
		);
	} elseif ( is_404() ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html__( 'Page Not Found', 'versalia' ),
			$position
		);
	} elseif ( is_singular() ) {
		printf(
			'<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page"><span itemprop="name">%s</span><meta itemprop="position" content="%d" /></li>',
			esc_html( get_the_title() ),
			$position
		);
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
