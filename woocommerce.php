<?php

global $product, $post;
$product = get_product( $post->ID );

$template = ( is_singular( 'product' ) ) ? 'single-product.twig' : 'archive-product.twig';

Maera()->views->dependencies();

Maera()->views->header();
Maera()->views->render( $template );
Maera()->views->footer();
