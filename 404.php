<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package  WordPress
 * @subpackage  Maera
 * @since    Maera 0.1
 */

$context = Maera_Timber::get_context();
Maera_Timber::render( '404.twig', $context, apply_filters( 'maera/timber/cache', false ) );
