<?php
/**
 * Testimonial widget
 */
class esteem_testimonial_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_testimonial', 'description' => __( 'Display Testimonial', 'esteem' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Testimonial', 'esteem' ), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text1 = apply_filters( 'widget_text1', empty( $instance['text1'] ) ? '' : $instance['text1'], $instance );
		$name1 = apply_filters( 'widget_name1', empty( $instance['name1'] ) ? '' : $instance['name1'], $instance, $this->id_base );
		$image1 = apply_filters( 'widget_image1', empty( $instance['image1'] ) ? '' : $instance['image1'], $instance, $this->id_base );
		$byline1 = apply_filters( 'widget_byline1', empty( $instance['byline1'] ) ? '' : $instance['byline1'], $instance, $this->id_base );

		$company1 = apply_filters( 'widget_company1', empty( $instance['company1'] ) ? '' : $instance['company1'], $instance, $this->id_base );
		$company_link = apply_filters( 'widget_company_link', empty( $instance['company_link'] ) ? '' : $instance['company_link'], $instance, $this->id_base );


		$text2 = apply_filters( 'widget_text2', empty( $instance['text2'] ) ? '' : $instance['text2'], $instance );
		$image2 = apply_filters( 'widget_image2', empty( $instance['image2'] ) ? '' : $instance['image2'], $instance, $this->id_base );
		$name2 = apply_filters( 'widget_name2', empty( $instance['name2'] ) ? '' : $instance['name2'], $instance, $this->id_base );
		$byline2 = apply_filters( 'widget_byline2', empty( $instance['byline2'] ) ? '' : $instance['byline2'], $instance, $this->id_base );
		$company2 = apply_filters( 'widget_company2', empty( $instance['company2'] ) ? '' : $instance['company2'], $instance, $this->id_base );
		$company2_link = apply_filters( 'widget_company2_link', empty( $instance['company2_link'] ) ? '' : $instance['company2_link'], $instance, $this->id_base );


		echo $before_widget; ?>
		<?php if ( !empty( $title ) ) { ?>
			<div class="fancy-tab">
				<?php echo $before_title. esc_html( $title ) . $after_title; ?>
			</div>
		<?php } ?>
		<div class="testimonial">
			<?php if ( !empty( $name1 ) ) : ?>
				<div class="tg-one-half">
					<div class="testimonial-wrap">
						<div class="testimonial-content clearfix">
							<div class="author-image">
								<img title="author" alt="author" src="<?php echo esc_url( $image1 ); ?>">
							</div><!-- .testimonial-content -->
							<div class="testimonial-text">
								<p><?php echo esc_textarea( $text1 ); ?></p>
							</div><!-- .testimonial-text -->
						</div><!-- .testimonial-content -->
						<div class="testimonial-byline">
							<?php echo esc_html( $name1 ); ?>
							<span class="author-desc"><?php echo esc_html( $byline1 ).' <a href="'.esc_url( $company_link).'" title="'.esc_html( $company1 ).'">'.esc_html( $company1 ).'</a>'?></span>
						</div><!-- .byline -->
					</div><!-- .testimonial-wrap -->
				</div><!-- .tg-one-half -->
			<?php endif; ?>

			<?php if ( !empty( $name2 ) ) : ?>
				<div class="tg-one-half tg-one-half-last">
					<div class="testimonial-wrap">
						<div class="testimonial-content clearfix">
							<div class="author-image">
								<img title="author" alt="author" src="<?php echo esc_url( $image2 ); ?>">
							</div><!-- .testimonial-content -->
							<div class="testimonial-text">
								<p><?php echo esc_textarea( $text2 ); ?></p>
							</div><!-- .testimonial-text -->
						</div><!-- .testimonial-content -->
						<div class="testimonial-byline">
							<?php echo esc_html( $name2 ); ?>
							<span class="author-desc"><?php echo esc_html( $byline2 ).' <a href = "'.esc_url( $company2_link).'" title="'.esc_html( $company2 ).'">'.esc_html( $company2 ).'</a>'?></span>
						</div><!-- .byline -->
					</div><!-- .testimonial-wrap -->
				</div><!-- .tg-one-half -->
			<?php endif; ?>
		</div><!-- .testimonial -->

		<?php echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['name1'] = strip_tags($new_instance['name1']);
		$instance['image1'] = esc_url_raw($new_instance['image1']);
		$instance['byline1'] = strip_tags($new_instance['byline1']);
		$instance['company1'] = strip_tags($new_instance['company1']);
		$instance['company_link'] = esc_url_raw($new_instance['company_link']);
		if ( current_user_can('unfiltered_html') )
			$instance['text1'] =  $new_instance['text1'];
		else
			$instance['text1'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text1']) ) ); // wp_filter_post_kses() expects slashed
		$instance['name2'] = strip_tags($new_instance['name2']);
		$instance['image2'] = esc_url_raw($new_instance['image2']);
		$instance['byline2'] = strip_tags($new_instance['byline2']);
		$instance['company2'] = strip_tags($new_instance['company2']);
		$instance['company2_link'] = esc_url_raw($new_instance['company2_link']);
		if ( current_user_can('unfiltered_html') )
			$instance['text2'] =  $new_instance['text2'];
		else
			$instance['text2'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text2']) ) ); // wp_filter_post_kses() expects slashed
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','name1' => '','image1' => '','byline1'=>'','text1' => '','company1' => '','company_link' => '','name2' =>'', 'image2' => '', 'text2' => '', 'byline2' => '','company2' => '','company2_link' => '' ) );
		$title = strip_tags($instance['title']);
		$name1 = strip_tags($instance['name1']);
		$image1 = esc_url( $instance['image1']);
		$byline1 = strip_tags($instance['byline1']);
		$text1 = esc_textarea($instance['text1']);
		$company1 = strip_tags($instance['company1']);
		$company_link = esc_url( $instance['company_link']);
		$name2 = strip_tags($instance['name2']);
		$image2 = esc_url( $instance['image2']);
		$byline2 = strip_tags($instance['byline2']);
		$text2 = esc_textarea($instance['text2']);
		$company2 = strip_tags($instance['company2']);
		$company2_link = esc_url( $instance['company2_link']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('name1'); ?>"><?php _e( 'Name:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('name1'); ?>" name="<?php echo $this->get_field_name('name1'); ?>" type="text" value="<?php echo esc_attr($name1); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('image1'); ?>"><?php _e( 'Image link:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('image1'); ?>" name="<?php echo $this->get_field_name('image1'); ?>" type="text" value="<?php echo esc_attr($image1); ?>" /></p>

		<?php _e( 'Testimonial Description','esteem'); ?>
		<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('text1'); ?>" name="<?php echo $this->get_field_name('text1'); ?>"><?php echo $text1; ?></textarea>

		<p><label for="<?php echo $this->get_field_id('byline1'); ?>"><?php _e( 'Byline:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('byline1'); ?>" name="<?php echo $this->get_field_name('byline1'); ?>" type="text" value="<?php echo esc_attr($byline1); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('company1'); ?>"><?php _e( 'Company:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('company1'); ?>" name="<?php echo $this->get_field_name('company1'); ?>" type="text" value="<?php echo esc_attr($company1); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('company_link'); ?>"><?php _e( 'Company link:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('company_link'); ?>" name="<?php echo $this->get_field_name('company_link'); ?>" type="text" value="<?php echo esc_attr($company_link); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('name2'); ?>"><?php _e( 'Name:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('name2'); ?>" name="<?php echo $this->get_field_name('name2'); ?>" type="text" value="<?php echo esc_attr($name2); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('image2'); ?>"><?php _e( 'Image link:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('image2'); ?>" name="<?php echo $this->get_field_name('image2'); ?>" type="text" value="<?php echo esc_attr($image2); ?>" /></p>

		<?php _e( 'Testimonial Description','esteem'); ?>
		<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('text2'); ?>" name="<?php echo $this->get_field_name('text2'); ?>"><?php echo $text2; ?></textarea>

		<p><label for="<?php echo $this->get_field_id('byline2'); ?>"><?php _e( 'Byline:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('byline2'); ?>" name="<?php echo $this->get_field_name('byline2'); ?>" type="text" value="<?php echo esc_attr($byline2); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('company2'); ?>"><?php _e( 'Company:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('company2'); ?>" name="<?php echo $this->get_field_name('company2'); ?>" type="text" value="<?php echo esc_attr($company2); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('company2_link'); ?>"><?php _e( 'Company link:', 'esteem' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('company2_link'); ?>" name="<?php echo $this->get_field_name('company2_link'); ?>" type="text" value="<?php echo esc_attr($company2_link); ?>" /></p>


		<?php
	}
}
?>
