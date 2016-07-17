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
 * Checks whether the chosen layout is the 'grid-landscape' layout.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function extant_is_landscape() {

	return hybrid_is_layout( 'grid-landscape' );
}

/**
 * Checks whether the chosen layout is the 'grid-portrait' layout.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function extant_is_portrait() {

	return hybrid_is_layout( 'grid-portrait' );
}

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
 * Returns the primary icon theme mod.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_primary_icon() {

	return hybrid_get_theme_mod( 'menu_primary_icon', 'icon-bars' );
}

/**
 * Returns the secondary menu icon theme mod.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_secondary_icon() {

	return hybrid_get_theme_mod( 'menu_secondary_icon', 'icon-circle-o' );
}

/**
 * Returns the search menu icon theme mod.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_search_icon() {

	return hybrid_get_theme_mod( 'menu_search_icon', 'icon-search' );
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
