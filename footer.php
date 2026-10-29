<?php
/**
 * The footer for Finesse / Workstation theme
 *
 * @package Workstation
 * @since 1.0.0
 */

$office_text = get_theme_mod( 'finesse_footer_office', "Marsden Park NSW 2765\nServicing Greater Sydney" );
$hours_text  = get_theme_mod( 'finesse_footer_hours', "Mon – Fri 7:00 – 17:00\nSat 7:00 – 17:00" );
$watermark   = get_theme_mod( 'finesse_footer_watermark', 'FINESSE' );
?>

<footer id="colophon" class="fin-footer" role="contentinfo">
	<div class="wrap">
		<div class="g-foot">
			<!-- Column 1: Office or Widget 1 -->
			<div>
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php else : ?>
					<p class="lbl"><?php esc_html_e( 'Office', 'workstation' ); ?></p>
					<p><?php echo nl2br( esc_html( $office_text ) ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Column 2: Hours or Widget 2 -->
			<div>
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<?php dynamic_sidebar( 'footer-2' ); ?>
				<?php else : ?>
					<p class="lbl"><?php esc_html_e( 'Hours', 'workstation' ); ?></p>
					<p><?php echo nl2br( esc_html( $hours_text ) ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Column 3: Services Menu or Widget 3 -->
			<div>
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<?php dynamic_sidebar( 'footer-3' ); ?>
				<?php else : ?>
					<p class="lbl"><?php esc_html_e( 'Services', 'workstation' ); ?></p>
					<?php
					if ( has_nav_menu( 'finesse-footer' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'finesse-footer',
							'menu_class'     => 'flink-col',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						) );
					} else {
						?>
						<div class="flink-col">
							<a class="flink" href="#what"><?php esc_html_e( 'Mechanical Polished Concrete', 'workstation' ); ?></a>
							<a class="flink" href="#what"><?php esc_html_e( 'Grind & Seal Concrete', 'workstation' ); ?></a>
							<a class="flink" href="#what"><?php esc_html_e( 'Micro Cement', 'workstation' ); ?></a>
							<a class="flink" href="#what"><?php esc_html_e( 'Epoxy & Flake Flooring', 'workstation' ); ?></a>
							<a class="flink" href="#what"><?php esc_html_e( 'Spray Resin', 'workstation' ); ?></a>
							<a class="flink" href="#what"><?php esc_html_e( 'Concrete Preparation Grinding', 'workstation' ); ?></a>
						</div>
						<?php
					}
					?>
				<?php endif; ?>
			</div>

			<!-- Column 4: Social Links / Footer Menu -->
			<div>
				<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
					<?php dynamic_sidebar( 'footer-4' ); ?>
				<?php else : ?>
					<p class="lbl"><?php esc_html_e( 'Social', 'workstation' ); ?></p>
					<?php
					if ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'menu_class'     => 'flink-col',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						) );
					} else {
						?>
						<div class="flink-col">
							<a class="flink" href="https://www.instagram.com/finessegrindpolish/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Instagram', 'workstation' ); ?></a>
							<a class="flink" href="https://www.facebook.com/share/1V7rDeEntc/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Facebook', 'workstation' ); ?></a>
						</div>
						<?php
					}
					?>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Big Watermark Wordmark -->
	<?php if ( $watermark ) : ?>
		<div aria-hidden="true" class="rv fin-foot-watermark"><?php echo esc_html( $watermark ); ?></div>
	<?php endif; ?>

	<!-- Bottom Row -->
	<div class="wrap fin-foot-bottom">
		<span>
			<?php
			$copyright = get_theme_mod( 'workstation_footer_text', '© ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '. All rights reserved.' );
			echo wp_kses_post( $copyright );
			?>
		</span>
		<a class="flink" href="#top"><?php esc_html_e( 'Back to top ↑', 'workstation' ); ?></a>
	</div>
</footer>

</div><!-- #root -->

<?php wp_footer(); ?>

</body>
</html>
