<?php
/**
 * Note: Experimental functions proposed for next version of the Hybrid Core framework.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * This is a wrapper function for core WP's `get_theme_mod()` function.  Core doesn't
 * provide a filter hook for the default value (useful for child themes).  The purpose
 * of this function is to provide that additional filter hook.  To filter the final
 * theme mod, use the core `theme_mod_{$name}` filter hook.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name
 * @param  mixed   $default
 * @return mixed
 */
function hybrid_get_theme_mod( $name, $default = false ) {

	return get_theme_mod( $mod, apply_filters( "hybrid_theme_mod_{$mod}_default", $default ) );
}

/**
 * Checks if the current layout matches the layout to check against.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $layout
 * @return bool
 */
function hybrid_is_layout( $layout ) {

	return $layout === hybrid_get_theme_layout();
}

/**
 * Searches for and attempts to find a specific stylesheet.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $name   Name of the stylesheet file (without the extension).
 * @param  string  $where  stylesheet|template
 * @return string
 */
function hybrid_get_stylesheet_uri( $name, $where = 'stylesheet' ) {

	$style_uri = '';
	$suffix    = hybrid_get_min_suffix();
	$dir       = 'template' === $where ? trailingslashit( get_template_directory() )     : trailingslashit( get_stylesheet_directory() );
	$uri       = 'template' === $where ? trailingslashit( get_template_directory_uri() ) : trailingslashit( get_stylesheet_directory_uri() );

	if ( $suffix && file_exists( "{$dir}css/{$name}{$suffix}.css" ) )
		$style_uri = "{$uri}css/{$name}{$suffix}.css";

	else if ( file_exists( "{$dir}css/{$name}.css" ) )
		$style_uri = "{$uri}css/{$name}.css";

	return apply_filters( "hybrid_{$name}_stylesheet_uri", $style_uri, $dir, $uri );
}

/**
 * Gets the embed template used for embedding posts from the site.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function hybrid_get_embed_template() {

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// Assume the theme developer is creating an attachment template.
	if ( 'attachment' === $post_type ) {
		remove_filter( 'the_content',       'prepend_attachment'          );
		remove_filter( 'the_excerpt_embed', 'wp_embed_excerpt_attachment' );

		$type = hybrid_get_attachment_type();

		$templates[] = "embed-attachment-{$type}.php";
		$templates[] = "embed/attachment-{$type}.php";
	}

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based off post type and post format.
		$templates[] = "embed-{$post_type}-{$post_format}.php";
		$templates[] = "embed/{$post_type}-{$post_format}.php";

		// Template based off the post format.
		$templates[] = "embed-{$post_format}.php";
		$templates[] = "embed/{$post_format}.php";
	}

	// Template based off the post type.
	$templates[] = "embed-{$post_type}.php";
	$templates[] = "embed/{$post_type}.php";

	// Fallback 'embed/content.php' template.
	$templates[] = 'embed/content.php';

	// Apply filters to the templates array.
	$templates = apply_filters( 'hybrid_embed_template_hierarchy', $templates );

	// Locate the template.
	$template = locate_template( $templates );

	// If template is found, include it.
	if ( apply_filters( 'hybrid_embed_template', $template, $templates ) )
		include( $template );
}
