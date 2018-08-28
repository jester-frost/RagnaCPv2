<?php
/* Template Name: [ Resetar posição ]*/
include_once ( get_template_directory() . '/includes/functions.php');
require ( get_template_directory() . '/includes/config.php');
    $_SESSION["msg"] = "Seu personagem está preso !, não poderá ser sair deste mapa sem autorização da administração";
    if ( $_SESSION['usuario'] ):
        switch ($_GET['modo']) {
            case 'reset':
                $char_id = preg_replace('/[^[:alnum:]_]/', '',$_GET['char_id']);
                // Aqui voce chama a funcao que valida se o usuario pode ver o id
                $search_character_query = $con->prepare("SELECT * FROM `char` WHERE char_id=$char_id");
                $search_character_query->execute();
                $char_account_id = $search_character_query->fetchAll(PDO::FETCH_OBJ);
                foreach ($char_account_id as $acc) {
                    $char_id_conta = $acc->account_id;
                    $char_id_mapa = $acc->last_map;
                }
                if ($_SESSION["usuario"]->account_id == $char_id_conta){
                    // Aqui voce chama a funcao que reseta a posicao
                    if (  $char_id_mapa != 'sec_pri'){
                        $dados = resetar_posicao($con, $char_id);
                        // redireciona mantendo a URL limpa
                        //wp_redirect( get_permalink()); exit;
                    }else{
                        //wp_redirect( get_permalink()); exit;
                        $dados = $_SESSION["msg"];
                    }
                } else {
                    $dados = "Não foi possivel processar a requisição ";
                }
            break;
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
                <div class="spacer">
                        <?php if($resumo){ ?>
                            <h4><?php echo $resumo; ?></h4>
                        <?php }; ?>
                        <?php if ( $_SESSION["usuario"] ) : ?>
                            <?php the_content(); ?>
                        <h4> Personagens</h4>
                        <table class="char-reset">
                            <tr>
                                <th>Char</th>
                                <th>Mapa</th>
                                <th>Coordenadas</th>
                                <th> </th>
                            </tr>
                        <?php
                            $char = list_reset_char($con, $_SESSION['usuario']->account_id);
                            foreach ($char as $c) :
                        ?>
                            <?php if (  $c->last_map != 'sec_pri') : ?>
                               <?php $botao = '<a href="?modo=reset&char_id='. $c->char_id .'" class="btn">Resetar </a>'; ?>
                            <?php else: ?>
                                <?php $botao = " Char Preso !";?>
                            <?php endif; ?>
                            <tr>
                                <td><?php echo $c->name; ?></td>
                                <td><?php echo $c->last_map; ?></td>
                                <td><?php echo $c->last_x; ?> , <?php echo $c->last_y; ?></td>
                                <td><?php echo $botao; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
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