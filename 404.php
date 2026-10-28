<?php
/**
 * 404 error page template
 *
 * @package Workstation
 * @since 1.0.0
 */

get_header(); ?>

<div class="site-content no-sidebar">
	<main id="main" class="site-main" role="main" tabindex="-1">
		<article class="error-404">
			<header class="post-header">
				<h1 class="post-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'workstation' ); ?></h1>
			</header>

			<div class="post-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'workstation' ); ?></p>
				<?php
				get_search_form();
				the_widget( 'WP_Widget_Recent_Posts' );
				?>
			</div>
		</article>
	</main>
</div>

<?php get_footer();
