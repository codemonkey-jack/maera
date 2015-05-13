<?php

global $product, $post;
$product = get_product( $post->ID );

Maera()->views->dependencies();

Maera()->views->header();
Maera()->views->render( 'single-product.twig' );
Maera()->views->footer();
