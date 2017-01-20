<?php
/*
	grunt.concat_in_order.declare('wpwqbxs_wrapper_bxslider_defaults');
	grunt.concat_in_order.require('init');
	grunt.concat_in_order.require('Wpwqbxs_defaults');
*/


/**
* Add related defaults to the global $wpwqbxs_defaults object
*/
function wpwqbxs_add_defaults_wrapper_bxslider(){
	global $wpwqbxs_defaults;
		
	// define name
	$type_name = 'bxslider';
		
	$wpwqbxs_defaults->add_default( array(
		'wrapper_' . $type_name . '_' . 'default_image' => ''
	));
}
add_action( 'admin_init', 'wpwqbxs_add_defaults_wrapper_bxslider', 2 );
add_action( 'init', 'wpwqbxs_add_defaults_wrapper_bxslider', 2 );



?>