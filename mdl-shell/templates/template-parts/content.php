<?php
/**
 * Template part for displaying posts.
 *
 * @package Maera
 */

?>
<article id="post-<?php the_ID(); ?>" class="mdl-grid single-post-content-wrapper">
	<div class="mdl-card mdl-shadow--4dp mdl-cell mdl-cell--12-col">
		<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>
		<div class="single-post-featured-image mdl-card__media mdl-color-text--grey-50"<?php echo ( $feat_image ) ? ' style="background-image:url(' . $feat_image . ');"' : ''; ?>>
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</div>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="mdl-color-text--grey-700 mdl-card__supporting-text meta">
				<?php maera_posted_on(); ?>
				<div class="section-spacer"></div>
			</div>
		<?php endif; ?>
		<div class="mdl-color-text--grey-700 mdl-card__supporting-text entry-content">
			<div class="inner">
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'maera' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
				?>
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
