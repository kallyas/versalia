<?php
/**
 * Custom Post Types
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Poem Custom Post Type.
 */
function versalia_register_poem_post_type(): void {
	$labels = array(
		'name'                  => _x( 'Poems', 'post type general name', 'versalia' ),
		'singular_name'         => _x( 'Poem', 'post type singular name', 'versalia' ),
		'menu_name'             => _x( 'Poems', 'admin menu', 'versalia' ),
		'name_admin_bar'        => _x( 'Poem', 'add new on admin bar', 'versalia' ),
		'add_new'               => _x( 'Add New', 'poem', 'versalia' ),
		'add_new_item'          => __( 'Add New Poem', 'versalia' ),
		'new_item'              => __( 'New Poem', 'versalia' ),
		'edit_item'             => __( 'Edit Poem', 'versalia' ),
		'view_item'             => __( 'View Poem', 'versalia' ),
		'all_items'             => __( 'All Poems', 'versalia' ),
		'search_items'          => __( 'Search Poems', 'versalia' ),
		'parent_item_colon'     => __( 'Parent Poems:', 'versalia' ),
		'not_found'             => __( 'No poems found.', 'versalia' ),
		'not_found_in_trash'    => __( 'No poems found in Trash.', 'versalia' ),
		'featured_image'        => _x( 'Poem Cover Image', 'Overrides the "Featured Image" phrase', 'versalia' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'versalia' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'versalia' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'versalia' ),
		'archives'              => _x( 'Poem archives', 'The post type archive label used in nav menus', 'versalia' ),
		'insert_into_item'      => _x( 'Insert into poem', 'Overrides the "Insert into post" phrase', 'versalia' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this poem', 'Overrides the "Uploaded to this post" phrase', 'versalia' ),
		'filter_items_list'     => _x( 'Filter poems list', 'Screen reader text for the filter links', 'versalia' ),
		'items_list_navigation' => _x( 'Poems list navigation', 'Screen reader text for the pagination', 'versalia' ),
		'items_list'            => _x( 'Poems list', 'Screen reader text for the items list', 'versalia' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Poetry and verse content', 'versalia' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug'       => 'poem',
			'with_front' => false,
		),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-edit',
		'show_in_rest'       => true,
		'rest_base'          => 'poems',
		'supports'           => array(
			'title',
			'editor',
			'author',
			'excerpt',
			'comments',
			'custom-fields',
			'revisions',
		),
		'taxonomies'         => array( 'collection', 'poetry_form', 'post_tag' ),
	);

	register_post_type( 'poem', $args );
}
add_action( 'init', 'versalia_register_poem_post_type' );

/**
 * Define custom meta fields for Poem post type.
 *
 * These will be available via the Custom Fields panel in WordPress until
 * Phase 4 when dedicated meta boxes with UI will be added.
 *
 * Meta fields:
 * - poem_date_written: Date the poem was written (separate from publish date)
 * - poem_dedication: Optional dedication text
 * - poem_epigraph: Optional epigraph/quote before the poem
 * - poem_epigraph_attribution: Attribution for the epigraph
 * - poem_audio_url: URL to audio recording of the poem
 * - poem_original_language: Original language (for translations)
 * - poem_translator: Translator name(s)
 * - poem_form_notes: Notes about poetic form/structure
 * - poem_reading_time: Estimated reading time in minutes
 */

/**
 * Register custom meta fields for REST API and Gutenberg.
 */
function versalia_register_poem_meta_fields(): void {
	$meta_fields = array(
		'poem_date_written'         => array(
			'type'         => 'string',
			'description'  => __( 'Date the poem was written', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_dedication'           => array(
			'type'         => 'string',
			'description'  => __( 'Dedication text', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_epigraph'             => array(
			'type'         => 'string',
			'description'  => __( 'Epigraph or quote', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_epigraph_attribution' => array(
			'type'         => 'string',
			'description'  => __( 'Attribution for epigraph', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_audio_url'            => array(
			'type'         => 'string',
			'description'  => __( 'URL to audio recording', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_original_language'    => array(
			'type'         => 'string',
			'description'  => __( 'Original language (for translations)', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_translator'           => array(
			'type'         => 'string',
			'description'  => __( 'Translator name(s)', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_form_notes'           => array(
			'type'         => 'string',
			'description'  => __( 'Notes about poetic form/structure', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
		'poem_reading_time'         => array(
			'type'         => 'integer',
			'description'  => __( 'Estimated reading time in minutes', 'versalia' ),
			'single'       => true,
			'show_in_rest' => true,
		),
	);

	foreach ( $meta_fields as $meta_key => $args ) {
		register_post_meta( 'poem', $meta_key, $args );
	}
}
add_action( 'init', 'versalia_register_poem_meta_fields' );

/**
 * Add custom columns to Poems admin list.
 *
 * @param array $columns Existing columns.
 * @return array Modified columns.
 */
function versalia_poem_columns( array $columns ): array {
	$new_columns = array();

	foreach ( $columns as $key => $title ) {
		$new_columns[ $key ] = $title;

		// Add custom columns after title
		if ( 'title' === $key ) {
			$new_columns['poetry_form'] = __( 'Poetry Form', 'versalia' );
			$new_columns['collection']  = __( 'Collection', 'versalia' );
			$new_columns['date_written'] = __( 'Date Written', 'versalia' );
		}
	}

	return $new_columns;
}
add_filter( 'manage_poem_posts_columns', 'versalia_poem_columns' );

/**
 * Display content for custom columns.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function versalia_poem_column_content( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'poetry_form':
			$terms = get_the_terms( $post_id, 'poetry_form' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$term_names = wp_list_pluck( $terms, 'name' );
				echo esc_html( implode( ', ', $term_names ) );
			} else {
				echo '—';
			}
			break;

		case 'collection':
			$terms = get_the_terms( $post_id, 'collection' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$term_names = wp_list_pluck( $terms, 'name' );
				echo esc_html( implode( ', ', $term_names ) );
			} else {
				echo '—';
			}
			break;

		case 'date_written':
			$date_written = get_post_meta( $post_id, 'poem_date_written', true );
			if ( $date_written ) {
				echo esc_html( $date_written );
			} else {
				echo '—';
			}
			break;
	}
}
add_action( 'manage_poem_posts_custom_column', 'versalia_poem_column_content', 10, 2 );

/**
 * Make custom columns sortable.
 *
 * @param array $columns Sortable columns.
 * @return array Modified sortable columns.
 */
function versalia_poem_sortable_columns( array $columns ): array {
	$columns['date_written'] = 'date_written';
	return $columns;
}
add_filter( 'manage_edit-poem_sortable_columns', 'versalia_poem_sortable_columns' );
