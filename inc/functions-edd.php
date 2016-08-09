<?php
/**
 * Functions and filters that run when the Easy Digital Downloads plugin is active.
 *
 * @package    Extant
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/themes/extant
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Remove purchase link after content.
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

# Filter the checkout image size.
add_filter( 'edd_checkout_image_size', 'extant_edd_checkout_image_size' );

# Disable plugin styles.
add_filter( 'edd_get_option_disable_styles', '__return_true' );

/**
 * Overwrites the checkout image size with the theme-defined `post-thumbnail` size.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function extant_edd_checkout_image_size() {
	return 'post-thumbnail';
}
