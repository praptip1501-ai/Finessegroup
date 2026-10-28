<?php
/**
 * Template part for displaying page content
 *
 * @package Workstation
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="post-header">
		<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>
	</header>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<figure class="post-thumbnail">
			<?php the_post_thumbnail( 'large', array( 'alt' => workstation_get_featured_image_alt() ) ); ?>
		</figure>
		<?php
	}
	?>

	<div class="post-content">
		<?php the_content(); ?>
	</div>

	<?php
	wp_link_pages( array(
		'before'      => '<div class="page-links">',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
	) );
	?>
</article>
