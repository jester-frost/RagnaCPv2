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
                        <span class="char clearfix">
                            <div class='info'>
                                <div class='pvp-char'>
                                    <img src="<?php echo get_template_directory_uri(); ?>/chargen/avatar/<?php echo $dado->name ?>"/> 
                                </div>
                            </div>
                        </span>
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