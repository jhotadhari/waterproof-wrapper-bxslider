<?php
/*
Plugin Name: Waterproof Wrapper BxSlider
Plugin URI: http://waterproof-webdesign.info/plugins/waterproof-wrapper-bxslider
Description: Wrapper to extend the 'Waterproof Wrap Query' Plugin. Based on bxslider (http://bxslider.com/).
Version: 0.0.2
Author: jhotadhari
Author URI: http://waterproof-webdesign.info/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpwq-bxslider
Domain Path: /languages
Tags: shortcode,wrapper,lists,listing,slider,jQuery,bxslider
*/

/*
	grunt.concat_in_order.declare('_plugin_info');
*/

?>
<?php
/*
	grunt.concat_in_order.declare('init');
	grunt.concat_in_order.require('_plugin_info');
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function wpwqbxs_get_required_php_ver() {
	return '5.6';
}

function wpwqbxs_plugin_activate(){
    if ( ! is_plugin_active( 'waterproof-wrap-query/waterproof-wrap-query.php' )
    	|| version_compare( PHP_VERSION, wpwqbxs_get_required_php_ver(), '<')
    ) {
        wp_die( wpwqbxs_get_admin_notice() . '<br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}
register_activation_hook( __FILE__, 'wpwqbxs_plugin_activate' );

function wpwqbxs_load_functions(){
	if (
		class_exists( 'Wpwq_wrapper' )
		&& ! version_compare( PHP_VERSION, wpwqbxs_get_required_php_ver(), '<')
	){
		include_once(plugin_dir_path( __FILE__ ) . 'functions.php');
	} else {
		add_action( 'admin_notices', 'wpwqbxs_print_admin_notice' );
	}
}
add_action( 'plugins_loaded', 'wpwqbxs_load_functions' );

function wpwqbxs_print_admin_notice() {
	echo '<strong><span style="color:#f00;">' . wpwqbxs_get_admin_notice() . '</span></strong>';
};

function wpwqbxs_get_admin_notice() {
	$plugin_title = 'Waterproof Wrapper BxSlider';
	$parent_plugin_title = 'Waterproof Wrap Query';
	return sprintf(esc_html__( '"%s" plugin requires "%s" plugin to be installed and activated and PHP version greater %s!', 'wpwq' ), $plugin_title, $parent_plugin_title, wpwqbxs_get_required_php_ver());
}
?>