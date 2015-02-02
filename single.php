<?php
/**
 * The Template for displaying all single posts.
 *
 * @package maera
 */

Maera()->views->dependencies();

Maera()->views->header();
Maera()->views->render( maera_templates_singular() );
Maera()->views->footer();
