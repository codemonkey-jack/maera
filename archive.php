<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

global $maera_i18n;

$templates = Maera_Init::twig_archive_templates();
$data = Timber::get_context();

$data['title'] = 'Archive';

if ( is_day() ) {
	$data['title'] = sprintf( $maera_i18n['day_s'], '<span>' . get_the_date() . '</span>' );
} else if ( is_month() ) {
	$data['title'] = sprintf( $maera_i18n['month_s'], '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'maera' ) ) . '</span>' );
} else if ( is_year() ) {
	$data['title'] = sprintf( $maera_i18n['year_s'], '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'maera' ) ) . '</span>' );
} else if ( is_tag() ) {
	$data['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
	$data['title'] = single_cat_title( '', false );
} else if ( is_post_type_archive() ) {
	$data['title'] = post_type_archive_title( '', false );
} else if ( is_author() ) {
	$data['title'] = sprintf( $maera_i18n['author_s'], '<span class="vcard">' . get_the_author() . '</span>' );
} else if ( is_tax( 'post_format', 'post-format-aside' ) ) {
	$data['title'] = $maera_i18n['asides'];
} else if ( is_tax( 'post_format', 'post-format-gallery' ) ) {
	$data['title'] = $maera_i18n['galleries'];
} else if ( is_tax( 'post_format', 'post-format-image' ) ) {
	$data['title'] = $maera_i18n['images'];
} else if ( is_tax( 'post_format', 'post-format-video' ) ) {
	$data['title'] = $maera_i18n['videos'];
} else if ( is_tax( 'post_format', 'post-format-quote' ) ) {
	$data['title'] = $maera_i18n['quotes'];
} else if ( is_tax( 'post_format', 'post-format-link' ) ) {
	$data['title'] = $maera_i18n['links'];
} else if ( is_tax( 'post_format', 'post-format-status' ) ) {
	$data['title'] = $maera_i18n['statuses'];
} else if ( is_tax( 'post_format', 'post-format-audio' ) ) {
	$data['title'] = $maera_i18n['audios'];
} else if ( is_tax( 'post_format', 'post-format-chat' ) ) {
	$data['title'] = $maera_i18n['chats'];
} else {
	$data['title'] = $maera_i18n['archives'];
}

$data['posts'] = Timber::query_posts( false, 'TimberPost' );

Timber::render( $templates, $data, apply_filters( 'maera/timber/cache', false ) );
