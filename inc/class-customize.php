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

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_scripts' ), 0 );

		// Enqueue scripts and styles for the preview.
		add_action( 'customize_preview_init', array( $this, 'preview_enqueue' ) );
	}

	/**
	 * Sets up the customizer panels.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function panels( $manager ) {

		$manager->add_panel(
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
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( extant_theme()->dir_path . 'inc/customize/section-locked.php' );

		// Register custom section types.
		$manager->register_section_type( 'Extant_Customize_Section_Locked' );

		// Move theme-specific sections to our theme options panel.
		$manager->get_section( 'background_image' )->panel = 'theme_options';
		$manager->get_section( 'layout' )->panel           = 'theme_options';
		$manager->get_section( 'colors' )->panel           = 'theme_options';

		$manager->add_section(
			'icons',
			array(
				'panel' => 'theme_options',
				'title' => __( 'Icons', 'extant' )
			)
		);

		$manager->add_section(
			new Extant_Customize_Section_Locked(
				$manager,
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
	 * @param  object  $manager
	 * @return void
	 */
	public function settings( $manager ) {

		// Set the transport property of existing settings.
		$manager->get_setting( 'blogname' )->transport              = 'postMessage';
		$manager->get_setting( 'blogdescription' )->transport       = 'postMessage';
		$manager->get_setting( 'background_color' )->transport      = 'postMessage';
		$manager->get_setting( 'background_image' )->transport      = 'postMessage';
		$manager->get_setting( 'background_position_x' )->transport = 'postMessage';
		$manager->get_setting( 'background_repeat' )->transport     = 'postMessage';
		$manager->get_setting( 'background_attachment' )->transport = 'postMessage';
		$manager->get_setting( 'theme_layout' )->transport          = 'refresh';

		/* === Layouts === */

		$manager->add_setting(
			'layout_type',
			array(
				'default'              => extant_get_layout_type(),
				'sanitize_callback'    => 'extant_validate_layout_type',
				'sanitize_js_callback' => 'extant_validate_layout_type',
				'transport'            => 'postMessage'
			)
		);

		/* === Icons === */

		$manager->add_setting(
			'show_header_icon',
			array(
				'default'           => extant_show_header_icon(),
				'sanitize_callback' => 'wp_validate_boolean',
				'transport'         => 'postMessage'
			)
		);

		$icons = array(
			'header_icon'         => extant_get_header_icon(),
			'menu_primary_icon'   => extant_get_menu_primary_icon(),
			'menu_secondary_icon' => extant_get_menu_secondary_icon(),
			'menu_search_icon'    => extant_get_menu_search_icon()
		);

		foreach ( $icons as $setting => $default ) {

			$manager->add_setting(
				$setting,
				array(
					'default'            => $default,
					'sanitize_callback'  => 'extant_validate_font_icon',
					'transport'          => 'postMessage',
				)
			);
		}

		/* === Pro === */

		$manager->add_setting( new WP_Customize_Filter_Setting( $manager, 'go_pro' ) );
	}

	/**
	 * Sets up the customizer controls.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function controls( $manager ) {

		// Load custom controls.
		require_once( extant_theme()->dir_path . 'inc/customize/control-select-icon.php' );
		require_once( extant_theme()->dir_path . 'inc/customize/control-custom-html.php' );

		// Register custom control types.
		$manager->register_control_type( 'Extant_Customize_Control_Select_Icon' );
		$manager->register_control_type( 'Extant_Customize_Control_Custom_HTML' );

		/* == Layouts == */

		$manager->add_control(
			'layout_type',
			array(
				'label'           => esc_html__( 'Layout Type', 'extant' ),
				'section'         => 'layout',
				'type'            => 'radio',
				'choices'         => extant_get_layout_types()
			)
		);

		/* === Icons === */

		$manager->add_control(
			'show_header_icon',
			array(
				'label'           => esc_html__( 'Always Display Header Icon', 'extant' ),
				'description'     => __( 'Icon is only shown on mobile devices by default.', 'extant' ),
				'section'         => 'icons',
				'type'            => 'checkbox'
			)
		);

		$icons = array(
			'header_icon'         => esc_html__( 'Header Icon',         'extant' ),
			'menu_primary_icon'   => esc_html__( 'Primary Menu Icon',   'extant' ),
			'menu_secondary_icon' => esc_html__( 'Secondary Menu Icon', 'extant' ),
			'menu_search_icon'    => esc_html__( 'Search Menu Icon',    'extant' )
		);

		foreach ( $icons as $control => $label ) {

			$manager->add_control(
				new Extant_Customize_Control_Select_Icon(
					$manager,
					$control,
					array( 'label' => $label )
				)
			);
		}

		/* === Pro Options === */

		$manager->add_control(
			new Extant_Customize_Control_Custom_HTML(
				$manager,
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
	 * @param  object  $manager
	 * @return void
	 */
	public function partials( $manager ) {

		$manager->selective_refresh->add_partial(
			'header_icon',
			array(
				'selector'            => '.site-title i',
				'container_inclusive' => true,
				'render_callback'     => 'extant_get_header_i'
			)
		);

		$manager->selective_refresh->add_partial(
			'menu_primary_icon',
			array(
				'selector'            => '.menu-toggle-primary button i',
				'container_inclusive' => true,
				'render_callback'     => 'extant_get_menu_primary_i'
			)
		);

		$manager->selective_refresh->add_partial(
			'menu_secondary_icon',
			array(
				'selector'            => '.menu-toggle-secondary button i',
				'container_inclusive' => true,
				'render_callback'     => 'extant_get_menu_secondary_i'
			)
		);

		$manager->selective_refresh->add_partial(
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
