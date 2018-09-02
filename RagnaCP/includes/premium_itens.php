<?php 
    if ( $_SESSION["usuario"] )  :
       $itens = lista_itens( $con, $item_db);
    endif;
    $account_id = $_SESSION["usuario"]->account_id; // conta do usuario
    $lista_chars = lista_personagens($con, $_SESSION["usuario"]->account_id );
    $cash = verifica_rops($con, $account_id);
    if( isset( $_POST['char_id'] ) && isset( $_POST['item_id'] ) ){
        $item_id = str_replace( $letters, "", $_POST['item_id'] );
        $char_id = str_replace( $letters, "", $_POST['char_id'] );
        $dados = compra_item( $con, $item_id, $account_id, $char_id );
    }
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
                                <p>Slots: <?php  echo "[".( 0 + $item['slots'] )."]";  ?></p>
                            <?php endif; ?>
                            <?php if( $item['atk:matk'] ): ?>
                               <p>Atk / Matk =  <?php echo str_replace(":", " / ", $item['atk:matk']); ?></p>
                            <?php endif; ?>
                            <?php if( $item['defence'] ): ?>
                                <p>Defence = <?php echo $item['defence']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['weight'] ): ?>
                               <p>Weigth =  <?php echo $item['weight']; ?></p>
                            <?php endif; ?>
                            <?php if( $item['script'] ): ?>
                                <p>Script { <small><?php echo $item['script']; ?></small> }</p>
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