<?php

class Maera_EDD_Tonesque {

    private $post_id;

    function __construct( $post_id = 0 ) {

        if ( 0 == $post_id ) {
            $post_id = get_the_ID();
        }

        $this->post_id = $post_id;

    }

    /**
    * Build CSS from Tonesque
    *
    * @uses get_the_ID(), is_single(), get_post_meta(), colorposts_get_post_image(), update_post_meta(), apply_filters()
    *
    * @since Color Posts 1.0
    */
    function colors() {

        $thumb_id  = get_post_thumbnail_id( $this->post_id );
        $thumb_url = wp_get_attachment_image_src( $thumb_id );
        $thumb_url = $thumb_url[0];
        $value = array();

        if ( $thumb_url ) {
            // Grab color from post meta
            $tonesque = get_post_meta( $thumb_id, '_post_colors', true );

            // No color? Let's get one
            if ( empty( $tonesque ) ) {
                $tonesque = new Tonesque( $thumb_url );
                $tonesque = array(
                    'color'    => $tonesque->color(),
                    'contrast' => $tonesque->contrast(),
                );

                if ( $tonesque['color'] ) {
                    update_post_meta( $this->post_id, '_post_colors', $tonesque );
                } else {
                    return;
                }
            }

            extract( $tonesque );
        }
        if ( ! isset( $color ) || ! $color ) {
            $color = 'FFFFFF';
        }

        $value['color'] = '#' . $color;

        $white = new Jetpack_Color( '#FFFFFF' );
        $color = new Jetpack_Color( '#' . $color );
        $value['luminosity'] = $color->toLuminosity();

        $value['fontcolor'] = ( $value['luminosity'] < 0.5 ) ? '#FFFFFF' : '#222222';
        $value['readable']  = '#' . $color->getReadableContrastingColor( $white, 6 )->toHex();

        return $value;
    }

}
