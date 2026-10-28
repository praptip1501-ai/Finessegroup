<?php
/**
 * Search template
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content">
	<main id="main" class="site-main" role="main" tabindex="-1">
		<?php
		if ( have_posts() ) {
			?>
			<h1 class="page-title">
				<?php
				printf( esc_html__( 'Search Results for: %s', 'workstation' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
				?>
			</h1>
			<?php

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
