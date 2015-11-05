<?php

use \Curl\MultiCurl;

function load_page_data($queries) {
	$GLOBALS['load_page_return'] = array();

	if(isset($queries['SalesForce'])) {
		$GLOBALS['load_page_return']['SalesForce'] = array();
	}

	if(isset($queries['ShareFile'])) {
		$GLOBALS['load_page_return']['ShareFile'] = array();
	}

	$sforce_multi_curl	= new MultiCurl();
	$sfile_multi_curl	= new MultiCurl();

	// SalesForce handler
	$sforce_multi_curl->success(function($instance) {
		$response = $instance->response;
		if(SalesForce::is_valid_session($response)) {
			if(isset($response->records[0])) {
				array_push($GLOBALS['load_page_return']['SalesForce'], $response->records[0]);
			}
		} else {
			return false;
		}
	});

	// ShareFile handler
	$sfile_multi_curl->success(function($instance) {
		$response = $instance->response;

		if(!empty($response->Results)) {
			array_push($GLOBALS['load_page_return']['ShareFile'], array($response->Results[0]->Details => $response->Results[0]->ItemID));
		}
	});

	// SalesForce
	$sforce_oauth_token = get_option('sforce_oauth_token');
	if(isset($queries['SalesForce'])) {
		foreach($queries['SalesForce'] as $object_name => $filters) {
			foreach($filters as $filter_name => $fields) {
				$query = urlencode("SELECT " . implode(',', $fields) . " FROM " . $object_name . " WHERE " . stripcslashes($filter_name));
				$url = SalesForce::get_api_base() . '/query/?q=' . $query;
				
				$sforce_multi_curl->setHeader('Authorization', 'Bearer ' . $sforce_oauth_token);
				$sforce_multi_curl->addGet($url);
			}
		}
	}

	// ShareFile
	$user_id = get_current_user_id();
	$parent_folder = get_user_meta($user_id,'sfile_id', true);
	$sfile_oauth_token = get_option('sfile_oauth_token');
	$sfile_api_url_base = get_option('sfile_api_url_base');

	if(isset($queries['ShareFile'])) {
		foreach($queries['ShareFile'] as $sub_folder => $files) {
			if(ShareFile::get_item_id($sub_folder)) {
				foreach($files as $file) {
					$url  = $sfile_api_url_base . "/sf/v3/Items/AdvancedSimpleSearch";

					$query = array(
						'Query' => array(
							"ParentID"		=> $parent_folder,
							"SearchQuery"	=> $file,
							"ItemNameOnly"	=> false 
						)
					);
					$data = json_encode($query);

					$sfile_multi_curl->setHeader('Authorization', 'Bearer ' . $sfile_oauth_token);
					$sfile_multi_curl->setHeader('Content-Type', 'application/json');
					$sfile_multi_curl->addPost($url, $data);
				}
			} else {
				ShareFile::create_folder($sub_folder, '');
			}
		}
	}

	$sforce_multi_curl->start();
	$sfile_multi_curl->start();

	return $GLOBALS['load_page_return'];
}