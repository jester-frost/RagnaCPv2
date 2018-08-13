<?php 
	if ( $_SESSION["usuario"] && $_SESSION["usuario"]->group_id >= $level_admin ) :
		if( !empty( $_POST ) and isset( $_POST['proc-ban-acc'] ) ){
			$ban_acc_id = str_replace($letters, "", $_POST['account-ban-id']);
			if ($ban_acc_id) {
                $conta = procuraACCban($con, $ban_acc_id);
            }
            if ( $conta ) :
            	if ( is_array( $conta ) ):
            		$edit = true;
            		$ban_type = array(
            			'' => 'Selecione',
        				'5' => 'Bloqueado',
        				'0' => 'Desbloqueado',
            		);
            		// Variaveis de calculo de data
			        $meudia = date("d",$conta['unban_time']);
					$meumes = date("m",$conta['unban_time']);
					$meuano = date("Y",$conta['unban_time']);
            	else:
            		$resultado = $conta;
            	endif;
            endif;
		}
		if( !empty( $_POST ) and isset( $_POST['ban-account'] ) ){
			$acc_id = str_replace($letters, "", $_POST['ban-account_id']);
            $dia = str_replace($letters, "", $_POST['dia']);
            $mes = str_replace($letters, "", $_POST['mes']);
            $ano = str_replace($letters, "", $_POST['ano']);
            $state = str_replace($letters, "", $_POST['block']);
            $results = banirACC($con, $acc_id, $dia, $mes, $ano, $state);
		}
	endif;
?>
<form action="" method="post" name="proc-ban-acc" class="generic-form proc-ban-acc">
	<input type="hidden" name="aba" value="7">
    <label>
        <span class="label-content">ACC ID</span>
        <input class="ipt ipt-num" name="account-ban-id" id="account-ban-id" type="text" placeholder="2000002" required="required">
        <input type="submit" value="Procurar" class="btn" name="proc-ban-acc">
    </label>
</form>
<div id="resultado-ban">
	<?php echo $results; ?>
</div>
<hr>
<div class="form-ban-char">
	<form action="" name="ban-account" class="generic-form ban-account" method="post">
		<input type="hidden" name="aba" value="7">
		<?php if ($edit): ?>
			<input name="ban-account_id" type="hidden" id="accid" value="<?php echo $conta['account_id'] ?>" required="required">
			<label>
				<span class="label-content">Id da Conta :</span> <span class="acc_id"><?php echo $conta['account_id']; ?></span>
			</label>
			<label>
				<span class="label-content">Login :</span> <span class="userid"><?php echo $conta['userid']; ?></span>
			</label>
			<label>
				<span class="label-content">Ultimo Login :</span> <span class="last_login"><?php echo $conta['lastlogin']; ?></span>
			</label>
			<label class="select-ban">
				<span class="label-content">Banir até :</span> 
				<?php
					function monta_select_mes($campo, $start, $end, $arg) {
						$mes['1'] = 'Janeiro';
						$mes['2'] = 'Fevereiro';
						$mes['3'] = 'Março';
						$mes['4'] = 'Abril';
						$mes['5'] = 'Maio';
						$mes['6'] = 'Junho';
						$mes['7'] = 'Julho';
						$mes['8'] = 'Agosto';
						$mes['9'] = 'Setembro';
						$mes['10'] = 'Outubro';
						$mes['11'] = 'Novembro';
						$mes['12'] = 'Dezembro';
						$select = "<select name='$campo' id='$campo' class='ipt' required='required'>";
						$select .= "<option value=''>---</option>";
						for($i = $start; $i <= $end; $i++) {	
							if ( $i == $arg ) :		
								$select .= "<option value=" .  $i ." selected='selected'>".$mes[$i]."</option>";
							else:
								$select .= "<option value=" .  $i .">".$mes[$i]."</option>";
							endif;
						} 							
						$select .= "</select>";
						return $select;	
					}
					function monta_select($campo, $start, $end, $arg) {
						$select = "<select name='$campo' id='$campo' class='ipt' required='required'>";
						$select .= "<option value=''>---</option>";
						for($i = $start; $i <= $end; $i++) {
							if ( $i == $arg ) :
								$select .= "<option value=".$i." selected='selected'>".$i."</option>";
							else:
								$select .= "<option value=".$i.">".$i."</option>";
							endif;
						}
						$select .= "</select>";
						return $select;	
					}
					$now   = new DateTime;
					$clone = $now;
					$ylimit = ($now->format( 'Y' ) + 6);
					$am = $now->format( 'm' );
					$limit31 = 31;
					$limit30 = 30;
					$limit29 = 29;
					$limit29 = 28;
					if($am == 1 ){
						$day_limit = $limit31; 
					}
					if($am == 2 ){
						if (($year % 4) === 0) {
							$day_limit = $limit29; 
						} else { 
							$day_limit = $limit28; 
						}
					} 
					if($am == 3 ){
						$day_limit = $limit31; 
					}
					if($am == 4 ){
						$day_limit = $limit30; 
					}
					if($am == 5 ){
						$day_limit = $limit31; 
					}
					if($am == 6 ){
						$day_limit = $limit30; 
					}
					if($am == 7 ){
						$day_limit = $limit31; 
					}
					if($am == 8 ){
						$day_limit = $limit31; 
					}
					if($am == 9 ){
						$day_limit = $limit30; 
					}
					if($am == 10 ){
						$day_limit = $limit31; 
					}
					if($am == 11 ){
						$day_limit = $limit30; 
					}else{
						$day_limit = $limit31;
					}
					//echo $tempo = mktime(0, 0, 0, $now->format( 'm' ), $now->format( 'd' ), $now->format( 'Y' ));
					//echo date("d/m/Y",1441843200); 
					echo monta_select("dia", 1, $day_limit, $meudia);	
					echo monta_select_mes("mes", 1, 12, $meumes);	
					echo monta_select("ano", $now->format( 'Y' ), $ylimit, $meuano);
				?>
			</label>
			<label>
		        <span class="label-content">Bloquear :</span>
		        <select class="ipt block" name="block" id="block" required="required">
		            <?php foreach ($ban_type as $key => $value): ?>
			        	<?php if ( $key == $conta['state'] ): ?>
			        		<option value='<?php echo $key; ?>' selected="selected"><?php echo $value; ?></option>
			        	<?php else: ?>
							<option value='<?php echo $key; ?>'><?php echo $value; ?></option>
			        	<?php endif ?>
			        <?php endforeach; ?>
		        </select>
		    </label>
		<?php else: ?>
			<input name="ban-account_id" type="hidden" id="accid" value="" required="required">
			<label>
				<span class="label-content">Id da Conta :</span> <span class="acc_id">N.D.A</span>
			</label>
			<label>
				<span class="label-content">Login :</span> <span class="userid">N.D.A</span>
			</label>
			<label>
				<span class="label-content">Ultimo Login :</span> <span class="last_login">N.D.A</span>
			</label>
			<label class="select-ban">
				<span class="label-content">Banir até :</span> 
				<?php
					function monta_select_mes($campo, $start, $end) {
						$mes['1'] = 'Janeiro';
						$mes['2'] = 'Fevereiro';
						$mes['3'] = 'Março';
						$mes['4'] = 'Abril';
						$mes['5'] = 'Maio';
						$mes['6'] = 'Junho';
						$mes['7'] = 'Julho';
						$mes['8'] = 'Agosto';
						$mes['9'] = 'Setembro';
						$mes['10'] = 'Outubro';
						$mes['11'] = 'Novembro';
						$mes['12'] = 'Dezembro';
						$select = "<select name='$campo' id='$campo' class='ipt' required='required'>";
						$select .= "<option value=''>---</option>";
						for($i = $start; $i <= $end; $i++) {	
							$select .= "<option value=" .  $i .">".$mes[$i]."</option>";
						} 							
						$select .= "</select>";
						return $select;	
					}
					function monta_select($campo, $start, $end) {
						$select = "<select name='$campo' id='$campo' class='ipt' required='required'>";
						$select .= "<option value=''>---</option>";
						for($i = $start; $i <= $end; $i++) {
							$select .= "<option value=".$i.">".$i."</option>";
						}
						$select .= "</select>";
						return $select;	
					}
					$now   = new DateTime;
					$clone = $now;
					$ylimit = ($now->format( 'Y' ) + 6);
					$am = $now->format( 'm' );
					$limit31 = 31;
					$limit30 = 30;
					$limit29 = 29;
					$limit29 = 28;
					if($am == 1 ){
						$day_limit = $limit31; 
					}
					if($am == 2 ){
						if (($year % 4) === 0) {
							$day_limit = $limit29; 
						} else { 
							$day_limit = $limit28; 
						}
					} 
					if($am == 3 ){
						$day_limit = $limit31; 
					}
					if($am == 4 ){
						$day_limit = $limit30; 
					}
					if($am == 5 ){
						$day_limit = $limit31; 
					}
					if($am == 6 ){
						$day_limit = $limit30; 
					}
					if($am == 7 ){
						$day_limit = $limit31; 
					}
					if($am == 8 ){
						$day_limit = $limit31; 
					}
					if($am == 9 ){
						$day_limit = $limit30; 
					}
					if($am == 10 ){
						$day_limit = $limit31; 
					}
					if($am == 11 ){
						$day_limit = $limit30; 
					}else{
						$day_limit = $limit31;
					}
					//echo $tempo = mktime(0, 0, 0, $now->format( 'm' ), $now->format( 'd' ), $now->format( 'Y' ));
					//echo date("d/m/Y",1441843200); 
					echo monta_select("dia", 1, $day_limit);	
					echo monta_select_mes("mes", 1, 12);	
					echo monta_select("ano", $now->format( 'Y' ), $ylimit);
				?>
			</label>
			<label>
		        <span class="label-content">Bloquear :</span>
		        <select class="ipt block" name="block" id="block" required="required">
		            <option value="">Selecione</option>
		            <option value="5">Bloqueado</option>
		            <option value="0">Desbloqueado</option>
		        </select>
		    </label>
		<?php endif; ?>
		<div class="box-footer">
	        <input type="submit" value="Atualizar" class="btn" name="ban-account">
	    </div>
	</form>
</div>