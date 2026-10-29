<?php
/**
 * Single Service Template
 *
 * Dedicated template for Finesse Services (finesse_service CPT)
 * Styled matching the live site (https://www.finessegroup.au/concrete-preparation-grinding)
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_id      = get_the_ID();
	$id_slug      = get_post_meta( $post_id, '_service_id_slug', true ) ?: sanitize_title( get_the_title() );
	$tag          = get_post_meta( $post_id, '_service_tag', true );
	$desc         = get_post_meta( $post_id, '_service_description', true );
	$best_raw     = get_post_meta( $post_id, '_service_best_uses', true );

	// Fallback to live defaults if not set
	if ( empty( $desc ) ) {
		$desc = "A mechanically polished concrete floor is created by progressively grinding, honing and polishing the concrete itself to produce a smooth, refined and highly durable finish. Different levels of aggregate exposure and sheen can be achieved depending on the desired look.";
	}
	if ( empty( $best_raw ) ) {
		$best_raw = "High-end homes, retail spaces, showrooms, offices, restaurants, warehouses and other areas where appearance and long-term durability are equally important.";
	}

	$spec_1_key   = get_post_meta( $post_id, '_service_spec_1_key', true ) ?: 'Maintenance';
	$spec_1_val   = get_post_meta( $post_id, '_service_spec_1_value', true ) ?: "Very low maintenance. Routine vacuuming and damp mopping with a suitable neutral cleaner is generally all that's required. Unlike topical coatings, there is no sealer layer that needs regular replacement.";

	$spec_2_key   = get_post_meta( $post_id, '_service_spec_2_key', true ) ?: 'Durability';
	$spec_2_val   = get_post_meta( $post_id, '_service_spec_2_value', true ) ?: "Exceptional. Because the finish is created within the concrete rather than applied as a surface coating, mechanically polished concrete handles heavy foot traffic extremely well and can provide decades of service when correctly installed and maintained.";

	$spec_3_key   = get_post_meta( $post_id, '_service_spec_3_key', true ) ?: 'Finish Options';
	$spec_3_val   = get_post_meta( $post_id, '_service_spec_3_value', true ) ?: "Available in different levels of aggregate exposure—from minimal/cream exposure through to full aggregate—as well as matte, satin and higher-gloss finishes.";

	// Process steps
	$steps = array();
	for ( $s = 1; $s <= 5; $s++ ) {
		$title = get_post_meta( $post_id, "_service_step_{$s}_title", true );
		$sdesc = get_post_meta( $post_id, "_service_step_{$s}_desc", true );
		if ( $title && $sdesc ) {
			$steps[] = array(
				'step'  => sprintf( '%02d', $s ),
				'title' => $title,
				'desc'  => $sdesc,
			);
		}
	}

	// Default steps fallback for Polished Concrete
	if ( empty( $steps ) ) {
		$steps = array(
			array(
				'step'  => '01',
				'title' => 'Assess & Prepare',
				'desc'  => 'We inspect the concrete, identify any repairs or existing contaminants and determine the required level of aggregate exposure and finish.',
			),
			array(
				'step'  => '02',
				'title' => 'Grind & Flatten',
				'desc'  => 'The concrete is progressively ground using industrial diamond tooling to expose the desired amount of aggregate and create a consistent surface.',
			),
			array(
				'step'  => '03',
				'title' => 'Refine',
				'desc'  => 'A series of progressively finer diamond grits removes scratches from the previous grinding stages and begins refining the concrete.',
			),
			array(
				'step'  => '04',
				'title' => 'Densify & Polish',
				'desc'  => 'A concrete densifier is applied to strengthen and harden the surface before progressively polishing to the selected finish and sheen.',
			),
			array(
				'step'  => '05',
				'title' => 'Protect & Finish',
				'desc'  => 'The floor receives its final polishing passes and protective treatment, leaving a durable, low-maintenance surface ready for use.',
			),
		);
	}

	// Featured image fallback
	$image_url = '';
	if ( has_post_thumbnail() ) {
		$image_url = get_the_post_thumbnail_url( $post_id, 'full' );
	} else {
		$fallback_img = get_template_directory() . '/assets/images/IMG_1117.png';
		if ( file_exists( $fallback_img ) ) {
			$image_url = get_template_directory_uri() . '/assets/images/IMG_1117.png';
		}
	}
	?>

	<style>
		/* Finesse Live Single Service Page Styles */
		.finesse-service-body {
			background: #fbfbfb;
			color: #1a1a1a;
			font-family: var(--fin-font-main, 'Barlow', system-ui, sans-serif);
			padding-top: 100px;
		}

		.finesse-service-container {
			max-width: 1320px;
			margin: 0 auto;
			padding: 0 32px;
		}

		/* Breadcrumbs */
		.finesse-crumb-nav {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 13px;
			letter-spacing: .04em;
			text-transform: uppercase;
			color: #777;
			margin-bottom: 36px;
			padding-top: 16px;
		}
		.finesse-crumb-nav a {
			color: #555;
			text-decoration: none;
			transition: color .2s ease;
		}
		.finesse-crumb-nav a:hover {
			color: #000;
		}

		/* Top Section Grid */
		.finesse-hero-grid {
			display: grid;
			grid-template-columns: minmax(320px, 480px) minmax(0, 1fr);
			gap: 64px;
			align-items: start;
			padding-bottom: 90px;
		}

		.finesse-image-frame {
			position: relative;
			background: #e8e8e8;
			border-radius: 4px;
			overflow: hidden;
			box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
		}
		.finesse-image-frame img {
			width: 100%;
			height: auto;
			display: block;
			object-fit: cover;
			max-height: 640px;
		}

		.finesse-info-column {
			display: flex;
			flex-direction: column;
		}

		.finesse-service-h1 {
			font-size: clamp(34px, 3.8vw, 52px);
			font-weight: 400;
			letter-spacing: -.02em;
			line-height: 1.1;
			margin: 0 0 24px;
			color: #000;
		}

		.finesse-lead-p {
			font-size: 16px;
			line-height: 1.65;
			color: #333;
			margin-bottom: 24px;
		}

		.finesse-spec-block {
			margin-bottom: 18px;
			font-size: 15px;
			line-height: 1.6;
			color: #444;
		}
		.finesse-spec-block strong {
			color: #000;
			font-weight: 600;
			margin-right: 4px;
		}

		/* Action Buttons (Screenshot 1) */
		.finesse-action-row {
			display: flex;
			align-items: center;
			gap: 16px;
			margin-top: 36px;
			flex-wrap: wrap;
		}

		.fin-pill-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-height: 52px;
			padding: 0 32px;
			border-radius: 12px;
			font-family: var(--fin-font-main, 'Barlow', sans-serif);
			font-size: 13px;
			font-weight: 600;
			letter-spacing: .08em;
			text-transform: uppercase;
			text-decoration: none;
			border: 2px solid #000;
			transition: all .25s ease;
			white-space: nowrap;
			cursor: pointer;
		}

		/* Active/Filled (Gallery) */
		.fin-pill-btn.btn-dark {
			background: #202020;
			color: #ffffff;
			border-color: #000000;
		}
		.fin-pill-btn.btn-dark:hover {
			background: #383838;
			color: #ffffff;
			transform: translateY(-2px);
			box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
		}

		/* Outlined (Case Studies & Request Quote) */
		.fin-pill-btn.btn-outline {
			background: transparent;
			color: #000000;
			border-color: #000000;
		}
		.fin-pill-btn.btn-outline:hover {
			background: #000000;
			color: #ffffff;
			transform: translateY(-2px);
			box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
		}

		/* Section 2: Our Process (Screenshot 2) */
		.finesse-process-section {
			background: #ffffff;
			padding: 90px 0 100px;
			border-top: 1px solid #eaeaea;
			border-bottom: 1px solid #eaeaea;
		}

		.finesse-process-title {
			text-align: center;
			font-size: clamp(30px, 3.2vw, 44px);
			font-weight: 400;
			letter-spacing: -.01em;
			margin: 0 0 56px;
			color: #000;
		}

		.finesse-process-list {
			max-width: 680px;
			margin: 0 auto;
			display: flex;
			flex-direction: column;
			gap: 32px;
			text-align: center;
		}

		.finesse-process-item h4 {
			font-size: 15px;
			font-weight: 700;
			letter-spacing: .02em;
			color: #000;
			margin: 0 0 8px;
		}

		.finesse-process-item p {
			font-size: 14px;
			line-height: 1.6;
			color: #3a3a3a;
			margin: 0;
		}

		/* Section 3: Live Page Footer (Screenshot 3) */
		.finesse-live-footer {
			background: #ffffff;
			padding: 56px 0 48px;
			color: #222;
			font-size: 13px;
			line-height: 1.65;
		}

		.finesse-footer-inner {
			display: grid;
			grid-template-columns: 1.6fr auto 1.6fr;
			gap: 32px;
			align-items: center;
		}

		.finesse-footer-left {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.finesse-footer-company {
			font-size: 14px;
			font-weight: 600;
			color: #000;
			margin-bottom: 4px;
		}

		.finesse-footer-bullets {
			list-style: none;
			padding: 0;
			margin: 0 0 10px;
		}
		.finesse-footer-bullets li {
			position: relative;
			padding-left: 14px;
			margin-bottom: 4px;
			color: #444;
		}
		.finesse-footer-bullets li::before {
			content: "•";
			position: absolute;
			left: 0;
			color: #222;
		}
		.finesse-footer-bullets a {
			color: inherit;
			text-decoration: none;
			transition: color .2s;
		}
		.finesse-footer-bullets a:hover {
			color: #000;
			text-decoration: underline;
		}

		.finesse-footer-credits {
			font-size: 12px;
			color: #666;
			margin-top: 6px;
		}

		.finesse-footer-center {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 20px;
		}
		.finesse-footer-social-icon {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 36px;
			height: 36px;
			color: #000;
			transition: transform .2s ease, opacity .2s ease;
		}
		.finesse-footer-social-icon:hover {
			transform: scale(1.12);
			opacity: .75;
		}

		.finesse-footer-right {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			gap: 20px;
		}

		.finesse-mb-text {
			font-family: var(--fin-font-main, sans-serif);
			font-size: 24px;
			font-weight: 800;
			font-style: italic;
			color: #c41e24;
			line-height: 1.1;
			text-align: right;
			white-space: nowrap;
		}

		.finesse-mb-logo img {
			height: 64px;
			width: auto;
			display: block;
		}

		/* Responsive */
		@media (max-width: 991px) {
			.finesse-hero-grid {
				grid-template-columns: 1fr;
				gap: 40px;
			}
			.finesse-footer-inner {
				grid-template-columns: 1fr;
				gap: 36px;
				text-align: center;
			}
			.finesse-footer-bullets li {
				padding-left: 0;
			}
			.finesse-footer-bullets li::before {
				display: none;
			}
			.finesse-footer-right {
				justify-content: center;
			}
			.finesse-mb-text {
				text-align: center;
			}
			.finesse-action-row {
				justify-content: flex-start;
			}
		}
	</style>

	<main id="main" class="site-main finesse-service-body" role="main">
		<div class="finesse-service-container">
			<!-- Breadcrumbs -->
			<nav class="finesse-crumb-nav" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'workstation' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'workstation' ); ?></a>
				<span>/</span>
				<a href="<?php echo esc_url( home_url( '/#what' ) ); ?>"><?php esc_html_e( 'Services', 'workstation' ); ?></a>
				<span>/</span>
				<span style="color: #000; font-weight: 500;"><?php the_title(); ?></span>
			</nav>

			<!-- Top Hero Overview Grid -->
			<div class="finesse-hero-grid">
				<!-- Left Column: Image -->
				<div class="finesse-image-frame">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
					<?php endif; ?>
				</div>

				<!-- Right Column: Info & Action Buttons -->
				<div class="finesse-info-column">
					<h1 class="finesse-service-h1"><?php the_title(); ?></h1>

					<p class="finesse-lead-p"><?php echo esc_html( $desc ); ?></p>

					<!-- Spec Blocks matching live site -->
					<div class="finesse-spec-block">
						<strong><?php esc_html_e( 'Best suited for', 'workstation' ); ?></strong>
						<span><?php echo esc_html( is_array( $best_raw ) ? implode( ', ', $best_raw ) : str_replace( "\n", ', ', $best_raw ) ); ?></span>
					</div>

					<div class="finesse-spec-block">
						<strong><?php echo esc_html( $spec_1_key ); ?></strong>
						<span><?php echo esc_html( $spec_1_val ); ?></span>
					</div>

					<div class="finesse-spec-block">
						<strong><?php echo esc_html( $spec_2_key ); ?></strong>
						<span><?php echo esc_html( $spec_2_val ); ?></span>
					</div>

					<div class="finesse-spec-block">
						<strong><?php echo esc_html( $spec_3_key ); ?></strong>
						<span><?php echo esc_html( $spec_3_val ); ?></span>
					</div>

					<!-- Screenshot 1: Action Buttons -->
					<div class="finesse-action-row">
						<a href="<?php echo esc_url( home_url( '/#work' ) ); ?>" class="fin-pill-btn btn-dark">
							<?php esc_html_e( 'Gallery', 'workstation' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/#services' ) ); ?>" class="fin-pill-btn btn-outline">
							<?php esc_html_e( 'Case Studies', 'workstation' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="fin-pill-btn btn-outline">
							<?php esc_html_e( 'Request A Quote', 'workstation' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Screenshot 2: Our Process Section -->
		<section class="finesse-process-section" aria-label="<?php esc_attr_e( 'Our Process', 'workstation' ); ?>">
			<div class="finesse-service-container">
				<h2 class="finesse-process-title"><?php esc_html_e( 'Our Process', 'workstation' ); ?></h2>

				<div class="finesse-process-list">
					<?php foreach ( $steps as $step ) : ?>
						<div class="finesse-process-item">
							<h4><?php echo esc_html( $step['step'] . ' — ' . $step['title'] ); ?></h4>
							<p><?php echo esc_html( $step['desc'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- Screenshot 3: Service Page Footer -->
		<div class="finesse-live-footer">
			<div class="finesse-service-container">
				<div class="finesse-footer-inner">
					<!-- Left: Company Info & Bullets -->
					<div class="finesse-footer-left">
						<div class="finesse-footer-company"><?php esc_html_e( 'Finesse Grind & Polish © 2026', 'workstation' ); ?></div>
						<ul class="finesse-footer-bullets">
							<li><?php esc_html_e( 'Phone: ', 'workstation' ); ?><a href="tel:0490389447">0490389447</a></li>
							<li><?php esc_html_e( 'Email: ', 'workstation' ); ?><a href="mailto:daniel@finessegroup.au">daniel@finessegroup.au</a></li>
							<li><?php esc_html_e( 'Business hours: Mon–Fri 7.00–17.00, Sat 7.00–17.00', 'workstation' ); ?></li>
							<li><?php esc_html_e( 'Address: Marsden Park NSW 2765', 'workstation' ); ?></li>
						</ul>
						<div class="finesse-footer-credits">
							<?php esc_html_e( 'Designed & maintained by Finesse Grind & Polish', 'workstation' ); ?><br>
							<?php esc_html_e( 'All content © Finesse Grind & Polish 2026. All rights reserved.', 'workstation' ); ?>
						</div>
					</div>

					<!-- Center: Social Icons -->
					<div class="finesse-footer-center">
						<a class="finesse-footer-social-icon" href="https://www.instagram.com/finessegrindpolish/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'workstation' ); ?>">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
								<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
								<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
							</svg>
						</a>
						<a class="finesse-footer-social-icon" href="https://www.facebook.com/share/1V7rDeEntc/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'workstation' ); ?>">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
							</svg>
						</a>
					</div>

					<!-- Right: Master Builder Better Builder + MBA Logo -->
					<div class="finesse-footer-right">
						<div class="finesse-mb-text">
							<?php esc_html_e( 'Master Builder', 'workstation' ); ?><br>
							<?php esc_html_e( 'Better Builder!', 'workstation' ); ?>
						</div>
						<div class="finesse-mb-logo">
							<?php
							$mba_logo_path = get_template_directory() . '/assets/images/MBA_MBBB_Web.jpg';
							$mba_logo_url  = get_template_directory_uri() . '/assets/images/MBA_MBBB_Web.jpg';
							if ( file_exists( $mba_logo_path ) ) :
								?>
								<img src="<?php echo esc_url( $mba_logo_url ); ?>" alt="<?php esc_attr_e( 'Master Builders Association Member', 'workstation' ); ?>">
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php
endwhile;

get_footer();
