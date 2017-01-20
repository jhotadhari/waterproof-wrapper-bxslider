<?php
/*
	grunt.concat_in_order.declare('wpwq_wrapper_bxslider_options');
	grunt.concat_in_order.require('init');
*/

// Add related defaults to the global $tarp_defaults object
function wpwqbxs_add_defaults(){
	global $wpwqbxs_defaults;
	
	$wpwqbxs_defaults->add_default( array(
		'bx_options' => '
{
	"mode": "horizontal",
	"speed": "500",
	"auto": "true",
	"pause": "5000",
	"autoHover": "true",
	"adaptiveHeight": "true",
	"adaptiveHeightSpeed": "500",
	"randomStart": "true",
	"infiniteLoop": "true",
	"easing": "ease-in-out",
	"nextText": "",
	"prevText": ""
}
		',
	));
}
add_action( 'admin_init', 'wpwqbxs_add_defaults', 2 );
add_action( 'init', 'wpwqbxs_add_defaults', 2 );

function wpwqbxs_options_cb( $cmb ) {
	global $wpwqbxs_defaults;
	global $wpwq_wrapper_types;
	
	
	// define name
	$type_name = 'bxslider';
	// get type_desc 
	$type_desc = $wpwq_wrapper_types->get_types( null, $type_name)[$type_name];
	
	$classes = 'wpwq-wrapper wrapper-bxslider';

	$cmb->add_field( array(
		'name' => __('Bxslider Wrapper', 'wpwq-bxslider'),
		'id' => $type_name . '_' . 'title',
		'desc' => '<span class="font-initial">' . __( $type_desc['desc'] , 'wpwq-bxslider') . '</span>',
		'type'    => 'title',
		'classes' => $classes,
	) );

	$cmb->add_field( array(
		'name' => '[default] ' . __('Bx Options', 'wpwq-bxslider'),
		'desc' => __('A JSON formatted array that directly addresses the <a title="bxslider options" target="_blank" href="http://bxslider.com/options">bxslider options</a>.<br>
			Just leave it blank to get the default values ... and save them!','wpwq-bxslider'),
		'id' => $type_name . '_' . 'bx_options',
		'default' => $wpwqbxs_defaults->get_default( 'bx_options' ),
		'type' => 'textarea',
		'classes' => $classes,
	) );

	$cmb->add_field( array(
		'name'    => 'Enqueue Frontend styles and scripts',
		'desc'    => __('Uncheck these if you want to load them your own way.','wpwq-bxslider') . '<br>'
			. '<span class="font-initial">' . __('If your Theme or Childtheme has a folder "wpwq" with file "wpwqbxs_style.css" it will be enqued at last.','wpwq-bxslider') . '</span>'
		,
		'id'      => $type_name . '_' . 'enqueue_jscss',
		'type'    => 'multicheck',
		'default' => array(
			'jquery_bxslider_js',
			'jquery_bxslider_css',
			'wpwqbxs_style'
		),
		'options' => array(
			'jquery_bxslider_js' => 'Plugin script jquery.bxslider',
			'jquery_bxslider_css' => 'Plugin style jquery.bxslider',
			'wpwqbxs_style' => 'Plugin style wpwqbxs_style'
		),
		'classes' => $classes,
	) );	
	
	
}
add_action('wpwq_options', 'wpwqbxs_options_cb', 10, 1 );
?>