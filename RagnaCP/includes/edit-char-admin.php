<?php
	if ( $_SESSION["usuario"] && $_SESSION["usuario"]->group_id >= $level_admin ) :
		if( !empty( $_POST ) and isset( $_POST['buscamarota'] ) ){
			$buscamarota = str_replace($letters, "", $_POST['buscamarota']);
			if ($buscamarota) {
                $conta = atualizaACC($con, $buscamarota);
            }
            if ( $conta ) :
            	if ( is_array( $conta ) ):
            		$edit = true;
            	else:
            		$resultado = $conta;
            	endif;
            endif;
		}
		if( !empty( $_POST ) and isset( $_POST['edit-account'] ) ){
			$id  = str_replace($letters, "", $_POST["edit-account_id"]);
            $pass = str_replace($letters, "", $_POST["edituser_pass"]);
            $login = str_replace($letters, "", $_POST["edituserid"]);
            $level = str_replace($letters, "", $_POST["editlevel"]);
            $mail = str_replace($letters, "", $_POST["editemail"]);
            $date = str_replace($letters, "", $_POST["editdate"]);
            $resultado = edit_account($con, $id, $pass, $login, $level, $mail, $date, $md5);
		}
	endif;	
?>
<form action="" name="proc-edit-account" method="POST" class="generic-form form-search-acc proc-edit-account">
	<input type="hidden" name="aba" value="5">
    <label>
        <span class='label-content'>Digite ACC ID :</span>
        <input type="search" class="ipt ipt-num" name="buscamarota" value='' id="buscamarota" required="required" placeholder="Procurar...">
        <input type="submit" name="proc-edit-account" class="btn proc-edit-account" value="Procurar">
    </label>
</form>
<hr>
<div class="form-editar">
	<form action='' name='edit-account' class='generic-form edit-char' method='post'>
		<input type="hidden" name="aba" value="5">
		<?php if ( $edit ): ?>
			<input name='edit-account_id' type='hidden' id="edit-accid" value="<?php echo $conta['iduser']; ?>">
			<label>
				<span class='label-content'>Id da Conta :</span> <span class='acc_id'><?php echo $conta['iduser']; ?></span>
			</label>
			<label class="login-edit">
		        <span class='label-content'>Login :</span>
		        <input class='ipt' name='edituserid' type='text' value='<?php echo $conta['user']; ?>' placeholder='fulano' required='required' value=''>
		    </label>
		    <label class="email-edit">
		        <span class='label-content'>E-mail :</span>
		        <input name='editemail' class='ipt' type='email' required='required' value='<?php echo $conta['email']; ?>' placeholder='fulano@provedor.com.br'>
		    </label>
		    <label class="date-edit">
		        <span class='label-content'>Data Nascimento :</span>
		        <input id="data" name='editdate' class='ipt' type='text' required='required'  value="<?php echo $conta['birthdate']; ?>" min='8' placeholder='1987-10-20' >
		    </label>
		    <label class="senha-edit">
		        <span class='label-content'>Senha :</span>
		        <input name='edituser_pass' class='ipt' type='text' required='required'  value="<?php echo $conta['user_pass']; ?>" min='6' placeholder='**********' >
		        <?php if( $md5  ):  ?><p>Padrão de senhas MD5 ligado</p> <?php endif; ?>
		    </label>
		    <label class="edit-level">
				<span class='label-content level_edit'>Group ID :</span>
		        <input pattern="{2}" name='editlevel' title="Maximo 2 numeros" class='ipt ipt-num' type='text' required='required'  value="<?php echo $conta['level']; ?>" min='6' placeholder='0'>
		    </label>
		<?php else: ?>
			<input name='edit-account_id' type='hidden' id="edit-accid" value=''>
			<label>
				<span class='label-content'>Id da Conta :</span> <span class='acc_id'></span>
			</label>
			<label class="login-edit">
		        <span class='label-content'>Login :</span>
		        <input class='ipt' name='edituserid' type='text' value='' placeholder='fulano' required='required' value=''>
		    </label>
		    <label class="email-edit">
		        <span class='label-content'>E-mail :</span>
		        <input name='editemail' class='ipt' type='email' required='required' value='' placeholder='fulano@provedor.com.br'>
		    </label>
		    <label class="date-edit">
		        <span class='label-content'>Data Nascimento :</span>
		        <input id="data" name='editdate' class='ipt' type='text' required='required'  value='' min='8' placeholder='1987-10-20' >
		    </label>
		    <label class="senha-edit">
		        <span class='label-content'>Senha :</span>
		        <input name='edituser_pass' class='ipt' type='text' required='required'  value='' min='6' placeholder='**********' >
		        <?php if( $md5  ):  ?><p>Padrão de senhas MD5 ligado</p> <?php endif; ?>
		    </label>
		    <label class="edit-level">
				<span class='label-content level_edit'>Group ID :</span>
		        <input pattern="{2}" name='editlevel' title="Maximo 2 numeros" class='ipt ipt-num' type='text' required='required'  value='' min='6' placeholder='0'>
		    </label>
		<?php endif; ?>
		<div class='box-footer'>
	        <div class='error-msg'>
				<div id="resultado3">
					<?php echo $resultado; ?>
				</div>
	        </div>
	        <input type='submit' value='Atualizar' class='btn' name='edit-account'>
	    </div>
	</form>
</div>