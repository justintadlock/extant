<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Customizer setup.
add_action( 'customize_register', 'extant_customize_register' );

/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 * @access public
 * @param  object  $wp_customize
 * @return void
 */
function extant_customize_register( $wp_customize ) {

	// Load custom controls.
	require_once( extant_theme()->dir_path . 'inc/customize/control-select-icon.php' );

	// Enqueue scripts and styles for the preview.
	add_action( 'customize_preview_init', 'extant_customize_preview_enqueue' );

	// Enqueue scripts and styles for the controls.
	add_action( 'customize_controls_enqueue_scripts', 'extant_customize_controls_register_scripts', 0 );

	// Register custom control types.
	$wp_customize->register_control_type( 'Extant_Customize_Control_Select_Icon' );

	// Enable live preview for WordPress theme features.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/* === Sections === */

	$wp_customize->add_section(
		'icons',
		array( 'title' => __( 'Icons', 'extant' ) )
	);

	/* === Selective Refresh === */

	$wp_customize->selective_refresh->add_partial(
		'header_icon',
		array(
			'selector'            => '.site-title i',
			'container_inclusive' => true,
			'render_callback'     => 'extant_get_header_i'
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'menu_primary_icon',
		array(
			'selector'            => '.menu-toggle-primary button i',
			'container_inclusive' => true,
			'render_callback'     => 'extant_get_menu_primary_i'
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'menu_secondary_icon',
		array(
			'selector'            => '.menu-toggle-secondary button i',
			'container_inclusive' => true,
			'render_callback'     => 'extant_get_menu_secondary_i'
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'menu_search_icon',
		array(
			'selector'            => '.menu-toggle-search button i',
			'container_inclusive' => true,
			'render_callback'     => 'extant_get_menu_search_i'
		)
	);

	/* === Settings === */

	$wp_customize->add_setting(
		'show_header_icon',
		array(
			'default'           => extant_show_header_icon(),
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_setting(
		'header_icon',
		array(
			'default'            => extant_get_header_icon(),
			'sanitize_callback'  => 'extant_validate_font_icon',
			'transport'          => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'menu_primary_icon',
		array(
			'default'            => extant_get_menu_primary_icon(),
			'sanitize_callback'  => 'extant_validate_font_icon',
			'transport'          => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'menu_secondary_icon',
		array(
			'default'            => extant_get_menu_secondary_icon(),
			'sanitize_callback'  => 'extant_validate_font_icon',
			'transport'          => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'menu_search_icon',
		array(
			'default'            => extant_get_menu_search_icon(),
			'sanitize_callback'  => 'extant_validate_font_icon',
			'transport'          => 'postMessage',
		)
	);

	/* === Controls === */

	$wp_customize->add_control(
		'show_header_icon',
		array(
			'label'       => esc_html__( 'Always Display Header Icon', 'extant' ),
			'description' => __( 'Icon is only shown on mobile devices by default.', 'extant' ),
			'section'     => 'icons',
			'type'        => 'checkbox'
		)
	);

	$wp_customize->add_control(
		new Extant_Customize_Control_Select_Icon(
			$wp_customize,
			'header_icon',
			array( 'label' => esc_html__( 'Header Icon', 'extant' ) )
		)
	);

	$wp_customize->add_control(
		new Extant_Customize_Control_Select_Icon(
			$wp_customize,
			'menu_primary_icon',
			array( 'label' => esc_html__( 'Primary Menu Icon', 'extant' ) )
		)
	);

	$wp_customize->add_control(
		new Extant_Customize_Control_Select_Icon(
			$wp_customize,
			'menu_secondary_icon',
			array( 'label' => esc_html__( 'Secondary Menu Icon', 'extant' ) )
		)
	);

	$wp_customize->add_control(
		new Extant_Customize_Control_Select_Icon(
			$wp_customize,
			'menu_search_icon',
			array( 'label' => esc_html__( 'Search Menu Icon', 'extant' ) )
		)
	);
}

/**
 * Loads theme customizer JavaScript.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_customize_preview_enqueue() {

	$suffix = hybrid_get_min_suffix();

	wp_enqueue_script( 'extant-customize-preview', trailingslashit( get_template_directory_uri() ) . "js/customize-preview{$suffix}.js", array( 'jquery' ), null, true );
}

/**
 * Loads theme customizer CSS.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_customize_controls_register_scripts() {

	wp_register_script( 'extant-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'customize-controls' ), null, true );

	wp_register_style( 'font-awesome',              hybrid_get_stylesheet_uri( 'font-awesome', 'template' ) );
	wp_register_style( 'extant-customize-controls', hybrid_get_stylesheet_uri( 'customize-controls', 'template' ) );
}
