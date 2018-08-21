<?php

	/*====================================================*/
	// PHP INSANO COMEÇA AQUI !!!
	/*====================================================*/

	/*====================================================*/
	// funções administrativas
	/*====================================================*/

	function atualizaACC($con, $buscamarota) {
		$acc=array(':account_id'=>$buscamarota);
        $account_query = $con->prepare("SELECT `account_id`, `userid`, `sex`, `email`, `group_id`, `last_ip`, `unban_time`, `state`, `user_pass`, `lastlogin`, `birthdate` FROM `login` WHERE `account_id` = :account_id");
        $account_query->execute($acc);
        $account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
        if ($account_info) {
            foreach ($account_info as $account) :
            	$dados = array(
            		'iduser' => $account->account_id, 
            		'user' => $account->userid, 
            		'email' => $account->email, 
            		'level' => $account->group_id, 
            		'unban_time' => $account->unban_time, 
            		'user_pass' => $account->user_pass, 
            		'birthdate' => $account->birthdate,
            	);
            endforeach;
        } else {
        	$dados = "<p class='error-msg'> Conta não encontrada </p>";
		}
		return $dados;
	}

	function readitems($con, $item_db) {
		$resp[] = "None";
		$item_query = $con->prepare("SELECT `id`, `name_english`, `name_japanese` FROM `item_db`");
		$item_query->execute();
		$item_info = $item_query->fetchAll(PDO::FETCH_OBJ);
		foreach ($item_info as $item):
			if( $item->name_japanese ):
				$resp[$item->id] = $item->name_japanese;
			else:
				$resp[$item->id] = $item->name_english;
			endif;
		endforeach;
		$item_info_re = $item_query->fetchAll(PDO::FETCH_OBJ);
		$item_query_re = $con->prepare("SELECT `id`, `name_english`, `name_japanese` FROM `item_db_re`");
		$item_query_re->execute();
		$item_info_re = $item_query_re->fetchAll(PDO::FETCH_OBJ);
		foreach ($item_info_re as $item):
			if( $item->name_japanese ):
				$resp[$item->id] = $item->name_japanese;
			else:
				$resp[$item->id] = $item->name_english;
			endif;
		endforeach;
		return $resp;
	}



	function char_detail($con, $char_id){

		$acc=array(':char_id'=>$char_id);
		$har_info_query = $con->prepare("SELECT * FROM `char` WHERE `char_id` = :char_id ");
		$har_info_query->execute($acc);
		$char_info = $har_info_query->fetchAll(PDO::FETCH_OBJ);
		$items = readitems($con, $item_db);

		foreach ($char_info as $char) {
				$classe = $char->class;
				$id = $char->account_id;
			}

		$gender = array(
			'M' => "Male",
			'F' => "Female",
			'S' => "SuperUser"
		);

		$table1 .= "
				<table>
					<thead>
						<tr>
							<td class=\"head\"><h2>Informações do char</h2></td>
						</tr>
					</thead>
					<tbody>
			";
			foreach ($char_info as $char) {
				$table1.="
					<tr>
						<td align=\"right\" class=\"head\"><b>Nome: </b> &nbsp;</td><td align=\"left\">" . $char->name . " | ".$gender[$char->sex]."</td>
						<td align=\"right\" class=\"head\"><b>Level:</b> &nbsp;</td><td align=\"left\">" . $char->base_level . " / " . $char->job_level . "</td>
						<td align=\"right\" class=\"head\"><b>Zeny:</b> &nbsp;</td><td align=\"left\">" . $char->zeny . " z</td>
					<tr>
						<td align=\"right\" class=\"head\"><b>STR:</b> &nbsp;</td><td align=\"left\">" . $char->str . "</td>
						<td align=\"right\" class=\"head\"><b>AGI:</b> &nbsp;</td><td align=\"left\">" . $char->agi . "</td>
						<td align=\"right\" class=\"head\"><b>VIT:</b> &nbsp;</td><td align=\"left\">" . $char->vit . "</td>
					</tr>
					<tr>
						<td align=\"right\" class=\"head\"><b>INT:</b> &nbsp;</td><td align=\"left\">" . $char->int . "</td>
						<td align=\"right\" class=\"head\"><b>DEX:</b> &nbsp;</td><td align=\"left\">" . $char->dex . "</td>
						<td align=\"right\" class=\"head\"><b>LUK:</b> &nbsp;</td><td align=\"left\">" . $char->luk . "</td>
					</tr>
				"; 
			}
			$table1.="</tbody></table>";

			$acc2=array(':char_id'=>$char_id);
			$inventory_query = $con->prepare("SELECT `nameid`, `amount`, `card0`, `card1`, `card2`, `card3`, `refine` FROM `inventory` WHERE `char_id` = :char_id ");
			$inventory_query->execute($acc2);
			$inventory_char = $inventory_query->fetchAll(PDO::FETCH_OBJ);
			$table2 .= "
				<table>
					<thead>
						<tr>
							<td class=\"head\"><h2>Inventário</h2></td>
						</tr>
						<tr>
							<th align=\"center\" class=\"head\">Item</th>
							<th align=\"center\" class=\"head\">Quantia</th>
							<th align=\"center\" class=\"head\">Refinamento</th>
							<th align=\"center\" class=\"head\">Card1</th>
							<th align=\"center\" class=\"head\">Card2</th>
							<th align=\"center\" class=\"head\">Card3</th>
							<th align=\"center\" class=\"head\">Card4</th>
						</tr>
					</thead>
					<tbody>
			";
			foreach ($inventory_char as $inventory) {
				$table2.="
						<tr>
							<td align=\"center\" class=\"head\">". $items[$inventory->nameid] ."</td>
							<td align=\"center\" class=\"head\">". $inventory->amount ."</td>
							<td align=\"center\" class=\"head\">". $inventory->refine ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card0] ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card2] ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card2] ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card3] ."</td>
						</tr>
				"; 
			}
			$table2.="</tbody></table>";
			$acc3=array(':account_id'=>$id);
			$storage_query = $con->prepare("SELECT `nameid`, `amount`, `card0`, `card1`, `card2`, `card3`, `refine` FROM `storage` WHERE `account_id` = :account_id ");
			$storage_query->execute($acc3);
			$storage_char = $storage_query->fetchAll(PDO::FETCH_OBJ);
			$table4 .= "
				<table>
					<thead>
						<tr>
							<td class=\"head\"><h2>Storage</h2></td>
						</tr>
						<tr>
							<th align=\"center\" class=\"head\">Item</th>
							<th align=\"center\" class=\"head\">Quantia</th>
							<th align=\"center\" class=\"head\">Refinamento</th>
							<th align=\"center\" class=\"head\">Card1</th>
							<th align=\"center\" class=\"head\">Card2</th>
							<th align=\"center\" class=\"head\">Card3</th>
							<th align=\"center\" class=\"head\">Card4</th>
						</tr>
					</thead>
					<tbody>
			";
			foreach ($storage_char as $inventory) {
				$table4.="
						<tr>
							<td align=\"center\" class=\"head\">". $items[$inventory->nameid] ."</td>
							<td align=\"center\" class=\"head\">". $inventory->amount ."</td>
							<td align=\"center\" class=\"head\">". $inventory->refine ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card0] ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card2] ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card2] ."</td>
							<td align=\"center\" class=\"head\">". $items[$inventory->card3] ."</td>
						</tr>
				"; 
			}
			$table4.="</tbody></table>";
			switch ($classe) {
				case 5:
				case 10:
				case 18:
				case 4006:
				case 4011:
				case 4019:
				case 4028:
				case 4033:
				case 4041:
				case 4058:
				case 4064:
				case 4071:
				case 4078:
				case 4086:
				case 4087:
				case 4107:
				case 4100:
				case 4112: 
					$acc4=array(':char_id'=>$char_id);
					$cart_query = $con->prepare("SELECT `nameid`, `amount`, `card0`, `card1`, `card2`, `card3`, `refine` FROM `cart_inventory` WHERE `char_id` = :char_id ");
					$cart_query->execute($acc4);
					$cart_char = $cart_query->fetchAll(PDO::FETCH_OBJ);
					$table3 .= "
						<table>
							<thead>
								<tr>
									<td class=\"head\"><h2>CART</h2></td>
								</tr>
								<tr>
									<th align=\"center\" class=\"head\">Item</th>
									<th align=\"center\" class=\"head\">Quantia</th>
									<th align=\"center\" class=\"head\">Refinamento</th>
									<th align=\"center\" class=\"head\">Card1</th>
									<th align=\"center\" class=\"head\">Card2</th>
									<th align=\"center\" class=\"head\">Card3</th>
									<th align=\"center\" class=\"head\">Card4</th>
								</tr>
							</thead>
							<tbody>
					";
					foreach ($cart_char as $storage) {
						$table3.="
								<tr>
									<td align=\"center\" class=\"head\">". $items[$storage->nameid] ."</td>
									<td align=\"center\" class=\"head\">". $storage->amount ."</td>
									<td align=\"center\" class=\"head\">". $storage->refine ."</td>
									<td align=\"center\" class=\"head\">". $items[$storage->card0] ."</td>
									<td align=\"center\" class=\"head\">". $items[$storage->card2] ."</td>
									<td align=\"center\" class=\"head\">". $items[$storage->card2] ."</td>
									<td align=\"center\" class=\"head\">". $items[$storage->card3] ."</td>
								</tr>
						"; 
						
					}
					$table3.="</tbody></table>";

				default:
				break;
			}
		$html .= "
				<div class='mask'>
				    <div class='information-char'>";
		$html .= $table1;
		$html .= $table2;	
		$html .= $table4;	
		$html .= $table3;		        
		$html .= " </div>
				</div>";
		return $html;
	}

	function charList($con, $char_account_id, $item_db){
		include("jobs.php");
		$acc=array(':account_id'=>$char_account_id);
		$account_query = $con->prepare("SELECT `char_id`, `char_num`, `name`, `class`, `base_level`, `job_level`, `online`, `last_map`, `last_x`, `last_y` FROM `char` WHERE `account_id` = :account_id ORDER BY `char_num`");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
		
		if ($account_info ) {
			$html .= "<table> <thead><tr><th>ID</th><th>Nome</th><th>Classe</th><th>Level</th><th>Estatus</th> <th>Mapa</th><th>Detalhes</th></tr></thead>";
			$html .= "<tbody>";
			foreach ($account_info as $dado) {

				$char_id = $dado->char_id;

				if($dado->online == 0) { $onlines = "<font color='red' face='Verdana'> OFFLINE </font>";}
	            if($dado->online == 1) { $onlines = "<font color='green' face='Verdana'> ONLINE </font>";}


				$html .= "<tr>";
				$html .= "<td><div align='center'>". $dado->char_id ."</div></td>";
				$html .= "<td><div align='center'>". $dado->name ."</div></td>";
				$html .= "<td><div align='center'>". $job[$dado->class] ."</div></td>";
				$html .= "<td><div align='center'>". $dado->base_level ." / ". $dado->job_level ."</div></td>";
				$html .= "<td><div align='center'>". $onlines ."</div></td>";
				$html .= "<td><div align='center'>". $dado->last_map ." ". $dado->last_x ." ". $dado->last_y ."</div></td>";
				$html .= "<td><div align='center'><a href='". $dado->char_id ."' class='char-detail'>Detalhes" . char_detail($con, $char_id) . "</a></div></td>";
			}
			$html .= "</tbody>";
			$html .= "</table>";

			$dados = $html;

		} else {
			$dados = "<p class='error-msg'>Conta não encontrada</p>";
		}
		return $dados;
	}

	function procuraACCban($con, $ban_acc_id){

		$acc=array(':account_id'=>$ban_acc_id);
		$account_query = $con->prepare("SELECT * FROM `login`  WHERE `account_id` = :account_id ");
		$account_query->execute($acc);
		$acc_info = $account_query->fetchAll(PDO::FETCH_OBJ);
			$now   = new DateTime;
			$clone = $now;
		if($acc_info){

			foreach ($acc_info as $acc) {

				$user = $acc->userid;
				$accid = $acc->account_id;
				$last = $acc->lastlogin;
				$stt = $acc->state;
				$time = $acc->unban_time; 
				if($acc->unban_time <= 0){
					$time = mktime(0, 0, 0, $now->format( 'm' ), $now->format( 'd' ), $now->format( 'Y' ));
				}
			}

			

			$dia = date("d",$time); 
			$mes = date("m",$time); 
			$ano = date("Y",$time); 


			$arr = array('dia'=>$dia,'mes'=>$mes,'ano'=>$ano,'userid' => $user, 'account_id' => $accid, 'lastlogin' => $last, 'unban_time' => $time, 'state' => $stt);
           	$dados = $arr;
        }else{
        	$dados = "<p class='error-msg'> Conta não encontrada</p>";
		}
		return $dados;
	}

	function banirACC($con, $acc_id, $dia, $mes, $ano, $state){
		

		$now   = new DateTime;
		$clone = $now;

		// evitando merda ..
		$acc_id = preg_replace('/[^[:alnum:]_]/', '',$acc_id);

		$acc=array(':account_id'=>$acc_id);
		$account_query = $con->prepare("SELECT * FROM `login`  WHERE `account_id` = :account_id ");
		$account_query->execute($acc);
		$acc_info = $account_query->fetchAll(PDO::FETCH_OBJ);
		foreach ($acc_info as $acc) {
			$atual_state = $acc->state;
		}

		// Se o bolovo ja estiver com a conta bloqueada ... não da pra bloquear de novo né ...
		if ($atual_state == 5) {
			$block_ban = $atual_state;
		}

		if( ( $dia < $now->format( 'd' ) ) || ( $mes < $now->format( 'm' ) ) || ( $ano < $now->format( 'Y' ) ) ){
			$msg = "";
			if ( $dia < $now->format( 'd' ) ) {
				$msg = " um dia menor que hoje";
			}
			if ( $mes < $now->format( 'm' ) ) {
				if ($msg != ""){
					$msg .= ", e um mês menor que o atual";
				}else{
					$msg = " um mês menor que o atual";
				}
			}
			if ( $ano < $now->format( 'y' ) ) {
				if ($msg != ""){
					$msg .= ", e um ano menor que o atual";
				}else {
					$msg = " um ano menor que o atual";
				}
			}

			$dados = "<p class='error-msg'>Não pode escolher ".$msg.".</p>";
		} if( $state == $block_ban ){
			$dados = "<p class='error-msg'>A conta já se encontra Bloqueada.</p>";
		} else {

			$time = mktime(0, 0, 0, $mes, $dia, $ano);

			if($acc_info){

				// ia fazer uma maluquice aqui .. mais depois faço
				//$diab = date("d",$time); 
				//$mesb = date("m",$time); 
				//$anob = date("Y",$time);

				$acc=array(':account_id'=>$acc_id);
				$ban_query = $con->prepare("UPDATE `login` SET `unban_time` = $time, `state` = $state WHERE `account_id` = :account_id");
				$ban_query->execute($acc);

				$dados = "<p class='sucess-msg'>Penalidade aplicada</p>";
			} else{ 
				
				$dados = "<p class='error-msg'>Conta Não encontrada</p>";
			}

		}
		return $dados;
	}

	function automatic_ban($con, $acc_id){

		// Um ban absurdo pra eu saber se essa bicha tentou fazer merda mesmo de propósito
		$dia = 30; 
		$mes = 12;
		$ano = 2999;
		$state = 5;

		$time = mktime(0, 0, 0, $mes, $dia, $ano);

		$acc=array(':account_id'=>$acc_id);
		$ban_query = $con->prepare("UPDATE `login` SET `unban_time` = $time, `state` = $state WHERE `account_id` = :account_id");
		$ban_query->execute($acc);

		$msg ="Querendo ser malandro né !! FDP, agora vou comer seu CU !!, primeiro vou Banir sua conta .. depois vou comer seu Cu com areia e sem vazelina !! como se diz no GTAV <p class='fdp'>SE FODEU !!</p>";
		return $msg;
	}



	function procuraip($con, $ip){
		$acc=array(':last_ip'=>$ip);
		$account_query = $con->prepare("SELECT * FROM `login` WHERE `last_ip` = :last_ip");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);

		if ($account_info) {

			$html .= "<table> <thead><tr><th>ID</th><th>Login</th><th>Genero</th><th>IP</th><th>BAN</th><th>Char Info</th></tr></thead>";
			$html .= "<tbody>";
			foreach ($account_info as $dado) {
				$html .= "<tr>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-edit' >" . $dado->account_id . "</a></div></td>";
				$html .= "<td><div align='center'>" . $dado->userid . "</div></td>";
				$html .= "<td><div align='center'>" . $dado->sex . "</div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->last_ip . "' class='ip-to-search' >" . $dado->last_ip . "</a></div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-ban' >Ban / Unban </a></div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='char-id-to-edit' >Char Info</a></div></td>";
				
			}
			$html .= "</tbody>";
			$html .= "</table>";
			$dados = $html;
			
		} else {
			$dados = "<p class='error-msg'> Conta não encontrada </p>";
		}
		return $dados;
	}



	function searchChar($con, $char_name){
		
		include("jobs.php");
		
		$acc=array(':name'=>$char_name);
		$string = preg_replace('/[^[:alnum:]_]/', '',$char_name);
		$account_query = $con->prepare("SELECT `account_id`, `char_id`, `char_num`, `name`, `class`, `base_level`, `job_level`, `online`, `last_map`, `last_x`, `last_y` FROM `char`  WHERE `name` Like '$string%' ORDER BY `account_id`");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
		
		if ($account_info ) {
			$html .= "<table> <thead><tr><th>ACC</th><th>Nome</th><th>Classe</th><th>Level</th><th>Estatus</th> <th>Mapa</th><th>Detalhes</th></tr></thead>";
			$html .= "<tbody>";
			foreach ($account_info as $dado) {

				$char_id = $dado->char_id;

				if($dado->online == 0) { $onlines = "<font color='red' face='Verdana'> OFFLINE </font>";}
	            if($dado->online == 1) { $onlines = "<font color='green' face='Verdana'> ONLINE </font>";}


				$html .= "<tr>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-edit' >" . $dado->account_id . "</a></div></td>";
				$html .= "<td><div align='center'>". $dado->name ."</div></td>";
				$html .= "<td><div align='center'>". $job[$dado->class] ."</div></td>";
				$html .= "<td><div align='center'>". $dado->base_level ." / ". $dado->job_level ."</div></td>";
				$html .= "<td><div align='center'>". $onlines ."</div></td>";
				$html .= "<td><div align='center'>". $dado->last_map ." ". $dado->last_x ." ". $dado->last_y ."</div></td>";
				$html .= "<td><div align='center'><a href='". $dado->char_id ."' class='char-detail'>Detalhes" . char_detail($con, $char_id) . "</a></div></td>";
			}
			$html .= "</tbody>";
			$html .= "</table>";

			$dados = $html;

		} else {
			$dados = "<p class='error-msg'>Personagem Não Encontrado</p>";
		}
		return $dados;
	}




	function procuraEmail($con, $email){
		$acc=array(':email'=>$email);
		$account_query = $con->prepare("SELECT `account_id`, `userid`, `sex`, `email`, `group_id`, `last_ip`, `unban_time`, `state`, `user_pass`, `lastlogin`, `birthdate` FROM `login` WHERE `email` = :email");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);

		if ($account_info) {

			$html .= "<table> <thead><tr><th>ID</th><th>Login</th><th>Genero</th><th>IP</th><th>BAN</th><th>Char Info</th></tr></thead>";
			$html .= "<tbody>";
			foreach ($account_info as $dado) {
				$html .= "<tr>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-edit' >" . $dado->account_id . "</a></div></td>";
				$html .= "<td><div align='center'>" . $dado->userid . "</div></td>";
				$html .= "<td><div align='center'>" . $dado->sex . "</div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->last_ip . "' class='ip-to-search' >" . $dado->last_ip . "</a></div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-ban' >Ban / Unban </a></div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='char-id-to-edit' >Char Info</a></div></td>";
				
			}
			$html .= "</tbody>";
			$html .= "</table>";

			$dados = $html;
		} else {
			$dados = "<p class='error-msg'> Conta não encontrada </p>";
		}
		return $dados;
	}
	


	function procuraConta($con, $account_id){
		$acc=array(':account_id'=>$account_id);
		$account_query = $con->prepare("SELECT `account_id`, `userid`, `sex`, `email`, `group_id`, `last_ip`, `unban_time`, `state`, `user_pass`, `lastlogin`, `birthdate` FROM `login` WHERE `account_id` = :account_id");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);

		if ($account_info) {
			$html .= "<table> <thead><tr><th>ID</th><th>Login</th><th>Genero</th><th>IP</th><th>BAN</th><th>Char Info</th></tr></thead>";
			$html .= "<tbody>";
			foreach ($account_info as $dado) {
				$html .= "<tr>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-edit' >" . $dado->account_id . "</a></div></td>";
				$html .= "<td><div align='center'>" . $dado->userid . "</div></td>";
				$html .= "<td><div align='center'>" . $dado->sex . "</div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->last_ip . "' class='ip-to-search' >" . $dado->last_ip . "</a></div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='acc-id-to-ban' >Ban / Unban </a></div></td>";
				$html .= "<td><div align='center'><a href='" . $dado->account_id . "' class='char-id-to-edit' >Char Info</a></div></td>";
				
			}
			$html .= "</tbody>";
			$html .= "</table>";

			$dados = $html;
		} else {
			$dados = "<p class='error-msg'> Conta não encontrada </p>";
		}
		return $dados ;
	}

	function LimparTexto($letters, $texto){
		$texto=str_replace($letters, "", $texto);
	return $texto;
	}

	function edit_account($con, $id, $pass, $login, $level, $mail, $date, $md5){
		if( $md5 ):
			$pass = md5($pass);
		endif;
		$acc_id = preg_replace('/[^[:alnum:]_]/', '',$id);
		$account_query = $con->prepare("SELECT account_id FROM `login` WHERE account_id = $acc_id");
		$account_query->execute();
		$account = $account_query->fetchAll(PDO::FETCH_OBJ);
		if ($account) {
			$acc_id=array(':account_id'=>$id, ':userid'=>$login, ':user_pass'=>$pass,':email'=>$mail, ':level'=>$level, ':birthdate'=>$date );
			$account_query = $con->prepare("UPDATE `login` SET `userid` = :userid, `user_pass` = :user_pass, `email` = :email, `group_id` = :level, `birthdate` = :birthdate  WHERE `account_id`= :account_id");
			$account_query->execute($acc_id);
			$dados = "<p class='sucess-msg'> Conta Atualizada </p>";
			$dados;
		} else {
			$dados = "<p class='error-msg'> Por algum motivo Sinistro não te encontrei ... oh fuck ...</p>";
		}
		return $dados;
	}

	/*====================================================*/
	// fim de funções administrativas
	/*====================================================*/

	/*====================================================*/
	//  Vote por Pontos
	/*====================================================*/

	function abrelink($url){
		echo "<script language='javascript'> window.open('".$url."', '_blank'); </script>";
	}


	function vote_points($con, $site, $acc_id, $points_for_click, $tempo, $links){
		$accid=array(':account_id'=>$acc_id);
		$search_vote_update = $con->prepare('SELECT `point`, `last_vote'.$site.'` FROM `vote_point` WHERE account_id=:account_id');
		$search_vote_update->execute($accid);
		$vote=$search_vote_update->fetchAll(PDO::FETCH_OBJ);
		$date = new DateTime();

		// verificando se o cidadão ja votou

		$atribute = 'last_vote'.$site;
		
		foreach ($vote as $v) {
			$point = $v->point;
			$last_vote = $v->$atribute;
		}
			
		// se ele ja votou vai atualizar om as condições la em baixo
		if($vote) {

			if ( time() - $last_vote > ( 60 * 60 * $tempo )  ){
				$date = new DateTime();
				$search_vote_update = $con->prepare("UPDATE `vote_point` SET `point` = ".($point + $points_for_click)." , `last_vote".$site."` = ".time().", `date` = '".$date->format('d-m-y H:i')."' WHERE  `account_id` = ".$acc_id." ");
				$search_vote_update->execute($accid);
				$votes = "Ganhou +".$points_for_click." pontos";
				$url = array_values($links)[$site-1];
				abrelink($url);
			}else{
				// alguns servidores podem nao efetuar a operação $last_time = (60 * 60 * $tempo) - time() - $last_vote ;
				$votes = "Não ganhou pontos <br>";
				$faltam = date("H:i:s", mktime(0, 0, ( (60 * 60 * $tempo) - time() + $last_vote ) ) );
				$votes .= " faltam ".$faltam. " para votar novamente.";
			}
		// se não votou vai cair aqui
		} else {
			$vote_query = $con->prepare('INSERT INTO `vote_point`(`account_id`, `point`, `last_vote'.$site.'`,`date`) VALUES (:account_id,'.$points_for_click.','.time().',"'.$date->format('d-m-y H:i').'")');
			$vote_query->execute($accid);
			$votes = "Ganhou +".$points_per_click." pontos";
			$url = array_values($links)[$site-1];
			abrelink($url);
		}
		// retorna as mensagens*/
		return $votes;
	}





	/*====================================================*/
	// Transferir dingos Function
	/*====================================================*/
	function transferir($con, $char_id, $dinheiro, $char_destino){
		$dinheiro = preg_replace("/[^0-9\s]/", '',$dinheiro);
		$char=array(':char_id'=>$char_id);
		$search_player_query = $con->prepare("SELECT zeny FROM `char` WHERE char_id=:char_id");
		$search_player_query->execute($char);
		$usuario=$search_player_query->fetchall(PDO::FETCH_OBJ);
		foreach ($usuario as $u) {
			$qtd = $u->zeny;
		}
		$char2=array(':char_id2'=>$char_destino);
		$search_player_destiny = $con->prepare("SELECT zeny FROM `char` WHERE char_id=:char_id2");
		$search_player_destiny->execute($char2);
		$usuario2=$search_player_destiny->fetchall(PDO::FETCH_OBJ);
		foreach ($usuario2 as $u) {
			$qtd_destino = $u->zeny;
		}
		if ($dinheiro > $qtd) {
			$msg = "Não pode depositar um valor acima do que voê possui em conta.";
		} else {
			// subtraindo do char 
			$subtracao = $qtd - $dinheiro;
			// Somando o dingos pro cara
			$somando = $qtd_destino + $dinheiro;
			$player1=array(':char_id'=>$char_id);
			$pq = $con->prepare("UPDATE `char` SET `zeny` = $subtracao WHERE `char_id`=:char_id");
			$pq->execute($player1);
			$player2=array(':char_destino'=>$char_destino);
			$pq2 = $con->prepare("UPDATE `char` SET `zeny` = $somando WHERE `char_id`=:char_destino");
			$pq2->execute($player2);
			$msg = "Depósito efetuado com Exito !";
		}
		return $msg;
	}
	/*====================================================*/
	// Divórcio Function
	/*====================================================*/
	function divorcio($con, $char_id, $partner_id){
		$valor=array(':char_id'=>$char_id);
		$player_query = $con->prepare("UPDATE `char` SET `partner_id` = '0' WHERE `char_id`=:char_id");
		$player_query2 = $con->prepare("DELETE FROM `inventory` WHERE (`nameid` = '2634' OR `nameid` = '2635') AND `char_id` = $char_id");
		$player_query->execute($valor);
		$player_query2->execute($valor);
		$msg = 'Char Divorciado.';
		return $msg;
	}
	/*====================================================*/
	// Resetar posição Function
	/*====================================================*/
	function resetar_posicao($con, $char_id){
        $valor=array(':char_id'=>$char_id);
		$player_query = $con->prepare("UPDATE `char` SET last_map='prontera', last_x='115', last_y='155'  WHERE char_id=:char_id");
		$player_query->execute($valor);
		$msg = "Posição do personagem foi resetada !";
		return $msg;
	}
	function resetar_cabelo($con, $char_id){
        $valor=array(':char_id'=>$char_id);

        $search_char_query = $con->prepare("SELECT * FROM `char` WHERE char_id=:char_id");
		$search_char_query->execute($valor);
		$char = $search_char_query->fetch(PDO::FETCH_OBJ);
        if( $char->class == 4218 || $char->class ==  4220 ){
        	$hair = 31;
        }else{
        	$hair = 0;
        }
		$player_query = $con->prepare("UPDATE `char` SET `hair_color` = '1', `hair` = '".$hair."', `clothes_color` = '1' WHERE `char_id`=:char_id");
		$player_query->execute($valor);
		$msg = "Aparência do personagem foi resetada !";
		return $msg;
	}

	function resetar_equip($con, $char_id){
        $valor=array(':char_id'=>$char_id);
		$player_query = $con->prepare("UPDATE `char` SET `weapon` = '0', `shield` = '0', `robe` = '0', `head_top` = '0', `head_mid` = '0', `head_bottom` = '0' WHERE `char_id`=:char_id");
		$equip_query = $con->prepare("UPDATE `inventory` SET `equip` = '0' WHERE `char_id`=:char_id");
		$player_query->execute($valor);
		$equip_query->execute($valor);
		$msg = "Equipamentos do personagem foram removidos !";
		return $msg;
	}

	/*====================================================*/
	// Resetar Senha Function
	/*====================================================*/
	function mudar_senha($con, $userid, $user_pass, $new_pass, $confirm_new_pass ){
		$dados = array(':userid'=>$userid);
		$search_player_query = $con->prepare("SELECT * FROM `login` WHERE userid=:userid");
		$search_player_query->execute($dados);
		$usuario = $search_player_query->fetchAll(PDO::FETCH_OBJ);
		if ( $usuario ) {
    		$user_pass=str_replace(array($letters), "", $new_pass);
			$valores=array(':userid'=>$userid, ':new_pass'=>$new_pass);
			$add_player_query = $con->prepare("UPDATE login SET user_pass = :new_pass WHERE userid=:userid");
			$add_player_query->execute($valores);
			$msg="a senha foi mudada ";
			unset($_SESSION["usuario"]);
			session_destroy();
			wp_redirect( get_the_permalink() );
		} else {
			$msg = "Por algum motivo bizarro, te procurei e não encontrei ...";
		}
		return $msg;
	}

	/*====================================================*/
	// Cadastrar Function
	/*====================================================*/

	function registrar($con, $userid, $user_pass, $confirm_user_pass, $email, $sex, $date, $letters){
		$dados=array(':userid'=>$userid);
		$search_player_query = $con->prepare("SELECT * FROM login WHERE userid=:userid");
		$search_player_query->execute($dados);
		$usuario=$search_player_query->fetchall(PDO::FETCH_OBJ);
		if ($usuario) {
			$msg = "Usuario já Cadastrado, tente usar um Login diferente";
		} elseif ($_POST["user_pass"] == $_POST["confirm_user_pass"]){
			$userid=str_replace(array($letters), "", $userid);
		    $user_pass=str_replace(array($letters), "", $user_pass);
		   if ($userid != "" && $user_pass != "") {
				/* Mandando variaveis para um array associativo (dicionario igual do python) */
				$cadastrar=array(':userid'=>$userid, ':user_pass'=>$user_pass, ':sex'=>$sex, ':email'=>$email, ':birthdate'=>$date);
				$add_player_query = $con->prepare("INSERT INTO `login`(userid,user_pass,email,sex,birthdate) VALUES(:userid, :user_pass, :email, :sex, :birthdate) ");
				$add_player_query->execute($cadastrar);
				$msg = "Usuario Cadastrado com Sucesso !";
		   	}else {
		   		$msg = "Usuario ou Senha estão vazios, por uso de caracteres indevidos, tente novamente criar sua conta com caracteres válidos.";
		   	}
		}else{
			$msg = "Senhas não conferem, por favor tente novamente !";
		}
		return $msg;
	}
		
	/*====================================================*/
	// Funções genéricas
	/*====================================================*/


	function account_gender($con, $account_id){
		$dados=array(':account_id'=>$account_id);
		$account_query = $con->prepare("SELECT account_id, userid, user_pass, sex, email FROM `login` WHERE account_id = :account_id");
		$account_query->execute($dados);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
		foreach ($account_info as $info) {
			$sex = ($info->sex);
			return $sex;
		}
	}

	function char_info($con, $char_id){
		include("jobs.php");
		$char_query = $con->prepare("SELECT char_id, hair, account_id, name, sex, class, base_level, job_level FROM `char` WHERE char_id = $char_id");
		$char_query->execute();
		$chars = $char_query->fetchAll(PDO::FETCH_OBJ);

		foreach ($chars as $c) {
			$account_id =  $c->account_id;
			echo "<div class='info'>
				<div class='pvp-char'>
					<img src='". get_template_directory_uri()  ."/chargen/avatar/". $c->name ."'/> 
				</div>";
		}
	}
                                            
	function carrega_rankPVP($con){
		/* Preparando array que evita SQL injection */
		$pvp_query = $con->prepare("SELECT char_id, name, kills, deaths FROM pvp ORDER BY kills DESC LIMIT 10");
		/* procurando query no Banco*/
		$pvp_query->execute();
		$dados=$pvp_query->fetchAll(PDO::FETCH_OBJ);
		$classe = $dados;
		foreach ($classe as $dado) {
			$char_id = $dado->char_id;
		}
		return $dados; $char_id; $char_info;
	}

	/*====================================================*/
	//  Login Function
	/*====================================================*/

	function login($con, $userid, $user_pass, $md5){
		if( $md5 ){
			$user_pass = md5( $user_pass );
		}
		$dados=array(':userid'=>$userid,':user_pass'=>$user_pass);
		/* Preparando array que evita SQL injection */
		$p_query = $con->prepare("SELECT * FROM login WHERE userid=:userid and user_pass=:user_pass");
		$p_query->execute($dados);
		$usuario=$p_query->fetch(PDO::FETCH_OBJ);
		$error_data = false;
		if ($usuario) {
			ini_set('default_charset','UTF-8');
			$_SESSION["usuario"]=$usuario;
		}else {
			$msg="Ooops! alguma coisa está errada ...";
			$error = "<p class='error'>" . $msg . "</p>";
		}
		return $error;
	}


	/*====================================================*/
	//  Ranks e TOPs gerais
	/*====================================================*/

	// TOP Player
	function topplayer($con, $string, $level_admin){
		include('jobs.php');
	    $char_query = $con->prepare("SELECT `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `char`.`account_id`, `char`.`guild_id`, `guild`.`name` as guildname FROM `char` LEFT JOIN `guild`  ON `char`.`guild_id` = `guild`.guild_id LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` where `login`.`group_id` < '".$level_admin."' AND `login`.`state` != '5' ORDER BY `char`.`base_level` DESC, `char`.`job_level` DESC LIMIT 0, 100 ");
	    $char_query->execute();
	    $chars = $char_query->fetchAll(PDO::FETCH_OBJ);
		return $chars;
	}

	// TOP ZENY
	function topzeny($con, $string, $level_admin){
		include('jobs.php');
	    $char_query = $con->prepare("SELECT `char`.`account_id`, `name`, `zeny`, `online`, `base_level`, `job_level`, `class`, `login`.`account_id` as loginid FROM `char` LEFT JOIN `login` on  `char`.`account_id` = `login`.`account_id` where `login`.`group_id` < '".$level_admin."' ORDER BY `zeny` DESC LIMIT 20;");
	    $char_query->execute();
	    $chars = $char_query->fetchAll(PDO::FETCH_OBJ);
		return $chars;
	}

	// TOP Guild Guildas
	function topguild($con){
		// Primeira Query
		$guild_query = $con->prepare("SELECT `guild`.`guild_id`, `guild`.`name`, `guild`.`master`, `guild`.`emblem_data`, `guild`.`guild_lv`, `guild`.`exp`, `guild`.`guild_id`, `guild`.`average_lv`, count(`guild_member`.`name`), (count(`guild_member`.`name`) * `guild`.`average_lv`) as gmate FROM `guild` LEFT JOIN `guild_member` ON `guild`.`guild_id` = `guild_member`.`guild_id` GROUP BY `guild_member`.`guild_id` ORDER BY `guild`.`guild_lv` DESC, `guild`.`exp` DESC, `gmate` DESC LIMIT 0, 50	");
	    $guild_query->execute();
	    $guild = $guild_query->fetchAll(PDO::FETCH_OBJ);
		return $guild;
	}

	// TOP Guild Castelos
	function topcastle($con){
		// Segunda Query
	    $castle_query = $con->prepare("SELECT `guild`.`name`,`guild`.`master`, `guild`.`emblem_data`, `guild_castle`.`castle_id`, `guild`.`guild_id`
		FROM `guild_castle` LEFT JOIN `guild` ON `guild`.`guild_id` = `guild_castle`.`guild_id` ORDER BY (`guild_castle`.`castle_id` * 1) DESC LIMIT 0, 50");
		$castle_query->execute();
	    $castle = $castle_query->fetchAll(PDO::FETCH_OBJ);
		return $castle;
	}
	
	// TOP homunculu
	function tophom($con){
		$hom_query = $con->prepare("SELECT `homunculus`.`name`, `homunculus`.`class`, `homunculus`.`level`, `homunculus`.`char_id`, `homunculus`.`intimacy`, `char`.`name` as 'charname' FROM `homunculus` INNER JOIN `char` on `homunculus`.`char_id` = `char`.char_id  ORDER BY `homunculus`.`level` DESC, `homunculus`.`intimacy` DESC LIMIT 0, 20 ");
	    $hom_query->execute();
	    $homunculos = $hom_query->fetchAll(PDO::FETCH_OBJ);
		return $homunculos;
	}

	// TOP MVPS
	function topmvp($con){
		$char_query = $con->prepare("SELECT * FROM `rank_mvp` LEFT JOIN `char` ON `char`.`char_id` = `rank_mvp`.`char_id`  ORDER BY `pontos_mvp` DESC LIMIT 0, 100");
	    $char_query->execute();
	    $chars = $char_query->fetchAll(PDO::FETCH_OBJ);
	    return $chars;
	}

	/*====================================================*/
	//  Tabela de Doações
	/*====================================================*/

	function doacaoPaga($con, $id){
		$doacao_query = $con->prepare("SELECT * FROM `doacao` WHERE account_id = ".$id." AND `estado` = 3 ");
	    $doacao_query->execute();
	    $doacoes = $doacao_query->fetchAll(PDO::FETCH_OBJ);
	    return $doacoes;
	}

	function doacaoPendente($con, $id){
		$doacao_query = $con->prepare("SELECT * FROM `doacao` WHERE account_id = ".$id." AND estado!= 3 ");
	    $doacao_query->execute();
	    $doacoes = $doacao_query->fetchAll(PDO::FETCH_OBJ);
	    return $doacoes;
	}

	// Lista de personagens para reset de aparencia

	function listagem_char($con, $account_id){
		$search_character_query = $con->prepare("SELECT * FROM `char` WHERE account_id = ".$account_id."");
        $search_character_query->execute();
        $char = $search_character_query->fetchAll(PDO::FETCH_OBJ);
		return $char;
	}

	// Lista de personagens para reset de posicão

	function list_reset_char($con, $account_id){
		$search_character_query = $con->prepare("SELECT * FROM `char` WHERE account_id = ".$account_id."");
        $search_character_query->execute();
        $char = $search_character_query->fetchAll(PDO::FETCH_OBJ);
		return $char;
	}

	// Lista de personagens para transferir dinheiro

	function list_money_char($con, $account_id){
		$search_character_query = $con->prepare("SELECT * FROM `char` WHERE account_id = ".$account_id."");
        $search_character_query->execute();
        $char = $search_character_query->fetchAll(PDO::FETCH_OBJ);
		return $char;
	}


	// Busca Make Char

	function MakesearchChar($con, $name){
		$acc=array(':name'=>$char_name);
		$account_query = $con->prepare("SELECT `name` FROM `char` WHERE `name` = :name ORDER BY `account_id`");
		$account_query->execute($acc);
		$account_info = $account_query->fetchAll(PDO::FETCH_OBJ);
		if($account_info):
			$dados = $account_info->name;
		else:
			$dados = "";
		endif;
		return $dados;
	}

	// Make Char
	function make_char($con, $acc_id, $name, $stats_points, $hair, $hair_color, $str, $agi, $vit, $int, $dex, $luk, $max_hp, $max_sp, $stats_final, $last_map, $mapa_x, $mapa_y, $gender){
		$blevel = 1;
		$jlevel = 0;
		// Lista de chars
		$search_character_query = $con->prepare("SELECT * FROM `char` WHERE `account_id` = ".$acc_id."");
        $search_character_query->execute();
        $chars = $search_character_query->fetchAll(PDO::FETCH_OBJ);
        // Ver nome
        $acc=array(':name'=>$name);
		$account_query = $con->prepare("SELECT `name` FROM `char` WHERE `name` = :name ORDER BY `account_id`");
		$account_query->execute($acc);
		$found = $account_query->fetchAll(PDO::FETCH_OBJ);
        if( ! $found ):
	        $personagens = array();
	        for ($i=0; $i < 9 ; $i++) {
	        	$personagens[$i] = null;
	        }
	    	for ($i=0; $i < 9 ; $i++) { 
		        foreach ( $chars as $char ) :
		    		if( $char->char_num == $i ){
			        	$personagens[$i] = array( 
			        		'char_id' => $char->char_id,
			        		'char_slot' => $char->char_num,
		        		);
		    		}
		        endforeach;
	    	}
	        $contagem = count( array_filter( $personagens ) );
	        if ( $contagem < 9 ) :
	    		// slot de teste
	    		$slot = 0;
	    		for ( $i=0; $i < 9 ; $i++) { 
	    			if( $personagens[$i] == null ){
						$slot = $i;
						break;
	    			}
	    		}
				$cadastrar=array(
					':account_id'	=>$acc_id, 
					':char_num'		=>$slot, 
					':name'			=>$name, 
					':base_level'	=>$blevel, 
					':job_level'	=>$jlevel, 
					':str'			=>$str, 
					':agi'			=>$agi, 
					':vit'			=>$vit, 
					':inte'			=>$int, 
					':dex'			=>$dex, 
					':luk'			=>$luk, 
					':max_hp'		=>$max_hp, 
					':hp'			=>$max_hp, 
					':max_sp'		=>$max_sp, 
					':sp'			=>$max_sp, 
					':status_point'	=>$stats_final, 
					':hair'			=>$hair, 
					':hair_color'	=>$hair_color, 
					':last_map'		=>$last_map, 
					':last_x'		=>$mapa_x, 
					':last_y'		=>$mapa_y, 
					':save_map'		=>$last_map, 
					':save_x'		=>$mapa_x, 
					':save_y'		=>$mapa_y,
					':sex'			=>$gender
				);
				$add_char_query = $con->prepare("INSERT INTO `char`(
							`account_id`, 
							`char_num`, 
							`name`, 
							`base_level`, 
							`job_level`, 
							`str`, 
							`agi`, 
							`vit`, 
							`int`, 
							`dex`, 
							`luk`, 
							`max_hp`, 
							`hp`, 
							`max_sp`, 
							`sp`, 
							`status_point`, 
							`hair`,
							`hair_color`,
							`last_map`, 
							`last_x`, 
							`last_y`, 
							`save_map`, 
							`save_x`, 
							`save_y`,
							`sex`
					) VALUES(
					:account_id, 
					:char_num, 
					:name, 
					:base_level, 
					:job_level, 
					:str, 
					:agi, 
					:vit, 
					:inte, 
					:dex, 
					:luk, 
					:max_hp, 
					:hp, 
					:max_sp, 
					:sp, 
					:status_point, 
					:hair,
					:hair_color,
					:last_map, 
					:last_x, 
					:last_y, 
					:save_map, 
					:save_x, 
					:save_y,
					:sex
					) 
				");
				$add_char_query->execute($cadastrar);
				$dados = "Personagem Cadastrado !";
			else:
				$dados = "Sem spaço para cadastrar novos personagens, entre no jogo e apague um personagem existente para criar um novo.";
			endif;
		else:
			$dados = "Já existe um personagem com este nome, tente um nome diferente";
		endif;
		return $dados;
	}

	function nova_senha( $con, $senha, $hash ){
		$today = date('Y-m-j h-i-s');  
		$dados = array(':hash'=>$hash);
		$pass_query = $con->prepare("SELECT * FROM passchange WHERE hash=:hash " );
		$pass_query->execute($dados);
		$pass = $pass_query->fetch(PDO::FETCH_OBJ);
		$dados2 =array('change_validate'=>0, ':hash'=>$hash, ':data_change'=>$today );
		$change_query = $con->prepare("UPDATE `passchange` SET `change_validate`=:change_validate, `data_change`=:data_change WHERE hash=:hash ");
		$change_query->execute($dados2);
		$dados3 = array(':usermail'=>$pass->email, ':password'=>md5($senha) );
		$pass_change = $con->prepare("UPDATE `login` SET `user_pass`=:password WHERE email=:usermail ");
		$pass_change->execute($dados3);
		$msg = array(
			'mensagem' => "<div class='ui positive message'>Senha Alterada com Sucesso</div>",
			'status' => '',
			'redirect' => '/home',
		);
		return $msg;
	}
	function redefine( $con, $hash ){
		$dados = array(':hash'=>$hash);
		$pass_query = $con->prepare("SELECT * FROM passchange WHERE hash=:hash " );
		$pass_query->execute($dados);
		$pass = $pass_query->fetch(PDO::FETCH_OBJ);
		if( $pass ){
			if( $pass->change_validate > 0 ){
				$msg = array(
					'mensagem' => "<div class='ui positive message'>Muito bem, altere sua senha nos campos a cima</div>",
					'status' => TRUE,
					'redirect' => '',
				);
			}else{
				$msg = array(
					'mensagem' => "<div class='ui error message'>Esta requisição de alteração de senha já expirou, lamentamos muito... <br> por favor tente pedir uma nova alteração </div>",
					'status' => FALSE,
					'redirect' => '',
				);
			}
		}else {
			$msg = array(
				'mensagem' => "<div class='ui error message'>Não encontramos nenhuma requisição de senha </div>",
				'status' => FALSE,
				'redirect' => '',
			);
		}
		return $msg;
	}
 ?>