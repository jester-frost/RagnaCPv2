<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="box">
		<h3 class="box-title">
			<?php
				if ( is_single() ) :
					the_title();
				else :
					the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' );
				endif;
			?>
		</h3>
		<div class="spacer">
			<?php
				the_excerpt('<h3">', '</h3>');
				the_content( sprintf(
					__( 'Continue Lendo %s', 'ragna_theme' ),
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
		<div class="box-footer">

			<?php edit_post_link( __( 'Edit', 'ragna_theme' ), '<span class="edit-link"> ', ' </span>' ); ?>
		</div>
	</div>
</div>
