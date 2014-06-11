<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

$templates = array(
	'archive.twig',
	'index.twig'
);

$data = Timber::get_context();

$data['title'] = 'Archive';

if ( is_day() ) {
	$data['title'] = sprintf( __( 'Day: %s', 'shoestrap' ), '<span>' . get_the_date() . '</span>' );
} else if ( is_month() ) {
	$data['title'] = sprintf( __( 'Month: %s', 'shoestrap' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'shoestrap' ) ) . '</span>' );
} else if ( is_year() ) {
	$data['title'] = sprintf( __( 'Year: %s', 'shoestrap' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'shoestrap' ) ) . '</span>' );
} else if ( is_tag() ) {
	$data['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
	$data['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} else if ( is_post_type_archive() ) {
	$data['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
} else if ( is_author() ) {
	$data['title'] = sprintf( __( 'Author: %s', 'shoestrap' ), '<span class="vcard">' . get_the_author() . '</span>' );
} else if ( is_tax( 'post_format', 'post-format-aside' ) ) {
	$data['title'] = __( 'Asides', 'shoestrap' );
} else if ( is_tax( 'post_format', 'post-format-gallery' ) ) {
	$data['title'] = __( 'Galleries', 'shoestrap');
} else if ( is_tax( 'post_format', 'post-format-image' ) ) {
	$data['title'] = __( 'Images', 'shoestrap');
} else if ( is_tax( 'post_format', 'post-format-video' ) ) {
	$data['title'] = __( 'Videos', 'shoestrap' );
} else if ( is_tax( 'post_format', 'post-format-quote' ) ) {
	$data['title'] = __( 'Quotes', 'shoestrap' );
} else if ( is_tax( 'post_format', 'post-format-link' ) ) {
	$data['title'] = __( 'Links', 'shoestrap' );
} else if ( is_tax( 'post_format', 'post-format-status' ) ) {
	$data['title'] = __( 'Statuses', 'shoestrap' );
} else if ( is_tax( 'post_format', 'post-format-audio' ) ) {
	$data['title'] = __( 'Audios', 'shoestrap' );
} else if ( is_tax( 'post_format', 'post-format-chat' ) ) {
	$data['title'] = __( 'Chats', 'shoestrap' );
} else {
	$data['title'] = __( 'Archives', 'shoestrap' );
}

$data['posts'] = Timber::get_posts();

Timber::render( $templates, $data );
