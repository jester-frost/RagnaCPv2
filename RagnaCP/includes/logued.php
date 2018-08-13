<?php  if($_SESSION["usuario"]) : ?>
	   <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Player Menu') ) : 
		endif;
		?>
		<?php if ( $_SESSION["usuario"]->group_id >= $level_admin ) : ?>
			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Admin Menu') ) : 
			endif;
			?>
		<?php endif;?>
<?php else :  ?>
	<div class="box">
		<h3 class="box-title">Você não está logado</h3>
		<div class="unloged">
			<p>Para ter acesso aos benefícios de um player, precisa se <a href="<?php echo home_url(); ?>/cadastro">registrar</a> e se logar.</p>
		</div>
	</div>
<?php endif; ?>