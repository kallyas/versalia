<?php
/**
 * Versalia Theme Customizer
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add postMessage support for site title and description.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function versalia_customize_register( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'versalia_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'versalia_customize_partial_blogdescription',
			)
		);
	}

	// Typography Panel
	$wp_customize->add_panel(
		'versalia_typography',
		array(
			'title'       => __( 'Typography', 'versalia' ),
			'description' => __( 'Customize fonts and typography settings.', 'versalia' ),
			'priority'    => 30,
		)
	);

	// Font Preset Section
	$wp_customize->add_section(
		'versalia_font_preset',
		array(
			'title'    => __( 'Font Pairing', 'versalia' ),
			'panel'    => 'versalia_typography',
			'priority' => 10,
		)
	);

	// Font Preset Setting
	$wp_customize->add_setting(
		'versalia_font_preset',
		array(
			'default'           => 'classic',
			'sanitize_callback' => 'versalia_sanitize_font_preset',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'versalia_font_preset',
		array(
			'label'       => __( 'Select Font Pairing', 'versalia' ),
			'description' => __( 'Choose from pre-configured font combinations optimized for poetry.', 'versalia' ),
			'section'     => 'versalia_font_preset',
			'type'        => 'select',
			'choices'     => array(
				'classic'       => __( 'Classic Elegance (Crimson Text)', 'versalia' ),
				'modern'        => __( 'Modern Literary (EB Garamond + Work Sans)', 'versalia' ),
				'contemporary'  => __( 'Contemporary (Spectral + Karla)', 'versalia' ),
				'traditional'   => __( 'Traditional (Libre Baskerville + Source Sans Pro)', 'versalia' ),
			),
		)
	);

	// Colors Panel
	$wp_customize->add_panel(
		'versalia_colors',
		array(
			'title'       => __( 'Colors', 'versalia' ),
			'description' => __( 'Customize color scheme for reading modes.', 'versalia' ),
			'priority'    => 40,
		)
	);

	// Primary Color Section
	$wp_customize->add_section(
		'versalia_primary_colors',
		array(
			'title'    => __( 'Primary Colors', 'versalia' ),
			'panel'    => 'versalia_colors',
			'priority' => 10,
		)
	);

	// Primary Accent Color
	$wp_customize->add_setting(
		'versalia_accent_color',
		array(
			'default'           => '#2C2C2C',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'versalia_accent_color',
			array(
				'label'       => __( 'Accent Color', 'versalia' ),
				'description' => __( 'Primary accent color for links and highlights.', 'versalia' ),
				'section'     => 'versalia_primary_colors',
			)
		)
	);

	// Layout Panel
	$wp_customize->add_panel(
		'versalia_layout',
		array(
			'title'       => __( 'Layout', 'versalia' ),
			'description' => __( 'Customize layout and display options.', 'versalia' ),
			'priority'    => 50,
		)
	);

	// Homepage Layout Section
	$wp_customize->add_section(
		'versalia_homepage_layout',
		array(
			'title'    => __( 'Homepage Layout', 'versalia' ),
			'panel'    => 'versalia_layout',
			'priority' => 5,
		)
	);

	// Hero Slider Section
	$wp_customize->add_section(
		'versalia_hero_slider',
		array(
			'title'       => __( 'Hero Slider', 'versalia' ),
			'description' => __( 'Configure the hero slider/carousel for featured poems.', 'versalia' ),
			'panel'       => 'versalia_layout',
			'priority'    => 3,
		)
	);

	// Enable Hero Slider
	$wp_customize->add_setting(
		'hero_slider_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hero_slider_enabled',
		array(
			'label'       => __( 'Enable Hero Slider', 'versalia' ),
			'description' => __( 'Show a hero slider/carousel for featured poems on the homepage.', 'versalia' ),
			'section'     => 'versalia_hero_slider',
			'type'        => 'checkbox',
		)
	);

	// Auto-Advance
	$wp_customize->add_setting(
		'hero_slider_auto_advance',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hero_slider_auto_advance',
		array(
			'label'       => __( 'Auto-Advance Slides', 'versalia' ),
			'description' => __( 'Automatically advance to the next slide.', 'versalia' ),
			'section'     => 'versalia_hero_slider',
			'type'        => 'checkbox',
		)
	);

	// Advance Speed
	$wp_customize->add_setting(
		'hero_slider_speed',
		array(
			'default'           => 5000,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hero_slider_speed',
		array(
			'label'       => __( 'Auto-Advance Speed (ms)', 'versalia' ),
			'description' => __( 'Time in milliseconds between slide transitions.', 'versalia' ),
			'section'     => 'versalia_hero_slider',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 2000,
				'max'  => 10000,
				'step' => 500,
			),
		)
	);

	// Number of Featured Poems
	$wp_customize->add_setting(
		'hero_slider_posts_count',
		array(
			'default'           => 5,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hero_slider_posts_count',
		array(
			'label'       => __( 'Number of Featured Poems', 'versalia' ),
			'description' => __( 'How many featured poems to show in the slider.', 'versalia' ),
			'section'     => 'versalia_hero_slider',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1,
				'max'  => 10,
				'step' => 1,
			),
		)
	);

	// Transition Effect
	$wp_customize->add_setting(
		'hero_slider_transition',
		array(
			'default'           => 'fade',
			'sanitize_callback' => 'versalia_sanitize_slider_transition',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hero_slider_transition',
		array(
			'label'   => __( 'Transition Effect', 'versalia' ),
			'section' => 'versalia_hero_slider',
			'type'    => 'select',
			'choices' => array(
				'fade'  => __( 'Fade', 'versalia' ),
				'slide' => __( 'Slide', 'versalia' ),
			),
		)
	);

	// Homepage Layout Style
	$wp_customize->add_setting(
		'homepage_layout',
		array(
			'default'           => 'layout-a',
			'sanitize_callback' => 'versalia_sanitize_homepage_layout',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'homepage_layout',
		array(
			'label'       => __( 'Homepage Layout', 'versalia' ),
			'description' => __( 'Choose the layout style for your homepage.', 'versalia' ),
			'section'     => 'versalia_homepage_layout',
			'type'        => 'select',
			'choices'     => array(
				'layout-a' => __( 'Layout A - Classic with Sidebar', 'versalia' ),
				'layout-b' => __( 'Layout B - Grid with Sidebar', 'versalia' ),
				'layout-c' => __( 'Layout C - Minimal List (No Sidebar)', 'versalia' ),
			),
		)
	);

	// Homepage Section Title
	$wp_customize->add_setting(
		'homepage_section_title',
		array(
			'default'           => __( 'Latest Poems', 'versalia' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'homepage_section_title',
		array(
			'label'   => __( 'Section Title', 'versalia' ),
			'section' => 'versalia_homepage_layout',
			'type'    => 'text',
		)
	);

	// Show Homepage Title
	$wp_customize->add_setting(
		'homepage_show_title',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'homepage_show_title',
		array(
			'label'   => __( 'Show Section Title', 'versalia' ),
			'section' => 'versalia_homepage_layout',
			'type'    => 'checkbox',
		)
	);

	// Homepage Posts Count
	$wp_customize->add_setting(
		'homepage_posts_count',
		array(
			'default'           => 9,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'homepage_posts_count',
		array(
			'label'       => __( 'Number of Poems', 'versalia' ),
			'description' => __( 'How many poems to display on the homepage.', 'versalia' ),
			'section'     => 'versalia_homepage_layout',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1,
				'max'  => 50,
				'step' => 1,
			),
		)
	);

	// Archive Layout Section
	$wp_customize->add_section(
		'versalia_archive_layout',
		array(
			'title'    => __( 'Archive Layout', 'versalia' ),
			'panel'    => 'versalia_layout',
			'priority' => 10,
		)
	);

	// Archive View Style
	$wp_customize->add_setting(
		'versalia_archive_view',
		array(
			'default'           => 'list',
			'sanitize_callback' => 'versalia_sanitize_archive_view',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'versalia_archive_view',
		array(
			'label'       => __( 'Archive View Style', 'versalia' ),
			'description' => __( 'Choose how poems are displayed on archive pages.', 'versalia' ),
			'section'     => 'versalia_archive_layout',
			'type'        => 'select',
			'choices'     => array(
				'list' => __( 'List View', 'versalia' ),
				'grid' => __( 'Grid View', 'versalia' ),
			),
		)
	);

	// Poem Display Section
	$wp_customize->add_section(
		'versalia_poem_display',
		array(
			'title'       => __( 'Poem Display', 'versalia' ),
			'description' => __( 'Control what appears on single poem pages.', 'versalia' ),
			'priority'    => 60,
		)
	);

	// Show Date Written
	$wp_customize->add_setting(
		'versalia_show_date_written',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'versalia_show_date_written',
		array(
			'label'   => __( 'Show Date Written', 'versalia' ),
			'section' => 'versalia_poem_display',
			'type'    => 'checkbox',
		)
	);

	// Show Poetry Form
	$wp_customize->add_setting(
		'versalia_show_poetry_form',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'versalia_show_poetry_form',
		array(
			'label'   => __( 'Show Poetry Form', 'versalia' ),
			'section' => 'versalia_poem_display',
			'type'    => 'checkbox',
		)
	);

	// Show Reading Time
	$wp_customize->add_setting(
		'versalia_show_reading_time',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'versalia_show_reading_time',
		array(
			'label'   => __( 'Show Reading Time', 'versalia' ),
			'section' => 'versalia_poem_display',
			'type'    => 'checkbox',
		)
	);

	// Show Author Bio
	$wp_customize->add_setting(
		'versalia_show_author_bio',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'versalia_show_author_bio',
		array(
			'label'   => __( 'Show Author Bio Box', 'versalia' ),
			'section' => 'versalia_poem_display',
			'type'    => 'checkbox',
		)
	);

	// Enable Drop Cap
	$wp_customize->add_setting(
		'versalia_enable_drop_cap',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'versalia_enable_drop_cap',
		array(
			'label'       => __( 'Enable Drop Cap', 'versalia' ),
			'description' => __( 'Display decorative large first letter in poems.', 'versalia' ),
			'section'     => 'versalia_poem_display',
			'type'        => 'checkbox',
		)
	);

	// Badge Settings Section
	$wp_customize->add_section(
		'versalia_badge_settings',
		array(
			'title'       => __( 'Taxonomy Badges', 'versalia' ),
			'description' => __( 'Customize the appearance of taxonomy badges.', 'versalia' ),
			'panel'       => 'versalia_colors',
			'priority'    => 20,
		)
	);

	// Badge Color Scheme
	$wp_customize->add_setting(
		'versalia_badge_color_scheme',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'versalia_sanitize_badge_color_scheme',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'versalia_badge_color_scheme',
		array(
			'label'       => __( 'Badge Color Scheme', 'versalia' ),
			'description' => __( 'Choose the color scheme for taxonomy badges displayed on poems and archives.', 'versalia' ),
			'section'     => 'versalia_badge_settings',
			'type'        => 'select',
			'choices'     => array(
				'default' => __( 'Default (Accent Colors)', 'versalia' ),
				'vibrant' => __( 'Vibrant (Bold Colors)', 'versalia' ),
				'minimal' => __( 'Minimal (Monochrome)', 'versalia' ),
			),
		)
	);

	// Footer Section
	$wp_customize->add_section(
		'versalia_footer',
		array(
			'title'       => __( 'Footer', 'versalia' ),
			'description' => __( 'Customize footer appearance and options.', 'versalia' ),
			'priority'    => 70,
		)
	);

	// Footer Background Color
	$wp_customize->add_setting(
		'versalia_footer_bg_color',
		array(
			'default'           => '#2C2C2C',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'versalia_footer_bg_color',
			array(
				'label'       => __( 'Footer Background Color', 'versalia' ),
				'description' => __( 'Choose the background color for the footer.', 'versalia' ),
				'section'     => 'versalia_footer',
			)
		)
	);

	// Enable Back to Top Button
	$wp_customize->add_setting(
		'versalia_enable_back_to_top',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'versalia_enable_back_to_top',
		array(
			'label'       => __( 'Enable Back to Top Button', 'versalia' ),
			'description' => __( 'Show a back to top button in the footer.', 'versalia' ),
			'section'     => 'versalia_footer',
			'type'        => 'checkbox',
		)
	);

	// Copyright Text
	$wp_customize->add_setting(
		'versalia_copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'versalia_copyright_text',
		array(
			'label'       => __( 'Copyright Text', 'versalia' ),
			'description' => __( 'Custom copyright text. Leave empty to use default.', 'versalia' ),
			'section'     => 'versalia_footer',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'versalia_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function versalia_customize_partial_blogname(): void {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function versalia_customize_partial_blogdescription(): void {
	bloginfo( 'description' );
}

/**
 * Sanitize font preset.
 *
 * @param string $input Font preset value.
 * @return string Sanitized font preset.
 */
function versalia_sanitize_font_preset( string $input ): string {
	$valid = array( 'classic', 'modern', 'contemporary', 'traditional' );
	return in_array( $input, $valid, true ) ? $input : 'classic';
}

/**
 * Sanitize archive view.
 *
 * @param string $input Archive view value.
 * @return string Sanitized archive view.
 */
function versalia_sanitize_archive_view( string $input ): string {
	$valid = array( 'list', 'grid' );
	return in_array( $input, $valid, true ) ? $input : 'list';
}

/**
 * Sanitize homepage layout.
 *
 * @param string $input Homepage layout value.
 * @return string Sanitized homepage layout.
 */
function versalia_sanitize_homepage_layout( string $input ): string {
	$valid = array( 'layout-a', 'layout-b', 'layout-c' );
	return in_array( $input, $valid, true ) ? $input : 'layout-a';
}

/**
 * Sanitize slider transition.
 *
 * @param string $input Slider transition value.
 * @return string Sanitized slider transition.
 */
function versalia_sanitize_slider_transition( string $input ): string {
	$valid = array( 'fade', 'slide' );
	return in_array( $input, $valid, true ) ? $input : 'fade';
}

/**
 * Sanitize badge color scheme.
 *
 * @param string $input Badge color scheme value.
 * @return string Sanitized badge color scheme.
 */
function versalia_sanitize_badge_color_scheme( string $input ): string {
	$valid = array( 'default', 'vibrant', 'minimal' );
	return in_array( $input, $valid, true ) ? $input : 'default';
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function versalia_customize_preview_js(): void {
	wp_enqueue_script(
		'versalia-customizer-preview',
		VERSALIA_THEME_URI . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		VERSALIA_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'versalia_customize_preview_js' );

/**
 * Enqueue customizer controls script.
 */
function versalia_customize_controls_js(): void {
	wp_enqueue_script(
		'versalia-customizer-controls',
		VERSALIA_THEME_URI . '/assets/js/customizer-controls.js',
		array( 'customize-controls' ),
		VERSALIA_VERSION,
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'versalia_customize_controls_js' );
