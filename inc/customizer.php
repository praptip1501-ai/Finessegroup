<?php
/**
 * Workstation Theme - Customizer Configuration
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add theme customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function workstation_customize_register( $wp_customize ) {
	if ( $wp_customize->get_section( 'colors' ) ) {
		$wp_customize->get_section( 'colors' )->title       = esc_html__( 'Brand Colors', 'workstation' );
		$wp_customize->get_section( 'colors' )->description = esc_html__( 'Adjust the main theme palette used across the header, cards, links, buttons, and footer.', 'workstation' );
	}

	$wp_customize->add_setting( 'workstation_primary_color', array(
		'default'           => '#0f766e',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_primary_color', array(
		'label'       => esc_html__( 'Primary Brand Color', 'workstation' ),
		'description' => esc_html__( 'Used for links, buttons, and active states.', 'workstation' ),
		'section'     => 'colors',
		'priority'    => 10,
	) ) );

	$wp_customize->add_setting( 'workstation_primary_strong_color', array(
		'default'           => '#115e59',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_primary_strong_color', array(
		'label'       => esc_html__( 'Primary Dark Color', 'workstation' ),
		'description' => esc_html__( 'Used for hover states and strong emphasis.', 'workstation' ),
		'section'     => 'colors',
		'priority'    => 20,
	) ) );

	$wp_customize->add_setting( 'workstation_accent_color', array(
		'default'           => '#f59e0b',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_accent_color', array(
		'label'       => esc_html__( 'Accent Color', 'workstation' ),
		'description' => esc_html__( 'Used for highlights and decorative accents.', 'workstation' ),
		'section'     => 'colors',
		'priority'    => 30,
	) ) );

	$wp_customize->add_setting( 'workstation_heading_color', array(
		'default'           => '#0b1b2b',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_heading_color', array(
		'label'    => esc_html__( 'Heading Color', 'workstation' ),
		'section'  => 'colors',
		'priority' => 40,
	) ) );

	$wp_customize->add_setting( 'workstation_text_color', array(
		'default'           => '#102033',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_text_color', array(
		'label'    => esc_html__( 'Body Text Color', 'workstation' ),
		'section'  => 'colors',
		'priority' => 50,
	) ) );

	$wp_customize->add_setting( 'workstation_surface_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_surface_color', array(
		'label'       => esc_html__( 'Card Surface Color', 'workstation' ),
		'description' => esc_html__( 'Background for post cards, widgets, and content panels.', 'workstation' ),
		'section'     => 'colors',
		'priority'    => 60,
	) ) );

	$wp_customize->add_setting( 'workstation_footer_bg_color', array(
		'default'           => '#0f172a',
		'sanitize_callback' => 'workstation_sanitize_color',
		'validate_callback' => 'workstation_validate_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'workstation_footer_bg_color', array(
		'label'    => esc_html__( 'Footer Background', 'workstation' ),
		'section'  => 'colors',
		'priority' => 70,
	) ) );

	$wp_customize->add_section( 'workstation_layout', array(
		'title'       => esc_html__( 'Layout', 'workstation' ),
		'description' => esc_html__( 'Control widths, spacing feel, and sticky header behavior.', 'workstation' ),
		'priority'    => 35,
	) );

	$wp_customize->add_setting( 'workstation_site_width', array(
		'default'           => 1200,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_site_width', array(
		'label'       => esc_html__( 'Max Site Width', 'workstation' ),
		'description' => esc_html__( 'Controls the overall width of the header, content area, and footer.', 'workstation' ),
		'section'     => 'workstation_layout',
		'type'        => 'range',
		'priority'    => 10,
		'input_attrs' => array(
			'min'  => 960,
			'max'  => 1440,
			'step' => 10,
		),
	) );

	$wp_customize->add_setting( 'workstation_content_width', array(
		'default'           => 760,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_content_width', array(
		'label'       => esc_html__( 'Single Content Width', 'workstation' ),
		'description' => esc_html__( 'Sets the reading width for single posts and pages.', 'workstation' ),
		'section'     => 'workstation_layout',
		'type'        => 'range',
		'priority'    => 20,
		'input_attrs' => array(
			'min'  => 640,
			'max'  => 920,
			'step' => 10,
		),
	) );

	$wp_customize->add_setting( 'workstation_sidebar_width', array(
		'default'           => 320,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_sidebar_width', array(
		'label'       => esc_html__( 'Sidebar Width', 'workstation' ),
		'description' => esc_html__( 'Controls the archive sidebar width on desktop.', 'workstation' ),
		'section'     => 'workstation_layout',
		'type'        => 'range',
		'priority'    => 30,
		'input_attrs' => array(
			'min'  => 260,
			'max'  => 400,
			'step' => 10,
		),
	) );

	$wp_customize->add_setting( 'workstation_card_radius', array(
		'default'           => 24,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_card_radius', array(
		'label'       => esc_html__( 'Card Corner Radius', 'workstation' ),
		'description' => esc_html__( 'Affects post cards, widgets, and panel corners.', 'workstation' ),
		'section'     => 'workstation_layout',
		'type'        => 'range',
		'priority'    => 40,
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 36,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_sticky_header', array(
		'default'           => 1,
		'sanitize_callback' => 'workstation_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_sticky_header', array(
		'label'       => esc_html__( 'Enable Sticky Header', 'workstation' ),
		'description' => esc_html__( 'Keeps the header visible while scrolling.', 'workstation' ),
		'section'     => 'workstation_layout',
		'type'        => 'checkbox',
		'priority'    => 50,
	) );

	$wp_customize->add_section( 'workstation_blog', array(
		'title'       => esc_html__( 'Blog Settings', 'workstation' ),
		'description' => esc_html__( 'Customize blog appearance and archive behavior.', 'workstation' ),
		'priority'    => 40,
	) );

	$wp_customize->add_setting( 'workstation_posts_per_page', array(
		'default'           => 10,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'workstation_posts_per_page', array(
		'label'       => esc_html__( 'Posts Per Page', 'workstation' ),
		'description' => esc_html__( 'Controls the number of posts on blog, archive, and search pages.', 'workstation' ),
		'section'     => 'workstation_blog',
		'type'        => 'number',
		'priority'    => 10,
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_excerpt_length', array(
		'default'           => 20,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'workstation_excerpt_length', array(
		'label'       => esc_html__( 'Excerpt Length', 'workstation' ),
		'description' => esc_html__( 'Set the excerpt length in words for archive cards.', 'workstation' ),
		'section'     => 'workstation_blog',
		'type'        => 'range',
		'priority'    => 20,
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 55,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_show_featured_image', array(
		'default'           => 1,
		'sanitize_callback' => 'workstation_sanitize_checkbox',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'workstation_show_featured_image', array(
		'label'       => esc_html__( 'Show Featured Images', 'workstation' ),
		'description' => esc_html__( 'Display featured images on archive cards.', 'workstation' ),
		'section'     => 'workstation_blog',
		'type'        => 'checkbox',
		'priority'    => 30,
	) );

	$wp_customize->add_section( 'workstation_typography', array(
		'title'       => esc_html__( 'Typography', 'workstation' ),
		'description' => esc_html__( 'Tune the readability of body copy and interface text.', 'workstation' ),
		'priority'    => 45,
	) );

	$wp_customize->add_setting( 'workstation_body_font_size', array(
		'default'           => 15,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_body_font_size', array(
		'label'       => esc_html__( 'Base Font Size', 'workstation' ),
		'description' => esc_html__( 'Adjust the base font size for body text.', 'workstation' ),
		'section'     => 'workstation_typography',
		'type'        => 'range',
		'priority'    => 10,
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 18,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_body_line_height', array(
		'default'           => 16,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_body_line_height', array(
		'label'       => esc_html__( 'Body Line Height', 'workstation' ),
		'description' => esc_html__( 'Higher values create more airy reading space.', 'workstation' ),
		'section'     => 'workstation_typography',
		'type'        => 'range',
		'priority'    => 20,
		'input_attrs' => array(
			'min'  => 15,
			'max'  => 20,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_heading_scale', array(
		'default'           => 100,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_heading_scale', array(
		'label'       => esc_html__( 'Heading Size Scale', 'workstation' ),
		'description' => esc_html__( 'Scales the global heading sizes from smaller to larger.', 'workstation' ),
		'section'     => 'workstation_typography',
		'type'        => 'range',
		'priority'    => 30,
		'input_attrs' => array(
			'min'  => 80,
			'max'  => 120,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_heading_line_height', array(
		'default'           => 115,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_heading_line_height', array(
		'label'       => esc_html__( 'Heading Line Height', 'workstation' ),
		'description' => esc_html__( 'Controls how tight or relaxed headings appear.', 'workstation' ),
		'section'     => 'workstation_typography',
		'type'        => 'range',
		'priority'    => 40,
		'input_attrs' => array(
			'min'  => 100,
			'max'  => 140,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_site_title_size', array(
		'default'           => 135,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_site_title_size', array(
		'label'       => esc_html__( 'Site Title Size', 'workstation' ),
		'description' => esc_html__( 'Adjusts the logo text size in the header.', 'workstation' ),
		'section'     => 'workstation_typography',
		'type'        => 'range',
		'priority'    => 50,
		'input_attrs' => array(
			'min'  => 100,
			'max'  => 180,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'workstation_post_title_size', array(
		'default'           => 185,
		'sanitize_callback' => 'absint',
		'validate_callback' => 'workstation_validate_integer',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'workstation_post_title_size', array(
		'label'       => esc_html__( 'Post Title Size', 'workstation' ),
		'description' => esc_html__( 'Controls the main post and card title sizing.', 'workstation' ),
		'section'     => 'workstation_typography',
		'type'        => 'range',
		'priority'    => 60,
		'input_attrs' => array(
			'min'  => 135,
			'max'  => 240,
			'step' => 1,
		),
	) );

	$wp_customize->add_section( 'workstation_footer', array(
		'title'       => esc_html__( 'Footer Settings', 'workstation' ),
		'description' => esc_html__( 'Customize footer content and messaging.', 'workstation' ),
		'priority'    => 50,
	) );

	$footer_default = '&copy; ' . get_bloginfo( 'name' ) . '. ' . esc_html__( 'All rights reserved.', 'workstation' );

	$wp_customize->add_setting(
		'workstation_footer_text',
		array(
			'default'           => $footer_default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control( 'workstation_footer_text', array(
		'label'       => esc_html__( 'Footer Copyright Text', 'workstation' ),
		'description' => esc_html__( 'HTML is allowed for links and formatting.', 'workstation' ),
		'section'     => 'workstation_footer',
		'type'        => 'textarea',
		'priority'    => 10,
	) );
}
add_action( 'customize_register', 'workstation_customize_register' );

/**
 * Output customizer CSS inline.
 */
function workstation_customize_css_output() {
	$primary_color        = workstation_sanitize_color( get_theme_mod( 'workstation_primary_color', '#0f766e' ) );
	$primary_strong_color = workstation_sanitize_color( get_theme_mod( 'workstation_primary_strong_color', '#115e59' ) );
	$accent_color         = workstation_sanitize_color( get_theme_mod( 'workstation_accent_color', '#f59e0b' ) );
	$heading_color        = workstation_sanitize_color( get_theme_mod( 'workstation_heading_color', '#0b1b2b' ) );
	$text_color           = workstation_sanitize_color( get_theme_mod( 'workstation_text_color', '#102033' ) );
	$surface_color        = workstation_sanitize_color( get_theme_mod( 'workstation_surface_color', '#ffffff' ) );
	$footer_bg_color      = workstation_sanitize_color( get_theme_mod( 'workstation_footer_bg_color', '#0f172a' ) );
	$site_width           = max( 960, min( 1440, absint( get_theme_mod( 'workstation_site_width', 1200 ) ) ) );
	$content_width        = max( 640, min( 920, absint( get_theme_mod( 'workstation_content_width', 760 ) ) ) );
	$sidebar_width        = max( 260, min( 400, absint( get_theme_mod( 'workstation_sidebar_width', 320 ) ) ) );
	$card_radius          = max( 12, min( 36, absint( get_theme_mod( 'workstation_card_radius', 24 ) ) ) );
	$body_font_size       = max( 14, min( 18, absint( get_theme_mod( 'workstation_body_font_size', 15 ) ) ) );
	$body_line_height     = max( 15, min( 20, absint( get_theme_mod( 'workstation_body_line_height', 16 ) ) ) ) / 10;
	$heading_scale        = max( 80, min( 120, absint( get_theme_mod( 'workstation_heading_scale', 100 ) ) ) ) / 100;
	$heading_line_height  = max( 100, min( 140, absint( get_theme_mod( 'workstation_heading_line_height', 115 ) ) ) ) / 100;
	$site_title_size      = max( 100, min( 180, absint( get_theme_mod( 'workstation_site_title_size', 135 ) ) ) ) / 100;
	$post_title_size      = max( 135, min( 240, absint( get_theme_mod( 'workstation_post_title_size', 185 ) ) ) ) / 100;
	$sticky_header        = (bool) get_theme_mod( 'workstation_sticky_header', 1 );

	$css  = ':root {';
	$css .= '--color-primary:' . esc_attr( $primary_color ) . ';';
	$css .= '--color-primary-strong:' . esc_attr( $primary_strong_color ) . ';';
	$css .= '--color-accent:' . esc_attr( $accent_color ) . ';';
	$css .= '--color-heading:' . esc_attr( $heading_color ) . ';';
	$css .= '--color-text:' . esc_attr( $text_color ) . ';';
	$css .= '--color-surface:' . esc_attr( $surface_color ) . ';';
	$css .= '--color-footer-bg:' . esc_attr( $footer_bg_color ) . ';';
	$css .= '--color-ring:' . esc_attr( $primary_color ) . ';';
	$css .= '--site-width:' . absint( $site_width ) . 'px;';
	$css .= '--content-width:' . absint( $content_width ) . 'px;';
	$css .= '--sidebar-width:' . absint( $sidebar_width ) . 'px;';
	$css .= '--radius-lg:' . absint( $card_radius ) . 'px;';
	$css .= '--heading-scale:' . esc_attr( $heading_scale ) . ';';
	$css .= '--heading-line-height:' . esc_attr( $heading_line_height ) . ';';
	$css .= '--site-title-size:' . esc_attr( $site_title_size ) . ';';
	$css .= '--post-title-size:' . esc_attr( $post_title_size ) . ';';
	$css .= '}';
	$css .= 'body{font-size:' . esc_attr( $body_font_size ) . 'px;line-height:' . esc_attr( $body_line_height ) . ';}';
	$css .= '.site-content{grid-template-columns:minmax(0,1fr) var(--sidebar-width);}';
	$css .= '.site-content.no-sidebar{grid-template-columns:minmax(0,var(--content-width));}';

	if ( ! $sticky_header ) {
		$css .= '.site-header{position:static;}';
	}

	wp_add_inline_style( 'workstation-style', $css );
}
add_action( 'wp_enqueue_scripts', 'workstation_customize_css_output', 20 );

/**
 * Enqueue customizer preview JS.
 */
function workstation_customize_preview_js() {
	wp_enqueue_script(
		'workstation-customize-preview',
		get_template_directory_uri() . '/assets/js/customize-preview.js',
		array( 'customize-preview', 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_preview_init', 'workstation_customize_preview_js' );
