<?php
/**
 *
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 1.0
 */
include_once 'includes/config.php'; // loads config variables
include_once 'includes/functions.php';
$resumo = get_the_excerpt();
get_header(); ?>
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
                    if ($_SESSION["usuario"]):
                        the_content();
                        if (have_posts()):
                            if (is_home() && ! is_front_page()):
                                echo '<div><h1 class="page-title screen-reader-text">' . single_post_title() . '</h1></div>';
                            endif;
                            while (have_posts()):
                                the_post();
                                get_template_part('content', get_post_format());
                            endwhile;
                            the_posts_pagination(array(
                                'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
                                'next_text'          => __( 'Next page', 'twentyfifteen' ),
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . '</span>',
                                ));
                        endif;
                    else:
                        get_template_part('content', 'none');
                    endif;
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