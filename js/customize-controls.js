( function( $, api ) {

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
