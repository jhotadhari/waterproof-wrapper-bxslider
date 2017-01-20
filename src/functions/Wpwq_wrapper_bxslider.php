<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_bxslider');
	grunt.concat_in_order.require('init');

	grunt.concat_in_order.declare('Wpwq_wrapper_bxslider_single');
	grunt.concat_in_order.require('wpwq_wrapper_add_type_bxslider');
	grunt.concat_in_order.require('wpwqbxs_wrapper_bxslider_defaults');
	grunt.concat_in_order.require('wpwq_wrapper_bxslider_options');
	grunt.concat_in_order.require('Wpwqbxs_localize');
*/

/*
	requires
		???
		jquery.bxslider.js

		jquery.bxslider.less

		
		wpwq_wrapper_bxslider.js
		wpwq_wrapper_bxslider.less
		
*/

class Wpwq_wrapper_bxslider extends Wpwq_wrapper {
	
	function __construct( $query_obj = null, $objs = null, $args = null ) {
		parent::__construct( $query_obj, $objs, $args );

		$this->set_name( 'bxslider' );
		
		$this->parse_data();
		
		add_action( 'wp_footer', array( $this, 'styles_scripts_frontend' ), 1 );
		add_action( 'wp_footer', array( $this, 'scripts_frontend_print' ) );

		$this->set_wrapper_open();
		$this->set_wrapper_close();
		$this->set_wrapper_inner();
	}

	protected function set_wrapper_open() {
		
		$unique = ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) > 0 ? ' ' . wpwq_slugify($this->args['unique']) . '-unique' : '' );
		
		$this->wrapper_open = '<div class="wpwq-query-wrapper clearfix bxslider' . $unique . '"><ul class="bxslider">';
	}
	protected function set_wrapper_close() {
		$this->wrapper_close = '</ul></div>';
	}
	
	protected function parse_data() {
		global $wpwqbxs_localize;
		global $wpwqbxs_defaults;

		$bx_options = wpwq_get_option( $this->type_name . '_' . 'bx_options', $wpwqbxs_defaults->get_default( 'bx_options' ));
		$jsonStr = strip_tags(str_replace( ' ', '', $bx_options));
		$bx_options = ( null !== json_decode( $jsonStr, true ) ? json_decode( $jsonStr, true ) : array() );
		
		$options = array(
			'global' => array(
				'bx_options' => $bx_options
			)
		);
		
		if ( array_key_exists('unique', $this->args ) && strlen($this->args['unique']) ) {
			$unique = wpwq_slugify($this->args['unique']);
			
			$options[$unique] = ( array_key_exists('bx_options', $this->args) ? $this->args['bx_options'] : array() );
		}


		
		$wpwqbxs_localize->add_datas( $options );
	}
	
	public function styles_scripts_frontend() {
		
		$enqueue_jscss = wpwq_get_option( $this->type_name . '_' . 'enqueue_jscss', array(
			'jquery_bxslider_js',
			'jquery_bxslider_css',
			'wpwqbxs_style'
		));
		
		if ( in_array( 'jquery_bxslider_css', $enqueue_jscss )){	
			wp_enqueue_style( 'jquery.bxslider', plugin_dir_url( __FILE__ ) . 'css/jquery.bxslider.css' );
		}
		if ( in_array( 'wpwqbxs_style', $enqueue_jscss )){	
			wp_enqueue_style( 'wpwqbxs_style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
		}
		
		if ( get_template_directory_uri() != get_stylesheet_directory_uri() ){
			// childtheme exists
			if ( file_exists( get_template_directory_uri() . '/wpwq/wpwqbxs_style.css' ) ){
				wp_enqueue_style( 'wpwqbxs_style_theme', get_template_directory_uri() . '/wpwq/wpwqbxs_style.css' );
			}
			if ( file_exists( get_stylesheet_directory() . '/wpwq/wpwqbxs_style.css' ) ){
				wp_enqueue_style( 'wpwqbxs_style_childtheme', get_stylesheet_directory_uri() . '/wpwq/wpwqbxs_style.css' );
			}
		} else {
			// childtheme doesn't exists
			if ( file_exists( get_template_directory_uri() . '/wpwq/wpwqbxs_style.css' ) ){
				wp_enqueue_style( 'wpwqbxs_style_theme', get_template_directory_uri() . '/wpwq/wpwqbxs_style.css' );
			}
		}
	
		if ( in_array( 'jquery_bxslider_js', $enqueue_jscss )){	
			wp_enqueue_script( 'jquery.bxslider', plugin_dir_url( __FILE__ ) . 'js/jquery.bxslider.min.js', array('jquery') , false , true);
		}
		
		wp_register_script( 'wpwqbxs_script', plugin_dir_url( __FILE__ ) . 'js/script.min.js', array('jquery','jquery.bxslider') , false , true);
	}	
	public function scripts_frontend_print() {
		global $wpwqbxs_localize;
		
		$parse_data = $wpwqbxs_localize->get_datas();
		wp_localize_script( 'wpwqbxs_script', 'Wpwq_wrapper_' . $this->type_name, $parse_data );
		wp_print_scripts('wpwqbxs_script');
	}	
	
	
	protected function set_wrapper_inner() {
		$return = '';
		
		foreach ( $this->query_prepared as $query_single_obj ){
			$wpwq_wrapper_bxslider_single = new Wpwq_wrapper_bxslider_single( $this->get_name(), $query_single_obj, $this->args, $this->get_args_single() );
			$return .= $wpwq_wrapper_bxslider_single->get_inner();
		}
		
		$this->wrapper_inner = $return;
	}
}
	





?>