<?php

/*
 * Display featured images on posts
 */
function shoestrap_get_featured_image( $context = null ) {

	$data = array();

	// Do not continue processing if there is no featured image
	if ( ! has_post_thumbnail() || '' == get_the_post_thumbnail() ) {

		$result = false;

	} else {

		// Set some default widths and heights.
		$data['width']  = apply_filters( 'shoestrap/content_width', 960 );
		$data['height'] = 350;

		if ( is_singular() ) {

			// Do not process if we don't want images on single posts
			if ( 1 != get_theme_mod( 'feat_img_post', 0 ) ) {

				$result = false;

			} else {

				$data['url']    = wp_get_attachment_url( get_post_thumbnail_id() );
				$data['width']  = apply_filters( 'shoestrap/images/singular/width',  $data['width'] );
				$data['height'] = apply_filters( 'shoestrap/images/singular/height', $data['height'] );

			}

		} else {

			// Do not process if we don't want images on post archives
			if ( 1 != get_theme_mod( 'feat_img_archive', 0 ) ) {

				$result = false;

			} else {

				$data['url']    = wp_get_attachment_url( get_post_thumbnail_id() );
				$data['width']  = apply_filters( 'shoestrap/images/archive/width',  $data['width'] );
				$data['height'] = apply_filters( 'shoestrap/images/archive/height', $data['height'] );

			}

		}

		$image = Shoestrap_Image::image_resize( $data );

		// Return the value we want, depending on the defined context.
		if ( 'url' == $context ) {
			$result = $image['url'];
		} elseif ( 'width' == $context ) {
			$result = $image['width'];
		} elseif ( 'height' == $context ) {
			$result = $image['height'];
		} elseif ( 'type' == $context ) {
			$result = $image['type'];
		} else {
			$result = true;
		}
	}

	return $result;

}
