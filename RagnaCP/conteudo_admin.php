<?php
/* Template Name: [ ADMIN Conteudo Privado ] */
include_once ( get_template_directory() . '/includes/config.php'); // loads config variables
include_once ( get_template_directory() . '/includes/functions.php');
$resumo = get_the_excerpt();
get_header();
?>
<section class="conteudo limit">
    <aside class="left">
    	<?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
    </aside>
    <article>
		<div class="box">
            <?php while ( have_posts() ) : the_post();?>
                <h3 class="box-title"><?php the_title(); ?></h3>
                <div class="spacer">
                    <?php if($resumo){ ?>
                        <h4><?php echo $resumo; ?></h4>
                    <?php }; ?>
                    <?php if ( $_SESSION["usuario"] && ( $_SESSION["usuario"]->group_id >= $level_admin ) ) : ?>
                        <?php the_content(); ?>
                        <div class="admin-content">
                            <?php include( get_template_directory() . '/includes/admin-tabs.php' ); ?>
                         </div>
                    <?php else : ?>
                        <h3 class="logued-error">Precisa se logar para ver o conteudo da pagina</h3>
                    <?php endif;?>
                </div>
                <div class="box-footer"></div>
            <?php endwhile;?>
		</div>
    </article>
    <aside class="right">
    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>