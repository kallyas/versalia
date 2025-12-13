<?php
/**
 * AJAX Handlers
 *
 * Handles AJAX requests for dynamic content loading.
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle AJAX request to load more poems.
 *
 * Responds with JSON containing HTML content and pagination information.
 *
 * Expected POST parameters:
 * - nonce (string): Security nonce for verification
 * - page (int): Page number to load
 * - post_type (string): Post type to query (default: 'poem')
 * - taxonomy (string): Taxonomy slug for filtering (optional)
 * - term_id (int): Term ID for taxonomy filtering (optional)
 *
 * JSON Response on success:
 * - html (string): Rendered HTML for the posts
 * - max_pages (int): Total number of pages available
 * - current_page (int): Current page number
 * - found_posts (int): Total number of posts found
 *
 * JSON Response on error:
 * - message (string): Error message
 */
function versalia_load_more_poems(): void {
	// Verify nonce for security
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), VERSALIA_LOAD_MORE_NONCE_ACTION ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed', 'versalia' ) ) );
		return;
	}

	// Get and sanitize parameters
	$paged = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
	$post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) : 'poem';
	$taxonomy = isset( $_POST['taxonomy'] ) ? sanitize_text_field( wp_unslash( $_POST['taxonomy'] ) ) : '';
	$term_id = isset( $_POST['term_id'] ) ? absint( $_POST['term_id'] ) : 0;

	// Build query arguments
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged'          => $paged,
		'post_status'    => 'publish',
	);

	// Add taxonomy query if provided
	if ( ! empty( $taxonomy ) && $term_id > 0 ) {
		$args['tax_query'] = array(
			array(
				'taxonomy'         => $taxonomy,
				'field'            => 'term_id',
				'terms'            => $term_id,
				'include_children' => true,
			),
		);
	}

	// Execute query
	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/content/content', 'excerpt' );
		}
		$html = ob_get_clean();
		wp_reset_postdata();

		wp_send_json_success(
			array(
				'html'         => $html,
				'max_pages'    => $query->max_num_pages,
				'current_page' => $paged,
				'found_posts'  => $query->found_posts,
			)
		);
	} else {
		wp_send_json_error( array( 'message' => __( 'No more posts found', 'versalia' ) ) );
	}
}
add_action( 'wp_ajax_' . VERSALIA_LOAD_MORE_AJAX_ACTION, 'versalia_load_more_poems' );
add_action( 'wp_ajax_nopriv_' . VERSALIA_LOAD_MORE_AJAX_ACTION, 'versalia_load_more_poems' );
