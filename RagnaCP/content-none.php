<?php
/**
* @package WordPress
* @subpackage RagnaCP
* @since RagnaCP 2.0
*/
include_once ( get_template_directory() . '/includes/config.php'); // loads config variables
include_once ( get_template_directory() . '/includes/functions.php');
$resumo = get_the_excerpt();
get_header();
?>
<section class="conteudo limit">
	<aside class="left">
		<?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
	</aside>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="box">
			<h3 class="box-title"><?php _e( 'Nothing Found', 'ragna_theme' ); ?></h3>
			<div class="spacer">
				<?php if($resumo){ ?>
                    <h4><?php echo $resumo; ?></h4>
                <?php }; ?>
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
					<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ragna_theme' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
				<?php elseif ( is_search() ) : ?>
					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ragna_theme' ); ?></p>
					<?php get_search_form(); ?>
				<?php else : ?>
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ragna_theme' ); ?></p>
					<?php get_search_form(); ?>
				<?php endif; ?>
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