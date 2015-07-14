<?php

Maera()->views->dependencies();

$context = Maera()->cache->get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['content'] = maera_get_echo( 'the_content' );

Maera()->views->header();
Maera()->views->render( 'bbp.twig', $context );
Maera()->views->footer();
