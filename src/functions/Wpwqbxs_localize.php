<?php
/*
	grunt.concat_in_order.declare('Wpwqbxs_localize');
	grunt.concat_in_order.require('init');
*/

class Wpwqbxs_localize {

	protected $datas = array();

	public function add_datas( $arr ){
		$datas = $this->datas;
		$this->datas = array_merge( $datas , $arr);
	}
	
	public function get_datas( $key = null ){
		
		if ( $key === null ){
			return $this->datas;
		} elseif ( array_key_exists( $key, $this->datas) ) {
			return $this->datas[$key];

		} else {
			return false;
		}
	
	}
}

function wpwqbxs_init_localize(){
	global $wpwqbxs_localize;
	$wpwqbxs_localize = new Wpwqbxs_localize();
}
add_action( 'admin_init', 'wpwqbxs_init_localize' , 3);
add_action( 'init', 'wpwqbxs_init_localize' , 3);


?>