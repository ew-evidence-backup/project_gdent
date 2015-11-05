<?php

function add_object($args) {
	$args_array = json_decode(stripcslashes($args), true);
	//SalesForce::add_object($args_array['object'], $args_array['fields']);

	return stripcslashes($args);
}