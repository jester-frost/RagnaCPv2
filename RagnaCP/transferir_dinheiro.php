<?php
/* Template Name: [ Transferir Dinheiro ] */
include_once ( get_template_directory() . '/includes/functions.php');
require ( get_template_directory() . '/includes/config.php');
if ( $_SESSION['usuario'] ):
    if( !empty($_POST) and isset($_POST["transferencia"] ) ){
        $account_id = $_SESSION["usuario"]->account_id;
        $char_id = str_replace($letters, "", $_POST["char"]);
        $dinheiro = str_replace($letters, "", $_POST["money"]);
        $char_destino = str_replace($letters, "", $_POST["personagem"]);
        $search_character_query = $con->prepare("SELECT * FROM `char` WHERE char_id=$char_id");
        $search_character_query->execute();
        $char = $search_character_query->fetch(PDO::FETCH_OBJ);
        if ($char) {
            if ( $char->account_id == $account_id ) {
                if ($char_id != $char_destino ) {
                    $dados = transferir($con, $char_id, $dinheiro, $char_destino);
                }
                else{
                    $dados="O depósito deve ser feito à personagens diferentes.";
                }
            }else{
                $dados = automatic_ban($con, $account_id);
            }
        }else{
            $dados = "Char não encontrado ... como é possível isso ?";
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
            <h3 class="box-title"><?php the_title(); ?></h3>
            <div class="spacer">
            <?php while ( have_posts() ) : the_post();?>
                <?php if($resumo){ ?>
                    <h4><?php echo $resumo; ?></h4>
                <?php }; ?>
                <?php if ( $_SESSION["usuario"] ) : ?>
                    <?php the_content(); ?>
                    <h4> Personagens</h4>
                    <ul class="char-reset char-zeny-transfer">
                    <?php $char = list_money_char($con, $_SESSION['usuario']->account_id); ?>
                        <li><div> <h5>Char</h5> <h5>Dinheiro</h5> <h5>Quantia</h5> <h5>Para</h5> </div></li>
                        <?php $option = '<option value="">Selecione</option>'; ?>
                        <?php foreach ($char as $opt) :?>
                            <?php  $option .= '<option value="' . $opt->char_id . '">' . $opt->name . '</option>';?>
                        <?php endforeach; ?>
                        <?php foreach ($char as $c) :?>
                        <li>
                            <div>
                                <p><?php echo $c->name; ?></p>
                                <p><?php echo number_format($c->zeny,0,'.','.'); ?> Z</p>
                            </div>
                            <form name="transferencia" action="" method="post">
                                <input type="hidden" name="char" value="<?php echo $c->char_id; ?>"> 
                                <label><input type="text" class="ipt ipt-num" name="money" required="required"></label>
                                <label><select class="ipt" name="personagem"><?php echo $option; ?></select></label>
                                <label><input type="submit" name="transferencia" class="btn" value="Depositar"></label>
                            </form>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php else : ?>
                    <div class="spacer">
                        <h3 class="logued-error">Precisa se logar para ver o conteudo da pagina</h3>
                    </div>
                <?php endif;?>
                <div class="box-footer">
                    <div class="error-msg">
                        <?php echo "<p class='error'>" . $dados . "</p>";?>
                    </div>
                </div>
            <?php endwhile;?>
        </div>
    </article>
    <aside class="right">
        <?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>