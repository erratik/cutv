<?php
/*
*	Load Scripts and Styles
*/

// Public JS scripts
if (!function_exists('bp_i_scripts_method')) {
	function bp_i_scripts_method() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('bp_i-master', plugins_url( 'js', __FILE__ ) . '/master.js', array('jquery'), '', TRUE);
		
	}
}
add_action('wp_enqueue_scripts', 'bp_i_scripts_method');

// Public CSS files
if (!function_exists('bp_i_style_method')) {
	function bp_i_style_method() {
		//wp_enqueue_style('bp_i-master-css', plugins_url( 'css', __FILE__ ) . '/master.css');

	}
}
add_action('wp_enqueue_scripts', 'bp_i_style_method');
add_action('wp_head', 'bp_i_style_method');
?>