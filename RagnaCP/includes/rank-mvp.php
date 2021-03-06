<?php 
    include( get_template_directory() . '/includes/config.php');
    $chars = topmvp($con);
?>

<table  id="conteudo" class="mvp-table">
    <thead>
        <tr class="ranking">
            <th>Pos</th>
            <th>
                <div align="center">Nome do jogador </div>
            </th>
            <th>
                <div align="center">Level</div>
            </th>
            <th>
                <div align="center">Classe</div>
            </th>
            <th>
                <div align="center">MVP's</div>
            </th>
            <th>
                <div align="center">Status</div>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php 
        include('jobs.php');
        $i = 0;
        if( $chars ):
            foreach ($chars as $c) :
            $i = $i+1;
            
            if($c->online == 0) { $onlines = "<font color='red' face='Verdana'> OFFLINE </font>";}
            if($c->online == 1) { $onlines = "<font color='green' face='Verdana'> ONLINE </font>";}
    ?>
    <tr>
        <td>
            <div align="center">
                <?PHP 
                    if ($i == 1) {
                           echo "<div  align='center' class='info'><img src='" . get_template_directory_uri() . "/images/medal_" . $i . ".gif '/> ";
                        }elseif ($i == 2) {
                           echo "<div  align='center' class='info'><img src='" . get_template_directory_uri() . "/images/medal_" . $i . ".gif '/> ";
                        }elseif ($i == 3) {
                           echo "<div  align='center' class='info'><img src='" . get_template_directory_uri() . "/images/medal_" . $i . ".gif '/> ";
                        }else{
                        
                        echo $i;
                        }

                        ?>
            </div></td>
            <td>
                <div align="center">
                    <?php echo $c->char_name;?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?php echo $c->base_level?>
                    / 
                    <?php echo $c->job_level?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?php echo $job[$c->class]?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?php echo($c->pontos_mvp); ?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?php echo $onlines; ?>
                </div>
            </td>
        </tr>
    <?php
    endforeach;
    else:
        echo "Sem Caçadores de MVPs no momento... trágico...";
    endif;
    ?>
    </tbody>
</table>