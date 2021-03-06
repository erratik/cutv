<?php

	// Static Global Data SGD
	global $wpvr_timezones , $wpvr_countries , $wpvr_colors , $wpvr_roles;
	global $wpvr_services , $wpvr_status , $wpvr_private_cpt;
	global $wpvr_types , $wpvr_types_;
	global $wpvr_days_names , $wpvr_days , $wpvr_hours , $wpvr_days_of_month;
	global $wpvr_base_definitions;
	//Dynamic Global Data SDD
	global $wpvr_dynamics , $wpvr_options , $wpvr_cron_token , $wpvr_tokens , $wpvr_stress , $wpvr_activation;
	global $wpvr_addons , $wpvr_fillers , $wpvr_filler_data , $wpvr_all_plugins , $wpvr_setters;
	global $wpvr_notices , $wpvr_deferred , $wpvr_deferred_ids , $wpvr_imported;

	global $wpvr_unwanted , $wpvr_unwanted_ids ;

	global $wpvr_getmb_unsupported_themes ;

	// Making those variables global
	global $current_user , $wpvr_pages , $wpvr_rating_levels;

	global $wpvr_vs , $wpvr_act ;

	global $default_fetching_options , $default_videosFound;
		

	/**************************    STATIC *****************************************************/

	$wpvr_getmb_unsupported_themes = array(
		'newstube',
	);

	$wpvr_act = wpvr_get_activation('wpvr');
	
	$default_videosFound = array(
		'nextPageToken' => '' ,
		'count'         => 0 ,
		'totalResults'  => 0 ,
		'absCount'      => 0 ,
		'dupCount'      => 0 ,
		'unwantedCount'      => 0 ,
		'execTime'      => '' ,
		'videosIds'     => '' ,
		'ch'            => '' ,
		'era'           => 0 ,
		'real_count'    => 0 ,
		'items'         => array() ,
	);

	$default_fetching_options = array(
		'how'  => array(
			'wantedResults'    => 10 , //Number of Videos to look for. Default : 10
			'onlyNewVideos'    => true , //Skip duplicate videos found in $old_videos array ? Default : false
			'getVideosStats'   => false , //Get video duration/Likes/Dislikes/Views ?(Performance issue). Default : false
			'getVideosTags'    => false , //Get video duration/Likes/Dislikes/Views ?(Performance issue). Default : false
			'debugMode'        => false , // show debug messages. Default : false
			'postDate'         => '' , // serialized array of wp cats
			'postCats'         => '' ,
			'postTags'         => array() ,
			'postAuthor'       => '' , // user id of posting author
			'autoPublish'      => false , // Auto
			'sourceName'       => '' , // Auto
			'sourceId'         => '' , // Auto
			'sourceType'       => '' , // Auto
			'postAppend'       => '' , // Auto
			'appendCustomText' => '' , // Auto
			'appendSourceName' => '' , // Auto
		) ,
		'what' => array(
			'era'             => 0 , //search,playlist,import,trending
			'mode'            => 'search' , //search,playlist,import,trending
			'service'         => 'youtube' , //search,playlist,import,trending
			'order'           => 'relevance' , // Date,rating, relevance,title,viewCount. Default : 'relevance'

			'videoQuality'    => 'any' ,
			'publishedAfter'  => '' ,
			'publishedBefore' => '' ,
			'havingViews'     => '' ,
			'videoDuration'   => 'any' ,
		) ,
	);


	$wpvr_rating_levels = array(
		10 ,
		100 ,
		500 ,
		1000 ,
		2000 ,
		5000 ,
		10000 ,
	);
	// Defining wpvr_setters
	$wpvr_setters = array(
		array(
			'title'  => __( 'Reset Video Tables' , WPVR_LANG ) ,
			'desc'   => 'Reset the antiduplicates filter, and remember only existing imported videos.' ,
			'button' => __( 'Reset Video Tables' , WPVR_LANG ) ,
			'action' => 'reset_video_tables' ,
			'url'    => 'reset_video_tables' ,
		) ,

		array(
			'title'  => __( 'Clear Deferred' , WPVR_LANG ) ,
			'desc'   => 'Clear deferred videos.' ,
			'button' => __( 'Clear Deferred' , WPVR_LANG ) ,
			'action' => 'clear_deferred' ,
		) ,
		array(
			'title'  => __( 'Clear Errors' , WPVR_LANG ) ,
			'desc'   => 'Clear WPVR activation errors.' ,
			'button' => __( 'Clear Errors' , WPVR_LANG ) ,
			'action' => 'clear_errors' ,
		) ,
		array(
			'title'       => __( 'Show Errors' , WPVR_LANG ) ,
			'desc'        => 'Show WPVR activation errors.' ,
			'button'      => __( 'Show Errors' , WPVR_LANG ) ,
			'action'      => 'show_errors' ,
			'show_result' => 1 ,
		) ,
		array(
			'title'  => __( 'Remove Temp Files' , WPVR_LANG ) ,
			'desc'   => 'Remove Import/Export Temporary files' ,
			'button' => __( 'Remove Temp Files' , WPVR_LANG ) ,
			'action' => 'remove_tmp' ,
		) ,

		array(
			'title'  => __( 'Reset Activation' , WPVR_LANG ) ,
			'desc'   => 'Reset the WP Video Robot licence activation.' ,
			'button' => __( 'Reset Activation' , WPVR_LANG ) ,
			'action' => 'reset_activation' ,
		) ,

		array(
			'title'  => __( 'Renew CRON Security Token' , WPVR_LANG ) ,
			'desc'   => 'Reset the security token code of cron executions.' ,
			'button' => __( 'Reset Cron Token' , WPVR_LANG ) ,
			'action' => 'reset_cron_token' ,
		) ,

		array(
			'title'  => __( 'Reset CRON Data' , WPVR_LANG ) ,
			'desc'   => 'Reset the CRON execution statistics and data.' ,
			'button' => __( 'Reset Cron Data' , WPVR_LANG ) ,
			'action' => 'reset_cron_data' ,
		) ,

		array(
			'title'  => __( 'Reset WPVR Notices' , WPVR_LANG ) ,
			'desc'   => 'Reset informational notices.' ,
			'button' => __( 'Reset Notices' , WPVR_LANG ) ,
			'action' => 'reset_notices' ,
		) ,

		array(
			'title'  => __( 'Reset APIs Tokens' , WPVR_LANG ) ,
			'desc'   => 'Reset video services APIs access tokens.' ,
			'button' => __( 'Reset APIs Tokens' , WPVR_LANG ) ,
			'action' => 'reset_wpvr_tokens' ,
		) ,

	);


	// Defining Countries */
	$wpvr_countries = array(
		''   => 'WorldWide' , 'AF' => 'Afghanistan' , 'AX' => 'Aland Islands' , 'AL' => 'Albania' , 'DZ' => 'Algeria' , 'AS' => 'American Samoa' , 'AD' => 'Andorra' , 'AO' => 'Angola' ,
		'AI' => 'Anguilla' , 'AQ' => 'Antarctica' , 'AG' => 'Antigua And Barbuda' , 'AR' => 'Argentina' , 'AM' => 'Armenia' , 'AW' => 'Aruba' , 'AU' => 'Australia' , 'AT' => 'Austria' ,
		'AZ' => 'Azerbaijan' , 'BS' => 'Bahamas' , 'BH' => 'Bahrain' , 'BD' => 'Bangladesh' , 'BB' => 'Barbados' , 'BY' => 'Belarus' , 'BE' => 'Belgium' , 'BZ' => 'Belize' , 'BJ' => 'Benin' ,
		'BM' => 'Bermuda' , 'BT' => 'Bhutan' , 'BO' => 'Bolivia' , 'BA' => 'Bosnia And Herzegovina' , 'BW' => 'Botswana' , 'BV' => 'Bouvet Island' , 'BR' => 'Brazil' ,
		'IO' => 'British Indian Ocean Territory' , 'BN' => 'Brunei Darussalam' , 'BG' => 'Bulgaria' , 'BF' => 'Burkina Faso' , 'BI' => 'Burundi' , 'KH' => 'Cambodia' , 'CM' => 'Cameroon' ,
		'CA' => 'Canada' , 'CV' => 'Cape Verde' , 'KY' => 'Cayman Islands' , 'CF' => 'Central African Republic' , 'TD' => 'Chad' , 'CL' => 'Chile' , 'CN' => 'China' , 'CX' => 'Christmas Island' ,
		'CC' => 'Cocos (Keeling) Islands' , 'CO' => 'Colombia' , 'KM' => 'Comoros' , 'CG' => 'Congo' , 'CD' => 'Congo, Democratic Republic' , 'CK' => 'Cook Islands' , 'CR' => 'Costa Rica' ,
		'CI' => 'Cote D\'Ivoire' , 'HR' => 'Croatia' , 'CU' => 'Cuba' , 'CY' => 'Cyprus' , 'CZ' => 'Czech Republic' , 'DK' => 'Denmark' , 'DJ' => 'Djibouti' , 'DM' => 'Dominica' ,
		'DO' => 'Dominican Republic' , 'EC' => 'Ecuador' , 'EG' => 'Egypt' , 'SV' => 'El Salvador' , 'GQ' => 'Equatorial Guinea' , 'ER' => 'Eritrea' , 'EE' => 'Estonia' , 'ET' => 'Ethiopia' ,
		'FK' => 'Falkland Islands (Malvinas)' , 'FO' => 'Faroe Islands' , 'FJ' => 'Fiji' , 'FI' => 'Finland' , 'FR' => 'France' , 'GF' => 'French Guiana' , 'PF' => 'French Polynesia' ,
		'TF' => 'French Southern Territories' , 'GA' => 'Gabon' , 'GM' => 'Gambia' , 'GE' => 'Georgia' , 'DE' => 'Germany' , 'GH' => 'Ghana' , 'GI' => 'Gibraltar' , 'GR' => 'Greece' ,
		'GL' => 'Greenland' , 'GD' => 'Grenada' , 'GP' => 'Guadeloupe' , 'GU' => 'Guam' , 'GT' => 'Guatemala' , 'GG' => 'Guernsey' , 'GN' => 'Guinea' , 'GW' => 'Guinea-Bissau' , 'GY' => 'Guyana' ,
		'HT' => 'Haiti' , 'HM' => 'Heard Island & Mcdonald Islands' , 'VA' => 'Holy See (Vatican City State)' , 'HN' => 'Honduras' , 'HK' => 'Hong Kong' , 'HU' => 'Hungary' , 'IS' => 'Iceland' ,
		'IN' => 'India' , 'ID' => 'Indonesia' , 'IR' => 'Iran, Islamic Republic Of' , 'IQ' => 'Iraq' , 'IE' => 'Ireland' , 'IM' => 'Isle Of Man' , 'IL' => 'Israel' , 'IT' => 'Italy' ,
		'JM' => 'Jamaica' , 'JP' => 'Japan' , 'JE' => 'Jersey' , 'JO' => 'Jordan' , 'KZ' => 'Kazakhstan' , 'KE' => 'Kenya' , 'KI' => 'Kiribati' , 'KR' => 'Korea' , 'KW' => 'Kuwait' ,
		'KG' => 'Kyrgyzstan' , 'LA' => 'Lao People\'s Democratic Republic' , 'LV' => 'Latvia' , 'LB' => 'Lebanon' , 'LS' => 'Lesotho' , 'LR' => 'Liberia' , 'LY' => 'Libyan Arab Jamahiriya' ,
		'LI' => 'Liechtenstein' , 'LT' => 'Lithuania' , 'LU' => 'Luxembourg' , 'MO' => 'Macao' , 'MK' => 'Macedonia' , 'MG' => 'Madagascar' , 'MW' => 'Malawi' , 'MY' => 'Malaysia' ,
		'MV' => 'Maldives' , 'ML' => 'Mali' , 'MT' => 'Malta' , 'MH' => 'Marshall Islands' , 'MQ' => 'Martinique' , 'MR' => 'Mauritania' , 'MU' => 'Mauritius' , 'YT' => 'Mayotte' , 'MX' => 'Mexico' ,
		'FM' => 'Micronesia, Federated States Of' , 'MD' => 'Moldova' , 'MC' => 'Monaco' , 'MN' => 'Mongolia' , 'ME' => 'Montenegro' , 'MS' => 'Montserrat' , 'MA' => 'Morocco' , 'MZ' => 'Mozambique' ,
		'MM' => 'Myanmar' , 'NA' => 'Namibia' , 'NR' => 'Nauru' , 'NP' => 'Nepal' , 'NL' => 'Netherlands' , 'AN' => 'Netherlands Antilles' , 'NC' => 'New Caledonia' , 'NZ' => 'New Zealand' ,
		'NI' => 'Nicaragua' , 'NE' => 'Niger' , 'NG' => 'Nigeria' , 'NU' => 'Niue' , 'NF' => 'Norfolk Island' , 'MP' => 'Northern Mariana Islands' , 'NO' => 'Norway' , 'OM' => 'Oman' ,
		'PK' => 'Pakistan' , 'PW' => 'Palau' , 'PS' => 'Palestinian Territory, Occupied' , 'PA' => 'Panama' , 'PG' => 'Papua New Guinea' , 'PY' => 'Paraguay' , 'PE' => 'Peru' , 'PH' => 'Philippines' ,
		'PN' => 'Pitcairn' , 'PL' => 'Poland' , 'PT' => 'Portugal' , 'PR' => 'Puerto Rico' , 'QA' => 'Qatar' , 'RE' => 'Reunion' , 'RO' => 'Romania' , 'RU' => 'Russian Federation' , 'RW' => 'Rwanda' ,
		'BL' => 'Saint Barthelemy' , 'SH' => 'Saint Helena' , 'KN' => 'Saint Kitts And Nevis' , 'LC' => 'Saint Lucia' , 'MF' => 'Saint Martin' , 'PM' => 'Saint Pierre And Miquelon' ,
		'VC' => 'Saint Vincent And Grenadines' , 'WS' => 'Samoa' , 'SM' => 'San Marino' , 'ST' => 'Sao Tome And Principe' , 'SA' => 'Saudi Arabia' , 'SN' => 'Senegal' , 'RS' => 'Serbia' ,
		'SC' => 'Seychelles' , 'SL' => 'Sierra Leone' , 'SG' => 'Singapore' , 'SK' => 'Slovakia' , 'SI' => 'Slovenia' , 'SB' => 'Solomon Islands' , 'SO' => 'Somalia' , 'ZA' => 'South Africa' ,
		'GS' => 'South Georgia And Sandwich Isl.' , 'ES' => 'Spain' , 'LK' => 'Sri Lanka' , 'SD' => 'Sudan' , 'SR' => 'Suriname' , 'SJ' => 'Svalbard And Jan Mayen' , 'SZ' => 'Swaziland' ,
		'SE' => 'Sweden' , 'CH' => 'Switzerland' , 'SY' => 'Syrian Arab Republic' , 'TW' => 'Taiwan' , 'TJ' => 'Tajikistan' , 'TZ' => 'Tanzania' , 'TH' => 'Thailand' , 'TL' => 'Timor-Leste' ,
		'TG' => 'Togo' , 'TK' => 'Tokelau' , 'TO' => 'Tonga' , 'TT' => 'Trinidad And Tobago' , 'TN' => 'Tunisia' , 'TR' => 'Turkey' , 'TM' => 'Turkmenistan' , 'TC' => 'Turks And Caicos Islands' ,
		'TV' => 'Tuvalu' , 'UG' => 'Uganda' , 'UA' => 'Ukraine' , 'AE' => 'United Arab Emirates' , 'GB' => 'United Kingdom' , 'US' => 'United States' , 'UM' => 'United States Outlying Islands' ,
		'UY' => 'Uruguay' , 'UZ' => 'Uzbekistan' , 'VU' => 'Vanuatu' , 'VE' => 'Venezuela' , 'VN' => 'Viet Nam' , 'VG' => 'Virgin Islands, British' , 'VI' => 'Virgin Islands, U.S.' ,
		'WF' => 'Wallis And Futuna' , 'EH' => 'Western Sahara' , 'YE' => 'Yemen' , 'ZM' => 'Zambia' , 'ZW' => 'Zimbabwe' ,
	);

	/* DEfining Days of the month */
	$wpvr_days_of_month = array(
		'01' => '01' , '02' => '02' , '03' => '03' , '04' => '04' , '05' => '05' , '06' => '06' , '07' => '07' , '08' => '08' , '09' => '09' , '10' => '10' , '11' => '11' , '12' => '12' ,
		'13' => '13' , '14' => '14' , '15' => '15' , '16' => '16' , '17' => '17' , '18' => '18' , '19' => '19' , '20' => '20' , '21' => '21' , '22' => '22' , '23' => '23' , '24' => '24' ,
		'25' => '25' , '26' => '26' , '27' => '27' , '28' => '28' , '29' => '29' , '30' => '30' , '31' => '31' ,
	);


	/* Defining Hours */
	$wpvr_hours = array(
		'00H00' => '00H00' ,
		'01H00' => '01H00' ,
		'02H00' => '02H00' ,
		'03H00' => '03H00' ,
		'04H00' => '04H00' ,
		'05H00' => '05H00' ,
		'06H00' => '06H00' ,
		'07H00' => '07H00' ,
		'08H00' => '08H00' ,
		'09H00' => '09H00' ,
		'10H00' => '10H00' ,
		'11H00' => '11H00' ,
		'12H00' => '12H00' ,
		'13H00' => '13H00' ,
		'14H00' => '14H00' ,
		'15H00' => '15H00' ,
		'16H00' => '16H00' ,
		'17H00' => '17H00' ,
		'18H00' => '18H00' ,
		'19H00' => '19H00' ,
		'20H00' => '20H00' ,
		'21H00' => '21H00' ,
		'22H00' => '22H00' ,
		'23H00' => '23H00' ,
	);

	/* DEfining Days */
	$wpvr_days = array(
		'1' => __( 'Monday' , WPVR_LANG ) ,
		'2' => __( 'Tuesday' , WPVR_LANG ) ,
		'3' => __( 'Wednesday' , WPVR_LANG ) ,
		'4' => __( 'Thursday' , WPVR_LANG ) ,
		'5' => __( 'Friday' , WPVR_LANG ) ,
		'6' => __( 'Saturday' , WPVR_LANG ) ,
		'0' => __( 'Sunday' , WPVR_LANG ) ,
		'7' => __( 'Sunday' , WPVR_LANG ) ,
	);

	/* Defining Day names */
	$wpvr_days_names = array(
		'monday'    => __( 'Monday' , WPVR_LANG ) ,
		'tuesday'   => __( 'Tuesday' , WPVR_LANG ) ,
		'wednesday' => __( 'Wednesday' , WPVR_LANG ) ,
		'thursday'  => __( 'Thursday' , WPVR_LANG ) ,
		'friday'    => __( 'Friday' , WPVR_LANG ) ,
		'saturday'  => __( 'Saturday' , WPVR_LANG ) ,
		'sunday'    => __( 'Sunday' , WPVR_LANG ) ,
	);

	/* DEfining Stress Array */
	$wpvr_stress = array(
		'max'           => '600' ,
		'base'          => '0.193' ,
		'wantedVideos'  => 1 ,
		'getTags'       => 10 ,
		'getStats'      => 2 ,
		'onlyNewVideos' => 2 ,
	);

	/* Defining TimeZones */
	$wpvr_timezones = array(
		"GMT-11"        => array(
			"Pacific/Midway" => "GMT-11 Pacific/Midway" , "Pacific/Niue" => "GMT-11 Pacific/Niue" , "Pacific/Pago_Pago" => "GMT-11 Pacific/Pago_Pago" , "Pacific/Samoa" => "GMT-11 Pacific/Samoa" ,
			"US/Samoa"       => "GMT-11 US/Samoa" ,
		) , "GMT-10"    => array(
			"HST"            => "GMT-10 HST" , "Pacific/Honolulu" => "GMT-10 Pacific/Honolulu" , "Pacific/Johnston" => "GMT-10 Pacific/Johnston" , "Pacific/Rarotonga" => "GMT-10 Pacific/Rarotonga" ,
			"Pacific/Tahiti" => "GMT-10 Pacific/Tahiti" , "US/Hawaii" => "GMT-10 US/Hawaii" ,
		) , "GMT-9.5"   => array( "Pacific/Marquesas" => "GMT-9.5 Pacific/Marquesas" , ) , "GMT-9" => array(
			"America/Adak" => "GMT-9 America/Adak" , "America/Atka" => "GMT-9 America/Atka" , "Pacific/Gambier" => "GMT-9 Pacific/Gambier" , "US/Aleutian" => "GMT-9 US/Aleutian" ,
		) , "GMT-8"     => array(
			"America/Anchorage" => "GMT-8 America/Anchorage" , "America/Juneau" => "GMT-8 America/Juneau" , "America/Metlakatla" => "GMT-8 America/Metlakatla" ,
			"America/Nome"      => "GMT-8 America/Nome" , "America/Sitka" => "GMT-8 America/Sitka" , "America/Yakutat" => "GMT-8 America/Yakutat" , "Pacific/Pitcairn" => "GMT-8 Pacific/Pitcairn" ,
			"US/Alaska"         => "GMT-8 US/Alaska" ,
		) , "GMT-7"     => array(
			"America/Creston"   => "GMT-7 America/Creston" , "America/Dawson" => "GMT-7 America/Dawson" , "America/Dawson_Creek" => "GMT-7 America/Dawson_Creek" ,
			"America/Ensenada"  => "GMT-7 America/Ensenada" , "America/Hermosillo" => "GMT-7 America/Hermosillo" , "America/Los_Angeles" => "GMT-7 America/Los_Angeles" ,
			"America/Phoenix"   => "GMT-7 America/Phoenix" , "America/Santa_Isabel" => "GMT-7 America/Santa_Isabel" , "America/Tijuana" => "GMT-7 America/Tijuana" ,
			"America/Vancouver" => "GMT-7 America/Vancouver" , "America/Whitehorse" => "GMT-7 America/Whitehorse" , "Canada/Pacific" => "GMT-7 Canada/Pacific" ,
			"Canada/Yukon"      => "GMT-7 Canada/Yukon" , "Mexico/BajaNorte" => "GMT-7 Mexico/BajaNorte" , "MST" => "GMT-7 MST" , "PST8PDT" => "GMT-7 PST8PDT" , "US/Arizona" => "GMT-7 US/Arizona" ,
			"US/Pacific"        => "GMT-7 US/Pacific" , "US/Pacific-New" => "GMT-7 US/Pacific-New" ,
		) , "GMT-6"     => array(
			"America/Belize"           => "GMT-6 America/Belize" , "America/Boise" => "GMT-6 America/Boise" , "America/Cambridge_Bay" => "GMT-6 America/Cambridge_Bay" ,
			"America/Chihuahua"        => "GMT-6 America/Chihuahua" , "America/Costa_Rica" => "GMT-6 America/Costa_Rica" , "America/Denver" => "GMT-6 America/Denver" ,
			"America/Edmonton"         => "GMT-6 America/Edmonton" , "America/El_Salvador" => "GMT-6 America/El_Salvador" , "America/Guatemala" => "GMT-6 America/Guatemala" ,
			"America/Inuvik"           => "GMT-6 America/Inuvik" , "America/Managua" => "GMT-6 America/Managua" , "America/Mazatlan" => "GMT-6 America/Mazatlan" ,
			"America/Ojinaga"          => "GMT-6 America/Ojinaga" , "America/Regina" => "GMT-6 America/Regina" , "America/Shiprock" => "GMT-6 America/Shiprock" ,
			"America/Swift_Current"    => "GMT-6 America/Swift_Current" , "America/Tegucigalpa" => "GMT-6 America/Tegucigalpa" , "America/Yellowknife" => "GMT-6 America/Yellowknife" ,
			"Canada/East-Saskatchewan" => "GMT-6 Canada/East-Saskatchewan" , "Canada/Mountain" => "GMT-6 Canada/Mountain" , "Canada/Saskatchewan" => "GMT-6 Canada/Saskatchewan" ,
			"Mexico/BajaSur"           => "GMT-6 Mexico/BajaSur" , "MST7MDT" => "GMT-6 MST7MDT" , "Navajo" => "GMT-6 Navajo" , "Pacific/Galapagos" => "GMT-6 Pacific/Galapagos" ,
			"US/Mountain"              => "GMT-6 US/Mountain" ,
		) , "GMT-5"     => array(
			"America/Atikokan"            => "GMT-5 America/Atikokan" , "America/Bahia_Banderas" => "GMT-5 America/Bahia_Banderas" , "America/Bogota" => "GMT-5 America/Bogota" ,
			"America/Cancun"              => "GMT-5 America/Cancun" , "America/Cayman" => "GMT-5 America/Cayman" , "America/Chicago" => "GMT-5 America/Chicago" ,
			"America/Coral_Harbour"       => "GMT-5 America/Coral_Harbour" , "America/Eirunepe" => "GMT-5 America/Eirunepe" , "America/Guayaquil" => "GMT-5 America/Guayaquil" ,
			"America/Indiana/Knox"        => "GMT-5 America/Indiana/Knox" , "America/Indiana/Tell_City" => "GMT-5 America/Indiana/Tell_City" , "America/Jamaica" => "GMT-5 America/Jamaica" ,
			"America/Knox_IN"             => "GMT-5 America/Knox_IN" , "America/Lima" => "GMT-5 America/Lima" , "America/Matamoros" => "GMT-5 America/Matamoros" ,
			"America/Menominee"           => "GMT-5 America/Menominee" , "America/Merida" => "GMT-5 America/Merida" , "America/Mexico_City" => "GMT-5 America/Mexico_City" ,
			"America/Monterrey"           => "GMT-5 America/Monterrey" , "America/North_Dakota/Beulah" => "GMT-5 America/North_Dakota/Beulah" ,
			"America/North_Dakota/Center" => "GMT-5 America/North_Dakota/Center" , "America/North_Dakota/New_Salem" => "GMT-5 America/North_Dakota/New_Salem" ,
			"America/Panama"              => "GMT-5 America/Panama" , "America/Porto_Acre" => "GMT-5 America/Porto_Acre" , "America/Rainy_River" => "GMT-5 America/Rainy_River" ,
			"America/Rankin_Inlet"        => "GMT-5 America/Rankin_Inlet" , "America/Resolute" => "GMT-5 America/Resolute" , "America/Rio_Branco" => "GMT-5 America/Rio_Branco" ,
			"America/Winnipeg"            => "GMT-5 America/Winnipeg" , "Brazil/Acre" => "GMT-5 Brazil/Acre" , "Canada/Central" => "GMT-5 Canada/Central" ,
			"Chile/EasterIsland"          => "GMT-5 Chile/EasterIsland" , "CST6CDT" => "GMT-5 CST6CDT" , "EST" => "GMT-5 EST" , "Jamaica" => "GMT-5 Jamaica" ,
			"Mexico/General"              => "GMT-5 Mexico/General" , "Pacific/Easter" => "GMT-5 Pacific/Easter" , "US/Central" => "GMT-5 US/Central" ,
			"US/Indiana-Starke"           => "GMT-5 US/Indiana-Starke" ,
		) , "GMT-4.5"   => array( "America/Caracas" => "GMT-4.5 America/Caracas" , ) , "GMT-4" => array(
			"America/Anguilla"             => "GMT-4 America/Anguilla" , "America/Antigua" => "GMT-4 America/Antigua" , "America/Aruba" => "GMT-4 America/Aruba" ,
			"America/Asuncion"             => "GMT-4 America/Asuncion" , "America/Barbados" => "GMT-4 America/Barbados" , "America/Blanc-Sablon" => "GMT-4 America/Blanc-Sablon" ,
			"America/Boa_Vista"            => "GMT-4 America/Boa_Vista" , "America/Campo_Grande" => "GMT-4 America/Campo_Grande" , "America/Cuiaba" => "GMT-4 America/Cuiaba" ,
			"America/Curacao"              => "GMT-4 America/Curacao" , "America/Detroit" => "GMT-4 America/Detroit" , "America/Dominica" => "GMT-4 America/Dominica" ,
			"America/Fort_Wayne"           => "GMT-4 America/Fort_Wayne" , "America/Grand_Turk" => "GMT-4 America/Grand_Turk" , "America/Grenada" => "GMT-4 America/Grenada" ,
			"America/Guadeloupe"           => "GMT-4 America/Guadeloupe" , "America/Guyana" => "GMT-4 America/Guyana" , "America/Havana" => "GMT-4 America/Havana" ,
			"America/Indiana/Indianapolis" => "GMT-4 America/Indiana/Indianapolis" , "America/Indiana/Marengo" => "GMT-4 America/Indiana/Marengo" ,
			"America/Indiana/Petersburg"   => "GMT-4 America/Indiana/Petersburg" , "America/Indiana/Vevay" => "GMT-4 America/Indiana/Vevay" ,
			"America/Indiana/Vincennes"    => "GMT-4 America/Indiana/Vincennes" , "America/Indiana/Winamac" => "GMT-4 America/Indiana/Winamac" ,
			"America/Indianapolis"         => "GMT-4 America/Indianapolis" , "America/Iqaluit" => "GMT-4 America/Iqaluit" , "America/Kentucky/Louisville" => "GMT-4 America/Kentucky/Louisville" ,
			"America/Kentucky/Monticello"  => "GMT-4 America/Kentucky/Monticello" , "America/Kralendijk" => "GMT-4 America/Kralendijk" , "America/La_Paz" => "GMT-4 America/La_Paz" ,
			"America/Louisville"           => "GMT-4 America/Louisville" , "America/Lower_Princes" => "GMT-4 America/Lower_Princes" , "America/Manaus" => "GMT-4 America/Manaus" ,
			"America/Marigot"              => "GMT-4 America/Marigot" , "America/Martinique" => "GMT-4 America/Martinique" , "America/Montreal" => "GMT-4 America/Montreal" ,
			"America/Montserrat"           => "GMT-4 America/Montserrat" , "America/Nassau" => "GMT-4 America/Nassau" , "America/New_York" => "GMT-4 America/New_York" ,
			"America/Nipigon"              => "GMT-4 America/Nipigon" , "America/Pangnirtung" => "GMT-4 America/Pangnirtung" , "America/Port-au-Prince" => "GMT-4 America/Port-au-Prince" ,
			"America/Port_of_Spain"        => "GMT-4 America/Port_of_Spain" , "America/Porto_Velho" => "GMT-4 America/Porto_Velho" , "America/Puerto_Rico" => "GMT-4 America/Puerto_Rico" ,
			"America/Santo_Domingo"        => "GMT-4 America/Santo_Domingo" , "America/St_Barthelemy" => "GMT-4 America/St_Barthelemy" , "America/St_Kitts" => "GMT-4 America/St_Kitts" ,
			"America/St_Lucia"             => "GMT-4 America/St_Lucia" , "America/St_Thomas" => "GMT-4 America/St_Thomas" , "America/St_Vincent" => "GMT-4 America/St_Vincent" ,
			"America/Thunder_Bay"          => "GMT-4 America/Thunder_Bay" , "America/Toronto" => "GMT-4 America/Toronto" , "America/Tortola" => "GMT-4 America/Tortola" ,
			"America/Virgin"               => "GMT-4 America/Virgin" , "Brazil/West" => "GMT-4 Brazil/West" , "Canada/Eastern" => "GMT-4 Canada/Eastern" , "Cuba" => "GMT-4 Cuba" ,
			"EST5EDT"                      => "GMT-4 EST5EDT" , "US/East-Indiana" => "GMT-4 US/East-Indiana" , "US/Eastern" => "GMT-4 US/Eastern" , "US/Michigan" => "GMT-4 US/Michigan" ,
		) , "GMT-3"     => array(
			"America/Araguaina"              => "GMT-3 America/Araguaina" , "America/Argentina/Buenos_Aires" => "GMT-3 America/Argentina/Buenos_Aires" ,
			"America/Argentina/Catamarca"    => "GMT-3 America/Argentina/Catamarca" , "America/Argentina/ComodRivadavia" => "GMT-3 America/Argentina/ComodRivadavia" ,
			"America/Argentina/Cordoba"      => "GMT-3 America/Argentina/Cordoba" , "America/Argentina/Jujuy" => "GMT-3 America/Argentina/Jujuy" ,
			"America/Argentina/La_Rioja"     => "GMT-3 America/Argentina/La_Rioja" , "America/Argentina/Mendoza" => "GMT-3 America/Argentina/Mendoza" ,
			"America/Argentina/Rio_Gallegos" => "GMT-3 America/Argentina/Rio_Gallegos" , "America/Argentina/Salta" => "GMT-3 America/Argentina/Salta" ,
			"America/Argentina/San_Juan"     => "GMT-3 America/Argentina/San_Juan" , "America/Argentina/San_Luis" => "GMT-3 America/Argentina/San_Luis" ,
			"America/Argentina/Tucuman"      => "GMT-3 America/Argentina/Tucuman" , "America/Argentina/Ushuaia" => "GMT-3 America/Argentina/Ushuaia" , "America/Bahia" => "GMT-3 America/Bahia" ,
			"America/Belem"                  => "GMT-3 America/Belem" , "America/Buenos_Aires" => "GMT-3 America/Buenos_Aires" , "America/Catamarca" => "GMT-3 America/Catamarca" ,
			"America/Cayenne"                => "GMT-3 America/Cayenne" , "America/Cordoba" => "GMT-3 America/Cordoba" , "America/Fortaleza" => "GMT-3 America/Fortaleza" ,
			"America/Glace_Bay"              => "GMT-3 America/Glace_Bay" , "America/Goose_Bay" => "GMT-3 America/Goose_Bay" , "America/Halifax" => "GMT-3 America/Halifax" ,
			"America/Jujuy"                  => "GMT-3 America/Jujuy" , "America/Maceio" => "GMT-3 America/Maceio" , "America/Mendoza" => "GMT-3 America/Mendoza" ,
			"America/Moncton"                => "GMT-3 America/Moncton" , "America/Montevideo" => "GMT-3 America/Montevideo" , "America/Paramaribo" => "GMT-3 America/Paramaribo" ,
			"America/Recife"                 => "GMT-3 America/Recife" , "America/Rosario" => "GMT-3 America/Rosario" , "America/Santarem" => "GMT-3 America/Santarem" ,
			"America/Santiago"               => "GMT-3 America/Santiago" , "America/Sao_Paulo" => "GMT-3 America/Sao_Paulo" , "America/Thule" => "GMT-3 America/Thule" ,
			"Antarctica/Palmer"              => "GMT-3 Antarctica/Palmer" , "Antarctica/Rothera" => "GMT-3 Antarctica/Rothera" , "Atlantic/Bermuda" => "GMT-3 Atlantic/Bermuda" ,
			"Atlantic/Stanley"               => "GMT-3 Atlantic/Stanley" , "Brazil/East" => "GMT-3 Brazil/East" , "Canada/Atlantic" => "GMT-3 Canada/Atlantic" ,
			"Chile/Continental"              => "GMT-3 Chile/Continental" ,
		) , "GMT-2.5"   => array( "America/St_Johns" => "GMT-2.5 America/St_Johns" , "Canada/Newfoundland" => "GMT-2.5 Canada/Newfoundland" , ) , "GMT-2" => array(
			"America/Godthab"        => "GMT-2 America/Godthab" , "America/Miquelon" => "GMT-2 America/Miquelon" , "America/Noronha" => "GMT-2 America/Noronha" ,
			"Atlantic/South_Georgia" => "GMT-2 Atlantic/South_Georgia" , "Brazil/DeNoronha" => "GMT-2 Brazil/DeNoronha" ,
		) , "GMT-1"     => array( "Atlantic/Cape_Verde" => "GMT-1 Atlantic/Cape_Verde" , ) , "GMT" => array(
			"GMT"                  => "GMT GMT" , "Africa/Abidjan" => "GMT Africa/Abidjan" , "Africa/Accra" => "GMT Africa/Accra" , "Africa/Bamako" => "GMT Africa/Bamako" ,
			"Africa/Banjul"        => "GMT Africa/Banjul" , "Africa/Bissau" => "GMT Africa/Bissau" , "Africa/Conakry" => "GMT Africa/Conakry" , "Africa/Dakar" => "GMT Africa/Dakar" ,
			"Africa/Freetown"      => "GMT Africa/Freetown" , "Africa/Lome" => "GMT Africa/Lome" , "Africa/Monrovia" => "GMT Africa/Monrovia" , "Africa/Nouakchott" => "GMT Africa/Nouakchott" ,
			"Africa/Ouagadougou"   => "GMT Africa/Ouagadougou" , "Africa/Sao_Tome" => "GMT Africa/Sao_Tome" , "Africa/Timbuktu" => "GMT Africa/Timbuktu" ,
			"America/Danmarkshavn" => "GMT America/Danmarkshavn" , "America/Scoresbysund" => "GMT America/Scoresbysund" , "Atlantic/Azores" => "GMT Atlantic/Azores" ,
			"Atlantic/Reykjavik"   => "GMT Atlantic/Reykjavik" , "Atlantic/St_Helena" => "GMT Atlantic/St_Helena" , "Factory" => "GMT Factory" , "Greenwich" => "GMT Greenwich" ,
			"Iceland"              => "GMT Iceland" , "UCT" => "GMT UCT" , "Universal" => "GMT Universal" , "UTC" => "GMT UTC" , "Zulu" => "GMT Zulu" ,
		) , "GMT+1"     => array(
			"Africa/Algiers"    => "GMT+1 Africa/Algiers" , "Africa/Bangui" => "GMT+1 Africa/Bangui" , "Africa/Brazzaville" => "GMT+1 Africa/Brazzaville" ,
			"Africa/Casablanca" => "GMT+1 Africa/Casablanca" , "Africa/Douala" => "GMT+1 Africa/Douala" , "Africa/El_Aaiun" => "GMT+1 Africa/El_Aaiun" , "Africa/Kinshasa" => "GMT+1 Africa/Kinshasa" ,
			"Africa/Lagos"      => "GMT+1 Africa/Lagos" , "Africa/Libreville" => "GMT+1 Africa/Libreville" , "Africa/Luanda" => "GMT+1 Africa/Luanda" , "Africa/Malabo" => "GMT+1 Africa/Malabo" ,
			"Africa/Ndjamena"   => "GMT+1 Africa/Ndjamena" , "Africa/Niamey" => "GMT+1 Africa/Niamey" , "Africa/Porto-Novo" => "GMT+1 Africa/Porto-Novo" , "Africa/Tunis" => "GMT+1 Africa/Tunis" ,
			"Atlantic/Canary"   => "GMT+1 Atlantic/Canary" , "Atlantic/Faeroe" => "GMT+1 Atlantic/Faeroe" , "Atlantic/Faroe" => "GMT+1 Atlantic/Faroe" ,
			"Atlantic/Madeira"  => "GMT+1 Atlantic/Madeira" , "Eire" => "GMT+1 Eire" , "Europe/Belfast" => "GMT+1 Europe/Belfast" , "Europe/Dublin" => "GMT+1 Europe/Dublin" ,
			"Europe/Guernsey"   => "GMT+1 Europe/Guernsey" , "Europe/Isle_of_Man" => "GMT+1 Europe/Isle_of_Man" , "Europe/Jersey" => "GMT+1 Europe/Jersey" , "Europe/Lisbon" => "GMT+1 Europe/Lisbon" ,
			"Europe/London"     => "GMT+1 Europe/London" , "GB" => "GMT+1 GB" , "GB-Eire" => "GMT+1 GB-Eire" , "Portugal" => "GMT+1 Portugal" , "WET" => "GMT+1 WET" ,
		) , "GMT+2"     => array(
			"Africa/Blantyre"     => "GMT+2 Africa/Blantyre" , "Africa/Bujumbura" => "GMT+2 Africa/Bujumbura" , "Africa/Ceuta" => "GMT+2 Africa/Ceuta" , "Africa/Gaborone" => "GMT+2 Africa/Gaborone" ,
			"Africa/Harare"       => "GMT+2 Africa/Harare" , "Africa/Johannesburg" => "GMT+2 Africa/Johannesburg" , "Africa/Kigali" => "GMT+2 Africa/Kigali" ,
			"Africa/Lubumbashi"   => "GMT+2 Africa/Lubumbashi" , "Africa/Lusaka" => "GMT+2 Africa/Lusaka" , "Africa/Maputo" => "GMT+2 Africa/Maputo" , "Africa/Maseru" => "GMT+2 Africa/Maseru" ,
			"Africa/Mbabane"      => "GMT+2 Africa/Mbabane" , "Africa/Tripoli" => "GMT+2 Africa/Tripoli" , "Africa/Windhoek" => "GMT+2 Africa/Windhoek" ,
			"Arctic/Longyearbyen" => "GMT+2 Arctic/Longyearbyen" , "Atlantic/Jan_Mayen" => "GMT+2 Atlantic/Jan_Mayen" , "CET" => "GMT+2 CET" , "Europe/Amsterdam" => "GMT+2 Europe/Amsterdam" ,
			"Europe/Andorra"      => "GMT+2 Europe/Andorra" , "Europe/Belgrade" => "GMT+2 Europe/Belgrade" , "Europe/Berlin" => "GMT+2 Europe/Berlin" ,
			"Europe/Bratislava"   => "GMT+2 Europe/Bratislava" , "Europe/Brussels" => "GMT+2 Europe/Brussels" , "Europe/Budapest" => "GMT+2 Europe/Budapest" ,
			"Europe/Copenhagen"   => "GMT+2 Europe/Copenhagen" , "Europe/Gibraltar" => "GMT+2 Europe/Gibraltar" , "Europe/Ljubljana" => "GMT+2 Europe/Ljubljana" ,
			"Europe/Luxembourg"   => "GMT+2 Europe/Luxembourg" , "Europe/Madrid" => "GMT+2 Europe/Madrid" , "Europe/Malta" => "GMT+2 Europe/Malta" , "Europe/Monaco" => "GMT+2 Europe/Monaco" ,
			"Europe/Oslo"         => "GMT+2 Europe/Oslo" , "Europe/Paris" => "GMT+2 Europe/Paris" , "Europe/Podgorica" => "GMT+2 Europe/Podgorica" , "Europe/Prague" => "GMT+2 Europe/Prague" ,
			"Europe/Rome"         => "GMT+2 Europe/Rome" , "Europe/San_Marino" => "GMT+2 Europe/San_Marino" , "Europe/Sarajevo" => "GMT+2 Europe/Sarajevo" , "Europe/Skopje" => "GMT+2 Europe/Skopje" ,
			"Europe/Stockholm"    => "GMT+2 Europe/Stockholm" , "Europe/Tirane" => "GMT+2 Europe/Tirane" , "Europe/Vaduz" => "GMT+2 Europe/Vaduz" , "Europe/Vatican" => "GMT+2 Europe/Vatican" ,
			"Europe/Vienna"       => "GMT+2 Europe/Vienna" , "Europe/Warsaw" => "GMT+2 Europe/Warsaw" , "Europe/Zagreb" => "GMT+2 Europe/Zagreb" , "Europe/Zurich" => "GMT+2 Europe/Zurich" ,
			"Libya"               => "GMT+2 Libya" , "MET" => "GMT+2 MET" , "Poland" => "GMT+2 Poland" ,
		) , "GMT+3"     => array(
			"Africa/Addis_Ababa"   => "GMT+3 Africa/Addis_Ababa" , "Africa/Asmara" => "GMT+3 Africa/Asmara" , "Africa/Asmera" => "GMT+3 Africa/Asmera" , "Africa/Cairo" => "GMT+3 Africa/Cairo" ,
			"Africa/Dar_es_Salaam" => "GMT+3 Africa/Dar_es_Salaam" , "Africa/Djibouti" => "GMT+3 Africa/Djibouti" , "Africa/Juba" => "GMT+3 Africa/Juba" , "Africa/Kampala" => "GMT+3 Africa/Kampala" ,
			"Africa/Khartoum"      => "GMT+3 Africa/Khartoum" , "Africa/Mogadishu" => "GMT+3 Africa/Mogadishu" , "Africa/Nairobi" => "GMT+3 Africa/Nairobi" ,
			"Antarctica/Syowa"     => "GMT+3 Antarctica/Syowa" , "Asia/Aden" => "GMT+3 Asia/Aden" , "Asia/Amman" => "GMT+3 Asia/Amman" , "Asia/Baghdad" => "GMT+3 Asia/Baghdad" ,
			"Asia/Bahrain"         => "GMT+3 Asia/Bahrain" , "Asia/Beirut" => "GMT+3 Asia/Beirut" , "Asia/Damascus" => "GMT+3 Asia/Damascus" , "Asia/Gaza" => "GMT+3 Asia/Gaza" ,
			"Asia/Hebron"          => "GMT+3 Asia/Hebron" , "Asia/Istanbul" => "GMT+3 Asia/Istanbul" , "Asia/Jerusalem" => "GMT+3 Asia/Jerusalem" , "Asia/Kuwait" => "GMT+3 Asia/Kuwait" ,
			"Asia/Nicosia"         => "GMT+3 Asia/Nicosia" , "Asia/Qatar" => "GMT+3 Asia/Qatar" , "Asia/Riyadh" => "GMT+3 Asia/Riyadh" , "Asia/Tel_Aviv" => "GMT+3 Asia/Tel_Aviv" ,
			"EET"                  => "GMT+3 EET" , "Egypt" => "GMT+3 Egypt" , "Europe/Athens" => "GMT+3 Europe/Athens" , "Europe/Bucharest" => "GMT+3 Europe/Bucharest" ,
			"Europe/Chisinau"      => "GMT+3 Europe/Chisinau" , "Europe/Helsinki" => "GMT+3 Europe/Helsinki" , "Europe/Istanbul" => "GMT+3 Europe/Istanbul" ,
			"Europe/Kaliningrad"   => "GMT+3 Europe/Kaliningrad" , "Europe/Kiev" => "GMT+3 Europe/Kiev" , "Europe/Mariehamn" => "GMT+3 Europe/Mariehamn" , "Europe/Minsk" => "GMT+3 Europe/Minsk" ,
			"Europe/Nicosia"       => "GMT+3 Europe/Nicosia" , "Europe/Riga" => "GMT+3 Europe/Riga" , "Europe/Sofia" => "GMT+3 Europe/Sofia" , "Europe/Tallinn" => "GMT+3 Europe/Tallinn" ,
			"Europe/Tiraspol"      => "GMT+3 Europe/Tiraspol" , "Europe/Uzhgorod" => "GMT+3 Europe/Uzhgorod" , "Europe/Vilnius" => "GMT+3 Europe/Vilnius" ,
			"Europe/Zaporozhye"    => "GMT+3 Europe/Zaporozhye" , "Indian/Antananarivo" => "GMT+3 Indian/Antananarivo" , "Indian/Comoro" => "GMT+3 Indian/Comoro" ,
			"Indian/Mayotte"       => "GMT+3 Indian/Mayotte" , "Israel" => "GMT+3 Israel" , "Turkey" => "GMT+3 Turkey" ,
		) , "GMT+4"     => array(
			"Asia/Dubai"    => "GMT+4 Asia/Dubai" , "Asia/Muscat" => "GMT+4 Asia/Muscat" , "Asia/Tbilisi" => "GMT+4 Asia/Tbilisi" , "Asia/Yerevan" => "GMT+4 Asia/Yerevan" ,
			"Europe/Moscow" => "GMT+4 Europe/Moscow" , "Europe/Samara" => "GMT+4 Europe/Samara" , "Europe/Simferopol" => "GMT+4 Europe/Simferopol" , "Europe/Volgograd" => "GMT+4 Europe/Volgograd" ,
			"Indian/Mahe"   => "GMT+4 Indian/Mahe" , "Indian/Mauritius" => "GMT+4 Indian/Mauritius" , "Indian/Reunion" => "GMT+4 Indian/Reunion" , "W-SU" => "GMT+4 W-SU" ,
		) , "GMT+4.5"   => array( "Asia/Kabul" => "GMT+4.5 Asia/Kabul" , "Asia/Tehran" => "GMT+4.5 Asia/Tehran" , "Iran" => "GMT+4.5 Iran" , ) , "GMT+5" => array(
			"Antarctica/Mawson" => "GMT+5 Antarctica/Mawson" , "Asia/Aqtau" => "GMT+5 Asia/Aqtau" , "Asia/Aqtobe" => "GMT+5 Asia/Aqtobe" , "Asia/Ashgabat" => "GMT+5 Asia/Ashgabat" ,
			"Asia/Ashkhabad"    => "GMT+5 Asia/Ashkhabad" , "Asia/Baku" => "GMT+5 Asia/Baku" , "Asia/Dushanbe" => "GMT+5 Asia/Dushanbe" , "Asia/Karachi" => "GMT+5 Asia/Karachi" ,
			"Asia/Oral"         => "GMT+5 Asia/Oral" , "Asia/Samarkand" => "GMT+5 Asia/Samarkand" , "Asia/Tashkent" => "GMT+5 Asia/Tashkent" , "Indian/Kerguelen" => "GMT+5 Indian/Kerguelen" ,
			"Indian/Maldives"   => "GMT+5 Indian/Maldives" ,
		) , "GMT+5.5"   => array( "Asia/Calcutta" => "GMT+5.5 Asia/Calcutta" , "Asia/Colombo" => "GMT+5.5 Asia/Colombo" , "Asia/Kolkata" => "GMT+5.5 Asia/Kolkata" , ) ,
		"GMT+5.75"      => array( "Asia/Kathmandu" => "GMT+5.75 Asia/Kathmandu" , "Asia/Katmandu" => "GMT+5.75 Asia/Katmandu" , ) , "GMT+6" => array(
			"Antarctica/Vostok"  => "GMT+6 Antarctica/Vostok" , "Asia/Almaty" => "GMT+6 Asia/Almaty" , "Asia/Bishkek" => "GMT+6 Asia/Bishkek" , "Asia/Dacca" => "GMT+6 Asia/Dacca" ,
			"Asia/Dhaka"         => "GMT+6 Asia/Dhaka" , "Asia/Qyzylorda" => "GMT+6 Asia/Qyzylorda" , "Asia/Thimbu" => "GMT+6 Asia/Thimbu" , "Asia/Thimphu" => "GMT+6 Asia/Thimphu" ,
			"Asia/Yekaterinburg" => "GMT+6 Asia/Yekaterinburg" , "Indian/Chagos" => "GMT+6 Indian/Chagos" ,
		) , "GMT+6.5"   => array( "Asia/Rangoon" => "GMT+6.5 Asia/Rangoon" , "Indian/Cocos" => "GMT+6.5 Indian/Cocos" , ) , "GMT+7" => array(
			"Antarctica/Davis" => "GMT+7 Antarctica/Davis" , "Asia/Bangkok" => "GMT+7 Asia/Bangkok" , "Asia/Ho_Chi_Minh" => "GMT+7 Asia/Ho_Chi_Minh" , "Asia/Hovd" => "GMT+7 Asia/Hovd" ,
			"Asia/Jakarta"     => "GMT+7 Asia/Jakarta" , "Asia/Novokuznetsk" => "GMT+7 Asia/Novokuznetsk" , "Asia/Novosibirsk" => "GMT+7 Asia/Novosibirsk" , "Asia/Omsk" => "GMT+7 Asia/Omsk" ,
			"Asia/Phnom_Penh"  => "GMT+7 Asia/Phnom_Penh" , "Asia/Pontianak" => "GMT+7 Asia/Pontianak" , "Asia/Saigon" => "GMT+7 Asia/Saigon" , "Asia/Vientiane" => "GMT+7 Asia/Vientiane" ,
			"Indian/Christmas" => "GMT+7 Indian/Christmas" ,
		) , "GMT+8"     => array(
			"Antarctica/Casey" => "GMT+8 Antarctica/Casey" , "Asia/Brunei" => "GMT+8 Asia/Brunei" , "Asia/Choibalsan" => "GMT+8 Asia/Choibalsan" , "Asia/Chongqing" => "GMT+8 Asia/Chongqing" ,
			"Asia/Chungking"   => "GMT+8 Asia/Chungking" , "Asia/Harbin" => "GMT+8 Asia/Harbin" , "Asia/Hong_Kong" => "GMT+8 Asia/Hong_Kong" , "Asia/Kashgar" => "GMT+8 Asia/Kashgar" ,
			"Asia/Krasnoyarsk" => "GMT+8 Asia/Krasnoyarsk" , "Asia/Kuala_Lumpur" => "GMT+8 Asia/Kuala_Lumpur" , "Asia/Kuching" => "GMT+8 Asia/Kuching" , "Asia/Macao" => "GMT+8 Asia/Macao" ,
			"Asia/Macau"       => "GMT+8 Asia/Macau" , "Asia/Makassar" => "GMT+8 Asia/Makassar" , "Asia/Manila" => "GMT+8 Asia/Manila" , "Asia/Shanghai" => "GMT+8 Asia/Shanghai" ,
			"Asia/Singapore"   => "GMT+8 Asia/Singapore" , "Asia/Taipei" => "GMT+8 Asia/Taipei" , "Asia/Ujung_Pandang" => "GMT+8 Asia/Ujung_Pandang" , "Asia/Ulaanbaatar" => "GMT+8 Asia/Ulaanbaatar" ,
			"Asia/Ulan_Bator"  => "GMT+8 Asia/Ulan_Bator" , "Asia/Urumqi" => "GMT+8 Asia/Urumqi" , "Australia/Perth" => "GMT+8 Australia/Perth" , "Australia/West" => "GMT+8 Australia/West" ,
			"Hongkong"         => "GMT+8 Hongkong" , "PRC" => "GMT+8 PRC" , "ROC" => "GMT+8 ROC" , "Singapore" => "GMT+8 Singapore" ,
		) , "GMT+8.75"  => array( "Australia/Eucla" => "GMT+8.75 Australia/Eucla" , ) , "GMT+9" => array(
			"Asia/Dili"  => "GMT+9 Asia/Dili" , "Asia/Irkutsk" => "GMT+9 Asia/Irkutsk" , "Asia/Jayapura" => "GMT+9 Asia/Jayapura" , "Asia/Pyongyang" => "GMT+9 Asia/Pyongyang" ,
			"Asia/Seoul" => "GMT+9 Asia/Seoul" , "Asia/Tokyo" => "GMT+9 Asia/Tokyo" , "Japan" => "GMT+9 Japan" , "Pacific/Palau" => "GMT+9 Pacific/Palau" , "ROK" => "GMT+9 ROK" ,
		) , "GMT+9.5"   => array(
			"Australia/Adelaide" => "GMT+9.5 Australia/Adelaide" , "Australia/Broken_Hill" => "GMT+9.5 Australia/Broken_Hill" , "Australia/Darwin" => "GMT+9.5 Australia/Darwin" ,
			"Australia/North"    => "GMT+9.5 Australia/North" , "Australia/South" => "GMT+9.5 Australia/South" , "Australia/Yancowinna" => "GMT+9.5 Australia/Yancowinna" ,
		) , "GMT+10"    => array(
			"Antarctica/DumontDUrville" => "GMT+10 Antarctica/DumontDUrville" , "Asia/Yakutsk" => "GMT+10 Asia/Yakutsk" , "Australia/ACT" => "GMT+10 Australia/ACT" ,
			"Australia/Brisbane"        => "GMT+10 Australia/Brisbane" , "Australia/Canberra" => "GMT+10 Australia/Canberra" , "Australia/Currie" => "GMT+10 Australia/Currie" ,
			"Australia/Hobart"          => "GMT+10 Australia/Hobart" , "Australia/Lindeman" => "GMT+10 Australia/Lindeman" , "Australia/Melbourne" => "GMT+10 Australia/Melbourne" ,
			"Australia/NSW"             => "GMT+10 Australia/NSW" , "Australia/Queensland" => "GMT+10 Australia/Queensland" , "Australia/Sydney" => "GMT+10 Australia/Sydney" ,
			"Australia/Tasmania"        => "GMT+10 Australia/Tasmania" , "Australia/Victoria" => "GMT+10 Australia/Victoria" , "Pacific/Chuuk" => "GMT+10 Pacific/Chuuk" ,
			"Pacific/Guam"              => "GMT+10 Pacific/Guam" , "Pacific/Port_Moresby" => "GMT+10 Pacific/Port_Moresby" , "Pacific/Saipan" => "GMT+10 Pacific/Saipan" ,
			"Pacific/Truk"              => "GMT+10 Pacific/Truk" , "Pacific/Yap" => "GMT+10 Pacific/Yap" ,
		) , "GMT+10.5"  => array( "Australia/LHI" => "GMT+10.5 Australia/LHI" , "Australia/Lord_Howe" => "GMT+10.5 Australia/Lord_Howe" , ) , "GMT+11" => array(
			"Antarctica/Macquarie" => "GMT+11 Antarctica/Macquarie" , "Asia/Sakhalin" => "GMT+11 Asia/Sakhalin" , "Asia/Vladivostok" => "GMT+11 Asia/Vladivostok" ,
			"Pacific/Efate"        => "GMT+11 Pacific/Efate" , "Pacific/Guadalcanal" => "GMT+11 Pacific/Guadalcanal" , "Pacific/Kosrae" => "GMT+11 Pacific/Kosrae" ,
			"Pacific/Noumea"       => "GMT+11 Pacific/Noumea" , "Pacific/Pohnpei" => "GMT+11 Pacific/Pohnpei" , "Pacific/Ponape" => "GMT+11 Pacific/Ponape" ,
		) , "GMT+11.5"  => array( "Pacific/Norfolk" => "GMT+11.5 Pacific/Norfolk" , ) , "GMT+12" => array(
			"Antarctica/McMurdo" => "GMT+12 Antarctica/McMurdo" , "Antarctica/South_Pole" => "GMT+12 Antarctica/South_Pole" , "Asia/Anadyr" => "GMT+12 Asia/Anadyr" ,
			"Asia/Kamchatka"     => "GMT+12 Asia/Kamchatka" , "Asia/Magadan" => "GMT+12 Asia/Magadan" , "Kwajalein" => "GMT+12 Kwajalein" , "NZ" => "GMT+12 NZ" ,
			"Pacific/Auckland"   => "GMT+12 Pacific/Auckland" , "Pacific/Fiji" => "GMT+12 Pacific/Fiji" , "Pacific/Funafuti" => "GMT+12 Pacific/Funafuti" ,
			"Pacific/Kwajalein"  => "GMT+12 Pacific/Kwajalein" , "Pacific/Majuro" => "GMT+12 Pacific/Majuro" , "Pacific/Nauru" => "GMT+12 Pacific/Nauru" , "Pacific/Tarawa" => "GMT+12 Pacific/Tarawa" ,
			"Pacific/Wake"       => "GMT+12 Pacific/Wake" , "Pacific/Wallis" => "GMT+12 Pacific/Wallis" ,
		) , "GMT+12.75" => array( "NZ-CHAT" => "GMT+12.75 NZ-CHAT" , "Pacific/Chatham" => "GMT+12.75 Pacific/Chatham" , ) , "GMT+13" => array(
			"Pacific/Apia"      => "GMT+13 Pacific/Apia" , "Pacific/Enderbury" => "GMT+13 Pacific/Enderbury" , "Pacific/Fakaofo" => "GMT+13 Pacific/Fakaofo" ,
			"Pacific/Tongatapu" => "GMT+13 Pacific/Tongatapu" ,
		) , "GMT+14"    => array( "Pacific/Kiritimati" => "GMT+14 Pacific/Kiritimati" , ) ,
	);

	/* Defining Colors */
	$wpvr_colors = array(
		'sourceServices' => array(
			'youtube'     => '#CA3B27' ,
			'dailymotion' => '#00669d' ,
			'vimeo'       => '#1ab7ea' ,
			'unknown'     => '#666' ,
		) ,
		'sourceTypes'    => array(
			'playlist' => '#90AC00' ,
			'channel'  => '#27A9CA' ,
			'videos'   => '#4E4E4E' ,
			'search'   => '#E69C00' ,
			'trends'   => '#CA3B27' ,
			'none'     => '#1AB7EA' ,
			'group_'   => 'yellowgreen' ,
			'user'     => 'rgb(95, 158, 160)' ,
			'page'     => '#1B7694' ,
		) ,
		'status'         => array(
			'draft'    => '#90AC00' ,
			'publish'  => '#65C6BB' ,
			'trash'    => '#A7A7A7' ,
			'pending'  => '#E69C00' ,
			'invalid'  => '#90AC00' ,
			'deferred' => '#6D6D6D' ,
		) ,
		'sourceStates'   => array(
			'active'   => '#B1C901' ,
			'inactive' => '#CBCEB5' ,
		) ,
	);

	/* New Video Services */
	//$wpvr_vs = array();
	//$wpvr_vs = apply_filters('wpvr_extend_video_services', $wpvr_vs);

	//new dBug( $wpvr_vs );


	/* Video Services */
	$wpvr_services = array(
		'youtube'     => array(
			'label' => 'Youtube' ,
			'icon'  => 'yt' ,
			'color' => '#CA3B27' ,
		) ,
		'vimeo'       => array(
			'label' => 'Vimeo' ,
			'icon'  => 'vm' ,
			'color' => '#1ab7ea' ,
		) ,
		'dailymotion' => array(
			'label' => 'Daily Motion' ,
			'icon'  => 'dm' ,
			'color' => '#FF7E00' ,
		) ,
		'unknown'     => array(
			'label'    => 'Unknown Service' ,
			'icon'     => 'us' ,
			'color'    => '#666' ,
			'skipThis' => true ,
		) ,
	);

	//$wpvr_services = apply_filters( 'wpvr_extend_video_services' , $wpvr_services );


	/* Defining Video Services Types */
	$wpvr_types_ = array(
		'search'      => array(
			'label' => 'Search' ,
			'icon'  => 'fa-search' ,
			'color' => $wpvr_services[ 'youtube' ][ 'color' ] ,
		) ,
		'search_vo'   => array(
			'label' => 'Search' ,
			'icon'  => 'fa-search' ,
			'color' => $wpvr_services[ 'vimeo' ][ 'color' ] ,
		) ,
		'search_dm'   => array(
			'label' => 'Search' ,
			'icon'  => 'fa-search' ,
			'color' => $wpvr_services[ 'dailymotion' ][ 'color' ] ,
		) ,
		'trendy'      => array(
			'label' => 'Trends' ,
			'icon'  => 'fa-trophy' ,
			'color' => $wpvr_services[ 'youtube' ][ 'color' ] ,
		) ,
		'trendy_dm'   => array(
			'label' => 'Trends' ,
			'icon'  => 'fa-trophy' ,
			'color' => $wpvr_services[ 'dailymotion' ][ 'color' ] ,
		) ,
		'playlist'    => array(
			'label' => 'Playlists' ,
			'icon'  => 'fa-play-circle' ,
			'color' => $wpvr_services[ 'youtube' ][ 'color' ] ,
		) ,
		'playlist_dm' => array(
			'label' => 'Playlists' ,
			'icon'  => 'fa-play-circle' ,
			'color' => $wpvr_services[ 'dailymotion' ][ 'color' ] ,
		) ,
		'group_vo'    => array(
			'label' => 'Groups' ,
			'icon'  => 'fa-users' ,
			'color' => $wpvr_services[ 'vimeo' ][ 'color' ] ,
		) ,
		'group_dm'    => array(
			'label' => 'Groups' ,
			'icon'  => 'fa-users' ,
			'color' => $wpvr_services[ 'dailymotion' ][ 'color' ] ,
		) ,
		'channel'     => array(
			'label' => 'Channels' ,
			'icon'  => 'fa-desktop' ,
			'color' => $wpvr_services[ 'youtube' ][ 'color' ] ,
		) ,
		'user_vo'     => array(
			'label' => 'Users' ,
			'icon'  => 'fa-user' ,
			'color' => $wpvr_services[ 'vimeo' ][ 'color' ] ,
		) ,
		'channel_vo'  => array(
			'label' => 'Channels' ,
			'icon'  => 'fa-desktop' ,
			'color' => $wpvr_services[ 'vimeo' ][ 'color' ] ,
		) ,
		'channel_dm'  => array(
			'label' => 'Channels' ,
			'icon'  => 'fa-desktop' ,
			'color' => $wpvr_services[ 'dailymotion' ][ 'color' ] ,
		) ,
		'videos'      => array(
			'label' => 'Videos' ,
			'icon'  => 'fa-film' ,
			'color' => $wpvr_services[ 'youtube' ][ 'color' ] ,
		) ,
		'videos_dm'   => array(
			'label' => 'Videos' ,
			'icon'  => 'fa-film' ,
			'color' => $wpvr_services[ 'dailymotion' ][ 'color' ] ,
		) ,
		'videos_vo'   => array(
			'label' => 'Videos' ,
			'icon'  => 'fa-film' ,
			'color' => $wpvr_services[ 'vimeo' ][ 'color' ] ,
		) ,
	);

	/*  ???? */
	$wpvr_types = array(
		'search'      => 'Search' ,
		'search_vo'   => 'Search' ,
		'search_dm'   => 'Search' ,
		'trendy'      => 'Trends' ,
		'trendy_dm'   => 'Trends' ,
		'playlist'    => 'Playlist' ,
		'playlist_dm' => 'Playlist' ,
		'group_vo'    => 'Group' ,
		'group_dm'    => 'Group' ,
		'channel'     => 'Channel' ,
		'channel_vo'  => 'Channel' ,
		'channel_dm'  => 'Channel' ,
		'videos'      => 'Videos' ,
		'videos_dm'   => 'Videos' ,
		'videos_vo'   => 'Videos' ,
	);

	/* DEfining Status */
	$wpvr_status = array(
		'draft'   => array(
			'label' => __( 'Draft' , WPVR_LANG ) ,
			'icon'  => 'fa-thumb-tack' ,
			'color' => '#7f8c8d' ,
		) ,
		'publish' => array(
			'label' => __( 'Published' , WPVR_LANG ) ,
			'icon'  => 'fa-check-square' ,
			'color' => '#2ECC71' ,
		) ,
		'pending' => array(
			'label' => __( 'Pending' , WPVR_LANG ) ,
			'icon'  => 'fa-bell' ,
			'color' => '#A55800' ,
		) ,
		'trash'   => array(
			'label' => __( 'Trash' , WPVR_LANG ) ,
			'icon'  => 'fa-trash' ,
			'color' => '#222222' ,
		) ,
		'invalid' => array(
			'label' => __( 'Invalid' , WPVR_LANG ) ,
			'icon'  => 'fa-exclamation-circle' ,
			'color' => '#F62459' ,
		) ,
	);

	/* dataFiller Names */
	$wpvr_filler_data = array(
		'wpvr_video_id'                => __( 'Video ID' , WPVR_LANG ) ,
		'wpvr_dynamic_views'           => __( 'Dynamic Video Views' , WPVR_LANG ) ,
		'wpvr_video_service'           => __( 'Video Service' , WPVR_LANG ) ,
		'wpvr_video_service_url'       => __( 'Video URL' , WPVR_LANG ) ,
		'wpvr_video_service_url_https' => __( 'Video URL (https)' , WPVR_LANG ) ,
		'wpvr_video_embed_code'        => __( 'Video Embed Code' , WPVR_LANG ) ,
		'wpvr_video_service_thumb'     => __( 'Video Thumbnail' , WPVR_LANG ) ,
		'wpvr_video_service_duration'  => __( 'Video Duration' , WPVR_LANG ) ,
		'wpvr_video_service_views'     => __( 'Video Original Views' , WPVR_LANG ) ,
	);

	/**************************    STATIC *****************************************************/


	/******************************* DYNAMIC ****************************************/
	/* CPT used by other plugins WPVR shouldnt interact with */
	$wpvr_private_cpt = array(
		//'',

		'page' ,
		'it_the_reviews' ,
		'it_sample_library_re' ,
		'it_books___epubs' ,
		'it_resources' ,
		'it_gear___hardware' ,
		'it_apps___software' ,
		'wpcf7_contact_form' ,


		//Music Private Custom Post Types
		'albums' ,
		'music' ,
		'any' ,

		//Woocommerce Private Custom Post Types
		'product' ,
		'product-category' ,
		'shop_webhook' ,

		//bbPress Private Custom Post Types
		'topic' ,
		'reply' ,
		'forum' ,

		//Amazon Auto Links
		'aal_auto_insert' ,
	);


	/* Getting Installed Plugins */
	if( ! function_exists( 'get_plugins' ) ) require_once ABSPATH . 'wp-admin/includes/plugin.php';
	$wpvr_all_plugins = get_plugins();

	//d( $wpvr_all_plugins );

	/******************************* DYNAMIC ****************************************/