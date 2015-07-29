<?php if ( have_posts() ) : ?>

	<header class="page-header <?php echo Maera()->shell['instance']->row(); ?>">
		<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	</header><!-- .page-header -->

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			Maera::get_template_part( 'template-parts/content', get_post_format() );
		?>

	<?php endwhile; ?>

	<?php the_posts_navigation(); ?>

<?php else : ?>

	<?php Maera::get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>
