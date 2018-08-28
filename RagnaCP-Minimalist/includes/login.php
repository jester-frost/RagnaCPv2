<?php /* PHP Insano começa aqui */
	if(!empty($_POST) and (isset($_POST["logar"]))){
	/*Variaveis para guardar valores do post */
	$userid=$_POST["userid"];
	$user_pass=$_POST["user_pass"];
	$dados = login($con, $userid, $user_pass, $md5);
	}
 ?>
<?php  if($_SESSION["usuario"]) : ?>
	<div class="login logued">
		<p>Olá <?php echo $_SESSION["usuario"]->userid;?></p> 

		<a href="?logout=sim"  class="btn">Deslogar</a>
	</div>
<?php else :  ?>
	<div class="login">
		<form action="" method="POST">
			<input name="userid" class="ipt" type="text" placeholder="Login: " required>
			<input name="user_pass" class="ipt" type="password" placeholder="Senha: " required>
			<input type="submit" value="logar" class="btn" name="logar">
			<div class="error-msg">
				<?php echo $dados;?>
			</div>
		</form>
	</div>
<?php endif; ?>