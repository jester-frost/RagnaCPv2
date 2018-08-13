<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
include_once 'includes/config.php'; // loads config variables
include_once 'includes/functions.php';
get_header(); ?>
<section class="conteudo limit">
    <aside class="left">
    	<?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
    </aside>
    <article>
		<div class="box">
			<h3 class="box-title">Não encontramos o Conteúdo</h3>
            <div class="spacer">
                <h3>Ooops !! Pagina não encontrada, ou não existe .. tente procurar novamente ...</h3>
            </div>
			<div class="box-footer">
				<?php get_search_form(); ?>
			</div>
		</div>
    </article>
    <aside class="right">
    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>