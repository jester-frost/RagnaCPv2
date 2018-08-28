<?php
    /* Template Name: [ Recuperar Senha ] */
    include ( get_template_directory() . '/includes/phpmailer_functions.php');
    include_once ( get_template_directory() . '/includes/config.php'); // loads config variables
    include_once ( get_template_directory() . '/includes/functions.php');
    if(!empty($_POST) and (isset($_POST["enviar"]))) {
        $email = str_replace($letters, "", $_POST["email"]);
        $dados = enviar_email($email, $md5);
    }
    $hash = '';
    if( $md5 ) {
        // Recuperar Senha
        $senha = '';
        $repete_senha = '';
        $msg = array('mensagem'=>'','status'=>'','redirect'=>'');
        $uri = $_SERVER["REQUEST_URI"];
        $re = '/(?<=hash=)([^&]+)/';
        preg_match($re, $uri, $matches, PREG_OFFSET_CAPTURE, 0);
        if( $matches ){
            if( is_array( $matches ) ){
                $matches = array_shift($matches);
                $hash = urldecode($matches[0]);
                if($hash){
                    $dados = redefine($con, $hash);
                }
            }
        }
        if(isset($_POST['new_pass'])){
            $senha = str_replace($letters, "", $_POST['new_pass']);
        }
        if(isset($_POST['repeat_new_pass'])){
            $repete_senha = str_replace($letters, "", $_POST['repeat_new_pass']);
        }
        if( isset($_POST['new_pass']) && isset( $_POST['repeat_new_pass'] ) ){
            if( $senha && $repete_senha ){
                if( $senha == $repete_senha ) {
                    $dados = nova_senha( $con, $senha, $hash );
                }else {
                    $dados = array('mensagem' => '<div class="ui error message">As senhas não conferem, por gentileza tente novamente.</div>','status'=>$dados['status'],'redirect'=>'');
                }
            }else{
                $dados = array('mensagem' => '<div class="ui error message">As senhas não foram digitadas, por gentileza tente novamente.</div>','status'=>$dados['status'],'redirect'=>'');
            }
        }
        // Fecha Recuperar Senha
    }
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
                    <?php the_content(); ?>
                </div>
                <?php if( $hash ): ?>
                    <?php if( $dados['status'] ): ?>
                        <form class="email" action="" name="alterar" method="post">
                            <input type="hidden" value="<?php echo $hash; ?>" name="hash">
                                <label>
                                    <span class="label-content" style="float: none; width: 150px; display: inline-block;">Senha</span>
                                    <input type="password" placeholder="Sua nova senha" name="new_pass">
                                </label>
                                <label>
                                    <span class="label-content" style="float: none; width: 150px; display: inline-block;">Repetir Senha</span>
                                    <input type="password" placeholder="Repetir nova senha" name="repeat_new_pass">
                                </label>
                            <div class="box-footer">
                                <div class="error-msg">
                                    <?php echo "<p class='error'>" . $dados['mensagem'] . "</p>";?>
                                </div>
                                <input type="submit" name="alterar" class="btn" value="Alterar">
                            </div>
                        </form>
                        <?php else: ?>
                            <form action="" method="post" name="recupera-senha" class="email">
                        <label>
                            <span class="label-content">E-mail</span>
                            <input class="ipt" name="email" type="text" required="required">
                        </label>
                        <div class="box-footer">
                            <div class="error-msg">
                                <?php echo "<p class='error'>" . $dados['mensagem'] . "</p>";?>
                            </div>
                            <input type="submit" value="Enviar" class="btn" name="enviar">
                        </div>
                    </form>
                    <?php endif; ?>
                <?php else: ?>
                    <form action="" method="post" name="recupera-senha" class="email">
                        <label>
                            <span class="label-content">E-mail</span>
                            <input class="ipt" name="email" type="text" required="required">
                        </label>
                        <div class="box-footer">
                            <div class="error-msg">
                                <?php echo "<p class='error'>" . $dados . "</p>";?>
                            </div>
                            <input type="submit" value="Enviar" class="btn" name="enviar">
                        </div>
                    </form>
                <?php endif; ?>
            <?php endwhile;?>
        </div>
    </article>
    <aside class="right">
        <?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>