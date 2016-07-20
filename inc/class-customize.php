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

final class Extant_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );
		add_action( 'customize_register', array( $this, 'settings' ) );
		add_action( 'customize_register', array( $this, 'controls' ) );
		add_action( 'customize_register', array( $this, 'partials' ) );

		// Enqueue scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_scripts' ), 0 );

		// Enqueue scripts and styles for the preview.
		add_action( 'customize_preview_init', array( $this, 'preview_enqueue' ) );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function sections( $wp_customize ) {

		$wp_customize->add_section(
			'icons',
			array( 'title' => __( 'Icons', 'extant' ) )
		);
	}

	/**
	 * Sets up the customizer settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function settings( $wp_customize ) {

		// Enable live preview for WordPress theme features.
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

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
	}

	/**
	 * Sets up the customizer controls.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function controls( $wp_customize ) {

		// Load custom controls.
		require_once( extant_theme()->dir_path . 'inc/customize/control-select-icon.php' );

		// Register custom control types.
		$wp_customize->register_control_type( 'Extant_Customize_Control_Select_Icon' );

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
	 * Sets up the customizer partials.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function partials( $wp_customize ) {

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
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_control_scripts() {

		wp_register_script( 'extant-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'customize-controls' ), null, true );

		wp_register_style( 'font-awesome',              hybrid_get_stylesheet_uri( 'font-awesome', 'template' ) );
		wp_register_style( 'extant-customize-controls', hybrid_get_stylesheet_uri( 'customize-controls', 'template' ) );
	}

	/**
	 * Loads theme customizer JavaScript.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function preview_enqueue() {

		$suffix = hybrid_get_min_suffix();

		wp_enqueue_script( 'extant-customize-preview', trailingslashit( get_template_directory_uri() ) . "js/customize-preview{$suffix}.js", array( 'jquery' ), null, true );
	}
}

// Doing this customizer thang!
Extant_Customize::get_instance();
