<?php

// Diminuindo a resolução padrão das imagens JPG
if ( !function_exists( 'commonwp_jpeg_quality_callback' ) ) :

    function commonwp_jpeg_quality_callback( $arg ) {
        return 60;
    }
    add_filter( 'jpeg_quality', 'commonwp_jpeg_quality_callback' );

endif;


// Retorna a URL de um arquivo com um parâmetro no final contendo
// o momento da última modificação deste arquivo (para evitar
// caching quando houver alteração)
if ( !function_exists( 'wp_anticache' ) ) :

    function wp_anticache( $file, $onlyappend = false ) {
        if ( '/' == substr( $file, 0, 1 ) ) $file = substr( $file, 1 );
        $filename = $file;
        $file = get_theme_root() . '/' . get_template() . '/' . $file;
        if ( file_exists( $file ) ) {
            $append = date( 'U', filemtime( $file ) );
        } else {
            $append = rand( 1000, 9999 );
        }
        return $onlyappend ? $append : get_bloginfo( 'template_directory' ) . '/' . $filename . '?' . $append;
    }

endif;


// Retorna a URL atual
if ( !function_exists( 'curPageURL' ) ) :

    function curPageURL() {
        $pageURL = 'http';
        if ( $_SERVER["HTTPS"] == "on" ) {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ( $_SERVER["SERVER_PORT"] != "80" ) {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

endif;


// Busca o conteúdo de um recurso externo (URL) e mantém um cache
if ( !function_exists( 'url_get_contents' ) ) :

    function url_get_contents( $url, $exptime = 1, $curltimeout = 10 ) {
        $exptime *= 3600;
        $dir = WP_CONTENT_DIR . '/cache/';
        if ( ( !is_dir( $dir) || !is_writable( $dir ) ) && is_writable( WP_CONTENT_DIR ) )
            mkdir( $dir, 0664, true );
        if ( !is_dir( $dir ) || !is_writable( $dir ) )
            $dir = '/tmp/cachewp/';
        if ( (!is_dir( $dir ) || !is_writable( $dir ) ) && is_writable( '/tmp/' ) )
            mkdir( $dir, 0777, true );
        $md5 = md5( $url );
        $cachefile = $dir . $md5 . '.txt';
        if ( file_exists( $cachefile ) && ( !$exptime || date( 'U', filemtime( $cachefile ) ) > ( date('U') - $exptime ) ) ) {
            $ret = file_get_contents( $cachefile );
        } else {
            if ( function_exists( 'curl_init' ) ) {
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $curltimeout );
                $ret = curl_exec( $ch );
                curl_close( $ch );
            } else {
                $ret = file_get_contents( $url );
            }
            if ( $ret !== false && '' != trim( $ret ) && is_dir( $dir ) )
                file_put_contents( $cachefile, $ret );
        }
        return $ret;
    }

endif;


// Parseia uma URL de vídeo (youtube ou vimeo) e retorna a(s) miniatura(s)
if ( !function_exists( 'parse_video_url' ) ) :

    function parse_video_url( $urlvideo, $classe = 'parsedvideo', $width = 738, $height = 433, $autoplay = false ) {
        $id = false;
        if( preg_match( '/https?:\/\/(([^\.]+)\.)?youtu(be\.com\/watch\?(.*?)v=|\.be\/)([^&]+)/ims', $urlvideo, $m ) ) {
            $id = $m[5];
            $thumb_large = 'http://img.youtube.com/vi/' . $id . '/0.jpg';
            $thumb_small = 'http://img.youtube.com/vi/' . $id . '/1.jpg';
            $embedsrc = 'http://www.youtube.com/embed/' . $id . ( $autoplay ? '?autoplay=1' : '' );
            $embed = '<iframe class="' . $classe . '" width="' . $width . '" height="' . $height . '" src="' . $embedsrc . '" frameborder="0" webkitallowfullscreen="webkitallowfullscreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen"></iframe>';
        }
        if( preg_match( '/https?:\/\/(([^\.]+)\.)?vimeo\.com\/([0-9]+)/ims', $urlvideo, $m ) ) {
            $id = $m[3];
            $thumb_large = '';
            $thumb_small = '';
            $apiurl = "http://vimeo.com/api/v2/video/$id.php";
            $hash = unserialize( function_exists( 'url_get_contents' ) ? url_get_contents( $apiurl, 0 ) : file_get_contents( $apiurl ) );
            if ( count( $hash ) ) {
                $thumb_large = $hash[0]['thumbnail_large'];
                $thumb_small = $hash[0]['thumbnail_small'];
            }
            $embedsrc = 'http://player.vimeo.com/video/' . $id . ( $autoplay ? '?autoplay=1' : '' );
            $embed = '<iframe class="' . $classe . '" src="' . $embedsrc . '" width="' . $width . '" height="' . $height . '" frameborder="0" webkitallowfullscreen="webkitallowfullscreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen"></iframe>';
        }
        if ( $id ) {
            return array(
                        'video_id' => $id,
                        'video_thumb_large' => $thumb_large,
                        'video_thumb_small' => $thumb_small,
                        'video_embedsrc' => $embedsrc,
                        'video_embed' => $embed,
                        'video_url' => $urlvideo,
                    );
        }
        return false;
    }

endif;


// Procura página(s) que usa(m) determinado template
if ( !function_exists( 'get_pages_by_template' ) ) :

    function get_pages_by_template( $template ) {
        if ( substr( $template, -4 ) != '.php' ) $template .= '.php';
        $pages = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => $template, 'hierarchical' => 0 ) );
        return $pages;
    }
    function get_page_by_template( $template, $which = 'first' ) {
        $pages = get_pages_by_template( $template );
        if ( count( $pages ) ) {
            $ind = 0;
            if ( 'last' == $which ) {
                $ind = count( $pages ) - 1;
            } elseif( is_numeric( $which ) && ( $which < count( $pages ) ) ) {
                $ind = $which;
            }
            return $pages[$ind];
        }
        return false;
    }

endif;


// Retorna apenas a URL da imagem destacada (não a tag inteira)
if ( !function_exists( 'get_post_thumbnail_src' ) ) :

    function the_post_thumbnail_src( $size = 'thumbnail' ) {
        echo get_the_post_thumbnail_src( $size );
    }

    function get_the_post_thumbnail_src( $size = 'thumbnail' ) {
        return get_post_thumbnail_src( get_the_ID(), $size );
    }

    function get_post_thumbnail_src( $pid, $size = 'thumbnail' ) {
        $ret = '';
        if ( $pthumbid = get_post_thumbnail_id( $pid ) ) :
            $att = wp_get_attachment_image_src( $pthumbid, $size );
            if ( is_array( $att ) ) $ret = array_shift( $att );
        endif;
        if ( ($size == 'carosseis' or $size==array(212,212) ) and !$ret ){
          return get_bloginfo('template_url').'/images/indisponivel.jpg';
        }
        return $ret;
    }

endif;

// Altera o cálculo padrão de excerpt (resumo)
if ( !function_exists( 'my_trim_excerpt' ) ) :

    function my_trim_excerpt( $text, $force_length = 0 ) {
	    $raw_excerpt = $text;

	    $text = strip_shortcodes( $text );

	    $text = apply_filters( 'the_content', $text );
	    $text = str_replace( ']]>', ']]&gt;', $text );
	    $text = strip_tags( $text );
	    $excerpt_length = $force_length ? $force_length : apply_filters( 'excerpt_length', 55 );
	    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
	    $words = preg_split( "/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
	    if ( count( $words ) > $excerpt_length ) {
		    array_pop( $words );
		    $text = implode( ' ', $words );
		    $text = $text . $excerpt_more;
	    } else {
		    $text = implode( ' ', $words );
	    }

	    return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
    }

endif;


// Redireciona a navegação se o post tiver um custom_field de nome 'URL' preenchido
if ( !function_exists( 'url_redirect' ) ) :

    function get_url_redirect( $pid ) {
        $ret = '';
        foreach ( apply_filters( 'auto_url_redirect_fields', array( 'URL' ) ) as $field ) {
            $urldestino = get_post_custom_values( $field, $pid );
            if ( $urldestino && $urldestino[0] ) {
                $ret = $urldestino[0];
                break;
            }
        }
        return $ret;
    }
    function url_redirect() {
        if ( is_singular() ) {
            global $post;
            if ( $urldestino = get_url_redirect( $post->ID ) ) {
                header( 'Location: ' . $urldestino );
                exit();
            }
        }
    }
    function url_redirect_permalink( $link, $p ) {
        if ( $urldestino = get_url_redirect( $p->ID ) ) $link = $urldestino;
        return $link;
    }

    add_action( 'get_header', 'url_redirect' );
    add_filter( 'post_type_link', 'url_redirect_permalink', 10, 2 );

endif;


// Limpa a tag img removendo atributos width e height
if ( !function_exists( 'get_clean_image_tag' ) ) :
    function get_clean_image_tag( $idfoto, $strsize, $icon = false, $attr = null ) {
        return preg_replace( '/\s*height\s*=\s*"[0-9]+"/ims', '',
                                preg_replace( '/\s*width\s*=\s*"[0-9]+"/ims', '',
                                                wp_get_attachment_image( $idfoto, $strsize, $icon, $attr )
                                            )
                            );
    }
endif;

// Limpa a tag img removendo atributos width e height
if ( !function_exists( 'get_clean_thumb_tag' ) ) :
    function get_clean_thumb_tag( $strsize, $icon = false, $attr = null, $idpost = false ) {
        $idfoto = get_post_thumbnail_id( $idpost );
        return get_clean_image_tag( $idfoto, $strsize, $icon, $attr );
    }
endif;


// WordPress says any custom taxonomies archive "is search" ( the method "is_search" returns "true" ). Let us fix this weirdness.
if ( !function_exists( '_wp_fix_query_bug' ) ) :
    function _wp_fix_query_bug( $query ) {
        $qv = $query->query_vars;
        if ( array_key_exists( 's', $qv ) && ( !trim( $qv['s'] ) ) ) {
            unset( $qv['s'] );
            $query->is_search = false;
        }
        $query->query_vars = $qv;
        return $query;
    }
    add_action( 'parse_query', '_wp_fix_query_bug' );
endif;

