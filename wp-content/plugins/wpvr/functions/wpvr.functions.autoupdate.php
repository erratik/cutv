<?php
	define( 'WPVR_UPDATE_DEBUG' , FALSE );
	
	class wpvr_autoupdate_product
	{
		public $current_version;
		public $new_version;
		public $plugin_slug;
		public $slug;
		public $update_zip_url;

		function __construct( $current_version , $plugin_slug , $update_zip_url ) {

			$this->current_version = $current_version;
			$this->update_zip_url  = $update_zip_url;
			$this->plugin_slug     = $plugin_slug;

			list ( $t1 , $t2 ) = explode( '/' , $plugin_slug );
			$this->slug = str_replace( '.php' , '' , $t2 );

			// define the alternative API for updating checking
			add_filter( 'pre_set_site_transient_update_plugins' , array( &$this , 'check_update' ) );
			add_filter( 'upgrader_post_install' , array( &$this , 'remove_update_notification' ) , 10 , 3 );

			// Define the alternative response for information checking
			add_filter( 'plugins_api' , array( &$this , 'check_info' ) , 10 , 3 );

			//d( $this );

		}

		public function remove_update_notification( $true, $hook_extra, $result ) {
			//return $result;
			global $current_user;
			$plugin_slug = $this->plugin_slug ;
			$v = $this->get_remote_version();
			if( ! property_exists( $v , 'version' ) ) $new_version = $this->current_version ;
			else $new_version = $v->version;
			$notice_slug = '_wpvr_update_' .$this->slug . '_' . $new_version;
			if ( isset( $hook_extra ) ) {
				if ( isset( $hook_extra['plugin'] ) && $hook_extra['plugin'] == $plugin_slug ){
					add_user_meta( $current_user->ID , $notice_slug , 'true' , TRUE );
				}
			}
			return $result;
		}


		public function check_update( $transient ) {
			global $wpvr_new_version_available , $updates_notices;

			if( empty( $transient->checked ) ) {
				//echo "empty transient";
				//return $transient;
			}

			if( ! is_plugin_active( $this->plugin_slug ) ) {
				return $transient;
			}


			$v = $this->get_remote_version();

			if( $v === false ) return $transient ;

			if( ! property_exists( $v , 'version' ) ) return $transient;

			$remote_version = $v->version;
			//$check = $this->slug . ' : '. $this->current_version . ' / ' . $remote_version ;
			//d( $check );

			if( version_compare( $this->current_version , $remote_version , '<' ) ) {

				$act = wpvr_get_activation( $this->slug );
				if( $act['act_status'] == 1 ){
					$download_url = $this->get_remote_download( $remote_version );
					//_d( $download_url );
				}else{
					$download_url = '#' ;
				}



				$obj              = new stdClass();
				$obj->slug        = $this->slug;
				$obj->new_version = $remote_version;
				$obj->url         = WPVR_API_REQ_URL;
				$obj->package     = $download_url;

				//d( $obj );
				$transient->response[ $this->plugin_slug ] = $obj;

				$wpvr_new_version_available = $remote_version;
				if( !isset( $_GET['action'] ) || $_GET['action'] != 'do-plugin-upgrade' ) {
					wpvr_capi_show_update_message( array(
						'name'          => $v->name ,
						'slug'          => $v->wp_slug ,
						'version'       => $v->version ,
						'date'          => $v->date ,
						'local_version' => $this->current_version ,
						'act'           => $act[ 'act_status' ] ,
					) );
					//d( array('NOTICE ADDED' ) );
				}
			}
			return $transient;
		}

		public function get_remote_version() {
			$api = wpvr_capi_release_get_full_version( $this->slug );

			if( $api[ 'status' ] == '1' ) {
				return $api[ 'data' ][ $this->slug ];
			} else {
				//echo $api[ 'msg' ];
				return FALSE;
			}
		}

		public function get_remote_download( $version ) {
			global $wpvr_new_version_msg;
			$wpvr_new_version_msg = '';

			$act = wpvr_get_activation( $this->slug );
			//d( $act );
			if( $act[ 'act_status' ] != '1' || $act[ 'act_code' ] == '' ) {
				return FALSE;
			}
			$api = wpvr_capi_get_download(
				$this->slug ,
				$act[ 'act_code' ] ,
				$version
			);



			if( $api[ 'status' ] == '1' ) {
				return $api[ 'data' ];
			} else {
				//echo $api[ 'msg' ];
				return FALSE;
			}
		}

		public function check_info( $false , $action , $arg ) {
			//return false;
			if( property_exists( $arg , 'slug' ) && $arg->slug === $this->slug ) {
				return $this->get_remote_information();
			}
			return FALSE;
		}

		public function get_remote_information() {

			$api = wpvr_capi_release_get_info( $this->slug );
			if( $api[ 'status' ] == '1' ) {
				return unserialize( $api[ 'data' ][ $this->slug ] );
			} else {
				//echo $api[ 'msg' ];
				return FALSE;
			}
		}

		public function get_remote_licence() {

			$api = wpvr_capi_release_get_full_version( $this->slug );
			if( $api[ 'status' ] == '1' ) {
				return $api[ 'data' ][ $this->slug ][ 'wp_licence' ];
			} else {
				//echo $api[ 'msg' ];
				return FALSE;
			}
		}

	}