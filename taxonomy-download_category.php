<?php

if ( ! get_query_var( 'post_type' ) ) {
    set_query_var( 'post_type', get_post_type() );
}

if ( $template = get_post_type_archive_template() ) {
    include $template;
}

