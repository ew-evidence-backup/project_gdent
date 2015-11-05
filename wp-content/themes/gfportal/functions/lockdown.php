<?php

// show admin bar only for admins
if(!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}

// lock all pages unless logged in
if(!is_admin()) {
    if(get_page_by_path('login') != NULL) {
        function authentication_lock() {
            global $post;

            // if use is not logged in and it's not the login page
            if(!is_user_logged_in() && $post->post_name != 'login') {
                wp_redirect(get_site_url() . '/login/');

                die();
            }
        }

        add_action('wp', 'authentication_lock');
    }
}

function no_page_error($page) {
    echo "<div class='error'><p>No '" . $page . "' page found. Please <a href='" . get_site_url() . "/wp-admin/post-new.php?post_type=page'>create a page</a> called '" . $page . "' and assign the '" . $page . "' page template to it. </p></div>";
}

function wpsites_admin_notice() {
    if(get_page_by_path('login') == NULL) {
        no_page_error('login');
    }

    if(get_page_by_path('account') == NULL) {
        no_page_error('account');
    }
}

add_action('admin_notices', 'wpsites_admin_notice');

// redirect logged out users away from the default wp login areas
function old_wp_login_redirect() {
    if(!is_user_logged_in() && in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) && get_page_by_path('login') != NULL) {
        wp_redirect(get_site_url() . '/login/', $status);

        die();
    }
}

add_action('init', 'old_wp_login_redirect');

// redirect subscribers away from the dashboard area
function subscriber_dashboard_redirect() {
    if(current_user_can('subscriber')) {
        wp_redirect(get_site_url() . '/account/', $status);

        die();
    }
}

add_action('admin_head', 'subscriber_dashboard_redirect');