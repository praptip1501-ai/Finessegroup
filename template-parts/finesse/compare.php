<?php
/**
 * Finesse Template Part: Section 9 - Before/After Concrete Grinding Slider
 *
 * @package Workstation
 * @since 1.0.0
 */

$cmp_lbl        = get_theme_mod( 'finesse_compare_lbl', esc_html__( 'Concrete Preparation Grinding', 'workstation' ) );
$cmp_head       = get_theme_mod( 'finesse_compare_heading', esc_html__( 'Drag to grind', 'workstation' ) );
$cmp_desc       = get_theme_mod( 'finesse_compare_desc', esc_html__( 'Adhesives, tile glue, membranes, paint and laitance. Pull the handle across to see proper preparation take a slab back to clean, sound concrete.', 'workstation' ) );
$cmp_pct_lbl    = get_theme_mod( 'finesse_compare_pct_label', esc_html__( 'prepared', 'workstation' ) );
$cmp_before_tag = get_theme_mod( 'finesse_compare_before_tag', esc_html__( 'Before', 'workstation' ) );
$cmp_after_tag  = get_theme_mod( 'finesse_compare_after_tag', esc_html__( 'After', 'workstation' ) );
$cmp_img_before = get_theme_mod( 'finesse_compare_img_before', '' );
$cmp_img_after  = get_theme_mod( 'finesse_compare_img_after', '' );
?>

<section class="compare-section" aria-label="<?php esc_attr_e( 'Interactive Grinding Slider', 'workstation' ); ?>">
	<div class="wrap">
		<div class="g-cmp">
			<div>
				<p class="lbl" style="margin: 0 0 20px; color: #A3A3A3"><?php echo esc_html( $cmp_lbl ); ?></p>
				<h3 class="rv cmp-heading"><?php echo esc_html( $cmp_head ); ?></h3>
				<p class="rv cmp-desc"><?php echo esc_html( $cmp_desc ); ?></p>
				<div class="rv" style="display: flex; align-items: baseline; gap: 12px">
					<span style="font-size: 64px; font-weight: 300; line-height: 1"><span id="cmpPct">50</span>%</span>
					<span class="cap" style="color: #A3A3A3"><?php echo esc_html( $cmp_pct_lbl ); ?></span>
				</div>
			</div>

			<div class="cmp clip">
				<!-- Clean Polished/Honed Concrete (After) -->
				<div style="position: absolute; inset: 0; background: #918B81; overflow: hidden">
					<?php if ( $cmp_img_after ) : ?>
						<img src="<?php echo esc_url( $cmp_img_after ); ?>" alt="<?php echo esc_attr( $cmp_after_tag ); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block">
					<?php else : ?>
						<span id="cmpStones"></span>
						<svg aria-hidden="true" width="100%" height="100%" style="position: absolute; inset: 0; mix-blend-mode: multiply; opacity: .3">
							<filter id="fz-noise2">
								<feTurbulence type="fractalNoise" baseFrequency="0.8" numOctaves="3" stitchTiles="stitch"></feTurbulence>
								<feColorMatrix type="saturate" values="0"></feColorMatrix>
							</filter>
							<rect width="100%" height="100%" filter="url(#fz-noise2)"></rect>
						</svg>
						<span class="gloss" style="opacity: .95"></span>
					<?php endif; ?>
				</div>

				<!-- Raw / Glue-Contaminated Concrete (Before) -->
				<div style="position: absolute; inset: 0; background: #7A756C; clip-path: inset(0 50% 0 0); overflow: hidden" id="cmpBefore">
					<?php if ( $cmp_img_before ) : ?>
						<img src="<?php echo esc_url( $cmp_img_before ); ?>" alt="<?php echo esc_attr( $cmp_before_tag ); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block">
					<?php else : ?>
						<span id="cmpRaw"></span>
						<svg aria-hidden="true" width="100%" height="100%" style="position: absolute; inset: 0; mix-blend-mode: multiply; opacity: .6">
							<filter id="fz-noise3">
								<feTurbulence type="fractalNoise" baseFrequency="0.6" numOctaves="4" stitchTiles="stitch"></feTurbulence>
								<feColorMatrix type="saturate" values="0"></feColorMatrix>
							</filter>
							<rect width="100%" height="100%" filter="url(#fz-noise3)"></rect>
						</svg>
					<?php endif; ?>
				</div>

				<span class="cmptag" style="left: 18px"><?php echo esc_html( $cmp_before_tag ); ?></span>
				<span class="cmptag" style="right: 18px"><?php echo esc_html( $cmp_after_tag ); ?></span>

				<!-- Accessible Range Control -->
				<input class="cmprange" type="range" min="0" max="100" value="50" id="cmpRange" aria-label="<?php esc_attr_e( 'Before and after: drag to grind the slab', 'workstation' ); ?>">

				<span class="handle" id="cmpHandle" style="left: 50%" aria-hidden="true">
					<span class="knob">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
							<path d="M9 7l-5 5 5 5M15 7l5 5-5 5"></path>
						</svg>
					</span>
				</span>
			</div>
		</div>
	</div>
</section>
