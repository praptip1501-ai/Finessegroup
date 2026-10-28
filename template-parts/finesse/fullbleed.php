<?php
/**
 * Finesse Template Part: Section 10 - Full Bleed Feature Image
 *
 * @package Workstation
 * @since 1.0.0
 */

$feature_img   = get_theme_mod( 'finesse_feature_img', '' );

if ( empty( $feature_img ) && file_exists( get_theme_file_path( 'assets/images/stair-micro.jpg' ) ) ) {
	$feature_img = get_theme_file_uri( 'assets/images/stair-micro.jpg' );
}

$feature_title = get_theme_mod( 'finesse_feature_title', 'Good work. No shortcuts.' );
$feature_tag   = get_theme_mod( 'finesse_feature_tag', esc_html__( 'Proper preparation · Attention to detail · Built to last', 'workstation' ) );
?>

<section class="fullbleed-section" aria-label="<?php esc_attr_e( 'Feature Showcase', 'workstation' ); ?>">
	<div class="clip fullbleed-box">
		<div class="par" style="position: absolute; inset: 0">
			<?php if ( $feature_img ) : ?>
				<img src="<?php echo esc_url( $feature_img ); ?>" alt="<?php echo esc_attr( $feature_title ); ?>">
			<?php else : ?>
				<!-- Procedural dark concrete slab fallback -->
				<div class="slab-b" style="position: absolute; inset: 0;" aria-hidden="true"></div>
			<?php endif; ?>
		</div>
		<div aria-hidden="true" class="fullbleed-overlay"></div>

		<div class="wrap fullbleed-content">
			<p class="rv fullbleed-title"><?php echo esc_html( $feature_title ); ?></p>
			<p class="lbl fullbleed-tagline"><?php echo esc_html( $feature_tag ); ?></p>
		</div>
	</div>
</section>
