<?php

Maera()->template->dependencies();

$context = Maera_Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['content'] = maera_get_echo( 'the_content' );

Maera()->template->header();
Maera()->template->main( 'bp.twig', $context );
Maera_Template::footer();
