<?php

use \Curl\MultiCurl;

function save_page_data($queries) {
	$GLOBALS['save_page_return'] = array();

	$multi_curl = new MultiCurl();

	$multi_curl->success(function($instance) {

		if($instance->http_status_code == '204')
			$response = array('status' => 'success');
		else
			$response = array('status' => 'error');

		array_push($GLOBALS['save_page_return'], $response);
	});

	$multi_curl->setHeader('Authorization', 'Bearer ' . get_option('sforce_oauth_token'));
	$multi_curl->setHeader('Content-Type', 'application/json');

	foreach($queries as $api_endpoint => $fields) {
		$url = get_option('sforce_instance_url') . $api_endpoint;
		$fields_json = json_encode($fields, JSON_FORCE_OBJECT);


		$multi_curl->addPatch($url, $fields_json);
	}

	$multi_curl->start();

	return $GLOBALS['save_page_return'];
}