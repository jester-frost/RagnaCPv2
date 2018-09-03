<?php 
    if ( $_SESSION["usuario"] )  :
       $itens = lista_itens( $con, $item_db);
    endif;
    $account_id = $_SESSION["usuario"]->account_id;     // conta do usuario
    $lista_chars = lista_personagens($con, $_SESSION["usuario"]->account_id );

    $cash = verifica_rops($con, $account_id);

    if( isset( $_POST['char_id'] ) && isset( $_POST['item_id'] ) ){
        $item_id = str_replace( $letters, "", $_POST['item_id'] );
        $char_id = str_replace( $letters, "", $_POST['char_id'] );
        $dados = compra_item( $con, $item_id, $account_id, $char_id );
    }

    $type = array(
        0 => "Usable",
        1 => "Usable",
        2 => "Usable",
        3 => "Misc",
        4 => "Equipment",
        5 => "Equipment",
        6 => "Card",
        7 => "",
        8 => "",
    );

    $jobs_equip = array(
        4294967295 => "Every Jobs",
        4294967294 => "Every Rebirth Job except High Novice",
        33554432 => "Ninja",
    );
 ?>

<div id="resultado">
    <?php if( $dados['rops']->value ): ?>
        <p>Cash na conta: <?php echo $dados['rops']->value; ?>  Rop's</p>
    <?php else: ?>
        <p>Cash na conta: <?php echo $cash->value; ?>  Rop's</p>
    <?php endif; ?>
    <?php if( $lista_chars ): ?>
        <?php if( $dados['msg'] ): ?>
            <p class="msg"> <?php echo $dados['msg']; ?></p>
        <?php endif; ?>
        <?php if( $itens ): ?>
        <ul class="lojinha_list" >
            <?php foreach ($itens as $item): ?>
                <?php $item =  (array) $item; ?>
            <li>
                <h4><?php echo $item['name_japanese']; ?></h4>
                <p>Valor: <?php echo "<sup>".$item['item_price'] ." Rop's</sup>"; ?> </p>
                <a href="#" class="show-info"> + </a>
                <figure>
                    <img src = "https://static.divine-pride.net/images/items/collection/<?php echo $item['item_id']; ?>.png">
                    <figcaption>
                        <div class="item_info hide">
                            <h4><?php echo $item['name_japanese']; ?></h4>
                            <img src = "https://static.divine-pride.net/images/items/collection/<?php echo $item['item_id']; ?>.png">
                            <?php if( $item['slots'] ): ?>
                                <p><strong>Slots: </strong><?php  echo "[".( 0 + $item['slots'] )."]";  ?></p>
                            <?php endif; ?>
                            <?php if( $item['atk:matk'] ): ?>
                               <p><strong>Atk / Matk :</strong>  <?php echo str_replace(":", " / ", $item['atk:matk']); ?></p>
                            <?php endif; ?>
                            <?php if( $item['defence'] ): ?>
                                <p><strong>Defence :</strong> <?php echo $item['defence']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['weight'] ): ?>
                               <p><strong>Weigth :</strong>  <?php echo $item['weight']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['weapon_level'] ): ?>
                               <p><strong>Weapon Level :</strong>  <?php echo $item['weapon_level']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['range'] ): ?>
                               <p><strong>Range Level :</strong>  <?php echo $item['range']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['type'] ): ?>
                               <p><strong>Type :</strong>  <?php echo $type[$item['type']]; ?></p>
                            <?php endif; ?>
                            <?php if( $item['equip_jobs'] ): ?>
                               <p><strong>Jobs :</strong>  <?php echo $jobs_equip[$item['equip_jobs']]; ?></p>
                            <?php endif; ?>
                            <?php if( $item['equip_level'] ): ?>
                               <p><strong>Level Required :</strong>  <?php echo $item['equip_level']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['script'] ): ?>
                                <p><strong>Script</strong> { <small><?php echo $item['script']; ?></small> }</p>
                            <?php endif; ?>
                            <?php if( $item['equip_script'] ): ?>
                                <p><strong>Script Equiped</strong> { <small><?php echo $item['equip_script']; ?></small> }</p>
                            <?php endif; ?>
                            <?php if( $item['unequip_script'] ): ?>
                                <p><strong>Script Unequiped</strong> { <small><?php echo $item['unequip_script']; ?></small> }</p>
                            <?php endif; ?>
                        </div>
                    </figcaption>
                    <form method="post" name="comprar" action="">
                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                        <div class="custom-select">
                            <select name="char_id" id="">
                                <?php foreach ($lista_chars as $char): ?>
                                    <option value="<?php echo $char->char_id; ?>"><?php echo $char->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="arrow">▼</div>
                        </div>
                        <input type="submit" class="btn" value="Comprar"/>
                    </form>
                </figure>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <p>Sem itens Cadastrados.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Você precisa ter pelo menos um personagem para que sejam entregues os itens via Rodex.</p>
    <?php endif; ?>
</div>