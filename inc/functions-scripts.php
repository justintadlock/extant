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
add_action( 'wp_enqueue_scripts',    'extant_enqueue'        );
add_action( 'enqueue_embed_scripts', 'extant_enqueue_embed'  );

/**
 * Returns an array of the font families to load from Google Fonts.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_font_families() {

	return array(
	//	'noto-sans'    => 'Noto Sans:400,400i,700,700i',
		'roboto'    => 'Roboto:400,400i,700,700i',
		'roboto-slab'  => 'Roboto+Slab:400,700',
	//	'crimson' => 'Crimson Text:400,400italic,600'
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
	wp_enqueue_style( 'hybrid-style'        );
	wp_enqueue_style( 'extant-mediaelement' );

	//wp_add_inline_style( 'hybrid-style', extant_get_inline_css() );
}

function extant_get_inline_css() {

	$style = '';

	return str_replace( array( "\r", "\n", "\t" ), '', $style );
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
