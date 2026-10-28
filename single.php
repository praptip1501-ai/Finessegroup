<?php
/**
 * Single post template
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content no-sidebar">
	<main id="main" class="site-main" role="main" tabindex="-1">
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', 'single' );
			the_post_navigation( array(
				'prev_text' => esc_html__( 'Previous Post', 'workstation' ),
				'next_text' => esc_html__( 'Next Post', 'workstation' ),
			) );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
		?>
	</main>
</div>

<?php get_footer();
