<?php
/* Template Name: [ Pagueseguro Retorno ] */
require "includes/config.php";
require "includes/dPagSeguro-master/dPagSeguro.inc.php";
$ps = new dPagSeguro($pgemail, $token);
$transactionInfo = $ps->getTransaction($_GET['transaction_id']);
$acc=array(':transaction_id'=> $_GET['transaction_id']);
$account_query = $con->prepare("SELECT `account_id` FROM `doacao` WHERE transaction_id = :transaction_id");
$account_query->execute($acc);
$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
$today = date('Y-m-j h-i-s');
$valores=array(
	':account_id'=>$transactionInfo['reference'],
	':valor'=>$transactionInfo['grossAmount'],
	':Rops'=>($transactionInfo['grossAmount'] * $rops_por_real ),
	':estado'=>$transactionInfo['status'],
	':transaction_id'=>$transactionInfo['code'],
	':email'=>$transactionInfo['sender']['email'],
	':data'=>$today
	);
if (empty($account_info)){
	$add_compra_query = $con->prepare("INSERT INTO `doacao`(account_id,data,valor,Rops,estado,transaction_id,email) VALUES(:account_id, :data, :valor, :Rops, :estado, :transaction_id, :email) ");
	$add_compra_query->execute($valores);	
	$dados = "Obrigado pela compra!";
}
else{
	$dados = "Verifique suas compras.";
}
include_once 'includes/functions.php';
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