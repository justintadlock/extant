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

	wp_add_inline_style( 'hybrid-style', extant_get_inline_css() );
}

function extant_get_inline_css() {

	return extant_get_primary_color_css() . extant_get_header_color_css();
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
 * Returns the primary color inline CSS.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_primary_color_css() {

	$p_hex = maybe_hash_hex_color( extant_get_primary_color() );

	$p_rgb = join( ', ', hybrid_hex_to_rgb( $p_hex ) );

	$style = '';

	// primary - color
	$style .= sprintf(
		'.main a:hover,
		.main a:focus,
		.site-footer a:hover,
		.site-footer a:focus,
		.breadcrumbs a:hover,
		.breadcrumbs a:focus,
		pre,
		code,
		.line-through,
		label.focus,
		legend,
		.comment-respond .required,
		.edd-required-indicator,
		.edd_purchase_submit_wrapper .edd-cart-ajax-alert { color: %s; }',
		$p_hex
	);

	// primary - background
	$style .= sprintf(
		'input[type="submit"],
		input[type="reset"],
		input[type="button"],
		button,
		.edd-page a.edd-submit.button,
		.singular-portfolio_project .project-link { background: %s; }',
		$p_hex
	);

	// primary - background - 0.1
	$style .= sprintf(
		'legend,
		pre { background-color: rgba( %s, 0.1 ); }',
		$p_rgb
	);

	// primary box-shadow for images
	$style .= sprintf(
		'.main a:hover img,
		.main a:focus img,
		a:hover .svg-featured,
		a:focus .svg-featured {
			box-shadow: 0 0 0 9px #fff, 0 0 0 10px rgba( %1$s, 0.25 ), 0 0 0 12px rgba( %1$s, 0.05 );
		}',
		$p_rgb
	);

	return str_replace( array( "\r", "\n", "\t" ), '', $style );
}

/**
 * Returns the header color inline CSS.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_header_color_css() {

	$p_hex = maybe_hash_hex_color( extant_get_header_primary_color() );
	$s_hex = maybe_hash_hex_color( extant_get_header_secondary_color() );

	$p_rgb = join( ', ', hybrid_hex_to_rgb( $p_hex ) );
	$s_rgb = join( ', ', hybrid_hex_to_rgb( $s_hex ) );

	$style = '';

	// primary - color
	$style .= sprintf(
		'.site-title a,
		.menu-toggle-primary button,
		.menu-toggle-secondary button,
		.menu-toggle-search button { color: %s; }',
		$p_hex
	);

	// primary - color @todo rbga
	$style .= sprintf(
		'.site-description { color: rgba( %s, 0.7 ); }',
		$p_rgb
	);

	// secondary - color
	$style .= sprintf(
		'.menu-toggle button:hover,
		.menu-toggle button:focus,
		.menu-primary-open .menu-toggle-primary button,
		.menu-secondary-open .menu-toggle-secondary button,
		.menu-search-open .menu-toggle-search button,
		.site-header .menu-items a,
		.site-header .menu-items a:hover,
		.site-header .menu-items a:focus,
		.menu-search .search-field,
		.menu-search .search-submit:hover,
		.menu-search .search-submit:focus { color: %1$s; }
		.menu-search .search-field::-webkit-input-placeholder { color: %1$s; }
		.menu-search .search-field::-moz-placeholder          { color: %1$s; }
		.menu-search .search-field:-ms-input-placeholder      { color: %1$s; }
		.menu-search .search-field:-moz-placeholder           { color: %1$s; }',
		$s_hex
	);

	// secondary - background
	$style .= sprintf(
		'.site-header,
		.menu-toggle button { background: %s; }',
		$s_hex
	);

	// primary - background
	$style .= sprintf(
		'.menu-toggle button:hover,
		.menu-toggle button:focus,
		.menu-primary-open .menu-toggle-primary button,
		.menu-secondary-open .menu-toggle-secondary button,
		.menu-search-open .menu-toggle-search button,
		.menu-primary > .wrap,
		.menu-secondary > .wrap,
		.menu-search > .search-form,
		.menu-search .search-field,
		.menu-search .search-submit { background: %s; }',
		$p_hex
	);

	// primary - border-color @todo rgba
	$style .= sprintf(
		'.site-header,
		.site-title,
		.menu-super > ul > li { border-color: rgba( %s, 0.05 ); }',
		$p_rgb
	);

	// primary - border-color
	$style .= sprintf(
		'.menu-super > ul > li:hover,
		.menu-super > ul > li:focus,
		.menu-primary-open .menu-primary,
		.menu-secondary-open .menu-secondary,
		.menu-search-open .menu-search { border-color: %s; }',
		$p_hex
	);

	// secondary - color 0.75
	$style .= sprintf(
		'.menu-search .search-submit { color: rgba( %s, 0.75 ); }',
		$s_rgb
	);

	// secondary - border-color - 0.025
	$style .= sprintf(
		'.menu-primary li a,
		.menu-secondary li a { border-color: rgba( %s, 0.025 ); }',
		$s_rgb
	);

	// secondary - border-color - 0.25
	$style .= sprintf(
		'.menu-search .search-field { border-color: rgba( %s, 0.25 ); }',
		$s_rgb
	);

	// secondary - border-color - 0.75
	$style .= sprintf(
		'.menu-search .search-submit { border-color: rgba( %s, 0.75 ); }',
		$s_rgb
	);

	// secondary - border-color
	$style .= sprintf(
		'.menu-search .search-submit:hover,
		.menu-search .search-submit:focus { border-color: %s; }',
		$s_hex
	);

	// secondary - background - 0.05
	$style .= sprintf(
		'.menu-primary li a:hover,
		.menu-primary li a:focus,
		.menu-secondary li a:hover,
		.menu-secondary li a:focus,
		.menu-search .search-submit:hover,
		.menu-search .search-submit:focus { background: rgba( %s, 0.05 ); }',
		$s_rgb
	);

	// secondary - background - 0.75
	$style .= sprintf(
		'.menu-primary-open .overlay,
		.menu-secondary-open .overlay,
		.menu-search-open .overlay { background: rgba( %s, 0.5 ); }',
		$s_rgb
	);


	// media query
	$style .= sprintf(
		'@media only screen and ( max-width: 480px ) {
			.site-header,
			.site-title a { border-color: rgba( %1$s, 0.05 ); }
			.site-title a { color: %2$s; }
			.site-title a:hover,
			.site-title a:focus {
				color:        %3$s;
				background:   %2$s;
				border-color: %2$s;
			}
		}',
		$p_rgb,
		$p_hex,
		$s_hex
	);

	return str_replace( array( "\r", "\n", "\t" ), '', $style );
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
