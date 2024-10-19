<?php
/**
 * Esteem Admin Class.
 *
 * @author  ThemeGrill
 * @package esteem
 * @since   1.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Esteem_Admin' ) ) :

	/**
	 * Esteem_Admin Class.
	 */
	class Esteem_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'esteem-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), ESTEEM_THEME_VERSION );

			wp_enqueue_script( 'esteem-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), ESTEEM_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&esteem-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'esteem' ),
				'nonce'    => wp_create_nonce( 'esteem_demo_import_nonce' ),
			);

			wp_localize_script( 'esteem-plugin-install-helper', 'esteemRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new Esteem_Admin();
