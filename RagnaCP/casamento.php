<?php
/* Template Name: [ Casamento e Divórcio ] */
include_once ( get_template_directory() . '/includes/functions.php');
require ( get_template_directory() . '/includes/config.php');
    if ( $_SESSION['usuario'] ):
        switch ($_GET['modo']) {
            case 'divorcio':
                $char_id = $_GET['char_id'];
                // Aqui voce chama a funcao que valida se o usuario pode ver o id
                $search_character_query = $con->prepare("SELECT * FROM `char` WHERE char_id=$char_id");
                $search_character_query->execute();
                $char_account_id = $search_character_query->fetchAll(PDO::FETCH_OBJ);
                foreach ($char_account_id as $acc) {
                    $char_account_id = $acc->account_id;
                    $char_id = $acc->char_id;
                    $partner_id = $acc->partner_id;

                }
                if ($_SESSION["usuario"]->account_id == $char_account_id){
                    // Aqui voce chama a funcao divorcia
                    $dados = divorcio($con, $char_id, $partner_id);
                    // redireciona mantendo a URL limpa
                    wp_redirect( get_permalink()); exit;
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
                    <?php
                        $user = $_SESSION['usuario'];
                        $account_id = $user->account_id;
                        $character_query = $con->prepare("SELECT `account_id`, `char_id`, `name`, `partner_id` FROM `char` WHERE `account_id`=$account_id");
                        $character_query->execute();
                        $char = $character_query->fetchAll(PDO::FETCH_OBJ);
                        $search_character_query = $con->prepare("SELECT c1.`name`, c1.`char_id`, c2.`name`, c2.`char_id` FROM `char` c1 LEFT JOIN `char` c2 ON c1.`partner_id` = c2.`char_id` WHERE c1.`account_id`=$account_id");
                        $search_character_query->execute();
                        $conjuge = $search_character_query->fetchAll(PDO::FETCH_OBJ);
                        if ($conjuge) :
                            echo "<h4> Personagens </h4>";
                            echo '<table class="char-reset">';
                            echo "<tr> <th>Char</th> <th>Conjuge</th> <th></th> </tr>";
                            foreach ($char as $ch) {
                                if ($ch->partner_id == 0) {
                                    $nome = "Solteiro";
                                    $botao =" ";
                                } else {
                                    foreach ($conjuge as $conj) {
                                        if ( $conj->char_id == $ch->partner_id){
                                            $nome = $conj->name;
                                            $botao = '<a href="?modo=divorcio&char_id=' . $ch->char_id . '" class="btn" >Divórcio </a>';
                                        }
                                    }
                                }
                                echo '<tr> <td>' . $ch->name . '</td> <td>' . $nome . '</td><td>' . $botao . '</td></tr>';
                            }
                            echo '</table>';
                        endif;    
                    ?>
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