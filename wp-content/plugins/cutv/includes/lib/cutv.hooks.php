<?php

	/***************************/
	/* CUTV Global HOOKS Hook */
	/*************************/



	//*****************************************************************/  
	//    CUTV HOOKS
	//*****************************************************************/

	add_action( 'wp_ajax_cutv_channel_link', 'wpse_126886_ajax_handler' );
	// add_action( 'wp_ajax_admin_enqform', 'wpse_126886_ajax_handler' );

	function wpse_126886_ajax_handler() {

        $playlists = get_post_meta($_POST['id'], 'cote', true);
		// if(isset($_POST['submitted'])) {    //validations 

		//     if(trim($_POST['firstname']) === '') {
		//         $hasError = true;
		//     } else {
		//         $firstname = trim($_POST['firstname']);
		//     }   


		    // maybe check some permissions here, depending on your app

		 	global $wpdb;
		 	$nonce=$_REQUEST['nonce'];
// if (! wp_verify_nonce($nonce, 'videogallery') ) die('Well that was naughty.');
		    // $nonce = $_POST['nonce'];
		    // if ( ! wp_verify_nonce( $nonce, 'form-nonce' ) ) {
		    //     die( 'Security check' ); 
		    // } else {            

		    	// print_r('test');
		        // $new_post = array(
		        //     'post_title'    => 'buttslut',
		        //     'post_status'   => 'publish',
		        //     'post_type' => 'post'
		        // );
		        // $pid = wp_insert_post($new_post);    

        /** Get video name parameters from the request */
        $videoName        = $_REQUEST['name' ];
        /** Get video description parameters from the request */
        $videoDescription = $_REQUEST['description' ];
        /** Get embed_code parameters from the request */
        $embedcode        = $_REQUEST['embed_code' ];
        /** Get publish parameters from the request */
        $videoPublish     = $_REQUEST['publish' ];
        /** Get feature parameters from the request */
        $videoFeatured        = $_REQUEST['feature' ];
        /** Get download parameters from the request */
        $videoDownload        = $_REQUEST['download' ];
        /** Get midrollads parameters from the request */
        $videomidrollads      = $_REQUEST['midrollads' ];
        /** Get imaad parameters from the request */
        $videoimaad           = $_REQUEST['imaad' ];
        /** Get postrollads parameters from the request */
        $videoPostrollads     = $_REQUEST['postrollads' ];
        /** Get prerollads parameters from the request */
        $videoPrerollads      = $_REQUEST['prerollads' ];
        /** Get googleadsense parameters from the request */
        $google_adsense       = $_REQUEST['googleadsense' ];
        /** Get google_adsense_value parameters from the request */
        $google_adsense_value = $_REQUEST['google_adsense_value' ];
        /**
         * Get member id from request.
         * If not get current user id
         */
        $member_id            = $_REQUEST['member_id' ];
        if (empty ( $member_id )) {
          $current_user = wp_get_current_user ();
          $member_id    = $current_user->ID;
        }

        $img1 = $_REQUEST['thumbimageform-value' ];
        /** Get preview image form params */
        $img2 = $_REQUEST['previewimageform-value' ];

        /** Get Youtube video url from request */
        $videoLinkurl     = $_REQUEST['youtube-value' ];
        /** Set video duration */
        $duration = '0:00';
        /** Get video added method */
        $video_added_method = $_REQUEST['filetypevalue' ];
        /** Get amazon bucket params */
        $amazon_buckets     = $_REQUEST['amazon_buckets' ];
        /** Check youtbe / youtu.be / dailymotion / viddler video url is exists */
        if ($videoLinkurl != '') {
          /** Attach http with video url */
          if (preg_match ( '#https?://#', $videoLinkurl ) === 0) {
            $videoLinkurl = 'http://' . $videoLinkurl;
          }
          /** Remove spaces in video url */
          $act_filepath = addslashes ( trim ( $videoLinkurl ) );
        }
        if ($videoLinkurl != '' && $act_filepath != '') {
          /** Set file type 1 for YouTube/ viddler /dailymotion  */
          $file_type = '1';
          /** Check video url contains youtbe / youtu.be / dailymotion / viddler */
          if ( (strpos ( $act_filepath, 'youtube' ) > 0 ) || (strpos ( $act_filepath, 'youtu.be' ) > 0) ) {
            /** Get youtube video id from plugin helper */
            $youtubeVideoID  = getYoutubeVideoID ( $act_filepath );
            /** Get thumb URL for YouTube videos */
            $act_opimage  = $previewurl   = 'http://img.youtube.com/vi/' . $youtubeVideoID . '/maxresdefault.jpg';
            /** Get preview URL for YouTube videos */
            $act_image    = $img          = 'http://img.youtube.com/vi/' . $youtubeVideoID . '/mqdefault.jpg';
            //* Get YouTube video URL and fetch information  
            $act_filepath = $youtubeVideoURL . $youtubeVideoID; 
            //$ydetails = hd_getsingleyoutubevideo( $youtubeVideoID );
            ///** Get youTube video duration */
            // $youtube_time = $ydetails['items'][0]->contentDetails->duration;
            // if(!empty($youtube_time)) {
            //     /** Convert duration into h:m:s format */
            //     $di = new DateInterval($youtube_time);
            //     $string = '';
            //     $min =  $di->i;
            //     if ($di->h > 0) {
            //       $string .= $di->h.':';
            //       /** Check if minutes is <= 9 while hours value is exist */ 
            //       if($min <= 9 ){ 
            //          $min = '0' . $min;
            //       }
            //     }
            //     $duration = $string . $min . ':' .$di->s;
            // }
          }

        }

		        /** Set palylsit details as array */         
		        $videoData = array ( 
		        	'name' => $videoName, 
					'description' => $videoDescription, 
					'embed_code' => $embedcode, 
					'publish' => $videoPublish, 
					'feature' => $videoFeatured, 
					'download' => $videoDownload, 
					'midrollads' => $videomidrollads, 
					'imaad' => $videoimaad, 
					'postrollads' => $videoPostrollads, 
					'prerollads' => $videoPrerollads,
					'googleadsense' => $google_adsense,
					'google_adsense_value' => $google_adsense_value,
					'member_id' => $member_id,
					'thumbimageform-value' => $img1,
					'previewimageform-value' => $img2,
					'youtube-value' => $videoLinkurl,
					'filetypevalue' => $video_added_method,
					'amazon_buckets' => $amazon_buckets,
					'duration' => $duration
		          ) ;
		        /** Insert the new data array into playlist table */
		        $insert_plist = $wpdb->insert ( $wpdb->prefix . 'hdflvvideoshare', $videoData );                
		        /** Check data is insert into database */
		        // if ($insert_plist != 0) {
		        //     /** Display success message */
		        //     $this->render_message ( __ ( 'Category', APPTHA_VGALLERY ) . ' ' . $name . ' ' . __ ( 'added successfully', APPTHA_VGALLERY ) ) . $this->get_playlist_for_dbx ( $media );
		        // }


		        // if( $pid ) { 
		        //     add_post_meta( $pid, 'cpt_twatbuckle', 'buttslut', true );                                       
		        // }

			    // send some information back to the javascipt handler
			    // $response = array(
			    //     'status' => '200',
			    //     'message' => 'OK',
			    //     'new_post_ID' => $pid
			    // );


		    // }




		  //   // normally, the script expects a json respone
		    header( 'Content-Type: application/json; charset=utf-8' );
		    // echo json_encode( $response );
		    echo json_encode( $insert_plist );
		    // echo '{"wp-test-check":true,"server_time":"'.$_REQUEST['foo'] .'"}';


			// echo 'test';

		    exit; // important
		// }
	}


    
