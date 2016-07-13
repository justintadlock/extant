<?php
/**
 * Functions that deal with theme options.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the header icon theme mod.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_header_icon() {

	return hybrid_get_theme_mod( 'header_icon', 'icon-home' );
}

/**
 * Conditional tag to check if the header icon should always display.  By default,
 * it's only meant to display on mobile (<= 480px).
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function extant_always_display_header_icon() {

	return hybrid_get_theme_mod( 'header_icon_always', false );
}

/**
 * Returns the primary color theme mod.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_primary_color() {

	return hybrid_get_theme_mod( 'color_primary', '#c02942' );
}

/**
 * Conditional tag to check whether the user is running the pro version.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function extant_is_pro() {

	return apply_filters( 'extant_is_pro', false );
}
