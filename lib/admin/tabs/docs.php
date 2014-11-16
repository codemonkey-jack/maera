<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style>
	/* Currently not minified for editing */
	/* Tabs */
	.ui-tabs{padding:0;border:none;position:relative;top:-3px;}
	.ui-tabs-nav{padding:0px 0px 0px 0px !important;border:none;border-bottom:1px solid;background-color:#ffffff;}
	.ui-tabs-nav .ui-state-default{border:none;padding:0px !important;margin-right:2px !important;background:none !important;}
	.ui-tabs-nav .ui-state-default a{border:1px solid;position:relative;top:2px;font-weight:bold;margin-bottom:4px;height:16px;}
	.ui-tabs-nav .ui-state-active a{border:1px solid;border-bottom:none !important;margin-bottom:0;height:22px;}
	.ui-tabs .ui-widget-content{border:1px solid !important;border-top:none !important;}
	.ui-tabs .ui-widget-content .ui-tabs {border:none !important;}
	.ui-tabs-nav .ui-state-hover{border:none;}
	.ui-tabs { position: relative; padding: .2em; zoom: 1; }
	.ui-tabs .ui-tabs-nav { margin: 0; padding: .2em .2em 0; }
	.ui-tabs .ui-tabs-nav li { list-style: none; float: left; position: relative; top: 1px; margin: 0 .2em 1px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
	.ui-tabs .ui-tabs-nav li a { float: left; padding: .5em 1em; text-decoration: none; }
	.ui-tabs .ui-tabs-nav li.ui-tabs-selected { margin-bottom: 0; padding-bottom: 1px; }
	.ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: text; }
	.ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a { cursor: pointer; }
	.ui-tabs .ui-tabs-panel { display: block; border-width: 0; padding: 1em 1.4em; background: none; }
	.ui-tabs .ui-tabs-hide { display: none !important; }
	/* Tab States */
	.ui-tabs-nav > .ui-state-default a{border-color:#e4e4e4;background:#e4e4e4;color:#000;}
	.ui-tabs-nav > .ui-state-active a{border-color:#d4d4d4 !important;background:#f1f1f1 !important;color:#525252 !important;}
	.ui-tabs-nav > .ui-state-hover a{background:#fff;border-color:#ccc;color:#000;}
	.ui-tabs-nav > .ui-state-focus a{background:#fff;border-color:;color:#000;}
	.ui-tabs .ui-widget-content{border-color:#d4d4d4 !important;background-color:#f1f1f1;}
	.ui-tabs-nav{border-color:#d4d4d4;}
	.ui-widget-content{ background: #f1f1f1 !important; }
	.ui-widget-header { background: #f1f1f1 !important; }
</style>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<!-- Begin Header -->
<div id="docs_header">
	<h2>This tab will contain the theme documentation.</h2>
	<p>For the time being you can see partial docs in the <a href="https://github.com/presscodes/maera/wiki">Repository's Wiki</a> on github.</p>
</div>
<!-- End Header -->

<!-- Begin Tabs -->
<div id="tabs">
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
