<?php
/**
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php ragna_theme_post_thumbnail(); ?>
	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( sprintf( '<h1 class="entry-title"><a href="%s">', esc_url( ragna_theme_get_link_url() ) ), '</a></h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s">', esc_url( ragna_theme_get_link_url() ) ), '</a></h2>' );
			endif;
		?>
	</header>
	<div class="entry-content">
		<?php
			the_content( sprintf(
				__( 'Continue reading %s', 'ragna_theme' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'ragna_theme' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'ragna_theme' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div>
	<?php
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>
	<footer class="entry-footer">
		<?php ragna_theme_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'ragna_theme' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>