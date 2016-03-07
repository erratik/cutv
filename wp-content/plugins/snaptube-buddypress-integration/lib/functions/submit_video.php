<?php 
function add_activity($title,$link) {
	bp_activity_add(array(
		'action' => '<a href="'.bp_loggedin_user_domain().'">'.bp_core_get_user_displayname(get_current_user_id()).'</a>' . ' added a new video',
		'content' => '<a href="'.get_video_permalink($link).'">'.$title.'</a>',
		'component' => 'videos',
		'type' => 'submited_a_video',
		'user_id' => get_current_user_id()
		));
}

function get_submit_video_settings() {
	global $wpdb;

	$results = 	$wpdb->get_results('SELECT player_colors FROM '.$wpdb->prefix.'hdflvvideoshare_settings');
	$player_colors = unserialize($results['0']->player_colors);
	$user_allowed_method = explode(',', $player_colors['user_allowed_method']);

	return $user_allowed_method;
}

function vh_check_video_URL() {
	$video_url = sanitize_text_field($_POST['video_url']);
	global $wpdb;

	$query = "SELECT vid FROM " . $wpdb->prefix . "hdflvvideoshare WHERE file='" . $video_url . "' AND member_id='" . get_current_user_id() . "'";
	$video_check = $wpdb->get_var($query);

	echo $video_check;
	die(1);
}
add_action( 'wp_ajax_nopriv_vh_snaptube_video_check', 'vh_check_video_URL' );
add_action( 'wp_ajax_vh_snaptube_video_check', 'vh_check_video_URL' );