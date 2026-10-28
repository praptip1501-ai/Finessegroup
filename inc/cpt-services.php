<?php
/**
 * Custom Post Type: Finesse Services
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Finesse Services CPT
 */
function finesse_register_services_cpt() {
	$labels = array(
		'name'               => esc_html__( 'Services', 'workstation' ),
		'singular_name'      => esc_html__( 'Service', 'workstation' ),
		'menu_name'          => esc_html__( 'Finesse Services', 'workstation' ),
		'name_admin_bar'     => esc_html__( 'Service', 'workstation' ),
		'add_new'            => esc_html__( 'Add New', 'workstation' ),
		'add_new_item'       => esc_html__( 'Add New Service', 'workstation' ),
		'new_item'           => esc_html__( 'New Service', 'workstation' ),
		'edit_item'          => esc_html__( 'Edit Service', 'workstation' ),
		'view_item'          => esc_html__( 'View Service', 'workstation' ),
		'all_items'          => esc_html__( 'All Services', 'workstation' ),
		'search_items'       => esc_html__( 'Search Services', 'workstation' ),
		'not_found'          => esc_html__( 'No services found.', 'workstation' ),
		'not_found_in_trash' => esc_html__( 'No services found in Trash.', 'workstation' ),
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
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-hammer',
		'supports'           => array( 'title', 'thumbnail' ),
		'show_in_rest'       => false,
	);

	register_post_type( 'finesse_service', $args );
}
add_action( 'init', 'finesse_register_services_cpt' );

/**
 * Register Meta Boxes for Services
 */
function finesse_service_add_meta_boxes() {
	add_meta_box(
		'finesse_service_details',
		esc_html__( 'Service Details & 3D Explorer Specs', 'workstation' ),
		'finesse_service_render_meta_box',
		'finesse_service',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'finesse_service_add_meta_boxes' );

/**
 * Render Service Meta Box
 */
function finesse_service_render_meta_box( $post ) {
	wp_nonce_field( 'finesse_service_meta_save', 'finesse_service_nonce' );

	$id_slug       = get_post_meta( $post->ID, '_service_id_slug', true );
	$short_name    = get_post_meta( $post->ID, '_service_short_name', true );
	$display_word  = get_post_meta( $post->ID, '_service_display_word', true );
	$tag           = get_post_meta( $post->ID, '_service_tag', true );
	$desc          = get_post_meta( $post->ID, '_service_description', true );
	$best_uses     = get_post_meta( $post->ID, '_service_best_uses', true );
	$base_color    = get_post_meta( $post->ID, '_service_base_color', true ) ?: '#958F85';
	$order         = get_post_meta( $post->ID, '_service_order', true ) ?: 1;

	$spec_1_key   = get_post_meta( $post->ID, '_service_spec_1_key', true );
	$spec_1_value = get_post_meta( $post->ID, '_service_spec_1_value', true );
	$spec_2_key   = get_post_meta( $post->ID, '_service_spec_2_key', true );
	$spec_2_value = get_post_meta( $post->ID, '_service_spec_2_value', true );
	$spec_3_key   = get_post_meta( $post->ID, '_service_spec_3_key', true );
	$spec_3_value = get_post_meta( $post->ID, '_service_spec_3_value', true );
	?>
	<style>
		.finesse-field-row { margin-bottom: 14px; }
		.finesse-field-row label { display: block; font-weight: 600; margin-bottom: 4px; }
		.finesse-field-row input[type="text"], .finesse-field-row input[type="number"], .finesse-field-row textarea, .finesse-field-row select { width: 100%; max-width: 600px; }
		.finesse-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 600px; }
		.finesse-step-card { background: #f9f9f9; border: 1px solid #e0e0e0; padding: 12px; margin-bottom: 12px; border-radius: 4px; }
		.finesse-step-title { font-size: 13px; font-weight: bold; text-transform: uppercase; margin-bottom: 8px; color: #333; }
	</style>

	<div class="finesse-field-row">
		<label for="_service_id_slug"><?php esc_html_e( 'Service Identifier / Slug', 'workstation' ); ?></label>
		<input type="text" id="_service_id_slug" name="_service_id_slug" value="<?php echo esc_attr( $id_slug ); ?>" placeholder="e.g. polished, seal, micro, epoxy, resin, prep" />
		<small><?php esc_html_e( 'Used as the internal key in the 3D explorer.', 'workstation' ); ?></small>
	</div>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label for="_service_short_name"><?php esc_html_e( 'Short Name (Tabs & Menu)', 'workstation' ); ?></label>
			<input type="text" id="_service_short_name" name="_service_short_name" value="<?php echo esc_attr( $short_name ); ?>" placeholder="e.g. Polished Concrete" />
		</div>
		<div class="finesse-field-row">
			<label for="_service_display_word"><?php esc_html_e( 'Display Word (3D Background)', 'workstation' ); ?></label>
			<input type="text" id="_service_display_word" name="_service_display_word" value="<?php echo esc_attr( $display_word ); ?>" placeholder="e.g. Polished" />
		</div>
	</div>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label for="_service_tag"><?php esc_html_e( 'Tagline', 'workstation' ); ?></label>
			<input type="text" id="_service_tag" name="_service_tag" value="<?php echo esc_attr( $tag ); ?>" placeholder="e.g. The slab becomes the floor" />
		</div>
		<div class="finesse-field-row">
			<label for="_service_base_color"><?php esc_html_e( 'Base Color (Hex)', 'workstation' ); ?></label>
			<input type="text" id="_service_base_color" name="_service_base_color" value="<?php echo esc_attr( $base_color ); ?>" placeholder="#958F85" />
		</div>
	</div>

	<div class="finesse-field-row">
		<label for="_service_order"><?php esc_html_e( 'Sort Order (1 to 6)', 'workstation' ); ?></label>
		<input type="number" id="_service_order" name="_service_order" value="<?php echo esc_attr( $order ); ?>" min="1" max="100" style="max-width: 100px;" />
	</div>

	<div class="finesse-field-row">
		<label for="_service_description"><?php esc_html_e( 'Full Description', 'workstation' ); ?></label>
		<textarea id="_service_description" name="_service_description" rows="3"><?php echo esc_textarea( $desc ); ?></textarea>
	</div>

	<div class="finesse-field-row">
		<label for="_service_best_uses"><?php esc_html_e( 'Best For / Applications (One per line)', 'workstation' ); ?></label>
		<textarea id="_service_best_uses" name="_service_best_uses" rows="4" placeholder="High-end homes&#10;Retail&#10;Showrooms&#10;Offices"><?php echo esc_textarea( $best_uses ); ?></textarea>
	</div>

	<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">
	<h4><?php esc_html_e( 'Specifications (Key/Value pairs for Explorer Info Panel)', 'workstation' ); ?></h4>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label><?php esc_html_e( 'Spec 1 Label', 'workstation' ); ?></label>
			<input type="text" name="_service_spec_1_key" value="<?php echo esc_attr( $spec_1_key ); ?>" placeholder="e.g. Maintenance" />
		</div>
		<div class="finesse-field-row">
			<label><?php esc_html_e( 'Spec 1 Value', 'workstation' ); ?></label>
			<textarea name="_service_spec_1_value" rows="2"><?php echo esc_textarea( $spec_1_value ); ?></textarea>
		</div>
	</div>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label><?php esc_html_e( 'Spec 2 Label', 'workstation' ); ?></label>
			<input type="text" name="_service_spec_2_key" value="<?php echo esc_attr( $spec_2_key ); ?>" placeholder="e.g. Durability" />
		</div>
		<div class="finesse-field-row">
			<label><?php esc_html_e( 'Spec 2 Value', 'workstation' ); ?></label>
			<textarea name="_service_spec_2_value" rows="2"><?php echo esc_textarea( $spec_2_value ); ?></textarea>
		</div>
	</div>

	<div class="finesse-grid-2">
		<div class="finesse-field-row">
			<label><?php esc_html_e( 'Spec 3 Label', 'workstation' ); ?></label>
			<input type="text" name="_service_spec_3_key" value="<?php echo esc_attr( $spec_3_key ); ?>" placeholder="e.g. Finish options" />
		</div>
		<div class="finesse-field-row">
			<label><?php esc_html_e( 'Spec 3 Value', 'workstation' ); ?></label>
			<textarea name="_service_spec_3_value" rows="2"><?php echo esc_textarea( $spec_3_value ); ?></textarea>
		</div>
	</div>

	<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">
	<h4><?php esc_html_e( '5 Process Steps (Stages of Concrete Transformation)', 'workstation' ); ?></h4>

	<?php
	$look_options = array(
		'raw'    => 'Raw Slab',
		'ground' => 'Mechanically Ground',
		'cream'  => 'Cream Polish (Agg)',
		'salt'   => 'Salt & Pepper (Agg)',
		'full'   => 'Full Exposure (Agg)',
		'solid'  => 'Solid Primer / Coat',
		'micro'  => 'Micro Cement Hand-Applied',
		'flake'  => 'Flake Broadcast',
		'resin'  => 'Spray Resin Texture',
	);

	for ( $s = 1; $s <= 5; $s++ ) :
		$step_title = get_post_meta( $post->ID, "_service_step_{$s}_title", true );
		$step_desc  = get_post_meta( $post->ID, "_service_step_{$s}_desc", true );
		$step_look  = get_post_meta( $post->ID, "_service_step_{$s}_look", true ) ?: 'raw';
		$step_sheen = get_post_meta( $post->ID, "_service_step_{$s}_sheen", true );
		if ( '' === $step_sheen ) {
			$step_sheen = '0';
		}
		$step_solid = get_post_meta( $post->ID, "_service_step_{$s}_solid_color", true );
		?>
		<div class="finesse-step-card">
			<div class="finesse-step-title"><?php printf( esc_html__( 'Step %d', 'workstation' ), $s ); ?></div>
			<div class="finesse-grid-2">
				<div class="finesse-field-row">
					<label><?php esc_html_e( 'Step Title', 'workstation' ); ?></label>
					<input type="text" name="_service_step_<?php echo $s; ?>_title" value="<?php echo esc_attr( $step_title ); ?>" />
				</div>
				<div class="finesse-field-row">
					<label><?php esc_html_e( 'Texture Look', 'workstation' ); ?></label>
					<select name="_service_step_<?php echo $s; ?>_look">
						<?php foreach ( $look_options as $val => $txt ) : ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $step_look, $val ); ?>><?php echo esc_html( $txt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="finesse-field-row">
				<label><?php esc_html_e( 'Step Description', 'workstation' ); ?></label>
				<textarea name="_service_step_<?php echo $s; ?>_desc" rows="2"><?php echo esc_textarea( $step_desc ); ?></textarea>
			</div>

			<div class="finesse-grid-2">
				<div class="finesse-field-row">
					<label><?php esc_html_e( 'Sheen Level (0.00 to 1.00)', 'workstation' ); ?></label>
					<input type="number" step="0.01" min="0" max="1" name="_service_step_<?php echo $s; ?>_sheen" value="<?php echo esc_attr( $step_sheen ); ?>" />
				</div>
				<div class="finesse-field-row">
					<label><?php esc_html_e( 'Solid Color (if Texture Look = Solid)', 'workstation' ); ?></label>
					<input type="text" name="_service_step_<?php echo $s; ?>_solid_color" value="<?php echo esc_attr( $step_solid ); ?>" placeholder="#9C978E" />
				</div>
			</div>
		</div>
	<?php endfor; ?>
	<?php
}

/**
 * Save Service Meta Box Data
 */
function finesse_service_save_meta( $post_id ) {
	if ( ! isset( $_POST['finesse_service_nonce'] ) || ! wp_verify_nonce( $_POST['finesse_service_nonce'], 'finesse_service_meta_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$single_text_fields = array(
		'_service_id_slug',
		'_service_short_name',
		'_service_display_word',
		'_service_tag',
		'_service_base_color',
		'_service_spec_1_key',
		'_service_spec_2_key',
		'_service_spec_3_key',
	);

	foreach ( $single_text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	if ( isset( $_POST['_service_order'] ) ) {
		update_post_meta( $post_id, '_service_order', intval( $_POST['_service_order'] ) );
	}

	$textarea_fields = array(
		'_service_description',
		'_service_best_uses',
		'_service_spec_1_value',
		'_service_spec_2_value',
		'_service_spec_3_value',
	);

	foreach ( $textarea_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	for ( $s = 1; $s <= 5; $s++ ) {
		if ( isset( $_POST["_service_step_{$s}_title"] ) ) {
			update_post_meta( $post_id, "_service_step_{$s}_title", sanitize_text_field( wp_unslash( $_POST["_service_step_{$s}_title"] ) ) );
		}
		if ( isset( $_POST["_service_step_{$s}_desc"] ) ) {
			update_post_meta( $post_id, "_service_step_{$s}_desc", sanitize_textarea_field( wp_unslash( $_POST["_service_step_{$s}_desc"] ) ) );
		}
		if ( isset( $_POST["_service_step_{$s}_look"] ) ) {
			update_post_meta( $post_id, "_service_step_{$s}_look", sanitize_text_field( wp_unslash( $_POST["_service_step_{$s}_look"] ) ) );
		}
		if ( isset( $_POST["_service_step_{$s}_sheen"] ) ) {
			update_post_meta( $post_id, "_service_step_{$s}_sheen", floatval( $_POST["_service_step_{$s}_sheen"] ) );
		}
		if ( isset( $_POST["_service_step_{$s}_solid_color"] ) ) {
			update_post_meta( $post_id, "_service_step_{$s}_solid_color", sanitize_text_field( wp_unslash( $_POST["_service_step_{$s}_solid_color"] ) ) );
		}
	}
}
add_action( 'save_post_finesse_service', 'finesse_service_save_meta' );

/**
 * Helper to get all services formatted for frontend Explorer JS
 */
function finesse_get_services_explorer_data() {
	$query = new WP_Query( array(
		'post_type'      => 'finesse_service',
		'posts_per_page' => 10,
		'orderby'        => 'meta_value_num',
		'meta_key'       => '_service_order',
		'order'          => 'ASC',
	) );

	if ( ! $query->have_posts() ) {
		return finesse_get_default_services_data();
	}

	$services = array();

	while ( $query->have_posts() ) {
		$query->the_post();
		$post_id = get_the_ID();

		$best_raw = get_post_meta( $post_id, '_service_best_uses', true );
		$best_arr = array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", '', $best_raw ) ) ) );

		$steps = array();
		for ( $s = 1; $s <= 5; $s++ ) {
			$title = get_post_meta( $post_id, "_service_step_{$s}_title", true );
			$desc  = get_post_meta( $post_id, "_service_step_{$s}_desc", true );
			$look  = get_post_meta( $post_id, "_service_step_{$s}_look", true ) ?: 'raw';
			$sheen = floatval( get_post_meta( $post_id, "_service_step_{$s}_sheen", true ) );
			$solid = get_post_meta( $post_id, "_service_step_{$s}_solid_color", true );

			$step_data = array(
				't'     => $title,
				'd'     => $desc,
				'look'  => $look,
				'sheen' => $sheen,
			);
			if ( 'solid' === $look && $solid ) {
				$step_data['solid'] = $solid;
			}
			$steps[] = $step_data;
		}

		$specs = array();
		for ( $k = 1; $k <= 3; $k++ ) {
			$lbl = get_post_meta( $post_id, "_service_spec_{$k}_key", true );
			$val = get_post_meta( $post_id, "_service_spec_{$k}_value", true );
			if ( $lbl && $val ) {
				$specs[] = array( 'k' => $lbl, 'v' => $val );
			}
		}

		$services[] = array(
			'id'    => get_post_meta( $post_id, '_service_id_slug', true ) ?: sanitize_title( get_the_title() ),
			'short' => get_post_meta( $post_id, '_service_short_name', true ) ?: get_the_title(),
			'word'  => get_post_meta( $post_id, '_service_display_word', true ) ?: get_the_title(),
			'tag'   => get_post_meta( $post_id, '_service_tag', true ),
			'name'  => get_the_title(),
			'desc'  => get_post_meta( $post_id, '_service_description', true ),
			'best'  => ! empty( $best_arr ) ? array_values( $best_arr ) : array(),
			'specs' => $specs,
			'base'  => get_post_meta( $post_id, '_service_base_color', true ) ?: '#958F85',
			'steps' => $steps,
		);
	}
	wp_reset_postdata();

	return $services;
}

/**
 * Fallback / default data matching the original Finesse HTML
 */
function finesse_get_default_services_data() {
	$services = array(
		array(
			'id'    => 'polished',
			'short' => 'Polished Concrete',
			'word'  => 'Polished',
			'tag'   => 'Durable, low-maintenance polished finishes for homes, retail, offices and commercial spaces.',
			'name'  => 'Mechanical Polished Concrete',
			'desc'  => 'Concrete progressively ground, honed and polished — the finish is part of the slab, not a coating on top. Tailored by how much aggregate shows and how much it shines.',
			'best'  => array( 'High-end homes', 'Retail', 'Showrooms', 'Offices', 'Restaurants', 'Warehouses' ),
			'specs' => array(
				array( 'k' => 'Maintenance', 'v' => 'Very low. Vacuum and damp-mop with a neutral cleaner — no sealer layer to replace.' ),
				array( 'k' => 'Durability', 'v' => 'Handles heavy foot traffic and can last for decades.' ),
				array( 'k' => 'Finish options', 'v' => 'Cream through to full aggregate; matte, satin or high gloss.' ),
			),
			'base'  => '#958F85',
			'steps' => array(
				array( 't' => 'Assess & prepare', 'd' => 'We inspect the slab, flag repairs or contaminants, and agree on aggregate exposure and finish.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Grind & flatten', 'd' => 'Industrial diamond tooling, in stages, exposes the aggregate and flattens the surface.', 'look' => 'ground', 'sheen' => 0.04 ),
				array( 't' => 'Refine', 'd' => 'Progressively finer diamond grits remove the scratches left by earlier passes.', 'look' => 'full', 'sheen' => 0.22 ),
				array( 't' => 'Densify & polish', 'd' => 'A densifier hardens the surface, then we polish to your chosen sheen.', 'look' => 'full', 'sheen' => 0.6 ),
				array( 't' => 'Protect & finish', 'd' => 'Final polishing passes and a protective treatment complete the floor.', 'look' => 'full', 'sheen' => 0.95 ),
			),
		),
		array(
			'id'    => 'seal',
			'short' => 'Grind & Seal',
			'word'  => 'Sealed',
			'tag'   => 'Natural concrete character under a durable protective sealer — a cost-effective finish.',
			'name'  => 'Grind & Seal Concrete',
			'desc'  => 'Grinding reveals the natural character of the concrete, finished with a clear protective sealer — a cost-effective alternative to full mechanical polishing.',
			'best'  => array( 'Homes', 'Garages', 'Retail', 'Cafés', 'Showrooms', 'Light commercial' ),
			'specs' => array(
				array( 'k' => 'Maintenance', 'v' => 'Vacuum and mop. The sealer resists stains and can be recoated over time.' ),
				array( 'k' => 'Durability', 'v' => 'Durable with the right sealer — and refreshable without replacing the floor.' ),
				array( 'k' => 'Finish options', 'v' => 'Light grind to full exposure; matte, satin or gloss sealer.' ),
			),
			'base'  => '#A19B91',
			'steps' => array(
				array( 't' => 'Assess & prepare', 'd' => 'We inspect the concrete, identify repairs and agree on exposure level and appearance.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Grind', 'd' => 'Industrial diamond tooling removes the surface layer to reveal the aggregate.', 'look' => 'ground', 'sheen' => 0.04 ),
				array( 't' => 'Refine & repair', 'd' => 'Heavy grind marks are refined out; cracks, holes and imperfections repaired.', 'look' => 'salt', 'sheen' => 0.08 ),
				array( 't' => 'Clean & prepare', 'd' => 'A thorough clean so the sealer bonds properly and finishes evenly.', 'look' => 'salt', 'sheen' => 0.12 ),
				array( 't' => 'Seal & protect', 'd' => 'A protective sealer in matte, satin or gloss guards against stains and wear.', 'look' => 'salt', 'sheen' => 0.55 ),
			),
		),
		array(
			'id'    => 'micro',
			'short' => 'Micro Cement',
			'word'  => 'Micro',
			'tag'   => 'Seamless, hand-applied finishes for floors, walls, bathrooms, fireplaces and feature surfaces.',
			'name'  => 'Micro Cement',
			'desc'  => 'A decorative finish hand-applied in thin layers over floors, walls and existing surfaces — seamless, with natural movement, and no tiles or heavy demolition.',
			'best'  => array( 'Bathrooms', 'Floors', 'Feature walls', 'Fireplaces', 'Kitchens', 'Laundries' ),
			'specs' => array(
				array( 'k' => 'Maintenance', 'v' => 'Mild cleaning products; a high-performance sealer guards against stains and moisture.' ),
				array( 'k' => 'Durability', 'v' => 'Strong for daily residential and commercial use over a properly prepared substrate.' ),
				array( 'k' => 'Finish options', 'v' => 'A wide range of colours and textures, from soft concrete looks to pronounced trowel marks.' ),
			),
			'base'  => '#C2B9AB',
			'steps' => array(
				array( 't' => 'Assess & prepare', 'd' => 'We inspect the substrate, confirm it is suitable and complete any repairs.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Prime & reinforce', 'd' => 'Primer and reinforcement create a stable base for the system.', 'look' => 'solid', 'solid' => '#9C978E', 'sheen' => 0.05 ),
				array( 't' => 'Base coats', 'd' => 'Hand-applied base coats build strength and level the surface.', 'look' => 'solid', 'solid' => '#B3AA9C', 'sheen' => 0.05 ),
				array( 't' => 'Finish coats', 'd' => 'Fine finish coats are hand-trowelled for colour, texture and movement.', 'look' => 'micro', 'sheen' => 0.12 ),
				array( 't' => 'Seal & protect', 'd' => 'A high-performance sealer resists moisture, stains and wear.', 'look' => 'micro', 'sheen' => 0.38 ),
			),
		),
		array(
			'id'    => 'epoxy',
			'short' => 'Epoxy & Flake',
			'word'  => 'Epoxy',
			'tag'   => 'Hard-wearing, seamless systems for garages, workshops, commercial and industrial spaces.',
			'name'  => 'Epoxy & Flake Flooring',
			'desc'  => 'Seamless, hard-wearing epoxy systems — from solid colours to full decorative flake under a clear protective topcoat — for demanding spaces.',
			'best'  => array( 'Garages', 'Workshops', 'Warehouses', 'Commercial kitchens', 'Showrooms', 'Plant rooms' ),
			'specs' => array(
				array( 'k' => 'Maintenance', 'v' => 'Few gaps for dirt to collect — sweep, vacuum, mop or wash.' ),
				array( 'k' => 'Durability', 'v' => 'Resists abrasion, impact, staining and wear; specified from home garage to industrial.' ),
				array( 'k' => 'Finish options', 'v' => 'Solid colours or decorative flake blends, with slip-resistance to suit.' ),
			),
			'base'  => '#6F6C68',
			'steps' => array(
				array( 't' => 'Assess & prepare', 'd' => 'We check for coatings, contamination and cracks, and choose the right system.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Mechanically grind', 'd' => 'Diamond grinding removes contaminants and profiles the slab so the coating bonds.', 'look' => 'ground', 'sheen' => 0.04 ),
				array( 't' => 'Repair & prime', 'd' => 'Cracks and holes are filled, then primed for a consistent base.', 'look' => 'solid', 'solid' => '#8E8A84', 'sheen' => 0.2 ),
				array( 't' => 'Apply epoxy & flake', 'd' => 'The epoxy base coat goes down and decorative flake is broadcast evenly.', 'look' => 'flake', 'sheen' => 0.25 ),
				array( 't' => 'Seal & protect', 'd' => 'Excess flake removed, then a protective topcoat with the right slip resistance.', 'look' => 'flake', 'sheen' => 0.7 ),
			),
		),
		array(
			'id'    => 'resin',
			'short' => 'Spray Resin',
			'word'  => 'Resin',
			'tag'   => 'Decorative resurfacing for driveways, paths, patios and outdoor areas.',
			'name'  => 'Spray Resin',
			'desc'  => 'Decorative resurfacing that renews existing outdoor concrete with a durable, customisable finish — without the cost of removal and replacement.',
			'best'  => array( 'Driveways', 'Pathways', 'Patios', 'Pool surrounds', 'Entertaining areas', 'Entrances' ),
			'specs' => array(
				array( 'k' => 'Maintenance', 'v' => 'Sweep and occasionally pressure wash. It can be refreshed down the track.' ),
				array( 'k' => 'Durability', 'v' => 'Built for harsh outdoor conditions, foot and vehicle traffic.' ),
				array( 'k' => 'Finish options', 'v' => 'Colours, stencil patterns and multi-colour designs; slip-resistant options.' ),
			),
			'base'  => '#BCA888',
			'steps' => array(
				array( 't' => 'Assess & prepare', 'd' => 'We inspect for cracks, damage, contamination and previous coatings.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Mechanically prepare', 'd' => 'The surface is cleaned and mechanically prepared to a sound base.', 'look' => 'ground', 'sheen' => 0.03 ),
				array( 't' => 'Repair & base coat', 'd' => 'Cracks and defects are repaired, then the base system is applied.', 'look' => 'solid', 'solid' => '#B4A386', 'sheen' => 0.05 ),
				array( 't' => 'Apply decorative finish', 'd' => 'Your colour, pattern and texture go on — including custom designs.', 'look' => 'resin', 'sheen' => 0.06 ),
				array( 't' => 'Seal & protect', 'd' => 'Sealed for stain and weather resistance, with slip resistance where needed.', 'look' => 'resin', 'sheen' => 0.28 ),
			),
		),
		array(
			'id'    => 'prep',
			'short' => 'Prep Grinding',
			'word'  => 'Prep',
			'tag'   => 'Grinding away adhesives, membranes and coatings to prepare for new flooring.',
			'name'  => 'Concrete Preparation Grinding',
			'desc'  => 'Mechanical grinding that removes adhesives, tile glue, membranes, coatings, paint and laitance — creating the profile your next flooring system needs.',
			'best'  => array( 'Commercial fit-outs', 'Warehouses', 'Retail', 'Industrial', 'New builds', 'Renovations' ),
			'specs' => array(
				array( 'k' => 'Dust control', 'v' => 'Grinders paired with H-class/HEPA extraction for a cleaner, safer site.' ),
				array( 'k' => 'Equipment', 'v' => 'Compact grinders for tight access through to remote-control machines for large floors.' ),
				array( 'k' => 'The result', 'v' => 'A clean substrate ready for epoxy, waterproofing, levelling, tiles, vinyl or coatings.' ),
			),
			'base'  => '#A39E95',
			'steps' => array(
				array( 't' => 'Assess the substrate', 'd' => 'We identify coatings, adhesives, membranes and defects, and set the preparation level.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Select tooling', 'd' => 'Diamond tooling and machinery are matched to the substrate and target profile.', 'look' => 'raw', 'sheen' => 0 ),
				array( 't' => 'Mechanically grind', 'd' => 'Coatings, adhesives, membranes and laitance are removed to a consistent profile.', 'look' => 'ground', 'sheen' => 0.03 ),
				array( 't' => 'Detail & edge work', 'd' => 'Edges, corners and tight areas are prepared with specialised equipment.', 'look' => 'ground', 'sheen' => 0.04 ),
				array( 't' => 'Clean & ready', 'd' => 'Vacuumed with H-class/HEPA extraction, ready for the next system.', 'look' => 'ground', 'sheen' => 0.1 ),
			),
		),
	);

	// Apply Customizer overrides for Services 1-6 from "Services Index ("What we do")"
	for ( $i = 1; $i <= 6; $i++ ) {
		$idx = $i - 1;
		$name_mod = get_theme_mod( "finesse_svc_{$i}_name" );
		if ( ! empty( $name_mod ) ) {
			$services[ $idx ]['name']  = $name_mod;
			$services[ $idx ]['short'] = $name_mod;
		}
		$desc_mod = get_theme_mod( "finesse_svc_{$i}_desc" );
		if ( ! empty( $desc_mod ) ) {
			$services[ $idx ]['tag']  = $desc_mod;
			$services[ $idx ]['desc'] = $desc_mod;
		}
	}

	// Apply Explorer Customizer overrides for Services 1-6 from "Service Explorer & Process"
	for ( $i = 1; $i <= 6; $i++ ) {
		$idx = $i - 1;
		$exp_short = get_theme_mod( "finesse_exp_svc_{$i}_short" );
		if ( ! empty( $exp_short ) ) {
			$services[ $idx ]['short'] = $exp_short;
		}
		$exp_tag = get_theme_mod( "finesse_exp_svc_{$i}_tag" );
		if ( ! empty( $exp_tag ) ) {
			$services[ $idx ]['tag'] = $exp_tag;
		}
		$exp_word = get_theme_mod( "finesse_exp_svc_{$i}_word" );
		if ( ! empty( $exp_word ) ) {
			$services[ $idx ]['word'] = $exp_word;
		}
		$exp_best = get_theme_mod( "finesse_exp_svc_{$i}_best" );
		if ( ! empty( $exp_best ) ) {
			$tags = array_filter( array_map( 'trim', explode( ',', $exp_best ) ) );
			if ( ! empty( $tags ) ) {
				$services[ $idx ]['best'] = array_values( $tags );
			}
		}
		$exp_desc = get_theme_mod( "finesse_exp_svc_{$i}_desc" );
		if ( ! empty( $exp_desc ) ) {
			$services[ $idx ]['desc'] = $exp_desc;
		}
	}

	// Support adding extra services dynamically from Customizer (e.g. 7 and 8)
	for ( $i = 7; $i <= 8; $i++ ) {
		$name_mod = get_theme_mod( "finesse_svc_{$i}_name" );
		if ( ! empty( $name_mod ) ) {
			$desc_mod = get_theme_mod( "finesse_svc_{$i}_desc", '' );
			$services[] = array(
				'id'    => 'custom-' . $i,
				'short' => $name_mod,
				'word'  => $name_mod,
				'name'  => $name_mod,
				'tag'   => $desc_mod,
				'desc'  => $desc_mod,
				'best'  => array(),
				'specs' => array(),
				'base'  => '#958F85',
				'steps' => array(),
			);
		}
	}

	return $services;
}
