<?php
/*
	grunt.concat_in_order.declare('Wpwqbxs_defaults');
	grunt.concat_in_order.require('init');
*/


class Wpwqbxs_defaults {


	protected $defaults = array();

	public function add_default( $arr ){
		$defaults = $this->defaults;
		$this->defaults = array_merge( $defaults , $arr);
	}
	
	public function get_default( $key ){
		if ( array_key_exists($key, $this->defaults) ){
			return $this->defaults[$key];

		}
			return null;
	}


}



function wpwqbxs_init_defaults(){
	global $wpwqbxs_defaults;
	
	$wpwqbxs_defaults = new Wpwqbxs_defaults();
	
}
add_action( 'admin_init', 'wpwqbxs_init_defaults', 1 );
add_action( 'init', 'wpwqbxs_init_defaults', 1 );



?>