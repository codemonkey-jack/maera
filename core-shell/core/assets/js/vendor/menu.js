(function($) {
	$(function() {
		$( ".menu-button" ).click( function() {
			$( "body" ).toggleClass( "show-menu" );
		});
		$( "#layout, .page-header" ).click( function() {
			$( "body" ).removeClass( "show-menu" );
		});
	});
})(jQuery);