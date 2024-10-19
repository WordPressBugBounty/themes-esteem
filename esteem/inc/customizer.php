<?php
/**
 * Esteem Theme Customizer
 *
 * @package    ThemeGrill
 * @subpackage Esteem
 * @since      Esteem 1.2.7
 */
function esteem_customize_register( $wp_customize ) {

	require ESTEEM_INCLUDES_DIR . '/customize-controls/class-esteem-image-radio-control.php';
	require ESTEEM_INCLUDES_DIR . '/customize-controls/class-esteem-upsell-section.php';

	// Transport postMessage variable set
	$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '#site-title a',
			'render_callback' => 'esteem_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'esteem_customize_partial_blogdescription',
		) );
	}

// Register `ESTEEM_Upsell_Section` type section.
	$wp_customize->register_section_type( 'ESTEEM_Upsell_Section' );

// Add `ESTEEM_Upsell_Section` to display pro link.
	$wp_customize->add_section(
		new ESTEEM_Upsell_Section( $wp_customize, 'esteem_upsell_section',
			array(
				'title'      => esc_html__( 'View PRO version', 'esteem' ),
				'url'        => 'https://themegrill.com/themes/esteem/?utm_source=esteem-customizer&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro',
				'capability' => 'edit_theme_options',
				'priority'   => 1,
			)
		)
	);

	/* Header Options Area */
	$wp_customize->add_panel( 'esteem_header_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 300,
		'title'      => __( 'Header', 'esteem' ),
	) );

	// Header Logo upload option
	$wp_customize->add_section( 'esteem_header_title_logo', array(
		'title'    => __( 'Header Logo', 'esteem' ),
		'priority' => 10,
		'panel'    => 'esteem_header_options',
	) );

	// Header logo and text display type option
	$wp_customize->add_section( 'esteem_show_logo_text_setting', array(
		'title'    => __( 'Show', 'esteem' ),
		'priority' => 12,
		'panel'    => 'esteem_header_options',
	) );

	$wp_customize->add_setting( 'esteem_show_header_logo_text', array(
		'default'           => 'text_only',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );
	$wp_customize->add_control( 'esteem_show_header_logo_text', array(
		'type'    => 'radio',
		'label'   => __( 'Choose the option that you want.', 'esteem' ),
		'section' => 'title_tagline',
		'choices' => array(
			'logo_only' => __( 'Header Logo Only', 'esteem' ),
			'text_only' => __( 'Header Text Only', 'esteem' ),
			'both'      => __( 'Show Both', 'esteem' ),
			'none'      => __( 'Disable', 'esteem' ),
		),
	) );

	// New Responsive Menu
	$wp_customize->add_section( 'esteem_new_menu', array(
		'priority' => 14,
		'title'    => __( 'Responsive Menu Style', 'esteem' ),
		'panel'    => 'esteem_header_options',
	) );

	$wp_customize->add_setting( 'esteem_new_menu_enable', array(
		'default'           => '1',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'esteem_new_menu_enable', array(
		'type'    => 'checkbox',
		'label'   => __( 'Switch to new responsive menu.', 'esteem' ),
		'section' => 'esteem_new_menu',
	) );

	// Promo bar
	$wp_customize->add_section( 'esteem_slogan_setting', array(
		'priority' => 20,
		'title'    => __( 'Promo box Primary Slogan', 'esteem' ),
		'panel'    => 'esteem_header_options',
	) );

	$wp_customize->add_setting( 'esteem_slogan', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'sanitize_callback' => 'esteem_text_sanitize',
	) );
	$wp_customize->add_control( 'esteem_slogan', array(
		'label'   => __( 'Enter the main Slogan', 'esteem' ),
		'section' => 'esteem_slogan_setting',
	) );

	// Selective refresh for slogan
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'esteem_slogan', array(
			'selector'        => '.promo-title',
			'render_callback' => 'esteem_slogan',
		) );
	}

	// Promo Sub Slogan
	$wp_customize->add_section( 'esteem_sub_slogan_setting', array(
		'priority' => 30,
		'title'    => __( 'Promo box secondary Slogan', 'esteem' ),
		'panel'    => 'esteem_header_options',
	) );

	$wp_customize->add_setting( 'esteem_sub_slogan', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'sanitize_callback' => 'esteem_text_sanitize',
	) );

	$wp_customize->add_control( 'esteem_sub_slogan', array(
		'label'   => __( 'Enter the sub slogan', 'esteem' ),
		'section' => 'esteem_sub_slogan_setting',
	) );

	// Selective refresh for sub slogan
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'esteem_sub_slogan', array(
			'selector'        => '.promo-text',
			'render_callback' => 'esteem_sub_slogan',
		) );
	}

	// Promo Button Text
	$wp_customize->add_section( 'esteem_button_text_setting', array(
		'priority' => 40,
		'title'    => __( 'Button Text', 'esteem' ),
		'panel'    => 'esteem_header_options',
	) );

	$wp_customize->add_setting( 'esteem_button_text', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	) );
	$wp_customize->add_control( 'esteem_button_text', array(
		'label'   => __( 'Button Text', 'esteem' ),
		'section' => 'esteem_button_text_setting',
	) );

	// Selective refresh for read more button
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'esteem_button_text', array(
			'selector'        => '.promo-action',
			'render_callback' => 'esteem_button_text',
		) );
	}

	// Promo Button Text Link
	$wp_customize->add_section( 'esteem_button_link_setting', array(
		'priority' => 50,
		'title'    => __( 'Button redirect link', 'esteem' ),
		'panel'    => 'esteem_header_options',
	) );

	$wp_customize->add_setting( 'esteem_button_redirect_link', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_text_sanitize',
	) );
	$wp_customize->add_control( 'esteem_button_redirect_link', array(
		'label'   => __( 'Enter redirect link', 'esteem' ),
		'section' => 'esteem_button_link_setting',
	) );

	/**************************************************************************************/

	/* Design Options Area */
	$wp_customize->add_panel( 'esteem_design_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 310,
		'title'      => __( 'Design', 'esteem' ),
	) );

	// Site Layout
	$wp_customize->add_section( 'esteem_site_layout_setting', array(
		'title'    => __( 'Site Layout', 'esteem' ),
		'priority' => 10,
		'panel'    => 'esteem_design_options',
	) );

	$wp_customize->add_setting( 'esteem_site_layout', array(
		'default'           => 'box',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );
	$wp_customize->add_control( 'esteem_site_layout', array(
		'type'    => 'radio',
		'label'   => __( 'Choose your site layout. The change is reflected in whole site.', 'esteem' ),
		'section' => 'esteem_site_layout_setting',
		'choices' => array(
			'box'  => __( 'Boxed layout', 'esteem' ),
			'wide' => __( 'Wide layout', 'esteem' ),
		),
	) );

	// Default layout
	$wp_customize->add_section( 'esteem_default_layout_setting', array(
		'title'    => __( 'Default layout', 'esteem' ),
		'priority' => 20,
		'panel'    => 'esteem_design_options',
	) );

	$wp_customize->add_setting( 'esteem_default_layout', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );
	$wp_customize->add_control(
		new ESTEEM_Image_Radio_Control( $wp_customize, 'esteem_default_layout', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout. This layout will be reflected in whole site archives, search etc. The layout for a single post and page can be controlled from below options.. The change is reflected in whole site.', 'esteem' ),
			'section' => 'esteem_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => ESTEEM_ADMIN_IMAGES_URL . '/right-sidebar.png',
				'left_sidebar'                => ESTEEM_ADMIN_IMAGES_URL . '/left-sidebar.png',
				'no_sidebar_full_width'       => ESTEEM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => ESTEEM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png',
			),
		) )
	);

	// Default layout for pages only
	$wp_customize->add_section( 'esteem_pages_default_layout_setting', array(
		'title'    => __( 'Default layout for pages only', 'esteem' ),
		'priority' => 30,
		'panel'    => 'esteem_design_options',
	) );

	$wp_customize->add_setting( 'esteem_pages_default_layout', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );
	$wp_customize->add_control(
		new ESTEEM_Image_Radio_Control( $wp_customize, 'esteem_pages_default_layout', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'esteem' ),
			'section' => 'esteem_pages_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => ESTEEM_ADMIN_IMAGES_URL . '/right-sidebar.png',
				'left_sidebar'                => ESTEEM_ADMIN_IMAGES_URL . '/left-sidebar.png',
				'no_sidebar_full_width'       => ESTEEM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => ESTEEM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png',
			),
		) )
	);

	// Default layout for single posts only
	$wp_customize->add_section( 'esteem_single_posts_default_layout_setting', array(
		'title'    => __( 'Default layout for single posts only', 'esteem' ),
		'priority' => 40,
		'panel'    => 'esteem_design_options',
	) );

	$wp_customize->add_setting( 'esteem_single_posts_default_layout', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );
	$wp_customize->add_control(
		new ESTEEM_Image_Radio_Control( $wp_customize, 'esteem_single_posts_default_layout', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'esteem' ),
			'section' => 'esteem_single_posts_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => ESTEEM_ADMIN_IMAGES_URL . '/right-sidebar.png',
				'left_sidebar'                => ESTEEM_ADMIN_IMAGES_URL . '/left-sidebar.png',
				'no_sidebar_full_width'       => ESTEEM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => ESTEEM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png',
			),
		) )
	);

	// Blog page display type
	$wp_customize->add_section( 'esteem_posts_page_display_type_setting', array(
		'title'    => __( 'Blog page display type', 'esteem' ),
		'priority' => 50,
		'panel'    => 'esteem_design_options',
	) );

	$wp_customize->add_setting( 'esteem_posts_page_display_type', array(
		'default'           => 'full_content',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );
	$wp_customize->add_control( 'esteem_posts_page_display_type', array(
		'type'    => 'radio',
		'label'   => __( 'Choose the display type for the latests posts view or posts page view (static front page).', 'esteem' ),
		'section' => 'esteem_posts_page_display_type_setting',
		'choices' => array(
			'large_image'  => __( 'Large featured image', 'esteem' ),
			'small_image'  => __( 'Small featured image', 'esteem' ),
			'full_content' => __( 'Full Content', 'esteem' ),
		),
	) );

	// Site primary color option
	$wp_customize->add_section( 'esteem_primary_color_setting', array(
		'panel'    => 'esteem_design_options',
		'priority' => 60,
		'title'    => __( 'Primary color option', 'esteem' ),
	) );

	$wp_customize->add_setting( 'esteem_primary_color', array(
		'default'              => '#ED564B',
		'capability'           => 'edit_theme_options',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'esteem_color_option_hex_sanitize',
		'sanitize_js_callback' => 'esteem_color_escaping_option_sanitize',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'esteem_primary_color', array(
			'label'    => __( 'This will reflect in links, buttons and many others. Choose a color to match your site.', 'esteem' ),
			'section'  => 'esteem_primary_color_setting',
			'settings' => 'esteem_primary_color',
		) )
	);

	// End of the Design Options

	/**************************************************************************************/

	/* Additional Options Area */
	$wp_customize->add_panel( 'esteem_additional_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 320,
		'title'      => __( 'Additional', 'esteem' ),
	) );

	//Related post
	$wp_customize->add_section( 'esteem_related_posts_section', array(
		'priority' => 5,
		'title'    => esc_html__( 'Related Posts', 'esteem' ),
		'panel'    => 'esteem_additional_options',
	) );

	$wp_customize->add_setting( 'esteem_related_posts_activate', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'esteem_related_posts_activate', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to activate the related posts', 'esteem' ),
		'section'  => 'esteem_related_posts_section',
		'settings' => 'esteem_related_posts_activate',
	) );

	$wp_customize->add_setting( 'esteem_related_posts', array(
		'default'           => 'categories',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_radio_sanitize',
	) );

	$wp_customize->add_control( 'esteem_related_posts', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Related Posts Must Be Shown As:', 'esteem' ),
		'section'  => 'esteem_related_posts_section',
		'settings' => 'esteem_related_posts',
		'choices'  => array(
			'categories' => esc_html__( 'Related Posts By Categories', 'esteem' ),
			'tags'       => esc_html__( 'Related Posts By Tags', 'esteem' ),
		),
	) );

	/**************************************************************************************/

	// Author Bio Option.
	$wp_customize->add_section( 'esteem_author_bio_section', array(
		'priority' => 7,
		'title'    => esc_html__( 'Author Bio Option', 'esteem' ),
		'panel'    => 'esteem_additional_options',
	) );

	$wp_customize->add_setting( 'esteem_author_bio_setting', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esteem_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'esteem_author_bio_setting', array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Check to display the author bio.', 'esteem' ),
		'setting' => 'esteem_author_bio_setting',
		'section' => 'esteem_author_bio_section',
	) );

	/**************************************************************************************/

	/* Slider Options Area */
	$wp_customize->add_panel( 'esteem_slider_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 330,
		'title'      => __( 'Slider', 'esteem' ),
	) );

	// Slider activate option
	$wp_customize->add_section( 'esteem_activate_slider_setting', array(
		'title'    => __( 'Activate slider', 'esteem' ),
		'priority' => 10,
		'panel'    => 'esteem_slider_options',
	) );

	$wp_customize->add_setting( 'esteem_activate_slider', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'sanitize_callback' => 'esteem_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'esteem_activate_slider', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to activate slider.', 'esteem' ),
		'section' => 'esteem_activate_slider_setting',
	) );

	// Selective refresh for slider activation
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'esteem_activate_slider', array(
			'selector'        => '#featured-slider',
			'render_callback' => '',
		) );
	}

	// Slide options
	for ( $i = 1; $i <= 4; $i ++ ) {
		// Slider Image upload
		$wp_customize->add_section( 'esteem_slider_image_setting' . $i, array(
			'title'    => sprintf( __( 'Image Upload #%1$s', 'esteem' ), $i ),
			'priority' => $i + 50,
			'panel'    => 'esteem_slider_options',
		) );

		$wp_customize->add_setting( 'esteem_slider_image' . $i, array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'esteem_sanitize_url',
			'sanitize_js_callback' => 'esteem_sanitize_js_url',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, 'esteem_slider_image' . $i, array(
				'label'    => __( 'Upload slider image.', 'esteem' ),
				'section'  => 'esteem_slider_image_setting' . $i,
				'settings' => 'esteem_slider_image' . $i,
			) )
		);

		// Slider Title
		$wp_customize->add_setting( 'esteem_slider_title' . $i, array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',

		) );
		$wp_customize->add_control( 'esteem_slider_title' . $i, array(
			'label'    => __( 'Enter title for your slider.', 'esteem' ),
			'section'  => 'esteem_slider_image_setting' . $i,
			'settings' => 'esteem_slider_title' . $i,
		) );

		// Slider Description
		$wp_customize->add_setting( 'esteem_slider_text' . $i, array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esteem_text_sanitize',

		) );
		$wp_customize->add_control(
			'esteem_slider_text' . $i, array(
				'type'	   => 'textarea',
				'label'    => __( 'Enter your slider description.', 'esteem' ),
				'section'  => 'esteem_slider_image_setting' . $i,
				'settings' => 'esteem_slider_text' . $i,
			)
		);

		// Slider Link
		$wp_customize->add_setting( 'esteem_slider_link' . $i, array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'esteem_sanitize_url',
			'sanitize_js_callback' => 'esteem_sanitize_js_url',

		) );
		$wp_customize->add_control( 'esteem_slider_link' . $i, array(
			'label'    => __( 'Enter link to redirect slider when clicked', 'esteem' ),
			'section'  => 'esteem_slider_image_setting' . $i,
			'settings' => 'esteem_slider_link' . $i,
		) );
	}

	/**************************************************************************************/

	function esteem_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}

	function esteem_sanitize_url( $input ) {
		$input = esc_url_raw( $input );

		return $input;
	}

	function esteem_sanitize_js_url( $input ) {
		$input = esc_url( $input );

		return $input;
	}

	// Color sanitization
	function esteem_color_option_hex_sanitize( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	function esteem_color_escaping_option_sanitize( $input ) {
		$input = esc_attr( $input );

		return $input;
	}

	// Radio and Select Sanitization
	function esteem_radio_sanitize( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	// Text sanitization
	function esteem_text_sanitize( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}

	// Sanitization of links
	function esteem_links_sanitize() {
		return false;
	}
}

add_action( 'customize_register', 'esteem_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Ample 1.1.8
 */
function esteem_customize_preview_js() {
	wp_enqueue_script( 'esteem-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), false, true );
}

add_action( 'customize_preview_init', 'esteem_customize_preview_js' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function esteem_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function esteem_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

// Function for slogan to support selective refresh
function esteem_slogan() {
	$esteem_slogan = get_theme_mod( 'esteem_slogan' );
	echo esc_html( $esteem_slogan );
}

// Function for sub slogan to support selective refresh
function esteem_sub_slogan() {
	$esteem_sub_slogan = get_theme_mod( 'esteem_sub_slogan' );
	echo esc_html( $esteem_sub_slogan );
}

// Function for slogn readmor button to support selective refresh
function esteem_button_text() {
	$esteem_button_text = get_theme_mod( 'esteem_button_text' );
	echo esc_html( $esteem_button_text );
}

/*****************************************************************************************/

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'esteem_customizer_custom_scripts' );

function esteem_customizer_custom_scripts() { ?>
	<style>
		/* Theme Instructions Panel CSS */
		li#accordion-section-esteem_upsell_section h3.accordion-section-title {
			background-color: #ED564B !important;
			border-left-color: #b72e24 !important;
		}

		#accordion-section-esteem_upsell_section h3 a:after {
			content: '\f345';
			color: #fff;
			position: absolute;
			top: 12px;
			right: 10px;
			z-index: 1;
			font: 400 20px/1 dashicons;
			speak: none;
			display: block;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
			text-decoration: none !important;
		}

		li#accordion-section-esteem_upsell_section h3.accordion-section-title a {
			display: block;
			color: #fff !important;
			text-decoration: none;
		}

		li#accordion-section-esteem_upsell_section h3.accordion-section-title a:focus {
			box-shadow: none;
		}

		li#accordion-section-esteem_upsell_section h3.accordion-section-title:hover {
			background-color: #e04439 !important;
			color: #fff !important;
		}

		/* Upsell button CSS */
		.customize-control-esteem-important-links a {
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#8fc800+0,8fc800+100;Green+Flat+%232 */
			background: #008EC2;
			color: #fff;
			display: block;
			margin: 15px 0 0;
			padding: 5px 0;
			text-align: center;
			font-weight: 600;
		}

		.customize-control-esteem-important-links a {
			padding: 8px 0;
		}

		.customize-control-esteem-important-links a:hover {
			color: #ffffff;
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
			background: #2380BA;
		}
	</style>

	<script>
		( function ( $, api ) {
			api.sectionConstructor['esteem-upsell-section'] = api.Section.extend( {

				// No events for this type of section.
				attachEvents : function () {
				},

				// Always make the section active.
				isContextuallyActive : function () {
					return true;
				}
			} );
		} )( jQuery, wp.customize );

	</script>

	<?php
}
