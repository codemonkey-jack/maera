<?php

$docs_tabs = array(
		'general'        => 'General & FAQ',
		'templating'     => 'Templating',
		'shells'         => 'Shells',
		'theme-supports' => 'Theme Supports',
		'actions'        => 'Actions & Hooks',
		'filters'        => 'Filters',
);
?>
<div id="docs_header">
	<h2>Theme documentation.</h2>
	<p>You can also access the most recent docs in the <a href="https://github.com/presscodes/maera/wiki">Repository's Wiki</a> on github.</p>
</div>

<div id="docs-tabs">
	<ul>
		<?php foreach ( $docs_tabs as $docs_tab => $docs_tab_label ) : ?>
			<li><a href="#<?php echo $docs_tab; ?>"><?php echo $docs_tab_label; ?></a></li>
		<?php endforeach; ?>
	</ul>

	<?php foreach ( $docs_tabs as $docs_tab => $docs_tab_label ) : ?>
		<div id="<?php echo $docs_tab; ?>">
			<h2><?php echo $docs_tab_label; ?></h2>
			<?php include( dirname( __FILE__ ) . '/docs/' . $docs_tab . '.php' ); ?>
		</div>
	<?php endforeach; ?>
</div>

<script>
jQuery(document).ready(function($) {
	$( "#docs-tabs" ).tabs();
});
</script>
