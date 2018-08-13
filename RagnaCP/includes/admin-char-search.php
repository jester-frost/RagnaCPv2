<?php 
	if ( $_SESSION["usuario"] &&  ( $_SESSION["usuario"]->group_id >= $level_admin )  ) :
        if(!empty($_POST) and isset($_POST["proc-personagem"] ) ){
	        $char_name = str_replace($letters, "", $_POST["char_name"]);
            $dados = searchChar($con, $char_name);
	    } else {
        	$dados ="" ;
	    }
    endif;
?>
<form action="" method="post" name="proc-personagem" class="generic-form  proc-personagem">
    <input type="hidden" name="aba" value="4">
    <label>
        <span class="label-content">Nome do Char</span>
        <input class="ipt" name="char_name" type="text" required="required">
        <input type="submit" value="Procurar" class="btn" name="proc-personagem">
    </label>
</form>
<hr>
<div id="resultado">
	<?php echo $dados; ?>
</div>