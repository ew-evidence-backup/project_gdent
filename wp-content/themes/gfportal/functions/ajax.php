<?php

function register_ajax() {
	if(!is_page('login')) {
		wp_enqueue_script('theme-ajax-js', get_template_directory_uri() . '/assets/js/ajax.js', array(), '0.0.0.0', true);
	}

	$user_id = get_current_user_id();
	wp_localize_script('theme-ajax-js', 'wp_ajax',
		array(
		    'url'				=> admin_url('admin-ajax.php'),
		    'nonce'     		=> wp_create_nonce('nonce'),
			'sforce_contact_id'	=> get_user_meta($user_id, 'sforce_contact_id', true),
			'sforce_account_id'	=> get_user_meta($user_id, 'sforce_account_id', true),
			'sfile_id'			=> get_user_meta($user_id, 'sfile_id', true),
	    )
	);
}

function load_page_ajax_func() {
	// check nonce
	if(!wp_verify_nonce($_POST['nonce'], 'nonce'))
		die(json_encode(array('error' => 'unauthorized')));

	$queries = array();

	// SalesForce
	if(isset($_POST['serialized']['SalesForce'])) {
		foreach($_POST['serialized']['SalesForce'] as $i => $field) {
			$queries['SalesForce'][$field['object']][$field['filters']][$i] = $field['field'];
		}
	}

	// ShareFile
	if(isset($_POST['serialized']['ShareFile'])) {
		foreach($_POST['serialized']['ShareFile'] as $i => $pair) {
			$queries['ShareFile'][$pair['folder']][$i] = $pair['filename'];
		}
	}

	// response output
	header('Content-Type: application/json');
	echo json_encode(load_page_data($queries), true);

	exit;
}

function save_page_ajax_func() {
	// check nonce
	if(!wp_verify_nonce($_POST['nonce'], 'nonce'))
		die(json_encode(array('error' => 'unauthorized')));

	$queries = array();
	if(isset($_POST['serialized'])) {
		foreach($_POST['serialized']['SalesForce'] as $i => $attr) {
			if(isset($attr['url']))
				$queries[$attr['url']][$attr['field']] = $attr['value'];
		}
	}

	// response output
	header('Content-Type: application/json');
	echo json_encode(save_page_data($queries), true);

	exit;
}

function edit_user_meta_ajax_func() {
	// check nonce
	if(!wp_verify_nonce($_POST['nonce'], 'nonce'))
		die(json_encode(array('error' => 'unauthorized')));


	// response output
	header('Content-Type: application/json');
	echo json_encode(edit_user_meta($_POST), true);

	exit;
}

function init_record_ajax_func() {
	// check nonce
	if(!wp_verify_nonce($_POST['nonce'], 'nonce'))
		die(json_encode(array('error' => 'unauthorized')));

	$queries = array();

	// SalesForce
	if(isset($_POST['serialized']['SalesForce'])) {
		foreach($_POST['serialized']['SalesForce'] as $i => $field) {
			$queries['SalesForce'][$field['object']][$field['filters']][$i] = $field['field'];
		}
	}

	// response output
	header('Content-Type: application/json');
	echo json_encode(init_record($queries), true);

	exit;
}

function add_object_ajax_func() {
	// check nonce
	if(!wp_verify_nonce($_POST['nonce'], 'nonce'))
		die(json_encode(array('error' => 'unauthorized')));

	// response output
	header('Content-Type: application/json');
	echo json_encode(add_object($_POST['serialized']), true);

	exit;
}

function unauthenticated_ajax() {
	echo json_encode(array('error' => 'unauthorized'));
}

add_action('wp_enqueue_scripts', 'register_ajax', 20);

add_action('wp_ajax_load-page', 'load_page_ajax_func');
add_action('wp_ajax_save-page', 'save_page_ajax_func');
add_action('wp_ajax_edit-user-meta', 'edit_user_meta_ajax_func');
add_action('wp_ajax_init-record', 'init_record_ajax_func');
add_action('wp_ajax_add-object', 'add_object_ajax_func');

add_action('wp_ajax_nopriv_page-load', 'unauthenticated_ajax');
add_action('wp_ajax_nopriv_page-save', 'unauthenticated_ajax');
add_action('wp_ajax_nopriv_edit-user-meta', 'unauthenticated_ajax');
add_action('wp_ajax_nopriv_init-record', 'unauthenticated_ajax');
add_action('wp_ajax_nopriv_add-object', 'unauthenticated_ajax');