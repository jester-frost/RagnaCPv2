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
get_header(); ?>

<section class="conteudo">
	    <aside class="left">
	    	<?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
	    </aside>

	    <article>
	        <div class="box">
				<h3 class="box-title"><?php the_title(); ?></h3>
	            
	            <div class="spacer">

					<?php if($resumo){ ?>

	                    <h4><?php echo $resumo; ?></h4>

	                <?php }; ?>

	                            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content-interno-noticia', get_post_format() ); ?>

            <?php endwhile; ?>

	            </div>


				<div class="box-footer">

				</div>
			</div>

	    </article>

	    <aside class="right">
	    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
	    </aside>
	</section>

<?php get_footer(); ?>
