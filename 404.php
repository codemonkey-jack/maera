<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package  WordPress
 * @subpackage  Maera
 * @since    Maera 0.1
 */

Maera()->template->dependencies();

Maera()->template->header();
Maera()->template->render( '404.twig' );
Maera()->template->footer();
