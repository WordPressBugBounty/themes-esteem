<?php
/**
 * Widget for business layout that shows selected page content,title and corresponding icon.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class esteem_service_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'widget-services', 'description' => __( 'Display Services( Business Layout )', 'esteem' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Services', 'esteem' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$defaults[$var] = '';
		}
		$defaults['checkbox'] = '0';
		$instance = wp_parse_args( (array) $instance, $defaults );
		for ( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$var = absint( $instance[ $var ] );
		}
		$checkbox = $instance[ 'checkbox' ] ? 'checked="checked"' : '';
		?>
		<p>
			<input class="checkbox" <?php echo $checkbox; ?> id="<?php echo $this->get_field_id( 'checkbox' ); ?>" name="<?php echo $this->get_field_name( 'checkbox' ); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('checkbox'); ?>"><?php _e( 'Check to display the Featured Image', 'esteem' ); ?></label>
			<?php _e('<strong>Note:</strong> Featured Image will overwrite the fontawesome icon.', 'esteem'); ?>
		</p>
		<?php for( $i=0; $i<3; $i++) { ?>
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
		for( $i=0; $i<3; $i++ ) {
			$var = 'page_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}
		$instance[ 'checkbox' ] = isset( $new_instance[ 'checkbox' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$checkbox = !empty( $instance[ 'checkbox' ] ) ? 'true' : 'false';
		$page_array = array();
		for( $i=0; $i<3; $i++ ) {
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
		echo $before_widget; ?>
		<div class="services-block clearfix">
			<?php
			$j = 1;
			while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
				$page_title = get_the_title();
				if( $j == 3 ) {
					$service_class = "tg-one-third tg-one-third-last";
				}
				else {
					$service_class = "tg-one-third";
				}
				?>
				<div class="<?php echo $service_class; ?>">
					<?php if ( $checkbox == 'true' ) : ?>
						<div class="services-featured-image">
							<?php
							if ( has_post_thumbnail() ) {
								echo'<div class="service-image">'.get_the_post_thumbnail( $post->ID, 'service-featured' ).'</div>';
							}
							?>
							<h3 class="service-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php echo $page_title; ?></a></h3>
							<?php the_excerpt(); ?>
							<a class="read-more" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php echo __( 'Read more', 'esteem' ); ?></a>
						</div>
					<?php else : ?>
						<?php $esteem_icon = get_post_meta( $post->ID, '_esteem_font_icon', true );
						if( !empty( $esteem_icon ) ) { ?>
							<div class="service-border">
								<div class="service-image-wrap">
									<?php
									//$values = get_post_custom( $post->ID );
									$esteem_icon = isset( $esteem_icon ) ? esc_attr( $esteem_icon ) : '';
									?>
									<i class="<?php echo esc_html( $esteem_icon ); ?>"></i>
								</div><!-- service-image-wrap" -->
							</div><!-- service-border -->
						<?php } ?>
						<h3 class="service-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php echo $page_title; ?></a></h3>
						<?php the_excerpt(); ?>
						<a class="read-more" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php _e( 'Read more','esteem' ); ?></a>
					<?php endif; ?>
				</div><!-- .tg-one-third -->
				<?php $j++; ?>
			<?php endwhile;
			// Reset Post Data
			wp_reset_query();
			?>
		</div>
		<?php
		echo $after_widget;
	}
}
