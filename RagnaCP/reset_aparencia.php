<?php
/* Template Name: [ Resetar aparencia ] */
include_once ( get_template_directory() . '/includes/functions.php');
require ( get_template_directory() . '/includes/config.php');
if ( $_SESSION['usuario'] ):
    switch ($_GET['modo']) {
        case 'reset_hair':
            $char_id = preg_replace('/[^[:alnum:]_]/', '',$_GET['char_id']);
            // Aqui voce chama a funcao que valida se o usuario pode ver o id
            $search_character_query = $con->prepare("SELECT * FROM `char` WHERE char_id=$char_id");
            $search_character_query->execute();
            $char_account_id = $search_character_query->fetchAll(PDO::FETCH_OBJ);

            foreach ($char_account_id as $acc) {
                $char_id_conta = $acc->account_id;
            }
            if ($_SESSION["usuario"]->account_id == $char_id_conta){
                // Aqui voce chama a funcao que reseta a posicao
                $dados = resetar_cabelo($con, $char_id);

                // redireciona mantendo a URL limpa
                //wp_redirect( get_permalink()); exit;

            }else {
                $dados = "Não foi possivel processar a requisição ";
            }
        break;
        case 'reset_equip':
            $char_id = preg_replace('/[^[:alnum:]_]/', '',$_GET['char_id']);
            // Aqui voce chama a funcao que valida se o usuario pode ver o id
            $search_character_query = $con->prepare("SELECT * FROM `char` WHERE char_id=$char_id");
            $search_character_query->execute();
            $char_account_id = $search_character_query->fetchAll(PDO::FETCH_OBJ);

            foreach ($char_account_id as $acc) {
                $char_id_conta = $acc->account_id;
            }
            if ($_SESSION["usuario"]->account_id == $char_id_conta){
                // Aqui voce chama a funcao que reseta a posicao
                $dados = resetar_equip($con, $char_id);
                // redireciona mantendo a URL limpa
                //wp_redirect( get_permalink()); exit;

            }else {
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
                    <ul class="char-reset-aparence">
                        <?php
                            $char = listagem_char($con, $_SESSION['usuario']->account_id);    
                            foreach ($char as $c):
                        ?>
                            <li>
                                <div class='reset-char'>
                                    <h4>Aparência de  <strong><?php echo $c->name; ?></strong> </h4>
                                    <div>
                                        <section class="my-char">
                                            <img src='<?php echo get_template_directory_uri(); ?>/chargen/avatar/<?php echo $c->name; ?>'/> 
                                        </section>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Penteado / Cor </th>
                                                    <th>Cor da Roupa </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $c->hair; ?> / <?php echo $c->hair_color; ?></td>
                                                    <td><?php echo $c->clothes_color; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="bt">
                                                        <a href="?modo=reset_hair&char_id=<?php echo $c->char_id; ?>" class="btn" >Aparência </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Cabeça Topo</th>
                                                    <th>Cabeça Meio</th>
                                                    <th>Cabeça Baixo</th>
                                                    <th>Arma</th>
                                                    <th>Escudo</th>
                                                    <th>Capa</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $c->head_top; ?></td>
                                                    <td><?php echo $c->head_mid; ?></td>
                                                    <td><?php echo $c->head_bottom; ?></td>
                                                    <td><?php echo $c->weapon; ?></td>
                                                    <td><?php echo $c->shield; ?></td>
                                                    <td><?php echo $c->robe; ?></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="bt">
                                                        <a href="?modo=reset_equip&char_id=<?php echo$c->char_id; ?>"  class="btn">Equipamento</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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