<?php

use \Curl\MultiCurl;

function init_record($queries) {
	$GLOBALS['init_record_return'] = array();

	if(isset($queries['SalesForce'])) {
		$GLOBALS['init_record_return']['SalesForce'] = array();
	}

	$sforce_multi_curl	= new MultiCurl();

	// SalesForce handler
	$sforce_multi_curl->success(function($instance) {
		$response = $instance->response;
		if(SalesForce::is_valid_session($response)) {
			if(isset($response->records[0])) {
				array_push($GLOBALS['init_record_return']['SalesForce'], $response->records[0]);
			}
		} else {
			return false;
		}
	});

	$user_id = get_current_user_id();
	$account_id = get_user_meta($user_id, 'sforce_account_id', true);

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

	$sforce_multi_curl->start();

	return $GLOBALS['init_record_return'];
}