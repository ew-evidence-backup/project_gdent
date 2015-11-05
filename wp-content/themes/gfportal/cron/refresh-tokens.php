<?php

define('SHORTINIT', true);

use \Curl\Curl;

include_once '../../../../wp-load.php';
include_once ABSPATH . WPINC . '/formatting.php';
include_once '../../../mu-plugins/gf-library/api/salesforce.php';
include_once '../../../mu-plugins/gf-library/api/sharefile.php';
include_once '../../../mu-plugins/gf-library/api/gf-config.php';
include_once '../../../mu-plugins/gf-library/vendor/php-curl-class/src/Curl/Curl.php';

if(!isset($_GET['id']) || $_GET['id'] != CRON_SECRET)
	exit();

function of_get_option($name, $default = false) {
	$optionsframework_settings = get_option('optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if(get_option($option_name)) {
		$options = get_option($option_name);
	}
		
	if(isset($options[$name])) {
		return $options[$name];
	} else {
		return $default;
	}
}

$environment = of_get_option('sforce_instance');

if($environment == 'sandbox')
	$sf_instance_url = 'https://test.salesforce.com/services/oauth2/token';
else
	$sf_instance_url = 'https://login.salesforce.com/services/oauth2/token';

$curl = new Curl();

$response = $curl->post($sf_instance_url, array(
	'grant_type'    => 'password',
	'client_id'     => SFORCE_CLIENT_ID,
	'client_secret' => SFORCE_CLIENT_SECRET,
	'username'      => ($environment == 'sandbox' ? SFORCE_STAGING_USER : SFORCE_PRODUCTION_USER),
	'password'      => ($environment == 'sandbox' ? SFORCE_STAGING_PASSWORD : SFORCE_PRODUCTION_PASSWORD)
));

$curl->close();

if(isset($response->access_token) && isset($response->instance_url)) {
	update_option('sforce_instance', $environment);
	update_option('sforce_oauth_token', $response->access_token);
	update_option('sforce_instance_url', $response->instance_url);
} else {
	delete_option('sforce_instance');
	delete_option('sforce_oauth_token');
	delete_option('sforce_instance_url');
}

ShareFile::authenticate();