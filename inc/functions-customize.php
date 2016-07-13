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

	// Enqueue scripts and styles for the preview.
	add_action( 'customize_preview_init', 'extant_customize_preview_enqueue' );

	// Enqueue scripts and styles for the controls.
	add_action( 'customize_controls_print_styles', 'extant_customize_controls_enqueue' );

	// Enable live preview for WordPress theme features.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/*$wp_customize->add_setting(
		'display_header_icon',
		array(
			'default' => true,
			// 'sanitize_callback' =>
			'transport' => 'postMessage'
		)
	);*/

	/* Adds the header icon setting. */
	$wp_customize->add_setting(
		'header_icon',
		array(
			'default'              => 'icon-home',
			'sanitize_callback'    => 'esc_attr',
			'sanitize_js_callback' => 'esc_attr',
			'transport'            => 'postMessage',
		)
	);

	// Adds the display header icon control.
	/*$wp_customize->add_control(
		'display_header_icon',
		array(
			'label'    => esc_html__( 'Display Header Icon', 'extant' ),
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
		)
	);*/

	// Adds the header icon control.
	$wp_customize->add_control(
		'header_icon',
		array(
			'label'    => esc_html__( 'Header Icon', 'extant' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => extant_get_header_icon_choices()
		)
	);
}

/**
 * Returns an array of header icons for use with the 'header_icon' theme option.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_header_icon_choices() {

	$icons = array( '' => '' );

	foreach ( extant_get_font_icons() as $class => $code )
		$icons[ $class ] = "&#x{$code};";

	return $icons;
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

	wp_enqueue_script( 'extant-customize', trailingslashit( get_template_directory_uri() ) . "js/customize-preview{$suffix}.js", array( 'jquery' ), null, true );
}

/**
 * Loads theme customizer CSS.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_customize_controls_enqueue() {

	wp_enqueue_style( 'font-awesome', hybrid_get_stylesheet_uri( 'font-awesome', 'template' ) );
}
