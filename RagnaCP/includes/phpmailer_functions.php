<?php
	require("PHPMailer-master/PHPMailerAutoload.php");

 	function enviar_email($email , $md5 ){

		function msg( $usuario, $email, $site, $pagina_recuberacao, $hash ){
			$usuario = array_shift($usuario);
			$mensagem = "<table>";
			$mensagem .= '<tr>Olá '.$usuario->userid.', foi solicitado que enviassemos um email de redefinição de senha, Caso não tenha sido solicitado ignore este email.</tr>';
			$mensagem .= '<tr> <strong>Informações da conta</strong></tr>';
			$mensagem .= '<tr> <td> <strong>Login:</strong> ' . $usuario->userid . '</td></tr>';
			$mensagem .= '<tr> <td> <strong>Email:</strong> ' . $email . '</td></tr>';
			$mensagem .= '<tr> <td>Clique no <a href="'.$site.'/'.$pagina_recuberacao.'/?hash='.$hash.'"> link</a> para redefinir sua senha.</td></tr>';
			$mensagem .= '<tr></tr>';
			$mensagem .= '<tr></tr>';
			$mensagem .= "</table>";
			return $mensagem;
		}
		function send($mensagem, $email, $host_do_email, $seu_email, $sua_senha, $seu_nome, $assunto, $msg_sent){
			/* Inclui a classe do phpmailer */              
		    
		    $mail = new PHPMailer();
		    /* Cria uma Instância da classe */

		    /* Configura os destinatários (pra quem vai o email) */
			$mail->AddAddress($email);

		    $mail->IsSMTP();
		    /* Define o endereço do servidor de envio */
		    $mail->Host = $host_do_email;
		    /* Utilizar autenticação SMTP */ 
		    $mail->SMTPAuth = true;
		    /* Protocolo da conexão */
		    $mail->SMTPSecure = "ssl";
		    /* Porta da conexão */
		    $mail->Port = "465";
		    /* Email ou usuário para autenticação */
		    $mail->Username = $seu_email;
		    /* Senha do usuário */
		    $mail->Password = $sua_senha;
		     
		    /* Configura os dados do remetente do email */
		    $mail->From = $seu_email; // Seu e-mail
		    $mail->FromName = $seu_nome; // Seu nome
		     
		    /* Configura a mensagem */
		    $mail->IsHTML(true); // Configura um e-mail em HTML
		     
		    /*   
		     * Se tiver problemas com acentos, modifique o charset
		     * para ISO-8859-1  
		     */
		    $mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)
		     
		    /* Configura o texto e assunto */
		    $mail->Subject  = $assunto; // Assunto da mensagem
		    $mail->Body = $mensagem; // A mensagem em HTML
		    $mail->AltBody = trim(strip_tags($mensagem)); // A mesma mensagem em texto puro
		     
		    /* Configura o anexo a ser enviado (se tiver um) */
		    //$mail->AddAttachment("foto.jpg", "foto.jpg");  // Insere um anexo
		     
		    /* Envia o email */
		    $email_enviado = $mail->Send();
		     
		    /* Limpa tudo */
		    $mail->ClearAllRecipients();
		    $mail->ClearAttachments();
		     
		    /* Mostra se o email foi enviado ou não */
	        $msg = $msg_sent;
	        return $msg;
		}

 		$dados=array(':email'=>$email);
 		include("config.php");
		$search_email_query = $con->prepare("SELECT * FROM login WHERE email=:email");
		$search_email_query->execute($dados);
		$usuario=$search_email_query->fetchall(PDO::FETCH_OBJ);
		if ($usuario) {
			if( $md5 ){
				$options = ['cost' => 12,];
				$hash = password_hash("esseshashquevejohjemdiaviu", PASSWORD_BCRYPT, $options);
				$today = date('Y-m-j h-i-s');  
				$dados2 = array(':email'=>$email);
				$email_query = $con->prepare("SELECT * FROM passchange WHERE email=:email " );
				$email_query->execute($dados2);
				$email_set = $email_query->fetch(PDO::FETCH_OBJ);
				if( !$email_set ) {
					$dados3 =array(':hash'=>$hash,':email'=>$email,':data_change'=>$today,':change_validate'=>1);
					$add_change = $con->prepare(
						"
							INSERT INTO `passchange` ( 
								hash, 
								email, 
								data_change, 
								change_validate
							) 
							VALUES (
								:hash, 
								:email, 
								:data_change, 
								:change_validate
							)
						"
					);
					$add_change->execute($dados3);
					$mensagem = msg($usuario, $email, $site, $pagina_recuberacao, $hash );
					$msg_sent = "<div class='ui positive message'>Um Email foi enviado para ".$email.",<br> em alguns instantes irá receber o email contendo instruções para atualização de senha. </div>";
					$msg = send($mensagem, $email, $host_do_email, $seu_email, $sua_senha, $seu_nome, $assunto, $msg_sent);
				} else {
					$mensagem = msg($usuario, $email, $site, $pagina_recuberacao, $hash );
					$dados3 =array('change_validate'=>1, ':hash'=>$hash, ':id'=>$email_set->id, ':data_change'=>$today );
					$change_query = $con->prepare("UPDATE `passchange` SET `change_validate`=:change_validate, `hash`=:hash, `data_change`=:data_change WHERE id=:id ");
					$change_query->execute($dados3);
					$msg_sent = "<div class='ui positive message'>Um Email foi enviado para ".$email.",<br> em alguns instantes irá receber o email contendo instruções para atualização de senha. </div>";
					$msg = send($mensagem, $email, $host_do_email, $seu_email, $sua_senha, $seu_nome, $assunto, $msg_sent);
				}
			}else{
				$mensagem = "<table>";
				foreach ($usuario as $us) {
					$i = $i+1;
					$mensagem .= '<tr>' . $i . '° Conta.<tr>';
					$mensagem .= '<tr><tr>';
					$mensagem .= '<tr> <td>Login: ' . $us->userid . '</td></tr>';
					$mensagem .= '<tr> <td>Senha: ' . $us->user_pass . '</td></tr>';
					$mensagem .= '<tr><tr>';
					$mensagem .= '<tr><tr>';
				}
				$mensagem .= "</table>";
				$msg_sent = "<div class='ui positive message'>Um Email foi enviado para ".$email.",<br> em alguns instantes irá receber o email</div>";
				$msg = send($mensagem, $email, $host_do_email, $seu_email, $sua_senha, $seu_nome, $assunto, $msg_sent);
			}
		}else{
			$msg = "Não foi possível enviar o e-mail.<br /><br />";
	        $msg .= "<b>Email não encontrado. </b> <br />" . $mail->ErrorInfo;
		}
		return $msg;
 	}
?>