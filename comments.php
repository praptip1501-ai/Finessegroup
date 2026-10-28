<?php
/**
 * Comments template
 *
 * @package Workstation
 * @since 1.0.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area" role="region" aria-label="<?php esc_attr_e( 'Comments', 'workstation' ); ?>">
	<?php
	if ( have_comments() ) {
		?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( 1 === $comment_count ) {
				esc_html_e( 'One thought on &ldquo;', 'workstation' );
				the_title();
				esc_html_e( '&rdquo;', 'workstation' );
			} else {
				printf(
					/* translators: %1$s is the number of comments, %2$s is the post title */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'workstation' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2>

		<ol class="commentlist">
			<?php
			wp_list_comments( array(
				'avatar_size' => 50,
				'type'        => 'comment',
				'callback'    => 'workstation_comment_callback',
			) );
			?>
		</ol>

		<?php
		the_comments_pagination( array(
			'prev_text' => esc_html__( 'Older Comments', 'workstation' ),
			'next_text' => esc_html__( 'Newer Comments', 'workstation' ),
		) );
	}

	if ( comments_open() ) {
		comment_form();
	} elseif ( is_single() || is_page() ) {
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'workstation' ); ?></p>
		<?php
	}
	?>
</div>

<?php

/**
 * Custom comment callback for proper escaping and security
 */
function workstation_comment_callback( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( array( 'comment' ), $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<b class="fn">
						<?php
						$comment_author_url = get_comment_author_url( $comment );
						if ( $comment_author_url ) {
							?>
							<a href="<?php echo esc_url( $comment_author_url ); ?>" rel="external nofollow user"><?php comment_author( $comment ); ?></a>
							<?php
						} else {
							comment_author( $comment );
						}
						?>
					</b>
					<span class="says"><?php esc_html_e( 'says:', 'workstation' ); ?></span>
				</div>

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
							printf(
								/* translators: %1$s is the comment date, %2$s is the time */
								esc_html__( '%1$s at %2$s', 'workstation' ),
								get_comment_date( '', $comment ),
								get_comment_time( '', false, $comment )
							);
							?>
						</time>
					</a>
				</div>

				<?php
				if ( '0' === $comment->comment_approved ) {
					?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'workstation' ); ?></em>
					<?php
				}
				?>
			</footer>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="reply">
				<?php
				comment_reply_link( array_merge(
					$args,
					array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					)
				) );
				?>
			</div>
		</article>
	<?php
}
