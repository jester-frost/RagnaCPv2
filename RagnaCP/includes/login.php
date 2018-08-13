<?php /* PHP Insano começa aqui */
	if(!empty($_POST) and (isset($_POST["logar"]))){
	/*Variaveis para guardar valores do post */
	$userid=$_POST["userid"];
	$user_pass=$_POST["user_pass"];
	$dados = login($con, $userid, $user_pass, $md5);
	}
 ?>
<?php  if($_SESSION["usuario"]) : ?>
	<div class="login box">
		<div class="box-title">
			Olá <?php echo $_SESSION["usuario"]->userid;?> 
		</div>
		<div class="box-footer">
			<a href="?logout=sim"  class="btn">Deslogar</a>
		</div>
	</div>
<?php else :  ?>
	<div class="login box">
		<div class="box-title">
			Log On
		</div>
		<form action="" method="POST">
			<label>
				<span>Login: </span>
				<input name="userid" class="ipt" type="text" required>
			</label>		
			<label>
				<span>Senha: </span>
				<input name="user_pass" class="ipt" type="password"  required>
			</label>
			<div class="error-msg">
				<?php echo $dados;?>
			</div>
			<div class="box-footer">
				<input type="submit" value="logar" class="btn" name="logar">
			</div>
		</form>
	</div>
<?php endif; ?>