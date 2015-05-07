<?php
/**
 * The template for displaying Author Archive pages
 */


Maera()->views->dependencies();

$context = Maera()->cache->get_context();

if ( is_singular( 'product' ) ) {

    $context['post']    = Timber::get_post();
    $product            = get_product( $context['post']->ID );
    $context['product'] = $product;

    $template = 'single-product.twig';

} else {

    $posts = Timber::get_posts();
    $context['products'] = $posts;

    if ( is_product_category() ) {

        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $context['category'] = get_term( $term_id, 'product_cat' );
        $context['title'] = single_term_title('', false);

    }

    $template = 'archive-product.twig';

}

Maera()->views->header();
Maera()->views->render( $template, $context );
Maera()->views->footer();
