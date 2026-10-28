<?php
/**
 * Finesse Template Part: Sections 6-8 - 3D Service Explorer
 *
 * @package Workstation
 * @since 1.0.0
 */

$exp_lbl        = get_theme_mod( 'finesse_exp_lbl', esc_html__( 'How we work', 'workstation' ) );
$exp_title      = get_theme_mod( 'finesse_exp_title', esc_html__( 'Explore each service', 'workstation' ) );
$exp_desc       = get_theme_mod( 'finesse_exp_desc', esc_html__( 'Choose a service and step through our process — the slab changes with every stage. Drag it to turn it in the light.', 'workstation' ) );
$exp_drag_hint  = get_theme_mod( 'finesse_exp_drag_hint', esc_html__( 'Drag to rotate · move to tilt', 'workstation' ) );
$exp_turn_text  = get_theme_mod( 'finesse_exp_turn_text', esc_html__( 'Turn sample', 'workstation' ) );
$exp_best_label = get_theme_mod( 'finesse_exp_best_label', esc_html__( 'Best suited for', 'workstation' ) );
$exp_quote_text = get_theme_mod( 'finesse_exp_quote_text', esc_html__( 'Request a quote', 'workstation' ) );
$exp_quote_url  = get_theme_mod( 'finesse_exp_quote_url', '#contact' );

$services_data = finesse_get_services_explorer_data();
?>

<!-- Pass WordPress CPT Service Data & Labels to Client-Side Explorer -->
<script>
	window.FINESSE_SERVICES = <?php echo wp_json_encode( $services_data ); ?>;
	window.FINESSE_LABELS = {
		turn: <?php echo wp_json_encode( $exp_turn_text ); ?>
	};
</script>

<section id="services" class="explorer-section" aria-label="<?php esc_attr_e( 'Interactive 3D Service Explorer', 'workstation' ); ?>">
	<div class="wrap">
		<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 24px">
			<div>
				<p class="lbl" style="margin: 0 0 20px; color: #A3A3A3"><?php echo esc_html( $exp_lbl ); ?></p>
				<h2 class="rv" style="margin: 0; font-size: clamp(44px, 5.6vw, 88px); font-weight: 300; line-height: .95; letter-spacing: -.01em"><?php echo esc_html( $exp_title ); ?></h2>
			</div>
			<p class="rv" style="margin: 0; max-width: 360px; font-size: 15px; line-height: 1.6; color: #A3A3A3"><?php echo esc_html( $exp_desc ); ?></p>
		</div>
	</div>

	<!-- Service Tabs Strip -->
	<div class="wrap explorer-tabs-wrap" style="margin-top: 56px">
		<div style="display: flex; align-items: center; gap: 16px">
			<button type="button" class="navbtn" data-act="prev" aria-label="<?php esc_attr_e( 'Previous service', 'workstation' ); ?>">
				<svg width="18" height="18" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
					<path d="M15 8H2M7 3L2 8l5 5"></path>
				</svg>
			</button>
			<div class="tabs" id="tabs" role="group" aria-label="<?php esc_attr_e( 'Choose a service', 'workstation' ); ?>"></div>
			<button type="button" class="navbtn" data-act="next" aria-label="<?php esc_attr_e( 'Next service', 'workstation' ); ?>">
				<svg width="18" height="18" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
					<path d="M1 8h13M9 3l5 5-5 5"></path>
				</svg>
			</button>
		</div>
	</div>

	<!-- 3D Slab Interactive Stage -->
	<div class="stage swapA" id="stage">
		<div class="scenebox">
			<div class="bgword" aria-hidden="true"><span class="wordin" id="bgword"></span></div>
			<div class="shadow" aria-hidden="true"></div>
			<div class="scene">
				<div class="enter">
					<div class="bob">
						<div class="slab3d">
							<div class="face stepA" id="face" role="img" aria-label="<?php esc_attr_e( 'Interactive Concrete Slab', 'workstation' ); ?>"></div>
							<div class="edge-b" id="edgeB"></div>
							<div class="edge-r" id="edgeR"></div>
						</div>
					</div>
				</div>
			</div>
			<p class="hint" aria-hidden="true">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
					<path d="M4 12h16M7 8l-4 4 4 4M17 8l4 4-4 4"></path>
				</svg>
				<?php echo esc_html( $exp_drag_hint ); ?>
			</p>
		</div>
		<div class="ovl" id="ovl"></div>
		<div class="ovr">
			<p class="cap" style="margin: 0 0 14px; color: #A3A3A3"><?php echo esc_html( $exp_best_label ); ?></p>
			<div id="best" style="display: flex; flex-wrap: wrap; gap: 8px"></div>
		</div>
	</div>

	<!-- Service Info & Process Steps -->
	<div class="wrap">
		<div class="swapA" id="infoWrap" style="border-top: 1px solid rgba(255,255,255,.18)">
			<div class="g-info" style="padding: 40px 0 40px">
				<h3 class="txtin" id="infoName" style="margin: 0; font-size: clamp(28px, 3vw, 44px); font-weight: 500; line-height: 1.05; text-transform: uppercase; letter-spacing: .01em"></h3>
				<p class="txtin" id="infoDesc" style="margin: 0; font-size: 17px; line-height: 1.7; color: #D4D4D4"></p>
			</div>
		</div>

		<!-- Step by Step Process Box -->
		<div class="procbox">
			<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 28px">
				<p class="cap" id="procName" style="margin: 0; color: #A3A3A3"></p>
				<button type="button" class="pill" data-act="play" id="playBtn"></button>
			</div>
			<div class="g-steps" id="steps" role="group" aria-label="<?php esc_attr_e( 'Process steps', 'workstation' ); ?>"></div>
			<div class="g-stepdetail stepA" id="stepDetail">
				<p class="chipin" id="stepText" style="margin: 0; font-size: clamp(20px, 2vw, 28px); font-weight: 300; line-height: 1.35; color: #fff"></p>
				<a class="btn btn-w" href="<?php echo esc_url( $exp_quote_url ); ?>" style="white-space: nowrap; justify-self: end">
					<?php echo esc_html( $exp_quote_text ); ?>
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
						<path d="M1 8h13M9 3l5 5-5 5"></path>
					</svg>
				</a>
			</div>
		</div>

		<!-- Specs Strip -->
		<div class="g-spec swapA" id="specs" style="padding: 40px 0; border-bottom: 1px solid rgba(255,255,255,.18)"></div>
	</div>
</section>
