<?php
/**
 * The template for displaying all single posts.
 *
 * @package Maera
 */

maera_get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <?php include maera_template_path(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php maera_get_footer();
