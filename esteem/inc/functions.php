<?php
/**
 * Esteem functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package    ThemeGrill
 * @subpackage Esteem
 * @since      Esteem 1.0
 */

/****************************************************************************************/

add_action( 'wp_enqueue_scripts', 'esteem_scripts_styles_method' );
/**
 * Register jquery scripts
 */
function esteem_scripts_styles_method() {

	global $esteem_theme_options_settings;
	$options = $esteem_theme_options_settings;

	/**
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'esteem_style', get_stylesheet_uri() );

	wp_enqueue_style( 'esteem-responsive', ESTEEM_CSS_URL . '/responsive.css' );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Register JQuery cycle 2 js file for slider.
	 */
	wp_register_script( 'jquery_cycle', ESTEEM_JS_URL . '/jquery.cycle2.min.js', array( 'jquery' ), '2.1.6', true );
	wp_register_script( 'jquery-cycle2-swipe', ESTEEM_JS_URL . '/jquery.cycle2.swipe.min.js', array( 'jquery' ), false, true );

	/**
	 * Enqueue Slider setup js file.
	 */
	if ( get_theme_mod( 'esteem_activate_slider', '0' ) == '1' ) {
		if ( is_home() || is_front_page() ) {
			wp_enqueue_script( 'jquery_cycle' );
			wp_enqueue_script( 'jquery-cycle2-swipe' );
		}
	}

	wp_enqueue_script( 'esteem-custom', ESTEEM_JS_URL . '/esteem-custom.js', array( 'jquery' ) );
	wp_enqueue_style( 'esteem-fontawesome', get_template_directory_uri() . '/fontawesome/css/font-awesome.css', array(), '3.2.1' );

	/**
	 * Browser specific queuing i.e
	 */
	wp_enqueue_script( 'html5', ESTEEM_JS_URL . '/html5shiv.min.js', true );
	wp_script_add_data( 'html5', 'conditional', 'lte IE 8' );

	wp_enqueue_script( 'esteem-navigation', ESTEEM_JS_URL . '/navigation.js', array( 'jquery' ), false, true );

	// Skip link focus fix JS enqueue.
	wp_enqueue_script( 'esteem-skip-link-focus-fix', ESTEEM_JS_URL . '/skip-link-focus-fix.js', array(), false, true );

}

add_action( 'admin_print_styles', 'esteem_admin_styles' );
/**
 * Enqueuing some styles.
 *
 * @uses wp_enqueue_style to register stylesheets.
 * @uses wp_enqueue_style to add styles.
 */
function esteem_admin_styles() {
	wp_enqueue_style( 'esteem-fontawesome', get_template_directory_uri() . '/fontawesome/css/font-awesome.css', array(), '3.2.1' );
}

/****************************************************************************************/
/*
 * Display the related posts.
 */
if ( ! function_exists( 'esteem_related_posts_function' ) ) {

	function esteem_related_posts_function() {
		wp_reset_postdata();
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'         => 3,
		);

		// Related by categories.
		if ( get_theme_mod( 'esteem_related_posts', 'categories' ) == 'categories' ) {
			$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
			$args['category__in'] = $cats;
		}

		// Related by tags.
		if ( get_theme_mod( 'esteem_related_posts', 'categories' ) == 'tags' ) {
			$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
			$args['tag__in'] = $tags;

			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query();

		return $query;
	}
}

/****************************************************************************************/

if ( ! function_exists( 'esteem_sidebar_select' ) ) :
	function esteem_sidebar_select() {
		global $post;

		if ( $post ) {
			$layout_meta = get_post_meta( $post->ID, '_esteem_layout', true );
		}

		if ( is_home() ) {
			$queried_id  = get_option( 'page_for_posts' );
			$layout_meta = get_post_meta( $queried_id, '_esteem_layout', true );
		}

		if ( empty( $layout_meta ) || is_archive() || is_search() ) {
			$layout_meta = 'default_layout';
		}
		$esteem_default_layout = get_theme_mod( 'esteem_default_layout', 'right_sidebar' );

		$esteem_default_page_layout = get_theme_mod( 'esteem_pages_default_layout', 'right_sidebar' );
		$esteem_default_post_layout = get_theme_mod( 'esteem_single_posts_default_layout', 'right_sidebar' );

		if ( $layout_meta == 'default_layout' ) {
			if ( is_page() || is_home() ) {
				if ( $esteem_default_page_layout == 'right_sidebar' ) {
					get_sidebar();
				} elseif ( $esteem_default_page_layout == 'left_sidebar' ) {
					get_sidebar( 'left' );
				}
			} elseif ( is_single() ) {
				if ( $esteem_default_post_layout == 'right_sidebar' ) {
					get_sidebar();
				} elseif ( $esteem_default_post_layout == 'left_sidebar' ) {
					get_sidebar( 'left' );
				}
			} elseif ( $esteem_default_layout == 'right_sidebar' ) {
				get_sidebar();
			} elseif ( $esteem_default_layout == 'left_sidebar' ) {
				get_sidebar( 'left' );
			}
		} elseif ( $layout_meta == 'right_sidebar' ) {
			get_sidebar();
		} elseif ( $layout_meta == 'left_sidebar' ) {
			get_sidebar( 'left' );
		}
	}
endif;

add_filter( 'body_class', 'esteem_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function esteem_body_class( $classes ) {
	global $post;

	if ( $post ) {
		$layout_meta = get_post_meta( $post->ID, '_esteem_layout', true );
	}

	if ( is_home() ) {
		$queried_id  = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, '_esteem_layout', true );
	}

	if ( empty( $layout_meta ) || is_archive() || is_search() ) {
		$layout_meta = 'default_layout';
	}
	$esteem_default_layout = get_theme_mod( 'esteem_default_layout', 'right_sidebar' );

	$esteem_default_page_layout = get_theme_mod( 'esteem_pages_default_layout', 'right_sidebar' );
	$esteem_default_post_layout = get_theme_mod( 'esteem_single_posts_default_layout', 'right_sidebar' );

	if ( $layout_meta == 'default_layout' ) {
		if ( is_page() || is_home() ) {
			if ( $esteem_default_page_layout == 'right_sidebar' ) {
				$classes[] = '';
			} elseif ( $esteem_default_page_layout == 'left_sidebar' ) {
				$classes[] = 'left-sidebar';
			} elseif ( $esteem_default_page_layout == 'no_sidebar_full_width' ) {
				$classes[] = 'no-sidebar-full-width';
			} elseif ( $esteem_default_page_layout == 'no_sidebar_content_centered' ) {
				$classes[] = 'no-sidebar';
			}
		} elseif ( is_single() ) {
			if ( $esteem_default_post_layout == 'right_sidebar' ) {
				$classes[] = '';
			} elseif ( $esteem_default_post_layout == 'left_sidebar' ) {
				$classes[] = 'left-sidebar';
			} elseif ( $esteem_default_post_layout == 'no_sidebar_full_width' ) {
				$classes[] = 'no-sidebar-full-width';
			} elseif ( $esteem_default_post_layout == 'no_sidebar_content_centered' ) {
				$classes[] = 'no-sidebar';
			}
		} elseif ( $esteem_default_layout == 'right_sidebar' ) {
			$classes[] = '';
		} elseif ( $esteem_default_layout == 'left_sidebar' ) {
			$classes[] = 'left-sidebar';
		} elseif ( $esteem_default_layout == 'no_sidebar_full_width' ) {
			$classes[] = 'no-sidebar-full-width';
		} elseif ( $esteem_default_layout == 'no_sidebar_content_centered' ) {
			$classes[] = 'no-sidebar';
		}
	} elseif ( $layout_meta == 'right_sidebar' ) {
		$classes[] = '';
	} elseif ( $layout_meta == 'left_sidebar' ) {
		$classes[] = 'left-sidebar';
	} elseif ( $layout_meta == 'no_sidebar_full_width' ) {
		$classes[] = 'no-sidebar-full-width';
	} elseif ( $layout_meta == 'no_sidebar_content_centered' ) {
		$classes[] = 'no-sidebar';
	}


	if ( get_theme_mod( 'esteem_posts_page_display_type', 'full_content' ) == 'small_image' ) {
		$classes[] = 'blog-medium';
	}
	if ( get_theme_mod( 'esteem_posts_page_display_type', 'full_content' ) == 'large_image' ) {
		$classes[] = 'blog-large';
	}

	if ( get_theme_mod( 'esteem_site_layout', 'box' ) == 'wide' ) {
		$classes[] = 'wide';
	} else {
		$classes[] = 'boxed';
	}

	if ( get_theme_mod( 'esteem_new_menu_enable', '1' ) == '1' ) {
		$classes[] = 'better-responsive-menu';
	}

	return $classes;
}

add_filter( 'excerpt_length', 'esteem_excerpt_length' );

/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function esteem_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_more', 'esteem_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function esteem_continue_reading() {
	return '&hellip; ';
}

/****************************************************************************************/

add_action( 'wp_head', 'esteem_custom_css', 100 );
/**
 * Hooks the Custom Internal CSS to head section
 */
function esteem_custom_css() {

	$esteem_internal_css = '';
	$primary_color       = get_theme_mod( 'esteem_primary_color', '#ED564B' );

	if ( $primary_color != '#ED564B' ) {
		$esteem_internal_css .= 'blockquote{border-left: 3px solid ' . $primary_color . '}
		button,html input[type="button"],input[type="reset"],input[type="submit"],#slider-title a{background:' . $primary_color . '}
		a,a:visited,a:hover,a:focus,a:active,.main-navigation li:hover > a,.main-navigation li.current_page_item > a,.main-navigation li.current-menu-item > a,.main-navigation li.current-menu-ancestor > a,#site-title a span,#site-title a:hover,#site-title a:focus,#site-title a:active,#controllers a:hover, #controllers a.active,.widget ul li a:hover,.widget ul li a:hover:before,.services-block .read-more:hover,.service-image-wrap,.service-title a:hover,.entry-meta a:hover,.entry-title a:hover,.search-wrap button:before,#site-generator a:hover, #colophon .widget a:hover,.menu-toggle:before{color: ' . $primary_color . '}
		.main-navigation ul ul {border-top: 4px solid' . $primary_color . '}
		#controllers a:hover, #controllers a.active,#promo-box,.fancy-tab,.call-to-action-button,.readmore-wrap,.page-title-bar,.default-wp-page .previous a:hover, .default-wp-page .next a:hover{ background-color: ' . $primary_color . '}
		#secondary .widget-title span, #colophon .widget-title span{ border-bottom: 2px solid ' . $primary_color . '}
		.services-block .read-more:hover{border: 1px solid ' . $primary_color . '}
		.service-border{ border: 3px solid ' . $primary_color . '}
		.blog-medium .post-featured-image, .blog-large .post-featured-image, .category .post-featured-image, .search .post-featured-image{border-bottom: 4px solid ' . $primary_color . '}
		.search-form-top,#colophon{border-top: 3px solid ' . $primary_color . '}
		a#scroll-up{ background-color: ' . $primary_color . '}
		.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce span.onsale,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {background-color: ' . $primary_color . ';}
		.woocommerce ul.products li.product .price .amount,.entry-summary .price .amount,.woocommerce .woocommerce-message::before, .count{color: ' . $primary_color . ';}
		.woocommerce .woocommerce-message {border-top-color: ' . $primary_color . ';}
		@media screen and (max-width: 768px) { .better-responsive-menu .sub-toggle { background: ' . $primary_color . '}}';
	}

	if ( ! empty( $esteem_internal_css ) ) {
		?>
		<style type="text/css"><?php echo $esteem_internal_css; ?></style>
		<?php
	}

}

/**************************************************************************************/

add_action( 'esteem_footer_copyright', 'esteem_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
if ( ! function_exists( 'esteem_footer_copyright' ) ) :
	function esteem_footer_copyright() {
		$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';

		$wp_link = '<a href="' . esc_url( 'https://wordpress.org' ) . '" target="_blank" title="' . esc_attr__( 'WordPress', 'esteem' ) . '"rel="nofollow"><span>' . esc_html__( 'WordPress', 'esteem' ) . '</span></a>';

		$tg_link = '<a href="' . esc_url( 'https://themegrill.com/themes/esteem' ) . '" target="_blank" title="' . esc_attr__( 'Esteem', 'esteem' ) . '" rel="nofollow"><span>' . esc_html__( 'Esteem', 'esteem' ) . '</span></a>';

		$default_footer_value = sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'esteem' ), date( 'Y' ), $site_link ) . ' ' . sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'esteem' ), $tg_link, 'ThemeGrill' ) . ' ' . sprintf( esc_html__( 'Powered by %s.', 'esteem' ), $wp_link );

		$esteem_footer_copyright = '<div class="copyright">' . $default_footer_value . '</div>';

		echo $esteem_footer_copyright;
	}
endif;

/**************************************************************************************/

if ( ! function_exists( 'esteem_posts_listing_display_type_select' ) ) :
	/**
	 * Function to select the posts listing display type
	 */
	function esteem_posts_listing_display_type_select() {
		if ( get_theme_mod( 'esteem_posts_page_display_type', 'full_content' ) == 'large_image' ) {
			$format = 'blog-image-large';
		} elseif ( get_theme_mod( 'esteem_posts_page_display_type', 'full_content' ) == 'small_image' ) {
			$format = 'blog-image-medium';
		} elseif ( get_theme_mod( 'esteem_posts_page_display_type', 'full_content' ) == 'full_content' ) {
			$format = 'blog-full-content';
		} else {
			$format = get_post_format();
		}

		return $format;
	}
endif;

add_action( 'admin_init', 'esteem_textarea_sanitization_change', 100 );
/**
 * Override the default textarea sanitization.
 */
function esteem_textarea_sanitization_change() {
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'esteem_sanitize_textarea_custom', 10, 2 );
}

/**
 * sanitize the input for custom css
 */
function esteem_sanitize_textarea_custom( $input, $option ) {
	if ( $option['id'] == "esteem_custom_css" ) {
		$output = wp_filter_nohtml_kses( $input );
	} else {
		$output = $input;
	}

	return $output;
}

/**
 * Adding the support for the entry-title tag for Google Rich Snippets
 */
function esteem_add_mod_hatom_data( $content ) {
	$title = get_the_title();
	if ( is_single() ) {
		$content .= '<div class="extra-hatom-entry-title"><span class="entry-title">' . $title . '</span></div>';
	}

	return $content;
}

add_filter( 'the_content', 'esteem_add_mod_hatom_data' );

/****************************************************************************************/

if ( ! function_exists( 'esteem_entry_meta' ) ) :
	/**
	 * Shows meta information of post.
	 */
	function esteem_entry_meta() {
		if ( 'post' == get_post_type() ) :
			echo '<div class="entry-meta-bar clearfix">';
			echo '<div class="entry-meta clearfix">';
			?>

			<span class="icon-user vcard author"><a class="url fn n"
			                                        href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>

			<?php
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
			}
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);
			printf( __( '<span class="icon-time"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>', 'esteem' ),
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				$time_string
			); ?>

			<?php if ( has_category() ) { ?>
			<span class="icon-tag"><?php the_category( ', ' ); ?></span>
		<?php } ?>

			<?php if ( comments_open() ) { ?>
			<span class="icon-comment-alt"><?php comments_popup_link( __( 'No Comments', 'esteem' ), __( '1 Comment', 'esteem' ), __( '% Comments', 'esteem' ), '', __( 'Comments Off', 'esteem' ) ); ?></span>
		<?php } ?>

			<?php edit_post_link( __( 'Edit', 'esteem' ), '<span class="icon-pencil">', '</span>' ); ?>

			<?php
			echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Making the theme Woocommrece compatible
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_action( 'woocommerce_before_main_content', 'esteem_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'esteem_wrapper_end', 10 );

function esteem_wrapper_start() {
	echo '<div id="primary">';
}

function esteem_wrapper_end() {
	echo '</div>';
}

if ( ! function_exists( 'esteem_pingback_header' ) ) :

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function esteem_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

endif;

add_action( 'wp_head', 'esteem_pingback_header' );


/**
 * Compare user's current version of plugin.
 */
if ( ! function_exists( 'esteem_plugin_version_compare' ) ) {
	function esteem_plugin_version_compare( $plugin_slug, $version_to_compare ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$installed_plugins = get_plugins();

		// Plugin not installed.
		if ( ! isset( $installed_plugins[ $plugin_slug ] ) ) {
			return false;
		}

		$tdi_user_version = $installed_plugins[ $plugin_slug ]['Version'];

		return version_compare( $tdi_user_version, $version_to_compare, '<' );
	}
}
