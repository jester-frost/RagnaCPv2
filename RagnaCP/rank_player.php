<?php
    include('config.php');
    $dados = topplayer($con, $string, $level_admin);
    $i = 0;
?>
<table  id="conteudo" class="rank-player">
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
                <div align="center">Guilda</div>
            </th>
            <th>
                <div align="center">Status</div>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php
        include('jobs.php');
        foreach ($dados as $c) :
            $i = $i+1;
            if($c->online == 0) { $onlines = "<font color='red' face='Verdana'> OFFLINE </font>";}
            if($c->online == 1) { $onlines = "<font color='green' face='Verdana'> ONLINE </font>";}
    ?>
    <tr>
        <td>
            <div align="center">
                <?PHP echo $i;?>
            </div></td>
            <td>
                <div align="center">
                    <?PHP echo $c->name;?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $c->base_level?>
                    / 
                    <?PHP echo $c->job_level?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $job[$c->class]?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?php echo $c->guildname; ?>
                </div>
            </td>
            <td>
                <div align="center">
                    <?PHP echo $onlines; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>