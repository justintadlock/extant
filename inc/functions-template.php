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
 * Returns the featured image size to use.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_size() {

	if ( extant_is_sticky() )
		return 'extant-sticky';

	return extant_is_landscape() ? 'extant-landscape' : 'extant-portrait';
}

/**
 * Returns the featured image 2x size to use.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_featured_size_2x() {

	return sprintf( '%s-2x', extant_get_featured_size() );
}

/**
 * Returns the featured image size required min. width.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function extant_get_featured_min_width() {

	if ( extant_is_sticky() )
		return 950;

	return extant_is_landscape() ? 750 : 380;
}

/**
 * Returns the featured image size recommended height.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function extant_get_featured_rec_height() {

	if ( extant_is_sticky() )
		return 422;

	return extant_is_landscape() ? 422 : 506;
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

	$svg = sprintf(
		'<div class="featured-media"><a href="%s">
			<?xml version="1.0"?>
			<svg class="svg-featured" width="%s" height="%s" viewBox="0 0 950 534">
				<rect class="svg-shape" x="400" y="192.5" rx="8" ry="8" width="150" height="150" transform="rotate(45 475 267.5)" />
				<text class="svg-icon" x="475" y="267.5" text-anchor="middle" alignment-baseline="central">%s</text>
			</svg>
		</a></div>',
		esc_url( get_permalink() ),
		esc_attr( extant_get_featured_min_width() ),
		esc_attr( extant_get_featured_rec_height() ),
		extant_get_featured_svg_icon()
	);

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

	$options   = extant_map_featured_icons();
	$icon      = $options['standard'];
	$type      = get_post_type();

	$icon_keys = array( $type );

	if ( post_type_supports( $type, 'post-formats' ) ) {

		$format = get_post_format() ? : 'standard';

		$icon_keys[] = "{$type}-{$format}";
		$icon_keys[] = $format;
	}

	foreach ( $icon_keys as $i ) {

		if ( isset( $options[ $i ] ) ) {

			$icon = $options[ $i ];
			break;
		}
	}

	return apply_filters( 'extant_featured_svg_icon', extant_get_font_icon_text( $icon ) );
}

/**
 * Maps post the post format or type to a specific font icon class.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function extant_map_featured_icons() {

	$icons = array(
		// Post type.
		'attachment'        => 'icon-image',
		'download'          => 'icon-download',
		'page'              => 'icon-file-text-o',
		'portfolio_project' => 'icon-image',

		// Post format.
		'aside'             => 'icon-paperclip',
		'audio'             => 'icon-volume-up',
		'chat'              => 'icon-comments',
		'gallery'           => 'icon-image',
		'image'             => 'icon-camera-retro',
		'link'              => 'icon-link',
		'quote'             => 'icon-quote-right',
		'standard'          => 'icon-pencil',
		'status'            => 'icon-map-pin',
		'video'             => 'icon-play-circle'
	);

	// Developers, array key can be `{$type}-{$format}`, `{$format}`, or `{$type}`.
	return apply_filters( 'extant_map_featured_icons', $icons );
}

/**
 * Returns the header icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_header_i() {

	return extant_get_font_icon_html( extant_get_header_icon() );
}

/**
 * Returns the primary menu icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_primary_i() {

	return extant_get_font_icon_html( extant_get_menu_primary_icon() );
}

/**
 * Returns the secondary menu icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_secondary_i() {

	return extant_get_font_icon_html( extant_get_menu_secondary_icon() );
}

/**
 * Returns the search menu icon HTML.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_get_menu_search_i() {

	return extant_get_font_icon_html( extant_get_menu_search_icon() );
}
