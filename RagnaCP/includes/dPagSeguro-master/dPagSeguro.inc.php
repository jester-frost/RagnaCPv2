<?php
require_once dirname(__FILE__).'/dBrowser2.inc.php';
// Documentação PagSeguro:
//		https://pagseguro.uol.com.br/v2/guia-de-integracao/visao-geral.html

// Modo de uso:
//   $ps = new dPagSeguro($email, $token);
// 
//   $ps->newPagamento($pedido, $produtos[, $callback])
//		@input
// 			Array $pedido:
//				[reference]
//				[senderEmail], [senderName], [senderAreaCode (2 dígitos DDD)], [senderPhone]
//				[shippingType], [shippingCost]
//				[shippingAddressCountry], [shippingAddressState], [shippingAddressCity], [shippingAddressPostalCode], [shippingAddressDistrict], [shippingAddressStreet], [shippingAddressNumber], [shippingAddressComplement]
//				[extraAmount], [redirectUrl]
//			
// 			Array $produtos []:
//				id, description, amount, quantity
//				[weight], [shippingCost]
// 		
//			Callback $callback($goUrl, $code, $date)
//		
//		@return
//			string $goUrl (url para direcionar o usuário)
// 			FALSE (se houver erros, use listErrors para obter a descricao)
// 
//   $ps->getNotification($type, $code)
//   $ps->getNotification($code)
//   	@input
// 			string $type --> Sempre 'transaction'
//          string $code --> Código da notificação, com > 39 caracteres
//      @return = getTransaction()
// 
//   @ps->getTransaction($code)
//      @input string $code --> 36 caracteres.
//      @return
// 			Array $resposta (https://pagseguro.uol.com.br/v2/guia-de-integracao/consulta-de-transacoes-por-codigo.html)
//          	[code]                --> Código da transação, com 36 caracteres.
//              [reference]           --> Código interno do pedido
//              [status]              --> 1=Ag. Pagam, 2=Em análise, 3=Paga, 4=Disponível, 5=Em disputa, 6=Devolvida, 7=Cancelada
//              [paymentMethod][type] --> 1=Crédito, 2=Boleto, 3=TEF, 4=Saldo PagSeguro, 5=Oi Paggo
//              [paymentMethod][code] --> 101=Visa, 102=MasterCard, 103=American Express, 104=Diners, 105=Hipercard, 106=Aurora, etc...
// 
//   @ps->getTransactionHistory($initialDate, $finalDate[, $page=1[, $maxPageResults=100]])
//   	@input
//          timestamp|usdate|brdate initialDate, finalDate
//          page, maxPageResults
//      @return
//          Array $resposta (https://pagseguro.uol.com.br/v2/guia-de-integracao/consulta-de-transacoes-por-intervalo-de-datas.html)
//              [transactions][transaction] --> []
//                  date, code, type, lastEventDate, grossAmount
// 
//   @ps->getAbandonedHistory  ($initialDate, $finalDate[, $page=1[, $maxPageResults=100]])
//   	@input
//          timestamp|usdate|brdate initialDate, finalDate
//          page, maxPageResults
//      @return
//          Array $resposta (https://pagseguro.uol.com.br/v2/guia-de-integracao/consulta-de-transacoes-abandonadas.html)
//              [transactions][transaction] --> [] 
//                   date, lastEventDate, code, reference, type, status
//                   status, paymentMethod[type], paymentMethod[code]
//                   grossAmount, discountAmount, feeAmount, netAmount, extraAmount
// 
// Sugestões de uso e instalação do PagSeguro:
//   > Integração > Gerar TOKEN
//   > Integração > Página de redirecionamento > Página fixa: "Desativado"
//   > Integração > Página de redirecionamento > Dinâmico: "Ativado" : "transaction_id"
//   > Integração > Pagamentos via API > "Ativado" (Sem isso, o redirecionamento dinâmico não funciona)
//   > Integração > Notificação de transações > "Ativado" (URL NOTIFICACAO)
//   > Integração > Retorno automático de dados > "Desativado"

// URL Retorno:
// --> $ps->getTransaction($_GET['transaction_id']) --> Decobre o status da transação de volta. Leia a documentação do PagSeguro para saber o que vem aqui.

// URL Notificação:
// --> $ps->getNotification($_POST['notificationCode'], $_POST['notificationType']) -->  Leia a documentação do PagSeguro para saber o que vem aqui.


class dPagSeguro{
	private $settings;
	private $errors;
	public  $permissive; /// Ignore errors on requests, if field is optional.
	public  $debug;
	
	static Function getVersion(){
		return 1.02; // Last-release: 17/03/2014
	}
	
	Function __construct          ($email, $token, $receiverEmail=false){
		$this->errors     = Array();
		$this->debug      = false;
		$this->permissive = true;
		$this->setToken($email, $token, $receiverEmail);
	}
	
	Function setToken             ($email, $token, $receiverEmail=false){
		$this->settings = Array('email'=>$email, 'token'=>$token, 'receiverEmail'=>$receiverEmail);
	}
	Function newPagamento         ($pedido, $produtos, $callback=false, $nRetries=3){
		// Parâmetros:
		//     https://pagseguro.uol.com.br/v2/guia-de-integracao/api-de-pagamentos.html
		// 
		// $pedido:
		//     [reference]
		//     [senderEmail], [senderName], [senderAreaCode (2 dígitos DDD)], [senderPhone]
		//     [shippingType], [shippingCost]
		//     [shippingAddressCountry], [shippingAddressState], [shippingAddressCity], [shippingAddressPostalCode], [shippingAddressDistrict], [shippingAddressStreet], [shippingAddressNumber], [shippingAddressComplement]
		//     [extraAmount], [redirectUrl]
		//     
		// $produtos[]:
		//     id, description, amount, quantity
		//     [weight], [shippingCost]
		
		$this->_clearErrors();
		$this->_checkErrors('newPagamento:pedido',   $pedido);
		$this->_checkErrors('newPagamento:produtos', $produtos);
		if($this->listErrors()){
			return false;
		}
		
		if(array_key_exists('shippingCost', $pedido)){
			$pedido['shippingCost'] = number_format($pedido['shippingCost'], 2, '.', '');
		}
		if(array_key_exists('extraAmount', $pedido)){
			$pedido['extraAmount'] = number_format($pedido['extraAmount'], 2, '.', '');
		}
		
		$b = new dBrowser2;
		$b->debug = $this->debug;
		$b->setCharset('UTF-8');
		$b->addPost('email',    $this->settings['email']);
		$b->addPost('token',    $this->settings['token']);
		$b->addPost('currency', 'BRL');
		foreach($pedido as $key=>$value){
			$b->addPost($key, $value);
		}
		
		$nProduto = 0;
		foreach($produtos as $produInfo){
			$nProduto++;
			$produInfo['amount'] = number_format($produInfo['amount'], 2, '.', '');
			if(array_key_exists('shippingCost', $produInfo)){
				$produInfo['shippingCost'] = number_format($produInfo['shippingCost'], 2, '.', '');
			}
			foreach($produInfo as $key=>$value){
				$b->addPost("item".ucfirst($key).$nProduto, $value);
			}
		}
		
		// Parâmetros para enviar:
		if($this->settings['receiverEmail']){
			$b->addPost('receiverEmail', $this->settings['receiverEmail']);
		}
		$sandbox = false;
		if( $sandbox ){
			$url1 = 'https://sandbox.pagseguro.uol.com.br';
			$url2 = 'https://ws.sandbox.pagseguro.uol.com.br';
			$url3 = 'https://stc.sandbox.pagseguro.uol.com.br';
		}else{
			$url1 = 'https://pagseguro.uol.com.br';
			$url2 = 'https://ws.pagseguro.uol.com.br';
			$url3 = 'https://stc.pagseguro.uol.com.br';
		}
		$b->addPost('maxAge',   array_key_exists('maxAge',  $pedido)?$pedido['maxAge'] :60*60);
		$b->addPost('maxUses',  array_key_exists('maxUses', $pedido)?$pedido['maxUses']:100);
		$b->go($url2."/v2/checkout");
		$body     = $b->getBody();
		$response = $this->_parseXML($body);
		if($response === false){
			$this->_addError("-999", "Resposta desconhecida: {$body}");
			return false;
		}
		
		$this->_checkErrors('newPagamento:response', $response);
		$errorList = $this->listErrors();
		if($errorList){
			// Problemas conhecidos:
			//     (11012) senderName invalid value: Lucas
			//     (11010) senderEmail invalid value: xxxxxxxxxx
			//     (11020) shippingAddressComplement invalid length: restaurante maracões no final de linha da calçada
			//     (-999)  Resposta desconhecida: XXXXX
			// 
			// Como tornar esta classe permissiva?
			//     Apenas os campos preenchidos pelo usuário serão permissivos, ou seja, apenas os que
			//     começarem com sender* e shipping*.
			// 
			//     Problema de comunicação (Resposta Desconhecida) permitirá o re-submit sem alterações
			//     no formulário.
			//     
			//     Outros problemas (como problema no 'Reference' ou nos produtos) não são permissivos, e serão sempre
			//     críticos.
			// 
			if($this->permissive && $nRetries){
				$newPedido   = $pedido;
				$_allowRetry = false;
				foreach($errorList as $errorCode=>$errorStr){
					if($errorCode == -999){
						$_allowRetry = true;
						continue;
					}
					if(preg_match("/^((sender|shipping).+?) invalid/", $errorStr, $out)){
						// Remove o field informado na mensagem de erro, para tornar a classe permissiva.
						unset($newPedido[$out[1]]);
					}
				}
				
				if($_allowRetry || (serialize($newPedido) != serialize($pedido))){
					return $this->newPagamento($newPedido, $produtos, $callback, $nRetries-1);
				}
			}
			return false;
		}
		$sandbox = false;
		if( $sandbox ){
			$url1 = 'https://sandbox.pagseguro.uol.com.br';
			$url2 = 'https://ws.sandbox.pagseguro.uol.com.br';
			$url3 = 'https://stc.sandbox.pagseguro.uol.com.br';
		}else{
			$url1 = 'https://pagseguro.uol.com.br';
			$url2 = 'https://ws.pagseguro.uol.com.br';
			$url3 = 'https://stc.pagseguro.uol.com.br';
		}
		$goUrl = $url1."/v2/checkout/payment.html?code=".$response['code'];
		if($callback){
			call_user_func($callback, $goUrl, $response['code'], $response['date']);
		}
		return $goUrl;
	}
	Function getNotification      ($type=false, $code=false){
		$this->_clearErrors();
		if(!$code){
			$code = $type;
			$type = 'transaction';
		}
		if($this->_checkErrors('getNotification:params', ($params = Array('type'=>$type, 'code'=>$code)))){
			return false;
		}
		if($type == 'transaction'){
			$b = new dBrowser2;
			$b->debug = $this->debug;
			$sandbox = false;
			if( $sandbox ){
				$url1 = 'https://sandbox.pagseguro.uol.com.br';
				$url2 = 'https://ws.sandbox.pagseguro.uol.com.br';
				$url3 = 'https://stc.sandbox.pagseguro.uol.com.br';
			}else{
				$url1 = 'https://pagseguro.uol.com.br';
				$url2 = 'https://ws.pagseguro.uol.com.br';
				$url3 = 'https://stc.pagseguro.uol.com.br';
			}
			$b->go($url2."/v2/transactions/notifications/{$code}?email={$this->settings['email']}&token={$this->settings['token']}");
			$body     = $b->getBody();
			$response = $this->_parseXML($body);
			if($response === false){
				$this->_addError("-999", "Resposta desconhecida: {$body}");
				return false;
			}
			if($this->_checkErrors('getNotification:response', $response)){
				return false;
			}
			return $this->_standardizeResponse('transaction', $response);
		}
		
		return false;
	}
	Function getTransaction       ($code){
		$this->_clearErrors();
		$b = new dBrowser2;
		$b->debug = $this->debug;
		$sandbox = false;
		if( $sandbox ){
			$url1 = 'https://sandbox.pagseguro.uol.com.br';
			$url2 = 'https://ws.sandbox.pagseguro.uol.com.br';
			$url3 = 'https://stc.sandbox.pagseguro.uol.com.br';
		}else{
			$url1 = 'https://pagseguro.uol.com.br';
			$url2 = 'https://ws.pagseguro.uol.com.br';
			$url3 = 'https://stc.pagseguro.uol.com.br';
		}
		$b->go($url2."/v2/transactions/{$code}?email={$this->settings['email']}&token={$this->settings['token']}");
		$body     = $b->getBody();
		$response = $this->_parseXML($body);
		if($this->_checkErrors('getTransaction:response', $response)){
			return false;
		}
		return $this->_standardizeResponse('transaction', $response);
	}
	Function getTransactionHistory($initialDate, $finalDate, $page=1, $maxPageResults=100){
		$this->_clearErrors();
		if($this->_checkErrors('getTransaction', Array('initialDate'=>$initialDate, 'finalDate'=>$finalDate, 'page'=>$page, 'maxPageResults'=>$maxPageResults)))
			return true;
		
		if(stripos($initialDate, "/")){
			// Veio em formato brasileiro:
			//     30/12/2010 --> Converta para US (2010-12-30)
			$initialDate = explode("/", $initialDate);
			$initialDate = "{$initialDate[2]}/{$initialDate[1]}/{$initialDate[0]}";
		}
		elseif(is_numeric($initialDate)){
			// Veio em formato TIMESTAMP:
			//     12345678901 --> Converta para US (2010-12-30)
			$initialDate = strtotime("Y-m-d", $initialDate);
		}
		
		if(stripos($finalDate, "/")){
			// Veio em formato brasileiro:
			//     30/12/2010 --> Converta para US (2010-12-30)
			$finalDate = explode("/", $finalDate);
			$finalDate = "{$finalDate[2]}/{$finalDate[1]}/{$finalDate[0]}";
		}
		elseif(is_numeric($finalDate)){
			// Veio em formato TIMESTAMP:
			//     12345678901 --> Converta para US (2010-12-30)
			$finalDate = strtotime("Y-m-d", $finalDate);
		}
		
		$initialDate .= "T00:00";
		$finalDate   .= ($finalDate == date('Y-m-d'))?
			"T".date('H:i', strtotime("-30 minutes")):
			"T23:59";
		$sandbox = false;
		if( $sandbox ){
			$url1 = 'https://sandbox.pagseguro.uol.com.br';
			$url2 = 'https://ws.sandbox.pagseguro.uol.com.br';
			$url3 = 'https://stc.sandbox.pagseguro.uol.com.br';
		}else{
			$url1 = 'https://pagseguro.uol.com.br';
			$url2 = 'https://ws.pagseguro.uol.com.br';
			$url3 = 'https://stc.pagseguro.uol.com.br';
		}
		$b = new dBrowser2;
		$b->debug = $this->debug;
		$b->go(
			$url2."/v2/transactions?".
			"email={$this->settings['email']}&".
			"token={$this->settings['token']}&".
			"initialDate={$initialDate}&".
			"finalDate={$finalDate}&".
			"page={$page}&".
			"maxPageResults={$maxPageResults}"
		);
		
		$response = $this->_parseXML($b->getBody());
		if($this->_checkErrors('getTransactionHistory:response', $response)){
			return false;
		}
		
		return $this->_standardizeResponse('history', $response);
	}
	Function getAbandonedHistory  ($initialDate, $finalDate, $page=1, $maxPageResults=100){
		$this->_clearErrors();
		if($this->_checkErrors('getTransaction', Array('initialDate'=>$initialDate, 'finalDate'=>$finalDate, 'page'=>$page, 'maxPageResults'=>$maxPageResults)))
			return true;
		
		if(stripos($initialDate, "/")){
			// Veio em formato brasileiro:
			//     30/12/2010 --> Converta para US (2010-12-30)
			$initialDate = explode("/", $initialDate);
			$initialDate = "{$initialDate[2]}/{$initialDate[1]}/{$initialDate[0]}";
		}
		elseif(is_numeric($initialDate)){
			// Veio em formato TIMESTAMP:
			//     12345678901 --> Converta para US (2010-12-30)
			$initialDate = strtotime("Y-m-d", $initialDate);
		}
		
		if(stripos($finalDate, "/")){
			// Veio em formato brasileiro:
			//     30/12/2010 --> Converta para US (2010-12-30)
			$finalDate = explode("/", $finalDate);
			$finalDate = "{$finalDate[2]}/{$finalDate[1]}/{$finalDate[0]}";
		}
		elseif(is_numeric($finalDate)){
			// Veio em formato TIMESTAMP:
			//     12345678901 --> Converta para US (2010-12-30)
			$finalDate = strtotime("Y-m-d", $finalDate);
		}
		
		$initialDate .= "T00:00";
		$finalDate   .= ($finalDate == date('Y-m-d'))?
			"T".date('H:i', strtotime("-30 minutes")):
			"T23:59";
		$sandbox = false;
		if( $sandbox ){
			$url1 = 'https://sandbox.pagseguro.uol.com.br';
			$url2 = 'https://ws.sandbox.pagseguro.uol.com.br';
			$url3 = 'https://stc.sandbox.pagseguro.uol.com.br';
		}else{
			$url1 = 'https://pagseguro.uol.com.br';
			$url2 = 'https://ws.pagseguro.uol.com.br';
			$url3 = 'https://stc.pagseguro.uol.com.br';
		}
		$b = new dBrowser2;
		$b->debug = $this->debug;
		$b->go(
			$url2."/v2/transactions?".
			"email={$this->settings['email']}&".
			"token={$this->settings['token']}&".
			"initialDate{$initialDate}&".
			"finalDate={$finalDate}&".
			"page={$page}&".
			"maxPageResults={$maxPageResults}"
		);
		
		$response = $this->_parseXML($b->getBody());
		if($this->_checkErrors('getAbandonedHistory:response', $response)){
			return false;
		}
		return $this->_standardizeResponse('history', $response);
	}
	Function listErrors           (){
		return $this->errors;
	}
	
	Function getStringByCode($what, $code){
		if($what == 'status'){
			if($code == '1') return "Aguardando pagamento";
			if($code == '2') return "Em análise";
			if($code == '3') return "Paga";
			if($code == '4') return "Disponível";
			if($code == '5') return "Em disputa";
			if($code == '6') return "Devolvida";
			if($code == '7') return "Cancelada";
			return false;
		}
		if($what == 'pagamento'){
			if($code == '1') return "Cartão de crédito";
			if($code == '2') return "Boleto";
			if($code == '3') return "Débito online (TEF)";
			if($code == '4') return "Saldo PagSeguro";
			if($code == '5') return "Oi Paggo";
			
			if($code == '101') return "Cartão de crédito Visa.";
			if($code == '102') return "Cartão de crédito MasterCard.";
			if($code == '103') return "Cartão de crédito American Express.";
			if($code == '104') return "Cartão de crédito Diners.";
			if($code == '105') return "Cartão de crédito Hipercard.";
			if($code == '106') return "Cartão de crédito Aura.";
			if($code == '107') return "Cartão de crédito Elo.";
			if($code == '108') return "Cartão de crédito PLENOCard.";
			if($code == '109') return "Cartão de crédito PersonalCard.";
			if($code == '110') return "Cartão de crédito JCB.";
			if($code == '111') return "Cartão de crédito Discover.";
			if($code == '112') return "Cartão de crédito BrasilCard.";
			if($code == '113') return "Cartão de crédito FORTBRASIL.";
			if($code == '201') return "Boleto Bradesco. *";
			if($code == '202') return "Boleto Santander.";
			if($code == '301') return "Débito online Bradesco.";
			if($code == '302') return "Débito online Itaú.";
			if($code == '303') return "Débito online Unibanco. *";
			if($code == '304') return "Débito online Banco do Brasil.";
			if($code == '305') return "Débito online Banco Real. *";
			if($code == '306') return "Débito online Banrisul.";
			if($code == '307') return "Débito online HSBC.";
			if($code == '401') return "Saldo PagSeguro.";
			if($code == '501') return "Oi Paggo.";
			
			if(strlen($code) == 3){
				// Se vier um código não listado, recupere o genérico.
				// Ex: 198 --> Retorna "Cartão de crédito".
				return self::getStringByCode($what, $code[0]);
			}
			
			return false;
		}
		if($what == 'frete'){
			if($code == '1') return "PAC";
			if($code == '2') return "SEDEX";
			if($code == '3') return "Outro";
		}
		
		return false;
	}
	
	Function _standardizeResponse($type, $response){
		if($type == 'transaction'){
			if(array_key_exists('id', $response['items']['item'])){
				$response['items']['item'] = Array($response['items']['item']);
			}
		}
		if($type == 'history'){
			if(array_key_exists('date', $response['transactions']['transaction'])){
				$response['transactions']['transaction'] = Array($response['transactions']['transaction']);
			}
		}
		
		return $response;
	}
	Function _clearErrors(){
		$this->errors = Array();
	}
	Function _addError   ($code, $message){
		$this->errors[$code] = $message;
	}
	Function _checkErrors($where, $data){
		// TRUE if has any errors.
		// FALSE is no errors found.
		
		// Parâmetros:
		//     https://pagseguro.uol.com.br/v2/guia-de-integracao/api-de-pagamentos.html
		// 
		// $pedido:
		//     [reference]
		//     [senderEmail], [senderName], [senderAreaCode (2 dígitos DDD)], [senderPhone]
		//     [shippingType], [shippingCost]
		//     [shippingAddressCountry], [shippingAddressState], [shippingAddressCity], [shippingAddressPostalCode], [shippingAddressDistrict], [shippingAddressStreet], [shippingAddressNumber], [shippingAddressComplement]
		//     [extraAmount], [redirectUrl]
		//     
		// $produtos[]:
		//     id, description, amount, quantity
		//     [weight], [shippingCost]
		if($where == 'newPagamento:pedido'){
			$pedido = &$data;
			$permis = $this->permissive;
			
			if( @$pedido['senderName']   && !preg_match("/.+ .+/", $pedido['senderName'])){
				if($permis){
					unset($pedido['senderName']);
				}
				else{
					$this->_addError('-999', "Nome do cliente (senderName) deve ser completo (com sobrenome)");
				}
			}
			if( @$pedido['senderName']   &&  preg_match("/  +/", $pedido['senderName'])){
				if($permis){
					$pedido['senderName'] = preg_replace("/  +/", " ", $pedido['senderName']);
				}
				else{
					$this->_addError('-999', "Campo senderName tem dois espaços entre os nomes");
				}
			}
			if(!@$pedido['shippingType'] || !in_array(strtolower($pedido['shippingType']), Array('1', '2', '3', 'pac', 'sedex', 'outro'))){
				if($permis){
					$pedido['shippingType'] = 3;
				}
				else{
					$this->_addError('-999', "Campo shippingType é obrigatório");
				}
			}
			if( @$pedido['shippingAddressComplement'] && strlen($pedido['shippingAddressComplement']) > 40){
				if($permis){
					$pedido['shippingAddressComplement'] = substr($pedido['shippingAddressComplement'], 0, 40);
				}
				else{
					$this->_addError('-999', "Campo shippingAddressComplement ultrapassou o limite de 40 caracteres.");
				}
			}
			if( @$pedido['shippingAddressNumber'] && strlen($pedido['shippingAddressNumber']) > 20){
				if($permis){
					$pedido['shippingAddressNumber'] = substr($pedido['shippingAddressNumber'], 0, 20);
				}
				else{
					$this->_addError('-999', "Campo shippingAddressNumber ultrapassou o limite de 20 caracteres.");
				}
			}
			if( @$pedido['shippingAddressState']  && strlen($pedido['shippingAddressState']) != 2 ){
				if($permis){
					unset($pedido['shippingAddressState']);
				}
				else{
					$this->_addError('-999', "Campo shippingAddressState deve ter exatamente 2 caracteres.");
				}
			}
			
			if(strtolower($pedido['shippingType']) == 'pac'){
				$pedido['shippingType'] = '1';
			}
			elseif(strtolower($pedido['shippingType']) == 'sedex'){
				$pedido['shippingType'] = '2';
			}
			else{
				$pedido['shippingType'] = '3';
			}
		}
		if($where == 'newPagamento:produtos'){
			
		}
		if($where == 'getNotification:params'){
			
		}
		if($where == 'getTransactionHistory:params'){
			
		}
		if($where == 'newPagamento:response'){
			if(array_key_exists('error', $data)){
				if(array_key_exists('code', $data['error']))
					$data['error'] = Array($data['error']);
				
				foreach($data['error'] as $errorItem){
					$this->_addError($errorItem['code'], $errorItem['message']);
				}
				return true;
			}
		}
		if($where == 'getNotification:response' || $where == 'getTransaction:response'){
			if(array_key_exists('error', $data)){
				if(array_key_exists('code', $data['error']))
					$data['error'] = Array($data['error']);
				
				foreach($data['error'] as $errorItem){
					$this->_addError($errorItem['code'], $errorItem['message']);
				}
				return true;
			}
			
		}
		if($where == 'getTransactionHistory:response' || $where == 'getAbandonedHistory:response'){
			if(array_key_exists('error', $data)){
				if(array_key_exists('code', $data['error']))
					$data['error'] = Array($data['error']);
				
				foreach($data['error'] as $errorItem){
					$this->_addError($errorItem['code'], $errorItem['message']);
				}
				return true;
			}
		}
		
		return false;
	}
	Function _parseXML($body){
		try{
			$xml = @new SimpleXMLElement($body);
		}
		catch(Exception $ex){
			return false;
		}
		
		$allXML = $this->_easyObjToArray($xml);
		return $allXML;
	}
	Function _easyObjToArray($data){
		if (is_object($data))
			$data = get_object_vars($data);
		return (is_array($data))?array_map(Array('dPagSeguro', '_easyObjToArray'), $data) : $data;
	}
}
