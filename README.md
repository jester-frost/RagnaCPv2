# RagnaCPv2
RagnaCP v2 ( Emulador usado e testado rAthena)
Tema de wordpress com funções similares ao CeresCP

Para utilizar o Tema será necessário baixar o [Wordpress](https://br.wordpress.org/download/)
Os temas deverão ficar na pasta themes dentro de wordpress/wp-content

# Pré requisitos
	PHP versão >= 5.6.29
	MySQL >= 5.4 ou MariaDB >= 10.1.34
    WordPress >= 4.7.11
	CUrl habilitado ( Para o PagSeguro )
	SimpleXML habilitado ( Para o PagSeguro )
	
# Colabore
Se deseja nos apoiar com desenvolvimeno desse projeto faça uma doação.
<a rel="donate" href="https://pag.ae/bhC5mN6"><img src="https://stc.pagseguro.uol.com.br/public/img/botoes/doacoes/120x53-doar-azul.gif" alt=""></a>
	
# licença

<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Licença Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Dataset" property="dct:title" rel="dct:type">Tema RagnaCP</span> de <a xmlns:cc="http://creativecommons.org/ns#" href="ragnacrashers.com.br" property="cc:attributionName" rel="cc:attributionURL">Marcos Gonçalves de Lima</a> está licenciado com uma Licença <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons - Atribuição 4.0 Internacional</a>.<br />Baseado no trabalho disponível em <a xmlns:dct="http://purl.org/dc/terms/" href="https://github.com/jester-frost/RagnaCP/" rel="dct:source">https://github.com/jester-frost/RagnaCP/</a>.<br />Podem estar disponíveis autorizações adicionais às concedidas no âmbito desta licença enviando email para: <a xmlns:cc="http://creativecommons.org/ns#" href="mailto:marcos@visie.com.br" rel="cc:morePermissions">marcos@visie.com.br</a>
# Configurações
    //===================== Configurações VItáis para o painel =========================
    //
    //
    //
    $host="127.0.0.1"; // Host localhost ou 127.0.0.1 ou seu host
    $database="ragnarok"; // Banco de dados do Servidor
    $user="ragnarok";   // Usuário de acesso ao banco de dados do servidor
    $userpass="ragnarok";    // Senha do Usuário de acesso ao bando de dados do servidor
    $con = new PDO("mysql:host=$host;dbname=$database"
        ,$user
        ,$userpass,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        )
        );
    // Mapa de inicio do personagem ( Mudar de acordo com os critérios do servidor)
    $mapa = 'new_1-1';
    $mapa_x = 53;
    $mapa_y = 111;
    $level_admin = 80; // Aqui o level de ADMIN ( group_id ) do administrador
    $stats_points = 48; // Quantia de pontos de Status o personagem tem para usar ao criar o personagem
    $qtd_cabelos = 45; // quantia de estilos de cabelo do seu servidor (OBS: ficar atento as imagens pois podem não corresponder as mesmas imagens do seu servidor)
    //
    // =================================================================================

    // =================================================================================
    
    // ================== Configuração de envio de emails com senha ====================
    //
    //
    //
    // Recomendo a todos usarem um email do Gmail mesmo, pois é muito bom e vai ser uma coisa a menos pra pesar na banda do servidor
    // Outro detalhe, é preciso habilitar Aplicativos menos seguros, https://support.google.com/accounts/answer/6010255?hl=pt-BR, e configurar o SMTP do email a ser usado
    $pagina_recuberacao = 'recuperar-senha';
    $assunto = 'Recuperação de Senha';
    $seu_email      =   'seuemail@gmail.com';
    $seu_nome       =   'RagnaCP';
    $sua_senha      =   'suasenha1234';
    /* Se for do Gmail o servidor é: smtp.gmail.com */
    $host_do_email  =   'smtp.gmail.com';
    /* Porta da conexão */
    $sua_porta  = "465";
    //
    //
    //
    // =================================================================================
    // ============== Escape de caracteres que podem prejudicar o Servidor =============
    //
    //                                  Evitando Merda
    $letters_char =array("<", "°", ">", "'",  "\"", "\\",  "/", "(", ")", ";","`", "¿","", "=", "?", ":", "-", "%");
    $letters =array("<", "Ã", "°", ">", "'",  "\"", "\\",  "/", "(", ")", ";","`", "¿", "ð","","Â", " ", "=", "?", ":", "%" );
    //
    // ========================== Fim das configurações vitais =========================
    // ============================= Configurações Extras ==============================
    //
    //
    // Daqui para baixo são configurações extras, não vai afetar o funcionamento do Painel em si;
    //
    //
    //================================ Suporte Pass MD5 ================================
    //
    // MD5 Pass, suporte para login e modificação de senha
    // true ou false
    $md5 = false;
    /*  Tabela da recuperação de senha deve ser inserida no BD do servidor
    
        CREATE TABLE `passchange` (
          `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
          `hash` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `data_change` datetime(6) NOT NULL,
          `change_validate` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    */
    //
    // ================================================================================
    // ============================= maldito vote points ==============================
    //
    // 
    // true or falsedoacao/
    $vote_points = true;
    // Aqui os links dos tops que seu servidor foi cadastrado
    //
    $points_for_click = 3;
    //
    //
        if ($vote_points) {
            // Tempo de votação 24 Horas
            $tempo = 24; // equivalente a 24 horas
            
            /* Tabela SQL do vote por pontos
            CREATE TABLE `vote_point` (
            `account_id` int(11) NOT NULL default '0',
            `point` int(11) NOT NULL default '0',
            `last_vote1` int(11) NOT NULL default '0',
            `last_vote2` int(11) NOT NULL default '0',
            `last_vote3` int(11) NOT NULL default '0',
            `date` text NOT NULL,
            PRIMARY KEY (`account_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
            */

            $link_array = array(
                1 => "http://www.topservers200.com/in.php?id=15873",
                2 => "http://www.topragnarok.com.br/index.php?s=vote&id=22134",
                3 => "http://www.topragnarok100.com.br/votar/rgcrashers",
            );

            $links = $link_array;
        }
    //
    //
    // ===============================================================================
    // ======================= Aplicação externa MVP Timer ===========================
    // MVP Timer
    // true or false
    // marca o Time de MVP morto
    $mvp_timer = true;
    $mvp_link ="http://ragnarokmvp.com.br/";
    //
    //
    // ===============================================================================
    // =========================== Aplicação Pague Seguro ============================
    //
    // == Recomendável ler a documentação do pague seguro antes de habilitar isso aqui
    //
    // Pagueseguro app
    // true or false
    //
    $pagueseguro = true;
    //
    /*
        SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        SET time_zone = "+00:00";
        CREATE TABLE `doacao` (
          `account_id` int(11) UNSIGNED NOT NULL,
          `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `valor` int(11) NOT NULL,
          `Rops` int(11) NOT NULL,
          `estado` int(11) UNSIGNED NOT NULL DEFAULT '0',
          `transaction_id` varchar(100) NOT NULL DEFAULT '',
          `email` varchar(100) NOT NULL DEFAULT ''
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    */
    // ===============================================================================
    // Token gerado pelo pague seguro
    $sandbox = false;
    if( $sandbox ){
        $token = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    }else{
        $token = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    }
    //
    // Endereço de Site sem a barra no final 
    $site = "http://site_do_seu_servidor.com.br"; // Seu endereço de site onde ficará instalado o wordpress,( geralmente abre-se a pasta do wordpress pega tudo o que tem dentro e deixa solto no www )
    //
    // a poha da moeda brasileira
    $moeda ='BRL';
    //
    // tipo de tranzação 
    $type =1; // Não mexer é a tranzação, para saber mais a respeito consulte a documentação do pagueseguro
    //
    // Seu email do pague seguro
    $pgemail = 'email_pagseguro@gmail.com='; // Email da sua conta do pagueseguro
    //
    // Default 1, equivale ao numero de produtos comprados, deixar 1 para não ser multiplicado pelo valor;
    // Caso queira mexer ou transformar em planos, use um select com valores pré estabelecidos
    $qtd = 1; 
    //
    // Quantos ROPs ou Cash por Real
    $rops_por_real = 1000 ;
    //
    // O que está vendendo é Cash ou Rops ..
    $id_do_item = 1;
    $desc_do_item = 'Rops';
    //
    // ===============================================================================
    //
    // Caso queira usar Planos com valores fixos habilite 
    // valor boleano, true ou false, ( Default False )
    // Configure as variaveis com o valor que desejar
    //
    $planos = false;
    $plano1 = 15.00;
    $plano2 = 25.00;
    $plano3 = 35.00;
    //
    // ===============================================================================
    //
    //
    //
    // ===============================================================================
