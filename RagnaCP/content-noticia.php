<?php
/**
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
$resumo = get_the_excerpt(the_id());
$thumb = get_the_post_thumbnail(the_id());
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="spacer">
		<h3 class="box-title"><?php the_title(); ?></h3>
		<div class="spacer" style="overflow:hidden;">
			<p><sup><?php the_date( 'd \d\e F \d\e Y' ); ?><sup></p>
			<?php if ($resumo): ?>
				<p><?php echo $resumo; ?></p>
			<?php endif; ?>
			<?php if ($thumb): ?>
				<div class="thumb">
					<?php echo $thumb; ?>
				</div>
			<?php endif; ?>
				<a href="<?php the_permalink(); ?>" class="btn " style="display: inline-block;">Ver Post</a>
		</div>
		<div class="box-footer">
			<?php edit_post_link( __( 'Edit', 'ragna_theme' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
		</div>
	</div>
</article>