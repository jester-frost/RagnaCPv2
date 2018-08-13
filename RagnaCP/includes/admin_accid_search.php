<?php 
	if ( $_SESSION["usuario"] &&  ( $_SESSION["usuario"]->group_id >= $level_admin )  ) :
        if ( !empty($_POST) and isset($_POST["proc-acc"] ) ) {
        	$account_id = str_replace($letters, "", $_POST["account_id"]);
	        $dados_conta = procuraConta($con, $account_id);
        } else {
        	$dados_conta ="" ;
	    }
    endif;
 ?>
<form action="" method="post" name="proc-acc" class="generic-form  proc-acc">
    <input type="hidden" name="aba" value="1">
    <label>
        <span class="label-content">ID da Conta</span>
        <input class="ipt ipt-num" name="account_id" type="text" required="required">
        <input type="submit" value="Procurar" class="btn" name="proc-acc">
    </label>
</form>
<hr>
<div id="resultado">
	<?php echo $dados_conta; ?>
</div>