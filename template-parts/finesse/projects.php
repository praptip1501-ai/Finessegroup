<?php
/**
 * Finesse Template Part: Section 11 - Projects Grid
 *
 * @package Workstation
 * @since 1.0.0
 */

$proj_lbl   = get_theme_mod( 'finesse_proj_lbl', esc_html__( 'Recent projects', 'workstation' ) );
$proj_title = get_theme_mod( 'finesse_proj_title', esc_html__( 'Selected work', 'workstation' ) );
$proj_desc  = get_theme_mod( 'finesse_proj_desc', esc_html__( 'Residential homes to large commercial sites across Sydney.', 'workstation' ) );
$proj_btn_t = get_theme_mod( 'finesse_proj_btn_text', esc_html__( 'View our work', 'workstation' ) );
$proj_btn_u = get_theme_mod( 'finesse_proj_btn_url', 'https://www.instagram.com/finessegrindpolish/' );

$projects = finesse_get_projects_data( 3 );
?>

<section id="work" class="projects-section" aria-label="<?php esc_attr_e( 'Selected Work', 'workstation' ); ?>">
	<div class="wrap">
		<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 24px; margin-bottom: 48px; padding-top: 24px; border-top: 1px solid #000">
			<div>
				<p class="lbl" style="margin: 0 0 20px"><?php echo esc_html( $proj_lbl ); ?></p>
				<h2 class="rv" style="margin: 0; font-size: clamp(44px, 5.6vw, 88px); font-weight: 300; line-height: .95; letter-spacing: -.01em"><?php echo esc_html( $proj_title ); ?></h2>
			</div>
			<p class="rv" style="margin: 0; max-width: 360px; font-size: 15px; line-height: 1.6; color: #4A4A4A"><?php echo esc_html( $proj_desc ); ?></p>
		</div>

		<div class="g-proj">
			<?php
			$fallback_slabs = array( 'slab-a', 'slab-c', 'slab-d' );
			foreach ( $projects as $idx => $p ) :
				$slab_class = $fallback_slabs[ $idx % 3 ];
				?>
				<a class="proj rv" href="<?php echo esc_url( $proj_btn_u ); ?>" target="_blank" rel="noopener noreferrer">
					<div class="img">
						<div class="par" style="position: absolute; inset: 0">
							<?php if ( ! empty( $p['image'] ) ) : ?>
								<img src="<?php echo esc_url( $p['image'] ); ?>" alt="<?php echo esc_attr( $p['title'] ); ?>">
							<?php else : ?>
								<div class="slab <?php echo esc_attr( $slab_class ); ?>" style="position: absolute; inset: 0;" aria-hidden="true"></div>
							<?php endif; ?>
						</div>
					</div>
					<p class="lbl proj-title"><?php echo esc_html( $p['title'] ); ?></p>
					<p class="proj-meta">
						<?php
						$meta_parts = array_filter( array( $p['service'], $p['location'] ) );
						echo esc_html( implode( ' · ', $meta_parts ) );
						?>
					</p>
				</a>
			<?php endforeach; ?>
		</div>

		<?php if ( $proj_btn_t ) : ?>
			<div style="display: flex; justify-content: center; margin-top: 56px">
				<a class="btn btn-b" href="<?php echo esc_url( $proj_btn_u ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $proj_btn_t ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
