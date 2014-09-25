<?php

if ( ! class_exists( 'Maera_Image' ) ) {

	/**
	* The Image handling class
	*/
	class Maera_Image {

		function __construct() {}

		/*
		 * Proxy function to be called whenever an image is used. If you wish to resize, use maera_image_resize()
		 */
		public static function image( $img ) {

			if ( empty( $img ) || ( empty( $img['id'] ) && empty( $img['url'] ) ) ) {
				return; // Nothing here to do!
			}

			// Get the full size attachment
			$image = wp_get_attachment_image_src( $img['id'], 'full' );

			$img['url'] = $image[0];

			$img['width'] = $image[1];
			$img['height'] = $image[2];

			return maera_image_resize( $img );
		}

		public static function image_resize( $data ) {

			$defaults = array(
				"url"       => "",
				"width"     => "",
				"height"    => "",
				"crop"      => true,
				"retina"    => "",
				"resize"    => true,
			);

			$settings = wp_parse_args( $data, $defaults );

			if ( empty( $settings['url'] ) ) {
				return;
			}

			// Generate the @2x file if retina is enabled
			if ( current_theme_supports( 'retina' ) ) {
				$results['retina'] = self::_resize( $settings['url'], $settings['width'], $settings['height'], $settings['crop'], true );
			}

			return self::_resize( $settings['url'], $settings['width'], $settings['height'], $settings['crop'], false );
		}

		/**
		 * Resizes an image and returns an array containing the resized URL, width, height and file type. Uses native Wordpress functionality.
		 * This is a slightly modified version of http://goo.gl/9iS0CO
		 *
		 * @return array   An array containing the resized image URL, width, height and file type.
		 */
		public static function _resize( $url, $width = NULL, $height = NULL, $crop = true, $retina = false ) {
			global $wpdb;

			if ( empty( $url ) ) {
				return new WP_Error( 'no_image_url', __( 'No image URL has been entered.', 'maera' ), $url );
			}

			// Get default size from database
			$width  = ( $width )  ? $width  : null;
			$height = ( $height ) ? $height : null;

			// Allow for different retina sizes
			$retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

			// Get the image file path
			$file_path = parse_url( $url );
			$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

			$editor = wp_get_image_editor( $file_path );
			// Get the original image size
			$size = $editor->get_size();
			$orig_width  = $size['width'];
			$orig_height = $size['height'];

			// Destination width and height variables
			$dest_width  = $width * $retina;
			$dest_height = ( is_null( $height ) ) ? intval( ( $dest_width / ( $orig_width / $orig_height ) ) * $retina ) : $height * $retina;

			// File name suffix (appended to original file name)
			$suffix_width  = ( ! is_null( $width ) ) ? ( $dest_width / $retina ) : 'Original';
			$suffix_height = ( $dest_height / $retina );
			$suffix_retina = ( $retina != 1 ) ? '@' . $retina . 'x' : NULL;

			$dest_width = ( 'Original' == $suffix_width ) ? $orig_width : $dest_width;
			$dest_height = ( 'Original' == $suffix_width ) ? $orig_height : $dest_height;
			$dest_height = ( 0 == $dest_height ) ? $orig_height : $dest_height;

			if ( 'Original' == $suffix_width && 'Original' == $suffix_height && is_null( $suffix_retina ) ) {
				$suffix = null;
			} else {
				$suffix = "{$suffix_width}x{$suffix_height}{$suffix_retina}";
			}

			// Some additional info about the image
			$info = pathinfo( $file_path );
			$dir = $info['dirname'];
			$ext = "";

			if ( ! empty( $info['extension'] ) ) {
				$ext = $info['extension'];
			}

			$name = wp_basename( $file_path, ".$ext" );

			// Get the destination file name
			$dest_file_name = ( ! is_null( $suffix ) ) ? "{$dir}/{$name}-{$suffix}.{$ext}" : "{$dir}/{$name}.{$ext}";

			if ( ! is_null( $suffix ) && ! file_exists( $dest_file_name ) ) {
				/*
				 *  Bail if this image isn't in the Media Library.
				 *  We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
				 */
				$query          = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
				$get_attachment = $wpdb->get_results( $query );

				if ( ! $get_attachment ) {
					return array( 'url' => $url, 'width' => $width, 'height' => $height );
				}

				// Load Wordpress Image Editor
				if ( is_wp_error( $editor ) ) {
					return array( 'url' => $url, 'width' => $width, 'height' => $height );
				}

				$src_x = $src_y = 0;
				$src_w = $orig_width;
				$src_h = $orig_height;

				if ( $crop ) {

					$cmp_x = $orig_width / $dest_width;
					$cmp_y = $orig_height / $dest_height;

					// Calculate x or y coordinate, and width or height of source
					if ( $cmp_x > $cmp_y ) {
						$src_w = round( $orig_width / $cmp_x * $cmp_y );
						$src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
					} elseif ( $cmp_y > $cmp_x ) {
						$src_h = round( $orig_height / $cmp_y * $cmp_x );
						$src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
					}
				}

				// Time to crop the image!
				$editor->crop( $src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height );

				// Now let's save the image
				$saved = $editor->save( $dest_file_name );

				// Get resized image information
				$resized_url    = str_replace( basename( $url ), basename( $saved['path'] ), $url );
				$resized_width  = $saved['width'];
				$resized_height = $saved['height'];
				$resized_type   = $saved['mime-type'];

				// Add the resized dimensions to original image metadata (so we can delete our resized images when the original image is delete from the Media Library)
				$metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
				if ( isset( $metadata['image_meta'] ) ) {
					$metadata['image_meta']['resized_images'][] = $resized_width .'x'. $resized_height;
					wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
				}

				// Create the image array
				$image_array = array(
					'url'    => $resized_url,
					'width'  => $resized_width,
					'height' => $resized_height,
					'type'   => $resized_type
				);
			} else {
				$image_array = array(
					'url'    => str_replace( basename( $url ), basename( $dest_file_name ), $url ),
					'width'  => $dest_width,
					'height' => $dest_height,
					'type'   => $ext
				);
			}

			// Return image array
			return $image_array;
		}

		public static function featured_image( $post_id = 0 ) {

			$args = array();

			$image_display = apply_filters( 'maera/image/display', 0 );
			$image_width   = apply_filters( 'maera/image/width', -1 );
			$image_height  = apply_filters( 'maera/image/height', 0 );

			// Do not continuee processing if a featured image does not exist
			if ( ! has_post_thumbnail( $post_id ) || '' == get_the_post_thumbnail( $post_id ) ) {
				return;
			}

			// Only process if we want to display the image
			if ( $image_display ) {

				$args['url'] = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );

				if ( -1 == $image_width ) {

					// If -1 then use max width
					$args['width'] = apply_filters( 'maera/content_width', 960 );

				} else if ( 0 == $image_width ) {

					// If 0 then use original width
					$args['width'] = null;

				} else {

					// Resize to selected width
					$args['width'] = $image_width;

					}

				if ( 0 == $image_height ) {
					// If 0 then use original height
					$args['height'] = null;
				} else {
					// Resize to selected height
					$args['height'] = $image_height;
				}

			}

			$image = self::image_resize( $args );

			return $image;


		}

	}

}
