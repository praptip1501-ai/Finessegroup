<?php
/**
 * The main template file
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content <?php echo ( ! workstation_has_sidebar() ) ? 'no-sidebar' : ''; ?>">
	<main id="main" class="site-main" role="main" tabindex="-1">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			}
			the_posts_pagination( array(
				'prev_text' => esc_html__( 'Previous', 'workstation' ),
				'next_text' => esc_html__( 'Next', 'workstation' ),
			) );
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
	</main>
	<?php
	if ( workstation_has_sidebar() ) {
		get_sidebar();
	}
	?>
</div>

<?php get_footer();
