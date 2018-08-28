<?php

class ragna_theme_custom_shortcodes {

    function init () {
        //Shortcode teste
        add_shortcode( 'sample', array( __CLASS__, 'sample' ) );

        //Shortcode Notícias
        add_shortcode( 'ultimas_noticias', array( __CLASS__, 'ultimas_noticias' ) );
    }

    function sample( $atts, $content = '' ) {
        return $content . '<p>BAZINGA</p>';
    }


    // Shortcode de Notícias
    /* [ultimas_noticias
        categoria=" " 
        posts=" " quantidade de posts
        titulo=" "]

        [ultimas_noticias categoria=" "  posts=" " titulo=" "]
    */
    function ultimas_noticias( $atts, $content = '' ) {

        !$atts['titulo'] ? $titulo = "Ultimas notícias" : $titulo = $atts['titulo'];
        !$atts['posts'] ? $qtd = 3 : $qtd = $atts['posts'];
        !$atts['categoria'] ? $cat = "" : $cat = $atts['categoria'];

        $args = array(
            'orderby'          => 'date',
            'posts_per_page'   => $qtd,
            'category_name' => $cat,
        );
        
        $noticia_query = get_posts( $args );

        $noticiaContent = array();

        foreach ( $noticia_query as $noticia ) :
            $data = get_the_date( 'd \d\e F \d\e Y', $noticia->ID  );
            $title = get_the_title( $noticia->ID );
            $url = get_the_permalink( $noticia->ID );
            $thumb = get_the_post_thumbnail( $noticia->ID );
            if ( !$thumb ) :
                $thumb = '<img src="' . get_bloginfo( 'template_directory' ) . '/assets/images/noticia-sem-imagem.jpg" alt="' . $title . '">';
            endif;
            $noticiaContent[] = array(
                'link' => $url,
                'data' => $data,
                'titulo' => $title,
                'foto' => $thumb,
            );
        endforeach;

        if ( $noticiaContent ) :

            if ( is_array( $noticiaContent ) ) :

                $content .='
                                    <div class="grid">';
                                    foreach ($noticiaContent as $noticia) :
                $content .='           <a class="thumbnail item" href="' . $noticia['link'] . '">
                                            <figure>';
                                                if ( $noticia['foto'] ) :
                $content .='                    <div class="-zoom-box">
                                                    ' . $noticia['foto'] . '
                                                </div>';
                                                endif;
                $content .='                    <figcaption>';
                                                    if( $noticia['data'] ) :
                $content .='                        <p>' . $noticia['data'] . '</p>';
                                                    endif;
                                                    if( $noticia['titulo'] ) :
                $content .='                        <h4>
                                                        ' . $noticia['titulo'] . '
                                                    </h4>';
                                                    endif;
                $content .='                    </figcaption>
                                            </figure>
                                        </a>';
                                    endforeach;
                $content .='        </div>';
            endif;

        endif;

        return $content;
    }

}

add_action( 'init', array( 'ragna_theme_custom_shortcodes', 'init' ) ); 

?>