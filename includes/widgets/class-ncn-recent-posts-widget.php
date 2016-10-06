<?php
/**
 * Widget class.
 * 
 * @package NAMNCN
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * NCN Recent Posts Widget.
 *
 * Show recent posts.
 *
 * @author   NamNCN
 * @category Widgets
 * @package  NAMNCN/Widgets
 * @version  1.0.0
 * @extends  NCN_Widget
 */
class NCN_Recent_Posts_Widget extends NCN_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'ncn-recent-posts-widget';
		$this->widget_description = esc_html__( "Show recent posts.", 'namncn' );
		$this->widget_id          = 'ncn-recent-posts-widget';
		$this->widget_name        = esc_html__( 'NCN: Recent Posts', 'namncn' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Recent Posts', 'namncn' ),
				'label' => esc_html__( 'Title:', 'namncn' ),
			),
			'number' => array(
				'type'   => 'text',
				'std'    => 5,
				'label'  => esc_html__( 'Number of posts to show:', 'namncn' ),
				'desc'   => esc_html__( 'Fill "-1" to show all posts', 'namncn' ),
			),
			'offset' => array(
				'type'  => 'number',
				'std'   => 0,
				'step'  => 1,
				'min'   => 0,
				'max'   => 1000000,
				'label' => esc_html__( 'Number of post to displace or pass over:', 'namncn' ),
				'desc'  => esc_html__( 'The \'offset\' parameter is ignored when \'posts_per_page\'=>-1 (show all posts) is used.', 'namncn' ),
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'DESC',
				'label' => esc_html__( 'Order:', 'namncn' ),
				'desc'  => esc_html__( 'Designates the ascending or descending order of the \'orderby\' parameter. Defaults to \'DESC\'', 'namncn' ),
				'options' => array(
					'DESC' => esc_html__( 'Descending', 'namncn' ),
					'ASC'  => esc_html__( 'Ascending', 'namncn' ),
				),
			),
			'orderby' => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => esc_html__( 'Orderby:', 'namncn' ),
				'desc'    => esc_html__( 'Sort retrieved posts by parameter. Defaults to \'date (post_date)\'. One or more options can be passed.', 'namncn' ),
				'options' => array(
					'none'           => esc_html__( 'No order', 'namncn' ),
					'date'           => esc_html__( 'Date', 'namncn' ),
					'ID'             => esc_html__( 'Post id', 'namncn' ),
					'author'         => esc_html__( 'Author', 'namncn' ),
					'title'          => esc_html__( 'Title', 'namncn' ),
					'name'           => esc_html__( 'Post name (post slug)', 'namncn' ),
					'type'           => esc_html__( 'Post type', 'namncn' ),
					'modified'       => esc_html__( 'Last modified date', 'namncn' ),
					'parent'         => esc_html__( 'Post/page parent id', 'namncn' ),
					'rand'           => esc_html__( 'Random order', 'namncn' ),
					'comment_count'  => esc_html__( 'Number of comments', 'namncn' ),
					'menu_order'     => esc_html__( 'Page Order', 'namncn' ),
					// 'meta_value'     => esc_html__( '', 'namncn' ),
					// 'meta_value_num' => esc_html__( 'Order by numeric meta value', 'namncn' ),
					// 'post__in'       => esc_html__( 'Preserve post ID order given in the post__in array', 'namncn' ),
					// 'post_name__in'  => esc_html__( 'Preserve post slug order given in the post_name__in array', 'namncn' ),
				),
			),
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		extract( $instance );

		$post_args = array(
			'posts_per_page'       => $number,
			'ignore_sticky_posts'  => 1,
		);

		if ( $offset ) {
			$post_args['offset'] = $offset;
		}

		if ( $order ) {
			$post_args['order'] = $order;
		}

		if ( $orderby ) {
			$post_args['orderby'] = $orderby;
		}

		$post_query = new WP_Query( $post_args );

		$this->widget_start( $args, $instance );
		?>

		<?php if ( $post_query->have_posts() ) : ?>
			<div class="ncn-recent-posts">
			<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
				<div class="list_item">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="list_item-thumb">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</a>
					</div><!-- .list_item-thumb -->
					<?php endif; ?>

					<div class="list_item-details">
						<?php the_title( '<a href="' . get_the_permalink() . '" class="post-title">', '</a>' ); ?>
						<div class="post-meta">
							<span class="post-date"><i class="fa fa-clock-o"></i><?php the_time( 'd/m/Y' ); ?></span>
							<?php $this->ncn_comments_link(); ?>
						</div>
					</div><!-- .list_item-details -->
				</div><!-- .list_item -->
			<?php endwhile; ?>
			</div><!-- .ncn-recent-posts -->
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<?php
		$this->widget_end( $args );
	}

	/**
	 * NCN comments link.
	 * 
	 * Displays the link to the comments for the current post ID.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string $one Optional. String to display when only one comment is available.
	 *                     Default false.
	 * @param string $more Optional. String to display when there are more than one comment.
	 *                     Default false.
	 */
	public function ncn_comments_link( $one = false, $more = false ) {
		$id = get_the_ID();
		$title = get_the_title();
		$number = get_comments_number( $id );

		if ( false === $one ) {
			/* translators: %s: post title */
			$one = sprintf( __( '1<span class="screen-reader-text"> on %s</span>' ), $title );
		}

		if ( false === $more ) {
			/* translators: 1: Number of comments 2: post title */
			$more = _n( '%1$s<span class="screen-reader-text"> on %2$s</span>', '%1$s<span class="screen-reader-text"> on %2$s</span>', $number );
			$more = sprintf( $more, number_format_i18n( $number ), $title );
		}

		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo '<i class="fa fa-comments"></i>';
			comments_popup_link( false, $one, $more );
			echo '</span>';
		}
	}
}
