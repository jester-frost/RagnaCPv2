<?php
/**
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
get_header(); ?>
	<section class="conteudo">
	    <aside class="left">
	    	<?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
	    </aside>
	    <article>
	        <div class="box">
				<h3 class="box-title">Ultimas Notícias</h3>
				<?php if ( have_posts() ) : ?>
					<?php
						while ( have_posts() ) : the_post();
							get_template_part( 'content-noticia', get_post_format() );
						endwhile;
						the_posts_pagination( array(
							'prev_text'          => __( 'Previous page', 'ragna_theme' ),
							'next_text'          => __( 'Next page', 'ragna_theme' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'ragna_theme' ) . ' </span>',
						) );
					else :
						echo "<p> Sem noticias publicadas.</p>";
					endif;

				?>
	        </div>
	    </article>
	    <aside class="right">
	    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
	    </aside>
	</section>
<?php get_footer(); ?>