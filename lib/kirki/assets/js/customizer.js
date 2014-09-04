jQuery.noConflict();

/** Fire up jQuery - let's dance!
 */
jQuery(document).ready(function($){

    var loader_overlay = '<div id="maera-loader-overlay" class="wp-full-overlay-main"></div>';
    var spinner_opts = {
      lines: 7, // The number of lines to draw
      length: 40, // The length of each line
      width: 30, // The line thickness
      radius: 0, // The radius of the inner circle
      corners: 1, // Corner roundness (0..1)
      rotate: 38, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#1abc9c', // #rgb or #rrggbb or array of colors
      speed: 1.3, // Rounds per second
      trail: 38, // Afterglow percentage
      shadow: false, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'kirki-spinner', // The CSS class to assign to the spinner
      zIndex: 2e9, // The z-index (defaults to 2000000000)
      top: '50%', // Top position relative to parent
      left: '50%', // Left position relative to parent
      shadow: true, // Whether to render a shadow
      hwaccel: true  // Whether to use hardware acceleration
    };

    $('#customize-preview').append(loader_overlay);
    var target = document.getElementById('maera-loader-overlay');
    var spinner = new Spinner(spinner_opts).spin(target);

    $(document).bind('ajaxSend', function(){
        $('#maera-loader-overlay').show();
    }).bind('ajaxComplete', function(){
        $('#maera-loader-overlay').hide();
    });

	$('a.tooltip').tooltipsy({
	    offset: [10, 0],
	    css: {
	        'padding': '6px 15px',
	        'max-width': '200px',
	        'color': '#f7f7f7',
	        'background-color': '#222222',
	        'border': '1px solid #333333',
	        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
	        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
	        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
	        'text-shadow': 'none',
	        'border-radius' : '3px'
	    }
	});

    // Debounce  textarea inputs for better live updating
    $('.of-input').keyup(_.debounce(function(e){
        // get content
        var contents = $(this).val().trim();
        var child_window = $('iframe')[0].contentWindow;
        var child$ = child_window.jQuery;
        var wrapped_content = "";

        if ($(this).data('customize-setting-link') == "css") {
            child$('#kirki-css-inject').remove();
            wrapped_content = '<style id="kirki-css-inject" type="text/css">' + contents + '</style>';
        } else if ($(this).data('customize-setting-link') == "less") {
            child$('#kirki-less-inject').remove();
            wrapped_content = '<style id="kirki-less-inject" type="text/less">' + contents + '</style>';
            child$('head').append(wrapped_content);
            child_window.less.refreshStyles();
            child_window.less.modifyVars();
        } 
        // inject the content
        if (wrapped_content) child$('head').append(wrapped_content);
    }, 1000));

});


