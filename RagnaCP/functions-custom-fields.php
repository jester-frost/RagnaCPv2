<?php

class ragna_theme_custom_fields {
    function fields( $post_type ) {
    	
        $fields = array(
            # 'custom_field' => array_propriedades
            'projeto_subtitle' => array(
                'type' => 'text',
                'label' => 'Descrição',
                'post_type' => array( 'noticia' ),
            ),
            
        );

        $ret = array();
        foreach ( $fields as $field => $fprops ) :
            if ( is_array( $fprops[ 'post_type' ] ) && in_array( $post_type, $fprops[ 'post_type' ] ) ) :
                $ret[ $field  ] = $fprops;
            endif;
        endforeach;
        return $ret;
    }

    function init() {
        add_action( 'do_meta_boxes', array( __CLASS__, 'add_meta_box' ), 10, 2 );
        add_action( 'save_post', array( __CLASS__, 'save' ) );
        add_action( 'edit_attachment', array( __CLASS__, 'save' ), 1 );
    }

    function add_meta_box( $page ) {
        global $post;
        $cf = call_user_func_array( array( __CLASS__, 'fields' ), array( $post->post_type ) );
        if ( count( $cf ) ) {
            add_meta_box( 'ragna_theme_customfields', __( 'Campos Personalizados' ), array( __CLASS__, 'do_meta_box' ), $page, 'normal', 'default' );
        }
    }

    function do_meta_box() {
        global $post;
        echo '<input type="hidden" name="ragna_theme_cf_noncename" id="ragna_theme_cf_noncename" value="' . wp_create_nonce( plugin_basename(__DIR__) ) . '" />';
        $cf = call_user_func_array( array( __CLASS__, 'fields' ), array( $post->post_type ) ); ?>
        <div class="wrap form-table">
            <?php
            foreach ( $cf as $fid => $fprops ) :
                $valuefield = esc_attr( get_post_meta( $post->ID, '_ragna_theme_' . $fid, true ) );

                ?>
                <div>
                    <?php if ( 'groupname' == $fprops['type'] ) : ?>
                        <h3><?php echo $fprops['label']; ?></h3>
                    <?php elseif ( 'upload' == $fprops[ 'type' ] ) : ?>
                        <label for="ceara_custom_field_<?php echo $fid; ?>"><span><?php echo $fprops['label']; ?></span></label>
                        <?php
                        $imagens = array();
                        foreach ( explode( ',', $valuefield ) as $img ):
                            $atts_img = wp_get_attachment_image_src( $img, 'medium' );
                            if ( $atts_img && is_array( $atts_img ) ) :
                                $imagens[] = array(
                                    'id' => $img,
                                    'url' => $atts_img[0],
                                );
                            endif;
                        endforeach;
                        ?>
                        <div class="ragna_theme_media_uploader">
                            <div class="ragna_theme_media_thumbs">
                                <?php if ( $imagens ) : ?>
                                    <?php foreach ( $imagens as $imagem ) : ?>
                                        <figure data-imgid="<?php echo esc_attr( $imagem[ 'id' ] ); ?>">
                                            <img src="<?php echo esc_attr( $imagem[ 'url' ] ); ?>">
                                            <a href="#" title="Remover imagem">&ndash;</a>
                                        </figure>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </div>
                            <input type="hidden" value="<?php echo $valuefield; ?>" name="<?php echo $fid; ?>" id="<?php echo $fid; ?>" />
                            <input class="ragna_theme_media_button button" name="<?php echo $fid; ?>" id="ceara_custom_field_<?php echo $fid; ?>" type="button" value="Selecionar mídia" />
                        </div>
                    <?php else : ?>
                        <label>
                            <span><?php echo $fprops['label']; ?>:</span>
                            <?php if ( 'textarea' == $fprops['type'] ) : ?>
                                <textarea id="<?php echo $fid; ?>" name="<?php echo $fid; ?>" class="regular-text"><?php echo $valuefield ; ?></textarea>
                            <?php elseif ( 'select' == $fprops['type'] ) : ?>

                                <select name="<?php echo $fid; ?>" id="<?php echo $fid; ?>">
                                    <option value=""></option>
                                    <?php if( isset( $fprops['options'] ) ) : ?>
                                        <?php foreach ($fprops['options'] as $key => $value): ?>
                                            <?php $selected = ( $key == $valuefield) ? 'selected' :  '' ;?>
                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                                        <?php endforeach ?>
                                    <?php endif; ?>
                                </select>
                            <?php elseif ( 'upload' == $fprops[ 'type' ] ) : ?>
                                <?php
                                $imagens = array();
                                foreach ( explode( ',', $valuefield ) as $img ):
                                    $atts_img = wp_get_attachment_image_src( $img, 'medium' );
                                    if ( $atts_img && is_array( $atts_img ) ) :
                                        $imagens[] = array(
                                            'url' => $atts_img[0],
                                        );
                                    endif;
                                endforeach;
                                ?>
                                <div class="ragna_theme_media_uploader">
                                    <div class="ragna_theme_media_thumbs">
                                        <?php if ( $imagens ) : ?>
                                            <?php foreach ( $imagens as $imagem ) : ?>
                                                <figure>
                                                    <img src="<?php echo $imagem[ 'url' ]; ?>"/>
                                                </figure>
                                            <?php endforeach; ?>
                                        <?php endif ?>
                                    </div>
                                    <input type="hidden" value="<?php echo $valuefield; ?>" name="<?php echo $fid; ?>" id="<?php echo $fid; ?>" />
                                    <input class="ragna_theme_media_button button" name="<?php echo $fid; ?>" type="button" value="Selecionar mídia" />
                                </div>
                            <?php else : ?>
                                <input id="<?php echo $fid; ?>" name="<?php echo $fid; ?>" type="<?php echo $fprops['type']; ?>" class="regular-text" value="<?php echo $valuefield; ?>" />
                            <?php endif; ?>
                        </label>
                    <?php endif; ?>
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <?php
    }

    function save( $pid ) {
        if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST[ 'bulk_edit' ] ) ) return $pid;
        if ( ( !array_key_exists( 'ragna_theme_cf_noncename', $_POST ) ) || ( !wp_verify_nonce( $_POST['ragna_theme_cf_noncename'], plugin_basename(__DIR__) ) ) ) {
            return $pid;
        }
        if ( !current_user_can( 'edit_post', $pid ) ) return $pid;
        $cf = call_user_func_array( array( __CLASS__, 'fields' ), array( $_POST['post_type'] ) );
        foreach ( $cf as $slug => $atts ) {
            
            if(! $_POST[$slug] ){
                delete_post_meta( $pid, '_ragna_theme_' . $slug );
            } else {
                update_post_meta( $pid, '_ragna_theme_' . $slug, $_POST[$slug] );
            }
        }
        return $pid;
    }

}
add_action( 'init', array( 'ragna_theme_custom_fields', 'init' ) );

