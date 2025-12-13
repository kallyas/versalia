<?php
/**
 * Social Media Meta Tags
 *
 * Adds Open Graph and Twitter Card meta tags for better social sharing.
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Open Graph meta tags to head
 */
function versalia_add_og_meta_tags(): void {
	if ( ! is_singular( 'poem' ) ) {
		return;
	}

	$poem_title   = get_the_title();
	$poem_url     = get_permalink();
	$poem_excerpt = get_the_excerpt();
	$site_name    = get_bloginfo( 'name' );

	// Open Graph tags
	echo '<meta property="og:type" content="article" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $poem_title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $poem_excerpt ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $poem_url ) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '" />' . "\n";

	// Add featured image if available
	if ( has_post_thumbnail() ) {
		$image_url = get_the_post_thumbnail_url( null, 'large' );
		if ( $image_url ) {
			echo '<meta property="og:image" content="' . esc_url( $image_url ) . '" />' . "\n";

			// Get image dimensions for better display
			$image_id   = get_post_thumbnail_id();
			$image_meta = wp_get_attachment_metadata( $image_id );
			if ( $image_meta ) {
				echo '<meta property="og:image:width" content="' . esc_attr( $image_meta['width'] ) . '" />' . "\n";
				echo '<meta property="og:image:height" content="' . esc_attr( $image_meta['height'] ) . '" />' . "\n";
			}
		}
	}

	// Twitter Card tags
	echo '<meta name="twitter:card" content="summary" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $poem_title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $poem_excerpt ) . '" />' . "\n";

	if ( has_post_thumbnail() ) {
		$image_url = get_the_post_thumbnail_url( null, 'large' );
		if ( $image_url ) {
			echo '<meta name="twitter:image" content="' . esc_url( $image_url ) . '" />' . "\n";
		}
	}

	// Article specific meta
	echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c' ) ) . '" />' . "\n";
	echo '<meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( 'c' ) ) . '" />' . "\n";
	echo '<meta property="article:author" content="' . esc_attr( get_the_author() ) . '" />' . "\n";

	// Add poetry form as article section
	$forms = get_the_terms( get_the_ID(), 'poetry_form' );
	if ( $forms && ! is_wp_error( $forms ) ) {
		foreach ( $forms as $form ) {
			echo '<meta property="article:section" content="' . esc_attr( $form->name ) . '" />' . "\n";
		}
	}

	// Add tags
	$tags = get_the_tags();
	if ( $tags && ! is_wp_error( $tags ) ) {
		foreach ( $tags as $tag ) {
			echo '<meta property="article:tag" content="' . esc_attr( $tag->name ) . '" />' . "\n";
		}
	}
}
add_action( 'wp_head', 'versalia_add_og_meta_tags' );
