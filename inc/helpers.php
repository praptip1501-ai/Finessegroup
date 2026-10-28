<?php
/**
 * Workstation Theme - Helper Functions
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get theme customizer mod value
 *
 * @param string $setting Setting name.
 * @param string $default Default value.
 * @return mixed Theme mod value or default.
 */
function workstation_get_mod( $setting, $default = '' ) {
	return get_theme_mod( $setting, $default );
}

/**
 * Check if sidebar should display
 *
 * @return bool True if sidebar should display.
 */
function workstation_has_sidebar() {
	return is_active_sidebar( 'sidebar-1' ) && ( is_home() || is_archive() || is_search() );
}

/**
 * Get footer widget area count
 *
 * @return int Number of active footer widget areas.
 */
function workstation_footer_widget_count() {
	$count = 0;
	if ( is_active_sidebar( 'footer-1' ) ) $count++;
	if ( is_active_sidebar( 'footer-2' ) ) $count++;
	if ( is_active_sidebar( 'footer-3' ) ) $count++;
	return $count;
}

/**
 * Get footer grid columns
 *
 * @return int Number of columns for footer grid.
 */
function workstation_footer_grid_columns() {
	$count = workstation_footer_widget_count();
	return max( 1, min( 3, $count ) );
}

/**
 * Get primary color from customizer
 *
 * @return string Hex color value.
 */
function workstation_primary_color() {
	return workstation_get_mod( 'workstation_primary_color', '#0073aa' );
}

/**
 * Get heading color from customizer
 *
 * @return string Hex color value.
 */
function workstation_heading_color() {
	return workstation_get_mod( 'workstation_heading_color', '#000000' );
}

/**
 * Get footer copyright text
 *
 * @return string Footer copyright text, escaped and safe.
 */
function workstation_footer_text() {
	$default = '&copy; ' . get_bloginfo( 'name' ) . '. ' . esc_html__( 'All rights reserved.', 'workstation' );
	$text    = workstation_get_mod( 'workstation_footer_text', $default );

	return wp_kses_post( $text );
}

/**
 * Check if featured images should display
 *
 * @return bool True if featured images should display.
 */
function workstation_show_featured_images() {
	return (bool) workstation_get_mod( 'workstation_show_featured_image', true );
}

/**
 * Get posts per page setting
 *
 * @return int Posts per page.
 */
function workstation_posts_per_page() {
	return absint( workstation_get_mod( 'workstation_posts_per_page', 10 ) );
}

/**
 * Output site logo/custom logo
 */
function workstation_the_custom_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
	}
}

/**
 * Get custom logo image
 *
 * @return string|bool Custom logo HTML or false.
 */
function workstation_get_custom_logo() {
	return get_custom_logo();
}

/**
 * Check if current page has title
 *
 * @return bool True if page should display title.
 */
function workstation_show_page_title() {
	return is_singular() && get_the_title();
}

/**
 * Safe post class wrapper
 *
 * @param array $classes Additional classes.
 * @param int   $post_id Post ID (optional).
 * @return array Post classes.
 */
function workstation_get_post_classes( $classes = array(), $post_id = null ) {
	return get_post_class( $classes, $post_id );
}

/**
 * Get archive title safely
 *
 * @return string Archive title.
 */
function workstation_get_archive_title() {
	if ( is_home() && ! is_front_page() ) {
		return esc_html__( 'Blog', 'workstation' );
	} elseif ( is_archive() ) {
		return get_the_archive_title();
	}
	return '';
}

/**
 * Get archive description safely
 *
 * @return string Archive description.
 */
function workstation_get_archive_description() {
	if ( is_archive() ) {
		return get_the_archive_description();
	}
	return '';
}

/**
 * Truncate text to word limit
 *
 * @param string $text Text to truncate.
 * @param int    $limit Word limit.
 * @param string $more Append text if truncated.
 * @return string Truncated text.
 */
function workstation_truncate_text( $text, $limit = 20, $more = '...' ) {
	if ( ! $text ) {
		return '';
	}

	$words = explode( ' ', wp_strip_all_tags( $text ) );

	if ( count( $words ) > $limit ) {
		$text = implode( ' ', array_slice( $words, 0, $limit ) ) . $more;
	}

	return $text;
}

/**
 * Get featured image URL
 *
 * @param int    $post_id Post ID.
 * @param string $size Image size.
 * @return string Image URL.
 */
function workstation_get_featured_image_url( $post_id = null, $size = 'large' ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$image_id = get_post_thumbnail_id( $post_id );

	if ( ! $image_id ) {
		return '';
	}

	$image = wp_get_attachment_image_src( $image_id, $size );

	return isset( $image[0] ) ? esc_url( $image[0] ) : '';
}

/**
 * Get post excerpt safely
 *
 * @param int    $post_id Post ID.
 * @param int    $length Excerpt length.
 * @return string Escaped post excerpt.
 */
function workstation_get_excerpt( $post_id = null, $length = 55 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$post = get_post( $post_id );

	if ( ! $post ) {
		return '';
	}

	$excerpt = $post->post_excerpt;

	if ( ! $excerpt ) {
		$excerpt = wp_strip_all_tags( $post->post_content );
	}

	if ( ! $excerpt ) {
		return '';
	}

	$words = explode( ' ', $excerpt );

	if ( count( $words ) > $length ) {
		$excerpt = implode( ' ', array_slice( $words, 0, $length ) ) . '...';
	}

	return wp_kses_post( $excerpt );
}
