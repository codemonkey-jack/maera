<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Maera
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php maera_get_template_part( 'template-parts/head' ); ?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'maera' ); ?></a>

	<?php maera_get_template_part( 'template-parts/header' ); ?>

	<main id="content" class="site-content mdl-layout__content">
