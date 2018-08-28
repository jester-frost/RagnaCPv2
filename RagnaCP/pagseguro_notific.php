<?php
/* Template Name: [ Pagueseguro Atualiza ] */
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
$ps = new dPagSeguro($pgemail, $token);
$notificInfo = $ps->getNotification($_POST['notificationType'], $_POST['notificationCode']);
$acc=array(':transaction_id'=> $notificInfo['code']);
$account_query = $con->prepare("SELECT `transaction_id`, `account_id`, `Rops` FROM `doacao` WHERE transaction_id = :transaction_id");
$account_query->execute($acc);
$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
if (!empty($account_info)){
	$account_info = array_shift($account_info);	
	$acc=array(':transaction_id'=> $notificInfo['code'], ':status'=> $notificInfo['status']);
	$add_compra_query = $con->prepare("UPDATE `doacao`SET `estado` = :status WHERE transaction_id = :transaction_id");
	$add_compra_query->execute($acc);
	$update=array(':Rops'=>$account_info->Rops, ':account_id'=>$account_info->account_id);
	$cash_update = $con->prepare("INSERT INTO `acc_reg_num` (`account_id`, `key`, `index`, `value`) VALUES(:account_id, '#CASHPOINTS', 0, :Rops) ON DUPLICATE KEY UPDATE value=value+:Rops");
	$cash_update->execute($update);
}
?>