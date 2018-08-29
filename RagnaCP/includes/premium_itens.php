<?php 
	if ( $_SESSION["usuario"] )  :
	   $itens = lista_itens($con, $item_db);
    endif;
    $account_id = $_SESSION["usuario"]->account_id;     // conta do usuario
    $lista_chars = lista_personagens($con, $_SESSION["usuario"]->account_id );

    if( isset( $GET['comprar'] ) && isset( $GET['char_id'] ) ){
        $item_id = $GET['comprar'];                         // id do item
        $char_id = $GET['char_id'];                         // Id do personagem
        $dados = compra_item( $con, $item_id, $account_id, $char_id );
    }
 ?>

<div id="resultado">

    <?php if( $lista_chars ): ?>

        <select name="char_id" id="">
            <?php foreach ($lista_chars as $char): ?>
                <option value="<?php echo $char->char_id; ?>"><?php echo $char->name; ?></option>
            <?php endforeach; ?>
        </select>

        <?php if( $itens ): ?>
    	<ul class="lojinha_list" >
            <?php foreach ($itens as $item): ?>
                <?php $item =  (array) $item; ?>
            <li>
                <p><?php echo $item['name_japanese'];  echo " [".( 0 + $item['slots'] )."] "; echo "<sup>".$item['item_price'] ." Rop's</sup>"; ?></p>
                <figure>
                    <img src = "https://static.divine-pride.net/images/items/collection/<?php echo $item['item_id']; ?>.png">
                    <figcaption>
                        <?php if( $item['atk:matk'] ): ?>
                           <p>Atk / Matk =  <?php echo str_replace(":", " / ", $item['atk:matk']); ?></p>
                        <?php endif; ?>
                        <?php if( $item['defence'] ): ?>
                            <p>Defence = <?php echo $item['defence']; ?></p>
                        <?php endif; ?>
                        <?php if( $item['script'] ): ?>
                            <p>Script { <small><?php echo $item['script']; ?></small> }</p>
                        <?php endif; ?>
                        <a href="?comprar=<?php echo $item['id']; ?>" class="btn">Comprar</a>
                    </figcaption>
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