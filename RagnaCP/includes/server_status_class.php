<?php


class ServerStatus {

# Declaração das propriedades.
private $host;
private $user;
private $pass;
private $base;

	# Método construtor da classe.
	function __construct($host,$user,$pass,$base) {
		$this->host = gethostbyname( $host );
		$this->user = $user;
		$this->pass = $pass;
		$this->base = $base;
	}
	
	# Método destrutor da classe.
	function __destruct() {
		$this->host;
		$this->user;
		$this->pass;
		$this->base;
	}
	
	# Método para conectar com o host:porta.
	function connect( $host,$port ) {
		# $fp receberá o retorno da função fsockopen.
		$fp = @fsockopen( $host, $port, $errno, $errstr, 1.0 );
		# $close receberá o retorno do método $this->close;
		$close = $this->close( $fp );
		# Irá retornar o valor de $fp.
		return $fp;
	}
	
	# Método para fechar a conexão.
	function close( $fp ) {
		# Chama a função fclose para fechar a conexão gerada em $fp.
		@fclose( $fp );
	}
	
	# Método de retorno do Status através de $port.
	function getSt( $port ) {
		# Retorna o retorno do método $this->connect.
		return $this->connect( $this->host, $port );
	}
	
	# Método de retorno do Statos do Login-Serv.
	function getLoginStatus() {
		# Retorna o retorno de $this->getSt com a porta 6900.
		return $this->getSt( 6900 );
	}
	
	# Método de retorno do Statos do Char-Serv.
	function getCharStatus() {
		# Retorna o retorno de $this->getSt com a porta 6121.
		return $this->getSt( 6121 );
	}
	
	# Método de retorno do Statos do Map-Serv.
	function getMapStatus() {
		# Retorna o retorno de $this->getSt com a porta 5121.
		return $this->getSt( 5121 );
	}
	
	# Método para pegar o número de jogadores online.
	function getUsersOnline($con) {

		$qry = $con->prepare("SELECT COUNT(online) as usersOnline FROM `char` WHERE `online` = 1" ) or die( 'Erro na tabela "char"');
		$qry->execute();
		$res = $qry->fetchall(PDO::FETCH_OBJ);

		return $res;
	}
}

?>