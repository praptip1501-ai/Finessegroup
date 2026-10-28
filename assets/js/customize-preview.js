/**
 * Customizer Preview JavaScript
 *
 * Handles live preview updates in the WordPress Customizer.
 *
 * @package Workstation
 * @since 1.0.0
 */

(function( api, $ ) {
	'use strict';

	var root = document.documentElement;
	var styleId = 'workstation-customizer-preview-style';

	function updateRootVar( property, value, suffix ) {
		root.style.setProperty( property, String( value ) + ( suffix || '' ) );
	}

	function updatePreviewRule( css ) {
		var $style = $( '#' + styleId );

		if ( $style.length ) {
			$style.html( css );
		} else {
			$( 'head' ).append( '<style id="' + styleId + '">' + css + '</style>' );
		}
	}

	function bindCssVar( settingId, property, suffix ) {
		api( settingId, function( value ) {
			value.bind( function( to ) {
				updateRootVar( property, to, suffix );
			} );
		} );
	}

	bindCssVar( 'workstation_primary_color', '--color-primary' );
	bindCssVar( 'workstation_primary_color', '--color-ring' );
	bindCssVar( 'workstation_primary_strong_color', '--color-primary-strong' );
	bindCssVar( 'workstation_accent_color', '--color-accent' );
	bindCssVar( 'workstation_heading_color', '--color-heading' );
	bindCssVar( 'workstation_text_color', '--color-text' );
	bindCssVar( 'workstation_surface_color', '--color-surface' );
	bindCssVar( 'workstation_footer_bg_color', '--color-footer-bg' );
	bindCssVar( 'workstation_site_width', '--site-width', 'px' );
	bindCssVar( 'workstation_content_width', '--content-width', 'px' );
	bindCssVar( 'workstation_sidebar_width', '--sidebar-width', 'px' );
	bindCssVar( 'workstation_card_radius', '--radius-lg', 'px' );
	api( 'workstation_body_font_size', function( value ) {
		value.bind( function( to ) {
			document.body.style.fontSize = String( to ) + 'px';
		} );
	} );

	api( 'workstation_body_line_height', function( value ) {
		value.bind( function( to ) {
			document.body.style.lineHeight = String( Number( to ) / 10 );
		} );
	} );

	api( 'workstation_heading_line_height', function( value ) {
		value.bind( function( to ) {
			updateRootVar( '--heading-line-height', Number( to ) / 100 );
		} );
	} );

	api( 'workstation_heading_scale', function( value ) {
		value.bind( function( to ) {
			updateRootVar( '--heading-scale', Number( to ) / 100 );
		} );
	} );

	api( 'workstation_site_title_size', function( value ) {
		value.bind( function( to ) {
			updateRootVar( '--site-title-size', Number( to ) / 100 );
		} );
	} );

	api( 'workstation_post_title_size', function( value ) {
		value.bind( function( to ) {
			updateRootVar( '--post-title-size', Number( to ) / 100 );
		} );
	} );

	api( 'workstation_sticky_header', function( value ) {
		value.bind( function( to ) {
			updatePreviewRule( to ? '.site-header{position:sticky;}' : '.site-header{position:static;}' );
		} );
	} );

	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description, .footer-description' ).text( to );
		} );
	} );
})( wp.customize, jQuery );
