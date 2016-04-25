(function($) {

	function heightAdjuster() {
		$( '#main' ).find( '.hentry' ).each( function() {

			metaheight = $(this).find( '.entry-meta' ).height();

			$(this).css( 'min-height', metaheight + 72 + 'px' );
			$(this).find( '.entry-content' ).css( 'min-height', metaheight + 'px' );

		} );
	}

	/*
	 * Toggle slide menu
	 */
	function slideControl() {
		$( '.menu-toggle' ).on( 'click', function( e ) {
			e.preventDefault();
			$( '.slide-menu' ).toggleClass( 'expanded' ).resize();
			$( 'body' ).toggleClass( 'sidebar-open' );
			$( this ).toggleClass( 'toggle-on' );
		} );
	}

	$(window).on( 'load', function() {
		heightAdjuster();
		slideControl();
	} );

	$(window).on( 'resize', function() {
		heightAdjuster();
	} );

	/* Adjust heights after IS loads */
	$(document).on( 'post-load', function() {
		heightAdjuster();
	} );

})(jQuery);