<?php
/**
 * The template part for displaying navigation.
 *
 * @package Esteem
 */

if ( is_archive() || is_home() || is_search() ) {
	/**
	 * Checking WP-PageNaviplugin exist
	 */
	if ( function_exists('wp_pagenavi' ) ) :
		wp_pagenavi();

	else:
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) :
		?>
		<ul class="default-wp-page clearfix">
			<li class="previous"><?php next_posts_link( __( '&laquo; Previous', 'esteem' ) ); ?></li>
			<li class="next"><?php previous_posts_link( __( 'Next &raquo;', 'esteem' ) ); ?></li>
		</ul>
		<?php
		endif;
	endif;
}

if ( is_single() ) {
	if( is_attachment() ) {
	?>
		<ul class="default-wp-page clearfix">
			<li class="previous"><?php previous_image_link( false, __( '&larr; Previous', 'esteem' ) ); ?></li>
			<li class="next"><?php next_image_link( false, __( 'Next &rarr;', 'esteem' ) ); ?></li>
		</ul>
	<?php
	}
	else {
	?>
		<ul class="default-wp-page clearfix">
			<li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'esteem' ) . '</span> %title' ); ?></li>
			<li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'esteem' ) . '</span>' ); ?></li>
		</ul>
	<?php
	}
}

?>
