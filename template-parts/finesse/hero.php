<?php
/**
 * Finesse Template Part: Section 2 - Hero
 *
 * @package Workstation
 * @since 1.0.0
 */

$hero_word     = get_theme_mod( 'finesse_hero_word', 'FINESSE' );
$hero_sub      = get_theme_mod( 'finesse_hero_sub', 'GRIND & POLISH' );
$hero_desc     = get_theme_mod( 'finesse_hero_desc', 'Concrete grinding, polishing and resin flooring for residential, commercial and industrial projects across Sydney.' );
$hero_video    = get_theme_mod( 'finesse_hero_video', '' );
$hero_poster   = get_theme_mod( 'finesse_hero_poster', '' );

if ( empty( $hero_video ) && file_exists( get_theme_file_path( 'assets/images/hero.mp4' ) ) ) {
	$hero_video = get_theme_file_uri( 'assets/images/hero.mp4' );
}
if ( empty( $hero_poster ) && file_exists( get_theme_file_path( 'assets/images/poster.jpg' ) ) ) {
	$hero_poster = get_theme_file_uri( 'assets/images/poster.jpg' );
}

$btn1_text     = get_theme_mod( 'finesse_hero_btn1_text', esc_html__( 'Our services', 'workstation' ) );
$btn1_url      = get_theme_mod( 'finesse_hero_btn1_url', '#services' );
$btn2_text     = get_theme_mod( 'finesse_hero_btn2_text', esc_html__( 'Request a quote', 'workstation' ) );
$btn2_url      = get_theme_mod( 'finesse_hero_btn2_url', '#contact' );

// Calculate staggered delays for each letter of wordmark
$letters = mb_str_split( $hero_word );
?>

<section id="top" class="hero" aria-label="<?php esc_attr_e( 'Hero Showcase', 'workstation' ); ?>">
	<div class="kb hero-video-box">
		<?php if ( $hero_video ) : ?>
			<video id="heroVideo" autoplay muted loop playsinline preload="auto" src="<?php echo esc_url( $hero_video ); ?>" <?php echo $hero_poster ? 'poster="' . esc_url( $hero_poster ) . '"' : ''; ?> aria-hidden="true"></video>
		<?php else : ?>
			<!-- Fallback Dark Textured Concrete Backdrop -->
			<div class="slab-b" style="position: absolute; inset: 0;" aria-hidden="true"></div>
		<?php endif; ?>
	</div>

	<div aria-hidden="true" class="hero-gradient-overlay"></div>

	<div class="heroin">
		<h1 class="wm" aria-label="<?php echo esc_attr( $hero_word . ' ' . $hero_sub ); ?>" data-act="replay" title="<?php esc_attr_e( 'Click to replay animation', 'workstation' ); ?>">
			<span class="wmrow" aria-hidden="true">
				<?php
				$base_delay = 0.4;
				foreach ( $letters as $i => $char ) {
					$delay = $base_delay + ( $i * 0.08 );
					printf(
						'<span class="ltr" style="animation-delay: %.2fs">%s</span>',
						$delay,
						esc_html( $char )
					);
				}
				?>
			</span>
			<span class="hrule" aria-hidden="true"></span>
			<span class="sub" aria-hidden="true"><?php echo esc_html( $hero_sub ); ?></span>
		</h1>

		<p class="tagl">
			<span style="animation-delay: 2.1s"><?php esc_html_e( 'Grind', 'workstation' ); ?></span>
			<span class="dot" style="animation-delay: 2.2s">•</span>
			<span style="animation-delay: 2.3s"><?php esc_html_e( 'Polish', 'workstation' ); ?></span>
			<span class="dot" style="animation-delay: 2.4s">•</span>
			<span style="animation-delay: 2.5s"><?php esc_html_e( 'Coat', 'workstation' ); ?></span>
			<span class="dot" style="animation-delay: 2.6s">•</span>
			<span style="animation-delay: 2.7s"><?php esc_html_e( 'Overlays', 'workstation' ); ?></span>
		</p>
	</div>

	<div class="wrap hero-bottom-bar">
		<p class="fade d6 hero-desc"><?php echo esc_html( $hero_desc ); ?></p>
		<div class="fade d6 hero-scroll-cue">
			<span class="cap" style="font-size: 10px; color: #D0D0D0"><?php esc_html_e( 'Scroll', 'workstation' ); ?></span>
			<span class="cue" aria-hidden="true"></span>
		</div>
		<div class="fade d6 hero-btns">
			<?php if ( $btn1_text ) : ?>
				<a class="btn btn-w" href="<?php echo esc_url( $btn1_url ); ?>"><?php echo esc_html( $btn1_text ); ?></a>
			<?php endif; ?>
			<?php if ( $btn2_text ) : ?>
				<a class="btn" href="<?php echo esc_url( $btn2_url ); ?>" style="color: #fff"><?php echo esc_html( $btn2_text ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

