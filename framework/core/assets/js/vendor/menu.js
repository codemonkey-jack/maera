(function($) {
	$(function() {
		if ( $( "body" ).hasClass( "show-menu" ) ) {
			$( ".menu-button" ).click( function() {
				$( "body" ).removeClass( "show-menu" );
			});
		} else {
			$( ".menu-button" ).click( function() {
				$( "body" ).addClass( "show-menu" );
			});
		}
	});
})(jQuery);