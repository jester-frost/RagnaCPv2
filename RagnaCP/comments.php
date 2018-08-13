<?php
/**
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
	<p class="resumo"><?php the_excerpt(); ?></p>
	<div class="publicacao"><?php the_content(); ?></div>
    <?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'Publicação em &ldquo;%2$s&rdquo;', '%1$s Publicações em &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'twentyfifteen' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h2>
	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 56,
			) );
		?>
	</ol>
	<?php endif; // have_comments() ?>
	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>
	<?php comment_form(); ?>