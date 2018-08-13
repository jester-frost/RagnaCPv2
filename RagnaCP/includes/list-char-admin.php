<?php 
	if ( $_SESSION["usuario"] &&  ( $_SESSION["usuario"]->group_id >= $level_admin )  ) :
        if(!empty($_POST) and isset($_POST["proc-char-acc"] ) ){
	        $char_account_id = str_replace($letters, "", $_POST["account-char"]);
            $dados = charList($con, $char_account_id, $item_db);
	    } else {
        	$dados ="" ;
	    }
    endif;
 ?>
<form action="" method="post" name="proc-char-acc" class="generic-form proc-char-acc">
    <input type="hidden" name="aba" value="6">
    <label>
        <span class="label-content">ACC ID</span>
        <input class="ipt" name="account-char" type="text" placeholder="2000002" required="required">
        <input type="submit" value="Procurar" class="btn" name="proc-char-acc">
    </label>
</form>
<hr>
<div id="resultado-chars">
	<?php echo $dados; ?>
</div>