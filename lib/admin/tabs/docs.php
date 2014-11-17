<!-- Begin Header -->
<div id="docs_header">
	<h2>This tab will contain the theme documentation.</h2>
	<p>For the time being you can see partial docs in the <a href="https://github.com/presscodes/maera/wiki">Repository's Wiki</a> on github.</p>
</div>
<!-- End Header -->

<!-- Begin Tabs -->
<div id="tabs-vertical">
	<!-- Begin Tab Titles -->
	<ul>
		<li><a href="#tab-1">Topic 1</a></li>
		<li><a href="#tab-2">Topic 2</a></li>
		<li><a href="#tab-3">Topic 3</a></li>
		<li><a href="#tab-4">Topic 4</a></li>
		<li><a href="#tab-5">Topic 5</a></li>
		<li><a href="#tab-6">Topic 6</a></li>
	</ul>
	<!-- End Tab Titles -->
	<!-- Begin Tab Content -->
	<div id="tab-1">
		<p>Lorem</p>
	</div>
	<div id="tab-2">
		<p>Ipsum</p>
	</div>
	<div id="tab-3">
		<p>Vehicula</p>
	</div>
	<div id="tab-4">
		<p>Lorem</p>
	</div>
	<div id="tab-5">
		<p>Ipsum</p>
	</div>
	<div id="tab-6">
		<p>Vehicula</p>
	</div>
	<!-- End Tab Content -->
</div>
<!-- End Tabs -->

<script>
jQuery(document).ready(function($) {
	$( "#tabs-vertical" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	$( "#tabs-vertical li" ).tabs().removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
});
</script>
