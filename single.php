<?php
/**
 * The Template for displaying all single posts.
 *
 * @package maera
 */

Maera_Template::dependencies();

Maera_Template::header();
Maera_Template::main( maera_templates_singular() );
Maera_Template::footer();
