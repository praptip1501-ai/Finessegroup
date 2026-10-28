<?php
/**
 * The header for Finesse / Workstation theme
 *
 * @package Workstation
 * @since 1.0.0
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'workstation' ); ?></a>

<?php
$header_btn_text = get_theme_mod( 'finesse_header_btn_text', esc_html__( 'Request a quote', 'workstation' ) );
$header_btn_url  = get_theme_mod( 'finesse_header_btn_url', '#contact' );
?>

<div class="fin fx" id="root">

<div class="prog" aria-hidden="true"></div>

<!-- TOP BAR -->
<header class="bar" role="banner">
	<div class="wrap bar-inner">
		<div class="bar-logo">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				$finesse_logo_path = get_theme_file_path( 'assets/images/logo-white.png' );
				$finesse_logo_url  = get_theme_file_uri( 'assets/images/logo-white.png' );
				if ( file_exists( $finesse_logo_path ) ) {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title" aria-label="<?php bloginfo( 'name' ); ?>">
						<img src="<?php echo esc_url( $finesse_logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="height: 38px; width: auto; display: block">
					</a>
					<?php
				} else {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
				}
			}
			?>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'workstation' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'navlinks',
					'container'      => false,
					'depth'          => 1,
				) );
			} elseif ( has_nav_menu( 'finesse-primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'finesse-primary',
					'menu_class'     => 'navlinks',
					'container'      => false,
					'depth'          => 1,
				) );
			} else {
				// Default Finesse Section Anchors matching original design
				?>
				<ul class="navlinks">
					<li><a href="#what"><?php esc_html_e( 'Services', 'workstation' ); ?></a></li>
					<li><a href="#services"><?php esc_html_e( 'How we work', 'workstation' ); ?></a></li>
					<li><a href="#work"><?php esc_html_e( 'Projects', 'workstation' ); ?></a></li>
					<li><a href="#about"><?php esc_html_e( 'About', 'workstation' ); ?></a></li>
					<li><a href="#contact"><?php esc_html_e( 'Contact', 'workstation' ); ?></a></li>
				</ul>
				<?php
			}
			?>
		</nav>

		<!-- Right Side Action & Mobile Toggle -->
		<div class="bar-actions">
			<?php if ( $header_btn_text ) : ?>
				<a class="btn btn-w bar-cta" href="<?php echo esc_url( $header_btn_url ); ?>"><?php echo esc_html( $header_btn_text ); ?></a>
			<?php endif; ?>

			<button class="fin-menu-toggle" aria-controls="fin-mobile-drawer" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'workstation' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<line x1="3" y1="12" x2="21" y2="12"></line>
					<line x1="3" y1="18" x2="21" y2="18"></line>
				</svg>
			</button>
		</div>
	</div>

	<!-- Mobile Menu Drawer -->
	<div id="fin-mobile-drawer" class="fin-mobile-menu" aria-hidden="true">
		<?php
		if ( has_nav_menu( 'primary' ) || has_nav_menu( 'finesse-primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => has_nav_menu( 'primary' ) ? 'primary' : 'finesse-primary',
				'menu_class'     => 'mobile-navlinks',
				'container'      => false,
				'depth'          => 1,
			) );
		} else {
			?>
			<ul class="mobile-navlinks">
				<li><a href="#what"><?php esc_html_e( 'Services', 'workstation' ); ?></a></li>
				<li><a href="#services"><?php esc_html_e( 'How we work', 'workstation' ); ?></a></li>
				<li><a href="#work"><?php esc_html_e( 'Projects', 'workstation' ); ?></a></li>
				<li><a href="#about"><?php esc_html_e( 'About', 'workstation' ); ?></a></li>
				<li><a href="#contact"><?php esc_html_e( 'Contact', 'workstation' ); ?></a></li>
			</ul>
			<?php
		}
		?>

		<?php if ( $header_btn_text ) : ?>
			<div class="mobile-cta-wrap" style="margin-top: 16px;">
				<a class="btn btn-w" href="<?php echo esc_url( $header_btn_url ); ?>" style="width: 100%; min-height: 44px; text-align: center; justify-content: center;"><?php echo esc_html( $header_btn_text ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</header>
