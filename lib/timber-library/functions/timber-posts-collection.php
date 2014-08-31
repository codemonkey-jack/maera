<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
    exit;

class TimberPostsCollection extends ArrayObject {

    public function __construct( $array = array(), $post_class = 'TimberPost' ) {
        $posts = array();
        if ( is_null( $array ) ){
            $array = array();
        }
        foreach ( $array as $rid ) {
            $post_class_use = $post_class;

            if ( is_array( $post_class ) ) {
                $post_type      = get_post_type( $rid );
                $post_class_use = 'TimberPost';

                if ( isset( $post_class[$post_type] ) ) {
                    $post_class_use = $post_class[$post_type];

                } else {
                    if ( is_array( $post_class ) ) {
                        TimberHelper::error_log( $post_type . ' of ' . $rid . ' not found in ' . print_r( $post_class, true ) );
                    } else {
                        TimberHelper::error_log( $post_type . ' not found in ' . $post_class );
                    }
                }
            }

            // Don't create yet another object if $rid is already of the right type
            if ( is_a( $rid, $post_class_use ) ) {
                $post = $rid;
            } else {
                $post = new $post_class_use( $rid );
            }

            if ( isset( $post->ID ) ) {
                $posts[] = $post;
            }
        }

        $posts = self::maybe_set_preview($posts);

        parent::__construct( $posts, $flags = 0, 'TimberPostsIterator' );
    }

    public function get_posts() {
        return $this->getArrayCopy();
    }

     /**
     * @param array $posts
     * @return array
     */
    static function maybe_set_preview( $posts ) {
        if ( is_array( $posts ) && isset( $_GET['preview'] ) && $_GET['preview']
               && isset( $_GET['preview_id'] ) && $_GET['preview_id']
               && current_user_can( 'edit_post', $_GET['preview_id'] ) ) {
            // No need to check the nonce, that already happened in _show_post_preview on init

            $preview_id = $_GET['preview_id'];
            foreach( $posts as &$post ) {
                if ( is_object( $post ) && $post->ID == $preview_id ) {
                    // Based on _set_preview( $post ), but adds import_custom
                    $preview = wp_get_post_autosave( $preview_id );
                    if ( is_object($preview) ) {

                        $preview = sanitize_post($preview);

                        $post->post_content = $preview->post_content;
                        $post->post_title = $preview->post_title;
                        $post->post_excerpt = $preview->post_excerpt;
                        $post->import_custom( $preview_id );

                        add_filter( 'get_the_terms', '_wp_preview_terms_filter', 10, 3 );
                    }
                }
            }

        }

        return $posts;
    }

}

class TimberPostsIterator extends ArrayIterator {

    public function current() {
        global $post;
        $post = parent::current();
        return $post;
    }
}
