<?php
	if( ! class_exists( 'wpvr_Custom_Bulk_Action' ) ) {

		class wpvr_Custom_Bulk_Action {
			public function __construct() {
				if( is_admin() ) {
					/* Hooking the bulk functions */
					add_action( 'admin_footer-edit.php' , array( &$this , 'wpvr_custom_bulk_create_menus' ) );
					add_action( 'load-edit.php' , array( &$this , 'wpvr_custom_bulk_handle_actions' ) );
					add_action( 'admin_notices' , array( &$this , 'wpvr_custom_bulk_admin_notice_links' ) );
				}
			}
			
			function wpvr_custom_bulk_create_menus() {
				global $post_type;
				global $post_status;
				if( $post_type == WPVR_SOURCE_TYPE ) {
					?>
					<script type = "text/javascript">
						jQuery(document).ready(function () {
							
							// jQuery('<option>').val('delete').text('<?php _e( 'Delete permanently' , WPVR_LANG )?>').appendTo("select[name='action']");
							// jQuery('<option>').val('delete').text('<?php _e( 'Delete permanently' , WPVR_LANG )?>').appendTo("select[name='action2']");
							
							
							<?php if($post_status != 'trash'){ ?>
							
							
							jQuery('<option>').val('toggleON').text('<?php _e( 'Toggle ON source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('toggleON').text('<?php _e( 'Toggle ON source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");

							jQuery('<option>').val('toggleOFF').text('<?php _e( 'Toggle OFF source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('toggleOFF').text('<?php _e( 'Toggle OFF source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");
							
							jQuery('<option>').val('test').text('<?php _e( 'Test source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('test').text('<?php _e( 'Test source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");

							jQuery('<option>').val('run').text('<?php _e( 'Run source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('run').text('<?php _e( 'Run source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");

							jQuery('<option>').val('duplicate').text('<?php _e( 'Duplicate source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('duplicate').text('<?php _e( 'Duplicate source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");


							jQuery('<option>').val('export').text('<?php _e( 'Export source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('export').text('<?php _e( 'Export source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");
							
							<?php } ?>
							
							//jQuery('<option>').val('exportAll').text('<?php _e( 'Export all source(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							//jQuery('<option>').val('exportAll').text('<?php _e( 'Export all source(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");
						});
					</script>
					<?php
				} elseif( $post_type == WPVR_VIDEO_TYPE ) {
					?>
					<script type = "text/javascript">
						jQuery(document).ready(function () {
							<?php if($post_status != 'trash'){ ?>
							jQuery('<option>').val('delete').text('<?php _e( 'Delete permanently' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('delete').text('<?php _e( 'Delete permanently' , WPVR_LANG )?>').appendTo("select[name='action2']");
							<?php } ?>
							<?php if($post_status != 'publish'){ ?>
							jQuery('<option>').val('publish').text('<?php _e( 'Publish video(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('publish').text('<?php _e( 'Publish video(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");
							<?php } ?>

							jQuery('<option>').val('unwant').text('<?php _e( 'Add to Unwanted' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('unwant').text('<?php _e( 'Add to Unwanted' , WPVR_LANG )?>').appendTo("select[name='action2']");

							jQuery('<option>').val('undo_unwant').text('<?php _e( 'Remove from Unwanted' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('undo_unwant').text('<?php _e( 'Remove from Unwanted' , WPVR_LANG )?>').appendTo("select[name='action2']");

							jQuery('<option>').val('autoembed').text('<?php _e( 'Enable AutoEmbed' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('autoembed').text('<?php _e( 'Enable AutoEmbed' , WPVR_LANG )?>').appendTo("select[name='action2']");

							jQuery('<option>').val('undo_autoembed').text('<?php _e( 'Disable AutoEmbed' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('undo_autoembed').text('<?php _e( 'Disable AutoEmbed' , WPVR_LANG )?>').appendTo("select[name='action2']");


							jQuery('<option>').val('export').text('<?php _e( 'Export video(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							jQuery('<option>').val('export').text('<?php _e( 'Export video(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");

							//jQuery('<option>').val('exportAll').text('<?php _e( 'Export all video(s)' , WPVR_LANG )?>').appendTo("select[name='action']");
							//jQuery('<option>').val('exportAll').text('<?php _e( 'Export all video(s)' , WPVR_LANG )?>').appendTo("select[name='action2']");
						});
					</script>
					<?php
				}
			}
			
			
			/* handle the custom Bulk Action */
			function wpvr_custom_bulk_handle_actions() {
				global $typenow;
				$post_type = $typenow;
				
				if( $post_type == WPVR_SOURCE_TYPE ) {
					// get the action
					$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
					$action        = $wp_list_table->current_action();
					
					$allowed_actions = array( 
						'test' , 
						'run' , 
						'duplicate' , 
						'toggleON' , 
						'toggleOFF' , 
						'export' , 
						'delete' , 
						'exportAll' 
					);
					if( ! in_array( $action , $allowed_actions ) ) return;
					
					// security check
					check_admin_referer( 'bulk-posts' );
					
					// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
					if( isset( $_REQUEST[ 'post' ] ) ) $post_ids = array_map( 'intval' , $_REQUEST[ 'post' ] );
					
					if( empty( $post_ids ) ) return;
					
					// this is based on wp-admin/edit.php
					$sendback = remove_query_arg( array( 'exported' , 'untrashed' , 'deleted' , 'ids' ) , wp_get_referer() );
					if( ! $sendback )
						$sendback = admin_url( "edit.php?post_type=$post_type" );
					
					$pagenum  = $wp_list_table->get_pagenum();
					$sendback = esc_url( add_query_arg( 'paged' , $pagenum , $sendback ) );
					
					switch ( $action ) {
						case 'toggle':
							if( ! $this->wpvr_perform_toggle( $post_ids ) )
								wp_die( __( 'Error toggling post.' , WPVR_LANG ) );
							break;
							
						case 'toggleON':
							if( ! $this->wpvr_perform_toggle( $post_ids , TRUE ) )
								wp_die( __( 'Error toggling post.' , WPVR_LANG ) );
							break;
							
						case 'toggleOFF':
							if( ! $this->wpvr_perform_toggle( $post_ids , FALSE ) )
								wp_die( __( 'Error toggling post.' , WPVR_LANG ) );
							break;

						case 'delete':
							$count_selected = count( $post_ids );
							if( ! $this->wpvr_delete_sources_permanently( $post_ids ) )
								wp_die( __( 'Error deleting post.' , WPVR_LANG ) );
							break;

						case 'duplicate':
							foreach ( $post_ids as $id ) {
								wpvr_duplicate_source( $id );
							}
							break;

						case 'test':
							$sendback = esc_url( add_query_arg( array( 'bulk_action' => 'test' , 'ids' => join( ',' , $post_ids ) ) , $sendback ) );
							break;
						case 'run':
							$sendback = esc_url( add_query_arg( array( 'bulk_action' => 'run' , 'ids' => join( ',' , $post_ids ) ) , $sendback ) );
							break;
						case 'export':
							$sendback = esc_url( add_query_arg( array( 'bulk_action' => 'export' , 'ids' => join( ',' , $post_ids ) ) , $sendback ) );
							break;
						case 'exportAll':
							$sendback = esc_url( add_query_arg( array( 'bulk_action' => 'exportAll' , ) , $sendback ) );
							break;

						default:
							return;
					}
					
					$sendback = remove_query_arg( array(
						'action' ,
						'action2' ,
						'tags_input' ,
						'post_author' ,
						'comment_status' ,
						'ping_status' ,
						'_status' ,
						'post' ,
						'bulk_edit' ,
						'post_view' ,
					) , $sendback );
					$sendback = str_replace( '#038;' , '' , $sendback );
					if( $action == 'test' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&test_sources&ids=' . join( ',' , $post_ids ) , 'http' );
						wp_redirect( $testLink );
					} elseif( $action == 'run' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&run_sources&ids=' . join( ',' , $post_ids ) , 'http' );
						wp_redirect( $testLink );

					} elseif( $action == 'export' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&export_sources&ids=' . join( ',' , $post_ids ) , 'http' );
						wp_redirect( $testLink );
					} elseif( $action == 'exportAll' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&export_all_sources' , 'http' );
						wp_redirect( $testLink );

					} else {
						wp_redirect( $sendback );
					}
					exit();
				} elseif( $post_type == WPVR_VIDEO_TYPE ) {
					
					// get the action
					$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
					$action        = $wp_list_table->current_action();
					
					$allowed_actions = array(
						'export' ,
						'delete' ,
						'unwant' ,
						'undo_unwant' ,
						'publish' ,
						'exportAll',
						'autoembed',
						'undo_autoembed',
					);
					if( ! in_array( $action , $allowed_actions ) ) return;
					
					// security check
					check_admin_referer( 'bulk-posts' );
					
					// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
					if( isset( $_REQUEST[ 'post' ] ) ) {
						$post_ids = array_map( 'intval' , $_REQUEST[ 'post' ] );
					}
					
					if( empty( $post_ids ) ) return;
					
					// this is based on wp-admin/edit.php
					$sendback = remove_query_arg( array( 'exported' , 'untrashed' , 'deleted' , 'ids' ) , wp_get_referer() );

					if( ! $sendback )
						$sendback = admin_url( "edit.php?post_type=$post_type" );
					
					$pagenum  = $wp_list_table->get_pagenum();
					$sendback = esc_url( add_query_arg( 'paged' , $pagenum , $sendback ) );
					
					switch ( $action ) {

						case 'export':
							$sendback = esc_url( add_query_arg( array( 'bulk_action' => 'export' , 'ids' => join( ',' , $post_ids ) ) , $sendback ) );
							break;
						case 'exportAll':
							$sendback = esc_url( add_query_arg( array( 'bulk_action' => 'export' , ) , $sendback ) );
							break;

						case 'publish':
							$count_selected = count( $post_ids );
							if( ! $this->wpvr_bulk_publish_videos( $post_ids ) )
								wp_die( __( 'Error publishing post.' , WPVR_LANG ) );
							break;

						case 'delete':
							$count_selected = count( $post_ids );
							if( ! $this->wpvr_delete_videos_permanently( $post_ids ) )
								wp_die( __( 'Error deleting post.' , WPVR_LANG ) );
							break;

						case 'unwant':
							$count_selected = count( $post_ids );
							if( ! $this->wpvr_unwant_videos( $post_ids ) )
								wp_die( __( 'Error unwanting post.' , WPVR_LANG ) );
							break;

						case 'autoembed':
							$count_selected = count( $post_ids );
							if( ! $this->wpvr_bulk_update_meta_videos( $post_ids , 'wpvr_video_disableAutoEmbed' , 'off') )
								wp_die( __( 'Error Enabling Autoembed on video.' , WPVR_LANG ) );
							break;

						case 'undo_autoembed':
							if( ! $this->wpvr_bulk_update_meta_videos( $post_ids , 'wpvr_video_disableAutoEmbed' , 'on') )
								wp_die( __( 'Error Enabling Autoembed on video.' , WPVR_LANG ) );
							break;

						case 'undo_unwant':
							$count_selected = count( $post_ids );
							if( ! $this->wpvr_undo_unwant_videos( $post_ids ) )
								wp_die( __( 'Error undo unwanting post.' , WPVR_LANG ) );
							break;

						default:
							break;
					}
					$sendback = str_replace( '#038;' , '' , $sendback );
					$sendback = remove_query_arg( array(
						'action' ,
						'action2' ,
						'tags_input' ,
						'post_author' ,
						'comment_status' ,
						'ping_status' ,
						'_status' ,
						'post' ,
						'bulk_edit' ,
						'post_view' ,
					) , $sendback );

					
					if( $action == 'test' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&test_sources&ids=' . join( ',' , $post_ids ) , 'http' );
						wp_redirect( $testLink );
					} elseif( $action == 'run' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&run_sources&ids=' . join( ',' , $post_ids ) , 'http' );
						wp_redirect( $testLink );
					} elseif( $action == 'export' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&export_videos&ids=' . join( ',' , $post_ids ) , 'http' );
						echo $testLink;
						wp_redirect( $testLink );
						
					} elseif( $action == 'exportAll' ) {
						$testLink = admin_url( 'admin.php?page=wpvr&axport_all_videos' , 'http' );
						wp_redirect( $testLink );

					} else {
						wp_redirect( $sendback );
					}
					exit();
				}
			}
			
			/*Display admin Notices */
			function wpvr_custom_bulk_admin_notice_links() {
				global $post_type , $pagenow;
				if( $pagenow == 'edit.php' && $post_type == WPVR_SOURCE_TYPE && isset( $_REQUEST[ 'ids' ] ) && isset( $_REQUEST[ 'bulk_action' ] ) ) {
					$testLink = admin_url( 'admin.php?page=wpvr&test_sources&ids=' . $_REQUEST[ 'ids' ] , 'http' );
					$runLink  = admin_url( 'admin.php?page=wpvr&run_sources&ids=' . $_REQUEST[ 'ids' ] , 'http' );
					if( $_REQUEST[ 'bulk_action' ] == "test" ) $link = $testLink;
					elseif( $_REQUEST[ 'bulk_action' ] == "run" ) $link = $runLink;
					else return FALSE;
					?>
					<script>
						window.open('<?php echo $link; ?>');
					</script>
					<?php
				}
			}
			
			/*Perform Bulk Toggling Method */
			function wpvr_perform_toggle( $source_ids , $status = TRUE ) {
				if( count( $source_ids ) == 0 ) return;
				// $status = get_post_meta( $source_ids[ 0 ] , 'wpvr_source_status' , TRUE );
				if( $status === FALSE ) $newStatus = "off";
				else $newStatus = "on";
				$k = 0;
				foreach ( $source_ids as $id ) {
					update_post_meta( $id , 'wpvr_source_status' , $newStatus );
					$k ++;
				}
				wpvr_render_done_notice_redirect( '<strong>' . $k . '</strong> Sources toggled.' , TRUE );

				return TRUE;
			}
			
			function wpvr_delete_sources_permanently( $source_ids ) {
				if( count( $source_ids ) == 0 ) return;
				$k = 0;
				foreach ( $source_ids as $id ) {
					wp_delete_post( $id , TRUE );
					$k ++;
				}
				wpvr_render_done_notice_redirect( '<strong>' . $k . '</strong> Sources deleted permanently.' , TRUE );

				return TRUE;
			}
			
			function wpvr_delete_videos_permanently( $source_ids ) {
				$wpvr_imported = get_option( 'wpvr_imported' );
				if( count( $source_ids ) == 0 ) return;
				$k = 0;
				foreach ( $source_ids as $id ) {
					$video_id      = get_post_meta( $id , 'wpvr_video_id' , TRUE );
					$video_service = get_post_meta( $id , 'wpvr_video_service' , TRUE );
					wp_delete_post( $id , TRUE );
					unset( $wpvr_imported[ $video_service ][ $video_id ] );
					$k ++;
				}
				update_option( 'wpvr_imported' , $wpvr_imported );
				wpvr_render_done_notice_redirect( '<strong>' . $k . '</strong> Videos deleted permanently.' , TRUE );

				return TRUE;
			}

			function wpvr_bulk_update_meta_videos( $post_ids , $meta_key , $meta_value ) {

				//$meta_key = 'wpvr_video_disableAutoEmbed';
				$i = 0 ;
				foreach( (array) $post_ids as $post_id ){
					$done = update_post_meta( $post_id , $meta_key , $meta_value );
					if( $done != FALSE ) $i++;
				}

				//wpvr_unwant_videos( $post_ids );
				wpvr_render_done_notice_redirect( '<strong>' . $i . '</strong> Videos processed.' , TRUE );

				return TRUE;
			}

			function wpvr_unwant_videos( $post_ids ) {
				wpvr_unwant_videos( $post_ids );
				wpvr_render_done_notice_redirect( '<strong>' . count( $post_ids ) . '</strong> Videos added to Unwanted.' , TRUE );

				return TRUE;
			}

			function wpvr_undo_unwant_videos( $post_ids ) {
				wpvr_undo_unwant_videos( $post_ids );
				wpvr_render_done_notice_redirect( '<strong>' . count( $post_ids ) . '</strong> Videos removed from Unwanted.' , TRUE );

				return TRUE;
			}

			function wpvr_bulk_publish_videos( $source_ids ) {
				if( count( $source_ids ) == 0 ) return;
				$k = 0;
				foreach ( $source_ids as $id ) {
					wp_update_post( array( 'ID' => $id , 'post_status' => 'publish' ) );
					$k ++;
				}
				wpvr_render_done_notice_redirect( '<strong>' . $k . '</strong> Videos Published.' , TRUE );

				return TRUE;
			}
			

		}
	}

	new wpvr_Custom_Bulk_Action();