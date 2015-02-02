<?php

Maera()->template->dependencies();

$context = Maera()->cache->get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['content'] = maera_get_echo( 'the_content' );

Maera()->template->header();
Maera()->template->render( 'bp.twig', $context );
Maera()->template->footer();
