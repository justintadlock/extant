<?php
/**
 * Helper functions and filters for scripts, styles, and fonts.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Load scripts, styles, and fonts.
add_action( 'wp_enqueue_scripts',    'extant_enqueue', 5        );
add_action( 'enqueue_embed_scripts', 'extant_enqueue_embed'  );

/**
 * Returns the font args for the theme's Google Fonts call.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_locale_font_args() {

	$fonts  = extant_get_locale_fonts();
	$locale = strtolower( get_locale() );
	$args   = isset( $fonts[ $locale ] ) ? $fonts[ $locale ] : $fonts['default'];

	return apply_filters( "extant_{$locale}_font_args", $args );
}

/**
 * Returns an array of locale-specific font arguments
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_locale_fonts() {

	$fonts = array(
		'default' => array( 'family' => extant_get_font_families(), 'subset' => extant_get_font_subsets() ),
		'ja'      => array( 'src' => '//fonts.googleapis.com/earlyaccess/notosansjapanese.css' ),
		'ko_kr'   => array( 'src' => '//fonts.googleapis.com/earlyaccess/notosanskr.css' ),
		'zh_cn'   => array( 'src' => '//fonts.googleapis.com/earlyaccess/notosanssc.css' )
	);

	return apply_filters( 'extant_get_locale_fonts', $fonts );
}

/**
 * Returns an array of the font families to load from Google Fonts.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_font_families() {

	return array(
		'roboto'      => 'Roboto:400,400i,700,700i',
		'roboto-slab' => 'Roboto+Slab:400,700'
	);
}

/**
 * Returns an array of the font subsets to include.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_get_font_subsets() {

	return array( 'latin', 'latin-ext' );
}

/**
 * Loads scripts, styles, and fonts on the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_enqueue() {

	// Deregisters the core media player styles (rolling our own).
	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );

	// Add custom mediaelement inline script.
	wp_add_inline_script( 'mediaelement', extant_get_mediaelement_inline_script() );

	// Load scripts.
	wp_enqueue_script( 'extant' );

	// Load fonts.
	hybrid_enqueue_font( 'extant' );

	// Load styles.
	wp_enqueue_style( 'font-awesome'        );
	wp_enqueue_style( 'hybrid-one-five'     );
	wp_enqueue_style( 'hybrid-gallery'      );

	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		wp_enqueue_style( 'extant-style'        );
		wp_enqueue_style( 'extant-mediaelement' );
		wp_enqueue_style( 'extant-colors'       );

	} else {
		if ( is_child_theme() )
			wp_enqueue_style( 'hybrid-parent' );

		wp_enqueue_style( 'hybrid-style' );
	}
}

/**
 * Loads scripts, styles, and fonts for embeds.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_enqueue_embed() {

	// Load fonts.
	hybrid_enqueue_font( 'extant' );

	// Load styles.
	wp_enqueue_style( 'font-awesome' );

	if ( is_child_theme() )
		wp_enqueue_style( 'extant-parent-embed' );

	wp_enqueue_style( 'extant-embed' );
}

/**
 * Inline script called for the media player.  This reorders the controls.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_mediaelement_inline_script() {

	return "( function( window ) {

		var settings = window._wpmejsSettings || {};

		settings.features = [ 'progress', 'playpause', 'volume', 'tracks', 'current', 'duration', 'fullscreen' ];
	} )( window );";
}

/**
 * Returns a stylesheet file.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the stylesheet file (without the extension).
 * @param  string  $path   The folder to look for the stylesheet in.
 * @param  string  $where  template|stylesheet
 * @return string
 */
function extant_get_style_uri( $name, $path = 'css', $where = 'template' ) {

	$suffix = hybrid_get_min_suffix();
	$path   = 'stylesheet' === $where ? '%2$s/' . $path : '%1$s/' . $path;

	$dir = trailingslashit( hybrid_sprintf_theme_dir( $path ) );
	$uri = trailingslashit( hybrid_sprintf_theme_uri( $path ) );

	return $suffix && file_exists( "{$dir}{$name}{$suffix}.css" ) ? "{$uri}{$name}{$suffix}.css" : "{$uri}{$name}.css";
}

/**
 * Returns a stylesheet file from the child theme.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the stylesheet file (without the extension).
 * @param  string  $path   The folder to look for the stylesheet in.
 * @return string
 */
function extant_get_child_style_uri( $name, $path = 'css' ) {

	return extant_get_style_uri( $name, $path, 'stylesheet' );
}

/**
 * Returns a script file.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the script file (without the extension).
 * @param  string  $path   The folder to look for the script in.
 * @param  string  $where  template|stylesheet
 * @return string
 */
function extant_get_script_uri( $name, $path = 'js', $where = 'template' ) {

	$suffix = hybrid_get_min_suffix();
	$path   = 'stylesheet' === $where ? '%2$s/' . $path : '%1$s/' . $path;

	$dir = trailingslashit( hybrid_sprintf_theme_dir( $path ) );
	$uri = trailingslashit( hybrid_sprintf_theme_uri( $path ) );

	return $suffix && file_exists( "{$dir}{$name}{$suffix}.js" ) ? "{$uri}{$name}{$suffix}.js" : "{$uri}{$name}.js";
}

/**
 * Returns a script file from the child theme.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the script file (without the extension).
 * @param  string  $path   The folder to look for the script in.
 * @return string
 */
function extant_get_child_script_uri( $name, $path = 'js' ) {

	return extant_get_script_uri( $name, $path, 'stylesheet' );
}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.  This also fixes WordPress
 * not correctly handling the theme's default background color.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 * @link http://core.trac.wordpress.org/ticket/21510
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css" id="custom-background-css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}
