/**
 * Handles the customizer live preview settings.
 */
jQuery( document ).ready( function() {

	// Shows a live preview of changing the site title.
	wp.customize( 'blogname', function( value ) {

		value.bind( function( to ) {

			jQuery( '#site-title a' ).html( to );

		} ); // value.bind

	} ); // wp.customize

	// Shows a live preview of changing the site description.
	wp.customize( 'blogdescription', function( value ) {

		value.bind( function( to ) {

			jQuery( '#site-description' ).html( to );

		} ); // value.bind

	} ); // wp.customize

	// Update `<body>` class when `layout_type` value has changed.
	wp.customize( 'layout_type', function( value ) {

		value.bind( function( to ) {

			var classes = jQuery( 'body' ).attr( 'class' ).replace( /\slayout-type-[a-zA-Z0-9_-]*/g, '' );
			jQuery( 'body' ).attr( 'class', classes ).addClass( 'layout-type-' + to );

		} ); // value.bind

	} ); // wp.customize

	// Update `<body>` class when `show_header_icon` value has changed.
	wp.customize( 'show_header_icon', function( value ) {

		value.bind( function( to ) {

			true === to ? jQuery( 'body' ).removeClass( 'hide-header-icon' ) : jQuery( 'body' ).addClass( 'hide-header-icon' );

		} ); // value.bind

	} ); // wp.customize

} ); // jQuery( document ).ready
