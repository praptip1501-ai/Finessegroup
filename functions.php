<?php
/**
 * Workstation Theme - Functions
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/sanitizers.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/cpt-services.php';
require_once get_template_directory() . '/inc/cpt-projects.php';
require_once get_template_directory() . '/inc/finesse-menus.php';
require_once get_template_directory() . '/inc/finesse-customizer.php';

/**
 * Theme setup and initialization
 */
function workstation_setup() {
	load_theme_textdomain( 'workstation', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	
	// Custom header support
	add_theme_support( 'custom-header', array(
		'width'           => 1200,
		'height'          => 250,
		'flex-height'     => true,
		'flex-width'      => true,
		'header-text'     => false,
		'default-image'   => '',
	) );
	
	// Custom background support
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) );
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'workstation' ),
		'footer'  => esc_html__( 'Footer Menu', 'workstation' ),
	) );
}
add_action( 'after_setup_theme', 'workstation_setup' );

/**
 * Register theme sidebars/widget areas
 */
function workstation_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'workstation' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Main sidebar', 'workstation' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 1', 'workstation' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget area 1', 'workstation' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 2', 'workstation' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Footer widget area 2', 'workstation' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 3', 'workstation' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Footer widget area 3', 'workstation' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'workstation_widgets_init' );

/**
 * Add editor styles for better Block Editor experience
 */
function workstation_editor_styles() {
	add_editor_style( 'editor-style.css' );
}
add_action( 'after_setup_theme', 'workstation_editor_styles' );

/**
 * Enqueue scripts and styles for the theme
 */
function workstation_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Finesse Typography - Google Fonts
	wp_enqueue_style(
		'finesse-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600&family=Barlow+Condensed:wght@500;600&family=Montserrat:wght@300;400;500&display=swap',
		array(),
		null
	);

	// Finesse Global Design System & Layout
	wp_enqueue_style( 'finesse-base', get_template_directory_uri() . '/assets/css/finesse-base.css', array(), $theme_version, 'all' );
	wp_enqueue_style( 'finesse-header', get_template_directory_uri() . '/assets/css/finesse-header.css', array( 'finesse-base' ), filemtime( get_template_directory() . '/assets/css/finesse-header.css' ), 'all' );
	wp_enqueue_style( 'finesse-footer', get_template_directory_uri() . '/assets/css/finesse-footer.css', array( 'finesse-base' ), $theme_version, 'all' );
	wp_enqueue_script( 'finesse-header', get_template_directory_uri() . '/assets/js/finesse-header.js', array(), $theme_version, array( 'in_footer' => true, 'strategy' => 'defer' ) );

	// Finesse Front Page Section Specific Assets
	if ( is_front_page() ) {
		wp_enqueue_style( 'finesse-hero', get_template_directory_uri() . '/assets/css/finesse-hero.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-intro', get_template_directory_uri() . '/assets/css/finesse-intro.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-stats', get_template_directory_uri() . '/assets/css/finesse-stats.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-services', get_template_directory_uri() . '/assets/css/finesse-services.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-compare', get_template_directory_uri() . '/assets/css/finesse-compare.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-fullbleed', get_template_directory_uri() . '/assets/css/finesse-fullbleed.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-projects', get_template_directory_uri() . '/assets/css/finesse-projects.css', array( 'finesse-base' ), $theme_version, 'all' );
		wp_enqueue_style( 'finesse-contact', get_template_directory_uri() . '/assets/css/finesse-contact.css', array( 'finesse-base' ), $theme_version, 'all' );

		wp_enqueue_script( 'finesse-hero', get_template_directory_uri() . '/assets/js/finesse-hero.js', array(), $theme_version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
		wp_enqueue_script( 'finesse-explorer', get_template_directory_uri() . '/assets/js/finesse-explorer.js', array(), filemtime( get_template_directory() . '/assets/js/finesse-explorer.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
		wp_enqueue_script( 'finesse-compare', get_template_directory_uri() . '/assets/js/finesse-compare.js', array(), $theme_version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
		wp_enqueue_script( 'finesse-scroll', get_template_directory_uri() . '/assets/js/finesse-scroll.js', array(), $theme_version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}

	wp_enqueue_style( 'workstation-style', get_stylesheet_uri(), array( 'finesse-base' ), $theme_version, 'all' );
	wp_style_add_data( 'workstation-style', 'rtl', 'replace' );

	wp_enqueue_script( 'workstation-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), $theme_version, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_enqueue_script( 'workstation-main', get_template_directory_uri() . '/assets/js/main.js', array(), $theme_version, array( 'in_footer' => true, 'strategy' => 'defer' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script( 'workstation-navigation', 'workstationSettings', array(
		'menuClass'   => 'primary-menu',
		'toggleClass' => 'menu-toggle',
	) );
}
add_action( 'wp_enqueue_scripts', 'workstation_enqueue_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 */
function workstation_enqueue_block_editor_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'workstation-editor-style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all' );
}
add_action( 'enqueue_block_editor_assets', 'workstation_enqueue_block_editor_assets' );

/**
 * Register custom block styles
 */
function workstation_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'outline',
			'label' => __( 'Outline', 'workstation' ),
		)
	);
	
	register_block_style(
		'core/image',
		array(
			'name'  => 'border',
			'label' => __( 'Border', 'workstation' ),
		)
	);
}
add_action( 'init', 'workstation_register_block_styles' );

/**
 * Register custom block patterns
 */
function workstation_register_block_patterns() {
	register_block_pattern(
		'workstation/hero-section',
		array(
			'title'       => __( 'Hero Section', 'workstation' ),
			'description' => __( 'A large hero section with title and description', 'workstation' ),
			'content'     => '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="wp-block-group"><!-- wp:heading {"level":1} --><h1>' . __( 'Welcome to our site', 'workstation' ) . '</h1><!-- /wp:heading --><!-- wp:paragraph --><p>' . __( 'This is a hero section where you can add your main message.', 'workstation' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
			'categories'  => array( 'featured' ),
		)
	);
	
	register_block_pattern(
		'workstation/three-columns',
		array(
			'title'       => __( 'Three Columns', 'workstation' ),
			'description' => __( 'Three equal-width columns', 'workstation' ),
			'content'     => '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>' . __( 'Column one', 'workstation' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>' . __( 'Column two', 'workstation' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>' . __( 'Column three', 'workstation' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
			'categories'  => array( 'columns' ),
		)
	);
}
add_action( 'init', 'workstation_register_block_patterns' );

/**
 * Set content width for embeds and other content
 */
function workstation_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'workstation_content_width', 800 );
}
add_action( 'wp_head', 'workstation_content_width', 0 );

/**
 * Add custom classes to body tag
 */
function workstation_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'single';
	}

	if ( is_home() || is_archive() ) {
		$classes[] = 'blog';
	}

	if ( is_front_page() ) {
		$classes[] = 'front-page';
	}

	return $classes;
}
add_filter( 'body_class', 'workstation_body_classes' );

/**
 * Customize excerpt length
 */
function workstation_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return absint( get_theme_mod( 'workstation_excerpt_length', 20 ) );
}
add_filter( 'excerpt_length', 'workstation_excerpt_length' );

/**
 * Customize excerpt more text
 */
function workstation_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '&hellip;';
}
add_filter( 'excerpt_more', 'workstation_excerpt_more' );

/**
 * Apply Customizer posts per page to the main blog/archive query.
 */
function workstation_apply_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_home() || $query->is_archive() || $query->is_search() ) {
		$query->set( 'posts_per_page', absint( get_theme_mod( 'workstation_posts_per_page', 10 ) ) );
	}
}
add_action( 'pre_get_posts', 'workstation_apply_posts_per_page' );

/**
 * Custom comment form arguments
 */
function workstation_comment_form_args( $args ) {
	$args['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'workstation' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="' . esc_attr( apply_filters( 'comment_form_field_maxlength', 65525 ) ) . '" required></textarea></p>';

	$args['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>';

	return $args;
}
add_filter( 'comment_form_defaults', 'workstation_comment_form_args' );

/**
 * Ensure sidebar displays on single posts
 */
function workstation_template_include( $template ) {
	return $template;
}
add_filter( 'template_include', 'workstation_template_include' );

/**
 * Helper function to get customizer setting with default fallback
 */
function workstation_get_mod( $setting, $default = '' ) {
	return get_theme_mod( $setting, $default );
}

/**
 * Get accessible text for featured images.
 *
 * @param int $post_id Post ID.
 * @return string Alt text for the featured image.
 */
function workstation_get_featured_image_alt( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$title = get_the_title( $post_id );

	if ( ! $title ) {
		return esc_attr__( 'Featured image', 'workstation' );
	}

	return sprintf( esc_attr__( 'Featured image for %s', 'workstation' ), $title );
}

/**
 * Get accessible label for a linked featured image.
 *
 * @param int $post_id Post ID.
 * @return string Accessible label for the thumbnail link.
 */
function workstation_get_featured_image_link_label( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$title = get_the_title( $post_id );

	if ( ! $title ) {
		return esc_attr__( 'View post', 'workstation' );
	}

	return sprintf( esc_attr__( 'View featured image for %s', 'workstation' ), $title );
}

/**
 * Helper function to check if post has sidebar
 */
function workstation_has_sidebar() {
	return is_active_sidebar( 'sidebar-1' ) && ! is_single() && ! is_page();
}

/**
 * Outputs the published/updated date for archive cards.
 */
function workstation_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf(
		'<span class="posted-on">%s <a href="%s" rel="bookmark">%s</a></span>',
		esc_html__( 'Posted on', 'workstation' ),
		esc_url( get_the_permalink() ),
		$time_string
	);
}

/**
 * Outputs the published/updated date for single posts.
 */
function workstation_posted_on_single() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf(
		'<span class="posted-on">%s %s</span>',
		esc_html__( 'Published on', 'workstation' ),
		$time_string
	);
}
