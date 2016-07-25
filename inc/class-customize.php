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

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'panels'   ) );
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
	 * Sets up the customizer panels.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function panels( $wp_customize ) {

		$wp_customize->add_panel(
			'theme_options',
			array(
				'priority' => 5,
				'title'    => __( 'Theme Options', 'extant' )
			)
		);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function sections( $wp_customize ) {

		// Load custom sections.
		require_once( extant_theme()->dir_path . 'inc/customize/section-locked.php' );

		// Register custom section types.
		$wp_customize->register_section_type( 'Extant_Customize_Section_Locked' );

		// Move theme-specific sections to our theme options panel.
		$wp_customize->get_section( 'background_image' )->panel = 'theme_options';
		$wp_customize->get_section( 'layout' )->panel           = 'theme_options';
		$wp_customize->get_section( 'colors' )->panel           = 'theme_options';

		$wp_customize->add_section(
			'icons',
			array(
				'panel' => 'theme_options',
				'title' => __( 'Icons', 'extant' )
			)
		);

		$wp_customize->add_section(
			new Extant_Customize_Section_Locked(
				$wp_customize,
				'pro_options',
				array(
					'panel'           => 'theme_options',
					'priority'        => 995,
					'title'           => esc_html__( 'Pro Options', 'extant' ),
					'button'          => esc_html__( 'Unlock', 'extant' ),
					'active_callback' => array( $this, 'show_pro_options' )
				)
			)
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

		// Layout needs to be refreshed to change image sizes.
		$wp_customize->get_setting( 'theme_layout' )->transport = 'refresh';

		$wp_customize->add_setting(
			'color_primary',
			array(
				'default'              => extant_get_primary_color(),
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
			)
		);

		$wp_customize->add_setting(
			'color_header_primary',
			array(
				'default'              => extant_get_header_primary_color(),
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
			)
		);

		$wp_customize->add_setting(
			'color_header_secondary',
			array(
				'default'              => extant_get_header_secondary_color(),
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
			)
		);

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

		$wp_customize->add_setting( new WP_Customize_Filter_Setting( $wp_customize, 'go_pro' ) );
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
		require_once( extant_theme()->dir_path . 'inc/customize/control-custom-html.php' );

		// Register custom control types.
		$wp_customize->register_control_type( 'Extant_Customize_Control_Select_Icon' );
		$wp_customize->register_control_type( 'Extant_Customize_Control_Custom_HTML' );

		/* === Colors === */

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'color_primary',
				array(
					'label'           => esc_html__( 'Primary Color', 'extant' ),
					'section'         => 'colors',
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'color_header_primary',
				array(
					'label'           => esc_html__( 'Header Primary Color', 'extant' ),
					'section'         => 'colors',
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'color_header_secondary',
				array(
					'label'           => esc_html__( 'Header Secondary Color', 'extant' ),
					'section'         => 'colors',
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		/* === Icons === */

		$wp_customize->add_control(
			'show_header_icon',
			array(
				'label'           => esc_html__( 'Always Display Header Icon', 'extant' ),
				'description'     => __( 'Icon is only shown on mobile devices by default.', 'extant' ),
				'section'         => 'icons',
				'type'            => 'checkbox',
				'active_callback' => 'extant_is_pro'
			)
		);

		$wp_customize->add_control(
			new Extant_Customize_Control_Select_Icon(
				$wp_customize,
				'header_icon',
				array(
					'label'           => esc_html__( 'Header Icon', 'extant' ),
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		$wp_customize->add_control(
			new Extant_Customize_Control_Select_Icon(
				$wp_customize,
				'menu_primary_icon',
				array(
					'label'           => esc_html__( 'Primary Menu Icon', 'extant' ),
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		$wp_customize->add_control(
			new Extant_Customize_Control_Select_Icon(
				$wp_customize,
				'menu_secondary_icon',
				array(
					'label'           => esc_html__( 'Secondary Menu Icon', 'extant' ),
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		$wp_customize->add_control(
			new Extant_Customize_Control_Select_Icon(
				$wp_customize,
				'menu_search_icon',
				array(
					'label'           => esc_html__( 'Search Menu Icon', 'extant' ),
					'active_callback' => 'extant_is_pro'
				)
			)
		);

		/* === Pro Options === */

		$wp_customize->add_control(
			new Extant_Customize_Control_Custom_HTML(
				$wp_customize,
				'go_pro',
				array(
					'section' => 'pro_options',
					'label'   => esc_html__( 'Go Pro', 'extant' ),
					'html'    => $this->get_custom_control_html()
				)
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
	 * Whether to show the pro options.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function show_pro_options() {

		return ! extant_is_pro();
	}

	/**
	 * Returns the HTML for the custom HTML control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_custom_control_html() {

		$html = sprintf(
			'<p>%s</p>
			 <p>%s</p>
			 <p><a class="button button-primary" href="http://themehybrid.com/themes/extant" target="_blank">%s</a></p>',
			__( 'Extant Pro is an add-on that gives you the ability to pick and choose icons, change up your color scheme, and more without ever having to leave the customizer.', 'extant' ),
			__( 'In addition to extra customizer options, you get a full year of dedicated support.', 'extant' ),
			__( 'Find Out More', 'extant' )
		);

		return $html;
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_control_scripts() {

		wp_register_script( 'extant-customize-controls', hybrid_get_script_uri( 'customize-controls', 'template' ), array( 'customize-controls' ), null, true );

		wp_register_style( 'font-awesome',              hybrid_get_style_uri( 'font-awesome', 'template' ) );
		wp_register_style( 'extant-customize-controls', hybrid_get_style_uri( 'customize-controls', 'template' ) );
	}

	/**
	 * Loads theme customizer JavaScript.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function preview_enqueue() {

		wp_enqueue_script( 'extant-customize-preview', hybrid_get_script_uri( 'customize-preview', 'template' ), array( 'jquery' ), null, true );
	}
}

// Doing this customizer thang!
Extant_Customize::get_instance();
