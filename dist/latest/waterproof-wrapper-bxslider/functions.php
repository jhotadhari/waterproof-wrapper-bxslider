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
<?php
/*
	grunt.concat_in_order.declare('Wpwq_wrapper_bxslider_single');
	grunt.concat_in_order.require('init');
*/

class Wpwq_wrapper_bxslider_single extends Wpwq_wrapper_single {
	
	function __construct( $name = null, $query_single_obj = null , $args = null, $args_single = null, $single_count = null ) {
		parent::__construct( $name, $query_single_obj , $args, $args_single, $single_count);
		$this->set_inner( $query_single_obj );
	}
		
	protected function set_inner( $query_single_obj ) {

		$is_linked = ( array_key_exists('has_link', $this->args ) 
			&& $this->args['has_link'] == 'true' 
			&& strlen($query_single_obj['str_link']) > 0 
			&& strlen($query_single_obj['link']) > 0 
			? true 
			: false );
		
		$return = '';
		
		$return .= '<li>';
			$return .= '<div class="bxslider-inner">';
			
			$return .= '<div class="silder-header postheader">';
				if ($is_linked) $return .= '<a href="' . $query_single_obj['link'] . '">';

					$return .= '<h3>' . $query_single_obj['str_title'] . '</h3>';
				if ($is_linked) $return .= '</a>';

			$return .= '</div>';
				
			if ( strlen($query_single_obj['image_url']) > 0 ) {
				if ($is_linked)
					$return .= '<a href="' . $query_single_obj['link'] . '">';

				$return .= $query_single_obj['image'];
				if ($is_linked)
					$return .= '</a>';

			}
				
			$return .= '<div class="inner">';
				$return .= $query_single_obj['str_inner'];
			$return .= '</div">';
				
				$return .= '<div  class="bxslider-post-link">';
					$return .= '<span>';
						if ($is_linked) $return .= '<a title="' . $query_single_obj['str_title'] . '" href="' . $query_single_obj['link'] . '">' . $query_single_obj['str_link'] . '</a>';
					$return .= '</span>';

				$return .= '</div>';	

				
			$return .= '</div>';

		$return .= '</li>';
		
		
		$this->inner = $return;
	}
	
}

?>
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
			if ( file_exists( get_template_directory() . '/wpwq/wpwqbxs_style.css' ) ){
				wp_enqueue_style( 'wpwqbxs_style_theme', get_template_directory_uri() . '/wpwq/wpwqbxs_style.css' );

			}
			if ( file_exists( get_stylesheet_directory() . '/wpwq/wpwqbxs_style.css' ) ){
				wp_enqueue_style( 'wpwqbxs_style_childtheme', get_stylesheet_directory_uri() . '/wpwq/wpwqbxs_style.css' );
			}
		} else {
			// childtheme doesn't exists
			if ( file_exists( get_template_directory() . '/wpwq/wpwqbxs_style.css' ) ){
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
		
		$i = 1;
		foreach ( $this->query_prepared as $query_single_obj ){
			$wpwq_wrapper_bxslider_single = new Wpwq_wrapper_bxslider_single( $this->get_name(), $query_single_obj, $this->args, $this->get_args_single(), $i );
			$return .= $wpwq_wrapper_bxslider_single->get_inner();
			$i++;
		}
		
		$this->wrapper_inner = $return;
	}
}
	





?>