<?php
/*
* Template Name: Submit a video
*/
get_header();
$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-image' );

if ( LAYOUT == 'sidebar-no' ) {
	$span_size = 'span10';
} else {
	$span_size = '';
}

$vh_new_videos_drafts = get_option('vh_new_videos_drafts');
if($vh_new_videos_drafts == false) {
	$vh_new_videos_drafts = 'false';
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?>
<div class="page-<?php echo LAYOUT; ?> page-wrapper">
	<div class="clearfix"></div>
	<div class="content vc_row wpb_row vc_row-fluid">
		<?php
		wp_reset_postdata();
		if (LAYOUT == 'sidebar-no' || 'sidebar-right' ) {
			$side_menu_style = get_option('vh_side_menu_style') ? get_option('vh_side_menu_style') : '';
		?>
			<div class="vc_col-sm-2 sidebar_menu <?php echo $side_menu_style; ?>">
				<div class="side_menu_seperator"></div>
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary-menu',
							'menu_class'      => 'primary-menu',
							'container'       => 'div',
							'container_class' => '',
							'depth'           => 2,
							'link_before'     => '',
							'link_after'      => '',
							'walker'          => new description_walker()
						)
					);
				?>
			</div><!--end of sidebars-->
		<?php } ?>
		<div class="<?php echo LAYOUT; ?>-pull">
			<div class="main-content <?php echo (LAYOUT != 'sidebar-no') ? 'vc_col-sm-7' : 'vc_col-sm-10'; ?>">
				<?php
				if ( !is_front_page() && !is_home() ) { ?>
					<div class="page-title">
						<?php echo  the_title( '<h1>', '</h1>' ); ?>
					</div>
				<?php } ?>
				<?php
				if ( !is_front_page() && !is_home() ) {
					echo vh_breadcrumbs();
				}
				if ( is_plugin_active('contus-video-gallery/hdflvvideoshare.php') ) {
					include_once ($adminControllerPath . 'ajaxplaylistController.php');
					include_once SBP_DIR . '/lib/functions/videosController.php';
				}
				global $user_level;

				if ( isset($img[0]) ) { ?>
					<div class="entry-image">
						<img src="<?php echo $img[0]; ?>" class="open_entry_image <?php echo $span_size; ?>" alt="" />
					</div>
				<?php } ?>
				<div class="main-inner">
					<?php
					if (have_posts ()) {
						while (have_posts()) {
							the_post();
							the_content();
						}
					} else {
						echo '
							<h2>Nothing Found</h2>
							<p>Sorry, it appears there is no content in this section.</p>';
					}

					if ( !is_plugin_active('contus-video-gallery/hdflvvideoshare.php') ) {
						echo '<p>' . __('This plugin is add-on for WordPress Video Gallery plugin, please install and activate it before you can use this one. You can get it here ', 'vh') . '<a href="https://wordpress.org/plugins/contus-video-gallery/" target="_blank">WordPress Video Gallery</a></p>';
					
					} else if ( is_user_logged_in() == true ) {
						$emptyImage         = getImagesDirURL() .'empty.gif';
						// $adminPage = filter_input( INPUT_GET, 'page' );
						// $videoId   = filter_input( INPUT_GET, 'videoId' );
						// if ( $adminPage == 'newvideo' && ! empty( $videoId ) ) {
						// 	$editbutton = 'Update';
						// 	$page_title = 'Edit video';
						// } else {
						// 	$editbutton = 'Save';
						// 	$page_title = 'Add a new video';
						// }
						
						// function get_current_user_role() {
						// 	global $current_user;
						// 	get_currentuserinfo();
						// 	$user_roles = $current_user->roles;
						// 	$user_role  = array_shift( $user_roles );
						// 	return $user_role;
						// }
						// $user_role = get_current_user_role();
						
						// $user_allowed_method = explode(',',$player_colors['user_allowed_method']);
					  ?>
						<div class="submit_video_container">
							<div class="submit_video_info">
								<div class="vc_message_box vc_message_box-classic vc_message_box-rounded vc_color-alert-success" id="submit_success" style="display: none;">
									<div class="messagebox_text"></div>
								</div>
								<form name="table_options" enctype="multipart/form-data" method="post" id="video_options" action="">
									<div>
										<div class="vc_col-sm-9">
											<div class="add-video-selection">
												<?php $video_settings = get_submit_video_settings(); ?>
												<?php if ( in_array('c', $video_settings) ) { ?>
													<span><input type="radio" name="agree" id="btn2" value="c" checked /> <?php esc_attr_e( 'YouTube URL / Viddler / Dailymotion', 'video_gallery' ); ?></span>
												<?php } ?>
												<?php if ( in_array('y', $video_settings) ) { ?>
													<span><input type="radio" name="agree" id="btn1" value="y" /> <?php esc_attr_e( 'Upload file', 'video_gallery' ); ?></span>
												<?php } ?>
												<?php if(in_array('url', $video_settings) ) { ?> 
													<span><input type="radio" class="post-format" name="agree" value="url" id="btn3" /> <?php esc_attr_e( 'Custom URL', 'video_gallery' ); ?></span> 
												<?php } ?>
												<?php if(in_array('rmtp', $video_settings) ){ ?> 
													<span><input type="radio" id="btn4" class="post-format" name="agree" value="rtmp" /> <?php esc_attr_e( 'RTMP', 'video_gallery' ); ?></span> 
												<?php } ?>
											</div>
											<form action="">
												<div id="youtube" class="rtmp_inside inside">
													<?php esc_attr_e( 'Video URL', 'video_gallery' ) ?>
													<div class="clearfix"></div>
													<input type="text" size="50" name="filepath" value="<?php
													if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 1 ) {
														echo balanceTags( $videoEdit->link );
													}
													?>" id="filepath1" />
													<input id="generate" type="submit" name="youtube_media" class="button-primary wpb_button wpb_btn-success wpb_regularsize generate_youtube_details" value="<?php esc_attr_e( 'Generate details', 'video_gallery' ); ?>" onClick="return getyoutube_details();" />
													<div id="loading_image" align="center" style="display:none;"><img src="<?php echo getImagesDirURL().'ajax-loader.gif';?>" /><div class="clearfix"></div></div>
													<div class="clearfix"></div>
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="urlareadyexists" style="display: none;"></div>
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="Youtubeurlmessage" style="display: none;"></div>
												</div>
											</form>
											<?php
												global $wpdb;
												$settings_result = $wpdb->get_var ( "SELECT player_colors FROM " . $wpdb->prefix . "hdflvvideoshare_settings WHERE settings_id='1'" );
												$setting_youtube = unserialize( $settings_result );
												isset( $setting_youtube['youtube_key'] ) ? $youtube_key = $setting_youtube['youtube_key'] : $youtube_key = '';
											?>
											<script type="text/javascript">
														<?php if ( !in_array('c', $video_settings) ) { ?>
															jQuery(document).ready(function() {
																jQuery('#btn1').click();
																jQuery('#upload2').slideDown();
																jQuery('#youtube').slideUp();
																jQuery('#filetypevalue').val('2');
															});
														<?php } ?>
														function getyoutube_details(){
															var youtube_url =  document.getElementById("filepath1").value;
															if(youtube_url.indexOf('youtube') != -1) {
																var video_id = youtube_url.split('v=')[1];
																var ampersandPosition = video_id.indexOf('&');
																if(ampersandPosition != -1) {
																	video_id = video_id.substring(0, ampersandPosition);
																}
															} else if(youtube_url.indexOf('youtu.be') != -1) {
																var video_id = youtube_url.split('/')[3];
															}
															var urlmatch = /(http:\/\/|https:\/\/)[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|(http:\/\/|https:\/\/)/;
															var errormsg = "<p>Enter Valid Video URL</p>";
															if( !urlmatch.test(youtube_url) ){
																document.getElementById('Youtubeurlmessage').innerHTML = errormsg;
																document.getElementById('Youtubeurlmessage').style.display = "block";
																return false;
															}
															document.getElementById('loading_image').style.display ="block";
															document.getElementById('generate').style.display ="none";

															<?php if ( $youtube_key != '' ) { ?>
																var youtubeurl = 'https://www.googleapis.com/youtube/v3/videos?id='+video_id+'&key=<?php echo $youtube_key; ?>&part=snippet';
																jQuery.ajax({
																	url: youtubeurl,
																	type: "GET",
																	dataType: "jsonp",
																	success : function( data ){

																		if(data['items']['0'].snippet.title !== undefined){
																			document.getElementById( 'name' ).value = data['items']['0'].snippet.title;
																		}

																		if(data['items']['0'].snippet.description !== undefined){
																			document.getElementById( 'description' ).value = data['items']['0'].snippet.description;
																		}
																							  
																		document.getElementById('generate').style.display ="block";  
																		document.getElementById('loading_image').style.display ='none';

																	}
																	
																});
															<?php } ?>
														}
														var upload_nonce = '<?php echo wp_create_nonce( "upload-video");?>';
											</script>
											<div id="upload2" class="inside">
												<div id="supportformats"><b><?php esc_attr_e( 'Supported video formats:', 'video_gallery' ) ?></b> <?php esc_attr_e( '(  MP4, M4V, M4A, MOV, Mp4v or F4V )', 'video_gallery' ) ?></div>
												<script type="text/javascript">
													folder = '<?php echo balanceTags( $dirPage ); ?>';
													var	videogallery_plugin_folder =  '<?php echo getImagesDirURL() ; ?>' ;
												</script>
												<table class="form-table">
													<tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><th style="vertical-align: middle;"><?php esc_attr_e( 'Upload Video', 'video_gallery' ) ?></th>
														<td>
															<div id="f1-upload-form" >
																<form name="normalvideoform" method="post" enctype="multipart/form-data" >
																	<input type="file" name="myfile" onchange="enableUpload( this.form.name );" />
																	<input type="button" class="button" name="uploadBtn" value="<?php esc_attr_e( 'Upload Video', 'video_gallery' ) ?>" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" />
																	<input type="hidden" name="mode" value="video" />
																	<label id="lbl_normal"><?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 )
																	echo balanceTags( $videoEdit->file );
																?></label>
																</form>
															</div>
															<span id="uploadmessage" style="display: block; margin-top:10px;color:red;font-size:12px;font-weight:bold;"></span>
															<div id="f1-upload-progress" style="display:none">
																<div style="float:left"><img id="f1-upload-image" src="<?php echo $emptyImage; ?>" alt="Uploading"  style="padding-top:2px"/>
																	<label style="padding-top:0px;padding-left:4px;font-size:14px;font-weight:bold;vertical-align:top"  id="f1-upload-filename">PostRoll.flv</label>
																</div>
																<div style="float:right">
																	<span id="f1-upload-cancel">
																		<a style="float:right;padding-right:10px;" href="javascript:cancelUpload( 'normalvideoform' );" name="submitcancel">Cancel</a>
																	</span>
																	<label id="f1-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
																	<span id="f1-upload-message" style="float:right;font-size:10px;background:#FFAFAE;">
																		<b><?php esc_attr_e( 'Upload Failed:', 'video_gallery' ) ?></b> <?php esc_attr_e( 'User Cancelled the upload', 'video_gallery' ) ?>
																	</span>
																</div>
															</div>
														</td>
													</tr>
													<tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new1"> <th><?php esc_attr_e( 'Upload HD Video ( Optional )', 'video_gallery' ) ?></th>
														<td>
															<div id="f2-upload-form" >
																<form name="hdvideoform" method="post" enctype="multipart/form-data" >
																	<input type="file" name="myfile" onchange="enableUpload( this.form.name );" />
																	<input type="button" class="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" />
																	<input type="hidden" name="mode" value="video" />
																	<label id="lbl_normal"><?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 )
																	echo balanceTags( $videoEdit->hdfile );
																?></label>
																</form>
															</div>
															<div id="f2-upload-progress" style="display:none">
																<div style="float:left"><img id="f2-upload-image" src="<?php echo $emptyImage; ?>" alt="Uploading"  style="padding-top:2px" />
																	<label style="padding-top:0px;padding-left:4px;font-size:14px;font-weight:bold;vertical-align:top"  id="f2-upload-filename">PostRoll.flv</label>
																</div>
																<div style="float:right">
																	<span id="f2-upload-cancel">
																		<a style="float:right;padding-right:10px;" href="javascript:cancelUpload( 'hdvideoform' );" name="submitcancel">Cancel</a>
																	</span>
																	<label id="f2-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
																	<span id="f2-upload-message" style="float:right;font-size:10px;background:#FFAFAE;">
																		<b><?php esc_attr_e( 'Upload Failed:', 'video_gallery' ) ?></b> <?php esc_attr_e( 'User Cancelled the upload', 'video_gallery' ) ?>
																	</span>
																</div>
															</div>
														</td>
													</tr>
													<tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new1"><th><?php esc_attr_e( 'Upload Thumb Image', 'video_gallery' ) ?></th>
														<td>
															<div id="f3-upload-form" >
																<form name="thumbimageform" method="post" enctype="multipart/form-data" >
																	<input type="file" name="myfile"  onchange="enableUpload( this.form.name );" />
																	<input type="button" class="button" name="uploadBtn" value="Upload Image"  disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" />
																	<input type="hidden" name="mode" value="image" />
																	<label id="lbl_normal"><?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 2 || $videoEdit->file_type == 5 ) )
																	echo balanceTags( $videoEdit->image );
																?></label>
																</form>
															</div>
															<span id="uploadthumbmessage" style="display: block; margin-top:10px;color:red;font-size:12px;font-weight:bold;"></span>
															<div id="f3-upload-progress" style="display:none">
																<div style="float:left">
																	<img id="f3-upload-image" src="<?php echo $emptyImage; ?>" alt="Uploading" style="padding-top:2px" />
																	<label style="padding-top:0px;padding-left:4px;font-size:14px;font-weight:bold;vertical-align:top"  id="f3-upload-filename">PostRoll.flv</label>
																</div>
																<div style="float:right">
																	<span id="f3-upload-cancel">
																		<a style="float:right;padding-right:10px;" href="javascript:cancelUpload( 'thumbimageform' );" name="submitcancel">Cancel</a>
																	</span>
																	<label id="f3-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
																	<span id="f3-upload-message" style="float:right;font-size:10px;background:#FFAFAE;">
																		<b><?php esc_attr_e( 'Upload Failed:', 'video_gallery' ) ?></b> <?php esc_attr_e( 'User Cancelled the upload', 'video_gallery' ) ?>
																	</span>
																</div>
															</div>
														</td>
													</tr>
													<tr id="ffmpeg_disable_new4" name="ffmpeg_disable_new1"><th><?php esc_attr_e( 'Upload Preview Image ( Optional )', 'video_gallery' ) ?></th>
														<td>
															<div id="f4-upload-form" >
																<form name="previewimageform" method="post" enctype="multipart/form-data" >
																	<input type="file" name="myfile" onchange="enableUpload( this.form.name );" />
																	<input type="button" class="button" name="uploadBtn" value="Upload Image" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" />
																	<input type="hidden" name="mode" value="image" />
																	<label id="lbl_normal"><?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 )
																	echo balanceTags( $videoEdit->opimage );
																?></label>
																</form>
															</div>
															<div id="f4-upload-progress" style="display:none">
																<div style="float:left">
																	<img id="f4-upload-image" src="<?php echo $emptyImage; ?>" alt="Uploading" style="padding-top:2px" />
																	<label style="padding-top:0px;padding-left:4px;font-size:14px;font-weight:bold;vertical-align:top"  id="f4-upload-filename">PostRoll.flv</label>
																</div>
																<div style="float:right">
																	<span id="f4-upload-cancel">
																		<a style="float:right;padding-right:10px;" href="javascript:cancelUpload( 'previewimageform' );" name="submitcancel">Cancel</a>
																	</span>
																	<label id="f4-upload-status" style="float:right;padding-right:40px;padding-left:20px;">Uploading</label>
																	<span id="f4-upload-message" style="float:right;font-size:10px;background:#FFAFAE;">
																		<b><?php esc_attr_e( 'Upload Failed:', 'video_gallery' ) ?></b> <?php esc_attr_e( 'User Cancelled the upload', 'video_gallery' ) ?>
																	</span>
																</div>
															</div>
															<div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
														</td>
													</tr>
												</table>
												<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="video_upload" style="display: none;">
													<div id="videomessage" class="messagebox_text"><?php _e('Please upload a video', 'video_gallery'); ?></div>
												</div>
												<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="video_thumb" style="display: none;">
													<div id="thumbmessage" class="messagebox_text"><?php _e('Please upload a video thumbnail', 'video_gallery'); ?></div>
												</div>
											</div>

											<div id="customurl" class="rtmp_inside inside">
												<div class="rtmp-related">
													<?php esc_attr_e( 'Streamer Path', APPTHA_VGALLERY ) ?>
													<input type="text" name="streamname" id="streamname" onkeyup="validatestreamurl();"
														value="<?php
															if (isset ( $videoEdit->file_type ) && $videoEdit->file_type == 4) {
															  echo $videoEdit->streamer_path;
															}
															?>" />
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="streamermessage" style="display: none;"></div>
													<?php esc_attr_e( 'Here you need to select whether your RTMP video is a live video or not', APPTHA_VGALLERY ) ?><br />
													<div class="islive-radio">
														<input type="radio" style="float: none;" id="islive2" name="islive" 
															<?php if ( isset( $videoEdit->islive ) && $videoEdit->islive == '1' ) { 
															  echo $checked; 
															} ?> value="1" /> <label><?php esc_attr_e( 'Yes, live', APPTHA_VGALLERY ) ?></label><br />
														<input type="radio" name="islive" id="islive1" style="float: none;" 
															<?php if ( isset( $videoEdit->islive ) && ( $videoEdit->islive == '0' || $videoEdit == '' ) ) {
															  echo $checked; 
															} ?> value="0" /> <label><?php esc_attr_e( 'No, not live', APPTHA_VGALLERY ) ?></label>
													</div>
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="rtmplivemessage" style="display: none;"></div>
												</div>
												<?php esc_attr_e( 'Video URL', APPTHA_VGALLERY ) ?>
												<input type="text" id="filepath2" size="50" name="filepath2" onkeyup="validatevideourl();"
													<?php /** Check video edit 
															* Type is file upload
															*/?>
													value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
													  echo $videoEdit->file ; 
													} ?>" />
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="videourlmessage" style="display: none;"></div>
												<div class="customurl-related">
													<?php esc_attr_e( 'HD Video URL ( Optional )', APPTHA_VGALLERY ) ?>
													<input type="text" name="filepath3" id="filepath3" size="50" 
														value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
														  echo $videoEdit->hdfile ; 
														} ?>" />
														<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="videohdurlmessage" style="display: none;"></div>
												</div>
												<?php esc_attr_e( 'Thumb Image URL', APPTHA_VGALLERY ) ?>
												<input type="text" name="filepath4" size="50" id="filepath4" onkeyup="validatethumburl();"
													value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
													  echo $videoEdit->image ; 
													} ?>" />
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="thumburlmessage" style="display: none;"></div>
												<?php esc_attr_e( 'Preview Image URL ( Optional )', APPTHA_VGALLERY ) ?>
												<input type="text" id="filepath5" size="50" name="filepath5" 
													value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
													  echo $videoEdit->opimage ; 
													} ?>" />
													<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="previewurlmessage" style="display: none;"></div>
											</div>

											<input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 ) echo balanceTags( $videoEdit->file ); ?>"  />
											<input type="hidden" name="hdvideoform-value" id="hdvideoform-value" value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 ) echo balanceTags( $videoEdit->hdfile ); ?>" />
											<input type="hidden" name="thumbimageform-value" id="thumbimageform-value"  value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 2 || $videoEdit->file_type == 5 ) ) echo balanceTags( $videoEdit->image ); ?>" />
											<input type="hidden" name="previewimageform-value" id="previewimageform-value"  value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 ) echo balanceTags( $videoEdit->opimage ); ?>" />
											<input type="hidden" name="subtitle1form-value" id="subtitle1form-value"  value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type != 5 ) echo balanceTags( $videoEdit->srtfile1 ); ?>" />
											<input type="hidden" name="subtitle2form-value" id="subtitle2form-value"  value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type != 5 ) echo balanceTags( $videoEdit->srtfile2 ); ?>" />
											<input type="hidden" name="subtitle_lang1" id="subtitle_lang1" value="" />
											<input type="hidden" name="subtitle_lang2" id="subtitle_lang2" value="" />
											<input type="hidden" name="youtube-value" id="youtube-value"  value="" />
											<input type="hidden" name="streamerpath-value" id="streamerpath-value" value="" />
											<input type="hidden" name="embed_code" id="embed_code" value="" />
											<input type="hidden" name="islive-value" id="islive-value" value="0" />
											<input type="hidden" name="customurl" id="customurl1"  value="" />
											<input type="hidden" name="customhd" id="customhd1"  value="" />
											<input type="hidden" name="member_id" id="member_id"  value="<?php if ( isset( $videoEdit->member_id ) ) echo balanceTags( $videoEdit->member_id ); ?>" />
											<input type="hidden" name="customimage" id="customimage"  value="" />
											<input type="hidden" name="custompreimage" id="custompreimage"  value="" />
											<input type="hidden" name="download" id="download"  value="0" />
											<input type="hidden" name="prerollads" id="prerollads"  value="0" />
											<input type="hidden" name="postrollads" id="postrollads"  value="0" />
											<input type="hidden" name="midrollads" id="midrollads"  value="0" />
											<input type="hidden" name="imaad" id="imaad"  value="0" />
											<input type="hidden" name="googleadsense" id="googleadsense"  value="0" />
											<input type="hidden" name="google_adsense_value" id="google_adsense_value"  value="0" />
											<input type="hidden" name="amazon_buckets" id="amazon_buckets"  value="0" />
											
											<div id="poststuff">
												<div id="post-body" class="metabox-holder columns-2">
													<div id="post-body-content">
														<div class="stuffbox">	
															<div class="inside">
																<div class="video_title"><?php _e('Title / Name', 'vh') ?></div>
																<input value="" type="text" size="50" maxlength="200" name="video_name" id="name" />
																<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="video_title" style="display: none;">
																	<div class="messagebox_text">
																		<span id="titlemessage" style="display: block;"></span>
																	</div>
																</div>
																<div class="video_description"><?php _e('Description', 'vh') ?></div>
																<textarea id="description" name="description" rows="5" cols="60"></textarea>
																<input type="hidden" id="feature_off" name="feature" checked="checked" value="0">
																<?php if ( $vh_new_videos_drafts != 'false' ) { ?>
																<input type="hidden" id="publish_on" name="publish" checked="checked" value="1">
																<?php } else { ?>
																<input type="hidden" id="publish_on" name="publish" checked="checked" value="0">
																<?php } ?>
															</div>
														</div>
													</div>
													<!-- Start of sidebar  -->
													<!-- End of sidebar -->
												</div><!--END Post body -->
											</div><!--END Poststuff -->
											<div class="submit_video_button">
												<input type="submit" name="submit_video" class="button wpb_button wpb_btn-primary wpb_regularsize" value="<?php echo _e('Add video', 'vh'); ?>" />

										<?php
											echo _e('Add video', 'vh');
										?>
												<input type="hidden" name="add_video" value="<?php echo _e('Add video', 'vh'); ?>" />
											</div>
										</div>
										<div id="postbox-container-1" class="postbox-container vc_col-sm-3">
											<div id="side-sortables" class="inner-sidebar meta-box-sortables ui-sortable" >
												<div id="categorydiv" class="postbox">
													<div class="video_category"><?php _e('Categories', 'vh'); ?></div>
													<div class="inside">
														<div id="submitpost" class="submitbox">
															<div class="misc-pub-section">
																<div id="playlistchecklist"><?php $ajaxplaylistOBJ->get_playlist(); ?></div>
																<input type="hidden" name="filetypevalue" id="filetypevalue" value="1" />
																<div class="vc_message_box vc_message_box-standard vc_message_box-rounded vc_color-alert-danger" id="video_category" style="display: none;">
																	<div id="jaxcat" class="messagebox_text"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<?php
										if ( $vh_new_videos_drafts != 'false' && function_exists('bp_do_register_theme_directory') ) {
											$select = "SELECT slug FROM " . $wpdb->prefix . "hdflvvideoshare ORDER BY vid DESC";
											$results = $wpdb->get_results($select);
											if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
												add_activity($_POST['video_name'],$results['0']->slug);
											}
										}
										?>
									</div>
								</form>
							</div>
						</div>
					<?php } else {
						echo __("You need to be logged in to submit a video. Register your account ", "vh") . '<a href="wp-login.php?action=register">' . __("here", "vh") . '</a>';
					} ?>
					<?php

					echo $error;
					?>
				</div>
			</div>
		</div>
		<?php
		if (LAYOUT == 'sidebar-right') {
		?>
		<div class="vc_col-sm-3 pull-right <?php echo LAYOUT; ?>">
			<div class="sidebar-inner">
			<?php
				global $vh_is_in_sidebar;
				$vh_is_in_sidebar = true;
				generated_dynamic_sidebar();
			?>
			<div class="clearfix"></div>
			</div>
		</div><!--end of span3-->
		<?php } ?>
		<?php $vh_is_in_sidebar = false; ?>
		<div class="clearfix"></div>
	</div><!--end of content-->
	<div class="clearfix"></div>
</div><!--end of page-wrapper-->
<?php get_footer();