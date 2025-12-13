<?php
/**
 * Versalia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Versalia only works in WordPress 6.0 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '6.0', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Define theme constants
 */
define( 'VERSALIA_VERSION', '1.0.0' );
define( 'VERSALIA_THEME_DIR', get_template_directory() );
define( 'VERSALIA_THEME_URI', get_template_directory_uri() );

/**
 * Define AJAX constants
 */
define( 'VERSALIA_LOAD_MORE_NONCE_ACTION', 'versalia_load_more_nonce' );
define( 'VERSALIA_LOAD_MORE_AJAX_ACTION', 'versalia_load_more' );

/**
 * Theme setup and configuration
 */
require VERSALIA_THEME_DIR . '/inc/theme-setup.php';

/**
 * Custom post types
 */
require VERSALIA_THEME_DIR . '/inc/custom-post-types.php';

/**
 * Custom taxonomies
 */
require VERSALIA_THEME_DIR . '/inc/custom-taxonomies.php';

/**
 * Custom template tags
 */
require VERSALIA_THEME_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require VERSALIA_THEME_DIR . '/inc/template-functions.php';

/**
 * Customizer additions
 */
require VERSALIA_THEME_DIR . '/inc/customizer.php';

/**
 * Custom widgets
 */
require VERSALIA_THEME_DIR . '/inc/widgets.php';

/**
 * AJAX handlers
 */
require VERSALIA_THEME_DIR . '/inc/ajax-handlers.php';
