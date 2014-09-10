jQuery(document).ready(function($) {
	var jPM = {};

	$(function() {

		jPM = $.jPanelMenu({

			menu : '#menu',
			trigge : '.menu-trigger',
			animated: false,
			beforeOpen : ( function() {

				if (matchMedia('only screen and (min-width: 992px)').matches) {
					$('.sidebar').css("left", "250px");
				}

			}),
			beforeClose : ( function() {

				$('.sidebar').css("left", "0");
				$('.writer-icon, .side-writer-icon').removeClass("fadeOutUp");
			})
		});

		jPM.on();

		var fullHeight = $(window).height();

		$('.hero-image-404').css("height", fullHeight );

	});
});
