<?php
/**
 * Template part for no content found
 *
 * @package Workstation
 * @since 1.0.0
 */

?>
<article class="no-results">
	<header class="post-header">
		<h1 class="post-title"><?php esc_html_e( 'Nothing here', 'workstation' ); ?></h1>
	</header>

	<div class="post-content">
		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'workstation' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</article>
