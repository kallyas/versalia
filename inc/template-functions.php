<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom classes to the body element.
 *
 * @param array $classes Classes for the body element.
 * @return array Modified body classes.
 */
function versalia_body_classes( array $classes ): array {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add poem-specific classes
	if ( is_singular( 'poem' ) ) {
		$classes[] = 'single-poem';
	}

	if ( is_post_type_archive( 'poem' ) || is_tax( array( 'collection', 'poetry_form' ) ) ) {
		$classes[] = 'poem-archive';
	}

	// Add reading mode class (from localStorage, default to light)
	$classes[] = 'reading-mode-light';

	return $classes;
}
add_filter( 'body_class', 'versalia_body_classes' );

/**
 * Add custom classes to post elements.
 *
 * @param array $classes Post classes.
 * @param array $class   Additional classes.
 * @param int   $post_id Post ID.
 * @return array Modified post classes.
 */
function versalia_post_classes( array $classes, array $class, int $post_id ): array {
	if ( 'poem' === get_post_type( $post_id ) ) {
		$classes[] = 'poem-entry';

		// Add poetry form as a class
		$forms = get_the_terms( $post_id, 'poetry_form' );
		if ( $forms && ! is_wp_error( $forms ) ) {
			foreach ( $forms as $form ) {
				$classes[] = 'poetry-form-' . $form->slug;
			}
		}
	}

	return $classes;
}
add_filter( 'post_class', 'versalia_post_classes', 10, 3 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function versalia_pingback_header(): void {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'versalia_pingback_header' );

/**
 * Modify the archive title.
 *
 * @param string $title Archive title.
 * @return string Modified archive title.
 */
function versalia_archive_title( string $title ): string {
	if ( is_post_type_archive( 'poem' ) ) {
		$title = __( 'Poems', 'versalia' );
	} elseif ( is_tax( 'collection' ) ) {
		$title = single_term_title( '', false );
	} elseif ( is_tax( 'poetry_form' ) ) {
		$title = single_term_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'versalia_archive_title' );

/**
 * Modify the archive description.
 *
 * @param string $description Archive description.
 * @return string Modified archive description.
 */
function versalia_archive_description( string $description ): string {
	if ( is_post_type_archive( 'poem' ) ) {
		$description = __( 'A collection of poetry and verse.', 'versalia' );
	}

	return $description;
}
add_filter( 'get_the_archive_description', 'versalia_archive_description' );

/**
 * Modify the excerpt length.
 *
 * @param int $length Excerpt length.
 * @return int Modified excerpt length.
 */
function versalia_excerpt_length( int $length ): int {
	if ( is_post_type_archive( 'poem' ) || is_tax( array( 'collection', 'poetry_form' ) ) ) {
		return 25; // Shorter excerpts for poems
	}
	return $length;
}
add_filter( 'excerpt_length', 'versalia_excerpt_length' );

/**
 * Modify the excerpt "more" string.
 *
 * @param string $more "More" string.
 * @return string Modified "more" string.
 */
function versalia_excerpt_more( string $more ): string {
	if ( 'poem' === get_post_type() ) {
		return '&hellip;';
	}
	return $more;
}
add_filter( 'excerpt_more', 'versalia_excerpt_more' );

/**
 * Change the number of posts per page for poem archives.
 *
 * @param WP_Query $query The WP_Query instance.
 */
function versalia_poem_archive_query( WP_Query $query ): void {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_post_type_archive( 'poem' ) || is_tax( array( 'collection', 'poetry_form' ) ) ) {
			$query->set( 'posts_per_page', 12 );
			$query->set( 'orderby', 'date' );
			$query->set( 'order', 'DESC' );
		}
	}
}
add_action( 'pre_get_posts', 'versalia_poem_archive_query' );

/**
 * Add custom query vars.
 *
 * @param array $vars Query variables.
 * @return array Modified query variables.
 */
function versalia_query_vars( array $vars ): array {
	$vars[] = 'reading_mode';
	return $vars;
}
add_filter( 'query_vars', 'versalia_query_vars' );

/**
 * Add skip link focus fix for screen readers.
 */
function versalia_skip_link_focus_fix(): void {
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'versalia_skip_link_focus_fix' );

/**
 * Remove WordPress emoji scripts.
 */
function versalia_disable_emojis(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'versalia_disable_emojis' );

/**
 * Optimize WordPress query for better performance.
 *
 * @param array $query_vars Query variables.
 * @return array Modified query variables.
 */
function versalia_optimize_query( array $query_vars ): array {
	if ( isset( $query_vars['post_type'] ) && 'poem' === $query_vars['post_type'] ) {
		// Reduce the number of revisions for poems
		$query_vars['revision'] = 5;
	}
	return $query_vars;
}
add_filter( 'request', 'versalia_optimize_query' );
