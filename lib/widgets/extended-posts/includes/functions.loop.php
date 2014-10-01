<?php

function ssnw_posts_loop( $post_type = 'post', $taxonomy = '', $term = '', $posts_per_page = 5, $offset = 0, $thumb = false, $thumb_float = true, $thumb_width = 150, $thumb_height = 100, $excerpt_length = 20, $read_more_text = '...', $post_title_size = 'h4' ) {

	// Set-Up the taxonomy query
	if ( 'maera_all_terms' != $term ) {

		$tax_query = array( array(
			'taxonomy' => $taxonomy,
			'field'    => 'id',
			'terms'    => array( $term ),
		) );

	} else {

		$tax_query = '';

	}

	// Start the arguments
	$args = array(
		'post_type'      => $post_type,
		'tax_query'      => $tax_query,
		'taxonomy'       => $taxonomy,
		'terms'          => $term,
		'posts_per_page' => $posts_per_page,
		'offset'         => $offset,
	);

	$thumb_class = ( $thumb_float ) ? 'class="pull-left"' : '';

	// The Query
	$the_query = new WP_Query( $args );

	// The Loop
	$i = 0;
	while ( $the_query->have_posts() ) : $i++;
		$the_query->the_post();

		$image_args['width']  = $thumb_width;
		$image_args['url']    = wp_get_attachment_url( get_post_thumbnail_id() );
		$image_args['height'] = $thumb_height;

		$image = Maera_Image::image_resize( $image_args );
		?>

		<div class="media">

			<?php if ( $thumb && has_post_thumbnail() ) : ?>

				<?php if ( !$thumb_float ) : ?>

					<div class="media-body">
						<a href="<?php the_permalink(); ?>">

							<?php if ( $post_title_size == 'h3' ) : ?>
								<h3 class="media-heading">
							<?php elseif ( $post_title_size == 'h4' ) : ?>
								<h4 class="media-heading">
							<?php else : ?>
								<strong class="media-heading">
							<?php endif; ?>

								<?php the_title(); ?>

							<?php if ( $post_title_size == 'h3' ) : ?>
								</h3>
							<?php elseif ( $post_title_size == 'h4' ) : ?>
								</h4>
							<?php else : ?>
								</strong><br />
							<?php endif; ?>

						</a>

				<?php endif; ?>

				<a <?php echo $thumb_class; ?> href="<?php the_permalink(); ?>">
					<img class="media-object" src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>">
				</a>

			<?php endif; ?>

			<?php if ( $thumb && has_post_thumbnail() && !$thumb_float ) : ?>

				<?php echo maera_ext_posts_excerpt( $excerpt_length, $read_more_text ); ?>

			<?php else : ?>

				<div class="media-body">
					<a href="<?php the_permalink(); ?>">

						<?php if ( $post_title_size == 'h3' ) : ?>
							<h3 class="media-heading">
						<?php elseif ( $post_title_size == 'h4' ) : ?>
							<h4 class="media-heading">
						<?php else : ?>
							<strong class="media-heading">
						<?php endif; ?>

							<?php the_title(); ?>

						<?php if ( $post_title_size == 'h3' ) : ?>
							</h3>
						<?php elseif ( $post_title_size == 'h4' ) : ?>
							</h4>
						<?php else : ?>
							</strong><br />
						<?php endif; ?>

					</a>

					<?php echo maera_ext_posts_excerpt( $excerpt_length, $read_more_text ); ?>

			<?php endif; ?>

			</div>
		</div>
		<?php
	endwhile;

	/* Restore original Post Data 
	 * NB: Because we are using new WP_Query we aren't stomping on the 
	 * original $wp_query and it does not need to be reset.
	*/
	wp_reset_postdata();
}