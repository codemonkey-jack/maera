<?php

/**
 * @package     Maera/Widget/Class
 * @version     1.0.0
 * @author      Aristeides Stathopoulos, Brian Welch
 * @copyright   2014
 * @link        https://wpmu.io
 * @license     http://opensource.org/licenses/MIT
 */

class Maera_Ext_Posts_Widget_Latest_Articles extends WP_Widget {

	/**
	 * Add the widget to the back end.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function maera_ext_posts_widget_latest_articles() {

		$widget_ops = array(
			'classname'   => __( 'Maera Latest Posts', 'maera' ),
			'description' => '',
		);

		$control_ops = array(
			'width'   => 250,
			'height'  => 350,
			'id_base' => 'maera_ext_posts_widget_latest_articles',
		);

		$this->WP_Widget(
			'maera_ext_posts_widget_latest_articles',
			__( 'Maera Latest Posts', 'maera' ),
			$widget_ops,
			$control_ops
		);
	}


	/**
	 * Render the widget on the front end.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function widget( $args, $instance ) {

		extract( $args );

		if ( 'any' != $instance['term'] ) {
			$tax_query = array(
				array(
					'taxonomy' => $instance['taxonomy'],
					'terms'    => $instance['term'],
				),
			);
		} else {
			$tax_query = '';
		}

		$query_args = array(
			'post_type'        => $instance['post_type'],
			'tax_query'        => $tax_query,
			'posts_per_page'   => $instance['per_page'],
			'offset'           => $instance['offset'],
		);

		$widget = array(
			'title'           => apply_filters( 'widget_title', $instance['title'] ),
			'thumb'           => $instance['thumb'],
			'thumb_float'     => $instance['thumb_float'],
			'thumb_width'     => $instance['thumb_width'],
			'thumb_height'    => $instance['thumb_height'],
			'excerpt_length'  => $instance['excerpt_length'],
			'more_text'       => $instance['more_text'],
			'post_title_size' => $instance['post_title_size'],
			'before_widget'   => $before_widget,
			'after_widget'    => $after_widget,
			'before_title'    => $before_title,
			'after_title'     => $after_title,

		);

		$context = Timber::get_context();
		$context['post']   = Timber::query_post();
		$context['posts']  = Timber::get_posts( $query_args );
		$context['widget'] = $widget;

		Timber::render(
			array(
				'widget-extended-posts.twig',
			),
			$context,
			apply_filters( 'maera/timber/cache', false )
		);

		wp_reset_query();

	}


	/**
	 * Widget instance update.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip terms (if needed) and update the widget settings. */
		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['post_type']       = strip_tags( $new_instance['post_type'] );
		$instance['taxonomy']        = strip_tags( $new_instance['taxonomy'] );
		$instance['term']            = strip_tags( $new_instance['term'] );
		$instance['per_page']        = strip_tags( $new_instance['per_page'] );
		$instance['offset']          = strip_tags( $new_instance['offset'] );
		$instance['thumb']           = isset( $new_instance['thumb'] );
		$instance['thumb_float']     = isset( $new_instance['thumb_float'] );
		$instance['thumb_width']     = strip_tags( $new_instance['thumb_width'] );
		$instance['thumb_height']    = strip_tags( $new_instance['thumb_height'] );
		$instance['excerpt_length']  = strip_tags( $new_instance['excerpt_length'] );
		$instance['more_text']       = strip_tags( $new_instance['more_text'] );
		$instance['post_title_size'] = strip_tags( $new_instance['post_title_size'] );

		return $instance;
	}


	/**
	 * Render the widget form controls.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function form( $instance ) {

		$defaults = array(
			'title'           => 'Latest Articles',
			'post_type'       => 'post',
			'taxonomy'        => 'category',
			'term'            => 'any',
			'per_page'        => 5,
			'offset'          => 0,
			'thumb'           => true,
			'thumb_float'     => 1,
			'thumb_width'     => 150,
			'thumb_height'    => 100,
			'excerpt_length'  => 20,
			'more_text'       => __( 'Read More', 'maera' ),
			'post_title_size' => 'h4',
		);

		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<?php _e( 'Title:','maera' ); ?>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" /></td>

		<table style="margin-top: 10px;">
			<tr>
				<td><?php _e( 'Post Type:','maera' ); ?></td>
				<td>
					<select name="<?php echo $this->get_field_name( 'post_type' ); ?>">
						<?php $post_types = get_post_types( array( 'public' => true, ), 'names' ); ?>
						<?php foreach ( $post_types as $post_type ) : ?>
							<?php $selected = ( $instance['post_type'] == $post_type ) ? 'selected' : ''; ?>
							<option <?php echo $selected; ?> value="<?php echo $post_type; ?>">
								<?php echo $post_type; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>

			<?php $taxonomies = get_object_taxonomies( $instance['post_type'], 'objects' ); ?>
			<?php if ( $taxonomies ) : ?>
				<tr>
					<td><?php _e( 'Taxonomy:','maera' ); ?></td>
					<td>
						<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
							<?php foreach ( $taxonomies as $taxonomy ) : ?>
								<?php $selected = ( $instance['taxonomy'] == $taxonomy->name ) ? 'selected' : ''; ?>
								<option <?php echo $selected; ?> value="<?php echo $taxonomy->name; ?>">
									<?php echo $taxonomy->name; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>

				<tr>
					<td><?php _e( 'Term:','maera' ); ?></td>
					<td>
						<select name="<?php echo $this->get_field_name( 'term' ); ?>">
							<?php $selected = ( $instance['term'] == 'any' ) ? 'selected' : ''; ?>
							<option <?php echo $selected; ?> value="any"><?php _e( 'Any Term', 'maera' ); ?></option>
							<?php
								$terms_args = array(
									'orderby'    => 'name',
									'order'      => 'ASC',
									'hide_empty' => 0,
								);

								$terms = get_terms( $instance['taxonomy'], $terms_args );

								foreach ( $terms as $term ) : ?>
									<?php $selected = ( $instance['term'] == $term->term_id ) ? 'selected' : ''; ?>
									<option <?php echo $selected; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
								<?php endforeach; ?>
						</select>
					</td>
				</tr>
			<?php endif; ?>

			<tr>
				<td><?php _e( 'Number of Posts to display','maera' ); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'per_page' ); ?>" value="<?php echo $instance['per_page']; ?>" type="number" /></td>
			</tr>

			<tr>
				<td><?php _e( 'Offset','maera' ); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'per_page' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo $instance['offset']; ?>" type="number" /></td>
			</tr>

			<tr style="margin: 10px 0;">
				<td><?php _e( 'Post Title Size:','maera' ); ?></td>
				<td>
					<input class="radio" type="radio" <?php if ( $instance['post_title_size'] == 'h3' ) { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'post_title_size' ); ?>" value="h3" id="<?php echo $this->get_field_id( 'post_title_size' ); ?>_h3" />
					<?php _e( 'Large (H3)', 'maera' ); ?>
					<br />
					<input class="radio" type="radio" <?php if ( $instance['post_title_size'] == 'h4' ) { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'post_title_size' ); ?>" value="h4" id="<?php echo $this->get_field_id( 'post_title_size' ); ?>_h4" />
					<?php _e( 'Normal (H4)', 'maera' ); ?>
					<br />
					<input class="radio" type="radio" <?php if ( $instance['post_title_size'] == 'h5' ) { ?>checked <?php } ?>name="<?php echo $this->get_field_name( 'post_title_size' ); ?>" value="h5" id="<?php echo $this->get_field_id( 'post_title_size' ); ?>_h5" />
					<?php _e( 'Small (H5)', 'maera' ); ?>
					<br />
			</tr>

			<tr>
				<td><?php _e( 'Excerpt Length','maera' ); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" value="<?php echo $instance['excerpt_length']; ?>" type="number" /></td>
			</tr>

			<tr>
				<td><?php _e( 'Read More text:','maera' ); ?></td>
				<td><input id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo $instance['more_text']; ?>" class="widefat" type="text" /></td>
			</tr>

			<tr>
				<td colspan="2">
					<input class="checkbox" type="checkbox" <?php checked( isset( $instance['thumb'] ) ? $instance['thumb'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" />
					<?php _e( 'Display thumbs','maera' ); ?>
				</td>
			</tr>

			<?php if ( $instance['thumb'] ) : ?>

				<tr>
					<td colspan="2">
						<input class="checkbox" type="checkbox" <?php checked( isset( $instance['thumb_float'] ) ? $instance['thumb_float'] : 0  ); ?> id="<?php echo $this->get_field_id( 'thumb_float' ); ?>" name="<?php echo $this->get_field_name( 'thumb_float' ); ?>" />
						<?php _e( 'Float Tumbnails Left','maera' ); ?>
					</td>
				</tr>

				<tr>
					<td><?php _e( 'Thumbnail Width','maera' ); ?></td>
					<td><input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" type="number" /></td>
				</tr>

				<tr>
					<td><?php _e( 'Thumbnail Height','maera' ); ?></td>
					<td><input id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo $instance['thumb_height']; ?>" type="number" /></td>
				</tr>
			<?php endif; ?>

		</table>
		<?php
	}
}
