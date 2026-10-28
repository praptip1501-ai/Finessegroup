<?php
/**
 * Page template
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
			get_template_part( 'template-parts/content', 'page' );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
		?>
	</main>
</div>

<?php get_footer();
