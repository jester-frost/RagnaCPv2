<?php
/* Template Name: [ Pagueseguro Retorno ] */
require ( get_template_directory() . '/includes/config.php');
include_once ( get_template_directory() . '/includes/functions.php');
require ( get_template_directory() . '/includes/dPagSeguro-master/dPagSeguro.inc.php');
if( $sandbox ){
    $url = "https://sandbox.pagseguro.uol.com.br";
}else{
    $url = "https://pagseguro.uol.com.br";
}
header("access-control-allow-origin: ".$url."");
header("Content-Type: text/html; charset=UTF-8",true);
date_default_timezone_set('America/Sao_Paulo');	
$ps = new dPagSeguro($pgemail, $token);
$transactionInfo = $ps->getTransaction($_GET['transaction_id']);
$acc=array(':transaction_id'=> $_GET['transaction_id']);
$account_query = $con->prepare("SELECT `account_id` FROM `doacao` WHERE transaction_id = :transaction_id");
$account_query->execute($acc);
$account_info = $account_query->fetch(PDO::FETCH_OBJ);
$today = date('Y-m-j h-i-s');

$valores = array(
	':account_id'=> $transactionInfo['reference'],
	':valor'=> $transactionInfo['grossAmount'],
	':Rops'=> ($transactionInfo['grossAmount'] * $rops_por_real ),
	':estado'=> $transactionInfo['status'],
	':transaction_id'=> $transactionInfo['code'],
	':email'=> $transactionInfo['sender']['email'],
	':data'=> $today
	);

if( $transactionInfo ){
	if ( empty( $account_info ) ){
		$add_compra_query = $con->prepare("INSERT INTO `doacao`(
					`account_id`, 
					`data`, 
					`valor`, 
					`Rops`, 
					`estado`, 
					`transaction_id`, 
					`email`
				) VALUES (
				:account_id, 
				:data, 
				:valor, 
				:Rops, 
				:estado, 
				:transaction_id, 
				:email
			) "
		);
		$add_compra_query->execute($valores);

		$acc=array(':transaction_id'=> $valores[':transaction_id']);
		$account_query = $con->prepare("SELECT * FROM `doacao` WHERE `transaction_id` = :transaction_id AND `estado` = 3");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);

		if ($account_info){
			$account_info = array_shift($account_info);
			$acc=array(':transaction_id'=> $valores[':transaction_id'], ':estado'=> $valores[':estado']);
			$add_compra_query = $con->prepare("UPDATE `doacao`SET `estado` = :estado WHERE `transaction_id` = :transaction_id");
			$add_compra_query->execute($acc);
			$update=array(':Rops'=>$account_info->Rops, ':account_id'=>$account_info->account_id);
			$cash_update = $con->prepare("INSERT INTO `acc_reg_num` (`account_id`, `key`, `index`, `value`) VALUES(:account_id, '#CASHPOINTS', 0, :Rops) ON DUPLICATE KEY UPDATE value=value+:Rops");
			$cash_update->execute($update);
		}

		$dados = "Obrigado pela compra!";
	}else{
		$dados = "Compra já efetuada, verifique suas compras.";
	}
} else {
	$dados = "Verifique suas compras.";
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
					<p><?php echo $dados; ?></p>
				</div>
				<div class="box-footer"></div>
			<?php endwhile;?>
        </div>
    </article>
    <aside class="right">
    	<?php include( get_template_directory() . '/includes/vote.php' ); ?>
    </aside>
</section>
<?php get_footer(); ?>