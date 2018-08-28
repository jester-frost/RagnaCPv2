<?php
/* Template Name: [ Pagueseguro ] */
include_once ( get_template_directory() . '/includes/functions.php');
require ( get_template_directory() . '/includes/config.php');
require ( get_template_directory() . '/includes/dPagSeguro-master/dPagSeguro.inc.php');
if( $sandbox ){
    $url = "https://sandbox.pagseguro.uol.com.br";
}else{
    $url = "https://pagseguro.uol.com.br";
}
header("access-control-allow-origin: ".$url."");
header("Content-Type: text/html; charset=UTF-8",true);
date_default_timezone_set('America/Sao_Paulo');
    if( !empty( $_POST ) and isset( $_POST["valor"] ) ){
        $acc_id = str_replace($letters, "", $_SESSION['usuario']->account_id);
        $valor = str_replace($letters, "", $_POST["valor"]);
        $sendername = str_replace($letters, "", $_POST["senderName"]);
        $total = $rops_por_real * $valor;
        $Email = $pgemail;
        $Token = $token;
        $pedido = Array(
            'reference'   => $_SESSION['usuario']->account_id,
            'senderEmail' => $Email,
            'senderName'  => $sendername,
            'shippingType'=> 3, // 1=PAC, 2=SEDEX, 3=Não especificado
            'shippingCost'=> 0.0, // Preço sempre decimal
            'redirectUrl' => $site.'/pagseguro_retorno.php'
        );
        $produtos   = Array();
        $produtos[] = Array(
            'id'         => $id_do_item,
            'description'=> "R$ ".$valor." em ".$desc_do_item." Total ".$total." de ".$desc_do_item,
            'amount'     => $valor, // Preço sempre decimalm, vindo do ajax ao clicar no botão de compra
            'quantity'   => $qtd,     // Quantidade
            // ... Veja a relação completa na documentação do PagSeguro.
        );
        $ps = new dPagSeguro($Email, $Token);
        $goURL = $ps->newPagamento($pedido, $produtos);
        print_r($goURL);

        if($goURL){
            header("Location: {$goURL}");
            die();
        }
        else{
            echo "O PagSeguro não aceitou o pedido de compra:\r\n";
            foreach($ps->listErrors() as $errorCode=>$errorStr){
                echo "{$errorStr} (código {$errorCode})\r\n";
            }
        }
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
                <?php if($resumo){ ?>
                    <h4><?php echo $resumo; ?></h4>
                <?php }; ?>
                <?php if ( $_SESSION["usuario"] ) : ?>
                    <?php the_content(); ?>
                    <form action="" name="doa-form" class="generic-form pagueseguro" method="post">
                        <?php if ( $planos ) : ?>
                            <div class="plan-value">
                                <h2>Valores de Planos</h2>
                                <div class="doacao">
                                    <label class="valor-doacao">
                                        <span class="label-content"><input type="radio" name="valor" value="<?php echo $plano1; ?>"> Plano 1 <?php echo "R$ ".$plano1.",00"; ?></span>
                                        <p><?php echo ( $rops_por_real * $plano1 )." " .$desc_do_item ; ?></p>
                                    </label>
                                </div>
                                <div class="doacao">
                                    <label class="valor-doacao">
                                        <span class="label-content"><input type="radio" name="valor" value="<?php echo $plano2; ?>"> Plano 2 <?php echo "R$ ".$plano2.",00"; ?></span>
                                        <p><?php echo ( $rops_por_real * $plano2 )." " .$desc_do_item ;?></p>
                                    </label>
                                </div>
                                <div class="doacao">
                                    <label class="valor-doacao">
                                        <span class="label-content"><input type="radio" name="valor" value="<?php echo $plano3; ?>"> Plano 3 <?php echo "R$ ".$plano3.",00"; ?></span>
                                        <p><?php echo ( $rops_por_real * $plano3 )." " .$desc_do_item ;?></p>
                                    </label>
                                </div>
                            </div>
                        <?php else : ?>
                            <label>
                                <span class="label-content">Valor de Doação</span>
                                <input name="valor" id="money" onkeypress="mascara( this, mvalor );" onkeyup="mascara( this, mvalor );" class="ipt" type="text" required="required" pattern="\d+.\d{2}"  value="" min="6" placeholder="" >
                            </label>
                        <?php endif; ?>
                        <label>
                            <span class="label-content">Nome</span>
                            <input type="text" name="senderName" class="ipt"  placeholder="Seu Nome">
                        </label>
                        <label>
                            <span class="label-content">Telefone</span>
                            <input type="text" name="senderPhone" class="ipt ipt-num" placeholder="Seu Telefone">
                        </label>
                        <div class="box-footer">
                            <div class="error-msg">
                                <?php echo "<p class='error'>" . $dados . "</p>";?>
                            </div>
                            <input type="submit" value="Contribuir" class="btn" name="doa-form">
                        </div> 
                    </form>
                    <div class="spacer">
                        <nav class="tab-nav">
                            <a href="#tab-1" class="tab-item active" >Histórico de Doações</a>
                            <a href="#tab-2" class="tab-item" >Doações Pendentes</a>
                        </nav>
                        <div class="tab-content">
                            <div id="tab-1">
                                <h3> Doações Realizadas</h3>
                                <hr>
                            <?php include "includes/tabela_doacoes.php";?>  
                            </div>
                            <div id="tab-2" class="hide">
                                <h3> Doações Pendentes</h3>
                                <hr>
                                <?php include "includes/doacao_pendente.php";?>  
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="spacer">
                        <h3 class="logued-error">Precisa se logar para ver o conteudo da pagina</h3>
                    </div>
                <?php endif; ?>
            <?php endwhile;?>
		</div>
    </article>
    <aside class="right">
    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>