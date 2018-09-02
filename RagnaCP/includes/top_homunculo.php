<?php
    include( get_template_directory() . '/includes/config.php');
    $homunculos = tophom($con);
?>
<table  id="conteudo">
	<thead>
	    <tr class="ranking">
	        <th>Pos</th>
	        <th>
	            <div align="center"></div>
	        </th>
	        <th>
	            <div align="center">Classe</div>
	        </th>
	        <th>
	            <div align="center">Nome</div>
	        </th>
	        <th>
	            <div align="center">Level</div>
	        </th>
	        <th>
	            <div align="center">Dono</div>
	        </th>
	    </tr>
	</thead>
	<tbody>
        <?php
            include('homunculos.php');
            $i = 0;
            foreach ($homunculos as $h) :
            $i = $i+1;
        ?>
    	<tr>
	        <td>
	            <div align="center">
	                <?PHP echo $i;?>
	            </div>
	        </td>
	        <td>
                <div align="center">
                    <?PHP echo "<div class='info'><img src='". get_bloginfo(template_url)  ."/images/homunculos/". ($h->class) .".gif '/> ";?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $h_job[$h->class];?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $h->name;?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $h->level?>
           
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $h->charname?>
           
                </div>
            </td>
   		</tr>
    <?php endforeach; ?>
    </tbody>
</table>