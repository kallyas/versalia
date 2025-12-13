<?php
/**
 * Custom Taxonomies
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom taxonomies.
 */
function versalia_register_taxonomies(): void {
	versalia_register_collection_taxonomy();
	versalia_register_poetry_form_taxonomy();
}
add_action( 'init', 'versalia_register_taxonomies' );

/**
 * Register Collection taxonomy.
 *
 * Hierarchical taxonomy (like categories) for organizing poems into
 * collections, chapbooks, or series.
 */
function versalia_register_collection_taxonomy(): void {
	$labels = array(
		'name'                       => _x( 'Collections', 'taxonomy general name', 'versalia' ),
		'singular_name'              => _x( 'Collection', 'taxonomy singular name', 'versalia' ),
		'search_items'               => __( 'Search Collections', 'versalia' ),
		'popular_items'              => __( 'Popular Collections', 'versalia' ),
		'all_items'                  => __( 'All Collections', 'versalia' ),
		'parent_item'                => __( 'Parent Collection', 'versalia' ),
		'parent_item_colon'          => __( 'Parent Collection:', 'versalia' ),
		'edit_item'                  => __( 'Edit Collection', 'versalia' ),
		'update_item'                => __( 'Update Collection', 'versalia' ),
		'add_new_item'               => __( 'Add New Collection', 'versalia' ),
		'new_item_name'              => __( 'New Collection Name', 'versalia' ),
		'separate_items_with_commas' => __( 'Separate collections with commas', 'versalia' ),
		'add_or_remove_items'        => __( 'Add or remove collections', 'versalia' ),
		'choose_from_most_used'      => __( 'Choose from the most used collections', 'versalia' ),
		'not_found'                  => __( 'No collections found.', 'versalia' ),
		'menu_name'                  => __( 'Collections', 'versalia' ),
		'back_to_items'              => __( '← Back to Collections', 'versalia' ),
	);

	$args = array(
		'labels'            => $labels,
		'description'       => __( 'Poetry collections, chapbooks, and series', 'versalia' ),
		'hierarchical'      => true,
		'public'            => true,
		'publicly_queryable' => true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'rest_base'         => 'collections',
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => 'collection',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'collection', array( 'poem' ), $args );
}

/**
 * Register Poetry Form taxonomy.
 *
 * Non-hierarchical taxonomy (like tags) for categorizing poems by their
 * poetic form (Sonnet, Haiku, Free Verse, etc.).
 */
function versalia_register_poetry_form_taxonomy(): void {
	$labels = array(
		'name'                       => _x( 'Poetry Forms', 'taxonomy general name', 'versalia' ),
		'singular_name'              => _x( 'Poetry Form', 'taxonomy singular name', 'versalia' ),
		'search_items'               => __( 'Search Poetry Forms', 'versalia' ),
		'popular_items'              => __( 'Popular Forms', 'versalia' ),
		'all_items'                  => __( 'All Poetry Forms', 'versalia' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Poetry Form', 'versalia' ),
		'update_item'                => __( 'Update Poetry Form', 'versalia' ),
		'add_new_item'               => __( 'Add New Poetry Form', 'versalia' ),
		'new_item_name'              => __( 'New Poetry Form Name', 'versalia' ),
		'separate_items_with_commas' => __( 'Separate forms with commas', 'versalia' ),
		'add_or_remove_items'        => __( 'Add or remove poetry forms', 'versalia' ),
		'choose_from_most_used'      => __( 'Choose from the most used forms', 'versalia' ),
		'not_found'                  => __( 'No poetry forms found.', 'versalia' ),
		'menu_name'                  => __( 'Poetry Forms', 'versalia' ),
		'back_to_items'              => __( '← Back to Poetry Forms', 'versalia' ),
	);

	$args = array(
		'labels'            => $labels,
		'description'       => __( 'Poetic forms and structures', 'versalia' ),
		'hierarchical'      => false,
		'public'            => true,
		'publicly_queryable' => true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'rest_base'         => 'poetry-forms',
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'poetry-form',
			'with_front' => false,
		),
	);

	register_taxonomy( 'poetry_form', array( 'poem' ), $args );
}

/**
 * Pre-populate Poetry Forms with default values.
 *
 * This runs once on theme activation to create the common poetry forms.
 */
function versalia_insert_default_poetry_forms(): void {
	// Check if we've already populated
	$populated = get_option( 'versalia_poetry_forms_populated', false );
	if ( $populated ) {
		return;
	}

	// Default poetry forms from specification (lines 258)
	$default_forms = array(
		'Sonnet'       => 'A 14-line poem with a specific rhyme scheme, typically in iambic pentameter.',
		'Haiku'        => 'A three-line poem with a 5-7-5 syllable structure.',
		'Free Verse'   => 'Poetry without consistent meter, rhyme, or other musical pattern.',
		'Villanelle'   => 'A 19-line poem with a specific pattern of repetition and rhyme.',
		'Sestina'      => 'A complex 39-line poem with a fixed pattern of word repetition.',
		'Limerick'     => 'A humorous five-line poem with an AABBA rhyme scheme.',
		'Ode'          => 'A lyrical stanza written in praise of or dedicated to something.',
		'Elegy'        => 'A mournful, melancholic poem, especially a lament for the dead.',
		'Ballad'       => 'A narrative poem often set to music.',
		'Acrostic'     => 'A poem where the first letters of each line spell out a word or message.',
		'Blank Verse'  => 'Unrhymed iambic pentameter, widely used for dramatic and narrative poetry.',
	);

	foreach ( $default_forms as $form_name => $description ) {
		// Check if term already exists
		$term = term_exists( $form_name, 'poetry_form' );

		if ( ! $term ) {
			wp_insert_term(
				$form_name,
				'poetry_form',
				array(
					'description' => $description,
					'slug'        => sanitize_title( $form_name ),
				)
			);
		}
	}

	// Mark as populated
	update_option( 'versalia_poetry_forms_populated', true );
}
add_action( 'after_switch_theme', 'versalia_insert_default_poetry_forms' );

/**
 * Modify taxonomy term permalink structure.
 *
 * @param string  $termlink Term link.
 * @param WP_Term $term     Term object.
 * @param string  $taxonomy Taxonomy slug.
 * @return string Modified term link.
 */
function versalia_taxonomy_term_link( string $termlink, WP_Term $term, string $taxonomy ): string {
	// Ensure clean URLs for poetry taxonomies
	if ( in_array( $taxonomy, array( 'collection', 'poetry_form' ), true ) ) {
		$termlink = str_replace( '//', '/', $termlink );
	}
	return $termlink;
}
add_filter( 'term_link', 'versalia_taxonomy_term_link', 10, 3 );
