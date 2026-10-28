<?php
/**
 * Template part for displaying archive post content
 *
 * @package Workstation
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="post-header">
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			?>
			<a class="post-category" href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
				<?php echo esc_html( $categories[0]->name ); ?>
			</a>
			<?php
		}
		?>

		<?php the_title( '<h2 class="post-title"><a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="post-meta">
			<?php workstation_posted_on(); ?>
			<span class="post-author"><?php esc_html_e( 'by', 'workstation' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
		</div>
	</header>

	<?php
	if ( has_post_thumbnail() && workstation_get_mod( 'workstation_show_featured_image', true ) ) {
		?>
		<figure class="post-thumbnail">
			<a class="post-thumbnail-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( workstation_get_featured_image_link_label() ); ?>">
				<?php the_post_thumbnail( 'medium_large', array( 'alt' => workstation_get_featured_image_alt() ) ); ?>
			</a>
		</figure>
		<?php
	}
	?>

	<div class="post-excerpt">
		<?php the_excerpt(); ?>
	</div>

	<footer class="post-footer">
		<a href="<?php the_permalink(); ?>" class="read-more"><?php printf( esc_html__( 'Read more about %s', 'workstation' ), esc_html( get_the_title() ) ); ?></a>
	</footer>
</article>
