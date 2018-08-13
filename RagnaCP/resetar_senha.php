<?php
/* Template Name: [ Mudar Senha ] */
include_once 'includes/functions.php';
require "includes/config.php";
if ( $_SESSION['usuario'] ):
    if( !empty($_POST) and isset($_POST["mudar_senha"] ) ) {
        $userid = str_replace($letters, "", $_SESSION['usuario']->userid);
        $user_pass = str_replace($letters, "", $_POST["user_pass"]);
        $new_pass = str_replace($letters, "", $_POST["new_pass"]);
        $confirm_new_pass = str_replace($letters, "", $_POST["confirm_new_pass"]);
        if( $new_pass == $confirm_new_pass ){
            if($_SESSION['usuario']->user_pass == $user_pass ){
                $dados = mudar_senha($con, $userid, $user_pass, $new_pass,  $confirm_new_pass);
            }else{
                $dados = "A senha Digitada não é igual à que consta registrada no sistema.";
            }
        }else{
            $dados = "A senha nova e sua confirmação não são iguais";
        }
    }
endif;
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
                <?php if($resumo){ ?>
                    <h4><?php echo $resumo; ?></h4>
                <?php }; ?>
                <?php if ( $_SESSION["usuario"] ) : ?>
                    <?php the_content(); ?>
                     <form action="" name="resetar_senha" class="cadastro reset_pass" method="post">
                        <label>
                            <span class="label-content">Digite sua Senha :</span>
                            <input name="user_pass" class="ipt" type="password" required="required"  value="" min="6" placeholder="**********" >
                        </label>
                        <label>
                            <span class="label-content">Nova Senha :</span>
                            <input name="new_pass" class="ipt" type="password" required="required"  value="" min="6" placeholder="**********"\   >
                        </label>
                        <label>
                            <span class="label-content">Confire a Senha :</span>
                            <input name="confirm_new_pass" class="ipt" type="password" required="required"  value="" min="6" placeholder="**********"\   >
                        </label>
                        <div class="box-footer">
                            <div class="error-msg">
                                <?php echo "<p class='error'>" . $dados . "</p>";?>
                            </div>
                            <input type="submit" value="Mudar Senha" class="btn" name="mudar_senha">
                        </div>
                    </form>
                <?php else : ?>
                    <h3 class="logued-error">Precisa se logar para ver o conteudo da pagina</h3>
                <?php endif;?>
            <?php endwhile;?>
		</div>
    </article>
    <aside class="right">
    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>