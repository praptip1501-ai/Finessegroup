<?php
/**
 * Workstation Theme - Sanitization Functions
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize hex color
 *
 * @param string $color Color value to sanitize.
 * @return string Sanitized hex color.
 */
function workstation_sanitize_color( $color ) {
	if ( empty( $color ) ) {
		return '';
	}

	if ( '#' === $color[0] ) {
		$color = substr( $color, 1 );
	}

	if ( preg_match( '/^[0-9A-F]{6}$/i', $color ) ) {
		return '#' . $color;
	}

	return '#0073aa';
}

/**
 * Sanitize checkbox
 *
 * @param mixed $input Input value.
 * @return bool Sanitized boolean value.
 */
function workstation_sanitize_checkbox( $input ) {
	return ( isset( $input ) ? true : false );
}

/**
 * Sanitize HTML with wp_kses_post
 *
 * @param string $html HTML string to sanitize.
 * @return string Sanitized HTML.
 */
function workstation_sanitize_html( $html ) {
	return wp_kses_post( $html );
}

/**
 * Sanitize text field
 *
 * @param string $text Text to sanitize.
 * @return string Sanitized text.
 */
function workstation_sanitize_text( $text ) {
	return sanitize_text_field( $text );
}

/**
 * Sanitize URL
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
function workstation_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

/**
 * Sanitize email
 *
 * @param string $email Email to sanitize.
 * @return string Sanitized email.
 */
function workstation_sanitize_email( $email ) {
	return sanitize_email( $email );
}

/**
 * Validate color
 *
 * @param WP_Customize_Setting $setting Setting object.
 * @param string              $value Color value.
 * @return WP_Error|void WP_Error if validation fails.
 */
function workstation_validate_color( $setting, $value ) {
	if ( empty( $value ) ) {
		return;
	}

	if ( ! preg_match( '/^#[0-9A-F]{6}$/i', $value ) ) {
		$setting->preview()->defer_sanitize_js_variables = true;
		return new WP_Error( 'invalid_color', esc_html__( 'Invalid color value.', 'workstation' ) );
	}
}

/**
 * Validate integer
 *
 * @param WP_Customize_Setting $setting Setting object.
 * @param int                  $value Integer value.
 * @return WP_Error|void WP_Error if validation fails.
 */
function workstation_validate_integer( $setting, $value ) {
	if ( ! is_numeric( $value ) || ( (int) $value ) < 0 ) {
		$setting->preview()->defer_sanitize_js_variables = true;
		return new WP_Error( 'invalid_integer', esc_html__( 'Invalid integer value.', 'workstation' ) );
	}
}

/**
 * Validate text (max length)
 *
 * @param WP_Customize_Setting $setting Setting object.
 * @param string              $value Text value.
 * @param int                 $max_length Maximum length allowed.
 * @return WP_Error|void WP_Error if validation fails.
 */
function workstation_validate_text_length( $setting, $value, $max_length = 100 ) {
	if ( strlen( $value ) > $max_length ) {
		$setting->preview()->defer_sanitize_js_variables = true;
		return new WP_Error(
			'text_too_long',
			sprintf(
				esc_html__( 'Text cannot exceed %d characters.', 'workstation' ),
				$max_length
			)
		);
	}
}
