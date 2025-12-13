<?php
/**
 * Custom widgets for Versalia theme
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Featured Poems Widget
 */
class Versalia_Featured_Poems_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'versalia_featured_poems',
			__( 'Featured Poems', 'versalia' ),
			array(
				'description' => __( 'Display a list of featured poems.', 'versalia' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Poems', 'versalia' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 3;

		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];

		$query_args = array(
			'post_type'      => 'poem',
			'posts_per_page' => $count,
			'orderby'        => 'rand',
		);

		$poems = new WP_Query( $query_args );

		if ( $poems->have_posts() ) :
			echo '<ul class="featured-poems-list">';
			while ( $poems->have_posts() ) :
				$poems->the_post();
				?>
				<li class="featured-poem-item">
					<h3 class="featured-poem-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<?php
					$poetry_forms = get_the_terms( get_the_ID(), 'poetry_form' );
					if ( $poetry_forms && ! is_wp_error( $poetry_forms ) ) :
						?>
						<span class="featured-poem-form"><?php echo esc_html( $poetry_forms[0]->name ); ?></span>
					<?php endif; ?>
				</li>
				<?php
			endwhile;
			echo '</ul>';
			wp_reset_postdata();
		endif;

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Poems', 'versalia' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of poems:', 'versalia' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number"
				   step="1" min="1" max="10" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 3;
		return $instance;
	}
}

/**
 * Recent Collections Widget
 */
class Versalia_Recent_Collections_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'versalia_recent_collections',
			__( 'Recent Collections', 'versalia' ),
			array(
				'description' => __( 'Display a list of recent poetry collections.', 'versalia' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Collections', 'versalia' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;

		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];

		$collections = get_terms(
			array(
				'taxonomy'   => 'collection',
				'number'     => $count,
				'hide_empty' => true,
			)
		);

		if ( ! empty( $collections ) && ! is_wp_error( $collections ) ) :
			echo '<ul class="collections-list">';
			foreach ( $collections as $collection ) :
				?>
				<li class="collection-item">
					<a href="<?php echo esc_url( get_term_link( $collection ) ); ?>">
						<?php echo esc_html( $collection->name ); ?>
						<span class="collection-count">(<?php echo esc_html( $collection->count ); ?>)</span>
					</a>
				</li>
				<?php
			endforeach;
			echo '</ul>';
		endif;

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Collections', 'versalia' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of collections:', 'versalia' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number"
				   step="1" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 5;
		return $instance;
	}
}

/**
 * Author Info Widget
 */
class Versalia_Author_Info_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'versalia_author_info',
			__( 'Author Info', 'versalia' ),
			array(
				'description' => __( 'Display author information and bio.', 'versalia' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$author_id   = ! empty( $instance['author_id'] ) ? absint( $instance['author_id'] ) : get_current_user_id();
		$show_avatar = ! empty( $instance['show_avatar'] ) ? $instance['show_avatar'] : true;

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		$author_name = get_the_author_meta( 'display_name', $author_id );
		$author_bio  = get_the_author_meta( 'description', $author_id );
		$author_url  = get_author_posts_url( $author_id );

		?>
		<div class="author-info-widget">
			<?php if ( $show_avatar ) : ?>
				<div class="author-avatar">
					<?php echo get_avatar( $author_id, 96 ); ?>
				</div>
			<?php endif; ?>

			<div class="author-details">
				<h3 class="author-name">
					<a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
				</h3>

				<?php if ( $author_bio ) : ?>
					<div class="author-bio">
						<?php echo wp_kses_post( wpautop( $author_bio ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'About the Poet', 'versalia' );
		$author_id   = ! empty( $instance['author_id'] ) ? absint( $instance['author_id'] ) : get_current_user_id();
		$show_avatar = isset( $instance['show_avatar'] ) ? (bool) $instance['show_avatar'] : true;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'author_id' ) ); ?>">
				<?php esc_html_e( 'Author:', 'versalia' ); ?>
			</label>
			<?php
			wp_dropdown_users(
				array(
					'name'     => $this->get_field_name( 'author_id' ),
					'id'       => $this->get_field_id( 'author_id' ),
					'selected' => $author_id,
					'class'    => 'widefat',
				)
			);
			?>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_avatar ); ?>
				   id="<?php echo esc_attr( $this->get_field_id( 'show_avatar' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'show_avatar' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_avatar' ) ); ?>">
				<?php esc_html_e( 'Display avatar', 'versalia' ); ?>
			</label>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['author_id']   = ( ! empty( $new_instance['author_id'] ) ) ? absint( $new_instance['author_id'] ) : get_current_user_id();
		$instance['show_avatar'] = ! empty( $new_instance['show_avatar'] );
		return $instance;
	}
}

/**
 * Social Links Widget
 */
class Versalia_Social_Links_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'versalia_social_links',
			__( 'Social Links', 'versalia' ),
			array(
				'description' => __( 'Display social media links.', 'versalia' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		$social_links = array(
			'twitter'   => ! empty( $instance['twitter'] ) ? $instance['twitter'] : '',
			'facebook'  => ! empty( $instance['facebook'] ) ? $instance['facebook'] : '',
			'instagram' => ! empty( $instance['instagram'] ) ? $instance['instagram'] : '',
			'linkedin'  => ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '',
			'github'    => ! empty( $instance['github'] ) ? $instance['github'] : '',
		);

		$has_links = false;
		foreach ( $social_links as $link ) {
			if ( ! empty( $link ) ) {
				$has_links = true;
				break;
			}
		}

		if ( $has_links ) :
			?>
			<ul class="social-links-list">
				<?php foreach ( $social_links as $platform => $url ) : ?>
					<?php if ( ! empty( $url ) ) : ?>
						<li class="social-link-item social-<?php echo esc_attr( $platform ); ?>">
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="screen-reader-text"><?php echo esc_html( ucfirst( $platform ) ); ?></span>
								<?php echo esc_html( ucfirst( $platform ) ); ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<?php
		endif;

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title     = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Follow Me', 'versalia' );
		$twitter   = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
		$facebook  = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
		$instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
		$linkedin  = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		$github    = ! empty( $instance['github'] ) ? $instance['github'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">
				<?php esc_html_e( 'Twitter URL:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="url"
				   value="<?php echo esc_url( $twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>">
				<?php esc_html_e( 'Facebook URL:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="url"
				   value="<?php echo esc_url( $facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>">
				<?php esc_html_e( 'Instagram URL:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="url"
				   value="<?php echo esc_url( $instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>">
				<?php esc_html_e( 'LinkedIn URL:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="url"
				   value="<?php echo esc_url( $linkedin ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'github' ) ); ?>">
				<?php esc_html_e( 'GitHub URL:', 'versalia' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'github' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'github' ) ); ?>" type="url"
				   value="<?php echo esc_url( $github ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['twitter']   = ( ! empty( $new_instance['twitter'] ) ) ? esc_url_raw( $new_instance['twitter'] ) : '';
		$instance['facebook']  = ( ! empty( $new_instance['facebook'] ) ) ? esc_url_raw( $new_instance['facebook'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? esc_url_raw( $new_instance['instagram'] ) : '';
		$instance['linkedin']  = ( ! empty( $new_instance['linkedin'] ) ) ? esc_url_raw( $new_instance['linkedin'] ) : '';
		$instance['github']    = ( ! empty( $new_instance['github'] ) ) ? esc_url_raw( $new_instance['github'] ) : '';
		return $instance;
	}
}

/**
 * Register widgets
 */
function versalia_register_widgets() {
	register_widget( 'Versalia_Featured_Poems_Widget' );
	register_widget( 'Versalia_Recent_Collections_Widget' );
	register_widget( 'Versalia_Author_Info_Widget' );
	register_widget( 'Versalia_Social_Links_Widget' );
}
add_action( 'widgets_init', 'versalia_register_widgets' );
