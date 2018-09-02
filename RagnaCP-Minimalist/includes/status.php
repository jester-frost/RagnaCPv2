
<div class="server-status">
<?php
	
	# Require no arquivo da classe.
	
	require  ( get_template_directory() . '/includes/server_status_class.php');

	# Instanciar a classe ServerStatus com os parâmetros: (IP, Usuário, Senha, Banco de Dados).
	$status = new ServerStatus( $host, $user, $userpass, $database );

	# Se $status->getLoginStatus() retornar algum valor, imprime Online.
	echo "<div class='server-info'>
				<div class='server-stats'>";
	if($status->getLoginStatus()) echo "<img class='img-status'src='". get_bloginfo(template_url)  ."/status/login-on.gif'/>";
	# Senão, imprime Offline
	else echo "<img class='img-status'src='". get_bloginfo(template_url)  ."/status/login-off.gif'/>";
	
	# Quebra de linha HTML.
	
	# Se $status->getCharStatus() retornar algum valor, imprime Online.
	if($status->getCharStatus()) echo "<img class='img-status'src='". get_bloginfo(template_url)  ."/status/char-on.gif'/>";
	# Senão, imprime Offline.
	else echo "<img class='img-status'src='". get_bloginfo(template_url)  ."/status/char-off.gif'/>";
	
	# Quebra de linha HTML.
	
	# Se $status->getMapStatus() retornar algum valor, imprime Online.
	if($status->getMapStatus()) echo "<img class='img-status'src='". get_bloginfo(template_url)  ."/status/map-on.gif'/></div>";
	# Senão, imprime Offline.
	else echo "<img class='img-status'src='". get_bloginfo(template_url)  ."/status/map-off.gif'/></div>";
	
	# Quebra de linha HTML.
	
	# Imprime o número de usuários Online.
	
	$dados = array_shift($status->getUsersOnline( $con ));
	echo "<p> Online: ". $dados->usersOnline  ."</p>";
	echo "</div>";
	
?>
</div>