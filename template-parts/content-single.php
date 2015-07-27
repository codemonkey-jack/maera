<?php
/**
 * Template part for displaying single posts.
 *
 * @package Maera
 */

?>

<article id="post-<?php the_ID(); ?>" class="mdl-grid single-post-content-wrapper">
	<div class="mdl-card mdl-shadow--4dp mdl-cell mdl-cell--12-col">
		<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>
		<div class="single-post-featured-image mdl-card__media mdl-color-text--grey-50"<?php echo ( $feat_image ) ? ' style="background-image:url(' . $feat_image . ');"' : ''; ?>>
			<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
		</div>
		<div class="mdl-color-text--grey-700 mdl-card__supporting-text meta">
			<?php maera_posted_on(); ?>
			<div class="section-spacer"></div>
			<div>
				<i class="material-icons" role="presentation">share</i>
				<span class="visuallyhidden">share</span>
			</div>
		</div>
		<div class="mdl-color-text--grey-700 mdl-card__supporting-text entry-content">
			<div class="inner">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'maera' ),
					'after'  => '</div>',
				) );
				?>
				<?php the_post_navigation(); ?>
			</div>
		</div>
		<div class="entry-footer mdl-color-text--primary-contrast mdl-card__supporting-text comments">
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
			<?php maera_entry_footer(); ?>
		</div><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
