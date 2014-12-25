<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

Maera_Template::dependencies();

Maera_Template::get_header();
Maera_Template::content();
Maera_Template::get_footer();
