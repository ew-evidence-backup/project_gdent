<?php

function debug_home_menu() {
	register_nav_menu('debug_home', 'Temporary Home Menu');
}

add_action('after_setup_theme', 'debug_home_menu');