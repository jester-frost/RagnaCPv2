<?php

class ragna_theme_post_types {
    function init() {

        # Notícias
	    $args = array(
		    'labels' => array(
		        'name' => __( 'Notícias' ),
		        'singular_name' => __( 'Notícia' ),
	        ),
            'description' => __( 'Ultimas Notícias.' ),
		    'supports' => array( 'title', 'thumbnail', 'excerpt', 'editor' ),
		    'has_archive' => true,
		    'show_ui' => true,
			'public' => true,
	    );
        register_post_type( 'noticia', $args );
		
		// Criando os menus
		add_action( 'admin_menu', array( __CLASS__, 'ragna_theme_create_option' ) );

		// Registrando as options
		add_action( 'admin_init', array( __CLASS__, 'ragna_theme_register_option'  ) );

		add_action( 'pre_get_posts', array( __CLASS__, 'change_number_posts' ), 1 );

		add_filter( 'the_title', array( __CLASS__, 'agenda_get_title' ), 10, 2 );
		add_action( 'wp_insert_post_data', array( __CLASS__, 'agenda_change_title' ), 10, 1 );
		if ( is_admin() ) add_action( 'pre_get_posts', array( __CLASS__, 'agenda_change_default_order' ), 9 );
    }

	// Estrutura dos submenus
	function custom_submenus( $all = false ) {
		$menus = array(
			'organograma' => array(
				'page_title'  => 'Configurações do Organograma',
				'menu_title'  => 'Config. Organogramas',
				'capability'  => 'activate_plugins',
				'fields'      => array(
					'org_titulo' => array(
						'label' => 'Título da página',
						'type'  => 'text',
					),
					'org_introducao' => array(
						'label' => 'Introdução da página',
						'type'  => 'textarea',
					),
				),
			),
			'aplicativo' => array(
				'page_title' => 'Configurações da Lista de Apps',
				'menu_title'  => 'Config. Apps',
				'capability' => 'activate_plugins',
				'fields'     => array(
					'app_titulo' => array(
						'label' => 'Título da página',
						'type'  => 'text',
					),
				),
			),
		);
		if ( ! $all ) :
			if ( is_array( $_GET ) && array_key_exists( 'post_type', $_GET ) && $_GET[ 'post_type' ] ) :
				$post_type = $_GET[ 'post_type' ];
				$aux = array();
				foreach ( $menus as $slug => $atts ) :
					if ( $slug == $post_type ) :
						$aux[ $slug ] = $atts;
					endif;
				endforeach;
				$menus = $aux;
			endif;
		endif;
		return $menus;
	}
	
	// cria os submenus
	function ragna_theme_create_option() {
		$menus = call_user_func_array ( array( __CLASS__, 'custom_submenus' ), array( true ) );
		foreach ( $menus as $slug => $atts ) :
			$parent_slug = 'edit.php?post_type=' . $slug;
			$menu_slug = 'config-' . $slug;
			add_submenu_page( $parent_slug, $atts[ 'page_title' ], $atts[ 'menu_title' ], $atts[ 'capability' ], $menu_slug, array( __CLASS__, 'ragna_theme_generic_create_menu' ) );
		endforeach;
	}

	// registra as options
	function ragna_theme_register_option() {
		$menus = call_user_func( array( __CLASS__, 'custom_submenus' ) );
		foreach ( $menus as $slug => $atts ) :
			if ( array_key_exists( 'fields', $atts ) && is_array( $atts[ 'fields' ] ) ) :
				foreach ( $atts[ 'fields' ] as $slug => $atts ) :
					register_setting( '_ragna_theme_options', '_ragna_theme_' . $slug );
				endforeach;
			endif;
		endforeach;
	}

	// cria a tela para o submenu
	function ragna_theme_generic_create_menu() {
		$menu = call_user_func( array( __CLASS__, 'custom_submenus' ) );
		$menu = is_array( $menu ) ? array_shift( $menu ) : $menu;
		$post_type = $_GET[ 'post_type' ];
		?>
		<div class="wrap">
			<h1><?php echo $menu[ 'page_title' ]; ?></h1>
			<form action="options.php" method="post" class="validate">
				<?php
				settings_fields( '_ragna_theme_options' );
				do_settings_sections( '_ragna_theme_options' ); 
				?>
				<table class="form-table">
					<tbody>
						<?php
						if ( is_array( $menu[ 'fields' ] ) && $menu[ 'fields' ] ) :
							foreach( $menu[ 'fields' ] as $slug => $atts ) :
							?>
								<tr>
									<th scope="row">
										<label for="<?php echo $slug ?>"><?php echo $atts[ 'label' ] ?></label>
									</th>
									<td>
										<?php if ( 'textarea' == $atts[ 'type' ] ) : ?>
											<textarea id="<?php echo $slug; ?>" class="large-text" name="_ragna_theme_<?php echo $slug; ?>" rows="5"><?php echo esc_attr( get_option( '_ragna_theme_' . $slug ) ); ?></textarea>
										<?php else : ?>
											<input id="<?php echo $slug; ?>" class="large-text" name="_ragna_theme_<?php echo $slug; ?>" type="<?php echo $atts[ 'type' ]; ?>" value="<?php echo esc_attr( get_option( '_ragna_theme_' . $slug ) ); ?>">
										<?php endif; ?>
									</td>
								</tr>
							<?php
							endforeach;
						endif;
						?>
					</tbody>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php 
	}

	function agenda_monta_title( $dia, $mes, $ano ) {
		$title = 'Agenda';
		if ( $dia || $mes || $ano ) :
			$meses = array(
						1 => 'Janeiro',
						2 => 'Fevereiro',
						3 => 'Março',
						4 => 'Abril',
						5 => 'Maio',
						6 => 'Junho',
						7 => 'Julho',
						8 => 'Agosto',
						9 => 'Setembro',
						10 => 'Outubro',
						11 => 'Novembro',
						12 => 'Dezembro',
					);
			$title .= ' para';
			if ( $dia ) $title .= ' o dia ' . $dia;
			if ( $mes ) $title .= ( $dia ? ' de ' : ' ' ) . $meses[ $mes ];
			if ( $ano ) $title .= ( $dia || $mes ? ' de ' : ' ' ) . $ano;
		endif;
		return $title;
	}
	function agenda_get_title( $title, $pid ) {
		$pt = get_post_type( $pid );
		if ( 'agenda' == $pt ) {
			$dia = get_post_meta( $pid, '_ragna_theme_agenda_dia', true );
			$mes = get_post_meta( $pid, '_ragna_theme_agenda_mes', true );
			$ano = get_post_meta( $pid, '_ragna_theme_agenda_ano', true );
			$title = call_user_func_array( array( __CLASS__, 'agenda_monta_title' ), array( $dia, $mes, $ano ) );
		}
		return $title;
	}
	function agenda_change_title( $data ) {
		if ( 'agenda' == $data[ 'post_type' ] ) {
			$maior_data = get_option( '_ragna_theme_agenda_maior_data' );
			$menor_data = get_option( '_ragna_theme_agenda_menor_data' );
			$dia = $_POST[ 'agenda_dia' ];
			$mes = $_POST[ 'agenda_mes' ];
			$ano = $_POST[ 'agenda_ano' ];
			$datajunta = $ano . substr( '00' . $mes, -2 ) . substr( '00' . $dia, -2 );
			$data[ 'post_title' ] = $datajunta;
			$data[ 'post_title' ] .= ' - ' . call_user_func_array( array( __CLASS__, 'agenda_monta_title' ), array( $dia, $mes, $ano ) );
			if ( $ano ) :
				if ( ( $datajunta > $maior_data ) || !$maior_data ) update_option( '_ragna_theme_agenda_maior_data', $datajunta );
				if ( ( $datajunta < $menor_data ) || !$menor_data ) update_option( '_ragna_theme_agenda_menor_data', $datajunta );
			endif;
		}
		return $data;
	}
	function agenda_change_default_order( $query ) {
		if ( ( ! is_admin() ) || ( ! $query->is_main_query() ) || ( 'agenda' != $query->get( 'post_type' ) ) ) return;
		$orderby = $query->get( 'orderby' );
		if ( !$orderby ) $query->set( 'orderby', 'title' );
		return $query;
	}

	// Listagem de aplicativos sem limite de posts, mostrando tudo
	function change_number_posts( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) return;
		if ( is_post_type_archive( 'aplicativo' ) ) {
			$query->set( 'posts_per_page', -1 );
			return $query;
		}
	}
}
add_action( 'init', array( 'ragna_theme_post_types', 'init' ) );

?>