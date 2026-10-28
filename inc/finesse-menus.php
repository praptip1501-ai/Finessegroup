<?php
/**
 * Finesse Theme Menus
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Finesse navigation menu locations
 */
function finesse_register_nav_menus() {
	register_nav_menus( array(
		'finesse-footer' => esc_html__( 'Finesse Footer Links Menu', 'workstation' ),
	) );
}
add_action( 'after_setup_theme', 'finesse_register_nav_menus', 20 );
