<?php 
    $aba = $_POST['aba'];
    if(!$aba){
        $aba = 1;
    }
?>
<nav class="tab-nav">
    <a href="#tab-1" class="tab-item <?php if($aba == 1) : ?> active <?php endif; ?>" >ACC ID</a>
    <a href="#tab-2" class="tab-item <?php if($aba == 2) : ?> active <?php endif; ?>" >Email</a>
    <a href="#tab-3" class="tab-item <?php if($aba == 3) : ?> active <?php endif; ?>ip-tab" >IP</a>
    <a href="#tab-4" class="tab-item <?php if($aba == 4) : ?> active <?php endif; ?>" >Char</a>
    <a href="#tab-5" class="tab-item <?php if($aba == 5) : ?> active <?php endif; ?>edit-tab" >Editar Conta</a>
    <a href="#tab-6" class="tab-item <?php if($aba == 6) : ?> active <?php endif; ?>char-info-tab" >Char Info</a>
    <a href="#tab-7" class="tab-item <?php if($aba == 7) : ?> active <?php endif; ?>acc-ban" >Ban</a>
</nav>
<div class="tab-content">
    <div id="tab-1" <?php if($aba != 1) : ?> class="hide" <?php endif;?>>
        <h3> Insira o ID a ser Pesquisado</h3>
        <hr>
        <?php include"admin_accid_search.php";?>
    </div>
    <div id="tab-2" <?php if($aba != 2) : ?> class="hide" <?php endif;?>>
        <h3> Insira o Email a ser Encontrado</h3>
        <hr>
        <?php include"admin-email-search.php";?>  
    </div>
    <div id="tab-3" <?php if($aba != 3) : ?> class="hide" <?php endif;?>>
        <h3> Insira IP a ser Encontrado</h3>
        <hr>
        <?php include"admin-ip-search.php";?>  
    </div>
    <div id="tab-4" <?php if($aba != 4) : ?> class="hide" <?php endif;?>>
        <h3> Insira o nome do Char Encontrado</h3>
        <hr>
        <?php include"admin-char-search.php";?>  
    </div>
    <div id="tab-5" <?php if($aba != 5) : ?> class="hide" <?php endif;?>>
        <h3> Editar Conta</h3>
        <hr>
        <?php include"edit-char-admin.php";?>  
    </div>
    <div id="tab-6" <?php if($aba != 6) : ?> class="hide" <?php endif;?>>
        <h3> Informações do Personagem</h3>
        <hr>
        <?php include"list-char-admin.php";?>  
    </div>
    <div id="tab-7" <?php if($aba != 7) : ?> class="hide" <?php endif;?>>
        <h3> Banir / Desbanir conta</h3>
        <hr>
        <?php include"ban-char-admin.php";?>  
    </div>
</div>
