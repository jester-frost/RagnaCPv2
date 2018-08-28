<?php
/* Template Name: [ Ranks ] */
include_once ( get_template_directory() . '/includes/config.php'); // loads config variables
include_once ( get_template_directory() . '/includes/functions.php');
if ( is_page() ) get_header();
?>	
<section class="conteudo limit">
    <aside class="left">
        <?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
    </aside>
    <article>
        <?php include( get_template_directory() . '/includes/ranks.php' ); ?>
    </article>
    <aside class="right">
        <?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>