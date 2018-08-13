<?php
	if ( $_SESSION["usuario"] &&  ( $_SESSION["usuario"]->group_id >= $level_admin )  ) :
        if(!empty($_POST) and (isset($_POST["proc-mail"]))){
		    $email = str_replace($letters, "", $_POST["email"]);
		    $dados = procuraEmail($con, $email);
		} else {
        	$dados ="" ;
	    }
    endif;
 ?>
<form action="" method="post" name="proc-mail" class="email proc-mail">
    <input type="hidden" name="aba" value="2">
    <label>
        <span class="label-content">E-mail</span>
        <input class="ipt" name="email" type="text" required="required">
        <input type="submit" value="Procurar" class="btn" name="proc-mail">
    </label>
</form>
<hr>
<div id="resultado">
	<?php echo $dados; ?>
</div>