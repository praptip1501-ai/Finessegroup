<?php
/**
 * Custom Post Type: Finesse Projects
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Finesse Projects CPT
 */
function finesse_register_projects_cpt() {
	$labels = array(
		'name'               => esc_html__( 'Projects', 'workstation' ),
		'singular_name'      => esc_html__( 'Project', 'workstation' ),
		'menu_name'          => esc_html__( 'Finesse Projects', 'workstation' ),
		'name_admin_bar'     => esc_html__( 'Project', 'workstation' ),
		'add_new'            => esc_html__( 'Add New', 'workstation' ),
		'add_new_item'       => esc_html__( 'Add New Project', 'workstation' ),
		'new_item'           => esc_html__( 'New Project', 'workstation' ),
		'edit_item'          => esc_html__( 'Edit Project', 'workstation' ),
		'view_item'          => esc_html__( 'View Project', 'workstation' ),
		'all_items'          => esc_html__( 'All Projects', 'workstation' ),
		'search_items'       => esc_html__( 'Search Projects', 'workstation' ),
		'not_found'          => esc_html__( 'No projects found.', 'workstation' ),
		'not_found_in_trash' => esc_html__( 'No projects found in Trash.', 'workstation' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'thumbnail' ),
		'show_in_rest'       => false,
	);

	register_post_type( 'finesse_project', $args );
}
add_action( 'init', 'finesse_register_projects_cpt' );

/**
 * Register Meta Box for Project Details
 */
function finesse_project_add_meta_boxes() {
	add_meta_box(
		'finesse_project_details',
		esc_html__( 'Project Meta Information', 'workstation' ),
		'finesse_project_render_meta_box',
		'finesse_project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'finesse_project_add_meta_boxes' );

/**
 * Render Project Meta Box
 */
function finesse_project_render_meta_box( $post ) {
	wp_nonce_field( 'finesse_project_meta_save', 'finesse_project_nonce' );

	$category     = get_post_meta( $post->ID, '_project_category', true );
	$location     = get_post_meta( $post->ID, '_project_location', true );
	$service_type = get_post_meta( $post->ID, '_project_service_type', true );
	$year         = get_post_meta( $post->ID, '_project_year', true );
	$description  = get_post_meta( $post->ID, '_project_description', true );
	?>
	<style>
		.finesse-field-row { margin-bottom: 14px; }
		.finesse-field-row label { display: block; font-weight: 600; margin-bottom: 4px; }
		.finesse-field-row input[type="text"], .finesse-field-row textarea { width: 100%; max-width: 600px; }
		.finesse-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 600px; }
	</style>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label for="_project_category"><?php esc_html_e( 'Category / Tag', 'workstation' ); ?></label>
			<input type="text" id="_project_category" name="_project_category" value="<?php echo esc_attr( $category ); ?>" placeholder="e.g. Commercial, Residential" />
		</div>
		<div class="finesse-field-row">
			<label for="_project_location"><?php esc_html_e( 'Location', 'workstation' ); ?></label>
			<input type="text" id="_project_location" name="_project_location" value="<?php echo esc_attr( $location ); ?>" placeholder="e.g. Sydney CBD" />
		</div>
	</div>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label for="_project_service_type"><?php esc_html_e( 'Service Type', 'workstation' ); ?></label>
			<input type="text" id="_project_service_type" name="_project_service_type" value="<?php echo esc_attr( $service_type ); ?>" placeholder="e.g. Polished Concrete" />
		</div>
		<div class="finesse-field-row">
			<label for="_project_year"><?php esc_html_e( 'Year Completed', 'workstation' ); ?></label>
			<input type="text" id="_project_year" name="_project_year" value="<?php echo esc_attr( $year ); ?>" placeholder="2024" />
		</div>
	</div>

	<div class="finesse-field-row">
		<label for="_project_description"><?php esc_html_e( 'Short Description', 'workstation' ); ?></label>
		<textarea id="_project_description" name="_project_description" rows="3" placeholder="Brief project summary"><?php echo esc_textarea( $description ); ?></textarea>
	</div>
	<p><small><?php esc_html_e( 'Note: Use the "Featured Image" box in the sidebar to set the project cover photo.', 'workstation' ); ?></small></p>
	<?php
}

/**
 * Save Project Meta Data
 */
function finesse_project_save_meta( $post_id ) {
	if ( ! isset( $_POST['finesse_project_nonce'] ) || ! wp_verify_nonce( $_POST['finesse_project_nonce'], 'finesse_project_meta_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'_project_category',
		'_project_location',
		'_project_service_type',
		'_project_year',
	);

	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	if ( isset( $_POST['_project_description'] ) ) {
		update_post_meta( $post_id, '_project_description', sanitize_textarea_field( wp_unslash( $_POST['_project_description'] ) ) );
	}
}
add_action( 'save_post_finesse_project', 'finesse_project_save_meta' );

/**
 * Get projects for frontend display with fallback defaults
 */
function finesse_get_projects_data( $limit = 3 ) {
	$query = new WP_Query( array(
		'post_type'      => 'finesse_project',
		'posts_per_page' => $limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	if ( ! $query->have_posts() ) {
		$img_a = file_exists( get_theme_file_path( 'assets/images/still-a.jpg' ) ) ? get_theme_file_uri( 'assets/images/still-a.jpg' ) : '';
		$img_b = file_exists( get_theme_file_path( 'assets/images/bathroom.jpg' ) ) ? get_theme_file_uri( 'assets/images/bathroom.jpg' ) : '';
		$img_c = file_exists( get_theme_file_path( 'assets/images/still-b.jpg' ) ) ? get_theme_file_uri( 'assets/images/still-b.jpg' ) : '';

		return array(
			array(
				'title'    => 'Warehouse to Showroom Conversion',
				'category' => 'Commercial',
				'location' => 'Sydney CBD',
				'service'  => 'Polished Concrete',
				'image'    => $img_a,
			),
			array(
				'title'    => 'Minimalist Coastal Residence',
				'category' => 'Residential',
				'location' => 'Palm Beach',
				'service'  => 'Micro Cement Floors & Bathrooms',
				'image'    => $img_b,
			),
			array(
				'title'    => 'Automotive Workshop & Showroom',
				'category' => 'Industrial',
				'location' => 'Alexandria',
				'service'  => 'Epoxy & Flake Flooring',
				'image'    => $img_c,
			),
		);
	}

	$projects = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_id = get_the_ID();
		$img_url = get_the_post_thumbnail_url( $post_id, 'large' );

		$projects[] = array(
			'title'    => get_the_title(),
			'category' => get_post_meta( $post_id, '_project_category', true ) ?: 'Commercial',
			'location' => get_post_meta( $post_id, '_project_location', true ),
			'service'  => get_post_meta( $post_id, '_project_service_type', true ),
			'image'    => $img_url ?: '',
		);
	}
	wp_reset_postdata();

	return $projects;
}
