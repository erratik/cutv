<?php

	/***************************/
	/* WPVR Global HOOKS Hook */
	/*************************/


	/* Loading WPVR translation files */
	add_action( 'plugins_loaded' , 'wpvr_load_textdomain' );
	function wpvr_load_textdomain() {
		load_plugin_textdomain( WPVR_LANG , FALSE , dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );
	}

	/* Plugin Init Action Hook */
	add_action( 'init' , 'wpvr_init' );
	function wpvr_init() {
		/*starting a PHP session if not already started */
		if( ! session_id() ) {
			@session_start();
		}
		wpvr_mysql_install();
		add_image_size( 'wpvr_hard_thumb' , 200 , 150 , TRUE ); // Hard Crop Mode
		add_image_size( 'wpvr_soft_thumb' , 200 , 150 ); // Soft Crop Mode
		wpvr_capi_init();

	}

	add_action( 'load-edit.php' , 'wpvr_add_slug_edit_screen_header' , -1 );
	function wpvr_add_slug_edit_screen_header() {
		if( WPVR_SMOOTH_SCREEN_ENABLED === TRUE ) {
			$screen = get_current_screen();

			if(
				$screen->id == 'edit-' . WPVR_SOURCE_TYPE
				|| $screen->id == 'edit-' . WPVR_VIDEO_TYPE
			) {
				?>

				<div class="wpvr_super_wrap" style=" transition:visibility 1s ease-in-out;visibility:hidden;">
				<!-- SUPER_WRAP -->
				<?php
			}

		}
	}

	add_action( 'admin_footer' , 'wpvr_add_slug_edit_screen_footer' , 999999999999 );
	function wpvr_add_slug_edit_screen_footer() {
		if( WPVR_SMOOTH_SCREEN_ENABLED === TRUE ) {
			$screen = get_current_screen();
			if(
				$screen->id == 'edit-' . WPVR_SOURCE_TYPE
				|| $screen->id == 'edit-' . WPVR_VIDEO_TYPE
			) {
				?>

				<!-- SUPER_WRAP -->


				<?php
			}

		}

	}

	/* Load JS scripts(minified or normal) in admin area only */
	add_action( 'admin_head' , 'wpvr_load_scripts' );
	function wpvr_load_scripts() {

		if( WPVR_DEV_MODE === FALSE && WPVR_USE_MIN_JS === TRUE ) {
			$js_functions_file = WPVR_URL . 'assets/js/wpvr.functions.min.js';
		} else {
			$js_functions_file = WPVR_URL . 'assets/js/wpvr.functions.js';

		}

		$js_globals_array  = array(
			'functions_js' => $js_functions_file ,
			'api_auth_url' => WPVR_AUTH_URL ,
			'wpvr_js'      => WPVR_JS ,

		);
		$js_localize_array = array(
			'confirm_import_sample_sources' => __( 'Do you really want to import demo sources ?' , WPVR_LANG ) ,
			'save_source_first'             => __( 'Your source has changed. Please save it before testing it.' , WPVR_LANG ) ,
			'save_source'                   => '<i class="fa fa-save"></i> ' . __( 'Save Source' , WPVR_LANG ) ,
			'group_info'                    => __( 'Grouped Testing Info' , WPVR_LANG ) ,
			'add_to_unwanted'               => __( 'Add to Unwanted' , WPVR_LANG ) ,
			'remove_from_unwanted'          => __( 'Remove from Unwanted' , WPVR_LANG ) ,
			'license_cancelled'             => __( 'Activation cancelled. You can now use your purchase code on your new domain.' , WPVR_LANG ) ,
			'license_reset'                 => __( 'License reset.' , WPVR_LANG ) ,
			'activation_cancel_confirm'     => __( 'Do you really want to cancel your activation ?' , WPVR_LANG ) ,
			'licence_reset_confirm'         => __( 'Do you really want to reset this addon license ?' , WPVR_LANG ) ,
			'action_done'                   => __( 'Action done successfully.' , WPVR_LANG ) ,
			'select_preset'                 => __( 'Please select a dataFiller Preset.' , WPVR_LANG ) ,
			'correct_entry'                 => __( 'Please enter both Data to Add and the custom field name where to add.' , WPVR_LANG ) ,
			'confirm_add_from_preset'       => __( 'Do you really want to add all this preset fillers ?' , WPVR_LANG ) ,
			'fillers_deleted'               => __( 'All the data fillers have been deleted successfully.' , WPVR_LANG ) ,
			'confirm_delete_fillers'        => __( 'Do you really want to delete all the data fillers ?' , WPVR_LANG ) ,
			'confirm_run_sources'           => __( 'Do you really want to run this source ?' , WPVR_LANG ) ,
			'confirm_merge_items'           => __( 'Do you really want to merge the selected items ?' , WPVR_LANG ) ,
			'confirm_merge_dups'            => __( 'Do you really want to merge those duplicates ?' , WPVR_LANG ) ,
			'is_now_connected'              => __( 'is now connected !' , WPVR_LANG ) ,
			'confirm_cancel_access'         => __( 'Do you really want to cancel this access ?' , WPVR_LANG ) ,
			'import_videos'                 => __( 'Import Videos' , WPVR_LANG ) ,
			'wp_video_robot'                => __( 'WP Video Robot' , WPVR_LANG ) ,
			'source_with_no_name'           => __( 'Do you really want to add this source without a name.' , WPVR_LANG ) ,
			'source_with_no_type'           => __( 'Please choose a source type to continue.' , WPVR_LANG ) ,
			'source_with_big_wanted'        => __( 'Wanted Videos are limited to' , WPVR_LANG ) . ' : ' . WPVR_MAX_WANTED_VIDEOS ,
			'video_preview'                 => __( 'Video Preview' , WPVR_LANG ) ,
			'work_completed'                => __( 'Work Completed !' , WPVR_LANG ) ,
			'videos_unanted_successfully'   => __( 'videos added to unwanted successfuly' , WPVR_LANG ) ,
			'videos_added_successfully'     => __( 'videos added successfuly' , WPVR_LANG ) ,
			'cancel_anyway'                 => ' <i class="fa fa-remove"></i> ' . __( 'Cancel anyway' , WPVR_LANG ) ,
			'back_to_work'                  => __( 'Continue the work in progress' , WPVR_LANG ) ,
			'reset_yes'                     => ' <i class="fa fa-check"></i> ' . __( 'Confirm Reset' , WPVR_LANG ) ,
			'reset_no'                      => ' <i class="fa fa-remove"></i> ' . __( 'Cancel' , WPVR_LANG ) ,
			'yes'                           => ' <i class="fa fa-check"></i> ' . __( 'Yes' , WPVR_LANG ) ,
			'no'                            => ' <i class="fa fa-remove"></i> ' . __( 'No' , WPVR_LANG ) ,
			'import_btn'                    => ' <i class="fa fa-download"></i> ' . __( 'Import' , WPVR_LANG ) ,
			'are_you_sure'                  => __( 'Are you sure ?' , WPVR_LANG ) ,
			'really_want_cancel'            => __( 'Do you really want to cancel the work in progress ?' , WPVR_LANG ) ,
			'continue_button'               => ' <i class="fa fa-play"></i> ' . __( 'Continue' , WPVR_LANG ) ,
			'cancel_button'                 => ' <i class="fa fa-remove"></i> ' . __( 'Cancel' , WPVR_LANG ) ,
			'ok_button'                     => ' <i class="fa fa-check"></i> ' . __( 'OK' , WPVR_LANG ) ,
			'export_button'                 => ' <i class="fa fa-download"></i> ' . __( 'Export' , WPVR_LANG ) ,
			'dismiss_button'                => ' <i class="fa fa-close"></i> ' . __( 'DISMISS' , WPVR_LANG ) ,
			'close_button'                => ' <i class="fa fa-close"></i> ' . __( 'Close' , WPVR_LANG ) ,
			'pause_button'                  => ' <i class="fa fa-pause"></i> ' . __( 'Pause' , WPVR_LANG ) ,
			'options_set_to_default'        => __( 'WPVR Options set to default !' , WPVR_LANG ) ,
			'options_reset_confirm'         => __( 'Do you really want to reset options to default ?' , WPVR_LANG ) ,
			'options_saved'                 => __( 'Options successfully saved' , WPVR_LANG ) ,
			'addon_options_saved'           => __( 'Addon options successfully saved' , WPVR_LANG ) ,
			'licences_saved'                => __( 'Licences successfully saved' , WPVR_LANG ) ,
			'options_reset_confirm'         => __( 'Do you really want to reset options to default ?' , WPVR_LANG ) ,
			'adding_selected_videos'        => __( ' Adding selected videos' , WPVR_LANG ) ,
			'work_in_progress'              => __( 'Work in progress' , WPVR_LANG ) ,
			'loading'                       => __( 'Loading' , WPVR_LANG ) . ' <i class="wpvr_spinning_icon fa fa-cog fa-spin"></i> ' ,
			'loadingCenter'                 => '<div class="wpvr_loading_center"><br /><br />' . __( 'Please Wait ...' , WPVR_LANG )
			                                   . ' <br/><br/><i class="wpvr_spinning_icon fa fa-cog fa-spin"></i></div>' ,
			'please_wait'                   => __( 'Please wait' , WPVR_LANG ) ,
			'want_clear_log'                => __( 'Do you really want to clear the log ?' , WPVR_LANG ) ,
			'system_infos'                  => __( 'System Informations' , WPVR_LANG ) ,
			'item'                          => __( 'item' , WPVR_LANG ) ,
			'items'                         => __( 'items' , WPVR_LANG ) ,
			'confirm_delete_permanently'    => __( 'Do you really want to delete permanently the selected items ?' , WPVR_LANG ) ,
			'want_remove_items'             => __( 'Do you really want to remove permanently the selected items ?' , WPVR_LANG ) ,
			'videos_removed_successfully'   => __( 'video(s) removed from deferred' , WPVR_LANG ) ,
			'showing'                       => __( 'Showing' , WPVR_LANG ) ,
			'on'                            => __( 'on' , WPVR_LANG ) ,
			'page'                          => __( 'Page' , WPVR_LANG ) ,
			'items'                         => __( 'items' , WPVR_LANG ) ,
			'videos_processed_successfully' => __( 'videos processed successfully' , WPVR_LANG ) ,
			'errorJSON'                     => __( 'Headers already sent by some other scripts. Error thrown :' , WPVR_LANG ) ,
			'error'                     => __( 'Error' , WPVR_LANG ) ,
			'confirm_run_fillers'           => __( 'Run fillers on existant videos ? This may take some time.' , WPVR_LANG ) ,
			'confirm_remove_filler'         => __( 'Do you really want to remove this filler ?' , WPVR_LANG ) ,
		);

		wp_enqueue_script( 'jquery' );
		//wp_enqueue_script('wpvr_functions', WPVR_URL.'assets/js/wpvr.functions.js' . '?version='.WPVR_VERSION );


		if( WPVR_DEV_MODE === FALSE && WPVR_USE_MIN_JS === TRUE ) {
			$js_file = WPVR_URL . 'assets/js/wpvr.scripts.min.js';

			wp_register_script( 'wpvr_scripts' , $js_file . '?version=' . WPVR_VERSION , array( 'jquery' ) );
			wp_localize_script( 'wpvr_scripts' , 'wpvr_localize' , $js_localize_array );
			wp_localize_script( 'wpvr_scripts' , 'wpvr_globals' , $js_globals_array );
			wp_enqueue_script( 'wpvr_scripts' );

		} else {
			$js_file = WPVR_URL . 'assets/js/wpvr.scripts.js';

			wp_register_script( 'wpvr_scripts_chart' , WPVR_URL . 'assets/js/wpvr.chart.min.js' );
			wp_enqueue_script( 'wpvr_scripts_chart' );

			wp_register_script( 'wpvr_scripts_selectize' , WPVR_URL . 'assets/js/wpvr.selectize.min.js' );
			wp_enqueue_script( 'wpvr_scripts_selectize' );

			wp_register_script( 'wpvr_scripts_countup' , WPVR_URL . 'assets/js/wpvr.countup.js' );
			wp_enqueue_script( 'wpvr_scripts_countup' );

			wp_register_script( 'wpvr_scripts_noui' , WPVR_URL . 'assets/js/wpvr.slider.min.js' );
			wp_enqueue_script( 'wpvr_scripts_noui' );

			wp_register_script( 'wpvr_scripts' , $js_file . '?version=' . WPVR_VERSION );
			wp_localize_script( 'wpvr_scripts' , 'wpvr_localize' , $js_localize_array );
			wp_localize_script( 'wpvr_scripts' , 'wpvr_globals' , $js_globals_array );
			wp_enqueue_script( 'wpvr_scripts' );
		}
	}

	/* Load CSS files (minified or normal version) in admin area only */
	add_action( 'admin_head' , 'wpvr_load_styles' );
	function wpvr_load_styles() {


		if( WPVR_USE_LOCAL_FONTAWESOME ){
			wp_register_style( 'wpvr_icons' , WPVR_URL . 'assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'wpvr_icons' );
		}else{
			wp_register_style( 'wpvr_icons' ,WPVR_FONTAWESOME_CSS_URL );
			wp_enqueue_style( 'wpvr_icons' );
		}

		if( WPVR_DEV_MODE === FALSE && WPVR_USE_MIN_CSS === TRUE ) {

			$css_file = WPVR_URL . 'assets/css/wpvr.styles.min.css';
			wp_register_style( 'wpvr_styles' , $css_file . '?version=' . WPVR_VERSION );
			wp_enqueue_style( 'wpvr_styles' );

		} else {

			$css_file = WPVR_URL . 'assets/css/wpvr.styles.css';
			wp_register_style( 'wpvr_selectize' , WPVR_URL . 'assets/css/wpvr.selectize.min.css' );
			wp_enqueue_style( 'wpvr_selectize' );

			wp_register_style( 'wpvr_noui_styles' , WPVR_URL . 'assets/css/wpvr.slider.min.css' );
			wp_enqueue_style( 'wpvr_noui_styles' );

			wp_register_style( 'wpvr_flags_styles' , WPVR_URL . 'assets/css/wpvr.flags.min.css' );
			wp_enqueue_style( 'wpvr_flags_styles' );

			wp_register_style( 'wpvr_styles' , $css_file . '?version=' . WPVR_VERSION );
			wp_enqueue_style( 'wpvr_styles' );

		}


		if( is_rtl() ) {
			wp_enqueue_style( 'wpvr_styles_rtl' , WPVR_URL . 'assets/css/wpvr.styles.rtl.css' );
		}
	}

	/* Load CSS fix for embeding youtube player */
	add_action( 'wp_head' , 'wpvr_load_services_css_styles' , 120 );
	add_action( 'admin_head' , 'wpvr_load_services_css_styles' , 120 );
	function wpvr_load_services_css_styles() {
		global $wpvr_vs;
		$css = '';
		if( count( $wpvr_vs ) != 0 ) {
			foreach ( $wpvr_vs as $vs ) {
				if( WPVR_DEV_MODE === TRUE ) {
					$css .= "/*WPVR DEV MODE */\n";
					$css .= "#adminmenuback{display:none;}\n";
					$css .= "/*WPVR DEV MODE */\n";
				}
				$css .= "/*WPVR VIDEO SERVICE STYLES ( " . $vs[ 'label' ] . " ) */\n";
				//$css .= "/* START */\n";
				$css .= trim( preg_replace( '/\t+/' , '' , $vs[ 'get_styles' ]() ) );
				//$css .= "<!-- END -->\n";
				$css .= "/* WPVR VIDEO SERVICE STYLES ( " . $vs[ 'label' ] . " ) */\n\n";
			}
		}
		echo "<style>\n $css\n </style>\n";
	}


	/* Load CSS fix for embeding youtube player */
	add_action( 'wp_head' , 'wpvr_load_dynamic_css' , 100 );
	add_action( 'admin_head' , 'wpvr_load_dynamic_css' , 100 );
	function wpvr_load_dynamic_css() {
		global $wpvr_status , $wpvr_services;

		$css = '';
		$css .= '.wpvr_embed .fluid-width-video-wrapper{ padding-top:56% !important; }';
		$css .= '.ad-container.ad-container-single-media-element-annotations.ad-overlay{ background:red !important; }';
		/*
		$css .= '.wpvr_button{ background : '.WPVR_BUTTON_BGCOLOR.' !important; color : '.WPVR_BUTTON_COLOR.' !important; }';
		$css .= '.wpvr_button:hover{ background : '.WPVR_BUTTON_HOVER_BGCOLOR.' !important; color : '.WPVR_BUTTON_HOVER_COLOR.' !important; }';
		*/
		foreach ( $wpvr_status as $value => $data ) {
			$css .= '.wpvr_video_status.' . $value . '{ background:' . $data[ 'color' ] . ' ;} ';
		}
		/*foreach( $wpvr_services as $value=> $data){
			$css .= '.wpvr_service_icon.'.$value.'{ background:'.$data['color'].';} ';
			$css .= '.wpvr_source_icon_right.'.$value.'{ background:'.$data['color'].';} ';
			$css .= '.wpvrArgs[service='.$value.'] , .wpvr_source_icon[service='.$value.']{ border-color:'.$data['color'].';} ';
		}
		*/


		?>
		<style>
			<?php echo $css; ?>
		</style>
		<?php
	}

	/* Load CSS fix for embeding youtube player */
	add_action( 'wp_footer' , 'wpvr_load_css_fix' );
	function wpvr_load_css_fix() {
		global $wpvr_status , $wpvr_services;

		$css = '';

		foreach ( $wpvr_status as $value => $data ) {
			$css .= '.wpvr_video_status.' . $value . '{ background-color:red;}';
		}


		?>
		<style>
			<?php echo $css; ?>
			.wpvr_embed {
				position: relative !important;
				padding-bottom: 56.25% !important;
				padding-top: 30px !important;
				height: 0 !important;
				overflow: hidden !important;
			}

			.wpvr_embed.wpvr_vst_embed {
				padding-top: 0px !important;
			}

			.wpvr_embed iframe, .wpvr_embed object, .wpvr_embed embed {
				position: absolute !important;
				top: 0 !important;
				left: 0 !important;
				width: 100% !important;
				height: 100% !important;
			}
		</style>
		<?php
	}

	/* Define WPVR menu items */
	add_action( 'admin_menu' , 'wpvr_admin_actions' );
	function wpvr_admin_actions() {
		$can_show_menu_links = wpvr_can_show_menu_links();

		if( $can_show_menu_links === TRUE ) {




			add_menu_page(
				WPVR_LANG ,
				'WP Video Robot' ,
				'read' ,
				WPVR_LANG ,
				'wpvr_action_render' ,
				WPVR_URL . "assets/images/wpadmin.icon.png"
			//'dashicons-lightbulb'
			);

			add_submenu_page(
				WPVR_LANG ,
				__( 'WELCOME | WP video Robot' , WPVR_LANG ) ,
				__( 'Welcome' , WPVR_LANG ) ,
				'read' ,
				'wpvr-welcome' ,
				'wpvr_welcome_render'
			);

			add_submenu_page(
				WPVR_LANG ,
				__( 'VIDEOS | WP video Robot' , WPVR_LANG ) ,
				__( 'Manage Videos' , WPVR_LANG ) ,
				'read' ,
				'wpvr-manage' ,
				'wpvr_manage_render'
			);

			add_submenu_page(
				WPVR_LANG ,
				__( 'OPTIONS | WP video Robot' , WPVR_LANG ) ,
				__( 'Manage Options' , WPVR_LANG ) ,
				'read' ,
				'wpvr-options' ,
				'wpvr_options_render'
			);
			add_submenu_page(
				WPVR_LANG ,
				__( 'LOG | WP video Robot' , WPVR_LANG ) ,
				__( 'Activity Logs' , WPVR_LANG ) ,
				'read' ,
				'wpvr-log' ,
				'wpvr_log_render'
			);

			add_submenu_page(
				WPVR_LANG ,
				__( 'DEFERRED VIDEOS | WP video Robot' , WPVR_LANG ) ,
				__( 'Deferred Videos' , WPVR_LANG ) ,
				'read' ,
				'wpvr-deferred' ,
				'wpvr_deferred_render'
			);

			add_submenu_page(
				WPVR_LANG ,
				__( 'UNWANTED VIDEOS | WP Video Robot' , WPVR_LANG ) ,
				__( 'Unwanted Videos' , WPVR_LANG ) ,
				'read' ,
				'wpvr-unwanted' ,
				'wpvr_unwanted_render'
			);

			add_submenu_page(
				WPVR_LANG ,
				__( 'Import | WP video Robot' , WPVR_LANG ) ,
				__( 'Import Panel' , WPVR_LANG ) ,
				'read' ,
				'wpvr-import' ,
				'wpvr_import_render'
			);
			add_submenu_page(
				WPVR_LANG ,
				__( 'Licences | WP video Robot' , WPVR_LANG ) ,
				__( 'Manage Licences' , WPVR_LANG ) ,
				'read' ,
				'wpvr-licences' ,
				'wpvr_licences_render'
			);
			if( WPVR_DEV_MODE === TRUE || WPVR_ENABLE_SANDBOX === TRUE ) {
				add_submenu_page(
					WPVR_LANG ,
					__( 'Sandbox | WP Video Robot' , WPVR_LANG ) ,
					__( 'Sandbox' , WPVR_LANG ) ,
					'read' ,
					'wpvr-sandbox' ,
					'wpvr_sandbox_render'
				);
			}


			/* Removing Main WPVR Menu Item */
			global $menu;
			global $submenu;
			$submenu[ WPVR_LANG ][ 0 ][ 0 ] = __( 'Plugin Dashboard' , WPVR_LANG );
			//remove_submenu_page( WPVR_LANG , WPVR_LANG );

		}


	}

	/* Add Menu of Addons */
	add_action( 'admin_menu' , 'wpvr_addons_admin_actions' );
	function wpvr_addons_admin_actions() {
		if( WPVR_ENABLE_ADDONS === TRUE ) {

			$can_show_menu_links = wpvr_can_show_menu_links();
			if( $can_show_menu_links === TRUE ) {
				add_menu_page(
					'WPVRM' ,
					'WPVR Addons' ,
					'read' ,
					'wpvr-addons' ,
					'wpvr_addons_render' ,
					WPVR_URL . "assets/images/wpadmin.icon.png"
				);

				add_submenu_page(
					'wpvr-addons' ,
					__( 'ADDONS | WP video Robot' , WPVR_LANG ) ,
					__( 'Browse Addons' , WPVR_LANG ) ,
					'read' ,
					'wpvr-addons' ,
					'wpvr_addons_render'
				);

				/* Removing Main WPVR Menu Item */
				global $menu , $submenu , $wpvr_addons;
				//$submenu['wpvr-addons'][0][0] = __('Browse Addons', WPVR_LANG );
			}
		}
	}


	/* Define plugin included pages */

	/* Rendering Options */
	function wpvr_manage_render() {
		if( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.manage.php' );
	}


	/* Rendering Addons */
	function wpvr_welcome_render() {
		if( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.welcome.php' );
	}

	/* Rendering Addons */
	function wpvr_addons_render() {
		if( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		//global $addon_id;
		//$addon_id = 'wpvrm';
		include( WPVR_PATH . 'addons/wpvr.addons.php' );
	}

	/* Rendering Licences */
	function wpvr_licences_render() {
		if( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.licences.php' );
	}


	/* Rendering Options */
	function wpvr_options_render() {
		if( ! WPVR_NONADMIN_CAP_OPTIONS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.options.php' );
	}

	/* Rendering Logs */
	function wpvr_log_render() {
		if( ! WPVR_NONADMIN_CAP_LOGS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.log.php' );
	}

	/* Rendering Deferred */
	function wpvr_deferred_render() {
		if( ! WPVR_NONADMIN_CAP_DEFERRED && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.deferred.php' );
	}

	/* Rendering Deferred */
	function wpvr_unwanted_render() {
		if( ! WPVR_NONADMIN_CAP_DEFERRED && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.unwanted.php' );
	}

	/* Rendering Actions */
	function wpvr_action_render() {
		if( ! WPVR_NONADMIN_CAP_ACTIONS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		global $wpvr_pages;
		$wpvr_pages = TRUE;
		include( WPVR_PATH . 'includes/wpvr.actions.php' );
	}

	/* Rendering Import */
	function wpvr_import_render() {
		if( ! WPVR_NONADMIN_CAP_IMPORT && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();

			return FALSE;
		}
		include( WPVR_PATH . 'includes/wpvr.import.php' );
	}


	/* Define hourly running event */
	add_action( 'wpvr_hourly_event' , 'wpvr_run_hourly' );
	function wpvr_run_hourly() {
		global $wpvr_options;
		if( ! $wpvr_options[ 'useCronTab' ] ) {
			include( WPVR_PATH . 'wpvr.cron.php' );
		}
	}


	/* Add WP Video Robot shortcode for embeding videos on post */
	add_shortcode( 'wpvr' , 'wpvr_embed_shortcode' );
	function wpvr_embed_shortcode( $atts ) {
		$wpvr_video_id      = get_post_meta( $atts[ 'id' ] , 'wpvr_video_id' , TRUE );
		$wpvr_video_service = get_post_meta( $atts[ 'id' ] , 'wpvr_video_service' , TRUE );
		$player             = wpvr_video_embed(
			$wpvr_video_id ,
			$atts[ 'id' ] ,
			FALSE ,
			$wpvr_video_service
		);
		$embedCode          = '<div class="wpvr_embed">' . $player . '</div>';
		//new dBug( $wpvr_video_id);
		$views = get_post_meta( $atts[ 'id' ] , 'wpvr_video_views' , TRUE );
		update_post_meta( $atts[ 'id' ] , 'wpvr_video_views' , $views + 1 );
		wpvr_update_dynamic_video_views( $atts[ 'id' ] , $views + 1 );
		$embedCode = apply_filters( 'wpvr_replace_player_code' , $embedCode , $atts[ 'id' ] );

		return $embedCode;
	}

	/* Add WP Video Robot shortcode for embeding videos on post */
	add_shortcode( 'wpvr_views' , 'wpvr_views_shortcode' );
	function wpvr_views_shortcode( $atts ) {
		$wpvr_video_views = get_post_meta( $atts[ 'id' ] , 'wpvr_video_views' , TRUE );

		return $wpvr_video_views;
	}

	add_filter( 'the_content' , 'wpvr_video_autoembed_function' , 100 );
	function wpvr_video_autoembed_function( $content ) {
		global $post , $wpvr_options , $wpvr_dynamics;
		//d( $wpvr_options );
		if( isset( $wpvr_dynamics[ 'autoembed_done' ] ) && $wpvr_dynamics[ 'autoembed_done' ] == 1 ) {
			return $content;
		}
		$disableAutoEmbed = get_post_meta( $post->ID , 'wpvr_video_disableAutoEmbed' , TRUE );
		if( $disableAutoEmbed == 'default' || $disableAutoEmbed == '' ){
			$disableAutoEmbed = $wpvr_options['autoEmbed'] ? 'off' : 'on' ;
		}

		if( is_singular() && $post->post_type == WPVR_VIDEO_TYPE ) {
			//d( $disableAutoEmbed );

			if( $disableAutoEmbed == 'on' ) {
				return $content;
			}

			$embedCode = wpvr_render_modified_player( $post->ID );
			//d( $embedCode );
			$views = get_post_meta( $post->ID , 'wpvr_video_views' , TRUE );
			update_post_meta( $post->ID , 'wpvr_video_views' , $views + 1 );

			wpvr_update_dynamic_video_views( $post->ID , $views + 1 );
			$text_content = '';
			$text_content .= stripslashes( $wpvr_dynamics[ 'content_tags' ][ 'before' ] );
			$text_content .= $content;
			$text_content .= stripslashes( $wpvr_dynamics[ 'content_tags' ][ 'after' ] );


			if( $wpvr_options[ 'autoEmbed' ] ) {
				//$wpvr_dynamics[ 'autoembed_done' ] = 1;
				if( $wpvr_options[ 'removeVideoContent' ] ) {
					return $embedCode . ' <br/> ';
				} else {
					return $embedCode . ' <br/> ' . $text_content;
				}
			} else {
				return $text_content;
			}

		} else {
			return $content;
		}

	}

	/* Defining my own custom icon styles */
	add_action( 'admin_head' , 'wpvr_add_menu_icons_styles' );
	function wpvr_add_menu_icons_styles() {
		?>
		<style>
			#adminmenu .menu-icon-video div.wp-menu-image:before {
				content: "\f126";
			}

			#adminmenu .menu-icon-source div.wp-menu-image:before {
				content: "\f179";
			}
		</style><?php
	}

	/* Add query video custom post types on pre get posts action */
	add_filter( 'pre_get_posts' , 'wpvr_include_custom_post_type_queries' , 1000 , 1 );
	function wpvr_include_custom_post_type_queries( $query ) {
		global $wpvr_options , $wpvr_private_cpt;
		$getOut = FALSE;

		//d( DOING_AJAX );
		if( $query->is_page() ) {
			return $query;
		}

		if( ! defined( 'DOING_AJAX' ) || DOING_AJAX === FALSE ) {
			if( is_admin() ) {
				return $query;
			}
		}

		// DEPRECATED since 1.7.5
		//$wpvr_query_vars = apply_filters( 'wpvr_extend_preget_post_query_vars' , $query->query_vars );
		//if( isset( $wpvr_query_vars[ 'return_query' ] ) && $wpvr_query_vars[ 'return_query' ] === TRUE ) {
		//	return $query;
		//}


		$wpvr_private_query_vars = array(
			'product_cat' ,
			'download_artist' ,
			'download_tag' ,
			'download_category' ,
		);
		$wpvr_private_query_vars = apply_filters( 'wpvr_extend_private_query_vars' , $wpvr_private_query_vars );

		foreach ( $query->query_vars as $key => $val ) {
			if( in_array( $key , $wpvr_private_query_vars ) ) {
				return $query;
			}
		}

		if( $wpvr_options[ 'privateCPT' ] == null ) {
			$wpvr_private_cpt = array();
		} else {
			$wpvr_private_cpt = $wpvr_options[ 'privateCPT' ];
		}
		$wpvr_private_cpt = apply_filters( 'wpvr_extend_private_cpt' , $wpvr_private_cpt );


		//_d( $query->get( 'post_type' ) );

		//This line is Bugging with TrueMag Theme
		//if( isset($query->query_vars['suppress_filters']) && $query->query_vars['suppress_filters'] ) return $query;


		//echo "#IAM OUT";
		//_d( $wpvr_private_cpt );
		if( $wpvr_options[ 'addVideoType' ] === TRUE ) {

			$supported = $query->get( 'post_type' );
			//_d( $supported );
			//new dBug( $wpvr_options['privateCPT'] );
			//new dBug( $wpvr_private_cpt );
			if( is_array( $supported ) ) {
				foreach ( $supported as $s ) {
					if( in_array( $s , $wpvr_private_cpt ) ) {
						$getOut = TRUE;
					}
				}
			} else {
				$getOut = in_array( $supported , $wpvr_private_cpt );
			}

			if( $getOut === TRUE ) {
				return $query;
			} elseif( $supported == 'post' || $supported == '' ) {
				$supported = array( 'post' , WPVR_VIDEO_TYPE );
			} elseif( is_array( $supported ) ) {
				array_push( $supported , WPVR_VIDEO_TYPE );
			} elseif( is_string( $supported ) ) {
				$supported = array( $supported , WPVR_VIDEO_TYPE );
			}
			//echo "newSuported = ";new dBug( $supported );

			$query->set( 'post_type' , $supported );

			return $query;
		}
	}

	/* Remove Video Post Type slug from permalink */
	add_filter( 'post_type_link' , 'wpvr_remove_video_slug' , 10 , 3 );
	function wpvr_remove_video_slug( $post_link , $post , $leavename ) {
		global $wpvr_options;

		if( WPVR_VIDEO_TYPE != $post->post_type || 'publish' != $post->post_status ) {
			return $post_link;
		}

		if( $wpvr_options[ 'enableRewriteRule' ] === TRUE ) {
			$post_link = wpvr_render_video_permalink( $post , "/%postname%/" );
			if( $wpvr_options[ 'permalinkBase' ] === 'none' ) {

				$base = '';

			} elseif( $wpvr_options[ 'permalinkBase' ] === 'category' ) {

				$terms = wp_get_object_terms( $post->ID , 'category' );
				if( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[ 0 ] ) ) {
					$taxonomy_slug = $terms[ 0 ]->slug;
				} else {
					$taxonomy_slug = WPVR_UNCATEGORIZED;
				}

				if( $taxonomy_slug == '' ) {
					$base = '';
				} else {
					$base = '/' . $taxonomy_slug . '';
				}

			} elseif( $wpvr_options[ 'permalinkBase' ] === 'custom' ) {

				if( $wpvr_options[ 'customPermalinkBase' ] == '' ) {
					$base = '';
				} else {
					$base = '/' . $wpvr_options[ 'customPermalinkBase' ] . '';
				}

			}

			$permalink = str_replace( WPVR_SITE_URL , WPVR_SITE_URL . $base , $post_link );

			return $permalink;
		} else {

			return wpvr_render_video_permalink( $post );
		}
	}


	/* Define Custom Dashboard Widgets */
	add_action( 'wp_dashboard_setup' , 'wpvr_custom_dashboard_widget' );
	function wpvr_custom_dashboard_widget() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget(
			'home_dashboard_widget' , //ID of the dashboard Widgets
			'WP Video Robot - Global Activity' , //Title of the dashboard Widgets
			'wpvr_custom_dashboard_function' ,
			'side' ,
			'high'
		);
	}


	/* Function to redirect download request to permalink structure */
	add_action( 'template_include' , 'wpvr_download_export_file' );
	function wpvr_download_export_file( $template ) {
		$ext = 'json';
		$tab = explode( '/wpvr_export/' , $_SERVER[ 'REQUEST_URI' ] );
		
		
		if( $tab[ 0 ] == '' ) {
			$xtab = explode( '_@_' , $tab[ 1 ] );
			//d( $xtab );return false;
			if( ! isset( $xtab[ 1 ] ) || $xtab[ 1 ] == '' ) {

				$a = explode( '*' , $xtab[ 0 ] );

				if( isset( $a[ 1 ] ) ) {
					$type            = '';
					$file_name       = $tab[ 1 ];
					$export_filename = $a[ 0 ] . '.' . $a[ 1 ];
				} elseif( strpos( $tab[1] , 'sysinfo' ) != -1 ){
					$type            = "";
					$file_name       = $tab[ 1 ];
					$export_filename = "wpvr_system_info.txt";
				}else{
					//All types
					$type            = "";
					$file_name       = $tab[ 1 ];
					$export_filename = "wpvr_export.".$ext;
				}
			} else {
				if( $xtab[ 1 ] == 'options' ) {
					//options
					$type = "options";
				} elseif( $xtab[ 1 ] == 'sources' ) {
					//sources
					$type = "sources";
				} elseif( $xtab[ 1 ] == 'videos' ) {
					//Videos
					$type = "videos";
				} elseif( $xtab[ 1 ] == 'sysinfo' ) {
					//Videos
					$type = "system_info";
					$ext = "txt";
				}
				$file_name       = $xtab[ 0 ];
				$export_filename = "wpvr_export_" . $type . ".".$ext;
			}


			$file = WPVR_TMP_PATH . '' . $tab[ 1 ];
			header( "Content-type: application/x-msdownload" , TRUE , 200 );
			header( "Content-Disposition: attachment; filename=" . $export_filename );
			header( "Pragma: no-cache" );
			header( "Expires: 0" );
			readfile( $file );
			exit();
		} else {
			return $template;
		}
	}

	/* Function to declare PHP is too old ! */
	add_action( 'admin_notices' , 'wpvr_show_php_too_old' );
	function wpvr_show_php_too_old() {
		if( version_compare( PHP_VERSION , '5.3.0' , '<' ) ) {
			$php_version = explode( '+' , PHP_VERSION );
			?>
			<div class = "error">
				<p>
					<strong>WP Video Robot ERROR</strong><br/>
					<?php echo __( 'You are using PHP version ' , WPVR_LANG ) . $php_version[ 0 ]; ?>.<br/>
					<?php echo __( 'WP Video Robot needs version 5.3.0 at least to work properly.' , WPVR_LANG ); ?><br/>
					<?php echo __( 'Please upgrade PHP.' , WPVR_LANG ); ?>
				</p>
			</div>
			<?php
		}
	}

	/* Function to show error message if cron not writable */
	add_action( 'admin_notices' , 'wpvr_cron_file_permission_issue' );
	function wpvr_cron_file_permission_issue() {
		$f = WPVR_PATH . 'assets/php/cron.txt';
		if( is_writable( $f ) === FALSE ) {
			?>
			<div class = "error">
				<p>
					<strong>WP Video Robot ERROR</strong><br/>
					<?php echo __( 'The plugin cannot work automatically.' , WPVR_LANG ); ?>
					<?php echo __( 'Please, make sure this file is writable :' , WPVR_LANG ); ?>
					<strong><?php echo $f; ?></strong><br/>
					<?php echo __( 'If you cannot do that, contact your host.' , WPVR_LANG ); ?>

				</p>
			</div>
			<?php
		}
	}

	/* Function to show WPVR NOtices */
	add_action( 'admin_notices' , 'wpvr_show_notices' );
	function wpvr_show_notices() {
		$wpvr_notices = get_option( 'wpvr_notices' );
		if( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'do-plugin-upgrade' ) {
			return FALSE;
		}
		if( $wpvr_notices == '' ) {
			return FALSE;
		}
		//d( $wpvr_notices );
		foreach ( $wpvr_notices as $notice ) {
			if( ! isset( $notice[ 'is_manual' ] ) || $notice[ 'is_manual' ] === FALSE ) {
				wpvr_render_notice( $notice );
			}
		}
	}


	/* Function to show demo message */
	add_action( 'admin_notices' , 'wpvr_show_demo_message' );
	function wpvr_show_demo_message() {
		if( WPVR_IS_DEMO ) {
			global $current_user;
			$user_id = $current_user->ID;
			/* Check that the user hasn't already clicked to ignore the message */
			if( ! get_user_meta( $user_id , 'wpvr_show_demo_notice' ) ) {
				global $wpvr_options;
				$hideLink = "?wpvr_show_demo_notice=0";
				foreach ( $_GET as $key => $value ) {
					$hideLink .= "&$key=$value";
				}
				?>
				<div class = "updated">
					<div class = "wpvr_demo_notice">
						<a class = "pull-right" href = "<?php echo $hideLink; ?>"><?php _e( 'Hide this notice' , WPVR_LANG ); ?></a>

						<strong>WELCOME TO THE LIVE DEMO OF WP VIDEO ROBOT v<?php echo WPVR_VERSION; ?></strong><br/><br/>

						<div class = "wpvr_demo_notice_left">
							<i class = "fa fa-smile-o"></i>
						</div>
						<div class = "wpvr_demo_notice_right">
							Feel free to play around with the options, add sources, test them and even schedule them to get a feel for how the plugin works. <br/>Don't forget to check this demo
							<a class = "wpvr_notice_button" href = "<?php echo WPVR_SITE_URL; ?>">FrontEnd</a> to see how do your imported videos render.
							<br/><b>You can also check out our several frontend demo sites <a class = "wpvr_notice_button" href = "<?php echo WPVR_DEMOS_URL; ?>" title = "FRONT END DEMOS">here</a></b>.
							<br/>The contents of the demo site is reset once a week.
						</div>
					</div>

					<div class = "wpvr_clearfix"></div>
				</div>
				<?php
			}
		}
	}

	/* Activation */
	add_action( 'admin_footer' , 'wpvr_check_customer' );

	/* Function to ask for api Key */
	//add_action( 'admin_notices', 'wpvr_ask_for_api_key' );
	function wpvr_ask_for_api_key() {
		global $wpvr_options;
		if( $wpvr_options[ 'apiKey' ] == '' ) {
			?>
			<div class = "error">
				<h3>WP Video Robot</h3>

				<p>
					<?php _e( 'In order to work, the plugin needs a valid Youtube API Key.' , WPVR_LANG ); ?><br/>
					<?php _e( 'Click the link below to know how to get your own Youtube API Key.' , WPVR_LANG ); ?><br/><br/>
					<a target = "_blank" href = "http://support.wpvr.co/tutorials/where-to-find-youtube-api-key/" title = "Click here">
						<?php _e( 'WHERE TO FIND MY YOUTUBE API KEY' , WPVR_LANG ); ?>
					</a> |
					<a target = "_blank" href = "http://support.wpvr.co/" title = "Click here">
						<?php _e( 'Get Support' , WPVR_LANG ); ?>
					</a>
				</p>
			</div>
			<?php
		}
	}


	/* Display message to adapt old data */
	add_action( 'admin_notices' , 'wpvr_adapt_check_imported' );
	function wpvr_adapt_check_imported() {
		global $wpvr_imported;
		$wpvr_actions_url = admin_url( 'admin.php?page=wpvr&update_imported' , 'http' );
		//new dBug( $wpvr_imported );
		if( isset( $_GET[ 'update_imported' ] ) ) {
			return FALSE;
		}
		if( $wpvr_imported === FALSE ) {
			return FALSE;
		}
		if( $wpvr_imported == '' || ! is_array( $wpvr_imported ) ) {

			$notice = array();
			//d( $wpvr_imported );

			?>
			<div class = "error warning wpvr_wp_notice" style = "display:none;">
				<div>
					<b><?php _e( 'WP Video Robot WARNING' , WPVR_LANG ); ?></b> : <br/>
					<?php _e( 'Looks like the anti duplicates filter is OFF.' , WPVR_LANG ); ?>
					<br/>
					<a href = "<?php echo $wpvr_actions_url; ?>">
						<?php echo __( 'Click here to turn it ON' , WPVR_LANG ); ?>.
					</a>
				</div>

			</div>

			<?php
		}
	}


	/* Display message to adapt old data */
	add_action( 'admin_notices' , 'wpvr_adapt_old_data_reminder' );
	function wpvr_adapt_old_data_reminder() {
		if( isset( $_GET[ 'adapt_old_data' ] ) ) {
			return FALSE;
		}
		$wpvr_actions_url = admin_url( 'admin.php?page=wpvr&adapt_old_data' , 'http' );
		$wpvr_is_adapted  = get_option( 'wpvr_is_adapted' );

		//new dBug( $wpvr_is_adapted );

		if( $wpvr_is_adapted != WPVR_VERSION ) {
			global $wpdb;

			$sql_videos
				= "
                    SELECT
                        count(*)
                    FROM
                        $wpdb->posts P
                    WHERE P.ID IN(
                        SELECT
                            P.ID
                        FROM
                            $wpdb->posts P
                            INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
                        WHERE
                            P.post_type = '" . WPVR_VIDEO_TYPE . "'
                            AND post_status != 'auto-draft'
                            AND M.meta_key = 'wpvr_video_plugin_version'
                            AND M.meta_value < '" . WPVR_VERSION . "'
                    )
                ";
			$sql_sources
				= "
                    SELECT
                        count(*)
                    FROM
                        $wpdb->posts P
                    WHERE P.ID IN(
                        SELECT
                            P.ID
                        FROM
                            $wpdb->posts P
                            INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
                        WHERE
                            P.post_type = '" . WPVR_SOURCE_TYPE . "'
                            AND post_status != 'auto-draft'
                            AND M.meta_key = 'wpvr_source_plugin_version'
                            AND M.meta_value < '" . WPVR_VERSION . "'
                    )
                ";

			//$items = $wpdb->get_results( $sql_sources , OBJECT);
			//new dBug( $items );
			$count_sources = $wpdb->get_var( $sql_sources );
			$count_videos  = $wpdb->get_var( $sql_videos );

			if( $count_videos != 0 || $count_sources != 0 ) {
				$info_notice = array(
					'title'   => __( 'WP Video Robot WARNING' , WPVR_LANG ) ,
					'class'   => 'warning' , //updated or warning or error
					'content' => '' .
					             __( 'Looks like you have some sources and videos from an older version of the plugin.' , WPVR_LANG ) .
					             '<br/>' .
					             '<a href = "' . $wpvr_actions_url . '">' .
					             __( 'Click here to adapt them to this new version' , WPVR_LANG ) . ' ( ' . WPVR_VERSION . ' )' .
					             '</a>'
					,
					'hidable' => FALSE ,
					'color'   => '#999' ,
					'icon'    => 'fa-info-circle' ,
				);
				wpvr_render_notice( $info_notice );
			} else {
				update_option( 'wpvr_is_adapted' , WPVR_VERSION );
			}
		}
	}

	add_action( 'admin_init' , 'wpvr_demo_message_ignore' );
	function wpvr_demo_message_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if( isset( $_GET[ 'wpvr_show_demo_notice' ] ) && '0' == $_GET[ 'wpvr_show_demo_notice' ] ) {
			add_user_meta( $user_id , 'wpvr_show_demo_notice' , 'true' , TRUE );
		}

		if( isset( $_GET[ 'wpvr_hide_notice' ] ) && $_GET[ 'wpvr_hide_notice' ] != '' ) {
			add_user_meta( $user_id , $_GET[ 'wpvr_hide_notice' ] , 'true' , TRUE );
		}

	}


	/* Function to prevent from showing content on loops */
	add_action( 'the_content' , 'wpvr_remove_flow_content' );
	function wpvr_remove_flow_content( $html ) {
		if( is_admin() || ! defined( 'WPVR_REMOVE_FLOW_CONTENT' ) || WPVR_REMOVE_FLOW_CONTENT === FALSE ) {
			return $html;
		} else {
			if( ! is_singular() ) {
				return '';
			} else {
				return $html;
			}
		}
	}

	/* Function to prevent from showing tags on loops */
	add_action( 'term_links-post_tag' , 'wpvr_remove_flow_tags' );
	function wpvr_remove_flow_tags( $tags ) {
		if( is_admin() || ! defined( 'WPVR_REMOVE_FLOW_TAGS' ) || WPVR_REMOVE_FLOW_TAGS === FALSE ) {
			return $tags;
		} else {
			if( ! is_singular() ) {
				return array();
			} else {
				return $tags;
			}
		}
	}


	/* Function for whether to show thumbnail on single */
	add_action( 'post_thumbnail_html' , 'wpvr_remove_thumb_single_function' );
	function wpvr_remove_thumb_single_function( $html ) {
		if( is_admin() || ! defined( 'WPVR_REMOVE_THUMB_SINGLE' ) || WPVR_REMOVE_THUMB_SINGLE === FALSE ) {
			return $html;
		} else {
			if( is_singular() ) {
				return '';
			} else {
				return $html;
			}
		}
	}

	/* Function for replacing post thumbnail by embeded video player */
	add_action( 'post_thumbnail_html' , 'wpvr_video_thumbnail_embed' , 20 , 2 );
	function wpvr_video_thumbnail_embed( $html , $post_id ) {
		global $wpvr_options , $wpvr_is_admin;
		if( $wpvr_is_admin === TRUE || is_admin() || $wpvr_options[ 'videoThumb' ] === FALSE ) {
			return $html;
		} else {
			if( is_singular() ) {
				return $html;
			} else {
				$wpvr_video_id = get_post_meta( $post_id , 'wpvr_video_id' , TRUE );
				$wpvr_service  = get_post_meta( $post_id , 'wpvr_video_service' , TRUE );
				$player        = wpvr_video_embed(
					$wpvr_video_id ,
					$post_id ,
					$autoPlay = FALSE ,
					$wpvr_service
				);
				$embedCode     = '<div class="wpvr_embed">' . $player . '</div>';

				return $embedCode;
			}
		}
	}

	/* Actions to be done on the activation of WPVR */
	//add_action( 'activated_plugin', 'wpvr_activation', 10, 2 );
	register_activation_hook( WPVR_MAIN_FILE , 'wpvr_activation' );
	function wpvr_activation() {

		wpvr_reset_on_activation();

		wpvr_start_plugin( 'wpvr' , WPVR_VERSION , FALSE );


		wp_schedule_event( time() , 'hourly' , 'wpvr_hourly_event' );
		wpvr_save_errors( ob_get_contents() );
		//wpvr_set_debug( ob_get_contents() , TRUE );
		flush_rewrite_rules();

		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	}

	/* Actions to be done on the DEactivation of WPVR */
	register_deactivation_hook( WPVR_MAIN_FILE , 'wpvr_deactivation' );
	function wpvr_deactivation() {
		wp_clear_scheduled_hook( 'wpvr_hourly_event' );
		flush_rewrite_rules();
		wpvr_save_errors( ob_get_contents() );
		//wpvr_set_debug( ob_get_contents() , TRUE );
	}

	/* Set Autoupdate Hook */
	add_action( 'init' , 'wpvr_activate_autoupdate' );
	function wpvr_activate_autoupdate() {
		global $wpvr_addons;

		//Check WPVR updates
		if( WPVR_CHECK_PLUGIN_UPDATES ) {
			new wpvr_autoupdate_product (
				WPVR_VERSION , // Current Version of the product (ex 1.7.0)
				WPVR_SLUG , // Product Plugin Slug (ex wpvr/wpvr.php')
				FALSE // Update zip url ? (ex TRUE or FALSE ),
			);
		}

		//Check for active addons updates
		if( WPVR_CHECK_ADDONS_UPDATES ) {
			$addons_obj = wpvr_get_addons( array() , FALSE );
			if( isset( $addons_obj[ 'items' ] ) && count( $addons_obj[ 'items' ] ) != 0 ) {
				foreach ( $addons_obj[ 'items' ] as $addon ) {
					//continue;
					if( ! isset( $wpvr_addons[ $addon->id ] ) ) {
						continue;
					}
					if( ! is_plugin_active( $addon->plugin_dir ) ) {
						continue;
					}
					$local_version = $wpvr_addons[ $addon->id ][ 'infos' ][ 'version' ];
					new wpvr_autoupdate_product (
						$local_version , // Current Version of the product (ex 1.7.0)
						$addon->plugin_dir , // Product Plugin Slug (ex wpvr/wpvr.php')
						FALSE // Update zip url ? (ex TRUE or FALSE ),
					);

				}
			}
		}

	}

	/* restricting Actions for demo user */
	if( WPVR_IS_DEMO_SITE === TRUE ) {
		add_action( 'admin_init' , 'wpvr_my_remove_menu_pages' );
		function wpvr_my_remove_menu_pages() {

			global $user_ID;

			if( $user_ID == WPVR_IS_DEMO_USER ) {
				define( 'DISALLOW_FILE_EDIT' , TRUE );
				remove_menu_page( 'plugins.php' );
				remove_menu_page( 'users.php' );
				remove_menu_page( 'tools.php' );
			}
		}
	}

	/* Add Manage Videos Link To Videos Admin Menu */
	add_action( 'admin_menu' , 'wpvr_add_manage_videos_link' );
	function wpvr_add_manage_videos_link() {
		add_submenu_page(
			'edit.php?post_type=' . WPVR_VIDEO_TYPE ,
			'VIDEOS' ,
			__( 'Manage Videos' , WPVR_LANG ) ,
			'manage_options' ,
			'wpvr_manage_videos' ,
			'wpvr_manage_videos_render'
		);
	}

	function wpvr_manage_videos_render() { include( 'wpvr.manage.php' ); }

	function wpvr_sandbox_render() {
		echo "<h2>WP VIDEO ROBOT SANDBOX</h2><br/><br/>";
		include( WPVR_PATH . 'wpvr.sandbox.php' );
	}


	/*Fix For pagination Category 1/2 */
	add_filter( 'request' , 'wpvr_remove_page_from_query_string' );
	function wpvr_remove_page_from_query_string( $query_string ) {
		if( isset( $query_string[ 'name' ] ) && $query_string[ 'name' ] == 'page' && isset( $query_string[ 'page' ] ) ) {
			unset( $query_string[ 'name' ] );
			// 'page' in the query_string looks like '/2', so i'm spliting it out
			list( $delim , $page_index ) = split( '/' , $query_string[ 'page' ] );
			$query_string[ 'paged' ] = $page_index;
		}

		return $query_string;
	}

	/*Fix For pagination Category 2/2 */
	add_filter( 'request' , 'wpvr_fix_category_pagination' );
	function wpvr_fix_category_pagination( $qs ) {
		if( isset( $qs[ 'category_name' ] ) && isset( $qs[ 'paged' ] ) ) {
			$qs[ 'post_type' ] = get_post_types( $args = array(
				'public'   => TRUE ,
				'_builtin' => FALSE ,
			) );
			array_push( $qs[ 'post_type' ] , 'post' );
		}

		return $qs;
	}


	add_filter( 'the_content' , 'wpvr_add_links' );
	function wpvr_add_links( $content ) { return make_clickable( $content ); }

	/* Add EG FIX content trick */
	add_action( 'the_content' , 'wpvr_eg_content_hook_fix' );
	function wpvr_eg_content_hook_fix( $content ) {
		if( WPVR_EG_FIX === TRUE ) {
			$content = preg_replace_callback( "/<iframe (.+?)<\/iframe>/" , function ( $matches ) {
				return str_replace( $matches[ 1 ] , '>' , $matches[ 0 ] );
			} , $content );
		}

		return $content;
	}

	add_filter( 'wp_head' , 'wpvr_watermark' , 10000 );
	function wpvr_watermark() {
		$act = wpvr_get_activation( 'wpvr' );
		//_d( $act );
		if( $act[ 'act_status' ] == 1 ) {
			$licensed = " - License activated by " . $act[ 'buy_user' ] . ".";
		} else {
			$licensed = " - Not Activated. ";
		}
		echo "\n <!-- ##WPVR : WP Video Robot version " . $act[ "act_version" ] . " " . $licensed . "--> \n";
	}

	add_action( 'wpvr_event_add_video_done' , 'wpvr_add_notice_trigger_function' , 10 , 1 );
	function wpvr_add_notice_trigger_function( $count_videos ) {
		if( WPVR_ASK_TO_RATE_TRIGGER === FALSE ) {
			return FALSE;
		}
		global $current_user;
		$user_id = $current_user->ID;

		//update_option('koko' , $count_videos );

		if( get_user_meta( $user_id , 'wpvr_user_has_voted' , TRUE ) == 1 ) {
			return FALSE;
		}
		$level_reached = wpvr_is_reaching_level( $count_videos );
		if( $level_reached != FALSE ) {
			$message = "<p class='wpvr_dialog_icon'><i class='fa fa-trophy'></i></p>" .
			           "<div class='wpvr_dialog_msg'>" .
			           "<p>Hey, you just have crossed <strong>$count_videos</strong> videos imported with WPVR. That's Awesome !</p>" .
			           "<p>Could you please do us a big favor and give WP Video Robot a 5-star rating on Codecanyon ?" .
			           "<br/>That will help us spread the word and boost our motivation.</p>" .
			           "<strong>~pressaholic</strong>" .
			           "</div>";

			$token = bin2hex( openssl_random_pseudo_bytes( 16 ) );

			/*$wpvr_notices = get_option('wpvr_notices');
			foreach( $wpvr_notices as $id=>$notice){
				if( strpos($id , 'rating_notice_' ) != false )  unset( $wpvr_notices[ $id ] );
			}
			update_option('wpvr_notices' , $wpvr_notices);
			*/


			wpvr_add_notice( array(
				'slug'               => "rating_notice_" . $level_reached ,
				'title'              => 'Congratulations !' ,
				'class'              => 'updated' , //updated or warning or error
				'content'            => $message ,
				'hidable'            => TRUE ,
				'is_dialog'          => TRUE ,
				'dialog_modal'       => FALSE ,
				'dialog_delay'       => 1500 ,
				//'dialog_ok_button' => '',
				'dialog_ok_button'   => ' <i class="fa fa-heart"></i> RATE WPVR NOW' ,
				'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS ' ,
				'dialog_class'       => ' askToRate ' ,
				'dialog_ok_url'      => 'http://codecanyon.net/downloads#item-8619739' ,
			) );

		}

	}


	add_action( 'plugins_loaded' , 'wpvr_load_addons_activation_hooks' , 5 );
	function wpvr_load_addons_activation_hooks() {
		$x           = explode( 'wpvr' , WPVR_MAIN_FILE );
		$plugins_dir = $x[ 0 ];

		$addons_obj = wpvr_get_addons( array() , FALSE );
		if( isset( $addons_obj[ 'items' ] ) && count( $addons_obj[ 'items' ] ) != 0 ) {
			foreach ( $addons_obj[ 'items' ] as $addon ) {
				//continue;


				$addon_main_file = $plugins_dir . str_replace( '/' , "\\" , $addon->plugin_dir );

				//if( ! is_plugin_active( $addon->plugin_dir ) ) continue;
				//wpvr_set_debug( $addon_main_file , true );
				//wpvr_set_debug( $addon , true );
				register_activation_hook(
					$addon_main_file ,
					function () use ( $addon ) {
						wpvr_start_plugin( $addon->id , $addon->version , FALSE );
					}
				);
				//break;
				//register_activation_hook( $addon->plugin_dir , $addon->id . '_activation' );
				//function wpvr_activation() {
			}
		}
	}

	add_filter( 'custom_menu_order' , 'wpvr_reorder_addons_submenu' );
	function wpvr_reorder_addons_submenu( $menu_ord ) {
		global $submenu;
		$a = $b = $c = array();
		if( ! isset( $submenu[ 'wpvr-addons' ] ) ) {
			return $menu_ord;
		}

		foreach ( (array) $submenu[ 'wpvr-addons' ] as $link ) {
			if( $link[ 2 ] == 'wpvr-addons' ) {
				$a[] = $link;
			} elseif( strpos( $link[ 0 ] , '+' ) != FALSE ) {
				$a[] = $link;
			} else {
				$b[] = $link;
			}
		}
		$submenu[ 'wpvr-addons' ] = array_merge( $a , $b );

		return $menu_ord;
	}

	add_action( 'add_meta_boxes' , 'wpvr_update_cpt_meta_boxes' , 1000 );
	function wpvr_update_cpt_meta_boxes() {
		global $wp_meta_boxes , $wpvr_getmb_unsupported_themes;

		//d( $_GET );

		$theme = wp_get_theme(); // gets the current theme
		if( $theme->parent_theme == '' ) $theme_name = $theme->name;
		else $theme_name = $theme->parent_theme;


		if( in_array( $theme_name , $wpvr_getmb_unsupported_themes ) ) return FALSE;
		//d( $theme_name );


		//if( isset( $_GET[ 'wpvr_reset_mb' ] ) && $_GET[ 'wpvr_reset_mb' ] == '1' ) $wpvr_mb = array();
		if( isset( $_GET[ 'wpvr_clear_mb' ] ) && $_GET[ 'wpvr_clear_mb' ] == 1 ) {
			update_option( 'wpvr_mb' , array() );

			return FALSE;
		}
		if( ! isset( $_GET[ 'wpvr_get_mb' ] ) || $_GET[ 'wpvr_get_mb' ] != 1 ) return FALSE;
		//d( $_GET );

		$wpvr_mb = get_option( 'wpvr_mb' );
		if( $wpvr_mb == '' ) $wpvr_mb = array();
		if( isset( $_GET[ 'wpvr_reset_mb' ] ) && $_GET[ 'wpvr_reset_mb' ] == 1 ) $wpvr_mb = array();

		//if( isset( $wpvr_mb[ $theme_name ] ) ) return FALSE;
		$wpvr_mb[ $theme_name ] = array(
			'theme'  => $theme ,
			'normal' => array() ,
			'side'   => array() ,
		);

		$mb_post_types = apply_filters( 'wpvr_extend_mb_post_types' , array( 'post' ) );


		foreach ( (array) $mb_post_types as $post_type ) {

			//d( $post_type );
			if( !isset($wp_meta_boxes[ $post_type ]) ) continue;
			//Cloning Normal metaboxes
			foreach ( (array) $wp_meta_boxes[ $post_type ][ 'normal' ] as $level => $mbs ) {
				//d( $mbs );
				foreach ( (array) $mbs as $mb ) {

					$mb[ 'level' ] = $level;

					$wpvr_mb[ $theme_name ][ 'normal' ][ $mb[ 'id' ] ] = $mb;
				}
			}
			//Cloning Side metaboxes
			foreach ( (array) $wp_meta_boxes[ $post_type ][ 'side' ] as $level => $mbs ) {
				//d( $mbs );
				foreach ( (array) $mbs as $mb ) {
					$mb[ 'level' ] = $level;

					$wpvr_mb[ $theme_name ][ 'side' ][ $mb[ 'id' ] ] = $mb;
				}
			}
		}
		//d( $wpvr_mb );
		update_option( 'wpvr_mb' , $wpvr_mb );

		$msg  = __( 'New Theme Metaboxes detected and added.' , WPVR_LANG ) . '<br/>' .
		        __( 'You can now handle your imported videos as any regular Wordpress post.' ) . '<br/><br/>' .
		        '<a id="wpvr_get_mb_close" href="#">' . __( 'Close' , WPVR_LANG ) . '</a>';
		$slug = wpvr_add_notice( array(
			'title'     => 'WP Video Robot : ' ,
			'class'     => 'updated' , //updated or warning or error
			'content'   => $msg ,
			'hidable'   => FALSE ,
			'is_dialog' => FALSE ,
			'show_once' => TRUE ,
			'color'     => '#27A1CA' ,
			'icon'      => 'fa-cube' ,
		) );
		wpvr_render_notice( $slug );
		wpvr_remove_notice( $slug );

		?>
		<style>
			#poststuff {
				display: none;
			}

			.wrap h1 {
				visibility: hidden;
			}
		</style>
		<?php


	}


	add_action( 'add_meta_boxes' , 'wpvr_adapt_cpt_meta_boxes' , 1000 );
	function wpvr_adapt_cpt_meta_boxes() {

		global $wp_meta_boxes , $post;
		$wpvr_mb = get_option( 'wpvr_mb' );
		if( $wpvr_mb == '' || $wpvr_mb == array() ) return FALSE;
		if( $post->post_type != WPVR_VIDEO_TYPE ) return FALSE;

		$theme = wp_get_theme(); // gets the current theme
		if( $theme->parent_theme == '' ) $theme_name = $theme->name;
		else $theme_name = $theme->parent_theme;
		if( ! isset( $wpvr_mb[ $theme_name ] ) ) return FALSE;
		$mbs = $wpvr_mb[ $theme_name ];

		foreach ( (array) $mbs[ 'side' ] as $id => $mb ) {
			$wp_meta_boxes[ WPVR_VIDEO_TYPE ][ 'side' ][ $mb[ 'level' ] ][ $mb[ 'id' ] ] = $mb;
		}

		foreach ( (array) $mbs[ 'normal' ] as $id => $mb ) {
			$wp_meta_boxes[ WPVR_VIDEO_TYPE ][ 'normal' ][ $mb[ 'level' ] ][ $mb[ 'id' ] ] = $mb;
		}
	}


	add_action( 'wp_trash_post' , 'wpvr_add_unwanted_on_trash' );
	function wpvr_add_unwanted_on_trash( $post_id ) {
		global $wpvr_options;
		if( get_post_type( $post_id ) == WPVR_VIDEO_TYPE && $wpvr_options[ 'unwantOnTrash' ] === TRUE ) {
			wpvr_unwant_videos( array( $post_id ) );
		}
	}

	add_action( 'before_delete_post' , 'wpvr_add_unwanted_on_delete' );
	function wpvr_add_unwanted_on_delete( $post_id ) {
		global $wpvr_options;
		if( get_post_type( $post_id ) == WPVR_VIDEO_TYPE && $wpvr_options[ 'unwantOnDelete' ] === TRUE ) {
			wpvr_unwant_videos( array( $post_id ) );
		}
	}
