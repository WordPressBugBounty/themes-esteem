jQuery( document ).ready( function () {
	/**
	 * Search
	 */
	( function () {
		var searchBox, icon;

		searchBox = document.getElementById( 'masthead' ).getElementsByClassName( 'search-form-top' )[0];
		icon      = document.getElementById( 'masthead' ).getElementsByClassName( 'search-top' )[0];

		if ( typeof icon === 'undefined' ) {
			return;
		}

		var showHideSearchForm = function ( action ) {
			if ( action === 'hide' ) {
				searchBox.classList.remove( 'active' );
				return;
			}
			// Show/hide search form
			searchBox.classList.toggle( 'active' );

			// autofocus
			if ( searchBox.classList.contains( 'active' ) ) {
				searchBox.getElementsByTagName( 'input' )[0].focus();
			}
		};

		// on search icon click
		icon.onclick = function () {
			showHideSearchForm();
		};

		// on esc key
		document.addEventListener( 'keyup', function ( e ) {
			if ( searchBox.classList.contains( 'active' ) && e.keyCode === 27 ) {
				showHideSearchForm( 'hide' );
			}
		} );

		// on click outside form
		document.addEventListener( 'click', function ( ev ) {
			if ( ev.target.closest( '.search-form-top' ) || ev.target.closest( '.search-top' ) ) {
				return;
			}
			showHideSearchForm( 'hide' );
		} );
	} )();

	jQuery( '#scroll-up' ).hide();

	jQuery( function () {
		jQuery( window ).scroll( function () {
			if ( jQuery( this ).scrollTop() > 1000 ) {
				jQuery( '#scroll-up' ).fadeIn();
			} else {
				jQuery( '#scroll-up' ).fadeOut();
			}
		} );

		jQuery( 'a#scroll-up' ).click( function () {
			jQuery( 'body,html' ).animate( {
				scrollTop : 0
			}, 800 );
			return false;
		} );
	} );
} );

jQuery( document ).on( 'click', '#site-navigation .menunav-menu li.menu-item-has-children > a', function ( event ) {
	var menuClass = jQuery( this ).parent( '.menu-item-has-children' );

	if ( ! menuClass.hasClass( 'focus' ) ) {
		menuClass.addClass( 'focus' );
		event.preventDefault();
		menuClass.children( '.sub-menu' ).css( {
			'display' : 'block'
		} );
	}
} );

/**
 * Slider Setting
 *
 * Contains all the slider settings for the featured post/page slider.
 */

jQuery( window ).load( function () {

	if ( typeof jQuery.fn.cycle !== 'undefined' ) {
		jQuery( '.slider-cycle' ).cycle( {
			fx                : 'fade',
			slides            : '> section',
			pager             : '> #controllers',
			pagerActiveClass  : 'active',
			pagerTemplate     : '<a></a>',
			timeout           : 4000,
			speed             : 1000,
			pause             : 1,
			pauseOnPagerHover : 1,
			width             : '100%',
			containerResize   : 0,
			autoHeight        : 'container',
			fit               : 1,
			after             : function () {
				jQuery( this ).parent().css( 'height', jQuery( this ).height() );
			},
			cleartypeNoBg     : true,
			log               : false,
			swipe             : true

		} );
	}

} );

