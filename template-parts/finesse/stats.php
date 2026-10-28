<?php
/**
 * Finesse Template Part: Section 4 - Stats Strip
 *
 * @package Workstation
 * @since 1.0.0
 */

$s1_num  = get_theme_mod( 'finesse_stat1_num', '15+' );
$s1_text = get_theme_mod( 'finesse_stat1_text', esc_html__( 'Years in the construction industry', 'workstation' ) );
$s2_num  = get_theme_mod( 'finesse_stat2_num', '06' );
$s2_text = get_theme_mod( 'finesse_stat2_text', esc_html__( 'Specialist services', 'workstation' ) );
$s3_num  = get_theme_mod( 'finesse_stat3_num', 'NSW' );
$s3_text = get_theme_mod( 'finesse_stat3_text', esc_html__( 'Residential & commercial across Sydney', 'workstation' ) );
?>

<section class="stats-strip" aria-label="<?php esc_attr_e( 'Key Statistics', 'workstation' ); ?>">
	<div class="wrap">
		<div class="g-stats">
			<div class="rv stat-item">
				<div class="draw stat-line"></div>
				<div class="stat-num"><?php echo esc_html( $s1_num ); ?></div>
				<p class="stat-label"><?php echo esc_html( $s1_text ); ?></p>
			</div>
			<div class="rv stat-item">
				<div class="draw stat-line"></div>
				<div class="stat-num"><?php echo esc_html( $s2_num ); ?></div>
				<p class="stat-label"><?php echo esc_html( $s2_text ); ?></p>
			</div>
			<div class="rv stat-item">
				<div class="draw stat-line"></div>
				<div class="stat-num"><?php echo esc_html( $s3_num ); ?></div>
				<p class="stat-label"><?php echo esc_html( $s3_text ); ?></p>
			</div>
		</div>
	</div>
</section>
