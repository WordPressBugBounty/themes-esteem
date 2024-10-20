<?php
/**
 * Widget for business page template that shows Call to Action section.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class esteem_call_to_action_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'widget-call-to-action', 'description' => __( 'Use this widget to show the call to action section', 'esteem' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Call To Action Widget', 'esteem' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$esteem_defaults[ 'text_main' ] = '';
		$esteem_defaults[ 'text_additional' ] = '';
		$esteem_defaults[ 'button_text' ] = '';
		$esteem_defaults[ 'button_url' ] = '';
		$esteem_defaults[ 'new_tab' ] = '0';
		$instance = wp_parse_args( (array) $instance, $esteem_defaults );
		$text_main = esc_textarea( $instance[ 'text_main' ] );
		$text_additional = esc_textarea( $instance[ 'text_additional' ] );
		$button_text = esc_attr( $instance[ 'button_text' ] );
		$button_url = esc_url( $instance[ 'button_url' ] );
		$new_tab = $instance['new_tab'] ? 'checked="checked"' : '';
		?>


		<?php _e( 'Call to Action Main Text','esteem' ); ?>
		<textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id('text_main'); ?>" name="<?php echo $this->get_field_name('text_main'); ?>"><?php echo $text_main; ?></textarea>
		<?php _e( 'Call to Action Additional Text','esteem' ); ?>
		<textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id('text_additional'); ?>" name="<?php echo $this->get_field_name('text_additional'); ?>"><?php echo $text_additional; ?></textarea>
		<p>
			<label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e( 'Button Text:', 'esteem' ); ?></label>
			<input id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e( 'Button Redirect Link:', 'esteem' ); ?></label>
			<input id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $new_tab; ?> id="<?php echo $this->get_field_id('new_tab'); ?>" name="<?php echo $this->get_field_name('new_tab'); ?>" /> <label for="<?php echo $this->get_field_id('new_tab'); ?>"><?php _e( 'Open in new tab', 'esteem' ); ?></label>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( current_user_can('unfiltered_html') )
			$instance['text_main'] =  $new_instance['text_main'];
		else
			$instance['text_main'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text_main']) ) ); // wp_filter_post_kses() expects slashed

		if ( current_user_can('unfiltered_html') )
			$instance['text_additional'] =  $new_instance['text_additional'];
		else
			$instance['text_additional'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text_additional']) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'button_text' ] = strip_tags( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ] = esc_url_raw( $new_instance[ 'button_url' ] );
		$instance[ 'new_tab' ] = isset( $new_instance[ 'new_tab' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$new_tab = !empty( $instance[ 'new_tab' ] ) ? 'true' : 'false';
		$text_main = empty( $instance['text_main'] ) ? '' : $instance['text_main'];
		$text_additional = empty( $instance['text_additional'] ) ? '' : $instance['text_additional'];
		$button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
		$button_url = isset( $instance[ 'button_url' ] ) ? $instance[ 'button_url' ] : '#';

		echo $before_widget;
		?>
		<div class="call-to-action clearfix">
			<div class="call-to-action-text">
				<div class="call-to-action-text-inner-wrap">
					<?php
					if( !empty( $text_main ) ) {
						?>
						<h4><?php echo esc_html( $text_main ); ?></h4>
						<?php
					}
					if( !empty( $text_additional ) ) {
						?>
						<p><?php echo esc_html( $text_additional ); ?></p>
						<?php
					}
					?>
				</div>
			</div><!-- .call-to-action-text -->
			<?php
			if( !empty( $button_text ) ) {
				?>
				<div class="call-to-action-button">
					<div class="call-to-action-button-inner-wrap">
						<a class="call-to-action-link" <?php if( $new_tab == 'true' ) { echo 'target="_blank"'; } ?> href="<?php echo esc_url( $button_url ); ?>" title="<?php echo esc_attr( $button_text ); ?>"><?php echo esc_html( $button_text ); ?></a>
					</div>
				</div><!-- .call-to-action-button -->
				<?php
			}
			?>
		</div><!-- .call-to-action clearfix -->
		<?php
		echo $after_widget;
	}
}
