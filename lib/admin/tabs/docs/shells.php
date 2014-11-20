<?php

$shell_tabs = array(
    'creating-shells'   => 'Creating Shells',
    'macros'           => 'Macros',
);
?>

<div id="shell_header">
      <p>Shells can be built as plugins and allow you to completely custom-code your own theme, overriding the default templates of the theme as well as its stylesheets and other scripts.</p>
      <p>The default templates of the theme already include a lot of hooks and actions you can use, allowing for a sane markup, SEO-optimization and easy to modify using a <a href="/docs/shells/macros/">shell macros</a> file.</p>
      <p>If needed, you can override the default templates by <a href="/docs/shells/views/">adding your own template views</a>.
      If you would like to learn more about Shells, you can read the docs below:</p>
</div>
<hr>

<div id="shell-tabs">
  <ul>
    <?php foreach ( $shell_tabs as $shell_tab => $shell_tab_label ) : ?>
      <li><a href="#<?php echo $shell_tab; ?>"><?php echo $shell_tab_label; ?></a></li>
    <?php endforeach; ?>
  </ul>
  <?php foreach ( $shell_tabs as $shell_tab => $shell_tab_label ) : ?>
    <div id="<?php echo $shell_tab; ?>">
      <h2><?php echo $shell_tab_label; ?></h2>
      <?php include( dirname( __FILE__ ) . '/' . $shell_tab . '.php' ); ?>
    </div>
  <?php endforeach; ?>
</div>

<script>
	jQuery(document).ready(function($) {
		$( "#shell-tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#shell-tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
</script>
