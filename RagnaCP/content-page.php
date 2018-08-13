<?php
/**
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
?>
<section class="conteudo limit">
	<aside class="left">
    	<?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
    </aside>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="box">
			<h3 class="box-title"><?php the_title(); ?></h3>
			<?php the_content(); ?>
			<div class="box-footer">
				<?php edit_post_link( __( 'Edit', 'ragna_theme' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
			</div>
			<?php include( get_template_directory() . '/includes/rank-pvp.php' ); ?>
		</div>
    </article>
    <aside class="right">
    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
