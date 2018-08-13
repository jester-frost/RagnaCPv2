<?php
/**
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */

$resumo = get_the_excerpt();
?>
<div class="box" <?php post_class(); ?>>
	<h3 class="box-title">Pagina: <?php the_title( )?></h3>
    <div class="spacer">
        <?php if($resumo){ ?>
            <h4><?php echo $resumo; ?></h4>
        <?php }; ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-footer">
			<?php edit_post_link( __( 'Edit', 'ragna' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	<?php else : ?>
		<?php edit_post_link( __( 'Edit', 'ragna' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
	<?php endif; ?>
    </div>
	<div class="box-footer">
        <?php the_title( sprintf( '<a href="%s" rel="bookmark" class="link-post-class">', esc_url( get_permalink() ) ), '</a>' ); ?>
	</div>
</div>