<?php 
	if ( $_SESSION["usuario"] &&  ( $_SESSION["usuario"]->group_id >= $level_admin )  ) :
        if(!empty($_POST) and isset($_POST["proc-ip"])){
	        $ip = str_replace($letters, "", $_POST["last_ip"]);
	        $dados = procuraip($con, $ip);
	    } else {
        	$dados ="" ;
	    }
    endif;
 ?>
<form action="" method="post" name="proc-ip" class="generic-form proc-ip">
    <input type="hidden" name="aba" value="3">
    <label>
        <span class="label-content">IP</span>
        <input class="ipt" name="last_ip" type="text" value="" placeholder="192.168.1.1" required="required">
        <input type="submit" value="Procurar" class="btn" name="proc-ip">
    </label>
</form>
<hr>
<div id="resultado">
	<?php echo $dados; ?>
</div>