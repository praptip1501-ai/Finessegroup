<?php
/**
 * Archive template
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
	<main id="main" class="site-main" role="main" tabindex="-1">
		<?php
		if ( have_posts() ) {
			if ( is_archive() ) {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			}

			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content', 'archive' );
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
