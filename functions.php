<?php
/**
 * "No power in the 'verse can stop me." - River Tam (Firefly)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Extant
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for launching the theme and setup configuration.
 *
 * @since  1.0.0
 * @access public
 */
final class Extant_Theme {

	/**
	 * Directory path to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';

	/**
	 * Directory URI to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';

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
			$instance->setup();
			$instance->includes();
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
	 * Initial theme setup.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir_path = trailingslashit( get_template_directory()     );
		$this->dir_uri  = trailingslashit( get_template_directory_uri() );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Load the Hybrid Core framework and theme files.
		require_once( $this->dir_path . 'lib/hybrid.php'       );
		require_once( $this->dir_path . 'inc/hybrid-x.php'     );
		require_once( $this->dir_path . 'inc/hybrid-fonts.php' );

		// Load theme includes.
		require_once( $this->dir_path . 'inc/class-customize.php'     );
		require_once( $this->dir_path . 'inc/functions-filters.php'   );
		require_once( $this->dir_path . 'inc/functions-icons.php'     );
		require_once( $this->dir_path . 'inc/functions-options.php'   );
		require_once( $this->dir_path . 'inc/functions-scripts.php'   );
		require_once( $this->dir_path . 'inc/functions-template.php'  );

		// Load Easy Digital Downloads files if plugin is active.
		if ( class_exists( 'Easy_Digital_Downloads' ) )
			require_once( $this->dir_path . 'inc/functions-edd.php' );

		// Launch the Hybrid Core framework.
		new Hybrid();
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Theme setup.
		add_action( 'after_setup_theme', array( $this, 'theme_setup'             ),  5 );
		add_action( 'after_setup_theme', array( $this, 'custom_background_setup' ), 15 );

		// Register menus.
		add_action( 'init', array( $this, 'register_menus' ) );

		// Register image sizes.
		add_action( 'init', array( $this, 'register_image_sizes' ) );

		// Register layouts.
		add_action( 'hybrid_register_layouts', array( $this, 'register_layouts' ) );

		// Register scripts, styles, and fonts.
		add_action( 'wp_enqueue_scripts',    array( $this, 'register_scripts' ), 0 );
		add_action( 'enqueue_embed_scripts', array( $this, 'register_scripts' ), 0 );
	}

	/**
	 * The theme setup function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_setup() {

		// Custom Content Portfolio plugin.
		add_theme_support( 'custom-content-portfolio' );

		// Theme layouts.
		add_theme_support( 'theme-layouts', array( 'default' => 'grid-landscape', 'post_meta' => false ) );

		// Breadcrumbs.
		add_theme_support( 'breadcrumb-trail' );

		// Template hierarchy.
		add_theme_support( 'hybrid-core-template-hierarchy' );

		// The best thumbnail/image script ever.
		add_theme_support( 'get-the-image' );

		// Nicer [gallery] shortcode implementation.
		add_theme_support( 'cleaner-gallery' );

		// Automatically add feed links to `<head>`.
		add_theme_support( 'automatic-feed-links' );

		// Post formats.
		add_theme_support(
			'post-formats',
			array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' )
		);

		// Handle content width for embeds and images.
		hybrid_set_content_width( 950 );
	}

	/**
	 * Adds support for the WordPress 'custom-background' theme feature.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function custom_background_setup() {

		add_theme_support(
			'custom-background',
			array(
				'default-color'    => 'f8f8f8',
				'default-image'    => '',
				'wp-head-callback' => 'extant_custom_background_callback',
			)
		);
	}

	/**
	 * Registers nav menus.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_menus() {

		register_nav_menu( 'primary',   _x( 'Primary',   'nav menu location', 'extant' ) );
		register_nav_menu( 'secondary', _x( 'Secondary', 'nav menu location', 'extant' ) );
	}

	/**
	 * Registers image sizes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_image_sizes() {

		// Landscape sizes.
		set_post_thumbnail_size(                 240, 135, true );
		add_image_size( 'extant-landscape',      750, 422, true );
		add_image_size( 'extant-landscape-2x',  1500, 844,  true );

		// Portrait sizes.
		add_image_size( 'extant-portrait',       380,  506, true );
		add_image_size( 'extant-portrait-2x',    760, 1012, true );
		add_image_size( 'extant-portrait-thumb', 180,  240, true );

		// Sizes always used for sticky posts.
		add_image_size( 'extant-sticky',     950,  534, true );
		add_image_size( 'extant-sticky-2x', 1900, 1068, true );
	}

	/**
	 * Registers layouts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_layouts() {

		hybrid_register_layout(
			'grid-landscape',
			array(
				'label'          => esc_html__( 'Grid: Landscape', 'extant' ),
				'is_post_layout' => false,
				'image'          => hybrid_locate_theme_file( 'images/layouts/grid-landscape.png' )
			)
		);

		hybrid_register_layout(
			'grid-portrait',
			array(
				'label'          => esc_html__( 'Grid: Portrait', 'extant' ),
				'is_post_layout' => false,
				'image'          => hybrid_locate_theme_file( 'images/layouts/grid-portrait.png' )
			)
		);
	}

	/**
	 * Registers scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_scripts() {

		// Register scripts.
		wp_register_script( 'extant', extant_get_script_uri( 'theme' ), array( 'jquery' ), null, true );

		// Register fonts.
		hybrid_register_font( 'extant', extant_get_locale_font_args() );

		// Register styles.
		wp_register_style( 'extant-style',        extant_get_style_uri( 'style',        'css/src' ) );
		wp_register_style( 'extant-mediaelement', extant_get_style_uri( 'mediaelement', 'css/src' ) );
		wp_register_style( 'extant-font-family',  extant_get_style_uri( 'font-family',  'css/src' ) );
		wp_register_style( 'extant-colors',       extant_get_style_uri( 'colors',       'css/src' ) );
		wp_register_style( 'font-awesome',        extant_get_style_uri( 'font-awesome'            ) );
		wp_register_style( 'extant-embed',        extant_get_style_uri( 'embed'                   ) );

		if ( is_child_theme() )
			wp_register_style( 'extant-child-embed', extant_get_child_style_uri( 'embed' ) );
	}
}

/**
 * Gets the instance of the `Extant_Theme` class.  This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function extant_theme() {
	return Extant_Theme::get_instance();
}

// Let's roll!
extant_theme();
