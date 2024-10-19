<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage esteem
 * @since esteem 1.0
 */

add_action( 'widgets_init', 'esteem_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function esteem_widgets_init() {

	// Registering main right sidebar
	register_sidebar( array(
		'name' 				=> __( 'Right Sidebar', 'esteem' ),
		'id' 					=> 'esteem_right_sidebar',
		'description'   	=> __( 'Shows widgets at Right side.', 'esteem' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering main left sidebar
	register_sidebar( array(
		'name' 				=> __( 'Left Sidebar', 'esteem' ),
		'id' 					=> 'esteem_left_sidebar',
		'description'   	=> __( 'Shows widgets at Left side.', 'esteem' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );


	// Registering Business Page section sidebar
	register_sidebar( array(
		'name' 				=> __( 'Business Page Sidebar', 'esteem' ),
		'id' 					=> 'esteem_business_page_sidebar',
		'description'   	=> __( 'Shows widgets on Business Page Template.', 'esteem' ),
		'before_widget' 	=> '<section id="%1$s" class="widget widget-home %2$s clearfix">',
		'after_widget'  	=> '</section>',
		'before_title'  	=> '<h6>',
		'after_title'   	=> '</h6>'
	) );

	// Registering footer sidebar one
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar One', 'esteem' ),
		'id' 					=> 'esteem_footer_sidebar_one',
		'description'   	=> __( 'Shows widgets at footer sidebar one.', 'esteem' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering footer sidebar two
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar Two', 'esteem' ),
		'id' 					=> 'esteem_footer_sidebar_two',
		'description'   	=> __( 'Shows widgets at footer sidebar two.', 'esteem' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering footer sidebar three
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar Three', 'esteem' ),
		'id' 					=> 'esteem_footer_sidebar_three',
		'description'   	=> __( 'Shows widgets at footer sidebar three.', 'esteem' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering contact Page sidebar
	register_sidebar( array(
		'name' 				=> __( 'Contact Page Sidebar', 'esteem' ),
		'id' 					=> 'esteem_contact_page_sidebar',
		'description'   	=> __( 'Shows widgets on Contact Page Template.', 'esteem' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering custom widgets.
	register_widget( 'esteem_service_widget' );
	register_widget( 'esteem_recent_work_widget' );
	register_widget( 'esteem_call_to_action_widget' );
	register_widget( 'esteem_testimonial_widget' );
}

// Require file for TG: Service widget.
require ESTEEM_WIDGETS_DIR . '/class-esteem-service-widget.php';

// Require file for TG: Recent Work widget.
require ESTEEM_WIDGETS_DIR . '/class-esteem-recent-work-widget.php';

// Require file for TG: Call To Action widget.
require ESTEEM_WIDGETS_DIR . '/class-esteem-call-to-action-widget.php';

// Require file for TG: Testimonial widget.
require ESTEEM_WIDGETS_DIR . '/class-esteem-testimonial-widget.php';
