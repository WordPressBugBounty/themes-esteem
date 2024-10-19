/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ( $ ) {
	// Site title
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-title a' ).text( to );
		} );
	} );

	// Site description.
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Site layout
	wp.customize( 'esteem_site_layout', function ( value ) {
		value.bind( function ( layout ) {
			var layout_options = layout;
			if ( layout_options == 'wide' ) {
				$( 'body' ).addClass( 'wide' );
			} else if( layout == 'box' ) {
				$( 'body' ).removeClass( 'wide' );
			}
		});
	});

	/*
	 * Shows a live preview of changing the site title color.
	 */
	wp.customize( 'header_textcolor', function( value ) {

		value.bind( function( to ) {

			jQuery( '#site-title a' ).css( 'color', to );

		} ); // value.bind

	} ); // wp.customize

	// Primary color option
	wp.customize( 'esteem_primary_color', function ( value ) {
		value.bind( function ( primaryColor ) {
			// Store internal style for primary color
			var primaryColorStyle = '<style id="esteem-internal-primary-color"> blockquote{border-left: 3px solid '  + primaryColor +'}' +
			'button,html input[type="button"],input[type="reset"],input[type="submit"],#slider-title a{background:' + primaryColor +'}' +
			'a,a:visited,a:hover,a:focus,a:active,.main-navigation li:hover > a,.main-navigation li.current_page_item > a,.main-navigation li.current-menu-item > a,.main-navigation li.current-menu-ancestor > a,#site-title a span,#site-title a:hover,#site-title a:focus,#site-title a:active,#controllers a:hover, #controllers a.active,.widget ul li a:hover,.widget ul li a:hover:before,.services-block .read-more:hover,.service-image-wrap,.service-title a:hover,.entry-meta a:hover,.entry-title a:hover,.search-wrap button:before,#site-generator a:hover, #colophon .widget a:hover,.menu-toggle:before{color: ' + primaryColor +'}' +
			'.main-navigation ul ul {border-top: 4px solid' + primaryColor +'}' +
			'#controllers a:hover, #controllers a.active,#promo-box,.fancy-tab,.call-to-action-button,.readmore-wrap,.page-title-bar,.default-wp-page .previous a:hover, .default-wp-page .next a:hover{ background-color: ' + primaryColor +'}' +
			'#secondary .widget-title span, #colophon .widget-title span{ border-bottom: 2px solid ' + primaryColor +'}' +
			'.services-block .read-more:hover{border: 1px solid ' + primaryColor +'}' +
			'.service-border{ border: 3px solid ' + primaryColor +'}' +
			'.blog-medium .post-featured-image, .blog-large .post-featured-image, .category .post-featured-image, .search .post-featured-image{border-bottom: 4px solid ' + primaryColor +'}' +
			'.search-form-top,#colophon{border-top: 3px solid ' + primaryColor +'}' +
			'a#scroll-up,.better-responsive-menu .sub-toggle { background-color: ' + primaryColor +'}' +
			 '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce span.onsale,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {background-color: ' + primaryColor +';}' +
			  '.woocommerce ul.products li.product .price .amount,.entry-summary .price .amount,.woocommerce .woocommerce-message::before, .count{color: ' + primaryColor +';}' +
			   '.woocommerce .woocommerce-message {border-top-color: ' + primaryColor +';} </style>';

			// Remove previously create internal style and add new one.
			$( 'head #spacious-internal-primary-color' ).remove();
			$( 'head' ).append( primaryColorStyle );
		}
		);
	} );

})( jQuery );