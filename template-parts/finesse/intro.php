<?php
/**
 * Finesse Template Part: Section 3 - About / Intro
 *
 * @package Workstation
 * @since 1.0.0
 */

$intro_lbl       = get_theme_mod( 'finesse_intro_lbl', esc_html__( 'About', 'workstation' ) );
$intro_text      = get_theme_mod( 'finesse_intro_text', 'Finesse Grind & Polish is a Sydney-based concrete contractor with over 15 years of hands-on experience in the construction industry.' );
$intro_desc      = get_theme_mod( 'finesse_intro_desc', 'Good work. No shortcuts. From residential homes to large commercial sites, our focus is on proper preparation, attention to detail and delivering a finish built to last.' );
$intro_cta_text  = get_theme_mod( 'finesse_intro_cta_text', esc_html__( 'Our services', 'workstation' ) );
$intro_cta_url   = get_theme_mod( 'finesse_intro_cta_url', '#services' );
$intro_img1      = get_theme_mod( 'finesse_intro_img1', '' );
$intro_img2      = get_theme_mod( 'finesse_intro_img2', '' );

if ( empty( $intro_img1 ) && file_exists( get_theme_file_path( 'assets/images/stair-dark.jpg' ) ) ) {
	$intro_img1 = get_theme_file_uri( 'assets/images/stair-dark.jpg' );
}
if ( empty( $intro_img2 ) && file_exists( get_theme_file_path( 'assets/images/marble-detail.jpg' ) ) ) {
	$intro_img2 = get_theme_file_uri( 'assets/images/marble-detail.jpg' );
}

$intro_img2_lbl  = get_theme_mod( 'finesse_intro_img2_lbl', esc_html__( 'Material detail', 'workstation' ) );

// Split heading into span.w words for scroll reveal animation
$words = explode( ' ', $intro_text );
?>

<section id="about" class="intro-section" aria-label="<?php esc_attr_e( 'About Finesse', 'workstation' ); ?>">
	<div class="wrap">
		<div class="g-intro">
			<p class="lbl"><?php echo esc_html( $intro_lbl ); ?></p>
			<div>
				<p class="intro-heading">
					<?php
					foreach ( $words as $word ) {
						echo '<span class="w">' . esc_html( $word ) . '</span> ';
					}
					?>
				</p>
				<p class="rv intro-desc"><?php echo esc_html( $intro_desc ); ?></p>
				<?php if ( $intro_cta_text ) : ?>
					<a class="btn btn-b rv" href="<?php echo esc_url( $intro_cta_url ); ?>"><?php echo esc_html( $intro_cta_text ); ?></a>
				<?php endif; ?>
			</div>
		</div>

		<!-- 12-Column Mosaic -->
		<div class="g-pics">
			<div class="clip" style="grid-column: 1 / span 5; position: relative; height: 640px; overflow: hidden">
				<div class="par img-box" style="position: absolute; inset: 0">
					<?php if ( $intro_img1 ) : ?>
						<img src="<?php echo esc_url( $intro_img1 ); ?>" alt="<?php esc_attr_e( 'Staircase with stone finish', 'workstation' ); ?>">
					<?php else : ?>
						<!-- Procedural concrete slab fallback -->
						<div class="slab slab-c" style="position: absolute; inset: 0;" aria-hidden="true"></div>
					<?php endif; ?>
				</div>
			</div>

			<div style="grid-column: 8 / span 4; margin-top: 260px">
				<div class="lift">
					<div class="clip img-box" style="position: relative; height: 520px; overflow: hidden">
						<div class="par" style="position: absolute; inset: 0">
							<?php if ( $intro_img2 ) : ?>
								<img src="<?php echo esc_url( $intro_img2 ); ?>" alt="<?php echo esc_attr( $intro_img2_lbl ); ?>">
							<?php else : ?>
								<!-- Procedural concrete slab fallback -->
								<div class="slab slab-d" style="position: absolute; inset: 0;" aria-hidden="true"></div>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( $intro_img2_lbl ) : ?>
						<p class="lbl" style="margin: 16px 0 0; color: #4A4A4A"><?php echo esc_html( $intro_img2_lbl ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
