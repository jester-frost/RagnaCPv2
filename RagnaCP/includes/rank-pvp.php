<?php
    /* PHP Insano começa aqui */
    $dados =  carrega_rankPVP($con);
?>
<?php if( $dados ): ?>
    <div class='carousel'>
        <div class='carousel-inner'>
            <ul>
            <?php $i=0; foreach ($dados as $dado ) : $i++; ?>
                <li>
                    <div>
                        <span class="char clearfix"><?php $info = char_info($con, $dado->char_id);?></span>
                        <div class="posicao">
                            <span>Matou: <?php echo $dado->kills;?></span>
                            <span>Morreu: <?php echo $dado->deaths;?></span>
                        </div>
                        <p><?php echo $i; ?></p>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
        <div class="carousel-pagination">
        </div>
    </div>
<?php else: ?>
    <p>Sem players no Rank ... ora ora ... bora se matar gente que isso !! '-'</p>
<?php endif; ?>