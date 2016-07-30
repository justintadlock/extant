jQuery( window ).ready( function() {

	/*
	 * Adds classes to the `<label>` element based on the type of form element the label belongs
	 * to. This allows theme devs to style specifically for certain labels (think, icons).
	 */

	jQuery( '#container input, #container textarea, #container select' ).each(

		function() {
			var sg_input_type = 'input';
			var sg_input_id   = jQuery( this ).attr( 'id' );
			var sg_label      = '';

			if ( jQuery( this ).is( 'input' ) )
				sg_input_type = jQuery( this ).attr( 'type' );

			else if ( jQuery( this ).is( 'textarea' ) )
				sg_input_type = 'textarea';

			else if ( jQuery( this ).is( 'select' ) )
				sg_input_type = 'select';

			jQuery( this ).parent( 'label' ).addClass( 'label-' + sg_input_type );

			if ( sg_input_id )
				jQuery( 'label[for="' + sg_input_id + '"]' ).addClass( 'label-' + sg_input_type );

			if ( 'checkbox' === sg_input_type || 'radio' === sg_input_type ) {
				jQuery( this ).parent( 'label' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

				if ( sg_input_id )
					jQuery( 'label[for="' + sg_input_id + '"]' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

			}
		}
	);

	/* Focus labels for form elements. */
	jQuery( 'input, select, textarea' ).on( 'focus blur',
		function() {
			var sg_focus_id   = jQuery( this ).attr( 'id' );

			if ( sg_focus_id )
				jQuery( 'label[for="' + sg_focus_id + '"]' ).toggleClass( 'focus' );
			else
				jQuery( this ).parents( 'label' ).toggleClass( 'focus' );
		}
	);

	/* Add class to links with an image. */
	jQuery( 'a' ).has( 'img' ).addClass( 'has-image' );
	jQuery( 'a' ).has( 'svg' ).addClass( 'has-svg' );

	jQuery( '#cancel-comment-reply-link' ).wrapInner(
		'<span class="screen-reader-text">'
	);

	//jQuery( '.site-title a' ).wrapInner( '<span class="name">' );

	//jQuery( '.comment-list .avatar' ).wrap( '<span class="avatar-wrap">' );

	/* Custom-colored line-through. */
	jQuery( 'del, strike, s' ).wrap( '<span class="line-through" />' );

	// menu item count
	//var numTopNavItems = jQuery( '.menu-super > ul > li' ).length;

	jQuery( 'body' ).addClass( 'menu-col-' + jQuery( '.menu-super > ul > li' ).length );

	// Adds a class to the comments container if we have a nav (paginated comments).
	jQuery( '.comments-nav' ).parents( '#comments' ).addClass( 'has-comments-nav' );

	// Hide separator for no comments span.
	jQuery( 'span.comments-link' ).prev( '.sep' ).hide();

	// Classes for pagination list items.
	jQuery( '.nav-links li .prev' ).parent().addClass( 'nav-item-prev' );
	jQuery( '.nav-links li .next' ).parent().addClass( 'nav-item-next' );

	/* Inline labels for comment form elements. *
	if ( jQuery( 'body' ).has( '.comment-form' ) ) {

		jQuery( '.comment-form p > label ' ).each(
			function( index ) {
				var labelText = jQuery( this ).text();

				jQuery( this ).addClass( 'screen-reader-text' );

				jQuery( this ).siblings( 'input, textarea' ).attr( 'placeholder', labelText );
			}
		);
	}*/

	/* Menu toggle. */

	jQuery( '.below-site-header' ).prepend( '<div class="overlay">' );

	var scroll = 0;

	function extantToggleClass( c ) {
			if ( ! jQuery( 'body' ).hasClass( c ) ) {

				if ( 0 === scroll ) {
					scroll = jQuery( 'body' ).scrollTop();
				}

				jQuery( 'body' ).addClass( 'menu-open' ).addClass( c );
				jQuery( 'html' ).addClass( 'menu-open' );
			} else {
				jQuery( 'body' ).removeClass( 'menu-open' ).removeClass( c );
				jQuery( 'html' ).removeClass( 'menu-open' );
				jQuery( 'body' ).scrollTop( scroll );
				scroll = 0;
			}
	}

	jQuery( '.menu-toggle-primary button' ).click(
		function( e ) {

			jQuery( '.menu-toggle button' ).not( this ).removeClass( 'selected' );

			jQuery( this ).toggleClass( 'selected' );

			if ( jQuery( 'body' ).hasClass( 'menu-search-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-search-open' );
			}
			else if ( jQuery( 'body' ).hasClass( 'menu-secondary-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-secondary-open' );
			}

			extantToggleClass( 'menu-primary-open' );
		}
	);

	jQuery( '.menu-toggle-secondary button' ).click(
		function( e ) {

			jQuery( '.menu-toggle button' ).not( this ).removeClass( 'selected' );

			jQuery( this ).toggleClass( 'selected' );

			if ( jQuery( 'body' ).hasClass( 'menu-search-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-search-open' );
			}
			else if ( jQuery( 'body' ).hasClass( 'menu-primary-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-primary-open' );
			}

			extantToggleClass( 'menu-secondary-open' );
		}
	);

	jQuery( '.menu-toggle-search button' ).click(
		function( e ) {

			jQuery( '.menu-toggle button' ).not( this ).removeClass( 'selected' );

			jQuery( this ).toggleClass( 'selected' );

			if ( jQuery( 'body' ).hasClass( 'menu-primary-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-primary-open' );
			}
			else if ( jQuery( 'body' ).hasClass( 'menu-secondary-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-secondary-open' );
			}

			extantToggleClass( 'menu-search-open' );
		}
	);

	jQuery( document ).click(
		function() {

			jQuery( 'body' ).removeClass( 'menu-open' );
				jQuery( 'html' ).removeClass( 'menu-open' );
			jQuery( '.menu-toggle button' ).removeClass( 'selected' );

			if ( jQuery( 'body' ).hasClass( 'menu-primary-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-primary-open' );
			}

			if ( jQuery( 'body' ).hasClass( 'menu-search-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-search-open' );
			}

			if ( jQuery( 'body' ).hasClass( 'menu-secondary-open' ) ) {
				jQuery( 'body' ).toggleClass( 'menu-secondary-open' );
			}
		}
	);

	jQuery( '.menu-primary, .menu-search, .menu-secondary' ).on( 'click',
		function( e ) {
			e.stopPropagation();
		}
	);
    function closeMobileMenu() {

     //   var mobileContent = $("#mobile_menu_content");
        // now `unlock` the body contents and put things back to
        // normal before fading out the mobile menu.
        var bodyTemp = $('.body_temp');
        var scrolltop = Math.abs(bodyTemp.position().top);

        $('#body_wrapper').append(bodyTemp.contents());
        bodyTemp.remove();

        $("body").scrollTop(scrolltop);
     //   mobileContent.fadeOut("slow", function() {
       //     slideUpAllMobileMenusExcept(null);
       // });
    }

    function openMobileMenu() {

     //   var mobileContent = $("#mobile_menu_content");

        // get the current scroll position, and then `lock` the body
        // contents in a div that won't scroll. This prevents the background from
        // scrolling when the mobile menu is open.
        var scrolltop = $(window).scrollTop();
        $("<div class='body_temp' />")
        	.append($('#body_wrapper')
                .contents())
        	.css('position', 'fixed')
        	.css('top', "-" + scrolltop + 'px')
        	.width($(window).width())
        	.appendTo('#body_wrapper');

        // fade in the mobile menu
      //  mobileContent.fadeIn("slow");
    }

} );
