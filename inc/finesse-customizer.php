<?php
/**
 * Finesse Theme Customizer Panels & Settings
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Finesse Customizer settings and controls
 */
function finesse_customize_register( $wp_customize ) {

	// Main Panel: Finesse Theme Settings
	$wp_customize->add_panel( 'finesse_panel', array(
		'title'       => esc_html__( 'Finesse Theme Settings', 'workstation' ),
		'description' => esc_html__( 'Configure all homepage sections, animations, and contact details.', 'workstation' ),
		'priority'    => 25,
	) );

	// 0. Header Navigation
	$wp_customize->add_section( 'finesse_header_section', array(
		'title'    => esc_html__( 'Header Navigation', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 5,
	) );

	$wp_customize->add_setting( 'finesse_header_btn_text', array(
		'default'           => esc_html__( 'Request a quote', 'workstation' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_header_btn_text', array(
		'label'   => esc_html__( 'Header Button Text', 'workstation' ),
		'section' => 'finesse_header_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_header_btn_url', array(
		'default'           => '#contact',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'finesse_header_btn_url', array(
		'label'   => esc_html__( 'Header Button Link', 'workstation' ),
		'section' => 'finesse_header_section',
		'type'    => 'text',
	) );

	// 1. Hero Section
	$wp_customize->add_section( 'finesse_hero_section', array(
		'title'    => esc_html__( 'Hero Section', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'finesse_hero_word', array(
		'default'           => 'FINESSE',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_hero_word', array(
		'label'       => esc_html__( 'Big Wordmark Title', 'workstation' ),
		'description' => esc_html__( 'Animated letter by letter upon scroll/view.', 'workstation' ),
		'section'     => 'finesse_hero_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'finesse_hero_sub', array(
		'default'           => 'GRIND & POLISH',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_hero_sub', array(
		'label'   => esc_html__( 'Subtitle', 'workstation' ),
		'section' => 'finesse_hero_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_hero_desc', array(
		'default'           => 'Concrete grinding, polishing and resin flooring for residential, commercial and industrial projects across Sydney.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_hero_desc', array(
		'label'   => esc_html__( 'Hero Description Text', 'workstation' ),
		'section' => 'finesse_hero_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_hero_video', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'finesse_hero_video', array(
		'label'       => esc_html__( 'Background Video (MP4)', 'workstation' ),
		'description' => esc_html__( 'Upload or provide direct URL to looping hero video.', 'workstation' ),
		'section'     => 'finesse_hero_section',
	) ) );

	// 2. About Intro Section
	$wp_customize->add_section( 'finesse_intro_section', array(
		'title'    => esc_html__( 'About / Intro Section', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'finesse_intro_text', array(
		'default'           => 'Finesse Grind & Polish is a Sydney-based concrete contractor with over 15 years of hands-on experience in the construction industry.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_intro_text', array(
		'label'       => esc_html__( 'Headline (Word-by-word reveal)', 'workstation' ),
		'section'     => 'finesse_intro_section',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_intro_desc', array(
		'default'           => 'Good work. No shortcuts. From residential homes to large commercial sites, our focus is on proper preparation, attention to detail and delivering a finish built to last.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_intro_desc', array(
		'label'   => esc_html__( 'Body Description', 'workstation' ),
		'section' => 'finesse_intro_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_intro_img1', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'finesse_intro_img1', array(
		'label'   => esc_html__( 'Mosaic Image 1 (Left tall)', 'workstation' ),
		'section' => 'finesse_intro_section',
	) ) );

	$wp_customize->add_setting( 'finesse_intro_img2', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'finesse_intro_img2', array(
		'label'   => esc_html__( 'Mosaic Image 2 (Right floating)', 'workstation' ),
		'section' => 'finesse_intro_section',
	) ) );

	// 3. Stats Strip Section
	$wp_customize->add_section( 'finesse_stats_section', array(
		'title'    => esc_html__( 'Stats Strip', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'finesse_stat1_num', array( 'default' => '15+', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'finesse_stat1_num', array( 'label' => esc_html__( 'Stat 1 Value', 'workstation' ), 'section' => 'finesse_stats_section' ) );
	$wp_customize->add_setting( 'finesse_stat1_text', array( 'default' => 'Years in the construction industry', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'finesse_stat1_text', array( 'label' => esc_html__( 'Stat 1 Label', 'workstation' ), 'section' => 'finesse_stats_section' ) );

	$wp_customize->add_setting( 'finesse_stat2_num', array( 'default' => '06', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'finesse_stat2_num', array( 'label' => esc_html__( 'Stat 2 Value', 'workstation' ), 'section' => 'finesse_stats_section' ) );
	$wp_customize->add_setting( 'finesse_stat2_text', array( 'default' => 'Specialist services', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'finesse_stat2_text', array( 'label' => esc_html__( 'Stat 2 Label', 'workstation' ), 'section' => 'finesse_stats_section' ) );

	$wp_customize->add_setting( 'finesse_stat3_num', array( 'default' => 'NSW', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'finesse_stat3_num', array( 'label' => esc_html__( 'Stat 3 Value', 'workstation' ), 'section' => 'finesse_stats_section' ) );
	$wp_customize->add_setting( 'finesse_stat3_text', array( 'default' => 'Residential & commercial across Sydney', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'finesse_stat3_text', array( 'label' => esc_html__( 'Stat 3 Label', 'workstation' ), 'section' => 'finesse_stats_section' ) );

	// 4. Services Index Section ("What we do")
	$wp_customize->add_section( 'finesse_services_section', array(
		'title'    => esc_html__( 'Services Index ("What we do")', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 32,
	) );

	$wp_customize->add_setting( 'finesse_sidx_lbl', array(
		'default'           => 'Services',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_sidx_lbl', array(
		'label'   => esc_html__( 'Section Eyebrow Label', 'workstation' ),
		'section' => 'finesse_services_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_sidx_title', array(
		'default'           => 'What we do',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_sidx_title', array(
		'label'   => esc_html__( 'Section Title', 'workstation' ),
		'section' => 'finesse_services_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_sidx_desc', array(
		'default'           => 'Six specialist concrete services. Select any service to see where it\'s used and exactly how we deliver it.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_sidx_desc', array(
		'label'   => esc_html__( 'Section Description', 'workstation' ),
		'section' => 'finesse_services_section',
		'type'    => 'textarea',
	) );

	// Services Items (Rows in "What we do")
	$default_services_config = array(
		1 => array(
			'num'  => '01',
			'name' => 'Mechanical Polished Concrete',
			'desc' => 'Durable, low-maintenance polished finishes for homes, retail, offices and commercial spaces.',
		),
		2 => array(
			'num'  => '02',
			'name' => 'Grind & Seal Concrete',
			'desc' => 'Natural concrete character under a durable protective sealer — a cost-effective finish.',
		),
		3 => array(
			'num'  => '03',
			'name' => 'Micro Cement',
			'desc' => 'Seamless, hand-applied finishes for floors, walls, bathrooms, fireplaces and feature surfaces.',
		),
		4 => array(
			'num'  => '04',
			'name' => 'Epoxy & Flake Flooring',
			'desc' => 'Hard-wearing, seamless systems for garages, workshops, commercial and industrial spaces.',
		),
		5 => array(
			'num'  => '05',
			'name' => 'Spray Resin',
			'desc' => 'Decorative resurfacing for driveways, paths, patios and outdoor areas.',
		),
		6 => array(
			'num'  => '06',
			'name' => 'Concrete Preparation Grinding',
			'desc' => 'Grinding away adhesives, membranes and coatings to prepare for new flooring.',
		),
		7 => array(
			'num'  => '07',
			'name' => '',
			'desc' => '',
		),
		8 => array(
			'num'  => '08',
			'name' => '',
			'desc' => '',
		),
	);

	foreach ( $default_services_config as $idx => $svc_conf ) {
		$label_suffix = $idx <= 6 ? " ({$svc_conf['num']})" : " ({$svc_conf['num']} - Optional)";

		$wp_customize->add_setting( "finesse_svc_{$idx}_name", array(
			'default'           => $svc_conf['name'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "finesse_svc_{$idx}_name", array(
			'label'       => sprintf( esc_html__( 'Service %s Title', 'workstation' ), $label_suffix ),
			'section'     => 'finesse_services_section',
			'type'        => 'text',
		) );

		$wp_customize->add_setting( "finesse_svc_{$idx}_desc", array(
			'default'           => $svc_conf['desc'],
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( "finesse_svc_{$idx}_desc", array(
			'label'       => sprintf( esc_html__( 'Service %s Subtitle / Description', 'workstation' ), $label_suffix ),
			'section'     => 'finesse_services_section',
			'type'        => 'textarea',
		) );
	}

	// 5. 3D Service Explorer & Process ("Explore each service")
	$wp_customize->add_section( 'finesse_explorer_section', array(
		'title'    => esc_html__( 'Service Explorer & Process', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 34,
	) );

	$wp_customize->add_setting( 'finesse_exp_lbl', array(
		'default'           => 'How we work',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_exp_lbl', array(
		'label'   => esc_html__( 'Section Eyebrow Label', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_exp_title', array(
		'default'           => 'Explore each service',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_exp_title', array(
		'label'   => esc_html__( 'Section Title', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_exp_desc', array(
		'default'           => 'Choose a service and step through our process — the slab changes with every stage. Drag it to turn it in the light.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_exp_desc', array(
		'label'   => esc_html__( 'Section Description', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_exp_drag_hint', array(
		'default'           => 'Drag to rotate · move to tilt',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_exp_drag_hint', array(
		'label'   => esc_html__( 'Slab Drag Hint Text', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_exp_turn_text', array(
		'default'           => 'Turn sample',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_exp_turn_text', array(
		'label'   => esc_html__( '"Turn Sample" Button Text', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_exp_best_label', array(
		'default'           => 'Best suited for',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_exp_best_label', array(
		'label'   => esc_html__( '"Best Suited For" Heading', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_exp_quote_text', array(
		'default'           => 'Request a quote',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_exp_quote_text', array(
		'label'   => esc_html__( 'Process Quote Button Text', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_exp_quote_url', array(
		'default'           => '#contact',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'finesse_exp_quote_url', array(
		'label'   => esc_html__( 'Process Quote Button Link', 'workstation' ),
		'section' => 'finesse_explorer_section',
		'type'    => 'text',
	) );

	// Individual Explorer Service Details (Services 01 - 06)
	$default_explorer_services = array(
		1 => array(
			'num'   => '01',
			'short' => 'Mechanical Polished Concrete',
			'tag'   => 'The slab becomes the floor',
			'word'  => 'POLISHED',
			'best'  => 'High-end homes, Retail, Showrooms, Offices, Restaurants, Warehouses',
			'desc'  => 'Concrete progressively ground, honed and polished — the finish is part of the slab, not a coating on top. Tailored by how much aggregate shows and how much it shines.',
		),
		2 => array(
			'num'   => '02',
			'short' => 'Grind & Seal Concrete',
			'tag'   => 'Natural character, clear sealed',
			'word'  => 'SEALED',
			'best'  => 'Homes, Garages, Retail, Cafés, Showrooms, Light commercial',
			'desc'  => 'Grinding reveals the natural character of the concrete, finished with a clear protective sealer — a cost-effective alternative to full mechanical polishing.',
		),
		3 => array(
			'num'   => '03',
			'short' => 'Micro Cement',
			'tag'   => 'Seamless, hand-applied',
			'word'  => 'MICRO',
			'best'  => 'Bathrooms, Floors, Feature walls, Fireplaces, Kitchens, Laundries',
			'desc'  => 'A decorative finish hand-applied in thin layers over floors, walls and existing surfaces — seamless, with natural movement, and no tiles or heavy demolition.',
		),
		4 => array(
			'num'   => '04',
			'short' => 'Epoxy & Flake Flooring',
			'tag'   => 'Seamless and hard-wearing',
			'word'  => 'EPOXY',
			'best'  => 'Garages, Workshops, Warehouses, Commercial kitchens, Showrooms, Plant rooms',
			'desc'  => 'Seamless, hard-wearing epoxy systems — from solid colours to full decorative flake under a clear protective topcoat — for demanding spaces.',
		),
		5 => array(
			'num'   => '05',
			'short' => 'Spray Resin',
			'tag'   => 'Outdoor resurfacing',
			'word'  => 'RESIN',
			'best'  => 'Driveways, Pathways, Patios, Pool surrounds, Entertaining areas, Entrances',
			'desc'  => 'Decorative resurfacing that renews existing outdoor concrete with a durable, customisable finish — without the cost of removal and replacement.',
		),
		6 => array(
			'num'   => '06',
			'short' => 'Concrete Preparation Grinding',
			'tag'   => 'The foundation of every floor',
			'word'  => 'PREP',
			'best'  => 'Commercial fit-outs, Warehouses, Retail, Industrial, New builds, Renovations',
			'desc'  => 'Mechanical grinding that removes adhesives, tile glue, membranes, coatings, paint and laitance — creating the profile your next flooring system needs.',
		),
	);

	foreach ( $default_explorer_services as $idx => $esvc ) {
		// Tab / Short Name
		$wp_customize->add_setting( "finesse_exp_svc_{$idx}_short", array(
			'default'           => $esvc['short'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "finesse_exp_svc_{$idx}_short", array(
			'label'       => sprintf( esc_html__( 'Service (%s) Tab Name', 'workstation' ), $esvc['num'] ),
			'section'     => 'finesse_explorer_section',
			'type'        => 'text',
		) );

		// Explorer Subtitle / Tagline
		$wp_customize->add_setting( "finesse_exp_svc_{$idx}_tag", array(
			'default'           => $esvc['tag'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "finesse_exp_svc_{$idx}_tag", array(
			'label'       => sprintf( esc_html__( 'Service (%s) Explorer Tagline / Subtitle', 'workstation' ), $esvc['num'] ),
			'section'     => 'finesse_explorer_section',
			'type'        => 'text',
		) );

		// 3D Background Ghost Word
		$wp_customize->add_setting( "finesse_exp_svc_{$idx}_word", array(
			'default'           => $esvc['word'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "finesse_exp_svc_{$idx}_word", array(
			'label'       => sprintf( esc_html__( 'Service (%s) 3D Background Wordmark', 'workstation' ), $esvc['num'] ),
			'section'     => 'finesse_explorer_section',
			'type'        => 'text',
		) );

		// Best Suited For Tags
		$wp_customize->add_setting( "finesse_exp_svc_{$idx}_best", array(
			'default'           => $esvc['best'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "finesse_exp_svc_{$idx}_best", array(
			'label'       => sprintf( esc_html__( 'Service (%s) "Best Suited For" Tags (comma-separated)', 'workstation' ), $esvc['num'] ),
			'section'     => 'finesse_explorer_section',
			'type'        => 'text',
		) );

		// Full Explorer Description
		$wp_customize->add_setting( "finesse_exp_svc_{$idx}_desc", array(
			'default'           => $esvc['desc'],
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( "finesse_exp_svc_{$idx}_desc", array(
			'label'       => sprintf( esc_html__( 'Service (%s) Full Description', 'workstation' ), $esvc['num'] ),
			'section'     => 'finesse_explorer_section',
			'type'        => 'textarea',
		) );
	}

	// 6. Before / After Concrete Grinding Slider ("Drag to grind")
	$wp_customize->add_section( 'finesse_compare_section', array(
		'title'    => esc_html__( 'Grind Comparison Slider', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 36,
	) );

	$wp_customize->add_setting( 'finesse_compare_lbl', array(
		'default'           => 'Concrete Preparation Grinding',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_compare_lbl', array(
		'label'   => esc_html__( 'Section Eyebrow Label', 'workstation' ),
		'section' => 'finesse_compare_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_compare_heading', array(
		'default'           => 'Drag to grind',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_compare_heading', array(
		'label'   => esc_html__( 'Section Heading', 'workstation' ),
		'section' => 'finesse_compare_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_compare_desc', array(
		'default'           => 'Adhesives, tile glue, membranes, paint and laitance. Pull the handle across to see proper preparation take a slab back to clean, sound concrete.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_compare_desc', array(
		'label'   => esc_html__( 'Section Description', 'workstation' ),
		'section' => 'finesse_compare_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_compare_pct_label', array(
		'default'           => 'prepared',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_compare_pct_label', array(
		'label'   => esc_html__( 'Percentage Metric Label', 'workstation' ),
		'section' => 'finesse_compare_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_compare_before_tag', array(
		'default'           => 'Before',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_compare_before_tag', array(
		'label'   => esc_html__( 'Before Badge Text', 'workstation' ),
		'section' => 'finesse_compare_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_compare_after_tag', array(
		'default'           => 'After',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_compare_after_tag', array(
		'label'   => esc_html__( 'After Badge Text', 'workstation' ),
		'section' => 'finesse_compare_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_compare_img_before', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'finesse_compare_img_before', array(
		'label'       => esc_html__( 'Before Image', 'workstation' ),
		'description' => esc_html__( 'Upload photo for the "Before" state (e.g. raw or glue-contaminated slab). If empty, procedural aggregate residue is generated.', 'workstation' ),
		'section'     => 'finesse_compare_section',
	) ) );

	$wp_customize->add_setting( 'finesse_compare_img_after', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'finesse_compare_img_after', array(
		'label'       => esc_html__( 'After Image', 'workstation' ),
		'description' => esc_html__( 'Upload photo for the "After" state (e.g. cleanly ground and polished concrete). If empty, procedural polished stone aggregate is generated.', 'workstation' ),
		'section'     => 'finesse_compare_section',
	) ) );

	// 7. Feature Section (Full-Bleed)
	$wp_customize->add_section( 'finesse_feature_section', array(
		'title'    => esc_html__( 'Full-Bleed Feature Section', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'finesse_feature_img', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'finesse_feature_img', array(
		'label'   => esc_html__( 'Full Bleed Background Image', 'workstation' ),
		'section' => 'finesse_feature_section',
	) ) );

	$wp_customize->add_setting( 'finesse_feature_title', array(
		'default'           => 'Good work. No shortcuts.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_feature_title', array(
		'label'   => esc_html__( 'Headline Title', 'workstation' ),
		'section' => 'finesse_feature_section',
	) );

	$wp_customize->add_setting( 'finesse_feature_tag', array(
		'default'           => 'Proper preparation · Attention to detail · Built to last',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_feature_tag', array(
		'label'   => esc_html__( 'Tagline / Slogan', 'workstation' ),
		'section' => 'finesse_feature_section',
	) );

	// 8. Recent Projects Section ("Selected work")
	$wp_customize->add_section( 'finesse_projects_section', array(
		'title'    => esc_html__( 'Selected Work / Projects Grid', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 45,
	) );

	$wp_customize->add_setting( 'finesse_proj_lbl', array(
		'default'           => 'Recent projects',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_proj_lbl', array(
		'label'   => esc_html__( 'Section Eyebrow Label', 'workstation' ),
		'section' => 'finesse_projects_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_proj_title', array(
		'default'           => 'Selected work',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_proj_title', array(
		'label'   => esc_html__( 'Section Title', 'workstation' ),
		'section' => 'finesse_projects_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_proj_desc', array(
		'default'           => 'Residential homes to large commercial sites across Sydney.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_proj_desc', array(
		'label'   => esc_html__( 'Section Description', 'workstation' ),
		'section' => 'finesse_projects_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_proj_btn_text', array(
		'default'           => 'View our work',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_proj_btn_text', array(
		'label'   => esc_html__( 'Bottom Button Text', 'workstation' ),
		'section' => 'finesse_projects_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'finesse_proj_btn_url', array(
		'default'           => 'https://www.instagram.com/finessegrindpolish/',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'finesse_proj_btn_url', array(
		'label'   => esc_html__( 'Bottom Button Link', 'workstation' ),
		'section' => 'finesse_projects_section',
		'type'    => 'text',
	) );

	// 9. Contact Section & CF7 Shortcode
	$wp_customize->add_section( 'finesse_contact_section', array(
		'title'    => esc_html__( 'Contact Form & Details', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'finesse_contact_phone', array(
		'default'           => '0490 389 447',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_contact_phone', array(
		'label'   => esc_html__( 'Phone Number', 'workstation' ),
		'section' => 'finesse_contact_section',
	) );

	$wp_customize->add_setting( 'finesse_contact_email', array(
		'default'           => 'daniel@finessegroup.au',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'finesse_contact_email', array(
		'label'   => esc_html__( 'Email Address', 'workstation' ),
		'section' => 'finesse_contact_section',
	) );

	$wp_customize->add_setting( 'finesse_contact_cf7_shortcode', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_contact_cf7_shortcode', array(
		'label'       => esc_html__( 'Contact Form 7 Shortcode', 'workstation' ),
		'description' => esc_html__( 'Paste your CF7 form shortcode here, e.g. [contact-form-7 id="123" title="Quote Form"]. If left empty, built-in enquiry form is displayed.', 'workstation' ),
		'section'     => 'finesse_contact_section',
	) );

	// 6. Footer Section
	$wp_customize->add_section( 'finesse_footer_section', array(
		'title'    => esc_html__( 'Footer Details', 'workstation' ),
		'panel'    => 'finesse_panel',
		'priority' => 60,
	) );

	$wp_customize->add_setting( 'finesse_footer_office', array(
		'default'           => "Marsden Park NSW 2765\nServicing Greater Sydney",
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_footer_office', array(
		'label'   => esc_html__( 'Office Location', 'workstation' ),
		'section' => 'finesse_footer_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_footer_hours', array(
		'default'           => "Mon – Fri 7:00 – 17:00\nSat 7:00 – 17:00",
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'finesse_footer_hours', array(
		'label'   => esc_html__( 'Business Hours', 'workstation' ),
		'section' => 'finesse_footer_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'finesse_footer_watermark', array(
		'default'           => 'FINESSE',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'finesse_footer_watermark', array(
		'label'       => esc_html__( 'Watermark Wordmark', 'workstation' ),
		'description' => esc_html__( 'Large ghost text spanning bottom of the page.', 'workstation' ),
		'section'     => 'finesse_footer_section',
	) );
}
add_action( 'customize_register', 'finesse_customize_register', 30 );

/**
 * Fix Customizer admin UI color visibility for back arrows, labels, and collapse sidebar
 */
function finesse_customize_controls_styles() {
	?>
	<style type="text/css">
		/* Back buttons & top panel navigation arrow & label */
		.wp-core-ui .customize-panel-back,
		.wp-core-ui .customize-section-back,
		.wp-core-ui .customize-panel-back:before,
		.wp-core-ui .customize-section-back:before,
		.wp-core-ui .control-panel-back,
		.wp-core-ui .control-panel-back:before,
		#customize-header-actions .customize-controls-close,
		#customize-header-actions .customize-controls-close:before {
			color: #1e1e1e !important;
		}
		.wp-core-ui .customize-panel-back:hover,
		.wp-core-ui .customize-panel-back:focus,
		.wp-core-ui .customize-section-back:hover,
		.wp-core-ui .customize-section-back:focus,
		.wp-core-ui .control-panel-back:hover,
		.wp-core-ui .control-panel-back:focus,
		#customize-header-actions .customize-controls-close:hover,
		#customize-header-actions .customize-controls-close:focus {
			color: #2271b1 !important;
		}
		.wp-core-ui .customize-panel-back:hover:before,
		.wp-core-ui .customize-panel-back:focus:before,
		.wp-core-ui .customize-section-back:hover:before,
		.wp-core-ui .customize-section-back:focus:before,
		.wp-core-ui .control-panel-back:hover:before,
		.wp-core-ui .control-panel-back:focus:before,
		#customize-header-actions .customize-controls-close:hover:before,
		#customize-header-actions .customize-controls-close:focus:before {
			color: #2271b1 !important;
		}

		/* Bottom collapse sidebar bar & buttons */
		#customize-footer-actions,
		.wp-core-ui #customize-footer-actions {
			background: #f0f0f1 !important;
			border-top: 1px solid #dcdcde !important;
		}
		#customize-footer-actions .collapse-sidebar,
		#customize-footer-actions .collapse-sidebar-label,
		#customize-footer-actions .collapse-sidebar-arrow,
		.wp-core-ui #customize-footer-actions .collapse-sidebar,
		.wp-core-ui #customize-footer-actions .collapse-sidebar-label,
		.wp-core-ui #customize-footer-actions .collapse-sidebar-arrow {
			color: #2c3338 !important;
		}
		#customize-footer-actions .collapse-sidebar:hover,
		#customize-footer-actions .collapse-sidebar:focus,
		.wp-core-ui #customize-footer-actions .collapse-sidebar:hover,
		.wp-core-ui #customize-footer-actions .collapse-sidebar:focus {
			color: #2271b1 !important;
		}
		#customize-footer-actions .devices button,
		.wp-core-ui #customize-footer-actions .devices button,
		.wp-full-overlay-footer .devices button {
			color: #2c3338 !important;
			display: inline-flex !important;
			align-items: center !important;
			justify-content: center !important;
			min-width: 44px !important;
			padding: 0 8px !important;
		}
		#customize-footer-actions .devices button:hover,
		#customize-footer-actions .devices button:focus,
		#customize-footer-actions .devices button.active,
		.wp-core-ui #customize-footer-actions .devices button:hover,
		.wp-core-ui #customize-footer-actions .devices button:focus,
		.wp-core-ui #customize-footer-actions .devices button.active {
			color: #2271b1 !important;
		}
		#customize-footer-actions .devices button:before,
		.wp-core-ui #customize-footer-actions .devices button:before,
		.wp-full-overlay-footer .devices button:before {
			margin: 0 !important;
			padding: 0 !important;
			line-height: 1 !important;
		}

		/* Hide Desktop, Tablet, and Mobile text labels and keep only icons */
		#customize-footer-actions .devices .devices__preview-label,
		.wp-core-ui #customize-footer-actions .devices .devices__preview-label,
		.wp-full-overlay-footer .devices .devices__preview-label {
			display: none !important;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'finesse_customize_controls_styles', 100 );
