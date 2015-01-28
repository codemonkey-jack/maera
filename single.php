<?php
/**
 * The Template for displaying all single posts.
 *
 * @package maera
 */

Maera()->template->dependencies();

Maera()->template->header();
Maera()->template->render( maera_templates_singular() );
Maera()->template->footer();
