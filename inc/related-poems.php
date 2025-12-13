<?php
/**
 * Related Poems Functionality
 *
 * Functions for displaying related poems on single poem pages.
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get related poems based on taxonomy relationships.
 *
 * Tries to find related poems in this order:
 * 1. Same poetry form
 * 2. Same collection
 * 3. Same author
 *
 * @param int $post_id Post ID. Defaults to current post.
 * @param int $limit   Number of poems to return. Default 3.
 * @return WP_Query|null Query object with related poems or null if none found.
 */
function versalia_get_related_poems( int $post_id = 0, int $limit = 3 ): ?WP_Query {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'poem' !== get_post_type( $post_id ) ) {
		return null;
	}

	// Try by poetry form first
	$forms = get_the_terms( $post_id, 'poetry_form' );
	if ( $forms && ! is_wp_error( $forms ) ) {
		$form_ids = wp_list_pluck( $forms, 'term_id' );

		$args = array(
			'post_type'      => 'poem',
			'posts_per_page' => $limit,
			'post__not_in'   => array( $post_id ),
			'tax_query'      => array(
				array(
					'taxonomy' => 'poetry_form',
					'field'    => 'term_id',
					'terms'    => $form_ids,
				),
			),
			'orderby'        => 'rand',
		);

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			return $query;
		}
		wp_reset_postdata();
	}

	// Fallback: Try by collection
	$collections = get_the_terms( $post_id, 'collection' );
	if ( $collections && ! is_wp_error( $collections ) ) {
		$collection_ids = wp_list_pluck( $collections, 'term_id' );

		$args = array(
			'post_type'      => 'poem',
			'posts_per_page' => $limit,
			'post__not_in'   => array( $post_id ),
			'tax_query'      => array(
				array(
					'taxonomy' => 'collection',
					'field'    => 'term_id',
					'terms'    => $collection_ids,
				),
			),
			'orderby'        => 'rand',
		);

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			return $query;
		}
		wp_reset_postdata();
	}

	// Fallback: Same author
	$args = array(
		'post_type'      => 'poem',
		'posts_per_page' => $limit,
		'post__not_in'   => array( $post_id ),
		'author'         => get_post_field( 'post_author', $post_id ),
		'orderby'        => 'rand',
	);

	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		return $query;
	}

	wp_reset_postdata();
	return null;
}

/**
 * Get the title for the related poems section.
 *
 * Returns a contextual title based on what relationship the related poems have.
 *
 * @param int $post_id Post ID. Defaults to current post.
 * @return string Section title.
 */
function versalia_get_related_poems_title( int $post_id = 0 ): string {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	// Check for poetry form
	$forms = get_the_terms( $post_id, 'poetry_form' );
	if ( $forms && ! is_wp_error( $forms ) ) {
		$form = array_shift( $forms );
		/* translators: %s: Poetry form name */
		return sprintf( __( 'More %ss', 'versalia' ), $form->name );
	}

	// Check for collection
	$collections = get_the_terms( $post_id, 'collection' );
	if ( $collections && ! is_wp_error( $collections ) ) {
		$collection = array_shift( $collections );
		/* translators: %s: Collection name */
		return sprintf( __( 'More from %s', 'versalia' ), $collection->name );
	}

	// Fallback
	return __( 'Related Poems', 'versalia' );
}
