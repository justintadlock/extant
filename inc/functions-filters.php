<?php
/**
 * Filters the theme adds.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Custom body and post classes.
add_filter( 'body_class', 'extant_body_class' );
add_filter( 'post_class', 'extant_post_class' );

# Embed wrap.
add_filter( 'embed_oembed_html', 'extant_maybe_wrap_embed', 10, 2 );

# Add author to front of comment text.
add_filter( 'comment_text', 'extant_add_comment_author', 0 );

# Prev/Next comments link attributes.
add_filter( 'previous_comments_link_attributes', 'extant_prev_comments_link_attr' );
add_filter( 'next_comments_link_attributes',     'extant_next_comments_link_attr' );

/**
 * Adds custom body classes.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $classes
 * @return array
 */
function extant_body_class( $classes ) {

	if ( ! extant_show_header_icon() )
		$classes[] = 'hide-header-icon';

	return $classes;
}

/**
 * Adds custom post classes.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $classes
 * @return array
 */
function extant_post_class( $classes ) {

	if ( function_exists( 'ccp_is_project_archive' ) && ccp_is_project_archive() && ccp_is_project_sticky() ) {

		$classes[] = 'sticky';

	} else  if (  ! is_singular() && ! is_sticky() ) {
		static $extant_post_alt;
		++$extant_post_alt;

		$classes[] = ( $extant_post_alt % 2 ) ? 'odd' : 'even';

		if ( extant_is_portrait() && ! is_singular() && ! is_sticky() ) {

			$remainder = $extant_post_alt % 3;

			if ( 1 === $remainder )
				$classes[] = 'one';

			if ( 2 === $remainder )
				$classes[] = 'two';

			else if ( ! $remainder )
				$classes[] = 'three';
		}

	}

	return $classes;
}

/**
 * Wraps embeds with `.embed-wrap` class.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function extant_wrap_embed_html( $html ) {

	return $html && is_string( $html ) ? sprintf( '<div class="embed-wrap">%s</div>', $html ) : $html;
}

/**
 * Checks embed URL patterns to see if they should be wrapped in some special HTML, particularly
 * for responsive videos.
 *
 * @author     Automattic
 * @link       http://jetpack.me
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @param  string  $url
 * @return string
 */
function extant_maybe_wrap_embed( $html, $url ) {

	if ( ! $html || ! is_string( $html ) || ! $url )
		return $html;

	$do_wrap = false;

	$patterns = array(
		'#http://((m|www)\.)?youtube\.com/watch.*#i',
		'#https://((m|www)\.)?youtube\.com/watch.*#i',
		'#http://((m|www)\.)?youtube\.com/playlist.*#i',
		'#https://((m|www)\.)?youtube\.com/playlist.*#i',
		'#http://youtu\.be/.*#i',
		'#https://youtu\.be/.*#i',
		'#https?://(.+\.)?vimeo\.com/.*#i',
		'#https?://(www\.)?dailymotion\.com/.*#i',
		'#https?://dai.ly/*#i',
		'#https?://(www\.)?hulu\.com/watch/.*#i',
		'#https?://wordpress.tv/.*#i',
		'#https?://(www\.)?funnyordie\.com/videos/.*#i',
		'#https?://vine.co/v/.*#i',
		'#https?://(www\.)?collegehumor\.com/video/.*#i',
		'#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
	);

	$patterns = apply_filters( 'extant_maybe_wrap_embed_patterns', $patterns );

	foreach ( $patterns as $pattern ) {

		$do_wrap = preg_match( $pattern, $url );

		if ( $do_wrap )
			return extant_wrap_embed_html( $html );
	}

	return $html;
}

/**
 * Adds the comment author to the front of the comment text.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $text
 * @return string
 */
function extant_add_comment_author( $text ) {

	if ( ! is_singular() )
		return $text;

	return '<cite ' . hybrid_get_attr( 'comment-author' ) . '>' . get_comment_author_link() . '</cite> ' . $text;
}

/**
 * Adds a custom class to the previous comments link.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function extant_prev_comments_link_attr( $attr ) {

	return $attr .= ' class="prev-comments-link"';
}

/**
 * Adds a custom class to the next comments link.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function extant_next_comments_link_attr( $attr ) {

	return $attr .= ' class="next-comments-link"';
}
