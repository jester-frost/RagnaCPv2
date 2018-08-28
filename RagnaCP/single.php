<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
include_once ( get_template_directory() . '/includes/config.php'); // loads config variables
include_once ( get_template_directory() . '/includes/functions.php');
$resumo = get_the_excerpt();
get_header();
?>
<section class="conteudo">
	<aside class="left"><?php include( get_template_directory() . '/includes/menu-left.php' ); ?></aside>
	<article>
		<div class="box">
			<h3 class="box-title"><?php the_title(); ?></h3>
			<div class="spacer">
				<?php
				if ($resumo):
					echo '<h4>' . $resumo . '</h4>';
				endif;
				the_content();
				while ( have_posts() ) : the_post();
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile;
				?>
			</div>
			<div class="box-footer">
				<div id="comments" class="comments-area">
				</div>
			</div>
		</div>
	</article>
	<aside class="right"><?php include( get_template_directory() . '/includes/vote.php' ); ?></aside>
</section>
<?php get_footer(); ?>