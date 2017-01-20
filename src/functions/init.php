<?php
/*
	grunt.concat_in_order.declare('init');
*/


// load_plugin_textdomain
function wpwqbxs_load_textdomain(){
	
	load_plugin_textdomain(
		'wpwq-bxslider',
		false,
		dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
	);
}
add_action( 'plugins_loaded', 'wpwqbxs_load_textdomain' );


?>