<?php
/**
 * Finesse Template Part: Section 5 - Service Index
 *
 * @package Workstation
 * @since 1.0.0
 */

$sidx_lbl   = get_theme_mod( 'finesse_sidx_lbl', esc_html__( 'Services', 'workstation' ) );
$sidx_title = get_theme_mod( 'finesse_sidx_title', esc_html__( 'What we do', 'workstation' ) );
$sidx_desc  = get_theme_mod( 'finesse_sidx_desc', esc_html__( 'Six specialist concrete services. Select any service to see where it\'s used and exactly how we deliver it.', 'workstation' ) );

$services = finesse_get_services_explorer_data();
?>

<section id="what" class="service-index-section" aria-label="<?php esc_attr_e( 'Our Services', 'workstation' ); ?>">
	<div class="wrap">
		<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 24px; margin-bottom: 48px">
			<div>
				<p class="lbl" style="margin: 0 0 20px"><?php echo esc_html( $sidx_lbl ); ?></p>
				<h2 class="rv" style="margin: 0; font-size: clamp(44px, 5.6vw, 88px); font-weight: 300; line-height: .95; letter-spacing: -.01em"><?php echo esc_html( $sidx_title ); ?></h2>
			</div>
			<p class="rv" style="margin: 0; max-width: 380px; font-size: 15px; line-height: 1.6; color: #4A4A4A"><?php echo esc_html( $sidx_desc ); ?></p>
		</div>

		<div class="sidx" id="ovList">
			<?php
			// Server-side fallback rendered immediately before client JS initializes
			if ( ! empty( $services ) ) :
				foreach ( $services as $j => $svc ) :
					$num_str = sprintf( '%02d', $j + 1 );
					?>
					<a class="srow" href="#services" data-act="ov" data-i="<?php echo esc_attr( $j ); ?>">
						<span class="lbl snum"><?php echo esc_html( $num_str ); ?></span>
						<span class="sname"><?php echo esc_html( $svc['name'] ); ?></span>
						<span class="sdesc"><?php echo esc_html( $svc['tag'] ?: $svc['desc'] ); ?></span>
						<span class="sthumb sw sw-<?php echo esc_attr( $svc['id'] ); ?>" aria-hidden="true"></span>
						<span class="sarr">
							<svg width="22" height="22" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
								<path d="M1 8h13M9 3l5 5-5 5"></path>
							</svg>
						</span>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
