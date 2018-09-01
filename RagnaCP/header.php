<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage RagnaCP
 * @since RagnaCP 2.0
 */
	require ( get_template_directory() . '/includes/config.php');
	if ( $_GET['logout'] == 'sim' ) {
		unset($_SESSION["usuario"]);
		session_destroy();
		wp_redirect( home_url() );
	}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo home_url(); ?>/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url(); ?>/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php echo $seu_nome; ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script id="ragna-js" src="<?php bloginfo('template_directory'); ?>/js/jquery.js" type="text/javascript"></script>
	<script id="ragna-js" src="<?php bloginfo('template_directory'); ?>/js/mask.js" type="text/javascript"></script>
	<script id="ragna-js" src="<?php bloginfo('template_directory'); ?>/js/slick.min.js" type="text/javascript"></script>
	<!-- Char Maker por Marcos Gonçalves -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/make.css" type="text/css" media="all">
	<script id="ragna-js" src="<?php bloginfo('template_directory'); ?>/js/make.js" type="text/javascript"></script>
	<script>
		function mascara(o,f){
		    v_obj=o
		    v_fun=f
		    setTimeout("execmascara()",1)
		}
		function execmascara(){
		    v_obj.value=v_fun(v_obj.value)
		}
		function mvalor(v){
		    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
		    v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
		    v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
		    v=v.replace(/(\d)(\d{2})$/,"$1.$2");//coloca o ponto antes dos 2 últimos dígitos
		    return v;
		}
	</script>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<div id="mycursor"></div>
<div id="page" class="hfeed site">
	<div class="top-content limit">
		<?php include( get_template_directory() . '/includes/login.php' ); ?>
		<?php include( get_template_directory() . '/includes/server-name.php' ); ?>
		<?php include( get_template_directory() . '/includes/status.php' ); ?>
	</div>
	<div class="content-site limit">
		<nav class="menu-principal">
			<?php wp_nav_menu( array( 'theme_location' => 'principal') ); ?>
		</nav>
		<div id="content" class="site-content limit">