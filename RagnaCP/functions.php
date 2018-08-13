<?php 
// Algumas funções úteis
require_once( get_template_directory() . '/functions-common.php' );
// Criação de tipos de post personalizados
include_once( get_template_directory() . '/functions-post-types.php' );
// Criação de campos personalizados
include_once( get_template_directory() . '/functions-custom-fields.php' );
// Criação de shortcodes personalizados
include_once( get_template_directory() . '/functions-shortcodes.php' );

if ( !class_exists( 'ragna_theme' ) ) :

    class ragna_theme {

        function init() {
            if ( function_exists( 'add_post_type_support' ) ) {
                add_post_type_support( 'page', 'excerpt' ); // suporte a resumo em páginas
            }
            if ( function_exists( 'add_theme_support' ) ) {
                add_theme_support( 'automatic-feed-links' );
                add_theme_support( 'post-thumbnails' );
                add_theme_support( 'menus' );
                if ( function_exists( 'register_nav_menus' ) ) {
                    call_user_func( array( __CLASS__, 'register_menus' ) );
                }
            }
            
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts_e_estilos' ) );

            call_user_func( array( __CLASS__, 'myStartSession', ) ) ;
        }

        // Menus
        function register_menus() {
            register_nav_menus(
                array(
                    'principal' => __( 'Menu Principal' ),
                    'logado' => __( 'Menu logado' ),
                    'admin' => __( 'Menu admin' )
                )
            );
        }
        
        function myStartSession() {
           if(!session_id()) {
               session_start();
           }
        }

        // Javascripts e CSSs
        function scripts_e_estilos() {
            // Javascript
            wp_enqueue_script( 'ragna_scripts', get_stylesheet_directory_uri() . '/js/ragna.js', array( 'jquery' ),wp_get_theme()->get('Version'), true );
            wp_enqueue_script( 'ragna_scripts', get_stylesheet_directory_uri() . '/js/html5shiv.min.js', array( 'jquery' ), wp_get_theme()->get('Version'), true );

            // CSS Normalize
            wp_register_style( 'ragna_normalize', get_stylesheet_directory_uri() . '/css/normalize.css', '', '0.01' );
            wp_enqueue_style( 'ragna_normalize' );

            // CSS Geral
            wp_register_style( 'ragna_style', get_stylesheet_directory_uri() . '/css/ragna.css', '', '0.01' );
            wp_enqueue_style( 'ragna_style' );

            // CSS Mobile
            wp_register_style( 'ragna_style_mobile', get_stylesheet_directory_uri() . '/css/mobile.css', '', '0.01' );
            wp_enqueue_style( 'ragna_style_mobile' );

            add_action( 'after_setup_theme', 'register_my_menu' );
            register_nav_menu( 'primary', __( 'Primary Menu', 'theme-slug' ) );

            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on RagnaCP, use a find and replace
             * to change 'RagnaCP' to the name of your theme in all the template files
             */
            load_theme_textdomain( 'ragna_theme', get_template_directory() . '/languages' );

            // Add default posts and comments RSS feed links to head.
            add_theme_support( 'automatic-feed-links' );

            /*
             * Let WordPress manage the document title.
             * By adding theme support, we declare that this theme does not use a
             * hard-coded <title> tag in the document head, and expect WordPress to
             * provide it for us.
             */
            add_theme_support( 'title-tag' );

            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
             */
            add_theme_support( 'post-thumbnails' );
            set_post_thumbnail_size( 825, 510, true );
            /*
             * Switch default core markup for search form, comment form, and comments
             * to output valid HTML5.
             */
            add_theme_support( 'html5', array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
            ) );

            /*
             * Enable support for Post Formats.
             *
             * See: https://codex.wordpress.org/Post_Formats
             */
            add_theme_support( 'post-formats', array(
                'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
            ) );

        }

    }

    add_action( 'init', array( 'ragna_theme', 'init' ) );

else :
    wp_die( 'A classe "ragna_theme" foi duplicada, o que aparentemente não deveria acontecer. Entre em contato com o desenvolvedor.' );
endif;

function ragna_theme_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Widget Personalizado', 'ragna' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Appears in the footer section of the site.', 'ragna' ),
        'before_widget' => '<div id="%1$s" class="box widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title box-title">',
        'after_title'   => '</h3>',
    ) );

     register_sidebar( array(
        'name'          => __( 'Player Menu', 'ragna' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Appears on posts and pages in the sidebar.', 'ragna' ),
        'before_widget' => '<div id="%1$s" class="box widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title box-title">',
        'after_title'   => '</h3>',
    ) );

      register_sidebar( array(
        'name'          => __( 'Admin Menu', 'ragna' ),
        'id'            => 'sidebar-3',
        'description'   => __( 'Appears on posts and pages in the sidebar.', 'ragna' ),
        'before_widget' => '<div id="%1$s" class="box widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title box-title">',
        'after_title'   => '</h3>',
    ) );

    if ( function_exists( 'add_post_type_support' ) ) {
        add_post_type_support( 'page', 'excerpt' );
    }
    

}

add_action( 'widgets_init', 'ragna_theme_widgets_init' );

require get_template_directory() . '/inc/custom-header.php';

?>
