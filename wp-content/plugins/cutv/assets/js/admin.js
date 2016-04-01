jQuery( document ).ready( function ( $ ) {
	if (window.location.pathname.indexOf('wp-admin/edit')) {

		$('.posts .iedit').each(function(){

			var $videoRow = $(this);
			var $thumbnailUrl = $videoRow.find('.wp-post-image').prop('src');

			// add the snaptube button
			$videoRow.find('.thickbox').hide()
			$videoRow.find('.column-video_data').append('<button class="add-to-snaptube cutv">Convert to Snaptube Video</button>');

		});

		$('.posts')
			.on('click', '.add-to-snaptube', function(e) {
				e.preventDefault();

				$videoPost = $(this).parents(".iedit");
				$videoPost.cutv_get_new_videogallery_form($videoPost.find('.video-info').attr('data-youtube-url'));

			});
	}


	$.fn.cutv_get_new_videogallery_form = function(youtube_url)
	{
		console.log($(this));

		youtube_url = typeof youtube_url !== 'undefined' ? youtube_url : false;
		
		if ($('#stuff').length)
			$('#stuff').empty();

		var requesturl = '/cutv/wp-admin/'+'admin.php?page=newvideo form'; 
		var post_id = $(this).prop('id').split('post-')[1];
		// GET THE FORM
		$(this).find('td:last').append('<div id="stuff-'+post_id+'"></div>');
		$('#stuff-'+post_id).load( requesturl, function( response, status, xhr ) {
		  if ( status == "error" ) {
		    var msg = "Sorry but there was an error: ";
		    console.log( msg + xhr.status + " " + xhr.statusText );
		    // $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
		  } else {
		  	// console.log(response);

			// document.getElementById('table_options').onsubmit = 'return cutv_chkbut()';

			// cutv_chkbut();
			$(this).find('#video_options').prop('id', 'video_options-'+post_id); 
			var $videoForm = $('#video_options-'+post_id);
			var $post = $('#post-'+post_id);
			var $videoInfo = $post.find('.video-info');

			$videoForm.prop('action', '/cutv/wp-admin/'+'admin.php?page=newvideo').siblings().hide(); 
			$videoForm.find('#adstypebox').hide();
			$videoForm.find('.form-table:first tr:not(:last)').hide();
			$videoForm.find('.form-table:first tr:eq(2), .form-table:first tr:eq(3)').show();
			// $(this).html($videoForm);

			$videoForm.find('[name="name"]').val($videoInfo.find('.cutv-video-title').text());
			$videoForm.find('[name="description"]').val($videoInfo.find('.cutv-video-description').text());

			// $videoForm.append('<input type="hidden" name="image" value="'+$('#post-'+post_id+' .wp-post-image').prop('src')+'">');
			$videoForm.append('<input type="hidden" name="youtube-value" value="'+youtube_url+'">'); 
			$videoForm.append('<input type="hidden" name="post_date" value="'+$videoInfo.data('youtube-postdate')+'">'); 
			$videoForm.append('<input type="hidden" name="post_id" value="'+$videoInfo.data('post-id')+'">'); 
			$videoForm.append('<input type="hidden" name="cutv_add" value="true">'); 
			$videoForm.append('<input type="checkbox" id="btn2">'); 

			$post.find('[name="tags_name"]').val($videoInfo.data('youtube-tags'));

			$post.find('#playlist-'+$videoInfo.data('cutv-channel')).prop('checked', true);
			$videoForm.find('.post-body-content').append($videoForm.find('#playlistchecklist'));

			$videoForm.find('.postbox-container-1').remove();
			document.getElementById('btn2').checked = true;
			document.getElementById('filepath1').value = youtube_url;

			console.log($videoForm.find('[name="image"]'));

			$('#add-snaptube-modal_'+post_id).html($('#stuff-'+post_id));
			$('#post-'+post_id).find('.thickbox').trigger('click');
			// $video
			// $videoForm.submit();
			// $videoForm.find('[name=""]')
			
			// document.getElementById('video_options').onsubmit =  function(){
			// document.getElementById('video_options').onsubmit =  function(){

			// cutv_chkbut();
			// 	 return false;
			// }
			// GENERATE THE DETAILS
			// var videoDetails = cutv_getyoutube_details(youtube_url);	  	
		  }
		});


		// $j('#stuff').html('<iframe width="100%" height="300" src="/cutv/wp-admin/admin.php?page=newvideo&youtube_url='+youtube_url+'&auto=true"></iframe>');

	}

});

var $j = jQuery.noConflict();
function cutv_getyoutube_details(youtube_url)
{
	youtube_url = typeof youtube_url !== 'undefined' ? youtube_url : document.getElementById("filepath1").value;
   // var youtube_url =  document.getElementById("filepath1").value;
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
	   // document.getElementById('Youtubeurlmessage').innerHTML = errormsg;
	   // document.getElementById('Youtubeurlmessage').style.display = "block";
	   return false;
   }
   var playlistajax = jQuery.noConflict();
   // document.getElementById('loading_image').style.display ="block";         
   var requesturl = '/cutv/wp-admin/'+'admin-ajax.php?action=getyoutubedetails'; 
   playlistajax.ajax({
           url:requesturl,
           type:"GET",
           data:"filepath="+ video_id,
           success : function( msg ){
           	// console.log(playlistajax.parseJSON(msg));
               if(msg==7){
                   alert('Could not retrieve Youtube video information. API Key is missing');
               
               }
         var resultdata =  playlistajax.parseJSON(msg);
         document.getElementById( 'name' ).value = resultdata[0];
     	   document.getElementById( 'filepath1' ).value = resultdata[4];
     		var tag_name = resultdata[6];
     	   if(resultdata[5] !== undefined){
     		// tinymce.activeEditor.setContent(resultdata[5]);
     		// tinymce.execCommand('mceAddControl',true,'description');
     	   	 document.getElementById( 'description' ).innerHTML = resultdata[5];

     	   }
     	   if( tag_name !== undefined ) {	   
     	   	 document.getElementById( 'tags_name' ).value = resultdata[6];
     	   }	                      
        	   document.getElementById( 'embedvideo').style.display = "none";
         document.getElementById('loading_image').style.display ='none';

         // FORCING ANIMATION CATEGORY FOR NOW
        var chkbox = document.getElementById('playlist-2');
        chkbox.checked = true;

        // document.getElementById

      }  
   }); 
}


function cutv_chkbut()
{
	// 	if (uploadqueue.length <= 0)
	// 	{
		
		document.getElementById('youtube-value').value = document.getElementById('filepath1').value;

		//if using the orginal form... bleh
		//return true;

		var data = $j('#video_options').serializeArray();

		data.push({
			'name' : 'page',
			'value' : 'newvideo'
		});


		console.log(data);

		var cutv_add_video = cutv.ajax('/cutv/wp-admin/'+'admin-ajax.php', data);

		cutv_add_video.done(function(result){
			// console.log(result);
		}).fail(function(error){
			console.log(error);
		});
		// return false;
		// $j.ajax({
	 //        url: '/cutv/wp-admin/'+'admin.php?page=newvideo',
	 //        type:"GET",
	 //        data: $j('#video_options').serializeArray(),
	 //        success : function( result ){
	 //        	// document.getElementById('stuff').innerHTML = result;
	 //        	console.log(result);
	 //        }
		   
		// }); 

		
	// } else {
	// 	alert("Wait for Uploading to Finish");
	// 	return false;
	// }

}

//*****************************************************************/  
//    TAYANA'S FUNCTIONS
//*****************************************************************/

/*****************************************************************/
//	Development environment functions
/********************************************************************/

DEBUG_LEVEL = window.location.hostname == 'localhost' ? 3 : 0;
if (navigator.appName == "Microsoft Internet Explorer") DEBUG_LEVEL = 0;
function log(options) {

	var defaults = {
		msg: null,
		level: DEBUG_LEVEL,
		group: false,
		color: 'blue'
	};
	$j.extend(defaults, options);

	if ( DEBUG_LEVEL > 2 && navigator.appName != "Microsoft Internet Explorer") {
			console.log("%c" + options.msg, "color:"+options.color+";");
	}
}


var cutv = {

	ajax: function(url, data, options){
		data = typeof data !== 'undefined' ? data : '';
		options = typeof options !== 'undefined' ? options : '';
		log({msg: "MakePromise() to " + url+" (cutv.Promise)", color: 'blue' });
	    return new MakePromise({ url: url, data: data, options: options });
	}

};

function MakePromise(options){

//log({msg: "A promise is being made...", color: 'purple' });

	var errorMessage;
	var defaults = {
			url: null,
			data: null,
			method: 'GET',
			cache: true,
			showErrors: true,
			success: function(result) {
				//log({msg:"Promise went through!", color: 'purple' });
				//console.groupEnd();
				promise.resolve(result);
			},
			error: function(jqXHR, textStatus, error) {

				if ( jqXHR.status == 400 ) {
					errorMessage = jqXHR.responseText;
					log({msg: "%c(╯°□°）╯ should be accompanied by custom message to display", color: 'red' });
					log({msg: errorMessage , color: 'red' });

					//if (defaults.showErrors) Dna.Errors(errorMessage);
					if (defaults.showErrors) console.log(errorMessage);


				} else {
					log({msg: "%c(╯°□°）╯", color: 'red' });
					errorMessage = { error: error, statusCode: jqXHR.status};
				}

				promise.reject(errorMessage);
			}
		};

	$j.extend(defaults, options);


	var promise = $j.Deferred();
	$j.ajax({
		type: options.method || defaults.method,
		url: options.url,
		data: options.data,
		success: options.success || defaults.success,
		error: options.error || defaults.error
	});

	return promise;
}


function getURLParameter(name, url) {
	console.log(window.parent.location);

	if (window.parent.location.search.length) {
		url = typeof url !== 'undefined' ? url : window.parent.location.search;
	} else if (location.search !== '') {
		url = typeof url !== 'undefined' ? url : location.search;
	}

	if (url !== null) 
  		return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(url)||[,""])[1].replace(/\+/g, '%20'))||null;

}

