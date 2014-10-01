<?php


function maera_ext_posts_excerpt( $limit = 20, $read_more_text ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );

	if ( count( $excerpt ) >= $limit ) :
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt ) . ' <a href="' . get_post_permalink() . '">' . $read_more_text . '</a>';
	else :
		$excerpt = implode( ' ', $excerpt );
	endif;

	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
	return $excerpt;
}


function maera_ext_posts_content( $limit, $read_more_text ) {
	$content = explode( ' ', get_the_content(), $limit );

	if ( count( $content ) >= $limit ) :
		array_pop( $content );
		$content = implode( ' ', $content ) . ' <a href="' . get_post_permalink() . '">' . $read_more_text . '</a>';
	else :
		$content = implode( ' ', $content );
	endif;

	$content = preg_replace( '/\[.+\]/', '', $content );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	return $content;
}