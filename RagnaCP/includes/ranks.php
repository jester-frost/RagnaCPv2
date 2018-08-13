<div class="box">
    <?php while ( have_posts() ) : the_post();?>
    	<h3 class="box-title"><?php the_title(); ?></h3>
        <div class="spacer">
            <?php if($resumo){ ?>
                <h4><?php echo $resumo; ?></h4>
            <?php }; ?>
            <?php the_content(); ?>
            <nav class="tab-nav">
                <a href="#tab-1" class="tab-item active" >Top Players</a>
                <a href="#tab-2" class="tab-item" >Top Zeny</a>
                <a href="#tab-3" class="tab-item" >Top Guilds</a>
                <a href="#tab-4" class="tab-item" >Top Homunculus</a>
            </nav>
            <div class="tab-content">
                <div id="tab-1">
                    <h3> Top Players</h3>
                    <div class="span2">
                        <input type="search" class="ipt" name="buscamarota" id="buscamarota" placeholder="Procurar..." class="btn"></input>
                    </div>
                    <hr>
                <?php include"rank_player.php";?>  
                </div>
                <div id="tab-2" class="hide">
                    <h3> Top Zeny</h3>
                    <hr>
                    <?php include"topzeny.php";?>  
                </div>
                <div id="tab-3" class="hide">
                    <h3> Top Guild</h3>
                    <hr>
                    <?php include"top_guild.php";?>  
                </div>
                <div id="tab-4" class="hide">
                    <h3> Top Homunculus </h3>
                    <hr>
                    <?php include"top_homunculo.php";?>  
                </div>
            </div>
        </div>
    	<div class="box-footer"></div>
    <?php endwhile;?>
</div>