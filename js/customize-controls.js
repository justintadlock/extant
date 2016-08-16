( function( $, api ) {

	// Shows or hides sections and controls based on the layout type.
	api( 'layout_type', function( value ) {
		value.bind(
			function( to ) {

				if ( 'boxed' === to ) {
					api.section( 'background_image' ).activate();
					api.control( 'background_color' ).activate();

				} else if ( 'full' == to ) {
					api.section( 'background_image' ).deactivate();
					api.control( 'background_color' ).deactivate();
				}
			}
		);
	} );

	// Extends our custom "locked" section.
	api.sectionConstructor['locked'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {
			var section = this;

			// Expand/Collapse accordion sections on click.
			section.container.find( '.accordion-section-title > button, .customize-section-back' ).on( 'click keydown', function( event ) {
				if ( api.utils.isKeydownButNotEnterEvent( event ) ) {
					return;
				}
				event.preventDefault(); // Keep this AFTER the key filter above

				if ( section.expanded() ) {
					section.collapse();
				} else {
					section.expand();
				}
			});
		},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	// Extends the core control constructor so that it handles a setting change.
	api.controlConstructor['select-icon'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'select', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );

} )( jQuery, wp.customize );
