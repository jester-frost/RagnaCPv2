<?php 
	/* Template Name: [ Logs ADMIN ] */
    include( get_template_directory() . '/includes/config.php');
    // PDO database LOG
    $log_con = new PDO("mysql:host=$host;dbname=$logdatabase"
        ,$user
        ,$userpass,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        )
    );
    $logs = $log_con->prepare("SELECT * FROM `atcommandlog` WHERE `account_id`>1999999 AND `account_id`<2000004");
    $logs->execute();
    $admin_logs = $logs->fetchAll(PDO::FETCH_OBJ);
    $resumo = get_the_excerpt();
    get_header();
?>
    <section class="conteudo">
        <aside class="left">
            <?php include( get_template_directory() . '/includes/menu-left.php' ); ?>
        </aside>
        <article>
            <div class="box">
                <h3 class="box-title"><?php the_title(); ?></h3>
                <div class="spacer">
                    <?php if($resumo): ?>
                        <h4><?php echo $resumo; ?></h4>
                    <?php endif; ?>
                    <?php the_content(); ?>
                    <table  id="conteudo" class="mvp-table" style="text-align: center; max-height: 800px; overflow: auto; display: block;">
                        <thead>
                            <tr class="ranking">
                                <th>
                                    N°
                                </th>
                                <th>
                                    <div align="center">Nome do GM </div>
                                </th>
                                <th>
                                    <div align="center">Data / Horário</div>
                                </th>
                                <th>
                                    <div align="center">Comando</div>
                                </th>
                                <th>
                                    <div align="center">Mapa</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($admin_logs): ?>
                                <?php $i = 0; foreach ($admin_logs as $log): ?>
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $log->char_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $log->atcommand_date; ?>
                                        </td>
                                        <td>
                                            <?php echo $log->command; ?>
                                        </td>
                                        <td>
                                            <?php echo $log->map; ?>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td></td>
                                <td>Nenhum comando usado até agora =)</td>
                                <td></td>
                            </tr>
                           <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div id="comments" class="comments-area">
                    </div>
                </div>
            </div>
        </article>
        <aside class="right">
            <?php include( get_template_directory() . '/includes/vote.php' ); ?>
        </aside>
    </section>
<?php get_footer(); ?>