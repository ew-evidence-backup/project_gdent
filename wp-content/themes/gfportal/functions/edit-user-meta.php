<?php

function edit_user_meta($args) {
	$user_id = get_current_user_id();
    update_user_meta($user_id,'sforce_contact_id', $args['serialized']['data-sforce-contact-id']);
    update_user_meta($user_id,'sforce_account_id', $args['serialized']['data-sforce-account-id']);
    update_user_meta($user_id,'sfile_id', $args['serialized']['data-sfile-id']);

    return true;
}