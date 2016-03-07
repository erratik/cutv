<?php

	/* Defining types */
	$vs[ 'types' ] = array();

	/* Define Search Type */
	$type_id                   = 'search' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'search' ,
		'label'            => 'Search' ,
		'icon'             => 'fa-search' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => FALSE ,
		'subdata_function' => FALSE ,
		'multiplicate'     => FALSE ,
		'param'            => 'searchTerm' . $pid_suffix ,
		'fields'           => array(
			//Search Terms Field
			array(
				'id'          => 'searchTerm' . $pid_suffix ,
				'type'        => 'textarea_small' ,
				'name'        => __( 'Search Terms' , WPVR_LANG ) ,
				'desc'        => '' ,
				'wpvrService' => $vs[ 'id' ] ,
				'wpvrType'    => $type_id ,
			) ,
		) ,
	);

	/* Define Trends Type */
	global $wpvr_countries;
	$type_id                   = 'trends' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'trends' ,
		'label'            => 'Trends' ,
		'icon'             => 'fa-trophy' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => TRUE ,
		'subdata_function' => 'get_trends_data' ,
		'multiplicate'     => FALSE ,
		'param'            => 'regionCode' . $pid_suffix ,
		'fields'           => array(
			//Trends Fields
			array(
				'id'          => 'regionCode' . $pid_suffix ,
				'type'        => 'select' ,
				'name'        => __( 'Country' , WPVR_LANG ) ,
				'desc'        => '' ,
				'default'     => '' ,
				'options'     => $wpvr_countries ,
				'wpvrType'    => $type_id ,
				'wpvrService' => $vs[ 'id' ] ,
				'wpvrStyle'   => $vs[ 'id' ] ,
			) ,
		) ,
	);

	/* Define Playlist Type */
	$type_id                   = 'playlist' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'playlist' ,
		'label'            => 'Playlists' ,
		'icon'             => 'fa-play-circle' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => TRUE ,
		'subdata_function' => 'get_playlist_data' ,
		'multiplicate'     => array(
			'parent' => 'playlistIds' . $pid_suffix ,
			'child'  => 'playlistId' . $pid_suffix ,
		) ,
		'param'            => 'playlistId' . $pid_suffix ,
		'fields'           => array(
			array(
				'name'         => __( 'Playlist Id' , WPVR_LANG ) ,
				'desc'         => 'Example: http://www.youtube.com/watch?v=YRWhUo5g0K0&list=<span class="wpvr_wanted_param">PLh2QSchbA3pntIcjZRMsnAb7l_tAUJjeg</span> <br/>' .
				                  __( 'Single Playlist ID' , WPVR_LANG ) ,
				'id'           => 'playlistId' . $pid_suffix ,
				'type'         => 'text' ,
				'wpvrType'     => $type_id ,
				'wpvrService'  => $vs[ 'id' ] ,
				'hidden_field' => TRUE ,
			) ,
			array(
				'name'            => __( 'Playlists Ids' , WPVR_LANG ) .
				                     '<br/><div class="wpvr_count_playlists wpvr_count_items"></div>' ,
				'id'              => 'playlistIds' . $pid_suffix ,
				'type'            => 'textarea' ,
				'desc'            => 'Example: http://www.youtube.com/watch?v=YRWhUo5g0K0&list=<span class="wpvr_wanted_param">PLh2QSchbA3pntIcjZRMsnAb7l_tAUJjeg</span><br/>' .
				                     __( 'List of comma-separated playlist IDs.' , WPVR_LANG ) ,
				'wpvrType'        => $type_id ,
				'wpvrService'     => $vs[ 'id' ] ,
				'wpvrClass'       => 'countMyItems' ,
				'wpvr_attributes' => array(
					'listener' => 'playlistIds' . $pid_suffix ,
				) ,
			) ,
		) ,
	);

	$channel_form
		= '
			<h3>
				' . __( 'Retrieve a channel ID from its owner username :' , WPVR_LANG ) . '
			</h3>
			<input type="text" name="" service="youtube" class="wpvr_channel_input" id="wpvr_channel_username" placeholder="' . __( 'Username' , WPVR_LANG ) . '" />
			<div class="wpvr_clearfix"></div>
			<div class="wpvr_button pull-right" id="wpvr_channel_button_reset">
				<i class="fa fa-close"></i> ' . __( 'RESET' , WPVR_LANG ) . '
			</div>
			<div class="wpvr_button pull-right wpvr_channel_button" id="wpvr_channel_retreive" url="' . WPVR_ACTIONS_URL . '">
				<i class="fa fa-search"></i> ' . __( 'Find Channel ID' , WPVR_LANG ) . '
			</div>
			<div class="wpvr_clearfix"></div>
			<div id="wpvr_channel_error" style="display:none;"></div>
			<div id="wpvr_channel_zone" style="display:none;">
				<input type="text" readonly name="" class="wpvr_channel_input" id="wpvr_channel_id" placeholder="' . __( 'Channel ID' , WPVR_LANG ) . '" />
				<div class="wpvr_button wpvr_channel_add" id="wpvr_channel_add_id" target="wpvr_source_' . 'channelIds' . $pid_suffix . '" >' . __( 'ADD TO LIST' , WPVR_LANG ) . '</div>
			</div>
		';

	//$helper_form = wpvr_render_helper_form( 'channel' , $vs[ 'id' ] , TRUE , 'count_my_channels' );
	$helper_form = $vs[ 'render_helper_form' ](
		'channel' ,
		TRUE , //append ?
		'count_my_channels'
	);

	/* Define Channel Type */
	$type_id                   = 'channel' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'channel' ,
		'label'            => 'Channels' ,
		'icon'             => 'fa-desktop' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => TRUE ,
		'subdata_function' => 'get_channel_data' ,
		'param'            => 'channelId' . $pid_suffix ,
		'multiplicate'     => array(
			'parent' => 'channelIds' . $pid_suffix ,
			'child'  => 'channelId' . $pid_suffix ,
		) ,
		'fields'           => array(
			array(
				'name'         => __( 'Channel Id' , WPVR_LANG ) ,
				'desc'         => 'Example: http://www.youtube.com/watch?v=YRWhUo5g0K0&list=<span class="wpvr_wanted_param">RD02UQlFOX0YKlQ</span> <br/>' .
				                  __( 'Single Channel ID' , WPVR_LANG ) ,
				'id'           => 'channelId' . $pid_suffix ,
				'type'         => 'text' ,
				'wpvrType'     => $type_id ,
				'wpvrService'  => $vs[ 'id' ] ,
				'hidden_field' => TRUE ,
			) ,
			array(
				'name'            => __( 'Channels Ids' , WPVR_LANG ) . '<br/><div id="count_my_channels" class="wpvr_count_channels wpvr_count_items"></div>' ,
				'id'              => 'channelIds' . $pid_suffix ,
				'type'            => 'textarea' ,
				'desc'            => $helper_form ,
				'wpvrType'        => $type_id ,
				'wpvrService'     => $vs[ 'id' ] ,
				'wpvrClass'       => 'countMyItems' ,
				'wpvr_attributes' => array(
					'listener' => 'channelIds' . $pid_suffix ,
				) ,

			) ,
		) ,

	);

	/* Define Videos Type */
	$type_id                   = 'videos' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'videos' ,
		'label'            => 'Videos' ,
		'icon'             => 'fa-film' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => FALSE ,
		'multiplicate'     => FALSE ,
		'subdata_function' => FALSE ,
		'param'            => 'videoIds' . $pid_suffix ,
		'fields'           => array(
			array(
				'name'            => __( 'Videos Ids' , WPVR_LANG ) .
				                     '<br/><div class="wpvr_count_videos wpvr_count_items" ></div>' ,
				'desc'            => 'Example: http://www.youtube.com/watch?v=<span class="wpvr_wanted_param">yVcuniTfgyE</span><br/>' .
				                     __( 'List of video IDs separated by commas.' , WPVR_LANG ) ,
				'id'              => 'videoIds' . $pid_suffix ,
				'type'            => 'textarea' ,
				'wpvrType'        => $type_id ,
				'wpvrService'     => $vs[ 'id' ] ,
				'wpvrClass'       => 'countMyItems' ,
				'wpvr_attributes' => array(
					'listener' => 'videoIds' . $pid_suffix ,
				) ,

			) ,

		) ,
	);