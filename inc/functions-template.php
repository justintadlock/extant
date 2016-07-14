<?php
/**
 * Functions for use within theme templates.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Wrapper function for checking if a post is sticky.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function extant_is_sticky() {

	if ( function_exists( 'ccp_is_project_archive' ) && ccp_is_project_archive() && ccp_is_project_sticky() )
		return true;

	else if ( is_home() && is_sticky() )
		return true;

	return false;
}

/**
 * Prints the the post format permalink.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function extant_post_format_permalink() {
	echo extant_get_post_format_permalink();
}

/**
 * Returns the post permalink (URL) with the post format as the link text.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_post_format_permalink() {

	$format = get_post_format();

	return $format ? sprintf( '<a href="%s" class="post-format-permalink"><span class="screen-reader-text">%s</span></a>', esc_url( get_permalink() ), get_post_format_string( $format ) ) : '';
}

/**
 * Prints the comment parent link.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function extant_comment_parent_link( $args = array() ) {

	echo extant_get_comment_parent_link( $args );
}

/**
 * Returns the comment parent link.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $args
 * @return string
 */
function extant_get_comment_parent_link( $args = array() ) {

	$link = '';

	$defaults = array(
		'text'   => '%s', // Defaults to comment author.
		'depth'  => 2,    // At what level should the link show.
		'before' => '',
		'after'  => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( $args['depth'] <= $GLOBALS['comment_depth'] ) {

		$parent = get_comment()->comment_parent;

		if ( 0 < $parent ) {

			$url  = esc_url( get_comment_link( $parent ) );
			$text = sprintf( $args['text'], get_comment_author( $parent ) );

			$link = sprintf( '%s<a class="comment-parent-link" href="%s">%s</a>%s', $args['before'], $url, $text, $args['after'] );
		}
	}

	return apply_filters( 'extant_comment_parent_link', $link, $args );
}

/**
 * Returns an SVG fallback.  Used when there is no featured image.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_fallback() {

	$svg = '<div class="featured-media"><a href="' . esc_url( get_permalink() ) . '">
		<?xml version="1.0"?>
		<svg class="svg-featured" width="950" height="535" viewBox="0 0 950 535">
			<rect class="svg-shape" x="400" y="192.5" rx="8" ry="8" width="150" height="150" transform="rotate(45 475 267.5)" />
			<text class="svg-icon" x="475" y="267.5" text-anchor="middle" alignment-baseline="central">' . extant_get_featured_svg_icon() . '</text>
		</svg>
	</a></div>';

	return apply_filters( 'extant_get_featured_fallback', $svg );
}

/**
 * Returns the featured SVG fallback icon.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_svg_icon() {

	$options = extant_get_featured_svg_icons();
	$icon    = $options['standard'];

	$type   = get_post_type();
	$format = post_type_supports( $type, 'post-formats' ) ? get_post_format() : '';

	if ( $format && isset( $options[ "{$type}-{$format}" ] ) )
		$icon = $options[ "{$type}-{$format}" ];

	else if ( $format && isset( $options[ $format ] ) )
		$icon = $options[ $format ];

	else if ( isset( $options[ $type ] ) )
		$icon = $options[ $type ];

	return apply_filters( 'extant_featured_svg_icon', extant_get_font_icon_html( $icon ) );
}

/**
 * Returns an array of possible featured SVG fallback icons.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_get_featured_svg_icons() {

	$icons = array(
		'aside'             => 'icon-paperclip',
		'attachment'        => 'icon-image',
		'audio'             => 'icon-volume-up',
		'chat'              => 'icon-comments',
		'download'          => 'icon-download',
		'gallery'           => 'icon-image',
		'image'             => 'icon-camera-retro',
		'link'              => 'icon-link',
		'page'              => 'icon-file-text-o',
		'portfolio_project' => 'icon-image',
		'quote'             => 'icon-quote-right',
		'standard'          => 'icon-pencil',
		'status'            => 'icon-map-pin',
		'video'             => 'icon-play-circle'
	);

	return apply_filters( 'extant_featured_svg_icons', $icons );
}
