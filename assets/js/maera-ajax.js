/*
	jQuery for All-AJAX theme
	Original JavaScript by Chris Coyier
	Updated October 2010 by Stewart Heckenberg & Chris Coyier
	Updated May 2011 by Chris Coyier
	Updated Sep 2012 by Jeff Starr
*/

// Self-Executing Anonymous Function to avoid more globals
(function($){

	// add spinner via JS, cuz would never need it otherwise
	$(config.wrapper).append(config.loader);

	var	$el;

	// auto-clear search field
	$(config.search_selector).focus(function(){
		if ($(this).val() == config.search_text){
			$(this).val("");
		}
	});

	// query search results
	$('#searchform').submit(function(){
		var s = $(config.search_selector).val().replace(/ /g, '+');
		if (s){
			var query = '/?s=' + s;
			$.address.value(query);
		}
		return false;
	});

	// URL internal is via plugin http://benalman.com/projects/jquery-urlinternal-plugin/
	$('a[data-ajax]').live('click', function(e){

		$el = $(this); // Caching

		if ((!$el.hasClass("comment-reply-link")) && ($el.attr("id") != 'cancel-comment-reply-link')){
			var path = $(this).attr('href').replace(config.base, '');
			$.address.value(path);
			$(".current_page_item").removeClass("current_page_item");
			$("a").removeClass("current_link");
			$el.addClass("current_link").parent().addClass("current_page_item");
			return false;
		}
		// Default action (go to link) prevented for comment-related links (which use onclick attributes)
		e.preventDefault();
	});

	// Fancy ALL AJAX Stuff
	$.address.change(function(event){
		if (event.value){
			$(config.loader_selector).fadeIn();
			$(config.main).empty().load(config.base + event.value + ' ' + config.main, function(){
				$(config.loader_selector).fadeOut('fast');
				$(config.main).fadeIn('fast');
			});
		}
		var current = location.protocol + '//' + location.hostname + location.pathname;
		if (config.base + '/' != current) {
			var diff = current.replace(config.base, '');
			location = config.base + '/#' + diff;
		}
	});

})(jQuery);
