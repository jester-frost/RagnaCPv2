<?php 
if ( $_SESSION["usuario"] ) :
    $usuario = $_SESSION["usuario"];
	$account_id = $usuario->account_id;
    switch ($_GET['modo']) {
        case 'vote':
        	$acc_id = preg_replace('/[^[:alnum:]_]/', '',$account_id);
        	$acc_id = str_replace($letters, "", $acc_id);
        	$site = $_GET['link'];
        	$votes = vote_points($con, $site, $acc_id, $points_for_click, $tempo, $links);
        break;
    }
endif;
?>
<div class="links">
	<?php if ($vote_points): ?>
		<div class="box">
			<h5 class="box-title">Vote por Pontos</h5>
			<div class="spacer">
				<a href="?modo=vote&link=<?php print_r(array_keys($links)[0]); ?>" class="vote-link " ><img src="<?php echo get_template_directory_uri() ?>/images/top200.jpg" border="0" title="Vote em nosso servidor!"></a>
				<a href="?modo=vote&link=<?php print_r(array_keys($links)[1]); ?>" class="vote-link" ><img src="<?php echo get_template_directory_uri() ?>/images/topBR.jpg" border="0" title="Vote em nosso servidor!"></a>
				<a href="?modo=vote&link=<?php print_r(array_keys($links)[2]); ?>" class="vote-link" ><img src="<?php echo get_template_directory_uri() ?>/images/topORG.jpg" border="0" title="Vote em nosso servidor!"></a>
			</div>
			<h5 class="points"><?php echo $votes["msg"];?></h5>
		</div>
		<?php else : ?>
			<div class="box">
				<h5 class="box-title">Ajude-nos votando</h5>
				<div class="spacer">
					<a href="<?php echo $links[1];?>" target="_blank" class="vote-link " ><img src="<?php echo get_template_directory_uri() ?>/images/top200.jpg" border="0" title="Vote em nosso servidor!"></a>
					<a href="<?php echo $links[2];?>" target="_blank" class="vote-link" ><img src="<?php echo get_template_directory_uri() ?>/images/topBR.jpg" border="0" title="Vote em nosso servidor!"></a>
					<a href="<?php echo $links[3];?>" target="_blank" class="vote-link" ><img src="<?php echo get_template_directory_uri() ?>/images/topORG.jpg" border="0" title="Vote em nosso servidor!"></a>
				</div>
			</div>
	<?php endif; ?>
<?php if ($mvp_timer): ?>
	<div class="box">
		<h5 class="box-title">MVP Timer</h5>
		<div class="spacer">
			<a href="<?php echo $mvp_link; ?>" target="_blank" class="vote-link " ><img src="<?php echo get_template_directory_uri() ?>/images/ragnarok-mvp-logo.png" border="0" title="MVP TImer !"></a>
		</div>
	</div>
<?php endif; ?>
</div>
<div class="mask"></div>
<div class="modal-vote">
	<?php if ( $_GET['modo'] ): ?>
		<?php if( $votes['url'] ): ?>
			<iframe sandbox="allow-same-origin allow-scripts allow-popups allow-forms" class="iframe" src="<?php echo $votes['url'];?>" frameborder="0"></iframe>
			<script language="javascript">
				$(".mask").addClass("active");
				$(".modal-vote").addClass("active");
				$(".mask").on( 'click', function(){
					$(".modal-vote, .mask").removeClass('active');
				})
			</script>
		<?php endif; ?>
	<?php endif; ?>
</div>