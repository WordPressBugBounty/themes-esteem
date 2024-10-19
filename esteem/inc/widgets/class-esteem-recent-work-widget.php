<?php
/**
 * Widget for business layout that shows Featured page title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class esteem_recent_work_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'widget-recent-work', 'description' => __( 'Use this widget to show recent work, portfolio or any pages as your wish ( Business Layout )', 'esteem' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Featured Widget', 'esteem' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=0; $i<4; $i++ ) {
			$var = 'page_id'.$i;
			$defaults[$var] = '';
		}
		$att_defaults = $defaults;
		$att_defaults['title'] = '';
		$instance = wp_parse_args( (array) $instance, $att_defaults );
		for ( $i=0; $i<4; $i++ ) {
			$var = 'page_id'.$i;
			$var = absint( $instance[ $var ] );
		}
		$title = esc_attr( $instance[ 'title' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'esteem' ); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
		for( $i=0; $i<4; $i++) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php _e( 'Page', 'esteem' ); ?>:</label>
				<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( key($defaults) ), 'selected' => $instance[key($defaults)] ) ); ?>
			</p>
			<?php
			next( $defaults );// forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		for( $i=0; $i<4; $i++ ) {
			$var = 'page_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$page_array = array();
		for( $i=0; $i<6; $i++ ) {
			$var = 'page_id'.$i;
			$page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';

			if( !empty( $page_id ) )
				array_push( $page_array, $page_id );// Push the page id in the array
		}
		$get_featured_pages = new WP_Query( array(
			'posts_per_page' 			=> -1,
			'post_type'					=>  array( 'page' ),
			'post__in'		 			=> $page_array,
			'orderby' 		 			=> 'post__in'
		) );
		echo $before_widget;
		if ( !empty( $title ) ) { ?>
			<div class="fancy-tab">
				<?php echo $before_title . esc_html( $title ) . $after_title; ?>
			</div>
		<?php } ?>
		<div class="recent-work clearfix">
			<?php
			$i=1;
			while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
				if ( $i % 4 == 0 ) { $class = 'tg-one-fourth tg-one-fourth-last'.' tg-column-'.$i; }
				else { $class = 'tg-one-fourth'.' tg-column-'.$i; }
				$page_title = get_the_title();
				?>
				<div class="<?php echo $class; ?>">
					<?php
					if ( has_post_thumbnail( ) ) {
						$thumb_id            = get_post_thumbnail_id( get_the_ID() );
						$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
						$img_alt             = ! empty( $img_altr ) ? $img_altr : $page_title;
						$post_thumbnail_attr = array(
							'alt' => esc_attr( $img_alt ),
						);
						echo '<a title="'.get_the_title().'" href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID,'recent-thumb', $post_thumbnail_attr).'</a>';?>
						<div class="recent-work-title">
							<h6><?php the_title(); ?></h6>
						</div>
						<?php
					}
					?>
					<!-- <h3 class="custom-gallery-title"><a href="<?php the_permalink(); ?>" title=""><?php echo $page_title; ?></a></h3> -->
				</div>
				<?php
				$i++;
			endwhile;
			// Reset Post Data
			wp_reset_query();
			?>
		</div><!-- .recent-work -->
		<?php echo $after_widget;
	}
}
