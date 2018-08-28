<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
include_once ( get_template_directory() . '/includes/config.php'); // loads config variables
include_once ( get_template_directory() . '/includes/functions.php');
get_header();
?>
<section class="conteudo limit">
	<aside class="left"><?php include( get_template_directory() . '/includes/menu-left.php' ); ?></aside>
	<article id="post-<?php echo the_ID(); ?>">
		<div class="box">
			<h3 class="box-title"><?php printf( __( 'Resultados encontrados para: %s', 'ragna' ), get_search_query() ); ?></h3>
			<?php
			if (have_posts()):
				while (have_posts()):
					the_post();
					get_template_part('content', 'search');
				endwhile;
				the_posts_pagination(array(
					'prev_text'          => __( 'Previous page', 'ragna' ),
					'next_text'          => __( 'Next page', 'ragna' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'ragna' ) . ' </span>',
				));
			else:
				$html .= '
					<div class="box box-inner">
						<h3 class="box-title">Não foram encontrados resultados, procure novamente. </h3>					
						<form role="search" method="get" id="searchform" class="searchform" action="">
							<input type="text" value="" name="s" class="ipt" id="s">
							<input type="submit" id="searchsubmit" class="btn" value="Pesquisar">
						</form>
					</div>';
				echo $html;
			endif;
			?>
			<div class="box-footer">
			</div>
		</div>
	</article>
    <aside class="right"><?php include( get_template_directory() . '/includes/vote.php' ); ?></aside>
</section>
<?php get_footer(); ?>