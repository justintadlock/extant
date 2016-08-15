jQuery( window ).ready( function() {

	/*
	 * Adds classes to the `<label>` element based on the type of form element the label belongs
	 * to. This allows theme devs to style specifically for certain labels (think, icons).
	 */

	jQuery( '#container input, #container textarea, #container select' ).each(

		function() {
			var input_type = 'input';
			var input_id   = jQuery( this ).attr( 'id' );
			var label      = '';

			if ( jQuery( this ).is( 'input' ) )
				input_type = jQuery( this ).attr( 'type' );

			else if ( jQuery( this ).is( 'textarea' ) )
				input_type = 'textarea';

			else if ( jQuery( this ).is( 'select' ) )
				input_type = 'select';

			jQuery( this ).parent( 'label' ).addClass( 'label-' + input_type );

			if ( input_id )
				jQuery( 'label[for="' + input_id + '"]' ).addClass( 'label-' + input_type );

			if ( 'checkbox' === input_type || 'radio' === input_type ) {
				jQuery( this ).parent( 'label' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

				if ( input_id )
					jQuery( 'label[for="' + input_id + '"]' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

			}
		}
	);

	// Focus labels for form elements.
	jQuery( 'input, select, textarea' ).on( 'focus blur',
		function() {
			var focus_id   = jQuery( this ).attr( 'id' );

			if ( focus_id )
				jQuery( 'label[for="' + focus_id + '"]' ).toggleClass( 'focus' );
			else
				jQuery( this ).parents( 'label' ).toggleClass( 'focus' );
		}
	);

	// Add class to links with an image.
	jQuery( 'a' ).has( 'img' ).addClass( 'has-image' );
	jQuery( 'a' ).has( 'svg' ).addClass( 'has-svg' );

	// Screen reader text.
	jQuery( '#cancel-comment-reply-link' ).wrapInner( '<span class="screen-reader-text">' );

	// Custom-colored line-through.
	jQuery( 'del, strike, s' ).wrap( '<span class="line-through" />' );

	// Menu item count.
	jQuery( 'body' ).addClass( 'menu-col-' + jQuery( '.menu-super > ul > li' ).length );

	// Adds a class to the comments container if we have a nav (paginated comments).
	jQuery( '.comments-nav' ).parents( '#comments' ).addClass( 'has-comments-nav' );

	// Hide separator for no comments span.
	jQuery( 'span.comments-link' ).prev( '.sep' ).hide();

	// Classes for pagination list items.
	jQuery( '.nav-links li .prev' ).parent().addClass( 'nav-item-prev' );
	jQuery( '.nav-links li .next' ).parent().addClass( 'nav-item-next' );

	/* === Menu toggle. === */

	// Adds our overlay div.
	jQuery( '.below-site-header' ).prepend( '<div class="overlay">' );

	// Assume the initial scroll position is 0.
	var scroll = 0;

	// Wait for a click on one of our menu toggles.
	jQuery( '.menu-toggle button' ).click( function() {

		// Assign this (the button that was clicked) to a variable.
		var button = this;

		// Gets the actual menu (parent of the button that was clicked).
		var menu = jQuery( this ).parents( '.menu' );

		// Remove selected classes from other menus.
		jQuery( '.menu-toggle button' ).not( button ).removeClass( 'selected' );
		jQuery( '.menu' ).not( menu ).removeClass( 'is-open' );

		// Toggle the selected classes for this menu.
		jQuery( button ).toggleClass( 'selected' );
		jQuery( menu ).toggleClass( 'is-open' );

		// Is the menu in an open state?
		var is_open = jQuery( menu ).hasClass( 'is-open' );

		// If the menu is open and there wasn't a menu already open when clicking.
		if ( is_open && ! jQuery( 'body' ).hasClass( 'menu-open' ) ) {

			// Get the scroll position if we don't have one.
			if ( 0 === scroll ) {
				scroll = jQuery( 'body' ).scrollTop();
			}

			// Add a custom body class.
			jQuery( 'body' ).addClass( 'menu-open' );

		// If we're closing the menu.
		} else if ( ! is_open ) {

			jQuery( 'body' ).removeClass( 'menu-open' );
			jQuery( 'body' ).scrollTop( scroll );
			scroll = 0;
		}
	} );

	// Close menus when somewhere else in the document is clicked.
	jQuery( document ).click( function() {

		jQuery( 'body' ).removeClass( 'menu-open' );
		jQuery( '.menu-toggle button' ).removeClass( 'selected' );
		jQuery( '.menu' ).removeClass( 'is-open' );
	} );

	// Stop propagation if clicking inside of our main menu.
	jQuery( '.menu-super' ).on( 'click', function( e ) {

		e.stopPropagation();
	} );

} );
