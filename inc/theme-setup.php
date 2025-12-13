<?php
/**
 * Theme setup and configuration
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function versalia_setup(): void {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'versalia', VERSALIA_THEME_DIR . '/languages' );

	/*
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Register navigation menus.
	 */
	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu', 'versalia' ),
			'footer'    => esc_html__( 'Footer Menu', 'versalia' ),
			'social'    => esc_html__( 'Social Links', 'versalia' ),
		)
	);

	/*
	 * Switch default core markup to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	/*
	 * Add theme support for selective refresh for widgets.
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Add support for core custom logo.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	/*
	 * Add support for Block Styles.
	 */
	add_theme_support( 'wp-block-styles' );

	/*
	 * Add support for full and wide align images.
	 */
	add_theme_support( 'align-wide' );

	/*
	 * Add support for editor styles.
	 */
	add_theme_support( 'editor-styles' );

	/*
	 * Add support for responsive embedded content.
	 */
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'versalia_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function versalia_content_width(): void {
	$GLOBALS['content_width'] = apply_filters( 'versalia_content_width', 720 );
}
add_action( 'after_setup_theme', 'versalia_content_width', 0 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function versalia_widgets_init(): void {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'versalia' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'versalia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'versalia' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'versalia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Homepage widget areas
	register_sidebar(
		array(
			'name'          => esc_html__( 'Homepage Featured', 'versalia' ),
			'id'            => 'homepage-featured',
			'description'   => esc_html__( 'Featured content area on homepage.', 'versalia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Homepage Hero', 'versalia' ),
			'id'            => 'homepage-hero',
			'description'   => esc_html__( 'Hero/intro section on homepage.', 'versalia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Homepage Bottom', 'versalia' ),
			'id'            => 'homepage-bottom',
			'description'   => esc_html__( 'Bottom section on homepage.', 'versalia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'versalia_widgets_init' );

/**
 * Get Google Fonts URL for selected preset.
 *
 * @param string $preset Font preset name.
 * @return string Google Fonts URL or empty string.
 */
function versalia_get_fonts_url( string $preset = 'classic' ): string {
	$fonts_url = '';

	// Font presets from specification
	$font_presets = array(
		'classic'       => 'family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap',
		'modern'        => 'family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Work+Sans:wght@400;500&display=swap',
		'contemporary'  => 'family=Spectral:ital,wght@0,300;0,400;1,300&family=Karla:wght@400;500&display=swap',
		'traditional'   => 'family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+Pro:wght@400;600&display=swap',
	);

	if ( isset( $font_presets[ $preset ] ) ) {
		$fonts_url = 'https://fonts.googleapis.com/css2?' . $font_presets[ $preset ];
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function versalia_enqueue_assets(): void {
	// Main stylesheet
	wp_enqueue_style(
		'versalia-style',
		get_stylesheet_uri(),
		array(),
		VERSALIA_VERSION
	);

	// RTL support
	if ( is_rtl() ) {
		wp_enqueue_style(
			'versalia-rtl',
			VERSALIA_THEME_URI . '/rtl.css',
			array( 'versalia-style' ),
			VERSALIA_VERSION
		);
	}

	// Google Fonts (selected preset from customizer)
	$font_preset = get_theme_mod( 'versalia_font_preset', 'classic' );
	$fonts_url   = versalia_get_fonts_url( $font_preset );
	if ( $fonts_url ) {
		wp_enqueue_style(
			'versalia-fonts',
			$fonts_url,
			array(),
			null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		);
	}

	// Navigation script
	wp_enqueue_script(
		'versalia-navigation',
		VERSALIA_THEME_URI . '/assets/js/navigation.js',
		array(),
		VERSALIA_VERSION,
		true
	);

	// Sticky header script
	wp_enqueue_script(
		'versalia-sticky-header',
		VERSALIA_THEME_URI . '/assets/js/sticky-header.js',
		array(),
		VERSALIA_VERSION,
		true
	);

	// Hero Slider script and styles (for front page only)
	if ( is_front_page() || is_home() ) {
		wp_enqueue_script(
			'versalia-hero-slider',
			VERSALIA_THEME_URI . '/assets/js/hero-slider.js',
			array(),
			VERSALIA_VERSION,
			true
		);

		// Pass WordPress data to JavaScript
		wp_localize_script(
			'versalia-hero-slider',
			'versaliaHeroSlider',
			array(
				'pauseLabel' => __( 'Pause slider', 'versalia' ),
				'playLabel'  => __( 'Play slider', 'versalia' ),
			)
		);
	}

	// Bookmarks script (for poem pages and archives)
	if ( is_singular( 'poem' ) || is_post_type_archive( 'poem' ) || is_front_page() || is_home() || is_tax( array( 'collection', 'poetry_form' ) ) ) {
		wp_enqueue_script(
			'versalia-bookmarks',
			VERSALIA_THEME_URI . '/assets/js/bookmarks.js',
			array(),
			VERSALIA_VERSION,
			true
		);
	}

	// Load More script (for poem archives and taxonomies)
	if ( is_post_type_archive( 'poem' ) || is_tax( array( 'collection', 'poetry_form' ) ) ) {
		wp_enqueue_script(
			'versalia-load-more',
			VERSALIA_THEME_URI . '/assets/js/load-more.js',
			array(),
			VERSALIA_VERSION,
			true
		);

		// Pass WordPress data to JavaScript
		wp_localize_script(
			'versalia-load-more',
			'versaliaLoadMore',
			array(
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'ajaxAction' => VERSALIA_LOAD_MORE_AJAX_ACTION,
			)
		);
	}

	// Reading mode (only on single poems)
	if ( is_singular( 'poem' ) ) {
		wp_enqueue_script(
			'versalia-reading-mode',
			VERSALIA_THEME_URI . '/assets/js/reading-mode.js',
			array(),
			VERSALIA_VERSION,
			true
		);

		wp_enqueue_script(
			'versalia-poem-navigation',
			VERSALIA_THEME_URI . '/assets/js/poem-navigation.js',
			array(),
			VERSALIA_VERSION,
			true
		);

		// Pass WordPress data to JavaScript
		wp_localize_script(
			'versalia-poem-navigation',
			'versaliaPoem',
			array(
				'prevUrl'   => get_previous_post_link( '%link', '%title', true, '', 'poem' ),
				'nextUrl'   => get_next_post_link( '%link', '%title', true, '', 'poem' ),
				'archiveUrl' => get_post_type_archive_link( 'poem' ),
			)
		);
	}

	// Customizer preview
	if ( is_customize_preview() ) {
		wp_enqueue_script(
			'versalia-customizer-preview',
			VERSALIA_THEME_URI . '/assets/js/customizer-preview.js',
			array( 'customize-preview' ),
			VERSALIA_VERSION,
			true
		);
	}

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'versalia_enqueue_assets' );

/**
 * Add preconnect for Google Fonts.
 */
function versalia_resource_hints( array $urls, string $relation_type ): array {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'versalia_resource_hints', 10, 2 );

/**
 * Enqueue block editor assets.
 */
function versalia_block_editor_assets(): void {
	// Editor stylesheet
	wp_enqueue_style(
		'versalia-editor-style',
		VERSALIA_THEME_URI . '/assets/css/editor-style.css',
		array(),
		VERSALIA_VERSION
	);

	// Google Fonts for editor
	$font_preset = get_theme_mod( 'versalia_font_preset', 'classic' );
	$fonts_url   = versalia_get_fonts_url( $font_preset );
	if ( $fonts_url ) {
		wp_enqueue_style(
			'versalia-editor-fonts',
			$fonts_url,
			array(),
			null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'versalia_block_editor_assets' );

/**
 * Flush rewrite rules on theme activation.
 */
function versalia_activation(): void {
	// Ensure custom post types and taxonomies are registered
	if ( function_exists( 'versalia_register_poem_post_type' ) ) {
		versalia_register_poem_post_type();
	}
	if ( function_exists( 'versalia_register_taxonomies' ) ) {
		versalia_register_taxonomies();
	}

	// Flush rewrite rules
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'versalia_activation' );
