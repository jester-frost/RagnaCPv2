 <?php 
 	include('config.php');
 	$guild = topguild($con);
    $castle = topcastle($con);
?>
<table>
	<thead>
		<tr>
			<th><div align="center">Pos</div></th>
			<th><div align="center">Guilda</div></th>
			<th><div align="center">Dono</div></th>
			<th><div align="center">Level</div></th>
			<th><div align="center">Exp</div></th>
			<th><div align="center">Membros</div></th>
			<th><div align="center">Level Médio</div></th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
		    foreach ($guild as $g) :
		    
		    $i = $i+1;
			$guildID = $g->guild_id;
			$ebm = @gzuncompress(pack('H*', $g->emblem_data));
			
		?>
		<tr>
			<td><div align="center"><?php echo $i;?></div></td>
			<td><div align="center" class="emblema"><canvas id="canvas-<?php echo $i;?>" class="guild-emblem" width=24 height=24></canvas><img id="obj" src="data:image/png;base64,<?php echo base64_encode($ebm) ; ?>" class="guild-emblem"><?php echo $g->name;?></div></td>
			<td><div align="center"><?php echo $g->master;?></div></td>
			<td><div align="center"><?php echo $g->guild_lv;?></div></td>
			<td><div align="center"><?php echo number_format($g->exp,0,'.','.');?></div></td>
			<td><div align="center"><?php echo ($g->gmate/$g->average_lv);?></div></td>
			<td><div align="center"><?php echo $g->average_lv;?></div></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<h3>Castelos Conquistados</h3>
<table>
	<thead>
		<tr>
			<th><div align="center">Guilda</div></th>
			<th><div align="center">Dono</div></th>
			<th><div align="center">Castelo</div></th>
		</tr>
	</thead>
	<tbody>
	<?php
		include "castelos.php";
		$i=0;
	    foreach ($castle as $c) :
	    $i=$i+1;
	    $ebm = @gzuncompress(pack('H*', $c->emblem_data));
			
	?>
		<tr>
			<td><div align="center" class="emblema"><canvas id="canvas-g<?php echo $i;?>" class="guild-emblem" width=24 height=24></canvas><img src="data:image/png;base64,<?php echo  base64_encode($ebm) ; ?>" class="guild-emblem"><?php echo $c->name;?></div></td>
			<td><div align="center"><?php echo $c->master;?></div></td>
			<td><div align="center"><?php echo $castelo[$c->castle_id];?></div></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>