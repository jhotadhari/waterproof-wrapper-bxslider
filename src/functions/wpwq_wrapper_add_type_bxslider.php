<?php
/*
	grunt.concat_in_order.declare('wpwq_wrapper_add_type_bxslider');
	grunt.concat_in_order.require('init');
*/

/**
* Add type name to the $wpwq_wrapper_types object
*/
function wpwq_wrapper_add_type_bxslider(){
	global $wpwq_wrapper_types;
	$wpwq_wrapper_types->add_type( array(
		'bxslider' => array(
			'desc' => __('Wrapps the results in a responsive jQuery content slider.<br>
				Its based on <a title="bxslider" target="_blank" href="http://bxslider.com/">bxslider</a> and its possible to use all of the <a title="bxslider options" target="_blank" href="http://bxslider.com/options">bxslider options</a> with the "bx_options" argument inside the "wrapper_args" shortcode attribute.','wpwq-bxslider'),
			'args' => array(
				'has_link' => array(
					'accepts' => 'bool', 
					'default' => 'false', 
					'desc' => __('Object should be linked?','wpwq-bxslider')
					),
				'bx_options' => array(
					'accepts' => 'JSON', 
					'default' => '', 
					'desc' => __('This argument directly addresses the <a title="bxslider options" target="_blank" href="http://bxslider.com/options">bxslider options</a>.<br>
						The global defaults are set in <a title="Settings -> Waterproof Wrap Query options" target="_blank" href="' . get_admin_url() . 'options-general.php?page=wpwq_options">Settings -> Waterproof Wrap Query options</a>','wpwq-bxslider')
					),
				)
			)
		)
	);
}
add_action( 'admin_init', 'wpwq_wrapper_add_type_bxslider' );
add_action( 'init', 'wpwq_wrapper_add_type_bxslider' );

?>