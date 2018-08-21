<?php
/* Template Name: [ Cadastro ] */
    include("includes/functions.php");
    require "includes/config.php";
    if(!empty($_POST) and (isset($_POST["cadastrar"]))){
        $account_id = str_replace($letters, "", $_POST[""]);
        $userid = LimparTexto($letters, $_POST["userid"]);
        $user_pass = str_replace($letters, "", $_POST["user_pass"]);
        $sex = str_replace($letters, "", $_POST["sex"]);
        $confirm_user_pass = str_replace($letters, "", $_POST["confirm_user_pass"]);
        $email = str_replace($letters, "", $_POST["email"]);
        $date = str_replace($letters, "", $_POST["birthdate"]);
        $dados = registrar($con, $userid, $user_pass, $confirm_user_pass, $email, $sex, $date, $letters, $md5);
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
                <?php if ($msg) : ?>
                    <?php echo $msg;?>
                <?php else : ?>
                <form action="" name="cadastro" class="cadastro" method="post">
                    <label for="login">
                        <span class="label-content">Login :</span>
                        <input pattern=".{6,}" title="No minimo 6 caractéres" class="ipt" name="userid" id="login" type="text" value="" placeholder="fulano" required="required" value="">
                    </label>
                    <label>
                        <span class="label-content">E-mail :</span>
                        <input name="email" class="ipt" type="email" required="required" value="" placeholder="fulano@provedor.com.br">
                    </label>
                    <label>
                        <span class="label-content">Genero :</span>
                        <select class="ipt" name="sex" id="sexo" required="required">
                            <option value="">Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </label>
                    <label class="date">
                        <span class='label-content'>Data Nascimento :</span>
                        <input id="data" name='birthdate' class='ipt' type='text' required='required'  value='' min='10' placeholder='1987-10-20' >
                    </label>
                    <label>
                        <span class="label-content">Senha :</span>
                        <input pattern=".{6,}" title="No minimo 6 caractéres" name="user_pass" class="ipt" type="password" required="required"  value="" min="6" placeholder="**********" >
                    </label>
                    <label>
                        <span class="label-content">Confirme à Senha :</span>
                        <input pattern=".{6,}" title="No minimo 6 caractéres" name="confirm_user_pass" class="ipt" type="password" required="required"  value="" min="6" placeholder="**********"\   >
                    </label>
                    <div class="box-footer">
                        <div class="error-msg">
                            <?php echo "<p class='error'>" . $dados . "</p>";?>
                        </div>
                        <input type="submit" value="Cadastrar" class="btn" name="cadastrar">
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