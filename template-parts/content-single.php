<?php
/**
 * Template part for displaying single post content
 *
 * @package Workstation
 * @since 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="post-header">
		<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

		<div class="post-meta">
			<?php workstation_posted_on_single(); ?>
			<span class="post-author"><?php esc_html_e( 'by', 'workstation' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>

			<?php
			$categories = get_the_category();
			if ( $categories ) {
				echo ' | <span class="post-categories">';
				foreach ( $categories as $category ) {
					echo '<a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ) . '</a> ';
				}
				echo '</span>';
			}

			$tags = get_the_tags();
			if ( $tags ) {
				echo ' | <span class="post-tags">';
				foreach ( $tags as $tag ) {
					echo '<a href="' . esc_url( get_tag_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a> ';
				}
				echo '</span>';
			}
			?>
		</div>
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
